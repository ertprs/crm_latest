<?php $appconfig = get_appconfig(); ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<div class="ciuis-body-content" ng-controller="Staff_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
    <!-- <div ng-show="staffLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
         <span>
            <?php echo lang('please_wait') ?> <br>
           <small><strong><?php echo lang('loading'). ' '. lang('details').'...' ?></strong></small>
         </span>
       </p>
     </div> -->


      
    <md-content ng-show="!staffLoader" class="bg-white user-profile">
      <div class="col-md-5 user-display">
        <div class="user-display-bg"><img ng-src="<?php echo base_url('assets/img/staffmember_bg.png'); ?>"></div>
        <div class="user-display-bottom" >
          <div class="user-display-avatar"><img ng-src="<?php echo base_url('uploads/images/{{staff.avatar}}')?>"></div>
          <div class="user-display-info">
            <div class="name" ng-bind="staff.name"></div>
            <div class="nick"><span ng-bind="staff.staff_number"></span></div>
            <div class="nick"><span class="mdi mdi-account"></span> <span ng-bind="staff.properties.department"></span></div>
			  <div class="nick">Mobile No: <span ng-bind="staff.phone"></span></div>
			  <div class="nick">Status: <span ng-bind="staff.inactive"></span></div>
          </div>
        </div>
        <md-divider></md-divider>
        
        <div class="col-md-6" style="padding: 0px" >
              <md-content class="bg-white">
                <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
                  <md-divider></md-divider>
                  <md-list-item>
                     <div class="col-xs-6">Joining Date :</div>
                    <p ng-bind="staff.joining_date"></p>
                  </md-list-item>
      			<md-divider></md-divider>
      			 <md-list-item>
			
              <div class="col-xs-6"> Profession :</div>
              <p ng-bind="staff.profession"></p>
            </md-list-item>

            <md-divider></md-divider>
             <md-list-item>
                    <div class="col-xs-6"> Created :</div>
                    <p ng-bind="staff.createdat"></p>
                  </md-list-item>
            <md-divider></md-divider>

             <md-list-item>
                    <div class="col-xs-6"> Date of Birth : </div>
                    <p ng-bind="staff.date_of_birth_result"></p>
                  </md-list-item>


          </md-list>
        </md-content>
      </div>
          <div class="col-md-6" style="padding: 0px">

        <md-content class="bg-white">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
            
            <md-divider></md-divider>
 
             <md-list-item>
                    <div class="col-xs-6"> Gender : </div>
                    <p ng-bind="staff.gender"></p>
          
                  </md-list-item>
            <md-divider></md-divider>

             <md-list-item>
                    <div class="col-xs-6"> Nominee : </div>
                    <p ng-bind="staff.nominee"></p>
                  </md-list-item>
            <md-divider></md-divider>
             <md-list-item>
                    <div class="col-xs-6">Nationality : </div>
                    <p ng-bind="staff.nationality"></p>
                  </md-list-item>
                  <md-divider></md-divider>
                  <md-list-item>
                    <div class="col-xs-12">
                    Home Country Address <br>
                    <p ng-bind="staff.address"></p>
                  </div>
                  </md-list-item>
                 <!--  <md-divider></md-divider> -->
          </md-list>
        </md-content>
      </div>
      
			
			
			<!--
            <md-list-item>
              <md-icon class="mdi ion-android-mail"></md-icon>
              <p ng-bind="staff.email"></p>
            </md-list-item>-->
         
      
        <md-divider></md-divider>
        <!-- <md-content class="md-padding bg-white">
          <div class="col-xs-4">
            <div class="title"><?php echo lang('sales')?></div>
            <div class="counter"><strong ng-bind-html="staff.properties.sales_total | currencyFormat:cur_code:null:true:cur_lct"></strong></div>
          </div>
          <div class="col-xs-4">
            <div class="title"><?php echo lang('customers')?></div>
            <div class="counter"><strong ng-bind="staff.properties.total_customer"></strong></div>
          </div>
          <div class="col-xs-4">
            <div class="title"><?php echo lang('tickets')?></div>
            <div class="counter"><strong ng-bind="staff.properties.total_ticket"></strong></div>
          </div>
        </md-content> -->
      </div>
      
      <div class="col-md-7" style="padding: 0px">
        <md-toolbar class="toolbar-white">
          <div class="md-toolbar-tools">
            <h2 class="md-pl-10" flex md-truncate><?php echo lang('staffdetail') ?></h2>
            <?php if (check_privilege('staff', 'edit')) { ?>
              <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak>
                <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>
            <?php }?>
            <md-menu md-position-mode="target-right target" ng-cloak>
              <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
                <md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
              </md-button>
              <md-menu-content width="4">
                <?php if (check_privilege('staff', 'edit')) { ?>
                  <md-menu-item>
                    <md-button ng-click="ChangePassword()">
                      <div layout="row" flex>
                        <p flex><?php echo lang('changepassword') ?></p>
                        <md-icon md-menu-align-target class="ion-locked" style="margin: auto 3px auto 0;"></md-icon>
                      </div>
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="ChangeAvatar()">
                      <div layout="row" flex>
                        <p flex><?php echo lang('changeprofilepicture') ?></p>
                        <md-icon md-menu-align-target class="ion-android-camera" style="margin: auto 3px auto 0;"></md-icon>
                      </div>
                    </md-button>
                  </md-menu-item>
                <?php } if(check_privilege('staff', 'delete')) {?>
                  <md-menu-item>
                    <md-button ng-click="Delete()">
                      <div layout="row" flex>
                        <p flex><?php echo lang('delete') ?></p>
                        <md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
                      </div>
                    </md-button>
                  </md-menu-item>
                <?php }?>
              </md-menu-content>
            </md-menu>
          </div>
        </md-toolbar>
        <md-content class="bg-white">
          <?php /* <div class="col-md-12"  style="align-self: flex-end;">
            <div class="widget-chart-container">
              <div class="widget-counter-group widget-counter-group-right md-p-20">
                <div class="pull-left text-left">
                  <h4><b><?php echo lang('staffsalesgraphtitle')?></b></h4>
                  <small><?php echo lang('staffsalesgraphdescription')?></small> </div>
                <div class="counter counter-big md-p-10">
                  <div class="text-warning value" ng-bind-html="staff.properties.sales_total | currencyFormat:cur_code:null:true:cur_lct"></div>
                  <div class="desc"><?php echo lang('inthisyear')?></div>
                </div>
              </div>
              <div class="ciuis-chart" style="align-self: flex-end;" ng-cloak>
                <div class="card">
                  <canvas width="900px" height="260px" id="staff_sales_chart"></canvas>
                  <div class="axis">
                    <div ng-repeat="inline in staff.properties.chart_data.inline_graph" class="tick"> {{inline.month}} <span class="value value--this" ng-bind-html="100 | currencyFormat:cur_code:null:true:cur_lct"></span> <span class="value value--prev" ng-bind-html="100| currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                  </div>
                </div>
              </div>
            </div>
          </div> */ ?>
		    <div style="width:70%;hieght:90%;text-align:center">
            <h2 class="page-header" >Attendance Graph </h2>
            <div>Month </div>
            <canvas  id="chartjs_bar"></canvas> 
        </div>   
		<?php $productname = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$sales = array('100','300','400','500');?>
        </md-content>
      </div>
      <?php if (!$this->session->userdata('other')) { ?>
      <div class="col-md-12 staff-tabs-content"  ng-cloak>
        <md-divider></md-divider>
        <md-content class="bg-white">
          <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="<?php echo lang('work_plan') ?>">
              <md-content class="text-center bg-white">
                <md-toolbar class="toolbar-white">
                  <div class="md-toolbar-tools">
                    <h2 flex md-truncate><?php echo lang('work_plan') ?></h2>
                    <?php if (check_privilege('staff', 'edit')) { ?>
                      <md-button class="md-icon-button" aria-label="view" ng-href="<?php echo base_url('staff/restore_workplan/'). $id?>">
                        <md-icon><i class="ion-ios-refresh-outline text-muted"></i></md-icon>
                        <md-tooltip md-direction="bottom"><?php echo lang('restore').' '.lang('workplan') ?></md-tooltip>
                      </md-button>
                    <?php }?> 
                    <md-button ng-show='View_Work == false' ng-click="View_Work = true" ng-init="View_Work = false" class="md-icon-button" aria-label="view">
                      <md-icon><i class="mdi mdi-plus-circle text-muted"></i></md-icon>
                      <md-tooltip md-direction="bottom"><?php echo lang('show') ?></md-tooltip>
                    </md-button>
                    <md-button aria-label="Select All" class="md-icon-button" ng-show='View_Work == true' ng-click="View_Work = false"> 
                      <md-icon><i class="mdi mdi-minus-circle-outline text-muted"></i></md-icon>
                      <md-tooltip md-direction="bottom"><?php echo lang('hide') ?></md-tooltip>   
                    </md-button>
                    <?php if (check_privilege('staff', 'edit')) { ?>
                      <md-button ng-click="UpdateWorkPlan()" class="md-raised md-primary btn-report" aria-label='Update Work Plan' ng-disabled="savingWork == true">
                        <span ng-hide="savingWork == true"><?php echo lang('save'); ?></span>
                        <md-progress-circular class="white" ng-show="savingWork == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                        <md-tooltip ng-hide="savingWork == true" md-direction="bottom"><?php echo lang('update_work_plan') ?></md-tooltip>
                      </md-button>
                    <?php }?>
                  </div>
                </md-toolbar>
                <div layout="row" layout-wrap ng-show="View_Work == true">
                  <md-content flex="13" class="week-day-time bg-white"  ng-repeat="weekday in staff.work_plan" layout-padding>
                    <md-checkbox ng-model="weekday.status"><span class="text-uppercase text-bold">{{ weekday.day }}</span></md-checkbox>
                    <fieldset class="demo-fieldset" >
                      <legend class="demo-legend"><?php echo lang('working_hours') ?></legend>
                      <md-input-container>
                        <label><?php echo lang('start') ?></label>
                        <input str-to-time="" ng-model="weekday.start" type="time">
                      </md-input-container>
                      <md-input-container>
                        <label><?php echo lang('end') ?></label>
                        <input str-to-time="" ng-model="weekday.end" type="time">
                      </md-input-container>
                    </fieldset>
                    <fieldset class="demo-fieldset" >
                      <legend class="demo-legend"><?php echo lang('break_time') ?></legend>
                      <md-input-container>
                        <label><?php echo lang('start') ?></label>
                        <input str-to-time="" ng-model="weekday.breaks.start" type="time">
                      </md-input-container>
                      <md-input-container>
                        <label><?php echo lang('end') ?></label>
                        <input str-to-time="" ng-model="weekday.breaks.end" type="time">
                      </md-input-container>
                    </fieldset>
                  </md-content>
                </div>
              </md-content>
            </md-tab>
			<?php $path = $this->uri->segment( 4 ); 
			 ?>
			<?php if($path == 'documents'){ ?>
				<md-tab label="<?php echo lang('documents');?>"  md-active="true">
				<md-content class="bg-white">
			<?php } else { ?>	
			<md-tab label="<?php echo lang('documents');?>"  >
				<md-content class="bg-white">
				<?php }  ?>	
				<br>
				
				<form  action="<?php echo base_url('staff/update_documents/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">

            
  <div class="form-row">
   <div class="form-group col-md-2">
      <label for="inputState">Doument Name</label>
      <input type="text" class="form-control" name="document_name"id="document_name" value="<?php echo $path; ?>">
    </div>
    <div class="form-group col-md-2">
      <label for="inputState">Document ID</label>
      <input type="text" class="form-control" name="document_id"id="inputZip" value="<?php echo @$documents->passport; ?>">
    </div>
    <div class="form-group col-md-2">
        <label for="inputState">Expiry Date</label>
		<div class="input-group date">
        <input type="text" name="expiry_date" class="form-control newdatepicker" id="expiry_date" value="<?php  echo @$documents->passport_expiry_date ;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	  <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="remind" id="inputZip" placeholder="Remind Me" value="<?php echo @$documents->passport_remind ;?>">
    </div>
	 <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <!-- <input type="hidden" name="old_passport_data" value="<?php  //echo @$documents->passport_doc ;?>"> -->
      <input type="file" class="form-control" name="doc[]" multiple id="passport_doc">
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$documents->passport_doc) { 
        $passport_doc = explode(",", $documents->passport_doc);
          foreach ($passport_doc as $key => $pass_value) {
            ?>
          <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
            <?php 
          }
         } ;?>
    </div>
	<div class="form-group col-md-12" style="margin-left:82%;">
  <button type="submit" class="btn btn-primary" >Save</button>
  <a href="<?php echo base_url('staff/staffmember/'.$staffres['id']); ?>"><img src="<?php echo base_url('uploads/images/closebutton.jpg'); ?>"></a>
  </div>
  </div>
  </form>
