
<div class="modal" id="editClass{{$class->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" >Edit Class</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-class/{{$class->id}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                   
                    <div class='col-md-12'>
                        Equipment Class Code :
                        <input type="text" class="form-control-sm form-control "  value="{{$class->class_code}}"  name="class_code" required/>
                    </div>
                    <div class='col-md-12'>
                        Equipment Class Description :
                        <input type="text" class="form-control-sm form-control "  value="{{$class->class_description}}"  name="class_description" required/>
                    </div>
                    <div class='col-md-12'>
                        Equipment Category : 
                        <select name='equipment_category' class='form-control-sm form-control category' required>
                            <option value=""></option>
                            @foreach($categories as $category)
                                @if($category->status)
                                @else
                                <option value='{{$category->id}}' @if($category->id == $class->category_id) selected @endif >{{$category->category_code}} - {{$category->equipment}}</option>
                                @endif
                            @endforeach
                        </select>
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