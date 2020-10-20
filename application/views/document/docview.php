<style>
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#000;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#000;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #26c281 !important;
		outline: 0;
		color:#fff !important;
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

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Out'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'In'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }

.switchToggle1 input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle1 label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle1 label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle1 input:checked + label, .switchToggle1 input:checked + input + label  {background: #3e98d3; }
.switchToggle1 input + label:before, .switchToggle1 input + input + label:before {content: 'No'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle1 input:checked + label:before, .switchToggle1 input:checked + input + label:before {content: 'Yes'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle1 input:checked + label:after, .switchToggle1 input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle1 label:active:after {width: 60px; } 

.switchToggle2 input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle2 label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle2 label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle2 input:checked + label, .switchToggle2 input:checked + input + label  {background: #3e98d3; }
.switchToggle2 input + label:before, .switchToggle2 input + input + label:before {content: 'No'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle2 input:checked + label:before, .switchToggle2 input:checked + input + label:before {content: 'Yes'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle2 input:checked + label:after, .switchToggle2 input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle2 label:active:after {width: 60px; } 
.toBold { 
    color: orange !important;
};
.ciuis-activity-line ul.ciuis-activity-timeline li {
    list-style: none;
    margin: auto;
    min-height: 70px;
    border-left: 1px dashed #818384;
    padding: 0 0 25px 30px;
    position: relative;
    padding-top: 16px;
    width: 232px;
}
</style>
<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->
 <!---<div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>-->
<div class="ciuis-body-content" ng-controller="Documentedit_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<div class="col-sm-11">
				    <span style="font-size: 16px;">Information View</span><br>
					<span style="font-size: 19px;" ><b><?php echo $result['name'] ?></b></span>
				
				</div>
				<!--<md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
						<md-tooltip md-direction="bottom"><?php //echo lang('update') ?></md-tooltip> 
						<md-icon><i class="ion-compose  text-muted"></i></md-icon>
				</md-button>
				<a href="<?php //echo site_url() ?>contacts/delete_contact/<?php //echo $task['person_id'] ?>"><i class="fa fa-trash"></i></a> -->
				<div class="col-sm-1">
					<?php if (check_privilege('document', 'edit')){ ?> 
							<span id="" ng-click="Updatedoc()" title="Edit" class="cursor"><i class="ion-compose  text-muted"></i></span>&nbsp;
					<?php } 
						if(check_privilege('document', 'delete')){
					?>
						<span  id="" onclick="deletematerial('<?php echo $result['document_id']; ?>')" class="cursor"><i class="ion-trash-b text-muted"></i></span>
					<?php  } ?>
				</div>
			</div>
		</md-toolbar>
	<md-content ng-show="!ticketsLoader" layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
			
				<div class="ciuis-ticket-fieldgroup col-sm-6">
				  <div class="ticket-label"><?php echo 'Type' ?></div>
				  <div class="ticket-data" ><?= ($result['status'] =='on')?'Public':'Confidential'; ?></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" >
				  <div class="ticket-label"><?php echo 'Category' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['doc_cat_name']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6">
				  <div class="ticket-label"><?php echo 'Title' ?></div>
				  <div class="ticket-data"  ng-bind="'<?php echo $result['name']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" >
				  <div class="ticket-label"><?php echo 'Expiry Date' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo date("d-m-Y H:i:s A",strtotime($result['expiry_date'])); ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['remind_before'] ?>'!=''">
				  <div class="ticket-label"><?php echo 'Remind Before' ?></div>
				  <div class="ticket-data" ><?php echo $result['remind_before'] ?> <?php echo $result['reminder_type'] ?> </div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['repeat_interval'] ?>'=='1'">
				  <div class="ticket-label"><?php echo 'Repeat Interval' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['interval_type']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['remind_staff'] ?>'=='1'">
				  <div class="ticket-label"><?php echo 'Remind of Staff' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['staffname']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['company_name'] ?>'!=''">
				  <div class="ticket-label"><?php echo 'Authorised Company Name' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['company_name'] ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['email'] ?>'!=''">
				  <div class="ticket-label"><?php echo 'Email' ?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['email']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['contact_person'] ?>'!=''">
				  <div class="ticket-label"><?php echo lang('Contact Person')?></div>
				  <div class="ticket-data" ng-bind="'<?php echo $result['contact_person']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6" ng-show="'<?php echo $result['contact_number'] ?>'!=''">
					<div class="ticket-label"><?php echo lang('Contact Number')?></div>
					<div class="ticket-data" ng-bind="'<?php echo $result['contact_number']; ?>'"></div>
				</div>
				<div class="ciuis-ticket-fieldgroup col-sm-6">
					<div class="ticket-label"><?php echo lang('Created Date')?></div>
					<div class="ticket-data" ng-bind="'<?php echo date("d-m-Y",strtotime($result['created'])); ?>'"></div>
				</div>
			
			<?php// } ?> 
		</md-content>
		<div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-body">
						<div id="update_details"></div>		  
					</div>
				</div>
			</div>
		</div>
		<!---Start Update Document modal----->
		<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
					<h2 flex md-truncate><?php echo lang('Update') ?></h2>
				</div>
			</md-toolbar>
			<md-content layout-padding="">
				<md-tabs md-dynamic-height md-border-bottom>
					<?php if($task['type'] == 'business') { ?>
					<md-tab label="<?php echo lang('Business') ?>">
						<md-content class="bg-white" layout-padding ng-cloak>
							<form action="<?php echo base_url('document/updateb/'.$result['document_id'])?>" method="post" id="formid" enctype="multipart/form-data">
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-sm>
										<label><?php echo lang('company')?>*</label>
										<input  name="cname"  value="<?php echo $task["cname"];?> ">
									</md-input-container>
									<md-input-container class="md-block" flex-gt-sm>
										<label><?php echo lang('email')?></label>
										<input  name="cemail"  value="<?php echo $task["cname"];?> ">
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-sm>
										<label><?php echo lang('contact').' '.lang('person')?></label>
										<input  name="cperson" value="<?php echo $task["cperson"];?> ">
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
										<label><?php echo lang('keyword / comment') ?></label>
										<textarea  name="keyword_content" rows="3"><?php echo $task['keyword_content'];?></textarea>
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
										<label><?php echo lang('address') ?></label>
										<textarea  name="address" rows="3"><?php echo $task['address'];?></textarea>
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
										<label><?php //echo lang('Upload file') ?></label>
										<input type="file" name="files[]" id="chooseFile" value="" multiple>
									</md-input-container>
								</div>
								<div class="form-group col-md-12">
									<div class="field_wrapper row field_wrapper0">
									<?php if(!empty($contact_numbers)){$p=1;foreach($contact_numbers as $eachcontact){?>
										<div class="form-group col-md-9">
										<!--<input id="phone" type="tel" name="number[]">-->
											<span id="valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
											<span id="error-msg<?php print $p;?>" class="hide"></span>
											<input type="hidden" id="calling_code<?php print $p;?>" name="countrycode[]" value="<?php print $eachcontact['contact_country_code'];?>"/>
											<input type="tel" id="phone<?php print $p;?>" name="point_contact_number[]" value="<?php print '+'.$eachcontact['contact_country_code'].$eachcontact['contact_number'];?>">
										</div>
										<div class="form-group col-md-3">
											<a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>
										</div>
									<script type="text/javascript">
										setTimeout(function(){
											allshowtel('<?php print $p;?>');
										},1000);
									</script>
									<?php $p++;}}?>
									</div>
									<div class="form-group col-md-3">
											<label for="inputZip">Add More</label>
											<a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
									</div>
								</div>
								<button type="submit" class="btn btn-report" >Update</button>
							</form>
						</md-content>
					</md-tab>
					<?php  } if($task['type'] == 'person') { ?>
					<md-tab label="<?php echo lang('person') ?>">
						<md-content class="bg-white" layout-padding ng-cloak>
							<form action="<?php echo base_url('document/update/'.$result['document_id'])?>" method="post" id="formid" enctype="multipart/form-data">
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-sm>
										<label><?php echo lang('email')?></label>
										<input  name="cemail"   value="<?php echo $task['cemail'];?>">
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-sm>
										<label><?php echo lang('contact').' '.lang('person')?></label>
										<input name="cperson"  value="<?php echo $task['cperson'];?>">
									</md-input-container>
								</div> 
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
									  <label><?php echo lang('keyword / comment') ?></label>
									  <textarea  name="keyword_content" rows="3"><?php echo $task['keyword_content'];?></textarea>
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
										<label><?php echo lang('address') ?></label>
										<textarea  name="address" rows="3"><?php echo $task['address'];?></textarea>
									</md-input-container>
								</div>
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-xs>
										<label><?php //echo lang('Upload file') ?></label>
										<input type="file" name="files[]" id="chooseFile" value="" multiple>
									</md-input-container>
								</div>
								<div class="form-group col-md-12">
									<div class="field_wrapper row field_wrapper1">
										<?php if(!empty($contact_numbers)){$p=1;foreach($contact_numbers as $eachcontact){?>
											<div class="form-group col-md-9">
												<span id="person_valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
												<span id="person_error-msg<?php print $p;?>" class="hide"></span>
												<input type="hidden" id="person_calling_code<?php print $p;?>" name="person_countrycode[]" value="<?php print $eachcontact['contact_country_code'];?>"/>
												<input type="tel" id="person_phone<?php print $p;?>" name="person_point_contact_number[]" value="<?php print '+'.$eachcontact['contact_country_code'].$eachcontact['contact_number'];?>">
											</div>  
											<div class="form-group col-md-3">  
												<label for="inputZip"></label>  
												<a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>
											</div>
											<script type="text/javascript">
												setTimeout(function(){
													allshowtel1('<?php print $p;?>');
												},1000);
											</script>
										<?php $p++;}}?>
									</div>
									<div class="form-group col-md-3">
										<label for="inputZip">Add More</label>
										<a href="javascript:void(0);" class="add_button1" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
									</div>
								</div>
								<button type="submit" class="btn btn-report" >Update</button>
							</form>
						</md-content>
					</md-tab>
						<?php } ?>
	</md-tabs>
   
			</md-content>
  </md-siFilesdenav>

  </div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
	   <md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
			  <md-icon><i class="ion-document text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo lang('files') ?></h2>
	<?php if (check_privilege('document', 'edit')) { ?> 
			  <md-button ng-click="UploadFileDoc()"  class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
				<md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
				<md-icon class="ion-android-add-circle text-success"></md-icon>
			  </md-button>
			<?php } ?>
			
		  </div>
		  
		</md-toolbar>
		
		<div ng-show="documentFiles" layout-align="center center" class="text-center" id="circular_loader">
		  <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
		  <p style="font-size: 15px;margin-bottom: 5%;">
			<span><?php echo lang('please_wait') ?> <br>
			<small><strong><?php echo lang('loading'). ' Contact Fles...' ?></strong></small></span>
		  </p>
		</div>
		<md-content class="bg-white" ng-show="!documentFiles">
			<!--- <?php  $passport_doc = explode(",", $result["documents"]);  
			 $ext = ''; 
			   foreach ($passport_doc as $key => $pass_value) { ?>
			   <ul>
			  <div class="md-list-item-text image-preview">
			<?php
				 //echo $pass_value;
				  if($pass_value != '') {  
				  $ext =  substr($pass_value, strrpos($pass_value, '.' )+1);  ?>
			  <div class="row">
				   <?php  if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
					   if($ext=='pdf'){ ?>

			<a href='#about' onclick=show_post_pdf(<?php echo $pass_value; ?>) data-toggle='modal' data-image=<?php echo $pass_value; ?> id='editidpdf<?php echo $pass_value;?>'></a>
					<?php   }else{ ?>
					  <a class='btn btn-success' href='uploads/images/$pass_value'  target='_new'><i class='ion-clipboard'></i></a>
				<?php	    }
				   
				 }  else {  ?>
			  <a href='#about'  onclick=show_post(<?php echo $pass_value;?>) data-toggle='modal'  data-image=<?php echo $pass_value;?> id='editid<?php echo $pass_value;?>'></a>
				 <?php   } ?> 
					<li><?php echo $pass_value;?>
		
			   <!-- <a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name(<?php //echo $pass_value;?>,<?php //echo $result['document_id'] ?>);><span class="glyphicon glyphicon-remove"></span></a> --
			
				 <?php if (check_privilege('contacts', 'delete')) { ?> 
				<md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
			  <?php } ?>
			  </li>
				 </div>
				 
				 <?php
				   
					 
				 } ?>
				 </div>
				 
		 
			</ul><?php } ?>
			</div> --->
			 <md-list-item class="md-2-line" ng-repeat="file in files1 | pagination : currentPage*itemsPerPage | limitTo: 4">
			  <div class="md-list-item-text image-preview">
				<a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFiledoc(file.sn, image)">
				  <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
				  <img src="{{file.path}}">
				</a>
				<a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('document/download/{{file.id}}');?>">
				  <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
				  <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
				</a>
				<a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('document/download/{{file.id}}');?>">
				  <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
				  <img src="<?php echo base_url('assets/img/file_icon.png');?>">
				</a>
				<a ng-if="file.type == 'pdf'" class="cursor" ng-click="ViewPdfFiledoc($index, image)">
				
				 <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
				  <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
				</a>
			  </div>
			  <div class="md-list-item-text">
				<a class="cursor" ng-href="<?php echo base_url('document/download/{{file.id}}');?>">
				  <h3 class="link" ng-bind="file.file_name"></h3>
				</a>
			  </div>
			  <?php if (check_privilege('document', 'delete')) { ?> 
				<md-icon  ng-click='DeleteDocFile(file.id)' class="ion-trash-b cursor"></md-icon>
			  <?php } ?>
			  <md-divider></md-divider>
			</md-list-item>
			 <div ng-show="!files1.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
		  </md-list>
		  <div ng-show="files1.length>6 && !documentFiles" class="pagination-div" ng-cloak>
			<ul class="pagination">
			  <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
			  <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
			  <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
			</ul>
		  </div>
		  
		</md-content>	
	</div> <br>
	<div class="main-content col-xs-12 col-md-12 col-lg-3 md-pl-0 pull-right" style="margin-top: 10px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
					<md-icon><i class="ion-document text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('History') ?></h2>
			</div>
		
		
		<div class="ciuis-activity-line col-md-12">
			<ul class="ciuis-activity-timeline">
				<li ng-repeat="log in logs | limitTo: LogLimit" class="ciuis-activity-detail">
					<div class="ciuis-activity-title" ng-bind="log.date"></div>
					<div class="ciuis-activity-detail-body">
						<div ng-bind-html="log.detail|trustAsHtml"></div>
						<div style="margin-right: 15px; border-radius: 3px; background: transparent; color: #2f3239; font-weight: 400;" class="pull-right label label-default">
							<small class="log-date"><i class="ion-android-time"></i> <span ng-bind="log.logdate | date : 'MMM d, y h:mm:ss a'"></span></small>
						</div>
					</div>
				</li>
				<load-more></load-more>
			</ul>
		</div>
		</md-toolbar>
	</div>	
 <!----<div class="col-sm-4 pull-right">
    <?php echo form_open_multipart('document/add_file/'.$result['document_id'],array("class"=>"form-horizontal","enctype"=>"multipart/form-data","method"=>"post","onsubmit"=>" $('#loader-wrapper').show();")); ?>
	<input type="file" name="file_name[]" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,.ppt,.pptx,.txt,.pdf" multiple>
		<button type="submit" class="btn btn-success" ng-disabled="uploading == true">
			<span ng-hide="uploading == true"><?php echo lang('upload');?></span>
			<md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</button>
    <?php echo form_close(); ?><br>
   </div>--->
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Updatedoc" ng-cloak style="width: 450px;">
		<form id="myForm" method="post" action="<?php echo base_url('document/Update');?>" enctype="multipart/form-data" onsubmit="return Validation()">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
					<h2 flex md-truncate><?php echo lang('Update') ?></h2>
				</div>
			</md-toolbar>  
			<md-content>
				<md-content layout-padding>
				<input type="hidden" name="material_id" id="material_id"  value="<?= $result["document_id"]; ?>" >
				<div >           
					<input type="radio" id="switch" name="status" value="on" <?=($result["status"] =='on')?'checked':''; ?> > <label>Public</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
					<input type="radio" id="switch" name="status" value="off" <?=($result["status"] =='off')?'checked':''; ?>> <label>Confidential</label> 
					<!-- <label for="switch">Toggle</label> -->
				</div>
				<div class="form-group">
					<label for="category">Category</label>
					<select class="form-control" id="category" name="category" required>
						<option value=""> Select..</option>
						<?php if(isset($categories)){
							foreach($categories as $eachCat){
								$selected='';
								if($result["category"] == $eachCat['doc_cat_id']){
									  $selected = "selected";
								}
								?>
							<option value="<?php print $eachCat['doc_cat_id'];?>" <?=  $selected;?> ><?php print $eachCat['doc_cat_name'];?></option>
							<?php }?>
						<?php }?>
					</select>
				</div>
				<div class="form-group code">
					<label for="exampleInputPassword1">Title</label>
					<input type="text" class="form-control" id="name" placeholder="Title" name="name" value="<?= $result["name"]; ?>" required>
				</div><br>
				<md-input-container class="md-block">
					<label for=""><b>Expiry Date/Remind Date</b></label>
					<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" name="expiry_date" required show-todays-date="" minutes="true" min-date="date"show-icon="true" ng-model="expiry_date" format="DD-MM-YYYY hh:mm a" class=" dtp-no-msclear dtp-input md-input" >
				</md-input-container>
				<div class="form-group">
					<label for="exampleInputPassword1">Remind Before</label>
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" id="remind_before" placeholder="Remind Before" name="remind_before" value="<?= $result["remind_before"]; ?>" required>
						</div>
						<div class="col-sm-6">
							<select class="form-control" id="reminder_type" name="reminder_type" required>
								<option value="Minute" <?= ($result["reminder_type"]=='Minute')?'selected':''; ?> > Minute(S)</option>
								<option value="Hours" <?= ($result["reminder_type"]=='Hours')?'selected':''; ?> > Hours</option>
								<option value="Days" <?= ($result["reminder_type"]=='Days')?'selected':''; ?>> Days</option>
								
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row" >
						<label class="col-sm-8" for="exampleInputPassword1">Repeat Interval</label>
						<div class="switchToggle col-sm-4">
							<input type="checkbox" id="switchrepeat" ng-model='checkStatusinterval' ng-click='check_status_interval(checkStatusinterval)' name="checkinterval" ng-init='checkStatusinterval= repeat_interval ==1 ? true : false' >
							<label for="switchrepeat">Toggle</label>
						</div>
					</div><br>
					<div class="col-sm-12" ng-show="repeatinerval">
						<input type="button" id="weekly" ng-model='weekly' value="Weekly" class="btn btn-default" style="border: 1px solid;padding: 0px 14px;" ng-click="setinterval('Weekly')" ng-class="{toBold: setBold=='Weekly'}" >&nbsp;&nbsp;
						<input type="hidden" name="intervalvalue1" id="weeklynew" value="">
						
						<input type="button" id="Monthly" ng-model='Monthly' value="Monthly" class="btn btn-default" style="border: 1px solid;padding: 0px 14px;" ng-click="setinterval('Monthly')" ng-class="{toBold: setBold=='Monthly'}"   >&nbsp;&nbsp;
						<input type="hidden" id="Monthlynew" name="intervalvalue2" value="">
						
						<input type="button" id="Quarterly" ng-model='Quarterly' value="Quarterly" class="btn btn-default" style="border: 1px solid;padding: 0px 14px;"  ng-click="setinterval('Quarterly')" ng-class="{toBold: setBold=='Quarterly'}"  >&nbsp;&nbsp;
						<input type="hidden" id="Quarterlynew" name="intervalvalue3" value="">
						
						<input type="button" id="Yearly" ng-model='Yearly' value="Yearly" class="btn btn-default" style="border: 1px solid;padding: 0px 14px;" ng-click="setinterval('Yearly')" ng-class="{toBold: setBold=='Yearly'}"  >
						<input type="hidden" id="Yearlynew" name="intervalvalue4" value="">
					</div>
				</div><br>
				<div class="form-group">
					<div class="row" >
						<label class="col-sm-8" for="exampleInputPassword1">Remind of Staff</label>
						<div class="switchToggle1 col-sm-4">
							<input type="checkbox" id="switchremindstaff" ng-model='switchremindstaff' ng-click='check_status_staff(switchremindstaff)' name="checkremind" ng-init='switchremindstaff= remind_staff ==1 ? true : false'  >
							<label for="switchremindstaff">Toggle</label>
						</div>
					</div>
				</div>
				<div class="form-group" ng-show="remindstaff">
					<label for="staff">Staff</label>
					<select class="form-control" id="remind_staff" name="remind_staff" >
						<option value=""> Select..</option>
						<?php if(isset($staff)){
							foreach($staff as $eachCat){
								$selected='';
								if($result["remind_staff_id"] == $eachCat['id']){
									  $selected = "selected";
								}
							?>
							<option value="<?php print $eachCat['id'];?>" <?= $selected;?> ><?php print $eachCat['staffname'];?></option>
							<?php }?>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
					<div class="row" >
						<label class="col-sm-8" for="exampleInputPassword1">Contact Details</label>
						<div class="switchToggle2 col-sm-4">
							<input type="checkbox" id="contactdetails" ng-model='contactdetails' ng-click='ShowContactDetails(contactdetails)'  name="contactdetails" ng-init='contactdetails= contact_details ==1 ? true : false'>
							<label for="contactdetails">Toggle</label>
						</div>
					</div>
				</div>
				<div><hr style="height:2px;border-width:0;color:blue;background-color:black"></div>
				<div ng-show="contactdetailsdiv">
					<div class="form-group">
						<label for="itemname">Authorised Company Name</label>
						<input type="text" class="form-control" id="company_name" placeholder="Authorised Company Name" name="company_name" value="<?= isset($result["company_name"])?$result["company_name"]:''; ?>" >
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Contact Person</label>
						<input id="contact_person" type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?= isset($result["contact_person"])?$result["contact_person"]:''; ?>" >
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Contact Number</label>
						<input type="text" class="form-control" id="contact_number" placeholder="Contact Number" name="contact_number" value="<?= isset($result["contact_number"])?$result["contact_number"]:''; ?>"  >
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Email</label>
						<input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= isset($result["email"])?$result["email"]:''; ?>" >
					</div>
				</div>
				<input type="submit" class="btn btn-success col-md-12" id="setvalue" value="Update">
				</md-content>
			</md-content>
		</form>
		
	</md-sidenav>
</div>

<div class="container">
  <!-- Trigger the modal with a button -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body">
          
			<iframe src="" id="imagepdf" style="width:100%;height:440px;"></iframe>
       
        <div class="modal-footer">
           <div id="buttons" class='col-md-9'></div>
        <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">CANCEL</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script type="text/ng-template" id="addfile-template.html">
	  /* <md-dialog aria-label="options dialog">
	  <?php echo form_open_multipart('document/add_file/'.$result['document_id'],array("class"=>"form-horizontal","enctype"=>"multipart/form-data","method"=>"post","onsubmit"=>" $('#loader-wrapper').show();")); ?>
	  <md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
		<input type="file" required name="file_name[]"  multiple>
	  </md-dialog-content>
	  <md-dialog-actions>
		<span flex></span>
		<md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
		 <button type="submit" class="btn btn-report" ng-disabled="uploading == true">
			<span ng-hide="uploading == true"><?php echo lang('upload');?></span>
			<md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</button>
		<!----<md-button ng-click="uploadDocFile()" class="template-button" ng-disabled="uploading == true">
		  <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
		  <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</md-button>--->
	  </md-dialog-actions>
	  <?php echo form_close(); ?>
	  </md-dialog> */
</script>
<script type="text/ng-template" id="view_image.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>">
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('document', 'delete')) { ?> 
      <md-button ng-click='DeleteDocFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('document/download/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>

<script>

function getExtension(filename) {
    return filename.split('.').pop().toLowerCase();
}
function showmodal(id)
{
	var img=$('#filename'+id+'').val();
	
switch(getExtension(img)) {
        //if .jpg/.gif/.png do something
        case 'jpg': case 'gif': case 'png':
            /* handle */
			$('#imgbox').show();
			$('#pdfframe').hide();
			$('#imgbox').attr("src",img);
			
            break;
        //if .zip/.rar do something else
        case 'zip': case 'rar':
            /* handle */
            break;

        //if .pdf do something else
        case 'pdf':
            /* handle */
			$('#imgbox').hide();
			$('#pdfframe').show();
			
			$('#pdfframe').attr("src",img);
            break;
    }
	$('#myModal').modal("show");
}
  var DocumentID = "<?php echo $result['document_id'];?>";
	var repeat_interval="<?= $result['repeat_interval']?>";
	var interval_type="<?= $result['interval_type']?>";
	var remind_staff="<?= $result['remind_staff']?>";
	var contact_details="<?= $result['contact_details']?>";
	var expiry_date="<?= date('d-m-Y H:i:s',strtotime($result['expiry_date'])); ?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_task = "<?php echo lang('delete_meesage').' '.lang('task')?>";
</script> 


<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<!-- Loader Css -->
<link rel="stylesheet" href="<?=base_url();?>assets/loader.css">
<script type="text/javascript" src="<?php echo base_url('assets/js/document.js') ?>"></script>
<link rel="stylesheet" href="<?=base_url();?>assets/dist/imageuploadify.min.css">
<script type="text/javascript" src="<?php echo base_url('assets/dist/imageuploadify.js') ?>"></script>
<!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/bootstrap-datepicker.min.css'); ?>">
  <!-- datepicker -->
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo base_url('assets/select2/select2.min.js'); ?>"></script>
<!----<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>--->
<script type="text/ng-template" id="history-sidebar.html">
<div  class="hidden-md hidden-sm hidden-xs ciuis-sag-sidebar-xs">
	
</div>
</script>
<script>
	
     $(document).ready(function(){
		$('input[type="file"]').imageuploadify();
 
	   var x = <?php print count($contact_numbers);?>; //Initial field counter is 1
	   
    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper0'); //Input field wrapper
	var wrapper1 = $('.field_wrapper1');
	var addButton1=$('.add_button1'); 
   // var fieldHTML = ' <div class="form-group col-md-4">   <label for="inputZip"> Country Code</label><select name="countrycode[]" style="width: 85px; height: 46px;"> <option value="971">ARE +971</option><?php foreach($countries as $country) { ?> <option value="<?php echo $country["phonecode"]; ?>"><?php echo $country["iso3"] ." +". $country["phonecode"]; ?></option> <?php } ?></select> </div><div class="form-group col-md-5" style = ""> <label for="inputZip"> Contact Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>  <div class="form-group col-md-3">      <label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div><br>'; //New input field html 
 
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="valid-msg'+x+'" class="hide">✓ Valid</span><span id="error-msg'+x+'" class="hide"></span> <input type="hidden" id="calling_code'+x+'" name="countrycode[]"/>    <input type="tel" id="phone'+x+'" name="point_contact_number[]"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper).append(fieldHTML); //Add field html
	
	allshowtel(x);
	
			//allshowtel(x);
        }
    });
	
	
	 $(addButton1).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="person_valid-msg'+x+'" class="hide">✓ Valid</span><span id="person_error-msg'+x+'" class="hide"></span> <input type="hidden" id="person_calling_code'+x+'" name="person_countrycode[]"/>    <input type="tel" id="person_phone'+x+'" name="person_point_contact_number[]"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper1).append(fieldHTML); //Add field html
	 
	allshowtel1(x);
	  
			//allshowtel(x);
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
	
	$(wrapper1).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
});


</script>

	 <script src="<?php echo base_url('build/intel/js/prism.js'); ?>"></script>
	   <script src="<?php echo base_url('build/js/intlTelInput.js'); ?>"></script>
    <script src="<?php //echo base_url('build/intel/js/isValidNumber.js'); ?>"></script>
	
	 <script>
	function allshowtel(str){
		
		var input = document.querySelector("#phone"+str+""),
  errorMsg = document.querySelector("#error-msg"+str+""),
  validMsg = document.querySelector("#valid-msg"+str+"");
  
//  var country = $('#country'+str+'');




// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	separateDialCode : true, 
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
//console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
  //alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
  $('#calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	
	
	function allshowtel1(str){
		
		var input = document.querySelector("#person_phone"+str+""),
  errorMsg = document.querySelector("#person_error-msg"+str+""),
  validMsg = document.querySelector("#person_valid-msg"+str+"");
  
  

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	 separateDialCode : true, 
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
//console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
  //alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
  $('#person_calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	
	
	
	
	function deletematerial(id){
             var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>document/delete_mat",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				window.location.href="<?php echo base_url(); ?>document"
               
            }
          }); 
	     }
	     else{
	         
	        
	     }
        
    }
   
    function update(id){
        //alert(id);
               
           	 $.ajax({
              url : "<?php echo base_url(); ?>document/edit_mat",
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                  //console.log(response)
                  $('#update_details').html(response);
               $("#sidebar-right").modal ("show");
                $('.selectpicker').selectpicker('refresh');
               
               
               
              
                $(function() {
           $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-4" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              $("#exampleModal2").appendTo("body");
            });
         }); 
        var status = $('#switch').is(':checked');
        //alert(status);
        if(status == false){
            
              $("#item_code").prop("disabled", true);
              $("#item_code").removeAttr('required');
             $('.code').hide();
        
        }
        else{
            $('.code').show();
            $("#item_code").removeAttr('disabled');
             $('#item_code').attr('required', 'required');

        }
         function select_switch(){
                   
	   
    if ($('#switch').is(':checked')) {
        
       
         $('.code').show();
         $("#item_code").removeAttr('disabled');

          
    }else{
         
          $("#item_code").prop("disabled", true);
        $('.code').hide();
     
    }

    
} 
       var rd_status = $('#per').is(':checked');
       //alert(rd_status);
       if(rd_status == false){
             $('#percentage').hide();
        
        }
        else{
            $('#percentage').show();
        }
        
        
       var rd_status1 = $('#fix').is(':checked');
        //alert(rd_status1);
        if(rd_status1 == false){
             $('#fixed').hide();
        
        }
        else{
            $('#fixed').show();
        }
        
  	function change_margin(str){
	//	alert(str);
		
	}
	
  
   var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button1'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var val = $('#count').val();
   
   
    var x = val; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
             var fieldHTML = '<div class="row col-md-12" ><div class="form-group col-md-4"><label for="inputZip">Supplier</label>';
             fieldHTML += '<input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="supplier_hidden_id'+x+'" name="supp[newsupplier][]" id="supplier'+x+'" placeholder="Enter Supplier" autocomplete="off"/><input type="hidden" name="supp[supplier][]" id="supplier_hidden_id'+x+'" autocomplete="off" value=""/></div>';
            fieldHTML += '<div class="form-group col-md-4"><label for="exampleInputFile">Ref Code</label><input type="text" name="supp[shortname][]" placeholder="Enter Short Name" id="short-name" title="Short Name" aria-describedby="" class="form-control"></div>';
             fieldHTML +=  '<div class="form-group col-md-3"><label for="exampleInputFile">Price</label><input type="text" name="supp[price][]" placeholder="price" id="price" title="Price" aria-describedby="" class="form-control"></div><a href="javascript:void(0);" class="add_button" title="Add field"></a><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div><br>';
            //New input field html 
            $(wrapper).append(fieldHTML); //Add field html
			
				 $('#supplier'+x).typeahead({
           source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>supplier/get_supplier_list',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						if(data == '0'){
							//alert("fds");
							$('#supplier_hidden_id'+x).val('-1');
						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
      map[state.name] = state;
      states.push(state.name);
    });
    process(states);
                    }
					}
                });  
				
 
    
    },
    matcher: function (item) {
    if (item.toLowerCase().indexOf(this.query.trim().toLowerCase()) != -1) {
    return true;
    }
    },
    sorter: function (items) {
        return items;//items.sort();
    },
    highlighter: function (item) {
        var regex = new RegExp( '(' + this.query + ')', 'gi' );
        return item.replace( regex, "<strong>$1</strong>" );
    },
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
        $(`#${hiddenFieldId}`).val(SelectedCode);
        
        return SelectedCityName;
    },
	
        });
			


			  
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        //e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
		return false;
        x--; //Decrement field counter
    });
         
            }
          });  
	    
    }
    
    
	</script> 