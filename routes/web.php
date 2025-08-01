<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Task;

Route::get('/', function () {
    return view('welcome-new');
});

Route::get('/dashboard', function () {
    $userId = Auth::id();
    
    // Try to get cached statistics first
    $stats = Cache::get("user.{$userId}.task_stats");
    
    // If no cache or cache is old, calculate and cache
    if (!$stats || $stats['updated_at']->diffInMinutes(now()) > 60) {
        $pendingTasks = Auth::user()->tasks()->where('status', 'todo')->count() + 
                      Auth::user()->memberTasks()->where('invitation_accepted', true)->where('status', 'todo')->count();
        
        $inProgressTasks = Auth::user()->tasks()->where('status', 'in_progress')->count() + 
                          Auth::user()->memberTasks()->where('invitation_accepted', true)->where('status', 'in_progress')->count();
        
        $completedTasks = Auth::user()->tasks()->where('status', 'completed')->count() + 
                         Auth::user()->memberTasks()->where('invitation_accepted', true)->where('status', 'completed')->count();
        
        $stats = [
            'pending' => $pendingTasks,
            'in_progress' => $inProgressTasks,
            'completed' => $completedTasks,
            'updated_at' => now(),
        ];
        
        Cache::put("user.{$userId}.task_stats", $stats, 60 * 24); // Cache for 24 hours
    }
    
    return view('dashboard', [
        'pendingTasks' => $stats['pending'],
        'inProgressTasks' => $stats['in_progress'],
        'completedTasks' => $stats['completed'],
    ]);
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
