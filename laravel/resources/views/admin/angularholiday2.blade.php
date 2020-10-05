@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Holiday</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        <form class="form-horizontal" id="register-form"  autocomplete="off">
                            <input type="hidden" name="holidayId"  ng-model="holidayFormData.id">
                            <div class="row">
                                <div  class="col-md-3">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                            Form : 
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text"  id="form_holiday_date" name="form_holiday_date" 
                                            class="form-control borderred" data-date-format="dd-mm-yyyy" placeholder="Form Date" 
                                            ng-value="currentDate"  ng-model="holidayFormData.form_holiday_date"> 
                                            <span class="text-danger" id="emptyFormHolidayDate"></span>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-3">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">
                                            To : 
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" id="to_holiday_date" name="to_holiday_date" 
                                            class="form-control borderred" data-date-format="dd-mm-yyyy" placeholder="To Date" 
                                            ng-value="currentDate" ng-model="holidayFormData.to_holiday_date"> 
                                            <span class="text-danger" id="emptyToHolidayDate"></span>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-3">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Name : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred" id="name" name="name" rows="2" placeholder="Name" value=""  
                                            ng-model="holidayFormData.name">
                                            <span class="text-danger" id="emptyName"></span> 
                                        </div>
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <button type="button" id="lorderId"  ng-if="!isInsert" ng-click="updateHolidayData(holidayFormData)" class="btn btn-success">Update
                                            </button>
                                            <button type="button" id="lorderId" ng-if="isInsert" ng-click="addHolidayData(holidayFormData)" class="btn btn-success">Save
                                            </button>
                                            <button type="button" id="cancelId" ng-click="resetHolidayForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive"  ng-init="fetchHolidayData()" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" datatable="ng" dt-options="vm.dtOptions">
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Form Date</th>
                                        <th>To Date</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="holiday in holidayData">
                                        <?php /*  <tr @if($holiday->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                > */
                                        ?>         
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ holiday.form_holiday_date }}</td>
                                        <td>@{{ holiday.to_holiday_date }}</td>
                                        <td>@{{ holiday.name}}</td>
                                        <td>
