<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Proposals_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
    <div class="panel-heading"> <strong><?php echo lang('proposalsituation') ?></strong> <span class="panel-subtitle"><?php echo lang('proposalsituationsdesc') ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'1'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'1'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'2'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'3'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'4'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('revised')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'5'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'5'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('declined')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'6'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposals') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'6'}).length * 100 / proposals.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('accepted')?></span>
      </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('notebooks').' / '.lang('notebbok'); ?> <small>(<span ng-bind="proposals.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organizeyourproposals'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="proposal_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('notebooks', 'create')) { ?> 
          <md-button ng-href="<?php echo base_url('notebooks/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!proposalsLoader" class="bg-white" ng-cloak>
      <md-table-container>
        <table md-table md-progress="promise">
          <thead md-head md-order="proposal_list.order">
            <tr md-row>
              <th md-column><span><?php echo 'Notebook List'; ?></span></th>
              <th md-column ><span><?php echo 'Created Date'; ?></span></th>
              <th md-column><span><?php echo 'Remarks'; ?></span></th>
              <th md-column ><span><?php echo 'Description'; ?></span></th>
              <th md-column ><span><?php echo 'Action'; ?></span></th>
            </tr>
          </thead>
          <tbody md-body id="notebooktable">
		  <?php /* foreach($notebooks as $k => $result) { ?>
            <tr class="select_row" md-row>
              <td md-cell>
                <a href="<?php echo base_url();?>notebooks/view/<?php echo $result['notebook_id'];?>" class="link"><strong><span><?php echo $result['notebook_list'];?></span></strong></a><br>
              </td>
              <td md-cell>
                <strong><span class="badge"><?php echo date('d-M-Y',strtotime($result['created_date']));?></span></strong>
              </td>
              <td md-cell>
                <strong><?php  echo $result['remarks']; ?></strong>
              </td>
			       <td md-cell>
                <strong><?php  echo $result['description']; ?></strong>
              </td>

              <td md-cell>
				 <?php if (check_privilege('notebooks', 'delete') || $user_id == $result['created_by']) { ?> 
					<a href="<?php echo base_url();?>notebooks/delete/<?php echo $result['notebook_id'];?>" class="btn btn-danger" onclick="return confirm('Are you Sure to Delete');"><i class="fa fa-trash"></i></a>
				 <?php } ?>
              </td>
             
            </tr>
		  <?php } */?>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="proposals.length > 0" md-limit="proposal_list.limit" md-limit-options="limitOptions" md-page="proposal_list.page" md-total="{{proposals.length}}"></md-table-pagination>
      <md-content ng-show="!proposals.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
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
      <div ng-repeat="(prop, ignoredValue) in proposals[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill' && prop != 'status' && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type' && prop != 'customer_email'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
            <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
              <md-option value="all"><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
            </md-select>
          </div>
          <div ng-if="prop=='<?php echo lang('filterbyassigned') ?>'">
            <md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
              <md-option value="all"><?php echo lang('all') ?></md-option>
              <md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
            </md-select>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/proposals.js'); ?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	notebookData('');
	$('#search').on("input", function() {
	  var dInput = this.value;
	  if(dInput.length >= 2){
		  notebookData(dInput);
	  }else{
		  notebookData();
	  }
	});
});
function notebookData(searchdata){
	$.ajax({
			url : "<?php echo base_url(); ?>notebooks/get_request_data",
			data:{data : searchdata},
			method:'POST',
			success:function(response) {
				$("#notebooktable").html('');
				$("#notebooktable").html(response);
			}       
		  });
}
</script>