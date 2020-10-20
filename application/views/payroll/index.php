<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
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

.modal-header {
   
    background-color: #000000	;

 }
.modal-title {
    color: white !important;
	line-height:0.42857143;
	font-size: 20px;
    letter-spacing: .005em;
  }
  .ciuis-invoice-summaries-b1{
	  width:20% !important;
  }
  .ciuis-invoice-summaries-b1 .box-content .percentage
  {
	  left:40%!important;
  }
  .select2-default {
	  color: rgba(0,0,0,0.12) !important;
	  border-color:rgba(0,0,0,0.12) !important;
	  font-family:inherit !important;
	  font-size:inherit !important;
	  
  }
  .md-dialog-container,.md-open-menu-container{
	  z-index:2000;
  }
</style>
<div class="ciuis-body-content" ng-controller="Orders_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
    <div class="panel-heading"> <strong><?php //echo lang('ContactsList') ?></strong> <span class="panel-subtitle"><?php //echo lang('ordersituationsdesc') ?></span> </div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
	<form id="form1" method="POST" action="<?php print base_url().'payroll/index';?>">
	<label>Please Enter Financial year</label>
	
	<input type="text" name="year" id="year" placeholder="2020" value="<?php echo $year;?>" />
	<input type="submit" name="search"  id="search" value="Search" />
	</form>
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'1'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'1'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'2'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'3'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
      </div> -->
      <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'4'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('order') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'4'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('revised')?></span>
      </div> -->
     <!-- <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> <span class="task-stat-all" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'5'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php //echo lang('Total Contacts')?></span>
      </div> -->
    <!--  <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> <span class="task-stat-all" ng-bind="'<?php //echo count($getpayslip) ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'6'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php //echo lang('Total Contacts')?></span>
      </div>  -->
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('Payslip'); ?> <small>(<span ng-bind="'<?php //echo count($getpayslip); ?>'"></span>)</small><br>
         <b style='color:red'><?php echo $year; ?></b></h2>
       <!-- <div class="ciuis-external-search-in-table">
          <input ng-model="order_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php //echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div> -->
        <md-button onclick="update()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        
	<!--	<md-menu>
		<md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
              <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
            </md-button>
         <md-menu-content width="4">
		 <md-menu-item>
          <a href="<?php //echo base_url('payroll/create');?>">Payslip</a>
		  </md-menu-item>
		  <md-menu-item>
          <a href="<?php //echo base_url('paysheet');?>">Payroll</a>
		  </md-menu-item>
		 
		   </md-menu-content>
		   </md-menu> -->
           
      </div>
    </md-toolbar>
    <md-content ng-show="!contactsListLoader" class="bg-white" >
      <md-table-container >
        <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th md-column><span><?php echo '#'; ?></span></th>
              <th md-column ><span><?php echo 'Name of the month'; ?></span></th>
              <th md-column ><span><?php echo 'Period of Payment'; ?></span></th>
              <th md-column ><span><?php echo 'No .of days'; ?></span></th>
              <th md-column ><span><?php echo 'Amount Paid'; ?></span></th>
              <th md-column ><span><?php echo 'Status'; ?></span></th>
              
            </tr>
          </thead>
          <tbody md-body>
            <?php 
			
			$months = array('1'=>'Jan',
						    '2'=>'Feb',
							'3'=>'Mar',
							'4'=>'Apr',
							'5'=>'May',
							'6'=>'Jun',
							'7'=>'Jul',
							'8'=>'Aug',
							'9'=>'Sep',
							'10'=>'Oct',
							'11'=>'Nov',
							'12'=>'Dec');
			foreach ($months as $key => $value) {
				
				
				$ci =& get_instance();
$ci->load->model('Payroll_Model');
$amount = $this->Payroll_Model->get_sum($year,$key);
				if(empty($amount['amt'])){
					$amt = 0;
				}else{
                  $amt = $amount['amt'];
                }					
             ?>
            <tr class="select_row" md-row  class="cursor" >
              
             <td md-cell>
                <strong><span><?php echo $key; ?></span></strong>
              </td>
			  <?php
	          $last_year = $year-1;
		     $last_month = $key-1;
					if($key == '1'){
						$start_date = $last_year.'-12-25';
						$end_date = $year.'-0'.$key.'-25';
					}
					else{
						
						$start_date = $year.'-0'.$last_month.'-25';
						$end_date = $year.'-0'.$key.'-25';
					}

			  ?>
              <td md-cell>
                <strong><span><a class="link" href="<?php print base_url().'payroll/payroll_view/'.$start_date.'/'.$end_date;?>" onclick="select_month(<?php echo $key;?>)"><?php echo $value.'-'.$year; ?></a></span></strong>
              </td>
			  
			  <input type="hidden" name="start_date<?php echo $key;?>"  id="start_date<?php echo $key;?>" value="<?php echo $start_date;?>" />
			   <input type="hidden" name="end_date<?php echo $key;?>"  id="end_date<?php echo $key;?>" value="<?php echo $end_date;?>" />
              <td md-cell>
                <strong><span><?php if($key == 1) { echo 'Dec-25'.' to '.'Jan-25'; } else {  echo $months[$key-1].'-25'.' to '.$months[$key].'-25'; }?></span></strong>
              </td>
               <td md-cell>
                <strong><span><?php echo '30' ?></span></strong>
              </td>
               <td md-cell>
                <strong><span><?php echo $amt; ?></span></strong>
              </td>
              <td md-cell>
                <strong><span><?php echo 'Paid'; ?></span></strong>
              </td>
              
            </tr>
          <?php } ?>
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
      <div ng-repeat="(prop, ignoredValue) in orders[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill' && prop != 'status' && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type' && prop != 'customer_email'">
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
  <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">
 <div class="modal-header">
 
        <h4 class="modal-title">Filter</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>

