<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Mrequests extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		$this->load->model('Requests_Model');
		$this->load->model('Mrequests_Model');
			$this->load->model('Products_Model');
			$this->load->model('Staff_Model');
			$this->load->model('Vendors_Model');
			$this->load->model('Billrequests_Model');
		/* if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		} */
	}

	function index() {
		$data[ 'title' ] = lang( 'requests' );
		$data[ 'tickets' ] = $this->Tickets_Model->get_all_tickets();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'mrequests/index', $data );
	}

	function create() {
		//echo '<pre>'; print_r($_POST); die;
		$data[ 'title' ] = 'Requests';
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$request_type = $this->input->post('request_type');
			$user_id = $this->session->userdata( 'usr_id' );
			if($request_type == '1') {
		$mname = $this->input->post( 'material_name' );
		$project = $this->input->post( 'project' );
		//print_r($project); die;
		$project_id = $this->input->post( 'project_id' );
		$qty = $this->input->post('qty');
		$unit_type = $this->input->post('unit_type');
		$remarks = $this->input->post('remarks');
		$priority = $this->input->post('priority');
		
 		$params = array(
						'project_id' => $project_id,
						'project' => $project,
						'mname' => $mname,
						'qty' => $qty,
						'unit_type' => $unit_type,
						'remarks' => $remarks,
						'priority' => $priority,
						'user_id' => $user_id,
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' )
						
					);
					
					$this->db->insert('material_req', $params );
					
					$material_id = $this->db->insert_id();
					$mat = $this->Mrequests_Model->get_product_name($mname);
					$req_params = array(
					'request_type' =>$request_type, 
					'name' => $mat['productname'],
					'request_id' => $material_id,
					'user_id' => $user_id,
					'status' => 0,
					'created' => date( 'Y-m-d ' )
 					
					) ;
					
					$this->db->insert('all_req', $req_params );
			}
			else if($request_type == '2'){
				$employee_id  = $this->input->post( 'employee_id' );
		$type_of_leave = $this->input->post( 'type_of_leave' );
		$leave_start_date = $this->input->post( 'leave_start_date' );
		$rejoin_date = $this->input->post( 'rejoin_date' );
		$no_of_days = $this->input->post( 'no_of_days' );
		$user_id = $this->session->userdata( 'usr_id' );
 		
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_leave' => $type_of_leave,
						'leave_start_date' => date('Y-m-d',strtotime($leave_start_date)),
						'rejoin_date' => date('Y-m-d',strtotime($rejoin_date)),
						'no_of_days' => $no_of_days,
						'user_id' => $user_id,
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'leave_requests', $params );
					$leave_id = $this->db->insert_id();
					$req_params = array(
					'request_type' =>$request_type, 
					'name' => $type_of_leave,
					'request_id' => $leave_id,
					'user_id' => $user_id,
					'status' => 0,
					'created' => date( 'Y-m-d ')
 					
					) ;
					
					$this->db->insert('all_req', $req_params );
				
			}
			else if($request_type == '3'){
					$vendor_id = $this->input->post( 'vendor_id' );
		$bill_date = $this->input->post('bill_date');
		$reference = $this->input->post('reference');
		$amount = $this->input->post('amount');
		$vendor = $this->Billrequests_Model->get_vendor_name($vendor_id);
		$user_id = $this->session->userdata( 'usr_id' );
		if($vendor == ''){
			$params = array('company' => $vendor_id);
			$this->db->insert( 'vendors', $params );
		}
 		$params = array(
						'vendor_id' => $vendor_id,
						'bill_date' => date('Y-m-d',strtotime($bill_date)),
						'reference' => $reference,
						'amount' => $amount,
						'user_id' => $user_id,
						'status' => 1,
						'created' => date( 'Y-m-d' ), 
						
					);
					$this->db->insert( 'bill_requests', $params );
		
					$bill_id = $this->db->insert_id();

			//echo json_encode($data);
		$req_params = array(
					'request_type' =>$request_type, 
					'name' => $vendor_id,
					'request_id' => $bill_id,
					'user_id' => $user_id,
					'status' => 0,
					'created' => date( 'Y-m-d ')
 					
					) ;
					
					$this->db->insert('all_req', $req_params );
			if (!is_dir('uploads/files/billrequests/'.$bill_id)) { 
					mkdir('./uploads/files/billrequests/'.$bill_id, 0777, true);
				}
				      $data = [];
   
      $count = count($_FILES['files']['name']);
    
      for($i=0;$i<$count;$i++){
    
        if(!empty($_FILES['files']['name'][$i])){
    
          $_FILES['file']['name'] = $_FILES['files']['name'][$i];
          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
          $_FILES['file']['size'] = $_FILES['files']['size'][$i];
  
         $config[ 'upload_path' ] = './uploads/files/billrequests/'.$bill_id.'';
          $config['allowed_types'] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
          //$config['max_size'] = '5000';
		  $ext = explode(".",  $_FILES['file']['name']);
          //$config['file_name'] = $_FILES['files']['name'][$i];
    
			            // $image_name = "Others-".$size.rand(0,5000000).".".end($ext);
          $config['file_name'] =  $_FILES['file']['size'].rand(0,5000000).".".end($ext);
          $this->load->library('upload',$config); 
    
           if($this->upload->do_upload('file')){
			   
            $uploadData = $this->upload->data();
			
            $filename = $uploadData['file_name'];
			$filetype = $uploadData['file_type'];
			$params = array('bill_id' => $bill_id,
							'file_name' => $filename,
							'filetype' => $filetype
			);
			$this->db->insert( 'bill_request_files', $params );
   
             } 
        }
		
      }
			}
			else if($request_type == '4'){
				
				$employee_id  = $this->input->post( 'employee_id' );
		$type_of_salary = $this->input->post( 'type_of_salary' );
		$from_date = $this->input->post( 'from_date' );
		$to_date = $this->input->post( 'to_date' );
		$amount = $this->input->post( 'amount' );
		$remarks = $this->input->post( 'remarks' );
		$user_id = $this->session->userdata( 'usr_id' );
	
 		
 		$params = array(
						'employee_id' => $employee_id,
						'type_of_salary' => $type_of_salary,
						'from_date' => $from_date,
						'to_date' => $to_date,
						'amount' => $amount,
						'remarks' => $remarks,
						'user_id' => $this->session->userdata( 'usr_id' ),
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'salary_requests', $params );
					$salary_id = $this->db->insert_id();
					if($type_of_salary == '1'){
						$request_name = 'Monthly Advance';
					}else{
						$request_name = 'Leave Salary';
					}
					$req_params = array(
					'request_type' =>$request_type, 
					'name' => $request_name,
					'request_id' => $salary_id,
					'user_id' => $user_id,
					'status' => 0,
					'created' => date( 'Y-m-d ')
 					
					) ;
					
					$this->db->insert('all_req', $req_params );
				
			}
			else if($request_type == '5'){
				
				$description = $this->input->post( 'description' );
		$qty = $this->input->post('qty');
		$user_id  = $this->session->userdata( 'usr_id' );
 		$params = array(
						'description' => $description,
						'qty' => $qty,
						'user_id' => $user_id,
						'status' => 1,
						'created' => date( 'Y-m-d H:i:s' ), 
						
					);
					$this->db->insert( 'other_requests', $params );
					$oreq_id = $this->db->insert_id();

			//echo json_encode($data);
			
			$req_params = array(
					'request_type' =>$request_type, 
					'name' => $description,
					'request_id' => $oreq_id,
					'user_id' => $user_id,
					'status' => 0,
					'created' => date( 'Y-m-d ' )
 					
					) ;
					
					$this->db->insert('all_req', $req_params );
		
			if (!is_dir('uploads/files/orequests/'.$oreq_id)) { 
					mkdir('./uploads/files/orequests/'.$oreq_id, 0777, true);
				}
				      $data = [];
   
      $count = count($_FILES['files']['name']);
    
      
      for($i=0;$i<$count;$i++){
    
        if(!empty($_FILES['files']['name'][$i])){
    
          $_FILES['file']['name'] = $_FILES['files']['name'][$i];
          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
          $_FILES['file']['size'] = $_FILES['files']['size'][$i];
 // print_r($_FILES['files']['name'][$i]);
         $config[ 'upload_path' ] = './uploads/files/orequests/'.$oreq_id.'';
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
         // $config['max_size'] = '5000';
          $ext = explode(".",  $_FILES['file']['name']);
			            // $image_name = "Others-".$size.rand(0,5000000).".".end($ext);
          $config['file_name'] =  $_FILES['file']['size'].rand(0,5000000).".".end($ext);
  // print_r($config['file_name']); 
          $this->load->library('upload',$config); 
    
           if($this->upload->do_upload('file')){
			   
            $uploadData = $this->upload->data();
			//print_r($uploadData); 
            $filename = $uploadData['file_name'];
			$filetype = $uploadData['file_type'];
			$params = array('request_id' => $oreq_id,
							'file_name' => $filename,
							'filetype' => $filetype
			);
			$this->db->insert( 'other_request_files', $params );
   
             } 
        }
		
      }
	  

				
				
				
			}
					redirect(base_url().'mrequests');
			}
		
		
	}

