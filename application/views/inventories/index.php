<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.floatright{
    float: right;
}
.noborder{
        background-color: #fff !important; 
     border: none !important;
}
input[type="text"],


input[type="text"]:focus,
select.form-control:focus,span.form-control {
  -webkit-box-shadow: none;
  box-shadow: none;
}
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

#drop_file_zone {
    background-color: #EEE;
    border: #999 5px dashed;
    width: 100%;
    height: 200px;
    padding: 8px;
    font-size: 18px;
}
#drag_upload_file {
  width:50%;
  margin:0 auto;
}
#drag_upload_file p {
  text-align: center;
}
#drag_upload_file #selectfile {
  display: none;
}

.container{
 margin: 0 auto;
}
.content{
 width: 100px;
 float: left;
 margin-right: 5px;
 border: 1px solid gray;
 border-radius: 3px;
 padding: 5px;
}

/* Delete */
.content .delete{
 border: 2px solid red;
 display: inline-block;
 width: 99%; 
 text-align: center;
 color: red;
}
/* view */
.content .view{
 border: 2px solid blue;
 display: inline-block;
 width: 99%; 
 text-align: center;
 color: blue;
}
.content .delete:hover{
 cursor: pointer;
}
.ck-editor__editable_inline {
    min-height: 200px;
}
label {
    font-weight: 600;
}
.form-control{
	height: 38px;
	border-radius:10px;
}
.right-inner-addon {
  position: relative;
}
.bg-danger {
    background-color: #FF3B30 !important;
}
.bg-success {
    background-color: #26c281 !important;
}
.right-inner-addon input {
  padding-right: 30px;
}
.progress{
	height: 1rem !important;
	margin-bottom:0px;
}

.right-inner-addon i {
     position: absolute;
    right: 0px;
    padding: 12px 4px;
    pointer-events: none;
    /* top: 9px; */
    background: #ddd;
}

.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#000;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#000;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #26c281 !important;
		outline: 0;
		color:#fff !important;
	}
.pd0{
	padding:0px !important;
}
.pdleft0{
	padding-left: 0px;
}
  .button5 {
    border-radius: 50%;
    background-color: #4CAF50;
    /* Green */
    border: none;
    color: white;
    width:30px;
    height:30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }
  .totalcostclass{
    
  }
  .centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
  }
