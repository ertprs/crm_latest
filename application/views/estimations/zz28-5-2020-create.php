<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>

<!--box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;-->
<style>

.ck-editor__editable_inline {
    min-height: 200px;
}
label {
    font-weight: 600;
}
.form-control{
	height: 38px;
	border-radius:10px;
}
.right-inner-addon {
  position: relative;
}
.bg-danger {
    background-color: #FF3B30 !important;
}
.bg-success {
    background-color: #26c281 !important;
}
.right-inner-addon input {
  padding-right: 30px;
}
.progress{
	height: 1rem !important;
	margin-bottom:0px;
}

.right-inner-addon i {
     position: absolute;
    right: 0px;
    padding: 12px 4px;
    pointer-events: none;
    /* top: 9px; */
    background: #ddd;
}

.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#000;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#000;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #26c281 !important;
		outline: 0;
		color:#fff !important;
	}
.pd0{
	padding:0px !important;
}
.pdleft0{
	padding-left: 0px;
}
  .button5 {
    border-radius: 50%;
    background-color: #4CAF50;
    /* Green */
    border: none;
    color: white;
    width:30px;
    height:30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }
  .totalcostclass{
    
  }
  .centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
  }
</style>
<div class="ciuis-body-content" >
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-9"> 
    <form  action="<?php echo base_url('estimations/create') ?>" method="post" enctype="multipart/form-data">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">   
          <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
            <md-icon>
              <i class="ico-ciuis-proposals text-muted">
              </i>
            </md-icon>
          </md-button>
          <h2 flex md-truncate>
            <?php echo lang('createestimation') ?>
          </h2>
          <md-switch ng-model="proposal_type" aria-label="Type" ng-cloak>
            <strong class="text-muted">
              <?php echo lang('for_lead')?>
            </strong>
          </md-switch>
          <md-button ng-href="<?php echo base_url('estimations')?>" class="md-icon-button" aria-label="Save" ng-cloak>
            <md-tooltip md-direction="bottom">
              <?php echo lang('cancel') ?>
            </md-tooltip>
            <md-icon>
              <i class="ion-close-circled text-danger">
              </i>
            </md-icon>
          </md-button>
          <button type="submit"  class="btn btn-sm btn-success">
            <i class="glyphicon glyphicon-ok-circle">
            </i>
          </button>
        </div>
      </md-toolbar>
      <md-content class="bg-white layout-padding _md" >
        <div layout-gt-xs="row">
          <md-input-container class="md-block" flex-gt-sm>
            <input  name="estimation_project_name" id="estimation_project_name" id="estimation_project_name"class="form-control" placeholder="Enter Estimation Project Name" required="">
          </md-input-container>
        </div>
        <div layout-gt-xs="row">
          <div class="col-sm-6">
		  
            <select class="form-control client" name="client_id" id="client_id" required="">
              <option value="">Search or Add Client
              </option>
              <?php foreach($clients as $client){ 
if($client['clientname'] != '') { ?>
              <option value="<?php echo $client['client_id'];?>">
                <?php echo $client['clientname']; ?>
              </option>
              <?php }  } ?>
            </select>
          </div> 
          <div class="col-sm-6">
            <select class="form-control contact" name="client_contact_id" id="client_contact_id" required="">
              <option value="">Select Contact
              </option>
              <?php foreach($client_contacts as $contact){ 
if($contact['point_contact_name'] != '') { ?>
              <option value="<?php echo $contact['client_contact_id'];?>">
                <?php echo $contact['point_contact_name']; ?>
              </option>
              <?php }  } ?>
            </select>
          </div> 
        </div>
        <div layout-gt-xs="row">
          <div class="col-sm-6">
            <select id="salesteam" class="form-control" required name="salesteam"  placeholder="Select Project Salesteam">
              <option value="">Select Sales Team
              </option>
              <?php if(isset($saleswise) && !empty($saleswise)){foreach($saleswise as $eachSale){?>
              <option value="<?php print $eachSale['id']; ?>">
                <?php print $eachSale['staffname']; ?>
              </option>
              <?php } }?>
            </select>
          </div>
          <div class="col-sm-6">
            <select id="approval_admin" class="form-control" required name="approval_admin"  placeholder="Approval Request">
              <?php if(isset($admin) && !empty($admin)){foreach($admin as $eachSale){?>
              <option value="<?php print $eachSale['id']; ?>">
                <?php print $eachSale['staffname']; ?>
              </option>
              <?php } }?>
            </select>
          </div>      
        </div>
        <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
          <div class="md-toolbar-tools">
            <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
              <md-icon>
                <i class="ico-ciuis-proposals text-muted">
                </i>
              </md-icon>
            </md-button>
            <h2 flex="" md-truncate="" class="md-truncate flex">Estimation Items
            </h2>
          </div>
        </md-toolbar>
   
        <input type="hidden" id="totalwgcount" name="totalwgcount" value="0">
        <div class="box-body">
          <div class="input_fields_container_part">
            <div  class="row centered-form " style="background:#fff;">
			   <div class=" col-xs-12 col-sm-8 col-md-12" id="example2" style="padding: 10px;" >
                      <div class="col-sm-1 text-center"> # <input type="checkbox" id="checkAll"/> 
                      </div>
                      <div class="col-sm-4 text-center"><b>Item Name</b>
                      </div>
                      <div class="col-sm-1"><b>Qty</b>
                      </div>
                      <div class="col-sm-2"><b>Unit Price</b>
                      </div>
                      <div class="col-sm-1"><b>Tax % </b>
                      </div>
                      <div class="col-sm-2"><b>Total</b>
                      </div>
                      <div class="col-sm-1">
                      </div>
                    </div>
              <div class="col-xs-12 col-sm-8 col-md-12 " id="workgroup_id0">
			 
                <div class="panel panel-info">
                  <div class="panel-body">
                  	
                    <div class="row cloned-row" style="padding: 10px;" >
                      <div class="col-sm-1">
                        <span>
                          <input type="checkbox" style="padding-right:10px;" id="check_price_0" onclick="change_margin_value('0')" class="checkall"> <b>1
                          </b>
                        </span>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="items[item_name][]"  id="item_name0" required="required" class="form-control"   />
                        <input type="hidden" value="0" id="nextcnt0">
                      </div>
                      <div class="col-sm-1">
                        <input type="text" name="items[qty][]" id="qty0" class="form-control" 	value="1"  onchange="main_item(this.value,0)">
                      </div>
                      <!--onchange="change_round_helper(0,0)" -->
                      <div class="col-sm-2">
                        <input type="text" name="items[unit_price][]" id="unit_price_0" class="form-control text-right" >
                      </div>
                      <div class="col-sm-1">
                        <input type="text" name="items[tax][]" id="tax_0" class="form-control" value="5">
                      </div>
                      <div class="col-sm-2">
                        <span id="tot0" class="form-control totalcostclass text-right">0
                        </span>
                        <input type="hidden" name="items[amount][]" id="amount_0" class="amt"/>
                      </div>
                      <div class="">
                        <button class="btn btn-success removeclass " type="button" onclick="select_activity(0,0);">
                          <i class="glyphicon glyphicon-circle-arrow-down">
                          </i>
                        </button> 
                        <button class='btn btn-success' type='button' onclick='remove_activity(0,0);'>
                          <i class='glyphicon glyphicon-trash'>
                          </i>
                        </button>
                      </div>                          
                    </div>
                    <div style="border:1px solid #ddd;padding:10px;display:none" class="row " id="border_id_0_0">
                      <div class=" well clearfix sub-wrapper" >
                        <div id="wrapper_0_0">
                          <div data-count="0">
                            <div id="ac_id_0_0" style="display:none; margin-top:10px;" class="col-md-12"> 
                              <div style="width:3%;float:left;">
                                <label class="control-label">#
                                </label>
                                <br>
                                <span>
                                  <b>1
                                  </b>
                                </span>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label">Sku
                                </label>
                                <input type="text" name="subitems[0][sku][]" id="sku_0_0"  class="form-control " placeholder="Enter SKU" autocomplete="off"/>
                                <input type="hidden" value="0" id="nextsubcnt_0_0">
                              </div>
                              <div style="width:30%;float:left;margin-right: 5px;">
                                <label class="control-label">Name
                                </label>
								 <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="name_id_0_0" name="subitems[0][newmaterial][]" id="name_0_0" placeholder="Enter Material" autocomplete="off" >
        <input type="hidden" name="subitems[0][name][]" id="name_id_0_0" autocomplete="off" value="" class="allcategory"/>
		  <input type="hidden" name="" id="allcategory_0_0" autocomplete="off" value="" class="allcategory_0"/>
                                <input type="text" id="matid_0_0" class="mid matidnew0" style="display:none;">
								<?php /*
                                <select type="text" name="subitems[0][name][]" id="name_0_0" class="form-control allcategory" onchange="add_activity(this.value,0,0);">
                                  <option value=''>Select Material
                                  </option>
                                  <?php foreach($materials as $mat) { ?>
                                  <option value="<?php echo $mat['material_id'];?>">
                                    <?php echo $mat['itemname']; ?>
                                  </option>
                                  <?php } ?>
                                </select> */?>
                              </div>
                              
                              <div style="width:5%;float:left;margin-right: 5px;">
                                <label class="control-label">Qty
                                </label>
                                <input type="text" name="subitems[0][qty][]" id="quantity_0_0"  class="form-control" value="1" onchange="save(0,0);"/>
                                <input type="hidden" id="exact_qnty_0_0" value=""  >
                              </div>
							  <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label">Unit Cost
                                </label>
                                <input type="text" name="subitems[0][unit_cost][]" id="unit_cost_0_0" class="form-control text-right" onchange="select_subcost(this.value,0,0)"/>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
                                <label class="control-label">Total Cost
                                </label>
                                <input type="text" name="subitems[0][total_cost][]" id="total_cost_0_0" class="form-control tc_0 text-right" readonly />
                              </div>
                              <div style="width:8%;float:left;margin-right: 5px;">
                                <label class="control-label">Margin % 
                                </label>
                                <input type="text" name="subitems[0][margin][]" id="margin_0_0" class="form-control selling_price_0_0" onchange="change_margin(this.value,0,0);"/>
								
								<input type="hidden" name="" id="margin_hidden_0_0" class="form-control margin_hidden_0_0" />
                              </div>
                              <div style="width:12%;float:left;margin-right: 5px;">
                                <label class="control-label">Selling Price
                                </label>
                                <br>
                                <span id="sp_0_0" class="form-control text-right">0
                                </span>
                                <input type="hidden" name="subitems[0][selling_price][]" id="selling_price_0_0" class="sps_0"/>
								 <input type="hidden" name="" id="final_sp_0_0" class="form-control final_sp_0_0" />
                              </div>
                              <div style="width:7%;float:left;">
                                <label class="control-label">Action
                                </label>
                                <!--
