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
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>New
                        {{-- <button class="btn btn-primary" data-target="#new_fuel" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <form method='post' action='new-fuel' onsubmit='show();' autocomplete="off"  enctype="multipart/form-data" >
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class='row'>
                                <div class='col-md-6'>
                                    Date :
                                    <input type="date" class="input-sm form-control"  name="date_fuel" id='date_fuel' autocomplete="off"  value="{{date('Y-m-d')}}" required/>
                                    {{-- <input type="date" class="input-sm form-control"  name="date_fuel" id='date_fuel' autocomplete="off" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required/> --}}
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                    Type :
                                    <select name='type_requests' class='form-control-sm form-control category' onchange='type_request(value)' required>
                                        <option value=""></option>
                                        <option value="Equipment">Equipment</option>
                                        <option value="Generator">Generator / Pumps / Towerlights</option>
                                        <option value="Affiliates">Affiliates</option>
                                        <option value="Production">Production</option>
                                        <option value="External">External</option>
                                    
                                    </select>
                                </div>
                            </div>
                            <div class='row' id='equipment' style='display:none;'>
                                <div class='col-md-12'>
                                    Equipment :
                                    <select name='equipment_category' id='equipment_category' class='form-control-sm form-control category' onchange='start_data(value)' >
                                        <option value=""></option>
                                        @foreach($equipments as $key => $equipment )
                                            <option value='{{$equipment->id}}-{{$key}}'>{{$equipment->old_equipment_data}} / {{$equipment->company->company_code}}-{{$equipment->category->category_code}}-{{$equipment->class->class_code}}-{{str_pad($equipment->equipment_number, 4, '0', STR_PAD_LEFT)}} / {{$equipment->plate_number}} / {{$equipment->conduction_sticker}} / {{$equipment->location}}</option>
                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row' id='generator' style='display:none;'>
                                <div class='col-md-12'>
                                    Generator :
                                    <select name='generator_category' id='generator_category' class='form-control-sm form-control category'  >
                                        <option value=""></option>
                                        @foreach($generators as $generator)
                                            <option value="{{$generator->id}}">{{$generator->site}} - {{$generator->brand}} - {{$generator->model}} - {{$generator->serial_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row' id='affiliates' style='display:none;'>
                                <div class='col-md-12'>
                                    Affiliates :
                                    <select name='affiliates_category' id='affiliates_category' class='form-control-sm form-control category'  >
                                        <option value=""></option>
                                        @foreach($companies as $company)
                                            <option value='{{$company->id}}'>{{$company->company_code}} - {{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row' id='others' style='display:none;'>
                                <div class='col-md-12'>
                                    External :
                                    <textarea type="text" class="form-control"  name="others_category" id='others_category' ></textarea>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Location of Fuel Station :
                                    <select name='location' class='form-control-sm form-control category' onchange='get_fuel_active(this.value)'  required>
                                        <option value=""></option>
                                        @foreach($locations as $key => $location )
                                            @if(in_array($location->id,((auth()->user()->userLocations)->pluck('location_id'))->toArray()))
                                                <option value='{{$location->id}}' >{{$location->location}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class='row'>
                                <div class='col-md-12'>
                                Available Fuel :
                                    <input type="text" class="input-sm form-control"  id='available_fuel' autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Issuance Number :
                                    <input type="text" class="input-sm form-control"  name="reference_number" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Driver Name :
                                    <input type="text" class="input-sm form-control"  name="driver_name" id='driver_name' autocomplete="off" required/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Total Liters Issued:
                                    <input type="number" class="input-sm form-control" oninvalid="this.setCustomValidity('Available Fuel : '+this.max)"  oninput="this.setCustomValidity('')" name="total_liters" id='total_liters' step='0.01' min='0.01' autocomplete="off" required/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6'>
                                Previous Odometer :
                                    <input type="text" class="input-sm form-control"  name="starting_odometer" id='starting_odometer'  autocomplete="off" readonly/>
                                </div>
                                <div class='col-md-6'>
                                Ending Odometer :
                                    <input type="number" class="input-sm form-control"  name="ending_odometer"  id='ending_odometer'  step='0' min='0' autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                    Purpose  :
                                    <textarea type="text" class="form-control"  name="remarks" id='remarks' required></textarea>
                                </div>
                               
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                    Supporting Document <i>(Max of 10MB)</i> :
                                    <input type="file" class="form-control"  name="supporting_documents"   required/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type='submit'  class="btn btn-primary" >Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Fuels 
                        {{-- <button class="btn btn-primary" data-target="#new_fuel" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-3">
                            <select name='location' class='form-control-sm form-control location' onchange='get_fuel_balance(this.value)'  required>
                                <option value="">Location</option>
                                @foreach($locations as $key => $location )
                                @if(in_array($location->id,((auth()->user()->userLocations)->pluck('location_id'))->toArray()))
                                    <option value='{{$location->id}}'>{{$location->location}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            Ending Balance : <span id='ending_balance'></span>
                        </div>
                    </div>
                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Issuance Number</th>
                            <th>Date</th>
                            <th>Information</th>
                            <th>Driver Name</th>
                            <th>Total Liters</th>
                            <th>Encode By</th>
                            <th>Location</th>
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
                                        Generator  :     @if($fuel->generator){{($fuel->generator->brand)}} -  {{($fuel->generator->model)}}@endif<br>
                                        @elseif($fuel->request_type == "Affiliates")
                                        Company  :@if($fuel->company_details != null) {{$fuel->company_details->company_code}} @endif
                                        @else
                                            {{$fuel->others}}
                                        @endif
                                        </small>
                                    </td>
                                    <td>{{$fuel->driver_name}}</td>
                                    <td>{{number_format($fuel->liters,2)}} L</td>
                                    <td>{{$fuel->user->name}}</td>
                                    <td>{{$fuel->locations->location}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@include('new_fuel')
<script>
    function type_request(value)
    {
        
        if(value == "Equipment")
        {
            document.getElementById("equipment").style.display = "block";
            document.getElementById("equipment_category").required = true;
            document.getElementById("ending_odometer").required = true;
            $("#ending_odometer").attr("readonly", false); 
            
            document.getElementById("generator").style.display = "none";
            document.getElementById("generator_category").required = false;

            document.getElementById("affiliates").style.display = "none";
            document.getElementById("affiliates_category").required = false;

            document.getElementById("others").style.display = "none";
            document.getElementById("others_category").required = false;

            document.getElementById("driver_name").value = "";
            $("#driver_name").prop("readonly", false);
            document.getElementById("driver_name").required = true;
            
            
        }
        else if(value == "Generator")
        {
            document.getElementById("equipment").style.display = "none";
            document.getElementById("equipment_category").required = false;
            document.getElementById("ending_odometer").required = false;
            $("#ending_odometer").attr("readonly", true); 

            document.getElementById("generator").style.display = "block";
            document.getElementById("generator_category").required = true;

            document.getElementById("affiliates").style.display = "none";
            document.getElementById("affiliates_category").required = false;

   

            document.getElementById("others").style.display = "none";
            document.getElementById("others_category").required = false;

            document.getElementById("driver_name").value = "";
            $("#driver_name").prop("readonly", false);
            document.getElementById("driver_name").required = true;

        }
        else if(value == "Affiliates")
        {
            document.getElementById("equipment").style.display = "none";
            document.getElementById("equipment_category").required = false;
            document.getElementById("ending_odometer").required = false;
            $("#ending_odometer").attr("readonly", true); 

            document.getElementById("generator").style.display = "none";
            document.getElementById("generator_category").required = false;

            document.getElementById("affiliates").style.display = "block";
            document.getElementById("affiliates_category").required = true;

            document.getElementById("others").style.display = "none";
            document.getElementById("others_category").required = false;

            document.getElementById("driver_name").value = "";
            $("#driver_name").prop("readonly", false);
            document.getElementById("driver_name").required = true;
        }
        else if(value == "Production")
        {
            document.getElementById("equipment").style.display = "none";
            document.getElementById("equipment_category").required = false;
            document.getElementById("ending_odometer").required = false;
            $("#ending_odometer").attr("readonly", true); 

            document.getElementById("generator").style.display = "none";
            document.getElementById("generator_category").required = false;

            document.getElementById("affiliates").style.display = "none";
            document.getElementById("affiliates_category").required = false;

            document.getElementById("driver_name").readonly = true;
            document.getElementById("driver_name").value = "";
            $("#driver_name").prop("readonly", true);
            document.getElementById("driver_name").required = false;

            document.getElementById("others").style.display = "none";
            document.getElementById("others_category").required = false;
        }
        else
        {
            document.getElementById("equipment").style.display = "none";
            document.getElementById("equipment_category").required = false;
            document.getElementById("ending_odometer").required = false;
            $("#ending_odometer").attr("readonly", true); 

            document.getElementById("generator").style.display = "none";
            document.getElementById("generator_category").required = false;

            document.getElementById("affiliates").style.display = "none";
            document.getElementById("affiliates_category").required = false;

            document.getElementById("others").style.display = "block";
            document.getElementById("others_category").required = true;

            document.getElementById("driver_name").value = "";
            $("#driver_name").prop("readonly", false);
            document.getElementById("driver_name").required = true;
        }
    }
</script>
@endsection
