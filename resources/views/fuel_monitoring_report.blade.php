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
                    <strong> MOTORPOOL MANAGEMENT SYSTEM </strong><br>
                    FUEL MONITORING REPORT <br>
                    EQUIPMENT: {{$equipment->company->company_code}}-{{$equipment->category->category_code}}-{{$equipment->class->class_code}}-{{str_pad($equipment->equipment_number, 4, '0', STR_PAD_LEFT)}} <Br>
                    PERIOD : {{date('M d, Y',strtotime($date_from))}} - {{date('M d, Y',strtotime($date_to))}}<br>
            </td>
        </tr>
    </table>
    <hr>
    <table style='font-size:11px;' width="100%" border="1" cellspacing="1" cellpadding="0">
        <tr align='center' >
            <td>DATE</td>
            <td>PREVIOUS ODOMETER</td>
            <td>ENDING ODOMETER</td>
            <td>Liters</td>
            <td>KM. RUN</td>
            <td>LOCATION</td>
        </tr>
            @php
                $total_km_run = 0;
                $total_liters = 0;
            @endphp
            @foreach($fuels as $key => $fuel)
            @php
                $total_liters = $total_liters + $fuel->liters;
            @endphp
            <tr align='center' >
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
    </table>
</body>
</html>