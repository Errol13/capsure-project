@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" style="color:black;" href="#ongoing" data-bs-toggle="tab">ON-GOING</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:black;" href="#upcoming" data-bs-toggle="tab">UPCOMING</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:black;" href="#history" data-bs-toggle="tab">HiSTORY</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">

        <!-- ON-GOING Tab ------------------------------------------------------------------------------------------------------------------------------>
        <div class="tab-pane show active" id="ongoing">
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Client's Confirmation</th>
                        <th style="width: 14%;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currprojects = [
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'confirmation_status' => 'Partially Paid',
                                    'client_confirmation' => 'Partially Paid'
                                ],
                            ]
                        ],
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'confirmation_status' => 'Partially Paid',
                                    'client_confirmation' => 'Partially Paid'
                                ],

                            ]
                        ],
                    ]
                    ?>

                    <?php foreach ($currprojects as $currproject): ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                                        <span><?= $currproject['title']; ?></span>
                                        <a href="<?= url('/client-viewpost', ['id' => $currproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                    <div class="card-body">
                                        <!-- Loop through each client -->
                                        <?php foreach ($currproject['client'] as $client): ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div><?= $client['name']; ?></div>
                                                        <small class="text-muted"><?= $client['profession']; ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="<?= $client['confirmation_status'] == 'Partially Paid' ? 'text-primary' : 'text-success'; ?>">
                                                        <?= $client['confirmation_status']; ?>
                                                    </span>
                                                    <button class="btn btn-link pb-4" onclick="togglePaymentStatus()">
                                                        <i class="fas fa-repeat" style="color: black;"></i>
                                                    </button>
                                                </div>
                                                <div class="col-2 text-primary"><?= $client['client_confirmation']; ?></div>
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap; border-bottom-right-radius: 0px; border-top-right-radius: 0px; ">
                                                        <i class="fas fa-receipt me-2"></i>View Receipt
                                                    </a>
                                                    <span class="upload-icon" style="background-color:#E1C1D7; padding: 0.2rem 0.5rem; border-bottom-right-radius: 4px;border-top-right-radius: 4px;">
                                                        <i class="fas fa-upload" style="color: #000;"></i>
                                                    </span>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">Write a review</button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Card style on smaller screens -->
            <?php foreach ($currprojects as $currproject): ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span><?= $currproject['title']; ?></span>
                        <a href="<?= url('/client-viewpost', ['id' => $currproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <!-- Loop through each freelancer -->
                        <?php foreach ($currproject['client'] as $client): ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle me-2">
                                    <div>
                                        <?= $client['name']; ?>
                                        <small class="text-muted d-block"><?= $client['profession']; ?></small>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                <div class="mb-1"><strong>Confirmation:</strong> <?= $client['confirmation_status']; ?></div>
                                <div class="mb-1"><strong>Client's Confirmation:</strong> <?= $client['client_confirmation']; ?></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- UPCOMING Tab --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="upcoming">
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Client's Confirmation</th>
                        <th style="width: 14%;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $soonprojects = [
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'date' => 'November 1, 2024',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'confirmation_status' => 'Unpaid',
                                    'client_confirmation' => 'Unpaid'
                                ],
                            ]
                        ],
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'date' => 'November 1, 2024',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'confirmation_status' => 'Unpaid',
                                    'client_confirmation' => 'Unpaid'
                                ],
                            ]
                        ],
                    ]
                    ?>

                    <?php foreach ($soonprojects as $soonproject): ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="me-auto">
                                            <small><?= $soonproject['date']; ?></small>
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span><?= $soonproject['title']; ?></span>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $soonproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Loop through each freelancer -->
                                        <?php foreach ($soonproject['client'] as $client): ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div><?= $client['name']; ?></div>
                                                        <small class="text-muted"><?= $client['profession']; ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="<?= $client['confirmation_status'] == 'Unpaid' ? 'text-danger' : 'text-success'; ?>">
                                                        <?= $client['confirmation_status']; ?>
                                                    </span>
                                                    <button class="btn btn-link pb-4" onclick="togglePaymentStatus()">
                                                        <i class="fas fa-repeat" style="color: black;"></i>
                                                    </button>
                                                </div>
                                                <div class="col-2 text-danger"><?= $client['client_confirmation']; ?></div>
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;"><i class="fas fa-upload me-2"></i>Upload Receipt</a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">Write a review</button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Card style on smaller screens -->
            <?php foreach ($soonprojects as $soonproject): ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span><?= $soonproject['title']; ?></span>
                        <a href="<?= url('/client-viewpost', ['id' => $soonproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <!-- Loop through each client -->
                        <?php foreach ($soonproject['client'] as $client): ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle me-2">
                                    <div>
                                        <?= $client['name']; ?>
                                        <small class="text-muted d-block"><?= $client['profession']; ?></small>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                <div class="mb-1"><strong>Confirmation:</strong> <?= $client['confirmation_status']; ?></div>
                                <div class="mb-1"><strong>Client's Confirmation:</strong> <?= $client['client_confirmation']; ?></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- HISTORY Tab ----------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="history">
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Client's Confirmation</th>
                        <th style="width: 14%;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pastprojects = [
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'date' => 'November 1, 2024',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'confirmation_status' => 'Fully Paid',
                                    'client_confirmation' => 'Fully Paid'
                                ],
                            ]
                        ],
                        [
                            'id' => 1,
                            'title' => 'Project 1',
                            'date' => 'November 1, 2024',
                            'client' => [
                                [
                                    'profile_image' => 'assets/profilepic.svg',
                                    'name' => 'Freelancer 1',
                                    'profession' => 'Developer',
                                    'payment_fee' => 1500,
                                    'Fully Paid',
                                    'confirmation_status' => 'Fully Paid',
                                    'client_confirmation' => 'Fully Paid'
                                ],
                            ]
                        ],
                    ]
                    ?>

                    <?php foreach ($pastprojects as $pastproject): ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="me-auto">
                                            <small><?= $pastproject['date']; ?></small>
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span><?= $pastproject['title']; ?></span>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $pastproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Loop through each client -->
                                        <?php foreach ($pastproject['client'] as $client): ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div><?= $client['name']; ?></div>
                                                        <small class="text-muted"><?= $client['profession']; ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="<?= $client['confirmation_status'] == 'Fully Paid' ? 'text-success' : 'text-warning'; ?>">
                                                        <?= $client['confirmation_status']; ?>
                                                    </span>
                                                </div>
                                                <div class="col-2 text-success"><?= $client['client_confirmation']; ?></div>
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">View Review</button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Card style on smaller screens -->
            <?php foreach ($soonprojects as $soonproject): ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span><?= $soonproject['title']; ?></span>
                        <a href="<?= url('/client-viewpost', ['id' => $soonproject['id']]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <!-- Loop through each client -->
                        <?php foreach ($soonproject['client'] as $client): ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="<?= $client['profile_image']; ?>" class="rounded-circle me-2">
                                    <div>
                                        <?= $client['name']; ?>
                                        <small class="text-muted d-block"><?= $client['profession']; ?></small>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format($client['payment_fee'], 2); ?></div>
                                <div class="mb-1"><strong>Confirmation:</strong> <?= $client['confirmation_status']; ?></div>
                                <div class="mb-1"><strong>Client's Confirmation:</strong> <?= $client['client_confirmation']; ?></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

@endsection