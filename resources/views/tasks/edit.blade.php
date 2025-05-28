<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-4xl mx-auto p-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-4">Edit Task: {{ $task->title }}</h2>
                        <div class="flex items-center justify-between mb-4">
                            <a href="{{ route('tasks.show', $task) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Back to Task
                            </a>
                        </div>
                        <livewire:task-form :taskId="$task->id" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
