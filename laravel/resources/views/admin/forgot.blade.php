<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/admin/theme/../plugins/images/favicon.png')}}">
        <title>Recover Password</title>
        <!-- ===== Bootstrap CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('public/admin/theme/../plugins/components/toast-master/css/jquery.toast.css')}}" 
        rel="stylesheet">
        <!-- ===== Animation CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/animate.css')}}" rel="stylesheet">
        <!-- ===== Custom CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/style.css')}}" rel="stylesheet">
        <!-- ===== Color CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/colors/default.css')}}" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="mini-sidebar">
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="login-register">
            <div class="login-box">
                <div class="white-box">
                    {{ csrf_field() }}
                    <!--@if (!empty($successMsg))
                        <div class="alert alert-success alert-dismissable" id="error_sucess">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{$successMsg}}
                        </div>
                    @endif-->
                    <!-- @if (!empty($errorMsg))
                        <div class="alert alert-danger alert-dismissible" id="error_worng">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
                            {{$errorMsg}}
                        </div>
                    @endif -->
                    <!-- Forgot Password !-->
                    <form class="form-horizontal"  id="forgotForm" action="{{ route('forgotpassword') }}" method="post" autocomplete="off">
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
                    <!-- Forgot Password !-->
                </div>
            </div>
        </section>
        <!-- jQuery -->
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/jquery/dist/jquery.min.js')}}">
        </script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ URL::asset('public/admin/theme/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="{{ URL::asset('public/admin/theme/js/sidebarmenu.js')}}"></script>
        <!--slimscroll JavaScript -->
        <script src="{{ URL::asset('public/admin/theme/js/jquery.slimscroll.js')}}"></script>
        <!--Wave Effects -->
        <script src="{{ URL::asset('public/admin/theme/js/waves.js')}}"></script>
        <!-- Custom Theme JavaScript -->
        <script src="{{ URL::asset('public/admin/theme/js/custom.js')}}"></script>
        <!--Style Switcher -->
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/styleswitcher/jQuery.style.switcher.js')}}"></script>
          
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/toast-master/js/jquery.toast.js')}}"></script>
        
        <script src="{{ URL::asset('public/js/admin/jquery.validate.min.js') }}"></script> 
        
        <script>
            @if (!empty($errorMsg))
               $.toast({
                    heading: 'Wrong!',
                    text: '{{$errorMsg}}',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3500
                });
            @endif
            
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
