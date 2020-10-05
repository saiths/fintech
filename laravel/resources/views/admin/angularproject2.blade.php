@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Project</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        <form id="register-form"  name="register_form" method="post"  enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="projectId"  ng-model="projectFormData.id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Project Name : </label>
                                        <div class="col-md-9">
                                            <input type="text" id="name" name="name" class="form-control borderred" id="inputEmail3"  placeholder="Project Name" ng-model="projectFormData.name">
                                            <span class="text-danger" id="emptyName"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Description : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" id="description"  name="description" rows="2" placeholder="Description"  ng-model="projectFormData.description">
                                            <span class="text-danger" id="emptyDescription"></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3 col-form-label">Select User : </label>
                                        <div class="col-md-9">
                                            <select class="select2 m-b-10 select2-multiple"    multiple 
                                            id="select2-with-tokenizer_project" data-placeholder="Serach Assign User Name" name="user_id[]" 
                                            style="width: 100%;height:50px;" ng-model="projectFormData.userIdArr">
                                                <?php
                                                    $getUserNameDatas = [];
                                                    $userIdsArr = [];   
                                                    $projectId = !empty($getEditProject->id) ? $getEditProject->id : '';
                                                    if (!empty($projectId)) {
                                                        $getProjectDatas =  DB::select('SELECT * FROM project_assing_user WHERE is_deleted_status = "N" 
                                                            AND project_id = '.$projectId.'');
                                                        if (!empty($getProjectDatas)) {
                                                            foreach ($getProjectDatas as $projects) {
                                                                $userIdArr[] = $projects->user_id;
                                                            }   
                                                        }

                                                        $userIdC = implode(',', $userIdArr);
                                                        $userIdD = !empty($userIdC) ? $userIdC : 0;

                                                        $getUserNameDatas = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND id IN('.$userIdD.')');
                                                        if (!empty($getUserNameDatas)) {
                                                            foreach ($getUserNameDatas as $user) {
                                                                $userIdsArr[] = $user->id;
                                                            } 
                                                        }
                                                    }
                                                    $getProjectTypeData = 
                                                    DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND role_id != 4 ORDER BY username ASC');
                                                ?>
                                                @if (!empty($getProjectTypeData))
                                                    @foreach($getProjectTypeData as $user)
                                                        <option value="{{$user->id}}"
                                                            <?php 
                                                            if (in_array($user->id, $userIdsArr)) {
                                                                echo 'selected=selected';
                                                            }
                                                            ?> >{{$user->username}}
                                                        </option>
                                                    @endforeach
                                                @endif 
                                            </select>
                                            <span class="text-danger" id="userIdsArrName"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9">
                                            <button type="button" id="lorderId" ng-if="!isInsert" ng-click="updateProjectData(projectFormData)" class="btn btn-success">Update
                                            </button>
                                            <button type="button" id="lorderId" ng-if="isInsert" ng-click="addProjectData(projectFormData)" class="btn btn-success">Save
                                            </button>
                                            <button type="button" id="cancelId" ng-click="resetProjectForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive"   ng-init="fetchProjectData()">
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" datatable="ng" dt-options="vm.dtOptions">
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Project Name</th>
                                        <th>Project Assign User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="project in projectData">
                                        <?php /*  <tr @if($project->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                >*/
                                        ?>                                 
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ project.name }}</td>
                                        <td>@{{ project.username }}</td>
                                        <td>
                                     <!--       <div class="tooltip1">    
                                                <a href="#" ng-click="showProjectData(project)" class="btn btn-xs btn-info"
                                                    style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                                </a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip1">
                                                <a href="#"  ng-click="deleteProjectData(project.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
                                                    <i class="ti-trash" ></i> 
                                                </a>
                                                <span class="tooltiptext">Delete</span>
                                            </div>-->
                                             <a href="#" ng-click="showProjectData(project)" class="btn btn-xs btn-info"
                                                style="padding: 0px 7px;"  > <i class="ti-pencil"></i> 
                                            </a>
                                            <a href="#"  ng-click="deleteProjectData(project.id)" class="btn btn-xs btn-danger"  style="padding: 0px 7px;">
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
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
   
    <script>
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
             
            $scope.projectFormData = {};
            $scope.isInsert = true;
            
            $scope.fetchProjectData = function() {
                $http.get("{{route('angularProject.view')}}").success(function(data) {
                    $scope.projectData = data;
                });     
            };

            $scope.showProjectData = function(data) {
                var description = $('#description').val(data.description);
                var name = $('#name').val(data.name);
                $("#lorderId").hide();
                $("#cancelId").hide();
                $http({
                    method: "POST",
                    url:    "{{route('angularProjectSelect.selected')}}",
                    data: {
                        'id': data.id
                    }   
                }).success(function(data) {
                    $('#select2-with-tokenizer_project').html(data);
                    $("#lorderId").show();
                    $("#cancelId").show();
                    $("#cancelId").attr("disabled", false);
                    $scope.isInsert = false;
                });
                
                $('#emptyDescription').hide();
                $('#emptyName').hide();
                $('#userIdsArrName').hide();
                $scope.projectFormData = angular.copy(data);
                
            };

            $scope.updateProjectData = function(data) {
                var userIdArr = $('#select2-with-tokenizer_project').val();
                data.userIdArr= userIdArr;
                var description = $('#description').val();
                var name = $('#name').val();
                
                /*if (name == '' ||  description == '' || userIdArr == '') {*/
                if (name == '' ||  description == '') {

                    /*if (userIdArr == '') {
                        $('#userIdsArrName').show();
                        $('#userIdsArrName').html('Please Select User Name.');
                    } else {
                        $('#userIdsArrName').hide();
                    }
*/
                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }

                    if (description == '') {
                        $('#emptyDescription').show();
                        $('#emptyDescription').html('Description field is Required.');
                    } else {
                        $('#emptyDescription').hide();
                    }
                    return false;

                } else {    
                    
                    $('#emptyDescription').hide();
                    $('#userIdsArrName').hide();
                    $('#emptyName').hide();
                    
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
                    
                    
                    $http.post("{{route('angularProject.edit')}}",data).success(function(data) {
                        
                        if (data.message == 1) {
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Update');
                            
                            $('#emptyName').show();
                            $('#emptyName').html('The Project Name has already been taken.');
                        } else {
                            $("#cancelId").attr("disabled", false);
                            $('#emptyName').hide();
                            $scope.isInsert = true;
                            $scope.projectFormData = {};
                            $scope.fetchProjectData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetProjectForm();
                            $("#lorderId").attr("disabled", false);
                            $("#lorderId").html('Save');
                        }

                    }); 
                }
            };

            $scope.addProjectData = function(data) {
                var userIdArr = $('#select2-with-tokenizer_project').val();
                var description = $('#description').val();
                var name = $('#name').val();
               /* if (description == '' ||  name == '' || userIdArr == '') {*/
                if (description == '' ||  name == '') {

                    /*if (userIdArr == '') {
                        $('#userIdsArrName').show();
                        $('#userIdsArrName').html('Please Select User Name.');
                    } else {
                        $('#userIdsArrName').hide();
                    }*/

                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }

                    if (description == '') {
                        $('#emptyDescription').show();
                        $('#emptyDescription').html('Description field is Required.');
                    } else {
                        $('#emptyDescription').hide();
                    }
                    return false;

                } else {

                    $('#emptyDescription').hide();
                    $('#userIdsArrName').hide();
                    $('#emptyName').hide();
                    
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                        
                    $http.post("{{route('angularProject.add')}}",data).success(function(data) {
                        if (data.message == 1) {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            $('#emptyName').show();
                            $('#emptyName').html('The Project Name has already been taken.');
                        } else {
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            $('#emptyName').hide();
                            $scope.isInsert = true;
                            $scope.projectFormData = {};
                            $scope.fetchProjectData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetProjectForm();
                        }

                    });

                }
            };
            
            $scope.deleteProjectData = function(id) {
                if (confirm("Are you Want to delete?") == true) {
                    $http({
                        method: "POST",
                        url:    "{{route('angularProject.delete')}}",
                        data: {
                            'id': id
                        }   
                    }).success(function(data) {
                        $scope.fetchProjectData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetProjectForm();
                    });
                } 
            };

            $scope.resetProjectForm = function() {
                $scope.isInsert = true;
                $('#name').val('');
                $('#description').val('');
                $('#emptyDescription').hide();
                $('#emptyName').hide();
                $('#userIdsArrName').hide();
                $('#select2-with-tokenizer_project').val(['0']);
                $('#select2-with-tokenizer_project').trigger('change');
            }

        });
    </script>
    </body>
</html>




