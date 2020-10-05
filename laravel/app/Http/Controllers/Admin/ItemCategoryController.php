<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\ItemCategoryModel;
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


class ItemCategoryController extends Controller
{


   /**
     *  itemCategory Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularItemCategoryForm() 
    { 
        return view('admin.itemcategory');
    }   

  /**
    *  get itemCategoryData using Angular
    *
    * @return itemCategoryData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularItemCategoryView()
    { 

        $projectModel = new ItemCategoryModel();
        $getProjectData = $projectModel->selectItemCategory();
        foreach ($getProjectData as $key =>  $projectData) {
            $getProjectDatad =   DB::select('SELECT * FROM process_item_category_master WHERE is_deleted_status = "N" 
                AND item_category_id = '.$projectData->id.'');
            $userName = '';
            $userNames = '';
            $usersIds = '';
            $usersId = '';
            $userIdArrd = [];
            if (!empty($getProjectDatad)) {
                foreach ($getProjectDatad as $projectd) {
                    $userIdArrd[] = $projectd->process_id;
                }   
            }

            $userIded = implode(',', $userIdArrd);
            $userIA = !empty($userIded) ? $userIded : 0;
            $getUserNameDatad = DB::select('SELECT * FROM `process_master` WHERE is_deleted_status = "N" AND id IN('.$userIA.')');
            if (!empty($getUserNameDatad)) {

                foreach ($getUserNameDatad as $user) {
                    $userName .= ' '.$user->name.' ,';
                    $usersId .= $user->id.',';
                } 
                $userNames =  rtrim($userName,',');
                $usersIds =  rtrim($usersId,',');

            }
            
            $getProjectData[$key]->username = $userNames;
            $getProjectData[$key]->userId = $usersIds;
        }


      //  return $getProjectData;

        






      /*  $itemCategoryModel = new ItemCategoryModel();
        $getItemCategoryData = $itemCategoryModel->selectItemCategory();

        $itemCategoryProcessStr = 0;
        $processId = 0;

        if (!empty($getItemCategoryData)) {
            
            foreach ($getItemCategoryData as $key => $itemCategory) { 

                $getProcessItemCategoryData = DB::table('process_item_category_master')
                ->select('*')
                ->where('item_category_id', $itemCategory->id)
                ->where('is_deleted_status', 'N')
                ->get()
                ->toArray();

                $itemCategoryProcessId = [];
                
                if (!empty($getProcessItemCategoryData)) {
                    foreach ($getProcessItemCategoryData as $key => $processItemCategory) { 
                        $itemCategoryProcessId[] = $processItemCategory->process_id;
                                    
                    }
                }

                $processId = !empty($itemCategoryProcessId) ?  implode(',', $itemCategoryProcessId) : ''; 
                
                $getProcessData = DB::select('SELECT name FROM process_master WHERE is_deleted_status = "N" AND id IN('.$processId.') ');
                
                $processArr = [];    
                if (!empty($getProcessData)) {
                    foreach ($getProcessData as $process) { 
                        $processArr[] = $process->name;               
                    }
                    $processNameArrs = !empty($processArr) ?  implode(',', $processArr) : ''; 
                    
                }   
                    
                $getItemCategoryData[$key]->processNameArr = !empty($processNameArrs) ? $processNameArrs : '';
                    

            }

                            
        }
        */
        
