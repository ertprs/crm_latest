<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Vendor_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 class="md-pl-10" flex md-truncate ng-bind="vendor.vendor_number+' '+vendor.name"></h2>
				<?php if (check_privilege('vendors', 'edit')) { ?>					
				<md-button ng-click="Update()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
					<md-icon class="mdi mdi-edit"></md-icon>
				</md-button>
				<?php } if (check_privilege('vendors', 'delete')) { ?>
				<md-button ng-click="Delete()" class="md-icon-button md-primary" aria-label="Actions" ng-cloak>
					<md-icon class="ion-trash-b"></md-icon>
				</md-button>
				<?php } ?>					
			</div>
		</md-toolbar>
		<div ng-show="vendorsLoader" layout-align="center center" class="text-center" id="circular_loader">
			<md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
			<p style="font-size: 15px;margin-bottom: 5%;">
				<span>
					<?php echo lang('please_wait') ?> <br>
					<small><strong><?php echo lang('loading'). ' '. lang('vendor').'...' ?></strong></small>
				</span>
			</p>
		</div>
		<section ng-show="!vendorsLoader"  layout="row" flex>
			<md-sidenav class="md-sidenav-left" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')" style="z-index:0" ng-cloak>
				<md-subheader class="md-primary" style="background-color: white; border-bottom: 1px #e0e0e0 solid; padding-bottom: 2px; border-right: 1px #f3f3f3 solid;">
					<?php echo lang('informations');?>
				</md-subheader>
				<md-content class="bg-white" style="border-right:1px solid #e0e0e0;">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
					<md-list-item>
								<!--	<md-icon class="ion-android-call"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/contact_number_office.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $vendors['contact_number']?></p>[Contact Number Office]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="ion-android-call"></md-icon> -->
									<img src="<?php echo base_url('uploads/images/contact_person.jpg') ?>" alt="" width="30"
                                        height="30" /> 
									<p ><?php print $vendors['company_person']?></p>[Contact Person Office]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/credit_period.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $vendors['credit_period']?>"></p>[Credit Period]
								</md-list-item>
								<md-divider></md-divider>
									<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/credit_limit.jpg') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $vendors['credit_limit']?>"></p>[Credit Limit]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
									<img src="<?php echo base_url('uploads/images/lisence_nmber.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $vendors['licence_no']?>"></p>[Liscence Number]
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
								<!--	<md-icon class="mdi mdi-city material-icons"></md-icon> -->
								<img src="<?php echo base_url('uploads/images/doc_expiry.png') ?>" alt="" width="30"
                                        height="30" /> 
									<p ng-bind="<?php print $vendors['trade_expiry_date']?>"></p>[Expiry Date]
								</md-list-item>
								<md-divider></md-divider>
								<?php if(isset($documents)){
									?>
								<h4>Liscence Documents</h4>
								<?php foreach($documents as $eachdoc){?>
								<md-list-item>
									<md-icon class="mdi mdi-city material-icons"></md-icon>
									<a href="<?php print base_url();?>vendors/download_liscence_document/<?php print $eachdoc['dc_id'];?>"><?php print $eachdoc['document_name'];?></a> <a href="<?php print base_url();?>vendors/delete_liscence_document/<?php print $eachdoc['dc_id'];?>"><md-icon class="ion-trash-b ng-scope material-icons" role="img" aria-hidden="true"></md-icon></a>
								</md-list-item>
								<?php }?>
								<md-divider></md-divider>
								<?php }?>
						<md-list-item>
							<!-- <md-icon class="ion-android-call"></md-icon> -->
							<img src="<?php echo base_url('uploads/images/contact_number.png') ?>" alt="" width="30"
                                        height="30" /> 
							<p ng-bind="vendor.phone"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<!-- <md-icon class="mdi mdi-http"></md-icon> -->
							 <img src="<?php echo base_url('uploads/images/website.png') ?>" alt="" width="30"
                                        height="30" /> 
							<p ng-bind="vendor.web"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<!-- <md-icon class="ion-android-mail"></md-icon> -->
							<img src="<?php echo base_url('uploads/images/mail_id.png') ?>" alt="" width="30"
                                        height="30" /> 
							<p ng-bind="vendor.email"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<!-- <md-icon class="ion-earth"></md-icon> -->
						 <img src="<?php echo base_url('uploads/images/country.png') ?>" alt="" width="30"
                                        height="30" /> 	
							<p ng-bind="vendor.country"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<md-icon class="mdi mdi-map"></md-icon>
							<p ng-bind="vendor.state_name"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
						<!--	<md-icon class="mdi mdi-city"></md-icon> -->
							<img src="<?php echo base_url('uploads/images/city.png') ?>" alt="" width="30"
                                        height="30" /> 
							<p ng-bind="vendor.city"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<md-icon class="mdi mdi-city-alt"></md-icon>
							<p ng-bind="vendor.town"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<!-- <md-icon class="ion-ios-home"></md-icon> -->
							 <img src="<?php echo base_url('uploads/images/address.png') ?>" alt="" width="30"
                                        height="30" />
							<p ng-bind="vendor.address"></p>
						</md-list-item>
						<md-divider></md-divider>
						<md-list-item>
							<md-icon class="mdi mdi-markunread-mailbox"></md-icon>
							<p ng-bind="vendor.zipcode"></p>
						</md-list-item>
					</md-list>
				</md-content>
			</md-sidenav>
			<md-content class="bg-white information-section-hide" flex>
				<md-tabs md-dynamic-height md-border-bottom>
					<md-tab label="<?php echo lang('summary');?>">
						<md-content class="md-padding bg-white">
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 hidden-xs xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('riskstatus');?></h2>
										<small><?php echo lang('customerrisksubtext');?></small>
										<div ng-hide="vendor.risk != '0'" class="stat">
											<span style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i> <?php echo lang('norisk') ?></span>
										</div>
										<div ng-show="vendor.risk > '50'" class="stat"><span ng-bind="vendor.risk+'%'"></span></div>
										<div ng-show="vendor.risk > '50'" class="progress"><div style="width:{{vendor.risk}}%" class="progress-bar progress-bar-danger"></div></div>
										<div ng-show="vendor.risk > '0' && vendor.risk < 50" class="stat"><span ng-bind="vendor.risk+'%'"></span></div>
										<div ng-show="vendor.risk > '0' && vendor.risk < 50" class="progress"><div style="width:{{vendor.risk}}%" class="progress-bar progress-bar-primary"></div></div>
										<p><?php echo lang('customerrisksubtext');?></p>
									</div>
								</div>
							</div>
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('netrevenue');?></h2>
										<small><?php echo lang('netrevenuedetail');?></small>
										<div class='stat'>
											<span ng-show="vendor.netrevenue" ng-bind-html="vendor.netrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
											<span class="text-success font-10" ng-show="!vendor.netrevenue"><?php echo lang('nosalesyet') ?></span>
										</div>
										<p><?php echo lang('netrevenuedescription');?></p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('grossrevenue');?></h2>
										<small><?php echo lang('grossrevenuedetail');?></small>
										<div class='stat'>
											<span ng-show="vendor.grossrevenue" ng-bind-html="vendor.grossrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
											<span ng-show="!vendor.grossrevenue"><?php echo lang('nosalesyet') ?></span>
										</div>
										<p><?php echo lang('grossrevenuedescription');?></p>
									</div>
								</div>
							</div>
							<hr style="margin-bottom: 10px;">
						</md-content>
					</md-tab>
					<md-tab label="<?php echo lang('purchases');?>">
						<md-content class="bg-white">
							<md-list flex class="md-p-0 sm-p-0 lg-p-0">
								<md-list-item ng-repeat="invoice in purchases" ng-click="GoPuchases($index)" aria-label="Invoice">
									<md-icon class="ico-ciuis-invoices"></md-icon>
									<p><strong ng-bind="invoice.longid"></strong></p>
									<h4><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
									<md-divider></md-divider>
								</md-list-item>
							</md-list>
							<md-content ng-show="!purchases.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
						</md-content>
					</md-tab>
					<md-tab label="<?php echo lang('vendoractivities');?>">
						<md-content class="md-padding bg-white">
							<ul class="user-timeline">					
								<li ng-repeat="log in logs | filter: { vendor_id: '<?php echo $vendors['id'];?>' }">
									<div class="user-timeline-title" ng-bind="log.date"></div>
									<div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
								</li>					
							</ul>
						</md-content>
					</md-tab>
						<md-tab label="Terms And Conditions">
						<md-content class="md-padding bg-white">
							<?php print $vendors['terms_condition'];?>
						</md-content>
					</md-tab>
					<md-tab label="Notes">
					<md-content class="md-padding bg-white">
            <section class="md-pb-30">
              <md-input-container class="md-block" ng-show="!editNote">
                <label><?php echo lang('description') ?></label>
                <textarea name="description" ng-model="note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <md-input-container class="md-block" ng-show="editNote">
                <label><?php echo lang('description') ?></label>
                <textarea id="note_focus" name="description" ng-model="edit_note" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
              </md-input-container>
              <input type="hidden" name="" ng-model="edit_note_id">
              <div class="form-group pull-right">
                <md-button ng-show="editNote" ng-click="SaveNote()" class="template-button pull-right" ng-disabled="saveNote == true">
                  <span ng-hide="saveNote == true"><?php echo lang('savenote');?></span>
                  <md-progress-circular class="white" ng-show="saveNote == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                </md-button>
                <md-button ng-show="!editNote" ng-click="AddNote()" class="template-button pull-right" ng-disabled="addNote == true">
                  <span ng-hide="addNote == true"><?php echo lang('addnote');?></span>
                  <md-progress-circular class="white" ng-show="addNote == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                </md-button>
              </div>
            </section>
            <section class="ciuis-notes show-notes">
              <article ng-repeat="note in notes" class="ciuis-note-detail">
                <div class="ciuis-note-detail-img"> <img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50"/> </div>
                <div class="ciuis-note-detail-body"> 
                  <div class="text">
                    <p> 
                      <span ng-bind="note.description"></span> 
                      <a ng-click='DeleteNote($index)' class="ion-trash-a text-muted note-button pull-right" ng-disabled="modifyNote == true">
                        <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
                      </a>
                      <a ng-click='EditNote($index)' class="ion-compose note-button text-muted pull-right" ng-disabled="modifyNote == true">
                        <md-tooltip md-direction="bottom"><?php echo lang('edit') ?></md-tooltip>
                      </a>
                    </p>
                  </div>
                  <p class="attribution"> <?php echo lang('addedby') ?> <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> <?php echo lang('at') ?> <span ng-bind="note.date"></span> </p>
                </div>
              </article>
            </section>

						<md-content class="md-padding bg-white">
							<?php //print $vendors['notes'];?>
							
						</md-content>
					</md-tab>
					<md-tab label="Files">
						<md-content class="md-padding bg-white">
							  <md-button ng-click="UploadFile()"  class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
		  <div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-6 hidden-xs xs-pt-20 lg-pt-0">
		  <div ng-show="projectFiles" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
        <small><strong><?php echo lang('loading'). ' '. lang('project_files').'...' ?></strong></small></span>
      </p>
    </div>
	 <md-list flex ng-cloak>
        <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
          <div class="md-list-item-text image-preview">
            <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
              <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="{{file.path}}">
            </a>
            <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('vendors/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
            </a>
            <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('vendors/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
            <a ng-if="file.type == 'pdf'" class="cursor" ng-href="<?php echo base_url('vendors/download_file/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('vendors/download_file/{{file.id}}');?>">
              <h3 class="link" ng-bind="file.file_name"></h3>
            </a>
          </div>
          <?php if (check_privilege('vendors', 'delete')) { ?> 
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
	  </div>
						</md-content>
					</md-tab>
				</md-tabs>
			</md-content>
			<md-content class="bg-white information-section-show" flex>
				<md-tabs md-dynamic-height md-border-bottom>
					<md-tab label="<?php echo lang('informations');?>">
						<md-content class="md-padding bg-white">
							<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							
								<md-list-item>
									<md-icon class="ion-android-call"></md-icon>
									<p ng-bind="vendor.phone"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-http"></md-icon>
									<p ng-bind="vendor.web"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-android-mail"></md-icon>
									<p ng-bind="vendor.email"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-earth"></md-icon>
									<p ng-bind="vendor.country"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-map"></md-icon>
									<p ng-bind="vendor.state_name"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-city"></md-icon>
									<p ng-bind="vendor.city"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-city-alt"></md-icon>
									<p ng-bind="vendor.town"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-ios-home"></md-icon>
									<p ng-bind="vendor.address"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-markunread-mailbox"></md-icon>
									<p ng-bind="vendor.zipcode"></p>
								</md-list-item>
								
							</md-list>
						</md-content>
					</md-tab>
					<md-tab label="<?php echo lang('summary');?>">
						<md-content class="md-padding bg-white">
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 hidden-xs xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('riskstatus');?></h2>
										<small><?php echo lang('customerrisksubtext');?></small>
										<div ng-hide="vendor.risk != '0'" class="stat">
											<span style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i> <?php echo lang('norisk') ?></span>
										</div>
										<div ng-show="vendor.risk > '50'" class="stat"><span ng-bind="vendor.risk+'%'"></span></div>
										<div ng-show="vendor.risk > '50'" class="progress"><div style="width:{{vendor.risk}}%" class="progress-bar progress-bar-danger"></div></div>
										<div ng-show="vendor.risk > '0' && vendor.risk < 50" class="stat"><span ng-bind="vendor.risk+'%'"></span></div>
										<div ng-show="vendor.risk > '0' && vendor.risk < 50" class="progress"><div style="width:{{vendor.risk}}%" class="progress-bar progress-bar-primary"></div></div>
										<p><?php echo lang('customerrisksubtext');?></p>
									</div>
								</div>
							</div>
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('netrevenue');?></h2>
										<small><?php echo lang('netrevenuedetail');?></small>
										<div class='stat'>
											<span ng-show="vendor.netrevenue" ng-bind-html="vendor.netrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
											<span class="text-success font-10" ng-show="!vendor.netrevenue"><?php echo lang('nosalesyet') ?></span>
										</div>
										<p><?php echo lang('netrevenuedescription');?></p>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2><?php echo lang('grossrevenue');?></h2>
										<small><?php echo lang('grossrevenuedetail');?></small>
										<div class='stat'>
											<span ng-show="vendor.grossrevenue" ng-bind-html="vendor.grossrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
											<span ng-show="!vendor.grossrevenue"><?php echo lang('nosalesyet') ?></span>
										</div>
										<p><?php echo lang('grossrevenuedescription');?></p>
									</div>
								</div>
							</div>
							<hr style="margin-bottom: 10px;">
							
						</md-content>
					</md-tab>
					<md-tab label="<?php echo lang('purchases');?>">
						<md-content class="bg-white">
							<md-list flex class="md-p-0 sm-p-0 lg-p-0">
								<md-list-item ng-repeat="invoice in purchases" ng-click="GoPuchases($index)" aria-label="Invoice">
									<md-icon class="ico-ciuis-invoices"></md-icon>
									<p><strong ng-bind="invoice.longid"></strong></p>
									<h4><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
									<md-divider></md-divider>
								</md-list-item>
							</md-list>
							<md-content ng-show="!purchases.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
						</md-content>
					</md-tab>
					<md-tab label="<?php echo lang('vendoractivities');?>">
						<md-content class="md-padding bg-white">
							<ul class="user-timeline">					
								<li ng-repeat="log in logs | filter: { vendor_id: '<?php echo $vendors['id'];?>' }">
									<div class="user-timeline-title" ng-bind="log.date"></div>
									<div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
								</li>					
							</ul>
						</md-content>
					</md-tab>
				</md-tabs>
			</md-content>
		</section>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" ng-cloak style="width: 450px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
					class="ion-android-arrow-forward"></i> </md-button>
					<md-truncate flex><?php echo lang('update') ?></md-truncate>
					<md-switch ng-model="vendor.vendor_status_id" aria-label="Active"><strong class="text-muted"><?php echo lang('active')?></strong></md-switch>
				</div>
			</md-toolbar>
		<md-content layout-padding="">
			<md-content layout-padding>
				<md-input-container class="md-block">
					<label><?php echo lang('vendor').' '.lang('name'); ?></label>
					<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
					<input name="name" ng-model="vendor.name">
				</md-input-container>
				<!--
				<md-input-container class="md-block">
					<label><?php echo lang('company'); ?></label>
					<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
					<input name="company_name" ng-model="vendor.company_name">
				</md-input-container>-->
				<md-input-container class="md-block">
					<label>Company <?php echo lang('address') ?></label>
					<textarea ng-model="vendor.address" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				<md-input-container class="md-block">
					<label>contact number office</label>
					
					<input name="contact_number" ng-model="vendor.contact_number">
				</md-input-container>
				
				<md-input-container class="md-block">
					<label>contact person(accounts)</label>
					
					<input name="company_person" ng-model="vendor.company_person">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('vendor').' '.lang('group'); ?></label>
					<md-select placeholder="<?php echo lang('vendor').' '.lang('group'); ?>" ng-model="vendor.group_id"
						style="min-width: 200px;" required>
						<md-option ng-value="name.id" ng-repeat="name in groups">{{name.name}}</md-option>
					</md-select>
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo $appconfig['tax_label'].' '.lang('taxofficeedit'); ?></label>
					<input name="taxoffice" ng-model="vendor.taxoffice">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo $appconfig['tax_label'].' '.lang('taxnumberedit'); ?></label>
					<input name="taxnumber" ng-model="vendor.taxnumber">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('vendorupdate'); ?></label>
					<input name="executive" ng-model="vendor.executive">
				</md-input-container>
				<md-input-container class="md-block">
					<label>Mobile Number</label>
					<input name="phone" ng-model="vendor.phone">
				</md-input-container>
				<md-input-container class="md-block">
					<label>Credit Period</label>
					<input name="credit_period" ng-model="vendor.credit_period" type="number">
				</md-input-container>
				<md-input-container class="md-block">
					<label>Credit limit</label>
					<input name="credit_limit" ng-model="vendor.credit_limit">
				</md-input-container>
				
				<md-input-container class="md-block">
					<label><?php echo lang('fax'); ?></label>
					<input name="fax" ng-model="vendor.fax">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('email'); ?></label>
					<input name="email" ng-model="vendor.email" required minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/" />
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('customerweb'); ?></label>
					<input name="web" ng-model="vendor.web">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('country'); ?></label>
					<md-select placeholder="<?php echo lang('country'); ?>" ng-change="getStates(vendor.country_id)" ng-model="vendor.country_id" name="country_id" style="min-width: 200px;">
						<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('state'); ?></label>
					<md-select placeholder="<?php echo lang('state'); ?>" ng-model="vendor.state" name="state" style="min-width: 200px;">
						<md-option ng-value="state.id" ng-repeat="state in states">{{state.state_name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('city'); ?></label>
					<input name="city" ng-model="vendor.city">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('town'); ?></label>
					<input name="town" ng-model="vendor.town">
				</md-input-container>
				<md-input-container class="md-block">
					<label><?php echo lang('zipcode'); ?></label>
					<input name="zipcode" ng-model="vendor.zipcode">
				</md-input-container>
				<h5>Trade Details</h5>

 
   <md-input-container >
      <label for="licence_no">Licence No.</label>
     <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no" ng-model="vendor.licence_no">
	 </md-input-container>
  
	 <md-input-container>
      <label for="expiry_date"> Expiry Date</label>
	  <md-datepicker name="trade_expiry_date" ng-model="vendor.trade_expiry_date" md-open-on-focus></md-datepicker>
	  </md-input-container>
	  
	  
   
   
 <md-input-container class="md-block">
      <label for="inputAddress"> Documents</label><br>
  <input type="file" multiple  id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" ></div> 
  </md-input-container>
  
					<md-input-container class="md-block">
					<label>Terms And Conditions</label>
					<textarea ng-model="vendor.terms" name="terms" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				<!--
				<md-input-container class="md-block">
					<label>Notes</label>
					<textarea ng-model="vendor.notes" name="notes" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>-->
				<p id="vendorsError" style="color: red"></p>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
					<md-button ng-click="UpdateVendor()" class="md-raised md-primary btn-report block-button" ng-disabled="savingCustomer == true">
						<span ng-hide="savingCustomer == true"><?php echo lang('update');?></span>
						<md-progress-circular class="white" ng-show="savingCustomer == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					</md-button>
					<br/><br/><br/><br/>
				</section>	
			</md-content>
		</md-content>
	</md-sidenav>
</div>
<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('vendors/add_file/'.$vendors['id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="file_name" file-model="project_file">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="view_image.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>">
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('vendors', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('projects/download_file/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script>
	var lang={};
	var VENDORRID = "<?php echo $vendors['id'];?>";
	lang.doIt='<?php echo lang('doIt')?>';
	lang.cancel='<?php echo lang('cancel')?>';
    lang.attention='<?php echo lang('attention')?>';
    lang.delete_vendor="<?php echo lang('delete_vendor')?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url('assets/js/vendors.js'); ?>"></script>
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

</script>