<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Quoterequest extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Estimations_Model');
		$this->load->model('Customers_Model');
		$this->load->model('Settings_Model');
		$this->load->model('Orders_Model');
		$this->load->model('Fields_Model');
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data = array();
		$data[ 'title' ] = lang( 'quoterequest' );
		unset($_SESSION['Uniqid']);
		$imageId=uniqid();
		$this->session->set_userdata(array('Uniqid'=>$imageId));
		$this->load->view( 'quoterequest/index', $data );
	}
	
	function get_all_customers() {
		$customers = $this->Customers_Model->get_all_customers_by_acccess();
		echo json_encode($customers);
	}
	
	function get_all_sales_staff() {
		$sales_staff = $this->Estimations_Model->get_sales_staff('16');
		echo json_encode($sales_staff);
	}
	
	function create() {
		if ($this->Privileges_Model->check_privilege( 'quoterequest', 'create' )) {
			$data[ 'title' ] = lang( 'quoterequest' );
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$files = $this->db->get_where( 'temp_quote_documents', array( 'uniqid_id' => $this->session->userdata('Uniqid'),'user_id'=>$this->session->usr_id ))->result_array();
				$project = $this->input->post( 'project' );
				//$staff = $this->input->post('staff');
				$customer = $this->input->post( 'customer' );
				$client_contact_id = $this->input->post( 'client_contact_id');
				$salesteam = $this->input->post( 'main_sales_team_id' );
				$quotedetails = $this->input->post( 'quotedetails' );
				//Estimations insert//
				$Estparams = array(
					'project_name' =>$project,
					'estimate_status' => 'Quote Request',
					'salesteam'=>$salesteam,
					'customer_id' => $customer,
					'customer_contact_id' => $client_contact_id,
					'estimation_total_cost_amt' =>'0.00',
					'subtotal_amt' => '0.00',
					'user_id' => $this->session->usr_id,
					'created' => date( 'Y-m-d' ),
					'description'=> $quotedetails
				);
				$this->db->insert( 'estimations', $Estparams );
				$estimation_id = $this->db->insert_id();
				
				$main_params = array(
					'estimation_id' => $estimation_id,
					'item_name' => 'New',
					'quantity' => 1,
					'unit_price' => 0,
					'tax' => 5,
					'amount' => 0,
					'sub_tot_cost' => 0.00,
					'sub_tot_sp' => 0.00,
					'round_helper' => 0.00
				);
				$this->db->insert( 'estimations_main_items', $main_params );
				
				if(sizeof($files) > 0){
					foreach($files as $eachFile){
						$Fileparams=array();
						$Fileparams = array(
							'estimation_id' => $estimation_id,
							'document_name' => $eachFile['document_name']
						);
						$this->db->insert('estimations_documents', $Fileparams );
						$estDir ='uploads/estimate_documents/'. $eachFile['document_name'];
						$quotsDir='uploads/quoterequest_documents/'. $eachFile['document_name'];
						copy($quotsDir, $estDir);
					}
				}

				$params = array(
					'token' => md5( uniqid() ),
					'project' => $this->input->post( 'project' ),
					'assigned' => $this->session->usr_id,
					'date' =>  date( 'Y-m-d' ),
					'opentill' => date('Y-m-d', strtotime("+30 days")),
					'relation_type' => 'customer',
					'relation' => $this->input->post( 'customer'),
					'client_contact_id' => $this->input->post( 'client_contact_id'),
					'salesteam' => $this->input->post( 'main_sales_team_id' ),
					//'content' => $this->input->post( 'quotedetails' ),
					'addedfrom' => $this->session->usr_id,
					'created' => date( 'Y-m-d H:i:s'),
					'status_id' => 7,
					'estimation_id'=>$estimation_id
				);
				$orders_id = $this->Orders_Model->order_add($params,true);
				
				$historyparams=array('module'=>'orders','relation_id'=>$orders_id,'type'=>'created');
				$this->Privileges_Model->create_history($historyparams);
				
				/*$notesparams = array(
					'description' => $this->input->post( 'quotedetails' ),
					'relation' => $orders_id,
					'relation_type' => 'order',
					'addedfrom' => $this->session->userdata( 'usr_id' ),
					'created' => date('Y-m-d'),
				);
				$notes = $this->Trivia_Model->add_note( $notesparams );*/
				if(sizeof($files) > 0){
					foreach($files as $eachFile){
						$params=array();
						$params = array(
							'orderid' => $orders_id,
							'document_name' => $eachFile['document_name'],
							'filepath' => $eachFile['filepath']
						);
						$this->db->insert('order_documents', $params );
						$orderDir ='uploads/order_documents/'. $eachFile['document_name'];
						$quotsDir='uploads/quoterequest_documents/'. $eachFile['document_name'];
						copy($quotsDir, $orderDir);
					}
				}
				
				redirect(base_url('orders/index'));
			}else {
				$this->session->set_flashdata('ntf3',lang('No Data Present' ));
				$this->load->view( 'quoterequest/index', $data );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('quoterequest/index'));
		}
	}
	
	function get_client_contacts($client_id){
		$result = $this->Contacts_Model->get_customer_contacts($client_id);		
		$result1 = $this->Customers_Model->get_customers($client_id);	
		$salestea=$result1['sales_team'];
		$supplier_result=explode(',',$salestea);		
		$contact= ' <select class="form-control contact my-select" data-live-search="true" ng-model="contact_id" name="client_contact_id" id="client_contact_id" required=""><option value="">Select Contact</option>';
		foreach($result as $k => $val){
			if($val['id'] != '') {
				$contact.='<option value="'.$val['id'].'" >'.$val['name'].'</option>';
			}					
		}
		$contact.= '</select>';
		
		$supplier= ' <select class="form-control salesteam my-select" data-live-search="true"  ng-model="salesteam_id"  name="salesteam" id="salesteam" required=""><option value="">Select Sales Person </option>';
		
		foreach($supplier_result as $eachsupp){
			$sres = $this->Staff_Model->get_staff($eachsupp);
			if($sres['id'] != '') {
				$supplier.='<option value="'.$sres['id'].'" >'.$sres['staffname'].'</option>';
				}
		}
		$supplier.= '</select>';
		
		$salesteamid = $result1['main_sales_person'];
		echo json_encode(array('contact'=>$contact,'supplier'=>$supplier, 'salesteamid'=>$salesteamid));
	}
	function add_file() { 
		if ( $this->Privileges_Model->check_privilege( 'quoterequest', 'edit' ) ) {
			if (isset( $_POST )) {
				if (!is_dir('uploads/quoterequest_documents')) { 
					mkdir('./uploads/quoterequest_documents', 0777, true);
				}
				$count = count($_FILES);
				if($count > 0){
					for($i=0;$i<$count;$i++){
						if(!empty($_FILES[$i]['name'])){
						  $_FILES['file']['name'] = $_FILES[$i]['name'];
						  $_FILES['file']['type'] = $_FILES[$i]['type'];
						  $_FILES['file']['tmp_name'] = $_FILES[$i]['tmp_name'];
						  $_FILES['file']['error'] = $_FILES[$i]['error'];
						  $_FILES['file']['size'] = $_FILES[$i]['size'];
						  $config[ 'upload_path' ] = './uploads/quoterequest_documents';
						  $config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
						  $config['max_size'] = '9000';
						  $new_name =rand(100,1000).'_'.preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES[$i]['name']));
						  $config['file_name'] = $new_name; 
						  $this->load->library('upload',$config); 
						  $this->upload->initialize($config);
						  if($this->upload->do_upload('file')){  
							$uploadData = $this->upload->data();
							$filename = $uploadData['file_name'];
							$filetype = $uploadData['file_type'];
							$params=array();
							$params = array('uniqid_id' =>$this->session->userdata('Uniqid'),
											'document_name'=>$filename,
											'user_id'=>$this->session->usr_id,
											'filepath'=>'uploads/quoterequest_documents'
							);
							$this->db->insert( 'temp_quote_documents', $params );
						  }
						}
					}
					$data['success'] = true;
					$data['message'] = lang('file').' '.lang('uploadmessage');
					echo json_encode($data);
				}
			
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function quoterequestfilesbysession() {
		if ($this->session->userdata('Uniqid')) {
			$files = $this->db->get_where( 'temp_quote_documents', array( 'uniqid_id' => $this->session->userdata('Uniqid'),'user_id'=>$this->session->usr_id ))->result_array();
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['document_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf' || $ext =='PDF') {
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
				if ($ext == 'pdf' || $ext =='PDF') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				$path = base_url('uploads/quoterequest_documents/'.$file['document_name']);
				$data[] = array(
					'id' => $file['id'],
					'user_id' => $file['user_id'],
					'uniqid_id' => $file['uniqid_id'],
					'file_name' => $file['document_name'],
					
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}
	
	
	function download_file($id) {
		if (isset($id)) {
		   $fileData=$this->db->get_where('temp_quote_documents', array('id' => $id))->row_array();
			if (is_file('./uploads/quoterequest_documents/' . $fileData['document_name'])) {
				$this->load->helper('file');
				$this->load->helper('download');
				$data = file_get_contents('./uploads/quoterequest_documents/' . $fileData['document_name']);
				force_download($fileData['document_name'], $data);
			} else {
				$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
				redirect('quoterequest/index');
			}
		}
	}
	
	
	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'quoterequest', 'edit' ) ) {
			if (isset($id)) {
				 $fileData=$this->db->get_where('temp_quote_documents', array('id' => $id))->row_array();
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'temp_quote_documents', array( 'id' => $id ) );
					if (is_file('./uploads/quoterequest_documents/' . $fileData['document_name'])) {
				    		unlink('./uploads/quoterequest_documents/' . $fileData['document_name']);
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
				redirect('quoterequest/index');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function check_project_avalibility(){
		$estimationsResult=$this->Estimations_Model->is_project_available($_POST["projectName"]);
		$orderResult=$this->Orders_Model->is_project_available($_POST["projectName"]);
		if($estimationsResult==true || $orderResult==true){  
			 echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Project Name Already Exists</label>';  
		}else  
		{  
			 echo '<label class="text-success"><span class="glyphicon glyphicon-ok"></span> Project Name Available</label>';  
		} 
	}
	
	function check_project_submit(){
		$data = array();
		$estimationsResult=$this->Estimations_Model->is_project_available($_POST["projectName"]);
		$orderResult=$this->Orders_Model->is_project_available($_POST["projectName"]);
		$data['message'] = "success";
		if($estimationsResult==true || $orderResult==true){  
			$data['message'] = "fail";
		}else  
		{  
			$data['message'] = "success";
		}
		echo json_encode($data);
	}
	
	
}