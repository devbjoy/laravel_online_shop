
@extends('admin.layout.adminlayout')

@section('content')

<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change Password</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('admin.processAdminChangePassword') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="container-fluid">
            <div class="card">
                <div>  
                    @if(session('success'))
					<div class="alert alert-success" role="alert">
						{{ session('success') }}
					</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif    
                </div>
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Old Password</label>
                                <input type="text" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="old_password" value="{{ old('old_password') }}">
                                <span class="text-danger">@error('old_password') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="new_password" value="{{ old('new_password') }}">
                                <span class="text-danger">@error('new_password') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="confirm_password" value="{{ old('confirm_password') }}">
                                <span class="text-danger">@error('confirm_password') {{ $message }} @enderror</span>	
                            </div>
                        </div>				
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
<!-- /.content-wrapper -->

@endsection



@section('customJs')

	<script>
		// console.log('hello world');
	</script>


@endsection