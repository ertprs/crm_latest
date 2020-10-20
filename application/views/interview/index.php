<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content">
  <div class="main-content container-fluid col-xs-16 col-md-16 col-lg-16" layout="row" layout-wrap>
    <md-toolbar ng-show="!customersLoader" class="toolbar-white" style="margin: 0px 8px 8px 8px;">
    <div class="md-toolbar-tools" >
      <md-button class="md-icon-button" aria-label="File">
        <md-icon><i class="ico-ciuis-staff text-muted"></i></md-icon>
      </md-button>
      <h2 flex md-truncate><?php echo 'Interview Process For Screened Candidates' ?> <small></small></h2>
      <div class="ciuis-external-search-in-table">
        <input ng-model="search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search').' '.lang('staff') ?>">
        <md-button class="md-icon-button" aria-label="Search" ng-cloak>
          <md-icon><i class="ion-search text-muted"></i></md-icon>
        </md-button>
      </div>
      
</div>
  </md-toolbar>
  <br>
  <div ng-show="showGrid==true" class="text-center pagination-center" ng-cloak>
      <!-- <md-content ng-show="!staff.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
      <div class="pagination-div text-center" ng-show="staff.length > 5">
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div> -->
    </div>
  
   
        <md-content flex-gt-xs="100" flex-xs="100"  class="bg-white" ng-cloak style="margin: -20px 10px 20px 30px;">
      <md-table-container >
        <table md-table  md-progress="promise" id="myTable">
          <thead md-head>
            <tr md-row>
              <th md-column><span>#</span></th>
			   <th md-column><span>Applicant Name </span></th>
              <th md-column><span>Position Applied For</span></th>
			   <th md-column><span>Date</span></th>
			   <th md-column><span>Status</span></th>
			   <th md-column><span>Schedule Interview</span></th>
              <th md-column><span>Location</span></th>
			  <th md-column><span>Rejected Remarks</span></th>
			<th md-column><span>View</span></th>
			
              
              
            </tr>
          </thead>
          <tbody md-body>
		  <?php $i = 1;
		  foreach($candidates as $cand) { ?> 
            <tr>
              <td md-cell>
                <?php echo $i; ?>
              </td>
			   <td md-cell>
                <?php echo $cand['applicant_name']; ?>
              </td>
			   
			  
              <td md-cell>
                 <?php echo $cand['position_applied_for']; ?>
              </td>
			   <td md-cell>
                
				<?php echo $cand['entered_date']; ?>
              </td>
			   <td md-cell>
                <div>
				<select name="status" class="form-control"  data-target="#myModal"  onchange="select_status(this.value,<?php echo $cand['candidate_id']; ?>)" id="status<?php echo $cand['candidate_id']; ?>"  >
					<option value="1" <?php if($cand['status'] == '1'){  echo 'selected="selected"';  } ?> >Awaiting Review</option>
				   <option value="2" <?php if($cand['status'] == '2'){  echo 'selected="selected"';  } ?> >Reviewed</option>
				   <option value="3" <?php if($cand['status'] == '3'){  echo 'selected="selected"';  } ?> >Screened</option>
				   <option value="4" <?php if($cand['status'] == '4'){  echo 'selected="selected"';  } ?> >Interviewed</option>
				   <option value="5" <?php if($cand['status'] == '5'){  echo 'selected="selected"';  } ?> >Hired</option>
				   <option value="6" <?php if($cand['status'] == '6'){  echo 'selected="selected"';  } ?> >Rejected</option>
		   </select>
				</div>
              </td>
			  <td>
			  <a href="#" id="sch<?php echo $cand['candidate_id']; ?>" onclick="add_interview(<?php echo $cand['candidate_id']; ?>)" data-target="#interview" >Schedule Interview</a>
			  </td>
              <td md-cell>
                <?php echo $cand['location']; ?>
              </td>
              <td md-cell>
                 <?php echo $cand['rejected_remarks']; ?>
              </td>
             <td md-cell>
		
		<?php if($cand['file_name'] != ''){ ?>
         
			<a href="<?php  echo base_url('uploads/files/candidates/'.$cand['candidate_id'].'/'.$cand['file_name'].''); ?>" >View</a>
			<?php  } ?>

		</td>
             
            </tr>
		  <?php $i++; } ?>
          </tbody>
        </table>
      </md-table-container>
      <!-- <md-table-pagination ng-show="staff.length > 0" md-limit="staff_list.limit" md-limit-options="limitOptions" md-page="staff_list.page" md-total="{{staff.length}}" ></md-table-pagination>
    --> </md-content>
    
  </div>
 <?php /* <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
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
  </div> */ ?>
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
        <md-input-container class="md-block">
          <label><?php echo 'Positon Applied For' ?></label>
          <input required type="text" name="position_applied_for" class="form-control" id="position_applied_for" >
        </md-input-container>
        
          <label><?php echo 'Status' ?></label>
          <select type="text" name="status" class="form-control" id="status" >
		  <option value="1">Awaiting Review</option>
		   <option value="2">Reviewed</option>
		   <option value="3">Screened</option>
		   <option value="4">Interviewed</option>
		   <option value="5">Hired</option>
		   <option value="6">Rejected</option>
		  </select>
        
               <md-input-container class="md-block">
          <label><?php echo 'Date' ;?></label>
           <input type="date" required name="entered_date"  ngstyle="width: 200px !important;" >
        </md-input-container >
         <md-input-container class="md-block">
          <label><?php echo 'Location' ?></label>
          <input type="text" name="location" class="form-control" id="location">
        </md-input-container>
		<div class="col-sm-6">
		<label><?php echo 'Upload Resume (Please upload only docx files)' ?></label>
          <input type="file" name="file" class="form-control" id="file" required="">
		</div>
		
      </md-content>
	 
      <custom-fields-vertical></custom-fields-vertical>
      <md-content>
      
          <?php if (check_privilege('recruitment', 'create')) { ?>
<div class="col-sm-3" style="margin-left:40%;">
			 <button  name="add" Value="add" style="margin-top: 40px;" >ADD</button>
</div>			 
          <?php }?>
          <br/><br/><br/><br/>
        
      </md-content>
	   
    </md-content>
    </md-content>
	
  </md-sidenav>
  </form>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<script src="~/scripts/jquery-1.10.2.js"></script>

