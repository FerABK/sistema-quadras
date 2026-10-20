<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuadraController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\BloqueioController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bloqueios', [BloqueioController::class, 'index'])->name('bloqueios.index');
    Route::get('/bloqueios/novo', [BloqueioController::class, 'create'])->name('bloqueios.create');
    Route::post('/bloqueios', [BloqueioController::class, 'store'])->name('bloqueios.store');
    Route::get('/bloqueios/{bloqueio}/editar', [BloqueioController::class, 'edit'])->name('bloqueios.edit');
    Route::put('/bloqueios/{bloqueio}', [BloqueioController::class, 'update'])->name('bloqueios.update');
    Route::delete('/bloqueios/{bloqueio}', [BloqueioController::class, 'destroy'])->name('bloqueios.destroy');

    Route::get('/avaliacoes', [AvaliacaoController::class, 'index'])->name('avaliacoes.index');
    Route::get('/avaliacoes/nova', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    Route::get('/avaliacoes/{avaliacao}/editar', [AvaliacaoController::class, 'edit'])->name('avaliacoes.edit');
    Route::put('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('avaliacoes.update');
    Route::delete('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('avaliacoes.destroy');

    Route::get('/quadras', [QuadraController::class, 'index'])->name('quadras.index');

    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/nova', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
   
    Route::middleware('admin')->group(function () {

        Route::get('/quadras/nova', [QuadraController::class, 'create'])->name('quadras.create');
        Route::post('/quadras', [QuadraController::class, 'store'])->name('quadras.store');
        Route::get('/quadras/{quadra}/editar', [QuadraController::class, 'edit'])->name('quadras.edit');
        Route::put('/quadras/{quadra}', [QuadraController::class, 'update'])->name('quadras.update');
        Route::delete('/quadras/{quadra}', [QuadraController::class, 'destroy'])->name('quadras.destroy');

        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/novo', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        Route::prefix('relatorios')->name('relatorios.')->group(function () {
            Route::get('/', [RelatorioController::class, 'index'])->name('index');
            Route::get('/todas-as-reservas', [RelatorioController::class, 'todas'])->name('todas');
            Route::get('/por-data', [RelatorioController::class, 'porData'])->name('data');            
            Route::get('/faturamento', [RelatorioController::class, 'faturamento'])->name('faturamento');
            Route::get('/horarios', [RelatorioController::class, 'horarios'])->name('horarios');
            Route::get('/quadras-mais-usadas', [RelatorioController::class, 'quadrasMaisUsadas'])->name('quadras-mais-usadas');
            
        });
    });
});