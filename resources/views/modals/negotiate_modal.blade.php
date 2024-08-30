<!-- Negotiate Modal-->
<div class="modal" id="negotiateModal" tabindex="-1" aria-labelledby="negotiateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header poppins-medium" style="border-bottom: none;">
                <h4 class="modal-title" id="negotiateModalLabel">Make an Offer</h5>
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
                            <td>₱600 per hour</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control text-center" style="border:none;" value="₱500 per hour" id="offerInput" readonly>
                                    <button class="btn" type="button" id="editButton" style="border:none;">
                                        <i class="bi bi-pencil"></i> <!-- Bootstrap Pencil Icon -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-1">
                <button type="button" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Offer</button>
                <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>