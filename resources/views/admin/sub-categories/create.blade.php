@extends('admin.layout.adminlayout')


@section('content')

	<!-- Content Header (Page header) -->
	<section class="content-header">					
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Sub Category</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{ route('subcategory.index') }}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
			<form action="{{ route('subcategory.store') }}" method="post">
				@csrf
				<div class="card">
					<div class="card-body">								
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label for="name">Category</label>
									<select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
										<option value="">Select One Category</option>
										@if($data->isNotEmpty())
											@foreach($data as $category)
											<option value="{{ $category->id }}">{{ $category->name }}</option>
											@endforeach
											@endif
									</select>
									<span class="text-danger">@error('category') {{ $message }} @enderror</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">	
									<span class="text-danger">@error('name') {{ $message }} @enderror</span>	
								</div>
							</div>
							{{-- <div class="col-md-6">
								<div class="mb-3">
									<label for="email">Slug</label>
									<input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">	
								</div>
							</div> --}}
							<div class="col-md-6">
								<div class="mb-3">
									<label for="status">Status</label>
									<select name="status" id="" class="form-control">
										<option value="1">Active</option>
										<option value="0">Block</option>
									</select>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="show_home">Show On Home</label>
									<select name="show_home" id="" class="form-control">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>	
								</div>
							</div>										
						</div>
					</div>							
				</div>
			<div class="pb-5 pt-3">
				<button type="submit" class="btn btn-primary">Create</button>
				<a href="{{ route('subcategory.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
			</form>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
	<!-- /.content-wrapper -->

@endsection


@section('customJs')


@endsection