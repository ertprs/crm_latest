<script src="<?php echo base_url('assets/js/typeahead.js'); ?>"></script>  <script>
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
function add_activity1(value,workgroup_count,activity_count)
{//$(".errorDiv").html('');

    var material_id = value;
	if(material_id!=''){
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
       
	}
	});
	}
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
  
  function updatetypeahead(workgroup_count,act_count)
  {	  	  
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
  }       function skuupdatetypeahead(workgroup_count,act_count)  {	  var c=0;	$('#sku_'+workgroup_count+'_'+act_count+'').typeahead({				source: function (query, process) {			$.ajax({				url: '<?php print base_url();?>estimations/get_all_material_sku',					data: 'str=' + query,                                dataType: "json",                    type: "POST",                    success: function (data) {						if(data == '0'){							$('#name_id_'+workgroup_count+'_'+act_count+'').val('-1');	
$('#allcategory_'+workgroup_count+'_'+act_count+'').val('-1');  if(c==0){							addMore(workgroup_count,0);							}							c++;													}else{							map = {};						 states = [];						 						$.each(data, function (i, state) {					 map[state.name] = state;      states.push(state.name);    });    process(states);													}					}							});					},     updater: function (item) {		 SelectedCode=map[item].id;		 SelectedCityName=map[item].name;		  var hiddenFieldId = this.$element.data('hiddenFieldId');		  var catarr=[];        $('.allcategory_'+workgroup_count+'').each(function() {          if($(this).val()!=''){            catarr.push($(this).val());          }        });		var status=checkValue2(SelectedCode, catarr);	  if(status=='Not exist'){	        $(`#${hiddenFieldId}`).val(SelectedCode);		add_activity(SelectedCode,workgroup_count,act_count);                return SelectedCityName;		}else{		  alert("Already Selected");		  return false;	  }            	}			});	  	  }
</script>  <div class="input_fields_container_part">
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
				<?php if($estimation_main_items!=''){
	$i=0;
	foreach($estimation_main_items as $eachItem){
		$newarra=array();
		$sub1=$this->Estimations_Model->get_estimation_main_sub_items($eachItem['main_item_id']);
		
		$newarra[]=array('sub_item_id'=>'','estimation_id'=>'','main_item_id'=>'','item_code'=>'','name'=>'',
		'unit_cost'=>'','qty'=>'1','total_cost'=>'','margin'=>'','selling_price'=>'',
		'material_id'=>'','category'=>'','itemname'=>'','itemdescription'=>'','unittype'=>'',
		'cost'=>'','last_selling_price'=>'','remarks'=>'','margin_type'=>'','margin_value'=>'',
		'created'=>'','documents'=>'','others'=>'','next_sub'=>'0');
		$getsubitems=array_merge($sub1,$newarra);
		
		?>
              <div class="col-xs-12 col-sm-8 col-md-12 " id="workgroup_id<?php print $i;?>">
			 
                <div class="panel panel-info">
                  <div class="panel-body">
                  	
                    <div class="row cloned-row" style="padding: 10px;" >
                      <div class="col-sm-1">
                        <span>
                          <input type="checkbox" style="padding-right:10px;" id="check_price_<?php print $i;?>" onclick="change_margin_value('<?php print $i;?>')" class="checkall"> <b><?php print $i+1;;?>
                          </b>
                        </span>
                      </div>
                      <div class="col-sm-4">
					  
                        <input type="text" name="items[item_name][]"  id="item_name<?php print $i;?>" required="required" class="form-control" value="<?php print $eachItem['item_name'];?>"  />
                        <input type="hidden" value="0" id="nextcnt<?php print $i;?>">
                      </div>
                      <div class="col-sm-1">
                        <input type="text" name="items[qty][]" id="qty<?php print $i;?>" class="form-control" 	value="<?php print $eachItem['quantity'];?>"  onchange="main_item(this.value,<?php print $i;?>)" >
                      </div>
                      <!--onchange="change_round_helper(0,0)" -->
                      <div class="col-sm-2">
                        <input type="text" name="items[unit_price][]" id="unit_price_<?php print $i;?>" class="form-control text-right" value="<?php print number_format($eachItem['unit_price'],2);?>">
                      </div>
                      <div class="col-sm-1">
                        <input type="text" name="items[tax][]" id="tax_<?php print $i;?>" class="form-control" value="<?php print $eachItem['tax'];?>">
                      </div>
                      <div class="col-sm-2">
                        <span id="tot<?php print $i;?>" class="form-control totalcostclass text-right"><?php print number_format($eachItem['amount'],2);?>
                        </span>
                        <input type="hidden" name="items[amount][]" id="amount_<?php print $i;?>" class="amt" value="<?php print $eachItem['amount'];?>"/>
                      </div>
                      <div class="">
                        <button class="btn btn-success removeclass " type="button" onclick="select_activity(<?php print $i;?>,0);">
                          <i class="glyphicon glyphicon-circle-arrow-down">
                          </i>
                        </button> 
                        <button class='btn btn-success' type='button' onclick='remove_activity(<?php print $i;?>,0);'>
                          <i class='glyphicon glyphicon-trash'>
                          </i>
                        </button>
                      </div>                          
                    </div>
                    <div style="border:1px solid #ddd;padding:10px;display:block" class="row " id="border_id_<?php print $i;?>_0">
                      <div class=" well clearfix sub-wrapper" >
					 
                        <div id="wrapper_<?php print $i;?>_0">
					 <?php $t=0;for($t=0;$t<count($getsubitems);$t++){?>
                          <div data-count="<?php print $t;?>">
                            <div id="ac_id_<?php print $i;?>_<?php print $t;?>" style="display:block; margin-top:10px;" class="col-md-12"> 
                              <div style="width:3%;float:left;">
							  							  <?php if($t==0){?>
                                <label class="control-label">#
														  </label> <br><?php }?>
                               
                                <span>
                                  <b><?php print $t+1;?>
                                  </b>
                                </span>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Sku
                                </label>
							  <?php }?>
                                <input type="text" name="subitems[<?php print $i;?>][sku][]" id="sku_<?php print $i;?>_<?php print $t;?>"  class="form-control " placeholder="Enter SKU" autocomplete="off" value="<?php print $getsubitems[$t]['item_code']?>"/>
                                <input type="hidden" value="<?php if(isset($getsubitems[$t]['next_sub'])){ print $getsubitems[$t]['next_sub'];}?>" id="nextsubcnt_<?php print $i;?>_<?php print $t;?>">
                              </div>
                              <div style="width:30%;float:left;margin-right: 5px;">
							  							  <?php if($t==0){?>
                                <label class="control-label">Name
														  </label><?php }?>
								 <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="name_id_<?php print $i;?>_<?php print $t;?>" name="subitems[<?php print $i;?>][newmaterial][]" id="name_<?php print $i;?>_<?php print $t;?>" placeholder="Enter Material" autocomplete="off" value="<?php if(is_numeric($getsubitems[$t]['name'])){print htmlentities($getsubitems[$t]['itemdescription']);}else{print $getsubitems[$t]['name'];} ?>" >
        <input type="hidden" name="subitems[<?php print $i;?>][name][]" id="name_id_<?php print $i;?>_<?php print $t;?>" autocomplete="off" value="<?php if(is_numeric($getsubitems[$t]['name'])){print $getsubitems[$t]['material_id'];}else if($getsubitems[$t]['name']!=''){print "-1";} ?>" class="allcategory"/>
		<input type="hidden" name="" id="allcategory_<?php print $i;?>_<?php print $t;?>" autocomplete="off" value="<?php if(is_numeric($getsubitems[$t]['name'])){print $getsubitems[$t]['material_id'];}else if($getsubitems[$t]['name']!=''){print "-1";} ?>" class="allcategory_<?php print $i;?>"/>
                                <input type="hidden" id="matid_<?php print $i;?>_<?php print $t;?>" class="mid matidnew<?php print $i;?>" style="display:block;" value="<?php print $getsubitems[$t]['category'];?>">
							
                              </div>
                              
                              <div style="width:5%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Qty
							  </label><?php }?>
                                <input type="text" name="subitems[<?php print $i;?>][qty][]" id="quantity_<?php print $i;?>_<?php print $t;?>"  class="form-control" value="<?php print $getsubitems[$t]['qty']?>" onchange="save(<?php print $i;?>,0);" />
                                <input type="hidden" id="exact_qnty_<?php print $i;?>_<?php print $t;?>" value="1"  >
                              </div>
							  <div style="width:10%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Unit Cost
							  </label><?php }?>
                                <input type="text" name="subitems[<?php print $i;?>][unit_cost][]" id="unit_cost_<?php print $i;?>_<?php print $t;?>" class="form-control text-right" onchange="select_subcost(this.value,<?php print $i;?>,<?php print $t;?>)" value="<?php print $getsubitems[$t]['unit_cost']?>"/>
                              </div>
                              <div style="width:10%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Total Cost
							  </label><?php }?>
                                <input type="text" name="subitems[<?php print $i;?>][total_cost][]" id="total_cost_<?php print $i;?>_<?php print $t;?>" class="form-control tc_<?php print $i;?> text-right" readonly value="<?php print $getsubitems[$t]['total_cost']?>"/>
                              </div>
                              <div style="width:8%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Margin % 
							  </label><?php }?>
                                <input type="text" name="subitems[<?php print $i;?>][margin][]" id="margin_<?php print $i;?>_<?php print $t;?>" class="form-control selling_price_<?php print $i;?>_<?php print $t;?>" onchange="change_margin(this.value,<?php print $i;?>,<?php print $t;?>);"value="<?php print $getsubitems[$t]['margin']?>"/>
								
								<input type="hidden" name="" id="margin_hidden_<?php print $i;?>_<?php print $t;?>" class="form-control margin_hidden_<?php print $i;?>_<?php print $t;?>" value="<?php print $getsubitems[$t]['margin']?>" />
                              </div>
                              <div style="width:12%;float:left;margin-right: 5px;">
							  <?php if($t==0){?>
                                <label class="control-label">Selling Price
							  </label><br><?php }?>
                                
                                <span id="sp_<?php print $i;?>_<?php print $t;?>" class="form-control text-right"><?php print $getsubitems[$t]['selling_price']?>
                                </span>
                                <input type="hidden" name="subitems[<?php print $i;?>][selling_price][]" id="selling_price_<?php print $i;?>_<?php print $t;?>" class="sps_<?php print $i;?>" value="<?php print $getsubitems[$t]['selling_price']?>"/>
								 <input type="hidden" name="" id="final_sp_<?php print $i;?>_<?php print $t;?>" class="form-control final_sp_<?php print $i;?>_<?php print $t;?>" value="<?php if(is_numeric($getsubitems[$t]['name'])){print $getsubitems[$t]['last_selling_price'];} ?>"/>
                              </div>
                              <div style="width:7%;float:left;">
							  <?php if($t==0){?>
                                <label class="control-label">Action
							  </label><?php }?>
