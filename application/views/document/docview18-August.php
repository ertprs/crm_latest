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
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Off'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'On'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }


</style>
<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->
 
<div class="ciuis-body-content" ng-controller="Contact_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2>View Document</h2>
        <ul class="pull-right" style="margin-left:650px;">
     <!--  <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
               <md-tooltip md-direction="bottom"><?php //echo lang('update') ?></md-tooltip> 
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>

              <a href="<?php //echo site_url() ?>contacts/delete_contact/<?php //echo $task['person_id'] ?>"><i class="fa fa-trash"></i></a> -->
           <?php if (check_privilege('document', 'edit')){ ?> 
		<div class="col-sm-3" id="" onclick="update('<?php echo $result['document_id']; ?>')"><i class="ion-compose  text-muted"></i></div>
	 <?php } 
	  if(check_privilege('document', 'delete')){
	  ?>
		<div class="col-sm-3" id="" onclick="deletematerial('<?php echo $result['document_id']; ?>')"><i class="ion-trash-b text-muted"></i></div>
	 <?php  } ?>
        </ul></div>
    </md-toolbar>
    <md-content ng-show="!ticketsLoader" layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
     
     
<div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo 'Authorised Company Name:' ?></div>
          <div class="ticket-data" ng-bind="'<?php echo $result['company_name'] ?>'"></div>
        </div>
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo 'Email:' ?></div>
          <div class="ticket-data" ng-bind="'<?php echo $result['email']; ?>'"></div>
        </div>
      </div>
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Person')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $result['contact_person']; ?>'"></div>
        </div>
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Number')?></div>
	  
          <div class="ticket-data" ng-bind="'<?php echo $result['contact_number']; ?>'">></div>
	 
        </div>
      </div>
      
     

      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo 'Remarks' ?></div>
          <div class="ticket-data">
          <div class="ticket-data label-status" ng-bind="'<?php echo $result['remarks'] ?>'"></div>

          </div>
        </div>
        <div class="ciuis-ticket-fieldgroup">
            <div class="ticket-label"><?php echo 'Expiry Date' ?></div>
          <div class="ticket-data">
          <div class="ticket-data label-status" ng-bind="'<?php echo date("d-m-Y",strtotime($result['expiry_date'])); ?>'"></div>
        </div>
      </div>
      </div>
        
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Created Date')?></div>
          <div class="ticket-data" ng-bind="'<?php echo date("d-m-Y",strtotime($result['created'])); ?>'"></div>
        </div>
      </div>
    
      <?php
   // } ?> 
    </md-content>
    <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document" style="width: 400px;">
<div class="modal-content">

<div class="modal-body">

<div id="update_details"></div>
		   
		



</div>
</div>
</div>
</div>

      <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update" style="min-width: 450px;" ng-cloak>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('Update') ?></h2>
	
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding="">
	
		   <md-tabs md-dynamic-height md-border-bottom>
             
           <?php if($task['type'] == 'business') { ?>
	 <md-tab label="<?php echo lang('Business') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		  <form action="<?php echo base_url('contacts/updateb/'.$task['person_id'])?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
	  
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('company')?>*</label>
          <input  name="cname"  value="<?php echo $task["cname"];?> ">
        </md-input-container>
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail"  value="<?php echo $task["cname"];?> ">
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input  name="cperson" value="<?php echo $task["cperson"];?> ">
        </md-input-container>
        
	

      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea  name="keyword_content" rows="3"><?php echo $task['keyword_content'];?></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea  name="address" rows="3"><?php echo $task['address'];?></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="files[]" id="chooseFile" value="" multiple>
      </md-input-container>
     
      </div>

                  <div class="form-group col-md-12">
  <div class="field_wrapper row field_wrapper0">
    <?php if(!empty($contact_numbers)){$p=1;foreach($contact_numbers as $eachcontact){?>
	
	<div class="form-group col-md-9">
		
		
	  <!--
      <input id="phone" type="tel" name="number[]">-->
	  
<span id="valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
<span id="error-msg<?php print $p;?>" class="hide"></span>
 <input type="hidden" id="calling_code<?php print $p;?>" name="countrycode[]" value="<?php print $eachcontact['contact_country_code'];?>"/>
    <input type="tel" id="phone<?php print $p;?>" name="point_contact_number[]" value="<?php print '+'.$eachcontact['contact_country_code'].$eachcontact['contact_number'];?>">
	
	  
    
		</div>
	
       
<div class="form-group col-md-3">          <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div>

<script type="text/javascript">
	 setTimeout(function(){
	allshowtel('<?php print $p;?>');
	  },1000);
	</script>
	  <?php $p++;}}?>
	  
	  
     

    <div>
            </div>
</div>

<div class="form-group col-md-3">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
</div>

	   <button type="submit" class="btn btn-report" >Update</button>
	    </form>
    </md-content>
	</md-tab>
	<?php  } if($task['type'] == 'person') { ?>
	 <md-tab label="<?php echo lang('person') ?>">
		  <md-content class="bg-white" layout-padding ng-cloak>
		   <form action="<?php echo base_url('contacts/update/'.$task['person_id'])?>" method="post" id="formid" enctype="multipart/form-data">
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail"   value="<?php echo $task['cemail'];?>">
        </md-input-container>
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input name="cperson"  value="<?php echo $task['cperson'];?>">
        </md-input-container>
        
      </div> 

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('keyword / comment') ?></label>
          <textarea  name="keyword_content" rows="3"><?php echo $task['keyword_content'];?></textarea>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('address') ?></label>
          <textarea  name="address" rows="3"><?php echo $task['address'];?></textarea>
        </md-input-container>
      </div>
      
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php //echo lang('Upload file') ?></label>
      <input type="file" name="files[]" id="chooseFile" value="" multiple>

      </md-input-container>
     
      </div>

        <div class="form-group col-md-12">
  <div class="field_wrapper row field_wrapper1">
  <?php if(!empty($contact_numbers)){$p=1;foreach($contact_numbers as $eachcontact){?>
  <div class="form-group col-md-9">
  <span id="person_valid-msg<?php print $p;?>" class="hide">✓ Valid</span>
<span id="person_error-msg<?php print $p;?>" class="hide"></span>
 <input type="hidden" id="person_calling_code<?php print $p;?>" name="person_countrycode[]" value="<?php print $eachcontact['contact_country_code'];?>"/>
    <input type="tel" id="person_phone<?php print $p;?>" name="person_point_contact_number[]" value="<?php print '+'.$eachcontact['contact_country_code'].$eachcontact['contact_number'];?>">
	
      </div>  
<div class="form-group col-md-3">      <label for="inputZip"></label>     <a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div>
<script type="text/javascript">
	 setTimeout(function(){
	allshowtel1('<?php print $p;?>');
	  },1000);
	</script>
	  <?php $p++;}}?>
   
  
	
    <div>
            </div>
</div>
<div class="form-group col-md-3">
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button1" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div>
</div>

	  <button type="submit" class="btn btn-report" >Update</button>
	   </form>
    </md-content>
	</md-tab>
	<?php } ?>
	</md-tabs>
   
	       
    </md-content>
  </md-sidenav>

  </div>
   <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
   <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
          <md-icon><i class="ion-document text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('files') ?></h2>
