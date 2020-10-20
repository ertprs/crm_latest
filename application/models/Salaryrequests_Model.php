<?php

class Salaryrequests_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	

	function get_all_srequests($status) {
			if($status == 0){
				$this->db->select('*,staff.staffname,staff.staffavatar,salary_requests.status as salarystatus');
				$this->db->join( 'staff', 'salary_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
				$this->db->where('salary_requests.status != ', $status);
				return $this->db->get( 'salary_requests' )->result_array();
			}else{
				$this->db->select('*,staff.staffname,salary_requests.status as salarystatus');
				$this->db->join( 'staff', 'salary_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
				$this->db->where('salary_requests.status ', $status);
				return $this->db->get( 'salary_requests' )->result_array();
			}
	}
	
	function get_user_all_srequests($status,$user_id) {
			if($status == 0){
				$this->db->select('*,staff.staffname,staff.staffavatar,salary_requests.status as salarystatus');
				$this->db->join( 'staff', 'salary_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
				$this->db->where('salary_requests.status != ', $status);
				$this->db->where('salary_requests.user_id',$user_id);
				return $this->db->get( 'salary_requests' )->result_array();
			}else{
				$this->db->select('*,staff.staffname,salary_requests.status as salarystatus');
				$this->db->join( 'staff', 'salary_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
				$this->db->where('salary_requests.status ', $status);
				$this->db->where('salary_requests.user_id',$user_id);
				return $this->db->get( 'salary_requests' )->result_array();
			}
	}
	
	
	function get_appreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status ) )->result_array();
	}
	
	function get_user_appreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status,'salary_requests.user_id' => $user_id ) )->result_array();
	}
	
	
	function get_decreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status ) )->result_array();
	}
	
	function get_user_decreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status,'salary_requests.user_id' => $user_id  ) )->result_array();
	}
	
	function get_pendreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status ) )->result_array();
	}
	
	function get_user_pendreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.status' => $status,'salary_requests.user_id' => $user_id  ) )->result_array();
	}
	
	function get_allreq_count(){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( '' ) )->result_array();
	}
	
	function get_user_allreq_count($user_id){
				$this->db->select('*');
				$this->db->order_by( 'salary_requests.salary_id', 'desc' );
		return $this->db->get_where( 'salary_requests', array( 'salary_requests.user_id'=> $user_id ) )->result_array();
	}
	function get_single_request($id){
		return $getsalaryresult = $this->db->get_where('salary_requests', array('salary_requests.salary_id'=> $id))->row_array();
	}
	function update_status($id,$status){
		$getsalaryresult = $this->db->get_where('salary_requests', array('salary_requests.salary_id'=> $id))->row_array();
		$staffId=$getsalaryresult['user_id'];
		$seriesid=$getsalaryresult['seriesid'];
	
        $this->db->set('status', $status);
        $this->db->where('salary_id', $id);
        $result=$this->db->update('salary_requests');
		$showStatus='';
		switch ($status) {
			case '1':
				$showStatus = lang( 'Pending' );
				break;
			case '2':
				$showStatus = lang( 'Approved' );
				break;
			case '3':
				$showStatus = lang( 'Rejected' );
				break;
		};
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' =>( '' .$seriesid.' '.$showStatus.'  By '. $this->session->staffname .'' ),
			'staff_id' => $staffId,
			'target' => '' . base_url( 'salaryrequests/') . '',
			'perres' => $this->session->staffavatar
		) );
		return $result;
	}
	function getstaffnamebyid($staff_id) {
		$this->db->select('*,staff.staffname,staff.staffavatar');
		$this->db->where('staff.id= ', $staff_id);
		return $this->db->get( 'staff' )->row();
	
	}	
}