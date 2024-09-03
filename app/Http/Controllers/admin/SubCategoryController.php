<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Categorie;
use App\Models\SubCategorie;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subCategory = SubCategorie::oldest();

        $keyword = $request->get('keyword');

        if(!empty($keyword)){
            $subCategory = $subCategory->where('name','like','%'.$keyword.'%');
        }

        $subCategory = $subCategory->with('categoryName')->paginate(5);

        return view('admin.sub-categories.allsubcategory',['data' => $subCategory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Categorie::get();

        return view('admin.sub-categories.create',['data' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'status' => 'required|int',
        ]);

        $slug = Str::slug($request->name,'-');

        $category = SubCategorie::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
            'show_home' => $request->show_home,
        ]);

        return redirect()->route('subcategory.index')->with('status','This Sub_Category Added Successfully');
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
        $subCategory = SubCategorie::find($id);

        if(empty($subCategory)){
            return redirect()->route('delete','This Id Record Is Not Found');
        }

        $category = Categorie::get();

        // $data['categories'] = $category;
        // $data['subcategories'] = $subCategory;

        return view('admin.sub-categories.edit',['categories' => $category, 'subcategories' => $subCategory]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'status' => 'required|int',
        ]);

        $slug = Str::slug($request->name,'-');

        $category = SubCategorie::where('id',$id)->Update([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
            'show_home' => $request->show_home,
        ]);

        return redirect()->route('subcategory.index')->with('status','This Sub_Category Updated Successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategorie::find($id);

        if(empty($subCategory)){
            return redirect()->route('delete','This Id Record Is Not Found');
        }

        $subCategory->delete();

        return redirect()->route('subcategory.index')->with('delete','This Sub Category Has Been Deleted Successfully');
    }
}
