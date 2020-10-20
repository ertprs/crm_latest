<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<div class="ciuis-body-content" ng-controller="Task_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <h2>View Contact</h2>
     <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul>
          <li class="col-md-6 col-xs-6">
            <h5><?php echo lang('Email') ?></h5>
            <strong><?php echo $task['cemail'];?></strong> </li>
	    <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak>
                <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>
	      <!-- <md-button ng-click="Delete()" ng-bind="lang.delete" aria-label="Delete"></md-button> -->
          
        </ul>
      </div>
      <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul>
	<li class="col-md-6 col-xs-6">
            <h5><?php echo lang('Contact Person') ?></h5>
            <strong><?php echo $task['cname']; ?></strong> </li>
          <li class="col-md-6 col-xs-6">
            <h5><?php echo lang('Contact Number') ?></h5>
            <strong><?php echo $task['cnum']; ?></strong> </li>
        </ul>
      </div>
      <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul>
	 <li class="col-md-6 col-xs-6">
	 <h5><?php echo lang('Keyword / Comment') ?></h5>
	<p><strong><?php echo $task['keyword_content'];?></strong></p>
	</li>
         <li class="col-md-6 col-xs-6">
	 <h5><?php echo lang('Address') ?></h5>
	<p><strong><?php echo $task['address'];?></strong></p>
	</li>
        </ul>
      </div>
      <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('Update') ?></h2>
	
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
	
	 
	 	<!--   <div class="alert alert-danger alert-dismissible" id="displayerror"><span id="showerror"></span></div> -->
		   <md-tabs md-dynamic-height md-border-bottom>
             
           <?php if($task['type'] == 'business') { ?>
	 <md-tab label="<?php echo lang('Business') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		  <form action="<?php echo base_url('contacts/updateb/'.$task['person_id'])?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
	  
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('company')?>*</label>
          <input  name="cname" required="" value="<?php echo $task["cname"];?> ">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" required="" value="<?php echo $task["cname"];?> ">
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input  name="cperson" required="" value="<?php echo $task["cperson"];?> ">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').''.lang('number')?></label>
          <input  name="cnum" required="" value="<?php echo $task["cnum"];?> ">
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
      <input type="file" name="userfile" id="chooseFile" required="">
      </md-input-container>
     
      </div>
	   <button type="submit" class="btn btn-report" >Update</button>
	    </form>
    </md-content>
	</md-tab>
	<?php  } if($task['type'] == 'person') { ?>
	 <md-tab label="<?php echo lang('person') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		   <form action="<?php echo base_url('contacts/update/'.$task['person_id'])?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" required=""  value="<?php echo $task['cemail'];?>">
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input name="cperson" required="" value="<?php echo $task['cperson'];?>">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').''.lang('number')?></label>
          <input  name="cnum" required="" value="<?php echo $task['cnum'];?>">
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
      <input type="file" name="userfile" id="chooseFile" required="">
      </md-input-container>
     
      </div>
	  <button type="submit" class="btn btn-report" >Update</button>
	   </form>
    </md-content>
	</md-tab>
	<?php } ?>
	</md-tabs>
   
	       
    </md-content>
  </md-sidenav>

  </div>
     
</div>
<script>
  var TASKID = "<?php echo $task['person_id'];?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_task = "<?php echo lang('delete_meesage').' '.lang('task')?>";
</script> 


<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/tasks.js') ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
