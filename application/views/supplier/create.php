<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<style>
.ck-editor__editable_inline{
	height:200px;
}
</style>
<div class="ciuis-body-content" ng-controller="Supplier_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
    <md-toolbar class="toolbar-white" ng-cloak>
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('newsupplier') ?></h2>
      
      </div>
    </md-toolbar>
    <div ng-show="invoiceLoader" layout-align="center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
         <span>
            <?php echo lang('please_wait') ?> <br>
           <small><strong><?php echo lang('loading').'...' ?></strong></small>
         </span>
       </p>
    </div>
    <md-content ng-show="!invoiceLoader" class="bg-white" layout-padding ng-cloak>
	 <form id="form1" method="post" action="<?php print base_url()?>supplier/create" >
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="companyname"><b>Company Full Name</b></label>
      <input type="text" class="form-control required" required id="companyname" placeholder="Company Full Name" name="companyname">
    </div>
	
    <div class="form-group col-md-6">
      <label for="status">Status</label>
     <select id="status" class="form-control required" required name="status">
        <option value="">Choose...</option>
        <option>Active</option>
		<option>Black Listed</option>
      </select>
    </div>
  </div>
  <div class="form-group col-md-12">
    <label for="company_address">Company Address</label>
    <textarea type="text" class="form-control required" required id="company_address" placeholder="Company Address" name="company_address"></textarea>
  </div>
 
  <div class="form-row">
   <div class="form-group col-md-4">
    <label for="contact_number_office">Contact Number Office</label>
    <input type="text" class="form-control required" required id="contact_number_office" placeholder="Contact Number Office" name="contact_number_office">
  </div>
    <div class="form-group col-md-4">
      <label for="inputCity">Contact Person (Accounts)</label>
      <input type="text" class="form-control" id="account_contact_number" placeholder="Contact Person (Accounts)" name="account_contact_number">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">email address</label>
      <input type="text" class="form-control" id="emailaddress" placeholder="email" name="emailaddress"> 
    </div>
    
  </div>
   <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputZip">Mobile Number</label>
      <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number" name="mobile_number">
    </div>
    <div class="form-group col-md-4">
      <label for="inputCity">Website</label>
      <input type="text" class="form-control" id="website" placeholder="Website" name="website">
    </div>
    <div class="form-group col-md-4">
      <label for="">Country</label>
       <md-input-container class="md-block">
          <label><?php echo lang('country'); ?></label>
          <md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id" ng-change="getStates(customer.country_id)" name="country_id" style="min-width: 200px;">
            <md-option ng-value="country.id" ng-repeat="country in countries" >{{country.shortname}}</md-option>
          </md-select>
        </md-input-container>
    </div>
    
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputZip">Trade Licence No.</label>
      <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no">
    </div>
    <div class="form-group col-md-6">
      <label for="inputCity">TAX Registration No</label>
      <input type="text" class="form-control" id="tax_registration" placeholder="TAX Registration No" name="tax_registration">
    </div>
   
    
  </div>
<div class="form-group col-md-12">

    <label for="inputAddress">Trade Licence Documents</label>
  <input type="file" multiple class="form-control" id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-3"></div>
  <div id="image_preview" class="col-md-12"></div> 
  </div>
<div class="form-group col-md-12">
    <label for="inputAddress">Tax Registration Documents</label>
    <input type="file" multiple class="form-control">
  </div>
  <div class="form-group col-md-12">
    <label for="inputAddress">Documents of Owner</label>
     <input type="file" multiple class="form-control">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="creditperiod">Credit Period</label>
      <input type="number" class="form-control required" required id="creditperiod" placeholder="Credit Period" name="creditperiod">
    </div>
    <div class="form-group col-md-6">
      <label for="creditlimit">Credit Limit</label>
      <input type="text" class="form-control required" required id="creditlimit" placeholder="Credit Limit" name="creditlimit">
    </div>
   <div class="form-group col-md-12">
    <label for="inputAddress">Terms And Conditions</label>
    <textarea type="text" class="form-control" id="terms_and_conditions" placeholder="Terms And Conditions" name="terms_and_conditions"></textarea>
  </div>
  <div class="form-group col-md-12">
    <label for="inputAddress">Notes</label>
    <textarea type="text" class="form-control" id="notes" placeholder="Notes" name="notes"></textarea>
  </div>
    
  </div>
  <div class="form-group col-md-12">
  <h2>Point of Contacts</h2>
  <div class="field_wrapper">
  <div class="form-group col-md-4">
      <label for="inputZip">Contact Name</label>
      <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]">
    </div>
	<div class="form-group col-md-4">
      <label for="inputZip">Contact Number</label>
      <input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">
    </div>
	<div class="form-group col-md-3">
      <label for="inputZip">Email</label>
      <input type="text" class="form-control" id="point_contact_email" placeholder="Email"  name="point_contact_email[]">
    </div>
	<div class="form-group col-md-1">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
    <div>
            </div>
