<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class UserModel extends Model
{
	 
    protected  $table = 'user_master';
    protected  $user_type = 'user_type';

    /*---------------- User Part ----------------------*/

    protected  $id = 'id'; // PK
    protected  $name = 'name'; 
    protected  $username = 'username';
    protected  $password = 'password';
    protected  $mobile = 'mobile';

    /*---------------- Party Part ----------------------*/

    protected  $party_name = 'party_name'; 
    protected  $party_address  = 'party_address';
    protected  $party_city = 'party_city';
    protected  $party_country  = 'party_country ';    
    protected  $party_state = 'party_state'; 
    protected  $party_pincode  = 'party_pincode';
    protected  $party_gst_no   = 'party_gst_no';
    protected  $party_credit_limit  = 'party_credit_limit';

    protected  $contact_person = 'contact_person'; 
    protected  $contact_email  = 'contact_email';
    protected  $contact_mobile_no   = 'contact_mobile_no';
    protected  $contact_whatsapp_no  = 'contact_whatsapp_no';

    protected  $transport_name = 'transport_name'; 
    protected  $transport_address  = 'transport_address';
    protected  $transport_email   = 'transport_email';
    protected  $transport_mobile_no   = 'transport_mobile_no';

    protected  $created_by = 'created_by';
    protected  $edited_by  = 'edited_by';
    protected  $deleted_by  = 'deleted_by';

    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';

    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';


  /**
   *  check Username and Password in admin 
   *
   * @param $userData Arr
   * @return $userLoginQuery Arr    
   * @author <satishchauhan041@gmail.com>
   */ 
  public function userLogin($userData = null)
  {
      
      $getCountUserLogin = 0;
      if (!empty($userData) && is_array($userData)) {
        $getCountUserLogin = DB::table($this->table)
          ->select('*')
          ->where($this->username, $userData['username'])
          ->where($this->password, $userData['password'])
          ->where($this->is_deleted_status, 'N')
          ->get()
          ->toArray();
        $_SESSION['userRoleId'] = !empty($getCountUserLogin[0]->role_id) ?  $getCountUserLogin[0]->role_id : 0;
      
      }
      return $getCountUserLogin;
  }
    

    /**
    *  get User Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectUser() {

        $getUserData = [];
        $getUserData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->where($this->user_type, 3)
          ->orderBy('username', 'ASC')
          ->get()
          ->toArray();
        return $getUserData;
        
    }

    

  /**
    * Insert User Data 
    * 
    * @param  $userData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function userInsert($userData = null) {
        $insertResult = 0;
      	if (!empty($userData)) {        

         	$insertResult = DB::table($this->table)->insert($userData);

      	}  
      	return $insertResult;
   	}
    

  /**
    * check username in User
    * 
    * @param   $username  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function userNameAlredyExists($username = null,$userId = 0,$userType=0) {
        
        $checkResult = 0;

        if ($userType == 1) {



          if (!empty($userId)) {
            
            if (!empty($username)) {

              $checkResult = DB::table($this->table)
               ->select($this->party_name)
    	         ->where($this->party_name, $username)
    	         ->where($this->id, '!=',$userId)
    	         ->where($this->is_deleted_status, 'N')
    	         ->count();
            }

          } else {

            if (!empty($username)) {  

                $checkResult = DB::table($this->table)
                ->select($this->party_name)
              	->where($this->party_name, $username)
                ->where($this->is_deleted_status, 'N')
              	->count();
            }
            
          }

        } else {
      

        if (!empty($userId)) {

              if (!empty($username)) {

                $checkResult = DB::table($this->table)
                ->select($this->username)
                  ->where($this->username, $username)
                  ->where($this->id, '!=',$userId)
                  ->where($this->is_deleted_status, 'N')
                  ->count();

              }
          
          } else {

            if (!empty($username)) {


              $checkResult = DB::table($this->table)
                ->select($this->username)
                ->where($this->username, $username)
                ->where($this->is_deleted_status, 'N')
                ->count();


              }

          }

      }
         
      return $checkResult;
    }



  /**
    * delete User Data By UserId
    * 
    * @param   $userId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteUser($userId = null) {
   		
   		date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $userData = [
        	$this->is_deleted_status => 'Y',
        	$this->deleted_at => $time
       	];
		    $deleteResult = 0;
      	if (!empty($userId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $userId)
               	->update($userData);
        }
      	return $deleteResult;
   	}
	

   /**
    * Update User Data By UserId
    * 
    * @param  $userId INT && $userData Arr
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateUser($userData = null,$userId = 0) {
      	$updateResult = 0;
      	if (!empty($userData) && !empty($userId)) {
        	$updateResult = DB::table($this->table)
            	->where($this->id, $userId)
            	->update($userData);
      	}
      	return $updateResult;
   	}



  /**
    * get User Data By userId
    * 
    * @param  $userId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
    public function getAngularUserDataByID($userId = null) {

        $getUserDataByID = [];
        if (!empty($userId)) {
            $getUserDataByID = DB::table('user_master')
                ->select('*')
                ->where('is_deleted_status','N')
                ->where('id',$userId)
                ->get()
                ->toArray();
            return $getUserDataByID;
        }
        return $getUserDataByID;
    }
    
    
    
      /**
    * check username in User
    * 
    * @param   $username  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function userEmailAlredyExists($userEmail = null,$userId = 0,$userTypeId=0,$company_edit_profile_id=0) {
        $checkResult = 0;
        if (!empty($company_edit_profile_id)) {
            
            if (!empty($userEmail)) {

              $checkResult = DB::table('company_edit_profile')
               ->select('*')
               ->where('email', $userEmail)
                ->where('id', '!=',$company_edit_profile_id)
                ->where('is_deleted_status', 'N')
               ->count();
            }
        
        } else {
            
            if (!empty($userEmail)) {

              $checkResult = DB::table('company_edit_profile')
               ->select('*')
               ->where('email', $userEmail)
               ->where('is_deleted_status', 'N')
               ->count();
            }
        
            
            
        }
        return $checkResult;
        
      }
      


  /**
    * check username in User
    * 
    * @param   $username  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function userPhoneAlredyExists($userPhone = null,$userId = 0,$userTypeId=0,$company_edit_profile_id=0) {

        $checkResult = 0;
        if (!empty($company_edit_profile_id)) {
            

            if (!empty($userPhone)) { 

              $checkResult = DB::table('company_edit_profile')
               ->select('*')
               ->where('phone', $userPhone)
               ->where('id','!=',$company_edit_profile_id)
                ->where('is_deleted_status', 'N')
               ->count();
            }
            
            
            
        } else {
            
            if (!empty($userPhone)) { 

              $checkResult = DB::table('company_edit_profile')
               ->select('*')
               ->where('phone', $userPhone)
               ->where('is_deleted_status', 'N')
               ->count();
            }
            
            
            
        }
      return $checkResult;
    }
    
    
    public function getCurPasswordId($checkCurPassword = null,$sessionUserId = null) {
        $getIdCurPasswordQuery = [];
      	if (!empty($checkCurPassword)) {
        	$getIdCurPasswordQuery = DB::table($this->table)
        		->select($this->id)
        		->where($this->password, $checkCurPassword)
        		->where($this->id, $sessionUserId)
        		->get()
        		->toArray();
        }
      	return $getIdCurPasswordQuery;
    }
    
    
	/**
     *  get Current Password SessId in session ID 
     *
     * @param $sessionUserId VAR and $newPassword INT
     * @return Boolen 0 or 1     
     * @author <satishchauhan041@gmail.com>
     */
   	public function getCurPasswordUpdateBySessId($sessionUserId = null,$newPassword = null) {
   	    
   	    if (!empty($sessionUserId) && !empty($newPassword)) { 
   	        $newPasswordArr = [$this->password => $newPassword];
        	$loginProfileResult = DB::table($this->table)
              	->where($this->id, $sessionUserId)
              	->update($newPasswordArr); 
            
            
        }
    }
    
    


}


    
    
