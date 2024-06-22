<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeQuestions extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'practice_questions';
    protected $fillable = ['title', 'title_ar', 'description', 'description_ar', 'respondent', 'status', 'practice_id'];
    public function practice()
    {
        return $this->belongsTo(FunctionPractices::class, 'practice_id');
    }
    //attribute tarnslated title
    public function getTranslatedTitleAttribute($value)
    {
        return app()->getLocale() == 'en' ? $this->question : $this->{'question_' . app()->getLocale()};
    }
}
