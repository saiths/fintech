@include('admin.common.main2')
<div id="main-wrapper">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" id="card-colors">
                        <?php 
                            $priority = '';
                            $severity = '';
                            $headColor = '';
                            $borderColor = '';
                            
                            if (!empty($tasks)) {
                                
                                $taskId = base64_decode($tasks);
                            
                                if ($taskId == 5) {
                                    
                                    $taskd = 5; // complete
                                    $headColor = 'success';
                                    $borderColor = '#5ac146!important';
                                    
                                } else if ($taskId == 4) {
                                    
                                    $taskd = 4; // distrued
                                    $headColor = 'dark';
                                    $borderColor = '#343a40!important';

                                } else if($taskId == 3) {

                                    $taskd = 3; //fixed
                                    $headColor = 'info';
                                    $borderColor = '#137eff!important';
                                    
                                } else {
                                
                                    $taskd = 1; //new and process and reopen
                                    $headColor = 'warning';
                                    $borderColor = '#ffbc34!important';
                                    
                                }

                               
                               /* if ($tasks == 'MQ==') {
                                    $tasks = '!=';
                                } else {
                                    $tasks = '=';
                                }*/
                            }
                            
                            
                            
                            $getTicketData = DB::table('ticket')->select('ticket.*')
                            ->where('is_deleted_status','N')->get()->toArray();

                            if (!empty($getTicketData)) {
                                foreach ($getTicketData as $key => $ticketData) {
                                    $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status` WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                    if (!empty($getTicketStatusData)) {
                                        foreach ($getTicketStatusData as $ticketsData) {
                                            $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                            /*$getStatusIdArr = DB::select('SELECT * FROM `ticket_status` WHERE 
                                            is_deleted_status = "N" AND id = '.$ticketIdMax.' AND  ticket_status_id '.$tasks.' 5 ');*/
                                            
                                            $getStatusIdArr = DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" AND id = '.$ticketIdMax.' AND  ticket_status_id = '.$taskd.'');
                                            
                                            if (!empty($getStatusIdArr)) {
                                                foreach ($getStatusIdArr as $ticketsDatas) {
                                                    $ticketIdArrs[] = $ticketsDatas->ticket_id;
                                                }
                                            }
                                            if ($taskd == 1) {
                                                $proGetStatusIdArr = DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" AND id = '.$ticketIdMax.' AND 
                                                    ticket_status_id = 2');
                                                
                                                $reopenGetStatusIdArr = DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" AND id = '.$ticketIdMax.' AND 
                                                    ticket_status_id = 6');
                                                
                                                if (!empty($proGetStatusIdArr)) {
                                                    foreach ($proGetStatusIdArr as $ticketsDatas) {
                                                        $proTicketIdArrs[] = $ticketsDatas->ticket_id;
                                                    }
                                                }

                                                if (!empty($reopenGetStatusIdArr)) {
                                                    foreach ($reopenGetStatusIdArr as $ticketsDatas) {
                                                        $repenoTicketIdArrs[] = $ticketsDatas->ticket_id;
                                                    }
                                                }
                                            }
                                        }
                                    }   
                                }
                                
                                $ticketIds = 0;
                                $proTicketIds = 0;
                                $reopenTicketIds = 0;

                                if ($taskd == 1) {
                                    if (!empty($ticketIdArrs)) { 
                                        $ticketIds = implode(',', $ticketIdArrs);   
                                    }
                                    if (!empty($proTicketIdArrs)) { 
                                        $proTicketIds = implode(',', $proTicketIdArrs);
                                    }
                                    if (!empty($repenoTicketIdArrs)) { 
                                        $reopenTicketIds = implode(',', $repenoTicketIdArrs);
                                    }
                                    $ticketIds =  $ticketIds.','.$proTicketIds.','.$reopenTicketIds;
                                
                                } else {
                                    if (!empty($ticketIdArrs)) {
                                        $ticketIds = implode(',', $ticketIdArrs);
                                    }
                                }
                                
                                $ticketsId = !empty($ticketIds) ? $ticketIds : 0;
                                
                                $getActiveTasks = DB::select('SELECT * FROM `ticket` WHERE is_deleted_status = "N" AND id IN('.$ticketIds.') ORDER BY ticket_no DESC');
                                
                                foreach ($getActiveTasks as $key => $ticket) {
                                    
                                    $ticketNo = !empty($ticket->ticket_no) ? $ticket->ticket_no : '';
                                    $title = !empty($ticket->title) ? $ticket->title : '';
                                    $getClientTicketTypeData = DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" AND id ='.$ticket->ticket_type_id.'');

                                    $getTicketData[$key]->ticketTypeName = 
                                    !empty($getClientTicketTypeData[0]->name) ? $getClientTicketTypeData[0]->name : '';

                                    $getProjectByIdData = DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N" AND id ='.$ticket->project_id.'');

                                    if (!empty($getProjectByIdData[0]->name)) {
                                        $getTicketData[$key]->projectName =  
                                        wordwrap($getProjectByIdData[0]->name,28, "<br />\n");
                                    }

                                    /*if (!empty($ticket->priority)) {
                                        if ($ticket->priority == 1) {
                                            $priority = 'High';
                                        } else if ($ticket->priority == 2) {
                                            $priority = 'Low';
                                        } else {
                                            $priority = 'Medium';
                                        }
                                    }*/
                                    
                                    
                                    if (empty($getActiveTasks[$key]->priority)) {
                                        $priority = '';
                                    } else {    

                                        if ($getActiveTasks[$key]->priority == 1) { 
                                            $priority = 'High';
                                        }
                                        if ($getActiveTasks[$key]->priority == 2) { 
                                            $priority = 'Low';
                                        }
                                        if ($getActiveTasks[$key]->priority == 3) { 
                                            $priority = 'Medium';
                                        }
                                    }
                                    
                                    if (empty($getActiveTasks[$key]->severity)) {
                                        $severity = '';
                                    } else {    

                                        if ($getActiveTasks[$key]->severity == 1) { 
                                            $severity = 'Critical';
                                        }
                                        if ($getActiveTasks[$key]->severity == 2) { 
                                            $severity = 'Normal';
                                        }
                                       
                                    }
                                    
                                    
                                    /*if (!empty($ticket->severity)) {
                                        if ($ticket->severity == 1) {
                                            $severity = 'Critical';
                                        } else if ($ticket->severity == 2) {
                                            $severity = 'Normal';
                                        }
                                    }*/

                                    $userName = '';
                                    $getAssignDatad =  DB::select('SELECT * FROM ticket_assign WHERE is_deleted_status = "N" AND ticket_id = '.$ticket->id.'');
                                    $userIdArrd = [];
                                    if (!empty($getAssignDatad)) {
                                        foreach ($getAssignDatad as $ticketAssing) {
                                            $userIdArrd[] = $ticketAssing->user_id;
                                        }       
                                    }

                                    $userIded = implode(',', $userIdArrd);
                                    $userIdArrs = !empty($userIded) ? $userIded : 0;
                                    $getUserNameDatad = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND id IN('.$userIdArrs.') ORDER BY username');
                                        
                                    $userAssingName = '';
                                    if (!empty($getUserNameDatad)) {
                                        foreach ($getUserNameDatad as $user) {
                                            $userAssingName .= ' '.$user->username.' ,';
                                        }
                                        $userNames =  rtrim($userAssingName,',');
                                    } else {
                                        $userNames =  '';
                                    }
                                    
                                    $getTicketData[$key]->userAssingName = !empty($userNames) ? $userNames : '';
                                    
                                    /* view Ticekt Part */
                                    
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                                        if (!empty($ticket->ticket_type_id_admin)) {
                                            $ticketTypes = !empty($ticket->ticket_type_id_admin) ? $ticket->ticket_type_id_admin : '';
                                        } else {
                                            $ticketTypes = !empty($ticket->ticket_type_id) ? $ticket->ticket_type_id : '';
                                        }
                                    } else if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                        if (!empty($ticket->ticket_type_id_admin)) {
                                            $ticketTypes = !empty($ticket->ticket_type_id_admin) ? $ticket->ticket_type_id_admin : '';
                                        } else {
                                            $ticketTypes = !empty($ticket->ticket_type_id) ? $ticket->ticket_type_id : '';
                                        }
                                    } else {
                                        $ticketTypes = !empty($ticket->ticket_type_id) ? $ticket->ticket_type_id : '';
                                    }
                    
                                    $clientRole = '';
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                                        
                                        if (!empty($ticket->ticket_type_id_admin)) {
                                            $editTicketTypeId = $ticket->ticket_type_id_admin;
                                            if (!empty($ticket->user_id)) {    
                                                $getClientRole = [];
                                                $getClientRole = DB::table('user_master')
                                                    ->select('username','role_id')
                                                    ->where('id',$ticket->user_id)
                                                    ->where('is_deleted_status','N')
                                                    ->get()
                                                    ->toArray();
                                                if (!empty($getClientRole)) {
                                                    $clientRole =  $getClientRole[0]->role_id;
                                                    if ($clientRole == 4) {
                                                        $editTicketTypeId = $ticket->ticket_type_id;
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!empty($ticket->user_id)) {    
                                                $getClientRole = [];
                                                $getClientRole = DB::table('user_master')
                                                    ->select('username','role_id')
                                                    ->where('id',$ticket->user_id)
                                                    ->where('is_deleted_status','N')
                                                    ->get()
                                                    ->toArray();
                                                if (!empty($getClientRole)) {
                                                    $clientRole =  $getClientRole[0]->role_id;
                                                    if ($clientRole == 4) {
                                                        $editTicketTypeId = $ticket->ticket_type_id;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if (!empty($ticket->ticket_type_id)) {
                                            $editTicketTypeId = $ticket->ticket_type_id;
                                        }
                                    }
                                    
                                    $taskCompittionDate = '';
                                    
                                    if (!empty($ticket->task_compittion_date)) {
                                        if ($ticket->task_compittion_date == '1111-11-11') {
                                            $taskCompittionDate = date('d-m-Y');
                                        } else  {
                                            $taskCompittionDate = date("d-m-Y", strtotime($ticket->task_compittion_date));
                                        } 
                                    }

                                    $roleIds       = !empty($getClientRole[0]->role_id) ? $getClientRole[0]->role_id : 0;
                                    $editProjectId = !empty($ticket->project_id) ? $ticket->project_id : 0;
                                    
                                                    
                                    /* -------------------------- view Ticke Part -----------------------------------*/
                                    ?>
                                    
                                    <div class="col-md-12 col-sm-12">
                                        <?php
                                            $colourStatus = 'warning';
                                            $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` 
                                            WHERE is_deleted_status = "N" AND ticket_id = '.$ticket->id.' 
                                            ORDER BY id DESC LIMIT 1 '); 
                                            $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? 
                                            $getTicketStatusById[0]->ticket_status_id : 0;
                                            if (!empty($ticketStatusId)) {
                                                if ($ticketStatusId == 5) {
                                                    $colourStatus = 'success';
                                                } 
                                            }
                                        ?>  
                                        <div class="card" 
                                            <?php 
                                                echo 'style="border:3px solid '.$borderColor.';border-radius:7px;"';
                                            /*if ($colourStatus == 'warning') {
                                                echo 'style="border:3px solid #ffbc34!important"';
                                            } else {
                                                echo 'style="border:3px solid #5ac146!important"';
                                            }*/
                                            ?>
                                            >
                                            <div class="card-header bg-{{$headColor}}" style="height:38px;padding:8px;">
                                                <div class="row">
                                                    <div class="col-md-8 text-left">
                                                        <h4 class="m-b-0 text-white" style="font-size:16px;">
                                                            <b><?php echo $ticketNo; ?> - <?php echo $title; ?></b>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h4 class="m-b-0 text-white" style="font-size:16px;">
                                                            <b>Project : <?php echo $getTicketData[$key]->projectName; ?></b>
                                                        </h4>
                                                    </div>
                                                    <?php 
                                                        $ticketId = !empty($ticket->id) ? $ticket->id : 0;
                                                        $getTicketAttachmentData = DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.'');
                                                        if (!empty($getTicketAttachmentData)) {
                                                        ?>

                                                            <div class="col-md-1">
                                                                <h4 class="m-b-0 text-white" style="font-size:16px;">
                                                                    <div class="tooltip14" style="border:none;">
                                                                        <i class="mdi mdi-paperclip"></i>
                                                                        <span class="tooltiptext">Attachment</span>
                                                                    </div>
                                                                </h4>
                                                            </div>
                                                            <?php 
                                                        }
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="card-body" style="height:67px;background: #C8C8C8;">
                                                <div class="row" style="margin-top:-10px;">
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-4">
                                                                <a href="#"  data-toggle="modal" data-target="#tickettype_<?php echo $ticket->id; ?>">TYPE</a> <b style="color:black;">:</b>  
                                                            </label>
                                                            <div class="col-md-8">
                                                                <div  style="border:none;background: #C8C8C8;"><?php echo $getTicketData[$key]->ticketTypeName; ?></div>
                                                                <div id="tickettype_<?php echo $ticket->id; ?>" class="modal"  role="dialog" aria-labelledby="vcenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="height:50px;">
                                                                                <h4 class="modal-title" id="vcenteir"><?php echo $ticketNo; ?> - Change Ticket Type</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group row">
                                                                                    <label for="inputEmail3" class="control-label text-right col-md-4">Select Ticket Type : </label>
                                                                                    <div class="col-md-6">
                                                                                        <select class="select2 m-b-10 select2" id="ticket_type_id_{{$ticket->id}}" name="ticket_type_id_{{$ticket->id}}"  style="width: 100%;height:50px;" 
                                                                                            <?php
                                                                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                                    Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                                                    echo 'disabled';
                                                                                                }
                                                                                            ?>>
                                                                                            <?php 
                                                                                                $getTicketTypeData = DB::select('SELECT * FROM ticket_type_master WHERE is_deleted_status = "N" ');
                                                                                            ?>
                                                                                            @if (!empty($getTicketTypeData))
                                                                                                @foreach ($getTicketTypeData as $ticketType)  
                                                                                                    <option value="{{$ticketType->id}}"
                                                                                                        @if (!empty($ticket->ticket_type_id_admin))
                                                                                                            {{ ($ticket->ticket_type_id_admin == $ticketType->id) ? 'selected=selected' : '' }}
                                                                                                        @else
                                                                                                            @if (!empty($ticket->ticket_type_id))
                                                                                                                {{ ($ticket->ticket_type_id == $ticketType->id) ? 'selected=selected' : '' }}
                                                                                                            @endif
                                                                                                        @endif
                                                                                                        >
                                                                                                        {{$ticketType->name}}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"  onclick="saveTicketType({{$ticket->id}})" class="btn btn-success">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-5">
                                                                <a href="#"  data-toggle="modal" data-target="#priority_<?php echo $ticket->id; ?>" >PRIORITY </a> <b style="color:black;">:</b> 
                                                            </label>
                                                            <div class="col-md-7">
                                                                <div style="border:none;background: #C8C8C8;"><?php echo $priority; ?></div>
                                                                <div id="priority_<?php echo $ticket->id; ?>" class="modal"  role="dialog" aria-labelledby="vcenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="height:50px;">
                                                                                <h4 class="modal-title" id="vcenteir"><?php echo $ticketNo; ?> - Change Priority</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group row">
                                                                                    <label for="inputEmail3" class="control-label text-right col-md-4">Set Priority : </label>
                                                                                    <div class="col-md-6">
                                                                                        <select class="select2 m-b-10 select2"   id="prioritys_{{$ticket->id}}" name="prioritys_{{$ticket->id}}" style="width: 100%;height:50px;border:1px solid #e74a25!important"
                                                                                            <?php 
                                                                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                                    Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                                                                    echo 'disabled';
                                                                                                }
                                                                                            ?>
                                                                                            >
                                                                                            <option value="1"
                                                                                                @if (!empty($ticket->priority))
                                                                                                    {{ ($ticket->priority == 1) ? 'selected=selected' : '' }}
                                                                                                @else
                                                                                                @endif>High
                                                                                            </option>
                                                                                            <option value="2" 
                                                                                                @if (!empty($ticket->priority))
                                                                                                    {{ ($ticket->priority == 2) ? 'selected=selected' : '' }}
                                        
                                                                                                @else
                                                                                                @endif>Low
                                                                                            </option>
                                                                                            <option value="3"
                                                                                                @if (!empty($ticket->priority))
                                                                                                    {{ ($ticket->priority == 3) ? 'selected=selected' : '' }}
                                        
                                                                                                @else
                                                                                                @endif>Medium
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"  onclick="savePriority({{$ticket->id}})" class="btn btn-success">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-5">
                                                                <a href="#" data-toggle="modal" data-target="#severitys_<?php echo $ticket->id; ?>" >SEVERITY </a><b style="color:black;">:</b>    
                                                            </label>
                                                            <div class="col-md-7">
                                                                <div style="border:none;background: #C8C8C8;"><?php echo $severity; ?></div>
                                                                <div id="severitys_<?php echo $ticket->id; ?>" class="modal"  role="dialog" aria-labelledby="vcenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="height:50px;">
                                                                                <h4 class="modal-title" id="vcenteir"><?php echo $ticketNo; ?> - Change Severity</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group row">
                                                                                    <label for="inputEmail3" class="control-label text-right col-md-4">Set Severity : </label>
                                                                                    <div class="col-md-6">
                                                                                        <select class="select2 m-b-10 select2" 
                                                                                            id="severity_{{$ticket->id}}" name="severity_{{$ticket->id}}"  style="width: 100%;height:50px;border:1px solid #e74a25!important"
                                                                                            <?php 
                                                                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                                    Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                                                                    echo 'disabled';
                                                                                                }
                                                                                            ?>
                                                                                            >
                                                                                            <option value="1"
                                                                                                @if (!empty($ticket->severity))
                                                                                                    {{ ($ticket->severity == 1) ? 'selected=selected' : '' }}
                                                                                                @else
                                                                                                @endif
                                                                                                >Critical 
                                                                                            </option>
                                                                                            <option value="2"
                                                                                                @if (!empty($ticket->severity))
                                                                                                    {{ ($ticket->severity == 2) ? 'selected=selected' : '' }}
                                                                                                @else
                                                                                                @endif
                                                                                                >Normal
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"  onclick="saveSeverity({{$ticket->id}})" class="btn btn-success">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-6">
                                                                <a href="#" data-toggle="modal" data-target="#ticketstatus_<?php echo $ticket->id; ?>" >STATUS </a><b style="color:black;">:</b> 
                                                            </label>
                                                            <div class="col-md-6">
                                                                <?php 
                                                                    $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" AND ticket_id = '.$ticket->id.' ORDER BY id DESC LIMIT 1 '); 
                                                                    $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                                    $commonDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                    $fixedDate = '';
                                                                    $completedDate = '';                                                                                         
                                                                    if (!empty($commonDate)) {
                                                                        if ($ticketStatusId == 3) {
                                                                            $fixedDate =  !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                        } else if ($ticketStatusId == 5) {
                                                                            $completedDate =  !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                        }
                                                                    }
                                                                    $getTicketStatusData = DB::select('SELECT * FROM `ticket_status_master` WHERE is_deleted_status = "N" 
                                                                    AND status ='.$ticketStatusId.'');
                                                                    $ticketStatus = !empty($getTicketStatusData[0]->ticket_status) ? $getTicketStatusData[0]->ticket_status : '';
                                                                    
                                                                ?>
                                                                
                                                                <div style="border:none;background: #C8C8C8;"><?php echo $ticketStatus; ?></div>
                                                                <div id="ticketstatus_<?php echo $ticket->id; ?>" class="modal"  role="dialog" aria-labelledby="vcenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="height:50px;">
                                                                                <h4 class="modal-title" id="vcenteir"><?php echo $ticketNo; ?> - Change Ticket Status</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group row">
                                                                                    <label for="inputEmail3" class="control-label text-right col-md-4">Select Ticket Status : </label>
                                                                                    <div class="col-md-6">
                                                                                        <select class="borderred select2 m-b-10 select2" id="ticket_status_id_{{$ticket->id}}" name="ticket_status_id_{{$ticket->id}}"  style="width: 100%;height:50px;">
                                                                                            <?php  
                                                                                                $ticketStatusIds = !empty($ticket->id) ? $ticket->id : 0;
                                                                                                $getTicketStatusById =  
                                                                                                DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  
                                                                                                ticket_id = '.$ticketStatusIds.'  
                                                                                                ORDER BY id DESC LIMIT 1'); 
                                                                                                $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                                                                $getTicketStatusData = DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" ');
                                                                                            ?>
                                                                                            @if (!empty($getTicketStatusData))
                                                                                                @foreach ($getTicketStatusData as $ticketStatus)  
                                                                                                    <option value="{{$ticketStatus->status}}"
                                                                                                        @if (!empty($ticketStatusId))
                                                                                                            {{ ($ticketStatusId == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                                                                        @else
                                                                                                        @endif
                                                                                                        >{{$ticketStatus->ticket_status}}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"  onclick="saveTicketStatus({{$ticket->id}})" class="btn btn-success">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-8">
                                                                <a href="#" data-toggle="modal" data-target="#assignes_<?php echo $ticket->id; ?>" >ASSIGNED TO</a> <b style="color:black;">:</b> 
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div style="border:none;background: #C8C8C8;"><?php echo $getTicketData[$key]->userAssingName; ?></div>
                                                                <div id="assignes_<?php echo $ticket->id; ?>" class="modal"  role="dialog" aria-labelledby="vcenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="height:50px;">
                                                                                <h4 class="modal-title" id="vcenteir"><?php echo $ticketNo; ?> - Change Assigned To</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group row">
                                                                                    <label for="inputEmail3" class="control-label  text-right col-md-3">Asign User : </label>
                                                                                    <div class="col-md-7">
                                                                                        <select class="select2 m-b-10 select2-multiple" multiple style="width: 100%;height:50px;border:1px solid #e74a25!important"   
                                                                                            id="project_select_<?php echo $ticket->id; ?>"  data-placeholder="Serach Assign User Name" 
                                                                                            name="user_id[]" <?php if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                                Session::get('sessionUserData')[0][0]->role_id == 3) 
                                                                                            { echo 'disabled';}?>>
                                                                                            <?php
                                                                                                $getUserNameData = [];
                                                                                                $userIdsArr = []; 
                                                                                                $ticketIds = !empty($ticket->id) ? $ticket->id : '';
                                                                                                if (!empty($ticketIds)) {
                                                                                                    $getUserAssignData =  DB::select('SELECT * FROM ticket_assign WHERE is_deleted_status = "N"  
                                                                                                    AND ticket_id = '.$ticketIds.'');
                                                                                                    if (!empty($getUserAssignData)) {
                                                                                                        foreach ($getUserAssignData as $users) {
                                                                                                            $userIdsArr[] = $users->user_id;
                                                                                                        }   
                                                                                                    }
                                                                                                }
                                                                                                if (!empty($editProjectId)) {
                                                                                                    $getProjectAssingData = DB::select('SELECT * FROM `project_assing_user` WHERE is_deleted_status = "N" AND project_id = '.$editProjectId.'');
                                                                                                    foreach ($getProjectAssingData as $projectUserID) {
                                                                                                        $projectUserIdsArr[] = $projectUserID->user_id;
                                                                                                    }
                                                                                                    $projectUserIdsArr = !empty($projectUserIdsArr) ? $projectUserIdsArr : 0;
                                                                                                    
                                                                                                    if (!empty($projectUserIdsArr)) {
                                                                                                        $projectUserIds = implode(',', $projectUserIdsArr);
                                                                                                    } 
                                                                                                    
                                                                                                    $projectUserId = !empty($projectUserIds) ? $projectUserIds : 0;
                                                                                                    $getUserData = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N"  
                                                                                                    AND id IN('.$projectUserId.') ORDER BY username');
                                                                                                }
                                                                                                
                                                                                                if (empty($userIdsArr)) {
                                                                                                    $userIdsArr = !empty($projectUserIdsArr) ? $projectUserIdsArr : '';
                                                                                                }
                                                                                            ?>
                                                                                        
                                                                                            @if (!empty($getUserData))
                                                                                                @foreach($getUserData as $user)
                                                                                                    <option value="{{$user->id}}"
                                                                                                        <?php
                                                                                                        if (in_array($user->id, $userIdsArr)) {
                                                                                                            echo 'selected=selected';
                                                                                                        } 
                                                                                                        ?>
                                                                                                    >{{$user->username}}</option>
                                                                                                @endforeach
                                                                                            @endif 
                                                                                        </select>
                                                                                        <span class="text-danger" style="display:none" id="userIdMsg_<?php echo $ticket->id; ?>" style="">Please Select User Name.</span>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"  onclick="saveTicketAssign({{$ticket->id}})" class="btn btn-success">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group row">
                                                            <label for="inputEmail3" class="control-label text-right col-md-4">
                                                                VIEW <b style="color:black;">:</b>
                                                            </label>
                                                            <div class="col-md-8">
                                                                <div style="border:none;background: #C8C8C8;">
                                                                    <a href="{{ route('aticket.viewbyid',
                                                                        ['ticketId' =>  base64_encode($ticket->id)]) }}" onclick="showTicketData(<?php echo $ticket->id; ?>)">More Detail
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-left:10px;margin-top:-10px;">
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label col-md-4" style="color:#000000">Created on  :</label>
                                                            <div class="col-md-4"><?php if (!empty($ticket->created_at)) {
                                                                    $datePart = explode(' ', $ticket->created_at);
                                                                    echo $datePart[0];
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label col-md-4" style="color:#000000">
                                                                <?php 
                                                                    $getTicketStatusById =  DB::select('SELECT * FROM `ticket_assign` WHERE is_deleted_status = "N" 
                                                                    AND ticket_id = '.$ticket->id.' ORDER BY id DESC LIMIT 1');
                                                                    $assingDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                    $finalAssingDate = explode(' ',$assingDate);
                                                                ?>
                                                                Assigned on : 
                                                            </label>
                                                            <div class="col-md-4">
                                                                <?php echo !empty($finalAssingDate[0]) ? $finalAssingDate[0] : ''; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label col-md-4" style="color:#000000">
                                                                Fixed on    :  
                                                            </label>
                                                            <div class="col-md-4">
                                                                <?php 
                                                                    $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" 
                                                                    AND ticket_id = '.$ticket->id.' AND ticket_status_id = 5 ORDER BY id DESC LIMIT 1');
                                                                    $completedDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                    $finalCompletedDate = explode(' ',$completedDate);
                                                                    
                                                                    $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" 
                                                                    AND ticket_id = '.$ticket->id.' AND ticket_status_id = 3 ORDER BY id DESC LIMIT 1');
                                                                    $fixedDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                    $finalFixedDate = explode(' ',$fixedDate);
                                                                    
                                                                ?>
                                                                <?php echo !empty($finalFixedDate[0]) ? $finalFixedDate[0] : ''; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <label for="inputEmail3" class="control-label col-md-5" style="color:#000000">
                                                                Completed on :  
                                                            </label>
                                                            <div class="col-md-5">
                                                                <?php echo !empty($finalCompletedDate[0]) ? $finalCompletedDate[0] : ''; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php /*
                                            <div class="card-header text-white" style="height: 38px;background-color:#808080;" >
                                                <div class="col-md-6" style="max-width:100%">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="control-label col-md-3" style="margin-top:-3px;color:#000000">
                                                            Created on  : 
                                                            <?php 
                                                                if (!empty($ticket->created_at)) {
                                                                    $datePart = explode(' ', $ticket->created_at);
                                                                    echo $datePart[0];
                                                                }
                                                            ?>
                                                        </label>
                                                        <?php 
                                                            $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" 
                                                            AND ticket_id = '.$ticket->id.' AND ticket_status_id = 5 ORDER BY id DESC LIMIT 1');
                                                            $completedDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                            $finalCompletedDate = explode(' ',$completedDate);
                                                            
                                                            $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status` WHERE is_deleted_status = "N" 
                                                            AND ticket_id = '.$ticket->id.' AND ticket_status_id = 3 ORDER BY id DESC LIMIT 1');
                                                            $fixedDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                            $finalFixedDate = explode(' ',$fixedDate);
                                                            
                                                        ?>
                                                        <label for="inputEmail3" class="control-label col-md-3" style="margin-top:-3px;color:#000000">
                                                            <?php 
                                                                $getTicketStatusById =  DB::select('SELECT * FROM `ticket_assign` WHERE is_deleted_status = "N" 
                                                                AND ticket_id = '.$ticket->id.' ORDER BY id DESC LIMIT 1');
                                                                $assingDate = !empty($getTicketStatusById[0]->created_at) ? $getTicketStatusById[0]->created_at : '';
                                                                $finalAssingDate = explode(' ',$assingDate);
                                                            ?>
                                                            Assigned on : <?php echo !empty($finalAssingDate[0]) ? $finalAssingDate[0] : ''; ?>
                                                        </label>
                                                        <label for="inputEmail3" class="control-label col-md-3" style="margin-top:-3px;color:#000000">
                                                            Fixed on    : <?php echo !empty($finalFixedDate[0]) ? $finalFixedDate[0] : ''; ?> 
                                                        </label>
                                                        <label for="inputEmail3" class="control-label col-md-3" style="margin-top:-3px;color:#000000">
                                                            Completed on : <?php echo !empty($finalCompletedDate[0]) ? $finalCompletedDate[0] : ''; ?> 
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>*/?>
                                            
                                        </div>
                                    </div>
                                    
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('admin.common.script2')
<script type="text/javascript">

    function saveTicketType(ticket_id) {
        var ticketTypeId = $('#ticket_type_id_'+ticket_id).val();
        $.ajax({
            url: "{{ route('ticketType.save') }}",
            type: 'GET',
            data : { 
                ticketTypeId: ticketTypeId,
                ticket_id: ticket_id,
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }
    
    function savePriority(ticket_id) {
        var priority = $('#prioritys_'+ticket_id).val();
        $.ajax({
            url: "{{ route('priority.save') }}",
            type: 'GET',
            data : { 
                priority    : priority,
                ticket_id   : ticket_id,
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }
    
    function saveSeverity(ticket_id) {
        var severity = $('#severity_'+ticket_id).val();
        $.ajax({
            url: "{{ route('severity.save') }}",
            type: 'GET',
            data : { 
                severity    : severity,
                ticket_id   : ticket_id,
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }
    
    function saveTicketStatus(ticket_id) {
        var status = $('#ticket_status_id_'+ticket_id).val();
        $.ajax({
            url: "{{ route('status.save') }}",
            type: 'GET',
            data : { 
                status      : status,
                ticket_id   : ticket_id,
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }
    
    function saveTicketAssign(ticket_id) {
        var assignUserId = $('#project_select_'+ticket_id).val();
        if (assignUserId != '') {
            $('#userIdMsg_'+ticket_id).hide();
            $.ajax({
                url: "{{ route('assignuser.save') }}",
                type: 'GET',
                data : { 
                    assignUserId : assignUserId,
                    ticket_id    : ticket_id,
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        } else {
            $('#userIdMsg_'+ticket_id).show();
        }
    }
    
    @if(\Session::has('message'))
        toastr.success(
            '{{session()->get('message')}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif

    function showTicketData(ticketId)
    {
        var ticketId = btoa(ticketId);   
        window.location.href = "aticket/viewbyid/"+ticketId+"";
    }
</script>