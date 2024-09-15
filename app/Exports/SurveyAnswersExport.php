<?php

namespace App\Exports;

use App\Models\Companies;
use App\Models\Departments;
use App\Models\Emails;
use App\Models\Employees;
use App\Models\Functions;
use App\Models\OpenEndedQuestions;
use App\Models\OpenEndedQuestionsAnswers;
use App\Models\PracticeQuestions;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SurveyAnswersExport implements FromCollection, WithHeadings, WithChunkReading
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $id;
    private $type;
    private $type_id;
    private $ans;
    public function __construct($id, $type, $type_id = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->type_id = $type_id;
    }
    public function collection()
    {
        $exportData = [];
        $surveyAnswers = null;
        $Emails = null;
        if ($this->type == 'all') {
            $Emails = DB::table('respondents')
                ->distinct()
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->join('survey_answers', 'respondents.id', '=', 'survey_answers.answered_by')
                ->where('respondents.survey_id', '=', $this->id)
                ->select(['respondents.id', 'respondents.employee_id'])
                ->get();
            // $Emails = Emails::select(['id', 'comp_id','sector_id','age_generation','gender'])->where('SurveyId', $this->id)->get();


        } else if ($this->type == 'comp') {
            //get emails where $emails exist in SurveyAnswers
            // $Emails = Emails::select(['id', 'comp_id','sector_id','age_generation','gender'])->where('SurveyId', $this->id)->where('comp_id', $this->type_id)->get();
            $Emails = DB::table('respondents')
                ->distinct()
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->join('survey_answers', 'respondents.id', '=', 'survey_answers.answered_by')
                ->where([['respondents.survey_id', '=', $this->id], ['employees.comp_id', $this->type_id]])
                ->select(['respondents.id', 'respondents.employee_id'])
                ->get();
        }
        //sector
        else if ($this->type == 'sec') {
            //get emails where $emails exist in SurveyAnswers
            // $Emails = Emails::select(['id', 'comp_id','sector_id','age_generation','gender'])->where('SurveyId', $this->id)->where('sector_id', $this->type_id)->get();
            $Emails = DB::table('respondents')
                ->distinct()
                ->join('employees', 'respondents.employee_id', '=', 'employees.id')
                ->join('survey_answers', 'respondents.id', '=', 'survey_answers.answered_by')
                ->where([['respondents.survey_id', '=', $this->id], ['employees.sector_id', $this->type_id]])
                ->select(['respondents.id', 'respondents.employee_id'])
                ->get();
        }
        $count = 0;
        $index = 0;
        $temp_AnsweredBy = null;
        //chunck the Emails collection
        // $EmailsColl=$Emails->chunck(150);
        // dd($Emails);
        $EmailsChunk = $Emails->chunk(100);
        foreach ($Emails as $email) {
            //log email

            $count = 0;
            $surveyAnswers = SurveyAnswers::where('survey_id', $this->id)->where('answered_by', $email->id)->count();
            if ($surveyAnswers > 0) {
                //find employee
                $employee = Employees::find($email->employee_id);
                $exportData[] = [
                    'Survey Id' => $this->id,
                    'Answered By' => $email->id,
                    'Sector' => $employee->sector->name,
                    'Company' => $employee->company->name,
                    'Senior Directorate' => $this->getDepName($employee->department, "Sup-Dir"),
                    'Directorate' => $this->getDepName($employee->department, "Dir"),
                    'Division' => $this->getDepName($employee->department, "Div"),
                    'Department' => $this->getDepName($employee->department, "Dep"),
                    'Gender' => $employee->gender ?? 'N/A',
                    'Birth Date' => $employee->dob,
                    'Service Data' => $employee->dos,
                ];
                // foreach ($surveyAnswers as $surveyAnswer) {
                $count += 5;
                $indx = 5;
                $functions = Functions::where('service_id', Surveys::find($this->id)->plans->service)->get();

                foreach ($functions as $function) {

                    foreach ($function->practices as $practce) {
                        if ($function->IsDriver)
                        //split striing title by space
                        {
                            $title = explode(" ", $function->title);

                            $questionTitle = $title[0] . "-Driver-Q";
                        } else {
                            if ($practce->questions->first()->IsENPS)
                                $questionTitle = "outcome-eNPS-Q";
                            else
                                $questionTitle = "outcome-Q";
                        }
                        //get answervalue
                        $answerValue = SurveyAnswers::where('survey_id', $this->id)->where('question_id', $practce->questions->first()->id)->where('answered_by', $email->id)->first();
                        //push answerValue into eFunctionTitlexportData
                        if ($answerValue != null) {

                            //add this value to next column

                            $exportData[$index][$questionTitle . $indx++] = $answerValue->answer_value;
                            $count++;
                        }
                    }
                }

                $index++;
            }
        }

        return collect($exportData);
        // return SurveyAnswers::select('SurveyId', 'QuestionId', 'AnswerValue',   'AnsweredBy')->where('SurveyId',$this->id)->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        // $heading = ['Survey Id', 'Function ID', 'Function Title', 'Is Driver Function', 'Question Id', 'Question Title', 'Question is eNPS', 'Answer Value',   'Answered By'];
        $heading = [
            'Survey Id',
            'Answered By',
            'Sector',
            'Company',
            'Senior Directorate',
            'Directorate',
            'Division',
            'Department',
            'Gender',
            'Birth Date',
            'Service Data',

        ];
        $functions = Functions::where('service_id', Surveys::find($this->id)->plans->service)->get();
        //get functions
        $index = 1;
        foreach ($functions as $function) {
            $questionTitle = "";
            foreach ($function->practices as $practce) {
                if ($function->IsDriver) {
                    $title = explode(" ", $function->title);
                    $questionTitle = $title[0] . "Driver-Q";
                } else {
                    if ($practce->questions->first()->IsENPS)
                        $questionTitle = "outcome-eNPS-Q";
                    else
                        $questionTitle = "outcome-Q";
                }
                //get loop iteration

                $heading[] = $questionTitle . $index;
                $index++;
            }
        }

        return $heading;
    }
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A' . (count($this->ans) + 3), 'Average:');
                $event->sheet->setCellValue('B' . (count($this->ans) + 3), 'Percentage:');
            }
        ];
    }
    public function chunkSize(): int
    {
        return 80; // Set the desired chunk size
    }
    public function getDepName(Departments $dep, $currenttype)
    {

        if ($currenttype == "Dep") {
            if ($dep->isDepartment())
                return $dep->name;
            else
                return "N/A";
        }

        if ($currenttype == "Div") {
            if ($dep->isDivision())
                return $dep->name;
            elseif ($dep->dep_level > 3)
                return $dep->parent ? $this->getDepName($dep->parent, $currenttype) : "N/A";
            else
                return "N/A";
        }

        if ($currenttype == "Dir")
            if ($dep->isDirectorate())
                return $dep->name;
            elseif ($dep->dep_level > 2)
                return $dep->parent ? $this->getDepName($dep->parent, $currenttype) : "N/A";
            else
                return "N/A";

        if ($currenttype == "Sup-Dir")
            if ($dep->isSuperDirectorate())
                return $dep->name;
            elseif ($dep->dep_level > 1)
                return $dep->parent ? $this->getDepName($dep->parent, $currenttype) : "N/A";
            else
                return "N/A";
    }
}
