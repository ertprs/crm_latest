<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Task_Controller">
  <div class="main-content container-fluid col-md-9 borderten">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        
        <h2 flex md-truncate><?php echo 'View  Material';?></h2>
          
           <ul class="pull-right" style="margin-left:550px;">
      <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
                <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>

              <a href="<?php echo site_url() ?>material/delete_mat/<?php echo $materials['material_id'] ?>">Delete</a>
          
        </ul>
        
        
       
      </div>
    </md-toolbar>
    <md-content class="bg-white">
	<div></div>
	<div></div>
     
	  <table width="100%">
	  <thead>
		<th colspan="6"><h2 style="background-color:lightblue">Details</h2></th>
	  </thead>
	  <tbody>
	  <tr>
	  <td><b>Item Code:</b><?php echo $materials['item_code'];?></td> 
	  <td><b>Item Name:</b><?php echo $materials['itemname'];?></td>
	   <td><b>Category:</b><?php echo $materials['item_code'];?></td> 
	  </tr>
	  <tr>
	  <td><b>Long Description:</b><?php echo $materials['longdescription'];?></td> 
	  <td><b>Item Description:</b><?php echo nl2br($materials['itemdescription']);?></td>
	   <td><b>Remarks:</b><?php echo $materials['remarks'];?></td> 
	  </tr>
	  <tr>
	  <td><b>Created At:</b><?php echo $materials['created'];?></td> 
	  </tr>
<div class="row"></div>
	  <tr>
	   <table width="80%" align="center">
	  <tr style="background-color:lightgrey">
	  <th><b>Unit</b></th> 
	  <td><b>Cost</b></td>
	  <td><b>Margin Percentage</b></td>
		<td><b>Margin Fixed</b></td>
		<td><b>Last Selling Price</b></td>	  
	  </tr>
	  <tr>
	  <td>Unit</td> 
	  <td><?php echo $materials['cost'];?></td>
	  <td><?php  if($materials['margin_type'] == 'percentage'){ 
				echo $materials['margin_value'];
	  }?></td>
		<td><?php  if($materials['margin_type'] == 'fixed'){ 
				echo $materials['margin_value'];
	  }?></td>
		<td><?php echo $materials['last_selling_price'];?></b></td>	  
	  </tr>
	  </table>
	  </tbody>
	  </table>
    </md-content
	</md-content>
  </div>
  <ciuis-sidebar></ciuis-sidebar>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('Update') ?></h2>
	
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
			<form id="form1" method="post" action="<?php echo base_url('material/create');?>">
  <div class="form-group">
    <label for="category">Category</label>
    <select class="form-control required" id="category" name="category">
<option value=""> Select..</option>
	<?php if(isset($categories)){
		foreach($categories as $eachCat){?>
		<option value="<?php print $eachCat['mat_cat_id'];?>" <?php if($eachCat['mat_cat_id'] == $materials['category']) {  echo 'selected="selected"'; } ?>><?php print $eachCat['mat_cat_name'];?></option>
		<?php }?>
	<?php }?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Item Code</label>
    <input type="text" class="form-control" id="item_code" placeholder="Item Code" name="item_code" value="<?php echo $materials['item_code'];?>">
  </div>
<div class="form-group">
    <label for="itemname">Item Name</label>
    <input type="text" class="form-control required" id="itemname" placeholder="Item Name" name="itemname" value="<?php echo $materials['itemname'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Item Description</label>
	<textarea class="form-control" id="itemdescription" rows="3" name="itemdescription"> <?php echo $materials['itemdescription'];?></textarea>
   
  </div>
  <div class="form-group" style="display:none;">
    <label for="exampleInputPassword1">Long Description</label>
	<textarea class="form-control" id="longdescription" rows="3" name="longdescription"> <?php echo $materials['longdescription'];?></textarea>
   
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Unit Size</label>
     <select class="form-control" id="unittype" name="unittype">

	<?php if(isset($unittypes)){
		foreach($unittypes as $eachUnit){?>
		<option value="<?php print $eachUnit['unit_type_id'];?>" <?php if($eachUnit['unit_type_id'] == $materials['unittype']) { echo 'selected="selected"'; } ?>><?php print $eachUnit['unit_name'];?></option>
		<?php }?>
	<?php }?>
    </select>
  </div>
   <div class="form-group">
  <label class="radio-inline"><input type="radio" name="margin_type" checked value="percentage" onclick="change_margin('percentage');">Percentage</label>
