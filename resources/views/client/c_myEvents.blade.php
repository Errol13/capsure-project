@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <h3>My Posts</h3>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary ms-2">+</button>
                </div>
                <div class="col ms-auto text-end">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/freelancer-profile">Profile</a>
                        <a class="dropdown-item" href="#">Setting</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>


            <!-- Desktop View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table mt-3">
                    <thead class="table-danger text-center">
                        <tr>
                            <th></th>
                            <th>Status</th>
                            <th>Pending application</th>
                            <th>Hiring request</th>
                            <th>Hired</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Repeat this block for each post -->
                        <tr>
                            <td>
                                <small>Created 1 min ago</small>
                                <br>
                                <strong>18th Birthday Celebration</strong>
                                <br>
                                <small>Budget: ₱10,000 - ₱20,000</small>
                            </td>
                            <td class="text-success text-center">OPEN</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td>
                                <a href="#" class="btn btn-link" style="white-space: nowrap;">VIEW POST</a><br>
                                <a href="#" class="btn btn-link text-danger ms-3">CANCEL</a>
                            </td>
                        </tr>
                        <!-- Repeat ends here -->
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="d-block d-md-none mt-3">
                <!-- Repeat this block for each post -->
                <div class="card mb-3">
                    <div class="card-body">
                        <small>Created 1 min ago</small>
                        <h5 class="card-title">18th Birthday Celebration</h5>
                        <p class="card-text">Budget: ₱10,000 - ₱20,000</p>
                        <span class="badge bg-success">OPEN</span>
                        <p class="mt-2 mb-0">Pending application: 0</p>
                        <p class="mb-0">Hiring request: 0</p>
                        <p class="mb-2">Hired: 0</p>
                        <a href="#" class="btn btn-primary">VIEW POST</a>
                        <a href="#" class="btn btn-danger">CANCEL</a>
                    </div>
                </div>
                <!-- Repeat ends here -->
            </div>
        </div>
    </div>
</div>
@endsection