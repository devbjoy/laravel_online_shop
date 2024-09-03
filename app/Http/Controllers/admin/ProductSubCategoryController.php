<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategorie;

class ProductSubCategoryController extends Controller
{
    public function getSubCat(Request $request)
    {
        if(!empty($request->category_id)){

            $subCategory = SubCategorie::where('category_id',$request->category_id)->orderBy('name','ASC')->get();

            return response()->json([
                'status' => true,
                'subCategory' => $subCategory,
            ]);
        }else{
            return response()->json([
                'status' => true,
                'subCategory' => [],
            ]);
        }
    }
}
