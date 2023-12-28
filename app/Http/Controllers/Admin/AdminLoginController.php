<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
    public function indexx()
    {
        return view('admin.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required | email',
            'password' => 'required'
        ]);
        if($validator->passes()){

            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password'=> $request->password],
            $request->get('remember'))){
                $check = Auth::guard('admin')->user();
                
                if($check->role == 2){

                    return redirect()->route('admin.dashboard');

                } else{
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','you are not access to this admin page');

                }

                

            }  else{
                return redirect()->route('admin.login')->with('error','Either Email/Password is incorrect');

            }

        }else{
            return redirect()->route('admin.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }

    }
    // public function logout()
    // {

    // }
}
