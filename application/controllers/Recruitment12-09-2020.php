<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Recruitment extends CIUIS_Controller {

	function index() {
		$this->load->model('Recruitment_Model');
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} else {
			$data[ 'title' ] = lang( 'candidates' );
			$data[ 'candidates' ] = $this->Recruitment_Model->get_all_candidates();
			//$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			//$data[ 'departments' ] = $this->Settings_Model->get_departments();
			$path = $this->uri->segment( 1 );
			if ( !$this->Privileges_Model->has_privilege( $path ) ) {
				$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
				redirect( 'panel/' );
				die;
			}
			$this->load->view( 'recruitment/index', $data );
		}
	} 

	function createcandidate() {
		$this->load->model('Recruitment_Model');
		if ( $this->Privileges_Model->check_privilege( 'recruitment', 'create' ) ) {
			$data[ 'title' ] = 'Create Candidates';
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$applicant_name = $this->input->post( 'applicant_name' );
				$position_applied_for = $this->input->post( 'position_applied_for' );
				$status = $this->input->post( 'status' );
				$entered_date = $this->input->post('entered_date');
				$location = $this->input->post( 'location' );
			
				
				
					$appconfig = get_appconfig();
					$params = array(
						'applicant_name' => $applicant_name,
						'position_applied_for' => $position_applied_for,
						'status' => $status,				
						'entered_date' => $entered_date,
						'location' => $location,
						'user_id' => $this->session->userdata( 'usr_id' ),
						
					);
					$this->db->insert( 'recruitment_candidates', $params );
					$candidate_id = $this->db->insert_id();
					
					if (!is_dir('uploads/files/candidates/'.$candidate_id)) { 
					mkdir('./uploads/files/candidates/'.$candidate_id, 0777, true);
				}
				    
   
     
    
     
    
        if(!empty($_FILES['file']['name'])){

          $_FILES['file']['name'] = $_FILES['file']['name'];
          $_FILES['file']['type'] = $_FILES['file']['type'];
          $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
          $_FILES['file']['error'] = $_FILES['file']['error'];
          $_FILES['file']['size'] = $_FILES['file']['size'];
  
         $config[ 'upload_path' ] = './uploads/files/candidates/'.$candidate_id.'';
          $config['allowed_types'] = 'docx|doc|pdf';
          //$config['max_size'] = '20000';
          $config['file_name'] = $_FILES['file']['name'];
   
          $this->load->library('upload',$config); 
    
           if($this->upload->do_upload('file')){
			   
            $uploadData = $this->upload->data();
			
            $filename = $uploadData['file_name'];
			$filetype = $uploadData['file_type'];
		
			
			$this->Recruitment_Model->update_file($candidate_id,$filename,$filetype);
   
             } 
        
		
      }
					
				redirect('recruitment','refresh'); 
		}
		
		}
					
	}

	function update(){
		$this->load->model('Recruitment_Model');
		$id = $this->input->post('id');
		$remarks = $this->input->post('remarks');
		$status = $this->input->post('status');
		$data = $this->Recruitment_Model->update_remarks($id,$remarks,$status);
		echo json_encode($data);
		redirect('recruitment','refresh');
	}
	
	function update_status(){
		
		$this->load->model('Recruitment_Model');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data = $this->Recruitment_Model->update_candidate_status($id,$status);
		echo json_encode($data); 
		redirect('recruitment','refresh');
		
	}
}