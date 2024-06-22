<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partners extends Model
{
    use HasFactory, SoftDeletes;
    //filable
    protected $fillable = [
        'name',
        'name_ar',
        'country',
        'logo_path',
        'webiste',
        'is_active'
    ];
    //table
    protected $table = 'partners';
    //belongs to countries
    public function countryObj()
    {
        return $this->belongsTo(Countries::class, 'country');
    }
    // hasMany Focal points
    public function focalPoints()
    {
        return $this->hasMany(PartnerFocalPoint::class, 'partner_id');
    }
    //get count of focalPoints
    public function getFocalPointsCountAttribute()
    {
        return $this->focalPoints->count();
    }
    //has many partnerships
    public function partnerships()
    {
        return $this->hasMany(Partnerships::class, 'partner_id');
    }
    //get count of partnerships
    public function getPartnershipsCountAttribute()
    {
        return $this->partnerships->count();
    }
}
