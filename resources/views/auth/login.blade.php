<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/assets') . '/' }}" data-template="vertical-menu-template-no-customizer">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <title>Login | {{ $appInfo->name }}</title> 
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
                    
                    <h3 class="mb-1">Welcome to {{ $appInfo->name  }}</h3> 
                    <p class="mb-4">Please sign-in to your account </p> 
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                        @csrf
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
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
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
