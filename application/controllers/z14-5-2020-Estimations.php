<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Estimations extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Estimations_Model');
		/*if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} */
	}

	function index() {
		$data[ 'title' ] = lang( 'estimations' );
		$data[ 'estimations' ] = $this->Estimations_Model->get_all_estimations();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view('estimations/index', $data );
	}
	function get_all_material()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Estimations_Model->get_materials_keyword($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["material_id"], 
            'name' => $row["itemname"].'<br>'.$row["itemdescription"],'description' => $row["itemdescription"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	function get_all_material_sku()
	{
		$keyword = strval( $this->input->post( 'str' ));
		$mat=$this->Estimations_Model->get_materials_keyword_sku($keyword);
			if(!empty($mat)){
			foreach($mat as $row){
				
				$supplierResult[]= array('id' => $row["material_id"], 
            'name' => $row["item_code"]);
			}   
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	function create() {
		
		$data[ 'title' ] = lang( 'createestimation' );
		$data['clients'] = $this->Estimations_Model->get_all_clients();
		$data['client_contacts'] = $this->Estimations_Model->get_all_client_contacts();
		$data['saleswise'] = $this->Estimations_Model->get_sales_staff('16');
		$data['materials'] = $this->Estimations_Model->get_materials();
			$data['admin'] = $this->Estimations_Model->get_admin_staff();
		
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				
				$project_name = $this->input->post('estimation_project_name');
				$estimatestatus = $this->input->post('estimatestatus');
				$client_id = $this->input->post('client_id');
				$client_contact_id = $this->input->post('client_contact_id');
				$estimation_total_cost_amt = $this->input->post('estimation_total_cost_amt');
				$subtotal_amt =  $this->input->post('subtotal_amt');
				$estimation_profit_amt = $this->input->post('estimation_profit_amt');
				$discount = $this->input->post('discount');
				$estimation_tax_amount = $this->input->post('estimation_tax_amount');
				$estimation_total_amt = $this->input->post('estimation_total_amt');
				
				
				$params = array(
				'project_name' => $project_name,
				'estimate_status' => $estimatestatus,
				'client_id' => $client_id,
				'client_contact_id' => $client_contact_id,
				'estimation_total_cost_amt' => 	$estimation_total_cost_amt,
				'subtotal_amt' => $subtotal_amt,
				'estimation_profit_amt' => $estimation_profit_amt,
				'discount' => $discount,
				'estimation_tax_amount' => $estimation_tax_amount,
				'estimation_total_amt' => $estimation_total_amt,
				'user_id' => $this->session->userdata( 'usr_id' ),
				'created' => date( 'Y-m-d' ),
				);
				$this->db->insert( 'estimations', $params );
				$estimation_id = $this->db->insert_id();
				
				 $countfiles = count($_FILES['file']['name']);
				 if( $countfiles>0){
				  for($i=0;$i<$countfiles;$i++){
				   $filename = $_FILES['file']['name'][$i];
				   
				      $ext = explode(".", $filename);
			             $image_name = "estimate-".rand(0,5000000).".".end($ext);
				   
				   // Upload file
				   if(move_uploaded_file($_FILES['file']['tmp_name'][$i],'uploads/estimate_documents/'.$image_name))
				   {
					   $params1 = array(
				'document_name' => $image_name,
				'estimation_id'=>$estimation_id);
					   $this->db->insert( 'estimations_documents', $params1 );
					   
				   }else{
					   
					   
				   }
					
				 }
				 
				 }
				$items = $this->input->post('items');
				
				foreach(array_filter($items['item_name']) as $k => $item_name){
					$item_data['item_name'] = $item_name;
					$item_data['estimation_id'] = $estimation_id;
 					$item_data['quantity'] = $items['qty'][$k];
					$item_data['unit_price'] = $items['unit_price'][$k];
					$item_data['tax'] = $items['tax'][$k];
					$item_data['amount'] = $items['amount'][$k];
					$item_data['sub_tot_cost'] = $items['sub_tot_cost'][$k];
					$item_data['sub_tot_sp'] = $items['sub_tot_sp'][$k];
					$item_data['round_helper'] = $items['round_helper'][$k];
					$main_params = array(
					'estimation_id' => $item_data['estimation_id'],
					'item_name' => $item_data['item_name'],
					'quantity' => $item_data['quantity'],
					'unit_price' => $item_data['unit_price'],
					'tax' => $item_data['tax'],
					'amount' => $item_data['amount'],
					'sub_tot_cost' => $item_data['sub_tot_cost'],
					'sub_tot_sp' => $item_data['sub_tot_sp'],
					'round_helper' => $item_data['round_helper']
					);
					$this->db->insert( 'estimations_main_items', $main_params );
					$main_item_id =  $this->db->insert_id();
					$subitems = $this->input->post('subitems');
					
					foreach(array_filter($subitems[$k]['sku']) as $l => $item_code){
						$subitem_data['item_code'] = $item_code;
						$subitem_data['name'] =  $subitems[$k]['name'][$l];
						$subitem_data['unit_cost'] = $subitems[$k]['unit_cost'][$l];
						$subitem_data['qty'] = $subitems[$k]['qty'][$l];
						$subitem_data['total_cost'] = $subitems[$k]['total_cost'][$l];
						$subitem_data['margin'] = $subitems[$k]['margin'][$l];
						$subitem_data['selling_price'] = $subitems[$k]['selling_price'][$l];
						$sub_params = array(
						'estimation_id' => $estimation_id,
						'main_item_id' => $main_item_id,
						'item_code' => $subitem_data['item_code'],
						'name' => $subitem_data['name'],
						'unit_cost' => $subitem_data['unit_cost'],
						'qty' => $subitem_data['qty'],
						'total_cost' => $subitem_data['total_cost'],
						'margin' => $subitem_data['margin'],
						'selling_price' => $subitem_data['selling_price']
						);
					$this->db->insert( 'estimations_sub_items', $sub_params );
					$sub_item_id = $this->db->insert_id();
				}
				
				}
				redirect(base_url('estimations'));
				 
			} else {
				$this->load->view( 'estimations/create', $data );
			}
		} else {
			$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'you_dont_have_permission' ) );
			redirect(base_url('estimations'));
		}
	}

