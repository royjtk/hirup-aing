<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The task instance.
     */
    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You have been invited to a task')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have been invited to collaborate on a task: ' . $this->task->title)
            ->line('Task Details: ' . $this->task->description)
            ->action('View Task', url('/tasks/' . $this->task->id . '/accept'))
            ->line('If you do not wish to join this task, you can ignore this email or decline the invitation.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'inviter' => $this->task->user->name,
        ];
    }
}
