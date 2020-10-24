<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Warehouses_Controller">
	<style type="text/css">
		rect.highcharts-background {
			fill: #f3f3f3;
		}
	</style>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="File">
					<md-icon><i class="ion-document text-muted"></i></md-icon>
				</md-button>
				
				<h2 flex md-truncate><?php echo lang('warehouses'); ?> <small>(<span ng-bind="vendors.length"></span>)</small></h2>
				
			
				<div class="ciuis-external-search-in-table">
					<input ng-model="search" x-webkit-speech='x-webkit-speech' class="search-table-external" id="searchcustomer" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					<md-button class="md-icon-button" aria-label="Search" ng-cloak>
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
					<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
				</md-button> 
				<?php if(check_privilege('warehouses', 'create')) {?>
				<md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
					<md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
				</md-button>
				<?php } ?>
			</div>
			
		</md-toolbar>
		
		<div ng-show="vendorsLoader" layout-align="center center" class="text-center" id="circular_loader">
			<md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
			<p style="font-size: 15px;margin-bottom: 5%;">
				<span>
					<?php echo lang('please_wait') ?> <br>
					<small><strong><?php echo lang('loading'). ' '. lang('vendors').'...' ?></strong></small>
				</span>
			</p>
		</div>
		<ul ng-show="!vendorsLoader" class="custom-ciuis-list-body bg-white" style="padding: 0px;" ng-cloak>
			<md-table-container ng-show="vendors.length > 0">
				<table md-table  md-progress="promise" ng-cloak>
					<thead md-head md-order="vendor_list.order">
						<tr md-row>
							<th md-column><span>Warehouse</span></th>
							<th md-column md-order-by="name"><span><?php echo 'Warehouse Name'; ?></span></th>
							<th md-column md-order-by="group_name"><span><?php echo 'City'; ?></span></th>
							<th md-column md-order-by="address"><span><?php echo 'Created By' ?></span></th>
							
						</tr>
					</thead>
					<tbody md-body>
						<tr class="select_row" md-row ng-repeat="vendor in vendors | orderBy: vendor_list.order | limitTo: vendor_list.limit : (vendor_list.page -1) * vendor_list.limit | filter: search | filter: FilteredData" class="cursor" ng-click="goToLink('warehouses/warehouse/'+vendor.id)">
							<td md-cell>
								<strong>
									<a class="link" ng-href="<?php echo base_url('warehouses/warehouse/')?>{{vendor.id}}"> <strong ng-bind="vendor.warehouse_number"></strong></a>
								</strong>
							</td>
							<td md-cell>
								<strong>
									<strong ng-bind="vendor.name"></strong>
								</strong><br>
								
							</td>
							<td md-cell>
								<strong>
									<strong ng-bind="vendor.city"></strong>
								</strong><br>
								
							</td>
							<td md-cell>
								<span class="badge" ng-bind="vendor.staffname"></span>
							</td>
							
							
						</tr>
					</tbody>
				</table>
			</md-table-container>
			<md-table-pagination ng-show="vendors.length > 0" md-limit="vendor_list.limit" md-limit-options="limitOptions" md-page="vendor_list.page" md-total="{{vendors.length}}" ></md-table-pagination>
		</ul>
		<md-content ng-show="!vendors.length && vendorsLoader == false"  class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar">
		<div class="panel-default panel-table borderten lead-manager-head">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('warehouses'); ?>
					<md-button ng-click="CreateGroup()" class="md-icon-button" aria-label="New" ng-cloak>
						<md-icon><i class="ion-gear-a text-muted"></i></md-icon>
					</md-button>
					<br>
				</div>
			</md-toolbar>
			<div class="tasks-status-stat">
				<div class="widget-chart-container" ng-cloak>
					<div class="widget-counter-group widget-counter-group-right">
						<div style="width: auto" class="pull-left"> <i
							style="font-size: 38px;color: #bfc2c6;margin-right: 10px"
							class="ion-stats-bars pull-left"></i>
							<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
								<h4 style="padding: 0px;margin: 0px;"><b><?php echo 'Product by Warehouse' ?></b>
								</h4>
								<small><?php echo lang('product').' '.lang('stats') ?></small>
							</div>
						</div>
					</div>
					<!-- <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->
				</div>
			</div>
		</div>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
					<i class="ion-android-arrow-forward"></i>
				</md-button>
				<h2 flex md-truncate><?php echo lang('create') ?></h2>
			</div>
		</md-toolbar>
		<md-content layout-padding="">
			<md-content layout-padding>
				
				<md-input-container class="md-block">
					<label>WAREHOUSE NAME</label>
					
					<input name="warehouse_name" ng-model="vendor.warehouse_name" placeholder="Warehouse Name" required>
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
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="vendor.state_id" name="state" style="min-width: 200px;">
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
					<input name="zipcode" ng-model="vendor.postcode" placeholder="Post Code">
				</md-input-container>
				
				<md-input-container class="md-block">
					<label>ADDRESS</label>
					<textarea ng-model="vendor.address" name="address" md-maxlength="500" rows="3" md-select-on-focus placeholder="Address"></textarea>
				</md-input-container>
				<!--
				<md-input-container class="md-block">
					<label>Notes</label>
					<textarea ng-model="vendor.notes" name="notes" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				-->
				
				<p id="vendorsError" style="color: red"></p>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
					<md-button ng-click="AddVendor()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
						<span ng-hide="saving == true"><?php echo lang('add');?></span>
						<md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					</md-button>
					<br/><br/><br/><br/>
				</section>
			</md-content>
		</md-content>
	</md-sidenav>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateGroup" ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white" style="background:#262626">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i
					class="ion-android-arrow-forward"></i></md-button>
					<md-truncate><?php echo lang('groups') ?></md-truncate>
				</div>
			</md-toolbar>
			<md-content>
				<md-toolbar class="toolbar-white" style="background:#262626">
					<div class="md-toolbar-tools">
						<h4 class="text-bold text-muted" flex><?php echo lang('vendor').' '.lang('groups') ?></h4>
						<?php if (check_privilege('vendors', 'create')) { ?>
						<md-button aria-label="Add Status" class="md-icon-button" ng-click="NewGroup()">
							<md-tooltip md-direction="bottom"><?php echo lang('add').' '.lang('vendor').' '.lang('group') ?></md-tooltip>
							<md-icon><i class="ion-plus-round text-success"></i></md-icon>
						</md-button>
						<?php } ?>
					</div>
				</md-toolbar>
				<md-list-item ng-repeat="name in group" class="noright" ng-click="EditGroup(name.id,name.name, $event)"
				aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
				<?php if (check_privilege('vendors', 'edit')) { ?>
				<md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit group"></md-icon>
				<?php } if (check_privilege('vendors', 'delete')) { ?>
				<md-icon ng-click='DeleteVendorGroup($index)' aria-label="Remove Status"
				class="md-secondary md-hue-3 ion-trash-b"></md-icon>
				<?php }?>
			</md-list-item>
		</md-content>
	</md-sidenav>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
		<md-toolbar class="md-theme-light" style="background:#262626">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
					<i class="ion-android-arrow-forward"></i>
				</md-button>
				<md-truncate><?php echo lang('filter') ?></md-truncate>
			</div>
		</md-toolbar>
		<md-content layout-padding="">
			<div ng-repeat="(prop, ignoredValue) in vendors[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop!='vendor' && prop != 'name' && prop != 'address' && prop != 'email' && prop != 'phone' && prop != 'balance' && prop != 'vendor_id' && prop != 'contacts' && prop != 'vendor_number' && prop != 'group_name'">
				<div class="filter col-md-12">
					<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
					<hr>
					<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycountry') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
						<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
					</div>
					<div ng-if="prop=='<?php echo lang('filterbycountry') ?>'">
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
<script type="text/javascript">
	var lang={};
	lang.vendor='<?php echo lang('vendor')?>';
	lang.vendor_title="<?php echo lang('vendor_title')?>";
	lang.type_group="<?php echo lang('type_group')?>";
	lang.delete_group="<?php echo lang('delete_group')?>";
	lang.group='<?php echo lang('group')?>';
	lang.new='<?php echo lang('new')?>';
	lang.name='<?php echo lang('name')?>';
	lang.add='<?php echo lang('add')?>';
	lang.cancel='<?php echo lang('cancel')?>';
	lang.save='<?php echo lang('save')?>';
	lang.edit='<?php echo lang('edit')?>';
	lang.doIt='<?php echo lang('doIt')?>';
	lang.attention='<?php echo lang('attention')?>';

</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' );?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
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