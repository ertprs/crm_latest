<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<!-- Latest compiled and minified CSS 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">-->
<link rel="stylesheet" href="<?php echo base_url('build/intel/css/prism.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('build/css/intlTelInput.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('build/css/demo.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('build/intel/css/isValidNumber.css'); ?>">
<style> 
	.toBold { 
		color: orange !important;
	};
</style> 	 
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Contacts_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
		<div class="panel-heading"> <strong><?php echo lang('OverAll Contacts'); ?></strong> <span class="panel-subtitle"><?php //echo lang('tasksituationsdesc'); ?></span> </div>
		<div class="row" style="padding: 0px 20px 0px 20px;">
			<div class="col-md-12 col-xs-6 border-right text-uppercase">
				<md-list-item ng-click="open_students(0);" class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title" > <span class="task-stat-number" ng-bind="contacttype.total" ng-class="{toBold: setBold==0}"></span> <span class="task-stat-all" ng-bind="'/'+' '+contacttype.total+' '+'<?php echo lang('Contacts') ?>'" ng-class="{toBold: setBold==0}"></span> </h3>
					
                </md-list-item>
				<div class="tasks-status-stat">
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{ (contacttype.total)  /(contacttype.total)  }}%;"></span> </span>
				</div>
				<span style="color:#989898"><?php echo lang('All'); ?></span> 
			</div>
			<div class="col-md-12 col-xs-12 border-right text-uppercase">
				<md-list-item ng-click="open_students('business');" class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title" > <span class="task-stat-number" ng-bind="contacttype.businesstype" ng-class="{toBold: setBold=='business'}"></span> <span class="task-stat-all" ng-bind="'/'+' '+contacttype.total+' '+'<?php echo lang('Contacts') ?>'"  ng-class="{toBold: setBold=='business'}"></span> </h3>
					
                </md-list-item>
				<div class="tasks-status-stat">
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(contacttype.businesstype) * 100 / (contacttype.total) }}%;"></span> </span>
				</div>
				<span style="color:#989898"><?php echo lang('Companies'); ?></span>
			</div>
			<div class="col-md-12 col-xs-12 border-right text-uppercase" >
				<md-list-item ng-click="open_students('person');" class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title"  > <span class="task-stat-number" ng-bind="contacttype.persontype"  ng-class="{toBold: setBold=='person'}"></span> <span class="task-stat-all" ng-bind="'/'+' '+contacttype.total+' '+'<?php echo lang('Contacts') ?>'" ng-class="{toBold: setBold=='person'}"></span> </h3>
					
                </md-list-item>
				<div class="tasks-status-stat">
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(contacttype.persontype) * 100 / (contacttype.total) }}%;"></span> </span> 
				</div>
				<span style="color:#989898"><?php echo lang('Persons'); ?></span> 
			</div>
		</div>
	</div>
  <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
    <md-toolbar class="bg-white toolbar-white">
      <div class="md-toolbar-tools bg-white">
        <h2 flex md-truncate class="text-bold"><?php echo lang('contacts'); ?> <small>(<span ng-bind="tasks.length"></span>)</small><br>
          <small flex md-truncate><?php echo lang('View Add and Edit Contact'); ?></small></h2>
        <div class="ciuis-external-search-in-table">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contacts').' '.lang('name')   ?>">
          <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('search').' '.lang('contacts') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter').' '.lang('contacts') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('contacts', 'create')) { ?> 
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('new').' '.lang('contact') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <md-content>
      <div ng-show="taskLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="25"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span><?php echo lang('please_wait') ?> <br>
          <small><strong><?php echo lang('loading'). ' '. lang('contacts').'...' ?></strong></small></span>
        </p>
      </div>
      <div ng-show="!taskLoader" class="bg-white" style="padding: unset;">
        <md-table-container ng-show="tasks.length > 0">
          <table md-table  md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo 'Company Name'; ?></span></th>
                <!-- <th md-column md-order-by="address"><span><?php echo 'Company Address'; ?></span></th> -->
				
                <th md-column md-order-by="cperson"><span><?php echo 'Contact Person'; ?></span></th>
               <th md-column md-order-by="cnum"><span><?php echo 'Contact Number'; ?></span></th>
				 <!-- <th md-column md-order-by="cemail"><span><?php echo 'Email' ?></span></th> -->
				<th ><span><?php echo 'Keyword Or Comments'?></span></th>
				
				 <th ><span><?php echo 'Attachments'?></span></th>
              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="task in tasks | orderBy: task_list.order | filter: task_search | filter: FilteredData | limitTo: task_list.limit : (task_list.page -1) * task_list.limit " class="cursor" ng-click="goToLink('contacts/task/'+task.id)">
                 <!-- <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('contacts/task/')?>{{task.id}}"> <strong ng-bind="task.id"></strong></a> <br>
                   
                  </strong>
                </td> -->
                <td md-cell>
                  <strong>
             <a class="link" ng-href="<?php echo base_url('contacts/task/')?>{{task.id}}">
                    <small ng-bind="task.name"></small></strong></a> <br>
                  </strong>
                </td>
                <!-- <td md-cell>
                  <strong ng-bind="task.address"></strong>
                </td> -->
			
                <td md-cell>
                  <strong  ng-bind="task.cperson"></strong>
                </td>
				
                <td md-cell>
                  <p ng-repeat="num in task.allnum">
                   <!-- <strong ng-bind="(task.cnum | limitTo: 20 )+ (task.cnum.length > 20 ? '...' : '')"></strong>-->+<strong ng-bind="num.contact_country_code"></strong>
				      <strong ng-bind="num.contact_number"></strong>
                  </p>
                </td>
				<!--  
				  <td md-cell>
                  <span>
				  
                     <strong ng-bind="task.email"></strong>
                  </span>
                </td> -->
		<td md-cell>
                  <span>
				  
                     <strong ng-bind="(task.keywords | limitTo: 20 )+ (task.keywords.length > 20 ? '...' : '')"></strong>
                  </span>
                </td>
		
		 <td md-cell>
                  <p ng-show="task.doctype == 1">
          <img src="<?php  echo base_url('assets/img/file_icon.png'); ?>" style="height: 40%; width: 40%"/></p>
		  
		  <p ng-show="task.doctype == 0">-</p>
                  </span>
                </td>
				 <td  >
                  <div class="bottom-right text-right">
                    <ul class="more-avatar">
                      <li ng-repeat="member in task.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
                        <md-tooltip md-direction="top">{{member.staffname}}</md-tooltip>
                        <div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
                      </li>
                      <div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
                    </ul>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="limitOptions" md-page="task_list.page" md-total="{{tasks.length}}" ></md-table-pagination>
        <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
      </div>
    </md-content>
	<?php /*
		  <form action="<?php echo base_url('contacts/allnum/')?>" method="post" >
	  <div id="result">
	  <!--
      <input id="phone" type="tel" name="number[]">-->
	  <?php for($p=0;$p<3;$p++){?>
<span id="valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
<span id="error-msg<?php print $p;?>" class="hide"></span>
 <input type="text" id="calling_code<?php print $p;?>" name="country[]"/>
    <input type="tel" id="phone<?php print $p;?>" name="phone[]">
	<script type="text/javascript">
	 setTimeout(function(){
	allshowtel('<?php print $p;?>');
	  },1000);
	</script>
	  <?php }?>
    </div><input type="submit" value="submit">
	</form>
	  <?php */?>
  </div>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'address' && prop != 'cperson' && prop != 'cnum' && prop != 'email'  && prop != 'keywords' && prop != 'created' && prop != 'doctype' && prop != 'allnum' ">
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

  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
		<!--
        <md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable').' '.lang('task') ?></strong>
          <md-tooltip ng-hide="savingInvoice == true" md-direction="bottom"><?php echo lang('task_as_billable') ?></md-tooltip>
        </md-switch>-->
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
	 	  <div class="alert alert-danger alert-dismissible" id="displayerror"><span id="showerror"></span></div>
		   <md-tabs md-dynamic-height md-border-bottom>
             
           
	 <md-tab label="<?php echo lang('Business') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		  <form action="<?php echo base_url('contacts/createb/')?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
	  
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('company')?>*</label>
          <input  name="cname" >
        </md-input-container>
       
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input  name="cperson" >
        </md-input-container>
      </div>
       <div layout-gt-xs="row">
       <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" >
        </md-input-container>
        </div>
    <div layout-gt-xs="row" class="layout-gt-xs-row">
      <div class="form-group col-md-12">
        <div class="field_wrapper row field_wrapper0">
		<div class="form-group col-md-9">
		 <label for="inputZip">Enter Contact Number</label>
		
	  <!--
      <input id="phone" type="tel" name="number[]">-->
	  <?php for($p=1;$p<2;$p++){?>
<span id="valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
<span id="error-msg<?php print $p;?>" class="hide"></span>
 <input type="hidden" id="calling_code<?php print $p;?>" name="countrycode[]" value="<?php print $phonecode;?>"/>
    <input type="tel" id="phone<?php print $p;?>" name="point_contact_number[]" value="<?php print '+'.$phonecode;?>">
	<script type="text/javascript">
	 setTimeout(function(){
	allshowtel('<?php print $p;?>');
	  },1000);
	</script>
	  <?php }?>
    
		</div>
		<!--
    <div class="form-group col-md-4">
      <label for="inputZip">Country Code</label>
      <select name="countrycode[]" style="width: 85px; height: 46px;">
            <option value="971">ARE +971</option>
            <?php foreach ($countries as $country) {
              ?>
              <option value="<?php echo $country['phonecode']; ?>"><?php echo $country['iso3'] .' +'. $country['phonecode']; ?></option>
              <?php
            } ?>
            
          </select>
    </div>
    
  <div class="form-group col-md-5">
      <label for="inputZip">Contact Number</label>
      <input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">
    </div>-->
  <div class="form-group col-md-3">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
    <div>
            </div>
