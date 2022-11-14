<?php

namespace App\Http\Controllers;
use App\Company;
use App\InsuranceCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //

    public function company()
    {
        $companies = Company::get();
        $insurances = InsuranceCompany::get();
        return view('companies',
        array(
            'subheader' => 'Companies',
            'header' => "Settings",
            'companies' => $companies,
            'insurances' => $insurances,
        ));
    }

    public function companiesAPI()
    {
        $companies = Company::get();
     
        return $companies;
    }

    public function new_company(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'min:6|unique:companies',
            'company_code' => 'unique:companies',
        ]);
        // dd($request->all());
        $company = new Company;
        $company->company_name = $request->company_name;
        $company->company_code = $request->company_code;
        $company->save();
        $request->session()->flash('status','Successfully created');
        return back();

    }

    public function edit_company(Request $request,$id)
    {
        $this->validate($request, [
            'company_code' => 'unique:companies,company_code,' . $id,
        ]);
        // dd($request->all());
        $company = Company::where('id',$id)->first();
        $company->company_name = $request->company_name;
        $company->company_code = $request->company_code;
        $company->save();
        $request->session()->flash('status','Successfully updated');
        return back();

    }

    public function deactivate_company(Request $request)
    {

        $company = Company::where('id',$request->id)->first();
        $company->status = 1;
        $company->save();

        return "success";
    }
    public function activate_company(Request $request)
    {

        $company = Company::where('id',$request->id)->first();
        $company->status = Null;
        $company->save();

        return "success";
    }
}
