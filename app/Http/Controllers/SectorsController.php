<?php

namespace App\Http\Controllers;

use App\Models\Sectors;
use App\Http\Requests\StoreSectorsRequest;
use App\Http\Requests\UpdateSectorsRequest;
use App\Models\Employees;
use Exception;
use Illuminate\Support\Facades\Log;

class SectorsController extends Controller
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
    public function store(StoreSectorsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sectors $sectors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sectors $sectors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectorsRequest $request, Sectors $sectors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sectors $sectors)
    {
        //
    }
    //sectors function
    public function sectors($id)
    {
        try {
            $data = [
                'status' => true,
                'message' => 'Sectors fetched successfully',
                'sectors' => Sectors::where('client_id', Employees::find($id)->client->id)->get()->append('name')
            ];
            return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => 'Error: ' . $e->getMessage(), 'status' => false], 500);
        }
    }
}
