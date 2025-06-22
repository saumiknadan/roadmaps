<div class="row mb-4">
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                    <h5 class="card-title mb-sm-0 me-2">Profile Information</h5>
                    
                </div>
                <div class="card-body" id="top">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <form action="{{ route('profile.update') }}"  method="POST" id="forms_data" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                {{-- Name --}}
                                <div class="form-group col-md-8 mb-4">
                                    <label class="mb-2" for="name">Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}"
                                        required autofocus autocomplete="name" 
                                        />
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                                </div>

                                <div class="form-group col-md-8 mb-4">
                                    <label class="mb-2" for="name"> Email</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}"
                                        required autocomplete="username"
                                        />
                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
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