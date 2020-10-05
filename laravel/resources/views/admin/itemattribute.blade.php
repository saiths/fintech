@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(!empty($getItemAttDataByID))
                        @foreach ($getItemAttDataByID as $getItemAttData)
                        @endforeach
                    @endif
                
                    <div class="card card-custom gutter-b example example-compact">
                        
                        @if(!empty($getItemAttData->id))
                    
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('itemattribute.edit')}}">
                            
                        @else
                    
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('itemattribute.add')}}">
                    
                        @endif
                    
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        @if(!empty($getItemAttData->id))
                            <input type="hidden" name="ItemAttId" id="ItemAttId"  value="{{$getItemAttData->id}}">
                        @endif
                    
                            
                            <!--<input type="hidden" name="itemAttributeId"  ng-model="itemAttributeData.id">
                            -->
                            
                            <div class="card-body">
                                
                                
                                <style type="text/css">
                                .abcs 
                                {
                                    font-size: 12px;
                                }
                                </style>
                                
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-2 col-form-label"><b class="abcs">Name :</b> </label>

                                            <div class="col-md-8">
                                                <!--<input type="text" class="form-control abc" placeholder="Name"
                                                value="{{ !empty($getItemAttData->name) ? $getItemAttData->name : '' }}"
                                                name="name" id="name" ng-model="itemAttributeData.name">
                                                -->
                                                <input type="text" class="form-control abc" placeholder="Name"
                                                value="{{ !empty($getItemAttData->name) ? $getItemAttData->name : '' }}"
                                                name="name" id="name">
                                                
                                                @if (!empty($nameText))
                                                    <span class="text-danger" id="emptyName">{{ $nameText }}</span>
                                                @else
                                                    <span class="text-danger" id="emptyName">{{ $errors->first('name') }}</span>
                                                @endif
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                 @if(!empty($getItemAttData->id))
                                                                
                                                    <!--<button type="button" ng-if="!isInsert" 
                                                        ng-click="updateProccesData(processFormData)" id="lorderId" 
                                                        class="btn btn-primary mr-2">Update
                                                    </button>
                                                    -->
                                                    
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Update</button>
                                                    
                                                @else
                                                
                                                    <!--<button type="button" ng-if="isInsert" id="lorderId"  
                                                        ng-click="addProcessData(processFormData)" 
                                                        class="btn btn-primary mr-2">Save
                                                    </button>
                                                    -->
                                                    
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Save</button>
                                                    
                                                    
                                                @endif
                                               
                                                <!--<button type="button" ng-if="!isInsert" 
                                                    ng-click="updateItemAttributeData(itemAttributeData)" 
                                                    id="lorderId" class="btn btn-primary mr-2">Update
                                                </button>
                                                
                                                <button type="button" ng-if="isInsert" id="lorderId"  
                                                    ng-click="addItemAttributeData(itemAttributeData)" 
                                                    class="btn btn-primary mr-2">Save
                                                </button>
                                                -->
                                                
                                                <button type="button"  id="cancelId" 
                                                onclick="resetItemAttributeForm()" class="btn btn-dark">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <table class="table table-striped table-bordered display" id="default_order_process">
                                    
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getItemAttributeData = [];
                                        $getItemAttributeData = DB::table('item_attribute_master')
                                          ->select('*')
                                          ->where('is_deleted_status', 'N')
                                          ->orderBy('name', 'ASC')
                                          ->get()
                                          ->toArray();
                                          
                                        if (!empty($getItemAttributeData)) {
                                            $j = 1;
                                            foreach ($getItemAttributeData as $key => $processData) {
                                        ?>
                                        
                                                <tr style="background-color: white">
                                                    <td>{{ $j }}</td>
                                                    <td>{{ $processData->name }}</td>
                                                    <td>
                                                        
                                                        
                                                    <!--    <a href="#" 
                                                        
                                            onclick="showItemAttributeData({{$processData->id}})"> 
                                            
                                                            <i class="text-dark-10 flaticon2-edit"></i>
                                                        </a>
                                                        <a href="#"  
                                        onclick="deleteItemAttributeData({{$processData->id}})" >
                                                            
                                                            <i class="text-dark-10 flaticon2-trash"></i>
                                                        </a>-->
                                                        
                                                        
        <a href="{{ route('itemattribute.viewbyid',['processId' => base64_encode($processData->id)]) }}"> 
            <i class="text-dark-10 flaticon2-edit"></i>
        </a>
        
            <!--<a href="#"  onclick="deleteProcessData({{base64_encode($processData->id)}})" >
                <i class="text-dark-10 flaticon2-trash"></i>
            </a>
            -->
                                                        
        <a onclick="return confirm('Are you sure want to delete?')" 
        href="{{ route('itemattribute.deletes',['processId' => base64_encode($processData->id)]) }}">
            <i class="text-dark-10 flaticon2-trash"></i>
        </a>
        
       
                                                        
                                                    </td>
                                                </tr>
                                        <?php
                                            $j++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!--<div class="card-body" ng-init="fetchItemAttributeData()">
                                <table class="table table-bordered table-hover table-checkable mt-10" 
                                    datatable="ng" dt-options="vm.dtOptions">
                                        
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <tr ng-repeat="itemAttribute in itemAttributeDatas">
                                            <td>@{{ $index + 1 }}</td>
                                            <td>@{{ itemAttribute.name }}</td>
                                            <td>
                                                <a href="#" ng-click="showItemAttributeData(itemAttribute)"> 
                                                    <i class="text-dark-10 flaticon2-edit"></i>
                                                </a>
                                                <a href="#"  ng-click="deleteItemAttributeData(itemAttribute.id)" >
                                                    <i class="text-dark-10 flaticon2-trash"></i>
                                                </a>
                                                
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            -->
                        </div>
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
       $('#default_order_process').DataTable();
    });
    
    
   /* var app = angular.module("myApp", ['datatables']);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.itemAttributeData = {};
        $scope.isInsert = true;
                
        $scope.fetchItemAttributeData = function() {
            $http.get("{{route('itemattribute.view')}}").success(function(data) {
                $scope.itemAttributeDatas = data;
            });     
        };

        $scope.showItemAttributeData = function(data) {
            var name = $('#name').val(data.name);
            $('#emptyName').hide();
           // $('#name').css('border-color', '#E4E6EF');
            $scope.isInsert = false;
            $scope.itemAttributeData = angular.copy(data);
        };


        $scope.updateItemAttributeData = function(data) {

            var name = $('#name').val();
            
            if (name == '') {

                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                   // $('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                    
                }
                return false;


            } else {
                    
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');

                $http.post("{{route('itemattribute.edit')}}",data).success(function(data) {
                    
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
                        
                        $scope.isInsert = true;

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $scope.userFormData = {};
                        $scope.fetchItemAttributeData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetItemAttributeForm();
                        
                    }
                    
                }); 
            }
        };


        $scope.addItemAttributeData = function(data) {

            var name = $('#name').val();

            if (name == '') {  
                
                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                    //$('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                    
                }
                return false;

            } else {     

                $('#emptyName').hide();
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
               
                $http.post("{{route('itemattribute.add')}}",data).success(function(data) {
                    
                    $("#lorderId").attr("disabled", false);
                    $("#cancelId").attr("disabled", false);
                    $("#lorderId").html('Save');
                    
                    if (data.nameText == 'nameText') {

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
                        
                        $scope.itemAttributeData = {};
                        $scope.fetchItemAttributeData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetItemAttributeForm();
                        $scope.isInsert = true;
                    }

                }); 
            }
        }

        
        $scope.deleteItemAttributeData = function(id) {

            if (confirm("Are you Want to delete?") == true) {
                $http({
                method: "POST",
                url:    "{{route('itemattribute.delete')}}",
                data: {'id': id} 
                }).success(function(data) {
                    $scope.fetchItemAttributeData();
                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                    $scope.resetItemAttributeForm();
                });
            } 
        };


        $scope.resetItemAttributeForm = function() {
            $scope.isInsert = true;
           // $('#name').css('border-color', '#E4E6EF');
            $('#emptyName').hide();
            var name = $('#name').val('');
        };


    });*/
    
    
    function resetItemAttributeForm() {
        /*$('#emptyName').hide();
        var name = $('#name').val('');
        */
        window.location.href = "{{route('itemattribute') }}";        

    }
    

</script>
</body>
</html>

