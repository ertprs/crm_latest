<?php

$salestarget_id =  $_POST["salestargetid"];
$salesdata = get_salestargetdata($salestarget_id);
?>

<style>
	.tablehead {
		background: cadetblue;
		color: white;
	}
</style>


<div class="input-card">
	<button class="btn subhead-text text-danger add-salesperson" tabindex="28">+ADD</button>
	<div class="table-responsive">
		<form id="sales_target">
			<table class="table" id="salesper_target">
				
				<tr>
					<td style="width: 20%;">Sales person</td>
					<td>Q1</td>
					<td>Q2</td>
					<td>Q3</td>
					<td>Q4</td>
				</tr>
				<?php
							if (isset($salesdata)) {
								foreach ($salesdata as $row) {
									echo'									
										<tr >
											<td style="width: 20%;">'.$row["staffname"].'</td>
											<td>'.$row["qtr1"].'</td>
											<td>'.$row["qtr2"].'</td>
											<td>'.$row["qtr3"].'</td>
											<td>'.$row["qtr4"].'</td>
											<td><button  tabindex="28">Edit</button></td>
										</tr>';
									}
								}
								?>
			</table>
		</form>
		<div id="sales_targethtml" style="color: green;"></div>
	</div>
	<div class="col-md-12">
		<table class="table table-striped table-hover compact hover table-bordered nowrap table-responsive" style="text-align:center;" width="100%" id="view_allsalestarget">
			<tr>
				<td style="width: 20%;">Sales person</td>
				<td>Q1</td>
				<td>Q2</td>
				<td>Q3</td>
				<td>Q4</td>
				<td>Edit</td>
			</tr>
			<?php
			if (isset($saledata)) {
				foreach ($saledata as $row) {
					echo '									
						<tr >
							<td style="width: 20%;">' . $row["staffname"] . '</td>
							<td>' . $row["qtr1"] . '</td>
							<td>' . $row["qtr2"] . '</td>
							<td>' . $row["qtr3"] . '</td>
							<td>' . $row["qtr4"] . '</td>
							<td><button  tabindex="28">Edit</button></td>
						</tr>';
				}
			}
			?>
		</table>
	</div>
</div>