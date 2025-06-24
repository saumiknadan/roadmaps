@extends('admin.index')


@section('styles')

@endsection

@section('admin-content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
           
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">Create New User</h5>
                        <div class="action-btns">
                            <a class="btn btn-label-primary me-3" href="{{ route('users.index') }}">
                            <span class="align-middle"> Back</span>
                            </a>
                            
                        </div>
                    </div>
                        @include('admin.partials.message')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Enter your full name"
                                            value="{{ old('name') }}" required  />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
            
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Enter your email or username"
                                            value="{{ old('email') }}" required autofocus autocomplete="username" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
            
                                    <div class="mb-3">
                                        <label for="userType" class="form-label">User Type</label>
                                        <select
                                            id="is_admin"
                                            class="select2 form-select w-100"
                                            data-style="btn-default"
                                            data-live-search="true"
                                            name="is_admin"
                                            required >
                                            <option value="" selected disabled>Select User Type</option>
                                            <option value="1">Admin</option>
                                            <option value="0">General User</option>
                                        </select>
                                    </div>
            
                                    <div class="mb-3 form-password-toggle">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
            
                                    <div class="mb-3 form-password-toggle">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password_confirmation" />
                                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                        </div>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    

                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Create </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              
        </div>
    </div>
</div>
@endsection