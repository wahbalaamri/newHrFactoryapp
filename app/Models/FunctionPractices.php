<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunctionPractices extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'function_practices';
    protected $fillable = ['title', 'title_ar', 'description', 'description_ar', 'respondent', 'status', 'function_id'];
    public function function()
    {
        return $this->belongsTo(Functions::class, 'function_id');
    }
    // relation with questions
    public function questions()
    {
        return $this->hasMany(PracticeQuestions::class, 'practice_id');
    }
    //attribute tarnslated title
    public function getTranslatedTitleAttribute($value)
    {
        return app()->getLocale() == 'en' ? $this->title : $this->{'title_' . app()->getLocale()};
    }
}
