<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
class Employee extends  REST_Controller {

	public function __construct() {
		date_default_timezone_set(timeZone);
		parent::__construct();
		$this->load->model('Employee_Model');
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
	public function getEmployeeList_get($limit = null) {
		$token = $this->jwtauth->ValidateToken();
		if($limit == 1) {
			$limit = 0;
		}
        if($token) {
            $query = $this->Employee_Model->getEmployeeList($limit);
            if($query) {
                $res = array('status'=>true,'message'=>'Employee list found.','list'=>$query);
            } else {
                $res = array('status'=>false,'message'=>'Employee list not found.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    /* Add New Employee */
    public function addEmployee_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $info['added_by'] = $token;
            $info['added_date_time'] = date('Y-m-d h:i:s a');
            if($info['password'] != '' && $info['password'] != null){
                $info['password'] = md5( $info['password']);
			}
			if(!is_null($info['emp_code'])){
				$checkEmpCode = $this->mycustomlibrary->select_row('users',array('emp_code'=>$info['emp_code']));
				if($checkEmpCode) {
					$res = array('status'=>false,'message'=>'Employee code already exist.');
					echo json_encode($res);
					die();
				}
			}
			$query = $this->mycustomlibrary->select_row('users',array('email'=>$info['email']));;
			if($query) {
				$res = array('status'=>false,'message'=>'Email already exist.');
					echo json_encode($res);
					die();
			}
			$info['role'] = 2;
            $query = $this->mycustomlibrary->save_data('users',$info);
            if($query) {
                $getDetails =  $this->Employee_Model->getEmployeeDetails($query);
                $res = array('status'=>true,'message'=>'Employee added successfully.','data'=>$getDetails);
            } else {
                $res = array('status'=>false,'message'=>'Employee not added.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    /* Get Employee Details */
    public function getEmployeeDetails_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $query = $this->Employee_Model->getEmployeeDetails($info['user_id']);
            if($query) {
                $res = array('status'=>true,'message'=>'Employee details found.','data'=>$query);
            } else {
                $res = array('status'=>false,'message'=>'Employee not found.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }

    /* Edit Employee Details */
    public function editEmployeeDetails_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
       if($token) {
            $info['added_by'] = $token;
            if($info['password'] != '' && $info['password'] != null){
                $info['password'] = md5( $info['password']);
            } else {
                unset($info['password']);
			}
			if(!is_null($info['emp_code'])){
				$checkEmpCode = $this->Employee_Model->checkEmpCode($info['emp_code'],$info['user_id']);
				if($checkEmpCode) {
					$res = array('status'=>false,'message'=>'Employee code already exist.');
					echo json_encode($res);
					die();
				}
			}
			$query = $this->Employee_Model->checkEmpEmail($info['email'],$info['user_id']);;
			if($query) {
				$res = array('status'=>false,'message'=>'Email already exist.');
					echo json_encode($res);
					die();
			}
            $query = $this->mycustomlibrary->edit_table_data('user_id',$info['user_id'],'users',$info);
            if($query) {
                $getDetails =  $this->Employee_Model->getEmployeeDetails($info['user_id']);
                $res = array('status'=>true,'message'=>'Employee details updated successfully.','data'=>$getDetails);
            } else {
                $res = array('status'=>false,'message'=>'Employee details not updated.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        }  
    }
    /* Delete Employee */
    public function deleteEmployee_post() {
        $info = $this->post();
        $token = $this->jwtauth->ValidateToken();
        if($token) {
            $query = $this->mycustomlibrary->edit_table_data('user_id',$info['user_id'],'users',array('is_delete'=>1));
            if($query) {
                $res = array('status'=>true,'message'=>'Employee deleted successfully.');
            } else {
                $res = array('status'=>false,'message'=>'Employee not deleted.');
            }
            echo json_encode($res);
        } else {
            return $this->response(array('status'=>0,'title'=>'ERROR','message'=>'Authentication error'), REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
}
?>
