<?php

namespace App\Http\services;

use App\Models\Clients;
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
        //get client country
        $ipAddress = request()->ip() ?? null; // Get client's IP address
        if ($ipAddress != '127.0.0.1') {
            $clientCountry = $ipAddress ? "http://ipinfo.io/$ipAddress/json" : null; // Get client's country
            if ($clientCountry) {
                $json = file_get_contents($clientCountry);
                $data = json_decode($json);
                $countryCode = $data->country;
                //   Log::info( $countryCode );
                $country = Countries::where('country_code', $countryCode)->first();
                return $country->id;
            }
        }
        //using api detect current location
        $url = "https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd";
        $json = file_get_contents($url);
        // Log::info($json);
        $data = json_decode($json);
        // Log::info($data->countryCode);
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
        } else {
            return false;
        }
    }
    //get client logo
    public function getClientLogo()
    {
        if (Auth()->user()->user_type == 'partner') {
            $partner = Partners::find(auth()->user()->partner_id);
            if ($partner) {
                return $partner->logo_path;
            } else {
                return null;
            }
        } else {
            $client = Clients::find(auth()->user()->client_id);
            if ($client) {
                return $client->logo_path;
            } else {
                return null;
            }
        }
    }
}
