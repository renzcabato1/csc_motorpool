
<div class="modal" id="editBrand{{$brand->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" >Edit Brand</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-brand/{{$brand->id}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                   
                    <div class='col-md-12'>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <img id='avatar{{$brand->id}}' src="{{ asset($brand->logo) }}" class="m-b-md border" alt="profile" height='75px;' width='75px;'>
                            </div>
                            <div class="col-lg-8">
                                <label title="Upload image file" for="EditImage{{$brand->id}}" class="btn btn-primary">
                                    <input type="file" accept="image/*" name="file" id="EditImage{{$brand->id}}" style="display:none" onchange='uploadimageEdit(this,{{$brand->id}})'>
                                    Edit image
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-12'>
                        Brand Name :
                        <input type="text" class="form-control-sm form-control "  value="{{$brand->brand_name}}"  name="brand_name" required/>
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