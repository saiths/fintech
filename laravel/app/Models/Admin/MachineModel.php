<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class MachineModel extends Model
{
	
    protected  $table = 'machine_master';	
    protected  $id = 'id'; // PK
    protected  $name = 'name'; 
    protected  $status = 'status';
    protected  $is_status = 'is_status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';
    protected  $created_by = 'created_by';
    protected  $edited_by  = 'edited_by';
    protected  $deleted_by = 'deleted_by';
  

  /**
    * Insert machine Data 
    * 
    * @param  $machineData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function machineInsert($machineData = null) {
      	$insertResult = 0;
      	if (!empty($machineData)) {  
          $insertResult = DB::table($this->table)->insert($machineData);
        }  
      	return $insertResult;
   	}
   


    /**
    *  get machine Data 
    *
    * @return $getMachineData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectMachine() {

        $getMachineData = [];
        $getMachineData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy('name', 'ASC')
          ->get()
          ->toArray();
          
        return $getMachineData;
      
    }


  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function machineNameAlredyExists($name = null,$machineId = 0) {

      	$checkResult = 0;

      	if (!empty($machineId)) {


            if (!empty($name)) {
                
                $checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$machineId)
	            	->where($this->is_deleted_status, 'N')
	            	->count();
	         }

        } else {

          if (!empty($name)) {
              $checkResult = DB::table($this->table)->select($this->name)
            	->where($this->name, $name)
            	->where($this->is_deleted_status, 'N')
            	->count();
          }

        }
      	return $checkResult;
    }


  /**
    * get User Data By UserId
    * 
    * @param  $machineId INT
    * @return $getProcessDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectMachineDataByID($machineId = null) {
      	$getMachineDataByID = [];
      	if (!empty($machineId)) {
          	$getMachineDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $machineId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getMachineDataByID;
      	}
      	return $getMachineDataByID;
   	}
	
   /**
    * delete Process Data By UserId
    * 
    * @param   $processId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteMachine($machineId = null) {
   		
   		  date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $machineData = [
        	 $this->is_deleted_status => 'Y',
        	 $this->deleted_at => $time
       	];

		    $deleteResult = 0;
      	if (!empty($machineId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $machineId)
               	->update($machineData);
        }
      	return $deleteResult;
   	  
    }
	

   /**
    * Update Process Data By processId
    * 
    * @param  $processId INT && $processData Arr
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateMachine($machineData = null,$machineId = 0) {

        $updateResult = 0;

      	if (!empty($machineData) && !empty($machineId)) {

            $updateResult = DB::table($this->table)

            	->where($this->id, $machineId)

            	->update($machineData);
      	}
        return $updateResult;
   	    
    }

   	
   	
   	
	  
    

}
