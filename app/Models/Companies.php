<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model
{
    use HasFactory,SoftDeletes;
    // table name
    protected $table = 'companies';
    //fields
    protected $fillable = [
        'name_en',
        'name_ar',
        'sector_id',
    ];
    //belongs to sector
    public function sector()
    {
        return $this->belongsTo(Sectors::class, 'sector_id', 'id');
    }
    //has many departments
    public function departments()
    {
        return $this->hasMany(Departments::class, 'company_id', 'id');
    }
    //company name
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
}
