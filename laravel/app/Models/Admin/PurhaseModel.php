<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateInterval;
use DateTime;
use DatePeriod;

class PurhaseModel extends Model
{
	
	protected  $table = 'purchase_master';
	protected  $id = 'id'; // PK
	protected  $inward_no = 'inward_no';
  protected  $inward_date = 'inward_date';
  protected  $purchase_bill_no = 'purchase_bill_no';
  protected  $purchase_date = 'purchase_date';
  protected  $party_id = 'party_id';
  protected  $total = 'total';
  protected  $other_charges = 'other_charges';
  protected  $grand_total = 'grand_total';
  protected  $remark = 'remark';

  protected  $tables = 'purchase_master_detail';
  protected  $purchase_id = 'purchase_id';
  protected  $item_type_id = 'item_type_id';
  protected  $item_id = 'item_id';
  protected  $unit_id = 'unit_id';
  protected  $qty = 'qty';
  protected  $rate = 'rate';
  protected  $amount = 'amount';
  protected  $gst_no = 'gst_no';
  protected  $gst_amount_no = 'gst_amount_no';
  protected  $totals = 'totals';

  protected  $status = 'status';
  protected  $is_deleted_status = 'is_deleted_status';

  protected  $created_at = 'created_at';
	protected  $updated_at = 'updated_at';
	protected  $deleted_at = 'deleted_at';

  protected  $created_by = 'created_by';
  protected  $edited_by  = 'edited_by';
  protected  $deleted_by = 'deleted_by';
  

  /**
    * Insert purchaseData 
    * 
    * @param  $purchaseData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function purhaseInsert($purchaseData = null) {
      	$insertResult = 0;
      	if (!empty($purchaseData)) {  
          $insertResult = DB::table($this->table)->insertGetId($purchaseData);
        }  
      	return $insertResult;
   	  
    }


  /**
    * Insert purhaseDetailsInsert 
    * 
    * @param  $purhaseDetailsInsert Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function purhaseDetailsInsert($purhaseDetailsArr = null) {
      $insertResult = 0;
      if (!empty($purhaseDetailsArr)) {  
        $insertResult = DB::table('purchase_master_detail')->insert($purhaseDetailsArr);
      }  
      return $insertResult;
    }
      

  /**
    *  getPurchaseData 
    *
    * @return $getPurchaseData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectPurhase() {

        $getPurchaseData = [];
        $getPurchaseData = DB::table($this->table)
          ->select('*')
          ->where($this->is_deleted_status, 'N')
          ->get()
          ->toArray();
        return $getPurchaseData;

    }


  /**
    * check username in User
    * 
    * @param   $name  VARCHAR
    * @return  Boolen 0 or1     
    * @author <satishchauhan041@gmail.com>
    */
    public function purchaseAlredyExists($name = null,$purchaseId = 0) {

      	$checkResult = 0;

      	if (!empty($purchaseId)) {
            
            if (!empty($name)) {
                
                $checkResult = DB::table($this->table)->select($this->name)
	            	->where($this->name, $name)
	            	->where($this->id, '!=',$purchaseId)
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
    * get getPurchaseDataByID By purchaseId
    * 
    * @param  $purchaseId INT
    * @return $getPurchaseDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectPurchaseDataByID($purchaseId = null) {

      	$getPurchaseDataByID = [];
        
      	if (!empty($purchaseId)) {
          
          	$getPurchaseDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $purchaseId)
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
   	public function deletePurhase($purchaseId = null) {
   		
   		  date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        $purchaseData = [$this->is_deleted_status => 'Y',$this->deleted_at => $time];
		    $deleteResult = 0;
      	if (!empty($purchaseId)) {
            $deleteResult = DB::table($this->table)->where($this->id, $purchaseId)->update($purchaseData);
            $deleteResult = DB::table($this->tables)->where($this->purchase_id, $purchaseId)->update($purchaseData);
        }

        return $deleteResult;
    }
	

  /**
    * Update purchaseData Data By purchaseId
    * 
    * @param  $purchaseId INT && $purchaseData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updatePurchase($purchaseData = null,$purchaseId = 0) {



        $updateResult = 0;
      	if (!empty($purchaseData) && !empty($purchaseId)) {
            $updateResult = DB::table('purchase_master')
            	->where($this->id, $purchaseId)
            	->update($purchaseData);
      	}
        return $updateResult;
   	    
    }


      /**
    * Update purchaseData Data By purchaseId
    * 
    * @param  $purchaseId INT && $purchaseData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function updatePurchaseDetails($purhaseDetailsArr = null,$purchaseDelId = 0) {
            
          $updateResult = 0;
        //  if (!empty($purhaseDetailsArr) && !empty($purchaseDelId)) {

            $updateResult = DB::table('purchase_master_detail')->insert($purhaseDetailsArr);

            
          //}
            
        return $updateResult;
    }    


  /**
    * delete purchaseDetailsData Data By purchaseDetailsId
    * 
    * @param   $purchaseDetailsId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function deletePurhaseDetails($purchaseDetailsId = null,$purchaseIds = null,$totalss=null,$totalr=null,$otherChargess=null,$grandTotals=null) {

      $otherChargessNew = 0;
        $deleteResult = 0;
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        

        $purchaseData = [$this->is_deleted_status => 'Y',$this->deleted_at => $time];
        
        $deleteResult = DB::table('purchase_master_detail')->where($this->id, $purchaseDetailsId)->update($purchaseData);
        




      //  $purchaseDetailsIds = !empty($purchaseDetailsId) ? $purchaseDetailsId : 0;
/*        $nTotals = $totalr - $totalss;
        
        if (!empty($nTotals)) {
          $otherChargessNew = number_format($otherChargess,2,'.','');
        }

        $gTotals = $nTotals + $otherChargessNew;


*/
      $purchaseDetailsQuery = DB::select( 'SELECT SUM(totals) as sumPurchase FROM purchase_master_detail WHERE is_deleted_status = "N" and 
        purchase_id = '.$purchaseIds.'');


   //   print_r($purchaseDetailsQuery);die;


        if (!empty($purchaseDetailsQuery)) {


               $nTotalsNew = !empty($purchaseDetailsQuery[0]->sumPurchase) ? $purchaseDetailsQuery[0]->sumPurchase : '';

               $gTotalsNew = $nTotalsNew + $otherChargess;
               

        $purchaseDatas =

        [
            $this->total         => number_format($nTotalsNew,2,'.',''),
            $this->grand_total   => number_format($gTotalsNew,2,'.',''),
            $this->other_charges => number_format($otherChargess,2,'.',''),
              
        ]; 

      } else {

        

        $purchaseDatas =

        [
            $this->total         => number_format(0,2,'.',''),
            $this->grand_total   => number_format(0,2,'.',''),
            $this->other_charges => number_format(0,2,'.',''),
              
        ]; 



      }

  


      

              
       // if (!empty($purchaseDetailsId)) {
          
          $deleteResult = DB::table('purchase_master')->where($this->id, $purchaseIds)->update($purchaseDatas);




          
      //  }






        return $deleteResult;

    }
      
   	
   	
	  
    

}
