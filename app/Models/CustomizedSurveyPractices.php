<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizedSurveyPractices extends Model
{
    use HasFactory;
    //hasmany Customized survey questions
    public function questions()
    {
        return $this->hasMany(CustomizedSurveyQuestions::class);
    }
    //belongs to Customized function
    public function function()
    {
        return $this->belongsTo(CustomizedSurveyFunctions::class);
    }
    //getTranslatedTitleAttribute
    public function getTranslatedTitleAttribute()
    {
        return app()->isLocale('en') ? $this->title : $this->title_ . app()->getLocale();
    }
}
