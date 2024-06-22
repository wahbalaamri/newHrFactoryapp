<?php

namespace App\Models;

use App\Http\traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respondents extends Model
{
    use HasFactory,SoftDeletes,Uuid;
    // table name
    protected $table = 'respondents';
    protected $keyType = 'string';
    public $incrementing = false;
    //fields
    protected $fillable = [
        'id',
        'survey_id',
        'client_id',
        'employee_id',
        'survey_type',
    ];
    //belongs to department
    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id', 'id');
    }
    //relationship with surveys
    public function surveys()
    {
        return $this->belongsToMany(Surveys::class,  'employee_id', 'survey_id');
    }
}
