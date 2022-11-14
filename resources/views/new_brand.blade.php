
<div class="modal" id="new_brand" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Brand</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-brand' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
{{--                    
                    <div class='col-md-12'>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <img id='avatar' src="{{URL::asset('/images/no_image.png')}}" class="m-b-md border" alt="profile" height='75px;' width='75px;'>
                            </div>
                            <div class="col-lg-8">
                                <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                    <input type="file" accept="image/*" name="file" id="inputImage" style="display:none" onchange='uploadimage(this)'>
                                    Upload image
                                </label>
                            </div>
                        </div>
                    </div> --}}
                    <div class='col-md-12'>
                        Brand Name :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('brand_name') }}"  name="brand_name" required/>
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
    function uploadimage(input)
    {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
    $('#avatar').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
    }
    }

    function uploadimageEdit(input,id)
    {
        // var iddata = input.data('id');
        // alert(id);
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
    $('#avatar'+id).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
    }
    }
</script>