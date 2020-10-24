<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<style>
.select2-selection__arrow b{
    display:none !important;
}
.select2-selection{
	min-height:50px !important;
}
.select2-selection__rendered {
	padding-top: inherit !important;
}
.md-avatar1{
  border-radius: 50%;
}

table.md-table:not(.md-row-select) td.md-cell:nth-child(n+2):nth-last-child(n+2), table.md-table:not(.md-row-select) th.md-column:nth-child(n+2):nth-last-child(n+2){
	padding:0 40px 0 0 !important;
}

td.dataTables_empty {
	background-image:none !important;
	color:red;
}

.imgCircle {
    border: 2px solid rgb(243,243,243);
    border-radius: 50%;
}
.redCls{
	color:#ff0000;
}

.greenCls{
	color:#008000;
}

.orangeCls{
	color:#ff6501;
}

.brownCls{
	color:#964B00;
}
</style>
 <div class="div1">
<?php $appconfig = get_appconfig(); ?>
  
   <div class="ciuis-body-content">
 <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0">
			<div class="panel-default panel-table borderten lead-manager-head">
				
				  <div class="ticket-contoller-left">
					<div id="tickets-left-column text-left">
					  <div class="col-md-12 ticket-row-left text-left">
						<div class="tickets-vertical-menu">
						 <?php $this->load->view('inc/side_menu.php');?>
						    <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo 'Status' ?></h5>
						    <a onclick="show_leave_form1(0)" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num" id="allcnt"><?php echo count($all_count);?></span></a>
						  <a onclick="show_leave_form1('open')" class="side-tickets-menu-item"><?php echo 'Open' ?><span class="ticket-num" id="opencnt"><?php echo count($open_count);?></span></a>
						  <a onclick="show_leave_form1('pend')" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num" id="pendingcnt"><?php echo count($pend_count);?></span></a>
						  <a onclick="show_leave_form1('app')" class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num" id="approvedcnt"><?php echo count($app_count);?></span></a>
						  <a onclick="show_leave_form1('dec')" class="side-tickets-menu-item"><?php echo 'Declined' ?><span class="ticket-num" id="declinedcnt"><?php echo count($dec_count);?></span></a>
						
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
     
      <md-toolbar class="toolbar-white" >
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Leave Request</small><br>
            
          </h2>
	

		   
		  </div>
		  </md-toolbar>
		  	  
	 <div class="row">
<md-toolbar class="toolbar-white" style="margin-bottom: 2%;">
		 <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-md-12">
           <div class="alert alert-success" > <a class="close" data-dismiss="alert" href="#" style="color:#fff;">&times;</a><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>
	
	<!--leaverequests/create-->
        <form  id="edit_form" method="post" action="<?php print base_url()?>leaverequests/create" enctype='multipart/form-data'> 
	 
	 <div class=" col-md-12">
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
		<select name="type_of_leave" id="type_of_leave" class="form-control emp" required="">
		<option  value="Un Approved Leave">Un Approved Leave</option>
		<option value="Sick Leave">Sick Leave</option>
		<option value="Annual Leave">Annual Leave</option>
		<option value="Emergency Leave">Emergency Leave</option>
		<option value="Paid Leave">Paid Leave</option>
		<option value="Casual Leave">Casual Leave</option>
		</select>
 
    </div>
	 <div class="form-group col-md-2">
        <label for="inputState">Leave Start Date</label>
		<div class="input-group date">
		
        <input type="text" name="leave_start_date" class="form-control start-date" id="leave_start_date" value=""required="" autocomplete="off" readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	 <div class="form-group col-md-2">
        <label for="inputState">Rejoin Date</label>
		<div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control end-date" id="rejoin_date" value="" required="" autocomplete="off" readonly><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	<div class="form-group col-md-2">
	   <label><?php echo "No. of days" ?></label>
          <input  type="number" 
		  class="form-control" id="no_of_days" name="no_of_days" />
		 </div> 
		
