<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class ItemCategoryModel extends Model
{
	
  	protected  $table = 'item_category_master';	
  	protected  $id = 'id'; // PK
  	protected  $name = 'name'; 
    protected  $process_id = 'process_id'; 
    protected  $status = 'status';
  	protected  $is_deleted_status = 'is_deleted_status';
  	protected  $created_at = 'created_at';
  	protected  $updated_at = 'updated_at';
  	protected  $deleted_at = 'deleted_at';
    protected  $created_by = 'created_by';
    protected  $edited_by  = 'edited_by';
    protected  $deleted_by = 'deleted_by';
    

  /**
    * Insert itemCategoryData 
    * 
    * @param  $itemCategoryData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function itemCategoryInsert($itemCategoryData = null) {
      	$insertResult = 0;
      	if (!empty($itemCategoryData)) {  
            $insertResult = DB::table($this->table)->insertGetId($itemCategoryData);
      	    
      	}  
      	return $insertResult;
   	}

    
  /**
    *  get itemCategoryData 
    *
    * @return $getItemCategoryData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectItemCategory() {
        $getItemCategoryData = [];
        $getItemCategoryData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy('name', 'ASC')
          ->get()
          ->toArray();
          
        return $getItemCategoryData;
      
    }


  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function itemCategoryNameAlredyExists($name = null,$itemCategoryId = 0) {

      	$checkResult = 0;

      	if (!empty($itemCategoryId)) {
            
            if (!empty($name)) {
                
                $checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$itemCategoryId)
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
    * @param  $itemCategoryId INT
    * @return $getItemCategoryDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectItemCategoryDataByID($itemCategoryId = null) {
      	$getItemCategoryDataByID = [];
      	if (!empty($itemCategoryId)) {
          	$getItemCategoryDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $itemCategoryId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getItemCategoryDataByID;
      	}
      	return $getItemCategoryDataByID;
   	}
	
   /**
    * delete itemCategory Data By itemCategoryId
    * 
    * @param   $itemCategoryId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteItemCategory($itemCategoryId = null) {
   		
   		  date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $itemCategoryData = [
        	 $this->is_deleted_status => 'Y',
        	 $this->deleted_at => $time
       	];
        
        $deleteResult = 0;
        if (!empty($itemCategoryId)) {
              
            $deleteResult = DB::table($this->table)
                ->where($this->id, $itemCategoryId)
                ->update($itemCategoryData);
          
            $deleteResult = DB::table('process_item_category_master')
             	  ->where('item_category_id', $itemCategoryId)
               	->update($itemCategoryData);
        }
      	return $deleteResult;
   	  
    }
	

   /**
    * Update itemCategoryData By itemCategoryId
    * 
    * @param  $itemCategoryId INT && $itemCategoryData Arr
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateItemCategory($itemCategoryData = null,$itemCategoryId = 0) {

        $updateResult = 0;
      	if (!empty($itemCategoryData) && !empty($itemCategoryId)) {
            $updateResult = DB::table($this->table)
            	->where($this->id, $itemCategoryId)
            	->update($itemCategoryData);
      	}
        return $updateResult;
   	    
    }

   	
   	
   	
	  
    

}
