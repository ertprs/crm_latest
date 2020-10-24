<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Payroll extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model("Staff_Model");
		$this->load->model("Payroll_Model");
		$this->load->model("Attendance_Model");
		// if ( !$this->Privileges_Model->has_privilege( $path ) ) {
		// 	$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
		// 	redirect( 'panel/' );
		// 	die;
		// }
	}

	function index() {
		$data[ 'title' ] = lang( 'Payslip' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		 
		$getpayslip = $this->Payroll_Model->getrecords();
		$data['getpayslip'] = $getpayslip;

		$this->load->view( 'payroll/index', $data );
	}

	function create(){
		$data[ 'title' ] = lang( 'Generate Payslip' );
	$data[ 'departments' ] = $this->Settings_Model->get_departments();
	$data['staff'] = $this->Staff_Model->get_all_staff();
	
	
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$staff_id = $this->input->post('staff_id');
			$basic_salary = $this->input->post('basic_salary');
			$allowance = $this->input->post('allowance');
			$ot_hours = $this->input->post('ot_hours');
			$ot_per_hour = $this->input->post('ot_per_hour');
			$ot_amount = $this->input->post('ot_amount');
			$advance = $this->input->post('advance');
			$incentives = $this->input->post('incentives');
			$total = $this->input->post('total');
			$total_earnings = $this->input->post('total_earnings');
			$present_days = $this->input->post('present_days');
			$lop_days = $this->input->post('lop_days');
			$total_days = $this->input->post('total_days');
			$params = array(
				'from_date' => $from_date,
				'to_date' => $to_date,
				'staff_id' => $staff_id,
				'basic_salary' => $basic_salary,
				'allowance' => $allowance,
				'ot_hours' => $ot_hours,
				'ot_per_hour' => $ot_per_hour,
				'ot_amount' => $ot_amount,
				'advance' => $advance,
				'incentives' => $incentives,
				'total' => $total,
				'total_earnings' => $total_earnings,
				'present_days' => $present_days,
				'lop_days' => $lop_days,
				'total_days' => $total_days
			);
			$this->db->insert('payslip',$params);
			
				echo '<script>alert("Payslip Generated Successfully!");</script>';
               redirect('payroll/index', 'refresh');
		
		}
		$this->load->view('payroll/create', $data);
	}
	
	
	function payslip(){
		$staff_id = $this->input->post('staff_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['staff_details'] = $this->Staff_Model->get_staff($staff_id);
		$data['advance'] = $this->Payroll_Model->get_srequests($staff_id,$from_date,$to_date);
	//	$data['ot_hours'] = $this->Payroll_Model->get_total_othours($staff_id,$from_date,$to_date);
		$data['absents'] = $this->Payroll_Model->get_no_of_absents($staff_id,$from_date,$to_date);
		$data['attend_details'] = $this->Payroll_Model->get_filter_attendance_ot_log($from_date,$to_date,$staff_id);
		//print_r($data['ot_hours']); die;
		$this->load->view('payroll/payslip',$data);
		 
	}
	function view($id){
		$data['title'] = lang( 'payslip' );
		$data['payslip_data'] = $this->Payroll_Model->get_payslip($id);
		$this->load->view('payroll/view',$data);

	}
	function payslip_excel(){
	    
	   

	    
	     $this->load->library('excel');
		  $this->load->library('IOFactory');
    
	    	$from_date = $this->input->post('from_date');
	$to_date = $this->input->post('to_date');
	
	$time=strtotime($to_date);
$month=date("F",$time);
$year=date("Y",$time);

$day = date("d",$time);


$from_time = strtotime($from_date);

$from_month = date("F",$from_time);

$from_year = date("Y",$from_time);

$from_day = date("d", $from_time);

	
$payslip_data =	$this->Payroll_Model->get_payslip_data($from_date,$to_date);

$object = new PHPExcel();

  $object->setActiveSheetIndex(0);

	 $column = 0;
	// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1'); 

$object->getActiveSheet()->mergeCells('D1:F1');
$object->getActiveSheet()
    ->getCell('D1')
    ->setValue('ARTEFACT EXHIBITION STANDS MANUFACTURING L.L.C');
$styleArray = array(
    'font' => array(
        'bold' => true,
        'underline' => true
    )
);
$object->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
$object->getActiveSheet()
    ->getStyle('D1')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    

$object->getActiveSheet()->mergeCells('D2:F2');
$object->getActiveSheet()
    ->getCell('D2')
    ->setValue('MOL ID No.928294');
$styleArray = array(
    'font' => array(
        'bold' => true,
        'underline' => true
    )
);
$object->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray);
$object->getActiveSheet()
    ->getStyle('D2')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    



$object->getActiveSheet()->mergeCells('D3:F3');
$object->getActiveSheet()
    ->getCell('D3')
    ->setValue('PAYROLL FOR THE MONTH OF  -'.$month.' '.$year);
$styleArray = array(
    'font' => array(
        'bold' => true,
      'color' => array('rgb' => 'FF0000')
 
        
    )
);
$object->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
$object->getActiveSheet()
    ->getStyle('D3')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    

$object->getActiveSheet()->mergeCells('B4:D4');
$object->getActiveSheet()
    ->getCell('B4')
    ->setValue('Salary Date  - '.$from_day.' '.$from_month.' '.$from_year.' to '.$day.' '.$month.' '.$year);
$styleArray = array(
    'font' => array(
        
      'color' => array('rgb' => 'FF0000')
 
        
    )
);
$object->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);




