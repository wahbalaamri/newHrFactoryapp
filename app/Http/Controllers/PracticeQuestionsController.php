<?php

namespace App\Http\Controllers;

use App\Models\PracticeQuestions;
use App\Http\Requests\StorePracticeQuestionsRequest;
use App\Http\Requests\UpdatePracticeQuestionsRequest;

class PracticeQuestionsController extends Controller
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
    public function store(StorePracticeQuestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PracticeQuestions $practiceQuestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PracticeQuestions $practiceQuestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePracticeQuestionsRequest $request, PracticeQuestions $practiceQuestions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PracticeQuestions $practiceQuestions)
    {
        //
    }
     //setup question from https://3h.hrfactoryapp.com/question/getq
    function setup()
    {
        //read the question from the url
        $url = "https://3h.hrfactoryapp.com/question/getq";
        $json = file_get_contents($url);
        $data=json_decode($json);
        //loop through the data
        foreach($data as $item){
            //create a new question
            $question = new PracticeQuestions();
            $question->id = $item->id;
            $question->question = $item->Question;
            $question->question_ar = $item->QuestionAr;
            $question->respondent = $item->Respondent;
            $question->status = $item->Status;
            $question->IsENPS = $item->IsENPS==1;
            $question->practice_id=$item->PracticeId;
            $question->save();
        }
        //redirect to the index page
        return redirect()->route('EmployeeEngagment.index');
    }
}
