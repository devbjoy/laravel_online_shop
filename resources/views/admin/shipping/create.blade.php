@extends('admin.layout.adminlayout')

@section('content')
<section class="content-header">                    
    <div class="container-fluid my-2">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Shipping Price</h1>
        </div>
        <div class="col-sm-6 text-right">
        <a href="{{ route('shipping.index') }}" class="btn btn-primary">Back</a>
    </div>
</div>                
<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
<form action="{{ route('shipping.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Default box -->
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">                             
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <select name="country" id="" class="form-control @error('country') is-invalid @enderror">
                                    <option value="" selected disabled>Select Country</option>
                                    @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name}}</option>
                                    @endforeach
                                    @endif
                                    <option value="rest_of_the_world">Rest Of The World</option>
                                </select>
                                <span class="text-danger">@error('country') {{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="amount" class="form-control @error('country') is-invalid @enderror" placeholder="Enter Amount">
                            <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                        </div> 
                        <div class="col-md-2">
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Create</button>
                            </div>
                        </div>                                         
                    </div>
                </div>                                                                        
            </div>
        </div>
    <div class="pb-5 pt-3">
        
        
    </div>
    </div>
    <!-- /.card -->
</form>
</section>
@endsection

@section('customJs')
    
@endsection