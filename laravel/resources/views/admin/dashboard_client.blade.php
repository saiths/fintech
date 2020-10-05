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
                                        <a class="btn btn-success pull-right" href="{{route('aaddticket')}}">Add Ticket</a>
                                    </div>    
                                </div>
                            </div> 
                        </h4>
                        <!--<div class="table-responsive" ng-init="fetchTicketData()">-->    
                        <div class="table-responsive m-t-40">    
                            <!--<table id="default_order" class="table table-striped table-bordered display" 
                            style="width:100%" datatable="ng" dt-options="vm.dtOptions">-->
                            <table id="default_order" class="table display table-bordered table-striped no-wrap" 
                                style="width:100%" >
                                    

                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Ticket No.</th>
                                        <th>Project Name</th>
                                        <th>Ticket Title</th>
                                        <th>Ticket Type</th>
                                        <th>Status</th>
                                        <th>Ticket Issue Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getTicketDatas))
                                        @foreach ($getTicketDatas as $ticket)  
                                            <tr id="removeId_{{$ticket->id}}">
                                                <td>{{ $ticket->ticket_no }}</td>
                                                <td>{{ $ticket->project_id }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ $ticket->ticket_type_id }}</td>
                                                <td><span class="label label-rounded label-{{$ticket->statusColour}} pull-left" style="margin-left:5px;{{$ticket->style}}">{{$ticket->ticket_status_id}}</span></td>
                                                <td>{{ $ticket->created_at }}</td>
                                                <td>
                                                    <div class="tooltip7" style="border:none;">
                                                        <a href="#" onclick="showTicketData({{$ticket->id}})" data-toggle="tooltip" class="btn btn-xs btn-info" style="padding: 0px 7px;"><i class="ti-pencil"></i></a>
                                                        <span class="tooltiptext">Edit</span>
                                                    </div>
                                                    @if($ticket->ticket_status_id == 'New')
                                                        <div class="tooltip7" style="border:none;">
                                                            <a href="#" data-toggle="tooltip" onclick="deleteTicketData({{$ticket->id}})" class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i></a>
                                                            <span class="tooltiptext">Delete</span>
                                                        </div>
                                                    @endif
                                                    @if($ticket->attachment != 0)
                                                        <div class="tooltip9" style="border:none;">
                                                            <a href="#" data-toggle="tooltip"  class="btn btn-xs btn-warning" style="padding: 0px 7px;" ><i class="mdi mdi-paperclip"></i></a>
                                                            <span class="tooltiptext">Attachment</span>
                                                        </div>
                                                    @endif   
                                                </td> 
                                            </tr>        
                                        @endforeach
                                    @endif

                                    <?php /*<tr ng-repeat="ticket in ticketData">
                                        <td>@{{ ticket.ticket_no }}</td>
                                        <td>@{{ ticket.project_id }}</td>
                                        <td>@{{ ticket.ticket_type_id }}</td>
                                        <td>@{{ ticket.title }}</td>
                                        <td><span class="label label-rounded label-@{{ticket.statusColour}} pull-left" style="margin-left:5px;@{{ticket.style}}">@{{ticket.ticket_status_id}}</span></td>
                                        <td>@{{ ticket.created_at }}</td>
                                        <td>
                                            <div class="tooltip7" style="border:none;">
                                                <a href="#" ng-click="showTicketData(ticket.id)" data-toggle="tooltip" class="btn btn-xs btn-info" style="padding: 0px 7px;"><i class="ti-pencil"></i></a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip7" style="border:none;">
                                                <a href="#" ng-if='ticket.ticket_status_id=="New"' data-toggle="tooltip" ng-click="deleteTicketData(ticket.id)" class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i></a>
                                                <span class="tooltiptext">Delete</span>
                                            </div>
                                            <div class="tooltip9" style="border:none;">
                                                <a href="#" ng-if='ticket.attachment!=0' data-toggle="tooltip"  class="btn btn-xs btn-warning" style="padding: 0px 7px;" ><i class="mdi mdi-paperclip"></i></a>
                                                <span class="tooltiptext">Attachment</span>
                                            </div>
                                        </td>
                                    </tr>*/?>
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
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>

<script>

    var app = angular.module("myApp", ['datatables']);
    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.fetchTicketData = function() {
            $http.get("{{route('angularticket.view')}}").success(function(data) {
                $scope.ticketData = data;
            });     
        };
        
        $scope.fetchUserData = function() {
            $http.get("{{route('angularUser.view')}}").success(function(data) {
                $scope.userData = data;
            });     
        };

       /* $scope.showTicketData = function(id) {
            var Id = btoa(id);
            window.location.href = "aticket/viewbyid/"+Id+"";
        };
*/
      /*  $scope.deleteTicketData = function(id) {
            if (confirm("Are you Want to delete?") == true) {
                $http({
                    url:    "{{route('angularticket.delete')}}",
                    method: "GET",
                    params: {id: id}   
                }).success(function(data) {
                    $scope.fetchTicketData();
                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                });
            }
            
        };*/

    });
    
    function showTicketData(id) {
        var Id = btoa(id);
        window.location.href = "aticket/viewbyid/"+Id+"";
    };
    
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

    @if(\Session::has('message'))
        toastr.success(
            '{{session()->get('message')}}', 'Success!',
            {   
                "closeButton": true,
                timeOut: 3000 ,
            }
        );
    @endif
    </script>
    </body>
</html>
