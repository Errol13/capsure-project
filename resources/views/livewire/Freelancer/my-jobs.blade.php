<div wire:poll.10s>
    <div class="ms-4 mt-5 mb-4">
        <h3 class="ms-5 mt-3 poppins-medium">My Jobs</h3>
    </div>


    <div class="container ms-5 me-1">
        <!-- Navigations -->
        <!-- Navigations -->
        <ul class="nav border-bottom-0 d-flex justify-content-between pt-2 poppins-medium fixed-tabs mb-3" style="background-color: #FCF2F9;">
            <li class="nav-item flex-fill text-start me-2">
                <a wire:click="$set('activeTab', 'application')" class="nav-link {{ $activeTab === 'application' ? 'active' : '' }} tabs-bg-color rounded-top letter-spacing d-flex justify-content-between align-items-center" data-bs-toggle="tab" href="#application" aria-controls="application" aria-selected="true">
                    APPLICATION <span class="badge text-black" style="background-color: #E1C1D7;">{{$appliedJobsCount}}</span>
                </a>
            </li>
            <li class="nav-item flex-fill text-center me-2">
                <a wire:click="$set('activeTab', 'hiring-request')" class="nav-link {{ $activeTab === 'hiring-request' ? 'active' : '' }} tabs-bg-color rounded-top letter-spacing d-flex justify-content-between align-items-center" data-bs-toggle="tab" href="#hiring-request" aria-controls="hiring-request" aria-selected="false">
                    HIRING REQUEST <span class="badge text-black" style="background-color: #E1C1D7;">{{$hiringRequestsCount}}</span>
                </a>
            </li>
            <li class="nav-item flex-fill text-center">
                <a wire:click="$set('activeTab', 'recommendation')" class="nav-link {{ $activeTab === 'recommendation' ? 'active' : '' }} tabs-bg-color rounded-top letter-spacing d-flex justify-content-between align-items-center" data-bs-toggle="tab" href="#recommendation" aria-controls="recommendation" aria-selected="false">
                    RECOMMENDATION <span class="badge text-black" style="background-color: #E1C1D7;">{{$recommendationsCount}}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Application Content -->
            <div class="tab-pane fade {{ $activeTab === 'application' ? 'show active' : '' }}" id="application" aria-labelledby="application-tab">
                <table class="table table-striped">
                    <thead class="text-center mb-2">
                        <tr>
                            <th style="background-color: #FCF2F9;">Job</th>
                            <th style="background-color: #FCF2F9;">Applied as</th>
                            <th style="background-color: #FCF2F9;">Availability</th>
                            <th style="background-color: #FCF2F9;">Status</th>
                            <th style="background-color: #FCF2F9;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Jobs Applied -->
                        <tr>
                            @foreach($appliedJobs as $job)
                            <td class="open-sans-reg">
                                <strong>{{ $job->event->title }}</strong><br>
                                <span class="me-2" style="color: #91216C;">DATE & TIME:</span> <span>{{ $job->event->start_date_formatted }} - {{ $job->event->end_date_formatted }}</span><br>
                                <span class="me-2" style="color: #91216C;">LOCATION:</span> <span>{{ $job->event->street }}, {{ $job->event->barangay }}, {{ $job->event->city }}</span><br>
                                <span class="me-2" style="color: #91216C;">BUDGET:</span> <span>₱{{ $job->event->budget_min }} - ₱{{ $job->event->budget_max }}</span>
                            </td>
                            <td>{{$job->service_needed}}</td>

                            <!--Availability of event-->
                            <td>
                                <span class="{{ $job->event->status == 'Open' ? 'text-success' : 'text-danger' }} text-uppercase fw-bold">
                                    {{ $job->event->status }}
                                </span>
                            </td>

                            <td>
                                <span class="{{ $job->pivot->status == 'Pending' ? 'pending-color' : 
                                ($job->pivot->status == 'Accepted' ? 'text-success' : 'text-danger')}} text-uppercase fw-bold">
                                    {{ $job->pivot->status }}
                                </span>
                            </td>


                            <td>
                                <a href="{{ route('client-viewpost', ['id' => $job->event->event_id]) }}" class="btn btn-link pt-0" style="white-space: nowrap; color: #91216C; text-decoration: none; display: block;">View Post</a>
                                <a href="#" class="btn btn-link pt-0 text-danger" style="text-decoration: none; display: block;">Cancel</a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Hiring Request Content -->
            <div class="tab-pane fade {{ $activeTab === 'hiring-request' ? 'show active' : '' }}" id="hiring-request" aria-labelledby="hiring-request-tab">
                <!-- Content for Hiring Requests -->


            </div>

            <!-- Recommendation Content -->
            <div class="tab-pane fade {{ $activeTab === 'recommendation' ? 'show active' : '' }}" id="recommendation" aria-labelledby="recommendation-tab">
                <!-- Content for Recommendations -->
                <table class="table table-striped">
                    <thead class="text-center mb-2">
                        <tr>
                            <th style="background-color: #FCF2F9;">Event</th>
                            <th style="background-color: #FCF2F9;">Services Required</th>
                            <th style="background-color: #FCF2F9;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Jobs Recommendations -->
                        <tr>
                            @foreach($eventRecommendations as $event)
                            <td class="open-sans-reg">
                                <strong>{{ $event->title }}</strong><br>
                                <span class="me-2" style="color: #91216C;">DATE & TIME:</span> <span>{{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</span><br>
                                <span class="me-2" style="color: #91216C;">LOCATION:</span> <span>{{ $event->street }}, {{ $event->barangay }}, {{ $event->city }}</span><br>
                                <span class="me-2" style="color: #91216C;">BUDGET:</span> <span>₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</span>
                            </td>

                            <!--Needed Services -->
                            <td>
                                @foreach($event->event_jobs as $job)
                                <span class="me-2 rounded-3 border border-secondary-subtle bg-primary-subtle p-2">{{$job->service_needed}}</span>
                                @endforeach
                            </td>

        
                            <td class="open-sans-reg ">
                                <a href="#" class="btn-verify rounded-2 pt-0 mb-1" style="white-space: nowrap; text-decoration: none; display: block;">Apply</a>
                                <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-link pt-0 me-2" style=" white-space: nowrap; color: #91216C;">View Post</a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>