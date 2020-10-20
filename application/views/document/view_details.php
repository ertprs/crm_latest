<table width="100%" class="table table-bordered table-responsive">
	 
	  <tbody>
	  <tr><th><b>Authorised Company Name:</b></th><td><?php print $result["company_name"];?></td></tr>
	   <tr><th><b>Contact Person:</b></th><td><?php print $result["contact_person"];?></td></tr>
	   <tr><th><b>Contact Number:</b></th><td><?php print $result["contact_number"];?></td></tr>
		<tr><th><b>Email:</b></th><td><?php print $result["email"];?></td></tr>
	
	  <tr>
	 
	   <td><b>Remarks:</b></td> 
	   <td><?php echo $result['remarks'];?></td> 
	  </tr>
	  <tr>
	  <td><b>Created At:</b></td> 
	  <td><?php print $result['created'];?></td>	  </tr>

	 
	   </tbody></table>
	  
	   <h2 >Documents View</h2>
	   <div class="form-group col-md-2">
	   

	   <?php if($result['documents']) {  
	   $psp = str_replace(',','',$result['documents']);
        
        $passport_doc = explode(",", $result['documents']); 
        $pass_count = 0;
          foreach ($passport_doc as $key => $pass_value) {
              if($pass_value != ''){
             $pass_count ++;
              }
          }?>
           <?php  $ext = ''; 
           foreach ($passport_doc as $key => $pass_value) {
             
              if($pass_value != '') { 
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); ?>
			  <div class="row">
			  <?php if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){?>
				   <a href='#about' onclick="show_post_pdf('<?php print $pass_value;?>')" data-toggle='modal' data-image='<?php print $pass_value;?>' id='editidpdf<?php print $pass_value;?>'><span class='glyphicon glyphicon-file colorDocument'></span></a> <?php }else{?>
				   <a class='btn btn-success' href='<?php print base_url();?>uploads/images/<?php print $pass_value;?>'  target='_new'><i class='ion-clipboard'></i></a>
				   <?php }} else{ ?>
				   <a href='#about'  onclick="show_post('<?php print $pass_value;?>')" data-toggle='modal'  data-image='<?php print $pass_value;?>' id='editid<?php print $pass_value;?>'><span class='glyphicon glyphicon-file colorDocument'></span></a>
				   <?php }?>
				   <li><?php print $pass_value;?></li>
			  </div><?php }}?>
		 <!--  <span class="glyphicon glyphicon-file fontGreen"></span><a  id = "opener-4" style="cursor:pointer;"><?php //print $pass_count;?></a>
		  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		  <div class="modal-content">
		  <div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel"><h5>Document View</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" >
		 </div></div></div></div> --> <?php }?>