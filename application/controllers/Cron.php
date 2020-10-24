<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Cron extends CI_Controller{
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_Model');
        $this->load->model('Privileges_Model');
		$this->load->model('Notifications_Model');
		$this->load->model('Customers_Model');
		$this->load->model('Vendors_Model');
		$this->load->model('Document_Model');
    } 
    public function index(){ 
	 $StaffInfo=array();
	 $OtherInfo=array();
	 $CustomerLicenceNotify=array();
	 $VendorsNotify=array();
	 $currentDate=date("Y-m-d");
	 $StaffInfo=$this->Staff_Model->get_allStaffInfo();
	 $OtherInfo=$this->Staff_Model->get_allotherInfo();
	 $VendorsNotify= $this->Vendors_Model->get_vendor_by_licence_Notify();
	 $CustomerLicenceNotify=$this->Customers_Model->get_CustomerLicenceNotify();
	 $DocumentNotify=$this->Document_Model->get_document_Notify();
	 
	 $documentStaffIds=$this->Privileges_Model->get_all_privilegeuser('userdocuments');
	 $customerNotifiIds=$this->Privileges_Model->get_all_privilegeuser('customers');
	 $vendorNotifiIds=$this->Privileges_Model->get_all_privilegeuser('vendors');
	 $documentNotifiIds=$this->Privileges_Model->get_all_privilegeuser('document');
		 if(sizeof($StaffInfo) > 0){
			 foreach($StaffInfo as $eachInfo){
				 if($eachInfo['passport'] !='' && $eachInfo['passportreminddate'] !='' && $eachInfo['passportreminddate'] == $currentDate){
					$params=array();
					$params['staffList']=$documentStaffIds;
					$params['msg']='Passport No:'.$eachInfo['passport'] .' Will expire soon.';
					$params['link']= base_url( 'staff/staffmember/' . $eachInfo['staff_id'] . '' );
					$params['staff_id']= $eachInfo['staff_id'];
					$params['img']= $eachInfo['staffavatar'];
					$this->Notifications_Model->insertNotification($params);
				 }
				 if($eachInfo['emirates_id'] !='' && $eachInfo['emiratesreminddate']!='' && $eachInfo['emiratesreminddate'] == $currentDate){
					$params=array();
					$params['staffList']=$documentStaffIds;
					$params['msg']='Emirates Id:'.$eachInfo['emirates_id'] .' Will expire soon.';
					$params['link']= base_url( 'staff/staffmember/' . $eachInfo['staff_id'] . '' );
					$params['staff_id']= $eachInfo['staff_id'];
					$params['img']= $eachInfo['staffavatar'];
					$this->Notifications_Model->insertNotification($params);
				 }
				 if($$eachInfo['labour_card'] !='' && $eachInfo['labourreminddate'] !='' && $eachInfo['labourreminddate'] == $currentDate){
					$params=array();
					$params['staffList']=$documentStaffIds;
					$params['msg']='Labour Card:'.$eachInfo['labour_card'] .' Will expire soon.';
					$params['link']= base_url( 'staff/staffmember/' . $eachInfo['staff_id'] . '' );
					$params['staff_id']= $eachInfo['staff_id'];
					$params['img']= $eachInfo['staffavatar'];
					$this->Notifications_Model->insertNotification($params);
				 }
				 if($eachInfo['atm_card'] !='' && $eachInfo['atmreminddate'] !='' && $eachInfo['atmreminddate'] == $currentDate){
					$params=array();
					$params['staffList']=$documentStaffIds;
					$params['msg']='ATM No:'.$eachInfo['atm_card'] .' Will expire soon.';
					$params['link']= base_url( 'staff/staffmember/' . $eachInfo['staff_id'] . '' );
					$params['staff_id']= $eachInfo['staff_id'];
					$params['img']= $eachInfo['staffavatar'];
					$this->Notifications_Model->insertNotification($params);
					 
				 } 
			 }
		 }
		 if(sizeof($OtherInfo) > 0){
			  foreach($OtherInfo as $key=>$eachInfo){
				 if($eachInfo['othersreminddate'] !='' && $eachInfo['othersreminddate'] == $currentDate){
					$params=array();
					$params['staffList']=$documentStaffIds;
					$params['msg']='Document '.$eachInfo['others'] .' Will expire soon.';
					$params['link']= base_url( 'staff/staffmember/' . $eachInfo['staff_id'] . '' );
					$params['staff_id']= $eachInfo['staff_id'];
					$params['img']= $eachInfo['staffavatar'];
					$this->Notifications_Model->insertNotification($params);
				 }
			  }
		 }
		 
		 if(sizeof($CustomerLicenceNotify) > 0){
			 foreach($CustomerLicenceNotify as $eachCustomerLicence){
					$params=array();
					$params['staffList']=$customerNotifiIds;
					$params['msg']='Customer '.$eachCustomerLicence['customer_number'] .' licence: '.$eachCustomerLicence['licence_no'].' Will expire soon.';
					$params['link']= base_url( 'customers/customer/' . $eachCustomerLicence['id'] . '' );
					$params['staff_id']= '';
					$params['img']='' ;
					$this->Notifications_Model->insertNotification($params);
			 }
		 }
		 if(sizeof($VendorsNotify) > 0){
			 foreach($VendorsNotify as $eachVendorLicene){
					$params=array();
					$params['staffList']=$vendorNotifiIds;
					$params['msg']='Vendor '.$eachVendorLicene['company'] .' licence: '.$eachVendorLicene['licence_no'].' will expire soon.';
					$params['link']= base_url( 'vendors/vendor/' . $eachVendorLicene['id'] . '' );
					$params['staff_id']= '';
					$params['img']='' ;
					$this->Notifications_Model->insertNotification($params);
			 }
		 }
		 if(sizeof($DocumentNotify) > 0){
			 foreach($DocumentNotify as $eachDocument){
					$params=array();
					$params['staffList']=$documentNotifiIds;
					$params['msg']='Document: '.$eachDocument['name'] .' will expire soon.';
					$params['link']= base_url('document/');
					$params['staff_id']= '';
					$params['img']='' ;
					$this->Notifications_Model->insertNotification($params);
			 }
		 }
		 
    }
}
?>