<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Supplier_Controller">
  <style type="text/css">
  rect.highcharts-background {
    fill: #f3f3f3;
  }
  .pen body {
	padding-top:50px;
}

/* Social Buttons - Twitter, Facebook, Google Plus */
.btn-twitter {
	background: #00acee;
	color: #fff
}
.btn-twitter:link, .btn-twitter:visited {
	color: #fff
}
.btn-twitter:active, .btn-twitter:hover {
	background: #0087bd;
	color: #fff
}

.btn-instagram {
	color:#fff;
	background-color:#3f729b;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:focus,.btn-instagram.focus {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:hover {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}

.btn-github {
	color:#fff;
	background-color:#444;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:focus,.btn-github.focus {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:hover {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}

/* MODAL FADE LEFT RIGHT BOTTOM */
.modal.fade:not(.in).left .modal-dialog {
	-webkit-transform: translate3d(-25%, 0, 0);
	transform: translate3d(-25%, 0, 0);
}
.modal.fade:not(.in).right .modal-dialog {
	-webkit-transform: translate3d(25%, 0, 0);
	transform: translate3d(25%, 0, 0);
}
.modal.fade:not(.in).bottom .modal-dialog {
	-webkit-transform: translate3d(0, 25%, 0);
	transform: translate3d(0, 25%, 0);
}

.modal.right .modal-dialog {
	position:absolute;
	top:0;
	right:0;
	margin:0;
}

.modal.left .modal-dialog {
	position:absolute;
	top:0;
	left:0;
	margin:0;
}

.modal.left .modal-dialog.modal-sm {
	max-width:300px;
}

.modal.left .modal-content, .modal.right .modal-content {
    min-height:100vh;
	border:0;
}


.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Blacklisted'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'Active'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }

  </style>
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="File">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('supplier'); ?><small>(<span ng-bind="customers.length"></span>)</small>
        </h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="customer_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword') ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('customers', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
        <md-menu md-position-mode="target-right target" ng-cloak>
          <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
            <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4">
          
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
              <th md-column md-order-by="name"><span><?php echo lang('name'); ?></span></th>
              <th md-column md-order-by="group"><span><?php echo lang('status'); ?></span></th>
              
              <th md-column md-order-by="email"><span>Contact Person Name</span></th>
			   <th md-column md-order-by="phone"><span>Credit Period</span></th>
			   <th md-column md-order-by="phone"><span>Credit Limit</span></th>
			     <th md-column ><span><?php echo lang('Action'); ?></span></th>
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="customer in customers | orderBy: customer_list.order | limitTo: customer_list.limit : (customer_list.page -1) * customer_list.limit | filter: customer_search | filter: FilteredData" class="cursor" >
           
              <td md-cell>
                  <div id="{{customer.name}}" onclick="supplierview(this.id)" class="table-icon deleteIcon"><a class="link cursor">{{customer.name}}</a></div>
                <strong><span ng-bind="customer.name"></span></strong>
                
              </td>
              <td md-cell>
                <strong><span class="badge" ng-bind="customer.status"></span></strong>
              </td>
              
              <td md-cell>
                <span ng-bind="customer.account_contact_number"></span>
              </td>
			   <td md-cell>
                <span ng-bind="customer.creditperiod"></span>
              </td>
               <td md-cell>
                <span ng-bind="customer.creditlimit"></span>
              </td>
              <td md-cell>
                 
           
<div id="inline">
     <div class="col-sm-3" id="{{customer.id}}" onclick="update(this.id)"><i class="ion-compose  text-muted"></i></div>
 <div class="col-sm-3" id="{{customer.id}}" onclick="deletesupplier(this.id)"><i class="ion-trash-b text-muted"></i></div>
          
            <div class="col-sm-3" ng-if="customer.trade_docs_count == 0 && customer.tax_docs_count == 0 && customer.owner_docs_count == 0" ><span  style='color:black'>-</span></div>
             <div class="col-sm-3" ng-if="customer.trade_docs_count >= 1 || customer.tax_docs_count >= 1 ||  customer.owner_docs_count >= 1"><span  class="glyphicon glyphicon-file"></span></div> 

</div>
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
<div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">

<div class="modal-body">

<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>
</div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" style="width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
      
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
	   <form id="form1" method="post" action="<?php print base_url()?>supplier/create" >
	  
  <div class="form-row">
    <div class="form-group ">
      <label for="companyname"><b>Company Full Name</b></label>
      <input type="text" class="form-control required" required id="companyname" placeholder="Company Full Name" name="companyname">
    </div>
    <!--
    <div class="form-group ">
      <label for="status">Status</label>
     <select id="status" class="form-control required" required name="status">
        <option value="">Choose...</option>
        <option>Active</option>
		<option>Black Listed</option>
      </select>
    </div> -->
     <div class="outerDivFull" >
     <div>Status</div>          
<div class="switchToggle">

    <input type="checkbox" id="switch" name="status" checked onchange="select_switch(this.value);">
    <label for="switch">Toggle</label>
   
</div>


</div>
  </div>
  <div class="form-group">
    <label for="company_address">Company Address</label>
    <textarea type="text" class="form-control required" required id="company_address" placeholder="Company Address" name="company_address"></textarea>
  </div>
 
  <div class="form-row">
   <div class="form-group ">
    <label for="contact_number_office">Contact Number Office</label>
    <input type="text" class="form-control required" required id="contact_number_office" placeholder="Contact Number Office" name="contact_number_office">
  </div>
    <div class="form-group ">
      <label for="inputCity">Contact Person (Accounts)</label>
      <input type="text" class="form-control" id="account_contact_number" placeholder="Contact Person (Accounts)" name="account_contact_number">
    </div>
    <div class="form-group ">
      <label for="inputState">email address</label>
      <input type="text" class="form-control" id="emailaddress" placeholder="email" name="emailaddress"> 
    </div>
    
  </div>
   <div class="form-row">
    <div class="form-group ">
      <label for="inputZip">Mobile Number</label>
      <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number" name="mobile_number">
    </div>
    <div class="form-group ">
      <label for="inputCity">Website</label>
      <input type="text" class="form-control" id="website" placeholder="Website" name="website">
    </div>
    <div class="form-group">
      <label for="">Country</label>
         <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id" ng-change="getStates(customer.country_id)" name="country_id" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
    </div>
    
  </div>

    <div class="form-row">
  <label for="">Trade Licence No.</label>
  </div>
  <div class="row">
   
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
    <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no">
    </div>
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
      <input type="text" class="form-control" id="expiry_date" placeholder="Expiry Date" name="expiry_date">
    </div>
	 <div class="col-sm-3 col-md-6 col-lg-4" >
      <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
    </div>
  </div>
<div class="form-row">
  <label for="">Trade Licence No.</label>
  </div>
  <div class="row">
   
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
    <input type="text" class="form-control" id="tax_registration" placeholder="Tax Registration No" name="tax_registration">
    </div>
  <!--  <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
      <input type="text" class="form-control" id="tax_expiry_date" placeholder="Expiry Date" name="tax_expiry_date">
    </div> -->
	 <div class="col-sm-3 col-md-6 col-lg-4" >
      <input type="file" multiple class="form-control-file" id="upload_file1" name="upload_file1[]" onchange="preview_image1();">
	 <div class="loder col-md-1"></div>
  <div id="image_preview1" class="col-md-12"></div> 
    </div>
  </div>

 <div class="form-row">
 <!-- <div class="form-group ">
    <label for="inputAddress">Documents of Owner</label>
     <input type="file" multiple class="form-control-file" id="upload_file2" name="upload_file2[]" onchange="preview_image2();">
	  <div class="loder col-md-1"></div>
  <div id="image_preview2" class="col-md-12"></div> 
  </div> </div> -->
  <div class="form-row">
    <div class="form-group ">
      <label for="creditperiod">Credit Period</label>
      <input type="number" class="form-control required" required id="creditperiod" placeholder="Credit Period" name="creditperiod">
    </div>
    <div class="form-group ">
      <label for="creditlimit">Credit Limit</label>
      <input type="text" class="form-control required" required id="creditlimit" placeholder="Credit Limit" name="creditlimit">
    </div>
   <div class="form-group ">
    <label for="inputAddress">Terms And Conditions</label>
    <textarea type="text" class="form-control" id="terms_and_conditions" placeholder="Terms And Conditions" name="terms_and_conditions"></textarea>
  </div>
  <div class="form-group ">
    <label for="inputAddress">Notes</label>
    <textarea type="text" class="form-control" id="notes" placeholder="Notes" name="notes"></textarea>
  </div>
    
  </div>
  <div class="form-group">
  <h2>Point of Contacts</h2>
  <div class="field_wrapper row">
  <div class="form-group col-md-4 ">
      <label for="inputZip"> Name</label>
      <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]">
    </div>
	<div class="form-group col-md-4">
      <label for="inputZip"> Number</label>
      <input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">
    </div>
	<div class="form-group col-md-3">
      <label for="inputZip">Email</label>
      <input type="text" class="form-control" id="point_contact_email" placeholder="Email"  name="point_contact_email[]">
    </div>
	<div class="form-group col-md-1">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
    <div>
            </div>
</div>
</div>
 <div class="form-group col-md-12">
    
    <input type="submit" class="btn btn-success" value="Create">
  </div>
  
</form>
       
 
      
    </md-content>
  </md-sidenav>



  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ImportCustomersNav" ng-cloak style="width: 450px;">
   
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
        <a href="<?php echo base_url('uploads/samples/customerimport.csv') ?>" class="btn btn-success pull-left"><?php echo lang('downloadsample'); ?></a>
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
lang.status = '<?php echo lang('status') ?>';
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/supplier.js') ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
<style>
#inline{height:auto;display:flex;}
.one,.two{width:30%;height:100px;margin:10px;}
.ion-trash-b{font-size:20px;}
.ion-compose{font-size:20px;}
</style>
<script>

		/*ClassicEditor
            .create( document.querySelector( '#terms_and_conditions' ) )
            .catch( error => {
                console.error( error );
            } );
			
			ClassicEditor
            .create( document.querySelector( '#notes' ) )
            .catch( error => {
                console.error( error );
            } );
            */
	$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = ' <div class="form-group col-md-4">   <label for="inputZip"> Name</label>     <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]"> </div>	<div class="form-group col-md-4">      <label for="inputZip"> Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>	<div class="form-group col-md-3">      <label for="inputZip">Email</label>      <input type="text" class="form-control" id="point_contact_email" placeholder="Email" name="point_contact_email[]">    </div>	<div class="form-group col-md-1">      <label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
function supplierview(id)
	{
		
		 $.ajax({
            url: '<?php print base_url();?>supplier/view_supplier/'+id,
			 type        : 'post',
            cache       : false,
        contentType : true,
        processData : true,
        
            success: function(response){
				$('#material_details').html(response);
				$('#exampleModal1').modal('show');
				 $("#exampleModal1").appendTo("body");
				 
				 
				 
				 
				    $(function() {
           $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-4" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              $("#exampleModal2").appendTo("body");
            });
         }); 
                
            },
        }); 
		
		
	}
	
	
	
   function show_post(id)
  {
     $.ajax({
              url : "<?php echo base_url(); ?>supplier/img/"+id,
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                 // console.log(response)
                  $('#img_details').html(response);
                     $("#editModal").modal('show');
                    $("#editModal").appendTo("body");
              }
              
     });
  }
  
  
   function show_post_pdf(id)
  {
      //alert(id);
     $.ajax({
              url : "<?php echo base_url(); ?>supplier/pdf/"+id,
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                 // console.log(response)
                  $('#pdfdetails').html(response);
                     $("#pdfModal").modal('show');
                    $("#pdfModal").appendTo("body");
              }
              
     });
  }
  

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
					$('#image_preview').append("<div class='col-md-3' id='clients-edit-wrapper'><div class='close-wrapper'> <a  class='close-div text-danger'>Delete</a></div><input type='hidden' name='test_image[]' value='"+response.image_name+"'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
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

function update(id){
        //alert(id);
               
           	 $.ajax({
              url : "<?php echo base_url(); ?>supplier/edit_supp",
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                  //console.log(response)
                  $('#update_details').html(response);
               $("#sidebar-right").modal ("show");
                //$('.selectpicker').selectpicker('refresh');
                
                
                
                 $(function() {
           $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-4" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              $("#exampleModal2").appendTo("body");
            });
         }); 
                
                
             $(function() {
           $( "#dialog-5" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-5" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal3').modal('show');
              $("#exampleModal3").appendTo("body");
            });
         });  
         
         
         
          $(function() {
           $( "#dialog-6" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-6" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal4').modal('show');
              $("#exampleModal4").appendTo("body");
            });
         });     


