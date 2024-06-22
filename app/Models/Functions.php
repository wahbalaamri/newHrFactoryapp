<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Functions extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'functions';
    protected $fillable = ['title', 'title_ar', 'description', 'description_ar', 'respondent', 'status', 'service_id'];
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function practices()
    {
        return $this->hasMany(FunctionPractices::class, 'function_id');
    }
    //attribute tarnslated title
    public function getTranslatedTitleAttribute($value)
    {
        return app()->getLocale() == 'en' ? $this->title : $this->{'title_' . app()->getLocale()};
    }
}