<?php if (check_privilege('document', 'edit')) { ?> 
          <md-button ng-click="UploadFile()"  class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
        <?php } ?>
		
      </div>
	  
    </md-toolbar>
	
	
    <md-content class="bg-white" ng-show="projectFiles">
     
               <?php  $passport_doc = explode(",", $result["documents"]);  
         $ext = ''; 
           foreach ($passport_doc as $key => $pass_value) { ?>
           <ul>
          <div class="md-list-item-text image-preview">
        <?php
             //echo $pass_value;
              if($pass_value != '') {  
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1);  ?>
          <div class="row">
               <?php  if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){ ?>

		<a href='#about' onclick=show_post_pdf(<?php echo $pass_value; ?>) data-toggle='modal' data-image=<?php echo $pass_value; ?> id='editidpdf<?php echo $pass_value;?>'></a>
				<?php   }else{ ?>
				  <a class='btn btn-success' href='uploads/images/$pass_value'  target='_new'><i class='ion-clipboard'></i></a>
			<?php	    }
			   
			 }  else {  ?>
	      <a href='#about'  onclick=show_post(<?php echo $pass_value;?>) data-toggle='modal'  data-image=<?php echo $pass_value;?> id='editid<?php echo $pass_value;?>'></a>
             <?php   } ?> 
                <li><?php echo $pass_value;?>
	
           <!-- <a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name(<?php //echo $pass_value;?>,<?php //echo $result['document_id'] ?>);><span class="glyphicon glyphicon-remove"></span></a> -->
        
             <?php if (check_privilege('contacts', 'delete')) { ?> 
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          </li>
             </div>
             
             <?php
               
			     
			 } ?>
			 </div>
			 
     
        </ul><?php } ?>
        </div>
           
         
          <md-divider></md-divider>
        </md-list-item>
        
      </md-list>
      <div ng-show="files.length>6 && !projectFiles" class="pagination-div" ng-cloak>
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </md-content>
	 
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
<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('contacts/add_file/'.$task['person_id'].'',array("class"=>"form-horizontal")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="file_name" file-model="project_file">
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
    <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="view_image.html">
  <md-dialog aria-label="options dialog">
  <md-dialog-content layout-padding>
    <?php $path = '{{file.path}}';
    if ($path) { ?>
      <img src="<?php echo $path ?>">
    <?php } ?>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <?php if (check_privilege('contacts', 'delete')) { ?> 
      <md-button ng-click='DeleteFile(file.id)' aria-label="add"><?php echo lang('delete') ?>!</md-button>
    <?php } ?>
    <md-button ng-href="<?php echo base_url('contacts/download/') ?>{{file.id}}" aria-label="add"><?php echo lang('download') ?>!</md-button>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
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
  var TASKID = "<?php echo $task['person_id'];?>";
  var lang = {};
  lang.doIt = "<?php echo lang('doIt')?>";
  lang.cancel = "<?php echo lang('cancel')?>";
  lang.attention = "<?php echo lang('attention')?>";
  lang.delete_task = "<?php echo lang('delete_meesage').' '.lang('task')?>";
</script> 


<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/contacts.js') ?>"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
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
	
	
	
	
	function deletematerial(id){
             var r = confirm("Are you sure to delete the record");

	     if (r == true) {
	         	 $.ajax({
              url : "<?php echo base_url(); ?>document/delete_mat",
              data:{id : id},
              method:'POST',
              dataType:'json',
              success:function(response) {
             
               window.location.reload();
            }
          }); 
	     }
	     else{
	         
	        
	     }
        
    }
   
    function update(id){
        //alert(id);
               
           	 $.ajax({
              url : "<?php echo base_url(); ?>document/edit_mat",
              data:{id : id},
              method:'POST',
             // dataType:'json',
              success:function(response) {
                 // alert("dsafds");
                  //console.log(response)
                  $('#update_details').html(response);
               $("#sidebar-right").modal ("show");
                $('.selectpicker').selectpicker('refresh');
               
               
               
              
                $(function() {
           $( "#dialog-4" ).dialog({
               autoOpen: false, 
               modal: true,
               buttons: {
                  OK: function() {$(this).dialog("close");}
               },
            }); 
            $( "#opener-4" ).click(function() {
                //alert('sdsd00');
            //( "#dialog-4" ).dialog( "open" );
              $('#exampleModal2').modal('show');
              $("#exampleModal2").appendTo("body");
            });
         }); 
        var status = $('#switch').is(':checked');
        //alert(status);
        if(status == false){
            
              $("#item_code").prop("disabled", true);
              $("#item_code").removeAttr('required');
             $('.code').hide();
        
        }
        else{
            $('.code').show();
            $("#item_code").removeAttr('disabled');
             $('#item_code').attr('required', 'required');

        }
         function select_switch(){
                   
	   
    if ($('#switch').is(':checked')) {
        
       
         $('.code').show();
         $("#item_code").removeAttr('disabled');

          
    }else{
         
          $("#item_code").prop("disabled", true);
        $('.code').hide();
     
    }

    
} 
       var rd_status = $('#per').is(':checked');
       //alert(rd_status);
       if(rd_status == false){
             $('#percentage').hide();
        
        }
        else{
            $('#percentage').show();
        }
        
        
       var rd_status1 = $('#fix').is(':checked');
        //alert(rd_status1);
        if(rd_status1 == false){
             $('#fixed').hide();
        
        }
        else{
            $('#fixed').show();
        }
        
  	function change_margin(str){
	//	alert(str);
		
	}
	
  
   var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button1'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var val = $('#count').val();
   
   
    var x = val; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
             var fieldHTML = '<div class="row col-md-12" ><div class="form-group col-md-4"><label for="inputZip">Supplier</label>';
             fieldHTML += '<input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="supplier_hidden_id'+x+'" name="supp[newsupplier][]" id="supplier'+x+'" placeholder="Enter Supplier" autocomplete="off"/><input type="hidden" name="supp[supplier][]" id="supplier_hidden_id'+x+'" autocomplete="off" value=""/></div>';
            fieldHTML += '<div class="form-group col-md-4"><label for="exampleInputFile">Ref Code</label><input type="text" name="supp[shortname][]" placeholder="Enter Short Name" id="short-name" title="Short Name" aria-describedby="" class="form-control"></div>';
             fieldHTML +=  '<div class="form-group col-md-3"><label for="exampleInputFile">Price</label><input type="text" name="supp[price][]" placeholder="price" id="price" title="Price" aria-describedby="" class="form-control"></div><a href="javascript:void(0);" class="add_button" title="Add field"></a><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div><br>';
            //New input field html 
            $(wrapper).append(fieldHTML); //Add field html
			
				 $('#supplier'+x).typeahead({
           source: function (query, process) {
		
		
		$.ajax({
                    url: '<?php print base_url();?>supplier/get_supplier_list',
					data: 'str=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						if(data == '0'){
							//alert("fds");
							$('#supplier_hidden_id'+x).val('-1');
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
    matcher: function (item) {
    if (item.toLowerCase().indexOf(this.query.trim().toLowerCase()) != -1) {
    return true;
    }
    },
    sorter: function (items) {
        return items;//items.sort();
    },
    highlighter: function (item) {
        var regex = new RegExp( '(' + this.query + ')', 'gi' );
        return item.replace( regex, "<strong>$1</strong>" );
    },
    updater: function (item) {
      
        SelectedCode=map[item].id;
      
        SelectedCityName=map[item].name;
        
        // Get hidden field id from data-hidden-field-id attribute
        var hiddenFieldId = this.$element.data('hiddenFieldId')
        // Save SelectedCode to hiddenfield
        $(`#${hiddenFieldId}`).val(SelectedCode);
        
        return SelectedCityName;
    },
	
        });
			


			  
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        //e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
		return false;
        x--; //Decrement field counter
    });
         
            }
          });  
	    
    }
    
    
	</script> 