var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div> <div class="form-group col-md-4">   <label for="inputZip"> Name</label>     <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]"> </div>	<div class="form-group col-md-4">      <label for="inputZip"> Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>	<div class="form-group col-md-3">      <label for="inputZip">Email</label>      <input type="text" class="form-control" id="point_contact_email" placeholder="Email" name="point_contact_email[]">    </div>	<label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
                
              }
               
           	 });
    
}
function preview_image1() 
{
 var total_file=document.getElementById("upload_file1").files.length;

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
					$('#image_preview1').append("<div class='col-md-3' id='clients-edit-wrapper1'><div class='close-wrapper'> <a  class='close-div1'>Delete</a></div><input type='hidden' name='test_image1[]' value='"+response.image_name+"'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
					}
                }else{
                    alert('file not uploaded');
                }
            },
        });  
 
 }
}
$(document).on('click', '.close-div1', function(){
	
    $(this).closest("#clients-edit-wrapper1").remove();
});


function preview_image2() 
{
 var total_file=document.getElementById("upload_file2").files.length;

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
					$('#image_preview2').append("<div class='col-md-3' id='clients-edit-wrapper2'><div class='close-wrapper2'> <a  class='close-div'>Delete</a></div><input type='hidden' name='test_image2[]' value='"+response.image_name+"'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
					}
                }else{
                    alert('file not uploaded');
                }
            },
        });  
 
 }
}
$(document).on('click', '.close-div2', function(){
	
    $(this).closest("#clients-edit-wrapper2").remove();
});
    </script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
  <style>
   .error{ color:red; } 
   .cmxform fieldset p label span.error { color: red; }
