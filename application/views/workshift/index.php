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

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Off'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'On'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }


</style>
<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Workshift_Controller">

  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9" layout="row" layout-wrap>
    <md-toolbar ng-show="!customersLoader" class="toolbar-white" style="margin: 0px 8px 8px 8px;">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" aria-label="File">
        <md-icon><i class="ico-ciuis-staff text-muted"></i></md-icon>
      </md-button>
      <h2 flex md-truncate><?php echo 'Workshift'; ?> </h2>
      <div class="ciuis-external-search-in-table">
        <input ng-model="search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search').' '.lang('staff') ?>">
        <md-button class="md-icon-button" aria-label="Search" ng-cloak>
          <md-icon><i class="ion-search text-muted"></i></md-icon>
        </md-button>
      </div>
      <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
     
      <?php if (check_privilege('material', 'create')) { ?>
        <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('create'); ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>
      <?php }?>
    </div>
  </md-toolbar>
  <br>
    <div ng-show="showGrid==true" flex-gt-xs="33" flex-xs="100" ng-repeat="member in staff | filter:search | pagination : currentPage*itemsPerPage | limitTo: 6" style="padding: 0px;margin: 0px" ng-cloak>
      <md-card md-theme-watch style="margin-top:0px"> 
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
         <md-card-actions layout="row" layout-align="end center">
          <md-button ng-click="ViewStaff(member.id)"><?php echo lang('view')?></md-button>
        </md-card-actions>
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
             <th md-column><span>Work Shift Name</span></th>
         <th md-column><span>Work Shift </span></th>
          
			<th md-column><span>Start Time</span></th>
              <th md-column><span>End Time</span></th>
			  <!--  <th md-column><span>Late Count Time</span></th> -->
         
         
              <th md-column ><span><?php echo lang('Action'); ?></span></th>
              
              <!-- <th md-column md-order-by="total"><span><?php //echo lang('amount'); ?></span></th> -->
            </tr>
          </thead>
		  
          <tbody md-body>
              <?php //print_r($staff); ?>
            <tr class="select_row" md-row ng-repeat="member in staff | orderBy: staff_list.order | filter: search |  limitTo: staff_list.limit : (staff_list.page -1) * staff_list.limit | filter: FilteredData">
                 <td md-cell>
                   {{member.shift_ref}}
              
              </td>
              <td md-cell >
			   <div id="{{member.id}}" onclick="shiftview(this.id)" class="table-icon deleteIcon"><a class="link cursor">{{member.name}}</a></div>

              </td>
           
        
              <td md-cell>
                   {{member.start_time}}
              
              </td>
        
         <td md-cell>
               {{member.end_time}}
              </td>
             
              
              
              <td md-cell>
                 
         
<div id="inline">
     <div class="col-sm-3" id="{{member.id}}" onclick="update(this.id)"><i class="ion-compose  text-muted"></i></div>
 <div class="col-sm-3" id="{{member.id}}" onclick="deleteshift(this.id)"><i class="ion-trash-b text-muted"></i></div>
          
            

