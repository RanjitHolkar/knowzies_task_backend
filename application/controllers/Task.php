<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
class Task extends  REST_Controller {

	public function __construct() {
		date_default_timezone_set(timeZone);
		parent::__construct();
		$this->load->model('Task_Model');
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: *");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400'); 
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
           if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
             header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");         

         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
             header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		 exit(0);
		}
	}
	public function getTaskList_get($limit = null) {
		$token = $this->jwtauth->ValidateToken();
		if($limit == 1) {
			$limit = 0;
		}
        if($token) {
            $query = $this->Task_Model->getTaskList($limit);
            if($query) {
                $res = array('status'=>true,'message'=>'Task list found.','list'=>$query);
            } else {
                $res = array('status'=>false,'message'=>'Task list not found.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    /* Add New Task */
    public function addTask_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $info['added_by'] = $token;
            $info['added_date_time'] = date('Y-m-d h:i:s a');
            $query = $this->mycustomlibrary->save_data('task',$info);
            if($query) {
                $getDetails =  $this->Task_Model->getTaskDetails($query);
                $res = array('status'=>true,'message'=>'Task added successfully.','data'=>$getDetails);
            } else {
                $res = array('status'=>false,'message'=>'Task not added.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    /* Get Task Details */
    public function getTaskDetails_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $query = $this->Task_Model->getTaskDetails($info['user_id']);
            if($query) {
                $res = array('status'=>true,'message'=>'Task details found.','data'=>$query);
            } else {
                $res = array('status'=>false,'message'=>'Task not found.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }

    /* Edit Task Details */
    public function editTaskDetails_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
       if($token) {
            $info['added_by'] = $token;
            $query = $this->mycustomlibrary->edit_table_data('task_id',$info['task_id'],'task',$info);
            if($query) {
                $getDetails =  $this->Task_Model->getTaskDetails($info['task_id']);
                $res = array('status'=>true,'message'=>'Task details updated successfully.','data'=>$getDetails);
            } else {
                $res = array('status'=>false,'message'=>'Task details not updated.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        }  
    }
    /* Delete Task */
    public function deleteTask_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $query = $this->mycustomlibrary->edit_table_data('task_id',$info['task_id'],'task',array('is_delete'=>1));
            if($query) {
                $res = array('status'=>true,'message'=>'Task deleted successfully.');
            } else {
                $res = array('status'=>false,'message'=>'Task not deleted.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
	}
	/* Get Employee Task */
	public function getEmpTaskList_get() {
		$token = $this->jwtauth->ValidateToken();
		if($token) {
            $query = $this->mycustomlibrary->select_data('task',array('is_delete'=>0,'user_id'=>$token));
            if($query) {
                $res = array('status'=>true,'message'=>'Task list found.','list'=>$query);
            } else {
                $res = array('status'=>false,'message'=>'Task list not found.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        }
	}
}
?>
