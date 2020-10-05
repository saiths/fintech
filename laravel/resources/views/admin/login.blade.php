<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Fintech | Sign In</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/pages/login/classic/login-3.css?v=7.0.5') }}" 
        rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/plugins/global/plugins.bundle.css?v=7.0.5') }}" 
        rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.5') }}" 
        rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/style.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/header/base/light.css?v=7.0.5') }}" rel="stylesheet" 
        type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/header/menu/light.css?v=7.0.5') }}" rel="stylesheet" 
        type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/brand/dark.css?v=7.0.5') }}" rel="stylesheet" 
        type="text/css" />
        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/aside/dark.css?v=7.0.5') }}" rel="stylesheet" 
        type="text/css" />        
        <link rel="shortcut icon" href="{{ URL::asset('public/admin/dist/assets/media/logos/favicon.ico') }}" />
    </head>
            <style>
            .toast-success {
                background-color: #8B4513	 !important;
            }

        </style>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <!--<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" 
                    style="background-image: url({{ URL::asset('public/admin/dist/assets/media/bg/bg-1.jpg')}});">
                -->
                            
                <?php 
                    $getUserDataByID = DB::table('company_edit_profile')
                    ->select('*')
                    ->where('is_deleted_status','N')
                    ->get()
                    ->toArray();
                ?> 
                    
                @if(!empty($getUserDataByID))
                    @foreach ($getUserDataByID as $getUserData)
                    @endforeach
                @endif
                
                
                <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-color: white;">
                
                    <div class="login-form text-center text-white p-7 position-relative overflow-hidden" style="
    margin-top: -100px;>
                        <?php 
                            $photo = !empty($getUserData->logo) ? $getUserData->logo : '';
                            $url = URL::to('/').'/laravel/public/company_edit_profile_image/'.$photo;
                        ?>
                        
                        <div class="login-signin">
                        
                            <div class="mb-10">
                                @if(!empty($photo)) 
                                    <img id="previewImg"  src="{{$url}}"  
                                    alt="Placeholder" >
                                @endif
                            </div>
                            
                        
                            <!--<div class="mb-20">
                                <h3>Fintech</h3>
                            </div>
                            -->
                            
                            <form class="form-horizontal m-t-20"  action="{{ route('login') }}" 
                                id="register-form" method="post"  autocomplete="off">
                                
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                                    <input class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="text" 
                                    placeholder="User Name" name="username" id="username" autocomplete="off" />
                                    <span class="text-danger" id="emptyUserName">{{ $errors->first('username') }}</span>
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <input class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8" type="password" placeholder="Password" name="password" id="password" />
                                    <span class="text-danger" id="emptyPassword">{{ $errors->first('password') }}</span>
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
                                                <button type="button" onclick="generateCaptchImg()" class="btn btn-success" style="
    background-color: #8B4513;
    border-color: #8B4513;
">
                                                    <i class="ki ki-reload icon-nm" style="margin-left: 5px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="captcha" type="text" class="form-control" 
                                                placeholder="Enter Captcha" name="captcha">
                                                <span class="text-danger" id="emptyCaptcha"></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <!--<button class="btn btn-block btn-lg btn-info" type="button" 
                                        id="sendOtpLorder">Log In</button>
                                        -->
                                        <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg" type="button" id="sendOtpLorder" style="
    background-color: #8B4513;
    border-color: #8B4513;
"><b style="color:white">Log In</b></button>
                                    </div>
                                        
                                        
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
        <script>
            var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
        </script>

        <script src="{{ URL::asset('public/admin/dist/assets/plugins/global/plugins.bundle.js?v=7.0.5') }}"></script>
        <script src="{{ URL::asset('public/admin/dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5') }}"></script>
        <script src="{{ URL::asset('public/admin/dist/assets/js/scripts.bundle.js?v=7.0.5') }}"></script>
        <script src="{{ URL::asset('public/admin/dist/assets/js/pages/custom/login/login-general.js?v=7.0.5') }}"></script>
        <script src="{{ URL::asset('public/js/admin/jquery.validate.min.js') }}"></script>

        <script>

            $('#sendOtpLorder').on('click', function(e) {

                var username = $("#username").val();
                var password = $("#password").val();
                var captcha = $("#captcha").val();

                if (username == '' || captcha == '' || password == '') {
                    
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

                    if (captcha == '') {
                        $('#emptyCaptcha').show();
                        $('#emptyCaptcha').html('Captcha field is Required.');
                    } else {
                        $('#emptyCaptcha').hide();
                    }
                
                } else {

                    $("#sendOtpLorder").attr("disabled", true);
                    $("#sendOtpLorder").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;<b style="color:white">Logining..</b>');
    
                    $.ajax({
                        url:"{{ route('sendotpLorder') }}",
                        type :'get',
                        data : {  
                            username: username,
                            password: password
                        },
                        success:function(result) {
                            if (result == 1) {
                                $("#sendOtpLorder").attr("disabled",false);
                                $('#loading').show();
                            }
                        }
                    });

                    $('#register-form').submit();
                } 
                
            });

            @if(\Session::has('messages'))
                toastr.error(
                    '{{session()->get('messages')}}', 'Wrong!',
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