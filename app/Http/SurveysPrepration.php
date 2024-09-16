<?php

namespace App\Http;

use App\Exports\SurveyAnswersExport;
use App\Http\Facades\Landing;
use App\Jobs\SendAccountInfoJob;
use App\Jobs\SendSurvey;
use App\Models\CustomizedSurveyFunctions;
use App\Models\CustomizedSurveyPractices;
use App\Models\PlansPrices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\{Clients, ClientSubscriptions, Functions, Services, FunctionPractices, Industry, Plans, PracticeQuestions, Sectors, Surveys, Companies, CustomizedSurvey, CustomizedSurveyAnswers, CustomizedSurveyQuestions, CustomizedSurveyRaters, CustomizedSurveyRespondents, Departments, EmailContents, Employees, PrioritiesAnswers, Respondents, SurveyAnswers, Raters, User};
use Carbon\Carbon;
use Str;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\UploadEmployeeData;
use App\Jobs\UploadOrgChart;

class SurveysPrepration
{
    //
    private $id;
    private $ids = [];
    function index($service_type)
    {
        Log::info('1');
        try {
            //get all functions of the HR Diagnosis
            $functions = Functions::where('service_id', function ($querey) use ($service_type) {
                $querey->select('id')->from('services')->where('service_type', $service_type)->first()->id;
            })->get();
            Log::info('1ss');
            $data = [
                'functions' => $functions,
                'service_type' => $service_type,
            ];
            Log::info($functions);
            return view('dashboard.ManageHrDiagnosis.index')->with($data);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect('admin/dashboard')->with('error', $e->getMessage());
        }
    }
    //createFunction
    function createFunction(Request $request, $service_type)
    {
        //can create new function
        if (Auth::user()->can('create', new Functions)) {
            $data = [
                'function' => null,
                'service_type' => $service_type,
            ];
            //return view to create function
            return view('dashboard.ManageHrDiagnosis.edit')->with($data);
        } else {
            //abort
            abort(403);
        }
    }
    //storeFunction
    function storeFunction(Request $request, $service_type)
    {
        if (Auth::user()->can('create', new Functions)) {
            try {
                //store function
                $function = new Functions();
                $function->title = $request->title;
                $function->title_ar = $request->title_ar;
                $function->description = $request->description;
                $function->description_ar = $request->description_ar;
                $function->respondent = $request->respondent;
                if ($service_type == 3 || $service_type == 10) {
                    $function->IsDriver = $request->IsDriver != null;
                }
                $function->status = $request->status != null;
                $function->service_id = Services::select('id')->where('service_type', $service_type)->first()->id;
                $function->save();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function created successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.index')->with('success', 'Function created successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.index')->with('success', 'Function created successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.index')->with('success', 'Function created successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            //abort
            abort(403);
        }
    }
    //showPractices function
    function showPractices($id, $service_type)
    {
        $function = Functions::find($id);
        if (Auth::user()->can('view', $function)) {
            try {
                //get all practices of the function
                $data = [
                    'function' => $function,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.showPractices')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            //abort
            abort(403);
        }
    }
    //createPractice function
    function createPractice($id, $service_type)
    {
        if (Auth::user()->can('create', new FunctionPractices)) {
            try {
                //return view to create practice
                $function = Functions::find($id);
                $data = [
                    'function' => $function,
                    'practice' => null,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.editPractice')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //storePractice function
    function storePractice(Request $request, $id, $service_type)
    {
        if (Auth::user()->can('create', new FunctionPractices)) {
            try {
                //store practice
                $practice = new FunctionPractices();
                $practice->title = $request->title;
                $practice->title_ar = $request->title_ar;
                $practice->description = $request->description;
                $practice->description_ar = $request->description_ar;
                $practice->status = $request->status != null;
                $practice->function_id = $id;
                $practice->save();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.showPractices', $id)->with('success', 'Practice created successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.showPractices', $id)->with('success', 'Practice created successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.showPractices', $id)->with('success', 'Practice created successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.showPractices', $id)->with('success', 'Practice created successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //showQuestions function
    function showQuestions($id, $service_type)
    {
        $practice = FunctionPractices::find($id);
        if (Auth::user()->can('view', $practice)) {
            try {
                //get all questions of the practice
                $data = [
                    'practice' => $practice,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.showQuestions')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //createQuestion function
    function createQuestion($id, $service_type)
    {
        if (Auth::user()->can('create', new PracticeQuestions)) {
            try {
                //return view to create question
                $practice = FunctionPractices::find($id);
                $data = [
                    'practice' => $practice,
                    'question' => null,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.editQuestion')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //storeQuestion function
    function storeQuestion(Request $request, $id, $service_type)
    {
        if (Auth::user()->can('create', new PracticeQuestions)) {
            try {
                //store question
                $question = new PracticeQuestions();
                $question->question = $request->question;
                $question->question_ar = $request->question_ar;
                $question->description = $request->description;
                $question->description_ar = $request->description_ar;
                $question->respondent = $request->respondent;
                $question->status = $request->status != null;
                $question->practice_id = $id;
                if ($service_type == 3 || $service_type == 10) {
                    $question->IsENPS = $request->IsENPS == null ? false : true;
                }
                $question->save();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.showQuestions', $id)->with('success', 'Question created successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.showQuestions', $id)->with('success', 'Question created successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.showQuestions', $id)->with('success', 'Question created successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.showQuestions', $id)->with('success', 'Question created successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editQuestion function
    function editQuestion($id, $service_type)
    {
        $question = PracticeQuestions::find($id);
        if (Auth::user()->can('update', $question)) {
            try {
                //return view to edit question
                //practice
                $practice = FunctionPractices::find($question->practice_id);
                $data = [
                    'practice' => $practice,
                    'question' => $question,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.editQuestion')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updateQuestion function
    function updateQuestion(Request $request, $id, $service_type)
    {
        $question = PracticeQuestions::find($id);
        if (Auth::user()->can('update', $question)) {
            try {
                //update question
                $question->question = $request->question;
                $question->question_ar = $request->question_ar;
                $question->description = $request->description;
                $question->description_ar = $request->description_ar;
                if ($service_type == 3 || $service_type == 10) {
                    $question->IsENPS = $request->IsENPS == null ? false : true;
                }
                $question->respondent = $request->respondent;
                $question->status = $request->status != null;
                $question->save();
                if ($service_type == 4) {
                    return redirect()
                        ->route('ManageHrDiagnosis.showQuestions', $question->practice_id)
                        ->with('success', 'Question updated successfully');
                } elseif ($service_type == 3) {
                    return redirect()
                        ->route('EmployeeEngagment.showQuestions', $question->practice_id)
                        ->with('success', 'Question updated successfully');
                } elseif ($service_type == 10) {
                    return redirect()
                        ->route('CEmployeeEngagment.showQuestions', $question->practice_id)
                        ->with('success', 'Question updated successfully');
                } elseif ($service_type == 5) {
                    return redirect()
                        ->route('Leader360Review.showQuestions', $question->practice_id)
                        ->with('success', 'Question updated successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id, $service_type)
    {
        $question = PracticeQuestions::find($id);
        if (Auth::user()->can('delete', $question)) {
            try {
                //delete question
                $practice_id = $question->practice_id;
                $question->delete();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editPractice function
    function editPractice($id, $service_type)
    {
        $practice = FunctionPractices::find($id);
        if (Auth::user()->can('update', $practice)) {
            try {
                //return view to edit practice
                //function
                $function = Functions::find($practice->function_id);
                $data = [
                    'function' => $function,
                    'practice' => $practice,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.editPractice')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updatePractice function
    function updatePractice(Request $request, $id, $service_type)
    {
        $practice = FunctionPractices::find($id);
        if (Auth::user()->can('update', $practice)) {
            try {
                //update practice
                $practice->title = $request->title;
                $practice->title_ar = $request->title_ar;
                $practice->description = $request->description;
                $practice->description_ar = $request->description_ar;
                $practice->status = $request->status != null;
                $practice->save();
                if ($service_type == 4) {
                    return redirect()
                        ->route('ManageHrDiagnosis.showPractices', $practice->function_id)
                        ->with('success', 'Practice updated successfully');
                } elseif ($service_type == 3) {
                    return redirect()
                        ->route('EmployeeEngagment.showPractices', $practice->function_id)
                        ->with('success', 'Practice updated successfully');
                } elseif ($service_type == 10) {
                    return redirect()
                        ->route('CEmployeeEngagment.showPractices', $practice->function_id)
                        ->with('success', 'Practice updated successfully');
                } elseif ($service_type == 5) {
                    return redirect()
                        ->route('Leader360Review.showPractices', $practice->function_id)
                        ->with('success', 'Practice updated successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id, $service_type)
    {
        $practice = FunctionPractices::find($id);
        if (Auth::user()->can('delete', $practice)) {
            try {
                //delete practice
                $function_id = $practice->function_id;
                //delete all questions of the practice
                $practice->questions()->delete();
                $practice->delete();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.showPractices', $function_id)->with('success', 'Practice deleted successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.showPractices', $function_id)->with('success', 'Practice deleted successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.showPractices', $function_id)->with('success', 'Practice deleted successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.showPractices', $function_id)->with('success', 'Practice deleted successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //editFunction function
    function editFunction($id, $service_type)
    {
        $function = Functions::find($id);
        if (Auth::user()->can('update', $function)) {
            try {
                //return view to edit function
                $data = [
                    'function' => $function,
                    'service_type' => $service_type,
                ];
                return view('dashboard.ManageHrDiagnosis.edit')->with($data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //updateFunction function
    function updateFunction(Request $request, $id, $service_type)
    {
        $function = Functions::find($id);
        if (Auth::user()->can('update', $function)) {
            try {
                //update function
                $function->title = $request->title;
                $function->title_ar = $request->title_ar;
                $function->description = $request->description;
                $function->description_ar = $request->description_ar;
                $function->respondent = $request->respondent;
                $function->status = $request->status != null;
                if ($service_type == 3 || $service_type == 10) {
                    $function->IsDriver = $request->IsDriver != null;
                }
                $function->save();
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function updated successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.index')->with('success', 'Function updated successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.index')->with('success', 'Function updated successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.index')->with('success', 'Function updated successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id, $service_type)
    {
        $function = Functions::find($id);
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
                if ($service_type == 4) {
                    return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function deleted successfully');
                } elseif ($service_type == 3) {
                    return redirect()->route('EmployeeEngagment.index')->with('success', 'Function deleted successfully');
                } elseif ($service_type == 10) {
                    return redirect()->route('CEmployeeEngagment.index')->with('success', 'Function deleted successfully');
                } elseif ($service_type == 5) {
                    return redirect()->route('Leader360Review.index')->with('success', 'Function deleted successfully');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            abort(403);
        }
    }
    //add new survey function
    function editSurvey($id, $type, $survey = null)
    {
        $client = Clients::find($id);
        $service_id = Services::select('id')->where('service_type', $type)->first()->id;
        $plans = Plans::where([['service', $service_id], ['is_active', true]])->get();
        $plan = $plans->where('is_active', true)->first();
        $plans_id = $plans->pluck('id')->toArray();
        //get client active subscription
        $client_subscription = ClientSubscriptions::where([['client_id', $id], ['is_active', 1]])
            ->whereIn('plan_id', $plans_id)
            ->first();
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'plans' => $plans,
            'survey' => $survey,
            'client_subscription' => $client_subscription,
        ];
        return view('dashboard.client.editSurvey')->with($data);
    }
    function CreateOrUpdateSurvey(Request $request, $user_id, $service_type, $by_admin = false, $survey = null)
    {
        try {
            if ($survey == null) {
                $survey = new Surveys();
            }
            $survey->client_id = $user_id;
            $survey->plan_id = $request->h_plan_id;
            $survey->survey_title = $request->survey_title;
            $survey->survey_des = $request->survey_des;
            $survey->survey_stat = $request->survey_stat != null;
            $survey->save();
            if ($by_admin) {
                return redirect()
                    ->route('clients.ShowSurveys', [$user_id, $service_type])
                    ->with('success', 'Survey created successfully');
            } else {
                return redirect()
                    ->route('clients.ShowSurveys', [$user_id, $service_type])
                    ->with('success', 'Survey created successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function changeSurveyStat(Request $request, $user_id, $service_type, $survey_id, $by_admin = false)
    {
        try {
            $survey = Surveys::find($survey_id);
            $survey->survey_stat = $request->status == '1';
            $survey->save();
            //json response with status
            return response()->json(['status' => true, 'message' => 'Survey status changed successfully']);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    function surveyDetails($id, $type, $survey_id, $by_admin = false)
    {
        $survey = Surveys::find($survey_id);
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
        ];
        return view('dashboard.client.surveyDetails')->with($data);
    }
    function deleteSurvey($id, $type, $survey_id, $by_admin = false)
    {
        try {
            $survey = Surveys::find($survey_id);
            $survey->delete();
            return redirect()
                ->route('clients.ShowSurveys', [$id, $type])
                ->with('success', 'Survey deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //respondents function
    function respondents(Request $request, $id, $type, $survey_id)
    {
        $survey = Surveys::find($survey_id);
        $client = Clients::find($id);
        $survey_type = $survey->plans->service_->service_type;
        $is_candidate_raters = $survey->plans->service_->candidate_raters_model;
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client,
            'survey_type' => $survey_type,
            'survey_id' => $survey_id,
            'is_candidate_raters' => $is_candidate_raters,
        ];
        //if request is ajax
        if ($request->ajax()) {
            $respondents_ids = $survey->respondents->pluck('employee_id')->toArray();
            $candidate = Raters::where('survey_id', $survey_id)->get()->pluck('candidate_id')->toArray();
            //setup yajra datatable
            if ($is_candidate_raters) {
                $employees = $client->employeesData()->where('employee_type', 1)->get();
            } else {
                $employees = $client->employeesData()->get();
            }
            // $employees = Employees::where('client_id', $id)->get();
            //log employees as an array
            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($employee) {
                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteEmp(\'' . $employee->id . '\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                //hr
                ->addColumn('hr', function ($employee) {
                    return $employee->is_hr_manager ? '<span class="badge bg-success">' . __('HR Manager') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Manager') . '</span>';
                })
                ->addColumn('raters', function ($employee) use ($candidate) {
                    //button to show modal of Addraters
                    return in_array($employee->id, $candidate) ? '<a href="javascript:void(0);" onclick="AddRaters(\'' . $employee->id . '\')" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ratersModal">' . __('Raters') : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('result', function ($employee) use ($candidate, $survey_id) {
                    return in_array($employee->id, $candidate) ? '<a href="' . route('clients.candidateResult', [$employee->id, $survey_id]) . '" class="btn btn-info btn-xs">' . __('Result') . '<i class="fa fa-eye"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('service_type', function ($employee) use ($survey_type) {
                    return $survey_type;
                })
                ->addColumn('is_candidate_raters', function ($employee) use ($is_candidate_raters) {
                    return $is_candidate_raters;
                })
                ->addColumn('isAddedAsCandidate', function ($employee) use ($candidate) {
                    return in_array($employee->id, $candidate) ? true : false;
                })
                ->addColumn('isAddAsRespondent', function ($employee) use ($respondents_ids) {
                    return in_array($employee->id, $respondents_ids) ? true : false;
                })
                ->addColumn('SendSurvey', function ($employee) use ($respondents_ids, $survey_id, $id, $survey_type) {
                    //check if the survey sent to the employee
                    $emp_respondent = Respondents::where('survey_id', $survey_id)->where('employee_id', $employee->id)->first();
                    if ($emp_respondent) {
                        $send_status = $emp_respondent->send_status == null ? false : $emp_respondent->send_status;
                        $send_date = $send_status ? $emp_respondent->sent_date : null;
                        //fromat send_date
                        $send_date = Carbon::parse($send_date)->format('d-m-Y H:i');
                    } else {
                        $send_status = false;
                    }
                    $url_text = $send_status ? __('Sent') . ' ' . __('On ') . $send_date . ' Resend <i class="fa fa-paper-plane"></i>' : '<i class="fa fa-paper-plane"></i>';
                    return in_array($employee->id, $respondents_ids) ? '<a href="' . route('clients.showSendSurvey', [$id, $survey_type, $survey_id, 'i', $employee->id]) . '" class="btn btn-info btn-xs">' . $url_text . '</a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('SendReminder', function ($employee) use ($respondents_ids, $survey_id, $id, $survey_type) {
                    //check if the reminder sent to the employee
                    $emp_respondent = Respondents::where('survey_id', $survey_id)->where('employee_id', $employee->id)->first();
                    if ($emp_respondent) {
                        $reminder_status = $emp_respondent->reminder_status;
                        $reminder_date = $emp_respondent->reminder_date;
                        //fromat reminder_date
                        $reminder_date = Carbon::parse($reminder_date)->format('d-m-Y H:i');
                    } else {
                        $reminder_status = false;
                    }
                    $url_text = $reminder_status ? __('Sent') . ' ' . __('On ') . $reminder_date . ' Resend <i class="fa fa-paper-plane"></i>' : '<i class="fa fa-paper-plane"></i>';
                    return in_array($employee->id, $respondents_ids) ? '<a href="' . route('clients.showSendSurvey', [$id, $survey_type, $survey_id, 'ir', $employee->id]) . '" class="btn btn-warning btn-xs">' . $url_text . '</a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->rawColumns(['action', 'hr', 'SendSurvey', 'SendReminder', 'raters', 'result'])
                ->make(true);
        }
        return view('dashboard.client.respondents')->with($data);
    }
    //saveSCDS function
    function saveSCD(Request $request, $by_admin = false)
    {
        try {
            if ($request->type == 'sector') {
                //if sector id = other
                if ($request->_id == 'other') {
                    //create new sector
                    $Industry = new Industry();
                    $Industry->name = $request->name_en;
                    $Industry->name_ar = $request->name_ar;
                    $Industry->system_create = false;
                    $Industry->client_id = $request->client_id;
                    $Industry->save();
                    //create new sctore
                    $sector = new Sectors();
                    $sector->client_id = $request->client_id;
                    $sector->name_en = $request->name_en;
                    $sector->name_ar = $request->name_ar;
                    $sector->save();
                    //json response with status
                    return response()->json(['status' => true, 'message' => 'Sector created successfully', 'sector' => $sector]);
                } else {
                    //find the industry
                    $Industry = Industry::find($request->_id);
                    //create new sector
                    $sector = new Sectors();
                    $sector->client_id = $request->client_id;
                    $sector->name_en = $Industry->name;
                    $sector->name_ar = $Industry->name_ar;
                    $sector->save();
                    //json response with status
                    return response()->json(['status' => true, 'message' => 'Sector created successfully', 'sector' => $sector]);
                }
            }
            //type = comp
            elseif ($request->type == 'comp') {
                //create new company
                $company = new Companies();
                $company->client_id = $request->client_id;
                $company->sector_id = $request->_id;
                $company->name_en = $request->name_en;
                $company->name_ar = $request->name_ar;
                $company->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Company created successfully', 'company' => $company]);
            }
            //type = dep
            elseif ($request->type == 'dep') {
                $is_hr = false;
                if ($request->is_hr == 1 || $request->is_hr == true || $request->is_hr == 'true' || $request->is_hr == '1' || $request->is_hr == 'on' || $request->is_hr == 'yes' || $request->is_hr == 'checked' || $request->is_hr == 'selected' || $request->is_hr != false || $request->is_hr != 'false') {
                    $is_hr = true;
                }
                //create new department
                $department = new Departments();
                $department->company_id = $request->_id;
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                //is hr
                $department->is_hr = $is_hr;
                $department->dep_level = 0;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
            // type = sub-dep
            elseif ($request->type == 'sub-dep') {
                $is_hr = false;
                if ($request->is_hr == 1 || $request->is_hr == true || $request->is_hr == 'true' || $request->is_hr == '1' || $request->is_hr == 'on' || $request->is_hr == 'yes' || $request->is_hr == 'checked' || $request->is_hr == 'selected' || $request->is_hr != false || $request->is_hr != 'false') {
                    $is_hr = true;
                }
                if ($request->is_hr == false || $request->is_hr == 'false') {
                    $is_hr = false;
                }
                //find the department
                if ($request->_id != null) {
                    $p_department = Departments::find($request->_id);
                } else {
                    $p_department = null;
                }
                //if dep_id is null
                if ($request->dep_id == null) {
                    //create new department
                    $department = new Departments();
                } else {
                    //find the department
                    $department = Departments::find($request->dep_id);
                }
                if ($p_department != null) {
                    $department->company_id = $p_department->company_id;
                }
                if ($request->_id != null) {
                    $department->parent_id = $request->_id;
                }
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                if ($p_department != null) {
                    $department->parent_id = $p_department->id;
                    $department->dep_level = $p_department->dep_level + 1;
                }
                //is hr
                $department->is_hr = $is_hr;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //ShowCreateEmail function
    function ShowCreateEmail($id, $type, $survey_id, $by_admin = false)
    {
        $survey = Surveys::find($survey_id);
        $client = Clients::find($id);
        $emailContet = EmailContents::where([['survey_id', $survey_id], ['client_id', $id]])->first();
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client,
            'emailContet' => $emailContet,
        ];
        return view('dashboard.client.createEmail')->with($data);
    }
    //getClientLogo function
    function getClientLogo($id, $by_admin = false)
    {
        try {
            $client = Clients::find($id);
            return response()->json(['logo' => $client->logo_path]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }
    //storeSurveyEmail function
    function storeSurveyEmail(Request $request, $id, $type, $survey_id, $emailid = null, $by_admin = false)
    {
        try {
            //find client
            $client = Clients::find($id);

            //if Client_logo_status not null and client_logo has file
            if ($request->Client_logo_status != null && $request->hasFile('client_logo')) {
                $file = $request->file('client_logo');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/companies/logos'), $file_name);
                $client->logo_path = $file_name;
                $client->save();
            }

            //find email content

            if ($emailid == null) {
                $email = new EmailContents();
            } else {
                $email = EmailContents::find($emailid);
            }

            //check if survey_logo
            if ($request->hasFile('survey_logo')) {
                $file = $request->file('survey_logo');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/emails'), $file_name);
                $email->logo = $file_name;
            }
            $email->email_type = 'survey';
            $email->client_id = $id;
            $email->survey_id = $survey_id;
            $email->subject = $request->subject;
            $email->subject_ar = $request->subject_ar;
            $email->body_header = $request->email_body;
            $email->body_footer = $request->email_footer;
            $email->body_header_ar = $request->email_body_ar;
            $email->body_footer_ar = $request->email_footer_ar;
            $email->status = $request->status != null;
            $email->use_client_logo = $request->Client_logo_status != null;
            $email->save();
            if ($by_admin) {
                return redirect()
                    ->route('clients.ShowSurveys', [$id, $type])
                    ->with('success', 'Email created successfully');
            } else {
                return redirect()
                    ->route('clients.ShowSurveys', [$id, $type])
                    ->with('success', 'Email created successfully');
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //orgChart function
    function orgChart(Request $request, $id, $by_admin = false)
    {
        $client = Clients::find($id);
        $data = [
            'id' => $id,
            'client' => $client,
        ];
        if ($request->ajax()) {
            //setup yajra datatable
            $departments = $client->departments();
            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('action', function ($department) {
                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="EditDep(\'' . $department->id . '\',\'' . $department->parent_id . '\',\'' . $department->company->client_id . '\',\'sub-dep\')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></div>';
                    $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="EditDep(\'' . $department->id . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                ->addColumn('super_department', function ($department) {
                    return $department->parent_id == null ? 'No Super Parent' : (App()->getLocale() == 'en' ? $department->parent->name_en : $department->parent->name_ar);
                })
                ->addColumn('name', function ($department) {
                    return App()->getLocale() == 'en' ? $department->name_en : $department->name_ar;
                })
                ->addColumn('level', function ($department) {
                    return 'c-' . $department->dep_level;
                })
                ->addColumn('company', function ($department) {
                    return App()->getLocale() == 'en' ? $department->company->name_en : $department->company->name_ar;
                })
                ->addColumn('sector', function ($department) {
                    return App()->getLocale() == 'en' ? $department->company->sector->name_en : $department->company->sector->name_ar;
                })
                ->editColumn('is_hr', function ($department) {
                    return $department->is_hr ? '<span class="badge bg-success">' . __('HR Department') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Department') . '</span>';
                })
                ->rawColumns(['action', 'is_hr'])
                ->make(true);
        }
        return view('dashboard.client.orgChart.orgChart')->with($data);
    }
    // Employees function
    function Employees(Request $request, $id, $by_admin = false)
    {
        try {
            $client = Clients::find($id);
            $data = [
                'id' => $id,
                'client' => $client,
            ];
            $employees = $client->employeesData()->get();
            if ($request->ajax()) {
                //setup yajra datatable

                //log employees as an array
                return DataTables::of($employees)
                    ->addIndexColumn()
                    ->addColumn('action', function ($employee) {
                        $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="editEmp(\'' . $employee->id . '\')" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a></div>';
                        $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteEmp(\'' . $employee->id . '\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></div></div>';
                        return $action;
                    })
                    ->addColumn('type', function ($employee) {
                        return $employee->employee_type == 1 ? __('Manager') : __('Normal Employee');
                    })
                    ->addColumn('sector', function ($employee) {
                        return $employee->sector != null ? $employee->sector->Name : '-';
                    })
                    //hr
                    ->addColumn('hr', function ($employee) {
                        return $employee->is_hr_manager ? '<span class="badge bg-success">' . __('HR Manager') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Manager') . '</span>';
                    })
                    ->addColumn('company', function ($employee) {
                        return $employee->company != null ? (App()->getLocale() == 'en' ? $employee->company->name_en : $employee->company->name_ar) : '-';
                    })
                    ->editColumn('department', function ($employee) {
                        return $employee->department != null ? (App()->getLocale() == 'en' ? $employee->department->name_en : $employee->department->name_ar) : '-';
                    })
                    ->addColumn('active', function ($employee) {
                        return $employee->active ? '<span class="badge bg-success">' . __('Active') . '</span>' : '<span class="badge bg-danger">' . __('Not Active') . '</span>';
                    })
                    //add button assign as user
                    ->addColumn('assign', function ($employee) {
                        return '<a href="javascript:void(0);" onclick="assignUser(\'' . $employee->id . '\')" class="btn btn-info btn-xs">' . __('Assign as User') . '</a>';
                    })
                    ->rawColumns(['action', 'hr', 'active', 'name', 'assign'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return view('dashboard.client.Employees.showAll')->with($data);
    }
    //companies function
    function companies(Request $request, $id, $by_admin = false)
    {
        return Companies::where('sector_id', $id)->get()->append('name');
    }
    //departments function
    function departments(Request $request, $id, $type, $by_admin = false)
    {
        if ($type == 'r')
            return Departments::where('company_id', $id)->where('dep_level', 3)->get()->append('name');
        else
            return Departments::where('parent_id', $id)->get()->append('name');
    }
    //sections function
    function sections(Request $request, $id, $by_admin = false)
    {
        return Departments::where('parent_id', $id)->get()->append('name');
    }
    //storeEmployee function
    function storeEmployee(Request $request, $by_admin = false)
    {
        try {
            //create new employee
            if ($request->id == null) {
                $employee = new Employees();
            } else {
                $employee = Employees::find($request->id);
            }
            //get client
            $client = Clients::find($request->client_id);
            //check if client use department
            if ($client->use_departments) {
                //find department
                $department = Departments::find($request->department);
            } else {
                $department = null;
            }

            $employee->client_id = $request->client_id;
            $employee->sector_id = $request->sector;
            $employee->comp_id = $request->company;
            //check if client use department
            if ($client->use_departments) {
                //check if client use section
                if ($client->use_sections) {
                    $employee->dep_id = $request->section;
                } else {
                    $employee->dep_id = $request->department;
                }
            } else {
                $employee->dep_id = null;
            }
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->mobile = $request->mobile;
            $employee->employee_type = $request->type;
            $employee->position = $request->position;
            if ($client->use_department) {
                if ($department->is_hr && $request->type == 1) {
                    $employee->is_hr_manager = true;
                } else {
                    $employee->is_hr_manager = false;
                }
            } else {
                $employee->is_hr_manager = false;
            }
            $employee->added_by = 0;
            //save employee
            $employee->save();
            //json response with status
            return response()->json(['status' => true, 'message' => 'Employee created successfully', 'employee' => $employee]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //getEmployee function
    function getEmployee(Request $request, $id, $by_admin = false)
    {
        try {
            //find employee
            $employee = Employees::find($id);
            //json response with status
            return response()->json(['status' => true, 'employee' => $employee]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //getDepartment function
    function getDepartment(Request $request, $id, $by_admin = false)
    {
        try {
            //find department
            $department = Departments::find($id);
            //json response with status
            return response()->json(['status' => true, 'department' => $department]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //ShowSurveys function
    function ShowSurveys($id, $type, $by_admin = false)
    {
        $client = Clients::find($id);
        $departments = $client->departments();
        $service_id = Services::select('id')->where('service_type', $type)->first();
        //check if service_id is null
        if ($service_id == null) {
            return redirect()->route('services.index')->with('error', 'Service not found');
        }
        $service_id = $service_id->id;
        $plan_id = Plans::where('service', $service_id)->pluck('id')->toArray();
        $client_survyes = Surveys::where('client_id', $client->id)
            ->whereIn('plan_id', $plan_id)
            ->get();

        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'departments' => $departments,
            'client_survyes' => $client_survyes,
        ];
        return view('dashboard.client.Surveys')->with($data);
    }
    //saveSurveyRespondents function
    function saveSurveyRespondents(Request $request, $by_admin)
    {
        try {

            if ($request->tool_type != 'customized') { //check if ID from IDs is not added
                if ($request->isAll == 'all') {
                    //get all employee of the client
                    $employees = Employees::where('client_id', $request->client)->get();
                    //loop to add them into respondents
                    foreach ($employees as $employee) {
                        $respondent = Respondents::where('employee_id', $employee->id)
                            ->where([['survey_id', $request->survey], ['client_id', $request->client], ['survey_type', $request->type]])
                            ->first();
                        if ($respondent == null) {
                            $respondent1 = new Respondents();
                            $respondent1->employee_id = $employee->id;
                            $respondent1->survey_id = $request->survey;
                            $respondent1->client_id = $request->client;
                            $respondent1->survey_type = $request->type;
                            $respondent1->save();
                        }
                    }
                } else {
                    foreach ($request->ids as $idr) {
                        $respondent = Respondents::where('employee_id', $idr)
                            ->where([['survey_id', $request->survey], ['client_id', $request->client], ['survey_type', $request->type]])
                            ->first();
                        if ($respondent == null) {
                            $respondent1 = new Respondents();
                            $respondent1->employee_id = str($idr);
                            $respondent1->survey_id = $request->survey;
                            $respondent1->client_id = $request->client;
                            $respondent1->survey_type = $request->type;
                            $respondent1->save();
                        }
                    }
                }
                //get all respondents of the survey and client and type not in IDs
                $respondents = Respondents::where('survey_id', $request->survey)
                    ->where('client_id', $request->client)
                    ->where('survey_type', $request->type)
                    ->whereNotIn('employee_id', $request->ids)
                    ->get();
                $ready_to_delete = false;
                //delete all answers of each respondent in respondents
                if ($respondents->count() > 0 && $ready_to_delete) {
                    foreach ($respondents as $respondent) {
                        //delete all answers of the respondent
                        if ($request->type == 3 || $request->type == 4 || $request->type == 10) {
                            $answers = SurveyAnswers::where('answered_by', $respondent->id)->get();
                            foreach ($answers as $answer) {
                                $answer->delete();
                            }
                            if ($request->type == 4) {
                                $Panswers = PrioritiesAnswers::where('answered_by', $respondent->id)->get();
                                foreach ($Panswers as $answer) {
                                    $answer->delete();
                                }
                            }
                        }
                        if ($request->type == 5) {
                            $answers = SurveyAnswers::where('candidate', $respondent->id)
                                ->where('survey_id', $request->survey)
                                ->where('client_id', $request->client)
                                ->where('survey_type', $request->type)
                                ->get();
                            foreach ($answers as $answer) {
                                $answer->delete();
                            }
                        }
                        //delete the respondent
                        $respondent->delete();
                    }
                }
            } else {
                foreach ($request->ids as $idr) {
                    $respondent = CustomizedSurveyRespondents::where('employee_id', $idr)
                        ->where([['survey_id', $request->survey], ['client_id', $request->client], ['survey_type', $request->type]])
                        ->first();
                    if ($respondent == null) {
                        $respondent1 = new CustomizedSurveyRespondents();
                        $respondent1->employee_id = str($idr);
                        $respondent1->survey_id = $request->survey;
                        $respondent1->client_id = $request->client;
                        $respondent1->survey_type = $request->type;
                        $respondent1->save();
                    }
                }
                //get all respondents of the survey and client and type not in IDs
                $respondents = CustomizedSurveyRespondents::where('survey_id', $request->survey)
                    ->where('client_id', $request->client)
                    ->where('survey_type', $request->type)
                    ->whereNotIn('employee_id', $request->ids)
                    ->get();
                $ready_to_delete = false;
                //delete all answers of each respondent in respondents
                if ($respondents->count() > 0 && $ready_to_delete) {
                    foreach ($respondents as $respondent) {
                        //delete all answers of the respondent
                        if ($request->type == 3 || $request->type == 4 || $request->type == 10) {
                            $answers = CustomizedSurveyAnswers::where('answered_by', $respondent->id)->get();
                            foreach ($answers as $answer) {
                                $answer->delete();
                            }
                        }
                        if ($request->type == 5) {
                            $answers = CustomizedSurveyAnswers::where('candidate', $respondent->id)
                                ->where('survey_id', $request->survey)
                                ->where('client_id', $request->client)
                                ->where('survey_type', $request->type)
                                ->get();
                            foreach ($answers as $answer) {
                                $answer->delete();
                            }
                        }
                        //delete the respondent
                        $respondent->delete();
                    }
                }
            }
            //json response with status
            return response()->json(['status' => true, 'message' => 'Respondents added successfully']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            //return json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //manage function
    function manage($id, $by_admin = false)
    {
        //find client
        $client = Clients::find($id);
        return view('dashboard.client.manage', compact('id', 'client'));
    }
    //viewSubscriptions function
    function viewSubscriptions($id, $by_admin = false)
    {
        $client = Clients::find($id);
        $data = [
            'id' => $id,
            'client' => $client,
        ];
        //if request is ajax
        if (request()->ajax()) {
            //setup yajra datatable
            $subscriptions = $client->subscriptions();
            return DataTables::of($subscriptions)
                ->addIndexColumn()
                ->addColumn('action', function ($subscription) {
                    $action =
                        '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="editSub(\'' .
                        $subscription->id .
                        '\')" class="btn btn-primary btn-sm"><i class="fa fa-edit
                    "></i></a></div>';
                    $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteSub(\'' . $subscription->id . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                ->addColumn('service', function ($subscription) {
                    return $subscription->plan->service_->service_name;
                })
                ->addColumn('plan', function ($subscription) {
                    return $subscription->plan->plan_name;
                })
                ->editColumn('period', function ($subscription) {
                    return $subscription->period == 4 ? __('Annual') : __('Monthly');
                })
                ->editColumn('is_active', function ($subscription) {
                    return $subscription->is_active ? '<span class="badge bg-success">' . __('Active') . '</span>' : '<span class="badge bg-danger">' . __('Not Active') . '</span>';
                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
        return view('dashboard.client.subscrip')->with($data);
    }
    //saveSubscription function
    function saveSubscription(Request $request, $id, $by_admin = false)
    {

        try {
            //create new subscription
            if ($request->subscription == null) {
                $subscription = new ClientSubscriptions();
            } else {
                $subscription = ClientSubscriptions::find($request->subscription);
            }
            //find plan
            $plan = Plans::find($request->plan);
            //find client
            $client = Clients::find($id);
            //get plan price
            $planPrices = PlansPrices::where('plan', $plan->id)
                ->where('country', $client->country)
                ->first();
            $planPrices =
                $planPrices == null
                ? PlansPrices::where('plan', $plan->id)
                ->where('country', 155)
                ->first()
                : $planPrices;
            $price = $request->period == 4 ? $planPrices->annual_price : $planPrices->monthly_price;
            $subscription->client_id = $id;
            $subscription->plan_id = $request->plan;
            $subscription->period = $request->period;
            $subscription->paid_amount = $by_admin ? 0 : $price;
            $subscription->discount = !$by_admin ? 0 : $price;
            $subscription->start_date = $request->start_date;
            $subscription->end_date = $request->end_date;
            $subscription->is_active = $request->status != null ? ($request->status == false ? false : true) : false;
            $subscription->save();
            //json response with status
            return response()->json(['status' => true, 'message' => 'Subscription created successfully', 'subscription' => $subscription]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
    //sendSurvey function
    function showSendSurvey(Request $request, $id, $type, $survey_id, $send_type = null, $emp_id, $by_admin = false)
    {
        try {
            //show send survey view
            $survey = Surveys::find($survey_id);
            $client = Clients::find($id);
            $emailContet = EmailContents::where([['survey_id', $survey_id], ['client_id', $id]])->first();
            //get employee of type manager
            $candidate_ids = Raters::where('survey_id', $survey_id)->pluck('candidate_id')->toArray();
            $candidates = Employees::whereIn('id', $candidate_ids)->where('client_id', $id)->get();
            $data = [
                'id' => $id,
                'type' => $type,
                'survey' => $survey,
                'client' => $client,
                'emailContet' => $emailContet,
                'candidates' => $candidates,
                'send_type' => $send_type,
                'emp_id' => $emp_id,
            ];
            return view('dashboard.client.sendSurvey')->with($data);
        } catch (\Exception $e) {
            //return back with error

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //sendSurvey function
    function sendSurvey(Request $request, $id, $type, $survey_id, $send_type = null, $by_admin = false)
    {
        try {
            //find survey
            $survey = Surveys::find($survey_id);
            //find client
            $client = Clients::find($id);
            //find email content
            $emailContent = EmailContents::where([['survey_id', $survey_id], ['client_id', $id]])->first();
            $wherein = [];
            //build the where querey based on client selection of sector
            $where = [];
            if ($request->sector != null) {
                $where[] = ['sector_id', $request->sector];
            }
            if ($request->company != null) {
                $where[] = ['comp_id', $request->company];
            }
            if ($request->department != null) {

                $wherein[] = $this->getChilderenDepartmentIDs($request->department);
            }
            if ($type != 5 || $type != 6) { //get all respondents of the survey and client
                $emails = collect();
                if ($send_type == null) {
                    $respondents = Respondents::where('survey_id', $survey_id)->where('client_id', $id)->where('survey_type', $type)->where('send_status', false)->get();
                    //get all employees based on the where querey and id of respondents
                    $employees = Employees::select('email', 'id')->where($where)->whereIn('id', $respondents->pluck('employee_id')->toArray())->whereIn('dep_id', $this->ids)->get();
                    //create a collection of emails from $employees and ids from $respondents
                    foreach ($employees as $employee) {
                        $rid = $respondents->where('employee_id', $employee->id)->first()->id;
                        $emails->push(['email' => $employee->email, 'id' => $rid]);
                    }
                }
                if ($send_type == 'r') {
                    //get distinct answered_by as an array from survey_answers
                    $answered_by = SurveyAnswers::where('survey_id', $survey_id)->distinct('answered_by')->pluck('answered_by')->toArray();
                    //get employee_id from Respondent where id not in $answered_by
                    $respondents = Respondents::where('survey_id', $survey_id)->where('client_id', $id)->where('reminder_status', false)->whereNotIn('id', $answered_by)->pluck('employee_id')->toArray();
                    //get all employees based on the where querey and id of respondents
                    $employees = Employees::select('email', 'id')->where($where)->whereIn('id', $respondents)->get();
                    //create a collection of emails from $employees and ids from $respondents
                    foreach ($employees as $employee) {
                        $rid = Respondents::where('employee_id', $employee->id)->where('survey_id', $survey_id)->where('client_id', $id)->where('reminder_status', false)->first()->id;
                        $emails->push(['email' => $employee->email, 'id' => $rid]);
                    }
                }
                if ($send_type == 'i' || $send_type == 'ir') {
                    //get employee id from request
                    $employees = Employees::select('email', 'id')->where('id', $request->employee_id)->get();
                    //create a collection of emails from $employees and ids from $respondents
                    foreach ($employees as $employee) {
                        $rid = Respondents::where('employee_id', $employee->id)->where('survey_id', $survey_id)->where('client_id', $id)->first()->id;
                        $emails->push(['email' => $employee->email, 'id' => $rid]);
                    }
                }
                //capsolate all information in $data
                $data = [
                    'subject' => $emailContent->subject,
                    'subject_ar' => $emailContent->subject_ar,
                    'body_header' => $emailContent->body_header,
                    'body_footer' => $emailContent->body_footer,
                    'body_header_ar' => $emailContent->body_header_ar,
                    'body_footer_ar' => $emailContent->body_footer_ar,
                    'logo' => $emailContent->logo,
                    'client_logo' => $emailContent->use_client_logo ? $client->logo_path : null,
                    'type' => $type
                ];

                $job = (new SendSurvey($emails, $data, $send_type))->delay(now()->addSeconds(2));
                dispatch($job);
                Log::info("ggggddfuiuewu");
            } else {
                $rater_where = [];
                $rater_where[] = ['survey_id', $survey_id];
                $rater_where[] = ['client_id', $id];
                if ($request->raters != null || $request->raters != "ALL") {
                    $rater_where[] = ['type', $request->raters];
                }
                //get raters
                $raters = Raters::where($rater_where)->get();
                $employees = Employees::select('email', 'id')->where($where)->whereIn('id', $raters->pluck('rater_id')->toArray())->get();
                //create a collection of emails from $employees and ids from $respondents
                $emails = collect();
                foreach ($employees as $employee) {
                    $rater = $raters->where('rater_id', $employee->id)->first();
                    $respondent = Respondents::where('rater_id', $rater->id)->get()->first();
                    $emails->push(['email' => $employee->email, 'id' => $respondent->id, 'candidate_id', $rater->candidate_id]);
                    $name = $employee->name . '(' . $employee->position . ')';
                }
                $data = [
                    'subject' => $emailContent->subject . ' ' . $name,
                    'subject_ar' =>  $emailContent->subject_ar  . ' ' . $name,
                    'body_header' => `<b>This Assessed $name</b> <br>` . $emailContent->body_header,
                    'body_footer' => $emailContent->body_footer,
                    'body_header_ar' => `<b>This Assessed $name</b> <br>` . $emailContent->body_header_ar,
                    'body_footer_ar' => $emailContent->body_footer_ar,
                    'logo' => $emailContent->logo,
                    'client_logo' => $emailContent->use_client_logo ? $client->logo_path : null,
                    'type' => $type
                ];

                $job = (new SendSurvey($emails, $data, null))->delay(now()->addSeconds(2));
                dispatch($job);
            }
            //redirect to show surveys with success message
            return redirect()
                ->route('clients.surveyDetails', [$id, $type, $survey_id])
                ->with('success', 'Survey sent successfully');
        } catch (\Exception $e) {
            //return back with error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function getChilderenDepartmentIDs($id)
    {

        //find department
        $department = Departments::find($id);
        //check if deaortment has childeren
        if ($department->subDepartments->count() > 0) {

            //loop to get all children
            foreach ($department->subDepartments as $department) {
                $ids[] = $department->id;
                $this->getChilderenDepartmentIDs($department->id);
            }
        }
        //push id into $this->ids
        $this->ids[] = $id;
        return $id;
    }
    //SurveyResults function
    function SurveyResults($Client_id, $Service_type, $survey_id, $vtype, $vtype_id = null, $by_admin = false)
    {
        try {
            if ($Service_type == 3 || $Service_type == 10) {
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
                return view('dashboard.client.EESurveyresults')->with($data);
            }
            if ($Service_type == 4) {
                if ($vtype == "comp") {
                    $data = $this->company_results($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
                } elseif ($vtype == "sec") {
                    $data = $this->sector_results($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
                } else {
                    $data = $this->group_results($Client_id, $Service_type, $survey_id, $vtype, $vtype_id);
                }
                return view('dashboard.client.HrDiagnosis')->with($data);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function getDepartment3hResults($company, $dep_id, $Survey_id, $Client_id, $service_type, $dep_level)
    {
        //find department
        $data = [];
        $sub_data = [];
        $department = Departments::find($dep_id);
        //check if department has sub departments
        if ($department->subDepartments->count() > 0) {
            foreach ($department->subDepartments as $subDepartment) {
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
    public function get_resultd($Client_id, $service_type, $Survey_id, $type, $type_id = null)
    {

        $entity = '';
        $this->id = $Survey_id;
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
        // $data = [];
        // $service = Services::where('service_type', $service_type)->first()->id;
        // $functions = Functions::where('service_id', $service)->get();
        //     //append data from get_resultd to data array
        //     // $data = $data + $this->get_resultd($id, 'comp', $company->id);
        //     array_push($data, $this->get_resultd($Client_id, $service_type, $id, 'comp', $company->id));
        // }
        // $driver_functions = [];
        // $outcome_functions = [];
        // $ENPS_data_array1 = [];
        // $ENPS_data_array = [];
        // $practices = [];
        // $overall_per_fun = [];
        // $driver_functions_practice = [];
        // $outcome_function_results_1 = [];
        // $data_size = count($data);

        // foreach ($data as $singlData) {
        //     foreach ($singlData['drivers_functions'] as $driver) {
        //         array_push($driver_functions, $driver);
        //     }
        //     foreach ($singlData['outcomes'] as $outcome) {
        //         array_push($outcome_functions, $outcome);
        //     }
        //     // foreach ($singlData['ENPS_data_array'] as $ENPS) {
        //     array_push($ENPS_data_array, $singlData['ENPS_data_array']);
        //     // }
        //     foreach ($singlData['drivers'] as $practice) {
        //         array_push($practices, $practice);
        //     }
        // }
        // foreach ($functions as $function) {
        //     if ($function->IsDriver) {
        //         $function_results = [
        //             'function' => $function->id,
        //             'function_title' => $function->translated_title,
        //             'Nuetral_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'Favorable_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'UnFavorable_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Favorable answers
        //             'Favorable_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Nuetral answers
        //             'Nuetral_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //         ];
        //         array_push($overall_per_fun, $function_results);
        //         foreach ($function->practices as $practice) {
        //             $practice_results = [
        //                 'function' => $function->id,
        //                 'practice_id' => $practice->id,
        //                 'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
        //                 'Nuetral_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Nuetral_score') / $data_size,
        //                     ),
        //                 ),
        //                 'Favorable_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_score') / $data_size,
        //                     ),
        //                 ),
        //                 'UnFavorable_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_score') / $data_size,
        //                     ),
        //                 ),
        //                 //get count of Favorable answers
        //                 'Favorable_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_count') / $data_size,
        //                     ),
        //                 ),
        //                 //get count of UnFavorable answers
        //                 'UnFavorable_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_count') / $data_size,
        //                     ),
        //                 ),
        //                 //get count of Nuetral answers
        //                 'Nuetral_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Nuetral_count') / $data_size,
        //                     ),
        //                 ),
        //             ];
        //             array_push($driver_functions_practice, $practice_results);
        //         }
        //     } else {
        //         foreach ($function->practices as $practice) {
        //             if ($practice->questions->first()->IsENPS) {
        //                 $Favorable = floatval(
        //                     number_format(
        //                         collect($ENPS_data_array)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 );
        //                 $UnFavorable = floatval(
        //                     number_format(
        //                         collect($ENPS_data_array)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 );
        //                 $ENPS_data_array1 = [
        //                     'function' => $function->id,
        //                     'practice_id' => $practice->id,
        //                     'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
        //                     'Nuetral_score' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Nuetral_score') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of Favorable answers
        //                     'Favorable_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Favorable_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of UnFavorable answers
        //                     'UnFavorable_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('UnFavorable_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of Nuetral answers
        //                     'Nuetral_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Nuetral_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     'Favorable_score' => $Favorable,
        //                     'UnFavorable_score' => $UnFavorable,
        //                     'ENPS_index' => $Favorable - $UnFavorable,
        //                 ];
        //             }
        //         }
        //         $out_come_favorable = floatval(
        //             number_format(
        //                 collect($outcome_functions)
        //                     ->where('function', $function->id)
        //                     ->sum('Favorable_score') / $data_size,
        //                 2,
        //             ),
        //         );
        //         $out_come_unfavorable = floatval(
        //             number_format(
        //                 collect($outcome_functions)
        //                     ->where('function', $function->id)
        //                     ->sum('UnFavorable_score') / $data_size,
        //                 2,
        //             ),
        //         );
        //         //setup function_results
        //         $outcome_function_results = [
        //             'function' => $function->id,
        //             'function_title' => $function->translated_title,
        //             'Nuetral_score' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'Favorable_score' => $out_come_favorable,
        //             'UnFavorable_score' => $out_come_unfavorable,
        //             //get count of Favorable answers
        //             'Favorable_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Nuetral answers
        //             'Nuetral_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'outcome_index' => $out_come_favorable,
        //         ];
        //         array_push($outcome_function_results_1, $outcome_function_results);
        //     }
        // }
        // $heat_map = [];
        // $companies = Companies::where('sector_id', $type_id)->get();
        // foreach ($companies as $company) {
        //     $heat_map_indecators = [];
        //     $ENPS_Favorable = null;
        //     $ENPS_Pushed = false;
        //     $employees_id = Employees::where('comp_id', $company->id)
        //         ->pluck('id')
        //         ->all();
        //     $Emails = Respondents::where('survey_id', $this->id)
        //         ->whereIn('employee_id', $employees_id)
        //         ->pluck('id')
        //         ->all();
        //     $service = Services::where('service_type', $service_type)->first()->id;
        //     foreach (Functions::where('service_id', $service)->get() /* ->where('IsDriver', false) */ as $function) {
        //         //$sum_function_answer_value_Favorable_HM
        //         $function_Favorable_sum_HM = 0;
        //         $function_UnFavorable_sum_HM = 0;
        //         $function_Nuetral_sum_HM = 0;
        //         foreach ($function->practices as $practice) {
        //             $Favorable_result_HM = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
        //                 ->where([['survey_id', $this->id], ['answer_value', '>=', 4], ['question_id', $practice->questions->first()->id]])
        //                 ->whereIn('answered_by', $Emails)
        //                 ->first();
        //             $UnFavorable_result_HM = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
        //                 ->where([['survey_id', $this->id], ['answer_value', '<=', 2], ['question_id', $practice->questions->first()->id]])
        //                 ->whereIn('answered_by', $Emails)
        //                 ->first();
        //             $Nuetral_result_HM = SurveyAnswers::selectRaw('COUNT(answer_value) as count, SUM(answer_value) as sum')
        //                 ->where([['survey_id', $this->id], ['answer_value', 3], ['question_id', $practice->questions->first()->id]])
        //                 ->whereIn('answered_by', $Emails)
        //                 ->first();
        //             if ($Favorable_result_HM) {
        //                 $sum_answer_value_Favorable_HM = $Favorable_result_HM->sum;
        //                 $Favorable_count_HM = $Favorable_result_HM->count;
        //             } else {
        //                 $sum_answer_value_Favorable_HM = 0;
        //                 $Favorable_count = 0;
        //             }
        //             if ($UnFavorable_result_HM) {
        //                 $sum_answer_value_UnFavorable_HM = $UnFavorable_result_HM->sum;
        //                 $UnFavorable_count_HM = $UnFavorable_result_HM->count;
        //             } else {
        //                 $sum_answer_value_UnFavorable_HM = 0;
        //                 $UnFavorable_count_HM = 0;
        //             }
        //             if ($Nuetral_result_HM) {
        //                 $sum_answer_value_Nuetral_HM = $Nuetral_result_HM->sum;
        //                 $Nuetral_count_HM = $Nuetral_result_HM->count;
        //             } else {
        //                 $sum_answer_value_Nuetral_HM = 0;
        //                 $Nuetral_count_HM = 0;
        //             }
        //             if ($practice->questions->first()->IsENPS && $ENPS_Favorable == null) {
        //                 $ENPS_Favorable = $Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM == 0 ? 0 : number_format(($Favorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
        //                 $ENPS_UnFavorable = $Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM == 0 ? 0 : number_format(($UnFavorable_count_HM / ($Favorable_count_HM + $Nuetral_count_HM + $UnFavorable_count_HM)) * 100, 2);
        //             }
        //             $function_Favorable_sum_HM += $Favorable_count_HM;
        //             $function_UnFavorable_sum_HM += $UnFavorable_count_HM;
        //             $function_Nuetral_sum_HM += $Nuetral_count_HM;
        //         }
        //         $out_come_favorable_HM = $function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM == 0 ? 0 : number_format(($function_Favorable_sum_HM / ($function_Favorable_sum_HM + $function_Nuetral_sum_HM + $function_UnFavorable_sum_HM)) * 100, 2);
        //         if ($function->IsDriver) {
        //             $title = explode(' ', $function->FunctionTitle);
        //             $title = $title[0];
        //         } else {
        //             $title = 'Engagement';
        //         }
        //         $outcome_function_results_HM = [
        //             'function_title' => $title,
        //             'score' => $out_come_favorable_HM,
        //         ];
        //         array_push($heat_map_indecators, $outcome_function_results_HM);
        //         if ($ENPS_Favorable && !$ENPS_Pushed) {
        //             $ENPS_Pushed = true;
        //             $outcome_function_results_HM = [
        //                 'function_title' => $title,
        //                 'score' => $ENPS_Favorable - $ENPS_UnFavorable,
        //             ];
        //             array_push($heat_map_indecators, $outcome_function_results_HM);
        //         }
        //     }
        //     $heat_map_item = [
        //         'entity_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
        //         'entity_id' => $company->id,
        //         'indecators' => $heat_map_indecators,
        //     ];
        //     array_push($heat_map, $heat_map_item);
        // }
        // $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        // //sort $driver_functions_practice desc
        // $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        // $data = [
        //     'drivers' => $driver_functions_practice,
        //     'drivers_functions' => $overall_per_fun,
        //     'outcomes' => $outcome_function_results_1,
        //     'ENPS_data_array' => $ENPS_data_array1,
        //     'entity' => Sectors::find($type_id)->sector_name_en,
        //     'type' => $type,
        //     'type_id' => $type_id,
        //     'id' => $id,
        //     'driver_practice_asc' => $driver_functions_practice_asc,
        //     'driver_practice_desc' => $driver_functions_practice_desc,
        //     'heat_map' => $heat_map,
        //     'cal_type' => 'countD',
        // ];
        // return $data;
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
        // $data = [];
        // $client = Surveys::find($id)->clients;
        // $service = Services::where('service_type', $service_type)->first()->id;
        // $functions = Functions::where('service_id', $service)->get();
        // foreach ($client->sectors as $sector) {
        //     array_push($data, $this->get_SectorResult($Client_id, $service_type, $id, 'sec', $sector->id));
        // }
        // $driver_functions = [];
        // $outcome_functions = [];
        // $ENPS_data_array1 = [];
        // $ENPS_data_array = [];
        // $practices = [];
        // $overall_per_fun = [];
        // $driver_functions_practice = [];
        // $outcome_function_results_1 = [];
        // $data_size = count($data);
        // foreach ($data as $singlData) {
        //     foreach ($singlData['drivers_functions'] as $driver) {
        //         array_push($driver_functions, $driver);
        //     }
        //     foreach ($singlData['outcomes'] as $outcome) {
        //         array_push($outcome_functions, $outcome);
        //     }
        //     // foreach ($singlData['ENPS_data_array'] as $ENPS) {
        //     array_push($ENPS_data_array, $singlData['ENPS_data_array']);
        //     // }
        //     foreach ($singlData['drivers'] as $practice) {
        //         array_push($practices, $practice);
        //     }
        // }
        // foreach ($functions as $function) {
        //     if ($function->IsDriver) {
        //         $function_results = [
        //             'function' => $function->id,
        //             'function_title' => $function->translated_title,
        //             'Nuetral_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'Favorable_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'UnFavorable_score' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Favorable answers
        //             'Favorable_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Nuetral answers
        //             'Nuetral_count' => floatval(
        //                 number_format(
        //                     collect($driver_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //         ];
        //         array_push($overall_per_fun, $function_results);
        //         foreach ($function->practices as $practice) {
        //             $practice_results = [
        //                 'function' => $function->id,
        //                 'practice_id' => $practice->id,
        //                 'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
        //                 'Nuetral_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Nuetral_score') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //                 'Favorable_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //                 'UnFavorable_score' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //                 //get count of Favorable answers
        //                 'Favorable_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_count') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //                 //get count of UnFavorable answers
        //                 'UnFavorable_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_count') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //                 //get count of Nuetral answers
        //                 'Nuetral_count' => floatval(
        //                     number_format(
        //                         collect($practices)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Nuetral_count') / $data_size,
        //                         2,
        //                     ),
        //                 ),
        //             ];
        //             array_push($driver_functions_practice, $practice_results);
        //         }
        //     } else {
        //         foreach ($function->practices as $practice) {
        //             if ($practice->questions->first()->IsENPS) {
        //                 $Favorable = floatval(
        //                     number_format(
        //                         collect($ENPS_data_array)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('Favorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 );
        //                 $UnFavorable = floatval(
        //                     number_format(
        //                         collect($ENPS_data_array)
        //                             ->where('practice_id', $practice->id)
        //                             ->sum('UnFavorable_score') / $data_size,
        //                         2,
        //                     ),
        //                 );
        //                 $ENPS_data_array1 = [
        //                     'function' => $function->id,
        //                     'practice_id' => $practice->id,
        //                     'practice_title' => App()->getLocale() == 'en' ? $practice->title : $practice->title_ar,
        //                     'Nuetral_score' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Nuetral_score') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of Favorable answers
        //                     'Favorable_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Favorable_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of UnFavorable answers
        //                     'UnFavorable_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('UnFavorable_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     //get count of Nuetral answers
        //                     'Nuetral_count' => floatval(
        //                         number_format(
        //                             collect($ENPS_data_array)
        //                                 ->where('practice_id', $practice->id)
        //                                 ->sum('Nuetral_count') / $data_size,
        //                             2,
        //                         ),
        //                     ),
        //                     'Favorable_score' => $Favorable,
        //                     'UnFavorable_score' => $UnFavorable,
        //                     'ENPS_index' => $Favorable - $UnFavorable,
        //                 ];
        //             }
        //         }
        //         $out_come_favorable = floatval(
        //             number_format(
        //                 collect($outcome_functions)
        //                     ->where('function', $function->id)
        //                     ->sum('Favorable_score') / $data_size,
        //                 2,
        //             ),
        //         );
        //         $out_come_unfavorable = floatval(
        //             number_format(
        //                 collect($outcome_functions)
        //                     ->where('function', $function->id)
        //                     ->sum('UnFavorable_score') / $data_size,
        //                 2,
        //             ),
        //         );
        //         //setup function_results
        //         $outcome_function_results = [
        //             'function' => $function->id,
        //             'function_title' => $function->translated_title,
        //             'Nuetral_score' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_score') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'Favorable_score' => $out_come_favorable,
        //             'UnFavorable_score' => $out_come_unfavorable,
        //             //get count of Favorable answers
        //             'Favorable_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Favorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of UnFavorable answers
        //             'UnFavorable_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('UnFavorable_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             //get count of Nuetral answers
        //             'Nuetral_count' => floatval(
        //                 number_format(
        //                     collect($outcome_functions)
        //                         ->where('function', $function->id)
        //                         ->sum('Nuetral_count') / $data_size,
        //                     2,
        //                 ),
        //             ),
        //             'outcome_index' => $out_come_favorable,
        //         ];
        //         array_push($outcome_function_results_1, $outcome_function_results);
        //     }
        // }
        // $heat_map = [];

        // $sectors = Sectors::where('client_id', Surveys::find($id)->ClientId)->get();
        // foreach ($sectors as $sector) {
        //     $heat_map_indecators1 = [];
        //     $sector_heatMap = collect($data)
        //         ->where('type_id', $sector->id)
        //         ->first();
        //     $headAv = 0;
        //     $handAv = 0;
        //     $heartAv = 0;
        //     $outcomeAv = 0;
        //     $ENPSAv = 0;
        //     $headTitle = '';
        //     $handTitle = '';
        //     $heartTitle = '';
        //     $outcomeTitle = '';
        //     $ENPSTitle = '';
        //     foreach ($sector_heatMap['heat_map'] as $comp) {
        //         $headAv += $comp['indecators'][0]['score'];
        //         $handAv += $comp['indecators'][1]['score'];
        //         $heartAv += $comp['indecators'][2]['score'];
        //         $outcomeAv += $comp['indecators'][3]['score'];
        //         $ENPSAv += $comp['indecators'][4]['score'];
        //         $headTitle = $comp['indecators'][0]['function_title'];
        //         $handTitle = $comp['indecators'][1]['function_title'];
        //         $heartTitle = $comp['indecators'][2]['function_title'];
        //         $outcomeTitle = $comp['indecators'][3]['function_title'];
        //         $ENPSTitle = $comp['indecators'][4]['function_title'];
        //     }
        //     $outcome_function_results_HM1 = [
        //         'function_title' => $headTitle,
        //         'score' => floatval(number_format($headAv / count($sector_heatMap['heat_map']), 2)),
        //     ];
        //     array_push($heat_map_indecators1, $outcome_function_results_HM1);
        //     $outcome_function_results_HM1 = [
        //         'function_title' => $handTitle,
        //         'score' => floatval(number_format($handAv / count($sector_heatMap['heat_map']), 2)),
        //     ];
        //     array_push($heat_map_indecators1, $outcome_function_results_HM1);
        //     $outcome_function_results_HM1 = [
        //         'function_title' => $heartTitle,
        //         'score' => floatval(number_format($heartAv / count($sector_heatMap['heat_map']), 2)),
        //     ];
        //     array_push($heat_map_indecators1, $outcome_function_results_HM1);
        //     $outcome_function_results_HM1 = [
        //         'function_title' => $outcomeTitle,
        //         'score' => floatval(number_format($outcomeAv / count($sector_heatMap['heat_map']), 2)),
        //     ];
        //     array_push($heat_map_indecators1, $outcome_function_results_HM1);
        //     $outcome_function_results_HM1 = [
        //         'function_title' => $ENPSTitle,
        //         'score' => floatval(number_format($ENPSAv / count($sector_heatMap['heat_map']), 2)),
        //     ];
        //     array_push($heat_map_indecators1, $outcome_function_results_HM1);
        //     $heat_map_item1 = [
        //         'entity_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
        //         'entity_id' => $sector->id,
        //         'indecators' => $heat_map_indecators1,
        //     ];
        //     array_push($heat_map, $heat_map_item1);
        // }
        // $driver_functions_practice_asc = array_slice(collect($driver_functions_practice)->sortBy('Favorable_score')->toArray(), 0, 3);
        // //sort $driver_functions_practice desc
        // $driver_functions_practice_desc = array_slice(collect($driver_functions_practice)->sortByDesc('Favorable_score')->toArray(), 0, 3);
        // $data = [
        //     'drivers' => $driver_functions_practice,
        //     'drivers_functions' => $overall_per_fun,
        //     'outcomes' => $outcome_function_results_1,
        //     'ENPS_data_array' => $ENPS_data_array1,
        //     'entity' => $client->ClientName,
        //     'type' => $type,
        //     'type_id' => $type_id,
        //     'id' => $id,
        //     'driver_practice_asc' => $driver_functions_practice_asc,
        //     'driver_practice_desc' => $driver_functions_practice_desc,
        //     'heat_map' => $heat_map,
        //     'cal_type' => 'countD',
        //     'client_id' => $Client_id,
        //     'service_type' => $service_type

        // ];
        // return $data;
    }

    function company_results($Client_id, $Service_type, $id, $type, $type_id = null)
    {
        // $surveyEmails = Emails::where([['survey_id', $id], ['comp_id', $type_id]])->select(['id', 'EmployeeType'])->get();
        $surveyEmails = Respondents::select('respondents.id as id', 'employees.employee_type as EmployeeType')
            ->join('employees', 'respondents.employee_id', '=', 'employees.id')
            ->where('employees.comp_id', $type_id)
            ->where('respondents.survey_id', $id)
            ->get();
        if (count($surveyEmails) <= 0)
            return ['data_size' => 0];
        $surveyEmails_ids = $surveyEmails->pluck('id')->all();
        $SurveyResult = SurveyAnswers::where('survey_id', '=', $id)->whereIn('answered_by', $surveyEmails_ids)->select(['answer_value', 'question_id', 'answered_by'])->get();
        $scaleSize = 5;
        if ($SurveyResult->count() == 0 && $surveyEmails->count() == 0) {
            $data = [
                'leaders' => 1,
                'hr' => 1,
                'emp' => 1,
                'leaders_answers' => 0,
                'hr_answers' => 0,
                'emp_answers' => 0,
                'total' => 1,
                'total_answers' => 0 + 0 + 0,
            ];
            return view('SurveyAnswers.notComplet')->with($data);
        }
        $SurveyResult = $SurveyResult->map(function ($item, $key) {
            $item['answer_value'] = $item['answer_value'] - 1;
            return $item;
        });
        $leaders_email = array();
        $hr_teames_email = array();
        $employees_email = array();
        list($leaders_email, $hr_teames_email, $employees_email) = $this->newFunc($surveyEmails, $leaders_email, $hr_teames_email, $employees_email);

        $Answers_by_leaders = $SurveyResult->whereIn('answered_by', $leaders_email)->unique('answered_by')->count();
        $Answers_by_hr = $SurveyResult->whereIn('answered_by', $hr_teames_email)->unique('answered_by')->count();
        $Answers_by_emp = $SurveyResult->whereIn('answered_by', $employees_email)->unique('answered_by')->count();
        $HR_score = $SurveyResult->whereIn('answered_by', $hr_teames_email)->avg('answer_value');
        $Emp_score = $SurveyResult->whereIn('answered_by', $employees_email)->avg('answer_value');
        $Leaders_score = $SurveyResult->whereIn('answered_by', $leaders_email)->avg('answer_value');
        $_all_score = ($HR_score + $Emp_score + $Leaders_score) / 3;
        if ($Answers_by_leaders == 0 || $Answers_by_hr == 0)
            return ['data_size' => 0];
        $planID = Surveys::where('id', $id)->first()->plans->service;
        $functions = Functions::where('service_id', $planID)->select(['id', 'title_ar', 'title'])->get();
        Log::info($functions);
        $prioritiesRes = PrioritiesAnswers::where('survey_id', $id)->select(['answer_value', 'question_id', 'answered_by'])->get();
        // $avgxx = $SurveyResult->avg('answer_value');
        $overallResult = number_format(($_all_score / $scaleSize) * 100);

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
        foreach ($functions as $function) {
            $function_Lables[] = $function->translated_title;
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
                $allans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $leaders_email)->avg('answer_value');
                // leaders answers avg
                $leaders_ans_avg = $allans;
                //check if $allans has a value or just empty
                // if (!$leaders_had_answers)
                $leaders_had_answers = isset($allans) ? true : false;
                $answers = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $leaders_email);/* ->sum('answer_value') ;*/
                $leaders_Pract_w =  ($allans) / $scaleSize;
                $leaders_total += $leaders_Pract_w;
                // $leaders_Pract_wz =  ($allans) / $scaleSize;
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
                    ->whereIn('answered_by', $hr_teames_email)->avg('answer_value');
                // HrTeam answers avg
                $hr_ans_avg = $allans;
                // if (!$hr_had_answers)
                $hr_had_answers = isset($allans) ? true : false;
                $hr_practice_ans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)
                    ->whereIn('answered_by', $hr_teames_email);
                $hr_practice_weight =  round((($allans) / $scaleSize), 2);
                // $hr_practice_weightz =  round((($allans) / $scaleSize), 2);
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
                $allans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $employees_email)->avg('answer_value');
                // employees answers avg
                $emp_ans_avg = $allans;
                //check if employee group answer avg has value and assign flag
                // if (!$emp_had_answers)
                $emp_had_answers = isset($allans) ? true : false;
                Log::info("EMP: $allans");
                Log::info("emp_had_answers: $emp_had_answers");
                $emp_practice_ans = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $employees_email);
                // $emp_practice_ans_count = $SurveyResult->where('question_id', '=', $functionPractice->questions->first()->id)->whereIn('answered_by', $employees_email)->count();
                $emp_practice_weight =  round((($allans) / $scaleSize), 2);
                // $emp_practice_weightz =  round((($allans) / $scaleSize), 2);
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

                // $OverAllAv = $SurveyResult->where('question_id', '=', $functionPractice->practiceQuestions->id)
                //     ->avg('answer_value');
                if ($avg_factor <= 0)
                    return ['data_size' => 0];
                Log::info("gggg");
                $OverAllAv = ($the_three_avg) / $avg_factor;
                $practiceWeight =  round((($OverAllAv) / $scaleSize), 2);
                // $function_w += $practiceWeight;
                // $p_count_++;
                // $practiceWeightz =  round((($OverAllAv) / $scaleSize), 2);
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
            $avg = round(($avg / $scaleSize), 2);
            //get sum of this function leaders
            //get avg of this function leaders
            $avgl = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $leaders_email)->avg('answer_value');
            $avgl = round(($avgl / $scaleSize), 2);
            //get sum of this function hr
            //get avg of this function hr
            $avgh = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $hr_teames_email)->avg('answer_value');
            $avgh = round(($avgh / $scaleSize), 2);
            //get sum of this function employees
            //get avg of this function employees
            $avge = $SurveyResult->whereIn('question_id', $questionsIDs)->whereIn('answered_by', $employees_email)->avg('answer_value');
            $avge = round(($avge / $scaleSize), 2);
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
            $total_answers = $prioritiesRes->where('question_id', $function->id)->whereIn('answered_by', $leaders_email)->sum('answer_value');
            $count_answers = $prioritiesRes->where('question_id', $function->id)->whereIn('answered_by', $leaders_email)->count();
            $priorityVal = $count_answers > 0 ? round((($total_answers / $count_answers) / 3), 2) : 0;
            $priority = ["priority" => number_format($priorityVal * 100), "function" => $function->translated_title, "function_id" => $function->id, "performance" => number_format($avgl * 100), "performancez" => number_format($avgl * 100)];
            array_push($priorities, $priority);
            $performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((($avge + $avgh + $avgl) / $p_count_) * 100),
                // "performance" => ($avg * 100),
                // 'overall_Practices' => $overall_Practices,
                // 'leaders_practices' => $leaders_practices,
                // 'hr_practices' => $hr_practices,
                // 'emp_practices' => $emp_practices
            ];
            array_push($performences_, $performence_);
        }

        // $overAllpractice = $overall_Practices;
        //sorte overAllpractice Asc
        // usort($overAllpractice, function ($a, $b) {
        //     return $a['weight'] <=> $b['weight'];
        // });
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
                array_push($leaders_perform_onlyz, $leader_performences_[$count_z]['performance']);
            }
            if ($hr_performences_[$count_z]['function_id'] == $function->id) {
                array_push($hr_perform_onlyz, $hr_performences_[$count_z++]['performance']);
            }
        }
        $desc_perfom = $performences_;

        $data = [
            'data_size' => count($surveyEmails),
            'functions' => $functions,
            'priorities' => $priorities,
            'overallResult' => $overallResult,
            'asc_perform' => $asc_perform,
            'desc_perfom' => $desc_perfom,
            'overall_Practices' => $overall_Practices,
            // 'overAllpractice' => $overAllpractice,
            // 'overall_PracticesAsc' => $overall_PracticesAsc,
            // 'unsorted_performences' => $unsorted_performences,
            'sorted_leader_performences' => $sorted_leader_performences,
            'sorted_hr_performences' => $sorted_hr_performences,
            'sorted_emp_performences' => $sorted_emp_performences,
            'function_Lables' => $function_Lables,
            // 'leaders_perform_only' => $leaders_perform_only,
            // 'hr_perform_only' => $hr_perform_only,
            'leaders_perform_onlyz' => $leaders_perform_onlyz,
            'hr_perform_onlyz' => $hr_perform_onlyz,
            "id" => $id,
            'Resp_overAll_res' => count($surveyEmails),
            'overAll_res' => $Answers_by_leaders + $Answers_by_hr + $Answers_by_emp,
            'prop_leadersResp' => count($leaders_email),
            'prop_hrResp' => count($hr_teames_email),
            'prop_empResp' => count($employees_email),
            'leaders_res' => $Answers_by_leaders,
            'hr_res' => $Answers_by_hr,
            'emp_res' => $Answers_by_emp,
            'leader_performences' => $leader_performences_,
            'hr_performences' => $hr_performences_,
            'type' => $type,
            'type_id' => $type_id,
            'entities' => null,
            'entity' => Companies::find($type_id)->company_name_en . ' ' . __('Result Company-wise'),
            'client_id' => $Client_id,
            'service_type' => $Service_type
        ];
        return $data;
    }
    function sector_results($Client_id, $Service_type, $id, $type, $type_id = null)
    {
        $sector = Sectors::find($type_id);
        $sector_data = [];
        foreach ($sector->companies as $company) {
            $comp_d = $this->company_results($Client_id, $Service_type, $id, 'comp', $company->id);
            if ($comp_d['data_size'] > 0) {
                array_push($sector_data, $comp_d);
            }
        }
        $overallResult = 0; //Done
        $priorities_data = [];
        $asc_perform_data = [];
        $desc_perfom_data = [];
        $overall_Practices_data = [];
        $overAllpractice_data = [];
        $unsorted_performences_data = [];
        $sorted_leader_performences_data = [];
        $sorted_hr_performences_data = [];
        $sorted_emp_performences_data = [];
        $leader_performences_data = [];
        $hr_performences_data = [];
        $Resp_overAll_res = 0;
        $overAll_res = 0;
        $prop_leadersResp = 0;
        $prop_hrResp = 0;
        $prop_empResp = 0;
        $leaders_res = 0;
        $hr_res = 0;
        $emp_res = 0;
        foreach ($sector_data  as $comp_data) {

            $overallResult += $comp_data['overallResult'];
            $priorities_data = array_merge($priorities_data, $comp_data['priorities']);
            $asc_perform_data = array_merge($asc_perform_data, $comp_data['asc_perform']);
            $desc_perfom_data = array_merge($desc_perfom_data, $comp_data['desc_perfom']);
            $overall_Practices_data = array_merge($overall_Practices_data, $comp_data['overall_Practices']);
            $sorted_leader_performences_data = array_merge($sorted_leader_performences_data, $comp_data['sorted_leader_performences']);
            $sorted_hr_performences_data = array_merge($sorted_hr_performences_data, $comp_data['sorted_hr_performences']);
            $sorted_emp_performences_data = array_merge($sorted_emp_performences_data, $comp_data['sorted_emp_performences']);
            $leader_performences_data = array_merge($leader_performences_data, $comp_data['leader_performences']);
            $hr_performences_data = array_merge($hr_performences_data, $comp_data['hr_performences']);
            $Resp_overAll_res += $comp_data['Resp_overAll_res'];
            $overAll_res += $comp_data['overAll_res'];
            $prop_leadersResp += $comp_data['prop_leadersResp'];
            $prop_hrResp += $comp_data['prop_hrResp'];
            $prop_empResp += $comp_data['prop_empResp'];
            $leaders_res += $comp_data['leaders_res'];
            $hr_res += $comp_data['hr_res'];
            $emp_res += $comp_data['emp_res'];
        }
        if (count($sector_data) == 0)
            return ['data_size' => count($sector_data)];
        $overallResult = count($sector_data) != 0 ? number_format($overallResult / count($sector_data)) : 0;
        $service_id = Surveys::find($id)->plans->service;
        $functions = Functions::where('service_id', $service_id)->get();
        $priorities = [];
        $asc_perform = [];
        $desc_perfom = [];
        $overall_Practices = [];
        $leaders_practices = [];
        $overAllpractice = [];
        $unsorted_performences = [];
        $sorted_leader_performences = [];
        $sorted_hr_performences = [];
        $sorted_emp_performences = [];
        $leader_performences_ = [];
        $hr_performences_ = [];
        $leaders_perform_onlyz = [];
        $hr_perform_onlyz = [];
        $function_Lables = [];
        $performences_ = [];
        $hr_practices = [];
        $emp_practices = [];
        foreach ($functions as $function) {
            $function_Lables[] = $function->translated_title;
            $priority = [
                "priority" => number_format((collect($priorities_data)->where('function_id', $function->id)->sum('priority')) / count($sector_data), 2),
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((collect($priorities_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
            ];
            array_push($priorities, $priority);
            $overall_Practices_data = collect($overall_Practices_data);
            // $leaders_practice_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['leaders_practices'];
            // $hr_practices_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['hr_practices'];
            // $emp_practices_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['emp_practices'];
            foreach ($function->practices as $practice) {
                $practiceName = $practice->translated_title;
                $overall_Practice = [
                    'name' => $practiceName,
                    'id' => $practice->id,
                    'weight' => number_format((collect($overall_Practices_data)->where('id', $practice->id)->where('function_id', $function->id)->sum('weight')) / count($sector_data), 2),
                    'weightz' => number_format((collect($overall_Practices_data)->where('id', $practice->id)->where('function_id', $function->id)->sum('weightz')) / count($sector_data), 2),
                    'function_id' => $function->id,
                ];
                array_push($overall_Practices, $overall_Practice);
            }
            $performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((collect($asc_perform_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
                // "performance" => number_format((collect($asc_perform_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                // 'overall_Practices' => $overall_Practices,
                // 'leaders_practices' => $leaders_practices,
                // 'hr_practices' => $hr_practices,
                // 'emp_practices' => $emp_practices
            ];
            array_push($performences_, $performence_);
            $emp_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((collect($sorted_emp_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
                "applicable" => collect($sorted_emp_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false
                // "performance" => number_format((collect($sorted_emp_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data))
            ];
            array_push($sorted_emp_performences, $emp_performence_);
            $hr_performance = number_format((collect($sorted_hr_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data));
            $hr_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((collect($sorted_hr_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
                "applicable" => collect($sorted_hr_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false
                // "performance" => $hr_performance
            ];
            array_push($sorted_hr_performences, $hr_performence_);
            array_push($hr_perform_onlyz, $hr_performance);
            $L_performance = number_format((collect($sorted_leader_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data));
            $leader_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => number_format((collect($sorted_leader_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
                "applicable" => collect($sorted_leader_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false
                // "performance" => $L_performance
            ];
            array_push($sorted_leader_performences, $leader_performence_);
            array_push($leaders_perform_onlyz, $L_performance);
        }
        $asc_perform = $performences_;
        usort($asc_perform, function ($a, $b) {
            return $a['performance'] <=> $b['performance'];
        });
        $desc_perfom = $performences_;
        usort($desc_perfom, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        $leader_performences_ = $sorted_leader_performences;
        $hr_performences_ = $sorted_hr_performences;
        $overAllpractice = $overall_Practices;
        $data = [
            'data_size' => count($sector_data),
            'functions' => $functions,
            'priorities' => $priorities,
            'overallResult' => $overallResult,
            // 'overallResult' => $overallResult,
            'asc_perform' => $asc_perform,
            'desc_perfom' => $desc_perfom,
            'overall_Practices' => $overall_Practices,
            // 'overAllpractice' => $overAllpractice,
            // 'overall_PracticesAsc' => $overall_PracticesAsc,
            'unsorted_performences' => $unsorted_performences,
            'sorted_leader_performences' => $sorted_leader_performences,
            'sorted_hr_performences' => $sorted_hr_performences,
            'sorted_emp_performences' => $sorted_emp_performences,
            'function_Lables' => $function_Lables,
            // 'leaders_perform_only' => $leaders_perform_only,
            // 'hr_perform_only' => $hr_perform_only,
            'leaders_perform_onlyz' => $leaders_perform_onlyz,
            'hr_perform_onlyz' => $hr_perform_onlyz,
            "id" => $id,
            'Resp_overAll_res' => $Resp_overAll_res,
            'overAll_res' => $overAll_res,
            'prop_leadersResp' => $prop_leadersResp,
            'prop_hrResp' => $prop_hrResp,
            'prop_empResp' => $prop_empResp,
            'leaders_res' => $leaders_res,
            'hr_res' => $hr_res,
            'emp_res' => $emp_res,
            'leader_performences' => $leader_performences_,
            'hr_performences' => $hr_performences_,
            'type' => $type,
            'type_id' => $type_id,
            'entities' => $sector->companies,
            'entity' => $sector->sector_name_en . ' ' . __('Result Sector-wise'),
            'client_id' => $Client_id,
            'service_type' => $Service_type
        ];
        return $data;
    }
    function group_results($Client_id, $Service_type, $id, $type, $type_id = null)
    {
        $Survey = Surveys::find($id);
        $sectors = $Survey->clients->sectors;
        $client = $Survey->clients;
        $sector_data = [];
        foreach ($sectors as $sector) {
            $comp_d = $this->sector_results($Client_id, $Service_type, $id, 'sec', $sector->id);
            if ($comp_d['data_size'] > 0)
                array_push($sector_data, $comp_d);
        }
        $overallResult = 0; //Done
        $priorities_data = [];
        $asc_perform_data = [];
        $desc_perfom_data = [];
        $overall_Practices_data = [];
        $overAllpractice_data = [];
        $unsorted_performences_data = [];
        $sorted_leader_performences_data = [];
        $sorted_hr_performences_data = [];
        $sorted_emp_performences_data = [];
        $leader_performences_data = [];
        $hr_performences_data = [];
        $Resp_overAll_res = 0;
        $overAll_res = 0;
        $prop_leadersResp = 0;
        $prop_hrResp = 0;
        $prop_empResp = 0;
        $leaders_res = 0;
        $hr_res = 0;
        $emp_res = 0;
        foreach ($sector_data  as $comp_data) {

            $overallResult += $comp_data['overallResult'];
            $priorities_data = array_merge($priorities_data, $comp_data['priorities']);
            $asc_perform_data = array_merge($asc_perform_data, $comp_data['asc_perform']);
            $desc_perfom_data = array_merge($desc_perfom_data, $comp_data['desc_perfom']);
            $overall_Practices_data = array_merge($overall_Practices_data, $comp_data['overall_Practices']);
            $sorted_leader_performences_data = array_merge($sorted_leader_performences_data, $comp_data['sorted_leader_performences']);
            $sorted_hr_performences_data = array_merge($sorted_hr_performences_data, $comp_data['sorted_hr_performences']);
            $sorted_emp_performences_data = array_merge($sorted_emp_performences_data, $comp_data['sorted_emp_performences']);
            $leader_performences_data = array_merge($leader_performences_data, $comp_data['leader_performences']);
            $hr_performences_data = array_merge($hr_performences_data, $comp_data['hr_performences']);
            $Resp_overAll_res += $comp_data['Resp_overAll_res'];
            $overAll_res += $comp_data['overAll_res'];
            $prop_leadersResp += $comp_data['prop_leadersResp'];
            $prop_hrResp += $comp_data['prop_hrResp'];
            $prop_empResp += $comp_data['prop_empResp'];
            $leaders_res += $comp_data['leaders_res'];
            $hr_res += $comp_data['hr_res'];
            $emp_res += $comp_data['emp_res'];
        }
        $overallResult = count($sector_data) == 0 ? 0 : number_format($overallResult / count($sector_data));
        $service = Surveys::find($id)->plans->service;
        $functions = Functions::where('service_id', $service)->get();
        $priorities = [];
        $asc_perform = [];
        $desc_perfom = [];
        $overall_Practices = [];
        $leaders_practices = [];
        $overAllpractice = [];
        $unsorted_performences = [];
        $sorted_leader_performences = [];
        $sorted_hr_performences = [];
        $sorted_emp_performences = [];
        $leader_performences_ = [];
        $hr_performences_ = [];
        $leaders_perform_onlyz = [];
        $hr_perform_onlyz = [];
        $function_Lables = [];
        $performences_ = [];
        $hr_practices = [];
        $emp_practices = [];
        foreach ($functions as $function) {
            $function_Lables[] = $function->translated_title;
            $priority = [
                "priority" => count($sector_data) == 0 ? 0 : number_format((collect($priorities_data)->where('function_id', $function->id)->sum('priority')) / count($sector_data), 2),
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => count($sector_data) == 0 ? 0 : number_format((collect($priorities_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data)),
                // "performance" => number_format((collect($priorities_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2)
            ];
            array_push($priorities, $priority);
            $overall_Practices_data = collect($overall_Practices_data);
            // $leaders_practice_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['leaders_practices'];
            // $hr_practices_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['hr_practices'];
            // $emp_practices_befor = collect($asc_perform_data)->where('function_id', $function->id)->first()['emp_practices'];
            foreach ($function->practices as $practice) {
                $practiceName = $practice->translated_title;
                $overall_Practice = [
                    'name' => $practiceName,
                    'id' => $practice->id,
                    'weight' => count($sector_data) == 0 ? 0 : number_format((collect($overall_Practices_data)->where('id', $practice->id)->where('function_id', $function->id)->sum('weight')) / count($sector_data), 2),
                    'weightz' => count($sector_data) == 0 ? 0 : number_format((collect($overall_Practices_data)->where('id', $practice->id)->where('function_id', $function->id)->sum('weightz')) / count($sector_data), 2),
                    'function_id' => $function->id,
                ];
                array_push($overall_Practices, $overall_Practice);
                // $leaders_practice = [
                //     'name' => $practiceName,
                //     'id' => $practice->id,
                //     'weight' => number_format((collect($leaders_practice_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weight')) / count($sector_data), 2),
                //     'weightz' => number_format((collect($leaders_practice_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weightz')) / count($sector_data), 2),
                //     'function_id' => $function->id,
                // ];
                // array_push($leaders_practices, $leaders_practice);
                // $hr_practice = [
                //     'name' => $practiceName,
                //     'id' => $practice->id,
                //     'weight' => number_format((collect($hr_practices_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weight')) / count($sector_data), 2),
                //     'weightz' => number_format((collect($hr_practices_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weightz')) / count($sector_data), 2),
                //     'function_id' => $function->id,
                // ];
                // array_push($hr_practices, $hr_practice);
                // $emp_practice = [
                //     'name' => $practiceName,
                //     'id' => $practice->id,
                //     'weight' => number_format((collect($emp_practices_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weight')) / count($sector_data), 2),
                //     'weightz' => number_format((collect($emp_practices_befor)->where('id', $practice->id)->where('function_id', $function->id)->sum('weightz')) / count($sector_data), 2),
                //     'function_id' => $function->id,
                // ];
                // array_push($emp_practices, $emp_practice);
            }
            $performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => count($sector_data) == 0 ? 0 : number_format((collect($asc_perform_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                // "performance" => number_format((collect($asc_perform_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                // 'overall_Practices' => $overall_Practices,
                // 'leaders_practices' => $leaders_practices,
                // 'hr_practices' => $hr_practices,
                // 'emp_practices' => $emp_practices
            ];
            array_push($performences_, $performence_);
            $emp_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                "performance" => count($sector_data) == 0 ? 0 : number_format((collect($sorted_emp_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                "applicable" => count($sorted_emp_performences_data) == 0 ? false : (collect($sorted_emp_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false)
                // "performance" => number_format((collect($sorted_emp_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2)
            ];
            array_push($sorted_emp_performences, $emp_performence_);
            $hr_performance = count($sector_data) == 0 ? 0 : number_format((collect($sorted_hr_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2);
            $hr_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                // "performance" => number_format((collect($sorted_hr_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                "performance" => $hr_performance,
                "applicable" => count($sorted_hr_performences_data) == 0 ? false : (collect($sorted_hr_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false)
            ];
            array_push($sorted_hr_performences, $hr_performence_);
            array_push($hr_perform_onlyz, $hr_performance);
            $L_performance = count($sector_data) == 0 ? 0 : number_format((collect($sorted_leader_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2);
            $leader_performence_ = [
                "function" => $function->translated_title,
                "function_id" => $function->id,
                // "performance" => number_format((collect($sorted_leader_performences_data)->where('function_id', $function->id)->sum('performance')) / count($sector_data), 2),
                "performance" => $L_performance,
                "applicable" => count($sorted_leader_performences_data) == 0 ? false : (collect($sorted_leader_performences_data)->where('function_id', $function->id)->first()['applicable'] == 1 ? true : false)
            ];
            array_push($sorted_leader_performences, $leader_performence_);
            array_push($leaders_perform_onlyz, $L_performance);
        }
        $asc_perform = $performences_;
        usort($asc_perform, function ($a, $b) {
            return $a['performance'] <=> $b['performance'];
        });
        $desc_perfom = $performences_;
        usort($desc_perfom, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
        });
        $leader_performences_ = $sorted_leader_performences;
        $hr_performences_ = $sorted_hr_performences;
        $overAllpractice = $overall_Practices;
        $surveyEmailss = Respondents::select('respondents.id as id', 'employees.employee_type as EmployeeType')
            ->join('employees', 'respondents.employee_id', '=', 'employees.id')
            ->where('respondents.survey_id', $id)
            ->get();
        $data = [
            'data_size' => count($sector_data),
            'functions' => $functions,
            'priorities' => $priorities,
            'overallResult' => $overallResult,
            // 'overallResult' => $overallResult,
            'asc_perform' => $asc_perform,
            'desc_perfom' => $desc_perfom,
            'overall_Practices' => $overall_Practices,
            // 'overAllpractice' => $overAllpractice,
            // 'overall_PracticesAsc' => $overall_PracticesAsc,
            // 'unsorted_performences' => $unsorted_performences,
            'sorted_leader_performences' => $sorted_leader_performences,
            'sorted_hr_performences' => $sorted_hr_performences,
            'sorted_emp_performences' => $sorted_emp_performences,
            'function_Lables' => $function_Lables,
            // 'leaders_perform_only' => $leaders_perform_only,
            // 'hr_perform_only' => $hr_perform_only,
            'leaders_perform_onlyz' => $leaders_perform_onlyz,
            'hr_perform_onlyz' => $hr_perform_onlyz,
            "id" => $id,
            'Resp_overAll_res' => ($surveyEmailss->where('EmployeeType', 1)->count() + $surveyEmailss->where('EmployeeType', 2)->count() + $surveyEmailss->where('EmployeeType', 3)->count()),
            'overAll_res' => $overAll_res,
            'prop_leadersResp' => $surveyEmailss->where('EmployeeType', 1)->count(),
            'prop_hrResp' => $surveyEmailss->where('EmployeeType', 2)->count(),
            'prop_empResp' => $surveyEmailss->where('EmployeeType', 3)->count(),
            'leaders_res' => $leaders_res,
            'hr_res' => $hr_res,
            'emp_res' => $emp_res,
            'leader_performences' => $leader_performences_,
            'hr_performences' => $hr_performences_,
            'type' => $type,
            'type_id' => $type_id,
            'entities' => $sectors,
            'entity' => $client->ClientName . " " . __('Result Organizational-wise'),
            'client_id' => $Client_id,
            'service_type' => $Service_type
        ];
        return $data;
    }
    //calculateTheAverage function
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
        $enps_favorable = 0;
        $sum_hand_favorable_score = 0;
        $sum_head_favorable_score = 0;
        $sum_heart_favorable_score = 0;
        $sum_out_come_favorable_val = 0;
        $sum_enps_favorable = 0;
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
        }
        //get average of functions
        $hand_favorable_score = $sum_hand_favorable_score / $data_size;
        $head_favorable_score = $sum_head_favorable_score / $data_size;
        $heart_favorable_score = $sum_heart_favorable_score / $data_size;
        $out_come_favorable_val = $sum_out_come_favorable_val / $data_size;
        $enps_favorable = $sum_enps_favorable / $data_size;
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
            'there_is_answer' => $there_is_answer
        ];
        return $data;
    }
    function newFunc($surveyEmails, $leaders_email, $hr_teames_email, $employees_email)
    {
        foreach ($surveyEmails as $surveyEmail) {
            if ($surveyEmail->EmployeeType == 1) {
                array_push($leaders_email, $surveyEmail->id);
            }
            if ($surveyEmail->EmployeeType == 2) {
                array_push($hr_teames_email, $surveyEmail->id);
            }
            if ($surveyEmail->EmployeeType == 3) {
                array_push($employees_email, $surveyEmail->id);
            }
        }
        return [$leaders_email, $hr_teames_email, $employees_email];
    }
    //saveSurveyCandidates function
    public function saveSurveyCandidates(Request $request, $by_admin = false)
    {
        try {
            if ($request->tool_type != 'customized') {
                //type
                foreach ($request->ids as $candidate) {
                    $rater = new Raters();
                    $rater->candidate_id = $candidate;
                    $rater->rater_id = $candidate;
                    $rater->survey_id = $request->survey;
                    $rater->type = 'Self';
                    $rater->save();
                    //add new respondent
                    $respondent = new Respondents();
                    $respondent->survey_id = $request->survey;
                    $respondent->employee_id = $candidate;
                    $respondent->client_id = $request->client;
                    $respondent->survey_type = $request->type;
                    $respondent->rater_id = $rater->id;
                    $respondent->candidate_id = $candidate;
                    $respondent->save();
                }
            } else {
                //type
                foreach ($request->ids as $candidate) {
                    $rater = new CustomizedSurveyRaters();
                    $rater->candidate_id = $candidate;
                    $rater->rater_id = $candidate;
                    $rater->survey_id = $request->survey;
                    $rater->type = 'Self';
                    $rater->save();
                    //add new respondent
                    $respondent = new CustomizedSurveyRespondents();
                    $respondent->survey_id = $request->survey;
                    $respondent->employee_id = $candidate;
                    $respondent->client_id = $request->client;
                    $respondent->survey_type = $request->type;
                    $respondent->rater_id = $rater->id;
                    $respondent->candidate_id = $candidate;
                    $respondent->save();
                }
            }
            return response()->json(['message' => 'Candidates saved successfully'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error saving Candidates'], 500);
        }
    }
    //getRaters function
    public function getRaters(Request $request, $id, $survey,  $type = null, $by_admin = false)
    {
        $raters = [];
        $employee = Employees::find($id);
        $dep = $employee->department;
        $deps = [];
        array_push($deps, $dep->id);
        //get employees of $dep
        $next_level_deps = Departments::select('id')
            ->where('dep_level', $dep->dep_level + 1)
            ->pluck('id')
            ->toArray();
        $deps = array_merge($deps, $next_level_deps);
        $employees = Employees::whereIn('dep_id', $deps)->get();
        //push $employees to $raters
        foreach ($employees as $emp) {
            array_push($raters, [
                'id' => $emp->id,
                'name' => $emp->name,
                'email' => $emp->email,
                'dep_id' => $emp->department->name,
                'position' => $emp->position,
                'comp_id' => $emp->comp_id,
                'sector_id' => $emp->sector_id,
                'type' => $emp->id == $id ? 'Self' : 'DR',
            ]);
        }
        //get all department of same level
        $deps = Departments::where('company_id', $employee->comp_id)
            ->where('dep_level', $dep->dep_level)
            ->pluck('id')
            ->toArray();
        //get employees of $deps
        $employees = Employees::whereIn('dep_id', $deps)->where('employee_type', 1)->where('id', '!=', $id)->get();
        //push $employees to $raters
        foreach ($employees as $emp) {
            array_push($raters, [
                'id' => $emp->id,
                'name' => $emp->name,
                'email' => $emp->email,
                'dep_id' => $emp->department->name,
                'position' => $emp->position,
                'comp_id' => $emp->comp_id,
                'sector_id' => $emp->sector_id,
                'type' => 'Peer',
            ]);
        }
        //if dep_level !=0
        if ($dep->dep_level != 0) {
            //get all department of same level
            $deps = Departments::select('id')
                ->where('company_id', $employee->comp_id)
                ->where('dep_level', $dep->dep_level - 1)
                ->first();
            //get manager employees of $deps
            $employees = Employees::where('dep_id', $deps->id)
                ->where('employee_type', 1)
                ->get();
            //push $employees to $raters
            foreach ($employees as $emp) {
                array_push($raters, [
                    'id' => $emp->id,
                    'name' => $emp->name,
                    'email' => $emp->email,
                    'dep_id' => $emp->department->name,
                    'position' => $emp->position,
                    'comp_id' => $emp->comp_id,
                    'sector_id' => $emp->sector_id,
                    'type' => 'LM',
                ]);
            }
        }
        //yajra table of raters
        return DataTables::of(collect($raters))
            ->addIndexColumn()
            ->addColumn('rtype', function ($emp) {
                $type = '';
                switch ($emp['type']) {
                    case 'DR':
                        $type = 'Direct Report';
                        break;
                    case 'Peer':
                        $type = 'Peer';
                        break;
                    case 'LM':
                        $type = 'Line Manager';
                        break;
                    case 'Self':
                        $type = 'Self';
                        break;
                }
                return $type;
            })
            ->addColumn('Cid', function ($row) use ($id) {
                return $id;
            })
            ->addColumn('isAdded', function ($emp) use ($survey, $id, $type) {
                if ($type == 'customized')
                    return CustomizedSurveyRaters::where('candidate_id', $id)->where('rater_id', $emp['id'])->where('survey_id', $survey)->exists();
                return Raters::where('candidate_id', $id)->where('rater_id', $emp['id'])->where('survey_id', $survey)->exists();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    //SaveRaters function
    public function SaveRaters(Request $request, $by_admin = false)
    {
        try {
            if ($request->tool_type != "customized") { //action
                if ($request->action == "add") {
                    $rater = new Raters();
                    $rater->candidate_id = $request->cid;
                    $rater->rater_id = $request->id;
                    $rater->survey_id = $request->survey;
                    $rater->type = $request->type;
                    $rater->save();
                    //add new respondent
                    $respondent = new Respondents();
                    $respondent->survey_id = $request->survey;
                    $respondent->employee_id = $request->id;
                    $respondent->client_id = $request->client_id;
                    $respondent->survey_type = $request->stype;
                    $respondent->rater_id = $rater->id;
                    $respondent->candidate_id = $request->cid;
                    $respondent->save();
                } else {
                    $rater = Raters::where('candidate_id', $request->cid)->where('rater_id', $request->id)->where('survey_id', $request->survey)->first();
                    //completelly destroy
                    Respondents::where('survey_id', $request->survey)->where('rater_id', $rater->id)->first()->delete();
                    $rater->delete();
                }
            } else {
                if ($request->action == "add") {
                    $rater = new CustomizedSurveyRaters();
                    $rater->candidate_id = $request->cid;
                    $rater->rater_id = $request->id;
                    $rater->survey_id = $request->survey;
                    $rater->type = $request->type;
                    $rater->save();
                    //add new respondent
                    $respondent = new CustomizedSurveyRespondents();
                    $respondent->survey_id = $request->survey;
                    $respondent->employee_id = $request->id;
                    $respondent->client_id = $request->client_id;
                    $respondent->survey_type = $request->stype;
                    $respondent->rater_id = $rater->id;
                    $respondent->candidate_id = $request->cid;
                    $respondent->save();
                } else {
                    $rater = CustomizedSurveyRaters::where('candidate_id', $request->cid)->where('rater_id', $request->id)->where('survey_id', $request->survey)->first();
                    //completelly destroy
                    CustomizedSurveyRespondents::where('survey_id', $request->survey)->where('rater_id', $rater->id)->first()->delete();
                    $rater->delete();
                }
            }
            return response()->json(['message' => 'Raters saved successfully', 'stat' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving Raters', 'stat' => false], 500);
        }
    }
    //survey360 function
    public function survey360(Request $request, $id, $type = null)
    {
        //check if the respondent record is exist
        $respondent = Respondents::where('id', $id)->first();
        if (!$respondent) {
            //abort
            abort(404);
        }
        //check if employee is exist
        if (Employees::where('id', $respondent->employee_id)->doesntExist()) {
            //abort
            abort(404);
        }
        //get the survey
        $survey = Surveys::find($respondent->survey_id);
        //check if the survey is exist
        if (!$survey || !$survey->survey_stat) {
            //abort
            abort(404);
        }
        //check if the respondent already submit survey
        if (SurveyAnswers::where('answered_by', $id)->where('survey_id', $survey->id)->exists()) {
            //abort
            abort(404);
        }
        //get functions
        $functions = Functions::where('service_id', $survey->plans->service)->get();
        $can_ansewer_to_priorities = false;
        $employee = Employees::find($respondent->employee_id);
        $candidate_name = $employee->name . '(' . $employee->position . ')';
        $data = [
            'functions' => $functions,
            'user_type' =>  $employee->employee_type,
            'can_ansewer_to_priorities' => $can_ansewer_to_priorities,
            'survey_id' => $survey->id,
            'email_id' => $id,
            'plan_id' => $survey->plans->id,
            'open_end_q' => [],
            'candidate_name' => $candidate_name
        ];
        return view('surveys.360Survey')->with($data);
    }
    //candidates function
    public function candidates(Request $request, $is_admin = false)
    {
        $candidates = null;
        if ($request->type == "sectore") {
            $candidate_ids = Raters::where('survey_id', $request->survey)->pluck('candidate_id')->toArray();
            $candidates = Employees::whereIn('id', $candidate_ids)->where('client_id', $request->client)->where('sector_id', $request->id)->get();
        }
        if ($request->type == "company") {
            $candidate_ids = Raters::where('survey_id', $request->survey)->pluck('candidate_id')->toArray();
            $candidates = Employees::whereIn('id', $candidate_ids)->where('client_id', $request->client)->where('comp_id', $request->id)->get();
        }
        if ($request->type == "dep") {
            $candidate_ids = Raters::where('survey_id', $request->survey)->pluck('candidate_id')->toArray();
            $candidates = Employees::whereIn('id', $candidate_ids)->where('client_id', $request->client)->where('dep_id', $request->id)->get();
        }
        return $candidates;
    }
    //schedule360 public function
    public function schedule360(Request $request,  $type = null) {}
    //ShowCustomizedSurveys function
    function ShowCustomizedSurveys($id, $type, $by_admin = false)
    {
        $client = Clients::find($id);
        $departments = $client->departments();
        $service_id = Services::select('id')->where('service_type', $type)->first();
        //check if service_id is null
        if ($service_id == null) {
            return redirect()->route('services.index')->with('error', 'Service not found');
        }
        $service_id = $service_id->id;
        $plan_id = Plans::where('service', $service_id)->pluck('id')->toArray();
        $client_survyes = CustomizedSurvey::where('client', $client->id)
            ->whereIn('plan_id', $plan_id)
            ->get();

        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'departments' => $departments,
            'client_survyes' => $client_survyes,
        ];
        return view('dashboard.client.CustomizedSurveys')->with($data);
    }
    //createCustomizedSurvey function
    function editCustomizedSurvey($id, $type, $survey = null, $is_admin = false)
    {
        $client = Clients::find($id);
        $service = Services::select('id')->where('service_type', $type)->first();
        if (!$service) {
            // $data = [
            //     'id' => null,
            //     'type' => $type,
            //     'client' => $client,
            //     'plans' => null,
            //     'survey' => $survey,
            //     'client_subscription' => null,
            //     'error'=>'Service is not available yet please check it'
            // ];
            // return view('dashboard.client.editCustomizedSurvey')->with($data);
            return redirect()->route('services.index');
        }
        $service_id = $service->id;
        $plans = Plans::where([['service', $service_id], ['is_active', true]])->get();
        $plan = $plans->where('is_active', true)->first();
        $plans_id = $plans->pluck('id')->toArray();
        //get client active subscription
        $client_subscription = ClientSubscriptions::where([['client_id', $id], ['is_active', 1]])
            ->whereIn('plan_id', $plans_id)
            ->first();
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'plans' => $plans,
            'survey' => $survey,
            'client_subscription' => $client_subscription,
        ];
        return view('dashboard.client.editCustomizedSurvey')->with($data);
    }
    //storeCustomizedSurvey function
    function storeCustomizedSurvey(Request $request, $id, $type, $survey_id = null, $is_admin = false)
    {
        //collect data and save
        if ($survey_id != null)
            $survey = CustomizedSurvey::find($survey_id);
        else
            $survey = new CustomizedSurvey();
        $survey->client = $id;
        $survey->plan_id = $request->h_plan_id;
        $survey->subscription_plan_id = $request->h_splan_id;
        $survey->survey_title = $request->survey_title;
        $survey->survey_des = $request->survey_des;
        $survey->candidate_raters_model = $request->candidate_raters_model != null ? true : false;
        $survey->survey_stat = $request->survey_stat != null ? true : false;
        if ($request->cycle_stat != null) {
            $survey->cycle_stat = true;
            $survey->cycle_duration = $request->cycle_id;
            $survey->start_date = $request->start_date;
            $survey->start_time = $request->start_time;
            $survey->end_date = $request->end_date;
        } else {
            $survey->cycle_stat = false;
            $survey->cycle_duration = null;
            $survey->start_date = null;
            $survey->start_time = null;
            $survey->end_date = null;
        }
        if ($request->reminder_stat != null) {
            $survey->reminder_stat = true;
            $survey->reminder_duration_type = $request->reminder_duration_type;
            $survey->reminder_start_date = $request->reminder_start_date;
            $survey->reminder_start_time = $request->reminder_start_time;
        } else {
            $survey->reminder_stat = false;
            $survey->reminder_duration_type = null;
            $survey->reminder_start_date = null;
            $survey->reminder_start_time = null;
        }
        $survey->mandatory_stat = $request->mandatory_stat != null ? true : false;
        $survey->save();
        return redirect()->route('clients.ShowCustomizedSurveys', ['id' => $id, 'type' => $type])->with('success', 'Survey saved successfully');
    }
    //surveyCustomizedDetails function
    function surveyCustomizedDetails($id, $type, $survey_id, $is_admin = false)
    {
        $client = Clients::find($id);
        $survey = CustomizedSurvey::find($survey_id);
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'survey' => $survey,
        ];
        return view('dashboard.client.surveyCustomizedDetails')->with($data);
    }
    //CustomizedsurveyQuestions function
    function CustomizedsurveyQuestions($id, $type, $survey_id, $is_admin = false)
    {
        //get questions for the customized survey
        $client = Clients::find($id);
        $survey = CustomizedSurvey::find($survey_id);

        //datatable
        if (request()->ajax()) {
            $funcions_id = CustomizedSurveyFunctions::where('survey', $survey->id)->get()->pluck('id')->all();
            $practices_id = CustomizedSurveyPractices::whereIn('function_id', $funcions_id)->get()->pluck('id')->toArray();
            $questions = CustomizedSurveyQuestions::whereIn('practice_id', $practices_id)->get();
            return DataTables::of($questions)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return $row->translated_title;
                })
                ->addColumn('function', function ($row) {
                    return $row->practice->function->translated_title;
                })
                ->addColumn('practice', function ($row) {
                    return $row->practice->translated_title;
                })
                ->addColumn('fid', function ($row) {
                    return $row->practice->function->id;
                })
                ->addColumn('editCol', function ($row) {
                    $btn = '<div class="row"><a href="#" class="btn btn-sm btn-warning m-2" data-target="#EditCustomizedQuestionModal" data-toggel="modal"><i class="fa fa-edit"></i></a></div>';
                    return $btn;
                })
                ->addColumn('deleteCol', function ($row) {
                    $btn = '<div class="row"><a href="#" class="btn btn-sm btn-danger m-2" data-target="#EditCustomizedQuestionModal" data-toggel="modal"><i class="fa fa-trash"></i></a></div>';
                    return $btn;
                })
                ->rawColumns(['editCol', 'deleteCol'])
                ->make(true);
        }
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'survey' => $survey,
        ];
        return view('dashboard.client.CustomizedsurveyQuestions')->with($data);
    }
    //CreateCustomizedsurveyQuestions function
    function CreateCustomizedsurveyQuestions($id, $type, $survey_id, $is_admin = false)
    {
        $client = Clients::find($id);
        $survey = CustomizedSurvey::find($survey_id);
        $questions = $survey->questions;
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'survey' => $survey,
            'questions' => $questions,
        ];
        return view('dashboard.client.editCustomizedsurveyQuestions')->with($data);
    }
    //GetOtherSurveysQuestions function
    function GetOtherSurveysQuestions(Request $request, $sid, $fid = null, $pid = null, $is_admin)
    {
        try {
            if (request()->ajax()) {
                //get service id from Services using $sid
                $service_id = Services::select('id')->where('service_type', $sid)->first();
                //check if service_id is null
                if ($service_id == null) {
                    return response()->json(['error' => 'Service is not available yet please check it'], 404);
                }
                $service_id = $service_id->id;
                //get functions ids
                $functions = Functions::where('service_id', $service_id)->pluck('id')->toArray();
                //get parctices ids
                if ($fid == null || $fid == 'null')
                    $practices = FunctionPractices::whereIn('function_id', $functions)->pluck('id')->toArray();
                else
                    $practices = FunctionPractices::where('function_id', $fid)->pluck('id')->toArray();
                //get questions
                if ($pid == null || $pid == 'null')
                    $questions =  PracticeQuestions::whereIn('practice_id', $practices)->get();
                else
                    $questions = PracticeQuestions::where('practice_id', $pid)->get();
                return DataTables::of($questions)
                    ->addIndexColumn()
                    ->editColumn('title', function ($row) {
                        $row->translated_title;
                    })
                    ->addColumn('function', function ($row) {
                        return $row->practice->function->translated_title;
                    })
                    ->addColumn('practice', function ($row) {
                        return $row->practice->translated_title;
                    })
                    ->addColumn('fid', function ($row) {
                        return $row->practice->function->id;
                    })
                    ->make(true);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Error getting questions'], 500);
        }
    }
    //GetFunctions function
    function GetFunctions($sid, $is_admin)
    {
        try {
            //get service id from Services using $sid
            $service_id = Services::select('id')->where('service_type', $sid)->first();
            //check if service_id is null
            if ($service_id == null) {
                return response()->json(['error' => 'Service is not available yet please check it', 'stat' => false], 404);
            }
            $service_id = $service_id->id;
            //get functions ids
            $functions = Functions::where('service_id', $service_id)->get()->append('translated_title');
            return response()->json(['functions' => $functions, 'stat' => true], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Error getting functions', 'stat' => false], 500);
        }
    }
    //GetPractices function
    function GetPractices($fid, $is_admin)
    {
        try {
            //get practices ids
            $practices = FunctionPractices::where('function_id', $fid)->get()->append('translated_title');
            return response()->json(['practices' => $practices, 'stat' => true], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Error getting practices', 'stat' => false], 500);
        }
    }
    //SubmitCustomizedQuestions function
    function SubmitCustomizedQuestions(Request $request, $id, $type, $is_admin = false)
    {
        try {
            $client_id = $id;
            $survey_id = $request->survey;
            //check if $request->selectedQuestions is not empty
            if (is_array($request->selectedQuestions)) {
                if (count($request->selectedQuestions) > 0) {
                    //convert $request->selectedQuestions into collection
                    $selectedQuestions = collect($request->selectedQuestions);
                    //extract qid into an array
                    $qids = $selectedQuestions->pluck('qid')->toArray();
                    foreach ($qids as $qid) {
                        $question = PracticeQuestions::find($qid);
                        //get question practice id
                        $practice_id = $question->practice_id;
                        //get question function id
                        $function_id = $question->practice->function_id;
                        //check if customized function is already exist
                        $customized_function_id = $this->CustomizedFunctionId($function_id, $survey_id, $client_id);
                        //check if customized practice is already exist
                        $customized_practice_id = $this->CustomizedPracticeId($customized_function_id, $practice_id);
                        //create new customized question
                        $this->CustomizedQuestions($customized_practice_id, $qid);
                    }
                } else {
                }
            } else {
            }
            //check if $request->data is not empty
            if (count($request->data) > 0) {
                $data = $request->data;
                foreach ($data as $function) {
                    if ($function['function_'] != null) {
                        $title = $function['function_'];
                        $function_r = $function['function_r'];
                        //create new custome function
                        $customized_function = new CustomizedSurveyFunctions();
                        $customized_function->system_function = null;
                        $customized_function->survey = $survey_id;
                        $customized_function->client = $client_id;
                        $customized_function->title = $title;
                        $customized_function->title_ar = $title;
                        $customized_function->respondent = $function_r;
                        $customized_function->status = true;
                        $customized_function->save();
                        $customized_function_id = $customized_function->id;
                        foreach ($function['practices'] as $practice) {
                            //check if $pr has key practice
                            if (array_key_exists('practice', $practice)) {
                                $practice_title = $practice['practice'];
                                //create new custome practice
                                $customized_practice = new CustomizedSurveyPractices();
                                $customized_practice->system_practice = null;
                                $customized_practice->function_id = $customized_function_id;
                                $customized_practice->title = $practice_title;
                                $customized_practice->title_ar = $practice_title;
                                $customized_practice->save();
                                $customized_practice_id = $customized_practice->id;

                                foreach ($practice['questions'] as $question) {
                                    $question_ = $question['question'];
                                    $respondent = ($question['respondent']);
                                    $customized_question = new CustomizedSurveyQuestions();
                                    $customized_question->practice_id = $customized_practice_id;
                                    $customized_question->question = $question_;
                                    $customized_question->question_ar = $question_;
                                    $customized_question->respondent = $respondent;
                                    $customized_question->status = true;
                                    $customized_question->save();
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['message' => 'Questions saved successfully', 'stat' => true], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error saving Questions', 'stat' => false], 500);
        }
    }
    private function CustomizedFunctionId($function_id, $survey_id, $client_id)
    {
        $customized_function = CustomizedSurveyFunctions::where('system_function', $function_id)->where('survey', $survey_id)->where('client', $client_id)->first();
        if (!$customized_function) {
            //find system function
            $function = Functions::find($function_id);
            //create new customized function
            $customized_function = new CustomizedSurveyFunctions();
            $customized_function->system_function = $function_id;
            $customized_function->survey = $survey_id;
            $customized_function->client = $client_id;
            $customized_function->title = $function->title;
            $customized_function->title_ar = $function->title_ar;
            $customized_function->title_in = $function->title_in;
            $customized_function->title_urdo = $function->title_urdo;
            $customized_function->title_fr = $function->title_fr;
            $customized_function->title_sp = $function->title_sp;
            $customized_function->title_bngla = $function->title_bngla;
            $customized_function->title_tr = $function->title_tr;
            $customized_function->title_pr = $function->title_pr;
            // $customized_function->title_ru = $function->title_ru;
            // $customized_function->title_ch = $function->title_ch;
            $customized_function->respondent = $function->respondent;
            $customized_function->status = $function->status;
            $customized_function->IsDefault = $function->IsDefault;
            $customized_function->IsDriver = $function->IsDriver;
            $customized_function->save();
            return $customized_function->id;
        }
        return $customized_function->id;
    }
    private function CustomizedPracticeId($function_id, $systemPractice_id)
    {
        $customized_practice = CustomizedSurveyPractices::where('system_practice', $systemPractice_id)->where('function_id', $function_id)->first();
        if (!$customized_practice) {
            //find system practice
            $systemPractice = FunctionPractices::find($systemPractice_id);
            //create new customized practice
            $customized_practice = new CustomizedSurveyPractices();
            $customized_practice->system_practice = $systemPractice->id;
            $customized_practice->function_id = $function_id;
            $customized_practice->title = $systemPractice->title;
            $customized_practice->title_ar = $systemPractice->title_ar;
            $customized_practice->title_in = $systemPractice->title_in;
            $customized_practice->title_urdo = $systemPractice->title_urdo;
            $customized_practice->title_fr = $systemPractice->title_fr;
            $customized_practice->title_sp = $systemPractice->title_sp;
            $customized_practice->title_bngla = $systemPractice->title_bngla;
            $customized_practice->title_tr = $systemPractice->title_tr;
            $customized_practice->title_pr = $systemPractice->title_pr;
            // $customized_practice->title_ru = $systemPractice->title_ru;
            // $customized_practice->title_ch = $systemPractice->title_ch;
            $customized_practice->description = $systemPractice->description;
            $customized_practice->description_ar = $systemPractice->description_ar;
            $customized_practice->status = $systemPractice->status;
            $customized_practice->save();
            return $customized_practice->id;
        }
        return $customized_practice->id;
    }
    private function CustomizedQuestions($practice_id, $system_question_id)
    {
        $customized_question = CustomizedSurveyQuestions::where('system_question', $system_question_id)->where('practice_id', $practice_id)->first();
        if (!$customized_question) {
            //find system question
            $systemQuestion = PracticeQuestions::find($system_question_id);
            //create new customized question
            $customized_question = new CustomizedSurveyQuestions();
            $customized_question->system_question = $systemQuestion->id;
            $customized_question->practice_id = $practice_id;
            $customized_question->question = $systemQuestion->question;
            $customized_question->question_ar = $systemQuestion->question_ar;
            $customized_question->question_in = $systemQuestion->question_in;
            $customized_question->question_urdo = $systemQuestion->question_urdo;
            $customized_question->question_fr = $systemQuestion->question_fr;
            $customized_question->question_sp = $systemQuestion->question_sp;
            $customized_question->question_bngla = $systemQuestion->question_bngla;
            $customized_question->question_tr = $systemQuestion->question_tr;
            $customized_question->question_pr = $systemQuestion->question_pr;
            // $customized_question->question_ru = $systemQuestion->question_ru;
            // $customized_question->question_ch = $systemQuestion->question_ch;
            $customized_question->description = $systemQuestion->description;
            $customized_question->description_ar = $systemQuestion->description_ar;
            $customized_question->status = $systemQuestion->status;
            $customized_question->IsENPS = $systemQuestion->IsENPS;
            $customized_question->respondent = $systemQuestion->respondent;
            $customized_question->save();
            return $customized_question->id;
        }
        return $customized_question->id;
    }
    //CustomizedsurveyRespondents function
    function CustomizedsurveyRespondents(Request $request, $id, $type, $survey_id, $is_admin = false)
    {
        $survey = CustomizedSurvey::find($survey_id);
        $client = Clients::find($id);
        $is_candidate_raters = $survey->candidate_raters_model;
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client,
            'survey_id' => $survey_id,
            'is_candidate_raters' => $is_candidate_raters,
        ];
        //if request is ajax
        if ($request->ajax()) {
            $respondents_ids = CustomizedSurveyRespondents::where('survey_id', $survey_id)->get()->pluck('employee_id')->toArray();
            $candidate = /* CustomizedSurvey */ Raters::where('survey_id', $survey_id)->get()->pluck('candidate_id')->toArray();

            //setup yajra datatable
            if ($is_candidate_raters) {
                $employees = Employees::where('client_id', $id)->where('employee_type', 1)->get();
            } else {
                $employees = Employees::where('client_id', $id)->get();
            }
            // $employees = Employees::where('client_id', $id)->get();
            //log employees as an array
            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($employee) {
                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteEmp(\'' . $employee->id . '\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                //hr
                ->addColumn('hr', function ($employee) {
                    return $employee->is_hr_manager ? '<span class="badge bg-success">' . __('HR Manager') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Manager') . '</span>';
                })
                ->addColumn('raters', function ($employee) use ($candidate) {
                    //button to show modal of Addraters
                    return in_array($employee->id, $candidate) ? '<a href="javascript:void(0);" onclick="AddRaters(\'' . $employee->id . '\')" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ratersModal">' . __('Raters') : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('result', function ($employee) use ($candidate) {
                    return in_array($employee->id, $candidate) ? '<a href="javascript:void(0);" class="btn btn-info btn-xs">' . __('Result') . '<i class="fa fa-eye"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('is_candidate_raters', function ($employee) use ($is_candidate_raters) {
                    return $is_candidate_raters;
                })
                ->addColumn('isAddedAsCandidate', function ($employee) use ($candidate) {
                    return in_array($employee->id, $candidate) ? true : false;
                })
                ->addColumn('isAddAsRespondent', function ($employee) use ($respondents_ids) {
                    return in_array($employee->id, $respondents_ids) ? true : false;
                })
                ->addColumn('SendSurvey', function ($employee) use ($respondents_ids, $survey_id) {
                    return in_array($employee->id, $respondents_ids) ? '<a href="javascript:void(0);" onclick="SendSurvey(\'' . $employee->id . '\',\'' . $survey_id . '\')" class="btn btn-info btn-xs"><i class="fa fa-paper-plane"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('SendReminder', function ($employee) use ($respondents_ids, $survey_id) {
                    return in_array($employee->id, $respondents_ids) ? '<a href="javascript:void(0);" onclick="SendReminder(\'' . $employee->id . '\',\'' . $survey_id . '\')" class="btn btn-warning btn-xs"><i class="fa fa-paper-plane"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->rawColumns(['action', 'hr', 'SendSurvey', 'SendReminder', 'raters', 'result'])
                ->make(true);
        }
        return view('dashboard.client.CustomizedsurveyRespondents')->with($data);
    }
    //saveOrgInfo function
    function saveOrgInfo(Request $request, $id, $is_admin = false)
    {
        try {
            $client = Clients::find($id);

            $client->multiple_sectors = ($request->multiple_sectors) == 1 ? true : false;
            $client->multiple_company = ($request->multiple_companies) == 1 ? true : false;
            $client->use_departments = ($request->use_departments) == 1 ? true : false;
            $client->use_sections = ($request->use_sections) == 1 ? true : false;
            $client->save();
            return response()->json(['message' => 'Organization info saved successfully', 'stat' => true], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error saving Organization info', 'stat' => false], 500);
        }
    }
    //uploadOrgChartExcel function
    function uploadOrgChartExcel(Request $request, $id, $is_admin = false)
    {
        try {
            //check if $request has file
            if ($request->hasFile('excel')) {
                $file = $request->file('excel');
                // $file_name = time() . '.' . $file->getClientOriginalExtension();
                // $file->move(public_path('uploads/orgChart'), $file_name);
                $filePath = $file->store('temp');
                $job = (new UploadOrgChart($id, $filePath,  auth()->user()->id))->delay(now()->addSeconds(2));
                dispatch($job);
            }

            //return back with success
            return redirect()->back()->with('message', 'IT WORKS!');
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error uploading Organization chart', 'stat' => false], 500);
        }
    }
    function uploadEmployeeExcel(Request $request, $id, $is_admin = false)
    {
        try {
            //read excel sheet
            if ($request->hasFile('excel')) {
                //save file
                $file = $request->file('excel');
                // $file_name = time() . '.' . $file->getClientOriginalExtension();
                // $file->move(public_path('uploads/orgChart'), $file_name);
                $filePath = $file->store('temp');

                //create job

                $job = (new UploadEmployeeData($id, $filePath,  auth()->user()->id))->delay(now()->addSeconds(2));
                dispatch($job);
            }
            return redirect()->back()->with('message', 'IT WORKS!');
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error uploading Organization chart', 'stat' => false], 500);
        }
    }
    //copyFunction function
    function CopyFunctions(Request $request, $id, $is_admin = false)
    {
        try {
            //get copy_from_servic
            $copy_from_service = Services::where('service_type', $request->type)->first();
            //get copy_to_service
            $copy_to_service = Services::where('service_type', $id)->first();
            //get functions from copy_from_service
            $functions = Functions::where('service_id', $copy_from_service->id)->get();
            //loop through functions
            foreach ($functions as $function) {
                //create new function
                $new_function = new Functions();
                $new_function->service_id = $copy_to_service->id;
                $new_function->title = $function->title;
                $new_function->title_ar = $function->title_ar;
                $new_function->respondent = $function->respondent;
                $new_function->status = $function->status;
                $new_function->IsDefault = $function->IsDefault;
                $new_function->IsDriver = $function->IsDriver;
                $new_function->save();
                //get practices from function
                $practices = $function->practices;
                //loop through practices
                foreach ($practices as $practice) {
                    //create new practice
                    $new_practice = new FunctionPractices();
                    $new_practice->function_id = $new_function->id;
                    $new_practice->title = $practice->title;
                    $new_practice->title_ar = $practice->title_ar;
                    $new_practice->description = $practice->description;
                    $new_practice->description_ar = $practice->description_ar;
                    $new_practice->status = $practice->status;
                    $new_practice->save();
                    //get questions from practice
                    $questions = $practice->questions;
                    //loop through questions
                    foreach ($questions as $question) {
                        //create new question
                        $new_question = new PracticeQuestions();
                        $new_question->practice_id = $new_practice->id;
                        $new_question->question = $question->question;
                        $new_question->question_ar = $question->question_ar;
                        $new_question->description = $question->description;
                        $new_question->description_ar = $question->description_ar;
                        $new_question->status = $question->status;
                        $new_question->IsENPS = $question->IsENPS;
                        $new_question->respondent = $question->respondent;
                        $new_question->save();
                    }
                }
            }
            if ($id == 4) {
                return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function deleted successfully');
            } elseif ($id == 3) {
                return redirect()->route('EmployeeEngagment.index')->with('success', 'Function deleted successfully');
            } elseif ($id == 10) {
                return redirect()->route('CEmployeeEngagment.index')->with('success', 'Function deleted successfully');
            } elseif ($id == 5) {
                return redirect()->route('Leader360Review.index')->with('success', 'Function deleted successfully');
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error copying Function', 'stat' => false], 500);
        }
    }
    //SurveyStat function
    function SurveyStat($id, $cid, $type, $entity_id = null, $is_admin = false)
    {
        ini_set('max_execution_time', 300);
        try {
            //get client
            $client = Clients::find($cid);
            //find survey
            $survey = Surveys::find($id);
            $sector_stat = [];
            $company_stat = [];
            $region_stat = [];
            $branch_stat = [];
            $super_dir_stat = [];
            $dir_stat = [];
            $div_stat = [];
            $deps_stat = [];
            $all_employees = [];
            $collected = false;
            $sum_of_employees = 0;
            $sum_of_respondents = 0;
            $sum_of_answered = 0;
            //check if use multiple sectors
            if ($client->multiple_sectors) {
                foreach ($client->sectors as $sector) {
                    //get employees
                    $employees = [];
                    $employees = Employees::where('sector_id', $sector->id)->pluck('id')->toArray();
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $entity_stat = [
                        'entity_name' => $sector->name,
                        'entity_id' => $sector->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'sector'
                    ];
                    array_push($sector_stat, $entity_stat);
                    array_merge($all_employees, $employees);
                }
                $collected = true;
            }
            if ($client->multiple_company && !$collected && !$client->multiple_sectors) {
                foreach ($client->sectors->first()->companies as $company) {
                    $employees = [];
                    $employees = Employees::where('comp_id', $company->id)->pluck('id')->toArray();
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $entity_stat = [
                        'entity_name' => $company->name,
                        'entity_id' => $company->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'company'
                    ];
                    //push entity_stat into stat array
                    array_push($company_stat, $entity_stat);
                    array_merge($all_employees, $employees);
                }
            }
            if ($client->use_departments && !$client->multiple_company && !$collected && !$client->multiple_sectors) {
                $company = $client->sectors->first()->companies()->first();
                //Superdir
                foreach ($company->departments->where('dep_level', 1) as $department) {
                    $employees = [];
                    $employees = $this->getEmployeeOfEntity($department->id, $cid, 'department');
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $entity_stat = [
                        'entity_name' => $department->name,
                        'entity_id' => $department->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'department'
                    ];
                    array_push($super_dir_stat, $entity_stat);
                    // array_merge($all_employees, $employees);
                    $all_employees = array_unique(array_merge($all_employees, $employees));
                }
                //directorate
                foreach ($company->departments->where('dep_level', 2) as $department) {
                    $employees = [];
                    $employees = $this->getEmployeeOfEntity($department->id, $cid, 'department');
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $sum_of_answered += $answered;
                    $entity_stat = [
                        'entity_name' => $department->name,
                        'entity_id' => $department->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'department',

                    ];
                    array_push($dir_stat, $entity_stat);
                    $all_employees = array_unique(array_merge($all_employees, $employees));
                }
                //division
                foreach ($company->departments->where('dep_level', 3) as $department) {
                    $employees = [];
                    $employees = $this->getEmployeeOfEntity($department->id, $cid, 'department');
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $branch_title_collected = false;
                    $entity_stat = [
                        'entity_name' => $department->name,
                        'entity_id' => $department->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'department',
                    ];
                    array_push($div_stat, $entity_stat);
                    $all_employees = array_unique(array_merge($all_employees, $employees));
                }
                //department
                foreach ($company->departments->where('dep_level', 4) as $department) {
                    $employees = [];
                    $employees = $this->getEmployeeOfEntity($department->id, $cid, 'department');
                    $respondents = $this->getRespondentsIds($employees, $id);
                    $answered = $this->getNumberAnswered($respondents, $id);
                    $sum_of_employees += count($employees);
                    $sum_of_respondents += count($respondents);
                    $entity_stat = [
                        'entity_name' => $department->name,
                        'entity_id' => $department->id,
                        'employee' => count($employees),
                        'respondents' => count($respondents),
                        'answered' => $answered,
                        'percentage' => ($answered / count($respondents)) * 100,
                        'type' => 'department',
                    ];
                    array_push($deps_stat, $entity_stat);
                    $all_employees = array_unique(array_merge($all_employees, $employees));
                }
                //section
                // foreach ($company->departments->where('dep_level', 5) as $department) {
                //     $employees = [];
                //     $employees = $this->getEmployeeOfEntity($department->id, $cid, 'department');
                //     $respondents = $this->getRespondentsIds($employees, $id);
                //     $answered = $this->getNumberAnswered($respondents, $id);
                //     $entity_stat = [
                //         'entity_name' => $department->name,
                //         'entity_id' => $department->id,
                //         'employee' => count($employees),
                //         'respondents' => count($respondents),
                //         'answered' => $answered,
                //         'percentage' => ($answered / count($respondents)) * 100,
                //         'type' => 'department',
                //         'region' => $department->region_name,
                //         'branch' => $department->branch_name,
                //     ];
                //     array_push($div_stat, $entity_stat);
                // }
                //get all employees of company
                $employees_ = Employees::where('comp_id', $company->id)->pluck('id')->toArray();

                $respondents_ = Respondents::where('survey_id', $id)->pluck('id')->toArray();
                //get answers distinct answered by
                $answered_ = SurveyAnswers::where('survey_id', $id)->distinct()->count('answered_by');
            }


            $data = [
                'sector_stat' => $sector_stat,
                'company_stat' => $company_stat,
                'region_stat' => $region_stat,
                'branch_stat' => $branch_stat,
                'super_dir_stat' => $super_dir_stat,
                'dir_stat' => $dir_stat,
                'div_stat' => $div_stat,
                'deps_stat' => $deps_stat,
                'survey' => $survey,
                'sum_of_employees' => count($employees_),
                'sum_of_respondents' => count($respondents_),
                'sum_of_answered' => $answered_,
                'total_percentage' => ($answered_ / count($respondents_)) * 100,
                'client' => $client,
                'type' => $survey->plans->service_->service_type
            ];
            return view('dashboard.client.SurveyStatistics')->with($data);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    // recusive function to get all employee of an entity
    public function getEmployeeOfEntity($entity_id, $client, $entity_type): array
    {
        $employees = [];
        if ($entity_type == 'org') {
            $sectors = Sectors::where('client_id', $client)->get();
            foreach ($sectors as $sector) {
                //foreach sector companies
                foreach ($sector->companies as $company) {
                    $employees = array_merge($employees, $this->getEmployeeOfEntity($company->id, $client, 'company'));
                }
            }
        } elseif ($entity_type == 'sector') {
            $sectors = Sectors::find($entity_id);
            foreach ($sectors->companies  as $company) {
                $employees = array_merge($employees, $this->getEmployeeOfEntity($company->id, $client, 'company'));
            }
        } elseif ($entity_type == 'company') {
            //find client
            $client = Clients::find($client);
            $company = Companies::find($entity_id);
            //check if client use department
            if ($client->use_departments) {
                //foreach company departments
                foreach ($company->departments->where('dep_level', 1) as $department) {
                    $employees = array_merge($employees, $this->getEmployeeOfEntity($department->id, $client, 'department'));
                }
            } else {
                //foreach company employees
                $employees =  $company->employees->pluck('id')->toArray();
            }
        } elseif ($entity_type == 'department') {
            //find department
            $department = Departments::find($entity_id);
            $employees = $department->employees->pluck('id')->toArray();
            //foreach department subDepartments
            foreach ($department->subDepartments as $subDepartment) {
                $employees = array_merge($employees, $this->getEmployeeOfEntity($subDepartment->id, $client, 'department'));
            }
        }
        return $employees;
    }
    //get respondents ids
    private function getRespondentsIds($employees, $survey)
    {
        return Respondents::whereIn('employee_id', $employees)->where('survey_id', $survey)->pluck('id')->toArray();
    }
    private function getNumberAnswered($respondents, $survey)
    {
        return SurveyAnswers::whereIn('answered_by', $respondents)->where('survey_id', $survey)->distinct('answered_by')->count();
    }
    //AssignAsUser function
    function AssignAsUser(Request $request, $id, $cid, $is_admin = false)
    {
        try {
            //get client
            $client = Clients::find($cid);
            //get employee
            $employee = Employees::find($id);
            //check if employee is already assigned
            $assigned = User::where('email', $employee->email)->first();
            if ($assigned) {
                return response()->json(['message' => 'User already assigned', 'stat' => false], 400);
            }
            //generate random password of length 8
            $password = Landing::generateRandomPassword();
            //create new user
            $user = new User();
            $user->name = $employee->name;
            $user->email = $employee->email;
            $user->password = bcrypt($password);
            $user->client_id = $cid;
            $user->partner_id = $client->partner_id;
            $user->sector_id = $employee->sector_id;
            $user->comp_id = $employee->comp_id;
            $user->dep_id = $employee->dep_id;
            $user->user_type = "client";
            $user->emp_id = $employee->id;
            $user->save();
            //send account info
            // (new SendSurvey($emails, $data))->delay(now()->addSeconds(2));
            $job = (new SendAccountInfoJob($employee->email, $password))->delay(now()->addSeconds(2));
            dispatch($job);
            return response()->json(['message' => 'User assigned successfully', 'stat' => true], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error assigning user', 'stat' => false], 500);
        }
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
        $practice_results = [];
        $ENPS_data_array = [];
        $outcome_functions_practice = [];
        $Outcome_practice_results = [];
        $function_results = [];
        $outcome_function_results = [];
        $outcome_function_results_1 = [];
        $entity = '';
        $this->id = $Survey_id;
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
        foreach (Functions::where('service_id', $service)->get() as $function) {
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
            'entity_name' => $entity_name,
            'entity_id' => $entity_id,
            'there_is_answer' => $there_is_answer
        ];
        return $data;
    }
    function averageArrays($array1, $array2)
    {
        $result = [];
        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->averageArrays($value, $array2[$key]);
            } elseif (is_string($value)) {
                // If the value is a string, do not average it
                $result[$key] = $value;
            } else {
                $result[$key] = ($value + $array2[$key]) / 2;
            }
        }
        return $result;
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
    //DownloadSurveyResults function
    function DownloadSurveyResults($survey_id, $type, $type_id = null, $admin = null)
    {
        //export result
        return Excel::download(new SurveyAnswersExport($survey_id, $type, $type_id = null), 'survey_results.xlsx');
    }
}
