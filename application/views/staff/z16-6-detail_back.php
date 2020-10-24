<?php $appconfig = get_appconfig(); ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap Date-Picker Plugin-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<style>
.newdatepicker { z-index: 3000 !important; }
.user-display-avatar{top:0px;left: 13px;}
.user-display-avatar img{width: 130px;   height: 130px;}
</style>
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
          <div class="user-display-avatar"><img ng-src="<?php echo base_url('uploads/images/'.$staffres['staffavatar'].'')?>"></div>
          <div class="user-display-info">
            <div class="name" ><span class="mdi mdi-account"></span>  <span class="fontBold"><?php echo $staffres['staffname'];?></span></div>
            <div class="nick">Department : <span ng-bind="staff.properties.department"></span></div>
            <div class="nick"><div class="row"><div class="col-md-2 fontBold" >  Id  </div> <div class="col-md-6">: <?php echo $staffres['staff_number'];?></div></div></div>
    
       <?php if($staffres['status'] == 1) { ?>
        <div class="nick"><div class="row"><div class="col-md-2" ><b>Status</b></div> <div class="col-md-6"> : <span><b style="color:green"><?php echo 'Active'; ?></b></span></div></div></div>
      <?php  } else if($staffres['status'] == 2) { ?>
      <div class="nick"><div class="row"><div class="col-md-2" ><b>Status</b> </div> <div class="col-md-6"> : <span><b style="color:red"><?php echo 'In-Active'; ?></b></span></div></div></div>
      <?php } else if($staffres['status'] == 3) { ?>
       <div class="nick"><div class="row"><div class="col-md-2"  ><b>Status</b> </div> <div class="col-md-6"> : <span><b style="color:black"><?php echo 'Cancelled'; ?></b></span></div></div></div>
      <?php } else if($staffres['status'] == 4) { ?>
       <div class="nick"><div class="row"><div class="col-md-2"  ><b>Status </b></div> <div class="col-md-6"> : <span><b style="color:yellow"><?php echo 'Terminated'; ?></b></span></div></div></div>
      <?php } else if($staffres['status'] == 5) { ?>
      <div class="nick"><div class="row"><div class="col-md-2" style="    padding: 0px;
    padding-left: 15px;" ><b>Status</b> </div> <div class="col-md-6"> : <span><b style="color:blue"><?php echo 'Vacation'; ?></b></span></div></div></div>
      <?php } else if($staffres['status'] == 6) { ?>
      <div class="nick"><div class="row"><div class="col-md-2"  ><b>Status</b> </div> <div class="col-md-6"> : <span><b style="color:pink"><?php echo 'Payroll'; ?></b></span></div></div></div>
      <?php } else if($staffres['status'] == 7) { ?>
      <div class="nick"><div class="row"><div class="col-md-2" ><b>Status </b></div> <div class="col-md-6"> : <span><b style="color:orange"><?php echo 'Rejected'; ?></b></span></div></div></div>
      
      <?php } ?>
   <?php  if( ! $this->session->userdata('staffmember')) { ?>
        <div class="nick"><div class="row"><div class="col-md-2"  ><b>Grade </b></div> <div class="col-md-6"> : <div id="stars-green" class="middleStyle" data-rating="<?php echo $staffres['grade']; ?>"><input type="hidden"  name="rating" id="rating" /></div></div></div></div>
        <?php  } ?>
		
		    <div class="nick"><div class="row"><div class="col-md-2 fontBold"  >Number</div> <div class="col-md-6"> : <span><?php echo $staffres['phone'];?></span></div></div></div>
        
     <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $staffres['id']; ?>"  />
          </div>
        </div>
      
        <md-divider></md-divider>
        
        <div class="col-md-4" style="padding: 0px" >
              <md-content class="bg-white">
                <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
                  <md-divider></md-divider>
                  <md-list-item>
                     <div class="col-xs-5 fontBold">Joining Date </div>
                    <div class="col-xs-7"><?php echo $this->Staff_Model->get_format_change($staffres['joining_date']);?><?php //echo $staffres['joining_date'];?></div>
                  </md-list-item>
            <md-divider></md-divider>
             <md-list-item>
      
              <div class="col-xs-5 fontBold"> Profession </div>
              <div class="col-xs-7"> : <?php echo $staffres['profession'];?></div>
            </md-list-item>

            <md-divider></md-divider>
            <!--  <md-list-item>
                    <div class="col-xs-6"> Created :</div>
                    <p ng-bind="staff.createdat"></p>
                  </md-list-item> 
            <md-divider></md-divider> -->

            
          </md-list>
        </md-content>
      </div>
          <div class="col-md-4" style="padding: 0px">

        <md-content class="bg-white">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
            
            <md-divider></md-divider>
 
             <md-list-item>
                    <div class="col-xs-5 fontBold" style="text-align: right;
    padding-right: 0px;"> Gender  </div>
                    <div class="col-xs-7"> : <?php echo $staffres['gender']; ?> </div>
          
                  </md-list-item>
            <md-divider></md-divider>

             <md-list-item>
                    <div class="col-xs-5 fontBold"> Nominee  </div>
                   <div class="col-xs-7"> <?php echo $staffres['nominee'];?></div>
                  </md-list-item>
            <md-divider></md-divider>
            
                 
                 <!--  <md-divider></md-divider> -->
          </md-list>
        </md-content>
      </div>
	  
	     <div class="col-md-4" style="padding: 0px">

        <md-content class="bg-white">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
            
            <md-divider></md-divider>
  <md-list-item>
                    <div class="col-xs-5 fontBold" style="text-align: right;
    padding-right: 0px;"> DOB  </div>
                    <div class="col-xs-8"><?php echo $this->Staff_Model->get_format_change($staffres['birthday']);?><?php //echo $staffres['birthday'];?></div>
                  </md-list-item>

                   <md-divider></md-divider>
				    <md-list-item>
                    <div class="col-xs-5 fontBold">Nationality  </div>
                    <div class="col-xs-7">: <span ng-bind="staff.nationality_name"></span	></div>
                  </md-list-item>
                  <md-divider></md-divider>
                 
                 <!--  <md-divider></md-divider> -->
          </md-list>
        </md-content>
      </div>
      
       <div class="col-md-12" style="padding: 0px">

        <md-content class="bg-white">
          <md-list flex class="md-p-0 sm-p-0 lg-p-0" >
            
            

              <md-list-item>
                    <div class="col-xs-3 fontBold" >
                    Home Country Address  </div>
                    <div class="col-xs-9">:&nbsp; <?php echo $staffres['homeaddress'];?></div>
                 
              </md-list-item>

              <md-divider></md-divider>
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

             <p class="btn btn-primary" type="button"> <a href="<?php echo base_url() ;?>staff/view/<?php echo $id ;?>"class="">View</a></p>

            <?php if (check_privilege('staff', 'edit')) { ?>
              <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak>
                <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>
            <?php } ?>
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
                    <div ng-repeat="inline in staff.properties.chart_data.inline_graph" class="tick"> {{inline.month}} <span class="value value--this" ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span> <span class="value value--prev" ng-bind-html="inline.total | currencyFormat:cur_code:null:true:cur_lct"></span> </div>
                  </div>
                </div>
              </div>
            </div>
          </div> */ ?>
          <div style="width:90%;hieght:90%;text-align:center">
		  <?php $currentmonth= date("F", strtotime('m'));$allmonths = array('January','February','March','April','May','June','July','August','September','October','November','December'); ?>
            <h2 class="page-header" >Attendance Graph </h2>
			<div style="width: 100%;
    text-align: right;
    padding-right: 85px;"><select class="form-control" style="width:50%;"><?php foreach($allmonths as $month){?><option value="<?php print $month;?>" <?php if($currentmonth==$month){print "selected='selected'";}?>><?php print $month?></option><?php }?></select></div>
	
			 <div id="piechart"></div>
           
			<!--
            <canvas  id="chartjs_bar"></canvas>-->
        </div>   
		<?php 
		$year = date('Y');
		$productname = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'); 
		foreach($productname as $month){
		$sales[] = $this->Staff_Model->get_present_count($year,$month,$id);
		
		    $abs[] = $this->Staff_Model->get_absent_count($year,$month,$id);
		}
			
		?>
	
		
        </md-content>
      </div>
      <?php if (!$this->session->userdata('other') )  { ?>
      <div class="col-md-12 staff-tabs-content"  ng-cloak>
        <md-divider></md-divider>
        <md-content class="bg-white">
          <md-tabs md-selected="selectedIndex" md-dynamic-height md-border-bottom>
            <?php if ($accessTab['tools']== true) { ?>
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
                    <?php if (check_privilege('workplan', 'edit')) { ?>
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
            <?php } ?>
	<?php if ($accessTab['userdocuments']== true){	?>
        <md-tab label="<?php echo lang('documents');?>">
        <md-content class="bg-white">
        <br>
        <div>
        <form  action="<?php echo base_url('staff/update_documents/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo @$documents->id; ?>">
  <div class="form-row col-md-12 row">
   
    <div class="form-group col-md-3">
      <label for="inputState">Passport</label>
      <input type="text" class="form-control" name="passport"id="inputZip" value="<?php echo @$documents->passport; ?>">
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
    <div class="input-group date">
        <input type="text" name="passport_expiry_date" class="form-control newdatepicker" id="passport_expiry_date" value="<?php  echo @$documents->passport_expiry_date ;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="passport_remind" id="inputZip" placeholder="Remind Me" value="<?php echo @$documents->passport_remind ;?>">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_passport_data" value="<?php  echo @$documents->passport_doc ;?>">
      <input type="file" class="form-control-file" name="passport_doc[]" multiple id="passport_doc">
    </div>
    <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      
      <?php  if(@$documents->passport_doc) { 
          $psp = str_replace(',','',@$documents->passport_doc);
        
        $passport_doc = explode(",", $documents->passport_doc); 
        $pass_count = 0;
          foreach ($passport_doc as $key => $pass_value) {
              if($pass_value != ''){
             $pass_count ++;
              }
          }
       ?>
        
          <span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-4"><?php echo $pass_count; ?></a>
          <div id="dialog-4" style="display:none">
          <?php $ext = ''; foreach ($passport_doc as $key => $pass_value) {
             
              if($pass_value != '') { 
              
              
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); ?>
           <div class="row">
               <?php if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){?>

			 <a href="#about" onClick="show_post_pdf('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $pass_value; ?>" id="editidpdf<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
				   <?php }else{?>
				    <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
				   <?php }?>
			   
			<?php  } else{ ?>
	        <a href="#about" onClick="show_post('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#editModal" data-image="<?php echo $pass_value; ?>" id="editid<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
            <?php   } ?>
                <li><?php echo $pass_value;?></li>
		 <?php if (check_privilege('staff', 'delete')) { ?>
              <a  class="removeclass1 remove_class " style="margin-top:20px" href="#" onclick="select_image_name('<?php echo $pass_value; ?>','Passport',<?php echo @$documents->id; ?>);"><span class="glyphicon glyphicon-remove"></span></a>
            <?php } ?>
            
               </div><?php }
     
        
          } ?>
          </div>
      <?php    } ;?>
         
    </div>
  </div>
  
 <div class="form-row col-md-12 row">
   
    <div class="form-group col-md-3">
      <label for="inputState">Emirates ID</label>
      <input type="text" class="form-control" name="emirates_id" id="inputZip" value="<?php  echo @$documents->emirates_id ;?>">
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
      <div class="input-group date">
        <input type="text" name="emirates_expiry_date" class="form-control newdatepicker" id="emirates_expiry_date" value="<?php  echo @$documents->emirates_expiry_date ;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>

    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="emirates_remind" id="inputZip" placeholder="Remind Me" value="<?php  echo @$documents->emirates_remind ;?>">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_emirates_data" value="<?php echo @$documents->emirates_doc ;?>">
      <input type="file" class="form-control-file"  name="emirates_doc[]" multiple id="emirates_doc">
    </div>

    <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$documents->emirates_doc) { 
        $emirates_doc = explode(",", $documents->emirates_doc);
        $emirates_count = 0;
        foreach ($emirates_doc as $key => $pass_value) {
            
          if($pass_value != ''){
             $emirates_count ++;
              }
            
          } ?>
           <span class="glyphicon glyphicon-file fontGreen"></span> <a href="#" id = "opener-5"><?php echo $emirates_count; ?></a>
          <div id = "dialog-5" style="display:none">
         <?php  $ext = ''; foreach ($emirates_doc as $key => $pass_value) {
             if($pass_value != '') {  
                 $ext =  substr($pass_value, strrpos($pass_value, '.' )+1);
             
             ?>
             <div class="row">
                  <?php if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {if($ext=='pdf'){?>
			   <a href="#about" onClick="show_post_pdf('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $pass_value; ?>" id="editidpdf<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
			   <?php }else{  ?>
			
			    <a class="btn btn-success styleRemove" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard colorDocument1"></i></a>
			   <?php }?>
			<?php  } else{ ?>
          <a href="#about" onClick="show_post('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#editModal" data-image="<?php echo $pass_value; ?>" id="editid<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
        <?php   } ?>
         <li><?php echo $pass_value; ?></li>
         <?php if (check_privilege('staff', 'delete')) { ?>
          <a  class="removeclass1 remove_class " style="margin-top:20px" href="#" onclick="select_image_name('<?php echo $pass_value; ?>','Emirates',<?php echo @$documents->id; ?>);"><span class="glyphicon glyphicon-remove"></span></a>
          
          <?php } ?>
          </div>  <?php 
          }
         } ;?>
    </div>
<?php } ?>
  </div>
  
   <div class="form-row col-md-12 row">
   
    <div class="form-group col-md-3">
      <label for="inputState">Labour Card</label>
      <input type="text" class="form-control" name="labour_card" id="inputZip"value="<?php  echo @$documents->labour_card ;?>" >
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
      <div class="input-group date">
        <input type="text" name="labour_expiry_date" class="form-control newdatepicker" id="labour_expiry_date" value="<?php  echo @$documents->labour_expiry_date ;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>

    
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control"  name="labour_remind" id="inputZip" placeholder="Remind Me" value="<?php  echo @$documents->labour_remind ;?>">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" value="old_labour_data" value="<?php echo @$documents->labour_doc ;?>">
      <input type="file" class="form-control-file" name="labour_doc[]" multiple id="labour_doc">
    </div>

    <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$documents->labour_doc) { 
        $labour_doc = explode(",", $documents->labour_doc);
        $labour_count = 0;
          foreach ($labour_doc as $key => $pass_value) {
              if($pass_value != ''){
             $labour_count ++;
              }
          } ?>
          <span class="glyphicon glyphicon-file fontGreen"></span> <a href="#" id = "opener-6"><?php echo $labour_count; ?></a>
          <div id = "dialog-6" style="display:none">
          <?php $ext = '';
          foreach ($labour_doc as $key => $pass_value) {
            
            if($pass_value != '') { 
            
            
            $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); ?>
            <div class="row">
                  <?php if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {   if($ext=='pdf'){?>

			 <a href="#about" onClick="show_post_pdf('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $pass_value; ?>" id="editidpdf<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
				   <?php }else{?>
				    <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
				   <?php }?>
			   
			  
			<?php  } else{ ?>
            <a href="#about" onClick="show_post('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#editModal" data-image="<?php echo $pass_value; ?>" id="editid<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
         <?php   } ?>
         
         <li><?php echo $pass_value;?></li>
         <?php if (check_privilege('staff', 'delete')) { ?>
           <a  class="removeclass1 remove_class " style="margin-top:20px" href="#" onclick="select_image_name('<?php echo $pass_value; ?>','Labour',<?php echo @$documents->id; ?>);"><span class="glyphicon glyphicon-remove"></span></a>
       
       <?php } ?>
          </div>  <?php  }
          } ?>
          </div>
      <?php   } ;?>
    </div>
    


  </div>
  
    <div class="form-row col-md-12 row">
   
    <div class="form-group col-md-3">
      <label for="inputState">ATM Card</label>
      <input type="text" class="form-control" name="atm_card" id="inputZip" value="<?php  echo @$documents->atm_card ;?>">
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
    <div class="input-group date">
        <input type="text" name="atm_expiry_date" class="form-control newdatepicker" id="atm_expiry_date" value="<?php  echo @$documents->atm_expiry_date ;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
    
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="atm_remind" id="inputZip" placeholder="Remind Me" value="<?php  echo @$documents->atm_remind ;?>">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_atm_data" value="<?php echo @$documents->atm_doc ;?>">
      <input type="file" class="form-control-file" name="atm_doc[]" multiple id="atm_doc">
    </div>

     <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$documents->atm_doc) { 
        $atm_doc = explode(",", $documents->atm_doc);
        $atm_count = 0;
        foreach ($atm_doc as $key => $pass_value) {
              if($pass_value != ''){
             $atm_count ++;
              }
          } ?>
           <span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-7"><?php echo $atm_count; ?></a>
          <div id = "dialog-7" style="display:none">
          <?php $ext = '';
          foreach ($atm_doc as $key => $pass_value) {
            if($pass_value != '') { 
            
            $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); ?>
            <div class="row">
                 <?php if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {  if($ext=='pdf'){?>

			 <a href="#about" onClick="show_post_pdf('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $pass_value; ?>" id="editidpdf<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
				   <?php }else{?>
				    <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
				   <?php }?>
			    
			  
			<?php  } else { ?>
           <a href="#about" onClick="show_post('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#editModal" data-image="<?php echo $pass_value; ?>" id="editid<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
        <?php } ?>
        <li><?php echo $pass_value;?></li>
        <?php if (check_privilege('staff', 'delete')) { ?>
         <a  class="removeclass1 remove_class " style="margin-top:20px" href="#" onclick="select_image_name('<?php echo $pass_value; ?>','Atm',<?php echo @$documents->id; ?>);"><span class="glyphicon glyphicon-remove"></span></a>
         
         <?php } ?>
          </div>  <?php 
          }
         } ;?>
         </div>
         <?php } ?>
    </div>


  </div>
   <div class="form-row col-md-12 row">
  <?php if(count($otherdoc) == 0){ ?>
   
   <input type="hidden" name="count" id="count" value="1" class="count">
   <input type="hidden" name="other[otd_id][]" id="otd_id" value="" />
    <div class="form-group col-md-3">
      <label for="inputState">Other Docs Name</label>
      <input type="text" class="form-control" name="other[others][]" id="inputZip" value="" label="others0">
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
      <div class="input-group date">
        <input type="text" name="other[other_expiry_date][]" class="form-control newdatepicker" id="other_expiry_date" value="" label="others_expiry0"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="other[others_remind][]" id="inputZip" placeholder="Remind Me"  label="others_remind0" value="">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="other[old_others_data][]" value="">
      <input type="file" class="form-control-file" name="others_doc0[]" multiple id="others_doc" label="others_docs0">
    </div>

    <?php /* <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$documents->others_doc) { 
        $others_doc = explode(",", $documents->others_doc);
          foreach ($others_doc as $key => $pass_value) {
            ?>
          <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
            <?php 
          }
         } ;?>
    </div> */ ?>
    
    <?php } else {  ?>
    <input type="hidden" name="count" id="count" value="<?php echo count($otherdoc); ?>" class="count">
   <?php  $i = 100; foreach($otherdoc as $k =>  $docu) { ?>
    
     <div class="form-row">
         <input type="hidden" name="other[otd_id][]" id="otd_id" value="<?php echo $docu['id']; ?>" />
         
   
    <div class="form-group col-md-3">
      <label for="inputState">Other Docs</label>
      <input type="text" class="form-control " name="other[others][]" id="inputZip" value="<?php echo $docu['others']; ?>" label="others<?php echo $k; ?>">
    </div>
    <div class="form-group col-md-3">
        <label for="inputState">Expiry Date</label>
      <div class="input-group date">
        <input type="text" name="other[other_expiry_date][]" class="form-control newdatepicker1" id="other_expiry_date<?php echo $k;?>" value="<?php echo $docu['other_expiry_date']; ?>" label="others_expiry<?php echo $k;?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> 
        </div>
      
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Remind Me</label>
      <input type="text" class="form-control" name="other[others_remind][]" id="inputZip" placeholder="Remind Me"  label="others_remind<?php echo $k;?>" value="<?php echo $docu['others_remind']; ?>">
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="other[old_others_data][]" value="<?php echo $docu['others_doc']; ?>">
      <input type="file" class="form-control" name="others_doc<?php echo $k;?>[]" multiple id="others_doc" label="others_docs<?php echo $k;?>">
    </div>

      <div class="form-group col-md-2">
      <label for="inputCity">&nbsp;</label><br>
      <?php  if(@$docu['others_doc']) { 
        $others_doc = explode(",", $docu['others_doc']);
        $other_count = 0;
          foreach ($others_doc as $key => $pass_value) {
               if($pass_value != ''){
             $other_count ++;
              }
          }
            ?>
            
          <span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-<?php echo $i; ?>" onclick="select_number(<?php echo $i; ?>)"><?php echo $other_count; ?></a>
         <div id = "dialog-<?php echo $i;?>" style="display:none">
            <?php 
             
             $ext = '';
             foreach ($others_doc as $key => $pass_value) {
          
            if($pass_value != '') {  
            
            $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); ?>
            <div class="row">
                 <?php if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {   if($ext=='pdf'){?>

			 <a href="#about" onClick="show_post_pdf('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $pass_value; ?>" id="editidpdf<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
				   <?php }else{?>
				    <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
				   <?php }?>
			   
			  
			<?php  } else{ ?>
           <a href="#about" onClick="show_post('<?php echo $pass_value; ?>')" data-toggle="modal" data-target="#editModal" data-image="<?php echo $pass_value; ?>" id="editid<?php echo $pass_value; ?>"><span class="glyphicon glyphicon-file colorDocument"></span></a>
       <?php } ?>
       
        <li><?php echo $pass_value;?></li>
        <?php if (check_privilege('staff', 'delete')) { ?>
         <a  class="removeclass1 remove_class " style="margin-top:20px" href="#" onclick="select_image_name('<?php echo $pass_value; ?>','Other',<?php echo @$documents->id; ?>);"><span class="glyphicon glyphicon-remove"></span></a>
          
          <?php } ?>
          </div>  <?php 
          }
         } ?>
         </div>
         <?php } ?>
    </div> 
    
    </div>
    <?php $i++; }  } ?>
   
    <div class="form-row col-md-12 row">
    <div  id="fields3">
										<div class="padding-top"></div>
									</div>
									</div>
									<div class="col-md-12">
									 <a id="AddButton2" class="btn btn-success" style="margin-top:24px; padding: 7px 19px!important;float:right;" >+</a></div> 
									 <div class="col-md-12">
								<button type="submit" class="btn btn-warning" >Save</button></div>
  </div>
