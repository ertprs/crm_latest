<?php

defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Customers extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'customers' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['payment'] = $this->Settings_Model->get_payment_gateway_data();
		$saleswise1=$this->Staff_Model->get_staff_department_wise('16');
		$saleswise2=$this->Staff_Model->get_staff_department_wise('9');
		$adminwise=$this->Staff_Model->get_staff_department_wise('11');
		 $data['saleswise']=array_merge($adminwise,$saleswise1,$saleswise2);
		
		$this->load->view( 'customers/index', $data );
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$company = $this->input->post( 'company' );
				$namesurname = $this->input->post( 'namesurname' );
				$email = $this->input->post( 'email' );
				$default_payment_method = $this->input->post( 'default_payment_method' );
				$group = $this->input->post('groupid');
				$sales=$this->input->post( 'sales_team' );
				$is_individual=$this->input->post( 'is_individual' );
				$mainsalesperson=$this->input->post( 'main_sales_person' );
				if ( $this->input->post('type') == 'true' ) {
					$type = 1;
					$company = '';
				} else {
					$type = 0;
					$namesurname = '';
				}
				$hasError = false;
				$data['message'] = '';
				if ($company == '' && $type == 0) {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('company');
				} else if ($namesurname == '' && $type == 1) {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('customer'). ' ' .lang('name');
				} else if ($email == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('Contact Person (Accounts)'). ' ' .lang('email');
				} else if ($this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) )) {
					$hasError = true;
					$data['message'] = lang('contact').' '.lang('email_exist');
				} else if ($group == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('customer'). ' ' .lang('group');
				} else if($mainsalesperson == ''){
					$hasError = true;
					$data['message'] = 'Please Select Sales Manager';
				}else if($is_individual == 'true'){
					if($sales == ''){
						$hasError = true;
						$data['message'] = 'Please Select Sales Team';
					}
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'type' => $type,
						'company' => $company,
						'namesurname' => $namesurname,
						'ssn' => $this->input->post( 'ssn' ),
						'executive' => $this->input->post( 'executive' ),
						'address' => $this->input->post( 'address' ),
						'phone' => $this->input->post( 'phone' ),
						'email' => $this->input->post( 'email' ),
						'fax' => $this->input->post( 'fax' ),
						'web' => $this->input->post( 'web' ),
						'taxoffice' => $this->input->post( 'taxoffice' ),
						'taxnumber' => $this->input->post( 'taxnumber' ),
						'country_id' => $this->input->post( 'country_id' ),
						'state_id' => $this->input->post( 'state_id' ),
						'city' => $this->input->post( 'city' ),
						'town' => $this->input->post( 'town' ),
						'zipcode' => $this->input->post( 'zipcode' ),
						'billing_street' => $this->input->post( 'billing_street' ),
						'billing_city' => $this->input->post( 'billing_city' ),
						'billing_state_id' => $this->input->post( 'billing_state_id' ),
						'billing_zip' => $this->input->post( 'billing_zip' ),
						'billing_country' => $this->input->post( 'billing_country' ),
						'shipping_street' => $this->input->post( 'shipping_street' ),
						'shipping_city' => $this->input->post( 'shipping_city' ),
						'shipping_state_id' => $this->input->post( 'shipping_state_id' ),
						'shipping_zip' => $this->input->post( 'shipping_zip' ),
						'shipping_country' => $this->input->post( 'shipping_country' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'default_payment_method' => $this->input->post('default_payment_method'),
						'groupid' => $this->input->post('groupid'),
						'customer_status' => '',
						'main_sales_person' => $this->input->post( 'main_sales_person' ),
						'is_individual'=>($is_individual == 'true' ? '1' : '0'),
						'sales_team' =>($is_individual == 'true' ? implode(',',$this->input->post( 'sales_team' )) :''),
						'company_address' => $this->input->post( 'company_address' ),
						'contact_number_office' => $this->input->post( 'contact_number_office' ),
						'account_contact_number' => $this->input->post( 'account_contact_number' ),
						'licence_no' => $this->input->post( 'licence_no' ),
						'trade_expiry_date' => $this->input->post( 'trade_expiry_date' ),
						'creditperiod' => $this->input->post( 'creditperiod' ),
						'creditlimit' => $this->input->post('creditlimit'),
						'terms_and_conditions' => $this->input->post('terms_and_conditions'),
						'notes' => $this->input->post('notes'),
						
					);
			
					$customers_id = $this->Customers_Model->add_customers( $params );
					
					$allfiles=explode(',',$this->input->post('img_name'));
					foreach($allfiles as $eachFiles){
						if($eachFiles!=''){
						$params1 = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'trade_document' => $eachFiles,
						'cust_id' => $customers_id
						);
						$this->db->insert( 'customer_document', $params1 );
						}
					}

					$template = $this->Emails_Model->get_template('customer', 'new_customer');
					if ($template['status'] == 1) {
						$admins = $this->Staff_Model->get_all_admins(); 
						if($this->input->post( 'namesurname' )) {
							$name = $this->input->post( 'namesurname' );
							$type = lang('individual');
						} else {
							$name = $this->input->post( 'company' );
							$type = lang('company');
						}
						$message_vars = array(
							'{customer_type}' => $type,
							'{name}' => $name,
							'{customer_email}' => $this->input->post( 'email' ),
						);												$email = $this->input->post( 'email' );			$clean = $this->security->xss_clean( $email );		
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $admins['email'],
							'subject' => $subject,
							'message' => $message,
						);
						if ($param['email']) {
							$this->db->insert( 'email_queue', $param );
						}												$this->load->library('mail');						//echo $message;exit;						$this->mail->send_email($clean, $template['from_name'], $subject, $message);
					}
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'customer', $customers_id );
					}
					$data['success'] = true;
					$data['id'] = $customers_id;
					$data['message'] = lang('customer').' '.lang('createmessage');
					if($appconfig['customer_series']){
						$customer_number = $appconfig['customer_series'];
						$customer_number = $customer_number + 1 ;
						$this->Settings_Model->increment_series('customer_series',$customer_number);
					}
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function groups() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$data = $this->Customers_Model->get_groups();
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$data = $this->Customers_Model->get_groups($this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		echo json_encode( $data );
	}

	function add_group() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'customergroups', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$data[ 'group' ] = $this->Customers_Model->get_group( $id );
			if ( isset( $data[ 'group' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Customers_Model->update_group( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'delete' ) ) {
			$group = $this->Customers_Model->get_group( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Customers_Model->check_group($id) == 0) {
					$this->Customers_Model->remove_group( $id );
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('deletemessage');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('group').' '.lang('is_linked').' '.lang('with').' '.lang('customer').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function get_customer_groups() {
		$groups = $this->Customers_Model->get_customer_groups();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}

	function customer( $id ) {
		$data['payment'] = $this->Settings_Model->get_payment_gateway_data();
		$data[ 'title' ] = lang( 'customer' ).' '.get_number('customers', $id, 'customer', 'customer');
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		if($customer) {
			$data[ 'ycr' ] = $this->Report_Model->ycr();
			if ( isset( $customer[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
						$company = $this->input->post( 'company' );
						$namesurname = $this->input->post( 'namesurname' );
						$email = $this->input->post( 'email' );
						$is_individual = $this->input->post( 'is_individual' );
						$main_sales_person = $this->input->post( 'main_sales_person' );
						$sales_team = $this->input->post( 'sales_team' );
						$default_payment_method = $this->input->post( 'default_payment_method' );
						if ( $this->input->post('type') == 'true' ) {
							$type = 1;
							$company = '';
						} else {
							$type = 0;
							$namesurname = '';
						}
						$hasError = false;
						$data['message'] = '';
						if ($company == '' && $type == 0) {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('company');
						} else if ($main_sales_person == '') {
							$hasError = true;
							$data['message'] = 'Please Select Sales Manager';
						}else if($is_individual == 'true'){
							if($sales_team == ''){
								$hasError = true;
								$data['message'] = 'Please Select Sales Team';
							}
						}else if ($namesurname == '' && $type == 1) {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('customer'). ' ' .lang('name');
						}
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						}
						if (!$hasError) {
							$params = array(
								'company' => $company,
								'type' => $type,
								'namesurname' => $namesurname,
								'groupid' => $this->input->post( 'group_id' ),
								'ssn' => $this->input->post( 'ssn' ),
								'executive' => $this->input->post( 'executive' ),
								'address' => $this->input->post( 'address' ),
								'phone' => $this->input->post( 'phone' ),
								//'email' => $this->input->post( 'email' ),
								'email'=> $this->input->post( 'email' ),
								'fax' => $this->input->post( 'fax' ),
								'web' => $this->input->post( 'web' ),
								'taxoffice' => $this->input->post( 'taxoffice' ),
								'taxnumber' => $this->input->post( 'taxnumber' ),
								'country_id' => $this->input->post( 'country_id' ),
								'state_id' => $this->input->post( 'state_id' ),
								'city' => $this->input->post( 'city' ),
								'town' => $this->input->post( 'town' ),
								'zipcode' => $this->input->post( 'zipcode' ),
								'billing_street' => $this->input->post( 'billing_street' ),
								'billing_city' => $this->input->post( 'billing_city' ),
								'billing_state_id' => $this->input->post( 'billing_state_id' ),
								'billing_zip' => $this->input->post( 'billing_zip' ),
								'billing_country' => $this->input->post( 'billing_country' ),
								'shipping_street' => $this->input->post( 'shipping_street' ),
								'shipping_city' => $this->input->post( 'shipping_city' ),
								'shipping_state_id' => $this->input->post( 'shipping_state_id' ),
								'shipping_zip' => $this->input->post( 'shipping_zip' ),
								'shipping_country' => $this->input->post( 'shipping_country' ),
								'staff_id' => $this->session->userdata( 'usr_id' ),
								'risk' => $this->input->post( 'risk' ),
								'customer_status_id' => $this->input->post( 'status_id' ),
								'default_payment_method' => $this->input->post('default_payment_method'),
								'main_sales_person' => $this->input->post( 'main_sales_person' ),
								'is_individual'=>($is_individual == 'true' ? '1' : '0'),
								'sales_team' =>($is_individual == 'true' ? implode(',',$this->input->post( 'sales_team' )) :''),
								'company_address' => $this->input->post( 'company_address' ),
								'contact_number_office' => $this->input->post( 'contact_number_office' ),
								'account_contact_number' => $this->input->post( 'account_contact_number' ),
								'licence_no' => $this->input->post( 'licence_no' ),
								'trade_expiry_date' => $this->input->post( 'trade_expiry_date' ),
								'creditperiod' => $this->input->post( 'creditperiod' ),
								'creditlimit' => $this->input->post('creditlimit'),
								'terms_and_conditions' => $this->input->post('terms_and_conditions'),
								'notes' => $this->input->post('notes'),
						
							);
							$this->Customers_Model->update_customers( $id, $params );
							
							$allfiles=explode(',',$this->input->post('img_name'));
					foreach($allfiles as $eachFiles){
						if($eachFiles!=''){
						$params1 = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'trade_document' => $eachFiles,
						'cust_id' => $id
						);
						$this->db->insert( 'customer_document', $params1 );
						}
					}
					
							if ( $this->input->post( 'custom_fields' ) ) {
								$custom_fields = array(
									'custom_fields' => $this->input->post( 'custom_fields' )
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'customer', $id );
							}
							$data['success'] = true;
							$data['message'] = lang('customer').' '.lang('updatemessage');
							echo json_encode($data);
						}
					} else {
						$data['success'] = false;
						$data['message'] = lang( 'you_dont_have_permission' );
						echo json_encode($data);
					}
				} else {
				$data[ 'customers' ] = $customers=$this->Customers_Model->get_customers( $id );
				$data[ 'documents' ] = $this->Customers_Model->get_customers_documents( $id );
				$data[ 'estimations' ] = $this->Customers_Model->get_customers_estimations( $id );
					
		 $saleswise1=$this->Staff_Model->get_staff_department_wise('16');
		 $saleswise2=$this->Staff_Model->get_staff_department_wise('9');
		 $adminwise=$this->Staff_Model->get_staff_department_wise('11');
		 $data['saleswise']=array_merge($adminwise,$saleswise1,$saleswise2);
		 $data['sales_res']=explode(',',$customers['sales_team']);
					$this->load->view( 'customers/customer', $data );
				}
			} else {
				show_error( 'Eror' );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
	}

	function get_group_id($name){
		$rows = $this->db->get_where('customergroups',array(''))->result_array();
		foreach($rows as $row){
			if($row['name'] = $name){
				$group_id = $row['id'];
			}
		}
		return $group_id?$group_id:'';
	}
function download_liscence_document($id){
		
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file_doc_cust( $id );
			if (is_file('./uploads/images/' . $fileData['trade_document'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/images/' . $fileData['trade_document']);
		    		force_download($fileData['trade_document'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('customers/customer/'.$fileData['cust_id']);
		    	}
				
		}
	}

function delete_liscence_document($id) {
	
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			//echo "21312";exit;
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file_doc_cust($id);
				if ($fileData) {
					$response = $this->db->where( 'doc_id', $id )->delete( 'customer_document', array( 'doc_id' => $id ) );
					
				if (is_file('./uploads/images/' . $fileData['trade_document'])) {
				    		unlink('./uploads/images/' . $fileData['trade_document']);
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
					redirect('customers/customer/'.$fileData['cust_id'].'');
			    }
			} else {
				redirect('customers');
			}
		} else {
			//echo "adSA";exit;
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			//echo json_encode($data);
			redirect('customers');
		}
	}
	
	function customersimport () {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
		   
			$this->load->library( 'import' );
			$data[ 'customers' ] = $this->Customers_Model->get_customers_for_import();
			$data[ 'error' ] = '';
			$config[ 'upload_path' ] = './uploads/imports/';
		$config['allowed_types'] = 'xlsx|xls|csv';
			$config[ 'max_size' ] = '1000';
			$this->load->library( 'upload', $config ); 
			if ( !$this->upload->do_upload('file') ) {
				$data[ 'error' ] = $this->upload->display_errors();
					$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata( 'ntf1', lang('csvimporterror') );
				//redirect( 'customers/index' );
			} else {
			    	$file_data = $this->upload->data();
				$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
			
			 $inputFileName = $file_path;
		 require_once APPPATH . "./third_party/PHPExcel.php";
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$flag = true;
				$i=0;
				foreach ($allDataInSheet as $row) {
				  if($flag){
					$flag =false;
					continue;
				  }
				  $businesstype = $this->Leads_Model->get_businesstype_by_name($row[ 'B' ]);
				  if(sizeof($businesstype) > 0){
					$businesstypeid = $businesstype['id']; 
				  } else {
						$param = array('name'=>$row[ 'B' ]);
						$this->db->insert('customergroups',$param);
						$businesstypeid = $this->db->insert_id();
				  }
				  $appconfig = get_appconfig();
				  $inserdata[$i]['created'] = date( 'Y-m-d H:i:s');
				  $inserdata[$i]['company'] = $row['A'];
				  $inserdata[$i]['groupid'] = $businesstypeid;
				  $inserdata[$i]['account_contact_number'] = $row['C'];
				  $inserdata[$i]['email'] = $row['D'];
				  $inserdata[$i]['address'] = $row['E'];
				  $inserdata[$i]['taxoffice'] = $row['F'];
				  $inserdata[$i]['taxnumber'] = $row['G'];
				  $inserdata[$i]['phone'] = $row['H'];
				  $inserdata[$i]['fax'] = $row['I'];
				  $inserdata[$i]['web'] =$row['J'];
				  $inserdata[$i]['zipcode'] = $row['K'];
				  $inserdata[$i]['licence_no'] = $row['L'];
				  $inserdata[$i]['trade_expiry_date'] = date('Y-m-d',strtotime($row['M']));
				  $inserdata[$i]['terms_and_conditions'] =$row['N'];
				  $inserdata[$i]['notes'] = $row['O'];
				  $inserdata[$i]['creditperiod'] = $row['P'];
				  $inserdata[$i]['creditlimit'] = $row['Q'];
				  $inserdata[$i]['staff_id'] = $this->session->userdata('usr_id');
				   $inserdata[$i]['type'] ='0';
				
				  $result =	$this->Customers_Model->insert_customers_csv( $inserdata[$i] );
						if($appconfig['customer_series']){
							$customer_number = $appconfig['customer_series'];
							$customer_number = $customer_number + 1 ;
							$this->Settings_Model->increment_series('customer_series',$customer_number);
							}
					if($result){
				 
				  	$datas['success'] = true;
					$datas['message'] = lang('file') . ' ' . lang('excelimportsuccess');
					
					echo json_encode($datas);
					
				}else{
				    	$datas['success'] = false;
					$datas['message'] = lang('errormessage').' row '.$i;
					echo json_encode($datas);
					
				
				}    
							
				  $i++;
				} 
				
			
			         

		  } catch (Exception $e) {
			   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' .$e->getMessage());
			}
		  }
			
		}else {
			$datas['success'] = false;
			$datas['message'] = lang('you_dont_have_permission');
			echo json_encode($datas);
		}
	}
	function customersimport_csv () {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			$this->load->library( 'import' );
			$data[ 'customers' ] = $this->Customers_Model->get_customers_for_import();
			$data[ 'error' ] = '';
			$config[ 'upload_path' ] = './uploads/imports/';
			$config[ 'allowed_types' ] = 'csv';
			$config[ 'max_size' ] = '1000';
			$this->load->library( 'upload', $config ); 
			if ( !$this->upload->do_upload('file') ) {
				$data[ 'error' ] = $this->upload->display_errors();
				$this->session->set_flashdata( 'ntf1', lang('csvimporterror') );
				//redirect( 'customers/index' );
			} else {
				$file_data = $this->upload->data();
				$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
				if ( $this->import->get_array( $file_path ) ) {
					$appconfig = get_appconfig();
					$csv_array = $this->import->get_array( $file_path );
					$num = 1;
					$csv_errors = array();
					foreach ( $csv_array as $row ) {
						$group_name = $row['group_name'];
						$group_id = $this->get_group_id($group_name);
						if(($row['email']=='')||($row['type']=='')){
							$num++;
							$csv_errors[] = array(
								'line' => $num,
							);
							continue;
						} else {
						$insert_data = array(
							'created' => date( 'Y-m-d H:i:s' ),
							'type' => $row[ 'type' ],
							'namesurname' => $row[ 'namesurname' ],
							'company' => $row[ 'company' ],
							'taxoffice' => $row[ 'taxoffice' ],
							'taxnumber' => $row[ 'taxnumber' ],
							'executive' => $row[ 'executive' ],
							'ssn' => $row[ 'ssn' ],
							'town' => $row[ 'town' ],
							'zipcode' => $row[ 'zipcode' ],
							'city' => $row[ 'city' ],
							'state' => $row[ 'state' ],
							'country_id' => $row[ 'country_id' ],
							'address' => $row[ 'address' ],
							'fax' => $row[ 'fax' ],
							'email' => $row[ 'email' ],
							'web' => $row[ 'web' ],
							'status_id' => $row[ 'status_id' ],
							'phone' => $row[ 'phone' ],
							'risk' => $row[ 'risk' ],
							'staff_id' => $this->session->userdata('usr_id'),
							'groupid' => $group_id,
						);
						$num++;
						$this->Customers_Model->insert_customers_csv( $insert_data );
						if($appconfig['customer_series']){
							$customer_number = $appconfig['customer_series'];
							$customer_number = $customer_number + 1 ;
							$this->Settings_Model->increment_series('customer_series',$customer_number);
							}
						}
					}
					$datas['success'] = true;
					$datas['message'] = lang('file') . ' ' . lang('csvimportsuccess') . ' ' . lang('butErrors');
					$datas['errors'] = $csv_errors;
					echo json_encode($datas);
				} else{
					$datas['success'] = false;
					$datas['message'] = lang('errormessage');
					echo json_encode($datas);
				}
			}
		} else {
			$datas['success'] = false;
			$datas['message'] = lang('you_dont_have_permission');
			echo json_encode($datas);
		}
	}
function cellColor($cells,$color){
   // global $objPHPExcel;
   $this->load->library('excel');
$objPHPExcel = new PHPExcel();

 $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB($color);
/*
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));*/
}
	// create xlsx
    public function exportdata() {
        /** Include PHPExcel */
        $this->load->library('excel');
        if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id,customers.*');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( ''  ) );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id,customers.*');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( 'staff_id' => $this->session->usr_id ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		
		
    // create file name
        $fileName = 'data-'.time().'.xlsx';  
    // load excel library
        $this->load->library('excel');
        $listInfo = $q->result();
        //echo "<pre>";
        //print_r($listInfo);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
         $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('ff9933');
 $objPHPExcel->getActiveSheet()->getStyle('B1:E1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('66ccff');
 $objPHPExcel->getActiveSheet()->getStyle('F1:I1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('ff9933');
 $objPHPExcel->getActiveSheet()->getStyle('J1:K1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('66ccff');
 $objPHPExcel->getActiveSheet()->getStyle('L1:N1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('ff9933');
$objPHPExcel->getActiveSheet()->getStyle('O1:P1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('66ccff');


$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);

        
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Company Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Industry Type');
       
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Company Address');    
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Vat Office');    
       
           
          $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Vat Number');    
           $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Phone');    
           
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Fax');    
         $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Web');    
          
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Post Code'); 
            
             $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Trade Liscence Number');    
         $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Expiry Date');    
             
         $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Credit Period'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Credit Limit');    
		
          
         $from = "A1"; // or any value
$to = "N1"; // or any value
$objPHPExcel->getActiveSheet()->getStyle( "$from:$to" )->getFont()->setBold( true );
          
        // set Row
        $rowCount = 2;
        foreach ($listInfo as $list) {
           
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->company);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->group);
          
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->address);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->taxoffice);
        
         
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list->taxnumber);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list->phone);
          
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list->fax);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list->web);
          
             $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list->zipcode);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list->licence_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list->trade_expiry_date);
           
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $list->creditperiod);
			 $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $list->creditlimit);
      
            $rowCount++;
        }
      
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Customers.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;       
    }
    

	function exportdata_BACK() {
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( ''  ) );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( 'staff_id' => $this->session->usr_id ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		
		$delimiter = ",";
		$nuline    = "\r\n";
		force_download('Customers.xlsx', $this->dbutil->csv_from_result($q, $delimiter, $nuline));
		
  
	}

	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'customer',
				'staff_id' => $this->input->post( 'staff' ),
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'date' => $this->input->post( 'date' ),
			);
			$notes = $this->Trivia_Model->add_reminder( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'reminderadded' ) . '' );
			redirect( 'customers/customer/' . $this->input->post( 'relation' ) . '' );
		} else {
			redirect( 'leads/index' );
		}
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($customer) {
			if ( $this->Privileges_Model->check_privilege( 'customers', 'delete' ) ) {
				if ( isset( $customer[ 'id' ] ) ) {
					$result = $this->Customers_Model->delete_customers( $id, get_number('customers',$id,'customer','customer'));
					$customer = lang('customer');
					if ( $result ) {
						$data['message'] = sprintf( lang( 'success_delete' ), $customer . '' );
						$data['success'] = true;
						echo json_encode($data);
					} else {
						$data['message'] = sprintf( lang( 'cant_delete' ), $customer . '' );
						$data['success'] = false;
						echo json_encode($data);
					}
				} else {
					show_error( 'Customer not deleted' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
	}

	function customers_json() {
		$customers = $this->Customers_Model->get_all_customers();
		header( 'Content-Type: application/json' );
		echo json_encode( $customers );
	}

	function customers_arama_json() {
		$veriler = $this->Customers_Model->search_json_customer();
		echo json_encode( $veriler );

	}

	function create_contact() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$hasError = false;
				$data['message'] = '';
				if ($this->input->post( 'name' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' '.lang('name');
				} else if ($this->input->post( 'email' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' '.lang('email');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
						$data['success'] = false;
						$data['message'] = lang('contact').' '.lang('email_exist');
						echo json_encode($data);
					} else {
						if (($this->input->post( 'password' ) == '') && ($this->input->post( 'isPrimary' ) == 'true')) {
							$hasError = true;
							$data['message'] = lang('invalidmessage').' '.lang('password');
						}
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						} else {
							switch ($this->input->post('isPrimary')) {
								case 'true':
									$primary = 1;
									$passNew = password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT );
									break;
								case 'false':
									$primary = 0;
									$passNew = null;
									break;
							}
							switch ( $this->input->post( 'isAdmin' ) ) {
								case true:
									$isAdmin = 1;
									break;
								case false:
									$isAdmin = 0;
									break;
							}
							$params = array(
								'name' => $this->input->post( 'name' ),
								'surname' => $this->input->post( 'surname' ),
								'phone' => $this->input->post( 'phone' ),
								'extension' => $this->input->post( 'extension' ),
								'mobile' => $this->input->post( 'mobile' ),
								'email' => $this->input->post( 'email' ),
								'address' => $this->input->post( 'address' ),
								'skype' => $this->input->post( 'skype' ),
								'linkedin' => $this->input->post( 'linkedin' ),
								'customer_id' => $this->input->post( 'customer' ),
								'position' => $this->input->post( 'position' ),
								'primary' => $primary,
								'admin' => $isAdmin,
								'password' => $passNew,
							);
							$contacts_id = $this->Contacts_Model->create( $params );
							if ( $contacts_id ) {
								$permissions = $this->input->post('permissions');
								foreach ($permissions as $perm) {
									if($perm['value'] == 'true'){
										$params = array(
											'relation' => ( int )$contacts_id,
											'relation_type' => 'contact',
											'permission_id' => ( int )$perm['id'],
										);
										$this->db->insert( 'privileges', $params );
									}
								}
								$template = $this->Emails_Model->get_template('customer', 'new_contact_added');
								if ($template['status'] == 1 && $primary == 1) {
									$message_vars = array(
										'{login_email}' => $this->input->post( 'email' ),
										'{login_password}' => ($this->input->post( 'password' ))?($this->input->post( 'password' )):' ',
										'{app_url}' => '' . base_url( 'area/login' ) . '',
										'{email_signature}' => $this->session->userdata( 'email' ),
										'{name}' => $this->session->userdata( 'staffname' ),
										'{customer}' => $this->input->post( 'name' )
									);
									$subject = strtr($template['subject'], $message_vars);
									$message = strtr($template['message'], $message_vars);
									$param = array(
										'from_name' => $template['from_name'],
										'email' => $this->input->post( 'email' ),
										'subject' => $subject,
										'message' => $message,
										'created' => date( "Y.m.d H:i:s" ),
									);
									if ($this->input->post( 'email' )) {
										$this->db->insert( 'email_queue', $param );
									}
								}
								$data['success'] = true;
								$data['message'] = lang('contact').' '.lang('createmessage');
								echo json_encode($data);
							} else {
								$data['success'] = false;
								$data['message'] = lang('errormessage');
								echo json_encode($data);
							}
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

	function contact() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if ($this->input->post( 'name' ) == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('name');
			} else if ($this->input->post( 'email' ) == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('email');
			}
			if ($hasError) {
				$data['success'] = false;
				echo json_encode($data);
			}
			if (!$hasError) {
				if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
					$data['success'] = false;
					$data['message'] = lang('contact').' '.lang('email_exist');
					echo json_encode($data);
				} else {
					if (($this->input->post( 'password' ) == '') && ($this->input->post( 'isPrimary' ) == 'true')) {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('password');
					}
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					} else {
						$data['success'] = true;
						$data['message'] = lang('contact').' '.lang('createmessage');
						echo json_encode($data);
					}
				}
			}
		}
	}

	function update_contact( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contacts = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contacts[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$hasError = false;
					$data['message'] = '';
					if ($this->input->post( 'name' ) == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('name');
					} else if ($this->input->post( 'email' ) == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('email');
					}
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					}
					if (!$hasError) {
						if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) &&  ($this->input->post( 'email' ) != $contacts['email'])) {
							$data['success'] = false;
							$data['message'] = lang('contact').' '.lang('email_exist');
							echo json_encode($data);
						} else {
							$params = array(
								'name' => $this->input->post( 'name' ),
								'surname' => $this->input->post( 'surname' ),
								'phone' => $this->input->post( 'phone' ),
								'extension' => $this->input->post( 'extension' ),
								'mobile' => $this->input->post( 'mobile' ),
								'email' => $this->input->post( 'email' ),
								'address' => $this->input->post( 'address' ),
								'skype' => $this->input->post( 'skype' ),
								'linkedin' => $this->input->post( 'linkedin' ),
								'position' => $this->input->post( 'position' ),
							);
							$this->Contacts_Model->update( $id, $params );
							$data['success'] = true;
							$data['message'] = lang('contact').' '.lang('updatemessage');
							echo json_encode($data);
						}
					}
				}
			} else { 
				show_error( 'The contacts you are trying to edit does not exist.' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function update_contact_privilege( $id, $value, $privilege_id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			if ( $value != 'false' ) {
				$params = array(
					'relation' => ( int )$id,
					'relation_type' => 'contact',
					'permission_id' => ( int )$privilege_id
				);
				$this->db->insert( 'privileges', $params );
			} else {
				$response = $this->db->delete( 'privileges', array( 'relation' => $id, 'relation_type' => 'contact', 'permission_id' => $privilege_id ) );
			}
			$data['success'] = true;
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function change_password_contact( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contact = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contact[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'password' => password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT ),
					);
					$customer = $contact[ 'customer_id' ];
					$staffname = $this->session->staffname;
					$contactname = $contact[ 'name' ];
					$contactsurname = $contact[ 'surname' ];
					$loggedinuserid = $this->session->usr_id;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $message = sprintf( lang( 'changedpassword' ), $staffname, $contactname, $contactsurname ) . '' ),
						'staff_id' => $loggedinuserid,
						'customer_id' => $customer,
					) );
					$this->Contacts_Model->update( $id, $params ); 

					// send email to contact about password change
					$template = $this->Emails_Model->get_template('staff', 'customer_password_reset');
					$message_vars = array(
						'{email}' => $contact['email'],
						'{contact}' => $contact['name'].' '.$contact['surname'],
						'{email_signature}' => $template['from_name'],
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $contact['email'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" ),
						'status' => 1
					);
					if ($contact['email']) {
						$this->db->insert( 'email_queue', $param );
					}
					$data['success'] = true;
					$data['message'] = ' ' . $contact[ 'name' ] . ' ' . lang( 'passwordchanged' ) . '';
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function remove_contact( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contacts = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contacts[ 'id' ] ) ) {
				$this->Contacts_Model->delete( $id );
				$data['success'] = true;
				$data['message'] = lang('contactdeleted');
				echo json_encode($data);
			} else{
				show_error( 'The contacts you are trying to delete does not exist.' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		} 
	}
	
	function saleswisedata() {
		$saleswise1=$this->Staff_Model->get_staff_department_wise('16');
		$saleswise2=$this->Staff_Model->get_staff_department_wise('9');
		$adminwise=$this->Staff_Model->get_staff_department_wise('11');
		$data['saleswise']=array_merge($adminwise,$saleswise1,$saleswise2);
		echo json_encode($data['saleswise']);
	}
	
	function get_customer( $id ) {
		$customer = array();
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		if($customer) {
			$country = get_country($customer['country_id']);
			$state = get_state_name($customer['state'], $customer['state_id']);
			$contacts = $this->Contacts_Model->get_customer_contacts( $id );
			$subsidiaries = $this->Customers_Model->get_subsidiaries( $id );
			$this->db->select_sum( 'total' );
			$this->db->from( 'invoices' );
			$this->db->where( '(status_id = 2 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$netrevenue = $this->db->get();
			$this->db->select_sum( 'total' );
			$this->db->from( 'invoices' );
			$this->db->where( '(status_id != 1 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$grossrevenue = $this->db->get();
			$settings = $this->Settings_Model->get_settings_ciuis();
				switch ( $settings[ 'dateformat' ] ) {
					case 'yy.mm.dd':
						$trade_expiry_date = _rdate( $customer[ 'trade_expiry_date' ] );
						

						break;
					case 'dd.mm.yy':
						$trade_expiry_date = _udate( $customer[ 'trade_expiry_date' ] );
					
						break;
					case 'yy-mm-dd':
						$trade_expiry_date = _mdate( $customer[ 'trade_expiry_date' ] );
						
						break;
					case 'dd-mm-yy':
						$trade_expiry_date = _cdate( $customer[ 'trade_expiry_date' ] );
						
						break;
					case 'yy/mm/dd':
						$trade_expiry_date = _zdate( $customer[ 'trade_expiry_date' ] );
						
						break;
					case 'dd/mm/yy':
						$trade_expiry_date = _kdate( $customer[ 'trade_expiry_date' ] );
						
						break;
				};
			$data_customerdetail = array(
				'id' => $customer[ 'id' ],
				'type' => $customer[ 'type' ],
				'isIndividual' => ($customer['type'] == '1') ? true : false,
				'created' => $customer[ 'created' ],
				'staff_id' => $customer[ 'staff_id' ],
				'company' => $customer[ 'company' ],
				'namesurname' => $customer[ 'namesurname' ],
				'taxoffice' => $customer[ 'taxoffice' ],
				'taxnumber' => $customer[ 'taxnumber' ],
				'ssn' => $customer[ 'ssn' ],
				'executive' => $customer[ 'executive' ],
				'address' => $customer[ 'address' ],
				'zipcode' => $customer[ 'zipcode' ],
				'country_id' => $customer[ 'country_id' ],
				'state' => $state,
				'state_id' => $customer['state_id'],
				'city' => $customer[ 'city' ],
				'town' => $customer[ 'town' ],
				'default_payment_method' => $customer[ 'default_payment_method' ],
				'main_sales_person'=>$customer[ 'main_sales_person' ],
				'is_individual'=>($customer[ 'is_individual' ] == 1 ? true : false),
				'sales_team' => $customer[ 'sales_team' ],
				'billing_street' => $customer[ 'billing_street' ],
				'billing_city' => $customer[ 'billing_city' ],
				'billing_state' => $customer['billing_state'],
				'billing_state_id' => $customer['billing_state_id'],
				'billing_zip' => $customer[ 'billing_zip' ],
				'billing_country' => $customer[ 'billing_country' ],
				'country' => $country,
				'shipping_street' => $customer[ 'shipping_street' ],
				'shipping_city' => $customer[ 'shipping_city' ],
				'shipping_state' => $customer['shipping_state'],
				'shipping_state_id' => $customer['shipping_state_id'],
				'shipping_zip' => $customer[ 'shipping_zip' ],
				'shipping_country' => $customer[ 'shipping_country' ],
				'phone' => $customer[ 'phone' ],
				'fax' => $customer[ 'fax' ],
				'email' => $customer[ 'email' ],
				'companyemail' => $customer[ 'email' ],
				'contactpersonname' => $customer[ 'contactpersonname' ],
				'web' => $customer[ 'web' ],
				'risk' => intval( $customer[ 'risk' ] ),
				'netrevenue' => $netrevenue->row()->total,
				'grossrevenue' => $grossrevenue->row()->total,
				'subsidiaries' => $subsidiaries,
				'contacts' => $contacts,
				'chart_data' => $this->Report_Model->customer_annual_sales_chart( $id ),
				'group_name' => $customer['name'],
				'group_id' => $customer['groupid'],
				'customer_number' => get_number('customers', $customer[ 'id' ], 'customer','customer'),
				'customer_status_id' => ($customer['customer_status_id'] == 1 ? true : false),
				'company_address'=>$customer['company_address'],
				'contact_number_office'=>$customer['contact_number_office'],
				'account_contact_number'=>$customer['account_contact_number'],
				'licence_no'=>$customer['licence_no'],
				'terms_and_conditions'=>$customer['terms_and_conditions'],
				'notes'=>$customer['notes'],
				'creditperiod'=>$customer['creditperiod'],
				'creditlimit'=>$customer['creditlimit'],
				'trade_expiry_date'=>$trade_expiry_date
				
			);
			echo json_encode( $data_customerdetail );
		}
	}
}
