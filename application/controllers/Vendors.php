<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Vendors extends CIUIS_Controller {

	function __construct() {
		parent::__construct();
		$path = $this->uri->segment( 1 );
		if ( !$this->Privileges_Model->has_privilege( $path ) ) {
			$this->session->set_flashdata( 'ntf3', '' . lang( 'you_dont_have_permission' ) );
			redirect( 'panel/' );
			die;
		}
	}

	function index() {
		$data[ 'title' ] = lang( 'vendors' );
		$data[ 'vendors' ] = $this->Vendors_Model->get_all_vendors();
		
	
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'vendors/index', $data );
	}

	function create() {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'create' ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$company = $this->input->post( 'name' );
				$email = $this->input->post( 'email' );
				$groupid = $this->input->post( 'groupid' );
				$hasError = false;
				$data['message'] = '';
				if ($company == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' . lang('name') ;
				}else if ($groupid == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' .lang('group');
				}else if ($email == '') {
					$hasError = true;
					$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' .lang('email');
				}
				if ($hasError) {
					$data['success'] = false;
					echo json_encode($data);
				}
				if (!$hasError) {
					$appconfig = get_appconfig();
					$params = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'company' => $this->input->post( 'name' ),
						'groupid' => $this->input->post( 'groupid' ),
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
						'state' => $this->input->post( 'state' ),
						'city' => $this->input->post( 'city' ),
						'town' => $this->input->post( 'town' ),
						'zipcode' => $this->input->post( 'zipcode' ),
						'staff_id' => $this->session->userdata( 'usr_id' ),
						'vendor_status_id' => '1',
						'company_name' => $this->input->post( 'company_name' ),
						'contact_number' => $this->input->post( 'contact_number' ),
						'company_person' => $this->input->post( 'company_person' ),
						'credit_period' => $this->input->post( 'credit_period' ),
						'credit_limit' => $this->input->post( 'credit_limit' ),
						'terms_condition' => $this->input->post( 'terms' ),
						'notes' => $this->input->post( 'notes' )
					);
					$vendors_id = $this->Vendors_Model->add_vendors( $params );
					$data['success'] = true;
					$data['id'] = $vendors_id;
					
					
					//send mail
					
					$template = $this->Emails_Model->get_template('purchase', 'vendor_aded_mail');
					if ($template['status'] == 1) {
						
						$email = $userInfo->email;
			$clean = $this->security->xss_clean( $email );
					$message_vars = array(
				'{vendor_email}' => $email,
				'{vendorname}' => $this->input->post( 'name' ),
				'{name}'=>$this->session->userdata('staffname'),
				'{email_signature}' => $template['from_name'],
			);
			$subject = strtr($template['subject'], $message_vars);
			$message = strtr($template['message'], $message_vars);
						$param = array(
								'from_name' => $template['from_name'],
								'email' => $email,
								'subject' => $subject,
								'message' => $message,
								'created' => date( "Y.m.d H:i:s" ),
								'status' => 0
						);
						if ($clean) {
							$this->db->insert( 'email_queue', $param );
						}
						$this->load->library('mail');
						//echo $message;exit;
						$this->mail->send_email($clean, $template['from_name'], $subject, $message);
						
					}
					
					$imgname=$this->input->post('img_name');
							 if(!empty($imgname)){
								$doc= explode(',',$imgname);
								foreach($doc as $eachDoc){
									$params = array( 								
								'vendor_id' => $id,
								'document_name' => $eachDoc
								
							);
							$this->db->insert( 'vendor_documents', $params );
								}
							 }
					if($appconfig['vendor_series']){
						$vendor_number = $appconfig['vendor_series'];
						$vendor_number = $vendor_number + 1 ;
						$this->Settings_Model->increment_series('vendor_series',$vendor_number);
					}
					echo json_encode($data);
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang( 'you_dont_have_permission' );
			echo json_encode($data);
		}
	}

	function exportdata()
	{
		$this->load->library('excel');
        if ($this->Privileges_Model->check_privilege('vendors', 'all')) {
            $q = $this->Vendors_Model->get_all_vendors();
        }
        // create file name
        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        $listInfo = $q;
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff9933');
        $objPHPExcel->getActiveSheet()->getStyle('B1:D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('66ccff');
        $objPHPExcel->getActiveSheet()->getStyle('E1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff9933');
        $objPHPExcel->getActiveSheet()->getStyle('G1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('66ccff');
		 $objPHPExcel->getActiveSheet()->getStyle('K1:Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff9933');
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Vendor Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Vendor Group*');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact Person');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Contact Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Company Mail');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Company Adress');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Vat Office');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Vat Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Fax');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Web');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Post code');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Trade Lisence Number');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Expiry Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Terms and Conditions');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Credit Period');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Credit Limit');
        $from = "A1"; // or any value
        $to   = "Q1"; // or any value
        $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $rowCount = 2;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['company']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['grpname']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['company_person']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['contact_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['taxoffice']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['taxnumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['fax']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['web']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $list['zipcode']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $list['licence_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $list['trade_expiry_date']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $list['terms_condition']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $list['credit_period']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $list['credit_limit']);
            
            $rowCount++;
        }
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vendors.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
   

	}
	
	function importdata()
	{
		
		
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'create' ) ) {
			
			$path = './uploads/imports/';
			require_once APPPATH . "/third_party/PHPExcel.php";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx|xls|csv';
			$config['remove_spaces'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);            
			if (!$this->upload->do_upload()) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
			}
			if(empty($error)){
			  if (!empty($data['upload_data']['file_name'])) {
				$import_xls_file = $data['upload_data']['file_name'];
			} else {
				$import_xls_file = 0;
			}
			  $inputFileName = $path . $import_xls_file;
			 
		 
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$flag = true;
				$i=0;
				foreach ($allDataInSheet as $row) {
				  if($flag){
					$flag =false;
					continue;
				  }
				  $materialcattype = $this->Vendors_Model->get_vendor_group_by_name($row[ 'B' ]);
				 
				  if(sizeof($materialcattype) > 0){
					$groupid = $materialcattype['id']; 
				  } else {
						$param = array('name'=>$row[ 'B' ]);
						$this->db->insert('vendors_groups',$param);
						$groupid = $this->db->insert_id();
				  }
				  $inserdata[$i]['created'] = date( 'Y-m-d' );
				  $inserdata[$i]['company'] = $row['A'];
				  $inserdata[$i]['groupid'] = $groupid;				  
				  $inserdata[$i]['company_person'] = $row['C'];
				  $inserdata[$i]['contact_number'] = $row['D'];
				  $inserdata[$i]['email'] = $row['E'];
				  $inserdata[$i]['address'] = $row['F'];
				  $inserdata[$i]['taxoffice'] = $row['G'];
				   $inserdata[$i]['taxnumber'] = $row['H'];
				  $inserdata[$i]['phone'] = $row['I'];
				  $inserdata[$i]['fax'] = $row['J'];
				  $inserdata[$i]['web'] = $row['K'];
				  $inserdata[$i]['credit_period'] = $row['L'];
				  $inserdata[$i]['credit_limit'] = $row['M'];
				  
				 
							
				  $i++;
				} 
				
				$result = $this->Vendors_Model->insert_bulk_vendor($inserdata);
				
				if($result){
				  $this->session->set_flashdata( 'ntf3', 'Your Excel File Imported Successfully.' );
				  unlink($inputFileName);
				  // echo $this->session->flashdata('success');exit;
				  redirect( 'vendors' );
				}else{
					unlink($inputFileName);
				  redirect( 'vendors' );
				  $this->session->set_flashdata( 'ntf3', 'Error' );
				}             
				
		  } catch (Exception $e) {
			   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' .$e->getMessage());
			}
		  }else{
			  $this->session->set_flashdata( 'ntf3',lang( 'There is some issue while upload. Please try again later.' ) );
			redirect(base_url('vendors'));
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
	}
	function vendor( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'vendors', 'own') ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
		if($vendor) {
			
			$data[ 'title' ] = lang( 'vendor' ).' '.get_number('vendors', $id, 'vendor', 'vendor');
			$data[ 'ycr' ] = $this->Report_Model->ycr();
			if ( isset( $vendor[ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
						$company = $this->input->post( 'name' );
						$email = $this->input->post( 'email' );
						$groupid = $this->input->post( 'groupid' );
						$hasError = false;
						$data['message'] = '';
						if ($company == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' . lang('name') ;
						}else if ($groupid == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' .lang('group');
						}else if ($email == '') {
							$hasError = true;
							$data['message'] = lang('invalidmessage'). ' ' .lang('vendor'). ' ' .lang('email');
						}
						if ($hasError) {
							$data['success'] = false;
							echo json_encode($data);
						}
						if (!$hasError) {
							$appconfig = get_appconfig();
							$params = array(
							
								'company' => $this->input->post( 'name' ),
								'groupid' => $this->input->post('groupid'),
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
								'state' => $this->input->post( 'state' ),
								'city' => $this->input->post( 'city' ),
								'town' => $this->input->post( 'town' ),
								'zipcode' => $this->input->post( 'zipcode' ),
								'staff_id' => $this->session->userdata( 'usr_id' ),
								'risk' => $this->input->post( 'risk' ),
								'vendor_status_id' => $this->input->post( 'status_id' ),
								'vendor_number' => get_number('vendors', $id, 'vendor', 'vendor'),
								'company_name' => $this->input->post( 'company_name' ),
						'contact_number' => $this->input->post( 'contact_number' ),
						'company_person' => $this->input->post( 'company_person' ),
						'credit_period' => $this->input->post( 'credit_period' ),
						'credit_limit' => $this->input->post( 'credit_limit' ),
						'terms_condition' => $this->input->post( 'terms' ),
						'notes' => $this->input->post( 'notes' ),
						'licence_no'=>$this->input->post( 'licence_no' ),
						'trade_expiry_date' => $this->input->post( 'trade_expiry_date' )
							);
							$this->Vendors_Model->update_vendors( $id, $params );
							 $imgname=$this->input->post('img_name');
							 if(!empty($imgname)){
								$doc= explode(',',$imgname);
								foreach($doc as $eachDoc){
									$params = array( 								
								'vendor_id' => $id,
								'document_name' => $eachDoc
								
							);
							$this->db->insert( 'vendor_documents', $params );
								}
							 }
							$data['success'] = true;
							$data['message'] = lang('vendorsupdated');
							echo json_encode($data);
						}	
					} else {
						$data['success'] = false;
						$data['message'] = lang( 'you_dont_have_permission' );
						echo json_encode($data);
					}
				} else {
					$data[ 'vendors' ] = $this->Vendors_Model->get_vendors( $id );
					$data[ 'documents' ] = $this->Vendors_Model->get_vendors_documents( $id );
					//echo "<pre>";
					//print_r($data[ 'documents' ]);
					$this->load->view( 'vendors/vendor', $data );
				}
			} else {
				redirect(base_url('vendors'));
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
	}
	
	function add_file( $id ) { 
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			if ( isset( $id ) ) {
				if ( isset( $_POST ) ) {
					if (!is_dir('uploads/files/vendors/'.$id)) { 
						mkdir('./uploads/files/vendors/'.$id, 0777, true);
					}
					$config[ 'upload_path' ] = './uploads/files/vendors/'.$id.'';
					$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|gif|pdf|doc|docx|xls|xlsx|txt|csv|ppt|opt';
					$config['max_size'] = '9000';
					$new_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES["file"]['name']));
					$config['file'] = $new_name;
					$this->load->library( 'upload', $config );
					if (!$this->upload->do_upload('file')) {
						$data['success'] = false;
						$data['message'] = $this->upload->display_errors();
						echo json_encode($data);
					} else {
						$image_data = $this->upload->data();
						if (is_file('./uploads/files/vendors/'.$id.'/'.$image_data[ 'file_name' ])) {
							$params = array( 
								'relation_type' => 'vendor',
								'relation' => $id,
								'file_name' => $image_data[ 'file_name' ],
								'created' => date( " Y.m.d H:i:s " ),
								'is_old' => '0'
							);
							$this->db->insert( 'files', $params );
							
							$data['success'] = true;
							$data['message'] = lang('file').' '.lang('uploadmessage');
							echo json_encode($data);
						} else {
							$data['success'] = false;
							$data['message'] = lang('errormessage');
							echo json_encode($data);
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
	
	function delete_liscence_document($id) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			//echo "21312";exit;
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file_doc($id);
				if ($fileData) {
					$response = $this->db->where( 'dc_id', $id )->delete( 'vendor_documents', array( 'dc_id' => $id ) );
					
				if (is_file('./uploads/images/' . $fileData['document_name'])) {
				    		unlink('./uploads/images/' . $fileData['document_name']);
				    	}
			    	if ($response) {
			    		$data['success'] = true;
			    		$data['message'] = lang('file'). ' '.lang('deletemessage');
			    	} else {
			    		$data['success'] = false;
			    		$data['message'] = lang('errormessage');
			    	}
					//$res=$response->row_array();
			    	//echo json_encode($data);
					redirect('vendors/vendor/'.$fileData['vendor_id'].'');
			    }
			} else {
				redirect('vendors');
			}
		} else {
			//echo "adSA";exit;
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			//echo json_encode($data);
			redirect('vendors');
		}
	}
	
	function delete_file($id) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			//echo "21312";exit;
			if (isset($id)) {
				$fileData = $this->Expenses_Model->get_file($id);
				if ($fileData) {
					$response = $this->db->where( 'id', $id )->delete( 'files', array( 'id' => $id ) );
					if ($fileData['is_old'] == '1') {
						if (is_file('./uploads/files/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/' . $fileData['file_name']);
				    	}
					} else {
						if (is_file('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name'])) {
				    		unlink('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name']);
				    	}
					}
			    	if ($response) {
			    		$data['success'] = true;
			    		$data['message'] = lang('file'). ' '.lang('deletemessage');
			    	} else {
			    		$data['success'] = false;
			    		$data['message'] = lang('errormessage');
			    	}
			    	echo json_encode($data);
			    }
			} else {
				redirect('vendors');
			}
		} else {
			//echo "adSA";exit;
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
	}
	
	function download_liscence_document($id){
		
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file_doc( $id );
			if (is_file('./uploads/images/' . $fileData['document_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/images/' . $fileData['document_name']);
		    		force_download($fileData['document_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
				
		}
	}

	function download_file($id) {
		if (isset($id)) {
			$fileData = $this->Expenses_Model->get_file( $id );
			if ($fileData['is_old'] == '1') {
				if (is_file('./uploads/files/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
			} else {
				if (is_file('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name'])) {
		    		$this->load->helper('file');
		    		$this->load->helper('download');
		    		$data = file_get_contents('./uploads/files/vendors/'.$fileData['relation'].'/' . $fileData['file_name']);
		    		force_download($fileData['file_name'], $data);
		    	} else {
		    		$this->session->set_flashdata( 'ntf4', lang('filenotexist'));
		    		redirect('vendors/vendor/'.$fileData['relation']);
		    	}
		    }
				
		}
	}


	function projectfiles( $id ) {
		if (isset($id)) {
			$files = $this->Vendors_Model->get_project_files( $id );
			$data = array();
			foreach ($files as $file) {
				$ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);
				$type = 'file';
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
					$type = 'image';
				}
				if ($ext == 'pdf') {
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
				if ($ext == 'pdf') {
					$pdf = true;
				} else {
					$pdf = false;
				}
				if ($file['is_old'] == '1') {
					$path = base_url('uploads/files/'.$file['file_name']);
				} else {
					$path = base_url('uploads/files/vendors/'.$id.'/'.$file['file_name']);
				}
				$data[] = array(
					'id' => $file['id'],
					'project_id' => $file['relation'],
					'file_name' => $file['file_name'],
					'created' => $file['created'],
					'display' => $display,
					'pdf' => $pdf,
					'type' => $type,
					'path' => $path,
				);
			}
			echo json_encode($data);
		}
	}


	function groups() {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$data = $this->Vendors_Model->get_groups();
		} else if ($this->Privileges_Model->check_privilege( 'vendors', 'own') ) {
			$data = $this->Vendors_Model->get_groups($this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
		echo json_encode( $data );
	}

	function add_group() {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'create' ) ) {
			if (isset($_POST)) {
				$params = array(
					'name' => $this->input->post('name')
				);
				$this->db->insert( 'vendors_groups', $params );
				$id = $this->db->insert_id();
				if ($id) {
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('createmessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function update_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'edit' ) ) {
			$data[ 'group' ] = $this->Vendors_Model->get_group( $id );
			if ( isset( $data[ 'group' ][ 'id' ] ) ) {
				if ( isset( $_POST ) && count( $_POST ) > 0 ) {
					$params = array(
						'name' => $this->input->post( 'name' ),
					);
					$this->Vendors_Model->update_group( $id, $params );
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('updatemessage');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function remove_group( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'delete' ) ) {
			$group = $this->Vendors_Model->get_group( $id );
			if ( isset( $group[ 'id' ] ) ) { 
				if ($this->Vendors_Model->check_group($id) == 0) {
					$this->Vendors_Model->remove_group( $id );
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('group'). ' ' .lang('deletemessage');
				} else {
					$data['success'] = false;
					$data['message'] = $data['message'] = lang('group').' '.lang('is_linked').' '.lang('with').' '.lang('vendor').', '.lang('so').' '.lang('cannot_delete').' '.lang('group');
				}
			}
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
		}
		echo json_encode($data);
	}

	function get_vendor_groups() {
		$groups = $this->Vendors_Model->get_vendor_groups();
		$data_categories = array();
		foreach ( $groups as $group ) {
			$data_categories[] = array(
				'name' => $group[ 'name' ],
				'id' => $group[ 'id' ],
			);
		};
		echo json_encode( $data_categories );
	}

	function remove( $id ) {
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'vendors', 'own') ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id, $this->session->usr_id );
		} else {
			$data['success'] = false;
			$data['message'] = lang('you_dont_have_permission');
			echo json_encode($data);
		}
		if($vendor) {
			if ( $this->Privileges_Model->check_privilege( 'vendors', 'delete' ) ) {
				if ( isset( $vendor[ 'id' ] ) ) {
					$this->Vendors_Model->delete_vendors( $id, get_number('vendors',$id,'vendor','vendor') );
					$data['success'] = true;
					$data['message'] = lang('vendor').' '.lang('deletemessage');
					echo json_encode($data);
				} else {
					show_error( 'vendor not deleted' );	
				}
			} else {
				$data['success'] = false;
				$data['message'] = lang('you_dont_have_permission');
				echo json_encode($data);
			}
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
	}

	function get_vendor( $id ) {
		$vendor = array();
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id );
		} else if ($this->Privileges_Model->check_privilege( 'vendors', 'own') ) {
			$vendor = $this->Vendors_Model->get_vendor_by_privileges( $id, $this->session->usr_id );
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
		if($vendor) {
			$this->load->model('Vendors_Model'); 
			$country = get_country($vendor['country_id']);
			$state = get_state_name('', $vendor['state']);
			$this->db->select_sum( 'total' );
			$this->db->from( 'purchases' );
			$this->db->where( '(status_id = 2 AND vendor_id = ' . $vendor[ 'id' ] . ') ' );
			$netrevenue = $this->db->get();
			$this->db->select_sum( 'total' );
			$this->db->from( 'purchases' );
			$this->db->where( '(status_id != 1 and  status_id!=4 AND vendor_id = ' . $vendor[ 'id' ] . ') ' );
			$grossrevenue = $this->db->get();
			$settings = $this->Settings_Model->get_settings_ciuis();
				switch ( $settings[ 'dateformat' ] ) {
					case 'yy.mm.dd':
						$trade_expiry_date = _rdate( $vendor[ 'trade_expiry_date' ] );
						

						break;
					case 'dd.mm.yy':
						$trade_expiry_date = _udate( $vendor[ 'trade_expiry_date' ] );
					
						break;
					case 'yy-mm-dd':
						$trade_expiry_date = _mdate( $vendor[ 'trade_expiry_date' ] );
						
						break;
					case 'dd-mm-yy':
						$trade_expiry_date = _cdate( $vendor[ 'trade_expiry_date' ] );
						
						break;
					case 'yy/mm/dd':
						$trade_expiry_date = _zdate( $vendor[ 'trade_expiry_date' ] );
						
						break;
					case 'dd/mm/yy':
						$trade_expiry_date = _kdate( $vendor[ 'trade_expiry_date' ] );
						
						break;
				};
			$data_customerdetail = array(
				'id' => $vendor[ 'id' ],
				'created' => $vendor[ 'created' ],
				'staff_id' => $vendor[ 'staff_id' ],
				'name' => $vendor[ 'company' ],
				'taxoffice' => $vendor[ 'taxoffice' ],
				'taxnumber' => $vendor[ 'taxnumber' ],
				'ssn' => $vendor[ 'ssn' ],
				'executive' => $vendor[ 'executive' ],
				'address' => $vendor[ 'address' ],
				'zipcode' => $vendor[ 'zipcode' ],
				'country_id' => $vendor[ 'country_id' ],
				'state' => $vendor['state'],
				'state_name' => $state,
				'city' => $vendor[ 'city' ],
				'town' => $vendor[ 'town' ],
				'phone' => $vendor[ 'phone' ],
				'fax' => $vendor[ 'fax' ],
				'email' => $vendor[ 'email' ],
				'web' => $vendor[ 'web' ],
				'risk' => intval( $vendor[ 'risk' ] ),
				'country' => $country,
				'group_id' => $vendor['groupid'],
				'netrevenue' => $netrevenue->row()->total,
				'grossrevenue' => $grossrevenue->row()->total,
				'vendor_number' => $vendor['vendor_number'],
				'vendor_status_id' => ($vendor['vendor_status_id'] == '1') ? true : false,
					'company_name' => $vendor['company_name'],
						'contact_number' => $vendor['contact_number'],
						'company_person' => $vendor['company_person'],
						'credit_period' => $vendor['credit_period'],
						'credit_limit' => $vendor['credit_limit'],
						'terms' =>$vendor['terms_condition'],
						'notes' => $vendor['notes'],
						'licence_no' =>$vendor['licence_no'],
						'trade_expiry_date' => $trade_expiry_date,
			);
			echo json_encode( $data_customerdetail );	
		} else {
			$this->session->set_flashdata( 'ntf3',lang( 'you_dont_have_permission' ) );
			redirect(base_url('vendors'));
		}
	}

	function get_vendors() {
		$vendors = array();
		if ( $this->Privileges_Model->check_privilege( 'vendors', 'all' ) ) {
			$vendors = $this->Vendors_Model->get_all_vendors_by_privileges();
		} else if ( $this->Privileges_Model->check_privilege( 'vendors', 'own' ) ) {
			$vendors = $this->Vendors_Model->get_all_vendors_by_privileges($this->session->usr_id);
		}
		$data_customers = array();
		foreach ( $vendors as $vendor ) {
			$this->db->select_sum( 'total' )->from( 'purchases' )->where( '(status_id = 3 AND vendor_id = ' . $vendor[ 'id' ] . ') ' );
			$total_unpaid_invoice_amount = $this->db->get()->row()->total;
			$this->db->select_sum( 'total' )->from( 'purchases' )->where( '(status_id = 2 AND vendor_id = ' . $vendor[ 'id' ] . ') ' );
			$total_paid_invoice_amount = $this->db->get()->row()->total;
			$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(transactiontype = 0 AND vendor_id = ' . $vendor[ 'id' ] . ') ' );
			$total_paid_amount = $this->db->get()->row()->amount;
			$country = get_country($vendor['country_id']);
			$data_customers[] = array(
				'id' => $vendor[ 'id' ],
				'vendor' => $vendor[ 'id' ],
				'name' => $vendor[ 'company' ],
				'address' => $vendor[ 'address' ],
				'group_name' => $vendor['name'],
				'email' => $vendor[ 'email' ],
				'balance' => $total_unpaid_invoice_amount - $total_paid_amount + $total_paid_invoice_amount,
				'phone' => $vendor[ 'phone' ],
				'' . lang( 'filterbycountry' ) . '' => $country,
				'vendor_number' => get_number('vendors', $vendor[ 'id' ], 'vendor','vendor'),
			);
		};
		echo json_encode( $data_customers );
	}
}