<?php   if($documents){  
  foreach ($documents as $key => $value) {
?>
<div class="row">
  <div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-3">
          <?php echo $value->document_name;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->document_id;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->expiry_date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->remind;?>
        </div>
        <div class="form-group co-md-2">
          <?php  if(@$value->doc) { 
        $doc = explode(",", $value->doc);
          foreach ($doc as $key => $pass_value) {
            ?>
          <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
            <?php 
          }
         } ;?>
        </div>
      </div>
    </div>



</div>
  
 
  
<?php }  }?>
				
				 </md-content>
			
			</md-tab>
			<md-tab label="<?php echo lang('salary');?>">
				<md-content class="bg-white">
				
				<?php if($this->session->flashdata('message')!=''){?>
				<div id="infoMessage" class="alert alert-danger col-md-6"><?php echo $this->session->flashdata('message');?></div>
				<?php }?>
				<form class="form-horizontal" action="<?php echo base_url('staff/update_salary_details');?>" method="post">
				
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label col-sm-4" for="email">Fixed Portion:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="salary" placeholder="Enter basic salary" name="salary" value="<?php echo  $staffres['basic_salary'];?>">
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-sm-4" for="pwd">Allowance:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="allowance" placeholder="Enter Other Allowance" name="allowance" value="<?php print $staffres['allowance'];?>">
					</div>
				  </div>
				  <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Vehicle/ Transport Allowance:</label>
					<div class="col-sm-8">
            <div class="row">
            <div class="col-md-8">
					  <select name="transport_allowance" class="form-control" id="transport_allowance">
						<option value="">Select Type</option>
						<option value="Provide By Company" <?php if($staffres['transport_allowance']=="Provide By Company"){print "selected='selected'";} ?>>Provide By Company</option>
						<option value="Not Provide By Company" <?php if($staffres['transport_allowance']=="Not Provide By Company"){print "selected='selected'";} ?>>Not Provide By Company</option>
					  </select>
					</div>
          <div class="col-md-4">
            <input type="text" class="form-control" id="vehicle_amound" placeholder="Enter Amound" name="vehicle_amound" value="<?php print $staffres['vehicle_amound'] ;?>">
          </div>
        </div>
      </div>
				  </div>
				   <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Accomodation Allowance:</label>
					<div class="col-sm-8">
            <div class="row">
            <div class="col-md-8">
              <select name="accomodation_allowance" class="form-control" id="accomodation_allowance">
            <option value="">Select Type</option>
            <option value="Provide By Company" <?php if($staffres['accomodation_allowance']=="Provide By Company"){print "selected='selected'";} ?>>Provide By Company</option>
            <option value="Not Provide By Company" <?php if($staffres['accomodation_allowance']=="Not Provide By Company"){print "selected='selected'";} ?>>Not Provide By Company</option>
            </select>
					</div>
          <div class="col-md-4">
            <input type="text" class="form-control" id="accom_amound" placeholder="Enter Amound" name="accom_amound" value="<?php echo $staffres['accom_amound'] ;?>">
          </div>
        </div>
        </div>
				  </div>
				   <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Over Time/Hour:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="over_time" placeholder="Enter Other Allowance" name="over_time" value="<?php print $staffres['over_time'];?>"> 
					</div>
				  </div>
				  <div class="form-group">
            <label class="control-label col-sm-4" for="pwd">Total salary</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="total_salary" placeholder="Enter Total Salary" name="total_salary" value="<?php print $staffres['total_salary'];?>"> 
          </div>
          </div>
				  </div>
				  <div class="col-md-6">
				  <div class="form-group">
					<label class="control-label col-sm-4" for="email">Work Permit No:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="work_permit_no" placeholder="Work Permit No" name="work_permit_no" value="<?php print $staffres['work_permit_no'];?>">
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-sm-4" for="pwd">Work Permit Personal No:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="work_permit_personal_no" placeholder="Work Permit Personal No" name="work_permit_personal_no" value="<?php print $staffres['work_permit_personal_no'];?>">
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-sm-4" for="pwd">Bank Name:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="bank_name" placeholder="Bank Name" name="bank_name" value="<?php print $staffres['bank_name'];?>">
					</div>
				  </div>
				   <div class="form-group">
					<label class="control-label col-sm-4" for="pwd">IBAN/Bank Card  Number:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="bank_card_number" placeholder="IBAN/Bank Card  Number" name="bank_card_number" value="<?php print $staffres['bank_card_number'];?>">
					</div>
				  </div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-primary">Update</button>
					</div>
				  </div>
				  <input type="hidden" name="id" value="<?php print $staffres['id']; ?>" >
				</form>
				 </md-content>
			</md-tab>
			<md-tab label="<?php echo lang('appraisal');?>">
				<md-content class="bg-white">
				<br>
				<form  action="<?php echo base_url('staff/update_appraisal_details/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">
  <div class="form-row">
   
    <div class="form-group col-md-3">
      <label for="inputState">Date Of Increment</label>
  	    <div class="input-group date">
        <input type="text" name="increment_date" class="form-control newdatepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div> 
      <!-- <md-datepicker required name="increment_date" id="increment_date" ng-model="staff.date_of_increment" md-open-on-focus ></md-datepicker>  -->

      
    </div>
    <div class="form-group col-md-2">
      <label for="increment_amount">Increment Amount</label>
      <input type="text" class="form-control" name="increment_amount" id="increment_amount">
    </div>
	  <div class="form-group col-md-2">
      <label for="increment_type">Increment Type</label>
      <select class="form-control" name="increment_type" id="increment_type">
        <option selected>Choose...</option>
        <option name="increment_type" value="Basic Salary">Basic Salary</option>
        <option name="increment_type" value="Allowancen">Allowance</option>
        <option name="increment_type" value="Transpotation Aloowance">Transpotation Aloowance</option>
        <option name="increment_type" value="Basic Salary">Basic Salary</option>
        <option name="increment_type" value="Basic Salary">Basic Salary</option>
      </select>
    </div>
	 <div class="form-group col-md-2">
      <label for="increment_reason">Reason Of Increment</label>
      <select class="form-control" name="increment_reason" id="increment_reason">
        <option selected>Choose...</option>
        <option name="increment_reason" value="Best Performance">Best Performance</option>
        <option name="increment_reason" value="Hardworking Person">Hardworking Person</option>
        <option name="increment_reason" value="Good Leader">Good Leader</option>
        <option name="increment_reason" value="Team Management Perfoiramce">Team Management Perfoiramce</option>
        <option name="increment_reason" value="Base Employee">Base Employee</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_appraisal_data" value="<?php echo @$appraisal->appraisal_doc ;?>">
      <input type="file" class="form-control" name="appraisal_doc[]" multiple id="appraisal_doc">
    </div>
	 <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>  
