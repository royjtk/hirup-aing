<div>
    <form wire:submit="saveTask" class="space-y-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input 
                type="text" 
                id="title" 
                wire:model="title" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Task title"
            >
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea 
                id="description" 
                wire:model="description" 
                rows="4" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Task description (optional)"
            ></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select 
                id="status" 
                wire:model="status" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
                <option value="todo">To Do</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input 
                type="date" 
                id="dueDate" 
                wire:model="dueDate" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
            @error('dueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex items-center justify-between">
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ $mode === 'create' ? 'Create Task' : 'Update Task' }}
            </button>
        </div>
    </form>
</div>
