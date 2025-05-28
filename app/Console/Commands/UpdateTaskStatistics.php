<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateTaskStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-task-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update task statistics for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating task statistics for all users...');
        
        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));
        $bar->start();
        
        foreach ($users as $user) {
            // Calculate task statistics for the user
            $pendingTasks = $user->tasks()->where('status', 'todo')->count() + 
                           $user->memberTasks()->where('invitation_accepted', true)->where('status', 'todo')->count();
            
            $inProgressTasks = $user->tasks()->where('status', 'in_progress')->count() + 
                              $user->memberTasks()->where('invitation_accepted', true)->where('status', 'in_progress')->count();
            
            $completedTasks = $user->tasks()->where('status', 'completed')->count() + 
                             $user->memberTasks()->where('invitation_accepted', true)->where('status', 'completed')->count();
            
            // Cache the statistics for the user
            Cache::put("user.{$user->id}.task_stats", [
                'pending' => $pendingTasks,
                'in_progress' => $inProgressTasks,
                'completed' => $completedTasks,
                'total' => $pendingTasks + $inProgressTasks + $completedTasks,
                'updated_at' => now(),
            ], 60 * 24); // Cache for 24 hours
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Task statistics updated successfully!');
        
        return Command::SUCCESS;
    }
}
