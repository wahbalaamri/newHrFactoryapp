<?php

namespace App\Http\Controllers;

use App\Models\ServiceFeatures;
use App\Http\Requests\StoreServiceFeaturesRequest;
use App\Http\Requests\UpdateServiceFeaturesRequest;

class ServiceFeaturesController extends Controller
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
    public function store(StoreServiceFeaturesRequest $request)
    {
        //
        try {
            $newServiceFeature = new ServiceFeatures();
            $newServiceFeature->service = $request->service;
            $newServiceFeature->feature = $request->feature;
            $newServiceFeature->feature_ar = $request->feature_ar;
            //is_active
            $newServiceFeature->is_active = $request->status;
            $newServiceFeature->save();
            // return json response with status and message
            return response()->json([
                'status' => true,
                'message' => 'Service Feature created successfully',
            ]);
        } catch (\Exception $e) {
            // return json response with status and message
            return response()->json([
                'status' => false,
                'message' => 'Error creating Service Feature',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceFeatures $serviceFeatures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return ServiceFeatures::find($id); as json response
        return response()->json(ServiceFeatures::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceFeaturesRequest $request, $id)
    {
        // find the service feature and update it
        $serviceFeature = ServiceFeatures::find($id);
        $serviceFeature->service = $request->service;
        $serviceFeature->feature = $request->feature;
        $serviceFeature->feature_ar = $request->feature_ar;
        //is_active
        $serviceFeature->is_active = $request->status;
        $serviceFeature->save();
        // return json response with status and message
        return response()->json([
            'status' => true,
            'message' => 'Service Feature updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceFeatures $serviceFeatures)
    {
        //
    }
}
