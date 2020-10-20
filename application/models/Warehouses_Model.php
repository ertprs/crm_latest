<?php
class Warehouses_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_warehouses( $id ) {
		$this->db->select( '*, warehouses.warehouse_id as id ' );
		return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id ) )->row_array();
	}
	
	function get_all_supplier_by_search($supplier='') {
		$this->db->select( '*' );
		$this->db->from('vendors');
		$this->db->where('(
			company LIKE "' . $supplier . '%"
		
		)');
		$this->db->order_by('company', 'desc');
		return $this->db->get()->result_array();
		
		
	}
	function add_supplier( $params ) {
		$this->db->insert( 'vendors', $params );
		$supplier_id = $this->db->insert_id();
	
		return $supplier_id;
	}
	
	function get_project_files( $id ) { 
		$this->db->order_by( 'id', 'desc' );
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'vendor', 'files.relation' => $id ) )->result_array();
	}
	
	function get_vendors_documents($id){
		$this->db->select( '*, vendor_documents.vendor_id as id ' );
		return $this->db->get_where( 'vendor_documents', array( 'vendor_documents.vendor_id' => $id ) )->result_array();
	}


	function get_all_vendors() {
		$this->db->select( '*, vendors.id as id ' );
		$this->db->join('vendors_groups','vendors.groupid = vendors_groups.id','left');
		$this->db->order_by( 'vendors.id', 'desc' );
		return $this->db->get_where( 'vendors', array( '' ) )->result_array();
	}

	function add_warehouse( $params ) {
		
		$this->db->insert( 'warehouses', $params );
		$vendor_id = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['warehouse_series'] ? $appconfig['warehouse_series'] : $vendor_id;
		$vendor_number = $appconfig['warehouse_prefix'].$number;
		$this->db->where('warehouse_id', $vendor_id)->update( 'warehouses', array('warehouse_number' => $vendor_number ) );
		
		return $vendor_id;
	}

	function update_vendors( $id, $params ) {
		$appconfig = get_appconfig();
		$vendor_data = $this->get_vendors($id);
		if($vendor_data['vendor_number']==''){
			$number = $appconfig['vendor_series'] ? $appconfig['vendor_series'] : $id;
			$vendor_number = $appconfig['vendor_prefix'].$number;
			$this->db->where('id',$id)->update('vendors',array('vendor_number'=>$vendor_number));
			if(($appconfig['vendor_series']!='')){
				$vendor_number = $appconfig['vendor_series'];
				$vendor_number = $vendor_number + 1;
				$this->Settings_Model->increment_series('vendor_series',$vendor_number);
			}
		}
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'vendors', $params );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated' ) . ' <a href="vendors/vendor/' . $id . '">' . get_number('vendors',$id,'vendor','vendor') . '</a>' ),
			'staff_id' => $this->session->usr_id
		) );
	}

	function delete_warehouses( $id) {
		
			$response = $this->db->delete( 'warehouses', array( 'warehouse_id' => $id ) );
			
			return true;
		
	}

	function get_vendor_groups() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'vendors_groups', array( '' ) )->result_array();
	}

	function get_groups($staff_id='') {
		$this->db->select('vendors_groups.name as name, COUNT(vendors_groups.name) as y');
		$this->db->join( 'vendors_groups', 'vendors.groupid = vendors_groups.id', 'left' );
		if($staff_id){
			$this->db->where('staff_id', $staff_id);
		}
		$this->db->group_by('vendors_groups.name'); 
		return $this->db->get_where( 'vendors', array( '' ) )->result_array();
	}

	function get_group( $id ) {
		return $this->db->get_where( 'vendors_groups', array( 'id' => $id ) )->row_array();
	}

	function update_group( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'vendors_groups', $params );
	}

	function check_group($id) {
		$data = $this->db->get_where( 'vendors', array( 'groupid' => $id ) )->num_rows();
		return $data;
	}

	function remove_group( $id ) {
		$response = $this->db->delete( 'vendors_groups', array( 'id' => $id ) );
	}

	function get_all_warehouses_by_privileges($staff_id='') {
		$this->db->select( '*, warehouses.warehouse_id as id,staff.staffname ' );
		$this->db->join('staff','staff.id = warehouses.staff_id','left');
		$this->db->order_by('warehouses.warehouse_id', 'desc' );
		if($staff_id) {
			return $this->db->get_where( 'warehouses', array( 'staff_id' => $staff_id ) )->result_array();
		} else {
			return $this->db->get_where( 'warehouses', array( '' ) )->result_array();
		}
	}

	function get_warehouse_by_privileges( $id, $staff_id='' ) {
		$this->db->select( '*, warehouses.warehouse_id as id ' );
		if($staff_id) {
			return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id, 'staff_id' => $staff_id ) )->row_array();
		} else {
			return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id ) )->row_array();
		}
		
	}
	
	function get_vendor_by_licence_Notify(){
		$sql = "SELECT ven.id,ven.company,ven.licence_no FROM vendors as ven where ven.trade_expiry_date !='' AND DATE_SUB(ven.trade_expiry_date,INTERVAL 30 DAY) = CURDATE() AND ven.licence_no !=''  order by ven.id ASC";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
}