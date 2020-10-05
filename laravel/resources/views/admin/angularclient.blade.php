@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">@{{ isInsert? 'Add Client':'Edit  Client' }}</h3>
            <p class="text-muted m-b-30 font-13 "><span class="text-danger"> *Indicates Required Field </span></p>
            <form class="form-horizontal" autocomplete="off" class="form-horizontal" id="register-form">
                <input type="hidden" name="clientId"  value="" ng-model="clientFormData.id">
                <div class="row">
                    <div  class="col-md-6">
                        <div class="form-group has-feedback">
                            <label for="inputEmail3" class="col-sm-3 control-label ">Name<b class="text-danger">*</b>
                            </label>
                            <div class="col-sm-9">
                                <input type="text"  id="name" name="name" class="form-control" 
                                style="border:1px solid #e74a25!important" id="inputEmail3" placeholder="Name" 
                                ng-model="clientFormData.name"> 
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="form-group has-feedback">
                            <label for="inputEmail3" class="col-sm-3 control-label">Address<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <textarea class="form-control"  style="height: 39px; border:1px solid #e74a25!important" id="address" name="address" rows="2" placeholder="Address" ng-model="clientFormData.address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label for="inputEmail3" class="col-sm-3 control-label">Email<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input class="form-control" style="border:1px solid #e74a25!important" type="text"  
                                placeholder="Email" id="email" name="email" ng-model="clientFormData.email">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label for="inputEmail3" class="col-sm-3 control-label">Mobile<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                              <input class="form-control" style="border:1px solid #e74a25!important" type="text" name="mobile" id="number"  ng-model="clientFormData.mobile" placeholder="Mobile" maxlength="10" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('contact_person') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">ContactPerson<b class="text-danger">*</b>
                            </label>
                            <div class="col-sm-9">
                                <input class="form-control"  ng-model="clientFormData.contact_person"  type="text" name="contact_person" id="contact_person" placeholder="Contact Person" style="border:1px solid #e74a25!important">
                            </div>
                        </div>
                    </div>
                </div>
                <?php /*
                <div class="col-md-6">
                    <div class="form-group has">
                        <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;Select Project</label>
                        <div class="col-sm-8" > 
                            <select class="select2 m-b-10 select2-multiple" style="width: 113%;" multiple id="project_select" data-placeholder="Serach Project Name" name="project_id[]">
                                <?php
                                    $getProjectDatas = [];
                                    $projectArr = [];
                                    if (!empty($getEditClient->id)) {
                                        $getProjectDatas = DB::select('SELECT * FROM client_project_master WHERE is_deleted_status =  "N" AND client_id = 
                                            '.$getEditClient->id.'');
                                        if (!empty($getProjectDatas)) {
                                            foreach ($getProjectDatas as $projects) {
                                                $projectArr[] = $projects->project_id;
                                            }   
                                        }
                                    }
                                    $getProjectData = 
                                    DB::select('SELECT * FROM project_master WHERE is_deleted_status = "N"');
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
                            <span class="text-danger" id="assignUserId">{{ $errors->first('project_id') }}</span>
                        </div>
                    </div>
                </div> 
                */?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                                <button type="button" ng-if="!isInsert" ng-click="updateClientData(clientFormData)" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <button type="button" ng-if="isInsert" ng-click="addClientData(clientFormData)" class="btn btn-block btn-primary"> 
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                            <div class="col-md-3" style="margin-left: -25px;">
                                <button type="button" onclick="resetClientForm()" class="btn btn-block btn-default">
                                    <i class="icon-close"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row" >
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Client</h3>
            <div class="clearfix"></div>
            <div class="table-responsive"  ng-init="fetchClientData()">
                <style type="text/css">
                    .table td{
                        padding: 0.1rem !important;
                        vertical-align: top;
                        border-top: 1px solid #dee2e6;
                    }
                </style>
                <table id="myTable" class="table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Mobile</th>
                          <!--   <th>Project Name</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="client in clientData">
                            <td>@{{ $index + 1 }}</td>
                            <td>&nbsp;@{{ client.name }}</td>
                            <td>&nbsp;&nbsp;&nbsp;@{{ client.contact_person }}</td>
                            <td>&nbsp;@{{ client.email }}</td>
                            <td>&nbsp;@{{ client.mobile }}</td>
                            <?php
                             /* <td>
                                
                                  $projectName = '';
                                    $getProjectDatad =  
                                    DB::select('SELECT * FROM client_project_master WHERE is_deleted_status = "N"
                                        AND client_id = '.$client->id.'');
                                    $projectArrs = [];
                                    if (!empty($getProjectDatad)) {
                                        foreach ($getProjectDatad as $projects) {
                                            $projectArrs[] = $projects->project_id;
                                        }   
                                    }
                                    if (!empty($projectArrs)) {
                                        $projectIds = implode(',', $projectArrs);
                                    } else {
                                        $projectIds = 0;
                                    }
                                    
                                    $getProjectNameDatad =   DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N"  AND id IN('.$projectIds.')');
                                    $i = 1;
                                    if (!empty($getProjectNameDatad)) {
                                        foreach ($getProjectNameDatad as $project) {
                                            echo '<b>['.$i.']</b>&nbsp;'.$project->name.' ';
                                            $i++;
                                        } 

                                    }
                                
                            </td>*/
                            ?>
                            <td>
                                <a href="#" ng-click="showClientData(client)" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit" style="padding: 0px 7px;" ><i class="icon-pencil"></i> </a>
                                <a href="#"  ng-click="deleteClientData(client.id)" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')" style="padding: 0px 7px;"><i class="icon-trash"></i> </a>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.common.script')

