<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MyCustomLibrary {
	
	private $CI;

  public function __construct() {
      $this->CI =& get_instance();
  }

  public function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  /*Create the token after user is logged in*/
  public function createToken($db_usr_id,$role){	  
    $data= $this->CI->jwtauth->CreateToken($db_usr_id,$role);
    return $data['token'];
  }

  public function save_data($tablename,$savedata) {
			$result  = $this->CI->db->insert($tablename,$savedata);
			// return $this->CI->db->last_query();
      $id=$this->CI->db->insert_id();  
      return $id;
  }

  public function save_addresss($tablename,$savedata) {
      $result  = $this->CI->db->insert_batch($tablename,$savedata);
      return $this->CI->db->insert_id();
  }

  public function select_data($tablename,$condition) {
    if(empty($condition)) {
      $query  =  $this->CI->db->get($tablename);
    } else {
      $query  =  $this->CI->db->get_where($tablename,$condition);
    }
    return  $query->result();
	}

  public function select_row($tablename,$condition) {
    if(empty($condition)){
      $query  =  $this->CI->db->get($tablename);
    } else {
      $query  =  $this->CI->db->get_where($tablename,$condition);
    } 
    return  $query->row();
  }

  public function select_data_byorder($tablename,$condition,$order) {
    if(empty($condition)){
      $this->CI->db->order_by($order, 'desc');
      $query  =  $this->CI->db->get($tablename);
    } else {
      $this->CI->db->order_by($order, 'desc');
      $query  =  $this->CI->db->get_where($tablename,$condition);
    }
    return  $query->result();
  }

  public function edit_table_data($primary_field,$primary_field_id,$tablename,$data) {
    $this->CI->db->where($primary_field,$primary_field_id);
    return  $this->CI->db->update($tablename,$data);
  }

  public function delete_row($primary_field,$primary_field_id,$tablename) {
    $this->CI->db->where($primary_field,$primary_field_id);
    $this->CI->db->delete($tablename);
    if ($this->CI->db->affected_rows() > 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function center_data($center_id) {
    $this->CI->db->select('*');
    $this->CI->db->from('centers');
    $this->CI->db->join('states','centers.CenState=states.id','left');
    $this->CI->db->join('districts','centers.CenDist=districts.iddistricts','left');
    $this->CI->db->join('talukas','centers.CenTaluka=talukas.idtalukas','left');
    $this->CI->db->join('coordinators','centers.cenCordinator=coordinators.idcoordinators','left');
    $this->CI->db->where('centers.idcenters',$center_id);
    return  $this->CI->db->get()->result();
  }

  public function get_row_count($tablename,$condition) {
    if(empty($condition)) {   
      $query  =  $this->CI->db->get($tablename);
    } else {
      $query  =  $this->CI->db->get_where($tablename,$condition);
    }
    return  $query->num_rows();
  }

  public function gte_all_data($tablename) {
    $this->CI->db->select('*');
    $this->CI->db->from($tablename);
    return $this->CI->db->get()->result_array();
  }
  // This Function For Send Mail
  Public function sendMail($to,$html,$subject){
    if (mail($to,$subject,$html)) {
      echo "Your Mail is sent successfully."; 
    } else {
      echo "Your Mail is not sent. Try Again."; 
    }
    // $message= $html;
    // $config = array(
    //   'protocol' => 'smtp',
    //   'smtp_host' => 'ssl://smtp.googlemail.com',
    //   'smtp_port' => 465,
    //   'smtp_user' => 'ranjitholkar75@gmail.com', 
    //   'smtp_pass' => 'RanjitHolkar@123',//my valid email password
    //   'mailtype' => 'html',
    //   'charset' => 'iso-8859-1',
    //   'wordwrap' => TRUE
    //         );
    // $this->CI->email->initialize($config);
    // $this->CI->load->library('email', $config);
    // $this->CI->email->set_newline("\r\n");  
    // $this->CI->email->from('ranjitholkar75@gmail.com'); 
    // $this->CI->email->to($to);
    // $this->CI->email->subject($subject);
    // $this->CI->email->message($message); 
    // $response=$this->CI->email->send();
    // return $response;
  }

}

 ?>
