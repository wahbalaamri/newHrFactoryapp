<?php

namespace App\Http\Controllers;

use App\Http\SurveysPrepration;
use Illuminate\Http\Request;
use App\Models\{Clients, Employees, Functions, PracticeQuestions, FunctionPractices, Raters, Respondents, Services, SurveyAnswers, Surveys};
use Illuminate\Support\Facades\Log;

class Leader360ReviewController extends Controller
{
    //
    private $survey;
    private $service_type = 5;
    public function __construct()
    {
        $this->survey = new SurveysPrepration();
    }
    function index()
    {
        return $this->survey->index($this->service_type);
    }
    //createFunction
    function createFunction(Request $request)
    {
        return $this->survey->createFunction($request, $this->service_type);
    }
    //storeFunction
    function storeFunction(Request $request)
    {
        return $this->survey->storeFunction($request, $this->service_type);
    }
    //showPractices function
    function showPractices($id)
    {
        return $this->survey->showPractices($id, $this->service_type);
    }
    //createPractice function
    function createPractice($id)
    {
        return $this->survey->createPractice($id, $this->service_type);
    }
    //storePractice function
    function storePractice(Request $request, $id)
    {
        return $this->survey->storePractice($request, $id, $this->service_type);
    }
    //showQuestions function
    function showQuestions($id)
    {
        return $this->survey->showQuestions($id, $this->service_type);
    }
    //createQuestion function
    function createQuestion($id)
    {
        return $this->survey->createQuestion($id, $this->service_type);
    }
    //storeQuestion function
    function storeQuestion(Request $request, $id)
    {
        return $this->survey->storeQuestion($request, $id, $this->service_type);
    }
    //editQuestion function
    function editQuestion($id)
    {
        return $this->survey->editQuestion($id, $this->service_type);
    }
    //updateQuestion function
    function updateQuestion(Request $request, $id)
    {
        return $this->survey->updateQuestion($request, $id, $this->service_type);
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id)
    {
        return $this->survey->deleteQuestion($request, $id, $this->service_type);
    }
    //editPractice function
    function editPractice($id)
    {
        return $this->survey->editPractice($id, $this->service_type);
    }
    //updatePractice function
    function updatePractice(Request $request, $id)
    {
        return $this->survey->updatePractice($request, $id, $this->service_type);
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id)
    {
        return $this->survey->destroyPractice($request, $id, $this->service_type);
    }
    //editFunction function
    function editFunction($id)
    {
        return $this->survey->editFunction($id, $this->service_type);
    }
    //updateFunction function
    function updateFunction(Request $request, $id)
    {
        return $this->survey->updateFunction($request, $id, $this->service_type);
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id)
    {
        return $this->survey->destroyFunction($request, $id, $this->service_type);
    }
    function survey(Request $request, $id)
    {
        return $this->survey->survey360($request, $id, $this->service_type);
    }
    //candidateResult function
    function candidateResult(Request $request, $id, $survey)
    {
        $practice = [];
        $practices = [];
        $functions_lbl = [];
        $Self_Functions = [];
        $Others_Functions = [];
        $_all_fun = [];
        //overall indecator
        $overall = 0;
        $employee=Employees::find($id);
        //counter
        $counter = 0;
        $raters = Raters::select(['id', 'rater_id', 'type','candidate_id','survey_id'])
        ->where('candidate_id', $id)
        ->where('survey_id', $survey)
        ->get();
        $email = Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$raters->pluck('id')->toArray())->pluck('id')->toArray();
        //get survey answers of candidate
        $answers = SurveyAnswers::select(['question_id', 'survey_id', 'candidate', 'answer_value', 'answered_by'])
            ->where([['survey_id', $survey]])
            ->whereIn('answered_by',$email)
            ->get();
        //substract 1 from answers->answer_value
        $answers->transform(function ($item, $key) {
            $item->answer_value = $item->answer_value - 1;
            return $item;
        });
        //get count of DM raters
        $DM = $raters->where('type', 'DM')->count();
        //get count of DR raters
        $DR = $raters->where('type', 'DR')->count();
        //get count of Peer raters
        $Peer = $raters->where('type', 'Peer')->count();

