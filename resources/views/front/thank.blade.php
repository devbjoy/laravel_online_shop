@extends('front.layouts.layout')

@section('content')
@if (Session()->has('success'))
        <div class="alert alert-success w-50 mx-auto mt-5">
            {{ Session()->get('success') }}
        </div>
    @endif
<div class="text-center mt-3">
    <h2>Thank You !</h2>
    <p class="mt-2">Your Order Id Is : {{ $id }}</p>
</div>
    
@endsection