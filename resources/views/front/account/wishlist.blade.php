@extends('front.layouts.layout')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a></li>
                <li class="breadcrumb-item">Wishlist</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                    </div>
                    <div class="card-body p-4">
                        @if ($wishlists->isNotEmpty())
                        @foreach ($wishlists as $item)
                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('front.product',$item->product->slug) }}" style="width: 10rem;">
                                @if (!empty($item->product->product_images->product_image_lg))
                                    <img src="{{ asset('storage/'.$item->product->product_images->product_image_lg) }}" alt="Product">
                                @else
                                    <img src="{{ asset('storage/'.$item->product->product_images->product_image_sm) }}" alt="Product">
                                @endif
                                {{-- <img src="images/product-1.jpg" alt="Product"> --}}
                            </a>
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2"><a href="{{ route('front.product',$item->product->slug) }}">{{ $item->product->title }}</a></h3> 
                                    @if ($item->product->compare_price > 0)
                                        <div class="fs-lg text-accent pt-2">${{ $item->product->price }} <small><del>${{ $item->product->compare_price }}</del></small></div>                                  
                                    @endif                                       
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <button onclick="deleteWishlistItem({{ $item->product->id }})" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                            </div>
                        </div> 
                        @endforeach
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script>
        function deleteWishlistItem(id){
            $.ajax({
                url: '{{ route("account.deleteWishlistPorduct") }}',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(res){
                    if(res.status == true){
                        alert(res.message);
                        window.location.href = "{{ route('account.wishlist') }}";
                    }
                },
                error: function(error){

                }
                
            })
        }
    </script>
@endsection