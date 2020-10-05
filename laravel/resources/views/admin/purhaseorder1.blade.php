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
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group row">
                                            <a href="{{route('addPurchaseOrder')}}" class="btn btn-info font-weight-bolder">
                                                Add PO
                                            </a>
                                        </div>
                                    </div>                                    
                                </div>      
                                    
                                <div ng-init="fetchPurhaseData()">
                                    <table class="table table-bordered table-hover table-checkable" datatable="ng" 
                                    dt-options="vm.dtOptions">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>PO.No.</th>
                                                <th>PO. Date</th>
                                                <th>Party Name</th>
                                                <th>Item Name</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="purhase in purhaseData">
                                                <td>@{{ $index + 1 }}</td>
                                                <td>@{{ purhase.po_no }}</td>
                                                <td>@{{ purhase.po_date }}</td>
                                                <td>@{{ purhase.partyName }}</td>
                                                <td>@{{ purhase.itemNames }}</td>
                                                <td>@{{ purhase.qty }}</td>
                                                
                                                <td>
                                                    <a href="#" ng-click="showPurchaseData(purhase)"> 
                                                        <i class="text-dark-10 flaticon2-edit"></i>
                                                    </a>
                                                    <a href="#" ng-click="deletePurchaseData(purhase.id)" >
                                                        <i class="text-dark-10 flaticon2-trash"></i>
                                                    </a>
                                                    <a href="#" ng-click="pdfPurchaseData(purhase)">
                                                        <i class="text-dark-10 flaticon2-file-1"></i>
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
        
        $scope.purhaseFormData = {};
        $scope.isInsert = true;

        $scope.fetchPurhaseData = function() {
            $http.get("{{route('purchaseorder.view')}}").success(function(data) {
                $scope.purhaseData = data;
            });     
        };

        $scope.showPurchaseData = function(data) {
            var Id = btoa(data.id);
            window.location.href = "purchaseorder/viewbyid/"+Id
        };
        
        $scope.deletePurchaseData = function(id) {
            if (confirm("Are you Want to delete?") == true) {
                $http({
                    method : "POST",
                    url    : "{{route('purchaseorder.delete')}}",
                    data   : { 'id' : id } 
                    }).success(function(data) {
                    $scope.fetchPurhaseData();
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
        };

        $scope.pdfPurchaseData = function(data) {
            var Id = btoa(data.id);
            window.location.href = "purchaseorder/pdf/"+Id
        };
        
        
    });

</script>
</body>
</html>
