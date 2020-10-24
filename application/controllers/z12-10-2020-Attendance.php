<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Attendance extends CIUIS_Controller {

	public function  __construct() {
        parent::__construct();
        $this->load->model("Attendance_Model");
		$this->load->model("Settings_Model");
		$this->load->model("Staff_Model");
        $this->load->helper('security');     
    }

	function index($val="",$sts="") {
		$data[ 'title' ] = lang( 'Attendance' );
		$current_date = date('Y-m-d');
			$path = $this->uri->segment( 3 );
		//print_r($path);
		
		$data[ 'departments' ] = $this->Settings_Model->get_departments();
		$data[ 'staff' ] = $this->Settings_Model->get_departments();
		$data['allstaff']= $this->Staff_Model->get_all_staff_new();
		$data['attendance'] = $this->Attendance_Model->get_attendance($current_date);
		 if($path == 2){
	     
	     $data['attendance_date'] = date('Y-m-d', strtotime('-1 days', strtotime($current_date)));
	 }else if($path == 3){
		 $startdate= date("Y-m-d", strtotime("last week friday"));

		$enddate= date("Y-m-d", strtotime("this friday"));
		 
	 }else if($path == 4)
	 {
		  $startdate= date("Y-m-01");

		 $enddate=  date('Y-m-t');
		
		
	 }
	    else{
	      	$data['attendance_date'] = $current_date;
	       
	    }
	
		//$data['attend_details'] = $this->Attendance_Model->get_current_attendance_timings($data['attendance_date']);
		//	print_r($data['attend_details']); die;
		if ( $this->Privileges_Model->check_privilege( 'attendance', 'all' ) ) {
			$staffid='';
		}else{
			$staffid=$this->session->userdata( 'usr_id' );
		}
		
		if($path == 3 || $path == 4){
			$data['attend_details'] = $this->Attendance_Model->get_filter_attendance_log($startdate,$enddate,'',$staffid);
		}else{
		
		$data['attend_details'] = $this->Attendance_Model->get_current_attendance_log($data['attendance_date'],$staffid);
		}
$data['val']=$val;
$data['newstatus']=$sts;
		//echo "<pre>";
			//print_r($data['attend_details']);exit;
			
			$this->load->view( 'attendance/index', $data );
	} 
	
	public function search_details(){
	//echo '<pre>'; print_r($_POST); die;
	$month = $this->input->post('month');
	$from_date = $this->input->post('from_date');
	$to_date = $this->input->post('to_date');
	
	$deps = $this->input->post('depts');
	$dep = implode(',',$deps);
	$emps = $this->input->post('emps');
	$emp = implode(',',$emps);
	$i = 1;
	$degrees = array();
	for($i==1;$i<=31;$i++){
		$dayy = 'day_'.(int)$i;
	$attends_details[] = $this->Attendance_Model->get_attend_details($from_date,$to_date,$dep,$emp,$dayy,$month);
	}
	 foreach($attends_details as $details){
		 if(!empty($details)){
	$data['attend_details'] = $details;
		 }
		
	 }
	//print_r($data['attend_details']); die;
	$this->load->view( 'attendance/index', $data );
	
}

public function filter_attendance($indeses='')
{
	
	
	$month = $this->input->post('month');
	 $from_date1 = $this->input->post('from_date');
	 if(!empty($from_date1 )){
	  $fdate = str_replace('/', '-', $from_date1);  
	$from_date =date("Y-m-d",strtotime($fdate));
	
	 }
	  
	$to_date1 = $this->input->post('to_date');
	if(!empty($to_date1 )){
	$tdate = str_replace('/', '-', $to_date1);  
	  
	$to_date =date("Y-m-d",strtotime($tdate));
	}
	$data['month'] = $month;
	$data['from_date'] = $from_date;
	$data['to_date'] = $to_date;

	$deps = $this->input->post('depts');
	$dep = implode(',',$deps);
	$data['dep'] = $dep; 
	 $emps = $this->input->post('emps');
	
	 $emp = implode(',',$emps);
	$data['emp'] = $emp;
	if(!empty($indeses)){
		$data['selectedemp']=$emps;
		
		$data['todate']=$to_date1;
	$data['action']=$indeses;
	}
	
		$data['allstaff']= $this->Staff_Model->get_all_staff_new();
	$data['attend_details'] = $this->Attendance_Model->get_filter_attendance_log($from_date,$to_date,$dep,$emp,$month);
	//echo "<pre>";
		//print_r($data['attend_details']);exit;
		$this->load->view( 'attendance/index', $data );
	
}
public function search_atten(){
	$departments = $this->Settings_Model->get_departments();
		$staff = $this->Staff_Model->get_all_staff();
 echo '<form id="form1" method="post" action="'.base_url().'attendance/filter_attendance">';
     
		 echo '<div class="row"><div class="form-group">
                  <label class="control-label col-sm-4" for="email"> <b>From Date</b></label>

                  <div class="col-sm-7">
                    <input type="text" class="form-control newdatepicker" name="from_date" id="from_date" placeholder="From Date" autocomplete="off"  >
                  </div>
                </div></div><br></br>';
		echo '<div class="row"><div class="form-group">
                  <label class="control-label col-sm-4" for="email"> <b>To Date</b></label>

                  <div class="col-sm-7">
                    <input type="text" class="form-control newdatepicker" name="to_date" id="to_date" placeholder="To date" autocomplete="off"  >
                  </div>
                </div></div><br></br>';

echo '<div class="row" id="emp"><div class="form-group col-md-12"><label class="control-label col-md-4" for="email"><b>Employees</b></label><select multiple class="full-width" ui-select2="groupSetup" data-placeholder="Select Employee" >';
echo '<option value="0">All Employees</option>';
if(isset($staff)){
	foreach($staff as $stf){
		echo '<option value='.$stf[id].'>'.$stf[staffname].'</option>';
	}
		
}
echo '</select></div></div><br></br>';				
echo ' <input type="submit" class="btn btn-success col-md-12"  value="Search">';				
echo '</form>';		
}

	// export xlsx|xls file
    public function atten_excel() {
          $this->load->library('excel');
		  $this->load->library('IOFactory');
    
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $month = $this->input->post('month');
    $dep = $this->input->post('dep');
    $emp = $this->input->post('emp');
    $from_date1 = date('d-m-Y',strtotime($from_date));
    $to_date1 = date('d-m-Y',strtotime($to_date));
    
	$staff = $this->Attendance_Model->get_attend_details($from_date,$to_date,$dep,$emp,$month);
		 	
  //$this->load->library("excel");
  $object = new PHPExcel();

  $object->setActiveSheetIndex(0);

 // $table_columns = array("S.No", "First Name", "Last Name", "Email", "Phone Number", "Course", "Register No", "Address", "Pincode");

  $column = 0;
$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, 'Attendance Report');
$object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'From Date:'.'-'.$from_date1);
$object->getActiveSheet()->setCellValueByColumnAndRow(4, 2, 'To Date:'.'-'.$to_date1);

