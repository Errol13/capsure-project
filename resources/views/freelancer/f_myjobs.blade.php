@extends('layouts.app')

@section('content')
<div class="container py-4 my-2">
    <livewire:freelancer.my-jobs />
</div>
<!-- CSS for responsive adjustments -->
<style>
    @media (max-width: 576px) {
        .nav-link {
            font-size: 0.75rem;
            /* Reduce font size on extra-small screens */
            padding: 0.5rem 0.2rem;
            /* Adjust padding for smaller look */
        }

        .badge {
            font-size: 0.6rem;
            /* Scale down badge font */
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
        .nav-link {
            font-size: 0.85rem;
            /* Slightly larger font size on small screens */
            padding: 0.6rem 0.3rem;
        }

        .badge {
            font-size: 0.7rem;
        }
    }
</style>

@endsection