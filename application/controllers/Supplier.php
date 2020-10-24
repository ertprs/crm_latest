<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Supplier extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Supplier_Model');
		/*
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}*/
	}

	function index() {
		$data[ 'title' ] = lang( 'supplier' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data['payment'] = $this->Settings_Model->get_payment_gateway_data();
		
	
		$this->load->view( 'supplier/index', $data );
	}
	
	function get_supplier_list()
	{
		$supplierResult=array();
		$keyword = strval( $this->input->post( 'str' ));
		$supplier = $this->Supplier_Model->get_all_supplier_by_search($keyword);
		if(!empty($supplier)){
			foreach($supplier as $row){
				
				$supplierResult[]= array('id' => $row["supplier_id"], 
            'name' => $row["companyname"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}
	
	function get_supplier_list_new()
	{
		$supplierResult=array();
		$keyword = strval( $this->input->post( 'str' ));
		$supplier = $this->Vendors_Model->get_all_supplier_by_search($keyword);
		if(!empty($supplier)){
			foreach($supplier as $row){
				
				$supplierResult[]= array('id' => $row["id"], 
            'name' => $row["company"]);
			}
			echo json_encode($supplierResult);
		}else{
			echo '0';
		}
	}


	function create() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				
				
				
				$hasError = false;
				
				if (!$hasError) {
					$appconfig = get_appconfig();
					$newdata2='';
					$newdata22 ='';
					$newdata23 = '';
					 if(isset($_POST['test_image']) && (!empty($_POST['test_image']))){
					    $cnt=count($_POST['test_image']);
							if($cnt>0){
								
					        	$newdata2 = implode(',', $this->input->post('test_image'));
							}
					 }
					if(isset($_POST['test_image1']) && (!empty($_POST['test_image1']))){
					    $cnt=count($_POST['test_image1']);
					    if($cnt>0){
					        
					        	$newdata22 = implode(',', $this->input->post('test_image1'));
					    }
					 }
					
					if(isset($_POST['test_image2']) && (!empty($_POST['test_image2']))){
					    $cnt=count($_POST['test_image2']);
					    if($cnt>0){
					        
					        	$newdata23 = implode(',', $this->input->post('test_image2'));
							
					    }
					}
					 $status = $this->input->post( 'status' );
					if($status != ''){
					    $stat = $status;
					}else{
					    $stat = 'off';
					}
					$params = array(
						'created' => date( 'Y-m-d' ),
						'companyname' => $this->input->post( 'companyname' ),
				'status' => $stat,
				
				'company_address' => $this->input->post( 'company_address' ),
				'contact_number_office' => $this->input->post( 'contact_number_office' ),
				'account_contact_number' => $this->input->post('account_contact_number'),
				'emailaddress' => $this->input->post( 'emailaddress' ),
				'mobile_number' => $this->input->post( 'mobile_number') ,
				'website' => $this->input->post( 'website' ),
				'country_id' => $this->input->post( 'country_id') ,
				'tax_registration' => $this->input->post('tax_registration'),
				'creditlimit' => $this->input->post('creditlimit'),
				'creditperiod' => $this->input->post('creditperiod'),
				'terms_and_conditions' => $this->input->post('terms_and_conditions'),
				'notes' => $this->input->post('notes'),
				'trade_licence_documents'=>$newdata2,
				'tax_registration_document'=>$newdata22,
				'expiry_date' => $this->input->post('expiry_date'),
				'licence_no' => $this->input->post('licence_no'),
				//'owner_documents'=>$newdata23
					);
					$customers_id = $this->Supplier_Model->add_supplier( $params );

					if($this->input->post('point_contact_name'))
				{
				$cnt=count($this->input->post('point_contact_name'));
					if($cnt>0){
						
						$ptcntname=$this->input->post('point_contact_name');
						$ptcntnum=$this->input->post('point_contact_number');
						$ptcntemail=$this->input->post('point_contact_email');
						for($i=0;$i<$cnt;$i++){
							
							
							$params1 = array(										
										'point_contact_name' => $ptcntname[$i],
										'point_contact_number' => $ptcntnum[$i],
										'point_contact_email' => $ptcntemail[$i],
										'supplierid' => $customers_id);
							 $this->Supplier_Model->add_supplier_contact( $params1 );
							
						}
						
					}
				
				}
				
				
					
					
					if ( $this->input->post( 'custom_fields' ) ) {
						$custom_fields = array(
							'custom_fields' => $this->input->post( 'custom_fields' )
						);
						$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'supplier', $customers_id );
					}
					
					redirect(base_url().'supplier');
					
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}


function edit_supp(){
    $supp_id = $this->input->post('id');
		$result = $this->Supplier_Model->get_supplier_id($supp_id);
	$supp_contacts = $this->Supplier_Model->get_supp_contact_records($supp_id);
	$countries = file_get_contents( 'assets/json/countries.json' );
	$obj = json_decode($countries,true); 
	

        echo '<form id="form1" method="post" action="supplier/update">';
        echo '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Update</h4> </div></div>';
        echo '<hr></hr>';
        echo '<input type="hidden" name="supplier_id" id="supplier_id"  value="'.$supp_id.'" >';
       echo ' <div class="form-row"><div class="form-group "><label for="companyname"><b>Company Full Name</b></label><input type="text" class="form-control required" required id="companyname" placeholder="Company Full Name" name="companyname" value="'.$result["companyname"].'"></div>';
 /*   echo '<div class="form-group "><label for="status">Status</label><select id="status" class="form-control required" required name="status">
        <option value="">Choose...</option>';
        $selected = '';
        if($result["status"] == 'Active') {
            
              $selected = "selected";
        }
         $selected1 = '';
        if($result["status"] == 'Black Listed'){
            $selected1 = "selected";
        }
       echo' <option ' . $selected. '>Active</option>';
		echo '<option ' . $selected1. '>Black Listed</option>';
		echo '</select></div>'; */
		
		 echo '<div class="outerDivFull" ><div>Status</div><div class="switchToggle">';
		 if($result["status"] == 'on'){
		echo  '<input type="checkbox" id="switch" name="status" checked onchange="select_switch(this.value);">';
		 } else { 
		  	echo  '<input type="checkbox" id="switch" name="status"  onchange="select_switch(this.value);">';   
		 }
   echo '<label for="switch">Toggle</label></div></div>';
		echo '</div>';
		
 echo  '<div class="form-group"><label for="company_address">Company Address</label><textarea type="text" class="form-control required" required id="company_address" placeholder="Company Address" name="company_address">'.$result["company_address"].'</textarea></div>';
 
  echo '<div class="form-row"><div class="form-group "><label for="contact_number_office">Contact Number Office</label><input type="text" class="form-control required" required id="contact_number_office" placeholder="Contact Number Office" name="contact_number_office" value="'.$result["contact_number_office"].'"></div>';
  
   echo '<div class="form-group "><label for="inputCity">Contact Person (Accounts)</label><input type="text" class="form-control" id="account_contact_number" placeholder="Contact Person (Accounts)" name="account_contact_number" value="'.$result["account_contact_number"].'"></div>';
   
   echo '<div class="form-group ">
      <label for="inputState">email address</label>
      <input type="text" class="form-control" id="emailaddress" placeholder="email" name="emailaddress" value="'.$result["emailaddress"].'"></div></div>';
      
  echo '<div class="form-row"><div class="form-group "><label for="inputZip">Mobile Number</label><input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number" name="mobile_number" value="'.$result["mobile_number"].'">
    </div>';
 echo  '<div class="form-group "><label for="inputCity">Website</label>
      <input type="text" class="form-control" id="website" placeholder="Website" name="website" value="'.$result["website"].'"></div>';
    echo '<div class="form-group"><label for="">Country</label><select name="country_id" id="country_id" class="form-control" autocomplete="off">';
    echo '<option value>Select Country</option>';
    foreach($obj as  $cntry){
        
        echo '<option value='.$cntry["id"].'>'.$cntry["shortname"].'</option>';
    }
    echo '</select></div></div>';

    echo '<div class="form-row"><label for="">Trade Licence No.</label></div>';
  echo '<div class="row">
   
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
    <input type="text" class="form-control" id="licence_no" placeholder="Trade Licence No" name="licence_no" value="'.$result["licence_no"].'">
    </div>
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
      <input type="text" class="form-control" id="expiry_date" placeholder="Expiry Date" name="expiry_date" value="'.$result["expiry_date"].'">
    </div>
	 <div class="col-sm-3 col-md-6 col-lg-4" >
      <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
   
<div class="form-group col-md-2">';
if($result["trade_licence_documents"]) {
          $psp = str_replace(',','',$result["trade_licence_documents"]);
        
        $passport_doc = explode(",", $result["trade_licence_documents"]); 
        $pass_count = 0;
          foreach ($passport_doc as $key => $pass_value) {
              if($pass_value != ''){
             $pass_count ++;
              }
          }
       
        
       echo '<span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-4">'.$pass_count.'</a>';
       echo '<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
      echo '<div class="modal-header">';
       echo ' <h5 class="modal-title" id="exampleModalLabel"><h5>Document View</h5>';
       echo  '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" >';
           $ext = ''; 
           foreach ($passport_doc as $key => $pass_value) {
             
              if($pass_value != '') { 
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); 
        echo    '<div class="row">';
                if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){

		echo	 "<a href='#about' onclick=show_post_pdf('".$pass_value."') data-toggle='modal' data-image='".$pass_value."' id='editidpdf$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
				   }else{
				  echo "<a class='btn btn-success' href='uploads/images/$pass_value'  target='_new'><i class='ion-clipboard'></i></a>";
				    }
			   
			 } else{ 
	      echo "<a href='#about'  onclick=show_post('".$pass_value."') data-toggle='modal'  data-image='".$pass_value."' id='editid$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
               } 
               echo ' <li>'.$pass_value.'</li>';
	
            echo   '<a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name("'.$pass_value.'","'.$result["supplier_id"].'","trade_documents");><span class="glyphicon glyphicon-remove"></span></a>';
        
            
             echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
         } ;
         
echo '</div>';

   echo '</div>
  </div>
<div class="form-row">
  <label for="">Trade Licence No.</label>
  </div>
  <div class="row">
   
    <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
    <input type="text" class="form-control" id="tax_registration" placeholder="Tax Registration No" name="tax_registration" value="'.$result["tax_registration"].'">
    </div>
    <!-- <div class="col-sm-3 col-md-6 col-lg-4" style="border-right:2px solid #000;">
      <input type="text" class="form-control" id="tax_expiry_date" placeholder="Expiry Date" name="tax_expiry_date" value="'.$result["tax_expiry_date"].'">
    </div>  -->
	 <div class="col-sm-3 col-md-6 col-lg-4" >
      <input type="file" multiple class="form-control-file" id="upload_file1" name="upload_file1[]" onchange="preview_image1();">
	 <div class="loder col-md-1"></div>
  <div id="image_preview1" class="col-md-12"></div> 
  
<div class="form-group col-md-2">';
if($result["tax_registration_document"]) {
          $psp = str_replace(',','',$result["tax_registration_document"]);
        
        $passport_doc = explode(",", $result["tax_registration_document"]); 
        $pass_count = 0;
          foreach ($passport_doc as $key => $pass_value) {
              if($pass_value != ''){
             $pass_count ++;
              }
          }
       
        
       echo '<span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-5">'.$pass_count.'</a>';
       echo '<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
      echo '<div class="modal-header">';
       echo ' <h5 class="modal-title" id="exampleModalLabel"><h5>Document View</h5>';
       echo  '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" >';
           $ext = ''; 
           foreach ($passport_doc as $key => $pass_value) {
             
              if($pass_value != '') { 
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); 
        echo    '<div class="row">';
                if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){

		echo	 "<a href='#about' onclick=show_post_pdf('".$pass_value."') data-toggle='modal' data-image='".$pass_value."' id='editidpdf$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
				   }else{
				  echo "<a class='btn btn-success' href='uploads/images/$pass_value'  target='_new'><i class='ion-clipboard'></i></a>";
				    }
			   
			 } else{ 
	      echo "<a href='#about'  onclick=show_post('".$pass_value."') data-toggle='modal'  data-image='".$pass_value."' id='editid$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
               } 
               echo ' <li>'.$pass_value.'</li>';
	
            echo   '<a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name("'.$pass_value.'","'.$result["supplier_id"].'","tax_documents");><span class="glyphicon glyphicon-remove"></span></a>';
        
            
             echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
         } ;
         
echo '</div>';

    echo '</div>
  </div>

 <div class="form-row"> ';
  /* <div class="form-group ">
    <label for="inputAddress">Documents of Owner</label>
     <input type="file" multiple class="form-control-file" id="upload_file2" name="upload_file2[]" onchange="preview_image2();">
	  <div class="loder col-md-1"></div>
  <div id="image_preview2" class="col-md-12"></div>   */
echo '</div></div>
  <div class="form-row">
    <div class="form-group ">
      <label for="creditperiod">Credit Period</label>
      <input type="number" class="form-control required" required id="creditperiod" placeholder="Credit Period" name="creditperiod"value="'.$result["creditperiod"].'">
    </div>
    <div class="form-group ">
      <label for="creditlimit">Credit Limit</label>
      <input type="text" class="form-control required" required id="creditlimit" placeholder="Credit Limit" name="creditlimit" value="'.$result["creditlimit"].'">
    </div>
   <div class="form-group ">
    <label for="inputAddress">Terms And Conditions</label>
    <textarea type="text" class="form-control" id="terms_and_conditions" placeholder="Terms And Conditions" name="terms_and_conditions">'.$result["terms_and_conditions"].'</textarea>
  </div>
  <div class="form-group ">
    <label for="inputAddress">Notes</label>
    <textarea type="text" class="form-control" id="notes" placeholder="Notes" name="notes">'.$result["notes"].'</textarea>
  </div>
    
  </div>
  <div class="form-group">
  <h2>Point of Contacts</h2>';
  echo '<input type="hidden" id="count" name="count" value="'.count($supp_contacts).'">';
  if(count($supp_contacts) > 0){
      
  foreach($supp_contacts as $k => $supp){
      
  
 echo  '<div class="field_wrapper row">
  <div class="form-group col-md-4 ">
      <label for="inputZip"> Name</label>
      <input type="text" class="form-control" id="point_contact_name" placeholder="Contact Name" name="point_contact_name[]" value="'.$supp["point_contact_name"].'">
    </div>
	<div class="form-group col-md-4">
      <label for="inputZip"> Number</label>
      <input type="text" class="form-control" id="point_contact_number" placeholder="Contact Number" name="point_contact_number[]" value="'.$supp["point_contact_number"].'">
    </div>
	<div class="form-group col-md-3">
      <label for="inputZip">Email</label>
      <input type="text" class="form-control" id="point_contact_email" placeholder="Email"  name="point_contact_email[]" value="'.$supp["point_contact_email"].'">
    </div>';
    if($k == 0){
	echo '<div class="form-group col-md-1"> 
      <label for="inputZip">Add More</label>
      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a>
    </div> ';
    }
   echo '<div>';
  }
  }
    
    echo '</div>
</div>
</div>
 <div class="form-group col-md-12">
    
    <input type="submit" class="btn btn-success" value="Update">
  </div>
  
  
</form>';
}
function update(){
    
    
     $supplier_id = $this->input->post('supplier_id');
   	    $images = $this->input->post('test_image');
   	    
   	    $old_imgs = $this->Supplier_Model->get_supplier_id($supplier_id);
   	   
   	    	if($old_imgs !="") $docs = array($old_imgs['trade_licence_documents']); 
				else $docs = array();
				$docs1 = $images;
				if($images != ''){
			$ov_docs = array_merge($docs,$docs1);
				}else{
				$ov_docs = $docs;
				}
		//	print_r($ov_docs); die;
   	    $mat_imgs = implode(',',$ov_docs);
   	    
   	    
   	     $tax_images = $this->input->post('test_image1');
   	    
   	    $tax_images_old = $this->Supplier_Model->get_supplier_id($supplier_id);
   	   
   	    	if($tax_images_old !="") $tax_docs = array($tax_images_old['tax_registration_document']); 
				else $tax_docs = array();
				$tax_docs1 = $images;
				if($tax_images != ''){
			$tax_reg_docs = array_merge($tax_docs,$tax_docs1);
				}else{
				$tax_reg_docs = $tax_docs;
				}
		//	print_r($ov_docs); die;
   	    $mat_imgs1 = implode(',',$tax_reg_docs);
   	    
   	    
   	     $owner_images = $this->input->post('test_image2');
   	    
   	    $owner_images_old = $this->Supplier_Model->get_supplier_id($supplier_id);
   	   
   	    	if($owner_images_old !="") $owner_docs = array($owner_images_old['owner_documents']); 
				else $owner_docs = array();
				$owner_docs1 = $owner_images;
				if($owner_images != ''){
			$owner_reg_docs = array_merge($owner_docs,$owner_docs1);
				}else{
				$owner_reg_docs = $owner_docs;
				}
		//	print_r($ov_docs); die;
   	    $mat_imgs2 = implode(',',$owner_reg_docs);
   	    
   	     $status = $this->input->post( 'status' );
					if($status != ''){
					    $stat = $status;
					}else{
					    $stat = 'off';
					}
   	    
   	  				$params = array(
					
				'companyname' => $this->input->post( 'companyname' ),
				'status' => $stat,
				'company_address' => $this->input->post( 'company_address' ),
				'contact_number_office' => $this->input->post( 'contact_number_office' ),
				'account_contact_number' => $this->input->post('account_contact_number'),
				'emailaddress' => $this->input->post( 'emailaddress' ),
				'mobile_number' => $this->input->post( 'mobile_number') ,
				'website' => $this->input->post( 'website' ),
				'country_id' => $this->input->post( 'country_id') ,
				'tax_registration' => $this->input->post('tax_registration'),
				'creditlimit' => $this->input->post('creditlimit'),
				'creditperiod' => $this->input->post('creditperiod'),
				'terms_and_conditions' => $this->input->post('terms_and_conditions'),
				'notes' => $this->input->post('notes'),
				'trade_licence_documents'=> $mat_imgs,
				'tax_registration_document'=> $mat_imgs1,
				'licence_no' => $this->input->post('licence_no'),
				'expiry_date' => $this->input->post('expiry_date'),
			//	'tax_expiry_date' => $this->input->post('tax_expiry_date'),
				//'owner_documents'=>$mat_imgs2
					); 
					 $this->Supplier_Model->update_supplier($supplier_id,$params );
					
				  $this->Supplier_Model->delete_supplier_contacts($supplier_id);	
					

					if($this->input->post('point_contact_name'))
				{
				$cnt=count($this->input->post('point_contact_name'));
					if($cnt>0){
						
						$ptcntname=$this->input->post('point_contact_name');
						$ptcntnum=$this->input->post('point_contact_number');
						$ptcntemail=$this->input->post('point_contact_email');
						for($i=0;$i<$cnt;$i++){
							
							
							$params1 = array(										
										'point_contact_name' => $ptcntname[$i],
										'point_contact_number' => $ptcntnum[$i],
										'point_contact_email' => $ptcntemail[$i],
										'supplierid' => $supplier_id);
							 $this->Supplier_Model->add_supplier_contact( $params1 );
							
						}
						
					}
				
				}
				
				
					
   	    redirect(base_url().'supplier');
}

	function view_supplier($id)
	{
		
		$result=$this->Supplier_Model->get_supplier_id($id);
	
		$data['supp_result']=$this->Supplier_Model->get_supp_contact_records($id);
		$data['result']=$result;
		$this->load->view('supplier/view_details',$data);
		

		
	}

    function img()
	{
	    
	    $id = $this->input->post('id');
	    echo "<img src='uploads/images/$id' alt='staffavatar' width='60%;' height='60%'>";
	}
		function pdf()
	{
	    
	    $id = $this->input->post('id');
	  echo "<object type='application/pdf' data='uploads/images/$id' width='100%' height='500' style='height: 85vh;' id='pdffile'>No Support</object>";
	}
	
		function delete_supp(){

		$supplier_id = $this->input->post('id');
		$data['deletesupplier'] = $this->Supplier_Model->delete_supplier($supplier_id);
	$data['delete_supp_supplier'] = $this->Supplier_Model->delete_supplier_contacts($supplier_id);
	         echo json_encode($data);
	//	redirect(base_url('material'));

	}
function delete_file(){
	    
	    $image_name = $this->input->post('val');
	    $id = $this->input->post('id');
	    $type =$this->input->post('type');
	    $data = $this->Supplier_Model->update_file($image_name,$id,$type);
	    echo json_encode($data); 
	    
	}

	function groups() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$data = $this->Customers_Model->get_groups();
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$data = $this->Customers_Model->get_groups($this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		echo json_encode( $data );
	}

	function add_group() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'customergroups', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$data[ 'group' ] = $this->Customers_Model->get_group( $id );
			if ( isset( $data[ 'group' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Customers_Model->update_group( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'delete' ) ) {
			$group = $this->Customers_Model->get_group( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Customers_Model->check_group($id) == 0) {
					$this->Customers_Model->remove_group( $id );
					$data['success'] = true;
					$data['message'] = lang('customergroup'). ' ' .lang('deletemessage');
					echo json_encode($data);
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('group').' '.lang('is_linked').' '.lang('with').' '.lang('customer').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function get_customer_groups() {
		$groups = $this->Customers_Model->get_customer_groups();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}

	function customer( $id ) {
		$data['payment'] = $this->Settings_Model->get_payment_gateway_data();
		$data[ 'title' ] = lang( 'customer' ).' '.get_number('customers', $id, 'customer', 'customer');
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		if($customer) {
			$data[ 'ycr' ] = $this->Report_Model->ycr();
			if ( isset( $customer[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
						$company = $this->input->post( 'company' );
						$namesurname = $this->input->post( 'namesurname' );
						$email = $this->input->post( 'email' );
						$default_payment_method = $this->input->post( 'default_payment_method' );
						if ( $this->input->post('type') == 'true' ) {
							$type = 1;
							$company = '';
						} else {
							$type = 0;
							$namesurname = '';
						}
						$hasError = false;
						$data['message'] = '';
						if ($company == '' && $type == 0) {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('company');
						} else if ($namesurname == '' && $type == 1) {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('customer'). ' ' .lang('name');
						} else if ($email == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('customer'). ' ' .lang('email');
						}	
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						}
						if (!$hasError) {
							$params = array(
								'company' => $company,
								'type' => $type,
								'namesurname' => $namesurname,
								'groupid' => $this->input->post( 'group_id' ),
								'ssn' => $this->input->post( 'ssn' ),
								'executive' => $this->input->post( 'executive' ),
								'address' => $this->input->post( 'address' ),
								'phone' => $this->input->post( 'phone' ),
								'email' => $this->input->post( 'email' ),
								'fax' => $this->input->post( 'fax' ),
								'web' => $this->input->post( 'web' ),
								'taxoffice' => $this->input->post( 'taxoffice' ),
								'taxnumber' => $this->input->post( 'taxnumber' ),
								'country_id' => $this->input->post( 'country_id' ),
								'state_id' => $this->input->post( 'state_id' ),
								'city' => $this->input->post( 'city' ),
								'town' => $this->input->post( 'town' ),
								'zipcode' => $this->input->post( 'zipcode' ),
								'billing_street' => $this->input->post( 'billing_street' ),
								'billing_city' => $this->input->post( 'billing_city' ),
								'billing_state_id' => $this->input->post( 'billing_state_id' ),
								'billing_zip' => $this->input->post( 'billing_zip' ),
								'billing_country' => $this->input->post( 'billing_country' ),
								'shipping_street' => $this->input->post( 'shipping_street' ),
								'shipping_city' => $this->input->post( 'shipping_city' ),
								'shipping_state_id' => $this->input->post( 'shipping_state_id' ),
								'shipping_zip' => $this->input->post( 'shipping_zip' ),
								'shipping_country' => $this->input->post( 'shipping_country' ),
								'staff_id' => $this->session->userdata( 'usr_id' ),
								'risk' => $this->input->post( 'risk' ),
								'customer_status_id' => $this->input->post( 'status_id' ),
								'default_payment_method' => $this->input->post('default_payment_method'),
							);
							$this->Customers_Model->update_customers( $id, $params );
							if ( $this->input->post( 'custom_fields' ) ) {
								$custom_fields = array(
									'custom_fields' => $this->input->post( 'custom_fields' )
								);
								$this->Fields_Model->custom_field_data_add_or_update_by_type( $custom_fields, 'customer', $id );
							}
							$data['success'] = true;
							$data['message'] = lang('customer').' '.lang('updatemessage');
							echo json_encode($data);
						}
					} else {
						$data['success'] = false;
						$data['message'] = lang( 'you_dont_have_permission' );
						echo json_encode($data);
					}
				} else {
					$data[ 'customers' ] = $this->Customers_Model->get_customers( $id );
					$this->load->view( 'customers/customer', $data );
				}
			} else {
				show_error( 'Eror' );
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
	}

	function get_group_id($name){
		$rows = $this->db->get_where('customergroups',array(''))->result_array();
		foreach($rows as $row){
			if($row['name'] = $name){
				$group_id = $row['id'];
			}
		}
		return $group_id?$group_id:'';
	}

	function customersimport () {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'create' ) ) {
			$this->load->library( 'import' );
			$data[ 'customers' ] = $this->Customers_Model->get_customers_for_import();
			$data[ 'error' ] = '';
			$config[ 'upload_path' ] = './uploads/imports/';
			$config[ 'allowed_types' ] = 'csv';
			$config[ 'max_size' ] = '1000';
			$this->load->library( 'upload', $config ); 
			if ( !$this->upload->do_upload('file') ) {
				$data[ 'error' ] = $this->upload->display_errors();
				$this->session->set_flashdata( 'ntf1', lang('csvimporterror') );
				//redirect( 'customers/index' );
			} else {
				$file_data = $this->upload->data();
				$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
				if ( $this->import->get_array( $file_path ) ) {
					$appconfig = get_appconfig();
					$csv_array = $this->import->get_array( $file_path );
					$num = 1;
					$csv_errors = array();
					foreach ( $csv_array as $row ) {
						$group_name = $row['group_name'];
						$group_id = $this->get_group_id($group_name);
						if(($row['email']=='')||($row['type']=='')){
							$num++;
							$csv_errors[] = array(
								'line' => $num,
							);
							continue;
						} else {
						$insert_data = array(
							'created' => date( 'Y-m-d H:i:s' ),
							'type' => $row[ 'type' ],
							'namesurname' => $row[ 'namesurname' ],
							'company' => $row[ 'company' ],
							'taxoffice' => $row[ 'taxoffice' ],
							'taxnumber' => $row[ 'taxnumber' ],
							'executive' => $row[ 'executive' ],
							'ssn' => $row[ 'ssn' ],
							'town' => $row[ 'town' ],
							'zipcode' => $row[ 'zipcode' ],
							'city' => $row[ 'city' ],
							'state' => $row[ 'state' ],
							'country_id' => $row[ 'country_id' ],
							'address' => $row[ 'address' ],
							'fax' => $row[ 'fax' ],
							'email' => $row[ 'email' ],
							'web' => $row[ 'web' ],
							'status_id' => $row[ 'status_id' ],
							'phone' => $row[ 'phone' ],
							'risk' => $row[ 'risk' ],
							'staff_id' => $this->session->userdata('usr_id'),
							'groupid' => $group_id,
						);
						$num++;
						$this->Customers_Model->insert_customers_csv( $insert_data );
						if($appconfig['customer_series']){
							$customer_number = $appconfig['customer_series'];
							$customer_number = $customer_number + 1 ;
							$this->Settings_Model->increment_series('customer_series',$customer_number);
							}
						}
					}
					$datas['success'] = true;
					$datas['message'] = lang('file') . ' ' . lang('csvimportsuccess') . ' ' . lang('butErrors');
					$datas['errors'] = $csv_errors;
					echo json_encode($datas);
				} else{
					$datas['success'] = false;
					$datas['message'] = lang('errormessage');
					echo json_encode($datas);
				}
			}
		} else {
			$datas['success'] = false;
			$datas['message'] = lang('you_dont_have_permission');
			echo json_encode($datas);
		}
	}

	function exportdata() {
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( ''  ) );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$this->db->select('type, created, company, namesurname, taxoffice, taxnumber, ssn, executive, address, zipcode, country_id, state, city, town, phone, fax, email, web, customer_status_id, risk,customergroups.name as group,customergroups.id as group_id');
			$this->db->join('customergroups','customers.groupid = customergroups.id','left');
			$this->db->order_by( 'customers.id', 'desc' );
			$q = $this->db->get_where( 'customers', array( 'staff_id' => $this->session->usr_id ) );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		
		$delimiter = ",";
		$nuline    = "\r\n";
		force_download('Customers.csv', $this->dbutil->csv_from_result($q, $delimiter, $nuline));
	}

	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'customer',
				'staff_id' => $this->input->post( 'staff' ),
				'addedfrom' => $this->session->userdata( 'usr_id' ),
				'date' => $this->input->post( 'date' ),
			);
			$notes = $this->Trivia_Model->add_reminder( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'reminderadded' ) . '' );
			redirect( 'customers/customer/' . $this->input->post( 'relation' ) . '' );
		} else {
			redirect( 'leads/index' );
		}
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($customer) {
			if ( $this->Privileges_Model->check_privilege( 'customers', 'delete' ) ) {
				if ( isset( $customer[ 'id' ] ) ) {
					$result = $this->Customers_Model->delete_customers( $id, get_number('customers',$id,'customer','customer'));
					$customer = lang('customer');
					if ( $result ) {
						$data['message'] = sprintf( lang( 'success_delete' ), $customer . '' );
						$data['success'] = true;
						echo json_encode($data);
					} else {
						$data['message'] = sprintf( lang( 'cant_delete' ), $customer . '' );
						$data['success'] = false;
						echo json_encode($data);
					}
				} else {
					show_error( 'Customer not deleted' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
	}

	function customers_json() {
		$customers = $this->Customers_Model->get_all_customers();
		header( 'Content-Type: application/json' );
		echo json_encode( $customers );
	}

	function customers_arama_json() {
		$veriler = $this->Customers_Model->search_json_customer();
		echo json_encode( $veriler );

	}

	function create_contact() {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$hasError = false;
				$data['message'] = '';
				if ($this->input->post( 'name' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' '.lang('name');
				} else if ($this->input->post( 'email' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage').' '.lang('email');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
						$data['success'] = false;
						$data['message'] = lang('contact').' '.lang('email_exist');
						echo json_encode($data);
					} else {
						if (($this->input->post( 'password' ) == '') && ($this->input->post( 'isPrimary' ) == 'true')) {
							$hasError = true;
							$data['message'] = lang('invalidmessage').' '.lang('password');
						}
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						} else {
							switch ($this->input->post('isPrimary')) {
								case 'true':
									$primary = 1;
									$passNew = password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT );
									break;
								case 'false':
									$primary = 0;
									$passNew = null;
									break;
							}
							switch ( $this->input->post( 'isAdmin' ) ) {
								case true:
									$isAdmin = 1;
									break;
								case false:
									$isAdmin = 0;
									break;
							}
							$params = array(
								'name' => $this->input->post( 'name' ),
								'surname' => $this->input->post( 'surname' ),
								'phone' => $this->input->post( 'phone' ),
								'extension' => $this->input->post( 'extension' ),
								'mobile' => $this->input->post( 'mobile' ),
								'email' => $this->input->post( 'email' ),
								'address' => $this->input->post( 'address' ),
								'skype' => $this->input->post( 'skype' ),
								'linkedin' => $this->input->post( 'linkedin' ),
								'customer_id' => $this->input->post( 'customer' ),
								'position' => $this->input->post( 'position' ),
								'primary' => $primary,
								'admin' => $isAdmin,
								'password' => $passNew,
							);
							$contacts_id = $this->Contacts_Model->create( $params );
							if ( $contacts_id ) {
								$permissions = $this->input->post('permissions');
								foreach ($permissions as $perm) {
									if($perm['value'] == 'true'){
										$params = array(
											'relation' => ( int )$contacts_id,
											'relation_type' => 'contact',
											'permission_id' => ( int )$perm['id'],
										);
										$this->db->insert( 'privileges', $params );
									}
								}
								$template = $this->Emails_Model->get_template('customer', 'new_contact_added');
								if ($template['status'] == 1 && $primary == 1) {
									$message_vars = array(
										'{login_email}' => $this->input->post( 'email' ),
										'{login_password}' => ($this->input->post( 'password' ))?($this->input->post( 'password' )):' ',
										'{app_url}' => '' . base_url( 'area/login' ) . '',
										'{email_signature}' => $this->session->userdata( 'email' ),
										'{name}' => $this->session->userdata( 'staffname' ),
										'{customer}' => $this->input->post( 'name' )
									);
									$subject = strtr($template['subject'], $message_vars);
									$message = strtr($template['message'], $message_vars);
									$param = array(
										'from_name' => $template['from_name'],
										'email' => $this->input->post( 'email' ),
										'subject' => $subject,
										'message' => $message,
										'created' => date( "Y.m.d H:i:s" ),
									);
									if ($this->input->post( 'email' )) {
										$this->db->insert( 'email_queue', $param );
									}
								}
								$data['success'] = true;
								$data['message'] = lang('contact').' '.lang('createmessage');
								echo json_encode($data);
							} else {
								$data['success'] = false;
								$data['message'] = lang('errormessage');
								echo json_encode($data);
							}
						}
					}
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function contact() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$hasError = false;
			$data['message'] = '';
			if ($this->input->post( 'name' ) == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('name');
			} else if ($this->input->post( 'email' ) == '') {
				$hasError = true;
				$data['message'] = lang('invalidmessage').' '.lang('email');
			}
			if ($hasError) {
				$data['success'] = false;
				echo json_encode($data);
			}
			if (!$hasError) {
				if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
					$data['success'] = false;
					$data['message'] = lang('contact').' '.lang('email_exist');
					echo json_encode($data);
				} else {
					if (($this->input->post( 'password' ) == '') && ($this->input->post( 'isPrimary' ) == 'true')) {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('password');
					}
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					} else {
						$data['success'] = true;
						$data['message'] = lang('contact').' '.lang('createmessage');
						echo json_encode($data);
					}
				}
			}
		}
	}

	function update_contact( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contacts = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contacts[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$hasError = false;
					$data['message'] = '';
					if ($this->input->post( 'name' ) == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('name');
					} else if ($this->input->post( 'email' ) == '') {
						$hasError = true;
						$data['message'] = lang('invalidmessage').' '.lang('email');
					}
					if ($hasError) {
						$data['success'] = false;
						echo json_encode($data);
					}
					if (!$hasError) {
						if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) &&  ($this->input->post( 'email' ) != $contacts['email'])) {
							$data['success'] = false;
							$data['message'] = lang('contact').' '.lang('email_exist');
							echo json_encode($data);
						} else {
							$params = array(
								'name' => $this->input->post( 'name' ),
								'surname' => $this->input->post( 'surname' ),
								'phone' => $this->input->post( 'phone' ),
								'extension' => $this->input->post( 'extension' ),
								'mobile' => $this->input->post( 'mobile' ),
								'email' => $this->input->post( 'email' ),
								'address' => $this->input->post( 'address' ),
								'skype' => $this->input->post( 'skype' ),
								'linkedin' => $this->input->post( 'linkedin' ),
								'position' => $this->input->post( 'position' ),
							);
							$this->Contacts_Model->update( $id, $params );
							$data['success'] = true;
							$data['message'] = lang('contact').' '.lang('updatemessage');
							echo json_encode($data);
						}
					}
				}
			} else { 
				show_error( 'The contacts you are trying to edit does not exist.' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function update_contact_privilege( $id, $value, $privilege_id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			if ( $value != 'false' ) {
				$params = array(
					'relation' => ( int )$id,
					'relation_type' => 'contact',
					'permission_id' => ( int )$privilege_id
				);
				$this->db->insert( 'privileges', $params );
			} else {
				$response = $this->db->delete( 'privileges', array( 'relation' => $id, 'relation_type' => 'contact', 'permission_id' => $privilege_id ) );
			}
			$data['success'] = true;
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function change_password_contact( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contact = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contact[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'password' => password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT ),
					);
					$customer = $contact[ 'customer_id' ];
					$staffname = $this->session->staffname;
					$contactname = $contact[ 'name' ];
					$contactsurname = $contact[ 'surname' ];
					$loggedinuserid = $this->session->usr_id;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $message = sprintf( lang( 'changedpassword' ), $staffname, $contactname, $contactsurname ) . '' ),
						'staff_id' => $loggedinuserid,
						'customer_id' => $customer,
					) );
					$this->Contacts_Model->update( $id, $params ); 

					// send email to contact about password change
					$template = $this->Emails_Model->get_template('staff', 'customer_password_reset');
					$message_vars = array(
						'{email}' => $contact['email'],
						'{contact}' => $contact['name'].' '.$contact['surname'],
						'{email_signature}' => $template['from_name'],
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $contact['email'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" ),
						'status' => 1
					);
					if ($contact['email']) {
						$this->db->insert( 'email_queue', $param );
					}
					$data['success'] = true;
					$data['message'] = ' ' . $contact[ 'name' ] . ' ' . lang( 'passwordchanged' ) . '';
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function remove_contact( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'customers', 'edit' ) ) {
			$contacts = $this->Contacts_Model->get_contacts( $id );
			if ( isset( $contacts[ 'id' ] ) ) {
				$this->Contacts_Model->delete( $id );
				$data['success'] = true;
				$data['message'] = lang('contactdeleted');
				echo json_encode($data);
			} else{
				show_error( 'The contacts you are trying to delete does not exist.' );
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		} 
	}
	
	function get_customer( $id ) {
		$customer = array();
		if ( $this->Privileges_Model->check_privilege( 'customers', 'all' ) ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'customers', 'own') ) {
			$customer = $this->Customers_Model->get_customers_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('customers'));
		}
		if($customer) {
			$country = get_country($customer['country_id']);
			$state = get_state_name($customer['state'], $customer['state_id']);
			$contacts = $this->Contacts_Model->get_customer_contacts( $id );
			$subsidiaries = $this->Customers_Model->get_subsidiaries( $id );
			$this->db->select_sum( 'total' );
			$this->db->from( 'invoices' );
			$this->db->where( '(status_id = 2 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$netrevenue = $this->db->get();
			$this->db->select_sum( 'total' );
			$this->db->from( 'invoices' );
			$this->db->where( '(status_id != 1 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$grossrevenue = $this->db->get();
			$data_customerdetail = array(
				'id' => $customer[ 'id' ],
				'type' => $customer[ 'type' ],
				'isIndividual' => ($customer['type'] == '1') ? true : false,
				'created' => $customer[ 'created' ],
				'staff_id' => $customer[ 'staff_id' ],
				'company' => $customer[ 'company' ],
				'namesurname' => $customer[ 'namesurname' ],
				'taxoffice' => $customer[ 'taxoffice' ],
				'taxnumber' => $customer[ 'taxnumber' ],
				'ssn' => $customer[ 'ssn' ],
				'executive' => $customer[ 'executive' ],
				'address' => $customer[ 'address' ],
				'zipcode' => $customer[ 'zipcode' ],
				'country_id' => $customer[ 'country_id' ],
				'state' => $state,
				'state_id' => $customer['state_id'],
				'city' => $customer[ 'city' ],
				'town' => $customer[ 'town' ],
				'default_payment_method' => $customer[ 'default_payment_method' ],
				'billing_street' => $customer[ 'billing_street' ],
				'billing_city' => $customer[ 'billing_city' ],
				'billing_state' => $customer['billing_state'],
				'billing_state_id' => $customer['billing_state_id'],
				'billing_zip' => $customer[ 'billing_zip' ],
				'billing_country' => $customer[ 'billing_country' ],
				'country' => $country,
				'shipping_street' => $customer[ 'shipping_street' ],
				'shipping_city' => $customer[ 'shipping_city' ],
				'shipping_state' => $customer['shipping_state'],
				'shipping_state_id' => $customer['shipping_state_id'],
				'shipping_zip' => $customer[ 'shipping_zip' ],
				'shipping_country' => $customer[ 'shipping_country' ],
				'phone' => $customer[ 'phone' ],
				'fax' => $customer[ 'fax' ],
				'email' => $customer[ 'email' ],
				'web' => $customer[ 'web' ],
				'risk' => intval( $customer[ 'risk' ] ),
				'netrevenue' => $netrevenue->row()->total,
				'grossrevenue' => $grossrevenue->row()->total,
				'subsidiaries' => $subsidiaries,
				'contacts' => $contacts,
				'chart_data' => $this->Report_Model->customer_annual_sales_chart( $id ),
				'group_name' => $customer['name'],
				'group_id' => $customer['groupid'],
				'customer_number' => get_number('customers', $customer[ 'id' ], 'customer','customer'),
				'customer_status_id' => ($customer['customer_status_id'] == 1 ? true : false),
			);
			echo json_encode( $data_customerdetail );
		}
	}
	 function form_add_image()
	 {
	
		$filename =$_FILES['file']['name'];
		$allowed =  array('png','jpg','jpeg','txt','pdf','doc','docx','xls','xlsx','txt','csv','ppt','opt');
								$filename = $_FILES['file']['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES['file']["tmp_name"];
									$profile = "uploads/images/";
									$set_img = base_url()."uploads/images/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES['file']["name"]);
									$newfilename = 'custom_file_'.rand().'.'.$ext;
									if(move_uploaded_file($tmp_name, $profile.$newfilename)){
										$Return['csrf_hash'] = $this->security->get_csrf_hash();	
										$Return['image_name'] = $newfilename;	
										$this->output($Return);
									}
									else{
									$Return['csrf_hash'] = $this->security->get_csrf_hash();	
									$Return['error'] = "This type of file doesn't allow tp upload. ";	
									$this->output($Return);
									}
									
								}else{
									$Return['csrf_hash'] = $this->security->get_csrf_hash();	
									$Return['error'] = "This type of file doesn't allow tp upload. ";	
									$this->output($Return);
								}
	 }
	 function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
}
