<?php

namespace App\Http\Controllers;

use App\Models\Functions;
use App\Http\Requests\StoreFunctionsRequest;
use App\Http\Requests\UpdateFunctionsRequest;
use App\Models\FunctionPractices;
use App\Models\Plans;
use App\Models\PracticeQuestions;
use App\Models\Services;
use Illuminate\Support\Facades\Log;

class FunctionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $remotFunctionsArry = array();
        $functions = Functions::all();

        return view('Functions.index', compact('functions'));
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
    public function store(StoreFunctionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Functions $functions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Functions $functions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFunctionsRequest $request, Functions $functions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Functions $functions)
    {
        //
    }
    //setup function from https://3h.hrfactoryapp.com/function/getf
    public function setup()
    {
        //read the data from the url
        $url = "https://3h.hrfactoryapp.com/function/getf";
        $json = file_get_contents($url);
        $data = json_decode($json);
        //get functions id where service_id =3
        $functions = Functions::where('service_id', 3)->get();
        //get ids
        $ids = $functions->pluck('id')->toArray();
        //delete the data from the database
        Functions::destroy($ids);
        //get function practices where function_id is in ids
        $functionPractices = FunctionPractices::whereIn('function_id', $ids)->get();
        //get ids
        $pids = $functionPractices->pluck('id')->toArray();
        //delete the data from the database
        FunctionPractices::destroy($pids);
        //get practiceQuestions
        $practiceQuestions = PracticeQuestions::whereIn('practice_id', $pids)->get();
        //delete from database
        PracticeQuestions::destroy($practiceQuestions->pluck('id')->toArray());

        //find service with type 3
        $service = Services::where('service_type', 3)->first();
        //insert the data into the database
        $new_data = collect($data);
        foreach ($new_data as $singl_new) {
            $function = new Functions();
            $function->title = $singl_new->FunctionTitle;
            $function->title_ar = $singl_new->FunctionTitleAr;
            $function->respondent = $singl_new->Respondent;
            $function->status = $singl_new->Status;
            $function->service_id = 1;
            $function->IsDefault = $singl_new->IsDefault == 1;
            $function->IsDriver = $singl_new->IsDriver == 1;
            $function->save();
            $practices = $singl_new->function_practices;
            foreach ($practices as $_oldPractice) {
                $practice = new FunctionPractices();
                $practice->function_id = $function->id;
                $practice->title = $_oldPractice->PracticeTitle;
                $practice->title_ar = $_oldPractice->PracticeTitleAr;
                $practice->status = $_oldPractice->Status;
                $practice->save();
                $question = new PracticeQuestions();
                $question->practice_id = $practice->id;
                $question->question = $_oldPractice->practice_questions->Question;
                $question->question_ar = $_oldPractice->practice_questions->QuestionAr;
                $question->question_in = $_oldPractice->practice_questions->QuestionIn;
                $question->respondent = $_oldPractice->practice_questions->Respondent;
                $question->status = $_oldPractice->practice_questions->Status;
                $question->IsENPS = $_oldPractice->practice_questions->IsENPS;
                $question->save();
            }
        }
        foreach ($data as $item) {


            // $function->save();
            //loop through the practices
            // foreach ($item['function_practices'] as $practice_) {
            //     $practice = new FunctionPractices();
            //     $practice->id = $practice_->id;
            //     $practice->function_id = $item->id;
            //     $practice->title = $practice_->PracticeTitle;
            //     $practice->title_ar = $practice_->PracticeTitleAr;
            //     $practice->status = $practice_->Status;
            //     // $practice->save();
            //     //loop through the questions
            //     foreach ($practice['practice_questions'] as $question_) {
            //         $question = new PracticeQuestions();
            //         $question->id = $question_->id;
            //         $question->practice_id = $question_->id;
            //         $question->question = $question_->Question;
            //         $question->question_ar = $question_->QuestionAr;
            //         // $question->save();
            //     }
            // }
        }
        dd("done");
        return redirect()->route('EmployeeEngagment.index');
    }
}
