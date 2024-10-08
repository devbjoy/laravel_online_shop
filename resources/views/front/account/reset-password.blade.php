@extends('front.layouts.layout')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item">Reset Password</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="login-form">    
            <form action="{{ route('front.processResetPassword') }}" method="post">
                @csrf
                <h4 class="modal-title">Reset Password</h4>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Enter Password" name="password">
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" value="{{ old('confirm_password') }}" placeholder="Enter confirm password" name="confirm_password">
                    @error('confirm_password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">              
            </form>			
            <div class="text-center small"><a href="{{ route('account.login') }}">Login</a></div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    
@endsection