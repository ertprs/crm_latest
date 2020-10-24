<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<!--box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;-->
<style>

 
.centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
    
}
</style>
<div class="ciuis-body-content" >
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-12"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('createestimation') ?></h2>
        <md-switch ng-model="proposal_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php echo lang('for_lead')?></strong></md-switch>
        <md-button ng-href="<?php echo base_url('estimations')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-danger"></i></md-icon>
        </md-button>
        <md-button type="button" ng-href="<?php echo base_url('estimations/create')?>"  class="md-icon-button" aria-label="Save" ng-cloak>
          <md-progress-circular ng-show="savingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="savingProposal == true" md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
          <md-icon ng-hide="savingProposal == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
   
	 <form  action="<?php echo base_url('estimations/create') ?>" method="post" enctype="multipart/form-data">
    <md-content class="bg-white layout-padding _md" >
	<div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          
          <input  name="estimation_project_name" id="estimation_project_name" id="estimation_project_name"class="form-control" placeholder="Enter Estimation Project Name" required="">
        </md-input-container>
		</div>
      <div layout-gt-xs="row">
      <div class="col-sm-6">
         <select class="form-control client" name="client_id" id="client_id" required="">
		 <option value="">Search or Add Client</option>
		 <?php foreach($clients as $client){ 
		 if($client['clientname'] != '') { ?>
		 <option value="<?php echo $client['client_id'];?>"><?php echo $client['clientname']; ?></option>
		 <?php }  } ?>
		 </select>
      </div> 
	  
	   <div class="col-sm-6">
         <select class="form-control contact" name="client_contact_id" id="client_contact_id" required="">
		 <option value="">Select Contact</option>
		 <?php foreach($client_contacts as $contact){ 
		 if($contact['point_contact_name'] != '') { ?>
		 <option value="<?php echo $contact['client_contact_id'];?>"><?php echo $contact['point_contact_name']; ?></option>
		 <?php }  } ?>
		 </select>
      </div> 
       
         
      </div>
      <div layout-gt-xs="row">
        	<div class="col-sm-6">
      
       <select id="salesteam" class="form-control" required name="salesteam[]"  placeholder="Select Project Salesteam">
	    
        <option value="">Select Sales Team</option>
		<?php if(isset($saleswise) && !empty($saleswise)){foreach($saleswise as $eachSale){?>
        <option value="<?php print $eachSale['id']; ?>"><?php print $eachSale['staffname']; ?></option>
		<?php } }?>
      </select>
    </div>
        <div class="col-sm-6">
      
       <select id="approval_admin" class="form-control" required name="approval_admin"  placeholder="Approval Request">
	    
       
		<?php if(isset($admin) && !empty($admin)){foreach($admin as $eachSale){?>
        <option value="<?php print $eachSale['id']; ?>"><?php print $eachSale['staffname']; ?></option>
		<?php } }?>
      </select>
    </div>      
      </div>
	  
	  <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
      <div class="md-toolbar-tools">
               <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
        </md-button>
        <h2 flex="" md-truncate="" class="md-truncate flex">Estimation Items</h2>
       
      </div>
    </md-toolbar>
	<!--
	   <legend style="padding-left:1%;"> Estimation Items</legend>
	  
	    <div class="">
        <div class="row centered-form">
            <div class="row col-xs-12 col-sm-8 col-md-12 ">
                <div class="panel panel-info">
 
 
                    <div class="panel-body">
                        <form role="form" method="post" action="">
                            
                            <div class="list_wrapper"> 

                                <div class="row">
								
								<div class="panel-info">							
							<div class="panel-heading text-center">
                   
                        <h1 class="panel-title text-left" style="padding-left:10px;">Item - 1</h1>
                    </div></div>
 
                                    <div class="col-xs-4 col-sm-4 col-md-3">
 
                                        <div class="form-group">
                                            Item Name
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
 
                                    <div class="col-xs-7 col-sm-7 col-md-2">
                                        <div class="form-group">
                                            Quantity
                                           <input type="text" name="items[qty][]" id="qty0" class="form-control" onchange="main_item(this.value,0)" value="1" readonly>
                                        </div>
                                    </div> 
									 <div class="col-xs-7 col-sm-7 col-md-2">
                                        <div class="form-group">
                                            Unit Price
                                           <input type="text" name="items[unit_price][]" id="unit_price_0" class="form-control">
                                        </div>
                                    </div> 
									 <div class="col-xs-7 col-sm-7 col-md-2">
                                        <div class="form-group">
                                            Tax %
                                           <input type="text" name="items[tax][]" id="tax_0" class="form-control" value="5">
                                        </div>
                                    </div> 
									 <div class="col-xs-7 col-sm-7 col-md-2">
                                        <div class="form-group">
                                            Total
                                           <span id="tot0">0</span>
								 <input type="hidden" name="items[amount][]" id="amount_0" class="amt" autocomplete="off" readonly>
                                        </div>
                                    </div> 
 
                                    <div class="col-xs-1 col-sm-1 col-md-1">
                                        <br>
                                       <button class="btn btn-primary list_add_button" type="button">+</button>
									     <button class="btn btn-success " type="button" onclick="showlistsku()"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
                                    </div>
									
                                </div>
								  <div class="well clearfix sub-wrapper" style="display:none;">
         <div class="row">
					
					 <div class="col-xs-4 col-sm-4 col-md-1">
 
                                        <div class="form-group">
                                           Sku
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									
									 <div class="col-xs-4 col-sm-4 col-md-1">
 
                                        <div class="form-group">
                                           Name
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									 <div class="col-xs-4 col-sm-4 col-md-2">
 
                                        <div class="form-group">
                                            Unit Cost
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									 <div class="col-xs-4 col-sm-4 col-md-1">
 
                                        <div class="form-group">
                                            Qty
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									 <div class="col-xs-4 col-sm-4 col-md-2">
 
                                        <div class="form-group">
                                           Total Cost
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									 <div class="col-xs-4 col-sm-4 col-md-2">
 
                                        <div class="form-group">
                                            Margin %
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
									 <div class="col-xs-4 col-sm-4 col-md-2">
 
                                        <div class="form-group">
                                           Selling Price
                                           <input type="text" name="items[item_name][]" id="item_name0" required="required" class="form-control" >
                                        </div>
                                    </div>
                      
						 <div class="col-xs-1 col-sm-1 col-md-1">
                                        <br>
                                       <button class="btn btn-primary list_add_button1" type="button">+</button>
									 
                                    </div>
                    
    </div> </div>
                            </div>
                            
                            <input type="submit" value="Submit" class="btn btn-info btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	-->
                  
	<input type="hidden" id="totalwgcount" name="totalwgcount" value="0">
						
					 <div class="box-body">
					 
				

						<div id="workgroup_id0" class="row centered-form" style="background:#fff;">
						<div class="col-xs-12 col-sm-8 col-md-12 ">
						 <div class="panel panel-info">
 
 
                    <div class="panel-body">
						<div class="row" id="example2" style="padding: 10px;" >
							<div class="col-sm-1">#</div>
							<div class="col-sm-2">Item Name</div>
							<div class="col-sm-2">Qty</div>
							<div class="col-sm-2">Unit Price</div>
							<div class="col-sm-2">Tax % </div>
							<div class="col-sm-2">Total</div>
							
							<div class="col-sm-1">Action</div>
							   
						</div>	
						
						<div class="row cloned-row" style="padding: 10px;">
						<div class="col-sm-1">
						<span><b>1</b></span>
						</div>
						<div class="col-sm-2">
							
								<input type="text" name="items[item_name][]"  id="item_name0" required="required" class="form-control"  onchange="select_workgroup(0);" />
								<input type="hidden" value="0" id="nextcnt0">
						</div>
						<div class="col-sm-2"><input type="text" name="items[qty][]" id="qty0" class="form-control" onchange="main_item(this.value,0)"	value="1" ></div>
						<!--onchange="change_round_helper(0,0)" -->
							<div class="col-sm-2"><input type="text" name="items[unit_price][]" id="unit_price_0" class="form-control" ></div>
							<div class="col-sm-2"><input type="text" name="items[tax][]" id="tax_0" class="form-control" value="5"></div>
							<div class="col-sm-2">
							<span id="tot0">0</span>
								<input type="hidden" name="items[amount][]" id="amount_0" class="amt"/>
							</div>
							<div class="col-sm-1">
							
							<button class="btn btn-success removeclass " type="button" onclick="select_activity(0,0);"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
							
							
							</div>                          
						</div>
						<div style="border:1px solid #ddd;padding:10px;display:none" class="row " id="border_id_0_0">
						
						<div class=" well clearfix sub-wrapper" >
						<div id="wrapper_0_0">
						 
						<div data-count="0">
						<div id="ac_id_0_0" style="display:none; margin-top:10px;" class="col-md-11 col-md-offset-1" > 
						
							<div class="col-sm-1"><label class="control-label">#</label><br><span><b>1</b></span></div>
							<div class="col-sm-1"><label class="control-label">Sku</label><input type="text" name="subitems[0][sku][]" id="sku_0_0"  class="form-control"/></div>
							<div class="col-sm-2"><label class="control-label">Name</label><select type="text" name="subitems[0][name][]" id="name_0_0" class="form-control " onchange="add_activity(this.value,0,0);">
							<?php foreach($materials as $mat) { ?>
							<option value="<?php echo $mat['material_id'];?>"><?php echo $mat['itemname']; ?></option>
							<?php } ?>
							</select></div>
							<div class="col-sm-1" style="padding:0px;"><label class="control-label">Unit Cost</label><input type="text" name="subitems[0][unit_cost][]" id="unit_cost_0_0" class="form-control" onchange="select_subcost(this.value,0,0)"/></div>
							<div class="col-sm-1"><label class="control-label">Qty</label><input type="text" name="subitems[0][qty][]" id="quantity_0_0"  class="form-control" value="1"/>
							<input type="text" id="exact_qnty_0_0" value="1" onchange="select_activityquantity(this.value,0,0)">
							</div>
							
							<div class="col-sm-1" style="padding:0px;"><label class="control-label">Margin % </label><input type="text" name="subitems[0][margin][]" id="margin_0_0" class="form-control selling_price_0_0" /></div>
							<div class="col-sm-2"><label class="control-label">Total Cost</label><input type="text" name="subitems[0][total_cost][]" id="total_cost_0_0" class="form-control tc_0" readonly /></div>
							<div class="col-sm-2"><label class="control-label">Selling Price</label><br><span id="sp_0_0" class="form-control">0</span><input type="hidden" name="subitems[0][selling_price][]" id="selling_price_0_0" class="sps_0"/></div>
							<div class="col-sm-1"><label class="control-label">Action</label>
							<!--
							<a  class="remove btn btn-danger" onclick='removediv(0,0);'>-</a>
							-->
							</div>                          
						</div>
						</div>
						</div>
						<button id="add" onclick="addMore(0,0)" class="btn btn-danger btn-lg" style="float:right;" type="button"> Add More</button> 
						</div>
						<div id="totals0" style="display:none" class="col-md-offset-1">
						
						<div class="col-md-12" style="margin-bottom: 10px;"><div class="col-md-7 p-1 text-right"><b>SubTotal:</b></div><div class="col-md-2 p-1"><span id="sub_total_cost0" >0.00</span></div><div class="col-md-1 p-1"><span id="sub_total_sp0" >0.00</span></div>
						<input type="hidden" name="items[sub_tot_cost][]" id="sub_tot_cost0"  class="sub_cs"/>
						
						<input type="hidden" name="items[sub_tot_cost_change][]" id="sub_tot_cost_change0"  class="sub_cs_change"/>
						
						<input type="hidden" name="items[sub_tot_sp][]" id="sub_tot_sp0"class="sub_sp" />
						</div>
						
						<div class="col-md-6"></div>
						<div class="col-md-3 row">
							<div class="col-sm-6"><b>Round Helper:</b></div>
						<div class="col-sm-6">	
						<input type="text"name="items[round_helper][]" id="round_helper0" class="form-control" size="4" onchange="select_round(this.value,0)" value="0">
						</div>
						</div>
						<div class="col-md-2"><b>Total:</b> <span id="ototal0">0.00</span><br>Difference: <span id="dtotal0"class="sub_diff"></span></div>
						</div>
						</div>
						
						<hr/>
						</div>
						</div>
						</div>
						</div> 
						
						<div class="col-md-12" style="background:#fff !important;">
						<div class="col-md-6" >
						<table class="table table-bordered col-md-6">
						<tr>
						<th>Total Cost:</th><td><span id="estimation_total_cost"></span><input type="hidden" name="estimation_total_cost_amt" id="estimation_total_cost_amt" /></td></tr>
						<tr><th>Estimated Profit:</th><td><span id="estimation_profit"></span><input type="hidden" name="estimation_profit_amt" id="estimation_profit_amt" /></td></tr>
						<tr><th>Tax:</th><td><span id="estimation_tax"></span><input type="hidden" name="estimation_tax_amount" id="estimation_tax_amount" /></td></tr>
						</tr>
						</table>
						</div>
						<div class="col-md-6" >
						<table class="table table-bordered col-md-6">       
						<tr>
						<th>Sub Total:</th><td><span id="subtotal"></span><input type="hidden" name="subtotal_amt" id="subtotal_amt" /></td></tr>
						<tr><th>Discount:</th><td><input type="text" name="discount" id="discount" class="form-control" value="0" onchange="select_discount(this.value);"></td></tr>
						<tr><th>Total Amount:</th><td><span id="estimation_total_amount"></span><input type="hidden" name="estimation_total_amt" id="estimation_total_amt" /></td></tr>
						</tr>
						</table>
						</div>
						<!--
						<div class="col-md-6" style="padding:10px;">
						<div ><b>Total Cost:</b><span id="estimation_total_cost"></span><input type="hidden" name="estimation_total_cost_amt" id="estimation_total_cost_amt" /></div>
						</div>
						<div class="col-md-6" style="padding:10px;">
						<div ><b>Sub Total:</b><span id="subtotal"></span><input type="hidden" name="subtotal_amt" id="subtotal_amt" /></div>
						</div>
						
						
						<div class="col-md-6" style="padding:10px;">
						<div><b>Estimated Profit:</b><span id="estimation_profit"></span><input type="hidden" name="estimation_profit_amt" id="estimation_profit_amt" /></div>
						</div>
						<div class="col-md-6" style="padding:10px;">
						<div class="col-md-6" ><b>Discount:</b></div>
						<div class="col-md-6" >
						<div class="col-sm-12" ><input type="text" name="discount" id="discount" class="form-control" value="0" onchange="select_discount(this.value);"></div>
						</div>
						</div>
						
						<div class="col-md-6" style="padding:10px;">
						<div ><b>Tax:</b><span id="estimation_tax"></span><input type="hidden" name="estimation_tax_amount" id="estimation_tax_amount" /></div>
						</div>
						<br></br>
						<div class="col-md-6" style="padding:10px;">
						<div ><b>Total Amount:</b><span id="estimation_total_amount"></span><input type="hidden" name="estimation_total_amt" id="estimation_total_amt" /></div>
						</div>
						-->
						</div>
						<span class="copy_append" style="display:none;">
							                          
							<?php foreach($materials as $mat){ ?>
								<option value="<?php echo $mat['material_id'];?>"><?php echo $mat['itemname'];?></option>		  
							<?php }	?>
						</span>
      <div class="col-md-12">
        <div class="form-group ">
		<md-toolbar class="toolbar-white _md _md-toolbar-transitions">
      <div class="md-toolbar-tools">
       
        <h2 flex="" md-truncate="" class="md-truncate flex">Special Notes / Remarks</h2>
       
      </div>
    </md-toolbar>
   
    <textarea type="text" class="form-control" id="special_notes" placeholder="" name="special_notes" rows="5" cols="30"></textarea>
  </div>
      </div>
	  <div class="col-md-12">
	  <div class="form-group ">
	  <div class="file-upload-wrapper">
  <input type="file" name="file[]" id="file" multiple />
