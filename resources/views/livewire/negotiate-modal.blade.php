<div class="modal fade" id="negotiateModal-{{$hiringRequestId}}" tabindex="-1" aria-labelledby="negotiateModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="updateOffer">
                @csrf
                @method('PATCH')

                <div class="modal-header poppins-medium" style="border-bottom: none;">
                    <h4 class="modal-title" id="negotiateModalLabel">Make an Offer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    @if(is_object($service) && $service->job_fee)
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Service: {{$service->job_title}}
                    </p>
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee: Php {{$service->job_fee}}
                    </p>
                    <p class="text-center mb-2 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee Type: {{$service->fee_type}}
                    </p>
                    @elseif(is_array($service))
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Service: {{ $service['package_service'] ?? 'N/A' }}
                    </p>
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee: Php {{ $service['package_price'] ?? 'N/A' }}
                    </p>
                    <p class="text-center mb-2 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee Type: /project
                    </p>
                    @else
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Service: {{$service->package_service ?? 'N/A'}}
                    </p>
                    <p class="text-center mb-1 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee: Php {{$service->package_price ?? 'N/A'}}
                    </p>
                    <p class="text-center mb-2 mt-0 text-muted poppins-regular" style="font-size: smaller;">
                        Fee Type: /project
                    </p>
                    @endif

                    <div class="d-flex table-responsive mt-1 mb-1 text-center">
                        <table class="table table-bordered offer-table" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    @if(auth()->user()->user_type == 'client' && is_object($service))
                                    <th style="width: 50%;">Freelancer's Offer</th>
                                    @elseif(auth()->user()->user_type == 'client' && is_array($service))
                                    <th style="width: 50%;">Team's Offer</th>
                                    @elseif(auth()->user()->user_type == 'freelancer')
                                    <th style="width: 50%;">Client's Offer</th>
                                    @endif
                                    <th style="width: 50%;">Your Offer</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if(auth()->user()->user_type == 'client')
                                    <td class="text-muted border border-secondary-subtle">₱{{ $hiringRequestData->freelancer_pricing }}</td>
                                    <td class="border border-secondary-subtle">
                                        <div class="input-group">
                                            <div class="d-flex align-items-center">
                                                <span class="ms-0 me-2 ">₱</span>
                                                <input type="text" class="form-control text-center ps-0 pe-0 border-secondary-subtle" wire:model.defer="clientPricing" id="offerInput" min="0">

                                            </div>
                                        </div>
                                    </td>
                                    @elseif(auth()->user()->user_type == 'freelancer')
                                    <td class="text-muted border border-secondary-subtle">₱{{ $hiringRequestData->client_pricing }}</td>
                                    <td class="border border-secondary-subtle">
                                        <div class="input-group">
                                            <div class="d-flex align-items-center">
                                                <span class="ms-0 me-2 ">₱</span>
                                                <input type="text" class="form-control text-center ps-0 pe-0 border-secondary-subtle"
                                                    wire:model.defer="freelancerPricing" wire:input="warningLowerOffer($event.target.value)" id="offerInput" min="0">
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Hidden input to store the hiring request ID -->
                    <input type="hidden" name="hiring_request_id" value="{{ $hiringRequestId }}">

                    <!--Hidden input to identify if its client or freelancer making the negotiation -->
                    <input type="hidden" name="dealer_user_type" value="{{ auth()->user()->user_type }}">

                    <!--A warning to show that the freelancer is making lower offer compared to client's offer -->

                    <div id="warningMessage{{$hiringRequestId}}" style="display: none;" class="text-danger mb-3 mt-0 fw-bold">Your offer is lower than the client's offer!</div>


                    <div class="d-flex justify-content-center mb-1">
                        <button type="submit" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Offer</button>
                        <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Listen for changes to the $isLower property
        window.addEventListener('showWarning', event => {
            var isLower = event.detail.isLower; // Access the detail from the event

            const warningMessage = document.getElementById('warningMessage<?php echo $hiringRequestId; ?>');

            if (isLower) {
                warningMessage.style.display = 'block'; // Show warning

            } else {
                warningMessage.style.display = 'none'; // Hide warning

            }
        });


        window.addEventListener('offerUpdated', () => {
            // Hide the modal using jQuery
            $('#negotiateModal-{{$hiringRequestId}}').modal('hide');

            // Reload the page
            window.location.reload();
        });
    });
</script>