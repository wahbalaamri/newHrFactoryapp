<?php

namespace App\Http\Controllers;

use App\Enums\NumberOfEmployees;
use App\Http\Facades\Landing;
use App\Models\Clients;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use App\Http\SurveysPrepration;
use App\Jobs\Calculate3hResultsJob;
use App\Jobs\SendAccountInfoJob;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\Industry;
use App\Models\PartnerFocalPoint;
use App\Models\Partners;
use App\Models\Partnerships;
use App\Models\Plans;
use App\Models\Sectors;
use App\Models\Services;
use App\Models\Surveys;
use App\Models\TermsConditions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        if (Auth()->user()->user_type == 'partner') {
            //find the partner focal point
            $partner_id = PartnerFocalPoint::where('Email', Auth()->user()->email)->first()->partner_id;
            //get countries id in partnerships
            $Countries_id = Partnerships::where('partner_id', $partner_id)->pluck('country_id')->toArray();
            //get partner
            $partner = Partners::find($partner_id);
            if ($partner->is_main) {
                $clients = Clients::whereIn('country', $Countries_id)->get();
            } else {
                $clients = Clients::where('partner_id', $partner_id)->whereIn('country', $Countries_id)->get();
            }
            //get all clients in the countries

        } else {
            $clients = Clients::all();
        }
        $data = [
            'clients' => $clients,
        ];
        return view('dashboard.client.allClients')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //get current country
        $current_country = Landing::getCurrentCountry();
        //get Default country
        $default_country = Landing::getDefaultCountry();
        //get terms & conditions
        $terms = TermsConditions::where('for', "Singup")->where('country_id', $current_country)->first();
        $terms = $terms ? $terms : TermsConditions::where('for', "Singup")->where('country_id', $default_country)->first();
        $Employee = new NumberOfEmployees();
        $data = [
            'industries' => Industry::all(),
            'countries' => Countries::all(),
            'numberOfEmployees' => $Employee->getList(),
            'terms' => $terms
        ];
        return view('dashboard.client.edit')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        //validate company name english
        // $request->validate([
        //     'company_name_en' => 'required|string|max:255',
        //     'company_name_ar' => 'required|string|max:255',
        //     'phone' => 'required|string|max:255',
        //     'company_country' => 'required|integer',
        //     'company_sector' => 'required|integer',
        //     'company_size' => 'required|integer',
        //     'focal_name' => 'required|string|max:255',
        //     'focal_email' => 'required|string|max:255',
        //     'focal_phone' => 'required|string|max:255',
        //     'password' => 'required|string|min:8',
        // ]);
        //check if the user is already registered
        $user = User::where('email', $request->focal_email)->get();
        if (count($user) > 0) {
            //return back with error message
            return back()->with('fail', 'You are already registered');
        } else {
            //check if logo_path has file
            if ($request->hasFile('logo_path')) {
                $file = $request->file('logo_path');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/companies/logos/', $filename);
            } else {
                $filename = null;
            }
            $request_hasPass = $request->has('password');
            $notify_client = true;
            if (!$request_hasPass)
                $notify_client = $request->notify_client_cred == "on" ? true : false;
            $password = $request_hasPass ? $request->password : Landing::generateRandomPassword();
            $country_id = Landing::getCurrentCountry();
            //find the country from countries table
            $country = Countries::where('id', operator: $country_id)->first();
            // get partner id from partnerships table
            $partnership = Partnerships::where('country_id', $country->id)->first();
            //create new Client
            $newClient = new Clients();
            $newClient->name = $request->company_name_en;
            $newClient->name_ar = $request->company_name_ar;
            $newClient->country = $request->company_country;
            $newClient->industry = $request->company_sector;
            $newClient->client_size = $request->company_size;
            $newClient->phone = $request->phone;
            $newClient->logo_path = $filename;
            $newClient->webiste = $request->website;
            $newClient->partner_id = Auth::user()->partner_id;
            $newClient->added_by = Auth::user()->id;
            $newClient->updated_by = Auth::user()->id;
            $newClient->save();
            //retrieve industry
            $industry = Industry::find($request->company_sector);
            //create new sector
            $newSector = new Sectors();
            $newSector->client_id = $newClient->id;
            $newSector->name_en = $industry->name;
            $newSector->name_ar = $industry->name_ar;
            $newSector->save();
            //add new comapny
            //create new company
            $company = new Companies();
            $company->client_id = $newClient->id;
            $company->sector_id = $newSector->id;
            $company->name_en = $request->company_name_en;
            $company->name_ar = $request->company_name_ar != null ? $request->company_name_ar : $request->company_name_en;
            $company->save();
            //new Employee
            $newEmployee = new Employees();
            $newEmployee->name = $request->focal_name;
            $newEmployee->client_id = $newClient->id;
            $newEmployee->email = $request->focal_email;
            $newEmployee->mobile = $request->focal_phone;
            $newEmployee->sector_id = $newSector->id;
            $newEmployee->comp_id = $company->id;
            $newEmployee->emp_id = null;
            $newEmployee->employee_type = 2;
            $newEmployee->isCandidate = false;
            $newEmployee->isBoard = false;
            $newEmployee->acting_for = null;
            $newEmployee->is_hr_manager = false;
            $newEmployee->added_by = 0;
            $newEmployee->save();
            //create new user
            $newUser = new User();
            $newUser->name = $request->focal_name;
            $newUser->email = $request->focal_email;
            $newUser->password = Hash::make($password);
            $newUser->client_id = $newClient->id;
            $newUser->sector_id = $newSector->id;
            $newUser->emp_id = $newEmployee->id;
            $newUser->is_main = true;
            //user_type
            $newUser->user_type = "client";
            //is_active
            $newUser->is_active = true;
            $newUser->save();
            //create new focal point
            $newFocal = new FocalPoints();
            $newFocal->name = $request->focal_name;
            $newFocal->email = $request->focal_email;
            $newFocal->phone = $request->focal_phone;
            $newFocal->client_id = $newClient->id;
            $newFocal->is_active = true;
            $newFocal->save();
            //
            //redirect to login page with success message
            // (new SendSurvey($emails, $data))->delay(now()->addSeconds(2));
            if (!$request_hasPass && $notify_client) {
                $job = (new SendAccountInfoJob($request->focal_email, $password))->delay(now()->addSeconds(2));
                dispatch($job);
                //redirect to route name('clients.index')

                return redirect()->route('clients.index')->with('success', 'You are registered successfully');
            }
            return redirect('/login')->with('success', 'You are registered successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientsRequest $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients)
    {
        //
    }

    //subscriptions function
    public function manage(SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->manage($id);
    }
    //viewSubscriptions function
    public function viewSubscriptions(SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->viewSubscriptions($id, true);
    }
    //saveSubscription function
    public function saveSubscription(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->saveSubscription($request, $id, true);
    }
    //ShowEmployeeEngagment function
    public function ShowSurveys(SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->ShowSurveys($id, $type);
    }
    //createSurvey function
    public function createSurvey(SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->editSurvey($id, $type);
    }
    //storeSurvey function
    public function storeSurvey(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id = null)
    {
        if ($survey_id != null) {
            $survey = Surveys::find($survey_id);
            return $surveysPrepration->CreateOrUpdateSurvey($request, $id, $type, true, $survey);
        }
        return $surveysPrepration->CreateOrUpdateSurvey($request, $id, $type, true);
    }
    //changeSurveyStatus function
    public function changeSurveyStat(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->changeSurveyStat($request, $id, $type, $survey_id, true);
    }
    //surveyDetails function
    public function surveyDetails(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->surveyDetails($id, $type, $survey_id, true);
    }
    //deleteSurvey function
    public function deleteSurvey(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->deleteSurvey($id, $type, $survey_id, true);
    }
    //editSurvey function
    public function editSurvey(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->editSurvey($id, $type, $survey_id);
    }
    //Respondents function
    public function Respondents(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->Respondents($request, $id, $type, $survey_id);
    }
    //saveSCD function
    public function saveSCD(Request $request, SurveysPrepration $surveysPrepration)
    {
        try {
            return $surveysPrepration->saveSCD($request, true);
        } catch (\Exception $e) {
            //     return response()->json(['message' => 'Error'], 500);
        }
    }
    //ShowCreateEmail function
    public function ShowCreateEmail(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->ShowCreateEmail($id, $type, $survey_id, true);
    }
    //getClientLogo function
    public function getClientLogo(SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getClientLogo($id, true);
    }
    //storeSurveyEmail function
    public function storeSurveyEmail(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id, $emailid = null)
    {
        return $surveysPrepration->storeSurveyEmail($request, $id, $type, $survey_id, $emailid, true);
    }
    //orgChart function
    public function orgChart(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->orgChart($request, $id, true);
    }
    //DeleteLeveL function
    public function DeleteLeveL(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->DeleteLeveL($request, $id, true);
    }
    //DownloadOrgChartTemp function
    public function DownloadOrgChartTemp(Request $request, SurveysPrepration $surveysPrepration, $id, $sector, $company, $deps)
    {
        return $surveysPrepration->DownloadOrgChartTemp($request, $id, $sector, $company, $deps, true);
    }
    //DownloadEmployeeTemp function
    public function DownloadEmployeeTemp(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->DownloadEmployeeTemp($request, $id, true);
    }
    //deleteDep function
    public function deleteDep(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->deleteDep($request, $id, true);
    }
    //Employees function
    public function Employees(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->Employees($request, $id, true);
    }
    //companies function
    public function companies(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->companies($request, $id, true);
    }
    //departments function
    public function departments(Request $request, SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->departments($request, $id, $type, true);
    }
    //sections function
    public function sections(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->sections($request, $id, true);
    }
    //storeEmployee function
    public function storeEmployee(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->storeEmployee($request, true);
    }
    //deleteEmployee function
    public function deleteEmployee(Request $request, SurveysPrepration $surveysPrepration, $id, $cid)
    {
        return $surveysPrepration->deleteEmployee($request, $id, $cid, true);
    }
    //getEmployee function
    public function getEmployee(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getEmployee($request, $id, true);
    }
    //getDepartment function
    public function getDepartment(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getDepartment($request, $id, true);
    }
    //saveSurveyRespondents function
    public function saveSurveyRespondents(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->saveSurveyRespondents($request, true);
    }
    //saveIndividualRespondents function
    public function saveIndividualRespondents(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->saveIndividualRespondents($request, true);
    }
    //sendSurvey function
    public function showSendSurvey(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id, $send_type = null, $emp_id = null)
    {
        return $surveysPrepration->showSendSurvey($request, $id, $type, $survey_id, $send_type, $emp_id, true);
    }
    //sendSurvey function
    public function sendSurvey(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id, $send_type = null)
    {
        return $surveysPrepration->sendSurvey($request, $id, $type, $survey_id, $send_type, true);
    }
    //SurveyResults function
    public function SurveyResults(SurveysPrepration $surveysPrepration, $Client_id, $Service_type, $survey_id, $vtype, $vtype_id = null)
    {
        ini_set('max_execution_time', 300);
        try {
            return $surveysPrepration->SurveyResults($Client_id, $Service_type, $survey_id, $vtype, $vtype_id, true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //saveSurveyCandidates function
    public function saveSurveyCandidates(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->saveSurveyCandidates($request, true);
    }
    //getRaters function
    public function getRaters(Request $request, SurveysPrepration $surveysPrepration, $id, $survey, $type = null)
    {
        return $surveysPrepration->getRaters($request, $id, $survey, $type, true);
    }
    //SaveRaters function
    public function SaveRaters(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->SaveRaters($request, true);
    }
    //candidates function
    public function candidates(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->candidates($request, true);
    }
    //schedule360 function
    public function schedule360(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->schedule360($request, true);
    }
    //ShowCustomizedSurveys function
    public function ShowCustomizedSurveys(SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->ShowCustomizedSurveys($id, $type, true);
    }
    //createCustomizedSurvey function
    public function createCustomizedSurvey(SurveysPrepration $surveysPrepration, $id, $type, $survey = null)
    {
        return $surveysPrepration->editCustomizedSurvey($id, $type, $survey, true);
    }
    //storeCustomizedSurvey function
    public function storeCustomizedSurvey(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id = null)
    {
        return $surveysPrepration->storeCustomizedSurvey($request, $id, $type, $survey_id, true);
    }
    //surveyCustomizedDetails function
    public function surveyCustomizedDetails(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->surveyCustomizedDetails($id, $type, $survey_id, true);
    }
    //CustomizedsurveyQuestions function
    public function CustomizedsurveyQuestions(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->CustomizedsurveyQuestions($id, $type, $survey_id, true);
    }
    //GetOtherSurveysQuestions function
    public function GetOtherSurveysQuestions(Request $request, SurveysPrepration $surveysPrepration, $s_type, $fid = null, $pid = null)
    {
        return $surveysPrepration->GetOtherSurveysQuestions($request, $s_type, $fid, $pid, true);
    }
    //GetFunctions function
    public function GetFunctions(SurveysPrepration $surveysPrepration, $servic_type)
    {
        return $surveysPrepration->GetFunctions($servic_type, true);
    }
    //GetPractices function
    public function GetPractices(SurveysPrepration $surveysPrepration, $fid)
    {
        return $surveysPrepration->GetPractices($fid, true);
    }
    //SubmitCustomizedQuestions function
    public function SubmitCustomizedQuestions(Request $request, SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->SubmitCustomizedQuestions($request, $id, $type, true);
    }
    //CreateCustomizedsurveyQuestions function
    public function CreateCustomizedsurveyQuestions(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->CreateCustomizedsurveyQuestions($id, $type, $survey_id, true);
    }
    //CustomizedsurveyRespondents function
    public function CustomizedsurveyRespondents(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->CustomizedsurveyRespondents($request, $id, $type, $survey_id, true);
    }
    //changeLogo function
    public function changeLogo(Request $request)
    {
        //get current user client_id
        if (Auth()->user()->user_type == 'partner') {
            $partner_id = Auth()->user()->partner_id;
            //get partner
            $object = Partners::find($partner_id);
        } else {
            $client_id = Auth()->user()->client_id;
            //get client
            $object = Clients::find($client_id);
        }
        //check if request has file
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = $object->name . '-' . time() . '.' . $extension;
            $file->move('uploads/companies/logos/', $filename);
            //update object logo
            $object->logo_path = $filename;
            $object->save();
            //return json
            return response()->json(['message' => 'Logo Updated Successfully', 'status' => true], 200);
        } else {
            //return json
            return response()->json(['message' => 'No file found', 'status' => false], 400);
        }
    }
    //saveOrgInfo function
    public function saveOrgInfo(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->saveOrgInfo($request, $id, true);
    }
    //uploadOrgChartExcel function
    public function uploadOrgChartExcel(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->uploadOrgChartExcel($request, $id, true);
    }
    //uploadEmployeeExcel function
    public function uploadEmployeeExcel(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->uploadEmployeeExcel($request, $id, true);
    }
    //AssignAsUser function
    public function AssignAsUser(Request $request, SurveysPrepration $surveysPrepration, $id, $cid)
    {
        return $surveysPrepration->AssignAsUser($request, $id, $cid, true);
    }
    //DownloadSurveyResults function
    public function DownloadSurveyResults(SurveysPrepration $surveysPrepration, $survey_id, $service_type, $type, $type_id = null)
    {
        ini_set('max_execution_time', 300);
        return $surveysPrepration->DownloadSurveyResults($survey_id, $service_type, $type, $type_id, true);
    }
    //DownloadPriorities function
    public function DownloadPriorities(SurveysPrepration $surveysPrepration, $survey_id, $type, $type_id = null)
    {
        ini_set('max_execution_time', 300);
        return $surveysPrepration->DownloadPriorities($survey_id,  $type, $type_id);
    }
    //StartSurveyResults function
    public function StartSurveyResults($Client_id, $Service_type, $survey_id, $vtype, $vtype_id = null)
    {
        //job to calculate 3h results
        $job = (new Calculate3hResultsJob($Client_id, $Service_type, $survey_id, $vtype, $vtype_id = null, true));
        dispatch($job);
        return redirect()->route('clients.surveyDetails', [$Client_id, $Service_type, $survey_id]);
    }
    //ShowSurveyResults function
    public function ShowSurveyResults()
    {
        //get session data
        $data = session()->get('data');
    }
    public function ResendAccount(Request $request, $email)
    {
        //find user
        $user = User::where('email', $email)->first();
        //random password
        $password = Landing::generateRandomPassword();
        //if user exists
        if ($user) {
            //update password
            $user->password = bcrypt($password);

            $job = (new SendAccountInfoJob($email, $password))->delay(now()->addSeconds(2));
            dispatch($job);
        }
    }
}
