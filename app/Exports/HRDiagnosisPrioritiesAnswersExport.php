<?php

namespace App\Exports;

use App\Models\PrioritiesAnswers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HRDiagnosisPrioritiesAnswersExport implements FromCollection, WithHeadings, WithChunkReading
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $id;
    private $type;
    private $type_id;
    public function __construct($id, $type, $type_id)
    {
        $this->id = $id;
        $this->type = $type;
        $this->type_id = $type_id;
    }
    public function collection()
    {
        $exportData = [];
        $ids = DB::table('respondents')
            ->join('employees', 'employees.id', '=', 'respondents.employee_id')
            ->join('departments', 'employees.dep_id', '=', 'departments.id')
            ->where('departments.is_hr', false)
            ->where('employees.employee_type', 1)
            ->where('respondents.survey_id', $this->id)
            ->select('respondents.id')
            ->pluck('respondents.id')->toArray();
        //get functions
        $functions = DB::table('functions')
            ->join('services', 'functions.service_id', '=', 'services.id')
            ->where('services.service_type', '=', 4)
            ->select(['functions.id', 'functions.title'])
            ->get();
        $count = 1;
        foreach ($ids as $id) {
            $index = 0;
            $exportData[$count][$index++] =  $this->id;
            $exportData[$count][$index++] =  $id;

            foreach ($functions as $function) {
                $result = PrioritiesAnswers::select("survey_id", "question_id", "answer_value",  "answered_by")
                    ->where('survey_id', $this->id)
                    ->where('question_id', $function->id)
                    ->where("answered_by", $id)->first();
                if ($result != null) {
                    $exportData[$count][$index++] = $result->answer_value;
                } else {
                    $exportData[$count][$index++] = 'N/A';
                }
            }
            $count++;
        }
        return collect($exportData);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $array = ['Survey Id',  'Answered By'];
        $functions = DB::table('functions')
            ->join('services', 'functions.service_id', '=', 'services.id')
            ->where('services.service_type', '=', 4)
            ->select(['functions.id', 'functions.title'])
            ->get();

        foreach ($functions as $function) {
            $array[] = $function->title;
        }
        return $array;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
