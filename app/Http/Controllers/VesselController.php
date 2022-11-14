<?php

namespace App\Http\Controllers;
use App\Vessel;
use App\AuditLog;
use App\Http\Controllers\AuditController;
use App\VesselType;
use Illuminate\Http\Request;

class VesselController extends Controller
{
    //

    public function vessels ()
    {
        $vessels = Vessel::with('type_info')->get();
        $vessel_types = VesselType::orderBy('name','asc')->get();
        return view('vessels',
        array(
            'subheader' => 'Vessels',
            'header' => "Vessels",
            'vessels' => $vessels,
            'vessel_types' => $vessel_types,
        ));
    }
    public function newVessel (Request $request)
    {
        $this->validate($request, [
            'vessel_code' => 'unique:vessels,vessel_code',
        ]);
        $vessel = new Vessel;
        $vessel->vessel_code = $request->vessel_code;
        $vessel->description = $request->vessel_description;
        $vessel->type = $request->vessel_type;
        $vessel->encoded_by = auth()->user()->id;
        $vessel->save();

        $audit = new AuditController;
        $audit->audit_register($vessel->id,"Vessel",$vessel,null,"New");

        $request->session()->flash('status','Successfully Store');
        return back();
                 
    }

}
