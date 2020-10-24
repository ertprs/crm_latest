<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>

<style type="text/css">
	#desc {
		padding-left:2%;
	}
	
	.gap {
		border: 15px solid #EEEEEE;
	}
	
	.desc h3:focus {
		outline: none;
		border: 0;
	}
	
	table.gap tr th, table.gap tr td {
		background-color:#fff;
	}
	
	table.gap, .gap th, .gap td {
		border: 1px solid #EEEEEE !important;
	}
	
	.control-label	{
		font-weight:bold !important;
	}
	
	.newline { 
		margin-top:3%;
		margin-left:-86%;
		color: #393939;
		font-size: 20px;
		font-weight: bold;
	}
	
	md-radio-button {
		display:inline-block !important;
	}
</style>
<script src="https://use.fontawesome.com/da116b126d.js"></script>
<div class="ciuis-body-content lead-single quote-single" ng-controller="Order_Controller">
  <div class="main-content container-fluid col-md-9 borderten">
    <md-toolbar class="toolbar-white lead-user">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true" ng-cloak>
          <md-icon><i class="ico-ciuis-proposals text-warning"></i></md-icon>
        </md-button>
        <h5 style="font-size:14px;margin-left:10px;margin-top: 0px;"><?php echo $orders['order_number'].' '?></h5>
		<strong style="margin-top:4%;margin-left:-62px" flex md-truncate class="newline"><?php echo $orders['project'];?></strong>
          <!-- <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
            <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            <md-tooltip ng-hide="sendingEmail == true" md-direction="bottom" ng-bind="lang.send"></md-tooltip>
            <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
          </md-button>-->
          <md-button ng-show="order.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button" aria-label="Pdf" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
            <md-icon><i class="fa fa-file-pdf-o" aria-hidden="true"></i> </md-icon>
          </md-button>
          <md-button ng-show="order.pdf_status == '1'" ng-href="<?php echo base_url('orders/download_pdf/'.$orders['id'] )?>" class="md-icon-button" aria-label="Pdf" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
            <md-icon><i class="fa fa-file-pdf-o" aria-hidden="true"></i> </md-icon>
          </md-button>
          <md-button ng-href="<?php echo base_url('orders/print_/{{order.id}}') ?>" class="md-icon-button" aria-label="Print" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('print') ?></md-tooltip>
            <md-icon><i class="fa fa-print" aria-hidden="true"></i></md-icon>
          </md-button>
        <?php /* if (check_privilege('invoices', 'create')) { ?>    
          <md-menu ng-if="!order.invoice_id" md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
              <md-icon><i class="ion-loop text-success"></i></md-icon>
            </md-button>
            <md-menu-content width="4" ng-cloak>
              <md-contet class="text-center" layout-padding> <img height="80%" src="https://cdn4.iconfinder.com/data/icons/business-399/512/invoice-128.png" alt="">
                <p style="max-width: 250px"> <strong ng-show="order.relation_type == true" ><?php echo lang('leadproposalconvertalert') ?></strong> <strong ng-show="order.relation_type != true" ><?php echo lang('convert_order_to_invoice'); ?></strong> </p>
                <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                  <!--<md-button ng-click="Convert()" class="ion-filemd-primary pull-right" aria-label="Convert" ng-cloak><span ng-bind="lang.convert"></span></md-button>-->
				  <md-button ng-click="Convert()" aria-label="Convert" ng-cloak></md-button>
				  <img src="../img/invoice-convert.png" alt="">
                </section>
              </md-contet>
            </md-menu-content>
          </md-menu>
        <?php } */?>
        <!--<md-button ng-if="order.invoice_id" ng-href="<?php echo base_url('invoices/invoice/{{order.invoice_id}}')?>" class="md-icon-button" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('invoice') ?></md-tooltip>
          <md-icon><i class="ion-document-text text-success"></i></md-icon>
        </md-button>-->
		<?php if($orders['status_id']=='6'){ 
		   if($orders['is_invoiced'] !='1'){?>
			<md-button aria-label="Convert" class="md-icon-button" ng-click="ConvertInvoice()" ng-cloak>
			<md-tooltip md-direction="bottom"><?php echo lang('Convert Invoice') ?></md-tooltip>
            <md-icon><i class="fa fa-file-text-o" aria-hidden="true"></i></md-icon>
			</md-button>
		<?php }else{ ?>
			<md-button class="md-icon-button" aria-label="Invoiced" ng-cloak>
			<md-tooltip md-direction="bottom"><?php echo lang('invoiced') ?></md-tooltip>
			<md-icon><img src="<?php echo base_url('assets/img/invoiced.jpg') ?>" alt="" width="30" height="30" /></md-icon>
			</md-button>
		<?php }}?>
		<?php if($orders['status_id']=='6'){ 
		   if($orders['is_converted'] !='1'){?>
			<md-button aria-label="Convert" class="md-icon-button" ng-click="convertProject()" ng-cloak>
			<md-tooltip md-direction="bottom"><?php echo lang('Convert Project') ?></md-tooltip>
            <md-icon><i class="ion-loop text-success"></i> </md-icon>
			</md-button>
		<?php }else{ ?>
			<md-button class="md-icon-button" aria-label="Converted" ng-cloak>
			<md-tooltip md-direction="bottom"><?php echo lang('converted') ?></md-tooltip>
			<md-icon><i class="ion-trophy text-success"></i></md-icon>
			</md-button>
		<?php }}?>
        <?php if ($orders['enable_edit'] == '1') { ?>    
          <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
                <md-menu-item>
                  <md-button ng-click="NewMilestone()" ng-bind="lang.sentexpirationreminder" aria-label="sentexpirationreminder"></md-button>
                </md-menu-item>
                <?php if(($orders['status_id']=='10' || $orders['status_id']=='1') && $orders['showAccess']== '1'){ ?>
				<md-menu-item>
                  <md-button ng-click="MarkAs(9,'Approved')" ng-bind="lang.markasapproved" aria-label="Complete"></md-button>
                </md-menu-item>
				<md-menu-item>
                  <md-button ng-click="ordStatusDeclined('5')" ng-bind="lang.markasdeclined" aria-label="Complete"></md-button>
                </md-menu-item>
				<?php  } ?>
			    <?php if ($orders['status_id']=='1'){ ?>
					<md-menu-item>
						<md-button ng-click="MarkAs(10,'Send For Approval')" ng-bind="lang.sendforapproval" aria-label="Sendforapproval"></md-button>
					</md-menu-item>
			     <?php } if((($orders['status_id']=='9' || $orders['status_id']=='2' ||$orders['status_id']=='6' || $orders['status_id']=='4')||($orders['status_id']=='3' && $orders['estimation_id'] !='0'))){ ?>
					<md-menu-item>
						<md-button ng-click="MarkAs(2,'Sent')" ng-bind="lang.markassent" aria-label="Sent"></md-button>
					</md-menu-item>
					<md-menu-item>
					  <md-button ng-click="MarkAs(6,'Accepted')" ng-bind="lang.markasaccepted" aria-label="Accepted"></md-button>
					</md-menu-item>
					<md-menu-item>
					  <md-button ng-click="ordStatusDeclined('11')" ng-bind="lang.markasrejected" aria-label="Rejected"></md-button>
					</md-menu-item>
					 <md-menu-item>
						<md-button ng-click="MarkAs(4,'Revised')" ng-bind="lang.markasrevised" aria-label="Revised"></md-button>
					</md-menu-item>
				<?php } ?>
                <md-divider></md-divider>
			    <?php if ($orders['is_converted'] != '1' && $orders['status_id'] != '10') { ?> 
                <md-menu-item>
                  <md-button ng-click="Update()" aria-label="Update">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.edit"></p>
                      <md-icon md-menu-align-target class="ion-edit" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-divider></md-divider>
              <?php } if ($orders['is_converted'] != '1' && $orders['status_id'] != '10') { ?>
                <md-menu-item>
                  <md-button ng-click="Delete()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.delete"></p>
                      <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
              <?php } ?>
            </md-menu-content>
          </md-menu>
        <?php } 
		 if($orders['enable_edit'] == '0' && $allow_delete =='1'){
		?>
		    <md-menu md-position-mode="target-right target" ng-cloak>
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
				<md-menu-item>
                  <md-button ng-click="Delete()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.delete"></p>
                      <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
			</md-menu-content>
          </md-menu>
		<?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white orders-data">
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="<?php echo lang('quotes'); ?>">
          <md-content class="md-padding bg-white">
            <div class="proposal">
              <main>
                <div id="details" class="clearfix">
                  <div id="company">
                    <h2 class="name"><?php echo $settings['company'] ?></h2>
                    <div><?php echo $settings['address'] ?></div>
                    <div><?php echo lang('phone')?>:</b><?php echo $settings['phone'] ?></div>
                    <div><a href="mailto:<?php echo $settings['email'] ?>"><?php echo $settings['email'] ?></a></div>
                  </div>
                  <div id="client">
                    <div class="to"><span><?php echo lang('order').' '.lang('to'); ?>:</span></div>
                    <h2 class="name">
                      <?php if($orders['relation_type'] == 'customer'){if($orders['customercompany']== ""){echo $orders['namesurname'];} else echo $orders['customercompany'];} ?>
                      <?php if($orders['relation_type'] == 'lead'){echo $orders['leadname'];} ?>
                    </h2>
                    <div class="address"><?php echo $orders['toaddress']; ?></div>
                    <div class="email"><a href="mailto:<?php echo $orders['toemail']; ?>"><?php echo $orders['toemail']; ?></a></div>
					<?php if($orders['client_contact_person_name']) { ?>
					<div>
						<label>Attn:</label>
						<?php echo $orders['client_contact_person_name'];?>
					</div>
					<?php } ?>
                  </div>
                  <div id="invoice">
                    <h1 ng-bind="order.long_id"></h1>
                    <!--<div class="date"><?php echo lang('dateofissuance')?>: <span ng-bind="order.date"></span></div>
                    <div class="date text-bold"><?php echo lang('opentill')?>: <span ng-bind="order.opentill"></span></div>-->
                    <span class="text-uppercase" ng-bind="order.status_name">
					<?php if(($orders['status_id'] == '5' || $orders['status_id'] == '11') && !empty($declined_notes)) { ?>
						<md-tooltip md-direction="bottom"><?php echo $declined_notes["notes"];?></md-tooltip>
					<?php }?>
					</span> 
					</div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr>
                      <th class="desc"><?php echo lang('description') ?></th>
                      <th class="qty text-right"><?php echo lang('quantity') ?></th>
                      <th class="unit text-right"><?php echo lang('Price');echo ' (AED)'; ?></th>
                      <th class="discount text-right" ng-show="showdiscounttab == 1"><?php echo lang('discount'); echo ' (%)'; ?></th>
                      <th class="tax text-right"><?php echo $appconfig['tax_label']; echo ' (%)'; ?></th>
                      <th class="total text-right"><?php echo lang('total');echo ' (AED)'; ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat-start="item in order.items">
                      <td class="desc"><h3 ng-bind="item.name" ng-click="sectionToShow(item.id)"><br>
                        </h3>
                        <pre class="pre_view" ng-cloak>{{item.description}}</pre></td>
                      <td class="qty" ng-bind="item.quantity"></td>
                      <td class="unit"><span ng-bind="item.price"></span></td>
                      <td class="discount" ng-show="showdiscounttab == 1" ng-bind="item.discount+'%'"></td>
                      <td class="tax" ng-bind="item.tax+'%'"></td>
                      <!--<td class="total"><span ng-bind-html="item.total | currencyFormat:cur_code:null:true:cur_lct"></span></td>-->
                      <td class="total"><span ng-bind="item.price*item.quantity"></span></td>
					</tr>
					<?php if($orders['showAccess']== '1') { ?>
					<tr id="item_{{item.id}}" style="display:none" ng-show="item.child.length > 0">
						<td colspan='6' >
							<table class="gap">
								<thead>
									<tr>
										<th class="control-label text-right">Sku</th>
										<th class="control-label text-right">Name</th>
										<th class="control-label text-right">Qty</th>
										<th class="control-label text-right">Unit Cost</th>
										<th class="control-label text-right">Total Cost</th>
										<th class="control-label text-right">Margin %</th>
										<th class="control-label text-right">Selling Price</th>
									<tr>
								</thead>
								<tbody>
									<tr ng-repeat="echild in item.child">
										<td>{{echild.item_code}}</td>
										<td>{{echild.itemname}}</td>
										<td>{{echild.qty}}</td>
										<td>{{echild.unit_cost}}</td>
										<td>{{echild.total_cost}}</td>
										<td>{{echild.margin}}</td>
										<td>{{echild.selling_price}}</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<?php } ?>
					<tr ng-repeat-end ></tr>
                  </tbody>
                </table>
                <div class="col-md-12 md-pr-0" style="font-weight: 600; font-size: 14px; color: #000000;">
					<div class="col-md-6">
					  <div class="orders-data-f-left">
         <?php if($userInfo['role_name'] !='Sales Team' && $userInfo['role_name'] == 'Admin Role'){ ?>
            <div class="col-md-8">
              <div class="text-right text-uppercase text-muted"><?php echo $orders['cost_amount'] > 0 ?  lang('total_cost').':' :'' ;?></div>
              <div class="text-right text-uppercase text-muted"><?php echo $orders['profit_amt'] + $orders['quote_profit_amt'] > 0 ? lang('estimated_profit').':' :'';?></div>
            </div>
            <div class="col-md-4">
              <div class="text-left"><?php echo $orders['cost_amount'] > 0 ? $orders['cost_amount'] : ''; ?></div>
              <div class="text-left"><?php echo $orders['profit_amt'] + $orders['quote_profit_amt'] > 0 ? number_format(($orders['profit_amt'] + $orders['quote_profit_amt']), 2) : ''; ?></div>
            </div>
            <?php } ?>     
            </div>
					</div>
				  <div class="col-md-6">
                  <div class="col-md-8">
                    <div class="text-right text-uppercase text-muted"><?php echo lang('sub_total'); ?>:</div>
					<?php if($orders['total_discount'] > 0) { ?>
						<div class="text-right text-uppercase text-muted"><?php echo lang('total_discount'); ?>:</div>
					<?php } ?>
						<div class="text-right text-uppercase text-muted"><?php echo lang('net_total'); ?>:</div>
                    <?php if($orders['total_tax'] > 0) { ?>
						<div class="text-right text-uppercase text-muted"><?php echo lang('totalvatonsales'); ?>:</div>
					<?php } ?>
                    
                  </div>
                  <!--<div class="col-md-2">
                    <div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
                    <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
                  </div>-->
				  <div class="col-md-4">
					  <div class="text-right"><?php echo $orders['sub_total'] > 0 ? $orders['sub_total'] : '0.00'; ?></div>
					  <div class="text-right"><?php echo $orders['total_discount'] > 0 ?$orders['total_discount'] : '';?></div>
					  <div class="text-right"><?php echo $orders['sub_total'] > 0 ? ($orders['sub_total'] - $orders['total_discount']) : '0.00'; ?></div>
					  <div class="text-right"><?php echo $orders['total_tax'] > 0 ? $orders['total_tax'] : ''; ?></div>
					  
				  </div>

<div class="row">
  <div class="col-md-4"></div>
          <div class="col-md-8 grandtotal-bar">
            
              <div class="col-md-8"><div class="text-right text-uppercase"><?php echo lang('grand_total'); ?>:</div></div>
              <div class="col-md-4">
                <div class="text-right"><?php echo $orders['total'] > 0 ? $orders['total'] : '0.00'; ?></div>
              </div>
            </div>
            
          </div>

				  </div>
                </div>
              </main>
            </div>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('notes'); ?>">
          <md-content class="md-padding bg-white">
            <section class="ciuis-notes show-notes">
              <article ng-repeat="note in notes" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50" /> </div>
                <div class="ciuis-note-detail-body">
                  <div class="text">
                    <p> <span ng-bind="note.description"></span> <a ng-click='DeleteNote($index)' style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a> </p>
                  </div>
                  <p class="attribution"> by <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span> </p>
                </div>
              </article>
            </section>
            <section class="md-pb-30">
              <md-input-container class="md-block">
                <label><?php echo lang('description') ?></label>
                <textarea required name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <div class="form-group pull-right">
                <button ng-click="AddNote()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
                <?php echo lang('addnote')?>
                </button>
              </div>
            </section>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('reminders'); ?>">
          <md-list ng-cloak>
            <md-toolbar class="toolbar-white">
              <div class="md-toolbar-tools">
                <h2><?php echo lang('reminders') ?></h2>
                <span flex></span>
                <md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip" aria-label="Add Reminder">
                  <md-tooltip md-direction="left"><?php echo lang('addreminder') ?></md-tooltip>
                  <md-icon><i class="ion-plus-round text-success"></i></md-icon>
                </md-button>
              </div>
            </md-toolbar>
            <md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)" class="noright"> <img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
              <p>{{ reminder.description }}</p>
              <md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3" >
                <md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
                <i class="ion-ios-calendar-outline"></i> </md-icon>
              <md-icon ng-click="DeleteReminder($index)" aria-label="Send Email" class="md-secondary md-hue-3" >
                <md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
                <i class="ion-ios-trash-outline"></i> </md-icon>
            </md-list-item>
          </md-list>
        </md-tab>
      </md-tabs>
    </md-content>
	<md-divider></md-divider>
	<?php if($orders['content'] != '' && $orders['content'] != null) { ?>
	<md-content class="bg-white">
		<div id="desc">
			<h3>Special Notes</h3>
			<div class="address"><?php echo $orders['content']; ?></div>
		</div>
	<?php } ?>
	</md-content>
  </div>
