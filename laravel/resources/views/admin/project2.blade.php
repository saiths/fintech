@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(!empty($getProjectDataByID))
                        @foreach ($getProjectDataByID as $getEditProject)
                        @endforeach
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">Manage Project</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        @if(!empty($getEditProject->id))
                        <form  autocomplete="off"  id="register-form"  name="register_form" action="{{ route('project.edit') }}" method="post"  autocomplete="off" onsubmit="return validateform()" enctype="multipart/form-data">
                        @else 
                        <form id="register-form"  name="register_form" method="post" action="{{ route('project.add') }}" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateform()" >
                        @endif
                        @if(!empty($getEditProject->id))
                            <input type="hidden" name="projectId"  value="{{$getEditProject->id}}">
                        @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label class="control-label text-right col-md-3 col-form-label">Project Name : </label>
                                        <div class="col-md-9">
                                            <input type="text" id="name" name="name" class="form-control borderred"
                                            oninput="emptyName()"  id="inputEmail3"  placeholder="Project Name" value="{{ !empty($getEditProject->name) ? $getEditProject->name : old('name') }}{{ !empty($registerProjectPostData['name']) ? $registerProjectPostData['name'] : '' }}">
                                            <span class="text-danger"   id="nameMsg"></span> 
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @if (!empty($emptyErrorMsg['checkNameMsg']))
                                                <span class="text-danger">{{$emptyErrorMsg['checkNameMsg']}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                                        <label class="control-label text-right col-md-3 col-form-label">Description : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" oninput="emptyDescription()" 
                                             id="description"  name="description" rows="2" placeholder="Description" 
                                             value="{{ !empty($getEditProject->description) ? $getEditProject->description : old('description') }}{{ !empty($registerProjectPostData['description']) ? $registerProjectPostData['description'] : '' }}">
                                            <span class="text-danger" id="descriptionMsg">{{ $errors->first('description') }}
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Select User : </label>
                                        <div class="col-md-9">
                                            <select class="select2 m-b-10 select2-multiple"  onchange="projectType()"  multiple 
                                            id="select2-with-tokenizer_project" data-placeholder="Serach Assign User Name" name="user_id[]" style="width: 100%;height:50px;">
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
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" onclick="resetProjectForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%">
                                <thead style="color: black;background: #456c4552;">
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
                                            <tr @if($project->status == 'No') 
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
                                                        $getUserNameDatad = 
                                                        DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND id 
                                                        IN('.$userIdD.')');
                                                        if (!empty($getUserNameDatad)) {
                                                            foreach ($getUserNameDatad as $user) {
                                                                $userName .= $user->username.',';
                                                            } 
                                                            echo rtrim($userName,',');
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="{{ route('project.viewbyid',['projectId' =>  base64_encode($project->id)]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                                        style="padding: 0px 7px;" ><i class="ti-pencil"></i> 
                                                    </a>
                                                    <a href="{{ route('project.delete',['projectId' =>  base64_encode($project->id)]) }}"  class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')"style="padding: 0px 7px;">
                                                        <i class="ti-trash"></i> 
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
        </div>
    </div>
</div>
</div>
<div class="chat-windows"></div>

@include('admin.common.script2')

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
/*  @if (!empty($successMsg))
        toastr.success(
            '{{$successMsg}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif 
*/
    
    @if(\Session::has('message'))
        toastr.success(
            '{{session()->get('message')}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif
</script>
    </body>
</html>

