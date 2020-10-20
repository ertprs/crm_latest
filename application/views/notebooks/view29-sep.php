<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<!--box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;-->
<style>

 
.centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
    
}
.mb50{ margin-bottom: 30px; }
.mb10{ margin-bottom: 10px; }
.ck-editor__editable {
    min-height: 200px;
}
.nav-item .nav-link{ text-align: left;}
.nav-title { margin-right: 20px; }
	.tab-content{ padding:10px 0 !important; }
	.files{  border-left:1px solid #CCC; min-height: 250px }
	.files_list{  margin-bottom: 10px;  border: 1px solid #ffbc00; padding:10px; font-size: 16px; }
	.files_list a{ color : #ffbc00; }
	

.ui-autocomplete {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 160px;
  padding: 5px 0;
  margin: 2px 0 0;
  list-style: none;
  text-align: left;
  background-color: #ffffff;
  border: 1px solid #cccccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-clip: padding-box;
}

.ui-autocomplete > li > div {
  display: block;
  padding: 3px 20px;
  clear: both;
  line-height: 1.42857143;
  color: #333333;
  white-space: nowrap;
}

.ui-state-hover,
.ui-state-active,
.ui-state-focus {
  text-decoration: none;
  color: #262626;
  background-color: #f5f5f5;
  cursor: pointer;
}

.ui-helper-hidden-accessible {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}
.md-errors-spacer{
	min-width: 0px !important;
}
.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 24px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'Private'; position: absolute; top: 3px; left: 35px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'Public'; position: absolute; top: 2px; left: 10px; width: 26px; height: 26px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 8px 0 10px 0; }


</style>
<?php //print_r($notebooks); die; ?>
<div class="ciuis-body-content" ng-controller="Notbook_Controller">
	<div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-9"> 
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
				  <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo $notebooks->notebook_list;?><?php // echo lang('createnotebook') ?></h2>
				<div class="switchToggle" style="margin-left:50px;">
					<input type="checkbox" id="switch" name="others" checked >
					<label for="switch">Toggle</label>
				</div>
				<md-input-container class="md-block">
				<div class="col-sm-12">
					<input  name="searchnotebook" id="searchPage" class="form-control" placeholder="&nbsp;&nbsp;&nbsp;Search a Notbook Page" value="">
					</div>
				</md-input-container>
				
				<?php if (check_privilege('notebooks', 'edit') || $user_id == $notebooks->created_by) { ?>
					<md-button ng-href="<?php echo base_url()?>notebooks/editnotebook/<?php echo $notebooks->notebook_id;?>" class="md-icon-button" aria-label="Edit" ng-cloak>
						<md-tooltip md-direction="bottom"><?php echo lang('edit') ?></md-tooltip>
						<md-icon><i class="ion-compose  text-muted"></i></md-icon>
					</md-button>
				<?php } ?>
				<?php if(check_privilege('notebooks', 'delete')){ ?>
					<!----<md-button ng-href="<?php echo base_url()?>notebooks/delete/<?php echo $notebooks->notebook_id;?>" class="md-icon-button" aria-label="Delete" ng-cloak>
						<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
						<md-icon><i class="ion-trash-b text-danger"></i></md-icon>
					</md-button>-->
					<md-button  onclick='deletenotebook(<?php echo $notebooks->notebook_id;?>)' class="md-icon-button" aria-label="Delete" ng-cloak>
						<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
						<md-icon><i class="ion-trash-b text-muted"></i></md-icon>
					</md-button>
				<?php  } ?>
				
			</div>
		</md-toolbar>
		<md-content ng-show="!ticketsLoader" layout-padding class="bg-white" style="overflow: hidden;" ng-cloak>
			<div class="box-body">
				<div id="notebook_list_id0" class="row centered-form" style="background:#fff;">
					<div class="col-xs-12 col-sm-8 col-md-12 ">
						<div class="panel panel-info">
							<div class="panel-body">
								<ul class="nav nav-tabs " id="myTab" role="tablist">
									<?php if($notebooks_desc) {  foreach ($notebooks_desc as $key => $value) {?>
									<li class="nav-item <?php echo $key == 0 ? 'active' : "" ;?>" id="mytab1">
										<a class="nav-link"  id="tab-<?php echo $key;?>" data-toggle="tab" onclick="opentab(<?php echo $key;?>)" role="tab" aria-controls="One" aria-selected="true"><span class="nav-title"><?php echo $value->notes_title ;?></span> </a>
									</li>
									<?php  } }?>
								</ul>
								<div class="tab-content" id="myTabContent">
								<?php if($notebooks_desc) { 
									foreach ($notebooks_desc as $key => $value) { ?>
										<div class="tab-pane <?php echo $key == 0 ? 'active' : "" ;?> p-3" id="notestab-<?php echo $key;?>" role="tabpanel" >
											<div class="row" >
												<div class="col-lg-8 mb10" style="text-align: justify" >
													<h3>NOTES </h3>
													<p align="justify"><?php echo $value->notes_description;?></p>
												</div>
											</div>		        
										</div>												
								<?php 	} } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</md-content>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
		<md-content class="bg-white col-sm-12">
			<div class="tab-content" id="myTabContent1">
				<?php if($notebooks_desc) { 
					foreach ($notebooks_desc as $key => $value) {
				?>
				<div class="tab-pane <?php echo $key == 0 ? 'active' : "" ;?> p-3" id="notestab1-<?php echo $key;?>" role="tabpanel" >
					<div class="row" >
						<div class="col-lg-12 mb10 files">
							<md-toolbar class="toolbar-white">
								<div class="md-toolbar-tools">
									<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
										<md-icon><i class="ion-document text-muted"></i></md-icon>
									</md-button>
									<h2 flex md-truncate><?php echo lang('files') ?></h2>
									<md-button ng-click="UploadFileDoc(<?php echo $value->id;?>)"  class="md-icon-button md-primary" aria-label="Add File" ng-cloak>
										<md-tooltip md-direction="bottom"><?php echo lang('upload').' '.lang('file') ?></md-tooltip>
										<md-icon class="ion-android-add-circle text-success"></md-icon>
									</md-button>
									
									
									<!---<h3><a href="javascript:void(0)" class="pull-right file_upload_btn"><i class="fa fa-plus"></i></a> </h3>--->
								</div>
							</md-toolbar>
							<!---<div class="file_upload" style="display: none;">
								<form method="post" action="<?php echo base_url();?>notebooks/upload_image/<?php echo $notebooks->notebook_id;?>" enctype="multipart/form-data">
									<input type="hidden" value="<?php echo $value->id;?>" name="notes_id">
									<p><input type="file" class="form-control" name="files[]" multiple=""></p>
									<p align="right"><input type="submit" class="btn btn-primary" value="Submit"> <input type="button" class="btn btn-default close_btn" value="Cancel"> </p>
								</form>
							</div>--->
							<?php 
								$files = $this->Notebooks_Model->get_notebooks_files($value->id);
								if($files){
									foreach ($files as $key => $file) {
							?>
							<md-list flex ng-cloak>
								<md-list-item class="md-2-line">
									<div class="md-list-item-text">
										<a  class="cursor" onClick="show_post_pdf('<?php echo $file->file_name;?>','<?php echo $file->notebook_files_id;?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $file->file_name;?>" id="editidpdf<?php echo $file->file_name;?>"><h3 class="link"><i class="fa fa-file"></i>  <?php echo $file->file_name;?></h3></a>
									</div>
									<md-icon  href="javascript:void(0)"data-id="<?php echo $file->notebook_files_id;?>" class="ion-trash-b cursor delete_files"></md-icon>
									<md-divider></md-divider>
								</md-list-item>
								
							</md-list>
							<?php  
							} } else { ?> 
								<div class="no-item-data"></div>
							<?php }  ?>
						</div>
					</div>		        
				</div>
				<?php 	} }?>
			</div>
		</md-content>
	</div>
   <custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0"></custom-fields-vertical> 
	<div class="main-content col-xs-12 col-md-12 col-lg-3 md-pl-0 pull-right" style="margin-top: 10px;">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
					<md-icon><i class="ion-document text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('History') ?></h2>
			</div>
		
		
		<div class="ciuis-activity-line col-md-12">
			<ul class="ciuis-activity-timeline">
				<li ng-repeat="log in logs | limitTo: LogLimit" class="ciuis-activity-detail">
					<div class="ciuis-activity-title" ng-bind="log.date"></div>
					<div class="ciuis-activity-detail-body">
						<div ng-bind-html="log.detail|trustAsHtml"></div>
						<div style="margin-right: 15px; border-radius: 3px; background: transparent; color: #2f3239; font-weight: 400;" class="pull-right label label-default">
							<small class="log-date"><i class="ion-android-time"></i> <span ng-bind="log.logdate | date : 'MMM d, y h:mm:ss a'"></span></small>
						</div>
					</div>
				</li>
				<load-more></load-more>
			</ul>
		</div>
		</md-toolbar>
	</div>	
</div>

   <div class="modal fade" id="pdfModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
			<div class="pdffile_class">         
			</div>
			 <input type="hidden" id="fileid">
          <input type="hidden" id="filename">
		</div>
        <div class="modal-footer ">
			<md-dialog-actions>
				<span flex></span>
				
				 <md-button onclick="Getdata()"  aria-label="add"><?php echo lang('delete') ?>!</md-button>
				<a id="imageid1" href="" class="btn btn-default" download><?php echo lang('download') ?>!</a>
				
				<md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
			</md-dialog-actions>
        </div>
      </div>      
    </div>
  </div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script>
var PROPOSALID=0;
var NotbookId= "<?php echo $notebooks->notebook_id;?>";
   		ClassicEditor
            .create( document.querySelector( '#notes_description_1' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
<script type="text/ng-template" id="addfile-template.html">
	   <md-dialog aria-label="options dialog">
	  <?php echo form_open_multipart('notebooks/upload_image/'.$notebooks->notebook_id,array("class"=>"form-horizontal","enctype"=>"multipart/form-data","method"=>"post")); ?>
	  <input type="hidden" value="{{note_id}}" name="notes_id">
	  <md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
		<input type="file" class="form-control" name="files[]" multiple="">
	  </md-dialog-content>
	  <md-dialog-actions>
		<span flex></span>
		<md-button ng-click="close()" aria-label="add"><?php echo lang('cancel') ?>!</md-button>
		 <button type="submit" class="btn btn-report" ng-disabled="uploading == true">
			<span ng-hide="uploading == true"><?php echo lang('upload');?></span>
			<md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</button>
		<!----<md-button ng-click="uploadDocFile()" class="template-button" ng-disabled="uploading == true">
		  <span ng-hide="uploading == true"><?php echo lang('upload');?></span>
		  <md-progress-circular class="white" ng-show="uploading == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
		</md-button>--->
	  </md-dialog-actions>
	  <?php echo form_close(); ?>
	  </md-dialog> 
</script>
<script type="text/javascript">   
	/* $(document).on("click",".tab_btn1",function(){
		var length_count = $(".tab_lenght").val();
		var tab_list= $("#mytab1").clone();
		tab_list.removeClass("active");
		tab_list.find("a .nav-title").html("Page " + length_count);
		tab_list.find("a").attr("id","tab-"+length_count).attr("href","#notestab-"+length_count).attr("aria-controls",length_count);
		tab_list.find("a .close_icons").show();
		$(".btn-li").before(tab_list);

		var tab_div= $("#notestab-1").clone();
		tab_div.attr("id","notestab-"+length_count);
		tab_div.removeClass("active");
		tab_div.attr("aria-labelledby","tab-"+length_count);
		tab_div.find("input").val("").find("textarea").val("");
		tab_div.find(".ck-content p").html("&nbsp;");
		tab_div.find(".notes_title").val("Page " + length_count );
		tab_div.find(".upload_file").attr("name","upload_file["+(length_count - 1)+"][]")
		$("#myTabContent").append(tab_div);
		$("#myTabContent1").append(tab_div);
		$(".tab_lenght").val(parseInt(length_count) + 1);
	}); */
	
	$(document).on("input",".notes_title",function() {
		var dInput = this.value;
		var tab_id = $(this).parents(".tab-pane").attr('id');
		//alert(tab_id);
		$('a[href="#'+tab_id+'"] .nav-title').html(dInput);
	});

	$(document).on("click",".input_Data",function(){
		//alert($(this).find(".fa-edit").length);
		if($(this).find(".fa-edit").length == 1){
			$(this).removeClass("btn-warning").addClass("btn-primary");
			$(this).find("i").removeClass("fa-edit").addClass("fa-check")
			$(this).parents(".input-group").find("input").removeAttr("readonly");
		}
		else{
			$(this).removeClass("btn-success").addClass("btn-warning");
			$(this).find("i").removeClass("fa-check").addClass("fa-edit")
			$(this).parents(".input-group").find("input").attr("readonly", "readonly");
		}
	});
	function opentab(id){
		$('.nav-tabs a[href="#notestab-' + id + '"]').tab('show');
		$('.nav-tabs a[href="#notestab1-' + id + '"]').tab('show');
		$('#myTabContent .tab-pane').removeClass('active');
		$('#myTabContent1 .tab-pane').removeClass('active');
		$("#notestab-" + id).addClass("active");
		$("#notestab1-" + id).addClass("active");
	}
	$(document).on("click",".close_icons",function(){
		var isGood=confirm('Are you sure to delete?');
		if (isGood) {
			var href_id = $(this).parents(".nav-item").find("a").attr("href");
			$(this).parents(".nav-item").remove();
			$(href_id).remove();
			$("active");
			$("#notestab-1").addClass("active");
			$("#notestabnew-1").addClass("active");
		} else {
		  return false
		}
	});

	function show_post_pdf(image,id)
	{
		$("#fileid").val(id);
		$("#filename").val(image);
		var image1= $('#editidpdf'+image).data('image');
		//alert(image);
		//alert(id);
		$(".pdffile_class").html('<object type="application/pdf" data="<?php echo base_url();?>assets/files/notebook/'+image+'" width="100%" height="450"  >No Support</object>');
		$("#imageid1").attr('href', '<?php echo base_url()?>assets/files/notebook/'+image);
	}
	function Getdata(){ 
		var	fileid = $("#fileid").val();
		select_image_name(fileid);
	};
	function select_image_name(id){
         var files_id = id;
         var r = confirm("Are you sure to delete the file");
		var that =  $(this);
	     if (r) {
			var url =  "<?php echo base_url();?>notebooks/delete_files/"+ files_id; 
	        $.ajax({
				url: url , 
				success: function(result){
					that.parents(".files_list").remove();
					var count_2 = that.parents(".files").find(".files_list").length;
					window.location.href="<?php echo base_url(); ?>notebooks/view/"+NotbookId;
				}
			});
	     }
	    else{} 
    }
	$(document).on("click",".delete_files",function(){
		var isGood=confirm('Are you sure to delete?');
		var that =  $(this);
		if (isGood) {
			var files_id  = $(this).attr("data-id");
			var url =  "<?php echo base_url();?>notebooks/delete_files/"+ files_id; 
			$.ajax({
				url: url , 
				success: function(result){
					that.parents(".files_list").remove();
					var count_2 = that.parents(".files").find(".files_list").length;
					window.location.href="<?php echo base_url(); ?>notebooks/view/"+NotbookId;
					/* if(count_2  == 0 ){
						that.parents(".files")/after("h3").html('<div class="no-item-data"></div>');
					} */
				}
			});
		}
		else{
			return false;
		}
	});
  
	$(document).on("click",".file_upload_btn, .close_btn",function(){
		$(this).parents(".files").find(".file_upload").toggle();
	});
		
	$( function() {
		var availablePages = [
		  <?php echo json_encode($notebooks_desc);?>
		];
		var pageTitle = [];
		var autocompleteText = '';
		for(var i = 0; i < availablePages[0].length; i++){	
			pageTitle.push(availablePages[0][i].notes_title);
		}
		 $('#searchPage').autocomplete({
			source: pageTitle,
			select: function (event, ui) {
				var label = ui.item.label;
				var value = ui.item.value;
				autocompleteText = value;
				$('.nav-tabs li.active').removeClass('active');
				var search = $( "ul li.nav-item" ).filter( function ()
				{
					return $( this ).text().toLowerCase().indexOf( autocompleteText.toLowerCase() ) >= 0;
				}).first();
				var tabpane = search.find('a').attr('id');
				var newid=tabpane.split('-');
				$('#myTabContent .tab-pane').removeClass('active');
				$('#myTabContent1 .tab-pane').removeClass('active');
				$("#notestab-" + newid[1]).addClass("active");
				$("#notestab1-" + newid[1]).addClass("active");
				$(tabpane).addClass('active');
				search.addClass('active');
			}
		});
	});
	function deletenotebook(id){
        var r = confirm("Are you sure to delete the record");
	    if (r) {
			$.ajax({
				url : "<?php echo base_url(); ?>notebooks/delete/"+id,
				//data:{id : id},
				method:'POST',
				dataType:'json',
				success:function(response) {
					window.location.href="<?php echo base_url(); ?>notebooks"
				}
			}); 
	    }
	    else{
	        return false;
	    }
    }
</script>
	
	