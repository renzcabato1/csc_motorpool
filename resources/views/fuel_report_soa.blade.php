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
        <div class="ibox ">
            <div class="ibox-content">
                <form  method='GET' onsubmit='show();'  enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="font-normal">Locations </label>
                            <select name='equipment_category' class='form-control-sm form-control category' required>
                                <option value=""></option>
                                <option value="All" {{("All" == $location_id) ? "selected":"" }}>All</option>
                                @foreach($locations as $key => $location )
                                    <option value='{{$location->id}}' {{($location->id == $location_id) ? "selected":"" }}>{{$location->location}}</option>
                                
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="font-normal">Date From</label>
                            <input type='date' name='date_from' id='date_from' class='form-control' onchange='date_from_fuel(this.value);' value='{{$date_from}}' max='{{date('Y-m-d')}}'  required>
                        </div>
                        <div class="col-lg-2">
                            <label class="font-normal">Date To</label>
                            <input type='date' name='date_to' id='date_to' class='form-control' min='{{$date_from}}'  max='{{date('Y-m-d')}}' value='{{$date_to}}' required>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary mt-4" type="submit" id='submit'><i class="fa fa-check"></i>&nbsp;Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Fuel Monitoring Report 
                        {{-- @if(count($fuels) != 0) <a target='_blank' href='{{ url('/fuel-export?equipment_category='.$location_id.'&date_from='.$date_from.'&date_to='.$date_to.'') }}'><button class="btn btn-primary" type="button"><i class="fa fa-print"></i>Export &nbsp;</button></a>@endif --}}
                    </h5>
                    {{-- <div ibox-tools></div> --}}
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover fuel-reports">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Vendor Name/Driver name</th>
                                <th>Received By/Equipment</th>
                                <th>Remarks</th>
                                <th>Reference</th>
                                <th>Encode By</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Attachment</th>
                                {{-- <th>Balance</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($fuels as $fuel)
                                <tr>
                                    <td>{{$fuel->locations->location}}</td>
                                    <td>{{date('F d, Y',strtotime($fuel->date_fuel))}}</td>
                                    @if($fuel->type == "receivings")
                                    <td>
                                            Vendor Name : {{$fuel->vendor_name}} 
                                       
                                    </td>
                                    <td>
                                            Received By : {{$fuel->received_by}} <br>
                                            
                                    </td>
                                    <td>
                                            {{$fuel->remarks}} <br>
                                            
                                        </td>
                                        @else

                                        <td>
                                                Driver Name : {{$fuel->driver_name}} <br>
                                            
                                        </td>
                                        <td>
                                            <small>
                                                Request type : {{$fuel->request_type}} <Br>
                                                @if($fuel->request_type == "Equipment")
                                               
                                                Company  :     {{($fuel->equipment->company->company_code)}} <br>
                                                Equipment Code  :     {{$fuel->equipment->company->company_code}}-{{$fuel->equipment->category->category_code}}-{{$fuel->equipment->class->class_code}}-{{str_pad($fuel->equipment->equipment_number, 4, '0', STR_PAD_LEFT)}}  <br>
                                                Old Code :  {{$fuel->equipment->old_code}}
                                                Ending Odometer : {{number_format($fuel->ending_odometer)}} KM
                                                @elseif($fuel->request_type == "Generator")
                                                Generator  :     @if($fuel->generator){{($fuel->generator->brand)}} -  {{($fuel->generator->model)}} @endif<br>
                                                @elseif($fuel->request_type == "Affiliates")
                                                Company  : {{$fuel->company_details->company_code}}
                                                @else
                                                    {{$fuel->others}}
                                                @endif
                                                </small>
                                            
                                        </td>
                                        <td>
                                                {{$fuel->remarks}} <br>
                                            
                                        </td>
                                        @endif
                                    
                                        <td>{{$fuel->reference_number}}</td>
                                        <td>{{$fuel->user->name}}</td>
                                        <td>@if($fuel->type == "receivings"){{number_format($fuel->liters,2)}}@endif</td>
                                        <td>@if($fuel->type != "receivings"){{number_format($fuel->liters,2)}}@endif</td>
                                        <td>@if($fuel->attachment_file)<a href='{{url($fuel->attachment_file)}}' target='_blank'>Attachment </a>@endif</td>
                                        {{-- <td>
                                            @if($fuel->type == "receivings")
                                                {{number_format($fuel->liters+$fuel->previous_fuel,2)}}
                                            @else
                                                {{number_format($fuel->previous_fuel-$fuel->liters,2)}}
                                            @endif
                                        </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function date_from_fuel(value)
    {
        document.getElementById('date_to').value = '';
        document.getElementById('date_to').min = value;
    }
</script>
@endsection
