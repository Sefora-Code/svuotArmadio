<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::get();
        $employees = Employee::get();
        $customers = Customer::get();
        return view('users.index', compact('users', 'employees', 'customers'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();// Input::all();
        
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:50']
        ]);
        
        // process the login
        if ($validator->fails()) 
        {
            return redirect()->back()->with('error', 'Dati non corretti')
                            ->withErrors($validator)
                            ->withInput();
        }
        
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'address' => $data['address']
        ]);
        
        $type = $data['type'];
        
        if ($type == 'customer') {
            $user->assignRole(['customer']);
            
            Customer::create(['user_id' => $user->id]);
        } else if ($type == 'deliverer') {
            $user->assignRole(['deliverer']);
            
            Employee::create(['hired_on' => now(), 'user_id' => $user->id]);
        }
        
        return redirect()->to('users')->with('success', 'Utente creato correttamente');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // show the edit form and pass the user
        return view('users.edit', compact('user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();// Input::all();
        
        $validator = Validator::make($data, [
            'name' => ['string', 'max:255'],
            'surname' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:50']
        ]);
        
        // process the login
        if ($validator->fails())
        {
            return redirect()->back()->with('error', 'Dati non corretti')
            ->withErrors($validator)
            ->withInput();
        }
        
        
        $user = User::find($id);
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        if ($data['password'])
            $user->password = Hash::make($data['password']);
        $user->phone_number = $data['phone_number'];
        $user->address = $data['address'];
        $user->save();
        
        $type = $data['type'];
        if ($type == 'customer') 
        {
            if ($user->customer == '')
            {
                Employee::where('user_id', $user->id)->delete();
                
                $user->assignRole(['customer']);
                Customer::create(['user_id' => $user->id]);
            }
        } 
        else if ($type == 'deliverer') 
        {
            if ($user->employee == '')
            {
                Customer::where('user_id', $user->id)->delete();
                
                $user->assignRole(['deliverer']);
                Employee::create(['hired_on' => now(), 'user_id' => $user->id]);
            }
        }
        
        return redirect()->to('users')->with('success', 'Utente modificato correttamente');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user->customer == '')
        {
            Employee::where('user_id', $user->id)->delete();
        }
        else if ($user->employee == '')
        {
            Customer::where('user_id', $user->id)->delete();
        }
        
        $user->delete();
        
        return redirect()->to('users')->with('success', 'Utente rimosso correttamente');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_denis_branch(Request $request)
    {
        $thisUser = Auth::user();
        // check that the user is not trying to modify someone else's data
        if ($request->has('id') && $request->id == $thisUser->id)
        {
            if ($request->has('address'))
            {
                $thisUser->address = $request->address;
            }
            
            if ($request->has('phone'))
            {
                $thisUser->phone_number = $request->phone;
            }
            
            if ($request->has('email'))
            {
                $thisUser->email = $request->email;
            }
            
            if ($request->has('pwd'))
            {
                $thisUser->password = Hash::make($request->pwd);
            }
            
            $thisUser->touch();
            
            return redirect()->back()->with('status', 'Dati aggiornati correttamente');
        }
        return redirect()->back()->with('error', 'Errore - utente non riconosciuto - dati non aggiornati');
    }
}
