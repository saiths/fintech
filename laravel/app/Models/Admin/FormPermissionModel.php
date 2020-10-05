<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class FormPermissionModel extends Model
{
	
	protected  $table = 'form_permission';	
	protected  $id = 'id'; // PK
  protected  $user_id = 'user_id';
  protected  $form_id = 'form_id';
  protected  $status = 'status';
	protected  $is_deleted_status = 'is_deleted_status';
  protected  $created_at = 'created_at';
  protected  $updated_at = 'updated_at';
  protected  $deleted_at = 'deleted_at';
  
  /**
    *  get form_permission Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectFormPermission() {
      	$getformPermissionData = [];
       /* 	$getformPermissionData = DB::table($this->table)->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy($this->date,'DESC')
          ->get()
          ->toArray();*/
      	return $getformPermissionData;
    }
  
  /**
    * Insert holiday Data 
    * 
    * @param  $holidayData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*    public function holidayInsert($holidayData = null) {
        $insertResult = 0;
        if (!empty($holidayData)) {        
          $insertResult = DB::table($this->table)->insert($holidayData);
        }  
        return $insertResult;
    }*/

  /**
    * check in holiday
    * 
    * @param  $date VARCHAR
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*    public function checkHolidayDateAlredyExists($date = null,$holidayId = 0) {
        $checkResult = 0;
        if (!empty($holidayId)) {
          if (!empty($date)) {
              $checkResult = DB::table($this->table)->select($this->date)
              ->where($this->date,$date)
              ->where($this->id, '!=',$holidayId)
              ->where($this->is_deleted_status, 'N')
              ->count();
          }
        } else {
           if (!empty($date)) {
            $checkResult = DB::table($this->table)->select($this->date)
              ->where($this->date, $date)
              ->where($this->is_deleted_status, 'N')
              ->count();
          }
        }
      return $checkResult;

    }*/

  /**
    * get holiday Data By holidayId
    * 
    * @param  $holidayId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
/*   	public function selectHolidayDataByID($holidayId = null) {
      	$getHolidayDataByID = [];
      	if (!empty($holidayId)) {
          	$getHolidayDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $holidayId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getHolidayDataByID;
      	}
      	return $getHolidayDataByID;
   	}*/
	
   /**
    * delete holiday Data By holidayId
    * 
    * @param   $holidayId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*   	public function deleteHoliday($holidayId = null) {
   		
   		 date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $holidayData = [
        	$this->is_deleted_status => 'Y',
        	$this->deleted_at => $time
       	];

		    $deleteResult = 0;
      	if (!empty($holidayId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $holidayId)
              ->update($holidayData);
        }
      	return $deleteResult;
   	}
	*/

   /**
    * Update holiday Data By holidayId
    * 
    * @param  $holidayId INT && $holidayData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*   	public function updateHoliday($holidayData = null,$holidayId = 0) {
      	$updateResult = 0;
      	if (!empty($holidayData) && !empty($holidayId)) {
        	$updateResult = DB::table($this->table)
            	->where($this->id, $holidayId)
            	->update($holidayData);
      	}
      	return $updateResult;
   	}*/


}
