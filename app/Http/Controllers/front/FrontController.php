<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\ContactEmail;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index()
    {
        $featuredProduct = Product::with('product_images')->where('is_featured','Yes')->where('status',1)->limit(8)->get();

        $latestProduct = Product::with('product_images')->orderBy('id','DESC')->where('status',1)->limit(8)->get();  

        $data['featuredProduct'] = $featuredProduct;
        $data['latestProduct'] = $latestProduct;

        return view('front.home',$data);
    }

    public function addToWishlist(Request $request)
    {
        // check user login or not
        if(Auth::check() == false){
            session(['url.intended' => url()->previous()]);
            
            return response()->json([
                'status' => false
            ]);
        }

        // check product exists in product table
        $product = Product::find($request->id);
        if(empty($product)){
            return response()->json([
                'status' => true,
                'message' => 'Porduct Not Found!',
            ]);
        }

        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => $product->title.' Added To Wishlist',
        ]);
    }

    // display page in dynimic
    public function page($slug){

        $page = Page::where('slug',$slug)->first();

        if($page == null){
            abort(404);
        }
        return view('front.page',['page' => $page]);

    }

    public function sendContactEmail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10',
        ]);

        if($validator->passes()){

            // send email 
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'mail_subject' => 'You have received a contact email',
            ];

            $adminEmail = 'bijoyshaha38@gmail.com';

            Mail::to($adminEmail)->send(new ContactEmail($mailData));

            Session()->flash('success','Thanks for contacting us, we will get back to you soon');
            
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
}
