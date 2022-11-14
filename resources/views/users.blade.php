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
                    <h5>Users
                        <button class="btn btn-primary" data-target="#new_account" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp; New Account</button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Approver</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->company->company_name}}</td>
                                    <td>{{$user->department->department_name}}</td>
                                    <td>{{$user->role->role}}</td>
                                    <td>@if($user->approver){{$user->approver->name}}@endif</td>
                                    <td  id='statususer{{$user->id}}'>@if($user->status) <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                    <td data-id='{{$user->id}}' id='actionuser{{$user->id}}'>

                                            @if($user->status)

                                        <button class="btn btn-sm btn-primary activate-user" title="Activate"><i class="fa fa-user-circle"></i></button>
                                            @else
                                            <button class="btn btn-sm btn-warning" data-target="#change_pass{{$user->id}}" data-toggle="modal" title='change password' ><i class="fa fa-user-circle"></i></button>
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editUser{{$user->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                            @if(Auth::user()->id != $user->id)<button class="btn btn-sm btn-danger deactivate-user" title='Deactivate' ><i class="fa fa-trash"></i></button>@endif
                                        @endif
                                    </td>
                                </tr>
                                @include('edit_user') 
                                @include('changepassword') 
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
  
</div>
  @include('new_account')
@endsection
