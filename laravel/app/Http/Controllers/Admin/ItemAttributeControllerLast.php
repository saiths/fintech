<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\ItemAttributeModel;
use App\Models\Admin\PurhaseModel;
use App\Models\Admin\PurhaseOrderModel;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Jenssegers\Agent\Agent;
use DateTime;
use Redirect;
use URL;
use DatePeriod;
use DateInterval;
use PDF;
use Codedge\Fpdf\Fpdf\Fpdf;


class ItemAttributeController extends Controller
{


   /**
     *  ItemAttribute Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularItemAttributeForm() 
    { 
        return view('admin.itemattribute');
    }

  /**
    *  get $itemAttributeData using Angular
    *
    * @return $itemAttributeData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularItemAttributeView()
    { 
        $itemAttributeModel = new ItemAttributeModel();
        $itemAttributeData = $itemAttributeModel->selectItemAttribute();
        return $itemAttributeData;
    }

  /**
    *  add $itemAttributeData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAttributeAngularAdd(Request $request)
    {   

        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $itemAttributeId = 0;
        
        if (!empty($request->input('name'))) {
            $itemAttributeModel = new ItemAttributeModel();
            $resultName = $itemAttributeModel->itemAttributeNameAlredyExists(trim($request->input('name')),$itemAttributeId); 
        }
        
        $nameText =  !empty($resultName) ? 'nameText' : 0;

        if ($nameText == '') { 
            
            $itemAttributeData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0
            ];

            $itemAttributeModel = new ItemAttributeModel();
            $itemAttributeResult = $itemAttributeModel->itemAttributeInsert($itemAttributeData);
            return ['success'=> true,'message' => 'Item Attribute has been added.'];

        } else {

            return ['success'=> true,'nameText' => $nameText ];

        } 

    }
    

  /**
    *  update $itemAttributeData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAttributeAngularEdit(Request $request)
    {
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';

        $itemAttributeId = 0;
        $itemAttributeId = $request->input('id');

        if (!empty($request->input('name'))) {
            $itemAttributeModel = new ItemAttributeModel();
            $resultName = $itemAttributeModel->itemAttributeNameAlredyExists(trim($request->input('name')),$itemAttributeId); 
        }  
        
        $nameText =  !empty($resultName) ? 'nameText' : 0;
        
        if ($nameText == '') { 
            
            $itemAttributeData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0
            ];

            $itemAttributeModel = new ItemAttributeModel();
            $itemAttributeResult = $itemAttributeModel->updateItemAttribute($itemAttributeData,$itemAttributeId);
            return ['success'=> true,'message' => 'Item Attribute has been updated.'];
        
        } else {
            
            return ['success'=> true,'nameText' => $nameText ];   
            
        } 

    }

   /**
     *  delete ItemAttribute By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularItemAttribute(Request $request)
    {
        $itemAttributeId = $request->input('id');
        if (!empty($itemAttributeId)) {
            $itemAttributeModel = new ItemAttributeModel();
            $result = $itemAttributeModel->deleteItemAttribute($itemAttributeId);
            return ['success'=> true, 'message' => 'Item Attribute has been deleted.'];
        }

    }

   /**
     *  purhaseDashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    /*public function showAngularPurhaseForm() 
    { 
        return view('admin.purhase');
    }
    */

