<table width="100%" class="table table-bordered table-responsive">
	 
	  <tbody>
	  <tr><th><b>Item Code:</b></th><td><?php print $result["item_code"];?></td></tr>
	   <tr><th><b>Item Name:</b></th><td><?php print $result["itemname"];?></td></tr>
	   <tr><th><b>Category:</b></th><td><?php print $result["mat_cat_name"];?></td></tr>
		<tr><th><b>Item Description:</b></th><td><?php print $result["itemdescription"];?></td></tr>
			<tr><th><b>Unit Type:</b></th><td><?php print $result["unit_name"];?></td></tr>
	
	  <tr>
	 
	   <td><b>Remarks:</b></td> 
	   <td><?php echo $result['remarks'];?></td> 
	  </tr>
	  <tr>
	  <td><b>Created At:</b></td> 
	  <td><?php print $result['created'];?></td>	  </tr>

	  <tr>
	  <?php  if($result['margin_type'] == 'percentage'){?><td><b>Margin Percentage:</b></td><td><?php print $result['margin_value'];?></td><?php }else if($result['margin_type'] == 'fixed'){?><td><b>Fixed Selling Price</b></td><td><?php print $result['margin_value'];?></td><?php }?>
	    </tr><tr><td><b>Last Selling Price</b></td><td><?php print $result['last_selling_price']; ?></td></tr>
	   </tbody></table>
	   <h2 >Vendor Details</h2>
	   <table class="table">
	  
	 
	   <thead>
    <tr>
      <th scope="col"><b>#</b></th>
      <th scope="col"><b>Vendor Name</b></th>
      <th scope="col"><b>Ref Code</b></th>
      <th scope="col"><b>Price</b></th>
    </tr>
  </thead>
	   <?php if(!empty($supp_result)){$i=1;foreach($supp_result as $eachSupp){?>
	  <tr>
      <th scope="row"><?php print $i;?></th>
      <td><?php print $eachSupp['company'];?></td>
      <td><?php print $eachSupp['vendor_ref'];?></td>
      <td><?php print $eachSupp['vendor_price'];?></td>
    </tr>
	   <?php $i++;}}?>
	   </table>
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