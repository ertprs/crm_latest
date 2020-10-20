<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Leaverequests extends CIUIS_Controller {

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
			$this->load->model('Approvals_Model');
			
	if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} 
		
	}
	
	function index(){
		
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
		$lrequests=$this->Leaverequests_Model->get_all_lrequests($status);
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
		$lrequests= $this->Leaverequests_Model->get_user_all_lrequests($status,$data['user_id']);
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
		}else {
			$data['brequests'] = $this->Billrequests_Model->get_all_brequests($status,$data['user_id']);
		}
		$data[ 'title' ] = lang( 'leaverequests' );	
		$approvalAccess=$this->Privileges_Model->has_approval_access('leaverequests');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='no_of_days';
		if($approvalAccess['type']=='level'){
			$data['lrequests']=check_approval_data($lrequests,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$data['lrequests']=check_approval_data($lrequests,$maxvalue,$comperKey);
		}else{
			$data['lrequests']=check_approval_data($lrequests,$maxvalue,'NotAccess');
		}		
		if($url=='filter'){
			$this->load->view( 'leaverequests/filter_leaverequest', $data );
		}else{
		  $this->load->view( 'leaverequests/leaverequest', $data );
		}
	}
	
	function getallstatusresult()
	{
		if($this->Privileges_Model->check_privilege( 'leaverequests', 'all' ) ){
		
		$data['open_count'] =$open_count= $this->Leaverequests_Model->get_appreq_count(1);
		$data['app_count'] =$app_count=  $this->Leaverequests_Model->get_appreq_count(2);
		$data['dec_count'] =$dec_count=  $this->Leaverequests_Model->get_decreq_count(4);
		$data['pend_count'] =$pend_count=  $this->Leaverequests_Model->get_pendreq_count(3);
		$data['all_count'] =$all_count=  $this->Leaverequests_Model->get_allreq_count();
				
		}else{
		
		$data['open_count'] =$open_count=  $this->Leaverequests_Model->get_user_appreq_count(1,$data['user_id']);
			$data['app_count'] =$app_count=  $this->Leaverequests_Model->get_user_appreq_count(2,$data['user_id']);
		$data['dec_count'] =$dec_count=  $this->Leaverequests_Model->get_user_decreq_count(4,$data['user_id']);
		$data['pend_count'] =$pend_count=  $this->Leaverequests_Model->get_user_pendreq_count(3,$data['user_id']);
		$data['all_count'] =$all_count=  $this->Leaverequests_Model->get_user_allreq_count($data['user_id']);
	
		}
		echo json_encode(array('appcnt'=>count($app_count),'dec_count'=>count($dec_count),'pend_count'=>count($pend_count),'all_count'=>count($all_count),'open_count'=>count($open_count)));		
	}
   
	function showleaveform($id)
	{
		$data['id']=$id;
		$oreq= $this->Leaverequests_Model->get_leave_data($id);
		$approvalAccess=$this->Privileges_Model->has_approval_access('leaverequests');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='no_of_days';
		if($approvalAccess['type']=='level'){
			$data['oreq']=check_approval_data_ForId($oreq,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$data['oreq']=check_approval_data_ForId($oreq,$maxvalue,$comperKey);
		}else{
			$data['oreq']=check_approval_data_ForId($oreq,$maxvalue,'NotAccess');
		}
		$this->load->view( 'leaverequests/update_leave',$data);
		
	}
	
	function delete_request()
	{
		$id = $this->input->post('id');
		$response = $this->db->delete( 'leave_requests', array( 'leave_id' => $id ) );
		echo json_encode(array('success'=>'true'));
	}


	function create(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {	
		$employee_id  = $this->input->post( 'employee_id' );
		$type_of_leave = $this->input->post( 'type_of_leave' );
		$leave_start_date = date('Y-m-d',strtotime($this->input->post( 'leave_start_date' )));
		$rejoin_date =  date('Y-m-d',strtotime($this->input->post( 'rejoin_date' )));
		$no_of_days = $this->input->post( 'no_of_days' );
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_leave' => $type_of_leave,
						'leave_start_date' => $leave_start_date,
						'rejoin_date' => $rejoin_date,
						'no_of_days' => $no_of_days,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 3,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
				$this->db->insert( 'leave_requests', $params );
				$leave_id = $this->db->insert_id();
				$staff = $this->Leaverequests_Model->getstaffnamebyid($employee_id);
				$staffname = $this->session->staffname;
				$loggedinuserid = $this->session->usr_id;
				$staffavatar = $this->session->staffavatar;
				$this->db->insert( 'estiimation_notifications', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $staffname .' req '.'LVE REQ-'. $leave_id),
					'staff_id' => $loggedinuserid,
					'perres' => $staffavatar,
					'customer_id' => $employee_id,
					'number' => ('LVE REQ - '. $leave_id ),
					'first_levelinfo' => $type_of_leave,
					'value' => $no_of_days,
					'customer_name' => $staff->staffname,
					'request_type'=> "leave"
				) );
				$this->session->set_flashdata('success','Leave Request Added Successfully');
				echo json_encode(array('success'=>'true'));
		}
	}
	
	
		
	function update(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$method_of_leave = $this->input->post('method_of_leave');
		$payment_type = $this->input->post('payment_type');
		$leave_start_date = date('Y-m-d',strtotime($this->input->post('leave_start_date')));
		$rejoin_date = date('Y-m-d',strtotime($this->input->post('rejoin_date')));
		$no_of_days = $this->input->post('no_of_days');
		if($this->input->post('status')=='2'){
			$getdata=$this->db->get_where( 'leave_requests', array( 'leave_requests.leave_id' => $id ) )->row_array();
			$getapprovals=$this->Approvals_Model->getapprovalsByType('leaverequests');
			$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
			$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
			if($optionType=='level'){
				if($maxapproverLevel==$getdata['approve_level']){
					$data=$this->Leaverequests_Model->update_status($id,$status,$method_of_leave,$payment_type,$leave_start_date,$rejoin_date,$no_of_days);
				}else{
					$currentLevel=$getdata['approve_level']+1;			
					$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array('approve_level' => $currentLevel)) ;
					$data=$this->Leaverequests_Model->update_status($id,$status,$method_of_leave,$payment_type,$leave_start_date,$rejoin_date,$no_of_days);
				}
			}else if($optionType=='price'){
				$data=$this->Leaverequests_Model->update_status($id,$status,$method_of_leave,$payment_type,$leave_start_date,$rejoin_date,$no_of_days);
			}
		}else{
			$data=$this->Leaverequests_Model->update_status($id,$status,$method_of_leave,$payment_type,$leave_start_date,$rejoin_date,$no_of_days);
		}
				$template = $this->Emails_Model->get_template('staff', 'quote__leave');

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
		$this->session->set_flashdata('success', "Status  Updated Successfully"); 
		redirect('leaverequests','refresh');
    }
	
	function update_status()
	{
		$response='';
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$payment_type  = $this->input->post('payment_type');
		$ls_date = $this->input->post('ls_date');
		$rj_date = $this->input->post('rj_date');
		$emp_id = $this->input->post('emp_id');
		$days = $this->input->post('days');
		$leave_type = $this->input->post('leave_type');
		
		
			
		if($this->input->post('status')=='2'){
			$getdata=$this->db->get_where( 'leave_requests', array( 'leave_requests.leave_id' => $id ) )->row_array();
			$getapprovals=$this->Approvals_Model->getapprovalsByType('leaverequests');
			$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
			$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
			if($optionType=='level'){
				if($maxapproverLevel==$getdata['approve_level']){
					$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array( 'status' => $status, 'payment_type' => $payment_type)) ;
					
					$params = array('staff_id' => $emp_id,
					                'leave_start_date' => 	$ls_date,
					                'rejoin_date' => $rj_date,
					                'no_leave' => $days,
					                'payment_type' => $payment_type,
					                'type_of_leave' => $leave_type
					                 );
					$this->db->insert( 'staff_leaves', $params );
					
					$dateStart = $ls_date;
$dateEnd = $rj_date;
$current_date = $dateStart;
while(strtotime($current_date) < strtotime($dateEnd))
{
 // echo $current_date."<br>";
 $year = date('Y',strtotime($current_date));
 $month = (int)date('m',strtotime($current_date));
 $day = (int)date('d',strtotime($current_date));
 
 $params1 = array('empl_id' => $emp_id,
                 'month' => $month,
                 'year' => $year,
                 'day' => $day,
                 'hour' => '0',
                 'min' => '0',
                 'sec' => '0',
                 'type' => 'in',
                 'time' => '00:00:00',
                 'punch_date' => $current_date,
                 'payment_type' => $payment_type,
				 'type_of_leave' => $leave_type
                 
                );
 	$this->db->insert( 'attendance_log', $params1 );
 	
 	$params2 = array('empl_id' => $emp_id,
                 'month' => $month,
                 'year' => $year,
                 'day' => $day,
                 'hour' => '0',
                 'min' => '0',
                 'sec' => '0',
                 'type' => 'out',
                 'time' => '00:00:00',
                 'punch_date' => $current_date,
                  'payment_type' => $payment_type,
					'type_of_leave' => $leave_type
                );
                
 	$this->db->insert( 'attendance_log', $params2 );
 	
  $current_date= date("Y-m-d",strtotime("+1 day",strtotime($current_date)));
}   
				}else{
					$currentLevel=$getdata['approve_level']+1;
					$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array('approve_level' => $currentLevel,'status' =>'1', 'payment_type' => $payment_type)) ;
				}
			}else if($optionType=='price'){
				$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array( 'status' => $status, 'payment_type' => $payment_type)) ;
				
					$params = array('staff_id' => $emp_id,
					                'leave_start_date' => 	$ls_date,
					                'rejoin_date' => $rj_date,
					                'no_leave' => $days,
					                'payment_type' => $payment_type,
					                'type_of_leave' => $leave_type
					                 );
					$this->db->insert( 'staff_leaves', $params );
					
					$dateStart = $ls_date;