</div>
</div>
</div>

  <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea autocomplete="off" name="keyword_content" rows="3"></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="content" autocomplete="off" name="address" rows="3"></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="files[]" id="chooseFile" multiple >
      </md-input-container>
     
      </div>

      
	   <button type="submit" class="btn btn-report" >Create</button>
	    </form>
    </md-content>
	</md-tab>
	 <md-tab label="<?php echo lang('person') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		   <form action="<?php echo base_url('contacts/create/')?>" method="post" id="formid" enctype="multipart/form-data">
    
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input name="cperson" >
        </md-input-container>

      </div>
        <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail" >
        </md-input-container>
      </div>
      <div layout-gt-xs="row" class="layout-gt-xs-row">
  <div class="field_wrapper row field_wrapper1">
  <div class="form-group col-md-9">
  <label for="inputZip">Enter Contact Number</label>
		
	  <!--
      <input id="phone" type="tel" name="number[]">-->
	  <?php for($p=1;$p<2;$p++){?>
<span id="person_valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
<span id="person_error-msg<?php print $p;?>" class="hide"></span>
 <input type="hidden" id="person_calling_code<?php print $p;?>" name="person_countrycode[]" value="<?php print $phonecode;?>"/>
    <input type="tel" id="person_phone<?php print $p;?>" name="person_point_contact_number[]" value="<?php print '+'.$phonecode;?>">
	<script type="text/javascript">
	 setTimeout(function(){
	allshowtel1('<?php print $p;?>');
	  },1000);
	</script>
	  <?php }?>
    
  </div>
  <!--
    <div class="form-group col-md-4">
      <label for="inputZip">Country Code</label>
      <select name="countrycode[]" style="width: 85px; height: 46px;">
            <option value="971">ARE +971</option>
            <?php foreach ($countries as $country) {
              ?>
              <option value="<?php echo $country['phonecode']; ?>"><?php echo $country['iso3'] .' +'. $country['phonecode']; ?></option>
              <?php
            } ?>
            
          </select>
    </div>
  <div class="form-group col-md-5">
      <label for="inputZip">Contact Number</label>
      <input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">
    </div>-->
  <div class="form-group col-md-3">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button1" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
    <div>
            </div>
