<?php

namespace App\Http\Controllers;
use App\Brand;
use App\AuditLog;
use Illuminate\Http\Request;
use URL;
class BrandController extends Controller
{
    //

    public function brands()
    {

        $brands = Brand::get();
        return view('brands',
        array(
            'subheader' => 'Brands',
            'header' => "Settings",
            'brands' => $brands,
        ));
    }

    public function new_brand(Request $request)
    {
        $this->validate($request, [
            'brand_name' => 'unique:brands',
        ]);

        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        if($request->hasFile('file'))
        {
            $attachment = $request->file('file');
            $original_name = $attachment->getClientOriginalName();
            $name = time().'_'.$attachment->getClientOriginalName();
            $attachment->move(public_path().'/brand_image/', $name);
            $file_name = '/brand_image/'.$name;
            $brand->logo = $file_name;
        }
        $brand->save();
        $request->session()->flash('status','Successfully created');
        return back();
        
    }

    public function edit_brand(Request $request,$id)
    {
        // dd($request->all());
        $this->validate($request, [
            'brand_name' => 'unique:brands,brand_name,' . $id,
        ]);
        // dd($id);
        $brand = Brand::where('id',$id)->first();

        $audit_log = new AuditLog;
        $audit_log->user_id = auth()->user()->id;
        $audit_log->table_name = "Brands";
        $audit_log->table_id = $id;
        $audit_log->previous_data = $brand;

        $brand->brand_name = $request->brand_name;
        $brand->save();
        $audit_log->after_data = $brand;
        $audit_log->action = "Edit";
        $audit_log->save();
        $request->session()->flash('status','Successfully updated');
        return back();
        
    }
        

    public function deactivate_brand(Request $request)
    {
        $brand = Brand::where('id',$request->id)->first();
        $brand->status = 1;
        $brand->save();

        return $request;
        // return $brand;

    }
    public function activate_brand(Request $request)
    {
        $brand = Brand::where('id',$request->id)->first();
        $brand->status = "";
        $brand->save();

        return $request;
    }
}
