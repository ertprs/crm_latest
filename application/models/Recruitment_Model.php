<?php
class Recruitment_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function update($id,$data){
		$this->db->set($data);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'history_logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated' ) . ' <a href="recruitment/GetRecruitment/' .$id . '">' . $params['applicant_name'] . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'type'=>'Recruitment',
			'vendor_id'=>$id
		) );
		return $result;
	}
	function update_remarks($id,$remarks,$status){
		$this->db->set('rejected_remarks', $remarks);
		$this->db->set('status',$status);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'history_logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated Status' ) . ' <a href="recruitment/GetRecruitment/' .$id . '">' . $status. '</a>.' ),
			'staff_id' => $loggedinuserid,
			'type'=>'Recruitment',
			'vendor_id'=>$id
		) );
		return $result;
	}
	function get_all_candidates($type="") {
		if($type) $this->db->where("recruitment_candidates.status",$type);
		$this->db->select( '*' );
		$this->db->order_by("candidate_id","desc");
		return $this->db->get_where( 'recruitment_candidates', array( '' ) )->result_array();
	}
	function get_all_candidates_privileges($type="",$staff_id='') {
		if($type) $this->db->where("recruitment_candidates.status",$type);
		$this->db->select( '*' );
		$this->db->order_by("candidate_id","desc");
		return $this->db->get_where( 'recruitment_candidates', array( "user_id"=>$staff_id ) )->result_array();
	}
	function update_candidate_status($id,$status){
		$this->db->set('status',$status);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'history_logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated Status' ) . ' <a href="recruitment/GetRecruitment/' .$id . '">' . $status. '</a>.' ),
			'staff_id' => $loggedinuserid,
			'type'=>'Recruitment',
			'vendor_id'=>$id
		) );
		return $result;
	}
	function update_file($id,$filename,$filetype){
		$this->db->set('file_name',$filename);
		$this->db->set('filetype',$filetype);
		$this->db->where('candidate_id', $id);
		$result=$this->db->update('recruitment_candidates');
		$this->db->insert( 'history_logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated Document' ) . ' <a href="recruitment/GetRecruitment/' .$id . '">' . $filename. '</a>.' ),
			'staff_id' => $loggedinuserid,
			'type'=>'Recruitment',
			'vendor_id'=>$id
		) );
		return $result;
	}
	function GetRecruitment( $id ) {
		return $this->db->get_where( 'recruitment_candidates', array( 'candidate_id' => $id ) )->row_array();
	}
	function delete_recruitment($id) {
		$this->db->delete('history_logs', array( 'vendor_id' => $id,'type'=>'Recruitment'));
		return $del= $this->db->delete('recruitment_candidates', array( 'candidate_id' => $id));
	}
     
}