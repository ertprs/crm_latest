<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<style>
.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #26c281 !important;
		outline: 0;
		color:#fff !important;
	}
	
	select.ng-invalid {
		border:1px solid red !important;
	}
	
	md-input-container label:not(.md-container-ignore) {
		font-weight:bold;
		bottom:165% !important;
	}
	
	.quoteLabel {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		width: 100%;
		-webkit-box-ordinal-group: 2;
		-webkit-order: 1;
		order: 1;
		pointer-events: none;
		-webkit-font-smoothing: antialiased;
		padding-left: 3px;
		padding-right: 0;
		z-index: 1;
		-webkit-transform: translate3d(0, 28px, 0) scale(1);
		transform: translate3d(0, 28px, 0) scale(1);
		-webkit-transition: -webkit-transform .4s cubic-bezier(.25, .8, .25, 1);
		transition: -webkit-transform .4s cubic-bezier(.25, .8, .25, 1);
		transition: transform .4s cubic-bezier(.25, .8, .25, 1);
		transition: transform .4s cubic-bezier(.25, .8, .25, 1), -webkit-transform .4s cubic-bezier(.25, .8, .25, 1);
		max-width: 100%;
		-webkit-transform-origin: left top;
		transform-origin: left top;
		text-transform: uppercase;
	}
	
	.scrollableTxtarea {
		margin-top: 20px !important;
		min-height:50px;
		max-height:250px;
		overflow-y: hidden;
	}
	
	.ck-editor__editable{
		height:450px !important;
	}
</style>
<div class="ciuis-body-content lead-single quote-single create-page" ng-controller="QuoteRequest_Controller">
<div class="main-content container-fluid col-md-9 borderten">
	<form  action="<?php echo base_url('quoterequest/create') ?>" method="post" enctype="multipart/form-data" onsubmit="return checkProject()">
		<md-toolbar class="toolbar-white  lead-user">
			<div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
			  <md-icon><i class="ico-ciuis-invoices" style="color: #fff"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo lang('quoterequest'); ?></h2>
			<md-button ng-href="<?php echo base_url('quoterequest')?>" class="md-icon-button" aria-label="Save" ng-cloak>
				<md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
				<md-icon><i class="ion-close-circled"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar> 
		<md-content class="bg-white orders-data" layout-padding ng-cloak style="height:800px;">
		    <div layout-gt-xs="row"><div class="col-md-12" style="text-align:right;"><span id="email_result"></span></div></div>
			<div layout-gt-xs="row"> 
				<md-input-container class="md-block" flex-gt-xs>
					 <input id="projectName"  name="project" class="form-control" placeholder="Enter  Project Name" required="" ng-model="project">
				</md-input-container>
			</div>
			<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-xs>
					<label>Customer</label>
					<select class="form-control client selectpicker custDropdown" data-live-search="true" name="customer" id="customer" ng-model="customer" required="" ng-change="ChangeCustomer(customer)">
						<option value="">Search or Add Customer</option>
						<option ng-repeat="customer in customers" value="{{customer.id}}">
							{{customer.company}}
						</option>
					</select>
				</md-input-container>
				<md-input-container class="md-block" flex-gt-sm>
					<label>Contact</label>
					<div id="client_contact_id">
						<select class="form-control selectpicker contact" data-live-search="true" name="client_contact_id" id="client_contact_id" required="">
						</select>
					</div>
					<input type="hidden" name="main_sales_team_id" id="salesteamid" value="0"/>
				</md-input-container>
				<!--<md-input-container class="md-block" flex-gt-sm>
					<label>Sales Team</label>
					<div id="salesteam">
						<select  class="form-control selectpicker" required="" name="salesteam">
							<option value="">Select Sales Team
							</option>
						</select>
					</div>
					
				</md-input-container>-->
			</div>
			<!--<div layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-sm>
				<label><?php echo lang('quotedetails')?></label>
				<input ng-model="quotedetails" name="quotedetails" required >
			  </md-input-container>
			</div>-->
			<div layout-gt-xs="row">
				<div class="col-sm-12">
					<label class="quoteLabel"><?php echo lang('quotedetails')?></label>
					
						<textarea class="min_input_width" ng-model="quotedetails" name="quotedetails"  id="quotedetails"></textarea>
					
				</div>
			</div>
			<?php if (check_privilege('quoterequest', 'create')) { ?>
			<div class="col-md-5"></div>
			<div layout-gt-xs="row">
				<button name="send" Value="Send" class="btn btn-success"><?php echo lang('request');?></button>
			</div>
			<?php } ?>
		</md-content>
		</form>
