@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        
                        <!--<form class="form">
                        -->        
                            <div class="card-body">
                                <style type="text/css">
                                    .abc {
                                        font-size: 12px;
                                    }
                                    
                                </style>
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
                                <div>   
                                    <table class="table table-striped table-bordered display" id="default_order">
                                        <thead>
                                            <tr>
                                                <!-- <th>No.</th> -->
                                                <th>PO.No.</th>
                                                <th>PO. Date</th>
                                                <th>Party Name</th>
                                                <th style="color:black !important; ">Item Name</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                                <th>Job Card</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $getPurchaseOrderData = [];
                                                $getPurchaseOrderData = DB::table('purchase_order')
                                                  ->select('*')
                                                  ->where('is_deleted_status', 'N')
                                                  ->orderBy('po_no', 'DESC')
                                                  ->get()
                                                  ->toArray();

                                                if (!empty($getPurchaseOrderData)) {

                                                    $i = 0;
                                                    $j = 1;
                                                    foreach ($getPurchaseOrderData as $key => $itemData) {

                                                        $itemNames = [];
                                                        $itemNamesId = [];
                                                        $itemCategoryId = [];
                                                        $itemCatName = [];
                                                        $partyNames = [];
                                                        $itemCatNameId = [];

                                                        $getJobCardData = DB::table('job_card')
                                                            ->select('*')
                                                            ->where('is_deleted_status', 'N')
                                                            ->where('po_id', $itemData->id)
                                                            ->where('item_id', $itemData->item_id)
                                                            ->get()
                                                            ->toArray();

                                                        if (!empty($getJobCardData)) {
                                                            foreach ($getJobCardData as $key => $jobCardData) { 
                                                                $getPurchaseOrderData[$key]->jobCardNo = !empty($jobCardData->job_card_no) ? $jobCardData->job_card_no : '';
                                                            }
                                                        }

                                                        $itemUnitData = DB::table('item_master')
                                                           ->select('*')
                                                           ->where('is_deleted_status', 'N')
                                                           ->where('id', $itemData->item_id)
                                                           ->get()
                                                           ->toArray();

                                                        if (!empty($itemUnitData)) {
                                                            foreach ($itemUnitData as  $unitType) {
                                                                $itemNames[] = !empty($unitType->name) ? $unitType->name : '';
                                                                $itemNamesId[] = !empty($unitType->id) ? $unitType->id : '';
                                                                $itemCategoryId[] = !empty($unitType->item_category_id) ? $unitType->item_category_id : 0;
                                                            }
                                                        }
                                                        
                                                      $itemCategoryIdss = !empty($itemCategoryId[$i]) ? $itemCategoryId[$i] : 0;
                                                        
                                                        $itemCatData = DB::table('item_category_master')
                                                          ->select('*')
                                                          ->where('is_deleted_status', 'N')
                                                          ->where('id', $itemCategoryIdss)
                                                          ->get()
                                                          ->toArray();


                                                        if (!empty($itemCatData)) {
                                                            foreach ($itemCatData as $key => $itemCat) { 
                                                                $itemCatName[] = !empty($itemCat->name) ? $itemCat->name : 0;
                                                                $itemCatNameId[] = !empty($itemCat->id) ? $itemCat->id : 0;
                                                                   
                                                            }
                                                        }

                                                        $partyUserData = DB::table('user_master')
                                                          ->select('*')
                                                          ->where('is_deleted_status', 'N')
                                                          ->where('id', $itemData->party_id)
                                                          ->where('user_type', 3)
                                                          ->get()
                                                          ->toArray();

                                                        if (!empty($partyUserData)) {

                                                            foreach ($partyUserData as  $partyNameData) {

                                                                $partyNames[] =  
                                                        !empty($partyNameData->party_name) ? $partyNameData->party_name : 0;


                                                            } 
                                                        }
                                                        

                                                      
                                                        ?>

                                                        <tr id="getUserByDateId_{{$itemData->id}}" style="background-color: white">
                                                            <!-- <td>{{$j}}</td>
                                                             -->

                                                            <td>{{$itemData->po_no}}</td>
                                                            <td>{{$itemData->po_date}}</td>
                                                            <td>{{!empty($partyNames[$i]) ? $partyNames[$i] : '' }}</td>
                                                            <td>{{!empty($itemNames[$i]) ? $itemNames[$i] : '' }}</td>
                                                            <td>{{$itemData->qty}}</td>  
                                                            <td>
                                                                <a href="#" onclick="showPurchaseData({{$itemData->id}})"> 
                                                                    <i class="text-dark-10 flaticon2-edit"></i>
                                                                </a>
                                                                <a href="#" onclick="deletePurchaseData({{$itemData->id}})" >
                                                                    <i class="text-dark-10 flaticon2-trash"></i>
                                                                </a>

                                                                <a href="#" onclick="pdfPurchaseData({{$itemData->id}})">
                                                                    <i class="text-dark-10 flaticon2-file-1"></i>
                                                                </a> 
                                                            </td>

                                                            <td>
                                                            <?php   
                                                            

                                $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');
                                $jobCardNos  =   !empty($getTicketAttachmentDatas[0]->job_card_no) ? $getTicketAttachmentDatas[0]->job_card_no : 0;
                                if (!empty($jobCardNos)) {
                                   
                                   ?>
                                                                <a href="#" class="btn-sm btn-success btn-shadow-hover font-weight-bolder" 
                                                                    data-toggle="modal" data-target="#exampleModalSizeLg_{{$itemData->id}}">View
                                                                </a>


                                                            <?php 
                                                        } else {
                                                             ?>

                                                                <a href="#" class="btn-sm btn-success btn-shadow-hover font-weight-bolder" 
                                                                    data-toggle="modal" data-target="#exampleModalSizeLg_{{$itemData->id}}">Create
                                                                </a>
                                                                

                                                         <?php } ?>

                                                                <div class="modal fade" id="exampleModalSizeLg_{{$itemData->id}}" 
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true"
                                                                    data-toggle="modal" data-backdrop="static" data-keyboard="false">


                                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

                                                                        <div class="modal-content">
                                                                                
                                                                            <button type="button" style="margin-left: 48%" class="close col-md-12" 
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close" style="font-size: 11px;"></i>
                                                                            </button>

                                                                                         
                                                                            <div class="modal-header" style="padding: 0.5rem 0.75rem;border:none">


                                                                                <div class="row">
                                                                                    <style type="text/css">
                                                                                        .tds {
                                                                                            width: 140px;
                                                                                        }

                                                                                        .table-hover tbody tr:hover {
                                                                                          color: #3F4254;
                                                                                            background-color:#fff;
                                                                                           width: 100px;
                                                                                        }
                                                                                            
                                                                                        .table-bordereds {
                                                                                            border-collapse: initial;
                                                                                        }

                                                                                        .table-bordereds th, .table-bordereds td {
                                                                                            border:none;
                                                                                        }

                                                                                        .form-group label {
                                                                                            font-size: 8px;
                                                                                        }
                                                                                    </style>
                                                                                        




                                                                            <style type="text/css">
                                                                                .my-custom-scrollbar {
                                                                                    position: relative;
                                                                                    height: 317px;
                                                                                    overflow: auto;

                                                                                }
                                                                                .table-wrapper-scroll-y {
                                                                                    display: block;
                                                                                }

                                                                                .padding0tbl th,
                                                                                .padding0tbl td {
                                                                                padding: 0px 5px 0px 5px !important;
                                                                                }

                                                                                .padding0tbl th, .padding0tbl td{    
                                                                                    vertical-align: middle;
                                                                                }   

                                                                            </style>
                                                                            <?php /*

                                                                            <div class="modal-body">
                                                                                <div class="my-custom-scrollbar">
                                                                                    <table class="padding0tbl table table-bordered table-hover table-checkable col-lg-12">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Item Name</th>
                                                                                                <th>Item Category Name</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td> {{ !empty($itemNames[$i]) ? $itemNames[$i] : ''  }}</td>
                                                                                                <td>{{ !empty($itemCatName[$i]) ? $itemCatName[$i] : '' }}</td>
                                                                                            </tr>    
                                                                                        </tbody>
                                                                                    </table>

                                                                                    <table class="padding0tbl table table-bordered table-hover table-checkable col-lg-12">
                                                                                        <tbody>

                                                                                            <tr>

                                <td> 
                                    
                                    Job Card No :  <?php   

                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                    $jobCardNos  =   !empty($getTicketAttachmentDatas[0]->job_card_no) ? $getTicketAttachmentDatas[0]->job_card_no : 0;
                                        
                                    if (!empty($jobCardNos)) {

                                          $bookNoFinal = $jobCardNos;

                                    } else {

                                        $jobCardQuery = DB::select('SELECT MAX(job_card_no) as  jobCardNo FROM job_card WHERE is_deleted_status = "N"');
                                        if (!empty($jobCardQuery)) {
                                            $bookNoFinal = $jobCardQuery[0]->jobCardNo + 1;
                                        }                                                                                                     
                                    }
                                    ?>

                                        <input type="hidden" id="job_card_no_{{$itemData->id}}" name="job_card_no" class="form-control borderred"
                                                            placeholder="Job Card No" value="{{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}" >
                                        {{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}

                                </td>





                                                                                                <td> 


                                                                                              Date :  <?php 

                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                    $jobCardDate  = !empty($getTicketAttachmentDatas[0]->job_card_date) ? $getTicketAttachmentDatas[0]->job_card_date : 0;
                                        
                                        ?>

                            <input type="text"  name="job_card_date" class="form-control borderred"   placeholder="Job Card Date"  
                                        id="kt_datetimepicker_6_{{$itemData->id}}" value="{{ !empty($jobCardDate) ? $jobCardDate : date('d-m-yy') }}" style="width:140px;">

                                        

                                                                                            </td>




                                                                                            </tr>  



                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>        
                                                                                     */
                                                                                     ?>   

                                                                                            

                                                                                                                  
                      
                            


                                                                                <?php /*

                                                                                
                                                                                    <table class="pull-right col-md-12 table-bordereds" >

                                                                                        <tbody>


                                                                                            <tr>

                                                                                <td class="tds"><strong>Item Name</strong></td>

                                                                            <td><strong> : </strong> </td>

                                                                            <td>
                                                                                                    {{ $itemNames[$i] }}

                                                                <input type="hidden" id="item_id_{{$itemData->id}}" 
                                                                    name="item_id_{{$itemData->id}}" class="form-control borderred" placeholder="Item Name" 
                                                                                    value="{{ !empty($itemNamesId[$i]) ? $itemNamesId[$i] : $itemNamesId[$i] }}" >

                                                                                                    
                                            <input type="hidden" id="po_id_{{$itemData->id}}" name="po_id_{{$itemData->id}}" class="form-control borderred" placeholder="PoId" value="{{ !empty($itemData->id) ? $itemData->id : $itemData->id }}" >


                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td class="tds"><strong>Item Category Name</strong></td>
                                                                                                <td><strong> : </strong></td>

                                                                                                <td>
                                                                                                    {{ $itemCatName[$i] }}

                                                                                                    <input type="hidden" id="item_category_id_{{$itemData->id}}"name="item_category_id_{{$itemData->id}}" class="form-control borderred"
                                                                                                    placeholder="Item Category Name" value="{{ !empty($itemCatNameId[$i]) ? $itemCatNameId[$i] : $itemCatNameId[$i] }}" >


                                                                                                </td>


                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td class="tds"><strong>Job Card No</strong></td>
                                                                                                <td><strong> : </strong> </td>
                                                                                                <td>
                                                                                                    <?php   

                                $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                    $jobCardNos  =   !empty($getTicketAttachmentDatas[0]->job_card_no) ? $getTicketAttachmentDatas[0]->job_card_no : 0;
                                        
                                    if (!empty($jobCardNos)) {

                                          $bookNoFinal = $jobCardNos;

                                    } else {

                                        $jobCardQuery = DB::select('SELECT MAX(job_card_no) as  jobCardNo FROM job_card WHERE is_deleted_status = "N"');


                                                                                                        if (!empty($jobCardQuery)) {

                                                                                                            $bookNoFinal = $jobCardQuery[0]->jobCardNo + 1;
                                                                                                            
                                                                                                        }                                                                                                     }



                                                                                                    ?>

                                        <input type="hidden" id="job_card_no_{{$itemData->id}}" name="job_card_no" class="form-control borderred"
                                                            placeholder="Job Card No" value="{{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}" >

                                                                                                    {{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}

                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td class="tds"><strong>Date</strong></td>
                                                                                                <td><strong> : </strong></td>
                                                                                                <td>
                                                                                        <?php 

                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                    $jobCardDate  = 
                                    !empty($getTicketAttachmentDatas[0]->job_card_date) ? $getTicketAttachmentDatas[0]->job_card_date : 0;
                                    
                                        



                                                                                        ?>

                            <input type="text"  name="job_card_date" class="form-control borderred"   placeholder="Job Card Date"  
                                        id="kt_datetimepicker_6_{{$itemData->id}}" value="{{ !empty($jobCardDate) ? $jobCardDate : date('d-m-yy') }}" style="width:140px;">


                                                                                                </td>   
                                                                                            </tr>



                                                                                        </tbody>
                                                                                    </table>
                                                                             */?>



                                                                                </div>
                                                                            </div>

<!--                                                                             <div class="modal-header" 
                                                                                style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-8 col-form-label">
                                                                                                <b class="abc">Item Category Name :</b> 
                                                                                            </label>
                                                                                            <div class="col-md-4">
                                                                                                {{ !empty($itemCatName[$i]) ? $itemCatName[$i] : 0 }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="modal-header" style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-8  
                                                                                                col-form-label">
                                                                                                <b class="abc">Job Card No : </b> 
                                                                                            </label>
                                                                                            <div class="col-md-4">
                                                                                                <?php   

                                                                                                    $jobCardQuery = DB::select('SELECT MAX(job_card_no) as  
                                                                                                    jobCardNo FROM job_card WHERE is_deleted_status = "N"');

                                                                                                    $jobCardNo = $jobCardQuery[0]->jobCardNo;
                                                                                                    if (!empty($jobCardQuery)) {
                                                                                                        if (empty($jobCardNo)) {
                                                                                                            $bookNoFinal = 1;
                                                                                                        } else {
                                                                                                            $bookNoFinal = $jobCardNo + 1;
                                                                                                        }
                                                                                                    }
                                                                                                ?>

                                                                                                <input type="text" id="po_no" name="po_no" class="form-control borderred"
                                                                                                id="inputEmail3"  placeholder="PO. No" value="{{ !empty($jobCardQuery->po_no) ? $jobCardQuery->po_no : $bookNoFinal }}" readonly="">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-header" style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-6  
                                                                                                col-form-label">
                                                                                                <b class="abc">Date : </b> 
                                                                                            </label>
                                                                                            <div class="col-md-6">
                                                                                                <input type="text"  name="job_card_date" 
                                                                                                class="form-control borderred"   placeholder="Date"  
                                                                                                id="kt_datetimepicker_6_{{$itemData->id}}"  
                                                                                                value="{{ date('d-m-yy') }}" >

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
 -->





                                                                            <style type="text/css">
                                                                                .my-custom-scrollbar {
                                                                                    position: relative;
                                                                                    height: 317px;
                                                                                    overflow: auto;

                                                                                }
                                                                                .table-wrapper-scroll-y {
                                                                                    display: block;
                                                                                }

                                                                                .padding0tbl th,
                                                                                .padding0tbl td {
                                                                                padding: 0px 5px 0px 5px !important;
                                                                                }

                                                                                .padding0tbl th, .padding0tbl td{    
                                                                                    vertical-align: middle;
                                                                                }   

                                                                            </style>

                                            <div class="modal-body">
                                                            <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                                                                                                enctype="multipart/form-data" autocomplete="off" action="{{route('jobcard.add')}}">
                                                                                                
                                                                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                                                                                <input type="hidden" name="po_id" id="po_id" value="{{ !empty($itemData->id) ? $itemData->id :  0 }}">
                                                                        
                                                                                <div class="row" style="margin-top: -40px;">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <span class="control-label"><strong>Item Name</strong></span>
                                                                                            <div>
                                                                                                <span>
                                                                                                    {{ !empty($itemNames[$i]) ? $itemNames[$i] : 0 }}

                                                                                                    <input type="hidden" id="item_id_{{$itemData->id}}" 
                                                                                                    name="item_id_{{$itemData->id}}" class="form-control borderred" 
                                                                                                    placeholder="Item Name" 
                                                                                                    value="{{ !empty($itemNamesId[$i]) ? $itemNamesId[$i] : 0 }}" >

                                                                                                
                                                                                                    <input type="hidden" id="po_id_{{$itemData->id}}" 
                                                                                name="po_id_{{$itemData->id}}" 
                                                                                                    class="form-control borderred" placeholder="PoId" 
                                                                                                    value="{{ !empty($itemData->id) ? $itemData->id : $itemData->id }}" >
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <span class="control-label"><strong>Item Category Name</strong></span>
                                                                                            <div>
                                                                                                <span>{{ !empty($itemCatName[$i]) ? $itemCatName[$i] : 0  }}
                                                                                                <input type="hidden" id="item_category_id_{{$itemData->id}}" 
                                                                                                name="item_category_id_{{$itemData->id}}" 
                                                                                                class="form-control" placeholder="Item Category Name" 
                                                                                                value="{{ !empty($itemCatNameId[$i]) ? $itemCatNameId[$i] 
                                                                                                : 0 }}" >
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="row" style="margin-top:12px;">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <span class="control-label"><strong>Job Card No :</strong>
                                                                                                <?php   
                                                                                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                                                                                    $jobCardNos  =   !empty($getTicketAttachmentDatas[0]->job_card_no) ? $getTicketAttachmentDatas[0]->job_card_no : 0;
                                        
                                                                                                    if (!empty($jobCardNos)) {
                                                                                                        $bookNoFinal = $jobCardNos; 
                                                                                                    } else {

                                                                                                        $jobCardQuery = DB::select('SELECT MAX(job_card_no) as  jobCardNo FROM job_card WHERE is_deleted_status = "N"');
                                                                                                        if (!empty($jobCardQuery)) {

                                                                                                            $bookNoFinal = $jobCardQuery[0]->jobCardNo + 1;
                                                                                                            
                                                                                                        }
                                                                                                    }
                                                                                                ?>

                                                                                                    <input type="hidden" id="job_card_no_{{$itemData->id}}" 
                                                                                name="job_card_no_{{$itemData->id}}"
                                                                                                                     class="form-control borderred"
                                                                                                    placeholder="Job Card No" value="{{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}" >

                                                                                                    {{ !empty($bookNoFinal) ? $bookNoFinal : 1 }}
                                                                                            </span>

                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <span class="control-label"><strong>Date : </strong>
                                                                                                 <?php 

                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                    $jobCardDate  = !empty($getTicketAttachmentDatas[0]->job_card_date) ? $getTicketAttachmentDatas[0]->job_card_date : 0;
                                    
                                    ?>

                                    <input type="text"  
                                    name="job_card_date_{{$itemData->id}}" class="form-control borderred"   placeholder="Job Card Date"  
                                        id="kt_datetimepicker_6_{{$itemData->id}}" value="{{ !empty($jobCardDate) ? $jobCardDate : date('d-m-yy') }}" 
                                        style="width:140px;margin-top:-31px;margin-left:44px;">

                                        </span>
                                                                                       
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                
                                                                          


                                                <div class="clearfix"></div>







                                                                                        
                                                                                <div class="my-custom-scrollbar" >



                                                                                <table class="padding0tbl table table-bordered table-checkable col-lg-12" id="kt_datatable" >
                                                                                    <thead>
                                                                                        <tr style="background-color: white">
                                                                                                   <th>No.</th>
                                                                                    <th style="width: 97px;">Process Name</th>
                                                                                                                    <th style="width: 156px;">Machine</th>
                                                                                                                    <th style="width: 80px;">Date</th>
                                                                                                                    <th>Note</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                        <?php

                                        $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" AND po_id = '.$itemData->id.'');

                                            $jobCardId  =  !empty($getTicketAttachmentDatas[0]->id) ? $getTicketAttachmentDatas[0]->id : 0;
                                                                    


                                                                                                $processIdArrs = [];
                                                                                                $process_datesArr = [];
                                                                                                $noteArrs = [];
                                                            $machine_idArr = [];
                                                                                                                                                        
                                                                                                
                                                                
                                $jobCardProcessListArr = DB::select('SELECT * FROM job_card_process_list WHERE is_deleted_status = "N" 
                                AND job_card_id = '.$jobCardId.' ');



                                                                                            if (!empty($jobCardProcessListArr)) {
                                                                                                foreach ($jobCardProcessListArr as $jobProcess) { 
                                                                                                    $processIdArrs[] = $jobProcess->process_id;
                                                                                                    $process_datesArr[] = $jobProcess->process_date;
                                                                                                    $noteArrs[] = $jobProcess->note;
                                                                                                    
                                                                                                      $machine_idArr[] = $jobProcess->machine_id;
                                                                                                }
                                                                                            }

                                                                               



                            $process_item_category_master = DB::select('SELECT * FROM 
                            process_item_category_master WHERE is_deleted_status = "N" 
                                AND item_category_id = '.$itemCategoryIdss.'');


                                    $processIdArr = [];
                                    if (!empty($process_item_category_master)) {
                                        foreach ($process_item_category_master as $process_item_categorys) { 
                                            $processIdArr[] = $process_item_categorys->process_id;

                                        }
                                    }


                                                                                            $processIds = implode(',', $processIdArr);
                                                                                            $processIds = !empty($processIds) ? $processIds : 0; 
                                                                                             $process_masters = DB::select('SELECT * FROM process_master 
                                                                                             WHERE is_deleted_status = "N" 
                                                                                            AND id IN('.$processIds.') ');

                                                                                            if (!empty($process_masters)) {

                                                                                                $k = 1;
                                                                                                $u = 0;
                                                                            foreach ($process_masters as $process) {
                                                                    $machine_idArrs = 
                        !empty($machine_idArr[$u]) ?  $machine_idArr[$u] : 0;
                                                                                                                    
                                                                                                                    
                                                                                
                                                                                            ?>
                                                                                                    
                                                                                                    <tr id="removeQty_<?php //echo $purchaseDetails->id; ?>" style="background-color: white">
                                                                                                        <td><?php echo $k;?></td>

                                                                                                        <td>
                                                                                                            <div style="cursor: none;" class="btn-sm btn-dark">
                                                                                                                <?php echo $process->name;?>

                                                                                        <input type="hidden" id="process_id_{{$itemData->id}}" 
                                                                                     name="process_id_{{$itemData->id}}[]" class="form-control borderred" placeholder="ProcessId" value="{{ !empty($process->id) ? $process->id : 0 }}" > 

                                                                                                            </div>
                                                                                                        </td>
                    
                    
                                                                                                                                <td>

                                                                                <select class="form-control form-control" 
                                                                                name="machineId_{{$itemData->id}}[]" 
                                                                                id="kt_select2_3_modal_1_machine_{{$process->id}}_{{$itemData->id}}" >   
                                                                                                

                                                                                        <?php 
                                                                                       // if (empty($machine_idArr)) {
                                                                                        ?>

                                                                                             <option value=""></option>

                                                                                        <?php 

                                                                                     //   }
                                                                                        ?>

                                                                                        <?php


                                                                                      

                                                                                        $getMachineData = DB::select('SELECT * FROM machine_master WHERE 
                                                                                        is_deleted_status = "N" AND is_status = "Y" ');
                                                                                            if (!empty($getMachineData)) {
                                                                                                    
                                                                                                foreach ($getMachineData as $machineData) {  

                                                                                                   

                                                                                                            
                                                                                                        ?>   
                                                                                        
                                                                                        <option value="<?php echo $machineData->id; ?>"
                                                                                                <?php


                                                                                                    if($machineData->id == $machine_idArrs) {
                                                                                                        
                                                                                                        echo 'selected=selected';


                                                                                                    }


                                                                                            ?>>
                                                                                                <?php echo $machineData->name; ?>
                                                                                            </option>

                                                                                            
                                                                                        <?php    

                                                                                            }
                                                                                        }        
                                                                                        ?>
                                                                                    </select>




                                                                                                                                    </td>
                                                                                                                                    
                                                                                                        <td>

                                                                                            <input type="text" id="kt_datetimepicker_7_{{$process->id}}_{{$itemData->id}}" 
                                        
                                        name="process_date_{{$itemData->id}}[]" 
                                                                                    placeholder="{{$process->name}} - Date" style="float:left;width:140px;"  
                                                                                        
                                                                                    value="{{ !empty($process_datesArr[$u]) ? $process_datesArr[$u] : '' }}" 

                                                                                    class="form-control">

                                                                                                        </td>

                                                                                                        <td>

                                                                                                            
                                                <textarea class="form-control message_{{$itemData->id}}" 
                                                                        rows="2"  
                                                id="note_{{$process->id}}_{{$itemData->id}}" 
                                                name="notes_{{$itemData->id}}[]" 
                                                placeholder="{{$process->name}} - Note" style="height: 45px;" 

                                                    value="{{ !empty($noteArrs[$u]) ? $noteArrs[$u] : '' }}">{{ !empty($noteArrs[$u]) ? $noteArrs[$u] : '' }}</textarea>

                                                                                
                        <input type="hidden"  id="note_{{$process->id}}_{{$itemData->id}}" 
                                                                        
                                name="note_{{$itemData->id}}[]" placeholder="{{$process->name}} - Date" style="float:right;"  value="" class="form-control">
                                                                                                            
    





                                                                                                        </td>

                                                                                                    </tr>

                                                                                                    <?php 
                                                                                                    $u++;
                                                                                                    $k++;
                                                                                                } 
                                                                                            } 
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                                <div data-scroll="true"  class="row"> 
                                                                                    <div class="modal-footer col-sm-3"       style="margin-left: -41px;">
                                                                                        <button type="submit"  class="btn btn-primary font-weight-bold pull-right">Save</button>
                                                                                                            
                                                                            <button type="button" disabled="" class="btn btn-info font-weight-bold pull-right" data-dismiss="modal">Print</button>
                                                                                         <!-- <button type="button"   onclick="addJobCard(<?php echo $itemData->id;?>)"  class="btn btn-primary font-weight-bold pull-right">Save</button>
                                                                                        <button type="button" disabled="" class="btn btn-info font-weight-bold pull-right" data-dismiss="modal">Print</button>-->
                                                                                    </div>
                                                                                </div>
                                                                                
                                        </form>
                                                                                        
                                                                            </div>
                                                                        
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>                        
                                                        <?php /*
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
                                                            <td>
                                                                <a href="#" class="btn-sm btn-success btn-shadow-hover font-weight-bolder" 
                                                                    data-toggle="modal" data-target="#exampleModalSizeLg_@{{purhase.id}}">Create
                                                                </a>
                                                                <div class="modal fade" id="exampleModalSizeLg_@{{purhase.id}}" 
                                                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" 
                                                                                style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-7 col-form-label">
                                                                                                <b class="abc">Item Name :</b> 
                                                                                            </label>
                                                                                            <div class="col-md-5">
                                                                                                @{{ purhase.itemNames }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-header" 
                                                                                style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">

                                                                                            <label class="control-label text-left col-md-7 col-form-label">
                                                                                                <b class="abc">Item Category Name :</b> 
                                                                                            </label>
                                                                                            <div class="col-md-5">
                                                                                                @{{ purhase.itemCatName }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="modal-header" 
                                                                                style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-8  
                                                                                                col-form-label">
                                                                                                <b class="abc">Job Card No : </b> 
                                                                                            </label>
                                                                                            <div class="col-md-4">
                                                                                                <?php 

                                                                                                    $jobCardQuery = DB::select('SELECT MAX(job_card_no) as  jobCardNo FROM job_card WHERE is_deleted_status = "N"');

                                                                                                    $jobCardNo = $jobCardQuery[0]->jobCardNo;
                                                                                                    if (!empty($jobCardQuery)) {
                                                                                                        if (empty($jobCardNo)) {
                                                                                                            $bookNoFinal = 1;
                                                                                                        } else {
                                                                                                            $bookNoFinal = $jobCardNo + 1;
                                                                                                        }
                                                                                                    }
                                                                                                ?>

                                                                                                <input type="text" id="po_no" name="po_no" class="form-control borderred"
                                                                                                id="inputEmail3"  placeholder="PO. No" value="{{ !empty($jobCardQuery->po_no) ? $jobCardQuery->po_no : $bookNoFinal }}" readonly="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-header" 
                                                                                style="padding: 0.5rem 0.75rem;border:none">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group row has-feedback">
                                                                                            <label class="control-label text-left col-md-6  
                                                                                                col-form-label">
                                                                                                <b class="abc">Date : </b> 
                                                                                            </label>
                                                                                            <div class="col-md-6">
                                                                                                <input type="text"  name="job_card_date" 
                                                                                                class="form-control borderred"   placeholder="Date"  
                                                                                                id="kt_datetimepicker_6_@{{purhase.id}}"  
                                                                                                value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="modal-body">
                                                                                <div data-scroll="true" data-height="300">
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-primary font-weight-bold">Save</button>
                                                                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </td>
                                                        </tr>
                                                        */
                                                        ?>
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
    
    function addJobCard(po_id=null) 
    {
        
        var item_ids = $('#item_id_'+po_id).val();
        var item_cat_ids = $('#item_category_id_'+po_id).val();
        var job_card_nos = $('#job_card_no_'+po_id).val();
        var job_card_dates = $('#kt_datetimepicker_6_'+po_id).val();
        
        var process_idArr = $("input[name='process_id_"+po_id+"[]']")
              .map(function(){return $(this).val();}).get();
        
        var process_dateArr = $("input[name='process_date_"+po_id+"[]']")
              .map(function(){return $(this).val();}).get();
        
        var noteArr = [];
        jQuery("textarea.message_"+po_id+"").each(function(){
            noteArr.push(jQuery(this).val());
        });
        
        $.ajax({
            url:"{{ route('jobcard.add') }}",
            type :'get',
            data : {  
                item_ids    : item_ids,
                item_cat_ids: item_cat_ids,
                job_card_nos: job_card_nos,
                job_card_dates: job_card_dates,
                po_id: po_id,
                process_idArr: process_idArr,
                process_dateArr: process_dateArr,
                noteArr : noteArr,
            },
            success: function (data) {
                window.location.href = "{{ route('purchaseorder') }}";
            }
        });
        $('#exampleModalSizeLg_'+po_id+'').modal({backdrop: 'static', keyboard: false});
    }  
    
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
/*
        $scope.pdfPurchaseData = function(data) {
            var Id = btoa(data.id);
            window.location.href = "purchaseorder/pdf/"+Id
        
        };*/
        
        
    });

    function pdfPurchaseData(Id) {
        var Ids = btoa(Id);
        window.location.href = "purchaseorder/pdf/"+Ids
    }


    function showPurchaseData(Id) {
        var Ids = btoa(Id);

        window.location.href = "purchaseorder/viewbyid/"+Ids
    }

    

    function deletePurchaseData(id) {

        if (confirm("Are you Want to delete?") == true) {
            $.ajax({
                url:"{{ route('purchaseorder.delete') }}",
                method: "get",
                data: { 'id': id } ,
                success:function(data) {
                    


                        $('#getUserByDateId_'+id).hide();

                        setTimeout(function() {
                            toastr.success(
                                'Purhase Order has been deleted.', 'Success!',
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

    <?php 

        $getPurchaseOrderData = DB::table('purchase_order')
          ->select('*')
          ->where('is_deleted_status', 'N')
          ->get()
          ->toArray();
        if (!empty($getPurchaseOrderData)) {
            foreach ($getPurchaseOrderData as $key => $itemData) {
    ?>  


    $('#kt_datetimepicker_6_<?php echo $itemData->id; ?>').datetimepicker({
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




    <?php
        $process_masterss = DB::select('SELECT * FROM process_master WHERE is_deleted_status = "N" ');

        if (!empty($process_masterss)) {
            foreach ($process_masterss as $processs) { 
             
                
    ?>
        
        $('#kt_datetimepicker_7_{{$processs->id}}_{{$itemData->id}}').datetimepicker({
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
        
        $('#kt_select2_3_modal_1_machine_{{$processs->id}}_{{$itemData->id}}').select2({
            placeholder: "Select Machine",
        });     

        <?php 
        }
    } 
    ?>

<?php 
    } 
    } 
?>





</script>
</body>
</html>

