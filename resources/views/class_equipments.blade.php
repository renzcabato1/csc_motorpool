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
                    <h5>Class
                        <button class="btn btn-primary" data-target="#new_class" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp; New Class</button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Class Code</th>
                            <th>Class Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($class_equipments as $class)
                            <tr>
                                <td style='text-align: center;'>
                                    {{$class->class_code}}
                                </td>
                                <td style='text-align: center;'>{{$class->class_description}}</td>
                                <td>{{$class->category->category_code}}</td>
                                <td id='statusclass{{$class->id}}' >
                                    @if($class->status) <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif
                                </td>
                                <td data-id='{{$class->id}}' id='actionclasstd{{$class->id}}'>
                                    @if($class->status)
                                        <button class="btn btn-sm btn-primary activate-class" title="Activate"><i class="fa fa-check"></i></button>
                                    @else
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editClass{{$class->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger deactivate-class" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @include('edit_class') 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-1 ">
            
        </div>
        <div class="col-lg-5 ">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Category
                        <button class="btn btn-primary" data-target="#new_category" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp; New Category</button>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">

                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>Category Code</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td style='text-align: center;'>
                                    {{$category->category_code}}
                                </td>
                                <td style='text-align: center;'>{{$category->equipment}}</td>
                                <td id='statuscategory{{$category->id}}'>@if($category->status) <small class="label label-danger">Inactive</small>  @else <small class="label label-primary">Active</small> @endif</td>
                                <td data-id='{{$category->id}}' id='actioncategorytd{{$category->id}}' >
                                    @if($category->status)
                                        <button class="btn btn-sm btn-primary activate-category" title="Activate"><i class="fa fa-check"></i></button>
                                    @else
                                        <button class="btn btn-sm btn-info"  title='Edit' data-target="#editCategory{{$category->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger deactivate-category" title='Deactivate' ><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @include('edit_category') 
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
  @include('new_class')
  @include('new_category')
@endsection
