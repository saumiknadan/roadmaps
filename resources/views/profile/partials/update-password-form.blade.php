<div class="row mt-4">
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                    <h5 class="card-title mb-sm-0 me-2">{{ __('Update Password') }}</h5>
                </div>
                <div class="card-body" id="top">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')

                                <div class="form-group col-md-8 mb-4">
                                    <label class="mb-2" for="update_password_current_password">Current Password</label>
                                    <input type="password"
                                        class="form-control" 
                                        id="update_password_current_password" 
                                        name="current_password" 
                                        autocomplete="current-password"
                                        />
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />

                                </div>

                                <div class="form-group col-md-8 mb-4">
                                    <label class="mb-2" for="update_password_password">New Password</label>
                                    <input type="password" 
                                         id="update_password_password" 
                                         name="password" 
                                         class="form-control" 
                                         autocomplete="new-password"
                                        />
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />

                                </div>

                                <div class="form-group col-md-8 mb-4">
                                    <label class="mb-2" for="update_password_password_confirmation">Confirm Password</label>
                                    <input type="password" 
                                         id="update_password_password_confirmation" 
                                         name="password_confirmation" 
                                         class="form-control" 
                                         autocomplete="new-password"
                                        />
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />


                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>