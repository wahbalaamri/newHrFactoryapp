<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientSubscriptions extends Model
{
    use HasFactory, SoftDeletes;
    // table name
    protected $table = 'client_subscriptions';
    //fields
    protected $fillable = [
            'client_id',
            'plan_id',
            'service_id',
            'start_date',
            'end_date',
            'status',
            'is_active'
        ];
    //relationship with clients
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }
    //relationship with plans
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id', 'id');
    }
}
