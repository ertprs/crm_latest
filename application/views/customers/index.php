<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content quote-single leads-table" style="padding: 0px" ng-controller="Customers_Controller">
  <style type="text/css">
  rect.highcharts-background {
    fill: #f3f3f3;
  }
  
  .highcharts-point {
	  cursor:pointer;
  }
  
.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: ''; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: ''; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }
  </style>
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <div class="row">
          <div class="col-md-12 leads-table orders-table top-m40">
            <div class="leads-inner"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="File">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('customers'); ?><small>(<span ng-bind="customers.length"></span>)</small>
        </h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="customer_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword') ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><ion-icon name="search-outline"></ion-icon></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
          <md-icon><ion-icon name="filter-circle-outline"></ion-icon></md-icon>
        </md-button>
        <?php if (check_privilege('customers', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
            <md-icon><ion-icon name="add-circle"></ion-icon></md-icon>
          </md-button>
        <?php } ?>
        <?php if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {?>
        <md-menu md-position-mode="target-right target" ng-cloak>
          <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
            <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4">
            <?php if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {?> 
              <md-menu-item>
                <md-button ng-click="ImportCustomersNav()">
                  <div layout="row" flex>
                    <p flex ng-bind="lang.importcustomers"></p>
                    <md-icon md-menu-align-target class="ion-upload text-muted" style="margin: auto 3px auto 0;">
                    </md-icon>
                  </div>
                </md-button>
              </md-menu-item>
            <?php } ?>
            <?php echo form_open_multipart('customers/exportdata', array("class" => "form-horizontal")); ?>
            <md-menu-item>
              <md-button type="submit">
                <div layout="row" flex>
                  <p flex ng-bind="lang.exportcustomers"></p>
                  <md-icon md-menu-align-target class="ion-android-download text-muted" style="margin: auto 3px auto 0;"></md-icon>
                </div>
              </md-button>
            </md-menu-item>
            <?php echo form_close(); ?>
          </md-menu-content>
        </md-menu>
        <?php }?>
      </div>
    </md-toolbar>
    <div ng-show="customersLoader" layout-align="center center" class="text-center" id="circular_loader" ng-cloak>
      <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading') . ' ' . lang('customers') . '...' ?></strong></small></span>
      </p>
    </div>
    <md-content ng-show="!customersLoader" class="bg-white" ng-cloak>
      <md-table-container ng-show="customers.length > 0">
        <table md-table md-progress="promise">
          <thead md-head md-order="customer_list.order">
            <tr md-row>
              <th md-column><span>#</span></th>
              <th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
              <th md-column md-order-by="group"><span><?php echo lang('group'); ?></span></th>
              <th md-column md-order-by="address"><span><?php echo lang('address'); ?></span></th>
              <th md-column md-order-by="balance"><span><?php echo lang('balance'); ?></span></th>
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="customer in customers | orderBy: customer_list.order | filter: customer_search | filter: FilteredData | limitTo: customer_list.limit : (customer_list.page -1) * customer_list.limit" class="cursor" ng-click="goToLink('customers/customer/'+customer.id)">
              <td md-cell>
                <strong>
                  <a class="link" ng-href="<?php echo base_url('customers/customer/') ?>{{customer.id}}"> <span ng-bind="customer.customer_number"></span></a>
                </strong>
              </td>
              <td md-cell>
                <strong><span ng-bind="customer.name"></span></strong><br>
                <small class="blur" ng-bind="customer.email"></small>
              </td>
              <td md-cell>
                <strong><span class="badge" ng-bind="customer.group_name"></span></strong>
              </td>
              <td md-cell>
                <span class="blur" ng-bind="customer.address"></span><br>
                <strong><span ng-bind="customer.phone"></span></strong>
              </td>
              <td md-cell>
                <strong ng-bind-html="customer.balance | currencyFormat:cur_code:null:true:cur_lct"></strong>
              </td>
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="customers.length > 0" md-limit="customer_list.limit" md-limit-options="limitOptions" md-page="customer_list.page" md-total="{{customers.length}}"></md-table-pagination>
      <md-content ng-show="!customers.length && !customersLoader" class="md-padding no-item-data">
        <?php echo lang('notdata') ?></md-content>
    </md-content>

</div>
</div>
</div>



  </div>
  <!-- <ciuis-sidebar ng-show="!customersLoader"></ciuis-sidebar> -->
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar right-sidebar">
    <div class="right-sidebar-inner">
      <div class="panel-default panel-table borderten lead-manager-head">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('customer') . ' ' . lang('group'); ?>
            <md-button ng-click="CreateGroup()" class="md-icon-button pull-right" aria-label="New" ng-cloak>
              <md-icon><i class="ion-gear-a text-muted"></i></md-icon>
            </md-button>
            <br>
        </div>
      </md-toolbar>
      <div class="tasks-status-stat">
        <div class="widget-chart-container">
          <div class="widget-counter-group widget-counter-group-right">
            <div style="width: auto" class="pull-left"> <i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
              <div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
                <h4 style="padding: 0px;margin: 0px;">
                  <b><?php echo lang('customers') . ' ' . lang('noteby') . ' ' . lang('group') ?></b>
                </h4>
                <small><?php echo lang('customer') . ' ' . lang('stats') ?></small>
              </div>
            </div>
          </div>
          <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <md-sidenav class="md-sidenav-right create-form md-whiteframe-4dp" md-component-id="Create" style="width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
        <!-- <md-switch ng-model="isIndividual" aria-label="Type"><strong class="text-muted"><?php echo lang('individual') ?></strong></md-switch> -->
        <md-switch ng-model="isContact" aria-label="Contact"><strong class="text-muted"><?php echo lang('create').' '.lang('contact') ?></strong></md-switch>
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('company') ?></label>
          <!-- <md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon> -->
          <input name="company" ng-model="customer.company">
        </md-input-container>
		<md-input-container class="md-block">
          <label>Business Type</label>
          <md-select placeholder="Business Type" ng-model="customer.group_id" style="min-width: 200px;" required>
            <md-select-header>
              <md-toolbar class="toolbar-white">
                <div class="md-toolbar-tools">
                  <h4 flex md-truncate>Business Type</h4>
                  <md-button class="md-icon-button" ng-click="NewGroup()" aria-label="Create New">
                    <md-icon><i class="mdi mdi-plus text-muted"></i></md-icon>
                  </md-button>
                </div>
              </md-toolbar>
            </md-select-header>
            <md-option ng-value="name.id" ng-repeat="name in group">{{name.name}}</md-option>
          </md-select>
          <br />
        </md-input-container>
		<!--
		<md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('status'); ?></label>
          <md-select required ng-model="customer.statuss" name="statuss" style="min-width: 200px;" >
            <md-option ng-value="status.id" ng-repeat="status in statuss">{{status.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>-->
		<!--
		<md-input-container class="md-block">
          <label>Company Address</label>
          <textarea ng-model="customer.company_address" name="company_address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
        </md-input-container>-->
		<!--<md-input-container class="md-block">
          <label>Contact Person Office</label>
          <input name="contact_number_office" ng-model="customer.contact_number_office">
        </md-input-container>-->
		<md-input-container class="md-block">
          <label>Contact Person (Accounts)</label>
           <input name="account_contact_number" ng-model="customer.account_contact_number">
        </md-input-container>
		<md-input-container class="md-block">
          <label>Contact Person Email(Accounts)</label>
          <input name="email" ng-model="customer.email" required minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/">
        </md-input-container>
		<md-input-container class="md-block">
          <label>Company <?php echo lang('address') ?></label>
          <textarea ng-model="customer.address" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
        </md-input-container> 
        <!--<md-input-container class="md-block password-input" ng-show="isContact == true">
          <label><?php echo lang('password') ?></label>
          <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
          <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
        </md-input-container>-->
		 <md-input-container class="md-block">
          <label><?php echo $appconfig['tax_label'] . ' ' . lang('taxofficeedit'); ?></label>
          <input name="taxoffice" ng-model="customer.taxoffice">
        </md-input-container>
		<md-input-container class="md-block">
          <label><?php echo $appconfig['tax_label'] . ' ' . lang('taxnumberedit'); ?></label>
          <input name="taxnumber" ng-model="customer.taxnumber">
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
          <label><?php echo lang('customerweb'); ?></label>
          <input name="web" ng-model="customer.web">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id" ng-change="getStates(customer.country_id)" name="country_id" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('state'); ?></label>
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="customer.state_id" name="state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
          </md-select><br />
        </md-input-container>
		<!--
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="customer.city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('town'); ?></label>
          <input name="town" ng-model="customer.town">
        </md-input-container>-->
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="customer.zipcode">
        </md-input-container>
		
		 <h5>Trade Details</h5>

 
   <md-input-container >
      <label for="licence_no">Licence No.</label>
     <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no" ng-model="customer.licence_no">
	 </md-input-container>
  
	 <md-input-container>
      <label for="expiry_date"> Expiry Date</label>
	  <md-datepicker name="trade_expiry_date" ng-model="customer.trade_expiry_date" md-open-on-focus></md-datepicker>
	  </md-input-container>
	  
	  
   
   
 <md-input-container class="md-block">
      <label for="inputAddress"> Documents</label><br>
  <input type="file" multiple  id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" ></div> 
  </md-input-container>
  
   <md-input-container class="md-block">
    <label for="inputAddress">Terms And Conditions</label>
    <textarea type="text"  id="terms_and_conditions" placeholder="Terms And Conditions" name="terms_and_conditions" ng-model="customer.terms_and_conditions" md-maxlength="500" rows="3"></textarea>
  </md-input-container class="md-block">
   <md-input-container class="md-block">
    <label for="inputAddress">Notes</label>
    <textarea type="text" class="" id="notes" placeholder="Notes" name="notes" ng-model="customer.notes"md-maxlength="500" rows="3"></textarea>
  </md-input-container>
  
		<label>Individual/Team</label>
		<div class="switchToggle">
		    
			<div class="row">
				<div class="col-md-1"><i class="fa fa fa-user fa-2x" style="padding-left:15%;"></i></div>
				<div class="col-md-2">
					<input type="checkbox" id="switch" ng-model='customer.is_individual' ><label for="switch">Toggle</label>
				</div>
				<div class="col-md-9"><i class="fa fa fa-users fa-2x" style="padding-left:8%;"></i></div>
			</div>
		</div>
		
		<md-input-container class="md-block">
          <label>Sales Managers </label>
          <md-select placeholder="Sales Managers" name="main_sales_person" style="min-width: 200px;" ng-model="customer.main_sales_person" required ng-change="selectSaleTeam(customer.main_sales_person)">
            <?php 
            foreach ($saleswise as $eachsale) { ?>
              <md-option ng-value='"<?php echo $eachsale['id'] ?>"'><?php echo $eachsale['staffname']; ?></md-option>
            <?php } ?>
          </md-select>
        </md-input-container>
		<md-input-container class="md-block" id="sale_team_div" style="display:none">
          <label>Sales Team</label>
          <md-select placeholder="Sales Team" name="sales_team[]" style="min-width: 200px;" ng-model="customer.sales_team" multiple required>
            <?php 
            
            foreach ($saleswise as $eachsale) { ?>
              <md-option disabled class="sales_team_opt" ng-value='"<?php echo $eachsale['id'] ?>"'><?php echo $eachsale['staffname']; ?></md-option>
            <?php } ?>
          </md-select>
        </md-input-container>
		
		
		  <md-input-container class="md-block">
          <label><?php echo lang('default_payment_method'); ?></label>
          <md-select placeholder="<?php echo lang('default_payment_method'); ?>" ng-model="customer.default_payment_method" name="default_payment_method" style="min-width: 200px;">
            <?php 
            $gateways = get_active_payment_methods();
            foreach ($gateways as $gateway) { ?>
              <md-option ng-value='"<?php echo $gateway['relation'] ?>"'><?php echo lang($gateway['relation'])?lang($gateway['relation']):$gateway['name'] ?></md-option>
            <?php } ?>
          </md-select>
        </md-input-container>
        <br>
		
		 <md-input-container class="md-block">
      <label for="creditperiod">Credit Period(Days)</label>
      <input type="number" class=" required" required id="creditperiod" placeholder="Credit Period" name="creditperiod" ng-model="customer.creditperiod">
    </md-input-container>
     <md-input-container class="md-block">
      <label for="creditlimit">Credit Limit(AED)</label>
      <input type="text" class=" required" required id="creditlimit" placeholder="Credit Limit" name="creditlimit" ng-model="customer.creditlimit">
    </md-input-container>
	<!--<md-input-container class="md-block" ng-show"isContact == true">
		<label><?php echo lang('contactname') ?></label>
		<input type="text" name="contactname" ng-model="customer.contactname">
	</md-input-container>
	<md-input-container class="md-block" ng-show"isContact == true">
		<label><?php echo lang('contact').' '.lang('email') ?></label>
		<input name="email" name="contactemail" ng-model="customer.contactemail" required minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/">
	</md-input-container>-->	
	<md-slider-container> <span><?php echo lang('riskstatus'); ?></span>
          <md-slider flex min="0" max="100" ng-model="customer.risk" aria-label="red" id="red-slider"> </md-slider>
          <md-input-container>
            <input name="risk" flex type="number" ng-model="customer.risk" aria-label="red" aria-controls="red-slider">
          </md-input-container>
        </md-slider-container>
		
      
       <!--
        <md-input-container ng-show="isIndividual == true" class="md-block">
          <label><?php echo lang('ssn'); ?></label>
          <input name="ssn" ng-model="customer.ssn" ng-pattern="/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/" />
          <div class="hint" ng-if="showHints">###-##-####</div>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('executiveupdate'); ?></label>
          <input name="executive" ng-model="customer.executive">
        </md-input-container>
      
       
      
       -->
      </md-content>
      <md-subheader class="md-primary">
        <md-truncate><?php echo lang('billing_address') ?></md-truncate>
        <md-button ng-click='SameAsCustomerAddress()' class="md-icon-button" aria-label="Copy Customer Address">
          <md-icon class="ion-ios-copy">
            <md-tooltip md-direction="top"><?php echo lang('same_as_customer') ?></md-tooltip>
          </md-icon>
        </md-button>
        <md-button class="pull-right hide-pinned-projects md-icon-button" aria-label="<?php echo lang('billing_address') ?>">
          <a data-toggle="collapse" data-parent="#billing_address" href="#billing_address">
            <md-icon class="ion-chevron-down">
            </md-icon>
          </a>
        </md-button>
      </md-subheader>
      <md-content layout-padding id="billing_address" class="panel-collapse collapse out">
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="customer.billing_street" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.billing_country" ng-change="getBillingStates(customer.billing_country)" name="billing_country" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('state'); ?></label>
          <md-select placeholder="<?php echo lang('states'); ?>" ng-model="customer.billing_state_id" name="billing_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in billingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="customer.billing_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="customer.billing_zip">
        </md-input-container>
        <br>
      </md-content>
      <md-subheader class="md-primary">
        <md-truncate><?php echo lang('shipping_address') ?></md-truncate>
        <md-button ng-click='SameAsBillingAddress()' class="md-icon-button" aria-label="Favorite">
          <md-icon class="ion-ios-copy">
            <md-tooltip md-direction="top"><?php echo lang('same_as_billing') ?></md-tooltip>
          </md-icon>
        </md-button>
        <md-button class="pull-right hide-pinned-projects md-icon-button" aria-label="<?php echo lang('shipping_address') ?>">
          <a data-toggle="collapse" data-parent="#shipping_address" href="#shipping_address">
            <md-icon class="ion-chevron-down">
            </md-icon>
          </a>
        </md-button>
      </md-subheader>
      <md-content layout-padding id="shipping_address" class="panel-collapse collapse out">
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="customer.shipping_street" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.shipping_country" ng-change="getShippingStates(customer.shipping_country)" name="shipping_country" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('state'); ?></label>
          <md-select placeholder="<?php echo lang('states'); ?>" ng-model="customer.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="customer.shipping_city">
        </md-input-container>

        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="customer.shipping_zip">
        </md-input-container>
      </md-content>
      <custom-fields-vertical></custom-fields-vertical>
      <md-content class="layout-padding">
    </md-content>
      <md-content layout-padding>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="AddCustomer()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
            <span ng-hide="saving == true"><?php echo lang('create'); ?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20">
            </md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateGroup" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
        <md-truncate><?php echo lang('groups') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content>
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <h4 class="text-bold text-muted" flex><?php echo lang('customer') . ' ' . lang('groups') ?></h4>
          <?php if (check_privilege('customers', 'create')) { ?> 
            <md-button aria-label="Add Status" class="md-icon-button" ng-click="NewGroup()">
              <md-tooltip md-direction="bottom"><?php echo lang('add') . ' ' . lang('customer') . ' ' . lang('group') ?>
            </md-tooltip>
            <md-icon><i class="ion-plus-round text-success"></i></md-icon>
          </md-button>
        <?php } ?>
        </div>
      </md-toolbar>
      <md-list-item ng-repeat="name in group" class="noright" ng-click="EditGroup(name.id,name.name, $event)" aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
        <?php if (check_privilege('customers', 'edit')) { ?> 
          <md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit group"></md-icon>
        <?php } if (check_privilege('customers', 'delete')) { ?> 
          <md-icon ng-click='DeleteCustomerGroup($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b"></md-icon>
        <?php } ?>
      </md-list-item>
    </md-content>
  </md-sidenav>

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ImportCustomersNav" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
        <md-truncate><?php echo lang('importcustomers') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content>
      <?php echo form_open_multipart('customers/customersimport'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="name">
            <?php echo lang('choosecsvfile'); ?>
          </label>
          <div class="file-upload">
            <div class="file-select">
              <div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span>
                <?php echo lang('attachment') ?>
              </div>
              <div class="file-select-name" id="noFile">
                <?php echo lang('notchoise') ?>
              </div>
              <input type="file" name="userfile" id="chooseFile" required="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" file-model="customer_file">
            </div>
          </div>
        </div>
        <br>
        <div class="well well-sm"><?php echo lang('importcustomersinfo'); ?></div>
      </div>
      <div class="modal-footer">
        <a href="<?php echo base_url('uploads/samples/customerimport.xls') ?>" class="btn btn-success pull-left"><?php echo lang('downloadsample'); ?></a>
        <button type="button" ng-click="importCustomer()" class="btn btn-default"><?php echo lang('save'); ?></button>
      </div>
      <?php echo form_close(); ?>
      <div ng-show="importerror">
        <md-content>
          <ul>
            <li ng-repeat="error in errors">
              <p><?php echo lang('row') . ' ' ?>{{error.line}}<?php echo ' ' . lang('importSkipError') ?></p>
            </li>
          </ul>
        </md-content>
      </div>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in customers[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'name' && prop != 'address' && prop != 'email' && prop != 'phone' && prop != 'balance' && prop != 'customer_id' && prop != 'contacts' && prop != 'billing_street' && prop != 'billing_city' && prop != 'billing_state_id' && prop != 'billing_state' && prop != 'billing_zip' && prop != 'billing_country_id' && prop != 'billing_country' && prop != 'shipping_street' && prop != 'shipping_city' && prop != 'shipping_state' && prop != 'shipping_state_id' && prop != 'shipping_zip' && prop != 'shipping_country' && prop != 'shipping_country_id' && prop != 'customer_country' && prop != 'default_payment_method' && prop != 'state_id' && prop != 'group_name' && prop != 'group_id' && prop != 'customer_number'">
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
var lang = {};
lang.customer = '<?php echo lang('customer') ?>';
lang.group = '<?php echo lang('group') ?>';
lang.new = '<?php echo lang('new') ?>';
lang.name = '<?php echo lang('name') ?>';
lang.add = '<?php echo lang('add') ?>';
lang.cancel = '<?php echo lang('cancel') ?>';
lang.save = '<?php echo lang('save') ?>';
lang.edit = '<?php echo lang('edit') ?>';
lang.doIt = '<?php echo lang('doIt') ?>';
lang.attention = '<?php echo lang('attention') ?>';
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/customers.js') ?>"></script>
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

$(document).on('click', '.highcharts-label', function() {
	var chartGroup = $(this).find('tspan').html();
	
});

$(document).on('click', '.close-div', function(){
	
    $(this).closest("#clients-edit-wrapper").remove();
});


$(document).on('change', '#switch', function(){
	if(this.checked){
		$('#sale_team_div').fadeIn('slow');
	}else{
		$('#sale_team_div').fadeOut('slow');
	}
});

</script>




<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
