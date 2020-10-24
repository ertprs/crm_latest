<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Inventories extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Warehouses_Model');
		$this->load->model('Inventories_Model');
			$this->load->model('Vendors_Model');
		
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
		
	}

	function index() {
		$data[ 'title' ] = lang( 'inventories' );
		//$data[ 'vendors' ] = $this->Warehouses_Model->get_all_vendors();
		
	
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'warehouses'] = $this->Inventories_Model->get_warehouses_all();
		
		$data['product_types'] = $this->Inventories_Model->get_product_type();
		$data['move_types'] = $this->Inventories_Model->get_move_type();
		$data['product_categories'] = $this->Inventories_Model->get_product_categories();
		$data['material_categories'] = $this->Inventories_Model->get_material_categories();
			$data[ 'unittypes' ] = $this->Settings_Model->get_mat_unittype();
		//print_r($data['warehouses']); die;
		$this->load->view( 'inventories/index', $data );
	}
	function get_status() {
		$statusarr = $this->Inventories_Model->get_all_Status();
		$data_categories = array();
		foreach ( $statusarr as $status ) {
			$data_categories[] = array(
				'name' => $status[ 'warehouse_name' ],
				'city' => $status[ 'city' ],
				'id' => $status[ 'warehouse_id' ],
				'country_id' => $status[ 'country_id' ],
				'state_id' => $status[ 'state']
			);
		};
		echo json_encode( $data_categories );
	}

