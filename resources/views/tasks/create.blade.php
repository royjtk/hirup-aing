<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-4xl mx-auto p-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-4">Create New Task</h2>
                        <livewire:task-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
