<div class="my-2">
    <h5 class="mb-2 poppins-medium setting-color">Social Media Accounts</h5>

    @foreach ($socmed as $socialMedia)

    <form method="POST" action="{{ route('social-media.update', ['platform' => $socialMedia->platform]) }}" class="row mb-3 align-items-center border-bottom pb-2">
        @csrf
        @method('PATCH')

        <div class="col-auto col-md-2">
            <img src="{{ asset('assets/' . $socialMedia->platform . '.svg') }}" alt="{{ $socialMedia->platform }} Logo" class="socmed-container setting-socmed-img">
        </div>
        <div class="col col-md-8">
            <div class="input-group">
                <input
                    type="url"
                    id="{{ $socialMedia->platform }}_link"
                    name="url"
                    class="form-control"
                    placeholder="Enter your {{ $socialMedia->platform }} profile URL"
                    value="{{ $socialMedia ? $socialMedia->url : '' }}"
                    readonly />
            </div>
        </div>
        <div class="col-auto col-md-2">
            <button type="button" class="btn edit-btn" data-target="#{{ $socialMedia->platform }}_link">
                <i class="fas fa-pen-to-square"></i>
            </button>
            <button type="submit" class="btn btn-primary d-none save-btn">
                Save
            </button>
        </div>
    </form>
    @endforeach
</div>

<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const inputField = document.querySelector(this.getAttribute('data-target'));
            inputField.removeAttribute('readonly');
            this.classList.add('d-none');
            this.nextElementSibling.classList.remove('d-none');
        });
    });
</script>