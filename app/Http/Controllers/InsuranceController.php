<?php

namespace App\Http\Controllers;
use App\InsuranceCompany;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    //
    public function new_insurance(Request $request)
    {
        $this->validate($request, [
            'company' => 'unique:insurance_companies',
        ]);

        $insurance = new InsuranceCompany;
        $insurance->company = $request->company;
        $insurance->save();

        $request->session()->flash('status','Insurance company successfully created');
        return back();


    }

    public function deactivate_insurance(Request $request)
    {
        $company = InsuranceCompany::where('id',$request->id)->first();
        $company->status = 1;
        $company->save();

        return "success";
    }
    public function activate_insurance(Request $request)
    {
        // dd($request->all());
        $company = InsuranceCompany::where('id',$request->id)->first();
        $company->status = "";
        $company->save();

        return "success";
    }
    
    public function edit_insurance(Request $request,$id)
    {
        $this->validate($request, [
            'company' => 'unique:insurance_companies,company,' . $id,
        ]);

        $company = InsuranceCompany::where('id',$id)->first();
        $company->company = $request->company;
        $company->save();
        $request->session()->flash('status','Successfully updated');
        return back();
    }
}
