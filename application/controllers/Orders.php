<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Orders extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Staff_Model');
		$this->load->model('Estimations_Model');
		
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'quotes' );
		$data[ 'orders' ] = $this->Orders_Model->get_all_orders();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'orders/index', $data );
	}

	function create() { 
		//if ( $this->Privileges_Model->check_privilege( 'orders', 'create' ) ) {
			$data[ 'title' ] = lang( 'new' ).' '.lang('quote');
			$appconfig = get_appconfig();
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				//$order_type = $this->input->post( 'order_type' );
				$relation_type = lang('customer');
				$customer = $this->input->post('customer');
				$project = $this->input->post('project');
				$reference = $this->input->post('reference');
				$client_contact_id = $this->input->post( 'client_contact_id');
				$salesteam = $this->input->post( 'salesteam' );
				$assigned = $this->session->usr_id;
				$date = $this->input->post('date');
				$opentill = $this->input->post('opentill');
				$total = $this->input->post('total');
				$lead = $this->input->post('lead');
				$status = $this->input->post('status');
				$total_items = $this->input->post('total_items');
				$total = filter_var($this->input->post('total'), FILTER_SANITIZE_NUMBER_INT);
				
				$hasError = false;
				$data['message'] = '';
				if ($project == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('project_name');
				}else if($project != '') {
					if ($this->check_project_submit($project) == 'fail') {
						$hasError = true;
						$data['message'] = lang('projectnamealreadyexists');
					}
				} /*else if ($assigned == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('staff');
				}*/ else if ($date == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('issue'). ' ' .lang('date');
				} else if ($customer == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('customer');
				}  else if ($salesteam == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('salesperson');
				} else if ($opentill == '') {
					$hasError = true;
					$data['message'] = lang('selectinvalidmessage'). ' ' .lang('end'). ' ' .lang('date');
				} else if (strtotime($opentill) < strtotime($date)) {
					$hasError = true;
					$data['message'] = lang('issue'). ' ' .lang('date').' '.lang('date_error'). ' ' .lang('end'). ' ' .lang('date');
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
					/*if ( $order_type != true ) {
						$relation_type = 'customer';
						$relation = $this->input->post( 'customer' );
					} else {
						$relation_type = 'lead';
						$relation = $this->input->post( 'lead' );
					};*/
					$relation_type = 'customer';
					$relation = $this->input->post( 'customer' );
					
					$allow_comment = $this->input->post( 'comment' );
					if ( $allow_comment != true ) {
						$comment_allow = 0;
					} else {
						$comment_allow = 1;
					};
					$params = array(
						'token' => md5( uniqid() ),
						//'subject' => $this->input->post( 'subject' ),
						'project' => $this->input->post( 'project' ),
						'reference' => $this->input->post( 'reference' ),
						//'customer' => $this->input->post( 'customer' ),
						'client_contact_id' => $this->input->post( 'client_contact_id'),
						'salesteam' => $this->input->post( 'salesteam' ),
						'content' => $this->input->post( 'content' ),
						'date' =>  $this->input->post( 'date' ) ,
						'opentill' => $this->input->post( 'opentill' ) ,
						'relation_type' => $relation_type,
						'relation' => $relation,
						'assigned' => $this->session->usr_id,
						'addedfrom' => $this->session->usr_id,
						'created' => date('Y-m-d H:i:s'),
						'datesend' => _pdate( $this->input->post( 'datesend' ) ),
						'comment' => $comment_allow,
						'status_id' => 1,
						'invoice_id' => $this->input->post( 'invoice' ),
						'dateconverted' => $this->input->post( 'dateconverted' ),
						'sub_total' => $this->input->post( 'sub_total' ),
						'total_discount' => $this->input->post( 'total_discount' ),
						'total_tax' => $this->input->post( 'total_tax' ),
						'total' => $this->input->post( 'total' ),
						'quote_profit_amt' => $this->input->post('sub_total'),
					);
					$orders_id = $this->Orders_Model->order_add( $params );
					// Custom Field Post
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'order', $orders_id );
					}
					$this->Settings_Model->create_process('pdf', $orders_id, 'order', 'order_message');
					$historyparams=array('module'=>'orders','relation_id'=>$orders_id,'type'=>'created');
					$this->Privileges_Model->create_history($historyparams);
					$data['success'] = true;
					$data['message'] = lang('quotes'). ' '. lang('createmessage');
					$data['id'] = $orders_id;
					if( $appconfig['order_series']){
						$order_number = $appconfig['order_series'];
						$order_number = $order_number + 1 ;
						$this->Settings_Model->increment_series('order_series',$order_number);
					}
				$result1 = $this->Customers_Model->get_customers($customer);	
				$company=$result1['company'];
				$staffname = $this->session->staffname;
					$loggedinuserid = $this->session->usr_id;
					$staffavatar = $this->session->staffavatar;
					$this->db->insert( 'estiimation_notifications', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $staffname .' req '.$orders_id),
						'staff_id' => $loggedinuserid,
						'perres' => $staffavatar,
						'customer_id' => $customer,
						'number' => ('QUO- '.$orders_id),
						'first_levelinfo' => $company,
						'value' => $total,
						'customer_name' => $project,
						'request_type'=> "quotes",
						'target' => '' . base_url( 'orders/order/' . $orders_id . '' ) . ''
					) );
					echo json_encode($data);
				}
			} else {
				$this->load->view( 'orders/create', $data );
			}
		/*} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}*/
	}

	function update( $id ) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		/*if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$data[ 'order' ] = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$data[ 'order' ]  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}*/
		$data[ 'order' ]  = $this->Orders_Model->get_order_by_priviliges_by_salesteam( $id);
		
		if($data[ 'order' ]) {
			//if ( $this->Privileges_Model->check_privilege( 'orders', 'edit' ) ) {
				$data[ 'title' ] = lang('update').' '.lang ('quote' );
				if ( isset( $pro[ 'id' ] ) ) {
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
						switch ( $this->input->post( 'order_type' ) ) {
							case 'true':
								$relation_type = 'lead';
								$relation = $this->input->post( 'lead' );
								break;
							case 'false':
								$relation_type = 'customer';
								$relation = $this->input->post( 'customer' );
								break;
						};
						switch ( $this->input->post( 'comment' ) ) {
							case 'true':
								$comment_allow = 1;
								break;
							case 'false':
								$comment_allow = 0;
								break;
						};
						$params = array(
							//'subject' => $this->input->post( 'subject' ),
							'project' => $this->input->post( 'project' ),
							'reference' => $this->input->post( 'reference' ),
							'client_contact_id' => $this->input->post( 'client_contact_id'),
							'content' => $this->input->post( 'content' ),
							'salesteam' => $this->input->post( 'main_sales_team_id' ),
							'date' =>  $this->input->post( 'date' ) ,
							'created' =>  $this->input->post( 'created' ) ,
							'opentill' =>  $this->input->post( 'opentill' ) ,
							'relation_type' => $relation_type,
							'relation' => $relation,
							'datesend' => _pdate( $this->input->post( 'datesend' ) ),
							'comment' => $comment_allow,
							'status_id' => $this->input->post( 'status' ),
							'invoice_id' => $this->input->post( 'invoice' ),
							'dateconverted' => $this->input->post( 'dateconverted' ),
							'sub_total' => $this->input->post( 'sub_total' ),
							'total_discount' => $this->input->post( 'total_discount' ),
							'total_tax' => $this->input->post( 'total_tax' ),
							'total' => $this->input->post( 'total' ),
							'status_id' => 1,
						);
						$this->Orders_Model->update_orders( $id, $params );
						$historyparams=array('module'=>'orders','relation_id'=>$id,'type'=>'update');
						$this->Privileges_Model->create_history($historyparams);
						// Custom Field Post
						if ( $this->input->post( 'custom_fields' ) ) {
							$custom_fields = array(
								'custom_fields' => $this->input->post( 'custom_fields' )
							);
							$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'order', $id );
						}
						$this->Orders_Model->update_pdf_status($id, '0');
						echo $id;
					} else {
						$this->load->view( 'orders/update', $data );
					}
				} else {
					$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'orderediterror' ) );
				}
			/*} else {
				$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
				redirect(base_url('orders/order/'. $id));
			}*/
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function order( $id ) {
		$ordersdata=array();
		$data['est_revisions'] = array();
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$ordersdata  = $this->Orders_Model->get_order_by_priviliges_by_salesteam( $id);
		$data['customer_record'] = $this->Customers_Model->get_customers($ordersdata['relation']);
		
		$approvalAccess=$this->Privileges_Model->has_approval_access('orders');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='total';
		if($approvalAccess['type']=='level'){
			$data['orders']=check_approval_data_ForId($ordersdata,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$data['orders']=check_approval_data_ForId($ordersdata,$maxvalue,$comperKey);
		}else{
			$data['orders']=check_approval_data_ForId($ordersdata,$maxvalue,'NotAccess');
		}
		$data['userInfo']=$this->Staff_Model->getRoleByStaffId($this->session->usr_id);
		$data['declined_notes'] = $this->db->get_where( 'rejected_notes', array( 'relation' => $id, 'relation_type' => 'orders'))->row_array();
		$estimationId=$data['orders']['estimation_id'];
		if($estimationId !='0'){
			$data['allow_delete'] = $this->Estimations_Model->get_item_by_estimation( $estimationId);
		}else{
			$data['allow_delete']='1';
		}
		
		if($data[ 'orders' ]) {
			$data[ 'title' ] = lang( 'quotes' );
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data['revisions'] =$this->Privileges_Model->get_revision_by_id($id,'orders');
			if($estimationId !='0'){
				$data['est_revisions'] = $this->Privileges_Model->get_revision_by_id($estimationId,'estimations');
			}
			$this->load->view( 'orders/order', $data );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function download_pdf($id){
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$order = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$order  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
		if($order) {
			if (isset($id)) {
				$file_name = '' . get_number('orders',$id,'order','order').'.pdf';
				if (is_file('./uploads/files/orders/'.$id.'/'.$file_name)) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/orders/'.$id.'/'.$file_name);
					force_download($file_name, $data);
				} else {
					$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
					redirect('orders/order/'.$id);
				}
			} else {
				redirect('orders/order/'.$id);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function create_pdf( $id ) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$order = $this->Orders_Model->get_order_by_priviliges_by_salesteam( $id);
		if($order) {
			ini_set('max_execution_time', 0); 
			ini_set('memory_limit','2048M');
			if (!is_dir('uploads/files/orders/'.$id)) {
				mkdir('./uploads/files/orders/'.$id, 0777, true);
			}
			$data[ 'orders' ] = $order;
			$data['customer_record'] = $this->Customers_Model->get_customers($order['relation']);
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
			$data['country'] = get_country($data[ 'settings' ]['country_id']);
			$data['custcountry'] = get_country($data[ 'orders' ]['country_id']);
			$data['custstate'] = get_state_name($data['orders']['state'],$data['orders']['state_id']);
			$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id ) )->result_array();
			$this->load->view( 'orders/pdf', $data );
			$file_name = '' . get_number('orders', $id, 'order', 'order'). '.pdf';
			$html = $this->output->get_output();
			$this->load->library( 'dom' );
			$this->dompdf->loadHtml( $html );
			$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
			$this->dompdf->setPaper( 'A4', 'portrait' );
			$this->dompdf->render();
			$output = $this->dompdf->output();
			unset($this->dompdf);
			file_put_contents( 'uploads/files/orders/'. $id . '/' . $file_name . '', $output );
			$this->Orders_Model->update_pdf_status($id, '1');
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ( $output ) {
				redirect( base_url( 'orders/pdf_generated/' . $file_name . '' ) );
			} else {
				redirect( base_url( 'orders/pdf_fault/' ) );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function print_( $id ) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$order = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$order  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
		if($order) {
			$data[ 'orders' ] = $order;
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
			$data['country'] = get_country($data[ 'settings' ]['country_id']);
			$data['custcountry'] = get_country($data[ 'orders' ]['country_id']);
			$data['custstate'] = get_state_name($data['orders']['state'],$data['orders']['state_id']);
			$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id ) )->result_array();
			$this->load->view( 'orders/pdf', $data );
			$file_name = '' . get_number('orders', $id, 'order', 'order'). '.pdf';
			$html = $this->output->get_output();
			$this->load->library( 'dom' );
			$this->dompdf->loadHtml( $html );
			$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
			$this->dompdf->setPaper( 'A4', 'portrait' );
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents( 'assets/files/generated_pdf_files/orders/' . $file_name . '', $output );
			redirect(base_url('assets/files/generated_pdf_files/orders/' . $file_name . ''));
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	} 

	function pdf_generated( $file ) {
		$result = array(
			'status' => true,
			'file_name' => $file,
		);
		echo json_encode( $result );
	}

	function pdf_fault() {
		$result = array(
			'status' => false,
		);
		echo json_encode( $result );
	}

	function dp( $id ) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id ) )->result_array();
		$this->load->view( 'orders/pdf', $data );
	}

	function share( $id ) {
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$order = $this->Orders_Model->get_orders( $id, $rel_type );
			$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
			switch ( $order[ 'type' ] ) {
				case '0':
					$orderto = $order[ 'customercompany' ];
					break;
				case '1':
					$orderto = $order[ 'namesurname' ];
					break;
			}
			$ordertoemail = $order[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$order = $this->Orders_Model->get_orders( $id, $rel_type );
			$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
			$orderto = $order[ 'leadname' ];
			$ordertoemail = $order[ 'toemail' ];
		}
		$subject = lang( 'neworder' );
		$to = $ordertoemail;
		$data = array(
			'customer' => $orderto,
			'customermail' => $ordertoemail,
			'orderlink' => '' . base_url( 'share/order/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/orders/send.php', $data, TRUE );
		$result = send_email( $subject, $to, $data, $body );
		if ( $result ) {
			$response = $this->db->where( 'id', $id )->update( 'orders', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'orders/order/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'orders/order/' . $id . '' );
		}
	}

	function send_order_email($id) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$order = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$order  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
		if($order) {
			if ( $rel_type == 'customer' ) {
				$data[ 'orders' ] = $order;
				switch ( $order[ 'type' ] ) {
					case '0':
						$orderto = $order[ 'customercompany' ];
						break;
					case '1':
						$orderto = $order[ 'namesurname' ];
						break;
				}
				$ordertoemail = $order[ 'toemail' ];
			}
			if ($rel_type == 'lead') {
				$data['orders'] = $order;
				$orderto = $order['leadname'];
				$ordertoemail = $order['toemail'];
			}

			$template = $this->Emails_Model->get_template('order', 'order_message');

			$path = '';
			if ($template['attachment'] == '1') {
				if ($order['pdf_status'] == '0') {
					$this->Orders_Model->generate_pdf($id);
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/'.$id.'/'.$file.'.pdf');
				} else {
					$file = get_number('orders', $order['id'], 'order', 'order');
					$path = base_url('uploads/files/orders/'.$id.'/'.$file.'.pdf');
				}
			}

			$order_number = get_number('orders', $id, 'order', 'order');
			$settings = $this->Settings_Model->get_settings_ciuis();
			$message_vars = array(
				'{customer}' => $orderto,
				'{order_to}' => $orderto,
				'{email_signature}' => $this->session->userdata( 'email' ),
				'{name}' => $this->session->userdata( 'staffname' ),
				'{order_number}' => $order_number,
				'{app_name}' => $settings['company'],
				'{company_name}' => $settings['company']
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);
			$param = array(
				'from_name' => $template['from_name'],
				'email' => $ordertoemail,
				'subject' => $subject,
				'message' => $message,
				'created' => date( "Y.m.d H:i:s" ),
				'status' => 0,
				'attachments' => $path?$path:NULL,
			);
			if ($ordertoemail) {
				$this->load->library('mail'); 
				$data = $this->mail->send_email($ordertoemail, $template['from_name'], $subject, $message, $path);
				if ($data['success'] == true) {
					$return['status'] = true;
					$return['message'] = $data['message'];
					$this->db->insert( 'email_queue', $param );
					echo json_encode($return);
				} else {
					$return['status'] = false;
					$return['message'] = lang('errormessage');
					echo json_encode($return);
				}
			}
		} else {
			$return['status'] = false;
			$return['message'] = lang('you_dont_have_permission');
			echo json_encode($return);
		}
	}

	function expiration( $id ) {
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$order = $this->Orders_Model->get_orders( $id, $rel_type );
			$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
			switch ( $order[ 'type' ] ) {
				case '0':
					$orderto = $order[ 'customercompany' ];
					break;
				case '1':
					$orderto = $order[ 'namesurname' ];
					break;
			}
			$ordertoemail = $order[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$order = $this->Orders_Model->get_orders( $id, $rel_type );
			$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
			$orderto = $order[ 'leadname' ];
			$ordertoemail = $order[ 'toemail' ];
		}
		$subject = lang( 'orderexpiryreminder' );
		$to = $ordertoemail;
		$data = array(
			'customer' => $orderto,
			'customermail' => $ordertoemail,
			'orderlink' => '' . base_url( 'share/order/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/orders/expiration.php', $data, TRUE );
		$result = send_email( $subject, $to, $data, $body );
		if ( $result ) {
			$response = $this->db->where( 'id', $id )->update( 'orders', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'orders/order/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'orders/order/' . $id . '' );
		}
	}

	function convert_invoice( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'invoices', 'create' ) ) {
			$data[ 'title' ] = lang( 'convertordertoinvoice' );
			$pro = $this->Orders_Model->get_pro_rel_type( $id );
			$rel_type = $pro[ 'relation_type' ];
			$order = $this->Orders_Model->get_orders( $id, $rel_type );
			$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $order[ 'id' ] ) )->result_array();
			$date = strtotime( "+7 day" );
			if ( isset( $order[ 'id' ] ) ) {
				$params = array(
					'token' => md5( uniqid() ),
					'no' => null,
					'serie' => null,
					'customer_id' => $order[ 'relation' ],
					'staff_id' => $this->session->usr_id,
					'status_id' => 3,
					'created' => date( 'Y-m-d H:i:s' ),
					'duedate' => date( 'Y-m-d H:i:s', $date ),
					'datepayment' => 0,
					'duenote' => null,
					//'order_id' => $order[ 'id' ],
					'sub_total' => $order[ 'sub_total' ],
					'total_discount' => $order[ 'total_discount' ],
					'total_tax' => $order[ 'total_tax' ],
					'total' => $order[ 'total' ],
				);
				$this->db->insert( 'invoices', $params );
				$invoice = $this->db->insert_id();
				$appconfig = get_appconfig();
				$number = $appconfig['invoice_series'] ? $appconfig['invoice_series'] : $invoice;
				$invoice_number = $appconfig['inv_prefix'].$number;
				$this->db->where('id', $invoice)->update( 'invoices', array('invoice_number' => $invoice_number ) );
				if($appconfig['invoice_series']){
					$invoice_number = $appconfig['invoice_series'];
					$invoice_number = $invoice_number + 1 ;
					$this->Settings_Model->increment_series('invoice_series',$invoice_number);
				}
				$i = 0;
				foreach ( $items as $item ) {
					$this->db->insert( 'items', array(
						'relation_type' => 'invoice',
						'relation' => $invoice,
						'product_id' => $item[ 'product_id' ],
						'code' => $item[ 'code' ],
						'name' => $item[ 'name' ],
						'description' => $item[ 'description' ],
						'quantity' => $item[ 'quantity' ],
						'unit' => $item[ 'unit' ],
						'price' => $item[ 'price' ],
						'tax' => $item[ 'tax' ],
						'discount' => $item[ 'discount' ],
						'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
					) );
					$i++;
				};
				//LOG
				$staffname = $this->session->staffname;
				$loggedinuserid = $this->session->usr_id;
				$appconfig = get_appconfig();
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $message = sprintf( lang( 'coverttoinvoice' ), $staffname, get_number('orders', $order[ 'id' ], 'order','order') ) . '' ),
					'staff_id' => $loggedinuserid,
					'customer_id' => $order[ 'relation' ]
				) );
				//NOTIFICATION
				$staffname = $this->session->staffname;
				$staffavatar = $this->session->staffavatar;
				$this->db->insert( 'notifications', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
					'customer_id' => $order[ 'relation' ],
					'perres' => $staffavatar,
					'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
				) );
				//--------------------------------------------------------------------------------------
				/*$this->db->insert( $this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $loggedinuserid,
					'customer_id' => $order[ 'relation' ],
					'total' => $order[ 'total' ],
					'date' => date( 'Y-m-d H:i:s' )
				) );*/

				$response = $this->db->where( 'id', $id )->update( 'orders', array('status_id'=>12,'invoice_id' => $invoice, 'is_invoiced' => 1, 'invoiced_date' => date( 'Y-m-d H:i:s' ) ) );
				$data['id'] = $invoice;
				$data['success'] = true;
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function markas() {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$orderDetails = $this->db->get_where( 'orders', array( 'id' => $_POST['order_id']) )->row_array();
				$oldValue=$this->get_status($orderDetails['status_id']);
				$newValue=$this->get_status($_POST[ 'status_id' ]);
				$name = $_POST[ 'name' ];
				$params = array(
					'order_id' => $_POST[ 'order_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$tickets = $this->Orders_Model->markas();
				$historyparams=array('module'=>'orders','relation_id'=>$_POST[ 'order_id' ],'type'=>'status','oldvalue'=>$oldValue,'newvalue'=>$newValue);
				$this->Privileges_Model->create_history($historyparams);	
				$data['success'] = true;
				$data['message'] = lang('quotes').' '.lang('markas').' '.$name ;
			}
		echo json_encode($data);
	}
	
	function get_status($statusId){	
		switch ($statusId) {
				case '1':
					$status = lang( 'draft' );
					break;
				case '2':
					$status = lang( 'sent' );
					break;
				case '3':
					$status = lang( 'open' );
					break;
				case '4':
					$status = lang( 'revised' );
					break;
				case '5':
					$status = lang( 'declined' );
					break;
				case '6':
					$status = lang( 'accepted' );
					break;
				case '7':
					$status = lang('quote').' '.lang('request');
					break;
				case '8':
					$status = lang('under').' '.lang('approval');
					break;
				case '9':
					$status = lang('approved');
					break;
				case '10':
					$status = lang('under').' '.lang('approval');
					break;
				case '11':
					$status = lang('rejected');
					break;
				case '12':
					$status = lang('invoiced');
					break;
				default: 
					$status = lang( 'open' );
					break;

			};
		return $status;
	}
	function add_declined_msg(){
		$statusname = $_POST['statusid'] == '5' ? 'Declined' : 'Rejected';
		$validation_msg = $_POST['statusid'] == '5' ? lang('Please Enter Reason For Declined') : lang('Please Enter Reason For Rejected');
		if ( isset( $_POST ) && count( $_POST ) > 0 && $_POST[ 'orddeclined_msg' ] !='') {
			$orderid = $_POST[ 'order_id' ];
			$msg=$_POST[ 'orddeclined_msg' ];
			$rejectedparams = array(
				'relation_type' => 'orders',
				'relation' => $orderid,
				'status' => $statusname,
				'notes' => $_POST[ 'orddeclined_msg'],
				'created' => date('Y-m-d h:i:s')
			);
			$this->db->insert( 'rejected_notes', $rejectedparams );
			$this->db->where('id', $orderid)->update( 'orders', array('status_id'=>$_POST['statusid']) );
			$data['success'] = true;
			$data['message'] = lang('quotes').' '.lang('markas').' '.$statusname ;
		}else{
			$data['success'] = false; 
			$data['message'] = $validation_msg;
		}
		echo json_encode($data);
	}

	function cancelled() {
		if ( $this->Privileges_Model->check_privilege( 'orders', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'order' => $_POST[ 'order_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$tickets = $this->Orders_Model->cancelled();
				$data['success'] = true;
			}
		} else {
			$data['success'] = false; 
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove( $id ) {
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$order = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$order  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($order) {
			if($order['estimation_id'] !=0){
				$allow_delete=$this->Estimations_Model->get_item_by_estimation($order['estimation_id']);
				if($allow_delete=='1'){
					$this->Estimations_Model->delete_proposals( $order['estimation_id'], get_number('proposals',$order['estimation_id'],'proposal','proposal') );
				}
			}
			if ( $this->Privileges_Model->check_privilege( 'orders', 'delete' ) ) {
				if ( isset( $order[ 'id' ] ) ) {
					$this->Orders_Model->delete_orders( $id, get_number('orders',$id,'order','order') );
					$this->load->helper('file');
					$folder = './uploads/files/orders/'.$id;
					if(is_dir($folder)) {
						delete_files($folder, true);
						rmdir($folder);
					}
					$data['success'] = true;
					$data['message'] = lang('quotes').' '.lang('deleted');
					echo json_encode($data);
				} else {
					show_error( 'The orders you are trying to delete does not exist.' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function remove_item( $id ) {
		$response = $this->db->delete( 'items', array( 'id' => $id ) );
	}

	function get_order( $id ) {
		$order = array();
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		/*if ( $this->Privileges_Model->check_privilege( 'orders', 'all' ) ) {
			$order = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'orders', 'own') ) {
			$order  = $this->Orders_Model->get_order_by_priviliges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}*/
		$order = $this->Orders_Model->get_order_by_priviliges_by_salesteam( $id);
		if($order) {
			$items=$this->Orders_Model->get_order_items($id);
			$comments = $this->db->get_where( 'comments', array( 'relation' => $id, 'relation_type' => 'order' ) )->result_array();
			$customername = '';
			if ( $rel_type == 'customer' ) {
				$customer_id = $order[ 'relation' ];
				$customername = $order['namesurname']?$order['namesurname']:$order['customercompany'];
				$lead_id = '';
				$order_type = false;
			} else {
				$lead_id = $order[ 'relation' ];
				$customer_id = '';
				$order_type = true;
			}
			if ( $order[ 'comment' ] != 0 ) {
				$comment = true;
			} else {
				$comment = false;
			}
			switch ( $order[ 'status_id' ] ) {
				case '1':
					$status = lang( 'draft' );
					break;
				case '2':
					$status = lang( 'sent' );
					break;
				case '3':
					$status = lang( 'open' );
					break;
				case '4':
					$status = lang( 'revised' );
					break;
				case '5':
					$status = lang( 'declined' );
					break;
				case '6':
					$status = lang( 'accepted' );
					break;
				case '7':
					$status = lang('quote').' '.lang('request');
					break;
				case '8':
					$status = lang('under').' '.lang('approval');
					break;
				case '9':
					$status = lang('approved');
					break;
				case '10':
					$status = lang('under').' '.lang('approval');
					break;
				case '11':
					$status = lang('rejected');
					break;
				case '12':
					$status = lang('invoiced');
					break;
				default: 
					$status = lang( 'open' );
					break;

			};
			$appconfig = get_appconfig();
			$order_details = array(
				'id' => $order[ 'id' ],
				'token' => $order[ 'token' ],
				'long_id' => get_number('orders', $order[ 'id' ], 'order','order'),
				'subject' => $order[ 'subject' ],
				'project'=> $order['project'],
				'reference'=> $order['reference'],
				//'projectname'=> $order['projectname'],
				'client_contact_id'=> $order['client_contact_id'],
				'salesteam'=> $order['salesteam'],
				'salesteamperson'=>$this->Orders_Model->get_staff_name_by_id($order['salesteam']),
				'content' => $order[ 'content' ],
				'comment' => $comment,
				'sub_total' => $order[ 'sub_total' ],
				'total_discount' => $order[ 'total_discount' ],
				'total_tax' => $order[ 'total_tax' ],
				'total' => $order[ 'total' ],
				'customer' => $customer_id,
				'customername' => $customername,
				'lead' => $lead_id,
				'order_type' => $order_type,
				'created' => date('d-m-Y g:i a', strtotime( $order['created'])),
				'created_edit' => $order[ 'created' ],
				'date' => date('m/d/Y',strtotime($order[ 'date' ])),
				'opentill' => date('m/d/Y',strtotime($order[ 'opentill' ])),
				'opentill_edit' => $order[ 'opentill' ],
				'status' => $order[ 'status_id' ],
				'staff' => $order[ 'assigned' ],
				'addedfrom'=>$order['addedfrom'],
				'addedfrompersonname' => $this->Orders_Model->get_staff_name_by_id($order['addedfrom']),
				'content' => $order[ 'content' ],
				'invoice_id' => $order[ 'invoice_id' ],
				'status_name' => $status,
				'items' => $items,
				'comments' => $comments,
				'order_number' => $order['order_number'],
				'pdf_status' => $order['pdf_status'],
				'approved_by'=>($order[ 'approved_by' ] !='0' ? $this->Orders_Model->get_staff_name_by_id($order[ 'approved_by' ]) : ''),
				'approved_date'=>($order[ 'approved_by' ] !='0' ? date('d-m-Y g:i a', strtotime( $order['approved_date'])) : ''),
				'staffmembername'=>$this->Orders_Model->get_staff_name_by_id($order[ 'assigned' ]),
				'estimateByStaff'=>($order[ 'estimate_by' ] !='0' ? $this->Orders_Model->get_staff_name_by_id($order[ 'estimate_by' ]) : ''),
				'estimateDate'=>($order[ 'estimate_by' ] !='0' ? date('d-m-Y g:i a', strtotime( $order['estimate_on'])) : ''),
				'estimation_id'=> $order['estimation_id'],
				'total_discount' => $order['total_discount'],
				'estapproved_by'=>($order[ 'estapproved_by' ] !='0' ? $this->Orders_Model->get_staff_name_by_id($order[ 'estapproved_by' ]) : ''),
				'estapprove_date'=>($order[ 'estapproved_by' ] !='0' ? date('d-m-Y g:i a', strtotime( $order['estapprove_date'])) : '')
			);
			echo json_encode( $order_details );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('orders'));
		}
	}

	function get_orders() {
		$orders = array();
		$this->db->select('approvals.approverid');
		$this->db->join( 'approvals', 'approvals.permissions_id = permissions.id');
		$ordersbypermissions = $this->db->get_where( 'permissions', array( 'key' => 'orders', 'approvals.approverid' => $this->session->usr_id))->row_array();
		
		if($ordersbypermissions) {
			$orders = $this->Orders_Model->get_all_orders_by_privileges_permissions($this->session->usr_id);
		} else {
			$orders = $this->Orders_Model->get_all_orders_by_privileges($this->session->usr_id);
		}
		
		$data_orders = array();
		foreach ( $orders as $order ) {
			$pro = $this->Orders_Model->get_orders( $order[ 'id' ], $order[ 'relation_type' ] );
			if ( $pro[ 'relation_type' ] == 'customer' ) {
				if ( ($pro[ 'customercompany' ] === NULL) || ($pro[ 'customercompany' ] == '') ) {
					$customer = $pro[ 'namesurname' ];
					$customer_email = $pro['toemail'];
				} else {
					$customer = $pro[ 'customercompany' ];
					$customer_email = $pro['toemail'];
				}
			}
			if ( $pro[ 'relation_type' ] == 'lead' ) {
				$customer = $pro[ 'leadname' ];
				$customer_email = $pro['toemail'];
			}
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$date = _rdate( $order[ 'date' ] );
					$opentill = _rdate( $order[ 'opentill' ] );
					break;
				case 'dd.mm.yy':
					$date = _udate( $order[ 'date' ] );
					$opentill = _udate( $order[ 'opentill' ] );
					break;
				case 'yy-mm-dd':
					$date = _mdate( $order[ 'date' ] );
					$opentill = _mdate( $order[ 'opentill' ] );
					break;
				case 'dd-mm-yy':
					$date = _cdate( $order[ 'date' ] );
					$opentill = _cdate( $order[ 'opentill' ] );
					break;
				case 'yy/mm/dd':
					$date = _zdate( $order[ 'date' ] );
					$opentill = _zdate( $order[ 'opentill' ] );
					break;
				case 'dd/mm/yy':
					$date = _kdate( $order[ 'date' ] );
					$opentill = _kdate( $order[ 'opentill' ] );
					break;
			};
			switch ( $order[ 'status_id' ] ) {
				case '1':
					$status = lang( 'draft' );
					$class = 'order-status-accepted proposal-status-draft';
					break;
				case '2':
					$status = lang( 'sent' );
					$class = 'order-status-sent proposal-status-sent';
					break;
				case '3':
					$status = lang( 'open' );
					$class = 'order-status-open proposal-status-open';
					break;
				case '4':
					$status = lang( 'revised' );
					$class = 'order-status-revised proposal-status-revised';
					break;
				case '5':
					$status = lang( 'declined' );
					$class = 'order-status-declined proposal-status-declined';
					break;
				case '6':
					$status = lang( 'accepted' );
					$class = 'order-status-accepted proposal-status-accepted';
					break;
				case '7':
					$status = lang('quote').' '.lang('request');
					$class = 'order-status-quoterequest proposal-status-quote';
					break;
				case '8':
					$status = lang('under').' '.lang('approval');
					$class = 'order-status-underapproval';
					break;
				case '9':
					$status = lang('approved');
					$class = 'order-status-approved proposal-status-approved';
					break;
				case '10':
					$status = lang('under').' '.lang('approval');
					$class = 'order-status-underapproval proposal-status-sentforapproval';
					break;
				case '11':
					$status = lang( 'rejected' );
					$class = 'order-status-rejected proposal-status-declined';
					break;
				case '12':
					$status = lang('invoiced');
					$class = 'order-status-invoiced proposal-status-declined';
					break;
				default: 
					$status = lang( 'open' );
					$class = 'order-status-open proposal-status-open';
					break;
			};
			$data_orders[] = array(
				'id' => $order[ 'id' ],
				'assigned' => $order[ 'assigned' ],
				'prefix' => lang( 'orderprefix' ),
				'longid' => get_number('orders', $order[ 'id' ], 'order','order'),
				'project' => $order[ 'project' ],
				'reference'=> $order['reference'],
				'customer' => $customer,
				'relation' => $order[ 'relation' ],
				'date' => $date,
				'opentill' => $opentill,
				'status' => $status,
				'status_id' => $order[ 'status_id' ],
				'staff' => $order[ 'staffmembername' ],
				'staffavatar' => $order[ 'staffavatar' ],
				'addedfrom'=>$order['addedfrom'],
				'addedfrompersonname'=>$this->Orders_Model->get_staff_name_by_id($order['addedfrom']),
				'total' => (float)$order[ 'total' ],
				'class' => $class,
				'relation_type' => $order[ 'relation_type' ],
				'customer_email' => $customer_email,
				'' . lang( 'relationtype' ) . '' => $order[ 'relation_type' ],
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
				'' . lang( 'filterbyassigned' ) . '' => $order[ 'staffmembername' ],
				'enable_edit'=>$order['enable_edit'],
				'is_converted'=>$order[ 'is_converted' ],
				'is_invoiced'=>$order[ 'is_invoiced' ],
				'invoice_id'=>$order[ 'invoice_id' ],
				'projectid'=>$order['projectid']
			);
		};
		echo json_encode( $data_orders );
	}
	
	function GetContactsandSales($client_id) {
		$finaldata['contacts'] = $this->Contacts_Model->get_customer_contacts($client_id);
		$result1 = $this->Customers_Model->get_customers($client_id);	
		$salestea=$result1['sales_team'];
		$salesArr=explode(',',$salestea);
		foreach($salesArr as $key=>$eachsalesid) {
			$sales = $this->Staff_Model->get_staff($eachsalesid);
			$data[$key]['staff_id'] = $sales['id'];
			$data[$key]['staff_name'] = $sales['staffname'];
		}
		//$finaldata['salesteam'] = $data;
		$finaldata['salesteam'] = $result1["main_sales_person"];
		echo json_encode($finaldata);
	}
	
	function orderfiles($orderId){
		if (isset($orderId)){
			$files = $this->Orders_Model->get_order_documents($orderId);
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['document_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf' || $ext == 'PDF') {
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
				if ($ext == 'pdf' || $ext == 'PDF') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				$path = base_url($file['filepath'].'/'.$file['document_name']);
				$data[] = array(
					'id' => $file['id'],
					'project' => $file['orderid'],
					'file_name' => $file['document_name'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}
	function add_file($id){ 
		if ( $this->Privileges_Model->check_privilege( 'orders', 'edit' ) ) {
			if (isset( $_POST )) {
				if (!is_dir('uploads/order_documents')) { 
					mkdir('./uploads/order_documents', 0777, true);
				}
				if (!is_dir('uploads/estimate_documents')) { 
					mkdir('./uploads/estimate_documents', 0777, true);
				}
				$count = count($_FILES);
				if($count > 0){
					$orderData=$this->db->get_where('orders', array('id' => $id))->row_array();
					for($i=0;$i<$count;$i++){
						if(!empty($_FILES[$i]['name'])){
						  $_FILES['file']['name'] = $_FILES[$i]['name'];
						  $_FILES['file']['type'] = $_FILES[$i]['type'];
						  $_FILES['file']['tmp_name'] = $_FILES[$i]['tmp_name'];
						  $_FILES['file']['error'] = $_FILES[$i]['error'];
						  $_FILES['file']['size'] = $_FILES[$i]['size'];
						  $config[ 'upload_path' ] = './uploads/order_documents';
						  $config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
						  $config['max_size'] = '9000';
						  $new_name =rand(100,1000).'_'.preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES[$i]['name']));
						  $config['file_name'] = $new_name; 
						  $this->load->library('upload',$config); 
						  $this->upload->initialize($config);
						  if($this->upload->do_upload('file')){  
							$uploadData = $this->upload->data();
							$filename = $uploadData['file_name'];
							$filetype = $uploadData['file_type'];
							$params=array();
							$params = array('document_name'=>$filename,'orderid'=>$id,'filepath'=>'uploads/order_documents');
							$this->db->insert( 'order_documents', $params );
							if($orderData['estimation_id'] !='0' && ($orderData['status_id'] == '1' || $orderData['status_id'] == '3' || $orderData['status_id'] == '7')){
									$estparams=array();
									$estparams = array(
										'estimation_id' => $orderData['estimation_id'],
										'document_name' =>$filename,
									);
									$this->db->insert('estimations_documents', $estparams );
									$orderDir ='uploads/order_documents/'. $filename;
									$estDir='uploads/estimate_documents/'. $filename;
									copy($orderDir, $estDir);
							}
						  }
						}
					}
					$data['success'] = true;
					$data['message'] = lang('file').' '.lang('uploadmessage');
					echo json_encode($data);
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
			$fileData = $this->Orders_Model->get_order_documents_file($id);
				if (is_file('./uploads/order_documents/' . $fileData['document_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/order_documents/' . $fileData['document_name']);
		    		force_download($fileData['document_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('orders/order'.$fileData['orderid']);
		    	}
		    
				
		}
	}
	
	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'orders', 'edit' ) ) {
			if (isset($id)) {
				$fileData = $this->Orders_Model->get_order_documents_file($id);
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'order_documents', array( 'id' => $id ) );
					if (is_file('./uploads/order_documents/' . $fileData['document_name'])) {
				    		unlink('./uploads/order_documents/' . $fileData['document_name']);
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
				redirect('orders/order/'.$fileData['orderid'].'');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function search_customer_contacts($cust) {
		$contacts = $this->Contacts_Model->get_customer_contacts($cust);
	    echo json_encode( $contacts);
	}
	
	function get_all_sales_staff() {
		$sales_staff = $this->Estimations_Model->get_sales_staff('16');
		echo json_encode($sales_staff);
	}
	
	function search_customer_sales($cust) {
		$result1 = $this->Customers_Model->get_customers($cust);	
		$salesteamid = $result1['main_sales_person'];
		/*$salestea=$result1['sales_team'];
		$supplier_result=explode(',',$salestea);
		foreach($supplier_result as $key=>$eachsupp){
			$sres = $this->Staff_Model->get_staff($eachsupp);
			if($sres['id'] != '') {
				$data[$key]['staff_id'] = $sres['id'];
				$data[$key]['staff_name'] = $sres['staffname'];
			}
		}
		echo json_encode( $data);*/
		echo json_decode($salesteamid);
	}
	
	function check_project_avalibility(){
		$estimationsResult=$this->Estimations_Model->is_project_available($_POST["projectName"]);
		$orderResult=$this->Orders_Model->is_project_available($_POST["projectName"]);
		if($estimationsResult==true || $orderResult==true){  
			 echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Project Name Already Exists</label>';  
		}else  
		{  
			 echo '<label class="text-success"><span class="glyphicon glyphicon-ok"></span> Project Name Available</label>';  
		} 
	}
	
	function check_project_submit($project){
		$estResult=$this->Estimations_Model->is_project_available($project);
		$orderResult=$this->Orders_Model->is_project_available($project);
		if($estResult==true || $orderResult==true){  
			$result = "fail";
		}else  
		{  
			$result = "success";
		}
		return $result;
	}
	//convert_project
	
	function convert_project($id ){
		if ( $this->Privileges_Model->check_privilege( 'orders', 'create' ) ) {
			$orderData = $this->Orders_Model->get_order( $id );
			$orderdocuments = $this->db->select( '*' )->get_where('order_documents', array('orderid' => $id))->result_array();
			
			$start_date = date( 'Y-m-d' );
			//$deadline = date('Y-m-d', strtotime($start_date. ' +30 days'));
			$deadline = date('Y-m-d', strtotime($_POST['deadline_date']));
			$is_tentative = isset($_POST['is_tentative']) ? $_POST['is_tentative'] : 0;
			
			if ( $orderData[ 'is_converted' ] != '0' ) {
				$data['success'] = false;
				$data['message'] = lang('orderalreadyconverted');
				echo json_encode($data);
			} else {
				$params = array(
					'name' => $orderData['project'],
					'description' => $orderData[ 'content' ],
					'customer_id' => $orderData[ 'relation' ],
					'projectvalue' => $orderData[ 'total' ],
					'tax' => $orderData[ 'total_tax' ],
					'start_date' =>$start_date,
					'deadline' =>$deadline,
					'is_tentative'=>$is_tentative,
					'staff_id' => $this->session->userdata( 'usr_id' ),
					'status_id' => 1,
					'template' => 0,
					'created' => date( 'Y-m-d H:i:s' ),
					'order_id' => $id
				);
				$this->db->insert( 'projects', $params );
				$project_id = $this->db->insert_id();
				
				if (!is_dir('./uploads/files/projects/'.$project_id)) { 
					mkdir('./uploads/files/projects/'.$project_id, 0777, true);
				}
				if(sizeof($orderdocuments) > 0) {
					foreach($orderdocuments as $eachdoc) {
						$params = array(
							'relation_type' => 'project',
							'relation' => $project_id,
							'file_name' => $eachdoc['document_name'],
							'created' => date("Y.m.d H:i:s"),
							'is_old' => '0'
						);
						$this->db->insert( 'files', $params );
						$quotesDir ='uploads/order_documents/'. $eachdoc['document_name'];
						$projDir='./uploads/files/projects/'.$project_id.'/'.$eachdoc['document_name'];
						copy($quotesDir, $projDir);
					}
				}
				
				$allProjectStages = $this->db->get_where( 'project_stages', array( '' ))->result_array();
				
				foreach($allProjectStages as $eachProjectStage) {
					$subprojectparams = array(
						'projectid' => $project_id,
						'project_stage_id' => $eachProjectStage['id'],
						'finished' => 0,
						'created' => date( 'Y-m-d H:i:s' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'complete' => 0
					);
					$this->db->insert( 'subprojects', $subprojectparams );
				}
					
				//$order_items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id) )->result_array();
				$order_items = $this->Orders_Model->get_order_items($id);
				foreach($order_items as $oitem) {
					$oitemparams = array (
					'relation_type' => 'project',
					'relation' => $project_id,
					'name'=>$oitem['name'],
					'description'=>$oitem['description'],
					'quantity'=>$oitem['quantity'],
					'unit'=>$oitem['unit'],
					'price'=>$oitem['price'],
					'tax'=>$oitem['tax'],
					'discount'=>$oitem['discount'],
					'total'=>$oitem['total'],
					);
					$this->db->insert('items',$oitemparams);
					$item_id = $this->db->insert_id();
					foreach($oitem['child'] as $eachChild){
						$subitemparams = array (
						'project_id' => $project_id,
						'main_item_id' => $item_id,
						'item_code'=>$eachChild['item_code'],
						'name'=>$eachChild['name'],
						'unit_cost'=>$eachChild['unit_cost'],
						'qty'=>$eachChild['qty'],
						'total_cost'=>$eachChild['total_cost'],
						'margin'=>$eachChild['margin'],
						'selling_price'=>$eachChild['selling_price']
						);
						$this->db->insert('projects_sub_items',$subitemparams);
					}
				}
				$appconfig = get_appconfig();
				$number=$project_id;
				$project_number = $appconfig['project_prefix'].$number;
				$this->db->where('id', $project_id)->update( 'projects', array('project_number' => $project_number ) );
				$response = $this->db->where( 'id', $id )->update( 'orders', array( 'is_converted' => '1', 'converted_date' => date( 'Y-m-d H:i:s' ) ) );
				$data['id'] = $project_id;
				$data['success'] = true;
				echo json_encode($data) ;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function search_customers_by_access($q) {
		$customers = $this->Customers_Model->search_customers_by_access($q);
		$data = array();
		foreach ($customers as $customer) {
			$billing_country = get_country($customer['billing_country']);
			$shipping_country = get_country($customer['shipping_country']);  
			$billing_state = get_state_name($customer['billing_state'],$customer['billing_state_id']);
			$shipping_state = get_state_name($customer['shipping_state'],$customer['shipping_state_id']); 
			$data[] = array(
				'name' => $customer['namesurname']?$customer['namesurname']:$customer['company'],
				'email' => $customer['email'],
				'customer_number' => get_number('customers', $customer[ 'id' ], 'customer','customer'),
				'id' => $customer[ 'id' ],
				'billing_street' => $customer[ 'billing_street' ],
				'billing_city' => $customer[ 'billing_city' ],
				'billing_state' => $billing_state,
				'billing_state_id' => $customer['billing_state_id'],
				'billing_zip' => $customer[ 'billing_zip' ],
				'billing_country' => $billing_country,
				'billing_country_id' => $customer['billing_country'],
				'shipping_street' => $customer[ 'shipping_street' ],
				'shipping_city' => $customer[ 'shipping_city' ],
				'shipping_state' => $shipping_state,
				'shipping_state_id' => $customer['shipping_state_id'],
				'shipping_zip' => $customer[ 'shipping_zip' ],
				'shipping_country' => $shipping_country,
				'shipping_country_id' => $customer['shipping_country'],
			);
		}
		echo json_encode($data);
	}
	
	function exist_estimations_addnote() {
		$order = $data = array();
		$order = $this->db->get_where( 'orders', array( 'id' => $_POST[ 'relation'], 'estimation_id !=' => '0'))->row_array();
		if(sizeof($order) > 0 && $order['estimation_id'] != '0') {
			$params = array(
				'relation_type' => $_POST[ 'relation_type' ],
				'relation' => $order['estimation_id'],
				'description' => $_POST[ 'description' ],
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'notes', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();
		}
		return json_encode($data);
	}
	
	function get_history($id,$loadMore=''){
		$orderHistory=$this->Privileges_Model->get_histroy_by_relation_id($id,'orders',$loadMore);
		$data_history= array();
		foreach ($orderHistory as $eachhistory ) {
		$staffname=$eachhistory['staffmembername'];
		$oldvalue=(isset($eachhistory['oldvalue']) && $eachhistory['oldvalue'] !='' ? $eachhistory['oldvalue'] : '');
		$newvalue=(isset($eachhistory['newvalue']) && $eachhistory['newvalue'] !='' ? $eachhistory['newvalue'] : '');
		if($oldvalue !='' && $newvalue!=''){
			$statusmsg=lang($oldvalue).' from '.lang($newvalue).'&nbsp for';
		}else{
			$statusmsg='';
		}
		
		$detail='<a>' . $staffname . '</a> ' .lang($eachhistory['comments']).'&nbsp'.$statusmsg.' <a href="'.$eachhistory[ 'relation_id' ].'">' . ' '. lang( 'quote' ) .' '. get_number('orders ',$eachhistory['relation_id'],'order','order'). '</a>.';
			$data_history[] = array(
				'logdate' => date( DATE_ISO8601, strtotime( $eachhistory[ 'date' ] ) ),
				'date' => tes_ciuis( $eachhistory[ 'date' ] ),
				'detail' => $detail,
				'relation_id' => $eachhistory[ 'relation_id' ],
				'staff_id' => $eachhistory[ 'staff_id' ],
			);
		};
		echo json_encode( $data_history );
	}
	
	
	
	
}