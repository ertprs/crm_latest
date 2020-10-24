<?php
class Approvals_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function getallapprovals() {
		$this->db->select('approvals.option,approvals.created_on,permissions.permission,approvals.permissions_id as id,approvals.status as status');
		$this->db->from( 'approvals' );
		$this->db->join('permissions',"permissions.id = approvals.permissions_id");
		$this->db->group_by('approvals.permissions_id'); 
		$this->db->order_by('approvals.created_on', 'desc');
		return $this->db->get()->result();
	}

	function create($params){
		$this->db->select('id');
		$response = $this->db->get_where( 'approvals', array( 'permissions_id' => $params['module']) )->result_array();
		if(sizeof($response) > 0){
			$newArr=array_column($params['approvaluser'],'approveid');
			$presentArr=array_column($response, 'id');
			$extArr=array_diff($presentArr,$newArr);
			if(sizeof($extArr) > 0){
				$this->db->where_in('id', $extArr);
				$this->db->delete('approvals');
			}
			$status=$this->insertApproval($params);
		}else{
			$status=$this->insertApproval($params);
		}
		return $status;
	}

	function insertApproval($params){
		if(sizeof($params['approvaluser'] > 0)){
			$level = 0;
			foreach($params['approvaluser'] as $eachapproval){
				if($eachapproval[ 'approvename'] !=''){
					if($eachapproval['approveid'] !=''){
						$updatedata = array(
						'permissions_id' =>$params['module'],
						'option' => $params['option'],
						'approverid' => $eachapproval[ 'approvename' ],
						'approverlevel' =>($params['option'] =='level' ? ++$level : '0'),
						'approveprice' =>($params['option'] =='price' ? $eachapproval[ 'approveprice'] : '0:00'),
						'created_on' =>date('Y-m-d H:i:s'),
						'created_by'=>$this->session->usr_id,
						);
						$this->db->where('id', $eachapproval['approveid']);
						$this->db->update('approvals', $updatedata);
						
					}else{
						$this->db->insert('approvals', array(
						'permissions_id' =>$params['module'],
						'option' => $params['option'],
						'approverid' => $eachapproval[ 'approvename' ],
						'approverlevel' =>($params['option'] =='level' ?  $level++ : '0'),
						'approveprice' =>($params['option'] =='price' ? $eachapproval[ 'approveprice'] : '0:00'),
						'created_on' =>date('Y-m-d H:i:s'),
						'created_by'=>$this->session->usr_id,
						) );
					}
				}
			}
			return true;
		}else{
			return false;
		}
	}
	
	function getapprovalsByType($type) {
		$staff_id = $this->session->usr_id;
		$approvalsTypeData=array();
		$this->db->select('MAX(approvals.approverlevel) as maxapproverlevel,approvals.option,approvals.id,approvals.approverid,approvals.approverlevel,approvals.approveprice,permissions.key');
		$this->db->from( 'approvals' );
		$this->db->join('permissions',"permissions.id = approvals.permissions_id");
		$array = array('permissions.key' => $type, 'permissions.approval_req' => '1', 'approvals.status' =>'Active');
		$this->db->where($array);
		$this->db->order_by('approvals.approverlevel', 'asc');
		$result= $this->db->get()->result();
		
		if(sizeof($result) > 0){
			foreach($result as $eachapprovals){
				$approvalsTypeData['option']=$eachapprovals->option;
				$approvalsTypeData['maxapproverlevel']=$eachapprovals->maxapproverlevel;
				$approvalsTypeData['data'][]=$eachapprovals;
			}
			
		}else{
			$approvalsTypeData['option']='';
			$approvalsTypeData['maxapproverlevel']='';
			$approvalsTypeData['data']=array();
		}
		return $approvalsTypeData;
	}
	
	
}