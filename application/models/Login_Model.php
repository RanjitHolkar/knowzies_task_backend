<?php 
class Login_Model extends CI_Model {
    /* Get Login Details */
    public function getLoginDetails($email,$pass) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->join('user_role','users.user_role_id = user_role.user_role_id','left');
        $this->db->where('users.email',$email);
        $this->db->where('users.password',md5($pass));
        return $this->db->get()->row();
    }
}