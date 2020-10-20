<?php
class Staff_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_staff( $id ) {
		$this->db->select( '*,languages.name as stafflanguage,departments.name as department, staff.id as id, staff.role_id as role_id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		$this->db->join( 'languages', 'staff.language = languages.foldername', 'left' );
		$this->db->join( 'roles', 'staff.role_id = roles.role_id', 'left' );
		return $this->db->get_where( 'staff', array( 'staff.id' => $id ) )->row_array();
	}
	
	
function get_department_staff($dept_id){
	$sql = "SELECT id,staffname FROM staff as stf WHERE FIND_IN_SET(stf.department_id,'$dept_id')";
	$res = $this->db->query($sql);
	$result = $res->result_array();
	//print_r($result);
	
	return $result;
	
}


	function validate_user_password( $id, $password ) {
		$this->db->from( 'staff' );
		$this->db->where( 'id', $id );
		$this->db->where( 'password', md5($password));
		$login = $this->db->get()->result();
		if ( is_array( $login ) && count( $login ) == 1 ) {
			return true;
		} else {
			return false;
		}
	}


	function get_all_staff($type="") {
		if($type) $this->db->where("staff.status",$type);
		$this->db->order_by("staff.id ","desc");
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( 'is_staff'=>'1' ) )->result_array();
	}
	function get_all_staff_new($type="") {
		if($type) $this->db->where("staff.status",$type);
		$this->db->order_by("staff.staffname ","asc");
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array('is_staff'=>'1') )->result_array();
	}
	
	function get_all_admins() {
		$this->db->select( 'email' );
		$this->db->from('staff');
		$this->db->where('role_id = 1');
		$this->db->order_by('id', 'asc');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	

	function add_staff( $params ) {
		$this->db->insert( 'staff', $params );
		$staffmember = $this->db->insert_id();
		$appconfig = get_appconfig();
		$number = $appconfig['staff_series'] ? $appconfig['staff_series'] : $staffmember;
		$staff_number = $appconfig['staff_prefix'].$number;
		$this->db->where('id', $staffmember)->update( 'staff', array('staff_number' => $staff_number ) );
		$workplan = array(
			0 =>
			array(
				'day' => lang('monday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:360',
			),
			1 =>
			array(
				'day' => lang('tuesday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:361',
			),
			2 =>
			array(
				'day' => lang('wednesday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:362',
			),
			3 =>
			array(
				'day' => lang('thursday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:363',
			),
			4 =>
			array(
				'day' => lang('friday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:364',
			),
			5 =>
			array(
				'day' => lang('saturday'),
				'status' => false,
				'start' => '',
				'end' => '',
				'breaks' =>
				array(
					'start' => '',
					'end' => '',
				),
				'$$hashKey' => 'object:365',
			),
			6 =>
			array(
				'day' => lang('sunday'),
				'status' => false,
				'start' => '',
				'end' => '',
				'breaks' =>
				array(
					'start' => '',
					'end' => '',
				),
				'$$hashKey' => 'object:366',
			),
		);
		$this->db->insert( 'staff_work_plan', array(
			'staff_id' => $staffmember,
			'work_plan' => json_encode( $workplan ),
		) );
	$sql = "SELECT * FROM workshift WHERE (FIND_IN_SET($params[department_id],workshift.department)) AND name='1'";
	$res = $this->db->query($sql);
    $result = $res->row_array();
    
    $dep_sql = "SELECT * FROM departments WHERE id='$params[department_id]'";
    $dep_res = $this->db->query($dep_sql);
    $dep_result = $dep_res->row_array();
    if($result['employee_id'] != ''){
        
         $employee_id = $result['employee_id'].",".$staffmember;
		    $sql1 = "UPDATE  workshift SET employee_id = '$employee_id' WHERE shift_id = '$result[shift_id]' ";
		   // echo $sql1; die;
		    $res1 = $this->db->query($sql1);
        
    }
    else{
        $sql1 = "INSERT INTO workshift(created,department,employee_id,start_time,late_in_count_time,end_time,late_out_count_time,name,shift_ref)VALUES($params[createdat],$params[department_id],$staffmember,'08:00','08.30','18.00','18.30','1',$dep_result[name])";
        $res = $this->db->query($sql1);
       $shift_id =  $this->db->insert_id();
       
       $shift_sql = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Morning','10.00','10:15')";
       $shift_res = $this->db->query($shift_sql);
       
        $shift_sql2 = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Lunch','13.00','14:00')";
       $shift_res2 = $this->db->query($shift_sql2);
       
        $shift_sql3 = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Evening','16.00','16:15')";
       $shift_res3 = $this->db->query($shift_sql3);
       
        
    }
		$loggedinuserid = $this->session->usr_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'added' ) . ' <a href="staff/staffmember/' . $staffmember . '">' . get_number('staff',$staffmember,'staff','staff') . '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		return $staffmember;
	}

	function update_language($id, $language) {
		$this->db->where('id', $id)->update('staff', array('language' => $language));
	}
	
	
	function update_staff_leave($data,$id) {
		$this->db->where('id', $id)->update(' staff_leaves', $data);
	}

 function update_avatar($id, $params) {
		$response = $this->db->where('id', $id)->update('staff', $params);
		
		return $response;
	}
	
	function update_password($id, $params) {
		 $this->db->where('id', $id)->update('staff', $params);
		
	
	}
	
	function update_staff( $id, $params ) {
		$appconfig = get_appconfig();
		$staff_data = $this->get_staff($id);
		$exist_dep = $staff_data['department_id'];
		if($staff_data['staff_number'] == '') {
			$number = $appconfig['staff_series'] ? $appconfig['staff_series'] : $id;
			$staff_number = $appconfig['staff_prefix'].$number;
			$this->db->where('id', $id)->update('staff', array('staff_number' => $staff_number));
			if(($appconfig['staff_series'] != '')) {
				$staff_number = $appconfig['staff_series'];
				$staff_number = $staff_number + 1;
				$this->Settings_Model->increment_series('staff_series', $staff_number);
			}
		}
		$this->db->where( 'id', $id );
	$response = $this->db->update('staff', array('language' => $params['language'],
														'staffname' => $params['staffname'],
														'employee_no' => $params['employee_no'],
														'status' => $params['status'],
														'gender' => $params['gender'],
														'grade' => $params['grade'],
														'remark' => $params['remark'],
														'homeaddress' => $params['homeaddress'],
														'department_id' => $params['department_id'],
														'role_id' => $params['role_id'],
														'phone' => $params['phone'],
														'nomineephone' => $params['nomineephone'],
														'address' => $params['address'],
														'email' => $params['email'],
														'timezone' => $params['timezone'],
														'inactive' => $params['inactive'],
														'admin' => $params['admin'],
														'other' => $params['other'],
														'staffmember' => $params['staffmember'],
														'joining_date' => $params['joining_date'],
														'profession' => $params['profession'],
														'nominee' => $params['nominee'],
						'nationality' => $params['nationality'],
						'updatedAt' => $params['updatedAt'],	
						'birthday' => $params['birthday'],
														'user_id' => $params['user_id']
		));
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $this->session->usr_id . '"> ' . $this->session->staffname . '</a> ' . lang( 'updated' ) . ' <a href="staff/staffmember/' . $id . '">' . get_number('staff',$id,'staff','staff') . '</a>.' ),
			'staff_id' => $this->session->usr_id,
		) );
		$dep_sql = "SELECT * FROM departments WHERE id='$params[department_id]'";
    $dep_res = $this->db->query($dep_sql);
    $dep_result = $dep_res->row_array();
		if($exist_dep != $params[department_id]){
		    
		    $daysql = "SELECT employee_id,shift_id FROM workshift WHERE (FIND_IN_SET($exist_dep,workshift.department)) AND name='1'";
		    $dayres = $this->db->query($daysql);
		    $dayresult = $dayres->row_array();
		    
		    $emps_ids = explode(',',$dayresult['employee_id']);
		    
		    if(in_array($id,$emps_ids)){
		      
		    $input = $id;
             $list = $dayresult['employee_id'];
             $array1 = Array($input);
            $array2 = explode(',', $list);
            $array3 = array_diff($array2, $array1);
            $output = implode(',', $array3);
            
            $dayupdatesql = "UPDATE  workshift SET employee_id = '$output' WHERE shift_id = '$dayresult[shift_id]' ";
		   // echo $sql1; die;
		    $this->db->query($dayupdatesql);
		    
		    }
		    
		     $nightsql = "SELECT employee_id,shift_id FROM workshift WHERE (FIND_IN_SET($exist_dep,workshift.department)) AND name='2'";
		    $nightres = $this->db->query($nightsql);
		    $nightresult = $nightres->row_array();
		    
		    $emps_idss = explode(',',$nightresult['employee_id']);
		    
		    if(in_array($id,$emps_idss)){
		      
		    $input = $id;
             $list = $nightresult['employee_id'];
             $array1 = Array($input);
            $array2 = explode(',', $list);
            $array3 = array_diff($array2, $array1);
            $output = implode(',', $array3);
            
            $nightupdatesql = "UPDATE  workshift SET employee_id = '$output' WHERE shift_id = '$dayresult[shift_id]' ";
		   // echo $sql1; die;
		    $this->db->query($nightupdatesql);
		    
		    }
		    
		    

		    
		$sql = "SELECT employee_id,shift_id FROM workshift WHERE (FIND_IN_SET($params[department_id],workshift.department)) AND name='1'";
		$res = $this->db->query($sql);
		$result = $res->row_array();
		if($result['employee_id'] != ''){
		    $employee_id = $result['employee_id'].",".$id;
		    $sql1 = "UPDATE  workshift SET employee_id = '$employee_id' WHERE shift_id = '$result[shift_id]' ";
		   // echo $sql1; die;
		    $res1 = $this->db->query($sql1);
		}
		    $created = date('Y-m-d');
		      $sql1 = "INSERT INTO workshift(created,department,employee_id,start_time,late_in_count_time,end_time,late_out_count_time,name,shift_ref)VALUES($created,$params[department_id],$id,'08:00','08.30','18.00','18.30','1',$dep_result[name])";
        $res = $this->db->query($sql1);
         $shift_id =  $this->db->insert_id();
       
       $shift_sql = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Morning','10.00','10:15')";
       $shift_res = $this->db->query($shift_sql);
       
        $shift_sql2 = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Lunch','13.00','14:00')";
       $shift_res2 = $this->db->query($shift_sql2);
       
        $shift_sql3 = "INSERT INTO workshift_break_timings(shift_id,breakname,start_time,end_time)VALUES('$shift_id','Evening','16.00','16:15')";
       $shift_res3 = $this->db->query($shift_sql3);
		    
		}
		
	}

function update_salary( $id, $params ) {
		$appconfig = get_appconfig();
		$staff_data = $this->get_staff($id);
	
		$this->db->where( 'id', $id );
	$response = $this->db->update('staff', $params);
	
	}

	function delete_staff( $id, $number ) {

		$appointments = $this->db->get_where('appointments', array('staff_id' => $id))->num_rows();
		$comments = $this->db->get_where('comments', array('staff_id' => $id))->num_rows();
		$db_backup = $this->db->get_where('db_backup', array('staff_id' => $id))->num_rows();
		$deposits = $this->db->get_where('deposits', array('staff_id' => $id))->num_rows();
		$discussions = $this->db->get_where('discussions', array('staff_id' => $id))->num_rows();
		$discussion_comments = $this->db->get_where('discussion_comments', array('staff_id' => $id))->num_rows();
		$events = $this->db->get_where('events', array('staff_id' => $id))->num_rows();
		$expenses = $this->db->get_where('expenses', array('staff_id' => $id))->num_rows();
		$invoices = $this->db->get_where('invoices', array('staff_id' => $id))->num_rows();
		$leads = $this->db->get_where('leads', array('staff_id' => $id))->num_rows();
		$lead = $this->db->get_where('leads', array('assigned_id' => $id))->num_rows();
		$meetings = $this->db->get_where('meetings', array('staff_id' => $id))->num_rows();
		$orders = $this->db->get_where('orders', array('assigned' => $id))->num_rows();
		$order = $this->db->get_where('orders', array('addedfrom' => $id))->num_rows();
		$payments = $this->db->get_where('payments', array('staff_id' => $id))->num_rows();
		$projectmembers = $this->db->get_where('projectmembers', array('staff_id' => $id))->num_rows();
		$projects = $this->db->get_where('projects', array('staff_id' => $id))->num_rows();
		$proposals = $this->db->get_where('proposals', array('assigned' => $id))->num_rows();
		$proposal = $this->db->get_where('proposals', array('addedfrom' => $id))->num_rows();
		$purchases = $this->db->get_where('purchases', array('staff_id' => $id))->num_rows();
		$subtasks = $this->db->get_where('subtasks', array('staff_id' => $id))->num_rows();
		$tasks = $this->db->get_where('tasks', array('assigned' => $id))->num_rows();
		$task = $this->db->get_where('tasks', array('addedfrom' => $id))->num_rows();
		$tasktimer = $this->db->get_where('tasktimer', array('staff_id' => $id))->num_rows();
		$ticketreplies = $this->db->get_where('ticketreplies', array('staff_id' => $id))->num_rows();
		$tickets = $this->db->get_where('tickets', array('staff_id' => $id))->num_rows();
		$vendors = $this->db->get_where('vendors', array('staff_id' => $id))->num_rows();
		$vendor_sales = $this->db->get_where('vendor_sales', array('staff_id' => $id))->num_rows();
		$webleads = $this->db->get_where('webleads', array('assigned_id' => $id))->num_rows();

		if (($appointments > 0) || ($comments > 0) || ($db_backup > 0) || ($deposits > 0) || ($discussions > 0) || ($discussion_comments > 0) || ($events > 0) || ($expenses > 0) || ($invoices > 0) || ($leads > 0) || ($lead > 0) || ($meetings > 0) || ($orders > 0) || ($order > 0) || ($payments > 0) || ($projectmembers > 0) || ($projects > 0) || ($proposals > 0) || ($proposal > 0) || ($purchases > 0) || ($subtasks > 0) || ($tasks > 0) || ($task > 0) || ($tasktimer > 0) || ($ticketreplies > 0) || ($tickets > 0) || ($vendors > 0) || ($vendor_sales > 0) || ($webleads > 0) ) {
			return false;
		} else {
			$response = $this->db->delete( 'staff', array( 'id' => $id ) );
			$response = $this->db->delete( 'privileges', array( 'relation' => $id, 'relation_type' => 'staff' ) );
			$staffname = $this->session->staffname;
			$loggedinuserid = $this->session->usr_id;
			$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . $number . '' ),
			'staff_id' => $loggedinuserid
		) );
			return true;
		}
	}

	function delete_avatar( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'staff', array( 'staffavatar' => 'n-img.jpg' ) );
	}

	function total_sales_by_staff( $id ) {
		$this->db->select_sum( 'total' );
		$this->db->from( 'sales' );
		$sales_total = $this->db->get_where( '', array( 'staff_id' => $id ) )->row()->total;
		if ( isset( $sales_total ) ) {
			$total = $sales_total;
		} else {
			$total = 0;
		}
		return $total;
	}

	function total_custoemer_by_staff( $id ) {
		$this->db->from( 'customers' );
		return $this->db->get_where( '', array( 'staff_id' => $id ) )->num_rows();
	}

	function total_ticket_by_staff( $id ) {
		$this->db->from( 'tickets' );
		return $this->db->get_where( '', array( 'staff_id' => $id ) )->num_rows();
	}

	function isDuplicate( $email ) {
		$this->db->get_where( 'staff', array( 'email' => $email ), 1 );
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}

	function get_staff_email($id) {
		return $this->db->get_where( 'staff', array( 'id' => $id ), 1 )->row_array();
	}

	function insertToken( $user_id ) {
		$token = substr( sha1( rand() ), 0, 30 );
		$date = date( 'Y-m-d' );

		$string = array(
			'token' => $token,
			'user_id' => $user_id,
			'created' => $date
		);
		$query = $this->db->insert_string( 'tokens', $string );
		$this->db->query( $query );
		return $token . $user_id;

	}

	function isTokenValid( $token ) {
		$tkn = substr( $token, 0, 30 );
		$uid = substr( $token, 30 );

		$q = $this->db->get_where( 'tokens', array(
			'tokens.token' => $tkn,
			'tokens.user_id' => $uid ), 1 );

		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();

			$created = $row->created;
			$createdTS = strtotime( $created );
			$today = date( 'Y-m-d' );
			$todayTS = strtotime( $today );

			if ( $createdTS != $todayTS ) {
				return false;
			}

			$user_info = $this->getUserInfo( $row->user_id );
			return $user_info;

		} else {
			return false;
		}

	}

	function getUserInfo( $id ) {
		$q = $this->db->get_where( 'staff', array( 'id' => $id ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $id . ')' );
			return false;
		}
	}

	function updateUserInfo( $post ) {
		$data = array(
			'password' => $post[ 'password' ],
			'last_login' => date( 'Y-m-d h:i:s A' ),
			'inactive' => $this->inactive[ 1 ]
		);
		$this->db->where( 'id', $post[ 'user_id' ] );
		$this->db->update( 'staff', $data );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updateUserInfo(' . $post[ 'user_id' ] . ')' );
			return false;
		}

		$user_info = $this->getUserInfo( $post[ 'user_id' ] );
		return $user_info;
	}

	function getUserInfoByEmail( $email ) {
		$q = $this->db->get_where( 'staff', array( 'email' => $email ), 1 );
		if ( $this->db->affected_rows() > 0 ) {
			$row = $q->row();
			return $row;
		} else {
			error_log( 'no user found getUserInfo(' . $email . ')' );
			return false;
		}
	}

	function updatePassword( $post ) {
		$this->db->where( 'id', $post[ 'user_id' ] );
		$this->db->update( 'staff', array( 'password' => $post[ 'password' ] ) );
		$success = $this->db->affected_rows();

		if ( !$success ) {
			error_log( 'Unable to updatePassword(' . $post[ 'user_id' ] . ')' );
			return false;
		}
		return true;
	}

	function get_work_plan( $id ) {
		return $this->db->get_where( 'staff_work_plan', array( 'staff_id' => $id ) )->row_array();
	}

	function get_role_type($role_id) {
		return $this->db->get_where( 'roles', array( 'role_id' => $role_id ) )->row()->role_type;	
	}

	function restore_workplan($staff_id) {
		$this->db->where('staff_id', $staff_id);
		$this->db->delete('staff_work_plan');
		$workplan = array(
			0 =>
			array(
				'day' => lang('monday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:360',
			),
			1 =>
			array(
				'day' => lang('tuesday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:361',
			),
			2 =>
			array(
				'day' => lang('wednesday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:362',
			),
			3 =>
			array(
				'day' => lang('thursday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:363',
			),
			4 =>
			array(
				'day' => lang('friday'),
				'status' => true,
				'start' => '09:00',
				'end' => '18:00',
				'breaks' =>
				array(
					'start' => '14:30',
					'end' => '15:00',
				),
				'$$hashKey' => 'object:364',
			),
			5 =>
			array(
				'day' => lang('saturday'),
				'status' => false,
				'start' => '',
				'end' => '',
				'breaks' =>
				array(
					'start' => '',
					'end' => '',
				),
				'$$hashKey' => 'object:365',
			),
			6 =>
			array(
				'day' => lang('sunday'),
				'status' => false,
				'start' => '',
				'end' => '',
				'breaks' =>
				array(
					'start' => '',
					'end' => '',
				),
				'$$hashKey' => 'object:366',
			),
		);
		$this->db->insert( 'staff_work_plan', array(
			'staff_id' => $staff_id,
			'work_plan' => json_encode( $workplan ),
		) );

		return true;
	}


	function add_increment( $params ) {
		$this->db->insert( 'staff_increment', $params );
		return $this->db->insert_id();

	}
	function add_warning( $params ) {
		$this->db->insert( 'staff_warning', $params );
		return $this->db->insert_id();

	}
	function add_leaves( $params ) {
		$this->db->insert( 'staff_leaves', $params );
		return $this->db->insert_id();

	}
	function add_tools( $params ) {
		$this->db->insert( 'staff_tools', $params );
		return $this->db->insert_id();

	}
	function add_notes( $params ) {
		$this->db->insert( 'staff_notes', $params );
		return $this->db->insert_id();

	}
	
	function add_documents( $params ) {
		$this->db->insert( 'staff_documents', $params );
		return $this->db->insert_id();

	}
    	function add_other_documents( $params ) {
		$this->db->insert( 'staff_other_documents', $params );
		
	
		return $this->db->insert_id();

	}
	function update_documents( $params,$id ) {
		$this->db->where('id',$id);
		$this->db->update( 'staff_documents', $params );
		return true;

	}
		function update_other_documents( $params,$id ) {
		$this->db->where('id',$id);
		$this->db->update( 'staff_other_documents', $params );
		
		return true;

	}

	function update_notes( $params,$id ) {
		$this->db->where('id',$id);
		$this->db->update( 'staff_notes', $params );
		return true;

	}


function update_increment($params,$id){
    	$this->db->where('id',$id);
		$this->db->update( 'staff', $params );
		return true;

    
}
	function  delete_notes($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_notes'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
    
    function  delete_other_documents($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_other_documents'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
     function  delete_tools_and_assests($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_tools'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
    
      function  delete_leaves_records($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_leaves'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
    
    
    function delete_appraisal_records($id) {
       
         $sql = $this->db->query("SELECT * FROM staff_increment WHERE id = '$id'");
   
        $row = $sql->row();
        
		
		$staff = $this->Staff_Model->get_staff( $row->staff_id );
		
    
        if($row->increment_type == 'Fixed Portion'){
            $amt=$staff['basic_salary']-$row->increment_amount;
            $update_sql = $this->db->query("UPDATE staff SET basic_salary = '".$amt."'WHERE id='".$row->staff_id."'");
            
        }
        else if($row->increment_type == 'Allowance'){
            $amt=$staff['allowance']-$row->increment_amount;
            $update_sql = $this->db->query("UPDATE staff SET allowance =   '".$amt."' WHERE id='".$row->staff_id."'");
        }
        else if($row->increment_type == 'Transpotation Al1owance')
        {
			 $amt=$staff['vehicle_amound']-$row->increment_amount;
           
            $update_sql = $this->db->query("UPDATE staff SET vehicle_amound =   '".$amt."' WHERE id='".$row->staff_id."'");
        }
        else if($row->increment_type == 'Accomdation Al1owance')
        {
             $amt=$staff['accom_amound']-$row->increment_amount;
            $update_sql = $this->db->query("UPDATE staff SET accom_amound =   '".$amt."' WHERE id='".$row->staff_id."'");
        }
		///echo $this->db->last_query();
		//exit;
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_increment'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
    
    
    function delete_warning_records($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('staff_warning'); 
        //echo $this->db->last_query();
        if($query){
            return true;
        } else {
            return false;
        }
    }
    

	function get_appraisal($staff_id) {
		$this->db->from('staff_increment');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->result();
	}
	
function get_fixed_appraisals($staff_id){
    $sql = $this->db->query("SELECT increment_amount FROM staff_increment WHERE staff_id='$staff_id' AND increment_type = 'Fixed Portion' order by id desc LIMIT 1");
   
    $row = $sql->row();

   if($row){
    return $row->increment_amount;
    
}else{
     return 0;  
}
}



function get_allow_appraisals($staff_id){
    $sql = $this->db->query("SELECT increment_amount FROM staff_increment WHERE staff_id='$staff_id' AND increment_type = 'Allowance' order by id desc LIMIT 1");
    
    $row = $sql->row();

    if($row){
    return $row->increment_amount;
    
}else{
     return 0;  
}
}


function get_travel_appraisals($staff_id){
    $sql = $this->db->query("SELECT increment_amount FROM staff_increment WHERE staff_id='$staff_id' AND increment_type = 'Transpotation Al1owance' order by id desc LIMIT 1");
    
    $row = $sql->row();
if($row){
    return $row->increment_amount;
    
}else{
     return 0;  
}
}

function get_accom_appraisals($staff_id){
    $sql = $this->db->query("SELECT increment_amount FROM staff_increment WHERE staff_id='$staff_id' AND increment_type = 'Accomdation Al1owance' order by id desc LIMIT 1");
    
    $row = $sql->row();
if($row){
    return $row->increment_amount;
}else{
    
 return 0;   
}
}

	function get_user_appraisal($user_id,$id) {
		$this->db->from('staff_increment');
		$this->db->where('user_id',$user_id);
			$this->db->where('staff_id',$id);
		return $this->db->get()->result_array();
	}
	function get_warning($staff_id) {
		$this->db->from('staff_warning');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->result();
	}
	function get_user_warning($user_id,$id) {
		$this->db->from('staff_warning');
		$this->db->where('user_id',$user_id);
			$this->db->where('staff_id',$id);
		return $this->db->get()->row();
	}
	function get_leaves($staff_id) {
		$this->db->from('staff_leaves');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->result();
	}
	function get_user_leaves($user_id,$id) {
		$this->db->from('staff_leaves');
		$this->db->where('user_id',$user_id);
			$this->db->where('staff_id',$id);
		return $this->db->get()->row();
	}
	function get_tools($staff_id) {
		$this->db->from('staff_tools');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->result();
	}
		function get_user_tools($user_id,$id) {
		$this->db->from('staff_tools');
		$this->db->where('user_id',$user_id);
			$this->db->where('staff_id',$id);
		return $this->db->get()->row();
	}
	function get_notes($staff_id) {
		$this->db->select('staff_notes.*,staff.staffname');
		$this->db->from('staff_notes');
		$this->db->join('staff',"staff.id = staff_notes.added_by",'left');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->result();
	}
	function get_documents($staff_id) {
		$this->db->from('staff_documents');
		$this->db->where('staff_id',$staff_id);
		return $this->db->get()->row();
	}
		function get_other_documents($staff_id) {
		$this->db->from('staff_other_documents');
		$this->db->where('staff_id',$staff_id);
		
	
		return $this->db->get()->result_array();
	}
	
		function get_user_entered_documents($user_id,$id) {
		$this->db->from('staff_documents');
		$this->db->where('user_id',$user_id);
		$this->db->where('staff_id',$id);
		return $this->db->get()->result_array();
	}
		function get_user_entered_other_documents($user_id) {
		$this->db->from('staff_other_documents');
		$this->db->where('user_id',$user_id);
		
	
		return $this->db->get()->result_array();
	}
	function get_staff_details($id) {
		$this->db->where('staff.id',$id);
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
        $query = $this->db->get('staff');
        
        if($query->num_rows()>0) {
        
            return $query->result();
        } else {
            return false;
        }	
    }

        function get_staff_appraisal($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_increment');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
       function get_staff_warning($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_warning');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
         function get_staff_leaves($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_leaves');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
    function get_staff_tools($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_tools');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
    
    function get_staff_notes($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_notes');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
    function get_staff_documents($id) {
		$this->db->where('staff_id',$id);
        $query = $this->db->get('staff_documents');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }	
    }
     function get_status($status) {
		$this->db->from('staff');
		if($status !='all') $this->db->where('status',$status);
		return $this->db->get()->num_rows();
	}

	function get_pinned_status() {
		$this->db->from('staff');
		$this->db->where('pin_status',1);
		return $this->db->get()->result();
	}

	function update_staff_stauts($id,$data){
		$this->db->where('id', $id);
		$this->db->update('staff', $data);
	}
	function update_staff_grade($id,$rating){
	   
	    $this->db->set('grade', $rating);
	    $this->db->where('id',$id);
	   $result=$this->db->update('staff');
		return $result;
	    
	}
	
	 function get_present_count($year,$month,$staff_id){
        if($month == 'Jan'){  $m = '01'; }
        if($month == 'Feb'){ $m = '02'; }
        if($month == 'Mar'){ $m = '03'; }
        if($month == 'Apr'){ $m = '04'; }
        if($month == 'May'){ $m = '05'; }
        if($month == 'Jun'){ $m = '06'; }
        if($month == 'Jul'){ $m = '07'; }
        if($month == 'Aug'){ $m = '08'; }
        if($month == 'Sep'){ $m = '09'; }
        if($month == 'Oct'){ $m = '10'; }
        if($month == 'Nov'){ $m = '11'; }
        if($month == 'Dec'){ $m = '12'; }
        
        $sql = "SELECT * FROM `staff_attendance` WHERE YEAR(attendance_date) = $year AND MONTH(attendance_date) = $m AND staff_id = $staff_id ";
       // print_r($sql);
        $query = $this->db->query($sql);
    $atn_count = 0;
        $atn_result  =  $query->row_array();
       
        for($i=1;$i<=31;$i++){
         
          
            if(  $atn_result['day_'.$i] == 'P'){
                $atn_count += 1;
            }
        }
        
        if($atn_count >=  0)
        
        return $atn_count;
    }
    
    
    	 function get_absent_count($year,$month,$staff_id){
        if($month == 'Jan'){  $m = '01'; }
        if($month == 'Feb'){ $m = '02'; }
        if($month == 'Mar'){ $m = '03'; }
        if($month == 'Apr'){ $m = '04'; }
        if($month == 'May'){ $m = '05'; }
        if($month == 'Jun'){ $m = '06'; }
        if($month == 'Jul'){ $m = '07'; }
        if($month == 'Aug'){ $m = '08'; }
        if($month == 'Sep'){ $m = '09'; }
        if($month == 'Oct'){ $m = '10'; }
        if($month == 'Nov'){ $m = '11'; }
        if($month == 'Dec'){ $m = '12'; }
        
        $sql = "SELECT * FROM `staff_attendance` WHERE YEAR(attendance_date) = $year AND MONTH(attendance_date) = $m AND staff_id = $staff_id ";
       // print_r($sql);
        $query = $this->db->query($sql);
    $atn_count = 0;
        $atn_result  =  $query->row_array();
       
        for($i=1;$i<=31;$i++){
         
          
            if(  $atn_result['day_'.$i] == 'A'){
                $atn_count += 1;
            }
        }
        
        if($atn_count >=  0)
        
        return $atn_count;
    }
    
    function update_file($image_name,$type,$id){
        if($type == 'Passport'){
        $sql = $this->db->query("UPDATE  staff_documents SET `passport_doc` = replace(replace(passport_doc, '$image_name', ''), '@@' , '@') WHERE id = '$id'");
        }
        if($type == 'Emirates'){
              $sql = $this->db->query("UPDATE  staff_documents SET `emirates_doc` = replace(replace(emirates_doc, '$image_name', ''), '@@' , '@') WHERE id = '$id'");
        }
         if($type == 'Labour'){
              $sql = $this->db->query("UPDATE  staff_documents SET `labour_doc` = replace(replace(labour_doc, '$image_name', ''), '@@' , '@') WHERE id = '$id'");
        }
         if($type == 'Atm'){
              $sql = $this->db->query("UPDATE  staff_documents SET `atm_doc` = replace(replace(atm_doc, '$image_name', ''), '@@' , '@') WHERE id = '$id'");
        }
        if($sql){
            return true;
        } else {
            return false;
        }
        
    }
    
    
    
    function get_staff_department_wise($department_id="") {
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( 'department_id' => $department_id ) )->result_array();
	}
	
	function get_staff_multi_department_wise($department_id="") {
		
		$ids = array($department_id);
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->from('staff');
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		
		$this->db->where_in('department_id', $ids,FALSE );
		
		return $this->db->get()->result_array();
	}
	
	
	function employee_history($type,$name)
	{
		$date=date('Y-m-d');
		$user_id = $this->session->usr_id;
		$string = array(
			'history_name' => $name,
			'updated_by' => $user_id,
			'history_type'=>$type,
			'created_date' => $date
		);
		$query = $this->db->insert_string( 'employment_history', $string );
		$this->db->query( $query );
	}
	function get_all_history() {
		$this->db->select( '*' );
		$this->db->from('employment_history');
		
		$this->db->order_by('history_id', 'desc');
		
		return $this->db->get()->result_array();
	}
	
	function get_format_change($date){
		
		return date('dS F Y', strtotime($date));
	}
	function get_format_change1($date){
		
		return date('d-m-Y', strtotime($date));
	}
	
	function  get_staff_attendance($first_date,$last_date,$staffid) {
		
         $sql = "SELECT *,st.staffname FROM staff_attendance as sa  JOIN staff as st ON st.id = sa.staff_id WHERE  sa.attendance_date >= '".$first_date."' AND sa.attendance_date <= '".$last_date."' and sa.staff_id='".$staffid."'";
      
            
        $res = $this->db->query($sql);
		
       
        $result = $res->result_array();
        
        return $result;
    }
	function get_approval_staff(){
		$this->db->select('staffname,id');
		$data = $this->db->get('staff')->result_array();
		return $data;
	}
	
	function get_allStaffInfo(){
		$sql = "SELECT s.staffavatar,sd.staff_id,sd.passport,sd.emirates_id,sd.labour_card,sd.atm_card,
		DATE_SUB(DATE_FORMAT(STR_TO_DATE(sd.passport_expiry_date, '%d-%m-%y'), '%Y-%m-%d'),INTERVAL REPLACE(IF(sd.passport_remind !='',sd.passport_remind,'30'),' days','') DAY) as passportreminddate,DATE_SUB(DATE_FORMAT(STR_TO_DATE(sd.emirates_expiry_date, '%d-%m-%y'), '%Y-%m-%d'), INTERVAL REPLACE(IF(sd.emirates_remind !='',sd.emirates_remind,'30'),' days','') DAY) as emiratesreminddate,DATE_SUB(DATE_FORMAT(STR_TO_DATE(sd.labour_expiry_date, '%d-%m-%y'), '%Y-%m-%d'), INTERVAL REPLACE(IF(sd.labour_remind !='',sd.labour_remind,'30'),' days','') DAY) as labourreminddate,DATE_SUB(DATE_FORMAT(STR_TO_DATE(sd.atm_expiry_date, '%d-%m-%y'), '%Y-%m-%d'), INTERVAL REPLACE(IF(sd.atm_remind !='',sd.atm_remind,'30'),' days','') DAY) as atmreminddate FROM staff_documents as sd LEFT JOIN staff as s ON (s.id=sd.staff_id) order by sd.staff_id ASC";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	
	function get_allotherInfo(){
		$sql = "SELECT s.staffavatar,sod.staff_id,sod.document_id,sod.others,
		DATE_SUB(DATE_FORMAT(STR_TO_DATE(sod.other_expiry_date, '%d-%m-%y'), '%Y-%m-%d'),INTERVAL REPLACE(IF(sod.others_remind !='',sod.others_remind,'30'),' days','') DAY) as othersreminddate FROM staff_other_documents as sod LEFT JOIN staff as s ON (s.id=sod.staff_id) where sod.other_expiry_date !='' AND sod.others !='' order by sod.staff_id ASC";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	
	function get_all_admin_ids() {
		$data=array();
		$result=array();
		$this->db->select( 'id' );
		$this->db->from('staff');
		$this->db->where('role_id = 1');
		$this->db->order_by('id', 'asc');
		$data=$this->db->get()->result_array();
		foreach($data as $eachId){
			$result[]=$eachId['id'];
		}
		return $result;
	}
	
	function staffrolesAssign($params){
	  $this->db->where( 'id', $params['staffid']);
      $response = $this->db->update('staff', array('role_id' => $params['role_id'],'email' => $params['email'],'password' =>$params['password'],'admin'=>$params['admin'],'staffmember'=>$params['staffmember'],'other'=>$params['other']));
	  return true;	
	}
	function nonstaffrolesAssign($params){
	  $nonStaffparams =array(
							'staffname' => $params['staffname'],
							'email' => $params['email'],
							'password' =>$params['password'],
							'role_id'=> $params['role_id'],
							'status'=> '1',
							'staffavatar' => 'n-img.jpg',
							'admin' => NULL,
							'staffmember' =>NULL,
							'joining_date' => date('YYYY-MM-DD'),
							'other' => NULL,
							'inactive' => NULL,
							'createdat'=>date('YYYY-MM-DD'),
							'user_id' => $this->session->userdata( 'usr_id' ),
							'is_staff'=>'0',
						);
		$this->db->insert( 'staff', $nonStaffparams);
		$nonstaffmember =$this->db->insert_id();
		$staff_number = 'NONSTAFF-'.$nonstaffmember;
		$this->db->where('id', $nonstaffmember)->update( 'staff', array('staff_number' => $staff_number ) );
		return true;
	}
	
	
	function getallStaff(){
		$this->db->select('staff.id as staffId,staff.staffname,staff.password,staff.role_id,staff.is_staff,staff.admin,staff.status,roles.role_name,staff.login_access as access');
		$this->db->join( 'roles', 'roles.role_id = staff.role_id');
		$this->db->order_by("staff.id ","desc");
        $data = $this->db->get('staff')->result_array();
		return $data;
	}
	
	function getStaffRolePending(){
		$this->db->select('id as staffId,staffname');
		$where = "is_staff='1' AND (email='NULL' OR email='' OR role_id='0')";
		$this->db->where($where);
		$this->db->order_by("id ","desc");
        $data = $this->db->get('staff')->result_array();
		return $data;
	}
	function getRoleByStaffId($id){
		$this->db->select('staff.id as staffId,staff.staffname,staff.role_id,staff.status,roles.role_name');
		$this->db->join( 'roles', 'roles.role_id = staff.role_id');
		$this->db->where( 'staff.id', $id );
        $data = $this->db->get('staff')->row_array();
		return $data;
		
		
		
	}
	
	
}