<!---Add Image ---> 
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 right-sidebar">
	<div class="right-sidebar-inner">
   <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <!-- <md-button class="md-icon-button" aria-label="Quotes">
          <md-icon><i class="ion-android-clipboard text-muted"></i></md-icon>
        </md-button> -->
        <md-truncate><?php echo lang('information') ?></md-truncate>
      </div>
    </md-toolbar>
  <div class="col-md-12 col-xs-12 md-pr-0 md-pl-0 md-pb-10">
      <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul class="list-inline task-dates">
          <li class="col-md-6 col-xs-6">
            <h5><?php echo lang('related') ?></h5>
     <?php if($orders['estimation_id'] != '0' || $orders['estimation_id'] != ''){
      if($orders['enable_edit'] =='1' &&  check_privilege('estimations', 'edit')){ ?>
        <strong class="text-bold"><a class="label label-info" href="<?php echo base_url('estimations/view/'.$orders['estimation_id'].'')?>">Estimations <i class="ion-android-open"></i></a></strong>
      <?php }else{ ?>
        <strong class="text-bold">Estimations<i class="ion-android-open"></i></strong>
      <?php } ?>
     <?php } else { ?>
        <strong class="text-bold"><a class="label label-info" href="<?php echo base_url('orders/update/'.$orders['id'].'')?>">Quotes <i class="ion-android-open"></i></a></strong>
      </li>
    <?php } ?>
          <li class="col-md-6 col-xs-6">
            <h5><?php echo lang('status') ?></h5>
            <strong>{{order.status_name}}</strong> </li>
        </ul>
      </div>
   <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul class="list-inline task-dates">
          <li class="col-md-6 col-xs-6">
            <h5 ng-show="order.estimation_id == 0">Created By </h5>
      <h5 ng-show="order.estimation_id != 0">Requested By </h5>
            <span class="mdi mdi-assignment-account"></span> <strong >{{order.addedfrompersonname}}</strong> </li>
          <li class="col-md-6 col-xs-6">
            <h5 ng-show="order.estimation_id == 0">Created Date</h5>
      <h5 ng-show="order.estimation_id != 0">Requested Date</h5>
      <strong>{{order.created}}</strong>
      <!--
            <strong ng-bind="task.created"></strong>--> </li>
        </ul>
      </div>
    <div class="col-xs-12 task-sidebar-item" ng-cloak ng-show="order.estimateByStaff != '' && order.estimateByStaff != null">
        <ul class="list-inline task-dates">
          <li class="col-md-6 col-xs-6">
            <h5>Estimated By </h5>
            <span class="mdi mdi-assignment-account"></span> <strong >{{order.estimateByStaff}}</strong> </li>
          <li class="col-md-6 col-xs-6">
            <h5>Estimated Date</h5>
      <strong>{{order.estimateDate}}</strong>
      <!--
            <strong ng-bind="task.created"></strong>--> </li>
        </ul>
      </div>
    <div class="col-xs-12 task-sidebar-item" ng-cloak>
        <ul class="list-inline task-dates">
    
          <li class="col-md-6 col-xs-6">
            <h5>Sales By </h5>
            <span class="mdi mdi-assignment-account"></span> <strong >{{order.salesteamperson}}</strong> </li>
         
        </ul>
      </div>
      <div class="col-xs-12 task-sidebar-item" ng-cloak ng-show="order.estapproved_by!= '' && order.estapproved_by != null && order.approved_by == null">
        <ul class="list-inline task-dates">
          <li class="col-md-6 col-xs-6">
            <h5>Approved By</h5>
            <span class="mdi mdi-assignment-account"></span> <strong >{{order.estapproved_by}}</strong> </li>
          <li class="col-md-6 col-xs-6">
            <h5>Approved Date</h5>
      <strong>{{order.estapprove_date}}</strong>
      </li>
        </ul>
      </div>
     <div class="col-xs-12 task-sidebar-item" ng-cloak ng-show="order.approved_by != '' && order.approved_by != null">
        <ul class="list-inline task-dates">
          <li class="col-md-6 col-xs-6">
            <h5>Approved By</h5>
            <span class="mdi mdi-assignment-account"></span> <strong >{{order.approved_by}}</strong> </li>
          <li class="col-md-6 col-xs-6">
            <h5>Approved Date</h5>
      <strong>{{order.approved_date}}</strong>
      </li>
        </ul>
      </div>
    </div> 
  </div>