$dateEnd = $rj_date;
$current_date = $dateStart;
while(strtotime($current_date) < strtotime($dateEnd))
{
 // echo $current_date."<br>";
 $year = date('Y',strtotime($current_date));
 $month = (int)date('m',strtotime($current_date));
 $day = (int)date('d',strtotime($current_date));
 
 $params1 = array('empl_id' => $emp_id,
                 'month' => $month,
                 'year' => $year,
                 'day' => $day,
                 'hour' => '0',
                 'min' => '0',
                 'sec' => '0',
                 'type' => 'in',
                 'time' => '00:00:00',
                 'punch_date' => $current_date,
                 'payment_type' => $payment_type,
				 'type_of_leave' => $leave_type
                 
                );
 	$this->db->insert( 'attendance_log', $params1 );
 	
 	$params2 = array('empl_id' => $emp_id,
                 'month' => $month,
                 'year' => $year,
                 'day' => $day,
                 'hour' => '0',
                 'min' => '0',
                 'sec' => '0',
                 'type' => 'out',
                 'time' => '00:00:00',
                 'punch_date' => $current_date,
                  'payment_type' => $payment_type,
					'type_of_leave' => $leave_type
                );
                
 	$this->db->insert( 'attendance_log', $params2 );
 	
  $current_date= date("Y-m-d",strtotime("+1 day",strtotime($current_date)));
}   
				
			
			}
		}else{
			$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array( 'status' => $status, 'payment_type' => $payment_type)) ;
		}
		
		echo json_encode($response);
	}
	
	function update_payment()
	{
		$id = $this->input->post('id');
		$payment_type = $this->input->post('payment_type');
		$response = $this->db->where( 'leave_id', $id )->update( 'leave_requests', array( 'payment_type' => $payment_type)) ;
		echo json_encode($response);
	}
}