<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizedSurveyFunctions extends Model
{
    use HasFactory;
    //belongs to Customized Survey
    public function survey()
    {
        return $this->belongsTo(CustomizedSurvey::class,'survey');
    }
    //belongs to Clients
    public function client()
    {
        return $this->belongsTo(Clients::class,'client');
    }
    //has many customized practice
    public function practices()
    {
        return $this->hasMany(CustomizedSurveyPractices::class,'function_id');
    }
    //getTranslatedTitleAttribute
    public function getTranslatedTitleAttribute()
    {
        return app()->isLocale('en') ? $this->title : $this->title_ . app()->getLocale();
    }

}
