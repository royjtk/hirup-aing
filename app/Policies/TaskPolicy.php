<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view the task list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // User can view the task if they are the owner or a member who has accepted the invitation
        return $user->id === $task->user_id || 
               $task->members()->where('user_id', $user->id)
                   ->where('invitation_accepted', true)
                   ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create tasks
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Only the task owner or members with owner role can update the task
        return $user->id === $task->user_id || 
               $task->members()->where('user_id', $user->id)
                   ->where('role', 'owner')
                   ->where('invitation_accepted', true)
                   ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Only the task owner can delete the task
        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can invite others to the model.
     */
    public function invite(User $user, Task $task): bool
    {
        // Only the task owner or members with owner role can invite others
        return $user->id === $task->user_id || 
               $task->members()->where('user_id', $user->id)
                   ->where('role', 'owner')
                   ->where('invitation_accepted', true)
                   ->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
