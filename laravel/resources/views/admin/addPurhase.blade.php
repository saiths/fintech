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
<!-- 
                        @if(!empty($getPurhaseDataByID))
                            <form class="form-horizontal" id="register-form_edit"  action="{{ route('purchase.edit') }}" 
                            method="post"> 
                        @else     
                            <form class="form-horizontal" id="register-form_edit"  action="{{ route('purchase.add') }}" 
                            method="post"> 
                        @endif
                         -->

                        <form id="register-form"  class="form-horizontal" name="register_form" method="post" enctype="multipart/form-data" autocomplete="off">
                            
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <input type="hidden" name="purhaseId" id="purhaseId" value="{{!empty($getPurhaseData->id) ? $getPurhaseData->id:''}}">

                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                            <div class="card-body">
                                <style type="text/css">
                                    .abcs {
                                        font-size: 10px;
                                    }
                                    .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple
                                {
                                    border-color:red;
                                }
                                
                                
                                
                                .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--open .select2-selection--single 
                                {
                                    border-color:red;
                                }
                                
                                .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple 
                                {
                                    border-color:red;

                                }
                                    
                                </style>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abcs">Inward No :</b> 
                                            </label>
                                            <div class="col-md-5">
                                                <?php 
                                                    $purchaseDetailsQuery = DB::select('SELECT MAX(inward_no) as  
                                                    inwardNo FROM purchase_master WHERE is_deleted_status = "N"');
                                                    $inwardNo = $purchaseDetailsQuery[0]->inwardNo;
                                                    if (!empty($purchaseDetailsQuery)) {
                                                        if (empty($inwardNo)) {
                                                            $bookNoFinal = 1;
                                                        } else {
                                                            $bookNoFinal = $inwardNo + 1;
                                                        }
                                                    }
                                                ?>
                                                
                                                <input type="text" id="inward_no" name="inward_no" 
                                                onkeypress="return isNumber(event)" class="form-control borderred"
                                                  id="inputEmail3"  placeholder="Inward No" 
                                                value="{{ !empty($getPurhaseData->inward_no) ? $getPurhaseData->inward_no : $bookNoFinal }}" readonly="">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abcs">Inward Date :</b>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text"  name="inward_date" 
                                                    class="form-control borderred" readonly=""  placeholder="Inward Date"  
                                                    id="kt_datetimepicker_6"  
                                                    value="{{ !empty($getPurhaseData->inward_date) ?  $getPurhaseData->inward_date : date('d-m-yy') }}">
                                                    
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-8 col-form-label"></label>
                                            <div class="col-md-4">
                                                <a href="{{route('purchasesers')}}" 
                                                class="btn btn btn-success  font-weight-bolder text-left">
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
                                                <b class="abcs">Purchase Bill No :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" id="purchase_bill_nos" name="purchase_bill_nos" 
                                                class="form-control abc borderred" onkeypress="return isNumber(event)"
                                                  id="inputEmail3"  placeholder="Purchase Bill No" 
                                                    value="{{ !empty($getPurhaseData->purchase_bill_no) ?  $getPurhaseData->purchase_bill_no : '' }}">
                                                <span class="text-danger" id="purchaseBillNosMsg"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abcs">Purchase Date :</b> 
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text"  name="purchase_date" 
                                                class="form-control borderred" readonly="" id="kt_datetimepicker_7"
                                                   placeholder="Purchase Date" 
                                                value="{{ !empty($getPurhaseData->purchase_date) ?  $getPurhaseData->purchase_date : date('d-m-yy') }}">
                                                   <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b class="abcs">Party Name :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="party_id" id="kt_select2_3_modal_1" 
                                                style="width: 239%">

                                                    <option value=""> Select Party Name</option>
                                                            
                                                    <?php

                                        $getUserData = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" 
                                        AND user_type = 3 ORDER BY party_name ASC ');
                                                        if (!empty($getUserData)) {
                                                            foreach ($getUserData as $user) {  
                                                        
                                                    ?>   
                                                     
                                                            
                                                        <option value="<?php echo $user->id; ?>"
                                                            <?php 
                                                            
                                                            if (!empty($getPurhaseData->party_id)) {
                                                                
                                                                if ($getPurhaseData->party_id == $user->id)  {
                                                                    echo  'selected="selected"';
                                                                }
                                                                
                                                            } 
                                                            ?>><?php echo $user->party_name; ?></option>


                                                    <?php    
                                                        }
                                                    }        
                                                    ?>
                                                </select>
                                                <span class="text-danger" id="partyIdMsg"></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>    

                                <div class="row">
                                    <div class="col-md-2">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs">Item Type Name</b></label>
                                        </center>
                                        <select class="form-control" name="item_type_id" id="item_type_idsssddd">


                                            <?php
                                                $getItemTypeData = 
                                                DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N" ');
                                                if (!empty($getItemTypeData)) {
                                                    foreach ($getItemTypeData as $itemType) {  
                                            ?>


                                                <option value="<?php echo $itemType->id.'_'.$itemType->name; ?>"><?php echo $itemType->name; ?></option>
                                            <?php    
                                                }
                                            }        
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2" style="margin-left: -23px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs" style="margin-left:53px;">Item Name</b> </label>
                                        </center>
                        <select class="form-control form-control" name="item_id" id="item_id" style="width: 205px;margin-left:-15px">
                            <option value=""> Select Item Name</option>
                                                    
                                            <?php
                            $getItemData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id = 1 ORDER BY name ASC');
                                                
                                                if (!empty($getItemData)) {
                                    foreach ($getItemData as $item) {  
                                            ?>      

                                                        <option value="<?php echo $item->id.'_'.$item->name; ?>"><?php echo $item->name; ?></option>

                                                    <?php    
                                                }
                                            }        
                                            ?>
                                        </select>
                                        <span class="text-danger" id="itemNameMsg" style="font-size: 12px;"></span>
                                        
                                    </div>

                                    <div class="col-md-1" style="margin-left: 40px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs">Unit</b> </label>
                                        </center>
                                        <?php
                                           /* $getUnitDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND 
                                                item_type_id = 1 ORDER BY id ASC  LIMIT 1'); 
                                            if (!empty($getUnitDatas)) {
                                                $unitId = $getUnitDatas[0]->unit_id;
                                                $getUnitDatas = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" 
                                                    AND id = '.$unitId.''); 
*/


                                        ?>  

                                              

                                                            

                                            <?php
                                        //    }
                                        ?>
<!-- 
                                          <input type="text" id="unit_id" onkeypress="return isNumber(event)" name="unit_id[]" 
                                                placeholder="Unit" readonly="" value="{{!empty($getUnitDatas[0]->unit) ? $getUnitDatas[0]->unit : '' }}" 
                                                class="form-control">
                                                 -->

                                          <input type="text" id="unit_id" onkeypress="return isNumber(event)" name="unit_id[]" 
                                                placeholder="Unit" readonly="" value="" 
                                                class="form-control">
                                                

                                        <input type="hidden" id="unit_id_id" value="{{!empty($getUnitDatas[0]->id) ? $getUnitDatas[0]->id : '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-1" style="margin-left: -23px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs">Qty</b> </label>
                                        </center>
                                        <input type="text" id="qty" oninput="getQty(this)" 
                                        onkeypress="return fun_AllowOnlyAmountAndDot(this);"  name="qty[]" placeholder="Qty"  
                                        class="form-control abc">
                                        <span class="text-danger" style="margin-left: 19px;" id="emptyQty" ></span>
                                    </div>                                

                                    <div class="col-md-1" style="margin-left: -23px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs">Rate</b> </label>
                                        </center>
                                        <input type="text" id="rate"  oninput="getQty(this)" onkeypress="return fun_AllowOnlyAmountAndDot(this);"  name="rate[]" placeholder="Rate"  class="form-control abc">
                                        <span class="text-danger" style="margin-left: 15px;" id="emptyRate"></span>
                                    </div>
                                    
                                    <div class="col-md-1" style="margin-left: -23px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs" style="margin-left:27px;">Amount</b> </label>
                                        </center>
                                        <input type="text" id="amount" oninput="getQty(this)" 
                                        onkeypress="return fun_AllowOnlyAmountAndDot(this);"   name="amount[]" readonly="" placeholder="Amount"  class="form-control" style="width: 170%">
                                    </div>
                                                                    
                                    <div class="col-md-1"  style="margin-left: 18px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs" style="margin-left:18px;">GST(%)</b> </label>
                                        </center>
                                        <?php
                                       /*     $gst = '';
                                            $getItemTypeDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id = 1 ORDER BY id ASC  LIMIT 1'); 
                                            if (!empty($getItemTypeDatas)) {
                                                $gst = !empty($getItemTypeDatas[0]->gst) ? $getItemTypeDatas[0]->gst : '';
                                       */ ?>      


                                        <?php 
                                      //  }
                                        ?>    

                                            <input type="text" id="gst_no" oninput="getQty(this)" 
                                                onkeypress="return fun_AllowOnlyAmountAndDot(this);" 
                                                name="gst_no[]" placeholder="GST(%)" value="<?php //echo $gst;  ?>" class="form-control abc" style="width:80px" >
                                            <span class="text-danger" style="margin-left: 15px;" id="emptyGstPer"></span>
                                    </div>


                                    <div class="col-md-1" style="margin-left: -2px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs" style="margin-left:25px;">GSTAmt.</b> </label>
                                        </center>
                                        <input type="text" id="gst_amount_no" oninput="getQty(this)" onkeypress="return fun_AllowOnlyAmountAndDot(this);" style="width: 170%" name="gst_amount_no[]"  placeholder="GSTAmt." readonly=""  class="form-control">
                                    </div>
                                        
                                    <div class="col-md-1" style="margin-left: 18px;">
                                        <center>
                                            <label for="exampleInputEmail1"> <b class="abcs" style="margin-left:25px;">Total</b> </label>
                                        </center>
                                        <input type="text" id="total" oninput="getQty(this)" onkeypress="return fun_AllowOnlyAmountAndDot(this);" readonly=""  name="total" placeholder="Total"  style="width: 170%"  class="form-control">
                                    </div>

                                    <div class="col-md-1" id="addId" style="margin-left: 18px;margin-top: 6px" >
                                        <label for="exampleInputEmail1" class="col-md-8"></label>
                                        <button type="button"  onclick="addPurhaseDetail()" class="btn btn-primary"><i class="ki ki-plus icon-sm"></i></button>
                                    </div>

                                    <div class="card-body">
                                        <table class="table table-bordered table-hover table-checkable" style="margin-left: -17px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 139px;">Item Type Name</th>
                                                    <th style="width: 210px;">Item Name</th>
                                                    <th style="width: 62px;">Unit</th>
                                                    <th style="width: 62px;">Qty</th>
                                                    <th style="width: 62px;">Rate</th>
                                                    <th style="width: 100px;">Amount</th>
                                                    <th style="width: 80px;">GST(%)</th>
                                                    <th style="width: 100px;">GST Amt.</th>
                                                    <th style="width: 100px;">Total</th>
                                                    <th style="width: 50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="purhaseDetail">
                                                <?php
                                                $unit = '';
                                                    $purhaseId = !empty($getPurhaseData->id) ? $getPurhaseData->id : 0; 
                                                    $purchaseDetailsQuery = DB::select( 'SELECT * FROM purchase_master_detail 
                                                    WHERE is_deleted_status = "N" and purchase_id = '.$purhaseId.'');

                                                    if (!empty($purchaseDetailsQuery)) {
                                                        foreach ($purchaseDetailsQuery as $purchaseDetails) { 
                                                            $purchaseDetailsItemType = DB::select('SELECT * FROM item_type_master 
                                                                WHERE is_deleted_status = "N" and 
                                                                id = '.$purchaseDetails->item_type_id.'');


                                                            if (!empty($purchaseDetailsItemType)) {
                                                                $itemTypeName = !empty($purchaseDetailsItemType[0]->name) ? $purchaseDetailsItemType[0]->name : ''; 
                                                            }


                                                            $purchaseDetailsItemName = DB::select('SELECT * FROM item_master 
                                                                WHERE is_deleted_status = "N" and 
                                                                id = '.$purchaseDetails->item_id.'');
                                                            if (!empty($purchaseDetailsItemName)) {
                                                                $itemName = !empty($purchaseDetailsItemName[0]->name) ? $purchaseDetailsItemName[0]->name : ''; 
                                                            }





                                                            ?>
                                                            
                                                            <tr id="removeQty_<?php echo $purchaseDetails->id; ?>">

                                                                <td>
                                                                    <input type="hidden" name="purchaseDelId[]" 
                                                                    value="<?php echo $purchaseDetails->id; ?>">

                                                                    <input type="hidden" name="itemTypeNames[]" 
                                                                    value="<?php echo $purchaseDetails->item_type_id; ?>">


                                                                    {{!empty($itemTypeName) ? $itemTypeName : '' }}

                                                                </td>

                                                                <td >
                                                                    <input type="hidden" name="itemNames[]" 
                                                                    value="<?php echo $purchaseDetails->item_id; ?>">


                                                                    {{!empty($itemName) ? $itemName : '' }}

                                                                </td>

                                                                <td >
                                                                    <?php 
                                                                    $unitNew = '';
                                                                    if (!empty($purchaseDetails->unit_id)) {


                                                                            $getUnitDataArr = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND 
                                                                                id = '.$purchaseDetails->unit_id.' ');  

                                                                            $unit = !empty($getUnitDataArr[0]->unit) ? $getUnitDataArr[0]->unit : '';

                                                                            $unitNew = "'".$unit."'";

                                                                        }
                                                                        

                                                                    ?>

                                                                    

                                                                    <input type="hidden" name="unitIds[]" 
                                                                    value="<?php echo $unitNew; ?>">

                                                                            {{!empty($unit) ? $unit : '' }}


                                                                </td>

                                                                <td >
                                                                    <input type="hidden" name="qtys[]" 
                                                                    value="<?php echo $purchaseDetails->qty; ?>" >
                                                                    <?php echo number_format($purchaseDetails->qty,2,'.',''); ?>
                                                                </td>

                                                                <td >
                                                                     <input type="hidden" name="rates[]" 
                                                                     value="<?php echo $purchaseDetails->rate; ?>" >
                                                                    <?php echo number_format($purchaseDetails->rate,2,'.',''); ?>
                                                                </td>

                                                                <td >
                                                                    <input type="hidden" name="amounts[]" 
                                                                    value="<?php echo $purchaseDetails->amount; ?>">
                                                                    <?php echo number_format($purchaseDetails->amount,2,'.',''); ?>
                                                                </td>

                                                                <td > 
                                                                    <input type="hidden" name="gst_nos[]" 
                                                                    value="<?php echo $purchaseDetails->gst_no; ?>">
                                                                    <?php echo number_format($purchaseDetails->gst_no,2,'.',''); ?>
                                                                </td>

                                                                <td >
                                                                    <input type="hidden" name="gst_amount_nos[]" 
                                                                    value="<?php echo $purchaseDetails->gst_amount_no; ?>">
                                                                    <?php echo number_format($purchaseDetails->gst_amount_no,2,'.',''); ?>
                                                                </td>

                                                                <td >
                                                                    <input type="hidden" name="totalss[]" 
                                                                    value="<?php echo $purchaseDetails->totals; ?>">
                                                                    <?php echo number_format($purchaseDetails->totals,2,'.',''); ?>
                                                                </td>

                                                                <td >
<a href="#" onclick="editQty(<?php echo $purchaseDetails->id;?>,'<?php echo $purchaseDetails->item_type_id.'_'.$itemTypeName;?>','<?php echo $purchaseDetails->item_id.'_'.$itemName;?>','<?php echo $unit;?>',<?php echo $purchaseDetails->qty;?>,<?php echo $purchaseDetails->rate;?>,<?php echo $purchaseDetails->amount;?>,<?php echo $purchaseDetails->gst_no;?>,<?php echo $purchaseDetails->gst_amount_no;?>,<?php echo $purchaseDetails->totals;?>)"> 
                                                                        <i class="text-dark-10 flaticon2-edit"></i>
                                                                    </a>



                                                                    <a href="#"
                                                                    onclick="getDeletePurchaseDetail(<?php echo $purchaseDetails->id;?>,<?php echo $getPurhaseData->id;?>,<?php echo $purchaseDetails->totals.','.$getPurhaseData->total.','.$getPurhaseData->other_charges.','.$getPurhaseData->grand_total;?>)">

                        

                                                                    <i class="text-dark-10 flaticon2-trash"></i>






                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        
                                                        <?php
                                                        }

                                                    } else {

                                                        echo '<tr class="odd">
                                                            <td valign="text-right" align="center" colspan="10" 
                                                                class="dataTables_empty">
                                                                No data available in table
                                                            </td>
                                                        </tr>';
                                                    } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                
                                </div>

                                <div class="row">
                                    <div class="col-md-4" style="margin-left:-27px;">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abcs">
                                            Remark :</b> </label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="remark" id="remark" style="width: 250%"  
                                                placeholder="Remark" cols="5" rows="2">{{ !empty($getPurhaseData->remark) ?  $getPurhaseData->remark : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4"></div>

                                    <div class="col-md-4">
                                        <?php


                                    $totalEmpty = '';
                                    $otherChargesEmpty = '';
                                    $grandTotalEmpty = '';

 if (!empty($getPurhaseData->id)) {
                                    
                                    $purchase_master_detailArrs = DB::select('SELECT * FROM purchase_master_detail WHERE is_deleted_status = "N" AND purchase_id = '.$getPurhaseData->id.' ');

                                    if (!empty($purchase_master_detailArrs)) {

                                        $totalEmpty = !empty($getPurhaseData->total) ? $getPurhaseData->total : '0.00';
                                        $otherChargesEmpty = 
                                        !empty($getPurhaseData->other_charges) ? $getPurhaseData->other_charges : '0.00';
                                        $grandTotalEmpty = 
                                        !empty($getPurhaseData->grand_total) ? $getPurhaseData->grand_total : '0.00';

                                    } else {
                                        
                                        $totalEmpty = '0.00';
                                        $otherChargesEmpty = '0.00';
                                        $grandTotalEmpty = '0.00';
                                        


                                    }
}

                                    ?>

                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abcs">
                                            Total :</b> </label>
                                            <div class="col-md-6">
                                                <input type="text" id="totals" readonly=""  
                                                oninput="getQty(this)" onkeypress="return fun_AllowOnlyAmountAndDot(this);"  name="totals" placeholder="Total" class="form-control" value="{{!empty($totalEmpty) ?   $totalEmpty : ''}}"  >
                                            </div>
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abcs">
                                            Other Charges :</b> </label>
                                            <div class="col-md-6">
                                                <input type="text" id="other_charges"  oninput="getQtys(this)" onkeypress="return fun_AllowOnlyAmountAndDot(this);" name="other_charges" placeholder="Other Charges" class="form-control" value="{{!empty($otherChargesEmpty) ?  number_format($otherChargesEmpty,'2','.','') : ''}}" >
                                            </div>
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abcs">
                                            Grand Total :</b> </label>
                                            <div class="col-md-6">
                                                <input type="text" id="grand_total" readonly="" oninput="getQty(this)"  onkeypress="return fun_AllowOnlyAmountAndDot(this);" name="grand_total" placeholder="Grand Total" class="form-control" value="{{!empty($grandTotalEmpty) ?  $grandTotalEmpty : ''}}">
                                            </div>
                                        </div> 

                                    </div>
                                </div>  

                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4" style="margin-left:-28px;">
                                        <div class="form-group row has-feedback">
                                            <label class="control-label text-right col-md-4 col-form-label"><b class="abcs"></b> </label>
                                            <div class="col-md-6">
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

    $("#lorderId").click(function (e) {

        e.preventDefault();

        var _token = $('#_token').val();
        var inwardNo = $('#inward_no').val();
        var purhaseId = $('#purhaseId').val();
        

        var inwardDate = $('#kt_datetimepicker_6').val();
        var purchaseDate = $('#kt_datetimepicker_7').val();
        var purchaseBillNos = $('#purchase_bill_nos').val();
        var partyId = $('#kt_select2_3_modal_1').val();
        
        var remark = $('#remark').val();
        var totals = $('#totals').val();
        var other_charges = $('#other_charges').val();
        var grand_total = $('#grand_total').val();
        
        


        var itemTypeNames = $("input[name='itemTypeNames[]']")
              .map(function(){return $(this).val();}).get();
        
        var itemNames = $("input[name='itemNames[]']")
              .map(function(){return $(this).val();}).get();

        var unitIds = $("input[name='unitIds[]']")
              .map(function(){return $(this).val();}).get();
              
        var qty = $("input[name='qtys[]']")
              .map(function(){return $(this).val();}).get();

        var rate = $("input[name='rates[]']")
              .map(function(){return $(this).val();}).get();

        var amounts = $("input[name='amounts[]']")
              .map(function(){return $(this).val();}).get();

        var gstNo = $("input[name='gst_nos[]']")
              .map(function(){return $(this).val();}).get();
        
        var totalss = $("input[name='totalss[]']")
              .map(function(){return $(this).val();}).get();
        
        var gstAmountNos = $("input[name='gst_amount_nos[]']")
              .map(function(){return $(this).val();}).get();
        
                    


        if (purchaseBillNos == '' || (partyId == '' || partyId == null || partyId == 'undefined') ||   
        (itemNames == '' || itemNames == null || itemNames == 'undefined') || qty == '' || rate == '' || gstNo == '') 

        {
            
            $('.select2-selection').css('border-color','red');

            if (purchaseBillNos == '') {
                $('#purchase_bill_nos').css('border-color', 'red');
                $('#purchaseBillNosMsg').show();
                $('#purchaseBillNosMsg').html("Purchase Bill No is required.");
            } else {
                $('#purchase_bill_nos').css('border-color', '#E4E6EF');
                $('#purchaseBillNosMsg').hide();
            }   

            if ((partyId == '' || partyId == null || partyId == 'undefined')) {
                $('#partyIdMsg').show();
                $('#partyIdMsg').html("Party Name is required.");
            } else {
                $('#partyIdMsg').hide();

            }   

            if ((itemNames == '' || itemNames == null || itemNames == 'undefined')) {
                $('#itemNameMsg').show();
                $('#itemNameMsg').html("Item Name is required.");
            } else {
                $('#itemNameMsg').hide();
            }

            if (rate == '') {
                $('#rate').css('border-color', 'red');
                $('#emptyRate').show();
                $('#emptyRate').html("Rate");
            } else {
                $('#rate').css('border-color', '#E4E6EF');
                $('#emptyRate').hide();

            }

            if (qty == '') {
                $('#qty').css('border-color', 'red');
                $('#emptyQty').show();
                $('#emptyQty').html("Qty");
            } else {
                $('#qty').css('border-color', '#E4E6EF');
                $('#emptyQty').hide();
            }

            if (gstNo == '') {
                $('#gst_no').css('border-color', 'red');
                $('#emptyGstPer').show();
                $('#emptyGstPer').html("Gst(%)");
            } else {
                $('#gst_no').css('border-color', '#E4E6EF');
                $('#emptyGstPer').hide();

            }

        } else {


            var data = new FormData();
 
/*            $("#lorderId").attr("disabled", true);
            $("#cancelId").attr("disabled", true);
            $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Saving');    
*/
        //    $('.select2-selection').css('border-color', '#E4E6EF');
        
            $('#gst_no').css('border-color', '#E4E6EF');
            $('#qty').css('border-color', '#E4E6EF');
            $('#rate').css('border-color', '#E4E6EF');
            $('#purchase_bill_no').css('border-color', '#E4E6EF');
            $('#emptyQty').hide();
            $('#emptyGstPer').hide();
            $('#itemNameMsg').hide();
            $('#partyIdMsg').hide();
            $('#purchaseBillNosMsg').hide();
            $('#emptyRate').hide();
            $('#itemNameMsg').hide();

            data.append("_token", _token);
            data.append("inward_no", inwardNo);
            data.append("purchase_bill_nos", purchaseBillNos);
            
            data.append("inward_date", inwardDate);
            data.append("purchase_date", purchaseDate);
            data.append("party_id", partyId);
            
            data.append("itemTypeNames", itemTypeNames);
            data.append("itemNames", itemNames);

            data.append("unitIds", unitIds);
            data.append("qtys", qty);
            data.append("rates", rate);
            data.append("amounts", amounts);
            data.append("gst_nos", gstNo);

            data.append("gst_amount_nos", gstAmountNos);
            data.append("totalss", totalss);

            data.append("remark", remark);
            data.append("totals", totals);
            data.append("other_charges", other_charges);
            data.append("grand_total", grand_total);
            data.append("purhaseId", purhaseId);


                
            if (purhaseId == undefined || purhaseId == '') {

                $.ajax({
                    url: "{{ route('purchase.add') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        window.location.href = "{{route('purchasesers') }}";
                    }
                });
                

            } else {

                $.ajax({
                    url: "{{ route('purchase.edit') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        window.location.href = "{{route('purchasesers') }}";
                    }
                });

            }  
            
        }
    });


    function resetForm() {
       // window.location.href = '{{route("addPurchase")}}';
        window.location.reload();

    }



    function fun_AllowOnlyAmountAndDot(elementRef) {  
  
        var keyCodeEntered = (event.which) ? event.which : (window.event.keyCode) ?    window.event.keyCode : -1;  
  
        if ((keyCodeEntered >= 48) && (keyCodeEntered <= 57)) {  
  
    return true;  
  
}  
  
// '.' decimal point...  
  
else if (keyCodeEntered == 46) {  
  
// Allow only 1 decimal point ('.')...  
  
if ((elementRef.value) && (elementRef.value.indexOf('.') >= 0))  
  
    return false;  
  
else  
  
    return true;  
  
}  
  
    return false;  
  
}  


    function fun_AllowOnlyAmountAndDots(txt)
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
    
    function addPurhaseDetail() 
    {

        var itemId = $('#item_id').val();
        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var gstNo = $('#gst_no').val();
        
        if (qty == '' ||  rate == '' || gstNo == '' || (itemId == '' || itemId == null || itemId == 'undefined')) {


            $('.select2-selection').css('border-color', 'red');  
            if (rate == '') {
                $('#rate').css('border-color', 'red');
                $('#emptyRate').show();
                $('#emptyRate').html("Rate");
            } else {
                $('#rate').css('border-color', '#E4E6EF');
                $('#emptyRate').hide();

            }

            if (qty == '') {
                $('#qty').css('border-color', 'red');
                $('#emptyQty').show();
                $('#emptyQty').html("Qty");
            } else {
                $('#qty').css('border-color', '#E4E6EF');
                $('#emptyQty').hide();
            }

            if (gstNo == '') {
                $('#gst_no').css('border-color', 'red');
                $('#emptyGstPer').show();
                $('#emptyGstPer').html("Gst(%)");
            } else {
                $('#gst_no').css('border-color', '#E4E6EF');
                $('#emptyGstPer').hide();
            }

            if ((itemId == '' || itemId == null || itemId == 'undefined')) {
                $('#itemNameMsg').show();
                $('#itemNameMsg').html("Item Name is required.");
            } else {
                $('#itemNameMsg').hide();

            }


        } else { 

            $('.select2-selection').css('border-color', '#E4E6EF');
            $('#gst_no').css('border-color', '#E4E6EF');
            $('#qty').css('border-color', '#E4E6EF');
            $('#rate').css('border-color', '#E4E6EF');
            $('#itemNameMsg').hide();            
            $('.odd').remove();

            $('#emptyQty').hide('Qty');
            $('#emptyRate').hide('Rate');
            $('#emptyGstPer').hide('GST%');

            
            var randomQtyNO = Math.floor(Math.random() * 1000);
            var itemTypeId = $('#item_type_idsssddd').val();
            var itemTypeName = itemTypeId.split("_");                
            
            var itemId = $('#item_id').val();
            var itemName = itemId.split("_");

            var unitId = $('#unit_id').val();
            var qty = $('#qty').val();
            var amount = $('#amount').val();
            var rate = $('#rate').val();

            var gstAmountNo = $('#gst_amount_no').val();
            var gst_no = $('#gst_no').val();
            var total = $('#total').val();


            var itemTypeIds =  "'" + itemTypeId + "'";
            var itemIds =  "'" + itemId + "'";

            var unitIds =  "'" + unitId + "'";
            var qtys =  "'" + qty + "'";

            var amounts =  "'" + amount + "'";
            var rates =  "'" + rate + "'";

            var gstAmountNos =  "'" + gstAmountNo + "'";
            var gst_nos =  "'" + gst_no + "'";

            var totals =  "'" + total + "'";
            var unitId_id = $('#unit_id_id').val();

            $('#purhaseDetail').append('<tr id="removeQty_'+randomQtyNO+'"><td>'+itemTypeName[1]+'<input type="hidden" name="itemTypeNames[]" value="'+itemTypeName[0]+'"></td><td><input type="hidden" name="itemNames[]" value="'+itemName[0]+'"> '+itemName[1]+'</td><td>'+unitId+'<input type="hidden" name="unitIds[]" value="'+unitIds+'"></td><td><input type="hidden" name="qtys[]" value="'+qty+'">'+qty+'</td><td><input type="hidden" name="rates[]" value="'+rate+'">'+rate+'</td><td><input type="hidden" name="amounts[]" value="'+amount+'">'+amount+'</td><td><input type="hidden" name="gst_nos[]" value="'+gst_no+'">'+gst_no+'</td><td><input type="hidden" name="gst_amount_nos[]" value="'+gstAmountNo+'">'+gstAmountNo+'</td><td><input type="hidden" name="totalss[]" value="'+total+'">'+total+'</td><td><a href="#" onclick="editQty('+randomQtyNO+','+itemTypeIds+','+itemIds+','+unitIds+','+qtys+','+rates+','+amounts+','+gst_nos+','+gstAmountNos+','+totals+')"><i class="text-dark-10 flaticon2-edit"  ></i></a>&nbsp;<a href="#" onclick="deleteQty('+randomQtyNO+')"><i class="text-dark-10 flaticon2-trash"></i></a></td></tr>');
            
            var qty = $('#qty').val();
            var rate = $('#rate').val();
            var amount = qty*rate;

            var totalAmount = $('#amount').val(amount.toFixed(2));
            var gstNo  = $('#gst_no').val();

            var gstPointAmountno = (gstNo*amount)/100;
            var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));

            var totalPoint = amount+(gstNo*amount)/100;
            var total = $('#total').val(totalPoint.toFixed(2));

            var totalssPoint = amount+(gstNo*amount)/100;
            var totalss = $('#totals').val(totalssPoint.toFixed(2));


            var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
            var totalsse = $('#totals').val();
            var otherCharges = $('#other_charges').val();
            var grandTotals = Number(totalsse) + Number(otherCharges);

            var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));

            
            var amount_arr = $("input[name='totalss[]']");

            var amount_total = 0;
            $.each(amount_arr, function (i, item) {
            //i=index, item=element in array
                if ($(item).val() !== '') {
                    amount_total += parseFloat($(item).val());

                }
            });
            
            var grandTotals = Number(amount_total) + Number(otherCharges);
            $('#totals').val(amount_total.toFixed(2));
            $('#grand_total').val(grandTotals.toFixed(2));
         
            clearPurchaseDetail();

        }

    }


    $("#item_type_idsssddd").on('change',function() {

     //   clearPurchaseDetail();

        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));
        
        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));
            
        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();
        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));


        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
            if ($(item).val() !== '') {
                amount_total += parseFloat($(item).val());

            }
        });


        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(amount_total.toFixed(2));
        
        
        var itemTypeId = $(this).val();
        var itemId = $(this).val();

        var itemTypeIdss = itemTypeId.split("_");
                
           /* 
        $.ajax({
            url:"{{ route('purchase.itemselectds') }}",
            type :'get',
            data : {   
                itemTypeId: itemTypeIdss[0],
            },
            success:function(result) {
                $('#unit_id').val(result);                
            }
        });*/


