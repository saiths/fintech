<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/admin/theme2/assets/images/favicon.png')}}">
        <title>OTP Verification</title>
        <!--<link rel="canonical" href="https://www.wrappixel.com/templates/niceadmin/" />-->
        <link href="{{ URL::asset('public/admin/theme2/assets/extra-libs/toastr/dist/build/toastr.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('public/admin/theme2/dist/css/style.min.css')}}" rel="stylesheet">
    </head>
    <body class="mini-sidebar">
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
                        {{ csrf_field() }}
                        <form class="form-horizontal"  id="otpForm" action="{{ route('checkotp') }}" method="post" autocomplete="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h3 class="text-center">OTP Verification</h3>
                                    <p class="text-muted">
                                        Check Your Registered Email  @if(!empty(Session::get('sessionUserData'))) 
                                            @foreach (Session::get('sessionUserData') as $sessionUserData)
                                                <?php 
                                                    if (!empty($sessionUserData[0]->email)) {
                                                        $emailPart = explode('@', $sessionUserData[0]->email);
                                                        $getFirst2Ch = substr($emailPart[0], 0,2);
                                                        $getLast2Ch = substr($emailPart[0], -2);
                                                        $getLengthStr = strlen($emailPart[0]);
                                                        if ($getLengthStr == 4) {
                                                            $getFirst1Ch = substr($emailPart[0], 0,1);
                                                            $getLast1Ch = substr($emailPart[0], -1);
                                                            $x2ChStr = $getLengthStr - 2; 
                                                            $email4Str =  $getFirst1Ch; 
                                                            for ($j=0; $j < $x2ChStr; $j++) { 
                                                                $email4Str .= 'X';
                                                            }
                                                            $email4Str .= $getLast1Ch.'@'.$emailPart[1];
                                                            echo '<b>'.$email4Str.'</b>'; 
                                                        } else {
                                                            $xChstr = $getLengthStr - 4;
                                                            $emailStr =  $getFirst2Ch;
                                                            for ($i=0; $i < $xChstr; $i++) { 
                                                                $emailStr .= 'X';
                                                            }
                                                            $emailStr .= $getLast2Ch.'@'.$emailPart[1];
                                                            echo '<b>'.$emailStr.'</b>';
                                                        }
                                                    }
                                                ?>
                                            @endforeach
                                        @endif
                                        for OTP.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row has-feedback {{ !empty($emptyOtpMsg) ? 'has-error' : '' }}">
                                        <div class="col-md-8">
                                           <input class="form-control" name="otp" id="otp" type="text" 
                                           value="{{ !empty($forgotPostData['otp']) ? $forgotPostData['otp'] : old('otp') }}"  
                                           placeholder="Enter OTP">
                                            <span class="text-danger">{{ !empty($emptyOtpMsg) ? $emptyOtpMsg : ''}}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <a  href="{{route('resendotp')}}" class="btn btn-primary" >
                                                Resend
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">otp Verifiy</button>
                                </div>
                            </div>
                        </form>
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
            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
            $('#to-recover').on("click", function() {
                $("#loginform").slideUp();
                $("#recoverform").fadeIn();
            });
        </script>
        
        <script>
            
            @if (!empty($errorMsg))
                toastr.error(
                    '{{$errorMsg}}', 'Wrong!',
                    { 
                        "closeButton": true,
                        timeOut: 3000 
                    }
                );
            @endif
            
            
            @if (!empty($successMsg))
                toastr.success(
                    '{{$successMsg}}', 'Success!',
                    { 
                        "closeButton": true,
                        timeOut: 3000 
                    }
                );
            @endif
            
            @if(\Session::has('message'))
                toastr.success(
                    '{{session()->get('message')}}', 'Success',
                    { 
                        "closeButton": true,
                        timeOut: 3000 
                    }
                );
            @endif
            
            setTimeout(function() {
                $("#error_sucess").hide();
                $("#error_worng").hide();
                1
            }, 5000);
            
            $(function() {
                $("#otpForm").validate({
                    rules: {
                        otp: {
                            required: true,
                        },
                    },
                    // Specify the validation error messages
                    messages: {
                        otp:{
                            required : "<span class='text-danger'>Please Enter Your OTP</span>",
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
