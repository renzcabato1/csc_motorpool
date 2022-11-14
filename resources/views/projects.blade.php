@extends('layouts.header')

@section('content')


<div class="wrapper wrapper-content">
@if(session()->has('status'))
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    {{session()->get('status')}}
</div>
@endif
@include('error')
    <div class="row">
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Projects
                        <button class="btn btn-primary" data-target="#new_project" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Company</th>
                            <th>Project Description</th>
                            <th>Location</th>
                            <th>Area</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($projects as $project)
                            <tr>
                                <td>{{$project->project_id}}</td>
                                <td>{{$project->company->company_code}}</td>
                                <td>{{$project->project_description}}</td>
                                <td>{{$project->location}}</td>
                                <td>{{$project->area}}</td>
                                <td id='statustd{{$project->id}}'>@if($project->status == "Inactive") <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                <td id='actiontd{{$project->id}}' data-id='{{$project->id}}'>
                                        
                                    @if($project->status == "Inactive")
                                    <button class="btn btn-sm btn-primary activate-project" title="Activate"><i class="fa fa-check"></i></button>
                                    @else
                                    <button class="btn btn-sm btn-info"  title='Edit' data-target="#editProject{{$project->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger deactivate-project" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                    @endif
                                    {{-- <button class="btn btn-sm btn-info" data-target="#change_pass{{$company->id}}" data-toggle="modal">Change Password</button> --}}
                                    {{-- <button class="btn btn-sm btn-danger delete-comp" data-target="#deletecomp{{$company->id}}" data-toggle="modal">Delete</button> --}}
                                </td>
                            </tr>
                            @include('edit_project') 
                          @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@include('new_project')
@endsection
