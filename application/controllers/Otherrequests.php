<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Otherrequests extends CIUIS_Controller {

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
		
	}

	function index() {
		
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
		$description = $this->input->post( 'description' );
		$qty = $this->input->post('qty');
 		$params = array(
						'description' => $description,
						'qty' => $qty,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'other_requests', $params );
					$oreq_id = $this->db->insert_id();
					$seriesid = "ORT-".$oreq_id;
					$this->db->where('id', $oreq_id)->update( 'other_requests', array('seriesid' => $seriesid ) );
		
			if (!is_dir('uploads/files/orequests/'.$oreq_id)) { 
					mkdir('./uploads/files/orequests/'.$oreq_id, 0777, true);
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
 // print_r($_FILES['files']['name'][$i]);
         $config[ 'upload_path' ] = './uploads/files/orequests/'.$oreq_id.'';
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
         // $config['max_size'] = '5000';
          $ext = explode(".",  $_FILES['file']['name']);
			            // $image_name = "Others-".$size.rand(0,5000000).".".end($ext);
          $config['file_name'] =  $_FILES['file']['size'].rand(0,5000000).".".end($ext);
  // print_r($config['file_name']); 
          $this->load->library('upload',$config); 
    
           if($this->upload->do_upload('file')){
			   
            $uploadData = $this->upload->data();
			//print_r($uploadData); 
            $filename = $uploadData['file_name'];
			$filetype = $uploadData['file_type'];
			$params = array('request_id' => $oreq_id,
							'file_name' => $filename,
							'filetype' => $filetype
			);
			$this->db->insert( 'other_request_files', $params );
   
             } 
        }
		
      }
	  
				//Notification//
				$Notifyparams=array();
				$Notifyparams['staffList']=$employeeids;
				$Notifyparams['msg']=( '' .$seriesid.' '.lang('send').' By '. $this->session->staffname .'' );
				$Notifyparams['link']= base_url('otherrequest/');
				$Notifyparams['staff_id']= '';
				$Notifyparams['img']=$this->session->staffavatar;
				$this->Notifications_Model->insertNotification($Notifyparams);
				$this->session->set_flashdata('success','Other Request Added Successfully');
				redirect('otherrequest','refresh'); 
		}
	}
	
	function img()
	{
	    
	    $id = $this->input->post('id');
	    $val = $this->input->post('val');
	    echo "<img src='uploads/files/orequests/$id/$val' alt='staffavatar' width='60%;' height='60%'>";
	}
		
	function update(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		
		$data=$this->Otherrequests_Model->update_status($id,$status);
		echo json_encode($data);
		//$this->session->set_flashdata();
		$this->session->set_flashdata('success', "Status  Updated Successfully"); 

		redirect('otherrequests','refresh');
       // echo json_encode($data);
    }
	function get_requests(){
		
	$user_id = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'otherrequests', 'all' ) ){
		
		$orequests = $this->Otherrequests_Model->get_all_orequests(0);
		}else{
			$orequests = $this->Otherrequests_Model->get_user_all_orequests(0,$user_id);
			
		}
		
		
		$requests_array = array();
		foreach($orequests as $res) {
			
		
			
			$requests_array[] = array(
			'id' => $res['id'],
			'description' => $res['description'],
			'qty' => $res['qty'],
			'status' => $res['status'],
			'files' => $res['files'],
			'created' => $res['created'],
			'staffavatar' => $res['staffavatar']
			
			
			
			);
		}
		echo json_encode($requests_array);
	}
	
}