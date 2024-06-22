<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scheduleAutoEmails extends Model
{
    use HasFactory;
    protected $table = 'schedule_auto_emails';
    protected $fillable = [
        'email_id',
        'recivers',
        'cc',
        'send_date',
        'send_time',
        'status',
        'send_status'
    ];
}
