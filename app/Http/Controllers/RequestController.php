<?php

namespace App\Http\Controllers;
use App\ClassEquipment;
use App\RequestData;
use App\RequestHistory;
use App\EquipmentData;
use App\Project;
use App\RequestDeployment;
use App\User;
use App\Notifications\RequestAction;
use App\Notifications\ApproveAction;
use App\Notifications\DeclineAction;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //
    public function requests()
    {
        $all_request = RequestData::where('user_id',auth()->user()->id)->count();
        $pending_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Pending')->count();
        $approved_requests = RequestData::where('user_id',auth()->user()->id)->where('status','Approved')->count();
        $declined_requests = RequestData::where('user_id',auth()->user()->id)->where(function($q){
            $q->where('status', "Declined")
              ->orWhere('status', "Cancelled");
        })->count();
        $classes = ClassEquipment::with('category')->get();
        $requests = RequestData::with('user','company','department','class','approver','project')
        ->where('user_id',auth()->user()->id)
        // ->where('status','Pending')
        ->orderBy('id','DESC')
        ->get();
        $projects = Project::with('company')->get();
        // dd($requests)
        $header = "Requests";
        $subheader = "";
        return view('requests', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'classes' => $classes,
            'requests' => $requests,
            'projects' => $projects,
            'all_request' => $all_request,
            'pending_requests' => $pending_requests,
            'approved_requests' => $approved_requests,
            'declined_requests' => $declined_requests,
        )
        );
    }
    public function for_approval()
    {
        $requests = RequestData::with('user','company','department','class')
        ->where('approver_id',auth()->user()->id)
        ->where('status','Pending')
        ->orderBy('id','desc')
        ->get();
        $requests_approved = RequestData::with('user','company','department','class')
        ->where('approver_id',auth()->user()->id)
        ->where(function($q){
            $q->where('status','=',"Approved")
              ->orWhere('status','=',"Reserved")
              ->orWhere('status','=',"Dispatch");
        })
        ->orderBy('id','desc')
        ->get();
        $requests_declined = RequestData::with('user','company','department','class')
        ->where('approver_id',auth()->user()->id)
        ->where(function($q){
            $q->where('status',"Declined");
        })
        ->orderBy('id','desc')
        ->get();

        $header = "For Approval";
        $subheader = "";
        return view('for_approval', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests' => $requests,
            'requests_approved' => $requests_approved,
            'requests_declined' => $requests_declined,
        )
        );
    }
    public function for_dispatch()
    {
        $requests = RequestData::with('approve_by','user','company','department','class','histories')
        // ->where('approver_id',auth()->user()->id)
        ->where('status','Approved')
        ->orderBy('id','desc')
        ->get();
        $dispatch_approval = RequestData::with('approve_by','user','company','department','class','histories')
        ->where('status','Reserved')
        ->orderBy('id','desc')
        ->count();
        $approve_dispatch = RequestData::with('approve_by','user','company','department','class','histories','deploy')
        ->where('status','Dispatch')
        ->orderBy('id','desc')
        ->count();
        $equipments = EquipmentData::with('category','class','company','brand','insurance')->where('status','Operational')->where('company_id',auth()->user()->company_id)->get();
        $header = "For Dispatch";
        $subheader = "";
        return view('for_dispatch', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests' => $requests,
            'equipments' => $equipments,
            'dispatch_approval' => $dispatch_approval,
            'approve_dispatch' => $approve_dispatch,
        )
        );
    }
    public function all_approved_requests()
    {
        
        $requests_approved = RequestData::with('user','company','department','class')
        ->where('approver_id',auth()->user()->id)
        ->where(function($q){
            $q->where('status','=',"Approved")
              ->orWhere('status','=',"Reserved")
              ->orWhere('status','=',"Dispatch");
        })
        ->orderBy('id','desc')
        ->get();
        

        $header = "Approved Request";
        $subheader = "";
        return view('all_approved_requests', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests_approved' => $requests_approved,
        )
        );
    }
    public function all_declined_requests()
    {
      
        $requests_declined = RequestData::with('user','company','department','class')
        ->where('approver_id',auth()->user()->id)
        ->where(function($q){
            $q->where('status',"Declined");
        })
        ->orderBy('id','desc')
        ->get();

        $header = "Declined Request";
        $subheader = "";
        return view('all_declined_requests', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests_declined' => $requests_declined,
        )
        );
    }
    public function dispatch_approval()
    {
        $requests = RequestData::with('approve_by','user','company','department','class','histories')
        ->whereHas('deploy', function ($q){
            $q->where('approver_id',auth()->user()->id);
        })
        ->where('status','Reserved')
        ->orderBy('id','desc')
        ->get();

        $approved_request = RequestData::with('approve_by','user','company','department','class','histories')
        ->whereHas('deploy', function ($q){
            $q->where('approver_id',auth()->user()->id)
              ->where('status',"Dispatch");
        })
        ->orderBy('id','desc')
        ->count();

        $header = "Dispatch Approval";
        $subheader = "";
        return view('dispatch_approval', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests' => $requests,
            'approved_request' => $approved_request,
        )
        );
    }
    public function dispatch_equipments ()
    {
        $requests = RequestData::with('approve_by','user','company','department','class','histories','deploy')
        ->where('status','Dispatch')
        ->orderBy('id','desc')
        ->get();
        $header = "Dispatch Equipments";
        $subheader = "";
        return view('dispatch_equipments', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests' => $requests,
        )
        );

    }
    public function new_request(Request $request)
    {
        // dd($request->date_start);
        $date_start_array = explode("-",$request->date_start);
        $date_start = $date_start_array[2]."-".$date_start_array[0]."-".$date_start_array[1];
        $date_end_array = explode("-",$request->date_end);
        $date_end = $date_end_array[2]."-".$date_end_array[0]."-".$date_end_array[1];
        // $reque = ;
        foreach($request->equipment_category as $cat)
        {
            $data_final_array = explode("*",$cat);
            $data_final = $data_final_array[0];
            $data_final_data = $data_final_array[1];
            // dd($data_final_data);
            $req = new RequestData;
            $req->user_id = auth()->user()->id;
            $req->company_id = auth()->user()->company->id;
            $req->department_id = auth()->user()->department->id;
            $req->approver_id = $request->approver_id;
            $req->class_id = $data_final;
            $req->is_project = $request->project;
            $req->project_id = $request->project_id;
            $req->date_from_needed = $date_start;
            $req->date_to_needed = $date_end;
            $req->time_from_needed = $request->time_from;
            $req->time_to_needed = $request->time_to;
            $req->location = $request->location;
            $req->area = $request->area;
            $req->remarks = $request->remarks;
            $req->status = "Pending";
            $req->save();
    
            $history = new RequestHistory;
            $history->request_data_id = $req->id;
            $history->action = "Create Request";
            $history->remarks = $request->remarks;
            $history->user_id = auth()->user()->id;
            $history->save();
    
            $approver = User::where('id',$request->approver_id)->first();
            $requestor = User::where('id',auth()->user()->id)->first();
            $approver->notify(new RequestAction($req,$requestor,$data_final_data));
        }
       

        $request->session()->flash('status','Successfully created');
        return back();
        // dd($req);
        // $req->
        
    }
    public function cancel_request(Request $request)
    {
        $req = RequestData::where('id',$request->id)->first();
        $req->status = "Cancelled";
        $req->save();

        $history = new RequestHistory;
        $history->request_data_id = $request->id;
        $history->action = "Cancelled Request";
        $history->user_id = auth()->user()->id;
        $history->save();

        return $request;
    }
    public function approved_dispatch(Request $request)
    {
        $req = RequestData::where('id',$request->id)->first();
        $req->status = "Dispatch";
        $req->save();

        $history = new RequestHistory;
        $history->request_data_id = $request->id;
        $history->action = "Approved Dispatch";
        $history->user_id = auth()->user()->id;
        $history->save();

        $requestDep = RequestDeployment::where('request_id',$request->id)->first();
        $requestDep->status = "Dispatch";
        $requestDep->save();

        return $request;
    }
    public function edit_request(Request $request,$id)
    {
        
         // dd($request->date_start);
         $date_start_array = explode("-",$request->date_start);
         $date_start = $date_start_array[2]."-".$date_start_array[0]."-".$date_start_array[1];
         $date_end_array = explode("-",$request->date_end);
         $date_end = $date_end_array[2]."-".$date_end_array[0]."-".$date_end_array[1];
         // $reque = ;
         $data_final_array = explode("*",$request->equipment_category);
         $data_final = $data_final_array[0];
         $data_final_data = $data_final_array[1];
         // dd($data_final_data);
         $req = RequestData::where('id',$id)->first();
         $req->user_id = auth()->user()->id;
         $req->company_id = auth()->user()->company->id;
         $req->department_id = auth()->user()->department->id;
         $req->approver_id = $request->approver_id;
         $req->class_id = $data_final;
         $req->is_project = $request->project;
         $req->project_id = $request->project_id;
         $req->date_from_needed = $date_start;
         $req->date_to_needed = $date_end;
         $req->time_from_needed = $request->time_from;
         $req->time_to_needed = $request->time_to;
         $req->location = $request->location;
         $req->area = $request->area;
         $req->remarks = $request->remarks;
        //  $req->status = "Pending";
         $req->save();
 
         $history = new RequestHistory;
         $history->request_data_id = $id;
         $history->action = "Edit Request";
         $history->remarks = $request->remarks;
         $history->user_id = auth()->user()->id;
         $history->save();

         $request->session()->flash('status','Successfully updated');

         return back();
    }
    public function approve_request(Request $request)
    {
        $req = RequestData::where('id',$request->id)->first();
        $req->status = "Approved";
        $req->approved_by = auth()->user()->id;
        $req->save();

        $re = User::where('id',$req->user_id)->first();
        $re->notify(new ApproveAction($req));
        $history = new RequestHistory;
        $history->request_data_id = $request->id;
        $history->action = "Approved Request";
        $history->user_id = auth()->user()->id;
        $history->remarks = $request->remarks;
        $history->save();
        return $request;
    }
    public function declined_request(Request $request)
    {
        $req = RequestData::where('id',$request->id)->first();
        $req->status = "Declined";
        $req->save();

        $re = User::where('id',$req->user_id)->first();
        $re->notify(new DeclineAction($req,$request));




        $history = new RequestHistory;
        $history->request_data_id = $request->id;
        $history->action = "Declined Request";
        $history->user_id = auth()->user()->id;
        $history->remarks = $request->remarks;
        $history->save();
        return "success";
    }
    public function declined_request_dispatch(Request $request)
    {
        // dd($request->all());
        // return $request;
        
        $req = RequestData::where('id',$request->id)->first();
        $req->status = "Declined";
        $req->save();

        $re = User::where('id',$req->user_id)->first();
        $re->notify(new DeclineAction($req,$request));

        $history = new RequestHistory;
        $history->request_data_id = $request->id;
        $history->action = "Declined Request";
        $history->user_id = auth()->user()->id;
        $history->remarks = $request->remarks;
        $history->save();
        return "success";
    }
    public function dispatch_equip(Request $request)
    {
        $equipmentID =  explode("-",$request->id);
        // dd($equipmentID);
        $requestData = RequestData::where('id',$request->id_row_upload)->first();        
        $requestData->status = "Reserved";
        $requestData->save();

        $history = new RequestHistory;
        $history->request_data_id = $requestData->id;
        $history->action = "Reserved Equipment";
        $history->user_id = auth()->user()->id;
        $history->remarks = $request->remarks;
        $history->save();

        $requestDep = new RequestDeployment;
        $requestDep->equipment_datas_id = $equipmentID[0];
        $requestDep->request_id = $requestData->id;
        $requestDep->deployed_by = auth()->user()->id;
        $requestDep->status = "Reserved";
        $requestDep->approver_id = auth()->user()->approver_id;
        $requestDep->remarks = $request->remarks;
        $requestDep->save();
        
        return $request;
    }
    public function appproved_dispatch_requests()
    {
        
        $requests = RequestData::with('approve_by','user','company','department','class','histories')
        ->whereHas('deploy', function ($q){
            $q->where('approver_id',auth()->user()->id)
              ->where('status',"Dispatch");
        })
        ->orderBy('id','desc')
        ->get();
        

        $header = "Approved Dispatch Requests";
        $subheader = "";
        return view('approved_dispatch_requests', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'requests_approved' => $requests,
        )
        );
    }
}