function add_status() {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$country_id = $this->input->post( 'country_id' );
				$state_id = $this->input->post( 'state_id' );
				$city =  $this->input->post('city');

				$hasError = false;
				$data['name'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' ' .lang('warehouse').' ' .lang('name');
				} 
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'warehouse_name' => $name,
						'country_id' => $country_id,
						'state' => $state_id,
						'city' => $city,
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'created' => date('Y-m-d')
					);
					$this->db->insert( 'warehouses', $params );
					$id = $this->db->insert_id();
					if ($id) {
						$data['success'] = true;
						$data['message'] = lang('warehouse'). ' ' .lang('createmessage');
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

function update_status( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'edit' ) ) {
			$data[ 'status' ] = $this->Inventories_Model->get_set_status( $id );
			if ( isset( $data[ 'status' ][ 'warehouse_id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$name = $this->input->post( 'name' );
					$country_id = $this->input->post( 'country_id' );
					$state_id = $this->input->post('state_id');
					$city = $this->input->post( 'city' );
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
							
							'warehouse_name' => $name,
							'country_id' => $country_id,
							'state' => $state_id,
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'created' => date('Y-m-d')
						);
						$result=$this->Inventories_Model->update_status( $id, $params );
						if ($result) {
							$data['success'] = true;
							$data['message'] = lang('warehouse'). ' ' .lang('updatemessage');
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
	function remove_status( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'warehouses', 'delete' ) ) {
			$status = $this->Inventories_Model->get_set_status( $id );
			if ( isset( $status[ 'warehouse_id' ] ) ) { 
			$res = $this->Inventories_Model->get_inventory_warehouses($id);
			//print_r($res); die;
				if ($res['id'] == '') {
					$this->Inventories_Model->remove_status( $id );
					$data['success'] = true;
					$data['message'] = lang('warehouse'). ' ' .lang('deletemessage');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('warehouse').' '.lang('is_linked').' '.lang('with').' '.lang('inventory').', '.lang('so').' '.lang('cannot_delete').' '.lang('warehouse');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'create' ) ) {
			
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
	//	echo '<pre>'; print_r($_POST); die;
				//$warehouse_name = $this->input->post( 'name' );
				
				 $hasError = false;
				$data['message'] = '';
				/* if ($warehouse_name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('warehouse'). ' ' . lang('name') ;
				} */
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					 $supplier_id = $this->input->post('supplier_id');
						$customer_id = $this->input->post('customer_id');
					   	$pname = $this->input->post('product_name');
					   	$pnames = $this->input->post('product_names');
					   	if($pname != ''){
					   	    
					   	    $product_name = $pname;
					   	}else{
					   	     $product_name = $pnames;
					   	    
					   	}
					   	$unit_type = $this->input->post('inv_unit_type');
					   	$price =$this->input->post('cost');
					   	$warehouse = $this->input->post('inv_warehouse');
					   	$stock = $this->input->post( 'stock');
					   	$category = $this->input->post('category');
					   	if($category == '1'){
				$wh_result = 	$this->Inventories_Model->get_duplicate_inventory_record($product_name,$unit_type,$supplier_id,$price,$warehouse);
					   	}
					   	else{
					   	    
					   	    $wh_result = 	$this->Inventories_Model->get_duplicate_customer_inventory_record( $product_name,$customer_id,$price,$warehouse);
					   	}
     
     if(!empty($wh_result)){
         $tot_stock = $wh_result['stock']+$stock;
         $param = array('stock'=>$tot_stock);
         	$vendors_id = $this->Inventories_Model->update_inventory( $wh_result['inv_id'],$param);
         
     }else{
					if($supplier_id !='-1'){
										
								        $supplier_id = $supplier_id ;
								    }
								    else{
										
								        	$spparams = array(
						                    'created' => date( 'Y-m-d' ),
											'staff_id' => $this->session->userdata( 'usr_id' ),
											
						                    'company' => $this->input->post('supp_id'));
											
								         $supplier_id = $this->Vendors_Model->add_supplier( $spparams );
			
							 	        
								    }
						$customer_id = $this->input->post('customer_id');
						if($customer_id != '-1'){
						    $customer_id = $customer_id;
						} 
						
						 else{
										
								        	$cpparams = array(
						                    'created' => date( 'Y-m-d' ),
											'staff_id' => $this->session->userdata( 'usr_id' ),
											
						                    'company' => $this->input->post('cust_id'));
											
								         $customer_id = $this->Vendors_Model->add_customer( $cpparams );
			
							 	        
								    }
					$params = array(
						'created' => date( 'Y-m-d' ),
						'product_name' => $product_name,
						'service_name' => $this->input->post('service_name'),
						'category' => $this->input->post('category'),
						//'product_category' => $this->input->post( 'product_category' ),
						//'inv_product_category' => $this->input->post( 'inv_product_category'),
						//'product_type' => $this->input->post( 'product_type' ),
						//'inv_product_type' => $this->input->post( 'inv_product_type' ),
						'cost' => $this->input->post( 'cost' ),
						//'warehouse' => $this->input->post( 'warehouse' ),
						'inv_warehouse' => $this->input->post( 'inv_warehouse' ),
						'inv_unit_type' => $this->input->post('inv_unit_type'),
						'supplier_id' => $supplier_id,
						'customer_id' => $customer_id,
						'stock' => $this->input->post( 'stock'),
						//'move_type' => $this->input->post( 'move_type' ),
						'inv_move_type' => $this->input->post( 'inv_move_type' ),
						
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'notes' => $this->input->post('notes'),
					);
					$vendors_id = $this->Inventories_Model->add_inventories( $params );
     }
					$data['success'] = true;
					$data['message'] = lang('inventory').' '.lang('createmessage');
					//$data['id'] = $vendors_id;
					
							 
					if($appconfig['inventory_series']){
						$vendor_number = $appconfig['inventory_series'];
						$vendor_number = $vendor_number + 1 ;
						$this->Settings_Model->increment_series('inventory_series',$vendor_number);
					}
					echo json_encode($data);
					redirect(base_url().'inventories');
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
	
	function transfer() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'edit' ) ) {
			
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		
				$inv_id = $this->input->post('inventory_id');
				$qty = $this->input->post('qty');
				$project_id = $this->input->post('project_id');
				$warehouse_id = $this->input->post('warehouse_id');
				$project_type = $this->input->post('project');
				$staff_id = $this->session->userdata( 'usr_id' );
				if($project_id == ''){
					$project_id = 0;
				}else{
					$project_id = $project_id;
				}
				if($warehouse_id == ''){
					$warehouse_id = 0;
				}
				else{
					$warehouse_id = $warehouse_id;
				}
				 $hasError = false;
			
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					
								    
					$params = array(
					    
					    'inventory_id' => $inv_id,
						'project_type' => $project_type,
					
						'project_id' => $project_id,
					
						'to_warehouse' => $warehouse_id,
						
						'qty' => $qty,
						
						'staff_id' => $staff_id
						
					);
					$vendors_id = $this->db->insert('inventory_items',$params );
					if($project_type == 'warehouse'){
					    	$result = $this->Inventories_Model->get_inventory_record($inv_id);
					    	if($result['category'] == '1'){
					    		$wh_result = 	$this->Inventories_Model->get_duplicate_inventory_record( $result['product_name'],$result['inv_unit_type'],$result['supplier_id'],$result['cost'],$warehouse_id);
					    	}else{
					    	  $wh_result = 	$this->Inventories_Model->get_duplicate_customer_inventory_record( $result['product_name'],$result['customer_id'],$result['cost'],$warehouse_id);
					    	}
					    		if(!empty($wh_result)){
					    		      $tot_stock = $wh_result['stock']+$qty;
         $param = array('stock'=>$tot_stock);
         	$vendors_id = $this->Inventories_Model->update_inventory( $wh_result['inv_id'],$param);
					    		    
					    		}else{
     
						$params = array(
						'created' => date( 'Y-m-d' ),
						'product_name' => $result['product_name'],
						'service_name' => $result['service_name'],
						'category' => $result['category'],
						
						'cost' => $result['cost'],
					
						'inv_warehouse' => $warehouse_id,
						'inv_unit_type' => $result['inv_unit_type'],
						'supplier_id' => $result['supplier_id'],
						'customer_id' => $result['customer_id'],
						'stock' => $qty,
						'inv_move_type' => '5',
						
						'staff_id' => $this->session->userdata( 'usr_id' ),
					);
					$vendors_id = $this->Inventories_Model->add_inventories( $params );
						if($appconfig['inventory_series']){
						$vendor_number = $appconfig['inventory_series'];
						$vendor_number = $vendor_number + 1 ;
						$this->Settings_Model->increment_series('inventory_series',$vendor_number);
						}
					}
					}
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




		function delete_inventory(){

		$inventory_id = $this->input->post('id');
		$data['deleteinv'] = $this->Inventories_Model->delete_inventory($inventory_id);

	         echo json_encode($data);
	//	redirect(base_url('material'));

	}
	function get_material_cat(){
	    $material_id = $this->input->post('material_id');
	    $code = $this->Inventories_Model->get_cost_value($material_id);
	    $data['cost'] = $code['cost'];
		$data['category'] = $code['category'];
		$data['unittype'] = $code['unittype'];
	 
	    echo json_encode($data);
	    
	}
	function get_material_cost_values(){
	    $material_id = $this->input->post('material_id');
	     $supplier_id = $this->input->post('supplier_id');
	    $costs = $this->Inventories_Model->get_material_prices($material_id,$supplier_id);
	   echo ' <div class="form-group"><label>Cost Price
	<input list="costs" name="cost" class="form-control" style="border-radius:0px" autocomplete="off" size="50"/></label>';
echo '<datalist id="costs">';
  foreach($costs as $cost){ 
  echo '<option value="'.$cost[vendor_price].'">';
  }
echo '</datalist>
			
				</div>';
	 
	  
	    
	}
	
	function get_material_suppliers(){
	    $material_id = $this->input->post('material_id');
	   
	    $costs = $this->Inventories_Model->get_material_suppliers($material_id);
	   
	   echo ' <div class="form-group"><label>Suppliers
	</label>';
echo '<select class="form-control" name="supplier_id" id="supplier_id" style="border-radius:0px" onchange="get_cost('.$material_id.')">';
echo '<option value=""></option>';
echo '<option value="0">Select New Supplier</option>';
  foreach($costs as $cost){ 
  echo '<option value="'.$cost[id].'">'.$cost[company].'</option>';
  }
echo '</select>
			
				</div>';
	 
	  
	    
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

	function add_product_category() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'inventory_product_categories', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('unit').' '.lang('type'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	function add_product_type() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'inventory_product_type', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('product').' '.lang('type'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function add_move_type() {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'inventory_move_type', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('move').' '.lang('type'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}


	function update_product_category( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'edit' ) ) {
			$data[ 'name' ] = $this->Inventories_Model->get_inv_product_categories( $id );
			if ( isset( $data[ 'name' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Inventories_Model->update_product_category( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('unit').' '.lang('type'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	function update_move_type( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'edit' ) ) {
			$data[ 'name' ] = $this->Inventories_Model->get_inv_move_type( $id );
			if ( isset( $data[ 'name' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Inventories_Model->update_move_type( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('move').' '.lang('type'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_product_category( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'delete' ) ) {
			$group = $this->Inventories_Model->get_inv_product_categories( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Inventories_Model->check_product_category($id) == 0) {
					$this->Inventories_Model->remove_product_category( $id );
					$data['success'] = true;
					$data['message'] = lang('unit').' '.lang('type'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('unit').' '.lang('type').' '.lang('is_linked').' '.lang('with').' '.lang('inventory').', '.lang('so').' '.lang('cannot_delete').' '.lang('unit');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	function remove_product_type( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'delete' ) ) {
			$group = $this->Inventories_Model->get_inv_product_type( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Inventories_Model->check_product_type($id) == 0) {
					$this->Inventories_Model->remove_product_type( $id );
					$data['success'] = true;
					$data['message'] = lang('product').' '.lang('type'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('type').' '.lang('is_linked').' '.lang('with').' '.lang('inventory').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
function remove_move_type( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'delete' ) ) {
			$group = $this->Inventories_Model->get_inv_move_type( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Inventories_Model->check_move_type($id) == 0) {
					$this->Inventories_Model->remove_move_type( $id );
					$data['success'] = true;
					$data['message'] = lang('move').' '.lang('type'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('move').' '.lang('type').' '.lang('is_linked').' '.lang('with').' '.lang('inventory').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}


	function get_product_categories() {
		$groups = $this->Inventories_Model->get_product_categories();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}
	function get_product_type() {
		$groups = $this->Inventories_Model->get_product_type();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}

    function get_move_type() {
		$groups = $this->Inventories_Model->get_move_type();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}
	
	
	function get_all_material()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_materials_keyword($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["material_id"], 
            'name' => $row["itemname"].'<br>'.$row["itemdescription"],'description' => $row["itemdescription"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	function get_all_vendors()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_vendor_keyword($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["id"], 
            'name' => $row["company"],'description' => $row["company"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
		function get_all_customers()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_customer_keyword($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$customerResult[]= array('id' => $row["id"], 
            'name' => $row["company"],'description' => $row["company"]);
			}
			echo json_encode($customerResult);
		}else{
			echo '0';
		}
	}
	function get_all_inv_product_categories()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_all_inv_product_categories($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["id"], 
            'name' => $row["name"],'description' => $row["name"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	
	function get_all_inv_product_types()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_all_inv_product_types($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["id"], 
            'name' => $row["name"],'description' => $row["name"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	
	function get_all_inv_warehouses()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_all_inv_warehouses($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["warehouse_id"], 
            'name' => $row["warehouse_name"],'description' => $row["warehouse_name"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	function get_all_inv_move_types()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Inventories_Model->get_all_inv_move_types($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["id"], 
            'name' => $row["name"],'description' => $row["name"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
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

	function get_inventories() {
		$vendors = array();
		if ( $this->Privileges_Model->check_privilege( 'inventories', 'all' ) ) {
			$vendors = $this->Inventories_Model->get_all_inventories_by_privileges();
		} else if ( $this->Privileges_Model->check_privilege( 'inventories', 'own' ) ) {
			$vendors = $this->Inventories_Model->get_all_inventories_by_privileges($this->session->usr_id);
		}
		
		$data_customers = array();
		$client_name = '';
		foreach ( $vendors as $vendor ) {
			if($vendor['supplier_id'] != 0){
				
				$supp_res = $this->Inventories_Model->get_supp_name($vendor['supplier_id']);
				$client_name = $supp_res['company'];
			}
			else if($vendor['customer_id'] != 0){
				
				$cust_res = $this->Inventories_Model->get_cust_name($vendor['customer_id']);
				$client_name = $cust_res['company'];
			}
			if($vendor['service_name'] == 0){
				$product_cat = $this->Inventories_Model->get_inv_product_categories($vendor['inv_product_category']);
				$product_category_name = $product_cat['name'];
			}
			else{
				$mat_cat = $this->Inventories_Model->get_material_category_name($vendor['inv_product_category']);
				$product_category_name = $mat_cat['mat_cat_name'];
			}
			
			
				$totqty = $this->Inventories_Model->get_tot_qty($vendor[ 'id' ]);
			$tot =	$totqty['tot_qty'];
				if($tot == 'null'){
				    
				    $tot = 0;
				}else{
				    
				    $tot = $tot;
				}
				
				$qty = $vendor['stock']-$tot;
			$data_customers[] = array(
				'id' => $vendor[ 'id' ],
				'inventory_number' => $vendor['inventory_number'],
				'move_type' => $vendor['move_type_name'],
				'product_type' => $vendor['product_type'],
				'product_category' => $product_category_name,
				'product_name' => $vendor['product_name'],
				'staffavatar' => $vendor['staffavatar'],
				'cost' => $vendor['cost'],
				'stock' =>  $qty,
				'warehouse' => $vendor['warehouse_name'],
				'staffname' => $vendor['staffname'],
				'client_name' => $client_name,
				
				
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