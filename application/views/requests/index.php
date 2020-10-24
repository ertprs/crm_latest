<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
   <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Material Request</small><br>
            
          </h2>
		 <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-6">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>

		   <div class="ciuis-external-search-in-table">
		   <input  id="search" name="search" type="text" placeholder="<?php echo lang('searchword') ?>">
            <md-button class="md-icon-button" aria-label="Search" ng-cloak>
              <md-icon><i class="ion-search text-muted"></i></md-icon>
            </md-button>
			</div>
		  </div>
		  </md-toolbar>
		  </div>
	 
<md-toolbar class="toolbar-white">
	
        <form  id="edit_form" method="post" action="requests/create"> 
		 
      <div class="row col-md-9">
	  <div class="col-xs-3" style="margin-top:30px;">
	<label><h4><?php echo "Project" ?></h4></label>
		<input type="radio" name="project" id="project" value="project" class="rd"/>
	
	<label><h4><?php echo "Stock" ?></h4></label>
		<input type="radio" name="project" id="stock" value="stock" class="rd" />
	</div>
	  </div>
	 <div class="row col-md-9">
		<div class="col-xs-3" id="pr">
	   <label><?php echo "Project" ?></label>
        <select class="proj" name="project_id" id="project_id" > 
                    <option value="">Select Project</option>
                    <?php foreach($projects as $row):?>
                    <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                    <?php endforeach;?>
                    </datalist>
                    
                   
      </select> 
	</div>
	
	 </div>
	 
	 
	 
	 
	  
	 <div class="row col-md-10">
	 <div class="col-md-3">
	   <label><?php echo "Material Name" ?></label>
          
		  <select class="proj" name="material_name" id="material_name" autocomplete="on" onchange="select_material(this.value)" >
                        <option value="">Select Item</option>
                        <?php foreach($products as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['productname'].' '.$row['name'];?></option>
                        <?php endforeach;?>
                    </select>
	</div>
	<div class="col-md-1">
	   <label><?php echo "Qty" ?></label>
          <input required type="number" 
		  class="form-control" id="qty" name="qty" />
		 </div> 
		  
		  <div class="col-md-2" align="center">
	   <label><?php echo "Unit Type" ?></label>
          <input required type="text" 
		  class="form-control" id="unit_type" name="unit_type" />
		  </div>
		  <div class="col-xs-2" align="center">
	   <label><?php echo "Remarks" ?></label>
          <textarea  type="text" 
		  class="form-control" id="remarks" name="remarks"></textarea>
		  </div>
		  <div class="col-xs-2" align="center">
	   <label><?php echo "Priority" ?></label>
          <select class="form-control" name="priority" id="priority">
		  <option value="1">High</option>
		  <option value="2">Medium</option>
		  <option value="3">Low</option>
		  </select>
		  </div>
		   <?php if(check_privilege('requests','create')) { ?>
		  <button href ="<?php echo base_url('requests/create') ?>" name="send" Value="Send" style="margin-top: 40px;">+</button>
		   <?php } ?>
		  </div>
	</form>
	   </md-toolbar>
	   <form method="POST">
 <md-content  class="bg-white" >
      <md-table-container >
	
	  <tr md-row><td md-cell><input type="button" name="all_requests" onclick="window.location.href = '<?php echo base_url('requests/index/all') ?>';" value="All Requests <?php echo count($all_count);?>"/></td><td md-cell><input type="button" name="approved" onclick="window.location.href = '<?php echo base_url('requests/index/app') ?>';" value="Approved <?php echo count($app_count); ?>"/></td><td md-cell><input type="button" name="declined" onclick="window.location.href = '<?php echo base_url('requests/index/dec') ?>';" value="Declined <?php echo count($dec_count); ?>"/></td></tr>
	  </md-table-container>

</md-content>
 <md-content  class="bg-white" >
      <md-table-container >
	  
	  <table md-table id="myTable">
	  <thead md-head>
	  <tr md-row>
	 <th md-column>Select</th>
	  <th md-column >Project no. & Project Name</th>
	  <th md-column>Material Name</th>
	  <th md-column>Qty</th>
	  <th md-column>Unit Type</th>
	  <th md-column>Unit Price</th>
	  <th md-column>Status</th>
	  <th md-column>Created At</th>
	  <th md-column>By</th>
	   <th md-column>Action</th>
	</tr>
	  </thead>
	  <tbody md-body id="show_data">
	  
	  <?php if(count($mrequests) > 0 ){
		  foreach($mrequests as $mreq) {  ?>

	  <tr md-row>
	 <td md-cell>
			
			
											<input type="checkbox" id="remember" value="<?php echo $mreq['mrid']; ?>" class="tot_check" >
											<label for="remember"></label>
										
		</td>
	  <td md-cell>
           <?php if($mreq['project_name'] != ''){ echo $mreq['project_name']; } else { echo $mreq['name']; }?>
        </td>
		  <td md-cell>
           <?php echo $mreq['productname']; ?>
        </td>
		  <td md-cell>
          <?php echo $mreq['qty']; ?>
        </td>
		  <td md-cell>
            <?php echo $mreq['unit_type']; ?>
        </td>
		  <td md-cell>
            <?php echo $mreq['price']; ?>
        </td>
		  <td md-cell>
		 
            <select name="status" id="status" class="form-control">
				<option value="1" <?php if($mreq['status'] == '1') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="2" <?php if($mreq['status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($mreq['status'] == '3') { echo 'selected="selected"'; } ?>>Declined</option>
			</select>
		 
		  
        </td>
		  <td md-cell>
            <?php echo $mreq['created']; ?>
        </td>
		  <td md-cell>
			<img ng-src="<?php 
			  
			  echo base_url('uploads/images/'.$mreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
        </td>
		<td> 
	<?php if(check_privilege('requests', 'edit'))  {   ?>
	 <button class="btn btn-primary view_detail" relid="<?php echo $mreq['mrid'];  ?>">  <md-icon class="mdi mdi-edit"></md-icon> </button>
	<?php } ?>
	<?php if(check_privilege('requests', 'delete'))  {   ?>
	 <md-menu-item>
	        					<md-button  ng-href="<?php echo base_url('requests/delete/'.$mreq['mrid'])?>">
	        						<div layout="row" flex>
	        							
	        							<md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
	        						</div>
	        					</md-button>
	        				</md-menu-item>
	<?php } ?>
							</td>
		</tr>
	  <?php }  } else { ?>
		  <tr align="center" style="color:red"><td colspan="6"><?php echo "No records Found"; ?></td></tr>
	 <?php  } ?>
	  </tbody>
</table>
</md-table-container>

</md-content>
<?php $path = $this->uri->segment( 1 );  ?>
<!-- <md-table-pagination ng-show="1 > 0" md-limit="<?php //echo count($all_count); ?>" md-limit-options="limitOptions" md-page="1" md-total="<?php //echo count($all_count); ?>" ></md-table-pagination>  -->
				
</form>
</div>		  

	   

    <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/projects.js'); ?>"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="~/scripts/jquery-1.10.2.js"></script>

<!-- #region datatables files -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

      $('.view_detail').click(function(){
          
          var id = $(this).attr('relid'); //get the attribute value
         
          $.ajax({
              url : "<?php echo base_url(); ?>requests/get_request_data",
              data:{id : id},
              method:'GET',
              dataType:'json',
              success:function(response) {
               // $('#price_edit').html(response.mname); //hold the response in id and show on popup
               // $('#status_edit').html(response.status_id);
                
                $('#Modal_Edit').modal({backdrop: 'static', keyboard: true, show: true});
            }
          });
      });
      
      $(".proj").select2({
			//placeholder: "Select .."
	});
	
	$('#myTable').DataTable({
	    
	    "paging": true,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "info": true,
              "autoWidth": false,
	    
	});
    });
    
    
   
    
</script>
<form><div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Materil Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                       
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Price</label>
                            <div class="col-md-2">
                              <input type="text" name="price_edit" id="price_edit" class="form-control" 					placeholder="Price">
                            </div>
                        </div>
						<div class="form-group row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-2">
                             <select name="status_edit" id="status_edit" class="form-control" >
								<option value="1">Pending</option>
								<option value="2">Approved</option>
								<option value="3">Declined</option>
							</select>	
                            </div>
                        </div>
		<input type="hidden" name="material_id" id="material_id" />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" id="btn_update" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
<script type="text/javascript">
        //get data for update record
        $('#show_data').on('click','.view_detail',function(){
        
			
			
			var id = $(this).attr('relid'); //get the attribute value
         
          $.ajax({
              url : "<?php echo base_url(); ?>requests/get_request_data",
              data:{id : id},
              method:'GET',
              dataType:'json',
              success:function(response) {
              
                $('#Modal_Edit').modal('show');
				 $('[name="price_edit"]').val(response.price);
				$('[name="status_edit"]').val(response.status);
				$('[name="material_id"]').val(response.id);
                
            }
          });
        });
		
		
		 //update record to database
         $('#btn_update').on('click',function(){
            var unit_price = $('#price_edit').val();
            var status = $('#status_edit').val();
            var material_id = $('#material_id').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('requests/update')?>",
                dataType : "JSON",
                data : {unit_price:unit_price , status:status, material_id:material_id},
                success: function(data){
                    $('[name="price_edit"]').val("");
                    $('[name="status_edit"]').val("");
                    $('[name="material_id"]').val("");
                    $('#Modal_Edit').modal('hide');
					window.location.reload();
                }
            });
            return false;
			
        });
$('.rd').on('click',function() {
	if($('#project').is(':checked')) {   $('#pr').show() };
	if($('#stock').is(':checked')) {     $('#pr').hide() };
});

function select_material(val){
	
	var id = val;
	$.ajax({
              url : "<?php echo base_url(); ?>requests/get_product_data",
              data:{id : id},
              method:'GET',
              dataType:'json',
              success:function(response) {
             
               
				 $('[name="unit_type"]').val(response.unit_type);
				
            }
          });
	
}
		  
		
</script>		