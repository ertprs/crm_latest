<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->

<div class="ciuis-body-content" ng-controller="Estimations_Controller">
<div class="main-content container-fluid col-md-9 borderten">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-warning"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo 'EST'.$estimation_record['estimation_id'];?> <?php echo $estimation_record['project_name'];?></h2>
          <md-button ng-click="sendEmail()" class="md-icon-button" aria-label="Email" ng-cloak>
            <md-progress-circular ng-show="sendingEmail == true" md-mode="indeterminate" md-diameter="20">
            </md-progress-circular>
            <md-tooltip ng-hide="sendingEmail == true" md-direction="bottom" ng-bind="lang.send"></md-tooltip>
            <md-icon ng-hide="sendingEmail == true"><i class="mdi mdi-email text-muted"></i></md-icon>
          </md-button>
          <md-button ng-show="proposal.pdf_status == '0'" ng-click="GeneratePDF()" class="md-icon-button"
          aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
          </md-button>
          <md-button ng-show="proposal.pdf_status == '1'"
          ng-href="<?php //echo base_url('proposals/download_pdf/'.$proposals['id'] )?>" class="md-icon-button"
          aria-label="Pdf" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('pdf') ?></md-tooltip>
          <md-icon><i class="mdi mdi-collection-pdf text-muted"></i> </md-icon>
          </md-button>
          <md-button ng-href="<?php echo base_url('proposals/print_/{{proposal.id}}') ?>" class="md-icon-button"
            aria-label="Print" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('print') ?></md-tooltip>
            <md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
          </md-button>
        <?php if (check_privilege('invoices', 'create')) { ?>    
        <md-menu ng-if="!proposal.invoice_id" md-position-mode="target-right target">
          <md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
            <md-icon><i class="ion-loop text-success"></i></md-icon>
          </md-button>
          <md-menu-content width="4" ng-cloak>
            <md-contet class="text-center" layout-padding> <img height="80%"
              src="<?php echo base_url('assets/img/invoice_convert.png') ?>" alt="">
              <p style="max-width: 250px"> <strong
                ng-show="proposal.relation_type == true"><?php echo lang('leadproposalconvertalert') ?></strong>
                <strong
                ng-show="proposal.relation_type != true"><?php echo lang('convert_proposal_to_invoice') ?></strong>
              </p>
              <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                <md-button ng-click="Convert()" class="ion-filemd-primary pull-right" aria-label="Convert"><span
                  ng-bind="lang.convert"></span></md-button>
                </section>
              </md-contet>
            </md-menu-content>
          </md-menu>
        <?php } ?>
        <md-button ng-if="proposal.invoice_id"
          ng-href="<?php echo base_url('invoices/invoice/{{proposal.invoice_id}}')?>" class="md-icon-button" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('invoice') ?></md-tooltip>
          <md-icon><i class="ion-document-text text-success"></i></md-icon>
        </md-button>
        <?php if (check_privilege('proposals', 'edit') || check_privilege('proposals', 'delete')) { ?>   
          <md-menu md-position-mode="target-right target">
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
            </md-button>
            <md-menu-content width="4">
              <md-menu-item>
                <md-button ng-click="ViewProposal()" ng-bind="lang.viewproposal" aria-label="viewproposal"></md-button>
              </md-menu-item>
              <?php if (check_privilege('proposals', 'edit')) { ?> 
                <md-menu-item>
                  <md-button ng-click="NewMilestone()" ng-bind="lang.sentexpirationreminder"
                  aria-label="sentexpirationreminder"></md-button>
                </md-menu-item>
                <md-divider></md-divider>
                <md-menu-item>
                  <md-button ng-click="Update()" aria-label="Update">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.edit"></p>
                      <md-icon md-menu-align-target class="ion-edit" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-divider></md-divider>
              <?php } if (check_privilege('proposals', 'delete')) { ?>
                <md-menu-item>
                  <md-button ng-click="Delete()" aria-label="Delete">
                    <div layout="row" flex>
                      <p flex ng-bind="lang.delete"></p>
                      <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
                  </md-button>
                </md-menu-item>
                <md-divider></md-divider>
              <?php } if (check_privilege('proposals', 'edit')) { ?>
                <md-menu-item>
                  <md-button ng-click="MarkAs('Approved','Approved')"  aria-label="Mark As Approved">Mark As Approved</md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs('Draft','Draft')" aria-label="Draft">Mark As Draft</md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs('Missing Info','Missing Info')" >Mark As Missing Info</md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs('Under Approval','Under Approval')"  aria-label="Under Approval">Mark As Under Approval</md-button>
                </md-menu-item>
                <md-menu-item>
                  <md-button ng-click="MarkAs('Declined','Declined')"  aria-label="Declined">Mark As  Declined
                  </md-button>
                </md-menu-item>
                
              <?php } ?>
          </md-menu-content>
        </md-menu>
      <?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="<?php echo 'Estimation'; ?>">
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
                    <div class="to"><span><?php echo 'Estimation To'; ?>:</span></div>
                    <h2 class="name">
                     <?php echo $client_record['clientname'] ?>
                    </h2>
                    <div class="address"><?php echo $client_record['company_address']; ?></div>
                    <div class="email"><a
                        href="mailto:<?php echo $client_record['emailaddress']; ?>"><?php echo $client_record['emailaddress']; ?></a>
                    </div>
                  </div>
                  <div id="invoice">
                    <h1 ng-bind="proposal.long_id"></h1>
                    <div class="date"><?php echo lang('dateofissuance')?>: <span><?php echo $client_record['created']; ?></span></div>
                    <div class="date text-bold"><?php echo lang('opentill')?>: <span ng-bind="proposal.opentill"></span>
                    </div>
                    <span class="text-uppercase"><?php echo $estimation_record['estimate_status'];?></span>
                  </div>
                </div>
                <div ng-show="proposal.is_requested == '1'" class="col-md-6">
                  <strong><?php echo lang('details') ?>:<br></strong>
                  {{proposal.content}}
                  <br>
                  <br>
                </div>
                <div ng-show="proposal.is_requested == '1'" class="col-md-6">
                  <strong><?php echo lang( 'requested' ).' '.lang( 'quote' ).' '.lang('details') ?>:<br></strong>
                  {{proposal.customer_quote}}
                  <br>
                  <br>
                </div>
                <div ng-show="proposal.is_requested == '0'" class="col-md-12">
                  <strong><?php echo lang('details') ?>:<br></strong>
                  {{proposal.content}}
                  <br>
                  <br>
                </div>
				
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                      <th class="desc"><?php echo lang('description') ?></th>
                      <th class=" text-right"><?php echo lang('quantity') ?></th>
                      <th class=" unit  text-right">Unit <?php echo lang('price') ?></th>
                     
                      <th class=" text-right"><?php echo $appconfig['tax_label'] ?></th>
                      <th class="total text-right"><?php echo lang('total') ?></th>
					 
                    </tr>
                  </thead>
				  <?php 
				  $s=0;foreach($estimation_main_items as $k => $main_items ) {			  ?>
				
                  <tbody>
                    <tr>
                      <td class="desc">
                        <h3 onclick="toggling('<?php print $s;?>');" style="cursor:pointer;">
						<?php echo $main_items['item_name'];?>
                        </h3>
						<pre class="pre_view ng-binding"><?php echo $main_items['item_name'];?></pre>
                        </td>
                      </td>
                      <td class=" text-right"><?php echo $main_items['quantity'];?></td>
                      <td class=" unit text-right"><?php echo $main_items['unit_price'];?></td>
              
                      <td class=" text-right"><?php echo $main_items['tax']; ?></td>
                      <td class="total text-right"><?php echo $main_items['amount']; ?></td>
					 
                    </tr>
					
					 <tr class="subitems<?php print $s;?>" style="display:none;">
                     <td colspan="5" style="background: #fff;padding: 0px;">
                     
                            <div  style="margin-top: 10px;border: 1px solid #eee;" class="col-md-11 col-md-offset-1"> 
                              <div style="width:3%;float:left;">
                                <label class="control-label"><b>#</b>
                                </label>
                               
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label text-center"><b>Sku</b>
                                </label>
								
                              </div>
                              <div style="width:30%;float:left;margin-right: 5px;text-align: center;">
                                <label class="control-label"><b>Name</b>
                                </label>
								                              </div>
                              
                              <div style="width:5%;float:left;margin-right: 5px;">
                                <label class="control-label"><b>Qty</b>
                                </label>
                              </div>
							 
							  <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label"><b>Unit Cost</b>
                                </label>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label"><b>Total Cost</b>
                                </label>
                              </div>
                              <div style="width:8%;float:left;margin-right: 5px;">
                                <label class="control-label"><b>Margin % </b>
                                </label>
                              </div>
                              <div style="width:12%;float:left;margin-right: 5px;">
                                <label class="control-label"><b>Selling Price</b>
                                </label>
                              </div>
                                                      
                            </div>
                         
                  
                    </td>
                    </tr>
					<?php $t=1;foreach($estimation_sub_items as $l => $sub_items) { 
				
						
					 if($main_items['main_item_id'] == $sub_items['main_item_id']) { 
					 ?> 
					
                 
                    <tr class="subitems<?php print $s;?>" style="display:none;">
					<td  colspan="5" style="background: #fff;padding: 0px;">
					
                            <div class="col-md-11 col-md-offset-1" style="border:1px solid #eee;    margin-bottom: 10px;    padding-bottom: 10px;"> 
                              <div style="width:3%;float:left;">
                              
                                <br>
                                <span>
                                  <b><?php print $t;?>
                                  </b>
                                </span>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                               
								<br>
                               <?php echo $sub_items['item_code']; ?>
                              </div>
                              <div style="width:30%;float:left;margin-right: 5px;text-align: center;">
                               <br>
								 <?php if(is_numeric($sub_items['name'])){ echo $sub_items['itemname'];}else{ echo $sub_items['itemname'];} ?>
								                              </div>
                              
                              <div style="width:5%;float:left;margin-right: 5px;">
                              <br>
                                <?php echo $sub_items['qty']; ?>
                              </div>
							  
							  <div style="width:10%;float:left;margin-right: 5px;">
                                <br>
                                <?php echo number_format($sub_items['unit_cost'],2); ?>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                               <br>
                                <?php echo number_format($sub_items['total_cost'],2); ?>
                              </div>
                              <div style="width:8%;float:left;margin-right: 5px;">
                               <br>
                              <?php echo number_format($sub_items['margin'],2); ?>
                              </div>
                              <div style="width:12%;float:left;margin-right: 5px;">
                               <br>
                                <?php echo number_format($sub_items['selling_price'],2); ?>
                              </div>
                                                      
                            </div>
                        
					
                      </td>
                    </tr>
            
					
				  
				  
				 
					<?php $t++;?><?php } ?>
					
					<?php   }  ?>
					<tr class="subitems<?php print $s;?>" style="display:none;">
					<td colspan="5" style="background: #fff;padding: 0px;">
					 <div class="col-md-11 col-md-offset-1" style="margin-bottom: 10px;    padding-bottom: 10px;"> 
					 <div class="col-md-8">
					<b>Total Item Cost:</b><?php print number_format($main_items['sub_tot_cost'],2);?></div> <div class="col-md-3">
					<b>Total Selling Price:</b><?php print number_format($main_items['sub_tot_sp'],2);?></div>
					</div>
					</td>
					
					</tr>
					<?php $s++;} ?>
					

                  </tbody>
                </table>
				
				<div class="col-md-12 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
                  <div class="col-md-12">
				  <div class="col-md-10">
                    <div class="text-right text-uppercase text-muted"><?php echo lang('sub_total') ?>:</div></div><div class="col-md-2 text-right"><?php echo number_format($estimation_record['subtotal_amt'],2);?></div></div>
					<div class="col-md-12">
				  <div class="col-md-10">
                    <div  class="text-right text-uppercase text-muted">
                      <?php echo lang('total_discount') ?>:</div>
					  </div><div class="col-md-2 text-right">
                    <div  class="text-right text-uppercase text-muted">
                      <?php echo number_format($estimation_record['discount'],2); ?></div>
					  </div>
					  </div>
					  <div class="col-md-12">
				  <div class="col-md-10">
                    <div  class="text-right text-uppercase text-muted">
                      Total VAT:</div>
					  </div><div class="col-md-2 text-right">
                    <div  class="text-right text-uppercase text-muted">
                      <?php echo number_format($estimation_record['estimation_tax_amount'],2); ?></div>
					  </div>
					  </div>
					  <div class="col-md-12">
                    <div class="text-right text-uppercase text-black">
					 <div class="col-md-10"><?php echo lang('grand_total') ?>:</div></div><div class="col-md-2 text-right"><?php echo number_format($estimation_record['estimation_total_amt'],2);?></div></div>
                  </div>
               
				   
			 </main>
             </div>
          </md-content>
          <md-subheader ng-if="custom_fields"><?php echo lang('custom_fields') ?></md-subheader>
          <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
            <md-icon class="{{field.icon}} material-icons"></md-icon>
            <strong flex md-truncate>{{field.name}}</strong>
            <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
            <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
            <p ng-if="field.type === 'date'" class="text-right" flex md-truncate
              ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
            <p ng-if="field.type === 'select'" class="text-right" flex md-truncate
              ng-bind="custom_fields[$index].selected_opt.name"></p>
            <md-divider ng-if="custom_fields"></md-divider>
          </md-list-item>
        </md-tab>
        <md-tab label="<?php echo lang('notes'); ?>">
          <md-content class="md-padding bg-white">
            <section class="ciuis-notes show-notes">
              <article ng-repeat="note in notes" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt=""
                    width="50" height="50" /> </div>
                <div class="ciuis-note-detail-body">
                  <div class="text">
                    <p> <span ng-bind="note.description"></span> <a ng-click='DeleteNote($index)'
                        style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a> </p>
                  </div>
                  <p class="attribution"> by <strong><a
                        href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}"
                        ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span> </p>
                </div>
              </article>
            </section>
            <section class="md-pb-30">
              <md-input-container class="md-block">
                <label><?php echo lang('description') ?></label>
                <textarea required name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>"
                  class="form-control note-description"></textarea>
              </md-input-container>
              <div class="form-group pull-right">
                <button ng-click="AddNote()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
                  type="submit">
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
            <md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)"
              class="noright"> <img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
              <p>{{ reminder.description }}</p>
              <md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3">
                <md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
                <i class="ion-ios-calendar-outline"></i>
              </md-icon>
              <md-icon ng-click="DeleteReminder($index)" aria-label="Send Email" class="md-secondary md-hue-3">
                <md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
                <i class="ion-ios-trash-outline"></i>
              </md-icon>
            </md-list-item>
          </md-list>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('files') ?>/Drawings</h2>
       
      </div>
    </md-toolbar>
	   <md-content class="bg-white">
      <md-list flex ng-cloak>
	  <?php if(!empty($estimation_documents)){
		  foreach($estimation_documents as $eachdoc){
		  ?>
        <md-list-item class="md-2-line" >
          <div class="md-list-item-text image-preview">
         <a  class="cursor" >
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('estimations/download_file/'. $eachdoc['est_doc_id'].'');?>">
              <h3 class="link" ><?php print $eachdoc['document_name']; ?></a></h3>
            </a>
          </div>
          <?php if (check_privilege('tasks', 'delete')) { ?>
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
		  <?php }}else{?>
        <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
	  <?php }?>
      </md-list>
      <div ng-show="files.length>6" class="pagination-div" ng-cloak>
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
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
            class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('addreminder') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('datetobenotified') ?></label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
            placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date"
            show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('setreminderto'); ?></label>
          <md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id"
            style="min-width: 200px;">
            <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
          </md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label>
          <textarea required name="description" ng-model="reminder_description"
            placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
        </md-input-container>
        <div class="form-group pull-right">
          <button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane"
            type="submit">
            <?php echo lang('addreminder')?>
          </button>
        </div>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<script type="text/ng-template" id="generate-proposal.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding class="text-center">
		<md-content class="bg-white" layout-padding>
			<h2 class="md-title" ng-hide="PDFCreating == true"><?php echo lang('generate_proposal_pdf') ?></h2>
			<h2 class="md-title" ng-if="PDFCreating == true"><?php echo lang('report_generating') ?></h2>
			<span ng-hide="PDFCreating == false"><?php echo lang('generate_pdf_msg') ?></span><br><br>
			<span ng-if="PDFCreating == false"><?php echo lang('generate_pdf_last_msg') ?></span><br><br>
			<img ng-if="PDFCreating == true" ng-src="<?php echo base_url('assets/img/loading_time.gif') ?>" alt="">
			<a ng-if="PDFCreating == false" href="<?php echo base_url('proposals/download_pdf/'.$proposals['id'].'') ?>" alt=""><img  width="30%" ng-src="<?php echo base_url('assets/img/download_pdf.png') ?>" alt=""></a>
		</md-content>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button class="text-success" ng-if="PDFCreating == false" href="<?php echo base_url('proposals/download_pdf/'.$proposals['id'].'') ?>">
      <?php echo lang('download') ?>
    </md-button>
    <md-button class="text-success" ng-hide="PDFCreating == false" ng-click="CreatePDF()"><?php echo lang('create') ?>!</md-button>
    <md-button class="text-danger" ng-click="CloseModal()"><?php echo lang('cancel') ?>!</md-button>
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

<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/estimations.js') ?>"></script>
<!-- Latest compiled and minified JavaScript -->

<script>
function toggling(str)
{
	
	$('.subitems'+str).toggle();
}
</script>