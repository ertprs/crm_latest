<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Delivery extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}

		$this->load->model('Delivery_Model');
		$this->load->model('Newcontacts_Model');

	}

	function index() {
		$data[ 'title' ] = lang( 'Delivery' );
	//	$data[ 'projects' ] = $this->Projects_Model->get_all_projects();
		$data[ 'staff' ] = $this->Delivery_Model->get_all_staff();
		$data['countries'] = $this->Newcontacts_Model->get_countries();
		$this->load->view( 'delivery/index', $data );
	}

	function delivery( $id ) {
		$project = $this->Delivery_Model->get_delivery( $id );
			$data[ 'title' ] = $project[ 'name' ];
			$data[ 'projects' ] = $project;
			$this->load->view( 'inc/header', $data );
			$this->load->view( 'delivery/delivery', $data );
		
	}

	function create() { 
		if ( $this->Privileges_Model->check_privilege( 'projects', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$installation = $this->input->post( 'installation' );
				$projectid = $this->input->post('projectname');
				$delivery_date = $this->input->post( 'delivery_date' );
				$description = $this->input->post( 'description' );
				$address = $this->input->post( 'address' );
				$shipping_country_id = $this->input->post( 'shipping_country_id' );
				$shipping_state_id = $this->input->post( 'shipping_state_id' );
				$shipping_city = $this->input->post( 'shipping_city' );
				$shipping_zip = $this->input->post( 'shipping_zip' );
				$contact_number = $this->input->post( 'contact_number' );
				$contact_name = $this->input->post( 'contact_name' );
				$hasError = false;
				$data['message'] = '';
				if ($installation == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($projectid == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('customer');
				} 
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'description' => $description,
						'projectid' => $projectid,
						'delivery_date' => $delivery_date,
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'stage_id' => $installation,
						'address' => $address,
						'shipping_country_id' => $shipping_country_id,
						'shipping_state_id' => $shipping_state_id,
						'shipping_city' => $shipping_city,
						'shipping_zip' => $shipping_zip,
						'contact_name' => $contact_name,
						'contact_number' => $contact_number,
						'status_id' => 1,
  						'created' => date( 'Y-m-d H:i:s' ), 
					);

					$this->db->insert( 'delivery', $params );
					$delivery_id = $this->db->insert_id();
					$allProjectStages = $this->db->get_where( 'installation', array( '' ))->result_array();
					
					foreach($allProjectStages as $eachProjectStage) {
						$subprojectparams = array(
							'deliveryid' => $delivery_id,
							'delivery_stage_id' => $eachProjectStage['id'],
							'finished' => 0,
							'created' => date( 'Y-m-d H:i:s' ),
							'update' => date( 'Y-m-d H:i:s' ),
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'complete' => 0
						);
						$this->db->insert( 'subdelivery', $subprojectparams );
					}
					$array = array('deliveryid' => $delivery_id, 'delivery_stage_id' => $installation);
					$this->db->where( $array)->update( 'subdelivery', array( 'complete' => 1 ) );
					
					$appconfig = get_appconfig();
					$number = $appconfig['project_series'] ? $appconfig['project_series'] : $delivery_id;
					$delivery_number = $appconfig['delivery_prefix'].$number;
					$this->db->where('id', $delivery_id)->update( 'delivery', array('delivery_number' => $delivery_number ) );
					if($appconfig['project_series']){
						$project_number = $appconfig['project_series'];
						$project_number = $project_number + 1 ;
						$this->Settings_Model->increment_series('delivery_series',$project_number);
					}
					
					// Custom Field Post
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'project', $delivery_id );
					}
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ).' '.lang('project').' '. ' <a href="delivery/delivery/' . $delivery_id . '">' . get_number('delivery',$delivery_id,'delivery','delivery') . '</a>' ),
						'staff_id' => $this->session->usr_id,
						'delivery_id' => $delivery_id,
					) );
					/* $template = $this->Emails_Model->get_template('project', 'project_notification');
					if ($template['status'] == 1) {
						$project = $this->Projects_Model->get_projects( $delivery_id );
						$project_url = '' . base_url( 'area/projects/project/' . $delivery_id . '' ) . '';
						switch ( $project[ 'status' ] ) {
							case '1':
								$status_project = lang( 'notstarted' );
								break;
							case '2':
								$status_project = lang( 'started' );
								break;
							case '3':
								$status_project = lang( 'hold' );
								break;
							case '4':
								$status_project = lang( 'cancelled' );
								break;
							case '5':
								$status_project = lang( 'complete' );
								break;
						};

						if ( $project[ 'namesurname' ] ) {
							$customer = $project[ 'namesurname' ];
						} else {
							$customer = $project[ 'customercompany' ];
						}
						$message_vars = array(
							'{customer}' => $customer,
							'{project_name}' => $name,
							'{project_start_date}' => $_POST[ 'start' ],
							'{project_end_date}' => $_POST[ 'deadline' ],
							'{project_value}' => $value,
							'{project_tax}' => $tax,
							'{loggedin_staff}' => $this->session->userdata('staffname'),
							'{project_url}' => $project_url,
							'{project_status}' => $status_project,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{project_description}' => $project['description']
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $project['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($project['customeremail']) {
							$this->db->insert( 'email_queue', $param );
						}
					} */
					$data['success'] = true;
					$data['message'] = lang('project'). ' ' .lang('createmessage');
					$data['id'] = $delivery_id;
					if($appconfig['project_series']){	
						$project_number = $appconfig['project_series'];
						$project_number = $project_number + 1 ;
						$this->Settings_Model->increment_series('project_series',$project_number);
					}
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
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$shipping_country_id = $this->input->post( 'shipping_country_id' );
			$shipping_state_id = $this->input->post( 'shipping_state_id' );
			$shipping_city = $this->input->post( 'shipping_city' );
			$shipping_zip = $this->input->post( 'shipping_zip' );
			$contact_number = $this->input->post( 'contact_number' );
			$contact_name = $this->input->post( 'contact_name' );
			$editdelivery_date =  date("Y-m-d H:i:s",strtotime($this->input->post( 'editdelivery_date' , true)));
							$params = array(
								'description' => $this->input->post( 'description', true ),
								'address' => $this->input->post( 'address', true ),
								'delivery_date' => $editdelivery_date,
								'staff_id' => $this->session->userdata( 'usr_id' ),
								'modified_on' => date( 'Y-m-d H:i:s' ),
								'shipping_country_id' => $shipping_country_id,
								'shipping_state_id' => $shipping_state_id,
								'shipping_city' => $shipping_city,
								'shipping_zip' => $shipping_zip,
								'contact_name' => $contact_name,
								'contact_number' => $contact_number,
							);
							$this->Delivery_Model->update( $id, $params );
							$data['success'] = true;
							$data['message'] = lang('project'). ' ' .lang('updatemessage');
							echo json_encode($data);
				
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		
	}

	function createticket($id) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'create' ) ) { 
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$contact_id = $this->input->post( 'contact' );
				$customer_id = $this->input->post( 'customer' );
				$department_id = $this->input->post( 'department' );
				$subject = $this->input->post( 'subject' );
				$message = $this->input->post( 'message' );
				$priority = $this->input->post( 'priority' );

				$hasError = false;
				$data['message'] = '';
				if ($subject == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('subject');
				} else if ($customer_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('customer');
				} else if ($contact_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('contact');
				} else if ($department_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('department');
				} else if ($priority == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('priority');
				} else if ($message == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('message');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'contact_id' => $this->input->post( 'contact' ),
						'customer_id' => $this->input->post( 'customer' ),
						'department_id' => $this->input->post( 'department' ),
						'priority' => $this->input->post( 'priority' ),
						'status_id' => 1,
						'subject' => $this->input->post( 'subject' ),
						'message' => $this->input->post( 'message' ),
						'relation_id' => $id,
						'relation' => 'project',
						'date' => date( " Y.m.d H:i:s " ),
						'ticket_number' => $appconfig['ticket_prefix'] . $appconfig['ticket_series'],
						'staff_id' => $this->session->usr_id
					);
					$tickets_id = $this->Tickets_Model->add_tickets( $params );

					$template = $this->Emails_Model->get_template('ticket', 'new_ticket');
					if ($template['status'] == 1) {
						$ticket = $this->Tickets_Model->get_tickets( $tickets_id );
						if ( $ticket[ 'type' ] == 0 ) {
							$customer = $ticket[ 'company' ];
						} else {
							$customer = $ticket[ 'namesurname' ];
						} 

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

						$message_vars = array(
							'{customer}' => $customer,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{ticket_subject}' => $this->input->post( 'subject' ),
							'{ticket_message}' => $this->input->post( 'message' ),
							'{ticket_priority}' => $priority,
							'{ticket_department}' => $ticket['department'],
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);
						$param = array(
							'from_name' => $template['from_name'],
							'email' => $ticket['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($ticket['customeremail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$ticket_number = $appconfig['ticket_series'];
					$ticket_number = $ticket_number + 1 ;
					$this->Settings_Model->increment_series('ticket_series',$ticket_number);
					$data['message'] = lang('ticket'). ' ' .lang('createmessage');
					echo json_encode($data);
				}
			} 
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function ticket_markas() { 
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'edit' ) ) { 
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$response = $this->db->where( 'id', $_POST[ 'ticket_id' ] )->update( 'tickets', array( 'status_id' => $_POST[ 'status_id' ] ) );
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function tickets( $id ) {
		$tickets = $this->Projects_Model->get_all_tickets($id);
		echo json_encode($tickets);
	}

	function remove_ticket( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'delete' ) ) { 
			$tickets = $this->Projects_Model->get_tickets( $id );
			if ( isset( $tickets[ 'id' ] ) ) {
				if ($this->Projects_Model->delete_tickets( $id )) {
					$data['success'] = true;
					$data['message'] = lang('ticket'). ' ' .lang('deletemessage');
				}
			} else
				show_error( 'Eror' );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function copyProject( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'projects', 'create' ) ) {
			$project = $this->Projects_Model->get_projects( $id );
			$params = array(
				'customer_id' => $this->input->post( 'customer_id' ),
				'name' => $project['name'].'-Copy',
				'staff_id' => $this->session->userdata('usr_id'),
				'status_id' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
				'projectvalue' => $project['projectvalue'],
				'tax' => $project['tax'],
				'start_date' => $this->input->post( 'startdate' ),
				'deadline' => $this->input->post( 'enddate' ),
				'description' => $project['description'],
				'template' => 0
			);
			$this->db->insert( 'projects', $params );
			$projectId = $this->db->insert_id();
			$loggedinuserid = $this->session->usr_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . lang('created_a_new_project') ),
				'staff_id' => $loggedinuserid,
				'project_id' => $projectId,
			));

			// Items List to be copied:
			$isExpenses = $this->input->post('expenses');
			$isServices = $this->input->post('services');
			$isMilestones = $this->input->post('milestones');
			$isTasks = $this->input->post('tasks');
			$isPeoples = $this->input->post('peoples');
			$isFiles = $this->input->post('files');
			$isNotes = $this->input->post('notes');

			if ($isServices == 'true') {
				$services = $this->Projects_Model->get_project_services($id);
				$this->Projects_Model->copy_services($services, $projectId);
			}
			if ($isExpenses == 'true') {
				$expenses = $this->Expenses_Model->get_all_expenses_by_relation( 'project', $id );
				$this->Projects_Model->copy_expenses($expenses, $projectId);
			}
			if ($isMilestones == 'true') {
				$milestones = $this->Projects_Model->get_all_project_milestones( $id );
				$this->Projects_Model->copy_milestones($milestones, $projectId);
			}
			if ($isTasks == 'true') {
				$tasks = $this->Tasks_Model->get_project_tasks( $id );
				$this->Projects_Model->copy_tasks($tasks, $projectId);
			}
			if ($isPeoples == 'true') {
				$members = $this->Projects_Model->get_members( $id );
				$this->Projects_Model->copy_members($members, $projectId);
			}
			if ($isFiles == 'true') {
				$files = $this->Projects_Model->get_project_files( $id );
				$this->Projects_Model->copy_files($files, $projectId);
			}
			if ($isNotes == 'true') {
				$notes = $this->db->select( '*' )->get_where( 'notes', array( 'relation' => $id, 'relation_type' => 'project' ) )->result_array();
				$this->Projects_Model->copy_notes($notes, $projectId);
			}
			$data['success'] = true;
			$data['message'] = lang('project'). ' ' .lang('createmessage');
			$data['id'] = $projectId;
			echo json_encode($data);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function addservice() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$categoryid = $this->input->post( 'categoryid' );
					$productid = $this->input->post('productid');
					$servicename = $this->input->post( 'servicename' );
					$serviceprice = $this->input->post( 'serviceprice' );
					$servicetax = $this->input->post( 'servicetax' );
					$quantity = $this->input->post( 'quantity' );
					$unit = $this->input->post('unit');
					$servicedescription = $this->input->post( 'servicedescription' );
					$project_id = $this->input->post( 'projectid' );
					$hasError = false;
					$data['message'] = '';
					if ($categoryid == '') {
						$hasError = true;
						$data['message'] = lang('selectinvalidmessage'). ' ' .lang('category');
					} else if ($productid == '') {
						$hasError = true;
						$data['message'] = lang('selectinvalidmessage'). ' ' .lang('product');
					} else if ($servicename == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('productname');
					} else if ($serviceprice == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('price');
					} else if ($servicetax == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('tax');
					} else if ($quantity == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('quantity');
					} else if ($unit == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('unit');
					} else if ($servicedescription == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('description');
					}

					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
	 				} 

	 				if (!$hasError) {
	 					$params = array(
	 						'categoryid' => $categoryid,
	 						'productid' => $productid,
	 						'servicename' => $servicename,
	 						'serviceprice' => $serviceprice,
	 						'servicetax' => $servicetax,
	 						'quantity' => $quantity,
	 						'unit' => $unit,
	 						'servicedescription' => $servicedescription,
	 						'projectid' => $this->input->post( 'projectid' ),
	 					);
	 					$this->db->insert( 'projectservices', $params );
	 					$this->db->insert( 'logs', array(
	 						'date' => date( 'Y-m-d H:i:s' ),
	 						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ).' '.lang('service').' '.lang('for').' '.' <a href="projects/project/' . $project_id . '">' . get_number('projects',$project_id,'project','project') . '</a>' ),
	 						'staff_id' => $this->session->usr_id,
	 						'project_id' => $project_id,
	 					) );
						$project = $this->db->insert_id();
						$data['success'] = true;
						$data['message'] = lang('service'). ' ' .lang('createmessage');
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

	function updateservice($id) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && $id ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$categoryid = $this->input->post( 'categoryid' );
					$productid = $this->input->post('productid');
					$servicename = $this->input->post( 'servicename' );
					$serviceprice = $this->input->post( 'serviceprice' );
					$servicetax = $this->input->post( 'servicetax' );
					$servicedescription = $this->input->post( 'servicedescription' );
					$quantity = $this->input->post( 'quantity' );
					$unit = $this->input->post('unit');
					$project_id = $this->input->post( 'projectid' );
					$hasError = false;
					$data['message'] = '';
					if ($categoryid == '') {
						$hasError = true;
						$data['message'] = lang('selectinvalidmessage'). ' ' .lang('category');
					} else if ($productid == '') {
						$hasError = true;
						$data['message'] = lang('selectinvalidmessage'). ' ' .lang('product');
					} else if ($servicename == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('productname');
					} else if ($serviceprice == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('price');
					} else if ($servicetax == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('tax');
					} else if ($quantity == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('quantity');
					} else if ($unit == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('unit');
					} else if ($servicedescription == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage'). ' ' .lang('description');
					}

					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
	 				} 

	 				if (!$hasError) {
	 					$params = array(
	 						'categoryid' => $categoryid,
	 						'productid' => $productid,
	 						'servicename' => $servicename,
	 						'serviceprice' => $serviceprice,
	 						'servicetax' => $servicetax,
	 						'quantity' => $quantity,
	 						'unit' => $unit,
	 						'servicedescription' => $servicedescription,
	 						'projectid' => $this->input->post( 'projectid' ),
	 					);
	 					$this->db->where( 'id', $id );
	 					$this->db->update( 'projectservices', $params );
	 					$this->db->insert( 'logs', array(
	 						'date' => date( 'Y-m-d H:i:s' ),
	 						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated' ).' '.lang('service').' '.lang('for').' '.' <a href="projects/project/' . $project_id . '">' . get_number('projects',$project_id,'project','project') . '</a>' ),
	 						'staff_id' => $this->session->usr_id,
	 						'project_id' => $project_id,
	 					) );
						$data['success'] = true;
						$data['message'] = lang('service'). ' ' .lang('updatemessage');
						echo json_encode($data);
	 				}
	 			}
	 		} else {
	 			if ($hasError) {
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

	function get_project_services( $id ) {
		$data = $this->Projects_Model->get_project_services($id);
		echo json_encode($data);
	}

	function get_products_by_category( $id ) {
		$data = $this->Projects_Model->get_products_by_category($id);
		echo json_encode($data);
	}

	function markas_complete() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'project_id' => $_POST[ 'project_id' ],
					'status_id' => '5',
				); 
				$response = $this->Projects_Model->markas_complete();
				$template = $this->Emails_Model->get_template('project', 'project_status_changed');
				if ($template['status'] == 1) {
					$project = $this->Projects_Model->get_projects( $_POST[ 'project_id' ] );
					$project_url = '' . base_url( 'area/projects/project/' . $_POST[ 'project_id' ] . '' ) . '';
					switch ( $project[ 'status' ] ) {
						case '1':
							$status_project = lang( 'notsch' );
							break;
						case '2':
							$status_project = lang( 'schdule' );
							break;
						case '3':
							$status_project = lang( 'hold' );
							break;
						case '4':
							$status_project = lang( 'cancelled' );
							break;
						case '5':
							$status_project = lang( 'complete' );
							break;
					};
					if ( $project[ 'namesurname' ] ) {
						$customer = $project[ 'namesurname' ];
					} else {
						$customer = $project[ 'customercompany' ];
					}
					$message_vars = array(
						'{customer}' => $customer,
						'{project_name}' => $project[ 'name' ],
						'{project_start_date}' => $project[ 'start_date' ],
						'{project_end_date}' => $project[ 'deadline' ],
						'{project_value}' => $project[ 'projectvalue' ],
						'{project_tax}' => $project[ 'tax' ],
						'{loggedin_staff}' => $this->session->userdata('staffname'),
						'{project_url}' => $project_url,
						'{project_status}' => $status_project,
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
						'{project_description}' => $project['description']
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);
					$param = array(
						'from_name' => $template['from_name'],
						'email' => $project['customeremail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" )
					);
					if ($project['customeremail']) {
						$this->db->insert( 'email_queue', $param );
					}
				}
				$return['success'] = true;
				$return['message'] = lang('project_complete');
			}
		} else {
			$return['success'] = false;
			$return['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($return);
	}

	function markas() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				
				$deliveryid = $_POST[ 'deliveryid' ];
				$delivery_stage_id = $_POST[ 'delivery_stage_id' ];
				$address = $_POST[ 'address' ];
				$shipping_country_id = $this->input->post( 'shipping_country_id' );
				$shipping_state_id = $this->input->post( 'shipping_state_id' );
				$shipping_city = $this->input->post( 'shipping_city' );
				$shipping_zip = $this->input->post( 'shipping_zip' );
				$contact_number = $this->input->post( 'contact_number' );
				$contact_name = $this->input->post( 'contact_name' );
				$deliverydata = $this->db->get_where( 'delivery', array( 'id'=>$deliveryid  ))-> result_array();
				$appconfig = get_appconfig();
				$params = array(
					'description' => $deliverydata[0]["description"],
					'projectid' => $deliverydata[0]["projectid"],
					'delivery_date' => $deliverydata[0]["delivery_date"],
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'address' => $address,
					'stage_id' => $delivery_stage_id,
					'shipping_country_id' => $shipping_country_id,
					'shipping_state_id' => $shipping_state_id,
					'shipping_city' => $shipping_city,
					'shipping_zip' => $shipping_zip,
					'contact_name' => $contact_name,
					'contact_number' => $contact_number,
					'status_id' => 1,
					'created' => date( 'Y-m-d H:i:s' ), 
				);
				$this->db->insert( 'delivery', $params );
				$newdelivery_id = $this->db->insert_id();

				$response = $this->db->where( 'id', $delivery_stage_id )->update( 'subdelivery', array( 'complete' => 1 ,'update' => date( 'Y-m-d H:i:s' )) );
				$this->db->where( 'id', $deliveryid );
				$this->db->update('delivery', array('stage_id'=>$delivery_stage_id));

					$allProjectStages = $this->db->get_where( 'installation', array( '' ))->result_array();

					foreach($allProjectStages as $eachProjectStage) {
						$subprojectparams = array(
							'deliveryid' => $newdelivery_id,
							'delivery_stage_id' => $eachProjectStage['id'],
							'finished' => 0,
							'created' => date( 'Y-m-d H:i:s' ),
							'staff_id' => $this->session->userdata( 'usr_id' ),
							'complete' => 0,
							'update'=>date( 'Y-m-d H:i:s' ),
					);
						$this->db->insert( 'subdelivery', $subprojectparams );
					}
					$appconfig = get_appconfig();
					$number = $appconfig['project_series'] ? $appconfig['project_series'] : $newdelivery_id;
					$delivery_number = $appconfig['delivery_prefix'].$number;
					$this->db->where('id', $newdelivery_id)->update( 'delivery', array('delivery_number' => $delivery_number ) );

					$array = array('deliveryid' => $newdelivery_id, 'delivery_stage_id' => $delivery_stage_id);
					 $this->db->where( $array)->update( 'subdelivery', array( 'complete' => 1 ) );

				
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function addmilestone( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$order = $this->input->post( 'order' );
				$description = $this->input->post( 'description' );
				$hasError = false;
				$data['message'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($this->input->post( 'duedate' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('duedate');
				} else if ($description == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('description');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				} 

				if (!$hasError) {
					$params = array(
						'project_id' => $id,
						'name' => $name,
						'order' => $order,
						'duedate' => _phdate( $this->input->post( 'duedate' ) ),
						'description' => $description,
						'created' => date( 'Y-m-d' ),
						'color' => 'green',
					);
					$response = $this->Projects_Model->add_milestone( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('milestone'). ' ' .lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function updatemilestone( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$description = $this->input->post( 'description' );
				$hasError = false;
				$data['message'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('name');
				} else if ($this->input->post( 'duedate' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('duedate');
				} else if ($description == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('description');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				} 
				if (!$hasError) {
					$params = array(
						'order' => $this->input->post( 'order' ),
						'name' => $this->input->post( 'name' ),
						'description' => $this->input->post( 'description' ),
						'duedate' => $this->input->post( 'duedate' ),
					);
					$response = $this->Projects_Model->update_milestone( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('milestone'). ' ' .lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function removemilestone() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST[ 'milestone' ] ) ) {
				$milestone = $_POST[ 'milestone' ];
				$response = $this->db->delete( 'milestones', array( 'id' => $milestone ) );
				$data['success'] = true;
				$data['message'] = lang('milestone'). lang('deleted');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function addtask( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tasks', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $this->input->post( 'name' );
				$description =  $this->input->post( 'description' );
				$priority = $this->input->post( 'priority' );
				$assigned = $this->input->post( 'assigned' );

				$hasError = false;
				$data['message'] = '';
				if ($name == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('task'). ' ' .lang('name');
				} else if ($assigned == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned');
				} else if ($priority == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('priority');
				} else if ($description == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('description');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				} 

				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'name' => $name,
						'description' => $description,
						'priority' => $priority,
						'assigned' => $assigned,
						'relation_type' => 'project',
						'relation' => $id,
						'milestone' => $this->input->post( 'milestone' ),
						'public' => $this->input->post( 'public' ),
						'billable' => $this->input->post( 'billable' ),
						'visible' => $this->input->post( 'visible' ),
						'hourly_rate' => $this->input->post( 'hourlyrate' ),
						'startdate' => $this->input->post( 'startdate' ),
						'duedate' => $this->input->post( 'duedate' ),
						'addedfrom' => $this->session->userdata( 'usr_id' ),
						'status_id' => 1,
						'created' => date( 'Y-m-d H:i:s' ),
					);
					$this->session->set_flashdata( 'ntf1', '<b>'.lang( 'task_added' ).'</b>' );
					$this->db->insert( 'tasks', $params );
					$task_id = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['task_series'] ? $appconfig['task_series'] : $task_id;
					$task_number = $appconfig['task_prefix'].$number;
					$this->db->where('id', $task_id)->update( 'tasks', array('task_number' => $task_number ) );
					if($appconfig['task_series']){
						$task_number = $appconfig['task_series'];
						$task_number = $task_number + 1 ;
						$this->Settings_Model->increment_series('task_series',$task_number);
					}
					$loggedinuserid = $this->session->usr_id;
					$staffname = $this->session->staffname;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ).' '.lang('task').' '.lang('for').' '.' <a href="projects/project/' . $id . '">' . get_number('projects',$id,'project','project') . '</a>' ),
						'staff_id' => $loggedinuserid,
						'project_id' => $id,
					) );
					$template = $this->Emails_Model->get_template('task', 'new_task_assigned'); 
					if ($template['status'] == 1) {
						$tasks = $this->Tasks_Model->get_task_detail( $task_id );
						$task_url = '' . base_url( 'tasks/task/' . $task_id . '' ) . '';
						$settings = $this->Settings_Model->get_settings_ciuis();
						switch ( $tasks[ 'status_id' ] ) {
							case '1':
								$status = lang( 'open' );
								break;
							case '2':
								$status = lang( 'inprogress' );
								break;
							case '3':
								$status = lang( 'waiting' );
								break;
							case '4':
								$status = lang( 'complete' );
								break;
							case '5':
								$status = lang( 'cancelled' );
								break;
						};
						switch ( $tasks[ 'priority' ] ) {
							case '1':
								$priority = lang( 'low' );
								break;
							case '2':
								$priority = lang( 'medium' );
								break;
							case '3':
								$priority = lang( 'high' );
								break;
							default: 
								$priority = lang( 'medium' );
								break;
						};
						$message_vars = array(
							'{task_name}' => $tasks[ 'name' ],
							'{task_startdate}' => $tasks[ 'startdate' ],
							'{task_duedate}' => $tasks[ 'duedate' ],
							'{task_priority}' => $priority,
							'{task_url}' => $task_url,
							'{staffname}' => $tasks[ 'assigner' ],
							'{task_status}' => $status,
							'{company_name}' => $settings['company'],
							'{company_email}' => $settings['email'],
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $tasks['staffemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($tasks['staffemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$data['message'] = lang('task'). ' ' .lang('createmessage');
					echo json_encode($data);
				}
			} else {
	 			if ($hasError) {
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

	function addmember() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$staff = $_POST[ 'staff' ];
				$projectId = $_POST[ 'project' ];
				$members = $this->Delivery_Model->get_members($projectId);
				$hasError = false;
				$data['message'] = '';
				if ($staff == '' || $staff == null) {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('staff');
				} else {
					foreach ($members as $member) {
						if (($member['project_id'] == $projectId) && ($member['staff_id'] == $staff)) {
							$hasError = true;
							$data['message'] = lang('same').' '.lang('staff'). ' '.lang('duplicate_message');
							continue;
						}
					}
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$params = array(
						'staff_id' => $staff,
						'project_id' => $_POST[ 'project' ],
					);
					$this->db->insert( 'deliverymembers', $params );
					$this->db->insert( 'notifications', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( lang( 'assignednewproject' ) ),
						'perres' => $this->session->staffavatar,
						'staff_id' => $_POST[ 'staff' ],
						'target' => '' . base_url( 'delivery/delivery/' . $_POST[ 'project' ] . '' ) . ''
					) );
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $this->session->staffname . lang('added_a_member_project') ),
						'staff_id' => $this->session->usr_id,
						'project_id' => $_POST[ 'project' ],
					) );
					$member_detail = $this->Staff_Model->get_staff( $_POST[ 'staff' ] );




					$data['success'] = true;
					$data['message'] = lang('project'). ' ' .lang('createmessage');
					$data['member'] = $member_detail;
					echo json_encode( $data );
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function unlinkmember( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST[ 'linkid' ] ) ) {
				$linkid = $_POST[ 'linkid' ];
				$response = $this->db->where( 'id', $linkid )->delete( 'deliverymembers', array( 'id' => $linkid ) );
				$data['success'] = true;
				$data['message'] = lang('staff'). ' '.lang('deletemessage');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file($id);
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'files', array( 'id' => $id ) );
					if ($fileData['is_old'] == '1') {
						if (is_file('./uploads/files/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/' . $fileData['file_name']);
				    	}
					} else {
						if (is_file('./uploads/files/delivery/'.$fileData['relation'].'/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/delivery/'.$fileData['relation'].'/' . $fileData['file_name']);
				    	}
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
				redirect('projects');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function add_file( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $id ) ) {
				if ( isset( $_POST ) ) {
					if (!is_dir('uploads/files/delivery/'.$id)) { 
						mkdir('./uploads/files/delivery/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/delivery/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
					$config['file'] = $new_name;
					$this->load->library( 'upload', $config );
					if (!$this->upload->do_upload('file')) {
						$data['success'] = false;
						$data['message'] = $this->upload->display_errors();
						echo json_encode($data);
					} else {
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/delivery/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params = array(
								'relation_type' => 'delivery',
								'relation' => $id,
								'file_name' => $image_data[ 'file_name' ],
								'created' => date( " Y.m.d H:i:s " ),
								'is_old' => '0'
							);
							$this->db->insert( 'files', $params );

							$data['success'] = true;
							$data['message'] = lang('file').' '.lang('uploadmessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = lang('errormessage');
							echo json_encode($data);
						} 
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function download_file($id) {
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file( $id );
			if ($fileData['is_old'] == '1') {
				if (is_file('./uploads/files/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('delivery/delivery/'.$fileData['relation']);
		    	}
			} else {
				if (is_file('./uploads/files/delivery/'.$fileData['relation'].'/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/delivery/'.$fileData['relation'].'/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('delivery/delivery/'.$fileData['relation']);
		    	}
		    }
				
		}
	}

	function checkpinned() {
		if ( isset( $_POST[ 'project' ] ) ) {
			$project = $_POST[ 'project' ];
			$response = $this->db->where( 'id', $project )->update( 'projects', array( 'pinned' => 1 ) );
			$data['success'] = true;
			$data['message'] = lang('pinnedprojects');
		}
		echo json_encode($data);
	}

	function unpinned() {
		if ( isset( $_POST[ 'pinnedproject' ] ) ) {
			$pinnedproject = $_POST[ 'pinnedproject' ];
			$response = $this->db->where( 'id', $pinnedproject )->update( 'projects', array( 'pinned' => 0 ) );
			$data['success'] = true;
			$data['message'] = lang('unpinned').' '.lang('project');
		}
		echo json_encode($data);
	}

	function addexpense( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'expenses', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$category_id = $this->input->post( 'category' );
				$customer_id = $this->input->post( 'customer' );
				$account_id = $this->input->post( 'account' );
				$title = $this->input->post( 'title' );
				$date = $this->input->post( 'date' );
				$amount = $this->input->post( 'amount' );
				$description = $this->input->post( 'description' );

				$hasError = false;
				if ($title == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('title');
				} else if ($amount == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('amount');
				} else if ($category_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('category');
				} else if ($account_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('account');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}

				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'category_id' => $category_id,
						'staff_id' => $this->session->usr_id,
						'customer_id' => $customer_id,
						'relation_type' => 'project',
						'relation' => $id,
						'account_id' => $account_id,
						'title' => $title,
						'date' => $date,
						'created' => date( 'Y-m-d H:i:s' ),
						'amount' => $amount,
						'description' => $description,
						'internal' => '1',
						'total_tax' => '0',
						'total_discount' => '0',
						'sub_total' => $amount,
					);
					$this->db->insert( 'expenses', $params );
					$expense_id = $this->db->insert_id();
					$appconfig = get_appconfig();
					$number = $appconfig['expense_series'] ? $appconfig['expense_series'] : $expense_id;
					$expense_number = $appconfig['expense_prefix'].$number;
					$this->db->where('id', $expense_id)->update( 'expenses', array('expense_number' => $expense_number ) );
					if($appconfig['expense_series']){
						$expense_number = $appconfig['expense_series'];
						$expense_number = $expense_number + 1 ;
						$this->Settings_Model->increment_series('expense_series',$expense_number);
					}

					$item = array(
						'relation_type' => 'expense',
						'relation' => $expense_id,
						'product_id' => '',
						'code' => '',
						'name' => $this->input->post( 'name' ),
						'description' => $description,
						'quantity' => '1',
						'unit' => '1',
						'price' => $amount,
						'tax' => '0',
						'discount' => '0',
						'total' => $amount,
					);
					$this->db->insert( 'items', $item);
					$loggedinuserid = $this->session->usr_id;
					$appconfig = get_appconfig();
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ).' '.lang('expense').' '.lang('for').' '.' <a href="projects/project/' . $id . '">' . get_number('projects',$id,'project','project') . '</a>' ),
						'staff_id' => $loggedinuserid,
						'project_id' => $id,
						'customer_id' => $this->input->post( 'customer' )
					));
					$template = $this->Emails_Model->get_template('expense', 'expense_created');
					if ($template['status'] == 1) {
						$expense = $this->Expenses_Model->get_expenses( $expense_id );
						if ( $expense[ 'individual' ] ) {
							$customer = $expense[ 'individual' ];
						} else {
							$customer = $expense[ 'customer' ];
						}
						$message_vars = array(
							'{customer}' => $customer,
							'{expense_number}' => get_number('expenses', $expense['id'], 'expense', 'expense'),
							'{expense_title}' => $expense[ 'title' ],
							'{expense_category}' => $expense[ 'category' ],
							'{expense_date}' => $expense[ 'date' ],
							'{expense_description}' => $expense[ 'description' ],
							'{expense_amount}' => $expense[ 'amount' ],
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);

						$param = array(
							'from_name' => $template['from_name'],
							'email' => $expense['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($expense['customeremail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$data['message'] = lang('expense'). ' ' .lang('createmessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function convert( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'invoices', 'create' ) ) {
			$project = $this->Projects_Model->get_projects( $id );
			if ( isset( $_POST ) && count( $_POST ) > 0 ) { 
				$services = $this->Projects_Model->get_project_services($id);
				$params = array(
					'token' => md5( uniqid() ),
					'staff_id' => $project[ 'staff_id' ],
					'customer_id' => $project[ 'customer_id' ],
					'created' => date( 'Y-m-d H:i:s' ),
					'status_id' => 3,
					'total_discount' => 0,
					'total_tax' => 0,
					'total' => $this->input->post( 'total' ),
					'project_id' => $id,
					'sub_total' => $this->input->post( 'total' ),
				);
				$this->db->insert( 'invoices', $params );
				$invoice = $this->db->insert_id();
				$total = 0;
				$total_tax = 0;
				$sub_total = 0;
				foreach ( $services as $service ) {
					$this->db->insert( 'items', array(
						'relation_type' => 'invoice',
						'relation' => $invoice,
						'name' => $service[ 'servicename' ],
						'description' => $service[ 'servicedescription' ],
						'quantity' => $service[ 'quantity' ],
						'unit' => $service[ 'unit' ],
						'price' => $service[ 'serviceprice' ],
						'tax' => $service[ 'servicetax' ],
						'discount' => 0,
						'total' => $service[ 'quantity' ] * $service[ 'serviceprice' ] + ( ( $service[ 'servicetax' ] ) / 100 * $service[ 'quantity' ] * $service[ 'serviceprice' ] ),
					) );
					$total += $service[ 'quantity' ] * $service[ 'serviceprice' ] + ( ( $service[ 'servicetax' ] ) / 100 * $service[ 'quantity' ] * $service[ 'serviceprice' ] );
					$total_tax += ( $service[ 'servicetax' ] ) / 100 * $service[ 'quantity' ] * $service[ 'serviceprice' ];
				};
				$sub_total = $total - $total_tax;
				$response = $this->db->where( 'id', $invoice )->update( 'invoices', array( 'total' => $total, 'sub_total' => $sub_total, 'total_tax' => $total_tax ) );
				$this->db->insert( $this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project[ 'customer_id' ],
					'total' => $total,
					'date' => date( 'Y-m-d H:i:s' )
				) );
				$staffname = $this->session->staffname;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $message = sprintf( lang( 'projecttoinvoicelog' ), $staffname, $project[ 'id' ] ) . '' ),
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project[ 'customer_id' ],
				) );
				$response = $this->db->where( 'id', $id )->update( 'projects', array( 'invoice_id' => $invoice ) );
				$data['id'] = $invoice;
				$data['success'] = true;
				echo json_encode($data) ;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function convertwithcost( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'invoices', 'create' ) ) {
			$project = $this->Projects_Model->get_projects( $id );
			if ( isset( $_POST ) && count( $_POST ) > 0 ) { 
				$services = $this->Projects_Model->get_project_services($id);
				$params = array(
					'token' => md5( uniqid() ),
					'staff_id' => $project[ 'staff_id' ],
					'customer_id' => $project[ 'customer_id' ],
					'created' => date( 'Y-m-d H:i:s' ),
					'status_id' => 3,
					'total_discount' => 0,
					'total_tax' => 0,
					'total' => $this->input->post( 'total' ),
					'project_id' => $id,
					'sub_total' => $this->input->post( 'total' ),
				);
				$this->db->insert( 'invoices', $params );
				$invoice = $this->db->insert_id();

				$this->db->insert( 'items', array(
					'relation_type' => 'invoice',
					'relation' => $invoice,
					'name' => $this->input->post( 'name' ),
					'description' => $this->input->post( 'description' ),
					'quantity' => 1,
					'unit' => 'Unit',
					'price' => $this->input->post( 'cost' ),
					'tax' => $this->input->post( 'tax' ),
					'discount' => 0,
					'total' => 1 * $this->input->post( 'cost' ) + ( ( $this->input->post( 'tax' ) ) / 100 * 1 * $this->input->post( 'cost' ) ),
					) );

				$total = 0;
				$sub_total = 0;
				$total_tax = ( $this->input->post( 'tax' ) ) / 100 * 1 * $this->input->post( 'cost' );
				$total = 1 * $this->input->post( 'cost' ) + ( ( $this->input->post( 'tax' ) ) / 100 * 1 * $this->input->post( 'cost' ) );
				$sub_total = $total - $total_tax;
				$response = $this->db->where( 'id', $invoice )->update( 'invoices', array( 'total' => $total, 'sub_total' => $total, 'total_tax' => $total_tax ) );

				foreach ( $services as $service ) {
					$this->db->insert( 'items', array(
						'relation_type' => 'invoice',
						'relation' => $invoice,
						'name' => $service[ 'servicename' ],
						'description' => $service[ 'servicedescription' ],
						'quantity' => $service[ 'quantity' ],
						'unit' => $service[ 'unit' ],
						'price' => 0,
						'tax' => 0,
						'discount' => 0,
						'total' => 0,
					) );
				};

				$this->db->insert( $this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project[ 'customer_id' ],
					'total' => $total,
					'date' => date( 'Y-m-d H:i:s' )
				) );
				$staffname = $this->session->staffname;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $message = sprintf( lang( 'projecttoinvoicelog' ), $staffname, $project[ 'id' ] ) . '' ),
					'staff_id' => $this->session->usr_id,
					'customer_id' => $project[ 'customer_id' ],
				) );
				$response = $this->db->where( 'id', $id )->update( 'projects', array( 'invoice_id' => $invoice ) );
				$data['id'] = $invoice;
				$data['success'] = true;
				echo json_encode($data) ;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function removeService( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			$services = $this->Projects_Model->get_project_service( $id );
			if ( isset( $services[ 'id' ] ) ) {
				$number = get_number('projects', $services['projectid'], 'project', 'project');
				$this->Projects_Model->delete_service( $id, $number );
				$data['success'] = true;
				$data['message'] = lang('service') . ' ' . lang('deletemessage');
			} else {
				$data['success'] = false;
				$data['message'] = lang('servicedoesnotexist');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	/* Remove Project */
	function remove( $id ) {
			$project = $this->Delivery_Model->get_delivery( $id );

		
		if($project) {
					$this->Delivery_Model->delete_delivery( $id, $project[0]["delivery_number"]);
					$data['success'] = true;
				
		
			echo json_encode($data);
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function customer_proposals($id) {
		$project = $this->Projects_Model->get_projects( $id );
		if (isset($project['id'])) {
			$proposals = $this->Proposals_Model->customer_proposals($project['customer_id']);
			echo json_encode($proposals);
		}
	}

	function get_proposals($id) {
		$project = $this->Projects_Model->get_projects( $id );
		if (isset($project['id'])) {
			$proposals = $this->Proposals_Model->project_proposals($id);
			$data_proposals = array();
			foreach ( $proposals as $proposal ) {
				$pro = $this->Proposals_Model->get_proposals( $proposal[ 'id' ], $proposal[ 'relation_type' ] );
				if ( $pro[ 'relation_type' ] == 'customer' ) {
					if ( $pro[ 'customercompany' ] === NULL ) {
						$customer = $pro[ 'namesurname' ];
					} else $customer = $pro[ 'customercompany' ];
				}
				if ( $pro[ 'relation_type' ] == 'lead' ) {
					$customer = $pro[ 'leadname' ];
				}
				$settings = $this->Settings_Model->get_settings_ciuis();
				switch ( $settings[ 'dateformat' ] ) {
					case 'yy.mm.dd':
						$date = _rdate( $proposal[ 'date' ] );
						$opentill = _rdate( $proposal[ 'opentill' ] );
						break;
					case 'dd.mm.yy':
						$date = _udate( $proposal[ 'date' ] );
						$opentill = _udate( $proposal[ 'opentill' ] );
						break;
					case 'yy-mm-dd':
						$date = _mdate( $proposal[ 'date' ] );
						$opentill = _mdate( $proposal[ 'opentill' ] );
						break;
					case 'dd-mm-yy':
						$date = _cdate( $proposal[ 'date' ] );
						$opentill = _cdate( $proposal[ 'opentill' ] );
						break;
					case 'yy/mm/dd':
						$date = _zdate( $proposal[ 'date' ] );
						$opentill = _zdate( $proposal[ 'opentill' ] );
						break;
					case 'dd/mm/yy':
						$date = _kdate( $proposal[ 'date' ] );
						$opentill = _kdate( $proposal[ 'opentill' ] );
						break;
				};
				switch ( $proposal[ 'status_id' ] ) {
					case '0':
						$status = lang( 'quote' ).' '.lang( 'request' );
						$class = 'proposal-status-open';
						break;
					case '1':
						$status = lang( 'draft' );
						$class = 'proposal-status-accepted';
						break;
					case '2':
						$status = lang( 'sent' );
						$class = 'proposal-status-sent';
						break;
					case '3':
						$status = lang( 'open' );
						$class = 'proposal-status-open';
						break;
					case '4':
						$status = lang( 'revised' );
						$class = 'proposal-status-revised';
						break;
					case '5':
						$status = lang( 'declined' );
						$class = 'proposal-status-declined';
						break;
					case '6':
						$status = lang( 'accepted' );
						$class = 'proposal-status-accepted';
						break;

				};
				$appconfig = get_appconfig();
				$data_proposals[] = array(
					'id' => $proposal[ 'id' ],
					'assigned' => $proposal[ 'assigned' ],
					'prefix' => $appconfig['proposal_prefix'],
					'longid' => get_number('proposals',$proposal['id'],'proposal','proposal'),
					'subject' => $proposal[ 'subject' ],
					'customer' => $customer,
					'relation' => $proposal[ 'relation' ],
					'date' => $date,
					'opentill' => $opentill,
					'status' => $status,
					'status_id' => $proposal[ 'status_id' ],
					'staff' => $proposal[ 'staffmembername' ],
					'staffavatar' => $proposal[ 'staffavatar' ],
					'total' => $proposal[ 'total' ],
					'class' => $class,
					'relation_type' => $proposal[ 'relation_type' ],
					'' . lang( 'relationtype' ) . '' => $proposal[ 'relation_type' ],
					'' . lang( 'filterbystatus' ) . '' => $status,
					'' . lang( 'filterbycustomer' ) . '' => $customer,
					'' . lang( 'filterbyassigned' ) . '' => $proposal[ 'staffmembername' ],
				);
			};
			echo json_encode( $data_proposals );
		}
	}

	function link_proposal($id) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			$project = $this->Projects_Model->get_projects( $id );
			if (isset($project['id'])) {
				$pro_id = $this->input->post('proposal');
				$check = $this->Proposals_Model->check_project_id($id, $pro_id);
				$hasError = false;
				if ($pro_id == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage').' '. lang('proposal');
				} else if ($check == 'exist') {
					$hasError = true;
					$data['message'] = lang('proposal').' '.lang('already_linked').' '.lang('project');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$this->db->where( 'id', $pro_id );
					$response = $this->db->update( 'proposals', array('project_id' => $id));
					$data['message'] = lang('proposal').' '.lang('link_message');
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

	function proposal_create($id) {
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'create' ) ) {
			$project = $this->Projects_Model->get_projects( $id );
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$proposal_type = $this->input->post( 'proposal_type' );
				$customer = $this->input->post('customer');
				$subject = $this->input->post('subject');
				$assigned = $this->input->post('assigned');
				$proposal_type = $this->input->post('proposal_type');
				$date = $this->input->post('date');
				$opentill = $this->input->post('opentill');
				$total = $this->input->post('total');
				$lead = $this->input->post('lead');
				$status = $this->input->post('status');
				$total_items = $this->input->post('total_items');
				$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
				
				$hasError = false;
				$data['message'] = '';
				if ($subject == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('subject');
				} else if ($date == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('issue'). ' ' .lang('date');
				} else if ($opentill == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('end'). ' ' .lang('date');
				} else if (strtotime($opentill) < strtotime($date)) {
					$hasError = true;
					$data['message'] = lang('issue'). ' ' .lang('date').' '.lang('date_error'). ' ' .lang('end'). ' ' .lang('date');
				} else if ($assigned == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned');
				} else if ($status == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
				} else if ($total_items == '0') {
					$hasError = true;
					$data['message'] = lang('invalid_items');
				} else if ($total == 0) {
					$hasError = true;
					$data['message'] = lang('invalid_total');
				}

				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$allow_comment = $this->input->post( 'comment' );
					if ( $allow_comment != true ) {
						$comment_allow = 0;
					} else {
						$comment_allow = 1;
					};
					$params = array(
						'token' => md5( uniqid() ),
						'subject' => $this->input->post( 'subject' ),
						'content' => $this->input->post( 'content' ),
						'date' => _pdate( $this->input->post( 'date' ) ),
						'created' => date( 'Y-m-d H:i:s' ),
						'opentill' => _pdate( $this->input->post( 'opentill' ) ),
						'relation_type' => 'customer',
						'relation' => $project['customer_id'],
						'assigned' => $this->input->post( 'assigned' ),
						'project_id' => $id,
						'addedfrom' => $this->session->usr_id,
						'datesend' => _pdate( $this->input->post( 'datesend' ) ),
						'comment' => $comment_allow,
						'status_id' => $this->input->post( 'status' ),
						'invoice_id' => $this->input->post( 'invoice' ),
						'dateconverted' => $this->input->post( 'dateconverted' ),
						'sub_total' => $this->input->post( 'sub_total' ),
						'total_discount' => $this->input->post( 'total_discount' ),
						'total_tax' => $this->input->post( 'total_tax' ),
						'total' => $this->input->post( 'total' ),
					);
					$proposals_id = $this->Projects_Model->proposal_add( $params );
					$template = $this->Emails_Model->get_template('proposal', 'send_proposal');
					if ($template['status'] == 1) {
						$pro = $this->Proposals_Model->get_pro_rel_type( $proposals_id );
						$rel_type = $pro[ 'relation_type' ];
						$proposal = $this->Proposals_Model->get_proposals( $proposals_id, $rel_type );
						if ($rel_type == 'customer') { 
							$customer = $proposal['customercompany'] ? $proposal['customercompany'] : $proposal['namesurname'];
						} else {
							$customer = $proposal['leadname'];
						}
						$link = base_url( 'share/proposal/' . $proposal[ 'token' ] . '' );
						$message_vars = array(
							'{proposal_to}' => $customer,
							'{customer}' => $customer,
							'{proposal_number}' => $proposals_id,
							'{proposal_link}' => $link,
							'{subject}' => $this->input->post( 'subject' ),
							'{details}' => $this->input->post( 'content' ),
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{open_till}' => _pdate( $this->input->post( 'opentill' ) )
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);
						$param = array(
							'from_name' => $template['from_name'],
							'email' => $proposal['toemail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($proposal['toemail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$data['message'] = lang('proposal'). ' '. lang('createmessage');
					$data['proposal_id'] = $proposals_id;
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function download_pdf($id) {
		if (isset($id)) {
			$appconfig = get_appconfig();
			$file_name = '' . get_number('project', $id, 'project', 'project') . '.pdf';
			if (is_file('./uploads/files/expenses/'.$id.'/' . $file_name)) {
	    		$this->load->helper('file');
	    		$this->load->helper('download');
	    		$data = file_get_contents('./uploads/files/expenses/'.$id.'/' . $file_name);
	    		force_download($file_name, $data);
	    	} else {
	    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
	    		redirect('expenses/receipt/'.$id);
	    	}
		} else {
			redirect('expenses/receipt/'.$id);
		}
	}

	function create_pdf($id) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'all' ) ) {
			$project = $this->Projects_Model->get_project_by_priviliges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'projects', 'own') ) {
			$projects = $this->Projects_Model->get_projects( $id );
			if (($projects['staff_id'] == $this->session->usr_id) || ($this->Projects_Model->check_member($projects['id'], $this->session->usr_id)) == 'true') {
				$project = $this->Projects_Model->get_projects( $id );
			}
		} else {
			$result['success'] = false;
			$result['message'] = lang('you_dont_have_permission');
			echo json_encode($result);
		}
		if($project) {
			ini_set('max_execution_time', 0); 
			ini_set('memory_limit','2048M');
			if (!is_dir('uploads/files/projects/'.$id)) {
				mkdir('./uploads/files/projects/'.$id, 0777, true);
			}
			switch ($project[ 'status' ]) {
				case '1':
					$status_project = lang( 'notstarted' );
					break;
				case '2':
					$status_project = lang( 'started' ); 
					break;
				case '3':
					$status_project = lang( 'percentage' );
					break;
				case '4':
					$status_project = lang( 'cancelled' );
					break;
				case '5':
					$status_project = lang( 'completed' );
					break;
			};
			$data['logs'] = $this->projecttimelogs($id);
			$data['settings'] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
			$data['country'] = get_country($data[ 'settings' ]['country_id']);
			$data['billing_country'] = get_country($project['country_id']);
			$data['billing_state'] = get_state_name($project['billing_state'],$project['billing_state_id']);
			$data['project'] = $project;
			$data['status'] = $status_project;
			$data['color'] = $this->input->post('color');
			$data['services'] = '';
			$data['customer'] = false;
			$data['is_summary'] = false;
			$data['milestones'] = '';
			$data['tasks'] = '';
			$data['expenses'] = '';
			$data['proposals'] = '';
			$data['tickets'] = '';
			$data['members'] = '';
			$data['files'] = '';
			$data['notes'] = '';
			$data['time_logs'] = '';

			
			if ($this->input->post('customer') == 'true') {
				$data['customer'] = true;
			} else {
				$data['customer'] = false;
			}
			if ($this->input->post('services') == 'true') {
				$data['services'] = $this->Projects_Model->get_project_services($id);
			} else {
				$data['services'] = '';
			}
			if ($this->input->post('milestones') == 'true') {
				$data['milestones'] = $this->Projects_Model->get_all_project_milestones($id);
			} else {
				$data['milestones'] = '';
			}
			if ($this->input->post('tasks') == 'true') {
				$data['tasks'] = $this->Tasks_Model->get_project_tasks($id);
			} else {
				$data['tasks'] = '';
			}
			if ($this->input->post('expenses') == 'true') {
				$data['expenses'] = $this->Expenses_Model->get_all_expenses_by_relation('project', $id);
			} else {
				$data['expenses'] = '';
			}
			if ($this->input->post('proposals') == 'true') {
				$data['proposals'] = $this->Proposals_Model->project_proposals($id);
			} else {
				$data['proposals'] = '';
			}
			if ($this->input->post('tickets') == 'true') {
				$data['tickets'] = $this->Projects_Model->get_all_tickets($id);
			} else {
				$data['tickets'] = '';
			}
			if ($this->input->post('peoples') == 'true') {
				$data['members'] = $this->Projects_Model->get_members_index($id);
			} else {
				$data['members'] = '';
			}
			if ($this->input->post('files') == 'true') {
				$data['files'] = $this->Projects_Model->get_project_files($id);
			} else {
				$data['files'] = '';
			}
			if ($this->input->post('notes') == 'true') {
				$data['notes'] = $this->Projects_Model->get_project_notes($id);
			} else {
				$data['notes'] = '';
			}
			if ($this->input->post('time_logs') == 'true') {
				$data['time_logs'] = $data['logs'];
			} else {
				$data['time_logs'] = '';
			}
			if ($this->input->post('summary') == 'true') {
				$data['is_summary'] = true;
				$data['summary'] = $this->project_summary($id);
			} else {
				$data['is_summary'] = false;
			}
			$appconfig = get_appconfig();
			$file_name = '' . get_number('projects', $id, 'project', 'project') . '.pdf';
			$html = $this->load->view('projects/pdf', $data, TRUE);
			$this->load->library( 'dom' );
			$this->dompdf->loadHtml( $html );
			$this->dompdf->set_option('isRemoteEnabled', TRUE );
			$this->dompdf->setPaper('A4', 'portrait' );
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents( 'uploads/files/projects/'.$id.'/' . $file_name . '', $output ); 
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ($output) {
				$result = array(
					'success' => true,
					'file_name' => $file_name,
				);
				$this->Projects_Model->update_pdf_status($id, '1');
				echo json_encode( $result );
			} else {
				redirect( base_url('projects/pdf_fault/'));
			}
		} else {
			$result['success'] = false;
			$result['message'] = lang('you_dont_have_permission');
			echo json_encode($result);
		}
	}

	function project_summary($id) {
		$summary = array(
			'expenses' => $this->db->get_where('expenses', array('relation' => $id, 'relation_type' => 'project' ))->num_rows(),
			'tickets' => $this->db->get_where( 'tickets', array('relation_id' => $id, 'relation' => 'project',) )->num_rows(),
			'proposals' => $this->db->get_where( 'proposals', array( 'proposals.project_id' => $id) )->num_rows(),
			'tasks' => $this->db->get_where( 'tasks', array( 'tasks.relation_type' => 'project', 'tasks.relation' => $id) )->num_rows(),
			'milestones' => $this->db->get_where( 'milestones', array( 'project_id' => $id ) )->num_rows(),
			'members' => $this->db->get_where( 'projectmembers', array( 'projectmembers.project_id' => $id ) )->num_rows(),
			'files' => $this->db->get_where( 'files', array( 'files.relation_type' => 'project', 'files.relation' => $id ) )->num_rows(),
			'services' => $this->db->get_where( 'projectservices', array( 'projectservices.projectid' => $id ) )->num_rows()
		);
		return $summary;
	}

	function pdf_generates( $file ) {
		return true;
	}

	function pdf_generated( $file ) {
		$result = array(
			'status' => true,
			'file_name' => $file,
		);
		echo json_encode( $result );
	}

	function projecttimelogs( $id ) {
		$timelogs = $this->Projects_Model->get_project_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $timelog[ 'task_id' ] );
			$date1 = new DateTime($timelog['start']);
			$diffs = $date1->diff(new DateTime($timelog['end']));
			$h = $diffs->days * 24;
			$h += $diffs->h;
			$minutes = $diffs->i;
			$seconds = $diffs->s;
			if ($minutes < 10) {
				$minutes = $minutes;
			}
			if ($seconds < 10) {
				$seconds = $seconds;
			}
			if ($h < 10) {
				$h = $h;
			}
			$total = $h.':'.$minutes.':'.$seconds;
			$minutess = $h*60 + $minutes;
			if ($task[ 'hourly_rate' ] > 0) {
				$amounts = ($h+($minutes / 60)) * $task[ 'hourly_rate' ];
			} else {
				$amounts = 0;
			}
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'note' => $timelog[ 'note' ],
					'staff' => $timelog[ 'staffmember' ],
					'status' => $timelog[ 'status' ],
					//'timed' => $timed_minute,
					'total_logged' => $total,
					'total_amount' => $amounts,
					'minutes' => $minutess,
					'rate' => $task[ 'hourly_rate' ],
					'amount' => $amounts,
				);
			}
		};
		return $data_timelogs;
	}

	function delivery_stats() {
		$stats = $this->Delivery_Model->get_all_deliverystatus();
		$finalstatus =  array('sumstarted' => $stats[0][ 'sumstarted' ],
		'sumnotstarted' => $stats[0][ 'sumnotstarted' ],
		'sumhold' => $stats[0][ 'sumhold' ],
		'sumcancelled' => $stats[0][ 'sumcancelled' ],
		'sumcomplete' => $stats[0][ 'sumcomplete' ]);
		echo json_encode($finalstatus);
	}

	function get_deliverys( $id ) {
		$project = array();
		$project = $this->Delivery_Model->get_delivery( $id );

		if($project) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			$milestones = $this->Projects_Model->get_all_project_milestones( $id );
			$projectmembers = $this->Delivery_Model->get_members( $id );
			$get_last_status = $this->Delivery_Model->get_last_status( $id );
			$fetquerry = $this->db->last_query();
			$project_logs = $this->Logs_Model->project_logs( $id );
			$last_status = 	$get_last_status[0]['stagename'];
			$percentage_completed = $this->Delivery_Model->GetdeliveryStatusByStage($id);
			$customer = ($project['customercompany'])?$project['customercompany']:$project['namesurname'];
			$enddate = $project[ 'delivery_date' ];
			$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( $settings[ 'default_timezone' ] ) );
			$end_date = new DateTime( "$enddate", new DateTimeZone( $settings[ 'default_timezone' ] ) );
			$interval = $current_date->diff( $end_date );
			$project_left_date = $interval->format( '%a day(s)' );
			if ( date( "Y-m-d" ) > $project[ 'delivery_date' ] ) {
				$ldt = 'Time\'s up!';
			} else $ldt = $project_left_date;
			switch ( $project[ 'status' ] ) {
				case '1':
					$status_project = lang( 'notsch' );
					$status_class = 'notstarted';
					$status_type="#ff43df";
					break;
				case '2':
					$status_project = lang( 'schdule' ); 
					$status_class = 'started';
					$status_type="#ff2946";
					break;
				case '3':
					$status_project = lang( 'hold' );
					$status_class = 'hold';
					$status_type="#0645f5";
					break;
				case '4':
					$status_project = lang( 'cancelled' );
					$status_class = 'cancelled';
					$status_type="#e8ab00";
					break;
				case '5':
					$status_project = lang( 'completed' );
					$status_class = 'completed';
					$status_type="#ff43df";
					break;
			};
			
			if ($project[ 'status' ] == '5') {
				$status_class = 'completed';
				$progress = 100;
			}
			
			if ( in_array( current_user_id, array_column( $projectmembers, 'staff_id' ) ) || isAdmin() ) {
				$authorization = "true";
			} else {
				$authorization = 'false';
			};
			if ( $project[ 'invoice_id' ] > 0 ) {
				$billed = lang( 'yes' );
			} else {
				$billed = lang( 'no' );
			}


			$appconfig = get_appconfig();
			$data_projectdetail = array(
				'id' => $project[ 'id' ],
				'name' => $project[ 'name' ],
				'value' => $project[ 'projectvalue' ],
				'status_id' => $project[ 'status' ],
				'tax' => $project[ 'tax' ],
				'description' => $project[ 'description' ],
				'start' => $project[ 'start_date' ],
				'start_edit' => $project[ 'start_date' ],
				'delivery_date' => date("d-m-Y H:i",strtotime($project[ 'delivery_date' ])),
				'editdelivery_date' => $project[ 'delivery_date' ],
				'deadline_edit' => $project[ 'deadline' ],
				'created' => $project[ 'created' ],
				'finished' => $project[ 'finished' ],
				'template' => $project[ 'template' ],
				'status' => $status_project,
				'status_class'=>$status_class,
				'percentage_completed'=>$percentage_completed['percentageCompetion'],
				'progress' => $progress,
				'customer' => $customer,
				'customer_id' => $project[ 'customer_id' ],
				'ldt' => $ldt,
				'authorization' => $authorization,
				'billed' => $billed,
				'milestones' => $milestones,
				'members' => $projectmembers,
				'project_logs' => $project_logs,
				'pdf_report' => $project['pdf_report'],
				'file_name' =>  get_number('projects', $project[ 'id' ], 'project','project').'.pdf',
				'project_number' => get_number('projects', $project[ 'id' ], 'project','project'),
				'order_id'=> $project['order_id'],
				'latest_status'=> $last_status,
				'address'=>  $project['custaddress'],
				'shipping_country_id'=>  $project['shipping_country_id'],
				'shipping_state_id'=>  $project['shipping_state_id'],
				'shipping_city'=>  $project['shipping_city'],
				'shipping_zip'=>  $project['shipping_zip'],
				'delivery_number'=>  $project['delivery_number'],
				'contact_number'=>  $project['contact_number'],
				'contact_name'=>  $project['contact_name'],
				'status_type'=>  $status_type,
				'items'=> $this->Projects_Model->get_project_items($project[ 'projectid' ]),
			);
			echo json_encode( $data_projectdetail );
		}
	}
	
	/*function get_project_items($project_id) {
		$items = $this->db->get_where( 'items', array( 'relation_type'=>'project', 'relation'=>$project_id))->result_array();
		return $items;
	}*/
	
	function projectmilestones( $id ) {
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			if ( date( "Y-m-d" ) > $milestone[ 'duedate' ] ) {
				$status = 'is-completed';
			} else if ( date( "Y-m-d" ) < $milestone[ 'duedate' ] ) {
				$status = 'is-future';
			} else {
				$status = 'is-completed';
			}
			$tasks = $this->Projects_Model->get_all_project_milestones_task( $milestone[ 'id' ] );
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'duedate' => $milestone[ 'duedate' ],
				'description' => $milestone[ 'description' ],
				'order' => $milestone[ 'order' ],
				'due' => $milestone[ 'duedate' ],
				'status' => $status,
				'tasks' => $tasks,
			);
		};
		echo json_encode( $data_milestones );
	}

	function projectfiles( $id ) {
		if (isset($id)) {
			$files = $this->Delivery_Model->get_project_files( $id );
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf') {
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
				if ($ext == 'pdf') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				if ($file['is_old'] == '1') {
					$path = base_url('uploads/files/'.$file['file_name']);
				} else {
					$path = base_url('uploads/files/delivery/'.$id.'/'.$file['file_name']);
				}
				$data[] = array(
					'id' => $file['id'],
					'project_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}

	function get_projecttimelogs( $id ) {
		$timelogs = $this->Projects_Model->get_project_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $timelog[ 'task_id' ] );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];

			$date1 = new DateTime($timelog['start']);
			$diffs = $date1->diff(new DateTime($timelog['end']));
			$h = $diffs->days * 24;
			$h += $diffs->h;
			$minutes = $diffs->i;
			$seconds = $diffs->s;
			if ($minutes < 10) {
				$minutes = $minutes;
			}
			if ($seconds < 10) {
				$seconds = $seconds;
			}
			if ($h < 10) {
				$h = $h;
			}
			$total = $h.':'.$minutes.':'.$seconds;
			$minutess = $h*60 + $minutes;
			if ($task[ 'hourly_rate' ] > 0) {
				$amounts = ($h+($minutes / 60)) * $task[ 'hourly_rate' ];
			} else {
				$amounts = 0;
			}

			if ( $task[ 'status_id' ] != 5 ) { 
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'status' => $timelog[ 'status' ],
					'timed' => $timed_minute,
					'amount' => $amount,
					'total_logged' => $total,
					'total_amount' => $amounts,
					'minutes' => $minutess,
				);
			}
		};
		echo json_encode( $data_timelogs );
	}

	function get_delivery() {
		$delivery = $this->Delivery_Model->get_all_delivery();
		$last_querry =  $this->db->last_query();
		$deliverystatus = $this->Delivery_Model->get_all_deliverystatus();
		$data_projects = array();
		if ($this->Privileges_Model->check_privilege( 'projects', 'all') ) {
			foreach ( $delivery as $delivery ) {
				$settings = $this->Settings_Model->get_settings_ciuis();
			/* 	$totaltasks = $this->Report_Model->totalprojecttasks( $project[ 'id' ] );
				$opentasks = $this->Report_Model->openprojecttasks( $project[ 'id' ] );
				$completetasks = $this->Report_Model->completeprojecttasks( $project[ 'id' ] );
				$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 ); */
				$percentage_completed = $this->Delivery_Model->GetdeliveryStatusByStage($delivery[ 'id' ]);
				$get_last_status = $this->Delivery_Model->get_last_status($delivery[ 'id' ]);

				$last_status = 	$get_last_status[0]['stagename'];
				$project_id = $delivery[ 'id' ];
				$enddate = $delivery[ 'delivery_date' ];
				$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( $settings[ 'default_timezone' ] ) );
				$end_date = new DateTime( "$enddate", new DateTimeZone( $settings[ 'default_timezone' ] ) );
				$interval = $current_date->diff( $end_date );
				$project_left_date = $interval->format( '%a day(s)' );
				if ( date( "Y-m-d" ) > $delivery[ 'delivery_date' ] ) {
					$ldt = 'Time\'s up!';
				} else $ldt = $project_left_date;
				switch ( $delivery[ 'status' ] ) {
					case '1':
					$projectstatus = 'notstarted';
					$icon = 'notstarted.png';
					$status = lang( 'notsch' );
					$status_type="#26c281";
					break;
					case '2':
					$projectstatus = 'started';
					$icon = 'started.png';
					$status = lang( 'schdule' );
					$status_type="#ff2946";
					break;
					case '3':
					$projectstatus = 'hold';
					$icon = 'percentage.png';
					$status = lang( 'hold' );
					$status_type="#0645f5";
					break;
					case '4':
					$projectstatus = 'cancelled';
					$icon = 'cancelled.png';
					$status = lang( 'cancelled' );
					$status_type="#e8ab00";
					break;
					case '5':
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang( 'complete' );
					$status_type="#ff43df";
					break;
				}
				if ($delivery[ 'status' ] == '5') {
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang( 'completed' );
					$progress = 100;
				}
			
				switch ( $settings[ 'dateformat' ] ) {
					case 'yy.mm.dd':
					$startdate = _rdate( $delivery[ 'delivery_date' ] );
					break;
					case 'dd.mm.yy':
					$startdate = _udate( $delivery[ 'delivery_date' ] );
					break;
					case 'yy-mm-dd':
					$startdate = _mdate( $delivery[ 'delivery_date' ] );
					break;
					case 'dd-mm-yy':
					$startdate = _cdate( $delivery[ 'delivery_date' ] );
					break;
					case 'yy/mm/dd':
					$startdate = _zdate( $delivery[ 'delivery_date' ] );
					break;
					case 'dd/mm/yy':
					$startdate = _kdate( $delivery[ 'delivery_date' ] );
					break;
				};
				$customer = ($delivery['customercompany'])?$delivery['customercompany']:$delivery['namesurname'];
				$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( 'Asia/Dhaka' ) );
				$members = $this->Delivery_Model->get_members_index( $project_id );
				$milestones = $this->Projects_Model->get_all_project_milestones( $project_id );
				$appconfig = get_appconfig();
				$data_projects[] = array(
					'id' => $delivery[ 'id' ],
					'project_id' => $delivery[ 'id' ],
					'name' => $delivery[ 'name' ],
					'pinned' => $delivery[ 'pinned' ],
					'status_id' => $delivery[ 'status' ],
					'progress' => $progress,
					'percentage_completed' => $percentage_completed['percentageCompetion'],
					'customer' => $customer,
					'customeremail' => $delivery[ 'customeremail' ],
					'status_icon' => $icon,
					'status' => $status,
					'status_class' => $projectstatus,
					'customer_id' => $delivery[ 'customer_id' ],
					'members' => $members,
					'milestones' => $milestones,
					lang('filterbystatus') => lang($projectstatus),
					lang('filterbycustomer') => $customer,
					'project_number' => get_number('projects', $delivery[ 'id' ], 'project','project'),
					'delivery_number' => $delivery[ 'delivery_number' ],
					'delivery_date' => date("d-m-Y H:i:m a",strtotime($delivery[ 'delivery_date' ])),
					'sumstarted' => $deliverystatus[0][ 'sumstarted' ],
					'sumnotstarted' => $deliverystatus[0][ 'sumnotstarted' ],
					'sumhold' => $deliverystatus[0][ 'sumhold' ],
					'sumcancelled' => $deliverystatus[0][ 'sumcancelled' ],
					'sumcomplete' => $deliverystatus[0][ 'sumcomplete' ],
					'latest_status'=> $last_status,
					'status_type'=> $status_type,
					'duration'=> $ldt,
				);
			} 
		}
		echo json_encode( $data_projects );
	}
	function add_stage() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'project_stages', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('projectstage'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_stage( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			$data[ 'stage' ] = $this->Projects_Model->get_stage( $id );
			if ( isset( $data[ 'stage' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Projects_Model->update_stage( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('projectstage'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_installation( $id ) {
			$stage = $this->Delivery_Model->get_stage( $id );
			if ( isset( $stage[ 'id' ] ) ) { 
					$this->Delivery_Model->remove_installation( $id );
					$data['success'] = true;
					$data['message'] = "Stage deleted successfully";
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('stage').' '.lang('is_linked').' '.lang('with').' '.lang('project').', '.lang('so').' '.lang('cannot_delete').' '.lang('stage');
				
			}
		
		echo json_encode($data);
	}
	
	function get_project_stages() {
		$groups = $this->Projects_Model->get_project_stages();
		$data_stages = array();
		foreach ( $groups as $group ) {
			$data_stages[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_stages );
	}
	
	function subdelivery( $id ) {
		$subprojects = $this->Delivery_Model->get_subdelivery($id);
		echo json_encode( $subprojects );
	}
	
	function subdeliverycomplete( $id ) {
		$subdeliverycomplete = $this->Delivery_Model->get_subdeliverycomplete( $id );
		echo json_encode( $subdeliverycomplete );
	}
	
	function addsubproject() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'project_stage_id' => $_POST[ 'project_stage_id' ],
					'projectid' => $_POST[ 'projectid' ],
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'created' => date( 'Y-m-d H:i:s' ),
				);
				$this->db->insert( 'subprojects', $params );
				$data[ 'insert_id' ] = $this->db->insert_id();
				$data['success'] = true;
				// return json_encode( $data );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	
	function removesubprojects() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'delete' ) ) {
			if ( isset( $_POST[ 'subproject' ] ) ) {
				$subproject = $_POST[ 'subproject' ];
				$response = $this->db->where( 'id', $subproject )->delete( 'subprojects', array( 'id' => $subproject ) );
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	
	function completesubdelivery() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST[ 'subdelivery' ] ) ) {
				$subdelivery = $_POST[ 'subdelivery' ];
				$deliveryid = $_POST[ 'deliveryid' ];
				$response = $this->db->where( 'id', $subdelivery )->update( 'subdelivery', array( 'complete' => 1 ) );
				$this->db->where( 'id', $deliveryid );
				$this->db->update('delivery', array('status_id'=>2));
			
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	
	function uncompletesubdelivery() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			if ( isset( $_POST[ 'subdelivery' ] ) ) {
				$subprojectid = $_POST['subdelivery' ];
				$deliveryid = $_POST[ 'deliveryid' ];
				$response = $this->db->where('id', $subprojectid)->update( 'subdelivery', array( 'complete' => 0 ));
				$data['success'] = true;
				$subPrjData = $this->Delivery_Model->GetdeliveryStatusByStage($deliveryid);
				if($subPrjData['completedCnt'] == 0) {
					$this->db->where( 'id', $deliveryid );
	 				$this->db->update('delivery', array('status_id'=>1));
				} else {
					//nothing
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	function get_all_staff() {
		$staff = $this->Delivery_Model->get_all_staff();
		echo json_encode($staff);

	}

	function get_all_installation() {
		$groups = $this->Delivery_Model->get_all_installtion();
		$data_stages = array();
		foreach ( $groups as $group ) {
			$data_stages[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_stages );
	}

	function add_installation() {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'installation', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('projectstage'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}


	function update_installation( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'projects', 'edit' ) ) {
			$data[ 'stage' ] = $this->Delivery_Model->get_installationid( $id );
			if ( isset( $data[ 'stage' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Delivery_Model->update_installation( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('projectstage'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	//Add vehcile
	function deliveryvehcile($id){
		$project_tracking = $this->db->select( '*' )->get_where( 'delivery_vehicle', array( 'delivery_id' => $id))->result_array();
		if($project_tracking){
			$delivery['items']=$project_tracking;
		}else{
			$delivery['items'][]=array("id"=>0,"vehicle_number"=>"","driver_name"=>"","vehicle_type"=>"");
		}
		echo json_encode($delivery);
	}
	//Add 
	function create_delivery_vehicle(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if($this->input->post('deliveryId') == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('deliveryId');
			}
			if(!$hasError){
				$vehicleitem=$this->input->post('vehicleitem');
				$delivery_id=$this->input->post('deliveryId');
				foreach($vehicleitem as $eachItem){
						if($eachItem['id']==0){
							$trackingparams = array(
								'delivery_id'=>$delivery_id,
								'vehicle_number'=>$eachItem['vehicle_number'],
								'driver_name'=>$eachItem['driver_name'],
								'vehicle_type'=>$eachItem['vehicle_type'],
								'created_on'=> date('Y-m-d H:i:s'),
								'created_by'=>$this->session->usr_id,
							);
							$this->db->insert( 'delivery_vehicle', $trackingparams);
						}else{
							$this->db->where('id', $eachItem['id'])->update( 'delivery_vehicle', array('delivery_id' =>$delivery_id,'vehicle_number'=>$eachItem['vehicle_number'],'vehicle_type'=>$eachItem['vehicle_type'],'created_on'=> date('Y-m-d H:i:s'),'created_by'=>$this->session->usr_id));
						}
					}
				}
				$data['success'] = true;
				$data['message'] = lang('update').' '.lang('Delivery Vehicle');
				echo json_encode($data);
		}else{
			$data['success'] = false;
			$data['message'] ='No data present';
			echo json_encode($data);
		}
	}
	function delect_delivery_vehicle(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if($this->input->post('projectId') == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('projectId');
			}else if($this->input->post('deleteItemId') == 0) {
				$hasError = true;
				$data['message'] = lang('invalid_items');
			}
			if($hasError){
				$data['success'] = false;
				echo json_encode($data);
			}
			if(!$hasError){
				$projectId=$this->input->post('projectId');
				$deleteItemId=$this->input->post('deleteItemId');
				$response = $this->db->delete( 'delivery_vehicle', array( 'id' => $deleteItemId,'delivery_id'=>$projectId));
				$data['success'] = true;
				$data['message'] = lang('delete').' '.lang('Delivery Vehicle');
				echo json_encode($data);
			}	
		}else{
			$data['success'] = false;
			$data['message'] ='No data present';
			echo json_encode($data);
		}
	}
	//Add checklist
	function deliverycheckist($id){
		$project_tracking = $this->db->select( '*' )->get_where( 'delivery_checklist', array( 'delivery_id' => $id))->result_array();
		if($project_tracking){
			$delivery['items']=$project_tracking;
		}else{
			$delivery['items'][]=array("id"=>0,"description"=>"","qty"=>"");
		}
		echo json_encode($delivery);
	}
	//Add 
	function create_delivery_checklist(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if($this->input->post('deliveryId') == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('deliveryId');
			}
			if(!$hasError){
				$checklistitem=$this->input->post('checklistitem');
				$delivery_id=$this->input->post('deliveryId');
				foreach($checklistitem as $eachItem){
						if($eachItem['id']==0){
							$trackingparams = array(
								'delivery_id'=>$delivery_id,
								'description'=>$eachItem['description'],
								'qty'=>$eachItem['qty'],
								'created_on'=> date('Y-m-d H:i:s'),
								'created_by'=>$this->session->usr_id,
							);
							$this->db->insert( 'delivery_checklist', $trackingparams);
						}else{
							$this->db->where('id', $eachItem['id'])->update( 'delivery_checklist', array('delivery_id' =>$delivery_id,'description'=>$eachItem['description'],'qty'=>$eachItem['qty'],'created_on'=> date('Y-m-d H:i:s'),'created_by'=>$this->session->usr_id));
						}
					}
				}
				$data['success'] = true;
				$data['message'] = lang('update').' '.lang('Delivery checklist');
				echo json_encode($data);
		}else{
			$data['success'] = false;
			$data['message'] ='No data present';
			echo json_encode($data);
		}
	}
	function delect_delivery_checklist(){
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if($this->input->post('projectId') == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('projectId');
			}else if($this->input->post('deleteItemId') == 0) {
				$hasError = true;
				$data['message'] = lang('invalid_items');
			}
			if($hasError){
				$data['success'] = false;
				echo json_encode($data);
			}
			if(!$hasError){
				$projectId=$this->input->post('projectId');
				$deleteItemId=$this->input->post('deleteItemId');
				$response = $this->db->delete( 'delivery_checklist', array( 'id' => $deleteItemId,'delivery_id'=>$projectId));
				$data['success'] = true;
				$data['message'] = lang('delete').' '.lang('Delivery checklist');
				echo json_encode($data);
			}	
		}else{
			$data['success'] = false;
			$data['message'] ='No data present';
			echo json_encode($data);
		}
	}
	function StatusMarkAs() {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'project_id' => $_POST[ 'project_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$tickets = $this->Delivery_Model->StatusMarkAs();			
				$data['success'] = true;
			}
		echo json_encode($data);
	}
}
