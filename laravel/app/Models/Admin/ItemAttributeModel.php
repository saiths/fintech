<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class ItemAttributeModel extends Model
{
    
    protected  $table = 'item_attribute_master';	
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
    * Insert itemAttributeData 
    * 
    * @param  $itemAttributeData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function itemAttributeInsert($itemAttributeData = null) {
      	$insertResult = 0;
      	if (!empty($itemAttributeData)) {  
          $insertResult = DB::table($this->table)->insert($itemAttributeData);
        }  
      	return $insertResult;
   	}
  


  /**
    *  getItemAttribute Data 
    *
    * @return $getItemAttributeData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectItemAttribute() {

        $getItemAttributeData = [];
        $getItemAttributeData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy('name', 'ASC')
          ->get()
          ->toArray();
          
        return $getItemAttributeData;
      
    }


  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAttributeNameAlredyExists($name = null,$itemAttributeId = 0) {

      	$checkResult = 0;

      	if (!empty($itemAttributeId)) {
            
            if (!empty($name)) {
                
                $checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$itemAttributeId)
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
    * get itemAttribute Data By itemAttributeId
    * 
    * @param  $itemAttributeId INT
    * @return $getItemAttributeDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectItemAttributeDataByID($itemAttributeId = null) {
      	$getItemAttributeDataByID = [];
      	if (!empty($itemAttributeId)) {
          	$getItemAttributeDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $itemAttributeId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getItemAttributeDataByID;
      	}
      	return $getItemAttributeDataByID;
   	}
	

  /**
    * delete itemAttribute Data By itemAttributeId
    * 
    * @param   $itemAttributeId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteItemAttribute($itemAttributeId = null) 
   	{
   		
   		date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $itemAttributeData = [
        	 $this->is_deleted_status => 'Y',
        	 $this->deleted_at => $time
       	];

		$deleteResult = 0;
      	if (!empty($itemAttributeId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $itemAttributeId)
               ->update($itemAttributeData);
        }
        return $deleteResult;

    }
	

  /**
    * Update itemAttribute Data By itemAttributeId
    * 
    * @param  $itemAttributeId INT && $itemAttributeData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateItemAttribute($itemAttributeData = null,$itemAttributeId = 0) {

        $updateResult = 0;
      	if (!empty($itemAttributeData) && !empty($itemAttributeId)) {
            $updateResult = DB::table($this->table)
            	->where($this->id, $itemAttributeId)
            	->update($itemAttributeData);
      	}
        return $updateResult;
   	    
    }

   	
   	
   	
	  
    

}
