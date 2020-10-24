<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.inputfile:focus + label,
.inputfile.has-focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
}
.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
}

.inputfile-6 + label {
    color: #0a9408;
}
.inputfile-6 + label {
    border: 1px solid #0a9408;
    background-color: #f1e5e6;
    padding: 0;
}

.inputfile-6:focus + label,
.inputfile-6.has-focus + label,
.inputfile-6 + label:hover {
    border-color: #09612c;
}

.inputfile-6 + label span,
.inputfile-6 + label strong {
    padding: 0.625rem 1.25rem;
    /* 10px 20px */
}

.inputfile-6 + label span {
    width:142px;
    min-height: 2em;
    display: inline-block;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: top;
}

.inputfile-6 + label strong {
    color: #eeffe8;
    background-color: #18b11c;
    display: inline-block;
}
.inputfile-6:focus + label strong,
.inputfile-6.has-focus + label strong,
.inputfile-6 + label:hover strong {
    background-color: #09612c;
}
@media screen and (max-width: 50em) {
	.inputfile-6 + label strong {
		display: block;
	}
}

</style>
<div class="ciuis-body-content" ng-controller="Expenses_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
					<md-icon><i class="ico-ciuis-expenses text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate ><?php echo lang(' New Expense') ?></h2>
				<!---<md-switch ng-model="newexpense.internal" aria-label="Internal" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('mark_as_internal_expense') ?></md-tooltip>
					<strong class="text-muted"><?php echo lang('internal') ?></strong>
					<md-tooltip md-direction="bottom"><?php echo lang('mark_as_internal_expense') ?></md-tooltip>
				</md-switch>
				<md-switch ng-model="expense_recurring" aria-label="Recurring" ng-cloak> <strong class="text-muted"><?php echo lang('recurring') ?></strong> </md-switch>-->
				<md-button ng-href="<?php echo base_url('expenses')?>" class="md-icon-button" aria-label="Save" ng-cloak>
					<md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
					<md-icon><i class="ion-close-circled text-danger"></i></md-icon>
				</md-button>
				<md-button type="submit" ng-click="AddExpense()" class="md-icon-button" aria-label="Save" ng-cloak>
					<md-progress-circular ng-show="savingExpense == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					<md-tooltip ng-hide="savingExpense == true" md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
					<md-icon ng-hide="savingExpense == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
				</md-button>
			</div>
		</md-toolbar>
		<div ng-show="expensesLoader" layout-align="center center" class="text-center" id="circular_loader">
			<md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
			<p style="font-size: 15px;margin-bottom: 5%;">
				<span><?php echo lang('loading'). ' '. lang('please_wait'). '....' ?> <br> </span>
			</p>
		</div>
		<md-content ng-show="!expensesLoader" class="bg-white" layout-padding ng-cloak>
			<div layout-gt-xs="row">
				<!----<md-input-container required class="md-block" flex-gt-sm>
						<label><?php echo lang('title')?></label>
						<input required ng-model="newexpense.title" name="title">
					</md-input-container>
					<md-input-container class="md-block" flex-gt-xs>
						<label><?php echo lang('category'); ?></label>
						<md-select required ng-model="newexpense.category" name="category" style="min-width: 200px;">
							<md-option ng-value="category.id" ng-repeat="category in categories">{{category.name}}</md-option>
						</md-select>
					</md-input-container>---><br>
			
					<!----<md-select  placeholder="<?php echo lang('Choose vendor'); ?>" ng-model="newexpense.customer" name="customer" data-md-container-class="selectdemoSelectHeader">
						<md-select-header class="demo-select-header">
							<label style="display: none;"><?php echo lang('search').' '.lang('vendor')?></label>
							<md-input-container>
								<input ng-model="searchTerm" type="search" ng-model-options="{debounce: {'default': 1000, 'blur': 0}}"
								placeholder="Search..." class="demo-header-searchbox md-text"/>
							</md-input-container>
							<!----<input ng-submit="search_customers(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search').' '.lang('vendor')?>" class="demo-header-searchbox md-text" ng-keyup="search_customers(search_input)">--
						</md-select-header>
							<md-optgroup label="customers">
							<md-option ng-value='' >Choose One</md-option>
								<md-option ng-value="customer.id" ng-repeat="customer in vendors  | filter:searchTerm">
									
									<span class="blur" ng-bind="customer.vendor_number"></span> 
									<strong ng-bind="customer.name"></strong>
								</md-option>
							</md-optgroup>
					</md-select>	---->
				<div class="col-sm-5" style="margin-top: 14px;">	
					<md-autocomplete
						id="custom-template"
						ng-disabled="isDisabled"
						md-no-cache="noCache"
						md-selected-item="selectedItem"
						md-search-text-change="searchTextChange(itemcut.name)"
						md-search-text="itemcut.name"
						md-selected-item-change="selectedItemChange(itemcut)"
						md-items="itemcut in querySearch(itemcut.name)"
						md-item-text="itemcut.name"
						md-min-length="0"
						md-escape-options="clear"
						input-aria-label="Vendors"
						placeholder="Choose Vendor"
						md-menu-class="autocomplete-custom-template"
						md-menu-container-class="custom-container">
						<md-item-template>
							<span class="item-title">
								<strong>{{itemcut.vendor_number}} </strong>{{itemcut.name}}
							</span> 
						</md-item-template>
					</md-autocomplete>
					<input class="min_input_width" type="hidden" ng-model="itemcut.name">
						<bind-expression ng-init="selectedItem.name = itemcut.name" expression="selectedItem.name" ng-model="itemcut.name" />
					
						<input class="min_input_width" type="hidden" ng-model="itemcut.id">
						<bind-expression ng-init="selectedItem.id = itemcut.id" expression="selectedItem.id" ng-model="itemcut.id" />
				</div>
				<md-input-container class="md-block">
					 <label><?php echo lang('date') ?></label>
					<input mdc-datetime-picker="" date="true" time="false" type="text" id="created" placeholder="<?php echo lang('date') ?>" required show-todays-date="" minutes="true" min-date="" show-icon="true" ng-model="newexpense.date"  name="created"  class=" dtp-no-msclear dtp-input md-input" >
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('reference')?></label>
					<input ng-model="newexpense.number" name="newexpense.number">
				</md-input-container>
				<!---<md-input-container class="md-block" flex-gt-xs ng-show="newexpense.internal">
					<label><?php echo lang('staff'); ?></label>
					<md-select required placeholder="<?php echo lang('choisestaff'); ?>" ng-model="newexpense.staff" name="customer" style="min-width: 200px;">
						<md-option ng-value="staf.id" ng-repeat="staf in staff">{{staf.name}}</md-option>
					</md-select>
				</md-input-container>--->
			</div>
			<div layout-gt-xs="row">
				<div class="col-sm-3" >
				<label class="radio-inline"><input type="radio" name="Cash"  value="1"  ng-model="newexpense.amountType" ng-click="setvalue(1)">Cash</label>
				<label class="radio-inline"><input type="radio" name="Card" value="2"  ng-model="newexpense.amountType" ng-click="setvalue(2)">Card</label>
				</div>
				<div class="col-sm-6" ng-show="newexpense.amountType==1">
					<md-input-container class="md-block" flex-gt-xs style="margin-top: -11px;">
					<label><?php echo lang('Select Cash Account'); ?></label>
						<md-select  ng-model="newexpense.account" name="account" style="min-width: 200px;">
							<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
						</md-select>
					</md-input-container>
				</div>
				<div class="col-sm-6" ng-show="newexpense.amountType==2">
					<md-input-container class="md-block" flex-gt-xs style="margin-top: -11px;">
						<label><?php echo lang('Select Card'); ?></label>
						<md-select  ng-model="newexpense.card" name="card" style="min-width: 200px;">
							<md-option ></md-option>
						</md-select>
					</md-input-container>
				</div>
				 <!---<md-input-container>
				  <label><?php echo lang('date') ?></label>
				  <md-datepicker required name="created" ng-model="newexpense.date" md-open-on-focus></md-datepicker>
				  <md-tooltip md-direction="top"><?php echo lang('expense').' '.lang('date') ?></md-tooltip>
				</md-input-container>---><br>
			</div>
			<div ng-show="expense_recurring" layout-gt-xs="row">
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_period') ?></label>
					<input type="number" ng-value="1" value="1" ng-init="recurring_period = 1" min="1" ng-model="recurring_period" name="recurring_period">
				</md-input-container>
				<md-input-container class="md-block" flex-gt-xs>
					<label><?php echo lang('recurring_type') ?></label>
					<md-select ng-model="recurring_type" name="recurring_type">
						<md-option value="0"><?php echo lang('days') ?></md-option>
						<md-option value="1"><?php echo lang('weeks') ?></md-option>
						<md-option value="2" selected><?php echo lang('months') ?></md-option>
						<md-option value="3"><?php echo lang('years') ?></md-option>
					</md-select>
				</md-input-container><br>
				<md-input-container>
					<label><?php echo lang('ends_on') ?></label>
					<md-datepicker md-min-date="date" name="EndRecurring" ng-model="EndRecurring" style="min-width: 100%;" md-open-on-focus></md-datepicker>
					<div >
						<div ng-message="required" class="my-message"><?php echo lang('leave_blank_for_lifetime') ?></div>
					</div>
				</md-input-container>
			</div>
		</md-content>
		<md-content ng-show="!expensesLoader" class="bg-white" layout-padding ng-cloak>
			<md-list-item ng-repeat="item in newexpense.items">
				<div layout-gt-sm="row">
					<md-autocomplete
						md-autofocus
						md-items="product in Getmaterial(item.name)"
						md-search-text="item.name"
						md-item-text="product.name"   
						md-selected-item="selectedProduct"
						md-no-cache="true"
						md-min-length="0"
						md-floating-label="<?php echo lang('productservice'); ?>">
						<md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.cost | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
					</md-autocomplete>
					<md-input-container class="md-block">
						<label><?php echo lang('description'); ?></label>
						<input class="min_input_width" type="hidden" ng-model="item.name">
						<bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
						<textarea class="min_input_width" ng-model="item.description" placeholder="<?php echo lang('description'); ?>"></textarea>
						<bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
						<input class="min_input_width" type="hidden" ng-model="item.product_id">
						<bind-expression ng-init="selectedProduct.id = item.product_id" expression="selectedProduct.id" ng-model="item.product_id" />
						<input class="min_input_width" type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
						<bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-sm>
						<label><?php echo lang('quantity'); ?></label>
						<input class="min_input_width" ng-model="item.quantity" >
					</md-input-container>
					<!---- <md-input-container class="md-block" flex-gt-xs>
						<label><?php echo lang('unit'); ?></label>
						<input class="min_input_width" ng-model="item.unit" >
						<bind-expression ng-init="selectedProduct.unit = item.unit" expression="selectedProduct.unit" ng-model="item.unit" />
					</md-input-container>--->
					<md-input-container class="md-block">
						<label><?php echo lang('Price'); ?></label>
						<input class="min_input_width" ng-model="item.price">
						<bind-expression ng-init="selectedProduct.cost = 0" expression="selectedProduct.cost" ng-model="item.price" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-xs>
						<label><?php echo lang('account'); ?></label>
						<md-select placeholder="<?php echo 'Select Account' ?>" ng-model="item.account" name="account">
							<md-option ng-value="chartaccount.id" ng-repeat="chartaccount in chartaccounts">{{chartaccount.account_code}} {{chartaccount.account_name}}</md-option>
						</md-select><br>
					</md-input-container>
					<md-input-container class="md-block" flex-gt-xs>
						<label><?php echo $appconfig['tax_label']; ?> (%)</label>
						<input class="min_input_width" ng-model="item.tax">
						<bind-expression ng-init="selectedProduct.tax = 0" expression="selectedProduct.tax" ng-model="item.tax" />
					</md-input-container>
					<md-input-container class="md-block" flex-gt-xs>
						<label><?php echo 'Project'; ?></label>
						<md-select placeholder="<?php echo 'Select Project' ?>" ng-model="item.project_id" name="customer">
							<md-option ng-value="project.id" ng-repeat="project in projects">{{project.name}}</md-option>
						</md-select><br>
					</md-input-container>
					<!-- <md-input-container class="md-block" flex-gt-sm>
					<label><?php echo lang('discount'); ?></label>
					<input ng-model="item.discount">
					</md-input-container> -->
					<md-input-container class="md-block">
						<label><?php echo lang('total'); ?></label>
						<input class="min_input_width" disabled="" ng-value="item.quantity * item.price + ((item.tax)/100*item.quantity * item.price) - ((item.discount)/100*item.quantity * item.price)">
					</md-input-container>
				</div>
				<md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
			</md-list-item>
			<md-content class="bg-white" layout-padding>
				<div class="col-md-6">
					<md-button ng-click="add()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
						<md-icon class="ion-plus-round text-muted"></md-icon>
					</md-button>
				</div>
				<div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
					<div class="col-md-7">
						<div class="text-right text-uppercase text-muted"><?php echo lang('subtotal') ?>:</div>
						<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
						<div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted"><?php echo lang('total'). ' '.$appconfig['tax_label'] ?>:</div>
						<div class="text-right text-uppercase text-black"><?php echo lang('grandtotal') ?>:</div>
					</div>
					<div class="col-md-5">
						<div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
						<div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
					</div>
				</div>
			</md-content>
		</md-content>
		<custom-fields-vertical></custom-fields-vertical>
	</div>
	<div class="main-content container-fluid lg-pl-0 col-xs-12 col-md-12 col-lg-3">
		<md-toolbar class="toolbar-white">
			<div class="col-sm-12 files">
				<h2 flex style="margin-top: 9px;">
					<i class="ion-document text-muted"></i> 
					<?php echo lang('files') ?>
				</h2>
				<div class=" file_upload" >
					<input type="file" name="upload_file" id="upload_file" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" required  multiple  style="display:none" document-upload >
					<label for="upload_file"><span></span> <strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="5" viewBox="0 0 20 17"></svg> Choose a file&hellip;</strong></label>
				</div> 
				
			</div><br>
		</md-toolbar>								
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateCustomer"  ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
				<h2 flex md-truncate><?php echo lang('create') ?></h2>
				<md-switch ng-model="isIndividual" aria-label="Type"><strong class="text-muted"><?php echo lang('individual') ?></strong></md-switch>
			</div>
		</md-toolbar>
		<md-content flex>
			<md-content layout-padding>
				<md-input-container ng-show="isIndividual != true" class="md-block">
					<label><?php echo lang('company'); ?></label>
					<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
					<input  md-autofocus name="company" ng-model="customer.company">
				</md-input-container>
				<md-input-container ng-show="isIndividual == true" class="md-block">
					<label><?php echo lang('namesurname'); ?></label>
					<md-icon md-svg-src="<?php echo base_url('assets/img/icons/individual.svg') ?>"></md-icon>
					<input name="namesurname" ng-model="customer.namesurname">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo $appconfig['tax_label'].' '.lang('taxofficeedit'); ?></label>
					<input name="taxoffice" ng-model="customer.taxoffice">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo $appconfig['tax_label'].' '.lang('taxnumberedit'); ?></label>
					<input name="taxnumber" ng-model="customer.taxnumber">
				</md-input-container>
				<md-input-container ng-show="isIndividual == true" class="md-block">
					<label><?php echo lang('ssn'); ?></label>
					<input name="ssn" ng-model="customer.ssn" ng-pattern="/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/" />
					<div class="hint" ng-if="showHints">###-##-####</div>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('executiveupdate'); ?></label>
					<input name="executive" ng-model="customer.executive">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('phone'); ?></label>
					<input name="phone" ng-model="customer.phone">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('fax'); ?></label>
					<input name="fax" ng-model="customer.fax">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('email'); ?></label>
					<input name="email" ng-model="customer.email" required minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/" />
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('customerweb'); ?></label>
					<input name="web" ng-model="customer.web">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id" name="country_id" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<input name="state" ng-model="customer.state">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="customer.city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('town'); ?></label>
					<input name="town" ng-model="customer.town">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="customer.zipcode">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="customer.address" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				<md-slider-container> <span><?php echo lang('riskstatus');?></span>
					<md-slider flex min="0" max="100" ng-model="customer.risk" aria-label="red" id="red-slider"> </md-slider>
					<md-input-container>
						<input name="risk" flex type="number" ng-model="customer.risk" aria-label="red" aria-controls="red-slider">
					</md-input-container>
				</md-slider-container>
			</md-content>
			<md-subheader class="md-primary">
				<md-truncate><?php echo lang('billing_address') ?></md-truncate>
				<md-button ng-click='SameAsCustomerAddress()' class="md-icon-button" aria-label="Copy Customer Address">
					<md-icon class="ion-ios-copy">
						<md-tooltip md-direction="right"><?php echo lang('same_as_customer') ?></md-tooltip>
					</md-icon>
				</md-button>
			</md-subheader>
			<md-content layout-padding>
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="customer.billing_street" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="customer.billing_city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<input name="state" ng-model="customer.billing_state">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="customer.billing_zip">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.billing_country" name="billing_country" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container> <br>
			</md-content>
			<md-subheader class="md-primary">
				<md-truncate><?php echo lang('shipping_address') ?></md-truncate>
				<md-button ng-click='SameAsBillingAddress()' class="md-icon-button" aria-label="Favorite">
					<md-icon class="ion-ios-copy">
						<md-tooltip md-direction="right"><?php echo lang('same_as_billing') ?></md-tooltip>
					</md-icon>
				</md-button>
			</md-subheader>
			<md-content layout-padding>
				<md-input-container class="md-block">
					<label><?php echo lang('address') ?></label>
					<textarea ng-model="customer.shipping_street" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="customer.shipping_city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<input name="state" ng-model="customer.shipping_state">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="customer.shipping_zip">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.shipping_country" name="shipping_country" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container>
				<br>
			</md-content>
			<md-content layout-padding>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
				  <md-button ng-click="AddCustomer()" class="template-button" ng-disabled="saving == true">
					<span ng-hide="saving == true"><?php echo lang('create');?></span>
					<md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
				  </md-button>
				  <!-- <md-button ng-click="AddCustomer()" class="md-raised md-primary pull-right"><?php echo lang('create');?></md-button> -->
				</section>
			</md-content>
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/expenses.js') ?>"></script>
<script src="<?php echo base_url('assets/js/custom-file-input.js'); ?>"></script>
