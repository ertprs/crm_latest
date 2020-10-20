<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.shown{
	display:block !important;
}

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Out'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'In'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }

.switchToggle1 input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle1 label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle1 label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle1 input:checked + label, .switchToggle1 input:checked + input + label  {background: #3e98d3; }
.switchToggle1 input + label:before, .switchToggle1 input + input + label:before {content: 'No'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle1 input:checked + label:before, .switchToggle1 input:checked + input + label:before {content: 'Yes'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle1 input:checked + label:after, .switchToggle1 input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle1 label:active:after {width: 60px; } 
</style>
<div class="ciuis-body-content" ng-controller="Staffs_Controller" ng-app="myAppModule">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9" layout="row" layout-wrap>
    <md-toolbar ng-show="!customersLoader" class="toolbar-white" style="margin: 0px 8px 8px 8px;">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" aria-label="File">
        <md-icon><i class="ico-ciuis-staff text-muted"></i></md-icon>
      </md-button>
      <h2 flex md-truncate><?php echo lang('staff'); ?> <small>(<span ng-bind="staff.length"></span>)</small></h2>
      <div class="ciuis-external-search-in-table">
        <input ng-model="search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search').' '.lang('staff') ?>">
        <md-button class="md-icon-button" aria-label="Search" ng-cloak>
          <md-icon><i class="ion-search text-muted"></i></md-icon>
        </md-button>
      </div>
      <md-button ng-show="showGrid==true" ng-click="showGrid=false;showList=true;" class="md-icon-button" aria-label="New" ng-cloak>
        <md-tooltip md-direction="bottom"><?php echo lang('show').' '.lang('list') ?></md-tooltip>
        <md-icon><i class="ion-ios-list-outline text-muted"></i></md-icon>
      </md-button>
      <md-button ng-show="showList==true" ng-click="showList=false;showGrid=true;" class="md-icon-button" aria-label="New" ng-cloak>
        <md-tooltip md-direction="bottom"><?php echo lang('show').' '.lang('grid') ?></md-tooltip>
        <md-icon><i class="ion-android-apps text-muted"></i></md-icon>
      </md-button>
      <?php if (check_privilege('staff', 'create')) { ?>
        <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('create').' '.lang('staff') ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>
      <?php }?>
	   <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter').' '.lang('staff') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
    </div>
  </md-toolbar>
  <br>
    <div ng-show="showGrid==true" flex-gt-xs="33" flex-xs="100" ng-repeat="member in staff | filter:search | pagination : currentPage*itemsPerPage | limitTo: 6" style="padding: 0px;margin: 0px" ng-cloak>
      <md-card md-theme-watch style="margin-top:0px" class="viewSet"> 
        <md-card-title>
          <md-card-title-media style="width:100px;height:100px"> 
            <img src="<?php echo base_url('uploads/images/{{member.avatar}}'); ?>" alt="Avatar" class="staff_img"></md-card-title-media>
           <md-card-title-text class="md-ml-20 xs-ml-20" style="margin-top: -10px;"> 
             <a class="md-headline cursor" ng-click="ViewStaff(member.id)">
               <span ng-bind="member.name"></span><sup class="sup-label" style="background: <?php echo '{{member.color}}' ?>" ng-bind="member.type"></sup>
             </a>
             <span class="md-subhead" ng-bind="member.staff_number"></span>
             <span class="md-subhead" ng-bind="member.department"></span> 
             <span class="md-subhead"><a href="tel:{{member.phone}}">{{member.phone}}</a></span> 
           <!--  <span class="md-subhead"><a href="tel:{{member.email}}">{{member.email}}</a></span>  -->
           </md-card-title-text>
		   
         </md-card-title>
         <div class="clearfix"></div>
		   <md-button ng-click="ViewStaff(member.id)"><?php echo lang('view')?></md-button>
      </md-card>
    </div> 
    <div ng-show="showGrid==true" class="text-center pagination-center" ng-cloak>
      <md-content ng-show="!staff.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
      <div class="pagination-div text-center" ng-show="staff.length > 5">
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </div>
    <md-content flex-gt-xs="100" flex-xs="100" ng-show="showList==true" class="bg-white" ng-cloak style="margin: -20px 8px 8px 8px;">
      <md-table-container ng-show="staff.length > 0">
        <table md-table  md-progress="promise">
          <thead md-head md-order="staff_list.order">
            <tr md-row>
            
         <th md-column md-order-by="id"><span>ID NO</span></th>
           <th md-column><span>#</span></th>
              <th md-column><span><?php echo lang('department'); ?></span></th>
         <th md-column><span>DOB</span></th>
         <th md-column ><span><?php echo lang('mobile_number'); ?></span></th>
              <!--<th md-column><span><?php echo lang('type'); ?></span></th>-->
       
            <!--  <th md-column md-order-by="created"><span><?php //echo lang('email'); ?></span></th> -->
           <!--   <th md-column md-order-by="duedate"><span><?php //echo lang('department'); ?></span></th> -->
              <th md-column ><span><?php echo lang('status'); ?></span></th>
			   <th md-column><span>Passport</span></th>
              <th md-column ><span>Pinned</span></th>
              
              <!-- <th md-column md-order-by="total"><span><?php echo lang('amount'); ?></span></th> -->
            </tr>
          </thead>
          <tbody md-body>
            <tr class="select_row" md-row ng-repeat="member in staff | orderBy: staff_list.order | filter: search | filter: FilteredData | limitTo: staff_list.limit : (staff_list.page -1) * staff_list.limit  ">
             
              <td md-cell>
                <span><span ng-bind="member.id"></span></span>
              </td>
             
             
             
              <td md-cell>
                <div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{member.name}}" class="assigned-staff-for-this-lead user-avatar"><img ng-click="ViewStaff(member.id)" ng-src="<?php echo base_url('uploads/images/{{member.avatar}}')?>" alt="{{member.name}}"></div>
              </td>
        
         
        
              <td md-cell>
                <div>
                  <strong>
                    <a class="link cursor" ng-click="ViewStaff(member.id)"> <span ng-bind="member.name"></span></a>
                  </strong>
                </div>
              </td>
			 <td md-cell>
                <strong><span ng-bind="member.birthday" class="badge" >{{member.birthday}}</span></strong>
              </td>
         <td md-cell>
                <a href="tel:{{member.phone}}">{{member.phone}}</a>
              </td>
              <!-- <td md-cell ng-show="member.color !=''">
                <span class="sup-label" style="background: <?php echo '{{member.color}}' ?>;font-size: 14px !important;" ng-bind="member.type"></span>
              </td>
			   <td md-cell ng-show="member.color ==''">
                <a class="link cursor" href="<?php echo base_url('settings'); ?>">Role Assign</a>
              </td>
              <td md-cell>
                <span><a ng-href="email:{{member.email}}"><span ng-bind="member.email"></span></a></span>
              </td> -->
             <!--  <td md-cell>
                <span><span ng-bind="member.department"></span></span>
              </td> -->
              
               <td md-cell>
                <span class="sup-label colorGreenBack" style="background: <?php echo '{{member.status_type}}' ?>;font-size: 14px !important;" ng-bind="member.status"></span>
              </td>
			  <td md-cell><div class="outerDivFull" >
<div class="switchToggle">
    <input type="checkbox" id="switch<?php print '{{member.id}}';?>" ng-init='checkStatus= member.passport_status ==1 ? true : false' ng-model='checkStatus' ng-click='update_status(checkStatus,1,member.id)' >
    <label for="switch<?php print '{{member.id}}';?>">Toggle</label>
</div>


</div></td>
              <td md-cell>
			<div class="pull-right md-pr-10 pinned<?php print '{{member.id}}';?>" ng-show="member.pin_status == 1">
			     <span>
				 
			  <i class="glyphicon glyphicon-pushpin" ng-click='update_status(1,2,member.id)' ></i>
			    <md-tooltip md-direction="top">Delete</md-tooltip>
                    </span>
					</div>
					<div class="pull-right md-pr-10 pin<?php print '{{member.id}}';?>" ng-show="member.pin_status == 0">
			   <span>
                      <i ng-click='update_status(checkStatus2,2,member.id)' class="ciuis-project-badge pull-right ion-pin"></i>
                      <md-tooltip md-direction="top">Pin Staff</md-tooltip>
                    </span>
					</div>
                   
					<!--
					
			  <div class="outerDivFull" >
			  
			  
<div class="switchToggle1">
    <input type="checkbox" id="switch1<?php print '{{member.id}}';?>" ng-init='checkStatus2=member.pin_status ==1 ? true : false' ng-model='checkStatus2' ng-click='update_status(checkStatus2,2,member.id)' >
    <label for="switch1<?php print '{{member.id}}';?>">Toggle</label>
</div>


</div>-->


			  
			  <!--
                <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ion-ios-arrow-down"></i>
                        </button>
                        <div class="dropdown-menu overflow-auto"  aria-labelledby="dropdownMenuButton">
						
						
                          <p class="dropdown-item" > <input type="checkbox" ng-init='checkStatus= member.passport_status ==1 ? true : false' ng-model='checkStatus' ng-click='update_status(checkStatus,1,member.id)' ><div ng-if="member.passport_status == 1"><span  style='color:red'>Passport</span></div><div ng-if="member.passport_status == 0"><span>Passport</span></div></p>
                          <p class="dropdown-item" > <input type="checkbox" ng-init='checkStatus2=member.pin_status ==1 ? true : false' ng-model='checkStatus2' ng-click='update_status(checkStatus2,2,member.id)' > Pinned</p>
                   <!--       <p class="dropdown-item" > <input type="checkbox" ng-init='checkStatus3=member.vaccstatus  == 5 ? true : false' ng-model='checkStatus3' ng-click='update_status(checkStatus3,3,member.id)'> Passport Out</p> 
                        </div>
                      </div>-->
        
              </td>
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="staff.length > 0" md-limit="staff_list.limit" md-limit-options="limitOptions" md-page="staff_list.page" md-total="{{staff.length}}" ></md-table-pagination>
    </md-content>
    
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate><?php echo lang('Status') ?></h2>
        <!-- <?php if (check_privilege('staff', 'create')) { ?>
          <md-button ng-click="NewDepartment()" class="md-icon-button" aria-label="Department" ng-cloak>
            <md-tooltip md-direction="left"><?php echo lang('adddepartment') ?></md-tooltip>
            <md-icon><i class="ion-android-add text-muted"></i></md-icon>
          </md-button>
        <?php } ?> -->
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item >
          <p ng-click="open_students(0);" ><strong class="allColorDiv">All</strong> : <strong class="allColorDiv1" ng-bind="payroll.total"></strong>
          </p><br>
        </md-list-item>
        <md-list-item >
          <p ng-click="open_students(1);" ><strong class="blueColor">Active</strong> : <strong class="blueColor1" ng-bind="payroll.active"></strong>
          </p><br>
        </md-list-item>
        <md-list-item>
          <p ng-click="open_students(2);"><strong class="greyColor">In-Active</strong> : <strong class="greyColor1" ng-bind="payroll.in_active"></strong>
          </p><br>
        </md-list-item>
        <md-list-item>
          <p ng-click="open_students(3);"><strong class="orangeColor">Cancelled</strong> : <strong class="orangeColor1" ng-bind="payroll.cancelled"></strong>
          </p><br>
        </md-list-item>
        <md-list-item>
          <p ng-click="open_students(4);"><strong class="redColor">Terminated</strong> : <strong class="redColor1" ng-bind="payroll.terminated"></strong>
          </p><br>
        </md-list-item>
        <md-list-item>
           <p ng-click="open_students(5);"><strong class="yellowColor">On Vacation</strong> : <strong class="yellowColor1" ng-bind="payroll.onvacation"></strong>
          </p><br>
        </md-list-item>
        <md-list-item>
           <p ng-click="open_students(6);"><strong class="greenColor">Payroll</strong> : <strong class="greenColor1" ng-bind="payroll.payroll"></strong>
          </p><br>
         </md-list-item>
         <md-list-item>
           <p ng-click="open_students(7);"><strong class="brownColor">Rejected</strong> : <strong class="brownColor1" ng-bind="payroll.rejected"></strong>
          </p>
            </md-list-item>
          
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!departments.length" class="md-padding bg-white no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
    </md-content>
 

     <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate><i class="glyphicon glyphicon-pushpin"></i> Pinned</h2>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item ng-repeat="pinn_data in pinned"  aria-label="Project">
          <p><strong ng-bind="pinn_data.staffname"></strong></p>

           <md-button ng-click='update_status(1,2,pinn_data.id)'  class="md-icon-button" aria-label="Create">
              <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
              <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>


          
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!pinned.length" class="md-padding bg-white no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
    </md-content>

    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate><?php echo lang('departments') ?></h2>
        <?php if (check_privilege('staff', 'create')) { ?>
          <md-button ng-click="NewDepartment()" class="md-icon-button" aria-label="Department" ng-cloak>
            <md-tooltip md-direction="left"><?php echo lang('adddepartment') ?></md-tooltip>
            <md-icon><i class="ion-android-add text-muted"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item ng-repeat="department in departments" ng-click="EditDepartment($index)" aria-label="Project">
          <p><strong ng-bind="department.name"></strong></p>
          <?php if (check_privilege('staff', 'delete')) { ?>
            <md-button ng-click="DeleteDepartment($index)" class="md-icon-button" aria-label="Create">
              <md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
              <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!departments.length" class="md-padding bg-white no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
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
      <div ng-repeat="(prop, ignoredValue) in staff[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'avatar' && prop != 'phone' && prop != 'address' && prop != 'email' && prop != 'last_login' && prop != 'appointment_availability' && prop != 'staff_number' && prop != 'type'  && prop != 'color' && prop != 'birthday' && prop != 'status_type' && prop != 'status' && prop != 'passport_status' && prop != 'pin_status' && prop != 'vaccstatus' ">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
       <!--  <md-switch ng-model="staff.active" aria-label="Type"><strong class="text-muted"><?php echo lang('active') ?></strong></md-switch> -->
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
        <md-input-container class="md-block">
          <label><?php echo lang('Employee ID No') ?></label>
          <input required type="text" ng-model="member.employee_no" class="form-control" id="employee_no">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('Name') ?></label>
          <input required type="text" ng-model="staff.name" class="form-control" id="title">
        </md-input-container>
        <!-- <md-input-container class="md-block">
          <label><?php echo lang('Last name') ?></label>
          <input required type="text" ng-model="staff.last_name" class="form-control" id="title">
        </md-input-container> -->
          <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('gender'); ?></label>
          <md-select required ng-model="staff.gender" name="assigned" style="min-width: 200px;">
            <md-option ng-value="gender.name" ng-repeat="gender in gender">{{gender.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
		
        <md-input-container class="md-block">
          <label><?php echo lang('date_of_birth') ?></label>
           <md-datepicker required name="date_of_birth" ng-model="date_of_birth" md-open-on-focus ></md-datepicker>
        </md-input-container>
        <!--<md-input-container class="md-block">
          <label><?php echo lang('email') ?></label>
          <input type="text" ng-model="staff.email" class="form-control" id="title" minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/">
        </md-input-container>
        <md-input-container class="md-block password-input">
          <label><?php echo lang('password') ?></label>
          <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
          <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
        </md-input-container>-->
        <md-input-container class="md-block">
          <label><?php echo lang('mobile_number') ?></label>
          <input type="text" ng-model="staff.phone" class="form-control" id="title">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('staffdepartment'); ?></label>
          <md-select required ng-model="staff.department_id" name="assigned" style="min-width: 200px;">
            <md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs style="display:none">
          <label><?php echo lang('language'); ?></label>
          <md-select  ng-model="staff.language" name="assigned" style="min-width: 200px;">
            <md-option ng-value="language.foldername" ng-repeat="language in languages">{{language.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>

        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('status'); ?></label>
          <md-select required ng-model="staff.status" name="assigned" style="min-width: 200px;">
            <md-option ng-value="status.id" ng-repeat="status in statuss">{{status.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('Grade'); ?></label>
          <md-select required ng-model="staff.grade" name="assigned" style="min-width: 200px;">
            <md-option ng-value="grade.id" ng-repeat="grade in grade">{{grade.name}}</md-option>
          </md-select>
          <br>
        </md-input-container>
        <!--<md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('roles'); ?></label>
          <md-select required ng-model="staff.assigned_role" name="assigned_role" style="min-width: 200px;">
            <md-option ng-value="role.role_id" ng-repeat="role in roles">{{role.role_name}} <span class="badge">{{role.role_type}}</span></md-option>
          </md-select>
          <br>
        </md-input-container>-->
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
           <md-datepicker required name="joining_date"  ng-model="joining_date" md-open-on-focus style="width: 200px !important;" ></md-datepicker>
        </md-input-container >
         <md-input-container class="md-block">
          <label><?php echo lang('profession') ?></label>
          <input type="text" ng-model="staff.profession" class="form-control" id="title">
        </md-input-container>
      
        <!-- <md-input-container class="md-block">
          <label><?php echo lang('profile') ?>&nbsp;</label>
          <input type="file"  file-model="staff.image" class="form-control" id="title">
        </md-input-container> -->
         <md-input-container class="md-block">
          <label><?php echo lang('nominee') ?></label>
          <input type="text" required ng-model="staff.nominee" class="form-control" id="title">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo 'Home Country Mobile Number' ?></label>
          <input type="text" ng-model="staff.nomineephone" class="form-control" id="title">
        </md-input-container>
         <md-input-container class="md-block">
          <!--<label><?php echo lang('nationality') ?></label>-->
		   <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="staff.country_id"  name="country_id" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
		<!--
          <input type="text" required ng-model="staff.nationality" class="form-control" id="title">-->
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('staff.homeaddress') ?></label>
          <textarea rows="2" ng-model="staff.homeaddress" class="form-control"></textarea>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('homeaddress 2') ?></label>
          <textarea rows="2" ng-model="staff.address" class="form-control"></textarea>
        </md-input-container>
          <md-input-container class="md-block">
          <label><?php echo lang('remark') ?></label>
          <input type="text"  ng-model="staff.remark" class="form-control" id="title">
        </md-input-container>
      </md-content>
      <custom-fields-vertical></custom-fields-vertical>
      <md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <?php if (check_privilege('staff', 'create')) { ?>
            <md-button ng-click="AddStaff()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
              <span ng-hide="saving == true"><?php echo lang('add');?></span>
              <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
          <?php }?>
          <br/><br/><br/><br/>
        </section>
      </md-content>
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js?v=1'); ?>"></script>