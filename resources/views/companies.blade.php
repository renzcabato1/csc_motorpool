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
                    <h5>Companies
                        <button class="btn btn-primary" data-target="#new_company" data-toggle="modal" type="button" title='New Company'><i class="fa fa-plus-circle"></i></button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            
                            <th>Company Code</th>
                            <th>Company Name</th>
                            <th>Status</th>
                            {{-- <th>Date Created</th> --}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{$company->company_code}}</td>
                                    <td>{{$company->company_name}}</td>
                                    <td id='statuscompanytd{{$company->id}}'>@if($company->status) <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                    <td data-id='{{$company->id}}' id='actioncompanytd{{$company->id}}'>
                                        @if($company->status)
                                        <button class="btn btn-sm btn-primary activate-company" title="Activate"><i class="fa fa-check"></i></button>
                                        @else
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editCompany{{$company->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger deactivate-company" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                {{-- @include('changepassword') --}}
                                @include('edit_company') 
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Insurance Companies
                        <button class="btn btn-primary" data-target="#new_insurance" data-toggle="modal" type="button" title='New Insurance'><i class="fa fa-plus-circle"></i></button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            
                            <th>Company Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          
                            @foreach($insurances as $insurance)
                                <tr>
                                    
                                    <td>{{$insurance->company}}</td>
                                    <td id='statusinsurancetd{{$insurance->id}}'>@if($insurance->status) <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                    <td data-id='{{$insurance->id}}' id='actioninsurancetd{{$insurance->id}}'>
                                        @if($insurance->status)
                                        <button class="btn btn-sm btn-primary activate-insurance" title="Activate"><i class="fa fa-check"></i></button>
                                        @else
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editInsurance{{$insurance->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger deactivate-insurance" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @include('edit_insurance') 
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
  
</div>
  @include('new_company')
  @include('new_insurance')
@endsection
