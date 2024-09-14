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
                        <th style="width: 13%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 13%;">Confirmation</th>
                        <th style="width: 18%;">Freelancer's Confirmation</th>
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
                                        <?php for ($j = 1; $j <= 3; $j++): ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Freelancer <?= $j; ?></div>
                                                        <small class="text-muted">Developer</small>
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
                                                    <a href="#" class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap; border-bottom-right-radius: 0px; border-top-right-radius: 0px; ">
                                                        <i class="fas fa-receipt me-2"></i>View Receipt
                                                    </a>
                                                    <span class="upload-icon" style="background-color:#E1C1D7; padding: 0.2rem 0.5rem; border-bottom-right-radius: 4px;border-top-right-radius: 4px;">
                                                        <i class="fas fa-upload" style="color: #000;"></i>
                                                    </span>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width" data-bs-toggle="modal" data-bs-target="#reviewClientModal">Write a Review</button>
                                                </div>
                                            </div>
                                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
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
                        <?php for ($j = 1; $j <= 3; $j++): // Loop through each freelancer 
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2">
                                    <div>
                                        Freelancer <?= $j; ?>
                                        <small class="text-muted d-block">Developer</small>
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ 1,500.00</div>
                                <div class="mb-1"><strong>Confirmation:</strong> Partially Paid</div>
                                <div class="mb-1"><strong>Freelancer's Confirmation:</strong> Partially Paid</div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2">
                                        <i class="fas fa-receipt me-2"></i>View Receipt
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width" data-bs-toggle="modal" data-bs-target="#reviewClientModal">Write a Review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
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
                        <th style="width: 13%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 13%;">Confirmation</th>
                        <th style="width: 18%;">Freelancer's Confirmation</th>
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
                                            <small>November <?= $i; ?>, 2024</small> <!-- Dynamic date example -->
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span>Project <?= $i; ?></span>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php for ($j = 1; $j <= 3; $j++): // Loop through each freelancer 
                                        ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle">
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Freelancer <?= $j; ?></div>
                                                        <small class="text-muted">Developer</small>
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
                                                    <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;">
                                                        <i class="fas fa-upload me-2"></i>Upload Receipt
                                                    </a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">Write a review</button>
                                                </div>
                                            </div>
                                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
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
                        <span>Project <?= $i; ?></span> <!-- Project title with dynamic content -->
                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <?php for ($j = 1; $j <= 3; $j++): // Loop for freelancers 
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2"> <!-- Static profile image -->
                                    <div>
                                        Freelancer <?= $j; ?> <!-- Freelancer name with dynamic content -->
                                        <small class="text-muted d-block">Developer</small> <!-- Static profession -->
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format(1500, 2); ?></div> <!-- Static payment fee -->
                                <div class="mb-1"><strong>Confirmation:</strong> Unpaid</div> <!-- Static confirmation status -->
                                <div class="mb-1"><strong>Freelancer's Confirmation:</strong> Unpaid</div> <!-- Static freelancer confirmation -->
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
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
                        <th style="width: 13%;"></th>
                        <th style="width: 15%;">Payment Fee</th>
                        <th style="width: 13%;">Confirmation</th>
                        <th style="width: 18%;">Freelancer's Confirmation</th>
                        <th style="width: 12%; white-space:nowrap;">Payment Proof</th>
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
                                            <small>November <?= $i; ?>, 2024</small> <!-- Dynamic project date -->
                                        </div>
                                        <div class="flex-grow-1 text-center poppins-medium">
                                            <span>Project <?= $i; ?></span> <!-- Dynamic project title -->
                                        </div>
                                        <div class="ms-auto">
                                            <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php for ($j = 1; $j <= 3; $j++): // Loop for freelancers 
                                        ?>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-auto pe-1">
                                                    <img src="assets/profilepic.svg" class="rounded-circle"> <!-- Static profile image -->
                                                </div>
                                                <div class="col-2 pe-4">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div>Freelancer <?= $j; ?></div> <!-- Dynamic freelancer name -->
                                                        <small class="text-muted">Developer</small> <!-- Static profession -->
                                                    </div>
                                                </div>
                                                <div class="col-2 text-left">₱ <?= number_format(1500, 2); ?></div> <!-- Static payment fee -->
                                                <div class="col-2 d-flex align-items-center">
                                                    <span class="text-success">Fully Paid</span> <!-- Static confirmation status -->
                                                </div>
                                                <div class="col-2 text-success">Fully Paid</div> <!-- Static freelancer confirmation -->
                                                <div class="col-1 d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <button class="btn btn-outline-secondary btn-sm btn-fit-width">View Review</button>
                                                </div>
                                            </div>
                                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
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
                        <span>Project <?= $i; ?></span> <!-- Dynamic project title -->
                        <a href="<?= url('/client-viewpost', ['id' => $i]); ?>" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                    </div>
                    <div class="card-body">
                        <?php for ($j = 1; $j <= 3; $j++): // Loop for freelancers 
                        ?>
                            <div class="d-flex flex-column align-items-start mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/profilepic.svg" class="rounded-circle me-2"> <!-- Static profile image -->
                                    <div>
                                        Freelancer <?= $j; ?> <!-- Dynamic freelancer name -->
                                        <small class="text-muted d-block">Developer</small> <!-- Static profession -->
                                    </div>
                                </div>
                                <div class="mb-1"><strong>Payment Fee:</strong> ₱ <?= number_format(1500, 2); ?></div> <!-- Static payment fee -->
                                <div class="mb-1"><strong>Confirmation:</strong> Fully Paid</div> <!-- Static confirmation -->
                                <div class="mb-1"><strong>Freelancer's Confirmation:</strong> Fully Paid</div> <!-- Static freelancer confirmation -->
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                    <button class="btn btn-outline-secondary btn-sm">Write a review</button>
                                </div>
                            </div>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Review Modal -->
        @include('modals.c_review')
    </div>
</div>

@endsection