        return $getProjectData;
    }

  /**
    *  add itemCategoryData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemCategoryAngularAdd(Request $request)
    {   
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $itemCategoryIds = 0;
        $processIdArr = $request->input('select2_itemCategory');
        
        if (!empty($processIdArr)) {
        
            if (!empty($request->input('name'))) {
                $itemCategoryModel = new ItemCategoryModel();
                $resultName = $itemCategoryModel->itemCategoryNameAlredyExists(trim($request->input('name')),$itemCategoryIds); 
            }
            
            $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
            
            
            if (empty($resultName)) {     
        
                $itemCategoryData = [ 
                    'name'        => $request->input('name'),
                    'status'      => $status,
                    'created_at'  => $time,
                    'updated_at'  => $time,
                    'deleted_at'  => $time,
                    'created_by'  => 0,
                    'edited_by'   => 0,
                    'deleted_by'  => 0
                ];
                
                $itemCategoryModel = new ItemCategoryModel();
                $itemCategoryResult = $itemCategoryModel->itemCategoryInsert($itemCategoryData);
    
                if (!empty($itemCategoryResult)) {
                    
                    foreach ($processIdArr as  $process_id) {
                        
                        $itemCategoryData = [
                            'item_category_id' => $itemCategoryResult,
                            'process_id'    => $process_id,
                            'status'      => $status,
                            'created_at'  => $time,
                            'updated_at'  => $time,
                            'deleted_at'  => $time,
                            'created_by'  => 0,
                            'edited_by'   => 0,
                            'deleted_by'  => 0
                        ]; 
                        
                        $insertResult = DB::table('process_item_category_master')->insert($itemCategoryData);
                    }
                }
                
                Session::flash('message','Item Category has been added.');
                return redirect('itemcategory');
            
                
            } else {
                
                return view('admin.itemcategory', [
                    'nameText' => $nameText,
                ]);
               
            } 
            
        } else {
            
            return view('admin.itemcategory', [
                'nameTexts' => 'Please Select Process',
            ]);
            
            
        }
        
    }
    

  /**
    *  update itemCategoryData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function itemCategoryAngularEdit(Request $request)
    {
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';
        
        $itemCategoryIds = 0;
        $itemCategoryIds = $request->input('itemCatId');
        $processIdArr = $request->input('select2_itemCategory');
        
        if (!empty($processIdArr)) {
            
            if (!empty($request->input('name'))) {
                $itemCategoryModel = new ItemCategoryModel();
                $resultName = $itemCategoryModel->itemCategoryNameAlredyExists(trim($request->input('name')),$itemCategoryIds); 
            }  
            
            $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
            
            if (empty($resultName)) {     
            
                $itemCategoryData = [ 
                    'name'        => $request->input('name'),
                    'status'      => $status,
                    'created_at'  => $time,
                    'updated_at'  => $time,
                    'deleted_at'  => $time,
                    'created_by'  => 0,
                    'edited_by'   => 0,
                    'deleted_by'  => 0
                ];
    
                $itemCategoryModel = new ItemCategoryModel();
                $itemCategoryResult = $itemCategoryModel->updateItemCategory($itemCategoryData,$itemCategoryIds);
                
                $itemCategoryDataDel = ['is_deleted_status' => 'Y','deleted_at' => $time];
                $deleteResult = DB::table('process_item_category_master')
                    ->where('item_category_id', $itemCategoryIds)
                    ->update($itemCategoryDataDel);
                    
                if (!empty($itemCategoryResult)) {
                    
                    foreach ($processIdArr as  $process_id) {
                        
                        $itemCategoryData = [
                            'item_category_id' => $itemCategoryIds,
                            'process_id'    => $process_id,
                            'status'      => $status,
                            'created_at'  => $time,
                            'updated_at'  => $time,
                            'deleted_at'  => $time,
                            'created_by'  => 0,
                            'edited_by'   => 0,
                            'deleted_by'  => 0
                        ]; 
                    
                        $insertResult = DB::table('process_item_category_master')->insert($itemCategoryData);
    
                    }
                }
                
                Session::flash('message','Item Category has been updated.');
                return redirect('itemcategory');
                
                //return ['success'=> true,'message' => 'Item Category has been updated.'];
            
            } else {
                
                
                $itemCategoryModel = new ItemCategoryModel();
                $getAngularItemCategoryByID = $itemCategoryModel->selectItemCategoryDataByID($itemCategoryIds);
                
                return view('admin.itemcategory', [
                    'nameText' => $nameText,
                    'getItemCategoryDataByID' => $getAngularItemCategoryByID,
                ]);
                
                
            } 
        
            
        } else {
            
            return view('admin.itemcategory', [
                'nameTexts' => 'Please Select Process',
            ]);
            
        }

    }

   /**
     *  delete itemCategory By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularItemCategory(Request $request)
    {   
        $itemCategoryId = $request->input('id');
        if (!empty($itemCategoryId)) {
            $itemCategoryModel = new ItemCategoryModel();
            $result = $itemCategoryModel->deleteItemCategory($itemCategoryId);
            
            return ['success'=> true, 'message' => 'Item Category has been deleted.'];
        }
    }
    
    
    
   /**
     * selectItemCategoryById By itemId  using angular
     *
     * @param  Request $request
     * @return $itemCategoryListHtml    
     * @author <satishchauhan041@gmail.com>
     */
    public function selectItemCategoryById(Request $request)
    {
        
        $itemCategoryId = $request->input('itemCategoryId');
        
        if (!empty($itemCategoryId)) {
            
            $getItemCategoryIdData = DB::select('SELECT * FROM process_item_category_master WHERE is_deleted_status = "N" 
            AND item_category_id = '.$itemCategoryId.'');
            if (!empty($getItemCategoryIdData)) {
                foreach ($getItemCategoryIdData as $itemCategoryData) {
                    $processId[] =  $itemCategoryData->process_id;
                } 
            }

            $getProcessDatas = DB::select('SELECT * FROM process_master WHERE is_deleted_status = "N"');
            
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
            
        }
        
    }
    
    
    
    
   /**
     *  delete Process By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularItemCategoryById($processId = null)
    {
        
        $processIds = base64_decode($processId);
        //$processId = $request->input('id');
        
        if (!empty($processIds)) {
            
            $itemCategoryModel = new ItemCategoryModel();
            $result = $itemCategoryModel->deleteItemCategory($processIds);
          
            //return ['success'=> true, 'message' => 'Process has been deleted.'];
            
        }
        
        Session::flash('message','Item Category has been deleted.');
        return redirect('itemcategory');
        
    }
    
    
    
   /**
     *  get getAngularProcessDataByID By processId and using angular
     *
     * @param  $processId INT
     * @return processId blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularItemCategoryByID($processId = null)
    {   
        
        $processIds = base64_decode($processId);
        
        if (!empty($processIds)) {
            $itemCategoryModel = new ItemCategoryModel();
            $getAngularItemCategoryByID = $itemCategoryModel->selectItemCategoryDataByID($processIds);
            
        }

        return view('admin.itemcategory', [
            'getItemCategoryDataByID' => $getAngularItemCategoryByID, 
            
        ]);
        
    }
    


}