<div class="modal-body">
<form id="form1" method="post" action="<?php print base_url().'payroll/payslip_excel';?>">
<div class="row" id="emp"><div class="form-group col-md-12">
<h4 class="text-muted text-uppercase"><strong class="ng-binding">filterbydate</strong></h4>
<div class="labelContainer">
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="fromdatetime" placeholder="<?php echo lang('from') ?>" show-todays-date="" minutes="false" ng-change="changeDate(prop)" show-icon="true" ng-model="filter_from_dt" class=" dtp-no-msclear dtp-input md-input" name="from_date">
					</div>
					<div class="col-md-6">
						<input mdc-datetime-picker="" date="true" time="false" type="text" id="todatetime" placeholder="<?php echo lang('to') ?>" show-todays-date="" minutes="true" show-icon="true" ng-change="changeDate(prop)" ng-model="filter_to_dt" class=" dtp-no-msclear dtp-input md-input" name="to_date">
					</div>
				</div></br></br>
				<div class="col-md-12">
<input type="submit" class="btn btn-success col-md-12"  value="Export Excel">
</div>
</div>
</form>
<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>

 
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<script>
function select_month(mon){
	var start_date = $('#start_date'+mon).val();
	var end_date = $('#end_date'+mon).val();
	 $.ajax({
              url : "<?php echo base_url(); ?>payroll/payroll_view",
              data:{start_date:start_date,end_date:end_date},
              method:'POST',
            //  dataType:'json',
              success:function(response) {
				  
			  }
	 });
}
function update(){
	 
	 $("#sidebar-right").modal ("show");
	 
	 return false;
	  $.ajax({
              url : "<?php echo base_url(); ?>attendance/search_atten",
              data:{},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				  $('#update_details').html(response);
	 $("#sidebar-right").modal ("show");
	 $('#emps').select2({ });
	  $('#depts').select2({ });
	 
	 var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
			  }
	  });
 }
</script> 