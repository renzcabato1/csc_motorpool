<?php

namespace App\Http\Controllers;
use App\Fuel;
use App\Company;
use App\Generator;
use App\UserLocation;
use PDF;
use App\EquipmentData;
use App\Location;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    //
    public function view_fuel()
    {
        $fuels = Fuel::where('user_id',auth()->user()->id)->with('equipment','user','locations','company_details','generator')->where('type','=',null)->orderBy('id','desc')->get();
        // dd($fuels);
        $companies = Company::where('status',Null)->get();
        $locations = Location::where('status',"Active")->get();
        $generators = Generator::get();
        $equipments = EquipmentData::with(['category','class','company','brand','insurance','fuel'=> function($q) {
            $q->where('request_type', 'Equipment');
        }])->get();
        return view('fuels',
        array(
            'subheader' => '',
            'header' => "Fuels",
            'fuels' => $fuels,
            'equipments' => $equipments,
            'locations' => $locations,
            'companies' => $companies,
            'generators' => $generators,
        ));
    }
    public function new_fuel(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'reference_number' => 'unique:fuels',
        ]);

        $location = Location::where('id',$request->location)->first();
      
        $old_actual_fuel = $location->actual_fuel;
        $new_fuel = $location->actual_fuel - $request->total_liters;
        $location->actual_fuel=$new_fuel;
        $location->save();
        
        $attachment = $request->file('supporting_documents');
        $original_name = $attachment->getClientOriginalName();
        $name = time().'_'.$attachment->getClientOriginalName();
        $attachment->move(public_path().'/receiving_documents/', $name);
        $file_name = '/receiving_documents/'.$name;
       
       
        $fuel = new Fuel;

        if($request->type_requests == "Affiliates")
        {
            $fuel->affiliates_id = $request->affiliates_category;
            $fuel->affiliates_id = $request->affiliates_category;
        }
        else if($request->type_requests == "Equipment")
        {
            $equipment = explode("-",$request->equipment_category);
            $fuel->equipment_id = $equipment[0];
        }
        else if($request->type_requests == "Generator")
        {
            $fuel->generator_id = $request->generator_category;
        }
        else
        {
            $fuel->others = $request->others_category;
        }
        $fuel->attachment_file = $file_name;
        $fuel->request_type = $request->type_requests;
        $fuel->date_fuel = $request->date_fuel;
        $fuel->location = $request->location;
        $fuel->driver_name = $request->driver_name;
        $fuel->previous_fuel = $old_actual_fuel;
        $fuel->liters = $request->total_liters;
        $fuel->ending_odometer = $request->ending_odometer;
        $fuel->reference_number = $request->reference_number;
        $fuel->remarks = $request->remarks;
        if($request->starting_odometer != "No previous data")
        {
            $fuel->previous_odometer = $request->starting_odometer;
        }
        $fuel->user_id = auth()->user()->id;
        $fuel->save();
        $request->session()->flash('status','Successfully created');
        return back();
    }
    public function new_received(Request $request)
    {
        $this->validate($request, [
            'reference_number' => 'unique:fuels',
        ]);
        $location = Location::where('id',$request->location)->first();
        $old_actual_fuel = $location->actual_fuel;
        $new_fuel = $location->actual_fuel + $request->total_liters;
        $location->actual_fuel=$new_fuel;
        $location->save();

        $attachment = $request->file('supporting_documents');
        $original_name = $attachment->getClientOriginalName();
        $name = time().'_'.$attachment->getClientOriginalName();
        $attachment->move(public_path().'/receiving_documents/', $name);
        $file_name = '/receiving_documents/'.$name;
       

        $fuel = new Fuel;
        $fuel->date_fuel = $request->date_fuel;
        $fuel->received_by = $request->receiver;
        $fuel->location = $request->location;
        $fuel->liters = $request->total_liters;
        $fuel->vendor_name = $request->driver_name;
        $fuel->reference_number = $request->reference_number;
        $fuel->previous_fuel = $old_actual_fuel;
        $fuel->attachment_file = $file_name;
        $fuel->type = "receivings";
        $fuel->remarks = $request->remarks;
        $fuel->user_id = auth()->user()->id;
        $fuel->save();
        $request->session()->flash('status','Successfully created');
        return back();
    }
    public function fuel_report (Request $request)
    {
        // dd($request->equipment_category);   
        $fuels = Fuel::where('equipment_id',$request->equipment_category)->where('type','=',null)->whereBetween('date_fuel',[$request->date_from,$request->date_to])->with('equipment','user','locations')->get();
        // dd($fuels);
        $equipments = EquipmentData::with('category','class','company','brand','insurance','fuel')->wherehas('fuel')->get();
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $equipment_id = $request->equipment_category;
        return view('fuel_report',
        array(
            'subheader' => '',
            'header' => "Fuel Monitoring Report",
            // 'fuels' => $fuels,
            'fuels' => $fuels,
            'equipments' => $equipments,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'equipment_id' => $equipment_id,
        ));
    }
    public function fuels_report (Request $request)
    {
        if($request->equipment_category == "All")
        {
        $fuels = Fuel::whereBetween('date_fuel',[$request->date_from,$request->date_to])->with('equipment','user','locations')->get();
        }
        else
        {
        $fuels = Fuel::with('locations')->where('location',$request->equipment_category)->whereBetween('date_fuel',[$request->date_from,$request->date_to])->with('equipment','user','locations','company_details')->orderBy('location','desc')->orderBy('id','desc')->get();
        }
        $equipments = EquipmentData::with('category','class','company','brand','insurance','fuel')->get();
        $locations = Location::get();
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $location_id = $request->equipment_category;
        return view('fuel_report_soa',
        array(
            'subheader' => '',
            'header' => "Fuel Report",
            // 'fuels' => $fuels,
            'fuels' => $fuels,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'locations' => $locations,
            'location_id' => $location_id,
        ));
    }
    public function export_report(Request $request)
    {
        $equipment = EquipmentData::where('id',$request->equipment_category)->with('category','class','company','brand','insurance','fuel')->first();
        $fuels = Fuel::where('equipment_id',$request->equipment_category)->where('type','=',null)->whereBetween('date_fuel',[$request->date_from,$request->date_to])->with('equipment','user','locations')->get();
       
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $equipment_id = $request->equipment_category;
        $pdf = PDF::loadView('fuel_monitoring_report',array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'equipment_id' => $equipment_id,
            'equipment' => $equipment,
            'fuels' => $fuels,
            
        ));
        return $pdf->stream('fuel_monitoring_report.pdf');
    }
    public function export(Request $request)
    {
        $fuels = Fuel::where('location',$request->equipment_category)->whereBetween('date_fuel',[$request->date_from,$request->date_to])->with('equipment','user','locations')->get();
        $equipments = EquipmentData::with('category','class','company','brand','insurance','fuel')->get();
        $locations = Location::get();
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $location_id = $request->equipment_category;
        $locations_data = Location::where('id',$request->equipment_category)->first();
        $pdf = PDF::loadView('fuel_monitoring_report_export',array(
            'fuels' => $fuels,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'locations' => $locations,
            'location_id' => $location_id,
            'locations_data' => $locations_data,
            
        ));
        return $pdf->stream('fuel_monitoring_report.pdf');
    }
    public function receivings()
    {
        $fuels = Fuel::where('user_id',auth()->user()->id)->with('equipment','user','locations')->get();
        $locations = Location::where('status',"Active")->get();
        $receivings = Fuel::where('type','=','receivings')->with('equipment','user','locations')->where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
        // dd($receivings);
        return view('receivings',
        array(
            'subheader' => '',
            'header' => "Receivings",
            'fuels' => $fuels,
            'locations' => $locations,
            'receivings' => $receivings,
        ));
    }
    public function transfer()
    {
        $fuels = Fuel::where('user_id',auth()->user()->id)->with('equipment','user','locations','generator')->orderBy('id','desc')->where('transfer',1)->get();
        $locations = Location::where('status',"Active")->get();
        return view('transfer',
        array(
            'subheader' => '',
            'header' => "Transfer",
            'fuels' => $fuels,
            'locations' => $locations,
        ));
    }
    public function transfertransaction(Request $request)
    {
        // dd($request->all());
        $location = Location::where('id',$request->location)->first();
      
        $old_actual_fuel = $location->actual_fuel;
        $new_fuel = $location->actual_fuel - $request->total_liters;
        $location->actual_fuel=$new_fuel;
        $location->save();
        
        $attachment = $request->file('supporting_documents');
        $original_name = $attachment->getClientOriginalName();
        $name = time().'_'.$attachment->getClientOriginalName();
        $attachment->move(public_path().'/receiving_documents/', $name);
        $file_name = '/receiving_documents/'.$name;

        $fuel = new Fuel;
        $fuel->request_type = $request->type_requests;
        $fuel->date_fuel = $request->date_fuel;
        $fuel->location = $request->location;
        $fuel->driver_name = $request->driver;
        $fuel->previous_fuel = $old_actual_fuel;
        $fuel->liters = $request->total_liters;
        $fuel->ending_odometer = $request->ending_odometer;
        $fuel->reference_number = $request->reference_number;
        $fuel->remarks = "TRANSFER OUT - ".$request->remarks;
        $fuel->attachment_file = $file_name;
        $fuel->transfer = 1;
        $fuel->user_id = auth()->user()->id;
        $fuel->save();

        $location_to = Location::where('id',$request->location_to)->first();
        $old_actual_fuel_to = $location_to->actual_fuel;
        $new_fuel = $location_to->actual_fuel + $request->total_liters;
        $location_to->actual_fuel=$new_fuel;
        $location_to->save();
       

        $fuel_to = new Fuel;
        $fuel_to->date_fuel = $request->date_fuel;
        $fuel_to->received_by = "TRANSFER";
        $fuel_to->location = $request->location_to;
        $fuel_to->liters = $request->total_liters;
        $fuel_to->vendor_name = "TRANSFER";
        $fuel_to->reference_number = $request->reference_number;
        $fuel_to->previous_fuel = $old_actual_fuel_to;
        $fuel_to->attachment_file = $file_name;
        $fuel_to->transfer = 1;
        $fuel_to->remarks = "TRANSFER IN - ".$request->remarks;
        $fuel_to->type = "receivings";
        $fuel_to->user_id = auth()->user()->id;
        $fuel_to->save();
        $request->session()->flash('status','Successfully transfer');
        return back();

    }
    public function editFuels()
    {
        $date_from = date("Y-m-d", strtotime("-7 days", strtotime(date('Y-m-d'))));
        $fuels = Fuel::with('equipment','user','locations','company','generator')->where('type','=',null)->orderBy('id','desc')->whereBetween('date_fuel',[$date_from,date('Y-m-d')])->get();
        $companies = Company::where('status',Null)->get();
        $locations = Location::where('status',"Active")->get();
        $generators = Generator::get();
        return view('edit_fuel',
        array(
            'subheader' => '',
            'header' => "Edit Fuel",
            'fuels' => $fuels,
            'locations' => $locations,
            'companies' => $companies,
            'generators' => $generators,
        ));
    }
}
