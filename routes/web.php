<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\A2Controller;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\PenerimaController;

/*
|--------------------------------------------------------------------------
| Redirect root
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('reporting.realisasi');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('reporting')
    ->name('reporting.')
    ->group(function () {

        Route::match(['get','post'], '/realisasi', [ReportingController::class, 'realisasi'])
            ->name('realisasi');

        Route::get('/realisasi/reset', function () {
            session()->forget('filter');
            return redirect()->route('reporting.realisasi');
        })->name('realisasi.reset');
        
        Route::post('/filter-rincian',
            [ReportingController::class, 'filterRincian']);

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

    Route::get('/reporting/laporan-bulanan', [ReportingController::class, 'bulanan'])->name('reporting.bulanan');
    Route::get('/reporting/laporan-bulanan/pdf', [ReportingController::class, 'bulananPdf'])->name('reporting.bulanan.pdf');

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
