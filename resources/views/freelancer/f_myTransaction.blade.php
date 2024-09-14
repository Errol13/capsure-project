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
            <a class="nav-link" style="color:black;" href="#history" data-bs-toggle="tab">HISTORY</a>
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
                    <?php for ($i = 1; $i <= 2; $i++): ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                                        <span>Project <?= $i; ?></span>
                                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                    <div class="card-body">
                                        <?php for ($j = 1; $j <= 1; $j++): ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Client <?= $j; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ 1,500.00</div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="text-primary">Partially Paid</span>
                                                    <button class="btn btn-link pb-4" onclick="togglePaymentStatus()">
                                                        <i class="fas fa-repeat" style="color: black;"></i>
                                                    </button>
                                                </div>
                                                <div class="col-2 text-primary">Partially Paid</div>
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap;">
                                                        <i class="fas fa-receipt me-2"></i>View Receipt
                                                    </a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width" data-bs-toggle="modal" data-bs-target="#reviewFreelancerModal">Write a Review</button>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php for ($i = 1; $i <= 2; $i++): // Loop through each project 
            ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span>Project <?= $i; ?></span>
                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <?php for ($j = 1; $j <= 1; $j++): // Loop through each client
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2">
                                    <div>
                                        Client <?= $j; ?>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ 1,500.00</div>
                                <div class="mb-1"><strong>Confirmation:</strong> Partially Paid</div>
                                <div class="mb-1"><strong>Client's Confirmation:</strong> Partially Paid</div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2">
                                        <i class="fas fa-receipt me-2"></i>View Receipt
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width" data-bs-toggle="modal" data-bs-target="#reviewFreelancerModal">Write a Review</button>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
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
                    <?php for ($i = 1; $i <= 2; $i++): // Loop through each project 
                    ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="me-auto">
                                            <small>November <?= $i; ?>, 2024</small> 
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span>Project <?= $i; ?></span>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php for ($j = 1; $j <= 1; $j++): // Loop through each client
                                        ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Client <?= $j; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format(1500, 2); ?></div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="text-danger">Unpaid</span>
                                                    <button class="btn btn-link pb-4" onclick="togglePaymentStatus()">
                                                        <i class="fas fa-repeat" style="color: black;"></i>
                                                    </button>
                                                </div>
                                                <div class="col-2 text-danger">Unpaid</div>
                                                <div class="col-1 d-flex justify-content-center">
                                                <small class="text-muted">No receipt yet</small>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">Write a review</button>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php for ($i = 1; $i <= 2; $i++): // Loop for projects 
            ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span>Project <?= $i; ?></span> 
                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <?php for ($j = 1; $j <= 1; $j++): // Loop for client
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2"> 
                                    <div>
                                        Client <?= $j; ?> 
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format(1500, 2); ?></div> 
                                <div class="mb-1"><strong>Confirmation:</strong> Unpaid</div> 
                                <div class="mb-1"><strong>Client's Confirmation:</strong> Unpaid</div> 
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
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
                    <?php for ($i = 1; $i <= 2; $i++): // Loop for past projects 
                    ?>
                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="me-auto">
                                            <small>November <?= $i; ?>, 2024</small>
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span>Project <?= $i; ?></span> 
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php for ($j = 1; $j <= 1; $j++):
                                        ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Client <?= $j; ?></div> 
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format(1500, 2); ?></div> 
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="text-success">Fully Paid</span> 
                                                </div>
                                                <div class="col-2 text-success">Fully Paid</div> 
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">View Review</button>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php for ($i = 1; $i <= 2; $i++): // Loop for soon projects 
            ?>
                <div class="card mb-3 mt-3 d-block d-md-none">
                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                        <span>Project <?= $i; ?></span> 
                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <?php for ($j = 1; $j <= 1; $j++): // Loop for client
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2"> 
                                    <div>
                                        Client <?= $j; ?>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format(1500, 2); ?></div> 
                                <div class="mb-1"><strong>Confirmation:</strong> Fully Paid</div>
                                <div class="mb-1"><strong>Client's Confirmation:</strong> Fully Paid</div> 
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        @include('modals.f_review')
    </div>
</div>

@endsection