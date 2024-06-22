<?php

namespace App\Http\Controllers;

use App\Models\Functions;
use App\Http\Requests\StoreFunctionsRequest;
use App\Http\Requests\UpdateFunctionsRequest;
use App\Models\Plans;
use App\Models\Services;

class FunctionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $remotFunctionsArry = array();
        $functions = Functions::all();

        return view('Functions.index', compact('functions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFunctionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Functions $functions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Functions $functions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFunctionsRequest $request, Functions $functions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Functions $functions)
    {
        //
    }
    //setup function from https://3h.hrfactoryapp.com/function/getf
    public function setup()
    {
        //read the data from the url
        $url = "https://3h.hrfactoryapp.com/function/getf";
        $json = file_get_contents($url);
        $data = json_decode($json);
        //find service with type 3
        $service = Services::where('service_type', 3)->first();
        //insert the data into the database
        foreach ($data as $item) {
            $function = new Functions();
            $function->id = $item->id;
            $function->title = $item->FunctionTitle;
            $function->title_ar = $item->FunctionTitleAr;
            $function->respondent = $item->Respondent;
            $function->status = $item->Status;
            $function->service_id = $service->id;
            $function->IsDefault= $item->IsDefault==1;
            $function->IsDriver= $item->IsDriver==1;
            $function->save();
        }
        return redirect()->route('EmployeeEngagment.index');
    }
}
