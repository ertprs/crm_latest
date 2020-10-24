<?php  $period = new DatePeriod(new DateTime($date_from), new DateInterval('P1D'), new DateTime(''.$date_to.' +1 day'));    foreach ($period as $date) {        
$dates[] = $date->format("Y-m-d");    }	

if(!empty($attn_details)){
	$present=0;
		  $absent=0;
		  $sickleaves=0;
		  $weekoff=0;
		  $publicholiday=0;
	foreach($attn_details as $eachStaff){
foreach($dates as $eachdate){
	$result= $this->Attendance_Model->get_attendance_sheet($eachStaff['id'],$eachdate);
 $day = date("d", strtotime($result['attendance_date']));			
		  if(!empty( $result)){			
		  $status=$result['day_'.(int)$day];
			if($status=='P'){
				$present++;
			}
			
			if($status=='A'){
				$absent++;
			}
			if($status=='SL'){
				$sickleaves++;
			}
			
			if($status=='WO'){
				$weekoff++;
			}
			
			if($status=='PH'){
				$publicholiday++;
			}
		  }
}
}}	?>

<div class="ciuis-body-content" >
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" layout="row" layout-wrap style="margin-top: 30px;"> 
          <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools"> 
              <h2 class="md-pl-10 col-md-4" flex md-truncate>Attendance Report</h2>
			  <br>
			
            </div>
          </md-toolbar>
		   <md-toolbar class="toolbar-white">
		    <div class="md-toolbar-tools"> 
		   <h2 class="md-pl-10 col-md-4" flex md-truncate> <?php echo "present - ".$present;?></h2>
			   <h2 class="md-pl-10 col-md-4" flex md-truncate> <?php echo "Absent - ".$absent;?></h2>
			   <h2 class="md-pl-10 col-md-4" flex md-truncate> <?php echo "WeekOff - ".$weekoff;?></h2>
			    <h2 class="md-pl-10 col-md-4" flex md-truncate> <?php echo "Sick Leaves - ".$sickleaves;?></h2>
				 <h2 class="md-pl-10 col-md-4" flex md-truncate> <?php echo "Public Holidays - ".$publicholiday;?></h2>
				  </div>
		    </md-toolbar>
          <md-content class="bg-white" style="width: 100%;">

          <div class="col-md-12">		  
		  <table class="table table-responsive table-bordered table-striped" id="example">                      
		  <thead>                        
		  <tr>                          
		  <th scope="col" style="color:#000;">Candidate</th> 
		  <?php foreach($dates as $eachdate){?>		  
		  <th scope="col" style="color:#000;">
		  <?php print date('d D M',strtotime($eachdate));?>
		  </th>          		  
		  <?php }?>  
			<th>Days Present</th>
			<th>Days Absent</th>
		  </tr>                      
		  </thead>					   
		  <?php 
		  
		  if(!empty($attn_details)){	foreach($attn_details as $eachStaff){
				
				$present1=0;
				$absent1=0;
		  
		  //$result= $this->Attendance_Model->getmonthlyattendance_new($department,$eachdate);						   						   ?>					  
		  <tr>					  
		  <td><?php print $eachStaff['staffname'].'<br> ID: '.$eachStaff['id'];;?></td>		
		  <?php foreach($dates as $eachdate){	?>	
		  <td><?php 						   
		  $result= $this->Attendance_Model->get_attendance_sheet($eachStaff['id'],$eachdate);						   
		  if(!empty( $result)){		
	  
		  $timeresult= $this->Attendance_Model->get_attendance_time_sheet($eachStaff['id'],$eachdate);
		  $day = date("d", strtotime($result['attendance_date']));							   
		 						    
		  $timeday = date("d", strtotime($timeresult['attendance_date']));		
			
		  $status=$result['day_'.(int)$day];
			if($status=='P'){
				 $status='<span class="btn btn-success btn-sm">Present</span>';
				$present1++;
			}
			
			if($status=='A'){
				$status='<span class="btn btn-danger btn-sm">Absent</span>';
				$absent1++;
			}
			if($status=='SL'){
				$status='<span class="btn btn-warning btn-sm">Sick Leave</span>';
				$sickleaves++;
			}
			
			if($status=='WO'){
				$status='<span class="btn btn-info btn-sm">Week Off</span>';
				$weekoff++;
			}
			
			if($status=='PH'){
				$status='<span class="btn btn-secondary btn-sm">Public Holiday</span>';
				$publicholiday++;
			}
			 echo $status;
		  echo "<br>";	
		  if($timeresult!=''){								
		  $timings = explode(',',$timeresult['day_'.(int)$timeday]); 
			if($result['day_'.(int)$day]!='A'){		  
					  echo '&nbsp;&nbsp;&nbsp;&nbsp;In<span class="glyphicon glyphicon-time"></span> - '.$timings['0'].'<br>Out<span class="glyphicon glyphicon-time"></span> - '.$timings['1'];	
			}		  
		  }	
		  }else{
			  echo "--";
			  }						  
			  ?>
			  </td>					  
			  <?php }?>	
<td><?php print $present1;?></td>	
<td><?php print $absent1;?></td>		  
			  </tr>					  
		  <?php }}?>		 
		  </table>
         
        </div>
		
      </md-content>
    </div>
 </div>

