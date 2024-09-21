<?php

namespace App\Http\Facades;
use Illuminate\Support\Facades\Facade;


class UserSubscriptionsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'UserSubscriptions';
    }
}
