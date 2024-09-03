<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\SubCategorie;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subcategorySlug = null)
    {
        $categories = Categorie::with('sub_category')
                                ->orderBy('name','ASC')
                                ->where('status',1)
                                ->get();

        $brands = Brand::orderBy('name','ASC')
                        ->where('status',1)
                        ->get();

         $products = Product::with('product_images')
                            ->where('status',1);

        $categorySelect = '';
        $SubcategorySelect = '';
        $brandArrary = [];
        // filter product
        
        // sorting to category product
        if(!empty($categorySlug)){
            $category = Categorie::where('slug', $categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelect = $category->id;
        }

        // sorting to sub category products
        if(!empty($subcategorySlug)){
            $subcategory = SubCategorie::where('slug', $subcategorySlug)->first();
            $products = $products->where('sub_category_id',$subcategory?->id);
            $SubcategorySelect = $subcategory->id;
        }

        // sorting to brand product
        if(!empty($request->get('brand'))){
            $brandArrary = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id',$brandArrary);
        }

        
        // sorting to price product
        if($request->get('price_max') != '' && $request->get('price_min') != ''){

            if($request->get('price_max') == 1000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')),100000]);
            }else{
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }
        } 

        // product filtter search
        if(!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');
        }


        //sorting to select box product
        if($request->get('sort') != ''){
            if($request->get('sort') == 'latest'){
                $products = $products->orderBy('id','DESC');
            }else if($request->get('sort') == 'price_asc'){
                $products = $products->orderBy('price','ASC');
            }else{
                $products = $products->orderBy('price','DESC');
            }
         }else{
            $products = $products->orderBy('id','DESC');
         } 

         $products = $products->paginate(6);

        return view('front.shop',['categories'=> $categories,
             'brands'=> $brands,
             'products'=>$products,
             'categorySelect'=>$categorySelect,
             'SubcategorySelect'=>$SubcategorySelect,
             'brandArrary' => $brandArrary,
             'delete' => (intval($request->get('price_max')) == 0 ? 1000 : intval($request->get('price_max'))),
             'price_min' => intval($request->get('price_min')),
             'price_max' => intval($request->get('price_max')),
             'sort' => $request->get('sort'),
             ]);
        
        
    }


    public function product($slug)
    {
        $products = Product::withSum('product_ratings','rating')->withCount('product_ratings')->with(['product_images','product_ratings'])->where('slug',$slug)->first();

        // "product_ratings_sum_rating": 8,
        // "product_ratings_count": 2,
        // return $products;
        if($products == null){
            abort(404);
        }

        $related_products = [];
        if(!empty($products->related_product)){
            $product_id = explode(',',$products->related_product);

            $related_products = Product::with('product_images')->whereIn('id',$product_id)->orderBy('id','desc')->get();
         }

        // calculate avarage rating
        $avgRating = '00.00';
        $avgRatingPer = '00.00';
        if($products->product_ratings_count > 0){
            $avgRating = number_format(($products->product_ratings_sum_rating/$products->product_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

         $data['related_products'] = $related_products;
         $data['products'] = $products;
         $data['avgRating'] = $avgRating;
         $data['avgRatingPer'] = $avgRatingPer;
        // return $products;
        return view('front.product',$data);
    }

    public function saveRating(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|email',
            'content' => 'required|min:10',
            'rating' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $count = ProductRating::where('email',$request->email)->count();
        if($count > 0){
            session()->flash('error','Your are Allready Rating Product this email');
            return response()->json([
                'status' => true,
                'message' => 'You have allerady ratings'
            ]);
        }

        $rating = new ProductRating();
        $rating->product_id = $id;
        $rating->username = $request->name;
        $rating->email = $request->email;
        $rating->comment = $request->content;
        $rating->rating = $request->rating;
        $rating->status = 0;
        $rating->save();

        session()->flash('success','Thanks for your Ratings');
        return response()->json([
            'status' => true,
            'message' => 'Thanks for your ratings'
        ]);


    }
}
