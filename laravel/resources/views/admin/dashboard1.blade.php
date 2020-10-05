@include('admin.common.main2')
<?php 
if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4) {
?>
    <style type="text/css">
    
        /* body { background: #3A3A3A; }*/
        
        .borderred {
            border: 1px solid red !important;
            border-radius:4px;
        }

        .table { border: none !important; }
        .table-bordered { border: solid 1px #CCC; border-left: 0px; }
        .table-bordered th, .table-bordered td { border-top: solid 1px #CCC; border-left: solid 1px #CCC; }
        .table thead tr:first-child {
            background-image: none;     
            color: #FFF;
        }

        .table thead th {border-left: none; }
        .table tr.info, td.info, .table tr.info th {
            background: #2d3a40 !important;
            color: #FFF;
        }

        .table>thead>tr>th { border: none; }
        .table tbody td {
            font-weight: 600;
            border-color: #E4E4E4 !important;
            border-right: 0px !important;
            background: #FAFAFA;
        }

        .table tbody td.blank {
            background: rgb(238, 238, 238);
            cursor: default;
        }

        .table tbody td.blank:hover {
            background: rgb(238, 238, 238);
        }

        .table tbody td:hover {  }

        .actual { color: #08c !important; }


        .non-active { border: inherit; }

        a.prev, a.next {
            border-left: none;
            border-right: none;
        }

        a.prev:hover,
        a.next:hover {
            filter: none;
        }

        a.prev:hover{background-position:5px -28px;}
        a.next:hover{background-position: -26px -28px;}

        div.loading { background: #FDFDFD; color: #222; }

        .border-left-off { border-left: none !important; }

        tbody td.b:nth-last-child(-n+7) { border-bottom: 1px solid #CCC; }
    </style>

    <div class="page-wrapper"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="padding: 0.75rem;"> 
                            <div class="row">
                            <!-- 1 card -->

                                <div class="card border-info col-md-2" style="background: #f4f8f9">
                                    <div class="card-header bg-info" style="height: 39px;">
                                        <h6 class="m-b-0 text-white"><i class="icon-call-in fa-fw"></i>&nbsp;
                                            Request a Leave 
                                        </h6>
                                    </div>
                                    <div class="card-body" style="padding: 0.75rem;">
                                        <button class="btn waves-effect waves-light btn-outline-primary" alt="default" data-toggle="modal" 
                                        data-target="#myModal_{{Session::get('sessionUserData')[0][0]->id}}" class="model_img img-responsive">
                                            <i class="icon-call-in fa-fw"></i>&nbsp; Request
                                        </button>
                                        <div id="myModal_{{Session::get('sessionUserData')[0][0]->id}}" class="modal fade" tabindex="-1" role="dialog" 
                                            aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false"   aria-hidden="true" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"  data-dismiss="modal"  aria-hidden="true" 
                                                            onclick="calenderPopup({{Session::get('sessionUserData')[0][0]->id}})" >×
                                                        </button>
                                                        <h4 class="modal-title text-center" id="myModalLabel"><i class="icon-call-in fa-fw"></i>
                                                            &nbsp;Request a Leave
                                                        </h4> 
                                                    </div>
                                                    <div class="modal-bodys" style="font-weight: 600;" id="getCalenderId">
                                                        <table class="table">
                                                            <?php
                                                                $leaveDate = '';
                                                                $dayNum=date("j");
                                                                $monthNum = date("m");
                                                                $year = date("Y"); 
                                                                $cMonth = $monthNum;
                                                                $cYear = $year;
                                                                $timestamp = mktime(0,0,0,$cMonth,1,$cYear);
                                                                $maxDay = date("t",$timestamp);
                                                                $thisMonth = getdate ($timestamp);
                                                                $startDay = $thisMonth['wday'];
                                                                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                                $monthNameChr = $dateObj->format('F');
                                                            ?>
                                                            <thead>
                                                                <tr style="background-color: #c94c46;">
                                                                    <th>
                                                                        <span id="anio" style="color: #FFF;font-weight: 600;" > <?php echo $year; ?>
                                                                        </span>
                                                                    </th>
                                                                    <th colspan="5" style="padding: 0px; line-height: 38px;">
                                                                        <a class="prev" onclick="Go(2,<?php echo $monthNum; ?>,<?php echo $year; ?>)" 
                                                                            data-toggle="tooltip" data-placement="top" title="" data-original-title="Previous"  href="javascript:void(0)">
                                                                        </a>
                                                                        <span id="mes" class="text-center" style="color: #FFF;font-weight: 600;"><?php echo $monthNameChr;?>
                                                                        </span>
                                                                        
                                                                        <a class="next" onclick="Go(3,<?php echo $monthNum; ?>,<?php echo $year; ?>)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Next"  href="javascript:void(0)"></a>
                                                                    </th>
                                                                    <th style="padding: 0px; line-height: 40px;">
                                                                       <!--  <a class="today" onclick="Go(1,<?php echo $monthNum; ?>,<?php echo $year; ?>)" href="javascript:void(0)" style="color: #FFF;font-weight: 600;"><i class="icon-home"></i></a> -->
                                                                    </th>
                                                                </tr>
                                                                <tr class="weekdays info" id="monday" style="height:42px !important;">
                                                                    <th>SUNDAY</th>
                                                                    <th>MONDAY</th>
                                                                    <th>TUESDAY</th>
                                                                    <th>WEDNESDAY</th>
                                                                    <th>THURSDAY</th>
                                                                    <th>FRIDAY</th>
                                                                    <th>SATURDAY</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    // all sunday Day Array Start
                                                                
                                                                    for ($i=0; $i<($maxDay+$startDay); $i++) {
                                                                        if ($i < $startDay)  {
                                                                            echo "";
                                                                        } else if(date("N F", mktime(0,0,0,$cMonth,($i - $startDay + 1),$cYear)) == 7) { 
                                                                            $allSundayArr[] =   ($i - $startDay + 1);
                                                                        }
                                                                    }

                                                                    // all Sunday Day Array End

                                                                    $dateToday =  getdate(mktime(0,0,0,$monthNum,1,$year)); 
                                                                    $monthName = $dateToday["month"]; 
                                                                    $firstWeekDay = $dateToday["wday"]; 
                                                                    $cont = true;
                                                                    $today = 27; 
                                                                    while (($today <= 32) && ($cont)) 
                                                                    {
                                                                        $dateToday = getdate(mktime(0,0,0,$monthNum,$today,$year));
                                                                        if ($dateToday["mon"] != $monthNum)
                                                                        {
                                                                            $lastDay = $today - 1; 
                                                                            $cont = false; 
                                                                        }
                                                                        $today++;
                                                                    }
                                                                    $day = 1;                                                  
                                                                    $wday = $firstWeekDay; 
                                                                    $firstWeek = true; 
                                                                    while ( $day <= $lastDay) 
                                                                    {
                                                                        if ($firstWeek) 
                                                                        {
                                                                            echo "<tr align=left>";
                                                                            for ($i=1; $i<=$firstWeekDay; $i++)
                                                                            {
                                                                                echo "<td style='background-color: #ddd;'></td>"; 
                                                                            }
                                                                            $firstWeek = false; 
                                                                        }

                                                                        if ($wday==0) 

                                                                        echo "<tr align=left>";
                                                                        $currentBg = '';
                                                                        $currentColor = '';
                                                                        $sundayBg = '';
                                                                        $sundayColor = '';
                                                                        $oldBg  = '';
                                                                        $oldColor = '';
                                                                        

                                                                        if ($day == date('d'))  {
                                                                            $currentBg = "background-color:#0283cc;";
                                                                            $currentColor = "color:#fff";

                                                                        } else {  
                                                                            if ($day < date('d')) {
                                                                                  $oldBg = 
                                                                                    "background-color: #ddd";
                                                                                    $oldColor = "color:#fff";
                                                                            }
                                                                        }

                                                                        $dayZeros = '';
                                                                        if ($day <= 9) {
                                                                            $dayZeros = 0;
                                                                        }

                                                                        $leaveStatusColor = '';
                                                                        $leaveStatusTooltip = '';
                                                                        $disabled = '';
                                                                        $style = '';
                                                                        $holidayDate  = '';
                                                                        $holidayName = '';

                                                                        $calenderDate = $day.'_'.$monthNum.'_'.$year;
                                                                        $calenderDated = $dayZeros.$day.'-'.$monthNum.'-'.$year;
                                                                        $compareDate = date("Y-m-d", strtotime($calenderDated));
                                                                         
                                                                        $getHolidayData = DB::select('SELECT * FROM `holiday` WHERE is_deleted_status = "N"  AND date = "'.$compareDate.'"');
                                                                        if (!empty($getHolidayData)) {
                                                                            foreach ($getHolidayData as $holiday) {
                                                                                $holidayDate = $holiday->date;
                                                                                $holidayName = $holiday->name;
                                                                            }
                                                                        }   
                                                                        
                                                                        if ($compareDate == $holidayDate) {

                                                                            echo "<td style='".$currentBg."'>
                                                                                <span class='label label-info pull-right' style='padding:5px 5px 5px 5px' data-toggle='tooltip' data-placement='top' title='' data-original-title='".$holidayName."' ><i class='fa fa-paperclip'></i>
                                                                                </span> ";
                                                                                $oldColor = '';
                                                                                
                                                                                /* if ($day == date('d'))  {
                                                                                    $currentColor = "";
                                                                                }*/

                                                                        }  else {
                                                                               
                                                                            $getLeaveReqData = DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND user_id =  '.Session::get('sessionUserData')[0][0]->id.' AND date = "'.$calenderDated.'"'); 
                                                                            echo "<td  style='".$currentBg."".$sundayBg."".$oldBg."' alt='default'";

                                                                            if (!empty($getLeaveReqData)) {

                                                                                if ($getLeaveReqData[0]->leave_status == 1) {

                                                                                    echo  "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."'";
                                                                                    $leaveStatusColor = 'warning';
                                                                                    $leaveStatusTooltip = 'Pending';

                                                                                }  else if ($getLeaveReqData[0]->leave_status == 3) {
                                                                                        
                                                                                    echo  "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."'";
                                                                                    $leaveStatusColor = 'success';
                                                                                    $leaveStatusTooltip = 'Approved';
                                                                                    $style = 'style="display:none"';
                                                                                    $disabled = 'disabled';
                                                                                    
                                                                                } else {

                                                                                    echo  "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."'";
                                                                                    $leaveStatusColor = 'danger';
                                                                                    $leaveStatusTooltip = 'Rejected';
                                                                                    $style = 'style="display:none"';
                                                                                    $disabled = 'disabled';
                                                                                
                                                                                }

                                                                                echo   "> <span class='label label-".$leaveStatusColor." pull-right' style='padding:5px 5px 5px 5px' data-toggle='tooltip' data-placement='top' 
                                                                                title='' data-original-title='".$leaveStatusTooltip."' ><i class='fa fa-paperclip'></i>
                                                                                </span>";

                                                                            } else {

                                                                                if ($day >= date('d')) {    
                                                                                    echo "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."'>";  
                                                                                } else {
                                                                                    echo ">";
                                                                                }

                                                                            }

                                                                        }

                                                                        echo "<a role='button' style='color: black;padding:39px 0px' 
                                                                            class='days active openBtn' >";
                                                                        echo "<b style=' ".$oldColor." ".$currentColor." ' >".$day."</b>";
                                                                        echo "</td>";

                                                                        if ($wday==6)
                                                                            echo "</tr>";
                                                                        ?>

                                                                        <?php
                                                                            if ($day < date('d')) {
                                                                        ?>

                                                                            <div id="responsive-modal_<?php echo $calenderDate; ?>" class="modal fade" 
                                                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" onclick="closeLeave('<?php echo $calenderDate; ?>')" 
                                                                                            >×</button>
                                                                                            <h5 class="modal-title text-center" id="myModalLabel" style="margin-top: 5px;">
                                                                                                <i class="icon-call-in fa-fw"></i>&nbsp;
                                                                                                    Request a Leave on <?php                   
                                                                                                    $zero = '';
                                                                                                    if ($day <= 9) {
                                                                                                        $zero = 0;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <?php 
                                                                                                        echo $zero.$day.'-'.$monthNameChr.'-'.$year;
                                                                                                        $leaveDate =  $day.'-'.$monthNum.'-'.$year; 
                                                                                                    ?>
                                                                                            </h5>  
                                                                                        </div>
                                                                                        <?php

                                                                                            $dayZero = '';
                                                                                            if ($day <= 9) {
                                                                                                $dayZero = 0;
                                                                                            }

                                                                                            $selected = '';
                                                                                            $paddingDates =  "'".$dayZero.$day.'-'.$monthNum.'-'.$year."'"; 

                                                                                            $getLeaveReqPadding = DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND   user_id = '.Session::get('sessionUserData')[0][0]->id.'  AND date = '.$paddingDates.'');
                                                                                            $reasonValue = !empty($getLeaveReqPadding[0]->reason) ? $getLeaveReqPadding[0]->reason : '';

                                                                                            if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                            ?>
                                                                                                    <input type="hidden" name="levelReqId" id="levelReqId_<?php echo $calenderDate; ?>" 
                                                                                                        value="<?php echo $getLeaveReqPadding[0]->id; ?>">
                                                                                            <?php 

                                                                                            }  else {

                                                                                            ?>      
                                                                                                    <input type="hidden" name="levelReqId" id="levelReqId_<?php echo $calenderDate; ?>" 
                                                                                                        value="<?php echo 0; ?>">
                                                                                        <?php 
                                                                                            }
                                                                                        ?>
                                                                                        <div class="modal-bodys" style="margin:10px;">
                                                                                            <form id="reason_form_<?php echo $calenderDate; ?>" >
                                                                                                <div class="row">
                                                                                                    <div class="col-md-1">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <label for="inputEmail3" class="control-label text-right col-form-label" style="color: black;">Leave Type :
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <select class="form-control" id="leave_type_<?php echo $calenderDate; ?>" 
                                                                                                            name="leave_type" disabled>
                                                                                                            <option value="1"
                                                                                                            <?php 
                                                                                                            if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 1) {  
                                                                                                                    echo 'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            ?>
                                                                                                            >
                                                                                                            Full Day</option>
                                                                                                            <option value="2" <?php 
                                                                                                            if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 2) {  
                                                                                                                    echo  'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            ?>>
                                                                                                            Half Day</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row" style="margin-top: 10px;">
                                                                                                    <div class="col-md-1">
                                                                                                    </div>
                                                                                                    <div class="col-md-2" >
                                                                                                        <label for="inputEmail3" class="control-label text-right col-form-label" style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reason : </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-6" >
                                                                                                        <textarea class="form-control borderred" id="reason_<?php echo $calenderDate; ?>" 
                                                                                                            name="reason" oninput="emptyReason('<?php echo $calenderDate; ?>')" rows="4"  placeholder="Leave Reason..."  disabled><?php echo trim($reasonValue);?></textarea>
                                                                                                        <span class="text-danger" id="emptyReason_<?php echo $calenderDate; ?>">
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row" style="margin-top: 10px;display: none;" >
                                                                                                    <div class="col-md-3">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <button  type="button" id="submit_<?php echo $calenderDate; ?>" class="btn btn-sm btn-success pull-left" 
                                                                                                         onclick="submitLeaveRequest('<?php echo $calenderDate; ?>',
                                                                                                            <?php echo $paddingDates; ?>)">Submit
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <div class="col-md-1" style="margin-left: -37px;">
                                                                                                        <button type="button" onclick="refreshLeaveRequest('<?php echo $calenderDate; ?>')"   class="btn btn-sm btn-dark pull-left">Clear
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <?php
                                                                                                        if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                                    ?>  
                                                                                                            
                                                                                                        <div class="col-md-3">
                                                                                                            <a href="#" 
                                                                                                            onclick="deleteLeaveRequest(<?php echo $getLeaveReqPadding[0]->id; ?>,<?php echo $paddingDates; ?>)"  class="btn btn-sm btn-danger pull-right" >Cancel Leave
                                                                                                            </a>
                                                                                                        </div>

                                                                                                    <?php 
                                                                                                    }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>  

                                                                        <?php
                                                                            } else {
                                                                        ?>
                                                                            <div id="responsive-modal_<?php echo $calenderDate; ?>" class="modal fade" 
                                                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" onclick="closeLeave('<?php echo $calenderDate; ?>')" >× 
                                                                                            </button>
                                                                                            <h5 class="modal-title text-center" id="myModalLabel"  style="margin-top: 5px;">
                                                                                                <i class="icon-call-in fa-fw"></i>&nbsp; Request a Leave on <?php                   
                                                                                                    $zero = '';
                                                                                                    if ($day <= 9) {
                                                                                                        $zero = 0;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <?php 

                                                                                                    echo $zero.$day.'-'.$monthNameChr.'-'.$year;

                                                                                                    $leaveDate =  $day.'-'.$monthNum.'-'.$year; 
                                                                                                    ?>
                                                                                            </h5>  
                                                                                        </div>
                                                                                        <?php
                                                                                            $dayZero = '';
                                                                                            if ($day <= 9) {
                                                                                                $dayZero = 0;
                                                                                            }
                                                                                            $selected = '';

                                                                                            $paddingDates =  "'".$dayZero.$day.'-'.$monthNum.'-'.$year."'"; 

                                                                                            $getLeaveReqPadding = DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND   user_id = '.Session::get('sessionUserData')[0][0]->id.'  AND date = '.$paddingDates.'');

                                                                                            $reasonValue = 
                                                                                            !empty($getLeaveReqPadding[0]->reason) ? $getLeaveReqPadding[0]->reason : '';

                                                                                            if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                            ?>      
                                                                                                <input type="hidden" name="levelReqId"  id="levelReqId_<?php echo $calenderDate; ?>"value="<?php echo $getLeaveReqPadding[0]->id; ?>">
                                                                                            <?php 
                                                                                                }  else {
                                                                                            ?>
                                                                                                <input type="hidden" name="levelReqId"  id="levelReqId_<?php echo $calenderDate; ?>" value="<?php echo 0; ?>">
                                                                                            <?php 
                                                                                                }
                                                                                            ?>
                                                                                        <div class="modal-bodys" style="margin:10px;">
                                                                                            <form id="reason_form_<?php echo $calenderDate; ?>" >
                                                                                                <div class="row">
                                                                                                    <div class="col-md-1">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <label for="inputEmail3" class="control-label text-right col-form-label" style="color: black;">Leave Type :
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <select class="form-control" 
                                                                                                        id="leave_type_<?php echo $calenderDate; ?>" name="leave_type" <?php echo $disabled; ?>>
                                                                                                            <option value="1"
                                                                                                            <?php 
                                                                                                            if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 1) {  
                                                                                                                    echo 'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            ?>
                                                                                                            >
                                                                                                            Full Day</option>
                                                                                                            <option value="2" <?php 
                                                                                                            if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 2) {  
                                                                                                                    echo  'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            ?>>
                                                                                                            Half Day</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row" style="margin-top: 10px;">
                                                                                                    <div class="col-md-1">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <label for="inputEmail3" class="control-label text-right col-form-label" style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reason : </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-6" >
                                                                                                        <textarea class="form-control borderred" id="reason_<?php echo $calenderDate; ?>" name="reason" oninput="emptyReason('<?php echo $calenderDate; ?>')" rows="4" placeholder="Leave Reason..."  <?php echo $disabled; ?> ><?php echo trim($reasonValue);?></textarea>

                                                                                                        <span class="text-danger"  
                                                                                                        id="emptyReason_<?php echo $calenderDate; ?>">
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row" style="margin-top: 10px;">
                                                                                                    
                                                                                                    <div class="col-md-3">
                                                                                                    </div>

                                                                                                    <div class="col-md-2">
                                                                                                        <button type="button" <?php echo $style; ?> id="submit_<?php echo $calenderDate; ?>"  class="btn btn-sm btn-success pull-left" 
                                                                                                        onclick="submitLeaveRequest('<?php echo $calenderDate; ?>',<?php echo $paddingDates; ?>)">Submit
                                                                                                        </button>
                                                                                                    </div>

                                                                                                    <div class="col-md-1" style="margin-left: -37px;">
                                                                                                        <button type="button" <?php echo $style; ?> onclick="refreshLeaveRequest('<?php echo $calenderDate; ?>')" 
                                                                                                            class="btn btn-sm btn-dark pull-left">Clear
                                                                                                        </button>
                                                                                                    </div>

                                                                                                    <?php
                                                                                                        if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                                    ?>  
                                                                                                            
                                                                                                            <div class="col-md-3">
                                                                                                                <a href="#" <?php echo $style; ?>
                                                                                                                     onclick="deleteLeaveRequest(<?php echo $getLeaveReqPadding[0]->id; ?>,<?php echo $paddingDates; ?>)"  class="btn btn-sm btn-danger pull-right" > Cancel Leave
                                                                                                                </a>
                                                                                                            </div>
                                                                                                    <?php 
                                                                                                        }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php 
                                                                            } 
                                                                        ?>
                                                                    <?php
                                                                        $wday++; 
                                                                        $wday = $wday % 7; 
                                                                        $day++; 
                                                                    }

                                                                    while($wday <=6 ) 
                                                                    {
                                            
                                                                        $wday++;
                                                                    }
                                                                    echo "</tr>";
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            &nbsp;&nbsp;
                            <!-- 2 card -->
                            
                            <div class="card border-info col-md-2" style="background: #f4f8f9">
                                <div class="card-header bg-warning" style="height: 39px;">
                                    <h6 class="m-b-0 text-white"><i class="icon-book-open fa-fw"></i>&nbsp;
                                        Attendance 
                                    </h6>
                                    <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->id)) {
                                            $date = date('d-m-Y');
                                            $userId = Session::get('sessionUserData')[0][0]->id;
                                            $countAttendance = DB::select('SELECT count(*) as countAttendance 
                                            FROM `attendance` WHERE is_deleted_status = "N" AND  user_id = '.$userId.' AND 
                                            date = "'.$date.'"');
                                        }

                                        if (!empty($countAttendance[0]->countAttendance)) {
                                    ?>         
                                            <button type="button" class="btn btn-primary btn-circle" data-toggle="dropdown" href="javascript:void(0);" 
                                            style="margin-top: -55px;margin-left: 134px;width: 33px;height: 33px;padding: 1px;">
                                                <i class="fa fa-list"></i>
                                            </button>
                                            <ul class="dropdown-menu" style="padding-top: 0px;border: 1px;">
                                                <style type="text/css">
                                                    .table td,th{
                                                        /*padding: 0.1rem !important;*/
                                                        vertical-align: top;
                                                        border-top: 1px solid #dee2e6;
                                                    } 
                                                    .table th{
                                                        color:#333b3f
                                                    }
                                                </style>
                                                <div class="modal-sm">
                                                    <div class="card-header bg-info" style="width: 155%;height: 39px" >
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff">×</button>
                                                        <h6 class="m-b-0 text-white" 
                                                        style="color: #fff;" id="mySmallModalLabel"><i class="icon-calender fa-fw"></i>&nbsp;&nbsp;{{date('d-M-Y')}} | {{date('l')}}
                                                        </h6> 
                                                    </div>
                                                    <table class="table-bordered" style="width: 155%;background-color: #f4f8f9">  
                                                        <thead style="color: black;background: #456c4552;font-size: 14px;">
                                                            <tr >
                                                                <th style="padding: 0.1rem !important;font-weight: 600" class="text-center" ><b style="font-weight: 600">Sr.No</b></th>
                                                                <th style="padding: 0.1rem !important;" class="text-center" ><b style="font-weight: 600">Check in</b></th>
                                                                <th style="padding: 0.1rem !important;" class="text-center" ><b style="font-weight: 600">Check out</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $getAttendanceData = DB::select('SELECT * FROM attendance WHERE is_deleted_status = "N" AND date = "'.$date.'" AND user_id = 
                                                                    '.$userId.'');
                                                            ?>
                                                            @if (!empty($getAttendanceData))
                                                                @foreach ($getAttendanceData as $key => $attendance)
                                                                    <tr @if($attendance->status == 'No') 
                                                                            style="background-color:#ff851b !important"
                                                                    @endif>
                                                                        <td class="text-center">{{$key+1}}</td>
                                                                        <td class="text-center">
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
                                                                        <td class="text-center">
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
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </ul>
                                            <?php
                                        }
                                    ?> 
                                </div>

                                <div class="card-body" style="padding: 0.5rem;color: black">&nbsp;
                                    <i class="icon-calender fa-fw"></i>&nbsp;  {{date('d-M-Y')}} | {{date('l')}} 
                                    <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->id)) {
                                            $userId = Session::get('sessionUserData')[0][0]->id;
                                            $date = date('d-m-Y');
                                            $firstCheckInStatus = DB::select('SELECT count(*) as firstCheckIn FROM `attendance`  WHERE is_deleted_status = "N" AND  user_id = '.$userId.' AND date 
                                            = "'.$date.'"'); 
                                            if ($firstCheckInStatus[0]->firstCheckIn == 0) {
                                            ?>
                                                <button class="btn waves-effect waves-light btn-outline-success"  style="margin-top:5px;margin-left: 5px;" 
                                                onclick="checkIn()"><i class="icon-login"></i>&nbsp;&nbsp;Check In</button>
                                            <?php 

                                            } else {

                                                $firstCheckOutStatus = DB::select('SELECT count(*) as firstCheckOut FROM `attendance` 
                                                WHERE is_deleted_status = "N" AND  user_id = '.$userId.' AND date = "'.$date.'" AND out_time = ""');
                                                if (!empty($firstCheckOutStatus[0]->firstCheckOut)) {
                                                ?>

                                                <button class="btn waves-effect waves-light btn-outline-warning" onclick="checkOut()" 
                                                    style="margin-top:5px;margin-left: 5px;" > <i class="icon-logout" ></i>&nbsp;&nbsp;Check Out
                                                </button>  

                                                <?php 
                                                } else {
                                                ?>

                                                <button class="btn waves-effect waves-light btn-outline-success" onclick="checkIn()" 
                                                style="margin-top:5px;margin-left: 5px;"><i class="icon-login" ></i>&nbsp;&nbsp;Check In</button>

                                                <?php 

                                                }

                                            }
                                        }
                                
                                    ?>  
                                </div>
                            </div>  
                        </div>
                        <?php 
                        }
                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && (Session::get('sessionUserData')[0][0]->role_id == 3 || Session::get('sessionUserData')[0][0]->role_id == 1)) {
                        ?>
                            <h4 class="card-title">Manage Ticket</h4>
                            <div class="table-responsive" >
                                <style type="text/css">
                                    .table-responsive {
                                        white-space: nowrap;
                                        width: 100%;
                                        margin-bottom: 15px;
                                        overflow-x: hidden;
                                        overflow-y: hidden;
                                    }
                                </style>
                                <table id="default_order" class="table table-striped table-bordered display" style="width:100%">
                                    <thead style="color: black;background: #456c4552;">
                                        <tr>
                                            <th style="display: none;">Ticket No.</th>
                                            <th>No.</th>
                                            <th>Title</th>
                                            
                                            <?php                                 
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                echo '<th>Name</th>';
                                            }
                                            ?>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>MISC</th>
                                            <?php                                 
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                echo '<th>Assigned to</th>';
                                            }
                                            ?>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $getTicketData = [];
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id == 4) {
                                                $getTicketData = DB::table('ticket')
                                                    ->select('ticket_status.user_id','ticket_status.ticket_status_id','ticket.*')
                                                    ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
                                                    ->orderBy('ticket.task_compittion_date','DESC')
                                                    ->orderBy('ticket.ticket_no','DESC')
                                                    ->where('ticket.is_deleted_status','N')
                                                    ->where('ticket_status.user_id',Session::get('sessionUserData')[0][0]->id)
                                                    ->get()
                                                    ->toArray();
                                            }  else {
                                                /*    $getTicketData = DB::table('ticket')
                                                    ->select('ticket_status.user_id','ticket_status.ticket_status_id','ticket.*')
                                                    ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
                                                    ->orderBy('ticket.task_compittion_date','DESC')
                                                    ->orderBy('ticket.ticket_no','DESC')
                                                    ->where('ticket.is_deleted_status','N')
                                                    ->get()
                                                    ->toArray();  
                                                */ 
                                                $getTicketData = DB::table('ticket')
                                                ->select('ticket.*')
                                                ->orderBy('ticket.task_compittion_date','DESC')
                                                ->orderBy('ticket.ticket_no','DESC')
                                                ->where('ticket.is_deleted_status','N')
                                                ->get()
                                                ->toArray(); 
                                            }
                            
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                Session::get('sessionUserData')[0][0]->role_id == 3) { 
                                                $getTicketData = DB::table('ticket')
                                                ->select('ticket_assign.*','ticket.*')
                                                ->join('ticket_assign', 'ticket_assign.ticket_id','ticket.id')
                                                ->orderBy('ticket.task_compittion_date','DESC')
                                                ->orderBy('ticket.ticket_no','DESC')
                                                ->where('ticket.is_deleted_status','N')
                                                ->where('ticket_assign.user_id',Session::get('sessionUserData')[0][0]->id)
                                                ->get()
                                                ->toArray(); 
                                            }
                                            ?>
                                        @if (!empty($getTicketData))
                                            @foreach ($getTicketData as  $key => $ticket)
                                                <tr @if($ticket->status == 'No') 
                                                        style="background-color:#ff851b !important"
                                                    @endif
                                                    >
                                                    <td style="display: none;">{{$key+1}}</td>
                                                    <td>{{$ticket->ticket_no}}</td>
                                                    <td><?php echo wordwrap($ticket->title,15,"<br />\n");?></td>
                                                    <?php 
                                                        $getUserIdByTicket =  DB::select('SELECT * FROM `ticket_status`  WHERE 
                                                        is_deleted_status = "N" AND  ticket_id = '.$ticket->id.'  ORDER BY id ASC LIMIT 1'); 
                                                        $ticketStatusUserId = !empty($getUserIdByTicket[0]->user_id) ? $getUserIdByTicket[0]->user_id : 0;
                                                        $getUserName = DB::table('user_master')
                                                        ->select('username')
                                                        ->where('id',$ticketStatusUserId)
                                                        ->where('is_deleted_status','N')
                                                        ->get()
                                                        ->toArray();
                                                        if (!empty($getUserName[0]->username)) {
                                                        // echo $getUserName[0]->username;
                                                        }
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                            Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                        ?>
                                                    <td>
                                                        <?php echo !empty($getUserName[0]->username) ? $getUserName[0]->username : '';?>
                                                    </td>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <td>
                                                        <?php 
                                                            $getClientTicketTypeData = [];
                                                            if (!empty($ticket->ticket_type_id)) {
                                                                $getClientTicketTypeData = DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" AND id ='.$ticket->ticket_type_id.'');
                                                                if (!empty($getClientTicketTypeData[0]->name)) {
                                                                    $name = $getClientTicketTypeData[0]->name;
                                                                    echo  $name;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $ticketStatus = '';
                                                            $statusColour = '';
                                                            $style = '';
                                                     
                                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id == 3) {
                            
                                                                $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status`  WHERE is_deleted_status = "N" AND  ticket_id = '.$ticket->id.'  ORDER BY id DESC LIMIT 1'); 
                                                                $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                                
                                                                if (!empty($ticketStatusId)) { 
                              
                                                                    $getTicketStatusData = DB::select('SELECT * FROM `ticket_status_master` WHERE is_deleted_status = "N" AND status ='.$ticketStatusId.'');
                                                                    $ticketStatus = !empty($getTicketStatusData[0]->ticket_status) ? 
                                                                    $getTicketStatusData[0]->ticket_status : '';
                                                                    $statusColour = !empty($getTicketStatusData[0]->status_colour) ? 
                                                                    $getTicketStatusData[0]->status_colour : '';
                                                                    $status = !empty($getTicketStatusData[0]->status) ? $getTicketStatusData[0]->status : '';
                                                                    if ($status == 4) { $style = 'background:#2b2b2b;';}
                                                                        echo '<span class="label-rounded label-'.$statusColour.' pull-left" style="margin-left:5px;'.$style.'color:#fff">'.$ticketStatus.'</span>';
                                                                }   else {
                                                                        echo '<span class="label-rounded label-primary pull-left"     style="margin-left:5px;color:#fff">New</span>';
                                                                }

                                                            } else {
                            
                                                                $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status`  WHERE   is_deleted_status = "N" AND  ticket_id = '.$ticket->id.'  ORDER BY id DESC LIMIT 1'); 
                                                                $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                                if (!empty($ticketStatusId)) { 
                                                                    $getTicketStatusData = DB::select('SELECT * FROM `ticket_status_master` WHERE is_deleted_status = "N" AND status ='.$ticketStatusId.'');
                                                                    $ticketStatus = !empty($getTicketStatusData[0]->ticket_status) ? 
                                                                    $getTicketStatusData[0]->ticket_status : '';
                                                                    $statusColour = !empty($getTicketStatusData[0]->status_colour) ? 
                                                                    $getTicketStatusData[0]->status_colour : '';
                                                                    $status = !empty($getTicketStatusData[0]->status) ? $getTicketStatusData[0]->status : '';
                                                                    if ($status == 4) { $style = 'background:#2b2b2b;';}
                                                                    echo '<span class="label-rounded label-'.$statusColour.' pull-left" style="margin-left:5px;'.$style.'color:#fff">'.$ticketStatus.'</span>'; 
                                                                } else {
                                                                    echo '<span class="label-rounded label-primary pull-left"     style="margin-left:5px;color:#fff">New</span>';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if (!empty($ticket->project_id)) { 
                                                                $getProjectByIdData = DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N" AND 
                                                                id ='.$ticket->project_id.'');
                                                                if (!empty($getProjectByIdData[0]->name)) {
                                                                    $name =  wordwrap($getProjectByIdData[0]->name,28, "<br />\n");
                                                                    echo '<button class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="right" title="" data-original-title="Project Name" style="color: #fff;padding:2px 8px;">
                                                                    <i class="icon-notebook"></i>&nbsp;'.$name.'</button>';
                                                                }
                                                            }
                                                        ?>
                                                        </br>
                                                        @if (!empty($ticket->priority))
                                                            @if ($ticket->priority == 1)
                                                               <button class="btn btn-danger btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;margin-top:2px;padding:2px 8px;"> <i class="icon-equalizer"></i>&nbsp;High</button>
                                                            @endif
                                                            
                                                            @if ($ticket->priority == 2)   
                                                                <button class="btn btn-warning btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Low</button>
                                                            @endif
                                                            @if ($ticket->priority == 3)
                                                                <button class="btn btn-info btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Medium</button>
                                                            @endif
                                                            <br>
                                                        @endif

                                                        @if (!empty($ticket->priority))
                                                            @if ($ticket->severity == 1)
                                                                <button class="btn btn-danger btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-arrow-up-circle"></i>&nbsp;Critical</button>
                                                            @endif
                                                            @if ($ticket->severity == 2) 
                                                                <button class="btn btn-success btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-arrow-down-circle"></i>&nbsp;Normal</button>
                                                            @endif
                                                            <br>
                                                        @endif
                                                        <?php 
                                                            if (!empty($ticket->task_compittion_date)) {
                                                                if  ($ticket->task_compittion_date != '1000-10-01') {
                                                                    $compittionDate =  date("d-m-Y", strtotime($ticket->task_compittion_date));
                                                                    echo '<button class="btn btn ribbon-default btn-rounded" data-toggle="tooltip" data-placement="right" title="" data-original-title="Compittion Date"  style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-calender fa-fw"></i>'.$compittionDate.'</button></br>';
                                                                }
                                                            }
                                                        ?>
                                                        <?php
                                                            $getAdminTicketTypeData = [];
                                                            if (!empty($ticket->ticket_type_id_admin)) {
                                                                $getAdminTicketTypeData = DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" AND id ='.$ticket->ticket_type_id_admin.'');
                                                                if (!empty($getAdminTicketTypeData[0]->name)) {
                                                                    $name = $getAdminTicketTypeData[0]->name;
                                                                    echo '<button class="btn btn-info btn-rounded" data-toggle="tooltip" data-placement="right" title="" data-original-title="Admin Ticket Type"  style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-tag"></i>&nbsp;'.$name.'</button></br>';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php 
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    ?>
                                                        <td class="text-left">
                                                        <?php
                                                            $userName = '';
                                                            $getAssignDatad =  DB::select('SELECT * FROM ticket_assign WHERE is_deleted_status = "N" 
                                                            AND ticket_id = '.$ticket->id.'');
                                                            $userIdArrd = [];
                                                            if (!empty($getAssignDatad)) {
                                                                foreach ($getAssignDatad as $ticketAssing) {
                                                                    $userIdArrd[] = $ticketAssing->user_id;
                                                                }       
                                                            }
                                                            $userIded = implode(',', $userIdArrd);
                                                            $userIdArrs = !empty($userIded) ? $userIded : 0;
                                                            $getUserNameDatad = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" AND id IN('.$userIdArrs.')');
                                                            $userAssingName  = '';
                                                            if (!empty($getUserNameDatad)) {
                                                                foreach ($getUserNameDatad as $user) {
                                                                    $userAssingName .= $user->username.'</br>,';
                                                                } 
                                                                echo rtrim($userAssingName,",");   
                                                            }   
                                                        ?>
                                                        </td>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    <td><?php echo wordwrap($ticket->created_at,10,"<br />\n"); ?></td>
                                                    <td>
                                                        <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" 
                                                        class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" style="padding: 0px 7px;" ><i class="icon-pencil"></i>
                                                        </a>
                                                        <?php 
                                                            $getAttachmentData = DB::select('SELECT count(*) as attachmentTicketCount  FROM `attachment` 
                                                            WHERE is_deleted_status = "N" AND ticket_id ='.$ticket->id.'');
                                                            if (!empty($getAttachmentData[0]->attachmentTicketCount)) {
                                                                echo '<a href=""  class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title=""    data-original-title="Attachment" style="padding: 0px 7px;" ><i class="icon-paper-clip"></i> </a>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        <?php 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="chat-windows"></div>


 
    <script type="text/javascript">

        function checkIn() {
            window.location.href="{{ route('checkin') }}";  
        }

        function checkOut() {
            window.location.href="{{ route('checkout') }}";   
        }



    </script>

    @include('admin.common.script2')

    <script type="text/javascript">

        function refreshLeaveRequest(calenderDay=null) {
            var quantity =  $('#reason_'+calenderDay).val(''); 
            $('#emptyReason_'+calenderDay).hide();
        }
        
        function deleteLeaveRequest(leaveReqId=null,leaveDate=null) {
            var retVal = confirm("Are you Want to delete?");
            if( retVal == true ) {
                $.ajax({
                    type: "GET",
                    url: '{{route("removeLeaveRequest")}}',
                    data : {  
                        leaveReqId:leaveReqId,
                        leaveDate:leaveDate
                    },
                    success: function(data) {
                       document.location.reload();
                    }
                });
            }
        }


        function closeLeave(calenderDay = null) {
            $('#responsive-modal_'+calenderDay).hide();
        }
        

        function submitLeaveRequest(calenderDay=null,leaveDate=null) {
           
            var reason =  $('#reason_'+calenderDay).val(); 
            var leaveType =  $('#leave_type_'+calenderDay).val();
            var leaveReqId =  $('#levelReqId_'+calenderDay).val();
            if (leaveReqId != 0) {
                
                if (reason != "")  {
                    $.ajax({
                        type: "GET",
                        url: '{{route("updateLeaveRequest")}}',
                        data : {  
                            reason: reason,
                            leaveType: leaveType,
                            leaveDate:leaveDate,
                            leaveReqId:leaveReqId                      
                        },
                        success: function(data) {
                           document.location.reload();
                        }
                    }); 
                }   else {
                    $('#emptyReason_'+calenderDay).show();
                    $('#emptyReason_'+calenderDay).html('Reason field is required.');
                }

            } else {

                if (reason != "")  {
                    $("#submit_"+calenderDay).attr("disabled", true);
                    $.ajax({
                        type: "GET",
                        url: '{{route("addLeaveRequest")}}',
                        data : {  
                            reason: reason,
                            leaveType: leaveType,
                            leaveDate:leaveDate
                        },
                        success: function(data) {
                            document.location.reload();
                        }
                    }); 
                }  else {
                    $('#emptyReason_'+calenderDay).show();
                    $('#emptyReason_'+calenderDay).html('Reason field is required.');
                }
            }
        }
        
        $('.modal fade').modal({backdrop: 'static', keyboard: false});

        @if(\Session::has('message'))
            toastr.success(
                '{{session()->get('message')}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 3000 
                }
            );
        @endif
        
        @if (!empty($successMsg))
            toastr.success(
                '{{$successMsg}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 3000 
                }
            );
        @endif

        function calenderPopup(userId = null) {
            $('div').removeClass( "modal-backdrop fade in" );
        }

        function emptyReason(day=null) {
            var reason =  $('#reason_'+day).val(); 
            if (reason != "") {
                $('#emptyReason_'+day).hide();
            } else {
                $('#emptyReason_'+day).show();
            }
        }

        function Go(type = null,month = null,year = null) {

            // 2 - prev , 3 - next , 1 - currentMonth //
            
            if (type == 2) {
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $('#getCalenderId').html(data);
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }

            if (type == 3) {
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $('#getCalenderId').html(data);
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }
            
            if (type == 1) {
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $('#getCalenderId').html(data);
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }
        }
    </script>    
    </body>
</html>
