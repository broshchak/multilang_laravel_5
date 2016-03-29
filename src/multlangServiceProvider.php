<?php

namespace broshchak\multlang;

use Illuminate\Support\ServiceProvider;
use App;

class multlangServiceProvider extends ServiceProvider
{

    public function register()
    {
        // TODO: Implement register() method.
        /*$this->app->bind('App\MyLanguageInterface', 'App\MyLanguage');*/
        App::bind('broshchak\multlang\MyLanguageInterface', 'broshchak\multlang\MyLanguage');
    }

    public function boot()
    {
        $this->app->router->group(['namespace' => 'broshchak\multlang\Http\Controllers'],
            function(){
                require __DIR__.'/Http/routes.php';
            });
    }

}