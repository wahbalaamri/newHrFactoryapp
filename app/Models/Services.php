<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    // Table Name
    protected $table = 'services';
    //fillable fields
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'objective',
        'objective_ar',
        'service_user',
        'FW_uploaded_video',
        'framework_media_path',
        'FW_uploaded_video_ar',
        'framework_media_path_ar',
        'service_fileType',
        'service_uploaded_video',
        'service_media_path',
        'service_type',
        'country',
        'is_active',
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
    //has many relationship with services features
    public function features()
    {
        //set up relationship with service features with cascade delete
        return $this->hasMany(ServiceFeatures::class,'service','id');
    }
    //has many relationship with services approache
    public function approaches()
    {
        return $this->hasMany(ServiceApproaches::class,'service','id');
    }
    //has many relationship with service plans
    public function plans()
    {
        return $this->hasMany(Plans::class,'service','id');
    }
    //name attribute
    public function getServiceNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name;
    }

}
