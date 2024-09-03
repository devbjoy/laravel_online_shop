@extends('admin.layout.adminlayout')


@section('content')

<!-- Content Header (Page header) -->
                <section class="content-header">                    
                     <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                             <h1>Edit Product</h1>
                            </div>
                         <div class="col-sm-6 text-right">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div>                
                    <!-- /.container-fluid -->
                </section>
                <!-- Main content -->
                <section class="content">
                    <form action="{{ route('products.update',$products->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                       <!-- Default box -->
                       <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">                             
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control @error('title')is-invalid @enderror" placeholder="Title" value="{{ $products->title }}">
                                                    <span class="text-danger">@error('title') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="sort_description">Sort Description</label>
                                                    <textarea name="sort_description" id="sort_description" cols="30" rows="10" class="summernote form-control" placeholder="">
                                                        {{ $products->sort_description }}
                                                    </textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote form-control" placeholder="">
                                                        {{ $products->description }}
                                                    </textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="shipping_returns">Shipping Returns</label>
                                                    <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote form-control" placeholder="">
                                                        {{ $products->shipping_returns }}
                                                    </textarea>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>                                                                        
                                </div>
                                <div class="card mb-3 p-3">
                                    <label for="product_image_lg">Product Image Lg</label>
                                    <input type="file" name="product_image_lg" class="form-control @error('product_image_lg')is-invalid @enderror" accept="image\*"> 
                                    <span class="text-danger">@error('product_image_lg') {{ $message }} @enderror</span> 
                                    <img src="{{ asset('storage/'.$products->product_images->product_image_lg) }}" alt="" width="70px" height="70px">                                                               
                                </div>
                                <div class="card mb-3 p-3">
                                    <label for="product_image_sm">Product Image Sm</label>
                                    <input type="file" name="product_image_sm" class="form-control @error('product_image_sm')is-invalid @enderror" accept="image\*"> 
                                    <span class="text-danger">@error('product_image_sm') {{ $message }} @enderror</span> <img src="{{ asset('storage/'.$products->product_images->product_image_sm) }}" alt="" width="70px" height="70px">                                                                
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Pricing</h2>                                
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" id="price" class="form-control @error('price')is-invalid @enderror" placeholder="Price" value="{{ $products->price }}"> 
                                                     <span class="text-danger">@error('price'){{ $message }} @enderror</span>  
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="compare_price">Compare at Price</label>
                                                    <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price"  value="{{ $products->compare_price }}">
                                                    <p class="text-muted mt-3">
                                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                    </p>    
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>                                                                        
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Inventory</h2>                              
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                                    <input type="text" name="sku" id="sku" class="form-control @error('sku')is-invalid @enderror" placeholder="sku" value="{{ $products->sku }}">
                                                    <span class="text-danger">@error('sku') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="barcode">Barcode</label>
                                                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ $products->barcode }}">  
                                                </div>
                                            </div>   
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="hidden" value="No" name="track_qty" value="{{ old('track_qty') }}">
                                                        <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" value="{{ old('track_qty') }}" {{ $products->track_qty == "Yes" ? 'checked' : '' }}>
                                    
                                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="qty" id="qty" class="form-control @error('qty')is-invalid @enderror" placeholder="Qty" value="{{ $products->qty }}">
                                                    <span class="text-danger">@error('qty') {{ $message }} @enderror</span>   
                                                </div>
                                            </div>                                         
                                        </div>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body"> 
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $products->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $products->status == 0 ? 'selected' : '' }}>Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card">
                                    <div class="card-body"> 
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                                <option selected>Select One Category</option>
                                                @if($categories->isNotEmpty())
                                                    @foreach($categories as $category)
                                                        <option {{ $category->id == $products->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">@error('category') {{ $message }} @enderror</span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sub_category">Sub category</label>
                                            <select name="sub_category" id="sub_category" class="form-control">
                                                <option value="">Select One Sub-Category</option>
                                                @if($subcategories->isNotEmpty())
                                                    @foreach($subcategories as $subcategory)
                                                        <option {{ $products->sub_category_id == $subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                    @endforeach
                                                @endif  
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card mb-3">
                                    <div class="card-body"> 
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
                                            <select name="brands" id="status" class="form-control">
                                                <option value="">Select One Brands</option>
                                                @if($brands->isNotEmpty())
                                                    @foreach($brands as $brand)
                                                        <option {{ $brand->id == $products->brand_id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card mb-3">
                                    <div class="card-body"> 
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option value="Yes" {{ $products->is_featured == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No" {{ $products->is_featured == 'No' ? 'selected' : '' }}>No</option> 
                                            </select>
                                        </div>
                                        <h2 class="h4 mb-3">Related product</h2>
                                        <div class="mb-3">
                                            <select name="related_product[]" multiple id="related_product" class="form-control related_product">
                                                @if (!empty($related_products))
                                                @foreach ($related_products as $related_product)
                                                    <option value="{{ $related_product->id }}" selected>{{ $related_product->title }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                        </div>
                        
                        <div class="pb-5 pt-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                       </div>
                       <!-- /.card -->
                    </form>
                </section>
                <!-- /.content -->               	

@endsection



@section('customJs')

<script defer>

    $(document).ready(function(){
            let url = @json(route('product.related-product'));
            // console.log(url)
            $('.related_product').select2({
                ajax: {
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    tags: true,
                    delay: 250,
                    multiple: true,
                    minimumInputLength: 3,
                    processResults: function(data){
                        return {
                            results: data.tags
                        };
                    }
                }
            });
        })

        $('#category').change(function(event){

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route("product_subcategory") }}',
                type: 'get',
                data: {category_id:category_id},
                dataType: 'json',
                success: function(response){
                    // console.log(response);
                    $('#sub_category').find("option").not(":first").remove();

                    $.each(response["subCategory"], function(key,item){
                        $("#sub_category").append(`<option value="${item.id}">${item.name}</option>>`);
                    });
                },
                error: function(response){
                    console.log('something went wrong');
                }
            });
        });
        
</script>

@endsection