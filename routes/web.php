<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;

// Pre každý jazyk, vrátime konkrétnu view na základe aktuálneho jazyka
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sk'])) {
        App::setLocale($locale);
        Session::put('locale', $locale);
    }
    
    return redirect()->back();
})->name('set-language');

// Pridanie štandardných stránok pre každý jazyk
Route::get('/', function () {
    return view('welcome_' . App::getLocale());
})->name('welcome');

// LANGUAGE
Route::get('/sk', function () {
    App::setLocale('sk');
    return view('welcome_sk');
})->name('welcome.sk');

Route::get('/en', function () {
    App::setLocale('en');
    return view('welcome_en');
})->name('welcome.en');

// THEME
Route::post('/theme-toggle', function () {
    $new = session('theme') === 'dark' ? 'light' : 'dark';
    session(['theme' => $new]);
    return back();
})->name('theme.toggle');

// LOGIN
Route::get('/sk/login', function () {
    App::setLocale('sk');
    return view('auth.login_sk');
})->name('login.sk');

Route::get('/en/login', function () {
    App::setLocale('en');
    return view('auth.login_en');
})->name('login.en');

// REGISTER
Route::get('/sk/register', function () {
    App::setLocale('sk');
    return view('auth.register_sk');
})->name('register.sk');

Route::get('/en/register', function () {
    App::setLocale('en');
    return view('auth.register_en');
})->name('register.en');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('questions', QuestionController::class);
});

require __DIR__.'/auth.php';
