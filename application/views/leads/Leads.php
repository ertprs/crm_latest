<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Leads extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index($search='') { 
		$data[ 'title' ] = lang( 'leads' );
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$data[ 'tlh' ] = $this->db->count_all( 'leads' );
			$data[ 'tcl' ] = $this->Report_Model->tcl();
			$data[ 'tll' ] = $this->Report_Model->tll();
			$data[ 'tjl' ] = $this->Report_Model->tjl();
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$leads = $this->Leads_Model->get_all_leads_by_privileges($this->session->usr_id);
			$data[ 'tlh' ] = sizeof($leads);
			$data[ 'tcl' ] = $this->Report_Model->tcl($this->session->usr_id);
			$data[ 'tll' ] = $this->Report_Model->tll($this->session->usr_id);
			$data[ 'tjl' ] = $this->Report_Model->tjl($this->session->usr_id);
		} 
			$where=" leads.id <>''";
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		//$data['salesstaffs'] = $this->Leads_Model->get_all_sales_leads();
		if ( !if_admin ) {
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads_for_admin($where);
			$data[ 'openLeads' ] = $this->Leads_Model->get_leads_count("status='1' and ".$where);
			$data[ 'chaseLeads' ] = $this->Leads_Model->get_leads_count("status='6' and ".$where);
			$data[ 'convertedLeads' ] = $this->Leads_Model->get_leads_count("status='7' and ".$where);
			$data[ 'ecfollowupLeads' ] = $this->Leads_Model->get_leads_count("(status='2' OR status='3') and ".$where);
			//$data[ 'cfollowupLeads' ] = $this->Leads_Model->get_leads_count("status='3' and ".$where);
			$data[ 'lostfollowupLeads' ] = $this->Leads_Model->get_leads_count("status='8' and ".$where);
		} else {
			$userId=$this->session->userdata('usr_id');
			$data[ 'openLeads' ] = $this->Leads_Model->get_leads_count("status='1' AND assigned_id='".$userId."' and ".$where);
			$data[ 'chaseLeads' ] = $this->Leads_Model->get_leads_count("status='6' AND assigned_id='".$userId."' and ".$where);
			$data[ 'convertedLeads' ] = $this->Leads_Model->get_leads_count("status='7' AND assigned_id='".$userId."' and ".$where);
			$data[ 'ecfollowupLeads' ] = $this->Leads_Model->get_leads_count("(status='2' OR status='3') AND assigned_id='".$userId."' and ".$where);
			//$data[ 'cfollowupLeads' ] = $this->Leads_Model->get_leads_count("status='3' AND assigned_id='".$userId."' and ".$where);
			$data[ 'lostfollowupLeads' ] = $this->Leads_Model->get_leads_count("status='8' AND assigned_id='".$userId."' and ".$where);
			$data[ 'leads' ] = $this->Leads_Model->get_all_leads($where);
		};
		$this->load->view( 'leads/index', $data );
	} 

	function forms() {
		$data['title'] = lang('leadsforms');
		$this->load->view( 'forms/index', $data);
	}

	function form($id) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$check = $this->Leads_Model->get_weblead($id);
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$check = $this->Leads_Model->get_weblead($id,$this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		if($check) {
			if (isset($id)) {
				$data['formId'] = $check['id'];
				$data['token'] = $check['token'];
				$data['submit'] = $check['submit_text'];
				$data['title'] = lang('leadsforms');
				$this->load->view( 'forms/form', $data);
			} else {
				redirect(base_url('leads'));
			}
		} else {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function get_weblead($id) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$form = $this->Leads_Model->get_weblead($id);
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$form = $this->Leads_Model->get_weblead($id,$this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		if($form) {
			if ($form['duplicate'] == '1') {
				$duplicate = true;
			} else {
				$duplicate = false;
			}
			if ($form['notification'] == '1') {
				$notification = true;
			} else {
				$notification = false;
			}
			if ($form['status'] == '1') {
				$status = true;
			} else {
				$status = false;
			}
			$data = array(
				'name' => $form['name'],
				'assigned_id' => $form['assigned_id'],
				'status_id' => $form['lead_status'],
				'source_id' => $form['lead_source'],
				'submit_text' => $form['submit_text'],
				'success_message' => $form['success_message'],
				'data' => $form['form_data'],
				'token' => $form['token'],
				'duplicate' => $duplicate,
				'notification' => $notification,
				'status' => $status
			);
			echo json_encode($data);
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function add_weblead_form() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$assigned_id = $this->input->post( 'assigned_id' );
				$status_id = $this->input->post( 'status_id' );
				$source_id = $this->input->post( 'source_id' );
				$submit_text = $this->input->post( 'submit_text' );
				$success_message = $this->input->post( 'success_message' );

				$hasError = false;
				if ($this->input->post('duplicate') == 'true') {
					$duplicate = '1';
				} else {
					$duplicate = '0';
				}
				if ($this->input->post( 'notification' ) == 'true') {
					$notification = '1';
				} else {
					$notification = '0';
				}
				if ($this->input->post( 'status' ) == 'true') {
					$status = '1';
				} else {
					$status = '0';
				}

				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($assigned_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned');
				} else if ($status_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
				} else if ($source_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('source');
				} else if ($success_message == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('message_after_success');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'token' => md5(uniqid()),
						'name' => $name,
						'assigned_id' => $assigned_id,
						'lead_status' => $status_id,
						'lead_source' => $source_id,
						'form_data' => '[{"label":"Name","type":"textfield","key":"lName","input":true,"tableView":true},{"label":"E-Mail","type":"email","key":"lEmail","input":true,"tableView":true},{"label":"Phone","type":"number","title":"Phone","key":"lPhone","input":true,"tableView":true},{"label":"Description","isUploadEnabled":false,"type":"textarea","key":"lDescription","input":true,"tableView":true},{"label":"Submit","type":"button","key":"lSubmit","input":true,"tableView":true}]',
						'submit_text' => $submit_text,
						'success_message' => $success_message,
						'duplicate' => $duplicate,
						'notification' => $notification,
						'created' => date('Y-m-d H:i:s'),
						'status' => $status,
					);
					$weblead_id = $this->Leads_Model->create_weblead_form( $params );
					if ($weblead_id) {
						$data['success'] = true;
						$data['message'] = lang('weblead').' '.lang('createmessage');
						$data['id'] = $weblead_id;
						echo json_encode($data);
					} else {
						$data['success'] = false;
						$data['message'] = lang('errormessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function save_weblead_form($id) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$assigned_id = $this->input->post( 'assigned_id' );
				$status_id = $this->input->post( 'status_id' );
				$source_id = $this->input->post( 'source_id' );
				$submit_text = $this->input->post( 'submit_text' );
				$success_message = $this->input->post( 'success_message' );

				$hasError = false;
				if ($this->input->post('duplicate') == 'true') {
					$duplicate = '1';
				} else {
					$duplicate = '0';
				}
				if ($this->input->post( 'notification' ) == 'true') {
					$notification = '1';
				} else {
					$notification = '0';
				}
				if ($this->input->post( 'status' ) == 'true') {
					$status = '1';
				} else {
					$status = '0';
				}

				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($assigned_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned');
				} else if ($status_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
				} else if ($source_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('source');
				} else if ($success_message == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('message_after_success');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'name' => $name,
						'assigned_id' => $assigned_id,
						'lead_status' => $status_id,
						'lead_source' => $source_id,
						'submit_text' => $submit_text,
						'success_message' => $success_message,
						'duplicate' => $duplicate,
						'notification' => $notification,
						'status' => $status,
					);
					$weblead_id = $this->Leads_Model->update_weblead_form($id, $params);
					if ($weblead_id) {
						$data['success'] = true;
						$data['message'] = lang('weblead').' '.lang('updatemessage');
						$data['id'] = $weblead_id;
						echo json_encode($data);
					} else {
						$data['success'] = false;
						$data['message'] = lang('errormessage');
						echo json_encode($data);
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function save_weblead_components($id) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$weblead_id = $this->db->where('id', $id)->update('webleads', array('form_data' => $this->input->post('components', FALSE)));
				if ($weblead_id) {
					$data['success'] = true;
					$data['message'] = lang('weblead').' '.lang('updatemessage');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = lang('errormessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function change_weblead_status($id) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				if ($this->input->post( 'status' ) == 'true') {
					$status = '1';
				} else {
					$status = '0';
				}
				$weblead_id = $this->db->where( 'id', $id )->update( 'webleads', array( 'status' => $status ) );
				if ($weblead_id) {
					$data['success'] = true;
					$data['message'] = lang('statuschanged');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = lang('errormessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function webleads() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$leads = $this->Leads_Model->get_all_web_leads_for_admin();
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$leads = $this->Leads_Model->get_all_web_leads();
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		$data_leads = array();
		foreach ( $leads as $lead ) {
			if ($lead['formstatus'] == '1') {
				$status = true;
			} else {
				$status = false;
			}
			$data_leads[] = array(
				'id' => $lead[ 'id' ],
				'total_submissions' => $this->db->get_where('leads', array('weblead' => $lead[ 'id' ]))->num_rows(),
				'name' => $lead[ 'name' ],
				'statusname' => $lead[ 'statusname' ],
				'sourcename' => $lead[ 'sourcename' ],
				'assigned' => $lead[ 'leadassigned' ],
				'avatar' => $lead[ 'assignedavatar' ],
				'createddate' => $lead[ 'created' ],
				'status' => $status
			);
		};
		echo json_encode($data_leads);
	}

	function delete_web_form( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'delete' ) ) {
			$form = $this->Leads_Model->get_weblead($id);
			if ( isset( $form[ 'id' ] ) ) {
				$this->Leads_Model->delete_web_form( $id );
				$data['success'] = true;
				$data['message'] = lang('weblead') . ' ' .lang('deletemessage');
				echo json_encode($data);
			} else {
				$data['success'] = false;
				$data['message'] = lang('web_lead_not_found');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$title = $this->input->post('title');
				$date_contacted = $this->input->post('date_contacted');
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$country_id = $this->input->post('country_id');
				$groupid = $this->input->post('group_id');
				$assigned = $this->input->post('assigned');
				$status = $this->input->post('status');
				$source = $this->input->post('source');
				$description = $this->input->post('description');
				$phone = $this->input->post('phone');
				$mobile = $this->input->post('mobile');
				$type = $this->input->post( 'type' );
				$data['message'] = '';
				$hasError = false;
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($assigned == '' && $type == 1) {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned'). ' ' .lang('staff');
				} else if ($groupid == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('businesstype');
				} else if ($status == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
				} else if ($source == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('source');
				} else if ($country_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('country');
				}  else if ($date_contacted == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('date_contacted');
				}
				else if($phone == ''  && $email == '' && $mobile == ''){
				    $hasError = true;
					$data['message'] = 'Please enter either phone number or Mobile number or contact person mail id';
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'date_contacted' => $this->input->post( 'date_contacted' ),
						'type' => $this->input->post( 'type' ),
						'name' => $this->input->post( 'name' ),
						'title' => $this->input->post( 'title' ),
						'company' => $this->input->post( 'company' ),
						'companyemail' => $this->input->post( 'companyemail' ),
						'description' => $this->input->post( 'description' ),
						'country_id' => $this->input->post( 'country_id' ),
						'zip' => $this->input->post( 'zip' ),
						'city' => $this->input->post( 'city' ),
						'state_id' => $this->input->post( 'state_id' ),
						'address' => $this->input->post( 'address' ),
						'email' => $this->input->post( 'email' ),
						'website' => $this->input->post( 'website' ),
						'phone' => $this->input->post( 'phone' ),
						'mobile' => $this->input->post( 'mobile' ),
						'assigned_id' => $this->input->post( 'assigned' ),
						'source' => $this->input->post( 'source' ),
						'groupid' => $this->input->post( 'group_id' ),
						'public' => $this->input->post( 'public' ),
						'dateassigned' => date( 'Y-m-d H:i:s' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'status' => $this->input->post( 'status' ),
						'lead_status_id' => '1',
					);
					$lead_id = $this->Leads_Model->add_lead( $params );
					// Custom Field Post
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'lead', $lead_id );
					}
					// Custom Field Post
					$this->db->insert( 'tags', array(
						'relation_type' => 'lead',
						'relation' => $lead_id,
						'data' => $this->input->post( 'tags' )
					) );

					$template = $this->Emails_Model->get_template('lead', 'lead_assigned');
					if ($template['status'] == 1) {
						$lead = $this->Leads_Model->get_lead( $lead_id );
						$lead_url = '' . base_url( 'leads/lead/' . $lead_id . '' ) . '';
						$message_vars = array(
							'{lead_name}' => $this->input->post( 'name' ),
							'{lead_email}' => $this->input->post( 'email' ),
							'{lead_url}' => $lead_url,
							'{lead_assigned_staff}' => $lead['leadassigned'],
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $lead['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($lead['staffemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$template = $this->Emails_Model->get_template('lead', 'lead_submitted');
					if ($template['status'] == 1) {
						$lead = $this->Leads_Model->get_lead( $lead_id );
						$message_vars = array(
							'{lead_name}' => $this->input->post( 'name' ),
							'{lead_email}' => $this->input->post( 'email' ),
							'{lead_assigned_staff}' => $lead['leadassigned'],
							'{email_signature}' => $template['from_name'],
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);
						$param = array(
							'from_name' => $template['from_name'],
							'email' => $lead['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($lead['staffemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$data['id'] = $lead_id;
					if($appconfig['lead_series']){
						$lead_number = $appconfig['lead_series'];
						$lead_number = $lead_number + 1 ;
						$this->Settings_Model->increment_series('lead_series',$lead_number);
					}
					$data['message'] = lang('lead').' '. lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function update( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$data[ 'lead' ] = $this->Leads_Model->get_lead_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$data[ 'lead' ] = $this->Leads_Model->get_lead_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		if($data[ 'lead' ]) {
			if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
				if ( isset( $data[ 'lead' ][ 'id' ] ) ) {
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
						$title = $this->input->post('title');
						$name = $this->input->post('name');
						$email = $this->input->post('email');
						$country_id = $this->input->post('country_id');
						$assigned = $this->input->post('assigned_id');
						$groupid = $this->input->post( 'group_id' );
						$status = $this->input->post('status');
						$source = $this->input->post('source');
						$phone = $this->input->post('phone');
						$mobile = $this->input->post('mobile');
						$description = $this->input->post('description');
						$data['message'] = '';
						$hasError = false;
						
						if ($name == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('name');
						} else if ($assigned == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned'). ' ' .lang('staff');
						} else if($groupid == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('businesstype');
						} else if ($status == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
						} else if ($source == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('source');
						}  else if ($country_id == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('country');
						} 
						else if($phone == '' && $email == '' && $mobile == ''){
						    	$hasError = true;
							$data['message'] = "Please enter either phone number or email";
							$data['message'] = "Please enter either phone number or mobile number or email";
						    
						} else if($status != '' && $data[ 'lead' ]['status'] != $status) {
							if ($this->Leads_Model->isCustomerExists($id) == TRUE) {
								$hasError = true;
								$data['message'] = lang('Lead is already converted and has a customer existing. Please delete the cutsomer and then update');
							} else {
								if($data[ 'lead' ]['status'] == '7') {
									$this->db->where( 'id', $id )->update( 'leads', array('dateconverted' => null ) );
								}
							}
						}
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						}
						if (!$hasError) {
							$params = array(
								//'created' => date( 'Y-m-d H:i:s' ),
								//'date_contacted' => $this->input->post( 'date_contacted' ),
								'type' => $this->input->post( 'type' ),
								'name' => $this->input->post( 'name' ),
								'title' => $this->input->post( 'title' ),
								'company' => $this->input->post( 'company' ),
								'description' => $this->input->post( 'description' ),
								'country_id' => $this->input->post( 'country_id' ),
								'zip' => $this->input->post( 'zip' ),
								'city' => $this->input->post( 'city' ),
								'state_id' => $this->input->post( 'state_id' ),
								'address' => $this->input->post( 'address' ),
								'email' => $this->input->post( 'email' ),
								'companyemail' => $this->input->post( 'companyemail' ),
								'groupid' => $this->input->post( 'group_id' ),
								'website' => $this->input->post( 'website' ),
								'phone' => $this->input->post( 'phone' ),
								'mobile' => $this->input->post( 'mobile' ),
								'assigned_id' => $this->input->post( 'assigned_id' ),
								'junk' => $this->input->post( 'junk' ),
								'lost' => $this->input->post( 'lost' ),
								'source' => $this->input->post( 'source' ),
								'public' => $this->input->post( 'public' ),
								'dateassigned' => date( 'Y-m-d H:i:s' ),
								'staff_id' => $this->session->userdata( 'usr_id' ),
								'status' => $this->input->post( 'status' ),
							);
							$this->Leads_Model->update_lead( $id, $params );
							// Custom Field Post
							if ( $this->input->post( 'custom_fields' ) ) {
								$custom_fields = array(
									'custom_fields' => $this->input->post( 'custom_fields' )
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'lead', $id );
							}
							$data['message'] = lang('lead').' '.lang('updatemessage');
							$data['success'] = true;
							echo json_encode($data);
						}
					} else {
						redirect( 'leads/index' );
					}
				} else {
					show_error( 'The lead you are trying to update does not exist.' );
				}
			} else {
				$data['message'] = lang('you_dont_have_permission');
				$data['success'] = false;
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function lead( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		if($lead) {
			$data[ 'title' ] = $lead[ 'leadname' ];
			$data[ 'lead' ] = $lead;
			$this->load->view( 'leads/lead', $data );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function convert( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			$lead = $this->Leads_Model->get_lead( $id );
			$settings = $this->Settings_Model->get_settings_ciuis();
			if ( $lead[ 'dateconverted' ] != null ) {
				$data['success'] = false;
				$data['message'] = lang('leadalreadyconverted');
				echo json_encode($data);
			} else {
				$params = array(
					'staff_id' => $lead[ 'staff_id' ],
					'company' => $lead[ 'company' ],
					'type' => $lead[ 'type' ],
					'namesurname' => $lead[ 'company' ],
					'created' => date( 'Y-m-d H:i:s' ),
					'address' => $lead[ 'address' ],
					'zipcode' => $lead[ 'zip' ],
					'country_id' => $lead[ 'country_id' ],
					'state' => $lead[ 'state' ],
					'city' => $lead[ 'city' ],
					'phone' => $lead[ 'leadphone' ],
					'email' => $lead[ 'leadmail' ],
					'companyemail' => $lead[ 'companyemail' ],
					'contactpersonname' => $lead[ 'contactpersonname' ],
					'web' => $lead[ 'website' ],
					'type' => '0',
					'groupid' => $lead[ 'groupid' ],
					'lead_converted_id' => $id,
					'sales_team'=>$lead[ 'assigned_id' ]
				);
				$this->db->insert( 'customers', $params );
				$customer = $this->db->insert_id();
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $message = sprintf( lang( 'coverttocustomer' ), $this->session->staffname, get_number('leads', $lead[ 'id' ], 'lead','lead') ) . '' ),
					'staff_id' => $this->session->usr_id,
					'customer_id' => $customer,
				) );
				$statusid = '7';
				$response = $this->db->where( 'id', $id )->update( 'leads', array( 'status' => $statusid, 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
				
				$response = $this->db->where( 'relation', $id, 'relation_type', 'lead' )->update( 'proposals', array( 'relation' => $customer, 'relation_type' => 'customer' ) );
				
				$contactParams = array(
					'name' => $lead[ 'contactpersonname' ],
					'surname' => $lead[ 'company' ],
					'email' => $lead[ 'leadmail' ],
					'customer_id'=> $customer
				);
				$responseContacts = $this->Contacts_Model->create($contactParams);
				$data['id'] = $customer;
				$data['success'] = true;
				echo json_encode($data) ;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function add_status() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
				);
				$status = $this->Leads_Model->add_status( $params );
				$data['message'] = lang('status').' '.lang('addmessage');
				$data['success'] = true;
				
			} else {
				$data['success'] = false;
				$data['message'] = "false";
				redirect( 'leads/index' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_status( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			$data[ 'statuses' ] = $this->Leads_Model->get_status( $id );
			if ( isset( $data[ 'statuses' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
						'color' => $this->input->post( 'color' ),
					);
					$this->Leads_Model->update_status( $id, $params );
					$data['message'] = lang('lead').' '.lang('status').' '.lang('updatemessage');
					$data['success'] = true;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function remove_status( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'delete' ) ) {
			$lead = $this->Leads_Model->get_status( $id );
			// check if the expenses exists before trying to delete it
			if ( isset( $lead[ 'id' ] ) ) {
				$check = $this->Leads_Model->check_sources($id);
				if ($this->Leads_Model->check_statuses($id) === 0) {
					$this->Leads_Model->delete_status( $id );
					$data['message'] = lang('lead').' '.lang('status').' '.lang('deletemessage');
					$data['success'] = true;
					echo json_encode($data);
				} else {
					$data['message'] = lang('status').' '.lang('used_message').' '.lang('some').' '.lang('lead');
					$data['success'] = false;
					echo json_encode($data);
				}
			}		
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function add_source() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
				);
				$source = $this->Leads_Model->add_source( $params );
				$data['message'] = lang('lead').' '.lang('source').' '.lang('addmessage');
				$data['success'] = true;
				echo json_encode($data);
			} else {
				redirect( 'leads/index' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function update_source( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			$data[ 'sources' ] = $this->Leads_Model->get_source( $id );
			if ( isset( $data[ 'sources' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Leads_Model->update_source( $id, $params );
					$data['message'] = lang('lead').' '.lang('source').' '.lang('updatemessage');
					$data['success'] = true;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function remove_source( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'delete' ) ) {
			$lead = $this->Leads_Model->get_source( $id );
			if (isset($lead['id'])) {
				$check = $this->Leads_Model->check_sources($id);
				if ($this->Leads_Model->check_sources($id) === 0) {
					$this->Leads_Model->delete_source( $id );
					$data['message'] = lang('lead').' '.lang('source').' '.lang('deletemessage');
					$data['success'] = true;
					echo json_encode($data);
				} else {
					$data['message'] = lang('source').' '.lang('used_message').' '.lang('some').' '.lang('lead');
					$data['success'] = false;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function move_lead() {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			$lead_id = $_POST[ 'lead_id' ];
			$status_id = $_POST[ 'status_id' ];
			$response = $this->db->where( 'id', $lead_id )->update( 'leads', array( 'status' => $status_id,'dateassigned'=>date( 'Y-m-d H:i:s' )) );
			$lead = $this->Leads_Model->get_lead( $lead_id );
			$data_lead = array(
				'id' => $lead[ 'id' ],
				'name' => $lead[ 'leadname' ],
				'company' => $lead[ 'company' ],
				'phone' => $lead[ 'leadphone' ],
				'color' => $lead[ 'color' ],
				'status' => $lead[ 'status' ],
				'statusname' => $lead[ 'statusname' ],
				'source' => $lead[ 'source' ],
				'sourcename' => $lead[ 'sourcename' ],
				'assigned' => $lead[ 'leadassigned' ],
				'avatar' => $lead[ 'assignedavatar' ],
				'staff' => $lead[ 'staff_id' ],
				'createddate' => $lead[ 'created' ],
				'' . lang( 'filterbystatus' ) . '' => $lead[ 'statusname' ],
				'' . lang( 'filterbysource' ) . '' => $lead[ 'sourcename' ],
			);
			echo json_encode( $data_lead );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function mark_as_lead( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) {
			if ( isset( $id ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					if ( $this->input->post( 'value' ) == 1 ) {
						$response = $this->db->where( 'id', $id )->update( 'leads', array( 'lost' => 1,'status'=> 8,'dateassigned'=>date( 'Y-m-d H:i:s' ) ) );
					}
					if ( $this->input->post( 'value' ) == 2 ) {
						$response = $this->db->where( 'id', $id )->update( 'leads', array( 'lost' => 0, 'status'=> 1,'dateassigned'=>date( 'Y-m-d H:i:s' ) ) );
					}
					if ( $this->input->post( 'value' ) == 3 ) {
						$response = $this->db->where( 'id', $id )->update( 'leads', array( 'junk' => 1,'dateassigned'=>date( 'Y-m-d H:i:s' ) ) );
					}
					if ( $this->input->post( 'value' ) == 4 ) {
						$response = $this->db->where( 'id', $id )->update( 'leads', array( 'junk' => 0,'dateassigned'=>date( 'Y-m-d H:i:s' ) ) );
					}
					$data['success'] = true;
					$data['message'] = lang( 'updated' );
				} else {
					$data['success'] = false;
					redirect( 'leads/index' );
				}
			} else {
				show_error( 'The expensecategory you are trying to edit does not exist.' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
		}
		echo json_encode($data);
	}
	function import(){
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			$path = './uploads/imports/';
			require_once APPPATH . "/third_party/PHPExcel.php";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx|xls|csv';
			$config['remove_spaces'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);            
			if (!$this->upload->do_upload()) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
			}
			if(empty($error)){
			  if (!empty($data['upload_data']['file_name'])) {
				$import_xls_file = $data['upload_data']['file_name'];
			} else {
				$import_xls_file = 0;
			}
			$inputFileName = $path . $import_xls_file;
		 
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
				  $inserdata[$i]['created'] = date( 'Y-m-d H:i:s');
				  $inserdata[$i]['company'] = $row['A'];
				  $inserdata[$i]['groupid'] = $businesstypeid;
				  $inserdata[$i]['name'] = $row['C'];
				  $inserdata[$i]['title'] = $row['D'];
				  $inserdata[$i]['phone'] = $row['E'];
				  $inserdata[$i]['mobile'] = $row['F'];
				  $inserdata[$i]['email'] = $row['G'];
				  $inserdata[$i]['address'] = $row['H'];
				  $inserdata[$i]['description'] = $row['I'];
				  $inserdata[$i]['staff_id'] = $this->session->userdata( 'usr_id' );
				  $inserdata[$i]['dateassigned'] = date( 'Y-m-d H:i:s' );
				  $inserdata[$i]['status'] = $this->input->post( 'importstatusid' );
				  $inserdata[$i]['source'] = $this->input->post( 'importsourceid' );
				  $inserdata[$i]['assigned_id'] = $this->input->post( 'importassignedto' );
				  $inserdata[$i]['public'] =  $this->input->post( 'importpublicornot' );
							
				  $i++;
				} 
				
				$result = $this->Leads_Model->insert_excel($inserdata);   
				if($result){
				  $this->session->set_flashdata( 'ntf1', lang('excelimportsuccess') );
				  redirect( 'leads/index' );
				}else{
				  redirect( 'leads/index' );
				  $this->session->set_flashdata( 'ntf3', 'Error' );
				}             

		  } catch (Exception $e) {
			   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' .$e->getMessage());
			}
		  }else{
			  $this->session->set_flashdata( 'ntf3',lang( 'There is some issue while upload. Please try again later.' ) );
			redirect(base_url('leads'));
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}
	

	function old_import () {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'create' ) ) {
			$this->load->library( 'import' );
			$data[ 'leads' ] = $this->Leads_Model->get_leads_for_import();
			$data[ 'error' ] = ''; //initialize image upload error array to empty
			$config[ 'upload_path' ] = './uploads/imports/';
			$config[ 'allowed_types' ] = 'csv';
			$config[ 'max_size' ] = '1000';
			$this->load->library( 'upload', $config );
			// If upload failed, display error
			if ( !$this->upload->do_upload() ) {
				$data[ 'error' ] = $this->upload->display_errors();
				$this->session->set_flashdata( 'ntf4', lang('csvimporterror') );
				redirect( 'leads/index' );
			} else {
				$file_data = $this->upload->data();
				$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
				if ( $this->import->get_array( $file_path ) ) {
					$csv_array = $this->import->get_array( $file_path );
					foreach ( $csv_array as $row ) {
						$businesstype = $this->Leads_Model->get_businesstype_by_name($row[ 'Industry Type' ]);
						if(sizeof($businesstype) > 0){
							$businesstypeid = $businesstype['id']; 
						} else {
							echo 'here';
							$param = array('name'=>$row[ 'Industry Type' ]);
							$this->db->insert('customergroups',$param);
							$businesstypeid = $this->db->insert_id();
						}
						
						$insert_data = array(
							'created' => date( 'Y-m-d H:i:s' ),
							//'type' => $row[ 'type' ],
							//'name' => $row[ 'name' ],
							//'title' => $row[ 'title' ],
							'company' => $row[ 'Company Name' ],
							'groupid' => $businesstypeid,
							'name' => $row[ 'Contact Person' ],
							'title'=> $row['Designation'],
							'phone'=> $row['Telephone(office)'],
							'mobile'=> $row['Mobile Number'],
							'email' => $row[ 'Email ID' ],
							'address' => $row[ 'Address' ],
							'description' => $row[ 'Remarks' ],
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'dateassigned' => date( 'Y-m-d H:i:s' ),
							'status' => $this->input->post( 'importstatusid' ),
							'source' => $this->input->post( 'importsourceid' ),
							'assigned_id' => $this->input->post( 'importassignedto' ),
							'public' =>  $this->input->post( 'importpublicornot' ),
							/*'zip' => $row[ 'zip' ],
							'city' => $row[ 'city' ],
							'state' => $row[ 'state' ],
							'website' => $row[ 'website' ],
							'phone' => $row[ 'phone' ],*/
						);
						$this->Leads_Model->insert_csv( $insert_data );
					}
					$this->session->set_flashdata( 'ntf1', lang('csvimportsuccess') );
					redirect( 'leads/index' );
				} else
					redirect( 'leads/index' );
				$this->session->set_flashdata( 'ntf3', 'Error' );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function exportdata() {
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$this->db->select('leads.type, leads.name, leads.title, leads.company, leads.description, leads.email, leads.zip, leads.state, leads.address, leads.city, leads.website, leads.phone, leadssources.name as Source, leadssources.id as Source_Id');
			$this->db->join( 'leadssources', 'leads.source = leadssources.id', 'left' );
			$q = $this->db->get_where( 'leads', array( '') );
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$this->db->select('leads.type, leads.name, leads.title, leads.company, leads.description, leads.email, leads.zip, leads.state, leads.address, leads.city, leads.website, leads.phone, leadssources.name as Source, leadssources.id as Source_Id');
			$this->db->join( 'leadssources', 'leads.source = leadssources.id', 'left' );
			$q = $this->db->get_where('leads','(leads.staff_id='.$this->session->usr_id.' OR leads.assigned_id='.$this->session->usr_id.')');
		}
		 
		$delimiter = ",";
		$nuline    = "\r\n";
		force_download('Leads.csv', $this->dbutil->csv_from_result($q, $delimiter, $nuline));
	}

	function remove_converted( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'delete' ) ) { 
			$response = $this->db->delete( 'leads', array( 'status' => $id ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function make_converted_status( $id ) {	
		if ( $this->Privileges_Model->check_privilege( 'leads', 'edit' ) ) { 
			$response = $this->db->where( 'settingname', 'ciuis' )->update( 'settings', array( 'converted_lead_status_id' => $id ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($lead) {
			if ( $this->Privileges_Model->check_privilege( 'leads', 'delete' ) ) {
				// check if the lead exists before trying to delete it
				$lead_number = get_number('leads',$id,'lead','lead');
				if ( isset( $lead[ 'id' ] ) ) {
					$this->Leads_Model->delete_lead( $id, $lead_number );
					$data['success'] = true;
					$data['message'] = lang('lead').' '.lang( 'deletemessage' );
					echo json_encode($data);
				} else {
					show_error( 'The lead you are trying to delete does not exist.' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}	
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function get_lead( $id ) {
		$lead = array();
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'leads', 'own') ) {
			$lead = $this->Leads_Model->get_lead_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
		if($lead) {
			$country = get_country($lead[ 'country_id' ]);
			$state = get_state_name($lead[ 'state' ],$lead[ 'state_id' ]);
			switch ( $lead[ 'public' ] ) {
				case '0':
					$is_public = false;
					break;
				case '1':
					$is_public = true;
					break;
			}
			switch ( $lead[ 'type' ] ) {
				case '0':
					$is_individual = false;
					break;
				case '1':
					$is_individual = true;
					break;
			}
			$data_lead = array(
				'id' => $lead[ 'id' ],
				'type' => $lead[ 'type' ],
				'name' => $lead[ 'leadname' ],
				'title' => $lead[ 'title' ],
				'company' => $lead[ 'company' ],
				'description' => $lead[ 'description' ],
				'country_id' => $lead[ 'country_id' ],
				'country' => $country,
				'zip' => $lead[ 'zip' ],
				'city' => $lead[ 'city' ],
				'state' => $state,
				'state_id' => $lead['state_id'],
				'email' => $lead[ 'leadmail' ],
				'companyemail' => $lead[ 'companyemail' ],
				'address' => $lead[ 'address' ],
				'website' => $lead[ 'website' ],
				'phone' => $lead[ 'leadphone' ],
				'mobile' => $lead[ 'mobile' ],
				'assigned' => $lead[ 'leadassigned' ],
				'assigned_id' => $lead[ 'assigned_id' ],
				'group_id' => $lead[ 'groupid' ],
				'created' => $lead[ 'created' ],
				'status_id' => $lead[ 'status' ],
				'status' => $lead[ 'statusname' ],
				'source_id' => $lead[ 'source' ],
				'source' => $lead[ 'sourcename' ],
				'lastcontact' => $lead[ 'lastcontact' ],
				'dateassigned' => $lead[ 'dateassigned' ],
				'staff_id' => $lead[ 'staff_id' ],
				'dateconverted' => $lead[ 'dateconverted' ],
				'date_contacted' => date(get_dateFormat(),strtotime($lead[ 'date_contacted' ])),
				'lost' => $lead[ 'lost' ],
				'junk' => $lead[ 'junk' ],
				'public' => $is_public,
				'type' => $is_individual,
				'lead_number' => get_number('leads', $lead[ 'id' ], 'lead','lead'),
				'lead_status_id' => ($lead['lead_status_id'] == '1') ? true : false,
			);
			echo json_encode( $data_lead );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('leads'));
		}
	}

	function leadstatuses() {
		$leadstatuses = $this->Leads_Model->get_leads_status();
		echo json_encode( $leadstatuses );
	}

	function leadsources() {
		$leadsources = $this->Leads_Model->get_leads_sources();
		echo json_encode( $leadsources );
	}

	function get_leads($type='') {
		$where="leads.id <>''";
		if(isset($type))
		{
			if($type=='today')$where="DATE(leads.dateassigned) between '".date('Y-m-d')."' and '".date('Y-m-d')."'";
			$date=date('Y-m-d');
			$date=date("Y-m-d",strtotime($date." -1 day "));
			if($type=='yesterday')$where="DATE(leads.dateassigned) between '".$date."' and '".$date."'";
			$end_week = strtotime("last monday midnight");
			$end_week = date("Y-m-d",$end_week);
			$start_week=date("Y-m-d",strtotime($end_week." -7 day "));
			if($type=='lastweek')$where="DATE(leads.dateassigned) between '".$start_week."' and '".$end_week."'";
			$start_month = date('Y-m-d', strtotime('first day of this month'));
			//$end_month = date('Y-m-d', strtotime('last day of last month'));
			$end_month=date('Y-m-d');
			if($type=='lastmonth')$where="DATE(leads.dateassigned) between '".$start_month."' and '".$end_month."'";
		}
		
		$leads = array();
		if ( $this->Privileges_Model->check_privilege( 'leads', 'all' ) ) {
			$leads = $this->Leads_Model->get_all_leads_by_privileges('',$where);
		} else if ( $this->Privileges_Model->check_privilege( 'leads', 'own' ) ) {
			$leads = $this->Leads_Model->get_all_leads_by_privileges($this->session->usr_id,$where);
		}
		$data_leads = array();
		$data_sales_staff = array();
		foreach ( $leads as $lead ) {
			$tags = $this->db->select( '*' )->get_where( 'tags', array( 'relation_type' => 'lead', 'relation' => $lead[ 'id' ] ) )->row_array();
			if($lead['leadassignedid'] != '') {
				$data_sales_staff[$lead['leadassignedid']] = array('assignedavatar'=>$lead['assignedavatar'], 'leadassigned'=>$lead['leadassigned'], 'leadassignedid' => $lead['leadassignedid']);
			}
			$data_leads[] = array(
				'id' => $lead[ 'id' ],
				'name' => $lead[ 'leadname' ],
				'company' => $lead[ 'company' ],
				'phone' => $lead[ 'leadphone' ],
				'color' => $lead[ 'color' ]?$lead[ 'color' ]:'',
				'status' => $lead[ 'status' ]?$lead[ 'status' ]:'',
				'statusname' => $lead[ 'statusname' ]?$lead[ 'statusname' ]:'',
				'source' => $lead[ 'source' ]?$lead[ 'source' ]:'',
				'sourcename' => $lead[ 'sourcename' ]?$lead[ 'sourcename' ]:'',
				'assigned' => $lead[ 'leadassigned' ],
				'avatar' => $lead[ 'assignedavatar' ],
				'staff' => $lead[ 'staff_id' ],
				'date_contacted' => date( get_dateTimeFormat(), strtotime( $lead[ 'date_contacted' ] ) ),
				'date_assigned' => $lead[ 'dateassigned' ] != null ? date('d-m-Y', strtotime( $lead[ 'dateassigned' ])) : lang('n_a'),
				'date_assigned_time' => $lead[ 'dateassigned' ] != null ? date('h:i:s a', strtotime( $lead[ 'dateassigned' ])) : '',
				'tags' => $tags,
				'createddate' => $lead[ 'created' ],
				'' . lang( 'filterbydate' ) . '' => $lead[ 'dateassigned' ] ? date('Y-m-d',strtotime($lead[ 'dateassigned' ])) : lang('n_a'),
				'' . lang( 'filterbystatus' ) . '' => $lead[ 'statusname' ]?$lead[ 'statusname' ]:'',
				'' . lang( 'filterbysource' ) . '' => $lead[ 'sourcename' ]?$lead[ 'sourcename' ]:'',
				'filter by category' => $lead['groupname'],
				'lead_number'=> get_number('leads', $lead[ 'id' ], 'lead','lead'),
				'email' => $lead['leadmail'],
				'public' => $lead[ 'public' ]
			);
		};
		$finaldata['sales_staff'] = $data_sales_staff;
		$finaldata['data_leads'] = $data_leads;
		echo json_encode( $finaldata );
	}
	
	function get_leads_count($type='') { 
		$where=" leads.id <>''";
		if(isset($type))
		{
			if($type=='today')$where="DATE(leads.dateassigned) between '".date('Y-m-d')."' and '".date('Y-m-d')."'";
			$date=date('Y-m-d');
			$date=date("Y-m-d",strtotime($date." -1 day "));
			if($type=='yesterday')$where="DATE(leads.dateassigned) between '".$date."' and '".$date."'";
			$end_week = strtotime("last monday midnight");
			$end_week = date("Y-m-d",$end_week);
			$start_week=date("Y-m-d",strtotime($end_week." -7 day "));
			if($type=='lastweek')$where="DATE(leads.dateassigned) between '".$start_week."' and '".$end_week."'";
			$start_month = date('Y-m-d', strtotime('first day of this month'));
			$end_month=date('Y-m-d');
			//$end_month = date('Y-m-d', strtotime('last day of last month'));
			if($type=='lastmonth')$where="DATE(leads.dateassigned) between '".$start_month."' and '".$end_month."'";
		}
		if ( !if_admin ) {
			$openLeads= $this->Leads_Model->get_leads_count("status='1' and ".$where);
			$chaseLeads= $this->Leads_Model->get_leads_count("status='6' and ".$where);
			$convertedLeads= $this->Leads_Model->get_leads_count("status='7' and ".$where);
			$ecfollowupLeads= $this->Leads_Model->get_leads_count("(status='2' OR status='3') and ".$where);
			//$cfollowupLeads= $this->Leads_Model->get_leads_count("status='3' and ".$where);
			$lostfollowupLeads= $this->Leads_Model->get_leads_count("status='8' and ".$where);
		} else {
			$userId=$this->session->userdata('usr_id');
			$openLeads = $this->Leads_Model->get_leads_count("status='1' AND assigned_id='".$userId."' and ".$where);
			$chaseLeads = $this->Leads_Model->get_leads_count("status='6' AND assigned_id='".$userId."' and ".$where);
			$convertedLeads = $this->Leads_Model->get_leads_count("status='7' AND assigned_id='".$userId."' and ".$where);
			$ecfollowupLeads = $this->Leads_Model->get_leads_count("(status='2' OR status='3') AND assigned_id='".$userId."' and ".$where);
			//$cfollowupLeads = $this->Leads_Model->get_leads_count("status='3' AND assigned_id='".$userId."' and ".$where);
			$lostfollowupLeads= $this->Leads_Model->get_leads_count("status='8' AND assigned_id='".$userId."' and ".$where);
		}

			$data[ 'openLeads' ] =$openLeads['total'];
			$data[ 'chaseLeads' ] =$chaseLeads['total'];
			$data[ 'convertedLeads' ] =$convertedLeads['total'];
			$data[ 'ecfollowupLeads' ] =$ecfollowupLeads['total'];
			//$data[ 'cfollowupLeads' ] =$cfollowupLeads['total'];
			$data[ 'lostfollowupLeads' ] =$lostfollowupLeads['total'];
		echo json_encode( $data );
	}
	
	function get_individual_count($status) {
		if($status == 'Open') {
			$data['totalCount'] = $this->Leads_Model->get_leads_count("status='1'");
		}
		else if($status == 'Chase') {
			$data['totalCount'] = $this->Leads_Model->get_leads_count("status='6'");
		}
		else if($status == 'Converted') {
			$data['totalCount'] = $this->Leads_Model->get_leads_count("status='7'");
		}
		else if($status == 'Lost') {
			$data['totalCount'] = $this->Leads_Model->get_leads_count("status='8'");
		}
		else if($status == 'ECall') {
			$data['totalCount'] = $this->Leads_Model->get_leads_count("status='2' OR status = '3'");
		}
		echo json_encode($data);
	}
	
	function get_filter_count() {
		$status = $this->input->post( 'stat' );
		$assigned_id = $this->input->post( 'assigned' );
		$source = $this->input->post( 'source' );
		$dates = $this->input->post( 'dates' );
		$category = $this->input->post( 'category' );
		$daySelection = $this->input->post( 'daySelection' );

		foreach($status as $eachStat) {
			$statId[] = $this->Leads_Model->get_statusid_by_name($eachStat);
		}
		foreach($source as $eachsource) {
			$sourceID[] = $this->Leads_Model->get_sourceid_by_name($eachsource);
		}
		foreach($assigned_id as $eachassigned) {
			$assignedID[] = $this->Leads_Model->get_assignedid_by_name($eachassigned);
		}
		$categoryID = $this->Leads_Model->get_businesstype_by_name($category[0]);
		if($dates != "") {
			$fromDt = $dates[0];
			$toDt = $dates[1];
		}
		
		$stats = implode(',',array_column($statId,'id'));
		$sources = implode(',',array_column($sourceID,'id'));
		$assignees = implode(',',array_column($assignedID,'id'));
		$businesstype = $categoryID ? $categoryID['id'] : '';
		
		$wherestatus=$wheresources=$whereassigned=$whereBusinessTypes='';
		if($stats != '') {
			$wherestatus=" and status in (".$stats.")";
		}
		if($sources != '') {
			$wheresources=" and source in (".$sources.")";
		}
		if($assignees != '') {
			$whereassigned=" and assigned_id in (".$assignees.")";
		}
		if($dates != '') {
			$whereDates = " and DATE(dateassigned) between '" .$fromDt."' and '".$toDt."'";
		}
		if($businesstype != '') {
			$whereBusinessTypes = " and groupid in (".$businesstype.")";
		}
		if($daySelection != null && $daySelection[0] != '') {
			$todayDt = $date=date('Y-m-d');
			$yesterdayDt=date("Y-m-d",strtotime($date." -1 day "));
			$end_week = strtotime("last monday midnight");
			$end_week = date("Y-m-d",$end_week);
			$start_week=date("Y-m-d",strtotime($end_week." -7 day "));
			$start_month = date('Y-m-d', strtotime('first day of this month'));
			//$end_month = date('Y-m-d', strtotime('last day of last month'));
			$end_month = date('Y-m-d');
			if($daySelection[0]=='today') {
				$wheredaySelection = " and DATE(dateassigned) between '".$todayDt."' and '".$todayDt."'";
			}
			else if($daySelection[0]=='yesterday') {
				$wheredaySelection = " and DATE(dateassigned) between '".$yesterdayDt."' and '".$yesterdayDt."'";
			}
			else if($daySelection[0]=='lastweek') {
				$wheredaySelection = " and DATE(dateassigned) between '".$start_week."' and '".$end_week."'";
			}
			else if($daySelection[0]=='lastmonth') {
				$wheredaySelection = " and DATE(dateassigned) between '".$start_month."' and '".$end_month."'";
			}
			else {
				$wheredaySelection = '';
			}
		}
		
		$where = $wherestatus.$wheresources.$whereassigned.$whereDates.$whereBusinessTypes.$wheredaySelection;
		
		$openLeads= $this->Leads_Model->get_leads_count("status='1' ".$where);
		$chaseLeads= $this->Leads_Model->get_leads_count("status='6' ".$where);
		$convertedLeads= $this->Leads_Model->get_leads_count("status='7' ".$where);
		$ecfollowupLeads= $this->Leads_Model->get_leads_count("(status='2' OR status='3') ".$where);
		//$cfollowupLeads= $this->Leads_Model->get_leads_count("status='3' ".$where);
		$lostfollowupLeads= $this->Leads_Model->get_leads_count("status='8' ".$where);
		
		$data[ 'openLeads' ] =$openLeads['total'];
		$data[ 'chaseLeads' ] =$chaseLeads['total'];
		$data[ 'convertedLeads' ] =$convertedLeads['total'];
		$data[ 'ecfollowupLeads' ] =$ecfollowupLeads['total'];
		//$data[ 'cfollowupLeads' ] =$cfollowupLeads['total'];
		$data[ 'lostfollowupLeads' ] =$lostfollowupLeads['total'];
		echo json_encode( $data );
	}
}