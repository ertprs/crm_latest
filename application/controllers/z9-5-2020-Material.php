<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Material extends CIUIS_Controller {

	function index() {
		
		$path = $this->uri->segment( 1 );
		/*
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} else {
			*/
			//print_r($this->session->userdata());
			$data[ 'title' ] = lang( 'material' );
			$data[ 'staff' ] = $this->Staff_Model->get_all_staff();
		
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data[ 'supplier' ] = $this->Supplier_Model->get_all_supplier();
			$data[ 'categories' ] = $this->Settings_Model->get_matdepartments();
			$data[ 'unittypes' ] = $this->Settings_Model->get_mat_unittype();
			$this->load->view( 'material/index', $data );
			
			
		//}
	} 
	function refresh_staff()
	{
		$data[ 'supplier' ] = $this->Supplier_Model->get_all_supplier();
		$this->load->view( 'material/staff_refresh', $data );
	}
	function add_supplier_price()
	{
		
		$this->session->unset_userdata(array('supplier_name', 'shortname', 'price', 'supplier_id'));
		if(empty($_POST['supplier_id'])){
			$params = array(
						'created' => date( 'Y-m-d' ),
						'companyname' => $_POST['supplier']);
			$supplier_id = $this->Supplier_Model->add_supplier( $params );
			
		}else{
		$this->session->set_userdata(array(
			'supplier_name'  => $_POST['supplier'],
			'shortname' =>$_POST['shortname'],
			'price'  => $_POST['price'],
			'supplier_id'=>$_POST['supplier_id']
			
				)); 
		

		}
	}
	function form_supplier($id)
	{
		
		$result=$this->Supplier_Model->get_supplier_id($id);
		
		echo ' <form id="formsupplier" method="post"><div class="row"><div class="form-group col-sm-6"><label for="exampleInputFile">Supplier</label> <input type="text" name="supplier" placeholder="Enter Supplier" id="email" title="Supplier" aria-describedby="" class="form-control" value="'.$result['companyname'].'"> <!----></div> <div class="form-group col-sm-6"><label for="exampleInputFile">Supplier Ref Code</label> <input type="text" name="shortname" placeholder="Enter Short Name" id="short-name" title="Short Name" aria-describedby="" class="form-control"> <!----></div> <div class="form-group col-sm-6"><label for="exampleInputFile">Price</label> <input type="text" name="price" placeholder="price" id="price" title="Price" aria-describedby="" class="form-control"> <!----></div></div><input type="hidden" value="'.$id.'" name="supplier_id" id="supplier_id"></form>';
	}
	function view_material($id)
	{
		
		$result=$this->Material_Model->get_material_record($id);
		$supp_result = $this->Material_Model->get_supp_material_records($id);
				$data['supp_result']=$this->Material_Model->get_supp_material_records($id);
		$data['result']=$result;
		$this->load->view('material/view_details',$data);
		
	/*
		echo '<div class="col-sm-12"><b>Item Description:</b>'.$result["itemdescription"].'</div>';
	
	  echo "<div class='col-sm-12'><div class='col-sm-6'><b>Category:</b>&nbsp;&nbsp;$result[mat_cat_name]</div><div class='col-sm-6'><b>Created:</b>&nbsp;&nbsp;$result[created]</div></div>";
	  
	   echo "<div class='col-sm-12 row'>";
	   if($result['margin_type'] == 'percentage'){ 
	        echo  "<div class='col-sm-6'><b>Margin Percentage:</b>&nbsp;&nbsp;$result[margin_value]</div>";
	    }
	    else{
	 	      echo "<div class='col-sm-6'><b>Margin Percentage:</b></div>";
	 	 }
	 	 if($result['margin_type'] == 'fixed'){ 
	        echo  "<div class='col-sm-6' ><b>Margin Fixed:</b>&nbsp;&nbsp;$result[margin_value]</div>";
	    }
	    else{
	 	      echo "<div class='col-sm-6'><b>Margin Fixed:</b></div>";
	 	 }
	 	 echo "</div>";
	 	 
             echo  "<div class='col-sm-12'><div class='col-sm-6'><b>Last Selling Price:</b>&nbsp;&nbsp;$result[last_selling_price]</div></div>";



	//echo '<table> <thead>';
	echo '<th colspan="6"><h2 style=background-color:lightblue">Supplier</h2></th>';
	 echo "</thead><div class='col-sm-18'><div class='col-sm-4'><b>Supplier Name</b></div><div class='col-sm-4'><b>Ref Code</b></div><div class='col-sm-2'><b>Price</b></div></div>";foreach($supp_result as $supp) { 
	      echo "<tr><td><div class='col-sm-4'>$supp[companyname]</div></td>";
	    echo "<td><div class='col-sm-4'>$supp[supplier_ref]</div></td>";
	 echo "<td><div class='col-sm-2'>$supp[supplier_price]</div></td> </tr>"; 
	     
	 }
	// echo '</tbody></table>';

    	echo '<th colspan="6"><h2 style="background-color:lightblue">Documents View</h2></th>';
    	echo   '<div class="form-group col-md-2">';
if($result["documents"]) {
          $psp = str_replace(',','',$result["documents"]);
        
        $passport_doc = explode(",", $result["documents"]); 
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
	
               echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
         } ;
         
echo '</div>';
*/
		
		
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
	function form_supplier_new()
	{
		
		
		echo ' <form id="formsupplier" method="post"><div class="row"><div class="form-group col-sm-6"><label for="exampleInputFile">Supplier</label> <input type="text" name="supplier" placeholder="Enter Supplier" id="email" title="Supplier" aria-describedby="" class="form-control" value=""> <!----></div></div></form>';
	}
	function create() {
			
				
		if ( $this->Privileges_Model->check_privilege( 'material', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				
		//	print_r($_POST); die;
				$hasError = false;
				
				if (!$hasError) {
					$appconfig = get_appconfig();
					$newdata2='';
				
					 if(isset($_POST['test_image']) && (!empty($_POST['test_image']))){
					    $cnt=count($_POST['test_image']);
							if($cnt>0){
								
					        	$newdata2 = implode(',', $this->input->post('test_image'));
							}
					 }
					 $value='';
					if($this->input->post( 'margin_type' )=='percentage'){
						$value=$this->input->post( 'percentage' );
					}else if($this->input->post( 'margin_type' )=='percentage'){
						$value=$this->input->post( 'margin_selling_price' );
					}
					$other_val  = $this->input->post('others');
					if($other_val != ''){
					    $others = $other_val;
					    $item_code = $this->input->post( 'item_code' );
					}else{
					    $others = 'off';
					    $item_code = '';
					}
					$params = array(
						'created' => date( 'Y-m-d' ),
						'category' => $this->input->post( 'category' ),
				'item_code' => $item_code,
				'itemname' => $this->input->post( 'itemname' ),
				'itemdescription' => $this->input->post( 'itemdescription' ),
				
				'unittype' => $this->input->post( 'unittype' ),
				'cost' => $this->input->post( 'cost') ,
				'last_selling_price' => $this->input->post( 'last_selling_price' ),
				'remarks' => $this->input->post( 'remarks') ,
				'documents'=>$newdata2,
				'margin_type' => $this->input->post( 'margin_type') ,
				'margin_value'=>$value,
				'others' => $others
				
					);
					
					  $material_id = $this->Material_Model->add_material( $params );
				if($material_id){
					$supp_data = $this->input->post('supp');
					
					 
					
				
								foreach(array_filter($supp_data['supplier']) as $k => $supplier_id){
									
								    if($supplier_id !='-1'){
										
								        $supplier_id = $supplier_id;
								    }
								    else{
										
								        	$spparams = array(
						                    'created' => date( 'Y-m-d' ),
						                    'companyname' => $supp_data['newsupplier'][$k]);
								        $supplier_id = $this->Supplier_Model->add_supplier( $spparams );
			
							 	        
								    }
									$params1 = array(										
										
										'supplier_id' => $supplier_id,
										'supplier_ref' => $supp_data['shortname'][$k],
										'supplier_price' => $supp_data['price'][$k],
										'material_id' => $material_id );
										
							 $this->Material_Model->add_material_supplier( $params1 );
					}
				
				//	$this->Material_Model->delete_supp();
				}
					
				
					redirect(base_url().'material');
					
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

function update(){
    
 // echo '<pre>'; print_r($_POST); die;
   	if ( isset( $_POST ) && count( $_POST ) > 0 ) {
   	    
   	    $material_id = $this->input->post('material_id');
   	    $images = $this->input->post('test_image');
   	    
   	    $old_imgs = $this->Material_Model->get_documents($material_id);
   	   
   	    	if($old_imgs !="") $docs = array($old_imgs->documents); 
				else $docs = array();
				$docs1 = $images;
				if($images != ''){
			$ov_docs = array_merge($docs,$docs1);
				}else{
				$ov_docs = $docs;
				}
		//	print_r($ov_docs); die;
   	    $mat_imgs = implode(',',$ov_docs);
   	    $other_val = $this->input->post('others');
   	    if($other_val != ''){
   	        $others = $other_val;
   	        	$item_code = $this->input->post( 'item_code' );
   	    }else{
   	        $others = 'off';
   	        $item_code = '';
   	    }
   	    //print_r($mat_imgs); die;
   	    $params = array(
				'category' => $this->input->post( 'category' ),
				'item_code' => $item_code,
				'itemname' => $this->input->post( 'itemname' ),
				'others' => $others,
				'itemdescription' => $this->input->post( 'itemdescription' ),
				'unittype' => $this->input->post( 'unittype' ),
				'documents' => $mat_imgs,
				
				'cost' => $this->input->post( 'cost') ,
				'last_selling_price' => $this->input->post( 'last_selling_price' ),
				'remarks' => $this->input->post( 'remarks') ,
			
				'margin_type' => $this->input->post( 'margin_type') ,
				'margin_value'=> $this->input->post('margin_selling_price')
					);
					
		    		
			$response = $this->Material_Model->update_material($material_id,$params);
			
		        $this->Material_Model->delete_supplier_material($material_id);
			
				$supp_data = $this->input->post('supp');
					//print_r(($supp_data)); die;
					if(!empty($supp_data)){   
				
				foreach(array_filter($supp_data['supplier']) as $k => $supplier_id){
								  
								   //if(is_numeric($supplier_id)){
									   if($supplier_id !='-1'){
								        $supplier_id = $supplier_id;
								    }
								    else{
								        	$spparams = array(
						                    'created' => date( 'Y-m-d' ),
						                    'companyname' => $supp_data['newsupplier'][$k]);
								        $supplier_id = $this->Supplier_Model->add_supplier( $spparams );
			
								        
								    }
								  
					$params1 = array(										
										
										'supplier_id' => $supplier_id,
										'supplier_ref' => $supp_data['shortname'][$k],
										'supplier_price' => $supp_data['price'][$k],
										'material_id' => $material_id );
										
							 $this->Material_Model->add_material_supplier( $params1 );
					}
					
					}
				
					
   	    
   	}
   		redirect(base_url().'material');
   
    
}

	function add_department() {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'create' ) ) {
			if (isAdmin()) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				    $mat_cat_name = $this->input->post('name');
				   $mc =  $this->Settings_Model->check_material_category_exists($mat_cat_name);
				   if($mc['mat_cat_name'] == ''){
					$params = array(
						'mat_cat_name' => $mat_cat_name,
					);
					$department = $this->Settings_Model->add_material_categories( $params );
					$data['message'] = lang('category').' '.lang('addmessage');
					$data['success'] = true;
				   }else{
				       
				       $data['message'] = 'Already by this name category exists';
						$data['success'] = false;
				   }
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('create'). ' '.lang('category');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}
	
	function add_unit() {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'create' ) ) {
			if (isAdmin()) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				    $unit_name = $this->input->post( 'name' );
				     $unit =  $this->Settings_Model->check_material_unit_exists($unit_name);
				     if($unit['unit_name'] == ''){
					$params = array(
		'unit_name' 	=> $unit_name,
					);
					$department = $this->Settings_Model->add_unit_types( $params );
					$data['message'] = lang('unit').' '.lang('addmessage');
					$data['success'] = true;
				     }else{
				         $data['message'] = 'Already by this name unit exists';
						$data['success'] = false;
				     }
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('create'). ' '.lang('unit');
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_department( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'edit' ) ) {
			if (isAdmin()) {
				$departments = $this->Settings_Model->get_material_categories( $id );
				if ( isset( $departments[ 'mat_cat_id' ] ) ) {
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
						$params = array(
							'mat_cat_name' => $this->input->post( 'name' ),
						);
						$this->session->set_flashdata('ntf1', '<span><b>' . lang('categorytupdated') . '</b></span>');
						$this->Settings_Model->update_mat_cat($id, $params);
						$data['message'] = lang('category').' '.lang('updatemessage');
						$data['success'] = true;
						echo json_encode($data);
					}
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('update'). ' '.lang('department');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function update_unit( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'edit' ) ) {
			if (isAdmin()) {
				$departments = $this->Settings_Model->get_unit( $id );
				if ( isset( $departments[ 'unit_type_id' ] ) ) {
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
						$params = array(
							'unit_name' => $this->input->post( 'name' ),
						);
						$this->session->set_flashdata('ntf1', '<span><b>' . lang('update') . '</b></span>');
						$this->Settings_Model->update_unit_type($id, $params);
						$data['message'] = lang('unit').' '.lang('updatemessage');
						$data['success'] = true;
						echo json_encode($data);
					}
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('update'). ' '.lang('department');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}


	function get_all_materials() {
		if ( $this->Privileges_Model->check_privilege( 'material', 'all' ) ) {
			$staffs = $this->Material_Model->get_all_materials();
			$data_staffs = array();
			foreach ( $staffs as $staff ) {
				
			
        
        $docs = explode(",", $staff['documents']); 
        $docs_count = 0;
          foreach ($docs as $key => $pass_value) {
              if($pass_value != ''){
             $docs_count ++;
              }
          }
       

				$data_staffs[] = array(
					'id' => $staff[ 'material_id' ],
					'name' => $staff[ 'item_code' ],
					'itemname' => $staff[ 'itemname' ],
					'itemdescription' => $staff[ 'itemdescription' ],
					'remarks' => $staff[ 'remarks' ],
					'unit' => $staff[ 'unit_name' ],
					'cost' => $staff[ 'cost' ],
					'documents' => $staff['documents'],
					'doc_count' => $docs_count
					
				);
			};
			echo json_encode( $data_staffs );
		}
	}
	

     function delete(){
         $id = $this->input->post('id');
         $data = $this->Staff_Model->delete_other_documents($id);
         echo json_encode($data);
     }
     
    
	function view($id){
		$data['title'] = lang( 'Material View' );
		$data['materials'] = $this->Material_Model->get_material_record($id);
		$data['materials_suppliers'] = $this->Material_Model->get_all_suppliers_material($id);
		$data[ 'supplier' ] = $this->Supplier_Model->get_all_supplier();
			$data[ 'categories' ] = $this->Settings_Model->get_matdepartments();
			$data[ 'unittypes' ] = $this->Settings_Model->get_mat_unittype();
		$this->load->view('material/view',$data);

	}
	function delete_file(){
	    
	    $image_name = $this->input->post('val');
	    $id = $this->input->post('id');
	    
	    $data = $this->Material_Model->update_file($image_name,$id);
	    echo json_encode($data); 
	    
	}

	function update_stauts($id,$type,$status){
		if($type == 1) {
			 $data = array('passport_status' => $status );
			 $this->Staff_Model->update_staff_stauts( $id, $data ); 
		} 

		if($type == 2) {
			 $data = array('pin_status' => $status );
			 $this->Staff_Model->update_staff_stauts( $id, $data ); 
		}

		if($type == 3) {
			$new_status = $status == 1 ? 5 : 1; 
			 $data = array('status' => $new_status  );
			 $this->Staff_Model->update_staff_stauts( $id, $data ); 
		}
		//echo $this->db->last_query();
	}
	function edit_mat(){

		$material_id = $this->input->post('id');
		$result = $this->Material_Model->get_material_record($material_id);
		$materials_suppliers = $this->Material_Model->get_supp_material_records($material_id);
		$supplier = $this->Supplier_Model->get_all_supplier();
			$categories = $this->Settings_Model->get_matdepartments();
			$unittypes = $this->Settings_Model->get_mat_unittype();
        echo '<form id="form1" method="post" action="material/update">';
        echo '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Update</h4> <div class="outerDivFull" ><div class="switchToggle">';
        if($result["others"] == 'on'){
    echo '<input type="checkbox" id="switch" name="others" checked onclick="select_switch();"><label for="switch">Toggle</label>';
        } else {
             echo '<input type="checkbox" id="switch" name="others" onclick="select_switch();"><label for="switch">Toggle</label>';
        }
   
echo '</div></div></div>';
        echo '<hr></hr>';
        echo '<input type="hidden" name="material_id" id="material_id"  value="'.$material_id.'" >';
     echo  '<div class="form-group"> <label for="category">Category</label><select class="form-control" id="category" name="category" required><option value="" > Select..</option>';
	 if(isset($categories)){
		foreach($categories as $eachCat){
		      $selected = '';
		       if($result["category"] == $eachCat['mat_cat_id']){
										  $selected = "selected";
									}
	echo '<option value="'.$eachCat['mat_cat_id'].'" ' . $selected. '>'.$eachCat['mat_cat_name'].'</option>';
		 }
	 }
   echo '</select></div>';
  // if($result['others'] == 'on'){ 
        
    echo '<div class="form-group code"><label for="exampleInputPassword1">Item Code</label><input type="text" class="form-control"  placeholder="Item Code" name="item_code" id="item_code" value="'.$result["item_code"].'"></div>';
//}
echo ' <div class="form-group">
    <label for="itemname">Item Name</label>
    <input type="text" class="form-control" id="itemname" placeholder="Item Name" name="itemname" required value="'.$result["itemname"].'">
  </div>';
 echo  '<div class="form-group">
    <label for="">Item Description</label>
	<textarea class="form-control" id="itemdescription" rows="3" name="itemdescription" required>'.$result["itemdescription"].'</textarea>
  </div>';
  echo  '<div class="form-group"><label for="exampleInputPassword1">Unit Size</label><select class="form-control" id="unittype" name="unittype" required>';
 if(isset($unittypes)){
   
		foreach($unittypes as $eachUnit){
		       $selected = '';
									 if($result["unittype"] == $eachUnit["unit_type_id"]){
										  $selected = "selected";
									}
	echo 	'<option value="'.$eachUnit["unit_type_id"].'" ' . $selected. '>'. $eachUnit["unit_name"].'</option>';
		 }
	}
   echo '</select></div>';
    echo '<div class="form-group">
    <label for="exampleInputPassword1">Cost ( AED )</label>
    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="'.$result["cost"].'" required onchange="add_cost(this.value)">
  </div>';
 
 $checked = '';
 if($result["margin_type"] == 'percentage') { 
     $checked = "checked";
   
 }
 
 $checked1 = '';
 if($result["margin_type"] == 'fixed') { 
     $checked1 = "checked";
    
 }
 
 
 echo  '<div class="form-group">';
 echo '<label class="radio-inline"><input type="radio" name="margin_type" '.$checked.' value="percentage" id="per" onclick=change_margin("percentage"); >Percentage</label>
<label class="radio-inline"><input type="radio" name="margin_type" '.$checked1.' value="fixed" id="fix"  onclick=change_margin("fixed");  >Fixed</label>
</div>';
 
echo '<div class="form-group" id="percentage">
    <label for="exampleInputPassword1">Margin / Selling Price Percentage</label>
     <div class="input-group">
    <span class="input-group-addon">%</span>';
    if($result["margin_type"] == 'percentage') { 
    echo '<input id="percentage" type="text" class="form-control" name="margin_selling_price" placeholder="Margin Percentage" value="'.$result["margin_value"].'">';
    }
    else{
         echo '<input id="percentage" type="text" class="form-control" name="margin_selling_price" placeholder="Margin Percentage" value=0>';
    }
echo '</div>
  </div> ';

 
   echo '<div class="form-group" id="fixed" >
    <label for="exampleInputPassword1">Margin / Selling Price Fixed</label>';
     if($result["margin_type"] == 'fixed') { 
    echo '<input type="text" class="form-control" id="margin_selling_price" placeholder="Margin Fixed" name="margin_selling_price" value="'.$result["margin_value"].'"> ';
     } else {
         
         echo '<input type="text" class="form-control" id="margin_selling_price" placeholder="Margin Fixed" name="margin_selling_price" value=> ';
     }
    
  echo '</div>';

  

echo  '<div class="form-group">
    <label for="exampleInputPassword1">Last Selling Price</label>
    <input type="text" class="form-control" id="last_selling_price" placeholder="Last Selling Price" name="last_selling_price" value="'.$result["last_selling_price"].'">
  </div>';
echo '<div class="form-group">
    <label for="exampleInputPassword1">Remarks</label>
    <input type="text" class="form-control" id="remarks" placeholder="Remarks" name="remarks" value="'.$result['remarks'].'">
  </div>';
  echo '<div class="form-group">
    <label for="exampleInputPassword1">Attachment</label>
    <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();">
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
  </div> ';
echo   '<div class="form-group col-md-2">';
if($result["documents"]) {
          $psp = str_replace(',','',$result["documents"]);
        
        $passport_doc = explode(",", $result["documents"]); 
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
	
            echo   '<a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name("'.$pass_value.'","'.$result["material_id"].'");><span class="glyphicon glyphicon-remove"></span></a>';
        
            
             echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
         } ;
         
echo '</div>';
 echo '<div class="form-group col-md-12">';
echo '<input type="hidden" id="count" name="count" value="'.count($materials_suppliers).'">';
 foreach($materials_suppliers as $k => $mat) {
    echo '<div class="field_wrapper1 row "><div id="div1" class="col-md-4 form-group " ><label for="exampleInputPassword1">Supplier</label>';  
	echo ' <input type="text" class="form-control typeahead" data-provide="typeahead" data-hidden-field-id="supplier_hidden_id'.$k.'" name="supp[newsupplier][]" id="supplier'.$k.'" placeholder="Enter Supplier" autocomplete="off" value="'.$mat["companyname"].'"/>
        <input type="hidden" name="supp[supplier][]" id="supplier_hidden_id'.$k.'" autocomplete="off" value="'.$mat["supplier_id"].'"/>  
		';
 
  echo  '</div>'; 
		echo  '<div class="form-group col-md-4 "><label for="exampleInputFile">Ref Code</label><input type="text" name="supp[shortname][]" placeholder="Enter Short Name" id="short-name" title="Short Name" aria-describedby="" class="form-control"  value="'.$mat["supplier_ref"].'">
        </div> <div class="form-group col-md-3 "><label for="exampleInputFile">Price</label><input type="text" name="supp[price][]" placeholder="price" id="price" title="Price" aria-describedby="" class="form-control" value="'.$mat["supplier_price"].'"></div><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle text-danger" style="font-size: 20px;"></i></a></div>
	   
		
		
	
  </div> ';
  echo '<script>$(document).ready(function(){$("#supplier'.$k.'").typeahead({source: function (query, process) {$.ajax({url: "'.base_url().'supplier/get_supplier_list",data: "str=" + query, dataType: "json",type: "POST",success: function (data) { if(data == "0"){$("#supplier_hidden_id'.$k.'").val("-1");}else{ map = {}; states = [];$.each(data, function (i, state) { map[state.name] = state; states.push(state.name);}); process(states); }}  });  },matcher: function (item) {if (item.toLowerCase().indexOf(this.query.trim().toLowerCase()) != -1) { return true;}},  updater: function (item) {SelectedCode=map[item].id;SelectedCityName=map[item].name;var hiddenFieldId = this.$element.data("hiddenFieldId");$(`#${hiddenFieldId}`).val(SelectedCode);return SelectedCityName;}, });$(".field_wrapper1").on("click", ".remove_button", function(e){ $(this).parent("div").remove(); return false; });});</script>';  
    
  } 
echo '
   <div class="field_wrapper row"> <div></div>';
	
echo '</div>
</div>';
echo '<div class="form-group col-md-6"><a href="javascript:void(0);" class="add_button1" title="Add field"><i class="fa fa-plus-circle text-success" style="font-size: 24px;"></i></a> <label for="inputZip">Add More Suppliers</label></div>';
 echo ' <input type="submit" class="btn btn-success col-md-12"  value="Update">
</form>'; 

	//	redirect(base_url('material'));

	}
	
	function delete_mat(){

		$material_id = $this->input->post('id');
		$data['deletematerial'] = $this->Material_Model->delete_material($material_id);
	$data['delete_supp_material'] = $this->Material_Model->delete_supplier_material($material_id);
	         echo json_encode($data);
	//	redirect(base_url('material'));

	}
	function validate_itemcode(){
	    $item_code = $this->input->post('item_code');
	    $code = $this->Material_Model->get_item_code($item_code);
	    $data['item_code'] = $code['item_code'];
	   
	    echo json_encode($data);
	    
	}
		function remove_department( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'delete' ) ) {
			if (isAdmin()) {
				$departments = $this->Settings_Model->get_material_categories( $id );
				if ( isset( $departments[ 'mat_cat_id' ] ) ) {
					$result2=$this->Settings_Model->check_material_record($id);
					if (empty($result2)) {
						$this->Settings_Model->delete_mat_cat($id);
						$data['message'] = lang('category').' '.lang('deletemessage');
						$data['success'] = true;
						echo json_encode($data);
					} else {
						$data['message'] = lang('category').' '.lang('is_linked').' '.lang('with').' '.lang('category').', '.lang('so').' '.lang('cannot_delete').' '.lang('category');
						$data['success'] = false;
						echo json_encode($data);
					}
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('delete'). ' '.lang('category');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function remove_unit( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'delete' ) ) {
			if (isAdmin()) {
				$departments = $this->Settings_Model->get_material_unit( $id );
				if ( isset( $departments[ 'unit_type_id' ] ) ) {
					$result2=$this->Settings_Model->check_unit_material_record($id);
					if (empty($result2)) {
						$this->Settings_Model->delete_mat_unit($id);
						$data['message'] = lang('unit').' '.lang('deletemessage');
						$data['success'] = true;
						echo json_encode($data);
					} else {
						$data['message'] = lang('unit').' '.lang('is_linked').' '.lang('with').' '.lang('unit').', '.lang('so').' '.lang('cannot_delete').' '.lang('unit');
						$data['success'] = false;
						echo json_encode($data);
					}
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('only_admin'). ' '.lang('delete'). ' '.lang('unit');
				echo json_encode($data);
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}


}