<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Salaryrequests extends CIUIS_Controller {

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
		 if($path == 'app'){
			$status = 2;
		}
		else if($path == 'dec'){
			$status = 3;
		}else if($path == 'pend'){
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
		$data['maxvalue']=$this->Privileges_Model->has_approval('salaryrequests');
		$data[ 'title' ] = lang( 'salaryrequests' );  
		$data['pagename']='request';
		
		$this->load->view( 'salaryrequests/index', $data );
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
		$employee_id  = $this->input->post( 'employee_id' );
		$type_of_salary = $this->input->post( 'type_of_salary' );
		$from_date = date('Y-m-d',strtotime($this->input->post( 'from_date' )));
		$to_date = date('Y-m-d',strtotime($this->input->post( 'to_date' )));
		$amount = $this->input->post( 'amount' );
		$remarks = $this->input->post( 'remarks' );
		$pagename = $this->input->post('pagename');
	
 		
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_salary' => $type_of_salary,
						'from_date' => $from_date,
						'to_date' => $to_date,
						'amount' => $amount,
						'remarks' => $remarks,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'salary_requests', $params );
					$oreq_id = $this->db->insert_id();
					$seriesid = "SLY-".$oreq_id;
					$this->db->where('salary_id', $oreq_id)->update( 'salary_requests', array('seriesid' => $seriesid ) );
					//Notification//
					$Notifyparams=array();
					$Notifyparams['staffList']=$employee_id;
					$Notifyparams['msg']=( '' .$seriesid.' '.lang('send').' By '. $this->session->staffname .'' );
					$Notifyparams['link']= base_url('salaryrequests/');
					$Notifyparams['staff_id']= '';
					$Notifyparams['img']=$this->session->staffavatar;
					$this->Notifications_Model->insertNotification($Notifyparams);
					$staff = $this->Salaryrequests_Model->getstaffnamebyid($employee_id);
					$staffname = $this->session->staffname;
					$loggedinuserid = $this->session->usr_id;
					$staffavatar = $this->session->staffavatar;
					if($type_of_salary == 1){
						$type_of_salary  = "Monthy Advance";
					}else{
						$type_of_salary  = "Leave Salary";
					}
					$this->db->insert( 'estiimation_notifications', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $staffname .' req '.$seriesid),
						'staff_id' => $loggedinuserid,
						'perres' => $staffavatar,
						'customer_id' => $employee_id,
						'number' => ($seriesid),
						'first_levelinfo' => $type_of_salary,
						'value' => $amount,
						'customer_name' => $staff->staffname,
						'request_type'=> "salary",
						'target'=> base_url('salaryrequests/'),
					) );

				$this->session->set_flashdata('success','Salary Request Added Successfully');
				if($pagename=='request'){
					redirect('salaryrequests','refresh'); 
				}else{
				redirect('salaryrequests','refresh'); 
				}
				
		}
	}
	function update_salary(){
		$employee_id  = $this->input->post( 'employee_id' );
		$type_of_salary = $this->input->post( 'type_of_salary' );
		$from_date = date('Y-m-d',strtotime($this->input->post( 'from_date' )));
		$to_date = date('Y-m-d',strtotime($this->input->post( 'to_date' )));
		$amount = $this->input->post( 'amount' );
		$remarks = $this->input->post( 'remarks' );
		$pagename = $this->input->post('pagename');
	$salaryid = $this->input->post( 'salaryid' );
 		
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_salary' => $type_of_salary,
						'from_date' => $from_date,
						'to_date' => $to_date,
						'amount' => $amount,
						'remarks' => $remarks,
						'user_id' => $this->session->userdata( 'usr_id' )
						
						
					);
					$this->db->where( 'salary_id', $salaryid );
				$response = $this->db->update( 'salary_requests', $params );
				//echo $this->db->last_query();exit;
					redirect('salaryrequests');
	}
	
		
	function update(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		if($status==1){
			$status_name='Pending';
		}else if($status==2){
			$status_name='Approved';
		}else if($status==3){
			$status_name='Rejected';
		}
		
		
		$data=$this->Salaryrequests_Model->update_status($id,$status);
		
		$template = $this->Emails_Model->get_template('staff', 'quote_salary_leave');

					if ($template['status'] == 1) {
						$result=$this->Salaryrequests_Model->get_single_request($id);
						
						$staff_details= $this->Staff_Model->get_staff_details($result['employee_id']);
						$name=$staff_details[0]->staffname;
						$email=$staff_details[0]->email;
						$message_vars = array(
								
								'{staffname}' => $name,
								'{status}' => $status_name,
								
								
							);
							$subject = strtr($template['subject'], $message_vars);
							$message = strtr($template['message'], $message_vars);
							$param = array(
								'from_name' => $template['from_name'],
								'email' => $email,
								'subject' => $subject,
								'message' => $message,
								'created' => date( "Y.m.d H:i:s" )
							);
							if ($this->input->post( 'email' )) {
								$this->db->insert( 'email_queue', $param );
							}
							$this->load->library('mail');
							$this->mail->send_email($email, $template['from_name'], $subject, $message);
					}
		echo json_encode($data);
		//$this->session->set_flashdata();
		$this->session->set_flashdata('success', "Status  Updated Successfully"); 

		redirect('salaryrequests','refresh');
       // echo json_encode($data);
    }
	
	function showsalaryform($id){
		$data['id']=$id;
		$data['result']=$result=$this->Salaryrequests_Model->get_single_request($id);
		//echo "<pre>";
		//print_r($result);
		$data['employees'] = $this->Staff_Model->get_all_staff();
		$this->load->view( 'salaryrequests/update_salary',$data);
	}
	
	function delete_request()
	{
		$id = $this->input->post('id');
		$response = $this->db->delete( 'salary_requests', array( 'salary_id' => $id ) );
		echo json_encode(array('success'=>'true'));
	}
	
	
}