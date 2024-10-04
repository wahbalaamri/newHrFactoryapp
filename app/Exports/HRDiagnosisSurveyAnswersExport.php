<?php

namespace App\Exports;

use App\Models\FunctionPractices;
use App\Models\Services;
use App\Models\SurveyAnswers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HRDiagnosisSurveyAnswersExport implements FromCollection , WithHeadings, WithChunkReading
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $sid, $type, $type_id;
    private $cid = [];
    public function __construct($sid, $type, $type_id = null, $cid = [])
    {
        $this->sid = $sid;
        $this->type = $type;
        $this->type_id = $type_id;
        $this->cid = $cid;
    }
    public function collection()
    {
        //
        $exportData = [];
        $surveyAnswers = null;
        $Emails = null;
        if (count($this->cid) == 0)
            $Emails = DB::table('respondents')
                ->distinct()
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->join('survey_answers', 'respondents.id', '=', 'survey_answers.answered_by')
                ->join('departments', 'employees.dep_id', '=', 'departments.id')
                ->join('companies', 'employees.comp_id', '=', 'companies.id')
                ->where('respondents.survey_id', '=', $this->sid)
                ->select(['respondents.id', 'respondents.employee_id', 'departments.is_hr', 'employees.employee_type', 'companies.name_en as company_name'])
                ->get();
        else {
            //get clients surveys IDs
            $surveys = DB::table('surveys')
                ->join('clients', 'surveys.client_id', '=', 'clients.id')
                ->join('services', 'surveys.service_id', '=', 'services.id')
                ->whereIn('client_id', $this->cid)->pluck('id')->toArray();
        }
        $count = 0;
        $index = 0;
        $EmailsChunk = $Emails->chunk(100);
        $functions = DB::table('functions')
            ->join('services', 'functions.service_id', '=', 'services.id')
            ->where('services.service_type', '=', 4)
            ->select(['functions.id', 'functions.title'])
            ->get();
        foreach ($Emails as $email) {
            $count = 0;
            $emp_type = '';
            if ($email->is_hr == 1)
                $emp_type = 'HR Team';
            //if 2 HR Team
            else if ($email->employee_type == 1)
                $emp_type = 'Manager';
            //if 3 Employee
            else if ($email->employee_type == 2)
                $emp_type = 'Employee';
            $surveyAnswers = SurveyAnswers::where('survey_id', $this->sid)->where('answered_by', $email->id)->get();
            if ($surveyAnswers->count() > 0) {

                $exportData[] = [
                    'Survey Id' => $this->sid,
                    'Answered By' => $email->id,
                    'Company' => $email->company_name,
                    'Respondent Type' => $emp_type
                ];
                // foreach ($surveyAnswers as $surveyAnswer) {
                $count = 4;
                $indx = 4;

                foreach ($functions as $function) {
                    foreach (FunctionPractices::where('function_id', $function->id)->get() as $practce) {

                        $questionTitle  =  $function->title;
                        foreach ($practce->questions as $question) {

                            //get answervalue
                            $answerValue = SurveyAnswers::where('survey_id', $this->sid)->where('question_id', $question->id)->where('answered_by', $email->id)->first();
                            //push answerValue into eFunctionTitlexportData
                            if ($answerValue != null) {

                                //add this value to next column

                                $exportData[$index][$questionTitle . '-Q-' . $indx++] =  ($answerValue->answer_value);
                                $count++;
                            } else {
                                $exportData[$index][$questionTitle . '-Q-' . $indx++] = '-';
                                $count++;
                            }
                        }
                    }
                }
                // }

                $index++;
            }
        }

        return collect($exportData);
        // $Emails = Emails::select(['id', 'comp_id','sector_id','age_generation','gender'])->where('SurveyId', $this->id)->get();
    }

    public function headings(): array
    {
        // $heading = ['Survey Id', 'Function ID', 'Function Title', 'Is Driver Function', 'Question Id', 'Question Title', 'Question is eNPS', 'Answer Value',   'Answered By'];
        $heading = [
            'Survey Id',
            'Answered By',
            'Company',
            'Respondent Type'
        ];
        $functions = DB::table('functions')
            ->join('services', 'functions.service_id', '=', 'services.id')
            ->where('services.service_type', '=', 4)
            ->get();
        //get functions
        $index = 1;
        foreach ($functions as $function) {
            $questionTitle = "";
            foreach (FunctionPractices::where('function_id', $function->id)->get() as $practce) {
                foreach ($practce->questions as $question) {
                    $questionTitle  =  $function->title;
                    //get loop iteration

                    $heading[] = $questionTitle . '-Q-' . $index;
                    $index++;
                }
            }
        }
        return $heading;
    }

    public function chunkSize(): int
    {
        return 80; // Set the desired chunk size
    }
}
