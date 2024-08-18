@extends('layouts.app')

@section('content')
<div class="container py-4 my-2">
    <div class="row">
        <div class="col-12">
            <div class="row d-flex align-items-center">
                <div class="col-auto pt-3">
                    <h2>My Posts</h2>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" style="background-color:#8FE2ED; border:none; color:black;">+</button>
                </div>
                <div class="col ms-auto text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" style="background-color: white; border-radius:12px; color:black; border-color:lightgray;" type="button" id="filterToggleButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mb-1" style="background-color: white;" aria-labelledby="filterToggleButton">
                            <li><a class="dropdown-item" href="#">Open</a></li>
                            <li><a class="dropdown-item" href="#">Closed</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <?php
            // Example array of posts
            $posts = [
                [
                    'created' => '1 min ago',
                    'title' => '18th Birthday Celebration',
                    'budget' => '₱10,000 - ₱20,000',
                    'status' => 'OPEN',
                    'pending' => 0,
                    'request' => 0,
                    'hired' => 0
                ],
                [
                    'created' => '1 min ago',
                    'title' => '18th Birthday Celebration',
                    'budget' => '₱10,000 - ₱20,000',
                    'status' => 'OPEN',
                    'pending' => 0,
                    'request' => 0,
                    'hired' => 0
                ],
                [
                    'created' => '1 min ago',
                    'title' => '18th Birthday Celebration',
                    'budget' => '₱10,000 - ₱20,000',
                    'status' => 'OPEN',
                    'pending' => 0,
                    'request' => 0,
                    'hired' => 0
                ],
                // Add more posts as needed
            ];
            ?>

            <!-- Larger Screens -->
            <div class="table-responsive d-none d-md-block">
                <table class="table mt-3">
                    <thead class="table-primary text-center poppins-extralight">
                        <tr>
                            <th></th>
                            <th>Status</th>
                            <th>Pending application</th>
                            <th>Hiring request</th>
                            <th>Hired</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <small>Created <?php echo $post['created']; ?></small><br>
                                    <strong class="poppins-medium"><?php echo $post['title']; ?></strong><br>
                                    <small>Budget: <?php echo $post['budget']; ?></small>
                                </td>
                                <td class="text-success fw-bold"><?php echo $post['status']; ?></td>
                                <td><?php echo $post['pending']; ?></td>
                                <td><?php echo $post['request']; ?></td>
                                <td><?php echo $post['hired']; ?></td>
                                <td>
                                    <a href="{{ url('/client-viewpost') }}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a><br>
                                    <a href="#" class="btn btn-link text-danger" style="text-decoration:none;">Cancel</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Small Screens -->
            <div class="d-block d-md-none mt-3">
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-3" style="border-radius: 20px;background-color:white;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-body">                            
                            <span class="badge bg-success me-2 mb-3"><?php echo $post['status']; ?></span>
                            <small>Created <?php echo $post['created']; ?></small>
                            <h5 class="card-title poppins-medium"><?php echo $post['title']; ?></h5>
                            <p class="card-text">Budget: <?php echo $post['budget']; ?></p>
                            <hr>
                            <p class="mt-2 mb-0">Pending application: <?php echo $post['pending']; ?></p>
                            <p class="mb-0">Hiring request: <?php echo $post['request']; ?></p>
                            <p class="mb-2">Hired: <?php echo $post['hired']; ?></p>
                            <a href="{{ url('/client-viewpost') }}" class="btn btn-primary" style="background-color: #91216C; color:white; border:none; border-radius: 12px;">View Post</a>
                            <a href="#" class="btn btn-danger ms-2" style="border:none; border-radius: 12px;">Cancel</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>
@endsection