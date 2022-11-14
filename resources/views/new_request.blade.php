
<div class="modal" id="new_request" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Request ({{date('F d, Y')}})</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-request' onsubmit='show();'  enctype="multipart/form-data" >
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
                            <button class="btn btn-primary btn-sm mb-2" onclick='add_equipment();' type="button"><i class="fa fa-plus"></i></button> Equipment Class :
                            <div id='equipments_datas'>
                                <select name='equipment_category[]' id='1' class='form-control-sm form-control cat' required>
                                    <option value=""></option>
                                    @foreach($classes as $key => $class )
                                        @if($class->status)
                                        @else
                                        <option value='{{$class->id}}*{{$class->class_description}}'>{{$class->class_code}} - {{$class->class_description}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type='hidden' name='approver_id' value='{{Auth::user()->approver->id}}'>
                        </div>
                        <div class='col-md-2 text-right'>
                            &nbsp;<br>
                            <label> <input type="checkbox" id='project' name="project" onchange="project_control()"  value="1"> Is Project?</label>
                        </div>
                        <div class='col-md-4' id='project_id_data' style='display:none;'>
                            Project ID : 
                            <select name='project_id' id='project_id' class='form-control-sm form-control cat'  onchange='select_project(this.value)' readonly="readonly">
                                <option value="" ></option>
                                @foreach($projects as $project)
                                <option value="{{$project->id}}" >{{$project->project_id}}</option>
                                @endforeach
                            </select>    
                        </div>
                    </div>
                    <hr>
                    <Br>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class="form-group" id="data_5">
                                <label class="font-normal">Date Needed</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" onkeydown="return false" name="date_start" autocomplete="off" value="" required/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" onkeydown="return false" name="date_end" autocomplete="off" value="" required/>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group" >
                                <label class="font-normal"> Time Needed</label>
                                <div class="row">
                                    <div class='col-md-5'>
                                        <input type="time"   class="input-sm form-control" name="time_from" required >
                                    </div>
                                    to
                                    <div class='col-md-5'>
                                        <input type="time"  class="input-sm form-control" name="time_to" required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Location : 
                             <input type="text" class="form-control-sm form-control "  id='location' value="{{ old('location') }}"  name="location" required/>
                        </div>
                        <div class='col-md-6'>
                            Area : 
                        <select name='area' id='area' class='form-control-sm form-control' required>
                            <option value=""></option>
                            <option value="Luzon">Luzon</option>
                            <option value="Visayas">Visayas</option>
                            <option value="Mindanao">Mindanao</option>
                        </select>    
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Remarks : 
                            <textarea class='form-control' name='remarks' required></textarea>
                        </div>
                    </div>
                    <hr>
                    
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

    function select_project(value)
    {

        for(var i = 0;i<projects.length;i++)
        {
            if(projects[i].id  == value)
           
            {
                $("#area").empty();
                $("#location").val(projects[i].location);
                $("#area").append("<option value='"+projects[i].area+"' selected>"+projects[i].area+"</option>");
                break;
            }
        }
          

    }
    function project_control()
    {
        var check = $('#project').is(':checked'); 
        if(check == true)
        {
            $("#area").empty();
            $("#project_id").attr("readonly", false); 
            document.getElementById("project_id_data").style.display="block";
            $("#project_id").prop('required',true);
            $("#location").attr("readonly", true); 
            $("#area").attr("readonly", true); 
            $("#location").val('');
            $("#area").val('');
        }
        else
        {
            $("#area").empty();
            $("#area").append("<option value='' selected></option>");   
            $("#area").append("<option value='Luzon'>Luzon</option>");   
            $("#area").append("<option value='Visayas' selected>Visayas</option>");   
            $("#area").append("<option value='Mindanao' selected>Mindanao</option>");   
            $("#project_id_chosen a span").html("Please select Project");
            document.getElementById("project_id_data").style.display="none";
            $("#project_id").attr("readonly", true); 
            $("#project_id").prop('required',false);
            $('#project_id').val('');  
            $("#location").attr("readonly", false); 
            $("#area").attr("readonly", false); 
            $("#location").val('');
            $("#area").val('');
        }
    }
    function add_equipment()
    { 
        var idEquipment = $('#equipments_datas').children().last().attr('id');
        var idEquipmentData = parseInt(idEquipment) + 1;
        var equip_select = "<div class='input-group mt-3' id='"+idEquipmentData+"'><select name='equipment_category[]'  class='form-control-sm form-control cat mt-2' required>";
            equip_select+= "<option value=''></option>";
            equip_select+= "@foreach($classes as $key => $class )";
            equip_select+= "@if($class->status)";
            equip_select+= "@else";
            equip_select+= "<option value='{{$class->id}}*{{$class->class_description}}'>{{$class->class_code}} - {{$class->class_description}}</option>";
            equip_select+= "@endif";
            equip_select+= "@endforeach";
            equip_select+= "</select><div class='input-group-append'>";
            equip_select+= "<span onclick='remove_equipment("+idEquipmentData+")' class='btn btn-danger  btn-outline'><i  class='fa fa-window-close-o'></i></span></div></div>";
            
        $("#equipments_datas").append(equip_select);
        $('.cat').chosen({width: "100%"});
    }
    function remove_equipment(data)
    { 
        console.log(data);
        $('#'+data).remove();
    }
</script>