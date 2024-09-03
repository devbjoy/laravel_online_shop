@extends('front.layouts.layout')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" id="updateProfileFrom">
                        <div class="row">
                            <div class="mb-3">               
                                <label for="name">Name</label>
                                <input value="{{ $user->name }}" type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">            
                                <label for="email">Email</label>
                                <input value="{{ $user->email }}" type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">                                    
                                <label for="phone">Phone</label>
                                <input value="{{ $user->phone }}" type="number" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                <p></p>
                            </div>

                            {{-- <div class="mb-3">                                    
                                <label for="phone">Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address"></textarea>
                            </div> --}}

                            <div class="d-flex">
                                <button type="submit" id="updateProfileButton" class="btn btn-dark">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                {{-- user address --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Address</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" id="updateAddress">
                        <div class="row">
                            <div class="mb-3 col-md-6">               
                                <label for="first_name">First Name</label>
                                <input value="{{ (!empty($address)) ? $address->first_name : '' }}" type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">            
                                <label for="last_name">Last Name</label>
                                <input value="{{ (!empty($address)) ? $address->last_name : '' }}" type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="phone">Email</label>
                                <input value="{{ (!empty($address)) ? $address->email : '' }}" type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="mobile">Mobile</label>
                                <input value="{{ (!empty($address)) ? $address->mobile : '' }}" type="number" name="mobile" id="mobile" placeholder="Enter Your mobile" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-3">                                    
                                <label for="phone">Country</label>
                                <select name="country_id" id="country_id" class="form-control">
                                    <option selected disabled>Select a Country</option>
                                    @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                        <option {{ (!empty($address) && $country->id == $address->country_id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    @endif  
                                </select>
                                <p></p>
                            </div>
                            <div class="mb-3">                                    
                                <label for="phone">Address</label>
                                <textarea name="address" id="address" cols="30" rows="5" class="form-control">
                                    {{ (!empty($address)) ? $address->address : '' }}
                                </textarea>
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="apartment">Apartment</label>
                                <input value="{{ (!empty($address)) ? $address->apartment : '' }}" type="text" class="form-control" name="apartment" id="apartment" >
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="city">City</label>
                                <input value="{{ (!empty($address)) ? $address->city : '' }}" type="text" class="form-control" name="city" id="city" >
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="state">State</label>
                                <input value="{{ (!empty($address)) ? $address->state : '' }}" type="text" class="form-control" name="state" id="state" >
                                <p></p>
                            </div>
                            <div class="mb-3 col-md-6">                                    
                                <label for="zip">Zip</label>
                                <input  value="{{ (!empty($address)) ? $address->zip : '' }}" type="text" class="form-control" name="zip" id="zip" >
                                <p></p>
                            </div>

                            <div class="d-flex">
                                <button type="submit" id="updateAddressButton" class="btn btn-dark">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    // update profile ajax
    $("#updateProfileFrom").on('submit',function(event){
        event.preventDefault();
        $("#updateProfileButton").prop("disabled",true);
        if(confirm('Are Your sure you can update your profile')){
            $.ajax({
            url: "{{ route('account.updateProfile') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var error = response.errors;
                $("#updateProfileButton").prop("disabled",false);
                if(response.status == false){
                    if(error.name){
                        $("#name").siblings('p').addClass('invalid-feedback').html(error.name);
                        $("#name").addClass('is-invalid');
                    }else{
                        $("#name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#name").removeClass('is-invalid');
                    }
                    if(error.email){
                        $("#email").siblings('p').addClass('invalid-feedback').html(error.email);
                        $("#email").addClass('is-invalid');
                    }else{
                        $("#email").siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');
                    }
                    if(error.phone){
                        $("#phone").siblings('p').addClass('invalid-feedback').html(error.phone);
                        $("#phone").addClass('is-invalid');
                    }else{
                        $("#phone").siblings('p').removeClass('invalid-feedback').html('');
                        $("#phone").removeClass('is-invalid');
                    }
                }else{
                    $("#phone").siblings('p').removeClass('invalid-feedback').html('');
                    $("#phone").removeClass('is-invalid');
                    $("#email").siblings('p').removeClass('invalid-feedback').html('');
                    $("#email").removeClass('is-invalid');
                    $("#name").siblings('p').removeClass('invalid-feedback').html('');
                    $("#name").removeClass('is-invalid');

                    alert(response.message);
                    window.location.href = "{{ route('account.profile') }}";
                }
            },
            error: function(error){

            }
        })
        }
        
    })

    // update address ajax
    $("#updateAddress").on('submit',function(event){
        event.preventDefault();
        $("#updateAddressButton").prop("disabled",true);
        if(confirm('Are Your sure you can update your profile')){
            $.ajax({
            url: "{{ route('account.updateAddress') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var error = response.errors;
                $("#updateAddressButton").prop("disabled",false);
                if(response.status == false){
                    if(error.first_name){
                        $("#first_name").siblings('p').addClass('invalid-feedback').html(error.first_name);
                        $("#first_name").addClass('is-invalid');
                    }else{
                        $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#first_name").removeClass('is-invalid');
                    }
                    if(error.last_name){
                        $("#last_name").siblings('p').addClass('invalid-feedback').html(error.last_name);
                        $("#last_name").addClass('is-invalid');
                    }else{
                        $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#last_name").removeClass('is-invalid');
                    }
                    if(error.email){
                        $("#updateAddress #email").siblings('p').addClass('invalid-feedback').html(error.email);
                        $("#updateAddress #email").addClass('is-invalid');
                    }else{
                        $("#updateAddress #email").siblings('p').removeClass('invalid-feedback').html('');
                        $("#updateAddress #email").removeClass('is-invalid');
                    }
                    if(error.mobile){
                        $("#mobile").siblings('p').addClass('invalid-feedback').html(error.mobile);
                        $("#mobile").addClass('is-invalid');
                    }else{
                        $("#mobile").siblings('p').removeClass('invalid-feedback').html('');
                        $("#mobile").removeClass('is-invalid');
                    }
                    if(error.country_id){
                        $("#country_id").siblings('p').addClass('invalid-feedback').html(error.country_id);
                        $("#country_id").addClass('is-invalid');
                    }else{
                        $("#country_id").siblings('p').removeClass('invalid-feedback').html('');
                        $("#country_id").removeClass('is-invalid');
                    }
                    if(error.address){
                        $("#address").siblings('p').addClass('invalid-feedback').html(error.address);
                        $("#address").addClass('is-invalid');
                    }else{
                        $("#address").siblings('p').removeClass('invalid-feedback').html('');
                        $("#address").removeClass('is-invalid');
                    }
                    if(error.city){
                        $("#city").siblings('p').addClass('invalid-feedback').html(error.city);
                        $("#city").addClass('is-invalid');
                    }else{
                        $("#city").siblings('p').removeClass('invalid-feedback').html('');
                        $("#city").removeClass('is-invalid');
                    }
                    if(error.state){
                        $("#state").siblings('p').addClass('invalid-feedback').html(error.state);
                        $("#state").addClass('is-invalid');
                    }else{
                        $("#state").siblings('p').removeClass('invalid-feedback').html('');
                        $("#state").removeClass('is-invalid');
                    }
                    if(error.zip){
                        $("#zip").siblings('p').addClass('invalid-feedback').html(error.zip);
                        $("#zip").addClass('is-invalid');
                    }else{
                        $("#zip").siblings('p').removeClass('invalid-feedback').html('');
                        $("#zip").removeClass('is-invalid');
                    }
                }else{
                    $("#zip").siblings('p').removeClass('invalid-feedback').html('');
                    $("#zip").removeClass('is-invalid');
                    $("#state").siblings('p').removeClass('invalid-feedback').html('');
                    $("#state").removeClass('is-invalid');
                    $("#city").siblings('p').removeClass('invalid-feedback').html('');
                    $("#city").removeClass('is-invalid');
                    $("#address").siblings('p').removeClass('invalid-feedback').html('');
                    $("#address").removeClass('is-invalid');
                    $("#country_id").siblings('p').removeClass('invalid-feedback').html('');
                    $("#country_id").removeClass('is-invalid');
                    $("#mobile").siblings('p').removeClass('invalid-feedback').html('');
                    $("#mobile").removeClass('is-invalid');
                    $("#updateAddress #email").siblings('p').removeClass('invalid-feedback').html('');
                    $("#updateAddress #email").removeClass('is-invalid');
                    $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                    $("#last_name").removeClass('is-invalid');
                    $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                    $("#first_name").removeClass('is-invalid');

                    alert(response.message);
                    window.location.href = "{{ route('account.profile') }}";
                }
            },
            error: function(error){

            }
        })
        }
        
    })
</script>
@endsection