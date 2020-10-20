<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #26c281 !important;
		outline: 0;
		color:#fff !important;
	}
	
	select.ng-invalid {
		border:1px solid red !important;
	}
	
	.marginTop5 {
		margin-top:5%;
	}

	.marginTop10 {
		margin-top:10%;
	}
	
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
	
	.ck-editor__editable{
		height:200px;
	}
</style>

<div class="ciuis-body-content leads-table create-order" ng-controller="Order_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9"> <?php echo form_open('orders/update',array("class"=>"form-horizontal orderForm")); ?>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <!-- <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-orders text-white"></i></md-icon>
        </md-button> -->
        <h2 flex md-truncate><strong><?php echo lang('update') . ' ' . lang('quote') ?></strong></h2>
        <md-button ng-href="<?php echo base_url('orders/order/{{order.id}}')?>" class="md-icon-button" aria-label="Save" ng-cloak>
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
      <div layout-gt-xs="row">
			<md-input-container class="md-block create-order-input" flex-gt-sm>
				<!--<md-select ng-model="order.project" data-md-container-class="selectdemoSelectHeader">
					<md-select-header class="demo-select-header">
						<label style="display: none;"><?php echo lang('search').' '.lang('project')?></label>
						<input ng-submit="search_projects(search_input_project)" ng-model="search_input_project" type="text" placeholder="<?php echo lang('search').' '.lang('project')?>" class="demo-header-searchbox md-text" ng-keyup="search_projects(search_input_project)">
					</md-select-header>
					<md-optgroup label="projects">
						<md-option ng-value="project.id" ng-repeat="project in all_projects">
							<strong ng-bind="project.name"></strong><br>
						</md-option>
					</md-optgroup>
				</md-select>-->
				<input  name="project" id="quoteName" class="form-control" placeholder="Enter Quote Name" required="" ng-model="order.project">
			</md-input-container>
			
			<md-input-container class="md-block create-order-input" flex-gt-sm>
				<input  name="reference" id="reference" class="form-control" placeholder="Enter Reference" ng-model="order.reference">
			</md-input-container>
			<!--<md-input-container class="md-block" flex-gt-sm>
				<md-select ng-model="order.staff" data-md-container-class="selectdemoSelectHeader">
					<md-select-header class="demo-select-header">
						<label style="display: none;"><?php echo lang('search').' '.lang('staff')?></label>
						<input ng-submit="search_sales_staff(search_input_staff)" ng-model="search_input_staff" type="text" placeholder="<?php echo lang('search').' '.lang('staff')?>" class="demo-header-searchbox md-text" ng-keyup="search_sales_staff(search_input_staff)">
					</md-select-header>
					<md-optgroup label="staffs">
						<md-option ng-value="staff.id" ng-repeat="staff in staffs">
							<span ng-bind="staff.staffname"></span><br>
						</md-option>
					</md-optgroup>
				</md-select>
			</md-input-container>-->
			<md-input-container>
			  <label><?php echo lang('dateofissuance') ?></label>
			  <md-datepicker name="created" ng-model="order.date" md-open-on-focus></md-datepicker>
			</md-input-container>
		</div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block create-order-input" flex-gt-sm>
          <md-select ng-model="order.customer" data-md-container-class="selectdemoSelectHeader" ng-change="ChangeCustomer(order.customer)">
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
          <md-select ng-model="order.client_contact_id" data-md-container-class="selectdemoSelectHeader">
		  <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('contacts')?></label>
			<input type="text" placeholder="<?php echo lang('search').' '.lang('contacts')?>" class="demo-header-searchbox md-text">
          </md-select-header>
          <md-optgroup label="contacts">
            <md-option ng-value="contact.id" ng-repeat="contact in all_contacts">
              <span ng-bind="contact.name"></span><br>
            </md-option>
          </md-optgroup>
        </md-select>
        </md-input-container>
		<input type="hidden" ng-model="main_sales_team_id" name="main_sales_team_id" id="salesteamid" value="0"/>
		<!--<md-input-container class="md-block" flex-gt-sm>
          <md-select ng-model="order.salesteam" data-md-container-class="selectdemoSelectHeader">
		  <md-select-header class="demo-select-header">
            <label style="display: none;"><?php echo lang('search').' '.lang('salesperson')?></label>
           <input type="text" placeholder="<?php echo lang('search').' '.lang('salesperson')?>" class="demo-header-searchbox md-text">
          </md-select-header>
			<md-optgroup label="salesteam">
				<md-option ng-value="salesteam.staff_id" ng-repeat="salesteam in all_salesteam">
				  <span ng-bind="salesteam.staff_name"></span><br>
				</md-option>
			</md-optgroup>
			</md-select>
        </md-input-container>-->
		<md-input-container>
          <label><?php echo lang('opentill') ?></label>
          <md-datepicker name="opentill" ng-model="order.opentill" md-open-on-focus></md-datepicker>
        </md-input-container>
      </div>
      <!--<md-checkbox class="pull-right" ng-model="order.comment" ng-true-value="true" ng-false-value="false" aria-label="Comment"> <strong class="text-muted text-uppercase"><?php echo lang('allowcomments');?></strong> </md-checkbox>-->
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
		    md-floating-label="<?php echo lang('productservice'); ?>"
		    placeholder="What is your favorite US state?">
            <md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
          </md-autocomplete>-->
		  <md-input-container class="md-block">
			<label><?php echo lang('name'); ?></label>
			<input class="min_input_width" type="text" ng-model="item.name">
            <bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
		  </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('description'); ?></label>
            <input class="min_input_width" type="hidden" ng-model="item.id">
            
            <textarea class="min_input_width" ng-model="item.description"></textarea>
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
            <bind-expression ng-init="selectedProduct.price = item.price" expression="selectedProduct.price" ng-model="item.price" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo $appconfig['tax_label']; echo ' (%)';?></label>
            <input class="min_input_width" ng-model="item.tax+'%'">
            <bind-expression ng-init="selectedProduct.tax = item.tax" expression="selectedProduct.tax" ng-model="item.tax" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('discount'); echo ' (%)';?></label>
            <input class="min_input_width"  ng-change="all_discount_items(item.discount)" ng-model="item.discount">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('total');echo ' (AED)'; ?></label>
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
      <md-content class="bg-white create-order-total">

        <div class="col-md-12 md-pr-0" style="font-weight: 600; font-size: 14px; color: #000000;">
          <div class="col-md-7">
			<div class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
            <div class="text-right text-uppercase text-muted marginTop5"><?php echo lang('sub_total') ?>:</div>
            <div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
			<div ng-show="nettotal() > 0" class="text-right text-uppercase text-muted"><?php echo lang('net_total') ?>:</div>
            <div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted"><?php echo lang('total').' '.$appconfig['tax_label'] ?>:</div>
            <div class="text-right text-uppercase text-black"><?php echo lang('grand_total') ?>:</div>
          </div>
          <div class="col-md-5">
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
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('Special Notes') ?></label>
          <textarea ck-editor ng-model="order.content" rows="3" id="quotedetails"></textarea>
        </md-input-container>
      </div>
    </md-content>
    <?php echo form_close(); ?> 
    <script>
		var ORDERID = <?php echo $order['id']; ?>;
	</script> 
  </div>
  <div class="main-content container-fluid top-m40 col-xs-12 col-md-12 col-lg-3 md-pl-0">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <!-- <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button> -->
        <h2 flex md-truncate><strong>Attachments</strong></h2>
		 <?php if (check_privilege('orders', 'edit')) { ?> 
          <md-button ng-click="UploadFile()" class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
	    <div ng-show="orderFiles" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
        <small><strong><?php echo lang('loading'). ' Order Files...' ?></strong></small></span>
      </p>
    </div>
	<md-content class="bg-white" ng-show="!orderFiles">
      <md-list flex ng-cloak>
        <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
          <div class="md-list-item-text image-preview">
            <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
              <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="{{file.path}}">
            </a>
            <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
            </a>
            <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
            <a ng-if="file.type == 'pdf'" class="cursor" ng-click="ViewPdfFile($index, image)">
			 <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('orders/download_file/{{file.id}}');?>">
              <h3 class="link" ng-bind="file.file_name"></h3>
            </a>
          </div>
          <?php if (check_privilege('orders', 'delete')) { ?> 
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
        <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
      </md-list>
      <div ng-show="files.length>6 && !projectFiles" class="pagination-div" ng-cloak>
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </md-content>
	<md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-ios-people text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate>Approved By</h2>
       
      </div>
    </md-toolbar>
 </div>
<!--Image End---> 

<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('orders/add_file/'.$orders['id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile');?></h2>
    <input type="file" required name="file_name" file-model="order_file">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="closeFile()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="view_image.html" >
  <md-dialog aria-label="options dialog"  class="dialog-picture">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>" >
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('orders', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('orders/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>

<script type="text/ng-template" id="view_pdf.html">
  <md-dialog aria-label="options dialog" style='width:100% !important;'>
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <iframe src="<?php echo $path ?>" style='width:100%;height:600px;'></iframe>
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('orders', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('orders/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="CloseModal()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
  
</div>
<script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>