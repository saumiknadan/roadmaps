@php
  $appInfo = App\Models\AppInfo::first();
@endphp

<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/assets') . '/' }}" data-template="vertical-menu-template-no-customizer">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <title>Registration | {{ $appInfo->name }}</title> 
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />
    @include('admin.partials.head') 
</head>

<body>
    

    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/assets/img/illustrations/auth-reset-password-illustration-light.png') }}"
                        alt="auth-login-cover" class="img-fluid my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-reset-password-illustration-light.png"
                        data-app-dark-img="illustrations/auth-reset-password-illustration-dark.png" />                  
                </div>
            </div>
            

            
            <div class="d-flex col-12 col-lg-5 justify-content-center align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    
                    <div class="mb-4 col-12 mb-md-5 d-flex justify-content-center align-items-center">
                        @if (isset($appInfo->logo) && $appInfo->logo != null)
                            <div class="d-flex align-items-center">
                                <img 
                                    src="{{ $appInfo->logo == 'admin' 
                                        ? asset(env('ADMINPATH') . $appInfo->logo) 
                                        : asset(env('FRONTPATH') . $appInfo->logo) }}"
                                    alt="App Logo"
                                    style="width: 60px; height: auto; object-fit: contain;"
                                >
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="mb-1">Please Register to {{ $appInfo->name  }}</h3> 
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    <form id="formRegistration" class="mb-3" method="POST" action="{{ route('register') }}">
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
                            <label for="email" class="form-label">Email or Username</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Enter your email or username"
                                value="{{ old('email') }}" required autofocus autocomplete="username" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <input type="hidden" class="form-control"  id="is_admin" name="is_admin" value="1" />

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
                        <button type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
                    </form>

                    <p class="text-center">
                        <span>New on our platform?</span>
                        <a href="{{ route('register') }}">
                            <span>Create an account</span>
                        </a>
                    </p>
                </div>
            </div>
            
        </div>
    </div>

    
    @include('admin.partials.script')

</body>

</html>
