<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Task Summary</h3>
                        <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Create New Task
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Pending Tasks</p>
                                    <p class="text-3xl font-bold text-yellow-600">{{ $pendingTasks ?? 0 }}</p>
                                </div>
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-800">In Progress</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ $inProgressTasks ?? 0 }}</p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-800">Completed</p>
                                    <p class="text-3xl font-bold text-green-600">{{ $completedTasks ?? 0 }}</p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Tasks</h3>
                            <div class="space-y-3">
                                @foreach(Auth::user()->tasks()->latest()->take(5)->get() as $task)
                                    <div class="bg-white p-4 border rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-lg font-medium text-blue-600 hover:underline">{{ $task->title }}</a>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($task->status === 'todo') bg-yellow-100 text-yellow-800
                                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline">View all tasks</a>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pending Invitations</h3>
                            <div class="space-y-3">
                                @php
                                    $pendingInvitations = Auth::user()->memberTasks()->where('invitation_accepted', false)->take(5)->get();
                                @endphp
                                
                                @forelse($pendingInvitations as $invitation)
                                    <div class="bg-white p-4 border rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-lg font-medium">{{ $invitation->title }}</p>
                                                <p class="text-sm text-gray-500">
                                                    Invited by: {{ $invitation->user->name }}
                                                </p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <form action="{{ route('invitations.accept', $invitation) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                                        Accept
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('invitations.decline', $invitation) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-white p-4 border rounded-lg text-center">
                                        <p class="text-gray-500">No pending invitations</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('invitations.pending') }}" class="text-blue-600 hover:underline">View all invitations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
