<?php

namespace broshchak\multlang\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{

    public function changeLang(Request $request)
    {
        $oldSiteURL = $request->headers->get('referer');
        $newLang = $request->input('selectLang');
        $oldSiteURL_array = explode('/', $oldSiteURL);

        //if use links method of change languages in app.blade.php (method 2)
        if (count($request->all()) == 1 and $newLang == null) {
            $newLang = (key($request->all()));
        }

        Session::set('applocale', $newLang);
        App::setlocale($newLang);

        if (count($oldSiteURL_array) >= 3 and array_key_exists($oldSiteURL_array[3], Config::get('languages'))) {
            $oldSiteURL_array[3] = $newLang;
            $newURL = implode('/', $oldSiteURL_array);
            return redirect($newURL);
        } else if (count($oldSiteURL_array) >= 3 and !array_key_exists($oldSiteURL_array[3], Config::get('languages'))) {
            foreach ($oldSiteURL_array as $key => $val) {
                if ($key < 3) {
                    $newSiteURL_array[] = $oldSiteURL_array[$key];
                } else if ($key == 3) {
                    $newSiteURL_array[] = $newLang;
                    $newSiteURL_array[] = $oldSiteURL_array[$key];
                } else $newSiteURL_array[] = $oldSiteURL_array[$key];
            }
            $newURL = implode('/', $newSiteURL_array);
            return redirect($newURL);
        } else if (count($oldSiteURL_array) > 3) {
            $oldSiteURL_array[3] = $newLang;
            $newURL = implode('/', $oldSiteURL_array);
            return redirect($newURL);
        }
    }
}