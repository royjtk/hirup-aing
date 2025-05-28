@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold">Edit Task: {{ $task->title }}</h2>
                        <a href="{{ route('tasks.show', $task) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Back to Task
                        </a>
                    </div>
                </div>
                
                <livewire:task-form :taskId="$task->id" />
            </div>
        </div>
    </div>
</div>
@endsection
