<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>

<md-content class=" ciuis-body-fixed-sidebar _md" ciuis-ready="" style="background:white;">
<md-content class="ciuis-body-content ng-scope _md" >
<md-toolbar class="toolbar-white _md _md-toolbar-transitions">
				<div class="md-toolbar-tools">
					<h2 flex="" md-truncate="" class="text-bold md-truncate flex">Create Attendance <br><small flex="" md-truncate="" class="md-truncate flex">Organize your Attendance</small></h2>
				
				
											
									</div>
			</md-toolbar>
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" style="background:white;min-height: 500px;">

        
              <div class="col-md-12">
			  <div class="col-md-4 ">
              <form class="form-horizontal" action="<?php echo base_url('attendance/create');?>" method="post">
                  	
                <div class="form-group">
                  <label class="control-label col-sm-12" for="email"> <b>Select Date</b><br></label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control newdatepicker" name="attendance_date" id="attendance_date" placeholder="date" autocomplete="off" value="<?php if(isset($attendance_date)){echo $attendance_date; } ?>" >
                  </div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-12" for="email"><b>Departments</b></br></label>
                  <div class="col-sm-12">
                    <select class="form-control myselect" name="department[]" id="department" multiple title="Select Department"  >
                      <option value=""></option>
					  <?php if($departments) {
						  foreach($departments as $dept) { ?>
					  
                      <option value="<?php echo $dept['id'];?>" <?php if(in_array($dept['id'],$depid)) {
						  echo "selected='selected'";
						  
					  } ?>><?php echo $dept['name'];?></option>
                     
					  <?php }  } ?>
                    </select>
                  </div>
				</div>
			<div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary" onclick="select_department();">Search</button>
                  </div>
                </div>
				</form>
				</div>
				 
				
				<div class="col-md-8 ">
				<md-toolbar class="toolbar-white _md _md-toolbar-transitions">
			<div class="md-toolbar-tools">
			
				<h2 flex="" md-truncate="" class="md-truncate flex">Update Attendance </h2>
				
							</div>
		</md-toolbar>
		<form class="form-horizontal" action="<?php echo base_url('attendance/create');?>" method="post">
				 
				<table class="table table-stripped table-bordered" style="width:100%;" id="myTable"> 
				<thead>
				<tr>
				<th scope="col" style="color:#000"><b>Select</b></th>
				<th scope="col" style="color:#000"><b>Attendance date</b></th>
				<th scope="col" style="color:#000"><b>Staff Number</b></th>
				<th scope="col" style="color:#000">Staff Name</th>
				
				<th scope="col" style="color:#000">In Time</th>
				<th scope="col" style="color:#000">Out Time</th>
				
				</tr>
				</thead>
				<tbody>
				<?php if($employees) {  
				?>
				 
				<?php 
				foreach($employees as $emp) {
				$day=date('l',strtotime($attendance_date));	
						$gettime=$this->Attendance_Model->get_attendance_time($emp['id']);
					//	print_r($gettime);
						//print_r($gettime);
						//$workplan=json_decode($gettime['work_plan'],TRUE);
						$starttime='';
						$endtime='';
						if($gettime!=''){
							//foreach($workplan as $eachwork){
								//if($eachwork['status']==1){
									//if(trim($eachwork['day'])==$day){
										$starttime= $gettime['start_time'];
										$endtime= $gettime['end_time'];
									//}
								//}
							//}
						}
						
						
						?>
				<tr>
				<td><input type="checkbox" name="selected[]" value="<?php echo $emp['id'];?>" ><input type="hidden"  name="departmentid[]" 	value="<?php print $emp['department_id'];?>" id="departmentid<?php echo $emp['id'];?>"></td>
				<td><?php print date('d-m-yy',strtotime($attendance_date));?></td>
				<td><?php echo $emp['staff_number']; ?></td>
				<td><?php echo $emp['staffname']; ?></td>
		
						
				    
				    	 <td><input type="time"  class="form-control clockin<?php echo $emp['id'];?>" name="staff[<?php echo $emp['id'];?>][clock_in]" id="clock_in<?php echo $emp['id'];?>" placeholder="Select time" value="<?php echo $starttime;?>" >Disable <input type="checkbox" onclick="disable('<?php echo $emp['id'];?>');" id="incheck<?php echo $emp['id']; ?>"></td>
				    <td><input type="time" class="form-control clockout<?php echo $emp['id'];?>" name="staff[<?php echo $emp['id'];?>][clock_out]" id="clock_out<?php echo $emp['id'];?>" placeholder="Select time" value="<?php echo $endtime;?>" onclick="calculate_difference('<?php echo $emp['id'];?>');">Disable <input type="checkbox" onclick="disableout('<?php echo $emp['id'];?>');" id="outcheck<?php echo $emp['id']; ?>"><input type="hidden" value="<?php echo $endtime;?>" id="exacttime<?php echo $emp['id'];?>" ></td>
	
				
						
				</tr>
			
				<?php }  ?>
				</tbody>
				</table>
                
                      <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              <input type="hidden" class="form-control" name="attendance_date"  value="<?php print $attendance_date;?>">
				   
				<?php }?>
				</form>
				</div>
            </div>
			</div>
			 </md-content>
			  </md-content>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/CiuisAngular.js'); ?>"></script>


<?php include_once( APPPATH . 'views/inc/onlyjs.php' ); ?>
   
  <script>
  function disableout(id){
	  
	  if($('#outcheck' + id).is(":checked")){
	   document.getElementById("clock_out"+id).disabled = true;
	  }else{
		  document.getElementById("clock_out"+id).disabled = false;
	  }
  }
  function disable(id){
	  
	  if($('#incheck' + id).is(":checked")){
	   document.getElementById("clock_in"+id).disabled = true;
	  }else{
		  document.getElementById("clock_in"+id).disabled = false;
	  }
  }
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoHide: true,changeYear: true,changeMonth: true});
    })
	
	function select_department(){
		
		var attendance_date = $('#attendance_date').val();
		var department = $('#department').val();
		if(department == ''){
			alert("Please select department");
			$('#department').focus()
			return false;
		}else{
		 url = "<?php echo base_url(); ?>attendance/create?id="+department+"&date="+attendance_date;
		
	
		window.location.href =  url
		}
		
	}
	function calculate_difference(id)
	{
		
		var changetime=$('.clockout'+id+'').val();
		var exacttime=$('#exacttime'+id+'').val();
		 var values = {changetime:changetime,exacttime:exacttime};
		$.ajax({
        url: "<?php echo base_url(); ?>attendance/change_time",
        type: "post",
        data: values ,
        success: function (response) {
		$('.ot_hrs_'+id+'').val(response);
           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
	}
	
	function makedefault_value(id,type)
	{
		if(type=='A'){
		$('.clockin'+id+'').val('00:00');
		$('.clockout'+id+'').val('00:00');
		$('.ot_hrs_'+id+'').val('00:00');
		}else{
			$('.clockin'+id+'').val('08:00');
			$('.clockout'+id+'').val('18:30');
		}
	}
	
	function makedefault_value1(id,type){
		if(type=='A'){
		$('.clockin'+id+'').val('00:00');
		$('.clockout'+id+'').val('00:00');
		$('.ot_hrs_'+id+'').val('00:00');
		}else{
			$('.clockin'+id+'').val($('#insertcheckinval'+id+'').val());
			$('.clockout'+id+'').val($('#insertcheckoutval'+id+'').val());
			$('.ot_hrs_'+id+'').val($('.ot_hrs_exist'+id+'').val());
			
		}
		
	}
	
</script>


