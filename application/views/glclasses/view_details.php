<form  id="edit_form" method="post" action="<?php echo site_url('inventories/transfer');?>" enctype='multipart/form-data'>
<input type="hidden" name="inventory_id" id="inventory_id" value="<?php echo $inv_id;?>" />
						<div class="col-md-12">
							<div class="col-xs-12">
								<label><h4><strong><?php echo "Project" ?></strong></h4></label>
								<input type="radio" checked="checked" name="project" id="project" value="project" class="rd"/>&nbsp;&nbsp;&nbsp;
								
								<label><h4><strong><?php echo "Warehouse" ?></strong></h4></label>
								<input type="radio" name="project" id="warehouse" value="warehouse" class="rd" />
							</div>
						</div>
						
						<div class="col-md-12 form-group">
							<div class="col-xs-5" id="pr">
								<label><strong><?php echo "Project" ?></strong></label>
								<select class="proj  form-control" name="project_id" id="project_id" autocomplete="on" style="width: 315.824px;"> 
									<option value="">Select Project</option>
									<?php foreach($projects as $row):?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
									<?php endforeach;?>
									</datalist>			   
								</select> 
							</div>
						</div>
						<div class="col-md-12 form-group" >
							<div class="col-xs-5" id="warehousediv">
								<label><strong><?php echo "Warehouse" ?></strong></label>
								<select class="form-control wh" name="warehouse_id" id="warehouse_id" autocomplete="on"> 
									<option value="">Select Warehouse</option>
									<?php foreach($warehouses as $row):?>
									<option value="<?php echo $row['warehouse_id'];?>"><?php echo $row['warehouse_name'];?></option>
									<?php endforeach;?>
									</datalist>			   
								</select> 
							</div>
						</div>
						<div class="col-md-12 form-group">
						<div class="col-xs-5">
						<label>Quantity</label>
						<input type="number" class="form-control" name="qty" id="qty" />
						</div>
						</div>
						<div class="col-md-5 form-group" align="center">
						
						
						</div>
						<button name="send" Value="Send" style="margin-top: 40px;">Update</button>
						
</form>			
 
<style>
.select2-selection__arrow b{
    display:none !important;
}
.select2-selection{
	min-height:50px !important;
}
.select2-selection__rendered {
	padding-top: inherit !important;
}
</style>			
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>
$('document').ready(function() { 
$('#pr').show(); 
$(".proj").select2({
	theme: "bootstrap"
});
$(".wh").select2({
	theme: "bootstrap"
});
$('#warehousediv').hide();
});
$('.rd').on('click',function() {
	
	if($('#project').is(':checked')) {
		$('#pr').show(); 
		$('#warehousediv').hide(); 
	$(".proj").select2({
	theme: "bootstrap"
});
};
	
	if($('#warehouse').is(':checked')) {
		$('#pr').hide(); 
		$('#warehousediv').show(); 
	$(".wh").select2({
	theme: "bootstrap"
});


};
});
</script>
