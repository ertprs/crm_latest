<style>
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
	
    .pen body {
	padding-top:50px;
}




/* Social Buttons - Twitter, Facebook, Google Plus */
.btn-twitter {
	background: #00acee;
	color: #fff
}
.btn-twitter:link, .btn-twitter:visited {
	color: #fff
}
.btn-twitter:active, .btn-twitter:hover {
	background: #0087bd;
	color: #fff
}

.btn-instagram {
	color:#fff;
	background-color:#3f729b;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:focus,.btn-instagram.focus {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}
.btn-instagram:hover {
	color:#fff;
	background-color:#305777;
	border-color:rgba(0,0,0,0.2);
}

.btn-github {
	color:#fff;
	background-color:#444;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:focus,.btn-github.focus {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}
.btn-github:hover {
	color:#fff;
	background-color:#2b2b2b;
	border-color:rgba(0,0,0,0.2);
}

/* MODAL FADE LEFT RIGHT BOTTOM */
.modal.fade:not(.in).left .modal-dialog {
	-webkit-transform: translate3d(-25%, 0, 0);
	transform: translate3d(-25%, 0, 0);
}
.modal.fade:not(.in).right .modal-dialog {
	-webkit-transform: translate3d(25%, 0, 0);
	transform: translate3d(25%, 0, 0);
}
.modal.fade:not(.in).bottom .modal-dialog {
	-webkit-transform: translate3d(0, 25%, 0);
	transform: translate3d(0, 25%, 0);
}

.modal.right .modal-dialog {
	position:absolute;
	top:0;
	right:0;
	margin:0;
}

.modal.left .modal-dialog {
	position:absolute;
	top:0;
	left:0;
	margin:0;
}

.modal.left .modal-dialog.modal-sm {
	max-width:300px;
}

.modal.left .modal-content, .modal.right .modal-content {
    min-height:100vh;
	border:0;
}

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Project'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'Warehouse'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }



</style>
<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->
 <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
<div class="ciuis-body-content" ng-controller="Inventory_Controller" >
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<div class="col-sm-11">
				    <span style="font-size: 16px;"></span><br>
					<span style="font-size: 19px;" ><b><?php echo $result['inventory_number'] ?>&nbsp;&nbsp;<?php echo $result['product_name'];?></b></span>
				
				</div>
				 <md-button aria-label="Convert" class="md-icon-button" onclick="select_project(<?php echo $result['inv_id'];?>)" ng-cloak>
            <md-icon><i class="ion-loop text-success"></i></md-icon>
          </md-button>
					<?php	if(check_privilege('inventories', 'delete')){
					?>
				<md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
						<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip> 
						<md-icon><i class="ion-compose  text-muted"></i></md-icon>
				</md-button>
				<?php  } ?>
			<!--	<a href="<?php //echo site_url() ?>contacts/delete_contact/<?php //echo $task['person_id'] ?>"><i class="fa fa-trash"></i></a> -->
				 
				<?php	if(check_privilege('inventories', 'delete')){
					?>
						<span  id="" onclick="deleteinventory('<?php echo $result['inv_id']; ?>')" class="cursor"><i class="ion-trash-b text-muted"></i></span>
					<?php  } ?>
				
			</div>
		</md-toolbar>
		<md-content layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
		<md-list flex class="md-p-0 sm-p-0 lg-p-0">
					<?php //echo "<pre>";
					//print_r($customers);?>
				
			<md-list-item>
									<md-icon class="ion-pricetags icon material-icons"></md-icon>
									<p><?php echo 'Cost Price'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['cost']; ?></p>
					</md-list-item>
					<md-divider></md-divider>
					<md-list-item>
									<md-icon class="mdi mdi-balance material-icons"></md-icon>
									<p><?php echo 'Warehouse'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['warehouse_name']; ?></p>
					</md-list-item>
					<md-divider></md-divider>
					<md-list-item>
									<md-icon class="mdi mdi-book material-icons"></md-icon>
									<p><?php echo 'In Stock'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($result['stock']-$tot_qty); ?></p>
					</md-list-item>
					<md-divider></md-divider>
					<md-list-item>
									<md-icon class="ion-ios-barcode-outline material-icons"></md-icon>
									<p><?php echo 'Move Type'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['move_name']; ?></p>
					</md-list-item>
					<md-divider></md-divider>
						<md-list-item>
									<md-icon class="ion-ios-bookmarks-outline material-icons"></md-icon>
									<p><?php echo 'Notes'; ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['notes']; ?></p>
					</md-list-item>
					<md-divider></md-divider>
				</md-list>
			
			
			
			
			<?php // } ?> 
		</md-content>
	
      <md-table-container >
        <table md-table md-progress="promise">
          <thead md-head md-order="contactsList.order">
            <tr md-row>
			
              <th md-column><span><?php echo 'S.No'; ?></span></th>
              <th md-column><span><?php echo 'Type'; ?></span></th>
              <th md-column><span><?php echo 'Name'; ?></span></th>
              <th md-column><span><?php echo 'Qty'; ?></span></th>
              <th md-column><span><?php echo 'Staff Name'; ?></span></th>
              
            </tr>
          </thead>
			   
             <tbody md-body>
      <?php if(!empty($itemresult)) {
      $k = 1;
      foreach($itemresult as $res) { ?>

 <tr class="select_row" md-row  class="cursor" >
			 <td md-cell  style="width:40px;">
			     <?php echo $k;?>
			 </td>
			 <td md-cell style="width:90px;">
			     <?php echo $res['project_type'];?>
			 </td>
			  <td md-cell  style="width:190px;">
			     <?php if($res['project_type'] == 'warehouse'){  echo $res['warehouse_name']; } else {  echo $res['name']; } ?>
			 </td>
			  <td md-cell  style="width:90px;">
			     <?php echo $res['qty'];?>
			 </td>
			  <td md-cell  style="width:90px;">
			     <?php echo $res['staffname'];?>
			 </td>
</tr>
	
    
      <?php $k++; }  } ?>
      	
  
   </tbody>
		 
        </table>
      </md-table-container>
  
		<div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-body">
						<div id="update_details"></div>		  
					</div>
				</div>
			</div>
		</div>
		<!---Start Update Document modal----->
		<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
		     <form id="form1" method="post" action="<?php echo base_url('inventories/update');?>">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
					<h2 flex md-truncate><?php echo lang('Update') ?></h2>
				</div>
			</md-toolbar>
			<md-content layout-padding="">
			
   <md-content layout-padding>
       <input type="hidden" name="inv_id" id="inv_id" value="<?php echo $result['inv_id'];?>"  />
       <div class="form-group">
           <label>Category</label>
           <select class="form-control" name="category" id="category" style="border-radius:0px" disabled>
               <option value="1" <?php if($result['category'] == '1') { echo "selected='selected'"; } ?>>Materials</option>
               <option value="2" <?php if($result['category'] == '2') { echo "selected='selected'"; } ?>>Client Unit Storage</option>
           </select>
       </div>
				
				 <md-input-container class="md-block">
				<input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="product_name" name="product_name" id="product_name" placeholder="MATERIAL / SERVICE NAME" autocomplete="off" value="<?php echo $result['product_name'];?>" readonly >
				
		  <input type="hidden" name="service_name" id="service_name" autocomplete="off"  class="service"  value="<?php echo $result['service_name'];?>" />
		   </md-input-container>
		   
		<?php if($result['category'] == 1){ ?>
		  <div class="form-group" >
		  <label>Unit Type</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_unit_type" id="inv_unit_type" style="border-radius:0px" disabled>
		  <?php  if(isset($unittypes)) { 
		
		  foreach($unittypes as $pc) { 
		       $selected = '';
		  if($pc['unit_type_id'] == $result['inv_unit_type']) {
		  
		     $selected = "selected";
		  } ?>
		  <option value="<?php echo  $pc['unit_type_id'];?>"<?php echo $selected;?>><?php echo $pc['unit_name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		  <?php } ?>
		  	<div class="form-group" id="supp" style="display:none">
		  <label>Suppliers</label>
<select class="form-control" name="supplier_id" id="supplier_id" style="border-radius:0px" >
    <option value='0'>Select New Supplier</option>
</select>

				</div>
				<?php if($result['customer_id'] == 0){ ?>
				<div class="form-group" id="all_supp" >
				     <label>Suppliers</label>
		  <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="supp_id" name="supp_id" id="supp_id" placeholder="SUPPLIER" autocomplete="off"  style="border-radius:0px" value="<?php echo $result['company'];?>" readonly>
				
		  <input type="hidden" name="supplier_id" id="supplier_id1" autocomplete="off" value="" class="supplier_id"/>
		  
		 </div>
		 <?php } else { ?>
		 	<div class="form-group" id="all_cust">
				     <label>Customers</label>
		  <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="cust_id" name="cust_id" id="cust_id" placeholder="CUSTOMER" autocomplete="off"  style="border-radius:0px" value="<?php echo $result['customer_name'];?>" readonly>
				
		  <input type="hidden" name=customer_id" id="customer_id" autocomplete="off" value="" class="customer_id"/>
		  
		 </div>
		 <?php } ?>
		 <div class="form-group" id="cost_price">
		  <label>Cost Price
<input list="costs" name="cost" class="form-control" style="border-radius:0px" size="50"autocomplete="off" value="<?php echo $result['cost'];?>"/></label>
<datalist id="costs">
  <option value=""></option>
</datalist>
				</div>
			
			
		<div class="form-group" >
		  <label>Warehouse</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_warehouse" id="inv_warehouse" style="border-radius:0px">
		  <?php  if(isset($warehouses)) { 
		 
		  foreach($warehouses as $wh) { 
		  
		  $selected = ''; 
		  
		  if($wh['warehouse_id'] == $result['inv_warehouse']) {
		  
		  $selected = 'selected';
		  } ?>
		  
		  <option value="<?php echo  $wh['warehouse_id'];?>"<?php echo $selected;?>><?php echo $wh['warehouse_name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		 
		  <md-input-container class="md-block">
				<label>Stock Qty()</label>
				<input type="text"  name="stock" id="stock" class="form-control" placeholder="Stock Qty" value="<?php echo $result['stock'];?>"> 
				</md-input-container>
				
		  <div class="form-group" >
		  <label>Move Type</label>&nbsp;&nbsp;
		  <select  class="form-control" name="inv_move_type" id="inv_move_type" style="border-radius:0px">
		  <?php  if(isset($move_types)) { 
		 
		  foreach($move_types as $mv) { 
		  $selected = '';
		  if($mv['id'] == $result['inv_move_type']) { 
		   $selected = 'selected';   
		  }
		  ?>
		  <option value="<?php echo  $mv['id'];?>"<?php echo $selected;?>><?php echo $mv['name'];?></option>
		  <?php } 
		  }?>
		  </select>
		  </div>
		  <div class="form-group">
		      <label>Notes</label>
		     <textarea  name="notes" id="notes"  class="form-control" style="border-radius:0px" placeholder="Enter Here"><?php echo $result['notes'];?></textarea>
		  </div>
				<!--
				<md-input-container class="md-block">
					<label>Notes</label>
					<textarea ng-model="vendor.notes" name="notes" md-maxlength="500" rows="3" md-select-on-focus></textarea>
				</md-input-container>
				-->
				
				<!-- <p id="vendorsError" style="color: red"></p>
				<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
					<md-button ng-click="AddVendor()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
						<span ng-hide="saving == true"><?php //echo lang('add');?></span>
						<md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
					</md-button>
					<br/><br/><br/><br/>
				</section> -->
				 <input type="submit" class="btn btn-success col-md-12"  value="Update">
				</form>
			</md-content>

	       
    </md-content>
  </md-sidenav>

  </div>
   <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
   <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
         
        </md-button>
        <h2 flex md-truncate><?php //echo lang('files') ?></h2>

		
      </div>
	  
    </md-toolbar>
	
	
   	 
   </div> 
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h5>
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
	  <div id="material_details"></div>
      
      </div>
     
    </div>
  </div>
</div>

<div class="container">
  <!-- Trigger the modal with a button -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-body">
          
			<iframe src="" id="imagepdf" style="width:100%;height:440px;"></iframe>
       
        <div class="modal-footer">
           <div id="buttons" class='col-md-9'></div>
        <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">CANCEL</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<script>
function getExtension(filename) {
    return filename.split('.').pop().toLowerCase();
}
function showmodal(id)
{
	var img=$('#filename'+id+'').val();
	
switch(getExtension(img)) {
        //if .jpg/.gif/.png do something
        case 'jpg': case 'gif': case 'png':
            /* handle */
			$('#imgbox').show();
			$('#pdfframe').hide();
			$('#imgbox').attr("src",img);
			
            break;
        //if .zip/.rar do something else
        case 'zip': case 'rar':
            /* handle */
            break;

        //if .pdf do something else
        case 'pdf':
            /* handle */
			$('#imgbox').hide();
			$('#pdfframe').show();
			
			$('#pdfframe').attr("src",img);
            break;
    }
	$('#myModal').modal("show");
}
  var VENDORRID = "<?php echo $result['inv_id'];?>";

  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_task = "<?php echo lang('delete_meesage').' '.lang('task')?>";
</script> 


<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<!-- Loader Css -->

<script src="<?php echo base_url('assets/js/inventories.js'); ?>"></script>
<!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/bootstrap-datepicker.min.css'); ?>">
  <!-- datepicker -->
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo base_url('assets/select2/select2.min.js'); ?>"></script>
<!----<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>--->
<script>
	
     $(document).ready(function(){
		 
	   var x = <?php print count($contact_numbers);?>; //Initial field counter is 1
	   
    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper0'); //Input field wrapper
	var wrapper1 = $('.field_wrapper1');
	var addButton1=$('.add_button1'); 
   // var fieldHTML = ' <div class="form-group col-md-4">   <label for="inputZip"> Country Code</label><select name="countrycode[]" style="width: 85px; height: 46px;"> <option value="971">ARE +971</option><?php foreach($countries as $country) { ?> <option value="<?php echo $country["phonecode"]; ?>"><?php echo $country["iso3"] ." +". $country["phonecode"]; ?></option> <?php } ?></select> </div><div class="form-group col-md-5" style = ""> <label for="inputZip"> Contact Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>  <div class="form-group col-md-3">      <label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div><br>'; //New input field html 
 
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="valid-msg'+x+'" class="hide">✓ Valid</span><span id="error-msg'+x+'" class="hide"></span> <input type="hidden" id="calling_code'+x+'" name="countrycode[]"/>    <input type="tel" id="phone'+x+'" name="point_contact_number[]"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper).append(fieldHTML); //Add field html
	
	allshowtel(x);
	
			//allshowtel(x);
        }
    });
	
	
	 $(addButton1).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
			
     var fieldHTML = '<div class="form-group col-md-9">   <span id="person_valid-msg'+x+'" class="hide">✓ Valid</span><span id="person_error-msg'+x+'" class="hide"></span> <input type="hidden" id="person_calling_code'+x+'" name="person_countrycode[]"/>    <input type="tel" id="person_phone'+x+'" name="person_point_contact_number[]"></div><div class="form-group col-md-3">        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a>   </div><br>';
	  $(wrapper1).append(fieldHTML); //Add field html
	 
	allshowtel1(x);
	  
			//allshowtel(x);
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
	
	$(wrapper1).on('click', '.remove_button', function(e){
        e.preventDefault();
                $(this).closest('.form-group').prev().remove();
$(this).closest('.form-group').prev().remove();
        $(this).parent('div').remove(); //Remove field html
        //x--; //Decrement field counter
    });
});


</script>

	 <script src="<?php echo base_url('build/intel/js/prism.js'); ?>"></script>
	   <script src="<?php echo base_url('build/js/intlTelInput.js'); ?>"></script>
    <script src="<?php //echo base_url('build/intel/js/isValidNumber.js'); ?>"></script>
	
	 <script>
	function allshowtel(str){
		
		var input = document.querySelector("#phone"+str+""),
  errorMsg = document.querySelector("#error-msg"+str+""),
  validMsg = document.querySelector("#valid-msg"+str+"");
  
//  var country = $('#country'+str+'');




// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	separateDialCode : true, 
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
//console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
  //alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
  $('#calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	
	
	function allshowtel1(str){
		
		var input = document.querySelector("#person_phone"+str+""),
  errorMsg = document.querySelector("#person_error-msg"+str+""),
  validMsg = document.querySelector("#person_valid-msg"+str+"");
  
  

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
	 separateDialCode : true, 
  utilsScript: ""+BASE_URL+"build/js/utils.js?1590403638580"
});
var countryData = iti.getSelectedCountryData();
//console.log(countryData);
input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
 
  //alert(iti.getSelectedCountryData().dialCode);
  var diacode=iti.getSelectedCountryData().dialCode;
  $('#person_calling_code'+str+'').val(diacode);
});


var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
	}
	
	
	
	
	function deleteinventory(id){
             var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>inventories/delete_inventory",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
				window.location.href="<?php echo base_url(); ?>inventories"
               
            }
          }); 
	     }
	     else{
	         
	        
	     }
        
    }
    
    
   function select_project(id)
   {
	  $.ajax({
            url: '<?php print base_url();?>inventories/view_details/'+id,
			 type        : 'post',
            cache       : false,
        contentType : true,
        processData : true,
        
            success: function(response){
				$('#material_details').html(response);
				$('#exampleModal1').modal('show');
				 $("#exampleModal1").appendTo("body");
			}
			
	  })
				 
				 
		
   }
   
    function update(id){
        //alert(id);
               
           	 $.ajax({
              url : "<?php echo base_url(); ?>inventories/edit_inv",
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                  //console.log(response)
                  $('#update_details').html(response);
               $("#sidebar-right").modal ("show");
                
               
               
               
              
           
         }
        
    
          });  
	    
    };
    
    
	</script> 