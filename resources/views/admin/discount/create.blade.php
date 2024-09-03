@extends('admin.layout.adminlayout')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">                    
        <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Coupone Code</h1>
            </div>
            <div class="col-sm-6 text-right">
            <a href="{{ route('discount.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>                
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    {{-- @error($errors->any())
            {{ $message }}
        @enderror --}}
    <form action="" method="post" enctype="multipart/form-data" id="addDiscountFrom">
        <!-- Default box -->
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">                             
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Discount Code" value="{{ old('code') }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Discount name" value="{{ old('name') }}">
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="summernote form-control" placeholder="Description">
                                        {{ old('description') }}
                                    </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_returns">Max Uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses" value="{{ old('max_uses') }}">
                                    
                                </div>
                            </div>                                            
                        </div>
                    </div>                                                                        
                </div>
                <div class="card mb-3 p-3">
                    <label for="shipping_returns">Max Uses User</label>
                    <input type="number" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses User" value="{{ old('max_uses_user') }}">                                                             
                </div>               
            </div>
            <div class="col-md-4"> 
                <div class="card mb-3">
                    <div class="card-body">                            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sku">Min Amount</label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="min_amount" value="{{ old('min_amount') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" placeholder="discount_amount" value="{{ old('discount_amount') }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                     <p></p>  
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>                                      
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="starts_at">Starts At</label>
                                    <input autocomplete="off" type="text" name="starts_at" id="starts_at" class="form-control" placeholder="starts_at" value="{{ old('starts_at') }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="expires_at">Expires At</label>
                                    <input autocomplete="off" type="text" name="expires_at" id="expires_at" class="form-control" placeholder="expires_at" value="{{ old('expires_at') }}">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>                                                                        
                </div>    
            </div>
            
        <div class="pb-5 pt-3">
            <button class="btn btn-primary" type="submit">Create</button>
            <a href="{{ route('discount.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </div>
        <!-- /.card -->
    </form>
    <div>
        {{-- @error($errors->any())
            {{ $errors->get() }}
        @enderror --}}
    </div>
</section>
<!-- /.content -->               	

@endsection

@section('customJs')
<script>
    $(document).ready(function(){
        $('#starts_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
        $('#expires_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
    });

    $('#addDiscountFrom').on('submit',function(event){
        event.preventDefault();

        $.ajax({
            url : '{{ route("discount.store") }}',
            headers: {
		        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	        },
            type: 'post',
            data : $(this).serializeArray(),
            dataType: 'json',
            success : function (res){
                let errors = res.errors;
                if(res.status == false){
                    if(errors.code){
                        $("#code").siblings('p').addClass('invalid-feedback').html(errors.code);
                        $("#code").addClass('is-invalid');
                    }else{
                        $("#code").siblings('p').removeClass('invalid-feedback').html('');
                        $("#code").removeClass('is-invalid');
                    }
                    if(errors.discount_amount){
                        $("#discount_amount").siblings('p').addClass('invalid-feedback').html(errors.discount_amount);
                        $("#discount_amount").addClass('is-invalid');
                    }else{
                        $("#discount_amount").siblings('p').removeClass('invalid-feedback').html('');
                        $("#discount_amount").removeClass('is-invalid');
                    }
                    if(errors.type){
                        $("#type").siblings('p').addClass('invalid-feedback').html(errors.type);
                        $("#type").addClass('is-invalid');
                    }else{
                        $("#type").siblings('p').removeClass('invalid-feedback').html('');
                        $("#type").removeClass('is-invalid');
                    }
                    if(errors.status){
                        $("#status").siblings('p').addClass('invalid-feedback').html(errors.status);
                        $("#status").addClass('is-invalid');
                    }else{
                        $("#status").siblings('p').removeClass('invalid-feedback').html('');
                        $("#status").removeClass('is-invalid');
                    }
                    if(errors.starts_at){
                        $("#starts_at").siblings('p').addClass('invalid-feedback').html(errors.starts_at);
                        $("#starts_at").addClass('is-invalid');
                    }else{
                        $("#starts_at").siblings('p').removeClass('invalid-feedback').html('');
                        $("#starts_at").removeClass('is-invalid');
                    }
                    if(errors.expires_at){
                        $("#expires_at").siblings('p').addClass('invalid-feedback').html(errors.expires_at);
                        $("#expires_at").addClass('is-invalid');
                    }else{
                        $("#expires_at").siblings('p').removeClass('invalid-feedback').html('');
                        $("#expires_at").removeClass('is-invalid');
                    }
                }else{
                    $("#code").siblings('p').removeClass('invalid-feedback').html('');
                    $("#code").removeClass('is-invalid');
                    $("#discount_amount").siblings('p').removeClass('invalid-feedback').html('');
                    $("#discount_amount").removeClass('is-invalid');
                    $("#type").siblings('p').removeClass('invalid-feedback').html('');
                    $("#type").removeClass('is-invalid');
                    $("#status").siblings('p').removeClass('invalid-feedback').html('');
                    $("#status").removeClass('is-invalid');
                    $("#starts_at").siblings('p').removeClass('invalid-feedback').html('');
                    $("#starts_at").removeClass('is-invalid');
                    $("#expires_at").siblings('p').removeClass('invalid-feedback').html('');
                    $("#expires_at").removeClass('is-invalid');

                    window.location.href = "{{ route('discount.index') }}";
                    // window.location.href
                }
            },
            error: function(jQXHR, exception){
                console.log('something went worng');
            }
        })
    })
</script>
@endsection
