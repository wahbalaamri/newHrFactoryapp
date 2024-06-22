<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Http\Requests\StoreIndustryRequest;
use App\Http\Requests\UpdateIndustryRequest;
use App\Models\Clients;
use Illuminate\Support\Facades\Log;

class IndustryController extends Controller
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
    public function store(StoreIndustryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndustryRequest $request, Industry $industry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        //
    }
    //function allIndustries
    public function allIndustries($id)
    {
        try{
        //find the client
        $client = Clients::find($id);
        //get all sectors name of this client
        $sectors = $client->sectors->pluck('name_en')->toArray();
        return Industry::select(['id', 'name', 'name_ar'])->whereNotIn('name',$sectors)->where('system_create', true)->orWhere('client_id', $id)->get();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
