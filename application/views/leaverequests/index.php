<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
   <div class="main-content container-fluid col-xs-16 col-md-16 col-lg-16">
       <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
      <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Leave Request</small><br>
            
          </h2>
		 <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-6">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>

		   
		  </div>
		  </md-toolbar>
		  </div>
		  
	 <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
<md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
	
        <form  id="edit_form" method="post" action="leaverequests/create" enctype='multipart/form-data'> 
		 
     
	 
	 <div class="row col-md-9">
	<div class="form-group col-md-3">
	   <label><?php echo "Employee" ?></label>
         <select class="form-control emp" name="employee_id" id="employee_id" required="">
                        <option value="">Select Employee Name</option>
                        <?php foreach($employees as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['staffname']?></option>
                        <?php endforeach;?>
                    </select>
	</div>
	<div class="form-group col-md-3">
        <label>Type of Leave</label>
		<select name="type_of_leave" id="type_of_leave" class="form-control" required="">
		<option  value="Un Approved Leave">Un Approved Leave</option>
		<option value="Sick Leave">Sick Leave</option>
		<option value="Annual Leave">Annual Leave</option>
		<option value="Emergency Leave">Emergency Leave</option>
		<option value="Paid Leave">Paid Leave</option>
		<option value="Casual Leave">Casual Leave</option>
		</select>
 
    </div>
	 <div class="form-group col-md-3">
        <label for="inputState">Leave Start Date</label>
		<div class="input-group date">
        <input type="text" name="leave_start_date" class="form-control newdatepicker" id="leave_start_date" value=""required="" autocomplete="off" readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	 <div class="form-group col-md-3">
        <label for="inputState">Rejoin Date</label>
		<div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control newdatepicker" id="rejoin_date" value="" required="" autocomplete="off" readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	<div class="form-group col-md-3">
	   <label><?php echo "No. of days" ?></label>
          <input  type="number" 
		  class="form-control" id="no_of_days" name="no_of_days" />
		 </div> 
		
<?php  if(check_privilege('otherrequests', 'create'))  {  ?>
		 <div class="form-group col-md-3">
		  		 <md-button  class="md-icon-button" aria-label="New" ng-cloak type="submit" style="margin-top:30px;" >
          <md-tooltip md-direction="bottom"><?php echo 'Create Request' ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>

		  </div> 
<?php } ?>
		  </div>
		  
	</form>
	   </md-toolbar>
	   </div>
	    <div class="row" align="center" >
		   <md-content  class="bg-white" >
		     <md-table-container >
		  <table md-table>
  <tr md-row style="height:50px;">
    <th>Leaves History</th>
	<th></th>
  </tr>
  <tr md-row style="height:40px;">
    <td md-cell>Annual Leave</td>
    <td md-cell><?php echo $annual_count; ?></td>
  </tr>
  <tr md-row style="height:40px;">
    <td md-cell>Sick Leave</td>
    <td md-cell><?php echo $sick_count; ?></td>
  </tr>
  <tr md-row style="height:40px;">
    <td md-cell>Emergency Leave</td>
    <td md-cell><?php echo $emergency_count; ?></td>
  </tr>
  <tr  md-row style="height:40px;">
    <td md-cell>Casual Leave</td>
    <td md-cell><?php echo $casual_count; ?></td>
  </tr>
  <tr  md-row style="height:40px;">
    <td md-cell>Maternity Leave</td>
    <td md-cell>0</td>
  </tr>
  <tr  md-row style="height:20px;">
    <td md-cell><b>Total Leaves</b></td>
    <td md-cell><b><?php $tot_count = $annual_count+$sick_count+$emergency_count+$casual_count;
						echo $tot_count; ?></b></td>
  </tr>
</table>
</md-table-container>

</md-content>
		  </div>
	   <form method="POST">
 <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
	

	  <tr md-row><td md-cell><input type="button" name="allrequests" class="btn btn-info"  onclick="window.location.href = '<?php echo base_url('leaverequests/index') ?>';" value="All Requests <?php echo count($all_count); ?>"/></td><td md-cell><input type="button" name="approved" class="btn btn-success"  onclick="window.location.href = '<?php echo base_url('leaverequests/index/app') ?>';" value="Approved <?php echo count($app_count); ?>"/></td><td md-cell><input type="button" name="pending" class="btn btn-warning" onclick="window.location.href = '<?php echo base_url('leaverequests/index/pend') ?>';" value="Pending <?php echo count($pend_count);?>"/></td><td md-cell><input type="button" name="declined" class="btn btn-danger"  onclick="window.location.href = '<?php echo base_url('leaverequests/index/dec') ?>';" value="Rejected <?php echo count($dec_count); ?>"/></td></tr>
	   <div class="ciuis-external-search-in-table" ng-cloak style="margin-left:60%;">
          <input  class="search-table-external" id="search" name="search" type="text"  onkeyup="myFunction()" placeholder="<?php echo lang('search_by').' '.lang('description')?>">
          <md-button class="md-icon-button" aria-label="Search">
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        </div>
	  </md-toolbar>
 <md-content  class="bg-white" >
      <md-table-container >
	  
	  <table md-table id="myTable">
	  <thead md-head>
	  <tr md-row>
	  
	  <th md-column><span>Employee Name</span></th>
	  <th md-column><span>Leave Start Date</span></th>
	  <th md-column><span>Rejoin Date</span></th>
	  <th md-column><span>Type of Leave</span></th>
	  <th md-column><span>No of Days Leave</span></th>
	  <th md-column><span>Method of Leave</span></th>
	  <th md-column><span>Payment Type</span></th>
	  <th md-column><span>Approved By</span></th>
	  <th md-column><span>Created At</span></th>
	  <th md-column><span>Requested By</span></th>
	</tr>
	  </thead>
	  <tbody md-body id="show_data">
	  
	  <?php if(count($lrequests) > 0 ){
		  foreach($lrequests as $oreq) {  ?>

	  <tr md-row>
		  <td md-cell>
           <?php echo $oreq['staffname']; ?>
        </td>
		  <td md-cell>
          <?php if($oreq['leave_start_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['leave_start_date'])); } ?>
        </td>
		   <td md-cell>
          <?php if($oreq['rejoin_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['rejoin_date'])); }  ?>
        </td>
		 <td md-cell>
          <?php echo $oreq['type_of_leave']; ?>
        </td>
		 <td md-cell>
          <?php echo $oreq['no_of_days']; ?>
        </td>
				<?php if(check_privilege('otherrequests', 'edit'))  {   ?>
		<td md-cell>
		<select class="form-control" name="method_of_leave" id="method_of_leave">
        <option selected="" value="Choose...">Choose...</option>
        <option value="Leave without Approvsl-Deduction Of 2 Hours" <?php if($oreq['method_of_leave']=='Leave without Approvsl-Deduction Of 2 Hours'){ echo "selected='selected'"; }  ?>>Leave without Approvsl-Deduction Of 2 Hours</option>
        <option value="Medical Certificated Provided" <?php if($oreq['method_of_leave']=='Medical Certificated Provided'){ echo "selected='selected'"; }  ?>>Medical Certificated Provided</option>
        <option value="Leave Salary &amp; Airfair Provided by Company" <?php if($oreq['method_of_leave']=='Leave Salary  Airfair Provided by Company'){ echo "selected='selected'"; }  ?>>Leave Salary Airfair Provided by Company</option>
        <option  value="Leave Withou Pay  No AirFair Provided" <?php if($oreq['method_of_leave']=='Leave Withou Pay  No AirFair Provided'){ echo "selected='selected'"; }  ?>>Leave Withou Pay  No AirFair Provided</option>
        <option  value="Leave Salary Without AirFir" <?php if($oreq['method_of_leave']=='Leave Salary Without AirFir'){ echo "selected='selected'"; }  ?>>Leave Salary Without AirFir</option>
        <option value="Family Emergency Leave" <?php if($oreq['method_of_leave']=='Family Emergency Leave'){ echo "selected='selected'"; }  ?>>Family Emergency Leave</option>
        <option value="Medical Emergency Leave" <?php if($oreq['method_of_leave']=='Medical Emergency Leave'){ echo "selected='selected'"; }  ?>>Medical Emergency Leave</option>
        <option  value="Paid Leave" <?php if($oreq['method_of_leave']=='Paid Leave'){ echo "selected='selected'"; }  ?>>Paid Leave</option>
        <option  value="Paid Leave Without Airfir" <?php if($oreq['method_of_leave']=='Paid Leave Without Airfir'){ echo "selected='selected'"; }  ?>>Paid Leave Without Airfir</option>
        <option  value="Approved Leave without Airfir" <?php if($oreq['method_of_leave']=='Approved Leave without Airfir'){ echo "selected='selected'"; }  ?>>Approved Leave without Airfir</option>
      </select>
		</td>
				<?php } else { ?>
				<td md-cell>
				<?php echo $oreq['method_of_leave']; ?>
				</td>
				<?php } ?>
				<?php if(check_privilege('otherrequests', 'edit'))  {   ?>
		<td md-cell>
		<select class="form-control" name="payment_type" id="payment_type">
		 <option selected="" value="Choose...">Choose...</option>
		<option value="Paid" <?php if($oreq['payment_type'] == 'Paid'){ echo "selected='selected'"; } ?>>Paid</option>
		<option value="Unpaid" <?php if($oreq['payment_type'] == 'Unpaid'){ echo "selected='selected'"; } ?>>Unpaid</option>
		</select></td>
				<?php } else {  ?>
				<?php echo $oreq['payment_type']; ?>
				<?php } ?>
				<?php if(check_privilege('otherrequests', 'edit'))  {   ?>
		  <td md-cell>
		 
            <select name="status" id="status" class="form-control" onchange="select_status(this.value,<?php echo $oreq['leave_id']; ?>)">
				<option value="1" <?php if($oreq['status'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($oreq['status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['status'] == '3') { echo 'selected="selected"'; } ?>>Rejected</option>
			</select>
        </td>
				<?php } else { ?>
				<td md-cell>
		<?php
		 
		 if($oreq['status'] == '1') { echo 'Pending'; }
		else if($oreq['status'] == '2') { echo 'Approved'; }
		else if($oreq['status'] == '3') { echo 'Rejected'; }	
		 
		 
		 
		 ?>
		 </td>
				<?php } ?>
		  <td md-cell>
            <?php echo date('d-m-Y',strtotime($oreq['created'])); ?>
        </td>
		  <td md-cell>
			<img ng-src="<?php 
			  
			  echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
        </td>
		</tr>
	  <?php }  } else { ?>
		  <tr align="center" style="color:red"><td colspan="6"><?php echo "No records Found"; ?></td></tr>
	 <?php  } ?>
	  </tbody>
</table>
</md-table-container>

</md-content>
<?php $path = $this->uri->segment( 1 );  ?>
<md-table-pagination ng-show="1 > 0" md-limit="<?php echo count($all_count); ?>" md-limit-options="limitOptions" md-page="1" md-total="<?php echo count($all_count); ?>" ></md-table-pagination>
				
</form>
</div>		  

	   

    <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/projects.js'); ?>"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
	<script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'dd-mm-yy',
			container: container,
			todayHighlight: true,
			autoclose: true,changeYear: true,changeMonth: true});
			
			$('.emp').select2({ 
			    
			});
    })
</script>

<script type="text/javascript">

function select_status(val,id){
	var status = val;
	var id = id;
	var method_of_leave = $('#method_of_leave').val();
	var payment_type = $('#payment_type').val();
	
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/update",
              data:{id : id,status : status , method_of_leave : method_of_leave, payment_type : payment_type },
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}
$('#rejoin_date').change(function(){
     
	var start_date = $('#leave_start_date').val();
	var rejoin_date = $('#rejoin_date').val();
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(start_date);
    date2 = new Date(rejoin_date);
    var timediff = date2 - date1;
    
    var days = Math.floor(timediff / day); 
       
    $('#no_of_days').val(days);
});
 function myFunction() {
  var input, filter, table, trs, tds,  i, txtValue;
  input = document.getElementById("search");
  
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  var trs = table.tBodies[0].getElementsByTagName("tr");


  for (i = 0; i < trs.length; i++) {
    tds = trs[i].getElementsByTagName("td") ;
     trs[i].style.display = "none";

    // loop through row cells
    for (var i2 = 0; i2 < tds.length; i2++) {

      // if there's a match
      if (tds[i2].innerHTML.toUpperCase().indexOf(filter) > -1) {

        // show the row
        trs[i].style.display = "";

        // skip to the next row
        continue;

      }
    }
  }
}



</script>		