@extends('front.layouts.layout')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form action="" name="checkout_form" method="POST" id="checkout_form">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" 
                                        placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" 
                                        placeholder="Last Name" value="{{ (!empty($customerAddress) ? $customerAddress->last_name : '') }}">
                                        <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" 
                                        placeholder="Email" value="{{ (!empty($customerAddress) ? $customerAddress->email : '') }}">
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                            @if(!empty($countries))
                                            @foreach ($countries as $country)
                                            <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} 
                                                value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                            @endif                             
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" 
                                        placeholder="Address" class="form-control">{{ (!empty($customerAddress) ? $customerAddress->address : '') }}</textarea>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control" 
                                        placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress) ? $customerAddress->apartment : '') }}">
                                    </div>            
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" 
                                        placeholder="City" value="{{ (!empty($customerAddress) ? $customerAddress->city : '') }}">
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" 
                                        placeholder="State" value="{{ (!empty($customerAddress) ? $customerAddress->state : '') }}">
                                        <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" 
                                        placeholder="Zip" value="{{ (!empty($customerAddress) ? $customerAddress->zip : '') }}">
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="number" name="mobile" id="mobile" class="form-control" 
                                        placeholder="Mobile No." value="{{ (!empty($customerAddress) ? $customerAddress->mobile : '') }}">
                                        <p></p>
                                    </div>            
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" 
                                        placeholder="Order Notes (optional)" 
                                        class="form-control">{{ (!empty($customerAddress) ? $customerAddress->notes : '') }}</textarea>
                                    </div>            
                                </div>

                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                            @if (Cart::count() > 0)
                            @foreach (Cart::content() as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{ $item->name}} X {{ $item->qty }}</div>
                                <div class="h6">${{ $item->price * $item->qty}}</div>
                            </div>
                            @endforeach    
                            @endif
                            
                            
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{ Cart::subTotal() }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong id="discountAmount">${{ $discount }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="shippingAmount">${{ number_format($shipping_amount, 2) }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">${{ number_format($grandTotal, 2) }}</strong></div>
                            </div>                            
                        </div>
                    </div>

                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" id="discount-coupon-from" class="form-control">
                        <button class="btn btn-dark" type="button" id="discount-button">Apply Coupon</button>
                    </div> 

                    <div id="discount-response-code">
                    @if(Session()->get('code'))
                        <div class="mt-4" id="cuopon-code">
                            <strong>{{ Session()->get('code')->code }}</strong>                          
                            <a href="javascript::void(0)" class="btn btn-sm btn-danger ml-5" id="remove-discount"><i class="fa fa-times"></i></a>
                        </div>
                    @endif
                    </div>
                    

                    <div class="card payment-form">                        
                        <h3 class="card-title h5 mb-3">Payment Details</h3>
                        <div>
                            <input checked type="radio" name="payment_method" id="payment_method_one" value="cod">
                            <label for="payment_method_one" class="form-check-label">COD</label>
                        </div>
                        <div>
                            <input type="radio" name="payment_method" id="payment_method_two" value="stripe">
                            <label for="payment_method_two" class="form-check-label">Stripe</label>
                        </div>
                        <div class="card-body p-0 d-none mt-3" id="payment_form_card">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="cvv_code" class="mb-2">CVV Code</label>
                                    <input type="text" name="cvv_code" id="cvv_code" placeholder="123" class="form-control">
                                </div>
                            </div>                        
                        </div> 
                        <div class="pt-4">
                            {{-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> --}}
                            <button type="submit" id="payNowButton" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>                       
                    </div>

                        
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('customJs')
    <script>
        $('#payment_method_one').click(function(){
            if($(this).is(':checked') == true){
                $('#payment_form_card').addClass('d-none');
            }
        })

        $('#payment_method_two').click(function(){
            if($(this).is(':checked') == true){
                $('#payment_form_card').removeClass('d-none');
            }
        })

        $("#checkout_form").submit(function(event){
            event.preventDefault();
            $("#payNowButton").prop("disabled",true);
            $.ajax({
                url: "{{ route('front.checkoutProcess') }}",
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(res){
                    $("#payNowButton").prop("disabled",false);
                    var errors = res.errors;
                    if(res.status == false){
                        if(errors.first_name){
                            $("#first_name").siblings('p').addClass('invalid-feedback').html(errors.first_name);
                            $("#first_name").addClass('is-invalid');
                        }else{
                            $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#first_name").removeClass('is-invalid');
                        }
                        if(errors.last_name){
                            $("#last_name").siblings('p').addClass('invalid-feedback').html(errors.last_name);
                            $("#last_name").addClass('is-invalid');
                        }else{
                            $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#last_name").removeClass('is-invalid');
                        }
                        if(errors.email){
                            $("#email").siblings('p').addClass('invalid-feedback').html(errors.email);
                            $("#email").addClass('is-invalid');
                        }else{
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }
                        if(errors.country){
                            $("#country").siblings('p').addClass('invalid-feedback').html(errors.country);
                            $("#country").addClass('is-invalid');
                        }else{
                            $("#country").siblings('p').removeClass('invalid-feedback').html('');
                            $("#country").removeClass('is-invalid');
                        }
                        if(errors.address){
                            $("#address").siblings('p').addClass('invalid-feedback').html(errors.address);
                            $("#address").addClass('is-invalid');
                        }else{
                            $("#address").siblings('p').removeClass('invalid-feedback').html('');
                            $("#address").removeClass('is-invalid');
                        }
                        if(errors.city){
                            $("#city").siblings('p').addClass('invalid-feedback').html(errors.city);
                            $("#city").addClass('is-invalid');
                        }else{
                            $("#city").siblings('p').removeClass('invalid-feedback').html('');
                            $("#city").removeClass('is-invalid');
                        }
                        if(errors.state){
                            $("#state").siblings('p').addClass('invalid-feedback').html(errors.state);
                            $("#state").addClass('is-invalid');
                        }else{
                            $("#state").siblings('p').removeClass('invalid-feedback').html('');
                            $("#state").removeClass('is-invalid');
                        }
                        if(errors.zip){
                            $("#zip").siblings('p').addClass('invalid-feedback').html(errors.zip);
                            $("#zip").addClass('is-invalid');
                        }else{
                            $("#zip").siblings('p').removeClass('invalid-feedback').html('');
                            $("#zip").removeClass('is-invalid');
                        }
                        if(errors.mobile){
                            $("#mobile").siblings('p').addClass('invalid-feedback').html(errors.mobile);
                            $("#mobile").addClass('is-invalid');
                        }else{
                            $("#mobile").siblings('p').removeClass('invalid-feedback').html('');
                            $("#mobile").removeClass('is-invalid');
                        }
                        // alert('Please Select Your Order Method');
                        // window.location.href = "{{ route('front.checkout') }}";
                    }else{
                        $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#first_name").removeClass('is-invalid');
                        $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#last_name").removeClass('is-invalid');
                        $("#email").siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');
                        $("#country").siblings('p').removeClass('invalid-feedback').html('');
                        $("#country").removeClass('is-invalid');
                        $("#address").siblings('p').removeClass('invalid-feedback').html('');
                        $("#address").removeClass('is-invalid');
                        $("#city").siblings('p').removeClass('invalid-feedback').html('');
                        $("#city").removeClass('is-invalid');
                        $("#state").siblings('p').removeClass('invalid-feedback').html('');
                        $("#state").removeClass('is-invalid');
                        $("#zip").siblings('p').removeClass('invalid-feedback').html('');
                        $("#zip").removeClass('is-invalid');
                        $("#mobile").siblings('p').removeClass('invalid-feedback').html('');
                        $("#mobile").removeClass('is-invalid');

                        window.location.href = '{{ url("/thanks/") }}/' + res.orderId;
                    }
                },
                error: function(jQXHR, exception){
                    console.log('something went worng');
                }
            })
        })

        // select country by shipping pirce
        $('#country').change(function(){
            $.ajax({
                url : '{{ route("front.getOrderSummery") }}',
                type: 'post',
                data : {country_id: $(this).val()},
                dataType: 'json',
                success : function(res){
                    if(res.status == true){
                        $("#shippingAmount").html('$'+res.shippingAmount);
                        $("#grandTotal").html('$'+res.grandTotal);
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

        // apply discount coupon code
        
        $('#discount-button').click(function(){
            $("#discount-button").prop("disabled",true);
            $.ajax({
                url: "{{ route('front.applyDiscount') }}",
                type: 'post',
                data: {code: $("#discount-coupon-from").val(), country_id: $("#country").val()},
                dataType: 'json',
                success: function(res){
                    $("#discount-button").prop("disabled",false);
                    if(res.status == true){
                        $("#shippingAmount").html('$'+res.shippingAmount);
                        $("#grandTotal").html('$'+res.grandTotal);
                        $("#discountAmount").html('$'+res.discount);
                        $("#discount-response-code").html(res.discountString);
                    }else{
                        $("#discount-response-code").html("<span class='text-danger mt-2'>"+res.message+"</span>");
                    }
                },
                error: function(err){
                    console.log(err)
                }
            })
        })

        // delete coupon session
        $('body').on('click','#remove-discount',function(){
            $.ajax({
                url: "{{ route('front.deleteDiscount') }}",
                type: 'post',
                data: {country_id: $("#country").val()},
                dataType: 'json',
                success: function(res){
                    if(res.status == true){
                        $("#shippingAmount").html('$'+res.shippingAmount);
                        $("#grandTotal").html('$'+res.grandTotal);
                        $("#discountAmount").html('$'+res.discount);
                        $("#cuopon-code").html('');
                    }
                },
                error: function(err){
                    console.log(err)
                }
            });
        });
    </script>
@endsection
