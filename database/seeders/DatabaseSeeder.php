<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a demo user
        $user1 = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Create another user for task assignments/invitations
        $user2 = User::factory()->create([
            'name' => 'Team Member',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Create some tasks for the demo user
        $tasks = [
            [
                'title' => 'Complete project setup',
                'description' => 'Set up the project environment, install dependencies, and configure the database.',
                'status' => 'completed',
                'due_date' => now()->addDays(1),
            ],
            [
                'title' => 'Implement user authentication',
                'description' => 'Set up user authentication with registration, login, and password reset functionality.',
                'status' => 'in_progress',
                'due_date' => now()->addDays(3),
            ],
            [
                'title' => 'Design database schema',
                'description' => 'Create database migrations for all the required tables and relationships.',
                'status' => 'todo',
                'due_date' => now()->addDays(5),
            ],
            [
                'title' => 'Create frontend components',
                'description' => 'Develop the necessary frontend components using Tailwind CSS and Livewire.',
                'status' => 'todo',
                'due_date' => now()->addDays(7),
            ],
        ];
        
        foreach ($tasks as $taskData) {
            $task = $user1->tasks()->create($taskData);
            
            // Add the creator as a member with owner role
            $task->members()->attach($user1->id, [
                'role' => 'owner',
                'invitation_accepted' => true,
            ]);
            
            // For the first two tasks, add the second user as a member
            if ($taskData['status'] === 'completed' || $taskData['status'] === 'in_progress') {
                $task->members()->attach($user2->id, [
                    'role' => 'member',
                    'invitation_accepted' => true,
                ]);
            }
        }
        
        // Create a task from the second user and invite the first user
        $sharedTask = $user2->tasks()->create([
            'title' => 'Collaborative task',
            'description' => 'This is a task created by Team Member that Demo User has been invited to.',
            'status' => 'todo',
            'due_date' => now()->addDays(10),
        ]);
        
        // Add creator as owner
        $sharedTask->members()->attach($user2->id, [
            'role' => 'owner',
            'invitation_accepted' => true,
        ]);
        
        // Invite user1 but don't accept yet
        $sharedTask->members()->attach($user1->id, [
            'role' => 'member',
            'invitation_accepted' => false,
        ]);
    }
}
