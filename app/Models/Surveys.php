<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surveys extends Model
{
    use HasFactory,SoftDeletes;
    //table name
    protected $table = 'surveys';
    //primary key
    public $primaryKey = 'id';
    //fields
    protected $fillable = [
        'client_id',
        'plan_id',
        'subscription_plan_id',
        'survey_title',
        'survey_des',
        'survey_stat'
    ];
    //relationship with clients
    public function clients()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
    //relationship with plans
    public function plans()
    {
        return $this->belongsTo(Plans::class, 'plan_id');
    }
    //relationship with respondents
    public function respondents()
    {
        return $this->hasMany(Respondents::class, 'survey_id');
    }

}
