@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
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
                
                    if ($getEditTicket->task_compittion_date == '1111-11-11') {
                        $taskCompittionDate = date('d-m-Y');
                    } else  {
                        $taskCompittionDate = date("d-m-Y", strtotime($getEditTicket->task_compittion_date));
                    } 
                }
                $roleIds = !empty($getClientRole[0]->role_id) ? $getClientRole[0]->role_id : 0;
                
            ?>
            <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body"> 
                        <h4 class="card-title">Edit Ticket</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        <form id="register-form"  name="register_form" method="post" 
                        enctype="multipart/form-data" autocomplete="off">
                            @if(!empty($getEditTicket->id))
                                <input type="hidden" name="ticketId" id="ticketId"  value="{{$getEditTicket->id}}">
                            @endif
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            
                            <input type="hidden" name="ticketNos" id="ticketNos"  value="{{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no:''}}">
                            <input type="hidden" name="ticketTypesId" id="ticketTypesId" 
                            value="{{!empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id:''}}">
                            
                            <input type="hidden" name="roleIds" id="roleIds" value="{{!empty($roleIds) ? $roleIds:0}}">
                            
                            <div class="row">
                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                    Session::get('sessionUserData')[0][0]->role_id != 4) {

                                        $usersId = !empty($getEditTicket->user_id) ? $getEditTicket->user_id : 0;
                                        $getUserName = DB::table('user_master')
                                        ->select('username','role_id')
                                        ->where('id',$usersId)
                                        ->where('is_deleted_status','N')
                                        ->get()
                                        ->toArray();
                                        $clientName =  !empty($getUserName[0]->username) ? $getUserName[0]->username : '';
                                ?>
                                
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-md-1"></div>
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                                    Ticket No : 
                                                </label>
                                                <label for="nputEmail3" class="control-label text-right col-md-2 col-form-label" 
                                                style="color: #6a7a8c">
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
                                            <?php 
                                                $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                                                $checkCreateTicketName = DB::select('SELECT * FROM ticket_status WHERE is_deleted_status = "N" 
                                                AND ticket_id = '.$ticketId.' ORDER BY id ASC LIMIT 1');
                                                if (!empty($checkCreateTicketName[0]->user_id) && $checkCreateTicketName[0]->user_id == 1) {
                                                ?>
                                        Admin :
                                        <?php 
                                        } else {
                                        ?>
                                        Client : 
                                        <?php } ?>
                                        
                                        
                                                  
                                            </label>
                                            <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label" 
                                                style="color: #6a7a8c">
                                                {{!empty($clientName) ?  $clientName : ''}}
                                            </label>
                                        </div>
                                    </div>
                                    
                                        <?php 
                                    } 
                                }
                                ?>
                            </div>

                            <?php /* 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">
                                            Ticket Type :
                                        </label>
                                        <?php 
                                            $getTicketTypeData = 
                                            DB::select('SELECT * FROM ticket_type_master WHERE is_deleted_status = "N" ');
                                        ?>
                                        <div class="col-md-10">
                                            @if (!empty($getTicketTypeData))
                                                @foreach ($getTicketTypeData as $key => $ticketType)
                                                    <label class="col-form-label">
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <?php 
                                                                    $colourTypeArr = [];
                                                                    $colourTypeArr = ['primary','secondary','danger','info','dark']
                                                                ?>
                                                                <input type="radio" class="custom-control-input" 
                                                                id="customControlValidation2_{{$ticketType->id}}" name="ticket_type_id" 
                                                                value="{{$ticketType->id}}" 
                                                                @if (!empty($getEditTicket->ticket_type_id_admin))
                                                                    {{ ($getEditTicket->ticket_type_id_admin == $ticketType->id) ? 'checked=checked' : '' }}
                                                                @else
                                                                    @if (!empty($getEditTicket->ticket_type_id))
                                                                        {{ ($getEditTicket->ticket_type_id == $ticketType->id) ? 'checked=checked' : '' }}
                                                                    @else
                                                                        @if($key==0)
                                                                           {{'checked=checked'}} 
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->ticket_type_id_admin == $ticketType->id) {

                                                                        } else if ($getEditTicket->ticket_type_id == 
                                                                            $ticketType->id) {

                                                                        } else {
                                                                            echo 'disabled';    
                                                                        }
                                                                    }
                                                                ?>>
                                                                <label class="custom-control-label btn-xs btn-rounded btn-{{$colourTypeArr[$key]}}" for="customControlValidation2_{{$ticketType->id}}" style="color: white">{{$ticketType->name}}</label>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>      
                                    
                                    </div> 
                                </div>
                            </div>
                            */?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                            <?php
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                    Session::get('sessionUserData')[0][0]->role_id != 3) {
                                                    echo 'Select';
                                                }
                                            ?> Project : 
                                        </label>
                                        <div class="col-md-8">
                                            <select class="borerred select2 m-b-10 select2" onchange="selectProject()" 
                                                id="project_id" name="project_id" 
                                                style="width: 150%;height:50px;"
                                                <?php
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                        echo 'disabled';
                                                    }
                                                ?>>
                                                <option value="">Select Project</option>
                                                <?php 
                                                    $editProjectId = !empty($getEditTicket->project_id) ? $getEditTicket->project_id : 0;
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
                                            <span class="text-danger" id="projectIdMsg"></span>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-5 col-form-label">Type : </label>
                                        <div class="col-md-7">
                                            <select class="borderred select2 m-b-10 select2" id="ticket_type_id" name="ticket_type_id"  style="width: 100%;height:50px;" 
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
                                                            @if (!empty($getEditTicket->ticket_type_id_admin))
                                                                {{ ($getEditTicket->ticket_type_id_admin == $ticketType->id) ? 'selected=selected' : '' }}
                                                            @else
                                                                @if (!empty($getEditTicket->ticket_type_id))
                                                                    {{ ($getEditTicket->ticket_type_id == $ticketType->id) ? 'selected=selected' : '' }}
                                                                @endif
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
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Title : </label>
                                        <div class="col-md-10">
                                            <input class="form-control borderred" type="text"  placeholder="Title" id="title" name="title" value="{{ !empty($getEditTicket->title) ? $getEditTicket->title :''}}"<?php 
                                            if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                                                echo 'readonly="readonly"';
                                            }
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                echo 'disabled="disabled"';
                                            }
                                            ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php

                            //if (!empty($getEditTicket->description)) { 

                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                    (Session::get('sessionUserData')[0][0]->role_id == 3 || $getUserName[0]->role_id == 4)) {
                                ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 
                                                col-form-label">Description : </label>
                                                <div class="col-md-10" style="height:150px;overflow-y: scroll;">
                                                    <?php echo !empty($getEditTicket->description) ? $getEditTicket->description : ''; ?>
                                                    <span class="text-danger"></span> 
                                                </div>
                                                <div class="adjoined-bottom" style="display: none;">
                                                    <div class="grid-container">
                                                        <div class="grid-width-100" style="padding-left:0px;width: 104%">
                                                            <textarea class="form-control"  id="editor" name="description"
                                                                <?php 
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                    Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        echo 'readonly="readonly"';
                                                                    }
                                                                ?>>
                                                                {{ !empty($getEditTicket->description) ? $getEditTicket->description : ''}}
                                                            </textarea>
                                                            <span class="text-danger"></span> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php 
                                } else {

                                   // if (!empty($getEditTicket->description)) {
                                ?>  
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">
                                                    Description : </label>
                                                <div class="col-md-10">
                                                    <div class="adjoined-bottom">
                                                        <div class="grid-container">
                                                            <div class="grid-width-100" style="padding-left:0px;width: 104%">
                                                                <textarea class="form-control"  id="editor" name="description"
                                                                    <?php 
                                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) 
                                                                        && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                            echo 'readonly="readonly"';
                                                                        }
                                                                    ?>>
                                                                    {{ !empty($getEditTicket->description) ? $getEditTicket->description : ''}}
                                                                </textarea>
                                                                <span class="text-danger"></span> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                  //  }
                                }
                            //}

                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                                
                                if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                               
                                } else { 

                                ?>          
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Attachment : </label>
                                                <div class="col-md-10">
                                                    <input type="file" multiple="multiple" name="uploadFile[]" id="uploadFile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                } 

                            } else {

                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {

                                ?>  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Attachment : </label>
                                                <div class="col-md-10">
                                                    <input  type="file" multiple="multiple" name="uploadFile[]" id="uploadFile">
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
                                $getTicketAttachmentData = DB::select('SELECT * FROM attachment WHERE is_deleted_status = 
                                "N" AND ticket_id = '.$ticketId.'');

                                if (!empty($getTicketAttachmentData)) {
                                ?>
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-10">
                                            <table id="default_order" class="table table-bordered display" style="width:100%;margin-top: -14px !important;margin-bottom: 10px !important;" >
                                                <thead style="color: black;background: #456c4552;">
                                                    <tr>
                                                        <th class="text-left">Sr. No.</th>
                                                        <th>Attachment</th>
                                                        <?php                                                    
                                                            $checkAttAction = DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.' AND 
                                                                role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                            if (!empty($checkAttAction)) {
                                                                echo '<th style="width:50px;">Action</th>';
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
                                                                    $checkAttAction =  DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketId.' AND role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                                    if (!empty($checkAttAction)) {
                                                                ?>     
                                                                        <td style="width: 55px;">
                                                                            <a href="#"    onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->attachment;?>')"  class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i> 
                                                                            </a>
                                                                        </td>
                                                                    <?php 
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

                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4) {
                                ?>  

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">Tag :</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" multiple="" data-placeholder="Serach Tags Name" 
                                                        id="select2-with-tags" <?php 
                                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                echo 'disabled="disabled"';
                                                            }
                                                                    ?>  name="tags_name"  style="width: 265%;height: 36px;">
                                                        <?php 
                                                            $getTagsName = 
                                                            !empty($getEditTicket->tags_name) ? $getEditTicket->tags_name : 0;
                                                            $expoldeArrs = explode(',', $getTagsName);
                                                            $getTagsDatas = DB::select('SELECT * FROM tags WHERE is_deleted_status = "N" ');
                                                                if (!empty($getTagsDatas)) {
                                                                    foreach ($getTagsDatas as $tags) {
                                                                ?>  
                                                                <option value="<?php echo $tags->id; ?>"
                                                                    <?php 
                                                                        if (in_array($tags->id, $expoldeArrs)) {
                                                                            echo 'selected=selected';
                                                                        }   
                                                                    ?>><?php echo $tags->tags_name;?></option>  
                                                                    <?php         
                                                                }  
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php /*<div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                                    Set Priority : 
                                                </label>
                                                <div class="col-md-8" >
                                                <select class="select2 m-b-10 select2"  id="priority" name="priority" style="width: 100%;height:50px;border:1px solid #e74a25!important"
                                                <?php 
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                        Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                        echo 'disabled';
                                                    }
                                                ?>
                                                >
                                                    <!--<option value="">Set Priority </option>-->
                                                    <option value="1"
                                                        @if (!empty($getEditTicket->priority))
                                                            {{ ($getEditTicket->priority == 1) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif>High
                                                    </option>
                                                    <option value="2" 
                                                        @if (!empty($getEditTicket->priority))
                                                            {{ ($getEditTicket->priority == 2) ? 'selected=selected' : '' }}

                                                        @else
                                                        @endif>Low
                                                    </option>
                                                    <option value="3"
                                                        @if (!empty($getEditTicket->priority))
                                                            {{ ($getEditTicket->priority == 3) ? 'selected=selected' : '' }}

                                                        @else
                                                        @endif>Medium
                                                    </option>
                                                </select>
                                                <span class="text-danger" id="priorityMsg"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                                    Set Severity : 
                                                </label>
                                                <div class="col-md-8">
                                                <select class="select2 m-b-10 select2" id="severity" 
                                                name="severity"  style="width: 100%;height:50px;border:1px solid #e74a25!important"
                                                <?php 
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                        Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                        echo 'disabled';
                                                    }
                                                ?>
                                                >
                                                    <!--<option value="">Set Severity </option>-->
                                                    <option value="1"
                                                        @if (!empty($getEditTicket->severity))
                                                            {{ ($getEditTicket->severity == 1) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif
                                                        >Critical 
                                                    </option>
                                                    <option value="2"
                                                        @if (!empty($getEditTicket->severity))
                                                            {{ ($getEditTicket->severity == 2) ? 'selected=selected' : '' }}
                                                        @else
                                                        @endif
                                                        >Normal
                                                    </option>
                                                </select>
                                                <span class="text-danger" id="severityMsg"></span>
                                                </div>
                                            </div>
                                        </div> 
                                        */
                                        ?>
                                        
                                    </div>
                
                                    <?php /*
                                    <div class="row" style="margin-left:-37px;">
                                        <div class="col-md-7">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                                    Priority : 
                                                </label>
                                                <div class="col-md-8">
                                                    <label class="col-form-label">
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" 
                                                                id="priority1" name="priority" value="1"
                                                                @if (!empty($getEditTicket->priority))
                                                                    {{ ($getEditTicket->priority == 1) ? 'checked=checked' : '' }}
                                                                @endif

                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->priority == 1) {
                                                                        } else {
                                                                            echo 'disabled';
                                                                        }
                                                                    }
                                                                ?>>
                                                                <label class="custom-control-label btn-xs btn-rounded btn-danger" style="color: white" for="priority1">High</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" 
                                                                id="priority2" name="priority" value="2" 
                                                                @if (!empty($getEditTicket->priority))
                                                                    {{ ($getEditTicket->priority == 2) ? 'checked=checked' : '' }}
                                                                @endif
                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->priority == 2) {
                                                                        } else {
                                                                            echo 'disabled';
                                                                        }
                                                                    }
                                                                ?>
                                                                >
                                                                <label class="custom-control-label btn-xs btn-rounded btn-warning" style="color: white" for="priority2">Low</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" 
                                                                id="priority3" name="priority" value="3" 
                                                                @if (!empty($getEditTicket->priority))
                                                                    {{ ($getEditTicket->priority == 3) ? 'checked=checked' : '' }}
                                                                @endif
                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->priority == 3) { 
                                                                        } else {
                                                                            echo 'disabled';
                                                                        }
                                                                    }
                                                                ?>>
                                                                <label class="custom-control-label btn-xs btn-rounded btn-success" style="color: white" for="priority3">Medium</label>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">
                                                    Severity : 
                                                </label>
                                                <div class="col-md-8">
                                                    <label class="col-form-label">
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" 
                                                                id="severity1" name="severity" value="1" 
                                                                @if (!empty($getEditTicket->severity))
                                                                    {{ ($getEditTicket->severity == 1) ? 'checked=checked' : '' }}
                                                                @endif
                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->severity == 1) {
                                                                        } else {
                                                                            echo 'disabled';
                                                                        }
                                                                    }
                                                                ?>>
                                                                <label class="custom-control-label btn-xs btn-rounded btn-danger" style="color: white" for="severity1">
                                                                    Critical
                                                                </label> 
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" 
                                                                id="severity2" name="severity" value="2"  
                                                                @if (!empty($getEditTicket->severity))
                                                                    {{ ($getEditTicket->severity == 2) ? 'checked=checked' : '' }}
                                                                @endif
                                                                <?php
                                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                        Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                        if ($getEditTicket->severity == 2) {
                                                                        } else {
                                                                            echo 'disabled';
                                                                        }
                                                                    }
                                                                ?>>
                                                                <label class="custom-control-label btn-xs btn-rounded btn-success" style="color: white" for="severity2">Normal</label>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>*/?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label"> Compittion Date : </label>
                                                <div class="col-md-8">
                                                    <input type="text"  id="task_compittion_date" name="task_compittion_date" 
                                                    class="form-control borderred"    
                                                    <?php 
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                        Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                        echo 'disabled';
                                                    }
                                                    ?>
                                                    data-date-format="dd-mm-yyyy" placeholder="Task Compittion Date" value="{{ !empty($taskCompittionDate) ? $taskCompittionDate : date('d-m-Y')}}" > 
                                                    <span class="text-danger" id="taskCompittionDateMsg"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <?php 
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                Session::get('sessionUserData')[0][0]->role_id == 3) {
                                        ?>
                                                <div class="col-md-6">  
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label">Ticket Status : </label>
                                                        <div class="col-md-8">
                                                            <select class="form-control select2" style="width: 100%;height:50px;border:1px solid #e74a25!important"  
                                                                id="ticket_status_id" name="ticket_status_id" >
                                                                <?php
                                                                    $getTicketStatusById = DB::select('SELECT * FROM `ticket_status`  
                                                                    WHERE is_deleted_status = "N" AND  ticket_id = '.$getEditTicket->id.' 
                                                                    ORDER BY id DESC LIMIT 1');
                                                                    
                                                                    $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? 
                                                                    $getTicketStatusById[0]->ticket_status_id : 0;
                                                                    $getTicketStatusData = DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" AND   status IN(2,3,4)');
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
                                                    </div>
                                                </div>
                        
                                        <?php 
                                            } else {
                                        ?>
                                                <div class="col-md-6">  
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="control-label text-right col-md-4 col-form-label"> Ticket Status : </label>
                                                        <div class="col-md-8">
                                                            <select class="select2 m-b-10 select2" style="width: 100%;height:50px;border:1px solid #e74a25!important"  
                                                            id="ticket_status_id" name="ticket_status_id" >
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
                                                                            @endif
                                                                            >{{$ticketStatus->ticket_status}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php 
                                        } 
                                        ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Asign User : </label>
                                                <div class="col-md-10"> 
                                                    <select class="select2 m-b-10 select2-multiple" multiple style="width: 100%;height:50px;border:1px solid #e74a25!important" onchange="userList()"  
                                                        id="project_select"  data-placeholder="Serach Assign User Name" 
                                                        name="user_id[]" <?php if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                Session::get('sessionUserData')[0][0]->role_id == 3) 
                                                                        { echo 'disabled';}?>>
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
                                                    <span class="text-danger" id="userIdMsg"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <?php /*
                                        <div class="row">
                                        <?php 
                                            $colourStatusArr = ['primary','warning','success','dark','danger','info'];
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id == 3) {

                                        ?>
                                            
                                            <div class="col-md-12">  
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Ticket Status : </label>
                                                    <div class="col-md-10">
                                                        <?php     
                                                            $getTicketStatusById = DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  ticket_id = '.$getEditTicket->id.' ORDER BY id DESC LIMIT 1');
                                                            $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? 
                                                            $getTicketStatusById[0]->ticket_status_id : 0;
                                                            $getTicketStatusData = DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" AND   status IN(2,3,4)');
                                                        ?>
                                                        @if (!empty($getTicketStatusData))
                                                            @foreach ($getTicketStatusData as $key => $ticketStatus)  
                                                                <label class="col-form-label">
                                                                    <div class="form-check form-check-inline">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" 
                                                                            id="ticket_status_{{$ticketStatus->status}}" name="ticket_status" 
                                                                            value="{{$ticketStatus->status}}" 

                                                                            @if (!empty($ticketStatusId))
                                                                                {{ ($ticketStatusId == $ticketStatus->status) ? 'checked=checked' : '' }}
                                                                            @else
                                                                            @endif>
                                                                            <label 
                                                                            class="custom-control-label btn-xs btn-rounded btn-{{$ticketStatus->status_colour}}" 
                                                                            for="ticket_status_{{$ticketStatus->status}}">
                                                                                {{$ticketStatus->ticket_status}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                     
                                        <?php 
                                        } else {
                                        ?>
                                            
                                            <div class="col-md-12">  
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label"> Ticket Status : </label>
                                                    <div class="col-md-10">
                                                        <?php  
                                                            $ticketStatusIds = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                                                            $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  ticket_id = '.$ticketStatusIds.' ORDER BY id DESC LIMIT 1'); 
                                                            $ticketStatusId =  
                                                            !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                            $getTicketStatusData = DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" ');
                                                        ?>
                                                        @if (!empty($getTicketStatusData))
                                                            @foreach ($getTicketStatusData as $key => $ticketStatus)  

                                                                <label class="col-form-label">
                                                                    <div class="form-check form-check-inline">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" class="custom-control-input" 
                                                                            id="ticket_status_{{$ticketStatus->status}}" name="ticket_status" 
                                                                            value="{{$ticketStatus->status}}" 
                                                                            <?php
                                                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                                                    Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                                    echo 'disabled';
                                                                                }
                                                                            ?>
                                                                            @if (!empty($ticketStatusId))
                                                                                {{ ($ticketStatusId == $ticketStatus->status) ? 'checked=checked' : '' }}
                                                                            @else
                                                                            @endif>
                                                                            <label class="custom-control-label btn-xs btn-rounded btn-{{$colourStatusArr[$key]}}" for="ticket_status_{{$ticketStatus->status}}">
                                                                                {{$ticketStatus->ticket_status}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        <?php 
                                        } 
                                        ?>
                                        </div>*/
                                    ?>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row has-feedback">
                                                <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">
                                                    Remark : 
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control borderred_border" id="remark" name="remark" placeholder="Remark" value="">
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 

                                <?php 
                                } 
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2"></label>
                                        <div class="col-md-10">
                                            <button type="submit" id="addTicket" class="btn btn-success">Save</button>
                                            
                                            @if(empty($getEditTicket->id))
                                                <button type="button" class="btn btn-dark" 
                                                onclick="resetTicketForm()">Cancel</button>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xlg-4 col-md-4">
                <div class="card" style="height: 500px;overflow-y: scroll;">
                    <div class="tab-content" id="pills-tabContent" >
                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            <div class="card-body">
                                <h4 class="card-title">Comments</h4>
                                <div class="profiletimeline m-t-0" style="margin:1px 10px 0px 30px;">
                                    <?php 
                                        $ticketRemark = '';    
                                        $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                                        $getTicketRemarkData = DB::select('SELECT * FROM ticket_status WHERE is_deleted_status = "N" AND  
                                        ticket_id = '.$ticketId.'   ORDER BY id DESC');
                                    ?>
                                    @if (!empty($getTicketRemarkData))
                                        @foreach ($getTicketRemarkData as $key => $remarkData)  
                                            <div class="sl-item">
                                                @if(!empty($remarkData->remark))
                                                    <div class="sl-left">
                                                        <img src="{{ URL::asset('public/admin/theme2/assets/images/users/1.jpg')}}" class="rounded-circle" /> 
                                                    </div>
                                                    <div class="sl-right">
                                                        <div>
                                                            <a href="#" class="link">
                                                                <?php 
                                                                    $getUserNameRemark = 
                                                                    DB::select('SELECT username FROM user_master WHERE is_deleted_status = "N" AND  
                                                                        id = '.$remarkData->user_id.'');
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="chat-windows"></div>
@include('admin.common.script2')

    <script type="text/javascript">
    
        $("#addTicket").click(function (e) {
            
            e.preventDefault();
            var _token = $('#_token').val();
            var projectId = $('#project_id').val();
            var ticketTypeId = $('#ticket_type_id').val();
            var ticketTypeIdAdmin = $('#ticketTypesId').val();
            var roleIds = $('#roleIds').val();
            var title = $('#title').val();
            var ticketId = $('#ticketId').val();
            var priority = $('#priority').val();
            var severity = $('#severity').val();
            var task_compittion_date = $('#task_compittion_date').val();
            var project_select = $('#project_select').val();
            var selectWithTags = $('#select2-with-tags').val();
            var remark = $('#remark').val();
            var ticketStatusId = $('#ticket_status_id').val();
            var description = CKEDITOR.instances.editor.getData();
/*
            if ((projectId=='' || projectId==null) || (ticketTypeId =='' || ticketTypeId==null) 
                || title == '' || (priority == ''|| priority==null) || (severity == '' || severity==null) || 
                (task_compittion_date =='' || task_compittion_date ==null) || 
                (project_select == '' || project_select == null) ||
                (ticketStatusId =='' || ticketStatusId ==null)) */
                
            if (
                (projectId=='' || projectId==null) || 
                (ticketTypeId =='' || ticketTypeId==null) || 
                title == '' || 
                (task_compittion_date =='' || task_compittion_date ==null) || 
                (project_select == '' || project_select == null) ||
                (selectWithTags == '' || selectWithTags == null) ||
                (ticketStatusId =='' || ticketStatusId ==null)

            )
                
                
            { 
                
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
                
                
                if (selectWithTags == ''|| selectWithTags == null) {
                    $('#priorityMsg').show();
                    $('#priorityMsg').html("Please Select Tags Name");
                } else {
                    $('#priorityMsg').hide();
                }

/*                if (priority == ''|| priority==null) {
                    $('#priorityMsg').show();
                    $('#priorityMsg').html("Please Select Priority.");
                } else {
                    $('#priorityMsg').hide();
                }

                if (severity == ''|| severity==null) {
                    $('#severityMsg').show();
                    $('#severityMsg').html("Please Select Severity.");
                } else {
                    $('#severityMsg').hide();
                }*/

                if (task_compittion_date == ''|| task_compittion_date==null) {
                    $('#taskCompittionDateMsg').show();
                    $('#taskCompittionDateMsg').html("TaskCompittionDate required.");
                } else {
                    $('#taskCompittionDateMsg').hide();
                }

                if (project_select == ''|| project_select==null) {
                    $('#userIdMsg').show();
                    $('#userIdMsg').html("Please Select User Name.");
                } else {
                    $('#userIdMsg').hide();
                }

            } else {
                var data = new FormData();
                var description = CKEDITOR.instances.editor.getData();

                <?php 
                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                    if (!empty($getUserName[0]->role_id) && $getUserName[0]->role_id == 4) {
                    } else {
                ?> 
                        var attachment = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
                        var files =$('input[type=file]')[0].files;
                        for(var i=0;i<files.length;i++) {
                            data.append('attachment[]',files[i],files[i]['name']);
                        }
                <?php 
                    }
                }
                ?>
                
                $("#addTicket").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#addTicket").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');

                data.append("_token", _token);
                data.append("ticket_type_id", ticketTypeId);
                data.append("ticket_type_id_admin", ticketTypeIdAdmin);
                data.append("title", title);
                data.append("description", description);
                data.append("project_id", projectId);
                data.append("priority", priority);
                data.append("ticketId", ticketId);
                data.append("severity", severity);
                data.append("task_compittion_date", task_compittion_date);
                data.append("project_select", project_select);
                data.append("selectWithTags", selectWithTags);
                data.append("remark", remark);
                data.append("ticket_status_id", ticketStatusId);
                data.append("roleIds", roleIds);
                
                if (ticketId == undefined) {
                    $.ajax({
                        url: "{{ route('angularaddticket.add') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            window.location.href = "{{route('dashboard') }}";
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
                            window.location.href = "{{route('dashboard') }}";
                        }
                    });
                }
            }
        });
        
        function resetTicketForm() {

            $('#userIdMsg').hide();
            $('#projectIdMsg').hide();
            $('#ticketTypeId').hide();
            $('#titleMsg').hide();
            $('#priorityMsg').hide();
            $('#severityMsg').hide();
            $('#taskCompittionDateMsg').hide();
            
            $('#title').val('');
            $('#uploadFile').val('');
            $('#task_compittion_date').val('');
            
            $('#ticket_type_id').val(['0']);
            $('#ticket_type_id').trigger('change');

            $('#project_id').val(['0']);
            $('#project_id').trigger('change');

            $('#priority').val(['0']);
            $('#priority').trigger('change');

            $('#severity').val(['0']);
            $('#severity').trigger('change');
        }
        
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

        function userList() {
            var userId = $('#project_select').val();
            if (userId=='') { 
                $('#userIdMsg').show();
            } else {
               $('#userIdMsg').hide(); 
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




