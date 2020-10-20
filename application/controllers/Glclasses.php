<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Glclasses extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Glclasses_Model');
		
		
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
		
	}

	function index() {
		$data[ 'title' ] = 'Manage Classes';
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['glclasses'] = $this->Glclasses_Model->get_all_classes();
		$data['glgroups'] = $this->Glclasses_Model->get_all_acc_groups();
		$this->load->view( 'glclasses/index', $data );
	}
	function get_classes() {
		$statusarr = $this->Glclasses_Model->get_all_classes();
		$data_categories = array();
		foreach ( $statusarr as $status ) {
			$data_categories[] = array(
				'name' => $status[ 'class_name' ],
				'class_id' => $status[ 'class_id' ],
				'id' => $status[ 'id' ]
			);
		};
		echo json_encode( $data_categories );
	}
	
	function get_groups() {
		$statusarr = $this->Glclasses_Model->get_all_acc_groups();
		$data_categories = array();
		foreach ( $statusarr as $status ) {
			$data_categories[] = array(
				'name' => $status[ 'group_name' ],
				'class_id' => $status[ 'class_id' ],
				'group_id' => $status[ 'group_id' ],
				'subgroup_of' => $status[ 'subgroup_of' ],
				'id' => $status[ 'id' ]
			);
		};
		echo json_encode( $data_categories );
	}


