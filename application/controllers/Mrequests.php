<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Mrequests extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->library( "Material_lib" );
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
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} 
	}

	function index() {
		$data[ 'unittypes' ] = $unittypes=$this->Settings_Model->get_mat_unittype();
		
		$data[ 'title' ] = lang( 'requests' );
		$path = $this->uri->segment(3);
		
		if($path == 'pending'){
			$status = 2;
		}
		else if($path == 'app'){
			$status = 3;
		}
		else if($path == 'dec'){
			$status = 4;
		}else if($path == 'open'){
			$status = 1;
		} else {
			$status = '';
		}
		
		$priority = 0;
		if($this->uri->segment(3) == "priority") {
			$priorityPath = $this->uri->segment(4);
			if($priorityPath == 'low') {
				$priority = 1;
			} else if ($priorityPath == 'medium') {
				$priority = 2;
			} else if ($priorityPath == 'high'){
				$priority = 3;
			} else {
				$priority = 0;
			}
		}
		$data[ 'tickets' ] = $this->Tickets_Model->get_all_tickets();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['projects']= $this->Projects_Model->get_all_projects();
		$data['materials'] = $this->Material_Model->get_all_materials();
		$data['priority'] = $this->Mrequests_Model->getSettingsByType('Request_priority');
		if($this->Privileges_Model->check_privilege( 'mrequests', 'all' ) ){
			$mrequestsdata = $this->Mrequests_Model->get_all_mrequests($status, $priority);
			$data['status_all_count'] = $this->Mrequests_Model->get_status_count('');
			$data['status_open_count'] = $this->Mrequests_Model->get_status_count(1);
			$data['status_pending_count'] = $this->Mrequests_Model->get_status_count(2);
			$data['status_approved_count'] = $this->Mrequests_Model->get_status_count(3);
			$data['status_declined_count'] = $this->Mrequests_Model->get_status_count(4);
			$data['priority_low_count'] = $this->Mrequests_Model->get_priority_count(1);
			$data['priority_medium_count'] = $this->Mrequests_Model->get_priority_count(2);
			$data['priority_high_count'] = $this->Mrequests_Model->get_priority_count(3);
		}
		else
		{	
			$data['user_id'] = $this->session->userdata( 'usr_id' );
			$mrequestsdata = $this->Mrequests_Model->get_user_mrequests($status,$data['user_id'], $priority);
			$data['status_all_count'] = $this->Mrequests_Model->get_status_count('',$data['user_id']);
			$data['status_open_count'] = $this->Mrequests_Model->get_status_count(1, $data['user_id']);
			$data['status_pending_count'] = $this->Mrequests_Model->get_status_count(2, $data['user_id']);
			$data['status_approved_count'] = $this->Mrequests_Model->get_status_count(3, $data['user_id']);
			$data['status_declined_count'] = $this->Mrequests_Model->get_status_count(4, $data['user_id']);
			$data['priority_low_count'] = $this->Mrequests_Model->get_priority_count(1, $data['user_id']);
			$data['priority_medium_count'] = $this->Mrequests_Model->get_priority_count(2, $data['user_id']);
			$data['priority_high_count'] = $this->Mrequests_Model->get_priority_count(3, $data['user_id']);
		}
		
		$status = 0;
		if($this->Privileges_Model->check_privilege( 'leaverequests', 'all' ) ){
			$data['lrequests'] = $this->Leaverequests_Model->get_all_lrequests($status);
			$data['open_count'] = $this->Leaverequests_Model->get_appreq_count(1);
			$data['app_count'] = $this->Leaverequests_Model->get_appreq_count(2);
			$data['dec_count'] = $this->Leaverequests_Model->get_decreq_count(4);
			$data['pend_count'] = $this->Leaverequests_Model->get_pendreq_count(3);
		}else{
			$data['lrequests'] = $this->Leaverequests_Model->get_user_all_lrequests($status,$data['user_id']);
			$data['open_count'] = $this->Leaverequests_Model->get_user_appreq_count(1,$data['user_id']);
			$data['app_count'] = $this->Leaverequests_Model->get_user_appreq_count(2,$data['user_id']);
			$data['dec_count'] = $this->Leaverequests_Model->get_user_decreq_count(4,$data['user_id']);
			$data['pend_count'] = $this->Leaverequests_Model->get_user_pendreq_count(3,$data['user_id']);
		}
		$approvalAccess=$this->Privileges_Model->has_approval_access('mrequests');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='price';
		if($approvalAccess['type']=='level'){
			$data['mrequests']=check_approval_data($mrequestsdata,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$data['mrequests']=check_approval_data($mrequestsdata,$maxvalue,$comperKey);
		}else{
			$data['mrequests']=check_approval_data($mrequestsdata,$maxvalue,'NotAccess');
		}
		$this->load->view( 'mrequests/index', $data );
	}
	
		function billrequest() {
		
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
			
		$data['brequests'] = $this->Billrequests_Model->get_all_user_brequests($status);
		$data['app_count'] = $this->Billrequests_Model->get_appreq_user_count(2);
		$data['dec_count'] = $this->Billrequests_Model->get_decreq_user_count(3);
		$data['pend_count'] = $this->Billrequests_Model->get_pendreq_user_count(1);
		$data['all_count'] = $this->Billrequests_Model->get_allreq_user_count();
			
		}
		else {
		$data['brequests'] = $this->Billrequests_Model->get_all_brequests($status,$data['user_id']);
		$data['app_count'] = $this->Billrequests_Model->get_appreq_count(2,$data['user_id']);
		$data['dec_count'] = $this->Billrequests_Model->get_decreq_count(3,$data['user_id']);
		$data['pend_count'] = $this->Billrequests_Model->get_pendreq_count(1,$data['user_id']);
		$data['all_count'] = $this->Billrequests_Model->get_allreq_count($data['user_id']);
		}
		
		
		$data[ 'title' ] = 'Bill Request';  
		$data['pagename']='request';
		$this->load->view( 'billrequests/index', $data );
	}
	
	function salaryrequest() {
		
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
		$data['employees'] = $this->Staff_Model->get_all_staff();
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'salaryrequests', 'all' ) ){
		$data['srequests'] = $this->Salaryrequests_Model->get_all_srequests($status);
		$data['app_count'] = $this->Salaryrequests_Model->get_appreq_count(2);
		$data['dec_count'] = $this->Salaryrequests_Model->get_decreq_count(3);
		$data['pend_count'] = $this->Salaryrequests_Model->get_pendreq_count(1);
		$data['all_count'] = $this->Salaryrequests_Model->get_allreq_count();
		}
		else{
			
			$data['srequests'] = $this->Salaryrequests_Model->get_user_all_srequests($status,$data['user_id']);
			$data['app_count'] = $this->Salaryrequests_Model->get_user_appreq_count(2,$data['user_id']);
			$data['dec_count'] = $this->Salaryrequests_Model->get_user_decreq_count(3,$data['user_id']);
			$data['pend_count'] = $this->Salaryrequests_Model->get_user_pendreq_count(1,$data['user_id']);
			$data['all_count'] = $this->Salaryrequests_Model->get_user_allreq_count($data['user_id']);
		}
		$data[ 'title' ] = 'Salary Request';  
		$data['pagename']='request';
		$this->load->view( 'salaryrequests/index', $data );
	}
	
	function otherrequest() {
		
		$this->load->model('Projects_Model');
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
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'otherrequests', 'all' ) ){
		$data['orequests'] = $this->Otherrequests_Model->get_all_orequests($status);
		$data['app_count'] = $this->Otherrequests_Model->get_appreq_count(2);
		$data['dec_count'] = $this->Otherrequests_Model->get_decreq_count(3);
		$data['pend_count'] = $this->Otherrequests_Model->get_pendreq_count(1);
		$data['all_count'] = $this->Otherrequests_Model->get_allreq_count();
		}else{
			$data['orequests'] = $this->Otherrequests_Model->get_user_all_orequests($status,$data['user_id']);
		$data['app_count'] = $this->Otherrequests_Model->get_user_appreq_count(2,$data['user_id']);
		$data['dec_count'] = $this->Otherrequests_Model->get_user_decreq_count(3,$data['user_id']);
		$data['pend_count'] = $this->Otherrequests_Model->get_user_pendreq_count(1,$data['user_id']);
		$data['all_count'] = $this->Otherrequests_Model->get_user_allreq_count($data['user_id']);
			
		}
		$data[ 'title' ] = lang( 'otherrequests' );  
		$data['maxvalue']=$this->Privileges_Model->has_approval('otherrequests');
		$this->load->view( 'otherrequests/index', $data );
	}


	function leaverequest()
	{
		
		$path = $this->uri->segment( 3 );
		 $url = $this->uri->segment( 4 );
		 if($path == 'app'){
			$status = 2;
		}
		else if($path == 'dec'){
			$status = 4;
		}else if($path == 'pend'){
			$status = 3;
		}else if($path == 'open'){
			$status = 1;
		}else{
			$status = 0;
		}
		$data['employees'] = $this->Staff_Model->get_all_staff();
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'leaverequests', 'all' ) ){
		$data['lrequests'] = $lrequests=$this->Leaverequests_Model->get_all_lrequests($status);
		$data['open_count'] = $this->Leaverequests_Model->get_appreq_count(1);
		$data['app_count'] = $this->Leaverequests_Model->get_appreq_count(2);
		$data['dec_count'] = $this->Leaverequests_Model->get_decreq_count(4);
		$data['pend_count'] = $this->Leaverequests_Model->get_pendreq_count(3);
		$data['all_count'] = $this->Leaverequests_Model->get_allreq_count();
		$data['annual_leave_count'] = $this->Leaverequests_Model->get_annualleave_count();
			if($data['annual_leave_count'] == ''){
				$data['annual_count'] = 0;
			}else{
				
				$data['annual_count'] = $data['annual_leave_count'];
			}
		$data['sick_leave_count'] = $this->Leaverequests_Model->get_sickleave_count();
			if($data['sick_leave_count'] == ''){
				$data['sick_leave_count'] = 0;
			}else{
				
				$data['sick_count'] = $data['sick_leave_count'];
			}
		$data['emergency_leave'] = $this->Leaverequests_Model->get_emergency_leave_count();
			if($data['emergency_leave'] == ''){
				$data['emergency_count'] = 0;
			}else{
				
				$data['emergency_count'] = $data['emergency_leave'];
			}
		$data['casual_leave'] = $this->Leaverequests_Model->get_casual_leave_count();
			if($data['casual_leave'] == ''){
					$data['casual_count'] = 0;
				}else{
					
					$data['casual_count'] = $data['casual_leave'];
				}
				
		}else{
		$data['lrequests'] =$lrequests= $this->Leaverequests_Model->get_user_all_lrequests($status,$data['user_id']);
		$data['open_count'] = $this->Leaverequests_Model->get_user_appreq_count(1,$data['user_id']);
			$data['app_count'] = $this->Leaverequests_Model->get_user_appreq_count(2,$data['user_id']);
		$data['dec_count'] = $this->Leaverequests_Model->get_user_decreq_count(4,$data['user_id']);
		$data['pend_count'] = $this->Leaverequests_Model->get_user_pendreq_count(3,$data['user_id']);
		$data['all_count'] = $this->Leaverequests_Model->get_user_allreq_count($data['user_id']);
		$data['annual_leave_count'] = $this->Leaverequests_Model->get_user_annualleave_count($data['user_id']);
			if($data['annual_leave_count'] == ''){
				$data['annual_count'] = 0;
			}else{
				
				$data['annual_count'] = $data['annual_leave_count'];
			}
		$data['sick_leave_count'] = $this->Leaverequests_Model->get_user_sickleave_count($data['user_id']);
			if($data['sick_leave_count'] == ''){
				$data['sick_leave_count'] = 0;
			}else{
				
				$data['sick_count'] = $data['sick_leave_count'];
			}
		$data['emergency_leave'] = $this->Leaverequests_Model->get_user_emergency_leave_count($data['user_id']);
			if($data['emergency_leave'] == ''){
				$data['emergency_count'] = 0;
			}else{
				
				$data['emergency_count'] = $data['emergency_leave'];
			}
		$data['casual_leave'] = $this->Leaverequests_Model->get_user_casual_leave_count($data['user_id']);
			if($data['casual_leave'] == ''){
					$data['casual_count'] = 0;
				}else{
					
					$data['casual_count'] = $data['casual_leave'];
				}
		}	
		
		if($this->Privileges_Model->check_privilege( 'billrequests', 'all' ) ){
			
		$data['brequests'] = $this->Billrequests_Model->get_all_user_brequests($status);
		
			
		}
		else {
		$data['brequests'] = $this->Billrequests_Model->get_all_brequests($status,$data['user_id']);
		
		}
				
		$data[ 'title' ] = lang( 'leaverequests' );  
		if($url=='filter'){
			$this->load->view( 'leaverequests/filter_leaverequest', $data );
		}else{
		$this->load->view( 'leaverequests/leaverequest', $data );
		}
	}
	
	function create(){
		$vendorIdMin = '';
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		$appconfig = get_appconfig();
		$employeeids=array();
		$adminides=$this->Staff_Model->get_all_admin_ids();
		$tempemployeeids=$adminides;
		foreach($tempemployeeids as $eachId){
			if($eachId != $this->input->post( 'staff' )){
				$employeeids[]=array("id"=>$eachId);
			}
		}
		if($this->input->post('project')=='cosumables'){
			$postmaterial_name=$this->input->post( 'description' );
			$postmaterial_name_text=$this->input->post( 'description' );
		}else{
			$postmaterial_name=$this->input->post( 'material_name' );
			
			$postmaterial_name_text=$this->input->post( 'material_name_text' );
		}
		
		if($postmaterial_name) {
			$getVendorsList = $this->Mrequests_Model->get_all_vendors($postmaterial_name);
			$counts = array_column($getVendorsList, 'price');
			$index = array_search(min($counts), $counts, true);
			$vendorIdMin = $getVendorsList[$index];
		}
		
		$mname = $postmaterial_name;
		$material_name = $postmaterial_name_text;
		$project = $this->input->post( 'project' );
		$project_id = $this->input->post( 'project_id' );
		$qty = $this->input->post('qty');
		$unit_type = $this->input->post('unit_type');
		$remarks = $this->input->post('remarks');
		$priority = $this->input->post('priority');
		
 		$params = array(
				'project_id' => $project_id,
				'project' => $project,
				'mname' => $mname,
				'material_name' => $material_name,
				'qty' => $qty,
				'unit_type' => $unit_type,
				'remarks' => $remarks,
				'priority' => $priority,
				'user_id' => $this->session->userdata( 'usr_id' ),
				'status' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
				'vendor_id'=> $vendorIdMin['vendorMaterialId'],
				'price' => $vendorIdMin ? ($vendorIdMin['price'] * $qty) : 0,
				'vendor_price' => $vendorIdMin ? $vendorIdMin['price'] : 0
			);
			
			$this->db->insert('material_req', $params );
			$material_id = $this->db->insert_id();
			//$number = $appconfig['matreq_series'] ? $appconfig['matreq_series'] : $material_id;
			
			$seriesid = $appconfig['matreq_prefix'].$material_id;
			$this->db->where('id', $material_id)->update( 'material_req', array('seriesid' => $seriesid ) );
			if (!is_dir('uploads/files/materialrequests/'.$material_id)) { 
				mkdir('./uploads/files/materialrequests/'.$material_id, 0777, true);
			}
		    $data = [];
			$count = count($_FILES['files']['name']);
			if($count > 0){
				for($i=0;$i<$count;$i++){
					if(!empty($_FILES['files']['name'][$i])){
					  $_FILES['file']['name'] = $_FILES['files']['name'][$i];
					  $_FILES['file']['type'] = $_FILES['files']['type'][$i];
					  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					  $_FILES['file']['error'] = $_FILES['files']['error'][$i];
					  $_FILES['file']['size'] = $_FILES['files']['size'][$i];
					  $config[ 'upload_path' ] = './uploads/files/materialrequests/'.$material_id.'';
					  $config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					  $config['max_size'] = '5000';
				      $config['file_name'] = $_FILES['files']['name'][$i]; 
					  $this->load->library('upload',$config); 
					  $this->upload->initialize($config); 
					  if($this->upload->do_upload('file')){  
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						$filetype = $uploadData['file_type'];
						$params=array();
						$params = array('material_req_id' => $material_id,
										'file_name' => $filename,
										'filetype' => $filetype
						);
						$this->db->insert( 'material_request_files', $params );
					  } 
				    }
			     }
			}
			$data['success'] = true;
			$data['message'] = "Material Request Added Successfully";
			$this->session->set_flashdata('success','Material Request Added Successfully');
			
			//Notification//
			$Notifyparams=array();
			$Notifyparams['staffList']=$employeeids;
			$Notifyparams['msg']=( '' .$seriesid.' '.lang('send').' By '. $this->session->staffname .'' );
			$Notifyparams['link']= base_url('mrequests/');
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
				'customer_id' => $vendorIdMin ? ($vendorIdMin['vendorMaterialId']) : 0,
				'number' => ($seriesid),
				'value' =>  $vendorIdMin ? $vendorIdMin['price'] : 0,
				'customer_name' => $material_name,
				'request_type'=> "leave",
				'first_levelinfo'=> ('QUANTITY '. - $qty),
				'second_levelinfo'=> ($this->input->post('project')),
				'target'=> base_url('mrequests/'),
				'request_type'=> "material"
			) );
			redirect('mrequests','refresh');
		}
	}
	
	function delete(){
		$id = $this->input->post('material_id');
		$this->db->delete( 'material_req', array( 'id' => $id ) );
		$this->session->set_flashdata('success',"Selected Material Request Deleted Successfully");
		$data = [];
		$data['success'] = true;
		$data['message'] = "Material Request Deleted Successfully";
		echo json_encode($data);
		redirect('mrequests','refresh');
	}
	
