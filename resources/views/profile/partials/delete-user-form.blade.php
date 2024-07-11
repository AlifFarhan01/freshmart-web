<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal">{{ __('Delete Account') }}</button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="{{ __('Password') }}">
                            @if ($errors->userDeletion->has('password'))
                                <div class="mt-2 text-danger">
                                    @foreach ($errors->userDeletion->get('password') as $message)
                                        {{ $message }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
