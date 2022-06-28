<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\User;

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
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_denis_branch()
    {
        return view('front.pickups.home');
    }
    
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
        $order->status = 1;
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
        $order->status = 2;
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
        $order->status = 3;
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
            $order->status = 1;
            $order->customer_id = $request->customer;
            $order->save();
            
            $orderDetails = new OrderDetail();
            $orderDetails->order_id = $order->id;
            $orderDetails->shipping_address = $request->shipping_address != '' ? $request->shipping_address : $customer->user->address;
            $orderDetails->pickup_date = $request->date;
            $orderDetails->volume = $request->volume;
            if ($request->has('notes')) // not mandatory
                $orderDetails->notes = $request->notes;
            $orderDetails->save();
        }
        
        return redirect()->back()->with('success', 'Ritiro salvato correttamente');
    }

    public function storeAdminPhoneOrder(Request $request)
    {
        $selectedCustomer = null;
        // firstly create the customer
        if ($request->has('email'))
        {
            // check if already exists
            $thisUser = User::where('email', $request->email)->first();
            if (!$thisUser) // no it's a new user - store it
            {
                $uc = new UsersController();
                $result = $uc->store($request);
                if(Session::has('error')) // in case of errors with the form get back to the user
                    return $result;
                else
                    $thisUser = User::where('email', $request->email)->first();
            }
            $selectedCustomer = Customer::where('user_id', $thisUser->id)->first();
        }
        else 
        {
            return redirect()->back()->with('error', 'Indirizzo Email mancante!');  
        }
        
        if (!$request->has('volume'))
        {
            return redirect()->back()->with('error', 'Volume Mancante!');
        }
        else if (!$request->has('date'))
        {
            return redirect()->back()->with('error', 'Data di ritiro mancante');
        }
        else
        {
            $customer = $selectedCustomer;
            $order = new Order();
            $order->status = 3;
            $order->customer_id = $selectedCustomer->id;
            $order->assigned_to = $request->rider;
            $order->assigned_by = Auth::user()->id;
            $order->save();
            
            $orderDetails = new OrderDetail();
            $orderDetails->order_id = $order->id;
            $orderDetails->shipping_address = $customer->user->address;
            $orderDetails->pickup_date = $request->date;
            $orderDetails->time_frame = $request->time;
            $orderDetails->volume = $request->volume;
            $orderDetails->notes = "";
            if ($request->has('more_details')) // not mandatory
                $orderDetails->notes .= "nome sul campanello: ".$request->more_details." - ";
            if ($request->has('more_details2')) // not mandatory
                $orderDetails->notes .= "bisogna salire al piano o raccogliere i sacchi al portone: ".$request->more_details2;
            $orderDetails->save();
        }
        
        return redirect()->back()->with('success', 'Ritiro salvato correttamente');
    }
    
    public function updateAdminPhoneOrder(Request $request)
    {
        $selectedCustomer = null;
        // firstly create the customer
        if ($request->has('email'))
        {
            // check if already exists
            $thisUser = User::where('email', $request->email)->first();
            if (!$thisUser) // no it's a new user - store it
            {
                $uc = new UsersController();
                $result = $uc->store($request);
                if(Session::has('error')) // in case of errors with the form get back to the user
                    return $result;
                else
                    $thisUser = User::where('email', $request->email)->first();
            }
            $selectedCustomer = Customer::where('user_id', $thisUser->id)->first();
        }
        else
        {
            return redirect()->back()->with('error', 'Indirizzo Email mancante!');
        }
        
        if (!$request->has('volume'))
        {
            return redirect()->back()->with('error', 'Volume Mancante!');
        }
        else if (!$request->has('date'))
        {
            return redirect()->back()->with('error', 'Data di ritiro mancante');
        }
        else
        {
            $customer = $selectedCustomer;
            
            $orderDetails = OrderDetail::find($request->order_details_id);
            $orderDetails->shipping_address = $customer->user->address;
            $orderDetails->pickup_date = $request->date;
            $orderDetails->time_frame = $request->time;
            $orderDetails->volume = $request->volume;
            $orderDetails->notes = "";
            if ($request->has('more_details')) // not mandatory
                $orderDetails->notes .= "nome sul campanello: ".$request->more_details." - ";
            if ($request->has('more_details2')) // not mandatory
                $orderDetails->notes .= "bisogna salire al piano o raccogliere i sacchi al portone: ".$request->more_details2;
            $orderDetails->save();
            
            $order = Order::find($orderDetails->order_id);
            $order->customer_id = $selectedCustomer->id;
            $order->assigned_to = $request->rider;
            $order->assigned_by = Auth::user()->id;
            $order->save();
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
            $order->status = 0;
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
        $newOrder->status = 0;
        $newOrder->customer_id = $thisCustomerId;
        $newOrder->save();
        
        $newOrderDetail = new OrderDetail();
        $newOrderDetail->shipping_address = $request->shipping_address;
        $newOrderDetail->volume = $request->range_volume;
        $newOrderDetail->pickup_date = $request->date;
        $newOrderDetail->time_frame = $request->range_time;
        $newOrderDetail->order_id = $newOrder->id;
        if ($request->has('notes')) // not mandatory
            $newOrderDetail->notes = $request->notes;
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
    
    
    public function editAdminPhoneOrder($id)
    {
        $thisUser = Auth::user();
        $newOrderDetail = OrderDetail::find($id);
        $newOrder = Order::find($newOrderDetail->order_id);
        $employees = Employee::get();
        $customer = Customer::find($newOrder->customer_id);
        $user = User::find($customer->user_id);
        
        return view('orders.pick_up_phone', compact('thisUser', 'newOrderDetail', 'newOrder', 'employees', 'user'));
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
    
    public function showDetail($id)
    {
        $order = Order::where('id', $id)->with('orderDetails')->first();
        return view('front.pickups.pickup-details', compact('order'));
    }
    
    /**
     * show Employee's today assigned orders for ordering pourposes
     * @param int $empId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showTodayUserOrders($riderId)
    {
        $employee = Employee::find($riderId);
        $user = User::find($employee->user_id);
        $orders = Order::where('employee_id', $riderId)->where('status','!=', 2)->with('orderDetails')->orderBy('seq_number')->get();
        return view('orders.pickups-ordering', compact('orders', 'user'));
    }
    
    public function confirmPickupsOrdering(Request $request)
    {
        $obj = new \stdClass();
        
        // TODO code to store pickup orders
        foreach ($request->orders as $pickup) 
        {
            $thisOrder = Order::find($pickup['id']);
            if ($thisOrder)
            {
                $thisOrder->seq_number = $pickup['order'];
                $thisOrder->touch();
            }
            else
            {
                $obj->code = 500;
                $obj->text = "Ordine ".$pickup->id." non trovato.";
                return $obj;
            }
        }
        
        $obj->code = 200;
        $obj->text = "Ordinamento correttamente assegnato.";
        
        return $obj;
    }
    
    public function showDetailEmp($id)
    {
        $order = Order::where('id', $id)->with('orderDetails')->first();
        return view('pickups.pickup-details', compact('order'));
    }
    
    public function paymentPage($id)
    {
        $newOrderDetail = OrderDetail::find($id);
        return view('front.orders.payment', compact('newOrderDetail'));
    }
    
    /**
     * get Employee's assigned orders
     * @param int $empId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function getTodayUserOrders($empId)
    {
        $orders = Order::where('employee_id', $empId)->where('status','!=', 2)->with('orderDetails')->orderBy('seq_number')->get();
        
        // get coordinates for today orders
        $baseUrl = "https://nominatim.openstreetmap.org/search?format=geojson&q=";
        $todayOrders = [];
        foreach($orders as $order)
        {
            if($order->orderDetails->pickup_date == date('Y-m-d 00:00:00'))
            {
                $encodedAddress = urlencode($order->orderDetails->shipping_address);
                
                $obj = new \stdClass();
                $obj->order = $order;
                
                // create a new cURL resource
                $ch = curl_init();
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $baseUrl.$encodedAddress);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_REFERER, "https://www.lostelloportaaporta.it");
                
                // grab result
                $result = curl_exec($ch);
                curl_close($ch);
                // create a simpler object to pass to the client
                $orderData = json_decode($result);
                if (count($orderData->features) > 0)
                {
                    $obj->lat = $orderData->features[0]->geometry->coordinates[1];
                    $obj->lng = $orderData->features[0]->geometry->coordinates[0];
                }
                else 
                {
                    $obj->lat = 0;
                    $obj->lng = 0;
                    $obj->error = "Indirizzo non trovato.";
                }
                $todayOrders[] = $obj;
                
                // sleep for 1 second to comply with Nominatim service usage policy at
                // https://operations.osmfoundation.org/policies/nominatim/
                sleep(1);
            }
        }
        
        
        return $todayOrders;
    }
    
    public function UpdateOrderStatus(Request $request)
    {
        $obj = new \stdClass();
        
        if ($request->has("o"))
        {
            $order = Order::find($request->o);
            $order->status = $request->s;
            $order->touch();
            
            $obj->code = 200; 
            $obj->text = "Ordine aggiornato correttamente.";
        }
        else 
        {
            $obj->code = 500;
            $obj->text = "Ordine non trovato.";
        }
        
        return $obj;
    }
    
    
    // an array of italian bank holidays
    public $feste = Array(
        '01-01',
        '06-01',
        '25-04',
        '01-05',
        '02-06',
        '15-08',
        '01-11',
        '08-12',
        '25-12',
        '26-12'
    ); 
    
    /**
     * add more bank holidays to the given array 
     */
    public function calculateItalianEasterHolidays()
    {
        $anno = date('Y');
        
        // calcolo le date di Pasqua e Pasquetta
        $gg_pasqua = easter_days($anno);
        $gg_pasquetta = $gg_pasqua+1;
        $tmp = date('Y-m-d', strtotime('21 march ' . $anno));
        $data_pasqua = date('d-m', strtotime($tmp . ' +' . $gg_pasqua . 'day'));
        $data_pasquetta = date('d-m', strtotime($tmp . ' +' . $gg_pasquetta . 'day'));
        
        // aggiungo le date di Pasqua e Pasquetta nel nostro elenco di festività
        $this->feste[] = $data_pasqua;
        $this->feste[] = $data_pasquetta;
    }
    
    /**
     * check whether the user date is a bank holiday
     * @param Request $request
     * @return number 1 in case of bank holiday or -1 if not
     */
    public function isBankHoliday(Request $request)
    {
        // first calculate full list of italian bank holidays
        $this->calculateItalianEasterHolidays();
        
        // get the date as month-day formatted as 05-27
        $userDate = date('d-m', strtotime($request->d));
                
        // loop trough the array of bank holidays checking if our date belongs to it
        foreach($this->feste as $d)
        {
            if ($d == $userDate)
                return 1;
        }
        
        return -1;
    }

    /**
     * Check if another order in the same date and timeframe exists
     * @param Request $request
     * @return number 1 in case it exists (so we can't proceed), -1 in case no order exists (and we can proceed)
     */
    public function verifyTimeSlot(Request $request)
    {
        $timeslot = str_replace("|", ":", $request->t); // replace the pipe here - id the opposite of what was done on the client
        $date = $request->d." 00:00:00";
        $order = OrderDetail::where('pickup_date', $date)->where('time_frame', $timeslot)->first();
        
        if ($order)
        {
            return 1;
        }
        else 
        {
            return -1;
        }
    }
    
}
