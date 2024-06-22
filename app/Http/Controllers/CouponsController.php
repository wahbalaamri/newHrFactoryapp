<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use App\Http\Requests\StoreCouponsRequest;
use App\Http\Requests\UpdateCouponsRequest;
use Illuminate\Http\Request;

class CouponsController extends Controller
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
    public function store(StoreCouponsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupons $coupons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupons $coupons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponsRequest $request, Coupons $coupons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupons $coupons)
    {
        //
    }
    public function getCouponRate(Request $request){
        $code=$request->code;
        $coupon=Coupons::where('coupon_code',$code)->first();
        if($coupon)
        {
            return response()->json(['result'=>'success','status'=>true,'rate'=>$coupon->coupon_discount_rate]);
        }
        else
        {
            return response()->json(['result'=>'error','status'=>false,'rate'=>0]);
        }
    }
}
