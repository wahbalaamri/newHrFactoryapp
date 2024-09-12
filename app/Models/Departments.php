<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use HasFactory,SoftDeletes;
    // table name
    protected $table = 'departments';
    //fields
    protected $fillable = [
        'name_en',
        'name_ar',
        'company_id',
    ];
    //belongs to company
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
    //has many employees
    public function employees()
    {
        return $this->hasMany(Employees::class, 'dep_id', 'id');
    }
    //has many relations to self
    public function subDepartments()
    {
        return $this->hasMany(Departments::class, 'parent_id', 'id');
    }
    //belongs to parent
    public function parent()
    {
        return $this->belongsTo(Departments::class, 'parent_id', 'id');
    }
    //department name
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
/**
     * Check if the department is a Super Directorate.
     */
    public function isSuperDirectorate()
    {
        return $this->dep_level === 1;
    }

    /**
     * Check if the department is a Directorate.
     */
    public function isDirectorate()
    {
        return $this->dep_level === 2;
    }

    /**
     * Check if the department is a Division.
     */
    public function isDivision()
    {
        return $this->dep_level === 3;
    }

    /**
     * Check if the department is a Department.
     */
    public function isDepartment()
    {
        return $this->dep_level === 4;
    }
    /**
     * Check if the department is a Section.
     */
    public function isSection()
    {
        return $this->dep_level === 5;
    }
}