function form($request_type){
	$projects= $this->Projects_Model->get_all_projects();
	$products = $this->Products_Model->get_all_products();
	$employees = $this->Staff_Model->get_all_staff();
	//print_r($products); die;
	if($request_type == '1'){
		echo '<d
		iv class="form-group"><label><h4>Project</h4></label>
		<input type="radio" name="project" id="project" value="project" class="rd"/><label><h4>Stock</h4></label>
		<input type="radio" name="project" id="stock" value="stock" class="rd" /></div>';
		echo '<div class="form-group" id="pr"><label>Project</label>
        <select class="proj" name="project_id" id="project_id" > 
                    <option value="">Select Project</option> ';
                   foreach($projects as $row){
              echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
				   }
                 echo '</select></div>';
		echo '<div class="form-group"><label>Material</label><select class="form-control mat" name="material_name" id="material_name"><option value="">Select Material</option>';
		 foreach($products as $row){
			 echo '<option value="'.$row["id"].'">'.$row['productname'].'</option>';
		 }
		echo '</select></div>';	
		echo '<div class="form-group" align="center"><label>Qty</label><input required type="number" 
		  class="form-control" id="qty" name="qty" /></div>'; 
		  
		 echo '<div class="form-group" align="center"><label>Unit Type</label><input required type="text" class="form-control" id="unit_type" name="unit_type" />
		  </div>';
		   echo '<div class="form-group" align="center"><label>Remarks</label>
          <textarea required type="text" 
		  class="form-control" id="remarks" name="remarks"></textarea>
		  </div>';
		  echo '<div class="form-group" align="center">
	   <label>Priority</label>
          <select class="form-control" name="priority" id="priority">
		  <option value="1">High</option>
		  <option value="2">Medium</option>
		  <option value="3">Low</option>
		  </select>
		  </div>';
	
		
	}
	else if($request_type == '2'){
		
		echo '<div class="form-group"><label>Employee</label>';
		echo '<select class="form-control emp" name="employee_id" id="employee_id">';
		echo '<option value="">Select Employee</option>';
			foreach($employees as $row){
				echo '<option value="'.$row['id'].'">'.$row['staffname'].'</option>';
				
			}
        echo '</select></div>';

		echo '<div class="form-group">
        <label>Type of Leave</label>
		<select name="type_of_leave" id="type_of_leave" class="form-control" required="">
		<option  value="Un Approved Leave">Un Approved Leave</option>
		<option value="Sick Leave">Sick Leave</option>
		<option value="Annual Leave">Annual Leave</option>
		<option value="Emergency Leave">Emergency Leave</option>
		<option value="Paid Leave">Paid Leave</option>
		<option value="Casual Leave">Casual Leave</option>
		</select></div>';
	 echo '<div class="form-group">
        <label for="inputState">Leave Start Date</label>
		<div class="input-group date">
        <input type="text" name="leave_start_date" class="form-control newdatepicker" id="leave_start_date" value=""required="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	 echo '<div class="form-group">
        <label for="inputState">Rejoin Date</label>
		<div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control newdatepicker" id="rejoin_date" value="" required="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group">
	   <label><?php echo "No. of days" ?></label>
          <input  type="number" 
		  class="form-control" id="no_of_days" name="no_of_days" />
		 </div> ';

	}
	else if($request_type == '3'){
		$vendors = $this->Vendors_Model->get_all_vendors();
		echo '<div class="form-group "><label>Supplier</label>';
		echo '<datalist id="suggestions">';
		foreach($vendors as $row) {
			echo '<option>'.$row["company"].'</option>';
		}
echo '</datalist>';
echo '<input  autoComplete="on" list="suggestions" name="vendor_id" required=""/> 
	</div>';
echo '<div class="form-group" id="fr_date"><label for="inputState">Date</label>
		<div class="input-group date">
        <input type="text" name="bill_date" class="form-control newdatepicker" id="bill_date" value="" align="center" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group "><label>Reference</label>
          <input type="text" 
		  class="form-control" id="reference" name="reference" required="" />
	</div>';
	echo '<div class="form-group ">
	   <label>Amount</label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" required="" />
		 </div> ';
		  echo '<div class="form-group ">
	   <label>Attachment</label>
		  <input type="file" name="files[]" multiple="" size="10" />
		  </div>';
		  
	}
	else if($request_type == '4'){
	echo '<div class="form-group"><label>Employee</label>';
		echo '<select class="form-control emp selectpicker"  data-live-search="true" name="employee_id" id="employee_id" width="50%">';
		echo '<option value="">Select Employee</option>';
			foreach($employees as $row){
				echo '<option value="'.$row['id'].'">'.$row['staffname'].'</option>';
				
			}
        echo '</select></div>';
	echo '<div class="form-group">
        <label>Salary Type</label>
		<select name="type_of_salary" id="type_of_salary" class="form-control" onchange="select_salarytype(this.value);">
		<option  value="">Choose Salary Type</option>
		<option  value="1">Monthly Advance</option>
		<option value="2">Leave Salary</option>
		</select></div>';
	echo  '<div class="form-group" id="fr_date">
        <label for="inputState">From Date</label>
		<div class="input-group date">
        <input type="text" name="from_date" class="form-control newdatepicker" id="from_date" value="" autocomplete="off"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	 echo '<div class="form-group" id="t_date">
        <label for="inputState">To Date</label>
		<div class="input-group date">
        <input type="text" name="to_date" class="form-control newdatepicker" id="to_date" value="" autocomplete="off"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group ">
	   <label>Amount</label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" />
	 </div>'; 
	 echo '<div class="form-group">
	   <label>Remarks</label>
          <textarea  type="number" 
		  class="form-control" id="remarks" name="remarks"></textarea>
	 </div> ';
		
	
		
	}
	else if($request_type == '5'){
		echo '<div class="form-group">
	   <label>Description</label><textarea required type="text" 
		  class="form-control" id="description" name="description" placeholder="Enter Description Here"rows="3" cols="10"required="" ></textarea></div>';
	echo '<div class="form-group"><label>Qty</label>
          <input  type="number" 
		  class="form-control" id="qty" name="qty"  required=""/></div>'; 
		  echo '<div class="form-group">
	   <label>Attachment</label>
		  <input type="file" name="files[]" multiple="" size="10" />
		  </div>';
		
		
	}
	
	
}
function update(){
	
	$request_id = $this->input->post('main_request_id');
	$req_result = $this->Mrequests_Model->get_request($request_id);
	$request_type = $req_result['request_type'];
	if($request_type == '5'){
				
				$description = $this->input->post( 'description' );
		$qty = $this->input->post('qty');
		$user_id  = $this->session->userdata( 'usr_id' );
 		$params = array(
						'description' => $description,
						'qty' => $qty 
						
					);
					$this->Mrequests_Model->update_other($req_result['request_id'], $params );
					

			//echo json_encode($data);
			
			$req_params = array( 
					'name' => $description,
										
					) ;
					
					$this->Mrequests_Model->update_main_request( $req_result['request_id'],$req_params );
		
			if (!is_dir('uploads/files/orequests/'.$req_result['request_id'])) { 
					mkdir('./uploads/files/orequests/'.$req_result['request_id'], 0777, true);
				}
				      $data = [];
   
      $count = count($_FILES['files']['name']);
    
      
      for($i=0;$i<$count;$i++){
    
        if(!empty($_FILES['files']['name'][$i])){
    
          $_FILES['file']['name'] = $_FILES['files']['name'][$i];
          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
          $_FILES['file']['size'] = $_FILES['files']['size'][$i];
 // print_r($_FILES['files']['name'][$i]);
         $config[ 'upload_path' ] = './uploads/files/orequests/'.$req_result['request_id'].'';
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
         // $config['max_size'] = '5000';
          $ext = explode(".",  $_FILES['file']['name']);
			            // $image_name = "Others-".$size.rand(0,5000000).".".end($ext);
          $config['file_name'] =  $_FILES['file']['size'].rand(0,5000000).".".end($ext);
  // print_r($config['file_name']); 
          $this->load->library('upload',$config); 
    
           if($this->upload->do_upload('file')){
			   
            $uploadData = $this->upload->data();
			//print_r($uploadData); 
            $filename = $uploadData['file_name'];
			$filetype = $uploadData['file_type'];
			$params = array('request_id' => $req_result['request_id'],
							'file_name' => $filename,
							'filetype' => $filetype
			);
			$this->db->insert( 'other_request_files', $params );
   
             } 
        }
		
      }
	  
	}
				redirect(base_url().'mrequests');
				
}
function edit_request(){
	
	$id = $this->input->post('id');
	$req_result = $this->Mrequests_Model->get_request($id);
	$employees = $this->Staff_Model->get_all_staff();
	
	echo '<form method="post" enctype="multipart/form-data" action="mrequests/update">';
	 echo '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Update</h4> </div></div>';
	 echo '<input type="hidden" name="main_request_id" id="main_request_id" value="'.$id.'"';
	 
        echo '<hr></hr>';
	if($req_result['request_type'] == '1')
	{
		$mat_result = $this->Mrequests_Model->get_material_request($req_result['request_id']);
		echo '<h4>Material Request</h4>';
		
		$projects= $this->Projects_Model->get_all_projects();
	$products = $this->Products_Model->get_all_products();
	$checked = '';
	$checked1 = '';
	if($mat_result['project'] == 'project'){
		$checked = "checked";
	}
	if($mat_result['project'] == 'stock'){
		$checked1 = "checked";
	}
		echo '<div class="form-group"><label><h4>Project</h4></label>
		<input type="radio" name="project" id="project" value="project" class="rd" '.$checked.'/><label><h4>Stock</h4></label>
		<input type="radio" name="project" id="stock" value="stock" class="rd" /></div>';
		echo '<div class="form-group" id="pr" '.$checked1.'><label>Project</label>
        <select class="proj" name="project_id" id="project_id" > 
                    <option value="">Select Project</option> ';
					$selected = '';
                   foreach($projects as $row){
					   if($row["id"] == $mat_result["project_id"]){
						   $selected = "selected";
					   }
              echo '<option value="'.$row["id"].'" '.$selected.'>'.$row['name'].'</option>';
				   }
                 echo '</select></div>';
		echo '<div class="form-group"><label>Material</label><select class="form-control mat" name="material_name" id="material_name"><option value="">Select Material</option>';
		$selected = "";
		 foreach($products as $row){
			 if($row["id"] == $mat_result["mname"]){
				 $selected  = "selected";
				 
			 }
			 echo '<option value="'.$row["id"].'" '.$selected.'>'.$row['productname'].'</option>';
		 }
		echo '</select></div>';	
		echo '<div class="form-group" align="center"><label>Qty</label><input required type="number" 
		  class="form-control" id="qty" name="qty" value="'.$mat_result["qty"].'" /></div>'; 
		  
		 echo '<div class="form-group" align="center"><label>Unit Type</label><input required type="text" class="form-control" id="unit_type" name="unit_type" value="'.$mat_result["unit_type"].'"  />
		  </div>';
		   echo '<div class="form-group" align="center"><label>Remarks</label>
          <textarea required type="text" 
		  class="form-control" id="remarks" name="remarks">'.$mat_result["remarks"].'</textarea>
		  </div>';
		  echo '<div class="form-group" align="center">
	   <label>Priority</label>
          <select class="form-control" name="priority" id="priority">';
		  $selected = '';
		  $selected1  = '';
		  $selected2 = '';
		  if($mat_result['priority'] == '1'){
			  $selected = "selected";
		  }
		  if($mat_result['priority'] == '2'){
			  $selected1  = "selected";
		  }if($mat_result['priority'] == '3'){
			  $selected2  = "selected";
		  }
		echo  ' <option value="1" '.$selected.'>High</option>
		  <option value="2" '.$selected1.'>Medium</option>
		  <option value="3" '.$selected2.'>Low</option>
		  </select>
		  </div>';
	
		
	}
	else if($req_result['request_type'] == '2'){
		$leave_result = $this->Mrequests_Model->get_leave_request($req_result['request_id']);
		$employees = $this->Staff_Model->get_all_staff();
		echo '<h4>Leave Request</h4>';
		echo '<div class="form-group"><label>Employee</label>';
		echo '<select class="form-control emp" name="employee_id" id="employee_id">';
		echo '<option value="">Select Employee</option>';
		$selected  = '';
			foreach($employees as $row){
				
				if($leave_result['employee_id'] == $row["id"]){
					$selected  = "selected";
				}
				echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['staffname'].'</option>';
				
			}
        echo '</select></div>';

		echo '<div class="form-group">
        <label>Type of Leave</label>
		<select name="type_of_leave" id="type_of_leave" class="form-control" required="">';
		$selected = '';
		$selected1 = '';
		$selected2 = '';
		$selected3 = '';
		$selected4 = '';
		$selected5 = '';
		if($leave_result["type_of_leave"] == 'Un Approved Leave'){
			$selected = "selected";
		}
		if($leave_result["type_of_leave"] == 'Sick Leave'){
			$selected1 = "selected";
		}
		if($leave_result["type_of_leave"] == 'Annual Leave'){
			$selected2 = "selected";
		}
		if($leave_result["type_of_leave"] == 'Emergency Leave'){
			$selected3 = "selected";
		}
		if($leave_result["type_of_leave"] == 'Paid Leave'){
			$selected4 = "selected";
		}
		if($leave_result["type_of_leave"] == 'Casual Leave'){
			$selected5 = "selected";
		}
		echo '<option  value="Un Approved Leave" '.$selected.'>Un Approved Leave</option>
		<option value="Sick Leave" '.$selected1.'>Sick Leave</option>
		<option value="Annual Leave" '.$selected2.'>Annual Leave</option>
		<option value="Emergency Leave" '.$selected3.'>Emergency Leave</option>
		<option value="Paid Leave" '.$selected4.'>Paid Leave</option>
		<option value="Casual Leave" '.$selected5.'>Casual Leave</option>
		</select></div>';
		$start_date  = date('d/m/y',strtotime($leave_result['leave_start_date']));
		$rejoin_date  = date('d/m/y',strtotime($leave_result['rejoin_date']));
	 echo '<div class="form-group">
        <label for="inputState">Leave Start Date</label>
		<div class="input-group date">
        <input type="text" name="leave_start_date" class="form-control newdatepicker" id="leave_start_date" value="'.$start_date.'" required="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	 echo '<div class="form-group">
        <label for="inputState">Rejoin Date</label>
		<div class="input-group date">
        <input type="text" name="rejoin_date" class="form-control newdatepicker" id="rejoin_date" value="'.$rejoin_date.'" required="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group">
	   <label><?php echo "No. of days" ?></label>
          <input  type="number" 
		  class="form-control" id="no_of_days" name="no_of_days" value="'.$leave_result["no_of_days"].'"/>
		 </div> ';

		
		
	}
	else if($req_result['request_type'] == '3'){
		
		echo '<h4>Bill Request</h4>';
		$vendors = $this->Vendors_Model->get_all_vendors();
		$bill_result  = $this->Mrequests_Model->get_bill_requests($req_result['request_id']);
		echo '<div class="form-group "><label>Supplier</label>';
		echo '<datalist id="suggestions">';
		//$selected  = '';
		foreach($vendors as $row) {
			
			echo '<option>'.$row["company"].'</option>';
		}
echo '</datalist>';
echo '<input  autoComplete="on" list="suggestions" name="vendor_id" required="" value="'.$bill_result["vendor_id"].'"/> 
	</div>';
echo '<div class="form-group" id="fr_date"><label for="inputState">Date</label>
		<div class="input-group date">
        <input type="text" name="bill_date" class="form-control newdatepicker" id="bill_date" value="'.$bill_result['bill_date'].'" align="center" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group "><label>Reference</label>
          <input type="text" 
		  class="form-control" id="reference" name="reference" required="" value="'.$bill_result['reference'].'"/>
	</div>';
	echo '<div class="form-group ">
	   <label>Amount</label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" required="" value="'.$bill_result['amount'].'"/>
		 </div> ';
		  echo '<div class="form-group ">
	   <label>Attachment</label>
		  <input type="file" name="files[]" multiple="" size="10" />
		  </div>';
		  
		
	}else if($req_result['request_type'] == '4'){
		echo '<h4>Salary Request</h4>';
		
		echo '<div class="form-group"><label>Employee</label>';
		echo '<select class="form-control emp" name="employee_id" id="employee_id" width="50%">';
		echo '<option value="">Select Employee</option>';
			foreach($employees as $row){
				echo '<option value="'.$row['id'].'">'.$row['staffname'].'</option>';
				
			}
        echo '</select></div>';
	echo '<div class="form-group">
        <label>Salary Type</label>
		<select name="type_of_salary" id="type_of_salary" class="form-control" onchange="select_salarytype(this.value);">
		<option  value="">Choose Salary Type</option>
		<option  value="1">Monthly Advance</option>
		<option value="2">Leave Salary</option>
		</select></div>';
	echo  '<div class="form-group" id="fr_date">
        <label for="inputState">From Date</label>
		<div class="input-group date">
        <input type="text" name="from_date" class="form-control newdatepicker" id="from_date" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	 echo '<div class="form-group" id="t_date">
        <label for="inputState">To Date</label>
		<div class="input-group date">
        <input type="text" name="to_date" class="form-control newdatepicker" id="to_date" value="" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        </div></div>';
	echo '<div class="form-group ">
	   <label>Amount</label>
          <input  type="number" 
		  class="form-control" id="amount" name="amount" />
	 </div>'; 
	 echo '<div class="form-group">
	   <label>Remarks</label>
          <textarea  type="number" 
		  class="form-control" id="remarks" name="remarks"></textarea>
	 </div> ';
		
	
		
	}else if($req_result['request_type'] == '5'){
		echo '<h4>Other Request</h4>';
		$oreq_result = $this->Mrequests_Model->get_oreq_request($req_result['request_id']);
		$oreq_doc = $this->Mrequests_Model->get_oreq_request_files($req_result['request_id']);
		echo '<div class="form-group">
	   <label>Description</label><textarea required type="text" 
		  class="form-control" id="description" name="description" placeholder="Enter Description Here"rows="3" cols="10"required="" >'.$oreq_result['description'].'</textarea></div>';
	echo '<div class="form-group"><label>Qty</label>
          <input  type="number" 
		  class="form-control" id="qty" name="qty"  required="" value="'.$oreq_result["qty"].'"/></div>'; 
		   echo '<span class="glyphicon glyphicon-file fontGreen"></span><a href="#" id = "opener-4">'.count($oreq_doc).'</a>';
		    echo '<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
      echo '<div class="modal-header">';
       echo ' <h5 class="modal-title" id="exampleModalLabel"><h5>Document View</h5>';
       echo  '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" >';
           $ext = ''; 
           foreach ($oreq_doc as $key => $pass_values) {
			   $pass_value = $pass_values['file_name'];
             
              if($pass_value != '') { 
              $ext =  substr($pass_value, strrpos($pass_value, '.' )+1); 
        echo    '<div class="row">';
                if($ext!='jpg' && $ext!='jpeg' && $ext!='png' && $ext!='gif') {
				   if($ext=='pdf'){

		echo	 "<a href='#about' onclick=show_post_pdf('".$pass_value."','".$oreq_result['id']."') data-toggle='modal' data-image='".$pass_value."' id='editidpdf$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
				   }else{
					   
				  echo "<a class='btn btn-success' href='uploads/files/$pass_value/$oreq_result[id]'  target='_new'><i class='ion-clipboard'></i></a>";
				    }
			   
			 } else{ 
	      echo "<a href='#about'  onclick=show_post('".$pass_value."','".$oreq_result['id']."') data-toggle='modal'  data-image='".$pass_value."' id='editid$pass_value'><span class='glyphicon glyphicon-file colorDocument'></span></a>";
               } 
               echo ' <li>'.$pass_value.'</li>';
	
            echo   '<a  class="removeclass1 remove_class" style="margin-top:20px" href="#" onclick=select_image_name("'.$pass_value.'","'.$oreq_result['id'].'");><span class="glyphicon glyphicon-remove"></span></a>';
        
            
             echo '</div>';
               }
     
        
          } 
        echo  '</div></div></div></div>';
      
		  echo '<div class="form-group">
	   <label>Attachment</label>
		  <input type="file" name="files[]" multiple="" size="10" />
		  </div>';
		
	}
	echo ' <input type="submit" class="btn btn-success col-md-12"  value="Update">';
	echo '</form>';	
		
		
	
	
}
function img()
	{
	    
	    $id = $this->input->post('id');
		$image = $this->input->post('image');
	    echo "<img src='uploads/files/orequests/$id/$image' alt='staffavatar' width='auto' height='auto'>";
	}
		function pdf()
	{
	    
	    $id = $this->input->post('id');
		$image = $this->input->post('image');
	  echo "<object type='application/pdf' data='uploads/files/orequests/$id/$image' width='100%' height='500' style='height: 85vh;' id='pdffile'>No Support</object>";
	}
	function delete_file(){
	    
	    $image_name = $this->input->post('val');
	    $id = $this->input->post('id');
	    
	    $data = $this->Mrequests_Model->delete_other_files($image_name,$id);
	    echo json_encode($data); 
	    
	}