</form>
       
    


<?php   if($appraisal){  
  foreach ($appraisal as $key => $value) {
?>
<div class="row">
  <div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-3">
          <?php echo $value->increment_date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->increment_amount;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->increment_type;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->increment_reason;?>
        </div>
        <div class="form-group co-md-2">
          <?php  if(@$value->appraisal_doc) { 
        $appraisal_doc = explode(",", $value->appraisal_doc);
          foreach ($appraisal_doc as $key => $pass_value) {
            ?>
          <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
            <?php 
          }
         } ;?>
        </div>
      </div>
    </div>
</div>

<?php }  }?>


				 </md-content>
			</md-tab>
			
				<md-tab label="<?php echo lang('warning');?>">
				<md-content class="bg-white">
				<br>
				<form  action="<?php echo base_url('staff/update_warning/'.$staffres['id']);?>" method="post">


  <div class="form-row">
   
    <div class="form-group col-md-2">
      <label for="warning_date">Warning Date</label>
	  <div class="input-group date">
        <input type="text" name="warning_date" class="form-control newdatepicker " id="warning_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group col-md-2">
      <label for="date_of_incident">Date Of Incident</label>
	   <div class="input-group date">
        <input type="text" name="date_of_incident" class="form-control newdatepicker " id="date_of_incident"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
	  <!-- <div class="form-group col-md-2">
      <label for="warning_type">Warning Type</label>
      <input type="text" class="form-control" name="warning_type" id="warning_type">
    </div> -->
    <div class="form-group col-md-2">
      <label for="inputState"> Warning Type</label>
      <select id="inputState"  name="warning_type" class="form-control">
        <option selected>Choose...</option>
        <option  name="warning_type" value="Warning" >Warning</option>
        <option name="warning_type" value="Warning 1">Warning 1</option>
        <option name="warning_type" value="Warning 2">Warning 2</option>
        <option name="warning_type" value="Warning 3">Warning 3</option>
        <option name="warning_type" value="Suspention">Suspention</option>
        <option name="warning_type" value="termination">Termination</option>
      </select>
    </div> 
    <div class="form-group col-md-2">
      <label for="inputState"> Type Of violation</label>
      <select id="inputState"  name="type_of_violation" class="form-control">
        <option selected>Choose...</option>
        <option  name="type_of_violation" value="Poor Perfomanc">Poor Perfomance</option>
        <option name="type_of_violation" value="Misconduct on company premies&properties">Misconduct on company premies&properties</option>
        <option name="type_of_violation" value="Late Attendence">Late Attendence</option>
        <option name="type_of_violation" value="Negligence">Negligence</option>
        <option name="type_of_violation" value="Disrespectful Behavior">Disrespectful Behavior</option>
        <option name="type_of_violation" value="Insubordination">Insubordination</option>
        <option name="type_of_violation" value="Goosiping">Goosiping</option>
        <option name="type_of_violation" value="Sexual Harassment">Sexual Harassment</option>
        <option name="type_of_violation" value="Excessive Absenteeism Or Tardiness">Excessive Absenteeism Or Tardiness</option>
        <option name="type_of_violation" value="Hygiene">Hygiene</option>
        <option name="type_of_violation" value="Dress Code Violation">Dress Code Violation</option>
        <option name="type_of_violation" value="Violation Of Company Polices Or procedures">Violation Of Company Polices Or procedures</option>
        <option name="type_of_violation" value="Willfull Damage to Material or Equipment">Willfull Damage to Material or Equipment</option>
        <option name="type_of_violation" value="Violation Of Safety Rules">Violation Of Safety Rules</option>
        <option name="type_of_violation" value="Intoxication During Work Hours">Intoxication During Work Hours</option>
        <option name="type_of_violation" value="Breach Of Company Policy">Breach Of Company Policy</option>
        <option name="type_of_violation" value="Other">Other</option>
        <!-- <option name="type_of_violation" value="Goosping">Goosping</option> -->
      </select>
    </div> 
    <div class="form-group col-md-1">
      <label for="inputState"> Action</label>
      <select id="inputState"  name="action" class="form-control">
        <option selected>Choose...</option>
        <option  name="action" value="Deduction Of Workhours 3 days" >Deduction Of Workhours 3 days</option>
        <option name="action" value="Suspention Of Over Time">Suspention Of Over Time</option>
        <option name="action" value="Suspention">Suspention</option>
        <option name="action" value="Termination">Termination </option>
      </select>
    </div> 
	 <div class="form-group col-md-2">
      <label for="employee_signature">Employee Signature</label>
      <input type="text" class="form-control" name="employee_signature" id="employee_signature">
    </div>
  </div>
