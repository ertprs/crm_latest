<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>

    <div class="col-md-12">
            <div class="detail-title">
              <h2 class="text-center">
                Payslip 
              </h2>
            </div>
    </div>
  
<div class="col-md-12">
  <div class="container">
   <p class="text-right"> <input class="btn btn-success" type="button" onclick="printDiv('printableArea')" value="Print" /></p>
    <div id="printableArea">
        <md-content  class="bg-white" >
      <md-table-container >
	  <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th md-column><span><?php echo 'Employee Name:' ?></span><span><?php echo $payslip_data['staffname']; ?></span></th>
			  <th md-column><span><?php echo 'Pay Period Begin Date:' ?></span><span><?php echo $payslip_data['from_date']; ?></span></th>
			 </tr>
			  <tr md-row>
              <th md-column><span><?php echo 'Employee ID:' ?></span><span><?php echo $payslip_data['staff_id']; ?></span></th>
			  <th md-column><span><?php echo 'Pay Period End Date:' ?></span><span><?php echo $payslip_data['to_date']; ?></span></th>
			 </tr>
          </thead>
          </table>
	  </md-table-container>
		</md-content>	
        
		 <md-content  class="bg-white" >
      <md-table-container >
        <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th md-column><span><?php echo 'EARNINGS:' ?></span></th>
			  <th md-column><span><?php echo 'AMOUNT:' ?></span></th>
			 </tr>
          </thead>
		  <tbody md-body>
		  <tr md-row>
		  <td md-cell><?php echo 'Salary'; ?></td>
		  <td md-cell><?php echo $payslip_data['basic_salary']; ?></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Allowances'; ?></td>
		  <td md-cell><?php echo $payslip_data['allowance']; ?></td>
		  </tr>
		  <tr md-row>
		  <td md-cell><?php echo 'Over Time Hours'; ?></td>
		  <td md-cell><?php echo $payslip_data['ot_hours']; ?></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Over Time Amount'; ?></td>
		  <td md-cell><?php echo $payslip_data['ot_amount'];?></td>
		  </tr>
		  
		  <tr md-row>
		  <td md-cell><?php echo 'Incentives'; ?></td>
		  <td md-cell><?php echo $payslip_data['incentives']; ?></td>
		  </tr>
		    <tr md-row>
		  <td md-cell><?php echo 'Total Earnings'; ?></td>
		  <td md-cell><?php echo  $payslip_data['total_earnings'];?></td>
		  </tr>
		    <tr md-row>
              <th style="color:black;"><b><span><?php echo 'Deductions:' ?></span></b></th>
			  <th style="color:black;"><b></b><span><?php echo 'Amount:' ?></span></b></th>
			 </tr>
         
		  
		    <tr md-row>
		  <td md-cell><?php echo 'Advance'; ?></td>
		  <td md-cell><?php echo $payslip_data['advance']; ?>
		  </tr>
		  <tr md-row>
		  <td md-cell><b><?php echo 'Total Salary in AED'; ?></b></td>
		  <td md-cell><b><?php echo $payslip_data['total'];?></b></td>
		  </tr>
		  </tbody>
          </table>
           
        
           
		 
         

		 
        </div>
        </div>
        </div>
          
         
       
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/payroll.js'); ?>"></script>
<script>function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}</script>