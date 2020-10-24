<?php $appconfig = get_appconfig(); ?>
<?php  $number = get_number_estimate('estimations',$estimation_record['estimation_id'],'estimation','est');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!-- Encoding utf8 chartset for the pdf -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/bootstrap/dist/css/bootstrap.css'); ?>" /> <!-- Bootstrap CSS file link -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
	
	<style>

    @page { margin: 100px 30px; }
    #header { position: fixed; left: 0px; top: -100px; right: 0px; height: 50px;   }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; }
    #footer .page:after { content: counter(page, upper-roman); }
	

	 body {
       font-family: "Roboto script=latin rev=1 !important";
            
    font-style: normal;
      }
	  
	  .robotolight{
		   font-family: "Roboto script=latin rev=1 !important";
		  font-weight: 200 !important;
    
	  }
	  .robotoregular{
		   font-family: "Roboto script=latin rev=1 !important";
		  font-weight: 400 !important;
    
	  }
	  .robotobold{
		   font-family: "Roboto script=latin rev=1 !important";
		  font-weight: 700 !important;
	  }
		.list-group-item.active,
		.list-group-item.active:focus,
		.list-group-item.active:hover {
			z-index: 2;
			color: #fff;
			background-color: #555;
			border-color: #555;
		}
		.fr{float:right;right:20px;}
		/*Custom CSS write/paste here*/
	</style>
</head>

<?php 

