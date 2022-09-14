<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocaleController extends Controller
{
    public function locale($lang){
        App::setlocale($lang);
        return view('welcome');
    }
}