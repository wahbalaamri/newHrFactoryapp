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
        //get users with id from 11-20
        // $users = \App\Models\User::whereBetween('id', [11, 20])->get();
        //get users with id from 21-30
        // $users = \App\Models\User::whereBetween('id', [21, 30])->get();
        //get users with id from 31-40
        // $users = \App\Models\User::whereBetween('id', [31, 40])->get();
        //get users with id from 41-50
        // $users = \App\Models\User::whereBetween('id', [41, 50])->get();
        //get users with id from 51-60
        // $users = \App\Models\User::whereBetween('id', [51, 60])->get();
        //get users with id from 61-70
        // $users = \App\Models\User::whereBetween('id', [61, 70])->get();
        //get users with id from 71-80
        // $users = \App\Models\User::whereBetween('id', [71, 80])->get();
        //get users with id from 81-90
        // $users = \App\Models\User::whereBetween('id', [81, 90])->get();
        //get users with id from 91-100
        // $users = \App\Models\User::whereBetween('id', [91, 100])->get();
        //get users with id from 101-110
        // $users = \App\Models\User::whereBetween('id', [101, 110])->get();
        //get users with id from 111-120
        // $users = \App\Models\User::whereBetween('id', [111, 120])->get();
        //get users with id from 121-130
        // $users = \App\Models\User::whereBetween('id', [121, 130])->get();
        //get users with id from 131-140
        // $users = \App\Models\User::whereBetween('id', [131, 140])->get();
        //get users with id from 141-150
        // $users = \App\Models\User::whereBetween('id', [141, 150])->get();
        //get users with id from 151-156
        // $users = \App\Models\User::whereBetween('id', [151, 156])->get();
        //get user old sections
        // foreach ($users as $user) {
            //english sections with lang =1
            // $old_sections = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetUserSections/?email='.$user->email.'&lang=1'), true);
            // $old_sections = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetUserSections'), true);
            // foreach ($old_sections['userSections'] as $old_section) {
            //     Log::info($old_section);
            //     //wait to fetch remote data
            //     $old_sub_sections = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetSubSections/?parent='.$old_section['Id']), true);
            //     Log::info($old_section['Id']);
            //     if($old_sub_sections)
            //     {
            //      Log::info("SubSection =====================================================================");
            //      Log::info($old_sub_sections);
            //     }
            //     else
            //     {
            //      //log no subsctions
            //      Log::alert('No Subsction');
            //     }

            //  }
            //arabic sections with lang =2
            // $old_sections_ar = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetUserSections/?email='.$user->email.'&lang=2'), true);
            // foreach ($old_sections_ar['userSections'] as $old_sections_ar)
            // {
            //     Log::info($old_sections_ar);

            // }
            // break;
        // }
        return "Done";
    }
}
