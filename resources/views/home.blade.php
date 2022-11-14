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
                    <h5>Numbe of Vessel Contracted</h5>
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
                    <h5> Expiry Contract</h5>
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
                    <h5>Vessel Under Maintenance</h5>
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
                    <h5>Fuel Dispatch</h5>
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
                    <span class="label label-warning pull-right">as of this month ({{date('M Y')}})</span>
                    <h5>Fuel Dispatch</h5>
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
                    <span class="label label-success pull-right">as of Today ({{date('M d, Y')}})</span>
                    <h5>Fuel Transfer</h5>
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
                    <span class="label label-danger pull-right">as of This Month ({{date('M Y')}})</span>
                    <h5>Fuel Transfer</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$for_repair_equipment}}</h1>
                    {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        @endif
    </div>
  

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
