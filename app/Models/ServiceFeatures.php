<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceFeatures extends Model
{
    use HasFactory, SoftDeletes;
    // Table Name
    protected $table = 'service_features';
    //fillable fields
    protected $fillable = [
        'service',
        'feature',
        'feature_ar',
        'is_active',
    ];
    //has many relationship with services
    public function services()
    {
        return $this->belongsTo(Services::class,'id','service');
    }
}
