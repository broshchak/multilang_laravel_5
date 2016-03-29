<?php

namespace broshchak\multlang\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class addLocaleToURL
{
    public function handle($request, Closure $next)
    {
        /** additional function addLocale() of addLangToUrl middleware */
        function addLocale($newLang)
        {
            //$siteUrl_array = $request->segments();
            $currentSiteUrl_array = App::make('request')->segments();
            //if root directory
            if (count ($currentSiteUrl_array) == 0) {
                return ('/'.$newLang);
            }
            App::setLocale($newLang);
            session::put('applocale', $newLang);
            foreach ($currentSiteUrl_array as $key => $val) {
                if ($key == 0) {
                    $newURL_array[0] = $newLang;
                    $newURL_array[] = $currentSiteUrl_array[$key];
                } else {
                    $newURL_array[] = $currentSiteUrl_array[$key];
                }
            }
            $newURL = implode('/', $newURL_array);
            return $newURL;
        }
        /** main part of addLangToUrl middleware */
        $route = Route::current();
        $actionName = $route->getActionName();
        $oldSiteURL = $request->headers->get('referer');
        $oldSiteURL_array = explode('/', $oldSiteURL);
        if (count($oldSiteURL_array) >= 3) {
            $langFromOldUrl = $oldSiteURL_array[3];
        }
        //if this is not function of change language and in active url is not language
        if ($actionName !== 'switchLang' and !array_key_exists($request->segment(1), Config::get('languages'))) {
            //if old url >=3 and in this url is language
            if (count($oldSiteURL_array) >= 3 and array_key_exists($langFromOldUrl, Config::get('languages'))) {
                $newLang = $langFromOldUrl;
                return redirect(addLocale($newLang));
            }
            //if old url >=3 and in this url is not language
            else if (count($oldSiteURL_array) >= 3 and !array_key_exists($langFromOldUrl, Config::get('languages'))) {
                if (session::get('applocale')) {
                    $newLang = session::get('applocale');
                    return redirect(addLocale($newLang));
                } else if (App::getLocale()) {
                    $newLang = App::getLocale();
                    return redirect(addLocale($newLang));
                } else {
                    $newLang = Config::get('app.fallback_locale');
                    return redirect(addLocale($newLang));
                }
            }
            //if old url < 3 and in this url is not language
            else if (count($oldSiteURL_array) < 3) {
                if (session::get('applocale')) {
                    $newLang = session::get('applocale');
                    return redirect(addLocale($newLang));
                } else if (App::getLocale()) {
                    $newLang = App::getLocale();
                    return redirect(addLocale($newLang));
                } else {
                    $newLang = Config::get('app.fallback_locale');
                    return redirect(addLocale($newLang));
                }
            }
        }
        return $next($request);
    }
}

