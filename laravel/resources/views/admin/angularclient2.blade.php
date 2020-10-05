@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Client</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        <form  enctype="multipart/form-data" autocomplete="off" id="register-form" >
                            <input type="hidden" name="clientId"  value="" ng-model="clientFormData.id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Name : </label>
                                        <div class="col-md-9">
                                            <input type="text"  id="name" name="name" class="form-control borderred" 
                                            id="inputEmail3" placeholder="Name" ng-model="clientFormData.name">
                                            <span class="text-danger" id="emptyName"></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Email : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" type="text"  placeholder="Email" id="email" name="email" ng-model="clientFormData.email">
                                            <span class="text-danger" id="emptyEmail"></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Mobile : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred"  type="text" name="mobile" id="number"  placeholder="Mobile" maxlength="10" ng-model="clientFormData.mobile">
                                            <span class="text-danger" id="emptyMobile"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Address : </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Address" id="address" 
                                            name="address"  ng-model="clientFormData.address">
                                            <span class="text-danger" id="emptyAddress"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label"> Select Project : </label>
                                        <div class="col-md-9">
                                            <select class="select2 m-b-10 select2-multiple" multiple="" id="select2-with-tokenizer" 
                                            style="width: 100%;height:50px;" data-placeholder="Serach Project Name" name="project_id[]" ng-model="clientFormData.projectIdArr">
                                                <?php
                                                    $getProjectDatas = [];
                                                    $projectArr = [];
                                                    if (!empty($getEditClient->id)) {
                                                        $getProjectDatas = 
                                                        DB::select('SELECT * FROM client_project_master WHERE is_deleted_status =  "N" AND client_id = 
                                                            '.$getEditClient->id.'  ');
                                                        if (!empty($getProjectDatas)) {
                                                            foreach ($getProjectDatas as $projects) {
                                                                $projectArr[] = $projects->project_id;
                                                            }   
                                                        }
                                                    }
                                                    $getProjectData = DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N" ORDER BY name ASC');
                                                ?>
                                                @if (!empty($getProjectData))
                                                    @foreach($getProjectData as $project)
                                                        <option value="{{$project->id}}"
                                                            <?php 
                                                            if (in_array($project->id, $projectArr)) {
                                                                echo 'selected=selected';
                                                            }
                                                            ?> >{{$project->name}}
                                                        </option>
                                                    @endforeach
                                                @endif 
                                            </select> 
                                            @if (!empty($emptyErrorMsg['checkProjectMsg']))
                                                <span class="text-danger">{{$emptyErrorMsg['checkProjectMsg']}}</span>
                                            @endif
                                            <span class="text-danger" id="projectArrName"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4 col-form-label" style="margin-left: -36px">
                                        Contact Person : </label>
                                        <div class="col-md-8">
                                            <input class="form-control borderred" style="width: 113%"   type="text" name="contact_person" id="contact_person" placeholder="Contact Person"  ng-model="clientFormData.contact_person" >
                                            <span class="text-danger" id="emptyContactPerson"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9">
                                            <button type="button" id="lorderId"  ng-if="!isInsert" ng-click="updateClientData(clientFormData)" class="btn btn-success">
                                                Update
                                            </button>
                                            <button type="button" id="lorderId" ng-if="isInsert" ng-click="addClientData(clientFormData)" class="btn btn-success">
                                                Save
                                            </button>
                                            <button type="button" ng-click="resetClientForm()" id="cancelId" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive" ng-init="fetchClientData()" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" datatable="ng" dt-options="vm.dtOptions" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Contact Person</th>
                                        <th>Project Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="client in clientData">
                                        <?php /*<tr @if($client->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                > */
                                        ?>         
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ client.name }}</td>
                                        <td>@{{ client.email }}</td>
                                        <td>@{{ client.mobile }}</td>
                                        <td>@{{ client.contact_person }}</td>
                                        <td>
                                            <span ng-repeat="projectname in clientData[$index].projectname">
                                                <span class="tooltip1" style="border:none;" ng-if="client.username[projectname]!=''" >
                                                    <a href="#"  class="btn btn-xs btn-primary" style="padding: 0px 7px;"> 
                                                        @{{projectname}} 
                                                    </a>    
                                                    <span class="tooltiptext" >@{{ client.username[projectname] }}</span>
                                                </span>
                                                <span style="border:none;" ng-if="client.username[projectname]==''" >
                                                    <a href="#"  class="btn btn-xs btn-primary" style="padding: 0px 7px;"> 
                                                        @{{projectname}} 
                                                    </a>    
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <!--<div class="tooltip1">    
                                                <a href="#" ng-click="showClientData(client)" class="btn btn-xs btn-info"
                                                    style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                                </a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip1">
                                                <a href="#"  ng-click="deleteClientData(client.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
                                                    <i class="ti-trash" ></i> 
                                                </a>
                                                <span class="tooltiptext">Delete</span>
                                            </div>-->
                                            <a href="#" ng-click="showClientData(client)" class="btn btn-xs btn-info"
                                                style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                            </a>
                                            <a href="#"  ng-click="deleteClientData(client.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
                                                <i class="ti-trash" ></i> 
                                            </a>
                                        </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="chat-windows"></div>
    @include('admin.common.script2')
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.7.9/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
    
    <script>
        angular.module('myApp', ['datatables'])
            .config(['$sceDelegateProvider', function($sceDelegateProvider) {
            $sceDelegateProvider.resourceUrlWhitelist([
                'self',
                'https://angularjs.org/**'
            ]);
        }])
        .controller('mainCtrl', ['$scope', '$http',
            function($scope, $http) {
                $scope.clientFormData = {};
                $scope.isInsert = true;

                
                $scope.fetchClientData = function() {
                    $http({
                        method: 'GET', 
                        url: "{{route('angularClient.view')}}", 
                    }).then(function(data) {
                        $scope.clientData = data.data;
                    });
                };

                $scope.showClientData = function(data) {
                    var name = $('#name').val(data.name);
                    var email = $('#email').val(data.email);
                    var mobile = $('#number').val(data.mobile);
                    var address = $('#address').val(data.address);
                    var contact_person = $('#contact_person').val(data.contact_person);
                    $("#lorderId").html('Update');
                   // $("#cancelId").hide();
                    $http({
                        method: "POST",
                        url:    "{{route('angularClientProject.selected')}}",
                        data: {
                            'id': data.id
                        }
                    }).then(function(data) {
                        $('#select2-with-tokenizer').html(data.data);
                        $("#lorderId").show();
                        $("#cancelId").show();
                        $scope.isInsert = false;
                    });

                    $('#emptyName').hide();
                    $('#emptyAddress').hide();
                    $('#emptyContactPerson').hide();
                    $('#emptyEmail').hide();
                    $('#emptyMobile').hide();
                    $('#projectArrName').hide();
                    $scope.clientFormData = angular.copy(data);
                };

                $scope.updateClientData = function(data) {
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var mobile = $('#number').val();
                    var address = $('#address').val();
                    var contactPerson = $('#contact_person').val();
                    var projectIdArr = $('#select2-with-tokenizer').val();
                    data.projectIdArr= projectIdArr;

                    /*if (name == '' ||  email == '' || mobile == '' || address == '' || contactPerson == '' || projectIdArr == '') {*/
                    
                    if (name == '' ||  email == '' || mobile == '' ||  contactPerson == '') {
                        
                        /*
                        if (projectIdArr == '') {
                            $('#projectArrName').show();
                            $('#projectArrName').html('Please Select Project Name.');
                        } else {
                            $('#projectArrName').hide();
                        }*/

                        if (name == '') {
                            $('#emptyName').show();
                            $('#emptyName').html('Name field is Required.');
                        } else {
                            $('#emptyName').hide();
                        }

                        if (email == '') {
                            $('#emptyEmail').show();
                            $('#emptyEmail').html('Email field is Required.');
                        } else {
                            $('#emptyEmail').hide();
                        }

                        if (mobile == '') {
                            $('#emptyMobile').show();
                            $('#emptyMobile').html('Mobile field is Required.'); 
                        } else {
                            $('#emptyMobile').hide();
                        }

                        /*if (address == '') {
                            $('#emptyAddress').show();
                            $('#emptyAddress').html('Address field is Required.');
                        } else {
                            $('#emptyAddress').hide();
                        }*/
                        
                        if (contactPerson == '') {
                            $('#emptyContactPerson').show();
                            $('#emptyContactPerson').html('Contact Person field is Required.');
                        } else {
                            $('#emptyContactPerson').hide();
                        }
                        return false;


                    } else if (email != '' || mobile != '') {

                        $('#emptyName').hide();
                        //$('#emptyAddress').hide();
                        $('#emptyContactPerson').hide();
                        $('#emptyEmail').hide();
                        $('#emptyMobile').hide();
                        $('#projectArrName').hide();
                                
                        var validEmail =    isEmail(email);
                        var validMobile =  isMobile(mobile);
                            
                        if (validEmail == false || validMobile == false) {

                            if (validEmail == false) {
                                $('#emptyEmail').show();
                                $('#emptyEmail').html('Please enter a valid email address.');
                            } else {
                                $('#emptyEmail').hide();
                            }

                            if (validMobile == false) {
                                $('#emptyMobile').show();
                                $('#emptyMobile').html('Please enter 10 digit mobile number.');
                            } else {
                                $('#emptyMobile').hide();
                            }

                            return false;

                        } else {
                            
                            $('#emptyName').hide();
                            // $('#emptyAddress').hide();
                            $('#emptyContactPerson').hide();
                            $('#emptyEmail').hide();
                            $('#emptyMobile').hide();
                            $('#projectArrName').hide();
                            
                            $("#lorderId").attr("disabled", true);
                            $("#cancelId").attr("disabled", true);
                            $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
                            
                            $http.post("{{route('angularClient.edit')}}",data).then(function(data) {
                                
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Update');
                                
                                if (data.data.emailText == 'emailText' || data.data.mobileText == 'mobileText') {

                                    if (data.data.emailText == 'emailText') {
                                        $('#emptyEmail').show();
                                        $('#emptyEmail').html('The Email has already been taken.');
                                    } else {
                                        $('#emptyEmail').hide();
                                    }

                                    if (data.data.mobileText == 'mobileText') {
                                        $('#emptyMobile').show();
                                        $('#emptyMobile').html('The Mobile has already been taken.');
                                    } else {
                                        $('#emptyMobile').hide();
                                    }
                                    
                                } else {

                                    $scope.isInsert = true;
                                    $scope.clientFormData = {};
                                    $scope.fetchClientData();
                                    setTimeout(function() {
                                        toastr.success(
                                            data.data.message, 'Success!',
                                            { 
                                                "closeButton": true,
                                                timeOut: 3000 
                                            }
                                        );
                                    }, 1000);
                                    $scope.resetClientForm();
                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                }
                                
                            });
                        }
                    } 
                };

                $scope.addClientData = function(data) {

                    var projectIdArr = $('#select2-with-tokenizer').val();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var mobile = $('#number').val();
                    var address = $('#address').val();
                    var contactPerson = $('#contact_person').val();

                   /* if (name == '' ||  email == '' || mobile == '' || address == '' || contactPerson == '' || projectIdArr == '') {*/
                   
                    if (name == '' ||  email == '' || mobile == '' ||  contactPerson == '') {
                        
                        /*if (projectIdArr == '') {
                            $('#projectArrName').show();
                            $('#projectArrName').html('Please Select Project Name.');
                        } else {
                            $('#projectArrName').hide();
                        }*/
                        
                        if (name == '') {
                            $('#emptyName').show();
                            $('#emptyName').html('Name field is Required.');
                        } else {
                            $('#emptyName').hide();
                        }

                        if (email == '') {
                            $('#emptyEmail').show();
                            $('#emptyEmail').html('Email field is Required.');
                        } else {
                            $('#emptyEmail').hide();
                        }

                        if (mobile == '') {
                            $('#emptyMobile').show();
                            $('#emptyMobile').html('Mobile field is Required.'); 
                        } else {
                            $('#emptyMobile').hide();
                        }

                        /*if (address == '') {
                            $('#emptyAddress').show();
                            $('#emptyAddress').html('Address field is Required.');
                        } else {
                            $('#emptyAddress').hide();
                        }*/

                        if (contactPerson == '') {
                            $('#emptyContactPerson').show();
                            $('#emptyContactPerson').html('Contact Person field is Required.');
                        } else {
                            $('#emptyContactPerson').hide();
                        }

                        return false;

                    } else if (email != '' || mobile != '') {

                        $('#emptyName').hide();
                        //  $('#emptyAddress').hide();
                        $('#emptyContactPerson').hide();
                        $('#emptyEmail').hide();
                        $('#emptyMobile').hide();
                        $('#projectArrName').hide();
                        
                        var validEmail =  isEmail(email);
                        var validMobile =  isMobile(mobile);
                        
                        if (validEmail == false || validMobile == false) {
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                    
                            if (validEmail == false) {
                                $('#emptyEmail').show();
                                $('#emptyEmail').html('Please enter a valid email address.');
                            } else {
                                $('#emptyEmail').hide();
                            }

                            if (validMobile == false) {
                                $('#emptyMobile').show();
                                $('#emptyMobile').html('Please enter 10 digit mobile number.');
                            } else {
                                $('#emptyMobile').hide();
                            }
                            return false;

                        } else {
                            $('#emptyName').hide();
                           // $('#emptyAddress').hide();
                            $('#emptyContactPerson').hide();
                            $('#emptyEmail').hide();
                            $('#emptyMobile').hide();
                            $('#projectArrName').hide();
                            
                            $("#lorderId").attr("disabled", true);
                            $("#cancelId").attr("disabled", true);
                            $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                            
                            $http.post("{{route('angularClient.add')}}",data).then(function(data) {
                                if (data.data.emailText == 'emailText' || data.data.mobileText == 'mobileText') {
                                    if (data.data.emailText == 'emailText') {
                                        $('#emptyEmail').show();
                                        $('#emptyEmail').html('The Email has already been taken.');
                                    } else {
                                        $('#emptyEmail').hide();
                                    }
                                    if (data.data.mobileText == 'mobileText') {
                                        $('#emptyMobile').show();
                                        $('#emptyMobile').html('The Mobile has already been taken.');
                                    } else {
                                        $('#emptyMobile').hide();
                                    }
                                } else {
                                    $("#lorderId").attr("disabled", false);
                                    $("#cancelId").attr("disabled", false);
                                    $("#lorderId").html('Save');
                                    $scope.isInsert = true;
                                    $scope.clientFormData = {};
                                    $scope.fetchClientData();
                                    setTimeout(function() {
                                        toastr.success(
                                            data.data.message, 'Success!',
                                            { 
                                                "closeButton": true,
                                                timeOut: 3000 
                                            }
                                        );
                                    }, 1000);
                                    $scope.resetClientForm();
                                }   
                            });
                        } 
                    
                    }
                };
            
                $scope.deleteClientData = function(id) {
                    if (confirm("Are you Want to delete?") == true) {
                        $http({
                            method: "POST",
                            url:    "{{route('angularClient.delete')}}",
                            data: {
                                'id': id
                            }   
                        }).then(function(data) {
                            $scope.fetchClientData();
                            setTimeout(function() {
                                toastr.success(
                                    data.data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetClientForm();
                        });
                           
                    } 
                };
                
                $scope.resetClientForm = function() {
                    $scope.isInsert = true;
                    $('#name').val('');
                    $('#email').val('');
                    $('#number').val('');
                    $('#address').val('');
                    $('#contact_person').val('');
                    $('#contact_person').val('');
                    $('#emptyName').hide();
                   // $('#emptyAddress').hide();
                    $('#emptyContactPerson').hide();
                    $('#emptyEmail').hide();
                    $('#emptyMobile').hide();
                    $('#projectArrName').hide();
                    $('#select2-with-tokenizer').val(['0']);
                    $('#select2-with-tokenizer').trigger('change');
                };
            }
        ]);
        
        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function isMobile(mobile) {
            if (mobile.length == 10) {
                return true;
            } else {
                return false;    
            }
        }
    </script>
    </body>
</html>