</div>
</div>
</div>
<div class="col-md-12">
<input type="submit" name="submit" id="submit" value="Create" class="btn btn-primary col-md-6" style="float:right;">  
</div>
 </form>
      
    </md-content>
        <custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0"></custom-fields-vertical> 
	</div>

</div>


</div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>"></script>




<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script>
    ClassicEditor
            .create( document.querySelector( '#special_notes' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
<script type="text/javascript">

		
		 	
function select_workgroup(num){
	
	var nxtcnt=$('#nextcnt'+num+'').val();
	if(nxtcnt==0){
	var val = num+1;
	$('#nextcnt'+num+'').val('1');
	var k = val+1;
	
	$("#getMessage"+num+"").hide();
	//document.getElementById("getMessage"+num+"").style.visibility="hidden";
	$('div#workgroup_id'+num+'').after("<div id='workgroup_id"+val+"' class='row centered-form' style='background:#fff;'><div class='col-xs-12 col-sm-8 col-md-12 '><div class='panel panel-info'><div class='panel-body'><div class='row cloned-row' style='padding: 10px;'><div class='col-sm-1'><b>"+k+"</b></div><div class='col-sm-2'><input type='text' name='items[item_name][]' id='item_name"+val+"' class='form-control' onchange='select_workgroup("+val+");'/><input type='hidden' value='0' id='nextcnt"+val+"'></div><div class='col-sm-2'><input type='text' name='items[qty][]' id='qty"+val+"' class='form-control' value='1' onchange='main_item(this.value,"+val+")'></div><div class='col-sm-2'><input type='text' name='items[unit_price][]' id='unit_price_"+val+"' class='form-control' ></div><div class='col-sm-2'><input type='text' name='items[tax][]' id='tax_"+val+"' class='form-control' value='5'></div><div class='col-sm-2'><span id='tot"+val+"'>0</span><input type='hidden' name='items[amount][]' id='amount_"+val+"' class='amt'/></div><div class='col-sm-1'> <button class='btn btn-success removeclass' type='button' onclick='select_activity("+val+",0);' style='float: left;margin-right:1px;'><i class='glyphicon glyphicon-circle-arrow-down'></i></button> <button class='btn btn-success' type='button' onclick='remove_activity("+val+",0);'><i class='glyphicon glyphicon-trash'></i></button></div></div><div style='border: 1px solid rgb(221, 221, 221); padding: 10px;display:none;' class='row ' id='border_id_"+val+"_0'><div class=' well clearfix sub-wrapper'><div id='wrapper_"+val+"_0'><div data-count='0'><div id='ac_id_"+val+"_0' style='display:none;' class='d col-md-11 col-md-offset-1' style='margin-top: 10px;'><div class='' ><div class='col-sm-1'><b>1</b></div><div class='col-sm-1'><label class='control-label'>Sku</label><input type='text' name='subitems["+val+"][sku][]' id='sku_"+val+"_0'  class='form-control'/></div><div class='col-sm-2'><label class='control-label'>Name</label><select  name='subitems["+val+"][name][]' id='name_"+val+"_0' class='form-control' onchange='add_activity(this.value,"+val+",0)'>"+$('.copy_append').html()+"</select></div><div class='col-sm-1' style='padding:0px;'><label class='control-label'>Unit Cost</label><input type='text' name='subitems["+val+"][unit_cost][]' id='unit_cost_"+val+"_0' class='form-control' onchange='select_subcost(this.value,"+val+",0)'/></div><div class='col-sm-1'><label class='control-label'>Qty</label><input type='text' name='subitems["+val+"][qty][]' id='quantity_"+val+"_0' onchange='select_activityquantity(this.value,"+val+",0)' class='form-control' value='1'/><input type='text' id='exact_qnty_"+val+"_0' value='1'></div><div class='col-sm-1' style='padding:0px;'><label class='control-label'>Margin % </label><input type='text' name='subitems["+val+"][margin][]' id='margin_"+val+"_0' class='form-control selling_price_"+val+"_0'/></div><div class='col-sm-2'><label class='control-label'>Total Cost</label><input type='text' name='subitems["+val+"][total_cost][]' id='total_cost_"+val+"_0' class='form-control tc_"+val+"' readonly /></div><div class='col-sm-2'><label class='control-label'>Selling Price</label><br><span id='sp_"+val+"_0' class='form-control'>0</span><input type='hidden' name='subitems["+val+"][selling_price][]' id='selling_price_"+val+"_0' class='sps_"+val+"' /></div></div></div></div></div><button id='add' onclick='addMore("+val+",0)' class='btn btn-danger btn-lg' style='float:right;' type='button'> Add More</button></div><div id='totals"+val+"' style='display:none' class='col-md-offset-1'><div class='col-md-12' style='margin-bottom: 10px;'><div ><div class='col-md-7 p-1 text-right'><b>SubTotal:</b></div><div class='col-md-2 p-1'><span id='sub_total_cost"+val+"' >0.00</span></div><div class='col-md-1 p-1'><span id='sub_total_sp"+val+"' >0.00</span></div><input type='hidden' name='items[sub_tot_cost][]' id='sub_tot_cost"+val+"' class='sub_cs'/><input type='hidden' name='items[sub_tot_cost_change][]' id='sub_tot_cost_change"+val+"' class='sub_cs_change'/><input type='hidden' name='items[sub_tot_sp][]' id='sub_tot_sp"+val+"' class='sub_sp' /></div></div><div class='col-md-6'></div><div class='col-md-3 row'><div class='col-sm-3'><b>Round Helper:</b></div><div class='col-sm-5'><input type='text' name='items[round_helper][]' id='round_helper"+val+"' class='form-control' size='4' onchange='select_round(this.value,"+val+")' value='0'></div></div><div class='col-md-2'><b>Total:</b><span id='ototal"+val+"'></span><br>Difference: <span id='dtotal"+val+"' class='sub_diff'></span></div></div></div><hr/></div></div></div>");
	
	
	}
}

function select_activity(workcount,activitycount){
	//alert(workcount);
	//alert(activitycount);
	
	$('#border_id_'+workcount+'_'+activitycount+'').toggle();
	$('#ac_id_'+workcount+'_'+activitycount+'').toggle();
	$('#totals'+workcount).toggle();
	
	
	
}  
function add_activity(value,workgroup_count,activity_count){
	
	var material_id = value;
	
	$.ajax({
              url : "<?php echo base_url(); ?>estimations/get_material_data",
              data:{material_id : material_id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				 
				 $('#sku_'+workgroup_count+'_'+activity_count).val(response.item_code);
				$('#unit_cost_'+workgroup_count+'_'+activity_count).val(response.cost);
			$('#margin_'+workgroup_count+'_'+activity_count).val(response.margin_value);
			var quantity = $('#quantity_'+workgroup_count+'_'+activity_count).val();
		$('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*response.cost);
			var margin_value = $('#margin_'+workgroup_count+'_'+activity_count).val();
		var sp =  parseFloat((1+(margin_value/100))*$('#total_cost_'+workgroup_count+'_'+activity_count).val());
			$('#sp_'+workgroup_count+'_'+activity_count).html(sp);
			
			$('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
			
			 tot_sal = 0;
    
$('input.sps_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_sal += value;
						
					}				
});

$('#sub_total_sp'+workgroup_count).html(tot_sal);
$('#unit_price_'+workgroup_count).val(tot_sal);
$('#sub_tot_sp'+workgroup_count).val(tot_sal);

total_ucost = 0;
$('input.tc_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_ucost += value;
						
					}		
});
$('#sub_total_cost'+workgroup_count).html(total_ucost);
$('#sub_tot_cost'+workgroup_count).val(total_ucost);
		var mainqty = parseFloat($('#qty'+workgroup_count).val());	
		/*var round_value = parseFloat($('#round_helper'+workgroup_count).val());
			
		if (!isNaN(round_value)){ 
			round = round_value;
		}else{
			
			round = 0;
		}
		*/
		round = 0;
		$('#round_helper'+workgroup_count).val(round);
			
	$('#unit_price_'+workgroup_count).val(tot_sal+parseFloat(round)/mainqty);
	$('#tot'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
	
	$('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#dtotal'+workgroup_count).html('');
			
			total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});
			$('#estimation_total_cost').html(total_eucost);
			$('#estimation_total_cost_amt').val(total_eucost);
			
			
			total_profit = 0;
$('input.sub_sp').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_profit += value;
						
					}		
}); 
			$('#estimation_profit').html(total_profit-total_eucost);
			$('#estimation_profit_amt').val(total_profit-total_eucost);
                tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}		
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

