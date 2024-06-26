<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, config('app.locales'))) {
            App::setLocale($lang);
            session()->put('locale', $lang);
        }
        return redirect()->back();
    }
}
