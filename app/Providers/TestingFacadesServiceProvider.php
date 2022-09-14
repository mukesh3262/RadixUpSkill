<?php

namespace App\Providers;

use App\Support\MyString;
use Illuminate\Support\ServiceProvider;

class TestingFacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mylibrary',function($app){
            return new MyString;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
