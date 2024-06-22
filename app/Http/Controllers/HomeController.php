<?php

namespace App\Http\Controllers;

use App\Http\SurveysPrepration;
use App\Jobs\SetupUsersIdInUsersOldSections;
use App\Models\Content;
use App\Models\FunctionPractices;
use App\Models\Functions;
use App\Models\PracticeQuestions;
use App\Models\Services;
use App\Models\User;
use App\Models\UserPlans;
use App\Models\UserSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contents = Content::where('page', '=', 'home')->get();
        $data = [
            'contents' => $contents,
            'services' => Services::where('public_availability', true)->get()
        ];
        return view('home.index')->with($data);
    }
    public function aboutus()
    {
        //aboutus
        $contents = Content::where('page', '=', 'aboutus')->get();
        $data = [
            'contents' => $contents
        ];
        return view('home.about-us')->with($data);
    }

    function CheckUser()
    {
        if (Auth()->check()); {
            //redirect to some route
            if (Auth()->user()->isAdmin == 1 || Auth()->user()->user_type == 'partner')
                return redirect()->route('admin.dashboard');
            else
                return redirect()->route('client.dashboard');
        }
    }
    function dashboard()
    {
        if (Auth()->user()->user_type == 'client') {
            return redirect()->route('client.dashboard');
        }
        $contents = Content::where('page', '=', 'login')->get();
        $data = [
            'contents' => $contents
        ];
        return view('dashboard.admin.index')->with($data);
    }
    function client()
    {
        if (Auth()->user()->user_type != 'client') {
            return redirect()->route('admin.dashboard');
        }
        //get active userplans subscriptions
        $active_sub = UserPlans::where([['IsActive', true], ['UserId', Auth()->user()->id]])->get();
        //get notactive userplans subscriptions
        $notactive_sub = UserPlans::where([['IsActive', false], ['UserId', Auth()->user()->id]])->get();
        $data = [
            'active_sub' => $active_sub,
            'notactive_sub' => $notactive_sub
        ];
        return view('dashboard.client.index')->with($data);
    }
    function setupUsrPlans()
    {
        //call SetupUsersIdInUsersOldSections
        $job = new SetupUsersIdInUsersOldSections();
        dispatch($job);
        return "Done";
    }
    function viewTool($id)
    {
        //get a service
        $service = Services::find($id);
        $data = [
            'service' => $service
        ];
        return view('home.view-tool')->with($data);
    }
    //manage function
    public function manage(SurveysPrepration $surveysPrepration)
    {
        //get all surveys
        return $surveysPrepration->manage(Auth()->user()->client_id);
    }
    public function SetupNameRev()
    {
        $service_type = 6; //HR Diagnosis =4, 360 reviwe =5 , 360 reviwe name =6
        ini_set('max_execution_time', 420);
        //find service of type 6
        $service = Services::where('service_type',  $service_type)->first();
        //read functions from https://hrtools.hrfactoryapp.com/GetFunctions
        $urlf = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/function/getf" : "https://hrtools.hrfactoryapp.com/GetFunctions";
        $jsonf = file_get_contents($urlf);
        $dataf = json_decode($jsonf, true);
        //loop through functions
        foreach ($dataf as $function) {
            //check if function exists
            $function1 = Functions::where('title', $function['FunctionTitle'])->whereIn('service_id', function ($query) {
                $query->select('id')
                    ->from('services')
                    ->where('service_type', 5);
            })->get();
            if ($function1->count() <= 0) {
                //create function
                Log::info($function);
                $f = new Functions();
                $f->title = $function['FunctionTitle'];
                $f->title_ar = $function['FunctionTitleAr'];
                $f->respondent = $function['Respondent'];
                $f->service_id = $service->id;
                $f->status = 1;
                $f->IsDefault =  $function['IsDefault'] == 1 ? true : false;
                $f->IsDriver =  array_key_exists('IsDriver', $function) ? ($function['IsDriver'] == 1 ? true : false) : false;
                $f->save();
                //read practices from https://hrtools.hrfactoryapp.com/GetPractices/
                $urlp = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/practice/getp/" . $function['id'] : "https://hrtools.hrfactoryapp.com/GetPractices/" . $function['id'];
                $jsonp = file_get_contents($urlp);
                $datap = json_decode($jsonp, true);
                //loop through practices
                foreach ($datap as $practice) {
                    if (!FunctionPractices::where('title', $practice['PracticeTitle'])->exists()) {
                        //create practice
                        $p = new FunctionPractices();
                        $p->title = $practice['PracticeTitle'];
                        $p->title_ar = $practice['PracticeTitleAr'];
                        $p->status = true;
                        $p->function_id = $f->id;
                        $p->save();
                        //read surveys from https://hrtools.hrfactoryapp.com/GetQuestion/
                        $urls = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/question/getq/" . $practice['id'] : "https://hrtools.hrfactoryapp.com/GetQuestion/" . $practice['id'];
                        $jsons = file_get_contents($urls);
                        $datas = json_decode($jsons, true);
                        //loop through surveys
                        foreach ($datas as $question) {
                            //create survey
                            if (PracticeQuestions::where('question', $question['Question'])->doesntExist()) {
                                $s = new PracticeQuestions();
                                $s->question = $question['Question'];
                                $s->question_ar = $question['QuestionAr'];
                                $s->respondent = $question['Respondent'];
                                $s->IsENPS = array_key_exists('IsENPS', $question) ? $question['IsENPS'] : false;
                                $s->practice_id = $p->id;
                                $s->status = true;
                                $s->save();
                            }
                        }
                    }
                }
            } else {
                Log::info($function);
                //read practices from https://hrtools.hrfactoryapp.com/GetPractices/
                $urlp = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/practice/getp/" . $function['id'] : "https://hrtools.hrfactoryapp.com/GetPractices/" . $function['id'];
                $jsonp = file_get_contents($urlp);
                $datap = json_decode($jsonp, true);
                //loop through practices
                foreach ($datap as $practice) {
                    if (!FunctionPractices::where('title', $practice['PracticeTitle'])->where('function_id', $function1->first()->id)->exists()) {
                        //create practice
                        $p = new FunctionPractices();
                        $p->title = $practice['PracticeTitle'];
                        $p->title_ar = $practice['PracticeTitleAr'];
                        $p->status = true;
                        $p->function_id = $function1->first()->id;
                        $p->save();
                        //read surveys from https://hrtools.hrfactoryapp.com/GetQuestion/
                        $urls = $service_type == 4 ? "https://diagnosis.hrfactoryapp.com/question/getq/" . $practice['id'] : "https://hrtools.hrfactoryapp.com/GetQuestion/" . $practice['id'];
                        $jsons = file_get_contents($urls);
                        $datas = json_decode($jsons, true);
                        //loop through surveys
                        foreach ($datas as $question) {
                            //create survey
                            if (PracticeQuestions::where('question', $question['Question'])->where('practice_id', $p->id)->doesntExist()) {
                                $s = new PracticeQuestions();
                                $s->question = $question['Question'];
                                $s->question_ar = $question['QuestionAr'];
                                $s->respondent = $question['Respondent'];
                                $s->IsENPS = array_key_exists('IsENPS', $question) ? $question['IsENPS'] : false;
                                $s->practice_id = $p->id;
                                $s->status = true;
                                $s->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