<a  class="remove btn btn-danger" onclick='removediv(0,0);'>-</a>
-->
                              </div>                          
                            </div>
                          </div>
                        </div>
                        <!--
<button id="add" onclick="addMore(0,0)" class="btn btn-danger btn-lg" style="float:right;" type="button"> Add More</button> 
                        <button id="add" onclick="save(0,0)" class="btn btn-success btn-lg" style="float:right;margin-right:10px;" type="button"> Save
                        </button> -->
                      </div>
                      <div id="totals0" style="display:none" class="col-md-offset-1">
                        <div class="col-md-12" style="margin-bottom: 10px;">
                          <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-6 text-danger">
                              <b>
                              </b> 
                            </div>
                            <div class="col-md-2 text-right " style="padding-right:0px;">
                              <b>Item Cost:
                              </b> 
                              <span id="sub_total_cost0" >0.00
                              </span>
                            </div>
                            <div class="col-md-3 text-right">
                              <b>Item Selling Price:
                              </b>  
                              <span id="sub_total_sp0" >0.00
                              </span>
                            </div> 
                          </div>
                          <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-4 row">
                              <div class="col-sm-5 text-right ">
                                <b>Round Helper:
                                </b>
                              </div>
                              <div class="col-sm-5 text-left pd0">	
                                <input type="text" name="items[round_helper][]" id="round_helper0" class="form-control" size="4" onchange="select_round(this.value,0)" value="0">
                              </div>
                            </div>
                          </div>
                          <!--
<div class="col-md-6 p-1 text-right"><b>Item Cost:</b></div><div class="col-md-2 p-1"><span id="sub_total_cost0" >0.00</span></div><div class="col-md-3 p-1"><b>Item Selling Price:</b>  <span id="sub_total_sp0" >0.00</span></div>-->
                          <input type="hidden" name="items[sub_tot_cost][]" id="sub_tot_cost0"  class="sub_cs"/>
                          <input type="hidden" name="items[sub_tot_cost_change][]" id="sub_tot_cost_change0"  class="sub_cs_change"/>
                          <input type="hidden" name="items[sub_tot_sp][]" id="sub_tot_sp0"class="sub_sp" />
                        </div>
                        <!--  
<div class="col-md-6"></div>
<div class="col-md-3 row">
<div class="col-sm-6"><b>Round Helper:</b></div>
<div class="col-sm-6">	
<input type="text"name="items[round_helper][]" id="round_helper0" class="form-control" size="4" onchange="select_round(this.value,0)" value="0">
</div>
</div>
-->
                        <div class="col-md-2" style="display:none;">
                          <b>Total:
                          </b> 
                          <span id="ototal0">0.00
                          </span>
                          <br>Difference: 
                          <span id="dtotal0"class="sub_diff">
                          </span>
                        </div>
                      </div>
                    </div>
                    <hr/>
                  </div>
                </div>
              </div>
            </div> 
          </div>
          <div class="col-md-12" style="margin-bottom:10px;">
            <button class="add_more_button button5">
              <i class="glyphicon glyphicon-plus">
              </i>
            </button>
          </div>
          <div class="col-md-12 row" style="background:#fff !important;">
            <div class="col-md-6" >
              <table class="table table-bordered col-md-6">
                <tr>
                  <th>Total Cost:
                  </th>
                  <td>
                    <span id="estimation_total_cost">
                    </span>
                    <input type="hidden" name="estimation_total_cost_amt" id="estimation_total_cost_amt" />
                  </td>
                </tr>
                <tr>
                  <th>Estimated Profit:
                  </th>
                  <td>
                    <span id="estimation_profit">
                    </span>
                    <input type="hidden" name="estimation_profit_amt" id="estimation_profit_amt" />
                  </td>
                </tr>
                </tr>
              </table>
          </div>
          <div class="col-md-6" >
            <table class="table table-bordered col-md-6">       
              <tr>
                <th>Sub Total:
                </th>
                <td>
                  <span id="subtotal">
                  </span>
                  <input type="hidden" name="subtotal_amt" id="subtotal_amt" />
                </td>
              </tr>
              <tr>
                <th>Tax:
                </th>
                <td>
                  <span id="estimation_tax">
                  </span>
                  <input type="hidden" name="estimation_tax_amount" id="estimation_tax_amount" />
                </td>
              </tr>
              <tr>
                <th>Discount:
                </th>
                <td>
                  <input type="text" name="discount" id="discount" class="form-control" value="0" onchange="select_discount(this.value);">
                </td>
              </tr>
              <tr>
                <th>Total Amount:
                </th>
                <td>
                  <span id="estimation_total_amount">
                  </span>
                  <input type="hidden" name="estimation_total_amt" id="estimation_total_amt" />
                </td>
              </tr>
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
        <option value=''>Select Material
        </option>
        <?php foreach($materials as $mat){ ?>
        <option value="<?php echo $mat['material_id'];?>">
          <?php echo $mat['itemname'];?>
        </option>		  
        <?php }	?>
      </span>
      <div class="col-md-12">
        <div class="form-group ">
          <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
            <div class="md-toolbar-tools">
              <h2 flex="" md-truncate="" class="md-truncate flex">Special Notes / Remarks
              </h2>
            </div>
          </md-toolbar>
          <textarea type="text" class="form-control" id="special_notes" placeholder="" name="special_notes" rows="30" cols="30">
          </textarea>
        </div>
		<?php if ( $this->session->userdata( 'admin' ) ) {?>
        <div class="form-group ">
          <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
            <div class="md-toolbar-tools">
              <h2 flex="" md-truncate="" class="md-truncate flex">Status
              </h2>
            </div>
          </md-toolbar>
          <select id="estimatestatus" class="form-control" required="" name="estimatestatus" placeholder="Select Status">
            <option value="Approved">Approved
            </option>
            <option value="Draft">Draft
            </option>
            <option value="Missing Info">Missing Info
            </option>
            <option value="Under Approval">Under Approval
            </option>
            <option value="Declined">Declined
            </option>
            <option value="Approved">Approved
            </option>
          </select>
        </div>
		<?php }else{?>
		<input type="text" name="estimatestatus" value="Draft">
		<?php }?>
      </div>
      <div class="form-group ">
        <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
          <div class="md-toolbar-tools">
            <h2 flex="" md-truncate="" class="md-truncate flex">Upload  Documents
            </h2>
          </div>
        </md-toolbar>
      </div>
      <div class="col-md-12">
        <div class="form-group ">
          <div class="file-upload-wrapper">
            <input type="file" name="file[]" id="file" multiple />
          </div>
        </div>
      </div>
      <!--
