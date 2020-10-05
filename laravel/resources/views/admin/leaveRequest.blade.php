@include('admin.common.main')
<?php 
    if(!empty(Session::get('sessionUserData'))) {
        foreach (Session::get('sessionUserData') as $sessionUserData) {
            $roleId = !empty($sessionUserData[0]->role_id) ? $sessionUserData[0]->role_id : '';
        }
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            @if ($roleId == 1) 
                <h3 class="box-title pull-left">Manage Leave Request</h3>
            @endif
            @if ($roleId == 3) 
                <h3 class="box-title pull-left">Leave History</h3>
            @endif
            <div class="clearfix"></div>
            <hr>
            <div class="table-responsive" >
           		<style type="text/css">
                    .table td {
                        padding: 0.1rem !important;
                        vertical-align: top;
                        border-top: 1px solid #dee2e6;
                    }
                    .radio-wrapper {
                        width: 106px;
                        height: 36px;
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
                        height: 31px;
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
                        height: 31px;
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
                <table id="myTable" class="table-bordered">
                    <thead>
                        <tr>
                        	<th>Sr.No.</th>
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
                    	@if (!empty($getLeaveRequest))
                    		@foreach ($getLeaveRequest as $key => $leaveRequest)
                            	<tr  
                            		@if($leaveRequest->status == 'No') 
                                    	style="background-color:#ff851b !important"
                                	@endif
                                	>
		                        	<td>{{$key+1}}</td>

                                    @if ($roleId == 1)
                                        <td>{{$leaveRequest->name}}</td>
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
                                        <button type="button" class="btn-sm btn-success btn-info btn-outline" 
                                        data-container="body" title="" data-toggle="popover"  data-trigger="click_{{$leaveRequest->id}}" data-placement="left" data-original-title="Leave Reason  
                                        {{date('d-M-Y', strtotime($leaveRequest->date))}}" data-content="<?php echo wordwrap($leaveRequest->reason,33    , "\n", TRUE); ?>" > 
                                            Reason 
                                        </button>
                                    </td>
                                    
                                    <td>
                                        <?php
                                            if ($leaveRequest->leave_status ==  3) { 
                                                echo '<span class="label label-rounded label-success">Approved</span>';
                                            } else if ($leaveRequest->leave_status ==  2) {
                                                echo '<span class="label label-rounded label-danger">Rejected</span>';
                                            } else {
                                                echo '<span class="label label-warning">Pending</span>';
                                            }
                                        ?>
                                    </td>
                                    
                                    @if ($roleId == 1)
                                        <td>
                                            <div class="radio-wrapper">  
                                                <input type="radio" name="event" class="yes"   id="radio-yes_{{$leaveRequest->id}}"   />
                                                <label for="radio-yes_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" 
                                                    title=""  data-original-title="Apporved"   style=" 
                                                    <?php  
                                                        if ($leaveRequest->leave_status ==  3) {  
                                                            echo  
                                                            'margin-top:3px;
                                                            display: inline-block;
                                                            width: 36px;
                                                            border-radius: 39%;
                                                            color: white;
                                                            padding: 4px;
                                                            background-color: #2ecc71;
                                                           ';
                                                        }  else {
                                                            echo 'margin-top:7px;
                                                             ';
                                                        }

                                                    ?>">
                                                    <a style="color: white" href="{{ route('getLeaveapporves',['apporveId' =>  base64_encode($leaveRequest->id)]) }}"  ><b style="margin-left: 8px;">A</b> 
                                                    </a>&nbsp;
                                                </label>
                                                <input type="radio" name="event" class="no" id="radio-no_{{$leaveRequest->id}}" />
                                                <label for="radio-no_{{$leaveRequest->id}}" data-toggle="tooltip" data-placement="top" title=""  data-original-title="Rejected"  style="<?php 
                                                    if ($leaveRequest->leave_status ==  2) {  
                                                        echo  'margin-top:3px;
                                                                display: inline-block;
                                                                width: 36px;
                                                                border-radius: 39%;
                                                                color: white;
                                                                padding: 4px;
                                                                background-color: #e74a25;
                                                                 ';
                                                               
                                                        } else {

                                                            echo 'margin-top:7px;
                                                            pointer-events: auto;';

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
                                                                echo  'margin-top:3px;
                                                                    display: inline-block;
                                                                    width: 36px;
                                                                    border-radius: 39%;
                                                                    color: white;
                                                                    padding: 4px;
                                                                    background-color: #ffb136;
                                                                    padding-left: 13px;
                                                                    ';
                                                           } else {
                                                            
                                                            echo 'margin-top:7px;
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
        </div>
    </div>
</div>


@include('admin.common.script')



<script>
    @if(\Session::has('message'))
        $.toast({
            heading: 'Success!',
            position: 'top-right',
            text: '{{session()->get('message')}}',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
    @endif
</script>


