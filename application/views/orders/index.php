<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.proposal-status-open {
	border : 1px solid #26c281 !important;	
}

.proposal-status-quote {
    font-size: 12px;
    margin-top: 5px;
    background: #ffffff;
    color: #26c281;
    border: 1px dashed #26c281;
    width: 100px;
}

.fa-info {
	color: #26c281;
}

/*.round-boxes{
	margin-top:0px !important;
	margin-bottom:0px !important;
}
*/
.statusColor:focus{
	outline: none;
	border: 0;
}
</style>
<div class="ciuis-body-content leads-page orders-page" ng-controller="Orders_Controller">
<div class="row">
          <div class="col-md-12 leads-table orders-table">
            <div class="leads-inner"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2 flex md-truncate class="text-bold"><?php echo lang('quotes'); ?> <small>(<span ng-bind="(orders|filter:FilteredData | filter:order_search).length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('organize_your_orders'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="order_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-icon><ion-icon name="search-outline"></ion-icon></md-icon>
          </md-button>
        </div>
        <!--<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-icon><ion-icon name="filter-circle-outline"></ion-icon></md-icon>
        </md-button>-->
        <?php //if (check_privilege('orders', 'create')) { ?>
          <md-button ng-href="<?php echo base_url('orders/create') ?>" class="md-icon-button" aria-label="New" ng-cloak>
            <md-icon><ion-icon name="add-circle"></ion-icon></md-icon>
          </md-button>
        <?php //} ?>
      </div>
    </md-toolbar>
    

</div>
</div>
</div>
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
   
    <div class="left-sidebar">
    <div class="panel-heading"> <strong><?php echo lang('Overall').' '.lang('quotes') ?></strong></div>
    <div class="row" style="padding: 0px 20px 0px 20px;">
      <div class="col-md-6 col-xs-6 border-right">
		 <div class="tasks-status-stat">
			  <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'7'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
			  <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'7'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase OrderStatus_Quote statusColor" style="color:#989898;cursor:pointer;" ng-click="GetQuotesbyFilter('Filter by Status','Quote Request');ChangeColor('Quote');"><?php echo lang('quote').' '.lang('request')?></span>
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'1'} : true).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'1'} : true).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase OrderStatus_DRAFT statusColor" style="color:#989898;cursor:pointer;" ng-click="GetQuotesbyFilter('Filter by Status','DRAFT');ChangeColor('DRAFT');"><?php echo lang('draft')?></span>
      </div>
      <!--<div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'2'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'2'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'3'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'3'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
      </div>-->
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'10'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'10'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase OrderStatus_UnderApproval statusColor" style="color:#989898;cursor:pointer;" ng-click="GetQuotesbyFilter('Filter by Status','under approval');ChangeColor('UnderApproval');"><?php echo lang('under approval')?></span>
      </div>
      <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'11'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'11'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase OrderStatus_Rejected statusColor" style="color:#989898;cursor:pointer;" ng-click="GetQuotesbyFilter('Filter by Status','Rejected');ChangeColor('Rejected');"><?php echo lang('rejected')?></span>
      </div>
      <!--<div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'6'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'6'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('accepted')?></span>
      </div>
	  <div class="col-md-6 col-xs-6 border-right">
        <div class="tasks-status-stat">
          <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(orders | filter:{status_id:'11'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+orders.length+' '+'<?php echo lang('quote') ?>'"></span> </h3>
          <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(orders | filter:{status_id:'11'}).length * 100 / orders.length }}%;"></span> </span>
        </div>
        <span class="text-uppercase" style="color:#989898"><?php echo lang('rejected')?></span>
      </div>-->
    </div>
  </div>
  
