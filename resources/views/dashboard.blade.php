<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-64 border-r bg-white">
            <div class="p-4">
                <!-- Profile Button -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 w-full hover:bg-gray-50 p-2 rounded-lg">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full">
                        <span class="font-medium flex-1 text-left">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Profile Dropdown Menu -->
                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 py-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                        style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-1 mb-6">
                    <button class="w-full flex items-center space-x-2 px-4 py-2 text-left hover:bg-gray-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <span>All-day</span>
                    </button>
                    <button class="w-full flex items-center space-x-2 px-4 py-2 text-left bg-blue-50 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>Today</span>
                    </button>
                </div>

                <!-- Lists -->
                <div class="mb-6">
                    <h3 class="px-4 text-sm font-medium text-gray-500 mb-2">Lists</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Work</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Workout</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Learning</span>
                        </a>
                    </div>
                </div>

                <!-- Tags -->
                <div>
                    <h3 class="px-4 text-sm font-medium text-gray-500 mb-2">Tags</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            <span>work</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span>personal</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                            <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                            <span>inspiration</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-4xl mx-auto p-8">
                <!-- Today's Activities -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Today Activities</h2>
                        <button class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            <span>New Activity</span>
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Manage your habits, reminders, events, activities.</p>

                    <!-- Habits Grid -->
                    <div class="grid grid-cols-5 gap-4 mb-8">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium">Observing</h3>
                            <p class="text-xs text-gray-500">07:00 - 07:30</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-pink-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium">Self Care</h3>
                            <p class="text-xs text-gray-500">08:00 - 08:30</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium">Reading</h3>
                            <p class="text-xs text-gray-500">09:00 - 09:30</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium">Meeting</h3>
                            <p class="text-xs text-gray-500">10:00 - 10:30</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium">Learning</h3>
                            <p class="text-xs text-gray-500">11:00 - 11:30</p>
                        </div>
                    </div>

                    <!-- To Do List -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">To Do List</h2>
                            <button class="text-sm text-blue-600 hover:text-blue-700">+ Add Task</button>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                            <div class="p-4 border-b">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>10x rep biceps</span>
                                </div>
                            </div>
                            <div class="p-4 border-b">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>5x rep legs</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>10x rep back</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
