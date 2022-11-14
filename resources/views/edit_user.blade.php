
<div class="modal" id="editUser{{$user->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" >Edit User</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-user/{{$user->id}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='col-md-12'>
                        Name :
                        <input type="text" class="form-control-sm form-control "  value="{{$user->name}}"  name="name" required/>
                     </div>
                    <div class='col-md-12'>
                        Email :
                        <input type="email" class="form-control-sm form-control "  value="{{$user->email}}"  name="email" required/>
                     </div>
                    <div class='col-md-12'>
                        Company :
                        <select name='company' class='form-control-sm form-control cat' required>
                            <option value=""></option>
                            @foreach($companies as $company)
                                @if($company->status)
                                @else
                                <option value='{{$company->id}}' @if($user->company_id == $company->id) selected @endif>{{$company->company_code}} - {{$company->company_name}}</option>
                                @endif
                            @endforeach
                        </select>
                     </div>
                    <div class='col-md-12'>
                        Department :
                        <select name='department' class='form-control-sm form-control cat' required>
                            <option value=""></option>
                            @foreach($departments as $dep)
                                @if($dep->status)
                                @else
                                <option value='{{$dep->id}}' @if($user->department_id == $dep->id) selected @endif>{{$dep->department_code}} - {{$dep->department_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-12'>
                        Role :
                        <select name='role' class='form-control-sm form-control cat' onchange='changeapproverEdit(this.value,{{$user->id}})' required>
                            <option value=""></option>
                            @foreach($roles as $role)
                               
                                <option value='{{$role->id}}' @if($user->role_id == $role->id) selected @endif>{{$role->role}}</option>
                            
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-12'>
                        Locations : 
                            <select name='locations[]' class='form-control-sm form-control cat' multiple >
                            <option value=""></option>
                            @foreach($locations as $location)
                                <option value='{{$location->id}}'  @if(in_array($location->id,(($user->userlocations)->pluck('location_id'))->toArray())) selected @endif >{{$location->location}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($user->approver_id != "")
                    <div class='col-md-12' id='edit_approver_id{{$user->id}}'>
                        Approver :
                        <select name='approver' id='approver{{$user->id}}' class='form-control-sm form-control cat' >
                            <option value=""></option>
                            @foreach($users as $us)
                                @if($us->status != 1)
                                    @if($us->id != Auth::user()->id)
                                        @if(($us->role_id == 4) || ($us->role_id == 5))
                                            <option value='{{$us->id}}' @if($us->id == $user->approver_id) selected @endif>{{$us->name}}</option>
                                        @endif
                                    @endif                                            
                                @endif
                            @endforeach
                        </select>
                     </div>
                     @else
                     <div class='col-md-12' id='edit_approver_id{{$user->id}}' style='display:none'>
                        Approver :
                        <select name='approver' id='approver{{$user->id}}' class='form-control-sm form-control cat' >
                            <option value=""></option>
                            @foreach($users as $user)
                                @if($user->status != 1)
                                    @if($user->id != Auth::user()->id)
                                        @if(($user->role_id == 5) || ($user->role_id == 4))
                                            <option value='{{$user->id}}'>{{$user->name}}</option>
                                        @endif
                                    @endif                                            
                                @endif
                            @endforeach
                        </select>
                     </div>
                     @endif
                
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
    function changeapproverEdit(value,id)
    {
        $('#approver'+id).val(null); 
        $("#approver"+id+"_chosen a span").html("Select an Option");
        if((value == 2) || (value == 3))
        {
            document.getElementById("edit_approver_id"+id).style.display="block";
            
        }
        else
        {
            document.getElementById("edit_approver_id"+id).style.display="none";
        }
    }    

   
</script>
