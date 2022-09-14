<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\Auth\LoginController;


Route::name('employee.')->namespace('Employee')->prefix('employee')->group(function(){

    Route::namespace('Auth')->middleware('guest:employee')->group(function(){
        //login route

        Route::get('/login', [LoginController::class, 'login']);
        Route::post("/login", [LoginController::class, "processLogin"])->name('login');
        
    });
    Route::get('/home', [LoginController::class, 'employeeHome'])->name('home');
    
    Route::namespace('Auth')->middleware('auth:employee')->group(function(){

        Route::post('/logout',function(){
            Auth::guard('employee')->logout();
            return redirect()->action([
                LoginController::class,
                'login'
            ]);
        })->name('logout');

    });

});