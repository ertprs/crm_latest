<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Contacts_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
    <div class="panel-heading"> <strong><?php echo lang('OverAll Contacts'); ?></strong> <span class="panel-subtitle"><?php //echo lang('tasksituationsdesc'); ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="tasks.length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{ tasks.length / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('All'); ?></span> </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{type:'business'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{type:'business'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('Companies'); ?></span> </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{type:'person'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{type:'person'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('Persons'); ?></span> </div>
     
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
    <md-toolbar class="bg-white toolbar-white">
      <div class="md-toolbar-tools bg-white">
        <h2 flex md-truncate class="text-bold"><?php echo lang('contacts'); ?> <small>(<span ng-bind="tasks.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('View Add and Edit Contact'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contacts').' '.lang('name')   ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('search').' '.lang('contacts') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter').' '.lang('contacts') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('tasks', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('new').' '.lang('contact') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content>
      <div ng-show="taskLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="25"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading'). ' '. lang('contacts').'...' ?></strong></small></span>
        </p>
      </div>
      <div ng-show="!taskLoader" class="bg-white" style="padding: unset;">
        <md-table-container ng-show="tasks.length > 0">
          <table md-table  md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
	      <th md-column md-order-by="id"><span><?php echo 'S.No'; ?></span></th>
                <th md-column md-order-by="name"><span><?php echo 'Company Name'; ?></span></th>
                <th md-column md-order-by="address"><span><?php echo 'Company Address'; ?></span></th>
				
                <th md-column md-order-by="cperson"><span><?php echo 'Contact Person'; ?></span></th>
                <th md-column md-order-by="cnum"><span><?php echo 'Contact Number'; ?></span></th>
				<th md-column md-order-by="cemail"><span><?php echo 'Email' ?></span></th>
				<th ><span><?php echo 'Keyword Or Comments'?></span></th>
				
				<th ><span><?php echo 'Created On'?></span></th>
              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="task in tasks | orderBy: task_list.order | limitTo: task_list.limit : (task_list.page -1) * task_list.limit | filter: task_search | filter: FilteredData" class="cursor" ng-click="goToLink('contacts/task/'+task.id)">
                 <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('contacts/task/')?>{{task.id}}"> <strong ng-bind="task.id"></strong></a> <br>
                   
                  </strong>
                </td>
		<td md-cell>
                  <strong>
             
                    <small ng-bind="task.name"></small>
                  </strong>
                </td>
                <td md-cell>
                  <strong ng-bind="task.address"></strong>
                </td>
			
                <td md-cell>
                  <strong  ng-bind="task.cperson"></strong>
                </td>
                <td md-cell>
                  <span>
                    <strong ng-bind="task.cnum"></strong>
                  </span>
                </td>
				 <td md-cell>
                  <span>
				  
                     <strong ng-bind="task.email"></strong>
                  </span>
                </td>
		<td md-cell>
                  <span>
				  
                     <strong ng-bind="task.keywords"></strong>
                  </span>
                </td>
		
		<td md-cell>
                  <span>
				  
                     <strong ng-bind="task.created"></strong>
                  </span>
                </td>
				 <td  >
                  <div class="bottom-right text-right">
                    <ul class="more-avatar">
                      <li ng-repeat="member in task.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
                        <md-tooltip md-direction="top">{{member.staffname}}</md-tooltip>
                        <div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
                      </li>
                      <div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
                    </ul>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="limitOptions" md-page="task_list.page" md-total="{{tasks.length}}" ></md-table-pagination>
        <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
      </div>
    </md-content>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'relationtype' && prop != 'duedate' && prop != 'startdate' && prop != 'status' && prop != 'done' && prop != 'status_id' && prop != 'task_number'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>


  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
		<!--
        <md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable').' '.lang('task') ?></strong>
          <md-tooltip ng-hide="savingInvoice == true" md-direction="bottom"><?php echo lang('task_as_billable') ?></md-tooltip>
        </md-switch>-->
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
	
	 
	 	  <div class="alert alert-danger alert-dismissible" id="displayerror"><span id="showerror"></span></div>
		   <md-tabs md-dynamic-height md-border-bottom>
             
           
	 <md-tab label="<?php echo lang('Business') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		  <form action="<?php echo base_url('contacts/createb/')?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
	  
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('company')?>*</label>
          <input  name="cname" required="">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" required="">
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input  name="cperson" required="">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').''.lang('number')?></label>
          <input  name="cnum" required="">
        </md-input-container>

      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea ng-model="content" name="keyword_content" rows="3"></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="content" name="address" rows="3"></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="userfile" id="chooseFile" required="">
      </md-input-container>
     
      </div>
	   <button type="submit" class="btn btn-report" >Create</button>
	    </form>
    </md-content>
	</md-tab>
	 <md-tab label="<?php echo lang('person') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		   <form action="<?php echo base_url('contacts/create/')?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" required="" >
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input name="cperson" required="">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').''.lang('number')?></label>
          <input  name="cnum" required="">
        </md-input-container>

      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea  name="keyword_content" rows="3"></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea  name="address" rows="3"></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="userfile" id="chooseFile" required="">
      </md-input-container>
     
      </div>
	  <button type="submit" class="btn btn-report" >Create</button>
	   </form>
    </md-content>
	</md-tab>
 
	</md-tabs>
   
	       
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/contacts.js'); ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
$('#displayerror').hide();
$('.my-select').selectpicker();
function checkvalidations()
{
	var selectable=$('#priority').val();
	$('#displayerror').show();	
	if($('#title').val()==''){
		$('#displayerror').show();
		$('#showerror').html("Please Enter Task Name");
		return false;
	} else if($('#datetime1').val()=='' && selectable==4){
		$('#displayerror').show();
		$('#showerror').html("Please Enter Due Date.");
		return false;
	} else if($('#description').val()==''){
		$('#displayerror').show();
		$('#showerror').html("Please Enter Description.");
		return false;
	} else if($('#assigned option:selected').length==0){
		$('#displayerror').show();
		$('#showerror').html("Please Select atleast One Assigned to.");
		return false;
	}else{
		$('#displayerror').hide();
		$('#formid').submit()
	}
	
}

function showdateselection(str){
	if(str==4){
		$('#duedateselect').show();
	}else{
		$('#duedateselect').hide();
	}
}


</script>