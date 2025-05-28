<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-4xl mx-auto p-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold">{{ $task->title }}</h2>
                            <div class="flex space-x-2">
                                @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Edit Task
                                </a>
                                @endcan
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-gray-600">{{ $task->description }}</p>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <livewire:task-comments :task="$task" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
