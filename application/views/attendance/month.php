<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig();
$this->load->model('Attendance_Model');
//print_r($attend_details); die;
 ?>
  
<div class="ciuis-body-content" >

 <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" layout="row" layout-wrap>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate>Date</h2>
        <form method="post" action="<?php echo base_url(); ?>attendance/atten_excel">
        <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date;?>" />
        <input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date;?>" />
        <input type="hidden" name="month" id="month" value="<?php echo $month;?>" />
        <input type="hidden" name="dep" id="dep" value="<?php echo $dep; ?>" />
        <input type="hidden" name="emp" id="emp" value="<?php echo $emp;?>" />  
        
        
     <input type="submit" name="export" class="btn btn-success" value="Export Excel" />
    </form>
    <form method="post" action="<?php echo base_url(); ?>attendance/download_pdf">
        <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date;?>" />
        <input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date;?>" />
        <input type="hidden" name="month" id="month" value="<?php echo $month;?>" />
        <input type="hidden" name="dep" id="dep" value="<?php echo $dep; ?>" />
        <input type="hidden" name="emp" id="emp" value="<?php echo $emp;?>" />  
        
        
     <input type="submit" name="download" class="btn btn-success" value="Download PDF" />
    </form>
      </div>
      
    </md-toolbar>
     
    <md-content class="bg-white" style="width: 100%;">
        <form method="post" action="<?php echo base_url(); ?>attendance/month">
       <div class="col-md-8">
            
      <div class="col-md-4">
          <div class="form-group">
                      <label for="from_date">From Date</label>
                      <input type="text" class="form-control newdatepicker" name="from_date"  placeholder="date" autocomplete="off" value="<?php if(!empty($from_date)) { echo $from_date; }  ?>"  >
                    </div>
                  </div>
                  
         <div class="col-md-4">
          <div class="form-group">
                      <label for="to_date">To Date</label>
                       <input type="text" class="form-control newdatepicker" name="to_date"  placeholder="date" autocomplete="off" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" >
                    </div>
                  </div> 
                   <div class="col-md-2">
                    <input type="submit" name="submit" class="btn btn-success" value="Submit" />
                    </div>
                </div>
             
     </form>
    </md-content>
  </div>

   

        <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" layout="row" layout-wrap style="margin-top: 90px;"> 
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools"> 
              <h2 class="md-pl-10" flex md-truncate>Attendance Report</h2>
            </div>
          </md-toolbar>
          <md-content class="bg-white" style="width: 100%;">

      

          <div class="col-md-12">
          
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Employee</th>
                          <?php

                            $start_date = 1;
                            $lastDate = date("t", strtotime($to_date));
                            $lastYear = date("Y", strtotime($to_date));
                             $lastmonth = date("m", strtotime($to_date));
                            $current_date = date('d');

                              if($start_date){

                                for ($i=1; $i <= $lastDate ; $i++) { 
                                 ?>
                                 <td> <?php echo date("d",strtotime(date($lastYear.'-'.$lastmonth.'-'.$i)));?><br> <?php echo date("D",strtotime(date($lastYear.'-'.$lastmonth.'-'.$i)));?></td>
                                 <?php 
                                }
                              } ?>
                        </tr>
                      </thead>
                      <?php 
                     

                      if($staff){
                          foreach ($staff as $key => $staff_value) {

                          ?>
                      <tbody>
                        <tr>
                          <td><?php echo $staff_value['staffname'];?></td>
                          <?php
                          if($start_date){

                                for ($i=1; $i <= $lastDate ; $i++) { 

                                 $ci =& get_instance();
                                 if(strlen($i) == 1){
                                 $date = date($lastYear.'-'.$lastmonth.'-0'.$i);
                                 }else{
                                     $date = date($lastYear.'-'.$lastmonth.'-'.$i);
                                 }
$ci->load->model('Attendance_Model');
$attend_details = $ci->Attendance_Model->get_report_attendance_log($date,$staff_value['id']);

$absent=0;
  $present=0;
  $latein=0;
   $ontime=0;
   if(!empty($attend_details)) {
				foreach($attend_details as $details) {  
//echo '<pre>'; print_r($details);
				$gettime=$this->Attendance_Model->get_attendance_time($details['empl_id']);
				$starttime='';
						$endtime='';
						if($gettime!=''){
							
										 $starttime= $gettime['start_time'];
										 $endtime= $gettime['end_time'];
									
						}
						
						$ci =& get_instance();
$ci->load->model('Attendance_Model');
$timings = $ci->Attendance_Model->get_attendance_time(($details["empl_id"]));
$next_day_continuation = $ci->Attendance_Model->next_day_continuation($details["punch_date"],$details["empl_id"]);
$break_timings = $ci->Attendance_Model->get_break_timings($details["empl_id"]);

 //$this->load->model("Attendance_Model");
//$timings = $this->Attendance_Model->get_attendance_time($details["staffid"]); 
$time1 = strtotime($details['CheckInTime']);
$time2 = strtotime($details['CheckOutTime']);
$st_time = strtotime($timings['start_time']);
$et_time = strtotime($timings['end_time']);
$ot_allow_time = strtotime($timings['late_out_count_time']);
$in_ot_allow_time = $timings['late_in_count_time'];
$in_end_grace_time =  strtotime("".$in_ot_allow_time." minutes", strtotime($timings['start_time']));
$in_start_grace_time =  strtotime("-".$in_ot_allow_time." minutes", strtotime($timings['start_time']));

 $in_start_grace = date('H:i:s', $in_start_grace_time); 
 $in_end_grace = date('H:i:s', $in_end_grace_time); 
 
 $out_end_grace_time =  strtotime("".$in_ot_allow_time." minutes", strtotime($timings['end_time']));
 
 $out_start_grace_time =  strtotime("-".$in_ot_allow_time." minutes", strtotime($timings['end_time']));


$out_start_grace = date('H:i:s', $out_start_grace_time); 
 $out_end_grace = date('H:i:s', $out_end_grace_time); 

$timediff = '-';
$ottimediff = '-';
$pr_status = '-'; 

$break_hrs = '-';
$total = 0;
foreach($break_timings as $break){
    $br_start = strtotime($break['start_time']);
    $br_end = strtotime($break['end_time']);
    if($time1 != '' && $time2 != ''){
    if($time1 < $br_start && $time2 > $br_end){
    
    $break_hrs = $this->Attendance_Model->get_time_difference($break['end_time'],$break['start_time']);
    $temp = explode(":", $break_hrs); 
      
    // Convert the hours into seconds 
    // and add to total 
    $total+= (int) $temp[0] * 3600; 
      
    // Convert the minutes to seconds 
    // and add to total 
    $total+= (int) $temp[1] * 60; 
      
    // Add the seconds to total 
    $total+= (int) $temp[2]; 
    
}

}
}
$formatted = sprintf('%02d:%02d:%02d',  
                ($total / 3600), 
                ($total / 60 % 60), 
                $total % 60); 
if($time1 != '' && $time2 != ''){
//echo ($time1.'--'.strtotime($timings['start_time']));
    if($time1 < $st_time ){
      
	$ottimediff= $this->Attendance_Model->get_time_diff($timings['start_time'],$details['CheckInTime']);
      
       
$timediff= $this->Attendance_Model->get_time_difference($details['CheckOutTime'],$timings['start_time']);
	$pr_status = 'Present';
	}
	else if($time1 >= $st_time && $time1 <= $et_time ){
	   // echo 'sas';
	    if($details['CheckOutTime'] != '' && $time2 > $out_end_grace_time){
	        	$ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$out_end_grace);
	    }
	    else{
	        $ottimediff = '-';
	    }
	    if($details['CheckOutTime'] > $timings['end_time']){
	        	$timediff= $this->Attendance_Model->get_time_difference($timings['end_time'],$details['CheckInTime']);
	    }else {
	    	$timediff= $this->Attendance_Model->get_time_difference($details['CheckOutTime'],$details['CheckInTime']);
	    }
	   $pr_status = 'Present'; 	
	}
	else if($time1 >= $out_end_grace_time){
	      
	    	$ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$details['CheckInTime']);
	    	$timediff = '-';
	    	$pr_status = 'OT';
	    
	}
	 else if($next_day_continuation == '1' && $details['CheckOutTime'] != ''){
	  
	    $timediff= $this->Attendance_Model->get_time_difference($timings['end_time'],$details['CheckInTime']);
	    
	    $ottimediff = $this->Attendance_Model->get_time_diff($details['CheckOutTime'],$out_grace_end);
	    $pr_status = 'Present';
     }
	else { $timediff= '-';
           $ottimediff = '-'; 
	    $pr_status = '-';
	}
//$difference = round(abs($time2 - $time1) / 3600,2);
 } 
 
 else if($time2 == ''){
     if($details['CheckOutTime'] == '' && $next_day_continuation == '1'){
	  
	   // $timediff= $this->Attendance_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	   $timediff = '-';
	    $ottimediff = $this->Attendance_Model->get_time_diff('24.00',$details['CheckInTime']);
	    $pr_status = 'OT';
     }else if($details['CheckOutTime'] == '' && $next_day_continuation != '1'){
	  
	   // $timediff= $this->Attendance_Model->get_time_diff($timings['end_time'],$details['CheckInTime']);
	   $timediff = '-';
	    $ottimediff = '-';
	    $pr_status = 'Absent';
     }
     
 }
 
 else { $timediff= '-';
           $ottimediff = '-'; 
     $pr_status = 'Absent';
 }
 
 if($details['CheckInTime'] == '00:00:00'){
      $timediff = '-';
       $ottimediff = $this->Attendance_Model->get_time_diff('00.00',$details['CheckOutTime']);
       $pr_status = 'Present';
 }
 $otstatus='';
 //echo $timediff;
 if($timediff != '-'){
 $tot_diff = $this->Attendance_Model->get_time_diff($timediff,$formatted);
 }else{
    $tot_diff = '-'; 
 }
 
 //commented by sailaja
 /* if($details['CheckInTime']>$timings['end_time']){
	 $otin= $details['CheckInTime'];echo "<br>";
	 if(empty( $details['CheckOutTime'])){
		 $otout='23:59';
	 }else{
		 $otout=$details['CheckOutTime'];
	 }
	 $ottimediff= $this->Attendance_Model->get_time_diff($otin,$otout);
	 $otstatus='OT';
 } */ 
 if($timediff!='-'){
	$hr=explode('Hrs',$timediff);
	if($hr[0]<10){
		 $status='<font color="red">Absent</font>';
		 $timestatus=0;
	}else{
		 $status='<font color="green">Present</font>';
		  $timestatus=1;
	}
 }else{
	 $status='<font color="red">Absent</font>';
	 $timestatus=0;
 }
                                 ?>
                                <td><?php if($pr_status == 'Present') { echo 'P'; } else if($pr_status == 'Absent') { 
                                    echo 'A'; } else { echo $pr_status; }?></td>
                               <?php } }  else {   ?>
                               <td><?php echo 'A';?></td>
                            <?php   } ?>
                               
                                 <?php 
                                }
                              }
                              ?>
                        </tr>
                      </tbody>
                    <?php }} ?>
                    </table>
      
        </div>
      </md-content>
    </div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/attendance.js'); ?>"></script>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">

<script>
     $(document).ready(function(){
		
	
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
      
    })
	
</script>