$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Employee');

$column = 1;
 $start_date = 1;
                            $lastDate = date("t", strtotime($to_date));
                            $current_date = date('d');
                            
                            
                             if($start_date){

                                for ($i=1; $i <= $lastDate ; $i++) { 
                                    $day = date("d",strtotime(date('Y-m-'.$i)));  
                                   $month =  date("D",strtotime(date('Y-m-'.$i)));
    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 3, $day.'-'.$month);
   $column++;
                                    
                                }
                                
                             }

 
  //$customers_data = $this->CustomersModel->get_all_customers();

  $excel_row = 4;
    
  foreach($staff as $row)
  {
   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['staffname']);
   $col = 1;
   for ($i=1; $i <= $lastDate ; $i++) { 

                                 
                                  $status=$row['day_'.(int)$i];
                                  if(!empty($status)){
                                      
                                      $stat = $status;
                                  }else{
                                      
                                      $stat = 'A';
                                  }
 $object->getActiveSheet()->setCellValueByColumnAndRow($col, $excel_row, $stat);
   $col++;
   }
        
   $excel_row++;
   
   
  } 

  
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Attendance Report.xls"');
   header('Cache-Control: max-age=0'); 
  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
 // ob_end_clean();

  $object_writer->save('php://output');
  
  
}