<script type="text/javascript">
    function resetClientForm() {
        window.location.href="{{ route('client') }}";
    }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

<script>
    
    var app = angular.module("myApp", []);
    app.controller("clientCtrl", function($scope,$http) {
         
        $scope.clientFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchClientData = function() {
            $http.get("{{route('angularClient.view')}}").success(function(data) {
                $scope.clientData = data;
            });     
        };

        $scope.showClientData = function(data) {
            $scope.isInsert = false;
            $scope.clientFormData = angular.copy(data);
        };

        $scope.updateClientData = function(data) {
            $http.post("{{route('angularClient.edit')}}",data).success(function(data) {
                $.toast({
                    heading: 'Success!',
                    position: 'top-right',
                    text: data.message,
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
                $scope.isInsert = true;
                $scope.clientFormData = {};
                $scope.fetchClientData();
            }); 
        };

        $scope.addClientData = function(data) {
            $http.post("{{route('angularClient.add')}}",data).success(function(data) {
                $.toast({
                    heading: 'Success!',
                    position: 'top-right',
                    text: data.message,
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
                $scope.isInsert = true;
                $scope.clientFormData = {};
                $scope.fetchClientData();
            }); 
        };
        
        $scope.deleteClientData = function(id) {
            $http({
                method: "POST",
                url:    "{{route('angularClient.delete')}}",
                data: {
                    'id': id
                }   
            }).success(function(data) {
                $.toast({
                    heading: 'Success!',
                    position: 'top-right',
                    text: data.message,
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
                $scope.fetchClientData();
            }); 
        };
    });

</script>

<script>
    $(function() {
        $("#register-form").validate({
            rules: {
                address : {
                    required: true
                },
                mobile : {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                      
                },
                contact_person: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
            },
            // Specify the validation error messages
            messages: {
                mobile: "<span class='text-danger'>The Mobile field is required.</span>",
                address: "<span class='text-danger'>The Address field is required.</span>",
                contact_person: "<span class='text-danger'>The Contact Person field is required.</span>",
                
                name: "<span class='text-danger'>The Name field is required.</span>",
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

