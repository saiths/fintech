@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                @if(!empty($getUserDataByID))
                    @foreach ($getUserDataByID as $getUserData)
                    @endforeach
                @endif
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--<form class="form" autocomplete="off" method="post" action="{{ route('user.edit') }}" 
                            onsubmit="return formValidation(this)">
                        -->    
                        
                        <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                        enctype="multipart/form-data" autocomplete="off">
                        
                            
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="userId" id="userId" value="{{$getUserData->id}}">
                            <input type="hidden" name="user_type" id="user_type" value="{{$getUserData->user_type}}">
                            
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right  col-md-4 col-form-label"><b> User Type :</b> </label>
                                            <div class="col-md-8">
                                                <select class="form-control form-control" name="user_type" id="kt_select2_3_modal_1" disabled >
                                                    <option value="1" <?php if ($getUserData->user_type == 1) {
                                                    echo 'selected=selected';
                                                } ?>> Party </option>
                                                    <option value="2" <?php if ($getUserData->user_type == 2) {
                                                    echo 'selected=selected';
                                                } 
                                                 ?> > User </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-8 col-form-label"></label>
                                            <div class="col-md-4">

                                                <a href="{{route('user')}}" class="btn btn btn-success  font-weight-bolder text-left">
                                                    Back >>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($getUserDataByID[0]->user_type == 1)
                            
                                <div class="card-body" style="margin-top: -60px;" id="partyForm">
                                    <h5>Party Detail : </h5>
                                    <hr>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b>Name :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control abc" placeholder="Name" 
                                                    name="party_name" id="party_name"  value="{{!empty($getUserData->party_name) ? $getUserData->party_name:''}}" />
                                                    <span class="text-danger" id="emptyPartyName"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Address :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="1" id="party_address" 
                                    name="party_address" placeholder="Address" >{{!empty($getUserData->party_address) ? $getUserData->party_address:''}}</textarea>
        
                                                           
                                                    <span class="text-danger" id="emptyPartyAddress"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Country :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Country" 
                                                    id="party_country" name="party_country"  
                                                    
                                        value="{{!empty($getUserData->party_country) ? $getUserData->party_country:''}}" 
        
                                        />
                                                    <span class="text-danger" id="emptyPartyCountry"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b>State :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="State" 
                                                    name="party_state" id="party_state"
                                                    value="{{!empty($getUserData->party_state) ? $getUserData->party_state:''}}" />
                                                    <span class="text-danger" id="emptyPartyState"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b>City :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control abc" placeholder="City" 
                                                    name="party_city" id="party_city"  
                                                    value="{{!empty($getUserData->party_city) ? $getUserData->party_city:''}}"/>
                                                    <span class="text-danger" id="emptyPartyCity"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Pincode :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Pincode" 
                                                    id="party_pincode" name="party_pincode"  
                                                     onkeypress="return isNumber(event)" value="{{!empty($getUserData->party_pincode) ? $getUserData->party_pincode:''}}" />
                                                    <span class="text-danger" id="emptyPincode"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> 
                                                GST No :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="GST No" 
                                                    name="party_gst_no" id="party_gst_no" 
                                                    value="{{!empty($getUserData->party_gst_no) ? $getUserData->party_gst_no:''}}" onkeypress="return isNumber(event)"/>
                                                    <span class="text-danger" id="emptyPartyGSTNo"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Credit Limit :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Credit Limit" 
                                                    id="party_credit_limit" name="party_credit_limit"  
                                                     onkeypress="return isNumber(event)" value="{{!empty($getUserData->party_credit_limit) ? $getUserData->party_credit_limit:''}}" />
                                                    <span class="text-danger" id="emptyPartyCreditLimit"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="card-body" style="margin-top: -60px;" id="contactForm">
                                    <h5>Contact Detail : </h5>
                                    <hr>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> 
                                                Person :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control abc" placeholder="Person" 
                                                    name="contact_person" id="contact_person" 
                                                    value="{{!empty($getUserData->contact_person) ? $getUserData->contact_person:''}}"/>
                                                    <span class="text-danger" id="emptyContactPerson"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b> Email :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Email" 
                                                    id="contact_email" name="contact_email" onblur="validateEmail(this);"
                                                    value="{{!empty($getUserData->contact_email) ? $getUserData->contact_email:''}}"  
                                                     />
                                                    <span class="text-danger" id="emptyContactEmail"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> 
                                                Mobile :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control abc" placeholder="Mobile" 
                                                    name="contact_mobile_no" id="contact_mobile_no" 
                                                     maxlength="10" 
                                                    onkeypress="return isNumber(event)"
                                                    value="{{!empty($getUserData->contact_mobile_no) ? $getUserData->contact_mobile_no:''}}" 
                                                     />
                                                    <span class="text-danger" id="emptyContactMobileNo"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Whatsapp :</b>
                                                </label>
        
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Whatsapp Mobile" 
                                                    id="contact_whatsapp_no" name="contact_whatsapp_no" maxlength="10" 
                                                    onkeypress="return isNumber(event)" 
                                                    value="{{!empty($getUserData->contact_whatsapp_no) ? $getUserData->contact_whatsapp_no:''}}"
                                                    />
                                                    <span class="text-danger" id="emptyContactWhatsappNo"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="card-body" style="margin-top: -60px;" id="transportForm">
                                    <h5>Transport Detail : </h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> 
                                                Name :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Name" 
                                                    name="transport_name" id="transport_name" 
                                        value="{{!empty($getUserData->transport_name) ? $getUserData->transport_name:''}}"
                                                     />
                                                    <span class="text-danger" id="emptyTransportName"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Address :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="1" id="transport_address" 
                                                    name="transport_address" placeholder="Address"
                                                      value="{{!empty($getUserData->transport_address) ? $getUserData->transport_address:''}}" >{{!empty($getUserData->transport_address) ? $getUserData->transport_address:''}}</textarea>
                                                    <span class="text-danger" id="emptyTransportAddress"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> 
                                                Email :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Email" 
                                                    name="transport_email" id="transport_email" onblur="validateEmail(this);"
        
                                    value="{{!empty($getUserData->transport_email) ? $getUserData->transport_email:''}}"
                                    />
                                                    <span class="text-danger" id="emptyTransportEmail"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label">
                                                    <b>Mobile :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" placeholder="Mobile" 
                                                    id="transport_mobile_no" name="transport_mobile_no" maxlength="10" 
                                                     onkeypress="return isNumber(event)" value="{{!empty($getUserData->transport_mobile_no) ? $getUserData->transport_mobile_no:''}}"  />
                                                    <span class="text-danger" id="emptyTransportMobileNo"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body" style="margin-top: -60px;" id="userForm1">
                                    <h5>User Detail : </h5>
                                    <hr>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b> User Name :</b> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control abc" placeholder="User Name" 
                                                    name="uusername" id="uusername"  
                                                    value="{{!empty($getUserData->username) ? $getUserData->username:''}}"  />
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
                                                    <input type="password" class="form-control abc" placeholder="Password" id="password" name="password" maxlength="10"   
                                                value="{{!empty($getUserData->password) ? base64_decode($getUserData->password):''}}"/>
                                                    <span class="text-danger" id="emptyPassword"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-4 col-form-label"><b>
                                                Retype :</b>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="password" class="form-control abc" placeholder="Retype Password" 
                                                    id="retype_password" name="retype_password" maxlength="10" value="{{!empty($getUserData->password) ? base64_decode($getUserData->password):''}}"/>
                                                    <span class="text-danger" id="emptyRetypePassword"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @else
                            
                                <div class="card-body" id="userForm" style="margin-top: -60px;" >

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control abc" placeholder="Name" name="uname" 
                                                id="uname"  value="{{!empty($getUserData->name) ? $getUserData->name:''}}"
                                                 />
                                                <span class="text-danger" id="emptyNames"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b> User Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control abc" placeholder="User Name" 
                                                name="username" id="username"  
                                                value="{{!empty($getUserData->username) ? $getUserData->username:''}}" />
                                                <span class="text-danger" id="emptyUserNames"></span>
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
                                                <input type="password" class="form-control abc" placeholder="Password" id="upassword" name="upassword" maxlength="10"  
                                                    value="{{!empty($getUserData->password) ? base64_decode($getUserData->password):''}}" />
                                                <span class="text-danger" id="emptyPasswords"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Retype :</b>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control abc" placeholder="Retype Password" 
                                                id="uretype_password" name="uretype_password" maxlength="10" 
                                                value="{{!empty($getUserData->password) ? base64_decode($getUserData->password):''}}" />
                                                <span class="text-danger" id="emptyRetypePasswords"></span>
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
                                                <input type="text" class="form-control abc" maxlength="10" 
                                                onkeypress="return isNumber(event)"  placeholder="Mobile" 
                                                name="umobile" id="umobile" value="{{!empty($getUserData->mobile) ? $getUserData->mobile:''}}" />
                                                <span class="text-danger" id="emptyMobiles"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @endif

                            <div class="card-body" style="margin-top: -60px;" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"></label>
                                            <div class="col-md-8">
                                                <button type="submit"  id="lorderId" class="btn btn-primary">Update</button>
                                                 
                                                <!-- <button type="button" ng-if="isInsert" id="lorderId"  
                                                    ng-click="addUserData(userFormData)" class="btn btn-primary">Save
                                                </button>
                                                 -->
                                                 <button type="button" ng-click="resetUserForm()" id="cancelId" class="btn btn-dark">Cancel</button>

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
    
    $("#contact_mobile_no").on('keyup', function(e) {
        var contact_mobile_no = $('#contact_mobile_no').val();
        var contact_whatsapp_no = $('#contact_whatsapp_no').val(contact_mobile_no);
        $('#emptyName').hide();
        $('#emptyUserName').hide();
        $('#emptyPassword').hide();
        $('#emptyMobile').hide();
        $('#emptyRetypePassword').hide();
        $('#emptyContactPerson').hide();
    });
    
    function validateEmail(emailField)  {

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var contact_email = $('#contact_email').val();
        var transport_email = $('#transport_email').val();
        
        if (reg.test(emailField.value) == false && contact_email != '' && transport_email == '') 
        {   
            
            $('#emptyContactEmail').show();
            $('#emptyContactEmail').html('Please insert a valid email address.'); 
            $("#lorderId").attr("disabled", true);
            $('#contact_email').css('border-color', 'red');
            return false;
       
        } else if (reg.test(emailField.value) == false && transport_email != '' && contact_email == '') {   
            
            $('#emptyTransportEmail').show();
            $('#emptyTransportEmail').html('Please insert a valid email address.');
            $("#lorderId").attr("disabled", true);
            $('#transport_email').css('border-color', 'red');
            return false;

        }  else if (reg.test(emailField.value) == false && transport_email != '' && contact_email != '') {   
            
            $('#emptyTransportEmail').show();
            $('#emptyTransportEmail').html('Please insert a valid email address.');
            $("#lorderId").attr("disabled", true);
            $('#transport_email').css('border-color', 'red');
            $('#emptyTransportEmail').show();
            $('#emptyTransportEmail').html('Please insert a valid email address.');
            $("#lorderId").attr("disabled", true);
            $('#transport_email').css('border-color', 'red');
            return false;

        } else {

            $('#emptyContactEmail').hide();
            $("#lorderId").attr("disabled", false);
            $('#contact_email').css('border-color', '#E4E6EF');

            $('#emptyTransportEmail').hide();
            $("#lorderId").attr("disabled", false);
            $('#transport_email').css('border-color', '#E4E6EF');
            return true;
        }
    }

    
    
    $("#kt_select2_3_modal_1").on('change',function() {
        var getValue=$(this).val(); 

        if (getValue == 2) {

            $('#partyForm').hide();
            $('#contactForm').hide();
            $('#transportForm').hide();
            $('#userForm1').hide();
            $('#userForm').show();

            $('#emptyPartyName').hide();  
            $('#emptyPartyCity').hide();
            $('#emptyContactEmail').hide();
            $('#emptyContactMobileNo').hide();
            $('#emptyContactPerson').hide();
            
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyRetypePassword').hide();
            $('#emptyContactWhatsappNo').hide();

            $('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();

        } else {

            $('#partyForm').show();
            $('#contactForm').show();
            $('#transportForm').show();
            $('#userForm1').show();
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
            
            var partyName = $('#party_name').val();
            var partyCity = $('#party_city').val();
            var contactPerson = $('#contact_person').val();
            var userType = $('#kt_select2_3_modal_1').val();
            var contactEmail = $('#contact_email').val();
            var contactMobileNo = $('#contact_mobile_no').val();
            var contactWhatsappNo = $('#contact_whatsapp_no').val();            
            
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var username = $('#username').val();
            var password = $('#password').val();
            
            var retype_password = $('#retype_password').val();
            var userId = $('#userId').val();
                
            if (userType == 1) {                            

                if (partyName == '' || partyCity == '' || contactEmail == '' || contactPerson == '' || 
                contactMobileNo == '' || contactWhatsappNo == '' ||  username == '' || password == '' || 
                retype_password == '') {

                    if (partyName == '') {
                        $('#emptyPartyName').show();
                        $('#emptyPartyName').html('Name field is Required.');
                    } else {
                        $('#emptyPartyName').hide();
                    }

                    if (partyCity == '') {
                        $('#emptyPartyCity').show();
                        $('#emptyPartyCity').html('City field is Required.');
                    } else {
                        $('#emptyPartyCity').hide();
                    }

                    if (contactEmail == '') {
                        $('#emptyContactEmail').show();
                        $('#emptyContactEmail').html('Email field is Required.');
                    } else {
                        $('#emptyContactEmail').hide();
                    }

                    if (contactPerson == '') {
                        $('#emptyContactPerson').show();
                        $('#emptyContactPerson').html('Person field is Required.');
                    } else {
                        $('#emptyContactPerson').hide();
                    }
                    
                    if (contactMobileNo == '') {
                        $('#emptyContactMobileNo').show();
                        $('#emptyContactMobileNo').html('Mobile field is Required.');
                    } else {
                        $('#emptyContactMobileNo').hide();
                    }

                    if (contactWhatsappNo == '') {
                        $('#emptyContactWhatsappNo').show();
                        $('#emptyContactWhatsappNo').html('Whatsapp Mobile field is Required.');
                    } else {
                        $('#emptyContactWhatsappNo').hide();
                    }
                    
                    if (username == '') {
                        $('#emptyUserName').show();
                        $('#emptyUserName').html('User Name field is Required.');
                    } else {
                        $('#emptyUserName').hide();
                    }

                    if (password == '') {
                        $('#emptyPassword').show();
                        $('#emptyPassword').html('Password field is Required.');
                    } else {
                        $('#emptyPassword').hide();
                    }

                    if (retype_password == '') {
                        $('#emptyRetypePassword').show();
                        $('#emptyRetypePassword').html('Retype Password field is Required.');
                    } else {
                        $('#emptyRetypePassword').hide();
                    }  

                    return false;
                
                } else {
                    
                    $('#emptyPartyName').hide();  
                    $('#emptyPartyCity').hide();
                    $('#emptyContactEmail').hide();
                    $('#emptyContactMobileNo').hide();
                    $('#emptyContactWhatsappNo').hide();

                    $('#emptyName').hide();  
                    $('#emptyUserName').hide();
                    $('#emptyPassword').hide();
                    $('#emptyMobile').hide();
                    $('#emptyRetypePassword').hide();


                    /*$("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    */
                    
                    data.user_type = userType;


                    $http.post("{{route('user.edit')}}",data).success(function(data) {



                    //    console.log(data);
                       // alert(data.userText);

                        //if (data.userText == 'userText' ||  data.partyText == 'partyText') {

                            if (data.userText == 'partyText') {

                                        
/*                                if (data.userText == 'userText') {

                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                    
                                    if (data.userText == 'userText') {
                                        $('#emptyUserName').show();
                                        $('#emptyUserName').html('The User Name has already been taken.');
                                    } else {
                                        $('#emptyUserName').hide();
                                    }

                                } else {
*/                                      

                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                
                                        
                                    if (data.partyText == 'partyText') {
                                        $('#emptyPartyName').show();
                                        $('#emptyPartyName').html('The Party Name has already been taken.');

                                    } else {

                                        $('#emptyPartyName').hide();
                                    }


                                    
                              //  } 

                                    

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

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');

                    
                    });
                    
                }


            } else if (userType == 2) {
                
                if (name == '' || username == '' || password == '' || mobile == ''  || retype_password == '') {

                    if (name == '') {
                        $('#emptyNames').show();
                        $('#emptyNames').html('Name field is Required.');
                    } else {
                        $('#emptyNames').hide();
                    }

                    if (username == '') {
                        $('#emptyUserNames').show();
                        $('#emptyUserNames').html('User Name field is Required.');
                    } else {
                        $('#emptyUserNames').hide();
                    }

                    if (password == '') {
                        $('#emptyPasswords').show();
                        $('#emptyPasswords').html('Password field is Required.');
                    } else {
                        $('#emptyPasswords').hide();
                    }

                    if (mobile == '') {
                        $('#emptyMobiles').show();
                        $('#emptyMobiles').html('Mobile field is Required.');
                    } else {
                        $('#emptyMobiles').hide();
                    }

                    if (retype_password == '') {
                        $('#emptyRetypePasswords').show();
                        $('#emptyRetypePasswords').html('Retype Password field is Required.');
                    } else {
                        $('#emptyRetypePasswords').hide();
                    }      
                    return false;

                } else {
                
                    $('#emptyNames').hide();  
                    $('#emptyUserNames').hide();
                    $('#emptyPasswords').hide();
                    $('#emptyMobiles').hide();
                    $('#emptyRetypePasswords').hide();

/*                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
*/
                    data.user_type = userType;

                    $http.post("{{route('user.edit')}}",data).success(function(data) {


                        if (data.userText == 'userText') {

                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            if (data.userText == 'userText') {
                                $('#emptyUserNames').show();
                                $('#emptyUserNames').html('The User Name has already been taken.');
                            } else {
                                $('#emptyUserNames').hide();
                            }


                    //    } else {
                              
                      //      $("#lorderId").attr("disabled", false);
                       //     $("#cancelId").attr("disabled", false);
                        //    $("#lorderId").html('Save');
                        
                                
                            /*if (data.partyText == 'partyText') {
                                $('#emptyPartyName').show();
                                $('#emptyPartyName').html('The Party Name has already been taken.');

                            } else {

                                $('#emptyPartyName').hide();
                            }
                            */
                            
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

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');

                    });
                }
            }
        };
        
        $scope.addUserData = function(data) {

            var partyName = $('#party_name').val();
            var partyCity = $('#party_city').val();
            var contactPerson = $('#contact_person').val();
            var userType = $('#kt_select2_3_modal_1').val();
            var contactEmail = $('#contact_email').val();
            var contactMobileNo = $('#contact_mobile_no').val();
            var contactWhatsappNo = $('#contact_whatsapp_no').val();            
            
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var retype_password = $('#retype_password').val();

            if (userType == 1) {                            

                if (partyName == '' || partyCity == '' || contactEmail == '' || contactPerson == '' || contactMobileNo == '' || contactWhatsappNo == '' ||  username == '' || password == '' || retype_password == '') {

                    if (partyName == '') {
                        $('#emptyPartyName').show();
                        $('#emptyPartyName').html('Name field is Required.');
                    } else {
                        $('#emptyPartyName').hide();
                    }

                    if (partyCity == '') {
                        $('#emptyPartyCity').show();
                        $('#emptyPartyCity').html('City field is Required.');
                    } else {
                        $('#emptyPartyCity').hide();
                    }

                    if (contactEmail == '') {
                        $('#emptyContactEmail').show();
                        $('#emptyContactEmail').html('Email field is Required.');
                    } else {
                        $('#emptyContactEmail').hide();
                    }

                    if (contactPerson == '') {
                        $('#emptyContactPerson').show();
                        $('#emptyContactPerson').html('Person field is Required.');
                    } else {
                        $('#emptyContactPerson').hide();
                    }
                    
                    if (contactMobileNo == '') {
                        $('#emptyContactMobileNo').show();
                        $('#emptyContactMobileNo').html('Mobile field is Required.');
                    } else {
                        $('#emptyContactMobileNo').hide();
                    }

                    if (contactWhatsappNo == '') {
                        $('#emptyContactWhatsappNo').show();
                        $('#emptyContactWhatsappNo').html('Whatsapp Mobile field is Required.');
                    } else {
                        $('#emptyContactWhatsappNo').hide();
                    }
                    
                    if (username == '') {
                        $('#emptyUserName').show();
                        $('#emptyUserName').html('User Name field is Required.');
                    } else {
                        $('#emptyUserName').hide();
                    }

                    if (password == '') {
                        $('#emptyPassword').show();
                        $('#emptyPassword').html('Password field is Required.');
                    } else {
                        $('#emptyPassword').hide();
                    }

                    if (retype_password == '') {
                        $('#emptyRetypePassword').show();
                        $('#emptyRetypePassword').html('Retype Password field is Required.');
                    } else {
                        $('#emptyRetypePassword').hide();
                    }  

                    return false;
                
                } else {
                    
                    $('#emptyPartyName').hide();  
                    $('#emptyPartyCity').hide();
                    $('#emptyContactEmail').hide();
                    $('#emptyContactMobileNo').hide();
                    $('#emptyContactWhatsappNo').hide();

                    $('#emptyName').hide();  
                    $('#emptyUserName').hide();
                    $('#emptyPassword').hide();
                    $('#emptyMobile').hide();
                    $('#emptyRetypePassword').hide();


                    /*$("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    */
                    
                    data.user_type = userType;

                    $http.post("{{route('user.add')}}",data).success(function(data) {



                    //    console.log(data);
                       // alert(data.userText);

                        //if (data.userText == 'userText' ||  data.partyText == 'partyText') {

                            if (data.userText == 'partyText') {

                                        
/*                                if (data.userText == 'userText') {

                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                    
                                    if (data.userText == 'userText') {
                                        $('#emptyUserName').show();
                                        $('#emptyUserName').html('The User Name has already been taken.');
                                    } else {
                                        $('#emptyUserName').hide();
                                    }

                                } else {
*/                                      

                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                
                                        
                                    if (data.partyText == 'partyText') {
                                        $('#emptyPartyName').show();
                                        $('#emptyPartyName').html('The Party Name has already been taken.');

                                    } else {

                                        $('#emptyPartyName').hide();
                                    }


                                    
                              //  } 

                                    

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

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');

                    
                    });
                    
                }


            } else if (userType == 2) {
                
                if (name == '' || username == '' || password == '' || mobile == ''  || retype_password == '') {

                    if (name == '') {
                        $('#emptyNames').show();
                        $('#emptyNames').html('Name field is Required.');
                    } else {
                        $('#emptyNames').hide();
                    }

                    if (username == '') {
                        $('#emptyUserNames').show();
                        $('#emptyUserNames').html('User Name field is Required.');
                    } else {
                        $('#emptyUserNames').hide();
                    }

                    if (password == '') {
                        $('#emptyPasswords').show();
                        $('#emptyPasswords').html('Password field is Required.');
                    } else {
                        $('#emptyPasswords').hide();
                    }

                    if (mobile == '') {
                        $('#emptyMobiles').show();
                        $('#emptyMobiles').html('Mobile field is Required.');
                    } else {
                        $('#emptyMobiles').hide();
                    }

                    if (retype_password == '') {
                        $('#emptyRetypePasswords').show();
                        $('#emptyRetypePasswords').html('Retype Password field is Required.');
                    } else {
                        $('#emptyRetypePasswords').hide();
                    }      
                    return false;

                } else {
                
                    $('#emptyNames').hide();  
                    $('#emptyUserNames').hide();
                    $('#emptyPasswords').hide();
                    $('#emptyMobiles').hide();
                    $('#emptyRetypePasswords').hide();

/*                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
*/
                    data.user_type = userType;

                    $http.post("{{route('user.add')}}",data).success(function(data) {


                        if (data.userText == 'userText') {

                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            if (data.userText == 'userText') {
                                $('#emptyUserNames').show();
                                $('#emptyUserNames').html('The User Name has already been taken.');
                            } else {
                                $('#emptyUserNames').hide();
                            }


                    //    } else {
                              
                      //      $("#lorderId").attr("disabled", false);
                       //     $("#cancelId").attr("disabled", false);
                        //    $("#lorderId").html('Save');
                        
                                
                            /*if (data.partyText == 'partyText') {
                                $('#emptyPartyName').show();
                                $('#emptyPartyName').html('The Party Name has already been taken.');

                            } else {

                                $('#emptyPartyName').hide();
                            }
                            */
                            
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

                        
                        

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');

                    });
                }
            }
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
            
            $('#emptyPartyName').hide();  
            $('#emptyPartyCity').hide();
            $('#emptyContactEmail').hide();
            $('#emptyContactMobileNo').hide();
            $('#emptyContactWhatsappNo').hide();

            $('#emptyNames').hide();  
            $('#emptyUserNames').hide();
            $('#emptyPasswords').hide();
            $('#emptyMobiles').hide();
            $('#emptyRetypePasswords').hide();

            var partyName = $('#party_name').val('');
            var contactEmail = $('#contact_email').val('');
            var contactMobileNo = $('#contact_mobile_no').val('');
            var contactWhatsappNo = $('#contact_whatsapp_no').val('');
            var partyName = $('#party_address').val('');
            var partyCity = $('#party_country').val('');

            $('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();
            $('#emptyContactPerson').hide();
            
            var name = $('#name').val('');
            var mobile = $('#mobile').val('');
            var username = $('#username').val('');
            var password = $('#password').val('');
            var password = $('#retype_password').val('');
        };
        
    });
    
        $("#lorderId").click(function (e) {

             e.preventDefault();

    
            var userType = $('#user_type').val();
            var userId = $('#userId').val();
            var _token = $('#_token').val();
            
            //alert(userType);
            
            
            if (userType == 1) {                            
                var partyName = $('#party_name').val();
                var partyAddress = $('#party_address').val();
                var partyState = $('#party_state').val();
                var partyCity = $('#party_city').val();
                var partyCountry = $('#party_country').val();
                var partyState = $('#party_state').val();
                var pincode = $('#party_pincode').val();
                var party_gst_no = $('#party_gst_no').val();
                var party_credit_limit = $('#party_credit_limit').val();

                var contactPerson = $('#contact_person').val();
                var contactEmail = $('#contact_email').val();
                var contactMobileNo = $('#contact_mobile_no').val();
                var contactWhatsappNo = $('#contact_whatsapp_no').val();    

                var transport_name = $('#transport_name').val();
                var transport_address = $('#transport_address').val();
                var transport_email = $('#transport_email').val();
                var transport_mobile_no = $('#transport_mobile_no').val();

                var uusername = $('#uusername').val();
                
                var password = $('#password').val();
                var retype_password = $('#retype_password').val();


                                

                if (partyName == '' || partyCity == '' || contactPerson == '' || contactMobileNo == '' ||   uusername == '' || password == '' || retype_password == '') {

                    
               // if (partyName == '' || partyCity == '' || contactPerson == '' || contactMobileNo == '' || contactWhatsappNo == '' ||  uusername == '' || password == '' || retype_password == '') {

                    if (partyName == '') {
                        $('#party_name').css('border-color', 'red');
                        $('#emptyPartyName').show();
                        $('#emptyPartyName').html('Name field is Required.');
                    } else {
                       // $('#party_name').css('border-color', '#E4E6EF');
                        $('#emptyPartyName').hide();
                    }

                    if (partyCity == '') {
                        $('#party_city').css('border-color', 'red');
                        $('#emptyPartyCity').show();
                        $('#emptyPartyCity').html('City field is Required.');
                    } else {
                       // $('#party_city').css('border-color', '#E4E6EF');
                        $('#emptyPartyCity').hide();
                    }

                    if (contactPerson == '') {
                        $('#contact_person').css('border-color', 'red');
                        $('#emptyContactPerson').show();
                        $('#emptyContactPerson').html('Person field is Required.');
                    } else {
                       // $('#contact_person').css('border-color', '#E4E6EF');
                        $('#emptyContactPerson').hide();
                    }
                    
                    if (contactMobileNo == '') {
                        $('#contact_mobile_no').css('border-color', 'red');
                        $('#emptyContactMobileNo').show();
                        $('#emptyContactMobileNo').html('Mobile field is Required.');
                    } else {
                      //  $('#contact_mobile_no').css('border-color', '#E4E6EF');
                        $('#emptyContactMobileNo').hide();
                    }

                    /*if (contactWhatsappNo == '') {
                        $('#contact_whatsapp_no').css('border-color', 'red');
                        $('#emptyContactWhatsappNo').show();
                        $('#emptyContactWhatsappNo').html('Whatsapp Mobile field is Required.');
                    } else {
                        $('#contact_whatsapp_no').css('border-color', '#E4E6EF');
                        $('#emptyContactWhatsappNo').hide();
                    }
                    */
                    
                    if (uusername == '') {
                        $('#uusername').css('border-color', 'red');
                        $('#emptyUserName').show();
                        $('#emptyUserName').html('User Name field is Required.');
                    } else {
                       // $('#uusername').css('border-color', '#E4E6EF');
                        $('#emptyUserName').hide();
                    }

                    if (password == '') {
                        $('#password').css('border-color', 'red');
                        $('#emptyPassword').show();
                        $('#emptyPassword').html('Password field is Required.');
                    } else {
                       // $('#password').css('border-color', '#E4E6EF');
                        $('#emptyPassword').hide();
                    }

                    if (retype_password == '') {
                        $('#retype_password').css('border-color', 'red');
                        $('#emptyRetypePassword').show();
                        $('#emptyRetypePassword').html('Retype Password field is Required.');
                    } else {
                        //$('#retype_password').css('border-color', '#E4E6EF');
                        $('#emptyRetypePassword').hide();
                    } 
                    return false;


                }  else if (password != retype_password) {


                    $('#emptyName').hide();
                    $('#emptyUserName').hide();
                    $('#emptyMobile').hide();
                    $('#emptyContactPerson').hide();

                    $('#emptyPartyName').hide();  
                    $('#emptyPartyCity').hide();
                    $('#emptyContactEmail').hide();
                    $('#emptyContactMobileNo').hide();
                    $('#emptyContactWhatsappNo').hide();
                    $('#emptyRetypePassword').hide();

                    /*$('#party_name').css('border-color', '#E4E6EF');
                    $('#party_city').css('border-color', '#E4E6EF');
                    $('#contact_person').css('border-color', '#E4E6EF');
                    $('#contact_mobile_no').css('border-color', '#E4E6EF');
                    $('#contact_whatsapp_no').css('border-color', '#E4E6EF');
                    $('#username').css('border-color', '#E4E6EF');

                    $('#password').css('border-color', 'red');
                    $('#retype_password').css('border-color', 'red');
                    */

                    $('#emptyPassword').show();
                    $('#emptyPassword').html('Password and Retype Password does not match.');
                    return false;

                } else {
                    
                    var data = new FormData();
                 //   data.userId = userId;

                    /*$('#password').css('border-color', '#E4E6EF');
                    $('#retype_password').css('border-color', '#E4E6EF');

                    $('#party_name').css('border-color', '#E4E6EF');
                    $('#party_city').css('border-color', '#E4E6EF');
                    $('#contact_person').css('border-color', '#E4E6EF');
                    $('#contact_mobile_no').css('border-color', '#E4E6EF');
                    $('#contact_whatsapp_no').css('border-color', '#E4E6EF');
                    $('#uusername').css('border-color', '#E4E6EF');
                    */
                    
                    $('#emptyPartyName').hide();  
                    $('#emptyPartyCity').hide();
                    $('#emptyContactEmail').hide();
                    $('#emptyContactMobileNo').hide();
                    $('#emptyContactWhatsappNo').hide();
                    $('#emptyContactPerson').hide();


                    $('#emptyName').hide();  
                    $('#emptyUserName').hide();
                    $('#emptyPassword').hide();
                    $('#emptyMobile').hide();
                    $('#emptyRetypePassword').hide();
                    
/*                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
*/
                    /*
                    data.token =  token;
                    data.user_type = userType;
                    data.party_name = partyName;
                    data.party_address = partyAddress;
                    data.party_state = partyState;
                    data.party_country = partyCountry;
                    data.party_city = partyCity;
                    data.party_pincode = pincode;
                    data.party_gst_no = party_gst_no;
                    data.party_credit_limit = party_credit_limit;
                    
                    data.contact_person = contactPerson;                   
                    data.contact_email = contactEmail;                    
                    data.contact_mobile_no = contactMobileNo;
                    data.contact_whatsapp_no = contactWhatsappNo;

                    data.transport_name = transport_name;                    
                    data.transport_address = transport_address;
                    data.transport_email = transport_email;                    
                    data.transport_mobile_no = transport_mobile_no;
                    
                    data.uusername = uusername;                    
                    data.password = password;
                    data.retype_password = retype_password;
                    //data.append("_token", _token);*/

            data.append("_token", _token);
            data.append("user_type", userType);
            data.append("party_name", partyName);
            data.append("party_address", partyAddress);
            data.append("party_state", partyState);
            data.append("party_country", partyCountry);
            data.append("party_city", partyCity);
            data.append("party_pincode", pincode);
            data.append("party_gst_no", party_gst_no);
            data.append("party_credit_limit", party_credit_limit);
            data.append("contact_person", contactPerson);
            data.append("contact_email", contactEmail);
            data.append("contact_mobile_no", contactMobileNo);
            data.append("contact_whatsapp_no", contactWhatsappNo);
            data.append("transport_name", transport_name);
            data.append("transport_address", transport_address);
            data.append("transport_email", transport_email);
            data.append("transport_mobile_no", transport_mobile_no);
            data.append("uusername", uusername);
            data.append("password", password);
            data.append("retype_password", retype_password);
            data.append("userId", userId);
                    
            
            
            
            
            
            
            
            



                         //   $http.post("{{route('user.edit')}}",data).success(function(data) {

                        //   if (data.partyText == 'partyText') {
                            /*
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');*/

                            //if (data.partyText == 'partyText') {
                                //$('#party_name').css('border-color', 'red');
                               // $('#emptyPartyName').show();
                               // $('#emptyPartyName').html('The Party Name has already been taken.');
                               // return false;
                               
                            //} 

                         //   $('#party_name').css('border-color', '#E4E6EF');
                            //$('#emptyPartyName').hide();


                       // } else {  
                                        //
                            /*$("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            */
                          //  $scope.isInsert = true;
                          //  $scope.userFormData = {};
                          //  $scope.fetchUserData();
                           // setTimeout(function() {
                             //   toastr.success(
                              //      data.message, 'Success!',
                               //     { 
                               //         "closeButton": true,
                               //         timeOut: 3000 
                               //     }
                               // );
                          //  }, 1000);
                           // $scope.resetUserForm();  
                           
                      //  }
                        
                        

                        /*$("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        */
                     //   window.location.href = "{{route('user') }}";
                        
                   // });
                   
                    $.ajax({
                        url: "{{ route('user.edit') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            if (data == 'partyText') {
                                $('#party_name').css('border-color', 'red');
                                $('#emptyPartyName').show();
                                $('#emptyPartyName').html('The Party Name has already been taken.');
                                return false;
                            } else {
                               window.location.href = "{{route('user') }}";
                            }
                        }
                        
                    });
                            
                }


            } else if (userType == 2) {
                
              //  alert('hello');
                
                var uname = $('#uname').val();
                var umobile = $('#umobile').val();
                var uusername = $('#username').val();
                var upassword = $('#upassword').val();
                var uretype_password = $('#uretype_password').val();

                if (uname == '' || umobile == '' || uusername == '' || upassword == ''  || uretype_password == '') {

                    if (uname == '') {
                        $('#uname').css('border-color', 'red');
                        $('#emptyNames').show();
                        $('#emptyNames').html('Name field is Required.');
                    } else {
                       // $('#uname').css('border-color', '#E4E6EF');
                        $('#emptyNames').hide();
                    }

                    if (uusername == '') {
                        $('#username').css('border-color', 'red');
                        $('#emptyUserNames').show();
                        $('#emptyUserNames').html('User Name field is Required.');
                    } else {
                       // $('#username').css('border-color', '#E4E6EF');
                        $('#emptyUserNames').hide();
                    }

                    if (upassword == '') {
                        $('#upassword').css('border-color', 'red');
                        $('#emptyPasswords').show();
                        $('#emptyPasswords').html('Password field is Required.');
                    } else {
                       // $('#upassword').css('border-color', '#E4E6EF');
                        $('#emptyPasswords').hide();
                    }

                    if (umobile == '') {
                        $('#umobile').css('border-color', 'red');
                        $('#emptyMobiles').show();
                        $('#emptyMobiles').html('Mobile field is Required.');
                    } else {
                      //  $('#umobile').css('border-color', '#E4E6EF');
                        $('#emptyMobiles').hide();
                    }

                    if (uretype_password == '') {
                        $('#uretype_password').css('border-color', 'red');
                        $('#emptyRetypePasswords').show();
                        $('#emptyRetypePasswords').html('Retype Password field is Required.');
                    } else {
                       // $('#uretype_password').css('border-color', '#E4E6EF');
                        $('#emptyRetypePasswords').hide();
                    } 

                    return false;

                }  else if (upassword != uretype_password) {

/*                      $('#uname').css('border-color', '#E4E6EF');
                        $('#username').css('border-color', '#E4E6EF');
                        $('#umobile').css('border-color', '#E4E6EF');
*/
                    $('#emptyNames').hide();  
                    $('#emptyUserNames').hide();
                    $('#emptyMobiles').hide();
                    $('#emptyRetypePasswords').hide();
                    $('#emptyPasswords').show();
                    $('#emptyPasswords').html('Password and Retype Password does not match.');
                    return false;

                } else {
                    
                    var data = new FormData();
                   // data.userId = userId;


                    /*                    $('#uname').css('border-color', '#E4E6EF');
                    $('#username').css('border-color', '#E4E6EF');
                    $('#upassword').css('border-color', '#E4E6EF');
                    $('#uretype_password').css('border-color', '#E4E6EF');
                    $('#umobile').css('border-color', '#E4E6EF');
                    */
                    
                    $('#emptyNames').hide();  
                    $('#emptyUserNames').hide();
                    $('#emptyPasswords').hide();
                    $('#emptyMobiles').hide();
                    $('#emptyRetypePasswords').hide();

                    /*                   $("#lorderId").attr("disabled", true);
                   $("#cancelId").attr("disabled", true);
                   $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    */
                    
                  //  data.token =  token;
                    /*data.user_type = userType;
                    data.username = uusername;
                    data.upassword = upassword;
                    data.umobile = umobile;                    
                    data.uname = uname;
                    data.uretype_password = uretype_password;
                    */
                    
                    data.append("userId", userId);
                    
                    data.append("_token", _token);
                    data.append("user_type", userType);
                    data.append("username", uusername);
                    data.append("upassword", upassword);
                    data.append("umobile", umobile);
                    data.append("uname", uname);
                    data.append("uretype_password", uretype_password);
                    data.append("userId", userId);
                    
                    
                    
                    
                    
                    $.ajax({
                        url: "{{ route('user.edit') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: 'POST',
                        success: function (data) {
                            if (data == 'userText') {
                                $('#party_name').css('border-color', 'red');
                                $('#emptyPartyName').show();
                                $('#emptyPartyName').html('The User Name has already been taken.');
                                return false;
                            } else {
                                window.location.href = "{{route('user') }}";
                            }
                        }
                        
                    });

                    //   $http.post("{{route('user.edit')}}",data).success(function(data) {

                     //   if (data.userText == 'userText') {
                        /*
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');*/
                            
                            /*if (data.userText == 'userText') {
                                $('#uusername').css('border-color', 'red');
                                $('#emptyUserNames').show();
                                $('#emptyUserNames').html('The User Name has already been taken.');
                                return false;
                            }*/ 

                           // $('#uusername').css('border-color', '#E4E6EF');
                           
                       //     $('#emptyUserNames').hide();

                    //    } else {
                              
                      //      $("#lorderId").attr("disabled", false);
                       //     $("#cancelId").attr("disabled", false);
                        //    $("#lorderId").html('Save');
                        
                                
                            /*if (data.partyText == 'partyText') {
                                $('#emptyPartyName').show();
                                $('#emptyPartyName').html('The Party Name has already been taken.');

                            } else {

                                $('#emptyPartyName').hide();
                            }
                            */
                            
                      //  } else {

                            /*$("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            */
                            
                            /*$scope.isInsert = true;
                            
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
                            */
                           // $scope.resetUserForm();
                       // }
                        
                        /*$("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        */
                        
                        
                      //  window.location.href = "{{route('user') }}";


                    //});
                }
                
            }
            
        });

    
    
   // });
    
</script>


</body>
</html>

