@extends('layouts.header')

@section('content')


<div class="wrapper wrapper-content">
 
@include('error')
    <div class="row">
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Declined Requests
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
                                <th>Name</th>
                                <th>Equipment Class</th>
                                <th>Date Needed / Time Needed</th>
                                <th>Project ID</th>
                                <th>Area</th>
                                <th>Location</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests_approved as $request)
                            <tr id='row{{$request->id}}' class='pointer' data-target="#view_request{{$request->id}}" data-toggle="modal" data-id='{{$request->id}}'>
                                {{-- <th>Logo</th> --}}
                                <td>RN-{{str_pad($request->id, 4, '0', STR_PAD_LEFT)}}</td>
                                <td>
                                    <small>
                                        {{$request->user->name}}
                                        <br>
                                        {{$request->company->company_name}}
                                        <br>
                                        {{$request->department->department_name}}
                                </td>
                                <td>{{$request->class->class_description}}</td>
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
                                {{-- <th><small class="label label-warning">Pending</small></th> --}}
                               
                            </tr>
                            @include('view_request_re')
                            @endforeach
                          
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
