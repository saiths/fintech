@include('admin.common.main2')
<?php 
    if(!empty(Session::get('sessionUserData'))) {
        foreach (Session::get('sessionUserData') as $sessionUserData) {
            $roleId = !empty($sessionUserData[0]->role_id) ? $sessionUserData[0]->role_id : '';
        }
    }
?>

<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(!empty($getLeavesDataByID))
                            @foreach ($getLeavesDataByID as $getEditLeaves)
                            @endforeach
                        @endif
                        
                        @if ($roleId == 1) 
                            <h4 class="card-title">Manage Leave Request</h4>
                        @endif
                        @if ($roleId == 3) 
                            <h4 class="card-title">Leave History</h4>
                        @endif
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        <style type="text/css">
                            .radio-wrapper {
                                width: 103px;
                                height: 23px;
                                display: inline-block;
                                vertical-align: middle;
                                background: #e5ebec;
                                border-radius: 30px;
                                position: relative;
                                margin-left: 1%;

                                p {
                                    position: absolute;
                                    z-index: 10;
                                    color: white;
                                    font-size: 1.7em;
                                    margin: 0;
                                    margin-top: 13px;
                                }
                                .correct {
                                    left: 17px;
                                    top: -5px;
                                }
                                .wrong {
                                    right: 17px;
                                    top: -5px;
                                }
                                .neutral-icon {
                                    left: 69px;
                                    top: -8px;
                                    opacity: .5;
                                }
                                label {
                                    z-index: 9;
                                }
                            }

                            input[type="radio"] {
                                display: none;
                            }

                            i { 
                              z-index: 99;
                              font-size: 18px;
                            }

                            .neutral + label {
                                display: inline-block;
                                width: 40px;
                                border-radius: 46%;
                                position: absolute;
                                left: 33%;
                                transition: transform 1s;
                            }

                            .neutral:checked + label {
                                display: inline-block;
                                width: 36px;
                                border-radius: 39%;
                                color: white;
                                padding: 4px;
                            }
                            .yes + label {
                                display: inline-block;
                                width: 40px;
                                height: 22px;
                                border-radius: 46%;
                                position: absolute;
                                left: 0;
                                text-align: center;
                            }

                            .yes:checked + label {
                                display: inline-block;
                                width: 36px;
                                border-radius: 39%;
                                color: white;
                                padding: 4px;
                                background: rgb(32, 213, 50);
                                background: -moz-linear-gradient(top, rgba(32, 213, 50, 1) 0%, rgba(28, 195, 1, 1) 100%);
                            }
                            .no + label {
                                display: inline-block;
                                 width: 40px;
                                height: 22px;
                                border-radius: 46%;
                                position: absolute;
                                right: 0;
                                text-align: center;
                            }

                            .no:checked + label {
                                display: inline-block;
                                width: 36px;
                                border-radius: 39%;
                                color: white;
                                padding: 4px;
                                background: #e74a25;

                            }
                        </style>
                        
                        <form class="form-horizontal" id="register-form"  autocomplete="off">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            @if(!empty($getEditLeaves->id))
                                <input type="hidden" name="leaveId" id="leaveId"  value="{{$getEditLeaves->id}}">
                                <input type="hidden" name="userId" id="userId"  value="{{$getEditLeaves->user_id}}">
                                
                            @endif   
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-6 col-form-label">
                                         Leave Type : </label>
                                        <div class="col-md-6">
                                            <select class="select2 m-b-10 select2" id="leave_type_form" 
                                                name="leave_type_form" style="width: 125%;height:50px;border:1px solid #e74a25!important">
                                                    <option value="1"  @if (!empty($getEditLeaves->leave_type))
                                                        {{ ($getEditLeaves->leave_type == 1) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif>Full Day</option>
                                                    <option value="2"  @if (!empty($getEditLeaves->leave_type))
                                                        {{ ($getEditLeaves->leave_type == 2) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif>Half Day</option>
                                            </select>
                                            <span class="text-danger" id="leaveTypeMsg"></span>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label for="inputEmail3"  class="control-label text-right col-md-4 col-form-label">
                                        Form : </label>

                                        <div class="col-md-8">
                                            <input type="text"  id="form_leave_date" name="form_leave_date" 
                                            class="form-control borderred" data-date-format="dd-mm-yyyy" placeholder="Form Date" ng-value="currentDate"  ng-model="leaveFormData.form_leave_date" 
                                            value="@if(!empty($getEditLeaves->form_date)){{date('d-m-Y', strtotime($getEditLeaves->form_date))}}@endif"> 
                                            <span class="text-danger" id="errorFormMsg" ></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2" style="margin-left:-24px;"> 
                                     <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                            To : 
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" id="to_leave_date" name="to_leave_date" 
                                            class="form-control borderred" data-date-format="dd-mm-yyyy" 
                                            placeholder="To Date" ng-value="currentDate" ng-model="leaveFormData.to_leave_date" 
                                            value="@if(!empty($getEditLeaves->to_date)){{date('d-m-Y', strtotime($getEditLeaves->to_date))}}@endif"> 
                                            <span class="text-danger" id="errorToMsg"></span>
                                        </div>
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-left:-35px;">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                            Reason : 
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" id="reason" name="reason" class="form-control borderred" data-date-format="dd-mm-yyyy" style="width: 150%"  placeholder="Leave Reason" ng-value="currentDate" ng-model="leaveFormData.reason" value="@if(!empty($getEditLeaves->reason)){{$getEditLeaves->reason}}
                                            @endif"><span class="text-danger" id="errorResonMsg"></span>
                                        </div>
                                    </div>   
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label"></label>
                                        <div class="col-md-8">
                                            <button type="button" id="lorderId" onclick="addLeaveData()" class="btn btn-success">Submit</button>
                                            <button type="button" id="cancelId" onclick="resetLeaveForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                 
                             </div> 
                        </form>
                        
                        <?php /*
                        <!--<div class="table-responsive" ng-init="fetchLeaveRequestData()">-->    
                        
                        <div class="table-responsive">
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th style="display:none">Sr.No.</th>
                                        <th style="display:none">Sr.No.</th>
                                        @if ($roleId == 1) 
                                            <th>UserName</th>
                                        @endif
                                        <th>LeaveType</th>
                                        <th>RequestDate</th>
                                        <th>LeaveDate</th>
                                        <th>Reason</th>
                                        <th>LeaveStatus</th>
                                        @if ($roleId == 1)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php /*
                                    <tr ng-repeat="leaveRequest in leaveRequestData">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ leaveRequest.name  }}</td>
                                        <td ng-if="leaveRequest.leave_type==1">Full Day</td>
                                        <td ng-if="leaveRequest.leave_type==2">Half Day</td>
                                        <td>@{{ leaveRequest.datetime }}</td>
                                        <td>@{{ leaveRequest.date }}</td>
                                        <td>
                                            <style type="text/css">
                                                .ticket_header {
                                                    display: flex;
                                                    align-items: flex-start;
                                                    justify-content: space-between;
                                                    padding: 1rem;
                                                    border-bottom: 1px solid rgba(0,0,0,.1);
                                                    border-top-left-radius: 2px;
                                                    border-top-right-radius: 2px;
                                                }
                                                .ticket_body {
                                                    position: relative;
                                                    flex: 1 1 auto;
                                                    padding: 1rem;
                                                    padding: 15px 15px;
                                                }
                                            </style>
                                            <div id="myModal_@{{leaveRequest.id}}" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="max-width: 350px;">
                                                    <div class="modal-content">
                                                        <div class="ticket_header">
                                                            <h4 class="modal-title" id="myModalLabel">@{{leaveRequest.date}} - Reson</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 25px">×</button>
                                                        </div>
                                                        <div class="ticket_body">
                                                            <div class="container-fluid">
                                                                @{{leaveRequest.reason}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="btn waves-effect waves-light btn-rounded btn-primary" href="#" role="button" alt="default" data-toggle="modal" data-target="#myModal_@{{leaveRequest.id}}" style="padding: 0px 7px;font-size: 13px">Reson</a>
                                        </td> 
                                        <td>
                                            <style type="text/css">
                                                .levaseress {
                                                    padding: 4px 10px;
                                                    color: white;
                                                    font-size: 10px;
                                                }
                                            </style>
                                            <span class="label-rounded label-success levaseress" ng-if="leaveRequest.leave_status==3">Apporved</span>
                                            <span class="label-rounded label-danger levaseress"  ng-if="leaveRequest.leave_status==2">Rejected</span>
                                            <span class="label-rounded label-warning levaseress" ng-if="leaveRequest.leave_status==1">Pending</span>
                                        </td>
                                        @if ($roleId == 1)
                                        <td>
                                            <div class="radio-wrapper">  
                                                <input type="radio" name="event" class="yes" id="radio-yes_@{{leaveRequest.id}}"/>
                                                <div class="tooltip7" style="border:none;">
                                                    <label for="radio-yes_@{{leaveRequest.id}}"  data-toggle="tooltip" data-placement="top" title=""  data-original-title="Apporve"  ng-style="apporved">
                                                        <a style="color: white" href="#"><b>A</b></a>
                                                    </label>
                                                    <span class="tooltiptext">Apporve</span>
                                                </div>
                                                <input type="radio" name="event" class="no" id="radio-no_@{{leaveRequest.id}}" />
                                                <div class="tooltip7" style="border:none;">
                                                    <label for="radio-no_@{{leaveRequest.id}}"   data-toggle="tooltip" data-placement="top" title="" data-original-title="Reject"  ng-style="rejected">
                                                        <a style="color: white" href="#"><b style="color: white">R</b></a>
                                                    </label>
                                                    <span class="tooltiptext">Reject</span>
                                                </div>
                                                <input type="radio" name="event" class="neutral" checked id="radio-neutral_@{{leaveRequest.id}}" />
                                                <div class="tooltip7" style="border:none;">
                                                    <label for="radio-neutral_@{{leaveRequest.id}}" data-toggle="tooltip" data-placement="top"  title="" data-original-title="Pending" ng-style="pending" >
                                                        <a style="color: white" href="#"><b style="color: white">P</b></a>
                                                    </label>
                                                    <span class="tooltiptext">Pending</span>
                                                </div>
                                            </div> 
                                        </td>
                                        @endif
                                    </tr>*/
                                    ?>
                                    <?php /*
                                    @if (!empty($getLeaveRequest))
                                        @foreach ($getLeaveRequest as $key => $leaveRequest)
                                            <tr  
                                                @if($leaveRequest->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                >
                                                <td style="display:none">{{$key+1}}</td>
                                                <td style="display:none">{{$key+1}}</td> 
                                                <td>{{$key+1}}</td> 
                                                @if ($roleId == 1)
                                                    <td>{{$leaveRequest->username}}</td>
                                                @endif
                                                <td>
                                                    @if($leaveRequest->leave_type == 1) 
                                                        Full Day      
                                                    @endif
                                                    @if($leaveRequest->leave_type == 2) 
                                                        Half Day      
                                                    @endif
                                                </td>
                                                <td>
                                                    {{date('d-m-Y h:i:s A', strtotime($leaveRequest->datetime))}}
                                                </td>
                                                <td>{{date('d-m-Y', strtotime($leaveRequest->date))}}</td>

                                                <td>
                                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-rounded btn-secondary" data-container="body"  
                                                    data-toggle="popover"  
                                                    style="padding: 1px 10px;"data-trigger="click_{{$leaveRequest->id}}" data-placement="left" title="Leave Reason   
                                                    {{date('d-M-Y', strtotime($leaveRequest->date))}}" data-content="<?php echo wordwrap($leaveRequest->reason,33, "\n", TRUE); ?>"
                                                    > Reson
                                                    </button>
                                                    
                                                </td>
                                                <style type="text/css">
                                                    .levaseress {
                                                        padding: 4px 10px;
                                                        color: white;
                                                        font-size: 10px;
                                                    }
                                                </style>
                                                <td>
                                                    <?php
                                                        if ($leaveRequest->leave_status ==  3) { 
                                                            echo '<span class="label-rounded label-success levaseress">
                                                                    Apporved
                                                                </span>';
                                                        } else if ($leaveRequest->leave_status ==  2) {
                                                            echo '<span class="label-rounded label-danger levaseress">Rejected</span>';
                                                        } else {
                                                            echo '<span class="label-rounded label-warning levaseress">
                                                            Pending</span>';
                                                        }
                                                    ?>
                                                </td>
                                                @if ($roleId == 1)
                                                    <td>
                                                        <div class="radio-wrapper">  
                                                            <input type="radio" name="event" class="yes"   id="radio-yes_{{$leaveRequest->id}}"   />
                                                            <label for="radio-yes_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" 
                                                                title=""  data-original-title="Apporve"   style=" 
                                                                <?php if ($leaveRequest->leave_status ==  3) {  
                                                                    echo 'display: inline-block;
                                                                        width: 36px;
                                                                        border-radius: 39%;
                                                                        color: white;
                                                                        padding: 1px;
                                                                        background-color: #2ecc71;';
                                                                    } 
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeaveapporves',['apporveId' =>  base64_encode($leaveRequest->id)]) }}"  ><b style="margin-left: 8px;">A</b> 
                                                                </a>&nbsp;
                                                            </label>
                                                            <input type="radio" name="event" class="no" id="radio-no_{{$leaveRequest->id}}" />
                                                            <label for="radio-no_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" title=""  data-original-title="Reject"  style="<?php 
                                                                if ($leaveRequest->leave_status ==  2) {  
                                                                        echo  'display: inline-block;
                                                                            width: 36px;
                                                                            border-radius: 39%;
                                                                            color: white;
                                                                            padding: 1px;
                                                                            background-color: #e74a25;';
                                                                            
                                                                    } else {
                                                                        echo 'pointer-events: auto;';
                                                                    }
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeaverejected',['rejecteId' => base64_encode($leaveRequest->id)]) }}" 
                                                                ><b style="color: white">R</b></a>
                                                            </label>
                                                            <input type="radio" name="event" class="neutral" checked id="radio-neutral_{{$leaveRequest->id}}" />
                                                            <label for="radio-neutral_{{$leaveRequest->id}}" data-toggle="tooltip" 
                                                                data-placement="top"  title=""  data-original-title="Pending"  style="
                                                                <?php 
                                                                    if ($leaveRequest->leave_status ==  1) {  
                                                                        echo  '
                                                                            display: inline-block;
                                                                            width: 36px;
                                                                            border-radius: 39%;
                                                                            color: white;
                                                                            padding: 1px;
                                                                            background-color: #ffb136;
                                                                            padding-left: 13px;
                                                                            ';
                                                                   } else {
                                                                    
                                                                    echo '
                                                                        left: 43%;
                                                                        pointer-events: auto;';
                                                                   }
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeavependding',['pendingId' => base64_encode($leaveRequest->id)]) }}" 
                                                                        ><b style="color: white">P</b>
                                                                </a>
                                                            </label>
                                                        </div> 
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        */?>
                        <div class="table-responsive">
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th style="display:none">Sr.No.</th>
                                        <th style="display:none">Sr.No.</th>
                                        @if ($roleId == 1) 
                                            <th>UserName</th>
                                        @endif
                                        <th>LeaveType</th>
                                        <th>formDate</th>
                                        <th>toDate</th>
                                        <th>RequestDate</th>
                                        <th>Reason</th>
                                        <th>LeaveStatus</th>
                                        @if ($roleId == 1)
                                            <th>Status</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getLeaveRequest))
                                        @foreach ($getLeaveRequest as $key => $leaveRequest)
                                            <tr  
                                                @if($leaveRequest->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                >

                                                <td style="display:none">{{$key+1}}</td>
                                                <td style="display:none">{{$key+1}}</td> 
                                                <td>{{$key+1}}</td> 
                                                
                                                @if ($roleId == 1)
                                                    <td>{{$leaveRequest->username}}</td>
                                                @endif
                                                
                                                <td>
                                                    @if($leaveRequest->leave_type == 1) 
                                                        Full Day      
                                                    @endif
                                                    @if($leaveRequest->leave_type == 2) 
                                                        Half Day      
                                                    @endif
                                                </td>
                                                
                                                <td>{{date('d-m-Y', strtotime($leaveRequest->form_date))}}</td>
                                                
                                                <td>{{date('d-m-Y', strtotime($leaveRequest->to_date))}}</td>
                                                
                                                <td>{{date('d-m-Y h:i:s A', strtotime($leaveRequest->datetime))}}</td>

                                                <td>
                                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-rounded btn-secondary" data-container="body"  data-toggle="popover"  
                                                    style="padding: 1px 10px;"data-trigger="click_{{$leaveRequest->id}}" data-placement="left" title="{{date('d-M-Y', strtotime($leaveRequest->form_date))}} to {{date('d-M-Y', strtotime($leaveRequest->to_date))}}" data-content="<?php echo wordwrap($leaveRequest->reason,33, "\n", TRUE); ?>"
                                                    > Reson
                                                    </button>
                                                    
                                                </td>
                                                
                                                <style type="text/css">
                                                    .levaseress {
                                                        padding: 4px 10px;
                                                        color: white;
                                                        font-size: 10px;
                                                    }
                                                </style>
                                                
                                                <td>
                                                    <?php
                                                        if ($leaveRequest->leave_status ==  3) { 
                                                            echo '<span class="label-rounded label-success levaseress">
                                                                    Apporved
                                                                </span>';
                                                        } else if ($leaveRequest->leave_status ==  2) {
                                                            echo '<span class="label-rounded label-danger levaseress">Rejected</span>';
                                                        } else {
                                                            echo '<span class="label-rounded label-warning levaseress">
                                                            Pending</span>';
                                                        }
                                                    ?>
                                                </td>
                                                
                                                @if ($roleId == 1)
                                                    <td>
                                                        <div class="radio-wrapper">  
                                                            <input type="radio" name="event" class="yes"   id="radio-yes_{{$leaveRequest->id}}"   />
                                                            <label for="radio-yes_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" 
                                                                title=""  data-original-title="Apporve"   style=" 
                                                                <?php if ($leaveRequest->leave_status ==  3) {  
                                                                    echo 'display: inline-block;
                                                                        width: 36px;
                                                                        border-radius: 39%;
                                                                        color: white;
                                                                        padding: 1px;
                                                                        background-color: #2ecc71;';
                                                                    } 
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeaveapporves',['apporveId' =>  base64_encode($leaveRequest->id)]) }}"  ><b style="margin-left: 8px;">A</b> 
                                                                </a>&nbsp;
                                                            </label>
                                                            <input type="radio" name="event" class="no" id="radio-no_{{$leaveRequest->id}}" />
                                                            <label for="radio-no_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" title=""  data-original-title="Reject"  style="<?php 
                                                                if ($leaveRequest->leave_status ==  2) {  
                                                                        echo  'display: inline-block;
                                                                            width: 36px;
                                                                            border-radius: 39%;
                                                                            color: white;
                                                                            padding: 1px;
                                                                            background-color: #e74a25;';
                                                                            
                                                                    } else {
                                                                        echo 'pointer-events: auto;';
                                                                    }
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeaverejected',['rejecteId' => base64_encode($leaveRequest->id)]) }}" 
                                                                ><b style="color: white">R</b></a>
                                                            </label>
                                                            <input type="radio" name="event" class="neutral" checked id="radio-neutral_{{$leaveRequest->id}}" />
                                                            <label for="radio-neutral_{{$leaveRequest->id}}" data-toggle="tooltip" 
                                                                data-placement="top"  title=""  data-original-title="Pending"  style="
                                                                <?php 
                                                                    if ($leaveRequest->leave_status ==  1) {  
                                                                        echo  '
                                                                            display: inline-block;
                                                                            width: 36px;
                                                                            border-radius: 39%;
                                                                            color: white;
                                                                            padding: 1px;
                                                                            background-color: #ffb136;
                                                                            padding-left: 13px;
                                                                            ';
                                                                   } else {
                                                                    
                                                                    echo '
                                                                        left: 43%;
                                                                        pointer-events: auto;';
                                                                   }
                                                                ?>">
                                                                <a style="color: white" href="{{ route('getLeavependding',['pendingId' => base64_encode($leaveRequest->id)]) }}" 
                                                                        ><b style="color: white">P</b>
                                                                </a>
                                                            </label>
                                                        </div> 
                                                    </td>
                                                @endif
                                                
                                                <td>
                                                    <?php 
                                                    if ($leaveRequest->leave_status ==  1 && (Session::get('sessionUserData')[0][0]->role_id == 3 || 
                                                    Session::get('sessionUserData')[0][0]->role_id == 2)) {
                                                    ?>
                                                        <a href="{{ route('leaverequest.viewbyid',['leaveId' =>  base64_encode($leaveRequest->id)]) }}" 
                                                        title="" class="btn btn-xs btn-info" style="padding: 0px 4px;" >
                                                            <i class="ti-pencil"></i> 
                                                        </a>
                                                        <a href="{{ route('leaverequest.delete',['leavesId' =>  base64_encode($leaveRequest->id)]) }}" 
                                                        onclick="return confirm('Are you Want to delete?')" class="btn btn-xs btn-danger"  
                                                        style="padding: 0px 4px;">
                                                            <i class="ti-trash"></i> 
                                                        </a>
                                                    
                                                    <?php 
                                                    } else if (Session::get('sessionUserData')[0][0]->role_id == 1 && $leaveRequest->user_id == 1) {
                                                    ?>
                                                        
                                                        <a href="{{ route('leaverequest.viewbyid',['leavesId' =>  
                                                            base64_encode($leaveRequest->id)]) }}"  
                                                            class="btn btn-xs btn-info"  style="padding: 0px 4px;" >
                                                            <i class="ti-pencil"></i> 
                                                        </a>
                                                        <a href="{{ route('leaverequest.delete',['leavesId' =>      
                                                            base64_encode($leaveRequest->id)]) }}" onclick="return confirm('Are you Want to delete?')" 
                                                            class="btn btn-xs btn-danger"  style="padding: 0px 4px;">
                                                            <i class="ti-trash"></i> 
                                                        </a>

                                                    <?php 
                                                    }
                                                    ?>
                                                </td>
                                            
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('admin.common.script2')
    <!--<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
   -->
    <script>
        /*var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            
            $scope.leaveRequestFormData = {};
            $scope.isInsert = true;
            
            $scope.fetchLeaveRequestData = function() {
                $http.get("{{route('leaverequest.view')}}").success(function(data) {
                    angular.forEach(data, function (value, key) { 
                        if (value.leave_status == 1) {
                            $scope.pending = {
                                "display"           : "inline-block",
                                "width"             : "36px",
                                "border-radius"     : "39%",
                                "color"             : "white",
                                "padding"           : "1px",
                                "background-color"  : "#ffb136",
                                "padding-left"      : "13px"
                            }
                            $scope.pendined = 1;
                        } 
                        
                        /*if (value.leave_status == 1) {
                            $scope.pending = {
                                "display" : "inline-block",
                                "width": "36px",
                                "border-radius" : "39%",
                                "color" : "white",
                                "padding" : "1px",
                                "background-color": "#ffb136",
                                "padding-left": "13px"
                            }    
                        } else if (value.leave_status == 2) {
                            $scope.rejected = {
                                "display" : "inline-block",
                                "width": "36px",
                                "border-radius" : "39%",
                                "color" : "white",
                                "padding" : "1px",
                                "background-color": "#e74a25"
                            }
                        } else {
                            $scope.apporved = {
                                "display" : "inline-block",
                                "width": "36px",
                                "border-radius" : "39%",
                                "color" : "white",
                                "padding" : "1px",
                                "background-color": "#2ecc71"
                            }
                        }
                       
                    });
                    $scope.leaveRequestData = data;
                    
                });     
            };
        }); */
        
        
        function resetLeaveForm() {
            window.location.href = "{{route('leaverequest') }}";
        }

        function addLeaveData() {
            
            var leaveTypeForm = $('#leave_type_form').val();
            var formLeaveDate = $('#form_leave_date').val();
            var toLeaveDate = $('#to_leave_date').val();
            var reason = $('#reason').val();
            var _token = $('#_token').val();
            var leaveId = $('#leaveId').val();
            var userId = $('#userId').val();
            
            if (formLeaveDate == '' || toLeaveDate == '' || reason == '')  {
                        
                if (formLeaveDate == '') {
                    $('#errorFormMsg').show();
                    $('#errorFormMsg').html('Select Form Date');
                } else {
                    $('#errorFormMsg').hide();
                }
                
                if (toLeaveDate == '') {
                    $('#errorToMsg').show();
                    $('#errorToMsg').html('Select To Date');
                } else {
                    $('#errorToMsg').hide();
                }

                if (reason == '') {
                    $('#errorResonMsg').show();
                    $('#errorResonMsg').html('Reason field is Required.');
                } else {
                    $('#errorResonMsg').hide();
                }

                return false;
                    
            } else {

                $('#errorToMsg').hide();
                $('#errorFormMsg').hide();
                $('#errorResonMsg').hide();
                
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Submiting');
                
                var data = new FormData();
                data.append("_token", _token);
                data.append("leave_type_form", leaveTypeForm);
                data.append("form_leave_date", formLeaveDate);
                data.append("to_leave_date", toLeaveDate);
                data.append("reason", reason);
                data.append("leaveId", leaveId);
                data.append("userId", userId);
                
                if (leaveId == undefined) {

                    $.ajax({
                        url: "{{ route('leaverequest.add') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            if (data == 1) {
                                
                                $('#errorFormMsg').show();
                                $('#errorFormMsg').html('Date already Exists.');
                                $('#errorToMsg').show();
                                $('#errorToMsg').html('Date already Exists.');
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Submit');
                                
                            } else if (data == 2) {
                                
                                $('#errorFormMsg').show();
                                $('#errorFormMsg').html('Invalid Form Date');
                                $('#errorToMsg').show();
                                $('#errorToMsg').html('Invalid To Date');
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Submit');
                                
                            } else {
                                
                                window.location.href = "{{route('leaverequest') }}";
                            }
                        }
                    });

                } else {

                    $.ajax({
                        url: "{{ route('leaverequest.edit') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            if (data == 2) {
                                
                                $('#errorFormMsg').show();
                                $('#errorFormMsg').html('Invalid Form Date');
                                $('#errorToMsg').show();
                                $('#errorToMsg').html('Invalid To Date');
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Submit');
                                
                            } else {
                                
                                window.location.href = "{{route('leaverequest') }}";
                            }
                        }
                    });
                }
            }
        }
        
        @if(!empty($deleteMsg))
            toastr.success(
                '{{$deleteMsg}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 3000 
                });
        @endif
        
        @if(\Session::has('message'))
            toastr.success(
                '{{session()->get('message')}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 
                3000 
            });
        @endif
    </script>
    </body>
</html>

