<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" >
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-9"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('createestimation') ?></h2>
        <md-switch ng-model="proposal_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php echo lang('for_lead')?></strong></md-switch>
        <md-button ng-href="<?php echo base_url('proposals')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-danger"></i></md-icon>
        </md-button>
        <md-button type="button" ng-click="saveAll()" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-progress-circular ng-show="savingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="savingProposal == true" md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
          <md-icon ng-hide="savingProposal == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <div ng-show="proposalsLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
         <span>
            <?php echo lang('please_wait') ?> <br>
           <small><strong><?php echo lang('loading').'...' ?></strong></small>
         </span>
       </p>
     </div>
    <md-content ng-show="!proposalsLoader" class="bg-white" layout-padding ng-cloak>
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
	   <legend style="padding-left:1%;"> Estimation Items</legend>
                  
	<input type="hidden" id="totalwgcount" name="totalwgcount" value="0">
						
					 <div class="box-body">
						<div id="workgroup_id0">
						<div class="row" id="example2" class="table table-bordered table-striped" style="background-color:#3c8dbc;padding:10px 0px;margin:0px -9px;">
							<div class="col-sm-1">#</div>
							<div class="col-sm-2">Item Name</div>
							<div class="col-sm-2">Qty</div>
							<div class="col-sm-2">Unit Price</div>
							<div class="col-sm-2">Tax % </div>
							<div class="col-sm-2">Total</div>
							   
						</div>	
						<div class="row cloned-row" style="background-color:#d1e1f9;padding:10px 0px;margin:5px -9px;">
						<div class="col-sm-1">
						<span><b>1</b></span>
						</div>
						<div class="col-sm-2">
							
								<input type="text" name="items[item_name][]"  id="item_name0" required="required" class="form-control"  onchange="select_workgroup(0);" />
						</div>
						<div class="col-sm-2"><input type="text" name="items[qty][]" id="qty0" class="form-control" value="1"></div>
							<div class="col-sm-2"><input type="text" name="items[unit_price][]" id="unit_price_0" class="form-control"></div>
							<div class="col-sm-2"><input type="text" name="items[tax][]" id="tax_0" class="form-control"></div>
							<div class="col-sm-2">
							<span id="tot0">Total : </span>
								<input type="hidden" name="items[amount][]" id="amount_0"/>
							</div>
							<div class="col-sm-2">
							<a href="#"><i class="fa fa-times-circle"></i> </a> &nbsp &nbsp  | &nbsp <a onclick="select_activity(0,0);" class="removeclass"><i class="fa fa-chevron-circle-down"></i></a> 
							</div>                          
						</div>
						
						<div id="ac_id_0_0" style="display:none;">
						<div class="row" style="background-color:#c9eced;padding:10px 0px;margin:5px -9px;">
						
							<div class="col-sm-1"><span><b>1</b></span></div>
							<div class="col-sm-1"><label class="control-label">Sku</label><input type="text" name="subitems[0][sku][]" id="sku_0_0"  class="form-control"/></div>
							<div class="col-sm-2"><label class="control-label">Name</label><select type="text" name="subitems[0][name][]" id="name_0_0" class="form-control sub" onchange="add_activity(this.value,0,0);">
							<?php foreach($materials as $mat) { ?>
							<option value="<?php echo $mat['material_id'];?>"><?php echo $mat['itemname']; ?></option>
							<?php } ?>
							</select></div>
							<div class="col-sm-1"><label class="control-label">Unit Cost</label><input type="text" name="subitems[0][unit_cost][]" id="unit_cost_0_0" class="form-control"/></div>
							<div class="col-sm-1"><label class="control-label">Qty</label><input type="text" name="subitems[0][qty][]" id="quantity_0_0" onchange="select_activityquantity(this.value,0,0)" class="form-control" value="1"/></div>
							<div class="col-sm-2"><label class="control-label">Total Cost</label><input type="text" name="subitems[0][total_cost][]" id="total_cost_0_0" class="form-control" /></div>
							<div class="col-sm-1"><label class="control-label">Margin % </label><input type="text" name="subitems[0][margin][]" id="margin_0_0" class="form-control selling_price_0_0"/></div>
							<div class="col-sm-1"><label class="control-label">Selling Price</label><input type="hidden" name="subitems[0][selling_price][]" id="selling_price_0_0" class="selling_price_0_0"/></div>
							<div class="col-sm-2">
							<a href="#"><i class="fa fa-times-circle"></i> </a> 
							</div>                          
						</div>
						</div>
						</div>
						<span class="copy_append" style="display:none;">
							                          
							<?php foreach($materials as $mat){ ?>
								<option value="<?php echo $mat['material_id'];?>"><?php echo $mat['itemname'];?></option>		  
							<?php }	?>
						</span>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('detail') ?></label>
          <textarea ng-model="content" rows="3"></textarea>
        </md-input-container>
      </div>
      <md-checkbox class="pull-right" ng-model="comment" aria-label="Comment"> <strong class="text-muted text-uppercase"><?php echo lang('allowcomments');?></strong> </md-checkbox>
    </md-content>
    <md-content ng-show="!proposalsLoader" class="bg-white" layout-padding ng-cloak>
      <md-list-item ng-repeat="item in proposal.items">
        <div layout-gt-sm="row">
          <md-autocomplete
  	  	 	md-autofocus
  	  	 	md-items="product in GetProduct(item.name)"
		    md-search-text="item.name"
		    md-item-text="product.name"   
		    md-selected-item="selectedProduct"
		    md-no-cache="true"
		    md-min-length="0"
		    md-floating-label="<?php echo lang('productservice'); ?>">
            <md-item-template> <span md-highlight-text="item.name">{{product.name}}</span> <strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong> </md-item-template>
          </md-autocomplete>
          <md-input-container class="md-block">
            <label><?php echo lang('description'); ?></label>
            <input class="min_input_width" type="hidden" ng-model="item.name">
            <bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
            <textarea class="min_input_width" ng-model="item.description" placeholder="<?php echo lang('description'); ?>"></textarea>
            <bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
            <input class="min_input_width" type="hidden" ng-model="item.product_id">
            <bind-expression ng-init="selectedProduct.product_id = item.product_id" expression="selectedProduct.product_id" ng-model="item.product_id" />
            <input class="min_input_width" type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
            <bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('quantity'); ?></label>
            <input class="min_input_width" ng-model="item.quantity" >
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('unit'); ?></label>
            <input class="min_input_width" ng-model="item.unit" >
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('price'); ?></label>
            <input class="min_input_width" ng-model="item.price">
            <bind-expression ng-init="selectedProduct.price = 0" expression="selectedProduct.price" ng-model="item.price" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo $appconfig['tax_label']; ?></label>
            <input class="min_input_width" ng-model="item.tax">
            <bind-expression ng-init="selectedProduct.tax = 0" expression="selectedProduct.tax" ng-model="item.tax" />
          </md-input-container>
          <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('discount'); ?></label>
            <input class="min_input_width" ng-model="item.discount">
          </md-input-container>
          <md-input-container class="md-block">
            <label><?php echo lang('total'); ?></label>
            <input class="min_input_width" ng-value="item.quantity * item.price + ((item.tax)/100*item.quantity * item.price) - ((item.discount)/100*item.quantity * item.price)">
          </md-input-container>
        </div>
        <md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
      </md-list-item>
      <md-content class="bg-white" layout-padding>
        <div class="col-md-6">
          <md-button ng-click="add()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
            <md-icon class="ion-plus-round text-muted"></md-icon>
          </md-button>
        </div>
        <div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
          <div class="col-md-7">
            <div class="text-right text-uppercase text-muted"><?php echo lang('sub_total') ?>:</div>
            <div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted"><?php echo lang('total_discount') ?>:</div>
            <div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted"><?php echo lang('total').' '.$appconfig['tax_label'] ?>:</div>
            <div class="text-right text-uppercase text-black"><?php echo lang('grand_total') ?>:</div>
          </div>
          <div class="col-md-5">
            <div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
            <div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
          </div>
          <div class="form-group ">
    <label for="inputAddress"><b>Special Notes / Remarks</b></label>
    <textarea type="text" class="form-control" id="special_notes" placeholder="" name="special_notes" rows="7"></textarea>
  </div>
        </div>
      </md-content>
    </md-content>
    <custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0"></custom-fields-vertical> 
	</div>
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3">
    <ciuis-sidebar></ciuis-sidebar>
  </div>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>

