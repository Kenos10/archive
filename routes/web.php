<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ZipExtractController;
use App\Http\Controllers\CaseFormatController;
use App\Http\Controllers\FileFormatController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/add-patient', function () {
        return view('addpatient');
    })->name('addpatient');

    Route::get('/view-patient', function () {
        return view('viewpatient');
    })->name('viewpatient');

    Route::get('/view-zip', function () {
        return view('viewzip');
    })->name('viewzip');

    Route::get('/setting', [ArchiveController::class, 'setting'])->name('setting');

    Route::get('/extract', function () {
        return view('viewzip');
    })->name('extract');

    Route::get('/setting', [ArchiveController::class, 'setting'])->name('setting');
    Route::post('/update-ftp-settings', [ArchiveController::class, 'updateFtpSettings'])->name('update.ftp.settings');
    Route::get('/downloadzip/{id}', [ArchiveController::class, 'download'])->name('zip');
    Route::get('/storezip/{id}', [ArchiveController::class, 'downloadPath'])->name('store.zip');

    Route::post('/case-format', [CaseFormatController::class, 'store'])->name('case.format.store');
    Route::post('/file-format', [FileFormatController::class, 'store'])->name('file.format.store');

    Route::get('/zip', function () {
        return view('zip');
    })->name('zip_form');

    Route::post('/upload_zip', [ZipExtractController::class, 'extractAndListFiles'])->name('upload_zip');
    Route::get('/view_file/{filename}', [ZipExtractController::class, 'viewFile'])->name('view_file')->where('filename', '.*');
    Route::get('/delete-extracted-folder', [ZipExtractController::class, 'deleteExtractedFolder'])->name('delete.extracted.folder');

    Route::resource('archives', ArchiveController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('files', FileController::class);
    Route::resource('zips', ZipExtractController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
