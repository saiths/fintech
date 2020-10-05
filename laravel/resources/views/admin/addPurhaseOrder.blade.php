@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <input type="hidden">

                        @if(!empty($getPurhaseDataByID))
                            @foreach ($getPurhaseDataByID as $getPurhaseData)
                            @endforeach
                        @endif

                        @if(!empty(Session::get('sessionUserData'))) 
                            @foreach (Session::get('sessionUserData') as $sessionUserData)
                            @endforeach
                        @endif
            
                         <form id="register-form"  class="form-horizontal" name="register_form" 
                         method="post" enctype="multipart/form-data" autocomplete="off">
                            
                            <style type="text/css">

                                .abcs 
                                {
                                    font-size: 12px;
                                }

                                .abcqty 
                                {
                                    border-color:red;
                                    
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
                              
                            </style>
                                    

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="po_id" id="po_id" 
                            value="{{!empty($getPurhaseData->id) ? $getPurhaseData->id:''}}">

                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                            <div class="card-body">
                                <style type="text/css">
                                    .abc {
                                        font-size: 10px;
                                    }
                                </style>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">PO. No :</b> 
                                            </label>
                                            <div class="col-md-5">
                                                <?php 
                                                    $purchaseDetailsQuery = DB::select('SELECT MAX(po_no) as  inwardNo FROM purchase_order WHERE is_deleted_status = "N"');
                                                    $inwardNo = $purchaseDetailsQuery[0]->inwardNo;
                                                    if (!empty($purchaseDetailsQuery)) {
                                                        if (empty($inwardNo)) {
                                                            $bookNoFinal = 1;
                                                        } else {
                                                            $bookNoFinal = $inwardNo + 1;
                                                        }
                                                    }
                                                ?>
                                                
                                                <input type="text" id="po_no" name="po_no" 
                                                onkeypress="return isNumber(event)" class="form-control borderred"
                                                  id="inputEmail3"  placeholder="PO. No" 
                                                value="{{ !empty($getPurhaseData->po_no) ? $getPurhaseData->po_no : $bookNoFinal }}" readonly="">

                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">PO. Date :</b>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text"  name="po_date" 
                                                    class="form-control borderred" readonly=""  placeholder="PO. Date"  
                                                    id="kt_datetimepicker_6"  
                                                    value="{{ !empty($getPurhaseData->po_date) ?  $getPurhaseData->po_date : date('d-m-yy') }}">
                                                    
                                                <span class="text-danger"></span>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-8 col-form-label"></label>
                                            <div class="col-md-4">
                                                <a href="{{route('purchaseorder')}}" class="btn btn btn-success  font-weight-bolder text-left">
                                                    Back >>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">Party Name :</b> 
                                            </label>

                                            <div class="col-md-8">
                                                <select class="form-control" name="party_id" id="kt_select2_3_modal_1" 
                                                style="width: 239%">

                                                     <option value=""> Select Party Name</option>
                                                    
                                        <?php
                                        if (!empty($sessionUserData[0]->user_type) && $sessionUserData[0]->user_type == 3) {

                                            $getUserData = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND user_type = 3 AND id = '.$sessionUserData[0]->id.' ORDER By username ASC ');

                                                if (!empty($getUserData)) {
                                                    foreach ($getUserData as $user) {  

                                        ?>   
                                                        <option value="<?php echo $user->id; ?>" selected="selected"><?php echo $user->party_name; ?></option>


                                                    <?php    
                                                    }
                                                }  

                                        } else {


                                            $getUserData = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND user_type = 3 ORDER By username ASC ');

                                                if (!empty($getUserData)) {
                                                    foreach ($getUserData as $user) {  
                                        ?>


                                        <option value="<?php echo $user->id; ?>" <?php
                                            if (!empty($getPurhaseData->party_id)) {
                                                                    
                                                                        if ($getPurhaseData->party_id == $user->id)  {
                                                                            echo  'selected="selected"';
                                                                        } else {
                                                                            echo 'disabled=disabled';
                                                                        }
                                                                    
                                                                    }
                                                                    ?>

                                            ><?php echo $user->party_name; ?></option>




                                        <?php


                                                    }
                                                
                                                }

                                             

                                            }      
                                        ?>



                                                

                                                </select>
                                                <span class="text-danger" id="partyIdMsg"></span>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback" style="margin-left:-15px;">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">Item Name :</b> 
                                            </label>

                                            <div class="col-md-8">
                                                <select class="form-control form-control" name="item_id" id="item_id" 
                                                style="width: 239%" >
                                                     <option value=""> Select Item Name</option>
                                                            
                                                    <?php

                                if (!empty($sessionUserData[0]->user_type) && $sessionUserData[0]->user_type == 1) {

                                    $editPartyId = !empty($getPurhaseData->party_id) ? $getPurhaseData->party_id : 0;
                                    $getItemNameData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND  party_id = '.$editPartyId.' ORDER By name ASC ');
                                    if (!empty($getItemNameData)) {
                                        foreach ($getItemNameData as $itemData) {
                            ?>              
                                            <option value="<?php echo $itemData->id; ?>" <?php
                                                if (!empty($getPurhaseData->item_id)) {
                                                    if ($getPurhaseData->item_id == $itemData->id)  {
                                                        echo  'selected="selected"';
                                                    }
                                                }
                                                                    ?>

                                            ><?php echo $itemData->name; ?></option>
                                            <?php
                                            } 
                                        }

                                        

                                } else if (!empty($sessionUserData[0]->user_type) && $sessionUserData[0]->user_type == 3) {

                                                     
                                 $getItemNameData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND  
                                    party_id = '.$sessionUserData[0]->id.' ORDER By name ASC ');

                                    if (!empty($getItemNameData)) {
                                foreach ($getItemNameData as $itemData) {  

                                                    ?>   



                                        <option value="<?php echo $itemData->id; ?>" <?php
                                            if (!empty($getPurhaseData->item_id)) {
                                                                    
                                                                        if ($getPurhaseData->item_id == $itemData->id)  {
                                                                            echo  'selected="selected"';
                                                                        }
                                                                    
                                                                    }
                                                                    ?>

                                            ><?php echo $itemData->name; ?></option>
                                            




                                                                        <?php    
                                                   
                                                                        
                                                                }
                                                            }  


}

                                                               // } 
                                                          //  } 
//
                                                    //    }
                                                    ?>

                                                </select>
                                                <span class="text-danger" id="itemNameMsg" ></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="margin-left: 125px">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-9 col-form-label">
                                                <b class="abc">Unit :</b> 
                                            </label>
                                            <?php 
                                            if (!empty($getPurhaseData->item_id)) {
                                                $getItemUnitData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND  id = '.$getPurhaseData->item_id.' ORDER By name ASC ');
                                                
                                                $unitId = !empty($getItemUnitData[0]->unit_id) ? $getItemUnitData[0]->unit_id : 0;

                                                $getUnitNames = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND  id = '.$unitId.' ORDER By unit ASC ');
                                                    


                                            }

                                                
                                            ?>

                                            <div class="col-md-3">
                                                <input type="text" id="unit_id"  name="unit_id" placeholder="Unit" readonly="" 
                                                value="{{ !empty($getUnitNames[0]->unit) ? $getUnitNames[0]->unit : '' }}" class="form-control" style="width: 140px;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-5" style="margin-left: -134px;">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-8 col-form-label">
                                                <b class="abc">Qty :</b> 
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" id="qty"  onkeypress="return fun_AllowOnlyAmountAndDot(this);"  name="qty" placeholder="Qty" style="width: 140px;"  value="{{ !empty($getPurhaseData->qty) ? $getPurhaseData->qty : '' }}" class="form-control abcqty">
                                                <span class="text-danger col-md-4" id="qtyMsg"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">Design File :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input name="filesToUploads[]" id="filesToUpload" type="file" multiple="" 
                                                onchange="makeFileList();" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8" id="fileList">
                                    </div>
                                </div>


                                <?php
                                    $ticketId = !empty($getPurhaseData->id) ? $getPurhaseData->id : 0;
                                    $getTicketAttachmentData = DB::select('SELECT * FROM purchase_order_image WHERE is_deleted_status = 
                                    "N" AND po_id = '.$ticketId.'');

                                    if (!empty($getTicketAttachmentData)) {

                                ?>
                                    
                                    <div class="row">
                                        <div class="col-md-12" style="overflow-x: auto;">

                                                <table  class="table table-bordered table-hover table-checkable" >

                                                <tbody>
                                                <tr id="attachment">

                                                    <?php 
                                                        foreach ($getTicketAttachmentData as $attachment) {
                                                            $uploadPath = url('laravel/public/po_image');
                                                            $ticketNoStr = $getPurhaseData->po_no.'_';
                                                            $finalFileName = 
                                                            str_replace($ticketNoStr, '', $attachment->image);



                                                    ?>
                                                                <td id="attachment_<?php echo $attachment->id; ?>">

                                                                    <!-- <a href="<?php echo  $uploadPath.'/'.$attachment->image ?>" target="_blank" download="<?php echo $finalFileName; ?>" class="btn btn-info font-weight-bolder font-size-sm mr-3"><?php echo $finalFileName;?><i class="flaticon2-trash"></i></a>
 -->
<!-- 
                                                                    <a href="<?php echo  $uploadPath.'/'.$attachment->image ?>" target="_blank" download="<?php echo $finalFileName; ?>" class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-bold-close icon-xs"></i> <?php echo $finalFileName;?></a> -->


                                                                    <div class="row">&nbsp;&nbsp;
                                                    <a href="#" onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->image;?>')"  class="text-primary font-weight-bolder"><i class="text-dark-10 flaticon2-trash"></i></a>&nbsp;&nbsp;
                                                    
                                                    <a href="<?php echo  $uploadPath.'/'.$attachment->image ?>" target="_blank" download="<?php echo $finalFileName; ?>" class="text-dark-75 font-weight-bolder font-size-sm"><?php echo $finalFileName;?></a>

                                                    
                                                </div>

                                                                    <!-- <a href="#"    onclick="deleteAttachment(<?php echo $attachment->id;?>,'<?php echo $attachment->image;?>')"  class="btn btn-xs btn-danger" style="padding: 0px 7px;"><i class="ti-trash"></i> 
                                                                    </a>
                                                                     -->
                                                                </td>
                                                         

                                                                    

                                                            <?php
                                                        }
                                                    ?>
                                                    </tr>
       
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    <?php 
                                    }
                                ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc">Description :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" rows="2"  
                                                id="description" name="description" 
                                                placeholder="Description" 
                                        value="{{ !empty($getPurhaseData->description) ? $getPurhaseData->description : '' }}" 
                                        style="width: 239%">{{ !empty($getPurhaseData->description) ? $getPurhaseData->description : '' }}</textarea>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php 
                                /*
                                @if (!empty($getPurhaseData->id))


                                 <?php
                                  //  $attribute_item_id  = [];
                                    $attribute_item_id_values  = [];
                                  //  $item_idArr  = [];
                                    
                                    
                                    $getTicketAttachmentDatas = 
                                    DB::select('SELECT * FROM attribute_item_master WHERE is_deleted_status = 
                                    "N"  AND item_id = '.$getPurhaseData->item_id.' ');

                                    
                                    if (!empty($getTicketAttachmentDatas)) { 
                                        
                                        
                                    ?>


                                        <div id="line"><hr></div>      

                                        <div class="row" id="label">
                                            <div class="col-md-4">
                                                <div class="form-group row has-feedback">
                                                    <label class="control-label text-right col-md-4 col-form-label">
                                                        <b class="abc" style="font-size: 9px;">Job Specification :</b> 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"  id="data">
                                            <div class="col-md-12" style="height: 250px;overflow-x: auto;">
                                                <table class="table table-bordered table-hover table-checkable" >
                                                    <tbody id="purhaseDetail">
                                                            
                                                        <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                            <?php

                                                foreach ($getTicketAttachmentDatas as $attachmentAttlist) {
                                                    $attribute_item_id[] = $attachmentAttlist->attribute_item_id;
                                                    //$attribute_item_id_values[] = $attachmentAttlist->value;
                                                   // $item_idArr[] = $attachmentAttlist->item_id;

                                                    
                                                       
                                                }
                                                $attItemIdlist = !empty($attribute_item_id) ? implode(',', $attribute_item_id) : 0;

                                             //   echo $attItemIdlist;

$finDATA =  
DB::table('item_attribute_master')
  ->select('item_attribute_master.id','item_attribute_master.name','purchase_order_attribute.value')
  ->join('purchase_order_attribute','purchase_order_attribute.attribute_item_id','=','item_attribute_master.id')
  ->where('item_attribute_master.is_deleted_status', 'N')
  ->where('purchase_order_attribute.is_deleted_status', 'N')
  ->whereIN('purchase_order_attribute.attribute_item_id', $attribute_item_id)
  ->where('purchase_order_attribute.item_id', $getPurhaseData->item_id)
->where('purchase_order_attribute.po_id', $getPurhaseData->id)
->orderBy('item_attribute_master.name', 'ASC')
->get()
->toArray();
                                            

                $getItemData = 
                DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" AND  id IN('.$attItemIdlist.') ORDER By name ASC ');
                                                            if (!empty($getItemData)) {
                                                                foreach ($getItemData as $item) { 
                                                            ?>
                                                                    <td>
                                                                        <input type="hidden" id="value"    name="attribute_item_ids[]"   value="<?php echo $item->id; ?>" class="form-control">
                                                                        <div style="cursor: none;" class="btn-sm btn-dark">
                                                                            <?php echo $item->name;?>
                                                                        </div>
                                                                    </td>

                                                                    <?php 
                                                                } 
                                                            } 
                                                            ?>
                                                        </tr>
                                                        <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                            <?php
                                                            $i = 0;
                                                            $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" AND id IN('.$attItemIdlist.') ORDER By name ASC ');
                                                            if (!empty($getItemData)) {
                                                                foreach ($getItemData as $item) { 
                                                            ?>
                                                                
                                                    <td>
                                    <input type="text" id="value"    name="values[]" placeholder="<?php echo $item->name; ?> - Value"  value="{{!empty($finDATA[$i]->value) ? $finDATA[$i]->value : '' }}" class="form-control"></td>
                                                                    
                                                                <?php 
                                                                $i++;
                                                                } 
                                                            } 
                                                            ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>  

                                    <?php 
                                } else {
                                    ?>

                                    
                                <div id="line" style="display: none;" ><hr></div>      

                                <div class="row" style="display: none;" id="label">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc" style="font-size: 9px;">Job Specification :</b> 
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row" style="display: none;" id="data">
                                    <div class="col-md-12" style="height: 250px;overflow-x: auto;">
                                        <table class="table table-bordered table-hover table-checkable" >
                                            <tbody id="purhaseDetail">
                                                    
                                                <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                    <?php
                                                    $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" 
                                                        ORDER By name ASC ');

                                                    if (!empty($getItemData)) {
                                                        foreach ($getItemData as $item) { 
                                                    ?>
                                                            <td>
                                                                <div style="cursor: none;" class="btn-sm btn-dark">
                                                                    <?php echo $item->name;?>
                                                                </div>
                                                            </td>

                                                            <?php 
                                                        } 
                                                    } 
                                                    ?>
                                                </tr>
                                                <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                    <?php
                                                    $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" ORDER By name ASC ');
                                                    if (!empty($getItemData)) {
                                                        foreach ($getItemData as $item) { 
                                                    ?>
                                                        
                                                            <td>
                                                                <input type="text" id="value"    name="value" placeholder="Value" style="width: 140px;float:left"  value="" class="form-control">

                                                            </td>
                                                            
                                                        <?php 
                                                        } 
                                                    } 
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  

                                        

                                    <?php
                                    } 
                                    ?>

                                @else 


                                <div id="line" style="display: none;" ><hr></div>      

                                <div class="row" style="display: none;" id="label">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abc" style="font-size: 9px;">Job Specification :</b> 
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row" style="display: none;" id="data">
                                    <div class="col-md-12" style="height: 250px;overflow-x: auto;">
                                        <table class="table table-bordered table-hover table-checkable" >
                                            <tbody id="purhaseDetail">
                                                    
                                                <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                    <?php
                                                    $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" ORDER By name ASC ');
                                                    if (!empty($getItemData)) {
                                                        foreach ($getItemData as $item) { 
                                                    ?>
                                                            <td>
                                                                <div style="cursor: none;" class="btn-sm btn-dark">
                                                                    <?php echo $item->name;?>
                                                                </div>
                                                            </td>

                                                            <?php 
                                                        } 
                                                    } 
                                                    ?>
                                                </tr>
                                                <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>">
                                                    <?php
                                                    $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" ORDER By name ASC ');
                                                    if (!empty($getItemData)) {
                                                        foreach ($getItemData as $item) { 
                                                    ?>
                                                        
                                                            <td>
                                                                <input type="text" id="value"    name="value" placeholder="Value" style="width: 140px;float:left"  value="" class="form-control">

                                                            </td>
                                                            
                                                        <?php 
                                                        } 
                                                    } 
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  


                                @endif
                                */
                                
                                ?>

                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abc"></b> </label>
                                            <div class="col-md-8">
                                                <button type="submit"  
                                                id="lorderId" class="btn btn-primary">Save</button>
                                                <button type="button" onclick="resetForm()"  id="cancelId" class="btn btn-dark">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
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
    function makeFileList() {
        var input = document.getElementById("filesToUpload");
        for (var i = 0; i < input.files.length; i++) {
            $('#fileList').append('<b>'+input.files[i].name+' , </b>');
        }
    }
</script>
    

<script type="text/javascript">

    $("#kt_select2_3_modal_1").on('change',function() {
        var partyId = $(this).val(); 
        $('#line').hide();
        $('#label').hide();
        $('#data').hide();
                    
        $.ajax({
            url:"{{ route('purchaseorder.itemselectd') }}",
            type :'get',
            data : {  
                partyIds: partyId,
            },
            success:function(result){
                if (result == 0) {
                    $('#unit_id').val('');
                    $('#item_id').html('');
                  //  $('#qty').val('');
                  //  $('#description').val('');
                    
                    $('#line').hide();
                    $('#label').hide();
                    $('#data').hide();

                } else {
                    $('#item_id').html(result);
                    $('#unit_id').val('');
                    
                 //   $('#qty').val('');
                 //   $('#description').val('');

                }

            }
        });
    });

    $("#item_id").on('change',function() {
        var itemId = $(this).val(); 
        $('#line').show();
        $('#label').show();
            
      //  $('#line').html('<hr>');
      //  $('#label').html('<div class="col-md-4"><div class="form-group row has-feedback"><label class="control-label text-right col-md-4 col-form-label"><b class="abc" style="font-size: 9px;">Job Specification :</b></label></div></div>');

        $.ajax({
            url:"{{ route('purchaseorder.itemattselectd') }}",
            type :'get',
            data : {  
                itemIds: itemId,
            },
            success:function(result)  {
                if (result == 0) {

                    $('#line').hide();
                    $('#label').hide();
                    $('#data').hide();
                    


                  ///  $('#unit_id').val('');
                  //  $('#qty').val('');
                  //  $('#description').val('');


                } else {
                    $('#data').show();
                    $('#data').html(result);
                    
                   // $('#unit_id').val('');
                //    $('#qty').val('');
                //    $('#description').val('');



                }


            }
        });


        $.ajax({
            url:"{{ route('purchase.itemselectd') }}",
            type :'get',
            data : {  
                itemId: itemId,
            },
            success:function(result) {
                $('#unit_id').val(result);
            }
        });


        
    });

    $("#lorderId").click(function (e) {

        e.preventDefault();

        var _token = $('#_token').val();
        var po_no = $('#po_no').val();
        var po_id = $('#po_id').val();
        var po_date = $('#kt_datetimepicker_6').val();
        var party_id = $('#kt_select2_3_modal_1').val();
        var item_id = $('#item_id').val();
        var description = $('#description').val();
        var qty = $('#qty').val();

        var attribute_item_ids = $("input[name='attribute_item_ids[]']")
              .map(function(){return $(this).val();}).get();
        
        var values = $("input[name='values[]']")
              .map(function(){return $(this).val();}).get();

       // var form_data = new FormData();
        



        if ((party_id == '' || party_id == null || party_id == 'undefined') || 
            (item_id == '' || item_id == null || item_id == 'undefined') || qty == '') 

        {
            

            $('.select2-selection').css('border-color','red');
            if ((party_id == '' || party_id == null || party_id == 'undefined')) {
                $('#partyIdMsg').show();
                $('#partyIdMsg').html("Party Name is Required.");
            } else {
                $('#partyIdMsg').hide();

            }   

            if ((item_id == '' || item_id == null || item_id == 'undefined')) {
                $('#itemNameMsg').show();
                $('#itemNameMsg').html("Item Name is Required.");
            } else {
                $('#itemNameMsg').hide();
            }


            if (qty == '') {
                $('#qtyMsg').show();
                $('#qtyMsg').html("Qty Required.");
            } else {
                $('#qtyMsg').hide();
            }


        } else {


            var data = new FormData();

            var ins = document.getElementById('filesToUpload').files.length;
            for (var x = 0; x < ins; x++) {
                data.append("filesToUploads[]", document.getElementById('filesToUpload').files[x]);
            }

    
/*          $("#lorderId").attr("disabled", true);
            $("#cancelId").attr("disabled", true);
            $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');    
*/
            
            $('#qtyMsg').hide();
            $('#itemNameMsg').hide();
            $('#partyIdMsg').hide();
            $('#itemNameMsg').hide();
            
            data.append("po_id", po_id);
            data.append("_token", _token);
            data.append("po_no", po_no);
            data.append("po_date", po_date);
            data.append("item_id", item_id);
            data.append("party_id", party_id);
            data.append("description", description);
            data.append("qty", qty);
            data.append("attribute_item_ids", attribute_item_ids);
            data.append("values", values);


            //data.append("design_files", formDatas);

            if (po_id == undefined || po_id == '') {

                $.ajax({
                    url: "{{ route('purchaseorder.add') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                         window.location.href = "{{route('purchaseorder') }}";

                    }
                });

                


            } else {


                $.ajax({
                    url: "{{ route('purchaseorder.edit') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                       window.location.href = "{{route('purchaseorder') }}";
 
                    }
                });

            } 

        }
    });


    function fun_AllowOnlyAmountAndDot(txt)
    {
        if(event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46)
        {
           var txtbx=document.getElementById(txt);
           var amount = document.getElementById(txt).value;
           var present=0;
           var count=0;

           if(amount.indexOf(".",present)||amount.indexOf(".",present+1));
           {

           }

          /*if(amount.length==2)
          {
            if(event.keyCode != 46)
            return false;
          }*/
           do
           {
           present=amount.indexOf(".",present);
           if(present!=-1)
            {
             count++;
             present++;
             }
           }
           while(present!=-1);
           if(present==-1 && amount.length==0 && event.keyCode == 46)
           {
                event.keyCode=0;
                //alert("Wrong position of decimal point not  allowed !!");
                return false;
           }

           if(count>=1 && event.keyCode == 46)
           {

                event.keyCode=0;
                //alert("Only one decimal point is allowed !!");
                return false;
           }
           if(count==1)
           {
            var lastdigits=amount.substring(amount.indexOf(".")+1,amount.length);
            if(lastdigits.length>=2)
                        {
                          //alert("Two decimal places only allowed");
                          event.keyCode=0;
                          return false;
                          }
           }
                return true;
        }
        else
        {
            event.keyCode=0;
            return false;
        }
    }
    
    $('#kt_datetimepicker_6').datetimepicker({
      //  startDate: dateToday,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        startView: 2,
        minView: 2,
        forceParse: 0,
        //    minDate:dateToday,
        pickerPosition: 'bottom-right'
    });
    

    function resetForm() {
        $('#qtyMsg').hide();
        $('#itemNameMsg').hide();
        $('#partyIdMsg').hide();
        window.location.reload();
    }

    function deleteAttachment(attachmentId = null,attachment = null) {

        var result = confirm("Are you Want to delete?"); 
        if (result == true) {     
            $.ajax({
                url:"{{ route('attachment.remove') }}",
                type :'get',
                data : {  
                    attachmentId: attachmentId,
                    attachment: attachment,
                },
                success:function(result) {
                    if (result !=  '') {
                        toastr.success(
                            'Attachment has been deleted.', 'Success!',
                            { 
                                "closeButton": true,
                                timeOut: 3000 
                            }
                        );
                        $('#attachment_'+result).remove();    
                    }
                }
            });
        }
    }
    

</script>

</body>
</html>

