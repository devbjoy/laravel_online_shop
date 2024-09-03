<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function register()
    {
        return view('front.account.register');
    }

    public function registerProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);

        if($validator->passes()){

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);

            $user->save();

            session()->flash('success','You have been register successfully');
            return response()->json([
                'status' => true,
                'data' => 'You have been register successfully',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');

            }else{

                return redirect()->route('account.login')->withInput($request->only('email'))->with('error','Either Email & Password is Incurrect');
            }
        }else{
            
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);
        $address = CustomerAddress::where('user_id',Auth::user()->id)->first();
        $countries = Country::orderBy('name','asc')->get();

        $data['countries'] = $countries;
        $data['user'] = $user;
        $data['address'] = $address;

        return view('front.account.profile',$data);
    }
    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required'
        ]);

        if($validator->passes()){

            $user = User::find($userId);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Your Profile Data Updated Successfully',
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_id' => 'required|numeric',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if($validator->passes()){

            CustomerAddress::updateOrCreate(
                ['user_id'=> Auth::user()->id],
                [
                    'user_id' => Auth::user()->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_id' => $request->country_id,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'apartment' => $request->apartment,
                    'zip' => $request->zip,     
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Your Address Updated Succssfully',
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function orders()
    {
        $data[] = '';
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();

        $data['orders'] = $orders;
        return view('front.account.order',$data);
    }

    public function orderDetails($id)
    {
        $data[] = '';

        $order = Order::where(['user_id' => Auth::user()->id,'id' => $id])->first();

        $orderItem = OrderItem::where('order_id',$id)->get();

        $data['order'] = $order;
        $data['orderItems'] = $orderItem;

        return view('front.account.order-details',$data);
    }

    public function wishlist()
    {
        $wishlists = Wishlist::with('product.product_images')->where('user_id',Auth::user()->id)->get();
        // return $wishlists;
        $data['wishlists'] = $wishlists;
        return view('front.account.wishlist',$data);
    }

    public function deleteWishlistPorduct(Request $request)
    {
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();

        if($wishlist == null){
            return response()->json([
                'status' => true,
                'message' => 'There are no product found'
            ]);
        }else{
            Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Wishlist product deleted successfully',
            ]);
        }
    }

    public function showChangePasswordFrom(){
        return view('front.account.change-password');
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);


        if($validator->passes()){

            $user = User::find(Auth::user()->id);

            if(!Hash::check($request->old_password,$user->password)){
                Session()->flash('error','Your Password is Incurrect, Please try again');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            Session()->flash('success','Your Password change successfully');
            return response()->json([
                'status' => true,
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function forgotPassword()
    {
        return view('front.account.forgot-password');
    }

    public function processFrogotPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);

        if($validator->fails()){
            return redirect()->route('front.forgotPassword')->withInput()->withErrors($validator);
        };

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $user = User::where('email',$request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have request to reset your password',
        ];
        
        // send email forgoting password
        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()->route('front.forgotPassword')->with('success','Please check your inbox to reset password');

    }

    public function resetPassword($token)
    {
        $tokenExist = DB::table('password_reset_tokens')->where('token',$token)->first();
        if($tokenExist == null){
            return redirect()->route('front.forgotPassword')->with('error','Invalid Request');
        }

        return view('front.account.reset-password',['token' => $token]);
    }

    public function processResetPassword(Request $request)
    {
        $token = $request->token;
        $tokenObj = DB::table('password_reset_tokens')->where('token',$token)->first();

        if($tokenObj == null){
            return redirect()->route('front.forgotPassword')->with('error','Invalid Request');
        }

        $validator = Validator::make($request->all(),[
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return redirect()->route('front.resetPassword',$token)->withInput()->withErrors($validator);
        };

        $user = User::where('email',$tokenObj->email)->first();

        DB::table('password_reset_tokens')->where('email',$user->email)->delete();

        User::where('id',$user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('account.login')->with('success','Your Password has been successfully reset');
        
    }
}