</div>
</div>
<input class=" btn btn-success" type="submit" value="Create">
  
</form>
     
     
    </md-content>

  </div>
 
</div>
<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/supplier.js'); ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
 <script>
  
        ClassicEditor
            .create( document.querySelector( '#company_address' ) )
            .catch( error => {
                console.error( error );
            } );
			ClassicEditor
            .create( document.querySelector( '#terms_and_conditions' ) )
            .catch( error => {
                console.error( error );
            } );
			
			ClassicEditor
            .create( document.querySelector( '#notes' ) )
            .catch( error => {
                console.error( error );
            } );
			
			$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = ' <div class="form-group col-md-4">   <label for="inputZip">Contact Name</label>     <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]"> </div>	<div class="form-group col-md-4">      <label for="inputZip">Contact Number</label><input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]">    </div>	<div class="form-group col-md-3">      <label for="inputZip">Email</label>      <input type="text" class="form-control" id="point_contact_email" placeholder="Email" name="point_contact_email[]">    </div>	<div class="form-group col-md-1">      <label for="inputZip"></label>      <a href="javascript:void(0);" class="add_button" title="Add field"><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></a>    </div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

function preview_image() 
{



 var total_file=document.getElementById("upload_file").files.length;

 for(var i=0;i<total_file;i++)
 {
 //console.log(event.target.files[i]['name']);
 //$('.loder').html('<img src="<?php print base_url();?>front/LoaderIcon.gif">');
 var file_data = event.target.files[i];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
		
  $.ajax({
            url: '<?php print base_url();?>supplier/form_add_image',
			 type        : 'post',
            cache       : false,
        contentType : false,
        processData : false,
        data        : form_data,
            success: function(response){
                if(response != 0){
					if(response.error){
					$('.error').show();
					$('.error').html(response.error);
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					}else{
					//$('.loder').html('');
                    //$("#img").attr("src",response); 
                    //$(".preview img").show(); // Display image element
					$('input[name="csrf_test_name"]').val(response.csrf_hash);
					$('#image_preview').append("<div class='col-md-3' id='clients-edit-wrapper'><div class='close-wrapper'> <a  class='close-div'>Delete</a></div><input type='hidden' name='test_image[]' value='"+response.image_name+"'><img src='<?php print base_url();?>uploads/images/"+response.image_name+"' width='200' height='200' ></div>");
					}
                }else{
                    alert('file not uploaded');
                }
            },
        });
  
 
 }
}
$(document).on('click', '.close-div', function(){
	
    $(this).closest("#clients-edit-wrapper").remove();
});
    </script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
  <style>
   .error{ color:red; } 
   .cmxform fieldset p label span.error { color: red; }
form.cmxform { width: 30em; }
form.cmxform label {
	width: auto;
	display: block;
	float: none;
}
  </style>
  <script>
  // only for demo purposes
$.validator.setDefaults({
	submitHandler: function() {
		$('#form1').submit();
	}
});
  var validator = $("#form1").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
		messages: {
			companyname: {
				required: " (required)",
				minlength: " (must be at least 3 characters)"
			},
			contact_number_office: {
				required: " (required)"
			},
			status: {
				required: " (required)"
			},
			creditperiod: {
				required: " (required)"
			},
			creditlimit: {
				required: " (required)"
			},
			password: {
				required: " (required)",
				minlength: " (must be between 5 and 12 characters)",
				maxlength: " (must be between 5 and 12 characters)"
			}
		}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
	
  </script>