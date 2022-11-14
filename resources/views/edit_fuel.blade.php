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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Fuels
                        {{-- <button class="btn btn-primary" data-target="#new_fuel" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">
                    <table datatable="" dt-options="dtOptions" class="table table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Issuance Number</th>
                                <th>Date</th>
                                <th>Information</th>
                                <th>Driver Name</th>
                                <th>Total Liters</th>
                                <th>Encode By</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fuels as $fuel)
                                <tr>
                                    <td>{{$fuel->reference_number}}</td>
                                    <td>{{date('M d, Y',strtotime($fuel->date_fuel))}}</td>
                                    <td>
                                        <small>
                                            Request type : {{$fuel->request_type}} <Br>
                                        @if($fuel->request_type == "Equipment")
                                            Company  :     {{($fuel->equipment->company->company_code)}} <br>
                                            Equipment Code  :     {{$fuel->equipment->company->company_code}}-{{$fuel->equipment->category->category_code}}-{{$fuel->equipment->class->class_code}}-{{str_pad($fuel->equipment->equipment_number, 4, '0', STR_PAD_LEFT)}}  <br>
                                            Old Code :  {{$fuel->equipment->old_code}}
                                            Ending Odometer : {{number_format($fuel->ending_odometer)}} KM
                                        @elseif($fuel->request_type == "Generator")
                                            Generator  :     {{($fuel->generator->brand)}} -  {{($fuel->generator->model)}}<br>
                                        @elseif($fuel->request_type == "Affiliates")
                                            Company  : {{$fuel->company->company_code}}
                                        @else
                                            {{$fuel->others}}
                                        @endif
                                        </small>
                                    </td>
                                    <td>{{$fuel->driver_name}}</td>
                                    <td>{{number_format($fuel->liters,2)}} L</td>
                                    <td>{{$fuel->user->name}}</td>
                                    <td>{{$fuel->locations->location}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editFuel{{$fuel->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger deactivate-brand" ><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @include('edit_fuel_data') 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
