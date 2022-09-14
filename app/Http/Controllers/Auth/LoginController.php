<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, SoftDeletes;
   
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle(Request $request){
        return Socialite::driver('google')->redirect();
    }

    //Google CallBack
    public function handleGoogleCallBack(){
        $user =   Socialite::driver('google')->stateless()->user();
        $provider = "google";
        $userData = $this->_registerOrLoginUser($user, $provider);
        return redirect()->route('home');
    }
 
    //Facebook Login
    public function redirectToFacebook(Request $request){
        return Socialite::driver('facebook')->redirect();
    }

    //Facebook CallBack
    public function handleFacebookCallBack(Request $request){
        $user =   Socialite::driver('facebook')->stateless()->user();

        dd($user);
        $provider = "facebook";
        $userData = $this->_registerOrLoginUser($user, $provider);
        return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data, $provider){ 
        
        $user = User::withTrashed()->where('email','=',$data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->role_id = 1;
            $user->email_verified_at=Carbon::now()->toDateTimeString();
            $user->provider = $provider;
            if($provider == "google"){
                $user->provider_id = "G-".$data->id;

            }else{
                $user->provider_id = "FB-".$data->id;
            }
            $user->save(); 
        }

        else if($user->deleted_at !== NULL && $user->provider_id !== null)
        {
            Session::put('error','These credentials do not match our records.');
            return redirect()->route('login');
        }
        
        Auth::login($user);
        return $user;
    }

}
