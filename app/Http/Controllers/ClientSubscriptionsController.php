<?php

namespace App\Http\Controllers;

use App\Models\ClientSubscriptions;
use App\Http\Requests\StoreClientSubscriptionsRequest;
use App\Http\Requests\UpdateClientSubscriptionsRequest;
use App\Models\Clients;
use App\Models\UserPlans;
use Illuminate\Support\Facades\Log;

class ClientSubscriptionsController extends Controller
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
    public function store(StoreClientSubscriptionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientSubscriptions $clientSubscriptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientSubscriptions $clientSubscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientSubscriptionsRequest $request, ClientSubscriptions $clientSubscriptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientSubscriptions $clientSubscriptions)
    {
        //
    }
}
