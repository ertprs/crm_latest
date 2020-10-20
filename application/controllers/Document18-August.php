<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Document extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Document_Model');
		
	

		
	}
	
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
			
			$data[ 'title' ] = lang( 'documents' );
			$data[ 'staff' ] = $this->Staff_Model->get_all_staff();
		
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data[ 'supplier' ] = $this->Supplier_Model->get_all_supplier();
			$data[ 'categories' ] = $this->Settings_Model->get_doccategories();
			$data[ 'unittypes' ] = $this->Settings_Model->get_mat_unittype();
			$this->load->view( 'document/index', $data );
			
			
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
		
		$result=$this->Document_Model->get_material_record($id);
		
		$data['result']=$result;
		$this->load->view('document/view_details',$data);
		
	}
	function docview($id)
	{
		
		$result=$this->Document_Model->get_material_record($id);
		//print_r($result);
		
		
		$data['result']=$result;
		$this->load->view('inc/header', $data);
		$this->load->view('document/docview',$data);
		
	}
		function img()
	{
	    
	    $id = $this->input->post('id');
	    echo "<img src='uploads/images/$id' alt='staffavatar' width='auto' height='auto'>";
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
				//print_r($_POST);
				
		
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
					 
					 
					 $status = $this->input->post( 'status' );
				/*	if($status != ''){
					    $stat = $status;
					}else{
					    $stat = 'off';
					} */
					
					$params = array(
						'created' => date( 'Y-m-d' ),
						'category' => $this->input->post( 'category' ),
				'name' => $this->input->post( 'name' ),
				'status' => $status,
				'company_name' => $this->input->post( 'company_name' ),
				'expiry_date' => $this->input->post( 'expiry_date' ),
				
				'remind_before' => $this->input->post( 'remind_before' ),
				'reminder_mail' => $this->input->post( 'reminder_mail') ,
				'contact_person' => $this->input->post( 'contact_person' ),
				'contact_number' => $this->input->post( 'contact_number' ),
				'remarks' => $this->input->post( 'remarks') ,
				'documents' => $newdata2,
				'email' => $this->input->post( 'email'),
				'staff_id' => $this->session->userdata( 'usr_id' )
				
				
					);
					//print_r($params); die;
					  $material_id = $this->Document_Model->add_docs( $params );
				/* if($material_id){
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
				} */
					
				
					redirect(base_url().'document');
					
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
   	    
   	    $old_imgs = $this->Document_Model->get_documents($material_id);
   	   
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
   	    
   	     $status = $this->input->post( 'status' );
					/* if($status != ''){
					    $stat = $status;
					}else{
					    $stat = 'off';
					} */
   	    
   	    $params = array(
				'category' => $this->input->post( 'category' ),
				'status' => $status,
	            'name' => $this->input->post( 'name' ),
				'company_name' => $this->input->post( 'company_name' ),
				'expiry_date' => $this->input->post( 'expiry_date' ),
				'remind_before' => $this->input->post( 'remind_before' ),
				'reminder_mail' => $this->input->post( 'reminder_mail') ,
				'contact_person' => $this->input->post( 'contact_person' ),
				'contact_number' => $this->input->post( 'contact_number' ),
				'remarks' => $this->input->post( 'remarks') ,
				'documents' => $mat_imgs,
				'email' => $this->input->post( 'email') ,
					'staff_id' => $this->session->userdata( 'usr_id' )
				
				);
			$response = $this->Document_Model->update_material($material_id,$params);
			
		       
   	}
   		redirect(base_url().'document');
   
    
}

