@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{url('/')}}" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            <div class="image">
                                <img src="{{ asset('logo.webp') }}" alt="Logo" class="img-fluid" style="width: 100%; height: auto;">
                            </div>
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">SK STEELS TECH</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">

                    <form id="formAuthentication" class="mb-3" action="{{url('/login')}}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{old('email')}}" autofocus>
                            <label for="email">Email</label>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                                @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Remember Me
                                </label>
                            </div>
                            <a href="{{url('auth/forgot-password-basic')}}" class="float-end mb-1">
                                <span>Forgot Password?</span>
                            </a>
                        </div> -->
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>

                    <!-- <p class="text-center">
                        <span>New on our platform?</span>
                        <a href="{{url('auth/register-basic')}}">
                            <span>Create an account</span>
                        </a>
                    </p> -->
                </div>
            </div>
            <!-- /Login -->
            <!-- <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
            <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
            <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block"> -->
        </div>
    </div>
</div>
@endsection