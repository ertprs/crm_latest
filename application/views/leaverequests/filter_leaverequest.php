	<md-table-container>
							<table md-table id="myTable1">
								<thead md-head>
									<tr md-row>
										
										<th md-column><span>Employee Name</span></td>
										<th md-column><span>Start Date</span></td>
										 <th md-column><span>Rejoin Date</span></th>
										  <th md-column><span>Type of Leave</span></th>
	  <th md-column><span>No of Days</span></th>
	   <th md-column><span>Payment Type</span></th>
	  <th md-column><span>Status</span></th>
	  <th md-column><span>Created At</span></th>
	  <th md-column><span> By</span></th>
	  
										
									</tr>
								</thead>
								<tbody md-body id="show_data">						  
									<?php if(count($lrequests) > 0 ){
										foreach($lrequests as $oreq) {  ?>
											<tr md-row>
												
												<td md-cell>
													<?php if($this->Privileges_Model->check_privilege('leaverequests', 'edit') )  {   ?>
													<strong>
														<a  onclick="view_leave('<?php print $oreq['leave_id'];?>')" class="link"><?php echo $oreq['staffname']; ?></a>
													</strong>
												<?php }else{?>
												<strong>
														<?php echo $oreq['staffname']; ?>
													</strong>
												<?php }?>
												</td>
												<td md-cell>
													<strong ><?php if($oreq['leave_start_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['leave_start_date'])); } ?></strong>
												</td>
												<td md-cell>
													<strong> <?php if($oreq['rejoin_date'] != '0000-00-00') { echo date('d-m-Y',strtotime($oreq['rejoin_date'])); }  ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['type_of_leave']; ?></strong>
												</td>
												<td md-cell>
													<strong><?php echo $oreq['no_of_days']; ?></strong>
												</td>
												<?php if(check_privilege('leaverequests', 'edit'))  {   ?>
		<td md-cell>
		<select class="form-control" name="payment_type" id="payment_type" style="width: 132px;">
		 <option selected="" value="">Select</option>
		<option value="Paid" <?php if($oreq['payment_type'] == 'Paid'){ echo "selected='selected'"; } ?>>Paid</option>
		<option value="Unpaid" <?php if($oreq['payment_type'] == 'Unpaid'){ echo "selected='selected'"; } ?>>Unpaid</option>
		</select></td>
				<?php } else {  ?>
				<td md-cell>
				<strong><?php echo $oreq['payment_type']; ?></strong></td>
				<?php } ?>
				<?php if(check_privilege('leaverequests', 'edit'))  {   ?>
		  <td>
		 
            <select name="status" id="status" class="form-control" onchange="update_status(this.value,<?php echo $oreq['leave_id']; ?>)" style="width: 132px;">
				<option value="1" <?php if($oreq['leave_status'] == '1') { echo 'selected="selected"'; } ?>>Open</option>
				<option value="2" <?php if($oreq['leave_status'] == '2') { echo 'selected="selected"';  } ?>>Approved</option>
				<option value="3" <?php if($oreq['leave_status'] == '3') { echo 'selected="selected"'; } ?>>Pending</option>
				<option value="4" <?php if($oreq['leave_status'] == '4') { echo 'selected="selected"'; } ?>>Declined</option>
			</select>
        </td>
				<?php } else { ?>
												
												<td md-cell><strong>
												<?php
		 //echo $oreq['leave_status'];
		 if($oreq['leave_status'] == 1) { echo 'Open'; }
		else if($oreq['leave_status'] == 2) { echo 'Approved'; }
		else if($oreq['leave_status'] == 3) { echo 'Pending'; }	
		else if($oreq['leave_status'] == 4) { echo 'Declined'; }	
		 
		 
		 
		 ?>
												</strong></td>
				<?php }?>
												 <td md-cell>
           <strong> <?php echo date('d-m-Y',strtotime($oreq['created'])); ?></strong>
        </td>
												<td md-cell>
													<img class="imgCircle" src="<?php 
													 echo base_url('uploads/images/'.$oreq['staffavatar'].'')?>" alt="staffavatar" width="40px;" height="40px">
												</td>
							</tr>
						  <?php }  }  ?>
							  
						  </tbody>
					</table>
						</md-table-container>