<?php  if(check_privilege('leaverequests', 'create'))  {  ?>
		 <div class="form-group col-md-3">
		  	<input type="submit" name="submit" value="<?php echo 'Create Request' ?>" class="btn btn-success btn-submit">

		  </div> 
<?php } ?>
		  </div>
		  
	</form>
	   </md-toolbar>
	   </div>
	   
	   <div class="row">
				<div class="col-md-12">
					<md-content class="md-pt-0 bg-white">
						<div id="details">
							<md-table-container>
							<table md-table id="myTable">
								<thead md-head>
									<tr md-row>
										
										<th md-column><span>Employee Name</span></td>
										<th md-column><span>Start Date</span></td>
										 <th md-column><span>Rejoin Date</span></th>
										  <th md-column><span>Type of Leave</span></th>
	  <th md-column><span>No of Days</span></th>
	   <th md-column><span>Payment Type</span></th>
	  <th md-column><span>Status</span></th>
	  <th md-column><span>Created At</span></th>
	  <th md-column><span> By</span></th>							
									</tr>
								</thead>
								<tbody md-body id="show_data">						  
									<?php  if(count($lrequests) > 0 ){
										foreach($lrequests as $oreq) {  ?>
											<tr md-row>
												
												<td md-cell>
												<?php if($this->Privileges_Model->check_privilege('leaverequests', 'edit') )  {   ?>
													<strong>
														<a  onclick="view_leave('<?php print $oreq['leave_id'];?>')" class="link"><?php echo $oreq['staffname']; ?></a>
													</strong>
												<?php }else{?>
												<strong>
														<?php echo $oreq['staffname']; ?>
													</strong>
												<?php }?>
												</td>
												<td md-cell>
													<strong ><?php if($oreq['leave_start_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['leave_start_date'])); } ?></strong>
<input type="hidden" name="ls_date" id="ls_date<?php echo $oreq['leave_id'];?>" value="<?php echo $oreq['leave_start_date'];?>" />
												</td>
												<td md-cell>
													<strong> <?php if($oreq['rejoin_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['rejoin_date'])); }  ?></strong>
<input type="hidden" name="rj_date"	 id="rj_date<?php echo $oreq['leave_id'];?>" value="<?php echo $oreq['rejoin_date'];?>" />												
												</td>
												<td md-cell>
													<strong><?php echo $oreq['type_of_leave']; ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['no_of_days']; ?></strong>
												</td>
												<?php if(check_privilege('leaverequests', 'edit') && $oreq['showAccess']=='1')  {   ?>
		<td md-cell>
		<select class="form-control" name="payment_type" id="payment_type<?php echo $oreq['leave_id'];?>" style="width: 132px;" onchange="update_payment(this.value,<?php echo $oreq['leave_id']; ?>)">
		 <option selected="" value="">Select</option>
		<option value="Paid" <?php if($oreq['payment_type'] == 'Paid'){ echo "selected='selected'"; } ?>>Paid</option>
		<option value="Unpaid" <?php if($oreq['payment_type'] == 'Unpaid'){ echo "selected='selected'"; } ?>>Unpaid</option>
		</select></td>
				<?php } else {  
				 $paymentTypeShow='';
				 $paymentshowCol="";
				if($oreq['payment_type'] == ''){ 
					$paymentTypeShow="Selected"; $paymentshowCol="orangeCls";
				}else if($oreq['payment_type'] == 'Paid'){
					$paymentTypeShow="Paid";$paymentshowCol="greenCls";
				}else if($oreq['payment_type'] == 'Unpaid') {
					$paymentTypeShow="Unpaid";$paymentshowCol="redCls";
				}
				 
				
				?>
				<td md-cell class="md-cell"><strong><span class="<?php echo $paymentshowCol; ?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $paymentTypeShow; ?></span></strong></td>
				<?php } ?>
				<?php if(check_privilege('leaverequests', 'edit') && $oreq['showAccess']=='1')  {   ?>
				<td md-cell>
		 
            <select name="status" id="status" class="form-control" onchange="update_status(this.value,<?php echo $oreq['leave_id']; ?>)" style="width: 132px;">
				<option value="1" <?php if($oreq['leave_status'] == '1') { echo 'selected="selected"'; } ?>>Open</option>
				<option value="2" <?php if($oreq['leave_status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['leave_status'] == '3') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="4" <?php if($oreq['leave_status'] == '4') { echo 'selected="selected"'; } ?>>Declined</option>
			</select>
        </td>
				<?php } else {
						$showStatus="";
						$showCol="";
						if($oreq['leave_status'] == '1'){ 
							$showStatus="Open"; $showCol="orangeCls";
						}else if($oreq['leave_status'] == '2'){
							$showStatus="Approved";$showCol="greenCls";
						}else if($oreq['leave_status'] == '3') {
							$showStatus="Pending";$showCol="redCls";
						}else if($oreq['leave_status'] == '4') {
							$showStatus="Declined";$showCol="brownCls";
						}
					?>
												
					<td md-cell class="md-cell"><strong><span class="<?php echo $showCol; ?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $showStatus; ?></span></strong></td>
				<?php }?>
												 <td md-cell>
           <strong> <?php echo date('d-m-Y',strtotime($oreq['created'])); ?></strong>
        </td>
												<td md-cell>
													<img class="imgCircle" src="<?php 
													 echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
												</td>
	<input type="hidden" name="emp_id" id="emp_id<?php echo $oreq['leave_id'];?>" value="<?php echo $oreq['employee_id']; ?>" />
	<input type="hidden" name="leave_type" id="leave_type<?php echo $oreq['leave_id'];?>" value="<?php echo $oreq['type_of_leave']; ?>" />
	<input type="hidden" name="no_of_days" id="no_of_days<?php echo $oreq['leave_id']; ?>" value="<?php echo $oreq['no_of_days'];?>" />

							</tr>
						  <?php }  }  ?>
							  
						  </tbody>
					</table>
						</md-table-container>
						</div>
					</md-content>
				</div>
			</div>
	  </div>
</div>

	   <div id="leaveModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
   
      <div class="modal-body">
	  <div id="leavehtml"></div>
      </div>
      <div class="modal-footer">
	   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary" onclick="select_status();">Update</button>
        <button type="button" class="btn btn-danger" onclick="delete_leave_request();">Delete</button>
      </div>
    </div>

  </div>
</div>

    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>

<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/onlyjs.php' ); ?>


	<script>
	//$.noConflict();
	
	showtable();
	
	function showtable()
	{
		$('#myTable1').DataTable({
	  "paging": true,
	  "lengthChange": false,
	  "searching": false,
	  "ordering": false,
	  "info": true,
	  "autoWidth": false,
});	
	}
	$(function() {
      var $startDate = $('.start-date');
      var $endDate = $('.end-date');

      $startDate.datepicker({
		   format:'dd-mm-yyyy',		
        todayHighlight: true,
			autoHide: true,changeYear: true,changeMonth: true
      });
      $endDate.datepicker({
        format:'dd-mm-yyyy',		
			autoHide: true,changeYear: true,changeMonth: true,
        startDate: $startDate.datepicker('getDate'),
      });

      $startDate.on('change', function () {
        $endDate.datepicker('setStartDate', $startDate.datepicker('getDate'));
      });
    });
    $(document).ready(function(){
		
		
		
		
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({format:'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoHide: true,changeYear: true,changeMonth: true});
			
			$('.emp').select2({ 
			   theme: "bootstrap"
			});
    })
</script>

<script type="text/javascript">
function delete_leave_request()
{
	var id = $('#leaveid').val();
	
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/delete_request",
              data:{id : id},
              method:'POST',
              dataType:'json',
			  cache:true,
              success:function(response) {
               // window.location.reload();
			   $('#leaveModal').modal('hide');
			   show_leave_form1();
			   getallstatusresult();
            }
          });
}

function update_status(val,id){
	var status = val;
	var id = id;
	
	var payment_type = $('#payment_type'+id).val();
	var ls_date = $('#ls_date'+id).val();
	var rj_date = $('#rj_date'+id).val();
	
	var emp_id = $('#emp_id'+id).val();
	var days = $('#no_of_days'+id).val();
	var leave_type = $('#leave_type'+id).val();

	
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/update_status",
              data:{id : id,status : status,  payment_type : payment_type, ls_date : ls_date , rj_date : rj_date, emp_id : emp_id, days : days, leave_type : leave_type},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}
function update_payment(val,id){
	var payment = val;
	var id = id;
	
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/update_payment",
              data:{id : id,payment_type : payment},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}
function select_status(){
	//var status = val;
	var id = $('#leaveid').val();
	var method_of_leave = $('#method_of_leave1').val();
	var status = $('#status').val();
	var payment_type=$('#payment_type1').val();
	var leave_start_date=$('#leave_start_date1').val();
	var rejoin_date=$('#rejoin_date1').val();
	var no_of_days=$('#no_of_days1').val();
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/update",
              data:{id : id,status : status , method_of_leave : method_of_leave, payment_type : payment_type, leave_start_date : leave_start_date, rejoin_date : rejoin_date,no_of_days:no_of_days},
              method:'POST',
              dataType:'json',
              success:function(response) {
				   $('#leaveModal').modal('hide');

			   show_leave_form1();
			   getallstatusresult();
			   
            }
          });
	
}
$('#rejoin_date').change(function(){
     
	var start_date = $('#leave_start_date').val();
	var rejoin_date = $('#rejoin_date').val();
	if(start_date==''){
		alert("Please Select Start Date.");
		$('#rejoin_date').val('');
	}else
	if(rejoin_date<start_date){
		alert("Rejoin Date Should not be less than start date.");
		$('#rejoin_date').val('');
	}else{
    /*var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(start_date);
    date2 = new Date(rejoin_date);
    var timediff = date2 - date1;
    
    var days = Math.floor(timediff / day); 
       
    $('#no_of_days').val(days);*/
	var start= $("#leave_start_date").datepicker("getDate");
    	var end= $("#rejoin_date").datepicker("getDate");
   		days = (end- start) / (1000 * 60 * 60 * 24);
       var finaldiff=Math.round(days);
	   
	   $('#no_of_days').val(finaldiff);
	}
});
function show_leave_form()
{
	
	$.ajax({
	  url : "<?php echo base_url(); ?>leaverequests/index/",

	  method:'POST',
	  success:function(response) {	
	
		//$('#leave_form').html(response);
		$('#details').html(response);
		showtable();
		
		
	}
  });
	
}

function getallstatusresult()
{
	 $.ajax({
              url : "<?php echo base_url(); ?>leaverequests/getallstatusresult",
           
              method:'POST',
              dataType:'json',
			  cache:true,
              success:function(response) {
               // window.location.reload();
			  console.log(response);
			  $('#opencnt').html(response.open_count);
			  $('#allcnt').html(response.all_count);
			  $('#pendingcnt').html(response.pend_count);
			  $('#approvedcnt').html(response.appcnt);
			  $('#declinedcnt').html(response.dec_count);
            }
          });
}
function show_leave_form1(str)
{
	
  //e.preventDefault();

	
	$.ajax({
	  url : "<?php echo base_url(); ?>leaverequests/index/"+str+"/filter",
	cache:true,
	  method:'POST',
	  
	  success:function(response) {	
	
		$('#details').html(response);
		showtable();
		
		
	}
  });
	
}

$("#edit_form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
//alert("sf");
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
		    dataType:'json',
			  cache:true,// serializes the form's elements.
           success: function(data)
           {
               $('#success').html('Leave Request Added Successfully'); // show response from the php script.
			   $('#edit_form')[0].reset(); // Clear the form
 //$("#leave_form").load("leaverequests/index #leave_form");
	show_leave_form1();
	getallstatusresult();
	 
           }
         });


});
function view_leave(str){
	
	$.ajax({
	  url : "<?php echo base_url(); ?>leaverequests/showleaveform/"+str,

	  method:'POST',
	  success:function(response) {	
  
		$('#leavehtml').html(response);
		 
      $('.newdatepicker').datepicker({
		  format:'dd-mm-yyyy',			
			clearBtn: true,
			autoHide: true,
			changeYear: true,
			changeMonth: true,
			zIndex: 2048,
			clearBtn:true});
			
			
		 
		$('#leaveModal').modal('show');
		     
		
		
	}
  });
	
}
</script>		</div>