/*        $.ajax({
            url:"{{ route('purchase.itemgstselectds') }}",
            type :'get',
            data : {  
                itemTypeId: itemTypeIdss[0],
            },
            success:function(result){
                $('#gst_no').val(result);
            }
        });
*/
        $.ajax({
            url:"{{ route('purchase.itemunitselectd') }}",
            type :'get',
            data : {  
                itemTypeId: itemTypeIdss[0],
            },
            success:function(result){
                $('#item_id').html(result);
                $('#gst_no').val('');
                $('#unit_id').val('');
                $('#qty').val('');
                $('#rate').val('');
                $('#amount').val('');
                $('#total').val('');
                $('#gst_amount_no').val('');
                    
                
                   
            }
        });


    });

    $("#item_id").on('change',function() {
        
        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));
        
        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));
            
        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();
        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));
            

        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
            if ($(item).val() !== '') {
                amount_total += parseFloat($(item).val());

            }
        });

        
        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(amount_total.toFixed(2));
            
        
        var itemId = $(this).val();
        var itemName = itemId.split("_");
            


        $.ajax({
            url:"{{ route('purchase.itemselectd') }}",
            type :'get',
            data : {  
                itemId: itemName[0],
            },
            success:function(result) {
                $('#unit_id').val(result);
                $('#qty').val('');
                $('#rate').val('');
                 $('#qty').val('');
                $('#rate').val('');
                $('#amount').val('');
                $('#total').val('');
                $('#gst_amount_no').val('');
               
                
            }
        });
        
    });


    $("#item_id").on('change',function() {

        var itemId = $(this).val();
        var itemName = itemId.split("_");
            
        $.ajax({
            url:"{{ route('purchasegstitemId.roleSelected') }}",
            type :'get',
            data : {  
                itemId: itemName[0],
            },
            success:function(result) {
                $('#gst_no').val(result);
                $('#qty').val('');
                $('#rate').val('');
                $('#qty').val('');
                $('#rate').val('');
                $('#amount').val('');
                $('#total').val('');
                $('#gst_amount_no').val('');
               
                
            }
        });

    });

    function getQty() {

        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));
        
        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));
            
        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();

        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);


        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));



        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
            if ($(item).val() !== '') {
                amount_total += parseFloat($(item).val());

            }
        });



        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(amount_total.toFixed(2));
    }

    function getQtys() {
        var otherCharges = $('#other_charges').val();
        var totalsse = $('#totals').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));
    }



    function onlyDigit(evt) {
        evt = (evt) ? evt : window.event;
        var amount = (evt.which) ? evt.which : evt.keyCode;
        if (amount > 31 && (amount < 48 || amount > 57)) {
            return false;
        }
        return true;
    }
   // var dateToday = new Date();

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
    
    $('#kt_datetimepicker_7').datetimepicker({
      //  startDate: dateToday,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        startView: 2,
        minView: 2,
        forceParse: 0,
        pickerPosition: 'bottom-right'
    });


    function getDeletePurchaseDetail(purchaseDelId = null,purchaseId = null,totals = null,total=null,otherCharges=null,grandTotals=null) {

        if (purchaseDelId != null) {

            var result = confirm("Are you Want to delete?");
            if (result) {
                $("#removeQty_"+purchaseDelId).remove();
                                calculateGrandTotal();
                                setTimeout(function() {
                                    toastr.success(
                                        'Purchase Detail has been deleted.', 'Success!',
                                        { 
                                            "closeButton": true,
                                            timeOut: 3000 
                                        }
                                    );
                                }, 1000); 
                                        

                $.ajax({
                    url:"{{ route('purchase.deletes') }}",
                    type :'get',
                    data : {  
                        purchaseDelIds : purchaseDelId,
                        totalss : totals,
                        totalr : total,
                        otherChargess : otherCharges,
                        grandTotals : grandTotals,
                        purchaseIds : purchaseId,
                        
                            
                    },  
                    success:function(data)
                    {

                       // if (result == 1) {

                          //  }

                       // } else {

                            /*$("#purhaseDetail").html('<tr class="odd"><td valign="text-right" align="center" colspan="10" class="dataTables_empty">No data available in table</td></tr>');
                            */   

                      //  } 


                       // $('#other_charges').val(data);

                    
                    }

                });

            
             /*else {

                $("#purhaseDetail").html('<tr class="odd"><td valign="text-right" align="center" colspan="10" class="dataTables_empty">No data available in table</td></tr>');
                               
                                

            }*/



        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));

        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));

        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();
        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));


        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
        if ($(item).val() !== '') {
            amount_total += parseFloat($(item).val());

        }
        });

        var grandTotals = Number(amount_total) + Number(otherCharges);
        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(grandTotals.toFixed(2));
        
        clearPurchaseDetail();

}




        }
    }


    function calculateGrandTotal() {


        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
            if ($(item).val() !== '') {
                amount_total += parseFloat($(item).val());

            }
        });


              var  otherCharges     =    $('#other_charges').val();


        
        if (amount_total != 0) {    
            
            
            $('#totals').val(amount_total.toFixed(2));
            $('#grand_total').val(Number(amount_total.toFixed(2)) + Number(otherCharges));
                

        } else {


            $('#totals').val(amount_total.toFixed(2));
            $('#grand_total').val(amount_total.toFixed(2));
            $('#other_charges').val('0.00');
            
            

        }



