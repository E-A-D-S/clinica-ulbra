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

Route::prefix('paciente')->middleware('auth')->group(function () {
    Route::match(['get', 'post'], '', [UserController::class, 'index'])->middleware('can:pacientes.ver')->name('paciente.index');
    Route::match(['get', 'post'], '/arquivados', [UserController::class, 'arquivados'])->middleware('can:pacientes.arquivar')->name('paciente.arquivados');
    Route::put('/restaurar/{id}', [UserController::class, 'restaurar'])->middleware('can:pacientes.arquivar')->name('paciente.restaurar');
    Route::post('/atendimento/{id}', [UserController::class, 'storeAtendimento'])->middleware('can:atendimentos.registrar')->name('paciente.atendimento.store');
    Route::match(['get', 'post'], '/historico/{id}', [UserController::class, 'historicoPdf'])->middleware('can:pacientes.imprimir')->name('paciente.historico');

    // Equipe (gestao de acessos por papel) e Auditoria
    Route::get('/usuarios', [UserController::class, 'usuarios'])->middleware('can:usuarios.gerenciar')->name('paciente.usuarios');
    Route::post('/usuarios', [UserController::class, 'usuariosStore'])->middleware('can:usuarios.gerenciar')->name('paciente.usuarios.store');
    Route::put('/usuarios/{id}/status', [UserController::class, 'usuariosToggle'])->middleware('can:usuarios.gerenciar')->name('paciente.usuarios.toggle');
    Route::delete('/usuarios/{id}', [UserController::class, 'usuariosDestroy'])->middleware('can:usuarios.gerenciar')->name('paciente.usuarios.destroy');
    Route::get('/auditoria', [UserController::class, 'auditoria'])->middleware('can:auditoria.ver')->name('paciente.auditoria');

    Route::match(['get', 'post'], '/edit/{id}', [UserController::class, 'edit'])->middleware('can:pacientes.editar')->name('paciente.edit');
    Route::match(['get', 'post'], '/view/{id}', [UserController::class, 'view'])->middleware('can:pacientes.ver')->name('paciente.view');
    Route::put('/update/{id}', [UserController::class, 'update'])->middleware('can:pacientes.editar')->name('paciente.update');
    Route::match(['get', 'post'], 'generatePdf/{id}', [UserController::class, 'generatePdf'])->middleware('can:pacientes.imprimir')->name('paciente.generatePdf');
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('can:pacientes.arquivar')->name('paciente.destroy');
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
    })->name('dashboard');
});
