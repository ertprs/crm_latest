<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' );
if(!empty($estimations)){
			$appro=0;
			$draft=0;
			$missing=0;
			$underapp=0;
			$declined=0;
			foreach($estimations as $eachest){
				if($eachest['estimate_status']=='Approved'){
					$appro++;
				}
				if($eachest['estimate_status']=='Draft'){
					$draft++;
				}
				if($eachest['estimate_status']=='Missing Info'){
					$missing++;
				}
				if($eachest['estimate_status']=='Under Approval'){
					$underapp++;
				}
				if($eachest['estimate_status']=='Declined'){
					$declined++;
				}
			}
			
			
		}
 ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Proposals_Controller">
 
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('estimation').' / '.lang('estimates'); ?> <small>(<span class="estlen"><?php echo sizeof($estimations);?></span>)</small><br>
         </h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="proposal_search" class="search-table-external" id="searchInput" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('estimations', 'create')) { ?> 
          <md-button ng-href="<?php echo base_url('estimations/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content ng-show="!proposalsLoader" class="bg-white" ng-cloak>
      <md-table-container>
        <table id="estimationstable" md-table md-progress="promise">
          <thead md-head md-order="proposal_list.order">
            <tr md-row>
              <th md-column><span>Estimation No.<br> & Name</span></th>
              <th md-column ><span>Customer</span>
              </th>
			              <th md-column ><span><?php echo lang('amount');?></span></th>
						   <th md-column ><span><?php echo lang('status'); ?></span></th>
              <th md-column><span>Created <?php echo lang('date'); ?></span></th>
             
  
              <th md-column ><span>Sales By </span></th>
            </tr>
          </thead>
          <tbody md-body id="estimationstbody>
		  <?php 
		  foreach($estimations as $k => $est) {
				$clientdet=$this->Customers_Model->get_customers($est['customer_id']);
			  ?>
            <tr class="select_row" md-row id="<?php echo $k+1;?>">
              <td md-cell>
                <strong>
                  <a ng-show="<?php echo $est['estimate_status'] != 'Quote Request'?>"class="link" ng-href="<?php echo base_url('estimations/view/'.$est['estimation_id']) ?>"> <span>EST-<?php echo $est['estimation_id'];?><br><?php echo $est['project_name'];?></span></a>
				  <a ng-show="<?php echo $est['estimate_status'] == 'Quote Request'?>"class="link" ng-href="<?php echo base_url('estimations/view/'.$est['estimation_id']) ?>"> <span>QR<br><?php echo $est['project_name'];?></span></a>
                </strong><br>
              </td>
              <td md-cell>
                <strong><span><?php echo $clientdet['company'];?></span></strong><br>
              </td>
			   <td md-cell>
                <strong><?php  echo number_format($est['estimation_total_amt'],2,'.',','); ?></strong>
              </td>
			   <td md-cell>
                <strong><span class="badge"><?php echo $est['estimate_status'];?></span></strong>
              </td>
              <td md-cell>
                <strong><span class="badge"><?php echo date('d-m-Y',strtotime($est['created']));?></span></strong>
              </td>
             
             
              <td md-cell>
                <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{proposal.staff}}" class="assigned-staff-for-this-lead user-avatar">
                  <img ng-src="<?php echo base_url('uploads/images/'.$est['staffavatar'])?>" alt="staffavatar"></div>
              </td>
            </tr>
		  <?php } ?>
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
   <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
   <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10 md-truncate flex" flex="" md-truncate="">Estimate Status</h2>
       
      </div>
    </md-toolbar>
  <md-content class="bg-white _md">
    <div class="col-md-12" >
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="<?php print $draft;?>"></span> <span class="task-stat-all" ng-bind="'/'+' <?php print count($estimations);?> '"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{<?php print $draft;?> * 100 / <?php print count($estimations);?> }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="<?php print $appro;?>"></span> <span class="task-stat-all" ng-bind="'/'+' <?php print count($estimations);?> '"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{<?php print $appro;?> * 100 / <?php print count($estimations);?> }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898">Approved</span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="<?php print $missing;?>"></span> <span class="task-stat-all" ng-bind="'/'+' <?php print count($estimations);?> '"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{<?php print $missing;?> * 100 / <?php print count($estimations);?>}}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898">Missing Info</span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="<?php print $underapp;?>"></span> <span class="task-stat-all" ng-bind="'/'+' <?php print count($estimations);?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{<?php print $underapp;?> * 100 / <?php print count($estimations);?>}}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898">Under Approval</span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="<?php print $declined;?>"></span> <span class="task-stat-all" ng-bind="'/'+' <?php print count($estimations);?> '"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{<?php print $declined;?> * 100 / <?php print count($estimations);?>}}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('declined')?></span>
      </div>
     
    </div>
	  </md-content>  
  </div>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/proposals.js'); ?>"></script>


<script type="text/javascript">
$.extend($.expr[":"], {
	"containsIN": function(elem, i, match, array) {
	return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});

$('#searchInput').keyup(function(){
	var cnts = 0;
	var search = $(this).val();
	$("#estimationstable").find("tr").hide();
	var len = $('#estimationstable tbody tr:not(.notfound) td:containsIN("'+search+'")').length;
	if(len > 0){
		var rowarray =[];
		$('#estimationstable tbody tr:not(.notfound) td:containsIN("'+search+'")').each(function(){
			$(this).closest('tr').show();
			console.log($(this).closest('tr').attr('id'));
			if($(this).closest('tr').attr('id') !='undefined'){
				rowarray.push($(this).closest('tr').attr('id'));
			}
			rowarray = getUnique(rowarray);
			console.log(rowarray);
		});
		//console.log($('#estimationstable tr').length);
		//console.log(cnts);
		$('.estlen').html(parseInt(rowarray.length));
	}else{
	  $('.notfound').show();
	  $('.estlen').html(parseInt(len));
	}
});
function getUnique(array){
	var uniqueArray = [];
	
	// Loop through array values
	for(var value of array){
		if(uniqueArray.indexOf(value) === -1){
			uniqueArray.push(value);
		}
	}
	return uniqueArray;
}
</script>