<div class="right-sidebar-inner">
  
  
  <?php if(sizeof($est_revisions)> 0){ ?>
  <div class="col-md-12 col-xs-12 md-pr-0 md-pl-0 md-pb-10" style="background: white">
      <div class="col-xs-12 task-sidebar-item" ng-cloak>
      <h4><strong>Estimations Revision:</strong></h4>
      <table class="table">
      <?php foreach($est_revisions as $key=>$eachrev) { $key = $key > 9 ? $key : '0'.$key; ?>
        <tr style="text-align:left;">
          <td style="width:25%;"><?php echo 'Rev'.$key;?></td>
          <td style="width:30%;padding:2px;"><strong>By: </strong><?php echo $eachrev['staffmembername'];?>
          <br/>
          <?php echo date('d M Y H:i:s',strtotime($eachrev['createddate']));?>
          </td>
        </tr>
      <?php } ?>
      </table>
    </div>
  </div>
  <?php } ?>
  <?php if(sizeof($revisions)> 0){ ?>
  <div class="col-md-12 col-xs-12 md-pr-0 md-pl-0 md-pb-10" style="background: white">
      <div class="col-xs-12 task-sidebar-item" ng-cloak>
      <h4><strong>Quotes Revision:</strong></h4>
      <table class="table">
      <?php foreach($revisions as $key=>$eachrev) { $key = $key > 9 ? $key : '0'.$key; ?>
        <tr style="text-align:left;">
          <td style="width:25%;"><?php echo 'Rev'.$key;?></td>
          <td style="width:30%;padding:2px;"><strong>By: </strong><?php echo $eachrev['staffmembername'];?>
          <br/>
          <?php echo date('d M Y H:i:s',strtotime($eachrev['createddate']));?>
          </td>
        </tr>
      <?php } ?>
      </table>
    </div>
  </div>
  <?php } ?>