</div>
</div>
<br/>
	<div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea autocomplete="off" name="keyword_content" rows="3"></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="content" autocomplete="off" name="address" rows="3"></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="files[]" id="chooseFile" multiple>
      </md-input-container>
     
      </div>
      
	  <button type="submit" class="btn btn-report" >Create</button>
	   </form>
    </md-content>
	</md-tab>
 
	</md-tabs>
   
	       
    </md-content>
  </md-sidenav>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/contacts.js'); ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
	$('#displayerror').hide();
	$('.my-select').selectpicker();
	
	function checkvalidations()
	{
		var selectable=$('#priority').val();
		$('#displayerror').show();	
		if($('#title').val()==''){
			$('#displayerror').show();
			$('#showerror').html("Please Enter Task Name");
			return false;
		} else if($('#datetime1').val()=='' && selectable==4){
			$('#displayerror').show();
			$('#showerror').html("Please Enter Due Date.");
			return false;
		} else if($('#description').val()==''){
			$('#displayerror').show();
			$('#showerror').html("Please Enter Description.");
			return false;
		} else if($('#assigned option:selected').length==0){
			$('#displayerror').show();
			$('#showerror').html("Please Select atleast One Assigned to.");
			return false;
		}else{
			$('#displayerror').hide();
			$('#formid').submit()
		}
	}

