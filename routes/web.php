<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\TarefaController;

// Home
Route::get('/', [DevController::class, 'index'])->name('home');

// Devs routes
Route::get('/devs', [DevController::class, 'index'])->name('devs.index');
Route::get('/devs/create', [DevController::class, 'create'])->name('devs.create');
Route::post('/devs', [DevController::class, 'store'])->name('devs.store');
Route::get('/devs/{id}/edit', [DevController::class, 'edit'])->name('devs.edit');
Route::put('/devs/{id}', [DevController::class, 'update'])->name('devs.update');
Route::delete('/devs/{id}', [DevController::class, 'destroy'])->name('devs.destroy');
Route::get('/devs/{id}/tarefas', [DevController::class, 'tarefasAjax']);

// Tarefas routes
Route::get('/tarefas', [TarefaController::class, 'index'])->name('tarefas.index');
Route::get('/tarefas/create', [TarefaController::class, 'create'])->name('tarefas.create');
Route::post('/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');
Route::get('/tarefas/{id}/edit', [TarefaController::class, 'edit'])->name('tarefas.edit');
Route::put('/tarefas/{id}', [TarefaController::class, 'update'])->name('tarefas.update');
Route::delete('/tarefas/{id}', [TarefaController::class, 'destroy'])->name('tarefas.destroy');
Route::get('/tarefas/export-pdf', [TarefaController::class, 'exportPdf'])->name('tarefas.exportPdf');
