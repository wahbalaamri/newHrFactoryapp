<?php

namespace App\Jobs;

use App\Http\Facades\Landing;
use App\Mail\SendAccountInfoMail;
use App\Models\Employees;
use App\Models\Partners;
use App\Models\Partnerships;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAccountInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $email;
    private $password;
    public function __construct($email, $password)
    {
        //
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $data = [];
            $data['subject'] = 'Account Information';
            //find employee
            $employee = Employees::where('email', $this->email)->first();
            $data['password'] = $this->password;
            $data['email'] = $this->email;
            $data['name'] = $employee->name;
            $data['position'] = $employee->position;
            //get company
            $company = $employee->company;
            $data['company'] = $company->name_en;
            //get client
            $client = $employee->client;
            $data['client_logo'] = $client->logo_path;
            if ($client->partner_id != null) {
                //find partner
                $partner = Partners::where('id', $client->partner_id)->first();
                $data['partner_logo'] = $partner->logo_path;
                //get partner focal point
                $partner_focal_point = $partner->focalPoints->first();
                $data['partner_email'] = $partner_focal_point->Email;
                $data['partner_phone'] = $partner_focal_point->phone;
            } else {
                //get current country
                $country = Landing::getCurrentCountry();
                //find partnership for current country
                $partnership = Partnerships::where('country_id', $country)->first();
                if ($partnership) {
                    //get partner partner
                    $data['partner_logo'] = $partnership->partner->logo_path;
                    $partner_focal_point = $partnership->partner->focalPoints->first();
                    $data['partner_email'] = $partner_focal_point->Email;
                    $data['partner_phone'] = $partner_focal_point->phone;
                } else {
                    $default_partnership = Partnerships::where('country_id', Landing::getDefaultCountry())->first();
                    $data['partner_logo'] = $default_partnership->partner->logo_path;
                    $partner_focal_point = $partnership->partner->focalPoints->first();
                    $data['partner_email'] = $partner_focal_point->Email;
                    $data['partner_phone'] = $partner_focal_point->phone;
                }
            }
            //partner_id
            Mail::to($this->email)->send(new SendAccountInfoMail($data));
        } catch (\Exception $e) {
            //log error
            Log::error('Error sending account info email: ' . $e->getMessage());
            Log::error($e);
        }
    }
}