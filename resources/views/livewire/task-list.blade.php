<div>
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Your Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Create New Task
            </a>
        </div>
        
        <div class="flex items-center space-x-4 mb-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search tasks..." 
                    class="w-full px-4 py-2 border rounded"
                >
            </div>
            
            <div>
                <select wire:model.live="filter" class="px-4 py-2 border rounded">
                    <option value="all">All Tasks</option>
                    <option value="owned">My Tasks</option>
                    <option value="member">Shared With Me</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="space-y-4">
        @forelse ($tasks as $task)
            <div class="p-4 bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold">
                            <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">
                                {{ $task->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">
                            Created by: {{ $task->user->name }} | 
                            Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                        </p>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($task->status === 'todo') bg-yellow-100 text-yellow-800
                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        
                        <div class="flex items-center space-x-2">
                            @if($task->user_id === auth()->id() || $task->members->where('id', auth()->id())->where('pivot.role', 'owner')->first())
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                
                                <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                            
                            @if($task->status !== 'completed')
                                <button wire:click="markAsCompleted({{ $task->id }})" class="text-green-500 hover:text-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($task->description)
                    <div class="mt-2">
                        <p class="text-gray-700">{{ Str::limit($task->description, 100) }}</p>
                    </div>
                @endif
                
                <div class="mt-3 flex items-center space-x-2">
                    <div class="flex -space-x-2">
                        @foreach($task->members->take(5) as $member)
                            <div class="h-6 w-6 rounded-full bg-gray-300 border border-white flex items-center justify-center text-xs" title="{{ $member->name }}">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endforeach
                        
                        @if($task->members->count() > 5)
                            <div class="h-6 w-6 rounded-full bg-gray-200 border border-white flex items-center justify-center text-xs">
                                +{{ $task->members->count() - 5 }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 bg-white rounded-lg shadow-md text-center">
                <p class="text-gray-500">No tasks found matching your criteria.</p>
                <a href="{{ route('tasks.create') }}" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Create Your First Task
                </a>
            </div>
        @endforelse
        
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
