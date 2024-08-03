<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\SubCategorie;
use App\Models\Brand;
use App\Models\Product;

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
        // if($request->get('price_max') != '' && $request->get('price_min') != ''){

        //     if($request->get('price_max') == 1000){
        //         $products = $products->whereBetween('price',[intval($request->get('price_min')),100000]);
        //     }else{
        //         $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
        //     }
        // } 


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
            //  'delete' => (intval($request->get('price_max')) == 0 ? 1000 : intval($request->get('price_max'))),
            //  'price_min' => intval($request->get('price_min')),
             'sort' => $request->get('sort'),
             ]);
        
        
    }


    public function product($slug)
    {
        $products = Product::with('product_images')->where('slug',$slug)->first();

        if($products == null){
            abort(404);
        }
        // return $products;
        return view('front.product',['products' => $products]);
    }
}
