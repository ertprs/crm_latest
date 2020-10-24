<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Salesoverview extends CIUIS_Controller
{

	function __construct()
	{
		parent::__construct();
		$path = $this->uri->segment(1);
		$this->load->model('Customers_Model');
		$this->load->model('Sales_Model');
	}

	function index()
	{
		$data['title'] = lang('staff');
		$data['staff'] =  $this->Customers_Model->get_all_salesstaffamount('16');
		$data['customer'] = $this->Customers_Model->get_all_customerstotalinvoice();
		$data['saledata'] = $this->Sales_Model->get_allsalestargetdata();
		$this->load->view('salesoverview/index', $data);
	}

	function get_all_customers()
	{
		$staff_uid = 	$this->input->post('staff_uid');
		if ($staff_uid == "") {
			$customers = $this->Customers_Model->get_all_customerstotalinvoice();
		} else {
			$customers = $this->Customers_Model->get_all_custinvoicebystaff($staff_uid);
		}
		echo json_encode($customers);
	}

	function get_all_salesoverview()
	{
		$i = 0;
		$salesarray =  array();
		$salesarray[] = array('Months', 'Achieved', 'Target');
		$month	 = date('F');
		$months = ["1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May","6"=> "June","7"=> "July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"];
		$staff_uid = 	$this->input->post('staff_uid');
		if ($staff_uid == "") {
			$sales_invoice = $this->Customers_Model->get_all_salesdatainvoice();
			$monthly_target = $this->Sales_Model->get_company_monthlysales();
		} else {
			$sales_invoice = $this->Customers_Model->get_all_salesdatainvoicebystaff($staff_uid);
			$monthly_target = $this->Sales_Model->get_company_monthlysalesforstaff($staff_uid);
		}
		if (!empty($sales_invoice)) {
			$i = 0;
			$existingmonths = array_column($sales_invoice, 'months');
			foreach($months as $key=>$eachmonth) {
				if(!in_array($eachmonth, $existingmonths)) {
					$sales_invoice[] = array('monthnumber'=>$key, 'months'=>$eachmonth, 'total'=> 0);
				}
			}
			array_multisort( array_column($sales_invoice, "monthnumber"), SORT_ASC, $sales_invoice );
			
			foreach ($sales_invoice as $row) {
				$salesarray[] = array($row["months"], intval($row["total"]), intval($monthly_target[0]["company_monthtarget"]));
				if ($row["months"] == $month) {
					break;
				}
			}
		} else {
			foreach($months as $key=>$eachmonth) {
				if(!in_array($eachmonth, $existingmonths)) {
					//$sales_invoice[] = array('monthnumber'=>$key, 'months'=>$eachmonth, 'total'=> 0);
					$salesarray[] = array($eachmonth, 0, 0);
				}
			}
		}
		
		echo json_encode($salesarray);
	}

	function addsalestarget()
	{
		$sales_uid = $this->Sales_Model->salestarget_add();
		echo json_encode($sales_uid);
	}

	function editsalestarget()
	{
		$salestarget_uid =  $this->input->post('salestarget_id');
		$sales_data = $this->Sales_Model->get_salestargetdata($salestarget_uid);
		echo json_encode($sales_data);
	}
	
	function updatesalestarget(){
		$OverviewId=$this->input->post('OverviewId');
		$edit_salesperQ1=$this->input->post('edit_salesperQ1');
		$edit_salesperQ2=$this->input->post('edit_salesperQ2');
		$edit_salesperQ3=$this->input->post('edit_salesperQ3');
		$edit_salesperQ4=$this->input->post('edit_salesperQ4');
		$response=$this->db->where( 'id', $OverviewId )->update( 'salestarget', array( 'qtr1' =>$edit_salesperQ1,'qtr2' =>$edit_salesperQ2,'qtr3' =>$edit_salesperQ3,'qtr4' =>$edit_salesperQ4));
		echo json_encode($response);
	}
	
	function get_sales_data() {
		$passyear=$this->input->post('passyear');
		$saledata = $this->Sales_Model->get_allsalestargetdata($passyear);
		$salesarr['result'] = '';
		$salesarr['result'] .= '<input id="is_updatesalesid" type="hidden" value="" /><table class="table table-striped table-hover compact hover table-bordered nowrap table-responsive" style="text-align:center;" width="100%" id="view_allsalestarget"><thead><tr><td style="width: 20%;">Sales person</td><td>Q1</td><td>Q2</td><td>Q3</td><td>Q4</td><td>Edit</td></tr></thead><tbody id="sales_overview_tbody">';
			if (isset($saledata) && sizeof($saledata) > 0) {
			foreach ($saledata as $row) {
				$salesarr['result'] .= '<tr><td style="width: 20%;">' . $row["staffname"] . '</td><td>' . $row["qtr1"] . '</td><td>' . $row["qtr2"] . '</td><td>' . $row["qtr3"] . '</td><td>' . $row["qtr4"] . '</td>	<td><button  onclick ="editsalestarget('.$row["salestarget_id"] . ')">Edit</button></td></tr>';
				
				$salesdatauser[] = $row["id"];
			}
		} else {
			$salesarr['result'] .= '<tr><td style="width: 20%;" colspan="6">No Data Found</td></tr>';
		}
		$salesarr['result'] .= '</tbody></table>';
		$salesuser = $this->Customers_Model->get_all_salesstaffamount('16');
		$salesarr['staff'] = '<option value="0">-Select Sale person-</option>';
		
		if (isset($salesuser)) {
			foreach ($salesuser as $eachsalesperson) {
				if(!in_array($eachsalesperson["id"], $salesdatauser)) {
					$salesarr['staff'] .= '<option value="'. $eachsalesperson["id"] . '">' . $eachsalesperson["staffname"] . '</option>';	
				}
			}
		}
		echo json_encode($salesarr);
	}

	function get_companymetredata()
	{
		$salesarray =  array();
		$totalquaterly = 0;
		$currYear = date('Y');
		$quarter_target = $this->Sales_Model->get_companytargetquaterly($currYear);
		$totalinvoice = $this->Sales_Model->get_companytotaltargetachived();
		if (!empty($quarter_target)) {
			foreach ($quarter_target as $row) {
				$quater1 = $row["qtr1"];
				$quater2 = $row["qtr2"];
				$quater3 = $row["qtr3"];
				$quater4 = $row["qtr4"];
				$totalquaterly =  $row["total_amount"];
			}
		}
		
		$Q1  = intval($quater1);
		$Q2  = $Q1 + $quater2;
		$Q3  = $Q2 + $quater3;
		$Q4  = $Q3 + $quater4;
		
		/*$salesarray[] =  array("minvalue" => 0, "maxvalue" => $Q1, "code" => "#F2726F");
		$salesarray[] =  array("minvalue" => $Q1, "maxvalue" => $Q2, "code" => "#F2728F");
		$salesarray[] =  array("minvalue" => $Q2, "maxvalue" => $Q3, "code" => "#FFC533");
		$salesarray[] =  array("minvalue" => $Q3, "maxvalue" => $Q4, "code" => "#62B58F");*/
		//echo json_encode(array("sales" => $salesarray, "upperlimit" => $totalquaterly, "total_targetachived" => $total_targetachived[0]["total_targetachived"]));
		
		$Q1perday = $currYear/4 == 0 ? intval($Q1/91) : intval($Q1/90);
		$Q2perday = intval($Q2/91);
		$Q3perday = intval($Q3/92);
		$Q4perday = intval($Q4/92);
		
		$currentmonth = date("n");
		$currentdatequarter = ceil($currentmonth / 3);
		//$daysincurrqtrelapsed = DATEDIFF('day',DATETRUNC('quarter',today()),today());
		
		$current_month = date('m');

          if($current_month>=1 && $current_month<=3)
          {
            $curr_qtr_start_date = date('Y-m-d', strtotime('1-01-'.($currYear-1)));
          } 
          else if($current_month>=4 && $current_month<=6)
          {
            $curr_qtr_start_date = date('Y-m-d', strtotime('1-04-'.$currYear));
          }
          else  if($current_month>=7 && $current_month<=9)
          {
            $curr_qtr_start_date = date('Y-m-d', strtotime('1-07-'.$currYear));
          }
          else  if($current_month>=10 && $current_month<=12)
          {
            $curr_qtr_start_date = date('Y-m-d', strtotime('1-10-'.$currYear));
          }
		
		$currQtrDateDiff = $this->dateDiffInDays(date("Y-m-d H:i:s"), $curr_qtr_start_date);
		/*echo $currentdatequarter; 
		echo '<br>';
		echo $curr_qtr_start_date; 
		echo '<br>';
		echo '<br>';
		echo $currQtrDateDiff;
		*/
		
		if($currentdatequarter == 1) {
			$targetachieved = intval($Q1);
		} else if($currentdatequarter == 2) {
			$targetachieved = intval($Q1 + (currQtrDateDiff* $Q2));
		} else if($currentdatequarter == 3) {
			$targetachieved = intval($Q1 + $Q2 + (currQtrDateDiff* $Q3));
		} else if($currentdatequarter == 4) {
			$targetachieved = intval($Q1 + $Q2 + $Q3 + (currQtrDateDiff* $Q4perday));
		}
		
		//$exactinvoice = $totalquaterly/$totalinvoice[0]["total_targetachived"];
		
		echo json_encode(array("salesq1" => $Q1,"salesq2" => $Q2,"salesq3" => $Q3,"salesq4" => $Q4, "upperlimit" => $totalquaterly, "totalinvoice" => $totalinvoice[0]["total_targetachived"], "targetachieved" => $targetachieved, "exactinvoice"=>$exactinvoice));
	}
	
	function dateDiffInDays($date1, $date2) { 
		$diff = strtotime($date2) - strtotime($date1);
		return abs(round($diff / 86400)); 
	} 
}
