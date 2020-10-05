<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\ItemModel;
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


class ItemController extends Controller
{


   /**
     *  Item Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularItemForm() 
    { 
        return view('admin.item');
    }

  /**
    *  get ItemData using Angular
    *
    * @return ItemData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularItemView()
    { 
        $itemModel = new ItemModel();
        $getItemData = $itemModel->selectItem();
        return $getItemData;
    }

  /**
    *  add ItemData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAngularAdd(Request $request)
    {   
        
        $itemTypeId =  !empty($request->input('itemTypeId')) ? $request->input('itemTypeId') : 0;
            
         
        if ($itemTypeId == 2) {
            
            $this->validate($request,[
                'name'                         => 'required',
                'party_name'                   => 'required',
                'item_category_names'          => 'required',
                'gst'                          => 'required'
                
            ]);
            
        } else {
            
            $this->validate($request,[
                'name'                         => 'required',
                'gst'                          => 'required'
            ]);
            
        }
        
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $itemIds = 0;
        $itemCategoryId = 0;

        if (!empty($request->input('name'))) {

            $itemModel = new ItemModel();
            $resultName = $itemModel->itemNameAlredyExists(trim($request->input('name')),$itemIds); 
        }
        
        
        //$itemTypeId = !empty($request->input('itemId')) ? $request->input('itemId') : 0;
        
        
        $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
        

        if (empty($resultName)) { 
            
            $itemTypeId = !empty($request->input('itemTypeId')) ? $request->input('itemTypeId') : 0;
            
            if ($itemTypeId == 2) {
                $itemCategoryId = $request->input('item_category_names');
            }

            if ($itemTypeId == 2) {
                
                $itemData = [ 
                    'unit_id'           => $request->input('kt_select2_3_modal_unit'),
                    'item_type_id'      => $request->input('itemTypeId'),
                    'party_id'          => $request->input('party_name'),
                    'item_category_id'  => $itemCategoryId,
                    'name'              => $request->input('name'),
                    'gst'               => $request->input('gst'),
                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,
                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0,

                ];
                
            } else {

                $itemData = [ 

                    'unit_id'           => $request->input('kt_select2_3_modal_unit'),
                    'item_type_id'      => $request->input('itemTypeId'),
                    'party_id'          => 0,
                    'item_category_id'  => 0,
                    'name'              => $request->input('name'),
                    'gst'               => $request->input('gst'),
                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,
                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0,
                ];
                
            }
            
            $itemModel = new ItemModel();
            $itemResultId = $itemModel->itemInsert($itemData);
            
            $process_idArrss = [];
            
            if (!empty($itemResultId)) {
                
                if ($itemTypeId == 2) {
                    
                    $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
                    $deleteResult = DB::table('item_attribute_value')->where('item_id', $itemResultId)->update($purchaseDatasss);
                    
                    $process_idArr = !empty($request->input('process_idsss')) ? $request->input('process_idsss') : 0;
                    
                  //  $process_idArrss =  explode(',', $process_idArr);
                    
                    $valueArr = !empty($request->input('value')) ? $request->input('value') : 0;
                    
                    if (!empty($valueArr)) {

                     //   $i = 4;
                        foreach ($valueArr as $key => $itemAtt) {
                            
                            $itemAttIdArr = [
                                'item_id'            => !empty($itemResultId) ? $itemResultId : 0,
                                'attribute_item_id'  => !empty($process_idArr[$key]) ? $process_idArr[$key] : 0,
                                'value'              => !empty($valueArr[$key]) ? $valueArr[$key] : 0,
                                'status'            => $status,
                                'created_at'        => $time,
                                'updated_at'        => $time,
                                'deleted_at'        => $time,
                                'created_by'        => 0,
                                'edited_by'         => 0,
                                'deleted_by'        => 0
 
                            ];
                            $itemModel = new ItemModel();
                            $itemModel->itemAttDetailsInserts($itemAttIdArr);
                           // $i++;
                        }
                    }
                
                
                
                    // $itemAttId = !empty($request->input('itemAttId')) ? $request->input('itemAttId') : 0;
                    
                

                        /*if (!empty($itemAttId)) {
                    foreach ($itemAttId as $key => $itemAtt) {
                        $itemAttIdArr = [
                            'item_id'            => !empty($itemResultId) ? $itemResultId : 0,
                            'attribute_item_id'  => !empty($itemAttId[$key]) ? $itemAttId[$key] : 0,
                            'status'            => $status,
                            'created_at'        => $time,
                            'updated_at'        => $time,
                            'deleted_at'        => $time,
                            'created_by'        => 0,
                            'edited_by'         => 0,
                            'deleted_by'        => 0
                        ];

                        $itemModel->itemAttDetailsInsert($itemAttIdArr);
                    }
                }
                */
                }
                
                
                
            }
            
            Session::flash('message','Item has been added.');
            return redirect('item');

            //return ['success'=> true,'message' => 'Item has been added.'];
                
        } else {
            
            return view('admin.item', [
                'nameText' => $nameText,
            ]);
            
            
            //return ['success'=> true,'nameText' => $nameText ];

        } 

    }
    

  /**
    *  update ItemData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAngularEdit(Request $request)
    {   
        
      
        
        $itemTypeId = !empty($request->input('itemTypeId')) ? $request->input('itemTypeId') : 0;
            
         
        if ($itemTypeId == 2) {
            
            $this->validate($request,[
                'name'                         => 'required',
                'party_name'                   => 'required',
                'item_category_names'          => 'required',
                'gst'                          => 'required'
                
            ]);
            
        } else {
            
            $this->validate($request,[
                'name'                         => 'required',
                'gst'                          => 'required'
            ]);
            
        }
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';
        $itemIds = 0;
        $itemCategoryId = 0;
        $itemIds = $request->input('itemId');
        
        
        if (!empty($request->input('name'))) {
            $itemModel = new ItemModel();
            $resultName = $itemModel->itemNameAlredyExists(trim($request->input('name')),$itemIds); 
        }  
        
        $itemTypeId = !empty($request->input('itemTypeId')) ? $request->input('itemTypeId') : 0;
        
        
        $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
        
        
        if (empty($resultName)) { 
    
            $itemTypeId = !empty($request->input('itemTypeId')) ? $request->input('itemTypeId') : 0;
            if ($itemTypeId == 2) {
                $itemCategoryId = $request->input('item_category_names');
            }
 
            if ($itemTypeId == 2) {
                
                $itemData = [ 
                    'unit_id'           => $request->input('kt_select2_3_modal_unit'),
                    'item_type_id'      => $request->input('itemTypeId'),
                    'party_id'          => $request->input('party_name'),
                    'item_category_id'  => $itemCategoryId,
                    'name'              => $request->input('name'),
                    'gst'               => $request->input('gst'),
                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,
                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0,

                ];
                
            } else {

                $itemData = [ 

                    'unit_id'           => $request->input('kt_select2_3_modal_unit'),
                    'item_type_id'      => $request->input('itemTypeId'),
                    'party_id'          => 0,
                    'item_category_id'  => 0,
                    'name'              => $request->input('name'),
                    'gst'               => $request->input('gst'),
                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,
                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0,
                ];
                
            }
            
            
            $itemModel = new ItemModel();
            $itemResult = $itemModel->updateItem($itemData,$itemIds);
            
            $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
            $deleteResult = DB::table('item_attribute_value')->where('item_id', $itemIds)->update($purchaseDatasss);
            
            
            /*if (!empty($itemIds)) {
                $itemAttId = !empty($request->input('itemAttId')) ? $request->input('itemAttId') : 0;
                if (!empty($itemAttId)) {
                    foreach ($itemAttId as $key => $itemAtt) {
                        $itemAttIdArr = [
                            'item_id'            => !empty($itemIds) ? $itemIds : 0,
                            'attribute_item_id'  => !empty($itemAttId[$key]) ? $itemAttId[$key] : 0,
                            'status'            => $status,
                            'created_at'        => $time,
                            'updated_at'        => $time,
                            'deleted_at'        => $time,
                            'created_by'        => 0,
                            'edited_by'         => 0,
                            'deleted_by'        => 0
                        ];

                        $itemModel->itemAttDetailsInsert($itemAttIdArr);
                    }
                }
            }*/
            
            if (!empty($itemIds)) {
            
                if ($itemTypeId == 2) {
                
                    $process_idArr = !empty($request->input('process_idsss')) ? $request->input('process_idsss') : 0;
                 
                 //   $process_idArrss =  explode(',', $process_idArr);
                 
                    $valueArr = !empty($request->input('value')) ? $request->input('value') : 0;

                    if (!empty($valueArr)) {

                       // $i = 4;
                       
                        foreach ($valueArr as $key => $itemAtt) {
                            
                            $itemAttIdArr = [

                                'item_id'            => !empty($itemIds) ? $itemIds : 0,
                                'attribute_item_id'  => !empty($process_idArr[$key]) ? $process_idArr[$key] : 0,
                                'value'              => !empty($valueArr[$key]) ? $valueArr[$key] : 0,
                                'status'            => $status,
                                'created_at'        => $time,
                                'updated_at'        => $time,
                                'deleted_at'        => $time,
                                'created_by'        => 0,
                                'edited_by'         => 0,
                                'deleted_by'        => 0
                            ];
                            
                            $itemModel = new ItemModel();
                            $itemModel->itemAttDetailsInserts($itemAttIdArr);
                           // $i++;
                        }
                    }
                  
                    /*
                    $itemAttId = !empty($request->input('itemAttId')) ? $request->input('itemAttId') : 0;
                    if (!empty($itemAttId)) {
                      foreach ($itemAttId as $key => $itemAtt) {
                          $itemAttIdArr = [
                              'item_id'            => !empty($itemIds) ? $itemIds : 0,
                              'attribute_item_id'  => !empty($itemAttId[$key]) ? $itemAttId[$key] : 0,
                              'status'            => $status,
                              'created_at'        => $time,
                              'updated_at'        => $time,
                              'deleted_at'        => $time,
                              'created_by'        => 0,
                              'edited_by'         => 0,
                              'deleted_by'        => 0
                          ];

                          $itemModel->itemAttDetailsInsert($itemAttIdArr);
                      }
                    }*/
                }
            }
            
            //return ['success'=> true,'message' => 'Item has been updated.'];
            
            Session::flash('message','Item has been updated.');
            return redirect('item');

        
        } else {
            
            $itemModel = new ItemModel();
            $getItemDataByID = $itemModel->selectItemDataByID($itemIds);
            
            return view('admin.item', [
                'nameText' => $nameText,
                'getItemDataByID' => $getItemDataByID
            ]);
            
            //return ['success'=> true,'nameText' => $nameText ];   
            
        } 

    }

   /**
     *  delete Item By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularItem(Request $request)
    {
        
        $itemId = $request->input('id');
        if (!empty($itemId)) {
            $itemModel = new ItemModel();
            $result = $itemModel->deleteItem($itemId);
            return ['success'=> true, 'message' => 'Item has been deleted.'];
        }
    
    }

    
   /**
     *  delete Item By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularItemFormss($itemAttValId = null)
    { 
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $processIds = base64_decode($itemAttValId);
        $getItemDataByID = DB::table('item_attribute_value')->where('id', $processIds)->get();
       
        $itemId = !empty($getItemDataByID[0]->item_id) ? $getItemDataByID[0]->item_id : 0;
        
        $itemModel = new ItemModel();
        $getItemDataByID = $itemModel->selectItemDataByID($itemId);
        
        if (!empty($processIds)) {
            
            $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
            $deleteResult = DB::table('item_attribute_value')->where('id', $processIds)->update($purchaseDatasss);
        }
        
        Session::flash('message','Item Attribute has been deleted.');
    
        return view('admin.item', [
            'getItemDataByID' => $getItemDataByID, 
        ]);
        
        
        
    }



   /**
     *  delete Item By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularItemFormsstttt($processId = null)
    { 

        
      date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $processIds = base64_decode($processId);
        
          
        
        if (!empty($processIds)) {
            
            $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
            $deleteResult = DB::table('item_cylinder_detail')
                ->where('id', $processIds)
                ->update($purchaseDatasss);
            


        }
        
        
        Session::flash('message','Item Cylinder Detail has been deleted.');
      
      return redirect('item');

      
        
    }
    
    
  /**
    *  add ItemData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemDetailsAngularAdd(Request $request)
    {   
        

        $item_id_sId =  $request->input('item_id_s');
        $cylinder_nameArr =  $request->input('cylinder_named_'.$item_id_sId);
        $valueArr   =  $request->input('value_'.$item_id_sId);
            
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $status = 'N';
              
        $item_cylinder_detailss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $deleteResult = DB::table('item_cylinder_detail')->where('item_id', $item_id_sId)->update($item_cylinder_detailss);
                
        if (!empty($cylinder_nameArr)) {
            
            foreach ($cylinder_nameArr as $key => $itemAtt) {
                      
                $item_cylinder_detailArr = [

                    'item_id'            => !empty($item_id_sId) ? $item_id_sId : 0,
                    'cylinder_name'      => !empty($cylinder_nameArr[$key]) ? $cylinder_nameArr[$key] : 0,
                    'value'              => !empty($valueArr[$key]) ? $valueArr[$key] : 0,
                    'status'             => $status,
                    'created_at'         => $time,
                    'updated_at'         => $time,
                    'deleted_at'         => $time,
                    'created_by'         => 0,
                    'edited_by'          => 0,
                    'deleted_by'         => 0
                  
                ];
                
                $itemModel = new ItemModel();
                $itemModel->item_cylinder_detailInsert($item_cylinder_detailArr);
            }
            
            Session::flash('message','Item Cylinder Detail has been added.');
            return redirect('item');    
        }
        
    }
    





   /**
     *  delete Item By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function addAngularItemFormssttttdisay()
    { 

        if (!empty($_GET['itemId'])) {

            $getcylinder_nameArr = DB::table('item_cylinder_detail')
              ->where('item_id', $_GET['itemId'])
              ->where('is_deleted_status', 'N')
              ->get();

            
            if (!empty($getcylinder_nameArr)) {
                $htmls = '';
                foreach ($getcylinder_nameArr as $key => $getcylinder_names) {

                      $getcylinderNames = !empty($getcylinder_names->cylinder_name) ?  $getcylinder_names->cylinder_name : '';
                      $getcylinderValues = !empty($getcylinder_names->value) ?  $getcylinder_names->value : '';
                                           
                
                    $htmls .=  '<div class="row" id="removeQty_'.$getcylinder_names->id.'"><div class="col-md-5"><div class="form-group"><span class="control-label"><input type="text" name="cylinder_named_'.$_GET['itemId'].'[]" id="" value="'.$getcylinderNames.'"  class="form-control abc" placeholder="Detail Caption"></span></div></div><div class="col-md-5"><div class="form-group row"><span class="control-label"><input type="text" 
                    name="value_'.$_GET['itemId'].'[]" id="values" class="form-control abc" placeholder="Value" 
                    value="'.$getcylinderValues.'" style="width: 235px" ></span></div></div><div class="col-md-2"><div class="form-group row"><button type="button" onclick="deleteQtysCylinderss('.$getcylinder_names->id.')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div></div>';
                } 
                echo $htmls;

            }
            
        }
    }
    
    
    


   /**
     *  delete Item By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function addAngularItemFormsstttt()
    {   
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $status = 'N';
        
        $cylinder_nameArr =  !empty($_GET['cylinder_nameArr']) ? $_GET['cylinder_nameArr'] : 0;
        $valueArr =  !empty($_GET['valueArr']) ? $_GET['valueArr'] : 0;
        $itemResultId =  !empty($_GET['itemId']) ? $_GET['itemId'] : 0;
        
        $item_cylinder_detailss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $deleteResult = DB::table('item_cylinder_detail')->where('item_id', $itemResultId)->update($item_cylinder_detailss);
        
        
        
        if (!empty($cylinder_nameArr)) {


            foreach ($cylinder_nameArr as $key => $itemAtt) {


                $item_cylinder_detailArr = [

                    'item_id'            => !empty($itemResultId) ? $itemResultId : 0,
                    'cylinder_name'      => !empty($cylinder_nameArr[$key]) ? $cylinder_nameArr[$key] : 0,
                    'value'              => !empty($valueArr[$key]) ? $valueArr[$key] : 0,
                    'status'             => $status,
                    'created_at'         => $time,
                    'updated_at'         => $time,
                    'deleted_at'         => $time,
                    'created_by'         => 0,
                    'edited_by'          => 0,
                    'deleted_by'         => 0
                  
                ];

                        
                $itemModel = new ItemModel();
                $itemModel->item_cylinder_detailInsert($item_cylinder_detailArr);
          
            }

        }
        
        Session::flash('message','Item Cylinder Detail has been added.');

        
    }





   /**
     * itemData By itemId  using angular
     *
     * @param  Request $request
     * @return $itemListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemAngularById(Request $request)
    {
        
        $unitId = $request->input('unit_id');
        if (!empty($unitId)) {
            $getUnitData = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N"');
            foreach ($getUnitData as $roleUnit) {
                $itemListHtml =  '<option value="'.$roleUnit->id.'"';
                
                if ($unitId == $roleUnit->id) { 
                    $itemListHtml .= ' selected="selected"';
                }

                $itemListHtml .= '>'.$roleUnit->unit.'</option>';
                echo $itemListHtml; 
            } 
        }
    }


   /**
     * processItemCategoryData By itemId  using angular
     *
     * @param  Request $request
     * @return $itemCategoryListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectProcessItemCategoryAngularById(Request $request)
    {
        
        $itemCategoryId = $request->input('item_category_id');
        if (!empty($itemCategoryId)) {
            $getItemCategoryIdData = DB::select('SELECT * FROM item_category_master WHERE is_deleted_status = "N"');
            foreach ($getItemCategoryIdData as $itemCategoryData) {

                $itemCategoryListHtml =  '<option value="'.$itemCategoryData->id.'"';
                
                if ($itemCategoryId == $itemCategoryData->id) { 
                    $itemCategoryListHtml .= ' selected="selected"';
                }

                $itemCategoryListHtml .= '>'.$itemCategoryData->name.'</option>';

                echo $itemCategoryListHtml; 

            } 

        }
    }



   /**
     * selectItemTypeSelectd By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemTypeSelectd()
    {
        
        $itemTypeIds = !empty($_GET['itemTypeIds']) ? $_GET['itemTypeIds'] : '';
        

        if (!empty($itemTypeIds)) {

            $getItemTypeIdData = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');

            if (!empty($getItemTypeIdData)) {

                foreach ($getItemTypeIdData as $itemType) {

                    $itemTpyeListHtml =  '<option value="'.$itemType->id.'"';
                    
                    if ($itemTypeIds == $itemType->id) { 

                        $itemTpyeListHtml .= ' selected="selected"';

                    }

                    $itemTpyeListHtml .= '>'.$itemType->name.'</option>';

                    echo $itemTpyeListHtml; 

                }

            }
        }
    }





   /**
     * selectItemTypeSelectd By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemTypeSelectds()
    {
        
       // $itemTypeIds = !empty($_GET['itemTypeIds']) ? $_GET['itemTypeIds'] : '';
        

      //  if (!empty($itemTypeIds)) {

            $getItemTypeIdDatas = DB::select('SELECT * FROM item_type_master WHERE is_deleted_status = "N"');

            if (!empty($getItemTypeIdDatas)) {

                foreach ($getItemTypeIdDatas as $itemTypes) {

                    $itemTpyesListHtml =  '<option value="'.$itemTypes->id.'"';
                    
                            

                    $itemTpyesListHtml .= '>'.$itemTypes->name.'</option>';

                    echo $itemTpyesListHtml; 

                }

            }
       // }
    }



   /**
     * selectItemTypeSelectd By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selecUnitdSelectds()
    {
        
    //    $itemTypeIds = !empty($_GET['itemTypeIds']) ? $_GET['itemTypeIds'] : '';
        

      //  if (!empty($itemTypeIds)) {

            $getUnitsIdData = DB::select('SELECT * FROM unit_master WHERE is_deleted_status = "N"');

            if (!empty($getUnitsIdData)) {

                foreach ($getUnitsIdData as $units) {

                    $unitsListHtml =  '<option value="'.$units->id.'"';
                    $unitsListHtml .= '>'.$units->unit.'</option>';

                    echo $unitsListHtml; 

                }

            }
       // }
    }
    


        
   /**
     * selectItemTypeSelectd By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectgetValueSelectd()
    {
       
       // $itemTypeIds = !empty($_GET['itemTypeIds']) ? $_GET['itemTypeIds'] : '';
        
$itemCatListHtml = '';
          
      //  if (!empty($itemTypeIds)) {

            $getItemCatDatas = DB::select('SELECT * FROM item_category_master WHERE is_deleted_status = "N"');

            if (!empty($getItemCatDatas)) {

              $itemCatListHtmlsss = '<option value="">Select Item Category Name</option>';

                foreach ($getItemCatDatas as $itemCat) {

                    $itemCatListHtml .=  '<option value="'.$itemCat->id.'"';
                    $itemCatListHtml .= '>'.$itemCat->name.'</option>';

                  //  echo $itemCatListHtml; 

                }

                echo $itemCatListHtmlsss.$itemCatListHtml;

            }
       // }
                 
       
    }
    
    
    
   /**
     * selectPartyNameSelectds By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectPartyNameSelectds()
    {


        $getItemCatDatas = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND 
                user_type = 1 ORDER BY party_name  ASC ');

        if (!empty($getItemCatDatas)) {

            $itemCatListHtmls = '<option value=""> Select Party Name</option>';

            $itemCatListHtml = '';
            foreach ($getItemCatDatas as $itemCat) {
                $itemCatListHtml  .=  '<option value="'.$itemCat->id.'"';
                $itemCatListHtml .= '>'.$itemCat->party_name.'</option>';

            }

            echo $itemCatListHtmls.$itemCatListHtml;

        }

    }
    
   /**
     * selectItemAtttrubute By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemAtttrubute()
    {
            

        $getItemCatDatas = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" ');

        if (!empty($getItemCatDatas)) {

            foreach ($getItemCatDatas as $itemCat) {

                $itemCatListHtml =  '<option value="'.$itemCat->id.'"';
                $itemCatListHtml .= '>'.$itemCat->name.'</option>';

                echo $itemCatListHtml; 

            }

        }

    }
    

   /**
     * selectPartyNameSelectds By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectEditPartyNameSelectds(Request $request)
    {   

        $itemPartyNameHtml = '';
        $selected = '';
            
       if (!empty($request->input('party_id'))) {
           
           
            
            $selectEditPartyNameSelectds = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND 
                user_type = 3 ORDER BY party_name  ASC');
                
                
            if (!empty($selectEditPartyNameSelectds)) {
                
                $itemPartyNameHtml = '';

                foreach ($selectEditPartyNameSelectds as $editPartyNames) {
                    $selected = '';

                    if ($editPartyNames->id == $request->input('party_id')) {
                        
                        $selected = 'selected=selected';
                    }

                    $itemPartyNameHtml .=  '<option value="'.$editPartyNames->id.'" '.$selected.'';
                    
                    $itemPartyNameHtml .= '>'.$editPartyNames->party_name.'</option>';
                    
                    
                }
                
                echo $itemPartyNameHtml;

            }

       } else {


             $selectEditPartyNameSelectds = DB::select('SELECT * FROM user_master WHERE is_deleted_status = "N" AND 
                user_type = 3 ORDER BY party_name  ASC ');



            if (!empty($selectEditPartyNameSelectds)) {

                            $itemPartyNameHtmls = '<option value=""> Select Party Name</option>';

                foreach ($selectEditPartyNameSelectds as $editPartyNames) { 
                    
                    $itemPartyNameHtml = '';

                    $itemPartyNameHtml .=  '<option value="'.$editPartyNames->id.'" '.$selected.'';
                    $itemPartyNameHtml .= '>'.$editPartyNames->party_name.'</option>';
                   // echo $itemPartyNameHtml; 
                    
                }

                            echo $itemPartyNameHtmls.$itemPartyNameHtml;


            }


       }


    }
    
    
   /**
     * selectEditItemAtttrubute By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectEditItemAtttrubute(Request $request)
    {
        
        $processId = [];
        if (!empty($request->input('item_id'))) {
            $itemCategoryId = $request->input('item_id');
            if (!empty($itemCategoryId)) {

                $getItemCategoryIdData = DB::select('SELECT * FROM attribute_item_master WHERE is_deleted_status = "N" 
                    AND item_id = '.$itemCategoryId.'');

                if (!empty($getItemCategoryIdData)) {
                    foreach ($getItemCategoryIdData as $itemCategoryData) {
                        $processId[] =  $itemCategoryData->attribute_item_id;
                    } 
                }
    
              //  if (!empty($processId)) {
                    $getProcessDatas = DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N" ORDER BY name ASC');
                    if (!empty($getProcessDatas)) { 
                    foreach ($getProcessDatas as $process) {

                        $processHtml =  '<option value="'.$process->id.'"';
                        
                        if (in_array($process->id, $processId)) { 

                            $processHtml .= ' selected="selected"';

                        }

                        $processHtml .= '>'.$process->name.'</option>';
                        echo $processHtml;
                    }

                    }
              //  }

            }
        
        }
    }
    
    
    
   /**
     * getselectItemAtttrubutess By itemTypeId  using angular
     *
     * @param  Request $request
     * @return $ItemtypeListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function getselectItemAtttrubutess(Request $request)
    {
        $processName = ''; 

        $html='';

        if (!empty($request->input('item_id'))) {

            $item_attribute_valueData =  DB::select('SELECT * FROM item_attribute_value WHERE is_deleted_status = "N"
              AND  item_id = '.$request->input('item_id').'');
            if (!empty($item_attribute_valueData))  {
              foreach ($item_attribute_valueData as $key => $datass) {
                  $attribute_item_idArr[] = $datass->attribute_item_id;
                  $valueArr[] = $datass->value;
                  $processName = '<select class="form-control form-control" style="width: 160%" name="process_idsss[]" id="kt_select2_3_modal_3_items_'.$request->input('item_id').'" >';

                  $getProcessDataArr =  DB::select('SELECT * FROM item_attribute_master WHERE is_deleted_status = "N"');
                  if (!empty($getProcessDataArr)) {
                    foreach ($getProcessDataArr as $process) {  
                      $processNameselected = '';
                      if ($datass->attribute_item_id == $process->id) {
                          $processNameselected = 'selected="selected"';
                      }
                      
                      $processName .= '<option value="'.$process->id.'" '.$processNameselected.'>'.$process->name.'</option>';
                      
                    }


                  }


                  $processName .= '</select>';






    //      $randomQtyNO = rand(10,100);


          if (!empty($datass->value)) {


            $html .= '<div class="row" id="removeQty_'.$datass->id.'"><div class="col-md-4"><div class="form-group row"><label class="control-label text-right  col-md-5 col-form-label"><b class="abcs" style="font-size:9px;">Item Attribute Name :</b></label><div class="col-md-7">'.$processName.'</div></div></div><div class="col-md-5"><div class="form-group row"><label class="control-label text-right  col-md-4 col-form-label"><b class="abcs" style="font-size:9px;">Value :</b></label><div class="col-md-7"><input type="text" id="value" name="value[]" class="form-control abc" value="'.$datass->value.'" placeholder="Value" /><span class="text-danger abc" id="emptyGst" style="font-size: 11px"></span></div></div></div><div class="col-md-1"><div class="form-group row"><button type="button" onclick="deleteQtys('.$datass->id.')" class="btn btn-sm btn-danger"><i class="text-dark-10 flaticon2-trash"></i></button></div></div></div></div>';

            


          }



        }
        

              }


            echo $html;

          }
      



    }
    
    
    
    
   /**
     *  get getAngularProcessDataByID By processId and using angular
     *
     * @param  $processId INT
     * @return processId blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularItemByID($processId = null)
    {   
        
        $processIds = base64_decode($processId);
        
        if (!empty($processIds)) {
            
            $itemModel = new ItemModel();
            $getItemDataByID = $itemModel->selectItemDataByID($processIds);
            
        }

        return view('admin.item', [
            'getItemDataByID' => $getItemDataByID, 
        ]);
        
    }
    
    
    
   /**
     *  delete Process By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularItemById($processId = null)
    {
        
        $processIds = base64_decode($processId);
        
        //$processId = $request->input('id');
        
        if (!empty($processIds)) {
            
            $itemModel = new ItemModel();
            $result = $itemModel->deleteItem($processIds);
            //return ['success'=> true, 'message' => 'Process has been deleted.'];
            
        }
        
        Session::flash('message','Item has been deleted.');
        
        //return view('admin.process');
        return redirect('item');
        
    }
    
    







}