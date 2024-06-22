<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlans extends Model
{
    use HasFactory;
    //many to one relationship users
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }
    //many to one relationship plans
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'PlanId');
    }
}
