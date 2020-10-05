<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\ProcessModel;
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


class ProcessController extends Controller
{


   /**
     *  Process Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularProcessForm() 
    { 
        return view('admin.process');
    }

  /**
    *  get processData using Angular
    *
    * @return processData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularProcessView()
    { 
        $processModel = new ProcessModel();
        $getProcessData = $processModel->selectProcess();
        return $getProcessData;
    }

  /**
    *  add processData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function processAngularAdd(Request $request)
    {   
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $processIds = 0;
        
        if (!empty($request->input('name'))) {
            $processModel = new ProcessModel();
            $resultName = $processModel->processNameAlredyExists(trim($request->input('name')),$processIds); 
        }
        
        $nameText =  
        !empty($resultName) ? 'The name has already been taken.' : 0;
        
        if (empty($resultName)) { 
            
            $processData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0
            ];
            

            $processModel = new ProcessModel();
            $processResult = $processModel->processInsert($processData);
            
            //return ['success'=> true,'message' => 'Process has been added.'];
            
            Session::flash('message','Process has been added.');
            return redirect('process');

    
        } else {
            
            return view('admin.process', [
                'nameText' => $nameText,
            ]);
            //return ['success'=> true,'nameText' => $nameText ];

        } 

    }
    

  /**
    *  update processData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function processAngularEdit(Request $request)
    {
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';
        $processIds = 0;
        $processIds = $request->input('processId');
        
        
        if (!empty($request->input('name'))) {
            $processModel = new ProcessModel();
            $resultName = $processModel->processNameAlredyExists(trim($request->input('name')),$processIds); 
        }  
        
        
        $nameText =  
        !empty($resultName) ? 'The name has already been taken.' : 0;
        
        if (empty($resultName)) { 
            
            $processData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0
            ];

            $processModel = new ProcessModel();
            $processResult = $processModel->updateProcess($processData,$processIds);
            
            Session::flash('message','Process has been updated.');
            return redirect('process');
            
            
        //return ['success'=> true,'message' => 'Process has been updated.'];
            
            
        } else {
            
            
            $getProcessDataByID = [];
            $processModel = new ProcessModel();
            $getProcessDataByID = $processModel->selectProcessDataByID($processIds);
            
            
            return view('admin.process', [
                'nameText' => $nameText,
                'getProcessDataByID' => $getProcessDataByID
            ]);
            
            //return ['success'=> true, 'nameText' => $nameText ];   
            
        } 

    }

   /**
     *  delete Process By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularProcess(Request $request)
    {
        
        $processId = $request->input('id');
        if (!empty($processId)) {
            $processModel = new ProcessModel();
            $result = $processModel->deleteProcess($processId);
            return ['success'=> true, 'message' => 'Process has been deleted.'];
        }

    }


    
   /**
     *  get getAngularProcessDataByID By processId and using angular
     *
     * @param  $processId INT
     * @return processId blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularProcessDataByID($processId = null)
    {   
        $processIds = base64_decode($processId);
        
        if (!empty($processIds)) {
            $processModel = new ProcessModel();
            $getProcessDataByID = $processModel->selectProcessDataByID($processIds);
        }

        return view('admin.process', [
            'getProcessDataByID' => $getProcessDataByID, 
        ]);
        
    }
    
    
    
   /**
     *  delete Process By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularProcessById($processId = null)
    {
        $processIds = base64_decode($processId);
        
        //$processId = $request->input('id');
        
        if (!empty($processIds)) {
            $processModel = new ProcessModel();
            $result = $processModel->deleteProcess($processIds);
            //return ['success'=> true, 'message' => 'Process has been deleted.'];
        }
        
        Session::flash('message','Process has been deleted.');
        return redirect('process');
        
    }
    
    
    


}