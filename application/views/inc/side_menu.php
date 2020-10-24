 <?php 
 $status = 0;
 $priority=0;
$data['user_id'] = $this->session->userdata( 'usr_id' );
if($this->Privileges_Model->check_privilege( 'requests', 'all' ) ){
			$mrequests = $this->Mrequests_Model->get_all_mrequests($status, $priority);
		
		}
		else
		{	
			
			$mrequests = $this->Mrequests_Model->get_user_mrequests($status,$data['user_id'], $priority);
		}
 if($this->Privileges_Model->check_privilege( 'salaryrequests', 'all' ) ){
		$srequests = $this->Salaryrequests_Model->get_all_srequests($status);	
		}
		else{			
			$srequests = $this->Salaryrequests_Model->get_user_all_srequests($status,$data['user_id']);
			
		}
if($this->Privileges_Model->check_privilege( 'billrequests', 'all' ) ){
			
		$brequests = $this->Billrequests_Model->get_all_user_brequests($status);
		
			
		}
		else {
		$brequests = $this->Billrequests_Model->get_all_brequests($status,$data['user_id']);
		
		}
		
		if($this->Privileges_Model->check_privilege( 'leaverequests', 'all' ) ){
		$lrequests = $this->Leaverequests_Model->get_all_lrequests($status);
	
		
		}else{
			$lrequests = $this->Leaverequests_Model->get_user_all_lrequests($status,$data['user_id']);
			
		}
		
		if($this->Privileges_Model->check_privilege( 'otherrequests', 'all' ) ){
		$orequests = $this->Otherrequests_Model->get_all_orequests($status);
		
		}else{
			$orequests = $this->Otherrequests_Model->get_user_all_orequests($status,$data['user_id']);
	
			
		}
 ?>
 <?php if ( $this->Privileges_Model->has_privilege( 'mrequests' ) ) {?>
 <a onclick="window.location.href = '<?php echo base_url('mrequests') ?>';" class="side-tickets-menu-item"><?php echo 'Material Request'; ?> <span class="ticket-num" ng-bind="<?php print count($mrequests);?>"></span></a>
 <?php }?>
  <?php if ( $this->Privileges_Model->has_privilege( 'leaverequests' ) ) {?>
 
						  <a onclick="window.location.href = '<?php echo base_url('leaverequests') ?>';" class="side-tickets-menu-item"><?php echo 'Leave Request' ?> <span class="ticket-num" ng-bind="<?php print count($lrequests);?>"></span></a>
  <?php }?>
   <?php if ( $this->Privileges_Model->has_privilege( 'billrequests' ) ) {?>
						  <a onclick="window.location.href = '<?php echo base_url('billrequests') ?>';" class="side-tickets-menu-item"><?php echo 'Bill Request' ?> <span class="ticket-num" ng-bind="<?php print count($brequests);?>"></span></a>
						   <?php }?>
						     <?php if ( $this->Privileges_Model->has_privilege( 'salaryrequests' ) ) {?>
						  <a onclick="window.location.href = '<?php echo base_url('salaryrequests') ?>';" class="side-tickets-menu-item"><?php echo 'Salary Request' ?> <span class="ticket-num" ng-bind="<?php print count($srequests);?>"></span></a>
						  <?php }?>
						  <?php /*if ( $this->Privileges_Model->has_privilege( 'salaryrequests' ) ) {?>
						   <a onclick="window.location.href = '<?php echo base_url('otherrequests') ?>';" class="side-tickets-menu-item"><?php echo 'Other Request' ?> <span class="ticket-num" ng-bind="<?php print count($orequests);?>"></span></a>
						  <?php }*/?>
						   