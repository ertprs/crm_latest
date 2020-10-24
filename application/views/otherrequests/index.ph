<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Otherrequests_Controller">
  <div class="main-content container-fluid col-xs-16 col-md-16 col-lg-16">
    <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="File">
          <md-icon><i class="icon ico-ciuis-projects text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo 'REQUESTS' ?> <small>/ Other Request(<span ng-bind="projects.length"></span>)</small></h2>
		<?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-6">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>

		
        
        
        
      <!--  <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php //echo lang('filter') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button> -->
        
      </div>
    </md-toolbar>
	<md-toolbar class="toolbar-white" style="margin-bottom: 2%;">
      <div >
	  <div class="row col-sm-12" >
        <form  id="edit_form" method="post" action="otherrequests/create" enctype='multipart/form-data'> 
	
	 <div class="col-sm-3 form-group">
	   <label><?php echo "Description" ?></label>
          <textarea required type="text" 
		  class="form-control" id="description" name="description" placeholder="Enter Description Here"rows="1" cols="10"required="" ></textarea>
	</div>
	<div class="col-sm-1 form-group">
	   <label><?php echo "Qty" ?></label>
          <input  type="number" 
		  class="form-control" id="qty" name="qty"  required="" style="height:40px;"/>
		 </div> 
		 
		  <div class="col-sm-3">
	   <label><?php echo "Attachment" ?></label>
		  <input type="file" name="files[]" multiple=""  class="form-control-file" style="font-size:13px;"/>
		  </div>

<?php if(check_privilege('otherrequests', 'create'))  {   ?>
<div class="col-sm-4">
		 <md-button  class="md-icon-button" aria-label="New" ng-cloak type="submit" style="margin-top:25px;">
          <md-tooltip md-direction="bottom"><?php echo 'Create Request' ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>
  </div>
<?php } ?>	  
		  
	</form>
	</div>
	  </div>
	 </md-toolbar>
	 <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
	  <tr md-row><td md-cell><input type="button" name="allrequests" class="btn btn-info" onclick="window.location.href = '<?php echo base_url('otherrequests/index') ?>';" value="All Requests <?php echo count($all_count); ?>"/></td><td md-cell><input type="button" name="approved" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('otherrequests/index/app') ?>';" value="Approved <?php echo count($app_count); ?>"/></td><td md-cell><input type="button" name="pending"  class="btn btn-warning" onclick="window.location.href = '<?php echo base_url('otherrequests/index/pend') ?>';" value="Pending <?php echo count($pend_count);?>"/></td><td md-cell><input type="button" name="declined"  class="btn btn-danger" onclick="window.location.href = '<?php echo base_url('otherrequests/index/dec') ?>';" value="Rejected <?php echo count($dec_count); ?>"/></td></tr>
	  </md-table-container>
	  
	  <div class="ciuis-external-search-in-table" ng-cloak style="margin-left:60%;">
          <input  class="search-table-external" id="search" name="search" type="text"  onkeyup="myFunction()" placeholder="<?php echo lang('search_by').' '.lang('description')?>">
          <md-button class="md-icon-button" aria-label="Search">
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        </div>
	  </md-toolbar>
	 <md-content  class="bg-white" >
      <md-table-container >
	

