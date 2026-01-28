    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\A2Controller;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
    return redirect()->route('a2.create');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('a2')->name('a2.')->group(function () {

            /* =========================
            | FORM & SIMPAN
            ========================= */
            Route::get('/create', [A2Controller::class, 'create'])
                ->name('create');

            Route::post('/', [A2Controller::class, 'store'])
                ->name('store');

            Route::get('/{id}', [A2Controller::class, 'show'])
                ->name('show');

            Route::get('/{id}/print', [A2Controller::class, 'print'])
                ->name('print');


            /* =========================
            | AJAX / FETCH (HARUS SAMA)
            ========================= */

            // JS: fetch(`/a2/program-by-dpa/${versi}`)
            Route::get('/program-by-dpa/{versi}', 
                [A2Controller::class, 'programByDpa']);

            // JS: fetch(`/a2/kegiatan-by-program/${programId}`)
            Route::get('/kegiatan-by-program/{program}', 
                [A2Controller::class, 'kegiatanByProgram']);

            // JS: fetch(`/a2/subkegiatan-by-kegiatan/${kegiatanId}`)
            Route::get('/subkegiatan-by-kegiatan/{kegiatan}', 
                [A2Controller::class, 'subByKegiatan']);

            // JS: fetch(`/a2/akun-by-subkegiatan/${sub}`)
            Route::get('/akun-by-subkegiatan/{subkegiatan}', 
                [A2Controller::class, 'akunBySubKegiatan']);

            // JS: fetch(`/a2/filter-rincian`, POST)
            Route::post('/filter-rincian', 
                [A2Controller::class, 'filterRincian']);

        });
    });

    require __DIR__ . '/auth.php';
