 <div id="div1"><select class="selectpicker required" data-live-search="true" name="supplier" title="Select Supplier" style="min-width: 200px;" data-width="100%" id="supplier0" onchange="supplierModal(this.value);" style="margin-bottom:10px;">
   

	<?php if(isset($supplier)){
		foreach($supplier as $eachSupplier){?>
		<option value="<?php print $eachSupplier['supplier_id'];?>"><?php print $eachSupplier['companyname'];?></option>
		<?php }?>
	<?php }?>
    </select>
    
    
    <div class="form-group col-md-3"><label for="exampleInputFile">Supplier Ref Code</label><input type="text" name="supp[shortname][]" placeholder="Enter Short Name" id="short-name" title="Short Name" aria-describedby="" class="form-control">
        </div> 
		<div class="form-group col-md-3"><label for="exampleInputFile">Price</label><input type="text" name="supp[price][]" placeholder="price" id="price" title="Price" aria-describedby="" class="form-control"></div>
	
		<button class="btn btn-sm btn-primary" style="margin-top:10px;float: right;" onclick="addnewsupplier();" type="button">Add New</button>
    </div>