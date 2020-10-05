<!DOCTYPE html>
<html dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/admin/theme2/assets/images/favicon.png')}}">
        <title>Sign In</title>
        <!--<link rel="canonical" href="https://www.wrappixel.com/templates/niceadmin/" />-->
        <link href="{{ URL::asset('public/admin/theme2/assets/extra-libs/toastr/dist/build/toastr.min.css')}}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ URL::asset('public/admin/theme2/dist/css/style.min.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="main-wrapper">
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>
            <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background-color: #f6f8f9;">
                <div class="auth-box">
                    <div id="loginform">
                        <div class="logo">
                            <h5 class="font-medium">Sign In</h5>
                        </div>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-12">
                                <form class="form-horizontal m-t-20"  action="{{ route('login') }}" id="register-form" method="post"  autocomplete="off">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <span id="loading" style="display:none">
                                        <center>
                                            <img src="{{ URL::asset('public/image/lorder.gif')}}" style="height: 50px;width: 50px;" />
                                        </center>
                                        <h3 class="box-title m-b-20 text-center" style="font-size: 21px;">Sending OTP...</h3>
                                    </span>
                                    
                                    <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"  id="username" name="username" placeholder="User Name" 
                                            value="{{ !empty($loginPostData['username']) ? $loginPostData['username'] : old('username') }}">
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="password" id="password"  name="password"  
                                            placeholder="Password">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    </div>  

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                                                <a href="{{ route('forgot') }}" class="text-dark float-right">
                                                    <i class="fa fa-lock m-r-5"></i> Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-4" >
                                                    <div class="captcha">
                                                        <span>{!! captcha_img('math') !!}</span>
                                                    </div>
                                                </div> 
                                                <div class="col-md-2" >
                                                    <button type="button" onclick="generateCaptchImg()" 
                                                        class="btn btn-success">
                                                        <i class="mdi mdi-refresh" id="refresh"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <div class="col-xs-12 p-b-20">
                                            <button class="btn btn-block btn-lg btn-info" type="button" id="sendOtpLorder">Log In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ URL::asset('public/admin/theme2/assets/libs/jquery/dist/jquery.min.js')}}"></script>
        <!--<script src="{{ URL::asset('public/admin/theme2/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>-->
        <script src="{{ URL::asset('public/admin/theme2/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('public/admin/theme2/assets/extra-libs/toastr/dist/build/toastr.min.js')}}"></script>
        <!--<script src="{{ URL::asset('public/admin/theme2/assets/extra-libs/toastr/toastr-init.js')}}"></script>-->
        <script src="{{ URL::asset('public/js/admin/jquery.validate.min.js') }}"></script> 
        
        <script>
            //$('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
            $('#to-recover').on("click", function() {
                $("#loginform").slideUp();
                $("#recoverform").fadeIn();
            });

            $('#sendOtpLorder').on('click', function(e) {
                var username = $("#username").val();
                var password = $("#password").val();
                //var captcha = $("#captcha").val();
                //if (username != "" && password != "" && captcha != "") {
                    
                if (username != "" && password != "") {
                    $("#sendOtpLorder").attr("disabled", true);
                    $("#sendOtpLorder").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Logining..');
                    $.ajax({
                        url:"{{ route('sendotpLorder') }}",
                        type :'get',
                        data : {  
                            username: username,
                            password: password
                        },
                        success:function(result) {
                            if (result == 1) {
                                e.preventDefault();
                                e.stopPropagation();
                                $("#sendOtpLorder").attr("disabled",false);
                                $('#loading').show();
                                $("#sendOtpLorder").attr("disabled", true);                
                                $("#username").attr("disabled", true);  
                                $("#password").attr("disabled", true);  
                                $("#captcha").attr("disabled", true);  
                                $('body').css('opacity', '0.6');
                            }
                        }
                    });
                    
                } 
                $('#register-form').submit();      
            });

            @if (!empty($errorMsg))
                toastr.error(
                    '{{$errorMsg}}', 'Wrong!',
                    {   
                        "closeButton": true,
                        timeOut: 3000 ,
                    }
                );
            @endif

            @if(\Session::has('message'))
                toastr.success(
                    '{{session()->get('message')}}', 'Success!',
                    {   
                        "closeButton": true,
                        timeOut: 3000 ,
                    }
                );
            @endif
            
            setTimeout(function() {
                $("#error_sucess").hide();
                $("#error_worng").hide();
                1
            }, 5000);
        
            $(function() {
                $("#register-form").validate({
                    rules: {
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                        //captcha: {
                         //   required: true,
                        ///},
                    },
                    // Specify the validation error messages
                    messages: {
                        username: "<span class='text-danger'>The User Name field is required.</span>",
                        password: "<span class='text-danger'>The Password field is required.</span>",
                       // captcha: "<span class='text-danger'>Captcha Required.</span>",          
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });

            function generateCaptchImg() {
                $.ajax({
                    type:'GET',
                    url:'refreshcaptcha',
                    success:function(data) {
                        $(".captcha span").html(data);
                    }
                });
            }

        </script>
    </body>
</html>