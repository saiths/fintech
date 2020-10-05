@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <form class="form" autocomplete="off" method="post">
                            <input type="hidden" name="userId"  ng-model="userFormData.id">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right  col-md-4 col-form-label"><b> User Type :</b> </label>
                                            <div class="col-md-8">
                                                <select class="form-control form-control" name="kt_select2_3_modal" 
                                                    id="kt_select2_3_modal_1" >
                                                    <option value="1"> Party </option>
                                                    <option value="2"> User </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="partyForm">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Party Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party Name" 
                                                name="party_name" id="party_name" ng-model="userFormData.party_name" />
                                                <span class="text-danger" id="emptyPartyName"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Party Address :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party Address" 
                                                id="party_address" name="party_address"  
                                                ng-model="userFormData.party_address" />
                                                <span class="text-danger" id="emptyPartyAddress"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Party Country :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party Country" 
                                                id="party_country" name="party_country"  
                                                ng-model="userFormData.party_country" />
                                                <span class="text-danger" id="emptyPartyCountry"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Party State :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party State" 
                                                name="party_state" id="party_state" ng-model="userFormData.party_state" />
                                                <span class="text-danger" id="emptyPartyState"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Party City :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party City" 
                                                name="party_city" id="party_city" ng-model="userFormData.party_city" />
                                                <span class="text-danger" id="emptyPartyCity"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Party Pincode :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party Pincode" 
                                                id="party_pincode" name="party_pincode"  
                                                ng-model="userFormData.party_pincode"  />
                                                <span class="text-danger" id="emptyPincode"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> 
                                            Party GST No :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party GST No" 
                                                name="party_gst_no" id="party_gst_no" ng-model="userFormData.party_gst_no" maxlength="10" />
                                                <span class="text-danger" id="emptyPartyGSTNo"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Party Credit Limit :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Party Credit Limit" 
                                                id="party_credit_limit" name="party_credit_limit"  
                                                ng-model="userFormData.party_credit_limit" />
                                                <span class="text-danger" id="emptyPartyCreditLimit"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> 
                                            Contact Person :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Contact Person" 
                                                name="contact_person" id="contact_person" ng-model="userFormData.contact_person" />
                                                <span class="text-danger" id="emptyContactPerson"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Contact Email :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Contact Email" 
                                                id="contact_email" name="contact_email"  
                                                ng-model="userFormData.contact_email" />
                                                <span class="text-danger" id="emptyContactEmail"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> 
                                            Contact Mobile No :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Contact Mobile No" 
                                                name="contact_mobile_no" id="contact_mobile_no" ng-model="userFormData.contact_mobile_no" maxlength="10" />
                                                <span class="text-danger" id="emptyContactMobileNo"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Contact Whatsapp No:</b>
                                            </label>

                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Contact Whatsapp No" 
                                                id="contact_whatsapp_no" name="contact_whatsapp_no" maxlength="10" 
                                                ng-model="userFormData.contact_whatsapp_no" />
                                                <span class="text-danger" id="contactWhatsappNo"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> 
                                            Transport Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Transport Name" 
                                                name="transport_name" id="transport_name" ng-model="userFormData.transport_name" />
                                                <span class="text-danger" id="emptyTransportName"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Transport Address :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Transport Address" 
                                                id="transport_address" name="transport_address"  
                                                ng-model="userFormData.transport_address" />
                                                <span class="text-danger" id="emptyTransportAddress"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> 
                                            Transport Email :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Transport Email" 
                                                name="transport_email" id="transport_email" ng-model="userFormData.transport_email" />
                                                <span class="text-danger" id="emptyTransportEmail"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Transport Mobile No :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Transport Mobile No" 
                                                id="transport_mobile_no" name="transport_mobile_no" maxlength="10" 
                                                ng-model="userFormData.transport_mobile_no" />
                                                <span class="text-danger" id="emptyTransportMobileNo"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> User Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="User Name" 
                                                name="username" id="username" ng-model="userFormData.username" />
                                                <span class="text-danger" id="emptyUserName"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Password :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" placeholder="Password" id="password" 
                                                name="password" maxlength="10" ng-model="userFormData.password" />
                                                <span class="text-danger" id="emptyPassword"></span>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Retype Password :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" placeholder="Retype Password" 
                                                id="retype_password" name="retype_password" maxlength="10" 
                                                ng-model="userFormData.retype_password" />
                                                <span class="text-danger" id="emptyRetypePassword"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="card-body" id="userForm" style="display: none;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Name" name="name" 
                                                id="name" ng-model="userFormData.name" />
                                                <span class="text-danger" id="emptyName"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> User Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="User Name" 
                                                name="username" id="username" ng-model="userFormData.username" />
                                                <span class="text-danger" id="emptyUserName"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Password :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" placeholder="Password" id="password" 
                                                name="password" maxlength="10" ng-model="userFormData.password" />
                                                <span class="text-danger" id="emptyPassword"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Retype Password :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" placeholder="Retype Password" 
                                                id="retype_password" name="retype_password" maxlength="10" 
                                                ng-model="userFormData.retype_password" />
                                                <span class="text-danger" id="emptyRetypePassword"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Mobile :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" maxlength="10" 
                                                onkeypress="return isNumber(event)"  placeholder="Mobile" 
                                                name="mobile" id="mobile" ng-model="userFormData.mobile" />
                                                <span class="text-danger" id="emptyMobile"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-1 col-form-label"></label>
                                            <div class="col-md-9">
                                                <button type="button" ng-if="!isInsert" ng-click="updateUserData(userFormData)" 
                                                    id="lorderId" class="btn btn-primary">Update
                                                </button>
                                                <button type="button" ng-if="isInsert" id="lorderId"  
                                                    ng-click="addUserData(userFormData)" class="btn btn-primary">Save
                                                </button>
                                                <button type="button" ng-click="resetUserForm()" id="cancelId" class="btn btn-dark">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

                <?php /*
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <form class="form">
                            <div class="card-body" ng-init="fetchUserData()">
                                <table class="table table-bordered table-hover table-checkable" datatable="ng" 
                                dt-options="vm.dtOptions">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>UserName</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="user in userData">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ user.name }}</td>
                                        <td>@{{ user.mobile }}</td>
                                        <td>@{{ user.username }}</td>
                                        <td>
                                            <a href="#" ng-click="showUserData(user)"> 
                                                <i class="text-dark-10 flaticon2-edit"></i>
                                            </a>
                                            <a href="#"  ng-click="deleteUserData(user.id)" >
                                                <i class="text-dark-10 flaticon2-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div> 
                
                */?>
            </div>
        </div>
    </div>
