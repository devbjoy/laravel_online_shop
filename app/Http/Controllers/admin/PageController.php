<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = Page::orderBy('id','desc');

        if(!empty($request->get('keyword'))){
            $pages = $pages->where('name','like','%'.$request->get('keyword').'%');
            $pages = $pages->orWhere('slug','like','%'.$request->get('keyword').'%');
        }

        $pages = $pages->paginate(10);
        $data['pages'] = $pages;
        return view('admin.pages.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        if($validate){
            $slug = Str::slug($request->name,'-');

            $page = new Page();
            $page->name = $request->name;
            $page->slug = $slug;
            $page->content = $request->content;
            $page->save();

            return redirect()->route('pages.index')->with('success','Page Create Successfully');
        };
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
        $page = Page::find($id);

        if($page == null){
            return redirect()->route('pages.index')->with('error','page not found !');
        }
        $data['page'] = $page;
        return view('admin.pages.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = Page::find($id);

        if($page == null){
            return redirect()->route('pages.index')->with('error','page not found !');
        }

        $validate = $request->validate([
            'name' => 'required',
        ]);

        if($validate){
            $slug = Str::slug($request->name,'-');

            $page->name = $request->name;
            $page->slug = $slug;
            $page->content = $request->content;
            $page->save();

            return redirect()->route('pages.index')->with('success','Page Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);

        if($page == null){
            return redirect()->route('pages.index')->with('error','pages not found !');
        }

        $page->delete();
        return redirect()->route('pages.index')->with('success','Pages Delted Successfully');
    }
}
