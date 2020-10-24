<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
  <div class="ciuis-body-content">
    <style type="text/css">
      rect.highcharts-background {
        fill: #f3f3f3;
      }
    </style>
   <div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2 flex md-truncate class="text-bold"><?php echo lang('REQUESTS'); ?> <small>/ Bill Request No.<?php echo $id; ?></small><br>
            
          </h2>
		 <?php if($responce = $this->session->flashdata('success')): ?>
      
        <div class="col-lg-6">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      
    <?php endif;?>

		   
		  </div>
		  </md-toolbar>
		  
	 
<?php $imgs = explode(',',$images); 

foreach($imgs as $img) {   ?>
<td>

	<img ng-src="<?php 
			  
			  echo base_url('uploads/files/billrequests/'.$id.'/'.$img.'')?>" alt="staffavatar" width="auto;" height="auto;" align="center">
</td>			  

<?php } ?> 
</div>
	   </md-toolbar>
	  

</div>		  

	   

    <?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/projects.js'); ?>"></script>
<script type="text/javascript">

function select_status(val,id){
	var status = val;
	var id = id;
	
	 $.ajax({
              url : "<?php echo base_url(); ?>otherrequests/update",
              data:{id : id,status : status},
              method:'POST',
              dataType:'json',
              success:function(response) {
                window.location.reload();
            }
          });
	
}
      

var countChecked = function(){
	var total = 0;
	var n = $("input:checked").length;
	$("input:checked").each(function() {
	total += parseInt($(this).val());
	//$( "div" ).text( n+ (n === 1 ? " is" : " are") + " checked!" );
	
	});
	
	$('#items').text( n+ " items" + " selected | " +total + " AED");
};
countChecked();

$("input[type=checkbox]").on("click",countChecked);

</script>		
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
	<script>
    $(document).ready(function(){
      var date_input=$('.newdatepicker'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
   
      date_input.datepicker({dateFormat:'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,changeYear: true,changeMonth: true});
			
    })
</script>