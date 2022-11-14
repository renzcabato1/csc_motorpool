
<div class="modal" id="view_request{{$request->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">Request</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}
                <div class='row'>
                    <div class='col-md-12'>
                        Request Number : RN-{{str_pad($request->id, 4, '0', STR_PAD_LEFT)}}
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        Name : {{$request->user->name}}
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        Company : {{$request->company->company_name}}
                    </div>
                    <div class='col-md-6'>
                        Department : {{$request->department->department_name}}
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        Approver : {{$request->approver->name}}
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class='col-md-6'>
                        Equipment Class : 
                        <input value='{{$request->class->class_description}}' class='form-control' readonly>
                        
                       
                    </div>
                    <div class='col-md-3'>
                        Project ID : 
                        <input value='{{$request->project_id}}' class='form-control' readonly>
                    </div>
                </div>
                <Br>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class="form-group" id="data_5">
                            <label class="font-normal">Date Needed</label> <br>
                            {{date('F m, Y',strtotime($request->date_from_needed))}} to {{date('F m, Y',strtotime($request->date_to_needed))}}
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group" >
                            <label class="font-normal"> Time Needed</label>
                            <div class="row">
                                <div class='col-md-5'>
                                    <input type="time"   class="input-sm form-control" value='{{$request->time_from_needed}}' name="time_from" readonly >
                                </div>
                                to
                                <div class='col-md-5'>
                                    <input type="time"  class="input-sm form-control" value='{{$request->time_from_needed}}' name="time_to" readonly >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        Location : 
                         <input type="text" class="form-control-sm form-control "  value="{{$request->location}}"  name="location" readonly/>
                    </div>
                    <div class='col-md-6'>
                        Area : 
                        <input value='{{$request->area}}' class='form-control' readonly> 
                    </div>
                </div>
                <Br>
                <div class='row'>
                    <div class='col-md-12'>
                        Remarks : 
                        <textarea class='form-control' name='remarks' readonly>{{$request->remarks}}</textarea>
                    </div>
                </div>

                <hr/>
                <strong>Logs</strong>
                <div id="vertical-timeline" class="vertical-container dark-timeline">
                    @foreach($request->histories as $history)
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon gray-bg">
                            <i class="fa fa-plus-square-o"></i>
                        </div>
                        <div class="vertical-timeline-content">
                            <p>{{$history->action}} by {{$history->user->name}} <br>
                                Remarks : {{$history->remarks}}
                            </p>
                            <span class="vertical-date small text-muted"> {{date('M d, Y h:i a',strtotime($history->created_at))}} </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>