<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminAuth\AuthController;
use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Auth\LoginController as  AuthLoginController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Google login
Route::get('login/google', [AuthLoginController::class,'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthLoginController::class,'handleGoogleCallBack']);


//Facebook login
Route::get('login/facebook', [AuthLoginController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthLoginController::class,'handleFacebookCallBack']);

Route::get('locales/{lang}', [LocaleController::class,'locale']);



Route::group(['middleware' => ['terminate']], function () {
    // Route::get('/terminate', [App\Http\Controllers\HomeController::class, 'index'])->name('terminate');
    Route::get('/', function () {
        return view('welcome');
    });
    
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/slug', [HomeController::class, 'facadesView'])->name('facades');
    Route::post("/generate-slug", [HomeController::class, "getSlug"])->name('facades.get-slug');

    //Company
    Route::get('/company/lang/{lang}', [CompanyController::class,'index']);
    Route::resource('company', CompanyController::class);

    //Employee
    Route::get('/emp/lang/{lang}', [EmployeeController::class,'index']);
    Route::resource('emp', EmployeeController::class);

    //QR Code
    Route::get('/qr-code-generator', [HomeController::class, 'qrCode'])->name('qr-code-generator');

    //Notification
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::post('/save-token', [NotificationController::class, 'saveToken'])->name('save-token');
    Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('send.notification');

    //Demo Mail Route
    Route::get('/send-mail', [HomeController::class, 'sendMail']); // Demo
    Route::get('/send-mail-using-mailchimp', [HomeController::class, 'sendMailChimp'])->name('send-mail-mailchimp'); // Demo

});


