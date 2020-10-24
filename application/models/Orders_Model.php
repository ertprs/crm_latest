<?php
include APPPATH . '/third_party/vendor/autoload.php';
use Dompdf\Dompdf;
class Orders_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_all_orders() {
		$loggedinid =  $this->session->usr_id;
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,orders.id as id' );
		$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
		//$this->db->join( 'projects', 'orders.project_id = projects.id', 'left' );
		$this->db->order_by( 'orders.id', 'desc' );
		return $this->db->get( 'orders' )->result_array();
	}
	
	function get_all_orders_by_customer($id) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,orders.id as id' );
		$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
		$this->db->order_by( 'orders.id', 'desc' );
		return $this->db->get_where( 'orders', array( 'relation_type' => 'customer', 'relation' => $id ) )->result_array();
	}

	function get_order( $id ) {
		return $this->db->get_where( 'orders', array( 'id' => $id ) )->row_array();
	}

	function get_pro_rel_type( $id ) {
		return $this->db->get_where( 'orders', array( 'id' => $id ) )->row_array();
	}

	function get_order_by_token( $token ) {
		return $this->db->get_where( 'orders', array( 'token' => $token ) )->row_array();
	}

	function get_orders( $id, $rel_type ) {
		if ( $rel_type == 'customer' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,customers.type as type,customers.company as customercompany,customers.email as toemail,customers.namesurname as namesurname,customers.address as toaddress,customers.zipcode as zip,orders.status_id as status_id, orders.id as id, orders.created as created' );
			$this->db->join( 'customers', 'orders.relation = customers.id', 'left' );
			$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
			return $this->db->get_where( 'orders', array( 'orders.id' => $id ) )->row_array();
		} elseif ( $rel_type == 'lead' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,leads.name as leadname,leads.address as toaddress,leads.email as toemail,orders.status_id as status_id,orders.id as id ' );
			$this->db->join( 'leads', 'orders.relation = leads.id', 'left' );
			$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
			return $this->db->get_where( 'orders', array( 'orders.id' => $id ) )->row_array();
		}
	}

	function get_orderitems( $id ) {
		return $this->db->get_where( 'orderitems', array( 'id' => $id ) )->row_array();
	}
	// GET INVOICE DETAILS

	function get_order_productsi_art( $id ) {
		$this->db->select_sum( 'in[total]' );
		$this->db->from( 'orderitems' );
		$this->db->where( '(order_id = ' . $id . ') ' );
		return $this->db->get();
	}

	// CHANCE INVOCE STATUS

	function status_1( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'orders', array( 'status_id' => ( '1' ) ) );
		$response = $this->db->update( 'sales', array( 'order_id' => $id, 'status_id' => '1' ) );
	}

	function status_2( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'orders', array( 'status_id' => ( '2' ) ) );
		$response = $this->db->update( 'sales', array( 'order_id' => $id, 'status_id' => '2' ) );
	}

	function status_3( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'orders', array( 'status_id' => ( '3' ) ) );
		$response = $this->db->update( 'sales', array( 'order_id' => $id, 'status_id' => '3' ) );
	}
	// ADD INVOICE
	function order_add( $params, $isQuote=false ) {
		$this->db->insert( 'orders', $params );
		$order = $this->db->insert_id();
		$appconfig = get_appconfig();
		if($isQuote == true) {
			$order_number = 'QR';
			$enable_edit='0';
		} else {
			$number = $appconfig['order_series'] ? $appconfig['order_series'] : $order;
			$order_number = $appconfig['order_prefix'] . $number;
			$enable_edit='1';
		}
		
		$this->db->where('id', $order)->update('orders', array('order_number' => $order_number,'enable_edit'=>$enable_edit));
		// MULTIPLE INVOICE ITEMS POST
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			$this->db->insert( 'items', array(
				'relation_type' => 'order',
				'relation' => $order,
				'product_id' => $item[ 'product_id' ],
				'code' => $item[ 'code' ],
				'name' => $item[ 'name' ],
				'description' => $item[ 'description' ],
				'quantity' => $item[ 'quantity' ],
				//'unit' => $item[ 'unit' ],
				'price' => $item[ 'price' ],
				'tax' => $item[ 'tax' ],
				'discount' => $item[ 'discount' ],
				'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
			) );
			$i++;
		};
		//LOG
		if ( $this->input->post( 'order_type' ) != 'true' ) {
			//NOTIFICATION
			$staffname = $this->session->staffname;
			$staffavatar = $this->session->staffavatar;
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . '' . lang( 'isaddedaneworder' ) . '' ),
				'customer_id' => $this->input->post( 'customer' ),
				'perres' => $staffavatar,
				'target' => '' . base_url( 'area/order/' . $order . '' ) . ''
			) );
		}
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="orders/order/' . $order . '">' . lang( 'order' ) . get_number('orders',$order,'order','order'). '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		return $order;
	}

	function update_orders( $id, $params ) {
		$appconfig = get_appconfig();
		$order_data = $this->get_order($id);
		$quote_profit_amt=$order_data['quote_profit_amt'];
		if ($order_data['order_number'] == '') {
			$number = $appconfig['order_series'] ? $appconfig['order_series'] : $id;
			$order_number = $appconfig['order_prefix'] . $number;
			$this->db->where('id', $id)->update('orders', array('order_number' => $order_number));
			if (($appconfig['order_series'] != '')) {
				$order_number = $appconfig['order_series'];
				$order_number = $order_number + 1;
				$this->Settings_Model->increment_series('order_series', $order_number);
			}
		}
		$this->db->where( 'id', $id );
		$order = $id;
		$response = $this->db->update( 'orders', $params );
		$items = $this->input->post( 'items' );
		$i = 0;
		foreach ( $items as $item ) {
			if ( isset($item[ 'id' ])) {
				$params = array(
					'relation_type' => 'order',
					'relation' => $order,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					//'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				);
				$this->db->where( 'id', $item[ 'id' ] );
				$response = $this->db->update( 'items', $params );
			} 
			if ( empty($item[ 'id' ])) {
				$this->db->insert( 'items', array(
					'relation_type' => 'order',
					'relation' => $order,
					'product_id' => $item[ 'product_id' ],
					'code' => $item[ 'code' ],
					'name' => $item[ 'name' ],
					'description' => $item[ 'description' ],
					'quantity' => $item[ 'quantity' ],
					//'unit' => $item[ 'unit' ],
					'price' => $item[ 'price' ],
					'tax' => $item[ 'tax' ],
					'discount' => $item[ 'discount' ],
					'total' => $item[ 'quantity' ] * $item[ 'price' ] + ( ( $item[ 'tax' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ) - ( ( $item[ 'discount' ] ) / 100 * $item[ 'quantity' ] * $item[ 'price' ] ),
				) );
				$quote_profit_amt =($quote_profit_amt+$item[ 'price' ]);
			}
			$i++;
		};
		
		//quote_profit_amt update//
		$response = $this->db->where( 'id', $id )->update( 'orders', array( 'quote_profit_amt' =>$quote_profit_amt));
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		if ( $this->input->post( 'order_type' ) != true ) {
			$relation = $this->input->post( 'customer' );
		} else {
			$relation = $this->input->post( 'lead' );
		};
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="orders/order/' . $id . '">' . get_number('orders',$id,'order','order')  . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $relation,
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedorder' ) . '' ),
			'customer_id' => $relation,
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/order/' . $order . '' ) . ''
		) );
		if ( $response ) {
			return "Proposal Updated.";
		} else {
			return "There was a problem during the update.";
		}
	}

	//PROPOSAL DELETE
	function delete_orders( $id, $number) {
		$response = $this->db->delete( 'orders', array( 'id' => $id ) );
		$response = $this->db->delete( 'items', array( 'relation_type' => 'order','relation' => $id ) );
		$response = $this->db->delete( 'pending_process', array( 'process_relation' => $id, 'process_relation_type' => 'order'));
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . $number . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function cancelled() {
		$response = $this->db->where( 'id', $_POST[ 'order_id' ] )->update( 'orders', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}

	function markas() {
		if($_POST[ 'status_id' ] =='9'){
			$getdata=$this->db->get_where( 'orders', array( 'orders.id' =>$_POST[ 'order_id' ]) )->row_array();
			if($getdata['status_id'] == '1') {
				$revparams = array('relation_id'=>$_POST[ 'order_id' ],'relation_module'=>'orders');
				$this->Privileges_Model->create_revisions($revparams);
			}
			$response = $this->db->where( 'id', $_POST[ 'order_id' ] )->update( 'orders', array( 'status_id' => $_POST[ 'status_id' ],'approved_by'=>$this->session->usr_id,'approved_date'=> date( 'Y-m-d H:i:s' )));
			
		}elseif($_POST[ 'status_id' ] =='10'){
			$revparams = array('relation_id'=>$_POST['order_id'],'relation_module'=>'orders');
			$this->Privileges_Model->create_revisions($revparams);
			$response = $this->db->where( 'id', $_POST[ 'order_id' ] )->update( 'orders', array( 'status_id' => $_POST[ 'status_id' ] ) );
		}else{
			$response = $this->db->where( 'id', $_POST[ 'order_id' ] )->update( 'orders', array( 'status_id' => $_POST[ 'status_id' ] ) );
		}
	}

	function deleteorderitem( $id ) {
		$response = $this->db->delete( 'orderitems', array( 'id' => $id ) );
	}
	public

	function get_order_year() {
		return $this->db->query( 'SELECT DISTINCT(YEAR(date)) as year FROM orders ORDER BY year DESC' )->result_array();
	}

	function update_pdf_status($id, $value){
		$this->db->where('id', $id);
		$response = $this->db->update('orders',array('pdf_status' => $value));
	}

	function generate_pdf( $id ) {
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		if (!is_dir('uploads/files/orders/'.$id)) {
			mkdir('./uploads/files/orders/'.$id, 0777, true);
		}
		$pro = $this->Orders_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'orders' ] = $this->Orders_Model->get_orders( $id, $rel_type );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['state'] = get_state_name($data['settings']['state'],$data['settings']['state_id']);
		$data['country'] = get_country($data[ 'settings' ]['country_id']);
		$data['custcountry'] = get_country($data[ 'orders' ]['country_id']);
		$data['custstate'] = get_state_name($data['orders']['state'],$data['orders']['state_id']);
		$data[ 'items' ] = $this->db->select( '*' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id ) )->result_array();
		$file_name = '' . get_number('orders', $id, 'order', 'order'). '.pdf';
		$html = $this->load->view( 'orders/pdf', $data, TRUE );
		$this->dompdf = new DOMPDF();
		$this->dompdf->loadHtml( $html );
		$this->dompdf->set_option( 'isRemoteEnabled', TRUE );
		$this->dompdf->set_option('isHtml5ParserEnabled', TRUE );
		$this->dompdf->setPaper( 'A4', 'portrait' );
		$this->dompdf->render();
		$output = $this->dompdf->output();
		$result = file_put_contents( 'uploads/files/orders/'. $id . '/' . $file_name . '', $output );
		$this->update_pdf_status($id, '1');
		$html = null;
		$this->output->delete_cache();
		$this->dompdf->loadHtml(null);
		$this->dompdf = null;
		unset($this->dompdf);
		return true; 
	}

	function get_all_orders_by_privileges($staff_id='') {
		$this->db->select( '*,orders.status_id as status_id,orders.invoice_id as invoice_id, staff.staffname as staffmembername,staff.staffavatar as staffavatar,orders.id as id, projects.id as projectid' );
		$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
		$this->db->join('customers', 'orders.relation = customers.id AND orders.relation_type = "customer"');
		$this->db->join( 'projects', 'orders.id = projects.order_id', 'left' );
		$this->db->where('customers.main_sales_person =', $this->session->usr_id);
		$this->db->or_where('find_in_set("'.$this->session->usr_id.'", customers.sales_team) <> 0');
		$this->db->order_by( 'orders.id', 'desc' );
		return $this->db->get( 'orders' )->result_array();
	}
	
	function get_all_orders_by_privileges_permissions($staff_id = '') {
		$this->db->select( '*,orders.status_id as status_id,orders.invoice_id as invoice_id, staff.staffname as staffmembername,staff.staffavatar as staffavatar,orders.id as id, projects.id as projectid' );
		$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
		$this->db->join( 'projects', 'orders.id = projects.order_id', 'left' );
		$this->db->order_by( 'orders.id', 'desc' );
		return $this->db->get( 'orders' )->result_array();
	}
	
	function get_order_by_priviliges_by_salesteam($id) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,customers.type as type,customers.company as customercompany,customers.email as toemail,customers.namesurname as namesurname,customers.address as toaddress,customers.zipcode as zip,orders.status_id as status_id, orders.id as id, orders.created as created, orders.approved_by, orders.approved_date,estimations.estimate_by,estimations.estimate_on, orders.salesteam, contacts.name as client_contact_person_name, orders.total_discount,estimations.approved_by as estapproved_by,estimations.approved_date as estapprove_date' );
		$this->db->join( 'customers', 'orders.relation = customers.id', 'left' );
		$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
		$this->db->join( 'estimations', 'orders.estimation_id = estimations.estimation_id', 'left' );
		$this->db->join( 'contacts', 'orders.client_contact_id = contacts.id', 'left' );
		return $this->db->get_where( 'orders', array( 'orders.id' => $id ) )->row_array();
	}

	function get_order_by_priviliges( $id, $rel_type, $staff_id='' ) {
		if ( $rel_type == 'customer' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,customers.type as type,customers.company as customercompany,customers.email as toemail,customers.namesurname as namesurname,customers.address as toaddress,customers.zipcode as zip,orders.status_id as status_id, orders.id as id, orders.created as created, orders.approved_by, orders.approved_date,contacts.name as client_contact_person_name' );
			$this->db->join( 'customers', 'orders.relation = customers.id', 'left' );
			$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
			$this->db->join( 'contacts', 'orders.client_contact_id = contacts.id', 'left' );
			//$this->db->join( 'projects', 'orders.project_id = projects.id', 'left' );
		} elseif ( $rel_type == 'lead' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,leads.name as leadname,leads.address as toaddress,leads.email as toemail,orders.status_id as status_id,orders.id as id,contacts.name as client_contact_person_name ' );
			$this->db->join( 'leads', 'orders.relation = leads.id', 'left' );
			$this->db->join( 'staff', 'orders.assigned = staff.id', 'left' );
			$this->db->join( 'contacts', 'orders.client_contact_id = contacts.id', 'left' );
		}
		if($staff_id) {
			$this->db->where('orders.id' ,$id);
			$this->db->where('(orders.assigned='.$staff_id.' OR orders.addedfrom='.$staff_id.')');
			return $this->db->get('orders')->row_array();
		} else {
			return $this->db->get_where( 'orders', array( 'orders.id' => $id ) )->row_array();
		}
	}
	
	function get_order_documents( $id ) {
		return $this->db->get_where( 'order_documents', array('orderid' => $id))->result_array();
	}
	function get_order_documents_file( $id ) {
		return $this->db->get_where('order_documents', array( 'id' => $id ))->row_array();
	}
	function is_project_available($pname){
		$this->db->where('project', $pname);  
        $query = $this->db->get("orders");  
        if($query->num_rows() > 0){  
            return true;  
        }else{  
            return false;  
        }  
	}
	
	function get_staff_name_by_id($staff_id) {
		$this->db->select('staffname');
		$data = $this->db->get_where( 'staff', array('id' => $staff_id))->row_array(); 
		return $data["staffname"];
	}
	
	function getOrderByEstID($estID) {
		$data = $this->db->get_where('orders', array('estimation_id'=>$estID))->row_array();
		return $data;
	}
	
	function getRequestByEstID($estID) {
		$this->db->select( 'staff.staffname as requested_by,staff.staffavatar as staffavatar,orders.id as orderid,orders.created as requested_on' );
		$this->db->join( 'staff', 'orders.addedfrom = staff.id', 'inner' );
		$this->db->order_by( 'orders.id', 'desc' );
		$data=$this->db->get_where('orders', array('estimation_id'=>$estID))->row_array();
		return $data;
	}
	
	function get_order_items($id) {
		$items = $this->db->select( '*, CAST(tax as INTEGER) as tax, CAST(discount as INTEGER) as discount' )->get_where( 'items', array( 'relation_type' => 'order', 'relation' => $id ) )->result_array();
		if(sizeof($items) > 0) {
			foreach($items as &$eachOrder){
				$this->db->select('orders_sub_items.*, materials.itemname,materials.item_code,materials.itemdescription');
				$this->db->join( 'materials', 'materials.material_id = orders_sub_items.name', 'left' );
				$SubItem=$this->db->get_where( 'orders_sub_items', array( 'main_item_id' => $eachOrder['id']))->result_array();
				$eachOrder['child']=$SubItem;
			}
		}
		return $items;
	}
}