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
        <div class="col-lg-6 ">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Brands
                        <button class="btn btn-primary" data-target="#new_brand" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp; New Brand</button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            {{-- <th>Logo</th> --}}
                            <th>Brand Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          
                            @foreach($brands as $key => $brand)
                                
                                <tr data-id='{{$brand->id}}'>
                                    {{-- <td style='text-align: center;' id='logotd{{$brand->id}}'>
                                        <img  src="{{ asset($brand->logo) }}" class="m-b-md border" alt="profile" height='75px;' width='75px;'>
                                    </td> --}}
                                    <td style='text-align: center;' id='brand_name{{$brand->id}}'>{{$brand->brand_name}}</td>
                                    <td id='statustd{{$brand->id}}'>@if($brand->status) <small class='label label-danger'>Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                    <td id='actiontd{{$brand->id}}' data-id='{{$brand->id}}'>
                                        
                                        @if($brand->status)
                                            <button class="btn btn-sm btn-primary activate-brand" title="Activate"><i class="fa fa-check"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-info"  title='Edit' data-target="#editBrand{{$brand->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger deactivate-brand" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                        @endif
                                        {{-- <button class="btn btn-sm btn-info" data-target="#change_pass{{$company->id}}" data-toggle="modal">Change Password</button> --}}
                                        {{-- <button class="btn btn-sm btn-danger delete-comp" data-target="#deletecomp{{$company->id}}" data-toggle="modal">Delete</button> --}}
                                    </td>       
                                </tr>
                                @include('edit_brand') 
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
       
    </div>
  
</div>
  @include('new_brand')
@endsection
