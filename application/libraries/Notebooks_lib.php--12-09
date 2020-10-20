<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );

class Notebooks_lib{

	public

	function __construct() {

		$this->CI = & get_instance();
		$this->CI->load->helper( 'url' );
		$this->CI->load->helper( 'form' );
		$this->CI->load->model( 'Notebooks_Model' );
		$this->CI->load->model( 'Privileges_Model' );
	}

	function getNoteBookList($searchdata='') {
		$notebooksData=array();
		$finaldata='';
		if($searchdata==''){
			if ( $this->CI->Privileges_Model->check_privilege( 'notebooks', 'all' ) ) {
			 $notebooksData= $this->CI->Notebooks_Model->get_all_notebooks();
			} else if( $this->CI->Privileges_Model->check_privilege( 'notebooks', 'own')){
				$notebooksData = $this->CI->Notebooks_Model->get_notebooks_by_userid($this->session->usr_id);
			} else {
				$notebooksData = array();
			}
		}else{
			if ( $this->CI->Privileges_Model->check_privilege( 'notebooks', 'all' ) ) {
			  $notebooksData= $this->CI->Notebooks_Model->get_all_notebooks_bysearch($searchdata,'1');
			} else if( $this->CI->Privileges_Model->check_privilege( 'notebooks', 'own')){
				$notebooksData = $this->CI->Notebooks_Model->get_all_notebooks_bysearch($searchdata,$this->session->usr_id);
			} else {
				$notebooksData = array();
			}
		}
		if(sizeof($notebooksData) > 0){
			foreach($notebooksData as $k => $result) {
				$notebookViewUrl=base_url('/notebooks/view/');
				$notebookdeleteUrl=base_url('/notebooks/delete/');
				$finaldata .='<tr class="select_row md-row">';
				$finaldata .='<td class="md-cell"><a href="'.$notebookViewUrl.$result['notebook_id'].'" class="link"><strong><span>'.$result['notebook_list'].'</span></strong></a><br></td>'; 
				$finaldata .='<td class="md-cell"><strong><span class="badge">'.date('d-M-Y',strtotime($result['created_date'])).'</span></strong></td>';
				$finaldata .='<td class="md-cell"><strong>'.$result['remarks'].'</strong></td>';
				$finaldata .='<td class="md-cell"><strong>'.$result['description'].'</strong></td>';
				$finaldata .='<td class="md-cell">';
				if (check_privilege('notebooks', 'delete') || $user_id == $result['created_by']) {
					$finaldata .='<a href="'.$notebookdeleteUrl.$result['notebook_id'].'" class="btn btn-danger" onclick="return confirm("Are you Sure to Delete")"><i class="fa fa-trash"></i></a>';
				}
				$finaldata .='</td></tr>';
			 }
		}else{
			$finaldata .='<tr><td class="md-cell" colspan="5">No Data Present</td></tr>';
		}
		echo $finaldata;
	}
}