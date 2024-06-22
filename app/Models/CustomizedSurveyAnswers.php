<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizedSurveyAnswers extends Model
{
    use HasFactory;
    //belongs to customized question
    public function question()
    {
        return $this->belongsTo(CustomizedSurveyQuestions::class);
    }
}