$object->getActiveSheet()->mergeCells('B5:D5');
$object->getActiveSheet()
    ->getCell('B5')
    ->setValue('Overtime  - '.$from_day.' '.$from_month.' '.$from_year.' to '.$day.' '.$month.' '.$year);
$styleArray = array(
    'font' => array(
        
      'color' => array('rgb' => 'FF0000')
 
        
    )
);
$object->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray);
  

$table_columns = array("Sl.No", "NAME OF THE EMPLOYEE", "WORK PERMIT NO (8 DIGIT NO)", "PERSONAL NO (14 DIGIT NO)", "BANK NAME", "IBAN /RATIBI CARD NUMBER", "NO OF DAYS ABSENT", "Cash Advance Deduction", "OT","Fixed Portion","Variable Portion","Total Payment");

 $column = 0;

  foreach($table_columns as $field)
  {
      $object->getActiveSheet()->mergeCells('J6:L6');
$object->getActiveSheet()
    ->getCell('J6')
    ->setValue('Employee`s Net Salary');
    $object->getActiveSheet()
    ->getCell('J7')
    ->setValue('Fixed Portion');
     $object->getActiveSheet()
    ->getCell('K7')
    ->setValue('Variable Portion');
     $object->getActiveSheet()
    ->getCell('L7')
    ->setValue('Total Payment');
    $object->getActiveSheet()->mergeCells('A6:A7');
    $object->getActiveSheet()
    ->getCell('A6')
    ->setValue('Sl.No');
     
    $object->getActiveSheet()->mergeCells('B6:B7');
    $object->getActiveSheet()
    ->getCell('B6')
    ->setValue('NAME OF THE EMPLOYEE');
    
 $object->getActiveSheet()->mergeCells('C6:C7');
    $object->getActiveSheet()
    ->getCell('C6')
    ->setValue('WORK PERMIT NO (8 DIGIT NO)');  
    
    
    $object->getActiveSheet()->mergeCells('D6:D7');
    $object->getActiveSheet()
    ->getCell('D6')
    ->setValue('PERSONAL NO (14 DIGIT NO)'); 
    
    
    $object->getActiveSheet()->mergeCells('E6:E7');
    $object->getActiveSheet()
    ->getCell('E6')
    ->setValue('BANK NAME'); 
    
     $object->getActiveSheet()->mergeCells('F6:F7');
    $object->getActiveSheet()
    ->getCell('F6')
    ->setValue('IBAN /RATIBI CARD NUMBER');
    
      $object->getActiveSheet()->mergeCells('G6:G7');
    $object->getActiveSheet()
    ->getCell('G6')
    ->setValue('NO OF DAYS ABSENT');
    
     $object->getActiveSheet()->mergeCells('H6:H7');
    $object->getActiveSheet()
    ->getCell('H6')
    ->setValue('Cash Advance Deduction');
    
         $object->getActiveSheet()->mergeCells('I6:I7');
    $object->getActiveSheet()
    ->getCell('I6')
    ->setValue('OT');
  // $object->getActiveSheet()->setCellValueByColumnAndRow($column, 6, $field);
   $styleArray = array(
    'font' => array(
        'bold' => true,
        
    ),
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle('A6:L6')->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle('A7:L7')->applyFromArray($styleArray);
   $column++;
  }

//$object->getActiveSheet()->mergeRows('6:7');    
    
    $excel_row = 8;
$i = 1;
$basic_total = 0;
$allowance_total = 0;
$payment_total = 0;

  foreach($payslip_data as $row)
  {
      
       /* $object->getActiveSheet()->getStyle(
    'A7:' . 
    $object->getActiveSheet()->getHighestColumn() . 
    $object->getActiveSheet()->getHighestRow()
)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); */



 $styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$exrow = 'A'.$excel_row;
$exrow1 = 'B'.$excel_row;
$exrow2 = 'C'.$excel_row;
$exrow3 = 'D'.$excel_row;
$exrow4 = 'E'.$excel_row;
$exrow5 = 'F'.$excel_row;
$exrow6 = 'G'.$excel_row;
$exrow7 = 'H'.$excel_row;
$exrow8 = 'I'.$excel_row;
$exrow9 = 'J'.$excel_row;
$exrow10 = 'K'.$excel_row;
$exrow11 = 'L'.$excel_row;


$object->getActiveSheet()->getStyle($exrow,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow1,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow2,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow3,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow4,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow5,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow6,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow7,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow8,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow9,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow10,5)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($exrow11,5)->applyFromArray($styleArray);




      
      $emp_data = $this->Payroll_Model->get_salary_info_details($row['staff_id']);
   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $i);
   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $emp_data['staffname']);
  // $permit_no = strval($emp_data['work_permit_no']);
   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $emp_data['work_permit_no']);
