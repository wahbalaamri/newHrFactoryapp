<?php

namespace App\Http\services;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Functions;
use App\Models\Respondents;
use App\Models\Sectors;
use App\Models\Services;
use App\Models\SurveyAnswers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Calculate3hResults
{
    function SurveyResults($Client_id, $Service_type, $survey_id, $vtype, $vtype_id = null, $by_admin = false)
    {
        try {
            if ($vtype == 'comp') {
                $data = $this->get_resultd($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
            } elseif ($vtype == 'sec') {
                $data = $this->get_SectorResult($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
            } elseif ($vtype == 'dep') {
                $data = $this->getDepartment3hResults(
                    $Client_id,
                    $vtype_id,
                    $survey_id,
                    $Client_id,
                    $Service_type,
                    Departments::find($vtype_id)->dep_level
                );
            } elseif ($vtype == 'gender') {
                if ($vtype_id == 'male')
                    $data = $this->getResultsByGender($Client_id, $Service_type, $survey_id, "m");
                elseif ($vtype_id == 'female')
                    $data = $this->getResultsByGender($Client_id, $Service_type, $survey_id, "f");
                else
                    $data = $this->getResultsByGender($Client_id, $Service_type, $survey_id);
            } elseif ($vtype == 'age') {
                if ($vtype_id == 'G-1')
                    $data = $this->getResultsByAge($Client_id, $Service_type, $survey_id, "G-1");
                elseif ($vtype_id == 'G-2')
                    $data = $this->getResultsByAge($Client_id, $Service_type, $survey_id, "G-2");
                elseif ($vtype_id == 'G-3')
                    $data = $this->getResultsByAge($Client_id, $Service_type, $survey_id, "G-3");
                elseif ($vtype_id == 'G-4')
                    $data = $this->getResultsByAge($Client_id, $Service_type, $survey_id, "G-4");
                else
                    $data = $this->getResultsByAge($Client_id, $Service_type, $survey_id);
            } elseif ($vtype == 'service') {
                if ($vtype_id == 'G-1')
                    $data = $this->getResultsByService($Client_id, $Service_type, $survey_id, "G-1");
                elseif ($vtype_id == 'G-2')
                    $data = $this->getResultsByService($Client_id, $Service_type, $survey_id, "G-2");
                elseif ($vtype_id == 'G-3')
                    $data = $this->getResultsByService($Client_id, $Service_type, $survey_id, "G-3");
                elseif ($vtype_id == 'G-4')
                    $data = $this->getResultsByService($Client_id, $Service_type, $survey_id, "G-4");
                else
                    $data = $this->getResultsByService($Client_id, $Service_type, $survey_id);
            } else {
                $data = $this->get_GroupResult($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
            }
            $data['client_id'] = $Client_id;
            $data['Service_type'] = $Service_type;
            $data['survey_id'] = $survey_id;
            return $data;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function get_GroupResult($Client_id, $service_type, $id, $type, $type_id)
    {
        //Sub data
        $sub_data = [];
        //find client
        $client = Clients::find($Client_id);
        foreach ($client->sectors as $sector) {
            $sub_data[] = $this->get_SectorResult($Client_id, $service_type, $id, 'sec', $sector->id);
        }
        $data = $this->calculateTheAverage(
            $client->name,
            $Client_id,
            $id,
            $service_type,
            "sec",
            $sub_data
        );
        return $data;
    }
    public function get_SectorResult($Client_id, $service_type, $id, $type, $type_id)
    {

        //find sector
        $sub_data = [];
        $sector = Sectors::find($type_id);
        foreach ($sector->companies as $company) {
            $sub_data[] = $this->get_resultd($Client_id, $service_type, $id, 'comp', $company->id);
        }
        $data = $this->calculateTheAverage(
            $sector->name,
            $type_id,
            $id,
            $service_type,
            "comp",
            $sub_data
        );
        $data['type'] = $sector->name;
        return $data;
    }
    public function get_resultd($Client_id, $service_type, $Survey_id, $type, $type_id = null)
    {

        $entity = '';
        // $this->id = $Survey_id;
        //find the company name
        $company = Companies::find($type_id);
        $entity = $company->name;
        $sub_data = [];
        //find client
        $client = Clients::find($Client_id);
        //check if client using departments
        if ($client->use_departments) {
            //find department parent is null
            $departments = $company->departments()->whereNull('parent_id')->get();
            $company_heat_map = [];
            //loop throgh $departments
            foreach ($departments as $department) {
                $sub_data_ = $this->getDepartment3hResults($type_id, $department->id, $Survey_id, $Client_id, $service_type, 1);
                if ((bool)$sub_data_['there_is_answer'])
                    $sub_data[] = $sub_data_;
            }
            //get the average
            $data = $this->calculateTheAverage(
                $company->name,
                $type_id,
                $Survey_id,
                $service_type,
                "dep",
                $sub_data
            );
        } else {
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.comp_id', $type_id)
                ->where('employees.client_id', $Client_id)
                ->where('respondents.client_id', $Client_id)
                ->where('respondents.survey_id', $Survey_id)
                ->pluck('respondents.id')->toArray();
            $data = $this->StartCalulate($Client_id, $Survey_id, $service_type, $entity, $type_id, $respondents);
        }
        $data['type'] = $entity;
        return $data;
    }

    function getDepartment3hResults($company, $dep_id, $Survey_id, $Client_id, $service_type, $dep_level)
    {
        //find department
        $data = [];
        $sub_data = [];
        $department = Departments::find($dep_id);
        //check if department has sub departments
        if ($department->subDepartments->count() > 0) {
            foreach ($department->subDepartments->whereNotIn('id', [14339, 14375, 14357, 14380]) as $subDepartment) {
                $sub_data[] = $this->getDepartment3hResults($company, $subDepartment->id, $Survey_id, $Client_id, $service_type, $subDepartment->dep_level);
            }
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.client_id', $Client_id)
                ->where('employees.comp_id', $company)
                ->where('employees.dep_id', $dep_id)
                ->where('respondents.client_id', $Client_id)
                ->where('respondents.survey_id', $Survey_id)
                ->pluck('respondents.id')->toArray();
            //get the result of current department
            $the_dep_result = $this->StartCalulate(
                $Client_id,
                $Survey_id,
                $service_type,
                'Result of Direct Employees in: ' . $department->name_en,
                $department->id,
                $respondents
            );
            $there_is_answer = (bool)$the_dep_result['there_is_answer'];
            //push $the_dep_result into sub_data
            if ($there_is_answer)
                $sub_data[] = $the_dep_result;
            //get the average
            $data = $this->calculateTheAverage(
                $department->name_en,
                $department->id,
                $Survey_id,
                $service_type,
                "dep",
                $sub_data
            );
        } else {
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.client_id', $Client_id)
                ->where('employees.comp_id', $company)
                ->where('employees.dep_id', $dep_id)
                ->where('respondents.client_id', $Client_id)
                ->where('respondents.survey_id', $Survey_id)
                ->pluck('respondents.id')->toArray();
            $data = $this->StartCalulate($Client_id, $Survey_id, $service_type, $department->name_en, $department->id, $respondents);
        }
        $data['entity'] = $department->name_en;
        $data['type'] = $department->name_en;
        return $data;
    }
    function StartCalulate($client_id, $Survey_id, $service_type, $entity_name, $entity_id, $Emails)
    {
        $overall_per_fun = [];
        $driver_functions_practice = [];
        $heat_map = [];
        $hand_favorable_score = 0;
        $head_favorable_score = 0;
        $heart_favorable_score = 0;
        $out_come_favorable_val = 0;
        $enps_favorable = 0;
        $enps_unfavorable = 0;
        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = [];
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = [];
        $entity = '';
        // $this->id = $Survey_id;
        //find service with type
        $service = Services::where('service_type', $service_type)->first()->id;
        foreach (Functions::where('service_id', $service)->where('IsDriver', true)->get() as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->practices as $practice) {
                $chunkSize = 500; // Adjust chunk size based on your DB limits
                $Favorable_result = collect();
                $sum_answer_value_Favorable = 0;
                $Favorable_count = 0;
                $there_is_answer = false;
                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', '>', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_Favorable += intval($result->first()->sum);
                    $Favorable_count += intval($result->first()->count);
                    $there_is_answer = intval($result->first()->count) > 0;
                    // Add results together
                }
                $sum_answer_value_UnFavorable = 0;
                $UnFavorable_count = 0;

                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', '<', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_UnFavorable += intval($result->first()->sum);
                    $UnFavorable_count += intval($result->first()->count);
                    // Add results together
                }
                $sum_answer_value_Nuetral = 0;
                $Nuetral_count = 0;
                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_Nuetral += intval($result->first()->sum);
                    $Nuetral_count += intval($result->first()->count);
                    // Add results together
                }
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
            $function_Favorable_score = $function_Favorable_count == 0 ? 0 : number_format(($function_Favorable_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2);
            if (str_contains(strtolower($function->title),  "head")) {
                $head_favorable_score = $function_Favorable_score;
            }
            if (str_contains(strtolower($function->title),  "hand")) {
                $hand_favorable_score = $function_Favorable_score;
            }
            if (str_contains(strtolower($function->title),  "heart")) {
                $heart_favorable_score = $function_Favorable_score;
            }
            //setup function_results
            $function_results = [
                'function' => $function->id,
                'function_title' => $function->translated_title,
                'Nuetral_score' => $function_Nuetral_count == 0 ? 0 : number_format(($function_Nuetral_count / ($function_Favorable_count + $function_Nuetral_count + $function_UnFavorable_count)) * 100, 2),
                'Favorable_score' => $function_Favorable_score,
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
        // dd($overall_per_fun);
        foreach (Functions::where('service_id', $service)->where('IsDriver', false)->get() as $function) {
            $function_Nuetral_sum = 0;
            $function_Favorable_sum = 0;
            $function_UnFavorable_sum = 0;
            $function_Nuetral_count = 0;
            $function_Favorable_count = 0;
            $function_UnFavorable_count = 0;
            foreach ($function->practices as $practice) {
                //get sum of answer value from survey answers
                $chunkSize = 500; // Adjust chunk size based on your DB limits
                $Favorable_result = collect();
                $sum_answer_value_Favorable = 0;
                $Favorable_count = 0;
                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', '>', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_Favorable += intval($result->first()->sum);
                    $Favorable_count += intval($result->first()->count);
                    // Add results together
                }
                $sum_answer_value_UnFavorable = 0;
                $UnFavorable_count = 0;
                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', '<', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_UnFavorable += intval($result->first()->sum);
                    $UnFavorable_count += intval($result->first()->count);
                    // Add results together
                }
                $sum_answer_value_Nuetral = 0;
                $Nuetral_count = 0;
                foreach (array_chunk($Emails, $chunkSize) as $chunkedEmails) {
                    $result = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
                        ->where('survey_id', $Survey_id)
                        ->where('answer_value', 3)
                        ->where('question_id', $practice->questions->first()->id)
                        ->whereIn('answered_by', $chunkedEmails)
                        ->get();
                    $sum_answer_value_Nuetral += intval($result->first()->sum);
                    $Nuetral_count += intval($result->first()->count);
                    // Add results together
                }
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
                    $enps_favorable = $Favorable;
                    $enps_unfavorable = $UnFavorable;
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
            $out_come_favorable_val = $out_come_favorable;
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
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->reverse()->toArray();
        // $ENPS_data_array = array_slice($ENPS_data_array, 0, 3);
        // $ENPS_data_array = collect($ENPS_data_array)->sortBy('ENPS_index')->toArray();
        //get first three highest items
        //sort $driver_functions_practice asc
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array,
            'entity' => $entity,
            // 'type' => $type,
            // 'type_id' => $type_id,
            'id' => $Survey_id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map,
            'hand_favorable_score' => $hand_favorable_score,
            'head_favorable_score' => $head_favorable_score,
            'heart_favorable_score' => $heart_favorable_score,
            'outcome_favorable_score' => $out_come_favorable_val,
            'enps_favorable' => $enps_favorable,
            'enps_unfavorable' => $enps_unfavorable,
            'entity_name' => $entity_name,
            'entity_id' => $entity_id,
            'there_is_answer' => $there_is_answer
        ];
        return $data;
    }
    function calculateTheAverage($entity_name, $entity_id, $survey_id, $service_type, $type_v, $array_of_data)
    {
        $service = Services::where('service_type', $service_type)->first()->id;
        $functions = Functions::where('service_id', $service)->get();
        $driver_functions = [];
        $outcome_functions = [];
        $ENPS_data_array1 = [];
        $ENPS_data_array = [];
        $practices = [];
        $overall_per_fun = [];
        $driver_functions_practice = [];
        $outcome_function_results_1 = [];
        $heat_map_last = [];
        $hand_favorable_score = 0;
        $head_favorable_score = 0;
        $heart_favorable_score = 0;
        $out_come_favorable_val = 0;
        $enps_unfavorable = 0;
        $sum_hand_favorable_score = 0;
        $sum_head_favorable_score = 0;
        $sum_heart_favorable_score = 0;
        $sum_out_come_favorable_val = 0;
        $sum_enps_favorable = 0;
        $sum_enps_unfavorable = 0;
        $data_size = count($array_of_data);
        $there_is_answer = false;
        foreach ($array_of_data as $singl_data) {
            foreach ($singl_data['drivers_functions'] as $driver) {
                array_push($driver_functions, $driver);
            }
            foreach ($singl_data['outcomes'] as $outcome) {
                array_push($outcome_functions, $outcome);
            }
            // foreach ($singlData['ENPS_data_array'] as $ENPS) {
            array_push($ENPS_data_array, $singl_data['ENPS_data_array']);
            // }
            foreach ($singl_data['drivers'] as $practice) {
                array_push($practices, $practice);
            }
            //heat_map_item
            //get entity_name
            $heat_map_item = [
                'entity_name' => $singl_data['entity_name'],
                'entity_id' => $singl_data['entity_id'],
                'vtype' => $type_v,
                'hand_favorable_score' => $singl_data['hand_favorable_score'],
                'head_favorable_score' => $singl_data['head_favorable_score'],
                'heart_favorable_score' => $singl_data['heart_favorable_score'],
                'outcome_favorable_score' => $singl_data['outcome_favorable_score'],
                'enps_favorable' => $singl_data['enps_favorable'],
                'enps_unfavorable' => $singl_data['enps_unfavorable'],
            ];
            if ($singl_data['hand_favorable_score'] > 0 || $singl_data['head_favorable_score'] > 0 || $singl_data['heart_favorable_score'] > 0 || $singl_data['outcome_favorable_score'] > 0 || $singl_data['enps_favorable'] > 0) {
                $there_is_answer = true;
            }
            array_push($heat_map_last, $heat_map_item);
            $sum_hand_favorable_score += $singl_data['hand_favorable_score'];
            $sum_head_favorable_score += $singl_data['head_favorable_score'];
            $sum_heart_favorable_score += $singl_data['heart_favorable_score'];
            $sum_out_come_favorable_val += $singl_data['outcome_favorable_score'];
            $sum_enps_favorable += $singl_data['enps_favorable'];
            $sum_enps_unfavorable += $singl_data['enps_unfavorable'];
        }
        //get average of functions
        $hand_favorable_score = $sum_hand_favorable_score / $data_size;
        $head_favorable_score = $sum_head_favorable_score / $data_size;
        $heart_favorable_score = $sum_heart_favorable_score / $data_size;
        $out_come_favorable_val = $sum_out_come_favorable_val / $data_size;
        $enps_favorable = $sum_enps_favorable / $data_size;
        $enps_unfavorable = $sum_enps_unfavorable / $data_size;
        foreach ($functions as $function) {
            if ($function->IsDriver) {
                $function_results = [
                    'function' => $function->id,
                    'function_title' => $function->translated_title,
                    'Nuetral_score' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('Nuetral_score') / $data_size,
                            2,
                        ),
                    ),
                    'Favorable_score' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('Favorable_score') / $data_size,
                            2,
                        ),
                    ),
                    'UnFavorable_score' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('UnFavorable_score') / $data_size,
                            2,
                        ),
                    ),
                    //get count of Favorable answers
                    'Favorable_count' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('Favorable_count') / $data_size,
                            2,
                        ),
                    ),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('UnFavorable_count') / $data_size,
                            2,
                        ),
                    ),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(
                        number_format(
                            collect($driver_functions)
                                ->where('function', $function->id)
                                ->sum('Nuetral_count') / $data_size,
                            2,
                        ),
                    ),
                ];
                array_push($overall_per_fun, $function_results);
                foreach ($function->practices as $practice) {
                    $practice_results = [
                        'function' => $function->id,
                        'practice_id' => $practice->id,
                        'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
                        'Nuetral_score' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('Nuetral_score') / $data_size,
                            ),
                        ),
                        'Favorable_score' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('Favorable_score') / $data_size,
                            ),
                        ),
                        'UnFavorable_score' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('UnFavorable_score') / $data_size,
                            ),
                        ),
                        //get count of Favorable answers
                        'Favorable_count' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('Favorable_count') / $data_size,
                            ),
                        ),
                        //get count of UnFavorable answers
                        'UnFavorable_count' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('UnFavorable_count') / $data_size,
                            ),
                        ),
                        //get count of Nuetral answers
                        'Nuetral_count' => floatval(
                            number_format(
                                collect($practices)
                                    ->where('practice_id', $practice->id)
                                    ->sum('Nuetral_count') / $data_size,
                            ),
                        ),
                    ];
                    array_push($driver_functions_practice, $practice_results);
                }
            } else {
                foreach ($function->practices as $practice) {
                    if ($practice->questions->first()->IsENPS) {
                        $Favorable = floatval(
                            number_format(
                                collect($ENPS_data_array)
                                    ->where('practice_id', $practice->id)
                                    ->sum('Favorable_score') / $data_size,
                                2,
                            ),
                        );
                        $UnFavorable = floatval(
                            number_format(
                                collect($ENPS_data_array)
                                    ->where('practice_id', $practice->id)
                                    ->sum('UnFavorable_score') / $data_size,
                                2,
                            ),
                        );
                        $ENPS_data_array1 = [
                            'function' => $function->id,
                            'practice_id' => $practice->id,
                            'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
                            'Nuetral_score' => floatval(
                                number_format(
                                    collect($ENPS_data_array)
                                        ->where('practice_id', $practice->id)
                                        ->sum('Nuetral_score') / $data_size,
                                    2,
                                ),
                            ),
                            //get count of Favorable answers
                            'Favorable_count' => floatval(
                                number_format(
                                    collect($ENPS_data_array)
                                        ->where('practice_id', $practice->id)
                                        ->sum('Favorable_count') / $data_size,
                                    2,
                                ),
                            ),
                            //get count of UnFavorable answers
                            'UnFavorable_count' => floatval(
                                number_format(
                                    collect($ENPS_data_array)
                                        ->where('practice_id', $practice->id)
                                        ->sum('UnFavorable_count') / $data_size,
                                    2,
                                ),
                            ),
                            //get count of Nuetral answers
                            'Nuetral_count' => floatval(
                                number_format(
                                    collect($ENPS_data_array)
                                        ->where('practice_id', $practice->id)
                                        ->sum('Nuetral_count') / $data_size,
                                    2,
                                ),
                            ),
                            'Favorable_score' => $Favorable,
                            'UnFavorable_score' => $UnFavorable,
                            'ENPS_index' => $Favorable - $UnFavorable,
                        ];
                    }
                }
                $out_come_favorable = floatval(
                    number_format(
                        collect($outcome_functions)
                            ->where('function', $function->id)
                            ->sum('Favorable_score') / $data_size,
                        2,
                    ),
                );
                $out_come_unfavorable = floatval(
                    number_format(
                        collect($outcome_functions)
                            ->where('function', $function->id)
                            ->sum('UnFavorable_score') / $data_size,
                        2,
                    ),
                );
                //setup function_results
                $outcome_function_results = [
                    'function' => $function->id,
                    'function_title' => $function->translated_title,
                    'Nuetral_score' => floatval(
                        number_format(
                            collect($outcome_functions)
                                ->where('function', $function->id)
                                ->sum('Nuetral_score') / $data_size,
                            2,
                        ),
                    ),
                    'Favorable_score' => $out_come_favorable,
                    'UnFavorable_score' => $out_come_unfavorable,
                    //get count of Favorable answers
                    'Favorable_count' => floatval(
                        number_format(
                            collect($outcome_functions)
                                ->where('function', $function->id)
                                ->sum('Favorable_count') / $data_size,
                            2,
                        ),
                    ),
                    //get count of UnFavorable answers
                    'UnFavorable_count' => floatval(
                        number_format(
                            collect($outcome_functions)
                                ->where('function', $function->id)
                                ->sum('UnFavorable_count') / $data_size,
                            2,
                        ),
                    ),
                    //get count of Nuetral answers
                    'Nuetral_count' => floatval(
                        number_format(
                            collect($outcome_functions)
                                ->where('function', $function->id)
                                ->sum('Nuetral_count') / $data_size,
                            2,
                        ),
                    ),
                    'outcome_index' => $out_come_favorable,
                ];
                array_push($outcome_function_results_1, $outcome_function_results);
            }
        }
        $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        //sort $driver_functions_practice desc
        $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        $data = [
            'drivers' => $driver_functions_practice,
            'drivers_functions' => $overall_per_fun,
            'outcomes' => $outcome_function_results_1,
            'ENPS_data_array' => $ENPS_data_array1,
            'entity' => $entity_name,
            'entity_name' => $entity_name,
            'entity_id' => $entity_id,
            'type' => $type_v,
            'type_id' => $entity_id,
            'id' => $survey_id,
            'driver_practice_asc' => $driver_functions_practice_asc,
            'driver_practice_desc' => $driver_functions_practice_desc,
            'heat_map' => $heat_map_last,
            'cal_type' => 'countD',
            'hand_favorable_score' => $hand_favorable_score,
            'head_favorable_score' => $head_favorable_score,
            'heart_favorable_score' => $heart_favorable_score,
            'outcome_favorable_score' => $out_come_favorable_val,
            'enps_favorable' => $enps_favorable,
            'enps_unfavorable' => $enps_unfavorable,
            'there_is_answer' => $there_is_answer
        ];
        return $data;
    }
    function getResultsByGender($client_id, $service_type, $survey_id, $gender = null)
    {
        //Sub data
        $sub_data = [];
        $data = [];
        if ($gender == 'm' || $gender === null) {
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.gender', "Male")
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $maleData = $this->StartCalulate($client_id, $survey_id, $service_type, 'Male', 'm', $respondents);
            $sub_data[] = $maleData;
            $type = "Male Results";
        }
        if ($gender == 'f' || $gender === null) {
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.gender', "Female")
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $femaleData = $this->StartCalulate($client_id, $survey_id, $service_type, 'Female', 'f', $respondents);
            $sub_data[] = $femaleData;
            $type = "Female Results";
        }

        if ($gender === null) {
            // Calculate the average of male and female data
            $data = $this->calculateTheAverage(
                "Gender-Wise",
                null,
                $survey_id,
                $service_type,
                'gender',
                $sub_data
            );
            $type = "Average Results";
            Log::info($type);
        } else {
            $data = $gender == 'm' ? $maleData : $femaleData;
        }

        // Add $type to $data
        $data['type'] = $type;

        return $data;
    }
    function getResultsByAge($client_id, $service_type, $survey_id, $gender = null)
    {
        $globalData = [];
        if ($gender == 'G-1' || $gender === null) {
            $maxDate = Carbon::now()->subYears(26)->format('Y-m-d');
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.dob', ">=", $maxDate)
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_1 = $this->StartCalulate($client_id, $survey_id, $service_type, 'Group -age < 26', 'G-1', $respondents);
            array_push($globalData, $g_1);
            $type = "Male Results";
        }
        if ($gender == 'G-2' || $gender === null) {
            $maxDate = Carbon::now()->subYears(42)->format('Y-m-d');
            $minDate = Carbon::now()->subYears(26)->subDays(1)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->whereBetween('employees.dob', [$maxDate, $minDate])
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_2 = $this->StartCalulate($client_id, $survey_id, $service_type,  'Group -age < 42 > 26', 'G-2', $respondents);
            array_push($globalData, $g_2);
            $type = "Female Results";
        }
        if ($gender == 'G-3' || $gender === null) {
            $maxDate = Carbon::now()->subYears(58)->format('Y-m-d');
            $minDate = Carbon::now()->subYears(42)->subDays(1)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->whereBetween('employees.dob', [$maxDate, $minDate])
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_3 = $this->StartCalulate($client_id, $survey_id, $service_type,  'Group -age < 58 > 42', 'G-3', $respondents);
            array_push($globalData, $g_3);
            $type = "Female Results";
        }
        if ($gender == 'G-4' || $gender === null) {
            $minDate = Carbon::now()->subYears(58)->subDays(1)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.dob', "<=", $minDate)
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_4 = $this->StartCalulate($client_id, $survey_id, $service_type,  'Group -age < 58', 'G-4', $respondents);
            array_push($globalData, $g_4);
            $type = "Female Results";
        }
        //if null return average of four groups results
        if ($gender === null) {
            $data = $this->calculateTheAverage(
                'age-wise',
                null,
                $survey_id,
                $service_type,
                'age',
                $globalData
            );
            return $data;
        }
        //if not null return the results of the group
        if ($gender == 'G-1') {
            $data = $g_1;
        }
        if ($gender == 'G-2') {
            $data = $g_2;
        }
        if ($gender == 'G-3') {
            $data = $g_3;
        }
        if ($gender == 'G-4') {
            $data = $g_4;
        }

        return $data;
    }
    function getResultsByService($client_id, $service_type, $survey_id, $gender = null)
    {
        $globalData = [];
        if ($gender == 'G-1' || $gender === null) {
            $maxDate = Carbon::now()->subYears(1)->format('Y-m-d');
            $respondents =  Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.dos', ">=", $maxDate)
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_1 = $this->StartCalulate($client_id, $survey_id, $service_type, 'Year-of-Service >= 1', 'G-1', $respondents);
            array_push($globalData, $g_1);
            $type = "Male Results";
        }
        if ($gender == 'G-2' || $gender === null) {
            $maxDate = Carbon::now()->subYears(5)->format('Y-m-d');
            $minDate = Carbon::now()->subYears(1)->subDays(1)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->whereBetween('employees.dos', [$maxDate, $minDate])
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_2 = $this->StartCalulate($client_id, $survey_id, $service_type, 'Year-of-Service > 1 <=5', 'G-2', $respondents);
            array_push($globalData, $g_2);
            $type = "Female Results";
        }
        if ($gender == 'G-3' || $gender === null) {
            $minDate = Carbon::now()->subYears(5)->subDays(1)->format('Y-m-d');
            $maxDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->whereBetween('employees.dos', [$maxDate, $minDate])
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_3 = $this->StartCalulate($client_id, $survey_id, $service_type, 'Year-of-Service > 5 <=10', 'G-3', $respondents);
            array_push($globalData, $g_3);
            $type = "Female Results";
        }
        if ($gender == 'G-4' || $gender === null) {
            $minDate = Carbon::now()->subYears(10)->subDays(1)->format('Y-m-d');
            $respondents = Respondents::join('employees', 'employees.id', '=', 'respondents.employee_id')
                ->select('respondents.id')
                ->where('employees.dos', "<=", $minDate)
                ->where('employees.client_id', $client_id)
                ->where('respondents.client_id', $client_id)
                ->where('respondents.survey_id', $survey_id)
                ->pluck('respondents.id')->toArray();
            $g_4 = $this->StartCalulate($client_id, $survey_id, $service_type, 'Year-of-Service > 10', 'G-4', $respondents);
            array_push($globalData, $g_4);
            $type = "Female Results";
        }
        //if null return average of four groups results
        if ($gender === null) {
            $data = $this->calculateTheAverage(
                'service-wise',
                null,
                $survey_id,
                $service_type,
                'service',
                $globalData
            );
            return $data;
        }
        //if not null return the results of the group
        if ($gender == 'G-1') {
            $data = $g_1;
        }
        if ($gender == 'G-2') {
            $data = $g_2;
        }
        if ($gender == 'G-3') {
            $data = $g_3;
        }
        if ($gender == 'G-4') {
            $data = $g_4;
        }
        // Add $type to $data
        $data['type'] = $type;

        return $data;
    }
}
