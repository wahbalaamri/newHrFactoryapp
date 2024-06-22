<?php

namespace App\Http\services;

use App\Models\ClientSubscriptions;
use App\Models\Countries;
use App\Models\Partners;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class LandingService
{
    public function __construct()
    {
        //
    }
    //get current country
    public function getCurrentCountry()
    {
        //using api detect current location
        $url = "https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd";
        $json = file_get_contents($url);
        $data = json_decode($json);
        Log::info($data->countryCode);
        $countryCode = $data->countryCode;
        $country = Countries::where('country_code', $countryCode)->first();
        return $country->id;
    }
    //get partner
    public function getPartner()
    {
        return Partners::where('id', function ($querey) {
            $querey->select('partner_id')->from('partnerships')->where('country_id', $this->getCurrentCountry());
        })->first();
    }
    //check user subscription
    public function CheckUserSubscription($id, $service_type)
    {
        //get service id
        $service = Services::where('service_type', $service_type)->first();
        if ($service) {
            //get service plans
            $plans = $service->plans->pluck('id')->toArray();
            //get user subscription
            $subscription = ClientSubscriptions::where('client_id', $id)->whereIn('plan_id', $plans)->where('is_active', true)->get();
            if ($subscription->count() > 0) {
                return true;
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }
}
