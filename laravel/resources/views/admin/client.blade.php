@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            @if(!empty($getClientDataByID))
                @foreach ($getClientDataByID as $getEditClient)
                @endforeach
            @endif
            <h3 class="box-title m-b-0">{{ !empty($getEditClient->id) ? 'Edit Client' : 'Add  Client' }}</h3>
            <p class="text-muted m-b-30 font-13 "> 
               <span class="text-danger"> *Indicates Required Field </span> 
            </p>
            
            @if(!empty($getEditClient->id))
                <form class="form-horizontal" autocomplete="off" class="form-horizontal" id="register-form" action="{{ route('client.edit') }}" method="post" autocomplete="off">
            @else 
                <form class="form-horizontal" style="margin-top: 10px;" id="register-form"  method="post" 
                action="{{ route('client.add') }}" enctype="multipart/form-data" autocomplete="off" >
            @endif
                @if(!empty($getEditClient->id))
                    <input type="hidden" name="clientId"  value="{{$getEditClient->id}}">
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label ">Name<b class="text-danger">*</b>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control" style="border:1px solid #e74a25!important" id="inputEmail3" 
                                placeholder="Name" value="{{ !empty($getEditClient->name) ? $getEditClient->name : old('name') }}{{ !empty($registerClientPostData['name']) ? $registerClientPostData['name'] : '' }}"> 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                  @if (!empty($emptyErrorMsg['checkUserNameMsg']))
                                    <span class="text-danger"> {{ $emptyErrorMsg['checkUserNameMsg'] }} </span>
                                @endif 
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Address<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <textarea class="form-control"  style="height: 39px; border:1px solid #e74a25!important" id="address" name="address" rows="2" placeholder="Address">{{ !empty($getEditClient->address) ? $getEditClient->address : old('address') }}{{ !empty($registerClientPostData['address']) ? $registerClientPostData['address'] : '' }}</textarea>
                                <span class="text-danger">{{ $errors->first('address') }}</span> 
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Email<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input class="form-control" style="border:1px solid #e74a25!important" type="text"  placeholder="Email"
                                id="email" name="email" 
                                value="{{ !empty($getEditClient->email) ? $getEditClient->email : old('email') }}{{ !empty($registerClientPostData['email']) ? $registerClientPostData['email'] : '' }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @if (!empty($emptyErrorMsg['checkEmailMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkEmailMsg']}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('mobile') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Mobile<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                              <input class="form-control" style="border:1px solid #e74a25!important" type="text" name="mobile" id="number"  
                              placeholder="Mobile" maxlength="10" 
                              value="{{ !empty($getEditClient->mobile) ? $getEditClient->mobile : old('mobile') }}{{ !empty($registerClientPostData['mobile']) ? $registerClientPostData['mobile'] : '' }}">
                              <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @if (!empty($emptyErrorMsg['checkMobileMsg']))
                                    <span class="text-danger"> {{ $emptyErrorMsg['checkMobileMsg'] }} </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">ContactPerson<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="contact_person" id="contact_person" 
                                placeholder="Contact Person" style="border:1px solid #e74a25!important" value="{{ !empty($getEditClient->contact_person) ? $getEditClient->contact_person : old('contact_person') }}{{ !empty($registerClientPostData['contact_person']) ? $registerClientPostData['contact_person'] : '' }}">
                                <span class="text-danger">{{ $errors->first('contact_person') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                           <div class="form-group has {{ $errors->has('project_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;Select Project</label>
                            <div class="col-sm-8" > 
                                <select class="select2 m-b-10 select2-multiple" style="width: 113%;" 
                                    multiple  id="project_select" data-placeholder="Serach Project Name" 
                                    name="project_id[]" >
                                    <?php
                                        $getProjectDatas = [];
                                        $projectArr = [];
                                        if (!empty($getEditClient->id)) {
                                            $getProjectDatas = 
                                            DB::select('SELECT * FROM client_project_master WHERE is_deleted_status =  "N" AND client_id =  '.$getEditClient->id.'');
                                            if (!empty($getProjectDatas)) {
                                                foreach ($getProjectDatas as $projects) {
                                                    $projectArr[] = $projects->project_id;
                                                }   
                                            }
                                        }
                                        $getProjectData = DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N"');
                                    ?>
                                    @if (!empty($getProjectData))
                                        @foreach($getProjectData as $project)
                                            <option value="{{$project->id}}"
                                                <?php 
                                                if (in_array($project->id, $projectArr)) {
                                                    echo 'selected=selected';
                                                }
                                                ?> >{{$project->name}}
                                            </option>
                                        @endforeach
                                    @endif 
                                </select> 
                                @if (!empty($emptyErrorMsg['checkProjectMsg']))
                                    <span class="text-danger">{{$emptyErrorMsg['checkProjectMsg']}}</span>
                                @endif
                                <span class="text-danger" id="assignUserId">{{ $errors->first('project_id') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                                @if(empty($getEditClient->id))
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Save</button>
                                @else
                                    <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Update</button>
                                @endif
                            </div>
                            <div class="col-md-3" style="margin-left: -25px;">
                                <button type="button" onclick="resetClientForm()" class="btn btn-block btn-default">
                                    <i class="icon-close"></i> Cancel</button>
                            </div>
                        </div>
                    <div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Client</h3>
            <div class="clearfix"></div>
            <div class="table-responsive" >
                <style type="text/css">
                .table td{
                    padding: 0.1rem !important;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                </style>
                <table id="myTable" class="table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Project Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($getClientData))
                            @foreach ($getClientData as $key => $client)
                                <tr  
                                    @if($client->status == 'No') 
                                        style="background-color:#ff851b !important"
                                    @endif
                                    >
                                    <td>{{$key+1}}</td>
                                    <td>&nbsp;&nbsp;{{$client->name}}</td>
                                    <td>&nbsp;&nbsp;
                                    {{$client->contact_person}}</td>
                                    <td>&nbsp;&nbsp;{{$client->email}}</td>
                                    <td>&nbsp;&nbsp;{{$client->mobile}}</td>
                                    <td>
                                        <?php
                                            $projectName = '';
                                            $getProjectDatad =  DB::select('SELECT * FROM client_project_master WHERE is_deleted_status = "N" AND client_id = '.$client->id.'');
                                            $projectArrs = [];
                                            if (!empty($getProjectDatad)) {
                                                foreach ($getProjectDatad as $projects) {
                                                    $projectArrs[] = $projects->project_id;
                                                }   
                                            }
                                            if (!empty($projectArrs)) {
                                                $projectIds = implode(',', $projectArrs);
                                            } else {
                                                $projectIds = 0;
                                            }
                                            $getProjectNameDatad = 
                                            DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N"  AND id IN('.$projectIds.')');
                                            if (!empty($getProjectNameDatad)) {
                                                foreach ($getProjectNameDatad as $project) {
                                                    $projectName .= $project->name.',';
                                                } 
                                                echo rtrim($projectName,',');
                                            }
                                        ?>
                                    </td>
                                    <td>&nbsp;&nbsp;
                                        <a href="{{ route('client.viewbyid',['clientId' =>  base64_encode($client->id)]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" style="padding: 0px 7px;" ><i class="icon-pencil"></i> </a>
                                        <a href="{{ route('client.delete',['clientId' =>  base64_encode($client->id)]) }}"  class="btn btn-sm btn-danger" 
                                        data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')" 
                                        style="padding: 0px 7px;"><i class="icon-trash"></i> 
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

<script type="text/javascript">
    function resetClientForm() {
        window.location.href="{{ route('client') }}";
        
    }
</script>
@include('admin.common.script')

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

    $(function() {
        $("#register-form").validate({
            rules: {
                address : {
                    required: true
                },
                mobile : {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                      
                },
                contact_person: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
            },
            // Specify the validation error messages
            messages: {
                mobile: "<span class='text-danger'>The Mobile field is required.</span>",
                address: "<span class='text-danger'>The Address field is required.</span>",
                contact_person: "<span class='text-danger'>The Contact Person field is required.</span>",
                
                name: "<span class='text-danger'>The Name field is required.</span>",
                email:{
                    required : "<span class='text-danger'>The Email field is required.</span>",
                    email :   "<span class='text-danger'>Please enter a valid email address.</span>",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>