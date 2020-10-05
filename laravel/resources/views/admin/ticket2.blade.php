@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <div class="row">
                                <div class="col-md-8">Manage Ticket</div>
                                <div class="col-md-4 row">
                                    <div class="col-md-8">
                                    </div> 
                                    <div class="col-md-4">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-success pull-right" href="{{route('addticket')}}">
                                            Add Ticket
                                        </a>
                                    </div>    
                                </div>
                            </div>
                        </h4>
                        <div class="table-responsive" >
                            <table id="default_order" class="table table-striped table-bordered display" style="width:100%">
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>No.</th>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getTicketData))
                                        @foreach ($getTicketData as $ticket)
                                            <tr @if($ticket->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif>
                                                <td>{{$ticket->ticket_no}}</td>
                                                <td>
                                                    <?php
                                                        if (!empty($ticket->project_id)) { 
                                                            $getProjectByIdData = DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N" AND id ='.$ticket->project_id.'');
                                                            if (!empty($getProjectByIdData[0]->name)) {
                                                                $name = $getProjectByIdData[0]->name;
                                                                echo $name;
                                                            }

                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if (!empty($ticket->ticket_type_id)) { 
                                                            $getTicketTypeData = DB::select('SELECT * FROM `ticket_type_master` WHERE is_deleted_status = "N" AND id ='.$ticket->ticket_type_id.'');
                                                            if (!empty($getTicketTypeData[0]->name)) {
                                                                $name = $getTicketTypeData[0]->name;
                                                                echo $name;
                                                            }

                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $ticket->title;?></td>
                                                <td>
                                                    <?php
                                                        $ticketStatus = '';
                                                        $statusColour = '';
                                                        $style = '';
                                                        $getTicketStatusById =  DB::select('SELECT * FROM `ticket_status`  WHERE  is_deleted_status = "N" AND  ticket_id = '.$ticket->id.'  ORDER BY id DESC LIMIT 1'); 
                                                        $ticketStatusId =  !empty($getTicketStatusById[0]->ticket_status_id) ? $getTicketStatusById[0]->ticket_status_id : 0;
                                                        if (!empty($ticketStatusId)) { 
                                                            $getTicketStatusData = 
                                                            DB::select('SELECT * FROM `ticket_status_master` WHERE is_deleted_status = "N" AND status ='.$ticketStatusId.'');
                                                            $ticketStatus = !empty($getTicketStatusData[0]->ticket_status) ? $getTicketStatusData[0]->ticket_status : '';
                                                            $statusColour = !empty($getTicketStatusData[0]->status_colour) ? $getTicketStatusData[0]->status_colour : '';
                                                            $status = !empty($getTicketStatusData[0]->status) ? $getTicketStatusData[0]->status : '';
                                                            if ($status == 4) {
                                                                $style = 'background:#2b2b2b;';
                                                            }
                                                            echo '<span class="label label-rounded label-'.$statusColour.' pull-left" style="margin-left:5px;'.$style.'">'.$ticketStatus.'</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $ticket->created_at; ?></td>
                                                <td>
                                                    <?php 
                                                        if (!empty($ticket->ticket_status_id)) { 

                                                            $ticketStatusId = $ticket->ticket_status_id;
                                                            $getTicketStatusData = DB::select('SELECT * FROM `ticket_status_master` 
                                                            WHERE is_deleted_status = "N" AND status ='.$ticketStatusId.'');
                                                            $statusAction = $getTicketStatusData[0]->status;
                                                            if ($statusAction == 1) { 
                                                    ?>

                                                                <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                                                    style="padding: 0px 7px;" >
                                                                    <i class="ti-pencil"></i> 
                                                                </a>
                                                                <a href="{{ route('ticket.delete',['ticketId' =>  base64_encode($ticket->id)]) }}"  class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')" 
                                                                    style="padding: 0px 7px;">
                                                                    <i class="ti-trash"></i> 
                                                                </a>
                                                        <?php 
                                                            } else {
                                                        ?>  
                                                                <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" style="padding: 0px 7px;" >
                                                                    <i class="ti-pencil"></i> 
                                                                </a>
                                                            <?php 
                                                            }
                                                        }
                                                    ?>
                                                    <?php 
                                                        $getAttachmentData = DB::select('SELECT count(*) as attachmentTicketCount  FROM `attachment` 
                                                            WHERE is_deleted_status = "N" AND ticket_id ='.$ticket->id.'');
                                                        if (!empty($getAttachmentData[0]->attachmentTicketCount)) {
                                                            echo '<a href=""  class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attachment" style="padding: 0px 7px;" ><i class="mdi mdi-paperclip"></i> </a>';
                                                            
                                                        }
                                                            
                                                    ?>
                                                    
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
        </div>
    </div>
</div>
</div>
<div class="chat-windows"></div>
@include('admin.common.script2')
<script>
    @if (!empty($successMsg))
        toastr.success(
            '{{$successMsg}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif
</script>
    </body>
</html>
