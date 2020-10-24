<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );

class Material_lib{

	public

	function __construct() {

		$this->CI = & get_instance();
		$this->CI->load->helper( 'url' );
		$this->CI->load->helper( 'form' );
		$this->CI->load->model( 'Mrequests_Model' );
	}

	function material_popup($id) {
		$materialsinfoData = $this->CI->Mrequests_Model->get_mreq_data($id);
		$vendorsinfo = $this->CI->Mrequests_Model->get_all_vendors($materialsinfoData['mname']);
		$imageinfo= $this->CI->Mrequests_Model->get_all_files($id);
		
		$approvalAccess=$this->CI->Privileges_Model->has_approval_access('mrequests');
		$maxvalue=$approvalAccess['maxvalue'];
		$comperKey='price';
		if($approvalAccess['type']=='level'){
			$materialsinfo=check_approval_data_ForId($materialsinfoData,$maxvalue,'Level');
		}else if($approvalAccess['type']=='price'){
			$materialsinfo=check_approval_data_ForId($materialsinfoData,$maxvalue,$comperKey);
		}else{
			$materialsinfo=check_approval_data_ForId($materialsinfoData,$maxvalue,'NotAccess');
		}
		
		$materialdiv="";
		$vendordiv="";
		$imgs = "";
		$imgsType = array("image/jpeg", "image/jpg", "image/png", "image/gif");
		$finaldata="";
		$selectedVar = '';		
		if(sizeof($materialsinfo) > 0){
			$materialVendorID = $materialsinfo['vendor_id'];
			$optionVal=array("1"=>"Open","2"=>"Pending","3"=>"Approved","4"=>"Declined");
			$selectedVar = "<select name='status_edit' id='status_edit' class='form-control' value='".$materialsinfo['status']."'>";
			foreach($optionVal as $key=>$value){
				$selected=($materialsinfo['status'] == $key) ? 'selected' :'';
				$selectedVar .="<option value='$key' $selected>$value</option>";
			}
			$selectedVar .="</select>";
			
			$materialdiv ="<div class='row'>";
			$materialdiv .="<div class='col-md-12'>";
			$materialdiv .="<div class='form-group col-md-4'>";
			$materialdiv .="<label>Price</label>";
			$materialdiv .="<div><input type='text' name='price_edit' id='price_edit' class='form-control' placeholder='Price' value='".$materialsinfo['price']."'></div>";
			$originalPrice = $materialsinfo['vendor_price'];
			$materialdiv .="</div>";
			$materialdiv .="<div class='form-group col-md-4'>";
			$materialdiv .="<label>Quantity</label>";
			$materialdiv .="<div><input type='number' placeholder='Quantity' name='quantity_edit' id='quantity_edit' class='form-control'value='".$materialsinfo['qty']."' onchange='priceCalculate()'></div>";
			$materialdiv .="</div>";
			/*
			$materialdiv .="<div class='form-group col-md-4'>";
			$materialdiv .="<label>Status</label>";
			if($materialsinfo['showAccess'] =='1'){
				$materialdiv .=$selectedVar;
			}
			
			$materialdiv .="</div>";*/
			$materialdiv .="<input type='hidden' name='material_id' value='".$materialsinfo['id']."' id='material_id' />";
			$materialdiv .="</div>";
			$materialdiv .="</div>";
		}else{
			$materialdiv="<div class='row'></div>";
		}
		if(sizeof($vendorsinfo) > 0){
			$vendordiv  ="<div class='row'>";
			$vendordiv .="<div class='col-md-12'>";
			$vendordiv .="<table class='vendortable table table-bordered'><thead><th></th><th>Vendor Name</th><th>Vendor Ref</th><th>Price</th></thead><tbody>";
			foreach($vendorsinfo as $eachitem){
				$vendorRadio = $eachitem['vendorMaterialId'] == $materialVendorID ? 'checked' : '';
				$vendorRadioChecked = $eachitem['vendorMaterialId'] == $materialVendorID ? '' : 'disabled';
				
				$vendorprice = $eachitem['vendorMaterialId'] == $materialVendorID ? $originalPrice : $eachitem['price'];
				$vendordiv .="<tr><td><input name='vendorradio' class='vendorRadio' type='radio' value='".$eachitem['vendorMaterialId']."' $vendorRadio id='vendor_".$eachitem['vendorMaterialId']."' /></td><td>".$eachitem['vendorname']."</td><td>".$eachitem['ref']."</td><td style='padding:0px !important;'><input type='number' name='price_vendor' class='form-control priceVendor' id='VendorPrice_".$eachitem['vendorMaterialId']."' value='".$vendorprice."' $vendorRadioChecked onchange='priceCalculate()'/></td></tr>";
			}
			$vendordiv .="</tbody></table>";
			$vendordiv .="</div>";
			$vendordiv .="</div>";
		}else{
			$vendordiv ="<div class='row'></div>";
		}
		if(sizeof($imageinfo)>0){
			$imgData = base_url('/uploads/files/materialrequests');
			$defaultImgPath = base_url('/assets/img/document_sample.png');
			$imgs .= "<div class='row'>";
			foreach($imageinfo as $eachImg) {
				    $ext = pathinfo($eachImg['file_name'], PATHINFO_EXTENSION);
					$type = 'file';
					if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
						$type = 'image';
					}
					if ($ext == 'pdf' || $ext == 'PDF') {
						$type = 'pdf';
					}
					if ($ext == 'zip' || $ext == 'rar' || $ext == 'tar') {
						$type = 'archive';
					}
					if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
						$display = true;
					} else {
						$display = false;
					}
					if ($ext == 'pdf' || $ext == 'PDF') {
						$pdf = true;
					} else {
						$pdf = false;
					}
					$imgs.="<div class='col-md-12'>";
					$imgs .= '<div class="col-md-9"><div class="md-list-item-text image-preview">';
					$filename = "'".$eachImg['file_name']."'";
					$fileurl = $imgData.'/'.$id.'/'.$eachImg['file_name'];
					
					if($type == 'image'){
						$imgs .= '<a class="cursor" data-toggle="tooltip" data-placement="top" title="Preview" onclick="ConvertToAng('.$filename.','.$id.','.$eachImg['file_id'].')"><img src='.$imgData.'/'.$id.'/'.$eachImg['file_name'].'></a>';
					}else if($type == 'archive'){
						$imgs .= '<a class="cursor" href="'.$fileurl.'" data-toggle="tooltip" data-placement="top" title="Download"><img src="'.base_url('assets/img/zip_icon.png').'"/></a>';
					}else if($type == 'file'){
						$imgs .= '<a class="cursor" href="'.$fileurl.'" data-toggle="tooltip" data-placement="top" title="Download"><img src="'.base_url('assets/img/file_icon.png').'"/></a>';
					}else if($type == 'pdf' || $type == 'PDF'){
						$imgs .= '<a class="cursor" data-toggle="tooltip" data-placement="top" title="Preview" onclick="ViewPdfFile('.$eachImg['file_id'].','.$filename.','.$id.')"><img src="'.base_url('assets/img/pdf_icon.png').'"/></a>';
					}
					$imgs .='</div></div>';
					$imgs.= '<div class="col-md-3" style="text-align:right;"><md-icon onclick="DeleteFile('.$id.','.$eachImg['file_id'].','.$filename.')" class="ion-trash-b cursor material-icons" role="button" tabindex="0" aria-hidden="true"></md-icon></div>';
					$imgs .='</div><hr/>';
			}
			$imgs.="</div></div>";
		}else{
			$imgs="";
		}
		$finaldata=$materialdiv.$vendordiv.$imgs;
		echo $finaldata;
	
	}


}