</div>
<!--<ciuis-sidebar></ciuis-sidebar>-->
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 right-sidebar">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-document" style="color: #fff"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><strong>Attachmenst</strong></h2>
		 <?php if (check_privilege('quoterequest', 'edit')) { ?> 
          <md-button ng-click="UploadFile()" " class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
        <?php } ?>
       
      </div>
    </md-toolbar>
	<div ng-show="quoterequestFiles" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
        <small><strong><?php echo lang('loading'). ' Estimation Files...' ?></strong></small></span>
      </p>
    </div>
	<md-content class="bg-white" ng-show="!quoterequestFiles">
      <md-list flex ng-cloak>
        <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
          <div class="md-list-item-text image-preview">
            <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
              <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="{{file.path}}">
            </a>
            <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('quoterequest/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
            </a>
            <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('quoterequest/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
            <a ng-if="file.type == 'pdf'" class="cursor" ng-click="ViewPdfFile($index, image)">
			
             <!-- <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>-->
			 <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('quoterequest/download_file/{{file.id}}');?>">
              <h3 class="link" ng-bind="file.file_name"></h3>
            </a>
          </div>
          <?php if (check_privilege('quoterequest', 'delete')) { ?> 
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
        <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
      </md-list>
      <div ng-show="files.length>6 && !projectFiles" class="pagination-div" ng-cloak>
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </md-content>
	<!--<md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-ios-people text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate>Approved By</h2>
       
      </div>
    </md-toolbar>-->
 </div>
</div>
<!--Script--->

 <script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('quoterequest/add_file/',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
	 <input type="file" id="file1" name="file" multiple ng-files="getTheFiles($files)" required />
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
	 <md-button ng-click="uploadFiles()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="view_image.html" >
  <md-dialog aria-label="options dialog"  class="dialog-picture">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>" >
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('quoterequest', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('quoterequest/download_file/')?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>

<script type="text/ng-template" id="view_pdf.html">
  <md-dialog aria-label="options dialog" style='width:100% !important;'>
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <iframe src="<?php echo $path ?>" style='width:100%;height:600px;'></iframe>
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('quoterequest', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('quoterequest/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/quoterequest.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$('#projectName').on('change',function(){  
   var projectName = $('#projectName').val();  
   if(projectName != ''){  
		$.ajax({  
			 url:"<?php echo base_url(); ?>Quoterequest/check_project_avalibility",  
			 method:"POST",  
			 data:{projectName:projectName},  
			 success:function(data){  
				  $('#email_result').html(data);  
			 }  
		});  
   }
});

ClassicEditor
.create( document.querySelector( '#quotedetails'))
.catch( error => {
	console.error( error );
} );

function checkProject(){
   var projectName = $('#projectName').val(); 
   $.ajaxSetup({async:false});  
   if(projectName != ''){  
		$.ajax({  
			 url:"<?php echo base_url(); ?>Quoterequest/check_project_submit",  
			 method:"POST",
			 async:false,			 
			 data:{projectName:projectName},  
			 success:function(res){
				var result = JSON.parse(res);
				stat = result.message;
			 }  
		});  
   }else{
	   return false;
   }
  if(stat=='fail'){	
	return false;
  }else{
	return true;
  }
  $.ajaxSetup({async:true});
}
</script>