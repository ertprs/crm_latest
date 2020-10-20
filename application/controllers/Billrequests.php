<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Billrequests extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
			$this->load->model('Requests_Model');
			$this->load->model('Mrequests_Model');
			$this->load->model('Material_Model');
			$this->load->model('Staff_Model');
			$this->load->model('Vendors_Model');
			$this->load->model('Billrequests_Model');
			$this->load->model('Leaverequests_Model');
			$this->load->model('Salaryrequests_Model');
			$this->load->helper('url'); 
			$this->load->model('Otherrequests_Model');
			$this->load->model('Notifications_Model');
			$this->load->model('Privileges_Model');
			
	
	if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} 
		
	}
	

	function index() {
		
		$path = $this->uri->segment( 3 );
		 if($path == 'approved'){
			$status = 2;
		}
		else if($path == 'rejected'){
			$status = 3;
		}else if($path == 'pending'){
			$status = 1;
		}else{
			$status = 0;
		}
		$data['vendors'] = $this->Vendors_Model->get_all_vendors();
		
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'billrequests', 'all' ) ){
			
		$brequestsdata = $this->Billrequests_Model->get_all_user_brequests($status);
		$data['app_count'] = $this->Billrequests_Model->get_appreq_user_count(2);
		$data['dec_count'] = $this->Billrequests_Model->get_decreq_user_count(3);
		$data['pend_count'] = $this->Billrequests_Model->get_pendreq_user_count(1);
		$data['all_count'] = $this->Billrequests_Model->get_allreq_user_count();
			
		}
		else {
		$brequestsdata = $this->Billrequests_Model->get_all_brequests($status,$data['user_id']);
		$data['app_count'] = $this->Billrequests_Model->get_appreq_count(2,$data['user_id']);
		$data['dec_count'] = $this->Billrequests_Model->get_decreq_count(3,$data['user_id']);
		$data['pend_count'] = $this->Billrequests_Model->get_pendreq_count(1,$data['user_id']);
		$data['all_count'] = $this->Billrequests_Model->get_allreq_count($data['user_id']);
		}
		$approvalAccess=$this->Privileges_Model->has_approval_access('billrequests');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='amount';
		if($approvalAccess['type']=='level'){
			$data['brequests']=check_approval_data($brequestsdata,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$data['brequests']=check_approval_data($brequestsdata,$maxvalue,$comperKey);
		}else{
			$data['brequests']=check_approval_data($brequestsdata,$maxvalue,'NotAccess');
		}
		$data[ 'title' ] = 'Bill Request';  
		$data['pagename']='request';
		$this->load->view( 'billrequests/index', $data );
	}
	

	function create(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		$employeeids=array();
		$adminides=$this->Staff_Model->get_all_admin_ids();
		$tempemployeeids=$adminides;
		foreach($tempemployeeids as $eachId){
			if($eachId != $this->input->post( 'staff' )){
				$employeeids[]=array("id"=>$eachId);
			}
		}
		$pagename = $this->input->post('pagename');
		$vendor_id = $this->input->post( 'vendor_id' );
		$bill_date = $this->input->post('bill_date');
		$reference = $this->input->post('reference');
		$amount = $this->input->post('amount');
		$vendor = $this->Billrequests_Model->get_vendor_name($vendor_id);
		if($vendor == ''){
			$params = array('company' => $vendor_id);
			$this->db->insert( 'vendors', $params );
		}
 		$params = array(
						'vendor_id' => $vendor_id,
						'bill_date' => $bill_date,
						'reference' => $reference,
						'amount' => $amount,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'bill_requests', $params );
					$bill_id = $this->db->insert_id();
					$seriesid = "BILL-".$bill_id;
					$this->db->where('bill_id', $bill_id)->update( 'bill_requests', array('seriesid' => $seriesid ) );
					
					if (!is_dir('uploads/files/billrequests/'.$bill_id)) { 
						mkdir('./uploads/files/billrequests/'.$bill_id, 0777, true);
					}
				      $data = [];
   
					$count = count($_FILES['files']['name']);
    
				  for($i=0;$i<$count;$i++){
					if(!empty($_FILES['files']['name'][$i])){
					  $_FILES['file']['name'] = $_FILES['files']['name'][$i];
					  $_FILES['file']['type'] = $_FILES['files']['type'][$i];
					  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					  $_FILES['file']['error'] = $_FILES['files']['error'][$i];
					  $_FILES['file']['size'] = $_FILES['files']['size'][$i];
			  
					 $config[ 'upload_path' ] = './uploads/files/billrequests/'.$bill_id.'';
					  $config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					  $config['max_size'] = '5000';
					  $config['file_name'] = $_FILES['files']['name'][$i];
					  $this->load->library('upload',$config); 
				
					   if($this->upload->do_upload('file')){
						   
						$uploadData = $this->upload->data();
						
						$filename = $uploadData['file_name'];
						$filetype = $uploadData['file_type'];
						$params = array('bill_id' => $bill_id,
										'file_name' => $filename,
										'filetype' => $filetype
						);
						$this->db->insert( 'bill_request_files', $params );
			   
						} 
					}
					
				  }
				$this->session->set_flashdata('success','Bill Request Added Successfully');
				
				//Notification//
				$Notifyparams=array();
				$Notifyparams['staffList']=$employeeids;
				$Notifyparams['msg']=( '' .$seriesid.' '.lang('send').' By '. $this->session->staffname .'' );
				$Notifyparams['link']= base_url('billrequests/');
				$Notifyparams['staff_id']= '';
				$Notifyparams['img']=$this->session->staffavatar;
				$this->Notifications_Model->insertNotification($Notifyparams);

				$staffname = $this->session->staffname;
				$loggedinuserid = $this->session->usr_id;
				$staffavatar = $this->session->staffavatar;
				$this->db->insert( 'estiimation_notifications', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $staffname .' req '.$seriesid) ,
					'staff_id' => $loggedinuserid,
					'perres' => $staffavatar,
					'customer_id' => $vendor_id ,
					'number' => ($seriesid),
					'value' => $amount,
					'customer_name' => $vendor,
					'request_type'=> "leave",
					'target'=> base_url('billrequests/'),
					'request_type'=> "bill"
				) );
				if($pagename=='request'){
					redirect('billrequests','refresh'); 
				}else{
				  redirect('billrequests','refresh'); 
				}
		}
	}
	
	
		
	function update(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data=$this->Billrequests_Model->update_status($id,$status);
		echo json_encode($data);
		//$this->session->set_flashdata();
		$this->session->set_flashdata('success', "Status  Updated Successfully"); 

		redirect('billrequests','refresh');
    }
	function view(){
		$data['id'] = $this->input->post('id');
		$data['images'] = $this->Billrequests_Model->get_images($data['id']);
		$data[ 'title' ] = lang( 'billrequestsview' );
		echo json_encode($data);
		//$this->load->view('billrequests/view',$data);
		
		
	}
	
	
}