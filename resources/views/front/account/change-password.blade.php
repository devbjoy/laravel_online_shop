@extends('front.layouts.layout')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a></li>
                <li class="breadcrumb-item">Change Password</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> {{ Session::get('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

            </div>
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="" id="changePasswordFrom">
                        <div class="row">
                            <div class="mb-3">               
                                <label for="name">Old Password</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">               
                                <label for="name">New Password</label>
                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-3">               
                                <label for="name">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-dark" type="submit">Save</button>
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
    $("#changePasswordFrom").submit(function(event){
        event.preventDefault();
        $.ajax({
            url: '{{ route("account.processChangePassword") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(res){
                var errors = res.errors;
                if(res.status == true){

                    window.location.href = "{{ route('account.changePassword') }}";

                    $("#old_password").siblings('p').removeClass('invalid-feedback').html('');
                    $("#old_password").removeClass('is-invalid');
                    $("#new_password").siblings('p').removeClass('invalid-feedback').html('');
                    $("#new_password").removeClass('is-invalid');
                    $("#confirm_password").siblings('p').removeClass('invalid-feedback').html('');
                    $("#confirm_password").removeClass('is-invalid');
                }else{
                    if(errors.old_password){
                        $("#old_password").siblings('p').addClass('invalid-feedback').html(errors.old_password);
                        $("#old_password").addClass('is-invalid');
                    }else{
                         $("#old_password").siblings('p').removeClass('invalid-feedback').html('');
                         $("#old_password").removeClass('is-invalid');
                    }
                    if(errors.new_password){
                        $("#new_password").siblings('p').addClass('invalid-feedback').html(errors.new_password);
                        $("#new_password").addClass('is-invalid');
                    }else{
                         $("#new_password").siblings('p').removeClass('invalid-feedback').html('');
                         $("#new_password").removeClass('is-invalid');
                    }

                    if(errors.confirm_password){
                        $("#confirm_password").siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                        $("#confirm_password").addClass('is-invalid');
                    }else{
                         $("#confirm_password").siblings('p').removeClass('invalid-feedback').html('');
                         $("#confirm_password").removeClass('is-invalid');
                    }
        
                }
            },
            errors:function(error){
                console.log('someting went worng');
            } 
            
        })
    })
</script>
@endsection