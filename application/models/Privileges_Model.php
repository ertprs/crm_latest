<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Privileges_Model extends CI_MODEL {

	function __construct() {
		parent::__construct();
	}

	function get_staff_permissions( $id ) {
		$array = array('relation_type' => 'staff', 'relation' => $id);
		$result = $this->db->select( 'permission_id' )->where($array)->get( 'privileges' );
		return array_column( $result->result_array(), 'permission_id' );
	}
	
	function has_privilege ( $path ) {
		$staff_id = $this->session->usr_id;
		$role = $this->db->get_where('staff', array('id' => $staff_id))->row_array();
		$role_id = $role['role_id'];
		$permission = $this->db->get_where('permissions', array('key' => $path))->row_array();
		$permission_id = $permission['id'];
		$staffpermissions = $this->db->get_where('individual_role_permissions', array('permission_id' => $permission_id, 'role_id' => $role_id,'staff_id'=>$staff_id))->row_array();
		if($staffpermissions){
			$permissions=$staffpermissions;
		}else{
			$permissions = $this->db->get_where('role_permissions', array('permission_id' => $permission_id, 'role_id' => $role_id))->row_array();
		}
		if($permissions) {
			if($permissions['permission_view_own'] == '1' || $permissions['permission_view_all'] == '1') {
				return true;
			} else { 
				return false;
			}
		} else {
			return false;
		}
	}

	function check_privilege ( $path, $type ) {
		$staff_id = $this->session->usr_id;
		$role = $this->db->get_where('staff a', array('a.id' => $staff_id))->row_array();
		$role_id = $role['role_id'];
		$permission = $this->db->get_where('permissions', array('key' => $path))->row_array();
		$permission_id = $permission['id'];
		$staffpermissions = $this->db->get_where('individual_role_permissions', array('permission_id' => $permission_id, 'role_id' => $role_id,'staff_id'=>$staff_id))->row_array();
		if($staffpermissions){
			$permission=$staffpermissions;
		}else{
			$permission = $this->db->get_where('role_permissions', array('permission_id' => $permission_id, 'role_id' => $role_id))->row_array();
		}
		if($permission) {
			if( $type == 'create' && $permission['permission_create'] == '1') {
				return true;
			} else if( $type == 'edit' && $permission['permission_edit'] == '1') {
				return true;
			} else if( $type == 'delete' && $permission['permission_delete'] == '1') {
				return true;
			} else if( $type == 'all' && $permission['permission_view_all'] == '1' ) {
				return true;
			} else if( $type == 'own' && $permission['permission_view_own'] == '1' ) {
				return true;
			} else { 
				return false;
			}
		} else {
			return false;
		}
	}
	
	function contact_has_privilege( $path ) {
		$relation = $_SESSION[ 'contact_id' ];
		$this->db->select( '*,permissions.key as permission_key');
		$this->db->join( 'permissions', 'privileges.permission_id = permissions.id', 'left' );
		$rows = $this->db->get_where( 'privileges', array( 'permissions.key' => $path, 'relation' => $relation, 'relation_type' => 'contact') )->num_rows();
		return ( $rows > 0 ) ? TRUE : FALSE;
	}

	function get_privileges() {
		$query = $this->db->get( 'privileges' );
		return $query->result_array();
	}

	function get_all_permissions() {
		return $this->db->get( 'permissions' )->result_array();
	}
	
	function getCategoriesByParentId($elementid, $roleid) {
		$this->db->select('*');
		$this->db->from('permissions');
		$this->db->join( 'role_permissions', 'permissions.id = role_permissions.permission_id and role_permissions.role_id ="'.$roleid.'"', 'left' );
		$where = "permissions.parent='".$elementid."' AND permissions.status=1";
		$this->db->where($where);
		$this->db->group_by('permissions.id'); 
		$this->db->order_by('permissions.showorder', 'ASC');
		$data = $this->db->get()->result_array();
		
		$newArray = array();
		foreach($data as $key=>&$eachData) {
			$eachData['permission_key'] = lang($eachData['permission']);
			$eachData['permission_view_own'] = $eachData['permission_view_own'] == '1' ? true : false;
			$eachData['permission_view_all'] = $eachData['permission_view_all'] == '1' ? true : false;
			$eachData['permission_create'] = $eachData['permission_create'] == '1' ? true : false;
			$eachData['permission_edit'] = $eachData['permission_edit'] == '1' ? true : false;
			$eachData['permission_delete'] = $eachData['permission_delete'] == '1' ? true : false;
			
			if($eachData['permission_delete'] == '1' && $eachData['permission_edit'] == '1' && $eachData['permission_create'] == '1' && $eachData['permission_view_all']=='1' && $eachData['permission_view_own'] == '1'){
				$eachData['permission_check']=true;
			}else{
				$eachData['permission_check']=false;
			}
			if($this->getCategoriesByParentId($eachData['id'], $roleid))
			{
				$eachData['viewChilds'] = 1;
				
				$data[$key]['child']=$this->getCategoriesByParentId($eachData['id'], $roleid);
			} else {
				$eachData['viewChilds'] = 0;	
			}
		}
		return $data;
	}
	
	function getPermissionsByParentID($elementid, $type = '', $permissionall = 0) {
		$this->db->select('*');
		$this->db->from('permissions');
		$where = "permissions.parent='".$elementid."' AND permissions.status=1";
		$this->db->where($where);
		$this->db->group_by('permissions.id'); 
		$this->db->order_by('permissions.showorder', 'ASC');
		$data = $this->db->get()->result_array();
		$newArray = array();
		foreach($data as $key=>&$eachData) {
			$eachData['id'] = $eachData['id'];
			$eachData['key'] = $eachData['key'];
			$eachData['permission_key'] = lang($eachData['permission']);
			if($permissionall == 0) {
				$eachData['permission_check']=false;	
			} else {
				$eachData['permission_check']=true;
			}
					
			if($permissionall == 1) {
				$eachData['permission_view_own'] = (($type == 'staff' && $eachData['key'] == 'settings') || ($type == 'staff' && $permission['key'] == 'staff') || ($type == 'other' && ($permission['key'] == 'invoices' || $permission['key'] == 'expenses'))) ? false : true;
				$eachData['permission_view_all'] = ($type == 'staff' && $eachData['key'] == 'settings') ? false : true;
				$eachData['permission_create'] = (($type == 'staff' && $eachData['key'] == 'settings') || ($type == 'staff' && $permission['key'] == 'staff') || ($type == 'other' && ($permission['key'] == 'invoices' || $permission['key'] == 'expenses'))) ? false : true;
				$eachData['permission_edit'] = (($type == 'staff' && $eachData['key'] == 'settings') || ($type == 'staff' && $permission['key'] == 'staff') || ($type == 'other' && ($permission['key'] == 'invoices' || $permission['key'] == 'expenses'))) ? false : true;
				$eachData['permission_delete'] = (($type == 'staff' && $eachData['key'] == 'settings') || ($type == 'staff' && $permission['key'] == 'staff') || ($type == 'other' && ($permission['key'] == 'invoices' || $permission['key'] == 'expenses'))) ? false : true;	
			} else {
				$eachData['permission_view_own'] = false;
				$eachData['permission_view_all'] = false;
				$eachData['permission_create'] = false;
				$eachData['permission_edit'] = false;
				$eachData['permission_delete'] = false;
				$eachData['permission_check']=false;
			}
			
			if($this->getPermissionsByParentID($eachData['id'], $type, $permissionall))
			{
				$eachData['viewChilds'] = 1;
				$data[$key]['child']=$this->getPermissionsByParentID($eachData['id'], $type, $permissionall);
			} else {
				$eachData['viewChilds'] = 0;	
			}
		}
		return $data;
	}
	
	function getPermissionsByStaff($elementid, $staff_id, $roleid) {
			$this->db->select('*, permissions.id as id');
			$this->db->from('permissions');
			$this->db->join( 'individual_role_permissions', 'permissions.id = individual_role_permissions.permission_id and individual_role_permissions.role_id ="'.$roleid.'" and individual_role_permissions.staff_id ="'.$staff_id.'"');
			
			$where = "permissions.parent='".$elementid."' AND permissions.status=1";
			$this->db->where($where);
			$this->db->group_by('permissions.id'); 
			$this->db->order_by('permissions.showorder', 'ASC');
			$data = $this->db->get()->result_array();
			
			$newArray = array();
			foreach($data as $key=>&$eachData) {
				$eachData['permission_key'] = lang($eachData['permission']);
				$eachData['permission_view_own'] = $eachData['permission_view_own'] == '1' ? true : false;
				$eachData['permission_view_all'] = $eachData['permission_view_all'] == '1' ? true : false;
				$eachData['permission_create'] = $eachData['permission_create'] == '1' ? true : false;
				$eachData['permission_edit'] = $eachData['permission_edit'] == '1' ? true : false;
				$eachData['permission_delete'] = $eachData['permission_delete'] == '1' ? true : false;
				
				if($eachData['permission_delete'] == '1' && $eachData['permission_edit'] == '1' && $eachData['permission_create'] == '1' && $eachData['permission_view_all']=='1' && $eachData['permission_view_own'] == '1'){
					$eachData['permission_check']=true;
				}else{
					$eachData['permission_check']=false;
				}
				if($this->getPermissionsByStaff($eachData['id'], $staff_id, $roleid))
				{
					$eachData['viewChilds'] = 1;
					
					$data[$key]['child']=$this->getPermissionsByStaff($eachData['id'], $staff_id, $roleid);
				} else {
					$eachData['viewChilds'] = 0;	
				}
			}
		return $data;
	}
	
	function build_child($elementid) {
		$data = $this->db->get_where('permissions', array('parent'=>$elementid))->result_array();
		return $data;
	}
	
	function get_all_common_permissions() {
		return $this->db->get_where( 'permissions', array( 'type' => 'common') )->result_array();
	}

	function add_privilege( $id, $privileges ) {
		$array = array('relation_type' => 'staff', 'relation' => $id);
		$delete_old = $this->db->where($array)->delete( 'privileges' );
		$data = array();
		foreach ( $privileges as $key ) {
			$arr = array(
				'relation' => ( int )$id,
				'relation_type' => 'staff',
				'permission_id' => ( int )$key
			);

			array_push( $data, $arr );
		}
		$insert_new = $this->db->insert_batch( 'privileges', $data );

		if ( $insert_new ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function add_contact_privilege( $id, $privileges ) {
		$array = array('relation_type' => 'contact', 'relation' => $id);
		$delete_old = $this->db->where($array)->delete( 'privileges' );
		$data = array();
		foreach ( $privileges as $key ) {
			$arr = array(
				'relation' => ( int )$id,
				'relation_type' => 'contact',
				'permission_id' => ( int )$key
			);

			array_push( $data, $arr );
		}
		$insert_new = $this->db->insert_batch( 'privileges', $data );

		if ( $insert_new ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function get_approval_modules(){
		$this->db->select('*')->from('permissions');
		$this->db->where('id NOT IN (SELECT `permissions_id` FROM approvals)  AND approval_req = 1', NULL, FALSE);
		$data = $this->db->get()->result_array();
		return $data;
	}
	function get_updateapproval_modules(){
		$this->db->select('*')->from('permissions');
		$this->db->where('approval_req = 1', NULL, FALSE);
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	function has_approval($permissiontype){
		$results=array();
		$maxvalue=0;
		$staff_id = $this->session->usr_id;
		$this->db->select('approvals.approverlevel,approvals.approveprice,approvals.option');
		$this->db->from('approvals');
		$this->db->join('permissions', 'approvals.permissions_id = permissions.id');
		$this->db->where(array( 'permissions.key' => $permissiontype, 'permissions.approval_req' =>'1','approvals.status'=>'Active','approvals.approverid'=>$staff_id));
		$results=$this->db->get()->result_array();
		
		if(sizeof($results) > 0){
			$option=$results['0']['option'];
			if($option=='price'){
				$maxvalue=max(array_column($results, 'approveprice'));
			}else{
				$maxvalue=max(array_column($results, 'approverlevel'));
			}
			
		}else{
			$maxvalue=0;
		}
	
		return $maxvalue;	
	}
	
	
	function has_approval_access_old($permissiontype){
		$results=array();
		$approvalAccess=0;
		$staff_id = $this->session->usr_id;
		$this->db->select('approvals.approverlevel,approvals.approveprice,approvals.option');
		$this->db->from('approvals');
		$this->db->join('permissions', 'approvals.permissions_id = permissions.id');
		$this->db->where(array( 'permissions.key' => $permissiontype, 'permissions.approval_req' =>'1','approvals.status'=>'Active','approvals.approverid'=>$staff_id));
		$results=$this->db->get()->result_array();		
		if(sizeof($results) > 0){
			$approvalAccess=1;
		}else{
			$approvalAccess=0;
		}
		return $approvalAccess;	
	}
	
	
	
	function has_approval_access($permissiontype){
		$results=array();
		$approvalAccess=array();
		$staff_id = $this->session->usr_id;
		$this->db->select('approvals.approverlevel,approvals.approveprice,approvals.option');
		$this->db->from('approvals');
		$this->db->join('permissions', 'approvals.permissions_id = permissions.id');
		$this->db->where(array('permissions.key' => $permissiontype, 'permissions.approval_req' =>'1','approvals.status'=>'Active','approvals.approverid'=>$staff_id));
		$results=$this->db->get()->result_array();		
		if(sizeof($results) > 0){
			$option=$results['0']['option'];
			if($option=='price'){
				$approvalAccess['type']='price';
				$approvalAccess['maxvalue']=max(array_column($results, 'approveprice'));
			}else{
				$approvalAccess['type']='level';
				$approvalAccess['maxvalue']=max(array_column($results, 'approverlevel'));
			}
			
		}else{
			$approvalAccess['type']='';
			$approvalAccess['maxvalue']=0;
		}
		return $approvalAccess;	
	}
	
	function get_all_privilegeuser($keyType){
		$sql = "Select id from staff where role_id=1 
		UNION
		Select staff.id from role_permissions inner join permissions on permissions.id = role_permissions.permission_id AND role_permissions.permission_view_all =1 AND permissions.`key`='".$keyType."' 
		INNER JOIN staff ON staff.role_id=role_permissions.role_id";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;
	}
	
	function create_history($params){
		$comments='';
		$permission_id=0;
		$permission = $this->db->get_where('permissions', array('key' => $params['module']))->row_array();
		if($permission){
			$permission_id = $permission['id'];
		}
		if($params['type']=='update'){
			$comments='updated';
		}elseif($params['type']=='delete'){
			$comments='delete';
		}elseif($params['type']=='status'){
			$comments='change status';
			$oldvalue=(isset($params['oldvalue']) && $params['oldvalue'] !='' ? $params['oldvalue'] : '');
			$newvalue=(isset($params['newvalue']) && $params['newvalue'] !='' ? $params['newvalue'] : '');
		}elseif($params['type']=='added'){
			$comments='added';
		}else{
			$comments=$params['type'];
		}
		$this->db->insert( 'history', array(
			'relation_module' => $params['module'],
			'relation_id' => $params['relation_id'],
			'permission_id'=>$permission_id,
			'comments' =>$comments,
			'oldvalue' =>$oldvalue,
			'newvalue' =>$newvalue,
			'created_by' =>$this->session->usr_id ,
			'created_on' => date( 'Y-m-d H:i:s' ),
			'is_active' =>1
		));
		return true;
	}
	
	
	function get_histroy_by_relation_id($id,$model,$loadMore=''){
		$this->db->select( 'staff.id as staff_id,staff.staffname as staffmembername, staff.staffavatar as staffimage, history.created_on as date,history.comments,history.oldvalue,history.newvalue,history.relation_id' );
		$this->db->join( 'staff', 'history.created_by = staff.id', 'left' );
		$this->db->order_by( "history.created_on", "desc" );
		if($loadMore == '') {
			$this->db->limit(10);	
		}
		return $this->db->get_where( 'history', array( 'history.relation_id' => $id,'history.relation_module'=>$model,'history.is_active'=>1))->result_array();
	}
	
	function create_revisions($revparams){
		$this->db->insert( 'revisions', array(
			'relation_module' => $revparams['relation_module'],
			'relation_id' => $revparams['relation_id'],
			'created_by'=> $this->session->usr_id,
			'created_on'=> date('Y-m-d H:i:s')
		));
		return true;
	}
	
	function get_revision_by_id($id, $module) {
		$this->db->select( 'staff.id as staff_id,staff.staffname as staffmembername, staff.staffavatar as staffimage, revisions.created_on as createddate,revisions.relation_id, revisions.relation_module' );
		$this->db->join( 'staff', 'revisions.created_by = staff.id', 'left' );
		$this->db->order_by( "revisions.created_on", "asc" );
		$rev_result = $this->db->get_where('revisions', array('revisions.relation_id' => $id, 'revisions.relation_module'=>$module))->result_array();
		return $rev_result;
	}
}