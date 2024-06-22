<?php

namespace App\Http\Controllers;

use App\Models\FunctionPractices;
use App\Http\Requests\StoreFunctionPracticesRequest;
use App\Http\Requests\UpdateFunctionPracticesRequest;

class FunctionPracticesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreFunctionPracticesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FunctionPractices $functionPractices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FunctionPractices $functionPractices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFunctionPracticesRequest $request, FunctionPractices $functionPractices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FunctionPractices $functionPractices)
    {
        //
    }
    //setup practices from https://3h.hrfactoryapp.com/practice/getp
    function setup()
    {
        //read data from the API
        $url = "https://3h.hrfactoryapp.com/practice/getp";
        $json = file_get_contents($url);
        $data= json_decode($json);
        //loop through the data
        foreach($data as $item){
            //check if the practice exists
                //create a new practice
                $practice = new FunctionPractices();
                $practice->id= $item->id;
                $practice->function_id= $item->FunctionId;
                $practice->title = $item->PracticeTitle;
                $practice->title_ar = $item->PracticeTitleAr;
                $practice->status = $item->Status;
                $practice->save();
        }
        // return to route
        return redirect()->route('EmployeeEngagment.index');
    }
}
