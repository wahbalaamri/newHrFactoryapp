<?php

namespace App\Http\Controllers;

use App\Models\ServiceApproaches;
use App\Http\Requests\StoreServiceApproachesRequest;
use App\Http\Requests\UpdateServiceApproachesRequest;

class ServiceApproachesController extends Controller
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
    public function store(StoreServiceApproachesRequest $request)
    {
        //check if the request has an icon
        if (!$request->hasFile('icon')) {
            return response()->json(['message' => 'Please upload an icon'], 400);
        }
        //upload the icon
        $icon = $request->file('icon');
        $iconName = time() . '.' . $icon->extension();
        $icon->move(public_path('uploads/services/icons/'), $iconName);
        // Store the ServiceApproaches
        $serviceApproaches = new ServiceApproaches();
        $serviceApproaches->service = $request->service;
        $serviceApproaches->approach = $request->approach;
        $serviceApproaches->approach_ar = $request->approach_ar;
        $serviceApproaches->icon = $iconName;
        $serviceApproaches->save();
        return response()->json(['message' => 'Service Approach created successfully', 'status' => true], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceApproaches $serviceApproaches)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceApproaches $serviceApproaches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceApproachesRequest $request, ServiceApproaches $serviceApproaches)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceApproaches $serviceApproaches)
    {
        //
    }
}
