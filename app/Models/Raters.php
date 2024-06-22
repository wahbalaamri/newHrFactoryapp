<?php

namespace App\Models;

use App\Http\traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Raters extends Model
{
    use HasFactory, SoftDeletes, Uuid;
}
