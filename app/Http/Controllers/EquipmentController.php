<?php

namespace App\Http\Controllers;
use App\EquipmentData;
use App\Company;
use App\RequestDeployment;
use App\InsuranceCompany;
use App\ClassEquipment;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    //
    public function equipments()
    {

        $equipments = EquipmentData::with('category','class','company','brand','insurance')->get();
        $brands = Brand::get();
        $companies = Company::get();
        $insurances = InsuranceCompany::get();
        $classes = ClassEquipment::with('category')->get();
        // dd($equipments);
        return view('equipments',
        array(
            'subheader' => 'Equipments',
            'header' => "Settings",
            'equipments' => $equipments,
            'companies' => $companies,
            'insurances' => $insurances,
            'classes' => $classes,
            'brands' => $brands,
        ));
    }
    public function new_equipment(Request $request)
    {
        // dd($request->all());
        
        $class = $request->equipment_category;
        
        $class_array = explode('-',$class);
        
        $class_id = $class_array[0];
        $oldest_data = equipmentData::where('class_id',$class_id)->orderBy('id','desc')->first();
        // dd($oldest_data);
        $this->validate($request, [
            'plate_number' => 'unique:equipment_datas',
            'engine_number' => 'unique:equipment_datas',
        ]);
        $equipment_id = 0;
        if($oldest_data == null)
        {   
            $equipment_id = $equipment_id + 1;
        }
        else
        {
            $equipment_id =  $oldest_data->equipment_number + 1 ;
        }
      
        $new_equipment = new EquipmentData;
        if($request->hasFile('file'))
        {
            $attachment = $request->file('file');
            $original_name = $attachment->getClientOriginalName();
            $name = time().'_'.$attachment->getClientOriginalName();
            $attachment->move(public_path().'/brand_image/', $name);
            $file_name = '/brand_image/'.$name;
            $new_equipment->image_path = $file_name; 
        }
        $class = $request->equipment_category;
        
        $class_array = explode('-',$class);
        
        $class_id = $class_array[0];
        $new_equipment->category_id  = $request->category_id;
        $new_equipment->class_id  = $class_id;
        $new_equipment->brand_id  = $request->brand;
        $new_equipment->equipment_number  = $equipment_id;
        $new_equipment->company_id  = $request->company;
        $new_equipment->plate_number  = $request->plate_number;
        $new_equipment->engine_number  = $request->engine_number;
        $new_equipment->registration_number  = $request->registration_number;
        $new_equipment->date_of_registration  = $request->registration_date;
        $new_equipment->date_of_expiration  = $request->registration_expiration;
        $new_equipment->insurance_policy_number  = $request->policy_number;
        $new_equipment->insurance_company_id  = $request->insurance;
        $new_equipment->insured_from  = $request->insured_from;
        $new_equipment->insured_to  = $request->insured_to;
        $new_equipment->remarks  = $request->remarks;
        $new_equipment->status  = "Operational";
        $new_equipment->save();
        $request->session()->flash('status','Successfully created');
        return back();
    }
    public function maintenance ()
    {
        $equipments = EquipmentData::with('category','class','company','brand','insurance')->where('status','Breakdown')->get();
        // dd($equipments);
        return view('maintenance',
        array(
            'subheader' => '',
            'header' => "Under Maintenance",
            'equipments' => $equipments,
        ));
    }
    public function dispatch_equipments()
    {
        $equipments = [];
        
        return view('maintenance',
        array(
            'subheader' => '',
            'header' => "Dispatch Equipment",
            'equipments' => $equipments,
        ));
    }
    
}
