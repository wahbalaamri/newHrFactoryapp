<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizedSurveyQuestions extends Model
{
    use HasFactory;

    //belong to practice
    public function practice()
    {
        return $this->belongsTo(CustomizedSurveyPractices::class);
    }
    //hasmany Customized survey answers
    public function answers()
    {
        return $this->hasMany(CustomizedSurveyAnswers::class);
    }
    //getTranslatedQuestionAttribute
    public function getTranslatedQuestionAttribute()
    {
        return app()->isLocale('en') ? $this->question : $this->question_ . app()->getLocale();
    }
}
