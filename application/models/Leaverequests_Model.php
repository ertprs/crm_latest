<?php

class Leaverequests_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	

	function get_all_lrequests($status) {
			if($status == 0){
				$this->db->select('*,staff.staffname,staff.staffavatar,leave_requests.status as leave_status');
				$this->db->join( 'staff', 'leave_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('leave_requests.status != ', $status);
				return $this->db->get( 'leave_requests' )->result_array();
			}else{
				$this->db->select('*,staff.staffname,staff.staffavatar,leave_requests.status as leave_status');
				$this->db->join( 'staff', 'leave_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('leave_requests.status ', $status);
				return $this->db->get( 'leave_requests' )->result_array();
			}
	}
	function get_user_all_lrequests($status,$user_id) {
		
			if($status == 0){
				$this->db->select('*,staff.staffname,staff.staffavatar,leave_requests.status as leave_status');
				$this->db->join( 'staff', 'leave_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('leave_requests.status != ', $status);
				
				$this->db->where('leave_requests.user_id ',$user_id);
				
				return $this->db->get( 'leave_requests' )->result_array();
			}else{
				$this->db->select('*,staff.staffname,staff.staffavatar,leave_requests.status as leave_status');
				$this->db->join( 'staff', 'leave_requests.employee_id = staff.id', 'left' );
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('leave_requests.status ', $status);
				$this->db->where('leave_requests.user_id ',$user_id);
				return $this->db->get( 'leave_requests' )->result_array();
			}
	}
	function get_appreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status ) )->result_array();
	}
	function get_user_appreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status,'leave_requests.user_id' => $user_id ) )->result_array();
	}
	function get_decreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status ) )->result_array();
	}
	function get_user_decreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status,'leave_requests.user_id' => $user_id ) )->result_array();
	}
	function get_pendreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status ) )->result_array();
	}
	function get_user_pendreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.status' => $status,'leave_requests.user_id' => $user_id ) )->result_array();
	}
	function get_allreq_count(){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( '' ) )->result_array();
	}
	function get_user_allreq_count($user_id){
				$this->db->select('*');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
		return $this->db->get_where( 'leave_requests', array( 'leave_requests.user_id' => $user_id ) )->result_array();
	}
	function update_status($id,$status,$method_of_leave,$payment_type,$leave_start_date,$rejoin_date,$no_of_days){
	
	
        $this->db->set('status', $status);
		$this->db->set('method_of_leave', $method_of_leave);
		$this->db->set('payment_type', $payment_type);
		$this->db->set('leave_start_date', $leave_start_date);
		$this->db->set('rejoin_date', $rejoin_date);
		$this->db->set('no_of_days', $no_of_days);
		
        $this->db->where('leave_id', $id);
        $result=$this->db->update('leave_requests');
		//echo $this->db->last_query();exit;
		return $result;
	} 
	function get_leave_data($id){
	$this->db->select('*');
			$this->db->from('leave_requests');
				$this->db->where('leave_id', $id);
			$row = $this->db->get()->row_array();
			if (isset($row)) {
				return $row;
			} else {
				return false;
			}
	}
	function get_annualleave_count()
	{
			$this->db->select('sum(no_of_days) as annual_count');
			$this->db->from('leave_requests');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('type_of_leave','Annual Leave');
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->annual_count;
			} else {
				return false;
			}
		
	}
	function get_user_annualleave_count($user_id)
	{
			$this->db->select('sum(no_of_days) as annual_count');
			$this->db->from('leave_requests');
				$this->db->order_by( 'leave_requests.leave_id', 'desc' );
				$this->db->where('type_of_leave','Annual Leave');
				$this->db->where('leave_requests.user_id',$user_id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->annual_count;
			} else {
				return false;
			}
		
	}
	function get_sickleave_count()
	{
			$this->db->select('sum(no_of_days) as sick_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Sick Leave');
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->sick_count;
			} else {
				return false;
			}
		
	}
	function get_user_sickleave_count($user_id)
	{
			$this->db->select('sum(no_of_days) as sick_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Sick Leave');
			$this->db->where('leave_requests.user_id',$user_id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->sick_count;
			} else {
				return false;
			}
		
	}
	function get_casual_leave_count()
	{
			$this->db->select('sum(no_of_days) as casual_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Casual Leave');
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->casual_count;
			} else {
				return false;
			}
		
	}
	function get_user_casual_leave_count($user_id)
	{
			$this->db->select('sum(no_of_days) as casual_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Casual Leave');
			$this->db->where('leave_requests.user_id',$user_id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->casual_count;
			} else {
				return false;
			}
		
	}
	
	function get_emergency_leave_count()
	{
			$this->db->select('sum(no_of_days) as emergency_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Emergency Leave');
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->emergency_count;
			} else {
				return false;
			}
		
	}
	function get_user_emergency_leave_count($user_id)
	{
			$this->db->select('sum(no_of_days) as emergency_count');
			$this->db->from('leave_requests');
			$this->db->order_by( 'leave_requests.leave_id', 'desc' );
			$this->db->where('type_of_leave','Emergency Leave');
			$this->db->where('leave_requests.user_id',$user_id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->emergency_count;
			} else {
				return false;
			}
		
	}
	
	function get_leave_count_data($sdate,$edate,$uid)
	{
		//echo $sdate.''.$edate.''.$uid;exit;
		$this->db->select('sum(no_of_days) as emergency_count');
			$this->db->from('leave_requests');
			$this->db->where("leave_start_date >= '".$sdate."'");
$this->db->where( "leave_start_date <= '".$edate."'");
			$this->db->where('leave_requests.employee_id',$uid);
			$row = $this->db->get()->row();
			//echo $this->db->last_query();
			if (isset($row)) {
				return $row->emergency_count;
			} else {
				return false;
			}
		
	}
	function getstaffnamebyid($staff_id) {
		$this->db->select('*,staff.staffname,staff.staffavatar');
		$this->db->where('staff.id= ', $staff_id);
		return $this->db->get( 'staff' )->row();
	
}
}