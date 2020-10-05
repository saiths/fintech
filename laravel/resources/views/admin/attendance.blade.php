@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <form class="form-horizontal" style="margin-top: 10px;margin-left: 154px;" id="register-form"  method="post" 
            action="{{ route('postattendance') }}" enctype="multipart/form-data" autocomplete="off" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                 <!--    <div class="col-md-5">
                        <div class="form-group has {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-5 control-label">Select User</label>
                            <div class="col-sm-7">
                                <select class="form-control select2" id="attendance_select"  name="user_id">
                                    <?php 
                                        /*$getUserData = 
                                        DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND  
                                        role_id != 4');*/
                                    ?>
                                    @if (!empty($getUserData))
                                        @foreach ($getUserData as $user)  
                                            <option value="{{$user->id}}"
                                                @if (!empty($registerUserPostData['user_id']))
                                                    {{ ($registerUserPostData['user_id'] == $user->id) ? 'selected=selected' : '' }}
                                                @else
                                                    @if (!empty(Session::get('sessionUserData')[0][0]->id))
                                                        {{ (Session::get('sessionUserData')[0][0]->id == $user->id) ? 'selected=selected' : '' }}
                                                    @else
                                                    @endif
                                                @endif
                                                >{{$user->username}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="roleId">{{ $errors->first('user_id') }}</span>
                            </div>
                        </div>
                    </div> -->
                    
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('attendance_date') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-5 control-label">Select Date<b class="text-danger">*</b></label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text"  placeholder="Date"
                                id="attendance_date" data-date-format="dd-mm-yyyy" name="attendance_date"  
                                value="{{ !empty($registerUserPostData['attendance_date']) ? $registerUserPostData['attendance_date'] : date('d-m-Y') }}">
                                <span class="text-danger">{{ $errors->first('attendance_date') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-block btn-primary"> 
                                <i class="fa fa-save"></i> Submit</button>
                            </div>
                            <div class="col-sm-6" style="margin-left: -25px;">
                                <button type="button" onclick="resetAttendanceForm()" class="btn btn-block btn-default"><i class="icon-close"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Attendance</h3>
            <div class="clearfix"></div>
            <div class="table-responsive" >
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
                            <th>User Name</th>
                            <th>Check In Time</th>
                            <th>Check Out Time</th>
                            <th>Working Hours [HH:MM]</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php 
                            //$userId = !empty($userId) ? $userId : 
                            //Session::get('sessionUserData')[0][0]->id;
                            
                            $date = !empty($date) ? $date : date('d-m-Y');
                            
                            /*$getAttendanceData = DB::select('SELECT * FROM attendance WHERE is_deleted_status = "N" AND user_id = '.$userId.' AND date = "'.$date.'"');*/
/*
                            $getAttendanceData = 
                            DB::select('SELECT * FROM attendance WHERE is_deleted_status = "N" AND date = "'.$date.'"');*/


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
                            	<tr  
                            		@if($attendance->status == 'No') 
                                    	style="background-color:#ff851b !important"
                                	@endif
                                	>
		                        	<td>{{$key+1}}</td>
		                            <td>
		                            	<?php 
                                    	/*	$getUserNameByUserId = 
                                    		DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND id = '.$attendance->user_id.' ');*/
                                    	?>
                                        {{!empty($attendance->username) ? $attendance->username: ''}}
                                    </td>
                                    
                                    <td>
                                        @if (!empty($attendance->in_time))

                                            <?php
                                                $inTimeArr = explode(' ', $attendance->in_time); 
                                            ?>
                                            <a style="background: #2ecc71;
                                                    border: 2px solid #2ecc71;    font-size: 12px;
                                                    line-height: .1;
                                                    border-radius: 3px;
                                                    padding: 3px;" 
                                                    class="btn btn-success" href="#"> <i class="icon-login"></i>&nbsp; {{$inTimeArr[1]}} {{$inTimeArr[2]}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($attendance->out_time))
                                            <?php
                                                $outTimeArr = explode(' ', $attendance->out_time); 
                                            ?>
                                            <a style="background: #ffb136;
                                                    border: 2px solid #ffb136;    
                                                    font-size: 12px;
                                                    line-height: .1;
                                                    border-radius: 3px;
                                                    padding: 3px;"  class="btn btn-warning" href="#"> 
                                                <i class="icon-logout"></i>&nbsp; 
                                                {{$outTimeArr[1]}} {{$outTimeArr[2]}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($attendance->hours))
                                            <a style="background: #0283cc;
                                                    border: 2px solid #0283cc;    
                                                    font-size: 12px;
                                                    line-height: .1;
                                                    border-radius: 3px;
                                                    padding: 3px;"  class="btn btn-warning" href="#"> 
                                                    <i class="icon-clock"></i>&nbsp; {{$attendance->hours}}
                                            </a>
                                        @endif
                                    </td>
		                        </tr>
                         	@endforeach
                  		@endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function resetAttendanceForm() {
        window.location.href="{{ route('attendance') }}";
    }
</script>

@include('admin.common.script')