</form>
</div>
         </md-content>
      </md-tab> 

	<?php } ?>
<?php if($accessTab['salaryinfo']== true) { 
if(check_privilege('staff', 'create')) { ?>
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
					  <input type="text" class="form-control sal" id="salary" placeholder="Enter basic salary" name="salary" value="<?php   echo  $staffres['basic_salary'];  ?>" onchange="basic_salary(this.value);" required="">
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-sm-4" for="pwd">Allowance:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control sal" id="allowance" placeholder="Enter Other Allowance" name="allowance" value="<?php echo $staffres['allowance']; ?>"  onchange="select_allowance(this.value);" required="">
					</div>
				  </div>
				  <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Vehicle/ Transport Allowance:</label>
					<div class="col-sm-8">
            <div class="row">
            <div class="col-md-8">
			<select   name="transport_allowance" class="form-control" id="transport_allowance" onchange="select_vta(this.value)";>
						
						<option value="Provide By Company" <?php if($staffres['transport_allowance']=="Provide By Company"){ echo "selected='selected'"; } ?>>Provide By Company</option>
						<option value="Not Provide By Company" <?php if($staffres['transport_allowance']=="Not Provide By Company"){ echo "selected='selected'";} ?>>Not Provide By Company</option>
					  </select>
					</div>
			
          <div class="col-md-4" id="vamt">
            <input type="text" class="form-control sal" id="vehicle_amound" placeholder="Enter Amound" name="vehicle_amound" value="<?php  echo $staffres['vehicle_amound']; ?>" onchange="vehicle_amt(this.value);"/>
          </div>
          
        </div>
      </div>
				  </div>
				   <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Accomodation Allowance:</label>
					<div class="col-sm-8">
            <div class="row">
            <div class="col-md-8">
              <select name="accomodation_allowance" class="form-control" id="accomodation_allowance" onchange="select_aal(this.value)";>
            
            <option value="Provide By Company" <?php if($staffres['accomodation_allowance']=="Provide By Company"){print "selected='selected'";} ?>>Provide By Company</option>
            <option value="Not Provide By Company" <?php if($staffres['accomodation_allowance']=="Not Provide By Company"){print "selected='selected'";} ?>>Not Provide By Company</option>
            </select>
					</div>
				
          <div class="col-md-4" id="aam">
            <input type="text" class="form-control sal" id="accom_amound" placeholder="Enter Amound" name="accom_amound" value="<?php  echo $staffres['accom_amound']; ?>" onchange="accom_amt(this.value); ">
          </div>
          
        </div>
        </div>
				  </div>
				   <div class="form-group">
						<label class="control-label col-sm-4" for="pwd">Over Time/Hour (AED):</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="over_time" placeholder="Enter Other Allowance" name="over_time" value="<?php print $staffres['over_time'];?>" required=""> 
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
			<?php } } ?>
			<?php if($accessTab['appraisal']== true) { ?>
      <md-tab label="<?php echo lang('appraisal');?>">
        <md-content class="bg-white">
        <br>
		<?php if($this->session->flashdata('apprmessage')!=''){?>
				<div id="infoMessage" class="alert alert-danger col-md-12"><?php echo $this->session->flashdata('apprmessage');?></div>
				<?php }?>
				<div class="col-md-12">
        <form  action="<?php echo base_url('staff/update_appraisal_details/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">
  <div class="form-row">
   
    <div class="form-group col-md-3">
      <label for="inputState">Date</label>
        <div class="input-group date">
        <input type="text" name="increment_date" class="form-control newdatepicker" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div> 
      <!-- <md-datepicker required name="increment_date" id="increment_date" ng-model="staff.date_of_increment" md-open-on-focus ></md-datepicker>  -->

      
    </div>
    <div class="form-group col-md-2">
	<div class="col-md-12">
      <label for="increment_amount"> Amount</label>
	  </div>
	  <div class="col-md-4">
	  <select name="type_of_amount"  class="form-control" style="width: 56px;"><option value="plus" selected>+</option><option value="minus">-</option></select></div>
	  <div class="col-md-8">
      <input type="text" class="form-control" name="increment_amount" id="increment_amount" required="">
	  </div>
    </div>
    <div class="form-group col-md-2">
      <label for="increment_type"> Type</label>
      <select class="form-control" name="increment_type" id="increment_type" required="">
        <option value="">Choose...</option>
        <option name="increment_type" value="Fixed Portion">Fixed Portion</option>
        <option name="increment_type" value="Allowance">Allowance</option>
        <option name="increment_type" value="Transpotation Al1owance">Vehicle / Transpotation Aloowance</option>
        <option name="increment_type" value="Accomdation Al1owance">Accomdation  Allowance</option>
         
        
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="increment_reason">Reason</label>
      <select class="form-control" name="increment_reason" id="increment_reason" >
      
        <option name="increment_reason" value="Best Performance">Best Performance</option>
        <option name="increment_reason" value="Hardworking Person">Hardworking Person</option>
        <option name="increment_reason" value="Good Leader">Good Leader</option>
        <option name="increment_reason" value="Team Management Performance">Team Management Performance</option>
        <option name="increment_reason" value="Employee Benefit">Employee Benefit</option>
        <option name="increment_reason" value="Poor Performance">Poor Performance</option>
        <option name="increment_reason" value="Employee Negotiation">Employee Negotiation</option>
      </select>
    </div>
   <!--  <div class="form-group col-md-2">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_appraisal_data" value="<?php //echo @$appraisal->appraisal_doc ;?>">
      <input type="file" class="form-control" name="appraisal_doc[]" multiple id="appraisal_doc">
    </div> -->
    <div class="form-group col-md-2">
      <label for="inputCity">Remarks</label>
      
      <input type="text" class="form-control" name="remarks"  id="remarks" >
    </div> 
   <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>  
</form>
       
    </div>
<hr/>
<div class="col-md-12">

  
<?php   if($appraisal){ ?>
<h2>Appraisal Lists</h2>
<table class="table table-bordered table-stripped listdata" >
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Amount</th>
      <th scope="col">Type</th>
      <th scope="col">Reason</th>
	   <th scope="col">Remarks</th>
	   <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php  
  foreach ($appraisal as $key => $value) {
?>

  <tr>
      <th ><?php echo $this->Staff_Model->get_format_change($value->increment_date);?></th>
      <td> <?php if($value->type_of_amount=='minus'){print "-";}else{print "+";}?><?php echo $value->increment_amount;?></td>
      <td> <?php echo $value->increment_type;?></td>
      <td> <?php echo $value->increment_reason;?></td>
	  <td> <?php echo $value->remarks;?></td>
	   <td>  <a  class="removeclass1 btn btn-danger remove_class "   onclick="delete_appraisal_record(<?php echo $value->id; ?>)"><i class="glyphicon glyphicon-trash"></i></a></td>
    </tr>
	


<?php } ?>

  </tbody>
</table>
<?php  }?>
</div>

         </md-content>
      </md-tab>
      <?php } ?>
      <?php if($accessTab['warnings']== true) { ?>
      
        <md-tab label="<?php echo lang('warning');?>">
        <md-content class="bg-white">
        <br>
		<div class="col-md-12">
        <form  action="<?php echo base_url('staff/update_warning/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">


  <div class="form-row">
   
    <div class="form-group " style="width:9%;float:left;margin-right:10px;">
      <label for="warning_date">Warning Date</label>
    <div class="input-group date">
        <input type="text" name="warning_date" class="form-control newdatepicker " id="warning_date" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group " style="width:9%;float:left;margin-right:10px;">
      <label for="date_of_incident">Date Of Incident</label>
     <div class="input-group date">
        <input type="text" name="date_of_incident" class="form-control newdatepicker " id="date_of_incident" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <!-- <div class="form-group col-md-2">
      <label for="warning_type">Warning Type</label>
      <input type="text" class="form-control" name="warning_type" id="warning_type">
    </div> -->
    <div class="form-group col-md-2">
      <label for="inputState"> Warning Type</label>
      <select id="inputState"  name="warning_type" class="form-control" >
        
        <option  name="warning_type" value="Warning" >Warning</option>
        <option name="warning_type" value="Warning 1">Warning 1</option>
        <option name="warning_type" value="Warning 2">Warning 2</option>
        <option name="warning_type" value="Warning 3">Warning 3</option>
        <option name="warning_type" value="Suspention">Suspention</option>
        <option name="warning_type" value="Termination">Termination</option>
         <option  name="warning_type" value="Verbal Warning" >Verbal Warning</option>
      </select>
    </div> 
    <div class="form-group col-md-2">
      <label for="inputState"> Type Of violation</label>
      <select id="inputState"  name="type_of_violation" class="form-control" >
       
        <option  name="type_of_violation" value="Poor Perfomanc">Poor Perfomance</option>
        <option name="type_of_violation" value="Misconduct on company premies&properties">Misconduct on company premies&properties</option>
        <option name="type_of_violation" value="Late Attendence">Late Attendence</option>
          <option name="type_of_violation" value="Leave Without Approval">Leave Without Approval</option>
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
		 <option name="type_of_violation" value="Alcoholic Consumption">Alcoholic Consumption.</option>
        <option name="type_of_violation" value="Other">Other</option>
        <!-- <option name="type_of_violation" value="Goosping">Goosping</option> -->
      </select>
    </div> 
    <div class="form-group col-md-1">
      <label for="inputState"> Action</label>
      <select id="inputState"  name="action" class="form-control" required="">
       
        <option  name="action" value="None" >None</option>
        <option  name="action" value="Deduction Of Workhours 3 days" >Deduction Of Workhours 3 days</option>
        <option name="action" value="Suspention Of Over Time">Suspention Of Over Time</option>
        <option name="action" value="Suspention">Suspention</option>
        <option name="action" value="Termination">Termination </option>
      </select>
    </div> 
   <div class="form-group col-md-2">
      <label for="employee_signature">Remarks</label>
      <input type="text" class="form-control" name="employee_signature" id="employee_signature" >
    </div>
  </div>
  <div class="form-group" style="    width: 13%;
    float: left;">
      <label for="inputCity">Signature</label>
      <input type="hidden" name="old_warning_data" value="<?php echo @$warning->warning_doc ;?>">
      <input type="file" class="form-control-file" name="warning_doc[]" multiple id="warning_doc[]" >
    </div>
<div class="form-group col-md-1 width6">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

</div>
<hr/>

<?php   if($warning){ ?>
<h2>Warnings Lists</h2>
<table id="example" class="table table-striped table-bordered listdata" style="width:100%">
        <thead>
            <tr>
                <th>Warning Date</th>
                <th>Date Of Incident</th>
                <th>Warning Type</th>
                <th>Type Of violation</th>
                <th>Action</th>
                <th>Remarks</th>
				 <th>Signature</th>
				  <th>Action</th>
            </tr>
        </thead>
        <tbody><?php  
  foreach ($warning as $key => $value) {
?>
<tr>
                <td><?php echo $this->Staff_Model->get_format_change($value->warning_date);?></td>
                <td><?php echo $this->Staff_Model->get_format_change($value->date_of_incident);?><?php //echo $value->date_of_incident;?></td>
                <td> <?php echo $value->warning_type;?></td>
                <td> <?php echo $value->type_of_violation;?></td>
                <td><?php echo $value->action;?></td>
				 <td><?php echo $value->employee_signature;?></td>
                <td>   <?php  if(@$value->warning_doc) { 
        $warning_doc = explode(",", $value->warning_doc);
          foreach ($warning_doc as $key => $pass_value) {
            ?>
          <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>"  target="_new"><i class="ion-clipboard "></i></a>
            <?php 
          }
         } ;?></td>
		 <td><a  class="removeclass1 btn btn-danger remove_class "  onclick="delete_warning_record(<?php echo $value->id; ?>)"><i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>

<?php }  ?>
 </tbody>
        
    </table>
<?php }?>
         </md-content>
      </md-tab>
      <?php } ?>