$object
   ->getActiveSheet()
   ->getCellByColumnAndRow(2, $excel_row)
   ->setValueExplicit($emp_data['work_permit_no'], PHPExcel_Cell_DataType::TYPE_STRING);

   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $emp_data['work_permit_personal_no']);
   
   $object
   ->getActiveSheet()
   ->getCellByColumnAndRow(3, $excel_row)
   ->setValueExplicit($emp_data['work_permit_personal_no'], PHPExcel_Cell_DataType::TYPE_STRING);
   
   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,$emp_data['bank_name']);
  
    $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,$emp_data['bank_card_number']);
   
  
    $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['lop_days']);
   
     $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,$row['advance']); 
      $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,$row['ot_amount']);
       $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,$row['basic_salary']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row,$row['allowance']);
         $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row,$row['total']);
         $basic_total += $row['basic_salary'];
         $allowance_total += $row['allowance'];
         $payment_total += $row['total'];
        
   $excel_row++;
   $i++; 
  }
$footer_row = $excel_row+5;
$tele = $excel_row+6;
$mob = $excel_row+7;
$fax = $excel_row+8;
$email = $excel_row+9;
$footer_cell = 'B'.$footer_row;
$tele_cell = 'B'.$tele;
$mob_cell = 'B'.$mob;
$fax_cell = 'B'.$fax;
$email_cell = 'B'.$email;

$sin_val = $excel_row;
$dou_val = $excel_row+1;
$three_val = $excel_row+3;

$single_row = 'A'.$sin_val;
$double_row = 'A'.$dou_val;

$end_row1 = 'L'.$sin_val;
$end_row2 = 'L'.$dou_val;

$three_row = 'A'.$three_val;
$three_col = 'L'.$three_val;


$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$object->getActiveSheet()->getStyle($single_row.':'.$end_row1)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($double_row.':'.$end_row2)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($three_row.':'.$three_col)->applyFromArray($styleArray);
$basic_row = 'J'.$three_val;
$allowance_row = 'K'.$three_val;
$payment_row = 'L'.$three_val;

$object->getActiveSheet()
    ->getCell($basic_row)
    ->setValue($basic_total);
$styleArray = array(
    'font' => array(
        
     'bold' => true,
    
     
 
        
    )
);
$object->getActiveSheet()->getStyle($basic_row)->applyFromArray($styleArray);

$object->getActiveSheet()
    ->getCell($allowance_row)
    ->setValue($allowance_total);
$styleArray = array(
    'font' => array(
        
     'bold' => true,
    
     
 
        
    )
);
$object->getActiveSheet()->getStyle($allowance_row)->applyFromArray($styleArray);


$object->getActiveSheet()
    ->getCell($payment_row)
    ->setValue($payment_total);
$styleArray = array(
    'font' => array(
        
     'bold' => true,
    
     
 
        
    )
);
$object->getActiveSheet()->getStyle($payment_row)->applyFromArray($styleArray);


$object->getActiveSheet()
    ->getCell($footer_cell)
    ->setValue('CONTACT PERSON -   GIGEESH SATHEENDRAN');
$styleArray = array(
    'font' => array(
        
     'bold' => true,
     'underline' => true,
     
 
        
    )
);
$object->getActiveSheet()->getStyle($footer_cell)->applyFromArray($styleArray);


$object->getActiveSheet()
    ->getCell($tele_cell)
    ->setValue('MOBILE -   +97155 10 88 466');
$styleArray = array(
    'font' => array(
        
     'bold' => true,
     'underline' => true,
     
 
        
    )
);
$object->getActiveSheet()->getStyle($tele_cell)->applyFromArray($styleArray);


$object->getActiveSheet()
    ->getCell($mob_cell)
    ->setValue('TELEPHONE -   04 8868425');
