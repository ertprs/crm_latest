<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Warehouses extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Warehouses_Model');
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
		
	}

	function index() {
		$data[ 'title' ] = lang( 'warehouses' );
		$data[ 'vendors' ] = $this->Warehouses_Model->get_all_vendors();
		
	
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'warehouses/index', $data );
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			
				$warehouse_name = $this->input->post( 'name' );
				
				$hasError = false;
				$data['message'] = '';
				if ($warehouse_name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('warehouse'). ' ' . lang('name') ;
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'created' => date( 'Y-m-d' ),
						'warehouse_name' => $warehouse_name,
						'phone' => $this->input->post( 'phone' ),
						'country_id' => $this->input->post( 'country_id' ),
						'state' => $this->input->post( 'state' ),
						'city' => $this->input->post( 'city' ),
						'post_code' => $this->input->post( 'post_code' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'address' => $this->input->post( 'address' )
						
					);
					$vendors_id = $this->Warehouses_Model->add_warehouse( $params );
					$data['success'] = true;
					$data['message'] = lang('warehouse').' '.lang('createmessage');
					//$data['id'] = $vendors_id;
					
							 
					if($appconfig['warehouse_series']){
						$vendor_number = $appconfig['warehouse_series'];
						$vendor_number = $vendor_number + 1 ;
						$this->Settings_Model->increment_series('warehouse_series',$vendor_number);
					}
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
			echo json_encode($data);
		}
	}

	function warehouse( $id ) {
		
			
			$data[ 'title' ] = lang( 'warehouse' );
			
			
					$data[ 'vendors' ] = $this->Warehouses_Model->get_warehouses( $id );

					//echo "<pre>";
					//print_r($data[ 'documents' ]);
					$this->load->view( 'warehouses/warehouse', $data );
				
			
		 
	}
	
	function add_file( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			if ( isset( $id ) ) {
				if ( isset( $_POST ) ) {
					if (!is_dir('uploads/files/vendors/'.$id)) { 
						mkdir('./uploads/files/vendors/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/vendors/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
					$config['file'] = $new_name;
					$this->load->library( 'upload', $config );
					if (!$this->upload->do_upload('file')) {
						$data['success'] = false;
						$data['message'] = $this->upload->display_errors();
						echo json_encode($data);
					} else {
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/vendors/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params = array( 
								'relation_type' => 'vendor',
								'relation' => $id,
								'file_name' => $image_data[ 'file_name' ],
								'created' => date( " Y.m.d H:i:s " ),
								'is_old' => '0'
							);
							$this->db->insert( 'files', $params );
							
							$data['success'] = true;
							$data['message'] = lang('file').' '.lang('uploadmessage');
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
	
	function delete_liscence_document($id) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			//echo "21312";exit;
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file_doc($id);
				if ($fileData) {
					$response = $this->db->where( 'dc_id', $id )->delete( 'vendor_documents', array( 'dc_id' => $id ) );
					
				if (is_file('./uploads/images/' . $fileData['document_name'])) {
				    		unlink('./uploads/images/' . $fileData['document_name']);
				    	}
			    	if ($response) {
			    		$data['success'] = true;
			    		$data['message'] = lang('file'). ' '.lang('deletemessage');
			    	} else {
			    		$data['success'] = false;
			    		$data['message'] = lang('errormessage');
			    	}
					//$res=$response->row_array();
			    	//echo json_encode($data);
					redirect('vendors/vendor/'.$fileData['vendor_id'].'');
			    }
			} else {
				redirect('vendors');
			}
		} else {
			//echo "adSA";exit;
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			//echo json_encode($data);
			redirect('vendors');
		}
	}
	
	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			//echo "21312";exit;
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file($id);
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'files', array( 'id' => $id ) );
					if ($fileData['is_old'] == '1') {
						if (is_file('./uploads/files/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/' . $fileData['file_name']);
				    	}
					} else {
						if (is_file('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name']);
				    	}
					}
			    	if ($response) {
			    		$data['success'] = true;
			    		$data['message'] = lang('file'). ' '.lang('deletemessage');
			    	} else {
			    		$data['success'] = false;
			    		$data['message'] = lang('errormessage');
			    	}
			    	echo json_encode($data);
			    }
			} else {
				redirect('vendors');
			}
		} else {
			//echo "adSA";exit;
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function download_liscence_document($id){
		
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file_doc( $id );
			if (is_file('./uploads/images/' . $fileData['document_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/images/' . $fileData['document_name']);
		    		force_download($fileData['document_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
				
		}
	}

	function download_file($id) {
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file( $id );
			if ($fileData['is_old'] == '1') {
				if (is_file('./uploads/files/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
			} else {
				if (is_file('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
		    }
				
		}
	}


	function projectfiles( $id ) {
		if (isset($id)) {
			$files = $this->Vendors_Model->get_project_files( $id );
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf') {
					$type = 'pdf';
				}
				if ($ext == 'zip' || $ext == 'rar' || $ext == 'tar') {
					$type = 'archive';
				}
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$display = true;
				} else {
					$display = false;
				}
				if ($ext == 'pdf') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				if ($file['is_old'] == '1') {
					$path = base_url('uploads/files/'.$file['file_name']);
				} else {
					$path = base_url('uploads/files/vendors/'.$id.'/'.$file['file_name']);
				}
				$data[] = array(
					'id' => $file['id'],
					'project_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}


	function groups() {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$data = $this->Vendors_Model->get_groups();
		} else if ($this->Privileges_Model->check_privilege( 'vendors', 'own') ) {
			$data = $this->Vendors_Model->get_groups($this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
		echo json_encode( $data );
	}

	function add_group() {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'vendors_groups', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			$data[ 'group' ] = $this->Vendors_Model->get_group( $id );
			if ( isset( $data[ 'group' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Vendors_Model->update_group( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'delete' ) ) {
			$group = $this->Vendors_Model->get_group( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Vendors_Model->check_group($id) == 0) {
					$this->Vendors_Model->remove_group( $id );
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('group').' '.lang('is_linked').' '.lang('with').' '.lang('vendor').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function get_vendor_groups() {
		$groups = $this->Vendors_Model->get_vendor_groups();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
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

	function get_warehouse( $id ) {
		$vendor = array();
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$vendor = $this->Warehouses_Model->get_warehouse_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'warehouses', 'own') ) {
			$vendor = $this->Warehouses_Model->get_warehouse_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
		if($vendor){
			$data_customerdetail = array(
				'id' => $vendor[ 'warehouse_id' ],
				'created' => $vendor[ 'created' ],
				'staff_id' => $vendor[ 'staff_id' ],
				'name' => $vendor[ 'warehouse_name' ],
				
				'address' => $vendor[ 'address' ],
				'post_code' => $vendor[ 'post_code' ],
				'country_id' => $vendor[ 'country_id' ],
				'state' => $vendor['state'],
				//'state_name' => $state,
				'city' => $vendor[ 'city' ],
				
				'phone' => $vendor[ 'phone' ],
				
				//'country' => $country,
							);
			echo json_encode( $data_customerdetail );	
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('warehouses'));
		}
	}

	function get_warehouses() {
		$vendors = array();
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'all' ) ) {
			$vendors = $this->Warehouses_Model->get_all_warehouses_by_privileges();
		} else if ( $this->Privileges_Model->check_privilege( 'warehouses', 'own' ) ) {
			$vendors = $this->Warehouses_Model->get_all_warehouses_by_privileges($this->session->usr_id);
		}
		
		$data_customers = array();
		foreach ( $vendors as $vendor ) {
			
			
			$data_customers[] = array(
				'id' => $vendor[ 'warehouse_id' ],
				'vendor' => $vendor[ 'warehouse_id' ],
				'address' => $vendor[ 'address' ],
				'name' => $vendor['warehouse_name'],
				'staffname' => $vendor['staffname'],
				'city' => $vendor['city'],
				'phone' => $vendor[ 'phone' ],
				'warehouse_number' => $vendor['warehouse_number'],
			);
		};
		echo json_encode( $data_customers );
	}
}