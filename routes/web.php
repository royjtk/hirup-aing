<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::resource('tasks', TaskController::class);
    
    // Invitation routes
    Route::post('/tasks/{task}/invite', [InvitationController::class, 'invite'])->name('tasks.invite');
    Route::get('/invitations', [InvitationController::class, 'pending'])->name('invitations.pending');
    Route::post('/invitations/{task}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{task}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/auth.php';
