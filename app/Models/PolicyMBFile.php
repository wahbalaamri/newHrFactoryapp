<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyMBFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "name",
        "name_ar",
        "logo",
    ];
    // one to one relationship belong to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