function showdateselection(str){
	if(str==4){
		$('#duedateselect').show();
	}else{
		$('#duedateselect').hide();
	}
}

  $(document).ready(function(){
	  var phonecode='<?= $settings["phonecode"]?>';
	  $("#phonecode").val(phonecode);
	console.log(phonecode);
	   var x = 1; //Initial field counter is 1
	   
    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper0'); //Input field wrapper
	var wrapper1 = $('.field_wrapper1');
	var addButton1=$('.add_button1'); 
   // var fieldHTML = ' <div class="form-group col-md-4">   <label for="inputZip"> Country Code</label><select name="countrycode[]" style="width: 85px; height: 46px;"> <option value="971">ARE +971</option><?php foreach($countries as $country) { ?> <option value="<?php echo $country["phonecode"]; ?>"><?php echo $country["iso3"] ." +". $country["phonecode"]; ?></option> <?php } ?></select> </div><div class="form-group col-md-5" style = ""> <label for="inputZip"> Contact Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>  <div class="form-group col-md-3">      <label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div><br>'; //New input field html 
 
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="valid-msg'+x+'" class="hide">✓ Valid</span><span id="error-msg'+x+'" class="hide"></span> <input type="hidden" id="calling_code'+x+'" name="countrycode[]" value="<?php print $phonecode;?>"/>    <input type="tel" id="phone'+x+'" name="point_contact_number[]" value="<?php print '+'.$phonecode;?>"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper).append(fieldHTML); //Add field html
	
	allshowtel(x);
	
			//allshowtel(x);
        }
    });
	
	
	 $(addButton1).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="person_valid-msg'+x+'" class="hide">✓ Valid</span><span id="person_error-msg'+x+'" class="hide"></span> <input type="hidden" id="person_calling_code'+x+'" name="person_countrycode[]" value="<?php print $phonecode;?>"/>    <input type="tel" id="person_phone'+x+'" name="person_point_contact_number[]" value="<?php print '+'.$phonecode;?>"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper1).append(fieldHTML); //Add field html
	 
	allshowtel1(x);
	  
			//allshowtel(x);
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
	
	$(wrapper1).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
});



</script>
<script src="<?php echo base_url('build/intel/js/prism.js'); ?>"></script>
<script src="<?php echo base_url('build/js/intlTelInput.js'); ?>"></script>
<script src="<?php //echo base_url('build/intel/js/isValidNumber.js'); ?>"></script>
	
	 <script>
	function allshowtel(str){
		var input = document.querySelector("#phone"+str+""),
  errorMsg = document.querySelector("#error-msg"+str+""),
  validMsg = document.querySelector("#valid-msg"+str+"");
  
//  var country = $('#country'+str+'');
// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	separateDialCode : true,
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
 // alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
 
  $('#calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	
	
	function allshowtel1(str){
		
		var input = document.querySelector("#person_phone"+str+""),
  errorMsg = document.querySelector("#person_error-msg"+str+""),
  validMsg = document.querySelector("#person_valid-msg"+str+"");
  
  

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	separateDialCode : true,
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
//console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
  //alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
  $('#person_calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	</script> 
	