<?phps
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\PurhaseModel;
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


class PurchaseController extends Controller
{


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
            

        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $itemIds = 0;

        if (!empty($request->input('name'))) {

            $purhaseModel = new PurhaseModel();
            $resultName = $purhaseModel->itemNameAlredyExists(trim($request->input('name')),$itemIds); 
        }
        
        $nameText =  !empty($resultName) ? 'nameText' : 0;

        if ($nameText == '') { 
            
            $getPurhaseData = [ 

                'unit_id'        => $request->input('unit_id'),
                'item_type_id'        => $request->input('itemTypeId'),
                'item_category_id'        => $request->input('itemCategoryId'),
                'name'        => $request->input('name'),
                'gst'     => $request->input('gst'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0,
            ];


            $purhaseModel = new PurhaseModel();
            $itemResult = $purhaseModel->itemInsert($getPurhaseData);
            return ['success'=> true,'message' => 'Item has been added.'];

        } else {

            return ['success'=> true,'nameText' => $nameText ];

        } 

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
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';
        $purhase = 0;
        $purhaseId = $request->input('id');
        
        
        if (!empty($request->input('name'))) {
            $purhaseModel = new PurhaseModel();
            $resultName = $purhaseModel->itemNameAlredyExists(trim($request->input('name')),$purhaseId); 
        }  
        
        $nameText =  !empty($resultName) ? 'nameText' : 0;
        
        if ($nameText == '') { 
            
            $getPurhaseData = [ 
                                
                'unit_id'            => $request->input('unit_id'),
                'item_type_id'       => $request->input('itemTypeId'),
                'item_category_id'        => $request->input('itemCategoryId'),
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

            $purhaseModel = new PurhaseModel();
            $itemResult = $purhaseModel->updateItem($getPurhaseData,$itemIds);
            return ['success'=> true,'message' => 'Purhase has been updated.'];
        
        } else {
            
            return ['success'=> true,'nameText' => $nameText ];   
            
        } 

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
    public function getAngularPurhaseDataByID()
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
     *  purhaseDashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularPurhaseForm() 
    { 
        return view('admin.purhase');
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
    public function selectItemGstAngularById(Request $request)
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
    public function selectItemUnitAngularByIds(Request $request)
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
    




}