@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(!empty($getClientDataByID))
                        @foreach ($getClientDataByID as $getEditClient)
                        @endforeach
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">Manage Client</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        @if(!empty($getEditClient->id))
                        <form  autocomplete="off"  id="register-form" action="{{ route('client.edit') }}" method="post"  autocomplete="off">
                        @else 
                        <form id="register-form"  method="post" action="{{ route('client.add') }}" enctype="multipart/form-data" autocomplete="off" >
                        @endif
                            @if(!empty($getEditClient->id))
                                <input type="hidden" name="clientId"  value="{{$getEditClient->id}}">
                            @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label class="control-label text-right col-md-3 col-form-label">Name : </label>
                                        <div class="col-md-9">
                                            <input type="text"  id="name" name="name" class="form-control borderred" id="inputEmail3" 
                                                placeholder="Name" value="{{ !empty($getEditClient->name) ? $getEditClient->name : old('name') }}{{ !empty($registerClientPostData['name']) ? $registerClientPostData['name'] : '' }}" ng-model="formData.username"> 
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @if (!empty($emptyErrorMsg['checkUserNameMsg']))
                                                <span class="text-danger"> {{ $emptyErrorMsg['checkUserNameMsg'] }} </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label class="control-label text-right col-md-3 col-form-label">Email : </label>
                                        <div class="col-md-9">
                                             <input class="form-control borderred" type="text"  placeholder="Email" id="email" name="email"   value="{{ !empty($getEditClient->email) ? $getEditClient->email : old('email') }}{{ !empty($registerClientPostData['email']) ? $registerClientPostData['email'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @if (!empty($emptyErrorMsg['checkEmailMsg']))
                                                <span class="text-danger">{{$emptyErrorMsg['checkEmailMsg']}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('mobile') ? 'has-error' : ''}}">
                                        <label class="control-label text-right col-md-3 col-form-label">Mobile : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred"  type="text" name="mobile" id="number"  placeholder="Mobile" maxlength="10" value="{{ !empty($getEditClient->mobile) ? $getEditClient->mobile : old('mobile') }}{{ !empty($registerClientPostData['mobile']) ? $registerClientPostData['mobile'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                            @if (!empty($emptyErrorMsg['checkMobileMsg']))
                                                <span class="text-danger"> {{ $emptyErrorMsg['checkMobileMsg'] }} </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label class="control-label text-right col-md-3 col-form-label">Address : </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control borderred" placeholder="Address" id="address" name="address" 
                                            value="{{ !empty($getEditClient->address) ? $getEditClient->address : old('address') }}{{ !empty($registerClientPostData['address']) ? $registerClientPostData['address'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('address') }}</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Select Project : </label>
                                        <div class="col-md-9">
                                            <select class="form-control" multiple="" id="select2-with-tokenizer" 
                                            style="width: 100%;height:50px;" data-placeholder="Serach Project Name" name="project_id[]">
                                                <?php
                                                    $getProjectDatas = [];
                                                    $projectArr = [];
                                                    if (!empty($getEditClient->id)) {
                                                        $getProjectDatas = DB::select('SELECT * FROM client_project_master WHERE is_deleted_status =  "N" AND client_id = 
                                                            '.$getEditClient->id.'');
                                                        if (!empty($getProjectDatas)) {
                                                            foreach ($getProjectDatas as $projects) {
                                                                $projectArr[] = $projects->project_id;
                                                            }   
                                                        }
                                                    }
                                                    $getProjectData = 
                                                    DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N"');
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
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4 col-form-label" style="margin-left: -36px">
                                        Contact Person : </label>
                                        <div class="col-md-8">
                                            <input class="form-control borderred" style="width: 113%"   type="text" name="contact_person" id="contact_person" 
                                            placeholder="Contact Person" value="{{ !empty($getEditClient->contact_person) ? $getEditClient->contact_person : old('contact_person') }}{{ !empty($registerClientPostData['contact_person']) ? $registerClientPostData['contact_person'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('contact_person') }}</span>
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
                                            <button type="button" onclick="resetClientForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Contact Person</th>
                                        <th>Project Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getClientData))
                                        @foreach ($getClientData as $key => $client)
                                            <tr @if($client->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif>
                                                <td>{{$key+1}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->email}}</td>
                                                <td>{{$client->mobile}}</td>
                                                <td>{{$client->contact_person}}</td>
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
                                                <td>
                                                    <a href="{{ route('client.viewbyid',['clientId' =>  base64_encode($client->id)]) }}" 
                                                    class="btn btn-xs btn-info"   data-toggle="tooltip" data-placement="top" title="Edit" 
                                                    style="padding: 0px 7px;"> <i class="ti-pencil"></i>
                                                    </a>
                                                    <a href="{{ route('client.delete',['clientId' =>  base64_encode($client->id)]) }}"  
                                                    class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"   
                                                    onclick="return confirm('Are you Want to delete?')" style="padding: 0px 7px;" ><i class="ti-trash" ></i>
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
        function resetClientForm() {
            window.location.href="{{ route('client') }}";
        }
    </script>
    <script>
    
/*      @if (!empty($successMsg))
            toastr.success(
                '{{$successMsg}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 
                3000 
            });
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
    </body>
</html>
