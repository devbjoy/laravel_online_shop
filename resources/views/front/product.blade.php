@extends('front.layouts.layout')


@section('content')


    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">{{ $products->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                        	@if(!empty($products->product_images))
                            <div class="carousel-item active">
                                @if (!empty($products->product_images->product_image_lg))
                                <img class="w-100 h-100" style="height: 500px;" src="{{ asset('storage/'.$products->product_images->product_image_lg) }}" alt="Image">
                                @else
                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" class="w-100 h-100">
                                @endif
                            </div>
                            <div class="carousel-item">
                                @if (!empty($products->product_images->product_image_sm))
                                <img class="w-100 h-100" style="height: 500px;" src="{{ asset('storage/'.$products->product_images->product_image_sm) }}" alt="Image">
                                @else
                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" class="w-100 h-100" style="height: 500px;" >
                                @endif
                            </div> 
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{ $products->title }}</h1>
                         <div class="d-flex mb-3">  

                            {{-- <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>   --}}

                            <div class="star-rating mt-2">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    
                                    <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 ps-2">
                                ({{ ($products->product_ratings_count > 1) ? $products->product_ratings_count.' Reviews' : $products->product_ratings_count.' Review' }})</div>
                        </div>
                        @if($products->compare_price > 0)
                        <h2 class="price text-secondary"><del>${{ $products->compare_price }}</del></h2>
                        @endif
                        <h2 class="price">${{ $products->price }}</h2>

                        <p>{{ $products->sort_description }}</p>
                        @if ($products->track_qty == 'Yes')
                            @if ($products->qty > 0)
                                <a href="javascript:void(0);" onclick="addToCart({{ $products->id }})" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;Out of Stock</a>       
                            @endif
                        @else
                            <a href="javascript:void(0);" onclick="addToCart({{ $products->id }})" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p> {{ $products->description }}</p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p>{{ $products->sort_description }}</p>
                            </div>
                            {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                {{ $products->shipping_returns }}
                            </div> --}}
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="col-md-8">
                                    <div class="row">
                                        <form action="" id="ratingForm" name="ratingForm">
                                        <h3 class="h4 pb-3">Write a Review</h3>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                            <p></p>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                            <p></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="rating">Rating</label>
                                            <br>
                                            <div class="rating" style="width: 10rem">
                                                <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                            </div>
                                            <p id="rating-star" class="text-danger"></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">How was your overall experience?</label>
                                            <textarea name="content"  id="content" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?"></textarea>
                                            <p></p>
                                        </div>
                                        <div>
                                            <button class="btn btn-dark"  type="submit" id="ratingButton">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="overall-rating mb-3">
                                        <div class="d-flex">
                                            <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                            <div class="star-rating mt-2">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="pt-2 ps-2">
                                                ({{ ($products->product_ratings_count > 1) ? $products->product_ratings_count.' Reviews' : $products->product_ratings_count.' Review' }})</div>
                                        </div>
                                        
                                    </div>
                                    @if ($products->product_ratings->isNotEmpty())
                                    @foreach ($products->product_ratings as $rating)
                                    @php
                                        $ratingPer = ($rating->rating*100)/5
                                    @endphp
                                    <div class="rating-group mb-4">
                                        <span> <strong>{{ $rating->username }} </strong></span>
                                         <div class="star-rating mt-2" title="">
                                             <div class="back-stars">
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 
                                                 <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                     <i class="fa fa-star" aria-hidden="true"></i>
                                                     <i class="fa fa-star" aria-hidden="true"></i>
                                                     <i class="fa fa-star" aria-hidden="true"></i>
                                                     <i class="fa fa-star" aria-hidden="true"></i>
                                                     <i class="fa fa-star" aria-hidden="true"></i>
                                                 </div>
                                             </div>
                                         </div>   
                                         <div class="my-3">
                                            
                                         <p>{{ $rating->comment }}</p>
                                         </div>
                                     </div>
                                    @endforeach
                                    @endif
                                    
    
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>           
        </div>
    </section>

    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div> 
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    @if(!empty($related_products))
                    @foreach ($related_products as $related_product)
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{ route('front.product',$related_product->slug) }}" class="product-img">
                                @if (!empty($related_product->product_images->product_image_lg))
                                    <img class="card-img-top" style="height: 250px;" src="{{ asset('storage/'.$related_product->product_images->product_image_lg) }}" alt="">
                                @else
                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" class="card-img-top" style="height: 250px;">
                                @endif
                            </a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                            <div class="product-action">
                            @if ($related_product->track_qty == 'Yes')
                                @if ($related_product->qty > 0)
                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $related_product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a> 
                                @else
                                <a class="btn btn-dark" href="javascript:void(0)">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a> 
                                @endif
                            @else
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $related_product->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a> 
                            @endif
                                                           
                            </div>
                        </div>                        
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">{{ $related_product->title }}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{ $related_product->price }}</strong></span>
                                <span class="h6 text-underline"><del>${{ $related_product->compare_price }}</del></span>
                            </div>
                        </div>                        
                    </div>
                    @endforeach
                    @else
                        <p class="text-danger mt-3">No Related Porduct Found</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- <img class="w-100 h-100" src="{{ asset('storage/'.$products->product_images->product_image_lg) }}" alt="Image"> --}}
    </section>


@endsection

@section('customJs')
<script>
$("#ratingForm").submit(function(event){
    event.preventDefault();
    $("#ratingButton").prop('disabled',true);
    $.ajax({
        url : "{{ route('font.saveRating',$products->id) }}",
        type: 'POST',
        data: $(this).serializeArray(),
        dataType : 'json',
        success : function(res){
            $("#ratingButton").prop('disabled',false);
            var error = res.errors;
            if(res.status == false){
                
                if(error.name){
                    $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.name);
                }else{
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if(error.email){
                    $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.email);
                }else{
                    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if(error.content){
                    $("#content").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.content);
                }else{
                    $("#content").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if(error.rating){
                    $("#rating-star").html(error.rating);
                }else{
                    $('#rating-star').html("");
                }

            }else{
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                $("#content").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                $('#rating-star').html("");

                window.location.href = "{{ route('front.product',$products->slug) }}";
            }
        },
        error: function(error){

        }
        
    });
})


    
</script>
@endsection