var tax_amt = (tot_amt)*(5/100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

$('#estimation_total_amount').html(parseFloat(tax_amt)+parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
				
            }
          });
		   
	
} 

function addMore(workgroup_count,activity_count){
	var qty=$('#qty'+workgroup_count+'').val();
  var act_count = $('#wrapper_'+workgroup_count+'_'+activity_count+' > div:last').data('count')+1 || 0;
  var j = act_count+1;
  $('#wrapper_'+workgroup_count+'_'+activity_count+'').append("<div data-count='"+act_count+"'><div id='ac_id_"+workgroup_count+"_"+act_count+"' class='d col-md-11 col-md-offset-1' style='margin-top: 10px;' ><div class='' ><div class='col-sm-1 ' >"+j+"</div><div class='col-sm-1'><input type='text' name='subitems["+workgroup_count+"][sku][]' id='sku_"+workgroup_count+"_"+act_count+"'  class='form-control  '/></div><div class='col-sm-2'><select  name='subitems["+workgroup_count+"][name][]' id='name_"+workgroup_count+"_"+act_count+"' class='form-control ' onchange='add_activity(this.value,"+workgroup_count+","+act_count+")'>"+$('.copy_append').html()+"</select></div><div class='col-sm-1' style='padding:0px;'><input type='text' name='subitems["+workgroup_count+"][unit_cost][]' id='unit_cost_"+workgroup_count+"_"+act_count+"' class='form-control' onchange='select_subcost(this.value,"+workgroup_count+","+act_count+")'/></div><div class='col-sm-1'><input type='text' name='subitems["+workgroup_count+"][qty][]' id='quantity_"+workgroup_count+"_"+act_count+"' class='form-control' value='"+qty+"'/><input type='text' id='exact_qnty_"+workgroup_count+"_"+act_count+"' value='1' onchange='select_activityquantity(this.value,"+workgroup_count+","+act_count+")' ></div><div class='col-sm-1' style='padding:0px;'><input type='text' name='subitems["+workgroup_count+"][margin][]' id='margin_"+workgroup_count+"_"+act_count+"' class='form-control selling_price_"+workgroup_count+"_"+act_count+"'/></div><div class='col-sm-2'><input type='text' name='subitems["+workgroup_count+"][total_cost][]' id='total_cost_"+workgroup_count+"_"+act_count+"' class='form-control tc_"+workgroup_count+"' readonly /></div><div class='col-sm-2'><span id='sp_"+workgroup_count+"_"+act_count+"' class='form-control'>0</span><input type='hidden' name='subitems["+workgroup_count+"][selling_price][]' id='selling_price_"+workgroup_count+"_"+act_count+"' class='sps_"+workgroup_count+"' /></div><div class='col-sm-1'><a  class='remove btn btn-danger' onclick='removediv("+workgroup_count+","+act_count+");'>-</a> </div></div></div>");
  
 
}

