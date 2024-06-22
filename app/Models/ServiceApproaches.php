<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceApproaches extends Model
{
    use HasFactory, SoftDeletes;
    // Table Name
    protected $table = 'service_approaches';
    //fillable fields
    protected $fillable = [
        'service',
        'approach',
        'approach_ar',
        'icon',
        'is_active',
    ];

}
