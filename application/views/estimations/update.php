<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
   
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">   
          <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
            <md-icon>
              <i class="ico-ciuis-proposals text-white">
              </i>
            </md-icon>
          </md-button>
          <h2 flex md-truncate>
           Update Estimations
          </h2>
        
          <button type="button"  class="btn btn-sm btn-success" id="formsubmit">
            Update
            </i>
          </button>
		   <md-menu md-position-mode="target-right target">
            <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
              <md-icon><i class="ion-android-more-vertical text-white"></i></md-icon>
            </md-button>
            <md-menu-content width="4">

                           <md-menu-item>
						 
                  <md-button >
				    <a href="" onclick="check_duplicate_name();">
                    <div layout="row" flex>
                      <p flex > Duplicate</p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-proposals" style="margin: auto 3px auto 0;"></md-icon>
                    </div>
					</a>
                  </md-button>
                </md-menu-item>
                <md-divider></md-divider>
				               
                <md-divider></md-divider>
				<div  class="approvalModel">
				 <md-menu-item>
                  <md-button  >
                    <div layout="row" flex>
					<a href="<?php print base_url()?>estimations/markas_approval/<?php print $updateid;?>">
                      <p flex>Proceed For Approval</p>
                      <md-icon md-menu-align-target class="icon ico-ciuis-proposals" style="margin: auto 3px auto 0;"></md-icon>
					  </a>
                    </div>
                  </md-button>
				</div>
                </md-menu-item>
                <md-divider></md-divider>
          </md-menu-content>
        </md-menu>
		 
        </div>
      </md-toolbar>
	  
	   <form  action="<?php echo base_url('estimations/update/'.$updateid.'') ?>" method="post" enctype="multipart/form-data" id="updateForm">
      <md-content class="bg-white layout-padding _md flow-unset" >
        <div layout-gt-xs="row">
          <md-input-container class="md-block" flex-gt-sm>
            <input  name="estimation_project_name" id="estimation_project_name" id="estimation_project_name" class="form-control" placeholder="Enter Estimation Project Name" required="" value="<?php print $proposal['project_name']; ?>">
			<input type="hidden" name="estimation_project_id" id="estimation_project_id" value="<?php print $proposal['estimation_id']; ?>">
          </md-input-container>
		   <span id="email_result"></span>
        </div>
        <div layout-gt-xs="row">
          <div class="col-sm-6">
		  
             <select class="form-control client selectpicker" data-live-search="true" name="client_id" id="client_id" required="">              <option value="">Search or Add Customer              </option>              <?php foreach($customers as $eachcustomer){ if($eachcustomer['company'] != '') { ?>              <option value="<?php echo $eachcustomer['id'];?>" <?php if($eachcustomer['id']==$proposal['customer_id']){print "selected='selected'";}?>>                <?php echo $eachcustomer['company']; ?>              </option>              <?php }  } ?>            </select>
          </div> 
          <div class="col-sm-6">
           <div id="client_contact_id">            <select class="form-control selectpicker contact" data-live-search="true" name="client_contact_id" id="client_contact_id" required="">             <option value="">Select Customer First              </option>			  <?php foreach($customer_contact as $k => $val){					if($val['id'] != '') {				?><option value="<?php print $val['id'];?>" <?php if($val['id']==$proposal['customer_contact_id']){print "selected='selected'";}?>><?php print $val['name'];?></option><?php 										}									} ?>            </select>			</div>
          </div> 
        </div>
        <div layout-gt-xs="row">
          <div class="col-sm-6">
            <div id="salesteam">            <select  class="form-control selectpicker" required name="salesteam"  placeholder="Select Project Salesteam">              <option value="">Select Sales Team              </option>              <?php foreach($supplier_details as $eachsupp){		$sres = $this->Staff_Model->get_staff($eachsupp);		if($sres['id'] != '') {?><option value="<?php print $sres['id'];?>" <?php if($sres['id']==$proposal['salesteam']){print "selected='selected'";}?> ><?php print $sres['staffname'];?></option><?php 															}			}?>            </select>			</div>
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
        <?php $this->load->view('estimations/update_details');?>

        
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
          <textarea type="text" class="form-control" id="special_notes" placeholder="" name="special_notes" rows="30" cols="30"><?php print $proposal['special_notes']; ?>
          </textarea>
        </div>
        <div class="form-group ">
          <md-toolbar class="toolbar-white _md _md-toolbar-transitions">
            <div class="md-toolbar-tools">
              <h2 flex="" md-truncate="" class="md-truncate flex">Status
              </h2>
            </div>
          </md-toolbar>
          <select id="estimatestatus" class="form-control" required="" name="estimatestatus" placeholder="Select Status">
            <option value="Approved" <?php if($proposal['estimate_status']=='Approved'){print "selected='selected'";} ?>>Approved
            </option>
            <option value="Draft" <?php if($proposal['estimate_status']=='Draft'){print "selected='selected'";} ?>>Draft
            </option>
            <option value="Missing Info" <?php if($proposal['estimate_status']=='Missing Info'){print "selected='selected'";} ?>>Missing Info
            </option>
            <option value="Under Approval" <?php if($proposal['estimate_status']=='Under Approval'){print "selected='selected'";} ?>>Under Approval
            </option>
            <option value="Declined" <?php if($proposal['estimate_status']=='Declined'){print "selected='selected'";} ?>>Declined
            </option>
            <option value="Approved" <?php if($proposal['estimate_status']=='Approved'){print "selected='selected'";} ?>>Approved
            </option>
          </select>
        </div>
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
    
    </md-content>
	</form>
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
$("#formsubmit").click(function(){        
        $("#updateForm").submit(); // Submit the form
    });
  ClassicEditor
    .create( document.querySelector( '#special_notes' ) )
    .catch( error => {
    console.error( error );
  }
          );
</script>

