<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\ShippingCharge;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);
        if($product == null){
            return response()->json([
                'status' => false,
                'message' => 'product not found',
            ]);
        }

        if(Cart::count() > 0){

            $productExists = false;
            $cartContent = Cart::content();

            foreach($cartContent as $item){
                if($item->id == $product->id){
                    $productExists = true;
                }
            }

            if($productExists == false){

                Cart::add($product->id, $product->title, 1, $product->price, 
                ['productImage' => (!empty($product->product_images->product_image_lg)) ? $product->product_images->product_image_lg : '']);
                $status = true;
                $message = $product->title.' added in cart';

            }else{

                $status = false;
                $message = $product->title.' product allready exists';

            }

        }else{

            Cart::add($product->id, $product->title, 1, $product->price, 
            ['productImage' => (!empty($product->product_images->product_image_lg)) ? $product->product_images->product_image_lg : '']);
            $status = true;
            $message = $product->title.' added in cart';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);

        // Cart::add();
    }

    public function cart()
    {
        $cartContent = Cart::content();
        //  return $cartContent;
        $data['cartContent'] = $cartContent;

        return view('front.cart',$data);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $productInfo = Cart::get($rowId);
        $product = Product::find($productInfo->id);

        if($product->track_qty == 'Yes'){
            if($qty <= $product->qty){
                Cart::update($rowId,$qty);
                $status = true;
                $message = 'Cart Updated Successfully';
                session()->flash('success',$message);
            }else{
                $status = false;
                $message = "Requested qty(' $qty ') Not Avaliable in Stock";
                session()->flash('error',$message);
            }
        }else{
            Cart::update($rowId,$qty);
            $status = true;
            $message = 'Cart Updated Successfully';
            session()->flash('success',$message);
        }

        
        return response()->json([
            'status' => $status,
            'message' => $message,        
        ]);
    }

    public function deleteCartItem(Request $request)
    {
        $productInfo = Cart::get($request->rowId);

        if($productInfo != null){
            Cart::remove($request->rowId);
            $message = 'Cart Item Deleted Successfully';
            $status = true;
            session()->flash('success',$message);
        }else{
            $message = 'No Item Avaliable In This Cart';
            $status = false;
            session()->flash('error',$message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function checkout()
    {
        $discount = 0;
    
        if(Cart::count() == 0){
            return redirect()->route('front.cart');
        }

        if(Auth::check() == false){
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('account.login');
        }

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        session()->forget('url.intended');
        $countries = Country::orderBy('name','asc')->get(); 

        $subTotal = Cart::subtotal(2,'.','');
        // apply discount here
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }

            
        }

        

        // total shipping price
        if($customerAddress != ''){
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id',$userCountry)->first();

            $totalQty = 0;
            $shipping_amount = 0;
            $grandTotal = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            } 
            if($shippingInfo != null){
                $shipping_amount = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal-$discount) + $shipping_amount;

            }else{
                $otherAmount = ShippingCharge::where('country_id','rest_of_the_world')->first();
                $shipping_amount = $totalQty * $otherAmount->amount;
                $grandTotal = ($subTotal-$discount) + $shipping_amount;
            }
        }else{
            $shipping_amount = 0;
            $grandTotal = ($subTotal-$discount);
        }
        

        $data['countries'] = $countries;
        $data['customerAddress'] = $customerAddress;
        $data['shipping_amount'] = $shipping_amount;
        $data['grandTotal'] = $grandTotal;
        $data['discount'] = $discount;

        return view('front.checkout',$data);
    }
    // public function checkout()
    // {
    //     if(Cart::count() == 0){
    //         return redirect()->route('front.cart');
    //     }

    //     if(Auth::check() == false){
    //         if(!session()->has('url.intended')){
    //             session(['url.intended' => url()->current()]);
    //         }
    //         return redirect()->route('account.login');
    //     }

    //     $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();

    //     $userCountry = (empty($customerAddress->country_id)) ? 'rest_of_the_world' : $customerAddress->country_id;
        
    //     $shippingInfo = ShippingCharge::where('country_id',$userCountry)->first();
    //     // return $shippingInfo;
    //     session()->forget('url.intended');

    //     // total shipping price
    //     if($shippingInfo != ''){

    //         $totalQty = 0;
    //         $shipping_amount = 0;
    //         $grandTotal = 0;
    //         foreach(Cart::content() as $item){
    //             $totalQty += $item->qty;
    //         } 
    //         $shipping_amount = $shippingInfo->amount * $totalQty;

    //         $grandTotal = Cart::subtotal(2,'.','') + $shipping_amount;


    //     }else{

    //         $resOfWorld = ShippingCharge::where('country_id','rest_of_the_world')->first();
    //         $totalQty = 0;
    //         $shipping_amount = 0;
    //         $grandTotal = 0;
    //         foreach(Cart::content() as $item){
    //             $totalQty += $item->qty;
    //         } 
    //         $shipping_amount = $resOfWorld->amount * $totalQty;

    //         $grandTotal = Cart::subtotal(2,'.','') + $shipping_amount;
    //     }
        
       
    //     $countries = Country::orderBy('name','asc')->get(); 

    //     $data['countries'] = $countries;
    //     $data['customerAddress'] = $customerAddress;
    //     $data['shipping_amount'] = $shipping_amount;
    //     $data['grandTotal'] = $grandTotal;
    //     return view('front.checkout',$data);
    // }

    public function checkoutProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'please file the all input value',
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        // store customer address to database
        CustomerAddress::updateOrCreate(
            ['user_id'=> $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country_id' => $request->country,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'apartment' => $request->apartment,
                'zip' => $request->zip,     
            ]
        );

        if($request->payment_method == 'cod'){

            $subtotal = Cart::subtotal(2,'.','');
            $shiping = 0;
            $discount = 0;
            $promoCode = '';

            // apply discount here
            if(session()->has('code')){
                $code = session()->get('code');
                if($code->type == 'percent'){
                    $discount = ($code->discount_amount/100)*$subtotal;
                }else{
                    $discount = $code->discount_amount;
                }
                $promoCode = $code->code;
            }

            // calculate shipping and grand total
            $shippingInfo = ShippingCharge::where('country_id',$request->country)->first();

            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }
            
            if($shippingInfo != null){

                $shiping = $totalQty * $shippingInfo->amount;
                $grand_total = ($subtotal-$discount) + $shiping;

            }else{

                $otherAmount = ShippingCharge::where('country_id','rest_of_the_world')->first();

                $shiping = $totalQty * $otherAmount->amount;
                $grand_total = ($subtotal-$discount)  + $shiping;
            }

            $order = new Order;

            $order->user_id = $user->id;
            $order->subtotal = $subtotal;
            $order->shipping = $shiping;
            $order->discount = $discount;
            $order->grand_total = $grand_total;
            $order->coupon_code = $promoCode;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->country_id = $request->country;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->apartment = $request->apartment;
            $order->notes = $request->order_notes;
            $order->zip = $request->zip;

            $order->save();

           
            // store order item in database
            foreach(Cart::content() as $item){
                $order_item = new OrderItem;

                $order_item->order_id = $order->id;
                $order_item->product_id = $item->id;
                $order_item->name = $item->name;
                $order_item->price = $item->price;
                $order_item->qty = $item->qty;
                $order_item->total = $item->price*$item->qty;
                $order_item->save();

                // update the prduct quntity
                $currentPorduct = Product::find($item->id);
                if($currentPorduct->track_qty == 'Yes'){
                    $currentQty = $currentPorduct->qty;
                    $newqty = $currentQty - $item->qty;
                    $currentPorduct->qty = $newqty;
                    $currentPorduct->save();
                }
            }

             // send mail from order
             orderEmail($order->id);

            Cart::destroy();
            session()->forget('code');
            session()->flash('success','Your Order has been Successfully Submited |');
            return response()->json([
                'status' => true,
                'message' => 'Your Order has been Successfully Submited',
                'orderId' => $order->id,
            ]);
            

        }else{
            session()->flash('success','please select your (second) order method');
            return response()->json([
                'status' => false,
                'message' => 'please select your order method',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function thanks($id){
        return view('front.thank',['id' => $id]);
    }

    public function getOrderSummery(Request $request)
    {
        $subTotal = Cart::subtotal(2,'.','');
        $discount = 0;
        $discountString = '';
        // apply discount here
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
            $discountString = '<div class="mt-4" id="cuopon-code">
                            <strong>'.session()->get('code')->code.'</strong>                          
                            <a href="javascript::void(0)" class="btn btn-sm btn-danger ml-5" id="remove-discount"><i class="fa fa-times"></i></a>
                        </div>';
        }

        if($request->country_id > 0){
            $shippingInfo = ShippingCharge::where('country_id',$request->country_id)->first();

            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }
            
            if($shippingInfo != null){
                $shipping_amount = $totalQty * $shippingInfo->amount;
                $grand_total = ($subTotal-$discount) + $shipping_amount;

                return response()->json([
                    'status' => true,
                    'shippingAmount' => number_format($shipping_amount,2),
                    'discount' => number_format($discount,2),
                    'grandTotal' => number_format($grand_total,2),
                    'discountString' => $discountString,
                ]);
                
            }else{

                $otherAmount = ShippingCharge::where('country_id','rest_of_the_world')->first();

                $shipping_amount = $totalQty * $otherAmount->amount;
                $grand_total = ($subTotal-$discount) + $shipping_amount;

                return response()->json([
                    'status' => true,
                    'shippingAmount' => number_format($shipping_amount,2),
                    'discount' => number_format($discount,2),
                    'grandTotal' => number_format($grand_total,2),
                    'discountString' => $discountString,
                ]);

            }


        }else{
            return response()->json([
                'status' => true,
                'shippingAmount' => number_format(0,2),
                'discount' => number_format($discount,2),
                'grandTotal' => number_format(($subTotal-$discount),2),
                'discountString' => $discountString,
            ]);
        }
    }
    // apply discount coupone code function
    public function applyDiscount(Request $request)
    {
        $code = DiscountCoupon::where('code',$request->code)->first();

        // check the copon code is not empty
        if($code == null){
            return response()->json([
                'status' => false,
                'message' => 'Coupon Code Not Found !'
            ]);
        }

        // check if coupon start date is valid or not
        $now = Carbon::now();

        if($code->starts_at != null){
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);
            if($now->lt($start_date)){
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon Code Start Date Will be Latter'
                ]);
            }
        }

        // check if coupon expire date is valid or not
        if($code->expires_at != null){
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);
            if($now->gt($end_date)){
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon Code Date will be expires'
                ]);
            }
        }

        // check the coupon code is valide
        if($code->max_uses > 0){
            $useCoupon = Order::where('coupon_code',$code->code)->count();
            if($useCoupon >= $code->max_uses){
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon Code Max Uses Allready Used'
                ]);
            }
        }

        // check the user alerady use this coupon code
        if($code->max_uses_user > 0){
            $useCouponUse = Order::where(['coupon_code'=>$code->code,'user_id'=>Auth::user()->id])->count();
            if($useCouponUse >= $code->max_uses_user){
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon code allready used you'
                ]);
            }
        }

        // check the min amount less then subtotal
        if($code->min_amount > 0){
            $subTotal = Cart::subtotal(2,'.','');
            if($subTotal < $code->min_amount){
                return response()->json([
                    'status' => false,
                    'message' => 'Your min amount must be $'.$code->min_amount.'.',
                ]);
            }
        }

        session()->put('code',$code);
        return $this->getOrderSummery($request);
    }

    // delete discount function
    public function deleteDiscount(Request $request)
    {
        Session()->forget('code');
        return $this->getOrderSummery($request);
    }

    
}
