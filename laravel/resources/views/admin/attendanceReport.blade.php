@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Attendance Report</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                /*border: 1px solid red !important;*/
                                border-radius:4px;
                            }
                        </style>	
                        <form id="register-form"  method="post" action="{{route('attreports')}}"  
                        	enctype="multipart/form-data" autocomplete="off" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">	
                                <div class="col-md-3">
                                    <div class="form-group row has-feedback {{ $errors->has('attendance_report_date') ?  
                                    	'has-error' : '' }}">
                                        <label class="control-label text-right col-md-4 col-form-label">
                                            Select Month : 
                                        </label>
                                    	<div class="col-md-4">
                                        	<input type="text"  id="attendance_report_date" name="attendance_report_date" 
                                            	class="form-control pickadate borderred" data-date-format="dd-mm-yyyy" 
                                            	placeholder="Month"value="">
                                            	<?php 
                                            		if (!empty($emptyAttendance)) {
                                            	?>
                                            		<span class="text-danger"> <?php echo $emptyAttendance;?> </span>
                                        		
                                        		<?php
                                        		}
                                        		?>
                                        </div>
                                        <div class="col-md-4">
                                        	<div class="form-group row">
                                        		<div class="col-md-6">
                                            		<button type="submit" class="btn btn-success">Submit</button>
                                           		</div>
                                    		</div>
                                   		</div>
                                    </div>
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
    <script type="text/javascript">
    	/*function attendanceReportDate()
        {   
            var month = $('#attendance_report_date').val();
            $.ajax({
                type : "GET",
                url  : '{{route("attreports")}}',
                data : {  
                    months: month,
                },
                success: function(data) {
                	
                }
            });
        }*/
    </script>
    </body>
</html>

