<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategorie;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('product_images')->oldest();
        $keyword = $request->get('keyword');

        if(!empty($keyword)){

            $products = $products->where('title','like','%'.$keyword.'%');
        }
        $products = $products->paginate(5);
        // return $products;
        return view('admin.products.all_product',['products' => $products]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::get();
        $brands = Brand::get();
        return view('admin.products.create',['brands' => $brands,'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'image_lg' => 'required|mimes:jpg,png,jpeg',
            'image_sm' => 'required|mimes:jpg,png,jpeg',
            'category' => 'required|numeric',
            'sku' => 'required|unique:products',
            'is_featured' => 'required|in:Yes,No',
            'track_qty' => 'required|in:Yes,No',
        ]);

        if(!empty($request->track_qty && $request->track_qty == 'Yes')){
            $request->validate([
                'qty' => 'required|numeric'
            ]);
        }

        // product image lg
        $image_lg = $request->file('image_lg');
        $newName_lg = time() . '_' . $image_lg->getClientOriginalName();
        $image_path_lg = $request->file('image_lg')->storeAs('product-images',$newName_lg,'public');

        // product image sm
        $image_sm = $request->file('image_sm');
        $newName_sm = time(). '_' .$image_sm->getClientOriginalName();
        $image_path_sm = $request->file('image_sm')->storeAs('product-images',$newName_sm,'public');



        $slug = Str::slug($request->title,'-');

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'slug' => $slug,
            'compare_price' => $request->compare_price,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty,
            'qty' => $request->qty,
            'status' => $request->status,
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'brand_id' => $request->brands,
            'is_featured' => $request->is_featured,
        ]);

        $product->product_images()->create([
            'product_image_lg' => $image_path_lg,
            'product_image_sm' => $image_path_sm,
        ]);

        return redirect()->route('products.index')->with('status','This Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $products = Product::with('product_images')->find($id);

        if(empty($products)){
            return redirect()->route('products.index');
        }

        $subCategory = SubCategorie::where('id',$products->sub_category_id)->get();

        $categories = Categorie::get();
        $brands = Brand::get();
        // return $products;
        return view('admin.products.edit_product',['products' => $products,'categories' => $categories,'brands' => $brands,'subcategories' => $subCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $product = Product::with('product_images')->find($id);

        $validate = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'image_lg' => 'required|mimes:jpg,png,jpeg',
            'image_sm' => 'required|mimes:jpg,png,jpeg',
            'category' => 'required|numeric',
            'sku' => 'required|unique:products',
            'is_featured' => 'required|in:Yes,No',
            'track_qty' => 'required|in:Yes,No',
        ]);

        if(!empty($request->track_qty && $request->track_qty == 'Yes')){
            $request->validate([
                'qty' => 'required|numeric'
            ]);
        }

        // Delete product image lg
         $image_path_lg = public_path('storage/') . $product->product_images->product_image_lg;
        if(file_exists($image_path_lg)){
            @unlink($image_path_lg);
        }

        // Delete product image sm
        $image_path_sm = public_path('storage/') . $product->product_images->product_image_sm;
        if(file_exists($image_path_sm)){
            @unlink($image_path_sm);
        }



        // product image lg
        $image_lg = $request->file('image_lg');
        $newName_lg = time() . '_' . $image_lg->getClientOriginalName();
        $image_path_lg = $request->file('image_lg')->storeAs('product-images',$newName_lg,'public');

        // product image sm
        $image_sm = $request->file('image_sm');
        $newName_sm = time(). '_' .$image_sm->getClientOriginalName();
        $image_path_sm = $request->file('image_sm')->storeAs('product-images',$newName_sm,'public');



        $slug = Str::slug($request->title,'-');

         $product->where('id',$id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'slug' => $slug,
            'compare_price' => $request->compare_price,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty,
            'qty' => $request->qty,
            'status' => $request->status,
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'brand_id' => $request->brands,
            'is_featured' => $request->is_featured,
        ]);

        $product->product_images()->update([
            'product_image_lg' => $image_path_lg,
            'product_image_sm' => $image_path_sm,
        ]);

        return redirect()->route('products.index')->with('status','This Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::with('product_images')->find($id);

        if(empty($products)){
            return redirect()->route('products.index')->with('delete','Product Not Found');
        }

        // Delete product image lg
         $image_path_lg = public_path('storage/') . $products->product_images->product_image_lg;
        if(file_exists($image_path_lg)){
            @unlink($image_path_lg);
        }

        // Delete product image sm
        $image_path_sm = public_path('storage/') . $products->product_images->product_image_sm;
        if(file_exists($image_path_sm)){
            @unlink($image_path_sm);
        }

        $products->delete();
        $products->product_images()->delete();

        return redirect()->route('products.index')->with('delete','This Product Item Deleted Successfully');

    }
}
