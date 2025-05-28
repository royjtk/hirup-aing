@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold">Pending Invitations</h2>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @forelse ($pendingInvitations as $invitation)
                        <div class="p-4 bg-white rounded-lg shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold">{{ $invitation->title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Invited by: {{ $invitation->user->name }} | 
                                        Invited on: {{ $invitation->pivot->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                  <div class="flex items-center space-x-2">
                                    <form action="{{ route('invitations.accept', $invitation) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                            Accept
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('invitations.decline', $invitation) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            @if($invitation->description)
                                <div class="mt-2">
                                    <p class="text-gray-700">{{ Str::limit($invitation->description, 100) }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 bg-white rounded-lg shadow-md text-center">
                            <p class="text-gray-500">No pending invitations found.</p>
                            <a href="{{ route('tasks.index') }}" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                View Your Tasks
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
