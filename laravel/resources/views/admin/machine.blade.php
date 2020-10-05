@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(!empty($getMachineDataByID))
                        @foreach ($getMachineDataByID as $getMachineData)
                        @endforeach
                    @endif
                    


                    <div class="card card-custom gutter-b example example-compact">  

                        @if(!empty($getMachineData->id))
                    
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('machine.edit')}}">
                            
                        @else
                        
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('machine.add')}}">
                        
                        @endif

                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        @if(!empty($getMachineData->id))
                            <input type="hidden" name="machineId" id="machineId"  
                            value="{{$getMachineData->id}}">
                        @endif
                            
                            <div class="card-body">
                                <style type="text/css">
                                    .abc 
                                    {
                                        font-size: 12px;
                                    }
                                    .table tr td 
                                    {
                                        height: 5px;
                                    }

                                </style>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-2 col-form-label"><b class="abc">Name :</b> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control col-md-12 abc" placeholder="Name" 
                    name="name" id="name" value="{{ !empty($getMachineData->name) ? $getMachineData->name : '' }}" >

                                                @if (!empty($nameText))
                                                    <span class="text-danger" id="emptyName">{{ $nameText }}</span>
                                                @else
                                                    <span class="text-danger" id="emptyName">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abc">Is Active :</b> </label>

                                            <div class="col-md-8">
                                                <div class="checkbox-inline" style="margin-top:10px;">
                                                    <label class="checkbox checkbox-success">
                                                    <input type="checkbox" name="is_status" value="Y" 
                                                    
                                                   <?php 
                                                    
                                                    if (!empty($getMachineData->is_status)) {

                                                        if ($getMachineData->is_status == 'Y') { 
                                                            echo 'checked="checked"'; 
                                                        } else {

                                                            
                                                        }

                                                    } else {

                                                        echo 'checked="checked"';

                                                         
                                                    
                                                    } 
                                                    ?>
                                                    
                                                        
                                                    >

                                                    <span></span>Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

        
                                    <div class="col-md-4">
                                        <div class="form-group row">

                                            <div class="col-md-10">
                                                @if(!empty($getMachineData->id))
                                                        
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Update</button>
                                                    
                                                @else
                                                
                                                    <button type="submit" id="addTickets" 
                                                    class="btn btn-primary mr-2">Save</button>
                                                    
                                                    
                                                @endif
                                                
                                                <button type="button" onclick="resetMachineForm()" id="cancelId" 
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
                            <table class="table table-bordered display" id="default_order_process_machine">
                                        
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Is Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        
                                            $getMachineData = DB::table('machine_master')
                                            ->select('*')
                                            ->where('is_deleted_status', 'N')
                                            ->orderBy('name', 'ASC')
                                            ->get()
                                            ->toArray();

                                            if (!empty($getMachineData)) {
                                                $j = 1;
                                                foreach ($getMachineData as $key => $machineData) {
                                        ?>
                                                    <tr>    
                                                        <td>{{$j}}</td>
                                                        <td>{{$machineData->name}}</td>
                                                        <td>
                                                            <?php 
                                                            if ($machineData->is_status == 'Y') {

                                                                echo 'Active'; 
                                                                
                                                            } else {
                                                                echo 'Deactive'; 
                                                                
                                                            }
                                                            ?>
                                                        </td>
                                                        
                                                        <td>
                                                            <a href="{{ route('machine.viewbyid',['machineId' => base64_encode($machineData->id)]) }}"> 
                                                                <i class="text-dark-10 flaticon2-edit"></i>
                                                            </a>
                                                                                                        
                                                            <a onclick="return confirm('Are you sure want to delete?')" 
                                                                href="{{ route('machine.deletes',['machineId' => base64_encode($machineData->id)]) }}">
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
       $('#default_order_process_machine').DataTable();
    });

    function resetMachineForm() {
        
        window.location.href = "{{route('machine') }}";        

    }
    
</script>
</body>
</html>

