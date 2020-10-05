@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            @if(!empty($getProjectDataByID))
                @foreach ($getProjectDataByID as $getEditProject)
                @endforeach
            @endif
            <h3 class="box-title m-b-0">
                {{ !empty($getEditProject->id) ? 'Edit Project' : 'Add  Project' }}
            </h3>
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
                
                <div class="row" >
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2" >
                              <label for="inputEmail3" class="control-label" >Project Name<b class="text-danger">*</b>
                              </label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" 
                                style="border:1px solid #e74a25!important;width: 90%" type="text" oninput="emptyName()" placeholder="Project Name" id="name" name="name"   value="{{ !empty($getEditProject->name) ? $getEditProject->name : old('name') }}{{ !empty($registerProjectPostData['name']) ? $registerProjectPostData['name'] : '' }}">
                                <span class="text-danger"   id="nameMsg"></span>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @if (!empty($emptyErrorMsg['checkTitleMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkTitleMsg']}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

        
             
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="inputEmail3" class="control-label" style="margin-left: 20px;">Description
                                <!-- <b class="text-danger">*</b> -->
                            </label>
                        </div>
                        <div class="col-md-9" 
                        <?php
                        if (!empty($getEditProject->id)) {
                            echo 'style="margin-left: -103px;"';  
                        } else {
                            echo 'style="margin-left: -103px;"';
                        }
                        ?>>
                            <div class="adjoined-bottom"  >
                                <div class="grid-container">
                                    <div class="grid-width-100">
                                        <textarea class="form-control" id="editor"  style="width:  150px;" 
                                        name="description"> 
                                            {{ !empty($getEditProject->description) ? $getEditProject->description : old('description') }}{{ !empty($registerProjectPostData['description']) ? $registerProjectPostData['description'] : '' }}
                                        </textarea>
                                        <span class="text-danger">{{ $errors->first('description') }}</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            <div class="col-md-3" >
                                <label for="inputEmail3" class="control-label">Select Assign User<b class="text-danger">*
                                </b></label>
                            </div>
                            <div class="col-md-6" style="margin-left: -81px;">
                                <select class="form-control select2" onchange="projectType()" id="project_select" 
                                name="user_id" style="border:1px solid #e74a25!important;width: 90%">
                                    <?php 
                                        $getProjectTypeData =  
                                        DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" ');
                                    ?>
                                    <option value="">Select Assign User</option>
                                </select>
                                <span class="text-danger" id="assignUserId">{{ $errors->first('user_id') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-3">
                                @if(empty($getEditProject->id))
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Save</button>
                                    
                                @else
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Update</button>
                                @endif
                            </div>
                            <div class="col-md-3" style="margin-left: -25px;">
                                <button type="button" onclick="resetProjectForm()" class="btn btn-block btn-default">
                                    <i class="icon-close"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function resetProjectForm() {
        
        window.location.href="{{ route('project') }}";
    }
</script>

@include('admin.common.script')

<script>
    function validateform() { 
        var projectType = document.register_form.project_select.value;
        var name = document.register_form.name.value;
        if (projectType=='' || name =='') { 
            if (projectType =='') {
                $('#assignUserId').show();
                $('#assignUserId').html("<span class='text-danger'>Please Select Assign User Name</span>");
            }
            if (name =='') {
                $('#nameMsg').show();
                $('#nameMsg').html("<span class='text-danger'>The Project Name field is required.</span>");   
            }
            return false;
        }  
    } 

    function projectType() {
        var projectType = $('#project_select').val();
        if (projectType=='') { 
            $('#assignUserId').show();
        } else {
           $('#assignUserId').hide(); 
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