  /**
    *  getPurhaseData using Angular
    *
    * @return purhaseData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularPurhaseView()
    { 
        
        $purhaseModel = new PurhaseModel();
        $getPurhaseData = $purhaseModel->selectPurhase();
        return $getPurhaseData;
    }

  /**
    *  add getPurhaseData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function purchaseAngularAdd(Request $request)
    {   

        $this->validate($request,[
            'party_id'           => 'required',
            'purchase_bill_nos'  => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $status = 'N';

        $inwardNo = !empty($request->input('inward_no')) ? $request->input('inward_no') : 0;

        $inwardDate = !empty($request->input('inward_date')) ? $request->input('inward_date') : 0;

        $purchaseBillNo = !empty($request->input('purchase_bill_nos')) ? $request->input('purchase_bill_nos') : 0;
            
        $purchaseDate = !empty($request->input('purchase_date')) ? $request->input('purchase_date') : 0;

        $partyId = !empty($request->input('party_id')) ? $request->input('party_id') : 0;

        $total = !empty($request->input('totals')) ? $request->input('totals') : 0;
        
        $otherCharges = !empty($request->input('other_charges')) ? $request->input('other_charges') : 0;
            
        $grandTotal = !empty($request->input('grand_total')) ? $request->input('grand_total') : 0;
       
        $remark = !empty($request->input('remark')) ? $request->input('remark') : 0;

        $itemTypeNames = !empty($request->input('itemTypeNames')) ? $request->input('itemTypeNames') : 0;
        if (!empty($itemTypeNames)) {
            $itemTypeNames = explode(',', $itemTypeNames);
        }
            
        $itemNames = !empty($request->input('itemNames')) ? $request->input('itemNames') : 0;
        if (!empty($itemNames)) {
            $itemNames = explode(',', $itemNames);
        }
       
        $unitIdss = !empty($request->input('unitIds')) ? $request->input('unitIds') : 0;
        if (!empty($unitIdss)) {
            $unitIdssNew = explode(',', $unitIdss);
            foreach ($unitIdssNew as $unit) {
                $getUnitData = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND unit = '.$unit.' ');  
                $unitIdArr[] = !empty($getUnitData[0]->id) ? $getUnitData[0]->id : '';
            }
        }

        $unitIdArr = !empty($unitIdArr) ? $unitIdArr : 0;
        

        $qtys = !empty($request->input('qtys')) ? $request->input('qtys') : 0;
        if (!empty($qtys)) {
            $qtys = explode(',', $qtys);
        }

        $rates = !empty($request->input('rates')) ? $request->input('rates') : 0;
        if (!empty($rates)) {
            $rates = explode(',', $rates);
        }
         
        $amounts = !empty($request->input('amounts')) ? $request->input('amounts') : 0;
        if (!empty($amounts)) {
            $amounts = explode(',', $amounts);
        }

        $gst_nos = !empty($request->input('gst_nos')) ? $request->input('gst_nos') : 0;
        if (!empty($gst_nos)) {
            $gst_nos = explode(',', $gst_nos);
        }

        $gst_amount_nos = !empty($request->input('gst_amount_nos')) ? $request->input('gst_amount_nos') : 0;
        if (!empty($gst_amount_nos)) {
            $gst_amount_nos = explode(',', $gst_amount_nos);
        }
        
        $totalss = !empty($request->input('totalss')) ? $request->input('totalss') : 0;
        if (!empty($totalss)) {
            $totalss = explode(',', $totalss);
        }        
        
        $getPurhaseData = [ 
            'inward_no'         => $inwardNo,
            'inward_date'       => $inwardDate,
            'purchase_bill_no'  => $purchaseBillNo,
            'purchase_date'     => $purchaseDate,
            'party_id'          => $partyId,
            'total'             => $total,
            'other_charges'     => $otherCharges,
            'grand_total'       => $grandTotal,
            'remark'            => $remark,
            'status'            => $status,
            'created_at'        => $time,
            'updated_at'        => $time,
            'deleted_at'        => $time,
            'created_by'        => 0,
            'edited_by'         => 0,
            'deleted_by'        => 0
        ];

        $purhaseModel = new PurhaseModel();
        $purhaseIds = $purhaseModel->purhaseInsert($getPurhaseData);
        if (!empty($purhaseIds)) {
            if (!empty($itemTypeNames)) {
                foreach ($itemTypeNames as $key => $purhaseDetails) {
                    $amountsArr = ''.$amounts[$key].'';
                    $purhaseDetailsArr = [
                        'purchase_id'       => !empty($purhaseIds) ? $purhaseIds : 0,
                        'item_type_id'      => $itemTypeNames[$key],
                        'item_id'           => $itemNames[$key],
                        'unit_id'           => !empty($unitIdArr[$key]) ? $unitIdArr[$key] : 0,
                        'qty'               => !empty($qtys[$key]) ? $qtys[$key] : 0,
                        'rate'              => $rates[$key],
                        'amount'            => !empty($amountsArr) ? $amountsArr : 0,
                        'gst_no'            => $gst_nos[$key],
                        'gst_amount_no'     => $gst_amount_nos[$key],
                        'totals'            => $totalss[$key],
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];
                    $purhaseModel->purhaseDetailsInsert($purhaseDetailsArr);

                }
            }
        }

        Session::flash('message','Purhase has been added.');
       // return redirect('purchasesers');    
    }
    

  /**
    *  update getPurhaseData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function purhaseAngularEdit(Request $request)
    {   
        
        $this->validate($request,[
            'party_id'           => 'required',
            'purchase_bill_nos'  => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $status = 'N';

        $inwardNo = !empty($request->input('inward_no')) ? $request->input('inward_no') : 0;

        $purhaseId = !empty($request->input('purhaseId')) ? $request->input('purhaseId') : 0;

        $inwardDate = !empty($request->input('inward_date')) ? $request->input('inward_date') : 0;

        $purchaseBillNo = !empty($request->input('purchase_bill_nos')) ? $request->input('purchase_bill_nos') : 0;
            
        $purchaseDate = !empty($request->input('purchase_date')) ? $request->input('purchase_date') : 0;

        $partyId = !empty($request->input('party_id')) ? $request->input('party_id') : 0;

        $total = !empty($request->input('totals')) ? $request->input('totals') : 0;
        
        $otherCharges = !empty($request->input('other_charges')) ? $request->input('other_charges') : 0;
            
        $grandTotal = !empty($request->input('grand_total')) ? $request->input('grand_total') : 0;
       
        $remark = !empty($request->input('remark')) ? $request->input('remark') : 0;

        $itemTypeNames = !empty($request->input('itemTypeNames')) ? $request->input('itemTypeNames') : 0;
        if (!empty($itemTypeNames)) {
            $itemTypeNames = explode(',', $itemTypeNames);
        }
            
        $itemNames = !empty($request->input('itemNames')) ? $request->input('itemNames') : 0;
        if (!empty($itemNames)) {
            $itemNames = explode(',', $itemNames);
        }
       
        $unitIdss = !empty($request->input('unitIds')) ? $request->input('unitIds') : 0;
        if (!empty($unitIdss)) {
            $unitIdssNew = explode(',', $unitIdss);
            foreach ($unitIdssNew as $unit) {
                $getUnitData = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND unit = '.$unit.' ');  
                $unitIdArr[] = !empty($getUnitData[0]->id) ? $getUnitData[0]->id : '';
            }
        }

        $unitIdArr = !empty($unitIdArr) ? $unitIdArr : 0;
        
        $qtys = !empty($request->input('qtys')) ? $request->input('qtys') : 0;
        if (!empty($qtys)) {
            $qtys = explode(',', $qtys);
        }

        $rates = !empty($request->input('rates')) ? $request->input('rates') : 0;
        if (!empty($rates)) {
            $rates = explode(',', $rates);
        }
         
        $amounts = !empty($request->input('amounts')) ? $request->input('amounts') : 0;
        if (!empty($amounts)) {
            $amounts = explode(',', $amounts);
        }

        $gst_nos = !empty($request->input('gst_nos')) ? $request->input('gst_nos') : 0;
        if (!empty($gst_nos)) {
            $gst_nos = explode(',', $gst_nos);
        }

        $gst_amount_nos = !empty($request->input('gst_amount_nos')) ? $request->input('gst_amount_nos') : 0;
        if (!empty($gst_amount_nos)) {
            $gst_amount_nos = explode(',', $gst_amount_nos);
        }
        
        $totalss = !empty($request->input('totalss')) ? $request->input('totalss') : 0;
        if (!empty($totalss)) {
            $totalss = explode(',', $totalss);
        }
    
        $purchaseDelId = !empty($request->input('purchaseDelId')) ? $request->input('purchaseDelId') : 0;


        $getPurhaseData = [ 
            'inward_no'         => $inwardNo,
            'inward_date'       => $inwardDate,
            'purchase_bill_no'  => $purchaseBillNo,
            'purchase_date'     => $purchaseDate,
            'party_id'          => $partyId,
            'total'             => $total,
            'other_charges'     => $otherCharges,
            'grand_total'       => $grandTotal,
            'remark'            => $remark,
            'status'            => $status,
            'created_at'        => $time,
            'updated_at'        => $time,
            'deleted_at'        => $time,
            'created_by'        => 0,
            'edited_by'         => 0,
            'deleted_by'        => 0
        ];

        $purhaseModel = new PurhaseModel();
        $purhaseIds = $purhaseModel->updatePurchase($getPurhaseData,$purhaseId);

        $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $deleteResult = DB::table('purchase_master_detail')->where('purchase_id', $purhaseId)->update($purchaseDatasss);
                


       // if (!empty($purhaseIds)) {
            if (!empty($itemTypeNames)) {
                foreach ($itemTypeNames as $key => $purhaseDetails) {

                    $amountsArr = ''.$amounts[$key].'';
                    $purchaseDelIds = !empty($purchaseDelId[$key]) ? $purchaseDelId[$key] : 0;
                        

                    $purhaseDetailsArr = [

                        'purchase_id'       => !empty($purhaseId) ? $purhaseId : 0,
                        'item_type_id'      => $itemTypeNames[$key],
                        'item_id'           => $itemNames[$key],
                        'unit_id'           => !empty($unitIdArr[$key]) ? $unitIdArr[$key] : 0,
                        'qty'               => !empty($qtys[$key]) ? $qtys[$key] : 0,
                        'rate'              => $rates[$key],
                        'amount'            => !empty($amountsArr) ? $amountsArr : 0,
                        'gst_no'            => $gst_nos[$key],
                        'gst_amount_no'     => $gst_amount_nos[$key],
                        'totals'            => $totalss[$key],
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0

                    ];
                    $purhaseModel->updatePurchaseDetails($purhaseDetailsArr,$purchaseDelIds);



                }


            }
       // }

        Session::flash('message','Purhase has been updated.');
        return redirect('purchasesers');
    }
    

   /**
     *  deletePurhase By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularPurhase(Request $request)
    {
        
        $purhaseId = $request->input('id');
        if (!empty($purhaseId)) {
            $purhaseModel = new PurhaseModel();
            $result = $purhaseModel->deletePurhase($purhaseId);
            return ['success'=> true, 'message' => 'Purhase has been deleted.'];

        }

    }


   /**
     * getPurchaseData By unit_id  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectPurhaseAngularById(Request $request)
    {


        $unitId = $request->input('unit_id');
        
        if (!empty($unitId)) {
            $getPurchaseData = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');


            foreach ($getPurchaseData as $purhase) {
                $purchaseListHtml =  '<option value="'.$purhase->id.'"';
                
                if ($unitId == $purhase->id) { 
                    $purchaseListHtml .= ' selected="selected"';
                }

                $purchaseListHtml .= '>'.$purhase->name.'</option>';

                
                echo $purchaseListHtml; 
            } 

        }

    }


   /**
     * getUserDataByID By userIds  using angular
     *
     * @param  Request $request
     * @return $getUserDataByID    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularPurhaseDataByID($purhaseId = null)
    {
        
        $purhaseId = base64_decode($purhaseId);
        if (!empty($purhaseId)) {
            $purhaseModel = new PurhaseModel();
            $getPurhaseDataByID = $purhaseModel->selectPurchaseDataByID($purhaseId);
        }
        return view('admin.addPurhase', [
            'getPurhaseDataByID' => $getPurhaseDataByID, 
        ]);
        
    }
    


    
   /**
     *  purhaseDashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularPurhasesForm() 
    { 
        return view('admin.purhase');
    }
    

    
   /**
     *  purhaseDashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularPurhaseForm() 
    { 

        $purhaseModel = new PurhaseModel();
        $getPurhaseData = $purhaseModel->selectPurhase();
        return  $getPurhaseData; 
    }

   /**
     *  purhaseDashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showaddPurchaseForm() 
    { 
        return view('admin.addPurhase');
    }

     

   /**
     * getPurchaseData By unit_id  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemUnitAngularById(Request $request)
    {
        

        //$unitId = $request->input('unit_id');
        
       // if (!empty($unitId)) {
           /* $getPurchaseData = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');


            foreach ($getPurchaseData as $purhase) {
                $purchaseListHtml =  '<option value="'.$purhase->id.'"';
                
                if ($unitId == $purhase->id) { 
                    $purchaseListHtml .= ' selected="selected"';
                }

                $purchaseListHtml .= '>'.$purhase->name.'</option>';

                
                echo $purchaseListHtml; 
            } */

