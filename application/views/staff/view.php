<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>

    <div class="col-md-12">
            <div class="detail-title">
              <h2 class="text-center">
                PROFILE
              </h2>
            </div>
    </div>
  
<div class="col-md-12">
  <div class="container">
   <p class="text-right"> <input class="btn btn-success" type="button" onclick="printDiv('printableArea')" value="Print" /></p>
    <div id="printableArea">
       <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Emoloyee Profile</th>
                  <!-- <th scope="col">Last</th>
                  <th scope="col">Handle</th> -->
                </tr>
              </thead>
                <?php if($staff_details){
                  foreach ($staff_details as $key => $value) {
                  ?>
              <tbody>
                <tr>
                  <th>Name</th>
                  <td><?php echo $value->staffname ;?></td>
                </tr>
                <tr>
                  <th>Role</th>
                  <td><?php echo $value->staff_number ;?></td>
                </tr>
                <tr>
                  <th>Staff Department</th>
                  <td><?php echo $value->name;?></td>
                </tr>
                <tr>
                  <th>Mobile No</th>
                  <td><?php echo $value->phone ;?></td>
                </tr>
                 <tr>
                  <th>Joining Date</th>
                  <td><?php echo $value->joining_date ;?></td>
                </tr>
                <tr>
                  <th>Gender </th>
                  <td><?php echo $value->gender ;?></td>
                </tr>
                <tr>
                  <th>Profession </th>
                  <td><?php echo $value->profession ;?></td>
                </tr>
                <tr>
                  <th>Nominee </th>
                  <td><?php echo $value->nominee ;?></td>
                </tr>
                <tr>
                  <th>Date of Birth </th>
                  <td><?php echo $value->birthday ;?></td>
                </tr>
                <tr>
                  <th>Nationality </th>
                  <td><?php echo get_country($value->nationality) ;?></td>
                </tr>
                <tr>
                  <th>Home Country Address</th>
                  <td><?php echo $value->address ;?></td>
                </tr>
              </tbody>
            <?php }} ?>
            </table>
          </div>
        </div>
        </div>
		
			<?php if ($accessTab['salaryinfo']== true) { ?>
          <div class="col-md-12">
            <div class="detail-title">
              <h2 class="text-center">
                SALARY INFO
              </h2>
            </div>
          </div>

          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printablevalue')" value="Print" /></p>
                <div id="printablevalue">
              <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Employee</th>
                <th scope="col">Saley info</th>
              </tr>
            </thead>
            <?php if($staff_details){
              foreach ($staff_details as $key => $value) {
               ?>
            <tbody>
              <tr>
                <th>Work Permit No</th>
                <td><?php echo $value->work_permit_no ;?></td>
              </tr>
              <tr>
                <th>Fixed Portion</th>
                <td><?php echo $value->basic_salary ;?></td>
              </tr>
              <tr>
                <th>Allowance</th>
                <td><?php echo $value->allowance ;?></td>
              </tr>
              <tr>
                <th>Work Permit Personal No</th>
                <td><?php echo $value->work_permit_personal_no ;?></td>
              </tr>
              <tr>
                <th>Vehicle/ Transport Allowance</th>
                <td><?php echo $value->transport_allowance ;?></td>
              </tr>
              <tr>
                <th>Vehicle/ Transport Allowance</th>
                <td><?php echo $value->vehicle_amound ;?></td>
              </tr>
              <tr>
                <th>Accommodation Allowance</th>
                <td><?php echo $value->accomodation_allowance ;?></td>
              </tr>
              <tr>
                <th>Accommodation Allowance</th>
                <td><?php echo $value->allowance ;?></td>
              </tr>
              <tr>
                <th>Over Time/Hour</th>
                <td><?php echo $value->over_time ;?></td>
              </tr>
              <tr>
                <th>Total salary</th>
                <td><?php echo $value->total_salary ;?></td>
              </tr>
              <tr>
                <th>Bank Name</th>
                <td><?php echo $value->bank_name ;?></td>
              </tr>
              <tr>
                <th>IBAN/Bank Card Number</th>
                <td><?php echo $value->bank_card_number ;?></td>
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
    </div>
			<?php }  if ($accessTab['appraisal']== true)  { ?>
			<div class="col-md-12">
			  <div class="detail-title">
				<h2 class="text-center">
				  APPRAISAL INFO
				</h2>
			  </div>
			</div>
          
          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printableapprasial')" value="Print" /></p>
                <div id="printableapprasial">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Date Of Increment</th>
                <th scope="col">Increment Amount</th>
                <th scope="col">Increment Type</th>
                <th scope="col">Reason Of Increment</th>
                <th scope="col">Documents</th>
              </tr>
            </thead>
            <?php if($staff_appraisal){
               foreach ($staff_appraisal as $key => $value) {
                ?>
            <tbody>
              <tr>
                <th><?php echo $value->increment_date ;?></th>
                <td><?php echo $value->increment_amount ;?></td>
                <td><?php echo $value->increment_type ;?></td>
                <td><?php echo $value->increment_reason ;?></td>
                <td><?php echo $value->appraisal_doc ;?></td>
              </tr>
             
            </tbody>
             <?php }} ?>
          </table>
        
        </div>
      </div>
    </div>
	<?php } if ($accessTab['warnings']== true)  {  ?>
       <div class="col-md-12">
          <div class="detail-title">
            <h2 class="text-center">
              WARNINGS
            </h2>
          </div>
        </div>
        
          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printablewarning')" value="Print" /></p>
                <div id="printablewarning">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Warning Date</th>
                <th scope="col">Date Of Incident</th>
                <th scope="col">Warning Type</th>
                <th scope="col">Type Of violation</th>
                <th scope="col">Action</th>
                <th scope="col">Employee Signature</th>
              </tr>
            </thead>
            <?php if($staff_warning){
               foreach ($staff_warning as $key => $value) {
               ?>
            <tbody>
              <tr>
                <th><?php echo $value->warning_date ;?></th>
                <td><?php echo $value->date_of_incident ;?></td>
                <td><?php echo $value->warning_type ;?></td>
                <td><?php echo $value->type_of_violation ;?></td>
                <td><?php echo $value->action ;?></td>
                <td><?php echo $value->employee_signature ;?></td>
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
      </div>
       <?php } if ($accessTab['leaves']== true){ ?>
	   <div class="col-md-12">
          <div class="detail-title">
            <h2 class="text-center">
              LEAVES
            </h2>
          </div>
        </div>

          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printableleaves')" value="Print" /></p>
                <div id="printableleaves">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Leave Start Date</th>
                <th scope="col">Rejoin Date</th>
                <th scope="col">No Of Day's leave</th>
                <th scope="col">Payment Type</th>
                <th scope="col">Type Of Leave</th>
                <th scope="col">Method Of Leave</th>
                <th scope="col">Remarks</th>
              </tr>
            </thead>
            <?php if($staff_leaves){
               foreach ($staff_leaves as $key => $value) {
               ?>
            <tbody>
              <tr>
                <th><?php echo $value->leave_start_date ;?></th>
                <td><?php echo $value->rejoin_date ;?></td>
                <td><?php echo $value->no_leave ;?></td>
                <td><?php echo $value->payment_type ;?></td>
                <td><?php echo $value->type_of_leave ;?></td>
                <td><?php echo $value->method_of_leave ;?></td>
                <td><?php echo $value->remarks ;?></td>
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
    </div>
        <?php } if ($accessTab['tools']== true) { ?>
	   <div class="col-md-12">
          <div class="detail-title">
            <h2 class="text-center">
              TOOLS & ASSETS
            </h2>
          </div>
        </div>

          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printabletools')" value="Print" /></p>
                <div id="printabletools">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col"> Date</th>
                <th scope="col">Item Discription</th>
                <th scope="col">Quantity</th>
                <th scope="col">Approved By</th>
                <th scope="col">Status</th>
                <th scope="col">Remarks</th>
                <th scope="col">Signature</th>
              </tr>
            </thead>
            <?php if($staff_tools){
              foreach ($staff_tools as $key => $value) {
              ?>
            <tbody>
              <tr>
                <th><?php echo $value->date ;?></th>
                <td><?php echo $value->item_discription ;?></td>
                <td><?php echo $value->quantity ;?></td>
                <td><?php echo $value->approved_by ;?></td>
                <td><?php echo $value->status ;?></td>
                <td><?php echo $value->remarks ;?></td>
                <td><?php echo $value->signature ;?></td>
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
    </div>
     <?php } if ($accessTab['notes']== true) { ?>
	<div class="col-md-12">
          <div class="detail-title">
            <h2 class="text-center">
              NOTES
            </h2>
          </div>
        </div>

          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printablenotes')" value="Print" /></p>
                <div id="printablenotes">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col"> Note Description</th>
               
              </tr>
            </thead>
            <?php if($staff_notes){
              foreach ($staff_notes as $key => $value) {
              ?>
            <tbody>
              <tr>
                <td><?php echo $value->notes ;?></td>
                
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
    </div>
  <?php } if ($accessTab['userdocuments']== true) { ?>
		<div class="col-md-12">
          <div class="detail-title">
            <h2 class="text-center">
              DOCUMENTS DETAILS
            </h2>
          </div>
        </div>

          <div class="col-md-12">
            <div class="container">
              <p class="text-right"> <input class="btn btn-primary" type="button" onclick="printDiv('printabledocuments')" value="Print" /></p>
                <div id="printabledocuments">
           <table class="table table-bordered">
            <thead>
              <tr>
              <th scope="col"> Passport ID </th>
              <th scope="col"> Expiry Date</th>
                  <th scope="col"> Remind Me before</th>
                 
                  <th scope="col">Files </th>
                  
                  
               
              </tr>
            </thead>
            <?php if($staff_documents){
              foreach ($staff_documents as $key => $value) {
              ?>
            <tbody>
              <tr>
                <td><?php echo $value->passport ;?></td>
                <td><?php echo $value->passport_expiry_date ;?></td>
                <td><?php echo $value->passport_remind ;?></td>
         <?php       $pass_doc =  str_replace(' ', ',', $value->passport_doc); ?>
                 <td><?php echo $pass_doc ;?></td>
                
                
              </tr>
            </tbody>
          <?php }} ?>
          </table>
           <table class="table table-bordered">
            <thead>
              <tr>
              <th scope="col"> Emirates ID </th>
             <th scope="col"> Expiry Date</th>
                  <th scope="col"> Remind Me before</th>
                 
                  <th scope="col">Files </th>
                  
                  
               
              </tr>
            </thead>
            <?php if($staff_documents){
              foreach ($staff_documents as $key => $value) {
              ?>
            <tbody>
              <tr>
                <td><?php echo $value->emirates_id ;?></td>
                <td><?php echo $value->emirates_expiry_date ;?></td>
                <td><?php echo $value->emirates_remind ;?></td>
                <?php       $em_doc =  str_replace(' ', ',', $value->emirates_doc); ?>
                 <td><?php echo $em_doc ;?></td>
                
                
              </tr>
            </tbody>
          <?php }} ?>
          </table>
            <table class="table table-bordered">
            <thead>
              <tr>
              <th scope="col"> Labour Card </th>
            <th scope="col"> Expiry Date</th>
                  <th scope="col"> Remind Me before</th>
                 
                  <th scope="col">Files </th>
                  
                  
               
              </tr>
            </thead>
            <?php if($staff_documents){
              foreach ($staff_documents as $key => $value) {
              ?>
            <tbody>
              <tr>
                <td><?php echo $value->labour_card;?></td>
                <td><?php echo $value->labour_expiry_date ;?></td>
                <td><?php echo $value->labour_remind ;?></td>
                 <?php       $lb_doc =  str_replace(' ', ',', $value->labour_doc); ?>
                 <td><?php echo $lb_doc ;?></td>
                
                
              </tr>
            </tbody>
          <?php }} ?>
          </table>
           <table class="table table-bordered">
            <thead>
              <tr>
              <th scope="col"> ATM Card </th>
            <th scope="col"> Expiry Date</th>
                  <th scope="col"> Remind Me before</th>
                 
                  <th scope="col">Files </th>
                  
                  
               
              </tr>
            </thead>
            <?php if($staff_documents){
              foreach ($staff_documents as $key => $value) {
              ?>
            <tbody>
              <tr>
                <td><?php echo $value->atm_card;?></td>
                <td><?php echo $value->atm_expiry_date ;?></td>
                <td><?php echo $value->atm_remind ;?></td>
                 <?php       $atm_doc =  str_replace(' ', ',', $value->atm_doc); ?>
                 <td><?php echo $atm_doc;?></td>
                
                
              </tr>
            </tbody>
          <?php }} ?>
          </table>
        </div>
      </div>
    </div>

 <?php }  ?>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/staffs.js'); ?>"></script>
<script>function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}</script>