function download_pdf(){
    
    //load mPDF library
	
		
     $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $month = $this->input->post('month');
    $dep = $this->input->post('dep');
    $emp = $this->input->post('emp');
    $from_date1 = date('d-m-Y',strtotime($from_date));
    $to_date1 = date('d-m-Y',strtotime($to_date));
    
    $data['from_date'] = $from_date;
    $data['to_date'] = $to_date;
    $data['month'] = $month;
    
    	//now pass the data//
	$data['staff'] = $this->Attendance_Model->get_attend_details($from_date,$to_date,$dep,$emp,$month);
	
	//	$this->load->view( 'attendance/month', $data );
			
	$html=$this->load->view('attendance/pdf',$data, true); //load the pdf.php by passing our data and get all data in $html varriable.
	
	//print_r($html); die;
		$pdfFilePath ="Attendance-".time().".pdf";	
		ob_clean();
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $pdfFilePath . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
		
	$this->load->library('m_pdf'); 
		//actually, you can pass mPDF parameter on this load() function
		//$pdf = $this->m_pdf->load();
		
	
		$pdf = new m_pdf('utf-8','A4');
			
		//generate the PDF!
		$stylesheet = '<style>'.file_get_contents('assets/css/bootstrap.min.css').'</style>';
	//print_r($html); die;
		// apply external css
		//$pdf->WriteHTML($stylesheet,1);
			
		$pdf->WriteHTML($html);
	//print_r('323');  die;
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		
		



		$pdf->Output($pdfFilePath, "D");
		ob_end_flush();

		exit;
    
    
    
    
   
}
	function month() {
		$data[ 'title' ] = lang( 'Attendance Report' );
	/* 	$current_date = date('Y-m-d');
		$data['attendance_date'] = $current_date; */
		$data['staff'] = $this->Attendance_Model->get_all_staff(); 
		$month = $this->input->post('month');
	$from_date = $this->input->post('from_date');
	echo $from_date; 
//	$to_date = $this->input->post('to_date');
$from_date = '2020-07-01';
$to_date = '2020-07-31';
		//echo '<pre>'; print_r($_POST); die;
	$data['month'] = $month;
	$data['from_date'] = $from_date;
	$data['to_date'] = $to_date;

	$deps = $this->input->post('depts');
	$dep = implode(',',$deps);
	$data['dep'] = $dep; 
	$emps = $this->input->post('emps');
//	print_r($emps); 
	$emp = implode(',',$emps);
	$data['emp'] = $emp;
	//print_r($emp); die;
//	$data['staff'] = $this->Attendance_Model->get_attend_details($from_date,$to_date,$dep,$emp,$month);
		$data['attend_details'] = $this->Attendance_Model->get_report_attendance_log($from_date,$to_date);
		$this->load->view('attendance/month', $data );
	} 
	function get_employees()
{
	$deps = $this->input->post('deps');
	//print_r($deps);
	if($deps != ''){
	$depts = implode(',',$deps);
	
	
	$employees = $this->Staff_Model->get_department_staff($depts);
	 echo '<label for="employees">Employees</label>';
	echo "<select class='form-control emps' id='employee_id' multiple name='emps[]' onchange='select_employee(this.value)'>";
	echo '<option value="0">All Employees</option>';
	if(isset($employees)){
		foreach($employees as $emp){
			echo '<option value= '.$emp['id'].'>'.$emp[staffname].'</option>';
		}
		
	}
	echo "</select>";
	}else{
		 echo '<label for="employees">Employees</label>';
	echo "<select class='form-control' id='employee_id' multiple name='employee_id[]'>";
	//if(isset($employees)){
		//foreach($employees as $emp){
			//echo '<option value= '.$emp['id'].'>'.$emp[staffname].'</option>';
		//}
		
	//}
	echo "</select>";
	}
}

	public function create_attendance()
	{
		$employees=array();
		$alldepartment=$this->input->post('department');
		$attendance_date=$this->input->post('attendance_date');
		if(!empty($alldepartment)){
			foreach($alldepartment as $eachdept){
				
				$data['department_id'] = $eachdept;
				$data['attendance_date'] = $attendance_date;
				$employees[] = $this->Staff_Model->get_staff_department_wise($data['department_id']);
				$attendance[] = $this->Attendance_Model->get_attendance_details($data['department_id'],$data['attendance_date']);
				$attendance_timings[] = $this->Attendance_Model->get_attendance_timings($data['department_id'],$data['attendance_date']);
				$employee_ot_hours[] = $this->Attendance_Model->get_ot_hours($data['department_id'],$data['attendance_date']);
		
		
			}
		}
		
		$data['employees']=$employees;
		$data['attendance']=$attendance;
		$data['attendance_timings']=$attendance_timings;
		$data['employee_ot_hours']=$employee_ot_hours;
		$data['title']="Attendance Entry";
        $this->load->view( 'attendance/create', $data );
	}

   	public function create() {
   	    
		$data[ 'departments' ] = $this->Settings_Model->get_departments();
		if(isset($_GET['id'])){
		    
		    $attendance_date = strtotime($_GET['date']);
					$month = date("m", $attendance_date);
					$day = date("d", $attendance_date);
					$year = date("Y",$attendance_date);
			
		$data['department_id'] = $_GET['id'];
		$data['depid'] = explode(',',$_GET['id']);
		$data['attendance_date'] = $_GET['date'];
		$newdep=explode(',',$data['department_id']);
		$depid='';
		foreach($newdep as $eachdep){
			$depid.="'".$eachdep."'".',';
		}
		$data['department_id']= rtrim($depid,',');
		$data['employees'] = $this->Staff_Model->get_staff_multi_department_wise($data['department_id']);
		$data['attendance'] = $this->Attendance_Model->get_attendance_details_multi($data['department_id'],$data['attendance_date'],$month,$year);
			$data['attendance_timings'] = $this->Attendance_Model->get_attendance_timings_multi($data['department_id'],$data['attendance_date']);
			$data['employee_ot_hours'] = $this->Attendance_Model->get_ot_hours($data['department_id'],$data['attendance_date']);
		
		}else{
			$data['department_id'] = '';
			$data['employees'] = '';
			$data['depid'] =array();
		}
    	if($this->input->server("REQUEST_METHOD")=="POST"){ 
		
	
					$data = $this->input->post() ;
					
					$attendance_date = strtotime($_POST['attendance_date']);
					$month = date("m", $attendance_date);
					 $day = date("d", $attendance_date);
					$year = date("Y",$attendance_date);
					
		$sstf_timings = $this->input->post('staff');
				
		$selected=$_POST['selected'];
		$departmentid=$this->input->post('departmentid');
		if(count($selected)>0){
		for($t=0;$t<count($selected);$t++){
			
			$clock_in = explode(":",$sstf_timings[$selected[$t]]['clock_in']);
						$clock_out = explode(":",$sstf_timings[$selected[$t]]['clock_out']);
				if((!empty($sstf_timings[$selected[$t]]['clock_in'])) ||( !empty($sstf_timings[$selected[$t]]['clock_out'])))	{	
		$params = array(
						'day_'.(int)$day => 'P',
						'staff_id' => $selected[$t],
						'attendance_date' => $_POST['attendance_date'],
						'department' => $departmentid[$t],
						'month' => (int)$month,
						'year' => $year
						
						);		
					
			
						$this->Attendance_Model->save($params);
						
						
						
						if(!empty($clock_in[0])){
							$hr=$clock_in[0];
						}else{
							$hr='00';
						}
						
						if(!empty($clock_in[1])){
							$min=$clock_in[1];
						}else{
							$min='00';
						}
						
						if(!empty($sstf_timings[$selected[$t]]['clock_in'])){
							$clockin=$sstf_timings[$selected[$t]]['clock_in'];
						}else{
							$clockin='00:00:00';
						}
						
					    $inparams = array(
					            'day'=> (int)$day,
						'empl_id' => $selected[$t],						
						'month' => (int)$month,
						'year' => $year,
						'hour'=>$hr,
						'min'=>$min,
						'sec'=>'00',
						'type'=>'in',
						'time'=>$clockin,
						'punch_date'=>date('Y-m-d', strtotime($_POST['attendance_date']))
						
					        
					        );
					       
					      $this->db->insert('attendance_log', $inparams); 
								
								
								if(!empty($clock_out[0])){
							$outhr=$clock_out[0];
						}else{
							$outhr='00';
						}
						
						if(!empty($clock_out[1])){
							$outmin=$clock_out[1];
						}else{
							$outmin='00';
						}
						if(!empty($sstf_timings[$selected[$t]]['clock_out'])){
							$clockout=$sstf_timings[$selected[$t]]['clock_out'];
						}else{
							$clockout='00:00:00';
						}
						
						
								$outparams = array(
					            'day'=> (int)$day,
						'empl_id' => $selected[$t],						
						'month' => (int)$month,
						'year' => $year,
						'hour'=>$outhr,
						'min'=>$outmin,
						'sec'=>'00',
						'type'=>'out',
						'time'=>$clockout,
						'punch_date'=>date('Y-m-d', strtotime($_POST['attendance_date']))
					        
					        );
												      
							$this->db->insert('attendance_log', $outparams); 
				}
							
		}
		$this->session->set_flashdata('message', 'Successfully Created');
					redirect('attendance', 'refresh');
		}else{
			$this->session->set_flashdata('message', 'Please Select Atleast One employee');
					redirect('attendance/create', 'refresh');
		}

        }
     	$data['title']="Attendance Entry";
        $this->load->view( 'attendance/create', $data );
        
    }
    public function summary(){
        $data['department']= $department = $this->input->post('department');
		
        $data['date_from']=$from_date = $this->input->post('from_date');
        $data['date_to']=$to_date = $this->input->post('to_date'); 
		
		$data['attn_details'] = $this->Attendance_Model->getmonthlyattendance_new($department); 
        //$data['attn_details'] = $this->Attendance_Model->getmonthlyattendance_new($department,$from_date,$to_date);
        //$data['attn_timings'] = $this->Attendance_Model->getmonthlytimings($department,$from_date,$to_date);
        
        
    
     $this->load->view('attendance/summary',$data);   
    }
	
	public function emp_list($filter_type){
	 
	 if($filter_type == 1){
	     $filter_date = date('Y-m-d');
	 }
	    else{
	        $date = date('Y-m-d');
	       $filter_date = date('Y-m-d', strtotime('-1 days', strtotime($date)));
	       
	    }
	        $data['filter_date'] = $filter_date;
	    	$data['attend_details'] = $this->Attendance_Model->get_current_attendance_timings($filter_date);
	    	 $this->load->view('attendance/atten_list',$data);   
	
	}
	function change_time()
	{
		
		$diff= $this->Attendance_Model->get_time_difference($_POST['changetime'], $_POST['exacttime']);
		if($_POST['changetime']<$_POST['exacttime']){
			echo '-'.$diff;
		}else{
			echo $diff;
		}
	}
    
	function report() {
		$currdate = date("Y-m-d");
		$startDt = date('Y-m-d', strtotime('-10 days', strtotime($currdate)));
		$endDt = date('Y-m-d', strtotime('-1 days', strtotime($currdate)));
		$users = $this->Attendance_Model->get_staff();
		$getalluserIDs = array_column($users,'id');
		$userids = implode(",",$getalluserIDs);
		$sdata = $this->Attendance_Model->get_attendance_report($currdate, $currdate, $userids);
		foreach($sdata as $eachData) {
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['PunchInTime'] = $eachData['MinInTime']!= '0:00:00' ? date('h:i a', strtotime($eachData['MinInTime'])) : '';
			
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['Instatus'] = $eachData['MinInTime'] == "0:00:01" ? "<strong style='color:red'>Continue</strong>" : '';
			
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['PunchOutTime'] = $eachData['MaxOutTime'] != '0:00:00' ? date('h:i a', strtotime($eachData['MaxOutTime'])) : '';
			
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['Outstatus'] = $eachData['MaxOutTime'] == "23:59:59" ? "<strong style='color:red'>Continue</strong>" : '';
			
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['Date'] = date('d M Y', strtotime($eachData['AttDate']));
			$timeData = $eachData['MaxOutTime'] > $eachData['MinInTime'] ? $this->differenceInHours($eachData['MaxOutTime'],$eachData['MinInTime']) : $this->differenceInHours($eachData['MinInTime'],$eachData['MaxOutTime']);
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['WorkingHours'] = $timeData['working_hrs'];
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['Status'] = $timeData['flag'];
			$finalData[$eachData['EmployeeName']][$eachData['AttDate']]['OTHours'] = $timeData['OT_hrs'];
		}
		$data['finalData']=$finalData;
		$this->load->view('attendance/report',$data);
	}
	
	function differenceInHours($starttime,$endtime){
		$data = array();
		$starttimestamp = strtotime($starttime);
		$endtimestamp = strtotime($endtime);
		$totalMins = abs($endtimestamp - $starttimestamp)/60;
		$totworkingMins = ($totalMins > 600) ? 480 : $totalMins;
		$totOtMins = $totalMins > 600 ? ($totalMins - 480) : 0;
		$workingHrs = floor($totworkingMins/60);
		$OTHrs = floor($totOtMins/60);
		$workingMins = $totworkingMins%60;
		$OTMins = $totOtMins%60;
		
		$data['hrs'] = floor(abs($endtimestamp - $starttimestamp)/3600);
		$data['min'] = $totalMins%60;
		$data['flag'] = $data['hrs'] > 0 ? 'Present' : '';
		$data['time'] =  $data['hrs'].' hrs '.$data['min']. ' min';
		//$data['working_hrs'] = $workingHrs. ' hrs '.$workingMins. ' mins';
		//$data['OT_hrs'] = $OTHrs. ' hrs '.$OTMins. ' mins';
		$data['working_hrs'] = $workingHrs;
		$data['OT_hrs'] = $OTHrs;
		return $data;
		//return $hrs.' hrs '.$min. ' min';
	}
}