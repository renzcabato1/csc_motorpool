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
                {{-- <div class="ibox-title">
                    <h5>Locations
                        <button class="btn btn-primary" data-target="#new_brand" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button>
                    </h5>
                    <div ibox-tools></div>
                </div> --}}
                <div class="ibox-content">
                    {{-- Locations --}}
                    {{-- <button class="btn btn-primary" data-target="#new_brand" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-equipments">
                        <thead>
                        <tr>
                            {{-- <th>Logo</th> --}}
                            <th>Station Name</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Region</th>
                            <th>Capacity</th>
                            <th>Fuel Tender</th>
                            <th>Remarks</th>
                            <th>Running Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                          
                            @foreach($locations as $key => $location)
                                <tr>
                                    <td>{{$location->location}}</td>
                                    <td>{{$location->location_address}}</td>
                                    <td>{{$location->location_type}}</td>
                                    <td>{{$location->area}}</td>
                                    <td>{{$location->region}}</td>
                                    <td class='text-right'>{{number_format($location->capacity,2)}}</td>
                                    <td><small>
                                        FUEL TENDER DEPOT : {{$location->fuel_tender_depot}} <br>
                                        FUEL TANKER DRIVER : {{$location->fuel_tanker_driver}} <br>
                                        FUEL TENDER MEGA DRUM : {{$location->fuel_tender_mega_drum}} <br>
                                    </small></td>
                                    <td>{{$location->remarks}}</td>
                                    <td>{{number_format($location->actual_fuel,2)}}</td>
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
