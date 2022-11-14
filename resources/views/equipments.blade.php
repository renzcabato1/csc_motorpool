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
                        <button class="btn btn-primary" data-target="#new_equipment" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i></button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-equipments">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Brand</th>
                            <th>Owned By</th>
                            <th>Information</th>
                            <th>Location</th>
                            <th>Area</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($equipments as $equip)
                            <tr>
                                <td style='text-align: center;width:10%'  > 
                                    {{$equip->company->company_code}}-{{$equip->category->category_code}}-{{$equip->class->class_code}}-{{str_pad($equip->equipment_number, 4, '0', STR_PAD_LEFT)}}
                                </td >
                                <td > 
                                    @if($equip->brand){{$equip->brand->brand_name}}@endif
                                </td >
                                <td > 
                                    {{$equip->company->company_name}}
                                </td >
                                <td > 
                                  <small>Plate Number : {{$equip->plate_number}} <br>
                                
                                    Engine Number :  {{$equip->engine_number}}<br>
                               
                                    Model :  {{$equip->model}}<br>
                               
                                    Chasis Number : {{$equip->chasis_number}}</small>
                                </td >
                                <td > 
                                    {{$equip->location}}
                                </td >
                                <td > 
                                    {{$equip->area}}
                                </td >
                                <td > 
                                    {{$equip->status}}
                                </td >
                                <td > 
                                    <button class="btn btn-sm btn-info"  title='Edit' data-target="#editBrand{{$equip->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                </td >
                            </tr>
                          @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
       
    </div>
  
</div>
  @include('new_equipment')
@endsection
