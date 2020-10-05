@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Form Permission</h4>
                        <style type="text/css">
                            .rounds {
                                position: relative;
                            }
                            .rounds label {
                                background-color: #fff;
                                border: 1px solid #ccc;
                                border-radius: 5%;
                                cursor: pointer;
                                height: 21px;
                                left: 0;
                                position: absolute;
                                top: 0;
                                width: 20px;
                            }
                            .rounds label:after {
                                border: 2px solid #fff;
                                border-top: none;
                                border-right: none;
                                content: "";
                                height: 5px;
                                left: 5px;
                                opacity: 0;
                                position: absolute;
                                top: 6px;
                                transform: rotate(-45deg);
                                width: 11px;
                            }
                            .rounds input[type="checkbox"] {
                                visibility: hidden;
                            }
                            .rounds input[type="checkbox"]:checked + label {
                                background-color: #00bbd9;
                                border-color: #00bbd9;
                            }
                            .rounds input[type="checkbox"]:checked + label:after {
                                opacity: 1;
                            }
                        </style>
                        <form class="form-horizontal" id="register-form" method="post"  autocomplete="off" 
                        action="{{route('formpermission.add')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="rounds">
                                        <input type="checkbox"  id="userIds" value="userList" class="pull-left" >
                                        <label for="userIds" style=" border-radius: 18%;margin-left: 240px;margin-top: 23px;">
                                        </label>
                                    </div>
                                    <?php 
                                        $userPerIdArrs = [];
                                        $formPerIdArrs = [];
                                        $getFormPramissionData = DB::select('SELECT * FROM `form_permission` WHERE is_deleted_status = "N"');
                                        if (!empty($getFormPramissionData)) {
                                            foreach ($getFormPramissionData as $formPermission) {
                                                $userPerIdArr[] = $formPermission->user_id;
                                                $formPerIdArr[] = $formPermission->form_id;
                                            }
                                        }
                                        $userPerIdArrs = !empty($userPerIdArr) ? array_unique($userPerIdArr) : 0;
                                        $formPerIdArrs = !empty($formPerIdArr) ? array_unique($formPerIdArr) : 0;

                                    ?>  
                                    <h3 class="text-center">User List</h3>
                                    <div class="well" style="max-height: 300px;overflow: auto;">
                                        <ul id="check-list-box" class="list-group checked-list-box" >
                                            <?php 
                                                $getRoleData  = DB::select('SELECT * FROM `role_master` 
                                                    WHERE is_deleted_status = "N" AND id != 1 ORDER BY `role_name` ASC');
                                                foreach ($getRoleData as $role) {
                                            ?>
                                                    <li class="list-group-item" style="padding: 6px 7px 9px 5px">
                                                        <div class="rounds">
                                                            &nbsp;&nbsp;<input type="checkbox"  
                                                            onclick="selectAll('<?php echo $role->role_name; ?>')" id="roleId_<?php echo $role->role_name; ?>" class="pull-left_<?php echo $role->role_name; ?>"  value="<?php echo $role->role_name; ?>">
                                                            <label for="roleId_<?php echo $role->role_name; ?>" style="border-radius: 50%;"></label>&nbsp;
                                                            <b><?php echo $role->role_name;?></b>
                                                        </div>
                                                    </li>   

                                                    <ul id="selectUserAll_<?php echo $role->role_name; ?>" >
                                                        <?php 
                                                            $getUserData  = 
                                                            DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND 
                                                            role_id = '.$role->id.' ORDER BY `username` ASC');
                                                            if (!empty($getUserData)) {
                                                                foreach ($getUserData as $user) {
                                                        ?>      
                                                                    <li class="list-group-item" style="padding: 7px 3px 10px 10px;">
                                                                        <div class="rounds">
                                                                            <input type="checkbox"   id="userId_{{$user->id}}" 
                                                                            class="pull-left_" name="userIdArr[]"  
                                                                            <?php 
                                                                                if (!empty($userPerIdArr)) {
                                                                                    if(in_array($user->id, $userPerIdArrs)) {
                                                                                        echo 'checked="checked"';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            value="{{$user->id}}">&nbsp;&nbsp;&nbsp; 
                                                                            <label for="userId_{{$user->id}}"></label>
                                                                            {{$user->username}} 
                                                                        </div>
                                                                    </li>
                                                                <?php      
                                                                }
                                                            } else {
                                                        ?>
                                                                <!--<li class="list-group-item" style="padding: 7px 3px 10px 10px;">
                                                                    No data available in List
                                                                </li>
                                                                -->
                                                            <?php
                                                            }
                                                        ?>
                                                    </ul>
                                                <?php 
                                                }
                                            ?>                              
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rounds">
                                        <input type="checkbox"  id="formIds" value="formList" class="pull-left" >
                                        <label for="formIds" style="border-radius: 18%;margin-left: 235px;margin-top: 23px;">
                                        </label>
                                    </div>
                                    <h3 class="text-center">Form List</h3>
                                    <div class="well" style="max-height: 300px;overflow: auto;" id="check_list_box_form" >
                                        <ul id="check_list_box_form1" class="list-group checked-list-box">   
                                        <?php 
                                            $getMasterData  = DB::select('SELECT * FROM `master` WHERE is_deleted_status = "N" ORDER BY `order_wise` ASC');
                                            $formTypeData = '';
                                            foreach ($getMasterData as $master) { 
                                            ?> 

                                                <li class="list-group-item" style="padding: 6px 7px 9px 5px">
                                                    <div class="rounds">
                                                        &nbsp;&nbsp;<input type="checkbox" 
                                                        onclick="selectAll('<?php echo $master->id; ?>')" 
                                                        id="masterId_<?php echo $master->id; ?>" class="pull-left_<?php echo $master->id; ?>"  
                                                        value="<?php echo $master->id; ?>">
                                                        <label for="masterId_<?php echo $master->id; ?>" 
                                                            style=" border-radius: 50%;">
                                                        </label>&nbsp;
                                                        <b><?php echo $master->form_type;?></b>
                                                    </div>
                                                </li>   

                                                <ul id="selectFormAll_<?php echo  $master->id; ?>" >
                                                    <?php 
                                                        $getFormMasterData  = 
                                                        DB::select('SELECT * FROM `form_master` WHERE is_deleted_status = "N" AND master_id = '.$master->id.' ORDER BY `order_wise` ASC');
                                                        if (!empty($getFormMasterData)) {
                                                            foreach ($getFormMasterData as $formMasterData) {

                                                    ?>
                                                                <li class="list-group-item" style="padding: 7px 3px 10px 10px;"  >
                                                                    <div class="rounds">
                                                                        <input type="checkbox"  id="formId_{{$formMasterData->id}}" class="pull-left_" name="formIdArr[]" 
                                                                        <?php 
                                                                            if (!empty($formPerIdArr)) {
                                                                                if(in_array($formMasterData->id, $formPerIdArrs)) {
                                                                                    echo 'checked="checked"';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        value="{{$formMasterData->id}}">&nbsp;&nbsp;&nbsp;<label for="formId_{{$formMasterData->id}}"></label>
                                                                        {{$formMasterData->form_name}} 
                                                                    </div>
                                                                </li>
                                                            <?php 
                                                            }
                                                        } else {
                                                            ?>
                                                                <!--<li class="list-group-item" style="padding: 7px 3px 10px 10px;">
                                                                    No data available in List
                                                                </li>
                                                                -->
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </ul>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4 text-center">
                                    <!-- <button type="button" ng-if="isInsert" ng-click="updateFormPermissionData(formPermissionData)" class="btn btn-success">Submit</button>
                                     -->
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="button" onclick="resetFormPermission()" class="btn btn-dark">Cancel</button>
                                </div>     
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    @include('admin.common.script2')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

    <script>
        var app = angular.module("myApp", []);
        app.controller("mainCtrl", function($scope,$http) {
            
            $scope.formPermissionData = {};
            $scope.isInsert = true;
            <?php 
            /*$scope.fetchFormPermissionData = function() {
                $http.get("{{route('angularFormPermissionData.view')}}").success(function(data) {
                    $scope.currentDate = '<?php echo date('d-m-Y'); ?>';
                    $scope.formPermissionData = data;  
                });     
            };

            $scope.updateFormPermissionData = function(data) {
                $http.post("{{route('angularFormPermissionData.edit')}}",data).success(function(data) {
                    toastr.success(
                        data.message, 'Success!',
                        { 
                            "closeButton": true,
                            timeOut: 3000 
                        }
                    );

                    $scope.isInsert = true;
                    $scope.formPermissionData = {};
                    $scope.fetchFormPermissionData();
                });   
            };*/
            ?>
        });
    </script>
    <script>

        function resetFormPermission() {
            window.location.href="{{ route('aformpermission') }}";
        }

        $("#userIds").click(function () {
            <?php 
                $getRoleData  = DB::select('SELECT * FROM `role_master` WHERE is_deleted_status = "N" AND id != 1 ORDER BY `role_name` ASC');
                foreach ($getRoleData as $role) {
            ?>      
                    $('#roleId_<?php echo $role->role_name; ?>').not(this).prop('checked', this.checked);
                    <?php 
                    $getUserData  = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND 
                        role_id = '.$role->id.' ORDER BY `username` ASC');
                    if (!empty($getUserData)) {
                        foreach ($getUserData as $user) {
                        ?>              
                            $('#userId_<?php echo $user->id; ?>').not(this).prop('checked', this.checked);
                        <?php 
                        }
                    }
                }
            ?>
        });


        $("#formIds").click(function () {
            <?php 
                $getMasterData  = DB::select('SELECT * FROM `master` WHERE is_deleted_status = "N" ORDER BY `order_wise` ASC');
                $formTypeData = '';
                foreach ($getMasterData as $master) { 
            ?>      
                    $('#masterId_<?php echo $master->id; ?>').not(this).prop('checked', this.checked);
                    <?php 
                    $getFormMasterData  = DB::select('SELECT * FROM `form_master` WHERE is_deleted_status = "N" AND master_id = '.$master->id.' ORDER BY `order_wise` ASC');
                    if (!empty($getFormMasterData)) {
                        foreach ($getFormMasterData as $formMasterData) {
                    ?>  
                            $('#formId_<?php echo $formMasterData->id; ?>').not(this).prop('checked', this.checked);
                            <?php 
                        }
                    }
                }
            ?>
        });

        function selectAll(roleIds) {
            /*-------- User List --------------*/
            if ($('#roleId_'+roleIds).is(':checked')) {
                <?php 
                    $selectAllfrom = '';
                    $getRoleData  = DB::select('SELECT * FROM `role_master` WHERE is_deleted_status = "N" AND role_name != 1');
                    if (!empty($getRoleData)) {
                        foreach ($getRoleData as $role) {
                    ?>
                            var roleId = '<?php echo  $role->role_name; ?>';
                            if (roleIds == roleId) {       
                                $('#selectUserAll_'+roleIds).html(''); 
                                <?php 
                                $getUserData  = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND 
                                    role_id = '.$role->id.' ORDER BY `username` ASC');
                                $checkedUser = '';
                                if (!empty($getUserData)) {
                                    foreach ($getUserData as $user) {
                                        if (!empty($userPerIdArr)) {
                                            if(in_array($user->id, $userPerIdArr)) {
                                                //$checkedUser = 'checked="checked"';
                                            }
                                        }
                                        $selectAllfrom =  '<li class="list-group-item" style="padding: 7px 3px 10px 10px;"  ><div class="rounds"><input type="checkbox" '.$checkedUser.'  checked="checked" id="userId_'.$user->id.'" class="pull-left_" name="userIdArr[]" value="'.$user->id.'">&nbsp;&nbsp;&nbsp; <label for="userId_'.$user->id.'"></label>'.$user->username.' </div></li>';
                                    ?>
                                        $('#selectUserAll_'+roleIds).append('<?php echo $selectAllfrom;?>'); 
                                    <?php 

                                    }
                                }
                                ?>
                            }

                        <?php
                        }
                    }
                ?>
            } else {
                <?php 
                    $selectAllfrom = '';
                    $getRoleData  = DB::select('SELECT * FROM `role_master` WHERE is_deleted_status = "N" AND role_name != 1');
                    if (!empty($getRoleData)) {
                        foreach ($getRoleData as $role) {
                    ?>
                            var roleId = '<?php echo  $role->role_name; ?>';
                            if (roleIds == roleId) {       
                                $('#selectUserAll_'+roleIds).html(''); 
                                <?php 
                                $getUserData  = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND role_id = '.$role->id.' ORDER BY `username` ASC');
                                if (!empty($getUserData)) {
                                    foreach ($getUserData as $user) {
                                        $selectAllfrom =  '<li class="list-group-item" style="padding: 7px 3px 10px 10px;"  ><div class="rounds"><input type="checkbox"   id="userId_'.$user->id.'" class="pull-left_" name="userIdArr[]" value="'.$user->id.'">&nbsp;&nbsp;&nbsp; <label for="userId_'.$user->id.'"></label>'.$user->username.' </div></li>';
                                    ?>
                                        $('#selectUserAll_'+roleIds).append('<?php echo $selectAllfrom;?>'); 
                                    <?php 

                                    }
                                }
                                ?>
                            }

                        <?php
                        }
                    }
                ?>
            }
            
            /*-------- form List --------------*/

            if ($('#masterId_'+roleIds).is(':checked')) {
                <?php 
                $getMasterData  = DB::select('SELECT * FROM `master` WHERE is_deleted_status = "N" ORDER BY `order_wise` ASC');
                $formTypeData = '';
                foreach ($getMasterData as $master) { 
                ?>
                    var masterId = <?php echo  $master->id; ?>;
                    if (roleIds == masterId) {       
                        $('#selectFormAll_'+roleIds).html(''); 
                        <?php 
                        $getFormMasterData  = DB::select('SELECT * FROM `form_master` WHERE is_deleted_status = "N" 
                        AND master_id = '.$master->id.' ORDER BY `order_wise` ASC');
                        if (!empty($getFormMasterData)) {
                            foreach ($getFormMasterData as $formMasterData) {
                                $formTypeData =  
                                '<li class="list-group-item" style="padding: 7px 3px 10px 10px;"  ><div class="rounds"><input type="checkbox"   id="formId_'.$formMasterData->id.'" checked="checked" class="pull-left_" name="formIdArr[]" value="'.$formMasterData->id.'">&nbsp;&nbsp;&nbsp; <label for="formId_'.$formMasterData->id.'"></label>'.$formMasterData->form_name.' </div></li>';
                        ?>
                                 $('#selectFormAll_'+roleIds).append('<?php echo $formTypeData;?>'); 
                                <?php 
                            }
                        }
                        ?>
                    }
                <?php
                }
                ?>
            } else {
                <?php 
                    $getMasterData  = DB::select('SELECT * FROM `master` WHERE is_deleted_status = "N" ORDER BY `order_wise` ASC');
                    $formTypeData = '';
                    foreach ($getMasterData as $master) { 
                ?>      
                        var masterId = <?php echo  $master->id; ?>;
                        if (roleIds == masterId) {       
                            $('#selectFormAll_'+roleIds).html(''); 
                            <?php 
                                $getFormMasterData  = DB::select('SELECT * FROM `form_master` WHERE is_deleted_status = "N" 
                                AND master_id = '.$master->id.' ORDER BY `order_wise` ASC');
                                if (!empty($getFormMasterData)) {
                                foreach ($getFormMasterData as $formMasterData) {
                                    $formTypeData = '<li class="list-group-item" style="padding: 7px 3px 10px 10px;"  ><div class="rounds"><input type="checkbox"   id="formId_'.$formMasterData->id.'" class="pull-left_" name="formIdArr[]" value="'.$formMasterData->id.'">&nbsp;&nbsp;&nbsp; <label for="formId_'.$formMasterData->id.'"></label>'.$formMasterData->form_name.' </div></li>';
                            ?>
                                    $('#selectFormAll_'+roleIds).append('<?php echo $formTypeData;?>'); 
                                    <?php 
                                }
                            }
                            ?>
                        }
                        <?php
                    }
                ?>
            }
        }

        @if(\Session::has('message'))
            toastr.success(
                '{{session()->get('message')}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 3000 
                }
            );
        @endif
        
        <?php 
        /*
            if ($('#roleId_'+roleIds).is(':checked')) {

                $.ajax({
                    url:"{{ route('angularformpermission.selectAngularAllForm') }}",
                    type :'GET',
                    data : {  
                        roleIds : roleId,
                        checked : 1,
                    },
                    success:function(result){
                        $('#selectFormAll_'+roleId).html(result);

                    }
                });
                
            } else {       

                $.ajax({
                    url:"{{ route('angularformpermission.selectAngularAllForm') }}",
                    type :'GET',
                    data : {  
                        roleIds: roleId,
                        checked : 0
                    },
                    success:function(result){
                       $('#selectFormAll_'+roleId).html(result);

                    }
                });
                
            } 
        */
        ?>
    </script>
    </body>
</html>
