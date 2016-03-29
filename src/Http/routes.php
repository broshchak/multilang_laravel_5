<?php


Route::group(['prefix' => MyLocale::addLocaleToUrl(), 'middleware' => ['web']], function () {

    //if use Method 1 (form method) in app.blade.php:
    Route::post('lang', ['as' => 'langSwitch', 'uses' => 'LanguageController@changeLang']);

    //if use Method 2 (links method) in app.blade.php:
    Route::get('lang', ['as' => 'langSwitch', 'uses' => 'LanguageController@changeLang']);

});