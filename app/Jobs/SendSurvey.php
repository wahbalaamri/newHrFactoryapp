<?php

namespace App\Jobs;

use App\Mail\SurveyMail;
use App\Models\Respondents;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSurvey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $data;
    private $emails;
    public function __construct($emails,$data)
    {
        //
        $this->data = $data;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       try
       {
         foreach ($this->emails as $email) {
            //add id of email to data
            $this->data['id'] = $email['id'];
            //send email
            Mail::to($email['email'])->send(new SurveyMail($this->data));
            //update response status
            $respondent=Respondents::where('id',$email['id'])->first();
            $respondent->send_status=true;
            $respondent->sent_date=date('Y-m-d H:i:s');
            $respondent->save();

        }
       }
         catch (\Exception $e)
         {
              //log error
              Log::error('Error sending survey email: '.$e->getMessage());

         }
    }
}