</div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
	<div class="ciuis-invoice-summary">
		<div>
			<div class="row">
				<div class="col-md-12">
				
				<div class="whiteBackGround">
						<div class="round-boxes">
                      <!--- <div class="box-header text-uppercase text-bold">Open</div>--->
                       <div class="box-content custom-icon whiteBack">
                         <div class="imgDivMain">
							<img src="/uploads/images/icons/red_image.png" class="img-responsive">
							<img src="/uploads/images/icons/tap.png" class="img-responsive imgAnimate">
							<div class=" posR">
								<div class="dbox__body posA"><span class="dbox__title">Open</span> </div> 
							</div>
							<div class="percentage numA" ng-bind="(orders | filter:{status_id:'3'}).length" ng-click="GetQuotesbyFilter('Filter by Status','OPEN');"></div>
								<div class="DotsRight">
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								</div>
						 </div>
						   </div>
                  </div>
				  
				  <div class="round-boxes">
                      <!--- <div class="box-header text-uppercase text-bold">Open</div>--->
                       <div class="box-content custom-icon whiteBack">
                         <div class="imgDivMain">
							<img src="/uploads/images/icons/yellow_image.png" class="img-responsive">
							<img src="/uploads/images/icons/phoneLand.png" class="img-responsive imgAnimate">
							<div class=" posR">
								<div class="dbox__body posA"><span class="dbox__title">SENT</br> <!--(Email /Call)--></span> </div> 
							</div>
							<div class="percentage numA" ng-bind="(orders| filter:{status_id:'2'}: true).length" ng-click="GetQuotesbyFilter('Filter by Status','Sent');"?></div>
							<div class="DotsRight">
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								</div>
						 </div>
						   </div>
                  </div>
				  
				  <div class="round-boxes">
                      <!--- <div class="box-header text-uppercase text-bold">Open</div>--->
                       <div class="box-content custom-icon whiteBack">
                         <div class="imgDivMain">
							<img src="/uploads/images/icons/brown_image.png" class="img-responsive">
							<img src="/uploads/images/icons/time.png" class="img-responsive imgAnimate">
							<div class=" posR">
								<div class="dbox__body posA"><span class="dbox__title">ACCEPTED</span> </div> 
							</div>
							<div class="percentage numA" ng-click="GetQuotesbyFilter('Filter by Status','Accepted');" ng-bind="(orders | filter:{status_id:'6'}).length"?></div>
							<div class="DotsRight">
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								</div>
						 </div>
						   </div>
                  </div>
				  
				  <div class="round-boxes">
                      <!--- <div class="box-header text-uppercase text-bold">Open</div>--->
                       <div class="box-content custom-icon whiteBack">
                         <div class="imgDivMain">
							<img src="/uploads/images/icons/green_image.png" class="img-responsive">
							<img src="/uploads/images/icons/thumb.png" class="img-responsive imgAnimate">
							<div class=" posR">
								<div class="dbox__body posA"><span class="dbox__title">INVOICED</span> </div> 
							</div>
							<div class="percentage numA" ng-click="GetQuotesbyFilter('Filter by Status','Invoiced');" ng-bind="(orders | filter:{status_id:'12'}).length"?></div>
							<div class="DotsRight">
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								  <span class="dot"></span>
								</div>
						   </div>
						</div>
                  </div>
				  
				   <div class="round-boxes">
                      <!--- <div class="box-header text-uppercase text-bold">Open</div>--->
                       <div class="box-content custom-icon whiteBack">
                         <div class="imgDivMain">
							<img src="/uploads/images/icons/grey_image.png" class="img-responsive">
							<img src="/uploads/images/icons/sad.png" class="img-responsive imgAnimate">
							<div class=" posR">
								<div class="dbox__body posA"><span class="dbox__title">DECLINED</span> </div> 
							</div>
							<div class="percentage numA" ng-click="GetQuotesbyFilter('Filter by Status','Declined');" ng-bind="(orders | filter:{status_id:'5'}).length"?></div>
						   </div>
						</div>
                  </div>
					</div>
				
				
				
				
					<!--<div class="round-boxes">
						<div class="box-content custom-icon">
							<div class="dbox dbox--color-1">
								<div class="dbox__body"><span class="dbox__title">Open</span></div>
								<!-- <div class="dbox__icon">   
									<div class="progress orange">
										<div class="percentage" ng-bind="(orders | filter:{status_id:'3'}).length" ng-click="GetQuotesbyFilter('Filter by Status','OPEN');"></div>
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
									</div>
								</div> --
                <div class="icon-gif">
              <div class="icon-back icon-back1">
                <img src="/crm/uploads/images/icons/icon4.jpeg" width="100%">
              </div>
            </div>
<div class="anim-circle">
    <svg width="140px" height="140px" viewBox="0 0 100 100" preserveAspectRatio="none">
