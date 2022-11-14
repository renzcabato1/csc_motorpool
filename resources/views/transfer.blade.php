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
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>New
                        {{-- <button class="btn btn-primary" data-target="#new_fuel" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <form method='post' action='tansfer-data' onsubmit='show();' autocomplete="off"  enctype="multipart/form-data" >
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class='row'>
                                <div class='col-md-6'>
                                    Transfer Date :
                                    <input type="date" class="input-sm form-control"  name="date_fuel" id='date_fuel' autocomplete="off"  max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required/>
                                    {{-- <input type="date" class="input-sm form-control"  name="date_fuel" id='date_fuel' autocomplete="off" min="{{date( "Y-m-d", strtotime( "-5 days" ))}}" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required/> --}}
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                From Location :
                                    <select name='location' class='form-control-sm form-control category' onchange='get_fuel_active(this.value)'   required>
                                        <option value=""></option>
                                        @foreach($locations as $key => $location)
                                            @if(($location->location_type == "FUEL STATION") || ($location->location_type == "DEPOT"))
                                                @if(in_array($location->id,((auth()->user()->userLocations)->pluck('location_id'))->toArray()))
                                                    <option value='{{$location->id}}'>{{$location->location}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6'>
                                Capacity :
                                    <input type="text" class="input-sm form-control" id='capacity' name="capacity" autocomplete="off" readonly/>
                                </div>
                                <div class='col-md-6'>
                                Running Balance :
                                    <input type="text" class="input-sm form-control" id='running_balance'  name="running_balance" autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                To Location :
                                    <select name='location_to' class='form-control-sm form-control category' onchange='get_fuel_active_to(this.value)'   required>
                                        <option value=""></option>
                                        @foreach($locations as $key => $location)
                                            @if(($location->location_type == "FUEL TANKER") || ($location->location_type == "MEGA DRUM"))
                                                @if(in_array($location->id,((auth()->user()->userLocations)->pluck('location_id'))->toArray()))
                                                    <option value='{{$location->id}}'>{{$location->location}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6'>
                                Capacity :
                                    <input type="text" class="input-sm form-control" id='capacity_to' name="capacity_to" autocomplete="off" readonly/>
                                </div>
                                <div class='col-md-6'>
                                Running Balance :
                                    <input type="text" class="input-sm form-control" id='running_balance_to'  name="running_balance_to" autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Driver:
                                    <input type="text" class="input-sm form-control"  name="driver" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Total Liters :
                                    <input type="number" class="input-sm form-control" oninvalid="this.setCustomValidity('Available Capacity : '+this.max)"  oninput="this.setCustomValidity('')"   id='total_liters' name="total_liters" step='0.01' min='0.01' autocomplete="off" required/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                Reference Number (DR/SI) :
                                    <input type="text" class="input-sm form-control"  name="reference_number" id='reference_number'  autocomplete="off" required/>
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
                                    <input type="file" class="form-control"  name="supporting_documents"  required/>
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
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Transfer
                        {{-- <button class="btn btn-primary" data-target="#new_fuel" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button> --}}
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example no-margins">
                        <thead>
                        <tr>
                            <th>Reference Number</th>
                            <th>Transfer Date</th>
                            <th>Date Encode</th>
                            <th>Location</th>
                            <th>Total Liters </th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($fuels as $fuel)
                            <tr>
                                <td>{{$fuel->reference_number}}</td>
                                <td>{{date('M d, Y',strtotime($fuel->date_fuel))}}</td>
                                <td>{{date('M d, Y',strtotime($fuel->created_at))}}</td>
                                <td>{{$fuel->locations->location}}</td>
                                <td>{{number_format($fuel->liters,2)}} L</td>
                                <td>{{$fuel->remarks}}</td>
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
    var locations = {!! json_encode($locations->toArray()) !!};
    function get_fuel_active(data)
    {
        var idSample = parseInt(data);

        var item = locations.find(item => item.id === idSample);
        console.log(item.location_type);
        if(item.location_type != "DIRECT SUPPLIER")
        {
        var total_liters = parseFloat(item.capacity)-parseFloat(item.actual_fuel);
        // alert(total_liters);
        document.getElementById("capacity").value = numberWithCommas(item.capacity);
        document.getElementById("running_balance").value = numberWithCommas(item.actual_fuel);
        // document.getElementById("total_liters").max = total_liters;
        }
        else
        {
            var total_liters = parseFloat(item.actual_fuel);
            document.getElementById("capacity").value = numberWithCommas(item.capacity);
            document.getElementById("running_balance").value = numberWithCommas(item.actual_fuel);
            // document.getElementById("total_liters").max = "";
        }   
    
    }
    function get_fuel_active_to(data)
    {
        var idSample = parseInt(data);

        var item = locations.find(item => item.id === idSample);
        console.log(item.location_type);
        if(item.location_type != "DIRECT SUPPLIER")
        {
        var total_liters = parseFloat(item.capacity)-parseFloat(item.actual_fuel);
        // alert(total_liters);
        document.getElementById("capacity_to").value = numberWithCommas(item.capacity);
        document.getElementById("running_balance_to").value = numberWithCommas(item.actual_fuel);
        document.getElementById("total_liters").max = total_liters;
        }
        else
        {
            var total_liters = parseFloat(item.actual_fuel);
            document.getElementById("capacity_to").value = numberWithCommas(item.capacity);
            document.getElementById("running_balance_to").value = numberWithCommas(item.actual_fuel);
            document.getElementById("total_liters").max = "";
        }   
    
    }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
</script>
@endsection
