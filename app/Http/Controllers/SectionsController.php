<?php

namespace App\Http\Controllers;

use App\Models\DefaultMB;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    //
    function EditSe($id){
        $section = DefaultMB::find($id);
        $data = [
            'section' => $section,
        ];
        return view('sections.edits')->with($data);
    }
}