<script>
    ClassicEditor
            .create( document.querySelector( '#special_notes' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
<script type="text/javascript">
    $(document).ready(function() {

 $(".client").select2({
			//placeholder: "Select .."
	});
	$(".contact").select2({
			//placeholder: "Select .."
	});
	$(".sub").select2({
	
	});
	
});

function select_workgroup(num){
	var val = num+1;
	var k = val+1;
	$("#getMessage"+num+"").hide();
	//document.getElementById("getMessage"+num+"").style.visibility="hidden";
	$('div#workgroup_id'+num+'').after("<div class='row' id='example2' class='table table-bordered table-striped' style='background-color:#3c8dbc;padding:10px 0px;margin:0px -9px;'><div class='col-sm-1'>#</div><div class='col-sm-1'>Item Name</div><div class='col-sm-2'>Qty</div><div class='col-sm-2'>Unit Price</div><div class='col-sm-2'>Tax % </div><div class='col-sm-2'>Total</div></div><div id='workgroup_id"+val+"'><div class='row' style='background-color:#d1e1f9;padding:10px 0px;margin:5px -9px;'><div class='col-sm-1'><b>"+k+"</b></div><div class='col-sm-2'><input type='text' name='items[item_name][]' id='item_name"+val+"' class='form-control' onchange='select_workgroup("+val+");'/></div><div class='col-sm-2'><input type='text' name='items[qty][]' id='qty"+val+"' class='form-control' value='1'></div><div class='col-sm-2'><input type='text' name='items[unit_price][]' id='unit_price_"+val+"' class='form-control'></div><div class='col-sm-2'><input type='text' name='items[tax][]' id='tax_"+val+"' class='form-control'></div><div class='col-sm-2'><span id='tot"+val+"'></span><input type='hidden' name='items[amount][]' id='amount_"+val+"'/></div><div class='col-sm-2'><a href=''><i class='fa fa-times-circle'></i> </a> &nbsp &nbsp  | &nbsp <a onclick='select_activity("+val+",0);' class='removeclass'><i class='fa fa-chevron-circle-down'></i></a> &nbsp &nbsp  | &nbsp </div></div><div id='ac_id_"+val+"_0'style='display:none;' class='d'><div class='row' style='background-color:#c9eced;padding:10px 0px;margin:5px -9px;'><div class='col-sm-1'><b>1</b></div><div class='col-sm-1'><label class='control-label'>Sku</label><input type='text' name='subitems["+val+"][sku][]' id='sku_"+val+"_0'  class='form-control'/></div><div class='col-sm-2'><label class='control-label'>Name</label><select type='text' name='subitems["+val+"][name][]' id='name_"+val+"_0' class='form-control sub' onchange='add_activity(this.value,"+val+",0)'>"+$('.copy_append').html()+"</select></div><div class='col-sm-1'><label class='control-label'>Unit Cost</label><input type='text' name='subitems["+val+"][unit_cost][]' id='unit_cost_"+val+"_0' class='form-control'/></div><div class='col-sm-1'><label class='control-label'>Qty</label><input type='text' name='subitems["+val+"][qty][]' id='quantity_"+val+"_0' onchange='select_activityquantity(this.value,"+val+",0)' class='form-control' value='1'/></div><div class='col-sm-2'><label class='control-label'>Total Cost</label><input type='text' name='subitems["+val+"][total_cost][]' id='total_cost_"+val+"_0' class='form-control' /></div><div class='col-sm-1'><label class='control-label'>Margin % </label><input type='text' name='subitems["+val+"][margin][]' id='margin_"+val+"_0' class='form-control selling_price_"+val+"_0'/></div><div class='col-sm-1'><label class='control-label'>Selling Price</label><input type='hidden' name='subitems["+val+"][selling_price][]' id='selling_price_"+val+"_0' class='selling_price_"+val+"_0' /></div><div class='col-sm-2'><a href=''><i class='fa fa-times-circle'></i> </a> </div></div>");
	
	$(".sub").select2({
	
	});
}

function select_activity(workcount,activitycount){
	//alert(workcount);
	//alert(activitycount);
	$('#ac_id_'+workcount+'_'+activitycount+'').show();
	$(".sub").select2({
	
	});
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
		
		
		
			
			
                
            }
          });
		  
	var act_count = activity_count+1;
	var j = act_count+1;
	//$("#getActivity_"+workgroup_count+"_"+activity_count+"").hide();
	$('div#ac_id_'+workgroup_count+'_'+activity_count+'').after("<div id='ac_id_"+workgroup_count+"_"+act_count+"' class='d'><div class='row' style='background-color:#c9eced;padding:10px 0px;margin:5px -9px;'><div class='col-sm-1'>"+j+"</div><div class='col-sm-1'><label class='control-label'>Sku</label><input type='text' name='subitems["+workgroup_count+"][sku][]' id='sku_"+workgroup_count+"_"+act_count+"'  class='form-control sub '/></div><div class='col-sm-2'><label class='control-label'>Name</label><select type='text' name='subitems["+workgroup_count+"][name][]' id='name_"+workgroup_count+"_"+act_count+"' class='form-control sub' onchange='add_activity(this.value,"+workgroup_count+","+act_count+")'>"+$('.copy_append').html()+"</select></div><div class='col-sm-1'><label class='control-label'>Unit Cost</label><input type='text' name='subitems["+workgroup_count+"][unit_cost][]' id='unit_cost_"+workgroup_count+"_"+act_count+"' class='form-control'/></div><div class='col-sm-1'><label class='control-label'>Qty</label><input type='text' name='subitems["+workgroup_count+"][qty][]' id='quantity_"+workgroup_count+"_"+act_count+"' onchange='select_activityquantity(this.value,"+workgroup_count+","+act_count+")' class='form-control' value='1'/></div><div class='col-sm-2'><label class='control-label'>Total Cost</label><input type='text' name='subitems["+workgroup_count+"][total_cost][]' id='total_cost_"+workgroup_count+"_"+act_count+"' class='form-control' /></div><div class='col-sm-1'><label class='control-label'>Margin % </label><input type='text' name='subitems["+workgroup_count+"][margin][]' id='margin_"+workgroup_count+"_"+act_count+"' class='form-control selling_price_"+workgroup_count+"_"+act_count+"'/></div><div class='col-sm-1'><label class='control-label'>Selling Price</label><input type='hidden' name='subitems["+workgroup_count+"][selling_price][]' id='selling_price_"+workgroup_count+"_"+act_count+"' class='selling_price_"+workgroup_count+"_"+act_count+"' /></div><div class='col-sm-2'><a href=''><i class='fa fa-times-circle'></i> </a> </div></div>");
	
	$(".sub").select2({
	
	});
	
	
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
	</script>