<label class="radio-inline"><input type="radio" name="margin_type" value="fixed" onclick="change_margin('fixed');">Fixed</label>
</div>
  
 <div class="form-group" id="percentage">
    <label for="exampleInputPassword1">Margin / Selling Price Percentage</label>
	 
     <div class="input-group">
    <span class="input-group-addon">%</span>
    <input id="percentage" type="text" class="form-control" name="percentage" placeholder="Margin Percentage">
  </div>
  </div>
   <div class="form-group" id="fixed" style="display:none;">
    <label for="exampleInputPassword1">Margin / Selling Price Fixed</label>
    <input type="text" class="form-control" id="margin_selling_price" placeholder="Margin Fixed" name="margin_selling_price" value="<?php echo $materials['margin_value'];?>">
  </div>
  
  <div class="form-group">
    <label for="exampleInputPassword1">Cost ( AED )</label>
    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="<?php echo $materials['cost'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Last Selling Price</label>
    <input type="text" class="form-control" id="last_selling_price" placeholder="Last Selling Price" name="last_selling_price" value="<?php echo $materials['last_selling_price'];?>">
  </div>
   
  <div class="form-group">
    <label for="exampleInputPassword1">Supplier</label>
	 <div id="div1-wrapper">
          <div id="div1" >   
               <select class="selectpicker required" data-live-search="true" name="supplier" title="Select Supplier" style="min-width: 200px;" data-width="100%" id="supplier" onchange="supplierModal(this.value);" style="margin-bottom:10px;">
   

	<?php if(isset($supplier)){
		foreach($supplier as $eachSupplier){?>
		<option value="<?php print $eachSupplier['supplier_id'];?>"><?php print $eachSupplier['companyname'];?></option>
		<?php }?>
	<?php }?>
    </select>
          </div>
        </div> 
	
	
	<button class="btn btn-sm btn-primary" style="margin-top:10px;float: right;" onclick="addnewsupplier();" type="button">Add New</button>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Remarks</label>
    <input type="text" class="form-control" id="remarks" placeholder="Remarks" name="remarks" value="<?php echo $materials['remarks'];?>">
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Attachment</label>
    <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
  </div>
  <input type="submit" class="btn btn-success col-md-12"  value="Add">
</form>
		   
		</md-content>
		</md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
            class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addreminder') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('datetobenotified') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
            placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date"
            show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('setreminderto'); ?></label>
          <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id"
            style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="reminder_description"
            placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
        </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
            type="submit">
            <?php echo lang('addreminder')?>
          </button>
        </div>
      </md-content>
    </md-content>
	
    </md-content>
  </md-sidenav>
</div>
<script type="text/ng-template" id="generate-proposal.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding class="text-center">
		<md-content class="bg-white" layout-padding>
			<h2 class="md-title" ng-hide="PDFCreating == true"><?php echo lang('generate_proposal_pdf') ?></h2>
			<h2 class="md-title" ng-if="PDFCreating == true"><?php echo lang('report_generating') ?></h2>
			<span ng-hide="PDFCreating == false"><?php echo lang('generate_pdf_msg') ?></span><br><br>
			<span ng-if="PDFCreating == false"><?php echo lang('generate_pdf_last_msg') ?></span><br><br>
			<img ng-if="PDFCreating == true" ng-src="<?php echo base_url('assets/img/loading_time.gif') ?>" alt="">
			<a ng-if="PDFCreating == false" href="<?php echo base_url('proposals/download_pdf/'.$proposals['id'].'') ?>" alt=""><img  width="30%" ng-src="<?php echo base_url('assets/img/download_pdf.png') ?>" alt=""></a>
		</md-content>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button class="text-success" ng-if="PDFCreating == false" href="<?php echo base_url('proposals/download_pdf/'.$proposals['id'].'') ?>">
      <?php echo lang('download') ?>
    </md-button>
    <md-button class="text-success" ng-hide="PDFCreating == false" ng-click="CreatePDF()"><?php echo lang('create') ?>!</md-button>
    <md-button class="text-danger" ng-click="CloseModal()"><?php echo lang('cancel') ?>!</md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
<script>
   var TASKID = "<?php echo $materials['material_id'];?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_task = "<?php echo lang('delete_meesage').' '.lang('task')?>";
</script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script src="<?php echo base_url('assets/js/tasks.js'); ?>"></script>