<div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Invite Team Members</h3>
        
        <form wire:submit="inviteUser" class="mb-6">
            <div class="flex items-center space-x-2">
                <div class="flex-1">
                    <input 
                        type="email" 
                        wire:model="email" 
                        placeholder="Enter email address" 
                        class="w-full px-4 py-2 border rounded"
                    >
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Invite
                </button>
            </div>
        </form>
        
        <div class="mb-6">
            <h4 class="text-md font-bold mb-2">Current Members</h4>
            
            @if(count($members) > 0)
                <ul class="divide-y">
                    @foreach($members as $member)
                        <li class="py-2 flex items-center justify-between">
                            <div>
                                <span class="font-medium">{{ $member['name'] }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $member['email'] }}</span>
                                <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                    {{ $member['pivot']['role'] === 'owner' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($member['pivot']['role']) }}
                                </span>
                            </div>
                            
                            @if($member['id'] !== auth()->id())
                                <div class="flex items-center space-x-2">
                                    <select 
                                        wire:change="changeRole({{ $member['id'] }}, $event.target.value)" 
                                        class="text-sm border rounded px-2 py-1"
                                    >
                                        <option value="member" {{ $member['pivot']['role'] === 'member' ? 'selected' : '' }}>Member</option>
                                        <option value="owner" {{ $member['pivot']['role'] === 'owner' ? 'selected' : '' }}>Owner</option>
                                    </select>
                                    
                                    <button wire:click="removeInvitation({{ $member['id'] }})" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No members yet.</p>
            @endif
        </div>
        
        @if(count($pendingInvitations) > 0)
            <div>
                <h4 class="text-md font-bold mb-2">Pending Invitations</h4>
                
                <ul class="divide-y">
                    @foreach($pendingInvitations as $invitation)
                        <li class="py-2 flex items-center justify-between">
                            <div>
                                <span class="font-medium">{{ $invitation['name'] }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $invitation['email'] }}</span>
                                <span class="ml-2 px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </div>
                            
                            <button wire:click="removeInvitation({{ $invitation['id'] }})" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
