
<div class="modal" id="new_equipment" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Equipment</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-equipment' onsubmit='show();'  enctype="multipart/form-data" id='new_equipment' >
                <div class="modal-body">
                    {{ csrf_field() }}
                   {{-- <div class='row'> --}}
                    <div class='col-md-12'>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <img id='avatar' src="{{URL::asset('/images/no_image.png')}}" class="m-b-md border" alt="profile" height='75px;' width='75px;'>
                            </div>
                            <div class="col-lg-8">
                                <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                    <input type="file" accept="image/*" name="file" id="inputImage" style="display:none" onchange='uploadimage(this)' required>
                                    Upload image
                                </label>
                            </div>
                        </div>
                    </div>
                   {{-- </div> --}}
                   <div class='row'>
                    <div class='col-md-6'>
                        Equipment Class :
                        <select name='equipment_category' class='form-control-sm form-control category' onchange="class_select(this.value)" required>
                            <option value=""></option>
                            @foreach($classes as $key => $class )
                                @if($class->status)
                                @else
                                <option value='{{$class->id}}-{{$class->category_id}}-{{$key}}'>{{$class->class_code}} - {{$class->class_description}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-6'>
                        Equipment Category : 
                        <input class='form-control-sm form-control' id='category' name='category' value='No class selected' readonly>
                        <input class='form-control-sm form-control' id='category_id' name='category_id' type='hidden' readonly>
                    </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-6'>
                        Brand :
                        <select name='brand' class='form-control-sm form-control category' required>
                            <option value=""></option>
                            @foreach($brands as $key => $brand )
                                @if($brand->status)
                                @else
                                <option value='{{$brand->id}}'>{{$brand->brand_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-6'>
                        Company :
                        <select name='company' class='form-control-sm form-control category' required>
                            <option value=""></option>
                            @foreach($companies as $key => $company )
                                @if($company->status)
                                @else
                                <option value='{{$company->id}}'>{{$company->company_code}} - {{$company->company_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-6'>
                        Model :
                        <input class='form-control-sm form-control' id='model' name='model'  required>
                    </div>
                    <div class='col-md-6'>
                        Chasis Number :
                        <input class='form-control-sm form-control' id='chasis_number' name='chasis_number'  required>
                    </div>
                    <div class='col-md-6'>
                        Date Acquired:
                        <input class='form-control-sm form-control' type='date' name='date_acquired'  required>
                    </div>
                    <div class='col-md-6'>
                        Acquisition Cost:
                        <input class='form-control-sm form-control' type='number'  name='acquisition_cost'  required>
                    </div>
                    <div class='col-md-6'>
                        Remarks :
                        <textarea class='form-control' name='remarks' required></textarea>
                    </div>
                   </div>
                   <hr>
                   <h2>Registration</h2>
                   <div class='row'>
                        <div class='col-md-4'>
                            Plate Number :
                            <input name='plate_number' class='form-control-sm form-control' type='text' >
                        </div>
                        <div class='col-md-4'>
                            Conduction Sticker :
                            <input name='conduction_sticker' class='form-control-sm form-control' type='text' required>
                        </div>
                        <div class='col-md-4'>
                            Engine Number :
                            <input name='engine_number' class='form-control-sm form-control' type='text' required>
                        </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-4'>
                        Registration Number :
                        <input name='registration_number' class='form-control-sm form-control' type='text' required>
                    </div>
                    <div class='col-md-4'>
                        Date of Registration :
                        <input name='registration_date' class='form-control-sm form-control' max='{{date('Y-m-d')}}' onchange='date_of_registration(this.value);' type='date'  required>
                    </div>
                    <div class='col-md-4'>
                        Date of Expiration :
                        <input name='registration_expiration' class='form-control-sm form-control' id='date_expired' type='date'  required>
                    </div>
                    
                   </div>
                   <hr>
                   <h2>Insurance <input type="checkbox" id='insurance_yes' name="insurance_yes" onchange="insurance_change();"  value="1"> </h2>
                   <div class='row'>
                        <div class='col-md-4'>
                            Policy Number :
                            <input name='policy_number' id='policy_number' class='form-control-sm form-control' type='text' readonly>
                        </div>
                    </div>
                   <div class='row'>
                    <div class='col-md-4'>
                        Insurance Company :
                        <select name='insurance' id='insurance' class='form-control-sm form-control' readonly>
                            <option value=""></option>
                            @foreach($insurances as $key => $insurance )
                                @if($insurance->status)
                                @else
                                <option value='{{$insurance->id}}'>{{$insurance->company}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-4'>
                        Insured From :
                        <input name='insured_from' id='insured_from' class='form-control-sm form-control' max='{{date('Y-m-d')}}' onchange='insurance_from(this.value);' type='date'  readonly>
                    </div>
                    <div class='col-md-4'>
                        Insured To :
                        <input name='insured_to' id='insured_to'  class='form-control-sm form-control' id='insured_expiration' type='date'  readonly>
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
    var classess = {!! json_encode($classes->toArray()) !!};
   

    // console.log(classess);
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

    function class_select(data)
    {
       
        var dataArray = data.split("-");
        var key = dataArray[2];
        document.getElementById('category').value= classess[key].category.category_code + " - " +classess[key].category.equipment; 
        document.getElementById('category_id').value= classess[key].category_id; 
    }

    function date_of_registration(value)
    {
        // alert(value);
        document.getElementById("date_expired").min = value;
    }
    function insurance_from(value)
    {
        // alert(value);
        document.getElementById("insured_expiration").min = value;
    }
    
    function insurance_change()
    {
        var check = $('#insurance_yes').is(':checked'); 
        if(check == true)
        {
            $("#policy_number").attr("readonly", false); 
            $("#policy_number").prop('required',true);
            $("#insured_from").attr("readonly", false); 
            $("#insured_from").prop('required',true);
            $("#insured_to").attr("readonly", false); 
            $("#insured_to").prop('required',true);
            $("#insurance").prop('required',true);
            $('#insurance').prop("disabled", false);
            $("#insurance").attr("readonly", false);
        }
        else
        {
            $("#policy_number").attr("readonly", true); 
            $("#policy_number").prop('required',false);
            $("#insured_from").attr("readonly", true); 
            $("#insured_from").prop('required',false);
            $("#insured_to").attr("readonly", true); 
            $("#insured_to").prop('required',false);
            $("#insurance").prop('required',false);
            $('#insurance').prop("disabled", true);
            $("#insurance").attr("readonly", true);
        }
    }
  
</script>