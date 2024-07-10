<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSections extends Model
{
    protected $table = 'user_sections';
    use HasFactory, SoftDeletes;
    //one to many relationship, create children relationship
    public function children()
    {
        return $this->hasMany(UserSections::class, 'paren_id')->orderBy('Ordering');
    }
}
