<!-- Negotiate Modal-->
<div class="modal" id="negotiateModal-{{$hiringId}}" tabindex="-1" aria-labelledby="negotiateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('freelancer.negotiate') }}" method="POST">
                @csrf
                @method('PATCH') 

                <div class="modal-header poppins-medium" style="border-bottom: none;">
                    <h4 class="modal-title" id="negotiateModalLabel">Make an Offer</h4>
                </div>
                <div class="d-flex table-responsive mt-1 mb-2 text-center">
                    <table class="table table-bordered offer-table" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Freelancer's Offer</th>
                                <th style="width: 50%;">Your Offer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>₱{{$hiringRequestData->freelancer_pricing}} <span> {{$fee_type}}</span></td>
                                <td>
                                    <div class="input-group">
                                        <div class="d-flex align-items-center">
                                            <input type="text" class="form-control text-center" style="border:none;" value="₱{{$hiringRequestData->freelancer_pricing}}" id="offerInput" name="client_pricing" readonly>
                                            <span> {{$fee_type}}</span>
                                            <button class="btn" type="button" id="editButton" style="border:none;">
                                                <i class="bi bi-pencil"></i> 
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Hidden input to store the hiring request ID -->
                <input type="hidden" name="hiring_request_id" value="{{$hiringRequestData->hiring_request_id}}">

                <div class="d-flex justify-content-center mb-1">
                    <button type="submit" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Offer</button>
                    <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Make the "Your Offer" input field editable when the pencil icon is clicked
    document.getElementById('editButton').addEventListener('click', function() {
        var offerInput = document.getElementById('offerInput');

        // If the input is currently read-only, make it editable
        if (offerInput.hasAttribute('readonly')) {
            offerInput.removeAttribute('readonly');
            offerInput.style.border = '1px solid #ced4da'; // Add border to indicate it's editable
        } else {
            offerInput.setAttribute('readonly', true); // Toggle back to read-only
            offerInput.style.border = 'none'; // Remove border when read-only
        }
    });
</script>