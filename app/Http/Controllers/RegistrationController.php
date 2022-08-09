<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
    /**
     * Show registration form
     */
    public function show(){
        return view('auth.register');
    }

    /**
     * User registration request handle
     * 
     * @param RegistrationRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function registration(RegistrationRequest $request)
    {
        $user = User::create($request->validated());

        auth()->login($user);

        return redirect('/')->with('succes', "Account successfully created");

    }

}
