
@extends('admin.layout.adminlayout')

@section('content')

	<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Edit Category</h1>
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
					<form action="{{ route('category.update',$category->id) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('PUT')
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ $category->name }}">
											<span class="text-danger">@error('name') {{ $message }} @enderror</span>	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Image</label>
											<input type="file" name="photo" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Photo" value="" accept="image\*">
											@if(!empty($category->image))
											<img src="{{ asset('/storage/'.$category->image) }}" alt="" style="width: 70px; height: 70px;" id="output">
											@endif
											<span class="text-danger">@error('photo') {{ $message }} @enderror</span>	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="email">Slug</label>
											<input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" value="{{ $category->slug }}" readonly>	
											<span class="text-danger">@error('slug') {{ $message }} @enderror</span>	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>
											<select name="status" id="" class="form-control">
												<option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active</option>
												<option {{ $category->status == 0 ? 'selected' : '' }} value="0">Block</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="status">Show On Home</label>
											<select name="showHome" id="" class="form-control">
												<option {{ $category->show_home == 'Yes' ? 'selected' : '' }} value="Yes">Yes</option>
												<option {{ $category->show_home == 'No' ? 'selected' : '' }} value="No">No</option>
											</select>
										</div>
									</div>										
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary" type="submit">Save</button>
							<a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
					</div>
					</form>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->

@endsection



@section('customJs')

	<script>
		// console.log('hello world');
	</script>


@endsection