function requests() {
		//$tickets = array();
		$requests  = $this->Mrequests_Model->get_all_requests();
		//print_r(json_encode($requests)); die;
		if($requests) {
			$data_ticket = array();
			foreach ( $requests as $ticket ) {
				switch ( $ticket[ 'request_type' ] ) {
					case '1':
						$req_type = lang( 'Material' );
						break;
					case '2':
						$req_type = lang( 'Leave' );
						break;
					case '3':
						$req_type = lang( 'Bill' );
						break;
						case '4':
						$req_type = lang( 'Salary' );
						break;
						case '5':
						$req_type = lang( 'Other' );
						break;
				};
				switch ( $ticket[ 'req_status' ] ) { 
				case '0':
					$status_type = 'Open';
					
					break;
				case '1':
					$status_type = 'Pending';
					
					break;
				case '2':
					$status_type = 'Approved';
					
					break;
				case '3':
					$status_type = 'Declined';
					
					break;
				
			};
				if($ticket['req_status'] == 0){
					
					$statusedit = 1;
				}else{
					$statusedit = 0;
				}
				$data_ticket[] = array(
					'id' => $ticket[ 'reqid' ],
					'name' => $ticket[ 'name' ],
					'req_type' => $req_type,
					'request_type' => $ticket['request_type'],
					'status' => $ticket[ 'req_status' ],
					'status_type' => $status_type,
					'created' => $ticket[ 'created' ],
					'statusedit' => $statusedit,
					'staffavatar' => $ticket[ 'staffavatar' ]
					
				);
			}
			//print_r($data_tickets); die;
			echo json_encode( $data_ticket);
		}
	}

