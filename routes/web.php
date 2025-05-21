<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\SetLocale;

use App\Http\Controllers\TestController;
use App\Http\Controllers\TestTakingController;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sk'])) {
        App::setLocale($locale);
        Session::put('locale', $locale);
    }

    $previousUrl = url()->previous();

    if (strpos($previousUrl, 'lang=') !== false) {
        $newUrl = preg_replace('/([?&])lang=[^&]+/', '$1lang=' . $locale, $previousUrl);
    } else {
        $newUrl = $previousUrl . (parse_url($previousUrl, PHP_URL_QUERY) ? '&' : '?') . 'lang=' . $locale;
    }

    return redirect()->to($newUrl);
})->name('set-language');

Route::middleware([SetLocale::class])->group(function () {
    // TESTS
    Route::get('/test/{test}/start', [TestTakingController::class, 'start'])->name('test.start');
    Route::get('/test/question', [TestTakingController::class, 'showQuestion'])->name('test.question');
    Route::post('/test/question', [TestTakingController::class, 'submitAnswer'])->name('test.answer');
    Route::get('/test/result', [TestTakingController::class, 'result'])->name('test.result');
    Route::get('/tests/{test}/start', [TestTakingController::class, 'start'])->name('tests.start');
    Route::get('/tests', [TestTakingController::class, 'index'])->name('test.index');

    // HOME
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    // LOGIN
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // REGISTER
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // THEME TOGGLE
    Route::post('/theme-toggle', function () {
        $new = session('theme') === 'dark' ? 'light' : 'dark';
        session(['theme' => $new]);

        return back();
    })->name('theme.toggle');

    // DASHBOARD
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // Auth routes (login, register, etc.)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //Route::resource('questions', QuestionController::class);

        //Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        // Route::get('/history/tests/{id}', [HistoryController::class, 'showTest'])->name('history.tests.show');
        // Route::get('/history/questions/{id}', [HistoryController::class, 'showQuestion'])->name('history.questions.show');
        // Route::get('/history/export-questions', [HistoryController::class, 'exportQuestions'])->name('export-questions');
        // Route::get('/history/export-test', [HistoryController::class, 'exportTests'])->name('export-tests');

        //Route::resource('tests', TestController::class);
        //Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    /*
     * Toto cele je jebnuty bypass na middleware lebo mi nesiel a preto
     * mame potom v controlleroch vzdy vratkov ofajč na kontrolu admina
     */
    Route::prefix('admin')
        ->middleware('auth')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])
                ->name('dashboard');

            Route::resource('questions', QuestionController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

            Route::resource('tests', TestController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

            Route::get('/history', [HistoryController::class, 'index'])
                ->name('history');

            Route::get('/history', [HistoryController::class, 'index'])
                ->name('history.index');

            Route::get('/history/tests/{id}', [HistoryController::class, 'showTest'])
                ->name('history.tests.show');

            Route::get('/history/questions/{id}', [HistoryController::class, 'showQuestion'])
                ->name('history.questions.show');

            Route::get('/history/export-questions', [HistoryController::class, 'exportQuestions'])
                ->name('history.export-questions');

            Route::get('/history/export-test', [HistoryController::class, 'exportTests'])
                ->name('history.export-tests');
        });
});

Route::get('/manual/download', [ManualController::class, 'downloadManual'])->name('manual.download');

Route::middleware([SetLocale::class])->group(function () {
    require __DIR__ . '/auth.php';
});
