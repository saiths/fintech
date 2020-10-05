<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use DatePeriod;
use DateTime;
use DateInterval;

class HolidayModel extends Model
{
	
    protected  $table = 'holiday';	
    protected  $id = 'id'; // PK
    protected  $to_date = 'to_date'; 
    protected  $form_date = 'form_date'; 
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';

  
  /**
    *  get holiday Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectHoliday() {
      	$getholidayData = [];
      	$getholidayData = 
      	DB::table($this->table)
      	    ->select('*')
      	    ->where($this->is_deleted_status, 'N')
      	    ->orderBy($this->id,'DESC')
      	    ->get()
      	    ->toArray();
      	return $getholidayData;
    }
  
  /**
    * Insert holiday Data 
    * 
    * @param  $holidayData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function holidayInsert($holidayData = null) {
        $insertResult = 0;
        if (!empty($holidayData)) {        
          $insertResult = DB::table($this->table)->insert($holidayData);
        }  
        return $insertResult;
    }

  /**
    * check in holiday
    * 
    * @param  $date VARCHAR
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function checkHolidayDateAlredyExists($toHolidayDate = null,$formHolidayDate = null,$holidayId = 0) {
        
        $checkResult = [];
        $dateArr = [];
        $bothDate = '';
        if (!empty($holidayId)) {
            $checkResult = DB::table($this->table)
            ->select('*')
            ->where($this->id, '!=',$holidayId)
            ->where($this->is_deleted_status, 'N')
            ->get();
            if (!empty($checkResult)) {
                foreach ($checkResult as  $dates) {
                    $interval = new DateInterval('P1D'); 
                    $realEnd = new DateTime($dates->to_date); 
                    $realEnd->add($interval); 
                    $dateArrs = new DatePeriod(new DateTime($dates->form_date), $interval, $realEnd); 
                    foreach($dateArrs as $date) {                  
                        $dateArr[] = $date->format('Y-m-d');  
                    }
                }
                if (in_array($toHolidayDate, $dateArr) || in_array($formHolidayDate, $dateArr)) {
                    if (in_array($toHolidayDate, $dateArr)) {
                        $bothDate = 'to';
                    }
                    if (in_array($formHolidayDate, $dateArr)) {
                        $bothDate .= 'form';
                    }
                }
            } 
            
        } else {
            
            $checkResult = DB::table($this->table)
            ->select('*')
            ->where($this->is_deleted_status, 'N')
            ->get();
            if (!empty($checkResult)) {
                foreach ($checkResult as  $dates) {
                    $interval = new DateInterval('P1D'); 
                    $realEnd = new DateTime($dates->to_date); 
                    $realEnd->add($interval); 
                    $dateArrs = new DatePeriod(new DateTime($dates->form_date), $interval, $realEnd); 
                    foreach($dateArrs as $date) {                  
                        $dateArr[] = $date->format('Y-m-d');  
                    }
                }
                if (in_array($toHolidayDate, $dateArr) || in_array($formHolidayDate, $dateArr)) {
                
                    if (in_array($toHolidayDate, $dateArr)) {
                        $bothDate = 'to';
                    }
                
                    if (in_array($formHolidayDate, $dateArr)) {
                        $bothDate .= 'form';
                    }
                } 
            }
        }
        return $bothDate;
   
    }

  /**
    * get holiday Data By holidayId
    * 
    * @param  $holidayId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectHolidayDataByID($holidayId = null) {
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
   	}
	
   /**
    * delete holiday Data By holidayId
    * 
    * @param   $holidayId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteHoliday($holidayId = null) {
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
	

   /**
    * Update holiday Data By holidayId
    * 
    * @param  $holidayId INT && $holidayData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateHoliday($holidayData = null,$holidayId = 0) {
      	$updateResult = 0;
      	if (!empty($holidayData) && !empty($holidayId)) {
        	$updateResult = DB::table($this->table)
            	->where($this->id, $holidayId)
            	->update($holidayData);
      	}
      	return $updateResult;
   	}


}
