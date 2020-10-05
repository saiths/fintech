<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class LeaveRequestModel extends Model
{
	
/*    protected  $table = 'leave_request';	
    protected  $id = 'id'; // PK
    protected  $user_id = 'user_id'; 
    protected  $leave_type = 'leave_type';
    protected  $date = 'date';
    protected  $reason = 'reason';
    protected  $leave_status = 'leave_status';
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';
    protected  $datetime   = 'datetime';*/
    
    
    protected  $table = 'leave_request';	
    protected  $id = 'id'; // PK
    protected  $user_id = 'user_id';
    protected  $role_id = 'role_id';
    protected  $leave_type = 'leave_type';
    protected  $form_date = 'form_date';
    protected  $to_date = 'to_date';
    protected  $leave_day = 'leave_day';
    protected  $reason = 'reason';
    protected  $leave_status = 'leave_status';
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';
    protected  $datetime   = 'datetime';
    
  /**
    * Insert leaveReqData 
    * 
    * @param  $leaveReqData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function insertLeaveRequest($leaveReqData = null) {
      	$insertResult = 0;
      	if (!empty($leaveReqData)) {        
         	$insertResult = DB::table($this->table)->insert($leaveReqData);
      	}  
      	return $insertResult;
   	}

  /**
    * update leaveReqData 
    * 
    * @param  $leaveReqData Arr AND $leaveReqId AND $leaveDate str
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
/*    public function updateLeaveRequest($leaveReqData = null,$leaveReqId = null,$leaveDate = null) {
        $insertResult = 0;
        if (!empty($leaveReqData) && !empty($leaveReqId)) {    
            $deleteResult = DB::table($this->table)
              ->where($this->id, $leaveReqId)
              ->where($this->date, $leaveDate)
              ->where($this->leave_status, 1)
              ->update($leaveReqData);
        }  
        return $insertResult;
    }*/
    
    public function updateLeaveRequest($leaveReqData = null,$leaveReqId = null,$leaveDate = null) {
        $insertResult = 0;
        if (!empty($leaveReqData) && !empty($leaveReqId)) {    
            $insertResult = DB::table($this->table)
              ->where($this->id, $leaveReqId)
              ->where($this->form_date, $leaveDate)
              ->where($this->to_date, $leaveDate)
              ->where($this->leave_status, 1)
              ->update($leaveReqData);
        }  
        return $insertResult;
    }

  /**
    * delete leaveReqData 
    * 
    * @param  $leaveReqId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function deleteLeaveRequest($leaveReqId = null) {
        $insertResult = 0;
        $leaveReqData = [$this->is_deleted_status => 'Y'];
        if (!empty($leaveReqId)) {    
            $deleteResult = DB::table($this->table)
              ->where($this->id, $leaveReqId)
              ->where($this->leave_status, 1)
              ->update($leaveReqData);
        }  
        return $insertResult;
    }
    
  /**
   *  get Leave Request 
   *
   *
   * @return dashboard view file    
   * @author <satishchauhan041@gmail.com>
   */ 
    public function selectLeaveRequest()
    { 
        $getLeaveReqData = [];
        $roleId = 0;
        if(!empty(Session::get('sessionUserData'))) {
            foreach (Session::get('sessionUserData') as $sessionUserData) {
                $userId = $sessionUserData[0]->id;
                $roleId = $sessionUserData[0]->role_id;  
            }
        }
        if ($roleId == 1) {
            $getLeaveReqData = DB::table('leave_request')
                ->select('user_master.username','leave_request.*')
                ->join('user_master', 'user_master.id','leave_request.user_id')
                ->where('leave_request.is_deleted_status','N')
                ->orderBy('leave_request.leave_status','ASC')
                ->orderBy('leave_request.datetime','DESC')
                ->get()
                ->toArray();
                
        }   else if ($roleId == 3) {
            $getLeaveReqData = DB::table('leave_request')
                ->select('user_master.username','leave_request.*')
                ->join('user_master', 'user_master.id','leave_request.user_id')
                ->where('leave_request.is_deleted_status','N')
                ->where('leave_request.user_id',$userId)
                ->orderBy('leave_request.datetime','DESC')
                ->orderBy('leave_request.leave_status','ASC')
                ->get()
                ->toArray();
        } 
        return $getLeaveReqData;
    }
    
 /**
   *  update Leave Request Status Apporved OR Rejected
   *
   * @return dashboard view file    
   * @author <satishchauhan041@gmail.com>
   */ 
    public function updateLeaveReqStatus($apporveId = null,$type = null)
    {   
        if ($type == 3) {
            $leaveReqData = [$this->leave_status => 3];
        } else {
            if ($type == 2) {
                $leaveReqData = [$this->leave_status => 2];
            } else {
                $leaveReqData = [$this->leave_status => 1];
            }
        }
        $updateLeaveReqStatus = 0;
        $updateLeaveReqStatus = DB::table($this->table)->where($this->id, $apporveId)->update($leaveReqData);
        return $updateLeaveReqStatus;
    }




}
