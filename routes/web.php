<?php

use App\Models\Preference;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AltRuleController;
use App\Http\Controllers\AltDiagnosisController;
use Illuminate\Support\Facades\Mail;
use App\Mail\Test;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('mail-test', function () {
    Mail::to('elfry.2nd@gmail.com')->send(new Test());

    echo 'Ok';
});

Route::get('/', function () {
    // return view('welcome');
    return view('home.index');
});

/* To use score-based diagnosis, uncomment the following four lines */
Route::get('/diagnosis', [AltDiagnosisController::class, 'index']);
Route::get('/diagnosis/create', [AltDiagnosisController::class, 'create']);
Route::post('/diagnosis', [AltDiagnosisController::class, 'store']);
Route::get('/diagnosis/result', [AltDiagnosisController::class, 'show']);

/* To use rule-based diagnosis, uncomment the following four lines */
// Route::get('/diagnosis', [DiagnosisController::class, 'index']);
// Route::get('/diagnosis/create', [DiagnosisController::class, 'create']);
// Route::post('/diagnosis', [DiagnosisController::class, 'store']);
// Route::get('/diagnosis/result', [DiagnosisController::class, 'show']);

Route::get('/dashboard', function () {
    return redirect('/diseases');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('ke')->group(function () {
        Route::resource('symptoms', SymptomController::class);
        Route::resource('diseases', DiseaseController::class);

        /* To use score-based rules, uncomment the following line*/
        Route::resource('rules', AltRuleController::class);

        /* To use symptoms-combination-based rules, uncomment the following line*/
        // Route::resource('rules', RuleController::class);
    });

    Route::middleware('admin')->group(function () {
        Route::resource('experts', ExpertController::class);
        Route::resource('users', RegisteredUserController::class);
    });

    Route::get('/preferences/{name}/{value}', [PreferenceController::class, 'set']);
    Route::get('/preferences/{name}', [PreferenceController::class, 'get']);
});

require __DIR__.'/auth.php';
