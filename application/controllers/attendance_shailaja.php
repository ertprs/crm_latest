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

	function index() {
		$data[ 'title' ] = lang( 'staff' );
		$current_date = date('Y-m-d');
			$path = $this->uri->segment( 3 );
		//print_r($path);
		$data[ 'departments' ] = $this->Settings_Model->get_departments();
		$data[ 'staff' ] = $this->Settings_Model->get_departments();
		$data['attendance'] = $this->Attendance_Model->get_attendance($current_date);
		 if($path == 2){
	     
	     $data['attendance_date'] = date('Y-m-d', strtotime('-1 days', strtotime($current_date)));
	 }
	    else{
	      	$data['attendance_date'] = $current_date;
	       
	    }
	
		$data['attend_details'] = $this->Attendance_Model->get_current_attendance_timings($data['attendance_date']);
	//	print_r($data['attend_details']); die;
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
public function search_atten(){
	$departments = $this->Settings_Model->get_departments();
		$staff = $this->Staff_Model->get_all_staff();
 echo '<form id="form1" method="post" action="attendance/month">';
        echo '<div class="modal-header" ><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Filter</h4> </div>';
        echo '<hr></hr>';
        echo '<div class="row"><div class="form-group"><label class="control-label col-sm-4" for="email"><b>Month</b></label><select class="form-control" id="month" name="month">
        <option value="">Select Month</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
        
        </select></div></div><br></br>';
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
echo '<div class="row"><div class="form-group"><label class="control-label col-sm-4" for="email"><b>Departments</b></label><select class="form-control dep" name="depts[]" id="depts" multiple onchange="select_department(this.value)";>';
echo '<option value="0">All Departments</option>';
if(isset($departments)){
	foreach($departments as $dep){
		echo '<option value='.$dep[id].'>'.$dep[name].'</option>';
	}
		
}
echo '</select></div></div><br></br>';

echo '<div class="row" id="emp"><div class="form-group"><label class="control-label col-sm-4" for="email"><b>Employees</b></label><select class="form-control emps" name="emps[]" id="emps" multiple onchange="select_employee(this.value)";>';
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
		$data['attendance_date'] = $current_date;
		$data['staff'] = $this->Attendance_Model->get_staff(); */
		$month = $this->input->post('month');
	$from_date = $this->input->post('from_date');
	$to_date = $this->input->post('to_date');
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
	$data['staff'] = $this->Attendance_Model->get_attend_details($from_date,$to_date,$dep,$emp,$month);
	
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
						
						$data['employees'] = $this->Staff_Model->get_staff_multi_department_wise($data['department']);
					 
					foreach($data['employees'] as $k =>  $emp){
                        $attendance = $this->Attendance_Model->get_attendance_details_count($data['department'],$_POST['attendance_date'],$month,$year,$emp['id']);
				
			//	print_r($attendance['count']); die;
					if($attendance['count'] == 0){
						$params = array(
						'day_'.(int)$day => $this->input->post('staff_'.$emp['id']),
						'staff_id' => $emp['id'],
						'attendance_date' => $_POST['attendance_date'],
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
						
						);
					
			
							$this->Attendance_Model->save($params);
					}else{
					    
					    	$params = array(
						'day_'.(int)$day => $this->input->post('staff_'.$emp['id']),
						'staff_id' => $emp['id'],
						'attendance_date' => $this->input->post('attendance_date'),
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
						);
					
			
							$this->Attendance_Model->update_attendance($emp['id'],$params,$month,$year);
					    
					}
					}
				    	 
					foreach($data['employees'] as $k =>  $emp){
					
					 $attendance = $this->Attendance_Model->get_attendance_timing_details_count($data['department'],$_POST['attendance_date'],$month,$year,$emp['id']);
					if($attendance['count'] == 0){

					
						$sstf_timings = $this->input->post('staff');
				
						$timings = implode(',',$sstf_timings[$emp['id']]);
						
					    $params = array(
					            'day_'.(int)$day => $timings,
						'staff_id' => $emp['id'],
						'attendance_date' => $_POST['attendance_date'],
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
					        
					        );
					        
					        	$this->Attendance_Model->savetimings($params);
						
					}else{
					    
					    	$sstf_timings = $this->input->post('staff');
				
						$timings = implode(',',$sstf_timings[$emp['id']]);
						
					    $params = array(
					            'day_'.(int)$day => $timings,
						'staff_id' => $emp['id'],
						'attendance_date' => $this->input->post('attendance_date'),
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
					        
					        );
					        
					        	$this->Attendance_Model->updatetimings($emp['id'],$params,$month,$year);
						
			
					    
					}
					} 
					
					
					     foreach($data['employees'] as $k =>  $emp){
					 $attendance = $this->Attendance_Model->get_attendance_ot_details_count($data['department'],$_POST['attendance_date'],$month,$year,$emp['id']);
					if($attendance['count'] == 0){
						$params = array(
						'day_'.(int)$day => $this->input->post('ot_'.$emp['id']),
						'staff_id' => $emp['id'],
						'attendance_date' => $this->input->post('attendance_date'),
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
						);
					
			
							$this->Attendance_Model->saveothours($params);
					 
					 }else{
					     
					     $month = (int)$month;
						$params = array(
						'day_'.(int)$day => $this->input->post('ot_'.$emp['id']),
						'staff_id' => $emp['id'],
						'attendance_date' => $this->input->post('attendance_date'),
						'department' => $emp['department_id'],
						'month' => $month,
						'year' => $year
						);
					//print_r($params); die;
			
							$this->Attendance_Model->update_ot($emp['id'],$params,$month,$year); 
					} 
					 }
				
					$this->session->set_flashdata('message', 'Successfully Created');
					redirect('attendance/index', 'refresh');
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
    

}