<?php

namespace App\Http\services;

use App\Models\Clients;
use App\Models\ClientSubscriptions;
use App\Models\Countries;
use App\Models\PartnerFocalPoint;
use App\Models\Partners;
use App\Models\Partnerships;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
                $country = Countries::where('country_code', $countryCode)->first();
                return $country->id;
            }
        }
        //using api detect current location
        $url = "https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd";
        $json = file_get_contents($url);
        $data = json_decode($json);
        $countryCode = $data->countryCode;
        $country = Countries::where('country_code', $countryCode)->first();
        return $country->id;
    }
    //get partner
    public function getPartner()
    {
        return Partners::where('is_main', true)->whereIn('id', function ($querey) {
            $querey->select('partner_id')->from('partnerships')->where('country_id', $this->getCurrentCountry());
        })->first();
    }
    public function getDefaultPartner()
    {
        return Partners::where('is_main', true)->whereIn('id', function ($querey) {
            $querey->select('partner_id')->from('partnerships')->where('country_id', $this->getDefaultCountry());
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
    function getDefaultCountry()
    {
        return Countries::where('name', "Oman")->first()->id;
    }
    function generateRandomPassword()
    {
        return Str::password(8, true, true, false, false);
    }

    function HasService($email, $service_type): bool
    {
        //get the focal point
        $focal_point = PartnerFocalPoint::where('Email', $email)->first();
        $service = Services::where('service_type', $service_type)->first();
        //partnerships
        $service = 's-' . $service->id;
        $partnership_services = json_decode(Partnerships::where('partner_id', $focal_point->partner_id)
            ->where('country_id', $focal_point->country)
            ->where('is_active', true)
            ->first()->services, true);
        //check if service exists
        $keys = array_keys($partnership_services);
        return in_array($service, $keys);
    }
    function isMainPartner($email)
    {
        $focal_point = PartnerFocalPoint::where('Email', $email)->first();
        $partner = Partners::where('id', $focal_point->partner_id)->first();
        return $partner->is_main;
    }
    function getPartnerLogo($partner_id = null): string
    {
        if ($partner_id) {
            $partner = Partners::where('id', $partner_id)->first();
            if ($partner) {
                return $partner->logo_path;
            }
        }
        $country_partner = $this->getPartner();
        if ($country_partner != null) {
            return $country_partner->logo_path;
        }
        return $this->getDefaultPartner()->logo_path;
    }
}
