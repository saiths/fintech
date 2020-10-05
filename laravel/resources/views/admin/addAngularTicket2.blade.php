@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            @if(!empty($getTicketDataByID))
                @foreach ($getTicketDataByID as $getEditTicket)
                @endforeach
            @endif
            <?php 
                $readonly = '';
                $disabled = '';
                if (!empty($getEditTicket->id)) {
                    $checkStatus = DB::select('SELECT * FROM ticket_status  WHERE is_deleted_status = "N" AND 
                    ticket_id = '.$getEditTicket->id.' ORDER BY id DESC LIMIT 1 ');
                    
                    if (!empty($checkStatus[0]->ticket_status_id)) {
                        if ($checkStatus[0]->ticket_status_id != 1) {
                            $readonly =  'readonly';
                            $disabled =  'disabled=disabled';
                            $lastStatus = $checkStatus[0]->ticket_status_id;
                        }     
                    }
                }
                $taskCompittionDate = '';
                if (!empty($getEditTicket->task_compittion_date)) {
                    if ($getEditTicket->task_compittion_date == '1111-11-11') {
                        $taskCompittionDate = '1111-11-11';
                    } else  {
                        $taskCompittionDate = date("d-m-Y", strtotime($getEditTicket->task_compittion_date));
                    } 
                }
                
                if (!empty($getEditTicket->priority)) {
                    $priority = !empty($getEditTicket->priority) ? $getEditTicket->priority : 0;
                }

                if (!empty($getEditTicket->severity)) {
                    $severity = !empty($getEditTicket->severity) ? $getEditTicket->severity : 0;
                }
            ?>
            @if(!empty($getEditTicket->id))
            <div class="col-lg-7 col-xlg-7 col-md-7">
            @else
            <div class="col-md-12">
            @endif
                <div class="card">
                    <div class="card-body">
                    @if(empty($getEditTicket->id))
                        <h4 class="card-title">Add Ticket</h4>
                    @else
                        <h4 class="card-title">Edit Ticket</h4>
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
                    <form id="register-form"  name="register_form" method="post" enctype="multipart/form-data" autocomplete="off">
                        @if(!empty($getEditTicket->id))
                            <input type="hidden" name="ticketId" id="ticketId"  value="{{$getEditTicket->id}}">
                        @endif
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        
                        @if(!empty($getEditTicket->ticket_status_id))
                            
                            <input type="hidden" name="ticket_status_id_client" 
                            id="ticket_status_id_client" value="{{!empty($lastStatus) ? $lastStatus:1}}">
                        @else
                            <input type="hidden" name="ticket_status_id_client" id="ticket_status_id_client" value="1">
                        @endif
                        
                        
                        <input type="hidden" name="task_compittion_date" id="task_compittion_date" 
                            value="{{!empty($taskCompittionDate) ? $taskCompittionDate:'1111-11-11'}}">
                        
                        <input type="hidden" name="severity" id="severityClient" value="{{!empty($severity) ? $severity:0}}">
                        <input type="hidden" name="priority" id="priorityClient" value="{{!empty($priority) ? $priority:0}}">
                        
                        <?php
                            if ($readonly == 'readonly') {
                        ?>
                        
                            <input type="hidden" name="project_id" 
                            id="project_ids" value="{{!empty($getEditTicket->project_id) ? $getEditTicket->project_id:0}}">
                            
                            <input type="hidden" name="ticket_type_id" id="ticket_type_ids" 
                            value="{{!empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id:0}}">
                            <?php 
                            } 
                        ?>
                        @if(!empty($getEditTicket->id))
                            <div class="row">
                            <?php 
                                $usersId = !empty($getEditTicket->user_id) ? $getEditTicket->user_id : 0;
                                $getUserName = DB::table('user_master')
                                    ->select('username','role_id')
                                    ->where('id',$usersId)
                                    ->where('is_deleted_status','N')
                                    ->get()
                                    ->toArray();
                                    $clientName =  
                                    !empty($getUserName[0]->username) ? $getUserName[0]->username : '';
                            ?>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <label for="inputEmail3" 
                                        class="control-label text-right 
                                        col-md-3 col-form-label">
                                        Ticket No : 
                                    </label>
                                    <label for="nputEmail3" 
                                    class="control-label text-right col-md-2 col-form-label" style="color: #6a7a8c">
                                        {{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no:''}}
                                    </label>
                                </div>
                            </div>
                            <?php 
                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="control-label text-right col-md-5 col-form-label">
                                                Name :  
                                            </label>
                                            <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label" 
                                                style="color: #6a7a8c">
                                                {{!empty($clientName) ?  $clientName : ''}}
                                            </label>
                                        </div>
                                    </div>
                            <?php 
                                } 
                            ?>
                        </div>
                        @endif
                        
                        <div class="row">
                            @if(!empty($getEditTicket->id))
                            <div class="col-md-6">
                            @else
                            <div class="col-md-4">
                            @endif
                                <div class="form-group row">
                                    @if(!empty($getEditTicket->id))
                                    <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                    @else
                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                    @endif
                                    Select Project : </label>
                                    @if(!empty($getEditTicket->id))
                                    <div class="col-md-8">
                                    @else
                                    <div class="col-md-9">
                                    @endif
                                        <select class="borderred select2 m-b-10 select2" id="project_id" 
                                            name="project_id" 
                                            @if(!empty($getEditTicket->id))
                                                style="width: 150%;height:50px;"
                                            @else
                                                style="width: 100%;height:50px;"
                                            @endif
                                            {{$disabled}}>
                                            <!--<option value="">Select Project</option>-->
                                            <?php 
                                                $projectIdArr = [];
                                                $getClientProjectIdData =  DB::select('SELECT * FROM client_project_master WHERE is_deleted_status = "N" AND 
                                                    client_id = '.Session::get('sessionUserData')[0][0]->client_id.' ');
                                                if (!empty($getClientProjectIdData)) {
                                                    foreach ($getClientProjectIdData as $projectId) {
                                                        $projectIdArr[] = $projectId->project_id;
                                                    }                                                
                                                }
                                                $projectIDs = implode(',', $projectIdArr);
                                                $projectIDs = !empty($projectIDs) ? $projectIDs : 0;
                                                $editProjectId = !empty($getEditTicket->project_id) ? $getEditTicket->project_id : 0;
                                                $getProjectData = DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N" AND id  IN ('.$projectIDs.')'); 
                                                if (!empty($getProjectData)) {
                                                    foreach ($getProjectData as $project) {
                                                        echo '<option value="'.$project->id.'"';
                                                        if ($editProjectId == $project->id)  {
                                                            echo  'selected="selected"';
                                                        }
                                                        echo  '>'.$project->name.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span class="text-danger" id="projectIdMsg"></span>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($getEditTicket->id))
                            <div class="col-md-6">
                            @else
                            <div class="col-md-3">
                            @endif    
                                <div class="form-group row">
                                    @if(!empty($getEditTicket->id))
                                    <label for="inputEmail3" class="control-label text-right col-md-5 col-form-label">Type : </label>
                                    @else
                                    <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">Ticket Type : </label>
                                    @endif
                                    @if(!empty($getEditTicket->id))
                                    <div class="col-md-7">
                                    @else
                                    <div class="col-md-8">
                                    @endif
                                        <select class="borderred select2 m-b-10 select2" id="ticket_type_id"  name="ticket_type_id"  
                                        style="width: 100%;height:50px;" {{$disabled}} >
                                            <!--<option value="">Select Ticket Type</option>-->
                                            <?php 
                                                $getTicketTypeData = DB::select('SELECT * FROM ticket_type_master WHERE is_deleted_status = "N" ');
                                            ?>
                                            @if (!empty($getTicketTypeData))
                                                @foreach ($getTicketTypeData as $ticketType)  
                                                    <option value="{{$ticketType->id}}"
                                                        @if (!empty($getEditTicket->ticket_type_id))
                                                            {{ ($getEditTicket->ticket_type_id == $ticketType->id) ? 'selected=selected' : '' }}
                                                        @endif
                                                        >
                                                        {{$ticketType->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="text-danger" id="ticketTypeId"></span>
                                    </div>
                                </div>
                            </div>
                            
                            @if(empty($getEditTicket->id))
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Title : </label>
                                    <div class="col-md-10">
                                        <input class="form-control borderred" type="text"  placeholder="Title" id="title" name="title" value="{{ !empty($getEditTicket->title) ? $getEditTicket->title :''}}">
                                        <span class="text-danger" id="titleMsg"></span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                        
                        @if(!empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Title : </label>
                                    <div class="col-md-10">
                                        <input class="form-control borderred" type="text"  placeholder="Title" id="title" name="title" value="{{ !empty($getEditTicket->title) ? $getEditTicket->title :''}}" {{$readonly}}>
                                        <span class="text-danger" id="titleMsg"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Description : </label>
                                    <div class="col-md-10">
                                        <div class="adjoined-bottom">
                                            <div class="grid-container">
                                                <div class="grid-width-100" style="padding-left:0px;width: 104%">
                                                    <textarea class="form-control"  id="editor" name="description" {{$readonly}}>{{ !empty($getEditTicket->description) ? $getEditTicket->description : ''}}
                                                    </textarea>
                                                    <span class="text-danger"></span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(empty($getEditTicket->id))
                        <div class="row">
                            <div class="form-group row">
                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Description : </label>
                                <div class="col-md-10">
                                    <div class="adjoined-bottom">
                                        <div class="grid-container">
                                            <div class="grid-width-100" style="padding-left:0px;width: 208%;">
                                                <textarea class="form-control"  id="editor" name="description">{{ !empty($getEditTicket->description) ? $getEditTicket->description : ''}}
                                                </textarea>
                                                <span class="text-danger"></span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($getEditTicket->id))
                        <?php 
                            if ($readonly != 'readonly') {
                        ?>      
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row has-feedback">
                                            <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Attachment : </label>
                                            <div class="col-md-10">
                                                <input  type="file" multiple="multiple" name="uploadFile[]" id="uploadFile">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            } 
                        ?>
                        @endif
                        
                        @if(empty($getEditTicket->id))
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Attachment : </label>
                                        <div class="col-md-9">
                                            <input  type="file" multiple="multiple" name="uploadFile[]" id="uploadFile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <?php
                            $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                            $getTicketAttachmentData = DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" 
                                AND ticket_id = '.$ticketId.'');
                            if (!empty($getTicketAttachmentData)) {
                            ?>
                                <div class="row">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-10">
                                        <table id="default_order" class="table table-bordered display" 
                                                style="width:100%;margin-top: -14px !important;margin-bottom: 10px !important;" >
                                            <thead style="color: black;background: #456c4552;">
                                                <tr>
                                                    <th class="text-left">Sr. No.</th>
                                                    <th>Attachment</th>
                                                    <?php                                                    
                                                        $checkAttAction = DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.' AND 
                                                      role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                        if (!empty($checkAttAction)) {
                                                            if ($readonly != 'readonly') {
                                                                echo '<th style="width:50px;">Action</th>';
                                                            }
                                                        }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i = 1;
                                                    foreach ($getTicketAttachmentData as $attachment) {
                                                        $uploadPath = url('laravel/public/attachment');
                                                        $ticketNoStr = $getEditTicket->ticket_no.'_';
                                                        $finalFileName = str_replace($ticketNoStr, '', $attachment->attachment);
                                                ?>
                                                        <tr id="attachment_<?php echo $attachment->id; ?>">
                                                            <td class="text-left"><?php echo $i; ?></td>
                                                            <td> 
                                                                <a href="<?php echo  $uploadPath.'/'.$attachment->attachment ?>" 
                                                                    target="_blank" download="<?php echo $finalFileName; ?>" style="color: black;"><?php echo $finalFileName;?>
                                                                </a>
                                                            </td>
                                                            
                                                            <?php
                                                                $checkAttAction =  
                                                                DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND  
                                                                ticket_id = '.$ticketId.' AND role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                                if (!empty($checkAttAction)) {
                                                                    if ($readonly != 'readonly') {
                                                                ?>     
                                                                        <td style="width: 55px;">
                                                                            <a href="#"    onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->attachment;?>')"  class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i> 
                                                                            </a>
                                                                        </td>
                                                                        <?php 
                                                                    }
                                                                }
                                                            ?>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                        <?php 
                            }
                        ?>
                        
                        @if(empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Remark :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control borderred_border" style="width: 380%;" id="remark" name="remark" placeholder="Remark" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Remark :</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control borderred_border" id="remark" name="remark" placeholder="Remark" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-9">
                                <button type="submit" id="addTicket" class="btn btn-success">Save</button>
                                @if(empty($getEditTicket->id))
                                    <button type="button" id="cancelId" class="btn btn-dark" onclick="resetTicketForm()">Cancel</button>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        @if(empty($getEditTicket->id))
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label"></label>
                                    <div class="col-md-9">
                                        <button type="submit" id="addTicket" class="btn btn-success">Save</button>
                                        @if(empty($getEditTicket->id))
                                            <button type="button" id="cancelId" class="btn btn-dark" onclick="resetTicketForm()">Cancel</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div id="image_preview"></div>
                    
                    </form>
                </div>
                </div>
            </div>
            
            
            <?php 
                $ticketRemark = '';    
                $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                $getTicketRemarkData = DB::select('SELECT * FROM ticket_status WHERE is_deleted_status = "N" AND 
                ticket_id = '.$ticketId.' AND (user_id = 1 OR user_id = "'.Session::get('sessionUserData')[0][0]->id.'")   
                ORDER BY id DESC');
            ?>
            @if (!empty($getTicketRemarkData))
            <div class="col-lg-5 col-xlg-5 col-md-5">
                <div class="card" style="height: 500px;overflow-y: scroll;">
                    <div class="tab-content" id="pills-tabContent" >
                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            <div class="card-body">
                                <h4 class="card-title">Comments</h4>
                                <div class="profiletimeline m-t-0" style="margin:1px 10px 0px 30px;">
                                    @foreach ($getTicketRemarkData as $key => $remarkData)  
                                        <div class="sl-item">
                                            @if(!empty($remarkData->remark))
                                                <div class="sl-left"> 
                                                    <img src="{{ URL::asset('public/admin/theme2/assets/images/users/1.jpg')}}" alt="user" 
                                                    class="rounded-circle" /> 
                                                </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <a href="#" class="link">
                                                            <?php 
                                                                $getUserNameRemark = DB::select('SELECT username FROM user_master WHERE is_deleted_status = "N" AND  id = '.$remarkData->user_id.'');
                                                            ?>
                                                            {{$getUserNameRemark[0]->username}}
                                                        </a> 
                                                        <span class="sl-date">
                                                            <?php 
                                                                $datePart = explode(' ', $remarkData->created_at);
                                                            ?>
                                                            {{date("d-M-Y", strtotime($datePart[0]))}} {{$datePart[1]}} {{$datePart[2]}}
                                                        </span>
                                                        <p> 
                                                            {{$remarkData->remark}}
                                                        </p>
                                                        <!-- <div class="row">
                                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="http://localhost/support/public/admin/theme2/assets/images/users/2.jpg" class="img-fluid rounded" /></div>
                                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="http://localhost/support/public/admin/theme2/assets/images/users/2.jpg" class="img-fluid rounded" /></div>
                                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="http://localhost/support/public/admin/theme2/assets/images/users/2.jpg" class="img-fluid rounded" /></div>
                                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="http://localhost/support/public/admin/theme2/assets/images/users/2.jpg" class="img-fluid rounded" /></div>
                                                        </div>!-->
                                                        <!-- <div class="like-comm"> 
                                                            <a href="javascript:void(0)" class="link m-r-10">2 comment</a> 
                                                            <a href="javascript:void(0)" class="link m-r-10">
                                                                <i class="fa fa-heart text-danger"></i> 
                                                            5 Love</a> 
                                                        </div> -->
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
<div class="chat-windows"></div>
@include('admin.common.script2')

    <script>
        $("#addTicket").click(function (e) {
            e.preventDefault();
            var _token = $('#_token').val();
            <?php
                if ($readonly == 'readonly') {
            ?>
                var ticketTypeId = $('#ticket_type_ids').val();
                var projectId = $('#project_ids').val();
                
            <?php 
                } else {
            ?>
                var ticketTypeId = $('#ticket_type_id').val();
                var projectId = $('#project_id').val();
            <?php 
                }
            ?>
            var title = $('#title').val();
            var ticketId = $('#ticketId').val();
            var task_compittion_date = $('#task_compittion_date').val();
            var priority = $('#priorityClient').val();
            var severity = $('#severityClient').val();
            var remark = $('#remark').val();
            var ticketStatusId = $('#ticket_status_id_client').val();
            
            if ((projectId=='' || projectId==null) || (ticketTypeId =='' || ticketTypeId==null)  || title == '') { 
    
                if (projectId == '' || projectId==null) {
                    $('#projectIdMsg').show();
                    $('#projectIdMsg').html("Please Select Project Name.");
                } else {
                    $('#projectIdMsg').hide();
                }

                if (ticketTypeId == '' || ticketTypeId==null) {
                    $('#ticketTypeId').show();
                    $('#ticketTypeId').html("Please Select Ticket Type.");
                } else {
                    $('#ticketTypeId').hide();
                }
                
                if (title == '') {
                    $('#titleMsg').show();
                    $('#titleMsg').html("The Ticket field is required.");
                } else {
                    $('#titleMsg').hide();
                }
                
            } else {
            
                var description = CKEDITOR.instances.editor.getData();
                var data = new FormData();
                <?php
                    if ($readonly != 'readonly') {
                ?>
                        var attachment = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
                        var files =$('input[type=file]')[0].files;
                        for(var i=0;i<files.length;i++) {
                            data.append('attachment[]',files[i],files[i]['name']);
                        }
                    <?php 
                    } 
                ?>
                
                data.append("_token", _token);
                data.append("ticket_type_id", ticketTypeId);
                data.append("title", title);
                data.append("description", description);
                data.append("project_id", projectId);
                data.append("ticketId", ticketId);
                data.append("task_compittion_date", task_compittion_date);
                data.append("priority", priority);
                data.append("severity", severity);
                
                data.append("remark", remark);
                data.append("ticket_status_id", ticketStatusId);
                
                $("#addTicket").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#addTicket").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                
                if (ticketId == undefined) {
                    $.ajax({
                        url: "{{ route('angularaddticket.add') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            window.location.href = "{{route('aticket') }}";
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('angularaddticket.edit') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            window.location.href = "{{route('aticket') }}";
                        }
                    });
                }
            }
        });
        
        function resetTicketForm() {
            $('#projectIdMsg').hide();
            $('#ticketTypeId').hide();
            $('#titleMsg').hide();
            $('#title').val('');
            $('#attachment').val('');
            $('#project_id').val(['0']);
            $('#project_id').trigger('change');
            $('#ticket_type_id').val(['0']);
            $('#ticket_type_id').trigger('change');
            $('#uploadFile').val('');
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
                            toastr.success(
                                'Attachment has been deleted.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                            $('#attachment_'+result).remove();    
                        }
                    }
                });
            }
        }
    </script>
    </body>
</html>




