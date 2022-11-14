<?php

namespace App\Http\Controllers;
use App\Project;
use App\Company;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function project()
    {
        $projects = Project::with('company')->get();
        $companies = Company::get();
        return view('projects',
        array(
            'subheader' => '',
            'header' => "Projects",
            'projects' => $projects,
            'companies' => $companies,
        ));
    }
    public function new_project(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'unique:projects',
        ]);

        $project = new Project;
        $project->project_id = $request->project_id;
        $project->project_description = $request->project_description;
        $project->location = $request->location;
        $project->area = $request->area;
        $project->company_id = $request->company;
        $project->status = "Active";
        $project->save();
        $request->session()->flash('status','Successfully Created');
        return back();
    }
    public function deactivate_project(Request $request)
    {
        $project = Project::where('id',$request->id)->first();
        $project->status = "Inactive";
        $project->save();

        return "success";
    }
    public function activate_project(Request $request)
    {
        $project = Project::where('id',$request->id)->first();
        $project->status = "Active";
        $project->save();

        return "success";
    }

    public function edit_project(Request $request,$id)
    {
        $this->validate($request, [
            'project_id' => 'unique:projects,project_id,' . $id,
        ]);

        $project = Project::where('id',$id)->first();
        $project->project_id = $request->project_id;
        $project->project_description = $request->project_description;
        $project->location = $request->location;
        $project->area = $request->area;
        $project->company_id = $request->company;
        $project->save();
        $request->session()->flash('status','Successfully Updated.');
        return back();
        
    }
}
