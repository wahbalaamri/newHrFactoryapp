<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use App\Http\SurveysPrepration;
use App\Models\Departments;
use App\Models\PartnerFocalPoint;
use App\Models\Partners;
use App\Models\Partnerships;
use App\Models\Plans;
use App\Models\Services;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // get all clients
        // $clients = Clients::all();
        // //update client status based on delete_at
        // foreach ($clients as $client) {
        //     if ($client->deleted_at != null) {
        //         $client->Status = false;
        //     } else {
        //         $client->Status = true;
        //     }
        // }
        //get all undeleted clients
        if (Auth()->user()->user_type == 'partner') {
            //find the partner focal point
            $partner_id = PartnerFocalPoint::where('Email', Auth()->user()->email)->first()->partner_id;
            //get countries id in partnerships
            $Countries_id = Partnerships::where('partner_id', $partner_id)->pluck('country_id')->toArray();
            //get all clients in the countries
            $clients = Clients::whereIn('country', $Countries_id)->get();
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientsRequest $request)
    {
        //
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
        try {
            return $surveysPrepration->SurveyResults($Client_id, $Service_type, $survey_id, $vtype, $vtype_id, true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e);
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
}