<circle class="js-circle circle" cx="50" cy="50" r="48" stroke="#e4e7ea" stroke-width="4" fill="none"></circle>

   </svg>
  </div>
  <div class="percentage" ng-bind="(orders | filter:{status_id:'3'}).length" ng-click="GetQuotesbyFilter('Filter by Status','OPEN');"></div>						  
							</div>
						</div>
                    </div>
                    <div class="round-boxes">
                       <div class="box-content custom-icon invoice-percent">
						   <div class="dbox dbox--color-1">
								 <div class="dbox__body"><span class="dbox__title">Sent</span></div>
								<!-- <div class="dbox__icon">   
									<div class="progress blue">
										<div class="percentage" ng-bind="(orders| filter:{status_id:'2'}: true).length" ng-click="GetQuotesbyFilter('Filter by Status','Sent');"></div>
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
									</div>
								</div> --
                <div class="icon-gif">
              <div class="icon-back icon-back1">
                <img src="/crm/uploads/images/icons/icon7.jpeg" width="100%">
              </div>
            </div>
<div class="anim-circle">
    <svg width="140px" height="140px" viewBox="0 0 100 100" preserveAspectRatio="none">
<circle class="js-circle circle" cx="50" cy="50" r="48" stroke="#e4e7ea" stroke-width="4" fill="none"></circle>

   </svg>
  </div>

  <div class="percentage" ng-bind="(orders| filter:{status_id:'2'}: true).length" ng-click="GetQuotesbyFilter('Filter by Status','Sent');"></div>
							</div>
                       </div>
                    </div>
                    <div class="round-boxes">
						<div class="box-content custom-icon invoice-percent-2">
							<div class="dbox dbox--color-1">
								<div class="dbox__body"><span class="dbox__title">Accepted</span> </div>
								<!-- <div class="dbox__icon">   
									<div class="progress green">
										<div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Accepted');" ng-bind="(orders | filter:{status_id:'6'}).length"></div>
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
									</div>
								</div> --
                <div class="icon-gif">
              <div class="icon-back icon-back1">
                <img src="/crm/uploads/images/icons/icon1.jpeg" width="100%">
              </div>
            </div>
<div class="anim-circle">
    <svg width="140px" height="140px" viewBox="0 0 100 100" preserveAspectRatio="none">
<circle class="js-circle circle" cx="50" cy="50" r="48" stroke="#e4e7ea" stroke-width="4" fill="none"></circle>

   </svg>
  </div>

  <div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Accepted');" ng-bind="(orders | filter:{status_id:'6'}).length"></div>

							</div>
                       </div>
                    </div>
                    <div class="round-boxes">
						<div class="box-content custom-icon invoice-percent-3">
							<div class="dbox dbox--color-1">
								<div class="dbox__body"><span class="dbox__title">Invoiced</span>   </div>
								<!-- <div class="dbox__icon">   
									<div class="progress yellow">
										<div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Invoiced');" ng-bind="(orders | filter:{status_id:'12'}).length"></div>
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>
									</div>
								</div> --
                <div class="icon-gif">
              <div class="icon-back icon-back1">
                <img src="/crm/uploads/images/icons/icon6.jpeg" width="100%">
              </div>
            </div>
<div class="anim-circle">
    <svg width="140px" height="140px" viewBox="0 0 100 100" preserveAspectRatio="none">
<circle class="js-circle circle" cx="50" cy="50" r="48" stroke="#e4e7ea" stroke-width="4" fill="none"></circle>

   </svg>
  </div>

  <div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Invoiced');" ng-bind="(orders | filter:{status_id:'12'}).length"></div>
							</div>
                       </div>
                    </div>
					<div class="round-boxes">
						<div class="box-content custom-icon invoice-percent" >
							<div class="dbox dbox--color-1">
								<div class="dbox__body"><span class="dbox__title">Declined</span>   </div>
								<!-- <div class="dbox__icon">   
									<div class="progress red">
										<div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Rejected');" ng-bind="(orders | filter:{status_id:'11'}).length"></div>
										<span class="progress-left">
											<span class="progress-bar"></span>
										</span>
										<span class="progress-right">
											<span class="progress-bar"></span>
										</span>              
									</div>
								</div> --
                <div class="icon-gif">
              <div class="icon-back icon-back1">
                <img src="/crm/uploads/images/icons/icon5.jpeg" width="100%">
              </div>
            </div>
<div class="anim-circle">
    <svg width="140px" height="140px" viewBox="0 0 100 100" preserveAspectRatio="none">
