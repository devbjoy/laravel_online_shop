@extends('admin.layout.adminlayout')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-md-12">
				@if(session('success'))
					<div class="alert alert-info" role="alert">
						{{ session('success') }}
					</div>
				@endif
				@if(session('delete'))
					<div class="alert alert-danger" role="alert">
						{{ session('delete') }}
					</div>
				@endif
			</div>
			<div class="col-sm-6">
				<h1>Product Rating</h1>
			</div>
			<div class="col-sm-6 text-right">
				{{-- <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a> --}}
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					<a href="{{ route('product.productRating') }}" class="btn btn-default btn-sm">Reset</a>
				</div>
				<div class="card-tools">
					<form action="{{ route('products.index') }}" method="get">
					<div class="input-group input-group" style="width: 250px;">
						<input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{ Request::get('keyword') }}">
	
						<div class="input-group-append">
							<button type="submit" class="btn btn-default">
							<i class="fas fa-search"></i>
							</button>
						</div>
						</div>
						</form>
				</div>
			</div>
			<div class="card-body table-responsive p-0">								
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th width="60">ID</th>
							<th >Product Name</th>
							<th>Rating</th>
							<th>Comment</th>
							<th>Rated By</th>
							<th width="100">Status</th>
							
						</tr>
					</thead>
					<tbody>
						@if($ratings->isNotEmpty())
							@foreach($ratings as $item)
						<tr>
							<td>{{ $item->id }}</td>										
							<td>{{ $item->product_ratings->title }}</td>										
							<td>{{ $item->rating }}</td>										
							<td>{{ $item->comment }}</td>										
							<td>{{ $item->username }}</td>										
							<td>
								@if($item->status == 1)
                                <a href="javascript:void(0)" onclick="changeRatingStatus(0,{{ $item->id}})">
                                    <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Click
                                </a>
								@else
                                <a href="javascript:void(0)" onclick="changeRatingStatus(1,{{ $item->id}})">
									<svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								    </svg>
                                    Click
                                </a>
								@endif
							</td>
						</tr>
							@endforeach
						@else
							<tr>
								<td>
									Record Not Found
								</td>
							</tr>
						@endif
					</tbody>
				</table>										
			</div>
			<div class="card-footer clearfix">
				@if($ratings->isNotEmpty())
					{{ $ratings->links() }}
				@endif
			</div>
		</div>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->
{{-- </div> --}}
<!-- /.content-wrapper -->

@endsection

@section('customJs')
<script>
    function changeRatingStatus(status, id){
        if(confirm('Are you sure to change product status')){
            $.ajax({
                headers: {
		            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	            },
                url: "{{ route('product.changePorductRating') }}",
                type: "POST",
                data: {status: status,id: id},
                dataType: 'json',
                success: function(res){
                    window.location.href = "{{ route('product.productRating') }}"
                },
                
                error: function(err){
                    console.log(err);
                }
            })
        }
    }
</script>
@endsection

