
<div class="modal" id="new_vessel" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Vessel</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-vessel' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='col-md-12'>
                        Vessel Code :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('vessel_code') }}"  name="vessel_code" required/>
                     </div>
                    <div class='col-md-12'>
                        Vessel Description :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('vessel_description') }}"  name="vessel_description" required/>
                    </div>
                    <div class='col-md-12'>
                        Vessel Type :
                        <select name='vessel_type' class='form-control-sm form-control cat' required>
                            <option value=""></option>
                            @foreach($vessel_types as $type )
                                <option value='{{$type->id}}'>{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-12'>
                        Fuel Capacity :
                        <input type="number" class="form-control-sm form-control " name='capacity' value="{{ old('capacity') }}" />
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
