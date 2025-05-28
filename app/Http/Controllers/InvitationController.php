<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Invite a user to a task
     */
    public function invite(Request $request, Task $task)
    {
        $this->authorize('invite', $task);
        
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Check if the user is already a member
        if ($task->members()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'User is already a member of this task.');
        }

        // Add user to the task
        $task->members()->attach($user->id, [
            'role' => 'member',
            'invitation_accepted' => false
        ]);

        // Send notification
        $user->notify(new TaskInvitation($task));

        return back()->with('success', 'Invitation sent successfully!');
    }

    /**
     * Accept an invitation
     */
    public function accept(Task $task)
    {
        $taskUser = $task->members()->where('user_id', Auth::id())->first();
        
        if (!$taskUser) {
            return redirect()->route('dashboard')->with('error', 'You are not invited to this task.');
        }

        $task->members()->updateExistingPivot(Auth::id(), [
            'invitation_accepted' => true
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Invitation accepted!');
    }

    /**
     * Decline an invitation
     */
    public function decline(Task $task)
    {
        $task->members()->detach(Auth::id());

        return redirect()->route('dashboard')->with('success', 'Invitation declined.');
    }

    /**
     * Show all pending invitations
     */
    public function pending()
    {
        $pendingInvitations = Auth::user()->memberTasks()
            ->where('invitation_accepted', false)
            ->with('user')
            ->get();

        return view('invitations.pending', compact('pendingInvitations'));
    }
}
