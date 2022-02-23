<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;

class OrdersController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.pickups.home');
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thisCustomerId = Customer::where('user_id', Auth::user()->id)->pluck('id')->first();
        $newOrder = new Order();
        $newOrder->fullfilled = 0;
        $newOrder->customer_id = $thisCustomerId;
        $newOrder->save();
        
        $newOrderDetail = new OrderDetail();
        $newOrderDetail->shipping_address = $request->shipping_address;
        $newOrderDetail->volume = $request->range_volume;
        $newOrderDetail->pickup_date = $request->date;
        $newOrderDetail->time_frame = $request->range_time;
        $newOrderDetail->order_id = $newOrder->id;
        $newOrderDetail->save();        
        
        return redirect()->route('show-order', $newOrderDetail->id)->with('status', 'Ordine salvato correttamente');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newOrderDetail = OrderDetail::find($id);
        return view('front.orders.recap', compact('newOrderDetail'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thisUser = Auth::user();
        $newOrderDetail = OrderDetail::find($id);
        return view('front.orders.home', compact('thisUser', 'newOrderDetail'));
    }
    
    
    /**
     * Update the specified resource in storage.
     * This is intended to be performed only by customers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newOrderDetail = OrderDetail::find($id);
        $newOrderDetail->shipping_address = $request->shipping_address;
        $newOrderDetail->volume = $request->range_volume;
        $newOrderDetail->pickup_date = $request->date;
        $newOrderDetail->time_frame = $request->range_time;
        $newOrderDetail->touch();
        
        return redirect()->route('show-order', $newOrderDetail->id)->with('status', 'Ordine aggiornato correttamente');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    
    public function paymentPage($id)
    {
        $newOrderDetail = OrderDetail::find($id);
        return view('front.orders.payment', compact('newOrderDetail'));
    }
}
