<?php

class Requests_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	

	function get_all_mrequests($status) { 
		$this->db->select('*,CONCAT(projects.project_number,projects.name) as project_name,projects.name,material_req.id as mrid,staff.staffavatar,products.productname');
		$this->db->join( 'projects', 'material_req.project_id = projects.id', 'left' );
		$this->db->join( 'staff', 'material_req.user_id = staff.id', 'left' );
		$this->db->join( 'products', 'material_req.mname = products.id', 'left' );
		
		$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status ) )->result_array();
	}
	function get_user_mrequests($status,$user_id) { 
		$this->db->select('*,CONCAT(projects.project_number,projects.name) as project_name,projects.name,material_req.id as mrid,staff.staffavatar,products.productname');
		$this->db->join( 'projects', 'material_req.project_id = projects.id', 'left' );
		$this->db->join( 'staff', 'material_req.user_id = staff.id', 'left' );
		$this->db->join( 'products', 'material_req.mname = products.id', 'left' );
		$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status,'material_req.user_id' => $user_id ) )->result_array();
	}
	function get_appreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status ) )->result_array();
	}
	
	function get_user_appreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status,'material_req.user_id' => $user_id  ) )->result_array();
	}
	function get_decreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status ) )->result_array();
	}
	function get_user_decreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status, 'material_req.user_id' => $user_id  ) )->result_array();
	}
	function get_allreq_count($status){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status ) )->result_array();
	}
	function get_user_allreq_count($status,$user_id){
				$this->db->select('*');
				$this->db->order_by( 'material_req.id', 'desc' );
		return $this->db->get_where( 'material_req', array( 'material_req.status' => $status, 'material_req.user_id' => $user_id  ) )->result_array();
	}

	function get_mreq_data($id)
{
	return $this->db->select('*')
	                ->from('material_req')
				    ->where(['id'=>$id])
				    ->get()
				    ->row();
}

function update_mreq_data($id,$price,$status){
	
	 $this->db->set('price', $price);
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $result=$this->db->update('material_req');
		return $result;
}

function get_prd_data($id)
{
	return $this->db->select('*')
	                ->from('products')
				    ->where(['id'=>$id])
				    ->get()
				    ->row();
}
}