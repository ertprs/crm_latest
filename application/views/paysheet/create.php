<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<div class="ciuis-body-content" ng-controller="Payroll_Controller">
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-9"> 
    <?php echo form_open('payroll/create',array("class"=>"form-horizontal orderForm")); ?>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-ios-filing-outline text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('generate').' '.lang('Payslip') ?></h2>
     <!--   <md-switch ng-model="order_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php echo lang('for_lead') ?></strong></md-switch>
        <md-button ng-href="<?php echo base_url('contacts')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-muted"></i></md-icon>
        </md-button>
        <md-button ng-click="saveAll()" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
          <md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
        </md-button>-->
      </div>
    </md-toolbar>
    <md-content class="bg-white" layout-padding ng-cloak>
      <div layout-gt-xs="row">
         <div class="form-group">
                  <label class="control-label col-sm-5" for="from_date">Pay Period Begin Date</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control newdatepicker" name="from_date" id="from_date" placeholder="" autocomplete="off" value="" >
                  </div>
                </div>
				 <div class="form-group">
                  <label class="control-label col-sm-5" for="email"> Pay Period End Date</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control newdatepicker" name="to_date" id="to_date" placeholder="" autocomplete="off" value="" >
                  </div>
                </div>
				
				 <div class="form-group">
                  <label class="control-label col-sm-5" for="email"> Staff</label>

                  <div class="col-sm-10">
                    <select class="form-control" name="staff_id" id="staff_id" onchange="select_staff(this.value)">
					<option value="">Select Employee</option>
					<?php foreach($staff as $k => $stf) { ?>
					<option value="<?php echo $stf['id'];?>"><?php echo $stf['staffname'];?></option>
					<?php } ?>
					</select>
                   </div>
                </div>
      </div>
	   </md-content>
	  <div id="payslip">
      <md-content  class="bg-white" >
      <md-table-container >
	  <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
              <th md-column><span><?php echo 'Employee Name:' ?></span><span><?php echo ''; ?></span></th>
			  <th md-column><span><?php echo 'Employee ID:' ?></span><span><?php echo ''; ?></span></th>
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
		  <td md-cell><?php echo '0'; ?></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Allowances'; ?></td>
		  <td md-cell><?php echo '0'; ?></td>
		  </tr>
		  <tr md-row>
		  <td md-cell><?php echo 'Over Time Hours'; ?></td>
		  <td md-cell><input type="hidden" name="ot_hours" id ="ot_hours" value=""></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Over Time Amount'; ?></td>
		  <td md-cell><input type="hidden" name="ot_amount" id ="ot_amount" value=""><span id="ot_full_amount"></span></td>
		  </tr>
		  <tr md-row>
		  <td md-cell><?php echo 'Advance'; ?></td>
		  <td md-cell><?php echo '0'; ?></td>
		  </tr>
		  <tr md-row>
		  <td md-cell><?php echo 'Incentives'; ?></td>
		  <td md-cell><input type="number" name="incentives" id="incentives" value=""></td>
		  </tr>
		   <tr md-row>
		  <td md-cell><?php echo 'Total Salary in AED'; ?></td>
		  <td md-cell><?php echo '0'; ?></td>
		  </tr>
		  </tbody>
          </table>
</md-table-container>
</md-content>		  

     </div> 
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="submit" name="submit" id="submit" value="Submit" >
      </md-input-container>
      </div>
   
    
    <?php echo form_close(); ?> 
  </div>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/payroll.js'); ?>"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
  <script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,changeYear: true,changeMonth: true});
	  
	  
	
    })
	
	function select_staff(val){
	    var from_date = $('#from_date').val();
	    var to_date = $('#to_date').val();
	   var staff_id = val;
	   $.ajax({ 
				type: "POST",
		
				url:'<?php echo base_url(); ?>payroll/payslip',
				data: {staff_id:staff_id,from_date:from_date,to_date:to_date}
			}).done(function( data ) {//alert(data);
				$( "#payslip").html( data );
				
				tot_sal = 0;
    
		$('input.amt').each(function() { 
						var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
							
			tot_ded = 0;	

					$('input.amt_d').each(function() { 
						var value1 = parseFloat($(this).val());
					
					if (!isNaN(value1)){ 
					
					tot_ded += value1;
					
					}
					
					});
					
	$('#total').val(tot_sal-tot_ded);
	$('#ttotal').html(tot_sal-tot_ded);
	$('#totale').val(tot_sal);
	$('#ttotale').html(tot_sal);
			 });
			 
			 
			   
		
	}
	
/* function enter_othours(val){
	var ot_time = $('#ot_per_hour').val();
	var ot_amt = val*parseFloat(ot_time);
	$('#ot_amount').val(ot_amt);
	$('#ot_full_amount').html(ot_amt);
	        tot_sal = 0;
    
$('input.amt').each(function() { 
						var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
				
	$('#total').val(tot_sal);
	$('#ttotal').html(tot_sal);
	} */
	//enter_incentives
	function enter_incentives(val){
	
	        tot_sal = 0;
    
					$('input.amt').each(function() { 
						var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 
					
					tot_sal += value;
					
					}
					
					});
					
					
					
			tot_ded = 0;	

					$('input.amt_d').each(function() { 
						var value1 = parseFloat($(this).val());
					
					if (!isNaN(value1)){ 
					
					tot_ded += value1;
					
					}
					
					});
				
	$('#total').val(tot_sal-tot_ded);
	$('#ttotal').html(tot_sal-tot_ded);
	$('#totale').val(tot_sal);
	$('#ttotale').html(tot_sal);
	}
	
</script>


