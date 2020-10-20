	<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>


<md-content class="bg-white " style="min-height:500px;">
<div class="ciuis-body-content ng-scope">
<div class="md-toolbar-tools bg-white" style="text-align: center;">
        <h2 flex="" md-truncate="" class="text-bold md-truncate flex">Create Attendance <br>
          <small flex="" md-truncate="" class="md-truncate flex">Organize Attendance</small></h2>
       
       
         
         
              </div>
        <div class="col-md-2">
          </div>
              <div class="col-md-10">
            <form action="<?php echo base_url('attendance/create_attendance');?>" method="post">
                  	  <div class="form-group col-md-12">
					<label class="control-label col-sm-2" for="email">Departments</label>
                  <div class="col-sm-5">
                    <select class="form-control selectpicker" name="department[]" id="department" multiple data-live-search="true" title="select Department" >
                     
					  <?php if($departments) {
						  foreach($departments as $dept) { ?>
					  
                      <option value="<?php echo $dept['id'];?>" <?php if($department_id == $dept['id']) {
						  echo "selected='selected'";
						  
					  } ?>><?php echo $dept['name'];?></option>
                     
					  <?php }  } ?>
                    </select>
                  </div>
				</div>
                <div class="form-group col-md-12">
                  <label class="control-label col-sm-2" for="email"> Select Date</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control newdatepicker" name="attendance_date" id="attendance_date" placeholder="date" autocomplete="off" value="<?php if(isset($attendance_date)){echo $attendance_date; } ?>" >
                  </div>
                </div>
				
				<div class="form-group col-md-12">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                  </div>
                </div>
				</form>
				
                <form class="form-horizontal" action="<?php echo base_url('attendance/create');?>" method="post">
			
				<input type="hidden" name="employees" value="<?php print_r($employees);?>" />
				<table class="table" > 
				<thead>
				<tr>
				<th scope="col">Staff Number</th>
				<th scope="col">Staff Name</th>
				<th scope="col">Present</th>
				<th scope="col">Absent</th>
				<th scope="col">Week Off</th>
				<th scope="col">Sick Leave</th>
				<th scope="col">Public Holiday</th>
				<th scope="col">In Time</th>
				<th scope="col">Out Time</th>
				<th scope="col">OT Hours</th>
				</tr>
				</thead>
				<tbody>
				<?php if($employees) { 
				foreach($employees as $eachemp) {
				foreach($eachemp as $emp) { ?>
				<tr>
				<td><?php echo $emp['staff_number']; ?></td>
				<td><?php echo $emp['staffname']; ?></td>
		
	<?php		if(array_key_exists($emp['id'], $attendance)  && $attendance[$emp['id']] == "P") { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="P" checked /> </td>
			<?php } else { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="P" checked /> </td>
			<?php } ?>
					<?php if(array_key_exists($emp['id'], $attendance)  && $attendance[$emp['id']] == "A") { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="A" checked /> </td>
				<?php } else { ?>
					<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="A" /> </td>
					<?php } ?>
						<?php if(array_key_exists($emp['id'], $attendance)  && $attendance[$emp['id']] == "WO") { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="WO" checked /> </td>
				<?php } else { ?>
					<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="WO" /> </td>
					<?php } ?>
						<?php if(array_key_exists($emp['id'], $attendance)  && $attendance[$emp['id']] == "SL") { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="SL" checked/> </td>
					<?php } else { ?>
						<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="SL" /> </td>
							<?php } ?>
								<?php if(array_key_exists($emp['id'], $attendance)  && $attendance[$emp['id']] == "PH") { ?>
				<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="PH" checked /> </td>
					<?php } else { ?>
					<td><input type="radio" name="staff_<?php echo $emp['id'];?>" id="staff_id" value="PH" /> </td>
						<?php } ?>
						
						<?php if(array_key_exists($emp['id'], $attendance_timings)  && $attendance_timings[$emp['id']] != "") {
						$timings = explode(',',$attendance_timings[$emp['id']]);
						  
			
						  
						?>
				 <td><input type="time" class="form-control" name="staff[<?php echo $emp['id'];?>][clock_in]" id="clock_in" placeholder="Select time" value="<?php echo $timings['0'];?>"></td>
				    <td><input type="time" class="form-control" name="staff[<?php echo $emp['id'];?>][clock_out]" id="clock_out" placeholder="Select time" value="<?php echo $timings['1'];?>"></td>
				    <?php } else {  ?>
				    
				    	 <td><input type="time" class="form-control" name="staff[<?php echo $emp['id'];?>][clock_in]" id="clock_in" placeholder="Select time" value="<?php echo '08:00';?>"></td>
				    <td><input type="time" class="form-control" name="staff[<?php echo $emp['id'];?>][clock_out]" id="clock_out" placeholder="Select time" value="<?php echo '06:30';?>" ></td>
	
				    <?php } ?>
						<?php if(array_key_exists($emp['id'], $employee_ot_hours)  && $employee_ot_hours[$emp['id']] != "") { ?>
					<td><input type="number" class="form-control" name="ot_<?php echo $emp['id'];?>" id="ot_hrs" value="<?php echo $employee_ot_hours[$emp['id']];?>"></td>
						<?php } else { ?>
						<td><input type="number" class="form-control" name="ot_<?php echo $emp['id'];?>" id="ot_hrs"></td>
						<?php } ?>
				</tr>
				<?php } }} ?>
				</tbody>
				</table>
                
                      
              </form>
            </div>
			
			            </div>
</md-content>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/CiuisAngular.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
  <script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
    })
	
	function select_department(val){
		var department = val;
		var attendance_date = $('#attendance_date').val();
		 url = "<?php echo base_url(); ?>attendance/create?id="+department+"&date="+attendance_date;
		
	
		window.location.href =  url;
		
	}
	
	
	
</script>


