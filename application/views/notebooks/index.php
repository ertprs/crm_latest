<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Notebook_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
    <div class="panel-heading"> <strong><?php // echo lang('proposalsituation') ?></strong> <span class="panel-subtitle"><?php // echo lang('proposalsituationsdesc') ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('notebooks').' / '.lang('notebook'); ?> <small>(<span ng-bind="orders.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organizeyourproposals'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="order_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <!-- <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>  -->
        <?php if (check_privilege('notebooks', 'create')) { ?> 
          <md-button ng-href="<?php echo base_url('notebooks/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!orderLoader" class="bg-white" ng-cloak>
      <md-table-container ng-show="orders.length > 0">
        <table md-table md-progress="promise">
          <thead md-head md-order="order_list.order">
            <tr md-row>
              <th md-column md-order-by="notebook_list"><span><?php echo 'Notebook List'; ?></span></th>
              <th md-column md-order-by="created_date"><span><?php echo 'Created Date'; ?></span></th>
              <th md-column><span><?php echo 'Page Names'; ?></span></th>
              <th md-column ><span><?php echo 'Created by'; ?></span></th>
             <!-- <th md-column ><span><?php // echo 'Action'; ?></span></th> -->
            </tr>
          </thead>
          <tbody md-body >
			<tr class="select_row cursor" md-row ng-repeat="notb in orders | orderBy: order_list.order | filter: order_search | limitTo: order_list.limit : (order_list.page -1) * order_list.limit">
				<td md-cell>
					<a class="link" ng-href="<?php echo base_url('notebooks/view/') ?>{{notb.id}}"><strong> <span ng-bind="notb.notebook_list"></span></strong></a>
				</td>
				<td md-cell>
					
					<span ng-bind="notb.created_date"></span>
				</td>
				<td md-cell>
					
					<span ng-bind="notb.page_names"></span>
				</td>
				<td md-cell>
					 <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" title="" class="assigned-staff-for-this-lead user-avatar"><img src="<?php echo base_url('uploads/images/')?>{{notb.staffavatar}}"></div> 
				</td>
			</tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="orders.length > 0" md-limit="order_list.limit" md-limit-options="limitOptions" md-page="order_list.page" md-total="{{orders.length}}"></md-table-pagination>
      <md-content ng-show="!orders.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
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
/* $(document).ready(function() {
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
} */
</script>