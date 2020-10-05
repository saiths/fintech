<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateTime;
use DateInterval;

class TicketModel extends Model
{
    
    protected  $table = 'ticket'; 
    protected  $id = 'id'; // PK
    protected  $project_id = 'project_id'; // PK
    protected  $title = 'title';
    protected  $title_no = 'ticket_no';
    protected  $ticket_type_id = 'ticket_type_id'; 
    protected  $ticket_type_id_admin = 'ticket_type_id_admin'; 
    protected  $priority = 'priority'; 
    protected  $severity = 'severity'; 
    protected  $task_compittion_date = 'task_compittion_date'; 
    protected  $description = 'description';
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';
  
  /**
    * Insert Ticket Data 
    * 
    * @param  $ticketData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function ticketInsert($ticketData = null) {
   	    
/*   	date_default_timezone_set('Asia/Kolkata');
        $minutesAdd = 1;
        //$curTime =   date('Y-m-d H:i:s',time() + 15);
        $curTime =   date('Y-m-d H:i:s');
        $time = new DateTime($curTime);
        $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $newTimes;*/
        
        date_default_timezone_set('Asia/Kolkata');
        // $minutesAdd = 1;
        $curTime =   date('Y-m-d H:i:s',time() + 15);
        // $curTime =   date('Y-m-d H:i:s');
        //// $time = new DateTime($curTime);
        // $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        // $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $curTime;


