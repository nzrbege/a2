<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\A2Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaController;

/*
|--------------------------------------------------------------------------
| Redirect root
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard.ringkasan');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        Route::get('/ringkasan', [DashboardController::class, 'ringkasan'])
            ->name('ringkasan');

        Route::get('/kendali-sub-kegiatan', [DashboardController::class, 'kendaliSubKegiatan'])
            ->name('kendali-sub-kegiatan');
    });

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | PENERIMA
    */
    Route::resource('penerima', PenerimaController::class);

    /*
    |--------------------------------------------------------------------------
    | REGISTER / A2
    |--------------------------------------------------------------------------
    */
    Route::prefix('a2')->name('a2.')->group(function () {

        Route::get('/', [A2Controller::class, 'index'])
            ->name('index');

        Route::get('/create', [A2Controller::class, 'create'])
            ->name('create');

        Route::post('/', [A2Controller::class, 'store'])
            ->name('store');

        Route::get('/{id}', [A2Controller::class, 'show'])
            ->name('show');

        Route::get('/{id}/edit', [A2Controller::class, 'edit'])
        ->name('edit');

        Route::put('/{id}', [A2Controller::class, 'update'])
        ->name('update');

        Route::delete('/{id}', [A2Controller::class, 'destroy'])
            ->name('destroy');

        Route::get('/{id}/print', [A2Controller::class, 'print'])
            ->name('print');

        /*
        |--------------------------------------------------------------------------
        | AJAX / FETCH
        |--------------------------------------------------------------------------
        */
        Route::get('/program-by-dpa/{versi}',
            [A2Controller::class, 'programByDpa']);

        Route::get('/kegiatan-by-program/{program}',
            [A2Controller::class, 'kegiatanByProgram']);

        Route::get('/subkegiatan-by-kegiatan/{kegiatan}',
            [A2Controller::class, 'subByKegiatan']);

        Route::get('/akun-by-subkegiatan/{subkegiatan}',
            [A2Controller::class, 'akunBySubKegiatan']);

        Route::post('/filter-rincian',
            [A2Controller::class, 'filterRincian']);
    });
});

require __DIR__.'/auth.php';
