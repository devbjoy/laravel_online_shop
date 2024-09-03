

@extends('admin.layout.adminlayout')


@section('content')

<section class="content-header">					
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-md-12">
				@if(session('success'))
					<div class="alert alert-info" role="alert">
						{{ session('success') }}
					</div>
				@endif
				@if(session('error'))
					<div class="alert alert-danger" role="alert">
						{{ session('error') }}
					</div>
				@endif
			</div>
			<div class="col-sm-6">
				<h1>All Shipping</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{ route('shipping.create') }}" class="btn btn-primary">Add Shipping Price</a>
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
					<a href="{{ route('shipping.index') }}" class="btn btn-default btn-sm">Reset</a>
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
							<th width="200">ID</th>
							<th>Country Name</th>
							<th>Amount</th>	
							<th width="100">Edit</th>
							<th width="100">Delete</th>
						</tr>
					</thead>
					<tbody>
						@if($shippingChaeges->isNotEmpty())
							@foreach($shippingChaeges as $item)
						<tr>
							<td>{{ $item->id }}</td>
							<td>{{ ($item->shipping_charge == null) ? 'Rest Of The World' : $item->shipping_charge->name}}</td>
							<td>${{ $item->amount }}</td>
							<td>
								<a href="{{ route('shipping.edit',$item->id) }}" class="btn btn-secondary">
									<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
									</svg>
								</a>
							</td>
							<td>
								<form action="{{ route('shipping.destroy',$item->id) }}" method="post">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger"><svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
									</svg></button>
								</form>
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
				@if($shippingChaeges->isNotEmpty())

					{{ $shippingChaeges->links() }}


				@endif
			</div>
		</div>
	</div>
	<!-- /.card -->
</section>

@endsection



@section('customJs')

	<script>
		// console.log('hello world');
	</script>


@endsection