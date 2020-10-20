<style>
.pen body {
	padding-top:50px;
}

/* Social Buttons - Twitter, Facebook, Google Plus */
.btn-twitter {
	background: #00acee;
	color: #fff
}
.btn-twitter:link, .btn-twitter:visited {
	color: #fff
}
.btn-twitter:active, .btn-twitter:hover {
	background: #0087bd;
	color: #fff
}

.btn-instagram {
	color:#fff;
	background-color:#3f729b;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:focus,.btn-instagram.focus {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:hover {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}

.btn-github {
	color:#fff;
	background-color:#444;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:focus,.btn-github.focus {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:hover {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}

/* MODAL FADE LEFT RIGHT BOTTOM */
.modal.fade:not(.in).left .modal-dialog {
	-webkit-transform: translate3d(-25%, 0, 0);
	transform: translate3d(-25%, 0, 0);
}
.modal.fade:not(.in).right .modal-dialog {
	-webkit-transform: translate3d(25%, 0, 0);
	transform: translate3d(25%, 0, 0);
}
.modal.fade:not(.in).bottom .modal-dialog {
	-webkit-transform: translate3d(0, 25%, 0);
	transform: translate3d(0, 25%, 0);
}

.modal.right .modal-dialog {
	position:absolute;
	top:0;
	right:0;
	margin:0;
}

.modal.left .modal-dialog {
	position:absolute;
	top:0;
	left:0;
	margin:0;
}

.modal.left .modal-dialog.modal-sm {
	max-width:300px;
}

.modal.left .modal-content, .modal.right .modal-content {
    min-height:100vh;
	border:0;
}

.modal-header {
   
    background-color: #000000	;

 }
h4 .modal-title {
    color: white;
  }
</style>

<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<style>
.selectpicker > .dropdown .dropdown-menu {
	padding:5px;
}
</style>
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
        <h2 flex md-truncate class="text-bold"><?php echo 'Attendance'; ?> <br>
        
         </h2>
        
        <div class="ciuis-external-search-in-table">
          <input ng-model="task_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by').' '.lang('contacts').' '.lang('name')   ?>">
         <!--  <md-button class="md-icon-button" aria-label="Search" ng-cloak>
            <md-tooltip md-direction="bottom"><?php //echo lang('search').' '.lang('contacts') ?></md-tooltip>
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button> -->
        </div>
        <md-button onclick="update()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo 'Filter Attendance'?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
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
		   </md-menu>
           
      </div>
    </md-toolbar>   
    <md-content>
        <div id="mytable">
              <div  class="bg-white">
        <md-table-container>
          <table md-table  md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo 'Date'; ?></span></th>
                 <th md-column md-order-by="address"><span><?php echo 'Employee'; ?></span></th> 
				
                <th md-column md-order-by="cperson"><span><?php echo 'Time In'; ?></span></th>
               <th md-column md-order-by="cnum"><span><?php echo 'Time Out'; ?></span></th>
                <th md-column md-order-by="cemail"><span><?php echo 'Status' ?></span></th> 
				  <th md-column md-order-by="cemail"><span><?php echo 'Working Hours' ?></span></th> 
				   <th md-column md-order-by="cemail"><span><?php echo 'Overtime' ?></span></th> 
			
              </tr>
            </thead>
            <tbody md-body>
                
                <?php foreach($attend_details as $details) {   ?>
                <tr class="select_row" md-row >
                <td md-cell><?php echo date('d-m-Y',strtotime($attendance_date));?></td>
                 <td md-cell><?php echo $details["staffname"];?></td>
                 <?php $days = explode(',',$details["day"]);  ?>
                  <td md-cell><?php if($days["0"] != '') {echo date("h:i:a",strtotime($days["0"])); } ?></td>
                   <td md-cell><?php if($days["1"] != ''){echo date("h:i:a",strtotime($days["1"]));}?></td>
                   <td md-cell><?php if($details["day_status"] == 'P'){ echo 'Present'; } else { echo 'Absent'; }   ?></td>
                    <td md-cell><?php $time1 = strtotime($days["1"]);
$time2 = strtotime($days["0"]);
if($time1 != ''){
$difference = round(abs($time2 - $time1) / 3600,2);
echo $difference; } else { echo '-'; } ?></td>
<?php 
$ci =& get_instance();
$ci->load->model('Attendance_Model');
$timings = $ci->Attendance_Model->get_attendance_time($details["staff_id"]);

 //$this->load->model("Attendance_Model");
//$timings = $this->Attendance_Model->get_attendance_time($details["staffid"]); 

?>

<td md-cell><?php  
    if($days["0"] >= $timings['late_in_count_time'] ) { echo '<font color="red"><b>Late In</b></font>' ; } 
    else if($days["0"] < $timings['start_time']) {
        echo '<font color="Yellow"><b>Early In</b></font>' ;
    }
        else { echo '<b><font color="green">Ok</b></font>'; } ?>/<?php  
        if($days["1"] >= $timings['late_out_count_time'] ){ echo '<b><font color="red">Late Out</font></b>' ; }
        else if( $days["1"] >= $timings['end_time'] && $days["1"] < $timings['late_out_count_time']) { echo '<b><font color="green">Ok</font></b>'; } 
        else if ($days["1"] < $timings['end_time'] && $days["1"] != '' )  { echo '<b><font color="red">Early Out</font></b>'; }  else if($days["1"] == '') { echo '<b><font color="black">-</font></b>';  } ?></td>
                    </tr>
                <?php } ?>
                
             </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="tasks.length > 0" md-limit="task_list.limit" md-limit-options="limitOptions" md-page="task_list.page" md-total="{{tasks.length}}" ></md-table-pagination>
       <!-- <md-content ng-show="!tasks.length" class="md-padding no-item-data" ng-cloak><?php //echo lang('notdata') ?></md-content> -->
      </div>
      </div>
    </md-content>    
  </div>
    </div>
  
 <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">

<div class="modal-body">

<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>

   
<div id="attn_info">
       
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

<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
 <script>
 function update(){
	  $.ajax({
              url : "<?php echo base_url(); ?>attendance/search_atten",
              data:{},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				  $('#update_details').html(response);
	 $("#sidebar-right").modal ("show");
	 $('#emps').select2({ });
	  $('#depts').select2({ });
	 
	 var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
			  }
	  });
 }
 
 function select_employee(val){
	if(val=='0'){
            $(".emps > option").prop("selected","selected");
            //$(".dep").trigger("change");
	}
			
}
function select_department(val){
	var deps = [];
	if(val=='0'){
            $(".dep > option").prop("selected","selected");
            //$(".dep").trigger("change");
			$. each($(".dep option:selected"), function(){
				if($(this). val() != '0'){
deps. push($(this). val());
				}
});

	}else{
	
$. each($(".dep option:selected"), function(){
deps. push($(this). val());
});

	}
//alert(deps);
 $.ajax({
              url : "<?php echo base_url(); ?>attendance/get_employees",
              data:{deps : deps},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				$('#emp').html(response);
$('#employee_id').select2({ });
				
			  }
 }) 
	
}	
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
      
      
    })
	
	function get_attendance(){
	    var department = $('#department').val();
	    var from_date = $('#from_date').val();
	   var to_date = $('#to_date').val();
	   $.ajax({ 
				type: "POST",
		
				url:'<?php echo base_url(); ?>attendance/summary',
				data: {department:department,from_date:from_date,to_date:to_date}
			}).done(function( data ) {//alert(data);
				$( "#attn_info").html( data );
				$('#example').DataTable();
			 });
	
		// url = "<?php echo base_url(); ?>attendance/create?id="+department+"&date="+attendance_date;
		
	
		//window.location.href =  url;
		
	}
	
	function select_filter(val){
	    //alert(val);
	    window.location.href = '<?php echo base_url(); ?>attendance/index/'+val;

	    /* var filter_type = val;
	       $.ajax({ 
				type: "POST",
		
				url:'<?php //echo base_url(); ?>attendance/index/'+filter_type,
				 cache       : false,
        contentType : true,
        processData : true,
			success: function(response) {
			   // alert(response)
				$( "#mytable").html( response );
					 //$("#mytable").appendTo("body");

				//window.location.reload();
					// $("#mytable").appendTo("body");
				 
			 }
	       }); */
	}
	
</script>