<circle class="js-circle circle" cx="50" cy="50" r="48" stroke="#e4e7ea" stroke-width="4" fill="none"></circle>

   </svg>
  </div>

  <div class="percentage" ng-click="GetQuotesbyFilter('Filter by Status','Declined');" ng-bind="(orders | filter:{status_id:'5'}).length"></div>
							</div>
                       </div>
                    </div>-->
                 </div>
              </div>
           </div>
        </div>

        <div class="row">
          <div class="col-md-12 leads-table orders-table">
            <div class="leads-inner"> 
    
    <md-content ng-show="!orderLoader" class="bg-white" ng-cloak>
      <md-table-container ng-show="orders.length > 0">
        <table md-table md-progress="promise">
          <thead md-head md-order="order_list.order">
            <tr md-row>
              <th md-column><span><?php echo lang('quotes'); ?></span></th>
			  <th md-column><span><?php echo lang('reference'); ?></span></th>
              <th md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span>
              </th>
              <th md-column md-order-by="date"><span><?php echo lang('date'); ?></span></th>
              <th md-column md-order-by="opentill"><span><?php echo lang('opentill'); ?></span></th>
              <th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
              <th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th>
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="order in orders | orderBy: order_list.order | filter: order_search | filter: FilteredData | limitTo: order_list.limit : (order_list.page -1) * order_list.limit" class="cursor">
              <td md-cell> 
                <strong>
                  <!--<a ng-show="order.enable_edit==1" class="link" ng-href="<?php echo base_url('orders/order/') ?>{{order.id}}"> <span ng-bind="order.longid"></span></a>
				  <span ng-show="order.enable_edit==0" ng-bind="order.longid"></span>-->
				  <a class="link" ng-href="<?php echo base_url('orders/order/') ?>{{order.id}}"> <span ng-bind="order.longid"></span></a>
                </strong><br>
                <small ng-bind="order.project"></small>
              </td>
			  <td md-cell>
                <strong><span class="badge" ng-bind="order.reference"></span></strong>
              </td>
              <td md-cell>
                <strong><span ng-bind="order.customer"></span></strong><br>
                <span class="blur" ng-bind="order.customer_email"></span>
              </td>
              <td md-cell>
                <strong><span class="badge" ng-bind="order.date"></span></strong>
              </td>
              <td md-cell>
                <strong><span class="badge" ng-bind="order.opentill"></span></strong>
              </td>
              <td md-cell>
                <strong class="text-uppercase text-{{order.status}} {{order.class}}" ng-bind="order.status"></strong>
              </td>
              <td md-cell style="font-size: 12px;">
                <strong ng-bind-html="order.total | currencyFormat:cur_code:null:true:cur_lct" style="padding-right: 4px"></strong>
				<span style="float: right; font-size: 18px;" ng-show="order.is_converted=='1'">
					<a ng-href="<?php echo base_url('projects/project/') ?>{{order.projectid}}">
						<md-tooltip md-direction="bottom"><?php echo lang('Convert') ?></md-tooltip>
						<md-icon style="font-size: 18px !important;"><i class="ion-checkmark-circled text-success"></i></md-icon>
					</a>
				</span>
				<span style="float: right;" ng-show="order.is_invoiced=='1'">
					<a ng-href="<?php echo base_url('invoices/invoice/') ?>{{order.invoice_id}}">
						<md-tooltip md-direction="bottom"><?php echo lang('Invoiced') ?></md-tooltip>
						<md-icon style="font-size: 18px !important;"><i class="fa fa-info" aria-hidden="true"></i></md-icon>
					</a>
				</span>
              </td>
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="orders.length > 0" md-limit="order_list.limit" md-limit-options="limitOptions" md-page="order_list.page" md-total="{{orders.length}}"></md-table-pagination>
      <md-content ng-show="!orders.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
    </md-content>

</div>
</div>
</div>








  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in orders[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill'  && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type' && prop != 'customer_email' && prop != 'addedfrom' && prop != 'addedfrompersonname' && prop != 'status' && prop != 'enable_edit' && prop != 'is_converted' && prop != 'is_invoiced' && prop != 'invoice_id' && prop != 'projectid' && prop != 'project' && prop != 'relation' && prop != 'reference' && prop != 'relationtype'">
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
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
