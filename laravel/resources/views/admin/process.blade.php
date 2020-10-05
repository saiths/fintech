@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                @if(!empty($getProcessDataByID))
                    @foreach ($getProcessDataByID as $getProcessData)
                    @endforeach
                @endif
                
                
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">  
                    
                    @if(!empty($getProcessData->id))
                    
                        <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                        enctype="multipart/form-data" autocomplete="off" action="{{route('process.edit')}}">
                            
                    @else
                    
                    <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                        enctype="multipart/form-data" autocomplete="off" action="{{route('process.add')}}">
                    
                    @endif
                    
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        @if(!empty($getProcessData->id))
                            <input type="hidden" name="processId" id="processId"  value="{{$getProcessData->id}}">
                        @endif
                        
                        
                        <!--<input type="hidden" name="processId"  ng-model="processFormData.id">-->
                        
                        <div class="card-body">
                                <style type="text/css">
                                    .abc 
                                    {
                                        font-size: 12px;
                                    }
                                    .table tr td {
                                        height: 5px;
                                    }
                                    
                                    .table-striped tbody tr:nth-of-type(odd) {
                                        background-color : #EBEDF3;
                                    }
                                </style>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-2 col-form-label"><b class="abc">Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control col-md-12 abc" placeholder="Name" 
                                        name="name" id="name" 
                                    value="{{ !empty($getProcessData->name) ? $getProcessData->name : '' }}" >
                                                
                                                @if (!empty($nameText))
                                                    <span class="text-danger" id="emptyName">{{ $nameText }}</span>
                                                @else
                                                    <span class="text-danger" id="emptyName">{{ $errors->first('name') }}</span>
                                                @endif
                                                
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                @if(!empty($getProcessData->id))
                                                                
                                                    <!--<button type="button" ng-if="!isInsert" 
                                                        ng-click="updateProccesData(processFormData)" id="lorderId" 
                                                        class="btn btn-primary mr-2">Update
                                                    </button>
                                                    -->
                                                    
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Update</button>
                                                    
                                                @else
                                                
                                                    <!--<button type="button" ng-if="isInsert" id="lorderId"  
                                                        ng-click="addProcessData(processFormData)" 
                                                        class="btn btn-primary mr-2">Save
                                                    </button>
                                                    -->
                                                    
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Save</button>
                                                    
                                                    
                                                @endif
                                                
                                                <button type="button" onclick="resetProcessForm()" id="cancelId" 
                                                    class="btn btn-dark">Cancel
                                                </button>
                                                
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                    <div class="col-lg-12">
                        <div class="card-body">
                            <table class="table table-striped table-bordered display" id="default_order_process">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $getProcessData = DB::table('process_master')
                                        ->select('*')
                                        ->where('is_deleted_status', 'N')
                                        ->orderBy('name', 'ASC')
                                        ->get()
                                        ->toArray();
    
                                        if (!empty($getProcessData)) {
                                            $j = 1;
                                            foreach ($getProcessData as $key => $processData) {
                                    ?>
                                                
                                                <tr style="background-color: white">    
                                                    <td>{{$j}}</td>
                                                    <td>{{$processData->name}}</td>
                                                    <td>
                                                        
        <a href="{{ route('process.viewbyid',['processId' => base64_encode($processData->id)]) }}"> 
            <i class="text-dark-10 flaticon2-edit"></i>
        </a>
        
            <!--<a href="#"  onclick="deleteProcessData({{base64_encode($processData->id)}})" >
                <i class="text-dark-10 flaticon2-trash"></i>
            </a>
            -->
                                                        
        <a onclick="return confirm('Are you sure want to delete?')" 
            href="{{ route('process.deletes',['processId' => base64_encode($processData->id)]) }}">
            <i class="text-dark-10 flaticon2-trash"></i>
        </a>
                                                        
                                                    </td>
                                                </tr>
                                    <?php 
                                        $j++;
                                        }
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>        
                    </div>
                        
                    <!--<div class="col-lg-12">
                            <div class="card-body" ng-init="fetchProcessData()">
                                <table class="table table-bordered table-hover table-checkable" 
                                    datatable="ng" dt-options="vm.dtOptions" >
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="process in processData">
                                            <td>@{{ $index + 1 }}</td>
                                            <td>@{{ process.name }}</td>
                                            <td>
                                                <a href="#" ng-click="showProcessData(process)"> 
                                                    <i class="text-dark-10 flaticon2-edit"></i>
                                                </a>
                                                <a href="#"  ng-click="deleteProcessData(process.id)" >
                                                    <i class="text-dark-10 flaticon2-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    -->    
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

@include('admin.common.footer')

</div>
</div>
</div>

@include('admin.common.script')

<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   

<script type="text/javascript">
    
    $(function () {
       $('#default_order_process').DataTable();
    });
    
    
  /*  $("#addTicket").click(function (e) {
        e.preventDefault();
        var _token = $('#_token').val();
        var name = $('#name').val();
        var processId = $('#processId').val();

        if (name == '') {

            if (name == '') {
                $('#name').css('border-color', 'red');
                $('#emptyName').show();
                $('#emptyName').html('Name field is Required.');
            } else {
                $('#emptyName').hide();
            }
            return false;
        
            
        } else {
            
            $("#addTicket").attr("disabled", true);
            $("#cancelId").attr("disabled", true);
            $("#addTicket").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
            
            var data = new FormData();
            data.append("_token", _token);
            data.append("name", name);
            data.append("processId", processId);
            
            if (processId == undefined) {
                
                $.ajax({
                    url: "{{ route('process.add') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        
                        if (data.nameText == 'nameText') {
                                
                            
                            if (data.nameText == 'nameText') {
                                
                                $('#name').css('border-color', 'red');
                                $('#emptyName').show();
                                $('#emptyName').html('The Name has already been taken.');
                                
                            } else {
                                
                                $("#lorderId").attr("disabled", false);
                                $("#cancelId").attr("disabled", false);
                                $("#lorderId").html('Save');
                                $('#emptyName').hide();
                            }
                       
                        } else {
                            
                            window.location.href = "{{route('process') }}";
                        }
                    }
                });
                
            } else {
                
                $.ajax({
                    url: "{{ route('process.edit') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        window.location.href = "{{route('process') }}";
                    }
                });
            }
        }
        
    }); */
        
    
    function deleteProcessData(id) {
        
        if (confirm("Are you Want to delete?") == true) {
            
            $.ajax({
                url:"{{ route('process.delete') }}",
                method: "get",
                data: { 'id': id } ,
                success:function(data) {
                    if (data == 1) {
                        
                        //$('#getUserByDateId_'+id).hide();
                        
                        setTimeout(function() {
                            toastr.success(
                                'User has been deleted.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        
                    } else {
                        
                       // $('#getUserByDateId').html(data);

                    }
                }
            });
        } 
    }
    
    
    <?php /*
    var app = angular.module("myApp", ['datatables']);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.processFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchProcessData = function() {
            $http.get("{{route('process.view')}}").success(function(data) {
                $scope.processData = data;
            });     
        };

        $scope.showProcessData = function(data) {
            var name = $('#name').val(data.name);
            $('#emptyName').hide(); 
            $scope.isInsert = false;
            $scope.processFormData = angular.copy(data);
        };

        $scope.updateProccesData = function(data) {

            var name = $('#name').val();
                
            if (name == '') {

                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                  //  $('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                }
                return false;


            } else {
            

             //   $('#name').css('border-color', '#E4E6EF');

                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');

                $http.post("{{route('process.edit')}}",data).success(function(data) {
                    
                    if (data.nameText == 'nameText') {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Update');
                        
                        if (data.nameText == 'nameText') {
                            $('#name').css('border-color', 'red');
                            $('#emptyName').show();
                            $('#emptyName').html('The Name has already been taken.');
                        } else {
                        //    $('#name').css('border-color', '#E4E6EF');
                            $('#emptyName').hide();
                        }
                   
                    } else {

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        $scope.isInsert = true;

                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        
                        
                        $scope.userFormData = {};
                        $scope.fetchProcessData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetProcessForm();
                        
                    }
                    
                }); 
            }
        };


        $scope.addProcessData = function(data) {
            
            var name = $('#name').val();
            
            if (name == '') {
                
                if (name == '') {
                    $('#name').css('border-color', 'red');
                    $('#emptyName').show();
                    $('#emptyName').html('Name field is Required.');
                } else {
                 //   $('#name').css('border-color', '#E4E6EF');
                    $('#emptyName').hide();
                }

            } else {
                
             //   $('#name').css('border-color', '#E4E6EF');
                $('#emptyName').hide();
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
               
                $http.post("{{route('process.add')}}",data).success(function(data) {
                    
                    $("#lorderId").attr("disabled", false);
                    $("#cancelId").attr("disabled", false);
                    $("#lorderId").html('Save');
                    
                    if (data.nameText == 'nameText') {

                        if (data.nameText == 'nameText') {
                            $('#emptyName').show();
                            $('#name').css('border-color', 'red');
                            $('#emptyName').html('The Name has already been taken.');
                        } else {
                          //  $('#name').css('border-color', '#E4E6EF');
                            $('#emptyName').hide();
                        }

                    } else {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        
                        $scope.processFormData = {};
                        $scope.fetchProcessData();
                        setTimeout(function() {
                            toastr.success(
                                data.message, 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        $scope.resetProcessForm();
                        $scope.isInsert = true;
                    }

                }); 
            }
        }

        
        $scope.deleteProcessData = function(id) {

            if (confirm("Are you Want to delete?") == true) {
                $http({
                method: "POST",
                url:    "{{route('process.delete')}}",
                data: {'id': id} 
                }).success(function(data) {
                    $scope.fetchProcessData();
                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                    $scope.resetProcessForm();
                });
            } 
        };


        $scope.resetProcessForm = function() {
            $scope.isInsert = true;
            $('#emptyName').hide();
          //  $('#name').css('border-color', '#E4E6EF');
            var name = $('#name').val('');
        };


    });
    
    */
    
    ?>
    
    
    function resetProcessForm() {
        
        window.location.href = "{{route('process') }}";        

    }
    
    
    /*
    function showProcessData(id) {
        window.location.href = "process/viewbyid/"+id
    }*/
    
    
    
    
    

</script>


</body>
</html>

