<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class ProjectModel extends Model
{
	
    protected  $table = 'project_master';	
    protected  $id = 'id'; // PK
    protected  $name = 'name'; 
    protected  $description = 'description'; 
    protected  $status = 'status';
    protected  $is_deleted_status = 'is_deleted_status';
    protected  $created_at = 'created_at';
    protected  $updated_at = 'updated_at';
    protected  $deleted_at = 'deleted_at';

  /**
    *  get project Data 
    *
    * @return $getUserData Arr    
    * @author <satishchauhan041@gmail.com>
    */
    public function selectProject() {
      	$getProjectData = [];
      	$getProjectData = DB::table($this->table)->select('*')
        ->where($this->is_deleted_status, 'N')
        ->orderBy($this->name,'ASC')
        ->get()
        ->toArray();
      	return $getProjectData;
    }
  
  /**
    * Insert project Data 
    * 
    * @param  $projectData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function projectInsert($projectData = null) {
        $insertResult = 0;
        if (!empty($projectData)) {        
          $insertResult = DB::table($this->table)->insertGetId($projectData);
        }
      return $insertResult;
    }

  /**
    * check in project
    * 
    * @param  $date VARCHAR
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
    public function checkProjectNameAlredyExists($name = null,$projectId = 0) {
        $checkResult = 0;
        if (!empty($projectId)) {
          if (!empty($name)) {
              $checkResult = DB::table($this->table)
              ->select($this->name)
              ->where($this->name,$name)
              ->where($this->id, '!=',$projectId)
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
    * get project Data By projectId
    * 
    * @param  $projectId INT
    * @return $getUserDataByID Arr     
    * @author <satishchauhan041@gmail.com>
    */
   	public function selectProjectDataByID($projectId = null) {
      	$getProjectDataByID = [];
      	if (!empty($projectId)) {
          	$getProjectDataByID = DB::table($this->table)
            	->select('*')
            	->where($this->id, $projectId)
            	->where($this->is_deleted_status, 'N')
            	->get()
            	->toArray();
        	return $getProjectDataByID;
      	}
      	return $getProjectDataByID;
   	}
	
   /**
    * delete project Data By projectId
    * 
    * @param   $projectId INT
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function deleteProject($projectId = null) {
   		
   		 date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');

        $projectData = [
        	$this->is_deleted_status => 'Y',
        	$this->deleted_at => $time
       	];

		$deleteResult = 0;
      	if (!empty($projectId)) {
          	$deleteResult = DB::table($this->table)
             	->where($this->id, $projectId)
                ->update($projectData);
            
            $deleteResult = DB::table('project_assing_user')
              ->where('project_id', $projectId)
              ->update($projectData);
        }
      	return $deleteResult;
   	}
	

   /**
    * Update project Data By projectId
    * 
    * @param  $projectId INT && $projectData Arr
    * @return  Boolen 0 or 1     
    * @author <satishchauhan041@gmail.com>
    */
   	public function updateProject($projectData = null,$projectId = 0) {
      	$updateResult = 0;
      	if (!empty($projectData) && !empty($projectId)) {
        	$updateResult = DB::table($this->table)
            	->where($this->id, $projectId)
            	->update($projectData);
      	}
      	return $updateResult;
   	}


}
