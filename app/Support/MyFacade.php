<?php
  
namespace App\Support;
  
use Illuminate\Support\Facades\Facade;
  
class MyFacade extends Facade{

    protected static function getFacadeAccessor() { 

        return 'mylibrary'; 
    }
}
