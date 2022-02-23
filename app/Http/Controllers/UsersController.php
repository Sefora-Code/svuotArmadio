<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
