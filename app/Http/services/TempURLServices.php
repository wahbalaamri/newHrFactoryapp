<?php

namespace App\Http\services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class TempURLServices
{
    public function __construct()
    {
        //
    }
    public function getTempURL($url_name, $time_in_minutes, $id = null)
    {
        //generate temp url
        if ($id)
            return URL::temporarySignedRoute($url_name, now()->addMinutes($time_in_minutes), $id);
        return URL::temporarySignedRoute($url_name, now()->addMinutes($time_in_minutes));
    }
    public function getIsValidUrl(Request $request)
    {
        return $request->hasValidSignature();
    }
    public function getIsExpUrl($signature, $expires_at)
    {
        $isValid = false;
        return $isValid;
    }
    public function treminateUrl($signature, $expires_at)
    {
        $isExpired = false;
        return $isExpired;
    }
}
