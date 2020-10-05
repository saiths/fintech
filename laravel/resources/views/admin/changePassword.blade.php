@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Change Password</h3>
            <p class="text-muted m-b-30 font-13 "> 
               <!-- <span class="text-danger"> *Indicates Required Field </span>  -->
            </p>
<!--             @if (!empty($successMsg))
                <div class="alert alert-success alert-dismissible" id="error_sucess" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$successMsg}}
                </div>
            @endif
            
            @if (!empty($errorMsg))
                <div class="alert alert-danger alert-dismissible"  id="error_worng"  role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$errorMsg}}
                </div>
            @endif -->

            <form autocomplete="off" id="register-form" action="{{ route('changepassword.update') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback {{ !empty($emptyErrorMsg['emptyCurrentMsg']) ? 'has-error' : '' }}">
                            <input class="form-control" style="border:1px solid #e74a25!important"   name="currentpassword" id="currentpassword" placeholder="Current Password" type="password" >
                            <span class="form-control-feedback"   aria-hidden="true"></span> 
                            @if (!empty($emptyErrorMsg['emptyCurrentMsg'])) 
                                <span class="text-danger">{{ $emptyErrorMsg['emptyCurrentMsg'] }}</span>
                            @endif
                         </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback {{ !empty($emptyErrorMsg['emptyNewMsg']) ? 'has-error' : '' }}">
                            <input class="form-control" style="border:1px solid #e74a25!important"  name="newpassword" id="newpassword" placeholder=" New Password" 
                            type="password" >
                            <span class="form-control-feedback"   aria-hidden="true"></span> 
                            @if (!empty($emptyErrorMsg['emptyNewMsg'])) 
                                <span class="text-danger">{{ $emptyErrorMsg['emptyNewMsg'] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback {{ !empty($emptyErrorMsg['emptyConfirmMsg']) ? 'has-error' : '' }}">
                            <input class="form-control"  style="border:1px solid #e74a25!important" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" type="password" >
                            <span class="form-control-feedback"   aria-hidden="true"></span> 
                            @if (!empty($emptyErrorMsg['emptyConfirmMsg'])) 
                                <span class="text-danger">{{ $emptyErrorMsg['emptyConfirmMsg'] }}</span>
                            @endif
                            <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-md-6">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Update</button>
                        </div>
                        <div class="col-md-3" style="margin-left: -25px;">
                            <button type="button" onclick="resetChangePwdForm()" class="btn btn-block btn-default">
                                <i class="icon-close"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function resetChangePwdForm() {
        window.location.href="{{ route('changepassword') }}";
    }
</script>
@include('admin.common.script')
<script type="text/javascript">
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
                currentpassword: {
                    required: true,
                },
                confirmpassword: {
                    required: true,
                },
                newpassword: {
                    required: true,
                },
            },
            
            // Specify the validation error messages
            messages: {
                currentpassword: "<span class='text-danger'>Current Password field is required.</span>",
                confirmpassword: "<span class='text-danger'>Confirm Password field is required.</span>",
                newpassword: "<span class='text-danger'>New Password field is required.</span>",
            },
            
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>