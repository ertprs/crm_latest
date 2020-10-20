<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">




<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Tasks_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
    <div class="panel-heading"> <strong><?php echo lang('tasksituation'); ?></strong> <span class="panel-subtitle"><?php echo lang('tasksituationsdesc'); ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'1'}).length" ></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'1'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('open'); ?></span> </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'2'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('inprogress'); ?></span> </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'3'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('waiting'); ?></span> </div>
      <div class="col-md-6 col-xs-6 border-right text-uppercase">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'4'}).length * 100 / tasks.length }}%;"></span> </span> </div>
        <span style="color:#989898"><?php echo lang('complete'); ?></span> </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
    <md-toolbar class="bg-white toolbar-white">
      <div class="md-toolbar-tools bg-white">
        <h2 flex md-truncate class="text-bold"><?php echo lang('tasks'); ?> <small>(<span ng-bind="tasks.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organizeyourtasks'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('task').' '.lang('name')   ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('search').' '.lang('tasks') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter').' '.lang('tasks') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('tasks', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('new').' '.lang('task') ?></md-tooltip>
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
          <small><strong><?php echo lang('loading'). ' '. lang('tasks').'...' ?></strong></small></span>
        </p>
      </div>
      <div ng-show="!taskLoader" class="bg-white" style="padding: unset;">
        <md-table-container ng-show="tasks.length > 0">
          <table md-table  md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo lang('task'); ?></span></th>
                <th md-column md-order-by="startdate"><span><?php echo lang('startdate'); ?></span></th>
				<!--
                <th md-column md-order-by="duedate"><span><?php echo lang('duedate'); ?></span></th>-->
                <th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
				<th md-column md-order-by="priority"><span><?php echo lang('priority'); ?></span></th>
				<th ><span><?php echo lang('members'); ?></span></th>
              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="task in tasks | orderBy: task_list.order | limitTo: task_list.limit : (task_list.page -1) * task_list.limit | filter: task_search | filter: FilteredData" class="cursor" ng-click="goToLink('tasks/task/'+task.id)">
                <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('tasks/task/')?>{{task.id}}"> <strong ng-bind="task.task_number"></strong></a> <br>
                    <small ng-bind="task.name"></small>
                  </strong>
                </td>
                <td md-cell>
                  <strong ng-bind="task.startdate"></strong>
                </td>
				<!--
                <td md-cell>
                  <strong class="badge" ng-bind="task.duedate"></strong>
                </td>-->
                <td md-cell>
                  <span>
                    <strong ng-bind="task.status"></strong>
                  </span>
                </td>
				 <td md-cell>
                  <span>
				  <div ng-class='whatClassIsIt(task.priority)'><strong>{{task.priority}}</strong></div>
                    
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
      <div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'relationtype' && prop != 'duedate' && prop != 'startdate' && prop != 'status' && prop != 'done' && prop != 'status_id' && prop != 'task_number' && prop != 'members'  && prop != 'priority'">
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
		
        <md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable').' '.lang('task') ?></strong>
          <md-tooltip ng-hide="savingInvoice == true" md-direction="bottom"><?php echo lang('task_as_billable') ?></md-tooltip>
        </md-switch>
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
	
	  <form action="<?php print base_url('tasks/create/')?>" method="post" id="formid" enctype="multipart/form-data">
	 <div class="form-group">
	   <label><strong><?php echo lang('task').' ' .lang('name') ?><span class="text-danger">*</span></strong></label>
          <input required type="text"  class="form-control" id="title" placeholder="<?php echo lang('name'); ?>" name="name"/>
		  </div>
		  <div class="form-group"><label><strong><?php echo lang('project'); ?></strong></label>
<?php if(!empty($projects)){?>
<select class="selectpicker" data-live-search="true" name="relation" title="Select Project" style="min-width: 200px;" data-width="100%" id="projectid">
<?php
	foreach($projects as $eachProj){
		?>
		<option value="<?php print $eachProj['id'];?>"><?php print $eachProj['name'];?></option>
		<?php 
	}?>
	</select>
	<?php 
}?>
</div>
<div class="form-group">
<label><strong>Assigned To<span class="text-danger">*</span></strong></label>
<?php if(!empty($staffs)){?>
<select class="selectpicker" data-live-search="true" name="assigned[]" title="Assigned" style="min-width: 200px;" data-width="100%" multiple data-actions-box="true" id="assigned">
<?php
	foreach($staffs as $eachstaffs){
		?>
		<option value="<?php print $eachstaffs['id'];?>"><?php print $eachstaffs['staffname'];?></option>
		<?php 
	}?>
	</select>
	<?php 
}?>
</div>

		  <div class="form-group" >
		  <label><strong><?php echo lang('task').' '.lang('priority'); ?></strong></label>
		  <select onchange="showdateselection(this.value)" name="priority" id="priority" class="text-uppercase selectpicker" data-width="100%">
			<option value="1">Low</option>
			<option value="2">Medium</option>
			<option value="3">High</option>
			<option value="4">Due Date</option>
		  </select>
		  <!--
          <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];task.priority_id = 1;" required placeholder="<?php echo lang('task').' '.lang('priority'); ?>" ng-model="task.priority_id" name="priority" style="min-width: 200px;">
            <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
          </md-select>-->
		  </div>
		  
		  <div class="form-group" style="display:none;" id="duedateselect">