</div>
              </td>
              
			  
            </tr>
          </tbody>
        </table>
      </md-table-container>
      <md-table-pagination ng-show="staff.length > 0" md-limit="staff_list.limit" md-limit-options="limitOptions" md-page="staff_list.page" md-total="{{staff.length}}" ></md-table-pagination>
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
      <div ng-repeat="(prop, ignoredValue) in staff[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'name' && prop != 'start_time' && prop != 'end_time'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
		  
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
		  <?php //$depts = explode(',',prop); ?>
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>

  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
    
   
 

     

    <!-- <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate><?php //echo lang('doc_category') ?></h2>
        <?php //if (check_privilege('staff', 'create')) { ?>
          <md-button ng-click="NewDepartment()" class="md-icon-button" aria-label="Department" ng-cloak>
            <md-tooltip md-direction="left"><?php //echo lang('addCategory') ?></md-tooltip>
            <md-icon><i class="ion-android-add text-muted"></i></md-icon>
          </md-button>
        <?php //} ?>
      </div>
    </md-toolbar> 
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item ng-repeat="doccat in docscat" ng-click="EditDepartment($index)" aria-label="Project">
          <p><strong ng-bind="doccat.name"></strong></p>
          <?php //if (check_privilege('staff', 'delete')) { ?>
            <md-button ng-click="DeleteDepartment($index)" class="md-icon-button" aria-label="Create">
              <md-tooltip md-direction="bottom"><?php //echo lang('delete') ?></md-tooltip>
              <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>
          <?php //} ?>
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!docscat.length" class="md-padding bg-white no-item-data" ng-cloak><?php //echo lang('notdata') ?></md-content>
    </md-content>
	-->
	
	<!-- <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools"> 
        <h2 class="md-pl-10" flex md-truncate>Unit Type</h2>
        <?php //if (check_privilege('staff', 'create')) { ?>
          <md-button ng-click="NewUnitType()" class="md-icon-button" aria-label="Unit Type" ng-cloak>
            <md-tooltip md-direction="left">Add Unit Type</md-tooltip>
            <md-icon><i class="ion-android-add text-muted"></i></md-icon>
          </md-button>
        <?php //} ?>
      </div>
    </md-toolbar>
    <md-content class="bg-white">
      <md-list flex class="md-p-0 sm-p-0 lg-p-0" ng-cloak>
        <md-list-item ng-repeat="unittype in unittypes" ng-click="EditUnit($index)" aria-label="Unit">
          <p><strong ng-bind="unittype.name"></strong></p>
          <?php //if (check_privilege('staff', 'delete')) { ?>
            <md-button ng-click="DeleteUnit($index)" class="md-icon-button" aria-label="Create">
              <md-tooltip md-direction="bottom"><?php //echo lang('delete') ?></md-tooltip>
              <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
            </md-button>
          <?php //} ?>
          <md-divider></md-divider>
        </md-list-item>
      </md-list>
      <md-content ng-show="!unittypes.length" class="md-padding bg-white no-item-data" ng-cloak><?php //echo lang('notdata') ?></md-content>
    </md-content>   -->
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
</div>
   <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
       <form id="form1" method="post" action="<?php echo base_url('workshift/create');?>">
           
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo 'Create Workshift' ?></h2>
       <!--  <md-switch ng-model="staff.active" aria-label="Type"><strong class="text-muted"><?php //echo lang('active') ?></strong></md-switch> -->
       <!--- <div class="form-group">
               <label for="others">Others</label>
               <label class="switch">
  <input type="checkbox" checked>
  <span class="slider round"></span>
</label>
           </div>  -->
          
      </div>
    </md-toolbar>
   
    <md-content>
      <md-content layout-padding>
      <!-- <div class="outerDivFull" >
     <div>Department</div>          
<div class="switchToggle">

    <input type="checkbox" id="switch" name="status" checked onclick="select_switch()">
    <label for="switch">Toggle</label>
   
</div>


</div> -->
	<div class="form-group">
	    <label for="shift_ref">Workshift Name</label>
	    <input type="text" name="shift_ref" id="shift_ref" class="form-control" required>
	</div>
  <div class="form-group" id="dept">
    <label for="category">Departments</label>
    <select class="form-control dep" multiple id="department" name="department[]" onchange="select_department(this.value)" style="min-width: 200px;" data-width="100%">
