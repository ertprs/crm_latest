<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php');



?>









<style>

	.container {

		max-width: 1170px;

		margin: auto;

	}



	img {

		max-width: 100%;

	}



	.inbox_people {

		background: #f8f8f8 none repeat scroll 0 0;

		float: left;

		overflow: hidden;

		width: 20%;

		border-right: 1px solid #c4c4c4;

		height: auto;

	}



	.inbox_msg {

		border: 1px solid #c4c4c4;

		clear: both;

		overflow: hidden;

	}



	.top_spac {

		margin: 20px 0 0;

	}





	.recent_heading {

		float: left;

		width: 40%;

	}







	.headind_srch {

		padding: 10px 29px 10px 20px;

		overflow: hidden;

		border-bottom: 1px solid #c4c4c4;

	}



	.recent_heading h4 {

		color: #05728f;

		font-size: 21px;

		margin: auto;

	}



	.srch_bar input {

		border: 1px solid #cdcdcd;

		border-width: 0 0 1px 0;

		width: 80%;

		padding: 2px 0 4px 6px;

		background: none;

	}



	.srch_bar .input-group-addon button {

		background: rgba(0, 0, 0, 0) none repeat scroll 0 0;

		border: medium none;

		padding: 0;

		color: #707070;

		font-size: 18px;

	}



	.srch_bar .input-group-addon {

		margin: 0 0 0 -27px;

	}



	.chat_ib h5 {

		font-size: 13px;

		color: black;

		margin: 0 0 8px 0;

		font-family: 'Montserrat', sans-serif;

		font-weight: bold;

	}



	.chat_ib h5 span {

		font-size: 13px;

		float: right;

		font-family: 'Montserrat', sans-serif;



	}



	.chat_ib p {

		font-size: 14px;

		color: #989898;

		margin: auto

	}



	.chat_img {

		float: left;

		width: 11%;

		height: 50px;



	}



	.chat_ib {

		float: left;

		padding: 0 0 0 15px;

		width: 88%;

	}



	.chat_people {

		overflow: hidden;

		clear: both;

	}



	.chat_list {

		border-bottom: 1px solid #c4c4c4;

		margin: 0;

		padding: 18px 16px 10px;

	}



	.inbox_chat {

		height: 800px;

		overflow-y: scroll;

		background-color: whitesmoke;

	}



	.active_chat {

		background: white;

	}



	.incoming_msg_img {

		display: inline-block;

		width: 6%;

	}



	.received_msg {

		display: inline-block;

		padding: 0 0 0 10px;

		vertical-align: top;

		width: 92%;

	}



	.received_withd_msg p {

		background: #ebebeb none repeat scroll 0 0;

		border-radius: 3px;

		color: #646464;

		font-size: 14px;

		margin: 0;

		padding: 5px 10px 5px 12px;

		width: 100%;

	}



	.time_date {

		color: #747474;

		display: block;

		font-size: 12px;

		margin: 8px 0 0;

	}



	.received_withd_msg {

		width: 57%;

	}



	.mesgs {

		float: left;

		padding: 30px 15px 0 0px;

		width: 80%;

	}



	.sent_msg p {

		background: #05728f none repeat scroll 0 0;

		border-radius: 3px;

		font-size: 14px;

		margin: 0;

		color: #fff;

		padding: 5px 10px 5px 12px;

		width: 100%;

	}



	.outgoing_msg {

		overflow: hidden;

		margin: 26px 0 26px;

	}



	.sent_msg {

		float: right;

		width: 46%;

	}



	.input_msg_write input {

		background: rgba(0, 0, 0, 0) none repeat scroll 0 0;

		border: medium none;

		color: #4c4c4c;

		font-size: 15px;

		min-height: 48px;

		width: 100%;

	}



	.type_msg {

		border-top: 1px solid #c4c4c4;

		position: relative;

	}



	.msg_send_btn {

		background: #05728f none repeat scroll 0 0;

		border: medium none;

		border-radius: 50%;

		color: #fff;

		cursor: pointer;

		font-size: 17px;

		height: 33px;

		position: absolute;

		right: 0;

		top: 11px;

		width: 33px;

	}



	.messaging {

		padding: 0 0 0 0;

	}



	.msg_history {

		height: 516px;

		overflow-y: auto;

	}



	.tablehead {

		background: cadetblue;

		color: white;

	}



	.rcorners2 {

		border-radius: 25px;

		border: 2px solid black;

		padding: 20px;

	}



	img {

		border-radius: 50%;

	}



	.customercss {

		font-family: 'Montserrat', sans-serif;

		font-weight: 300;

		font-size: 13px;

	}

	

	.modal-header {

		border-bottom:1px solid #e5e5e5 !important;

	}

