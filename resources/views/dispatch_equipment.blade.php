
<div class="modal" id="dispatch_equipment" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">Dispatch Equipment</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form onsubmit='dispatch_equipment();return false;'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{-- {{ csrf_field() }} --}}
                    <input type='hidden' value='' id='id_row_upload' required>
                    <div class='col-md-12' id='equipment_datas'>
                        Available Equipment :
                        <select name='equipment' id='equipment_data' class='form-control-sm form-control category' required>
                            <option value=""></option>
                         
                        </select>
                     </div>
                     <hr>
                    <div class='col-md-12'>
                        Brand : <span id='brand'></span>
                     </div>
                    <div class='col-md-12'>
                        Plate Number : <span id='plate_number'></span>
                     </div>
                    <div class='col-md-12'>
                        Engine Number : <span id='engine_number'></span>
                     </div>
                    <div class='col-md-12'>
                        Model  : <span id='model'></span>
                     </div>
                    <div class='col-md-12'>
                        Chasis Number  : <span id='chasis_number'></span>
                     </div>
                     <hr>

                    <div class='col-md-12'>
                        Remarks :
                        <textarea class='form-control' name='remarks_dispatch' id='remarks_dispatch' required></textarea>
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
  var equipments = {!! json_encode($equipments->toArray()) !!};
  var requests = {!! json_encode($requests->toArray()) !!};
  function data_change(data)
  {
        var d = data.split("-");
        var brand = equipments[d[1]].brand.brand_name;
        var plate_number = equipments[d[1]].plate_number;
        var engine_number = equipments[d[1]].engine_number;
        var model = equipments[d[1]].model;
        var chasis_number = equipments[d[1]].chasis_number;

        document.getElementById("brand").innerHTML=brand;
        document.getElementById("plate_number").innerHTML=plate_number;
        document.getElementById("engine_number").innerHTML=engine_number;
        document.getElementById("model").innerHTML=model;
        document.getElementById("chasis_number").innerHTML=chasis_number;

        
  }
  function dispatch_equipment()
  {
        var id_row_upload = document.getElementById('id_row_upload').value;
        var id = document.getElementById('equipment_data').value;
        var remarks = document.getElementById('remarks_dispatch').value;
        var requests = document.getElementById('requests').innerHTML;
        var dispatch_approval = document.getElementById('dispatch_approval').innerHTML;
 
        // alert(id);
        $.ajax({
            dataType: 'json',
            type:'POST',
            url:  'distpach-equipment',
            data:{id:id,remarks:remarks,id_row_upload:id_row_upload},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).done(function(data){
            $("#row"+id).remove();
            document.getElementById('requests').innerHTML = requests-1;
            document.getElementById('dispatch_approval').innerHTML = parseInt(dispatch_approval)+1;
            swal("Successfully!", "Successfully Dispatch", "success");
        });
        $("#row"+id_row_upload).remove();
        $('#dispatch_equipment').modal('toggle'); 
        swal("Successfully!", "Successfully Dispatch.", "success");
  }
</script>
