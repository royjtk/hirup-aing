<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskForm extends Component
{
    public $taskId;
    public $title = '';
    public $description = '';
    public $status = 'todo';
    public $dueDate = '';
    public $mode = 'create'; // create or edit
    
    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'status' => 'required|in:todo,in_progress,completed',
        'dueDate' => 'nullable|date',
    ];
    
    public function mount($taskId = null)
    {
        if ($taskId) {
            $this->taskId = $taskId;
            $this->mode = 'edit';
            
            $task = Task::findOrFail($taskId);
            
            // Authorize the user
            if (Auth::user()->cannot('update', $task)) {
                abort(403);
            }
            
            $this->title = $task->title;
            $this->description = $task->description;
            $this->status = $task->status;
            $this->dueDate = $task->due_date ? $task->due_date->format('Y-m-d') : '';
        }
    }
    
    public function saveTask()
    {
        $this->validate();
        
        if ($this->mode === 'create') {
            $task = Auth::user()->tasks()->create([
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'due_date' => $this->dueDate ?: null,
            ]);
            
            // Also add the creator as a member with owner role
            $task->members()->attach(Auth::id(), [
                'role' => 'owner',
                'invitation_accepted' => true
            ]);
            
            $this->reset(['title', 'description', 'status', 'dueDate']);
            
            $this->dispatch('taskCreated');
        } else {
            $task = Task::findOrFail($this->taskId);
            
            if (Auth::user()->cannot('update', $task)) {
                abort(403);
            }
            
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'due_date' => $this->dueDate ?: null,
            ]);
            
            $this->dispatch('taskUpdated');
        }
    }
    
    public function render()
    {
        return view('livewire.task-form');
    }
}