<!-- #region datatables files -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script  type = "text/javascript">
$('document').ready(function() { 
    
    	$('#myTable').DataTable({
	    
	    "paging": true,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "info": true,
              "autoWidth": false,
	    
	});
});
function select_status(val,id){
	var status = val;
	if(val == 6){
		$('#status'+id+'').attr('data-toggle',"modal");
		 $("body").append('<div id="myModal" class="modal fade" role="dialog"><div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Please enter remarks for rejection</h4></div><div class="modal-body"> <div class="col-sm-3"><input type="text" name="rejected_remarks" id="rejected_remarks'+id+'" class="form-control"/></div></div><div class="modal-footer"><button type="button" class="btn btn-default" onclick="add_remarks('+id+','+val+');">Add</button><button type="button" class="btn btn-default"  onclick="modal_close('+id+');">Close</button></div></div></div></div>');
	}
	else{
	
		$.ajax({
              url : "<?php echo base_url(); ?>interview/update_status",
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
              url : "<?php echo base_url(); ?>interview/update",
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
function add_interview(id){
	var status = $('#status'+id+'').val();
	$('#sch'+id+'').attr('data-toggle',"modal");
		 $("body").append('<div id="interview" class="modal fade" role="dialog"><div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Interview Schedule Timings</h4></div><div class="modal-body"><div class="row"><div class="col-sm-6"><label>Schedule Date:</label><input type="date" name="schedule_date" id="schedule_date'+id+'" class="form-control"/></div></div><div class="row"><div class="col-sm-3"><label>From Time</label><input type="text" name="from_time" id="from_time'+id+'" class="form-control"/></div></div><div class="row"><div class="col-sm-3"><label>To Time</label><input type="text" name="to_time" id="to_time'+id+'" class="form-control"/></div></div><div class="row"><div class="col-sm-3"><label>Interview Taken By</label><input type="text" name="interview_taken_by" id="interview_taken_by'+id+'" class="form-control"/></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" onclick="add_interview_details('+id+','+status+');">Add</button><button type="button" class="btn btn-default"  onclick="modal_close('+id+');">Close</button></div></div></div></div>');
	
}
function add_interview_details(id,status){
	var schedule_date = $('#schedule_date'+id+'').val();
	var from_time = $('#from_time'+id+'').val();
	var to_time = $('#to_time'+id+'').val();
	var interview_taken_by = $('#interview_taken_by'+id+'').val();
 	var id = id;
	var status =status;
	 $.ajax({
              url : "<?php echo base_url(); ?>interview/add",
              data:{id : id, schedule_date : schedule_date, from_time : from_time,to_time : to_time, interview_taken_by : interview_taken_by, status : status },
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
}
</script>

