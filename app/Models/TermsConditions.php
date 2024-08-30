<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermsConditions extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'terms_conditions';
    protected $fillable = [
        'plan_id',
        'country_id',
        'period',
        'arabic_text',
        'english_text',
        'arabic_title',
        'english_title',
        'is_active',
        'for',
        'service',
    ];
    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }
    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
    //attribute to get translated title
    public function getTitleAttribute()
    {
        return app()->isLocale('en') ? $this->english_title : $this->arabic_title;
    }
    //attribute to get translated text
    public function getTextAttribute()
    {
        return app()->isLocale('en') ? $this->english_text : $this->arabic_text;
    }
}
