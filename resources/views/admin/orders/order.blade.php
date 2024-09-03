@extends('admin.layout.adminlayout')

@section('content')

	 {{-- Content Header (Page header)  --}}
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    {{-- <a href="{{ route('brands.create') }}" class="btn btn-primary">New Brand</a> --}}
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
                <form  method="get">
            
                <div class="card-header">
                    <div class="card-title">
                        <a href="{{ route('admin.order') }}" class="btn btn-default btn-sm">Reset</a>
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{ Request::get('keyword') }}">
        
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                            </div>
                    </div>
                </div>
                </form>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Date Purchased</th> 
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody>
                            @if($orders->isNotEmpty())

                                @foreach($orders as $item)
                                <tr>
                                    <td><a href="{{ route('admin.orderDetails',$item->id) }}">{{ $item->id }}</a></td>

                                    <td>{{ (!empty($item->user)) ? $item->user->name : '' }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>
                                    @if ($item->status == 'pending')
                                        <span class="badge bg-danger">Pending</span>      
                                    @elseif($item->status == 'shipped')
                                        <span class="badge bg-info">Shipped</span>
                                    @elseif($item->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @else
                                        <span class="badge bg-warning">Canceled</span>                                          
                                    @endif
                                    </td>
                                    <td>${{ number_format($item->grand_total,2) }}</td> 
                                    <td>{{ date_format($item->created_at,"d M, Y") }}</td>
                                    <td><a href="{{ route('admin.orderDetails',$item->id) }}" class="btn btn-sm btn-info">view</a></td>
                                </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-bold">Order item is Empty !</td>
                                </tr>
                            @endif
                                                            
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    @if($orders->isNotEmpty())

                        {{ $orders->links() }}


                    @endif

                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection



@section('customJs')

	<script>
		// console.log('hello world');
	</script>


@endsection