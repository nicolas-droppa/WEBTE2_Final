<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

<<<<<<< HEAD
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
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
>>>>>>> darktheme
