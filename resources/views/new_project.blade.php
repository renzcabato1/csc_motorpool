
<div class="modal" id="new_project" tabindex="-1" role="dialog"  >
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
            <form method='post' action='new-project' onsubmit='show();' autocomplete="off"  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='col-md-12'>
                        Company :
                        <select name='company' class='form-control-sm form-control category' required>
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
                        Project ID :
                        <input type="text" class="form-control-sm form-control "   value="{{ old('project_id') }}"  name="project_id" required/>
                     </div>
                    <div class='col-md-12'>
                        Project Description :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('project_description') }}"  name="project_description" required/>
                     </div>
                    <div class='col-md-12'>
                        Location :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('location') }}"  name="location" required/>
                     </div>
                    <div class='col-md-12'>
                        Area :
                        <select name='area' class='form-control-sm form-control category' required>
                            <option value=""></option>
                            <option value="Luzon">Luzon</option>
                            <option value="Visayas">Visayas</option>
                            <option value="Mindanao">Mindanao</option>
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