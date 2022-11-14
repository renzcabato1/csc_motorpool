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
                    <h5>Vessels
                        <button class="btn btn-primary" data-target="#new_vessel" data-toggle="modal" type="button" title='New Company'><i class="fa fa-plus-circle"></i></button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Vessel Code</th>
                            <th>Vessel Description</th>
                            <th>Vessel Type</th>
                            <th>Status</th>
                            <th>Contract Period</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($vessels as $vessel)
                                <tr>
                                    <td>{{$vessel->vessel_code}}</td>
                                    <td>{{$vessel->description}}</td>
                                    <td>{{$vessel->type_info->name}}</td>
                                    <td>
                                        @php
                                            $contract = ($vessel->contract)->where('contract_to','>',date('Y-m-d'))->count();
                                        @endphp
                                        @if($contract == 0)
                                            <span class="badge badge-primary">Active</span>
                                        @else
                                        <span class="badge badge-danger">Contracted</span>
                                        @endif
                                    </td>
                                    <td>{{($vessel->contract)->where('contract_to','>',date('Y-m-d'))->first()}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  @include('new_vessel')
</div>
@endsection
