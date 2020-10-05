@include('admin.common.main')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Ticket</h3>
            <a class="btn btn-success pull-right" href="{{route('addticket')}}"><i class="icon-plus"></i> 
                Add Ticket
            </a>
            <div class="clearfix"></div>
            <hr>
            <div class="table-responsive" >
                <style type="text/css">
                    .table td{
                        padding: 0.1rem !important;
                        vertical-align: top;
                        border-top: 1px solid #dee2e6;
                    }
                </style>
                <table id="myTable"  class="table-bordered">
                    <thead>
                        <tr>
                           <!--  <th>Sr. No.</th> -->
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
                                <tr  
                                    @if($ticket->status == 'No') 
                                        style="background-color:#ff851b !important"
                                    @endif
                                    >
                                    <?php /*
                                            <!-- <td>&nbsp;&nbsp;{{$key+1}}</td> -->
                                        */
                                    ?>
                                    <td>{{$ticket->ticket_no}}</td>
                                    <td>
                                        <?php
                                            if (!empty($ticket->project_id)) { 
                                                $getProjectByIdData = DB::select('SELECT * FROM `project_master` WHERE is_deleted_status = "N" AND id ='.$ticket->project_id.'');
                                                if (!empty($getProjectByIdData[0]->name)) {
                                                    $name = $getProjectByIdData[0]->name;
                                                    echo '&nbsp;'.$name;
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
                                                    echo '&nbsp;'.$name;
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
                                                echo '<span class="label label-rounded label-'.$statusColour.' 
                                                pull-left" style="margin-left:5px;'.$style.'">'.$ticketStatus.'
                                                    </span>';
                                                
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

                                                    <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                                        style="padding: 0px 7px;" >
                                                        <i class="icon-pencil"></i> 
                                                    </a>
                                                    <a href="{{ route('ticket.delete',['ticketId' =>  base64_encode($ticket->id)]) }}"  class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')" 
                                                        style="padding: 0px 7px;">
                                                        <i class="icon-trash"></i> 
                                                    </a>
                                            <?php 
                                                } else {
                                            ?>  
                                                    <a href="{{ route('ticket.viewbyid',['ticketId' =>  base64_encode($ticket->id)]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" 
                                                        style="padding: 0px 7px;" >
                                                        <i class="icon-pencil"></i> 
                                                    </a>
                                                <?php 
                                                }
                                            }
                                        ?>
                                        <?php 
                                            $getAttachmentData = DB::select('SELECT count(*) as attachmentTicketCount  FROM `attachment` 
                                                WHERE is_deleted_status = "N" AND ticket_id ='.$ticket->id.'');
                                            if (!empty($getAttachmentData[0]->attachmentTicketCount)) {
                                                echo '<a href=""  class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attachment" style="padding: 0px 7px;" ><i class="icon-paper-clip"></i> </a>';
                                                
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

@include('admin.common.script')

<script>
    @if (!empty($successMsg))
        $.toast({
            heading: 'Success!',
            position: 'top-right',
            text: '{{$successMsg}}',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
    @endif
</script>