</style>

<div class="ciuis-body-content lead-single">

	<div class="main-content container-fluid col-md-12 borderten">

		<form action="<?php echo base_url('salesoverview/create') ?>" method="post" enctype="multipart/form-data" onsubmit="return checkProject()">

			<md-toolbar class="toolbar-white lead-user">

				<div class="md-toolbar-tools">

					<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">

						<md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>

					</md-button>

					<h2 flex md-truncate>Sales Overview</h2>

					<div>

						<button class="btn  btn-warning" type="button">Export </button>

						<button class="btn  btn-warning" type="button" data-toggle="modal" id="salesoverviewBtn">Setting </button>

					</div>

				</div>

			</md-toolbar>

			<md-content class="bg-white orders-data" layout-padding ng-cloak style="height:auto;">

				<div class="messaging">

					<div class="inbox_msg">

						<div class="inbox_people sidebar-left">

							<div class="headind_srch md-toolbar-tools">

								<!-- <div class="recent_heading"> -->

									<h2>Team</h2>

								<!-- </div> -->



							</div>

							<div class="inbox_chat left-sidebar">

								<?php

								if (isset($staff)) {

									foreach ($staff as $row) {

										$url = $row["staffavatar"];

										$staff_id  = $row['id'];

								?>

										<div class="chat_list active_chat" style="cursor: pointer;" onclick=getSalesDatabysaffid(<?php echo $staff_id ?>)>

											<div class="chat_people">

												<div class="chat_img"> <img src=<?php echo base_url() . 'uploads/images/' . $url ?>> </div>

												<div class="chat_ib">

													<h5><?php echo $row["staffname"]; ?><span class="chat_date"><?php echo $row["total_sales"]; ?></span></h5>



												</div>

											</div>

										</div>

								<?php

									}

								}

								?>

							</div>

						</div>

						<div class="mesgs">



							<div class="col-md-12 rcorners2">



								<!-- <div class="col-md-2">



								</div> -->

								<div class="card-body col-md-10 col-md-2">

									<div id="container"></div>

								</div>

							</div>

							<div class="col-md-12">

								<!-- <div class="col-md-2"></div> -->

								<div id="chart-container" class="col-md-4 customercss" style="height: 300px;"></div>

								<div class="col-md-6" style="overflow-y:scroll;height:300px;">

									<table border="0" class="table table-bordered" id="company_data">

										<thead>

											<th style="color: white;    background: cadetblue;">Sr .no</th>

											<th style="color: white;    background: cadetblue;">Customer Name</th>

											<th style="color: white;    background: cadetblue;">Revenue</th>

										</thead>

										<tbody style="color: darkred;" id="companydetails">



										</tbody>

									</table>

								</div>

							</div>



						</div>







					</div>

				</div>





			</md-content>

		</form>

	</div>





</div>