<div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php   if($warning){  
  foreach ($warning as $key => $value) {
?>
<div class="row">
  <div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-2">
          <?php echo $value->warning_date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->date_of_incident;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->warning_type;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->type_of_violation;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->action;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->employee_signature;?>
        </div>
      </div>
    </div>
</div>
<?php }  }?>
				 </md-content>
			</md-tab>

      <md-tab label="<?php echo lang('leaves');?>">
        <md-content class="bg-white">
        <br>
        <form  action="<?php echo base_url('staff/update_leaves/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">


  <div class="form-row">
   
    <div class="form-group col-md-2">
      <label for="warning_date">Leave Start Date</label>
	  <div class="input-group date">
        <input type="text" name="leave_start_date" class="form-control newdatepicker " id="leave_start_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group col-md-2">
      <label for="date_of_incident">Rejoin Date</label>
	   <div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control newdatepicker " id="rejoin_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
     
    </div>
    <div class="form-group col-md-2">
      <label for="warning_type">No Of Day's leave</label>
      <input type="text" class="form-control" name="no_leave" id="no_leave">
    </div>
   <div class="form-group col-md-2">
      <label for="type_of_violation">Payment Type</label>
      <select  class="form-control" name="payment_type" id="payment_type">
        <option selected>Choose...</option>
        <option name="payment_type" value="Paid">Paid</option>
        <option name="payment_type" value="Unopaid">Unpaid</option>
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="action">Type Of Leave</label>
      <select  class="form-control" name="type_of_leave" id="type_of_leave">
        <option selected>Choose..</option>
        <option name="type_of_leave" value="Un Approved Leave">Un Approved Leave</option>
        <option name="type_of_leave" value="Sick Leave">Sick Leave</option>
        <option name="type_of_leave" value="Annual Leave">Annual Leave</option>
        <option name="type_of_leave" value="Emergency Leave">Emergency Leave</option>
        <option name="type_of_leave" value="Paid Leave">Paid Leave</option>
        <option name="type_of_leave" value="Casual Leave">Casual Leave</option>
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="employee_signature">Method Of Leave</label>
      <select class="form-control" name="method_of_leave" id="method_of_leave">
        <option selected>Choose...</option>
        <option name="method_of_leave" value="Leave without Approvsl-Deduction Of 2 Hours">Leave without Approvsl-Deduction Of 2 Hours</option>
        <option name="method_of_leave" value="Medical Certificated Provided">Medical Certificated Provided</option>
        <option name="method_of_leave" value="Leave Salary & Airfair Provided by Company">Leave Salary & Airfair Provided by Company</option>
        <option name="method_of_leave" value="Leave Withou Pay & No AirFair Provided">Leave Withou Pay & No AirFair Provided</option>
        <option name="method_of_leave" value="Leave Salary Without AirFir">Leave Salary Without AirFir</option>
        <option name="method_of_leave" value="Family Emergency Leav">Family Emergency Leave</option>
        <option name="method_of_leave" value="Medical Emergency Leave">Medical Emergency Leave</option>
        <option name="method_of_leave" value="Paid Leave">Paid Leave</option>
        <option name="method_of_leave" value="Paid Leave Without Airfir">Paid Leave Without Airfir</option>
        <option name="method_of_leave" value="Approved Leave without Airfir">Approved Leave without Airfir</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">Upload Leaves</label>
      <input type="hidden" name="old_leaves_data" value="<?php echo @$leaves->leaves_doc ;?>">
      <input type="file" class="form-control" name="leaves_doc[]" multiple id="leaves_doc">
    </div>
  </div>

 <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php   if($leaves){  
  foreach ($leaves as $key => $value) {
?>
<div class="row">
  <div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-2">
          <?php echo $value->leave_start_date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->rejoin_date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->no_leave;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->payment_type;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->type_of_leave;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->method_of_leave;?>
        </div>
        <div class="form-group col-md-2">
          <?php if(@$value->leaves_doc){
             $leaves_doc = explode(",",$value->leaves_doc);
               foreach ($leaves_doc as $key => $pass_value) {
            ?>
            <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>" target="_new"><i class="ion-clipboard"></i></a>
            <?php 
          }
         } ;?>
        </div>
      </div>
    </div>
</div>
<?php }  }?>
         </md-content>
      </md-tab>
			
			<md-tab label="<?php echo lang('assets');?>">
				<md-content class="bg-white">
				<br>
				<form  action="<?php echo base_url('staff/update_tools/'.$staffres['id']);?>" method="post">


  <div class="form-row">
   
    <!-- <div class="form-group col-md-2">
      <label for="inputState"> Date</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div> -->
    <div class="form-group col-md-2">
      <label for="warning_date"> Date</label>
	    <div class="input-group date">
        <input type="text" name="date" class="form-control newdatepicker " id="date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
     
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Item Discription</label>
      <input type="text" class="form-control" name="item_discription" id="item_discription">
    </div>
	  <div class="form-group col-md-2">
      <label for="inputZip">Quantity</label>
      <input type="text" class="form-control" name="quantity" id="quantity">
    </div>
	 <div class="form-group col-md-2">
      <label for="inputCity">Approved By</label>
      <input type="text" class="form-control" name="approved_by" id="approved_by">
    </div>
	 <div class="form-group col-md-2">
      <label for="inputCity">Status</label>
      <select class="form-control" name="status" id="status">
      <option selected>Choose..</option>
      <option name="status" value="Received">Received</option>
      <option name="status" value="Retunered">Retunered</option>
      <option name="status" value="Damaged">Damaged</option>
      <option name="status" value="Misplaced">Misplaced</option>
      <option name="status" value="Replaced">Replaced</option>
    </select>
    </div>
	 <div class="form-group col-md-2">
      <label for="inputCity">Remarks</label>
      <input type="text" class="form-control" name="remarks" id="remarks">
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">Signature</label>
      <input type="text" class="form-control" name="signature" id="signature">
    </div>
  </div>

   <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php   if($tools){  
  foreach ($tools as $key => $value) {
?>
<div class="row">
  <div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-2">
          <?php echo $value->date;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->item_discription;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->quantity;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->approved_by;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->status;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->remarks;?>
        </div>
        <div class="form-group col-md-2">
          <?php echo $value->signature ;?>
        </div>
      </div>
    </div>
</div>
<?php }  }?>
				 </md-content>
			</md-tab>

            <md-tab label="<?php echo lang('notes');?>">
        <md-content class="bg-white">
        <br>
        <form  action="<?php echo base_url('staff/update_notes/'.$staffres['id']);?>" method="post">


  <div class="form-row">
   
    <div class="form-group col-md-10">
      <label for="warning_date"> Notes</label>
      <textarea type="text" class="form-control" name="notes" id="notes"></textarea>
    </div>
    <!-- <div class="form-group col-md-2">
      <label for="inputZip">Added By</label>
      <input type="text" class="form-control" name="added_by" id="added_by">
    </div> -->
  </div>
   <div class="form-group col-md-2">
    <label for="warning_date">&nbsp;</label><br>
  <button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