function removediv(workgroup_count,act_count)
{   

	round = 0;
		$('#round_helper'+workgroup_count).val(round);
		$('#dtotal'+workgroup_count).html('');
		
	var total=$("#selling_price_"+workgroup_count+"_"+act_count+"").val();
	var subtotl=$("#total_cost_"+workgroup_count+"_"+act_count+"").val();
	
	var maintot=$("#sub_tot_sp"+workgroup_count+"").val();
	var mainsbtot=$("#sub_tot_cost"+workgroup_count+"").val();
	
	var differ=maintot - total;
	$("#sub_tot_sp"+workgroup_count+"").val(differ);
	$('#sub_total_sp'+workgroup_count+'').html(differ);
	
	var subdiffer=mainsbtot - subtotl;	

	$('#sub_total_cost'+workgroup_count+'').html(subdiffer);
	$('#sub_tot_cost'+workgroup_count).val(subdiffer);
	
	$("#amount_"+workgroup_count+"").val(differ);
	$('#tot'+workgroup_count+'').html(differ);
	$("#unit_price_"+workgroup_count+"").val(differ);
	$("#ototal"+workgroup_count+"").html(differ);
	
	
	$("#ac_id_"+workgroup_count+"_"+act_count+"").parent('div').remove();
	get_total_change();
}

