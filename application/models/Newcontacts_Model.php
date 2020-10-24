<?php

class Newcontacts_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_contact( $id ) {
		return $this->db->get_where( 'contact_persons', array( 'person_id' => $id ) )->row_array();
	}
	function get_contact_number( $id ) {
		return $this->db->get_where( 'contact_person_number', array( 'contact_person_id' => $id ) )->result_array();
	}
	function get_contact_person_doc( $id ) {
		return $this->db->get_where( 'contact_person_documents', array( 'contact_person_id' => $id ) )->result_array();
	}
	
	function delete_contact_number($id) {
		return $this->db->delete('contact_person_number', array( 'contact_person_id' => $id));
	}

	function get_task_detail( $id ) {
		$this->db->select( '*,staff.staffname as assigner,tasks.id as id, staff.email as staffemail' );
			$this->db->join( 'staff', 'tasks.assigned = staff.id', 'left' );
			return $this->db->get_where( 'tasks', array( 'tasks.id' => $id ) )->row_array();

	}
	function get_task_time_log($id) {
		$this->db->select('*,staff.staffname as staffmember,tasktimer.id as id');
		$this->db->join( 'staff', 'tasktimer.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tasktimer', array( 'tasktimer.task_id' => $id ) )->result_array();
	}

	function get_project_tasks( $id ) {
		$this->db->select( '*' );
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'tasks', array( 'tasks.relation_type' => 'project', 'tasks.relation' => $id) )->result_array();

	}

	function get_all_contacts($type="",$user_id="") {
		if($type) $this->db->where("contact_persons.type",$type);
		if($user_id) $this->db->where("contact_persons.user_id",$user_id);
		$this->db->select('*');
		return $this->db->get_where( 'contact_persons', array( '' ) )->result_array();
	}
	function get_all_tasks_staff($id) {
		$this->db->select('*');
		return $this->db->get_where( 'staff', array( 'id' => $id) )->row_array();
	}

	function get_all_tasks_calendar($staff_id='') {
		if($staff_id) {
			$this->db->select('*, tasks.id as id');
			$this->db->join('staff', 'tasks.assigned = staff.id', 'left');
			$this->db->where('(tasks.assigned='.$staff_id.' OR tasks.addedfrom='.$staff_id.')');
			$result = $this->db->get('tasks')->result_array();
			return $result;
			
		} else {
			$this->db->select('*, tasks.id as id');
			$this->db->join('staff', 'tasks.assigned = staff.id', 'left');
			$result = $this->db->get_where( 'tasks', array( '' ) )->result_array();
			return $result;
		}
	}

	function get_all_tasks_for_timer() {
		$admin = $this->isAdmin();
		$this->db->select( '*' );
		$this->db->from('tasks');
		$user_id = $this->session->usr_id;
		if (!$admin) {
			$this->db->where("assigned = '$user_id'");
		}
		$this->db->order_by( 'id', 'desc' );
		$data = $this->db->get()->result_array();
		return $data;
	}

	function isAdmin() {
		$id = $this->session->usr_id;
		$this->db->select('*');
		$rows = $this->db->get_where( 'staff', array( 'admin' => 1, 'id' => $id ) )->num_rows();
        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
	}

	function get_subtasks( $id ) {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'subtasks', array( 'subtasks.taskid' => $id, 'subtasks.complete' => 0 ) )->result_array();
	}

	function get_subtaskscomplete( $id ) {
		return $this->db->get_where( 'subtasks', array( 'subtasks.taskid' => $id, 'subtasks.complete' => 1 ) )->result_array();
	}

	function get_task_files( $id ) {
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'task', 'files.relation' => $id ) )->result_array();

	}

	function add_contact_person($params){
		$this->db->insert( 'contact_persons', $params );
		$contact_id = $this->db->insert_id();
		
		return $contact_id;
	}
	function add_contact_person_number($params){		
	$this->db->insert( 'contact_person_number', $params );		 	
	}
	function add_contact_person_documents($params){		
	$this->db->insert( 'contact_person_documents', $params );			
	}

	function update_contact_person( $id, $params ) {
		
		$this->db->where( 'person_id', $id );
		$response = $this->db->update( 'contact_persons', $params );
		return $response;
	}
	function update_contact_person_details( $id, $params ) {
		
		$this->db->where( 'person_id', $id );
		$response = $this->db->update( 'contact_persons', $params );
		return $response;
	}

	function start_timer($id) {
		$date = new DateTime();
		$this->db->insert( 'tasktimer', array(
			//'relation' => 'task',
			'task_id' => NULL,
			'staff_id' => $id,
			'start' => $date->format('Y-m-d H:i:s'),
			'note' => '',
		));
		return $this->db->insert_id();
	}

	function stop_timer($timer_id, $params) {
		$this->db->where( 'id', $timer_id );
		$response = $this->db->update( 'tasktimer', $params );
		$response = $this->db->where( 'id', $params[ 'task_id' ] )->update( 'tasks', array( 'timer' => 0 ) );
		if ($response) {
			return true;
		} else {
			return false;
		}
	}

	function delete_timer($timer_id) {
		return $this->db->delete('tasktimer', array( 'id' => $timer_id));
	}

	function get_timer() {
		$this->db->select( 'tasktimer.id, tasktimer.start, tasktimer.end, tasktimer.task_id, tasks.name, tasktimer.note' );
		$this->db->join( 'tasks', 'tasktimer.task_id = tasks.id', 'left' );
		$this->db->order_by('tasktimer.id', 'desc');
		$data = $this->db->get_where( 'tasktimer', array( 'tasktimer.end' => NULL, 'tasktimer.staff_id' => $this->session->usr_id ) )->result_array();
		if ($data) {
			return $data;
		} else {
			return false;
		}
	}

	function get_timer_data($id){
		$this->db->select('');
		$response = $this->db->get_where('tasktimer', array('tasktimer.id' => $id))->row_array();
		return $response;
	}

	function get_all_tasks_by_privileges($staff_id='') {
		$this->db->order_by( 'id', 'desc' );
		if($staff_id) {
			
			$like1=''.$staff_id.',%';
				$like2='%,'.$staff_id.'%';
				$like3='%,'.$staff_id.',%';
				$like4='%,'.$staff_id.'';
				$assigned="assigned LIKE ('".$staff_id."') OR assigned LIKE ('".$like1."') OR assigned LIKE('".$like2."') OR assigned LIKE('".$like3."') OR assigned LIKE('".$like4."')";
				
			
			// $this->db->get('tasks')->result_array();
			  $sql = $this->db->query("SELECT * FROM tasks  where ".$assigned." OR  addedfrom='".$staff_id."' ");
			  
			   return $sql->result_array();
			   //echo $this->db->last_query();
			
		} else {
			return $this->db->get_where( 'tasks', array( '' ) )->result_array();	
		}
	}

	function get_task_by_privileges( $id, $staff_id='' ) {
		if($staff_id) {
			$like1=''.$staff_id.',%';
				$like2='%,'.$staff_id.'%';
				$like3='%,'.$staff_id.',%';
				$like4='%,'.$staff_id.'';
				$assigned="assigned LIKE ('".$staff_id."') OR assigned LIKE ('".$like1."') OR assigned LIKE('".$like2."') OR assigned LIKE('".$like3."') OR assigned LIKE('".$like4."')";
				
			
			// $this->db->get('tasks')->result_array();
			  $sql = $this->db->query("SELECT * FROM tasks  where ".$assigned." OR  addedfrom='".$staff_id."' ");
			  
			   return $sql->row_array();
		}
		else{
			$this->db->select( '*,tasks.id as id' );
			//$this->db->join( 'staff', 'tasks.assigned = staff.id', 'left' );
			return $this->db->get_where( 'tasks', array( 'tasks.id' => $id ) )->row_array();
			 //echo $this->db->last_query();
			/*
			if($staff_id) {
				$this->db->where('tasks.id' ,$id);
				$this->db->where('(tasks.assigned='.$staff_id.' OR tasks.addedfrom='.$staff_id.')');
				return $this->db->get('tasks')->row_array();
			} else {
				
			}*/
		}
		
	}

	function get_countries(){
		$this->db->select('*');
		return $this->db->get( 'country' )->result_array();
	}

	public function delete_contact($id){
		return $this->db->delete('contact_persons', array( 'person_id' => $id));
	}

	function get_file($id) {
		return $this->db->get_where( 'contact_persons', array( 'userfile' => $id) )->row_array();
	}
	function get_file_new($id) {
		return $this->db->get_where( 'contact_person_documents', array( 'contact_doxument_id' => $id) )->row_array();
	}
}
