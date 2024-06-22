<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sectors extends Model
{
    use HasFactory,SoftDeletes;
    // table name
    protected $table = 'sectors';
    //fields
    protected $fillable = [
        'name_en',
        'name_ar',
        'client_id',
    ];
    //belongs to client
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }
    //has many companies
    public function companies()
    {
        return $this->hasMany(Companies::class, 'sector_id', 'id');
    }
    //sector name
    public function getNameAttribute()
    {
        return App()->isLocale('ar') ? $this->name_ar : $this->name_en;
    }
}
