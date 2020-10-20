<?php
class Glclasses_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_warehouses( $id ) {
		$this->db->select( '*, warehouses.warehouse_id as id ' );
		return $this->db->get_where( 'warehouses', array( 'warehouses.warehouse_id' => $id ) )->row_array();
	}
	function get_inventory_warehouses( $id ) {
		$this->db->select( '*,inventories.inv_warehouse as id ' );
		return $this->db->get_where( 'inventories', array( 'inventories.inv_warehouse' => $id ) )->row_array();
	}
   function get_duplicate_inventory_record($product_name,$unit_type,$supplier_id,$price,$warehouse){
       
       $this->db->select('*');
       return $this->db->get_where('inventories',array('inventories.product_name' => $product_name,'inventories.inv_unit_type'=>  $unit_type,'inventories.supplier_id'=>$supplier_id,'inventories.cost'=>$price,'inventories.inv_warehouse'=>$warehouse))->row_array();
       
       
   }
   function get_duplicate_customer_inventory_record($product_name,$customer_id,$price,$warehouse){
       
       $this->db->select('*');
       return $this->db->get_where('inventories',array('inventories.product_name' => $product_name,'inventories.customer_id'=>$customer_id,'inventories.cost'=>$price,'inventories.inv_warehouse'=>$warehouse))->row_array();
       
       
   }
	function get_tot_qty($inventory_id){
	    $sql = "SELECT sum(qty) as tot_qty FROM inventory_items WHERE inventory_items.inventory_id = '$inventory_id'";
	    $res = $this->db->query($sql);
	    $result = $res->row_array();
	    return $result;
	    
	}
	function get_inventory_items($id){
	    $this->db->select('*,warehouses.warehouse_name,projects.name,staff.staffname');
	    	$this->db->join('warehouses','warehouses.warehouse_id = inventory_items.to_warehouse','left');
	    		$this->db->join('projects','projects.id = inventory_items.project_id','left');
	    		$this->db->join('staff','staff.id = inventory_items.staff_id','left');
	
	    return $this->db->get_where('inventory_items',array('inventory_items.inventory_id' => $id))->result_array();
	    
	}
	function get_all_classes() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'accounts_classes', array( '' ) )->result_array();
	}
	function get_set_classes( $id ) {
		return $this->db->get_where( 'accounts_classes', array( 'id' => $id ) )->row_array();
	}
	function update_classes( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'accounts_classes', $params );
	}
	function remove_classes( $id ) {
		$response = $this->db->delete( 'accounts_classes', array( 'id' => $id ) );
		
	}
	
	function get_all_acc_groups() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'accounts_groups', array( '' ) )->result_array();
	}
	function get_set_groups( $id ) {
		return $this->db->get_where( 'accounts_groups', array( 'id' => $id ) )->row_array();
	}
	function update_groups( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'accounts_groups', $params );
	}
	function remove_groups( $id ) {
		$response = $this->db->delete( 'accounts_groups', array( 'id' => $id ) );
		
	}
	
	function get_all_glclasses_by_privileges($staff_id='') {
		$this->db->select( '*, glaccounts.account_id as id,staff.staffname,staff.staffavatar,accounts_groups.group_name');
		$this->db->join('staff','staff.id = glaccounts.staff_id','left');
		$this->db->join('accounts_groups','accounts_groups.id = glaccounts.account_type','left');
		
		$this->db->order_by('glaccounts.account_id', 'desc' );
		if($staff_id) {
			return $this->db->get_where( 'glaccounts', array( 'staff_id' => $staff_id ) )->result_array();
		} else {
			return $this->db->get_where( 'glaccounts', array( '' ) )->result_array();
		}
	}

	
}