@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                @if(!empty($getItemCategoryDataByID))
                    @foreach ($getItemCategoryDataByID as $getItemCatData)
                    @endforeach
                @endif
                
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        
                        <input type="hidden" name="itemCategoryFormId"  ng-model="itemCategoryFormData.id">
                        
                        
                        
                        @if(!empty($getItemCatData->id))
                    
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('itemcategory.edit')}}">
                        @else
                    
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('itemcategory.add')}}">
                    
                        @endif
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        @if(!empty($getItemCatData->id))
                            <input type="hidden" name="itemCatId" id="itemCatId"  value="{{$getItemCatData->id}}">
                        @endif
                        
                        
                    
                            <div class="card-body">
                            <style type="text/css">
                                .abcs 
                                {
                                    font-size: 12px;
                                }
                                
                                .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple
                                {
                                    border-color:red;
                                }
                                
                                
                                
                                .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--open .select2-selection--single 
                                {
                                    border-color:red;
                                }
                                
                                .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple 
                                {
                                    border-color:red;

                                }
                                
                                .select2-selection 
                                {
                                    width : 135%;
                                }
                                    
                            </style>
                            <input type="hidden" name="itemCategoryFormId" id="itemCategoryFormId"  
                            ng-model="itemCategoryFormData.id">
                                    
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2 col-form-label"> 
                                        <b class="abcs">Name : </b></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control abc" placeholder="Name" 
                                            id="name" name="name" 
                                            value="{{ !empty($getItemCatData->name) ? $getItemCatData->name : '' }}" />
                                            
                                            @if (!empty($nameText))
                                                <span class="text-danger" id="emptyName">{{ $nameText }}</span>
                                            @else
                                                <span class="text-danger" id="emptyName">{{ $errors->first('name') }}</span>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7" style="margin-left: -133px;">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4 col-form-label">
                                            <b class="abcs">Select Process(s) : </b></label>
                                        <div class="col-md-8">
                                            <select class="form-control abc select2" id="kt_select2_3_modal" 
                                                multiple="multiple" name="select2_itemCategory[]"  style="width: 100%">
                                                <?php

                                                    $processIdsss = 
                                                    !empty($getItemCatData->id) ? $getItemCatData->id : 0;
                                                    
                                                    $processId = [];
                                                    $getItemCategoryIdData = DB::select('SELECT * FROM 
                                                    process_item_category_master WHERE 
                                                    is_deleted_status = "N" AND item_category_id = '.$processIdsss.'');
                                                    
                                                    
                                                    if (!empty($getItemCategoryIdData)) {
                                                        foreach ($getItemCategoryIdData as $itemCategoryData) {
                                                            $processId[] =  $itemCategoryData->process_id;
                                                        } 
                                                    }
                                                    
                                                    $getProcessData =  DB::select('SELECT * FROM process_master WHERE 
                                                    is_deleted_status = "N" ORDER BY name ASC');
                                                    
                                                    
                                                    if (!empty($getProcessData)) {
                                                        
                                                        foreach ($getProcessData as $process) { 
                                                            
                                                            
                                                ?>  
                                                            <option value="<?php echo $process->id; ?>"
                                                                <?php 
                                                                    if (in_array($process->id, $processId)) { 
                                                                        echo 'selected="selected"';
                                                                        
                                                                
                                                                }?>><?php echo $process->name; ?></option>
                                                        
                                                        <?php  
                                                        
                                                    }
                                                }        
                                                ?>
                                            </select>
                                            @if (!empty($nameTexts))
                                                <span class="text-danger" id="emptyName">{{ $nameTexts }}</span>
                                            @else
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group row" >
                                        <label class="control-label text-right col-md-2 col-form-label"></label>
                                        <div class="col-md-9">
                                            
                                            @if(!empty($getItemCatData->id))
                                                                
                                                    <!--<button type="button" ng-if="!isInsert" 
                                                        ng-click="updateProccesData(processFormData)" id="lorderId" 
                                                        class="btn btn-primary mr-2">Update
                                                    </button>
                                                    -->
                                                    
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Update</button>
                                                    
                                                @else
                                                
                                                <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Save</button>
                                                    
                                                    
                                                @endif
                                                
                                                
                                                <button type="button" onclick="resetItemCateForm()" id="cancelId" 
                                                    class="btn btn-dark">Cancel
                                                </button>
                                            
                                            <!--<button type="button" ng-if="!isInsert" 
                                            ng-click="updateItemCategory(itemCategoryFormData)" id="lorderId"   class="btn btn-primary mr-2">Update
                                            </button>
                                            
                                            <button type="button" ng-if="isInsert" id="lorderId"  
                                                ng-click="addItemCategory(itemCategoryFormData)" class="btn btn-primary mr-2">Save
                                            </button>

                                            <button type="button" ng-click="resetItemCategory()" id="cancelId" 
                                                class="btn btn-dark">
                                                Cancel
                                            </button>
-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered display" id="default_order_itemcategory">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Select Process(s)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                            
                                        $getProjectData = [];
                                        $getProjectData = DB::table('item_category_master')
                                          ->select('*')
                                          ->where('is_deleted_status', 'N')
                                          ->orderBy('name', 'ASC')
                                          ->get()
                                          ->toArray();
                                          
        
                                        $i = 1;
                                        foreach ($getProjectData as $key =>  $projectData) {
                                            $getProjectDatad =   DB::select('SELECT * FROM process_item_category_master 
                                            WHERE is_deleted_status = "N" 
                                                AND item_category_id = '.$projectData->id.'');
                                            $userName = '';
                                            $userNames = '';
                                            $usersIds = '';
                                            $usersId = '';
                                            
                                           ?>
                                           
                                    <tr style="background-color: white">
                                        
                                        <td>{{ $i }}</td>
                                        <td>{{ $projectData->name }}</td>
                                        <td>
                                            <?php 
                                            $userIdArrd = [];
                                            if (!empty($getProjectDatad)) {
                                                foreach ($getProjectDatad as $projectd) {
                                                    $userIdArrd[] = $projectd->process_id;
                                                }   
                                            }
                                
                                            $userIded = implode(',', $userIdArrd);
                                            $userIA = !empty($userIded) ? $userIded : 0;
                                            $getUserNameDatad = DB::select('SELECT * FROM `process_master` WHERE is_deleted_status = "N" AND id IN('.$userIA.')');
                                            if (!empty($getUserNameDatad)) {
                                
                                                foreach ($getUserNameDatad as $user) {
                                                    $userName .= ' '.$user->name.' ,';
                                                    $usersId .= $user->id.',';
                                                } 
                                                $userNames =  rtrim($userName,',');
                                                $usersIds =  rtrim($usersId,',');
                                
                                            }
                                            
                                            $getProjectData[$key]->username = $userNames;
                                            $getProjectData[$key]->userId = $usersIds;
                                            echo $userNames;
                                           ?>
                                        </td>
                                        
                                        <td>
                                            
                                            <!--<a href="#" onclick="showItemCategory({{$projectData->id}})"> 
                                                <i class="text-dark-10 flaticon2-edit"></i>
                                            </a>
                                            -->
                                            
                                                               
        <a href="{{ route('itemcategory.viewbyid',['processId' => base64_encode($projectData->id)]) }}"> 
            <i class="text-dark-10 flaticon2-edit"></i>
        </a>
                                            <!--<a href="#"  onclick="deleteItemCategory({{$projectData->id}})" >
                                                <i class="text-dark-10 flaticon2-trash"></i>
                                            </a>
                                            -->
                                            
                                                                             
        <a onclick="return confirm('Are you sure want to delete?')" 
            href="{{ route('itemcategory.deletes',['processId' => base64_encode($projectData->id)]) }}">
            <i class="text-dark-10 flaticon2-trash"></i>
        </a>
        
        
                                        </td>    
                                    </tr>
                                    
                                           
                                           
                                           <?php
                                            
                                            
                                            
                                            $i++;
                                            
                                        }
                                        

                                    ?>
                                            
                                </tbody>
                            </table>
                            
                        </div>
                            <!--<div class="card-body" ng-init="fetchItemCategory()">
                                <table class="table table-bordered table-hover table-checkable" 
                            
                                datatable="ng" dt-options="vm.dtOptions">
                            
                            
                                
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Select Process(s)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                
                                    <tr ng-repeat="itemCategory in itemCategoryData">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ itemCategory.name }}</td>
                                        <td>@{{ itemCategory.username }}</td>
                                        <td>
                                            <a href="#" ng-click="showItemCategory(itemCategory)"> 
                                                <i class="text-dark-10 flaticon2-edit"></i>
                                            </a>
                                            <a href="#"  ng-click="deleteItemCategory(itemCategory.id)" >
                                                <i class="text-dark-10 flaticon2-trash"></i>
                                            </a>
                                        </td>    
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                            </div>  
                            -->
                        </form>
                        
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</div>
@include('admin.common.footer')


</div>
</div>
</div>

@include('admin.common.script')

<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   

<script type="text/javascript">

    $(function () {
       $('#default_order_itemcategory').DataTable();
    });
    
    <?php 
    /*
    var app = angular.module("myApp", ['datatables']);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.itemCategoryFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchItemCategory = function() {
            $http.get("{{route('itemcategory.view')}}").success(function(data) {
                $scope.itemCategoryData = data;
            });
        };

        $scope.showItemCategory = function(data) {
            var name = $('#name').val(data.name);
            $('#emptyName').hide();
            $('#emptyProcess').hide();
            $http({
                method: "POST",
                url:    "{{route('angularItemCategorySelect.roleSelected')}}",
                data: {
                    'itemCategoryId': data.id,
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal').html(data);
            });
            
       //     $('.select2-selection').css('border-color','#E4E6EF');
          //  $('#name').css('border-color', '#E4E6EF');
            $scope.itemCategoryFormData = angular.copy(data);
            $scope.isInsert = false;

        };

        $scope.updateItemCategory = function(data) {

            var name = $('#name').val(); 
            var processId = $('#kt_select2_3_modal').val();
            data.processIdArr = processId;
            
            if (name == '' ||  processId == '') {

                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                  //  $('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                }
                
                if (processId == '') {
                    $('.select2-selection').css('border-color','red');
                    $('#emptyProcess').show();
                    $('#emptyProcess').html('Please Select Process Name');
                } else {
                  //  $('.select2-selection').css('border-color','#E4E6EF');
                    $('#emptyProcess').hide();
                }
                
                return false;


            } else {
                    
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');

                $http.post("{{route('itemcategory.edit')}}",data).success(function(data) {
                    
                    if (data.nameText == 'nameText') {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Update');
                        
                        if (data.nameText == 'nameText') {
                            $('#name').css('border-color', 'red');
                            $('#emptyName').show();
                            $('#emptyName').html('The Name has already been taken.');
                        } else {
                          //  $('#name').css('border-color', '#E4E6EF');
                            $('#emptyName').hide();
                        }
                   
                    } else {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        $scope.isInsert = true;
                        
                        $scope.userFormData = {};
                        $scope.fetchItemCategory();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetItemCategory();
                        
                    }
                    
                }); 
            }
        };
        
        $scope.addItemCategory = function(data) {
            
            var processId = $('#kt_select2_3_modal').val();
            var name = $('#name').val();
            data.processIdArr = processId;


            if (name == '' ||  processId == '') {
                    
                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                  //  $('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                }
                
                if (processId == '') {
                    $('.select2-selection').css('border-color','red');
                    $('#emptyProcess').show();
                    $('#emptyProcess').html('Please Select Process Name');
                } else {
                    //$('.select2-selection').css('border-color','#E4E6EF');
                    $('#emptyProcess').hide();
                }
                
                return false;

            } else {
                
                $('#emptyName').hide();
                $('#emptyProcess').hide();

                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
               
                $http.post("{{route('itemcategory.add')}}",data).success(function(data) {
                    
                    $("#lorderId").attr("disabled", false);
                    $("#cancelId").attr("disabled", false);
                    $("#lorderId").html('Save');
                    
                    if (data.nameText == 'nameText') {

                        if (data.nameText == 'nameText') {
                            $('#name').css('border-color', 'red');
                            $('#emptyName').show();
                            $('#emptyName').html('The Name has already been taken.');
                        } else {
                           // $('#name').css('border-color', '#E4E6EF');
                            $('#emptyName').hide();
                        }

                    } else {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        
                        $scope.itemCategoryFormData = {};

                        $scope.fetchItemCategory();

                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);

                        $scope.resetItemCategory();
                        $scope.isInsert = true;
                    }

                }); 
            }
        }
    

        $scope.deleteItemCategory = function(id) { 

            if (confirm("Are you Want to delete?") == true) {
                $http({
                    method: "POST",
                    url   :    "{{route('itemcategory.delete')}}",
                    data  : {'id': id} 
                }).success(function(data) {

                    $scope.fetchItemCategory();

                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                    $scope.resetItemCategory();
                });
            } 
        };
        
        $scope.resetItemCategory = function() {
            $scope.isInsert = true;
            $('#emptyName').hide();
            $('#emptyProcess').hide();
           // $('.select2-selection').css('border-color','#E4E6EF');
         //   $('#name').css('border-color', '#E4E6EF');
            
            var name = $('#name').val('');
            $('#kt_select2_3_modal').val(['0']);
            $('#kt_select2_3_modal').trigger('change');
        };

    });
    
    */
    ?>

    
    function resetItemCateForm() {
        window.location.href = "{{route('itemcategory') }}";        

    }

</script>


</body>
</html>

