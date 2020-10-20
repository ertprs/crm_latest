<?php
class Mrequests_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function getSettingsByType($type) {
		$this->db->select('*');
		$result = $this->db->get_where('setting_params_values', array('setting_params_values.type'=> $type))->result_array();
		return $result;
	}
	
	function get_priority_count($priority,$userid=null){
		if($userid != null) {
			$condArr = ['priority' => $priority, 'user_id' => $userid];
			$this->db->where($condArr);
		} else {
			$this->db->where('priority', $priority);
		}
		
		$this->db->from('material_req');
		$cnt = $this->db->count_all_results();
		return $cnt;
	}
	
	function get_status_count($statusid, $userid=null){
		if($statusid != '' && $userid != null) {
			$condArr = ['status' => $statusid, 'user_id' => $userid];	
		} else if($statusid != '' && $userid == null) {
			$condArr = ['status' => $statusid];
		} else if($statusid == '' && $userid != null) {
			$condArr = ['user_id' => $userid];
		} else {
			$condArr = array();
		}
		$this->db->where($condArr);
		$this->db->from('material_req');
		$cnt = $this->db->count_all_results();
		return $cnt;
	}
	
	function get_all_mrequests($status, $priority) {
		$this->db->select('material_req.*,projects.name as project_name,projects.name,material_req.id as mrid,staff.staffavatar,IFNULL(materials.itemdescription,material_req.material_name) as materialname, material_req.status as status, material_req.created as created, setting_params_values.settings_key as priority,vendors.company as vendorname, (CASE WHEN (material_req.status = 1) THEN "Open" WHEN  (material_req.status = 2) THEN "Pending" WHEN (material_req.status = 3) THEN "Approved" WHEN (material_req.status = 4) THEN "Declined" END) AS statusname, (CASE WHEN (material_req.status = 1) THEN "redCls" WHEN  (material_req.status = 2) THEN "orangeCls" WHEN (material_req.status = 3) THEN "greenCls" WHEN (material_req.status = 4) THEN "brownCls" END) AS colorname, material_req.status as status');
		$this->db->join( 'projects', 'material_req.project_id = projects.id', 'left' );
		$this->db->join( 'staff', 'material_req.user_id = staff.id', 'left' );
		$this->db->join( 'materials', 'material_req.mname = materials.material_id', 'left' );
		$this->db->join( 'vendor_materials', 'material_req.vendor_id = vendor_materials.vendor_mat_id', 'left' );
		$this->db->join( 'vendors', 'vendors.id = vendor_materials.vendor_id', 'left' );
		$this->db->join( 'setting_params_values', 'setting_params_values.settings_value = material_req.priority AND setting_params_values.type = "Request_priority"');
		$this->db->order_by( 'material_req.id', 'desc' );
		if($priority != 0) {
			$res = $this->db->get_where( 'material_req', array('material_req.priority' =>$priority ) )->result_array();
		}
		else {
			if($status != '') {
				$res = $this->db->get_where( 'material_req', array( 'material_req.status' => $status ) )->result_array();
			} else {
				$res = $this->db->get('material_req')->result_array();
			}
		}
		return $res;
	}
	
	function get_user_mrequests($status,$user_id) {
		$this->db->select('material_req.*,projects.name as project_name,projects.name,material_req.id as mrid,staff.staffavatar,IFNULL(materials.itemdescription,material_req.material_name) as materialname, material_req.status as status, material_req.created as created, setting_params_values.settings_key as priority,vendors.company as vendorname, (CASE WHEN (material_req.status = 1) THEN "Open" WHEN  (material_req.status = 2) THEN "Pending" WHEN (material_req.status = 3) THEN "Approved" WHEN (material_req.status = 4) THEN "Declined" END) AS statusname, (CASE WHEN (material_req.status = 1) THEN "redCls" WHEN  (material_req.status = 2) THEN "orangeCls" WHEN (material_req.status = 3) THEN "greenCls" WHEN (material_req.status = 4) THEN "brownCls" END) AS colorname, material_req.status as status');
		$this->db->join( 'projects', 'material_req.project_id = projects.id', 'left' );
		$this->db->join( 'staff', 'material_req.user_id = staff.id', 'left' );
		$this->db->join( 'materials', 'material_req.mname = materials.material_id', 'left' );
		$this->db->join( 'vendor_materials', 'material_req.vendor_id = vendor_materials.vendor_mat_id', 'left' );
		$this->db->join( 'vendors', 'vendors.id = vendor_materials.vendor_id', 'left' );
		$this->db->join( 'setting_params_values', 'setting_params_values.settings_value = material_req.priority AND setting_params_values.type = "Request_priority"');
		$this->db->order_by( 'material_req.id', 'desc' );
		if($priority != 0) {
			$res = $this->db->get_where( 'material_req', array('material_req.priority' =>$priority,'material_req.user_id' => $user_id ) )->result_array();
		}
		else {
			if($status != '') {
				$res = $this->db->get_where( 'material_req', array( 'material_req.status' => $status,'material_req.user_id' => $user_id ) )->result_array();
			} else {
				$res = $this->db->get_where( 'material_req', array('material_req.user_id' => $user_id ) )->result_array();
			}
		}
		return $res;
	}
	
	function get_all_files($id) {
		$this->db->select('*');
		return $this->db->get_where( 'material_request_files', array( 'material_request_files.material_req_id' => $id ) )->result_array();
	}
	
	function get_mreq_data_old($id)
	{
		return $this->db->select('vendors.company as vendorname, materials.item_code as itemcode, materials.itemname as itemname, materials.itemdescription as itemdescription, vendor_materials.vendor_ref as ref, vendor_materials.vendor_price as price')
	                ->from('material_req')
					->join('materials', 'materials.material_id = material_req.mname','left')
					->join('vendor_materials', 'vendor_materials.material_id = materials.material_id','left')
					->join('vendors', 'vendor_materials.vendor_id = vendors.id','left')
				    ->where(['material_req.id'=>$id])
				    ->get()
				    ->row();
	}
	
	function update_mreq_data($id,$price,$status,$vendor_id, $quantity, $vendor_price){
		$getMrequestresult = $this->db->get_where('material_req', array('material_req.id'=> $id))->row_array();
		$staffId=$getMrequestresult['user_id'];
		$seriesid=$getMrequestresult['seriesid'];
		$approve_level=$getMrequestresult['approve_level'];
	    $statusMsg='';
		switch ( $status ) {
			case '1':
				$statusMsg = lang( 'Open' );
				break;
			case '2':
				$statusMsg = lang( 'Pending' );
				break;
			case '3':
				$statusMsg = lang( 'Approved' );
				break;
			case '4':
				$statusMsg = lang( 'Declined' );
				break;
		};
		
		
		if($status=='3'){
			$getapprovals=$this->Approvals_Model->getapprovalsByType('leaverequests');
			$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
			$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
			if($optionType=='level'){
				if($maxapproverLevel== $approve_level){
					$this->db->set('status', $status);
				}else{
					$currentLevel=$approve_level+1;
					$this->db->set('approve_level', $currentLevel);
					$statusMsg='Approve '.$approve_level.' Level';
				}
			}else if($optionType=='price'){
				$this->db->set('status', $status);
			}
			$this->db->set('price', $price);
			$this->db->set('vendor_id', $vendor_id);
			$this->db->set('qty', $quantity);
			$this->db->set('vendor_price', $vendor_price);
			$this->db->where('id', $id);
			$result=$this->db->update('material_req');
		}else{
			$this->db->set('price', $price);
			$this->db->set('status', $status);
			$this->db->set('vendor_id', $vendor_id);
			$this->db->set('qty', $quantity);
			$this->db->set('vendor_price', $vendor_price);
			$this->db->where('id', $id);
			$result=$this->db->update('material_req');
		}

		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' =>( '' .$seriesid.' '.$statusMsg.'  By '. $this->session->staffname .'' ),
			'staff_id' => $staffId,
			'target' => '' . base_url( 'mrequests/') . '',
			'perres' => $this->session->staffavatar
		) );
		return $result;
	}

	function get_mreq_data($id)
	{
		return $this->db->select('*')
	                ->from('material_req')
				    ->where(['id'=>$id])
				    ->get()
				    ->row_array();
	}
	
	function get_all_vendors($id) {
		$this->db->select('vendor_materials.vendor_ref as ref, vendor_materials.vendor_price as price, vendors.company as vendorname, vendor_materials.vendor_mat_id as vendorMaterialId');
		$this->db->from('vendor_materials');
		$this->db->join('vendors', 'vendor_materials.vendor_id = vendors.id','left');
		$this->db->where('vendor_materials.material_id', $id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	/* Get Tickets */

	function get_tickets( $id ) {
		$this->db->select( '*,customers.type as type, customers.email as customeremail, customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,staff.email as staffemail,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid,tickets.status_id as status_id, tickets.id as id' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'customers', 'contacts.customer_id = customers.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.id' => $id ) )->row_array();
	}
	
	function get_product_name($material_id){
		$sql = "SELECT productname FROM products WHERE id ='$material_id' ";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		return $result;
	}
	function get_request($id){
		$sql = "SELECT * FROM all_req WHERE id = '$id'";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		return $result;
	}
	function get_material_request($id){
		$sql  = "SELECT * FROM  material_req  WHERE id = '$id'";
		$res  = $this->db->query($sql);
		$result  = $res->row_array();
		return $result;
	}
	function get_oreq_request($id)
	{
		$sql  = "SELECT * FROM other_requests WHERE id = '$id'";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		return $result;
		
	}
	function get_oreq_request_files($id){
		
		$sql = "SELECT * FROM other_request_files WHERE request_id = '$id'";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	function get_leave_request($id){
		
		$sql  = "SELECT * FROM leave_requests WHERE leave_id = '$id'";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		return $result;
	}
	function get_bill_requests($id){
		$sql  = "SELECT * FROM bill_requests WHERE bill_id = '$id'";
		$res   = $this->db->query($sql);
		$result  = $res->row_array();
		return $result;
		
	}
	function get_sal_requests($id){
		$sql  = "SELECT * FROM salary_requests WHERE salary_id = '$id'";
		$res   = $this->db->query($sql);
		$result  = $res->row_array();
		return $result;
		
	}
	
	function delete_other_files($image,$id){
		
		$sql = "DELETE FROM other_request_files WHERE file_name = '$image' AND request_id='$id'";
		$res  = $this->db->query($sql);
		return $res;
	}
	function get_all_requests(){
		$this->db->select('*,all_req.id as reqid, staff.staffavatar,all_req.status as req_status');
		$this->db->join( 'staff', 'all_req.user_id = staff.id', 'left' );
		$this->db->order_by( "all_req.id", "desc" );
			return $this->db->get_where( 'all_req', array() )->result_array();
		
		
	}

	function update_status($id,$params){
		$getMrequestresult = $this->db->get_where('material_req', array('material_req.id'=> $id))->row_array();
		$staffId=$getMrequestresult['user_id'];
		$seriesid=$getMrequestresult['seriesid'];	
		$status='';
		switch ( $params[ 'status' ] ) {
			case '1':
				$status = lang( 'Open' );
				break;
			case '2':
				$status = lang( 'Pending' );
				break;
			case '3':
				$status = lang( 'Approved' );
				break;
			case '4':
				$status = lang( 'Declined' );
				break;
		};

		if($params[ 'status' ]=='3'){
			$getdata=$this->db->get_where( 'material_req', array( 'material_req.id' => $id ) )->row_array();
			$getapprovals=$this->Approvals_Model->getapprovalsByType('mrequests');
			$optionType=($getapprovals['option'] !='' ? $getapprovals['option'] :'');
			$maxapproverLevel=($getapprovals['maxapproverlevel'] !='' ? $getapprovals['maxapproverlevel'] :'');
			if($optionType=='level'){
				if($maxapproverLevel==$getdata['approve_level']){
					$response = $this->db->where( 'id', $id )->update('material_req', array( 'status' => $params[ 'status' ])) ;
				}else{
					$currentLevel=$getdata['approve_level']+1;
					$response = $this->db->where( 'id', $id )->update('material_req', array( 'status' => '1','approve_level' => $currentLevel));
					$status='Approve '.$getdata['approve_level'].' Level';
				}
			}else if($optionType=='price'){
				$response = $this->db->where( 'id', $id )->update('material_req', array( 'status' => $params[ 'status' ])) ;
			}
		}else{
			$response = $this->db->where( 'id', $id )->update('material_req', array( 'status' => $params[ 'status' ])) ;
		}
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' =>( '' .$seriesid.' '.$status.'  By '. $this->session->staffname .'' ),
			'staff_id' => $staffId,
			'target' => '' . base_url( 'mrequests/') . '',
			'perres' => $this->session->staffavatar
		) );
		return $response;
	}
	function update_other($id,$params){
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'other_requests', $params );
		return $response;
	}
	function update_main_request($id,$params){
		$this->db->where( 'request_id', $id );
		$response = $this->db->update( 'all_req', $params );
		return $response;
	}
	

	
	function get_mat_for_purchase($mat_req_id) {
		$this->db->select('material_req.material_name as pmaterialname, material_req.price as pprice, material_req.qty as pqty, material_req.unit_type as punittype, vendor_materials.vendor_id as pvendorid, material_req.id as pmreqid');
		$this->db->from('material_req');
		$this->db->join( 'vendor_materials', 'vendor_materials.vendor_mat_id = material_req.vendor_id','left');
		$this->db->where_in('material_req.id', $mat_req_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
}