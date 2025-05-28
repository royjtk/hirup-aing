<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use Authorizable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the tasks that the user owns.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The tasks that the user is a member of.
     */
    public function memberTasks()
    {
        return $this->belongsToMany(Task::class)
            ->withPivot('role', 'invitation_accepted')
            ->withTimestamps();
    }

    /**
     * Get all comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