function get_total_change()
{
	
	total_eucost = 0;
$('input.sub_cs').each(function() {
    var value = parseFloat($(this).val());

    if (!isNaN(value)) {
        total_eucost += value;

    }
});
$('#estimation_total_cost').html(total_eucost);
$('#estimation_total_cost_amt').val(total_eucost);



total_profit = 0;
$('input.sub_sp').each(function() {
    var value = parseFloat($(this).val());

    if (!isNaN(value)) {
        total_profit += value;

    }
});
$('#estimation_profit').html(total_profit - total_eucost);
$('#estimation_profit_amt').val(total_profit - total_eucost);

var tax_amt = (tot_amt) * (5 / 100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

tot_amt = 0;
$('input.amt').each(function() {
    var value = parseFloat($(this).val());

    if (!isNaN(value)) {
        tot_amt += value;

    }
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

$('#estimation_total_amount').html(parseFloat(tax_amt) + parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt) + parseFloat(tot_amt));
}
$('body').on('change','#client_id',function() { 

var client_id = $('#client_id').val();

 $.ajax({
              url : "<?php echo base_url(); ?>estimations/get_client_contacts",
              data:{ client_id : client_id},
              method:'POST',
             // dataType:'json',
              success:function(data) {
				 
                $('#client_contact_id').html(data);
            }
          });

});

function select_subcost(val,workgroup_count,activity_count){
	var unit_cost = val;
	var quantity = parseFloat($('#quantity_'+workgroup_count+'_'+activity_count).val());
	var margin_value = parseFloat($('#margin_'+workgroup_count+'_'+activity_count).val());
	$('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*unit_cost);
	var sp =  parseFloat((1+(margin_value/100))*parseFloat($('#total_cost_'+workgroup_count+'_'+activity_count).val()));
	$('#sp_'+workgroup_count+'_'+activity_count).html(sp);
	$('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
	
	 tot_sal = 0;
    
$('input.sps_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					if (!isNaN(value)){ 			
						tot_sal += value;
						
					}			
});

$('#sub_total_sp'+workgroup_count).html(tot_sal);
$('#sub_tot_sp'+workgroup_count).val(tot_sal);
total_ucost = 0;
$('input.tc_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_ucost += value;
						
					}		
});
$('#sub_total_cost'+workgroup_count).html(total_ucost);
$('#sub_tot_cost'+workgroup_count).val(total_ucost);
		var mainqty = parseFloat($('#qty'+workgroup_count).val());
		var round_value = parseFloat($('#round_helper'+workgroup_count).val());		
		
		if (!isNaN(round_value)){ 
		round = round_value;
		}else{
			round = 0;
		}
	$('#unit_price_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round)/mainqty);
	$('#tot'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
	$('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	
	total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});
			$('#estimation_total_cost').html(total_eucost);
			$('#estimation_total_cost_amt').val(total_eucost);
			
			
			total_profit = 0;
$('input.sub_sp').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_profit += value;
						
					}		
});
			$('#estimation_profit').html(total_profit-total_eucost);
			$('#estimation_profit_amt').val(total_profit-total_eucost);
                tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}		
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