<option value="all">Select  all</option>
	<?php if(isset($departments)){
		foreach($departments as $eachCat){?>
		<option value="<?php print $eachCat['id'];?>"><?php print $eachCat['name'];?></option>
		<?php }?>
	<?php }?>
    </select>
  </div>
  <div class="form-group" id="emp" >
    <label for="employees">Employees</label>
    <select class="form-control emps" multiple id="employee_id" name="employee_id[]" onchange="select_employee(this.value)" style="min-width: 200px;" data-width="100%">
	<option value="all">Select  all</option>
	<?php if(isset($staff)){
		foreach($staff as $emp){?>
		<option value="<?php print $emp['id'];?>"><?php print $emp['staffname'];?></option>
		<?php }?>
	<?php }?>
    </select>
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">Workshift</label>
    <select class="form-control" id="shift_name" placeholder="Shift Name" name="name"  required >
	<option value="1">Day Shift</option>
	<option value="2"> Night Shift</option>
	</select>
  </div>
  <div class="row">
   <div class="form-group col-sm-6">
    <label for="">Start Time</label>
	<input type="time" class="form-control" id="start_time"  name="start_time" value="" required>
	
	
  </div>
  
  <div class="form-group col-sm-6">
    <label for="">End Time</label>
	<input type="time" class="form-control" id="end_time"  name="end_time" value="" required>
 
  </div>
  </div>
  <div class="row">
  <div class="form-group col-sm-6">
    <label for="">Grace Period (In Mins)</label>
	<input type="text" class="form-control" id="late_in_count_time"  name="late_in_count_time" value="" required>
 
  </div>
  <!-- <div class="form-group col-sm-6">
    <label for="">Late Out  Count Time</label>
	<input type="time" class="form-control" id="late_out_count_time"  name="late_out_count_time" value="" required>
 
  </div> -->
  </div>
<div class="form-group col-md-15 "> 
        <div class="field_wrapper row">
    <div class="form-group col-md-15">
   
	 <div id="div1-wrapper">
	 
          <div id="div1" class="col-md-5" > 
 <label for="exampleInputPassword1">Break</label>
 <input type="text" class="form-control " name="supp[breakname][]" id="break0" placeholder="Break Name" autocomplete="off" required>

          </div>
		  <div class="form-group col-md-5 row"><label for="exampleInputFile">Start Time</label><input type="time" name="supp[start_time][]"  id="start_time0" title="start_time0" aria-describedby="" class="form-control" required>
        </div> 
		<div class="form-group col-md-5 "><label for="exampleInputFile">End Time</label><input type="time" name="supp[end_time][]"  id="end_time0" title="Price" aria-describedby="" class="form-control" required></div>
	
	
	
  </div>
    
  
 
    <div>
             </div> 
</div>
</div>

 <div class="form-group col-md-6">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
  
  <input type="submit" class="btn btn-success col-md-12"  value="Add">
</form>
      </md-content>
     
    </md-content>
  </md-sidenav>
  
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/workshift.js?v=1'); ?>"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<style>
#inline{height:auto;display:flex;}
.one,.two{width:30%;height:100px;margin:10px;}
.ion-trash-b{font-size:20px;}
.ion-compose{font-size:20px;}
</style>

  <script>
 
