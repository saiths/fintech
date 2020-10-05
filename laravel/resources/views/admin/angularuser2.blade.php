@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage User</h4>
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
                        <form id="register-form"  name="register_form" method="post"  enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="userId"  ng-model="userFormData.id">
                            <input type="hidden" name="userId"  ng-model="userFormData.role_id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label"> Full Name : </label>
                                        <div class="col-md-9">
                                           <input type="text" id="name" name="name" class="form-control borderred" id="inputEmail3" placeholder="Full Name" 
                                           ng-model="userFormData.name" >
                                           <span class="text-danger" id="emptyName"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Address : </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" style="border-radius: 4px;"  
                                            id="address" name="address" placeholder="Address" 
                                            ng-model="userFormData.address" >
                                            <span class="text-danger" id="emptyAddress"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Select Role : </label>
                                        <div class="col-md-9">
                                            <select class="select2 m-b-10 select2" id="role_id" name="role_id" style="width: 100%;height:50px;"  
                                                data-placeholder="Select Role">
                                                <!--<option value="" >Select Role</option>-->
                                                <?php 
                                                    $getRoleData = DB::select('SELECT * FROM role_master WHERE is_deleted_status = "N" ORDER BY role_name ASC ');
                                                ?>
                                                @if (!empty($getRoleData))
                                                    @foreach ($getRoleData as $role)  
                                                        <option value="{{$role->id}}"
                                                            @if (!empty($getEditUser->role_id))
                                                                {{ ($getEditUser->role_id == $role->id) ? 'selected=selected' : '' }}
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
                                            <span class="text-danger" id="emptyRoleId"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" id="clientIdList"  style="display: none;" >
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Select Client : </label>
                                        <div class="col-md-9">
                                            <select  id="client_id" name="client_id" class="select2 m-b-10 select2 abc" style="width: 100%;height:50px;"  >
                                                <!--<option value="">Select Client</option>-->
                                                <?php 
                                                    $getClientData = DB::select('SELECT * FROM client_master WHERE is_deleted_status = "N" ORDER BY name ASC');
                                                ?>
                                                @if (!empty($getClientData))
                                                    @foreach ($getClientData as $key=>$client)  
                                                        <option value="{{$client->id}}" 
                                                            @if (!empty($getEditUser->client_id))
                                                                {{ ($getEditUser->client_id == $client->id) ? 'selected=selected' : '' }}
                                                            @else
                                                                {{ (old('client_id') == $client->id) ? 'selected=selected' : '' }}
                                                                @if (!empty($registerUserPostData['client_id']))
                                                                    {{ ($registerUserPostData['client_id'] == $client->id) ? 'selected=selected' : '' }}
                                                                @else
                                                                    @if ($key == 0)
                                                                        {{'selected=selected'}}
                                                                    @endif        
                                                                @endif
                                                            @endif
                                                            >{{$client->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" id="emptyClientId"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">UserName : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" type="text" name="username" id="username" placeholder="UserName" ng-model="userFormData.username">
                                            <span class="text-danger" id="emptyUserName"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Password : </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control borderred" ng-model="userFormData.password" style="border:1px solid #e74a25!important" type="text" name="password" id="password"  placeholder="Password">
                                            <span class="text-danger" id="emptyPassword"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Email : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred"  type="text"  placeholder="Email" id="email" name="email" ng-model="userFormData.email">
                                            <span class="text-danger" id="emptyEmail"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Mobile : </label>
                                        <div class="col-md-9">
                                          <input class="form-control borderred" type="text" name="mobile" id="mobile"  
                                          placeholder="Mobile" maxlength="10" ng-model="userFormData.mobile">
                                            <span class="text-danger" id="emptyMobile"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                        DOB : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred_border" type="text"  placeholder="Date of Birth" 
                                            id="datepicker_date_of_birth" data-date-format="dd-mm-yyyy" 
                                            name="date_of_birth" ng-model="userFormData.date_of_birth">
                                            <span class="text-danger" id="emptyDateOfBirth"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" id="date_of_Joining_hide"  >
                                    <div class="form-group row">
                                            <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">DOJ : </label>
                                        <div class="col-md-9" >
                                            <input class="form-control borderred_border" type="text"  placeholder="Date of Joining"
                                            id="datepicker_date_of_Joining" data-date-format="dd-mm-yyyy" 
                                            name="date_of_joining" ng-model="userFormData.date_of_joining" >
                                            <span class="text-danger" id=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9">
                                            <button type="button" ng-if="!isInsert" ng-click="updateUserData(userFormData)" id="lorderId" class="btn btn-success">Update
                                            </button>
                                            <button type="button" ng-if="isInsert" id="lorderId"  ng-click="addUserData(userFormData)" class="btn btn-success">Save
                                            </button>
                                            <button type="button" ng-click="resetUserForm()" id="cancelId" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive" ng-init="fetchUserData()">
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%"
                                datatable="ng" dt-options="vm.dtOptions" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>UserName</th>
                                        <th>Role</th>
                                        <th>Client</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>DOJ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="user in userData">
                                        <?php 
                                        /*  <tr @if($user->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                            >*/
                                        ?>

                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ user.username }}</td>
                                        <td>@{{ user.role_name }}</td>
                                        <td>@{{ user.client_name }}</td>
                                        <td>@{{ user.email }}</td>
                                        <td>@{{ user.mobile }}</td>
                                        <td>@{{ user.date_of_joining }}</td>

                                        <td>
                                            <!--
                                            <div class="tooltip1">    
                                                <a href="#" ng-click="showUserData(user)" class="btn btn-xs btn-info"
                                                    style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                                </a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip1">
                                                <a href="#"  ng-click="deleteUserData(user.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
                                                    <i class="ti-trash" ></i> 
                                                </a>
                                                <span class="tooltiptext">Delete</span>
                                            </div>-->
                                            <a href="#" ng-click="showUserData(user)" class="btn btn-xs btn-info"
                                                style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                            </a>
                                        
                                            <a href="#"  ng-click="deleteUserData(user.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
                                                <i class="ti-trash" ></i> 
                                            </a>
                                        </td> 
                                    </tr>
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

