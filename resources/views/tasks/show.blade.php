@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold">{{ $task->title }}</h2>
                        <div class="flex items-center space-x-2">
                            @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Edit Task
                            </a>
                            @endcan
                            
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Back to Tasks
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-2 flex items-center">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($task->status === 'todo') bg-yellow-100 text-yellow-800
                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        
                        <span class="ml-4 text-sm text-gray-500">
                            Created by: {{ $task->user->name }} | 
                            Created: {{ $task->created_at->format('M d, Y') }} | 
                            Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                        </span>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $task->description ?: 'No description provided.' }}</p>
                </div>
                
                @can('invite', $task)
                <div class="mb-6">
                    <livewire:invitation-manager :taskId="$task->id" />
                </div>
                @endcan
                
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Task Activity</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 italic">Task activity will be shown here in the future.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
