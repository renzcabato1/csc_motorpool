
<div class="modal" id="new_account" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-account' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                   
                    <div class='col-md-12'>
                        Name :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('name') }}"  name="name" required/>
                     </div>
                    <div class='col-md-12'>
                        Email :
                        <input type="email" class="form-control-sm form-control "  value="{{ old('email') }}"  name="email" required/>
                     </div>
                    <div class='col-md-12'>
                        Company :
                        <select name='company' class='form-control-sm form-control cat' required>
                            <option value=""></option>
                            @foreach($companies as $company)
                                @if($company->status)
                                @else
                                <option value='{{$company->id}}' @if(old('company') == $company->id) selected @endif>{{$company->company_code}} - {{$company->company_name}}</option>
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
                                <option value='{{$dep->id}}' @if(old('department') == $dep->id) selected @endif>{{$dep->department_code}} - {{$dep->department_name}}</option>
                                @endif
                            @endforeach
                        </select>
                     </div>
                    <div class='col-md-12'>
                        Role :
                        <select name='role' class='form-control-sm form-control cat' onchange='changeapprover(this.value)' required>
                            <option value=""></option>
                            @foreach($roles as $role)
                               
                                <option value='{{$role->id}}' >{{$role->role}}</option>
                            
                            @endforeach
                        </select>
                     </div>
                    <div class='col-md-12' id='approver_id_data' style='display:none;'>
                        Approver :
                        <select name='approver' id='approver' class='form-control-sm form-control cat' >
                            <option value=""></option>
                            @foreach($users as $u)
                                @if($u->status != 1)
                                    @if($u->id != Auth::user()->id)
                                        @if(($u->role_id == 4) ||($u->role_id == 5))
                                            <option value='{{$u->id}}'>{{$u->name}}</option>
                                        @endif
                                    @endif                                            
                                @endif
                            @endforeach
                        </select>
                     </div>
                    <div class='col-md-12'>
                       Password:
                        <input type="password" class="form-control-sm form-control "   name="password" required/>
                     </div>
                    <div class='col-md-12'>
                        Password Confirmation:
                        <input type="password" class="form-control-sm form-control "   name="password_confirmation" required/>
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
    var users = {!! json_encode($users->toArray()) !!};
    function changeapprover(value)
    {
        $('#approver').val(null); 
        $("#approver_chosen a span").html("Select an Option");
        if((value == 2) || (value == 3))
        {
            document.getElementById("approver_id_data").style.display="block";
            
        }
        else
        {
            document.getElementById("approver_id_data").style.display="none";
        }
    }    
</script>
