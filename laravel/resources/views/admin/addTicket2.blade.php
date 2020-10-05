@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
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
                    <div class="card-body">
                        <?php 
                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4) {
                        ?>
                            <h4 class="card-title"> Add Ticket</h4>
                        <?php 
                            } else {
                            echo '<h4 class="card-title"> Create Ticket</h4>';

                        } ?>
                        
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                            .borderred_border {
                                border-radius:4px;
                            }
                            #role_id {
                                border-color: red
                            }
                        </style>

                        @if(!empty($registerUserPostData))
                            <?php echo '<pre>';print_r($registerUserPostData);?>
                        @endif
                        
                        @if(!empty($getEditTicket->id))
                        <form  autocomplete="off"  id="register_form" name="register_form" action="{{ route('ticket.edit') }}" method="post" autocomplete="off" onsubmit="return validateform()" enctype="multipart/form-data" >
                        @else 
                        <form   id="register_form"  name="register_form"  method="post"  action="{{ route('ticket.add') }}" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateform()" >
                        @endif
                        
                            @if(!empty($getEditTicket->id))
                                <input type="hidden" name="ticketId"  value="{{$getEditTicket->id}}">
                            @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                            <input type="hidden" name="ticketTypesId" id="ticketTypesId" value="{{!empty($getEditTicket->ticket_type_id) ? $getEditTicket->ticket_type_id:''}}">

                            <input type="hidden" name="ticketNos" id="ticketNos"  value="{{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no:''}}">
                           
                            <div class="row">
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
                                        <div  class="col-md-4">
                                            <div class="form-group row has-feedback {{ $errors->has('ticket_no') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Ticket No : </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="ticket_no" name="ticket_no" class="form-control borderred" 
                                                     data-date-format="dd-mm-yyyy" placeholder="Ticket No" value="{{!empty($getEditTicket->ticket_no) ? $getEditTicket->ticket_no : '' }}" 
                                                    disabled=""> 
                                                </div>
                                            </div>
                                        </div>   
                                        <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 3) {
                                        ?>
                                            <div  class="col-md-4">
                                                <div class="form-group row has-feedback {{ $errors->has('ticket_no') ? 'has-error' : '' }}">
                                                    <label for="inputEmail3"  class="control-label text-right col-md-3 col-form-label">UserName : </label>
                                                    <div class="col-md-9">
                                                        <input type="text"  id="ticket_no" name="ticket_no" class="form-control borderred" 
                                                         data-date-format="dd-mm-yyyy" placeholder="Ticket No" 
                                                         value="{{!empty($clientName) ?  $clientName : ''}}" disabled=""> 
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                        } 
                                    }
                                }
                                ?>
                                <?php 
                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4 ) {
                                ?>
                                    <div class="col-md-4">
                                        <div class="form-group row has {{ $errors->has('ticket_type_id') ? 'has-error' : '' }}">
                                            <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Ticket Type : </label>
                                            <div class="col-md-9">
                                                <select class="select2 m-b-10 select2" onchange="ticketType()"
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
                                                        style="width: 100%;height:50px;border:1px solid #e74a25!important">
                                                    
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

                                <?php 
                                    if (empty($getEditTicket->id)) {
                                ?>
                                    <div class="col-md-4">
                                        <div class="form-group row has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                            <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                                <?php
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                    Session::get('sessionUserData')[0][0]->role_id != 3) {
                                                    echo 'Select';
                                                }
                                                ?>
                                                Project : <?php if ($clientRole != 4) { echo  $clientRole; ?><?php } ?>
                                            </label>
                                            <div class="col-md-9">
                                                <select class="select2 m-b-10 select2" onchange="selectProject()" id="project_id" name="project_id" 
                                                    <?php
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                            echo 'disabled';
                                                        }
                                                    ?> style="width: 100%;height:50px;border:1px solid #e74a25!important">
                                                    <option value="">Select Project : </option>
                                                    <?php 
                                                        $projectIdArr = [];
                                                        $getProjectData =  DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N"'); 
                                                        if (!empty($getProjectData)) {
                                                            foreach ($getProjectData as $project) {
                                                                echo   '<option value="'.$project->id.'"';
                                                               /* if ($editProjectId == $project->id)  {
                                                                    echo  'selected="selected"';
                                                                } else {
                                                                    if ($clientRole == 4) {
                                                                        echo 'disabled="disabled"';
                                                                    }
                                                                }*/
                                                                echo  '>'.$project->name.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <span class="text-danger" id="projectIdMsg">{{ $errors->first('project_id') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                    } 
                                ?>
                                <?php 
                                    } 
                                ?>
                            </div>
                            
                            <div class="row">
                                <?php 
                                    $editProjectId = !empty($getEditTicket->project_id) ? $getEditTicket->project_id : 0;
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4) {
                                ?>  
                                        <div class="col-md-4">
                                            <div class="form-group row has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Select Project : </label>
                                                <div class="col-md-9">
                                                    <select class="select2 m-b-10 select2" onchange="selectProject()" id="project_id" name="project_id"    
                                                    style="width: 100%;height:50px;border:1px solid #e74a25!important">
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
                                    
                                <?php   } else { 
                                        if (!empty($getEditTicket->id)) {
                                ?>
                                            <div class="col-md-4">
                                                <div class="form-group row has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                                        <?php
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && 
                                                            Session::get('sessionUserData')[0][0]->role_id != 3) {
                                                            echo 'Select';
                                                        }
                                                        ?>
                                                        Project : <?php if ($clientRole != 4) { //echo  $clientRole; ?><?php } ?>
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select class="select2 m-b-10 select2" onchange="selectProject()" id="project_id" name="project_id" 
                                                            <?php
                                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                    echo 'disabled';
                                                                }
                                                            ?> style="width: 100%;height:50px;border:1px solid #e74a25!important">
                                                            <option value="">Select Project : </option>
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
                                <?php 
                                        } 
                                    }
                                ?>
                                


                                <?php 
                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4 ) {
                                ?>
                                    <div class="col-md-4">
                                        <div class="form-group row has {{ $errors->has('ticket_type_id') ? 'has-error' : '' }}">
                                            <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Ticket Type : </label>
                                            <div class="col-md-9">
                                                <select class="select2 m-b-10 select2" onchange="ticketType()"
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
                                                        style="width: 100%;height:50px;border:1px solid #e74a25!important">
                                                    
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

                                <?php } ?>

                                 <div class="col-md-4">
                                    <div class="form-group row has-feedback">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Title : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" 
                                            <?php 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4 ) {
                                            ?>
                                                style="border:1px solid #e74a25!important;width: 241%" 

                                            <?php }  else { ?>

                                                style="border:1px solid #e74a25!important;width: 90%" 

                                            <?php } ?>
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
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-2 col-form-label">Description : </label>
                                        <div class="col-md-10">
                                            <div class="adjoined-bottom">
                                                <div class="grid-container">
                                                    <div class="grid-width-100" style="padding-left:0px;width: 208%">
                                                        <textarea class="form-control" id="editor" name="description" 
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
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label for="inputEmail3"  class="control-label text-right col-md-3 col-form-label">Description : </label>
                                                    <div class="col-md-9"><?php echo $getEditTicket->description; ?></div>
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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Attachment : </label>
                                                <div class="col-md-9">
                                                    <input type="file" multiple="multiple" name="attachment[]" id="attachment">
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
                                        <div class="col-md-4">
                                            <div class="form-group row has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Attachment : </label>
                                                <div class="col-md-9">
                                                    <input  type="file" multiple="multiple" name="attachment[]" id="attachment">
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
                                $getTicketAttachmentData = 
                                DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND ticket_id = '.$ticketId.'');
                                if (!empty($getTicketAttachmentData)) {
                                ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-11">
                                            <table id="default_order" class="table table-bordered display" style="width:100%;    margin-top: -14px !important;    margin-bottom: 10px !important;" >
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
                                                            <tr id="attachment_<?php echo $attachment->id; ?>" >
                                                                <td class="text-left"><?php echo $i; ?></td>
                                                                <td> 
                                                                    <a href="<?php echo  $uploadPath.'/'.$attachment->attachment ?>" target="_blank" download="<?php echo $finalFileName; ?>" style="color: black;">
                                                                    <?php echo $finalFileName;?>
                                                                    </a>
                                                                </td>
                                                                <?php
                                                                    $checkAttAction =  DB::select('SELECT * FROM attachment WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketId.' AND role_id ='.Session::get('sessionUserData')[0][0]->role_id.' '); 
                                                                    if (!empty($checkAttAction)) {
                                                                ?>     
                                                                        <td style="width: 55px;">
                                                                            <a href="#"    onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->attachment;?>')"  class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" 
                                                                            data-original-title="Delete"  style="padding: 0px 7px;"><i class="ti-trash"></i> 
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
                                        <div class="col-md-4">
                                            <div class="form-group row has {{ $errors->has('priority') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Set Priority : </label>
                                                <div class="col-md-9" >
                                                    <select class="select2 m-b-10 select2" onchange="setPriority()" id="priority" name="priority" 
                                                   style="width: 100%;height:50px;border:1px solid #e74a25!important"
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
                                            <div class="form-group row has {{ $errors->has('severity') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Set Severity : </label>
                                                <div class="col-md-9">
                                                    <select class="select2 m-b-10 select2" onchange="setSeverity()" id="severity" 
                                                    name="severity"  style="width: 100%;height:50px;border:1px solid #e74a25!important"
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
                                            <div class="form-group row has {{ $errors->has('task_compittion_date') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-5 col-form-label">Task Compittion Date : </label>
                                                <div class="col-md-7">
                                                    <input type="text"  id="task_compittion_date" name="task_compittion_date" class="form-control borderred" 
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

                                        <div class="col-md-4">
                                            <div class="form-group row has {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Assing User : </label>
                                                <div class="col-md-9"> 
                                                    <select class="select2 m-b-10 select2-multiple" style="width: 100%;height:50px;border:1px solid #e74a25!important" onchange="userList()"  multiple  id="project_select"  data-placeholder="Serach Assign User Name" name="user_id[]" <?php if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) { echo 'disabled';
                                                        }?>>
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
                                                                $projectUserIdsArr = !empty($projectUserIdsArr) ? $projectUserIdsArr : '';
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
                                                                    ?>>{{$user->username}}</option>
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
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id == 3) {
                                        ?>
    
                                            <div class="col-md-4">  
                                                <div class="form-group row has {{ $errors->has('ticket_status_id') ? 'has-error' : '' }}">
                                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Ticket Status : </label>
                                                    <div class="col-md-9">
                                                        <select class="select2 m-b-10 select2" style="width: 100%;height:50px;"
                                                        onchange="ticketType()"  id="ticket_status_id" 
                                                        name="ticket_status_id" >
                                                            <?php     
                                                                $getTicketStatusById = 
                                                                DB::select('SELECT * FROM `ticket_status`  WHERE    is_deleted_status = "N" AND  
                                                                ticket_id = '.$getEditTicket->id.' ORDER BY id DESC LIMIT 1');
                                                                $ticketStatusId =  
                                                                !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                                $getTicketStatusData = 
                                                                DB::select('SELECT * FROM ticket_status_master WHERE is_deleted_status = "N" AND id IN(6,7,8)');
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
                                            <div class="col-md-4">  
                                                <div class="form-group row has {{ $errors->has('ticket_status_id') ? 'has-error' : '' }}">
                                                    <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label"> Ticket Status : </label>
                                                    <div class="col-md-9">
                                                        <select class="select2 m-b-10 select2" style="width: 100%;height:50px;" onchange="ticketType()"  id="ticket_status_id" 
                                                            name="ticket_status_id" >
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
                                    
                
                                        <?php 
                                            //if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                            $ticketRemark = '';    
                                            $ticketId = !empty($getEditTicket->id) ? $getEditTicket->id : 0;
                                            $getTicketRemarkData = DB::select('SELECT * FROM ticket_status WHERE is_deleted_status = "N" AND 
                                            ticket_id = '.$ticketId.' ORDER BY id DESC LIMIT 1');
                                            if (!empty($getTicketRemarkData[0]->remark)) { 
                                                $ticketRemark =  $getTicketRemarkData[0]->remark;  
                                            }
                                        ?>

                                    
                                        <div class="col-md-4">
                                            <div class="form-group row has-feedback ">
                                                <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Remark : </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control borderred_border" id="remark" name="remark" 
                                                    value="<?php echo  $ticketRemark;?>" placeholder="Remark">
                                                    <span class="text-danger" id="remarkMsg"></span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php
                                //}
                                } 
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" onclick="resetTicketForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('admin.common.script2')
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
            var ticketType = $('#ticket_type_id').val();
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
                
                if (ticketType == '') {
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
                    $('#taskCompittionDateMsg').html("Task Compittion Date required.");   
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
            if (ticketType =='' || title =='' || projectId == '') { 
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
    </body>
</html>