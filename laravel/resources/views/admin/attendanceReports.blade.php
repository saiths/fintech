<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


<!--     <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/report/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/report/font-awesome/css/font-awesome.min.css') }}" />
    <script type="text/javascript" src="{{ URL::asset('public/report/js/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/report/bootstrap/js/bootstrap.min.js') }}"></script>
 -->
<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
 -->
</head>
<style type="text/css">
    table {
        border-collapse: collapse;
    }   
    table, th, td {
        border: 1px solid black;
    }
    .table td, .table th {
        padding: 0.20rem !important;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    hr.style-one {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #ccc, #333, #ccc);
    }
    .tables {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

</style>


<body>
    
    
    
                        <?php 

                            $getUserDataByID = DB::table('company_edit_profile')
                            ->select('*')
                            ->where('is_deleted_status','N')
                            ->get()
                            ->toArray();
                            

                        ?> 
                        
                        @if(!empty($getUserDataByID))
                            @foreach ($getUserDataByID as $getUserData)
                            @endforeach
                        @endif

                        





<!-- Simple Invoice - START -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
                        <div class="text-center">
                <center></center>
                <?php 
                    $photo = !empty($getUserData->logo) ? $getUserData->logo : '';
                    $url = URL::to('/').'/laravel/public/company_edit_profile_image/'.$photo;
                ?>
                @if(!empty($photo)) 
                    <img id="previewImg"  src="{{$url}}" 
                    alt="Placeholder" style="    width: 145px;
    height: 81px;
">
                @endif

                
                <center><h2 style="font-size: 22px;font-family:Verdana,sans-serif;margin-top:-64px;">
                    {{!empty($getUserData->company_name) ? $getUserData->company_name : ''  }}</h2>
                    {{!empty($getUserData->address) ? $getUserData->address : ''  }}    
                    </center>
                <center>
                
                <div>{{!empty($getUserData->phone) ? $getUserData->phone : ''  }} | 
                {{!empty($getUserData->email) ? $getUserData->email : ''  }}  | 
                <a href="<?php echo URL::to('/'); ?>">{{!empty($getUserData->website) ? $getUserData->website : ''  }}</a></div> 
                </center>

            </div>
            
                <hr>

            <div class="text-center">
                <center><h2 style="font-size: 22px;font-family:Verdana,sans-serif;">Purchase Order(PO)</h2></center>
            </div>

            <hr>
            <!-- <div class="row" style="font-size: 15px;font-family:Verdana,sans-serif;">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="">
                        <div class="" ><b>Party Name : </b>  Satish Chauhan Navinbhai.</div>
                    </div>

                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="">
                        <div class=""><b>PO. No : </b>  2500</div>
                    </div>

                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="">
                        <div class=""><b>PO. Date : </b> 19-08-2020</div>
                    </div>

                </div>

            </div>
             -->
        </div>
    </div>

                        @if(!empty($purchase_orders))
                            @foreach ($purchase_orders as $poData)
                            @endforeach
                        
    <div class="row" style="margin-top:15px;">
        <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="tables" border="1" style="font-family:Verdana,sans-serif;margin-top: 10px;font-size:18px;">
                            <thead class="spacer"  >
                                <tr class="panel-headings">
                                    <td style="width:60%">
                                        <div class="">
                                            <div class="" ><b>Party Name : </b> 
                                            {{!empty($poData->partyName) ? $poData->partyName : '' }}</div>
                                        </div>
                    
                                    </td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class=""><b>PO. No : </b>  
                                            {{!empty($poData->po_no) ? $poData->po_no : '' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class=""><b>PO. Date : </b> 
                                            {{!empty($poData->po_date) ? $poData->po_date : '' }}</div>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            
                            <thead class="spacer" style="background:#EDE8E7;"  >
                                <tr class="panel-headings">
                                    <td><strong>Item Detail</strong></td>
                                    <td class="text-center"><strong>Unit</strong></td>
                                    <td class="text-center"><strong>Qty</strong></td>
                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 col-lg-4 ">
                                                <div class="form-group row has-feedback">
                                                    <label class="control-label text-right col-md-5 col-form-label">
                                                        <b class="abc"></b>
                                                    </label>
                                                   <b style="font-size:18px;"> {{!empty($poData->itemNames) ? $poData->itemNames : '' }}</b>
                                                    
                                                </div>
                                                
                                                <div class="form-group row has-feedback" style="margin-top:10px;">
                                                    <label class="control-label text-right col-md-5 col-form-label">
                                                        <b class="abc">Description</b>
                                                    </label>
                                                    <br>
                                                    {{!empty($poData->description) ? $poData->description : '' }}
                                                    
                                                </div>
                                                
                                                <?php 
                                                  /*  $attribute_item_id  = [];
                                                    $attribute_item_id_values  = [];
                                                
                                                    $getTicketAttachmentDatas = DB::select('SELECT * FROM purchase_order_attribute WHERE is_deleted_status = "N" AND po_id = '.$poData->id.'');
                                                        if (!empty($getTicketAttachmentDatas)) { 
                                                            foreach ($getTicketAttachmentDatas as $attachmentAttlist) {
                                                                $attribute_item_id[] = $attachmentAttlist->attribute_item_id;
                                                                $attribute_item_id_values[] = $attachmentAttlist->value;
                                                            }
                                                            $attItemIdlist = !empty($attribute_item_id) ? implode(',', $attribute_item_id) : 0;

                                                            $getItemData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" AND  id IN('.$attItemIdlist.') ORDER By name ASC ');
                                                            if (!empty($getItemData)) {
                                                                foreach ($getItemData as $item) { 

                                                            */

                                                ?>

                                                    @if(!empty($attribute_item_name))
                                                                                                    <div style="margin-top:10px;">

                            @foreach ($attribute_item_name as $key => $values)
                            
                            

                                                        <div class="form-group row has-feedback">
                                                            <label class="control-label text-right col-md-5 col-form-label">
                                                                <b class="abc"> 
                                                            {{!empty($attribute_item_name[$key]) ? $attribute_item_name[$key] : '' }} : 
                                                                </b>
                                                            </label>
                                        {{!empty($attribute_item_id_values[$key]->value) ? $attribute_item_id_values[$key]->value : '' }}

                                                        </div>
                            @endforeach
                            </div>
                            @endif


                        


                                                                <?php 
                                                               // }
                                                            //}
                                                        //}

                                                    ?>


                                                        
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><p style="margin-top:-77px;">{{!empty($poData->unitName) ? $poData->unitName : '' }}</p></td>
                                    <td class="text-center"><p style="margin-top:-77px;">{{!empty($poData->qty) ? $poData->qty : '' }}</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            
        
        </div>
    </div>
    @endif

</div>



<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>

<!-- Simple Invoice - END -->


</body>
</html>


<?php //die;?>
