<?php

namespace App\Http\services;

use App\Models\ClientSubscriptions;
use App\Models\Plans;
use App\Models\Services;
use App\Models\Surveys;
use Illuminate\Support\Facades\Log;

class UserSubscriptionsService
{

    // check if current user can add new survey
    public function canAddNewSurvey($user_id, $service_id): bool
    {
        //get service plans
        $plans = Services::find($service_id)->plans->pluck('id')->toArray();
        //check if user has active plan
        $subscription = ClientSubscriptions::where('client_id', $user_id)
            ->whereIn('plan_id', $plans)
            ->where('is_active', true)
            ->first();
        if (!$subscription) {
            return false;
        }
        //get plan_id
        $plan_id = $subscription->plan_id;
        //get plan
        $plan = Plans::find($plan_id);
        if ($plan->plan_type == 5  && $plan->surveys->where('survey_stat', true)->where('client_id', $user_id)->count() > 0) {
            return false;
        }
        if ($plan->plan_type == 5 && $plan->surveys->where('client_id', $user_id)->count() >= 3)
            return false;
        //if plan is not premium and it has at least one survey
        if ($plan->plan_type != 1 && $plan->plan_type != 5 && $plan->surveys->where('client_id', $user_id)->count() > 0) {

            return false;
        }
        //if plan is premium and it has one survey is active
        if ($plan->plan_type == 1  && $plan->surveys->where('survey_stat', true)->where('client_id', $user_id)->count() > 0) {
            return false;
        }
        return true;
    }
    //checkSubscriptions function
    public function checkSubscriptions()
    {
        $subscriptions = ClientSubscriptions::where('is_active', true)
            ->whereDate('end_date', '<', date('Y-m-d'))
            ->get();
        return $subscriptions;
    }
    //deactivateSubscriptions function
    public function deactivateSubscriptions($subscriptions)
    {
        foreach ($subscriptions as $subscription) {
            $subscription->is_active = false;
            $subscription->save();
        }
    }
    public function canViewService($user_role, $client_id, $service_type): bool
    {
        if ($user_role == 'admin') {
            return true;
        }
        //get service
        $service = Services::where('service_type', $service_type)->first();
        if ($service) {
            if ($service->public_availability) {
                return true;
            }
            if ($service->service_client == $client_id) {
                return true;
            }
        }
        return false;
    }
}
