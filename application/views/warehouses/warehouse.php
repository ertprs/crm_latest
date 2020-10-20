<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Warehouse_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 class="md-pl-10" flex md-truncate ><?php echo $vendors['warehouse_name'];?></h2>
				<?php if (check_privilege('warehouses', 'edit')) { ?>					
				<md-button ng-click="Update()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
					<md-icon class="mdi mdi-edit"></md-icon>
				</md-button>
				<?php } if (check_privilege('warehouses', 'delete')) { ?>
				<md-button ng-click="Delete()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
					<md-icon class="ion-trash-b"></md-icon>
				</md-button>
				<?php } ?>					
			</div>
		</md-toolbar>
		<div ng-show="vendorsLoader" layout-align="center center" class="text-center" id="circular_loader">
			<md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
			<p style="font-size: 15px;margin-bottom: 5%;">
				<span>
					<?php echo lang('please_wait') ?> <br>
					<small><strong><?php echo lang('loading'). ' '. lang('warehouse').'...' ?></strong></small>
				</span>
			</p>
		</div>
		<section ng-show="!vendorsLoader"  layout="row" flex>
			<md-sidenav class="md-sidenav-left" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')" style="z-index:0" ng-cloak>
				<md-subheader class="md-primary" style="background-color: white; border-bottom: 1px #e0e0e0 solid; padding-bottom: 2px; border-right: 1px #f3f3f3 solid;">
					<?php //echo lang('informations');?>
				</md-subheader>
				<md-content class="bg-white" style="border-right:1px solid #e0e0e0;">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
				<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							<md-list-item>
									<md-icon class="ion-earth"></md-icon>
									<p><?php echo 'Country'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'dsdsd'; ?></p>
									
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-map"></md-icon>
									<p><?php echo 'State'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'dsdsd'; ?></p>
									
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-city"></md-icon>
									<p><?php echo 'City'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['city']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-markunread-mailbox"></md-icon>
									<p><?php echo 'Post Code'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['post_code']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-android-call"></md-icon>
									<p><?php echo 'Phone'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['phone']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								
								<md-list-item>
									<md-icon class="ion-ios-home"></md-icon>
									<p><?php echo 'Address'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						        <?php echo $vendors['address']; ?></p>
								</md-list-item>
								
								
								
							</md-list>
				</md-content>
			</md-sidenav>
				<md-content class="bg-white information-section-show" flex>
				<!-- <md-tabs md-dynamic-height md-border-bottom>
					<md-tab label="<?php //echo lang('');?>"> -->
						<md-content class="md-padding bg-white">
						    </md-content>
						    </md-content>
			<md-content class="bg-white information-section-show" flex>
				<!-- <md-tabs md-dynamic-height md-border-bottom>
					<md-tab label="<?php //echo lang('');?>"> -->
						<md-content class="md-padding bg-white">
							<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							<md-list-item>
									<md-icon class="ion-earth"></md-icon>
									<p><?php echo 'Country'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'dsdsd'; ?></p>
									
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-map"></md-icon>
									<p><?php echo 'State'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'dsdsd'; ?></p>
									
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-city"></md-icon>
									<p><?php echo 'City'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['city']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-markunread-mailbox"></md-icon>
									<p><?php echo 'Post Code'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['post_code']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-android-call"></md-icon>
									<p><?php echo 'Phone'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vendors['phone']; ?></p>
								</md-list-item>
								<md-divider></md-divider>
								
								<md-list-item>
									<md-icon class="ion-ios-home"></md-icon>
									<p><?php echo 'Address'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						        <?php echo $vendors['address']; ?></p>
								</md-list-item>
								
								
								
							</md-list>
						</md-content>
					<!-- </md-tab>
					
				</md-tabs> -->
			</md-content>
		</section>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
					class="ion-android-arrow-forward"></i> </md-button>
					<md-truncate flex><?php echo lang('update') ?></md-truncate>
					
				</div>
			</md-toolbar>
		<md-content layout-padding="">
			<md-content layout-padding>
				<md-input-container class="md-block">
					<label>WAREHOUSE NAME</label>
					
					<input name="warehouse_name" ng-model="vendor.name" placeholder="Warehouse Name" required>
				</md-input-container>
				
				<md-input-container class="md-block">
					<label>PHONE</label>
					<input name="phone" ng-model="vendor.phone" placeholder="Phone">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-change="getStates(vendor.country_id)" ng-model="vendor.country_id" name="country_id" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="vendor.state" name="state" style="min-width: 200px;">
						<md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="vendor.city" placeholder="City">
				</md-input-container>
				
				<md-input-container class="md-block">
					<label><?php echo 'POST CODE'; ?></label>
					<input name="zipcode" ng-model="vendor.post_code" placeholder="Post Code">
				</md-input-container>
				
				<md-input-container class="md-block">
					<label>ADDRESS</label>
					<textarea ng-model="vendor.address" name="address" md-maxlength="500" rows="3" md-select-on-focus placeholder="Address"></textarea>
				</md-input-container>
				<!--
				<md-input-container class="md-block">
					<label>Notes</label>
					<textarea ng-model="vendor.notes" name="notes" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>-->
				<p id="vendorsError" style="color: red"></p>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
					<md-button ng-click="UpdateVendor()" class="md-raised md-primary btn-report block-button" ng-disabled="savingCustomer == true">
						<span ng-hide="savingCustomer == true"><?php echo lang('update');?></span>
						<md-progress-circular class="white" ng-show="savingCustomer == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					</md-button>
					<br/><br/><br/><br/>
				</section>	
			</md-content>
		</md-content>
	</md-sidenav>
</div>
<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('vendors/add_file/'.$vendors['id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="file_name" file-model="project_file">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
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
    <?php if (check_privilege('vendors', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('projects/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script>
	var lang={};
	var VENDORRID = "<?php echo $vendors['warehouse_id'];?>";
	lang.doIt='<?php echo lang('doIt')?>';
	lang.cancel='<?php echo lang('cancel')?>';
    lang.attention='<?php echo lang('attention')?>';
    lang.delete_vendor="<?php echo lang('delete_warehouse')?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url('assets/js/warehouses.js'); ?>"></script>
<script>
function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;

 for(var i=0;i<total_file;i++)
 {
 //console.log(event.target.files[i]['name']);
 //$('.loder').html('<img src="<?php print base_url();?>front/LoaderIcon.gif">');
 var file_data = event.target.files[i];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
		
  $.ajax({
            url: '<?php print base_url();?>supplier/form_add_image',
			 type        : 'post',
            cache       : false,
        contentType : false,
        processData : false,
        data        : form_data,
            success: function(response){
                if(response != 0){
					if(response.error){
					$('.error').show();
					$('.error').html(response.error);
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					}else{
					//$('.loder').html('');
                    //$("#img").attr("src",response); 
                    //$(".preview img").show(); // Display image element
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					$('#image_preview').append("<div class='col-md-3' id='clients-edit-wrapper'><div class='close-wrapper'> <a  class='close-div text-danger' style='cursor:pointer;'>Delete</a></div><input type='hidden' name='test_image[]' value='"+response.image_name+"' ng-model='customer.test_image' id='test_image' class='imagename'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
					}
                }else{
                    alert('file not uploaded');
                }
            },
        });  
 
 }
}

$(document).on('click', '.close-div', function(){
	
    $(this).closest("#clients-edit-wrapper").remove();
});

</script>