var tax_amt = (tot_amt)*(5/100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

$('#estimation_total_amount').html(parseFloat(tax_amt)+parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
			
	
		
}
function select_activityquantity(val,workgroup_count,activity_count){
	var mainqty=$('#qty'+workgroup_count+'').val();
	var quantity = val;
	$('#quantity_'+workgroup_count+'_'+activity_count).val(mainqty*val);
	$('#exact_qnty_'+workgroup_count+'_'+activity_count).val(quantity);
	var unit_cost = $('#unit_cost_'+workgroup_count+'_'+activity_count).val();
	var margin_value = $('#margin_'+workgroup_count+'_'+activity_count).val();
	$('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*unit_cost*mainqty);
	var sp =  parseFloat((1+(margin_value/100))*$('#total_cost_'+workgroup_count+'_'+activity_count).val());
	$('#sp_'+workgroup_count+'_'+activity_count).html(sp);
	$('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
	
	 tot_sal = 0;
  
$('input.sps_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					if (!isNaN(value)){ 			
						tot_sal += value;
						
						
					}			
});
$('#sub_total_sp'+workgroup_count).html(tot_sal);
$('#sub_tot_sp'+workgroup_count).val(tot_sal);
total_ucost = 0;
$('input.tc_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_ucost += value;
						
					}		
});
				$('#sub_total_cost'+workgroup_count).html(total_ucost);
				$('#sub_tot_cost'+workgroup_count).val(total_ucost);
				var mainqty = parseFloat($('#qty'+workgroup_count).val());
				/*
				var round_value = parseFloat($('#round_helper'+workgroup_count).val());
				
										if (!isNaN(round_value)){ 
										round = round_value;
										
										}else{
											round = 0;
										}
				
	$('#unit_price_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round)/mainqty);
	$('#tot'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
	$('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	*/
	
	var round = 0;
	$('#round_helper'+workgroup_count).val(round);
	$('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
	$('#dtotal'+workgroup_count).html('');
	$('#tot'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
	$('#unit_price_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round)/mainqty);
	
	
	total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});
			$('#estimation_total_cost').html(total_eucost);
			$('#estimation_total_cost_amt').val(total_eucost);
			
			
			total_profit = 0;
$('input.sub_sp').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_profit += value;
						
					}		
});
			$('#estimation_profit').html(total_profit-total_eucost);
			$('#estimation_profit_amt').val(total_profit-total_eucost);
                tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}		
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

