<?php $appconfig = get_appconfig(); ?>
<!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="<?php echo base_url('build/intel/css/prism.css'); ?>">
 <link rel="stylesheet" href="<?php echo base_url('build/css/intlTelInput.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('build/css/demo.css'); ?>">
    
      <link rel="stylesheet" href="<?php echo base_url('build/intel/css/isValidNumber.css'); ?>">
<div class="ciuis-body-content" ng-controller="Contact_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2>View Contact</h2>
        <ul class="pull-right" style="margin-left:650px;">
      <md-button ng-click="Update()" class="md-icon-button" aria-label="Update" ng-cloak >
                <md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
                <md-icon><i class="ion-compose  text-muted"></i></md-icon>
              </md-button>

              <a href="<?php echo site_url() ?>contacts/delete_contact/<?php echo $task['person_id'] ?>"><i class="fa fa-trash"></i></a>
          
        </ul></div>
    </md-toolbar>
    <md-content ng-show="!ticketsLoader" layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
      <?php if($task['type'] == 'person'){ ?>
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Company Email')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['cemail']; ?>'"></div>
        </div>
      
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Person')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['cperson']; ?>'"></div>
        </div>
        </div>
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Number')?></div>
	  <?php if(!empty($contact_numbers)){foreach($contact_numbers as $eachcontact){?>
          <div class="ticket-data" ng-bind="'+<?php echo $eachcontact['contact_country_code'] .' '. $eachcontact['contact_number']?>'"></div>
	  <?php }}?>
        </div>
      </div>
      
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Address')?></div>
          <div class="ticket-data">
          <div class="ticket-data label-status" ng-bind="'<?php echo $task['address'] ?>'"></div>

          </div>
        </div>
        <div class="ciuis-ticket-fieldgroup">

        </div>
      </div>
      
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Created Date')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['created']; ?>'"></div>
        </div>
      </div>

     
    <?php }else{
      ?>
<div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Company Name')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['cname'] ?>'"></div>
        </div>
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Company Email')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['cemail']; ?>'"></div>
        </div>
      </div>
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Person')?></div>
          <div class="ticket-data" ng-bind="'<?php echo $task['cperson']; ?>'"></div>
        </div>
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Contact Number')?></div>
	  <?php if(!empty($contact_numbers)){foreach($contact_numbers as $eachcontact){?>
          <div class="ticket-data" ng-bind="'+<?php echo $eachcontact['contact_country_code'] .'-'. $eachcontact['contact_number']?>'"></div>
	  <?php }}?>
        </div>
      </div>
      
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Address')?></div>
          <div class="ticket-data">
          <div class="ticket-data label-status" ng-bind="'<?php echo $task['address'] ?>'"></div>

          </div>
        </div>
        <div class="ciuis-ticket-fieldgroup">

        </div>
      </div>

      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Keyword / Content')?></div>
          <div class="ticket-data">
          <div class="ticket-data label-status" ng-bind="'<?php echo $task['keyword_content'] ?>'"></div>

          </div>
        </div>
        <div class="ciuis-ticket-fieldgroup">

        </div>
      </div>
      <div class="ciuis-ticket-row">
        <div class="ciuis-ticket-fieldgroup">
          <div class="ticket-label"><?php echo lang('Created Date')?></div>
          <div class="ticket-data" ng-bind="'<?php echo date("d-m-Y",strtotime($task['created'])); ?>'"></div>
        </div>
      </div>
    
      <?php
    } ?> 
    </md-content>

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
     
      </div>
      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input  name="cperson" value="<?php echo $task["cperson"];?> ">
        </md-input-container>
        
	

      </div>
      
       <div layout-gt-xs="row">
	  
       
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail"  value="<?php echo $task["cemail"];?> ">
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
          <label><?php echo lang('contact').' '.lang('person')?></label>
          <input name="cperson"  value="<?php echo $task['cperson'];?>">
        </md-input-container>
        
      </div> 
 <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
          <label><?php echo lang('email')?></label>
          <input  name="cemail"   value="<?php echo $task['cemail'];?>">
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
<?php if (check_privilege('contacts', 'edit')) { ?> 
          <md-button ng-click="UploadFile()"  class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
            <md-icon class="ion-android-add-circle text-success"></md-icon>
          </md-button>
        <?php } ?>
		
      </div>
	  
    </md-toolbar>
	
	 <div ng-show="projectFiles" layout-align="center center" class="text-center" id="circular_loader">
      <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
      <p style="font-size: 15px;margin-bottom: 5%;">
        <span><?php echo lang('please_wait') ?> <br>
        <small><strong><?php echo lang('loading'). ' Contact Fles...' ?></strong></small></span>
      </p>
    </div>
    <md-content class="bg-white" ng-show="!projectFiles">
      <md-list flex ng-cloak>
        <md-list-item class="md-2-line" ng-repeat="file in files | pagination : currentPage*itemsPerPage | limitTo: 6">
          <div class="md-list-item-text image-preview">
            <a ng-if="file.type == 'image'" class="cursor" ng-click="ViewFile($index, image)">
              <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="{{file.path}}">
            </a>
            <a ng-if="(file.type == 'archive')" class="cursor" ng-href="<?php echo base_url('contacts/download/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/zip_icon.png');?>">
            </a>
            <a ng-if="(file.type == 'file')" class="cursor" ng-href="<?php echo base_url('contacts/download/{{file.id}}');?>">
              <md-tooltip md-direction="left"><?php echo lang('download') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/file_icon.png');?>">
            </a>
            <a ng-if="file.type == 'pdf'" class="cursor" ng-click="ViewPdfFile($index, image)">
			
             <md-tooltip md-direction="left"><?php echo lang('preview') ?></md-tooltip>
              <img src="<?php echo base_url('assets/img/pdf_icon.png');?>">
            </a>
          </div>
          <div class="md-list-item-text">
            <a class="cursor" ng-href="<?php echo base_url('contacts/download/{{file.id}}');?>">
              <h3 class="link" ng-bind="file.file_name"></h3>
            </a>
          </div>
          <?php if (check_privilege('contacts', 'delete')) { ?> 
            <md-icon  ng-click='DeleteFile(file.id)' class="ion-trash-b cursor"></md-icon>
          <?php } ?>
          <md-divider></md-divider>
        </md-list-item>
        <div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
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
  <?php echo form_open_multipart('contacts/add_file/'.$task['person_id'].'',array("class"=>"form-horizontal","enctype"=>"multipart/form-data","method"=>"post")); ?>
  <md-dialog-content layout-padding>
    <h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
    <input type="file" required name="file_name[]" file-model="project_file" multiple>
  </md-dialog-content>
  <md-dialog-actions>
    <span flex></span>
    <md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
	 <button type="submit" class="btn btn-report" ng-disabled="uploading == true">
			<span ng-hide="uploading == true"><?php echo lang('upload');?></span>
			<md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</button>
   <!--- <md-button ng-click="uploadProjectFile()" class="template-button" ng-disabled="uploading == true">
      <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
      <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
    </md-button>--->
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
	</script> 