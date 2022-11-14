
<div class="modal" id="edit_request{{$request->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">Edit Request</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-request/{{$request->id}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='row'>
                        <div class='col-md-4'>
                            Name : {{Auth::user()->name}}
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Company : {{Auth::user()->company->company_name}}({{Auth::user()->company->company_code}})
                        </div>
                        <div class='col-md-6'>
                            Department : {{Auth::user()->department->department_name}}({{Auth::user()->department->department_code}})
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Approver : {{Auth::user()->approver->name}}
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-md-6'>
                            Equipment Class :
                            <select name='equipment_category' class='form-control-sm form-control cat' required>
                                <option value=""></option>
                                @foreach($classes as $key => $class )
                                    @if($class->status)
                                    @else
                                    <option value='{{$class->id}}*{{$class->class_description}}' @if($class->id == $request->class_id) selected @endif>{{$class->class_code}} - {{$class->class_description}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type='hidden' name='approver_id' value='{{Auth::user()->approver->id}}'>
                        </div>
                        <div class='col-md-3 text-right'>
                            &nbsp;<br>
                            <label> <input type="checkbox" id='project{{$request->id}}' name="project" onchange="project_control_edit({{$request->id}})" @if($request->is_project == 1) checked @endif  value="1"> Is Project?</label>
                        </div>
                        <div class='col-md-3' id='project_id_data{{$request->id}}' @if($request->is_project == "") style='display:none;' @endif  >
                            Project ID : 
                            <select name='project_id' id='project_id{{$request->id}}' class='form-control-sm form-control cat'  onchange='select_project_edit(this.value,{{$request->id}})' @if($request->is_project == 1) required @else readonly @endif >
                                <option value="" ></option>
                                @foreach($projects as $project)
                                <option value="{{$project->id}}" @if($project->id == $request->project_id) selected @endif>{{$project->project_id}}</option>
                                @endforeach
                            </select>    
                            {{-- <input type="text" class="form-control-sm form-control "  id='project_id{{$request->id}}' value="{{$request->project_id}}"  name="project_id"  @if($request->is_project == 1) required @else readonly @endif /> --}}
                        </div>
                    </div>
                    <Br>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class="form-group" id="data_5">
                                <label class="font-normal">Date Needed</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" onkeydown="return false" name="date_start" autocomplete="off" value="{{date('m-d-Y',strtotime($request->date_from_needed))}}" required/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" onkeydown="return false" name="date_end" autocomplete="off" value="{{date('m-d-Y',strtotime($request->date_to_needed))}}" required/>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group" >
                                <label class="font-normal"> Time Needed</label>
                                <div class="row">
                                    <div class='col-md-5'>
                                        <input type="time"   class="input-sm form-control" name="time_from"  value="{{$request->time_from_needed}}" required >
                                    </div>
                                    to
                                    <div class='col-md-5'>
                                        <input type="time"  class="input-sm form-control" name="time_to" value="{{$request->time_to_needed}}" required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Location : 
                             <input type="text" id='location{{$request->id}}' class="form-control-sm form-control " @if($request->project_id) readonly @endif value="{{$request->location}}"  name="location" required/>
                        </div>
                        <div class='col-md-6'>
                            Area : 
                            <select name='area' id='area{{$request->id}}' class='form-control-sm form-control' @if($request->project_id) readonly @endif required>
                                <option value=""></option>
                                @if($request->project_id == "")
                                    <option value="Luzon" @if($request->area == "Luzon") selected @endif>Luzon</option>
                                    <option value="Visayas" @if($request->area == "Visayas") selected @endif>Visayas</option>
                                    <option value="Mindanao" @if($request->area == "Mindanao") selected @endif>Mindanao</option>
                                @else
                                    <option value="{{$request->area}}" selected>{{$request->area}}</option> 
                                @endif
                            </select>    
                        </div>
                    </div>
                    <Br>
                        <div class='row'>
                            <div class='col-md-12'>
                                Remarks : 
                                <textarea class='form-control' name='remarks' required>{{$request->remarks}}</textarea>
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
<script>
     var projects = {!! json_encode($projects->toArray()) !!};
    function select_project_edit(value,id)
    {

        for(var i = 0;i<projects.length;i++)
        {
            if(projects[i].id  == value)
            {
                // alert(id);
                $("#area"+id).empty();
                $("#location"+id).val(projects[i].location);
                $("#area"+id).append("<option value='"+projects[i].area+"' selected>"+projects[i].area+"</option>");
                $("#area"+id).val(projects[i].area);

                break;
            }
        }
          

    }
    function project_control_edit(id)
    {
        var check = $('#project'+id).is(':checked'); 
        if(check == true)
        {
            $("#area"+id).empty();
            $("#project_id"+id).attr("readonly", false); 
            document.getElementById("project_id_data"+id).style.display="block";
            $("#project_id"+id).prop('required',true);
            $("#location"+id).attr("readonly", true); 
            $("#area"+id).attr("readonly", true); 
            $("#location"+id).val('');
            $("#area"+id).val('');

        }
        else
        {
            $("#area"+id).empty();
            $("#area"+id).append("<option value='' selected></option>");   
            $("#area"+id).append("<option value='Luzon'>Luzon</option>");   
            $("#area"+id).append("<option value='Visayas' selected>Visayas</option>");   
            $("#area"+id).append("<option value='Mindanao' selected>Mindanao</option>");   
            $("#project_id"+id+"_chosen a span").html("Please select Project");
            $("#project_id"+id).attr("readonly", true); 
            $("#project_id"+id).prop('required',false);
            document.getElementById("project_id_data"+id).style.display="none";
            $('#project_id'+id).val('');  
            $("#location"+id).attr("readonly", false); 
            $("#area"+id).attr("readonly", false); 
            $("#location"+id).val('');
            $("#area"+id).val('');
        }
    }
</script>