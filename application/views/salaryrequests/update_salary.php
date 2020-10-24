
  <div class="row">
<input type="hidden" value="<?php print $id;?>" name="salaryid" id="salaryid">
<div class="form-group col-sm-6">
	   <label><?php echo "Employee" ?></label>
         <select class="form-control myselect" name="employee_id" id="employee_id" required="">
                        <option value="">Select Employee Name</option>
                        <?php foreach($employees as $row):?>
                        <option value="<?php echo $row['id'];?>" <?php if($result['employee_id'] == $row['id']) {print "selected='selected'";}?>><?php echo $row['staffname']?></option>
                        <?php endforeach;?>
                    </select>
	</div>
	
	<div class="form-group col-sm-6">
        <label>Salary Type</label>
		<select name="type_of_salary" id="type_of_salary" class="form-control" onchange="select_salarytype1(this.value);" required="">
		<option  value="">Choose Salary Type</option>
		<option  value="1" <?php if($result['type_of_salary'] == 1) {print "selected='selected'";}?>>Monthly Advance</option>
		<option value="2" <?php if($result['type_of_salary'] == 2) {print "selected='selected'";}?>>Leave Salary</option>
		
		</select>
 
    </div>
	
 <div class="form-group col-md-6" id="fr_date1">
        <label for="inputState">From Date</label>
		<div class="input-group date">
		
        <input type="text" name="from_date" class="form-control newdatepicker" id="from_date1" value="<?php print date('d-m-Y',strtotime($result['from_date']));?>" required=""  readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	 <div class="form-group col-md-6" id="t_date1">
        <label for="inputState">To Date</label>
		<div class="input-group date">
        <input type="text" name="to_date" class="form-control newdatepicker" id="to_date1" value="<?php print date('d-m-Y',strtotime($result['to_date']));?>" required=""  readonly><span class="input-group-addon" ><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	
	<div class="form-group col-sm-2">
	   <label><?php echo "Amount" ?></label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" value="<?php print $result['amount'];?>" />
	 </div> 
	 <div class="form-group col-sm-3">
	   <label><?php echo "Remarks" ?></label>
          <textarea  type="number" 
		  class="form-control" id="remarks" name="remarks" rows="1" and cols="10" required style="height:45px;"><?php print $result['remarks'];?></textarea>
	 </div> 
		<script>
		<?php if($result['type_of_salary'] == 1) {?>
		$('#fr_date1').hide();
			$('#t_date1').hide();
			$('#from_date1').val('00-00-0000');
			$('#to_date1').val('00-00-0000');
		<?php }else{?>
		
		<?php }?>
		function select_salarytype1(str){
			var type = str;
	
	if(type == 2){
			$('#fr_date1').show();
			$('#t_date1').show();
		
	}else{
		$('#fr_date1').hide();
			$('#t_date1').hide();
			$('#from_date1').val('00-00-0000');
			$('#to_date1').val('00-00-0000');
	}
	
	
	
		}
		
		</script>