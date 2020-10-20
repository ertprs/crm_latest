function QuoteRequest_Controller($scope, $http, $mdSidenav,$mdDialog, $q, $timeout,$parse,fileUpload) {
	"use strict";
	
	$http.get(BASE_URL + 'quoterequest/get_all_customers/').then(function (Customers) {
		$scope.customers = Customers.data;
	});
	
	$http.get(BASE_URL + 'quoterequest/get_all_sales_staff').then(function (Staff) {
		$scope.staffs = Staff.data;
	});
	
	$scope.ChangeCustomer = function(cust) {
		$http.get(BASE_URL +'quoterequest/get_client_contacts/'+cust).then(function (Customersdata) {
			//console.log(Customersdata.data.salesteamid);
			$('#client_contact_id').html(Customersdata.data.contact);
			//$('#salesteam').html(Customersdata.data.supplier);
			$('#salesteamid').val(Customersdata.data.salesteamid);
			$('.my-select').selectpicker();
		});
	}
	
	$scope.UploadFile = function (ev) {
		$mdDialog.show({
			templateUrl: 'addfile-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};
	$scope.close = function () {
		$scope.uploading= false; 
		$mdDialog.hide();
	};
	
	$scope.CloseModal = function () {
		$mdDialog.hide();
	};
	
	var formdata = new FormData();
	$scope.getTheFiles = function ($files) {              
		angular.forEach($files, function (value, key) {
			formdata.append(key, value);
		});
	};
	
	$scope.uploadFiles = function(){
		var uploadUrl = BASE_URL+'quoterequest/add_file/';
		var request = {
			   method: 'POST',
			   url: uploadUrl,
			   data: formdata,
			   headers: {
				   'Content-Type': undefined
			   }
		};
	   $http(request).then(function(response){
			if (response.data.success == true){
        		globals.mdToast('success', response.data.message);
        	} else {
        		globals.mdToast('error', response.data.message);
        	}
        	$scope.quoterequestFiles = true;
        	$http.get(BASE_URL + 'quoterequest/quoterequestfilesbysession/').then(function (Files) {
        		$scope.files = Files.data;
        		$scope.quoterequestFiles = false;
        	});
        	$scope.uploading = false;
        	$mdDialog.hide();
		});
	}
	
	$scope.ViewFile = function(index, image) {
		console.log(index);
		$scope.file = $scope.files[index];
		$mdDialog.show({
			templateUrl: 'view_image.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: $scope.file.id
		});
	}
	
	$scope.ViewPdfFile = function(index, image) {
		var id = $scope.files[index];
		var filepath=id.path;
		var fileid=id.id;
		var buton='  <a href="'+BASE_URL+'quoterequest/download_file/'+fileid+'" aria-label="add" class="btn btn-primary btn-lg">Download!</a>';
		$('#buttons').html(buton);
		$('#imagepdf').attr('src',filepath);
		$('#myModal').modal('show');
	}
	
	$scope.DeleteFile = function(id) {
		var confirm = $mdDialog.confirm()
			.title($scope.lang.delete_file_title)
			.textContent($scope.lang.delete_file_message)
			.ariaLabel($scope.lang.delete_file_title)
			.targetEvent(id)
			.ok($scope.lang.delete)
			.cancel($scope.lang.cancel);

		$mdDialog.show(confirm).then(function () {
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'quoterequest/delete_file/' + id, config)
				.then(
					function (response) {
						if(response.data.success == true) {
							showToast(NTFTITLE, response.data.message, ' success');
							$http.get(BASE_URL + 'quoterequest/quoterequestfilesbysession/').then(function (Files) {
								$scope.files = Files.data;
							});
						} else {
							showToast(NTFTITLE, response.data.message, ' danger');
						}
					},
					function (response) {
						console.log(response);
					}
				);

		}, function() {
			//
		});
	};
}

CiuisCRM.controller('QuoteRequest_Controller', QuoteRequest_Controller);

CiuisCRM.directive('ngFiles', ['$parse', function ($parse) {
	function fn_link(scope, element, attrs) {
		var onChange = $parse(attrs.ngFiles);
		element.on('change', function (event) {
			onChange(scope, { $files: event.target.files });
		});
	};
	return {
		link: fn_link
	}
} ]);