<div>
    <li class="nav-item dropdown mx-1 ms-md-2">
        <a class="nav-link dropdown-toggle-notif" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            @if($notifications->count() > 0)
                <span class="badge bg-danger">{{ $notifications->count() }}</span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px;">
            <li>
                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                    <span class="fw-bold">Notifications</span>
                    <a href="#" class="text-decoration-none" wire:click.prevent="markAllAsRead">Mark all as Read</a>
                </div>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            @forelse($notifications->take(4) as $notification) <!-- Show only the latest 4 notifications -->
                <li>
                    <a class="dropdown-item" href="{{ $notification->data['url'] }}">
                        <strong class="text-wrap">{{ $notification->data['message'] }}</strong>
                        <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </a>
                </li>
            @empty
                <li>
                    <p class="dropdown-item">No new notifications</p>
                </li>
            @endforelse

            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item text-center" href="#">See All</a>
            </li>
        </ul>
    </li>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationDropdown = document.getElementById('notificationDropdown');

            notificationDropdown.addEventListener('shown.bs.dropdown', function () {
                Livewire.emit('refreshNotifications');
            });
        });
    </script>
</div>
