<div wire:poll>
    <input 
        type="text" 
        wire:model.debounce.300ms="search" 
        placeholder="Search chats..." 
        class="form-control mb-3 mt-3"
    />

    @if($chatUsers->isNotEmpty())
    <div class="list-group">
        <h5 class="p-3">Chats</h5>
        @foreach($chatUsers as $user)
        <button
            wire:click="selectUser({{ $user->id }})" 
            class="list-group-item list-group-item-action @if(session('selectedUserId') == $user->id) active @endif">
            {{ $user->first_name }} {{ $user->last_name }}
        </button>
        @endforeach
    </div>
    @else
    <p>No messages.</p>
    @endif
</div>
