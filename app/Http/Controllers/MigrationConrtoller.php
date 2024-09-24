<?php

namespace App\Http\Controllers;

use App\Jobs\ExistingUsersOldSectionsSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MigrationConrtoller extends Controller
{
    //
    function MigrateUsersOldSections() : string {
        //get users with id from 1-10
        $users = \App\Models\User::whereBetween('id', [1, 10])->get();
        //call ExistingUsersOldSectionsSetup
        $test=new ExistingUsersOldSectionsSetup();
        dispatch($test);
        return "Done";
    }
}
