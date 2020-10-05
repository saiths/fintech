<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class PurhaseOrderModel extends Model
{
	
	protected  $purchase_order = 'purchase_order';
	protected  $id = 'id'; // PK
	protected  $po_no = 'po_no';
  protected  $po_date = 'po_date';
  protected  $party_id = 'party_id';
  protected  $item_id = 'item_id';
  protected  $description = 'description';
  protected  $qty = 'qty';

  protected  $purchase_order_attribute = 'purchase_order_attribute';
  protected  $po_id = 'po_id';
  protected  $attribute_item_id = 'attribute_item_id';
  protected  $value = 'value';
  
  protected  $purchase_order_image = 'purchase_order_image';
  protected  $image = 'image';
  
  protected  $status = 'status';
  protected  $is_deleted_status = 'is_deleted_status';

  protected  $created_at = 'created_at';
	protected  $updated_at = 'updated_at';
	protected  $deleted_at = 'deleted_at';

  protected  $created_by = 'created_by';
  protected  $edited_by  = 'edited_by';
  protected  $deleted_by = 'deleted_by';
  




  /**
    * Insert purchaseOrderData 
    * 
    * @param  $purchaseOrderData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function purhaseOrderInsert($purchaseOrderData = null) {
      	$insertResult = 0;
      	if (!empty($purchaseOrderData)) {  
          $insertResult = DB::table($this->purchase_order)->insertGetId($purchaseOrderData);
        }  
      	return $insertResult;
   	  
    }


  /**
    * Insert purhaseOrderDetailsInsert 
    * 
    * @param  $purhaseOrderDetailsInsert Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function purhaseOrderDetailsInsert($itemAttsArrs = null) {
      $insertResult = 0;
      if (!empty($itemAttsArrs)) {  
        $insertResult = DB::table('purchase_order_attribute')->insert($itemAttsArrs);
      }  
      return $insertResult;
    }
        

  /**
    *  getPurchaseOrderData 
    *
    * @return $getPurchaseOrderData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectPurhaseOrder() {

        $getPurchaseOrderData = [];
        $getPurchaseOrderData = DB::table($this->purchase_order)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->get()
          ->toArray();

        if (!empty($getPurchaseOrderData)) {
            foreach ($getPurchaseOrderData as $key => $itemData) {


               $itemUnitData = DB::table('item_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->item_id)
                  ->get()
                  ->toArray();

                if (!empty($itemUnitData)) {
                  foreach ($itemUnitData as  $unitType) {
                      $getPurchaseOrderData[$key]->itemNames = !empty($unitType->name) ? $unitType->name : '';
                  } 

                }



               $partyUserData = DB::table('user_master')
                  ->select('*')
                  ->where($this->is_deleted_status, 'N')
                  ->where($this->id, $itemData->party_id)
                  ->where('user_type', 1)
                  ->get()
                  ->toArray();

                  
                if (!empty($partyUserData)) {
                  foreach ($partyUserData as  $partyNameData) {
                      $getPurchaseOrderData[$key]->partyName = !empty($partyNameData->party_name) ? $partyNameData->party_name : '';
                    
                  } 

                }
              }

          }

        return $getPurchaseOrderData;

    }

  /**
    * get getPurchaseDataByID By purchaseId
    * 
    * @param  $purchaseId INT
    * @return $getPurchaseDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectPurchaseOrderDataByID($poIds = null) {

      	$getPurchaseDataByID = [];
        
      	if (!empty($poIds)) {
          
          	$getPurchaseDataByID = DB::table($this->purchase_order)
            	->select('*')
            	->where($this->id, $poIds)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();

        	 return $getPurchaseDataByID;
        }
        return $getPurchaseDataByID;

   	}
	

  /**
    * delete purchaseData Data By purchaseId
    * 
    * @param   $purchaseId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deletePurhaseOrder($poId = null) {
   		
   		  date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $purchaseData = [$this->is_deleted_status => 'Y',$this->deleted_at => $time];

		    $deleteResult = 0;
      	if (!empty($poId)) {
          
            $deleteResult = DB::table('purchase_order')->where($this->id, $poId)->update($purchaseData);
            $deleteResult = DB::table('purchase_order_attribute')->where($this->po_id, $poId)->update($purchaseData);
            $deleteResult = DB::table('purchase_order_image')->where($this->po_id, $poId)->update($purchaseData);
               
        }

        return $deleteResult;
    }
	

  /**
    * Update purchaseOrderData Data By po_id
    * 
    * @param  $po_id INT && $purchaseOrderData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updatePurchaseOrder($purchaseOrderData = null,$po_id = 0) {
        $updateResult = 0;
      	if (!empty($purchaseOrderData) && !empty($po_id)) {

            $updateResult = DB::table('purchase_order')
            	->where($this->id, $po_id)
            	->update($purchaseOrderData);

      	}
        return $updateResult;
   	    
    }
    


    
   	
	  
    

}
