<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class FrontController extends Controller
{
    public function index()
    {
        $featuredProduct = Product::with('product_images')
                         ->where('is_featured','Yes')
                         ->where('status',1)
                         ->limit(8)
                         ->get();

        $latestProduct = Product::with('product_images')
                         ->orderBy('id','DESC')
                         ->where('status',1)
                         ->limit(8)
                         ->get();  
        $data['featuredProduct'] = $featuredProduct;
        $data['latestProduct'] = $latestProduct;
        return view('front.home',$data);
    }
}