var tax_amt = (tot_amt)*(5/100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

$('#estimation_total_amount').html(parseFloat(tax_amt)+parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
			
	
	
}



function main_item(val,workgroup_count){
	
	//alert(default_val);
	var qty = val;
var k = 0;
tot_sal = 0; 
$('input.sps_'+workgroup_count).each(function() { 

var itemqty=$('#exact_qnty_'+workgroup_count+'_'+k).val();
$('#quantity_'+workgroup_count+'_'+k).val(qty*itemqty);	
	var unit_cost = $('#unit_cost_'+workgroup_count+'_'+k).val();
	var margin_value = $('#margin_'+workgroup_count+'_'+k).val();
	var quantity = $('#quantity_'+workgroup_count+'_'+k).val();	
		var round = 0;
	$('#round_helper'+workgroup_count).val(round);
	
	$('#dtotal'+workgroup_count).html('');	
	
	$('#total_cost_'+workgroup_count+'_'+k).val(quantity*unit_cost);
	
	var sp =  parseFloat((1+(margin_value/100))*($('#total_cost_'+workgroup_count+'_'+k).val()));
	$('#sp_'+workgroup_count+'_'+k).html(sp);
	$('#selling_price_'+workgroup_count+'_'+k).val(sp);
	
	var value = parseFloat($(this).val());
					if (!isNaN(value)){ 			
						tot_sal += value;
						
						
					}	
k++;	
});

$('#sub_total_sp'+workgroup_count).html(tot_sal);
$('#sub_tot_sp'+workgroup_count).val(tot_sal);
total_ucost = 0;
$('input.tc_'+workgroup_count).each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_ucost += value;
						
					}		
});
$('#sub_total_cost'+workgroup_count).html(total_ucost);
$('#sub_tot_cost'+workgroup_count).val(total_ucost);

	$('#unit_price_'+workgroup_count).val((tot_sal/qty)+parseFloat(round));
	$('#tot'+workgroup_count).html(tot_sal+parseFloat(round));
	$('#amount_'+workgroup_count).val(tot_sal+parseFloat(round));
	
	/*
	var mainvalue=$('#unit_price_'+workgroup_count+'').val();
	
	var mainvalue1=$('#sub_total_sp'+workgroup_count+'').html();
	
	var rounderhelper=mainvalue  - mainvalue1;
	$('#round_helper'+workgroup_count+'').val(rounderhelper);
	*/
	
	
	$('#samount_'+workgroup_count).val(tot_sal);
	$('#ototal'+workgroup_count).html(tot_sal+parseFloat(round));
	
	total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});
			$('#estimation_total_cost').html(total_eucost);
			$('#estimation_total_cost_amt').val(total_eucost);
			
			
			total_profit = 0;
$('input.sub_sp').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_profit += value;
						
					}		
});
			$('#estimation_profit').html(total_profit-total_eucost);
			$('#estimation_profit_amt').val(total_profit-total_eucost);
                tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}		
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

var tax_amt = (tot_amt)*(5/100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

$('#estimation_total_amount').html(parseFloat(tax_amt)+parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));


			
	
}

function remove_activity(workgroup_count)
{
	var lastid=workgroup_count-1;
	$('#nextcnt'+lastid+'').val(0);
	$('#workgroup_id'+workgroup_count+'').remove();
	get_total_change();
	var sub_total_sp=$('#sub_total_sp'+workgroup_count).html();
	var sub_total_cost=$('#sub_total_cost'+workgroup_count).html();
	var subtotal_amt=$('#subtotal_amt').val();
	var estimation_total_cost_amt=$('#estimation_total_cost_amt').val();
}



