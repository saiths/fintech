<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('public/admin/theme/../plugins/images/favicon.png') }}">
        <title>Register</title>
        <!-- ===== Bootstrap CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- ===== Plugin CSS ===== -->
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
                    <form class="form-horizontal form-material" id="loginform" action="index.html">
                        <h3 class="box-title m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>Already have an account? <a href="login.html" class="text-primary m-l-5"><b>Sign In</b></a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- jQuery -->
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/jquery/dist/jquery.min.js')}}"></script>
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
    </body>
</html>
