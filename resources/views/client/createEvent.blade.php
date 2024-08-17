@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-9 col-lg-7">
            <div class="card p-4 shadow-sm rounded-4">

                <!-- Title and Post Button -->
                <div class="d-flex justify-content-between mb-3 open-sans-reg">
                    <h3 class="event-title">Create an Event</h3>
                    <div>
                        <a href="{{ url('/client-homepage') }}">
                            <button class="btn-outline open-sans-reg me-2">Cancel</button>
                        </a>
                        <button class="btn-link open-sans-reg" style="text-decoration: none;">Post</button>
                    </div>
                </div>

                <!-- Title -->
                <div class="form-group mb-3 open-sans-reg">
                    <input type="text" class="form-control" placeholder="Title">
                </div>

                <!-- Description -->
                <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                    <label>Description:</label>
                    <textarea class="form-control" rows="3" maxlength="500" placeholder="Description"></textarea>
                    <small class="text-muted">0/500</small>
                </div>

                <!-- Location -->
                <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                    <label>Location:</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="St.">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Brgy.">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="City">
                        </div>
                    </div>
                </div>

                <!-- Time -->
                <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                    <div class="row">
                        <div class="col-5">
                            <div>Start Date & Time:</div>
                            <input type="datetime-local" class="form-control" placeholder="Start Date & Time">
                        </div>
                        <div class=" px-4 col-1 pt-4">-</div>
                        <div class="col-5">
                            <div>End Date & Time:</div>
                            <input type="datetime-local" class="form-control" placeholder="End Date & Time">
                        </div>
                    </div>
                </div>

                <!-- Budget and Payment Method -->
                <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                    <div class="row">
                        <div class="col-8">
                            <label>Budget:</label>
                        </div>
                        <div class="col-3" style="white-space: nowrap; font-size:small;">
                            <label>Payment Method:</label>
                        </div>
                        <div class="col-4">
                            <input type="number" class="form-control" placeholder="Min ₱">
                        </div>
                        <div class="col-4">
                            <input type="number" class="form-control" placeholder="Max ₱">
                        </div>
                        <div class="col-4">
                            <select class="form-control">
                                <option value="">Select</option>
                                <option value="Cash">Cash</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Add Jobs -->
                <div class="form-group mb-3 open-sans-reg">
                    <h4>Add Job/s</h4>
                    <div class="row align-items-center" style="color:#91216C;">
                        <div class="col-5">
                            <label>Service:</label>
                        </div>
                        <div class="col-5">
                            <label>Category:</label>
                        </div>
                        <div class="col-2" style="font-size: smaller;">
                            <label>Quantity:</label>
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control" placeholder="Eg. Photographer">
                        </div>
                        <div class="col-5 ">
                            <select class="form-control">
                                <option value="">Select Category</option>
                                <option value="Category 1">Handicrafts</option>
                                <option value="Category 2">Art</option>
                                <option value="Category 3">Entertainment</option>
                                <option value="Category 4">Photography</option>
                                <option value="Category 5">Voice Talent</option>
                                <option value="Category 6">Stylist</option>
                                <option value="Category 7">Food Service</option>
                                <option value="Category 8">Event Planner</option>
                                <option value="Category 9">Online Services</option>
                                <option value="Category 10">Videography</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" placeholder="0" min="0">
                        </div>
                        <div class="col-12 col-sm-1 d-flex mt-2 mt-sm-0">
                            <button class="btn open-sans-reg mt-2" style="background-color: #8FE2ED; color:black; border:none; font-size:smaller;">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection