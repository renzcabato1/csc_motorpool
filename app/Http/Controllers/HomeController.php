<?php

namespace App\Http\Controllers;
use App\EquipmentData;
use App\Company;
use App\RequestData;
use App\ClassEquipment;
use App\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $header = "Dashboard";
        $subheader = "";

        $equipments = EquipmentData::get();
        $companies = Company::whereHas('equipment')->get();
        if(auth()->user()->role_id == 1)        
        {
            $all_request = RequestData::count();
        }
        else
        {
            $all_request = RequestData::where('user_id',auth()->user()->id)->count();
        }
        $all_requests = RequestData::with('user','company','department','class','histories')->get();
        // dd($all_requests);
        if(auth()->user()->role_id == 1)        
        {
            $approved_requests = RequestData::where('status','Approved')->count();
        }
        else
        {
            $approved_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Approved')->count();
        }

        if(auth()->user()->role_id == 1)        
        {
            $pending_requests = RequestData::where('status','Pending')->count();
        }
        else
        {
            $pending_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Pending')->count();
        }
        if(auth()->user()->role_id == 1)        
        {
           
            $declined_requests = RequestData::where('status','Declined')->orWhere('status','Cancelled')->count();
        }
        else
        {
            
        $declined_requests = RequestData::where('user_id',auth()->user()->id)->where(function($q){
                $q->where('status', "Declined")
                  ->orWhere('status', "Cancelled");
            })->count();
        }
       
        
        $active_equipment = EquipmentData::where('status','Operational')->count();
        $for_repair_equipment = EquipmentData::where('status','Breakdown')->count();
        $inactive_equipment = EquipmentData::where('status','Disposal')->count();

        $classes = ClassEquipment::with('category')->get();
        $requests = RequestData::with('user','company','department','class','approver','project')
        ->where('user_id',auth()->user()->id)
        // ->where('status','Pending')
        ->orderBy('id','desc')
        ->get();
        $projects = Project::with('company')->get();
        return view('home', 
        array(
            'header' => $header,
            'companies' => $companies,
            'subheader' => $subheader,
            'equipments' => $equipments,
            'active_equipment' => $active_equipment,
            'inactive_equipment' => $inactive_equipment,
            'for_repair_equipment' => $for_repair_equipment,
            'all_request' => $all_request,
            'all_requests' => $all_requests,
            'requests' => $requests,
            'approved_requests' => $approved_requests,
            'declined_requests' => $declined_requests,
            'pending_requests' => $pending_requests,
            'classes' => $classes,
            'projects' => $projects ,
        )
        );
    }
    public function index_not_admin()
    {
        $header = "Dashboard";
        $subheader = "";

        $equipments = EquipmentData::get();
        $companies = Company::whereHas('equipment')->get();
        $all_request = RequestData::where('user_id',auth()->user()->id)->count();
        $approved_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Approved')->count();
        $pending_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Pending')->count();
        $declined_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Declined')->orWhere('status','Cancelled')->count();
        $active_equipment = EquipmentData::where('status','Operational')->count();
        $for_repair_equipment = EquipmentData::where('status','Breakdown')->count();
        $inactive_equipment = EquipmentData::where('status','Disposal')->count();
        return view('home', 
        array(
            'header' => $header,
            'companies' => $companies,
            'subheader' => $subheader,
            'equipments' => $equipments,
            'active_equipment' => $active_equipment,
            'inactive_equipment' => $inactive_equipment,
            'for_repair_equipment' => $for_repair_equipment,
            'all_request' => $all_request,
            'approved_requests' => $approved_requests,
            'declined_requests' => $declined_requests,
            'pending_requests' => $pending_requests,
        )
        );
    }
}
