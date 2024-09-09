<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestorDatabaseFromJsonController extends Controller
{
    public function RestoreDatabaseFromJsonShowFrom(){
        return view('restore');
    }
    //
    public function RestoreDatabaseFromJson(Request $request)
    {
        //check if $request has file
        
    }
}
