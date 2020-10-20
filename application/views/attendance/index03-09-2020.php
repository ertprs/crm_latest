<script data-require="jquery@1.11.0" data-semver="1.11.0" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  
<script data-require="select2@3.5.1" data-semver="3.5.1" src="//cdn.jsdelivr.net/select2/3.4.8/select2.min.js"></script>
<style>
.selectpicker > .dropdown .dropdown-menu {
	padding:5px;
}
.pen body {
	padding-top:50px;
}

/* Social Buttons - Twitter, Facebook, Google Plus */
.btn-twitter {
	background: #00acee;
	color: #fff
}
.btn-twitter:link, .btn-twitter:visited {
	color: #fff
}
.btn-twitter:active, .btn-twitter:hover {
	background: #0087bd;
	color: #fff
}

.btn-instagram {
	color:#fff;
	background-color:#3f729b;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:focus,.btn-instagram.focus {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:hover {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}

.btn-github {
	color:#fff;
	background-color:#444;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:focus,.btn-github.focus {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:hover {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}

/* MODAL FADE LEFT RIGHT BOTTOM */
.modal.fade:not(.in).left .modal-dialog {
	-webkit-transform: translate3d(-25%, 0, 0);
	transform: translate3d(-25%, 0, 0);
}
.modal.fade:not(.in).right .modal-dialog {
	-webkit-transform: translate3d(25%, 0, 0);
	transform: translate3d(25%, 0, 0);
}
.modal.fade:not(.in).bottom .modal-dialog {
	-webkit-transform: translate3d(0, 25%, 0);
	transform: translate3d(0, 25%, 0);
}

.modal.right .modal-dialog {
	position:absolute;
	top:0;
	right:0;
	margin:0;
}

.modal.left .modal-dialog {
	position:absolute;
	top:0;
	left:0;
	margin:0;
}

.modal.left .modal-dialog.modal-sm {
	max-width:300px;
}

.modal.left .modal-content, .modal.right .modal-content {
    min-height:100vh;
	border:0;
}

.modal-header {
   
    background-color: #000000	;

 }
.modal-title {
    color: white !important;
	line-height:0.42857143;
	font-size: 20px;
    letter-spacing: .005em;
  }
  .ciuis-invoice-summaries-b1{
	  width:20% !important;
  }
  .ciuis-invoice-summaries-b1 .box-content .percentage
  {
	  left:40%!important;
  }
  .select2-default {
	  color: rgba(0,0,0,0.12) !important;
	  border-color:rgba(0,0,0,0.12) !important;
	  font-family:inherit !important;
	  font-size:inherit !important;
	  
  }
  .md-dialog-container,.md-open-menu-container{
	  z-index:2000;
  }
</style>
<div class="ciuis-body-content" ng-controller="Attendance_Controller">

 <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" layout="row" layout-wrap>
    
      <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
          <?php $path = $this->uri->segment( 3 ); ?>
		  

		  <?php /*
    <div class="panel-heading"> <strong><?php echo 'Attendance'; ?></strong> <span class="panel-subtitle"><?php //echo lang('tasksituationsdesc'); ?></span>  <select class="form-control" name="filter_type" id="filter_type" onchange="select_filter(this.value)">
             <option value="1" <?php if($path == 1) {  echo 'selected="selected"'; } ?>>Today</option>
             <option value="2" <?php if($path == 2) {  echo 'selected="selected"'; } ?>>Yesterday</option>
         </select> </div>
		 <?php */?>
		 <div class="panel-default panel-table borderten lead-manager-head">
				
				  <div class="ticket-contoller-left">
					<div id="tickets-left-column text-left">
					  <div class="col-md-12 ticket-row-left text-left">
						<div class="tickets-vertical-menu">
						 
						   						  
						  
						  
						    <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i>Filter By </h5>
						    <a href="<?php print base_url('attendance');?>" class="side-tickets-menu-item">All</a>
						  <a onclick="select_filter('1');" class="side-tickets-menu-item">Today</a>
						  <a onclick="select_filter('2')" class="side-tickets-menu-item">yesterday </a>
						  <a onclick="select_filter('3')" class="side-tickets-menu-item">Last Week</a>
						  <a onclick="select_filter('4')" class="side-tickets-menu-item">This Month</a>
						
						</div>
					  </div>
					</div>
				</div>
			</div>
  
   
  </div>
    <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
	
		<div class="panel-default">
        <div class="ciuis-invoice-summary">
           <div>
              <div class="row">
                 <div class="col-md-12">
                    <div style="border-top-left-radius: 10px;" class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">
                       <div class="box-header text-uppercase text-bold">PRESENT</div>
                       <div class="box-content" style="width: 130px; height: 130px;">
                          <div class="percentage" ng-bind="openLeads" id="present">
                          </div>
                          <canvas id="0" width="130" height="130" style="border: 1px solid;border-radius: 50%;"></canvas>
                       </div>
                    </div>
                    <div class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">
                       <div class="box-header text-uppercase text-bold">ABSENT</div>
                       <div class="box-content invoice-percent" style="width: 130px; height: 130px;">
                          <div class="percentage" ng-bind="efollowupLeads" id="absent"></div>
                          <canvas id="0" width="130" height="130" style="border: 1px solid;border-radius: 50%;"></canvas>
                       </div>
                    </div>
                    <div class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">
                       <div class="box-header text-uppercase text-bold">ON TIME</div>
                       <div class="box-content invoice-percent" style="width: 130px; height: 130px;">
                          <div class="percentage" ng-bind="cfollowupLeads" id="ontime"></div>
                          <canvas id="0" width="130" height="130" style="border: 1px solid;border-radius: 50%;"></canvas>
                       </div>
                    </div>
                    <div class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">
                       <div class="box-header text-uppercase text-bold">LATE IN </div>
                       <div class="box-content invoice-percent-2" style="width: 130px; height: 130px;">
                          <div class="percentage" ng-bind="chaseLeads" id="latein"></div>
                          <canvas id="1" width="130" height="130" style="border: 1px solid;border-radius: 50%;"></canvas>
                       </div>
                    </div>
                    <div style="border-top-right-radius: 10px;" class="ciuis-invoice-summaries-b1">
                       <div class="box-header text-uppercase text-bold">VACATION</div>
                       <div class="box-content invoice-percent-3" style="width: 130px; height: 130px;">
                          <div class="percentage" ng-bind="convertedLeads" id="vacation"></div>
                          <canvas id="2" width="130" height="130" style="border: 1px solid;border-radius: 50%;"></canvas>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
      </div>
   <div class="md-toolbar-tools bg-white">
        <h2 flex md-truncate class="text-bold"><?php echo 'Attendance'; ?> <br>
        
         </h2>
        
        <div class="ciuis-external-search-in-table">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contacts').' '.lang('name')   ?>">
         <!--  <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php //echo lang('search').' '.lang('contacts') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button> -->
        </div>
        <md-button onclick="update()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo 'Filter Attendance'?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <md-menu>
		<md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
         <md-menu-content width="4">
		 <md-menu-item>
          <a href="<?php echo base_url('attendance/create');?>">Manual Entry</a>
		  </md-menu-item>
		  <md-menu-item>
          <a href="<?php echo base_url('workshift');?>">Work Shift</a>
		  </md-menu-item>
		  <md-menu-item>
          <a href="<?php echo base_url('attendance/month');?>">Generate Report</a>
		  </md-menu-item>
		   </md-menu-content>
		   </md-menu>
           
      </div>
    </md-toolbar>   
    <md-content>
        <div id="mytable">
              <div  class="bg-white">
        <md-table-container>
          <table md-table  md-progress="promise" ng-cloak id="example">
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo 'Date'; ?></span></th>
                 <th md-column md-order-by="address"><span><?php echo 'Employee'; ?></span></th> 
				
                <th md-column md-order-by="cperson"><span><?php echo 'Time In'; ?></span></th>
               <th md-column md-order-by="cnum"><span><?php echo 'Time Out'; ?></span></th>
                <th md-column md-order-by="cemail"><span><?php echo 'Status' ?></span></th> 
				  <th md-column md-order-by="cemail"><span><?php echo 'Working Hours' ?></span></th> 
				   <th md-column md-order-by="cemail"><span><?php echo 'Overtime' ?></span></th> 
			
              </tr>
            </thead>
            <tbody md-body>
                
                <?php
 $absent=0;
  $present=0;
  $latein=0;
   $ontime=0;
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
                <tr class="select_row" md-row >
                <td md-cell><strong><?php print $details['day'].'-'.$details['month'].'-'.$details['year'];//echo date('d-m-Y',strtotime());?></strong></td>
                 <td md-cell><strong><?php echo $details["staffname"];?></strong></td>
                 <?php $days = explode(',',$details["day"]);  ?>
                  <td md-cell><?php if($details['CheckInTime'] != '' && $details['CheckInTime'] != '00:00:00' ) { echo date("h:i:a",strtotime($details['CheckInTime'])); } else if($details['CheckInTime'] == '00:00:00'){  echo '--'; }?><br>
				  <?php  

				  
    if($details['CheckInTime'] >= $in_end_grace  ) { 
	$latein++;
	echo '<font color="red"><b>Late In</b></font>' ; } 
    else if($details['CheckInTime'] < $timings['start_time'] && $details['CheckInTime'] !='00:00:00' && $details['CheckInTime'] < $in_start_grace ) {
        echo '<font color="Yellow"><b>Early In</b></font>' ;
    }
    else if($details['CheckInTime'] == '00:00:00'){
        echo '';    
        
    }
        else  {
$ontime++;
			echo '<b><font color="green">Ok</b></font>'; } ?>
				  
				  </td>
                   <td md-cell><strong><?php  if( $otstatus!=''){
					   echo date("h:i:a",strtotime($otout)); 
				   }else{if($details['CheckOutTime'] != ''){echo date("h:i:a",strtotime($details['CheckOutTime']));}}?></strong><br>
				   <?php  
				   
				  
				   if($details['CheckOutTime'] != ''){
        if($details['CheckOutTime'] >= $out_end_grace ){ echo '<b><font color="red">Late Out</font></b>' ; }
        else if( $details['CheckOutTime'] >= $timings['end_time'] && $details['CheckOutTime'] < $out_end_grace) { echo '<b><font color="green">Ok</font></b>'; } 
				   else if ($details['CheckOutTime'] < $out_start_grace && $details['CheckOutTime'] != '' )  { echo '<b><font color="red">Early Out</font></b>'; }  else if($details['CheckOutTime'] == '') { echo '<b><font color="black">-</font></b>';  } }else{
					   echo '<b><font color="black">-</font></b>'; 
				   }?></td>
                   <td md-cell>
				   <strong>
				   <?php //if( $otstatus!=''){print  $otstatus;}else{print $status;}?>
				   <?php if($pr_status == 'Present') { 
				   
				   $present++;
				   echo '<font color="green">'.$pr_status.'</font>'; 
				   }else if($pr_status == 'Absent'){ 
				   $absent++;
				   echo '<font color="red">'.$pr_status.'</font>';  
				   } else if($pr_status == 'OT'){ 
				   echo '<font color="yellow">'.$pr_status.'</font>';  
				   }?></strong>
				   
				   </td>
                    <td md-cell><strong><?php
/* if($timediff>10){print "10 Hrs";
 $remaininghrs=$timediff - 10;
}else{ */

echo $tot_diff;
//} ?></strong></td>

<!-- <td md-cell><?php //if( $otstatus!=''){print $ottimediff;}else if(!empty($remaininghrs) && $timestatus=="1"){
	// $remaininghrs.' Hrs';}?></td> --><!-- commented by sailaja -->
	<td md-cell><?php if( $ottimediff!=''){print $ottimediff;}else { echo '-'; } ?></td>
                    </tr>
                <?php }  ?>
                
             </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="limitOptions" md-page="task_list.page" md-total="{{tasks.length}}" ></md-table-pagination>
       <!-- <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php //echo lang('notdata') ?></md-content> -->
      </div>
      </div>
    </md-content>    
  </div>
    </div>
  
 <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">
 <div class="modal-header">
 
        <h4 class="modal-title">Filter</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>

<div class="modal-body">
<form id="form1" method="post" action="<?php print base_url().'attendance/filter_attendance';?>">
<div class="row" id="emp"><div class="form-group col-md-12"><label class="control-label col-md-12" for="email"><b>All Employees</b></label><select multiple class="full-width" ui-select2="groupSetup" data-placeholder="Select Employee" name="emps[]">
<?php 
if(isset($allstaff)){
	foreach($allstaff as $stf){
		echo '<option value='.$stf['id'].'>'.$stf['staffname'].'</option>';
	}
		
}
?>
</select>
<h4 class="text-muted text-uppercase"><strong class="ng-binding">filterbydate</strong></h4>
<div class="labelContainer">
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="fromdatetime" placeholder="<?php echo lang('from') ?>" show-todays-date="" minutes="false" ng-change="changeDate(prop)" show-icon="true" ng-model="filter_from_dt" class=" dtp-no-msclear dtp-input md-input" name="from_date">
					</div>
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="todatetime" placeholder="<?php echo lang('to') ?>" show-todays-date="" minutes="true" show-icon="true" ng-change="changeDate(prop)" ng-model="filter_to_dt" class=" dtp-no-msclear dtp-input md-input" name="to_date">
					</div>
				</div></br></br>
				<div class="col-md-12">
<input type="submit" class="btn btn-success col-md-12"  value="Search">
</div>
</div>
</form>
<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>

   
<div id="attn_info">
       
    </div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/attendance.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> 
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->

<link data-require="select2@3.5.1" data-semver="3.5.1" rel="stylesheet" href="//cdn.jsdelivr.net/select2/3.4.8/select2.css" />
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
 <script>
 function update(){
	 
	 $("#sidebar-right").modal ("show");
	 
	 return false;
	  $.ajax({
              url : "<?php echo base_url(); ?>attendance/search_atten",
              data:{},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				  $('#update_details').html(response);
	 $("#sidebar-right").modal ("show");
	 $('#emps').select2({ });
	  $('#depts').select2({ });
	 
	 var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
			  }
	  });
 }
 
 function select_employee(val){
	if(val=='0'){
            $(".emps > option").prop("selected","selected");
            //$(".dep").trigger("change");
	}
			
}
function select_department(val){
	var deps = [];
	if(val=='0'){
            $(".dep > option").prop("selected","selected");
            //$(".dep").trigger("change");
			$. each($(".dep option:selected"), function(){
				if($(this). val() != '0'){
deps. push($(this). val());
				}
});

	}else{
	
$. each($(".dep option:selected"), function(){
deps. push($(this). val());
});

	}
//alert(deps);
 $.ajax({
              url : "<?php echo base_url(); ?>attendance/get_employees",
              data:{deps : deps},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				$('#emp').html(response);
$('#employee_id').select2({ });
				
			  }
 }) 
	
}	
    $(document).ready(function(){
		
		$('#present').html('<?php print $present;?>');
		$('#absent').html('<?php print $absent;?>');
		$('#latein').html('<?php print $latein;?>');
		$('#ontime').html('<?php print $ontime;?>');
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
      
    })
	
	function get_attendance(){
	    var department = $('#department').val();
	    var from_date = $('#from_date').val();
	   var to_date = $('#to_date').val();
	   $.ajax({ 
				type: "POST",
		
				url:'<?php echo base_url(); ?>attendance/summary',
				data: {department:department,from_date:from_date,to_date:to_date}
			}).done(function( data ) {//alert(data);
				$( "#attn_info").html( data );
				$('#example').DataTable();
			 });
	
		// url = "<?php echo base_url(); ?>attendance/create?id="+department+"&date="+attendance_date;
		
	
		//window.location.href =  url;
		
	}
	
	function select_filter(val){
	    //alert(val);
	    window.location.href = '<?php echo base_url(); ?>attendance/index/'+val;

	    /* var filter_type = val;
	       $.ajax({ 
				type: "POST",
		
				url:'<?php //echo base_url(); ?>attendance/index/'+filter_type,
				 cache       : false,
        contentType : true,
        processData : true,
			success: function(response) {
			   // alert(response)
				$( "#mytable").html( response );
					 //$("#mytable").appendTo("body");

				//window.location.reload();
					// $("#mytable").appendTo("body");
				 
			 }
	       }); */
	}
	
</script>