        $ticketNo = '';
        $ticketId = '';
        if (!empty($ticketData)) { 
            
            $getTicketNo = DB::select('SELECT MAX(ticket_no) as ticketNo FROM  `ticket` WHERE is_deleted_status = "N"');
            if (!empty($getTicketNo[0]->ticketNo)) {
                $ticketNo = $getTicketNo[0]->ticketNo  + 1;
            } 
            
            $ticketYr = substr($ticketNo, 0, 2);
            if ($ticketYr == date('y')) {
                $ticketNos  = $getTicketNo[0]->ticketNo + 1;
            } else {
                $ticketNos =  date('ym').'01';
            }
            
            $description = !empty($ticketData['description']) ? $ticketData['description'] : '';
            
            DB::insert(
                "CALL addTicket(?,?,?,?,?,?,?,?,?,?,?,?,?)",
                 array(
                    $ticketData['title'],
                    $ticketNos,
                    $ticketData['ticket_type_id'],
                    $ticketData['ticket_type_id_admin'],
                    $ticketData['priority'],
                    $ticketData['severity'],
                    $ticketData['selectWithTags'],
                    $ticketData['task_compittion_date'],
                    $description,
                    $ticketData['created_at'],
                    $ticketData['updated_at'],
                    $ticketData['deleted_at'],
                    $ticketData['project_id'],
                )
            );
            
            $getTicketIdData = DB::table($this->table)->orderBy('id', 'DESC')->first();
            if (!empty($getTicketIdData->id)) {
                $ticketId = $getTicketIdData->id;
            } 
                
            if (!empty($ticketId)) {
                $userId = !empty(Session::get('sessionUserData')[0][0]->id) ? Session::get('sessionUserData')[0][0]->id : '';
                $remark = !empty($ticketData['remark']) ? $ticketData['remark'] : '';
                $ticketStatusId = !empty($ticketData['ticket_status_id']) ? $ticketData['ticket_status_id'] : 1;
                
                DB::insert(
                    DB::raw("CALL addTicketStatus(?,?,?,?,?,?,?,?)"),
                    [ 
                        $ticketId,
                        $userId,
                        $ticketStatusId,
                        $ticketData['created_at'],
                        $ticketData['updated_at'],
                        $ticketData['deleted_at'],
                        $remark,
                        strtotime($newTime)
                        
                    ]
                );
            }
        }  
         return $ticketId.'_'.$ticketNos;
   	}
    
  /**
    *  get Ticket Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectTicket() {
      	$getTicketData = [];
      	if (!empty(Session::get('sessionUserData')[0][0]->role_id) &&  Session::get('sessionUserData')[0][0]->role_id != 1) {
      	    
      	   
            /*$getTicketData = DB::table('ticket')
              ->select('ticket_status.user_id','ticket_status.ticket_status_id','ticket.*')
              ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
              ->orderBy('ticket.ticket_no','DESC')
              ->where('ticket.is_deleted_status','N')
              ->where('ticket_status.user_id',Session::get('sessionUserData')[0][0]->id)
              ->get()
              ->toArray();
            */  
            $getTicketData = DB::table('ticket')
            ->select('ticket.*')
            ->orderBy('ticket.id','DESC')
            ->where('ticket.is_deleted_status','N')
            ->get()
            ->toArray();
            
            
            
        } else {
            
          $getTicketData = DB::table('ticket')
            ->select('ticket_status.user_id','ticket_status.ticket_status_id','ticket.*')
            ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
            ->orderBy('ticket.task_compittion_date','DESC')
            ->orderBy('ticket.ticket_no','DESC')
            ->where('ticket.is_deleted_status','N')
            ->get()
            ->toArray();
        }
        return $getTicketData;
    }

  /**
    * get Ticket Data By TicketId
    * 
    * @param  $ticketId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectTicketDataByID($ticketId = null) {
      	$getTicketDataByID = [];
      	if (!empty($ticketId)) {
      	    
            $getTicketDataByID = DB::table('ticket')
                ->select('ticket_status.*','ticket.*')
                ->join('ticket_status', 'ticket_status.ticket_id','ticket.id')
                ->orderBy('ticket.ticket_no','DESC')
                ->where('ticket.is_deleted_status','N')
                ->where('ticket.id',$ticketId)
                ->orderBy('ticket_status.id','ASC')
                ->limit(1)
                ->get()
                ->toArray();
            /*	$getTicketDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $ticketId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();*/
            	
        	return $getTicketDataByID;
      	}
      	return $getTicketDataByID;
   	}
	
   /**
    * delete Ticket Data By TicketId
    * 
    * @param   $ticketId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteTicket($ticketId = null) {
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $ticketData = [
        	$this->is_deleted_status => 'Y',
        	$this->deleted_at => $time
       	];
       	
        if (!empty($ticketId)) {
            $deleteResult = DB::table($this->table)
             	->where($this->id, $ticketId)
              ->update($ticketData);
            $deleteResults = DB::table('ticket_status')
              ->where('ticket_id', $ticketId)
              ->update($ticketData);
            $deleteResults = DB::table('attachment')
              ->where('ticket_id', $ticketId)
              ->update($ticketData);
                
        }
        return $deleteResult;
   	}
	

   /**
    * Update Ticket Data By TicketId
    * 
    * @param  $ticketId INT && $ticketData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateTicket($ticketData = null,$ticketId = 0,$ticketStatusId = 0) {
   	    
/*   	date_default_timezone_set('Asia/Kolkata');
        $minutesAdd = 1;
        //$curTime =   date('Y-m-d H:i:s',time() + 15);
        $curTime =   date('Y-m-d H:i:s');
        $time = new DateTime($curTime);
        $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $newTimes;*/
        
        date_default_timezone_set('Asia/Kolkata');
        // $minutesAdd = 1;
        $curTime =   date('Y-m-d H:i:s',time() + 15);
        // $curTime =   date('Y-m-d H:i:s');
        //// $time = new DateTime($curTime);
        // $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        // $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $curTime;


        
        $updateResult = 0;
      	if (!empty($ticketData) && !empty($ticketId)) {
           $description = !empty($ticketData['description']) ? $ticketData['description'] : '';
            
            if (!empty(Session::get('sessionUserData')[0][0]->role_id) && Session::get('sessionUserData')[0][0]->role_id == 4) {
                
                $ticketDatas = [
                    'title'                 =>  $ticketData['title'],
                    'ticket_type_id'        =>  
                    !empty($ticketData['ticket_type_id']) ? $ticketData['ticket_type_id'] : 0,
                    
                    'description'           =>  $description, 
                    'priority'              =>  
                    !empty($ticketData['priority']) ? $ticketData['priority'] : 0 , 
                    
                    'severity'              =>  
                    !empty($ticketData['severity']) ? $ticketData['severity'] : 0, 
                    'task_compittion_date'  =>   $ticketData['task_compittion_date'], 
                    
                    'updated_at'            => $ticketData['updated_at'],
                    'project_id'            => $ticketData['project_id'],
                ];
                
            } else {
                $ticketDatas = [
                    'title'                 =>  $ticketData['title'],
                    'ticket_type_id_admin'  =>  !empty($ticketData['ticket_type_id_admin']) ? $ticketData['ticket_type_id_admin'] : 0,
                    'description'           =>  $description, 
                    'ticket_type_id'        =>  !empty($ticketData['ticket_type_id']) ? $ticketData['ticket_type_id'] : 0,
                    'priority'              =>  1, 
                    'severity'              =>  1, 
                    'task_compittion_date'  =>  $ticketData['task_compittion_date'], 
                    'updated_at'            =>  $ticketData['updated_at'],
                    'project_id'            =>  $ticketData['project_id'],
                     'tags_name'            =>  $ticketData['tags_name']
                ];
            }
           

            $updateResult = DB::table($this->table)
            	->where($this->id, $ticketId)
            	->update($ticketDatas);
            
            if  (!empty($ticketStatusId) && !empty($ticketId)) {
                
                $ticketStatusDatas = [
                    'ticket_id'         => $ticketId, 
                    'user_id'           => Session::get('sessionUserData')[0][0]->id, 
                    'ticket_status_id'  =>  $ticketStatusId, 
                    'remark'            =>  $ticketData['remark'], 
                    'created_at'        =>  $ticketData['updated_at'],
                    'updated_at'        =>  $ticketData['updated_at'],
                    'deleted_at'        =>  $ticketData['deleted_at'],
                    'notif_time'        =>  strtotime($newTime)
                ];
                
                $updateResult =  DB::table('ticket_status')->insert($ticketStatusDatas);
                
                /*$ticketStatusDatas = ['ticket_status_id' =>  $ticketStatusId];
                $updateResult = DB::table('ticket_status')
                    ->where('ticket_id', $ticketId)
                    ->update($ticketStatusDatas);*/
            }
        }
      	return $updateResult;
   	}
   	
  /**
    * Update Ticket Remark Data By TicketId
    * 
    * @param  $ticketId INT && $ticketRemarkData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function updateTicketRemark($ticketId = 0,$ticketRemarkData = null)  {
        
    /*  date_default_timezone_set('Asia/Kolkata');
        $minutesAdd = 1;
        //$curTime =   date('Y-m-d H:i:s',time() + 15);
        $curTime =   date('Y-m-d H:i:s');
        $time = new DateTime($curTime);
        $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $newTimes;*/
        
        date_default_timezone_set('Asia/Kolkata');
        // $minutesAdd = 1;
        $curTime =   date('Y-m-d H:i:s',time() + 15);
        // $curTime =   date('Y-m-d H:i:s');
        //// $time = new DateTime($curTime);
        // $time->add(new DateInterval('PT' . $minutesAdd . 'M'));
        // $newTimes = $time->format('Y-m-d H:i:s');
        $newTime = $curTime;
        
        $updateResult = 0;
        /*$ticketStatusDatas = [
            'ticket_status_id' =>  $ticketRemarkData['ticket_status_id']
        ];
        $updateResult = DB::table('ticket_status')->where('ticket_id', $ticketId)->update($ticketStatusDatas);
        $getTicketRemark = DB::select('SELECT COUNT(*) as ticketRemarkCount FROM  `ticket_remark` WHERE is_deleted_status = "N" AND 
        user_id = '.$ticketRemarkData['user_id'].' AND  ticket_id = '.$ticketId.' ');
        if (empty($getTicketRemark[0]->ticketRemarkCount)) {
            $updateResult = DB::table('ticket_remark')->insert($ticketRemarkData);
        } else {*/
            
            $ticketRemarkStatusDatas = [
                'ticket_id'        => $ticketId,
                'user_id'          => Session::get('sessionUserData')[0][0]->id, 
                'ticket_status_id' =>  $ticketRemarkData['ticket_status_id'],
                'remark'           =>  $ticketRemarkData['remark'],
                'created_at'       =>  $ticketRemarkData['created_at'],
                'updated_at'       =>  $ticketRemarkData['updated_at'],
                'deleted_at'       =>  $ticketRemarkData['deleted_at'],
                'notif_time'       =>  strtotime($newTime)
            ];
            
            $updateResult = DB::table('ticket_status')->insert($ticketRemarkStatusDatas);
             
              /* $updateResult = DB::table('ticket_remark')
                ->where('ticket_id', $ticketId)
                ->where('user_id', $ticketRemarkData['user_id'])
                ->update($ticketRemarkStatusDatas);
        }*/
        
        return $updateResult;
    } 



}