     //   }

    }




   /**
     * getPurchaseData By unit_id  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemGstAngularById()
    {
        
        $itemId = !empty($_GET['itemId']) ? $_GET['itemId'] : '';
            

        if (!empty($itemId)) {
            $itemDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND id = '.$itemId.'');


            $itemGst =   !empty($itemDatas[0]->gst) ?  $itemDatas[0]->gst : '';
            echo $itemGst;

            /*if (!empty($itemDatas)) {
                foreach ($itemDatas as $item) {
                    $itemDatas = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND id = '.$item->unit_id.'');
                    $itemUnit =   !empty($itemDatas[0]->gst) ?  $itemDatas[0]->gst : '';

                    echo $itemGst;

                } 
            }*/  
        }

    }



   /**
     * getPurchaseData By unit_id  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemNameUnitAngularById()
    {
        
        $itemTypeIdss = !empty($_GET['itemTypeIdssd']) ? $_GET['itemTypeIdssd'] : '';

        if (!empty($_GET['itemTypeIdss'])) {
            
            $itemDatasName = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');
            if (!empty($itemDatasName)) {
                $purchaseItemTyppeListHtml = '';
                foreach ($itemDatasName as $itemTypeName) {
                    $purchaseItemTyppeListHtml .=  '<option value="'.$itemTypeName->id.'_'.$itemTypeName->name.'"';
                    if ($itemTypeName->id == $_GET['itemTypeIdss']) {
                        $purchaseItemTyppeListHtml .= 'selected=selected';
                    }
                    $purchaseItemTyppeListHtml .= '>'.$itemTypeName->name.'</option>';
                }
                echo $purchaseItemTyppeListHtml;
            }


        } else if (!empty($_GET['itemIdss'])) {

            
            $itemDatasName = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id =  '.$itemTypeIdss.'');

            if (!empty($itemDatasName)) {

                $purchaseItemNameListHtml = '';
                foreach ($itemDatasName as $itemName) {

                    $purchaseItemNameListHtml .=  '<option value="'.$itemName->id.'_'.$itemName->name.'"';

                    if ($itemName->id == $_GET['itemIdss']) {

                        $purchaseItemNameListHtml .= 'selected=selected';

                    }

                    $purchaseItemNameListHtml .= '>'.$itemName->name.'</option>';

                }
                echo $purchaseItemNameListHtml;



            }



        } else {

            $itemTypeId = !empty($_GET['itemTypeId']) ? $_GET['itemTypeId'] : '';

            $purchaseListHtml = '';
            if (!empty($itemTypeId)) {
                $itemDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND 
                    item_type_id = '.$itemTypeId.'');

                $purchaseListHtml1  =  '<option value=""> Select Item Name</option>';

                if (!empty($itemDatas)) {
                    foreach ($itemDatas as $item) {
                        $purchaseListHtml .=  '<option value="'.$item->id.'_'.$item->name.'"';
                        $purchaseListHtml .= '>'.$item->name.'</option>';
                        //echo $purchaseListHtml; 
                    } 
                }

               echo $purchaseListHtml1.$purchaseListHtml;

            }

        }

    }



   /**
     * getPurchaseData By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemNamedAngularById()
    {

        $itemTypeId = !empty($_GET['itemTypeId']) ? $_GET['itemTypeId'] : '';
        if (!empty($itemTypeId)) {
            $itemDatasUnitData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND item_type_id = '.$itemTypeId.'');
            if (!empty($itemDatasUnitData)) {
                $unitId = $itemDatasUnitData[0]->unit_id;
            }    
        }

        $itemUnitData = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND id = '.$unitId.'');
        if (!empty($itemUnitData)) {
            echo  $itemUnitData[0]->unit;
        }

    }



   /**
     * getPurchaseData By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemNameGstudAngularById()
    {
        
        $itemTypeId = !empty($_GET['itemTypeId']) ? $_GET['itemTypeId'] : '';
        if (!empty($itemTypeId)) {
            $itemDatasUnitData = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND 
                item_type_id = '.$itemTypeId.'');
            if (!empty($itemDatasUnitData)) {
                $unitGst = !empty($itemDatasUnitData[0]->gst) ? $itemDatasUnitData[0]->gst : '';
                echo $unitGst;
            }    
        }

    }




   /**
     * getPurchaseData By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $purchaseListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemNamesAngularById()
    {

        $itemId = !empty($_GET['itemId']) ? $_GET['itemId'] : '';
        if (!empty($itemId)) {
            $itemDatas = DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND id = '.$itemId.'');
            if (!empty($itemDatas)) {
                foreach ($itemDatas as $item) {
                    $itemDatas = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N" AND id = '.$item->unit_id.'');
                    $itemUnit =   !empty($itemDatas[0]->unit) ?  $itemDatas[0]->unit : '';
                    echo $itemUnit;
                } 
            }

        }

    }

    

    /**
     *  remove purchaseDelIds By purchaseDelIds
     *
     * @param $purchaseDelIds INT
     * @return boolean 0 and 1    
     * @author <satishchauhan041@gmail.com>
     */
    public function removePurchaseDetail() {  

        $result = 0;
        $purchaseDelIds = !empty($_GET['purchaseDelIds']) ? $_GET['purchaseDelIds'] : '';
        $totalss = !empty($_GET['totalss']) ? $_GET['totalss'] : '';
        $totalr = !empty($_GET['totalr']) ? $_GET['totalr'] : '';
        $otherChargess = !empty($_GET['otherChargess']) ? $_GET['otherChargess'] : '';
        $purchaseIds = !empty($_GET['purchaseIds']) ? $_GET['purchaseIds'] : '';
        $grandTotals = !empty($_GET['grandTotals']) ? $_GET['grandTotals'] : '';
                
        
        //if (!empty($purchaseDelIds)) {
            $purhaseModel = new PurhaseModel();
            $result = $purhaseModel->deletePurhaseDetails($purchaseDelIds,$purchaseIds,$totalss,$totalr,$otherChargess,$grandTotals);
        //}
        echo $result;

        
    }

    
    /**
     *  remove purchaseDelIds By purchaseDelIds
     *
     * @param $purchaseDelIds INT
     * @return boolean 0 and 1    
     * @author <satishchauhan041@gmail.com>
     */
    public function getOtherCharges() {  
            
        $result = 0;
        $purchaseIds = !empty($_GET['purchaseIds']) ? $_GET['purchaseIds'] : '';
        $purchaseData = DB::select('SELECT * FROM purchase_master WHERE is_deleted_status = "N" AND id = '.$purchaseIds.'');
        if (!empty($purchaseData)) {
            $otherCharges  = !empty($purchaseData[0]->other_charges) ?  $purchaseData[0]->other_charges : '0.00';        
            echo $otherCharges;
        }

    }
    


    
    /* start PO ORDER Part */


   /**
     * getItemNamebyPartyId By partyId  using angular
     *
     * @param  Request $request
     * @return $getItemNamebyPartyId    
     * @author <satishchauhan041@gmail.com>
     */
    public function getItemNamebyPartyId()
    {
        
        if (!empty($_GET['partyIds'])) {
            $purchaseListHtml = '';

            $getItemNameData = 
            DB::select('SELECT * FROM item_master WHERE is_deleted_status = "N" AND party_id = '.$_GET['partyIds'].' ORDER BY name ASC');

            if (!empty($getItemNameData)) {

                $itemCatListHtmls = '<option value=""> Select Item Name</option>';
                foreach ($getItemNameData as $itemData) {
                    $purchaseListHtml .=  '<option value="'.$itemData->id.'"';
                    $purchaseListHtml .= '>'.$itemData->name.'</option>';
                } 
                echo $itemCatListHtmls.$purchaseListHtml; 
            
            } else {

              echo 0;      

            }


        }
    }





   /**
     * getItemNameAttbyPartyId By itemId  using angular
     *
     * @param  Request $request
     * @return $getItemNameAttbyPartyId    
     * @author <satishchauhan041@gmail.com>
     */
    public function getItemNameAttbyPartyId()
    {
                                              
        $listItemAtt = 0;    
        if (!empty($_GET['itemIds'])) {

            $getItemNameAttData = 
            DB::select('SELECT * FROM attribute_item_master WHERE is_deleted_status = "N" AND item_id = '.$_GET['itemIds'].'');

            if (!empty($getItemNameAttData)) {
                
                $purchaseListHtml = '<div class="col-md-12" style="height: 250px;overflow-x: auto;">
                                        <table class="table table-bordered table-hover table-checkable" >
                                            <tbody id="purhaseDetail">';
                                                    
                foreach ($getItemNameAttData as $itemAttData) {
                    $itemAttId[] =  $itemAttData->attribute_item_id;
                }
                $listItemAtt = implode(',', $itemAttId);
                
                $getItemAttData = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" 
                    AND id IN('.$listItemAtt.')');

                if (!empty($getItemAttData)) {

/*                    $purchaseListHtml .= '<tr>';
                    $i = 1;
                    foreach ($getItemAttData as $itemAtt) { 
                        $purchaseListHtml .= 
                        '<th style="background-color:#EBEDF3">Item Attribute Name - '.$i.'</th>';
                    $i++;
                    }
                    $purchaseListHtml .= '</tr>';
*/
                    
                    $purchaseListHtml .= '<tr>';
                    foreach ($getItemAttData as $itemAtt) { 
                        $purchaseListHtml .= 
                        '<td><input type="hidden" id="value"    name="attribute_item_ids[]"   value="'.$itemAtt->id.'" class="form-control"><div style="cursor: none;" class="btn-sm btn-dark">'.$itemAtt->name.'</div></td>';
                    }
                    $purchaseListHtml .= '</tr>';

                    $purchaseListHtml .= '<tr>';
                    foreach ($getItemAttData as $itemAtt) { 
                        $purchaseListHtml .= 
                        '<td><input type="text" id="value"    name="values[]" placeholder="'.$itemAtt->name.' - Value"  value="" class="form-control"></td>';
                    }
                    $purchaseListHtml .= '</tr>';

                }
                

                $purchaseListHtml .= ' </tbody>
                                        </table>
                                    </div>';


                echo $purchaseListHtml;


                
            } else {

              echo 0;      

            }


        }
    }




  /**
    *  add purchaseOrderData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function purchaseOrderAngularAdd(Request $request)
    {   
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        

        $po_no =  !empty($request->input('po_no')) ? $request->input('po_no') : 0;
        $po_date =  !empty($request->input('po_date')) ? $request->input('po_date') : 0;
        $party_id =  !empty($request->input('party_id')) ? $request->input('party_id') : 0;
        $item_id =  !empty($request->input('item_id')) ? $request->input('item_id') : 0;
        $qty =  !empty($request->input('qty')) ? $request->input('qty') : 0;
        $description =  !empty($request->input('description')) ? $request->input('description') : 0;
        
        $purchaseOrderData = [ 
            'po_no'       => $po_no,
            'po_date'     => $po_date,
            'party_id'    => $party_id,
            'item_id'     => $item_id,
            'description' => $description,
            'qty'         => $qty,
            'status'      => $status,
            'created_at'  => $time,
            'updated_at'  => $time,
            'deleted_at'  => $time,
            'created_by'  => 0,
            'edited_by'   => 0,
            'deleted_by'  => 0
        ];
        
        $purhaseOrderModel = new PurhaseOrderModel();
        $purhaseOrderId = $purhaseOrderModel->purhaseOrderInsert($purchaseOrderData);

         if (!empty($purhaseOrderId)) {

            $itemAttsNames =  
            !empty($request->input('attribute_item_ids')) ? explode(',', $request->input('attribute_item_ids')) : 0;
            $attValues     =  !empty($request->input('values')) ? explode(',',$request->input('values')) : 0;
            
            if (!empty($itemAttsNames)) {

                foreach ($itemAttsNames as $key => $itemAtts) {

                    $itemAttsArrs = [
                        'po_id'             => !empty($purhaseOrderId) ? $purhaseOrderId : 0,
                        'item_id'           => !empty($item_id) ? $item_id : 0,
                        'attribute_item_id' => !empty($itemAttsNames[$key]) ? $itemAttsNames[$key] : 0,
                        'value'             => !empty($attValues[$key]) ? $attValues[$key] : 0,
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];

                    $purhaseOrderModel = new PurhaseOrderModel();
                    $purhaseOrderModel->purhaseOrderDetailsInsert($itemAttsArrs);
                    
                }

            }

            $uploadPath = public_path('po_image');
            $allowedfileExtension=['pdf','jpg','png','docx'];
            $files = $request->file('filesToUploads');
            if (!empty($files)) {
                foreach($files as $file) {
                    $fileName = time().'_'.$po_no.'_'.$file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $poImagesArrs = [
                        'po_id'             => !empty($purhaseOrderId) ? $purhaseOrderId : 0,
                        'item_id'           => !empty($item_id) ? $item_id : 0,
                        'image'             => !empty($fileName) ? $fileName : 0,
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];
                    DB::table('purchase_order_image')->insert($poImagesArrs);
                }
            }
        }
        Session::flash('message','Purhase Order has been added.');
    }





  /**
    *  add purchaseOrderData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function purchaseOrderAngularEdit(Request $request)
    {   
        
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        
        $po_id =  !empty($request->input('po_id')) ? $request->input('po_id') : 0;
        $po_no =  !empty($request->input('po_no')) ? $request->input('po_no') : 0;
        $po_date =  !empty($request->input('po_date')) ? $request->input('po_date') : 0;
        $party_id =  !empty($request->input('party_id')) ? $request->input('party_id') : 0;
        $item_id =  !empty($request->input('item_id')) ? $request->input('item_id') : 0;
        $qty =  !empty($request->input('qty')) ? $request->input('qty') : 0;
        $description =  !empty($request->input('description')) ? $request->input('description') : 0;
        
        $purchaseOrderData = [ 
            'po_no'       => $po_no,
            'po_date'     => $po_date,
            'party_id'    => $party_id,
            'item_id'     => $item_id,
            'description' => $description,
            'qty'         => $qty,
            'status'      => $status,
            'created_at'  => $time,
            'updated_at'  => $time,
            'deleted_at'  => $time,
            'created_by'  => 0,
            'edited_by'   => 0,
            'deleted_by'  => 0
        ];
        
        $purhaseOrderModel = new PurhaseOrderModel();
        $purhaseOrderId = $purhaseOrderModel->updatePurchaseOrder($purchaseOrderData,$po_id);

        $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $deleteResult = DB::table('purchase_order_attribute')->where('po_id', $po_id)->update($purchaseDatasss);
            

        if (!empty($po_id)) {

            $itemAttsNames = 
            !empty($request->input('attribute_item_ids')) ? explode(',', $request->input('attribute_item_ids')) : 0;
            $attValues     =  !empty($request->input('values')) ? explode(',',$request->input('values')) : 0;
            
            if (!empty($itemAttsNames)) {

                foreach ($itemAttsNames as $key => $itemAtts) {

                    $itemAttsArrs = [
                        'po_id'             => !empty($po_id) ? $po_id : 0,
                        'item_id'           => !empty($item_id) ? $item_id : 0,
                        'attribute_item_id' => !empty($itemAttsNames[$key]) ? $itemAttsNames[$key] : 0,
                        'value'             => !empty($attValues[$key]) ? $attValues[$key] : 0,
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];

                    $purhaseOrderModel = new PurhaseOrderModel();
                    $purhaseOrderModel->purhaseOrderDetailsInsert($itemAttsArrs);
                    
                }

            }

            $uploadPath = public_path('po_image');
            $allowedfileExtension=['pdf','jpg','png','docx'];
            $files = $request->file('filesToUploads');
            if (!empty($files)) {
                foreach($files as $file) {
                    $fileName =  time().'_'.$po_no.'_'.$file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $poImagesArrs = [
                        'po_id'             => !empty($po_id) ? $po_id : 0,
                        'item_id'           => !empty($item_id) ? $item_id : 0,
                        'image'             => !empty($fileName) ? $fileName : 0,
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];
                    DB::table('purchase_order_image')->insert($poImagesArrs);
                }
            }
        }

        Session::flash('message','Purhase Order has been updated.');

    }
    



   /**
     *  purhaseOrder view
     *
     * @return admin getPurchaseOrderData view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function purchaseOrderView() 
    { 

        return view('admin.purhaseorder');


    }


   /**
     *  purhaseOrder view
     *
     * @return admin getPurchaseOrderData view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function purchaseOrderViewData() 
    { 
        $purhaseOrderModel = new PurhaseOrderModel();
        $getPurhaseOrderData = $purhaseOrderModel->selectPurhaseOrder();
        return  $getPurhaseOrderData; 

    }


   /**
     *  addPurchaseOrderView
     *
     * @return admin addPurchaseOrderView view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function addPurchaseOrderView() 
    { 
        return view('admin.addPurhaseOrder');
                   
    }



   /**
     * getUserDataByID By userIds  using angular
     *
     * @param  Request $request
     * @return $getUserDataByID    
     * @author <satishchauhan041@gmail.com>
     */
    public function getPurhaseOrderDataByID($poId = null)
    {
        $poIds = base64_decode($poId);
        
        if (!empty($poIds)) {
            $purhaseOrderModel = new PurhaseOrderModel();
            $getPurhaseDataByID = $purhaseOrderModel->selectPurchaseOrderDataByID($poIds);
        }
        return view('admin.addPurhaseOrder', [
            'getPurhaseDataByID' => $getPurhaseDataByID, 
        ]);
        
    }
    


   /**
     *  delete itemCategory By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removePurhaseOrderById()
    {   
        
        $poId = !empty($_GET['id']) ? $_GET['id'] : 0;

        if (!empty($poId)) {

            $getTicketAttachmentData = DB::table('purchase_order_image')
              ->select('*')
              ->where('po_id', $poId)
              ->where('is_deleted_status', 'N')
              ->get()
              ->toArray(); 
            if (!empty($getTicketAttachmentData)) {
                foreach ($getTicketAttachmentData as $attachment) {
                    $unlinkPath =  $_SERVER['DOCUMENT_ROOT'].'/fintech_new/laravel/public/po_image/';
                    unlink($unlinkPath.$attachment->image);
                }
            }

            $purhaseOrderModel = new PurhaseOrderModel();
            $result = $purhaseOrderModel->deletePurhaseOrder($poId);
            
            return ['success'=> true, 'message' => 'Purhase Order has been deleted.'];
               
        }
    }



    /**
     *  remove Ticket Data By TicketId
     *
     * @param  $attachmentId INT
     * @return Ticket blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAttachmentById() {

        if (!empty($_GET['attachmentId']) && !empty($_GET['attachment'])) {
            $attachmentId = $_GET['attachmentId'];
            $attachment = $_GET['attachment'];
            $unlinkPath =  $_SERVER['DOCUMENT_ROOT'].'/fintech_new/laravel/public/po_image/';
            unlink($unlinkPath.$attachment);
            date_default_timezone_set('Asia/Kolkata');   
            $time =  date('d-m-Y h:i:s A');
            $ticketData = [
                'is_deleted_status' => 'Y',
                'deleted_at' => $time
            ];
            $deleteResults = DB::table('purchase_order_image')
              ->where('id', $attachmentId)
              ->update($ticketData);
          echo $attachmentId;

        }
    }



  /**
    *   report getPoReport
    *
    * @return getPoReport blude file    
    * @author <satishchauhan041@gmail.com>
    */
  
       public function getPoReport($poId = 0)
    {   

        $purchase_ordersArr = [];
        $purchase_order_attributesArr = [];
        
        $poIds = base64_decode($poId);  

        if (!empty($poIds)) {

            $purchase_ordersArr = DB::table('purchase_order')
                ->select('*')
                ->where('is_deleted_status', 'N')
                ->where('id', $poIds)
                ->get()
                ->toArray();

            if (!empty($purchase_ordersArr)) {
                foreach ($purchase_ordersArr as $key => $itemData) {

                    $itemUnitData = DB::table('item_master')
                        ->select('*')
                        ->where('is_deleted_status', 'N')
                        ->where('id', $itemData->item_id)
                        ->get()
                        ->toArray();

                    if (!empty($itemUnitData)) {
                        foreach ($itemUnitData as  $unitType) {
                            $purchase_ordersArr[$key]->itemNames = !empty($unitType->name) ? $unitType->name : '';
                            $purchase_ordersArr[$key]->unitId = !empty($unitType->unit_id) ? $unitType->unit_id : '';
                        } 
                    }


                    $itemUnitDatas = DB::table('unit_master')
                        ->select('*')
                        ->where('is_deleted_status', 'N')
                        ->where('id', $purchase_ordersArr[$key]->unitId)
                        ->get()
                        ->toArray();

                    if (!empty($itemUnitDatas)) { 
                        foreach ($itemUnitDatas as  $unitData) {
                            $purchase_ordersArr[$key]->unitName = !empty($unitData->unit) ? $unitData->unit : '';
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
                            $purchase_ordersArr[$key]->partyName = 
                            !empty($partyNameData->party_name) ? $partyNameData->party_name : '';
                    
                        } 
                    }
                } 
            }

            $attribute_item_id  = [];
            $attribute_item_id_values  = [];
            $attribute_item_name  = [];
            


            $getTicketAttachmentDatas = DB::select('SELECT * FROM attribute_item_master WHERE is_deleted_status = "N" 
                AND item_id = '.$itemData->item_id.'');
            
            if (!empty($getTicketAttachmentDatas)) { 
                foreach ($getTicketAttachmentDatas as $attachmentAttlist) {
                    $attribute_item_id[] = $attachmentAttlist->attribute_item_id;
                 // $attribute_item_id_values[] = $attachmentAttlist->value;
                }

                $attItemIdlist = !empty($attribute_item_id) ? implode(',', $attribute_item_id) : 0;

                $finDATA =  DB::table('item_attribute_master')
                    ->select('item_attribute_master.id','item_attribute_master.name','purchase_order_attribute.value')
                    ->join('purchase_order_attribute','purchase_order_attribute.attribute_item_id','=','item_attribute_master.id')
                    ->where('item_attribute_master.is_deleted_status', 'N')
                    ->where('purchase_order_attribute.is_deleted_status', 'N')
                    ->whereIN('purchase_order_attribute.attribute_item_id', $attribute_item_id)
                    ->where('purchase_order_attribute.item_id', $itemData->item_id)
                    ->where('purchase_order_attribute.po_id', $itemData->id)
                    ->orderBy('item_attribute_master.name', 'ASC')
                    ->get()
                    ->toArray();


                $getItemData = 
                DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" AND  id IN('.$attItemIdlist.') ORDER By name ASC ');
                
                /*if (!empty($getItemData)) {
                    foreach ($getItemData as $item) { 
                        $attribute_item_name[] = $item->name;
                        $attribute_item_id_values[] = $item->value;
                           
                    }
                }

                */

            if (!empty($finDATA)) {
                    foreach ($finDATA as $item) { 
                        $attribute_item_name[] = $item->name;
                        $attribute_item_id_values[] = $item->value;
                           
                    }
                }

            




            }

           // print_r($attribute_item_id_values);die;
            
        //   $reportFinalDate =  time().'_'.$itemData->po_no.'_'.date('d_m_Y').'_purchase_order_invoice.pdf';
           /* $fpdf = PDF::setOptions(['dpi' => 500]);
            $fpdf->setPaper('B4','landscape');
            $fpdf->save('laravel/storage/purchase_order_invoice/'.$reportFinalDate.'');
*/

/*            $fpdf = PDF::loadView('admin.attendanceReports',[
                'purchase_orders' => $purchase_ordersArr,
                'attribute_item_id_values'        => !empty($finDATA) ? $finDATA : 0,
                'attribute_item_name'        => $attribute_item_name,
            ]);

            PDF::setOptions(['dpi' => 500]);
*/         
            $reportFinalDate =  time().'_'.$itemData->po_no.'_'.date('d_m_Y').'_purchase_order_invoice.pdf';
         //   $fpdf = PDF::save('laravel/storage/purchase_order_invoice/'.$reportFinalDate.'');

          //  $fpdf->setPaper('B4','landscape');
           // $fpdf->save('laravel/storage/purchase_order_invoice/'.$reportFinalDate.'');
            
            //return  $fpdf->download($reportFinalDate);  
        
        
        } else {

           // $data['emptyAttendance'] = 'Select Month';
           // return view('admin.attendanceReport',$data);  
        }
        

        if (!empty($purchase_ordersArr)) {
            foreach ($purchase_ordersArr as $poData) {
                
                $partyNamess = !empty($poData->partyName) ? $poData->partyName : '';
                $partyPoNO = !empty($poData->po_no) ? $poData->po_no : '';
                $partyNamessPoDate = !empty($poData->po_date) ? $poData->po_date : '';


                            
                $pdf = new \Codedge\Fpdf\Fpdf\Fpdf('L', 'mm', 'A4');
                $pdf->AliasNbPages('{totalPages}');
                $pdf->AddPage();
                $pdf->AddFont('Verdana-Bold', 'B', 'verdanab.php');
                $pdf->AddFont('Verdana', '', 'Verdana.php');
                $pdf->SetAutoPageBreak(true);
                $pdf->SetFont('Verdana-Bold', 'B', 13);
                $pdf->cell(274, 6, 'Purchase Order(PO)', 'B', 0, 'C', '');
                $pdf->ln(10);

                $pdf->setFillColor(230, 230, 230);
                $pdf->SetFont('Verdana', '', 9);
                $pdf->cell(185, 6, 'Party Name : '.$partyNamess.'', 1, 0, 'L', '');
                $pdf->cell(39, 6, 'PO.No : '.$partyPoNO.'', 1, 0, 'L', '');
                $pdf->cell(50, 6, 'PO Date : '.$partyNamessPoDate, 1, 0, 'L', '');
                $pdf->ln();

                $pdf->SetFont('Verdana', '', 9);
                $pdf->SetWidths(array(185, 39, 50));
                $pdf->SetFont('Verdana-Bold', 'B', 9);
                $pdf->setFillColor(230, 230, 230);
                $pdf->cell(185, 6, 'Item Detail', 1, 0, 'L', '1');
                $pdf->cell(39, 6, 'Unit', 1, 0, 'L', '1');
                $pdf->cell(50, 6, 'Qty', 1, 0, 'L', '1');
                $pdf->ln();
                
                $pdf->SetFont('Verdana', '', 9);
                $pdf->SetWidths(array(185, 39, 50));
                $pdf->SetFont('Verdana', '', 12);
                
                $description = !empty($poData->itemNames) ? $poData->itemNames : '';
                $description .= !empty($poData->description) ?  $poData->description : '';

              
                if (!empty($attribute_item_name)) {
                   // $i = 0;
                    foreach ($attribute_item_name as $key => $values) {



                        $attribute_itemName = !empty($attribute_item_name[$key]) ? $attribute_item_name[$key] : '';

                        $attribute_item_id_valuesName = 
                        !empty($attribute_item_id_values[$key]) ? $attribute_item_id_values[$key] : '';


                        $description .= $attribute_itemName.' : '.$attribute_item_id_valuesName;
                    }
                }

                $pdf->row(array($description, ''.$poData->unitName.'', ''.number_format($poData->qty,2).''), 
                    array('L', 'L', 'L'), '', '', true, 5);
                    
                $pdf->Output($reportFinalDate,'D');
                
            }
        }
    }




  /**
    *  add jobCardAngularAdd using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function jobCardAngularAdd()
    {   
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $status = 'N';
        
        $jobCardData = [ 
            
            'po_id'            => !empty($_GET['po_id']) ? $_GET['po_id'] : 0,
            'item_category_id' => !empty($_GET['item_cat_ids']) ? $_GET['item_cat_ids'] : 0 ,
            'item_id'          => !empty($_GET['item_ids']) ? $_GET['item_ids'] : 0,
            'job_card_no'      => !empty($_GET['job_card_nos']) ? $_GET['job_card_nos'] : 0,
            'job_card_date'    => !empty($_GET['job_card_dates']) ? $_GET['job_card_dates'] : 0,
            'status'           => $status,
            'created_at'       => $time,
            'updated_at'       => $time,
            'deleted_at'       => $time,
            'created_by'       => 0,
            'edited_by'        => 0,
            'deleted_by'       => 0
            
        ];
        
        $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $getTicketAttachmentDatas = DB::select('SELECT * FROM job_card WHERE is_deleted_status = "N" 
            AND po_id = '.$jobCardData['po_id'].'');

        if (!empty($getTicketAttachmentDatas)) {
            foreach ($getTicketAttachmentDatas as $key => $itemAttss) { 
                $deleteResultss = DB::table('job_card_process_list')
                    ->where('job_card_id', $itemAttss->id)
                    ->update($purchaseDatasss);
            }
        }

        $deleteResults = DB::table('job_card')->where('po_id', $jobCardData['po_id'])->update($purchaseDatasss);
        $process_idArr = !empty($_GET['process_idArr']) ? $_GET['process_idArr'] : 0;
        $process_dateArr = !empty($_GET['process_dateArr']) ? $_GET['process_dateArr'] : 0;
        $noteArrs = !empty($_GET['noteArr']) ? $_GET['noteArr'] : 0;
        
        if (!empty(array_sum($process_dateArr))) {

            $insertJobCardRes = DB::table('job_card')->insertGetId($jobCardData);

            if (!empty($insertJobCardRes)) {

                foreach ($process_idArr as $key => $itemAtts) { 

                    $itemAttsArrs = [
                        'job_card_id'       => !empty($insertJobCardRes) ? $insertJobCardRes : 0,
                        'process_id'        => !empty($process_idArr[$key]) ? $process_idArr[$key] : 0,
                        'process_date'      => !empty($process_dateArr[$key]) ? $process_dateArr[$key] : 0,
                        'note'              => !empty($noteArrs[$key]) ? $noteArrs[$key] : 0,
                        'status'            => $status,
                        'created_at'        => $time,
                        'updated_at'        => $time,
                        'deleted_at'        => $time,
                        'created_by'        => 0,
                        'edited_by'         => 0,
                        'deleted_by'        => 0
                    ];
                    $insertResult = DB::table('job_card_process_list')->insertGetId($itemAttsArrs);
                }

            }
            Session::flash('message','Job Card has been added.');
        } 

    }

    
    




}