<!--                                        <div class="tooltip1">
                                                <a href="#"  ng-click="showHolidayData(holiday)"  
                                                class="btn btn-xs btn-info" style="padding: 0px 7px;">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip1">
                                                <a href="#"  ng-click="deleteHolidayData(holiday.id)" 
                                                    class="btn btn-xs btn-danger" style="padding: 0px 7px;"> <i class="ti-trash"></i> 
                                                    <span class="tooltiptext">Delete</span>
                                                </a>
                                            </div>-->
                                            <a href="#"  ng-click="showHolidayData(holiday)"  class="btn btn-xs btn-info" style="padding: 0px 7px;">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <a href="#"  ng-click="deleteHolidayData(holiday.id)" 
                                                class="btn btn-xs btn-danger" style="padding: 0px 7px;"> <i class="ti-trash"></i> 
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
    @include('admin.common.script2')
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>

    <script>
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            
            $scope.holidayFormData = {};
            $scope.isInsert = true;
            
            $scope.fetchHolidayData = function() {
                $http.get("{{route('angularHoliday.view')}}").success(function(data) {
                    //$scope.currentDate = '<?php echo date('d-m-Y'); ?>';
                    $scope.holidayData = data;  
                });     
            };

            $scope.showHolidayData = function(data) {
                var to_holiday_date = $('#to_holiday_date').val(data.to_holiday_date);
                var form_holiday_date = $('#form_holiday_date').val(data.form_holiday_date);
                var name = $('#name').val(data.name);
                $scope.isInsert = false;
                $('#emptyToHolidayDate').hide();
                $('#emptyFormHolidayDate').hide();
                $('#emptyName').hide();
                $scope.holidayFormData = angular.copy(data);
            };


            $scope.updateHolidayData = function(data) {
                
                var name = $('#name').val();
                var toHolidayDate = $('#to_holiday_date').val();
                var formHolidayDate = $('#form_holiday_date').val();
                
                if (name == '' ||  toHolidayDate == '' || formHolidayDate == '')  {

                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }
                    
                    if (toHolidayDate == '') {
                        $('#emptyToHolidayDate').show();
                        $('#emptyToHolidayDate').html('To Date field is Required.');
                    } else {
                        $('#emptyToHolidayDate').hide();
                    }

                    if (formHolidayDate == '') {
                        $('#emptyFormHolidayDate').show();
                        $('#emptyFormHolidayDate').html('Form Date field is Required.');
                    } else {
                        $('#emptyFormHolidayDate').hide();
                    }
                    
                    
                    return false;

                } else {

                    $('#emptyToHolidayDate').hide();
                    $('#emptyFormHolidayDate').hide();
                    $('#emptyName').hide();
                    
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
                    
                    $http.post("{{route('angularHoliday.edit')}}",data).success(function(data) {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Update');

                        if (data.message == 1) {

                            $('#emptyToHolidayDate').show();
                            $('#emptyToHolidayDate').html('To Date has already been taken.');

                        } else if (data.message == 2) {

                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('Form Date has already been taken.');

                        } else if(data.message == 3) {

                            $('#emptyToHolidayDate').show();
                            $('#emptyToHolidayDate').html('To Date has already been taken.');
                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('Form Date has already been taken.');

                        } else if(data.message == 4) {

                            $('#emptyToHolidayDate').hide();
                            $('#emptyFormHolidayDate').hide();
                            $('#emptyName').hide();
                            
                            $scope.isInsert = true;
                            $scope.holidayFormData = {};
                            $scope.fetchHolidayData();
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            toastr.success(
                                'Holiday has been updated.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                           

                        } else {
                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('The To date must be greater than the From date.');
                        }

                    }); 
                }
            };

            $scope.addHolidayData = function(data) {
                
                var name = $('#name').val();
                var toHolidayDate = $('#to_holiday_date').val();
                var formHolidayDate = $('#form_holiday_date').val();
        
                if (name == '' ||  toHolidayDate == '' || formHolidayDate == '')  {
                    
                    if (name == '') {
                        $('#emptyName').show();
                        $('#emptyName').html('Name field is Required.');
                    } else {
                        $('#emptyName').hide();
                    }
                    
                    if (toHolidayDate == '') {
                        $('#emptyToHolidayDate').show();
                        $('#emptyToHolidayDate').html('To Date field is Required.');
                    } else {
                        $('#emptyToHolidayDate').hide();
                    }

                    if (formHolidayDate == '') {
                        $('#emptyFormHolidayDate').show();
                        $('#emptyFormHolidayDate').html('Form Date field is Required.');
                    } else {
                        $('#emptyFormHolidayDate').hide();
                    }

                    return false;
                    
                } else {
                    
                    $('#emptyToHolidayDate').hide();
                    $('#emptyFormHolidayDate').hide();
                    $('#emptyName').hide();
                    
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                        
                    $http.post("{{route('angularHoliday.add')}}",data).success(function(data) {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        
                        if (data.message == 1) {

                            $('#emptyToHolidayDate').show();
                            $('#emptyToHolidayDate').html('To Date has already been taken.');

                        } else if (data.message == 2) {

                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('Form Date has already been taken.');

                        } else if(data.message == 3) {

                            $('#emptyToHolidayDate').show();
                            $('#emptyToHolidayDate').html('To Date has already been taken.');
                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('Form Date has already been taken.');

                        } else if(data.message == 4) {
                            
                            $('#emptyToHolidayDate').hide();
                            $('#emptyFormHolidayDate').hide();
                            $('#emptyName').hide();
                            $scope.isInsert = true;
                            $scope.holidayFormData = {};
                            $scope.fetchHolidayData();
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');

                            toastr.success(
                                'Holiday has been added.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );

               


                        } else {
                            $('#emptyFormHolidayDate').show();
                            $('#emptyFormHolidayDate').html('The To date must be greater than the From date.');
                        }
                        
                    }); 
                }
            };
            
            $scope.deleteHolidayData = function(id) {
                if (confirm("Are you Want to delete?") == true) {
                    $http({
                        method: "POST",
                        url:    "{{route('angularHoliday.delete')}}",
                        data: {
                            'id': id
                        }   
                    }).success(function(data) {
                        $scope.fetchHolidayData(); 
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetHolidayForm();
                    }); 
                }   
            };
            
            $scope.resetHolidayForm = function() {
                $scope.isInsert = true;
                $('#emptyToHolidayDate').hide();
                $('#emptyFormHolidayDate').hide();
                $('#emptyName').hide();
                $('#to_holiday_date').val('');
                $('#form_holiday_date').val('');
                $('#name').val('');
            }

        });
    </script>
    </body>
</html>