// Proposal logo
$logo =  file_exists(FCPATH.'uploads/ciuis_settings/'.$settings['app_logo']);
if(file_exists(FCPATH.'uploads/ciuis_settings/'.$settings['app_logo'])) {
	$logo = FCPATH.'uploads/ciuis_settings/'.$settings['app_logo'];
} else {
	$logo = FCPATH.'uploads/ciuis_settings/'.$settings['logo']; // Use app logo, if Proposal logo is not found
}
$logo="https://ecodelinfotel.com//crm/uploads/ciuis_settings/artefact5.jpg";
//echo "<pre>";
//print_r($estimation_record);
//exit;
?>
<body>
 <div id="header">
    <h1 style="width:80%;float: left;"><strong><span class="text-uppercase">Estimation</span> </strong></h1>
	<img height="85px" src="<?php echo $logo ?>" alt="" style="float: right;" >
  </div>
  <!--
  <div id="footer">
    <p class="page"><a href="ibmphp.blogspot.com"></a></p>
  </div>-->
  <div id="content">

	<div class="container">
		<div class="row">
		<?php /*
			<div class="page-header">
			<small class="pull-left" style="position:relative;top:50px;right:20px;width: 95%;font-size:25px;"><strong><span class="text-uppercase">Estimation</span> </strong><br> <!--  Proposal Title in your language -->
					</small>
					
				<img height="85px" src="<?php echo $logo ?>" alt="" >
				
			</div><?php */?>
			<div class="col-md-12 nav panel" style="padding-bottom: 20px">
			<div class="col-md-4 col-sm-6 col-xs-3" style="padding: 0">
					<!-- Customer Details -->
					<strong><?php echo lang('to') ?></strong><br><br>
					
					<small>
						<strong> <?php echo $customer_record['company'] ?></strong>
					</small>
					<br>
					<small>
						<?php echo $customer_record['address']; ?>
					</small><br>
					<small>
						<?php echo $customer_record['email']; ?>
					</small><br>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0;float:right;">
				
				<span class="text-uppercase" style="float:right" ><strong>Estimations # </strong></span> <br> <!--  Proposal Title in your language -->
					<span style="float:right"><?php echo '' . $number. '' ?></span> <!-- Proposal number -->
					<br> <br><strong style="float:right"><?php echo lang( 'date' ).': ' //Date label 
					?></strong><br>
					<span style="float:right">
					<?php print $customer_record['created'];?></span>
					<!-- Proposal issuance and ending date -->
					
					</div>
				
				
			</div>
			
			<div class="col-md-12 row" style="border-bottom:2px solid #000;padding-bottom:10px;">
			<strong>Project Name: <?php echo ucfirst($estimation_record[ 'project_name' ]); ?></strong>
			</div>
			<table class="table panel">
									<?php  $s=0;foreach($estimation_main_items as $k => $main_items ) {		 ?>
									
					<tr>
						<th class="col-md-7 ">
							<?php echo  lang( 'description' ) ?>
						</th>
						<th class="col-md-1 text-right ">
							<?php echo  lang( 'quantity' ) ?>
						</th>
						<th class="col-md-1 text-right ">
							Unit <?php echo  lang( 'price' ) ?>
						</th>
						<th class="col-md-1 text-right ">
							Tax(%)
						</th>
						
						<th class="col-md-2 text-right ">
							Total(AED)
						</th>
					</tr>
				
				<tbody>

					<tr>
						<td class="text-left robotolight">
							<?php echo '' . $main_items['item_name'] . '<br>'; ?>
						</td>
						<td class="text-right robotolight">
							<?php echo '' . number_format( $main_items[ 'quantity' ], 2, '.', ',' ) . '' ?>
						</td>
						<td class="text-right robotolight">
							<?php echo '' . number_format( $main_items[ 'unit_price' ], 2, '.', ',' ) . ''; ?>
						</td>
						
						<td class="text-right robotolight">
							<?php echo '' .  $main_items[ 'tax' ] . '%';?>
						</td>
						<td class="text-right robotolight">
							<?php echo '' . number_format( $main_items[ 'amount' ], 2, '.', ',' ) . ' ' . currency . '';?>
							<!-- You can change Number format as per your requirement
							i.e. number_format(number or amount, decimal_upto, decimal_separator, number_seperator)
							example: 1. number_format(12345.24, 3, '.', ',')  ===> 12,345.240 -->
						</td>
					</tr>
					 <tr class="subitems<?php print $s;?>" >
                     <td colspan="5" style="background: #fff;padding: 0px;">
					 <table class="table table-bordered " style="margin-bottom: 0px;">
					 <tr >
						<th class="col-md-1 robotolight">
							#
						</th>
						
						<th class="col-md-1 robotolight">
							Material Description
						</th>
						<th class="col-md-1 robotolight">
							Qty
						</th>
						
						<th class="col-md-2 text-right robotolight">
							Unit Cost
						</th>
						<th class="col-md-2 text-right robotolight">
							Total Cost
						</th>
						<th class="col-md-2 text-right robotolight">
							Margin %
						</th>
						<th class="col-md-2 text-right robotolight">
							Selling Price
						</th>
					</tr>
					<?php $t=1;foreach($estimation_sub_items as $l => $sub_items) { 
				
						
					 if($main_items['main_item_id'] == $sub_items['main_item_id']) { 
					 ?> 
					
<tr>
						<td class="text-left">
							<?php print $t;?>
						</td>
					
						<td class="text-left">
							 <?php if(is_numeric($sub_items['name'])){ echo $sub_items['itemname'];}else{ echo $sub_items['name'];} ?>
						</td>
						
						<td class="text-left">
							                                <?php echo $sub_items['qty']; ?>
						</td>
						<td class="text-right">
						 <?php echo number_format($sub_items['unit_cost'],2, '.', ','); ?>
							
						</td>
						<td class="text-right">
						 <?php echo number_format($sub_items['total_cost'],2, '.', ','); ?>
							
						</td>
						<td class="text-right">
						 <?php echo number_format($sub_items['margin'],2, '.', ','); ?>
							
						</td>
						<td class="text-right">
						 <?php echo number_format($sub_items['selling_price'],2, '.', ','); ?>
							
						</td>
					</tr>
                  
					
				  
				  
				 
					<?php $t++;?><?php } ?>
					
					<?php   }  ?>
                     
                         </table>
                  
                    </td>
                    </tr>
					
					<tr class="subitems<?php print $s;?>" >
					<td colspan="5" style="background: #fff;padding: 0px;border-top: hidden;">
						<table class="table ">
					 <tr >
					 <?php $profit=$main_items['sub_tot_sp']-$main_items['sub_tot_cost'];?>
					 <td class="text-right robotobold" style="width:60%;border-top: hidden;">Item Profit:<?php print number_format($profit,2);?> </td>
					 <td  class="text-right robotobold" style="padding-right:2%;border-top: hidden;">Item Cost:<?php print number_format($main_items['sub_tot_cost'],2);?></td>
					 </tr>
					 </table>
					
					</td>
					
					</tr>
					<?php $s++;} ?>
				</tbody>
			</table>
			<div class="col-md-12 col-xs-12 col-sm-12" >
			<div class="col-md-6 col-xs-6 col-sm-6  pull-left" style="padding: 0px;">
			<table class="table table-bordered"><tr><th>Total Cost:</th><td><?php echo '' . number_format( $estimation_record[ 'estimation_total_cost_amt' ], 2, '.', ',' ) . ' ' ?></td></tr><tr><th>Estmated Profit:</th><td><?php echo '' . number_format( $estimation_record[ 'estimation_profit_amt' ], 2, '.', ',' ) . ' ' ?></td></tr></table>
			
			</div>
			<?php /*
				<div class="col-md-6 col-xs-6 col-sm-6 panel pull-left" style="padding: 0px;">
				
					<strong><?php echo lang('from') ?></strong><br>
					<hr>
					<small>
						<strong><?php echo ($settings['company']) ? $settings['company'] : ""	; ?></strong>  <!-- Company Name from app settings -->
					</small>
					<br>
					<small>
						<!-- Company Address -->
						<?php echo '' .($settings[ 'town' ] ? $settings[ 'town' ].'/' : '').($settings[ 'city' ] ? $settings[ 'city' ].'/':'').($state ? $state.'/' : '').($country ? $country.'-':'').($settings[ 'zipcode' ] ? $settings[ 'zipcode' ] : '')  ?>
					</small><br>
					<small>
						<!-- Company Phone -->
						<?php echo $settings[ 'phone' ]; ?>
					</small><br>
					<small>
						<!-- Company Taxoffice & vatnumber -->
						<!-- You can remove these if don't want to display these in pdf -->
						<strong><?php echo  ($settings[ 'taxoffice' ] ? $appconfig['tax_label'].' '.lang('taxoffice').':' : '') ?></strong><?php echo $settings[ 'taxoffice' ]; ?>
					</small><br>
					<small>
						<?php echo '<strong>'.($settings[ 'vatnumber' ] ? $appconfig['tax_label'].' '.lang( 'vatnumber' ).':' : '') .'</strong>' . $settings[ 'vatnumber' ] . ''; ?>
					</small>
				
					
				</div>*/?>
				<div class="col-md-5 col-xs-5 col-sm-5 pull-right" >
				
				
					<div class="list-group">
						<li class="list-group-item">
							<strong>
								<?php echo lang( 'subtotal' ); ?>
							</strong>
							<span class="">
								<?php echo '' . number_format( $estimation_record[ 'subtotal_amt' ], 2, '.', ',' ) . ' ' ?>
							</span>
						</li>
						<li class="list-group-item">
							<strong>
								TOTAL DISCOUNT:
							</strong>
							<span class="">
								<?php echo '' . number_format( $estimation_record[ 'discount' ], 2, '.', ',' ) . ' ' ?>
							</span>
						</li>
						<li class="list-group-item">
							<strong>
								TOTAL VAT ON SALES (5%):
							</strong>
							<span class="">
								<?php echo '' . number_format( $estimation_record[ 'estimation_tax_amount' ], 2, '.', ',' ) . '' ?>
							</span>
						</li>
						<li class="list-group-item active">
							<strong>
								GRAND TOTAL(AED)
							</strong>
							<span class="">
								<?php echo '' . number_format( $estimation_record[ 'estimation_total_amt' ], 2, '.', ',' ) . ''; ?>
							</span>
						</li>
					</div>
				</div>
			</div>
			
				
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12" >
		<?php if(!empty($estimation_record['special_notes'])){?>
	<div class="" style="border-bottom: 1px dashed #000;
    padding-bottom: 10px;margin-bottom: 10px;">
			<b>Remarks:</b>
			</div>
			<p>
			<?php print $estimation_record['special_notes'];?> </p>
		<?php }?>
				<?php if(!empty($customer_record['terms_and_conditions'])){?>
	
	<div class="" style="border-bottom: 1px dashed #000;
    padding-bottom: 10px;margin-bottom: 10px;">
			<b>Terms And Conditions:</b>
			</div>
			<p>
			<?php print $customer_record['terms_and_conditions'];?>
 </p><?php }?>
 </div>
	</div>
	</div>
	
</body>
</html>

<?php //exit;?>