function select_round(val,workgroup_count){
	var round_value = parseFloat(val);
	
	var line_tot = parseFloat($('#unit_price_'+workgroup_count).val());
	var quantity = parseFloat($('#qty'+workgroup_count).val());

	
	
	if (!isNaN(line_tot)){ 	
					var ln_tot = line_tot;				
					}
		else{
		var ln_tot = 0;
		}
    if (!isNaN(round_value)){ 
	var round = round_value;
	}else{
		var round = 0;
	}
					
					var maintot=$('#ototal'+workgroup_count).html();
					
					var differ=parseFloat(round) - parseFloat(maintot);
					
					$('#dtotal'+workgroup_count).html(differ);
					
					$('#amount_'+workgroup_count).val(parseFloat(round));
					$('#tot'+workgroup_count).html(parseFloat(round));
					$('#unit_price_'+workgroup_count).val(parseFloat(round));
					
					
						total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});

						total_diff = 0;
$('.sub_diff').each(function() { 
					var value1 = parseFloat($(this).text());
					console.log(value1);
					if (!isNaN(value1)){ 			
						total_diff += value1;
						
					}		
});




   
$('#estimation_total_cost_amt').val(total_eucost);
$('#estimation_total_cost').html(total_eucost);


	total_profit = 0;
$('input.sub_sp').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_profit += value;
						
					}		
});
			$('#estimation_profit').html(total_profit-total_eucost+total_diff);
			$('#estimation_profit_amt').val(total_profit-total_eucost+total_diff);
			
			
			
                tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}		
});

$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);

var tax_amt = (tot_amt)*(5/100);
$('#estimation_tax').html(tax_amt.toFixed(2));
$('#estimation_tax_amount').val(tax_amt.toFixed(2));

$('#estimation_total_amount').html(parseFloat(tax_amt)+parseFloat(tot_amt));
$('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
			
			
			
		
		
	
					
					return false;
	$('#unit_price_'+workgroup_count).val(parseFloat(ln_tot)+parseFloat(round));
	$('#tot'+workgroup_count).html(parseFloat(ln_tot)+parseFloat(round));
	$('#amount_'+workgroup_count).val(parseFloat(ln_tot)+parseFloat(round));
	$('#ototal'+workgroup_count).html(parseFloat(ln_tot)+parseFloat(round));
	
	
			
			
		


			
	
}


function select_discount(val){
	var discount = val;
	var estimated_profit = $('#estimation_profit_amt').val();
	var tot = $('#estimation_total_amt').val();
	
	$('#estimation_profit_amt').val(estimated_profit-discount);
	$('#estimation_profit').html(estimated_profit-discount);
	
	$('#estimation_total_amount').html(tot-discount);
$('#estimation_total_amt').val(tot-discount);
	
}
function add_estimation(){
	
	 url = "<?php echo base_url(); ?>estimations/create";
	 window.location.reload(url);
	
	
}
	</script>
	<script>
	$(document).ready(function()

    {
	var x = 0; //Initial field counter
	var y = 0; 
	var list_maxField = 10; //Input fields increment limitation
	
        //Once add button is clicked
	$('.list_add_button').click(function()
	    {
	    //Check maximum number of input fields
	    if(x < list_maxField){ 
	        x++; //Increment field counter
	        var list_fieldHTML = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-3"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Name" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button btn btn-danger">-</a></div></div>'; //New input field html 
	        $('.list_wrapper').append(list_fieldHTML); //Add field html
	    }
        });
    
        //Once remove button is clicked
        $('.list_wrapper').on('click', '.list_remove_button', function()
        {
           $(this).closest('div.row').remove(); //Remove field html
           x--; //Decrement field counter
        });
		
		//sub div
		
		     //Once add button is clicked
	$('.list_add_button1').click(function()
	    {
	    //Check maximum number of input fields
	    if(y < list_maxField){ 
	        y++; //Increment field counter
	        var list_fieldHTML1 = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="SKU" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="SKU" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button1 btn btn-danger">-</a></div></div>'; //New input field html 
	        $('.sub-wrapper').append(list_fieldHTML1); //Add field html
	    }
        });
    
        //Once remove button is clicked
        $('.sub-wrapper').on('click', '.list_remove_button1', function()
        {
           $(this).closest('div.row').remove(); //Remove field html
           y--; //Decrement field counter
        });
		
});

function showlistsku()
{
	
	$('.sub-wrapper').toggle();
}

function change_round_helper(workcount,activitycount)
{
	var mainvalue=$('#unit_price_'+workcount+'').val();
	
	var mainvalue1=$('#sub_total_sp'+workcount+'').html();
	
	var rounderhelper=mainvalue  - mainvalue1;
	$('#round_helper'+workcount+'').val(rounderhelper);
	
	var qty=$('#qty'+workcount+'').val();
	
	var tofinal=qty * mainvalue;
	$('#tot'+workcount+'').html(tofinal);
	$('#amount_'+workcount+'').val(tofinal);
	$('#ototal'+workcount).html(tofinal);
	
	
	 tot_amt = 0;
				$('input.amt').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						tot_amt += value;
						
					}
				});
					
					$('#subtotal').html(tot_amt);
$('#subtotal_amt').val(tot_amt);
	
	
		total_eucost = 0;
$('input.sub_cs').each(function() { 
					var value = parseFloat($(this).val());
					
					if (!isNaN(value)){ 			
						total_eucost += value;
						
					}		
});

$('#estimation_profit').html(tot_amt-total_eucost);
$('#estimation_profit_amt').val(tot_amt-total_eucost);
	
}
	</script>
	
	