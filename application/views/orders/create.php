<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
input.lineInput {
  background: transparent !important;
  border: none;
  border-bottom: 1px solid rgba(0,0,0,0.12);
  -webkit-box-shadow: none;
  box-shadow: none;
  border-radius: 0;
}

input.lineInput:focus {
  -webkit-box-shadow: none;
  box-shadow: none;
}

.form-control{
	height: 5px;
	border-radius:10px;
}

.marginTop5 {
	margin-top:5%;
}

.marginTop10 {
	margin-top:10%;
}

.ck-editor__editable{
	height:200px;
}	
</style>
<div class="ciuis-body-content leads-table create-order" ng-controller="Orders_Controller">
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-10 col-md-offset-1"> 
	  <?php echo form_open('orders/add',array("class"=>"form-horizontal orderForm")); ?>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-ios-filing-outline text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('new').' '.lang('quote') ?></h2>
        <!--<md-switch ng-model="order_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php echo lang('for_lead') ?></strong></md-switch>-->
        <md-button ng-href="<?php echo base_url('orders')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-muted"></i></md-icon>
        </md-button>
        <md-button ng-click="saveAll()" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
          <md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-content class="bg-white create-order-search" layout-padding ng-cloak>
		<div layout-gt-xs="row"><div class="col-md-12" style="text-align:right;"><span id="ProjectNameValidate"></span></div></div>
		<div layout-gt-xs="row">
			<md-input-container class="md-block create-order-input" flex-gt-sm>
				<input  name="project" class="form-control" id="projectName" placeholder="Enter Quote Name" required="" ng-model="project">
			</md-input-container>
			<md-input-container class="md-block create-order-input" flex-gt-sm>
				<input  name="reference" class="form-control" id="reference" placeholder="Enter Reference" ng-model="reference">
			</md-input-container>
			<!--<md-input-container class="md-block" flex-gt-sm>
				<md-select ng-model="staff" data-md-container-class="selectdemoSelectHeader">
					<md-select-header class="demo-select-header">
						<label style="display: none;"><?php echo lang('search').' '.lang('staff')?></label>
						<input ng-submit="search_sales_staff(search_input_staff)" ng-model="search_input_staff" type="text" placeholder="<?php echo lang('search').' '.lang('staff')?>" class="demo-header-searchbox md-text" ng-keyup="search_sales_staff(search_input_staff)">
					</md-select-header>
					<md-optgroup label="staffs">
						<md-option ng-value="staff.id" ng-repeat="staff in staffs">
							<strong ng-bind="staff.staffname"></strong><br>
						</md-option>
					</md-optgroup>
				</md-select>
			</md-input-container>-->
			<md-input-container>
			  <label><?php echo lang('dateofissuance') ?></label>
			  <md-datepicker name="created" ng-model="created" md-open-on-focus></md-datepicker>
			</md-input-container>
		</div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block create-order-input" flex-gt-sm>
          <md-select ng-model="customer" data-md-container-class="selectdemoSelectHeader" ng-change="ChangeCustomer(customer)">
          <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('customer')?></label>
            <input ng-submit="search_customers_by_access(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search').' '.lang('customers')?>" class="demo-header-searchbox md-text" ng-keyup="search_customers_by_access(search_input)">
          </md-select-header>
          <md-optgroup label="customers">
            <md-option ng-value="customer.id" ng-repeat="customer in all_customers">
              <span class="blur" ng-bind="customer.customer_number"></span> 
              <strong ng-bind="customer.name"></strong><br>
              <span class="blur">(<small ng-bind="customer.email"></small>)</span>
            </md-option>
          </md-optgroup>
        </md-select>
        </md-input-container>
		<md-input-container class="md-block create-order-input" flex-gt-sm>
          <md-select ng-model="client_contact_id" data-md-container-class="selectdemoSelectHeader">
		  <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('contacts')?></label>
			<input type="text" placeholder="<?php echo lang('search').' '.lang('contacts')?>" class="demo-header-searchbox md-text">
          </md-select-header>
          <md-optgroup label="contacts">
            <md-option ng-value="contact.id" ng-repeat="contact in all_contacts">
              <strong ng-bind="contact.name"></strong><br>
            </md-option>
          </md-optgroup>
        </md-select>
        </md-input-container>
		<input type="hidden" ng-model="main_sales_team_id" name="main_sales_team_id" id="salesteamid"/>
		<!--<md-input-container class="md-block" flex-gt-sm>
          <md-select ng-model="salesteam" data-md-container-class="selectdemoSelectHeader">
		  <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('salesperson')?></label>
           <input type="text" placeholder="<?php echo lang('search').' '.lang('salesperson')?>" class="demo-header-searchbox md-text">
          </md-select-header>
			<md-optgroup label="salesteam">
				<md-option ng-value="salesteam.staff_id" ng-repeat="salesteam in all_salesteam">
				  <strong ng-bind="salesteam.staff_name"></strong><br>
				</md-option>
			</md-optgroup>
			</md-select>
        </md-input-container>-->
		<md-input-container>
          <label><?php echo lang('opentill') ?></label>
          <md-datepicker name="opentill" ng-model="opentill" md-open-on-focus></md-datepicker>
        </md-input-container>
      </div>
     <!-- <md-checkbox class="pull-right" ng-model="comment" aria-label="Comment"> <strong class="text-muted text-uppercase"><?php echo lang('allowcomments');?></strong> </md-checkbox>-->
    </md-content>
    <md-content class="bg-white" layout-padding ng-cloak>
      <md-list-item ng-repeat="item in order.items">
        <div layout-gt-sm="row">
          <!--<md-autocomplete
  	  	 	md-autofocus
  	  	 	md-items="product in GetProduct(item.name)"
		    md-search-text="item.name"
		    md-item-text="product.name"   
		    md-selected-item="selectedProduct"
		    md-no-cache="true"
		    md-min-length="0"
		    md-floating-label="<?php echo lang('productservice'); ?>">
            <md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
          </md-autocomplete>-->
		  <md-input-container class="md-block">
			 <label><?php echo lang('name'); ?></label>
			<input class="min_input_width" type="text" ng-model="item.name">
            <bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
		</md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('description'); ?></label>
            <textarea class="min_input_width" ng-model="item.description" placeholder="<?php echo lang('description'); ?>"></textarea>
            <bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
            <input class="min_input_width" type="hidden" ng-model="item.product_id">
            <bind-expression ng-init="selectedProduct.product_id = item.product_id" expression="selectedProduct.product_id" ng-model="item.product_id" />
            <input class="min_input_width" type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
            <bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('quantity'); ?></label>
            <input class="min_input_width" ng-model="item.quantity" >
          </md-input-container>
          <!--<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('unit'); ?></label>
            <input class="min_input_width" ng-model="item.unit" >
          </md-input-container>-->
          <md-input-container class="md-block">
            <label><?php echo lang('price'); ?></label>
            <input class="min_input_width" ng-model="item.price">
            <bind-expression ng-init="selectedProduct.price = 0" expression="selectedProduct.price" ng-model="item.price" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo $appconfig['tax_label']; ?></label>
            <input class="min_input_width" ng-model="item.tax">
            <bind-expression ng-init="selectedProduct.tax = 5" expression="selectedProduct.tax" ng-model="item.tax" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('discount'); ?></label>
            <input class="min_input_width" ng-change="all_discount_items(item.discount)" ng-model="item.discount">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('total'); ?></label>
            <input class="min_input_width" ng-value="item.quantity * item.price">
          </md-input-container>          
        </div>
        <md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b"></md-icon>
      </md-list-item>
      <md-content class="bg-white" layout-padding>
        <div class="col-md-12">
          <md-button ng-click="add()" class="md-fab pull-right" ng-disabled="false" aria-label="Add Line">
            <md-icon class="ion-plus-round text-muted"></md-icon>
          </md-button>
        </div>
      </md-content>
    </md-content>
      <md-content class="bg-white create-order-total">

        <div class="col-md-12" style="font-weight: 600; font-size: 16px; color: #c7c7c7;">
          <div class="col-md-8">
			<div class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
            <div class="text-right text-uppercase text-muted marginTop5"><?php echo lang('sub_total') ?>:</div>
            <div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
			<div ng-show="nettotal() > 0" class="text-right text-uppercase text-muted"><?php echo lang('net_total') ?>:</div>
            <div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted"><?php echo lang('totalvatonsales') ?>:</div>
            <div class="text-right text-uppercase text-black"><?php echo lang('grand_total') ?>:</div>
          </div>
          <div class="col-md-4">
			<div class="text-right">
				<input type="text" name="totaldiscount" id="totaldiscount" ng-change="MainDiscountCal(totaldiscount)" ng-model="totaldiscount" class="form-control lineInput" value="0">
			</div>
            <div class="text-right marginTop10" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="nettotal() > 0" class="text-right" ng-bind-html="nettotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
          </div>
        </div>
      </md-content>
	   <div layout-gt-xs="row">
        <div class="col-sm-12">
          <label><?php echo lang('Special Notes') ?></label>
          <textarea ck-editor ng-model="content" rows="3" id="quotecreatedetails"></textarea>
        </div>
      </div>
    </md-content>
    <?php echo form_close(); ?> 
	</div>
</div>
<script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<script type="text/javascript">

$('#projectName').on('change',function(){  
   var projectName = $('#projectName').val();  
   if(projectName != ''){  
		$.ajax({  
			 url:"<?php echo base_url(); ?>Orders/check_project_avalibility",  
			 method:"POST",  
			 data:{projectName:projectName},  
			 success:function(data){  
				  $('#ProjectNameValidate').html(data);  
			 }  
		});  
   }
});
</script>