function get_client_contacts(){
	$client_id = $this->input->post('client_id');
	
	$result = $this->Estimations_Model->get_client_contacts($client_id);
	echo '<option value="">Select Contact</option>';
				foreach($result as $k => $val){
					if($val['point_contact_name'] != '') {
					echo '<option value="'.$val['client_contact_id'].'" >'.$val['point_contact_name'].'</option>';
					
					}
					
				}
				
	
}

function get_material_data(){
	
    $id = $this->input->post('material_id');

    $get_data= $this->Estimations_Model->get_mat_data($id);
    echo json_encode($get_data); 
    exit();
		
	}
	function get_cat_mat_data()
	{
		$id = $this->input->post('matid');

    $get_data= $this->Estimations_Model->get_mat_cat_data($id);
    echo json_encode($get_data); 
    exit();
	}
	function get__mat__cat_data()
	{
		$id = $this->input->post('matid');
$alldata='';
			$get_data= $this->Estimations_Model->get__mat__cat_data($id);
			
			foreach($get_data as $eachdata){
				$alldata.="'".$eachdata['material_id']."'".',';
			}
			$data= "[".rtrim($alldata,',')."]";
			echo json_encode($get_data); 
			exit();
		
	}
	function update( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
		if($proposals) {
			if ( $this->Privileges_Model->check_privilege( 'proposals', 'edit' ) ) {
				$data[ 'title' ] = lang( 'updateproposal' );
				$data[ 'proposal' ] = $pro;
				if ( isset( $pro[ 'id' ] ) ) {
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
						if ($proposal_type == 'false') {
							$lead = '';
						} else {
							$customer = '';
						}
						if ($subject == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('subject');
						} else if ($customer == '' && $proposal_type == 'false') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('customer');
						} else if ($lead == '' && $proposal_type == 'true') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('lead');
						} else if ($date == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('issue'). ' ' .lang('date');
						} else if ($assigned == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('assigned');
						} else if ($status == '') {
							$hasError = true;
							$data['message'] = lang('selectinvalidmessage'). ' ' .lang('status');
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
							switch ( $this->input->post( 'proposal_type' ) ) {
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
								'subject' => $this->input->post( 'subject' ),
								'content' => $this->input->post( 'content' ),
								'date' => _pdate( $this->input->post( 'date' ) ),
								'opentill' =>$this->input->post( 'opentill' ),
								'relation_type' => $relation_type,
								'relation' => $relation,
								'assigned' => $this->input->post( 'assigned' ),
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

							$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
							if($proposal['is_requested'] == '1' && ($proposal['status_id'] == '0' && ($this->input->post( 'status' ) != '0'))) {
								$this->quote_status_changed($id, $this->input->post('status'));
							}
							$this->Proposals_Model->update_proposals( $id, $params );
							// Custom Field Post
							if ( $this->input->post( 'custom_fields' ) ) {
								$custom_fields = array(
									'custom_fields' => $this->input->post( 'custom_fields' )
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'proposal', $id );
							}
							$this->Proposals_Model->update_pdf_status($id, '0');
							$data['success'] = true;
							$data['message'] = lang('proposal'). ' '. lang('updatemessage');
							$data['id'] = $id;
							echo json_encode($data);
						}
					} else {
						$this->load->view( 'proposals/update', $data );
					}
				} else {
					$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'proposalediterror' ) );
				}
			} else{
				$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
				redirect(base_url('proposals/proposal/'. $id));
			}	
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
	}

	function proposal( $id ) {
		$data[ 'title' ] = 'Estimation';
		$est =  $this->Estimations_Model->get_estimation_record($id);
		$data['estimation_record'] = $est;
		$data['client_record'] = $this->Estimations_Model->get_client_record($est['client_id']);
		$data['client_contact_record'] = $this->Estimations_Model->get_client_contact_record($est['client_id'],$est['client_contact_id']);
		$data['estimation_main_items'] = $this->Estimations_Model->get_estimation_main_items($id);
		$data['estimation_sub_items'] = $this->Estimations_Model->get_estimation_sub_items($id);
		$this->load->view( 'estimations/proposal', $data );
	}

	function create_pdf( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
		if($proposals) {
			ini_set('max_execution_time', 0); 
			ini_set('memory_limit','2048M');
			if (!is_dir('uploads/files/proposals/'.$id)) {
				mkdir('./uploads/files/proposals/'.$id, 0777, true);
			}
			
			$data[ 'proposals' ] = $proposals;
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
			$data['country'] = get_country($data[ 'settings' ]['country_id']);
			$data['custcountry'] = get_country($data[ 'proposals' ]['country_id']);
			$data['custstate'] = get_state_name($data['proposals']['state'],$data['proposals']['state_id']);
			$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
			$this->load->view( 'proposals/pdf', $data );
			$file_name = '' . get_number('proposals', $id, 'proposal', 'proposal') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library( 'dom' );
			$this->dompdf->loadHtml( $html );
			$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
			$this->dompdf->setPaper( 'A4', 'portrait' );
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents( 'uploads/files/proposals/'. $id. '/' . $file_name . '', $output );
			$this->Proposals_Model->update_pdf_status($id, '1');
			//$this->dompdf->stream( '' . $file_name . '', array( "Attachment" => 0 ) );
			if ( $output ) {
				redirect( base_url( 'proposals/pdf_generated/' . $file_name . '' ) );
			} else {
				redirect( base_url( 'proposals/pdf_fault/' ) );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
	}

	function print_( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposals = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
		if($proposals) {
			ini_set('max_execution_time', 0); 
			ini_set('memory_limit','2048M');
			if (!is_dir('uploads/files/proposals/'.$id)) {
				mkdir('./uploads/files/proposals/'.$id, 0777, true);
			}
			$data[ 'proposals' ] = $proposals;
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
			$data['country'] = get_country($data[ 'settings' ]['country_id']);
			$data['custcountry'] = get_country($data[ 'proposals' ]['country_id']);
			$data['custstate'] = get_state_name($data['proposals']['state'],$data['proposals']['state_id']);
			$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
			$this->load->view( 'proposals/pdf', $data );
			$file_name = '' . get_number('proposals', $id, 'proposal', 'proposal') . '.pdf';
			$html = $this->output->get_output();
			$this->load->library( 'dom' );
			$this->dompdf->loadHtml( $html );
			$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
			$this->dompdf->setPaper( 'A4', 'portrait' );
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents( 'uploads/files/proposals/'. $id .'/'. $file_name . '', $output );
			if ($output) {
				redirect(base_url('uploads/files/proposals/'. $id .'/'. $file_name . ''));
			} else {
				redirect(base_url('proposals/pdf_falut/'));
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
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
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
		$this->load->view( 'proposals/pdf', $data );
	}

	function share( $id ) {
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
				$proposalto = $proposal[ 'customercompany' ];
				break;
				case '1':
				$proposalto = $proposal[ 'namesurname' ];
				break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		$subject = lang( 'newproposal' );
		$to = $proposaltoemail;
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/send.php', $data, TRUE );
		$result = send_email( $subject, $to, $data, $body );
		if ( $result ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}
	}

	function send_proposal_email($id) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$return['status'] = false;
			$return['message'] = lang( 'wrong_email_settings_msg' );
			echo json_encode($return);
		}
		if($proposal) {
			$template = $this->Emails_Model->get_template('proposal', 'send_proposal');
			$path = '';
			if ($template['attachment'] == '1') {
				if ($proposal['pdf_status'] == '0') {
					$this->Proposals_Model->generate_pdf($id);
					$file = get_number('proposals', $proposal['id'], 'proposal', 'proposal');
					$path = base_url('uploads/files/proposals/'.$id.'/'.$file.'.pdf');
				} else {
					$file = get_number('proposals', $proposal['id'], 'proposal', 'proposal');
					$path = base_url('uploads/files/proposals/'.$id.'/'.$file.'.pdf');
				}
			}
			if ($rel_type == 'customer') {
				$name = $proposal['namesurname'];
			} else {
				$name = $proposal['leadname'];
			}
			$link = base_url( 'share/proposal/' . $proposal[ 'token' ] . '' );
			$message_vars = array(
				'{proposal_to}' => $name,
				'{proposal_number}' => get_number('proposals', $id, 'proposal', 'proposal'),
				'{subject}' => $proposal['subject'],
				'{details}' => $proposal['content'],
				'{proposal_link}' => $link,
				'{name}' => $this->session->userdata('staffname'),
				'{email_signature}' => $this->session->userdata('email'),
				'{open_till}' => $proposal['opentill']
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);

			$param = array(
				'from_name' => $template['from_name'],
				'email' => $proposal['toemail'],
				'subject' => $subject,
				'message' => $message,
				'created' => date( "Y.m.d H:i:s" ),
				'status' => 0,
				'attachments' => $path?$path:NULL,
			);
			$this->load->library('mail');
			$data = $this->mail->send_email($proposal['toemail'], $template['from_name'], $subject, $message, $path);
			if ($data['success'] == true) {
				if ($proposal['toemail']) {
					$this->db->insert( 'email_queue', $param );
				}
				$return['status'] = true;
				$return['message'] = $data['message'];
				echo json_encode($return);
			} else {
				$return['status'] = false;
				$return['message'] = lang( 'wrong_email_settings_msg' );
				echo json_encode($return);
			}
		} else {
			$return['status'] = false;
			$return['message'] = lang( 'wrong_email_settings_msg' );
			echo json_encode($return);
		}
	}

	function expiration( $id ) {
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
				$proposalto = $proposal[ 'customercompany' ];
				break;
				case '1':
				$proposalto = $proposal[ 'namesurname' ];
				break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		$subject = lang( 'proposalexpiryreminder' );
		$to = $proposaltoemail;
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $pro[ 'token' ] . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/expiration.php', $data, TRUE );
		$result = send_email( $subject, $to, $data, $body );
		if ( $result ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}
	}

	function convert_invoice( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'invoices', 'create' ) ) {
			$data[ 'title' ] = lang( 'convertproposaltoinvoice' );
			$pro = $this->Proposals_Model->get_pro_rel_type( $id );
			$rel_type = $pro[ 'relation_type' ];
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $proposal[ 'id' ] ) )->result_array();
			$date = strtotime( "+7 day" );
			if ( isset( $proposal[ 'id' ] ) ) {
				$params = array(
					'token' => md5( uniqid() ),
					'no' => null,
					'serie' => null,
					'customer_id' => $proposal[ 'relation' ],
					'staff_id' => $this->session->usr_id,
					'status_id' => 3,
					'created' => date( 'Y-m-d H:i:s' ),
					'duedate' => date( 'Y-m-d H:i:s', $date ),
					'datepayment' => 0,
					'duenote' => null,
					'proposal_id' => $proposal[ 'id' ],
					'sub_total' => $proposal[ 'sub_total' ],
					'total_discount' => $proposal[ 'total_discount' ],
					'total_tax' => $proposal[ 'total_tax' ],
					'total' => $proposal[ 'total' ],
				);
				$this->db->insert( 'invoices', $params );
				$invoice = $this->db->insert_id();
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
					'detail' => ( '' . $message = sprintf( lang( 'coverttoinvoice' ), $staffname, get_number('proposals', $proposal[ 'id' ], 'proposal','proposal') ) . '' ),
					'staff_id' => $loggedinuserid,
					'customer_id' => $proposal[ 'relation' ]
				) );
				//NOTIFICATION
				$staffname = $this->session->staffname;
				$staffavatar = $this->session->staffavatar;
				$this->db->insert( 'notifications', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
					'customer_id' => $proposal[ 'relation' ],
					'perres' => $staffavatar,
					'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
				) );
				//--------------------------------------------------------------------------------------
				$this->db->insert( $this->db->dbprefix . 'sales', array(
					'invoice_id' => '' . $invoice . '',
					'status_id' => 3,
					'staff_id' => $loggedinuserid,
					'customer_id' => $proposal[ 'relation' ],
					'total' => $proposal[ 'total' ],
					'date' => date( 'Y-m-d H:i:s' )
				) );

				$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'invoice_id' => $invoice, 'status_id' => 6, 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
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
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $_POST[ 'name' ];
				$params = array(
					'proposal_id' => $_POST[ 'proposal_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$data['success'] = true;
				$data['message'] = lang( 'proposal' ).' '.lang('markas').' '.$name;
				$data['id'] = $this->Proposals_Model->markas();
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
		}
		echo json_encode($data);
	}

	function cancelled() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Proposals_Model->cancelled();
		}
	}

	function remove( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($proposal) {
			if ( $this->Privileges_Model->check_privilege( 'proposals', 'delete' ) ) {
				if ( isset( $proposal[ 'id' ] ) ) {
					$this->load->helper('file');
					$folder = './uploads/files/proposals/'.$id;
					if(is_dir($folder)) {
						delete_files($folder, true);
						rmdir($folder);	
					}
					$this->Proposals_Model->delete_proposals( $id, get_number('proposals',$id,'proposal','proposal') );
					$data['success'] = true;
					$data['message'] = lang('proposaldeleted');
					echo json_encode($data);
				} else {
					show_error( 'The proposals you are trying to delete does not exist.' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang( 'you_dont_have_permission' );
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
	}

	function remove_item( $id ) {
		$response = $this->db->delete( 'items', array( 'id' => $id ) );
	}

	function quote_status_changed($id, $old_status = null) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ($rel_type == 'customer') {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			if($proposal['is_requested'] == '1') {
				$template = $this->Emails_Model->get_template('quote', 'quote_status_changed');
				if ($template['status'] == 1) {
					$customer = $proposal['customercompany'] ? $proposal['customercompany'] : $proposal['namesurname'];
					$other_data = $this->Proposals_Model->get_proposal_customer($id);
					$cutomer_staff = $this->Settings_Model->get_cutomer_staff($other_data['customer_id']);
					$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type ); 
					$settings = $this->Settings_Model->get_settings_ciuis();
					$link = base_url('share/quote/' . $proposal[ 'token' ] . '');
					switch ( $proposal[ 'status_id' ] ) {
						case '0':
						$status = lang( 'quote' ).' '.lang('request');
						break;
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
					};
					$message_vars = array(
						'{customer_name}' => $customer,
						'{quote_status}' => $status,
						'{quote_link}' => $link,
						'{subject}' => $proposal['subject'],
						'{details}' => $proposal['content'],
						'{company_name}' => $settings['company'],
						'{company_email}' => $settings['email'],
						'{staff}' => $cutomer_staff['staffname']
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
			}
		}
	}

	function download_pdf($id){
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
		if($proposal) {
			if (isset($id)) {
				$file_name = '' . get_number('proposals',$id,'proposal','proposal').'.pdf';
				if (is_file('./uploads/files/proposals/'.$id.'/'.$file_name)) {
					$this->load->helper('file');
					$this->load->helper('download');
					$data = file_get_contents('./uploads/files/proposals/'.$id.'/'.$file_name);
					force_download($file_name, $data);
				} else {
					$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
					redirect('proposals/proposal/'.$id);
				}
			} else {
				redirect('proposals/proposal/'.$id);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
	}

	function get_proposal( $id ) {
		$proposal = array();
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $this->Privileges_Model->check_privilege( 'proposals', 'all' ) ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type );
		} else if ($this->Privileges_Model->check_privilege( 'proposals', 'own') ) {
			$proposal = $this->Proposals_Model->get_proposals_by_privileges( $id, $rel_type, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
		if($proposal) {
			$items = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'proposal', 'relation' => $id ) )->result_array();
			$comments = $this->db->get_where( 'comments', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
			if ( $rel_type == 'customer' ) {
				$customer_id = $proposal[ 'relation' ];
				$customername = $proposal['namesurname']?$proposal['namesurname']:$proposal['customercompany'];
				$lead_id = '';
				$leadname = '';
				$proposal_type = false;
			} else {
				$lead_id = $proposal[ 'relation' ];
				$customer_id = '';
				$customername = '';
				$leadname = $proposal['leadname'];
				$proposal_type = true;
			}
			if ( $proposal[ 'comment' ] != 0 ) {
				$comment = true;
			} else {
				$comment = false;
			}
			switch ( $proposal[ 'status_id' ] ) {
				case '0':
					$status = lang( 'quote' ).' '.lang( 'request' );
					break;
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
			};
			$appconfig = get_appconfig();
			$proposal_details = array(
				'id' => $proposal[ 'id' ],
				'token' => $proposal[ 'token' ],
				'long_id' => get_number('proposals', $proposal[ 'id' ], 'proposal','proposal'),
				'subject' => $proposal[ 'subject' ],
				'content' => $proposal[ 'content' ],
				'comment' => $comment,
				'sub_total' => $proposal[ 'sub_total' ],
				'total_discount' => $proposal[ 'total_discount' ],
				'total_tax' => $proposal[ 'total_tax' ],
				'total' => $proposal[ 'total' ],
				'customer' => $customer_id,
				'lead' => $lead_id,
				'proposal_type' => $proposal_type,
				'created' => $proposal[ 'created' ],
				'date' => date(get_dateFormat(),strtotime($proposal[ 'date' ])),
				'date_edit' => $proposal[ 'date' ],
				'opentill' => date(get_dateFormat(),strtotime($proposal[ 'opentill' ])),
				'opentill_edit' => $proposal[ 'opentill' ],
				'status' => $proposal[ 'status_id' ],
				'assigned' => $proposal[ 'assigned' ],
				'content' => $proposal[ 'content' ],
				'invoice_id' => $proposal[ 'invoice_id' ],
				'customer_quote' => $proposal['customer_quote'],
				'is_requested' => $proposal[ 'is_requested' ],
				'status_name' => $status,
				'items' => $items,
				'comments' => $comments,
				'pdf_status' => $proposal['pdf_status'],
				'customername' => $customername,
				'leadname' => $leadname,
			);
			echo json_encode( $proposal_details );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('proposals'));
		}
	}
}