function select_code(value){
    
    var item_code = value;
    
    
    	 $.ajax({
              url : "<?php echo base_url(); ?>material/validate_itemcode",
              data:{item_code : item_code},
              method:'POST',
              dataType:'json',
              success:function(response) {
                 // alert(response.item_code);
             if(response.item_code != null){
                 alert("Enetered Item Code is already exists");
                 $('#item_code').val('');
             }
            }
          }); 
}

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
					$('#image_preview').append("<div class='col-md-3' id='clients-edit-wrapper'><div class='close-wrapper'> <a  class='close-div text-danger'>Delete</a></div><input type='hidden' name='test_image[]' value='"+response.image_name+"'><a href='<?php print base_url();?>uploads/images/"+response.image_name+"' target='_blank' class='text-success'>View<a/></div>");
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

	function supplierModal(str)
	{
		
		 $.ajax({
            url: '<?php print base_url();?>material/form_supplier/'+str,
			 type        : 'post',
            cache       : false,
        contentType : true,
        processData : true,
        
            success: function(response){
				$('#supplier_details').html(response);
				$('#exampleModal').modal('show');
                
            },
        }); 
		
		
	}
	function shiftview(id)
	{
		
		 $.ajax({
            url: '<?php print base_url();?>workshift/view_shift/'+id,
			 type        : 'post',
            cache       : false,
        contentType : true,
        processData : true,
        
            success: function(response){
				$('#material_details').html(response);
				$('#exampleModal1').modal('show');
				 $("#exampleModal1").appendTo("body");
				 
				 
				 
				 
				    $(function() {
           $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-4" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              $("#exampleModal2").appendTo("body");
            });
         }); 
                
            },
        }); 
		
		
	}
	function add_cost(val){
	    var cost = val;
	    var cost_value = val*1.25;
	    $('#last_selling_price').val(cost_value);
	    
	}
	 function select_switch(value){
	  
    if ($('#switch').is(':checked')) {
		$('#emp').hide();
	   $('#dept').show();
	    $('#department').select2({
    
			//tags: true
		});
          
    }else{
		//alert('avc');
        // $("#item_code").prop("disabled", true);
        // $('#item_code').removeAttr('required');
       $('#emp').show();
	   $('#dept').hide();
	   $('#employee_id').select2({
    
			//tags: true
		});
    }

    
} 

$(document).ready(function(){
	$('#department').select2({
	});
$('#employee_id').select2({ });
});
	 $(document).ready(function(){
		
				
 
    
   
    
   
	

});
		 
		         
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
   
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
		
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            var fieldHTML = '<div class="row col-md-15" ><div class="form-group col-md-5"><label for="inputZip">Break </label>';
             fieldHTML += '<input type="text" class="form-control" name="supp[breakname][]" id="break'+x+'"  autocomplete="off"/></div>';
            fieldHTML += '<div class="form-group col-md-5"><label for="exampleInputFile">Start Time</label><input type="time" name="supp[start_time][]"  id="start_time'+x+'" title="" aria-describedby="" class="form-control" required=""></div>';
             fieldHTML +=  '<div class="form-group col-md-5"><label for="exampleInputFile">End Time</label><input type="time" name="supp[end_time][]"  id="end_time'+x+'" title="" aria-describedby="" class="form-control" required=""></div><a href="javascript:void(0);" class="add_button" title="Add field"></a><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div><br>'; 
            //New input field html 
            $(wrapper).append(fieldHTML); //Add field html
			
			  //('#supplier'+x).addClass('selectpicker required');
			  
			  /*
			  $('#supplier'+x).select2({
    
  tags: true
});*/

		}
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        //e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
		return false;
        x--; //Decrement field counter
    });
});



	function deleteshift(id){
             var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>workshift/delete_shift",
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
   
    
    function update(id){
        //alert(id);
               
           	 $.ajax({
              url : "<?php echo base_url(); ?>workshift/edit_shift",
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                  //console.log(response)
                  $('#update_details').html(response);
               $("#sidebar-right").modal ("show");
			   $('#department').select2({ });
			    $('#employee_id').select2({ });
                
               
               
               
		    
         
   var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button1'); //Add button selector
    var wrapper = $('.field_wrapper1'); //Input field wrapper
    var val = $('#count').val();
   
   
    var x = val; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
             var fieldHTML = '<div class="row col-md-12" ><div class="form-group col-md-4"><label for="inputZip">Break</label>';
             fieldHTML += '<input type="text" class="form-control" name="supp[breakname][]" id="break'+x+'" placeholder="Break Name" autocomplete="off"/></div>';
            fieldHTML += '<div class="form-group col-md-4"><label for="exampleInputFile">Start Time</label><input type="time" name="supp[start_time][]" placeholder="" id="start_time'+x+'" title="" aria-describedby="" class="form-control"></div>';
             fieldHTML +=  '<div class="form-group col-md-3"><label for="exampleInputFile">End Time</label><input type="time" name="supp[end_time][]" placeholder="" id="end_time'+x+'" title="Price" aria-describedby="" class="form-control"></div><a href="javascript:void(0);" class="add_button" title="Add field"></a><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div><br>';
            //New input field html 
            $(wrapper).append(fieldHTML); //Add field html
			
		}
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
		//alert('123');
        //e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
		return false;
        x--; //Decrement field counter
    });
         
            }
          });  
	    
    }
    
    $ (document).ready (function () {
	$ (".modal a").not (".dropdown-toggle").on ("click", function () {
		$ (".modal").modal ("hide");
	});
});
</script>

