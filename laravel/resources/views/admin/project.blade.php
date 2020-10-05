@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            @if(!empty($getProjectDataByID))
                @foreach ($getProjectDataByID as $getEditProject)
                @endforeach
            @endif
            <h3 class="box-title m-b-0"> {{ !empty($getEditProject->id) ? 'Edit Project' : 'Add  Project' }}</h3>

            <p class="text-muted m-b-30 font-13 "> 
               <span class="text-danger"> *Indicates Required Field </span> 
            </p>
            
            @if(!empty($getEditProject->id))
            <form class="form-horizontal" autocomplete="off" class="form-horizontal" id="register_form" name="register_form" action="{{ route('project.edit') }}" method="post" autocomplete="off" onsubmit="return validateform()" enctype="multipart/form-data" >
            @else 
            <form class="form-horizontal" style="margin-top: 10px;" id="register_form"  name="register_form"method="post"  action="{{ route('project.add') }}" enctype="multipart/form-data" 
                autocomplete="off" onsubmit="return validateform()" >
            @endif
                
                @if(!empty($getEditProject->id))
                    <input type="hidden" name="projectId"  value="{{$getEditProject->id}}">
                @endif
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                
                <div class="row">
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label ">ProjectName<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control"
                                oninput="emptyName()"   style="border:1px solid #e74a25!important" id="inputEmail3"  placeholder="Project Name" 
                                value="{{ !empty($getEditProject->name) ? $getEditProject->name : old('name') }}{{ !empty($registerProjectPostData['name']) ? $registerProjectPostData['name'] : '' }}">
                                <span class="text-danger"   id="nameMsg"></span> 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @if (!empty($emptyErrorMsg['checkNameMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkNameMsg']}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Description<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" oninput="emptyDescription()" 
                                style="height: 39px; border:1px solid #e74a25!important" id="description" name="description" rows="2" 
                                placeholder="Description">{{ !empty($getEditProject->description) ? $getEditProject->description : old('description') }}{{ !empty($registerProjectPostData['description']) ? $registerProjectPostData['description'] : '' }}</textarea>
                                <span class="text-danger" id="descriptionMsg">{{ $errors->first('description') }}</span> 
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;Select User<b class="text-danger">*</b></label>
                            <div class="col-sm-8" > 
                                <select class="select2 m-b-10 select2-multiple" style="width: 113%;"   onchange="projectType()"  
                                    multiple  id="project_select"  data-placeholder="Serach Assign User Name" name="user_id[]" >
                                    <?php
                                        $getUserNameDatas = [];
                                        $userIdsArr = [];   
                                        $projectId = !empty($getEditProject->id) ? $getEditProject->id : '';
                                        if (!empty($projectId)) {
                                            $getProjectDatas =  DB::select('SELECT * FROM project_assing_user WHERE is_deleted_status = "N" 
                                                AND project_id = '.$projectId.'');
                                            if (!empty($getProjectDatas)) {
                                                foreach ($getProjectDatas as $projects) {
                                                    $userIdArr[] = $projects->user_id;
                                                }   
                                            }
                                            $userIdA = implode(',', $userIdArr);
                                            $userIdB = !empty($userIdA) ? $userIdA : 0;
                                            $getUserNameDatas = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" 
                                                AND id IN('.$userIdB.')');

                                            if (!empty($getUserNameDatas)) {
                                                foreach ($getUserNameDatas as $user) {
                                                    $userIdsArr[] = $user->id;
                                                } 
                                            }
                                        }
                                        $getProjectTypeData = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND role_id != 4');
                                    ?>

                                    @if (!empty($getProjectTypeData))
                                        @foreach($getProjectTypeData as $user)
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
                                @if (!empty($emptyErrorMsg['checkUserIdMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkUserIdMsg']}}</span>
                                @endif
                                <span class="text-danger" id="assignUserId">{{ $errors->first('user_id') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(empty($getEditProject->id))
                            <div class="col-sm-3" style="margin-left: 147px;">
                                <button type="submit" class="btn btn-block btn-primary"> 
                                <i class="fa fa-save"></i> Save</button>
                            </div>  
                        @else
                            <div class="col-md-5" style="margin-left: 143px;">
                                <button type="submit"  style="width: 121px;" class="btn btn-block btn-primary"> 
                                <i class="fa fa-save"></i> Update</button>
                            </div>
                        @endif
                        <div class="col-sm-5" <?php if (!empty($getEditProject->id)) {?>  style="margin-left: 272px;margin-top: -36px;"
                            <?php } else {?>style="margin-left: -25px;"<?php } ?>>
                            <button type="button" onclick="resetProjectForm()" style="width: 121px;"  class="btn  btn-default">
                                <i class="icon-close"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Project</h3>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <style type="text/css">
                    .table td{
                        padding: 0.1rem !important;
                        vertical-align: top;
                        border-top: 1px solid #dee2e6;
                    }
                </style>
                <table id="myTable"  class="table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Project Name</th>
                            <th>Project Assign User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($getProjectData))
                            @foreach ($getProjectData as $key => $project)
                                <tr  
                                    @if($project->status == 'No') 
                                        style="background-color:#ff851b !important"
                                    @endif
                                    >
                                    <td>{{$key+1}}</td>
                                    <td>{{$project->name}}</td>
                                    <td>
                                        <?php
                                            $userName = '';
                                            $getProjectDatad =  
                                            DB::select('SELECT * FROM project_assing_user WHERE is_deleted_status = "N" 
                                                AND project_id = '.$project->id.'');
                                            $userIdArrd = [];
                                            if (!empty($getProjectDatad)) {
                                                foreach ($getProjectDatad as $projectd) {
                                                    $userIdArrd[] = $projectd->user_id;
                                                }   
                                            }
                                            $userIdC = implode(',', $userIdArrd);
                                            $userIdD = !empty($userIdC) ? $userIdC : 0;
                                            $getUserNameDatad = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND id IN('.$userIdD.')');
                                            if (!empty($getUserNameDatad)) {
                                                foreach ($getUserNameDatad as $user) {
                                                    $userName .= $user->username.',';
                                                } 
                                                echo rtrim($userName,',');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('project.viewbyid',['projectId' =>  base64_encode($project->id)]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" style="padding: 0px 7px;" >
                                            <i class="icon-pencil"></i> 
                                        </a>
                                        <a href="{{ route('project.delete',['projectId' =>  base64_encode($project->id)]) }}"  class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" 
                                            data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')"style="padding: 0px 7px;">
                                            <i class="icon-trash"></i> 
                                        </a>
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

@include('admin.common.script')

<script type="text/javascript">
    function resetProjectForm() {
        window.location.href="{{ route('project') }}";
    }
</script>

<script>
    function validateform() { 
       // var projectType = document.register_form.project_select.value;
        var name = document.register_form.name.value;
        var description = document.register_form.description.value;
        if (name =='' || description == '') { 
            if (description =='') {
                $('#descriptionMsg').show();
                $('#descriptionMsg').html("<span class='text-danger'>The Description field is required.</span>");
            }
            /*if (projectType =='') {
                $('#assignUserId').show();
                $('#assignUserId').html("<span class='text-danger'>Please Select Assign User Name</span>");
            }*/
            if (name =='') {
                $('#nameMsg').show();
                $('#nameMsg').html("<span class='text-danger'>The Project Name field is required.</span>");   
            }
            return false;
        }  
    } 

    function emptyDescription() {
        var description = $('#description').val();
        if (description=='') { 
            $('#descriptionMsg').show();
        } else {
           $('#descriptionMsg').hide(); 
        }
    }

    function projectType() {
        var projectType = 0;

        var projectType = $('#project_select').val();
        if (projectType==0) { 
            //$('#assignUserId').show();
            $("option:selected").removeAttr("selected");

        } else {
            if (projectType==0 ) { 
                 $("option:selected").removeAttr("selected");
            }   
           //   $("option:selected").removeAttr("selected");
          // $('#assignUserId').hide(); 
        }
    }
    
    function emptyName() {
        var title = $('#name').val();
        if (title=='') { 
            $('#nameMsg').show();
        } else {
           $('#nameMsg').hide(); 
        }
    }
</script>

<script>
    @if (!empty($successMsg))
        $.toast({
            heading: 'Success!',
            position: 'top-right',
            text: '{{$successMsg}}',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
    @endif
</script>
