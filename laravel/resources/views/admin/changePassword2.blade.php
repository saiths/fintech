@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">  
                        <form class="form" autocomplete="off" method="post">
                            <input type="hidden" name="processId"  ng-model="processFormData.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-6 col-form-label"> <b>Process Name :</b> </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control col-md-12" placeholder="Process Name" 
                                                    name="name" id="name"  ng-model="processFormData.name">
                                                <span class="text-danger" id="emptyName"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-0 col-form-label"></label>
                                            
                                            <div class="col-md-8">
                                                <button type="button" ng-if="!isInsert" 
                                                    ng-click="updateProccesData(processFormData)" id="lorderId" class="btn btn-primary mr-2">Update
                                                </button>
                                                
                                                <button type="button" ng-if="isInsert" id="lorderId"  
                                                    ng-click="addProcessData(processFormData)" class="btn btn-primary mr-2">Save
                                                </button>

                                                <button type="button" ng-click="resetProcessForm()" id="cancelId" 
                                                    class="btn btn-dark">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12">
                            <div class="card-body" ng-init="fetchProcessData()">
                                <table class="table table-bordered table-hover table-checkable" 
                                    datatable="ng" dt-options="vm.dtOptions">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Process Name</th>
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
    
<script type="text/javascript">
    function resetChangePwdForm() {
        window.location.href="{{ route('changepassword') }}";
    }
</script>

<script type="text/javascript">

    /*@if (!empty($successMsg))
        toastr.success(
            '{{$successMsg}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif 
    */
    
    @if(\Session::has('message'))
        toastr.success(
            '{{session()->get('message')}}', 'Success',
            { 
                "closeButton": true,
                timeOut: 3000 
            }
        );
    @endif

    $(function() {
        $("#register-form").validate({
            rules: {
                currentpassword: {
                    required: true,
                },
                confirmpassword: {
                    required: true,
                },
                newpassword: {
                    required: true,
                },
            },
            
            // Specify the validation error messages
            messages: {
                currentpassword: "<span class='text-danger'>Current Password field is required.</span>",
                confirmpassword: "<span class='text-danger'>Confirm Password field is required.</span>",
                newpassword: "<span class='text-danger'>New Password field is required.</span>",
            },
            
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>
