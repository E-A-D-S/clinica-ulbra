<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::match(['get', 'post'], '/form', [UserController::class, 'home'])->name('paciente.home');
Route::match(['get', 'post'], '/home', [UserController::class, 'homeScreen'])->name('paciente.homeScreen');
Route::post('paciente/store', [UserController::class, 'store'])->middleware('throttle:6,1')->name('paciente.store');

// Login com Google (OAuth)
Route::get('/auth/google', [UserController::class, 'redirectGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [UserController::class, 'callbackGoogle'])->name('google.callback');
// diagnostico temporario do login/permissao
Route::get('/auth/whoami', [UserController::class, 'whoami'])->name('auth.whoami');

Route::prefix('paciente')->middleware('can:admin')->group(function () {
    Route::match(['get', 'post'], '', [UserController::class, 'index'])->name('paciente.index');
    Route::match(['get', 'post'], '/arquivados', [UserController::class, 'arquivados'])->name('paciente.arquivados');
    Route::put('/restaurar/{id}', [UserController::class, 'restaurar'])->name('paciente.restaurar');
    Route::post('/atendimento/{id}', [UserController::class, 'storeAtendimento'])->name('paciente.atendimento.store');
    Route::match(['get', 'post'], '/historico/{id}', [UserController::class, 'historicoPdf'])->name('paciente.historico');
    Route::match(['get', 'post'], '/permission', [UserController::class, 'permission'])->name('paciente.permission');
    Route::match(['get', 'post'], '/permission/{id}', [UserController::class, 'permissionEdit'])->name('paciente.permission.edit');
    Route::put('/permission/update/{id}', [UserController::class, 'permissionUpdate'])->name('paciente.permission.update');
    Route::match(['get', 'post'], '/create', [UserController::class, 'create'])->name('paciente.create');
    
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('paciente.destroy');
    Route::match(['get', 'post'], '/edit/{id}', [UserController::class, 'edit'])->name('paciente.edit');
    Route::match(['get', 'post'], '/view/{id}', [UserController::class, 'view'])->name('paciente.view');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('paciente.update');
    Route::match(['get', 'post'], 'generatePdf/{id}', [UserController::class, 'generatePdf'])->name('paciente.generatePdf');
});

Route::match(['get', 'post'], '/', function() {
    return redirect()->route('paciente.homeScreen');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/paciente');
    })->name('dashboard')->middleware('can:admin');
});
