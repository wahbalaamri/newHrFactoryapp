<?php

namespace App\Http\services;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Functions;
use App\Models\PracticeQuestions;
use App\Models\PrioritiesAnswers;
use App\Models\Sectors;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateHrDiagnosisResults
{
    private $scaleSize = 5;

    public function __construct() {}


    public function calculate($client_id, $survey, $entity = null, $type)
    {
        $client = Clients::find($client_id);
        if ($type == "all") {
            return $this->calculateSingleClient($client, $survey,);
        }
        if ($type == "sec") {
            $sector = Sectors::where('id', $entity)->where('client_id', $client_id)->first();
            return $this->calculateSectorResults($sector, $survey);
        }
        if ($type == "comp") {
            $company = Companies::where('id', $entity)->where('client_id', $client_id)->first();
            return $this->startCalculateForCompany($survey, $company);
        }
    }
    public function getCompanyRespondents($survey, $company)
    {
        //get hr team
        $hr_teams_respondents = DB::table('respondents')
            ->join('employees', 'respondents.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.dep_id', '=', 'departments.id')
            ->where('departments.company_id', $company->id)
            ->where('departments.is_hr', true)
            ->where('respondents.survey_id', $survey)
            ->where('respondents.deleted_at', null)
            ->where('employees.deleted_at', null)
            ->where('departments.deleted_at', null)
            ->pluck('respondents.id')->toArray();
        //get Leaders
        $leaders_respondents = DB::table('respondents')
            ->join('employees', 'respondents.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.dep_id', '=', 'departments.id')
            ->where('departments.company_id', $company->id)
            ->where('departments.is_hr', false)
            ->where('respondents.survey_id', $survey)
            ->where('employees.employee_type', 1)
            ->where('respondents.deleted_at', null)
            ->where('employees.deleted_at', null)
            ->where('departments.deleted_at', null)
            ->pluck('respondents.id')->toArray();
        //get normal employees
        $normal_respondents = DB::table('respondents')
            ->join('employees', 'respondents.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.dep_id', '=', 'departments.id')
            ->where('departments.company_id', $company->id)
            ->where('departments.is_hr', false)
            ->where('respondents.survey_id', $survey)
            ->where('employees.employee_type', 2)
            ->where('respondents.deleted_at', null)
            ->where('employees.deleted_at', null)
            ->where('departments.deleted_at', null)
            ->pluck('respondents.id')->toArray();

        return [$hr_teams_respondents, $leaders_respondents, $normal_respondents];
    }
    public function getDepartmentRespondents($survey, $department)
    {
        $hr_teams_respondents = [];
        $leaders_respondents = [];
        $normal_respondents = [];
        if ($department->is_hr) {
            //get hr team
            $hr_teams_respondents = DB::table('respondents')
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->join('departments', 'employees.dep_id', '=', 'departments.id')
                ->where('departments.company_id', $department->company_id)
                ->where('departments.is_hr', true)
                ->where('respondents.survey_id', $survey)
                ->pluck('respondents.id')->toArray();
            //get Leaders
            $leaders_respondents = DB::table('respondents')
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->where('employees.dep_id', $department->id)
                ->where('respondents.survey_id', $survey)
                ->where('employees.employee_type', 1)
                ->pluck('respondents.id')->toArray();
            //get normal employees
            $normal_respondents = DB::table('respondents')
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->where('employees.dep_id', $department->id)
                ->where('respondents.survey_id', $survey)
                ->where('employees.employee_type', 0)
                ->pluck('respondents.id')->toArray();

            return [$hr_teams_respondents, $leaders_respondents, $normal_respondents];
        } else {
            return [$hr_teams_respondents, $leaders_respondents, $normal_respondents];
        }
    }
    public function startCalculateForCompany($survey, $company)
    {
        //get respondents
        [$hr_teams_respondents, $leaders_respondents, $normal_respondents] = $this->getCompanyRespondents($survey, $company);
        $surveyEmails_ids = array_merge($hr_teams_respondents, $leaders_respondents, $normal_respondents);
        $SurveyResult = SurveyAnswers::where('survey_id', '=', $survey)->whereIn('answered_by', $surveyEmails_ids)->select(['answer_value', 'question_id', 'answered_by'])->get();
        if ($this->scaleSize == 5) {
            $SurveyResult = $SurveyResult->map(function ($item, $key) {
                $item['answer_value'] = $item['answer_value'] - 1;
                return $item;
            });
        }
        if ($SurveyResult->count() == 0 || count($surveyEmails_ids) == 0) {
            return 0;
        }
        return $this->startCalculate(
            $company,
            $survey,
            $hr_teams_respondents,
            $leaders_respondents,
            $normal_respondents,
            $SurveyResult,
            count($surveyEmails_ids)
        );
    }
    public function startCalculate($company, $survey, $hr_teams_respondents, $leaders_respondents, $normal_respondents, $SurveyResult, $respondents_count)
    {

        $Answers_by_leaders = $SurveyResult->whereIn('answered_by', $leaders_respondents)->unique('answered_by')->count();
        $Answers_by_hr = $SurveyResult->whereIn('answered_by', $hr_teams_respondents)->unique('answered_by')->count();
        $Answers_by_emp = $SurveyResult->whereIn('answered_by', $normal_respondents)->unique('answered_by')->count();
        $HR_score = $SurveyResult->whereIn('answered_by', $hr_teams_respondents)->avg('answer_value');
        $Emp_score = $SurveyResult->whereIn('answered_by', $normal_respondents)->avg('answer_value');
        $Leaders_score = $SurveyResult->whereIn('answered_by', $leaders_respondents)->avg('answer_value');
        $_all_score = ($HR_score + $Emp_score + $Leaders_score) / 3;
        // if ($Answers_by_leaders == 0 || $Answers_by_hr == 0)
        //     return 1;
        $planID = Surveys::where('id', $survey)->first()->plans->service;
        $functions = Functions::where('service_id', $planID)->select(['id', 'title_ar', 'title'])->get();
        $prioritiesRes = PrioritiesAnswers::where('survey_id', $survey)->select(['answer_value', 'question_id', 'answered_by'])->get();
        // $avgxx = $SurveyResult->avg('answer_value');
        $overallResult = number_format(($_all_score / $this->scaleSize) * 100);

        $priorities = array();
        $priority = array();
        $performences_ = array();
        $performence_ = array();
        //leader
        $leader_performences_ = array();
        $leader_performence_ = array();
        //hr
        $hr_performences_ = array();
        $hr_performence_ = array();
        //emp
        $emp_performences_ = array();
        $emp_performence_ = array();

        $overall_Practices = array();
        $leaders_practices = array();
        $hr_practices = array();
        $emp_practices = array();
        $function_Lables = array();
        //function total=0
        $function_total = 0;
        foreach ($functions as $function) {
            $function_Lables[] = ['title' => $function->translated_title, 'id' => $function->id];
            $total = 0;
            $leaders_total = 0;
            $hr_total = 0;
            $emp_total = 0;
            $totalz = 0;
            $leaders_totalz = 0;
            $hr_totalz = 0;
            $emp_totalz = 0;
            $counter = 0;
            $HRcounter = 0;
            $Empcounter = 0;
            $overall_Practice = array();
            $leaders_practice = array();
            $hr_practice = array();
            $emp_practice = array();
            //leasders flag
            $leaders_had_answers = false;
            $Leader_function_flag = false;
            //hr flag
            $hr_had_answers = false;
            $hr_function_flag = false;
            //emp flag
            $emp_had_answers = false;
            $emp_function_flag = false;
            $function_w = 0;
            $p_count_ = 0;

            foreach ($function->practices as $functionPractice) {
                //genral data
                $practiceName = $functionPractice->translated_title;
                //leaders Caluclations
                $allans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $leaders_respondents)->avg('answer_value');
                // leaders answers avg
                $leaders_ans_avg = $allans;
                //check if $allans has a value or just empty
                // if (!$leaders_had_answers)
                $leaders_had_answers = isset($allans) ? true : false;
                $answers = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $leaders_respondents);/* ->sum('answer_value') ;*/
                $leaders_Pract_w =  ($allans) / $this->scaleSize;
                $leaders_total += $leaders_Pract_w;
                // $leaders_Pract_wz =  ($allans) / $this->scaleSize;
                // $leaders_totalz += $leaders_Pract_wz;
                if ($answers) {
                    $counter++;
                }
                $leaders_practice = [
                    'name' => $practiceName,
                    'id' => $functionPractice->id,
                    'weight' => round($leaders_Pract_w, 2),
                    // 'weightz' => round($leaders_Pract_wz, 2),
                    'function_id' => $function->id,
                ];
                array_push($leaders_practices, $leaders_practice);
                // Hr Caluclations
                $allans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)
                    ->whereIn('answered_by', $hr_teams_respondents)->avg('answer_value');
                // HrTeam answers avg
                $hr_ans_avg = $allans;
                // if (!$hr_had_answers)
                $hr_had_answers = isset($allans) ? true : false;
                $hr_practice_ans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)
                    ->whereIn('answered_by', $hr_teams_respondents);
                $hr_practice_weight =  round((($allans) / $this->scaleSize), 2);
                // $hr_practice_weightz =  round((($allans) / $this->scaleSize), 2);
                $hr_total += $hr_practice_weight;
                // $hr_totalz += $hr_practice_weightz;
                if ($hr_practice_ans) {
                    $HRcounter++;
                }
                $hr_practice = [
                    'name' => $practiceName,
                    'id' => $functionPractice->id,
                    'weight' => $hr_practice_weight,
                    // 'weightz' => $hr_practice_weightz,
                    'function_id' => $function->id,
                ];
                array_push($hr_practices, $hr_practice);
                // Emp Caluclations
                $allans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $normal_respondents)->avg('answer_value');
                // employees answers avg
                $emp_ans_avg = $allans;
                //check if employee group answer avg has value and assign flag
                // if (!$emp_had_answers)
                $emp_had_answers = isset($allans) ? true : false;
                $emp_practice_ans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $normal_respondents);
                // $emp_practice_ans_count = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $normal_respondents)->count();
                $emp_practice_weight =  round((($allans) / $this->scaleSize), 2);
                // $emp_practice_weightz =  round((($allans) / $this->scaleSize), 2);
                if ($emp_practice_ans) {
                    $Empcounter++;
                }
                $emp_total += $emp_practice_weight;
                // $emp_totalz += $emp_practice_weightz;
                $emp_practice = [
                    'name' => $practiceName,
                    'id' => $functionPractice->id,
                    'weight' => $emp_practice_weight,
                    'function_id' => $function->id,
                ];
                array_push($emp_practices, $emp_practice);
                // over all calculations
                $the_three_avg = 0;
                $avg_factor = 0;
                if ($leaders_had_answers) {
                    $the_three_avg += $leaders_ans_avg;
                    $avg_factor++;
                    if (!$Leader_function_flag) {
                        $p_count_++;
                        $Leader_function_flag = true;
                    }
                }
                if ($hr_had_answers) {
                    $the_three_avg += $hr_ans_avg;
                    $avg_factor++;
                    if (!$hr_function_flag) {
                        $p_count_++;
                        $hr_function_flag = true;
                    }
                }
                if ($emp_had_answers) {
                    $the_three_avg += $emp_ans_avg;
                    $avg_factor++;
                    if (!$emp_function_flag) {
                        $p_count_++;
                        $emp_function_flag = true;
                    }
                }

                $OverAllAv = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)
                    ->avg('answer_value');
                // if ($avg_factor <= 0)
                //     return ['data_size' => 0];
                // $OverAllAv = ($the_three_avg) / $avg_factor;
                $practiceWeight =  round((($OverAllAv) / $this->scaleSize), 2);
                $totalz += $practiceWeight;
                // $function_w += $practiceWeight;
                // $p_count_++;
                // $practiceWeightz =  round((($OverAllAv) / $this->scaleSize), 2);
                $overall_Practice = [
                    'name' => $practiceName,
                    'id' => $functionPractice->id,
                    'weight' => $practiceWeight,
                    'function_id' => $function->id,
                ];
                array_push($overall_Practices, $overall_Practice);
                // total calculations
                $total += $leaders_Pract_w + $hr_practice_weight + $emp_practice_weight;
                // $totalz += $leaders_Pract_wz + $hr_practice_weightz + $emp_practice_weightz;
            }
            //get bluck of question id through function
            $practicesIDs = $function->practices->pluck('id')->toArray();
            $questionsIDs = PracticeQuestions::whereIn('practice_id', $practicesIDs)->pluck('id')->toArray();
            //get sum of this function overalll
            //get avg of this function
            $avg = $SurveyResult->whereIn('question_id', $questionsIDs)->avg('answer_value');
            $avg = round(($avg / $this->scaleSize), 2);
            //get sum of this function leaders
            //get avg of this function leaders
            $avgl = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $leaders_respondents)->avg('answer_value');
            $avgl = round(($avgl / $this->scaleSize), 2);
            //get sum of this function hr
            //get avg of this function hr
            $avgh = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $hr_teams_respondents)->avg('answer_value');
            $avgh = round(($avgh / $this->scaleSize), 2);
            //get sum of this function employees
            //get avg of this function employees
            $avge = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $normal_respondents)->avg('answer_value');
            $avge = round(($avge / $this->scaleSize), 2);
            //overall performence


            //leader performence
            $leader_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format($avgl * 100),
                "applicable" => $Leader_function_flag
            ];
            array_push($leader_performences_, $leader_performence_);

            //hr performence

            $hr_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format($avgh * 100),
                "applicable" => $hr_function_flag
            ];
            array_push($hr_performences_, $hr_performence_);

            //emp performence
            $emp_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format($avge * 100),
                "applicable" => $emp_function_flag
            ];
            array_push($emp_performences_, $emp_performence_);
            //prioritiesRes
            $total_answers = $prioritiesRes->where('question_id', $function->id)->whereIn('answered_by', $leaders_respondents)->sum('answer_value');
            $count_answers = $prioritiesRes->where('question_id', $function->id)->whereIn('answered_by', $leaders_respondents)->count();
            $priorityVal = $count_answers > 0 ? round((($total_answers / $count_answers) / 3), 2) : 0;
            $priority = ["priority" => number_format($priorityVal * 100), "function" => $function->translated_title, "function_id" => $function->id, "performance" => number_format($avgl * 100), "performancez" => number_format($avgl * 100)];
            array_push($priorities, $priority);
            $function_total += ($totalz / count($function->practices));
            $performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format(($totalz / count($function->practices)) * 100),
                // "performance" => number_format((($avge + $avgh + $avgl) / $p_count_) * 100),
            ];
            array_push($performences_, $performence_);
        }
        $overallResult = number_format(($function_total / count($functions)) * 100);
        $unsorted_performences = $performences_;
        $sorted_leader_performences = $leader_performences_;
        $sorted_hr_performences = $hr_performences_;
        $sorted_emp_performences = $emp_performences_;
        //sorte sorted_leader_performences descending
        usort($sorted_leader_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sorte sorted_hr_performences descending
        usort($sorted_hr_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sorte sorted_emp_performences descending
        usort($sorted_emp_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        //sort performances_
        // usort($performences_, function ($a, $b) {
        //     return $a['performance'] <=> $b['performance'];
        // });
        $asc_perform = $performences_;
        usort($performences_, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        // $leaders_perform_only = array();
        // $hr_perform_only = array();
        $leaders_perform_onlyz = array();
        $hr_perform_onlyz = array();
        $count_z = 0;
        foreach ($functions as $function) {
            if ($leader_performences_[$count_z]['function_id'] == $function->id) {
                array_push($leaders_perform_onlyz, ['performance' => $leader_performences_[$count_z]['performance'], 'id' => $function->id]);
            }
            if ($hr_performences_[$count_z]['function_id'] == $function->id) {
                array_push($hr_perform_onlyz, ['performance' => $hr_performences_[$count_z++]['performance'], 'id' => $function->id]);
            }
        }
        $desc_perfom = $performences_;

        $data = [
            'data_size' => $respondents_count,
            'functions' => $functions,
            'priorities' => $priorities,
            'overallResult' => $overallResult,
            'asc_perform' => $asc_perform,
            'desc_perfom' => $desc_perfom,
            'overall_Practices' => $overall_Practices,
            'sorted_leader_performences' => $sorted_leader_performences,
            'sorted_hr_performences' => $sorted_hr_performences,
            'sorted_emp_performences' => $sorted_emp_performences,
            'function_Lables' => $function_Lables,
            'leaders_perform_onlyz' => $leaders_perform_onlyz,
            'hr_perform_onlyz' => $hr_perform_onlyz,
            "id" => $survey,
            'Resp_overAll_res' => $respondents_count,
            'overAll_res' => $Answers_by_leaders + $Answers_by_hr + $Answers_by_emp,
            'prop_leadersResp' => count($leaders_respondents),
            'prop_hrResp' => count($hr_teams_respondents),
            'prop_empResp' => count($normal_respondents),
            'leaders_res' => $Answers_by_leaders,
            'hr_res' => $Answers_by_hr,
            'emp_res' => $Answers_by_emp,
            'leader_performences' => $leader_performences_,
            'hr_performences' => $hr_performences_,
            'type' => 'comp',
            'type_id' => $company->id,
            'entities' => null,
            'entity' => $company->name . ' ' . __('Result Company-wise'),
            'client_id' => $company->id,
            'service_type' => 4,
            'heatmap' => []
        ];
        return $data;
    }
    //start calculate for sector

    public function calculateSectorResults($sector, $survey)
    {
        $sector_companies_results = [];
        foreach ($sector->companies as $company) {
            $result = $this->startCalculateForCompany($survey, $company);
            if ($result != 0 || $result != 1) {
                $sector_companies_results[] = $result;
            }
        }
        if (count($sector_companies_results) == 0) {
            return 0;
        }
        // calculate the averages
        $data = $this->calculateAverages(
            $sector_companies_results,
            $sector,
            'sector',
            $survey
        );

        return $data;
    }
    public function calculateSingleClient($client, $survey)
    {
        $client_sectors_results = [];
        foreach ($client->sectors as $sector) {
            $result = $this->calculateSectorResults($sector, $survey);
            if ($result != 0 || $result != 1) {
                $client_sectors_results[] = $result;
            }
        }
        if (count($client_sectors_results) == 0) {
            return 0;
        }
        // calculate the averages
        $data = $this->calculateAverages(
            $client_sectors_results,
            $client,
            'client',
            $survey
        );
        return $data;
    }
    public function calculateAverages($sector_companies_results, $entity, $entity_type, $survey)
    {
        if (count($sector_companies_results) > 1) {
            $data_size = count($sector_companies_results);
            $respondents_count = 0;
            $overallResult = 0;
            $overAll_res = 0;
            $prop_leadersResp = 0;
            $prop_hrResp = 0;
            $prop_empResp = 0;
            $leaders_res = 0;
            $hr_res = 0;
            $emp_res = 0;
            $planID = Surveys::where('id', $survey)->first()->plans->service;
            $functions = Functions::where('service_id', $planID)->select(['id', 'title_ar', 'title'])->get();
            $prioritiesArray = [];
            $priorities = [];
            $leaders_perform_onlyz=[];
            $hr_perform_onlyz=[];
            $asc_performArray = [];
            $desc_perfomArray = [];
            $asc_perform = [];
            $desc_perfom = [];
            $overall_Practices = [];
            $overall_Practices_data = [];
            $sorted_leader_performences_data = [];
            $sorted_leader_performences = [];
            $sorted_hr_performences_data = [];
            $sorted_hr_performences = [];
            $sorted_emp_performences_data = [];
            $sorted_emp_performences = [];
            $function_Lables = [];
            $leaders_perform_onlyz_data = [];
            $hr_perform_onlyz_data = [];
            $heatmap = [];
            foreach ($sector_companies_results as $data) {
                $respondents_count += $data['data_size'];
                $prioritiesArray = array_merge($prioritiesArray, $data['priorities']);
                $overallResult += $data['overallResult'];
                $asc_performArray = array_merge($asc_performArray, $data['asc_perform']);
                $desc_perfomArray = array_merge($desc_perfomArray, $data['desc_perfom']);
                $overall_Practices_data = array_merge($overall_Practices_data, $data['overall_Practices']);
                $sorted_leader_performences_data = array_merge($sorted_leader_performences_data, $data['sorted_leader_performences']);
                $sorted_hr_performences_data = array_merge($sorted_hr_performences_data, $data['sorted_hr_performences']);
                $sorted_emp_performences_data = array_merge($sorted_emp_performences_data, $data['sorted_emp_performences']);
                $leaders_perform_onlyz_data = array_merge($leaders_perform_onlyz_data, $data['leaders_perform_onlyz']);
                $hr_perform_onlyz_data = array_merge($hr_perform_onlyz_data, $data['hr_perform_onlyz']);
                $overAll_res += $data['overAll_res'];
                $prop_leadersResp += $data['prop_leadersResp'];
                $prop_hrResp += $data['prop_hrResp'];
                $prop_empResp += $data['prop_empResp'];
                $leaders_res += $data['leaders_res'];
                $hr_res += $data['hr_res'];
                $emp_res += $data['emp_res'];
                $type = '';
                if ($entity_type == 'client') {
                    $type = 'sec';
                }
                if ($entity_type == 'sector') {
                    $type = 'comp';
                }
                $heatmap_item = [
                    'overallResult' => $data['overallResult'],
                    'name' => $data['entity'],
                    'id' => $data['client_id'],
                    'survey_id' => $data['id'],
                    'type' => $type
                ];
                $heatmap[] = $heatmap_item;
            }
            $prioritiesArray = collect($prioritiesArray);
            $asc_performArray = collect($asc_performArray);
            $desc_perfomArray = collect($desc_perfomArray);
            $overall_Practices_data = collect($overall_Practices_data);
            $sorted_leader_performences_data = collect($sorted_leader_performences_data);
            $sorted_hr_performences_data = collect($sorted_hr_performences_data);
            $sorted_emp_performences_data = collect($sorted_emp_performences_data);
            $leaders_perform_onlyz_data = collect($leaders_perform_onlyz_data);
            $hr_perform_onlyz_data = collect($hr_perform_onlyz_data);
            $overallResult = $overallResult / $data_size;
            foreach ($functions as $function) {
                $function_Lables[] = ['title' => $function->translated_title, 'id' => $function->id];
                $priority = [
                    "priority" => $prioritiesArray->where('function_id', $function->id)->avg('priority'),
                    "function" => $function->translated_title,
                    "function_id" => $function->id,
                    "performance" => $prioritiesArray->where('function_id', $function->id)->avg('performance'),
                    "performancez" => $prioritiesArray->where('function_id', $function->id)->avg('performancez')
                ];
                array_push($priorities, $priority);
                $asc_perform_item = [
                    'performance' => $asc_performArray->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                    'function' => $function->translated_title
                ];
                array_push($asc_perform, $asc_perform_item);
                $desc_perfom_item = [
                    'performance' => $desc_perfomArray->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                    'function' => $function->translated_title
                ];
                array_push($desc_perfom, $desc_perfom_item);
                $leader_performences_item = [
                    'performance' => $sorted_leader_performences_data->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                    'function' => $function->translated_title,
                    //boolean applicable
                    'applicable' => $sorted_leader_performences_data->every(function ($item) {
                        return $item['applicable'] === true;
                    })
                ];
                array_push($sorted_leader_performences, $leader_performences_item);
                $hr_performences_item = [
                    'performance' => $sorted_hr_performences_data->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                    'function' => $function->translated_title,
                    //boolean applicable
                    'applicable' => $sorted_hr_performences_data->every(function ($item) {
                        return $item['applicable'] === true;
                    })
                ];
                array_push($sorted_hr_performences, $hr_performences_item);
                $emp_performences_item = [
                    'performance' => $sorted_emp_performences_data->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                    'function' => $function->translated_title,
                    //boolean applicable
                    'applicable' => $sorted_emp_performences_data->every(function ($item) {
                        return $item['applicable'] === true;
                    })
                ];
                array_push($sorted_emp_performences, $emp_performences_item);
                $leaders_perform_onlyz_item = [
                    'performance' => $leaders_perform_onlyz_data->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                ];
                array_push($leaders_perform_onlyz, $leaders_perform_onlyz_item);
                $hr_perform_onlyz_item = [
                    'performance' => $hr_perform_onlyz_data->where('function_id', $function->id)->avg('performance'),
                    'function_id' => $function->id,
                ];
                array_push($hr_perform_onlyz, $hr_perform_onlyz_item);
                foreach ($function->practices as $practice) {
                    $overall_Practices_item = [
                        'name' => $practice->translated_title,
                        'id' => $practice->id,
                        'weight' => $overall_Practices_data->where('practice_id', $practice->id)->avg('weight'),
                        'function_id' => $function->id,
                    ];
                    array_push($overall_Practices, $overall_Practices_item);
                }
            }
            //sorte asc_perform ascending
            $asc_perform = collect($asc_perform)->sortBy('performance')->toArray();
            $desc_perfom = collect($desc_perfom)->sortByDesc('performance')->toArray();
            $sorted_leader_performences = collect($sorted_leader_performences)->sortBy('performance')->toArray();
            $sorted_hr_performences = collect($sorted_hr_performences)->sortBy('performance')->toArray();
            $sorted_emp_performences = collect($sorted_emp_performences)->sortBy('performance')->toArray();
            $wise = "";

            if ($entity_type == 'sector') {
                $wise = __('Result Sector-wise');
            }
            if ($entity_type == 'client') {
                $wise = __('Result Org-wise');
            }
            $data = [
                'data_size' => $respondents_count,
                'functions' => $functions,
                'priorities' => $priorities,
                'overallResult' => $overallResult,
                'asc_perform' => $asc_perform,
                'desc_perfom' => $desc_perfom,
                'overall_Practices' => $overall_Practices,
                'sorted_leader_performences' => $sorted_leader_performences,
                'sorted_hr_performences' => $sorted_hr_performences,
                'sorted_emp_performences' => $sorted_emp_performences,
                'function_Lables' => $function_Lables,
                'leaders_perform_onlyz' => $leaders_perform_onlyz,
                'hr_perform_onlyz' => $hr_perform_onlyz,
                "id" => $survey,
                'Resp_overAll_res' => $respondents_count,
                'overAll_res' => $overAll_res,
                'prop_leadersResp' => $prop_leadersResp,
                'prop_hrResp' => $prop_hrResp,
                'prop_empResp' => $prop_empResp,
                'leaders_res' => $leaders_res,
                'hr_res' => $hr_res,
                'emp_res' => $emp_res,
                'leader_performences' => $sorted_leader_performences,
                'hr_performences' => $sorted_hr_performences,
                'type' => $entity_type,
                'type_id' => $entity->id,
                'entities' => null,
                'entity' => $entity->name . ' ' . $wise,
                'client_id' => $entity->client_id,
                'service_type' => 4,
                'heatmap' => $heatmap
            ];
            return $data;
        } else {
            $type = '';
            if ($entity_type == 'client') {
                $type = 'sec';
            }
            if ($entity_type == 'sector') {
                $type = 'comp';
            }
            $heatmap_item = [
                'overallResult' => $sector_companies_results[0]['overallResult'],
                'name' => $sector_companies_results[0]['entity'],
                'id' => $sector_companies_results[0]['client_id'],
                'survey_id' => $sector_companies_results[0]['id'],
                'type' => $type
            ];
            $heatmap[] = $heatmap_item;
            $sector_companies_results[0]['heatmap'] = $heatmap;
            return $sector_companies_results[0];
        }
    }
}
