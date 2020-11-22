<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
class Login extends  REST_Controller {

	public function __construct() {
		date_default_timezone_set(timeZone);
		parent::__construct();
		$this->load->model('Login_Model');
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
	/* Check USers Credentials Valid Or Not */
	public function checkLogin_POST(){
		$info = $this->post();
		$validationRules = array(
			array('field' => 'email','label' => 'email','rules' => 'required'),array('field' => 'password','label' => 'password','rules' => 'required'));
		$this->form_validation->set_rules($validationRules);
		if ($this->form_validation->run()){
			$query = $this->mycustomlibrary->select_row('users',array('email'=>$info['email'],'password'=>md5($info['password'])));
			if($query) {
				if($query->role == 1)
					$role = 'manager';
				else 
					$role = 'employee';
				
				$query->token = $this->mycustomlibrary->createToken($query->user_id,$role);
				$res = array('status'=>true,'message'=>'Login Successfully','userDetails'=>$query);
			} else {
				$res = array('status'=>false,'message'=>'Your email id and password invalid,Please try again');
			}
			echo json_encode($res);
		} else {
			$this->response(array('status'=>FALSE,'message'=>$this->form_validation->error_array()), 400);
		}
	}
}
?>