<?php if($accessTab['leaves']== true) { ?>
      <md-tab label="<?php echo lang('leaves');?>">
        <md-content class="bg-white">
        <br>
		<div class="col-md-12">
        <form  action="<?php echo base_url('staff/update_leaves/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">


  <div class="form-row">
   
    <div class="form-group " style="width:9%;float:left;margin-right:10px;">
      <label for="warning_date">Leave Start Date</label>
    <div class="input-group date">
        <input type="text" name="leave_start_date" class="form-control newdatepicker " id="leave_start_date" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
    </div>
    <div class="form-group " style="width:9%;float:left;margin-right:10px;">
      <label for="date_of_incident">Rejoin Date</label>
     <div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control newdatepicker " id="rejoin_date" onchange="select_rejoin();" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
      
     
    </div>
    <div class="form-group col-md-1">
      <label for="warning_type">No Of Day's</label>
      <input type="text" class="form-control" name="no_leave" id="no_leave" required="">
    </div>
   <div class="form-group col-md-1">
      <label for="type_of_violation">Payment Type</label>
      <select  class="form-control" name="payment_type" id="payment_type" >
       
        <option name="payment_type" value="Paid">Paid</option>
        <option name="payment_type" value="Unpaid">Unpaid</option>
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="action">Type Of Leave</label>
      <select  class="form-control" name="type_of_leave" id="type_of_leave" >
       
        <option name="type_of_leave" value="Un Approved Leave">Un Approved Leave</option>
        <option name="type_of_leave" value="Sick Leave">Sick Leave</option>
        <option name="type_of_leave" value="Annual Leave">Annual Leave</option>
        <option name="type_of_leave" value="Emergency Leave">Emergency Leave</option>
        <option name="type_of_leave" value="Vacation">Vacation</option>
        <option name="type_of_leave" value="Casual Leave">Casual Leave</option>
      </select>
    </div>
   <div class="form-group col-md-2">
      <label for="employee_signature">Method Of Leave</label>
      <select class="form-control" name="method_of_leave" id="method_of_leave" required="">
       
        <option name="method_of_leave" value="Leave without Approvsl-Deduction Of 16 Hours">Leave without Approvals-Deduction Of 16 Hours</option>
        <option name="method_of_leave" value="Medical Certificated Provided">Medical Certificated Provided</option>
        <option name="method_of_leave" value="Leave Salary & Airfair Provided by Company">Leave Salary & Airfair Provided by Company</option>
        <option name="method_of_leave" value="Emergency Leave">Emergency Leave</option>
        <option name="method_of_leave" value="Leave without a reason">Leave without a reason</option>
         <option name="method_of_leave" value="Approved Leave Without Airfair">Approved Leave Without Airfair</option>
      </select>
    </div>
    <div class="form-group col-md-1">
      <label for="remarks">Remarks</label>
     <input type="text" name="remarks" id="remarks" class="form-control" >
    </div>
     <div class="form-group col-md-1">
      <label for="inputCity">Upload Docs</label>
      <input type="hidden" name="old_leaves_data" value="<?php echo @$leaves->leaves_doc ;?>">
      <input type="file" class="form-control-file" name="leaves_doc[]" multiple id="leaves_doc" >
    </div>
  </div>

 <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
</form>
 </div>
 <hr/>
<?php   if($leaves){  ?>
<h2>Leaves Lists</h2>
<table id="example" class="table table-striped table-bordered listdata" style="width:100%">
 <thead>
            <tr>
                <th>Leave Start Date</th>
                <th>Rejoin Date</th>
                <th>No Of Day's</th>
                <th>Payment Type</th>
                <th>Type Of Leave</th>
                <th>Method Of Leave</th>
				<th>Remarks</th>
				<th>Documents</th>
				<th>Action</th>
            </tr>
        </thead>
        <tbody>
<?php
  foreach ($leaves as $key => $value) {
?>
<tr>
                <td> <?php echo $this->Staff_Model->get_format_change($value->leave_start_date);?></td>
                <td><?php echo $this->Staff_Model->get_format_change($value->rejoin_date);?></td>
                <td> <?php echo $value->no_leave;?></td>
                <td><?php echo $value->payment_type;?></td>
                <td>  <?php echo $value->type_of_leave;?></td>
                <td><?php echo $value->method_of_leave;?></td>
				<td><?php echo $value->remarks;?></td>
				<td style="padding:8px;"><div class="col-md-12"> <?php if(@$value->leaves_doc){
             $leaves_doc = explode(",",$value->leaves_doc);
               foreach ($leaves_doc as $key => $pass_value) {
            ?>
			<div class="col-md-8 row" style="margin-bottom:4px;margin-top:2px;margin-right:2px;">
            <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>" target="_new"><i class="ion-clipboard"></i></a><a href="<?php echo base_url('staff/staff_documents/'.$pass_value.'/'.$value->id.'/'.$value->staff_id);?>"><i class="glyphicon glyphicon-trash"></i></a></div>
            <?php 
          }
         } ?></div></td>
		 <td style="width: 10%;"><a  class=" btn btn-info  "  data-toggle="modal" data-target="#leaves_modal"  onclick="edit_leaves(<?php echo $value->id; ?>)" style="margin-right:10px;"><i class="glyphicon glyphicon-edit"></i></a> <a  class="removeclass1 btn btn-danger remove_class "  onclick="delete_leave_record(<?php echo $value->id; ?>)"><i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>
			

<?php }  ?>
</tbody>
 </table>
<?php }?>

         </md-content>
      </md-tab>
      <?php } ?>
      <?php if($accessTab['tools']== true) { ?>
      <md-tab label="<?php echo lang('assets');?>">
        <md-content class="bg-white">
        <br>
		<div class="col-md-12 row">
        <form  action="<?php echo base_url('staff/update_tools/'.$staffres['id']);?>" method="post" enctype="multipart/form-data">


  <div class="form-row">
   
    <!-- <div class="form-group col-md-2">
      <label for="inputState"> Date</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div> -->
    <div class="form-group " style="width: 9%;
    float: left;">
      <label for="warning_date"> Date</label>
      <div class="input-group date">
        <input type="text" name="date" class="form-control newdatepicker " id="date" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div>
     
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Item Description</label>
      <input type="text" class="form-control" name="item_discription" id="item_discription" required="">
    </div>
    <div class="form-group col-md-1">
      <label for="inputZip">Quantity</label>
      <input type="text" class="form-control" name="quantity" id="quantity" required="">
    </div>
   <div class="form-group col-md-1">
      <label for="inputCity">Approved By</label>
      <input type="text" class="form-control" name="approved_by" id="approved_by" required="">
    </div>
   <div class="form-group col-md-1">
      <label for="inputCity">Status</label>
      <select class="form-control" name="status" id="status" required="">
     
      <option name="status" value="Received">Received</option>
      <option name="status" value="Retunered">Retunered</option>
      <option name="status" value="Damaged">Damaged</option>
      <option name="status" value="Misplaced">Misplaced</option>
      <option name="status" value="Replaced">Replaced</option>
    </select>
    </div>
   <div class="form-group col-md-2">
      <label for="inputCity">Remarks</label>
      <input type="text" class="form-control" name="remarks" id="remarks" >
    </div>
    <!-- <div class="form-group col-md-2">
      <label for="inputCity">Signature</label>
      <input type="text" class="form-control" name="signature" id="signature" required="">
    </div>  -->
    <div class="form-group col-md-2">
      <label for="inputCity">Signature</label>
      <input type="hidden" name="old_tools_data" value="<?php echo @$tools->tools_doc ;?>">
      <input type="file" class="form-control-file" name="tools_doc[]" multiple id="tools_doc">
    </div>
  </div>

   <div class="form-group col-md-1">
    <label for="warning_date">&nbsp;</label><br>
     <button type="submit" class="btn btn-primary btn-lg">Save</button>
    </div>
</form>
</div>
<hr/>
<?php   if($tools){  ?>
<h2>Tools & Assets Lists</h2>
<table id="example" class="table table-striped table-bordered listdata" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>tem Description</th>
                <th>Quantity</th>
                <th>Approved By</th>
                <th>Status</th>
                <th>Remarks</th>
				<th>Signature</th>
				<th>Action</th>
            </tr>
        </thead>
        <tbody>
<?php 
  foreach ($tools as $key => $value) {
?>
 <tr>
                <td><?php echo $this->Staff_Model->get_format_change($value->date);?> </td>
                <td><?php echo $value->item_discription;?></td>
                <td>  <?php echo $value->quantity;?></td>
                <td> <?php echo $value->approved_by;?></td>
                <td> <?php echo $value->status;?></td>
               
				<td>  <?php echo $value->remarks;?></td>
				<td>  <?php if(@$value->tools_doc){
             $tools_doc = explode(",",$value->tools_doc);
               foreach ($tools_doc as $key => $pass_value) {
            ?>
            <a class="btn btn-success" href="<?php echo base_url('uploads/staff_documents/'.$pass_value);?>" target="_new"><i class="ion-clipboard"></i></a>
            <?php 
          }
         } ;?></td>
		 <td> <a  class="removeclass1 btn btn-danger remove_class " style="margin-top:20px" onclick="delete_tool_record(<?php echo $value->id; ?>)"><i class="glyphicon glyphicon-th"></i></a></td>
            </tr>

<?php } ?>
 </tbody>
 </table>
<?php  }?>
         </md-content>
      </md-tab>
      <?php } ?>
