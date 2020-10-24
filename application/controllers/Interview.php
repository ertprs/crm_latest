<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Interview extends CIUIS_Controller {

	function index() {
		$this->load->model('Interview_Model');
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} else {
			$data[ 'title' ] = lang( 'interview' );
			$data[ 'candidates' ] = $this->Interview_Model->get_screened_candidates();
			//$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			//$data[ 'departments' ] = $this->Settings_Model->get_departments();
			$path = $this->uri->segment( 1 );
			if ( !$this->Privileges_Model->has_privilege( $path ) ) {
				$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
				redirect( 'panel/' );
				die;
			}
			$this->load->view( 'interview/index', $data );
		}
	} 

	function add() {
		$this->load->model('Interview_Model');
		if ( $this->Privileges_Model->check_privilege( 'interview', 'create' ) ) {
			$data[ 'title' ] = 'Schedule Interview';
			
				$candidate_id = $this->input->post( 'id' );
				$schedule_date = $this->input->post( 'schedule_date' );
				$from_time = $this->input->post( 'from_time' );
				$to_time = $this->input->post('to_time');
				$interview_taken_by  = $this->input->post( 'interview_taken_by' );
				$status = $this->input->post('status');
			
				
				
					$appconfig = get_appconfig();
					$params = array(
						'candidate_id' => $candidate_id,
						'schedule_date' => $schedule_date,
						'from_time' => $from_time,				
						'interview_taken_by' => $interview_taken_by,
						'to_time' => $to_time,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => $status,
						
					);
					$data = $this->db->insert( 'interview_schedule', $params );
					$candidate_id = $this->db->insert_id();
					
					echo json_encode($data);
					
				redirect('interview','refresh'); 
		}
		
		}
					
	

	function update(){
		$this->load->model('Interview_Model');
		$id = $this->input->post('id');
		$remarks = $this->input->post('remarks');
		$status = $this->input->post('status');
		$data = $this->Interview_Model->update_remarks($id,$remarks,$status);
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