<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
   
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        table { 
            border-spacing: 0;
            border-collapse: collapse;
        }
        body{
            font-family: Calibri;
            font-size : 12px;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr >
            <td  align='center' > 
                <img src='{{asset('images/front-logo.png')}}' width='150px' >
            </td>
        </tr>
        <tr>
            <td >
                <br>
                    <strong> FUEL MANAGEMENT SYSTEM </strong><br>
                    FUEL MONITORING REPORT <br>
                    LOCATION:  {{$locations_data->location}}<Br>
                    PERIOD : {{date('M d, Y',strtotime($date_from))}} - {{date('M d, Y',strtotime($date_to))}}<br>
            </td>
        </tr>
    </table>
    <hr>
    <table style='font-size:11px;' width="100%" border="1" cellspacing="1" cellpadding="0">
        <tr align='center' >
            <th>DATE</th>
            <th>DESCRIPTION</th>
            <th>REFERENCE</th>
            <th>ENCODE BY</th>
            <th>IN</th>
            <th>OUT</th>
            {{-- <th>BALANCE</th> --}}
        </tr>
        @foreach($fuels as $fuel)
        <tr >
            <td>{{date('F d, Y',strtotime($fuel->date_fuel))}}</td>
            @if($fuel->type == "receivings")
            <td>
                <small>
                    Vendor Name : {{$fuel->vendor_name}} <br>
                    Received By : {{$fuel->received_by}} <br>
                    Remarks : {{$fuel->remarks}} <br>
                    {{-- Received By : {{$fuel->received_by}} <br> --}}
                </small>
            </td>
            @else

            <td>
                <small>
                    
                    Company : {{$fuel->equipment->company->company_code}} <br>
                    Driver Name : {{$fuel->driver_name}} <br>
                    Equipment : {{$fuel->equipment->company->company_code}}-{{$fuel->equipment->category->category_code}}-{{$fuel->equipment->class->class_code}}-{{str_pad($fuel->equipment->equipment_number, 4, '0', STR_PAD_LEFT)}} / {{$fuel->equipment->plate_number}} / {{$fuel->equipment->conduction_sticker}} <br>
                    Remarks : {{$fuel->remarks}} <br>
                    {{-- Received By : {{$fuel->received_by}} <br> --}}
                </small>
            </td>
            @endif
           
            <td>{{$fuel->reference_number}}</td>
            <td>{{$fuel->user->name}}</td>
            <td>@if($fuel->type == "receivings"){{number_format($fuel->liters,2)}}@endif</td>
            <td>@if($fuel->type != "receivings"){{number_format($fuel->liters,2)}}@endif</td>
            {{-- <td>
                @if($fuel->type == "receivings")
                    {{number_format($fuel->liters+$fuel->previous_fuel,2)}}
                @else
                    {{number_format($fuel->previous_fuel-$fuel->liters,2)}}
                @endif</td> --}}
        </tr>
    @endforeach
      
    </table>
</body>
</html>