/*
        $.ajax({
            url:"{{ route('otherCharge.otherCharges') }}",
            type :'get',
            data : {  
                purchaseIds: purchaseId,
            },
            success:function(result) {
                $('#other_charges').val(result);

            }
        });*/


    <?php 

        if (!empty($getPurhaseData->id)) {
            $otherCharges = 0;
            $purchaseData = DB::select('SELECT * FROM purchase_master WHERE is_deleted_status = "N" AND id = '.$getPurhaseData->id.'');
            $otherCharges  = !empty($purchaseData[0]->other_charges) ?  $purchaseData[0]->other_charges : '0.00';        
            //echo $otherCharges;
    
        ?>
            
            //$('#other_charges').val('<?php echo $otherCharges; ?>');
    


    <?php
        }
    ?>  
    

    }


   /* function getEditPurchaseDetail(challanDelId = null,description = null,quantity = null,price = null,amount= null) 
    {

        var totalAmount = amount;
        $('#disabledButtonChallan').html('<button type="submit" disabled  class="btn btn-primary" id="button_right">Save</button>');
          var totalAmounts = quantity*price;
            var totalAmount =  totalAmounts.toFixed(2);
         //   var priced =  price;

           // var price = priced+".00";
        var newDescription =  "'" + description + "'";
        $('#removeQty_'+challanDelId).html('<td><input class="form-control" oninput="getDescription(this)"  type="text" id="description_'+challanDelId+'" value='+newDescription+' ></td><td><input type="text" class="form-control"   oninput="getEditQuantity(this,'+challanDelId+')" oninput="getEditQuantityOnblur(this,'+challanDelId+')"  onkeypress="return onlyDigit(event)" id="quantity_'+challanDelId+'" value='+quantity+'></td><td><input type="text" id="price_'+challanDelId+'" class="form-control" oninput="getEditPrice(this,'+challanDelId+')" oninput="getEditPriceOnblur(this,'+challanDelId+')"  value='+price+'></td><td id="challanAmount_'+challanDelId+'"><input class="form-control" type="text" value='+totalAmount+' id="totalAmount_'+challanDelId+'" disabled  ></td><td><button onclick="editChallanDetail('+challanDelId+')" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button> <a  class="btn btn btn-danger btn-xs" href="#" onclick="deleteQty('+challanDelId+')" ><i class="fa fa-remove"></i></a></td><td style="display:"none"" id="removeQty1_'+challanDelId+'"> <b style="color:red">Please add Challan Detail</b>  </td>');
            $('#removeQty1_'+challanDelId).hide();

    }

*/