form.cmxform { width: 30em; }
form.cmxform label {
	width: auto;
	display: block;
	float: none;
}
  </style>
  <script>
  // only for demo purposes
$.validator.setDefaults({
	submitHandler: function() {
		$('#form1').submit();
	}
});
  var validator = $("#form1").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
		messages: {
			companyname: {
				required: " (required)",
				minlength: " (must be at least 3 characters)"
			},
			contact_number_office: {
				required: " (required)"
			},
			status: {
				required: " (required)"
			},
			creditperiod: {
				required: " (required)"
			},
			creditlimit: {
				required: " (required)"
			},
			password: {
				required: " (required)",
				minlength: " (must be between 5 and 12 characters)",
				maxlength: " (must be between 5 and 12 characters)"
			}
		}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
	
	
		function deletesupplier(id){
             var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>supplier/delete_supp",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
             //alert(response);
               //window.location.reload();
            }
          }); 
	     }
	     else{
	         
	        
	     }
        
    }
   
    
	function select_image_name(val, id, type){
         var val =  val;
         
         var id = id;
        
         var type = type;
         
        
         var r = confirm("Are you sure to delete the file");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>supplier/delete_file",
              data:{val : val ,  id : id, type : type },
              method:'POST',
              dataType:'json',
              success:function(response) {
               
               window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     } 
        
      }

  </script>
  
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>Supplier View
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="material_details"></div>
      
      </div>
     
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>View
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="img_details"></div>
      
      </div>
     
    </div>
  </div>
</div>


 <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body form-group">
	
          <div id="pdfdetails"></div>
          
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>