<script>
function select_employee(val){
    
	if(val=='all'){
	    
            $(".emps > option").prop("selected","selected");
           
            //$(".dep").trigger("change");
            
            	$. each($(".emps option:selected"), function(){
				if($(this). val() != 'all'){
var emp = $(this). val();
//alert(emp);
$.ajax({
				  url : "<?php echo base_url(); ?>workshift/validate_employee",
				  data:{emp : emp},
				  method:'POST',
				 //dataType:'json',
				  success:function(response) {
			var obj = jQuery.parseJSON( response );
if(obj.status == '1'){
    
    
    //alert("Employee id already existed"+emp);
}


				  }
	 }) 
				}
});

	}
			else {
				$. each($(".emps option:selected"), function(i, item){
				if($(this). val() != 'all'){
var emp = $(this). val();


$.ajax({
				  url : "<?php echo base_url(); ?>workshift/validate_employee",
				  data:{emp : emp},
				  method:'POST',
				 //dataType:'json',
				  success:function(response) {
			var obj = jQuery.parseJSON( response );
if(obj.status == '1'){
    
    
   $(".emps option[value='"+emp+"']").remove();

$(".emps").val();

}


				  }
	 }) 
				}
});

}
}
function select_department(val){
	var deps = [];
	if(val=='all'){
            $(".dep > option").prop("selected","selected");
            //$(".dep").trigger("change");
			$. each($(".dep option:selected"), function(){
				if($(this). val() != 'all'){
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
              url : "<?php echo base_url(); ?>workshift/get_employees",
              data:{deps : deps},
              method:'POST',
             // dataType:'json',
              success:function(response) {
				$('#emp').html(response);
$('#employee_id').select2({ });
				
			  }
 }) 
	
}	

function edit_department(id,val){
			  var shift_id = id;
		var deps = [];
		if(val=='all'){
            $(".dep > option").prop("selected","selected");
            //$(".dep").trigger("change");
			$. each($(".dep option:selected"), function(){
				if($(this). val() != 'all'){
deps. push($(this). val());
				}
});

	}else{
	$. each($(".dep option:selected"), function(){
	deps. push($(this). val());
	});
	}
	$.ajax({
				  url : "<?php echo base_url(); ?>workshift/get_edit_employees",
				  data:{shift_id : shift_id,deps : deps},
				  method:'POST',
				 // dataType:'json',
				  success:function(response) {
					$('#emp').html(response);
	$('#employee_id').select2({ });
					
				  }
	 }) 

	}	       
               
        function select_shift_type(val){
            var shift_type = val;
            var deps = [];
            	$. each($(".dep option:selected"), function(){
	            deps. push($(this). val());
            	});
            		$.ajax({
				  url : "<?php echo base_url(); ?>workshift/validate_department",
				  data:{shift_type : shift_type,deps : deps},
				  method:'POST',
				 //dataType:'json',
				  success:function(response) {
			alert(response);

				  }
	 }) 
        }
            
           
  </script>
 
       
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>Supplier Details
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="supplier_details"></div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_session()">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>View
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="material_details"></div>
      
      </div>
     
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>View
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="img_details"></div>
      
      </div>
     
    </div>
  </div>
</div>


 <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body form-group">
	
          <div id="pdfdetails"></div>
          
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>
