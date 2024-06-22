<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partnerships extends Model
{
    use HasFactory,SoftDeletes;
    //table
    protected $table = 'partnerships';
    //fillable

    //belongs to partner
    public function partner()
    {
        return $this->belongsTo(Partners::class, 'partner_id');
    }
    //belongs to country
    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
    //Exclusivity
    public function getExclusiveAttribute()
    {
        return $this->is_exclusive ? __('Exclusive') : __('Non-Exclusive');
    }
    //status
    public function getActiveAttribute()
    {
        return $this->is_active ? __('Active') : __('Inactive');
    }
}
