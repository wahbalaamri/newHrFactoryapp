<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\SurveysPrepration;

class ManageEmployeeEngagmentController extends Controller
{
    //
    private $survey;
    private $service_type = 3;
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
        return $this->survey->createFunction($request,$this->service_type);
    }
    //storeFunction
    function storeFunction(Request $request)
    {
        return $this->survey->storeFunction($request,$this->service_type);

    }
    //showPractices function
    function showPractices($id)
    {
        return $this->survey->showPractices($id,$this->service_type);
    }
    //createPractice function
    function createPractice($id)
    {
        return $this->survey->createPractice($id,$this->service_type);
    }
    //storePractice function
    function storePractice(Request $request, $id)
    {
        return $this->survey->storePractice($request, $id,$this->service_type);
    }
    //showQuestions function
    function showQuestions($id)
    {
        return $this->survey->showQuestions($id,$this->service_type);
    }
    //createQuestion function
    function createQuestion($id)
    {
        return $this->survey->createQuestion($id,$this->service_type);
    }
    //storeQuestion function
    function storeQuestion(Request $request, $id)
    {
        return $this->survey->storeQuestion($request, $id,$this->service_type);
    }
    //editQuestion function
    function editQuestion($id)
    {
        return $this->survey->editQuestion($id,$this->service_type);
    }
    //updateQuestion function
    function updateQuestion(Request $request, $id)
    {
        return $this->survey->updateQuestion($request, $id,$this->service_type);
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id)
    {
        return $this->survey->deleteQuestion($request, $id,$this->service_type);
    }
    //editPractice function
    function editPractice($id)
    {
        return $this->survey->editPractice($id,$this->service_type);
    }
    //updatePractice function
    function updatePractice(Request $request, $id)
    {
        return $this->survey->updatePractice($request, $id,$this->service_type);
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id)
    {
        return $this->survey->destroyPractice($request, $id,$this->service_type);
    }
    //editFunction function
    function editFunction($id)
    {
        return $this->survey->editFunction($id,$this->service_type);
    }
    //updateFunction function
    function updateFunction(Request $request, $id)
    {
        return $this->survey->updateFunction($request, $id,$this->service_type);
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id)
    {
        return $this->survey->destroyFunction($request, $id,$this->service_type);
    }
}
