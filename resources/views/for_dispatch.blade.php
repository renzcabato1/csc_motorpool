@extends('layouts.header')

@section('content')


<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">as of Today</span>
                    <h5>For Dispatch</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" id='requests'>{{(count($requests))}}</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">as of Today</span>
                    <h5> For Approval(Dispatch)</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" id='dispatch_approval'>{{$dispatch_approval}}</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">as of Today</span>
                    <h5>For Deployment</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$approve_dispatch}}</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
    </div>
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
                    <h5>For Dispatch
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
                            <th>Approved By</th>
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
                                    <small>
                                    Name : {{$request->approve_by->name}} <br>
                                    Date Approved : {{date('M d, Y',strtotime($request->histories[0]->created_at))}} <br>
                                    Remarks : {{$request->histories[0]->remarks}} <br>
                                    </small>
                                </td>
                                <td data-id='{{$request->id}}'>
                                    <button class="btn btn-sm btn-info Dispatch-Equipment"  title='Dispatch Equipment' ><i class="fa fa-upload"></i></button>
                                    <button class="btn btn-sm btn-danger declined-request-dispatch" title='Decline Request' ><i class="fa fa-window-close-o"></i></button>
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
@include('dispatch_equipment')
@include('decline_request_dispatch')
@endsection