function add_classes() {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$class_id = $this->input->post( 'class_id' );
				
				$hasError = false;
				$data['name'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' ' .lang('class').' ' .lang('name');
				} 
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'class_name' => $name,
						'class_id' => $class_id,
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'created' => date('Y-m-d')
					);
					$this->db->insert( 'accounts_classes', $params );
					$id = $this->db->insert_id();
					if ($id) {
						$data['success'] = true;
						$data['message'] = lang('classes'). ' ' .lang('createmessage');
						echo json_encode($data);
					} else {
						$data['success'] = false;
						$data['message'] = lang('errormessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}


function add_groups() {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$class_id = $this->input->post( 'class_id' );
				$group_id = $this->input->post( 'group_id' );
				$subgroup_of = $this->input->post('subgroup_of');
				
				$hasError = false;
				$data['name'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' ' .lang('group').' ' .lang('name');
				} 
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'group_name' => $name,
						'class_id' => $class_id,
						'group_id' => $group_id,
						'subgroup_of' => $subgroup_of,
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'created' => date('Y-m-d')
					);
					$this->db->insert( 'accounts_groups', $params );
					$id = $this->db->insert_id();
					if ($id) {
						$data['success'] = true;
						$data['message'] = lang('groups'). ' ' .lang('createmessage');
						echo json_encode($data);
					} else {
						$data['success'] = false;
						$data['message'] = lang('errormessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}


function update_classes( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'edit' ) ) {
			$data[ 'status' ] = $this->Glclasses_Model->get_set_classes( $id );
			if ( isset( $data[ 'status' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$name = $this->input->post( 'name' );
					$class_id = $this->input->post( 'class_id' );
					
					$hasError = false;
					$data['name'] = '';
					if ($name == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('name');
					} 
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					}
					if (!$hasError) {
						$params = array(
							
							'class_name' => $name,
							'class_id' => $class_id,
							
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'created' => date('Y-m-d')
						);
						$result=$this->Glclasses_Model->update_classes( $id, $params );
						if ($result) {
							$data['success'] = true;
							$data['message'] = lang('Classes'). ' ' .lang('updatemessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = lang('errormessage');
							echo json_encode($data);
						}
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}
	
	function update_groups( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'edit' ) ) {
			$data[ 'status' ] = $this->Glclasses_Model->get_set_groups( $id );
			if ( isset( $data[ 'status' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$name = $this->input->post( 'name' );
					$class_id = $this->input->post( 'class_id' );
					$group_id = $this->input->post( 'group_id' );
					$subgroup_of = $this->input->post( 'subgroup_of' );
					
					$hasError = false;
					$data['name'] = '';
					if ($name == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('name');
					} 
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					}
					if (!$hasError) {
						$params = array(
							
							'group_name' => $name,
							'class_id' => $class_id,
							'group_id' => $group_id,
							'subgroup_of' => $subgroup_of,
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'created' => date('Y-m-d')
						);
						$result=$this->Glclasses_Model->update_groups( $id, $params );
						if ($result) {
							$data['success'] = true;
							$data['message'] = lang('groups'). ' ' .lang('updatemessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = lang('errormessage');
							echo json_encode($data);
						}
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}
	function remove_classes( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'delete' ) ) {
			
					$this->Glclasses_Model->remove_classes( $id );
					$data['success'] = true;
					$data['message'] = lang('classes'). ' ' .lang('deletemessage');
					echo json_encode($data);
				
			
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}
	function remove_groups( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'delete' ) ) {
			
					$this->Glclasses_Model->remove_groups( $id );
					$data['success'] = true;
					$data['message'] = lang('groups'). ' ' .lang('deletemessage');
					echo json_encode($data);
				
			
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'create' ) ) {
			
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		
				$dashboard = $this->input->post( 'dashboard' );
				$expense = $this->input->post( 'expense' );
				$payments = $this->input->post( 'payments' );
				if($expense == 'on'){
					$expense = 1;
				}else{
					$expense = 0;
					
				}
				
				if($dashboard == 'on'){
					$dashboard = 1;
				}else{
					$dashboard = 0;
				}
				if($payments == 'on'){
					$payments = 1;
				}else{
					$payments = 0;
				}
				 $hasError = false;
				$data['message'] = '';
				
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					 $params = array(
						'created' => date( 'Y-m-d' ),
						'account_type' => $this->input->post('account_type'),
						'account_code' => $this->input->post('account_code'),
						'account_name' => $this->input->post('account_name'),
						'account_desc' => $this->input->post( 'account_desc' ),
						'dashboard' => $dashboard,
						'payments' => $payments,
						'expense' => $expense,
						'staff_id' => $this->session->userdata( 'usr_id' ),
					);
					$account_id = $this->db->insert('glaccounts',$params );
     
					$data['success'] = true;
					$data['message'] = lang('accounts').' '.lang('createmessage');
					
							 
					
					echo json_encode($data);
					redirect(base_url().'glclasses');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
			echo json_encode($data);
		}
	}

function update() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'edit' ) ) {
			
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		
				$inv_id = $this->input->post('inv_id');
				 $hasError = false;
			
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					
								    
					$params = array(
						'created' => date( 'Y-m-d' ),
					
						'cost' => $this->input->post( 'cost' ),
					
						'inv_warehouse' => $this->input->post( 'inv_warehouse' ),
						
						'stock' => $this->input->post( 'stock'),
						
						'inv_move_type' => $this->input->post( 'inv_move_type' ),
						
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'notes' => $this->input->post( 'notes' ),
					);
					$vendors_id = $this->Inventories_Model->update_inventory( $inv_id,$params );
					$data['success'] = true;
					$data['message'] = lang('inventory').' '.lang('updatemessage');
					//$data['id'] = $vendors_id;
					
					
					echo json_encode($data);
					redirect(base_url().'inventories/invview/'.$inv_id.'');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
			echo json_encode($data);
		}
	}
	
	
function view_details($id)
	{
		$data['inv_id'] = $id;
		$data['projects']= $this->Projects_Model->get_all_projects();
		$data[ 'warehouses'] = $this->Inventories_Model->get_warehouses_all();
		$data['result'] = $this->Inventories_Model->get_inventory_record($id);
		
		$this->load->view('inventories/view_details',$data);
		
	
	}
	
	


		function delete_inventory(){

		$inventory_id = $this->input->post('id');
		$data['deleteinv'] = $this->Inventories_Model->delete_inventory($inventory_id);

	         echo json_encode($data);
	//	redirect(base_url('material'));

	}
	
	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$vendor = $this->Warehouses_Model->get_warehouse_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'warehouses', 'own') ) {
			$vendor = $this->Warehouses_Model->get_warehouse_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($vendor) {
			if ( $this->Privileges_Model->check_privilege( 'warehouses', 'delete' ) ) {
				if ( isset( $vendor[ 'id' ] ) ) {
					$this->Warehouses_Model->delete_warehouses( $id );
					$data['success'] = true;
					$data['message'] = lang('warehouse').' '.lang('deletemessage');
					echo json_encode($data);
				} else {
					show_error( 'warehouse not deleted' );	
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
	}

	function get_inventories() {
		$vendors = array();
		if ( $this->Privileges_Model->check_privilege( 'glclasses', 'all' ) ) {
			$vendors = $this->Glclasses_Model->get_all_glclasses_by_privileges();
		} else if ( $this->Privileges_Model->check_privilege( 'glclasses', 'own' ) ) {
			$vendors = $this->Glclasses_Model->get_all_glclasses_by_privileges($this->session->usr_id);
		}
		
		$data_customers = array();
		foreach ( $vendors as $vendor ) {
			
	
			$data_customers[] = array(
				'id' => $vendor[ 'id' ],
				'group_name' => $vendor['group_name'],
				'account_code' => $vendor['account_code'],
				'staffavatar' => $vendor['staffavatar'],
				'account_name' => $vendor['account_name'],
				'account_desc' => $vendor['account_desc'],
				
			);
		};
		echo json_encode( $data_customers );
	}
		
	
	function invview($id)
	{
		
		$data[ 'warehouses'] = $this->Inventories_Model->get_warehouses_all();
		
		$data['product_types'] = $this->Inventories_Model->get_product_type();
		$data['move_types'] = $this->Inventories_Model->get_move_type();
		$data['product_categories'] = $this->Inventories_Model->get_product_categories();
			$data[ 'unittypes' ] = $this->Settings_Model->get_mat_unittype();
		$result=$this->Inventories_Model->get_inventory_record($id);
		//print_r($result);
		$itemresult = $this->Inventories_Model->get_inventory_items($id);
		
		$tot_qty = $this->Inventories_Model->get_tot_qty($id);
		$data['result']=$result;
		$data['itemresult'] = $itemresult;
		$data['tot_qty'] = $tot_qty['tot_qty'];
		$this->load->view('inc/header', $data);
		$this->load->view('inventories/invview',$data);
		
	}
}