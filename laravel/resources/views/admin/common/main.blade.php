@if(!empty(Session::get('sessionUserData'))) 
@else
    <script type="text/javascript">
        window.location.href = '{{url("/")}}'; 
    </script>
@endif
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        @if(Request::segment(1) == 'dashboard')
            <title>Fintech | Dashboard</title>
        @endif

        @if(Request::segment(1) == 'user' ||  Request::segment(1) == 'addUser')
            <title>Fintech | User Master</title>
        @endif
        
        @if(Request::segment(1) == 'machine')
            <title>Fintech | Machine Master</title>
        @endif
            
    
        @if(Request::segment(1) == 'process')
            <title>Fintech | Process Master</title>
        @endif

        @if(Request::segment(1) == 'itemcategory')
            <title>Fintech | Item Category Master</title>
        @endif

        @if(Request::segment(1) == 'itemattribute')
            <title>Fintech | Item Attribute Master</title>
        @endif

        @if(Request::segment(1) == 'item' || Request::segment(1) == 'itemsssssss')
            <title>Fintech | Item Master</title>
        @endif

        @if(Request::segment(1) == 'changepassword' || Request::segment(1) == 'achangepassword' )
            <title>Fintech | Change Password</title>
        @endif

        @if(Request::segment(1) == 'purchaseser' || Request::segment(1) == 'addPurchase' || 
        Request::segment(1) == 'purchasesers' || Request::segment(1) == 'purchase')
            <title>Fintech | Purchase</title>
        @endif
        
        
        @if(Request::segment(1) == 'purchaseorder' || Request::segment(1) == 'addPurchaseOrder')
            <title>Fintech | Purchase Order(PO)</title>
        @endif
        
        @if(Request::segment(1) == 'editprofile' || Request::segment(1) == 'updateprofile' || Request::segment(1) == 'aeditprofile')
            <title>Fintech | Edit Profile</title>
        @endif


        
        <meta name="description" content="Updates and statistics" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

        <link href="{{ URL::asset('public/admin/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.5') }}" rel="stylesheet"  type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
        
        <link href="{{ URL::asset('public/admin/dist/assets/plugins/global/plugins.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/css/style.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/header/base/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/header/menu/light.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/brand/dark.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('public/admin/dist/assets/css/themes/layout/aside/dark.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
        
        <link rel="shortcut icon" href="{{ URL::asset('public/admin/dist/assets/media/logos/favicon.ico') }}" />

        <link href="{{ URL::asset('public/admin/toastr/dist/build/toastr.min.css')}}" rel="stylesheet">
        
        <style>
            .toast-success {
                background-color: #8B4513	 !important;
            }
            .btn.btn-primary {
                color: #FFFFFF;
                background-color: #8B4513 !important;
                border-color: #8B4513 !important; 
            }
        </style>
    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" ng-app="myApp" ng-controller="mainCtrl">
        <style>
            .abc {
                border-color:red;
            }
        </style>
        <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                    <span></span>
                </button>
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">  
                @include('admin.common.slider') 
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include('admin.common.header')
                
                















