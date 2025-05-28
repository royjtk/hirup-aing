<div class="space-y-4">
    <div class="border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-900">Comments</h3>
    </div>

    {{-- Comment List --}}
    <div class="space-y-4">
        @foreach($comments as $comment)
            <div class="flex space-x-3 bg-white p-4 rounded-lg shadow-sm">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500 font-medium">
                            {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="flex-grow">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        @if(Auth::user()->id === $comment->user_id || Auth::user()->id === $task->user_id)
                            <button 
                                wire:click="deleteComment({{ $comment->id }})"
                                class="text-red-600 hover:text-red-800"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- New Comment Form --}}
    <div class="mt-6">
        <form wire:submit="addComment" class="space-y-3">
            <div>
                <label for="comment" class="sr-only">Add a comment</label>
                <textarea
                    id="comment"
                    wire:model="newComment"
                    rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Add a comment..."
                ></textarea>
                @error('newComment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Post Comment
                </button>
            </div>
        </form>
    </div>
</div>
