<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes are managed by Laravel Breeze or Fortify
// Add these if you haven't set up authentication yet

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Invitation routes
    Route::post('/tasks/{task}/invite', [InvitationController::class, 'invite'])->name('invitations.invite');
    Route::get('/tasks/{task}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::get('/tasks/{task}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
    Route::get('/invitations/pending', [InvitationController::class, 'pending'])->name('invitations.pending');
});
