<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskInvitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvitationManager extends Component
{
    public $taskId;
    public $email = '';
    public $members = [];
    public $pendingInvitations = [];
    
    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];
    
    protected $messages = [
        'email.exists' => 'This email is not registered in the system.',
    ];
    
    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadMembers();
    }
    
    public function loadMembers()
    {
        $task = Task::findOrFail($this->taskId);
        
        // Check if user can invite others
        if (Auth::user()->cannot('invite', $task)) {
            abort(403);
        }
        
        // Get members
        $this->members = $task->members()
            ->where('invitation_accepted', true)
            ->get()
            ->toArray();
            
        // Get pending invitations
        $this->pendingInvitations = $task->members()
            ->where('invitation_accepted', false)
            ->get()
            ->toArray();
    }
    
    public function inviteUser()
    {
        $this->validate();
        
        $task = Task::findOrFail($this->taskId);
        
        // Check if user can invite others
        if (Auth::user()->cannot('invite', $task)) {
            abort(403);
        }
        
        $user = User::where('email', $this->email)->first();
        
        // Check if the user is already a member
        if ($task->members()->where('user_id', $user->id)->exists()) {
            $this->addError('email', 'User is already a member or has a pending invitation.');
            return;
        }
        
        // Add user to the task
        $task->members()->attach($user->id, [
            'role' => 'member',
            'invitation_accepted' => false
        ]);
        
        // Send notification
        $user->notify(new TaskInvitation($task));
        
        $this->reset('email');
        $this->loadMembers();
        
        $this->dispatch('userInvited');
    }
    
    public function removeInvitation($userId)
    {
        $task = Task::findOrFail($this->taskId);
        
        // Check if user can invite others
        if (Auth::user()->cannot('invite', $task)) {
            abort(403);
        }
        
        $task->members()->detach($userId);
        
        $this->loadMembers();
        
        $this->dispatch('invitationRemoved');
    }
    
    public function changeRole($userId, $newRole)
    {
        $task = Task::findOrFail($this->taskId);
        
        // Check if user can invite others
        if (Auth::user()->cannot('invite', $task)) {
            abort(403);
        }
        
        $task->members()->updateExistingPivot($userId, [
            'role' => $newRole
        ]);
        
        $this->loadMembers();
        
        $this->dispatch('roleChanged');
    }
    
    public function render()
    {
        return view('livewire.invitation-manager');
    }
}
