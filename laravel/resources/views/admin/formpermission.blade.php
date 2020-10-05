@include('admin.common.main')

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Form Permission</h3>
            <div class="clearfix"></div>
            <style type="text/css">
                .rounds {
                    position: relative;
                }
                .rounds label {
                    background-color: #fff;
                    border: 1px solid #ccc;
                    border-radius: 5%;
                    cursor: pointer;
                    height: 21px;
                    left: 0;
                    position: absolute;
                    top: 0;
                    width: 20px;
                }
                .rounds label:after {
                    border: 2px solid #fff;
                    border-top: none;
                    border-right: none;
                    content: "";
                    height: 5px;
                    left: 5px;
                    opacity: 0;
                    position: absolute;
                    top: 6px;
                    transform: rotate(-45deg);
                    width: 11px;
                }
                .rounds input[type="checkbox"] {
                    visibility: hidden;
                }
                .rounds input[type="checkbox"]:checked + label {
                    background-color: #00bbd9;
                    border-color: #00bbd9;
                }
                .rounds input[type="checkbox"]:checked + label:after {
                    opacity: 1;
                }
            </style>            
            <div class="row">
                <div class="col-md-6" >
                    <div class="rounds">
                        <input type="checkbox"  id="formId" value="check all" class="pull-left" >
                        <label for="formId" style=" border-radius: 18%;margin-left: 235px;margin-top: 15px;"></label>
                    </div>
                    <h3 class="text-center">User List</h3>
                    <div class="well" style="max-height: 300px;overflow: auto;">
                        <ul id="check-list-box" class="list-group checked-list-box" >
                            <?php 
                                $getRoleData  = DB::select('SELECT * FROM `role_master` WHERE is_deleted_status = "N" AND id != 1');
                                foreach ($getRoleData as $role) {
                            ?>
                                    
                                    <li class="list-group-item" style="padding: 6px 4px 4px 5px">
                                        <div class="rounds">
                                            &nbsp;&nbsp;<input type="checkbox" 
                                            onclick="selectAll('<?php echo $role->id; ?>')" id="formId_<?php echo 
                                            $role->id; ?>" class="pull-left_<?php echo $role->id; ?>"  value="<?php echo 
                                            $role->id; ?>">
                                            <label for="formId_<?php echo $role->id; ?>" style=" border-radius: 50%;"></label>&nbsp;
                                            <b><?php echo $role->role_name;?> List</b>
                                        </div>
                                    </li>   

                                            <ul id="selectFormAll_<?php echo $role->id; ?>" >
                                <?php 
                                    $getUserData  = DB::select('SELECT * FROM `user_master` WHERE is_deleted_status = "N" 
                                        AND role_id = '.$role->id.'');
                                        if (!empty($getUserData)) {
                                            foreach ($getUserData as $user) {
                                ?>      
                                                <li class="list-group-item" 
                                                style="padding: 8px 1px 4px 8px;"  >
                                                    <div class="rounds">
                                                        <input type="checkbox"   id="formId_{{$user->id}}" class="pull-left_" name="formIdArr[]"  
                                                        value="">&nbsp;&nbsp;&nbsp; 
                                                        <label for="formId_{{$user->id}}"></label>
                                                        {{$user->username}} 
                                                    </div>
                                                </li>
                                        <?php      
                                        }
                                    } else {
                                ?>
                                            <li class="list-group-item" style="padding: 4px 0px 4px 2px">
                                                No data available in List
                                            </li>
                                    <?php
                                    }
                                    ?>
                                     </ul>
                                <?php 
                                }
                            ?>                              
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">

                    <h3 class="text-center"  >&nbsp;&nbsp;&nbsp;Form List<b class="text-danger">*</b></h3>
                    <div class="well" style="max-height: 300px;overflow: auto;" id="check_list_box_form" >
                        <ul id="check_list_box_form1" class="list-group checked-list-box" style="margin-top: -17px" >
                            &nbsp;&nbsp;
                            <li class="list-group-item" style="padding: 4px 0px 1px 3px">
                                <div class="rounds">
                                    <?php /*
                                    &nbsp;&nbsp;
                                    <input type="checkbox" onclick="selectAll(<?php //echo $formTypeData; ?>)" id="formIds_<?php// echo $formTypeData; ?>" 
                                    class="pull-left_<?php //echo $formTypeData; ?>"  value="<?php //echo $formTypeData; ?>">
                                    <label for="formIds_<?php //echo $formTypeData; ?>" style=" border-radius: 50%;"></label>&nbsp;
                                    */?>
                                </div>
                                
                            </li>
                            <ul id="selectFormAll_" >
                                <li class="list-group-item" style="padding: 3px 1px 4px 2px;"  >
                                    <div class="rounds"  >
                                        <input type="checkbox"   id="formIds_" class="pull-left_" name="formIdArr[]"  
                                        value="">&nbsp;&nbsp;&nbsp; 
                                        <label for="formIds_"></label>
                                    </div>
                                </li>
                            </ul>

                            <li class="list-group-item">No data available in List</li>
                        </ul>
                        <?php //    } ?>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

@include('admin.common.script')
<script>
    $("#formId").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    function selectAll(roleId) {
        if ($('#formId_'+roleId).is(':checked')) {
            var roleId =  $('#formId_'+roleId).val();
            $.ajax({
                url:"{{ route('permission.selectAllForm') }}",
                type :'GET',
                data : {  
                    roleIds : roleId,
                    checked : 1,
                },
                success:function(result){
                    $('#selectFormAll_'+roleId).html(result);
                }
            });
        } else {       
            $.ajax({
                url:"{{ route('permission.selectAllForm') }}",
                type :'GET',
                data : {  
                    roleIds: roleId,
                    checked : 0
                },
                success:function(result){
                   $('#selectFormAll_'+roleId).html(result);
                }
            });
        } 
    }

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