/*    var app = angular.module("myApp", ['datatables']);

    app.controller("mainCtrl", function($scope,$http) {
        
        $scope.ItemFormData = {};
        $scope.isInsert = true;
        
        $scope.fetchItemData = function() {
            $http.get("{{route('item.view')}}").success(function(data) {
                $scope.itemData = data;
            });     
        };

        $scope.showItemData = function(data) {
            $('#emptyName').hide(); 
            $('#emptyGst').hide(); 
            
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
        };

        $scope.updateItemData = function(data) {
            
            var name = $('#name').val();
            var gst = $('#gst').val();
            var itemTypeId = $('#kt_select2_3_modal_1').val();
            var itemCategoryId = $('#kt_select2_3_modal_2').val();
            var unit = $('#kt_select2_3_modal_3').val();

            if (name == '' || gst == '' ||  itemCategoryId == '' ) {
                
                if (name == '') {
                    $('#emptyName').show();
                    $('#emptyName').html('Item Name field is Required.');
                } else {
                    $('#emptyName').hide();
                }   
                
                if (gst == '') {
                    $('#emptyGst').show();
                    $('#emptyGst').html('GST field is Required.');
                } else {
                    $('#emptyGst').hide();
                }
            } else {
                
                data.itemTypeId = itemTypeId;
                data.itemCategoryId = itemCategoryId;
                data.unit_id = unit;
                
                $("#lorderId").attr("disabled", true);
                $("#cancelId").attr("disabled", true);
                $("#lorderId").html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Updating');

                $http.post("{{route('item.edit')}}",data).success(function(data) {
                    
                    if (data.nameText == 'nameText') {
                        
                        $("#lorderId").attr("disabled", false);
                        $("#cancelId").attr("disabled", false);
                        $("#lorderId").html('Update');
                        
                        if (data.nameText == 'nameText') {
                            $('#emptyName').show();
                            $('#emptyName').html('The Item Name has already been taken.');
                        } else {
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
        };

        $scope.addItemData = function(data) {

            var name = $('#name').val();
            var gst = $('#gst').val();
            var itemTypeId = $('#kt_select2_3_modal_1').val();
            var itemCategoryId = $('#kt_select2_3_modal_2').val();
            var unit = $('#kt_select2_3_modal_3').val();
                

            if (name == '' || gst == '' ||  itemCategoryId == '' ) {
                
                if (name == '') {
                    $('#emptyName').show();
                    $('#emptyName').html('Item Name field is Required.');
                } else {
                    $('#emptyName').hide();
                }   
                
                if (gst == '') {
                    $('#emptyGst').show();
                    $('#emptyGst').html('GST field is Required.');
                } else {
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
                
                            
                $http.post("{{route('item.add')}}",data).success(function(data) {
                    
                    $("#lorderId").attr("disabled", false);
                    $("#cancelId").attr("disabled", false);
                    $("#lorderId").html('Save');
                    
                    if (data.nameText == 'nameText') {

                        if (data.nameText == 'nameText') {

                            $('#emptyName').show();
                            $('#emptyGst').hide();
                            $('#emptyName').html('The Item Name has already been taken.');
                      
                        } else {

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
                    }

                }); 
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

        $scope.resetItemForm = function() {
            $scope.isInsert = true;
            $('#emptyName').hide();
            $('#emptyGst').hide();
            var name = $('#name').val('');
            var name = $('#gst').val('');

            
        };

    });
*/


    function editQty(randomQtyNO=null,itemTypeId=null,itemId=null,unitId=null,qty=null,rate=null,amount=null,gst_no=null,gstAmountNo=null,total=null) {

        var itemNameTypeId = itemTypeId.split("_");
        var itemIds = itemId.split("_");
        
        $.ajax({
            url:"{{ route('purchase.itemunitselectd') }}",
            type :'get',
            data : {  
                itemTypeIdss: itemNameTypeId[0],
            },
            success:function(result){
                $('#item_type_idsssddd').html(result);
            }
        });


        $.ajax({
            url:"{{ route('purchase.itemunitselectd') }}",
            type :'get',
            data : {  
                itemIdss: itemIds[0],
                itemTypeIdssd: itemNameTypeId[0],
                
            },
            success:function(result){
                $('#item_id').html(result);
            }
        });
        
        
        var qty = $('#qty').val(qty);
        var rate = $('#rate').val(rate);
        var gst_no = $('#gst_no').val(gst_no);
        var gst_amount_no = $('#gst_amount_no').val(gstAmountNo);
        var name = $('#total').val(total);  
        var amount = $('#amount').val(amount);
        var unitId = $('#unit_id').val(unitId);

        $("#addId").html('<label for="exampleInputEmail1" class="col-md-6"></label><button type="reset" onclick="editPurhaseDetail('+randomQtyNO+')" class="btn btn-primary mr-2"><i class="text-dark-10 flaticon2-edit icon-sm"></i></button>');

    }

    function editPurhaseDetail(randomQtyNO=null) {

        var itemTypeId = $('#item_type_idsssddd').val();
        var itemId = $('#item_id').val();
        
        var unitId = $('#unit_id').val();
        var qty = $('#qty').val();
        var amount = $('#amount').val();
        var rate = $('#rate').val();
        var gstAmountNo = $('#gst_amount_no').val();
        var gst_no = $('#gst_no').val();
        var total = $('#total').val();

        var itemTypeIds =  "'" + itemTypeId + "'";
        var itemIds =  "'" + itemId + "'";
        var unitIds =  "'" + unitId + "'";
        var qtys =  "'" + qty + "'";
        var amounts =  "'" + amount + "'";
        var rates =  "'" + rate + "'";
        var gstAmountNos =  "'" + gstAmountNo + "'";
        var gst_nos =  "'" + gst_no + "'";
        var totals =  "'" + total + "'";
        var itemTypeName = itemTypeId.split("_");
        var itemId = $('#item_id').val();
        var itemName = itemId.split("_");
        var unitId_id = $('#unit_id_id').val();


        $('#removeQty_'+randomQtyNO).html('<td>'+itemTypeName[1]+'<input type="hidden" name="itemTypeNames[]" value="'+itemTypeName[0]+'"></td><td><input type="hidden" name="itemNames[]" value="'+itemName[0]+'"> '+itemName[1]+'</td><td>'+unitId+'<input type="hidden" name="unitIds[]" value="'+unitIds+'"></td><td><input type="hidden" name="qtys[]" value="'+qty+'">'+qty+'</td><td><input type="hidden" name="rates[]" value="'+rate+'">'+rate+'</td><td><input type="hidden" name="amounts[]" value="'+amount+'">'+amount+'</td><td><input type="hidden" name="gst_nos[]" value="'+gst_no+'">'+gst_no+'</td><td><input type="hidden" name="gst_amount_nos[]" value="'+gstAmountNo+'">'+gstAmountNo+'</td><td><input type="hidden" name="totalss[]" value="'+total+'">'+total+'</td><td><a href="#" onclick="editQty('+randomQtyNO+','+itemTypeIds+','+itemIds+','+unitIds+','+qtys+','+rates+','+amounts+','+gst_nos+','+gstAmountNos+','+totals+')"><i class="text-dark-10 flaticon2-edit"  ></i></a>&nbsp;<a href="#" onclick="deleteQty('+randomQtyNO+')"><i class="text-dark-10 flaticon2-trash"></i></a></td>');

        $("#addId").html('<label for="exampleInputEmail1" class="col-md-6"></label><button type="reset" onclick="addPurhaseDetail()" class="btn btn-primary mr-2"><i class="ki ki-plus icon-sm"></i></button>');

        var itemTypeId = $('#item_type_idsssddd').val();
        var itemId = $('#item_id').val();
        var unitId = $('#unit_id').val('');
        var qty = $('#qty').val('');
        var amount = $('#amount').val('');
        var rate = $('#rate').val('');
        var gstAmountNo = $('#gst_amount_no').val('');
        var gst_no = $('#gst_no').val('');
        var total = $('#total').val('');    

        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));

        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));

        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();
        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));


        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
        if ($(item).val() !== '') {
            amount_total += parseFloat($(item).val());

        }
        });
        
        /*$('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(amount_total.toFixed(2));
        */
        var grandTotals = Number(amount_total) + Number(otherCharges);
        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(grandTotals.toFixed(2));
        
        /*$('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(amount_total.toFixed(2));
        */

        clearPurchaseDetail();

    }
    
    function deleteQty(randomQtyNO = null) {
        var result = confirm("Are you Want to delete?");
        if (result) {
            setTimeout(function() {
                toastr.success(
                    'Purchase Detail has been deleted.', 'Success!',
                    { 
                        "closeButton": true,
                        timeOut: 3000 
                    }
                );
            }, 1000);
            $("#removeQty_"+randomQtyNO).remove();
        }


        var qty = $('#qty').val();
        var rate = $('#rate').val();
        var amount = qty*rate;

        var totalAmount = $('#amount').val(amount.toFixed(2));
        var gstNo  = $('#gst_no').val();

        var gstPointAmountno = (gstNo*amount)/100;
        var gstAmountNo = $('#gst_amount_no').val(gstPointAmountno.toFixed(2));

        var totalPoint = amount+(gstNo*amount)/100;
        var total = $('#total').val(totalPoint.toFixed(2));

        var totalssPoint = amount+(gstNo*amount)/100;
        var totalss = $('#totals').val(totalssPoint.toFixed(2));


        var totalGrand = $('#grand_total').val(amount+(gstNo*amount)/100);
        var totalsse = $('#totals').val();
        var otherCharges = $('#other_charges').val();
        var grandTotals = Number(totalsse) + Number(otherCharges);
        var grandTotal = $('#grand_total').val(grandTotals.toFixed(2));


        var amount_arr = $("input[name='totalss[]']");
        var amount_total = 0;
        $.each(amount_arr, function (i, item) {
        //i=index, item=element in array
        if ($(item).val() !== '') {
            amount_total += parseFloat($(item).val());

        }
        });

        var grandTotals = Number(amount_total) + Number(otherCharges);
        $('#totals').val(amount_total.toFixed(2));
        $('#grand_total').val(grandTotals.toFixed(2));
        
        clearPurchaseDetail();

    }

    function clearPurchaseDetail() {

        <?php

            $itemTypeNameHtml = '';
            $itemNameHtml = '';

            $getItemTypeDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id = 1 ORDER BY id ASC  LIMIT 1'); 
            if (!empty($getItemTypeDatas)) {
                $gst = !empty($getItemTypeDatas[0]->gst) ? $getItemTypeDatas[0]->gst : '';
        ?>
                var rate = $('#gst_no').val(<?php //echo $gst;?>);
                <?php 
            
            }
        ?>      

        <?php
        $purchaseListHtml1 = '';
        $finalItemNameHtml = '';
            $getItemData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id = 1');
            if (!empty($getItemData)) {
                                $purchaseListHtml1  =  '<option value=""> Select Item Name</option>';

                foreach ($getItemData as $item) {  
                    $itemNameHtml .= '<option value="'.$item->id.'_'.$item->name.'">'.$item->name.'</option>';
                } 

                $finalItemNameHtml = $purchaseListHtml1.$itemNameHtml; 

            }
        ?>

        <?php
            $getItemTypeData = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');
            if (!empty($getItemTypeData)) {
                foreach ($getItemTypeData as $itemType) {  
                    $itemTypeNameHtml .= '<option value="'.$itemType->id.'_'.$itemType->name.'">'.$itemType->name.'</option>';
                } 
            }
        ?>  


        $('#item_type_idsssddd').html('<?php echo $itemTypeNameHtml; ?>');
       
        $('#item_id').html('<?php echo $finalItemNameHtml; ?>');


        var rate = $('#rate').val('');
        var qty = $('#qty').val('');
        var amount = $('#amount').val('');
        var gst_amount_no = $('#gst_amount_no').val('');
        var total = $('#total').val('');
        var gst_no = $('#gst_no').val('');
        var unit_id = $('#unit_id').val('');
                    



    }


</script>

</body>
</html>

