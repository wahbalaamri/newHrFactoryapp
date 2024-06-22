<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerFocalPoint extends Model
{
    use HasFactory, SoftDeletes;
    //table
    protected $table = 'partner_focal_points';
    //fields
    protected $fillable = [
        'partner_id',
        'name',
        'name_ar',
        'phone',
        'email',
    ];
    // belongs to partner
    public function partner()
    {
        return $this->belongsTo(Partners::class, 'partner_id', 'id');
    }
}
