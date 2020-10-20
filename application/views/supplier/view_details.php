<table width="100%" class="table table-bordered table-responsive">
	 
	  <tbody>
	  <tr><th><b>Company Address:</b></th><td><?php print $result["company_address"];?></td></tr>
	   <tr><th><b>Contact Number Office:</b></th><td><?php print $result["contact_number_office"];?></td></tr>
	   <tr><th><b>Email Address:</b></th><td><?php print $result["emailaddress"];?></td></tr>
		<tr><th><b>Website:</b></th><td><?php print $result["website"];?></td></tr>
	
	  <tr>
	 
	   <th><b>Mobile Number:</b></th> 
	   <td><?php echo $result['mobile_number'];?></td> 
	  </tr>
	  <tr>
	  <th><b>Country:</b></th> 
	  <td><?php print get_country($result['country_id']);?></td>	  </tr>

	  <tr>
        <th><b>Terms And Conditions:</b></th><td><?php print $result['terms_and_conditions'];?></td></tr><tr>
        <th><b>Notes:</b></th><td><?php print $result['notes'];?></td>
	    </tr>
	   </tbody></table>
	   <h2 >Contacts Details</h2>
	   <table class="table">
	  
	 
	   <thead>
    <tr>
      <th scope="col"><b>#</b></th>
      <th scope="col"><b>Name</b></th>
      <th scope="col"><b>Number</b></th>
      <th scope="col"><b>Email</b></th>
    </tr>
  </thead>
	   <?php if(!empty($supp_result)){$i=1;foreach($supp_result as $eachSupp){?>
	  <tr>
      <th scope="row"><?php print $i;?></th>
      <td><?php print $eachSupp['point_contact_name'];?></td>
      <td><?php print $eachSupp['point_contact_number'];?></td>
      <td><?php print $eachSupp['point_contact_email'];?></td>
    </tr>
	   <?php $i++;}}?>
	   </table>
	   
	   <div class="form-group col-md-9">
	   <b>Trade Licence Documents</b>

	   <?php if($result['trade_licence_documents']) {  
	   $psp = str_replace(',','',$result['trade_licence_documents']);
        
        $passport_doc = explode(",", $result['trade_licence_documents']); 
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
		  <?php }?>
		 
	   <div class="form-group col-md-9">
	    <b>Tax  Documents</b>

	   <?php if($result['tax_registration_document']) {  
	   $psp = str_replace(',','',$result['tax_registration_document']);
        
        $passport_doc = explode(",", $result['tax_registration_document']); 
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
		  <?php }?>

    