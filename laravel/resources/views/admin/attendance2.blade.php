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
                                /*border: 1px solid red !important;*/
                                border-radius:4px;
                            }
                        </style>

                        <form id="register-form"  method="post" action="{{ route('postattendance') }}"  
                        enctype="multipart/form-data" autocomplete="off" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row has-feedback {{ $errors->has('attendance_date') ?  'has-error' : '' }}">
                                        <label class="control-label text-right col-md-4 col-form-label">
                                            Select Date : 
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text"  id="attendance_date" name="attendance_date" class="form-control pickadate borderred" data-date-format="dd-mm-yyyy" placeholder="Date" value="" 
                                            onchange="getAttendanceByDate()">
                                            <?php  /* value="{{ !empty($registerUserPostData['attendance_date']) ? $registerUserPostData['attendance_date'] : date('d-m-Y') }}"  */?>
                                            <!-- <span class="text-danger">{{ $errors->first('attendance_date') }}</span>  -->
                                        
                                            <!--<input type="text"  id="attendance_date" name="attendance_date" class="form-control pickadate borderred" data-date-format="dd-mm-yyyy"   placeholder="Date" 
                                            value="{{ !empty($registerUserPostData['attendance_date']) ? $registerUserPostData['attendance_date'] : date('d-m-Y') }}"> 
                                            <span class="text-danger">{{ $errors->first('attendance_date') }}</span> -->
                                        </div>
                                    </div>
                                </div>
                               <!-- <div class="col-md-4">
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" onclick="resetAttendanceForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </form>

                        <div class="table-responsive" ng-init="fetchAttendanceData()" >
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
                                <tbody id="getAttendanceByDateId">
                                    <tr ng-repeat="attendance in attendanceData">
                                        <?php /*<tr @if($client->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                > */
                                        ?>         
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ attendance.username}}</td>
                                        <td><a ng-if="attendance.in_time!=''" style="background: #2ecc71;border: 2px solid #2ecc71;font-size: 12px;line-height: .1;border-radius: 3px;padding: 3px;" class="btn btn-success" href="#"> <i class="icon-login"></i> @{{ attendance.in_time }}</a></td>
                                        <td><a ng-if="attendance.out_time!=''" style="background: #ffb136;border: 2px solid #ffb136;font-size: 12px;line-height: .1;border-radius: 3px;padding: 3px;"  class="btn btn-warning" href="#"><i class="icon-logout"></i> @{{ attendance.out_time }}</a></td>
                                        <td><a ng-if="attendance.hours!=''" style="background: #0283cc;border: 2px solid #0283cc;font-size: 12px;line-height: .1;border-radius: 3px;padding: 3px;"  class="btn btn-warning" href="#"><i class="icon-clock"></i> @{{ attendance.hours }}</td>
                                    </tr>
                                </tbody>
                                <?php /*
                                <tbody id="getAttendanceByDateId">
                                    <?php 
                                        $date = !empty($date) ? $date : date('d-m-Y');
                                        $getAttendanceData = DB::table('attendance')
                                        ->select('user_master.username','attendance.*')
                                        ->join('user_master', 'user_master.id','attendance.user_id')
                                        ->where('attendance.is_deleted_status','N')
                                        ->where('attendance.date',$date)
                                        ->orderBy('user_master.username','ASC')
                                        ->get()
                                        ->toArray();
                                    ?>
                                    @if (!empty($getAttendanceData))
                                        @foreach ($getAttendanceData as $key => $attendance)
                                            <tr @if($attendance->status == 'No') style="background-color:#ff851b !important" @endif>
                                                <td>{{$key+1}}</td>
                                                <td>{{!empty($attendance->username) ? $attendance->username: ''}}</td>
                                                <td>@if (!empty($attendance->in_time))<?php $inTimeArr = explode(' ', $attendance->in_time);?><a style="background: #2ecc71;
                                                            border: 2px solid #2ecc71;    font-size: 12px;
                                                            line-height: .1;
                                                            border-radius: 3px;
                                                            padding: 3px;" 
                                                            class="btn btn-success" href="#"> <i class="icon-login"></i> {{$inTimeArr[1]}} {{$inTimeArr[2]}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>@if (!empty($attendance->out_time))<?php $outTimeArr = explode(' ', $attendance->out_time); ?><a style="background: #ffb136;
                                                                border: 2px solid #ffb136;    
                                                                font-size: 12px;
                                                                line-height: .1;
                                                                border-radius: 3px;
                                                                padding: 3px;"  class="btn btn-warning" href="#"> 
                                                            <i class="icon-logout"></i> {{$outTimeArr[1]}} {{$outTimeArr[2]}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>@if (!empty($attendance->hours))<a style="background: #0283cc;
                                                                border: 2px solid #0283cc;    
                                                                font-size: 12px;
                                                                line-height: .1;
                                                                border-radius: 3px;
                                                                padding: 3px;"  class="btn btn-warning" href="#"> 
                                                                <i class="icon-clock"></i> {{$attendance->hours}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody> */?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
/*    function resetAttendanceForm() {
        window.location.href="{{ route('attendance') }}";
    }*/
</script>
    @include('admin.common.script2')
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
    
    <script type="text/javascript">
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            
            $scope.attendanceFormData = {};
            $scope.fetchAttendanceData = function() {
                $http.get("{{route('angularAttendance.view')}}").success(function(data) {
                    $scope.attendanceData = data;
                });
            };
            /*
            $scope.getAttendanceByDate = function() {
                var attendanceDate = $('#attendance_date').val();
                alert(attendanceDate);
                $http({
                    url: "{{route('getattendanceByAjax')}}", 
                    method: "GET",
                    params: {attendanceDates: attendanceDate}
                }).success(function(data) {
                    $scope.attendanceData = data;
                });
            }
            */
        });
        
        function getAttendanceByDate()
        {   
            var attendanceDate = $('#attendance_date').val();
            $('#getAttendanceByDateId').show();
            $('#getAttendanceByDateId').html("<tr class='odd'><td valign='top' colspan='5' class='dataTables_empty'><img src='<?php echo URL::asset('public/image/lorder.gif') ?>' style='height: 50px;width: 50px;' /></td></tr>");
            $.ajax({
                type: "GET",
                url: '{{route("getattendanceByAjax")}}',
                data : {  
                    attendanceDate: attendanceDate,
                },
                success: function(data) {
                    $('#getAttendanceByDateId').html(data);
                }
            });
            
        }
        
    </script>
    </body>
</html>

