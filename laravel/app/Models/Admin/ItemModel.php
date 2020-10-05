<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class ItemModel extends Model
{
    
    protected  $table = 'item_master';	
    protected  $id = 'id'; // PK
    protected  $item_type_id = 'item_type_id';
    protected  $item_category_id = 'item_category_id';
    protected  $unit_id = 'unit_id';
    protected  $party_id = 'party_id';
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
    * Insert ItemData 
    * 
    * @param  $itemData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function itemInsert($itemData = null) {
      	$insertResult = 0;
      	if (!empty($itemData)) {  
          $insertResult = DB::table($this->table)->insertGetId($itemData);
        }  
      	return $insertResult;
   	}
   	
   	
  /**
    * Insert itemAttIdArr 
    * 
    * @param  $itemAttIdArr Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function itemAttDetailsInsert($itemAttIdArr = null) {
        $insertResult = 0;
        if (!empty($itemAttIdArr)) {  
            $insertResult = DB::table('attribute_item_master')->insert($itemAttIdArr);
        }  
        return $insertResult;
    }
    
   	
    public function itemAttDetailsInserts($itemAttIdArr = null) {
        $insertResult = 0;
        if (!empty($itemAttIdArr)) {  
          
            $insertResult = DB::table('item_attribute_value')->insert($itemAttIdArr);

            
        }  
        return $insertResult;
    }
   	
   	
   	
   	
    public function item_cylinder_detailInsert($item_cylinder_detailArr = null) {
        $insertResult = 0;
        if (!empty($item_cylinder_detailArr)) {  
          $insertResult = DB::table('item_cylinder_detail')->insert($item_cylinder_detailArr);
        }  
        return $insertResult;
      
    }
    
    

  /**
    *  get ItemData 
    *
    * @return $getItemData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectItem() 
    {
        $getItemData = [];
        $getItemData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->orderBy('name', 'ASC')
          ->get()
          ->toArray();

          if (!empty($getItemData)) {
            foreach ($getItemData as $key => $itemData) {

               $itemCategoryData = DB::table('item_category_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->item_category_id)
                  ->orderBy('name', 'ASC')
                  ->get()
                  ->toArray();

                if (!empty($itemCategoryData)) {
                  foreach ($itemCategoryData as  $itemCategory) {
                      $getItemData[$key]->itemCategoryName = !empty($itemCategory->name) ? $itemCategory->name : '';
                  } 

                }

                

               $itemTypeData = DB::table('item_type_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->item_type_id)
                  ->orderBy('name', 'ASC')
                  ->get()
                  ->toArray();

                if (!empty($itemTypeData)) {
                  foreach ($itemTypeData as  $itemType) {
                      $getItemData[$key]->itemTypeName = !empty($itemType->name) ? $itemType->name : '';
                  } 

                }

                

               $itemUnitData = DB::table('unit_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->unit_id)
                  ->get()
                  ->toArray();

                if (!empty($itemUnitData)) {
                  foreach ($itemUnitData as  $unitType) {
                      $getItemData[$key]->itemUnitName = !empty($unitType->unit) ? $unitType->unit : '';
                  } 

                }
                
                
                
               $partyUserData = DB::table('user_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->party_id)
                  ->where('user_type', 3)
                  ->get()
                  ->toArray();

                  
                if (!empty($partyUserData)) {
                    foreach ($partyUserData as  $partyNameData) {
                        $getItemData[$key]->partyName = !empty($partyNameData->party_name) ? $partyNameData->party_name : '';
                    } 
                }
                
                
            }
        
              
          }
        
        return $getItemData;
    }

  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function itemNameAlredyExists($name = null,$itemId = 0) {

      	$checkResult = 0;

      	if (!empty($itemId)) {


            if (!empty($name)) {
                
                $checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$itemId)
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
    * @param  $itemId INT
    * @return $getItemDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectItemDataByID($itemId = null) {

      	$getItemDataByID = [];
      	if (!empty($itemId)) {
          	$getItemDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $itemId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getItemDataByID;
      	}
      	return $getItemDataByID;

   	}
	

  /**
    * delete ItemData By itemId
    * 
    * @param   $itemId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteItem($itemId = null) {
   		
   		date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        
        $purchaseDatasss = ['is_deleted_status' => 'Y','deleted_at' => $time];
        $deleteResult = DB::table('attribute_item_master')->where('item_id', $itemId)->update($purchaseDatasss);
     
        
        $itemData = [
        	 $this->is_deleted_status => 'Y',
        	 $this->deleted_at => $time
       	];

		$deleteResult = 0;
		    
      	if (!empty($itemId)) {
          	$deleteResult = DB::table($this->table)->where($this->id, $itemId)->update($itemData);
            $deleteResult = DB::table('item_attribute_value')->where('item_id', $itemId)->update($itemData);
             $deleteResult = DB::table('item_cylinder_detail')->where('item_id', $itemId)->update($itemData);
            
        }
        
      	return $deleteResult;
   	  
    }
	

  /**
    * Update Item Data By itemId
    * 
    * @param  $itemId INT && $itemData Arr
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateItem($itemData = null,$itemId = 0) {

        $updateResult = 0;
      	if (!empty($itemData) && !empty($itemId)) {
            $updateResult = DB::table($this->table)
            	->where($this->id, $itemId)
            	->update($itemData);
      	}
        return $updateResult;
   	    
    }
    
    
    
    
    


}