<!--<ciuis-sidebar></ciuis-sidebar>-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="exampleModalLabel">Setting</h5>

				<button type="button" class="close modalCloseBtn" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">&times;</span>

				</button>

				<div class="col-md-12">

				<div class="col-md-8"></div>

				<div class="col-md-4">

					<?php $currentYear=date('Y');?>

					<select class="form-control selectyear" name="selectyear" data-width="50%" data-live-search="true" id="selectyear" data-container="body">

						<option value="2020" <?php $currentYear == '2020' ? ' selected="selected"' : '';?>>2020</option>

						<option value="2021" <?php $currentYear == '2021' ? ' selected="selected"' : '';?>>2021</option>

						<option value="2022" <?php $currentYear == '2022' ? ' selected="selected"' : '';?>>2022</option>

						<option value="2023" <?php $currentYear == '2023' ? ' selected="selected"' : '';?>>2023</option>

						<option value="2024" <?php $currentYear == '2024' ? ' selected="selected"' : '';?>>2024</option>

						<option value="2025" <?php $currentYear == '2025' ? ' selected="selected"' : '';?>>2025</option>

					</select>

					</div>

				</div>

			</div>

			<div class="modal-body">

			    

				<i class="ion-android-add-circle text-success add-salesperson" style="float:right;cursor:pointer;"></i>

				<div class="input-card">

					<div class="table-responsive">

						<form id="sales_target">

							<table class="table" id="salesper_target" style="border-top:0px;">

								<tr>

									<td style="width: 25%;">Sales person</td>

									<td>Q1</td>

									<td>Q2</td>

									<td>Q3</td>

									<td>Q4</td>

									<td></td>

								</tr>

								<tr class="calbillvolume_parent" id="editDiv" style="display:none">

									<td style="width: 25%;">

										<input type="text" class="form-control" id="edit_salesperson_name" readonly tabindex="25"/>

										<input type="hidden" class="form-control" id="edit_salesperson_id" name="edit_salesperson_id" tabindex="25"/>

										<input type="hidden" class="form-control" id="sales_overview_id" name="sales_overview_id" tabindex="25"/>

									</td>

									<td><input type="text" class="form-control salesperQ1" id="edit_salesperQ1" name="q1editamount" tabindex="25"/></td>

									<td><input type="text" class="form-control" id="edit_salesperQ2" name="q2editamount"  tabindex="26"/></td>

									<td><input type="text" class="form-control" id="edit_salesperQ3" name="q3editamount" tabindex="27"/></td>

									<td><input type="text" class="form-control" id="edit_salesperQ4" name="q4editamount" tabindex="27"/></td>

									<td></td>

								</tr>

								<tr class="calbillvolume_parent" id="addDiv">

									<td style="width: 25%;">

										<select class="form-control salesperson sales_person_list" name="sale_peruid[]" data-width="100%" data-live-search="true" id="" data-container="body">

										</select>

									</td>

									<td><input type="text" class="form-control  salesperQ1" name="q1amount[]" tabindex="25"></td>

									<td><input type="text" class="form-control  salesperQ2" name="q2amount[]" tabindex="26"></td>

									<td><input type="text" class="form-control  salesperQ3" name="q3amount[]" tabindex="27"></td>

									<td><input type="text" class="form-control  salesperQ4" name="q4amount[]" tabindex="27"></td>

									<td><button class="delete-salepercol " tabindex="28">X</button></td>

								</tr>

								

							</table>

							<div class="pull-right">

								<button type="button" class="btn btn-primary add-btn" onclick="addsalestargetforstaff()">Save changes</button>

								<button style="display:none" type="button" class="btn btn-primary update-btn" onclick="updatesalestargetforstaff()">Update changes</button>

							</div>

						</form>

						<div id="sales_targethtml" style="color: green;"></div>

					</div>

					<div class="col-md-12" class="customercss" id="sales_table_data" style="margin-top:20px;">

					

					</div>

				</div>

			</div>

			<div class="modal-footer">



			</div>

		</div>

	</div>

</div>

<!--Script--->



<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>

<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/salesoverview.js'); ?>"></script>

