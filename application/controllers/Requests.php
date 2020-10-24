<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Requests extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
			$this->load->model('Requests_Model');
			$this->load->model('Products_Model');
	
	if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} 
		
	}

	function index() {
		
		$this->load->model('Projects_Model');
		$path = $this->uri->segment( 3 );
		 if($path == 'app'){
			$status = 2;
		}
		else if($path == 'dec'){
			$status = 3;
		}else{
			$status = 1;
		}
		$data['projects']= $this->Projects_Model->get_all_projects();
		$data['products'] = $this->Products_Model->get_all_products();
		$data['user_id'] = $this->session->userdata( 'usr_id' );
		if($this->Privileges_Model->check_privilege( 'requests', 'all' ) ){
				$data['mrequests'] = $this->Requests_Model->get_all_mrequests($status);
				$data['app_count'] = $this->Requests_Model->get_appreq_count(2);
				$data['dec_count'] = $this->Requests_Model->get_decreq_count(3);
				$data['all_count'] = $this->Requests_Model->get_allreq_count(1);
		}
		else
			{
						
				$data['mrequests'] = $this->Requests_Model->get_user_mrequests($status,$data['user_id']);
				$data['app_count'] = $this->Requests_Model->get_user_appreq_count(2,$data['user_id']);
				$data['dec_count'] = $this->Requests_Model->get_user_decreq_count(3,$data['user_id']);
				$data['all_count'] = $this->Requests_Model->get_user_allreq_count(1,$data['user_id']);
						
				
			}
		$data[ 'title' ] = lang( 'requests' );  
		
		$this->load->view( 'requests/index', $data );
	}


	function create(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
		$mname = $this->input->post( 'material_name' );
		$project = $this->input->post( 'project' );
		//print_r($project); die;
		$project_id = $this->input->post( 'project_id' );
		$qty = $this->input->post('qty');
		$unit_type = $this->input->post('unit_type');
		$remarks = $this->input->post('remarks');
		$priority = $this->input->post('priority');
		
 		$params = array(
						'project_id' => $project_id,
						'project' => $project,
						'mname' => $mname,
						'qty' => $qty,
						'unit_type' => $unit_type,
						'remarks' => $remarks,
						'priority' => $priority,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' )
						
					);
					
					$this->db->insert('material_req', $params );
					$material_id = $this->db->insert_id();
					$data['success'] = true;
					$data['message'] = "Material Request Added Successfully";
			//echo json_encode($data);
				$this->session->set_flashdata('success','Material Request Added Successfully');
				redirect('requests','refresh');
		}
	}
	
	function delete($id){
		
		$request_id = $id;
		
		$this->db->delete( 'material_req', array( 'id' => $id ) );
		$this->session->set_flashdata('success',"Selected Material Request Deleted Successfully");
				redirect('requests','refresh');
	}
	
		
	function update(){
		$id = $this->input->post('material_id');
		$price = $this->input->post('unit_price');
		$status = $this->input->post('status');
		$data=$this->Requests_Model->update_mreq_data($id,$price,$status);
		echo json_encode($data);
		//$this->session->set_flashdata();
		$this->session->set_flashdata('success', "Selected Material Request Updated Successfully"); 

		redirect('requests','refresh');
       // echo json_encode($data);
    }
	
	function get_request_data(){
	
    $id = $this->input->get('id');

    $get_data= $this->Requests_Model->get_mreq_data($id);
    echo json_encode($get_data); 
    exit();
		
	}
	function get_product_data(){
		
		
		$id = $this->input->get('id');

    $get_data= $this->Requests_Model->get_prd_data($id);
	
    echo json_encode($get_data); 
    
		
	}
}