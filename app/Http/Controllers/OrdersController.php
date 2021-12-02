<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Employee;
use App\Models\Customer;

class OrdersController extends Controller
{
    /** 
     * gli stati degli ordini potrebbero essere
     * 0 => registrato;
     * 1 => approvato;
     * 2 => rifiutato;
     * 3 => assegnato;
     * 4 => completato;
     * 5 => non si riesce a completare; 
     *
     * Per ora lo stato lo metto nella colonna 'fulfilled' degli ordini
     * TODO ma va fatta una migration per cambiare nome
     * 
    */
    
    
    public function index()
    {
        $orders = Order::get();
        $employees = Employee::get();
        $customers = Customer::get();
        return view('orders.index', compact('orders', 'employees', 'customers'));
    }

    public function accept(Request $request)
    {
        $toReturn = new \stdClass();
        $toReturn->error = "";
        $toReturn->message = "";
        
        $order = Order::find($request->orderId);
        $order->fullfilled = 1;
        $order->save();
        
        $toReturn->message = $request->orderId;
        return $toReturn;
    }
    
    public function reject(Request $request)
    {
        $toReturn = new \stdClass();
        $toReturn->error = "";
        $toReturn->message = "";
        
        $order = Order::find($request->orderId);
        $order->fullfilled = 2;
        $order->save();
        
        $toReturn->message = $request->orderId;
        return $toReturn;
    }
    
    public function assign(Request $request)
    {
        $toReturn = new \stdClass();
        $toReturn->error = "";
        $toReturn->message = "";
        
        $order = Order::find($request->orderId);
        $order->employee_id = $request->employeeId;
        $order->assigned_by = Auth::user()->employee->id;
        $order->fullfilled = 3;
        $order->save();
        
        $toReturn->message = "Assegnazione effettuata";
        return $toReturn;
    }
    
    public function storeAdminOrder(Request $request)
    {
        if (!$request->has('customer'))
        {
            return redirect()->back()->with('error', 'Cliente Mancante!');
        }
        else if (!$request->has('volume'))
        {
            return redirect()->back()->with('error', 'Volume Mancante!');
        }
        else if (!$request->has('date'))
        {
            return redirect()->back()->with('error', 'Data di ritiro mancante');
        }
        else
        {
            $customer = Customer::find($request->customer);
            $order = new Order();
            $order->fullfilled = 0;
            $order->customer_id = $request->customer;
            $order->save();
            
            $orderDetails = new OrderDetail();
            $orderDetails->order_id = $order->id;
            $orderDetails->shipping_address = $customer->user->address;
            $orderDetails->pickup_date = $request->date;
            $orderDetails->volume = $request->volume;
            if ($request->has('notes')) // not mandatory
                $orderDetails->notes = $request->notes;
            $orderDetails->save();
        }
        
        return redirect()->back()->with('success', 'Ritiro salvato correttamente');
    }

    
    public function storeCustomerOrder(Request $request)
    {
        $toReturn = new \stdClass();
        $toReturn->error = "";
        $toReturn->message = "";
        
        if (!$request->has('customer'))
        {
            $toReturn->error = "Cliente mancante";
        }
        else if (!$request->has('volume'))
        {
            $toReturn->error = "Volume mancante";
        }
        else if (!$request->has('date'))
        {
            $toReturn->error = "Data di ritiro mancante";
        }
        else
        {
            $user = Auth::user(); // the customer
            $order = new Order();
            $order->fullfilled = 0;
            $order->customer_id = $request->customer;
            $order->save();
            
            $orderDetails = new OrderDetail();
            $orderDetails->order_id = $order->id;
            $orderDetails->shipping_address = $user->address;
            $orderDetails->pickup_date = $request->date;
            $orderDetails->volume = $request->volume;
            if ($request->has('notes')) // not mandatory
                $orderDetails->notes = $request->notes;
                $orderDetails->save();
                
                $toReturn->message = "Ritiro prenotato correttamente.";
        }
        
        return redirect()
        ->back()
        ->with('success', 'Your message has been sent successfully!');
    }
    
}