<?php include_once(APPPATH . 'views/inc/validate_footer.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>

<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>



<!-- Latest compiled and minified CSS -->



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">



<!-- Latest compiled and minified JavaScript -->







<script type='text/javascript'>

	$(document).ready(function() {

		$('#view_allsalestarget').DataTable();

		var output = '';

		$.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>Salesoverview/get_all_customers",

			success: function(result) {

				var response = $.parseJSON(result);

				$.each(response, function(key, item) {

					output += "<tr>";

					output += "<td></td>";

					output += "<td>" + item["company"] + "</td>";

					output += "<td>" + item["revenue"] + "</td>";

					output += "</tr>";



				})

				$('#companydetails').append(output)





			}

		});

		$('.selectpicker').selectpicker();

		$('#selectyear').on('change',function(){

			var currentYear=$('#selectyear').val();

			$('#sales_table_data').html('');

			$.ajax({

				type: "POST",

				url: "<?php echo base_url(); ?>Salesoverview/get_sales_data",

				data:{passyear:currentYear},

				success: function(result) {

					var finalresult =  JSON.parse(result);

					$('.sales_person_list').html(finalresult.staff);

					$('#sales_table_data').html(finalresult.result);

					$('#view_allsalestarget').DataTable();

				}

			});

		});

		

		$('.active_chat').on('click', function() {

			console.log('s');

			$('.active_chat').find('h5').css('color', '#000');

			$(this).find('h5').css('color','orange');

		});

		

		$('#salesoverviewBtn').on('click', function(){

			var currentYear=new Date().getFullYear();

			$('#sales_table_data').html('');

			$.ajax({

				type: "POST",

				url: "<?php echo base_url(); ?>Salesoverview/get_sales_data",

				data:{passyear:currentYear},

				success: function(result) {

					enableAdd();

					var finalresult =  JSON.parse(result);

					$('.sales_person_list').html(finalresult.staff);

					$('#sales_table_data').html(finalresult.result);

					$('#view_allsalestarget').DataTable();

				}

			});

			$('#exampleModal').modal('show');

		});



		google.charts.load("current", {

			"packages": ["bar"]

		});

		google.charts.setOnLoadCallback(column_chart);



		function column_chart() {

			var jsonData = $.ajax({

				url: "<?php echo base_url(); ?>Salesoverview/get_all_salesoverview",

				async: false,

				success: function(jsonData) {

					var options = {

						title: "Company Perfomance Report",

						width: 1000,

						height: 320,

						backgroundColor: 'transparent',

						bar: {

							groupWidth: "50%"

						},

						/* 	hAxis: {

    textStyle:{color: '#FFF'}

},

vAxis: {

    textStyle:{color: '#FFF'}

}, */

						colors: ['#304a5a', '#79b9e1'],

						bold: true,

						italic: true,

					};

					var data = google.visualization.arrayToDataTable($.parseJSON(jsonData));

					/* 	var chart = new google.visualization.ColumnChart(document.getElementById("container"));

					chart.draw(data, options);

 */

					var chart = new google.charts.Bar(document.getElementById('container'));



					chart.draw(data, google.charts.Bar.convertOptions(options));

				}

			}).responseText;

		}

		Company_meter();

		//highlishchart();

	});



	//var packagescloned = $("#salesper_target tr:last").clone();

	$(".add-salesperson").click(function(e) {

		e.preventDefault();

		var packagescloned = $("#salesper_target tr:last").clone();

		packagescloned.clone().appendTo("#salesper_target");

		packagescloned.find('.bootstrap-select').replaceWith(function() {

			return $('select', this);

		});

	});





	$("#salesper_target").on("click", ".delete-salepercol", function(e) {

		e.preventDefault();

		var trlenght = $("#salesper_target tr").length;

		if (trlenght <= 2) {

			alert("Cannot remove last table row");

			return;

		}

		$(this).closest("tr").remove();

	});

	

	function updatesalestargetforstaff(){

		var currentYear=$('#selectyear').val();

		var preId=$("#edit_salesperson_id").val();

		var OverviewId=$("#sales_overview_id").val();

		var edit_salesperQ1=$("#edit_salesperQ1").val();

		var edit_salesperQ2=$("#edit_salesperQ2").val();

		var edit_salesperQ3=$("#edit_salesperQ3").val();

		var edit_salesperQ4=$("#edit_salesperQ4").val();

		$.ajax({

				type: "POST",

				url: "<?php echo base_url(); ?>Salesoverview/updatesalestarget",

				data: {

					OverviewId:OverviewId,

					edit_salesperQ1:edit_salesperQ1,

					edit_salesperQ2:edit_salesperQ2,

					edit_salesperQ3:edit_salesperQ3,

					edit_salesperQ4:edit_salesperQ4

				},

				success: function(result) {

					$("#sales_targethtml").html("Data Saved successfully");

					$.ajax({

						type: "POST",

						url: "<?php echo base_url(); ?>Salesoverview/get_sales_data",

						data:{passyear:currentYear},

						success: function(result) {

							var finalresult =  JSON.parse(result);

							$('.sales_person_list').html(finalresult.staff);

							$('#sales_table_data').html(finalresult.result);

							$('#view_allsalestarget').DataTable();

						}

					});

				}

		});

	}

	function addsalestargetforstaff() {

		var items = []

		var saleperson=[];

		var checkUnique;

		var q1amount = document.getElementsByName("q1amount[]");

		var q2amount = document.getElementsByName("q2amount[]");

		var q3amount = document.getElementsByName("q3amount[]");

		var q4amount = document.getElementsByName("q4amount[]");

		var sale_peruid = document.getElementsByName("sale_peruid[]");

		for (var a = 0; a < sale_peruid.length; a++) {

			saleperson.push(sale_peruid[a].value);

			items.push({

				q1amount: q1amount[a].value,

				q2amount: q2amount[a].value,

				q3amount: q3amount[a].value,

				q4amount: q4amount[a].value,

				sale_peruid: sale_peruid[a].value,

			});

		}

		checkUnique=checkIfArrayIsUnique(saleperson);

		var currentYear=$('#selectyear').val();

		if(checkUnique==true){

			$.ajax({

				type: "POST",

				url: "<?php echo base_url(); ?>Salesoverview/addsalestarget",

				data: {

					items: items,

					passyear:currentYear,

				},

				success: function(result) {

					$("#sales_target").trigger("reset");

					$("#sales_targethtml").html("Data Saved successfully");

					$("#salesper_target").find("tr:not(:nth-child(1)):not(:nth-child(2))").remove();

					

					$.ajax({

						type: "POST",

						url: "<?php echo base_url(); ?>Salesoverview/get_sales_data",

						data:{passyear:currentYear},

						success: function(result) {

							var finalresult =  JSON.parse(result);

							$('.sales_person_list').html(finalresult.staff);

							$('#sales_table_data').html(finalresult.result);

							$('#view_allsalestarget').DataTable();

						}

					});

				}

			})	

		}else{

			alert('You selected the Same Person multiple times');

		}

	}

	function checkIfArrayIsUnique(myArray) {

	  return myArray.length === new Set(myArray).size;

	}

	function editsalestarget(salestarget_id) {

		var currentYear=$('#selectyear').val();

		$.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>Salesoverview/editsalestarget",

			data: {

				salestarget_id: salestarget_id,

				passYear:currentYear,

			},

			success: function(result) {

				var output = $.parseJSON(result);

				enableEdit();

				$("#salesper_target #edit_salesperson_id").val(output.user_id);

				$("#salesper_target #edit_salesperson_name").val(output.staffname);

				$("#salesper_target #sales_overview_id").val(salestarget_id);

				$("#salesper_target #edit_salesperQ1").val(output.qtr1);

				$("#salesper_target #edit_salesperQ2").val(output.qtr2);

				$("#salesper_target #edit_salesperQ3").val(output.qtr3);

				$("#salesper_target #edit_salesperQ4").val(output.qtr4);

				

			}

		})

	}

	

	function enableAdd(){

		//$('#sales_target')[0].reset();

		$("#sales_target").trigger("reset");

		$('#editDiv').css('display','none');

		$('#addDiv').css('display','table-row');

		$('.add-btn').css('display','block');

		$('.add-salesperson').css('display','block');

		$('.update-btn').css('display','none');

	}

	

	function enableEdit(){

		$('#sales_target')[0].reset();

		$(".add-btn").css("display", "none");

		$(".update-btn").css("display", "block");

		$('#editDiv').css("display", "table-row");

		$('#addDiv').css("display", "none");

		$('.add-salesperson').css("display", "none");

	}



	function Company_meter() {

		$.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>Salesoverview/get_companymetredata",



			success: function(result) {

				output = $.parseJSON(result);

				//var sales = output["sales"];

				var upperlimit = output["upperlimit"];

				var totalinvoice = output["totalinvoice"];

				var targetachieved = output["targetachieved"];

				var tickValueDistance = Number.parseFloat(upperlimit / 12);

				

				var Q1 = output['salesq1'];

				var Q2 = output['salesq2'];

				var Q3 = output['salesq3'];

				var Q4 = output['salesq4'];

				

				/*var q1jan = tickValueDistance;

				var q1feb = q1jan + tickValueDistance;

				var q1march = q1feb + tickValueDistance;



				var q2apr = q1march + tickValueDistance;

				var q2may = q2apr + tickValueDistance;

				var q2june = q2may + tickValueDistance;

				var q3july = q2june + tickValueDistance;

				var q3aug = q3july + tickValueDistance;

				var q3sep = q3aug + tickValueDistance;

				var q4oct = q3sep + tickValueDistance;

				var q4nov = q4oct + tickValueDistance;

				var q4dec = q4nov + tickValueDistance;*/

				

				

				const dataSource = {

					chart: {

						caption: "Artefact",

						subcaption: "2020",

						lowerlimit: "0",

						upperlimit: upperlimit,

						showvalue: "1",

						numbersuffix: "",

						theme: "fusion",

						/*majorTMColor: "#333333",

						majorTMAlpha: "100",

						majorTMHeight: "10",

						majorTMThickness: "2",

						minorTMColor: "#666666",

						minorTMAlpha: "100",

						minorTMHeight: "12",

						minorTMThickness: "1",

						majorTMNumber: "12",

						//	minorTMNumber: "3",*/

						editMode: "1",

						autoAlignTickValues: "1",

						manageValueOverLapping: "1",

						//tickValueDistance: tickValueDistance,

						showTickValues: "1",

						showLimits: "1"





					},

					colorrange: {

						color: [{

								minValue: "0",

								maxValue: Q1,

								code: "#2eb82e",

								label: "Q1"

							}, {

								minValue: Q1,

								maxValue: Q2,

								code: "#70db70",

								label: "Q2"

							}, {

								minValue: Q2,

								maxValue: Q3,

								code: "#adebad",

								label: "Q3"

							},

							{

								minValue: Q3,

								maxValue: Q4,

								code: "#b4db3d",

								label: "Q4"

							}

						]



					},

					dials: {

						dial: [{
							value: totalinvoice,
							//value: "250000",

							//tooltext: "<b>9%</b> lesser that target"

						}]

					},

					trendpoints: {

						point: [{
							startvalue: targetachieved,
							displayvalue: "Target",

							thickness: "2",

							color: "#E15A26",

							usemarker: "1",

							markerbordercolor: "#E15A26",
							markertooltext: targetachieved
						}]

					},



				};



				FusionCharts.ready(function() {

					var myChart = new FusionCharts({

						type: "angulargauge",

						renderAt: "chart-container",

						width: "100%",

						height: "100%",

						dataFormat: "json",

						dataSource

					}).render();



				});



			}

		})

	}



	function get_databystaffid(staff_uid) {

		$.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>Salesoverview/get_all_customers",

			data: {

				staff_uid: staff_uid

			},

			success: function(result) {

				var response = $.parseJSON(result);

				console.log(response)

				var output = "";

				$('#companydetails').html("");

				$.each(response, function(key, item) {

					output += "<tr>";

					output += "<td></td>";

					output += "<td>" + item["company"] + "</td>";

					output += "<td>" + item["revenue"] + "</td>";

					output += "</tr>";



				})

				$('#companydetails').append(output)





			}

		})

	}



	function getSalesDatabysaffid(staff_uid) {

		var jsonData = $.ajax({

			url: "<?php echo base_url(); ?>Salesoverview/get_all_salesoverview",

			async: false,

			type: "POST",

			data: {

				staff_uid: staff_uid

			},

			success: function(jsonData) {

				var options = {

					title: "Company Perfomance Report",

					width: 1000,

					height: 320,

					backgroundColor: 'transparent',

					bar: {

						groupWidth: "50%"

					},

					colors: ['#304a5a', '#79b9e1'],

					bold: true,

					italic: true,

				};

				var data = google.visualization.arrayToDataTable($.parseJSON(jsonData));

				var chart = new google.charts.Bar(document.getElementById('container'));

				chart.draw(data, google.charts.Bar.convertOptions(options));

			}

		}).responseText;

		get_databystaffid(staff_uid)





	}



	function highlishchart() {

		$.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>Salesoverview/get_companymetredata",



			success: function(result) {

				output = $.parseJSON(result);

				var sales = output["sales"];

				var postion_array = [Number.parseInt(sales[0]["minvalue"]), Number.parseInt(sales[0]["maxvalue"]), Number.parseInt(sales[1]["maxvalue"]), sales[2]["maxvalue"], sales[3]["maxvalue"]];

				console.log(postion_array);

				var upperlimit = Number.parseInt(output["upperlimit"]);

				var tickValueDistance = Number.parseFloat(upperlimit / 12);



				$('#chart-container').highcharts({

					chart: {

						type: 'gauge',

						alignTicks: false,

						plotBackgroundColor: null,

						plotBackgroundImage: null,

						plotBorderWidth: 0,

						plotShadow: false

					},



					title: {

						text: "Artifact"

					},



					tooltip: {

						enabled: true

					},



					pane: {

						startAngle: -100,

						endAngle: 100,

						background: null

					},



					plotOptions: {

						gauge: {

							dial: {

								baseWidth: 2,

								baseLength: '100%',

								radius: '100%',

								rearLength: 0

							},

							pivot: {

								radius: 5

							},

							dataLabels: {

								enabled: true

							}

						}

					},



					yAxis: [{

						min: 0,

						max: 500,

						tickPositions: [0, 100, 200, 300, 400],

						lineColor: '#933',

						lineWidth: 0,

						minorTickPosition: 'outside',

						tickLength: 5,

						minorTickLength: 15,

						tickInterval: 100,

						minorTickInterval: 41,



						labels: {

							distance: 12,

							//rotation: 'auto'

						},

						//categories: ['Grunder'],

						offset: 0,

						plotBands: [{

							from: -100,

							to: 0,

							thickness: 50,

							color: '#55BF3B',

						}, {

							from: 0,

							to: 100,

							thickness: 50,

							color: '#55BF3B',

						}, {

							from: 100,

							to: 202,

							thickness: 50,

							color: {

								linearGradient: {

									x1: 0,

									x2: 1,

									y1: 0,

									y2: 0

								},

								stops: [

									[0, '#55BF3B'], //green

									[1, '#DDDF0D'] //yellow

								]

							}

						}, {

							from: 200,

							to: 500,

							thickness: 50,

							color: {

								linearGradient: {

									x1: 0,

									x2: 1,

									y1: 0,

									y2: 0

								},

								stops: [

									[0, '#DDDF0D'], //yellow

									[1, '#ff0000'] //red

								]

							}

						}]

					}],



					series: [{

						data: [250]



					}]

				});

			}

		});





	}

</script>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/modules/data.js"></script>



<script src="https://code.highcharts.com/highcharts-more.js"></script>

<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>