<?php

namespace App\Http\Controllers;

use App\Models\Surveys;
use App\Http\Requests\StoreSurveysRequest;
use App\Http\Requests\UpdateSurveysRequest;
use App\Models\ClientSubscriptions;
use App\Models\Employees;
use App\Models\Functions;
use App\Models\PrioritiesAnswers;
use App\Models\Raters;
use App\Models\Respondents;
use App\Models\SurveyAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SurveysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSurveysRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Surveys $surveys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surveys $surveys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveysRequest $request, Surveys $surveys)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surveys $surveys)
    {
        //
    }
    //takeSurvey function the id is the respondent id
    public function takeSurvey($id)
    {
        //from the id get the survey id
        $respondent = Respondents::find($id);
        Log::info("message");
        //if not found return 404
        if (!$respondent) {
            return abort(404);
        }
        //get the survey
        $survey = Surveys::find($respondent->survey_id);
        //if not found return 404
        if (!$survey) {
            return abort(404);
        }
        //get the plan of this survey
        $plan = $survey->plans;
        //get client subscription
        $subscription = ClientSubscriptions::select('is_active')->where('client_id', $survey->client_id)->where('plan_id', $plan->id)->first()->is_active;
        if (!$subscription) {
            return abort(404);
        }
        //check if the respondent has already taken the survey
        $surveyAnswers = SurveyAnswers::where('answered_by', $id)->get();
        if ($surveyAnswers->count() > 0) {
            return abort(404);
        }
        if (!$survey->survey_stat) {
            return abort(404);
        }
        if ($plan->service_->service_type == 3) {
            //get servcie id
            $service_id = $plan->service_->id;
            //create empty array
            $open_end_q = array();
            $functions = Functions::where('service_id', $service_id)->get();
            $data = [
                'functions' => $functions,
                'type' => $respondent->survey_type,
                'can_ansewer_to_priorities' => false,
                'SurveyId' => $survey->id,
                'email_id' => $id,
                'plan_id' => $plan->id,
                'open_end_q' => $open_end_q
            ];
            return view('surveys.employeeEngagment')->with($data);
        }
        if ($plan->service_->service_type == 4) {
            //setLocale ar
            // App()->setLocale('ar');
            $functions = Functions::where('service_id', $plan->service_->id)->get();
            $user = Employees::where('id', $respondent->employee_id)->first();
            $user_type = $user->employee_type;
            $can_ansewer_to_priorities = false;
            foreach ($functions as $function) {
                if ($user->department->is_hr) {
                    if ($function->Respondent == 1 || $function->Respondent == 4 || $function->Respondent == 6 || $function->Respondent == 7 || $function->Respondent == 8) {
                        $can_ansewer_to_priorities = true;
                    }
                    $user_type = 2;
                } elseif ($user->employee_type == 1) {
                    if ($function->Respondent == 3 || $function->Respondent == 5 || $function->Respondent == 6 || $function->Respondent == 7 || $function->Respondent == 8) {
                        $can_ansewer_to_priorities = true;
                    }
                    $user_type = 1;
                } else {
                    if ($function->Respondent == 2 || $function->Respondent == 4 || $function->Respondent == 5 || $function->Respondent == 7 || $function->Respondent == 8) {
                        $can_ansewer_to_priorities = true;
                    }
                    $user_type = 3;
                }
            }
            $data = [
                'functions' => $functions,
                'user_type' => $user_type,
                'can_ansewer_to_priorities' => $can_ansewer_to_priorities,
                'SurveyId' => $survey->id,
                'email_id' => $id,
                'plan_id' => $plan->id,
                'open_end_q' => []
            ];
            return view('surveys.hrdiagnosis')->with($data);
        }
    }
    // SaveAnswers function the id is the respondent id
    public function SaveAnswers(Request $request)
    {
        $reply = ($request->reply);
        $QuestionAnswers = $reply[0]['answers'];
        $SurveyId = $reply[0]['survey_id'];
        $PlanId = $reply[0]['PlanID'];
        $EmailId = $reply[0]['EmailId'];
        $priorities = $reply[0]['priorities'];
        $oe_ans = $reply[0]['oe_ans'];
        $gender = $reply[0]['gender'];
        $agegroup = $reply[0]['agegroup'];
        $type = $reply[0]['type'];
        $ansAva = SurveyAnswers::where([['answered_by', $EmailId], ['survey_id', $SurveyId]])->get();
        if ($SurveyId == null) {
            // $Count = freeSurveyAnswers::select('SurveyId')->distinct('SurveyId')->count('SurveyId');
            // foreach ($QuestionAnswers as $key => $value) {
            //     $free_survey_answer = new freeSurveyAnswers();
            //     $free_survey_answer->SurveyId = "FreeSurvey-" . ($Count + 1);
            //     $free_survey_answer->PlanId = $PlanId;
            //     $free_survey_answer->QuestionId = $value['question_id'];
            //     $free_survey_answer->Answer_value = $value['answer'];
            //     $free_survey_answer->save();
            // }
            // $data = [
            //     'msg' => 'success',
            //     'message' => 'Your answers has been saved successfully',
            //     'url' => route('survey-answers.freeSurveyResult', "FreeSurvey-" . ($Count + 1)),
            // ];
            // return response()->json($data);
        } elseif (count($ansAva) == 0) {
            foreach ($QuestionAnswers as $key => $value) {
                $survey_answer = new SurveyAnswers();
                $survey_answer->survey_id = $SurveyId;
                $survey_answer->answered_by = $EmailId;
                $survey_answer->question_id = $value['question_id'];
                $survey_answer->answer_value = $value['answer'];
                $survey_answer->save();
            }
            if ($priorities != null) {
                foreach ($priorities as $key => $value) {
                    $Priority_answer = new PrioritiesAnswers();
                    $Priority_answer->survey_id = $SurveyId;
                    $Priority_answer->answered_by = $EmailId;
                    $Priority_answer->question_id = $value['function'];
                    $Priority_answer->answer_value = $value['priority'];
                    $Priority_answer->save();
                }
            }
            if ($oe_ans != null) {
                // foreach ($oe_ans as $key => $value) {
                //     $oe_answer = new OpenEndedQuestionsAnswers();
                //     $oe_answer->survey_id = $SurveyId;
                //     $oe_answer->respondent_id = $EmailId;
                //     $oe_answer->open_ended_question_id = $value['questionId'];
                //     //check $value['answer'] length if grater than 55 get sub-string of it
                //     if (strlen($value['answer']) > 55) {
                //         $oe_answer->answer = substr($value['answer'], 0, 55);
                //     }
                //     $oe_answer->answer = $value['answer'];
                //     if ($value['answer'] != null || $value['answer'] != '') {
                //         $oe_answer->save();
                //     }
                // }
            }
            //update emails with agegroup and gender
            //find respondent
            $respondent = Respondents::select('employee_id')->where('id', $EmailId)->first();
            $email = Employees::find($respondent->employee_id);
            $email->age_generation = $agegroup;
            $email->gender = $gender;
            $email->save();
        }
        $data = [
            'msg' => 'success',
            'message' => 'Your answers has been saved successfully',
            'url' => '',
        ];
        return response()->json($data);
    }
    function save360Answer(Request $request)
    {
        $reply = ($request->reply);
        $QuestionAnswers = $reply[0]['answers'];
        $SurveyId = $reply[0]['survey_id'];
        $PlanId = $reply[0]['PlanID'];
        $EmailId = $reply[0]['EmailId'];
        $priorities = $reply[0]['priorities'];
        $oe_ans = $reply[0]['oe_ans'];
        $ansAva = SurveyAnswers::where([['answered_by', $EmailId], ['survey_id', $SurveyId]])->get();
        if ($SurveyId == null) {
            // $Count = freeSurveyAnswers::select('SurveyId')->distinct('SurveyId')->count('SurveyId');
            // foreach ($QuestionAnswers as $key => $value) {
            //     $free_survey_answer = new freeSurveyAnswers();
            //     $free_survey_answer->SurveyId = "FreeSurvey-" . ($Count + 1);
            //     $free_survey_answer->PlanId = $PlanId;
            //     $free_survey_answer->QuestionId = $value['question_id'];
            //     $free_survey_answer->Answer_value = $value['answer'];
            //     $free_survey_answer->save();
            // }
            // $data = [
            //     'msg' => 'success',
            //     'message' => 'Your answers has been saved successfully',
            //     'url' => route('survey-answers.freeSurveyResult', "FreeSurvey-" . ($Count + 1)),
            // ];
            // return response()->json($data);
        } elseif (count($ansAva) == 0) {
            foreach ($QuestionAnswers as $key => $value) {
                $survey_answer = new SurveyAnswers();
                $survey_answer->survey_id = $SurveyId;
                $survey_answer->candidate = Raters::find($EmailId)->candidate_id;
                $survey_answer->answered_by = $EmailId;
                $survey_answer->question_id = $value['question_id'];
                $survey_answer->answer_value = $value['answer'];
                $survey_answer->save();
            }
            if ($priorities != null) {
                foreach ($priorities as $key => $value) {
                    $Priority_answer = new PrioritiesAnswers();
                    $Priority_answer->survey_id = $SurveyId;
                    $Priority_answer->answered_by = $EmailId;
                    $Priority_answer->question_id = $value['function'];
                    $Priority_answer->answer_value = $value['priority'];
                    $Priority_answer->save();
                }
            }
            // if ($oe_ans != null) {
            //     foreach ($oe_ans as $key => $value) {
            //         $oe_answer = new OpenEndedQuestionsAnswers();
            //         $oe_answer->survey_id = $SurveyId;
            //         $oe_answer->respondent_id = $EmailId;
            //         $oe_answer->open_ended_question_id = $value['questionId'];
            //         //check $value['answer'] length if grater than 55 get sub-string of it
            //         if (strlen($value['answer']) > 55) {
            //             $oe_answer->answer = substr($value['answer'], 0, 55);
            //         }
            //         $oe_answer->answer = $value['answer'];
            //         if ($value['answer'] != null || $value['answer'] != '') {
            //             $oe_answer->save();
            //         }
            //     }
            // }
        }
        $data = [
            'msg' => 'success',
            'message' => 'Your answers has been saved successfully',
            'url' => '',
        ];
        return response()->json($data);
    }
}
