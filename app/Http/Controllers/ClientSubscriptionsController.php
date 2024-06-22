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
    //pull data from https://www.hrfactoryapp.com/Home/GetUserPlan?email=wahb.alaamri@gmail.com
    public function getUserPlan()
    {
        //get all clienta
        $clients = Clients::all();
        //read data from url
        foreach ($clients as $client) {

            $json = file_get_contents('https://www.hrfactoryapp.com/Home/GetUserPlan?email=' . $client->focalPoint->first()->email);
            $data = json_decode($json, true);
            //get status
            Log::info($data['stat']);
            if($data['stat'] !=1){
                Log::info('No Plan');
                Log::info($client->focalPoint->first()->email);
            }
            else{

                if($data['userPlan']){
                    Log::info('User Plan');
                    Log::info($data['userPlan']);
                }
                else{
                    Log::info('No User Plan');
                }
            }
            //convert /Date(1680465600000)/ to 2023-04-01
            // $date = date('Y-m-d', substr($data['EndDate'], 6, 10));
        }
    }
}