</md-content>
    <div class="row projectRow">
      
      <div ng-show="!projectLoader" id="ciuisprojectcard" style="padding-left: 15px;padding-right: 15px;" ng-cloak>
        <md-table-container ng-show="showList==true" class="bg-white">
          <table md-table  md-progress="promise" id="myTable">
            <thead md-head md-order="projects_list.order">
              <tr md-row>
                <th  md-column  md-order-by="description"><span>Description</span></th>
	  <th md-column><span>Qty</span></th>
	  <th md-column><span>Status</span></th>
	 
	  <th md-column><span>Created At</span></th>
	  <th md-column><span>By</span></th>
	   <th md-column><span>Attachment</span></th>
              </tr>
            </thead>
            <tbody md-body>
			 <?php if(count($orequests) > 0 ){
				
		  foreach($orequests as $oreq) {  
		  
		   ?>
		   <tr class="select_row" md-row  class="cursor">
			  <td md-cell>
           <?php echo $oreq['description']; ?>
        </td>
		  <td md-cell>
          <?php echo $oreq['qty']; ?>
        </td>
		  <?php if(check_privilege('otherrequests', 'edit'))  {   ?>
		  <td md-cell>
		 
            <select name="status" id="status" class="form-control" onchange="select_status(this.value,<?php echo $oreq['request_id']; ?>)">
				<option value="1" <?php if($oreq['request_status'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($oreq['request_status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['request_status'] == '3') { echo 'selected="selected"'; } ?>>Rejected</option>
			</select>
        </td>
		  <?php }  else { ?>
		  <td md-cell>
		<?php
		 
		 if($oreq['request_status'] == '1') { echo 'Pending'; }
		else if($oreq['request_status'] == '2') { echo 'Approved'; }
		else if($oreq['request_status'] == '3') { echo 'Rejected'; }	
		 
		 
		 
		 ?>
		 </td>

		   		 <?php } ?>
		
		
		  <td md-cell>
            <?php echo date('d-m-Y',strtotime($oreq['created'])); ?>
        </td>
		  <td md-cell>
			<img ng-src="<?php 
			  
			  echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
        </td>      
        <td md-cell>
		
		<?php $imgs = explode(',',$oreq['files']); 
		$pass_count = 0;
		foreach($imgs as $img) { 
		if($img != '') { 
		$pass_count ++; } } ?>
		<span class="glyphicon glyphicon-file fontGreen"></span><a href="" id ="opener-4" onclick="select_file()"><?php echo $pass_count; ?></a>
		  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLabel"><h5>Document View</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" >
          
          
        <?php   $ext = ''; 
           foreach ($imgs as $key => $pass_value) {
             
              if($pass_value != '') { 
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1);  ?>
        <div class="row">
        <a href='#about'  onclick=show_post("<?php echo $oreq["request_id"]; ?>","<?php echo $pass_value;?>") data-toggle='modal'  data-image=<?php echo $pass_value;?> id='editid<?php echo $pass_value;?>'><span class='glyphicon glyphicon-file colorDocument'></span></a>
               
                <li><?php echo $pass_value;?></li>
	
               </div>
           <?php     }
     
        
          }  ?>
          
          
           </div>
           </div>
           </div>
           </div>
           </div>
		</td>
        </tr>
			<?php }  } else { ?>
		  <tr align="center" style="color:red"><td colspan="6"><?php echo "No records Found"; ?></td></tr>
	 <?php  } ?>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="showList==true" md-limit="projects_list.limit" md-limit-options="limitOptions" md-page="projects_list.page" md-total="{{projects.length}}" ></md-table-pagination>
        <div ng-show="showGrid==true" ng-repeat="project in projects | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 6" class="col-md-4 {{project.status_class}}" style="padding-left: 0px;padding-right: 10px;">  
          <div id="project-card" class="ciuis-project-card">
            <div class="ciuis-project-content">
              <div class="ciuis-content-header">
                
              
              </div>
              
              <div class="ciuis-project-stat col-md-12">
                <div class="col-md-6 bottom-left">
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <md-content ng-show="!projects.length && !projectLoader" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
    </div>
    <div ng-show="showGrid==true" ng-show="projects.length > 6 && !projectLoader" ng-cloak>
      <div class="pagination-div">
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </div>
  </div>
  
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp projects-filter" md-component-id="ContentFilter"   ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in projects[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' ">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop=='<?php echo lang('filterbystatus') ?>'">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
</div>
  <script type="text/ng-template" id="copyProjectDialog.html">
    <md-dialog aria-label="Expense Detail">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class=""><?php echo lang('create_new_template_project') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px;">
        <md-content class="bg-white">
          <md-list flex>
            <md-list-item>
              <div class="ciuis-custom-list-item-item col-md-12">
                <p><?php echo lang('projectCopy') ?></p>
                <md-input-container class="md-block" flex-gt-xs>
                  <md-checkbox ng-model="copy.service" ng-value="true" ng-checked="true">
                    <?php echo lang('copy_services') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.expenses" ng-value="true" ng-checked="false">
                    <?php echo lang('copy_expenses') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.milestones" ng-value="true" ng-checked="copy.tasks">
                    <?php echo lang('copy_milesstones') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.tasks" ng-value="true" ng-checked="copy.milestones">
                    <?php echo lang('copy_tasks') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.peoples" ng-value="true" ng-checked="true">
                    <?php echo lang('copy_project_peoples') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.files" ng-value="true" ng-checked="true">
                    <?php echo lang('copy_uploaded_files') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.notes" ng-value="true" ng-checked="false">
                    <?php echo lang('copy_project_notes') ?>
                  </md-checkbox>
                </md-input-container>
                <div class="row">
                  <div class="col-md-6 md-block">
                    <md-input-container class="md-block" flex-gt-xs>
                      <label><?php echo lang('customer'); ?></label>
                      <md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="copy.customer" name="customer" style="min-width: 200px;">
                        <md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
                      </md-select>
                    </md-input-container>
                  </div>
                  <div class="col-md-6 md-block">
                  </div>
                </div>
                <md-input-container>
                  <label><?php echo lang('startdate') ?></label>
                  <md-datepicker name="start" ng-model="copy.start" md-open-on-focus></md-datepicker>
                </md-input-container>
                <md-input-container>
                  <label><?php echo lang('deadline') ?></label>
                  <md-datepicker name="deadline" ng-model="copy.end" md-open-on-focus></md-datepicker>
                </md-input-container>
              </div>
            </md-list-item>
          </md-list>
        </md-content>     
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
        <md-button ng-click="copyProjectConfirm()"><?php echo lang('doIt') ?></md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
  <script type="text/ng-template" id="processing.html">
    <md-dialog id="updating" style="box-shadow:none;padding:unset;min-width: 25%;">
      <md-dialog-content layout-padding layout-align="center center" aria-label="wait" style="text-align: center;">
        <md-progress-circular md-mode="indeterminate" md-diameter="40" style="margin-left: auto;margin-right: auto;"></md-progress-circular>
        <span style="font-size: 15px;"><strong><?php echo lang('processing'); ?></strong></span>
        <div class="row">
          <div class="col-md-12">
            <p style="opacity: 0.7;"><br><?php echo lang('update_note'); ?></p>
          </div>
        </div>
      </md-dialog-content>
    </md-dialog>
  </script>
  <script type="text/javascript">
    var lang = {};
    lang.doIt = '<?php echo lang("doIt") ?>';
    lang.project_complete_note = '<?php echo lang("project_complete_note") ?>';
    lang.attention = '<?php echo lang("attention") ?>';
    lang.cancel = '<?php echo lang("cancel") ?>';
  </script>
  <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/otherrequests.js') ?>"></script>
<script type="text/javascript">

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function select_status(val,id){
	var status = val;
	var id = id;
	
	 $.ajax({
              url : "<?php echo base_url(); ?>otherrequests/update",
              data:{id : id,status : status},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}

          
           // $( "#opener-4" ).click(function() {
           function select_file(){
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              
           }
             // $("#exampleModal2").appendTo("body");
           // });
         
           function show_post(id,val)
  {
     $.ajax({
              url : "<?php echo base_url(); ?>otherrequests/img/"+id,
              data:{id : id, val : val},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                 // console.log(response)
                  $('#img_details').html(response);
                     $("#editModal").modal('show');
                    $("#editModal").appendTo("body");
              }
              
     });
  }
  
  
</script>		
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


