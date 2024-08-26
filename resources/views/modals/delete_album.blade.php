<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for delete confirmation -->
                    <form id="deleteForm" method="POST" action="{{ route('delete-album') }}">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label for="albumSelect" class="form-label">Select Album to Delete</label>
                            <select class="form-select" id="albumSelect" name="album_id">
                                @foreach ($portfolios as $portfolio)
                                <option value="{{ $portfolio->portfolio_id }}">{{ $portfolio->album_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>