<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;
    
    public $filter = 'all'; // Filter options: all, owned, member, completed, pending
    public $search = '';
    
    protected $queryString = [
        'filter' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $user = Auth::user();
        
        $query = Task::query();
        
        // Apply filter
        if ($this->filter === 'owned') {
            $query->where('user_id', $user->id);
        } elseif ($this->filter === 'member') {
            $query->whereHas('members', function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('invitation_accepted', true)
                  ->where('role', 'member');
            });
        } elseif ($this->filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($this->filter === 'pending') {
            $query->where('status', 'todo');
        } else {
            // All tasks where the user is either the owner or a member
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('members', function($q) use ($user) {
                      $q->where('user_id', $user->id)
                        ->where('invitation_accepted', true);
                  });
            });
        }
        
        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        $tasks = $query->with(['user', 'members'])
                      ->latest()
                      ->paginate(10);
        
        return view('livewire.task-list', [
            'tasks' => $tasks
        ]);
    }
    
    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        
        if ($task && Auth::user()->can('delete', $task)) {
            $task->delete();
            
            $this->dispatch('taskDeleted');
        }
    }
    
    public function markAsCompleted($taskId)
    {
        $task = Task::find($taskId);
        
        if ($task && Auth::user()->can('update', $task)) {
            $task->status = 'completed';
            $task->save();
            
            $this->dispatch('taskUpdated');
        }
    }
}
