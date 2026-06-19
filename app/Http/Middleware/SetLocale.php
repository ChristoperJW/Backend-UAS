<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        } 
        else {
            $browserLang = $request->getPreferredLanguage(['id', 'en']);
            
            $locale = in_array($browserLang, ['id', 'en']) ? $browserLang : config('app.fallback_locale', 'id');
            
            App::setLocale($locale);
            Session::put('applocale', $locale);
        }

        return $next($request);
    }
}