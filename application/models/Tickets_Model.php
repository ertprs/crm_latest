<?php
class Tickets_Model extends CI_Model {
	function __construct() {
		parent::__construct();
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
  function get_employee_name($empsd,$id){
      
      $sql = "SELECT GROUP_CONCAT(staff.staffname) as empname,GROUP_CONCAT(staff.staffavatar) as images FROM tickets LEFT JOIN staff ON FIND_IN_SET(staff.id,'$empsd') WHERE tickets.id='$id'";
      
    $res = $this->db->query($sql);
    $result = $res->row_array();
    
    return $result;
      
  }
	/* Get All Tickets */

	function get_all_tickets() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id, contacts.email as contactemail ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		$this->db->order_by( 'date desc, priority desc' );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'tickets', array() )->result_array();
	}

	function get_all_tickets_by_customer( $id ) {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		$this->db->order_by( 'date desc, priority desc' );
		$this->db->order_by( "date", "desc" );
		return $this->db->get_where( 'tickets', array( 'contact_id' => $id ) )->result_array();
	}

	function get_all_open_tickets() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.status_id' => 1 ) )->result_array();
	}

	function get_all_open_tickets_by_staff() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.status_id' => 1, 'staff_id' => $this->session->usr_id ) )->result_array();
	}

	function get_all_inprogress_tickets() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.status_id' => 2 ) )->result_array();
	}

	function get_all_answered_tickets() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.status' => 3 ) )->result_array();
	}

	function get_all_closed_tickets() {
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id ' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tickets', array( 'tickets.status_id' => 4 ) )->result_array();
	}

	function add_tickets( $params ) {
		$tempemployeeids=array();
		$employeeids=array();
		$adminides=$this->Staff_Model->get_all_admin_ids();
		if($params['employee_id'] !=''){
			$tempemployeeids=array_unique(array_merge($adminides,(explode(",",$params['employee_id']))));
		}else{
		   $tempemployeeids=$adminides;
		}
		foreach($tempemployeeids as $eachId){
			$employeeids[]=array("id"=>$eachId);
		}
		$this->db->insert( 'tickets', $params );
		$ticket = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['ticket_series'] ? $appconfig['ticket_series'] : $ticket;
		$ticket_number = $appconfig['ticket_prefix'].$number;
		$this->db->where('id', $ticket)->update( 'tickets', array('ticket_number' => $ticket_number ) );
		$url = base_url('tickets/ticket/'.$ticket);
		$this->db->insert( 'logs', array( 
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ) . ' <a href="tickets/ticket/' . $ticket . '">' . get_number('tickets',$ticket,'ticket','ticket') . '</a>' ),
			'staff_id' => $this->session->usr_id
		) );
		$Notifyparams=array();
		$Notifyparams['staffList']=$employeeids;
		$Notifyparams['msg']=(''.get_number('tickets',$ticket,'ticket','ticket').' Added By ' . $this->session->staffname . '');
		$Notifyparams['link']= base_url('tickets/ticket/' . $ticket . '');
		$Notifyparams['staff_id']= '';
		$Notifyparams['img']=$this->session->staffavatar;
		$this->Notifications_Model->insertNotification($Notifyparams);
		return $ticket;
	}

	function add_reply_contact( $params ) {
		$this->db->insert( 'ticketreplies', $params );
		return $this->db->insert_id();
	}

	function update_tickets( $id, $params ) {
		$passparams=array();
		$appconfig = get_appconfig();
		$ticket_data = $this->get_tickets($id);
		if($ticket_data['ticket_number']==''){
			$number = $appconfig['ticket_series'] ? $appconfig['ticket_series'] : $id;
			$ticket_number = $appconfig['ticket_prefix'].$number;
			$this->db->where('id',$id)->update('tickets',array('ticket_number'=>$ticket_number));
			if(($appconfig['ticket_series']!='')){
				$ticket_number = $appconfig['ticket_series'];
				$ticket_number = $ticket_number + 1;
				$this->Settings_Model->increment_series('ticket_series',$ticket_number);
			}
		}
		//Notification//
		$tempemployeeids=array();
		$adminides=$this->Staff_Model->get_all_admin_ids();
		$tempemployeeids=$adminides;
		foreach($tempemployeeids as $eachId){
			$employeeids[]=array("id"=>$eachId);
		}
        $Notifyparams=array();
		$Notifyparams['staffList']=$employeeids;
		$Notifyparams['msg']=(''.$ticket_data['ticket_number'].'  '.$params['name'] .'    BY'. $this->session->staffname . '');
		$Notifyparams['link']= base_url('tickets/ticket/' . $id . '');
		$Notifyparams['staff_id']=$ticket_data['stid'] ;
		$Notifyparams['img']=$this->session->staffavatar;
		$this->Notifications_Model->insertNotification($Notifyparams);
		
		$this->db->where( 'id', $id );
		$passparams['status_id'] =$params['status_id'];
		$passparams['modified_date'] = date('Y-m-d H:i:s');
		$response = $this->db->update( 'tickets', $passparams );
	}

	function markas() {
		$response = $this->db->where( 'id', $_POST[ 'ticket_id' ] )->update( 'tickets', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}

	function delete_tickets( $id, $number ) {
		$response = $this->db->delete( 'tickets', array( 'id' => $id ) );
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'deleted' ) . ' ' . $number . '' ),
			'staff_id' => $this->session->usr_id
		) );
	}

	function check_tickets_permission($id, $contact_id) {
		$data = $this->db->get_where( 'tickets', array( 'id' => $id, 'contact_id' => $contact_id ) )->num_rows();
		if ($data > 0) {
			return true;
		} else {
			return false;
		}
	}

	function weekly_ticket_stats() {
		$this->db->where( 'CAST(date as DATE) >= "' . date( 'Y-m-d', strtotime( 'monday this week', strtotime( 'last sunday' ) ) ) . '" AND CAST(date as DATE) <= "' . date( 'Y-m-d', strtotime( 'sunday this week', strtotime( 'last sunday' ) ) ) . '"' );
		$tickets = $this->db->get( 'tickets' )->result_array();
		$chart = array(
			'labels' => get_weekdays(),
			'datasets' => array(
				array(
					'label' => 'Weekly Ticket Report',
					'backgroundColor' => 'rgba(197, 61, 169, 0.5)',
					'borderColor' => '#c53da9',
					'borderWidth' => 1,
					'tension' => false,
					'data' => array(
						0,
						0,
						0,
						0,
						0,
						0,
						0
					)
				)
			)
		);
		foreach ( $tickets as $ticket ) {
			$ticket_day = date( 'l', strtotime( $ticket[ 'date' ] ) );
			$i = 0;
			foreach ( get_weekdays_original() as $day ) {
				if ( $ticket_day == $day ) {
					$chart[ 'datasets' ][ 0 ][ 'data' ][ $i ]++;
				}
				$i++;
			}
		}
		return $chart;
	}

	function get_all_tickets_by_privileges($staff_id='') {
	    if($staff_id){
	        
	      $sql = "SELECT *, `departments`.`name` as `department`, `staff`.`staffname` as `staffmembername`, `staff`.`staffavatar` as `staffavatar`, `contacts`.`name` as `contactname`, 
	             `contacts`.`surname` as `contactsurname`, `tickets`.`id` as `id`, `contacts`.`email` as `contactemail`, `projects`.`name`, `tickets`.`status_id` as `status_id` FROM tickets
                LEFT JOIN `contacts` ON `tickets`.`contact_id` = `contacts`.`id` 
        	   LEFT JOIN `projects` ON `tickets`.`customer_id` = `projects`.`id` 
        	   LEFT JOIN `departments` ON `tickets`.`department_id` = `departments`.`id` 
        	   LEFT JOIN `staff` ON `tickets`.`staff_id` = `staff`.`id` 
        	   WHERE (FIND_IN_SET($staff_id,tickets.employee_id) or `tickets`.`staff_id` = '$staff_id')
        	   ORDER BY `tickets`.`status_id` asc,`date` desc, `priority` desc, `date` DESC "; 
        	   
        	   //print_r($sql);
        	 $res = $this->db->query($sql);
        	 $result = $res->result_array();
        	 return $result;
        	   
	        
	    }else{
		$this->db->select( '*,departments.name as department,staff.staffname as staffmembername,staff.staffavatar as staffavatar,contacts.name as contactname,contacts.surname as contactsurname, tickets.id as id, contacts.email as contactemail,projects.name,tickets.status_id as status_id' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'projects', 'tickets.customer_id = projects.id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
		$this->db->order_by( "tickets.status_id", "asc" );
		$this->db->order_by( 'date desc, priority desc' );
		$this->db->order_by( "date", "desc" );
		
			return $this->db->get_where( 'tickets', array() )->result_array();
		}
	}
	function get_ticket_record($staff_id,$id){
	    $sql = "SELECT staff_id FROM tickets WHERE FIND_IN_SET($staff_id,tickets.employee_id) AND id = '$id'";
	    //print_r($sql);
	    $res = $this->db->query($sql);
	    $result = $res->row_array();
	    return $result;
	    
	}

	function get_ticket_by_privileges( $id, $staff_id='' ) {
	    if($staff_id){
	       $sql =  "SELECT *, `staff`.`role_id` as `srole_id`, `customers`.`type` as `type`, `customers`.`email` as `customeremail`, 
	        `customers`.`company` as `company`, `customers`.`namesurname` as `namesurname`, `departments`.`name` as `department`,
	        `staff`.`staffname` as `staffmembername`, `staff`.`email` as `staffemail`, `contacts`.`name` as `contactname`,
	        `contacts`.`surname` as `contactsurname`, `tickets`.`staff_id` as `stid`, `tickets`.`status_id` as `status_id`, 
	        `tickets`.`id` as `id`, `projects`.name as `projectname` FROM tickets LEFT JOIN `contacts` ON `tickets`.`contact_id` = `contacts`.`id` 
	        LEFT JOIN `customers` ON `contacts`.`customer_id` = `customers`.`id`
			LEFT JOIN `projects` ON `tickets`.`project_id` = `projects`.`id`
			LEFT JOIN `departments` ON `tickets`.`department_id` = `departments`.`id` 
	        LEFT JOIN `staff` ON `tickets`.`staff_id` = `staff`.`id` WHERE (FIND_IN_SET($staff_id,tickets.employee_id) or `tickets`.`staff_id` = '$staff_id')  AND tickets.id = '$id'";  
	        
	        $res = $this->db->query($sql);
	        $result = $res->row_array();
	        return $result;
	        
	    }
	    else{
		$this->db->select( '*,staff.role_id as srole_id,customers.type as type, customers.email as customeremail, customers.company as company,customers.namesurname as namesurname,departments.name as department,staff.staffname as staffmembername,staff.email as staffemail,contacts.name as contactname,contacts.surname as contactsurname,tickets.staff_id as stid,tickets.status_id as status_id, tickets.id as id, projects.name as projectname' );
		$this->db->join( 'contacts', 'tickets.contact_id = contacts.id', 'left' );
		$this->db->join( 'customers', 'contacts.customer_id = customers.id', 'left' );
		$this->db->join( 'projects', 'projects.id = tickets.project_id', 'left' );
		$this->db->join( 'departments', 'tickets.department_id = departments.id', 'left' );
		$this->db->join( 'staff', 'tickets.staff_id = staff.id', 'left' );
	
		
			return $this->db->get_where( 'tickets', array('tickets.id' => $id ) )->row_array();
		}
	}
}