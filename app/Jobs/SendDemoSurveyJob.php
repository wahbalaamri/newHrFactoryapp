<?php

namespace App\Jobs;

use App\Mail\SendDemoSurvey;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDemoSurveyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $link;
    private $email;
    public function __construct($link,$email)
    {
        //
        $this->link = $link;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        try
        {
            Mail::to($this->email)->send(new SendDemoSurvey($this->link));
        }
        catch (\Exception $e)
        {
            //log error
            Log::error('Error sending demo survey email: '.$e->getMessage());
        }
    }
}
