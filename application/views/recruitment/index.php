<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style> 
	.toBold { 
		color: orange !important;
	};
</style> 
<div class="ciuis-body-content" ng-controller="Recruitment_Controller">
    <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
		<div class="panel-heading"> <strong><?php echo lang('OverAll Recruitment'); ?></strong> 
			<span class="panel-subtitle"><?php //echo lang('tasksituationsdesc'); ?></span>
		</div>
		<div class="row" style="padding: 0px 20px 0px 20px;">
			<div class="col-md-6 col-xs-6 border-right">
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(0);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title" > <span class="task-stat-number" ng-bind="recruitmenttype.total" ng-class="{toBold: setBold==0}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==0}"></span> </h3>	
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{ (recruitmenttype.total)  /(recruitmenttype.total)  }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('All'); ?></span> 
				
				<div class="tasks-status-stat">
				<br>
					<md-list-item ng-click="open_recruitment(3);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="recruitmenttype.Screened" ng-class="{toBold: setBold==3}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==3}"></span> </h3>
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(recruitments | filter:{status:'3'}).length * 100 / recruitments.length }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Screened')?></span>
				
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(5);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="recruitmenttype.Hired" ng-class="{toBold: setBold==5}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==5}"></span> </h3>
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{ (recruitmenttype.Hired)  /(recruitmenttype.total)  }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Hired')?></span>
				
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(6);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="recruitmenttype.Rejected" ng-class="{toBold: setBold==6}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==6}"></span> </h3>
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(recruitmenttype.Rejected) * 100 / (recruitmenttype.total) }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Rejected')?></span>
			</div>
			<div class="col-md-6 col-xs-6 border-right">
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(1);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title" > <span class="task-stat-number" ng-bind="recruitmenttype.AwaitingReview" ng-class="{toBold: setBold==1}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==1}"></span> </h3>
						
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(recruitmenttype.AwaitingReview) * 100 / (recruitmenttype.total) }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Awaiting Review'); ?></span> 
				
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(2);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="recruitmenttype.Reviewed" ng-class="{toBold: setBold==2}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==2}"></span> </h3>
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(recruitmenttype.Reviewed) * 100 / (recruitmenttype.total) }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Reviewed')?></span>
				
				<div class="tasks-status-stat">
					<md-list-item ng-click="open_recruitment(4);" class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="recruitmenttype.Interviewed" ng-class="{toBold: setBold==4}"></span> <span class="task-stat-all" ng-bind="'/'+' '+recruitmenttype.total+' '+'<?php echo lang('Recruitment') ?>'" ng-class="{toBold: setBold==4}"></span> </h3>
					</md-list-item>
					<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(recruitmenttype.Interviewed) * 100 / (recruitmenttype.total) }}%;"></span> </span>
				</div>
				<span class="text-uppercase" style="color:#989898"><?php echo lang('Interviewed')?></span>
			
			</div>
		</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
		<md-toolbar class="bg-white toolbar-white">
			<div class="md-toolbar-tools bg-white">
				<md-button class="md-icon-button" aria-label="File">
					<md-icon><i class="ico-ciuis-staff text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate class="text-bold"><?php echo 'Recruitment' ?><small> (<span ng-bind="recruitments.length"></span>)</small></h2>
				<div class="ciuis-external-search-in-table">
					<input ng-model="recruitment_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('Recruitment')   ?>">
					<md-button class="md-icon-button" aria-label="Search" ng-cloak>
						<md-tooltip md-direction="bottom"><?php echo lang('search').' '.lang('Recruitment') ?></md-tooltip>
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<?php if (check_privilege('recruitment', 'create')) { ?> 
					<md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
						<md-tooltip md-direction="bottom"><?php echo lang('new').' '.lang('Candidates') ?></md-tooltip>
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
					<small><strong><?php echo lang('loading'). ' '. lang('Recruitment').'...' ?></strong></small></span>
				</p>
			</div>
			<div ng-show="!taskLoader" class="bg-white" style="padding: unset;">
				<md-table-container ng-show="recruitments.length > 0">
					<table md-table  md-progress="promise" ng-cloak>
						<thead md-head md-order="recruitment_list.order">
							<tr md-row>
								<th md-column md-order-by="name"><span>Applicant Name </span></th>
								<th md-column md-order-by="position"><span>Position Applied For</span></th>
								<th md-column><span>Date</span></th>
								<th md-column><span>Status</span></th>
								<th md-column md-column md-order-by="location"><span>Location</span></th>
								<th md-column><span><?php echo 'Attachments'?></span></th>
							</tr>
						</thead>
						<tbody md-body>
							<tr class="select_row" md-row ng-repeat="recruitment in recruitments | orderBy: recruitment_list.order | filter: recruitment_search | filter: FilteredData | limitTo: recruitment_list.limit : (recruitment_list.page -1) * recruitment_list.limit " class="cursor" >
								<td md-cell>
									<strong>
										<a class="link" ng-href="<?php echo base_url('recruitment/GetRecruitment/')?>{{recruitment.id}}">
										<small ng-bind="recruitment.name"></small></strong></a> <br>
									</strong>
								</td>
								<!-- <td md-cell><strong ng-bind="task.address"></strong></td> -->
								<td md-cell><strong  ng-bind="recruitment.position"></strong></td>
								<td md-cell>
									<strong>{{recruitment.entered_date | date : "dd-MM-yyyy" : 0}}</strong>
								</td>
								<td md-cell>
									<span ng-if="recruitment.status==1">
										<strong ><label class="label label-info">Awaiting Review</label></strong>
									</span>
									<span ng-if="recruitment.status==2">
										<strong ><label class="label label-warning">Reviewed</label></strong>
									</span>
									<span ng-if="recruitment.status==3">
										<strong ><label class="label label-warning">Screened</label></strong>
									</span>
									<span ng-if="recruitment.status==4">
										<strong ><label class="label label-primary">Interviewed</label></strong>
									</span>
									<span ng-if="recruitment.status==5">
										<strong ><label class="label label-success">Hired</label></strong>
									</span>
									<span ng-if="recruitment.status==6">
										<strong ><label class="label label-danger">Rejected</label></strong>
									</span>
								</td>
								<td md-cell>
									<span>
										<strong ng-bind="recruitment.location"></strong>
									</span>
								</td>
								<td md-cell>
									<p ng-show="recruitment.file_name!=''">
										<img src="<?php  echo base_url('assets/img/file_icon.png'); ?>" style="height: 40%; width: 40%"/>
									</p>
									<p ng-show="recruitment.file_name == ''">-</p>
								</td>
							</tr>
						</tbody>
					</table>
				</md-table-container>
				<md-table-pagination ng-show="recruitments.length > 0" md-limit="recruitment_list.limit" md-limit-options="limitOptions" md-page="recruitment_list.page" md-total="{{recruitments.length}}" ></md-table-pagination>
				<md-content ng-show="!recruitments.length" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
			</div>
		</md-content>
	</div>

  <form action="recruitment/createcandidate" method="POST" enctype="multipart/form-data">
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
          <label><?php echo 'Applicant Name'?></label>
          <input required type="text" name="applicant_name" class="form-control" id="applicant_name">
        </md-input-container>
    	<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('gender'); ?></label>
			<md-select  name="gender" ng-model="gender" style="min-width: 200px;" required="" >
				<md-option ng-value="gender.name" ng-repeat="gender in gender">{{gender.name}}</md-option>
			</md-select><br>
		</md-input-container>
		<div class="input-group">
			<input type="text" name="entered_date" class="form-control" id="entered_date" required="" aria-invalid="true" style=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
		</div>
		<md-input-container class="md-block">
			<label><?php echo lang('mobile_number') ?></label>
			<input type="text" name="phone" class="form-control" id="title" required>
		</md-input-container>
        <md-input-container class="md-block">
          <label><?php echo 'Positon Applied For' ?></label>
          <input required type="text" name="position_applied_for" class="form-control" id="position_applied_for" >
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
			 <label><?php echo 'Status' ?></label>
			<md-select required ng-model="status" name="status" style="min-width: 200px;">
				<md-option ng-value="status.id" ng-repeat="status in statuss">{{status.name}}</md-option>
			</md-select><br>
		</md-input-container>
        
         <md-input-container class="md-block">
          <label><?php echo 'Location' ?></label>
          <input type="text" name="location" class="form-control" id="location">
        </md-input-container>
		<md-input-container class="md-block">
		  <label><?php echo lang('homeaddress') ?></label>
		  <textarea rows="2" name="homeaddress" class="form-control" required></textarea>
		</md-input-container>
		<div class="col-sm-12">
		<label><?php echo 'Upload Resume (Please upload only docx files)' ?></label>
          <input type="file" name="file" class="form-control" id="file" required>
		</div>
		
      </md-content>
      <md-content>
      
          <?php if (check_privilege('recruitment', 'create')) { ?>
			 <input type="submit" name="add"  class="btn btn-success col-md-12"  value="Add">
          <?php }?>
          <br/><br/><br/><br/>
        
      </md-content>
	   
    </md-content>
    </md-content>
	
  </md-sidenav>
  </form>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/bootstrap-datepicker.min.css'); ?>">
<!-- datepicker -->
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<script src="~/scripts/jquery-1.10.2.js"></script>

<script  type = "text/javascript">
$(document).ready(function() {
		$('#entered_date').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			 orientation: "bottom right",
			 autoclose: true,
	    });
	});
var CandidateID=0;
var statusold=0;
var recruitment_status=0;
var files1='';
var filetype='';
function select_status(val,id){
	var status = val;
	if(val == 6){
		$('#status'+id+'').attr('data-toggle',"modal");
		 $("body").append('<div id="myModal" class="modal fade" role="dialog"><div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Please enter remarks for rejection</h4></div><div class="modal-body"> <div class="col-sm-3"><input type="text" name="rejected_remarks" id="rejected_remarks'+id+'" class="form-control"/></div></div><div class="modal-footer"><button type="button" class="btn btn-default" onclick="add_remarks('+id+','+val+');">Add</button><button type="button" class="btn btn-default"  onclick="modal_close('+id+');">Close</button></div></div></div></div>');
	}
	else{
	
		$.ajax({
              url : "<?php echo base_url(); ?>recruitment/update_status",
              data:{id : id , status : status},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	}
               
            
	
}
function add_remarks(id,val){
	var remarks = $('#rejected_remarks'+id+'').val();
	var id = id;
	var status = val;
	 $.ajax({
              url : "<?php echo base_url(); ?>recruitment/update",
              data:{id : id,remarks : remarks,status : status},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
}
function modal_close(id){
	
	window.location.reload();
}

</script>