</style>
<div class="ciuis-body-content" ng-controller="Inventories_Controller">
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
				
				<h2 flex md-truncate><?php echo lang('inventory'); ?> <small>(<span ng-bind="vendors.length"></span>)</small></h2>
				
			
				<div class="ciuis-external-search-in-table">
					<input ng-model="search" x-webkit-speech='x-webkit-speech' class="search-table-external" id="searchcustomer" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					<md-button class="md-icon-button" aria-label="Search" ng-cloak>
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<md-button ng-click="CreateGroup()" class="md-icon-button" aria-label="New" ng-cloak>
						<md-icon><i class="ion-gear-a text-muted"></i></md-icon>
					</md-button>
				<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
					<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
				</md-button> 
				<?php if(check_privilege('inventories', 'create')) {?>
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
					<small><strong><?php echo lang('loading'). ' '. lang('inventory').'...' ?></strong></small>
				</span>
			</p>
		</div>
		<ul ng-show="!vendorsLoader" class="custom-ciuis-list-body bg-white" style="padding: 0px;" ng-cloak>
			<md-table-container ng-show="vendors.length > 0">
				<table md-table  md-progress="promise" ng-cloak>
					<thead md-head md-order="vendor_list.order">
						<tr md-row>
							<th md-column><span>#</span></th>
								<th md-column md-order-by="move_type"><span><?php echo 'Item' ?></span></th>
						<th md-column md-order-by="client_name"><span><?php echo 'Client Name'; ?></span></th>
							<th md-column md-order-by="cost_price"><span><?php echo 'Value'; ?></span></th>
							<th md-column md-order-by="cost_price"><span><?php echo 'In Stock'; ?></span></th>
							<th md-column md-order-by="warehouse"><span><?php echo 'Warehouse'; ?></span></th>
							<th md-column md-order-by="created"><span><?php echo 'Created by'; ?></span></th>
							
							
						</tr>
					</thead>
					<tbody md-body>
						<tr class="select_row" md-row ng-repeat="vendor in vendors | orderBy: vendor_list.order | limitTo: vendor_list.limit : (vendor_list.page -1) * vendor_list.limit | filter: search | filter: FilteredData" class="cursor" ng-click="goToLink('inventories/invview/'+vendor.id)">
							<td md-cell>
							<strong>
									 <a class="link" ng-href="<?php echo base_url('inventories/invview/')?>{{vendor.id}}"> <strong ng-bind="vendor.inventory_number"></strong></a> 
								
								</strong>
							</td>
								<td md-cell>
								<strong>
									<strong ng-bind="vendor.product_name"></strong>
								</strong><br>
								
							</td>
						<td md-cell>
								<strong>
									<strong ng-bind="vendor.client_name"></strong>
								</strong><br>
								
							</td>
						<!--		<td md-cell>
								<strong>
									<strong ng-bind="vendor.product_category"></strong>
								</strong><br>
								
							</td> -->
							<td md-cell>
								<strong>
									<strong ng-bind="vendor.cost"></strong>
								</strong><br>
								
							</td>
							<td md-cell>
								<strong>
									<strong ng-bind="vendor.stock"></strong>
								</strong><br>
								
							</td>
							<td md-cell>
								<strong>
									<strong ng-bind="vendor.warehouse"></strong>
								</strong><br>
								
							</td>
						<td md-cell>
			      
			     <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{vendor.staffname}}" class="assigned-staff-for-this-lead user-avatar"><img  ng-src="<?php echo base_url('uploads/images/{{vendor.staffavatar}}')?>" alt="{{vendor.staffname}}"></div>             
              </td> 
							
							
						</tr>
					</tbody>
				</table>
			</md-table-container>
			<md-table-pagination ng-show="vendors.length > 0" md-limit="vendor_list.limit" md-limit-options="limitOptions" md-page="vendor_list.page" md-total="{{vendors.length}}" ></md-table-pagination>
		</ul>
		<md-content ng-show="!vendors.length && vendorsLoader == false"  class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
	</div>
	<div class="main-content container-fluid col-xs-13 col-md-3 col-lg-3 md-pl-0 lead-left-bar">
		<div class="panel-default panel-table borderten lead-manager-head">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate class="text-bold"><?php echo lang('inventory') .''.lang('warehouse'); ?>
					
						<!-- <a href="<?php //echo base_url('warehouses');?> "><md-icon><i class="ion-gear-a text-muted"></i></md-icon></a> -->
						<?php if (check_privilege('inventories', 'create')) { ?>
						<md-button aria-label="Add Status" class="md-icon-button" ng-click="ManageStatus()">
							<md-tooltip md-direction="bottom"><?php echo lang('add').' '.lang('warehouse') ?></md-tooltip>
							<md-icon><i class="ion-gear-a text-muted"></i></md-icon>
						</md-button>
						<?php } ?>
						
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
								<h4 style="padding: 0px;margin: 0px;"><b><?php echo 'Inventory By Category' ?></b>
								</h4>
								<small><?php echo lang('inventory').' '.lang('stats') ?></small>
							</div>
						</div>
					</div>
					<!-- <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->
				</div>
			</div>
		</div>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
	 <form id="form1" method="post" action="<?php echo base_url('inventories/create');?>">
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
			    <div class="form-group">
			         <label>Category</label>&nbsp;&nbsp;
		  <select  class="form-control" name="category" id="category" style="border-radius:0px" onchange="select_category(this.value)">
		      <option value="1">Materials</option>
		      <option value="2">Client Unit Storage</option>
		      </select>
			    </div>
				<div class="form-group" id="cust_mat_name" >
				    	 <md-input-container class="md-block">
				<input type="text" class="form-control" name="product_names" data-hidden-field-id="product_name" id="product_name1" placeholder="MATERIAL / SERVICE NAME" >
				
		 
		   </md-input-container>
				</div>
					<div class="form-group" id="mat_name">
				 <md-input-container class="md-block">
				<input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="product_name" name="product_name" id="product_name" placeholder="MATERIAL / SERVICE NAME" autocomplete="off" >
				
		  <input type="hidden" name="service_name" id="service_name" autocomplete="off"  class="service"   />
		   </md-input-container>
		   
	</div>
		  <div class="form-group" id="unit_type">
		  <label>Unit Type</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_unit_type" id="inv_unit_type" style="border-radius:0px">
		  <?php  if(isset($unittypes)) { 
		 
		  foreach($unittypes as $pc) { ?>
		  <option value="<?php echo  $pc['unit_type_id'];?>"><?php echo $pc['unit_name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		  
		  	<div class="form-group" id="supp" style="display:none">
		  <label>Suppliers</label>
<select class="form-control" name="supplier_id" id="supplier_id" style="border-radius:0px" >
    <option value='0'>Select New Supplier</option>
</select>

				</div>
				<div class="form-group" id="all_supp" >
				     <label>Suppliers</label>
		  <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="supp_id" name="supp_id" id="supp_id" placeholder="SUPPLIER" autocomplete="off" value=""  style="border-radius:0px" >
				
		  <input type="hidden" name="supplier_id" id="supplier_id1" autocomplete="off" value="" class="supplier_id"/>
		

		 </div>
		 <div class="form-group" id="all_cust" style="display:none">
				     <label>Customers</label>
		  <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="cust_id" name="cust_id" id="cust_id" placeholder="CUSTOMER" autocomplete="off" value=""  style="border-radius:0px" >
				
		  <input type="hidden" name="customer_id" id="customer_id" autocomplete="off" value="" class="customer_id"/>
		

		 </div>
		 <div class="form-group" id="cost_price">
		  <label>Cost Price
<input list="costs" name="cost" class="form-control" style="border-radius:0px" size="50"autocomplete="off" /></label>
<datalist id="costs">
  <option value=""></option>
</datalist>
				</div>
			
				<!-- </md-input-container> -->
		<!-- <md-input-container class="md-block"> -->
		<div class="form-group" >
		  <label>Warehouse</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_warehouse" id="inv_warehouse" style="border-radius:0px">
		  <?php  if(isset($warehouses)) { 
		 
		  foreach($warehouses as $wh) { ?>
		  <option value="<?php echo  $wh['warehouse_id'];?>"><?php echo $wh['warehouse_name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		   <!-- </md-input-container> --> 
		  <md-input-container class="md-block">
				<label>Stock Qty()</label>
				<input type="text"  name="stock" id="stock" class="form-control" placeholder="Stock Qty" ng-model="vendor.stock"> 
				</md-input-container>
				
		  <div class="form-group" >
		  <label>Move Type</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_move_type" id="inv_move_type" style="border-radius:0px">
		  <?php  if(isset($move_types)) { 
		 
		  foreach($move_types as $mv) { ?>
		  <option value="<?php echo  $mv['id'];?>"><?php echo $mv['name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		  <div class="form-group">
		      <label>Notes</label>
		     <textarea  name="notes" id="notes"  class="form-control" style="border-radius:0px" placeholder="Enter Here"></textarea>
		  </div>
		  <div class="form-group">
		      <input type="file" name="file" multiple class="form-control" style="border-radius:0px" />
		  </div>
				<!--
				<md-input-container class="md-block">
					<label>Notes</label>
					<textarea ng-model="vendor.notes" name="notes" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				-->
				
				<!-- <p id="vendorsError" style="color: red"></p>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
					<md-button ng-click="AddVendor()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
						<span ng-hide="saving == true"><?php //echo lang('add');?></span>
						<md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					</md-button>
					<br/><br/><br/><br/>
				</section> -->
				 <input type="submit" class="btn btn-success col-md-12"  value="Add">
				</form>
			</md-content>
		</md-content>
	</md-sidenav>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateGroup" ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white" style="background:#262626">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i
					class="ion-android-arrow-forward"></i></md-button>
					<md-truncate><?php echo lang('settings') ?></md-truncate>
				</div>
			</md-toolbar>
			<md-content>
			<md-content>
			<!--	<md-toolbar class="toolbar-white" style="background:#262626">
					<div class="md-toolbar-tools">
						<h4 class="text-bold text-muted" flex><?php //echo lang('unit').' '.lang('type') ?></h4>
						<?php //if (check_privilege('inventories', 'create')) { ?>
						<md-button aria-label="Add Status" class="md-icon-button" ng-click="NewGroup()">
							<md-tooltip md-direction="bottom"><?php //echo lang('add').' '.lang('unit').' '.lang('type') ?></md-tooltip>
							<md-icon><i class="ion-plus-round text-success"></i></md-icon>
						</md-button>
						<?php //} ?>
					</div>
				</md-toolbar>
				<md-list-item ng-repeat="name in group" class="noright" ng-click="EditGroup(name.id,name.name, $event)"
				aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
				<?php //if (check_privilege('inventories', 'edit')) { ?>
				<md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit group"></md-icon>
				<?php //} if (check_privilege('inventories', 'delete')) { ?>
				<md-icon ng-click='DeleteVendorGroup($index)' aria-label="Remove Status"
				class="md-secondary md-hue-3 ion-trash-b"></md-icon>
				<?php //}?>
			</md-list-item>  -->
			<md-toolbar class="toolbar-white" style="background:#262626">
					<div class="md-toolbar-tools">
						<h4 class="text-bold text-muted" flex><?php echo lang('move').' '.lang('type') ?></h4>
						<?php if (check_privilege('inventories', 'create')) { ?>
						<md-button aria-label="Add Status" class="md-icon-button" ng-click="NewMtype()">
							<md-tooltip md-direction="bottom"><?php echo lang('add').' '.lang('move').' '.lang('type') ?></md-tooltip>
							<md-icon><i class="ion-plus-round text-success"></i></md-icon>
						</md-button>
						<?php } ?>
					</div>
				</md-toolbar>
				<md-list-item ng-repeat="name in move" class="noright" ng-click="Edittype(name.id,name.name, $event)"
				aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
				<?php if (check_privilege('inventories', 'edit')) { ?>
				<md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit group"></md-icon>
				<?php } if (check_privilege('inventories', 'delete')) { ?>
				<md-icon ng-click='Deletetype($index)' aria-label="Remove Status"
				class="md-secondary md-hue-3 ion-trash-b"></md-icon>
				<?php }?>
			</md-list-item>
    
   <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate>Unit Type</h2>
        <?php if (check_privilege('material', 'create')) { ?>
          <md-button ng-click="NewUnitType()" class="md-icon-button" aria-label="Unit Type" ng-cloak>
            <md-tooltip md-direction="left">Add Unit Type</md-tooltip>
            <md-icon><i class="ion-android-add text-muted"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item ng-repeat="unittype in unittypes" ng-click="EditUnit($index)" aria-label="Unit">
          <p><strong ng-bind="unittype.name"></strong></p>
          <?php if (check_privilege('material', 'delete')) { ?>
            <md-button ng-click="DeleteUnit($index)" class="md-icon-button" aria-label="Create">
              <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
              <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!unittypes.length" class="md-padding bg-white no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
    </md-content>
 

     

   
			
		</md-content>
	</md-sidenav>
	<!----Add Status------>
		<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ManageStatus" ng-cloak style="min-width: 450px;">
			<md-toolbar class="md-theme-light" style="background:#262626">
				<div class="md-toolbar-tools">
					<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
					<md-truncate><?php echo lang('manage') . ' ' . lang('warehouses')?></md-truncate>
				</div>
			</md-toolbar>
			<md-content layout-padding="">
				<md-toolbar class="toolbar-white" style="background:#262626">
					<div class="md-toolbar-tools">
						<h4 class="text-bold text-muted" flex><?php echo lang('inventory') . ' ' . lang('warehouse') ?></h4>
						<?php if (check_privilege('warehouses', 'create')) { ?> 
							<md-button aria-label="Add Status" class="md-icon-button"  ng-click="ShowStatusForm()">
							  <md-tooltip md-direction="bottom"><?php echo lang('add') . ' ' . lang('warehouse') ?>
							</md-tooltip>
							<md-icon><i class="ion-plus-round text-success"></i></md-icon>
						  </md-button>
						<?php } ?>
					</div>
				</md-toolbar>
				<br ng-show="neweventtype">
				<md-input-container ng-show="neweventtype" class="md-block">
					<label>WAREHOUSE NAME</label>
					
					<input name="warehouse_name" ng-model="event_type.name" placeholder="Warehouse Name" required>
				</md-input-container>
				
				
				<md-input-container  ng-show="neweventtype" class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-change="getStates(event_type.country_id)" ng-model="event_type.country_id" name="country_id" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container ng-show="neweventtype" class="md-block">
					<label><?php echo lang('state'); ?></label>
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="event_type.state_id" name="state" style="min-width: 200px;">
						<md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container  ng-show="neweventtype" class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="event_type.city" placeholder="City">
				</md-input-container>
				
				
				<div ng-show="neweventtype" style="border-bottom: 1px solid #e5e5e5;padding-bottom: 12%;">
					<div class="pull-right">
						<md-button ng-click="AddNewStatus()" class="md-raised md-primary pull-right" aria-label='Add Status' ng-disabled="addingEventType == true" ng-show="event_type.id==0">
							<span ng-show="addingEventType == false"><?php echo lang('add') . ' ' . lang('warehouses')?></span>
							<md-progress-circular class="white" ng-show="addingEventType == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
						</md-button>
						<md-button ng-click="EditNewStatus()" class="md-raised md-primary pull-right" aria-label='Add Status' ng-disabled="addingEventType == true" ng-show="event_type.id!=0">
							<span ng-show="addingEventType == false"><?php echo lang('update') . ' ' . lang('warehouse')?></span>
							<md-progress-circular class="white" ng-show="addingEventType == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
						</md-button>
					</div>
				</div>
				<h4 class="text-bold text-muted" style="color:green"><?php echo 'Warehouse Name'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'City'; ?></h4>
				<md-list-item ng-repeat="name in status" class="noright" ng-click="EditStatus(name.id,name.name,name.city,name.country_id,name.state_id,$event)" aria-label="Edit Status">
					<div layout="row" layout-wrap style="width: 100% !important;">
						<div flex-gt-xs="60" flex-xs="60">
						  <strong ng-bind="name.name"></strong>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					</div>
					<div flex-gt-xs="30" flex-xs="30">
						<strong ng-bind="name.city"></strong>
					</div>
					<div flex-gt-xs="10" flex-xs="10">
						<?php if (check_privilege('warehouses', 'edit')) { ?> 
						<md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit status"></md-icon>
						<?php } if (check_privilege('warehouses', 'delete')) { ?> 
						  <md-icon ng-click='DeleteStatus($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b"></md-icon>
						<?php } ?>
					</div>
					<md-divider></md-divider>
				</md-list-item>
			</md-content>
		</md-sidenav>
		<!--End Add Status-->
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
			<div ng-repeat="(prop, ignoredValue) in vendors[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop!='inventory_number' && prop != 'product_type' && prop != 'product_category' && prop != 'product_name' && prop != 'staffavatar' && prop != 'stock' && prop != 'cost' && prop != 'contacts' && prop != 'vendor_number' && prop != 'group_name'">
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
	lang.product_type="<?php echo lang('product_type')?>"; 
	lang.product_category="<?php echo lang('product_category')?>";
	lang.delete_unit="<?php echo lang('delete_unit')?>";
	lang.delete_move="<?php echo lang('delete_move')?>";
	lang.group='<?php echo lang('group')?>';
	lang.new='<?php echo lang('new')?>';
	lang.product='<?php echo lang('product')?>';
	lang.unit = '<?php echo lang('unit')?>';
	lang.category='<?php echo lang('category')?>';
	lang.name='<?php echo lang('name')?>';
	lang.type='<?php echo lang('type')?>';
	lang.move='<?php echo lang('move')?>';
	lang.move_type='<?php echo lang('move_type')?>';
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
<script src="<?php echo base_url('assets/js/inventories.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/typeahead.js'); ?>"></script>
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


  var  p=0;
	   $('#product_name').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_material',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							//$('#product_name').val('-1');
							//$('#service_name').val('-1');
							//console.log(p);
							
							 p++;
							 $('#cost').val('0');
							 $('#mat_pid').hide();
							 $("#supplier_id").attr("disabled", "disabled");
							 $('#service_name').val('0');

		                    $('#inv_pid').show();

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
		$(`#${hiddenFieldId}`).val(SelectedCode);
		$('#service_name').val(SelectedCode);
		$('#supp').show();
		$('#all_supp').hide();
		$("#supplier_id").removeAttr("disabled", "disabled");
			$("#supplier_id1").attr("disabled", "disabled");
		$('#inv_pid').hide();
		get_mat_cat(SelectedCode);
		get_suppliers(SelectedCode);
	//	get_cost(SelectedCode);
		return SelectedCityName;
        // Save SelectedCode to hiddenfield
		/* var catarr=[];
        $('.service').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){	
	  
        $(`#${hiddenFieldId}`).val(SelectedCode);
		$('#service_name').val(SelectedCode);
		
		get_cost(SelectedCode);
		return SelectedCityName;
	  }else{
		  
		  alert("Already Selected");
		  return false;
	  } */
        
        
    }

});



  var  s=0;
	   $('#supp_id').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_vendors',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							//$('#product_name').val('-1');
							//$('#service_name').val('-1');
							//console.log(p);
							
							 s++;
							 $('#supplier_id1').val('-1');
							/* $('#cost').val('0');
							 $('#mat_pid').hide();
							 $("#inv_product_category").attr("disabled", "disabled");
							 $('#service_name').val('0');

		                    $('#inv_pid').show(); */

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
		$(`#${hiddenFieldId}`).val(SelectedCode);
		$('#supplier_id1').val(SelectedCode);
	
	//	get_cost(SelectedCode);
		return SelectedCityName;
        
        
        
    }

});
		
		var  w=0;
	   $('#cust_id').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_customers',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							//$('#product_name').val('-1');
							//$('#service_name').val('-1');
							//console.log(p);
							
							 w++;
							 $('#customer_id').val('-1');
							/* $('#cost').val('0');
							 $('#mat_pid').hide();
							 $("#inv_product_category").attr("disabled", "disabled");
							 $('#service_name').val('0');

		                    $('#inv_pid').show(); */

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
		$(`#${hiddenFieldId}`).val(SelectedCode);
		$('#customer_id').val(SelectedCode);
	
	//	get_cost(SelectedCode);
		return SelectedCityName;
        
        
        
    }

});
		
		
		
		
		
		
		function get_mat_cat(value){
    
    var material_id = value;
    
    
    	 $.ajax({
              url : "<?php echo base_url(); ?>inventories/get_material_cat",
              data:{material_id : material_id},
              method:'POST',
              dataType:'json',
              success:function(response) {
                 // alert(response.item_code);
				var cost =  response.cost;
           var category = response.category;
           var unittype = response.unittype;
		         $('#inv_product_category').val(category);
		         $('#inv_unit_type').val(unittype);
                 //$('#cost').val(cost);
				 
				 
				 
             
            }
          }); 
}

		function get_cost(value){
    
    var material_id = value;
    var supplier_id = $('#supplier_id').val();
    if(supplier_id == 0){
        $('#supp').hide();
        $("#supplier_id").attr("disabled", "disabled");
        $('#all_supp').show();
        
    }else{
         $('#all_supp').hide();
         $('#supp').show();
        $("#supplier_id").removeAttr("disabled", "disabled");
    
    	 $.ajax({
              url : "<?php echo base_url(); ?>inventories/get_material_cost_values",
              data:{material_id : material_id, supplier_id : supplier_id},
              method:'POST',
              //dataType:'json',
              success:function(response) {
                 // alert(response.item_code);
				$('#cost_price').html(response);
				 
				 
				 
             
            }
          }); 
          
    }
}
$('document').ready(function () {  
    $('#cust_mat_name').hide();
     $('#cust_mat_name').attr('disabled','disabled');
    
    
});

function select_category(val){
    if(val == 2){
   $('#all_cust').show();
   $('#all_supp').hide();
   $('#unit_type').hide();
   $('#cust_mat_name').show();
   $('#mat_name').hide();
   $('#mat_name').attr('disabled','disabled');
   $('#cust_mat_name').removeAttr('disabled','disabled');
    }
    else{
       
   $('#all_supp').show(); 
    $('#all_cust').hide();
    $('#unit_type').show();
     $('#mat_name').show();
     $('#mat_name').removeAttr('disabled','disabled');
     $('#cust_mat_name').hide();
     $('#cust_mat_name').attr('disabled','disabled');
    
        
    }
}
		
			function get_suppliers(value){
    
    var material_id = value;
    
    
    	 $.ajax({
              url : "<?php echo base_url(); ?>inventories/get_material_suppliers",
              data:{material_id : material_id},
              method:'POST',
              //dataType:'json',
              success:function(response) {
                 // alert(response.item_code);
				$('#supp').html(response);
				 
				 
				 
             
            }
          }); 
}
		
		 var  c=0;
	   $('#product_category').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_inv_product_categories',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							$('#product_category').val('-1');
							$('#inv_product_category').val('-1');
							//console.log(p);
							
							 c++;

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
        // Save SelectedCode to hiddenfield
		 var catarr=[];
        $('.inv_category').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){		
        $(`#${hiddenFieldId}`).val(SelectedCode);
		$('#inv_product_category').val(SelectedCode);
		return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
        
        
    }

});
		
		 var  t=0;
	   $('#product_type').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_inv_product_types',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							$('#product_type').val('-1');
							$('#inv_product_type').val('-1');
							//console.log(p);
							
							 t++;

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
        // Save SelectedCode to hiddenfield
		 var catarr=[];
        $('.inv_type').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){		
        $(`#${hiddenFieldId}`).val(SelectedCode);
		$('#inv_product_type').val(SelectedCode)
		return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
        
        
    }

});
		
		
		 var  w=0;
	   $('#warehouse').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_inv_warehouses',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							$('#warehouse').val('-1');
							$('#inv_warehouse').val('-1');
							//console.log(p);
							
							 w++;

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
        // Save SelectedCode to hiddenfield
		 var catarr=[];
        $('.inv_warehouses').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){		
        $(`#${hiddenFieldId}`).val(SelectedCode);
		$('#inv_warehouse').val(SelectedCode);
		return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
        
        
    }

});
		
		 var  m=0;
	   $('#move_type').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>inventories/get_all_inv_move_types',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							$('#move_type').val('-1');
							$('#inv_move_type').val('-1');
							//console.log(p);
							
							 m++;

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
        // Save SelectedCode to hiddenfield
		 var catarr=[];
        $('.inv_move').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){		
        $(`#${hiddenFieldId}`).val(SelectedCode);
		$('#inv_move_type').val(SelectedCode);
		
		return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
        
        
    }

});
		
		
		function checkValue2(value,arr){
    var status = 'Not exist';
    //console.log(arr.length);
    //return false;
    for(var i=0; i<arr.length; i++){
      var name = arr[i];
      //console.log(name);
      //console.log(value);
      if(name == value){
        status = 'Exist';
        break;
      }
    }
    return status;
  }
   
</script>