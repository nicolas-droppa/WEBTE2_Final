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
        // Skontrolujeme, či je jazyk v URL (ako parameter `lang`)
        if ($locale = $request->get('lang')) {
            // Ak je parameter `lang`, nastavíme jazyk
            if (in_array($locale, ['en', 'sk'])) {
                App::setLocale($locale);
                Session::put('locale', $locale);
            }
        } elseif (Session::has('locale')) {
            // Ak jazyk nie je v URL, ale je v session, nastavíme jazyk zo session
            App::setLocale(Session::get('locale'));
        } else {
            // Ak nie je jazyk v URL ani v session, použijeme predvolený jazyk
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
