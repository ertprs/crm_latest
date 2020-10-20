
  <div class="row">
<input type="hidden" value="<?php print $id;?>" id="leaveid">
 <div class="form-group col-md-6">
        <label for="inputState">Leave Start Date</label>
		<div class="input-group date">
		
        <input type="text" name="leave_start_date1" class="form-control newdatepicker" id="leave_start_date1" value="<?php print date('d-m-Y',strtotime($oreq['leave_start_date']));?>" required=""  onchange="rejoin_date()" readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	 <div class="form-group col-md-6">
        <label for="inputState">Rejoin Date</label>
		<div class="input-group date">
        <input type="text" name="rejoin_date1" class="form-control newdatepicker" id="rejoin_date1" value="<?php print date('d-m-Y',strtotime($oreq['rejoin_date']));?>" required="" onchange="rejoin_date()" readonly><span class="input-group-addon" ><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	<div class="form-group col-md-6">
	   <label><?php echo "No. of days" ?></label>
          <input  type="number" 
		  class="form-control" id="no_of_days1" name="no_of_days1" readonly value="<?php print $oreq['no_of_days'];?>"/>
		 </div> 
		 	 <div class="form-group col-md-6">
      <label for="employee_signature">Payment Type</label>
	<select class="form-control" name="payment_type1" id="payment_type1">
		 <option selected="" value="">Select</option>
		<option value="Paid" <?php if($oreq['payment_type'] == 'Paid'){ echo "selected='selected'"; } ?>>Paid</option>
		<option value="Unpaid" <?php if($oreq['payment_type'] == 'Unpaid'){ echo "selected='selected'"; } ?>>Unpaid</option>
		</select>
	</div>
           <div class="form-group col-md-8">
      <label for="employee_signature">Method Of Leave</label>
     <select class="form-control" name="method_of_leave1" id="method_of_leave1">
        <option selected="" value="">Select </option>
        <option value="Leave without Approvsl-Deduction Of 16 Hours" <?php if($oreq['method_of_leave']=='Leave without Approvsl-Deduction Of 16 Hours'){ echo "selected='selected'"; }  ?>>Leave without Approvsl-Deduction Of 16 Hours</option>
        <option value="Medical Certificated Provided" <?php if($oreq['method_of_leave']=='Medical Certificated Provided'){ echo "selected='selected'"; }  ?>>Medical Certificated Provided</option>
        <option value="Leave Salary & Airfair Provided by Company" <?php if($oreq['method_of_leave']=='Leave Salary & Airfair Provided by Company'){ echo "selected='selected'"; }  ?>>Leave Salary & Airfair Provided by Company</option>
        <option  value="Emergency Leave" <?php if($oreq['method_of_leave']=='Emergency Leave'){ echo "selected='selected'"; }  ?>>Emergency Leave</option>
        <option  value="Leave without a reason" <?php if($oreq['method_of_leave']=='Leave without a reason'){ echo "selected='selected'"; }  ?>>Leave without a reason</option>
        <option value="Approved Leave Without Airfair" <?php if($oreq['method_of_leave']=='Approved Leave Without Airfair'){ echo "selected='selected'"; }  ?>>Approved Leave Without Airfair</option>
      
      </select>
    </div>
	<?php /*
	
	   <div class="form-group col-md-4">
	   <label for="employee_signature">Status</label>
	   
	   
	   <?php if(check_privilege('leaverequests', 'edit') && $oreq['showAccess']=='1')  {   ?>
            <select name="status" id="status" class="form-control" onchange="update_status(this.value,<?php echo $oreq['leave_id']; ?>)" style="width: 132px;">
				<option value="1" <?php if($oreq['status'] == '1') { echo 'selected="selected"'; } ?>>Open</option>
				<option value="2" <?php if($oreq['status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['status'] == '3') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="4" <?php if($oreq['status'] == '4') { echo 'selected="selected"'; } ?>>Declined</option>
			</select>
        </td>
				<?php } else {
						$showStatus="";
						$showCol="";
						if($oreq['status'] == '1'){ 
							$showStatus="Open"; $showCol="orangeCls";
						}else if($oreq['status'] == '2'){
							$showStatus="Approved";$showCol="greenCls";
						}else if($oreq['status'] == '3') {
							$showStatus="Pending";$showCol="redCls";
						}else if($oreq['status'] == '4') {
							$showStatus="Declined";$showCol="brownCls";
						}
					?>
												
					<strong></br><span class="<?php echo $showCol; ?> form-control" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $showStatus; ?></span></strong>
				<?php }?>
    </div>
<?php */?>
	</div>
	<table class="table table-bordered">
	<tr><td class="bg-success"><span class=" text-white">Month</span></td><td class="bg-success">Days</td></tr>
	<?php for($i=1;$i<=12;$i++){
											
											
											
					$year = date('Y');
$month = $i;
$dateObj   = DateTime::createFromFormat('!m', $month);
$monthName = $dateObj->format('F'); // March
$date_start = date('Y-m-d', strtotime(date($year.'-'.$month).' first day of this month'));
$date_end = date('Y-m-d', strtotime(date($year.'-'.$month).'last day of this month'));

  $getleave= $this->Leaverequests_Model->get_leave_count_data($date_start,$date_end,$oreq['employee_id'] );
  if($getleave>0){
	  ?><tr><td><?php print $monthName;?></td><td><?php print $getleave;?></td></tr><?php
  }


										}?>
										</table>
				<!--						
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->							
 
  <script>
 function rejoin_date(){
    
	var start_date1 = $('#leave_start_date1').val();
	 
	var rejoin_date1 = $('#rejoin_date1').val();
	if(start_date1==''){
		alert("Please Select Start Date.");
		$('#rejoin_date1').val('');
	}else
	if(rejoin_date1<start_date1){
		alert("Rejoin Date Should not be less than start date.");
		$('#rejoin_date1').val('');
	}else{
		/*
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(start_date1);
    date2 = new Date(rejoin_date1);
    var timediff = date2 - date1;
    
    var days = Math.floor(timediff / day); 
       
    $('#no_of_days1').val(days);*/
	 var start= $("#leave_start_date1").datepicker("getDate");
    	var end= $("#rejoin_date1").datepicker("getDate");
   		days = (end- start) / (1000 * 60 * 60 * 24);
       var finaldiff=Math.round(days);
	   
	   $('#no_of_days1').val(finaldiff);
	   
	}
}
  //$.noConflict();
    
	
  </script>