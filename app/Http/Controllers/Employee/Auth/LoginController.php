<?php

namespace App\Http\Controllers\Employee\Auth;

use Illuminate\Http\Request;
use Facades\App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{   
    public function login()
    {
        if(View::exists('employee.auth.login'))
        {
            return view('employee.auth.login');
        }
        abort(Response::HTTP_NOT_FOUND);
    }

    public function processLogin(Request $request)
    {   
        $credentials = $request->except(['_token']);
        if(Auth::guard('employee')->attempt($credentials))
        {   
            // return redirect(RouteServiceProvider::EMPLOYEE);
            return redirect()->route('employee.home');
        }
        return redirect()->action([LoginController::class,'login'])->with('message','Credentials not matced in our records!');
    }

    public function employeeHome(){
        return view('home');
    }
    
}