@include('admin.common.script2')

<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   

    <script>
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
             
            $scope.userFormData = {};
            $scope.isInsert = true;
            
            $scope.fetchUserData = function() {
                $http.get("{{route('angularUser.view')}}").success(function(data) {
                    $scope.userData = data;
                });     
            };

            $scope.showUserData = function(data) {
                
                var name = $('#name').val(data.name);
                var name = $('#username').val(data.username);
                var email = $('#email').val(data.email);
                var mobile = $('#mobile').val(data.mobile);
                var password = $('#password').val(data.password);
                var address = $('#address').val(data.address);
                var date_of_joining = $('#datepicker_date_of_Joining').val(data.date_of_joining);
                var date_of_birth = $('#datepicker_date_of_birth').val(data.date_of_birth);
                
                if (data.role_id == 4) {
                    $('#clientIdList').show(); 
                    $('#date_of_Joining_hide').hide();
                } else {
                    $('#clientIdList').hide();
                    $('#date_of_Joining_hide').show();
                }
                
                $("#lorderId").hide();
                $("#cancelId").hide();
                
                $http({
                    method: "POST",
                    url:    "{{route('angularUserSelect.roleSelected')}}",
                    data: {
                        'role_id': data.role_id,
                    }   
                }).success(function(data) {
                    $('#role_id').html(data);
                    $("#lorderId").show();
                    $("#cancelId").show();
                    $("#cancelId").attr("disabled", false);
                    $scope.isInsert = false;
                });
                
                $http({
                    method: "POST",
                    url:    "{{route('angularUserSelect.clientSelected')}}",
                    data: {
                        'client_id': data.client_id,
                    }   
                }).success(function(data) {
                    $('.abc').html(data);    
                });
                
               
                $('#emptyName').hide();
                $('#emptyAddress').hide();
                $('#emptyRoleId').hide();
                $('#emptyUserName').hide();
                $('#emptyPassword').hide();
                $('#emptyEmail').hide();
                $('#emptyMobile').hide();
                $('#emptyClientId').hide();
                $scope.userFormData = angular.copy(data);
            };

            $scope.updateUserData = function(data) {

                var roleId = $('#role_id').val();
                var name = $('#name').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var DOJ = $('#date_of_joining').val();
                var DOB = $('#date_of_birth').val();
                var clientId = $('#client_id').val();
                
                if ((roleId == '' || roleId == null) ||  name == '' || email == '' || username == '' || password == '' || mobile == '') {

                    if (roleId == '' || roleId == null) {
                        $('#emptyRoleId').show();
                        $('#emptyRoleId').html('Please Select Role.');
                    } else {
                        $('#emptyRoleId').hide();
                    }

                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }

                    if (email == '') {
                        $('#emptyEmail').show();
                        $('#emptyEmail').html('Email field is Required.');
                    } else {
                        $('#emptyEmail').hide();
                    }

                    if (username == '') {
                        $('#emptyUserName').show();
                        $('#emptyUserName').html('UserName field is Required.');
                    } else {
                        $('#emptyUserName').hide();
                    }
                    
                    if (password == '') {
                        $('#emptyPassword').show();
                        $('#emptyPassword').html('Password field is Required.');
                    } else {
                        $('#emptyPassword').hide();
                    }

                    if (mobile == '') {
                        $('#emptyMobile').show();
                        $('#emptyMobile').html('Mobile field is Required.');
                    } else {
                        $('#emptyMobile').hide();
                    }

                    return false;

                } else if (email != '' || mobile != '') {
                    
                    var validEmail =  isEmail(email);
                    var validMobile =  isMobile(mobile);
                    
                    if (validEmail == false || validMobile == false) {
                        
                        if (validEmail == false) {
                            $('#emptyEmail').show();
                            $('#emptyEmail').html('Please enter a valid email address.');
                        } else {
                            $('#emptyEmail').hide();
                        }

                        if (validMobile == false) {
                            $('#emptyMobile').show();
                            $('#emptyMobile').html('Please enter 10 digit mobile number.');
                        } else {
                            $('#emptyMobile').hide();
                        }
                        return false;
                        
                    } else if (roleId == 4 && (clientId == '' || clientId == null))  {
                        
                        if (clientId == ''|| clientId == null) {
                            $('#emptyClientId').show();
                            $('#emptyClientId').html('Please Select Client.');
                        } else {
                            $('#emptyClientId').hide();
                        }
                        return false;

                    } else {
                        
                        data.role_id = roleId;
                        data.client_id = clientId;
                        
                        $('#emptyName').hide();
                        $('#emptyAddress').hide();
                        $('#emptyRoleId').hide();
                        $('#emptyUserName').hide();
                        $('#emptyPassword').hide();
                        $('#emptyEmail').hide();
                        $('#emptyMobile').hide();
                        $('#emptyClientId').hide();
                        
                        $("#lorderId").attr("disabled", true);
                        $("#cancelId").attr("disabled", true);
                        $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');

                        $http.post("{{route('angularUser.edit')}}",data).success(function(data) {
                            
                            if (data.emailText == 'emailText' || data.mobileText == 'mobileText') {
                                
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Update');
                                
                                if (data.emailText == 'emailText') {
                                    $('#emptyEmail').show();
                                    $('#emptyEmail').html('The Email has already been taken.');
                                } else {
                                    $('#emptyEmail').hide();
                                }
                                if (data.mobileText == 'mobileText') {
                                    $('#emptyMobile').show();
                                    $('#emptyMobile').html('The Mobile has already been taken.');
                                } else {
                                    $('#emptyMobile').hide();
                                }
                            
                                
                            } else {
                                
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                               // $("#lorderId").html('Save');
                                
                                $scope.isInsert = true;
                                $scope.userFormData = {};
                                $scope.fetchUserData();
                                setTimeout(function() {
                                    toastr.success(
                                        data.message, 'Success!',
                                        { 
                                            "closeButton": true,
                                            timeOut: 3000 
                                        }
                                    );
                                }, 1000);
                                $scope.resetUserForm();
                                
                            }

                        }); 
                    }
                }
            };

            $scope.addUserData = function(data) {
                
                var roleId = $('#role_id').val();
                var name = $('#name').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var DOJ = $('#date_of_joining').val();
                var DOB = $('#date_of_birth').val();
                var clientId = $('#client_id').val();
                
                if ((roleId == '' || roleId == null) ||  name == '' || email == '' || username == '' || password == '' || mobile == '') {

                    if (roleId == '' || roleId == null) {
                        $('#emptyRoleId').show();
                        $('#emptyRoleId').html('Please Select Role.');
                    } else {
                        $('#emptyRoleId').hide();
                    }

                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }

                    if (email == '') {
                        $('#emptyEmail').show();
                        $('#emptyEmail').html('Email field is Required.');
                    } else {
                        $('#emptyEmail').hide();
                    }

                    if (username == '') {
                        $('#emptyUserName').show();
                        $('#emptyUserName').html('UserName field is Required.');
                    } else {
                        $('#emptyUserName').hide();
                    }
                    
                    if (password == '') {
                        $('#emptyPassword').show();
                        $('#emptyPassword').html('Password field is Required.');
                    } else {
                        $('#emptyPassword').hide();
                    }

                    if (mobile == '') {
                        $('#emptyMobile').show();
                        $('#emptyMobile').html('Mobile field is Required.');
                    } else {
                        $('#emptyMobile').hide();
                    }

                    return false;

                } else if (email != '' || mobile != '') {

                    $('#emptyName').hide();
                    $('#emptyAddress').hide();
                    $('#emptyRoleId').hide();
                    $('#emptyUserName').hide();
                    $('#emptyPassword').hide();
                    $('#emptyEmail').hide();
                    $('#emptyMobile').hide();
                    
                    var validEmail =  isEmail(email);
                    var validMobile =  isMobile(mobile);

                    if (validEmail == false || validMobile == false) {
                        if (validEmail == false) {
                            $('#emptyEmail').show();
                            $('#emptyEmail').html('Please enter a valid email address.');
                        } else {
                            $('#emptyEmail').hide();
                        }

                        if (validMobile == false) {
                            $('#emptyMobile').show();
                            $('#emptyMobile').html('Please enter 10 digit mobile number.');
                        } else {
                            $('#emptyMobile').hide();
                        }
                        return false;
                        
                    }   else if (roleId == 4 && (clientId == '' || clientId == null))  {

                        if (clientId == ''|| clientId == null) {
                            $('#emptyClientId').show();
                            $('#emptyClientId').html('Please Select Client.');
                        } else {
                            $('#emptyClientId').hide();
                        }
                        return false;
                    
                    } else {
                        
                        data.client_id = clientId;
                        data.role_id = roleId;
                        $('#emptyName').hide();
                        $('#emptyAddress').hide();
                        $('#emptyRoleId').hide();
                        $('#emptyUserName').hide();
                        $('#emptyPassword').hide();
                        $('#emptyEmail').hide();
                        $('#emptyMobile').hide();
                        $('#emptyClientId').hide();
                        
                        $("#lorderId").attr("disabled", true);
                        $("#cancelId").attr("disabled", true);
                        $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                       
                        $http.post("{{route('angularUser.add')}}",data).success(function(data) {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            if (data.emailText == 'emailText' || data.mobileText == 'mobileText') {
                                
                                if (data.emailText == 'emailText') {
                                    $('#emptyEmail').show();
                                    $('#emptyEmail').html('The Email has already been taken.');
                                } else {
                                    $('#emptyEmail').hide();
                                }
                                if (data.mobileText == 'mobileText') {
                                    $('#emptyMobile').show();
                                    $('#emptyMobile').html('The Mobile has already been taken.');
                                } else {
                                    $('#emptyMobile').hide();
                                }
                            } else {
                                
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Save');
                                
                                $scope.userFormData = {};
                                $scope.fetchUserData();
                                setTimeout(function() {
                                    toastr.success(
                                        data.message, 'Success!',
                                        { 
                                            "closeButton": true,
                                            timeOut: 3000 
                                        }
                                    );
                                }, 1000);
                                $scope.resetUserForm();
                                $scope.isInsert = true;
                            }

                        }); 

                    }

                }
            };
            
            $scope.deleteUserData = function(id) {
                if (confirm("Are you Want to delete?") == true) {
                    $http({
                    method: "POST",
                    url:    "{{route('angularUser.delete')}}",
                    data: {'id': id} 
                    }).success(function(data) {
                        $scope.fetchUserData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetUserForm();
                    });
                } 
            };

            $scope.resetUserForm = function() {
                $scope.isInsert = true;
                $('#clientIdList').hide();
                $('#emptyName').hide();
                $('#emptyAddress').hide();
                $('#emptyRoleId').hide();
                $('#emptyUserName').hide();
                $('#emptyPassword').hide();
                $('#emptyEmail').hide();
                $('#emptyMobile').hide();
                $('#emptyClientId').hide();

                var name = $('#name').val('');
                var email = $('#email').val('');
                var mobile = $('#mobile').val('');
                var username = $('#username').val('');
                var password = $('#password').val('');
                var address = $('#address').val('');
                var DOJ = $('#datepicker_date_of_Joining').val('');
                var DOB = $('#datepicker_date_of_birth').val('');
                $('#date_of_Joining_hide').show();
                $('#role_id').val(['0']);
                $('#role_id').trigger('change');
                
                
                //$('#client_id').val(['0']);
                //$('#client_id').trigger('change');
            };
        });
    </script>

    <script>

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function isMobile(mobile) {
            if (mobile.length == 10) {
                return true;
            } else {
                return false;    
            }
        }

        //var role_id = document.getElementById("role_id");
        var roleId = $('#role_id').val();
            
        role_id.onchange = function()  {
            //var roleId = role_id.options[role_id.selectedIndex].value;
            var roleId = $('#role_id').val();
            $('#date_of_Joining_hide').show();
            /*
            if (roleId == 4 {
                $('#date_of_Joining_hide').hide();
            }*/
            
            if (roleId == 4) {
                $('#date_of_Joining_hide').hide();
                $('#clientIdList').show(); 
                //$('#client_id').val(['0']);
                //$('#client_id').trigger('change');
            } else {
                $('#clientIdList').hide();
            }

            /*if (roleId != 0) {
                $('#roleId').hide(); 
            } else {
                $('#roleId').show();
            }
            */
        }

        //var client_id = document.getElementById("client_id");
        var clientId = $('#client_id').val();
        client_id.onchange = function() {
            //var clientId = client_id.options[client_id.selectedIndex].value;
            var clientId = $('#client_id').val();
            if (clientId != 0) {
                $('#clientId').hide(); 
            } else {
                $('#clientId').show();
            }
        }
        </script>
    </body>
</html>