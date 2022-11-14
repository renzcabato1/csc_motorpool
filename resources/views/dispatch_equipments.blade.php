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
                    <h5>Equipments
                        {{-- <button class="btn btn-primary" data-target="#new_request" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            {{-- <th>Logo</th> --}}
                            <th>Request Number</th>
                            <th>Requestor</th>
                            <th>Equipment Class</th>
                            <th>Date Needed / Time Needed</th>
                            <th>Project ID</th>
                            <th>Area</th>
                            <th>Location</th>
                            <th>Remarks</th>
                            <th>Dispatch Equipment</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr id='row{{$request->id}}'>
                                {{-- <th>Logo</th> --}}
                                <td>RN-{{str_pad($request->id, 4, '0', STR_PAD_LEFT)}}</td>
                             
                                <td><small>
                                    Name : {{$request->user->name}}
                                    <br>
                                    Company : {{$request->company->company_code}}
                                    <br>
                                    Department : {{$request->department->department_name}}
                                    <br>
                                    Date Request : {{date('M d, Y',strtotime($request->created_at))}}
                                </td>
                                <td>
                                    {{$request->class->class_description}}
                                </td>
                                <td>
                                    <small>
                                        Date : {{date('M d, Y',strtotime($request->date_from_needed))}} - {{date('M d, Y',strtotime($request->date_to_needed))}} <br>
                                        Time : {{date('h:m a',strtotime($request->time_from_needed))}} - {{date('h:m a',strtotime($request->time_to_needed))}}
                                    </small>
                                </td>
                                <td>@if($request->project){{$request->project->project_id}}@endif</td>
                                <td>{{$request->area}}</td>
                                <td>{{$request->location}}</td>
                                <td>{!! nl2br(e($request->remarks)) !!}</td>
                                <td>
                                   Code : {{$request->deploy->equipment_data->company->company_code}}-{{$request->deploy->equipment_data->category->category_code}}-{{$request->deploy->equipment_data->class->class_code}}-{{str_pad($request->deploy->equipment_data->equipment_number, 4, '0', STR_PAD_LEFT)}} <br>
                                   Engine Number : {{$request->deploy->equipment_data->engine_number}} <br>
                                   Plate Number : {{$request->deploy->equipment_data->plate_number}} <br>
                                   Conduction Sticker : {{$request->deploy->equipment_data->conduction_sticker}} <br>
                                </td>
                                <td data-id='{{$request->id}}'>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
