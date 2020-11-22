<?php 
class Employee_Model extends CI_Model {
    public function getEmployeeList($limit) {
        $this->db->select('user1.*,user2.first_name as fname,user2.last_name as lname');
        $this->db->from('users as user1');
        $this->db->join('users as user2','user1.added_by = user2.user_id','left');
		$this->db->where('user1.is_delete',0);
		$this->db->where('user1.role',2);
		$this->db->order_by('user1.user_id','desc');
		if(!is_null($limit)){
			$this->db->limit(pageLimit,pageLimit*$limit);
		}
        return  $this->db->get()->result_array();
	}
	
    /* Get User Details */
    public function getEmployeeDetails($user_id) {
        $this->db->select('user1.*,user2.first_name as fname,user2.last_name as lname');
        $this->db->from('users as user1');
        $this->db->join('users as user2','user1.added_by = user2.user_id','left');
        $this->db->where('user1.user_id',$user_id);
        return  $this->db->get()->row();
	}
	/* Check Emplpoyee Code */
	public function checkEmpCode($emp_code,$user_id) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('emp_code',$emp_code);
		$this->db->where('user_id !=',$user_id);
		return  $this->db->get()->row();
	}
	/* Check Emplpoyee Code */
	public function checkEmpEmail($email,$user_id) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email',$email);
		$this->db->where('user_id !=',$user_id);
		return  $this->db->get()->row();
	}
}
