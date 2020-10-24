<?php
class Recruitment_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	
			function update_remarks($id,$remarks,$status){
			  $this->db->set('rejected_remarks', $remarks);
			  $this->db->set('status',$status);
					$this->db->where('candidate_id', $id);
					
					$result=$this->db->update('recruitment_candidates');
					return $result;
			}
				

	function get_all_candidates() {
		$this->db->select( '*' );
		$this->db->order_by("candidate_id","desc");

		return $this->db->get_where( 'recruitment_candidates', array( '' ) )->result_array();
	}
	function update_candidate_status($id,$status){
		$this->db->set('status',$status);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
					return $result;
	}
	function update_file($id,$filename,$filetype){
		$this->db->set('file_name',$filename);
		$this->db->set('filetype',$filetype);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
			return $result;
	}
	
     
}