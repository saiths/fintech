@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    
                    @if(!empty($getItemDataByID))
                        @foreach ($getItemDataByID as $getItemData)
                        @endforeach
                    @endif
                    
                    <div class="card card-custom gutter-b example example-compact">
                        
                        @if(!empty($getItemData->id))
                        
                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('item.edit')}}">
                                
                        @else
                        
                        <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                            enctype="multipart/form-data" autocomplete="off" action="{{route('item.add')}}">
                        
                        @endif
                        
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                        @if(!empty($getItemData->id))
                            <input type="hidden" name="itemId" id="itemId"  value="{{$getItemData->id}}">
                            <input type="hidden" name="itemTypeId" id="itemTypeId"  value="{{$getItemData->item_type_id}}">
                            
                        @endif
                        
                            <div class="card-body">
                                <div class="form-group row">
                                    
                                <input type="hidden" name="itemCategoryFormId"  ng-model="itemFormData.id">
                                
                                <div class="card-body">
                                    <style type="text/css">
                                .abcs 
                                {
                                    font-size: 12px;
                                }
                                .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple
                                {
                                    border-color:red;
                                }
                                
                                .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--open .select2-selection--single 
                                {
                                    border-color:red;
                                }
                                
                                .select2-containers--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--open .select2-selection--single 
                                {
                                    border-color:#E4E6EF;
                                }
                                
                                
                                .select2-containers--default .select2-selection--single, .select2-container--default .select2-selection--multiple 
                                {
                                    border-color:#E4E6EF;

                                }
                                
                                .select2 
                                {
                                    width:243.703px; !important;
                                    
                                }
                              
                                    </style>
                                    
                                    <input type="hidden" ng-model="itemFormData.item_type_id" id="item_type_id" name="item_type_id">
                                                
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                            <label class="control-label text-right col-md-5 col-form-label"><b class="abcs"> 
                                    Item Type :</b> 
                                                </label>
                                                
                                                
                                                <div class="col-md-7">
                                                    <select class="form-control form-control" name="itemTypeId" 
                                                        id="kt_select2_3_modal_1"  
                                                        <?php 
                                                            if (!empty($getItemData->id)) {
                                                        
                                                            echo 'disabled=disabled';
                                                        ?>
                                                        
                                                        
                                                        <?php 
                                                        } 
                                                        ?>
                                                        >
                                                        <?php
                                            
                                        $getItemTypeData = DB::select('SELECT * FROM item_type_master WHERE 
                                                        is_deleted_status = "N"');
                                                            if (!empty($getItemTypeData)) {
                                                                
                                                                foreach ($getItemTypeData as $itemType) {  
                                                                        
                                                                        ?>   
                                                                            <option value="<?php echo $itemType->id; ?>"
                                                                <?php
                                                                if (!empty($getItemData->item_type_id)) {
                                                                    if ($itemType->id == $getItemData->item_type_id)
                                                                    {                                                                    
                                                                        echo 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                
                                                            >
                                                                <?php echo $itemType->name; ?>
                                                            </option>
                                                            
                                                        <?php    
                                                            }
                                                        }        
                                                        ?>
                                                    </select>
                                                    <span class="text-danger" 
                                                    id="emptyName">{{ $errors->first('itemTypeId') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7">
                                            <div class="form-group row" 
                                            <?php
                                            if (!empty($getItemData->item_category_id)) {
                                                
                                            } else {
                                                echo 'style="display: none;"';    
                                                
                                            } 
                                            ?>
                                            
                                            id="itemCategotyId">
                                                <label class="control-label text-left  col-md-4 col-form-label"><b class="abcs"> 
                                                    Item Category Name :</b> 
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control form-control" name="item_category_names" 
                                                        id="kt_select2_3_modal_2" style="width: 350px;">
                                                        
                                                    <option value="">Select Item Category Name</option>

                                                        <?php
                                                            $getItemTypeData =  
                                                                DB::select('SELECT * FROM item_category_master WHERE 
                                                                is_deleted_status = "N" ORDER BY name ASC');
                                                                if (!empty($getItemTypeData)) {
                                                                    foreach ($getItemTypeData as $itemType) { 
                                                                        
                                                                ?>
                                                                
                                                                <option value="<?php echo $itemType->id; ?>"
                                                                <?php
                                                                
                                                                if (!empty($getItemData->item_category_id)) {
                                                                    
                                                                    if ($itemType->id == $getItemData->item_category_id)
                                                                    {                                                                    
                                                                        echo 'selected="selected"';
                                                                    }
                                                                }
                                                                ?>
                                                                >
                                                                    <?php echo $itemType->name; ?>
                                                                </option>
                                                        
                                                            <?php   
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <span class="text-danger" id="emptyName"
                                                    style="margin-left: -2px;font-size: 11px" >{{ $errors->first('item_category_names') }}</span>
                                                    
                                                    <!--<span class="text-danger" id="itemCatIdMsg" 
                                                    style="margin-left: -2px;font-size: 11px"></span>
                                                    -->
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>
    
                                    <!-- <div class="row" id="itemCategotyId">
                                        <div class="col-md-8">
                                            <div class="form-group row">
                                                <label class="control-label text-right  col-md-4 col-form-label"><b> 
                                                    Select Item Category Name :</b> 
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control form-control" name="kt_select2_3_modal" 
                                                        id="kt_select2_3_modal_2">
                                                        <?php
                                                            $getItemTypeData =  
                                                                DB::select('SELECT * FROM item_category_master WHERE 
                                                                is_deleted_status = "N"');
                                                                if (!empty($getItemTypeData)) {
                                                                    foreach ($getItemTypeData as $itemType) {  
                                                                ?>
                                                                
                                                                <option value="<?php echo $itemType->id; ?>">
                                                                    <?php echo $itemType->name; ?>
                                                                </option>
                                                        
                                                            <?php   
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                     --> 
                                     
                                     
                                    <div class="row"  
                                        <?php
                                            if (!empty($getItemData->party_id)) {
                                        
                                            } else {
                                                echo 'style="display: none;"';    
                                        
                                            } 
                                            
                                        ?> id="itemPartyNameId">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group row has-feedback">
                                                <label class="control-label text-right col-md-5 col-form-label">
                                                    <b class="abcs">Party Name :</b> 
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" 
                                                    name="party_name" id="kt_select2_3_modal_1_item" style="width: 239%">

                                                    <option value=""> Select Party Name</option>
                                                    
                                                            
                                                    <?php

                                                     $getUserData = DB::select('SELECT * FROM user_master WHERE 
                                                     is_deleted_status = "N" 
                                                        AND user_type = 3 ORDER BY party_name ASC');
                                                        if (!empty($getUserData)) {
                                                            foreach ($getUserData as $user) {  
                                                        
                                                    ?>   
                                                     
                                                            
                                                        <option value="<?php echo $user->id; ?>"
                                                            <?php 
                                                            
                                                            if (!empty($getItemData->party_id)) {
                                                                
                                                                if ($getItemData->party_id == $user->id)  {
                                                                    echo  'selected="selected"';
                                                                }
                                                            }
                                                            
                                                            ?>><?php echo $user->party_name; ?></option>


                                                    <?php    
                                                        }
                                                    }        
                                                    ?>
                                                </select>
                                                    <span class="text-danger" id="emptyName"
                                                        style="margin-left: -2px;font-size: 9px" >
                                                        {{ $errors->first('party_name') }}
                                                    </span>
                                                    <!--    
                                                    <span class="text-danger" id="partyIdMsg" 
                                                        style="margin-left: -2px;font-size: 11px"></span>
                                                    -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right  col-md-5 col-form-label">
                                                    <b class="abcs">Item Name :</b> 
                                                </label>
                                                <div class="col-md-7">
                                                    <input type="text" id="name" name="name"  class="form-control abc" 
                                                        placeholder="Item Name" 
                                                        value="{{ !empty($getItemData->name) ? $getItemData->name : '' }}" 
                                                        style="width: 447%" /> 
                                                </div>
                                                
                                                <!--<span class="text-danger abc" id="emptyName" 
                                                style="margin-left: 149px;font-size: 11px"></span>
                                                -->
                                                
                                                @if (!empty($nameText))
                                                    <span class="text-danger" style="margin-left: 149px;font-size: 11px" 
                                                    id="emptyName">{{ $nameText }}</span>
                                                @else
                                                    <span class="text-danger" style="margin-left: 149px;font-size: 11px" 
                                                    id="emptyName">{{ $errors->first('name') }}</span>
                                                    
                                                @endif
                                                
                                                
                                                    
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right  col-md-5 col-form-label"><b class="abcs"> 
                                                    Unit :</b> 
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control form-control_3" name="kt_select2_3_modal_unit"
                                                        id="kt_select2_3_modal_3" >
                                                         <?php
                                                            $getUnitData =  DB::select('SELECT * FROM unit_master WHERE 
                                                            is_deleted_status = "N"');
                                                            if (!empty($getUnitData)) {
                                                                foreach ($getUnitData as $unit) {
                                                                    
                                                        ?>                                              
                                                                
                                                                <option value="<?php echo $unit->id; ?>"><?php echo $unit->unit; ?></option>
                                                            <?php    
                                                        
                                                                }
                                                            }        
                                                        ?>
                                                    </select>
                                                    <span class="text-danger" style="margin-left: 149px;font-size: 11px" 
                                                    id="emptyName">{{ $errors->first('kt_select2_3_modal_unit') }}</span>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right  col-md-3 col-form-label"><b class="abcs"> 
                                                        GST% :</b> 
                                                </label>
                                                <div class="col-md-7">
                                                    <input type="text" id="gst" name="gst" 
                                                        onkeypress="return fun_AllowOnlyAmountAndDot(this);" 
                                                        class="form-control abc" 
                                                        placeholder="GST%"   
                                                        value="{{ !empty($getItemData->gst) ? $getItemData->gst : '' }}"
                                                        />      
                                                    <!--<span class="text-danger abc" id="emptyGst" style="font-size: 11px"></span>
                                                    --><span class="text-danger" id="emptyName">{{ $errors->first('gst') }}</span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-md-10">
                                                    <button type="button" ng-if="!isInsert" 
                                                        ng-click="updateItemData(itemFormData)" id="lorderId" class="btn btn-primary mr-2">Update
                                                    </button>
                                                    
                                                    <button type="button" ng-if="isInsert" id="lorderId"  
                                                        ng-click="addItemData(itemFormData)" class="btn btn-primary mr-2">Save
                                                    </button>

                                                    <button type="button" ng-click="resetItemForm()" id="cancelId" class="btn btn-dark">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                    
                                    <hr id="itemAttIdssLine" 
                                    <?php 
                                    if (!empty($getItemData->id)) {
                                        if ($getItemData->item_type_id == 1) {
                                            echo 'style="display: none;"';
                                        }
                                    ?>
                                        
                                    
                                    <?php
                                        } else {
                                    ?>
                                        
                                        style="display: none;"
                                    
                                    <?php
                                        }
                                    ?>
                                    
                                    
                                    >
                                    
                                    <div class="my-custom-scrollbar"
                                    
                                        <?php 
                                        
                                        if (!empty($getItemData->item_type_id)) {
                                        
                                        ?>
                                            
                                            style="max-height: 335px;overflow-y: scroll;overflow-x: hidden;";
                                            
                                        <?php
                                        
                                        } else {
                                            
                                        ?>
                                            
                                        
                                           style="display: none; max-height: 335px;overflow-y: scroll;overflow-x: hidden;"; 
                                           
                                        <?php
                                        }
                                        ?>
                                        
                                        id="itemAttIdss">
                                    
                                        <div class="appendClass">
                                            
                                            <div class="row" 
                                            
                                                <?php 
                                                if (!empty($getItemData->item_type_id)) {
                                                    
                                                    if ($getItemData->item_type_id == 1) {
                                                        echo 'style="display: none;"';
                                                    }
                                                    
                                                    
                                                ?>
                                                
                                                <?php
                                                
                                                } else {
                                                        
                                                ?>
                                                
                                                    style="display: none;"
                                                    
                                                <?php
                                                }
                                                ?>
                                            >
                                                
                                        
                                        
                                            <?php
                                
                                $getItemDataId = !empty($getItemData->id) ? $getItemData->id : 0;
                                
                                
                                
                                $item_attribute_valueData = DB::select('SELECT * FROM item_attribute_value 
                                WHERE is_deleted_status = "N"  AND item_id = "'.$getItemDataId.'" ORDER BY id ASC');
                                
                                    if (!empty($item_attribute_valueData)) {
                                    foreach ($item_attribute_valueData as $item_attribute_value) {  
                                            
                                     
                                    
                                            
                                ?>   
                                                
                                         
                                        
                                        
                                            <div class="col-md-4" >
                                                <div class="form-group row">
                                                    <label class="control-label text-right  col-md-5 col-form-label">
                                                        <b class="abcs" style="font-size:9px;">Item Attribute Name :</b>
                                                    </label>

                                                    <div class="col-md-7">
                        <select class="form-control form-control_3 select2-containers" 
                                                name="process_idsss[]"
                                                
                    id="kt_select2_3_modal_3_itemss_{{$item_attribute_value->id}}" 
                                                            style="width: 160%" >
                                                             <?php
            
    $getProcessData =  DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N"');
                                                if (!empty($getProcessData)) {
                                                foreach ($getProcessData as $process) { 
                                                                        
                                                                        
                                                            ?>                                              
                                                                        
                                    <option value="<?php echo $process->id; ?>"
                                                                        
                                    <?php 
                                    
                                        if (!empty($item_attribute_value->attribute_item_id)) {
                                            if ($item_attribute_value->attribute_item_id == $process->id)  {
                                                echo  'selected="selected"';
                                            }
                                        }
                                        
                                    ?>><?php echo $process->name; ?></option>
                                    
                                                                <?php    
                                                            
                                                                    }
                                                                }        
                                                            ?>
                                                        </select>
                                                        
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-5">
                                                <div class="form-group row">
                                                    <label class="control-label text-right  col-md-4 col-form-label">
                                                        <b class="abcs" style="font-size:9px;">Value :</b>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input type="text" id="value" name="value[]" 
                                                        class="form-control abc" placeholder="Value"
                                        value="{{ !empty($item_attribute_value->value) ? $item_attribute_value->value : ''  }}"/>
                                                        <span class="text-danger abc" id="emptyGst" 
                                                        style="font-size: 11px"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <div class="form-group row">
                                                    <a  onclick="return confirm('Are you sure want to delete?')" 
                                                        
                    href="{{route('itemsssssss.value',['itemAttValId' => base64_encode($item_attribute_value->id) ])}}"  
                                                     
                                                        class="btn btn-sm btn-danger">
                                                        <i class="text-dark-10 flaticon2-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                       <?php     
                                        }
                                        }
                                            
                                            
                                            
                                            ?>
                                            
                                            <div class="col-md-4" 
                                                <?php 
                                                    if (!empty($getItemData->item_type_id)) {
                                                ?>
                                                <?php
                                                    } else {
                                                ?>
                                                    style="display:none"
                                                <?php
                                                }
                                                ?>>
                                                
                                                <div class="form-group row" id="abcID">
                                                    <label class="control-label text-right col-md-5 col-form-label">
                                                        <b class="abcs" style="font-size:9px;">Add Item Attributes :</b>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <button type="button" onclick="addItemAttDetail()" 
                                                        class="btn btn-primary">
                                                            <i class="ki ki-plus icon-sm"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                        
                                    <div class="row" id="itemAttIdssss"></div>
                                         
                                </div>
                                    
                                    
                                    
                                    
                                    <!--<hr id="itemAttIdssLine" style="display: none;">
                                    
                                    <div class="row" id="itemAttIdssss"></div>
                                    -->
                                    <?php /*
                                        <div class="row"  style="display: none;" id="itemAttIdss">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-5 col-form-label"> 
                                                <b class="abcs">Item Attribute : </b></label>
                                                <div class="col-md-7">
                                                    <select class="form-control select2 .select2-containers--default .select2-selection--single, .select2-container--default .select2-selection--multiple 
                                " id="kt_select2_3_modal_3_item" 
                                                        name="select2_itemCategory" multiple="multiple" style="width: 447%" >
                                                        <?php

                                                            $getItemAttData =  DB::select('SELECT * FROM 
                                                            item_attribute_master WHERE is_deleted_status = "N" ORDER BY name ASC');
                                                        
                                                            if (!empty($getItemAttData)) {
                                                                foreach ($getItemAttData as $itemAtt) {  
                                                    ?>  
                                                                    <option value="<?php echo $itemAtt->id; ?>">
                                                                        <?php echo $itemAtt->name; ?>
                                                                    </option>
                                                                    <?php    
                                                                }
                                                            }        
                                                        ?>
                                                    </select>
                                                    <span class="text-danger" id="emptyProcess"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */?>
                                    
                                    <div class="row" style="margin-left:40px;margin-top: 31px;">
                                        <div class="col-md-4" >
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3 
                                                col-form-label"> <b class="abc"> </b></label>
                                                
                                                <div class="col-md-9">
                                                    
                                                    @if(!empty($getItemData->id))
                                                                
                                                        <!--<button type="button" ng-if="!isInsert" 
                                                            ng-click="updateProccesData(processFormData)" id="lorderId" 
                                                            class="btn btn-primary mr-2">Update
                                                        </button>
                                                        -->
                                                    
                                                        <button type="submit" id="addTickets" class="btn btn-primary mr-2">Update</button>
                                                    
                                                    @else
                                                
                                                        <!--<button type="button" ng-if="isInsert" id="lorderId"  
                                                            ng-click="addProcessData(processFormData)" 
                                                            class="btn btn-primary mr-2">Save
                                                        </button>
                                                        -->
                                                    
                                                        <button type="submit" id="addTickets" class="btn btn-primary mr-2">Save</button>
                                                        
                                                    @endif
                                                
                                                    <button type="button" onclick="resetItemForm()" id="cancelId" 
                                                    class="btn btn-dark">Cancel</button>
                                                
                                                    <!--<button type="button" ng-if="!isInsert" 
                                                        ng-click="updateItemData(itemFormData)" id="lorderId" 
                                                        class="btn btn-primary">Update
                                                    </button>
                                                    
                                                    <button type="button" ng-if="isInsert" id="lorderId"  
                                                        ng-click="addItemData(itemFormData)" class="btn btn-primary">Save
                                                    </button>

                                                    <button type="button" ng-click="resetItemForm()" 
                                                    id="cancelId" class="btn btn-dark">
                                                        Cancel
                                                    </button>
                                                    -->
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        </form>
                            
                            <div class="card-body">
                            
                                <!--<div class="card-body" ng-init="fetchItemData()">
                                    
                                <table class="table table-bordered table-hover table-checkable" 
                                    datatable="ng" dt-options="vm.dtOptions">
                                -->
                                
                                <table class="table table-striped table-bordered display" id="default_order_process">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Type</th>
                                            <th>Party Name</th>
                                            <th>Item Category Name</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>GST%</th>
                                            <th>Action</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    
                                    <!--<tbody>
                                        <tr ng-repeat="item in itemData">
                                            <td>@{{ $index + 1 }}</td>
                                            <td>@{{ item.itemTypeName }}</td>
                                            <td>@{{ item.partyName }}</td>
                                            <td>@{{ item.itemCategoryName }}</td>
                                            <td>@{{ item.name }}</td>
                                            <td>@{{ item.itemUnitName }}</td>
                                            <td>@{{ item.gst }}</td>
                                            <td>
                                                <a href="#" ng-click="showItemData(item)"> 
                                                    <i class="text-dark-10 flaticon2-edit"></i>
                                                </a>
                                                <a href="#"  ng-click="deleteItemData(item.id)" >
                                                    <i class="text-dark-10 flaticon2-trash"></i>
                                                </a>
                                                
                                            </td>
                                            <td>
                                            <a href="#" ng-if="item.item_type_id == 2" ng-click="getCylinderDetail(item.id)"  
                                                class="btn-sm btn-success btn-shadow-hover font-weight-bolder" data-toggle="modal"  data-target="#exampleModalSizeLg_@{{item.id}}">Detail
                                            </a>
                                            
                                            <div class="modal fade" id="exampleModalSizeLg_@{{item.id}}" tabindex="-1" role="dialog" 
                                                aria-labelledby="staticBackdrop" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false"  >
                                                <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 54% !important;margin:1.75rem auto;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>


                                                            <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>


                                                        </div>
                                                        <div class="modal-body" style="overflow-y: hidden;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <span class="control-label"><strong>Item Name : </strong>
                                                                            @{{ item.name }}
                                                                        </span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <span class="control-label"><strong>Party Name : </strong>
                                                                            @{{ item.partyName }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <strong style="font-size: 16px;">Add Cylinder/Dye Details</strong>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr id="itemAttIdssLine" width="696px;">

                                                            <div  class="my-custom-scrollbar"  style="max-height: 250px;overflow-y: scroll;overflow-x: hidden;"     
                                                            id="4845">

                                                                <div class="appendClass_@{{item.id}}">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <span class="control-label"><strong>Detail Caption</strong></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <span class="control-label"><strong>Value</strong></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group row">
                                                                                <span class="control-label"><strong>Action</strong></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <a href="#"  
                                                                            ng-click="addCylinderDetail(item.id)" 
                                                        class="btn btn-primary"><i class="ki ki-plus icon-sm"></i> Add</a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="submit" 
                                                                    ng-click="insertCylinderDetail(item.id)" 
                                                                    class="btn btn-primary"> 
                                                                    Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    -->
                                    
                                    <tbody>
                                        <?php    
                                            $getItemData = [];
                                            $getItemData = DB::table('item_master')
                                              ->select('*')
                                              ->where('is_deleted_status', 'N')
                                              ->orderBy('name', 'ASC')
                                              ->get()
                                              ->toArray();
    
                                            if (!empty($getItemData)) {

                                                $i = 1;
                                                foreach ($getItemData as $key => $itemData) {
                                                    
                                            ?>

                                                
                                                    <tr style="background-color: white">    
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <?php
                                                                $itemTypeData = DB::table('item_type_master')
                                                                  ->select('*')
                                                                  ->where('is_deleted_status', 'N')
                                                                  ->where('id', $itemData->item_type_id)
                                                                  ->orderBy('name', 'ASC')
                                                                  ->get()
                                                                  ->toArray();
                                                                if (!empty($itemTypeData)) {
                                                                    foreach ($itemTypeData as  $itemType) {
                                                                       echo  $getItemData[$key]->itemTypeName = 
                                                                       !empty($itemType->name) ? $itemType->name : '';
                                                                    } 
                                                                }
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                                $partyUserData = DB::table('user_master')
                                                                  ->select('*')
                                                                  ->where('is_deleted_status', 'N')
                                                                  ->where('id', $itemData->party_id)
                                                                  ->where('user_type', 3)
                                                                  ->get()
                                                                  ->toArray();
    
                                                                if (!empty($partyUserData)) {
                                                                    foreach ($partyUserData as  $partyNameData) {
                                                                        echo $getItemData[$key]->partyName = 
                                                                        !empty($partyNameData->party_name) ? $partyNameData->party_name : '';
                                                                    } 
                                                                }
    
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php 
                                                            $itemCategoryData = DB::table('item_category_master')
                                                              ->select('*')
                                                              ->where('is_deleted_status', 'N')
                                                              ->where('id', $itemData->item_category_id)
                                                              ->orderBy('name', 'ASC')
                                                              ->get()
                                                              ->toArray();

                                                            if (!empty($itemCategoryData)) {
                                                                foreach ($itemCategoryData as  $itemCategory) {
                                                                    echo $getItemData[$key]->itemCategoryName = 
                                                                    !empty($itemCategory->name) ? $itemCategory->name : '';
                                                                } 
                                                            }
                                                            ?>
                                                        </td>
                                                    
                                                        <td>{{$itemData->name}}</td>

                                                        <td>
                                                            <?php 
                                                            $itemUnitData = DB::table('unit_master')
                                                              ->select('*')
                                                              ->where('is_deleted_status', 'N')
                                                              ->where('id', $itemData->unit_id)
                                                              ->get()
                                                              ->toArray();

                                                            if (!empty($itemUnitData)) {
                                                                foreach ($itemUnitData as  $unitType) {
                                                                    echo $getItemData[$key]->itemUnitName = 
                                                                    !empty($unitType->unit) ? $unitType->unit : '';
                                                                } 

                                                            }
                                                            ?>
                                                        </td>

                                                        <td>{{$itemData->gst}}</td>

                    <td>
                        
                        <a href="{{ route('item.viewbyid',['processId' => base64_encode($itemData->id)]) }}"> 
                            <i class="text-dark-10 flaticon2-edit"></i>
                        </a>
                        
                        <a onclick="return confirm('Are you sure want to delete?')" 
                            href="{{ route('item.deletes',['processId' => base64_encode($itemData->id)]) }}">
                            <i class="text-dark-10 flaticon2-trash"></i>
                        </a>
                                                        
                    <!--<a href="#" onclick="showItemData(<?php echo $itemData->id; ?>)"> 
                                        <i class="text-dark-10 flaticon2-edit"></i>
                                </a>

                    <a href="#"  onclick="deleteItemData(<?php echo $itemData->id; ?>)" >
                <i class="text-dark-10 flaticon2-trash"></i>
                        </a>
                        -->
            
            </td>
                                                    
                                                    <td>

                                                        @if ($itemData->item_type_id == 2)

                                                            <!--<a href="#" onclick="getCylinderDetail(<?php echo $itemData->id; ?>)"  
                                                                class="btn-sm btn-success btn-shadow-hover font-weight-bolder" 
                                                                data-toggle="modal"  
                                                                data-target="#exampleModalSizeLg_{{$itemData->id}}">Detail
                                                            </a>
                                                            -->
                                                            
                                        <a href="#"   class="btn-sm btn-success btn-shadow-hover font-weight-bolder" 
                                            data-toggle="modal"  data-target="#exampleModalSizeLg_{{$itemData->id}}">Detail
                                        </a>    
                                            
                                                             
    
                                                            <div class="modal fade" id="exampleModalSizeLg_{{$itemData->id}}" 
                                                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" 
                                                                data-toggle="modal" data-backdrop="static" data-keyboard="false"  >
                                                                <div class="modal-dialog modal-dialog-scrollable" role="document" 
                                                                    style="max-width: 54% !important;margin:1.75rem auto;">
                                                                    <div class="modal-content">
                                                                        
                                                                        
                        <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                                enctype="multipart/form-data" autocomplete="off" action="{{ route('itemDetails.adds') }}">
                                
    
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
                                                                            <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        
                                                                        <div class="modal-body" style="overflow-y: hidden;">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <span class="control-label"><strong>Item Name : </strong>
                                                                                            {{ $itemData->name }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <span class="control-label"><strong>Party Name : </strong>
                                                                                            <?php

                                                                                                $partyUserData = DB::table('user_master')
                                                                                                  ->select('*')
                                                                                                  ->where('is_deleted_status', 'N')
                                                                                                  ->where('id', $itemData->party_id)
                                                                                                  ->where('user_type', 3)
                                                                                                  ->get()
                                                                                                  ->toArray();

                                                                                                if (!empty($partyUserData)) {
                                                                                                    foreach ($partyUserData as  $partyNameData) {
                                                                                                        echo $getItemData[$key]->partyName = 
                                                                                 !empty($partyNameData->party_name) ? $partyNameData->party_name : '';
                                                                                                    } 
                                                                                                }
                                                                                            ?>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <strong style="font-size: 16px;">Add Cylinder/Dye Details</strong>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <hr id="itemAttIdssLine" width="696px;">

                                                                            <div  class="my-custom-scrollbar"  
                                                                                style="max-height: 250px;overflow-y: scroll;overflow-x: hidden;" id="4845">
                                                                                
                                                                <input type="hidden" name="item_id_s" id="item_id_s" value="{{$itemData->id}}">
                                
                                                                                <div class="appendClass_{{$itemData->id}}">
                                                                                    <div class="row">
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <span class="control-label"><strong>Detail Caption</strong></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <span class="control-label"><strong>Value</strong></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group row">
                                                                                                <span class="control-label"><strong>Action</strong></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
            <?php 
            
            $itemIdssss = !empty($itemData->id) ? $itemData->id : 0;
            
            $getcylinder_nameArr = DB::table('item_cylinder_detail')
              ->where('item_id', $itemIdssss)
              ->where('is_deleted_status', 'N')
              ->get();
            
            
            $htmls = '';
            
            if (!empty($getcylinder_nameArr)) {
                
                
                foreach ($getcylinder_nameArr as $key => $getcylinder_names) {

                      $getcylinderNames = !empty($getcylinder_names->cylinder_name) ?  $getcylinder_names->cylinder_name : '';
                      $getcylinderValues = !empty($getcylinder_names->value) ?  $getcylinder_names->value : '';
                         
                
        $htmls .=  '<div class="row" id="removeQty_'.$getcylinder_names->id.'">
                <div class="col-md-5"><div class="form-group">
                <span class="control-label"><input type="text" name="cylinder_named_'.$itemIdssss.'[]" 
                id="" value="'.$getcylinderNames.'"  class="form-control abc" placeholder="Detail Caption"></span>
                </div></div><div class="col-md-5"><div class="form-group row"><span class="control-label">
                <input type="text" 
                    name="value_'.$itemIdssss.'[]" id="values" class="form-control abc" placeholder="Value" 
                    value="'.$getcylinderValues.'" style="width: 235px" ></span></div></div><div class="col-md-2">
                    <div class="form-group row"><button type="button" 
                    onclick="deleteQtysCylinderss('.$getcylinder_names->id.')" class="btn btn-sm btn-danger">
                    <i class="text-dark-10 flaticon2-trash"></i></button></div></div></div>';
                
                    
                } 
               
                echo $htmls;
    
            }
            
            
            ?>
            
                                                                                    
                                                                                    

                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                    <a href="#" onclick="addCylinderDetail(<?php echo  $itemData->id; ?>)" 
                                                    class="btn btn-primary"><i class="ki ki-plus icon-sm"></i> Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>  

                                                                
                                                                <div class="modal-footer">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <button type="submit"  class="btn btn-primary">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                

                                                            </form>
                                                                
                                                                        
                                                                        <!--<div class="modal-footer">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <button type="submit" 
                                                                onclick="insertCylinderDetail(<?php echo $itemData->id;  ?>)" 
                                                                class="btn btn-primary"> 
                                                                                    Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        -->
                                                                            
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        @endif  

                                                    </td>

                                                </tr>    
                                                
                                                    <?php

                                                    $i++;

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
@include('admin.common.footer')
</div>
</div>
</div>

@include('admin.common.script')

<script type="text/javascript">
    
    
       <?php
       
           
                                
                                
                                $item_attribute_valueData = DB::select('SELECT * FROM item_attribute_value 
                                WHERE is_deleted_status = "N"  AND item_id = "'.$getItemDataId.'" ORDER BY id ASC');
                                
                                if (!empty($item_attribute_valueData)) {
                                    foreach ($item_attribute_valueData as $item_attribute_value) {
                                        
                                ?>
                                
                                $('#kt_select2_3_modal_3_itemss_<?php echo $item_attribute_value->id; ?>').select2({
                                    placeholder: "Item Attribute Name",
                                }); 
            
                                
                                <?php
                                
                                    }
                                        
                                }   
                                ?>
                                     
       
    
    $(function () {
       $('#default_order_process').DataTable();
    });
    
    
    $("#kt_select2_3_modal_1").on('change',function(){
        
        var getValue=$(this).val();
        
      $.ajax({
            url:"{{ route('getValues.itemCayselectds') }}",
            type :'get',
            data : {  
                itemTypeIds: getValue,
            },
            success:function(result) {

               // $('#kt_select2_3_modal_2').html(result);
            }
        }); 


        if (getValue == 2) {
            
            $('#itemCategotyId').show();
            $('#itemPartyNameId').show();
            $('#itemAttIdss').show();
            $('#itemAttIdssss').show();
            $('#itemAttIdssList').show();
            $('#itemAttIdssLine').show();
            $('.appendClass').hide();
            
            $('.appendClass').html('');
            
            
            $('#kt_select2_3_modal_3_item').select2({
                placeholder: "Select Item Attribute",
            });
            
            $('#kt_select2_3_modal_2').select2({
                placeholder: "Select Item Category Name",
	        });
            
            
         $("#itemAttIdssss").html('<div class="col-md-4"><div class="form-group row"><label class="control-label text-right col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Add Item Attributes :</b></label><div class="col-md-7"><button type="button" onclick="addItemAttDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button></div></div></div>');
        
            
        } else {
            
            $('#itemAttIdssss').hide();
            $('#itemCategotyId').hide();
            $('#itemPartyNameId').hide();
            $('#itemAttIdss').hide();
            $('#itemAttIdssLine').hide();
            $('#itemAttIdssList').hide();
        //    $('#itemAttIdssLine').show();
            
        
        }
    });



</script>


<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
    
<script type="text/javascript">

    var app = angular.module("myApp", ['datatables']);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.ItemFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchItemData = function() {
            $http.get("{{route('item.view')}}").success(function(data) {
                $scope.itemData = data;
            });     
        };

        $scope.showItemData = function(data) {

            //$('#name').css('border-color', '#E4E6EF');
           // $('#gst').css('border-color', '#E4E6EF');
            
            $( "#kt_select2_3_modal_1" ).prop( "disabled", true );
    
  //  $('.my-custom-scrollbar').css({'position' : 'relative', 'height' : '179px','overflow' : 'auto'});
            
            itemTypeSelect(data.item_type_id);

            
            
            if (data.item_type_id == 1) {
                
                
                $('#itemCategotyId').hide();
                $('#itemPartyNameId').hide();
                $('#itemAttIdss').hide();
                $('#itemAttIdssssss').hide();
                $('#itemAttIdssLine').hide();
                $('#itemAttIdssss').hide();
                
                
                
            } else {
                
                $('#itemCategotyId').show();
                $('#itemPartyNameId').show();
                $('#itemAttIdss').show();
                $('#itemAttIdssssss').show();
                $('#itemAttIdssLine').show();
                $('#itemAttIdssss').show();
                
            }

            
            $('#emptyName').hide(); 
            $('#emptyGst').hide();
            $('#partyIdMsg').hide();
            $('#itemCatIdMsg').hide();
            
    
            $('#kt_select2_3_modal_3_items_'+data.id).select2({
                placeholder: "Select Process(s)",
            }); 
            
        if (data.item_type_id == 2) {
            
            
            $http({
                method: "POST",
                url:    "{{route('getedititemAtt.roleSelected')}}",
                data: {
                    'item_id': data.id,
                }   
            }).success(function(data) {
                
                
                $('.appendClass').html(data);
                

              //  $('#itemAttIdss').html(data);
                
                $('#itemAttIdssLine').show();
                  

            
                //$("#itemAttIdssss").html('<div class="col-md-8"><div class="form-group row"><button type="button" id="itemAttIdssssss" onclick="addItemAttDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button></div></div>');


                //  $("#itemAttIdssss").html('<div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Add Item Attributes :</b></label><div class="col-md-7"><button type="button" onclick="addItemAttDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button></div></div></div>');

            });

        }


            $http({
                method: "POST",
                url:    "{{route('editpartyName.roleSelected')}}",
                data: {
                    'party_id': data.party_id,
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_1_item').html(data);
            });

            $http({
                method: "POST",
                url:    "{{route('edititemAtt.roleSelected')}}",
                data: {
                    'item_id': data.id,
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_3_item').html(data);
            });
            
            $http({
                method: "POST",
                url:    "{{route('angularItemSelect.roleSelected')}}",
                data: {
                    'unit_id': data.unit_id,
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_3').html(data);
            });

            $http({
                method: "POST",
                url:    "{{route('angularProcessItemCategorySelect.roleSelected')}}",
                data: {
                    'item_category_id': data.item_category_id,
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_2').html(data);
            });

            $scope.isInsert = false;
            $scope.itemFormData = angular.copy(data);

    
            var itemTypeId = $('#name').val(data.name);
            var itemTypeId = $('#gst').val(data.gst);



        
        };

        $scope.updateItemData = function(data) {
            
            var name = $('#name').val();
            var gst = $('#gst').val();
            var itemTypeId = $('#kt_select2_3_modal_1').val();

            var itemCategoryId = $('#kt_select2_3_modal_2').val();
            var unit = $('#kt_select2_3_modal_3').val();
            var partyId = $('#kt_select2_3_modal_1_item').val();
            var itemAttId = $('#kt_select2_3_modal_3_item').val();
            
            
            var process_idArr = $("option:selected").map(function(){ return this.value }).get().join(", ");

            var valueArr = $("input[name='value[]']")
              .map(function(){return $(this).val();}).get();
           
                
            
            if (itemTypeId == 2) {

                if (name == '' || gst == ''|| partyId == '' || itemCategoryId == '') {
                
                    if (name == '') {
                        $('#name').css('border-color', 'red');
                        $('#emptyName').show();
                        $('#emptyName').html('Item Name field is Required.');
                    } else {
                       // $('#name').css('border-color', '#E4E6EF');
                        $('#emptyName').hide();
                    }   
                    
                    if (gst == '') {
                        $('#gst').css('border-color', 'red');
                        $('#emptyGst').show();
                        $('#emptyGst').html('GST% field is Required.');
                    } else {
                       // $('#gst').css('border-color', '#E4E6EF');
                        $('#emptyGst').hide();
                        
                    }
                
                    
                    if (partyId == '') {
                        $('#partyIdMsg').show();
                        $('#partyIdMsg').html('Party Name field is Required.');
                    } else {
                        $('#partyIdMsg').hide();
                    }
                    
                    
                    if (itemCategoryId == '') {
                        $('#itemCatIdMsg').show();
                        $('#itemCatIdMsg').html('Item Category Name field is Required.');
                    } else {
                        $('#itemCatIdMsg').hide();
                    }
                
                } else {
                
                    data.itemTypeId = itemTypeId;
                    data.itemCategoryId = itemCategoryId;
                    data.unit_id = unit;
                    data.partyId = partyId;
                    data.itemAttId = itemAttId;
                    
                    data.process_idArr = process_idArr;
                    data.valueArr = valueArr;
                    
                
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
    
                    $http.post("{{route('item.edit')}}",data).success(function(data) {
                    
                        if (data.nameText == 'nameText') {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Update');
                            
                            if (data.nameText == 'nameText') {
                                $('#name').css('border-color', 'red');
                                $('#emptyName').show();
                                $('#emptyName').html('The Item Name has already been taken.');
                            } else {
                               // $('#name').css('border-color', '#E4E6EF');
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
                            $scope.fetchItemData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetItemForm();
                            
                        }
                        
                    }); 
                    
                }
            
                
                
            } else {
                
                if (name == '' || gst == '') {
                
                    if (name == '') {
                        $('#name').css('border-color', 'red');
                        $('#emptyName').show();
                        $('#emptyName').html('Item Name field is Required.');
                    } else {
                       // $('#name').css('border-color', '#E4E6EF');
                        $('#emptyName').hide();
                    }   
                    
                    if (gst == '') {
                        $('#gst').css('border-color', 'red');
                        $('#emptyGst').show();
                        $('#emptyGst').html('GST% field is Required.');
                    } else {
                       // $('#gst').css('border-color', '#E4E6EF');
                        $('#emptyGst').hide();
                        
                    }
                
                    
                
                } else {
                
                    data.itemTypeId = itemTypeId;
                    data.itemCategoryId = itemCategoryId;
                    data.unit_id = unit;
                    //data.partyId = partyId;
                   // data.itemAttId = itemAttId;
                    
                
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');
    
                    $http.post("{{route('item.edit')}}",data).success(function(data) {
                    
                        if (data.nameText == 'nameText') {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Update');
                            
                            if (data.nameText == 'nameText') {
                                $('#name').css('border-color', 'red');
                                $('#emptyName').show();
                                $('#emptyName').html('The Item Name has already been taken.');
                            } else {
                               // $('#name').css('border-color', '#E4E6EF');
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
                            $scope.fetchItemData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetItemForm();
                            
                        }
                        
                    }); 
                    
                }
        
            }
        };

        $scope.addItemData = function(data) {

            var name = $('#name').val();
            var gst = $('#gst').val();
            var itemTypeId = $('#kt_select2_3_modal_1').val();
            var itemCategoryId = $('#kt_select2_3_modal_2').val();
            var unit = $('#kt_select2_3_modal_3').val();
            var partyId = $('#kt_select2_3_modal_1_item').val();
            var itemAttId = $('#kt_select2_3_modal_3_item').val();
             var process_idArr =    $("option:selected").map(function(){ return this.value }).get().join(", ");

            var valueArr = $("input[name='value[]']")
              .map(function(){return $(this).val();}).get();
           
        
            if (itemTypeId == 2) {

                if (name == '' || gst == ''|| partyId == '' ||  itemCategoryId == '' ) {
                     
                    
                    if (name == '') {
                        $('#name').css('border-color', 'red');
                        $('#emptyName').show();
                        $('#emptyName').html('Item Name field is Required.');
                    } else {
                     //   $('#name').css('border-color', '#E4E6EF');
                        $('#emptyName').hide();
                    }   
                    
                    if (gst == '') {
                        $('#gst').css('border-color', 'red');
                        $('#emptyGst').show();
                        $('#emptyGst').html('GST% field is Required.');
                    } else {
                       // $('#gst').css('border-color', '#E4E6EF');
                        $('#emptyGst').hide();
                    }
                    
                    if (partyId == '') {
                        $('#partyIdMsg').show();
                        $('#partyIdMsg').html('Party Name field is Required.');
                    } else {
                        $('#partyIdMsg').hide();
                    }
                    
                    if (itemCategoryId == '') {
                        $('#itemCatIdMsg').show();
                        $('#itemCatIdMsg').html('Item Category Name field is Required.');
                    } else {
                        $('#itemCatIdMsg').hide();
                    }
                    
                    
                        
        
                } else {
                    
                    $('#emptyName').hide();
                    $('#emptyGst').hide();
                    $('#partyIdMsg').hide();
                    $('#itemCatIdMsg').hide();
                    
        
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    
                    data.itemTypeId = itemTypeId;
                    data.itemCategoryId = itemCategoryId;
                    data.unit_id = unit;
                    data.itemAttId = itemAttId;
                    data.partyId = partyId;
                    
                    data.process_idArr = process_idArr;
                    data.valueArr = valueArr;

                    
                                
                    $http.post("{{route('item.add')}}",data).success(function(data) {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        
                        if (data.nameText == 'nameText') {
        
                            if (data.nameText == 'nameText') {
                                $('#name').css('border-color', 'red');
                                $('#emptyName').show();
                                $('#emptyGst').hide();
                                $('#emptyName').html('The Item Name has already been taken.');
                          
                            } else {
                             //   $('#name').css('border-color', '#E4E6EF');
                                $('#emptyName').hide();
                                $('#emptyGst').hide();
                            
                            }
        
                        } else {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            $scope.ItemFormData = {};
                            $scope.fetchItemData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetItemForm();
                            $scope.isInsert = true;
                            selectd(itemTypeId,unit);
        
        
                        }
        
                    }); 
                }
                
            } else {
                
                if (name == '' || gst == '') {
                     
                    
                    if (name == '') {
                        $('#name').css('border-color', 'red');
                        $('#emptyName').show();
                        $('#emptyName').html('Item Name field is Required.');
                    } else {
                     //   $('#name').css('border-color', '#E4E6EF');
                        $('#emptyName').hide();
                    }   
                    
                    if (gst == '') {
                        $('#gst').css('border-color', 'red');
                        $('#emptyGst').show();
                        $('#emptyGst').html('GST% field is Required.');
                    } else {
                       // $('#gst').css('border-color', '#E4E6EF');
                        $('#emptyGst').hide();
                    }
                    
                    
                    
                    
                        
        
                } else {
                    
                    $('#emptyName').hide();
                    $('#emptyGst').hide();
        
                    $("#lorderId").attr("disabled", true);
                    $("#cancelId").attr("disabled", true);
                    $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');
                    
                    data.itemTypeId = itemTypeId;
                    data.itemCategoryId = itemCategoryId;
                    data.unit_id = unit;
                    
                  //  data.itemAttId = itemAttId;
                 //   data.partyId = partyId;
                    
                    
                                
                    $http.post("{{route('item.add')}}",data).success(function(data) {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Save');
                        
                        if (data.nameText == 'nameText') {
        
                            if (data.nameText == 'nameText') {
                                $('#name').css('border-color', 'red');
                                $('#emptyName').show();
                                $('#emptyGst').hide();
                                $('#emptyName').html('The Item Name has already been taken.');
                          
                            } else {
                             //   $('#name').css('border-color', '#E4E6EF');
                                $('#emptyName').hide();
                                $('#emptyGst').hide();
                            
                            }
        
                        } else {
                            
                            $("#lorderId").attr("disabled", false);
                            $("#cancelId").attr("disabled", false);
                            $("#lorderId").html('Save');
                            
                            $scope.ItemFormData = {};
                            $scope.fetchItemData();
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            $scope.resetItemForm();
                            $scope.isInsert = true;
                            selectd(itemTypeId,unit);
        
        
                        }
        
                    }); 
                }
                
                
            }
            
        }

        $scope.deleteItemData = function(id) {

            if (confirm("Are you Want to delete?") == true) {
                $http({
                method: "POST",
                url:    "{{route('item.delete')}}",
                data: {'id': id} 
                }).success(function(data) {
                    $scope.fetchItemData();
                    setTimeout(function() {
                        toastr.success(
                            data.message, 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                    }, 1000);
                    $scope.resetItemForm();
                });
            } 
        };
        
        $scope.getCylinderDetail = function(id) {
            
            $.ajax({
                url:"{{ route('insertCylinderDetail.dislapy') }}",
                type :'get',
                data : {  
                    itemId : id,
                },
                success:function(result) {
                    var caption = '<div class="row"><div class="col-md-5"><div class="form-group"><span class="control-label"><strong>Detail Caption</strong></span></div></div><div class="col-md-5"><div class="form-group"><span class="control-label"><strong>Value</strong></span></div></div><div class="col-md-2"><div class="form-group row"><span class="control-label"><strong>Action</strong></span></div></div></div>';
                    $('.appendClass_'+id).html(caption + result);
                }

            });
            
        };
        
        $scope.addCylinderDetail = function(id) {

            var randomQtyNO = Math.floor(Math.random() * 1000);
            var html = '<div class="row" id="removeQty_'+randomQtyNO+'"><div class="col-md-5"><div class="form-group"><span class="control-label"><input type="text" name="cylinder_named_'+id+'[]" id="" value=""  class="form-control abc firstInput" placeholder="Detail Caption"></span></div></div><div class="col-md-5"><div class="form-group row"><span class="control-label"><input type="text" name="value_'+id+'[]" id="" class="form-control abc" placeholder="Value" value="" style="width: 235px;"></span></div></div><div class="col-md-2"><div class="form-group row"><button type="button" onclick="deleteQtysCylinder('+randomQtyNO+')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div>';
            $('.appendClass_'+id).append(html);
            
        }
        
        $scope.insertCylinderDetail = function(id) {
            
            var cylinder_nameArr = $("input[name='cylinder_named_"+id+"[]']")
              .map(function(){return $(this).val();}).get();

            var valueArr = $("input[name='value_"+id+"[]']")
              .map(function(){return $(this).val();}).get();
            
            if (cylinder_nameArr == '' || valueArr == '') {
                
                setTimeout(function() {
                    toastr.error(
                        'Item Cylinder Detail has been Required.', 'Wrong!',
                        { 
                            "closeButton": true,
                            timeOut: 3000 
                        }
                    );
                }, 1000);
                
            } else {
                
                
                $.ajax({
                    url:"{{ route('insertCylinderDetail.valuessss') }}",
                    type :'get',
                    data : {  
                        cylinder_nameArr : cylinder_nameArr,
                        valueArr : valueArr,
                        itemId : id,
                    },
                    success:function(result) {
                        
                    }
                });
                
                window.location.href = '{{route("item")}}'; 
            }
        }
        
        $scope.resetItemForm = function() {
            
            $scope.isInsert = true;
            $('#emptyName').hide();
            $('#emptyGst').hide();
            $('#partyIdMsg').hide();
            $('#itemCatIdMsg').hide();
            $('#itemAttIdssLine').hide();
            
            $('#itemAttIdssssss').hide();
            $('#itemAttIdss').hide();
            
            $("#itemCategotyId").css("display", "none");
            $("#itemAttIdss").css("display", "none");
            $("#itemPartyNameId").css("display", "none");
            
            
         //   $('#name').css('border-color', '#E4E6EF');
         //   $('#gst').css('border-color', '#E4E6EF');
            var name = $('#name').val('');
            var name = $('#gst').val(''); 


            $http({
                method: "POST",
                url:    "{{route('partyName.roleSelected')}}",
                data: {
                    'unit_id': '',
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_1_item').html(data);
            });

            $http({
                method: "POST",
                url:    "{{route('itemAtt.roleSelected')}}",
                data: {
                    'unit_id': '',
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_3_item').html(data);
            });

            $http({
                method: "POST",
                url:    "{{route('itemTypess.roleSelected')}}",
                data: {
                    'unit_id': '',
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_1').html(data);
            });

            $http({
                method: "POST",
                url:    "{{route('units.roleSelected')}}",
                data: {
                    'item_category_id': '',
                }   
            }).success(function(data) {
                $('#kt_select2_3_modal_3').html(data);
            });
            
            $( "#kt_select2_3_modal_1" ).prop( "disabled", false );


        };
        
    });
    
    
    function itemTypeSelect(itemTypeId) {
        $.ajax({
            url:"{{ route('itemType.itemselectd') }}",
            type :'get',
            data : {  
                itemTypeIds: itemTypeId,
            },
            success:function(result) {
    
                $('#kt_select2_3_modal_1').html(result);
            }
        });

        return;
    }
    
    
    function getCylinderDetail(id) {
        
        $.ajax({
            url:"{{ route('insertCylinderDetail.dislapy') }}",
            type :'get',
            data : {  
                itemId : id,
            },
            success:function(result) {
                var caption = '<div class="row"><div class="col-md-5"><div class="form-group"><span class="control-label"><strong>Detail Caption</strong></span></div></div><div class="col-md-5"><div class="form-group"><span class="control-label"><strong>Value</strong></span></div></div><div class="col-md-2"><div class="form-group row"><span class="control-label"><strong>Action</strong></span></div></div></div>';
                $('.appendClass_'+id).html(caption + result);
            }
        });
    }
    
    function addCylinderDetail(id) {
        
        var randomQtyNO = Math.floor(Math.random() * 1000);
        var html = '<div class="row" id="removeQty_'+randomQtyNO+'"><div class="col-md-5"><div class="form-group"><span class="control-label"><input type="text" name="cylinder_named_'+id+'[]" id="" value=""  class="form-control abc firstInput" placeholder="Detail Caption"></span></div></div><div class="col-md-5"><div class="form-group row"><span class="control-label"><input type="text" name="value_'+id+'[]" id="" class="form-control abc" placeholder="Value" value="" style="width: 235px;"></span></div></div><div class="col-md-2"><div class="form-group row"><button type="button" onclick="deleteQtysCylinder('+randomQtyNO+')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div>';
        $('.appendClass_'+id).append(html);
    }
    
    

</script>


<script type="text/javascript">

    
    

    function addItemAttDetail() {

        $('.appendClass').show();
            
            var randomQtyNO = Math.floor(Math.random() * 1000);
            var processName =  <?php 
                $getProcessData =  DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N"');
        
        ?>
                
                processName += '<option value="">Select Attribute</option>';
                    
                            
                <?php
                    if (!empty($getProcessData)) {


                    foreach ($getProcessData as $process) {  
                        
            ?> 
            
                        processName += '<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>';
                        
            
            <?php    
                    }
                }        
            ?>;
    
                
            $("#abcID").hide();
          
            //$("#itemAttIdssss").html('')
            var html = '<div class="row" id="removeQty_'+randomQtyNO+'"><div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Item Attribute Name :</b></label><div class="col-md-7"><select class="form-control form-control" style="width: 160%" name="process_idsss[]" id="kt_select2_3_modal_3_items_'+randomQtyNO+'" >'+processName+'</select></div></div></div><div class="col-md-5"><div class="form-group row"><label class="control-label text-right  col-md-4 col-form-label"><b class="abcs" style="font-size:9px;">Value :</b></label><div class="col-md-7"><input type="hidden" id="value" value="'+randomQtyNO+'"  name="randomQtyNO[]" class="form-control abc" placeholder="Value" /><input type="text" id="value" name="value[]" class="form-control abc" placeholder="Value" /><span class="text-danger abc" id="emptyGst" style="font-size: 11px"></span></div></div></div><div class="col-md-1"><div class="form-group row"><button type="button" onclick="deleteQty('+randomQtyNO+')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div></div></div><div class="row"></div>';
            //html.appendClass($('#itemAttIdssss'))
            $('.appendClass').append(html);
            //$('#itemAttIdss').appendAfter();

            var valueArr = $("input[name='randomQtyNO[]']")
              .map(function(){return $(this).val();}).get();
            
            
            //$('#itemAttIdss').append('<div class="row" id="removeQty_'+randomQtyNO+'"><div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Item Attribute Name :</b></label><div class="col-md-7"><select class="form-control form-control_3 select2-containers" name="process_idsss[]" id="kt_select2_3_modal_3_items_'+randomQtyNO+'" >'+processName+'</select></div></div></div><div class="col-md-5"><div class="form-group row"><label class="control-label text-right  col-md-4 col-form-label"><b class="abcs" style="font-size:9px;">Value :</b></label><div class="col-md-7"><input type="text" id="value" name="value[]" class="form-control abc" placeholder="Value" /><span class="text-danger abc" id="emptyGst" style="font-size: 11px"></span></div></div></div><div class="col-md-1"><div class="form-group row"><button type="button" onclick="deleteQty('+randomQtyNO+')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div></div></div>');
            
            
           $("#itemAttIdssss").html('<div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Add Item Attributes :</b></label><div class="col-md-7"><button type="button" onclick="addItemAttDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button></div></div></div>');


            $('#kt_select2_3_modal_3_items_'+randomQtyNO).select2({
                placeholder: "Select Attribute Name",
            }); 

            
/*            $('#kt_select2_3_modal_3_items_'+randomQtyNO).select2({
                placeholder: "Select Process(s)",
            }); 
*/

            //   $('.my-custom-scrollbar').css({'position' : 'relative', 'height' : '179px','overflow' : 'auto'});
            
            
            
        } 
        
        
    function deleteQtysCylinder(randomQtyNO = null) {

            var result = confirm("Are you Want to delete?");
            if (result) {
                $("#removeQty_"+randomQtyNO).remove();
                setTimeout(function() {
                    toastr.success(
                        'Item Cylinder Detail has been deleted.', 'Success!',
                        { 
                            "closeButton": true,
                            timeOut: 3000 
                        }
                    );
                }, 1000);
            }
        }

    


    function deleteQtysCylinderss(randomQtyNO = null) {
        
        
            var result = confirm("Are you Want to delete?");
            if (result) {
                
                var Id = btoa(randomQtyNO);
                window.location.href = "itemssssssDetails/delete/"+Id
        
                
            /*    $.ajax({
                    url:"{{ route('itemsssss.valuessss') }}",
                    type :'get',
                    data : {  
                        randomQtyNOssrr : randomQtyNO,
                    },
                    success:function(result) {  
                        $("#removeQty_"+randomQtyNO).remove();

                        setTimeout(function() {
                            toastr.success(
                                'Item Cylinder Detail has been deleted.', 'Success!',
                                { 
                                    "closeButton": true,
                                    timeOut: 3000 
                                }
                            );
                        }, 1000);
                        
                    }
                });
*/            }
        }

    function deleteQtys(randomQtyNO = null) {
            
        var result = confirm("Are you Want to delete?");
        if (result) {
           
            $.ajax({
                url:"{{ route('itemsssss.value') }}",
                type :'get',
                data : {  
                    randomQtyNOss : randomQtyNO,
                },
                success:function(result) {

                    $("#removeQty_"+randomQtyNO).remove();
                    setTimeout(function() {
                    toastr.success(
                        'Item Attribute has been deleted.', 'Success!',
                        { 
                            "closeButton": true,
                            timeOut: 3000 
                        }
                    );
                    }, 1000);
                


                }
            });
        
        }
    }
        
    function deleteQty(randomQtyNO = null) {
        
        var result = confirm("Are you Want to delete?");
        if (result) {

                var valueArr = $("input[name='randomQtyNO[]']")
              .map(function(){return $(this).val();}).get();
            
            if (valueArr.length >= 6) {
/*
                $('.my-custom-scrollbar').css({'margin':'4px, 4px',
                    'height': '335px',
                    'overflow-x': 'hidden',
                    'overflow-y': '110px',
                });
                */

        } else {
                

            if (valueArr.length == 1) {
               // $('.my-custom-scrollbar').css({'height': '0px'});

                $("#itemAttIdssss").html('<div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Add Item Attributes :</b></label><div class="col-md-7"><button type="button" onclick="addItemAttDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button></div></div></div>');

            } else {
              //  $('.my-custom-scrollbar').css({'height': '250px'});
            }

        }


            $("#removeQty_"+randomQtyNO).remove();

            setTimeout(function() {
                toastr.success(
                    'Item Attribute has been deleted.', 'Success!',
                    { 
                        "closeButton": true,
                        timeOut: 3000 
                    }
                );
            }, 1000);

        }
    }

        
    function resetItemForm() {
        /*$('#emptyName').hide();
        var name = $('#name').val('');
        */
        window.location.href = "{{route('item') }}";        

    }    
    
    
      
    
                            
        
    </script>

    

</body>
</html>

