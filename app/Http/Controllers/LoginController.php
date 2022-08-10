<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Login\RememberMeExpiration;

class LoginController extends Controller
{

    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show(){

        return view('auth.login');

    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request){

        $credentials = $request->getCredentials();
        if(!Auth::validate($credentials)):
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        endif;

        // $user = Auth::getProvider()->retriveByCredentials($credentials);
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);

    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }

}
