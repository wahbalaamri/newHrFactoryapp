<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanFeatures extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'plan_features';
    protected $fillable = [
        'plan',
        'feature_id'
    ];
    //belongs to relationship with plans
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }
}