<?php if($accessTab['notes']== true) { ?>
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
  <a href="<?php echo base_url();?>staff/delete_notes/<?php echo $value->id ;?>/<?php echo $staffres['id'] ;?>" class="" onclick="return  confirm('are you sure?');"><md-icon class="ng-scope material-icons" role="img" aria-hidden="true"><i class="ion-trash-b text-muted"></i></md-icon></a>
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
      <?php } ?>
            <?php /* <md-tab label="<?php echo lang('invoices');?>">
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
            </md-tab> */ ?>
            <?php if($accessTab['employeehistory']== true) { ?>
               <md-tab label="<?php echo 'Employee History'?>">
        <md-content class="bg-white">
        <br>
		<div class="col-md-12">
      <table id="example" class="table table-striped table-bordered listdata" style="width:100%">
        <thead>
            <tr>
                <th>Module Name</th>
                <th>Action</th>
                <th>Date</th>
                <th>Changed By</th>
              
            </tr>
        </thead>
        <tbody>
 
    <?php   
      
    $avatar =   $this->Staff_Model->get_staff( $user_id );
?>
  <?php if($staffhistory) { 
      foreach ($staffhistory as $udoc) { ?><tr>
                <td><?php print $udoc['history_name']; ?></td>
                <td> <span class="text-danger" style="font-weight:600;"> <?php echo $udoc['history_type'] ;  ?></span></td>
                <td><?php echo $this->Staff_Model->get_format_change($udoc['created_date']);?> </td>
                <td> <img ng-src="<?php echo base_url('uploads/images/'. $avatar['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px"></td>
               
            </tr>

      <?php } } ?>
        </tbody>
</table>


  </div>
  


         </md-content>
      </md-tab>
      <?php } ?>
      
           <?php /* <md-tab label="<?php echo lang('proposals');?>">
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
            </md-tab>  */ ?>
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
        <!--
          <md-input-container class="md-block">
          <label><?php echo lang('Employee Id No') ?></label>
          <input required type="text"  class="form-control" id="employee_no"  ng-model="staff.employee_no"  />
        </md-input-container>