function get_request_data(){
	$id = $this->input->post('id');
	$response =$this->material_lib->material_popup($id);
	return $response;
}
	
function get_po_request(){
	$vendors = $this->input->post('vendors');
	foreach($vendors as $vendor) {
		$materialReID[] = $vendor['materialid'];
	}
	$this->session->set_userdata(array('material'=>$materialReID));
	exit();
}

function update(){
	$id = $this->input->post('material_id');
	$price = $this->input->post('unit_price');
	$status = $this->input->post('status');
	$quantity = $this->input->post('quantity');
	$vendor_price = $this->input->post('vendor_price');
	$vendor_id = $this->input->post('vendor_id');
	if($this->input->post('status')=='3'){
		$getdata=$this->db->get_where( 'material_req', array( 'material_req.id' => $id ) )->row_array();
		$getapprovals=$this->Approvals_Model->getapprovalsByType('mrequests');
		$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
		$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
		if($optionType =='price'){
			if($maxapproverLevel > ($quantity * $price)){
				$data=$this->Mrequests_Model->update_mreq_data($id,$price,$status,$vendor_id, $quantity, $vendor_price);
				$msg= "Selected Material Request Updated Successfully";
				$this->session->set_flashdata('success',$msg);
			}else{
				$data=array();
				$msg= "You donot have permission to approve this.";
				$this->session->set_flashdata('error',$msg);
			}
		}else{
			$data=$this->Mrequests_Model->update_mreq_data($id,$price,$status,$vendor_id, $quantity, $vendor_price);
			$msg= "Selected Material Request Updated Successfully";
			$this->session->set_flashdata('success',$msg);
		}
	}else{
		$data=$this->Mrequests_Model->update_mreq_data($id,$price,$status,$vendor_id, $quantity, $vendor_price);
		$msg= "Selected Material Request Updated Successfully";
		$this->session->set_flashdata('success',$msg);
	}
	echo json_encode($data);
	
	
	redirect('mrequests','refresh');
}