</div>

@include('admin.common.footer')
</div>
</div>
</div>
@include('admin.common.script')

<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   

<script type="text/javascript">
    
    $("#kt_select2_3_modal_1").on('change',function() {
        var getValue=$(this).val(); 
        if (getValue == 2) {
            $('#userForm').show();
            $('#partyForm').hide();
        } else {
            $('#partyForm').show();
            $('#userForm').hide();
        }
    });
    
    var app = angular.module("myApp", ['datatables']);
    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.userFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchUserData = function() {
            $http.get("{{route('user.view')}}").success(function(data) {
                $scope.userData = data;
            });     
        };

        $scope.showUserData = function(data) {

            $('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();  
            var name = $('#name').val(data.name);
            var name = $('#username').val(data.username);
            var email = $('#email').val(data.email);
            var mobile = $('#mobile').val(data.mobile);
            var password = $('#password').val(data.password);
            var password = $('#retype_password').val(data.password);
            $scope.userFormData = angular.copy(data);
            $scope.isInsert = false;

        };
        
        $scope.updateUserData = function(data) {

            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var retype_password = $('#retype_password').val();

            if (name == '' || username == '' || password == '' || mobile == '' || retype_password == '') {

                if (name == '') {
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                    $('#emptyName').hide();
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

                if (retype_password == '') {
                    $('#emptyRetypePassword').show();
                    $('#emptyRetypePassword').html('Retype Password field is Required.');
                } else {
                    $('#emptyRetypePassword').hide();
                }


                return false;


            } else if (password != retype_password) {
                
                $('#emptyRetypePassword').show();
                $('#emptyRetypePassword').html('Password and Retype password not match.');
                return false;

            }  else {   

                $('#emptyRetypePassword').hide();  
                $('#emptyName').hide();
                $('#emptyUserName').hide();
                $('#emptyPassword').hide();
                $('#emptyMobile').hide();
                
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
                
                $http.post("{{route('user.edit')}}",data).success(function(data) {
                    

                    if (data.userText == 'userText') {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Update');
                        


                        if (data.userText == 'userText') {
                            $('#emptyUserName').show();
                            $('#emptyUserName').html('The UserName has already been taken.');
                        } else {
                            $('#emptyUserName').hide();
                        }



                    } else {       

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
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
        };

        $scope.addUserData = function(data) {

            /* --------------------------- User Detail -----------------------------------*/
                
                var name = $('#name').val();
                var mobile = $('#mobile').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var retype_password = $('#retype_password').val();
                var userType = $('#kt_select2_3_modal_1').val();

                
            /* -------------------------- Party Detail   ------------------------------------*/

                var partyName = $('#party_name').val();
                var partyAddress = $('#party_address').val();
                var partyCity = $('#party_city').val();
                var partyCountry = $('#party_country').val();
                var partyState = $('#party_state').val();
                var partyPincode = $('#party_pincode').val();
                var partyGstNo = $('#party_gst_no').val();
                var partyCreditLimit = $('#party_credit_limit').val(); 

            /* --------------------------- ContactParson Detail   -----------------------------------*/

                var contactParson = $('#contact_person').val();
                var contactEmail = $('#contact_email').val();
                var contactMobileNo = $('#contact_mobile_no').val();
                var contactWhatsappNo = $('#contact_whatsapp_no').val();

            /* ---------------------------- Transport Detail  ----------------------------------*/

                var transportName = $('#transport_name').val();
                var transportAddress = $('#transport_address').val();
                var transportEmail = $('#transport_email').val();
                var transportMobileNo = $('#transport_mobile_no').val();




                
              //  if (name == '' || username == '' || password == '' || mobile == '' || retype_password == '') {

                    /* ------------------------- User Detail  ------------------------------*/

                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
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

                    if (retype_password == '') {
                        $('#emptyRetypePassword').show();
                        $('#emptyRetypePassword').html('Retype Password field is Required.');
                    } else {
                        $('#emptyRetypePassword').hide();
                    }


                    /*------------------------- Party Detail ----------------------------*/
/*
                    if (partyName == '') {
                        $('#emptyPartyName').show();
                        $('#emptyPartyName').html('Party Name field is Required.');
                    } else {
                        $('#emptyPartyName').hide();
                    }

                    if (partyAddress == '') {
                        $('#emptyPartyAddress').show();
                        $('#emptyPartyAddress').html('Party Address field is Required.');
                    } else {
                        $('#emptyPartyAddress').hide();
                    }

                    if (partyCountry == '') {
                        $('#emptyPartyCountry').show();
                        $('#emptyPartyCountry').html('Party Country field is Required.');
                    } else {
                        $('#emptyPartyCountry').hide();
                    }

                    if (partyCity == '') {
                        $('#emptyPartyCity').show();
                        $('#emptyPartyCity').html('Party City field is Required.');
                    } else {
                        $('#emptyPartyCity').hide();
                    }

                    if (partyState == '') {
                        $('#emptyPartyState').show();
                        $('#emptyPartyState').html('Party State field is Required.');
                    } else {
                        $('#emptyPartyState').hide();
                    }

                    if (partyPincode == '') {
                        $('#emptyPincode').show();
                        $('#emptyPincode').html('Party Pincode field is Required.');
                    } else {
                        $('#emptyPincode').hide();
                    }
                    
                    if (partyGstNo == '') {
                        $('#emptyPartyGSTNo').show();
                        $('#emptyPartyGSTNo').html('Party GST No field is Required.');
                    } else {
                        $('#emptyPartyGSTNo').hide();
                    }
                    

                    if (partyCreditLimit == '') {
                        $('#emptyPartyCreditLimit').show();
                        $('#emptyPartyCreditLimit').html('Party Credit Limit field is Required.');
                    } else {
                        $('#emptyPartyCreditLimit').hide();
                    }

                    if (contactParson == '') {
                        $('#emptyContactPerson').show();
                        $('#emptyContactPerson').html('Contact Person field is Required.');
                    } else {
                        $('#emptyContactPerson').hide();
                    }
                    
                    if (contactEmail == '') {
                        $('#emptyContactEmail').show();
                        $('#emptyContactEmail').html('Contact Email field is Required.');
                    } else {
                        $('#emptyContactEmail').hide();
                    }

                    if (contactMobileNo == '') {
                        $('#emptyContactMobileNo').show();
                        $('#emptyContactMobileNo').html('Contact Mobile No field is Required.');
                    } else {
                        $('#emptyContactMobileNo').hide();
                    }*/

                    /*------------------------  Transport Detail --------------------------------------------   */

/*                    if (transportName == '') {
                        $('#emptyTransportName').show();
                        $('#emptyTransportName').html('Transport Name field is Required.');
                    } else {
                        $('#emptyTransportName').hide();
                    }

                    if (transportAddress == '') {
                        $('#emptyTransportAddress').show();
                        $('#emptyTransportAddress').html('Transport Address field is Required.');
                    } else {
                        $('#emptyTransportAddress').hide();
                    }

                    if (transportEmail == '') {
                        $('#emptyTransportEmail').show();
                        $('#emptyTransportEmail').html('Transport Email field is Required.');
                    } else {
                        $('#emptyTransportEmail').hide();
                    }
                    
                    if (transportMobileNo == '') {
                        $('#emptyTransportMobileNo').show();
                        $('#emptyTransportMobileNo').html('Transport Mobile No field is Required.');
                    } else {
                        $('#emptyTransportMobileNo').hide();
                    }
*/
                 //   return false;



             //   } else if (password != retype_password) {
                    
               //     $('#emptyRetypePassword').show();
               //     $('#emptyRetypePassword').html('Password and Retype password not match.');
               //     return false;

                //}  else {   


                    $('#emptyRetypePassword').hide();  
                    $('#emptyName').hide();
                    $('#emptyUserName').hide();
                    $('#emptyPassword').hide();
                    $('#emptyMobile').hide();

                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    

                var name = $('#name').val();
                var mobile = $('#mobile').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var retype_password = $('#retype_password').val();
                var userType = $('#kt_select2_3_modal_1').val();

                

                    data.user_type = userType;
                    


                    
                    $http.post("{{route('user.add')}}",data).success(function(data) {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');

                        if (data.userText != 0) {
                            
                            if (data.userText == 2) {

                                if (data.userText == 'userText') {
                                    $('#emptyUserName').show();
                                    $('#emptyUserName').html('The User Name has already been taken.');
                                } else {
                                    $('#emptyUserName').hide();
                                }

                            } else {
                                if (data.userText == 'userText') {
                                    $('#emptyPartyName').show();
                                    $('#emptyPartyName').html('The Party Name has already been taken.');
                                } else {
                                    $('#emptyPartyName').hide();
                                }
                                

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
                
              //  }
        };

        $scope.deleteUserData = function(id) {
            if (confirm("Are you Want to delete?") == true) {
                $http({
                method: "POST",
                url:    "{{route('user.delete')}}",
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
            $('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();

            var name = $('#name').val('');
            var mobile = $('#mobile').val('');
            var username = $('#username').val('');
            var password = $('#password').val('');
            var password = $('#retype_password').val('');

        };

    });


</script>


</body>
</html>

