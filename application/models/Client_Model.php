<?php
class Client_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_customers( $id ) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
	}
	
	function get_supplier_id( $id ) {
		$this->db->select( '*' );

		return $this->db->get_where( 'supplier', array( 'supplier.supplier_id' => $id ) )->row_array();
	}


	function get_all_supplier($staff_id='') {
		$this->db->select( '*,supplier_id as id' );
	
		if($staff_id) {
			return $this->db->get_where( 'supplier', array( 'supplier_id' => $staff_id) )->result_array();
		} else {
			return $this->db->get_where( 'supplier', array( '' ) )->result_array();	
		}
	}

	function get_subsidiaries($id) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->order_by( 'customers.id', 'desc' );
		return $this->db->get_where( 'customers', array( 'customers.subsidiary_parent_id' => $id ) )->result_array();
	}
	
	function add_client( $params ) {
		$this->db->insert( 'client', $params );
		$supplier_id = $this->db->insert_id();
	
		return $supplier_id;
	}
	function add_client_contact( $params ) {
		$this->db->insert( 'client_contact', $params );
	
		
	}
	
	function update_contact_privilege( $id, $value, $privilege_id ) {
		if ( $value != 'false' ) {
			$params = array(
				'relation' => ( int )$id,
				'relation_type' => 'contact',
				'permission_id' => ( int )$privilege_id
			);
			$this->db->insert( 'privileges', $params );
			return $this->db->insert_id();
		} else {
			$response = $this->db->delete( 'privileges', array( 'relation' => $id, 'relation_type' => 'contact', 'permission_id' => $privilege_id ) );
		}
	}

	function get_customers_for_import() {     
        $query = $this->db->get('customers');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
	}
	
	function get_customer_groups() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'customergroups', array( '' ) )->result_array();
	}

	function get_groups($staff_id='') {
		$this->db->select('customergroups.name as name, COUNT(customergroups.name) as y');
		$this->db->join( 'customergroups', 'customers.groupid = customergroups.id', 'left' );
		if($staff_id){
			$this->db->where('staff_id', $staff_id);
		}
		$this->db->group_by('customergroups.name'); 
		return $this->db->get_where( 'customers', array( '' ) )->result_array();
	}

	function get_group( $id ) {
		return $this->db->get_where( 'customergroups', array( 'id' => $id ) )->row_array();
	}

	function update_group( $id, $params ) {
		$this->db->where( 'id', $id );
		return $this->db->update( 'customergroups', $params );
	}

	function check_group($id) {
		$data = $this->db->get_where( 'customers', array( 'groupid' => $id ) )->num_rows();
		return $data;
	}

	function remove_group( $id ) {
		$response = $this->db->delete( 'customergroups', array( 'id' => $id ) );
	}

    function insert_customers_csv($data) {
		$this->db->insert('customers', $data);
		$customer = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['customer_series'] ? $appconfig['customer_series'] : $customer;
		$customer_number = $appconfig['customer_prefix'].$number;
		$this->db->where('id', $customer)->update( 'customers', array('customer_number' => $customer_number ) );
    }

	function update_supplier( $id, $params ) {
		$appconfig = get_appconfig();
		
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'supplier', $params );
		
	}

	function delete_customers( $id, $number ) {
		$invoice = $this->db->get_where('invoices', array('customer_id' => $id))->num_rows();
		$proposal = $this->db->get_where('proposals', array('relation_type' => 'customer', 'relation' => $id))->num_rows();
		$expense = $this->db->get_where('expenses', array('customer_id' => $id))->num_rows();
		$project = $this->db->get_where('projects', array('customer_id' => $id))->num_rows();
		$ticket = $this->db->get_where('tickets', array('customer_id' => $id))->num_rows();
		$deposit = $this->db->get_where('deposits', array('customer_id' => $id))->num_rows();
		$order = $this->db->get_where('orders', array('relation_type' => 'customer', 'relation' => $id))->num_rows();
		if (($invoice > 0) || ($proposal > 0) || ($expense > 0) || ($project > 0) || ($ticket > 0) || ($deposit > 0) || ($order > 0)) {
			return false;
		} else {
			$response = $this->db->delete( 'customers', array( 'id' => $id ) );
			$response = $this->db->delete( 'contacts', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'logs', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'notifications', array( 'customer_id' => $id ) );
			$response = $this->db->delete( 'reminders', array( 'relation_type' => 'customer', 'relation' => $id ) );
			$response = $this->db->delete( 'notes', array( 'relation_type' => 'customer', 'relation' => $id ) );
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' '. $number . '' ),
				'staff_id' => $this->session->usr_id
			) );
			return true;
		}
	}

	function search_json_customer() {
		$this->db->select( 'id customer,type customertype,company company,namesurname individual,' );
		$this->db->from( 'customers' );
		return $this->db->get()->result();
	}

	function get_customers_by_privileges( $id, $staff_id='' ) {
		$this->db->select( '*, customers.id as id ' );
		$this->db->join('customergroups','customers.groupid = customergroups.id','left');
		if($staff_id) {
			return $this->db->get_where( 'customers', array( 'customers.id' => $id, 'staff_id' => $staff_id ) )->row_array();
		} else {
			return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
		}
		
	}

	function search_customers($q) {
		$this->db->select( '*' );
		$this->db->from('customers');
		$this->db->where('(
			email LIKE "%' . $q . '%"
			OR company LIKE "%' . $q . '%"
			OR namesurname LIKE "%' . $q . '%"
		)');
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result_array();
	}
}
