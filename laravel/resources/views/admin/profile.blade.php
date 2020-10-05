@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
           @if(!empty(Session::get('sessionUserData')))
                @foreach (Session::get('sessionUserData') as $getEditUser)
                @endforeach
            @endif 
            <h3 class="box-title m-b-0">Edit Profile</h3>
            <p class="text-muted m-b-30 font-13 "> 
               <span class="text-danger"> *Indicates Required Field </span> 
            </p>
                <form class="form-horizontal" autocomplete="off" onsubmit="return formValidation(this)"  id="register-form" action="{{ route('updateprofile') }}" method="post">
                
                @if(!empty($getEditUser[0]->id))
                    <input type="hidden" name="userId"  value="{{$getEditUser[0]->id}}">
                @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label ">Full Name<b class="text-danger">*</b>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" style="border:1px solid #e74a25!important" id="name" name="name" class="form-control" id="inputEmail3" placeholder="Full Name" value="{{ !empty($getEditUser[0]->name) ? $getEditUser[0]->name : old('name') }}{{ !empty($registerUserPostData['name']) ? $registerUserPostData['name'] : '' }}"> 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"  id="address" name="address" rows="2" placeholder="Address">{{ !empty($getEditUser[0]->address) ? $getEditUser[0]->address : old('address') }}{{ !empty($registerUserPostData['address']) ? $registerUserPostData['address'] : '' }}</textarea>
                                <span class="text-danger">{{ $errors->first('address') }}</span> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has {{ $errors->has('role_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Select Role<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="role_id" name="role_id" style="border:1px solid #e74a25!important">
                                    <?php 
                                        $getRoleData = 
                                        DB::select('SELECT * FROM role_master WHERE is_deleted_status = "N" ');
                                    ?>
                                    <option value="">Select Role</option>
                                    @if (!empty($getRoleData))
                                        @foreach ($getRoleData as $role)  
                                            <option value="{{$role->id}}"
                                                @if (!empty($getEditUser[0]->role_id))
                                                    {{ ($getEditUser[0]->role_id == $role->id) ? 'selected=selected' : '' }}
                                                @else
                                                    {{ (old('role_id') == $role->id) ? 'selected=selected' : '' }}
                                                    @if (!empty($registerUserPostData['role_id']))
                                                        {{ ($registerUserPostData['role_id'] == $role->id) ? 'selected=selected' : '' }}
                                                    @else
                                                    @endif
                                                @endif
                                                >{{$role->role_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6" id="clientIdList"   
                        @if (!empty($registerUserPostData) || !empty($getEditUser[0]->role_id))
                            @if (!empty($registerUserPostData) == 4 || $getEditUser[0]->role_id == 4)
                            @else
                                style="display: none;"
                            @endif
                        @else
                        style="display: none;"
                    @endif 
                    >
                        <div class="form-group has {{ $errors->has('client_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Select Client<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="client_id" name="client_id" style="border:1px solid #e74a25!important">
                                    <?php 
                                    $getClientData = 
                                    DB::select('SELECT * FROM client_master WHERE is_deleted_status = "N" ');
                                    ?>
                                    <option value="">Select Client</option>
                                    @if (!empty($getClientData))
                                        @foreach ($getClientData as $client)  
                                            <option value="{{$client->id}}"
                                                @if (!empty($getEditUser[0]->client_id))
                                                    {{ ($getEditUser[0]->client_id == $client->id) ? 'selected=selected' : '' }}
                                                @else
                                                    {{ (old('client_id') == $client->id) ? 'selected=selected' : '' }}
                                                    @if (!empty($registerUserPostData['client_id']))
                                                        {{ ($registerUserPostData['client_id'] == $client->id) ? 'selected=selected' : '' }}
                                                    @else
                                                    @endif
                                                @endif
                                                >{{$client->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger">{{ $errors->first('client_id') }}</span>
                                @if (!empty($emptyErrorMsgs))
                                    <span class="text-danger">{{ $emptyErrorMsgs }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">UserName<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input class="form-control" style="border:1px solid #e74a25!important" type="text" name="username" id="username" 
                                placeholder="UserName" value="{{ !empty($getEditUser[0]->username) ? $getEditUser[0]->username : old('username') }}{{ !empty($registerUserPostData['username']) ? $registerUserPostData['username'] : '' }}">
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                @if (!empty($emptyErrorMsg['checkUserNameMsg']))
                                    <span class="text-danger"> {{ $emptyErrorMsg['checkUserNameMsg'] }} </span>
                                @endif 
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
                                value="{{ !empty($getEditUser[0]->email) ? $getEditUser[0]->email : old('email') }}{{ !empty($registerUserPostData['email']) ? $registerUserPostData['email'] : '' }}">
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
                              <input class="form-control" type="text" style="border:1px solid #e74a25!important" name="mobile" id="mobile"  
                              placeholder="Mobile" maxlength="10" 
                              value="{{ !empty($getEditUser[0]->mobile) ? $getEditUser[0]->mobile : old('mobile') }}{{ !empty($registerUserPostData['mobile']) ? $registerUserPostData['mobile'] : '' }}">
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
                        <div class="form-group has-feedback {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-md-3 control-label">DOB</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  placeholder="Date of Birth"
                                id="datepicker_date_of_birth" data-date-format="dd-mm-yyyy" name="date_of_birth" 
                                value="{{ !empty($getEditUser[0]->date_of_birth) ? $getEditUser[0]->date_of_birth : old('date_of_birth') }}{{ !empty($registerUserPostData['date_of_birth']) ? $registerUserPostData['date_of_birth'] : '' }}">

                                <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                            </div>
                        </div>
                    </div>
                    @if (!empty($getEditUser[0]->date_of_joining) && $getEditUser[0]->role_id  != 4)
                        <div class="col-md-6" id="date_of_Joining_hide"  >
                            <div class="form-group has-feedback {{ $errors->has('date_of_joining') 
                                    ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="col-md-3 control-label">DOJ</label>
                                <div class="col-sm-9" >
                                    <input class="form-control" type="text"  placeholder="Date of Joining"
                                    id="datepicker_date_of_Joining" data-date-format="dd-mm-yyyy" 
                                    name="date_of_joining" 
                                    value="{{ !empty($getEditUser[0]->date_of_joining) ? $getEditUser[0]->date_of_joining : old('date_of_joining') }}{{ !empty($registerUserPostData['date_of_joining']) ? $registerUserPostData['date_of_joining'] : '' }}">
                                    <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                                </div>
                            </div>
                        </div>
                    @else 
                        @if (!empty($getEditUser[0]->role_id) && $getEditUser[0]->role_id == 4)
                        @else
                            @if (!empty(old('role_id')) || old('role_id') != 4 )
                                <div class="col-md-6" id="date_of_Joining_hide"   >
                                    <div class="form-group has-feedback {{ $errors->has('date_of_joining') 
                                        ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-md-3 control-label">DOJ</label>
                                        <div class="col-sm-9" >
                                            <input class="form-control" type="text"  placeholder="Date of Joining"
                                            id="datepicker_date_of_Joining" data-date-format="dd-mm-yyyy" 
                                            name="date_of_joining" 
                                            value="{{ !empty($getEditUser[0]->date_of_joining) ? $getEditUser[0]->date_of_joining : old('date_of_joining') }}{{ !empty($registerUserPostData['date_of_joining']) ? $registerUserPostData['date_of_joining'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                            @endif
                        @endif
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                            <div class="col-md-2" style="margin-left: -25px;">
                                <button type="button" onclick="resetUserForm()" class="btn btn-block btn-default">
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
    function resetUserForm() {
        window.location.href="{{ route('editprofile') }}";
    }
</script>
@include('admin.common.script')

<script>

    @if(\Session::has('message'))
        $.toast({
            heading: 'Success!',
            position: 'top-right',
            text: '{{session()->get('message')}}',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
    @endif

    var role_id = document.getElementById("role_id");
    role_id.onchange = function()  {
        var roleId = role_id.options[role_id.selectedIndex].value;
        
        $('#date_of_Joining_hide').show();
        if (roleId == 4 || roleId == '') {
            $('#date_of_Joining_hide').hide();
        }

        if (roleId == 4) {
            $('#clientIdList').show(); 
        } else {
            $('#clientIdList').hide();
        }

        if (roleId != 0) {
            $('#roleId').hide(); 
        } else {
            $('#roleId').show();
        }
    }

    var client_id = document.getElementById("client_id");
    client_id.onchange = function() {
        var clientId = client_id.options[client_id.selectedIndex].value;
        if (clientId != 0) {
            $('#clientId').hide(); 
        } else {
            $('#clientId').show();
        }
    }

    $(function() {
        $("#register-form").validate({
            rules: {
                mobile : {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
                role_id: {
                    required: true,
                },
                client_id: {
                    required: true,
                },
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                name: {
                    required: true,
                },
                
            },
            // Specify the validation error messages
            messages: {
                mobile: "<span class='text-danger'>The Mobile field is required.</span>",
                password: "<span class='text-danger'>The Password field is required.</span>",
                role_id: "<span class='text-danger'>Please Select Role</span>",
                client_id: "<span class='text-danger'>Please Select Client</span>",
                username: "<span class='text-danger'>The UserName field is required.</span>",
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

    function formValidation() {
        var clientId =  $('#client_id').val();
        var roleId =  $('#role_id').val();
        if (clientId == ""  || roleId== "") {
            if (clientId == "") {
                $('#clientId').show();
                //$('#clientId').html('Please Select Client.');
            }
            if (roleId == "") {
                $('#roleId').show();
                $('#roleId').html('Please Select Role.');
                return false;
            }
        } else {
            return true;
        }
    }
</script>
