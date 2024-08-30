<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\FunctionPractices;
use App\Models\Functions;
use App\Models\PracticeQuestions;
use App\Models\Respondents;
use App\Models\Sectors;
use App\Models\Services;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SetEmployeeDataFromOldTools implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $client_old_id;
    private $use_dep;
    private $tool;
    public function __construct($client_old_id, $use_dep, $tool)
    {
        //
        $this->client_old_id = $client_old_id;
        $this->use_dep = $use_dep;
        $this->tool = $tool;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::info($this->client_old_id);
        Log::info($this->use_dep);
        Log::info($this->tool);
        $sector_looper = 0;
        $company_looper = 0;
        if ($this->tool == 1) {
            //3h
            if ($this->use_dep == 0) {
                //get data from https://3h.hrfactoryapp.com/getClientData/
                $data = json_decode(file_get_contents('https://3h.hrfactoryapp.com/getClientData/' . $this->client_old_id . '/' . $this->use_dep), true);
                // Log::info($data);
                //get client details
                $client_name = $data['ClientName'];
                $client_phone = $data['ClientPhone'];
                $Cilent_focal_point_name = $data['CilentFPName'];
                $Cilent_focal_point_email = $data['CilentFPEmil'];
                //industry
                $industry = 136;
                //size
                $client_size = 1;
                //country
                //get oman id from countries
                $country = Countries::where('name', "Oman")->first()->id;
                //find client
                $client = Clients::where('name', $client_name)->first();
                //if client not found
                if (!$client) {
                    $client = new Clients();
                }
                //set client details
                $client->name = $client_name;
                $client->country = $country;
                $client->industry = $industry;
                $client->client_size = $client_size;
                $client->use_departments = false;
                $client->use_sections = false;
                $client->save();
                $client_new_id = $client->id;
                //find focal point
                $focal_point = FocalPoints::where('client_id', $client_new_id)->where('email', $Cilent_focal_point_email)->first();
                //if focal point not found
                if (!$focal_point) {
                    $focal_point = new FocalPoints();
                }
                //set focal point details
                $focal_point->client_id = $client_new_id;
                $focal_point->name = $Cilent_focal_point_name;
                $focal_point->email = $Cilent_focal_point_email;
                $focal_point->phone = $client_phone;
                $focal_point->save();
                //save user
                //find user
                $user = User::where('email', $Cilent_focal_point_email)->where('client_id', $client_new_id)->first();
                //if user not found
                if (!$user) {
                    $user = new User();
                }
                //set user details
                $user->client_id = $client_new_id;
                $user->name = $Cilent_focal_point_name;
                $user->email = $Cilent_focal_point_email;
                $user->user_type = "client";
                $user->is_active = true;
                $user->password = bcrypt('123456');
                $user->is_main = true;
                $user->save();
                //find employee
                $employee = Employees::where('email', $Cilent_focal_point_email)->where('client_id', $client_new_id)->first();
                //if employee not found
                if (!$employee) {
                    $employee = new Employees();
                }
                //set employee details
                $employee->client_id = $client_new_id;
                $employee->name = $Cilent_focal_point_name;
                $employee->email = $Cilent_focal_point_email;
                $employee->mobile = $client_phone;
                $employee->employee_type = 2;
                $employee->added_by = 1;
                $employee->save();
                //get all sectors
                $sectors = $data['sectors'];
                //loop through all sectors
                foreach ($sectors as $sector) {
                    //get sector name
                    $sector_name = $sector['sector_name_en'];
                    $sector_name_ar = $sector['sector_name_ar'];
                    // find sector
                    $sector = Sectors::where('client_id', $client_new_id)->where('name_en', $sector_name)->first();
                    //if sector not found
                    if (!$sector) {
                        $sector = new Sectors();
                    }
                    //set sector details
                    $sector->client_id = $client_new_id;
                    $sector->name_en = $sector_name;
                    $sector->name_ar = $sector_name_ar;
                    $sector->save();
                    //sector id
                    $sector_id = $sector->id;
                    //get all companies
                    $companiesd = $data['sectors'][$sector_looper]['companies'];

                    //loop through all companies
                    $company_looper = 0;
                    foreach ($companiesd as $company) {
                        //get company name
                        $company_name = $company['company_name_en'];
                        $company_name_ar = $company['company_name_ar'];
                        //find company
                        $company = Companies::where('sector_id', $sector_id)->where('client_id', $client_new_id)->where('name_en', $company_name)->first();
                        //if company not found
                        if (!$company) {
                            $company = new Companies();
                        }
                        //set company details
                        $company->sector_id = $sector_id;
                        $company->client_id = $client_new_id;
                        $company->name_en = $company_name;
                        $company->name_ar = $company_name_ar;
                        $company->save();
                        //company id
                        //get all emails
                        $emails =  $data['sectors'][$sector_looper]['companies'][$company_looper++]['emails'];
                        //loop through all emails
                        foreach ($emails as $email) {
                            //find employee
                            $employee = Employees::where('email', $email['Email'])->where('client_id', $client_new_id)->first();
                            //if employee not found
                            if (!$employee) {
                                $employee = new Employees();
                            }
                            //set employee details
                            $employee->client_id = $client_new_id;
                            $employee->sector_id = $sector_id;
                            $employee->comp_id = $company->id;
                            $employee->email = $email['Email'];
                            $employee->employee_type = 2;
                            $employee->added_by = 1;
                            $employee->mobile = $email['Mobile'];
                            $employee->emp_id = $email['id'];
                            $employee->save();
                        }
                    }
                    $sector_looper++;
                }
                //get plans of service with service_type =3
                $service = Services::where('service_type', 3)->first();

                //get functions ids
                $functions = Functions::where('service_id', $service->id)->pluck('id')->toArray();
                //get practices ids
                $practices = FunctionPractices::whereIn('function_id', $functions)->pluck('id')->toArray();
                //get plans
                $plan = $service->plans->first();
                //find survey using client_id plan_id
                $survey = Surveys::where('client_id', $client_new_id)->where('plan_id', $plan->id)->first();
                //if survey not found
                if (!$survey) {
                    $survey = new Surveys();
                }
                $survey->client_id = $client_new_id;
                $survey->survey_title = "Employee Engagment Survey From Old Tool";
                $survey->survey_des = "Employee Engagment Survey From Old Tool";
                $survey->survey_stat = true;
                $survey->plan_id = $plan->id;
                $survey->save();
                $survey_id = $survey->id;
                //get this client employees
                $employees = Employees::where('client_id', $client_new_id)->get();
                //loop through all employees
                foreach ($employees as $employee) {
                    $respondent = Respondents::where('employee_id', str($employee->id))->where('survey_id', $survey_id)->where('client_id', $client_new_id)->first();
                    $bracker = 1;
                    if (!$respondent) {
                        $respondent = new Respondents();

                        $respondent->employee_id = str($employee->id);
                        $respondent->survey_id = $survey_id;
                        $respondent->client_id = $client_new_id;
                        $respondent->survey_type = 3;
                        $respondent->save();
                        //respondent id
                        $respondent_id = $respondent->id;
                        //get answers
                        $url = 'https://3h.hrfactoryapp.com/getRespondentAnswers/' . $employee->emp_id;
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                        $answers = json_decode(curl_exec($ch));
                        //loop through all answers
                        foreach ($answers as $answer) {
                            Log::info(json_decode($answer));
                            Log::info($answer->SurveyId);
                            //get question
                            $question = $answer['question']['Question'];
                            //get question
                            $newQuestion = PracticeQuestions::where('question', $question)->first();
                            //get answer
                            $answervalue = $answer['AnswerValue'];
                            $answer = SurveyAnswers::where('answered_by', $respondent_id)->where('question_id', $newQuestion->id)->first();
                            //save answer
                            if (!$answer)
                                $answer = new SurveyAnswers();
                            $answer->answered_by = $respondent_id;
                            $answer->question_id = $newQuestion->id;
                            $answer->answer_value = $answervalue;
                            $answer->survey_id = $survey_id;
                            $answer->save();
                        }
                        $bracker++;
                    }
                    //sleep for 10 seconds
                    if ($bracker % 500 == 0)
                        sleep(3);
                    //update employee emp_id
                    $employee->emp_id = null;
                    $employee->save();
                }
            }
        }
    }
}
