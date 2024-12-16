@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">

        <livewire:Freelancer.searchbar /> 

        <div class="row mx-0 mt-4">
            <h3 class="poppins-medium fs-3 text-start">Jobs For You</h3>
        </div>
        
        <livewire:Freelancer.freelancer-home />

    </div>
</div>


@endsection('content')