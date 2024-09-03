<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class ProductRatingController extends Controller
{
    public function index(){
        $ratings = ProductRating::with('product_ratings')->orderBy('id','desc')->paginate(10);
        // return $ratings;
        $data['ratings'] = $ratings;
        return view('admin.product-rating.list',$data);
    }

    public function changePorductRating(Request $request)
    {
        $productRating = ProductRating::find($request->id);
        $productRating->status = $request->status;
        $productRating->save();

        session()->flash('success','Product Rating status has been change');
        return response()->json([
            'status' => true,
        ]);
    }
}