<a class="remove btn btn-danger" onclick="removediv(<?php print $i;?>,<?php print $t;?>);" id="rdiv<?php print $i;?><?php print $t;?>">-</a>
                              </div>                          
                            </div>
                          </div>
						  <script>
						  add_activity1("<?php print $getsubitems[$t]['material_id'];?>","<?php print $i;?>","<?php print $t;?>");
						updatetypeahead("<?php print $i;?>","<?php print $t;?>");												skuupdatetypeahead("<?php print $i;?>","<?php print $t;?>");
						  </script>
						  <?php }?>
                        </div>
					  
                      </div>
                      <div id="totals0" style="display:block" class="col-md-offset-1">
                        <div class="col-md-12" style="margin-bottom: 10px;">
                          <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-6 text-danger">
                              <b>
                              </b> 
                            </div>
                            <div class="col-md-2 text-right " style="padding-right:0px;">
                              <b>Item Cost:
                              </b> 
                              <span id="sub_total_cost<?php print $i;?>" ><?php print $eachItem['sub_tot_cost']?>
                              </span>
                            </div>
                            <div class="col-md-3 text-right">
                              <b>Item Selling Price:
                              </b>  
                              <span id="sub_total_sp<?php print $i;?>" ><?php print $eachItem['sub_tot_sp']?>
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
                                <input type="text" name="items[round_helper][]" id="round_helper<?php print $i;?>" class="form-control" size="4" onchange="select_round(this.value,<?php print $i;?>)" value="<?php print $eachItem['round_helper']?>">
                              </div>
                            </div>
                          </div>
                          
                          <input type="hidden" name="items[sub_tot_cost][]" id="sub_tot_cost<?php print $i;?>"  class="sub_cs" value="<?php print $eachItem['sub_tot_cost']?>"/>
                          <input type="hidden" name="items[sub_tot_cost_change][]" id="sub_tot_cost_change<?php print $i;?>"  class="sub_cs_change"/>
                          <input type="hidden" name="items[sub_tot_sp][]" id="sub_tot_sp<?php print $i;?>"class="sub_sp" value="<?php print $eachItem['sub_tot_sp']?>"/>
                        </div>

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
				<?php $i++;} }?>
            </div> 
          </div>
		