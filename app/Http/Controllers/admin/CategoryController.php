<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Categorie::oldest();

        $keyword = $request->get('keyword');

        if(!empty($keyword)){
            $categories = $categories->where('name','like','%'.$keyword.'%');
        }

        $categories = $categories->paginate(5);

        return view('admin.categories.allcategory',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg',
        ]);

        #images
        
        $file = $request->file('photo');
        $newName = time() . '.' . $file->extension();
        $path = $request->file('photo')->storeAs('categoryImage',$newName,'public');

        
        $slug = Str::slug($request->name,'-');

        $category = Categorie::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
            'image' => $path,
            'show_home' => $request->showHome,
        ]);

        return redirect()->route('category.index')->with('status','This Category Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Categorie::find($id);

        if(empty($categories)){
            return redirect()->route('category.index');
        }

        return view('admin.categories.edit',['category' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Categorie::find($id);
        if(empty($category)){
            return redirect()->back()->with('delete','category not found');
        }
        $validate = $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $slug = Str::slug($request->name,'-');

        if(empty($request->photo)){

            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
                'show_home' => $request->showHome,
            ]);
            return redirect()->route('category.index')->with('status','This Category Updated Successfully');

        }else{
            #delete image
            $image_path = public_path('storage/') . $category->image;
            if(file_exists($image_path)){
                @unlink($image_path);
            }

            #images      
            $file = $request->file('photo');
            $newName = time() . '.' . $file->extension();
            $path = $request->file('photo')->storeAs('categoryImage',$newName,'public');

            

            #update images
            
            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
                'image' => $path,
                'show_home' => $request->showHome,
            ]);

            return redirect()->route('category.index')->with('status','This Category Updated Successfully');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categorie::find($id);

        $category->delete();

        $image_path = public_path('storage/'). $category->image;

        if(file_exists($image_path)){
            @unlink($image_path);
        }

        return redirect()->route('category.index')->with('delete','Category Has Been Deleted Successfully');
    }
}
