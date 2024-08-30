<?php

namespace App\Http\Controllers;

use App\Http\SurveysPrepration;
use App\Jobs\SendDemoSurveyJob;
use App\Jobs\SetEmployeeDataFromOldTools;
use App\Jobs\SetupUsersIdInUsersOldSections;
use App\Models\Content;
use App\Models\Countries;
use App\Models\DefaultMB;
use App\Models\FunctionPractices;
use App\Models\Functions;
use App\Models\PracticeQuestions;
use App\Models\RequestDemo;
use App\Models\Services;
use App\Models\User;
use App\Models\UserPlans;
use App\Models\UserSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contents = Content::where('page', '=', 'home')->get();
        $data = [
            'contents' => $contents,
            'services' => Services::where('public_availability', true)->get()
        ];
        return view('home.index')->with($data);
    }
    public function aboutus()
    {
        //aboutus
        $contents = Content::where('page', '=', 'aboutus')->get();
        $data = [
            'contents' => $contents
        ];
        return view('home.about-us')->with($data);
    }

    function CheckUser()
    {
        if (Auth()->check()); {
            //redirect to some route
            if (Auth()->user()->isAdmin == 1 || Auth()->user()->user_type == 'partner')
                return redirect()->route('admin.dashboard');
            else
                return redirect()->route('client.dashboard');
        }
    }
    function dashboard()
    {
        if (Auth()->user()->user_type == 'client') {
            return redirect()->route('client.dashboard');
        }
        $contents = Content::where('page', '=', 'login')->get();
        $data = [
            'contents' => $contents
        ];
        return view('dashboard.admin.index')->with($data);
    }
    function client()
    {
        if (Auth()->user()->user_type != 'client') {
            return redirect()->route('admin.dashboard');
        }
        //get active userplans subscriptions
        $active_sub = UserPlans::where([['IsActive', true], ['UserId', Auth()->user()->id]])->get();
        //get notactive userplans subscriptions
        $notactive_sub = UserPlans::where([['IsActive', false], ['UserId', Auth()->user()->id]])->get();
        $data = [
            'active_sub' => $active_sub,
            'notactive_sub' => $notactive_sub
        ];
        return view('dashboard.client.index')->with($data);
    }
    function setupUsrPlans()
    {
        //call SetupUsersIdInUsersOldSections
        $job = new SetupUsersIdInUsersOldSections();
        dispatch($job);
        return "Done";
    }
    function viewTool($id)
    {

        //get a service
        $service = Services::find($id);
        $data = [
            'service' => $service,
            'countries' => Countries::all()->groupBy('IsArabCountry')
        ];
        return view('home.view-tool')->with($data);
    }
    //manage function
    public function manage(SurveysPrepration $surveysPrepration)
    {
        //get all surveys
        return $surveysPrepration->manage(Auth()->user()->client_id);
    }
    //manualbuilderDemo function
    public function manualbuilderDemo($country, $plan)
    {
        //get default country
        $default_country = Countries::where('name', 'Oman')->first();
        //get all sections
        $sections = DefaultMB::where('country_id', $country)->where('plan_id', $plan)->whereNull('paren_id')->where('language', app()->isLocale('en') ? 'en' : 'ar')->orderBy('ordering')->get();
        $sections = count($sections) > 0 ? $sections : DefaultMB::where('country_id', $default_country->id)->where('plan_id', $plan)->whereNull('paren_id')->where('language', app()->isLocale('en') ? 'en' : 'ar')->orderBy('ordering')->get();
        $data = [
            'sections' => $sections,
            'country' => $country,
            'plan' => $plan
        ];
        return view('home.manualbuilder-demo')->with($data);
    }
    //SubmitDemoRequest function
    public function SubmitDemoRequest(Request $request)
    {
        $link = null;
        $request_demo = new RequestDemo();
        $request_demo->service_type = $request->service_type;
        $request_demo->company_name = $request->company_name;
        $request_demo->phone = $request->phone;
        $request_demo->email = $request->email;
        $request_demo->remarks = $request->remarks;
        $request_demo->save();
        //sendDemoSurveyJob
        if ($request->service_type == 3) {
            $link = route('tools.EmployeeEngagmentDemo', $request_demo->id);
        } elseif ($request->service_type == 4) {
            $link = route('tools.hrDiagnosisDemo', $request_demo->id);
        } elseif ($request->service_type == 5) {
            $link = route('tools.leader360ReviewDemo', $request_demo->id);
        }
        $job = new SendDemoSurveyJob($link, $request->email);
        dispatch($job);
        //return json
        return response()->json(['message' => __('Request submitted successfully'), 'email_prompt' => __('Email of Demo Survey Has Been Sent To Submitted Email, Please Check Your Email'), 'status' => 200]);
    }
    //EmployeeEngagmentDemo function
    public function EmployeeEngagmentDemo($id)
    {
        //check if id is exist in request demo
        $request_demo = RequestDemo::where('id',$id)->where('service_type',3)->first();
        if ($request_demo) {
            //get servcie id
            //create empty array
            $open_end_q = array();
            $functions = Functions::where('service_id', function ($quere) {
                $quere->select('id')
                    ->from('services')
                    ->where('service_type', 3);
            })->get();
            $data = [
                'functions' => $functions,
                'type' => 1,
                'can_ansewer_to_priorities' => false,
                'SurveyId' => 1,
                'email_id' => $id,
                'plan_id' => 1,
                'open_end_q' => $open_end_q
            ];
            return view('home.EmployeeEngagmentDemo')->with($data);
        } else {
            abort(404);
        }
    }
    //HRDiagnosisDemo function
    public function HRDiagnosisDemo($id)
    {
        //check if id is exist in request demo
        $request_demo = RequestDemo::where('id',$id)->where('service_type',4)->first();
        if ($request_demo) {
            //get servcie id
            //create empty array
            $open_end_q = array();
            $functions = Functions::where('service_id', function ($quere) {
                $quere->select('id')
                    ->from('services')
                    ->where('service_type', 4);
            })->get();
            $data = [
                'functions' => $functions,
                'user_type' => 1,
                'can_ansewer_to_priorities' => true,
                'SurveyId' => 1,
                'email_id' => $id,
                'plan_id' => 2,
                'open_end_q' => []
            ];
            return view('home.HRDiagnosisDemo')->with($data);
        } else {
            abort(404);
        }
    }
    //leader360ReviewDemo function
    public function leader360ReviewDemo($id)
    {
        //check if id is exist in request demo
        $request_demo = RequestDemo::where('id',$id)->where('service_type',5)->first();
        if ($request_demo) {
            //get servcie id
            //create empty array
            $open_end_q = array();
            $functions = Functions::where('service_id', function ($quere) {
                $quere->select('id')
                    ->from('services')
                    ->where('service_type', 5);
            })->get();
            $data = [
                'functions' => $functions,
                'user_type' => 1,
                'can_ansewer_to_priorities' => false,
                'SurveyId' => 1,
                'email_id' => $id,
                'plan_id' => 1,
                'open_end_q' => $open_end_q,
                'candidate_name' => "DEMO USER"
            ];
            return view('home.leader360ReviewDemo')->with($data);
        } else {
            abort(404);
        }
    }
    //EmployeeEngagmentResultDemo function
    public function EmployeeEngagmentResultDemo($id)
    {
        $overall_per_fun = [];
        $driver_functions_practice = [];
        $heat_map = [];

        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = [];
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = [];
        $heat_map_indecators = [];
        //check if id is exist in request demo
        $request_demo = RequestDemo::find($id);
        if (!$request_demo) {
            abort(404);
        }
        $func_iteration = 0;
        foreach (Functions::where('service_id', function ($quere) {
            $quere->select('id')
                ->from('services')
                ->where('service_type', 3);
        })->where('IsDriver', true)->get() as $function) {
            $func_iteration++;
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            $totalCount = 0;
            $oddCount = 0;
            $evenCount = 0;
            foreach ($function->practices as $practice) {
                $totalCount++;
                if ($totalCount % 2 == 0) {
                    $evenCount++;
                } else {
                    $oddCount++;
                }
                if ($func_iteration == 1) {
                    if ($totalCount == 3) {
                        $sum_answer_value_Favorable = 100; //green
                        $Favorable_count = 20; //green
                        $sum_answer_value_UnFavorable = 3; //yellow
                        $UnFavorable_count = 3; //yellow
                    } elseif ($totalCount % 2 == 0) {
                        if ($evenCount < 4) {
                            $sum_answer_value_Favorable = 50; //yellow
                            $Favorable_count = 15; //yellow
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        } else {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red
                        }
                    } else {
                        if ($oddCount > 3) {
                            $sum_answer_value_Favorable = 50; //yellow
                            $Favorable_count = 15; //yellow
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        } else {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red
                        }
                    }
                }
                if ($func_iteration == 2) {
                    if ($totalCount <= 3) {
                        $sum_answer_value_Favorable = 100; //green
                        $Favorable_count = 20; //green
                        $sum_answer_value_UnFavorable = 3; //yellow
                        $UnFavorable_count = 3; //yellow
                    } elseif ($totalCount % 2 == 0) {
                        if ($evenCount < 4) {
                            $sum_answer_value_Favorable = 50; //yellow
                            $Favorable_count = 15; //yellow
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        } else {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red
                            $sum_answer_value_Favorable = 100; //green
                            $Favorable_count = 20; //green
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        }
                    } else {
                        if ($oddCount > 3) {

                            $sum_answer_value_Favorable = 100; //green
                            $Favorable_count = 20; //green
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        } else {
                            $sum_answer_value_Favorable = 50; //yellow
                            $Favorable_count = 15; //yellow
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        }
                    }
                }
                if ($func_iteration == 3) {
                    if ($totalCount <= 3) {
                        $sum_answer_value_Favorable = 40; //red
                        $Favorable_count = 10; //red
                        $sum_answer_value_UnFavorable = 45; //red
                        $UnFavorable_count = 15; //red
                    } elseif ($totalCount % 2 == 0) {
                        if ($evenCount < 4) {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red

                        } else {
                            $sum_answer_value_Favorable = 50; //yellow
                            $Favorable_count = 15; //yellow
                            $sum_answer_value_UnFavorable = 3; //yellow
                            $UnFavorable_count = 3; //yellow
                        }
                    } else {
                        if ($oddCount > 3) {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red


                        } else {
                            $sum_answer_value_Favorable = 40; //red
                            $Favorable_count = 10; //red
                            $sum_answer_value_UnFavorable = 45; //red
                            $UnFavorable_count = 15; //red
                        }
                    }
                }
                // $UnFavorable_count = 6;

                $sum_answer_value_Nuetral = 9;
                $Nuetral_count = 3;
                // $Nuetral_count = 3;

                $practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
                    'Nuetral_score' => $Nuetral_count == 0 ? 0 : number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => $Favorable_count == 0 ? 0 : number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => $UnFavorable_count == 0 ? 0 : number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral answers
                    'Nuetral_count' => $Nuetral_count,
                ];
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($driver_functions_practice, $practice_results);
            }
            //setup function_results
            $function_results = [
                'function' => $function->id,
                'function_title' => $function->translated_title,
                'Nuetral_score' => $function_Nuetral_count == 0 ? 0 : number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $function_Favorable_count == 0 ? 0 : number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'UnFavorable_score' => $function_UnFavorable_count == 0 ? 0 : number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
            ];
            array_push($overall_per_fun, $function_results);
        }
        foreach (Functions::where('service_id',  function ($quere) {
            $quere->select('id')
                ->from('services')
                ->where('service_type', 3);
        })->get() as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->practices as $practice) {
                //get sum of answer value from survey answers

                $sum_answer_value_Favorable = 6;
                $Favorable_count = 2;

                $sum_answer_value_UnFavorable = 1;
                $UnFavorable_count = 1;

                $sum_answer_value_Nuetral = 4;
                $Nuetral_count = 2;

                $Outcome_practice_results = [
                    'function' => $function->id,
                    'practice_id' => $practice->id,
                    'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
                    'Nuetral_score' => $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'Favorable_score' => $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    'UnFavorable_score' => $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                    //get count of Favorable answers
                    'Favorable_count' => $Favorable_count,
                    //get count of UnFavorable answers
                    'UnFavorable_count' => $UnFavorable_count,
                    //get count of Nuetral nswers
                    'Nuetral_count' => $Nuetral_count,
                ];
                if ($practice->questions->where('IsENPS', true)->first()) {
                    $Favorable = $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($Favorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $UnFavorable = $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($UnFavorable_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2);
                    $ENPS_data_array = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
                        'Nuetral_score' => $Favorable_count + $Nuetral_count + $UnFavorable_count == 0 ? 0 : number_format(($Nuetral_count / ($Favorable_count + $Nuetral_count + $UnFavorable_count)) * 100, 2),
                        //get count of Favorable answers
                        'Favorable_count' => $Favorable_count,
                        //get count of UnFavorable answers
                        'UnFavorable_count' => $UnFavorable_count,
                        //get count of Nuetral answers
                        'Nuetral_count' => $Nuetral_count,
                        'Favorable_score' => $Favorable,
                        'UnFavorable_score' => $UnFavorable,
                        'ENPS_index' => $Favorable - $UnFavorable,
                    ];
                }
                $function_Nuetral_sum += $sum_answer_value_Nuetral;
                $function_Favorable_sum += $sum_answer_value_Favorable;
                $function_UnFavorable_sum += $sum_answer_value_UnFavorable;
                $function_Nuetral_count += $Nuetral_count;
                $function_Favorable_count += $Favorable_count;
                $function_UnFavorable_count += $UnFavorable_count;
                array_push($outcome_functions_practice, $Outcome_practice_results);
            }
            $out_come_favorable = $function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count == 0 ? 0 : number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            $out_come_unfavorable = $function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count == 0 ? 0 : number_format(($function_UnFavorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            //setup function_results
            $outcome_function_results = [
                'function' => $function->id,
                'function_title' => $function->translated_title,
                'Nuetral_score' => $function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count == 0 ? 0 : number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $out_come_favorable,
                'UnFavorable_score' => $out_come_unfavorable,
                //get count of Favorable answers
                'Favorable_count' => $function_Favorable_count,
                //get count of UnFavorable answers
                'UnFavorable_count' => $function_UnFavorable_count,
                //get count of Nuetral answers
                'Nuetral_count' => $function_Nuetral_count,
                'outcome_index' => $out_come_favorable,
            ];
            array_push($outcome_function_results_1, $outcome_function_results);
        }
        //sort $driver_functions_practice asc
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        //
        //========================================
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 75,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 35,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 50,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 65,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $ENPS_Pushed = true;
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 11,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);

        $heat_map_item = [
            'entity_name' => "Administration & Finance Department",
            'entity_id' => 1,
            'indecators' => $heat_map_indecators,
        ];
        $heat_map_indecators=[];
        array_push($heat_map, $heat_map_item);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 61,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 78,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 71,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 89,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $ENPS_Pushed = true;
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 0,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);

        $heat_map_item = [
            'entity_name' => "Human Resources Department",
            'entity_id' => 1,
            'indecators' => $heat_map_indecators,
        ];
        array_push($heat_map, $heat_map_item);
        $heat_map_indecators=[];
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 58,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 74,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 76,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => 54,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);
        $ENPS_Pushed = true;
        $outcome_function_results_HM = [
            'function_title' => "title",
            'score' => -50,
        ];
        array_push($heat_map_indecators, $outcome_function_results_HM);

        $heat_map_item = [
            'entity_name' => "IT Department",
            'entity_id' => 1,
            'indecators' => $heat_map_indecators,
        ];
        array_push($heat_map, $heat_map_item);
        //=======================================
        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array,
            'entity' => $request_demo->company_name,
            'type' => 'sec',
            'type_id' => [],
            'id' => [],
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'cal_type' => 'countD',
        ];
        return view('home.EmployeeEngagmentDemoResult')->with($data);
    }
    public function SetupNameRev()
    {
        $service_type = 6; //HR Diagnosis =4, 360 reviwe =5 , 360 reviwe name =6
        ini_set('max_execution_time', 420);
        //find service of type 6
        $service = Services::where('service_type',  $service_type)->first();
        //read functions from https://hrtools.hrfactoryapp.com/GetFunctions
        $urlf = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/function/getf" : "https://hrtools.hrfactoryapp.com/GetFunctions";
        $jsonf = file_get_contents($urlf);
        $dataf = json_decode($jsonf, true);
        //loop through functions
        foreach ($dataf as $function) {
            //check if function exists
            $function1 = Functions::where('title', $function['FunctionTitle'])->whereIn('service_id', function ($query) {
                $query->select('id')
                    ->from('services')
                    ->where('service_type', 5);
            })->get();
            if ($function1->count() <= 0) {
                //create function
                Log::info($function);
                $f = new Functions();
                $f->title = $function['FunctionTitle'];
                $f->title_ar = $function['FunctionTitleAr'];
                $f->respondent = $function['Respondent'];
                $f->service_id = $service->id;
                $f->status = 1;
                $f->IsDefault =  $function['IsDefault'] == 1 ? true : false;
                $f->IsDriver =  array_key_exists('IsDriver', $function) ? ($function['IsDriver'] == 1 ? true : false) : false;
                $f->save();
                //read practices from https://hrtools.hrfactoryapp.com/GetPractices/
                $urlp = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/practice/getp/" . $function['id'] : "https://hrtools.hrfactoryapp.com/GetPractices/" . $function['id'];
                $jsonp = file_get_contents($urlp);
                $datap = json_decode($jsonp, true);
                //loop through practices
                foreach ($datap as $practice) {
                    if (!FunctionPractices::where('title', $practice['PracticeTitle'])->exists()) {
                        //create practice
                        $p = new FunctionPractices();
                        $p->title = $practice['PracticeTitle'];
                        $p->title_ar = $practice['PracticeTitleAr'];
                        $p->status = true;
                        $p->function_id = $f->id;
                        $p->save();
                        //read surveys from https://hrtools.hrfactoryapp.com/GetQuestion/
                        $urls = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/question/getq/" . $practice['id'] : "https://hrtools.hrfactoryapp.com/GetQuestion/" . $practice['id'];
                        $jsons = file_get_contents($urls);
                        $datas = json_decode($jsons, true);
                        //loop through surveys
                        foreach ($datas as $question) {
                            //create survey
                            if (PracticeQuestions::where('question', $question['Question'])->doesntExist()) {
                                $s = new PracticeQuestions();
                                $s->question = $question['Question'];
                                $s->question_ar = $question['QuestionAr'];
                                $s->respondent = $question['Respondent'];
                                $s->IsENPS = array_key_exists('IsENPS', $question) ? $question['IsENPS'] : false;
                                $s->practice_id = $p->id;
                                $s->status = true;
                                $s->save();
                            }
                        }
                    }
                }
            } else {
                Log::info($function);
                //read practices from https://hrtools.hrfactoryapp.com/GetPractices/
                $urlp = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/practice/getp/" . $function['id'] : "https://hrtools.hrfactoryapp.com/GetPractices/" . $function['id'];
                $jsonp = file_get_contents($urlp);
                $datap = json_decode($jsonp, true);
                //loop through practices
                foreach ($datap as $practice) {
                    if (!FunctionPractices::where('title', $practice['PracticeTitle'])->where('function_id', $function1->first()->id)->exists()) {
                        //create practice
                        $p = new FunctionPractices();
                        $p->title = $practice['PracticeTitle'];
                        $p->title_ar = $practice['PracticeTitleAr'];
                        $p->status = true;
                        $p->function_id = $function1->first()->id;
                        $p->save();
                        //read surveys from https://hrtools.hrfactoryapp.com/GetQuestion/
                        $urls = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/question/getq/" . $practice['id'] : "https://hrtools.hrfactoryapp.com/GetQuestion/" . $practice['id'];
                        $jsons = file_get_contents($urls);
                        $datas = json_decode($jsons, true);
                        //loop through surveys
                        foreach ($datas as $question) {
                            //create survey
                            if (PracticeQuestions::where('question', $question['Question'])->where('practice_id', $p->id)->doesntExist()) {
                                $s = new PracticeQuestions();
                                $s->question = $question['Question'];
                                $s->question_ar = $question['QuestionAr'];
                                $s->respondent = $question['Respondent'];
                                $s->IsENPS = array_key_exists('IsENPS', $question) ? $question['IsENPS'] : false;
                                $s->practice_id = $p->id;
                                $s->status = true;
                                $s->save();
                            }
                        }
                    }
                }
            }
        }
    }
    public function GetDataFromOldTools($client_id,$tool,$use_dep){
        //new job SetEmployeeDataFromOldTools
        $job = new SetEmployeeDataFromOldTools($client_id,$use_dep,$tool);
        dispatch($job);
    }
}
