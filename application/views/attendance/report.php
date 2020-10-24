<style>
   .custom-table{border-collapse:collapse;width:100%;border:solid 1px #c0c0c0;font-family:open sans;font-size:11px}
            .custom-table th,.custom-table td{text-align:left;padding:8px;border:solid 1px #c0c0c0}
            .custom-table th{color:#000080}
            .custom-table tr:nth-child(odd){background-color:#f7f7ff}
            .custom-table>thead>tr{background-color:#dde8f7!important}
            .tbtn{border:0;outline:0;background-color:transparent;font-size:13px;cursor:pointer}
            .toggler{display:none}
            .toggler1{display:table-row;}
            .custom-table a{color: #0033cc;}
            .custom-table a:hover{color: #f00;}
            .page-header{background-color: #eee;}
</style>

<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>


<div class="ciuis-body-content" ng-controller="Attendance_Controller">
 <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12" layout="row" layout-wrap>
      <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
          <?php $path = $this->uri->segment( 3 ); ?>
    <div class="panel-heading"> <strong><?php echo 'Attendance'; ?></strong> <span class="panel-subtitle"><?php //echo lang('tasksituationsdesc'); ?></span>  <select class="form-control" name="filter_type" id="filter_type" onchange="select_filter(this.value)">
             <option value="1" <?php if($path == 1) {  echo 'selected="selected"'; } ?>>Today</option>
             <option value="2" <?php if($path == 2) {  echo 'selected="selected"'; } ?>>Yesterday</option>
         </select> </div>
		<div class="row" style="padding: 0px 20px 0px 20px;">
		  <div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
			  <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="tasks.length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
			  <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{ tasks.length / tasks.length }}%;"></span> </span> </div>
			<span style="color:#989898"><?php echo lang('All'); ?></span> </div>
		  <div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
			  <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{type:'business'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
			  <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{type:'business'}).length * 100 / tasks.length }}%;"></span> </span> </div>
			<span style="color:#989898"><?php echo lang('Companies'); ?></span> </div>
		  <div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
			  <h3 class="text-bold ciuis-task-stat-title"> <span class="task-stat-number" ng-bind="(tasks | filter:{type:'person'}).length"></span> <span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('Contacts') ?>'"></span> </h3>
			  <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{type:'person'}).length * 100 / tasks.length }}%;"></span> </span> </div>
			<span style="color:#989898"><?php echo lang('Persons'); ?></span> </div>
		 
		</div>
	</div>
    <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
			<div class="md-toolbar-tools bg-white">
			<h2 flex md-truncate class="text-bold"><?php echo 'Attendance Report'; ?> <br></h2>
			<div class="ciuis-external-search-in-table">
			  <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contacts').' '.lang('name')   ?>">
			</div>
			<md-menu>
			<md-button aria-label="Convert" class="md-icon-button" ng-click="$mdMenu.open($event)" ng-cloak>
				  <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
				</md-button>
			 <md-menu-content width="4">
			 <md-menu-item>
			  <a href="<?php echo base_url('attendance/create');?>">Manual Entry</a>
			  </md-menu-item>
			  <md-menu-item>
			  <a href="<?php echo base_url('workshift');?>">Work Shift</a>
			  </md-menu-item>
			  <md-menu-item>
			  <a href="<?php echo base_url('attendance/report');?>">Generate Report</a>
			  </md-menu-item>
			   </md-menu-content>
		  </div>
		  <md-content>
        <div id="attendanceReport">
            <div  class="bg-white">
				<md-table-container>
					<table md-table class="custom-table" md-progress="promise" ng-cloak>
						<thead md-head>
						  <tr md-row>
							<th md-column><span><?php echo 'Date'; ?></span></th>
							<th md-column><span><?php echo 'Punch In'; ?></span></th>
						   <th md-column><span><?php echo 'Punch Out'; ?></span></th>
							<th md-column><span><?php echo 'Status' ?></span></th> 
							<th md-column><span><?php echo 'Working Hours' ?></span></th> 
							<th md-column><span><?php echo 'Overtime' ?></span></th> 				
						  </tr>
						</thead>
						<!--<tbody md-body>
							<?php foreach($finalData as $key => $eachData)  { ?>
								<tr data-toggle="collapse" data-target="#<?php echo $key;?>" class="accordion-toggle">
									<td colspan="6"><?php echo $key;?></td>
								</tr>
								<?php foreach($eachData as $eachChildKey => $eachChildData)  { ?>
								<tr>
									<td class="accordion-body collapse" id="<?php echo $key?>">
									<td><?php echo $eachChildKey;?></td>
									<td><?php echo $eachChildData['PunchInTime'];?></td>
									<td><?php echo $eachChildData['PunchInTime'];?></td>
									<td><?php echo $eachChildData['PunchInTime'];?></td>
									<td><?php echo $eachChildData['PunchInTime'];?></td>
									<td><?php echo $eachChildData['PunchInTime'];?></td>
								</tr>
								<?php } ?>
							<?php } ?>
							
                
						</tbody>-->
						<?php foreach($finalData as $key => $eachData)  { ?>
						<tbody>
							<tr>
								<td colspan="20" class="page-header"><button type="button" class="tbtn"><i class="fa fa-plus-circle"></i><?php echo $key ?></button> </td>
							</tr>
						<?php foreach($eachData as $eachChildKey => $eachChildData)  { ?>
							<tr class="toggler toggler1">
								<td class="accordion-body collapse" id="<?php echo $key?>">
								<td><?php echo date('d M Y', strtotime($eachChildKey));?></td>
								<td><?php echo $eachChildData['PunchInTime'].'<br/>'.$eachChildData['Instatus'];?></td>
								<td><?php echo $eachChildData['PunchOutTime'].'<br/>'.$eachChildData['Outstatus'];?></td>
								<td><?php echo $eachChildData['Status'];?></td>
								<td><?php echo $eachChildData['WorkingHours'];?></td>
								<td><?php echo $eachChildData['OTHours'];?></td>
							</tr>
						<?php } ?>
						<?php } ?>
					</tbody>
          </table>
        </md-table-container>
       <!-- <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php //echo lang('notdata') ?></md-content> -->
      </div>
      </div>
    </md-content>
	</div>
</div>
</div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/attendance.js'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> 
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<script type="text/javascript">
	$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});

 $(document).ready(function () {
	$(".tbtn").click(function () {
		$(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
		$(this).parents("tbody").find(".toggler").addClass("toggler1");
		$(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
		$(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
	});
				
$(".custom-table").find(".toggler1").removeClass("toggler1");

$(".custom-table .fa-minus-circle").click(function() {
	$(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
});
});
</script>