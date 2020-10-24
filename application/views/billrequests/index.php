<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' );
?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content">
  <style>
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
.greenCls{
	color:#008000;
}

.brownCls{
	color:#964B00;
}
.orangeCls{
	color:#ff6501;
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
						    <a onclick="window.location.href = '<?php echo base_url('mrequests/billrequest') ?>';" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num"><?php echo count($all_count);?></span></a>
						 
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/billrequest/pending') ?>';" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num"><?php echo count($pend_count);?></span></a>
						  <a  onclick="window.location.href = '<?php echo base_url('mrequests/billrequest/approved') ?>';"  class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num"><?php echo count($app_count);?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/billrequest/rejected') ?>';" class="side-tickets-menu-item"><?php echo 'Rejected' ?><span class="ticket-num"><?php echo count($dec_count);?></span></a>
						
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
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Bill Request</small><br>
            
          </h2>
		 

		  
		  </div>
		  </md-toolbar>
		  
	 
<md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
	<?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-12">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>
        <form  id="edit_form" method="post" action="<?php print base_url();?>billrequests/create" enctype='multipart/form-data'> 
		 
     
	<?php if(isset($pagename) && $pagename=='request'){?>
	<input type="hidden" name="pagename" value="request">
	<div class="row col-md-11">
	<?php }else{?>
	<div class="row col-md-9">
	<?php }?>
	 
	 <div class="form-group col-sm-3">
	   <label><?php echo "Supplier" ?></label>
         <!-- <select class="form-control" name="vendor_id" id="vendor_id"  > -->
		 <datalist id="suggestions">
<option value="">Select Vendor Name</option>
<?php foreach($vendors as $row):?>
<option ><?php echo $row['company']?></option>
<?php endforeach;?>
</datalist>
<input  autoComplete="on" list="suggestions" name="vendor_id" required="" style="width:110%;height:48px;"/> 
	</div>
	
	<div class="form-group col-sm-2" id="fr_date" >
        <label for="inputState">Date</label>
		<div class="input-group date">
        <input type="text" name="bill_date" class="form-control newdatepicker" id="bill_date" value="" align="center" required="" style="width:140%;"><span class="input-group-addon"></span>
        </div>
      
    </div>
	 <div class="form-group col-md-2">
	   <label><?php echo "Reference" ?></label>
          <input type="text" 
		  class="form-control" id="reference" name="reference" required="" />
	</div>
	<div class="form-group col-md-2">
	   <label><?php echo "Amount" ?></label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" required="" />
		 </div> 
		  <div class="form-group col-md-3">
	   <label><?php echo "Attachment" ?></label>
		  <input type="file" name="files[]" multiple="" class="form-control-file" style="font-size:13px;" />
		  </div>
		  </div>
		  <?php if(check_privilege('billrequests','create')) { ?>
		   <div class="form-group <?php if(isset($pagename) && $pagename=='request'){?>col-md-1<?php }else{ ?>col-md-3<?php }?>">
		  		 <md-button  class="md-icon-button" aria-label="New" ng-cloak type="submit" style="margin-top:20px;" >
          <md-tooltip md-direction="bottom"><?php echo 'Create Request' ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>

		  </div> 
		  <?php } ?>
	</form>
	   </md-toolbar>
	   <form method="POST">
	   <?php if(!isset($pagename) && $pagename!='request'){?>
 <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
	
	  <tr><td><input type="button" name="allrequests" class="btn btn-info"  onclick="window.location.href = '<?php echo base_url('billrequests/index') ?>';" value="All Requests <?php echo count($all_count); ?>"/></td><td><input type="button" name="approved"  class="btn btn-success" onclick="window.location.href = '<?php echo base_url('billrequests/index/app') ?>';" value="Approved <?php echo count($app_count); ?>"/></td><td><input type="button" name="pending" class="btn btn-warning" onclick="window.location.href = '<?php echo base_url('billrequests/index/pend') ?>';" value="Pending <?php echo count($pend_count);?>"/></td><td><input type="button" name="declined" class="btn btn-danger" onclick="window.location.href = '<?php echo base_url('billrequests/index/dec') ?>';" value="Rejected <?php echo count($dec_count); ?>"/></td></tr>
	  <div class="ciuis-external-search-in-table" ng-cloak style="margin-left:60%;">
          <input  class="search-table-external" id="search" name="search" type="text"  onkeyup="myFunction()" placeholder="<?php echo lang('search_by').' '.lang('description')?>">
          <md-button class="md-icon-button" aria-label="Search">
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        </div>
	  </md-toolbar>
	   <?php }?>
 <md-content  class="bg-white" >
     <div id="items" style="padding:16px;"></div></strong>
	  <md-table-container>
							<table md-table id="myTable">
								<thead md-head>
									<tr md-row>
										 <th md-column><span>Select Bills</span></th>
										 <th md-column><span>Series</span></th>
										  <th md-column><span>Bill Date</span></th>
										  <th md-column><span>Supplier</span></th>
										  <th md-column><span>Reference</span></th>
										  <th md-column><span>Amount</span></th>
										  <th md-column><span>Status</span></th>
										  <th md-column><span>Created At</span></th>
										  <th md-column><span>Upload By</span></th>
										  <th md-column><span>View</span></th>
										
										
									</tr>
								</thead>
								<tbody md-body id="show_data">						  
									<?php if(count($brequests) > 0 ){
										foreach($brequests as $oreq) {  
										
										?>
											<tr md-row>
												
												<td md-cell class="md-cell">
													<strong>
														<input type="checkbox" id="remember" value="<?php echo $oreq['amount']; ?>" class="tot_check" >
											<label for="remember"></label>
													</strong>
													
												</td>
												<td md-cell class="md-cell">
													<strong ><?php echo $oreq['seriesid'];?></strong>
												</td>
												<td md-cell class="md-cell">
													<strong >  <?php echo date('d-m-Y',strtotime($oreq['bill_date'])); ?></strong>
												</td>
												<td md-cell class="md-cell">
													<strong>   <?php echo $oreq['vendor_id']; ?></strong>
												</td>
												<td md-cell class="md-cell">
													<strong><?php echo $oreq['reference']; ?></strong>
												</td>
												<td md-cell class="md-cell">
													<strong> <?php echo $oreq['amount']; ?></strong>
												</td>
												<?php if(check_privilege('billrequests', 'edit') && $oreq['showAccess']=='1')  { ?>
		<td md-cell class="md-cell">
		  <select name="status" id="status" class="form-control" onchange="select_status(this.value,'<?php echo $oreq['billid'];?>')" style="width:100px;">
				<option value="1" <?php if($oreq['bill_status'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($oreq['bill_status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['bill_status'] == '3') { echo 'selected="selected"'; } ?>>Rejected</option>
			</select>
			
			</td>
				<?php } else { 
                    $showStatus="";
					$showCol="";
					if($oreq['bill_status'] == '1'){ 
					    $showStatus="Pending"; $showCol="orangeCls";
					}else if($oreq['bill_status'] == '2'){
						$showStatus="Approved";$showCol="greenCls";
					}else if($oreq['bill_status'] == '3') {
						$showStatus="Rejected";$showCol="brownCls";
					}
				?>
				<td md-cell class="md-cell"><strong><span class="<?php echo $showCol; ?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $showStatus; ?></span></strong></td>
				<?php } ?>
				
			<td md-cell class="md-cell">
              <strong> <?php echo date('d-m-Y',strtotime($oreq['created'])); ?></strong>
           </td>
												<td md-cell class="md-cell">
													<img class="imgCircle" src="<?php 
													 echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
												</td>
												<td md-cell class="md-cell"><a href="#about" onClick="show_post(<?php echo $oreq['bill_id']; ?>)" data-toggle="modal" data-target="#editModal" data-image="<?php echo $oreq['files'] ?>" id="editid<?php echo $oreq['bill_id']; ?>">View</a></td>
							</tr>
						  <?php }  }  ?>
							  
						  </tbody>
					</table>
						</md-table-container>


</md-content>
<?php $path = $this->uri->segment( 1 );  ?>

				
</form>
</div>		  

	   

    <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>

<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/onlyjs.php' ); ?>


<script type="text/javascript">
function select_status(item,id){
	var status = item;
	var id = id;
	$.ajax({
		  url : "<?php echo base_url(); ?>billrequests/update",
		  data:{id : id,status : status},
		  method:'POST',
		  dataType:'json',
		  success:function(response) {
			window.location.reload();
		}
	 });
	
}


var countChecked = function(){
	var total = 0;
	var n = $("input:checked").length;
	$("input:checked").each(function() {
	total += parseInt($(this).val());
	//$( "div" ).text( n+ (n === 1 ? " is" : " are") + " checked!" );
	
	});
	
	$('#items').text( n+ " items" + " selected | " +total + " AED");
};
countChecked();

$("input[type=checkbox]").on("click",countChecked);


    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,changeYear: true,changeMonth: true});
			
    })
</script>
<div class="modal fade" id="editModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bill Request</h4>
        </div>
        <div class="modal-body form-group">
          <img src="" name="image" class="img-responsive postimg" id="image" width="70%" height="50%"><br>
          
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>  
</div>
<script type="text/javascript">
  function show_post(id)
  {
    var image=$('#editid'+id).data('image');
    $("#image").attr('src','<?php echo base_url()?>uploads/files/billrequests/'+id+'/'+image);
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


</script>