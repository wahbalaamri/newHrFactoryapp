<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailContents extends Model
{
    use HasFactory;
    protected $table = 'email_contents';
    protected $fillable = [
        'email_type',
        'country',
        'client_id',
        'survey_id',
        'subject',
        'subject_ar',
        'body_header',
        'body_footer',
        'body_header_ar',
        'body_footer_ar',
        'status',
        'use_client_logo',
        'created_by',
        'created_by_type',
        'logo'
    ];
}
