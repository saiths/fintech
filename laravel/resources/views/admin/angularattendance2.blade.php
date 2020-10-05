@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Attendance</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>

                        <form id="register-form"  method="post" enctype="multipart/form-data" autocomplete="off" >
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4 col-form-label">Select Date :</label>
                                        <div class="col-md-8">
                                            <input type="text"  id="attendance_date" name="attendance_date" class="form-control pickadate borderred" data-date-format="dd-mm-yyyy" placeholder="Date" 
                                             value="<?php echo date('d-m-Y'); ?>" > 
                                            <span class="text-danger" id="emptyDate"></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <button type="button" ng-click="addAttendanceData()" class="btn btn-success">Save</button>
                                            <button type="button" ng-click="resetAttendanceForm(0)" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="table-responsive" ng-init="fetchAttendanceData(data)" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%" datatable="ng" dt-options="vm.dtOptions" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>User Name</th>
                                        <th>Check In Time</th>
                                        <th>Check Out Time</th>
                                        <th>Working Hours [HH:MM]</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="attendance in attendanceData">
                                        <?php 
                                        /*  <tr @if($attendance->status == 'No') 
                                                style="background-color:#ff851b !important"
                                            @endif
                                            > */
                                        ?>         
                                        <td>@{{ attendance.id }}</td>
                                        <td>@{{attendance.username}}</td>
                                        <td>
                                            <a style="background: #2ecc71;
                                                border: 2px solid #2ecc71;    font-size: 12px;
                                                line-height: .1;
                                                border-radius: 3px;
                                                padding: 3px;" 
                                                class="btn btn-success" href="#"> 
                                                <i class="icon-login"></i>&nbsp;@{{attendance.in_time}}
                                            </a>
                                        </td>
                                        <td><a style="background: #ffb136;
                                                border: 2px solid #ffb136;    
                                                font-size: 12px;
                                                line-height: .1;
                                                border-radius: 3px;
                                                padding: 3px;"  
                                                class="btn btn-warning" href="#"> 
                                                <i class="icon-logout"></i>&nbsp;@{{attendance.out_time}}
                                            </a>
                                        </td>
                                        <td> 
                                            <a style="background: #0283cc;
                                                border: 2px solid #0283cc;    
                                                font-size: 12px;
                                                line-height: .1;
                                                border-radius: 3px;
                                                padding: 3px;"  class="btn btn-warning" href="#"> 
                                                <i class="icon-clock"></i>&nbsp;@{{attendance.hours}}
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

    <script type="text/javascript">
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            $scope.attendanceFormData = {};
            $scope.fetchAttendanceData = function(postData = null) {
                if (postData == null) {
                    $http.get("{{route('angularAttendance.view')}}").success(function(data) {
                        angular.forEach(data, function (value, key) { 
                            if (data[key].hours == '') {
                                data[key].hours = '00:00';
                            }
                            if (data[key].out_time == '') {
                                data[key].out_time = '00:00:00 <?php echo date('A'); ?>';
                            }  
                        }); 
                        $scope.attendanceData = data;  
                    });
                } else {
                    angular.forEach(postData, function (value, key) { 
                        if (postData[key].hours == '') {
                            postData[key].hours = '00:00';
                        }
                        if (postData[key].out_time == '') {
                            postData[key].out_time = '00:00:00 <?php echo date('A'); ?>';
                        }  
                    }); 
                    $scope.attendanceData = postData; 
                }
            };

            $scope.showAttendanceData = function(data) {
                $scope.attendanceFormData = angular.copy(data);
            };

            $scope.addAttendanceData = function() {
                var attendanceDate = $('#attendance_date').val();
                if (attendanceDate == '') {
                    $('#emptyDate').show();
                    $('#emptyDate').html('Date field is Required.');
                    return false;
                } else {
                    $http({
                            url: "{{route('angularAttendance.add')}}", 
                            method: "GET",
                            params: {attendanceDates: attendanceDate}

                        }).success(function(data) {
                            $scope.fetchAttendanceData(data);
                    });
                    $scope.resetAttendanceForm(attendanceDate);
                }
            }; 

            $scope.resetAttendanceForm = function(date= null) {
                $('#emptyDate').hide();
                if  (date == 0) {
                    $('#attendance_date').val('<?php echo date('d-m-Y'); ?>');
                    $http.get("{{route('angularAttendance.view')}}").success(function(data) {
                        $scope.attendanceData = data;  
                    });
                } else {
                    $('#attendance_date').val(date);
                }
            } 
        });
    </script>
    </body>
</html>


