<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.topRow {
margin-bottom : 30px;
}
.on-drag-enter {
}
.on-drag-hover:before {
display: block;
color: white;
font-size: x-large;
font-weight: 800;

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

.select2-selection__arrow b{
    display:none !important;
}
.select2-selection{
	min-height:50px !important;
}
.select2-selection__rendered {
	padding-top: inherit !important;
}
.newdatepicker { z-index: 300 !important; }
.user-display-avatar{top:0px;left: 13px;}
.user-display-avatar img{width: 130px;   height: 130px;}

#inline{height:auto;display:flex;}
.one,.two{width:30%;height:100px;margin:10px;}
.ion-trash-b{font-size:20px;}
.ion-compose{font-size:20px;}

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

.sepBtnToolbar {
	margin-bottom:5px !important;
	margin-top:-15px !important;
	min-height:40px !important;
	max-height:40px !important;
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

<div class="ciuis-body-content" id="ciuis-body-data" ng-controller="Mrequests_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0">
			<div class="panel-default panel-table borderten lead-manager-head">
				  <div class="ticket-contoller-left">
					<div id="tickets-left-column text-left">
					  <div class="col-md-12 ticket-row-left text-left">
						<div class="tickets-vertical-menu">
						  <!--<a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo 'All Requests'?> <span class="ticket-num" ng-bind="tickets.length"></span></a>-->
						  <?php $this->load->view('inc/side_menu.php')?>
						    <div id="requestpriority">
						   <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo 'Status' ?></h5>
						   <a onclick="window.location.href = '<?php echo base_url('mrequests/index/all') ?>';" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num"><?php echo $status_all_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/open') ?>';" class="side-tickets-menu-item"><?php echo 'Open' ?><span class="ticket-num"><?php echo $status_open_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/pending') ?>';" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num"><?php echo $status_pending_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/app') ?>';" class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num"><?php echo $status_approved_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/dec') ?>';" class="side-tickets-menu-item"><?php echo 'Declined' ?><span class="ticket-num"><?php echo $status_declined_count;?></span></a>
						 
						  <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo lang('filterbypriority') ?></h5>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/priority/low') ?>';" class="side-tickets-menu-item"><?php echo lang('low') ?> <span class="ticket-num"><?php echo $priority_low_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/priority/medium') ?>';" class="side-tickets-menu-item"><?php echo lang('medium') ?> <span class="ticket-num"><?php echo $priority_medium_count;?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/index/priority/high') ?>';" class="side-tickets-menu-item"><?php echo lang('high') ?> <span class="ticket-num"><?php echo $priority_high_count;?></span></a>
						  </div>
						  
						  <div id="leavereuestfilter" style="display:none;">
						  <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo 'Status' ?></h5>
						  <a onclick="show_leave_form1('all')" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num"><?php echo count($open_count);?></span></a>
						  <a onclick="show_leave_form1('open')" class="side-tickets-menu-item"><?php echo 'Open' ?><span class="ticket-num"><?php echo count($open_count);?></span></a>
						  <a onclick="show_leave_form1('pend')" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num"><?php echo count($pend_count);?></span></a>
						  <a onclick="show_leave_form1('app')" class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num"><?php echo count($app_count);?></span></a>
						  <a onclick="show_leave_form1('dec')" class="side-tickets-menu-item"><?php echo 'Declined' ?><span class="ticket-num"><?php echo count($dec_count);?></span></a>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
		<div id="leave_form">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold md-truncate flex"><?php echo 'Requests/Material Requests'; ?> 	<small>(<span><?php echo count($all_count); ?></span>)</small><br>
					</h2>
				</div>
			</md-toolbar>
			
			<div class="row">
				<md-content class="bg-white" style="margin-bottom: 2%;">
					<?php if($response = $this->session->flashdata('success')): ?>
						<div class="col-lg-12">
						   <div class="alert alert-success"><?php echo $response;?></div>
						</div>
					<?php endif;?>
					<?php if($response = $this->session->flashdata('error')): ?>
						<div class="col-lg-12">
						   <div class="alert alert-danger"><?php echo $response;?></div>
						</div>
					<?php endif;?>
					
					<form  id="edit_form" method="post" action="<?php echo site_url('Mrequests/create');?>" enctype='multipart/form-data'>
						<div class="col-md-12">
							<div class="col-xs-12">
								<label><h4><strong><?php echo "Project" ?></strong></h4></label>
								<input type="radio" checked="checked" name="project" id="project" value="project" class="rd"/>
								<label><h4><strong><?php echo "Stock" ?></strong></h4></label>
								<input type="radio" name="project" id="stock" value="stock" class="rd" />
								<label><h4><strong><?php echo "Cosumables" ?></strong></h4></label>
								<input type="radio" name="project" id="cosumables" value="cosumables" class="rd" />
							</div>
						</div>
						<div class="col-md-12 form-group">
							<div class="col-xs-5" id="pr">
								<label><strong><?php echo "Project" ?></strong></label>
								<select class="proj  form-control" name="project_id" id="project_id"> 
									<option value="">Select Project</option>
									<?php foreach($projects as $row):?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
									<?php endforeach;?>
									</datalist>			   
								</select> 
							</div>
						</div>
						<div class="col-md-12 form-group">
							<div class="col-md-5" align="center">
								<div class="noncosumablesdiv">
								<label><strong><?php echo "Material Name" ?></strong></label> 
								<select class="form-control matNameChange" name="material_name" id="material_name" autocomplete="on">
				                	<option value="">Select Item</option>
				                    <?php foreach($materials as $row):?>
					                    <option unittype="<?php echo $row['unit_name']?>" value="<?php echo $row['material_id'];?>"><?php echo $row['itemdescription'];?></option>
					                <?php endforeach;?>
				                </select>
								<input type="hidden" name="material_name_text" id="materialNameTxt" value="" />
								</div>
								<div class="cosumablesdiv" style="display:none;">
								 <label><strong><?php echo "Description" ?></strong></label>
								<textarea  type="text" class="form-control"  name="description" rows="1" style="padding:2%"></textarea>
								</div>
							
							</div>
							<div class="col-md-3" align="center">
								<label><strong><?php echo "Unit Type" ?></strong></label>
								<input required type="text" class="form-control unitType" id="unit_type" name="unit_type" />
							</div>
							<div class="col-md-2" align="center">
								<label><strong><?php echo "Qty" ?></strong></label>
								<input required type="number" class="form-control" id="qty" name="qty" />
							</div>
							<div class="col-md-2" align="center">
								<label><strong><?php echo "Priority" ?></strong></label>
								<select class="form-control" name="priority" id="priority">
									<?php foreach($priority as $eachpriority) { 
										echo "<option value=".$eachpriority['settings_value'].">".$eachpriority['settings_key']."</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<div class="col-md-5 noncosumablesdiv" align="center">
								<label><strong><?php echo "Remarks" ?></strong></label>
								<textarea  type="text" class="form-control" id="remarks" name="remarks" rows="1" style="padding:2%"></textarea>
							</div>
							<div class="col-md-5" align="center">
							<label><strong><?php echo "Attach File" ?></strong></label>
								<div class="file-upload">
								<div class="file-select">
								  <div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span> <?php echo lang('attachment')?></div>
								  <div class="file-select-name" id="noFile"><?php echo lang('nofile')?></div>
								  <input type="file" name="files[]" id="chooseFile"  multiple>
								</div>
							  </div>
						  </div>
							<div class="col-md-2">
								<?php if(check_privilege('mrequests','create')) { ?>
								<button name="send" Value="Send" style="margin-top: 40px;">+</button>
								<?php } ?>
							</div>
						</div>
					</form>
					
				</md-content>
			</div>
			<md-toolbar class="sepBtnToolbar toolbar-white _md _md-toolbar-transitions">
				<div class="md-toolbar-tools" style="margin-left:88%">
					<button name="send" Value="Send" class="createPO btn btn-info">Create PO</button>
				</div>
			</md-toolbar>
			<div class="row">
				<div class="col-md-12">
					<md-content class="md-pt-0 bg-white">
						<md-table-container>
							<table md-table id="myTable">
								<thead md-head>
									<tr md-row>
										<th md-column><input type="checkbox" id="select_all" /></th>
										<th md-column>Series</th>
										<th md-column>Material Name</th>
										<th md-column>Qty</th>
										<th md-column>Unit Type</th>
										<th md-column>Unit Price</th>
										<th md-column>Status</th>
										<th md-column>Priority</th>
										<th md-column>By</th>
									</tr>
								</thead>
								<tbody md-body id="show_data">						  
									<?php if(count($mrequests) > 0 ){
										foreach($mrequests as $mreq) {  ?>
											<tr md-row>
												<td md-cell>
													<input type="checkbox" class="checkbox poChecked" value="<?php echo $mreq['mrid'];?>" vendorid="<?php if($mreq['vendor_id'] !=''){echo $mreq['vendor_id'];}else{echo '0';}?>"/>
												</td>
												<td md-cell>
													<strong><?php echo $mreq['seriesid']; ?></strong>
												</td>
												<td md-cell>
													<strong data-toggle="tooltip" data-placement="top" title="<?php echo $mreq['vendorname']?>">
													    <?php if(check_privilege('mrequests','edit') && $mreq['showAccess']=='1'){ ?>
														<a style="cursor:pointer" onClick="show_post(<?php echo $mreq['mrid']; ?>)" data-toggle="modal" data-target="#editModal" class="view_detail link" relid="<?php echo $mreq['mrid'];  ?>" id="<?php echo $mreq['mrid'];  ?>">
														<?php echo $mreq['materialname'];?>
														</a>
														<?php }else{ 
														   echo $mreq['materialname'];
														}?>
													</strong>
													<br/>
													<?php if($mreq['project_name'] != ''){ echo $mreq['project_name']; } else { echo $mreq['name']; }?>
												</td>
												<td md-cell>
													<strong><?php echo $mreq['qty']; ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $mreq['unit_type']; ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $mreq['price']; ?></strong>
												</td>
												<td md-cell>
											    <?php if(check_privilege('mrequests','edit') && $mreq['showAccess']=='1'){ ?>
													<strong><select name="statuscha" relid="<?php echo $mreq['mrid'];  ?>"  onchange="changestatus(this)" class="form-control" id="status" style="width: 132px; height: 40px;">
														<option value="1" <?php if($mreq['status'] == '1') { echo 'selected="selected"'; } ?>>Open</option>
														<option value="2" <?php if($mreq['status'] == '2') { echo 'selected="selected"'; } ?>>Pending</option>
														<option value="3" <?php if($mreq['status'] == '3') { echo 'selected="selected"';  } ?>>Approved</option>
														<option value="4" <?php if($mreq['status'] == '4') { echo 'selected="selected"'; } ?>>Declined</option>
													</select></strong>
												<?php } else { ?>
													<span class="<?php echo $mreq['colorname']?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $mreq['statusname'];?></span>
												<?php }?>
												
												</td>
												<td md-cell>
													<strong><?php echo $mreq['priority']; ?></strong>
												</td>
												<td md-cell>
													<img class="imgCircle" src="<?php 
													echo base_url('uploads/images/'.$mreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
												</td>
							</tr>
						  <?php }  }  ?>
							  
						  </tbody>
					</table>
						</md-table-container>
					</md-content>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<!--Modal Block -->

<div id="imagePreviewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
     
      <div class="modal-body">
       
		<iframe src="" id="imagepdf" style="width:100%;height:440px;"></iframe>
      </div>
      <div class="modal-footer">
	  <div id="buttons" class='col-md-10'></div>
        <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">CANCEL</button>
      </div>
    </div>
  </div>
</div>

<script type="text/ng-template" id="view_image.html">
  <md-dialog aria-label="options dialog"  class="dialog-picture imagefile">
  <md-dialog-content layout-padding>
    <?php $path = '{{fullpath}}';
    if ($path) { ?>
      <img src="{{fullpath}}" >
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
      <md-button ng-click='DeleteFile(folderid,fileid,filename)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <md-button ng-href="<?php echo base_url('mrequests/download_file/') ?>{{fileid}}/{{filename}}/{{folderid}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>


<form>
	<div class="modal fade" id="editModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Material Request</h4>
        </div>
		<div class="modal-body form-group">
		   <div id="materialDtls"></div>
		</div>
		<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<?php if(check_privilege('mrequests', 'edit'))  {   ?>
				<button type="submit" id="btn_update" class="btn btn-primary">Update</button>
				<?php } ?>
				<?php if(check_privilege('mrequests', 'delete'))  {   ?>
					<button type="submit" id="btn_delete" class="btn btn-primary">Delete</button>
				<?php } ?>
			</div>
		</div>
      </div>      
    </div>
</form>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/imageuploadify.min.css'); ?>" type="text/css"/>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mrequests.js') ?>"></script>
<script src="<?php echo base_url('assets/js/imageuploadify.min.js'); ?>"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
 <!--
<link href="https://code.jquery.com/ui/1.12.1/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">

<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.17/css/bootstrap-select.min.css"/>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.17/js/bootstrap-select.min.js"></script>
 -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var date_input=$('.newdatepicker'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
		dateFormat:'dd-mm-yy',
		container: container,
		todayHighlight: true,
		autoclose: true,
		changeYear: true,
		changeMonth: true,
		theme:'cupertino'
	});	
	$('.emp').select2({	
	});
	
	setTimeout(function() {
		$('.alert-success').hide('fast');
	}, 2000);
	//$('input[type="file"]').imageuploadify();
	
	$('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
	
	$('#editModal').on('change', '.vendorRadio', function(){
		var id = $(this).val();
		var price = $('#VendorPrice_'+id).val();
		var qty = $('#quantity_edit').val();
		$('#price_edit').val(price * qty);
		$('#VendorPrice_'+id).removeAttr('disabled');
	});
	
	$('.createPO').on('click', function() {
		var allvendors = [];
		var withoutvendors = [];
		$. each($(".poChecked:checked"), function(){
			if($(this).attr('vendorid') != '') {
				allvendors.push({vendorid : $(this).attr('vendorid'), materialid: $(this).val()});	
			} else {
				withoutvendors.push({vendorid : $(this).attr('vendorid'), materialid: $(this).val()});
			}
		});
		
		var cntByVendor = count(allvendors, function (item) {
			return item.vendorid
		});
		
		if(allvendors.length > 0 && withoutvendors.length == 0 && Object.keys(cntByVendor).length == 1) {
			$.ajax({
			url : "<?php echo base_url(); ?>mrequests/get_po_request",
			data:{vendors : allvendors},
			method:'POST',
			success:function(response) {
				window.location.href="<?php echo site_url('purchases/'.create);?>";
			}		  
		});
		} else if (allvendors.length == 0 || withoutvendors.length > 0){
			alert('Please select any material with vendor.');
		} else if (Object.keys(cntByVendor).length > 1) {
			alert('You have selected different vendors for materials');
		}
	});
});
  
  count = function (ary, classifier) {
    classifier = classifier || String;
    return ary.reduce(function (counter, item) {
        var p = classifier(item);
        counter[p] = counter.hasOwnProperty(p) ? counter[p] + 1 : 1;
        return counter;
    }, {})
};


function select_req_type(val){
	$.ajax({
		url: '<?php print base_url();?>mrequests/form/'+val,
		type        : 'post',
        cache       : false,
        contentType : true,
        processData : true,
        success: function(response){
			$('#form-details').html(response);	
			$( ".newdatepicker" ).datepicker( "refresh" );
			var date_input=$('.newdatepicker'); //our date input has the name "date"
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			date_input.datepicker({dateFormat:'dd-mm-yy',
			container: container,
			todayHighlight: true,
			autoclose: true,changeYear: true,changeMonth: true});
			$('.emp').selectpicker();
		}
	});
}

$('.rd').on('click',function() {
	if($('#project').is(':checked')) {$('#pr').show(); $('.noncosumablesdiv').show(); $('.cosumablesdiv').hide();};
	if($('#stock').is(':checked')) {$('#pr').hide(); $('.noncosumablesdiv').show(); $('.cosumablesdiv').hide();};
	if($('#cosumables').is(':checked')) {$('#pr').hide();$('.noncosumablesdiv').hide(); $('.cosumablesdiv').show(); };
});

function update(id){
	$.ajax({
		url : "<?php echo base_url(); ?>mrequests/edit_request",
        data:{id : id},
		method:'POST',
        success:function(response) {
			$('#update_details').html(response);
            $("#sidebar-right").modal ("show");
            $('.emp').select2({
			});
            $(function() {
			   $( "#dialog-4" ).dialog({
				   autoOpen: false, 
				   modal: true,
				   buttons: {
					  OK: function() {$(this).dialog("close");}
				   },
				}); 
				$( "#opener-4" ).click(function() {
				  $('#exampleModal2').modal('show');
				  $("#exampleModal2").appendTo("body");
				});
			});		 
		}		  
	})	 
}
function show_post(id) {
  $.ajax({
		url : "<?php echo base_url(); ?>mrequests/get_request_data",
		data:{id : id},
		method:'POST',
		success:function(response) {
			$("#editModal").css('opacity', 1);
			$("#materialDtls").html('');
			$("#materialDtls").html(response);
			$("#editModal").modal('show');
			$("#editModal").appendTo("body");
		}       
  });
}
 
function show_post_pdf(image,id) {
  $.ajax({
		  url : "<?php echo base_url(); ?>mrequests/pdf/"+image,
		  data:{id : id,image : image},
		  method:'POST',
		  success:function(response) {
			  $('#pdfdetails').html(response);
				 $("#pdfModal").modal('show');
				$("#pdfModal").appendTo("body");
		  }    
     });
}
  
  
function select_image_name(val, id){
         var val =  val;       
         var id = id;       
         var r = confirm("Are you sure to delete the file");

	     if (r == true) {
			$.ajax({
				url : "<?php echo base_url(); ?>mrequests/delete_file",
				data:{val : val ,  id : id },
				method:'POST',
				dataType:'json',
				success:function(response) {   
					window.location.reload();
				}
			}); 
	     }
	     else{    
	     }
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

function changestatus(obj){
	var updatedStatus = obj.value;
	var relId = obj.getAttribute("relid");
	$.ajax({
        url: '<?php print base_url();?>mrequests/update_status/',
		data:{status : updatedStatus, relId :relId },
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
           location.reload();
        }
    });
}

function myOptionStyle()
{
	//alert("saD");
}

$('.rd').on('click',function() {
	if($('#project').is(':checked')) {   $('#pr').show() };
	if($('#stock').is(':checked')) {     $('#pr').hide() };
});

$(".proj").select2({
	theme: "bootstrap"
});

$(".matNameChange").select2({
	theme: "bootstrap",
	tags: true
});

$('#myTable').DataTable({
	  "paging": true,
	  "lengthChange": false,
	  "searching": false,
	  //"ordering": false,
	  "info": true,
	  "autoWidth": true,
	  "columnDefs": [
        { "orderable": false, "targets": 0 }
      ],
      "order": [],
});

$('#btn_delete').on('click',function(){
	var material_id = $('#material_id').val();
	$.ajax({
    	type : "POST",
        url  : "<?php echo site_url('mrequests/delete')?>",
        dataType : "JSON",
        data : {material_id:material_id},
        success: function(data){
        	window.location.reload();
        }
    });
	return false;
});

//update record to database
$('#btn_update').on('click',function(){
	$("#editModal").modal('hide');
	var unit_price = $('#price_edit').val();
	var quantity = $('#quantity_edit').val();
    var status = $('#status_edit').val();
    var material_id = $('#material_id').val();
    var vendor_id = $("input[name='vendorradio']:checked").val();
	var vendor_price = $('#VendorPrice_'+vendor_id).val();
    $.ajax({
    	type : "POST",
        url  : "<?php echo site_url('mrequests/update')?>",
        dataType : "JSON",
        data : {unit_price:unit_price,status:status, material_id:material_id,vendor_id:vendor_id,quantity:quantity,vendor_price: vendor_price},
        success: function(data){
        	$('[name="price_edit"]').val("");
            $('[name="status_edit"]').val("");
            $('[name="material_id"]').val("");
            $('#Modal_Edit').modal('hide');
			window.location.reload();
        }
    });
	return false;
});	  

$('#show_data').on('click','.view_detail',function(){		
	var id = $(this).attr('relid'); //get the attribute value
	console.log(id);
	$.ajax({
	  url : "<?php echo base_url(); ?>mrequests/get_request_data",
	  data:{id : id},
	  method:'GET',
	  dataType:'json',
	  success:function(response) {	  
		$('#Modal_Edit').modal('show');
		 $('[name="price_edit"]').val(response.price);
		$('[name="status_edit"]').val(response.status);
		$('[name="material_id"]').val(response.id);	
	}
  });
});

$('.matNameChange').on('change', function() {
	$('#materialNameTxt').val('');
	$('.unitType').val('');
	$('#materialNameTxt').val($('.matNameChange option:selected').text());
	if($( ".matNameChange option:selected" ).val() != '') {
		var unitTypeval = $( ".matNameChange option:selected" ).attr('unittype');
		$('.unitType').val(unitTypeval);
	}
});

function priceCalculate(){
	var qty = $('#quantity_edit').val();
	var vendor_id = $("input[name='vendorradio']:checked").val();
	var price = $('#VendorPrice_'+vendor_id).val();
	if(isNaN(price)) {
		price = "0";
	}
	$('#price_edit').val(price * qty);
}

function ViewPdfFile(fileid, filename,folderid) {
	$("#editModal").modal('hide');
	var fullpath = BASE_URL+'uploads/files/materialrequests/'+folderid+'/'+filename;
	var btn='  <a href="'+BASE_URL+'mrequests/download_file/'+fileid+'/'+filename+'/'+folderid+'" aria-label="add" class="btn btn-primary btn-lg">Download!</a>';
	$('#buttons').html(btn);
	$('#imagepdf').attr('src',fullpath);
	$('#imagePreviewModal').modal('show');
}

function ConvertToAng(filename,id, fileid) {
	$("#editModal").modal('hide');
	angular.element(document.getElementById('ciuis-body-data')).scope().ViewFile(filename,id, fileid);
}

function DeleteFile(folderid,fileid, filename) {
	$("#editModal").modal('hide');
	angular.element(document.getElementById('ciuis-body-data')).scope().DeleteFile(folderid,fileid, filename);
}
</script>