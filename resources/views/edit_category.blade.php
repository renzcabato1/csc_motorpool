
<div class="modal" id="editCategory{{$category->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" >Edit Category</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-category/{{$category->id}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                
                    <div class='col-md-12'>
                        Category Code :
                        <input type="text" class="form-control-sm form-control "  value="{{$category->category_code}}"  name="category_code" required/>
                    </div>
                    <div class='col-md-12'>
                        Equipment Category :
                        <input type="text" class="form-control-sm form-control "  value="{{$category->equipment}}"  name="equipment_class_description" required/>
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