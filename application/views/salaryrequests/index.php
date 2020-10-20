<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content">
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
.md-open-menu-container
{
	z-index: 2000;
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
   <?php if(isset($pagename) && $pagename=='request'){?>
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0">
			<div class="panel-default panel-table borderten lead-manager-head">
				
				  <div class="ticket-contoller-left">
					<div id="tickets-left-column text-left">
					  <div class="col-md-12 ticket-row-left text-left">
						<div class="tickets-vertical-menu">
						  <!--<a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo 'All Requests'?> <span class="ticket-num" ng-bind="tickets.length"></span></a>-->
						 <?php $this->load->view('inc/side_menu.php')?>
						  
						  
						   <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo 'Status' ?></h5>
						    <a onclick="window.location.href = '<?php echo base_url('mrequests/salaryrequest') ?>';" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num"><?php echo count($all_count);?></span></a>
						 
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/salaryrequest/pending') ?>';" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num"><?php echo count($pend_count);?></span></a>
						  <a  onclick="window.location.href = '<?php echo base_url('mrequests/salaryrequest/approved') ?>';"  class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num"><?php echo count($app_count);?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/salaryrequest/rejected') ?>';" class="side-tickets-menu-item"><?php echo 'Rejected' ?><span class="ticket-num"><?php echo count($dec_count);?></span></a>
						
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
	<?php }else{?>
   <div class="main-content container-fluid col-xs-15 col-md-15 col-lg-15">
	<?php }?>
      <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Salary Request</small><br>
            
          </h2>
		

		 
		  </div>
		  </md-toolbar>
		  
	 
<md-toolbar class="toolbar-white" style="margin-bottom: 2%;">
	 
	 <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-12">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>
	
        <form  id="edit_form" method="post" action="<?php print base_url();?>salaryrequests/create" enctype='multipart/form-data'> 
		 
      <?php if(isset($pagename) && $pagename=='request'){?>
	<input type="hidden" name="pagename" value="request">
	<div class="row col-md-11">
	<?php }else{?>
	<div class="row col-md-9">
	<?php }?>
	
	<div class="form-group col-sm-3">
	   <label><?php echo "Employee" ?></label>
         <select class="form-control myselect" name="employee_id" id="employee_id" required="">
                        <option value="">Select Employee Name</option>
                        <?php foreach($employees as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['staffname']?></option>
                        <?php endforeach;?>
                    </select>
	</div>
	<div class="form-group col-sm-3">
        <label>Salary Type</label>
		<select name="type_of_salary" id="type_of_salary" class="form-control" onchange="select_salarytype(this.value);" required="">
		<option  value="">Choose Salary Type</option>
		<option  value="1">Monthly Advance</option>
		<option value="2">Leave Salary</option>
		
		</select>
 
    </div>
	 <div class="form-group col-sm-3" id="fr_date">
        <label for="inputState">From Date</label>
		<div class="input-group date">
        <input type="text" name="from_date" class="form-control start-date" id="from_date" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	 <div class="form-group col-sm-3" id="t_date">
        <label for="inputState">To Date</label>
		<div class="input-group date">
        <input type="text" name="to_date" class="form-control end-date" id="to_date" value="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	<div class="form-group col-sm-2">
	   <label><?php echo "Amount" ?></label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" />
	 </div> 
	 <div class="form-group col-sm-3">
	   <label><?php echo "Remarks" ?></label>
          <textarea  type="number" 
		  class="form-control" id="remarks" name="remarks" rows="1" and cols="10" required style="height:45px;"></textarea>
	 </div> 
		
		  
		  
		  <?php if(check_privilege('salaryrequests','create')) { ?>
		 
		  <div class="form-group col-md-3">
		  		 <md-button  class="md-icon-button" aria-label="New" ng-cloak type="submit" style="margin-left:60px;">
          <md-tooltip md-direction="bottom"><?php echo 'Create Request' ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>

		  </div> 
		  <?php } ?>
		  
	</form>
	</div>
	   </md-toolbar>
	   <?php if(!isset($pagename) && $pagename!='request'){?>
	 <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
	  
	  <tr><td><input type="button" name="allrequests" onclick="window.location.href = '<?php echo base_url('salaryrequests/index') ?>';" value="All Requests <?php echo count($all_count); ?>" class="btn btn-info"/></td><td><input type="button" name="approved" class="btn btn-success"  onclick="window.location.href = '<?php echo base_url('salaryrequests/index/app') ?>';" value="Approved <?php echo count($app_count); ?>"/></td><td><input type="button" name="pending"  class="btn btn-warning" onclick="window.location.href = '<?php echo base_url('salaryrequests/index/pend') ?>';" value="Pending <?php echo count($pend_count);?>"/></td><td><input type="button" name="declined" class="btn btn-danger" onclick="window.location.href = '<?php echo base_url('salaryrequests/index/dec') ?>';" value="Rejected <?php echo count($dec_count); ?>"/></td></tr>
	 
<div class="ciuis-external-search-in-table" ng-cloak style="margin-left:60%;">
          <input  class="search-table-external" id="search" name="search" type="text"  onkeyup="myFunction()" placeholder="<?php echo lang('search_by').' '.lang('description')?>">
          <md-button class="md-icon-button" aria-label="Search">
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        </div>
	  </md-toolbar>
 <?php }?>
 <md-content  class="bg-white col-md-12"  >
 
 <md-table-container>
							<table md-table id="myTable" class="table table-responsive">
								<thead md-head>
									<tr md-row>
										 <th md-column><span>Employee Name</span></th>
										 <th md-column><span>Series</span></th>
										  <th md-column><span>Type of Salary</span></th>
										  <th md-column><span>Date From</span></th>
										  <th md-column><span>Date To</span></th>
										  <th md-column><span>Amount</span></th>
										  <th md-column><span>Remarks</span></th>
										  <th md-column><span>Status</span></th>
										  
										  <th md-column><span>Created Date</span></th>
										  <th md-column><span>Requested By</span></th>
									</tr>
								</thead>
								<tbody md-body id="show_data">						  
									<?php if(count($srequests) > 0 ){
										 foreach($srequests as $oreq) {   ?>
											<tr md-row>
												<td md-cell>
													<strong><a style="cursor:pointer" onClick="show_post(<?php echo $oreq['salary_id']; ?>)" data-toggle="modal" data-target="#editModal" class="view_detail link" relid="<?php echo $oreq['salary_id'];  ?>" id="<?php echo $oreq['salary_id'];  ?>"><?php echo $oreq['staffname']; ?></a></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['seriesid']; ?></strong>
												</td>
												<td md-cell>
													<strong>
														<?php if($oreq['type_of_salary'] == 1) {  echo 'Monthly Advance'; } else {  echo 'Leave Salary'; }?>
													</strong>
													
												</td>
												<td md-cell>
													<strong > <?php if($oreq['from_date'] != '0000-00-00')  { echo date('d-m-Y',strtotime($oreq['from_date'])); } else { echo '---'; } ?></strong>
												</td>
												<td md-cell>
													<strong> <?php if($oreq['to_date'] != '0000-00-00')  {  echo date('d-m-Y',strtotime($oreq['to_date'])); } else { echo '---'; }  ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['amount']; ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['remarks']; ?></strong>
												</td>
											<?php if(check_privilege('salaryrequests', 'edit') && $maxvalue >= $oreq['amount'] )
											{ ?>
		  <td md-cell>
		 
            <select name="status" id="status" class="form-control" onchange="select_status(this.value,<?php echo $oreq['salary_id']; ?>)" style="width:100px;">
				<option value="1" <?php if($oreq['salarystatus'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($oreq['salarystatus'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['salarystatus'] == '3') { echo 'selected="selected"'; } ?>>Rejected</option>
			</select>
        </td>
		<?php } else { 
		       $showStatus="";
				$showCol="";
				if($oreq['salarystatus'] == '1'){ 
					$showStatus="Pending"; $showCol="orangeCls";
				}else if($oreq['salarystatus'] == '2'){
					$showStatus="Approved";$showCol="greenCls";
				}else if($oreq['salarystatus'] == '3') {
					$showStatus="Rejected";$showCol="brownCls";
				}
		
		?>
		<td md-cell class="md-cell"><strong><span class="<?php echo $showCol; ?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $showStatus; ?></span></strong></td>
		<?php } ?>
												<td md-cell>
													<strong><?php echo date('d-m-Y',strtotime($oreq['created'])); ?></strong>
												</td>
												<td md-cell>
													<img class="imgCircle" src="<?php 
													echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
												</td>
							</tr>
						  <?php }  }  ?>
							  
						  </tbody>
					</table>
						</md-table-container>
     



</md-content>

				
</form>
</div>		  
<div id="leaveModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
   <form method="post" action="<?php print base_url();?>salaryrequests/update_salary">
      <div class="modal-body">
	  <div id="leavehtml"></div>
      </div>
      <div class="modal-footer">
	   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    <button type="submit" class="btn btn-primary" >Update</button>
        <button type="button" class="btn btn-danger" onclick="delete_salary_request();">Delete</button>
      </div>
	  </form>
    </div>

  </div>
</div>

	   


    <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>

<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/onlyjs.php' ); ?>
	<script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({format:'dd-mm-yyyy',
			startDate: new Date(),
			todayHighlight: true,
			autoHide: true,changeYear: true,changeMonth: true});
			$('.newdatepicker1').datepicker({format:'dd-mm-yyyy',
			
			todayHighlight: true,
			autoHide: true,changeYear: true,changeMonth: true});

			$('#fr_date').hide();
			$('#t_date').hide();
    })
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
</script>

<script type="text/javascript">

function select_status(val,id){
	var status = val;
	var id = id;
	
	 $.ajax({
              url : "<?php echo base_url(); ?>salaryrequests/update",
              data:{id : id,status : status},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}
function select_salarytype(val){
	var type = val;
	
	if(type == 2){
			$('#fr_date').show();
			$('#t_date').show();
		
	}else{
		$('#fr_date').hide();
			$('#t_date').hide();
	}
	
	
	
}

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
function show_post(str){
	
	$.ajax({
	  url : "<?php echo base_url(); ?>salaryrequests/showsalaryform/"+str,

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
function delete_salary_request()
{
	var id = $('#salaryid').val();
	
	 $.ajax({
              url : "<?php echo base_url(); ?>salaryrequests/delete_request",
              data:{id : id},
              method:'POST',
              dataType:'json',
			  cache:true,
              success:function(response) {
               location.reload();
            }
          });
}


</script>		