<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function new_category(Request $request)
    {

        $this->validate($request, [
            'category_code' => 'unique:categories',
        ]);
        $new_category = new Category;
        $new_category->category_code = $request->category_code;
        $new_category->equipment = $request->equipment_class_description;
        $new_category->save();
        $request->session()->flash('status','Category successfully created');
        return back();

    }
    public function deactivate_category(Request $request)
    {
        $category = Category::where('id',$request->id)->first();
        $category->status = 1;
        $category->save();

        return "success";
        // return $brand;
    }
    public function activate_category(Request $request)
    {
        $category = Category::where('id',$request->id)->first();
        $category->status = "";
        $category->save();

        return "success";
        // return $brand;
    }

    public function edit_category(Request $request,$id)
    {
        $this->validate($request, [
            'category_code' => 'unique:categories,category_code,' . $id,
        ]);

        $new_category = Category::where('id',$id)->first();
        $new_category->category_code = $request->category_code;
        $new_category->equipment = $request->equipment_class_description;
        $new_category->save();
        $request->session()->flash('status','Successfully updated');
        return back();
    }
}
