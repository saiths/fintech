<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\MachineModel;
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


class MachineController extends Controller
{


   /**
     *  Machine Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularMachineForm() 
    { 
        return view('admin.machine');
    }

  /**
    *  get MachineData using Angular
    *
    * @return MachineData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularMachineView()
    { 
        $machineModel = new MachineModel();
        $getMachineData = $machineModel->selectMachine();
        return $getMachineData;
    }

  /**
    *  add MachineData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function machineAngularAdd(Request $request)
    {   
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $machineIds = 0;
        
        if (!empty($request->input('name'))) {

            $machineModel = new MachineModel();
            $resultName = $machineModel->machineNameAlredyExists(trim($request->input('name')),$machineIds); 

        }

        $is_status = 'N';
        if ($request->input('is_status') == 'Y') {
            $is_status = 'Y';
        }


        $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
        
        if (empty($resultName)) { 
            
            $machineData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0,
                'is_status'   => $is_status
                  
            ];
            

            $machineModel = new MachineModel();
            $machineResult = $machineModel->machineInsert($machineData);
            
            Session::flash('message','Machine has been added.');
            return redirect('machine');

    
        } else {
            
            return view('admin.machine', [
                'nameText' => $nameText,
            ]);

        } 

    }
    

  /**
    *  update MachineData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function machineAngularEdit(Request $request)
    {
        
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $status = 'N';
        $machineIds = 0;
        $machineIds = $request->input('machineId');
        
        if (!empty($request->input('name'))) {
            $machineModel = new MachineModel();
            $resultName = $machineModel->machineNameAlredyExists(trim($request->input('name')),$machineIds); 
        }  
        
        $is_status = 'N';
        if ($request->input('is_status') == 'Y') {
            $is_status = 'Y';
        }
        


        $nameText =  !empty($resultName) ? 'The name has already been taken.' : 0;
        
        if (empty($resultName)) { 
            
            $machineData = [ 
                'name'        => $request->input('name'),
                'status'      => $status,
                'created_at'  => $time,
                'updated_at'  => $time,
                'deleted_at'  => $time,
                'created_by'  => 0,
                'edited_by'   => 0,
                'deleted_by'  => 0,
                'is_status'   => $is_status
                  
            ];

            $machineModel = new MachineModel();
            $machineResult = $machineModel->updateMachine($machineData,$machineIds);
            
            Session::flash('message','Machine has been updated.');
            return redirect('machine');
        
        } else {
            
            $getMachineDataByID = [];
            $machineModel = new MachineModel();
            $getMachineDataByID = $machineModel->selectMachineDataByID($machineIds);
            return view('admin.machine', [
                'nameText' => $nameText,
                'getMachineDataByID' => $getMachineDataByID
            ]);
        } 

    }



    
   /**
     *  get getAngularMachineDataByID By MachineId and using angular
     *
     * @param  $MachineId INT
     * @return MachineId blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularMachineDataByID($machineId = null)
    {   
        $machineIds = base64_decode($machineId);
        
        if (!empty($machineIds)) {
            $machineModel = new MachineModel();
            $getMachineDataByID = $machineModel->selectMachineDataByID($machineIds);
        }

        return view('admin.machine', [
            'getMachineDataByID' => $getMachineDataByID, 
        ]);
        
    }
    
    
    
   /**
     *  delete Machine By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularMachineById($machineId = null)
    {
        $machineIds = base64_decode($machineId);
        
        if (!empty($machineIds)) {
            $machineModel = new MachineModel();
            $result = $machineModel->deleteMachine($machineIds);

        }
        
        Session::flash('message','Machine has been deleted.');
        return redirect('machine');
        
    }
    
    
    


}