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
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">as of Today</span>
                    <h5>Total Requests</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{($all_request)}}</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">as of Today</span>
                    <h5> Pending Requests</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$pending_requests}}</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">as of Today</span>
                    <h5>Approved Requests</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$approved_requests}}</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">as of Today</span>
                    <h5>Declined/Cancelled Requests</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$declined_requests}}</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
    </div>
  
    <div class="row">
        @if(auth()->user()->role_id == 1)
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">This month ({{date('M Y')}})</span>
                    <h5>Expected Revenue</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
       
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">This month ({{date('M Y')}})</span>
                    <h5>Equipment for Expiry</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">This month ({{date('M Y')}})</span>
                    <h5>Equipment under Maintenance</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$for_repair_equipment}}</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        @endif
        @if((auth()->user()->role_id == 1) || (auth()->user()->role_id == 3) || (auth()->user()->role_id == 5))
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">This month ({{date('M Y')}})</span>
                    <h5>Total Equipment Dispatch</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        @endif
      
    </div>
    @if(auth()->user()->role_id == 1)
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div>
                    {{-- <span class="pull-right text-right">
                    <small>Average value of sales in the past month in: <strong>United states</strong></small>
                        <br/>
                        All sales: 162,862
                    </span> --}}
                        <h3 class="font-bold no-margins">
                            Equipments per Company
                        </h3>
                        {{-- <small>Sales marketing.</small> --}}
                    </div>

                    <div class="m-t-sm">

                        <div class="row">
                            <div class="col-md-9">
                                <div>
                                    <canvas id="barChart" height="120"></canvas>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <ul class="stat-list m-t-lg">
                                    <li>
                                        <h2 class="no-margins">{{$active_equipment}}</h2>
                                        <small>Total Active Equipments</small>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar" style="width: {{($active_equipment/count($equipments)*100)}}%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins ">{{$for_repair_equipment}}</h2>
                                        <small>For Repair Equipments</small>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-warning" style="width: {{($for_repair_equipment/count($equipments)*100)}}%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2 class="no-margins ">{{$inactive_equipment}}</h2>
                                        <small>Disposal</small>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-bar-danger" style="width: {{($inactive_equipment/count($equipments)*100)}}%;"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Requests</h5>
                </div>
                <div class="ibox-content" style='height:350px;'>
                    <div class='full-height-scroll'>
                    <table class="table table-hover no-margins pending-request" >
                        <thead>
                        <tr>
                            
                            <th>Date Request</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        
                        <tbody >
                            @foreach($all_requests as $reque)
                                {{-- @if(($reque->status == "Pending") || ($reque->status == "Approved")) --}}
                                    <tr class='pointer' data-target="#view_request{{$reque->id}}" data-toggle="modal" data-id='{{$reque->id}}'>
                                        <td><small>{{date('M d, Y',strtotime($reque->created_at))}}</small></td>
                                        <td>RN-{{str_pad($reque->id, 4, '0', STR_PAD_LEFT)}}</td>
                                        <td>{{$reque->user->name}}</td>
                                        <td><small class='label label'>{{$reque->status}}</small></td>
                                    </tr>
                                    @include('view_request')
                                {{-- @endif --}}
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->user()->role_id == 2)
    
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
                        <h5>Requests
                            <button class="btn btn-primary" data-target="#new_request" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
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
                                        <td><small class='label label'>{{$request->status}}</small></td>
                                    {{-- <th><small class="label label-warning">Pending</small></th> --}}
                                        <td data-id='{{$request->id}}'>
                                            @if($request->status == "Pending")
                                            {{-- <button class="btn btn-sm btn-info approve-request"  title='Approve Request' ><i class="fa fa-check-square-o"></i></button> --}}
                                            <button class="btn btn-sm btn-info"  title='Edit' data-target="#edit_request{{$request->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger remove-request" title='Cancel' ><i class="fa fa-trash"></i></button>
                                            @else
                                            
                                            @endif
                                        </td>
                                    </tr>
                                @include('view_request_re')
                                @include('edit_request') 
                                @endforeach
                            </tbody>
                        </table>
    
                    </div>
                </div>
            </div>
           
        </div>
        @include('new_request')
    </div>
    @endif
</div>
<script src="{{ asset('bootstrap/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/plugins/chartJs/Chart.min.js') }}"></script>
<script>
    var companies = {!! json_encode($companies->toArray()) !!};
var equipments = {!! json_encode($equipments->toArray()) !!};
var active_equipment = {!! json_encode($active_equipment) !!};
var for_repair_equipment = {!! json_encode($for_repair_equipment) !!};
var inactive_equipment = {!! json_encode($inactive_equipment) !!};
        var comp = [];
        var active_per_comp = [];
        var inactive_per_comp = [];
        var total_per_comp = [];
        var repair_per_comp = [];
        for(var i =0;i< companies.length;i++)
        {   
            comp[i] = companies[i].company_code;
            var active_comp = 0;
            var total_comp = 0;
            var inactive_comp = 0;
            var repair_comp = 0;
            for(var z=0;z< equipments.length;z++)
            {
                if((companies[i].id == equipments[z].company_id))
                {
                    total_comp = total_comp + 1;
                }
                if((companies[i].id == equipments[z].company_id) && (equipments[z].status == "Operational"))
                {
                    active_comp = active_comp + 1;
                }
                if((companies[i].id == equipments[z].company_id) && (equipments[z].status == "Disposal"))
                {
                    inactive_comp = inactive_comp + 1;
                }
                if((companies[i].id == equipments[z].company_id) && (equipments[z].status == "Breakdown"))
                {
                    repair_comp = repair_comp + 1;
                }
            }
            
            active_per_comp[i] = active_comp;
            inactive_per_comp[i] = inactive_comp;
            total_per_comp[i] = total_comp;
            repair_per_comp[i] = repair_comp;
        }
        // console.log(companies);
        var barData = {
            labels: comp,
            
            datasets: [
                {
                    label: "Total Equipment",
                    backgroundColor: 'rgba(220, 220, 220, 0.5)',
                    pointBorderColor: "#fff",
                    data: total_per_comp,
                    
                },
                {
                    label: "Active Equiement",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: active_per_comp
                },
                {
                    label: "For Repair Equipment",
                    backgroundColor: 'rgba(224, 163, 133,0.5)',
                    borderColor: "rgba(255, 153, 102,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: repair_per_comp
                },
                {
                    label: "Disposed Equipment",
                    backgroundColor: 'rgba(255, 128, 128,0.5)',
                    borderColor: "rgba(255, 0, 0,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: inactive_per_comp
                },

            ]
        };

        var barOptions = {
            responsive: true,
            
        };

        var ctx2 = document.getElementById("barChart").getContext("2d");
        
        new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
    
</script>
@endsection