function update_status(){
		$statusid = $this->input->get('status');
		$relId = $this->input->get('relId');
		$params = array(
			'status' => $statusid				
		);				
		$response  = $this->Mrequests_Model->update_status( $relId, $params );
		echo json_encode($response);
		$this->session->set_flashdata('success', "Selected Material Request Updated Successfully");
		redirect('mrequests','refresh');
}
	
function img()
	{
	    
	    $id = $this->input->post('id');
		$image = $this->input->post('image');
	    echo "<img src='uploads/files/orequests/$id/$image' alt='staffavatar' width='auto' height='auto'>";
	}
		function pdf()
	{
	    
	    $id = $this->input->post('id');
		$image = $this->input->post('image');
	  echo "<object type='application/pdf' data='uploads/files/orequests/$id/$image' width='100%' height='500' style='height: 85vh;' id='pdffile'>No Support</object>";
	}
	function delete_file(){
	    
	    $image_name = $this->input->post('val');
	    $id = $this->input->post('id');
	    
	    $data = $this->Mrequests_Model->delete_other_files($image_name,$id);
	    echo json_encode($data); 
	    
	}
	function attachments($file) {
		if (is_file('./uploads/attachments/' . $file)) {
    		$this->load->helper('file');
    		$this->load->helper('download');
    		$data = file_get_contents('./uploads/attachments/' . $file);
    		force_download($file, $data);
    	} else {
    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
    		redirect('tickets/index');
    	}
	}

	function markas() {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $_POST[ 'name' ];
				$params = array(
					'ticket_id' => $_POST[ 'ticket_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$data['success'] = true;
				$data['message'] = lang('ticket').' '.lang('markas').' '.$name;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'all' ) ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tickets', 'own') ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($ticket) {
			if ( $this->Privileges_Model->check_privilege( 'tickets', 'delete' ) ) {
				if ( isset( $ticket[ 'id' ] ) ) {
					$this->Tickets_Model->delete_tickets( $id, get_number('tickets',$id,'ticket','ticket') );
					$data['success'] = true;
					$data['message'] = lang('ticket').' '.lang('deletemessage');
					
				} else {
					show_error( 'Eror' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
			echo json_encode($data);
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
	}

	function download_file($fileid, $filename, $folderid) {
		if (isset($fileid)) {
				if (is_file('./uploads/files/materialrequests/'.$folderid.'/'.$filename)) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/materialrequests/'.$folderid.'/'.$filename);
					
		    		force_download($filename, $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('mrequests');
		    	}
		}
	}
	
	function get_ticket( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'all' ) ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tickets', 'own') ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
		if($ticket) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			switch ( $ticket[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					break;
				case '2':
					$status = lang( 'inprogress' );
					break;
				case '3':
					$status = lang( 'answered' );
					break;
				case '4':
					$status = lang( 'closed' );
					break;
			};
			if ( $ticket[ 'type' ] == 0 ) {
				$customer = $ticket[ 'company' ];
			} else $customer = $ticket[ 'namesurname' ];
			$replies = $this->db->get_where( 'ticketreplies', array( 'ticket_id' => $id ) )->result_array();
			$data_ticketdetails = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'message' => $ticket[ 'message' ],
				'relation' => $ticket[ 'relation' ],
				'relation_id' => $ticket[ 'relation_id' ],
				'staff_id' => $ticket[ 'staff_id' ],
				'contact_id' => $ticket[ 'contact_id' ],
				'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
				'priority' => $priority,
				'priority_id' => $ticket[ 'priority' ],
				'lastreply' => $ticket[ 'lastreply' ]?(date(get_dateTimeFormat(),strtotime($ticket[ 'lastreply' ]))):lang('n_a'),
				'status' => $status,
				'status_id' => $ticket[ 'status_id' ],
				'customer_id' => $ticket[ 'customer_id' ],
				'department' => $ticket[ 'department' ],
				'opened_date' => date(get_dateTimeFormat(),strtotime($ticket[ 'date' ])),
				'last_reply_date' => $ticket[ 'lastreply' ]?(date(get_dateTimeFormat(),strtotime($ticket[ 'lastreply' ]))):lang('n_a'),
				'attachment' => $ticket[ 'attachment' ],
				'customer' => $customer,
				'assigned_staff_name' => $ticket[ 'staffmembername' ],
				'replies' => $replies,
				'ticket_number' => get_number('tickets', $ticket[ 'id' ], 'ticket','ticket'),
			);
			echo json_encode( $data_ticketdetails );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
	}
	
	function delete_mreq_file($mat_req_folder_id, $fileid, $filename) {
		if ( $this->Privileges_Model->check_privilege( 'mrequests', 'delete' ) ) {
			if (isset($fileid)) {
				$response = $this->db->delete( 'material_request_files', array( 'file_id' => $fileid ) );
				if (is_file('./uploads/files/materialrequests/' . $mat_req_folder_id.'/'.$filename)) {
					unlink('./uploads/files/materialrequests/' . $mat_req_folder_id.'/'.$filename);
				}
				if ($response) {
					$data['success'] = true;
					$data['message'] = lang('file'). ' '.lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = lang('errormessage');
				}
				echo json_encode($data);
			} else {
				redirect('mrequests');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
}