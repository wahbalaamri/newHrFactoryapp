<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CustomizedSurvey extends Model
{
    use HasFactory;
    //belongs to Plans
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id');
    }
    //hasmany Customized survey functions
    public function functions()
    {
        return $this->hasMany(CustomizedSurveyFunctions::class, 'survey');
    }
    //get all customized survey questions

}
