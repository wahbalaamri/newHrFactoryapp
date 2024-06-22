<?php

namespace App\Http\Facades;
use Illuminate\Support\Facades\Facade;


class TempURL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tempurl';
    }
}
