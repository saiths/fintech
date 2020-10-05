@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            @if(!empty($getTicketDataByID))
                @foreach ($getTicketDataByID as $getEditTicket)
                @endforeach
            @endif
            <?php 
                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                    if (!empty($getEditTicket->ticket_type_id_admin)) {
                        $ticketTypes = !empty($getEditTicket->ticket_type_id_admin) ? $getEditTicket->ticket_type_id_admin : '';
                    } else {
                        $ticketTypes = !empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id : '';
                    }
                } else if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) { 
                    if (!empty($getEditTicket->ticket_type_id_admin)) {
                        $ticketTypes = !empty($getEditTicket->ticket_type_id_admin) ? $getEditTicket->ticket_type_id_admin : '';
                    } else {
                        $ticketTypes = !empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id : '';
                    }
                } else {
                    $ticketTypes = !empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id : '';
                }
                
                $clientRole = '';
                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                    if (!empty($getEditTicket->ticket_type_id_admin)) {
                        $editTicketTypeId = $getEditTicket->ticket_type_id_admin;
                        if (!empty($getEditTicket->user_id)) {    
                            $getClientRole = [];
                            $getClientRole = DB::table('user_master')
                                ->select('username','role_id')
                                ->where('id',$getEditTicket->user_id)
                                ->where('is_deleted_status','N')
                                ->get()
                                ->toArray();
                            if (!empty($getClientRole)) {
                                $clientRole =  $getClientRole[0]->role_id;
                                if ($clientRole == 4) {
                                    $editTicketTypeId = $getEditTicket->ticket_type_id;
                                }
                            }
                        }
                  
                        
                    } else {
                     
                        
                        if (!empty($getEditTicket->user_id)) {    
                            $getClientRole = [];
                            $getClientRole = DB::table('user_master')
                                ->select('username','role_id')
                                ->where('id',$getEditTicket->user_id)
                                ->where('is_deleted_status','N')
                                ->get()
                                ->toArray();
                            if (!empty($getClientRole)) {
                                $clientRole =  $getClientRole[0]->role_id;
                                if ($clientRole == 4) {
                                    $editTicketTypeId = $getEditTicket->ticket_type_id;
                                }
                            }
                        }
                        
                    }
                } else {
                    if (!empty($getEditTicket->ticket_type_id)) {
                        $editTicketTypeId = $getEditTicket->ticket_type_id;
                    }
                }
                
                $taskCompittionDate = '';
                if (!empty($getEditTicket->task_compittion_date)) {
                    if ($getEditTicket->task_compittion_date == '1000-10-01') {
                        $taskCompittionDate = date('d-m-Y');
                    } else  {
                        $taskCompittionDate = date("d-m-Y", strtotime($getEditTicket->task_compittion_date));
                    } 
                }
            ?>
            
            <h3 class="box-title m-b-0">
                {{ !empty($getEditTicket->id) ? 'Edit Ticket' : 'Add  Ticket' }}</h3>
            
            <p class="text-muted m-b-30 font-13 "> <span class="text-danger"> *Indicates Required Field </span></p>
            
            @if(!empty($getEditTicket->id))
            <form class="form-horizontal" autocomplete="off" class="form-horizontal" id="register_form" 
                name="register_form" action="{{ route('ticket.edit') }}" method="post" autocomplete="off" 
                onsubmit="return validateform()" enctype="multipart/form-data" >
            @else 
            <form class="form-horizontal" style="margin-top: 10px;" id="register_form"  name="register_form"  
                method="post"  action="{{ route('ticket.add') }}" enctype="multipart/form-data" autocomplete="off" 
                onsubmit="return validateform()" >
            @endif
            
                @if(!empty($getEditTicket->id))
                    <input type="hidden" name="ticketId"  value="{{$getEditTicket->id}}">
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <input type="hidden" name="ticketTypesId" id="ticketTypesId" 
                value="{{!empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id:''}}">

                <input type="hidden" name="ticketNos" id="ticketNos" 
                value="{{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no:''}}">

                
                <?php 
                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4) {
                        if (!empty($getEditTicket->user_id)) {
                            $getUserName = DB::table('user_master')
                                ->select('username','role_id')
                                ->where('id',$getEditTicket->user_id)
                                ->where('is_deleted_status','N')
                                ->get()
                                ->toArray();
                                $clientName =  $getUserName[0]->username;
                            ?>
                            <div class="row">
                                <div  class="col-md-6" style="margin-left: -15px;">
                                    <div class="form-group has-feedback {{ $errors->has('ticket_no') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-3 control-label ">Ticket No.</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="ticket_no" name="ticket_no" class="form-control" 
                                             data-date-format="dd-mm-yyyy" placeholder="Ticket No" value="{{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no : '' }}" 
                                            disabled=""> 
                                        </div>
                                    </div>
                                </div>   
                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {
                                ?>
                                    <div  class="col-md-6">
                                        <div class="form-group has-feedback {{ $errors->has('ticket_no') ? 'has-error' : '' }}">
                                            <label for="inputEmail3"  class="col-sm-3 control-label " style="margin-left:-28px">Ticket UserName</label>
                                            <div class="col-sm-8">
                                                <input type="text" style="margin-left:-27px" id="ticket_no" name="ticket_no" class="form-control" 
                                                 data-date-format="dd-mm-yyyy" placeholder="Ticket No" 
                                                 value="{{!empty($clientName) ?  $clientName : ''}}" disabled=""> 
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                } 
                                ?>
                            </div>
                        <?php 
                        }
                    }
                ?>
                
                <div class="row">
                    <?php 
                        $editProjectId = !empty($getEditTicket->project_id) ? $getEditTicket->project_id : 0;
                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4) {
                    ?>  
                            <div class="col-md-6" style="margin-left:-55px;">
                            <div class="form-group has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                <label for="inputEmail3" class="col-sm-4 control-label">Select Project<b class="text-danger">*</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" onchange="selectProject()" id="project_id" name="project_id"  
                                    style="border:1px solid #e74a25!important">
                                        <option value="">Select Project </option>
                                        <?php 
                                            $projectIdArr = [];
                                            $clientId = !empty(Session::get('sessionUserData')[0][0]->client_id) ? Session::get('sessionUserData')[0][0]->client_id : 0;
                                            $getClientProjectIdData =  DB::select('SELECT * FROM client_project_master WHERE is_deleted_status = "N" AND client_id = '.$clientId.' ');
                                            if (!empty($getClientProjectIdData)) {
                                                foreach ($getClientProjectIdData as $projectId) {
                                                    $projectIdArr[] = $projectId->project_id;
                                                }                                                
                                            }
                                            $projectIDs = implode(',', $projectIdArr);
                                            $projectIDs = !empty($projectIDs) ? $projectIDs : 0;
                                            $getProjectData =  DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N" AND id IN ('.$projectIDs.')'); 
                                            if (!empty($getProjectData)) {
                                                foreach ($getProjectData as $project) {
                                                    echo   '<option value="'.$project->id.'"';
                                                    if ($editProjectId == $project->id)  {
                                                        echo  'selected="selected"';
                                                    }
                                                    echo  '>'.$project->name.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="text-danger" id="projectIdMsg">{{ $errors->first('project_id') }}</span>
                                </div>
                            </div>
                        </div>
                        
                    <?php } else { ?>

                            <div class="col-md-6" style="margin-left: -55px;" >
                                <div class="form-group has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="col-sm-4 control-label">
                                        <?php
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                            Session::get('sessionUserData')[0][0]->role_id != 3) {
                                            echo 'Select';
                                        }
                                        ?>
                                        Project <?php if ($clientRole != 4) { echo  $clientRole; ?><b class="text-danger">*</b><?php } ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" onchange="selectProject()" id="project_id" name="project_id" 
                                        <?php
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                echo 'disabled';
                                            }
                                        ?> style="border:1px solid #e74a25!important">
                                        <option value="">Select Project </option>
                                        <?php 
                                            $projectIdArr = [];
                                            $getProjectData =  DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N"'); 
                                            if (!empty($getProjectData)) {
                                                foreach ($getProjectData as $project) {
                                                    echo   '<option value="'.$project->id.'"';
                                                    if ($editProjectId == $project->id)  {
                                                        echo  'selected="selected"';
                                                    } else {
                                                        if ($clientRole == 4) {
                                                            echo 'disabled="disabled"';
                                                        }
                                                    }
                                                    echo  '>'.$project->name.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="text-danger" id="projectIdMsg">{{ $errors->first('project_id') }}</span>
                                </div>
                            </div>
                        </div>
                    
                    <?php } ?>
                    
                    <div class="col-md-6">
                        <div class="form-group has {{ $errors->has('ticket_type_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Ticket Type<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <select class="form-control select2" onchange="ticketType()"
                                    <?php
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                            Session::get('sessionUserData')[0][0]->role_id == 3) {
                                            echo 'disabled';
                                        }
                                    ?>
                                    <?php 
                                    //    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                          //  Session::get('sessionUserData')[0][0]->role_id == 1) {
                                    ?>
                                    <?php 
                                     //   } else  {
                                    ?>id="ticket_type_id" name="ticket_type_id"  
                                    <?php 
                                     //   }
                                    ?> 
                                        style="border:1px solid #e74a25!important">
                                    
                                    <?php 
                                        $getTicketTypeData = DB::select('SELECT * FROM ticket_type_master WHERE is_deleted_status = "N" ');
                                    ?>
                                    <option value="">Select Ticket Type</option>
                                    @if (!empty($getTicketTypeData))
                                        @foreach ($getTicketTypeData as $ticketType)  
                                            <?php 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                    Session::get('sessionUserData')[0][0]->role_id == 1) {
                                                ?>
                                                <option value="{{$ticketType->id}}"
                                                    @if (!empty($ticketTypes))
                                                        {{ ($ticketTypes == $ticketType->id) ? 'selected=selected' : '' }}
                                                    @else
                                                        {{ (old('ticket_type_id_admin') == $ticketType->id) ? 'selected=selected' : '' }}
                                                            @if (!empty($ticketTypesterTicketPostData['ticket_type_id_admin']))
                                                                {{ ($registerTicketPostData['ticket_type_id_admin'] == $ticketType->id) ? 'selected=selected' : '' }}
                                                            @else
                                                            @endif
                                                    @endif >{{$ticketType->name}}
                                                </option>
                                            <?php 
                                            } else  {
                                            ?>
                                                <option value="{{$ticketType->id}}"
                                                    @if (!empty($ticketTypes))
                                                        {{ ($ticketTypes == $ticketType->id) ? 'selected=selected' : '' }}
                                                    @else
                                                        {{ (old('ticket_type_id') == $ticketType->id) ? 'selected=selected' : '' }}
                                                        @if (!empty($registerTicketPostData['ticket_type_id']))
                                                            {{ ($registerTicketPostData['ticket_type_id'] == $ticketType->id) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif
                                                    @endif
                                                    >{{$ticketType->name}}
                                                </option>
                                            <?php 
                                                }
                                            ?>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="ticketTypeId"> 
                                    <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                        Session::get('sessionUserData')[0][0]->role_id == 1) {
                                    ?>  
                                        {{ $errors->first('ticket_type_id_admin') }}
                                    <?php 
                                    } else  {
                                    ?>
                                        {{ $errors->first('ticket_type_id') }}
                                    <?php 
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="margin-left: 36px;">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <div class="col-md-1" >
                                <label for="inputEmail3" class="control-label">Title<b class="text-danger">*</b></label>
                            </div>
                            <div class="col-md-11">
                                <input class="form-control" style="border:1px solid #e74a25!important;width: 90%" 
                                type="text" oninput="emptyTitle()" placeholder="Title" id="title" name="title"   
                                value="{{ !empty($getEditTicket->title) ? $getEditTicket->title : old('title') }}{{ !empty($registerTicketPostData['title']) ? $registerTicketPostData['title'] : '' }}"
                                <?php 
                                    if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                                        echo 'readonly="readonly"';
                                    }
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                        echo 'disabled="disabled"';
                                    }
                                ?>>
                                <span class="text-danger"   id="titleMsg"></span>
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @if (!empty($emptyErrorMsg['checkTitleMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkTitleMsg']}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                 <?php 
                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {
                ?>
                
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="inputEmail3" class="control-label" style="margin-left: 56px;"  >Description</label>
                            </div>
                            <div class="col-md-10" <?php if (!empty($getEditTicket->id)) { echo 'style="margin-left: -49px;"';  } else { 
                                echo 'style="margin-left: -93px;"';}
                                ?>>
                                <div class="adjoined-bottom"  >
                                    <div class="grid-container">
                                        <div class="grid-width-100">
                                            <textarea class="form-control" id="editor"  style="width:  150px;" name="description"
                                                <?php 
                                                    if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                                                        echo 'readonly="readonly"';
                                                    }
                                                ?>> 
                                                {{ !empty($getEditTicket->description) ? $getEditTicket->description : old('description') }}{{ !empty($registerTicketPostData['description']) ? $registerTicketPostData['description'] : '' }}
                                            </textarea>
                                            <span class="text-danger">{{ $errors->first('description') }}</span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <?php 
                    } else {
                    
                    if (!empty($getEditTicket->description)) {
                ?>  
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="inputEmail3" style="margin-left: 61px;"; class="control-label">Description </label>
                            </div>
                            <div class="col-md-10" 
                                <?php
                                if (!empty($getEditTicket->id)) {
                                    echo "style='margin-left: -49px'";  
                                } else {
                                  echo  "style='margin-left: -93px'";
                                }
                                ?>>
                                <?php echo $getEditTicket->description; ?>
                            <span class="text-danger">{{ $errors->first('description') }}</span> 
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                    }
                }
                
                 
                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                        if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                        } else {
                            
                            
                ?>          
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Attachment</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" multiple="multiple" name="attachment[]" id="attachment">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        } 
                    } else {
                        
                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {

                ?>  
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <div class="form-group has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Attachment</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" multiple="multiple" name="attachment[]" id="attachment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        }
                    } 
                ?>
                <?php
                    $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                    $getTicketAttachmentData = DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.'');
                    if (!empty($getTicketAttachmentData)) {
                ?>
                        <div class="row" style="margin-left: 159px;">
                            <style type="text/css">
                                .table td {
                                    padding: 0.1rem !important;
                                    vertical-align: top;
                                    border-top: 1px solid #dee2e6;
                                }
                            </style> 
                            <table role="presentation" class="tablesaw table-bordered table-hover table" >
                                <thead>
                                    <tr>
                                        <th class="text-left">Sr. No.</th>
                                        <th>Attachment</th>
                                        <?php 
                                        
                                        $checkAttAction = 
                                          DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.' AND 
                                          role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                        if (!empty($checkAttAction)) {
                                            echo '<th style="width:50px;">Action</th>';
                                        }
                                          
                                        /*if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                                            if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                                            } else {
                                        ?>
                                        <th style="width:50px;">Action</th>
                                            <?php 
                                            } 
                                        } else { ?>
                                        <th style="width:50px;">Action</th>
                                        <?php 
                                        } 
                                        ?>
                                        */
                                        ?>
                                    </tr>
                                </thead>
                                <tbody class="files">
                                    <?php 
                                        $i = 1;
                                        foreach ($getTicketAttachmentData as $attachment) {
                                            $uploadPath = url('laravel/public/attachment');
                                            $ticketNoStr = $getEditTicket->ticket_no.'_';
                                            $finalFileName = str_replace($ticketNoStr, '', $attachment->attachment);
                                    ?>
                                            <tr id="attachment_<?php echo $attachment->id; ?>" >
                                                <td class="text-left"><?php echo $i; ?></td>
                                                
                                                <td> 
                                                    <a href="<?php echo  $uploadPath.'/'.$attachment->attachment ?>" target="_blank" 
                                                    download="<?php echo $finalFileName; ?>">
                                                        <?php echo $finalFileName;?>
                                                    </a>
                                                </td>
                                                <?php
                                                
                                                $checkAttAction =  DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND 
                                                ticket_id = '.$ticketId.' AND role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                if (!empty($checkAttAction)) {
                                                  
                                                  /*  if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                        Session::get('sessionUserData')[0][0]->role_id == 1) {
                                                        if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                                                        } else {*/
                                                ?>     
                                                        <td style="width: 55px;">
                                                            <a href="#" style="margin-left: 8px;"   
                                                            onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->attachment;?>')"  
                                                            class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" 
                                                            data-original-title="Delete"  style="padding: 0px 7px;"><i class="icon-trash"></i> 
                                                            </a>
                                                        </td>
                                                    <?php 
                                                }
                                                    /*}
                                                } else {*/
                                                ?>
                                                       <!-- <td>
                                                            <a href="#" onclick="deleteAttachment(<?php echo $attachment->id;?>,
                                                            '<?php //echo $attachment->attachment;?>')"  
                                                                class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" 
                                                                data-original-title="Delete"  style="padding: 0px 7px;"><i class="icon-trash"></i> 
                                                            </a>
                                                        </td>-->
                                                    <?php 
                                                   // } 
                                                ?>   
                                            </tr>
                                        <?php
                                         $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div> 
                    <?php 
                }
                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id 
                != 4) {
                ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has {{ $errors->has('priority') ? 'has-error' : '' }}">
                                <label for="inputEmail3" class="col-sm-5 control-label">Set Priority<b class="text-danger">*</b></label>
                                <div class="col-sm-7" style="margin-left:-15px;">
                                    <select class="form-control select2" onchange="setPriority()" id="priority" name="priority" 
                                    style="border:1px solid #e74a25!important"
                                    <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                            Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                            echo 'disabled';
                                        }
                                    ?>
                                    >
                                        <option value="">Set Priority </option>
                                        <option value="1"
                                            @if (!empty($getEditTicket->priority))
                                                {{ ($getEditTicket->priority == 1) ? 'selected=selected' : '' }}
                                            @else
                                                {{ (old('priority') == 1) ? 'selected=selected' : '' }}
                                                @if (!empty($registerTicketPostData['priority']))
                                                    {{ ($registerTicketPostData['priority'] == 1) ? 'selected=selected' : '' }}
                                                @else
                                                @endif
                                            @endif>High
                                        </option>
                                        <option value="2" 
                                            @if (!empty($getEditTicket->priority))
                                                {{ ($getEditTicket->priority == 2) ? 'selected=selected' : '' }}
                                            @else
                                                {{ (old('priority') == 2) ? 'selected=selected' : '' }}
                                                @if (!empty($registerTicketPostData['priority']))
                                                    {{ ($registerTicketPostData['priority'] == 2) ? 'selected=selected' : '' }}
                                                @else
                                            @endif
                                            @endif
                                            >Low
                                        </option>
                                        <option value="3"
                                            @if (!empty($getEditTicket->priority))
                                                {{ ($getEditTicket->priority == 3) ? 'selected=selected' : '' }}
                                            @else
                                                {{ (old('priority') == 3) ? 'selected=selected' : '' }}
                                                @if (!empty($registerTicketPostData['priority']))
                                                    {{ ($registerTicketPostData['priority'] == 3) ? 'selected=selected' : '' }}
                                                @else
                                                @endif
                                            @endif>Medium
                                        </option>
                                    </select>
                                    <span class="text-danger" id="priorityMsg">{{ $errors->first('priority') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                <label for="inputEmail3" class="col-sm-5 control-label">Set Severity<b class="text-danger">*</b></label>
                                <div class="col-sm-7">
                                    <select class="form-control select2" onchange="setSeverity()" id="severity" name="severity"  
                                    style="border:1px solid #e74a25!important"
                                    <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                            Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                            echo 'disabled';
                                        }
                                    ?>
                                    >
                                        <option value="">Set Severity </option>
                                        <option value="1"
                                            @if (!empty($getEditTicket->severity))
                                                {{ ($getEditTicket->severity == 1) ? 'selected=selected' : '' }}
                                            @else
                                                {{ (old('severity') == 1) ? 'selected=selected' : '' }}
                                                @if (!empty($registerTicketPostData['severity']))
                                                    {{ ($registerTicketPostData['severity'] == 1) ? 'selected=selected' : '' }}
                                                @else
                                                @endif
                                            @endif>Critical 
                                        </option>
                                        <option value="2"
                                            @if (!empty($getEditTicket->severity))
                                                {{ ($getEditTicket->severity == 2) ? 'selected=selected' : '' }}
                                            @else
                                                {{ (old('severity') == 2) ? 'selected=selected' : '' }}
                                                @if (!empty($registerTicketPostData['severity']))
                                                    {{ ($registerTicketPostData['severity'] == 2) ? 'selected=selected' : '' }}
                                                @else
                                                @endif
                                            @endif
                                            >Normal
                                        </option>
                                    </select>
                                    <span class="text-danger" id="severityMsg">{{ $errors->first('severity') }}</span>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group has {{ $errors->has('task_compittion_date') ? 'has-error' : '' }}">
                                <label for="inputEmail3" class="col-sm-6 control-label">Task Compittion Date<b class="text-danger">*</b></label>
                                <div class="col-sm-6">
                                    <input type="text" style="border:1px solid #e74a25!important" id="task_compittion_date" name="task_compittion_date" class="form-control" 
                                    oninput="emptyTaskCompittionDate()"   
                                    <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                        Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                        echo 'disabled';
                                    }
                                    ?>
                                    data-date-format="dd-mm-yyyy" placeholder="Task Compittion Date" value="{{ !empty($taskCompittionDate) ? $taskCompittionDate : old('task_compittion_date') }}{{ !empty($registerTicketPostData['task_compittion_date']) ? $registerTicketPostData['task_compittion_date'] : '' }}" > 
                                    <span class="text-danger" id="taskCompittionDateMsg">{{ $errors->first('task_compittion_date') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                <label for="inputEmail3" class="col-sm-3 control-label">Assing User<b class="text-danger">*</b></label>
                                <div class="col-sm-9" > 
                                <select class="select2 m-b-10 select2-multiple" style="width: 113%;"  onchange="userList()"  
                                multiple  id="project_select"  data-placeholder="Serach Assign User Name" name="user_id[]"
                                <?php 
                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                    Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                    echo 'disabled';
                                }
                                ?>>
                                    <?php
                                        $getUserNameData = [];
                                        $userIdsArr = []; 
                                        $ticketIds = !empty($getEditTicket->id) ? $getEditTicket->id : '';
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
                                            $getProjectAssingData = DB::select('SELECT * FROM `project_assing_user` WHERE is_deleted_status = "N" 
                                                AND project_id = '.$editProjectId.'');
                                            foreach ($getProjectAssingData as $projectUserID) {
                                                $projectUserIdsArr[] = $projectUserID->user_id;
                                            }
    
                                            $projectUserIds = implode(',', $projectUserIdsArr);
                                            $projectUserId = !empty($projectUserIds) ? $projectUserIds : 0;
                                            $getUserData = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = 
                                                "N" AND id IN('.$projectUserId.')');
                                            
                                        }
                                    ?>
                                    @if (!empty($getUserData))
                                        @foreach($getUserData as $user)
                                            <option value="{{$user->id}}"
                                                <?php 
                                                if (in_array($user->id, $userIdsArr)) {
                                                    echo 'selected=selected';
                                                }
                                                ?> >{{$user->username}}
                                            </option>
                                        @endforeach
                                    @endif 
                                </select>
                                <span class="text-danger" id="userIdMsg">{{ $errors->first('user_id') }}</span>
                                @if (!empty($checkUserIdMsg))
                                    <span class="text-danger">{{$checkUserIdMsg}}</span>
                                @endif
                            </div>
                            </div>
                        </div>
                        
                        <?php 
                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                            Session::get('sessionUserData')[0][0]->role_id == 3) {
                        ?>
    
                            <div class="col-md-6">  
                                <div class="form-group has {{ $errors->has('ticket_status_id') ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Ticket Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" onchange="ticketType()"  id="ticket_status_id" name="ticket_status_id" >
                                            <?php     
                    $getTicketStatusById =  
                    DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  ticket_id = '.$getEditTicket->id.' ORDER BY id DESC LIMIT 1');
                        $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                              $getTicketStatusData = DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" AND  
                                                id IN(6,7,8)');
                                            ?>
                                            @if (!empty($getTicketStatusData))
                                                @foreach ($getTicketStatusData as $ticketStatus)  
                                                    <option value="{{$ticketStatus->status}}"
                                                        @if (!empty($ticketStatusId))
                                                            {{ ($ticketStatusId == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                        @else
                                                            {{ (old('ticket_status_id') == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                            @if (!empty($registerTicketPostData['ticket_status_id']))
                                                            {{ ($registerTicketPostData['ticket_status_id'] == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif
                                                        @endif
                                                        >{{$ticketStatus->ticket_status}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="text-danger" id="ticketTypeId">{{ $errors->first('ticket_status_id') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php 
                        } else {
                        ?>
                            <div class="col-md-6">  
                                <div class="form-group has {{ $errors->has('ticket_status_id') ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Ticket Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" onchange="ticketType()"  id="ticket_status_id" name="ticket_status_id" >
                                            <?php  
                                                $ticketStatusIds = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                                                $getTicketStatusById =  
                                                DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  ticket_id = '.$ticketStatusIds.'  
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
                                                            {{ (old('ticket_status_id') == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                            @if (!empty($registerTicketPostData['ticket_status_id']))
                                                            {{ ($registerTicketPostData['ticket_status_id'] == $ticketStatus->status) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif
                                                        @endif
                                                        >{{$ticketStatus->ticket_status}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="text-danger" id="ticketTypeId">{{ $errors->first('ticket_status_id') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php } ?>
                    </div>
                    
                    <?php 
                        //if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) { 
                            $ticketRemark = '';    
                            $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                            $getTicketRemarkData = DB::select('SELECT * FROM ticket_status WHERE is_deleted_status = "N" AND 
                            ticket_id = '.$ticketId.' AND  user_id = '.Session::get('sessionUserData')[0][0]->id.'  ORDER BY id DESC LIMIT 1');
                            if (!empty($getTicketRemarkData[0]->remark)) { 
                                $ticketRemark =  $getTicketRemarkData[0]->remark;   
                            }
                    ?>

                        <div class="row" style="margin-left:-117px;">
                            <div class="col-md-9">
                                <div class="form-group has-feedback ">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Remark</label>
                                    <div class="col-sm-9">
                        <textarea class="form-control"  style="height: 39px;" id="remark" name="remark" rows="4"  placeholder="Remark"><?php echo  $ticketRemark;?></textarea>
                                        <span class="text-danger" id="remarkMsg"></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php
                   // }
                } 
                ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                                @if(empty($getEditTicket->id))
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Save</button>
                                @else
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Update</button>
                                @endif
                            </div>
                            <div class="col-md-3" style="margin-left: -25px;">
                                <button type="button" onclick="resetTicketForm()" class="btn btn-block btn-default"><i class="icon-close"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@include('admin.common.script')
<script type="text/javascript">
    function resetTicketForm() {
        window.location.reload();
    }
</script>

<script>
    <?php 
       if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) { 
    ?>

        function validateform() { 
            var ticketTypeAdmin = $('#ticket_type_id_admin').val();
            var title = $('#title').val();
            var taskCompittionDate = $('#task_compittion_date').val();
            var priority = $('#priority').val();
            var projectId = $('#project_id').val();
            var severity = $('#severity').val();
            var userId = $('#project_select').val();
            if (ticketType=='' || title =='' || ticketTypeAdmin == '' || taskCompittionDate== '' || priority == '' || 
                severity == '' || userId == null || projectId == '') { 
    
                if (ticketTypeAdmin == '') {
                    $('#ticketTypeId').show();
                    $('#ticketTypeId').html("The Ticket Type field is required.");
                }
    
                if (title=='') {
                    $('#titleMsg').show();
                    $('#titleMsg').html("The Ticket field is required.");   
                }
                
                if (projectId=='') {
                    $('#projectIdMsg').show();
                    $('#projectIdMsg').html("Please Select Project Name.");   
                }
    
                if (userId==null) {
                    $('#userIdMsg').show();
                    $('#userIdMsg').html("Please Select Any One Assign User Name.");   
                }
                
                if (taskCompittionDate=='') {
                    $('#taskCompittionDateMsg').show();
                    $('#taskCompittionDateMsg').html("TaskCompittionDate required.");   
                } else {
                    $('#taskCompittionDateMsg').hide();
                }
    
                if (priority=='') {
                    $('#priorityMsg').show();
                    $('#priorityMsg').html("Please Set Priority.");   
                }
    
                if (severity=='') {
                    $('#severityMsg').show();
                    $('#severityMsg').html("Please Set Severity.");   
                }
                return false;
            }  
        } 
    
    <?php 
       } else {
    ?>
    
        function validateform() { 
            var ticketType = $('#ticket_type_id').val();
            var projectId = $('#project_id').val();
            var title = $('#title').val();
            if (ticketType=='' || title =='' || projectId == '') { 
                if (ticketType=='') {
                    $('#ticketTypeId').show();
                    $('#ticketTypeId').html("The Ticket Type field is required.");
                }
                if (title=='') {
                    $('#titleMsg').show();
                    $('#titleMsg').html("The Ticket field is required.");   
                }
                if (projectId=='') {
                    $('#projectIdMsg').show();
                    $('#projectIdMsg').html("Please Select Project Name.");   
                }
                return false;
            }  
        } 
    <?php 
       } 
    ?>
    
    <?php 
        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
    ?>  
                       
    function selectProject() {
        var projectId = $('#project_id').val();
            if (projectId == '') { 
            $('#projectIdMsg').show();
            $('.select2-search-choice').hide();
            } else {
            $('#projectIdMsg').hide(); 
            $.ajax({
                url  :"{{ route('project.projectuser') }}",
                type :'get',
                data : {  
                    projectId: projectId,
                },
                success:function(result) {
                    $('.select2-search-choice').hide();
                    $('#project_select').html(result);
                    $('#select2-choices').hide();
                }
            }); 
        }        
    }

    <?php } else { ?>
        
    function selectProject() {
        var projectId = $('#project_id').val();
        if (projectId == '') { 
            $('#projectIdMsg').show();
        } else {
            $('#projectIdMsg').hide(); 
        }
    }
    
    <?php 
        } 
    ?>
    function ticketType() {
        var ticketType = $('#ticket_type_id').val();
        var ticketTypeAdmin = $('#ticket_type_id_admin').val();
        if (ticketType=='' || ticketTypeAdmin =='') { 
            $('#ticketTypeId').show();
        } else {
           $('#ticketTypeId').hide(); 
        }
    }

    function userList() {
        var userId = $('#project_select').val();
        if (userId=='') { 
            $('#userIdMsg').show();
        } else {
           $('#userIdMsg').hide(); 
        }
    }

    function setPriority() {
        var priority = $('#priority').val();
        if (priority=='') { 
            $('#priorityMsg').show();
        } else {
           $('#priorityMsg').hide(); 
        }
    }

    function setSeverity() {
        var ticketType = $('#severity').val();
        if (severity=='') { 
            $('#severityMsg').show();
        } else {
           $('#severityMsg').hide(); 
        }
    }
    
    function emptyTitle() {
        var title = $('#ticket').val();
        if (title=='') { 
            $('#titleMsg').show();
        } else {
           $('#titleMsg').hide(); 
        }
    }   
    
    function emptyTaskCompittionDate() {
        var taskCompittionDate = $('#task_compittion_date').val();
        if (taskCompittionDate=='') { 
            $('#taskCompittionDateMsg').show();
        } else {
           $('#taskCompittionDateMsg').hide(); 
        }
    }
    
    function deleteAttachment(attachmentId = null,attachment = null) {
        var result = confirm("Are you Want to delete?"); 
        if (result == true) {     
            $.ajax({
                url:"{{ route('attachment.remove') }}",
                type :'get',
                data : {  
                    attachmentId: attachmentId,
                    attachment: attachment,
                },
                success:function(result) {
                    if (result !=  '') {
                        $('#attachment_'+result).hide();    
                    }
                }
            });
        }
    }
</script>