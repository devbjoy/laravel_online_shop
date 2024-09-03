<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::oldest();

        $keyword = $request->get('keyword');

        if(!empty($keyword)){
            $brands = $brands->where('name','like','%'.$keyword.'%');
        }

        $brands = $brands->paginate(5);
        return view('admin.brands.all_brands',['data' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required|int',
        ]);

        // check the country all ready exists
        

        $slug = Str::slug($request->name,'-');

        $brands = Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('status','This Brands Data Inserted Successfully');
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
        $brands = Brand::find($id);

        if(empty($brands)){
            return redirect()->route('brands.index')->with('delete','Record Not Found');
        }

        return view('admin.brands.edit',['brands' => $brands]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required|int',
        ]);

        $slug = Str::slug($request->name,'-');

        $brands = Brand::where('id',$id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('status','This Brands Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brands = Brand::find($id);
        
        if(empty($brands)){
            return redirect()->route('brands.index')->with('delete','Record Not Found');
        }

        $brands->delete();

        return redirect()->route('brands.index')->with('delete','This Brands Data Has Been Deleted Successfully');
    }
}