$styleArray = array(
    'font' => array(
        
     'bold' => true,
     'underline' => true,
     
 
        
    )
);
$object->getActiveSheet()->getStyle($mob_cell)->applyFromArray($styleArray);


$object->getActiveSheet()
    ->getCell($fax_cell)
    ->setValue('FAX  - ');
$styleArray = array(
    'font' => array(
        
     'bold' => true,
     'underline' => true,
     
 
        
    )
);
$object->getActiveSheet()->getStyle($fax_cell)->applyFromArray($styleArray);

$object->getActiveSheet()
    ->getCell($email_cell)
    ->setValue('EMAIL -  gigeesh@artefact.ae');
$styleArray = array(
    'font' => array(
        
     'bold' => true,
     'underline' => true,
     
 
        
    )
);
$object->getActiveSheet()->getStyle($email_cell)->applyFromArray($styleArray);

$fst_col = $excel_row+8;
$first_col = 'J'.$fst_col;
$second_col = 'K'.$fst_col;
$fst_val_col = 'L'.$fst_col;
//print_r($first_col.'--'.$second_col);
$object->getActiveSheet()->mergeCells($first_col.':'.$second_col);
$object->getActiveSheet()
    ->getCell($first_col)
    ->setValue('Total Salary');
    
$object->getActiveSheet()
    ->getCell($fst_val_col)
    ->setValue($payment_total);    
$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle($first_col.':'.$second_col)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($fst_val_col)->applyFromArray($styleArray);


$tran_col = $excel_row+9;
$tfirst_col = 'J'.$tran_col;
$tsecond_col = 'K'.$tran_col;
$tran_val_col = 'L'.$tran_col;
//print_r($first_col.'--'.$second_col);
$object->getActiveSheet()->mergeCells($tfirst_col.':'.$tsecond_col);
$object->getActiveSheet()
    ->getCell($tfirst_col)
    ->setValue('LULU Tran Charge ');
$object->getActiveSheet()
    ->getCell($tran_val_col)
    ->setValue('5.00');    
$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle($tfirst_col.':'.$tsecond_col)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($tran_val_col)->applyFromArray($styleArray);
  
  
  $vat_col = $excel_row+10;
$vfirst_col = 'J'.$vat_col;
$vsecond_col = 'K'.$vat_col;
$vat_value_col = 'L'.$vat_col;
//print_r($first_col.'--'.$second_col);
$object->getActiveSheet()->mergeCells($vfirst_col.':'.$vsecond_col);
$object->getActiveSheet()
    ->getCell($vfirst_col)
    ->setValue('VAT');
    
    $object->getActiveSheet()
    ->getCell($vat_value_col)
    ->setValue('0.25');
$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle($vfirst_col.':'.$vsecond_col)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($vat_value_col)->applyFromArray($styleArray);
  
  
  
  $empty_col = $excel_row+11;
$efirst_col = 'J'.$empty_col;
$esecond_col = 'K'.$empty_col;
$empty_val_col = 'L'.$empty_col;
//print_r($first_col.'--'.$second_col);
$object->getActiveSheet()->mergeCells($efirst_col.':'.$esecond_col);
$object->getActiveSheet()
    ->getCell($efirst_col)
    ->setValue('');
$object->getActiveSheet()
    ->getCell($empty_val_col)
    ->setValue('');    
$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle($efirst_col.':'.$esecond_col)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($empty_val_col)->applyFromArray($styleArray);


 $lulu_col = $excel_row+12;
$lfirst_col = 'J'.$lulu_col;
$lsecond_col = 'K'.$lulu_col;
$lulu_val_col = 'L'.$lulu_col;
//print_r($first_col.'--'.$second_col);
$pyt_tot = $payment_total+5.00+0.25;
$object->getActiveSheet()->mergeCells($lfirst_col.':'.$lsecond_col);
$object->getActiveSheet()
    ->getCell($lfirst_col)
    ->setValue('Lulu Cheque Amount');
$object->getActiveSheet()
    ->getCell($lulu_val_col)
    ->setValue($pyt_tot);    
$styleArray = array(
    
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$styleArray1 = array('font' => array(
        
     'bold' => true,
    
        
    ),
    'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
    );
$object->getActiveSheet()->getStyle($lfirst_col.':'.$lsecond_col)->applyFromArray($styleArray);
$object->getActiveSheet()->getStyle($lulu_val_col)->applyFromArray($styleArray1);
  
  
  

 header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Payroll Data."'.$month.'"."'.$year.'".xls"');
   header('Cache-Control: max-age=0'); 
  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
 // ob_end_clean();

  $object_writer->save('php://output');

	}

	
}