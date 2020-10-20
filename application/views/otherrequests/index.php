<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.greenCls{
	color:#008000;
}

.brownCls{
	color:#964B00;
}
.orangeCls{
	color:#ff6501;
}
</style>

</style>
<div class="ciuis-body-content" ng-controller="Otherrequests_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0">
			<div class="panel-default panel-table borderten lead-manager-head">
				
				  <div class="ticket-contoller-left">
					<div id="tickets-left-column text-left">
					  <div class="col-md-12 ticket-row-left text-left">
						<div class="tickets-vertical-menu">
						  <!--<a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo 'All Requests'?> <span class="ticket-num" ng-bind="tickets.length"></span></a>-->
						 <?php $this->load->view('inc/side_menu.php')?>
						  
						  
						   <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo 'Status' ?></h5>
						    <a onclick="window.location.href = '<?php echo base_url('mrequests/otherrequests') ?>';" class="side-tickets-menu-item"><?php echo 'All' ?><span class="ticket-num"><?php echo count($all_count);?></span></a>
						 
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/otherrequests/pending') ?>';" class="side-tickets-menu-item"><?php echo 'Pending' ?> <span class="ticket-num"><?php echo count($pend_count);?></span></a>
						  <a  onclick="window.location.href = '<?php echo base_url('mrequests/otherrequests/approved') ?>';"  class="side-tickets-menu-item"><?php echo 'Approved' ?><span class="ticket-num"><?php echo count($app_count);?></span></a>
						  <a onclick="window.location.href = '<?php echo base_url('mrequests/otherrequests/rejected') ?>';" class="side-tickets-menu-item"><?php echo 'Rejected' ?><span class="ticket-num"><?php echo count($dec_count);?></span></a>
						
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
    <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="File">
          <md-icon><i class="icon ico-ciuis-projects text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo 'REQUESTS' ?> <small>/ Other Request(<span ng-bind="projects.length"></span>)</small></h2>
		

		
        
        
        
      <!--  <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php //echo lang('filter') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button> -->
        
      </div>
    </md-toolbar>
	<md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div >
	  <div class="row col-sm-12" >
	  <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-md-12">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>
        <form  id="edit_form" method="post" action="<?php print base_url(); ?>otherrequests/create" enctype='multipart/form-data'> 
	
	 <div class="col-sm-3 form-group">
	   <label><?php echo "Description" ?></label>
          <textarea required type="text" 
		  class="form-control" id="description" name="description" placeholder="Enter Description Here" rows="2" cols="20"required="" ></textarea>
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


<div class="col-sm-4">
		 <md-button  class="md-icon-button" aria-label="New" ng-cloak type="submit" style="margin-top:25px;">
          <md-tooltip md-direction="bottom"><?php echo 'Create Request' ?></md-tooltip>
          <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
        </md-button>
  </div>
  
		  
	</form>
	</div>
	  </div>
	 </md-toolbar>
	 <!--
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
	  </md-toolbar>-->
	 <md-content  class="bg-white" >
      <md-table-container >
	

</md-content>
    <div class="row projectRow">
      
      <div ng-show="!projectLoader" id="ciuisprojectcard" style="padding-left: 15px;padding-right: 15px;" ng-cloak>
        <md-table-container  class="bg-white">
          <table md-table  md-progress="promise" id="myTable">
            <thead md-head md-order="projects_list.order">
              <tr md-row>
                <th  md-column  md-order-by="description"><span>Description</span></th>
	  <th md-column><span>Series</span></th>
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
			  <td md-cell><strong>
           <?php echo $oreq['description']; ?></strong>
        </td>
		<td md-cell>
         <strong> <?php echo $oreq['seriesid']; ?></strong>
        </td>
		  <td md-cell>
         <strong> <?php echo $oreq['qty']; ?></strong>
        </td>
		  <?php
		  if(check_privilege('otherrequests', 'edit') && $maxvalue >= $oreq['qty'])  {   ?>
		  <td md-cell>
		 <br>
            <select name="status" id="status" class="form-control" onchange="select_status(this.value,<?php echo $oreq['request_id']; ?>)">
				<option value="1" <?php if($oreq['request_status'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($oreq['request_status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['request_status'] == '3') { echo 'selected="selected"'; } ?>>Rejected</option>
			</select>
			<br>
        </td>
		  <?php }  else { 
			$showStatus="";
			$showCol="";
			if($oreq['request_status'] == '1'){ 
				$showStatus="Pending"; $showCol="orangeCls";
			}else if($oreq['request_status'] == '2'){
				$showStatus="Approved";$showCol="greenCls";
			}else if($oreq['request_status'] == '3') {
				$showStatus="Rejected";$showCol="brownCls";
			}
		  ?>
		  <td md-cell class="md-cell"><strong><span class="<?php echo $showCol; ?>" style="font-weight:800;font-size: 14px !important;width:100%;padding:5px 21px;text-align:left;"><?php echo $showStatus; ?></span></strong></td>
		 <?php } ?>
		
		
		  <td md-cell>
		  <strong>
            <?php echo date('d-m-Y',strtotime($oreq['created'])); ?></strong>
        </td>
		  <td md-cell>
			<img src="<?php 
			  
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

        </div>
     
    </div>
  
  </div>
  
 
</div>

 
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
<?php include_once( APPPATH . 'views/inc/onlyjs.php' ); ?>
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


