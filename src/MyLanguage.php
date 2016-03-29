<?php
/**
 * Created by PhpStorm.
 * User: ii
 * Date: 24.02.16
 * Time: 9:05
 */

namespace broshchak\multlang;

use App;


class MyLanguage
{
    public function addLocaleToUrl($url=NULL)
    {
        // TODO: Implement addLocaleToUrl() method.
        /*
         * Main commands in class:
         *
         * get all data from file in config folder:
         * out of class:   $AllLocales = Config::get('languages');
         * in class:       $AllLocales = App::make('config')->get('languages')
         *
         * get parent url (old url):
         * out of class:   $oldURL = $request->headers->get('referer');
         * in class:       $oldURL = App::make('request')->headers->get('referer');
         *
         */
        $localeFromUrl = (App::make('request')->segment(1));

        if (array_key_exists($localeFromUrl, App::make('config')->get('languages'))) {
            return $localeFromUrl;
        }
        else {
            return null;
        }
    }

}