<?php   if($notes){  
  foreach ($notes as $key => $value) {
?>
<div id="nts1">
<div class="form-row">
<div class="form-group col-md-8 ">
 <textarea class="form-control" name="notes" disabled="disabled"><?php echo $value->notes;?></textarea>
 </div>
 <div class="col-md-4">
 <button type="submit" class="btn btn-primary" onclick="update_button()"><i class="icon ion-edit"></i></button>
 </div>
</div>
</div>
<div id="nts" style="display:none">
    <div class="form-row">
          <div class=" form-group col-md-12 ">
          <form  action="<?php echo base_url('staff/update_notes_id/'.$value->id."/". $staffres['id']);?>" method="post">
            <div class="form-group col-md-8 ">
               <textarea class="form-control" name="notes"><?php echo $value->notes;?></textarea>
               <p>Added by<strong> <?php echo $value->staffname;?></strong> at  <?php echo $value->updated_on ;?></p>
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary" ><i class="icon ion-edit"></i></button>
                <a href="<?php echo base_url();?>staff/delete_notes/<?php echo $value->id ;?>/<?php echo $staffres['id'] ;?>" class="" onclick="return  confirm('are you sure?');"><md-icon class="ng-scope material-icons" role="img" aria-hidden="true"><i class="ion-trash-b text-muted"></i></md-icon></a>
              </div>
            
            </form>
          </div>
      </div>
</div>
<?php }  }?>
         </md-content>
      </md-tab>
			
            <md-tab label="<?php echo lang('invoices');?>">
              <md-content class="bg-white">
                <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                  <md-list-item ng-repeat="invoice in invoices" ng-click="GoInvoice($index)" aria-label="Invoice">
                    <md-icon class="ico-ciuis-invoices"></md-icon>
                    <p><strong ng-bind="invoice.longid"></strong></p>
                    <h4><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
                    <md-divider></md-divider>
                  </md-list-item>
                </md-list>
                <md-content ng-show="!invoices.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
              </md-content>
            </md-tab>
            <md-tab label="<?php echo lang('proposals');?>">
              <md-content class="bg-white">
                <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                  <md-list-item ng-repeat="proposal in proposals" ng-click="GoProposal($index)" aria-label="Proposal">
                    <md-icon class="ico-ciuis-proposals"></md-icon>
                    <p><strong ng-bind="proposal.longid"></strong></p>
                    <h4><strong ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
                    <md-divider></md-divider>
                  </md-list-item>
                </md-list>
                <md-content ng-show="!proposals.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
              </md-content>
            </md-tab>
            <md-tab label="<?php echo lang('tickets');?>">
              <md-content class="bg-white">
                <md-list flex class="md-p-0 sm-p-0 lg-p-0">
                  <md-list-item ng-repeat="ticket in tickets" ng-click="GoTicket($index)" aria-label="Ticket">
                    <md-icon class="ico-ciuis-supports"></md-icon>
                    <p><strong ng-bind="ticket.ticket_number"></strong>&nbsp;<strong ng-bind="ticket.subject"></strong></p>
                    <p><strong ng-bind="ticket.contactname"></strong></p>
                    <h4><strong ng-bind="ticket.priority"></strong></h4>
                    <md-divider></md-divider>
                  </md-list-item>
                </md-list>
                <md-content ng-show="!tickets.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
              </md-content>
            </md-tab>
          </md-tabs>
        </md-content>
      </div>
    <?php } ?>
    </md-content>
    <md-content class="bg-white" ng-cloak>
      <md-subheader ng-if="custom_fields > 0"><?php echo lang('custom_fields'); ?></md-subheader>
      <md-list-item ng-if="custom_fields" ng-repeat="field in custom_fields">
        <md-icon class="{{field.icon}} material-icons"></md-icon>
        <strong flex md-truncate>{{field.name}}</strong>
        <p ng-if="field.type === 'input'" class="text-right" flex md-truncate ng-bind="field.data"></p>
        <p ng-if="field.type === 'textarea'" class="text-right" flex md-truncate ng-bind="field.data"></p>
        <p ng-if="field.type === 'date'" class="text-right" flex md-truncate ng-bind="field.data | date:'dd, MMMM yyyy EEEE'"></p>
        <p ng-if="field.type === 'select'" class="text-right" flex md-truncate ng-bind="custom_fields[$index].selected_opt.name"></p>
        <md-divider ng-if="custom_fields"></md-divider>
      </md-list-item>
    </md-content>
  </div>


  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('update') ?></h2>
        <md-switch ng-model="staff.active" aria-label="Type"><strong class="text-muted"><?php echo lang('active') ?></strong></md-switch>
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('name') ?></label>
          <input required type="text" ng-model="staff.name" class="form-control" id="title"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('email') ?></label>
          <input required type="text" ng-model="staff.email" class="form-control" id="title"/>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('mobile_number') ?></label>
          <input type="text" ng-model="staff.phone" class="form-control" id="title"/>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('staffdepartment'); ?></label>
          <md-select required ng-model="staff.department_id" name="assigned" style="min-width: 200px;">
            <md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('language'); ?></label>
          <md-select required ng-model="staff.language" name="assigned" style="min-width: 200px;">
            <md-option ng-value="language.foldername" ng-repeat="language in languages">{{language.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('roles'); ?></label>
          <md-select required ng-model="staff.assigned_role" name="assigned_role" style="min-width: 200px;">
            <md-option ng-value="assigned_role.role_id" ng-repeat="assigned_role in roles">{{assigned_role.role_name}} <span class="badge">{{assigned_role.role_type}}</span></md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container  class="md-block">
          <label><?php echo lang('staff'). ' '.lang('timezone')?></label>
          <md-select ng-model="staff_timezone">
            <md-optgroup ng-repeat="timezone in timezones" label="{{timezone.group}}">
              <md-option ng-value="zone.value" ng-repeat="zone in timezone.zones">{{zone.value}}</md-option>
            </md-optgroup>
          </md-select>
        </md-input-container>
         <md-input-container class="md-block">
          <label><?php echo lang('joining_date') ?></label>
          
           <md-datepicker required name="joining_date"  ng-model="staff.joining_date" md-open-on-focus style="width: 200px !important;" ></md-datepicker>
        </md-input-container >
          <md-input-container class="md-block">
          <label><?php echo lang('date_of_birth') ?></label>
           <md-datepicker required name="date_of_birth" ng-model="staff.date_of_birth_result" md-open-on-focus ></md-datepicker>
        </md-input-container>
           <md-input-container class="md-block">
          <label><?php echo lang('profession') ?></label>
          <input required type="text" ng-model="staff.profession" class="form-control" id="title"/>
        </md-input-container>
          <md-input-container class="md-block">
          <label><?php echo lang('nominee') ?></label>
          <input type="text" required ng-model="staff.nominee" class="form-control" id="title">
        </md-input-container>
         <md-input-container class="md-block">
          <label><?php echo lang('nationality') ?></label>
          <input type="text" required ng-model="staff.nationality" class="form-control" id="title">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('homeaddress') ?></label>
          <textarea rows="2" ng-model="staff.address" class="form-control"></textarea>
        </md-input-container>
      </md-content>
      <custom-fields-vertical></custom-fields-vertical>
      <md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="UpdateStaff()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
            <span ng-hide="saving == true"><?php echo lang('update');?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>
  <script type="text/ng-template" id="change-avatar-template.html">
    <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="profile_photo" file-model="profile_photo" accept="image/*">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="updateProfilePic()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('save');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  </md-dialog>
  </script> 
  <script type="text/ng-template" id="google-calendar-template.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('google_calendar_settings'); ?></h2>
    <md-content class="bg-white" layout-padding>
    <md-input-container ng-if="staff.google_calendar_enable" class="md-block">
      <label><?php echo lang('google_calendar_id')?></label>
      <input required ng-model="staff.google_calendar_id">
    </md-input-container>
    <md-input-container ng-if="staff.google_calendar_enable" class="md-block">
      <label><?php echo lang('google_calendar_api_key')?></label>
      <input required ng-model="staff.google_calendar_api_key">
    </md-input-container>
    <md-switch class="pull-left" ng-model="staff.google_calendar_enable" aria-label="Enable">
      <strong class="text-muted"><?php echo lang('enable') ?></strong>
    </md-switch>
    </md-content>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="UpdateGoogleCalendar()"><?php echo lang('update') ?>!</md-button>
  </md-dialog-actions>
  </md-dialog>
</script> 
<script type="text/ng-template" id="change-password.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('changepassword'); ?></h2>
    <md-content class="bg-white" layout-padding>
    <md-input-container class="md-block">
      <label><?php echo lang('old').' '.lang('password') ?></label>
      <input type="password" required ng-model="password.old">
    </md-input-container>
    <md-input-container class="md-block">
      <label><?php echo lang('new').' '.lang('password') ?></label>
      <input type="password" required ng-model="password.newpassword">
    </md-input-container>
    <md-input-container class="md-block">
      <label><?php echo lang('confirm').' '.lang('new').' '.lang('password') ?></label>
      <input type="password" required ng-model="password.c_newpassword">
    </md-input-container>
    </md-content>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="UpdatePassword()" class="md-raised md-primary pull-right" ng-disabled="saving == true">
      <span ng-hide="saving == true"><?php echo lang('update');?></span>
      <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  </md-dialog>
</script>
<script type="text/ng-template" id="change-password-admin.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('changepassword'); ?></h2>
    <md-content class="bg-white" layout-padding>
    <md-input-container class="md-block">
      <label><?php echo lang('new').' '.lang('password') ?></label>
      <input type="password" required ng-model="apassword.newpassword">
    </md-input-container>
    <md-input-container class="md-block">
      <label><?php echo lang('confirm').' '.lang('new').' '.lang('password') ?></label>
      <input type="password" required ng-model="apassword.c_newpassword">
    </md-input-container>
    </md-content>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="UpdatePasswordAdmin()" class="md-raised md-primary pull-right" ng-disabled="saving == true">
      <span ng-hide="saving == true"><?php echo lang('update');?></span>
      <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  </md-dialog>
</script>
</div>
<script> 
  var STAFFID = "<?php echo $id;?>"
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_staff = "<?php echo lang('staffattentiondetail')?>";
</script>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/CiuisAngular.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
 
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,changeYear: true,changeMonth: true});
    })
	
	function update_button(){
		
		$('#nts').show();
		$('#nts1').hide();
	}
</script>
<script type="text/javascript">
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($productname); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e"
                            ],
                            data:<?php echo json_encode($sales); ?>,
                        }]
                    },
                    options: {
                           legend: {
                        display: true,
                        position: 'bottom',
 
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
 
 
                }
                });
    </script>