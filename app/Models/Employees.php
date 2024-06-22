<?php

namespace App\Models;

use App\Http\traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    //table name
    protected $table = 'employees';
    protected $keyType = 'string';
    protected $KeyName = 'id';
    public $incrementing = false;

    //fields
    protected $fillable = [
        'client_id',
        'sector_id',
        'comp_id',
        'dep_id',
        'email',
        'mobile',
        'name',
        'Employee_type',
        'position',
    ];
    //relationships
    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }
    public function sector()
    {
        return $this->belongsTo(Sectors::class, 'sector_id');
    }
    public function company()
    {
        return $this->belongsTo(Companies::class, 'comp_id');
    }
    public function department()
    {
        return $this->belongsTo(Departments::class, 'dep_id');
    }
    public function surveys()
    {
        return $this->belongsToMany(Respondents::class, 'survey_employees', 'employee_id', 'survey_id');
    }
    //check if employee is from hr department
    public function getIsHrAttribute()
    {
        return $this->department->is_hr;
    }

}