        //get count of Self raters
        $Self = $raters->where('type', 'Self')->count();
        //get count of Others raters
        $Others = $raters->where('type', 'o')->count();
        //get rater_id of DM
        $DM_raters = $raters->where('type', 'DM')->pluck('id')->all();
        $DM_Raters_r=Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$DM_raters)->pluck('id')->toArray();
        //get rater_id of DR
        $DR_raters = $raters->where('type', 'DR')->pluck('id')->all();
        $DR_raters_r=Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$DR_raters)->pluck('id')->toArray();
        //get rater_id of Peer
        $Peer_raters = $raters->where('type', 'Peer')->pluck('id')->all();
        $Peer_raters_r=Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$Peer_raters)->pluck('id')->toArray();
        //get rater_id of Self
        $Self_raters = $raters->where('type', 'Self')->pluck('id')->all();
        $Self_raters_r=Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$Self_raters)->pluck('id')->toArray();
        //get rater_id of Others
        $Others_raters = $raters->where('type', 'o')->pluck('id')->all();
        $Others_raters_r=Respondents::where('candidate_id',$id)->where('survey_id',$survey)->whereIn('rater_id',$Others_raters)->pluck('id')->toArray();
        //get count of unique answers from DM
        $DM_answers = $answers->whereIn('answered_by', $DM_Raters_r)->groupBy('answered_by')->count();
        //get count of unique answers from DR
        $DR_answers = $answers->whereIn('answered_by', $DR_raters_r)->groupBy('answered_by')->count();
        //get count of unique answers from Peer
        $Peer_answers = $answers->whereIn('answered_by', $Peer_raters_r)->groupBy('answered_by')->count();
        //get count of unique answers from Self
        $Self_answers = $answers->whereIn('answered_by', $Self_raters_r)->groupBy('answered_by')->count();
        //get count of unique answers from Others
        $Others_answers = $answers->whereIn('answered_by', $Others_raters_r)->groupBy('answered_by')->count();
        //get count of unique answers from all raters
        $All_answers = $answers->groupBy('answered_by')->count();
        //get functions of the survey
        $service_id = Surveys::find($survey)->plans->service;
        $functions = Functions::where('service_id', $service_id)->get();
        foreach ($functions as $function) {
            $the_self_overall = 0;
            $the_others_overall = 0;
            $all_overall = 0;

            $prac_counter = 0;

            //get practices id
            foreach ($function->practices as $practice) {
                //get questions of the practice
                $prac_counter++;
                $oth_count = 0;
                $questions = PracticeQuestions::where('practice_id', $practice->id)
                    ->pluck('id')
                    ->all();
                $test = $answers->whereIn('answered_by', $DM_raters)->whereIn('question_id', $questions);
                //get answers of the practice
                $DM_practice = number_format(($answers->whereIn('question_id', $questions)->whereIn('answered_by', $DM_Raters_r)->avg('answer_value') / 3) * 100);
                $DR_practice = number_format(($answers->whereIn('question_id', $questions)->whereIn('answered_by', $DR_raters_r)->avg('answer_value') / 3) * 100);
                $Peer_practice = number_format(($answers->whereIn('question_id', $questions)->whereIn('answered_by', $Peer_raters_r)->avg('answer_value') / 3) * 100);
                $Self_practice = number_format(($answers->whereIn('question_id', $questions)->whereIn('answered_by', $Self_raters_r)->avg('answer_value') / 3) * 100);
                $Others_practice = $Others > 0 ? number_format(($answers->whereIn('question_id', $questions)->whereIn('answered_by', $Others_raters_r)->avg('answer_value') / 3) * 100) : 0;
                $results = 0;
                $count = 0;
                $oth = 0;
                if ($DM > 0) {
                    $results += $DM_practice;
                    $oth += $DM_practice;
                    $count++;
                    $oth_count++;
                }
                if ($DR > 0) {
                    $results += $DR_practice;
                    $oth += $DR_practice;
                    $count++;
                    $oth_count++;
                }
                if ($Peer > 0) {
                    $results += $Peer_practice;
                    $oth += $Peer_practice;
                    $count++;
                    $oth_count++;
                }
                if ($Self > 0) {
                    $results += $Self_practice;
                    $count++;
                }
                if ($Others > 0) {
                    $results += $Others_practice;
                    $oth += $Others_practice;
                    $count++;
                    $oth_count++;
                }
                $all_practice = $count > 0 ? $results / $count : 0;
                $all_overall += $all_practice;
                $overall += $all_practice;
                $the_Self_Result = $Self_practice;
                $the_others_Result = $oth_count > 0 ? $oth / $oth_count : 0;
                $the_self_overall += $the_Self_Result;
                $the_others_overall += $the_others_Result;
                $counter++;
                $practice = [
                    'id' => $practice->id,
                    'name' => $practice->translated_title,
                    'function' => $function->id,
                    'DM' => $DM_practice,
                    'DR' => $DR_practice,
                    'Peer' => $Peer_practice,
                    'Self' => $Self_practice,
                    'Others' => $Others_practice,
                    'All' => $all_practice,
                ];
                array_push($practices, $practice);
            }
            $the_self_overall = $the_self_overall / $prac_counter;
            $the_others_overall = $the_others_overall / $prac_counter;
            array_push($functions_lbl, $function->FunctionTitle);
            array_push($Self_Functions, $the_self_overall);
            array_push($Others_Functions, $the_others_overall);
            $_one_fun = [
                'id' => $function->id,
                'score' => $all_overall / $prac_counter,
            ];
            array_push($_all_fun, $_one_fun);
        }
        //get five highest practices
        $highest_practices = collect($practices)->sortByDesc('All')->take(5);
        //get five lowest practices
        $lowest_practices = collect($practices)->sortBy('All')->take(5);
        //get overall indecator
        $overall = $overall / $counter;
        $data = [
            'email' => $employee,
            'survey' => Surveys::select(['id', 'survey_title', 'created_at'])
                ->where('id', $survey)
                ->first(),
            'client' => Clients::select(['id', 'name'])
                ->where('id', $employee->client_id)
                ->first(),
            'DM_answers' => $DM_answers,
            'DR_answers' => $DR_answers,
            'Peer_answers' => $Peer_answers,
            'Self_answers' => $Self_answers,
            'Others_answers' => $Others_answers,
            'DM' => $DM,
            'DR' => $DR,
            'Peer' => $Peer,
            'Self' => $Self,
            'Others' => $Others,
            'practices' => $practices,
            'highest_practices' => $highest_practices,
            'lowest_practices' => $lowest_practices,
            'functions' => $functions,
            'overall' => $overall,
            'functions_lbl' => $functions_lbl,
            'Self_Functions' => $Self_Functions,
            'Others_Functions' => $Others_Functions,
            'all_fun' => collect($_all_fun),
        ];
        return view('dashboard.client.360result')->with($data);
    }
}
