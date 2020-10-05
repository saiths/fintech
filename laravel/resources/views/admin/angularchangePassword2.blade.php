@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">  
                        <form id="register-form"  method="post" action="{{ route('angularchangepassword.update') }}" 
                        enctype="multipart/form-data" autocomplete="off" >
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Current Password :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred" name="currentpassword" id="currentpassword" 
                                                placeholder="Current Password" type="password" 
                                                ng-model="changePasswordFormData.currentpassword" >
                                                <span class="text-danger" id="emptyName">{{ $errors->first('currentpassword') }}</span>
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>New Password :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred" name="newpassword" id="newpassword" 
                                                placeholder="New Password" type="password">
                                                <span class="text-danger" id="emptyName">{{ $errors->first('newpassword') }}</span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Confirm Password :</b> </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred"   name="confirmpassword" id="confirmpassword" 
                                                placeholder="Confirm Password" type="password" >
                                                <span class="text-danger" id="emptyName">{{ $errors->first('confirmpassword') }}</span>
                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"></label>
                                            <div class="col-md-8">
                                                <button type="submit" id="changePwdId" 
                                                class="btn btn-primary mr-2 ng-scope">Save</button>
                                                
                                                <button type="button" onclick="resetChangePwdForm()" class="btn btn-dark">Cancel
                                                </button>
                                                
                                            </div>
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


@include('admin.common.footer')

</div>
</div>
</div>

@include('admin.common.script')


<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script> 

<script type="text/javascript">
    var app = angular.module("myApp", []);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.changePasswordFormData = {};
        
        $scope.updateChangePasswordData = function(data) {
            
           // $("#changePwdId").attr("disabled", true);
           // $("#changePwdId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Submiting');
            
                
            var currentPassword = $('#currentpassword').val();
            var newPassword = $('#newpassword').val();
            var confirmPassword = $('#confirmpassword').val();
            
            if (currentPassword == '' ||  newPassword == '' || confirmPassword == '') {
                
                
              //  $("#changePwdId").attr("disabled", true);
             //   $("#changePwdId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Submiting');
            
                    
                if (currentPassword == '') {
                    $('#emptyCurrent').show();
                    $('#emptyCurrent').html('Current Password field is required.');
                } else {
                    $('#emptyCurrent').hide();
                }

                if (newPassword == '') {
                    $('#emptyNew').show();
                    $('#emptyNew').html('New Password field is required.');
                } else {
                    $('#emptyNew').hide();
                }

                if (confirmPassword == '') {
                    $('#emptyConfirm').show();
                    $('#emptyConfirm').html('Confirm Password field is required.');
                } else {
                    $('#emptyConfirm').hide();
                }
                
              //  $("#changePwdId").html('Submit');
               // $("#changePwdId").attr("disabled", false);

                return false;

            } else {

                $('#emptyCurrent').hide();
                $('#emptyNew').hide();
                $('#emptyConfirm').hide();

                $http.post("{{route('angularchangepassword.update')}}",data).success(function(data) {

                    if (data.message == 1) {
                        $("#changePwdId").attr("disabled", false);
                        $("#changePwdId").html('Submit');
                        $('#emptyCurrent').hide();
                        $('#emptyNew').show();
                        $('#emptyNew').html('New and Confirm Password doesnot match');
                        return false;
                    } else if(data.message == 2) {
                        $("#changePwdId").attr("disabled", false);
                        $("#changePwdId").html('Submit');
                        $('#emptyNew').hide();
                        $('#emptyCurrent').show();
                        $('#emptyCurrent').html('Current Password do not match');
                        return false;
                    } else {
                        $("#profileId").attr("disabled", false);
                        $("#profileId").html('Submit');
                        $scope.changePasswordFormData = {};
                        $('#emptyCurrent').hide(); 
                        $('#emptyNew').hide();
                        $('#emptyConfirm').hide();
                        setTimeout(function() {
                            toastr.success(
                                'Password updates successfully.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        window.location.href = '{{ route("logout") }}'; 
                        $scope.resetChangePwdForm();
                    }
                }); 
            }
        }; 

        $scope.resetChangePwdForm = function(data) {
            $('#currentpassword').val('');
            $('#newpassword').val('');
            $('#confirmpassword').val('');
            $('#emptyCurrent').hide();
            $('#emptyNew').hide();
            $('#emptyConfirm').hide();
        }

    });
    
    function resetChangePwdForm() {
        
        window.location.href = "{{route('achangepassword') }}";    
    }
    
    
</script>

</body>
</html>