<label ><strong><?php echo lang('task').' ' .lang('duedate') ?><span class="text-danger">*</span></strong></label>


  <input mdc-datetime-picker="" date="true" time="false" type="text" id="datetime1" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="true" minutes="false" min-date="date" show-icon="false" ng-model="task.duedate" class=" form-control" name="duedate" value="" readonly>
  
		  </div>
		  <div class="form-group">
		  <label><strong><?php echo lang('task').' '.lang('status'); ?></strong></label>
          <md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('open'); ?>'}, {id: 2,name: '<?php echo lang('inprogress'); ?>'}, {id: 3,name: '<?php echo lang('waiting'); ?>'}, {id: 4,name: '<?php echo lang('complete'); ?>'}];task.status_id = 1;" required placeholder="<?php echo lang('task').' '.lang('status'); ?>" ng-model="task.status_id" name="status_id" style="min-width: 200px;">
            <md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
          </md-select>
		  </div>
		  <div class="form-group">
		   <label><strong><?php echo lang('task').' '.lang('description') ?></strong></label>
          <textarea rows="2" required name="description" ng-model="task.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control" id="description"></textarea>
		  </div>
		  <div class="form-group">
		   <label><strong>Attachment</strong></label>
    <input type="file" name="file">
		  </div>
		  <input type="hidden" name="relation_type" value="project">
		  <input type="hidden" name="visible" value="1">
		  <div class="alert alert-danger alert-dismissible" id="displayerror"><span id="showerror"></span></div>
		  <button type="button" class="btn btn-report" onclick="checkvalidations();">Create</button>
		   
	  </form>
	  <?php /*
	   <md-input-container class="md-block">
          <label><?php echo lang('task').' ' .lang('name') ?></label>
          <input required type="text" ng-model="task.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
        </md-input-container>
        
		<!--
		<select class="selectpicker" data-live-search="true" multiple data-actions-box="true">
  <option>Mustard</option>
  <option>Ketchup</option>
  <option>Barbecue</option>
</select>-->
<?php //echo "<pre>";
//print_r($projects);?>

<label><?php echo lang('project'); ?></label>
<?php if(!empty($projects)){?>
<select class="selectpicker" data-live-search="true" name="RelatedProject" title="Select Project" style="min-width: 200px;" data-width="100%" id="projectid">
<?php
	foreach($projects as $eachProj){
		?>
		<option value="<?php print $eachProj['id'];?>"><?php print $eachProj['name'];?></option>
		<?php 
	}?>
	</select>
	<?php 
}?>
<label>Assigned To*</label>
<?php if(!empty($staffs)){?>
<select class="selectpicker" data-live-search="true" name="assigned[]" title="Assigned" style="min-width: 200px;" data-width="100%" multiple data-actions-box="true" id="assigned">
<?php
	foreach($staffs as $eachstaffs){
		?>
		<option value="<?php print $eachstaffs['id'];?>"><?php print $eachstaffs['staffname'];?></option>
		<?php 
	}?>
	</select>
	<?php 
}?>
<!--
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
          <label><?php echo lang('project'); ?></label>
          <md-select  ng-model="RelatedProject" name="relation" style="min-width: 200px;">
            <md-option ng-value="project" ng-repeat="project in projects">{{project.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
		 <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('assigned'); ?></label>
          <md-select required ng-model="task.assigned" name="assigned[]" style="min-width: 200px;" multiple>
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>-->
        <br>
		<!--
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
          <label><?php echo lang('milestone'); ?></label>
          <md-select ng-model="SelectedMilestone" name="relation" style="min-width: 200px;">
            <md-option ng-value="milestone.id" ng-repeat="milestone in RelatedProject.milestones">{{milestone.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
		-->
       
        <md-input-container ng-show="isBillable === true" class="md-block">
          <label><?php echo lang('task').' ' .lang('hourlyrate') ?></label>
          <input required type="text" ng-model="task.hourlyrate" class="form-control" id="title" placeholder="0.00"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('task').' ' .lang('date') ?></label>
          <input mdc-datetime-picker="" date="true" time="false" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="false" show-icon="true" ng-model="task.startdate" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
		<!--
        <md-input-container class="md-block">
          <label><?php echo lang('task').' ' .lang('duedate') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="task.startdate" show-icon="true" ng-model="task.duedate" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>-->
       
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('task').' '.lang('priority'); ?></label>
          <md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];task.priority_id = 1;" required placeholder="<?php echo lang('task').' '.lang('priority'); ?>" ng-model="task.priority_id" name="priority" style="min-width: 200px;">
            <md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('task').' '.lang('status'); ?></label>
          <md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('open'); ?>'}, {id: 2,name: '<?php echo lang('inprogress'); ?>'}, {id: 3,name: '<?php echo lang('waiting'); ?>'}, {id: 4,name: '<?php echo lang('complete'); ?>'}];task.status_id = 1;" required placeholder="<?php echo lang('task').' '.lang('status'); ?>" ng-model="task.status_id" name="priority" style="min-width: 200px;">
            <md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
          </md-select>
        </md-input-container> 
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('task').' '.lang('description') ?></label>
          <textarea rows="2" required name="description" ng-model="task.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control"></textarea>
        </md-input-container>
		
        <md-switch style="display: none;" ng-model="isPublic" ng-init="isPublic = true" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
        <md-switch style="display: none;" ng-model="isVisible" ng-init="isVisible = true" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
		</md-content>
        <custom-fields-vertical></custom-fields-vertical>
		<md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddTask()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
            <span ng-hide="saving == true"><?php echo lang('create');?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>
        </section>
		<?php */?>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tasks.js'); ?>"></script>
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