</div>

<div class="right-sidebar-inner">
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
        <small><strong><?php echo lang('loading'). ' Quote Files...' ?></strong></small></span>
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
              <strong><h3 style="font-weight: 600;" class="link" ng-bind="file.file_name"></h3></strong>
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
</div>
<div class="right-sidebar-inner">

	<div class="ciuis-activity-line col-md-12">
    <h3><strong>History</strong></h3><br>
		<ul class="ciuis-activity-timeline">
			<li ng-repeat="eachhistory in orderhistory | limitTo: LogLimit" class="ciuis-activity-detail">
				<div class="ciuis-activity-title" ng-bind="eachhistory.date"></div>
				<div class="ciuis-activity-detail-body">
					<div ng-bind-html="eachhistory.detail|trustAsHtml"></div>
					<div style="margin-right: 15px; border-radius: 3px; background: transparent; color: #2f3239; font-weight: 400;" class="pull-right label label-default">
						<small class="log-date"><i class="ion-android-time"></i> <span ng-bind="eachhistory.logdate | date : 'MMM d, y h:mm:ss a'"></span></small>
					</div>
				</div>
			</li>
			<load-order-more></load-order-more>
		</ul>
	</div>



</div>


 </div>
<!--Image End---> 
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addreminder') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('datetobenotified') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('setreminderto'); ?></label>
          <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id" style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="reminder_description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
        </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit">
          <?php echo lang('addreminder')?>
          </button>
        </div>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('orders/add_file/'.$orders['id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile');?></h2>
    <!--<input type="file" required name="file_name" file-model="order_file">-->
	<input type="file" id="file1" name="file" multiple ng-files="getTheFiles($files)" required />
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

<script type="text/ng-template" id="declined-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('order/add_declined_msg/',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title" ng-bind="dec_msg"></h2>
	<input type="hidden" value="stat" ng-model="dec_stat"/>
	<md-input-container class="md-block" style="margin-top: 20px !important;">
		<textarea class="min_input_width" ng-model="orddeclined_msg" name="orddeclined_msg"  id="orddeclined_msg"></textarea>
	</md-input-container> 
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="closemarkas()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="ordDeclined()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('save');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>

<script type="text/ng-template" id="project-converted-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('order/convert_project/',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
	<div layout-gt-xs="row">
		<md-radio-group ng-model="is_tentative" name="is_tentative">
			<md-radio-button value="0">Deadline</md-radio-button>
			<md-radio-button value="1">Tentative</md-radio-button>
		</md-radio-group>
	</div>
	<div layout-gt-xs="row">
		<md-datepicker name="deadlinedate" ng-model="deadlinedate" md-open-on-focus></md-datepicker>
	</div>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="closeconvertedmarkas()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="orderconvertedtoproject()" class="template-button">
      <span><?php echo lang('convert');?></span>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>

<script type="text/ng-template" id="generate-order.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding class="text-center">
		<md-content class="bg-white" layout-padding>
			<h2 class="md-title" ng-hide="PDFCreating == true"><?php echo lang('generate_proposal_pdf')?></h2>
			<h2 class="md-title" ng-if="PDFCreating == true"><?php echo lang('report_generating')?></h2>
			<span ng-hide="PDFCreating == false"><?php echo lang('generate_pdf_msg')?></span><br><br>
			<span ng-if="PDFCreating == false"><?php echo lang('generate_pdf_last_msg')?></span><br><br>
			<img ng-if="PDFCreating == true" ng-src="<?php echo base_url('assets/img/loading_time.gif') ?>" alt="">
			<a ng-if="PDFCreating == false" href="<?php echo base_url('orders/download_pdf/'.$orders['id'].'') ?>"><img  width="30%"ng-src="<?php echo base_url('assets/img/download_pdf.png') ?>" alt=""></a>
		</md-content>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button class="text-success" ng-if="PDFCreating == false" href="<?php echo base_url('orders/download_pdf/'.$orders['id'].'') ?>"><?php echo lang('download') ?></md-button>
    <md-button class="text-success" ng-hide="PDFCreating == false" ng-click="CreatePDF()"><?php echo lang('create') ?>!</md-button>
    <md-button ng-click="CloseModal()"><?php echo lang('cancel') ?></md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
<script>
  var PROPOSALID = "<?php echo $pid;?>";
  var lang = {};
  lang.convert_title = "<?php echo lang('convert').' '.lang('convertproposaltoinvoice')?>";
  lang.convert_text = "<?php echo lang('convertmsg').' '.lang('convertproposaltoinvoice')?>";
  lang.convert = "<?php echo lang('convert')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
</script>
<script>
  var ORDERID = "<?php echo $orders['id'];?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_order = "<?php echo lang('delete_meesage').' '.lang('quotes')?>";
  lang.convert_title = "<?php echo lang('information')?>";
  lang.convert_text = "<?php echo lang('convertmsg').' '.lang('quotes').' '.lang('to').' '.lang('project')?>";
  lang.convert_invoice_title = "<?php echo lang('information')?>";
  lang.convert_invoice_text = "<?php echo lang('convertmsg').' '.lang('quotes').' '.lang('to').' '.lang('invoice')?>";
  lang.convert = "<?php echo lang('convert')?>";
</script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script src="<?php echo base_url('assets/js/orders.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>

