<?php

namespace App\Jobs;

use App\Http\Facades\Calculate3hResultsFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Calculate3hResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $client_id, $service_type, $survey_id, $vtype, $vtype_id, $by_admin;
    public function __construct($client_id, $service_type, $survey_id, $vtype, $vtype_id, $by_admin)
    {
        //
        $this->client_id = $client_id;
        $this->service_type = $service_type;
        $this->survey_id = $survey_id;
        $this->vtype = $vtype;
        $this->vtype_id = $vtype_id;
        $this->by_admin = $by_admin;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $result = Calculate3hResultsFacade::SurveyResults($this->client_id, $this->service_type, $this->survey_id, $this->vtype, $this->vtype_id, $this->by_admin);
        //save result to session
        session()->put('resultOf3h', $result);
        //redirect ShowSurveyResults
        redirect()->route('clients.ShowSurveyResults');
    }
}
