<?php

namespace App\Http\Controllers;
use App\ClassEquipment;
use App\Category;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    //
    public function class_equipment ()
    {
        $class_equipments = ClassEquipment::with('category')->get();
        $categories = Category::get();
        return view('class_equipments',
        array(
            'subheader' => 'Equipment Class',
            'header' => "Settings",
            'class_equipments' => $class_equipments,
            'categories' => $categories,
        ));
    }

    public function new_class(Request $request)
    {
        $this->validate($request, [
            'class_code' => 'unique:class_equipments',
        ]);
        $new_class = new ClassEquipment;
        $new_class->class_code = $request->class_code;
        $new_class->class_description = $request->class_description;
        $new_class->category_id = $request->equipment_category;
        $new_class->save();
        $request->session()->flash('status','Class successfully created');
        return back();
    }

    public function deactivate_class(Request $request)
    {
        $class = ClassEquipment::where('id',$request->id)->first();
        $class->status = 1;
        $class->save();

        return "success";
        // return $brand;

    }
    public function activate_class(Request $request)
    {
        $class = ClassEquipment::where('id',$request->id)->first();
        $class->status = "";
        $class->save();

        return "success";
        // return $brand;

    }
    public function edit_class(Request $request,$id)
    {
        $this->validate($request, [
            'class_code' => 'unique:class_equipments,class_code,' . $id,
        ]);

        $class = ClassEquipment::where('id',$id)->first();
        $class->class_code = $request->class_code;
        $class->class_description = $request->class_description;
        $class->category_id = $request->equipment_category;
        $class->save();
        $request->session()->flash('status','Successfully updated');
        return back();
    }
}
