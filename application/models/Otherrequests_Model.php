<?php

class Otherrequests_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	

	function get_all_orequests($status) {
			if($status == 0){
				$this->db->select('*,GROUP_CONCAT(other_request_files.file_name) as files,staff.staffavatar,other_requests.id as request_id,other_requests.status as request_status');
				$this->db->join( 'other_request_files', 'other_requests.id = other_request_files.request_id', 'left' );
				$this->db->join( 'staff', 'other_requests.user_id = staff.id', 'left' );
				$this->db->order_by( 'other_requests.id', 'desc' );
				$this->db->group_by("other_requests.id");
				$this->db->where('other_requests.status != ', $status);
				return $this->db->get( 'other_requests' )->result_array();
			}else{
				$this->db->select('*,GROUP_CONCAT(other_request_files.file_name) as files,staff.staffavatar,,other_requests.id as request_id,other_requests.status as request_status');
            	$this->db->join( 'other_request_files', 'other_requests.id = other_request_files.request_id', 'left' );
				$this->db->join( 'staff', 'other_requests.user_id = staff.id', 'left' );
				$this->db->order_by( 'other_requests.id', 'desc' );
				$this->db->group_by("other_requests.id");
				$this->db->where('other_requests.status ', $status);
				return $this->db->get( 'other_requests' )->result_array();
			}
	}
	function get_user_all_orequests($status,$user_id) {
			if($status == 0){
				$this->db->select('*,GROUP_CONCAT(other_request_files.file_name) as files,staff.staffavatar,other_requests.id as request_id,other_requests.status as request_status');

				$this->db->join( 'other_request_files', 'other_requests.id = other_request_files.request_id', 'left' );
				$this->db->join( 'staff', 'other_requests.user_id = staff.id', 'left' );
				$this->db->order_by( 'other_requests.id', 'desc' );
				$this->db->group_by("other_requests.id");
				$this->db->where('other_requests.status != ', $status);
				$this->db->where('other_requests.user_id',$user_id);
				return $this->db->get( 'other_requests' )->result_array();
			}else{
				$this->db->select('*,GROUP_CONCAT(other_request_files.file_name) as files,staff.staffavatar,other_requests.id as request_id,other_requests.status as request_status');

				$this->db->join( 'other_request_files', 'other_requests.id = other_request_files.request_id', 'left' );
				$this->db->join( 'staff', 'other_requests.user_id = staff.id', 'left' );
				$this->db->order_by( 'other_requests.id', 'desc' );
				$this->db->group_by("other_requests.id");
				$this->db->where('other_requests.status ', $status);
				$this->db->where('other_requests.user_id',$user_id);
				return $this->db->get( 'other_requests' )->result_array();
			}
	}
	
	function get_appreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status ) )->result_array();
	}
	
	function get_user_appreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status,'other_requests.user_id' => $user_id ) )->result_array();
	}
	
	function get_decreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status ) )->result_array();
	}
	
	function get_user_decreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status,'other_requests.user_id' => $user_id  ) )->result_array();
	}
	function get_pendreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status ) )->result_array();
	}
	
	function get_user_pendreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.status' => $status,'other_requests.user_id' => $user_id ) )->result_array();
	}
	
	function get_allreq_count(){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( '' ) )->result_array();
	}
	
	function get_user_allreq_count($user_id){
				$this->db->select('*');
				$this->db->order_by( 'other_requests.id', 'desc' );
		return $this->db->get_where( 'other_requests', array( 'other_requests.user_id' => $user_id ) )->result_array();
	} 
	function update_status($id,$status){
	    $getothertresult = $this->db->get_where('other_requests', array('other_requests.id'=> $id))->row_array();
		$staffId=$getothertresult['user_id'];
		$seriesid=$getothertresult['seriesid'];
	
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $result=$this->db->update('other_requests');
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
			'target' => '' . base_url( 'mrequests/otherrequest/') . '',
			'perres' => $this->session->staffavatar
		) );
		
		
		
		
		
		return $result;
	}
	
}