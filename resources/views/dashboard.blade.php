@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">My Tasks Overview</h2>
                        
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg text-center">
                                <span class="text-3xl font-bold text-blue-600">{{ auth()->user()->tasks()->count() }}</span>
                                <p class="text-sm text-gray-600 mt-1">Total Tasks</p>
                            </div>
                            
                            <div class="bg-yellow-50 p-4 rounded-lg text-center">
                                <span class="text-3xl font-bold text-yellow-600">{{ auth()->user()->tasks()->where('status', 'todo')->count() }}</span>
                                <p class="text-sm text-gray-600 mt-1">Pending</p>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg text-center">
                                <span class="text-3xl font-bold text-green-600">{{ auth()->user()->tasks()->where('status', 'completed')->count() }}</span>
                                <p class="text-sm text-gray-600 mt-1">Completed</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-center">
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                View All Tasks
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                        
                        <div class="space-y-4">
                            <a href="{{ route('tasks.create') }}" class="block w-full p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                <div class="flex items-center">
                                    <div class="bg-blue-500 p-2 rounded-full text-white mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Create New Task</h3>
                                        <p class="text-sm text-gray-500">Add a new task to your list</p>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('invitations.pending') }}" class="block w-full p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                                <div class="flex items-center">
                                    <div class="bg-yellow-500 p-2 rounded-full text-white mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Pending Invitations</h3>
                                        <p class="text-sm text-gray-500">Check tasks you've been invited to</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 italic">Recent activity will be shown here in the future.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
