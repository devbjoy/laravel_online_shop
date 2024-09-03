
@extends('admin.layout.adminlayout')

@section('content')

	<!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Page</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('pages.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>	
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="content">Content</label>
                                <textarea name="content"  class="form-control" rows="5" cols="10" placeholder="Content"></textarea>
                            </div>
                        </div>                        										
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('pages.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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