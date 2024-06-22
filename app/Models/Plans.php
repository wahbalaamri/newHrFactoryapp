<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plans extends Model
{
    use HasFactory, SoftDeletes;
    //many to one relationship userPlans
    public function userPlans()
    {
        return $this->hasMany(UserPlans::class, 'PlanId');
    }
    //get plan name
    public function getPlanNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name;
    }
    //belongs to relationship with services
    public function service_()
    {
        return $this->belongsTo(Services::class, 'service');
    }
    //belongs to relationship with plansPrices
    public function plansPrices()
    {
        return $this->hasMany(PlansPrices::class, 'plan');
    }
    //get array of plan features IDs
    public function getFeaturesAttribute()
    {
        return $this->features_obj()->pluck('feature_id')->toArray();
    }
    //belongs to many relationship with features
    public function features_obj()
    {
        return $this->hasMany(PlanFeatures::class, 'plan');
    }
    //belongs to relationship with surveys
    public function surveys()
    {
        return $this->hasMany(Surveys::class, 'plan_id');
    }
    //belongs to relationship with TermsConditions
    public function termsConditions()
    {
        return $this->hasOne(TermsConditions::class, 'plan_id');
    }
    //belongs to relationship with ClientSubscriptions
    public function clientSubscriptions()
    {
        return $this->hasMany(ClientSubscriptions::class, 'plan_id');
    }
    //belongs to relationship with customized surveys
    public function customizedSurveys()
    {
        return $this->hasMany(CustomizedSurvey::class, 'plan_id');
    }
}
