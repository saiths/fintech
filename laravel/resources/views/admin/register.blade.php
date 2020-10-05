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
        <title>Sign In</title>
        <!-- ===== Bootstrap CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- ===== Plugin CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/../plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- ===== Animation CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/animate.css')}}" rel="stylesheet">
        <!-- ===== Custom CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/style.css')}}" rel="stylesheet">
        <!-- ===== Color CSS ===== -->
        <link href="{{ URL::asset('public/admin/theme/css/colors/default.css')}}" id="theme" rel="stylesheet">
        
        <link href="{{ URL::asset('public/admin/theme/../plugins/components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />
        
        <link href="{{ URL::asset('public/admin/theme/../plugins/components/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
        <link href="{{ URL::asset('public/admin/theme/../plugins/components/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />

    </head>
    <body class="mini-sidebar">
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="login-register">
            <div class="login-box" style="width: 596px;margin-top: 19px;">
                <div class="white-box">
                    <form class="form-horizontal form-material" id="loginform" action="#">
                        <h5 class="box-title m-b-20 text-center" style="font-size: 25px">Sign In</h5>
                        <div class="form-group" style="margin-left: 6px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="name" id="name" 
                                    required="" placeholder="Full Name">
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="address" name="address" rows="2" placeholder="Address"></textarea>
                                </div>    
                            </div>
                        </div>
                        <div class="form-group" style="margin-left: 7px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" id="role_id" name="role_id">
                                        <?php 
                                            $getRoleData = DB::select('SELECT * FROM role_master WHERE is_deleted_status = "N" ');
                                        ?>
                                        <option value="">Select Role</option>
                                        @if (!empty($getRoleData))
                                            @foreach ($getRoleData as $role)  
                                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="client_id" name="client_id">
                                        <?php 
                                            $getRoleData = DB::select('SELECT * FROM role_master WHERE is_deleted_status = "N" ');
                                        ?>
                                        <option value="">Select Client</option>
                                        @if (!empty($getRoleData))
                                            @foreach ($getRoleData as $role)  
                                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>    
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="username" id="username" 
                                required="" placeholder="User Name">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <input class="form-control" type="text" required="" placeholder="Email"
                                id="email" name="email">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" required="" placeholder="Password"
                                id="password" name="password">
                            </div>
                        </div>

                        <div class="form-group" >
                            <div class="col-md-6">
                                <input class="form-control" type="text" required="" placeholder="Date Of Birth"
                                id="datepicker_date_of_birth" data-date-format="dd-mm-yyyy" name="date_of_birth">
                            </div>
                            <div class="col-md-6" id="date_of_Joining_hide">
                                <input class="form-control" type="text" required="" placeholder="Date Of Joining"
                                id="datepicker_date_of_Joining" data-date-format="dd-mm-yyyy" name="date_of_Joining">
                            </div>
                        </div>

                       <!--  <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                                </div>
                            </div>
                        </div> -->
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
        
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/custom-select/custom-select.min.js')}}" type="text/javascript"></script>

        <script src="{{ URL::asset('public/admin/theme/../plugins/components/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>

        <!-- Date Picker Plugin JavaScript -->
        <script src="{{ URL::asset('public/admin/theme/../plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

        <script src="{{ URL::asset('public/admin/theme/../plugins/components/styleswitcher/jQuery.style.switcher.js')}}"></script>
        
        <script type="text/javascript">
            
            // For select 2
            $("#role_id").select2({
                placeholder: "Select",
                allowClear: true
            });

            $("#client_id").select2({
                placeholder: "Select",
                allowClear: true
            });

            $('.selectpicker').selectpicker();    
            
            // Date Picker
            jQuery('#datepicker_date_of_birth').datepicker({
                autoclose: true,
                todayHighlight: true,
                orientation: "bottom auto"
            });
            
            // Date Picker
            jQuery('#datepicker_date_of_Joining').datepicker({
                autoclose: true,
                todayHighlight: true,
                orientation: "bottom auto"
            });
            
            var role_id = document.getElementById("role_id");
            role_id.onchange = function() {
                var roleName = role_id.options[role_id.selectedIndex].value;
                if (roleName == 4) {
                    $('#date_of_Joining_hide').hide();
                } else {
                    $('#date_of_Joining_hide').show();
                }
            }
        </script>
    </body>
</html>
