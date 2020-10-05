<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class ClientModel extends Model
{
	
	protected  $table = 'client_master';	
	protected  $id = 'id'; // PK
	protected  $name = 'name'; 
	protected  $contact_person = 'contact_person';
	protected  $email = 'email';
	protected  $mobile = 'mobile';
	protected  $address = 'address';
	protected  $date_of_birth = 'date_of_birth';
	protected  $date_of_joining = 'date_of_joining';
	protected  $status = 'status';
	protected  $is_deleted_status = 'is_deleted_status';
	protected  $created_at = 'created_at';
	protected  $updated_at = 'updated_at';
	protected  $deleted_at = 'deleted_at';
  
  
  /**
    * Insert Client Data 
    * 
    * @param  $userData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function clientInsert($clientData = null) {
      	$insertResult = 0;
      	if (!empty($clientData)) {        
         	$insertResult = DB::table($this->table)->insertGetId($clientData);
      	}  
      	return $insertResult;
   	}

  /**
    * check Email in Client
    * 
    * @param  $email VARCHAR
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function clientEmailAlredyExists($email = null,$clientId = 0) {
      	$checkResult = 0;
      	if (!empty($clientId)) {
			if (!empty($email)) {
          		$checkResult = DB::table($this->table)->select($this->email)
	            ->where($this->email,$email)
	            ->where($this->id, '!=',$clientId)
	            ->where($this->is_deleted_status, 'N')
	            ->count();
        	}
        } else {
			if (!empty($email)) {
          	$checkResult = DB::table($this->table)->select($this->email)
            	->where($this->email, $email)
            	->where($this->is_deleted_status, 'N')
            	->count();
        	}
      	}
      	return $checkResult;
    }

  /**
    * check Mobile in Client
    * 
    * @param   $mobile VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function clientMobileAlredyExists($mobile = null,$clientId = 0) {
      	$checkResult = 0;
		if (!empty($clientId)) {
			if (!empty($mobile)) {
          		$checkResult = DB::table($this->table)->select($this->mobile)
            		->where($this->mobile,$mobile)
            		->where($this->id, '!=',$clientId)
            		->where($this->is_deleted_status, 'N')
            		->count();
        	}
		} else {

			if (!empty($mobile)) {
          		$checkResult = DB::table($this->table)->select($this->mobile)
            	->where($this->mobile, $mobile)
            	->where($this->is_deleted_status, 'N')
            	->count();
        	}

    	}
      	return $checkResult;
   	}
	
  /**
    * check name in Client
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function clientNameAlredyExists($name = null,$clientId = 0) {
      	$checkResult = 0;
      	if (!empty($clientId)) {
        	if (!empty($name)) {
	          	$checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$clientId)
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
    *  get Client Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectClient() {
      	$getClientData = [];
      	$getClientData = DB::table($this->table)
      	    ->select('*')
      	    ->where($this->is_deleted_status, 'N')
      	    ->orderBy($this->name,'ASC')
      	    ->get()
      	    ->toArray();
      	    
      	return $getClientData;
    }

  /**
    * get Client Data By ClientId
    * 
    * @param  $clientId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectClientDataByID($clientId = null) {
      	$getClientDataByID = [];
      	if (!empty($clientId)) {
          	$getClientDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $clientId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getClientDataByID;
      	}
      	return $getClientDataByID;
   	}
	
   /**
    * delete Client Data By clientId
    * 
    * @param   $clientId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteClient($clientId = null) {
   		
   		 date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $clientData = [
        	$this->is_deleted_status => 'Y',
        	$this->deleted_at => $time
       	];

		    $deleteResult = 0;
      	if (!empty($clientId)) {
          	$deleteResult = DB::table($this->table)
                ->where($this->id, $clientId)
                ->update($clientData);
            $deleteResult = DB::table('client_project_master')
              ->where('client_id', $clientId)
              ->update($clientData);
        }
      	return $deleteResult;
   	}
	

   /**
    * Update Client Data By ClientId
    * 
    * @param  $clientId INT && $clientData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateClient($clientData = null,$clientId = 0) {
      	$updateResult = 0;
      	if (!empty($clientData) && !empty($clientId)) {
        	$updateResult = DB::table($this->table)
            	->where($this->id, $clientId)
            	->update($clientData);
      	}
      	return $updateResult;
   	}


}
