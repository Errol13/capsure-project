<div class="modal" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content m-4" style="border-radius: 20px; padding: 20px;">
            <h4 class="text-center poppins-medium mb-3">Service Availability for Team</h4>

            <form method="POST" action="{{ route('service-edit') }}">
                @csrf
                <div class="modal-body">
                    @foreach(auth()->user()->freelancer->services as $service)
                        <div class="col p-2 mb-2 rounded-3 d-flex align-items-center justify-content-between" style="border:1px solid lightgray; margin: 0 auto;">
                            <span class="poppins-medium" style="color: black;">{{ $service->job_title }}</span>
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="service-{{ $service->id }}" 
                                    name="services[{{ $service->id }}]" 
                                    value="1" 
                                    {{ in_array($service->id, $member->offeredTeamServices()->pluck('id')->toArray()) ? 'checked' : '' }}>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    <button type="submit" class="confirm me-2 w-50">Save</button>
                    <button type="button" class="confirm w-50" style="background-color:lightgrey; color:black;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
