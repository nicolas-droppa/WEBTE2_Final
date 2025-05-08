<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// Pre každý jazyk, vrátime konkrétnu view na základe aktuálneho jazyka
Route::get('lang/{locale}', function ($locale) {
    // Overíme, či je jazyk validný
    if (in_array($locale, ['en', 'sk'])) {
        App::setLocale($locale); // Nastavíme aktuálny jazyk
        Session::put('locale', $locale); // Uložíme jazyk do session
    }
    
    // Prepresmerujeme na predchádzajúcu stránku
    return redirect()->back();
})->name('set-language');

// Pridanie štandardných stránok pre každý jazyk
Route::get('/', function () {
    return view('welcome_' . App::getLocale());
})->name('welcome');

// Nastavenie pre slovenský jazyk
Route::get('/sk', function () {
    App::setLocale('sk');
    return view('welcome_sk');
})->name('welcome.sk');

// Nastavenie pre anglický jazyk
Route::get('/en', function () {
    App::setLocale('en');
    return view('welcome_en');
})->name('welcome.en');

Route::post('/theme-toggle', function () {
    $new = session('theme') === 'dark' ? 'light' : 'dark';
    session(['theme' => $new]);
    return back();
})->name('theme.toggle');