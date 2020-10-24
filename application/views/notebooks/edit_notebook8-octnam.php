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
.page_input {  border: none; width: 100%; }	
.page_input:focus {outline:none;}
.tab-content{ padding:10px 0 !important; }
.files{  border-left:1px solid #CCC; min-height: 250px }
.files_list{  margin-bottom: 10px;  border: 1px solid #ffbc00; padding:10px; font-size: 16px; }
.files_list a{ color : #ffbc00; }

.wrapper {
    position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:50px;
}

.list {
    position:absolute;
    left:1px;
    top:0px;
  	min-width:10000px;
  	margin-left:12px;
    margin-top:0px;
}

.list li{
	display:table-cell;
    position:relative;
    text-align:center;
    cursor:grab;
    cursor:-webkit-grab;
    vertical-align:middle;
}

.scroller {
  text-align:center;
  cursor:pointer;
  display:none;
  padding:7px;
  padding-top:11px;
  white-space:no-wrap;
  vertical-align:middle;
  background-color:#fff;
}

.scroller-right{
  float:right;
}

.scroller-left {
  float:left;
}

.nav-tabs > li{
	margin-right:0px !important;
}
</style>
<?php //print_r($notebooks); die; ?>
<div class="ciuis-body-content" >
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-12"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><label>Notebooks</label><?php // echo lang('createnotebook') ?></h2>
       <!-- <md-switch ng-model="proposal_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php //echo lang('for_lead')?></strong></md-switch>-->
        <!-- <md-button ng-href="<?php //echo base_url()?>notebooks/editnotebook/<?php echo $notebooks->notebook_id;?>" class="md-icon-button" aria-label="Edit" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('edit') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-primary"></i></md-icon>
        </md-button>-->
        <md-button type="button" onclick="saveeditdata()"  class="md-icon-button" aria-label="Save" ng-cloak>
          <md-progress-circular ng-show="savingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="savingProposal == true" md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
          <md-icon ng-hide="savingProposal == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
        <md-button ng-href="<?php echo base_url('notebooks')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-danger"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>	 
	   	 <div class="box-body">
						<div id="notebook_list_id0" class="row centered-form" style="background:#fff;">
						<div class="col-xs-12 col-sm-8 col-md-12 ">
						 <div class="panel panel-info">
						<div class="panel-body">
					   <form id="notebookeditForm" name="notebookeditForm"  action="<?php echo base_url('notebooks/updatenote') ?>" method="post" enctype="multipart/form-data">
						 <input type="hidden" name="noteid" class="form-control"  value="<?php echo  $notebooks->notebook_id;?>">
						  <div class="panel panel-info">
							<div class="panel-body">
								<div layout-gt-xs="row">
									<md-input-container class="md-block" flex-gt-sm>
										<input  name="notebook" id="notebook" class="form-control" placeholder="Enter Notebook Name" required="required" value="<?php echo  $editnotebooks->notebook_list;?>">
									</md-input-container>
								</div>
                                <input type="hidden" class="tab_lenght" value="2">
								<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
								<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
								<div class="wrapper">
									<ul class="nav nav-tabs list" id="myTab" role="tablist">
									<?php if($notebooks_desc) {  foreach ($notebooks_desc as $key => $value) {?>
										<li class="nav-item <?php echo $key == 0 ? 'active' : "" ;?>" id="mytab1">
											<a class="nav-link row" id="tab-<?php echo $key;?>" data-toggle="tab" href="#notestab-<?php echo $key;?>" role="tab" aria-controls="One" aria-selected="true">
												<span class="col-md-10">
													<input type="text" name="notes_title[<?php echo $key;?>]" class="page_input" value="<?php echo $value->notes_title ;?>">
													<input type="hidden" name="noteidlist[<?php echo $key;?>]" class="descval" value="<?php echo $value->id;?>">
												</span>
												<span class="col-md-2 close_icons" id="<?php echo $value->id;?>" noteid="<?php echo $value->notebook_id;?>"><i class="fa fa-close"></i></span>
												</a>
										</li>
										<?php  } }?>
										<li class="btn-li">
										 <a class="btn btn-success btn-xs tab_btn"  href="javascript:void(0)"><i class="fa fa-plus"></i></a>
										</li>
									</ul>
								</div>
                            <div class="tab-content" id="myTabContent">
					          	<?php if($notebooks_desc) {  foreach ($notebooks_desc as $key => $value) {?>
						        <div class="tab-pane <?php echo $key == 0 ? 'active' : "" ;?> p-3" id="notestab-<?php echo $key;?>" role="tabpanel" aria-labelledby="tab-<?php echo $key;?>">

						               <div class="row" >
							               	<div class="col-lg-8 mb10" style="text-align: justify" >
											<label>Notes</label>
										<textarea type="text" class="form-control notes_description" placeholder="Notes" name="notes_description[<?php echo $key;?>]" id="notes_description_<?php echo $key;?>" row="5"><?php echo $value->notes_description;?></textarea>
										</div>							
											
											<div class="col-lg-4 mb10 files">
												<h3>FILES <a href="javascript:void(0)" class="pull-right file_upload_btn"><i class="fa fa-plus"></i></a> </h3>
												<div class="file_upload" style="display: none;">
												    <input type="hidden" value="<?php echo $value->id;?>" name="notes_id">
													<p><input type="file" id="img_<?php echo $value->id;?>" class="form-control upload_file" name="files[<?php echo $key;?>]" multiple=""></p>
													
													<p align="right"><input type="button" class="btn btn-primary imgupload" id="<?php echo $value->id;?>" notebookId="<?php echo $notebooks->notebook_id;?>" value="Submit"> <input type="button" class="btn btn-default close_btn" value="Cancel"> </p>
												</div>
												<?php
													$files = $this->Notebooks_Model->get_notebooks_files($value->id);
													if($files){
														foreach ($files as $key => $file) {	
												?>
												<div class="showFileList">
													<div class="files_list" > <a onClick="show_post_pdf('<?php echo $file->file_name;?>')" data-toggle="modal" data-target="#pdfModal" data-image="<?php echo $file->file_name;?>" id="editidpdf<?php echo $file->file_name;?>"><i class="fa fa-file"></i> <?php echo $file->file_name;?></a>

														<a class="pull-right delete_files" href="javascript:void(0)"data-id="<?php echo $file->notebook_files_id;?>"><i class="fa fa-trash"></i></a>
													</div>
												</div>
												<?php  
												} } else { ?> 
													<div class="no-item-data"></div>
												<?php }  ?>
											</div>
									   </div>		        
						          </div>
						      <?php } } ?>
					    </div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
  </div>
    </md-content>
        <custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0"></custom-fields-vertical> 
	</div>

</div>


</div>
   <div class="modal fade" id="pdfModal">
    <div class="modal-dialog modalstyle">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body form-group">
			<div class="pdffile_class">         
			</div>

          	
 
        </div>
        <div class="modal-footer ">
          </span>
        </div>
      </div>      
    </div>
  </div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>"></script>
<!--<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script>

   <?php if($notebooks_desc) {  foreach ($notebooks_desc as $key => $value) {?>
   		ClassicEditor
            .create( document.querySelector( '#notes_description_<?php print $key;?>' ) )
            .catch( error => {
                console.error( error );
            } );
   <?php }}?>
			
</script>
<script type="text/javascript">

$(document).ready(function() {
	var existingPagescnt = $('ul.nav-tabs>li.nav-item').length;
	$(".tab_lenght").val(existingPagescnt);
});
   
$(document).on("click",".tab_btn",function(){
	var length_count = $(".tab_lenght").val();
	var tab_list= $("#mytab1").clone(true);
	tab_list.removeClass("active");
	tab_list.find("a .page_input").val("Page " + (parseInt(length_count)+1));
	tab_list.find("a .page_input").attr("name","notes_title["+length_count+"]");
	tab_list.find("a .descval").attr("name","noteidlist["+length_count+"]");
	tab_list.find("a").attr("id","tab-"+length_count).attr("href","#notestab-"+length_count).attr("aria-controls",length_count);
	tab_list.find("a .close_icons").show(); 
	$(".btn-li").before(tab_list);
	tab_list.find("input.descval").val("");
	tab_list.find("span.close_icons").removeAttr('id');
	var tab_div='<div class="tab-pane p-3" id="notestab-'+length_count+'" role="tabpanel" aria-labelledby="tab-'+length_count+'"><div class="row" ><div class="col-lg-8 mb10" style="text-align: justify"><label>Notes</label><textarea type="text" class="form-control notes_description" placeholder="Notes" name="notes_description['+length_count+']" id="notes_description_'+length_count+'" row="5"></textarea></div><div class="col-lg-4 mb10 files"><h3>Upload FILES <a href="javascript:void(0)" class="pull-right file_upload_btn"><i class="fa fa-plus"></i></a></h3><div class="file_upload" style="display: none;"><input type="file" class="form-control upload_file" id="upload_file" name="files['+length_count+'][]" multiple="" /></div><div class="no-item-data"></div></div></div></div>';
	$("#myTabContent").append(tab_div);
	ClassicEditor
		.create(document.querySelector( '#notes_description_' + length_count))
		.then(newEditor => {
			editor = newEditor;
		})
		.catch( error => {
		//console.error( error );
		} );
		console.log($("textarea#notes_description_"+length_count).parent('div').children(".ck-editor"));
	$("textarea#notes_description_"+length_count).parent('div').children(".ck-editor").find("p").html("");
	$(".tab_lenght").val(parseInt(length_count) + 1);
	reAdjust();
	scrollrightbar();
});


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

	      $(document).on("click",".close_icons",function(){
	      	var isGood=confirm('Are you sure to delete?');
			    if (isGood) {
				   var descid='';
				   descid=$(this).attr('id');
				   var href_id = $(this).parents(".nav-item").find("a").attr("href");
				   $(this).parents(".nav-item").remove();
				   if (typeof descid === "undefined") {
					   $(href_id).remove();
					   
					}else{
						var url =  "<?php echo base_url();?>notebooks/delete_desc/"+ descid; 
						$.ajax({
							url: url , 
							success: function(result){
								$(href_id).remove();
							}
						});
					}
					$('.nav-item').removeClass("active");
					$('.tab-pane').removeClass("active");
					$("#notestab-0").addClass("active");
					$("#tab-0").parent('li').addClass("active");
			    } else {
			      return false
			    }
	      });


	      function show_post_pdf(id)
	 		 {
			    var image= $('#editidpdf'+id).data('image');
			    //alert(image);
			   	 //alert(id);

			   	 $(".pdffile_class").html('<object type="application/pdf" data="<?php echo base_url();?>assets/files/notebook/'+id+'" width="100%" height="500" style="height: 85vh;" >No Support</object>');

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
				    		if(count_2  == 0 ){
				    			that.parents(".files")/after("h3").html('<div class="no-item-data"></div>');
				    		}
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
	   		
var hidWidth;
var scrollBarWidths = 40;

var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

var i=1;
$('.scroller-right').click(function() { 
  $('.scroller-left').fadeIn('slow');
  //$('.scroller-right').fadeOut('slow');
  var intvalue = Math.floor(widthOfList()/325);
  var showFlag= getLeftPosi() + (i * 325);
  if(i < intvalue && widthOfList()+getLeftPosi() > 0){
	$('.list').animate({left:"-="+(showFlag)+"px"},'slow',function(){
	});
	i++;
  }
  else {
	i = 1;
	$('.scroller-right').fadeOut('slow');
  }
});

function scrollrightbar() {
	if(widthOfList() > 1300) {
		$('.scroller-left').fadeIn('slow');
		$('.scroller-right').fadeOut('slow'); 
		$('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){
		});
	}
}

$('.scroller-left').click(function() {
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
});

$('.imgupload').click(function(){
	var notebookdescid=$(this).attr('id');
	var notebookid=$(this).attr('notebookId');
	 var form_data = new FormData();
	 var totalfiles = $('#img_'+notebookdescid)[0].files.length;
	 for (var index = 0; index < totalfiles; index++) {
      form_data.append("files[]",$('#img_'+notebookdescid)[0].files[index]);
	}
	var url =  "<?php echo base_url();?>notebooks/edit_upload_image/"+ notebookdescid +"/"+notebookid; 
	$.ajax({
     url: url, 
     type: 'post',
     data: form_data,
     dataType: 'json',
     contentType: false,
     processData: false,
     success: function (response) {
		location.reload();
     }
   });
	
	
});

function saveeditdata() {
	$('#notebookeditForm').submit();
}

</script>
	
	