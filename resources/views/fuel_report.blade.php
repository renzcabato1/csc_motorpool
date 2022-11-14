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
                            <label class="font-normal">Equipment </label>
                            <select name='equipment_category' class='form-control-sm form-control category' required>
                                <option value=""></option>
                                @foreach($equipments as $key => $equipment )
                                    <option value='{{$equipment->id}}' {{($equipment->id == $equipment_id) ? "selected":"" }}>{{$equipment->old_equipment_data}} / {{$equipment->company->company_code}}-{{$equipment->category->category_code}}-{{$equipment->class->class_code}}-{{str_pad($equipment->equipment_number, 4, '0', STR_PAD_LEFT)}} / {{$equipment->plate_number}} / {{$equipment->conduction_sticker}}</option>
                                
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
                    <h5>Fuel Monitoring Report @if(count($fuels) != 0) <a target='_blank' href='{{ url('/fuel-monitoring-export?equipment_category='.$equipment_id.'&date_from='.$date_from.'&date_to='.$date_to.'') }}'><button class="btn btn-primary" type="button"><i class="fa fa-print"></i>Export &nbsp;</button></a>@endif</h5>
                    {{-- <div ibox-tools></div> --}}
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Previous Odometer</th>
                            <th>Ending Odometer</th>
                            <th>Liters</th>
                            <th>Km. Run</th>
                            <th>Location</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($fuels) == 0)
                                <tr class="text-center">
                                    <td class="text-center" colspan='6'>No Data Found</td>
                                </tr>
                            @else
                                @php
                                    $total_km_run = 0;
                                    $total_liters = 0;
                                @endphp
                                @foreach($fuels as $key => $fuel)
                                @php
                                    $total_liters = $total_liters + $fuel->liters;
                                @endphp
                                <tr>
                                    <td>{{date('M d, Y',strtotime($fuel->date_fuel))}}</td>
                                    <td>{{number_format($fuel->previous_odometer)}} KM</td>
                                    <td>{{number_format($fuel->ending_odometer)}} KM</td>
                                    <td>{{number_format($fuel->liters,2)}} L</td>
                                    <td>
                                        @php
                                        if(is_numeric($fuel->previous_odometer))
                                        {
                                            $fuel_cons = $fuel->ending_odometer-$fuel->previous_odometer;
                                          
                                        }
                                        else 
                                        {
                                            $fuel_cons = 0;
                                        }
                    
                                        $total_km_run = $total_km_run + $fuel_cons;
                                    @endphp   
                                    {{number_format($fuel_cons) }} KM
                                    </td>
                                    <td>{{$fuel->locations->location}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan='6' class="text-center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan='4' class="text-right"></td>
                                    <td  class="text-right">TOTAL KM RUN</td>
                                    <td  class="text-left"><strong>{{number_format($total_km_run) }} KM</strong></td>
                                </tr>
                                <tr>
                                    <td colspan='4' class="text-right"></td>
                                    <td  class="text-right">TOTAL LITERS CONSUMED</td>
                                    <td  class="text-left"><strong>{{number_format($total_liters,2)}} L</strong></td>
                                </tr>
                                <tr>
                                    <td colspan='4' class="text-right"></td>
                                    <td class="text-right">AVERAGE LITER/KM</td>
                                    <td class="text-left"><strong>@if($total_km_run == 0) 0 @else{{number_format($total_liters/$total_km_run,2)}} @endif L/KM</strong></td>
         
                                </tr>
                            @endif
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
