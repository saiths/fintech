@include('admin.common.main2')

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

        .table thead th {/*border-left: none;*/ }
        .table tr.info, td.info, .table tr.info th {
            background: #2d3a40 !important;
            color: #FFF;
        }

        .table>thead>tr>th { /*border: none;*/ }
        .table tbody td {
            /*font-weight: 600;
            border-color: #E4E4E4 !important;
            border-right: 0px !important;
            background: #FAFAFA;
            */
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

        .table th, .table td {
            text-align: center;
        }

         .calender>thead>tr>th {
            padding: 10px 0px;
        }
        .calender tbody td:hover {
            background: #D7F2FF;
            cursor: pointer;
        }
        .calender tbody td {
            padding: 0px;
            border: solid 1px #CCC !important;
        }
    </style>
    
    <style type="text/css">
        .tooltip1 {
          position: relative;
          display: inline-block;
          border-bottom: 1px dotted black;
        }
        
        .tooltip1 .tooltiptext {
          visibility: hidden;
          width: 120px;
          background-color: black;
          color: #fff;
          text-align: center;
          border-radius: 6px;
          padding: 5px 0;
          position: absolute;
          z-index: 1;
          bottom: 150%;
          left: 50%;
          margin-left: -60px;
        }
        
        .tooltip1 .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }
        
        .tooltip1:hover .tooltiptext {
            visibility: visible;
        }
        
        .tooltip2 {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }

        .tooltip2 .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            top: -5px;
            left: 110%;
        }

        .tooltip2 .tooltiptext::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent black transparent transparent;
        }
        
        .tooltip2:hover .tooltiptext {
            visibility: visible;
        }
        
    </style>

    <div class="page-wrapper"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