-->
        <md-input-container class="md-block">
          <label><?php echo lang('name') ?></label>
          <input required type="text" class="form-control" id="title"  ng-model="staff.name"  />
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('email') ?></label>
          <input required type="text"  class="form-control" id="title" ng-model="staff.email" />
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('mobile_number') ?></label>
          <input type="text"  class="form-control" id="title" ng-model="staff.phone" />
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('staffdepartment'); ?></label>
          <md-select required ng-model="staff.department_id" name="assigned" style="min-width: 200px;" readonly>
            <md-option  ng-value="department.id" ng-repeat="department in departments" >{{department.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
		 <md-input-container class="md-block">
          <label><?php echo lang('nationality') ?></label>
		  
         
          <md-select placeholder="<?php echo lang('nationality'); ?>" ng-model="staff.nationality"  name="country_id" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
       
		<!--
          <input type="text" required ng-model="staff.nationality" class="form-control" id="title">-->
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('status'); ?></label>
          <md-select required ng-model="staff.status" name="status" style="min-width: 200px;" readonly>
            <md-option ng-value="status.id" ng-repeat="status in statuss">{{status.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('Grade'); ?></label>
          <md-select required ng-model="staff.grade" name="assigned" style="min-width: 200px;" readonly>
            <md-option ng-value="grade.id" ng-repeat="grade in grade">{{grade.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs style="display:none">
          <label><?php echo lang('language'); ?></label>
          <md-select  ng-model="staff.language" name="assigned" style="min-width: 200px;" readonly>
            <md-option ng-value="language.foldername" ng-repeat="language in languages">{{language.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('roles'); ?></label>
          <md-select required ng-model="staff.assigned_role" name="assigned_role" style="min-width: 200px;" readonly>
            <md-option ng-value="assigned_role.role_id" ng-repeat="assigned_role in roles">{{assigned_role.role_name}} <span class="badge">{{assigned_role.role_type}}</span></md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container  class="md-block" style="display:none">
          <label><?php echo lang('staff'). ' '.lang('timezone')?></label>
          <md-select ng-model="staff_timezone">
            <md-optgroup ng-repeat="timezone in timezones" label="{{timezone.group}}">
              <md-option ng-value="zone.value" ng-repeat="zone in timezone.zones">{{zone.value}}</md-option>
            </md-optgroup>
          </md-select>
        </md-input-container>
         <md-input-container class="md-block">
          <label><?php echo lang('joining_date') ?></label>
		  <?php  $jdate=$this->Staff_Model->get_format_change1($staffres['joining_date']);?>
		 <input type="text" name="joining_date" value="<?php print $jdate;?>" class="form-control newdatepicker1" id="joining_date">
		   
		   
		   <!-- 
		   <md-datepicker name="joining_date" ng-model="staff.joining_date_edit" md-open-on-focus></md-datepicker>
		  
		   
		   
          <input type="text" name="joining_date" id="joining_date" class="newdatepicker form-control" readonly value="">
          <md-datepicker required name="joining_date"  ng-model="staff.joining_date" md-open-on-focus style="width: 200px !important;" ></md-datepicker>-->
        </md-input-container >
          <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('gender'); ?></label>
          <md-select required ng-model="staff.gender" name="assigned" style="min-width: 200px;">
            <md-option ng-value="gender.name" ng-repeat="gender in gender">{{gender.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
          <md-input-container class="md-block">
          <label><?php echo lang('date_of_birth') ?></label>
		   <?php  $bdate=$this->Staff_Model->get_format_change1($staffres['birthday']);?>
		   <input type="text" name="date_of_birth" value="<?php print $bdate;?>" class="form-control newdatepicker1" id="date_of_birth">
		   <!-- 
		   <md-datepicker name="date_of_birth" ng-model="staff.date_of_birth_edit" md-open-on-focus></md-datepicker>
		   
		    
		  <input mdc-datetime-picker="" date="true" time="false" type="text" id="date_of_birth" placeholder="Choose a date"  minutes="false"  show-icon="true" ng-model="staff.date_of_birth_result" class="ng-pristine ng-valid ng-isolate-scope ng-empty ng-touched" name="date_of_birth" value=""  aria-invalid="false" style="" format="DD-MM-YYYY" >
		 <input type="text" name="date_of_birth" id="date_of_birth" class="newdatepicker form-control" readonly value="">
          <md-datepicker required name="date_of_birth" ng-model="staff.date_of_birth_result" ></md-datepicker>-->
        </md-input-container>
           <md-input-container class="md-block">
          <label><?php echo lang('profession') ?></label>
          <input required type="text" ng-model="staff.profession" class="form-control" id="title"/>
        </md-input-container> 
          <md-input-container class="md-block">
          <label><?php echo lang('nominee') ?></label>
          <input type="text" required ng-model="staff.nominee" class="form-control" id="nominee">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo 'Home Country  Mobile Number' ?></label>
          <input type="text" ng-model="staff.nomineephone" class="form-control" id="title">
        </md-input-container>
        
      
         <md-input-container class="md-block">
          <label><?php echo lang('staff.homeaddress') ?></label>
          <textarea rows="2" ng-model="staff.homeaddress" class="form-control"></textarea>
        </md-input-container>
       
          <md-input-container class="md-block">
          <label><?php echo lang('remark') ?></label>
          <input type="text"  ng-model="staff.remark" class="form-control" id="title">
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

  
 <div id="leaves_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Leave</h4>
      </div>
      <div class="modal-body">
	  <div id="edit_leaves1"></div>
	  
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  
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
 <script src="<?php echo base_url('assets/js/staffs.js?v=1'); ?>"></script>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   

<!--
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>-->

      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	 
	   
	  <!-- datatables-->
	   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
          <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  
  <script>
    $(document).ready(function(){
		
		
		  
		 $('.listdata').DataTable();
		 $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
	$('.newdatepicker1').datepicker({dateFormat:'dd-mm-yy',

      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
	  
	  
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'dd-mm-yy',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
      
      
       var aall = $('#accomodation_allowance option:selected').val();
                if(aall == "Provide By Company"){
                    $('#accom_amound').addClass('sal');
                     $('#aam').show();
                    
                }else{
                    
                   $('#accom_amound').removeClass('sal');
                   $('#aam').hide();
                }
        var tall = $('#transport_allowance option:selected').val();

                if(tall == "Provide By Company"){
                 
                    $('#vehicle_amound').addClass('sal');
                    
                }
                else{
                    
                      $('#vehicle_amound').removeClass('sal');
                }
      
      
      tot_sal = 0;
$('input.sal').each(function() { 
				
					var value = parseFloat($(this).val());
		if (!isNaN(value)){ 			
			tot_sal += value;
			
		}
					
					});
					
$('#total_salary').val(tot_sal);
    


    })
    
    function update_button(){
		
		$('#nts').show();
		$('#nts1').hide();
	}
</script>
<script type="text/javascript">
<?php /*
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($productname); ?>,
                        datasets: [{
                              label : 'Present',
                            backgroundColor: [
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               "#5969ff",
                               
                            
                                
                            ],
                            data:<?php echo json_encode($sales); ?>,
                        },
                        
                        {
                              label : 'Absent',
                            backgroundColor: [
                               "#FF0000",
                                 "#FF0000",
                                "#FF0000",
                                 "#FF0000",
                                 "#FF0000",
                                "#FF0000",
                                 "#FF0000",
                                 "#FF0000",
                                "#FF0000",
                                 "#FF0000",
                                 "#FF0000",
                                "#FF0000",
                            ],
                            data:<?php echo json_encode($abs); ?>,
                        }]
                    },
                    options: {
                           legend: {
                        display: true,
                        position: '',
 
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
 
 
                }
                });
                */?>
                
                (function ( $ ) {
 
    $.fn.rating = function( method, options ) {
		method = method || 'create';
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
			limit: 5,
			value: 0,
			glyph: "glyphicon-star",
            coloroff: "gray",
			coloron: "gold",
			size: "18px",
			cursor: "default",
			onClick: function () {},
            endofarray: "idontmatter"
        }, options );
		var style = "";
		style = style + "font-size:" + settings.size + "; ";
		style = style + "color:" + settings.coloroff + "; ";
		style = style + "cursor:" + settings.cursor + "; ";
	

		
		if (method == 'create')
		{
			//this.html('');	//junk whatever was there
			
			//initialize the data-rating property
			this.each(function(){
				attr = $(this).attr('data-rating');
				if (attr === undefined || attr === false) { 
				    
				    $(this).attr('data-rating',settings.value); }
			})
			
			//bolt in the glyphs
			for (var i = 0; i < settings.limit; i++)
			{
				this.append('<span data-value="' + (i+1) + '" class="ratingicon glyphicon ' + settings.glyph + '" style="' + style + '" aria-hidden="true"></span>');
			}
			
			//paint
			this.each(function() { paint($(this)); });

		}
		if (method == 'set')
		{
			this.attr('data-rating',options);
			this.each(function() { paint($(this)); });
		}
		if (method == 'get')
		{
			return this.attr('data-rating');
		}
		//register the click events
		this.find("span.ratingicon").click(function() {
			rating = $(this).attr('data-value')
			$(this).parent().attr('data-rating',rating);
			paint($(this).parent());
			settings.onClick.call( $(this).parent() );
		})
		function paint(div)
		{
			rating = parseInt(div.attr('data-rating'));
			div.find("input").val(rating);	//if there is an input in the div lets set it's value
			div.find("span.ratingicon").each(function(){	//now paint the stars
				
				var rating = parseInt($(this).parent().attr('data-rating'));
				var value = parseInt($(this).attr('data-value'));
				if (value > rating) { $(this).css('color',settings.coloroff); }
				else { $(this).css('color',settings.coloron); }
			})
		}

    };
 
}( jQuery ));



	
	$("#stars-green").rating('create',{coloron:'green',onClick:function(){ 
	     var r = confirm("Are you sure to update the grade");
	     if (r == true) {
	        var id =  $('#staff_id').val();
	        var rating =  $(this).attr('data-rating');
	        
	        
	 $.ajax({
              url : "<?php echo base_url(); ?>staff/update_grade",
              data:{id : id,rating : rating},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          }); 
	
	     }else{
	         window.location.reload();
	         
	         
	     }
	 }});
	
var count2 = $('#count').val();

	$("body").on("click","#AddButton2",function(event){
		var count_val = count2++;
	
			append_html = '<div class="col-md-12 row"><input type="hidden" name="other[otd_id][]" id="otd_id" value="" /><div class="form-group col-md-3"> <label for="inputState">Other Docs Name</label><input type="text" class="form-control" name="other[others][]" id="inputZip"  label="others'+count_val+'"></div>';
			append_html += ' <div class="form-group col-md-3"><label for="inputState">Expiry Date</label><div class="input-group date"> <input type="text" name="other[other_expiry_date][]" class="form-control newdatepicker" id="other_expiry_date'+count_val+'"  label="others_expiry'+count_val+'"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span></div></div><div class="form-group col-md-2"><label for="inputZip">Remind Me</label> <input type="text" class="form-control" name="other[others_remind][]" id="inputZip" placeholder="Remind Me"  label="others_remind'+count_val+'" ></div><div class="form-group col-md-2"><label for="inputCity">Upload Docs</label><input type="hidden" name="other[old_others_data][]" ><input type="file" class="form-control" name="others_doc'+count_val+'[]" multiple id="others_doc" label="others_docs'+count_val+'"></div>';
                append_html += '<div class="col-md-1"><a  class="removeclass2 btn btn-danger " style="margin-top:20px" > <span class="glyphicon glyphicon-trash"></span> Remove</a></div></div>';
					
		$('#fields3').append(append_html);
	
         var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'dd-mm-yy',
      
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});

	 
	});
 $("body").on("click",".removeclass2", function(e){
		//alert('sdsd');
 var r = confirm("Are you sure to delete the record");
	     if (r == true) {
                $(this).parent('div').parent('div').remove(); 
                  return false;
	     }else{
				
	     }

    }); 
    
    function select_record(id){
        
        var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete",
              data:{id : id},
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
     function delete_tool_record(id){
        
        var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete_tools",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				  //alert("asd");
				  $(location).attr('href', '<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>/random='+Math.random()+'#tab7');
				  //location.href = 'newPage.html';
               //window.location.href ="<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>#tab7"
               //window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     }
        
    }
    
    function delete_leave_record(id){
        
        var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete_leaves",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				   $(location).attr('href', '<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>/random='+Math.random()+'#tab6');
               // window.location.href ="<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>#tab8";
               //window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     }
        
    }
	
	 function edit_leaves(id){
         
        $.ajax({
              url : "<?php echo base_url(); ?>staff/edit_leaves",
              data:{id : id},
              method:'post',
              success:function(response) {
				 
				 $('.modal-body #edit_leaves1').html(response);
				 
				 
				   var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'dd-mm-yy',
    container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true,zIndex: 3000});

				
              
			 
              // window.location.reload();
            }
          }); 
        
    }
    
    function updateAb(value)
	{
		alert(value);
	}
    
    
     function delete_appraisal_record(id){
        
        var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete_appraisal",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.href ='<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>/random='+Math.random()+'#tab4';
               //window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     }
        
    }
    

	 function delete_warning_record(id){
        
        var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete_warnings",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				   $(location).attr('href', '<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>/random='+Math.random()+'#tab5');
                //window.location.href ="<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>#tab5";
              // window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     }
        
    }
    

	function select_vta(val){
	    if (val == "Provide By Company"){
	         
	        
	        $('#vamt').show();
	      $('#vehicle_amound').addClass('sal');
	    }
	else{
	    
	     $('#vehicle_amound').removeClass('sal');
	        $('#vamt').hide();
	}
	   var aall = $('#accomodation_allowance').val();
if(aall == "Provide By Company"){
 
    $('#accom_amound').addClass('sal');
    
}else{
    
     $('#accom_amound').removeClass('sal');
}
	 tot_sal = 0;
    
$('input.sal').each(function() { 
					var value = parseFloat($(this).val());
		if (!isNaN(value)){ 			
			tot_sal += value;
			
		}
			
					
					});
					
				
	$('#total_salary').val(tot_sal);
	
	}
	
	function select_aal(val){
	    
	    if (val == "Provide By Company"){
	        
	         $('#accom_amound').removeClass('sal');
	        $('#aam').show();
	    }
	else{
	   
	      $('#accom_amound').addClass('sal');
	      
	     $('#aam').hide();
	}
	
	var tall = $('#transport_allowance').val();

if(tall == "Provide By Company"){
   $('#vehicle_amound').removeClass('sal');
    
}
else{
    
     $('#vehicle_amound').addClass('sal');
}
	     tot_sal = 0;
    
$('input.sal').each(function() { 
						var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
				
	$('#total_salary').val(tot_sal);
	}
	
	
	
var trall = $('#transport_allowance option:selected').val();
if(trall == "Provide By Company"){
     $( "#vehicle_amound" ).removeClass( "sal" )
     $('#vamt').show();
    

}
else{
      $( "#vehicle_amound" ).addClass( "sal" )
 $('#vamt').hide();
}


var allw = $('#accomdation_allowance option:selected').val();
if(allw == "Provide By Company"){
    
     
     
      $( "#accom_amound" ).addClass( "sal" )
 $('#aam').hide();
    

}
else{
      $( "#accom_amound" ).removeClass( "sal" )
     $('#aam').show();
}


function basic_salary(val){
    var aall = $('#accomodation_allowance').val();
if(aall == "Provide By Company"){
  
    $('#accom_amound').addClass('sal');
    
}else{
    
    $('#accom_amound').removeClass('sal');
}
var tall = $('#transport_allowance').val();

if(tall == "Provide By Company"){
   
   
    $('#vehicle_amound').addClass('sal');
    
}
else{
    
     $('#vehicle_amound').removeClass('sal');
}
    tot_sal = 0;
    
$('input.sal').each(function() { 
				
					
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
				
	$('#total_salary').val(tot_sal);
    
}

function select_allowance(val){
     var aall = $('#accomodation_allowance').val();
if(aall == "Provide By Company"){
     $('#accom_amound').addClass('sal');
   
    
}else{
    
   $('#accom_amound').removeClass('sal');
}
var tall = $('#transport_allowance').val();

if(tall == "Provide By Company"){
   
     $('#vehicle_amound').addClass('sal');
    
}
else{
    $('#vehicle_amound').removeClass('sal');
   
}
    tot_sal = 0;
$('input.sal').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
$('#total_salary').val(tot_sal);
    
}

function vehicle_amt(val){
    
var aall = $('#accomodation_allowance').val();
if(aall == "Provide By Company"){
  
   
    $('#accom_amound').addClass('sal');
    
}else{
     $('#accom_amound').removeClass('sal');
   
}
    tot_sal = 0;
$('input.sal').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
$('#total_salary').val(tot_sal);
    
}

function accom_amt(val){
    var tall = $('#transport_allowance').val();

if(tall == "Provide By Company"){
   
    $('#vehicle_amound').addClass('sal');
    
}
else{
    
    $('#vehicle_amound').removeClass('sal');
}
     tot_sal = 0;
$('input.sal').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					});
$('#total_salary').val(tot_sal);
}

var aall = $('#accomodation_allowance option:selected').val();
if(aall == "Provide By Company"){
     
     $('#aam').show();
}
else{
    
    $('#aam').hide();
 
}



         $(function() {
            $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
            $( "#opener-4" ).click(function() {
               $( "#dialog-4" ).dialog( "open" );
            });
         });
         
      function select_number(val){
$(function() {
            $( '#dialog-'+val ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
            $( '#opener-'+val ).click(function() {
               $( '#dialog-'+val ).dialog( "open" );
            });
         
});
         
         }
         
         
      
          
          $(function() {
            $( "#dialog-5" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
            $( "#opener-5" ).click(function() {
               $( "#dialog-5" ).dialog( "open" );
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
               $( "#dialog-6" ).dialog( "open" );
            });
         });
         
         
           $(function() {
           $( "#dialog-7" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            });
            $( "#opener-7" ).click(function() {
               $( "#dialog-7" ).dialog( "open" );
            });
         }); 
         
      function select_image_name(val,type, id){
         var val =  val;
         var type = type;
         var id = id;
        
         
         var r = confirm("Are you sure to delete the file");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>staff/delete_file",
              data:{val : val , type : type, id : id },
              method:'POST',
              dataType:'json',
              success:function(response) {
               $(location).attr('href', '<?php echo base_url(); ?>staff/staffmember/<?php print $id;?>/random='+Math.random()+'#tab2');
               //window.location.reload();
            }
          }); 
	     }
	     else{
	         
	         
	     } 
        
      }

    </script>
	
	    <div class="modal fade" id="pdfModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body form-group">
	 <iframe src="" width="100%" height="500px" id="pdfframe">
    </iframe>
	<!--
          	<object type="application/pdf" data="" width="100%" height="500" style="height: 85vh;" id="pdffile">No Support</object>-->
          
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>

       <div class="modal fade" id="editModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body form-group">
	
          <img src="" name="image" class="img-responsive postimg" id="image" width="70%" height="50%"><br>
          
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>  
</div>
<script type="text/javascript">
  function show_post(id)
  {
    var image=$('#editid'+id).data('image');
    //alert(image);
   // alert(id);
    $("#image").attr('src','<?php echo base_url()?>uploads/staff_documents/'+id);
  }
   function show_post_pdf(id)
  {
	  $("#pdffile").attr('data','');
    var image=$('#editidpdf'+id).data('image');
    //alert(image);
    //alert(id);
	
	  var $iframe = $('#pdfframe');
	  var url='<?php echo base_url()?>uploads/staff_documents/'+id;
	//  alert(url);
  $iframe.attr('src',url);    // here you can change src
        return false;
		
    //$("#pdffile").attr('data','<?php echo base_url()?>uploads/staff_documents/'+id);
  }
  
 function select_rejoin(){
      
     /*
	var start_date = $('#leave_start_date').val();
	var rejoin_date = $('#rejoin_date').val();
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(start_date);
    date2 = new Date(rejoin_date);
    var timediff = date2 - date1;
    
    var days = Math.floor(timediff / day); 
    
   
       
    $('#no_leave').val(days);*/
	
	   var start= $("#leave_start_date").datepicker("getDate");
    	var end= $("#rejoin_date").datepicker("getDate");
   		days = (end- start) / (1000 * 60 * 60 * 24);
       var finaldiff=Math.round(days);
	   
	   $('#no_leave').val(finaldiff);
	   
}

function select_rejoin1(){
      
     
	
	   var start= $("#leave_start_date1").datepicker("getDate");
    	var end= $("#rejoin_date1").datepicker("getDate");
   		days = (end- start) / (1000 * 60 * 60 * 24);
       var finaldiff=Math.round(days);
	   
	   $('#no_leave1').val(finaldiff);
	   
}

</script>

<script type="text/javascript"  src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">  
google.charts.load('current', {'packages':['corechart']});  
google.charts.setOnLoadCallback(drawPieChart);  

function drawPieChart()  
{  
    var pie = google.visualization.arrayToDataTable([  
              ['attendancede', 'Numbder'],
              ['Present', <?php print $present;?>],
           ['Absent', <?php print $absent;?>]
                    
         ]);  
    var header = {  
          title: 'Percentage of Staff attendance',
          slices: {0: {color: '#666666'}, 1:{color: '#006EFF'}}
         };  
    var piechart = new google.visualization.PieChart(document.getElementById('piechart'));  
    piechart.draw(pie, header);  
} 



</script>