<div class="col-md-12">
<input type="submit" name="submit" id="submit" value="Create" class="btn btn-primary col-md-6" style="float:right;">  
</div>
-->
    </form>
    </md-content>
  <custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0">
  </custom-fields-vertical> 
</div>
</div>
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">

  <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
    <div class="md-toolbar-tools"> 
      <h2 class="md-pl-10 md-truncate flex" flex="" md-truncate="">Categories
      </h2>
    </div>
  </md-toolbar>
  
  <md-content class="bg-white _md">
  
    <div id="destination" >
 
    </div>
  </md-content>
  

</div>
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>">
</script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>">
</script>

<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/typeahead.js'); ?>"></script>
<script>
  ClassicEditor
    .create( document.querySelector( '#special_notes' ) )
    .catch( error => {
    console.error( error );
  }
          );
</script>
<script type="text/javascript">
  function checkValue(value,arr){
    var status = 'Not exist';
    for(var i=0; i<arr.length; i++){
      var name = arr[i].material_id;
      if(name == value){
        status = 'Exist';
        break;
      }
    }
    return status;
  }
  function checkValue1(value,arr){
    var status = 'Not exist';
    //console.log(arr.length);
    //return false;
    for(var i=0; i<arr.length; i++){
      var name = arr[i];
      //console.log(name);
      //console.log(value);
      if(name == value){
        status = 'Exist';
        break;
      }
    }
    return status;
  }
  function checkValue2(value,arr){
    var status = 'Not exist';
    //console.log(arr.length);
    //return false;
    for(var i=0; i<arr.length; i++){
      var name = arr[i];
      //console.log(name);
      //console.log(value);
      if(name == value){
        status = 'Exist';
        break;
      }
    }
    return status;
  }
  
  function change_margin_value(workgroup_count){
	  if ($('input#check_price_'+workgroup_count+'').is(':checked')) {
	  var marcarid=[];
	  $('.errorDivstr').each(function() {
		  marcarid.push($(this).text());
	  });
	  
	  $('.matidnew'+workgroup_count+'').each(function() {
		  var selectedid=$(this).val();
		 
          if(selectedid!=''){
			//console.log(status);
			
            var status=checkValue2(selectedid, marcarid);
			
            if(status=='Exist'){
				 var marginval= $('input[data-id='+selectedid+']').val();
				//console.log(selectedid);return false;
				if(marginval!=''){
					if (!isNaN(marginval)){
						
						
              mid=$(this).attr('id');
              var midsp=mid.split('_');
			  var result=check_last_selling_value(marginval,midsp[1],midsp[2]);
			 if(result==1){
				  $('#margin_'+midsp[1]+'_'+midsp[2]+'').val(marginval);
				  var unitcost=$('#unit_cost_'+midsp[1]+'_'+midsp[2]+'').val();
				  select_subcost(unitcost,midsp[1],midsp[2]);
			 }else{
				 $('input[data-id='+selectedid+']').val('');
				 $('input#check_price_'+workgroup_count+'').prop("checked", false);
			 }
				}
				}
            }
          }
	  } );
	  }else{
		  
		    $('.matidnew'+workgroup_count+'').each(function() {
				  var selectedid=$(this).val();
				 
				  if(selectedid!=''){
					  
					  
						mid=$(this).attr('id');
					  var midsp=mid.split('_');
					  var marginval= $('#margin_hidden_'+midsp[1]+'_'+midsp[2]+'').val();
					  
					  $('#margin_'+midsp[1]+'_'+midsp[2]+'').val(marginval);
					  var unitcost=$('#unit_cost_'+midsp[1]+'_'+midsp[2]+'').val();
					  select_subcost(unitcost,midsp[1],midsp[2]);
					  
					  
				  }
			});
	  }
	  get_total_by_category();
  }
  function changemargin(str,id)
  {
	 
    $.ajax({
      url : "<?php echo base_url(); ?>estimations/get__mat__cat_data",
      data:{
        matid : id}
      ,
      method:'POST',
      dataType:'json',
      success:function(response1) {
        var names_arr = response1;
        $('.allcategory').each(function() {
          var selectedid=$(this).val();
          if(selectedid!=''){
			 
            var status=checkValue(selectedid, names_arr);
			
            if(status=='Exist'){
              mid=$(this).attr('id');
              var midsp=mid.split('_');
			  if($('#check_price_'+midsp[2]+'').is(":checked")){
				 console.log(midsp[2]);
				 var workgroup_count=midsp[2];
				 $('.matidnew'+workgroup_count+'').each(function() {
					  var selectedid=$(this).val();
		 
          if(selectedid!=''){
			//console.log(status);
			
            
				 var marginval= $('input[data-id='+selectedid+']').val();
				//console.log(selectedid);return false;
				
				if(marginval!=''){
					if (!isNaN(marginval)){
						
						
              mid=$(this).attr('id');
              var midsp=mid.split('_');
			  var result=check_last_selling_value(marginval,midsp[1],midsp[2]);
			 if(result==1){
				  $('#margin_'+midsp[1]+'_'+midsp[2]+'').val(marginval);
				  var unitcost=$('#unit_cost_'+midsp[1]+'_'+midsp[2]+'').val();
				  select_subcost(unitcost,midsp[1],midsp[2]);
			 }else{
				 $('input[data-id='+selectedid+']').val('');
				 $('input#check_price_'+workgroup_count+'').prop("checked", false);
			 }
				}
				}
            
          }
				 });
			  }
			/*
              $('#margin_'+midsp[2]+'_'+midsp[3]+'').val(str);
              var unitcost=$('#unit_cost_'+midsp[2]+'_'+midsp[3]+'').val();
              select_subcost(unitcost,midsp[2],midsp[3]);*/
			  
            }
          }
        }
                              );
        //console.log(seen);
      }
    }
          );
  }
  function select_workgroup(num){
    var nxtcnt=$('#nextcnt'+num+'').val();
    var val = num;
    $('#nextcnt'+num+'').val('1');
    var k = val+1;
    $("#getMessage"+num+"").hide();
    //document.getElementById("getMessage"+num+"").style.visibility="hidden";
    $('.input_fields_container_part').append("<div id='workgroup_id"+val+"' class='row centered-form' style='background:#fff;'><div class='col-xs-12 col-sm-8 col-md-12 '><div class='panel panel-info'><div class='panel-body'><div class='row cloned-row' style='padding: 10px;'><div class='col-sm-1'><b><input type='checkbox' style='padding-right:10px;' id='check_price_"+val+"' onclick='change_margin_value("+val+")' class='checkall'> "+k+"</b></div><div class='col-sm-4'><input type='text' name='items[item_name][]' id='item_name"+val+"' class='form-control' /><input type='hidden' value='0' id='nextcnt"+val+"'></div><div class='col-sm-1'><input type='text' name='items[qty][]' id='qty"+val+"' class='form-control' value='1' onchange='main_item(this.value,"+val+")'></div><div class='col-sm-2'><input type='text' name='items[unit_price][]' id='unit_price_"+val+"' class='form-control  text-right' ></div><div class='col-sm-1'><input type='text' name='items[tax][]' id='tax_"+val+"' class='form-control' value='5'></div><div class='col-sm-2'><span id='tot"+val+"' class='form-control totalcostclass text-right'>0</span><input type='hidden' name='items[amount][]' id='amount_"+val+"' class='amt'/></div><div class=''> <button class='btn btn-success removeclass' type='button' onclick='select_activity("+val+",0);' style='float: left;margin-right:1px;'><i class='glyphicon glyphicon-circle-arrow-down'></i></button> <button class='btn btn-success' type='button' onclick='remove_activity("+val+",0);'><i class='glyphicon glyphicon-trash'></i></button></div></div><div style='border: 1px solid rgb(221, 221, 221); padding: 10px;display:none;' class='row ' id='border_id_"+val+"_0'><div class=' well clearfix sub-wrapper'><div id='wrapper_"+val+"_0'><div data-count='0'><div id='ac_id_"+val+"_0' style='display:none;' class='d col-md-12' style='margin-top: 10px;'><div class='' ><div style='width:3%;float:left;'><b>#</b></div><div style='width:10%;float:left;margin-right: 5px;'><label class='control-label'>Sku</label><input type='text' name='subitems["+val+"][sku][]' id='sku_"+val+"_0'  class='form-control '/><input type='hidden'  id='nextsubcnt_"+val+"_0'  class='form-control' value='0'/></div><div style='width:30%;float:left;margin-right: 5px;'><label class='control-label'>Name</label><input type='text' id='matid_"+val+"_0' class='mid matidnew"+val+"' style='display:none;'><input type='text' class='form-control typeahead' data-provide='typeahead' data-hidden-field-id='name_id_"+val+"_0' name='subitems["+val+"][newmaterial][]' id='name_"+val+"_0' placeholder='Enter Material' autocomplete='off' ><input type='hidden' name='subitems["+val+"][name][]' id='name_id_"+val+"_0' autocomplete='off' value='' class='allcategory'/><input type='hidden' name='' id='allcategory_"+val+"_0' autocomplete='off' value='' class='allcategory_"+val+"'/></div><div style='width:5%;float:left;margin-right: 5px;'><label class='control-label'>Qty</label><input type='text' name='subitems["+val+"][qty][]' id='quantity_"+val+"_0' class='form-control' value='1' onchange='save("+val+",0);'/><input type='hidden' id='exact_qnty_"+val+"_0' value=''></div><div style='width:10%;float:left;margin-right: 5px;' style='padding:0px;'><label class='control-label'>Unit Cost</label><input type='text' name='subitems["+val+"][unit_cost][]' id='unit_cost_"+val+"_0' class='form-control text-right' onchange='select_subcost(this.value,"+val+",0)'/></div><div style='width:10%;float:left;margin-right: 5px;'><label class='control-label'>Total Cost</label><input type='text' name='subitems["+val+"][total_cost][]' id='total_cost_"+val+"_0' class='text-right form-control tc_"+val+"' readonly /></div><div style='width:8%;float:left;margin-right: 5px;' style='padding:0px;'><label class='control-label'>Margin % </label><input type='text' name='subitems["+val+"][margin][]' id='margin_"+val+"_0' class='form-control selling_price_"+val+"_0' onchange='change_margin(this.value,"+val+",0)'/><input type='hidden' name='' id='margin_hidden_"+val+"_0' class='form-control margin_hidden_"+val+"_0'></div><div style='width:12%;float:left;margin-right: 5px;'><label class='control-label'>Selling Price</label><br><span id='sp_"+val+"_0' class='form-control text-right'>0</span><input type='hidden' name='subitems["+val+"][selling_price][]' id='selling_price_"+val+"_0' class='sps_"+val+"' />  <input type='hidden' name='' id='final_sp_"+val+"_0' class='form-control final_sp_"+val+"_0' /></div></div></div></div></div></div><div id='totals"+val+"' style='display:none' class='col-md-offset-1'><div class='col-md-12' style='margin-bottom: 10px;'><div class=''><div class='col-md-7 text-right ' style='padding-right: 0px;'><b>Item Cost:</b></div><div class='col-md-1 p-1'><span id='sub_total_cost"+val+"' >0.00</span></div><div class='col-md-3'><b>Item Selling Price:</b> <span id='sub_total_sp"+val+"' >0.00</span></div><input type='hidden' name='items[sub_tot_cost][]' id='sub_tot_cost"+val+"' class='sub_cs'/><input type='hidden' name='items[sub_tot_cost_change][]' id='sub_tot_cost_change"+val+"' class='sub_cs_change'/><input type='hidden' name='items[sub_tot_sp][]' id='sub_tot_sp"+val+"' class='sub_sp' /></div></div><div class='col-md-8'></div><div class='col-md-4 row'><div class='col-sm-3 text-right'><b>Round Helper:</b></div><div class='col-sm-5 ' style='padding-right:0px;'><input type='text' name='items[round_helper][]' id='round_helper"+val+"' class='form-control' size='4' onchange='select_round(this.value,"+val+")' value='0'></div></div><div class='col-md-2' style='display:none;'><b>Total:</b><span id='ototal"+val+"'></span><br>Difference: <span id='dtotal"+val+"' class='sub_diff'></span></div></div></div><hr/></div></div></div>");
	
	var s1=0;
	$('#sku_'+val+'_0').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material_sku',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						if(data == '0'){
							//alert("fds");
							
							$('#name_id_'+val+'_0').val('-1');
							$('#allcategory_'+val+'_0').val('-1');
							if(s1==0){
							addMore(val,0);
							}
							 s1++;
						}else{
						 map = {};
						 states = [];	
						  
						$.each(data, function (i, state) {
							map[state.name] = state;
      states.push(state.name);
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
		
		var catarr=[];
        $('.allcategory_'+val+'').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
		 var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){	
        $(`#${hiddenFieldId}`).val(SelectedCode);
		add_activity(SelectedCode,val,0);        
        return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
    }

});
	var b=0;
	$('#name_'+val+'_0').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						if(data == '0'){
							//alert("fds");
							$('#name_id_'+val+'_0').val('-1');
							$('#allcategory_'+val+'_0').val('-1');
								if(b==0){
							addMore(val,0);
							}
							 b++;
						}else{
						 map = {};
						 states = [];
						 $.each(data, function (i, state) {
		 map[state.name] = state;
      states.push(state.name);
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
		var catarr=[];
        $('.allcategory_'+val+'').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
		 var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){	
        $(`#${hiddenFieldId}`).val(SelectedCode);
		add_activity(SelectedCode,val,0);
        
        return SelectedCityName;
	  }else{
		   alert("Already Selected");
		  return false;
	  }
    }

});
  }
  function select_activity(workcount,activitycount){
    //alert(workcount);
    //alert(activitycount);
    $('#border_id_'+workcount+'_'+activitycount+'').toggle();
    $('#ac_id_'+workcount+'_'+activitycount+'').toggle();
    $('#totals'+workcount).toggle();
  }
  function removeduplicate()
  {
    /*
 var seen='';
   $('.errorDiv').each(function(){
        var see=$(this).text();
        if(seen.match(see)){
            $(this).remove();}
        else{
            seen=seen+$(this).text();
        }
    });
    */
    var yourArray2= [];
    $('.allcategory').each(function() {
      //yourArray +="'"+$(this).text()+"',";
      yourArray2.push($(this).text());
    }
                          );
    var yourArray1 = [];
    $('.errorDivstr').each(function() {
      var status=checkValue1(response1.mat_cat_id, yourArray);
      console.log(status);
    }
                          );
  }
  function unique(list) {
    var result = [];
    $.each(list, function(i, e) {
      if ($.inArray(e, result) == -1) result.push(e);
    }
          );
    return result;
  }
  function add_activity(value,workgroup_count,activity_count){
    //$(".errorDiv").html('');
    var material_id = value;
    //$('#destination').html('<div class="errorDiv"></div>');
    var seen='';
    $.ajax({
      url : "<?php echo base_url(); ?>estimations/get_material_data",
      data:{
        material_id : material_id}  
      ,
      method:'POST',
      dataType:'json',
      success:function(response) {
        var strlen=$('.errorDivstr').length;
        if(strlen==0){
          $("#destination").append('<div class="errorDiv col-md-12 pd0 addbar'+response.mat_cat_id+'" id="removediv'+response.mat_cat_id+'">  <div class="col-md-12" style="margin-bottom:10px;"> <span class="errorDivstr errorDivstr1" style="display:none;">'+response.mat_cat_id+'</span>  <div class="col-md-9 pd0" style="margin-top:10px;"><strong>'+response.mat_cat_name+'</strong></div><div class="col-sm-3   pd0"><div class="right-inner-addon"><div class="icon-search"><i class="fa fa-percent"></i></div><input type="text" class="form-control"  value=""  data-id='+response.mat_cat_id+' onkeyup="changemargin(this.value,'+response.mat_cat_id+')"></div></div></div>     <div class="col-md-12"><span >AED <span class="totalcost'+response.mat_cat_id+'"></span></span><span style="float:right;" >AED <span class="sellingprice'+response.mat_cat_id+'"></span></span><div class="progress"><div class="progress-bar bg-danger pdanger'+response.mat_cat_id+'" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div> <div class="progress-bar bg-success psuccess'+response.mat_cat_id+'" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div><span >Cost </span><span style="float:right;" >Selling </span></div> <hr/> </div>');
		  
		   
        }
        else{
          var yourArray = [];
          $('.errorDivstr').each(function() {
            //yourArray +="'"+$(this).text()+"',";
            yourArray.push($(this).text());
          }
                                );
          var status=checkValue1(response.mat_cat_id, yourArray);
          if(status=='Not exist'){
            $("#destination").append('<div class="errorDiv col-md-12 pd0 addbar'+response.mat_cat_id+'" id="removediv'+response.mat_cat_id+'">  <div class="col-md-12" style="margin-bottom:10px;"> <span class="errorDivstr errorDivstr1" style="display:none;">'+response.mat_cat_id+'</span>  <div class="col-md-9 pd0" style="margin-top:10px;"><strong>'+response.mat_cat_name+'</strong></div><div class="col-sm-3   pd0"><div class="right-inner-addon"><div class="icon-search"><i class="fa fa-percent"></i></div><input type="text" class="form-control"  value=""  data-id='+response.mat_cat_id+'></div></div></div>     <div class="col-md-12"><span >AED <span class="totalcost'+response.mat_cat_id+'"></span></span><span style="float:right;" >AED <span class="sellingprice'+response.mat_cat_id+'"></span></span><div class="progress"><div class="progress-bar bg-danger pdanger'+response.mat_cat_id+'" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div> <div class="progress-bar bg-success psuccess'+response.mat_cat_id+'" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div><span >Cost </span><span style="float:right;" >Selling </span></div> </div>');
			
			
          }
        }
        var mainqty = parseFloat($('#qty'+workgroup_count).val());
        $('#matid_'+workgroup_count+'_'+activity_count).val(response.mat_cat_id);
        var catarr=[];
        $('.mid').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        }
                      );
        $('.errorDivstr').each(function() {
          var status=checkValue2($(this).text(), catarr);
          if(status=='Not exist'){
            var matid=$(this).text();
            $('#removediv'+matid+'').remove();
            //$(this).parent('div').remove();
          }
        });
		
		$('.errorDivstr1').each(function() {
          var status=checkValue2($(this).text(), catarr);
          if(status=='Not exist'){
            var matid=$(this).text();
            $('#removediv1'+matid+'').remove();
            //$(this).parent('div').remove();
          }
        });
		 $('#final_sp_'+workgroup_count+'_'+activity_count).val(response.last_selling_price);
        $('#sku_'+workgroup_count+'_'+activity_count).val(response.item_code);
		$('#name_id_'+workgroup_count+'_'+activity_count).val(response.material_id);
		$('#allcategory_'+workgroup_count+'_'+activity_count).val(response.material_id);
		
		$('#name_'+workgroup_count+'_'+activity_count).val(response.itemdescription);
	
        $('#unit_cost_'+workgroup_count+'_'+activity_count).val(response.cost);
        
        var quantity = $('#quantity_'+workgroup_count+'_'+activity_count).val();
        $('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*response.cost);
		
		if(response.margin_type=="percentage"){
       
		$('#margin_'+workgroup_count+'_'+activity_count).val(response.margin_value);
		$('#margin_hidden_'+workgroup_count+'_'+activity_count).val(response.margin_value);
		 var margin_value = $('#margin_'+workgroup_count+'_'+activity_count).val();
		   var sp =  parseFloat((1+(margin_value/100))*$('#total_cost_'+workgroup_count+'_'+activity_count).val());
        $('#sp_'+workgroup_count+'_'+activity_count).html(sp.toFixed(2));
        $('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
		}else{
			
			//var sp =  parseFloat((1+(margin_value/100))*$('#total_cost_'+workgroup_count+'_'+activity_count).val());
			var sp=response.margin_value;
			console.log(sp);
			var margin_value =parseFloat(((sp/$('#total_cost_'+workgroup_count+'_'+activity_count).val())-1)*100);
			$('#sp_'+workgroup_count+'_'+activity_count).html(sp);
        $('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
			$('#margin_'+workgroup_count+'_'+activity_count).val(margin_value);
		$('#margin_hidden_'+workgroup_count+'_'+activity_count).val(margin_value);
		
		}
		
     
        tot_sal = 0;
        $('input.sps_'+workgroup_count).each(function() {
          var value = parseFloat($(this).val());
          if (!isNaN(value)){
            tot_sal += value;
          }
        }
                                            );
        $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
        $('#unit_price_'+workgroup_count).val(formatNumber((tot_sal/mainqty).toFixed(2)));
        $('#sub_tot_sp'+workgroup_count).val(tot_sal);
        total_ucost = 0;
        $('input.tc_'+workgroup_count).each(function() {
          var value = parseFloat($(this).val());
          if (!isNaN(value)){
            total_ucost += value;
          }
        }
                                           );
        //alert("sdf");
        $('#sub_total_cost'+workgroup_count).html(formatNumber(total_ucost.toFixed(2)));
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
        $('#unit_price_'+workgroup_count).val(formatNumber(((tot_sal/mainqty)+parseFloat(round)).toFixed(2)));
        $('#tot'+workgroup_count).html(formatNumber((parseFloat(tot_sal)+parseFloat(round)).toFixed(2)));
        $('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
        $('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
        $('#dtotal'+workgroup_count).html('');
        total_eucost = 0;
        $('input.sub_cs').each(function() {
          var value = parseFloat($(this).val());
          if (!isNaN(value)){
            total_eucost += value;
          }
        }
                              );
        $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
        $('#estimation_total_cost_amt').val(total_eucost);
        total_profit = 0;
        $('input.sub_sp').each(function() {
          var value = parseFloat($(this).val());
          if (!isNaN(value)){
            total_profit += value;
          }
        }
                              );
        $('#estimation_profit').html(formatNumber((total_profit-total_eucost).toFixed(2)));
        $('#estimation_profit_amt').val(total_profit-total_eucost);
        tot_amt = 0;
        $('input.amt').each(function() {
          var value = parseFloat($(this).val());
          if (!isNaN(value)){
            tot_amt += value;
          }
        }
                           );
        $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
        $('#subtotal_amt').val(tot_amt);
        var tax_amt = (tot_amt)*(5/100);
        $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
        $('#estimation_tax_amount').val(tax_amt.toFixed(2));
        $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
        $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
      }
    }
          );
   
    setTimeout(function() {
		get_total_by_category();
    }, 2000);
    var nxtct=$('#nextsubcnt_'+workgroup_count+'_'+activity_count).val();
    if(nxtct==0){
      $('#nextsubcnt_'+workgroup_count+'_'+activity_count).val(1);
      addMore(workgroup_count,0);
    }
  }
  
  function get_total_by_category()
  {
	  
	  var catarr=[];
        $('.errorDivstr1').each(function() {
          if($(this).text()!=''){
            catarr.push($(this).text());
          }
        });
		
		 $('.errorDivstr1').each(function() {
			  tcost=0;
		 sellingprice=0;
			 var catid=$(this).text();
			 
		$('.mid').each(function() {
			if(catid==$(this).val()){
			
          var status=checkValue2($(this).val(), catarr);
		 
          if(status=='Exist'){
            var totid=$(this).attr('id');
			
			var totida=totid.split('_');
			var totalcost=$('#total_cost_'+totida[1]+'_'+totida[2]+'').val();
			 var value = parseFloat(totalcost);
			  if (!isNaN(value)){
				tcost += value;
			  }
			 
			var sprice=$('#selling_price_'+totida[1]+'_'+totida[2]+'').val();
			 var value1 = parseFloat(sprice);
			  if (!isNaN(value1)){
				sellingprice += value1;
			  }
			  var dangerpercent=Math.round(parseFloat(tcost/sellingprice)*100);
			   var successpercent=Math.round(100-dangerpercent);
			   $('.pdanger'+catid+'').css("width", ""+dangerpercent+"%");
			    $('.psuccess'+catid+'').css("width", ""+successpercent+"%");
			  $('.sellingprice'+catid+'').html(formatNumber((sellingprice).toFixed(2)));
		 $('.totalcost'+catid+'').html(formatNumber((tcost).toFixed(2)));
           
          }
			}
        }); 
		
		
		 
		 });
		
  }  
  function save(workgroup_count,activity_count){
    var act_count = $('#wrapper_'+workgroup_count+'_'+activity_count+' > div:last').data('count')+1 || 0;
    var divcnt=act_count;
    for(i = 0; i < divcnt; i++) {
      var mainqty=$('#qty'+workgroup_count+'').val();
      var subqty=$('#quantity_'+workgroup_count+'_'+i).val();
      var quantity=$('#quantity_'+workgroup_count+'_'+i).val();
      var unit_cost = $('#unit_cost_'+workgroup_count+'_'+i).val();
      var margin_value = $('#margin_'+workgroup_count+'_'+i).val();
      $('#exact_qnty_'+workgroup_count+'_'+i).val(subqty/mainqty);
      $('#total_cost_'+workgroup_count+'_'+i).val(subqty*unit_cost);
      var sp =  parseFloat((1+(margin_value/100))*parseFloat($('#total_cost_'+workgroup_count+'_'+i).val()));
      $('#sp_'+workgroup_count+'_'+i).html(sp.toFixed(2));
      $('#selling_price_'+workgroup_count+'_'+i).val(sp);
    }
    var round = 0;
    tot_sal = 0;
    $('#round_helper'+workgroup_count).val(round);
    $('#dtotal'+workgroup_count).html('');
    $('input.sps_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_sal += value;
      }
    }
                                        );
    $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
    $('#sub_tot_sp'+workgroup_count).val(tot_sal);
    total_ucost = 0;
    $('input.tc_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_ucost += value;
      }
    }
                                       );
    $('#sub_total_cost'+workgroup_count).html(formatNumber(total_ucost.toFixed(2)));
    $('#sub_tot_cost'+workgroup_count).val(total_ucost);
    $('#unit_price_'+workgroup_count).val(formatNumber(((tot_sal/mainqty)+parseFloat(round)).toFixed(2)));
    $('#tot'+workgroup_count).html(formatNumber((tot_sal+parseFloat(round)).toFixed(2)));
    $('#amount_'+workgroup_count).val(tot_sal+parseFloat(round));
    $('#samount_'+workgroup_count).val(tot_sal);
    $('#ototal'+workgroup_count).html(tot_sal+parseFloat(round));
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_eucost += value;
      }
    }
                          );
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    $('#estimation_total_cost_amt').val(total_eucost);
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit-total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit-total_eucost);
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    var tax_amt = (tot_amt)*(5/100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
	get_total_by_category();
  }
  function addMore(workgroup_count,activity_count){
    var qty=$('#qty'+workgroup_count+'').val();
    var act_count = $('#wrapper_'+workgroup_count+'_'+activity_count+' > div:last').data('count')+1 || 0;
    var j = act_count+1;
    $('#wrapper_'+workgroup_count+'_'+activity_count+'').append("<div data-count='"+act_count+"'><div id='ac_id_"+workgroup_count+"_"+act_count+"' class='d col-md-12' style='margin-top: 10px;' ><div class='' ><div style='width:3%;float:left;' >"+j+"</div><div style='width:10%;float:left;margin-right: 5px;' ><input type='text' name='subitems["+workgroup_count+"][sku][]' id='sku_"+workgroup_count+"_"+act_count+"'  class='form-control pd0 '/><input type='hidden' id='nextsubcnt_"+workgroup_count+"_"+act_count+"'  class='form-control  ' value='0'/></div><div style='width:30%;float:left;margin-right: 5px;'><input type='text' id='matid_"+workgroup_count+"_"+act_count+"' class='mid  matidnew"+workgroup_count+"' style='display:none;'><input type='text' class='form-control typeahead' data-provide='typeahead' data-hidden-field-id='name_id_"+workgroup_count+"_"+act_count+"' name='subitems["+workgroup_count+"][newmaterial][]' id='name_"+workgroup_count+"_"+act_count+"' placeholder='Enter Material' autocomplete='off' ><input type='hidden' name='subitems["+workgroup_count+"][name][]' id='name_id_"+workgroup_count+"_"+act_count+"' autocomplete='off' value='' class='allcategory'/><input type='hidden' name='' id='allcategory_"+workgroup_count+"_"+act_count+"' autocomplete='off' value='' class='allcategory_"+workgroup_count+"'/></div><div style='width:5%;float:left;margin-right: 5px;'><input type='text' name='subitems["+workgroup_count+"][qty][]' id='quantity_"+workgroup_count+"_"+act_count+"' class='form-control' value='1' onchange='save("+workgroup_count+",0);'/><input type='hidden' id='exact_qnty_"+workgroup_count+"_"+act_count+"' value=''></div><div style='width:10%;float:left;margin-right: 5px;'><input type='text' name='subitems["+workgroup_count+"][unit_cost][]' id='unit_cost_"+workgroup_count+"_"+act_count+"' class='form-control text-right' onchange='select_subcost(this.value,"+workgroup_count+","+act_count+")'/></div><div style='width:10%;float:left;margin-right: 5px;'><input type='text' name='subitems["+workgroup_count+"][total_cost][]' id='total_cost_"+workgroup_count+"_"+act_count+"' class='text-right form-control tc_"+workgroup_count+"' readonly /></div><div style='width:8%;float:left;margin-right: 5px;'><input type='text' name='subitems["+workgroup_count+"][margin][]' id='margin_"+workgroup_count+"_"+act_count+"' class='form-control selling_price_"+workgroup_count+"_"+act_count+"' onchange='change_margin(this.value,"+workgroup_count+","+act_count+");'/><input type='hidden' name='' id='margin_hidden_"+workgroup_count+"_"+act_count+"' class='form-control margin_hidden_0_0' /></div><div style='width:12%;float:left;margin-right: 5px;'><span id='sp_"+workgroup_count+"_"+act_count+"' class='form-control text-right'>0</span><input type='hidden' name='subitems["+workgroup_count+"][selling_price][]' id='selling_price_"+workgroup_count+"_"+act_count+"' class='sps_"+workgroup_count+"' /> <input type='hidden' name='' id='final_sp_"+workgroup_count+"_"+act_count+"' class='form-control final_sp_"+workgroup_count+"_"+act_count+"' /></div><div style='width:7%;float:left;'><a  class='remove btn btn-danger' onclick='removediv("+workgroup_count+","+act_count+");' id='rdiv"+workgroup_count+""+act_count+"'>-</a> </div></div></div>");
	
	
	var c=0;
	$('#sku_'+workgroup_count+'_'+act_count+'').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material_sku',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						if(data == '0'){
							//alert("fds");
							$('#name_id_'+workgroup_count+'_'+act_count+'').val('-1');
							$('#allcategory_'+workgroup_count+'_'+act_count+'').val('-1');
								if(c==0){
							addMore(workgroup_count,0);
							}
							 c++;
						}else{
						 map = {};
						 states = [];
						 
						$.each(data, function (i, state) {
					 map[state.name] = state;
      states.push(state.name);
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
		var catarr=[];
        $('.allcategory_'+workgroup_count+'').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
		 var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){	
        $(`#${hiddenFieldId}`).val(SelectedCode);
		add_activity(SelectedCode,workgroup_count,act_count);
        
        return SelectedCityName;
		}else{
		  alert("Already Selected");
		  return false;
	  }
    }

});
	var d=0;
	$('#name_'+workgroup_count+'_'+act_count+'').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						if(data == '0'){
							//alert("fds");
							$('#name_id_'+workgroup_count+'_'+act_count+'').val('-1');
							$('#allcategory_'+workgroup_count+'_'+act_count+'').val('-1');
								if(d==0){
							addMore(workgroup_count,0);
							}
							 d++;
						}else{
						 map = {};
						        
		
						 states = [];
						$.each(data, function (i, state) {
							 map[state.name] = state;
      states.push(state.name);
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
		var catarr=[];
        $('.allcategory_'+workgroup_count+'').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){
        $(`#${hiddenFieldId}`).val(SelectedCode);
		
		add_activity(SelectedCode,workgroup_count,act_count);
        
        return SelectedCityName;
		}else{
		  alert("Already Selected");
		  return false;
	  }
    }
	});
  }
  function removediv(workgroup_count,act_count)
  {
	  
	 var nameseleted=$("#name_"+workgroup_count+"_"+act_count+"").val();
	 if(nameseleted==""){
		 alert("Cannot delete This row.");
	 return false;
	 }else{
    var prevcnt=act_count-1;
    $("#nextsubcnt_"+workgroup_count+"_"+prevcnt+"").val(0);
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
	var catarr=[];
        $('.mid').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        }
                      );
        $('.errorDivstr').each(function() {
          var status=checkValue2($(this).text(), catarr);
          if(status=='Not exist'){
            var matid=$(this).text();
            $('#removediv'+matid+'').remove();
            //$(this).parent('div').remove();
          }
        });
		
		$('.errorDivstr1').each(function() {
          var status=checkValue2($(this).text(), catarr);
          if(status=='Not exist'){
            var matid=$(this).text();
            $('#removediv1'+matid+'').remove();
            //$(this).parent('div').remove();
          }
        });
		
		get_total_by_category();
	 }
  }
  function get_total_change()
  {
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)) {
        total_eucost += value;
      }
    }
                          );
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    $('#estimation_total_cost_amt').val(total_eucost);
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)) {
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit - total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit - total_eucost);
    var tax_amt = (tot_amt) * (5 / 100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)) {
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt) + parseFloat(tot_amt));
  }
  $('body').on('change','#client_id',function() {
    var client_id = $('#client_id').val();
    $.ajax({
      url : "<?php echo base_url(); ?>estimations/get_client_contacts",
      data:{
        client_id : client_id}
      ,
      method:'POST',
      // dataType:'json',
      success:function(data) {
        $('#client_contact_id').html(data);
      }
    }
          );
  }
              );
  function select_subcost(val,workgroup_count,activity_count){
    var unit_cost = val;
	
	
    var quantity = parseFloat($('#quantity_'+workgroup_count+'_'+activity_count).val());
	
	
    var margin_value = parseFloat($('#margin_'+workgroup_count+'_'+activity_count).val());
	var margin_value = isNaN(parseInt(margin_value)) ? 0 : parseInt(margin_value);
	//alert(value);
	
	var sp =  parseFloat((1+(margin_value/100))*parseFloat($('#total_cost_'+workgroup_count+'_'+activity_count).val()));
	
    $('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*unit_cost);
    
	
    $('#sp_'+workgroup_count+'_'+activity_count).html(sp.toFixed(2));
    $('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
    tot_sal = 0;
    $('input.sps_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_sal += value;
      }
    }
                                        );
    $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
    $('#sub_tot_sp'+workgroup_count).val(tot_sal);
    total_ucost = 0;
    $('input.tc_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_ucost += value;
      }
    }
                                       );
    $('#sub_total_cost'+workgroup_count).html(formatNumber(total_ucost.toFixed(2)));
    $('#sub_tot_cost'+workgroup_count).val(total_ucost);
    var mainqty = parseFloat($('#qty'+workgroup_count).val());
    var round_value = parseFloat($('#round_helper'+workgroup_count).val());
    if (!isNaN(round_value)){
      round = round_value;
    }
    else{
      round = 0;
    }
    $('#unit_price_'+workgroup_count).val(formatNumber((parseFloat(tot_sal)+parseFloat(round)/mainqty).toFixed(2)));
    $('#tot'+workgroup_count).html(formatNumber((parseFloat(tot_sal)+parseFloat(round)).toFixed(2)));
    $('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
    $('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_eucost += value;
      }
    }
                          );
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    $('#estimation_total_cost_amt').val(total_eucost);
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit-total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit-total_eucost);
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    var tax_amt = (tot_amt)*(5/100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
  }
  
  function check_last_selling_value(margin_value,workgroup_count,activity_count)
  {
	  var quantity = parseFloat($('#quantity_'+workgroup_count+'_'+activity_count).val());
	  var finalselling=$('#final_sp_'+workgroup_count+'_'+activity_count).val()*quantity;
	  var sp =  parseFloat((1+(margin_value/100))*parseFloat($('#total_cost_'+workgroup_count+'_'+activity_count).val()));
		if(sp<finalselling)
		{
			alert("You Cannot Use this value.");
			return 0;
		}else{
			return 1;
		}
  }
  function select_activityquantity(val,workgroup_count,activity_count){
    var quantity = val;
    var mainqty=$('#qty'+workgroup_count+'').val();
    $('#exact_qnty_'+workgroup_count+'_'+activity_count).val(quantity/mainqty);
    var unit_cost = $('#unit_cost_'+workgroup_count+'_'+activity_count).val();
    var margin_value = $('#margin_'+workgroup_count+'_'+activity_count).val();
    $('#total_cost_'+workgroup_count+'_'+activity_count).val(quantity*unit_cost);
    var sp =  parseFloat((1+(margin_value/100))*$('#total_cost_'+workgroup_count+'_'+activity_count).val());
    $('#sp_'+workgroup_count+'_'+activity_count).html(sp.toFixed(2));
    $('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
    tot_sal = 0;
    $('input.sps_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_sal += value;
      }
    }
                                        );
    $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
    $('#sub_tot_sp'+workgroup_count).val(tot_sal);
    total_ucost = 0;
    $('input.tc_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_ucost += value;
      }
    }
                                       );
    $('#sub_total_cost'+workgroup_count).html(formatNumber(total_ucost.toFixed(2)));
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
    $('#tot'+workgroup_count).html(formatNumber((parseFloat(tot_sal)+parseFloat(round)).toFixed(2)));
    $('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
    $('#unit_price_'+workgroup_count).val(formatNumber((parseFloat(tot_sal/mainqty)+parseFloat(round)).toFixed(2)));
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_eucost += value;
      }
    }
                          );
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    $('#estimation_total_cost_amt').val(total_eucost);
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit-total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit-total_eucost);
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    var tax_amt = (tot_amt)*(5/100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
  }
  function change_margin(val,workgroup_count,activity_count)
  {
    var margin_value=val;
	var result=check_last_selling_value(margin_value,workgroup_count,activity_count);
	if(result==1){
    var mainqty = parseFloat($('#qty'+workgroup_count).val());
    var sp =  parseFloat((1+(margin_value/100))*($('#total_cost_'+workgroup_count+'_'+activity_count).val()));
    $('#sp_'+workgroup_count+'_'+activity_count).html(sp.toFixed(2));
    $('#selling_price_'+workgroup_count+'_'+activity_count).val(sp);
    tot_sal = 0;
    $('input.sps_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_sal += value;
      }
    }
                                        );
    $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
    $('#sub_tot_sp'+workgroup_count).val(tot_sal);
    round = 0;
    $('#round_helper'+workgroup_count).val(round);
    $('#unit_price_'+workgroup_count).val(formatNumber(((tot_sal/mainqty)+parseFloat(round)).toFixed(2)));
    $('#tot'+workgroup_count).html(formatNumber((parseFloat(tot_sal)+parseFloat(round)).toFixed(2)));
    $('#amount_'+workgroup_count).val(parseFloat(tot_sal)+parseFloat(round));
    $('#ototal'+workgroup_count).html(parseFloat(tot_sal)+parseFloat(round));
    $('#dtotal'+workgroup_count).html('');
    get_total_change();
	get_total_by_category();
	}
  }
  function main_item(val,workgroup_count){
    //alert(default_val);
    var qty = val;
    var k = 0;
    tot_sal = 0;
    var mainqty=$('#qty'+workgroup_count).val();
    $('input.sps_'+workgroup_count).each(function() {
      var itemqty=$('#exact_qnty_'+workgroup_count+'_'+k).val();
      $('#quantity_'+workgroup_count+'_'+k).val(mainqty*itemqty);
      var unit_cost = $('#unit_cost_'+workgroup_count+'_'+k).val();
      var margin_value = $('#margin_'+workgroup_count+'_'+k).val();
      var quantity = $('#quantity_'+workgroup_count+'_'+k).val();
      var round = 0;
      $('#round_helper'+workgroup_count).val(round);
      $('#dtotal'+workgroup_count).html('');
      $('#total_cost_'+workgroup_count+'_'+k).val(quantity*unit_cost);
      var sp =  parseFloat((1+(margin_value/100))*($('#total_cost_'+workgroup_count+'_'+k).val()));
      $('#sp_'+workgroup_count+'_'+k).html(sp.toFixed(2));
      $('#selling_price_'+workgroup_count+'_'+k).val(sp);
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_sal += value;
      }
      k++;
    }
                                        );
    $('#sub_total_sp'+workgroup_count).html(formatNumber(tot_sal.toFixed(2)));
    $('#sub_tot_sp'+workgroup_count).val(tot_sal);
    total_ucost = 0;
    $('input.tc_'+workgroup_count).each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_ucost += value;
      }
    }
                                       );
    $('#sub_total_cost'+workgroup_count).html(formatNumber(total_ucost.toFixed(2)));
    $('#sub_tot_cost'+workgroup_count).val(total_ucost);
    $('#unit_price_'+workgroup_count).val(formatNumber(((tot_sal/mainqty)+parseFloat(round)).toFixed(2)));
    $('#tot'+workgroup_count).html(formatNumber((tot_sal+parseFloat(round)).toFixed(2)));
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
    }
                          );
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    $('#estimation_total_cost_amt').val(total_eucost);
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit-total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit-total_eucost);
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    var tax_amt = (tot_amt)*(5/100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
	
	get_total_by_category();
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
		var catarr=[];
        $('.mid').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        }
                      );
        $('.errorDivstr').each(function() {
          var status=checkValue2($(this).text(), catarr);
          if(status=='Not exist'){
            var matid=$(this).text();
            $('#removediv'+matid+'').remove();
            //$(this).parent('div').remove();
          }
        });
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
    }
    else{
      var round = 0;
    }
    var maintot=$('#ototal'+workgroup_count).html();
    var differ=parseFloat(round) - parseFloat(maintot);
    $('#dtotal'+workgroup_count).html(differ);
    $('#amount_'+workgroup_count).val(parseFloat(round));
    $('#tot'+workgroup_count).html(formatNumber((parseFloat(round)).toFixed(2)));
    $('#unit_price_'+workgroup_count).val(formatNumber((parseFloat(round)).toFixed(2)));
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_eucost += value;
      }
    }
                          );
    total_diff = 0;
    $('.sub_diff').each(function() {
      var value1 = parseFloat($(this).text());
      console.log(value1);
      if (!isNaN(value1)){
        total_diff += value1;
      }
    }
                       );
    $('#estimation_total_cost_amt').val(total_eucost);
    $('#estimation_total_cost').html(formatNumber(total_eucost.toFixed(2)));
    total_profit = 0;
    $('input.sub_sp').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_profit += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((total_profit-total_eucost+total_diff).toFixed(2)));
    $('#estimation_profit_amt').val(total_profit-total_eucost+total_diff);
    tot_amt = 0;
    $('input.amt').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        tot_amt += value;
      }
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    var tax_amt = (tot_amt)*(5/100);
    $('#estimation_tax').html(formatNumber(tax_amt.toFixed(2)));
    $('#estimation_tax_amount').val(tax_amt.toFixed(2));
    $('#estimation_total_amount').html(formatNumber((parseFloat(tax_amt)+parseFloat(tot_amt)).toFixed(2)));
    $('#estimation_total_amt').val(parseFloat(tax_amt)+parseFloat(tot_amt));
    return false;
    $('#unit_price_'+workgroup_count).val(formatNumber((parseFloat(ln_tot)+parseFloat(round)).toFixed(2)));
    $('#tot'+workgroup_count).html(parseFloat(ln_tot)+parseFloat(round));
    $('#amount_'+workgroup_count).val(parseFloat(ln_tot)+parseFloat(round));
    $('#ototal'+workgroup_count).html(parseFloat(ln_tot)+parseFloat(round));
  }
  function select_discount(val){
    var discount = val;
    var estimated_profit = $('#estimation_profit_amt').val();
    var tot = $('#estimation_total_amt').val();
    $('#estimation_profit_amt').val(estimated_profit-discount);
    $('#estimation_profit').html(formatNumber((estimated_profit-discount).toFixed(2)));
    $('#estimation_total_amount').html(formatNumber((tot-discount).toFixed(2)));
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
    var x = 0;
    //Initial field counter
    var y = 0;
    var list_maxField = 10;
    //Input fields increment limitation
    //Once add button is clicked
    $('.list_add_button').click(function()
                                {
      //Check maximum number of input fields
      if(x < list_maxField){
        x++;
        //Increment field counter
        var list_fieldHTML = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-3"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Name" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+x+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button btn btn-danger">-</a></div></div>';
        //New input field html 
        $('.list_wrapper').append(list_fieldHTML);
        //Add field html
      }
    }
                               );
    //Once remove button is clicked
    $('.list_wrapper').on('click', '.list_remove_button', function()
                          {
      $(this).closest('div.row').remove();
      //Remove field html
      x--;
      //Decrement field counter
    }
                         );
    //sub div
    //Once add button is clicked
    $('.list_add_button1').click(function()
                                 {
      //Check maximum number of input fields
      if(y < list_maxField){
        y++;
        //Increment field counter
        var list_fieldHTML1 = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="SKU" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="SKU" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-1"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-2"><div class="form-group"><input name="list['+y+'][]" type="text" placeholder="Type Item Quantity" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button1 btn btn-danger">-</a></div></div>';
        //New input field html 
        $('.sub-wrapper').append(list_fieldHTML1);
        //Add field html
      }
    }
                                );
    //Once remove button is clicked
    $('.sub-wrapper').on('click', '.list_remove_button1', function()
                         {
      $(this).closest('div.row').remove();
      //Remove field html
      y--;
      //Decrement field counter
    }
                        );
  }
                   );
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
    }
                       );
    $('#subtotal').html(formatNumber(tot_amt.toFixed(2)));
    $('#subtotal_amt').val(tot_amt);
    total_eucost = 0;
    $('input.sub_cs').each(function() {
      var value = parseFloat($(this).val());
      if (!isNaN(value)){
        total_eucost += value;
      }
    }
                          );
    $('#estimation_profit').html(formatNumber((tot_amt-total_eucost).toFixed(2)));
    $('#estimation_profit_amt').val(tot_amt-total_eucost);
  }
  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  }
  $(document).ready(function() {
	  
	  $("#checkAll").change(function () {
    $("input:checkbox.checkall").prop('checked', $(this).prop("checked"));
	$(".checkall").each(function() {		
		
		var checkid=$(this).attr('id');
		var mainid=checkid.split('_');
		change_margin_value(mainid[2]);
	});
});

$(".checkall").change(function () {
	
		_tot = $(".checkall").length						  
		_tot_checked = $(".checkall:checked").length;
		
		if(_tot != _tot_checked){
			$("#checkAll").prop('checked',false);
			/*var checkid=$(this).attr('id');
		var mainid=checkid.split('_');
		change_margin_value(mainid[2]);*/
		}
});
	  
	  
	  var g=0;
	   $('#sku_0_0').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material_sku',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						if(data == '0'){
							//alert("fds");
							$('#name_id_0_0').val('-1');
							$('#allcategory_0_0').val('-1');
							if(g==0){
							addMore(0,0);
							}
							 g++;

						}else{
						 map = {};
						 states = [];						
						$.each(data, function (i, state) { 
							map[state.name] = state;
							states.push(state.name);
							});
						process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
		var catarr=[];
        $('.allcategory_0').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
        $(`#${hiddenFieldId}`).val(SelectedCode);
		add_activity(SelectedCode,0,0);
        
        return SelectedCityName;
		 }else{
		  alert("Already Selected");
		  return false;
	  }
    }

});
	  var  p=0;
	   $('#name_0_0').typeahead({
    source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>estimations/get_all_material',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						//console.log(data);
						
						if(data == '0'){
							
							//alert("fds");
							$('#name_id_0_0').val('-1');
							$('#allcategory_0_0').val('-1');
							//console.log(p);
							if(p==0){
							addMore(0,0);
							}
							 p++;

						}else{
						 map = {};
						 states = [];
						$.each(data, function (i, state) {
							
							 map[state.name] = state;
      states.push(state.name);
							
    });
    process(states);
                    }
					}   
                });  
				
 
    
    },
 
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].description;
		
        //console.log(SelectedCityName);
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId');
        // Save SelectedCode to hiddenfield
		 var catarr=[];
        $('.allcategory_0').each(function() {
          if($(this).val()!=''){
            catarr.push($(this).val());
          }
        });
							
     var status=checkValue2(SelectedCode, catarr);
	  if(status=='Not exist'){		
        $(`#${hiddenFieldId}`).val(SelectedCode);
		add_activity(SelectedCode,0,0);
		return SelectedCityName;
	  }else{
		  alert("Already Selected");
		  return false;
	  }
        
        
    }

});
		 
	  
	  
    $('.categorymargin').keypress(function(event){
      // play with event
      // use $(this) to determine which element triggers this event
      alert($(this).val());
      alert($(this).attr('data-id'));
    }
                                 );
    var x = 0;
    //initialize counter for text box
    $('.add_more_button').click(function(e){
      //click event on add more fields button having class add_more_button
      e.preventDefault();
      x++;
      //counter increment
      select_workgroup(x);
      // $('.input_fields_container_part').append('<div><input type="text" name="tags" value="'+x+'"/><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
    }
                               );
    $('.input_fields_container_part').on("click",".remove_field", function(e){
      //user click on remove text links
      e.preventDefault();
      $(this).parent('div').remove();
    })
  });
  
  
</script>