<?php 
    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4) {
?>  
                    <div class="card-body" style="display: none;"> 
                            
<?php 
}   if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id != 4) {
?>
                        <div class="card-body" style="padding: 0.75rem;"> 
                            <div class="row">
                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 1) {
                                ?>
                                    <!-- 1 card -->
                                    <div class="card border-info col-md-2" style="background: #f4f8f9;cursor:pointer;border:3px solid #ffbc34!important;" 
                                    onclick="active(1)">
                                        <div class="card-header bg-warning" style="height: 39px;width: 212px;margin-left: -10px;">
                                            <h6 class="m-b-0 text-white text-center"><i class="ti-server"></i>&nbsp;Active Task</h6>
                                        </div>
                                        <div class="card-body" style="padding: 0.5rem;color: black" >
                                            <?php
                                                $getTicketData = 
                                                DB::table('ticket')
                                                ->select('ticket.*')
                                                ->where('ticket.is_deleted_status','N')
                                                ->get()
                                                ->toArray();
                                               
                                               // $paddingTaskTotal = 0;
                                                $activeTaskTotal = 0;
                                                $newTaskTotal = 0;
                                                $proTaskTotal = 0;
                                                $reopenTaskTotal = 0;
                                                
                                                /*if (!empty($getTicketData)) {
                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status` 
                                                            WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                $getStatusIdArr = DB::select('SELECT COUNT(*) as count FROM `ticket_status` WHERE is_deleted_status = "N" AND  id = '.$ticketIdMax.' 
                                                                    AND ticket_status_id != 5 ');
                                                                if (!empty($getStatusIdArr)) {
                                                                    foreach ($getStatusIdArr as $ticketsDatas) {
                                                                        if (!empty($ticketsDatas->count)) {
                                                                            $paddingTaskTotal += $ticketsDatas->count;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }*/
                                                if (!empty($getTicketData)) {
                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status` 
                                                            WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                $newGetStatusIdArr = DB::select('SELECT COUNT(*) as newCount FROM `ticket_status` WHERE is_deleted_status = "N" AND  id = '.$ticketIdMax.' 
                                                                    AND ticket_status_id = 1  ');
                                                                if (!empty($newGetStatusIdArr)) {
                                                                    foreach ($newGetStatusIdArr as $newTicketsDatas) {
                                                                        if (!empty($newTicketsDatas->newCount)) {
                                                                            $newTaskTotal += $newTicketsDatas->newCount;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status` 
                                                            WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                 $processGetStatusIdArr = DB::select('SELECT COUNT(*) as proCount FROM `ticket_status` WHERE is_deleted_status = "N" AND  
                                                                    id = '.$ticketIdMax.' AND ticket_status_id = 2 ');
                                                                if (!empty($processGetStatusIdArr)) {
                                                                    foreach ($processGetStatusIdArr as $proTicketsDatas) {
                                                                        if (!empty($proTicketsDatas->proCount)) {
                                                                            $proTaskTotal += $proTicketsDatas->proCount;

                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status` 
                                                            WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                 $reOpenGetStatusIdArr = DB::select('SELECT COUNT(*) as reopenCount FROM `ticket_status` WHERE is_deleted_status = "N" AND  
                                                                    id = '.$ticketIdMax.' AND ticket_status_id = 6  ');
                                                                if (!empty($reOpenGetStatusIdArr)) {
                                                                    foreach ($reOpenGetStatusIdArr as $reopenTicketsDatas) {
                                                                        if (!empty($reopenTicketsDatas->reopenCount)) {
                                                                            $reopenTaskTotal += $reopenTicketsDatas->reopenCount;
                                                                        }
                                                                    }
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                                $activeTaskTotal = $newTaskTotal+$proTaskTotal+$reopenTaskTotal;
                                                
                                            ?>
                                            <span  style="color: #ffbc34;font-size:40px;"><center id="notifyAjax_active"><?php echo $activeTaskTotal; ?></center></span>
                                        </div>
                                    </div>
                                    
                                    <!-- 2 card -->
                                    <div class="card border-info col-sm-2" style="background: #f4f8f9;cursor: pointer;border:3px solid #137eff!important;" 
                                    onclick="fixed(3)">
                                        <div class="card-header bg-info" style="height: 39px;width: 212px;margin-left: -10px;">
                                            <h6 class="m-b-0 text-white text-center"><i class="icon-check"></i>&nbsp;Fixed Task</h6>
                                        </div>
                                        <div class="card-bdoy" style="padding: 0.5rem;color: black">
                                            <?php
                                                $getTicketData = 
                                                DB::table('ticket')
                                                ->select('ticket.*')
                                                ->where('ticket.is_deleted_status','N')
                                                ->get()
                                                ->toArray(); 
                                                $completeTaskTotal = 0;
                                                if (!empty($getTicketData)) {
                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status`  
                                                        WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                $getStatusId = DB::select('SELECT COUNT(*) as count FROM `ticket_status` 
                                                                WHERE is_deleted_status = "N" AND  id = '.$ticketIdMax.' AND 
                                                                    ticket_status_id = 3');
                                                                if (!empty($getStatusId)) {
                                                                    foreach ($getStatusId as $ticketsDatas) {
                                                                        $completeTaskTotal += $ticketsDatas->count; 
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            <span  style="color: #137eff;font-size:40px;"><center id="notifyAjax_fixed"><?php echo $completeTaskTotal; ?></center></span>
                                        </div>
                                    </div>
                                    
                                    <!-- 3 card -->
                                    <div class="card border-info col-md-2" style="background: #f4f8f9;cursor: pointer;border:3px solid #2b2b2b!important;" 
                                    onclick="disputed(4)">
                                        <div class="card-header bg-" style="height: 39px;background: #2b2b2b;width: 212px;margin-left: -10px;">
                                            <h6 class="m-b-0 text-white text-center"><i class="icon-question"></i>&nbsp;Disputed Task</h6>
                                        </div>
                                        <div class="card-bdoy" style="padding: 0.5rem;color: black">
                                            <?php
                                                $getTicketData = DB::table('ticket')->select('ticket.*')->where('ticket.is_deleted_status','N')->get()->toArray(); 
                                                $completeTaskTotal = 0;
                                                if (!empty($getTicketData)) {
                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status`  
                                                        WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                $getStatusId = DB::select('SELECT COUNT(*) as count FROM `ticket_status` 
                                                                WHERE is_deleted_status = "N" AND  id = '.$ticketIdMax.' AND 
                                                                    ticket_status_id = 4');
                                                                if (!empty($getStatusId)) {
                                                                    foreach ($getStatusId as $ticketsDatas) {
                                                                        $completeTaskTotal += $ticketsDatas->count; 
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            <span  style="color: #2b2b2b;font-size:40px;"><center id="notifyAjax_disputed"><?php echo $completeTaskTotal; ?></center></span>
                                        </div>
                                    </div>
                                    
                                    <!-- 4 card -->
                                    <div class="card border-success col-md-2" style="background: #f4f8f9;cursor: pointer;border:3px solid #5ac146!important;" 
                                    onclick="complete(5)">
                                        <div class="card-header bg-success" style="height: 39px;width: 212px;margin-left: -10px;">
                                            <h6 class="m-b-0 text-white text-center"><i class="icon-close"></i>&nbsp;Completed Task</h6>
                                        </div>
                                        <div class="card-bdoy" style="padding: 0.5rem;color: black">
                                            <?php
                                                $getTicketData = DB::table('ticket')->select('ticket.*')->where('ticket.is_deleted_status','N')->get()->toArray(); 
                                                $completeTaskTotal = 0;
                                                if (!empty($getTicketData)) {
                                                    foreach ($getTicketData as $key => $ticketData) {
                                                        $getTicketStatusData = DB::select('SELECT MAX(id) as maxid FROM `ticket_status`  
                                                        WHERE is_deleted_status = "N" AND  ticket_id = '.$ticketData->id.'');
                                                        if (!empty($getTicketStatusData)) {
                                                            foreach ($getTicketStatusData as $ticketsData) {
                                                                $ticketIdMax = !empty($ticketsData->maxid) ? $ticketsData->maxid : 0;
                                                                $getStatusId = DB::select('SELECT COUNT(*) as count FROM `ticket_status` 
                                                                WHERE is_deleted_status = "N" AND  id = '.$ticketIdMax.' AND 
                                                                    ticket_status_id = 5');
                                                                if (!empty($getStatusId)) {
                                                                    foreach ($getStatusId as $ticketsDatas) {
                                                                        $completeTaskTotal += $ticketsDatas->count; 
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            <span  style="color: #5ac146;font-size:40px;"><center id="notifyAjax_closed"><?php echo $completeTaskTotal; ?></center></span>
                                        </div>
                                    </div>
                                <?php 
                                    } 
                                ?>
                                <?php 
                                    $requestStyle = '';
                                    $attendanceStyle = '';
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                    
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                            $requestStyle = 'style="height: 39px;width: 214px;margin-left: -10px;"';
                                        } else {
                                            $requestStyle = 'style="height: 39px;width: 212px;margin-left: -10px;"';
                                        } 
    
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                            $attendanceStyle = 'style="height: 39px;width: 215px;margin-left: -10px;"';
                                        } else {
                                            $attendanceStyle = 'style="height: 39px;width: 212px;margin-left: -10px;"';
                                        } 

                                    } else {

                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 2) {
                                            $requestStyle = 'style="height: 39px;width: 214px;margin-left: -10px;"';
                                        } else {
                                            $requestStyle = 'style="height: 39px;width: 212px;margin-left: -10px;"';
                                        } 
    
                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 2) {
                                            $attendanceStyle = 'style="height: 39px;width: 215px;margin-left: -10px;"';
                                        } else {
                                            $attendanceStyle = 'style="height: 39px;width: 212px;margin-left: -10px;"';
                                        } 
                                    }
                                ?>
                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                ?>&nbsp;
                                
                                <?php } ?>

                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 2) {
                                ?>&nbsp;
                                
                                <?php } ?>
                                
                                
                                <!-- 5 card -->
                                <div class="card border-secondary col-md-2" style="background: #f4f8f9;border:3px solid #6c757d!important;">
                                    <div class="card-header bg-secondary" <?php echo $requestStyle; ?>>
                                        <h6 class="m-b-0 text-white text-center"><i class="icon-call-in fa-fw"></i>&nbsp;
                                            Request a Leave 
                                        </h6>
                                    </div>
                                    <div class="card-body" style="padding: 0.75rem;">
                                        <button class="btn waves-effect waves-light btn-outline-secondary" alt="default" 
                                        data-toggle="modal" 
                                        data-target="#myModal_{{Session::get('sessionUserData')[0][0]->id}}" 
                                        class="model_img img-responsive" style="margin-left: 33px">
                                            <i class="icon-call-in fa-fw"></i>&nbsp; Request
                                        </button>
                                        <div id="myModal_{{Session::get('sessionUserData')[0][0]->id}}" class="modal fade" tabindex="-1" role="dialog" 
                                            aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false"   aria-hidden="true" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"  data-dismiss="modal"  aria-hidden="true" 
                                                            onclick="calenderPopup({{Session::get('sessionUserData')[0][0]->id}})" id="calenderMain" >×
                                                        </button>
                                                        <h4 class="modal-title text-center" id="myModalLabel"><i class="icon-call-in fa-fw"></i>
                                                            &nbsp;Request a Leave
                                                        </h4> 
                                                    </div>
                                                    <div class="row" id="loading_0"></div>
                                                    <div class="row" id="text_0"></div>
                                                    <div class="modal-bodys" style="font-weight: 600;border: 1px black" id="getCalenderId">
                                                        <table class="table calender" id="tablepoint">
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
                                                                        <!--<a class="prev" onclick="Go(2,<?php echo $monthNum; ?>,<?php echo $year; ?>)" 
                                                                            data-toggle="tooltip" data-placement="top" title="" data-original-title="Previous"  href="javascript:void(0)">
                                                                        </a>
                                                                        -->
                                                                        <a class="prev" onclick="Go(2,<?php echo $monthNum; ?>,<?php echo $year; ?>,0)" 
                                                                              href="javascript:void(0)">
                                                                        </a>
                                                                        
                                                                        <span id="mes" class="text-center" style="color: #FFF;font-weight: 600;"><?php echo $monthNameChr;?>
                                                                        </span>
                                                                        
                                                                        <!--<a class="next" onclick="Go(3,<?php echo $monthNum; ?>,<?php echo $year; ?>)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Next"  href="javascript:void(0)"></a>
                                                                        -->
                                                                        <a class="next" onclick="Go(3,<?php echo $monthNum; ?>,<?php echo $year; ?>,0)"  
                                                                        href="javascript:void(0)"></a>
                                                                        
                                                                    </th>
                                                                    <th style="padding: 0px; line-height: 40px;">
                                                                       <!--  <a class="today" onclick="Go(1,<?php echo $monthNum; ?>,<?php echo $year; ?>)" href="javascript:void(0)" style="color: #FFF;font-weight: 600;"><i class="icon-home"></i></a> -->
                                                                    </th>
                                                                </tr>
                                                                <tr class="weekdays info" id="monday" >
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
                                                                        $holidaysBg = '';
                                                                        $holidayColor = '';
                                                                        

                                                                        $calenderDate = $day.'_'.$monthNum.'_'.$year;
                                                                        $calenderDated = $dayZeros.$day.'-'.$monthNum.'-'.$year;
                                                                        $compareDate = date("Y-m-d", strtotime($calenderDated));
                                                                        
                                                                        $dateNameArr = [];
                                                                        $getHolidayData = DB::select('SELECT * FROM `holiday` WHERE is_deleted_status = "N"');
                                                                        if (!empty($getHolidayData)) {
                                                                            foreach ($getHolidayData as $key => $holiday) {
                                                                                $interval = new DateInterval('P1D'); 
                                                                                $realEnd = new DateTime($holiday->to_date); 
                                                                                $realEnd->add($interval); 
                                                                                $dateArrs = new DatePeriod(new DateTime($holiday->form_date), $interval, $realEnd); 
                                                                                foreach($dateArrs as $date) {                  
                                                                                    $dateNameArr[$date->format('Y-m-d')] = $holiday->name;
                                                                                }
                                                                            }
                                                                        } 
                                                                        
                                                                        if (array_key_exists($compareDate, $dateNameArr)) {
                                                                            
                                                                            $currentDates = strtotime(date('Y-m-d')); 
                                                                            $compareDates = strtotime($compareDate);
                                                                            
                                                                            if ($compareDate == date('Y-m-d'))  {
                                                                                $holidaysBg = "background-color:#0283cc;";
                                                                                $holidayColor = ";color:#fff";
                                                                            } else if($compareDates < $currentDates) {  
                                                                                $holidaysBg = "background-color:#ddd;";
                                                                                $holidayColor = ";color:#fff";
                                                                            } else {
                                                                                $holidaysBg = "background-color:#D7F2FF;";
                                                                                $holidayColor = ";color:black";
                                                                            }

                                                                            echo "<td style='".$holidaysBg."'>
                                                                                <span class='label label-info pull-right tooltip7' 
                                                                                    style='padding:5px 5px 5px 5px;float: right;border:none' title=''>
                                                                                    <i class='fa fa-paperclip'></i>
                                                                                    <span class='tooltiptext' style='font-size: 11px;'>";
                                                                                
                                                                                echo $dateNameArr[$compareDate];
                                                                                echo "</span></span> ";
                                                                                $oldColor = '';
                                                                                
                                                                                /* if ($day == date('d'))  {
                                                                                    $currentColor = "";
                                                                                }*/

                                                                        }  else {
                                                                               
                                                /*                            $getLeaveReqData = 
                                                    DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND 
                                                    user_id =  '.Session::get('sessionUserData')[0][0]->id.' AND date = "'.$calenderDated.'"'); 
                                                    */
                                                    
                                                      $getLeaveReqData = DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" 
                                                      AND user_id =  '.Session::get('sessionUserData')[0][0]->id.'');
                                                        $dateNameArrs = [];
                                                        if (!empty($getLeaveReqData)) {
                                                            foreach ($getLeaveReqData as $key => $requestData) {
                                                                $leaveStatausArrs[] =  $requestData->leave_status;
                                                                $interval = new DateInterval('P1D'); 
                                                                $realEnd = new DateTime($requestData->to_date); 
                                                                $realEnd->add($interval); 
                                                                $dateArrs = new DatePeriod(new DateTime($requestData->form_date), 
                                                                $interval, $realEnd); 
                                                                foreach($dateArrs as $date) { 
                                                                    $dateNameArrs[] =  $date->format('Y-m-d');
                                                                    $leaveStatausArrs[$date->format('Y-m-d')] =  
                                                                    $requestData->leave_status.'-'. $requestData->reason.'-'.$requestData->leave_type.'-'.$requestData->id.'-'.$requestData->leave_day;
                                                                    
                                                                }
                                                            }
                                                        }
                                                        
                                                $compareDateaaa = 
                                            !empty($leaveStatausArrs[$compareDate]) ? $leaveStatausArrs[$compareDate] : 0;
                                        
                                        $part2 = explode('-', $compareDateaaa);
                                        
                                        
                                                
                                                echo "<td  style='".$currentBg."".$sundayBg."".$oldBg."' alt='default'";
    
                                   // if (!empty($getLeaveReqData)) {
                                      if (in_array($compareDate, $dateNameArrs)) {

                                            if ($part2[0] == 1) {


                                       // if ($getLeaveReqData[0]->leave_status == 1) {

                                                echo  "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."'";
                                                $leaveStatusColor = 'warning';
                                                $leaveStatusTooltip = 'Pending';
                                                if ($part2[4] == 2) {
                                                    $disabled = 'disabled';
                                                }

                                       // }  else if ($getLeaveReqData[0]->leave_status == 3) {
                                       
                                        }  else if ($part2[0]  == 3) {
                                                                                    
                                                
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

                                        echo   "> <span class='label label-".$leaveStatusColor." pull-right' style='padding:5px 5px 5px 5px;float: right;' data-toggle='tooltip' data-placement='top' 
                                        title='' data-original-title='".$leaveStatusTooltip."' ><i class='fa fa-paperclip'></i>
                                        </span>";
                                        

                                    } else {

                                        if ($day >= date('d')) {    
                                            echo "data-toggle='modal' data-target='#responsive-modal_".$calenderDate."' 
                                            onclick='selectedHoverColor(".$day.")' id='hover_".$day."'>";  
                                        } else {
                                            echo ">";
                                        }
                                        
                                    }

                                }

                            echo "<a role='button' style='color: black;padding:39px 0px' class='days active openBtn' >";
                            echo "<b style=' ".$oldColor." ".$currentColor."".$holidayColor." ' >".$day."</b>";
                            echo "</td>";

                            if ($wday==6)
                                echo "</tr>";
                            ?>
                            <?php
                                if ($day < date('d')) {
                            ?>

                                <div id="responsive-modal_<?php echo $calenderDate; ?>" class="modal fade" 
                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"  >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" onclick="closeLeave('<?php echo $calenderDate; ?>',<?php echo $day; ?>,<?php echo date('d'); ?>)" 
                                                    id="closeFormLeave_<?php echo $calenderDate; ?>" >×</button>
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

                                                    /*$getLeaveReqPadding = DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND   
                                                    user_id = '.Session::get('sessionUserData')[0][0]->id.'  AND date = '.$paddingDates.'');
                                                    */
                                                    
                                                    $reasonValue = !empty($part2[1]) ? $part2[1] : '';

                                                    //$reasonValue = !empty($getLeaveReqPadding[0]->reason) ? $getLeaveReqPadding[0]->reason : '';
                                                    
                                                    if (!empty($part2[3])) {
                                                         
                                                         
                                                         
                                                    //if (!empty($getLeaveReqPadding[0]->id)) {
                                                    ?>
                                                    
            <!--<input type="hidden" name="levelReqId" id="levelReqId_<?php //echo $calenderDate; ?>" 
            value="<?php //echo $getLeaveReqPadding[0]->id; ?>">
            -->
             <input type="hidden" name="levelReqId" id="levelReqId_<?php echo $calenderDate; ?>" 
             value="<?php echo $part2[3]; ?>">
            
                                                    <?php 

                                                    }  else {

                                                    ?> 
                            <input type="hidden" name="levelReqId" id="levelReqId_<?php echo $calenderDate; ?>" 
                            value="<?php echo 0; ?>">
                            
                           <!-- <input type="hidden" name="levelReqId" id="levelReqId_<?php //echo $calenderDate; ?>" 
                            value="<?php //echo 0; ?>">-->
                            
                            
                                                <?php 
                                                
                                                    }
                                                ?>
                                                
                                                
                                                <div class="modal-bodys" style="margin:10px;">
                                                    <form id="reason_form_<?php echo $calenderDate; ?>" >
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="inputEmail3" class="control-label text-right col-form-label" 
                                                                style="color: black;">Leave Type :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select class="form-control" id="leave_type_<?php echo $calenderDate; ?>" 
                                                                    name="leave_type" disabled>
                                                                    <option value="1"
                                                                    <?php 
                                                                    /*if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 1) {  
                                                                            echo 'selected="selected"';
                                                                        }   
                                                                    }*/
                                                                    
                                                                    if (!empty($part2[2])) {
                                                                        if ($part2[2] == 1) {  
                                                                            echo 'selected="selected"';
                                                                        }   
                                                                    }
                                                                    
                                                                    ?>
                                                                    >
                                                                    Full Day</option>
                                                                    <option value="2" <?php 
                                                                    /*if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 2) {  
                                                                            echo  'selected="selected"';
                                                                        }   
                                                                    }*/
                                                                    
                                                                    if (!empty($part2[2])) { 
                                                                        if ($part2[2] == 2) {  
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
                                                                <label for="inputEmail3" class="control-label text-right col-form-label" 
                                                                style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reason : </label>
                                                            </div>
                                                            <div class="col-md-6" >
                                                                <textarea class="form-control borderred" id="reason_<?php echo $calenderDate; ?>" 
                                                                    name="reason" oninput="emptyReason('<?php echo $calenderDate; ?>')" rows="4"  
                                                                    placeholder="Leave Reason..."  disabled><?php echo trim($reasonValue);?></textarea>
                                                                <span class="text-danger" id="emptyReason_<?php echo $calenderDate; ?>">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-top: 10px;display: none;" >
                                                            
                                                            <div class="col-md-3">
                                                            </div>
                                                             <?php 
                                                                                                    
                                                            $part4 = !empty($part2[4]) ? $part2[4] : 0;

                                                            if ($part4 == 2) {
                                                            

                                                            } else {
                                                            ?>    

                                                            <div class="col-md-2">
                                                                <button  type="button" id="submit_<?php echo $calenderDate; ?>" 
                                                                class="btn btn-sm btn-success pull-left" 
                                                                 onclick="submitLeaveRequest('<?php echo $calenderDate; ?>',
                                                                    <?php echo $paddingDates; ?>)">Submit
                                                                </button>
                                                            </div>
                                                            <div class="col-md-1" style="margin-left: -37px;">
                                                                <button type="button" onclick="refreshLeaveRequest('<?php echo $calenderDate; ?>')" 
                                                                id="clear_button_<?php echo $calenderDate; ?>"   class="btn btn-sm btn-dark pull-left">Clear
                                                                </button>
                                                            </div>
                                                            
                                                            <?php
                                                            }
                                                             if (!empty($part2[4])) {
                                                                 
                                                                if ($part2[4] == 2) { 
                                                                    
                                                                } else {

                                                            
                                                                //if (!empty($getLeaveReqPadding[0]->id)) {
                                                            ?>      
                                                                    <div class="col-md-3">
                                                                        <a href="#" 
                                                                        onclick="deleteLeaveRequest('<?php echo $part2[3];; ?>,<?php echo $paddingDates; ?>,'<?php echo $calenderDate; ?>')"  
                                                                        class="btn btn-sm btn-danger pull-right" id="delete_button_<?php echo $calenderDate; ?>">Cancel Leave
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    <?php 
                                                                }
                                                             }
                                                            ?>
                                                        </div>
                                                        
                                                        <div class="row" id="loading_<?php echo $calenderDate; ?>" style="display: none;">
                                                            <div class="col-md-2">
                                                            </div>
                                                            <div class="col-md-3">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <img src="{{ URL::asset('public/image/lorder.gif')}}" 
                                                                style="height: 50px;width: 50px;" />
                                                            </div>
                                                        </div>
                                                        <div class="row" id="text_<?php echo $calenderDate; ?>" style="display: none;">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h6 class="box-title" style="font-size: 14px;color: black;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please Wait....</h6>
                                                            </div>
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
                                                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"  >
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" 
                                                                                            onclick="closeLeave('<?php echo $calenderDate; ?>',<?php echo $day; ?>,<?php echo date('d'); ?>)" id="closeFormLeave_<?php echo $calenderDate; ?>" >× 
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

                                                                                            /*$getLeaveReqPadding = 
                                                                                            
                                                                                            
                                                                                            DB::select('SELECT * FROM `leave_request` WHERE is_deleted_status = "N" AND   
                                                                                            user_id = '.Session::get('sessionUserData')[0][0]->id.'  
                                                                                            AND date = '.$paddingDates.'');*/

                                                                                          /*  $reasonValue = 
                                                                                            !empty($getLeaveReqPadding[0]->reason) ? $getLeaveReqPadding[0]->reason : '';*/
                                                                                            
                                                                                             $reasonValue = !empty($part2[1]) ? $part2[1] : '';

                                                                                            //if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                                
                                                                                                if (!empty($part2[3])) {
                                                                                                    
                                                                                            ?>      
                                                                                                <input type="hidden" name="levelReqId" 
                                                                                                id="levelReqId_<?php echo $calenderDate; ?>" value="<?php echo $part2[3]; ?>">
                                                                                            <?php 
                                                                                                }  else {
                                                                                            ?>
                                                                                                <input type="hidden" name="levelReqId"  
                                                                                                id="levelReqId_<?php echo $calenderDate; ?>" value="<?php echo 0; ?>">
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
                                                                                                            /*if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 1) {  
                                                                                                                    echo 'selected="selected"';
                                                                                                                }   
                                                                                                            }*/
                                                                                                            
                                                                                                            if (!empty($part2[2])) {
                                                                                                                if ($part2[2] == 1) {  
                                                                                                                    echo 'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            
                                                                                                            ?>
                                                                                                            >
                                                                                                            Full Day</option>
                                                                                                            <option value="2" <?php 
                                                                                                            /*if (!empty($getLeaveReqPadding[0]->leave_type)) {if ($getLeaveReqPadding[0]->leave_type == 2) {  
                                                                                                                    echo  'selected="selected"';
                                                                                                                }   
                                                                                                            }
                                                                                                            */
                                                                                                            if (!empty($part2[2])) {
                                                                                                                if ($part2[2] == 2) {  
                                                                                                                    echo 'selected="selected"';
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
                                                                                                        <label for="inputEmail3" class="control-label text-right col-form-label" 
                                                                                                        style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reason : </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-6" >
                                                                                                        <textarea class="form-control borderred" id="reason_<?php echo $calenderDate; ?>" name="reason" 
                                                                                                        
                                                                                                        oninput="emptyReason('<?php echo $calenderDate; ?>')" rows="4" placeholder="Leave Reason..."  <?php echo $disabled; ?> ><?php echo trim($reasonValue);?></textarea>

                                                                                                        <span class="text-danger"  
                                                                                                        id="emptyReason_<?php echo $calenderDate; ?>">
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row" style="margin-top: 10px;">
                                                                                                    
                                                                                                    <div class="col-md-3">
                                                                                                    </div>
                                                                                                    <?php 
                                                                                                    
                                                                                                    $part4 = !empty($part2[4]) ? $part2[4] : 0;
                                                                                                    
                                                                                                    if ($part4 == 2) {
                                                                                                    
                                                                                                    } else {
                                                                                                    ?>    
                                                                                                        <div class="col-md-2">
                                                                                                            <button type="button" <?php echo $style; ?> id="submit_<?php echo $calenderDate; ?>"  class="btn btn-sm btn-success pull-left" 
                                                                                                            onclick="submitLeaveRequest('<?php echo $calenderDate; ?>',<?php echo $paddingDates; ?>)">Submit
                                                                                                            </button>
                                                                                                        </div>
    
                                                                                                        <div class="col-md-1" style="margin-left: -37px;">
                                                                                                            <button type="button" <?php echo $style; ?> onclick="refreshLeaveRequest('<?php echo $calenderDate; ?>')" 
                                                                                                                id="clear_button_<?php echo $calenderDate; ?>" class="btn btn-sm btn-dark pull-left">Clear
                                                                                                            </button>
                                                                                                        </div>

                                                                                                    <?php
                                                                                                    }
                                                                                                       // if (!empty($getLeaveReqPadding[0]->id)) {
                                                                                                        if (!empty($part2[4])) {
                                                                                                            if ($part2[4] == 2) { }else {
                                                                                                    ?>  
                                                                                                            
                                                                                                            <div class="col-md-3">
                                                                                                                <a href="#" <?php echo $style; ?>
                                                                                                                     onclick="deleteLeaveRequest(<?php echo $part2[3]; ?>,<?php echo $paddingDates; ?>,'<?php echo $calenderDate; ?>')"  
                                                                                                                     class="btn btn-sm btn-danger pull-right" id="delete_button_<?php echo $calenderDate; ?>" > Cancel Leave
                                                                                                                </a>
                                                                                                            </div>
                                                                                                    <?php 
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                </div>
                                                                                                <div class="row" id="loading_<?php echo $calenderDate; ?>" style="display: none;">
                                                                                                    <div class="col-md-2">
                                                                                                    </div>
                                                                                                    <div class="col-md-3">
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <img src="{{ URL::asset('public/image/lorder.gif')}}" 
                                                                                                        style="height: 50px;width: 50px;" />
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row" id="text_<?php echo $calenderDate; ?>" style="display: none;">
                                                                                                    <div class="col-md-4">
                                                                                                    </div>
                                                                                                    <div class="col-md-4">
                                                                                                        <h6 class="box-title" style="font-size: 14px;color: black;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please Wait....</h6>
                                                                                                    </div>
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
                                
                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 2) {
                                ?>&nbsp;
                                
                                <?php } ?>

                                <?php 
                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 3) {
                                ?>&nbsp;
                                
                                <?php } ?>
                                
                                <!-- 6 card -->
                                <div class="card border-info col-md-2" style="background: #f4f8f9;border:3px solid #7460ee!important">
                                    <div class="card-header bg-primary" <?php echo $attendanceStyle;?>>
                                        <h6 class="m-b-0 text-white text-center"><i class="icon-book-open fa-fw"></i>&nbsp;Attendance</h6>
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
                                            <ul class="dropdown-menu" style="border:none;margin:-4px -275px;">
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
                                                    <div class="card-header bg-info" style="width: 128%;height: 39px" >
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff">×</button>
                                                        <h6 class="m-b-0 text-white" 
                                                        style="color: #fff;" id="mySmallModalLabel"><i class="icon-calender fa-fw"></i>&nbsp;&nbsp;{{date('d-M-Y')}} | {{date('l')}}
                                                        </h6> 
                                                    </div>
                                                    <table class="table-bordered" style="width: 128%;background-color: #f4f8f9">  
                                                        <thead style="color: black;background: #456c4552;font-size: 14px;">
                                                            <tr >
                                                                <th style="padding: 0.1rem !important;font-weight: 600" class="text-center" ><b style="font-weight: 600">Sr.No</b></th>
                                                                <th style="padding: 0.1rem !important;" class="text-center" ><b style="font-weight: 600">Check in</b></th>
                                                                <th style="padding: 0.1rem !important;" class="text-center" ><b style="font-weight: 600">Check out</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php   
                                                                $getAttendanceData = 
                                                                DB::select('SELECT * FROM attendance WHERE is_deleted_status = "N" AND date = "'.$date.'" 
                                                                AND user_id = '.$userId.'');
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

                                <div class="card-body" style="padding: 0.5rem;color: black">
                                    <i class="icon-calender fa-fw"></i>&nbsp;  {{date('d-M-Y')}} | {{date('l')}} 
                                    <?php 
                                        if (!empty(Session::get('sessionUserData')[0][0]->id)) {
                                            $userId = Session::get('sessionUserData')[0][0]->id;
                                            $date = date('d-m-Y');
                                            $firstCheckInStatus = DB::select('SELECT count(*) as firstCheckIn FROM `attendance`  WHERE is_deleted_status = "N" AND  user_id = '.$userId.' AND date 
                                            = "'.$date.'"'); 
                                            if ($firstCheckInStatus[0]->firstCheckIn == 0) {
                                            ?>
                                                <button class="btn btn-success" id="checkinId"  style="margin-top:4px;margin-left: 38px;" 
                                                onclick="checkIn()"><i class="icon-login"></i>&nbsp;&nbsp;Check In</button>
                                            <?php 

                                            } else {

                                                $firstCheckOutStatus = DB::select('SELECT count(*) as firstCheckOut FROM `attendance` 
                                                WHERE is_deleted_status = "N" AND  user_id = '.$userId.' AND date = "'.$date.'" AND 
                                                out_time = ""');
                                                if (!empty($firstCheckOutStatus[0]->firstCheckOut)) {
                                                ?>

                                                <button class="btn btn-warning" onclick="checkOut()" id="checkoutId"
                                                    style="margin-top:4px;margin-left: 30px;" > 
                                                    <i class="icon-logout" ></i>&nbsp;&nbsp;Check Out
                                                </button>  

                                                <?php 
                                                } else {
                                                ?>

                                                <button class="btn btn-success" id="checkinId" onclick="checkIn()" 
                                                style="margin-top:4px;margin-left: 38px;"><i class="icon-login" ></i>&nbsp;&nbsp;Check In</button>

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
if (!empty(Session::get('sessionUserData')[0][0]->role_id) && (Session::get('sessionUserData')[0][0]->role_id == 0 || 
Session::get('sessionUserData')[0][0]->role_id == 0)) {
?>
                            <h4 class="card-title">Manage Ticket</h4>
                            <div class="table-responsive" >
                                <style type="text/css">
                                    .display th, .display td {
                                        text-align: left;
                                    }
                                </style>
                                <table id="default_order" class="table table-striped table-bordered display" style="width:100%">
                                    <thead style="color: black;background: #456c4552;">
                                        <tr style="color: black;">
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
                                            <th>Ticket Issue Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $getTicketData = [];
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                            Session::get('sessionUserData')[0][0]->role_id == 4) {
                                                $getTicketData = DB::table('ticket')
                                                    ->select('ticket_status.user_id','ticket_status.ticket_status_id','ticket.*')
                                                    ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
                                                    //->orderBy('ticket.task_compittion_date','DESC')
                                                    ->orderBy('ticket.ticket_no','DESC')
                                                    ->where('ticket.is_deleted_status','N')
                                                    ->where('ticket_status.user_id',Session::get('sessionUserData')[0][0]->id)
                                                    ->get()
                                                    ->toArray();
                                            }  else {
                                                $getTicketData = DB::table('ticket')
                                                ->select('ticket.*')
                                                //->orderBy('ticket.task_compittion_date','DESC')
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
                                                //->orderBy('ticket.task_compittion_date','DESC')
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
                                                    <td><?php echo wordwrap($ticket->title,15);?></td>
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
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  
                                                            Session::get('sessionUserData')[0][0]->role_id == 3) {
                                                                
                                                                $getClientTicketTypeData = [];
                                                                if (!empty($ticket->ticket_type_id_admin)) {
                                                                    $getClientTicketTypeData = 
                                                                    DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" 
                                                                    AND id ='.$ticket->ticket_type_id_admin.'');
                                                                    if (!empty($getClientTicketTypeData[0]->name)) {
                                                                        $name = $getClientTicketTypeData[0]->name;
                                                                        echo  $name;
                                                                    }
                                                                }
                                                                
                                                            } else {
                                                                
                                                                $getClientTicketTypeData = [];
                                                                if (!empty($ticket->ticket_type_id)) {
                                                                    $getClientTicketTypeData = 
                                                                    DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" 
                                                                    AND id ='.$ticket->ticket_type_id.'');
                                                                    if (!empty($getClientTicketTypeData[0]->name)) {
                                                                        $name = $getClientTicketTypeData[0]->name;
                                                                        echo  $name;
                                                                    }
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
                                                                        echo '<span class="label label-rounded label-'.$statusColour.'" style="'.$style.'color:#fff;font-size: 12px;">'.$ticketStatus.'</span>';
                                                                }   else {
                                                                        echo '<span class="label label-rounded label-primary "     style="color:#fff;font-size: 12px;">New</span>';
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
                                                                    echo '<span class="label label-rounded label-'.$statusColour.' pull-left" style="'.$style.'color:#fff;font-size: 12px;">'.$ticketStatus.'</span>'; 
                                                                } else {
                                                                    echo '<span class="label label-rounded label-primary" style="color:#fff;font-size: 12px;">New</span>';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <style type="text/css">
                                                            .ticket_header {
                                                                display: flex;
                                                                align-items: flex-start;
                                                                justify-content: space-between;
                                                                padding: 1rem;
                                                                border-bottom: 1px solid rgba(0,0,0,.1);
                                                                border-top-left-radius: 2px;
                                                                border-top-right-radius: 2px;
                                                            }
                                                            .ticket_body {
                                                                position: relative;
                                                                flex: 1 1 auto;
                                                                padding: 1rem;
                                                                padding: 15px 15px;
                                                            }
                                                        </style>
                                                        <div id="myModal_{{$ticket->id}}" class="modal" tabindex="-1" role="dialog" 
                                                            aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="max-width: 350px;">
                                                                <div class="modal-content">
                                                                    <div class="ticket_header">
                                                                        <h4 class="modal-title" id="myModalLabel">{{$ticket->ticket_no}} - Ticket Detail</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" 
                                                                        style="font-size: 25px">×</button>
                                                                    </div>
                                                                    <div class="ticket_body">
                                                                        <div class="container-fluid">
                                                                            <div class="row" >
                                                                                <div class="col-md-12">
                                                                                    <?php 
                                                                                        if (!empty($ticket->project_id)) { 
                                                                                            $getProjectByIdData = DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N" AND 
                                                                                            id ='.$ticket->project_id.'');
                                                                                            if (!empty($getProjectByIdData[0]->name)) {
                                                                                                $name =  wordwrap($getProjectByIdData[0]->name,28, "<br />\n");
                                                                                                echo '<button class="btn btn-primary btn-rounded" 
                                                                                                data-toggle="tooltip" data-placement="right" title="" 
                                                                                                data-original-title="Project Name" style="color: #fff;padding:2px 8px;"><i class="icon-notebook"></i>&nbsp;'.$name.'</button>';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="margin-top:2px;">
                                                                                <div class="col-md-4">
                                                                                    @if (!empty($ticket->priority))
                                                                                        @if ($ticket->priority == 1)
                                                                                           <button class="btn btn-danger btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"> <i class="icon-equalizer"></i>&nbsp;High</button>
                                                                                        @endif
                                                                                        
                                                                                        @if ($ticket->priority == 2)   
                                                                                            <button class="btn btn-warning btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Low</button>
                                                                                        @endif
                                                                                        @if ($ticket->priority == 3)
                                                                                            <button class="btn btn-info btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Medium</button>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    @if (!empty($ticket->priority))
                                                                                        @if ($ticket->severity == 1)
                                                                                            <button class="btn btn-danger btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;padding:2px 8px;"><i class="icon-arrow-up-circle"></i>&nbsp;Critical</button>
                                                                                        @endif
                                                                                        @if ($ticket->severity == 2) 
                                                                                            <button class="btn btn-success btn-rounded"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-arrow-down-circle"></i>&nbsp;Normal</button>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="margin-top:2px;" >
                                                                                <div class="col-md-12">
                                                                                    <?php
                                                                                        $getAdminTicketTypeData = [];
                                                                                        if (!empty($ticket->ticket_type_id_admin)) {
                                                                                            $getAdminTicketTypeData = DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" AND id ='.$ticket->ticket_type_id_admin.'');
                                                                                            if (!empty($getAdminTicketTypeData[0]->name)) {
                                                                                                $name = $getAdminTicketTypeData[0]->name;
                                                                                                echo '<button class="btn btn-info btn-rounded" data-toggle="tooltip" data-placement="right" title="" data-original-title="Admin Ticket Type"  style="color: #fff;padding:2px 8px;"><i class="icon-tag"></i>&nbsp;'.$name.'</button>';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="margin-top:2px;" >
                                                                                <div class="col-md-12">
                                                                                    <?php 
                                                                                        if (!empty($ticket->task_compittion_date)) {
                                                                                            if  ($ticket->task_compittion_date != '1000-10-01') {
                                                                                                $compittionDate =  date("d-m-Y", strtotime($ticket->task_compittion_date));
                                                                                                echo '<button class="btn waves-effect waves-light btn-rounded btn-dark" data-toggle="tooltip" data-placement="right" title="" data-original-title="Compittion Date"  style="color: #fff;padding:2px 8px;"><i class="icon-calender fa-fw"></i>&nbsp;'.$compittionDate.'</button>';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            
                                                        <a class="btn waves-effect waves-light btn-rounded btn-primary" href="#" role="button" alt="default" data-toggle="modal" 
                                                            data-target="#myModal_{{$ticket->id}}" 
                                                            style="padding: 0px 7px;font-size: 13px">Ticket Detail
                                                        </a>
                                                    </td>
    
                                                    <?php 
                                                        if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    ?>
                                                        <td>
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
                                                                    $userAssingName .= $user->username.',';
                                                                } 
                                                                echo rtrim($userAssingName,",");   
                                                            }   
                                                        ?>
                                                        </td>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    <td>
                                                        <span class="label label-rounded label-secondary" data-toggle="tooltip" data-placement="top" title=""  data-original-title="<?php echo wordwrap($ticket->created_at,1); ?>"  style="font-size: 12px;color: #fff;background-color: #6c757d;border-color: #6c757d;">Date</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" 
                                                        class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="" 
                                                        data-original-title="Edit" style="padding: 0px 7px;" ><i class="ti-pencil"></i>
                                                        </a>
    
                                                        <?php 
                                                            $getAttachmentData = DB::select('SELECT count(*) as attachmentTicketCount  FROM `attachment` 
                                                            WHERE is_deleted_status = "N" AND ticket_id ='.$ticket->id.'');
                                                            if (!empty($getAttachmentData[0]->attachmentTicketCount)) {
                                                                echo '<a href=""  class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title=""    data-original-title="Attachment" style="padding: 0px 7px;" ><i class="mdi mdi-paperclip"></i> </a>';
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
} else if(!empty(Session::get('sessionUserData')[0][0]->role_id) && (Session::get('sessionUserData')[0][0]->role_id == 1 || Session::get('sessionUserData')[0][0]->role_id == 3)) {
?>

                            <h4 class="card-title">Manage Ticket</h4>
                            <!--<div class="table-responsive" ng-init="fetchTicketData()">-->
                            <div class="table-responsive">
                                <style type="text/css">
                                    .display th, .display td {
                                        text-align: left;
                                    }
                                </style>
                                <!--<table id="default_order" class="table table-striped table-bordered display" style="width:100%" datatable="ng" dt-options="vm.dtOptions">-->
                                <table id="default_order" class="table table-striped table-bordered display" style="width:100%" >
                                    <thead style="color: black;background: #456c4552;">
                                        <tr style="color: black;">
                                            <th style="display:none;">Id</th>
                                            <?php                                 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 1) { 
                                                    echo '<th style="display:none"></th>';
                                                    echo '<th style="display:none"></th>';
                                                    echo '<th style="display:none"></th>';  
                                                }
                                            ?>
                                            <th>Ticket No.</th>
                                            <th>Ticket Title</th>
                                            <?php                                 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    echo '<th>Name</th>';
                                                }
                                            ?>
                                            <th>Ticket Type</th>
                                            <th>Status</th>
                                            <th>MISC</th>
                                            <?php                                 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    echo '<th>Assigned to</th>';
                                                }
                                            ?>
                                            <th>Ticket Issue Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getTicketDatas))
                                            @foreach ($getTicketDatas as $key => $ticket) 
                                                <!--<tr id="removeId_{{$ticket->id}}">-->
                                                <tr id="removeId_{{$ticket->id}}">
                                                    <td style="display:none;">{{ $ticket->id }}</td>
                                                    <?php 
                                                        /*  <tr @if($ticket->status == 'No') 
                                                                style="background-color:#ff851b !important"
                                                            @endif
                                                        >*/
                                                    ?>
                                                    <?php                                 
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 1) { 
                                                    ?>
                                                        <td style="display:none"></td>
                                                        <td style="display:none"></td>
                                                        <td style="display:none"></td>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    
                                                    <td>{{ $ticket->ticket_no }}</td>
                                                    <td>{{ $ticket->title }}</td>
                                                    <?php
                                                       if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    ?>  
                                                        <td>{{ $ticket->name }}</td>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    <td>{{ $ticket->ticketTypeName }}</td>
                                                    <td id="changeStatus_{{$ticket->id}}">  
                                                        @if($ticket->defaultStatus == 1)
                                                            <span class="label label-rounded label-{{$ticket->statusColour}} pull-left" style="margin-left:5px;{{$ticket->style}}">{{$ticket->ticketStatus}}</span>
                                                        @else
                                                            <span class="label label-rounded label-primary" style="color:#fff;font-size: 12px;">New</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <style type="text/css">
                                                            .ticket_header {
                                                                display: flex;
                                                                align-items: flex-start;
                                                                justify-content: space-between;
                                                                padding: 1rem;
                                                                border-bottom: 1px solid rgba(0,0,0,.1);
                                                                border-top-left-radius: 2px;
                                                                border-top-right-radius: 2px;
                                                            }
                                                            .ticket_body {
                                                                position: relative;
                                                                flex: 1 1 auto;
                                                                padding: 1rem;
                                                                padding: 15px 15px;
                                                            }
                                                        </style>
                                                        <div id="myModal_{{$ticket->id}}" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="max-width: 350px;">
                                                                <div class="modal-content">
                                                                    <div class="ticket_header">
                                                                        <h4 class="modal-title" id="myModalLabel">{{$ticket->ticket_no}} - Ticket Detail</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 25px">×</button>
                                                                    </div>
                                                                    <div class="ticket_body">
                                                                        <div class="container-fluid">
                                                                            <div class="row" >
                                                                                <div class="col-md-12">
                                                                                    <div class="tooltip2" style="border:none;">
                                                                                        <button class="btn btn-primary btn-rounded" style="color: #fff;padding:2px 8px;"><i class="icon-notebook"></i>&nbsp;{{$ticket->projectName}}</button>
                                                                                        <span class="tooltiptext">Project Name</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @if($ticket->priority != 0 && $ticket->severity != 0)
                                                                                <div class="row" style="margin-top:2px;">
                                                                                    @if($ticket->priority != 0)
                                                                                        <div class="col-md-4">
                                                                                            <div class="tooltip2" style="border:none;">
                                                                                                @if($ticket->priority == 1)
                                                                                                    <button class="btn btn-danger btn-rounded"  style="color: #fff;padding:2px 8px;"> <i class="icon-equalizer"></i>&nbsp;High</button>
                                                                                                @endif
                                                                                                @if($ticket->priority == 2)
                                                                                                    <button class="btn btn-warning btn-rounded"  style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Low</button>
                                                                                                @endif    
                                                                                                @if($ticket->priority == 3)
                                                                                                    <button class="btn btn-info btn-rounded"  style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Medium</button>
                                                                                                @endif
                                                                                                <span class="tooltiptext">Priority</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    @if($ticket->severity != 0)
                                                                                        <div class="col-md-3">
                                                                                            <div class="tooltip2" style="border:none;">
                                                                                                @if($ticket->severity == 1)
                                                                                                    <button class="btn btn-danger btn-rounded tooltip2"   style="color: #fff;padding:2px 8px;"><i class="icon-arrow-up-circle"></i>&nbsp;Critical</button>
                                                                                                @endif
                                                                                                @if($ticket->severity == 2)
                                                                                                    <button class="btn btn-success btn-rounded"   style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-arrow-down-circle"></i>&nbsp;Normal</button>
                                                                                                @endif
                                                                                                <span class="tooltiptext">Severity</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                            @if($ticket->adminTicketType != "")
                                                                                <div class="row" style="margin-top:2px;">
                                                                                    <div class="col-md-12" >
                                                                                        <div class="tooltip2" style="border:none;">
                                                                                            <button  class="btn btn-info btn-rounded"   style="color: #fff;padding:2px 8px;"><i class="icon-tag"></i>&nbsp;{{$ticket->adminTicketType}}</button>
                                                                                            <span class="tooltiptext">Admin Ticket Type</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            @if($ticket->compittionDate != "")
                                                                                <div class="row" style="margin-top:2px;" >
                                                                                    <div class="col-md-12">
                                                                                        <div class="tooltip2" style="border:none;">
                                                                                            <button class="btn waves-effect waves-light btn-rounded btn-dark"   style="color: #fff;padding:2px 8px;"><i class="icon-calender fa-fw"></i>&nbsp;{{$ticket->compittionDate}}</button>
                                                                                            <span class="tooltiptext">Task Compittion Date</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a class="btn waves-effect waves-light btn-rounded btn-primary" href="#" role="button" alt="default" data-toggle="modal" data-target="#myModal_{{$ticket->id}}" style="padding: 0px 7px;font-size: 13px;color:white">More Detail</a>
                                                    </td>
                                                    <?php                                 
                                                    if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                                    ?>
                                                        <td>{{ $ticket->userAssingName }}</td>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    <td>{{$ticket->createDate}}</td>
                                                    <td>
                                                        <div class="tooltip7" style="border:none;">
                                                            <a href="{{ route('aticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" class="btn btn-xs btn-info" style="padding: 0px 7px;"><i class="ti-pencil-alt"></i></a>
                                                            <span class="tooltiptext">View/Process</span>
                                                        </div>
                                                        <?php                                 
                                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id == 1) { 
                                                        ?>
                                                            @if($ticket->ticketStatus=='New')
                                                                @if($ticket->createTicketRole==1)
                                                                    <div class="tooltip7" style="border:none;">
                                                                        <a href="#" class="btn btn-xs btn-danger" onclick="deleteTicketData({{$ticket->id}})" style="padding: 0px 7px;"><i class="ti-trash"></i></a>
                                                                        <span class="tooltiptext">Delete</span>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        <?php 
                                                            } 
                                                        ?>
                                                        <!--<a href="#"  ng-if='ticket.createTicketRole==1' ng-if='ticket.ticketStatus=="New"' ng-click="deleteTicketData(ticket.id)" class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i></a> -->
                                                        @if($ticket->attachmentTicketCount !=0)
                                                            <div class="tooltip9" style="border:none;">
                                                                <a href="#" class="btn btn-xs btn-warning" style="padding: 0px 7px;"><i class="mdi mdi-paperclip"></i></a>
                                                                <span class="tooltiptext">Attachment</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                                
                                    <!--<tr ng-repeat="ticket in ticketData">
                                            <?php 
                                                /*  <tr @if($ticket->status == 'No') 
                                                        style="background-color:#ff851b !important"
                                                    @endif
                                                >*/
                                            ?> 
                                            
                                            <td>@{{ ticket.ticket_no }}</td>
                                            <td>@{{ ticket.title }}</td>
                                            <?php                                 
                                            if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                            ?>  
                                                <td>@{{ ticket.name }}</td>
                                            <?php 
                                            } 
                                            ?>
                                            <td>@{{ ticket.ticketTypeName }}</td>
                                            <td> 
                                                <span ng-if='ticket.defaultStatus=="1"' class="label label-rounded label-@{{ticket.statusColour}} pull-left" style="margin-left:5px;@{{ticket.style}}">@{{ticket.ticketStatus}}</span>
                                                <span class="label label-rounded label-primary" ng-if='ticket.defaultStatus=="0"' style="color:#fff;font-size: 12px;">New</span>
                                            </td>
                                            <td>
                                                <style type="text/css">
                                                    .ticket_header {
                                                        display: flex;
                                                        align-items: flex-start;
                                                        justify-content: space-between;
                                                        padding: 1rem;
                                                        border-bottom: 1px solid rgba(0,0,0,.1);
                                                        border-top-left-radius: 2px;
                                                        border-top-right-radius: 2px;
                                                    }
                                                    .ticket_body {
                                                        position: relative;
                                                        flex: 1 1 auto;
                                                        padding: 1rem;
                                                        padding: 15px 15px;
                                                    }
                                                </style>
                                                <div id="myModal_@{{ticket.id}}" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" style="max-width: 350px;">
                                                        <div class="modal-content">
                                                        <div class="ticket_header">
                                                            <h4 class="modal-title" id="myModalLabel">@{{ticket.ticket_no}} - Ticket Detail</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" 
                                                            style="font-size: 25px">×</button>
                                                        </div>
                                                        <div class="ticket_body">
                                                            <div class="container-fluid">
                                                            <div class="row" >
                                                                <div class="col-md-12">
                                                                    <div class="tooltip2" style="border:none;">
                                                                        <button class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="right" title="" data-original-title="Project Name" style="color: #fff;padding:2px 8px;"><i class="icon-notebook"></i>&nbsp;@{{ticket.projectName}}</button>
                                                                        <span class="tooltiptext">Project Name</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top:2px;">
                                                                <div class="col-md-4">
                                                                    <div class="tooltip2" ng-if='ticket.priority!=0' style="border:none;">
                                                                        <button class="btn btn-danger btn-rounded" ng-if='ticket.priority==1'  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"> <i class="icon-equalizer"></i>&nbsp;High</button>
                                                                       
                                                                        <button class="btn btn-warning btn-rounded" ng-if='ticket.priority==2'  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Low</button>
                                                                        
                                                                        <button class="btn btn-info btn-rounded" 
                                                                        ng-if='ticket.priority==3'  data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority" style="color: #fff;padding:2px 8px;"><i class="icon-equalizer"></i>&nbsp;Medium</button>
                                                                        <span class="tooltiptext">Priority</span>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-3">
                                                                    <div class="tooltip2" ng-if='ticket.severity!=0' style="border:none;">
                                                                        <button class="btn btn-danger btn-rounded tooltip2" 
                                                                        ng-if='ticket.severity==1'  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;padding:2px 8px;"><i class="icon-arrow-up-circle"></i>&nbsp;Critical</button>
                                                                        
                                                                        <button class="btn btn-success btn-rounded" ng-if='ticket.severity==2'  data-toggle="tooltip" data-placement="right" title="" data-original-title="Severity" style="color: #fff;margin-top:2px;padding:2px 8px;"><i class="icon-arrow-down-circle"></i>&nbsp;Normal</button>
                                                                        <span class="tooltiptext">Severity</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top:2px;">
                                                                <div class="col-md-12" >
                                                                    <div class="tooltip2" style="border:none;">
                                                                        <button  class="btn btn-info btn-rounded" 
                                                                        ng-if='ticket.adminTicketType!=""' data-toggle="tooltip" data-placement="right" title="" data-original-title="Admin Ticket Type"  style="color: #fff;padding:2px 8px;"><i class="icon-tag"></i>&nbsp;@{{ticket.adminTicketType}}</button>
                                                                        <span class="tooltiptext">Admin Ticket Type</span>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="row" style="margin-top:2px;" >
                                                                <div class="col-md-12">
                                                                    <div class="tooltip2" style="border:none;">
                                                                        <button class="btn waves-effect waves-light btn-rounded btn-dark" ng-if='ticket.compittionDate!=""' data-toggle="tooltip" data-placement="right" title="" data-original-title="Compittion Date"  style="color: #fff;padding:2px 8px;"><i class="icon-calender fa-fw"></i>&nbsp;@{{ticket.compittionDate}}</button>
                                                                        <span class="tooltiptext">Task Compittion Date</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </div>
                                                </div>
                                                <a class="btn waves-effect waves-light btn-rounded btn-primary" href="#" role="button" alt="default" data-toggle="modal" 
                                                    data-target="#myModal_@{{ticket.id}}" style="padding: 0px 7px;font-size: 13px">Ticket Detail
                                                </a>
                                            </td>
                                            <?php                                 
                                                if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 3) { 
                                            ?>
                                            
                                            <td>@{{ ticket.userAssingName }}</td>
    
                                            <?php } ?>
                                            
                                            <td>@{{ticket.createDate}}</td>
                                            
                                            <!--<div class="tooltip1" style="border:none;">
                                                <span class="label label-rounded label-secondary" data-toggle="tooltip"           
                                                style="font-size: 12px;color: #fff;background-color: #6c757d;border-color: #6c757d;">Date
                                                </span>
                                                <span class="tooltiptext">@{{ticket.createDate}}</span>
                                            </div>-->
                                            <!--<td>
                                                <a href="#" ng-click="showTicketData(ticket.id)" class="btn btn-xs btn-info" style="padding: 0px 7px;" >
                                                    <i class="ti-pencil"></i> 
                                                </a>
                                                <?php 
                                                /* <a href="#"  ng-if='ticket.createTicketRole==1' ng-if='ticket.ticketStatus=="New"'
                                                ng-click="deleteTicketData(ticket.id)" 
                                                class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i>
                                                </a> */
                                                ?>
                                                <a href="#" ng-if="ticket.attachmentTicketCount!=0" class="btn btn-xs btn-warning" style="padding: 0px 7px;" >
                                                    <i class="mdi mdi-paperclip"></i>  
                                                </a>
                                            </td>
                                        </tr>!-->
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
        function deleteTicketData(id) {
            var result = confirm("Are you Want to delete?"); 
            if (result == true) {     
                $.ajax({
                    url:"{{ route('angularticket.delete') }}",
                    type :'get',
                    data : {  
                        id: id,
                    },
                    success:function(data) {
                        /*toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );*/
                        $('#removeId_'+id).remove();
                        window.location.reload();
                    }
                });
            }
        }
    
        function checkIn() {
            $("#checkinId").attr("disabled", true);
            $("#checkinId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Check In');
            window.location.href="{{ route('checkin') }}";  
        }

        function checkOut() {
            $("#checkoutId").attr("disabled", true);
            $("#checkoutId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Check Out');
            window.location.href="{{ route('checkout') }}";   
        }
        
        function active(active) {
            if (active == 1) {
                window.location.href = "activeTicketcard/"+btoa(active)+"";
            }
        }
        
        function fixed(active) {
            if (active == 3) {
                window.location.href = "fixedTicketcard/"+btoa(active)+"";
            }
        }
        
        function disputed(active) {
            if (active == 4) {
                window.location.href = "disputedTicketcard/"+btoa(active)+"";
            }
        }
        
        function complete(active) {
            if (active == 5) {
                window.location.href = "completeTicketcard/"+btoa(active)+"";
            }
        }
        
        
    </script>

    @include('admin.common.script2')
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>
    <script type="text/javascript">
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            $scope.fetchTicketData = function() {
                $http.get("{{route('angularticket.view')}}").success(function(data) {
                    $scope.ticketData = data;
                });     
            };
            $scope.showTicketData = function(id) {
                var Id = btoa(id);
                window.location.href = "aticket/viewbyid/"+Id+"";
            };
        });
        
        function refreshLeaveRequest(calenderDay=null) {
            var quantity =  $('#reason_'+calenderDay).val(''); 
            $('#emptyReason_'+calenderDay).hide();
        }
        
        function deleteLeaveRequest(leaveReqId=null,leaveDate=null,calenderDay=null) {
            var retVal = confirm("Are you Want to delete?");
            if( retVal == true ) {
                $("#submit_"+calenderDay).attr("disabled", true);
                $('#delete_button_'+calenderDay).css('pointer-events', 'none');
                $("#tablepoint").css('pointer-events', 'none'); 
                $('#loading_'+calenderDay).show();
                $('#text_'+calenderDay).show();  
                $('body').css('opacity', '0.6');
                $("body").css('pointer-events', 'none');  
                $('#leave_type_'+calenderDay).attr("disabled", true); 
                $('#reason_'+calenderDay).attr("disabled", true);  
                $('#clear_button_'+calenderDay).attr("disabled", true);
                $('#closeFormLeave_'+calenderDay).attr("disabled", true);
                
                $.ajax({
                    type: "GET",
                    url: '{{route("removeLeaveRequest")}}',
                    data : {  
                        leaveReqId:leaveReqId,
                        leaveDate:leaveDate
                    },
                    success: function(data) {
                        //document.location.reload();
                        window.location.href = "{{route('leaverequest')}}";
                    }
                });
            }
        }
        
        function selectedHoverColor(day=null) {
            $("#hover_"+day).css("background-color", "#D7F2FF");
        }
    
        function closeLeave(calenderDay = null,day=null,currentDay = null) {
            if (day == currentDay) {
                $("#hover_"+day).css("background-color", "#0283cc");
            } else {
                $("#hover_"+day).css("background-color", "#fff");
            }
            $('#responsive-modal_'+calenderDay).hide();
        }
        
        function submitLeaveRequest(calenderDay=null,leaveDate=null) {
            var reason =  $('#reason_'+calenderDay).val(); 
            var leaveType =  $('#leave_type_'+calenderDay).val();
            var leaveReqId =  $('#levelReqId_'+calenderDay).val();
            if (leaveReqId != 0) {
                if (reason != "")  {
                    $("#submit_"+calenderDay).attr("disabled", true);
                    $('#delete_button_'+calenderDay).css('pointer-events', 'none');
                    $("#tablepoint").css('pointer-events', 'none'); 
                    $('#loading_'+calenderDay).show();
                    $('#text_'+calenderDay).html('<div class="col-md-4"></div><div class="col-md-4"><h6 class="box-title" style="font-size: 14px;color: black;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit Request...</h6></div>');  
                    $('#text_'+calenderDay).show();
                    $('body').css('opacity', '0.6');
                    $("body").css('pointer-events', 'none');  
                    $('#leave_type_'+calenderDay).attr("disabled", true); 
                    $('#reason_'+calenderDay).attr("disabled", true);  
                    $('#clear_button_'+calenderDay).attr("disabled", true);
                    $('#closeFormLeave_'+calenderDay).attr("disabled", true);
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
                            //document.location.reload();
                            window.location.href = "{{route('leaverequest')}}";
                        }
                    }); 
                }   else {
                    $('#emptyReason_'+calenderDay).show();
                    $('#emptyReason_'+calenderDay).html('Reason field is required.');
                }

            } else {
                
                if (reason != "")  {
                    $("#submit_"+calenderDay).attr("disabled", true);
                    $("#tablepoint").css('pointer-events', 'none'); 
                    $('#loading_'+calenderDay).show();
                    $('#text_'+calenderDay).html('<div class="col-md-4"></div><div class="col-md-4"><h6 class="box-title" style="font-size: 14px;color: black;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit Request...</h6></div>');  
                    $('#text_'+calenderDay).show();  
                    $('body').css('opacity', '0.6');
                    $("body").css('pointer-events', 'none');  
                    $('#leave_type_'+calenderDay).attr("disabled", true); 
                    $('#reason_'+calenderDay).attr("disabled", true);  
                    $('#clear_button_'+calenderDay).attr("disabled", true);
                    $('#closeFormLeave_'+calenderDay).attr("disabled", true);
                    $.ajax({
                        type: "GET",
                        url: '{{route("addLeaveRequest")}}',
                        data : {  
                            reason: reason,
                            leaveType: leaveType,
                            leaveDate:leaveDate
                        },
                        success: function(data) {
                            //document.location.reload();
                            window.location.href = "{{route('leaverequest')}}";
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

        function Go(type = null,month = null,year = null,loader=null) {

            // 2 - prev , 3 - next , 1 - currentMonth //
            $("#tablepoint").css('pointer-events', 'none');
            $('#loading_'+loader).show();
            $('#text_'+loader).show();
            $('#loading_'+loader).html("<div class='col-md-3'></div><div class='col-md-2'></div><div class='col-md-5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo URL::asset('public/image/lorder.gif') ?>' style='height: 50px;width: 50px;' /></div>");
            //$('#text_'+loader).html("<div class='col-md-2'></div><div class='col-md-3'></div><div class='col-md-5'>Please Wait....</div>");
            $('body').css('opacity', '0.6');
            $("body").css('pointer-events', 'none');  
            $("#homeId").css('pointer-events', 'none');  
            $('#calenderMain').attr("disabled", true);
            
            if (type == 2) {
                $('#text_'+loader).html("<div class='col-md-2'></div><div class='col-md-3'></div><div class='col-md-5'>Previous Month...</div>");
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $("#tablepoint").css('pointer-events', '');
                        $('body').css('opacity', '');
                        $("body").css('pointer-events', '');  
                        $('#loading_'+loader).hide();
                        $('#text_'+loader).hide();
                        $('#getCalenderId').html(data);
                        $('#calenderMain').attr("disabled", false);
                        $("#homeId").css('pointer-events', '');  
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }

            if (type == 3) {
                $('#text_'+loader).html("<div class='col-md-2'></div><div class='col-md-3'></div><div class='col-md-5'>&nbsp;Next Month...</div>");
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $("#tablepoint").css('pointer-events', '');
                        $('body').css('opacity', '');
                        $("body").css('pointer-events', '');  
                        $('#loading_'+loader).hide();
                        $('#text_'+loader).hide();
                        $('#getCalenderId').html(data);
                        $('#calenderMain').attr("disabled", false);
                        $("#homeId").css('pointer-events', '');  
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }
            
            if (type == 1) {
                $('#text_'+loader).html("<div class='col-md-2'></div><div class='col-md-3'></div><div class='col-md-5'>Current Month...</div>");
                $.ajax({
                    type: "GET",
                    url: '{{route("calender")}}',
                    data : {  
                        type: type,
                        month: month,
                        year:year
                    },
                    success: function(data) {
                        $("#tablepoint").css('pointer-events', '');
                        $('body').css('opacity', '');
                        $("body").css('pointer-events', '');  
                        $('#loading_'+loader).hide();
                        $('#text_'+loader).hide();
                        $('#getCalenderId').html(data);
                        $('#calenderMain').attr("disabled", false);
                        $("#homeId").css('pointer-events', '');  
                        $('[data-toggle="tooltip_'+type+'"]').tooltip();
                    }
                });
            }
        }
    </script>    
    </body>
</html>
