<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class TaskComments extends Component
{
    public Task $task;

    #[Rule('required|min:2')]
    public string $newComment = '';

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function addComment()
    {
        $this->validate();

        $this->task->comments()->create([
            'content' => $this->newComment,
            'user_id' => Auth::user()->id,
        ]);

        $this->newComment = '';

        $this->dispatch('comment-added');
    }

    public function deleteComment(Comment $comment)
    {
        // Only allow comment deletion by the comment author or task owner
        if (Auth::user()->id === $comment->user_id || Auth::user()->id === $this->task->user_id) {
            $comment->delete();
            $this->dispatch('comment-deleted');
        }
    }

    public function render()
    {
        return view('livewire.task-comments', [
            'comments' => $this->task->comments()
                ->with('user')
                ->latest()
                ->get()
        ]);
    }
}
