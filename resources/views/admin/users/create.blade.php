
@extends('admin.layout.adminlayout')

@section('content')

	<!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Users</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}">
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" value="{{ old('password') }}">	
                                <span class="text-danger">@error('password') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="phone" value="{{ old('phone') }}">	
                                <span class="text-danger">@error('phone') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>										
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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