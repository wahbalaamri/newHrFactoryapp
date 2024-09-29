<?php

namespace App\Http\Controllers;

use App\Models\CustomizedSurveyFunctions;
use App\Models\CustomizedSurveyPractices;
use App\Models\CustomizedSurveyQuestions;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomizedSurveyController extends Controller
{
    //
    function Functions($client, $survey_id)
    {

        try {
            //get all functions of the HR Diagnosis
            $functions = CustomizedSurveyFunctions::where('survey', $survey_id)->where('client', $client)->get();
            //find survey
            $survey = Surveys::find($survey_id);
            //service
            $service_type = $survey->plans->service_->service_type;
            $data = [
                'functions' => $functions,
                'client' => $client,
                'survey' => $survey_id,
                'service_type' => $service_type,
            ];
            return view('dashboard.Customized.index')->with($data);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect('admin/dashboard')->with('error', $e->getMessage());
        }
    }
    //createFunction
    function createFunction(Request $request, $client, $survey)
    {
        //can create new function
        if (Auth::user()->can('create', new CustomizedSurveyFunctions)) {
            $data = [
                'function' => null,
                'client' => $client,
                'survey' => $survey,
            ];
            //return view to create function
            return view('dashboard.Customized.edit')->with($data);
        } else {
            //abort
            abort(403);
        }
    }
    //storeFunction
    function storeFunction(Request $request, $client, $survey)
    {
        if (Auth::user()->can('create', new CustomizedSurveyFunctions)) {
            try {
                //store function
                $function = new CustomizedSurveyFunctions();
                $function->client = $client;
                $function->survey = $survey;
                $function->title = $request->title;
                $function->title_ar = $request->title_ar;
                $function->description = $request->description;
                $function->description_ar = $request->description_ar;
                $function->respondent = $request->respondent;
                $function->IsDriver = $request->IsDriver != null;
                $function->status = $request->status != null;
                $function->save();
                return redirect()->route('CustomizedSurvey.Functions')->with('success', 'Function created successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            //abort
            abort(403);
        }
    }
    //showPractices function
    function showPractices($id)
    {
        $function = CustomizedSurveyFunctions::find($id);
        if (Auth::user()->can('view', $function)) {
            try {
                //get all practices of the function
                $data = [
                    'function' => $function,
                    'client' => $function->client,
                    'survey' => $function->survey,
                ];
                return view('dashboard.Customized.showPractices')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            //abort
            abort(403);
        }
    }
    //createPractice function
    function createPractice($id)
    {
        if (Auth::user()->can('create', new CustomizedSurveyPractices)) {
            try {
                //return view to create practice
                $function = CustomizedSurveyFunctions::find($id);
                $data = [
                    'function' => $function,
                    'practice' => null,
                ];
                return view('dashboard.Customized.editPractice')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //storePractice function
    function storePractice(Request $request, $id)
    {
        if (Auth::user()->can('create', new CustomizedSurveyPractices)) {
            try {
                //store practice
                $practice = new CustomizedSurveyPractices();
                $practice->title = $request->title;
                $practice->title_ar = $request->title_ar;
                $practice->description = $request->description;
                $practice->description_ar = $request->description_ar;
                $practice->status = $request->status != null;
                $practice->function_id = $id;
                $practice->save();
                return redirect()->route('CustomizedSurvey.showPractices', $id)->with('success', 'Practice created successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //showQuestions function
    function showQuestions($id)
    {
        $practice = CustomizedSurveyPractices::find($id);
        if (Auth::user()->can('view', $practice)) {
            try {
                //get all questions of the practice
                $data = [
                    'practice' => $practice,
                ];
                return view('dashboard.Customized.showQuestions')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //createQuestion function
    function createQuestion($id)
    {
        if (Auth::user()->can('create', new CustomizedSurveyQuestions)) {
            try {
                //return view to create question
                $practice = CustomizedSurveyPractices::find($id);
                $data = [
                    'practice' => $practice,
                    'question' => null,
                ];
                return view('dashboard.Customized.editQuestion')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //storeQuestion function
    function storeQuestion(Request $request, $id)
    {
        if (Auth::user()->can('create', new CustomizedSurveyQuestions)) {
            try {
                //store question
                $question = new CustomizedSurveyQuestions();
                $question->question = $request->question;
                $question->question_ar = $request->question_ar;
                $question->description = $request->description;
                $question->description_ar = $request->description_ar;
                $question->respondent = $request->respondent;
                $question->status = $request->status != null;
                $question->practice_id = $id;
                $question->IsENPS = $request->IsENPS == null ? false : true;
                $question->save();
                return redirect()->route('CustomizedSurvey.showQuestions', $id)->with('success', 'Question created successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editQuestion function
    function editQuestion($id)
    {
        $question = CustomizedSurveyQuestions::find($id);
        if (Auth::user()->can('update', $question)) {
            try {
                //return view to edit question
                //practice
                $practice = CustomizedSurveyPractices::find($question->practice_id);
                $data = [
                    'practice' => $practice,
                    'question' => $question,
                ];
                return view('dashboard.Customized.editQuestion')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updateQuestion function
    function updateQuestion(Request $request, $id)
    {
        $question = CustomizedSurveyQuestions::find($id);
        if (Auth::user()->can('update', $question)) {
            try {
                //update question
                $question->question = $request->question;
                $question->question_ar = $request->question_ar;
                $question->description = $request->description;
                $question->description_ar = $request->description_ar;
                $question->IsENPS = $request->IsENPS == null ? false : true;
                $question->respondent = $request->respondent;
                $question->status = $request->status != null;
                $question->save();
                return redirect()
                    ->route('CustomizedSurvey.showQuestions', $question->practice_id)
                    ->with('success', 'Question updated successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id)
    {
        $question = CustomizedSurveyQuestions::find($id);
        if (Auth::user()->can('delete', $question)) {
            try {
                //delete question
                $practice_id = $question->practice_id;
                $question->delete();
                return redirect()->route('CustomizedSurvey.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editPractice function
    function editPractice($id)
    {
        $practice = CustomizedSurveyPractices::find($id);
        if (Auth::user()->can('update', $practice)) {
            try {
                //return view to edit practice
                //function
                $function = CustomizedSurveyFunctions::find($practice->function_id);
                $data = [
                    'function' => $function,
                    'practice' => $practice,
                ];
                return view('dashboard.Customized.editPractice')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updatePractice function
    function updatePractice(Request $request, $id)
    {
        $practice = CustomizedSurveyPractices::find($id);
        if (Auth::user()->can('update', $practice)) {
            try {
                //update practice
                $practice->title = $request->title;
                $practice->title_ar = $request->title_ar;
                $practice->description = $request->description;
                $practice->description_ar = $request->description_ar;
                $practice->status = $request->status != null;
                $practice->save();
                return redirect()
                    ->route('CustomizedSurvey.showPractices', $practice->function_id)
                    ->with('success', 'Practice updated successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id)
    {
        $practice = CustomizedSurveyPractices::find($id);
        if (Auth::user()->can('delete', $practice)) {
            try {
                //delete practice
                $function_id = $practice->function_id;
                //delete all questions of the practice
                $practice->questions()->delete();
                $practice->delete();
                return redirect()->route('CustomizedSurvey.showPractices', $function_id)->with('success', 'Practice deleted successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editFunction function
    function editFunction($id)
    {
        $function = CustomizedSurveyFunctions::find($id);
        if (Auth::user()->can('update', $function)) {
            try {
                //return view to edit function
                $data = [
                    'function' => $function,
                    'client' => $function->client,
                    'survey' => $function->survey,
                ];
                return view('dashboard.Customized.edit')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updateFunction function
    function updateFunction(Request $request, $id)
    {
        $function = CustomizedSurveyFunctions::find($id);
        if (Auth::user()->can('update', $function)) {
            try {
                //update function
                $function->title = $request->title;
                $function->title_ar = $request->title_ar;
                $function->description = $request->description;
                $function->description_ar = $request->description_ar;
                $function->respondent = $request->respondent;
                $function->status = $request->status != null;
                $function->IsDriver = $request->IsDriver != null;
                $function->save();

                return redirect()->route('CustomizedSurvey.index')->with('success', 'Function updated successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id)
    {
        $function = CustomizedSurveyFunctions::find($id);
        if (Auth::user()->can('delete', $function)) {
            try {
                //delete function
                $service_id = $function->service_id;
                //delete all questions of the function
                $function->practices->each(function ($practice) {
                    $practice->questions()->delete();
                    $practice->delete();
                });
                $function->delete();
                return redirect()->route('CustomizedSurvey.index')->with('success', 'Function deleted successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
}
