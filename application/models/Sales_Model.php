<?php
class Sales_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	// Get sales by id
	function get_sales( $id ) {
		return $this->db->get_where( 'sales', array( 'id' => $id ) )->row_array();
	}

	// Get all sales
	function get_all_sales() {
		return $this->db->get( 'sales' )->result_array();
	}

	// Function to add new sales
	function add_sales( $params ) {
		$this->db->insert( 'sales', $params );
		return $this->db->insert_id();
	}

	// Function to update sales
	function update_sales( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'sales', $params );
	}

	// Function to delete sales
	function delete_sales( $id ) {
		$response = $this->db->delete( 'sales', array( 'id' => $id ) );
	}
	// function of adding sales targert
	function salestarget_add() {
		$items = $this->input->post( 'items', TRUE );
		$passyear = $this->input->post( 'passyear', TRUE );
		$i = 0;
		foreach ( $items as $item ) {
			$this->db->replace( 'salestarget', array(
				'user_id' => $item[ 'sale_peruid' ],
				'qtr1' => $item[ 'q1amount' ],
				'qtr2' => $item[ 'q2amount' ],
				'qtr3' => $item[ 'q3amount' ],
				'qtr4' => $item[ 'q4amount' ],
				'year'=>$passyear,
				'status'=>1,
				'create_by'=>$this->session->usr_id,
			) );
		};
		$salesid = $this->db->insert_id();
		return $salesid;	

	}
	// get company total monthly target
	function get_company_monthlysales(){
		$sql = "SELECT  (sum(qtr1)+sum(qtr2) +sum(qtr3)+sum(qtr4))/4 as company_monthtarget  FROM salestarget;";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;

	}

	// get all sales tagrget data by uersr
	function get_allsalestargetdata($passyear=''){
		if($passyear !=''){
			$where = "salestarget.status=1 AND salestarget.year='".$passyear."'";
		}else{
			$where = "salestarget.status=1";
		}
		$this->db->select( '*,salestarget.id as salestarget_id');
		$this->db->from('salestarget');
		$this->db->join( 'staff', 'staff.id = salestarget.user_id','inner');
		$this->db->where($where);
		$result = $this->db->get()->result_array();
		return $result;
	}


	// edit mode of adding sales target	
	function get_salestargetdata($salestarget_id) {
		$ci =& get_instance();
		$ci->db->select( '*,salestarget.user_id as salesuser_id' );
		$ci->db->join( 'staff', 'staff.id = salestarget.user_id', 'inner' );
		$salestarget = $ci->db->get_where( 'salestarget', array( 'salestarget.id' => $salestarget_id ) )->row_array();
		$salestarget_data = array(
			'user_id' => $salestarget[ 'salesuser_id' ],
			'staffname' => $salestarget[ 'staffname' ],
			'qtr1' => $salestarget[ 'qtr1' ],
			'qtr2' => $salestarget[ 'qtr2' ],
			'qtr3' => $salestarget[ 'qtr3' ],
			'qtr4' => $salestarget[ 'qtr4' ],
			'year' => $salestarget[ 'year' ],
			
		);
		return $salestarget_data;
	}

	// get company quaterly data
	function get_companytargetquaterly($yr) {
		$sql = "SELECT  sum(qtr1)  as  qtr1 ,sum(qtr2) as qtr2 , sum(qtr3) as qtr3 , sum(qtr4) as qtr4  ,(sum(qtr1)+sum(qtr2) +sum(qtr3)+sum(qtr4)) as total_amount FROM salestarget where year = '$yr';";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;

	}
	// get company monthly sales satff
	function get_company_monthlysalesforstaff($staff_id){
		$sql = "SELECT  (sum(qtr1)+sum(qtr2) +sum(qtr3)+sum(qtr4))/4 as company_monthtarget  FROM salestarget where user_id = '$staff_id';";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;

	}
	// get company total target achived
	function get_companytotaltargetachived(){
		$sql = "SELECT (sum(total)) as total_targetachived  FROM invoices ;";
		$res = $this->db->query($sql);
		$result = $res->result_array();
		return $result;

	}
}