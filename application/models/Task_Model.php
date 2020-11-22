<?php 
class Task_Model extends CI_Model {
    public function getTaskList() {
        $this->db->select('task.*,user1.first_name,user1.last_name,user2.first_name as fname,user2.last_name as lname');
        $this->db->from('task');
		$this->db->join('users as user1','task.user_id = user1.user_id','left');
		$this->db->join('users as user2','task.added_by = user2.user_id','left');
		$this->db->where('task.is_delete',0);
		$this->db->order_by('task.task_id','desc');
        return  $this->db->get()->result_array();
	}
	
    /* Get User Details */
    public function getTaskDetails($task_id) {
        $this->db->select('task.*,user1.first_name,user1.last_name,user2.first_name as fname,user2.last_name as lname');
        $this->db->from('task');
		$this->db->join('users as user1','task.user_id = user1.user_id','left');
		$this->db->join('users as user2','task.added_by = user2.user_id','left');
        $this->db->where('task.task_id',$task_id);
        return  $this->db->get()->row();
	}
	// /* Check Emplpoyee Code */
	// public function checkEmpCode($emp_code,$user_id) {
	// 	$this->db->select('*');
	// 	$this->db->from('users');
	// 	$this->db->where('emp_code',$emp_code);
	// 	$this->db->where('user_id !=',$user_id);
	// 	return  $this->db->get()->row();
	// }
	// /* Check Emplpoyee Code */
	// public function checkEmpEmail($email,$user_id) {
	// 	$this->db->select('*');
	// 	$this->db->from('users');
	// 	$this->db->where('email',$email);
	// 	$this->db->where('user_id !=',$user_id);
	// 	return  $this->db->get()->row();
	// }
}
