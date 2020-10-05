<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class AttendanceModel extends Model
{
	
	protected  $table = 'attendance';	
	protected  $id = 'id'; // PK
	protected  $user_id = 'user_id'; 
	protected  $in_time = 'in_time';
	protected  $out_time = 'out_time';
    protected  $hours = 'hours';
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $date = 'date';
  
  /**
    * Insert Client Data 
    * 
    * @param  $checkInData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function checkInInsert($checkInData = null) {
      	$insertResult = 0;
      	if (!empty($checkInData)) {        
         	$insertResult = DB::table($this->table)->insert($checkInData);
      	}  
      	return $insertResult;
   	}

  /**
    * Update checkOut Data By $user_id,$date,$out_time
    * 
    * @param   $checkOutData Arr
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function checkOutUpdate($checkOutData = null) {
      $userId = Session::get('sessionUserData')[0][0]->id;
      $date = date('d-m-Y'); 
      $updateResult = 0;
      	$updateResult = DB::table($this->table)
            ->where($this->out_time,'')
            ->where($this->user_id,$userId)
            ->where($this->date,$date)
            ->update(['out_time'=> $checkOutData['out_time']]);
        
        return $updateResult;
        
              
      /*$updateResult = DB::select("UPDATE `attendance` set `out_time` = '".$checkOutData['out_time']."' WHERE `user_id` = ".$userId." and `date` = '".$date."' and `out_time` = ''");
      */
      
    }

  /**
    * get User Attendance By UserId 
    * 
    * @param  $getAttendanceData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*    public function getAttendanceByUserId($userId = 0,$date = null) {
        $getAttendanceData = [];
        if (!empty($getAttendanceData)) { 
          $getRoleByRoleId = DB::select('SELECT * FROM role_master WHERE '.$this->is_deleted_status.' = "N" AND '.$this->user_id.' = '.$userId.' AND '.$this->date.' = '.$date.'');
        }  
        return $getAttendanceData;
    }
*/

}
