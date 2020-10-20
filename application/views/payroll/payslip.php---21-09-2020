<?php  
$date1 = date_create($from_date);
$date2 = date_create($to_date);
$diff = date_diff($date1,$date2);
$total_days = $diff->format("%a");

?>
<input type="text" name="total_days" id="total_days" value="<?php echo $total_days; ?>" />

       <md-content  class="bg-white" style="width: 100%;">
    
	  <table class="table">
          <thead>
            <tr>
              <td style="color:black;"><?php echo 'Employee Name:' ?><span><?php echo $staff_details['staffname']; ?></span></td>
			  <td style="color:black;"><span><?php echo 'Employee ID:' ?></span><span><?php echo $staff_details['id']; ?></span></td>
			 </tr>
          </thead>
          </table>
	 
		</md-content>	
		
		  <?php
		  $ot_hours = 0;
$absents = 0;
		  foreach($attend_details as $details) {  
//print_r($details);
				$gettime=$this->Attendance_Model->get_attendance_time($details['empl_id']);
				$starttime='';
						$endtime='';
						if($gettime!=''){
							
										 $starttime= $gettime['start_time'];
										 $endtime= $gettime['end_time'];
									
						}
						
						$ci =& get_instance();
$ci->load->model('Attendance_Model');
$ci->load->model('Payroll_Model');
$timings = $ci->Attendance_Model->get_attendance_time($details["empl_id"]);
$next_day_continuation = $ci->Attendance_Model->next_day_continuation($details["punch_date"],$details["empl_id"]);

 //$this->load->model("Attendance_Model");
//$timings = $this->Attendance_Model->get_attendance_time($details["staffid"]); 
$time1 = strtotime($details['CheckInTime']);
$time2 = strtotime($details['CheckOutTime']);
$st_time = strtotime($timings['start_time']);
$et_time = strtotime($timings['end_time']);
$ot_allow_time = strtotime($timings['late_out_count_time']);
$timediff = '-';
$ottimediff = '-';
$pr_status = '-'; 

if($time1 != '' && $time2 != ''){
//echo ($time1.'--'.strtotime($timings['start_time']));
    if($time1 < $st_time && $details['CheckInTime'] != '00:00:00'){
      
	$ottimediff= $this->Payroll_Model->get_time_diff($timings['start_time'],$details['CheckInTime']);
       
	$timediff= $this->Payroll_Model->get_time_diff($details['CheckOutTime'],$timings['start_time']);
	$pr_status = 'Present';
	//print_r($ottimediff);
	$ot_hours += $ottimediff;
	
	}
	else if($time1 >= $st_time && $time1 <= $et_time ){
	   // echo 'sas';
	    if($details['CheckOutTime'] != '' && $time2 > $ot_allow_time){
	        	$ottimediff = $this->Payroll_Model->get_time_diff($details['CheckOutTime'],$timings['late_out_count_time']);
	        		$ot_hours += $ottimediff;
	    }
	    else{
	        $ottimediff = '-';
	    }
	    if($details['CheckOutTime'] > $timings['end_time']){
	        	$timediff= $this->Payroll_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	    }else {
	    	$timediff= $this->Payroll_Model->get_time_diff($details['CheckOutTime'],$details['CheckInTime']);
	    }
	   $pr_status = 'Present'; 	
	}
	else if($time1 >= $ot_allow_time){
	      
	    	$ottimediff = $this->Payroll_Model->get_time_diff($details['CheckOutTime'],$details['CheckInTime']);
	    	$timediff = '-';
	    	$pr_status = 'OT';
	    		$ot_hours += $ottimediff;
	    
	}
	 else if($next_day_continuation == '1' && $details['CheckOutTime'] != ''){
	  
	    $timediff= $this->Payroll_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	    
	    $ottimediff = $this->Payroll_Model->get_time_diff($details['CheckOutTime'],$timings['late_out_count_time']);
	    $pr_status = 'Present';
	    	$ot_hours += $ottimediff;
     }
	else { $timediff= '-';
           $ottimediff = '-'; 
	    $pr_status = 'Absent';
	    $absents += 1;
	}
//$difference = round(abs($time2 - $time1) / 3600,2);
 } 
 
 else if($time2 == ''){
     if($details['CheckOutTime'] == '' && $next_day_continuation == '1'){
	  
	   // $timediff= $this->Attendance_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	   $timediff = '-';
	    $ottimediff = $this->Payroll_Model->get_time_diff('24.00',$details['CheckInTime']);
	    $pr_status = 'OT';
	    	$ot_hours += $ottimediff;
     }
 }
 
 else { $timediff= '-';
           $ottimediff = '-'; 
     $pr_status = 'Absent';
     $absents += 1;
 }
 
 if($details['CheckInTime'] == '00:00:00'){
      $timediff = '-';
       $ottimediff = $this->Payroll_Model->get_time_diff('00.00',$details['CheckOutTime']);;
       $pr_status = 'Present';
      	$ot_hours += $ottimediff;
 }
 $otstatus='';

 			
               
                 } ?>
              
        <?php $working_days = 30-$absents; ?>
		 <md-content  class="bg-white" >
      <md-table-container >
        <table class="table">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th style="color:black;"><span><?php echo 'Earnings:' ?></span></th>
			  <th style="color:black;"><span><?php echo 'Amount:' ?></span></th>
			 </tr>
          </thead>
		  <tbody md-body>
		  <tr md-row>
		  <td md-cell><?php echo 'Salary'; ?></td>
		  <td md-cell><?php echo  round( ($staff_details['basic_salary']*$working_days)/30); ?>
		  <input type="hidden" name="basic_salary" id="basic_salary" class="amt" value="<?php echo round( ($staff_details['basic_salary']*$working_days)/30); ?>"></td>
		  <input type="hidden" name="present_days" id="present_days" value="<?php echo $working_days; ?>" />
		  <input type="hidden" name="lop_days" id="lop_days" value="<?php echo $absents; ?>" />
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Allowances'; ?></td>
		  <td md-cell><?php echo round(($staff_details['allowance']*$working_days)/30); ?>
		  <input type="hidden" name="allowance" id="allowance" class="amt" value="<?php echo round(($staff_details['allowance']*$working_days)/30); ?>">
		  </td>
		  </tr>
		  <tr md-row>
		  <td md-cell><?php echo 'Over Time Hours'; ?></td>
		  <td md-cell><?php echo $ot_hours; ?>
		  <input type="hidden" name="ot_per_hour" id="ot_per_hour" value="<?php echo $staff_details['over_time'];?>">
		  <input type="hidden" name="ot_hours" id ="ot_hours" value="<?php echo $ot_hours; ?>" >
		  </td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Over Time Amount'; ?></td>
		  <td md-cell><input type="hidden" name="ot_amount" id ="ot_amount"  class="amt" value="<?php echo $ot_hours*$staff_details['over_time'];?>"><span id="ot_full_amount"><?php echo $ot_hours*$staff_details['over_time'];?> </span></td>
		  </tr>
		
		  <tr md-row>
		  <td md-cell><?php echo 'Incentives'; ?></td>
		  <td md-cell><input type="number" name="incentives" id="incentives" class="amt" value="" onchange="enter_incentives(this.value);"></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Total Earnings'; ?></td>
		  <td md-cell><input type="hidden" name="total_earnings" id="totale" /><span id="ttotale"></span></td>
		  </tr>
		  </tbody>
          </table>
		   <table class="table">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th style="color:black;"><span><?php echo 'Deductions:' ?></span></th>
			  <th style="color:black;"><span><?php echo 'Amount:' ?></span></th>
			 </tr>
          </thead>
		  <tbody md-body>
		    <tr md-row>
		  <td md-cell><?php echo 'Advance'; ?></td>
		  <td md-cell><?php echo $advance['amount']; ?>
		  <input type="hidden" name="advance" id="advance" class="amt_d" value="<?php echo $advance['amount']; ?>"></td>
		  </tr>
		  <tr md-row>
		  <td md-cell><b><?php echo 'Total Salary in AED'; ?></b></td>
		  <td md-cell><b><input type="hidden" name="total" id="total" /><span id="ttotal"></span></b></td>
		  </tr>
		    </tbody>
          </table>
</md-table-container>
</md-content>		
 
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
    
    

 
  
