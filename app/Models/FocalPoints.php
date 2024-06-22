<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FocalPoints extends Model
{
    use HasFactory, SoftDeletes;
    // table name
    protected $table = 'focal_points';
    //fields
    protected $fillable = [
        'client_id',
        'name',
        'name_ar',
        'phone',
        'email',
    ];
    // belongs to client
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }
}
