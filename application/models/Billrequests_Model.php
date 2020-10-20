<?php

class Billrequests_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	

	function get_all_brequests($status,$user_id) {
			if($status == 0){
				$this->db->select('*,GROUP_CONCAT(bill_request_files.file_name) as files,staff.staffavatar,bill_requests.status as bill_status');
				$this->db->join( 'bill_request_files', 'bill_requests.bill_id = bill_request_files.bill_id', 'left' );
				$this->db->join('staff','bill_requests.user_id=staff.id','left');
				
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->group_by("bill_requests.bill_id");
				$this->db->where('bill_requests.status != ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
			}else{
				$this->db->select('*,GROUP_CONCAT(bill_request_files.file_name) as files,staff.staffavatar,bill_requests.status as bill_status');
				$this->db->join( 'bill_request_files', 'bill_requests.bill_id = bill_request_files.bill_id', 'left' );
				
				$this->db->join('staff','bill_requests.user_id=staff.id','left');
				
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->group_by("bill_requests.bill_id");
				$this->db->where('bill_requests.status ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
			}
			
	}
	
	
//For admin

function get_all_user_brequests($status) {
			if($status == 0){
				$this->db->select('*,GROUP_CONCAT(bill_request_files.file_name) as files,staff.staffavatar,bill_requests.status as bill_status,bill_requests.bill_id as billid');
				$this->db->join( 'bill_request_files', 'bill_requests.bill_id = bill_request_files.bill_id', 'left' );
				$this->db->join('staff','bill_requests.user_id=staff.id','left');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->group_by("bill_requests.bill_id");
				$this->db->where('bill_requests.status != ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
			}else{
				$this->db->select('*,GROUP_CONCAT(bill_request_files.file_name) as files,staff.staffavatar,bill_requests.status as bill_status,bill_requests.bill_id as billid');
				$this->db->join( 'bill_request_files', 'bill_requests.bill_id = bill_request_files.bill_id', 'left' );
				$this->db->join('staff','bill_requests.user_id=staff.id','left');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->group_by("bill_requests.bill_id");
				$this->db->where('bill_requests.status ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
			}
			
	}
	
	function get_appreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	function get_appreq_user_count($status){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	function get_decreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	function get_decreq_user_count($status){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	
	function get_pendreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	
	function get_pendreq_user_count($status){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				$this->db->where('bill_requests.status ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( 'bill_requests.status' => $status ) )->result_array();
	}
	
	
	function get_allreq_count($user_id){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				//$this->db->where('bill_requests.status ', $status);
				$this->db->where('bill_requests.user_id',$user_id);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( '' ) )->result_array();
	}
	
	function get_allreq_user_count(){
				$this->db->select('*');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
				//$this->db->where('bill_requests.status ', $status);
				return $this->db->get( 'bill_requests' )->result_array();
		//return $this->db->get_where( 'bill_requests', array( '' ) )->result_array();
	}
	
	function update_status($id,$status){
		$getbillstresult = $this->db->get_where('bill_requests', array('bill_requests.bill_id'=> $id))->row_array();
		$staffId=$getbillstresult['user_id'];
		$seriesid=$getbillstresult['seriesid'];
        $approve_level=$getbillstresult['approve_level'];
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
		if($status=='2'){
			$getapprovals=$this->Approvals_Model->getapprovalsByType('billrequests');
			$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
			$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
			if($optionType=='level'){
				if($maxapproverLevel== $approve_level){
					$this->db->set('status', $status);
				}else{
					$currentLevel=$approve_level+1;
					$this->db->set('approve_level', $currentLevel);
					$showStatus='Approve '.$approve_level.' Level';
				}
			}else if($optionType=='price'){
				$this->db->set('status', $status);
			}
			$this->db->where('bill_id', $id);
			$result=$this->db->update('bill_requests');
		}else{
			$this->db->set('status', $status);
			$this->db->where('bill_id', $id);
			$result=$this->db->update('bill_requests');
		}
		
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' =>( '' .$seriesid.' '.$showStatus.'  By '. $this->session->staffname .'' ),
			'staff_id' => $staffId,
			'target' => '' . base_url( 'billrequests/') . '',
			'perres' => $this->session->staffavatar
		) );
		return $result;
	}
	function get_images($id)
	{
			$this->db->select('*,GROUP_CONCAT(bill_request_files.file_name) as files');
				$this->db->join( 'bill_request_files', 'bill_requests.bill_id = bill_request_files.bill_id', 'left' );
			$this->db->from('bill_requests');
				$this->db->order_by( 'bill_requests.bill_id', 'desc' );
			$this->db->where('bill_requests.bill_id', $id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->files;
			} else {
				return false;
			}
		
				
	}
	function get_vendor_name($vendor_id){
		$this->db->select('company');

			$this->db->from('vendors');
				$this->db->order_by( 'vendors.id', 'desc' );
			$this->db->where('vendors.company', $vendor_id);
			$row = $this->db->get()->row();
			if (isset($row)) {
				return $row->company;
			} else {
				return false;
			}
		
		
	}
}