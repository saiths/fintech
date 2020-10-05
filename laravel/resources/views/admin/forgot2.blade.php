<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/admin/theme2/assets/images/favicon.png')}}">
        <title>Recover Password</title>
        <!--<link rel="canonical" href="https://www.wrappixel.com/templates/niceadmin/" />-->
        <link href="{{ URL::asset('public/admin/theme2/assets/extra-libs/toastr/dist/build/toastr.min.css')}}" rel="stylesheet">
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
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12">
                                <form class="form-horizontal"  id="forgotForm" action="{{ route('forgotpassword') }}" 
                                    method="post" autocomplete="off">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <h3>Recover Password</h3>
                                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }} ">
                                        <div class="col-xs-12">
                                            <input class="form-control" name="email" id="email" type="text"  value="{{ !empty($forgotPostData['email']) ? $forgotPostData['email'] : old('email') }}"  placeholder="Email">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group text-center m-t-20">
                                        <div class="col-xs-12">
                                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
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
            
            setTimeout(function(){
                $("#error_sucess").hide();
                $("#error_worng").hide();
                1
            }, 5000);
        
            $(function() {
                $("#forgotForm").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        },
                    },
                    // Specify the validation error messages
                    messages: {
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