function form_add_image()
	 {
	
		$filename =$_FILES['file']['name'];
		$allowed =  array('png','jpg','jpeg','txt','pdf','doc','docx','xls','xlsx','txt','csv','ppt','opt');
		//$config['allowed_types'] = $allowed;
								$filename = $_FILES['file']['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
							//	$size = '9000';
								if(in_array($ext,$allowed)){
									$tmp_name = $_FILES['file']["tmp_name"];
									$profile = "uploads/images/";
									$upload_path = base_url()."uploads/images/";
									// basename() may prevent filesystem traversal attacks;
									// further validation/sanitation of the filename may be appropriate
									$name = basename($_FILES['file']["name"]);
									$fname =  pathinfo($filename, PATHINFO_FILENAME); 
                                    $fname1 = str_replace(' ', '_', $fname);
									$newfilename = $fname1.rand().'.'.$ext;
									//$config['file_name'] = $newfilename;
									         // $this->load->library('upload',$config); 
									          	//$Return['image_name'] = $newfilename;	
									//	$this->output($Return);
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

	function add_department() {
		if ( $this->Privileges_Model->check_privilege( 'staff', 'create' ) ) {
			if (isAdmin()) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				    $mat_cat_name = $this->input->post('name');
				   $mc =  $this->Settings_Model->check_doc_category_exists($mat_cat_name);
				   if($mc['mat_cat_name'] == ''){
					$params = array(
						'doc_cat_name' => $mat_cat_name,
					);
					$department = $this->Settings_Model->add_doc_categories( $params );
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
				$departments = $this->Settings_Model->get_doc_categories( $id );
				if ( isset( $departments[ 'doc_cat_id' ] ) ) {
					if ( isset( $_POST ) && count( $_POST ) > 0 ) {
						$params = array(
							'doc_cat_name' => $this->input->post( 'name' ),
						);
						$this->session->set_flashdata('ntf1', '<span><b>' . lang('categorytupdated') . '</b></span>');
						$this->Settings_Model->update_doc_cat($id, $params);
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
		    $user_id  = $this->session->userdata( 'usr_id' );
			$staffs = $this->Document_Model->get_all_materials($user_id);
			$data_staffs = array();
			foreach ( $staffs as $staff ) {
				
			$docres=$this->Document_Model->get_material_record($staff[ 'document_id' ]);
        
        $docs = explode(",", $staff['documents']); 
        $docs_count = 0;
          foreach ($docs as $key => $pass_value) {
              if($pass_value != ''){
             $docs_count ++;
              }
          }
       

				$data_staffs[] = array(
					'id' => $staff[ 'document_id' ],
					'staffavatar' => $staff['staffavatar'],
					'name' => $staff[ 'name' ],
					'expiry_date' => $staff[ 'expiry_date' ],
					'created' => $staff['created'],
					'remarks' => $staff[ 'remarks' ],
					'documents' => $staff['documents'],
					'doc_count' => $docs_count,
					'company_name' => $staff['company_name'],
					'category' => $staff['category'],
					'staffname' => $staff['staffname'],
					'Filter By Category' =>$docres['doc_cat_name']
					
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
	    
	    $data = $this->Document_Model->update_file($image_name,$id);
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
		$result = $this->Document_Model->get_material_record($material_id);
		$materials_suppliers = $this->Material_Model->get_supp_material_records($material_id);
		$supplier = $this->Supplier_Model->get_all_supplier();
			$categories = $this->Settings_Model->get_doccategories();
		//	$unittypes = $this->Settings_Model->get_mat_unittype();
        echo '<form id="form1" method="post" action="document/update">';
        echo '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Update</h4> </div></div>';
        echo '<hr></hr>';
        echo '<input type="hidden" name="material_id" id="material_id"  value="'.$material_id.'" >';
         echo '<div class="outerDivFull" >';
		 if($result["status"] == 'on'){
		echo  '<input type="radio" id="switch" name="status" checked> <label>Public</label> &nbsp;&nbsp;&nbsp;&nbsp;
		    <input type="radio" id="switch" name="status" value="off"> <label>Confidential</label> ';
		 } else { 
		  	echo  '<input type="radio" id="switch" name="status"  > <label>Public</label> &nbsp;&nbsp;&nbsp;&nbsp;
		    <input type="radio" id="switch" name="status" value="off" checked> <label>Confidential</label> ';   
		 }
   echo '</div>';
		echo '</div>';
     echo  '<div class="form-group"> <label for="category">Category</label><select class="form-control" id="category" name="category" required><option value="" > Select..</option>';
	 if(isset($categories)){
		foreach($categories as $eachCat){
		      $selected = '';
		       if($result["category"] == $eachCat['doc_cat_id']){
										  $selected = "selected";
									}
	echo '<option value="'.$eachCat['doc_cat_id'].'" ' . $selected. '>'.$eachCat['doc_cat_name'].'</option>';
		 }
	 }
   echo '</select></div>';
   echo '<div class="form-group"><label for="exampleInputPassword1">Name or Number</label><input type="text" class="form-control" id="name" placeholder="Name or Number" name="name" value="'.$result["name"].'" onchange="select_code(this.value)"  required></div>';
   echo '<div class="form-group"><label for="">Expiry Date</label><input type="date" class="form-control" id="expiry_date"  name="expiry_date" value="'.$result["expiry_date"].'" required></div>';
echo '<div><hr style="height:2px;border-width:0;color:blue;background-color:black"></div>';
echo '<div class="form-group"><label for="itemname">Authorised Company Name</label><input type="text" class="form-control" id="company_name" placeholder="Authorised Company Name" name="company_name" value="'.$result["company_name"].'" required></div>';



echo '<div class="form-group"><label for="exampleInputPassword1">Contact Person</label><input id="contact_person" type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="'.$result["contact_person"].'" required></div>';
 
  echo '<div class="form-group"><label for="exampleInputPassword1">Contact Number</label><input type="text" class="form-control" id="contact_number" placeholder="Contact Number" name="contact_number" value="'.$result["contact_number"].'" required>
  </div>';
  
   echo  '<div class="form-group"><label for="exampleInputPassword1">Email</label><input type="email" class="form-control" id="email" placeholder="Email" name="email" value="'.$result["email"].'" required></div>';
  
  echo '<div class="form-group"><label for="exampleInputPassword1">Remind Bef</label><input type="text" class="form-control" id="remind_before" placeholder="Remind Before" name="remind_before" value="'.$result["remind_before"].'" required>
  </div>';
  echo '<div class="form-group"><label for="exampleInputPassword1">Reminder Mail</label><input type="text" class="form-control" id="reminder_mail" placeholder="Reminder Mail" name="reminder_mail" value="'.$result["reminder_mail"].'" required >
  </div>';
   
   echo '<div><hr style="height:2px;border-width:0;color:blue;background-color:black"></div>';
  
echo '<div class="form-group">
    <label for="exampleInputPassword1">Remarks</label>
    <input type="text" class="form-control" id="remarks" placeholder="Remarks" name="remarks" value="'.$result['remarks'].'">
  </div>';
  echo   '<div class="form-group col-md-2">';
//if($result["documents"]) {
          $psp = str_replace(',','',$result["documents"]);
        
        $passport_doc = explode(",", $result["documents"]); 
        $pass_count = 0;
          foreach ($passport_doc as $key => $pass_value) {
              if($pass_value != ''){
             $pass_count ++;
              }
          }
//}
       if($pass_count == 0){
  echo '<div class="form-group">
    <label for="exampleInputPassword1">Attachment</label>
    <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();" required>
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
  </div> ';
  
       }else{
           echo '<div class="form-group">
    <label for="exampleInputPassword1">Attachment</label>
    <input type="file" multiple class="form-control-file" id="upload_file" name="upload_file[]" onchange="preview_image();" >
  <div class="loder col-md-1"></div>
  <div id="image_preview" class="col-md-12"></div> 
  </div> ';
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
	
            echo   '<a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name("'.$pass_value.'","'.$result["document_id"].'");><span class="glyphicon glyphicon-remove"></span></a>';
        
            
             echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
        // } ;
         
echo '</div>';
  echo ' <input type="submit" class="btn btn-success col-md-12"  value="Update">
</form>'; 

	//	redirect(base_url('material'));

	}
	
	function delete_mat(){

		$material_id = $this->input->post('id');
		$data['deletematerial'] = $this->Document_Model->delete_material($material_id);
	
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
				$departments = $this->Settings_Model->get_doc_categories( $id );
				if ( isset( $departments[ 'doc_cat_id' ] ) ) {
					//$result2=$this->Settings_Model->check_material_record($id);
					$result2 = '';
					if (empty($result2)) {
						$this->Settings_Model->delete_doc_cat($id);
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