<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class ProcessModel extends Model
{
	
	protected  $table = 'process_master';	
	protected  $id = 'id'; // PK
	protected  $name = 'name'; 
    protected  $status = 'status';
	protected  $is_deleted_status = 'is_deleted_status';
	protected  $created_at = 'created_at';
	protected  $updated_at = 'updated_at';
	protected  $deleted_at = 'deleted_at';
    protected  $created_by = 'created_by';
    protected  $edited_by  = 'edited_by';
    protected  $deleted_by = 'deleted_by';
  

  /**
    * Insert Process Data 
    * 
    * @param  $processData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function processInsert($processData = null) {
      	$insertResult = 0;
      	if (!empty($processData)) {  
          $insertResult = DB::table($this->table)->insert($processData);
        }  
      	return $insertResult;
   	}
   


    /**
    *  get Process Data 
    *
    * @return $getProcessData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectProcess() {
        $getProcessData = [];
        $getProcessData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy('name', 'ASC')
          ->get()
          ->toArray();
        return $getProcessData;
      
    }


  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function processNameAlredyExists($name = null,$processId = 0) {

      	$checkResult = 0;

      	if (!empty($processId)) {
            if (!empty($name)) {
                $checkResult = DB::table($this->table)->select($this->name)
            	->where($this->name, $name)
            	->where($this->id, '!=',$processId)
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
    * @param  $processId INT
    * @return $getProcessDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectProcessDataByID($processId = null) {
      	$getProcessDataByID = [];
      	if (!empty($processId)) {
          	$getProcessDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $processId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getProcessDataByID;
      	}
      	return $getProcessDataByID;
   	}
	
   /**
    * delete Process Data By UserId
    * 
    * @param   $processId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteProcess($processId = null) {
   		
   		
   		date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $processData = [
        	 $this->is_deleted_status => 'Y',
        	 $this->deleted_at => $time
       	];
       	

		$deleteResult = 0;
      	if (!empty($processId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $processId)
               	->update($processData);
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
   	public function updateProcess($processData = null,$processId = 0) {

        $updateResult = 0;
      	if (!empty($processData) && !empty($processId)) {
            $updateResult = DB::table($this->table)
            	->where($this->id, $processId)
            	->update($processData);
      	}
        return $updateResult;
   	    
    }

   	
   	
   	
	  
    

}