function update_status($id){
		//echo $id;
		$allid=explode('id',$id);
		$id=$allid[0];
		$statusid=$allid[1];
		$params = array(
							
							'status' => $statusid,
							
						);
						
				$response  = $this->Mrequests_Model->update_status( $id, $params );
		echo json_encode($response);
	}

	function ticket( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'all' ) ) {
			$data['ticket'] = $this->Tickets_Model->get_ticket_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tickets', 'own') ) {
			$data['ticket'] = $this->Tickets_Model->get_ticket_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
		if($data['ticket']) {
			$data[ 'title' ] = $data['ticket'][ 'subject' ];
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
			$this->load->view( 'tickets/ticket', $data );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
	}

	function assign_staff( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'ticket_id' => $id,
					'staff_id' => $this->input->post( 'staff' ),
				);
				$response = $this->db->where( 'id', $id )->update( 'tickets', array( 'staff_id' => $this->input->post( 'staff' ) ) );
				$this->db->insert( 'notifications', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $this->session->staffname . lang('assigned').' '. lang( 'ticket' ) . '-' . $id . '' ),
					'staff_id' => $this->input->post( 'staff' ),
					'perres' => $this->session->staffavatar,
					'target' => '' . base_url( 'tickets/ticket/' . $id . '' ) . ''
				) );
				$user = $this->Staff_Model->get_staff( $this->input->post( 'staff' ) );

				$template = $this->Emails_Model->get_template('ticket', 'ticket_assigned');
				if ($template['status'] == 1) {
					$ticket = $this->Tickets_Model->get_tickets( $id );
					if ( $ticket[ 'type' ] == 0 ) {
						$customer = $ticket[ 'company' ];
					} else {
						$customer = $ticket[ 'namesurname' ];
					} 

					switch ( $ticket[ 'priority' ] ) {
						case '1':
							$priority = lang( 'low' );
							break;
						case '2':
							$priority = lang( 'medium' );
							break;
						case '3':
							$priority = lang( 'high' );
							break;
					};

					$message_vars = array(
						'{assigned}' => $ticket['staffmembername'],
						'{customer}' => $customer,
						'{name}' => $this->session->userdata('staffname'),
						'{email_signature}' => $this->session->userdata('email'),
						'{ticket_subject}' => $ticket['subject'],
						'{ticket_message}' => $ticket['message'],
						'{ticket_priority}' => $priority,
						'{ticket_department}' => $ticket['department'],
					);
					$subject = strtr($template['subject'], $message_vars);
					$message = strtr($template['message'], $message_vars);

					$param = array(
						'from_name' => $template['from_name'],
						'email' => $ticket['staffemail'],
						'subject' => $subject,
						'message' => $message,
						'created' => date( "Y.m.d H:i:s" )
					);
					if ($ticket['staffemail']) {
						$this->db->insert( 'email_queue', $param );
					}
				}
				$data['name'] = $user[ 'staffname' ];
				$data['success'] = true;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function reply( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$hasError = false;
				$data['message'] = '';
				if ($this->input->post( 'message' ) == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('message');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$ticket = $this->Tickets_Model->get_tickets( $id );
					if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
						$config[ 'upload_path' ] = './uploads/attachments/';
						$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
						$config['max_size'] = '9000';
						$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
						$config['file'] = $new_name;
						$this->load->library( 'upload', $config );
						$this->upload->do_upload('file');
						$data_upload_files = $this->upload->data();
						$image_data = $this->upload->data();
						$filename = $image_data['file_name'];
					} else {
						$filename = NULL;
					}
					$params = array(
						'ticket_id' => $id,
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'contact_id' => $ticket[ 'contact_id' ],
						'date' => date( " Y-m-d h:i:sa" ),
						'name' => $this->session->userdata( 'staffname' ),
						'message' => $this->input->post( 'message' ),
						'attachment' => $filename,
					);
					$this->db->insert( 'ticketreplies', $params );
					$staffname = $this->session->staffname;
					$loggedinuserid = $this->session->usr_id;
					$this->db->insert( 'logs', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'replied' ) . ' <a href="tickets/ticket/' . $id . '"> ' . get_number('tickets', $id, 'ticket', 'ticket') . '</a>' ),
						'staff_id' => $loggedinuserid
					) );
					$staffname = $this->session->staffname;
					$loggedinuserid = $this->session->usr_id;
					$staffavatar = $this->session->staffavatar;
					$this->db->insert( 'notifications', array(
						'date' => date( 'Y-m-d H:i:s' ),
						'detail' => ( '' . $staffname . ' '. lang( 'replied' ).' ' . get_number('tickets', $id, 'ticket', 'ticket') . '' ),
						'contact_id' => $ticket[ 'contact_id' ],
						'perres' => $staffavatar,
						'target' => '' . base_url( 'area/tickets/ticket/' . $id . '' ) . ''
					) );
					$response = $this->db->where( 'id', $id )->update( 'tickets', array(
						'status_id' => 3,
						'lastreply' => date( "Y.m.d H:i:s " ),
						'staff_id' => $loggedinuserid,
					));
					$template = $this->Emails_Model->get_template('ticket', 'ticket_reply_to_customer');
					if ($template['status'] == 1) {
						if ( $ticket[ 'type' ] == 0 ) {
							$customer = $ticket[ 'company' ];
						} else {
							$customer = $ticket[ 'namesurname' ];
						} 
						$message_vars = array(
							'{customer}' => $customer,
							'{name}' => $this->session->userdata('staffname'),
							'{email_signature}' => $this->session->userdata('email'),
							'{ticket_subject}' => $ticket['subject'],
							'{ticket_message}' => $ticket['message'],
						);
						$subject = strtr($template['subject'], $message_vars);
						$message = strtr($template['message'], $message_vars);
						$param = array(
							'from_name' => $template['from_name'],
							'email' => $ticket['customeremail'],
							'subject' => $subject,
							'message' => $message,
							'created' => date( "Y.m.d H:i:s" )
						);
						if ($ticket['customeremail']) {
							$this->db->insert( 'email_queue', $param );
						}
					}
					$data['success'] = true;
					$data['message'] = lang('ticket').' '.lang('updatemessage');
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}

	function attachments($file) {
		if (is_file('./uploads/attachments/' . $file)) {
    		$this->load->helper('file');
    		$this->load->helper('download');
    		$data = file_get_contents('./uploads/attachments/' . $file);
    		force_download($file, $data);
    	} else {
    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
    		redirect('tickets/index');
    	}
	}

	function markas() {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'edit' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$name = $_POST[ 'name' ];
				$params = array(
					'ticket_id' => $_POST[ 'ticket_id' ],
					'status_id' => $_POST[ 'status_id' ],
				);
				$data['success'] = true;
				$data['message'] = lang('ticket').' '.lang('markas').' '.$name;
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'all' ) ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tickets', 'own') ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($ticket) {
			if ( $this->Privileges_Model->check_privilege( 'tickets', 'delete' ) ) {
				if ( isset( $ticket[ 'id' ] ) ) {
					$this->Tickets_Model->delete_tickets( $id, get_number('tickets',$id,'ticket','ticket') );
					$data['success'] = true;
					$data['message'] = lang('ticket').' '.lang('deletemessage');
					
				} else {
					show_error( 'Eror' );
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
			}
			echo json_encode($data);
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
	}

	function get_ticket( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'tickets', 'all' ) ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'tickets', 'own') ) {
			$ticket = $this->Tickets_Model->get_ticket_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
		if($ticket) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			switch ( $ticket[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					break;
				case '2':
					$status = lang( 'inprogress' );
					break;
				case '3':
					$status = lang( 'answered' );
					break;
				case '4':
					$status = lang( 'closed' );
					break;
			};
			if ( $ticket[ 'type' ] == 0 ) {
				$customer = $ticket[ 'company' ];
			} else $customer = $ticket[ 'namesurname' ];
			$replies = $this->db->get_where( 'ticketreplies', array( 'ticket_id' => $id ) )->result_array();
			$data_ticketdetails = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'message' => $ticket[ 'message' ],
				'relation' => $ticket[ 'relation' ],
				'relation_id' => $ticket[ 'relation_id' ],
				'staff_id' => $ticket[ 'staff_id' ],
				'contact_id' => $ticket[ 'contact_id' ],
				'contactname' => '' . $ticket[ 'contactname' ] . ' ' . $ticket[ 'contactsurname' ] . '',
				'priority' => $priority,
				'priority_id' => $ticket[ 'priority' ],
				'lastreply' => $ticket[ 'lastreply' ]?(date(get_dateTimeFormat(),strtotime($ticket[ 'lastreply' ]))):lang('n_a'),
				'status' => $status,
				'status_id' => $ticket[ 'status_id' ],
				'customer_id' => $ticket[ 'customer_id' ],
				'department' => $ticket[ 'department' ],
				'opened_date' => date(get_dateTimeFormat(),strtotime($ticket[ 'date' ])),
				'last_reply_date' => $ticket[ 'lastreply' ]?(date(get_dateTimeFormat(),strtotime($ticket[ 'lastreply' ]))):lang('n_a'),
				'attachment' => $ticket[ 'attachment' ],
				'customer' => $customer,
				'assigned_staff_name' => $ticket[ 'staffmembername' ],
				'replies' => $replies,
				'ticket_number' => get_number('tickets', $ticket[ 'id' ], 'ticket','ticket'),
			);
			echo json_encode( $data_ticketdetails );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('tickets'));
		}
	}
}