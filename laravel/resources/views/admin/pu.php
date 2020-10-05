@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <form class="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group row">
                                            <label class="control-label text-left col-md-4 col-form-label">
                                                <b> User/Party Type :</b> 
                                            </label>   
                                            <div class="col-md-8">
                                                <select class="form-control form-control" name="kt_select2_3_modal" 
                                                    id="kt_select2_3_modal_1"  onchange="getUserById()">
                                                    <option value="1"> Party </option>
                                                    <option value="2"> User </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group row">
                                            <a href="{{route('addUser')}}" class="btn btn-info font-weight-bolder">
                                                User/Party Add
                                            </a>
                                        </div>
                                    </div>                                    
                                </div>  

                                <div ng-init="fetchUserData()">
                                    <table class="table table-bordered table-hover table-checkable" 
                                        datatable="ng" dt-options="vm.dtOptions">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>UserName</th>
                                                <th>Mobile</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="getUserByDateId">
                                            <tr ng-repeat="user in userData">
                                                <td>@{{ $index + 1 }}</td>
                                                <td>@{{ user.name }}</td>
                                                <td>@{{ user.username }}</td>
                                                <td>@{{ user.mobile }}</td>
                                                <td>
                                                    <a href="#" ng-click="showUserData(user)"> 
                                                        <i class="text-dark-10 flaticon2-edit"></i>
                                                    </a>
                                                    <a href="#" ng-click="deleteUserData(user.id)" >
                                                        <i class="text-dark-10 flaticon2-trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
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

    var app = angular.module("myApp", ['datatables']);
    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.userFormData = {};
        $scope.isInsert = true;

        $scope.fetchUserData = function() {
            $http.get("{{route('user.view')}}").success(function(data) {
                $scope.userData = data;
            });     
        };

        $scope.showUserData = function(data) {
            var Id = btoa(data.id);
            window.location.href = "user/viewbyid/"+Id
            
            /*$('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();
            var name = $('#name').val(data.name);
            var name = $('#username').val(data.username);
            var email = $('#email').val(data.email);
            var mobile = $('#mobile').val(data.mobile);
            var password = $('#password').val(data.password);
            var password = $('#retype_password').val(data.password);
            $scope.userFormData = angular.copy(data);
            $scope.isInsert = false;
*/            
        };

        $scope.deleteUserData = function(id) {
            if (confirm("Are you Want to delete?") == true) {

            $http({
                method: "POST",
                url:    "{{route('user.delete')}}",
                data: {'id': id} 
                }).success(function(data) {
                    $scope.fetchUserData();
                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                    $scope.resetUserForm();
            });
        } 
    };

        $scope.resetUserForm = function() {
            $scope.isInsert = true;
            $('#emptyName').hide();
            $('#emptyUserName').hide();
            $('#emptyPassword').hide();
            $('#emptyMobile').hide();
            $('#emptyRetypePassword').hide();

            var name = $('#name').val('');
            var mobile = $('#mobile').val('');
            var username = $('#username').val('');
            var password = $('#password').val('');
            var password = $('#retype_password').val('');

        };
    });

    function getUserById()
    {   
        var userTypeId = $('#kt_select2_3_modal_1').val();
        $('#getUserByDateId').show();
        $('#getUserByDateId').html("<tr class='odd'><td  style='text-align: right' valign='top' colspan='5' class='dataTables_empty' ><img src='<?php echo URL::asset('public/image/lorder.gif') ?>' style='height: 50px;width: 50px;' /></td></tr>");
        $.ajax({
            type: "GET",
            url: '{{route("getUserByAjax")}}',
            data : {  
                userTypeId: userTypeId,
            },
            success: function(data) {
                $('#getUserByDateId').html(data);
            }
        });
    }



    function deleteUserData(id) {
        if (confirm("Are you Want to delete?") == true) {
            $http({
                method: "POST",
                url:    "{{route('user.delete')}}",
                data: {'id': id} 
                }).success(function(data) {
                setTimeout(function() {
                    toastr.success(
                        'User has been deleted.', 'Success!',
                        { 
                            "closeButton": true,
                            timeOut: 3000 
                        }
                    );
                }, 1000);
            
            });
        } 
    };

    function showUserData(id) {
        var Id = btoa(id);
        window.location.href = "user/viewbyid/"+Id
    }
    
</script>
</body>
</html>

