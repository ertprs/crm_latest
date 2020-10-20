function Attendance_Controller($scope, $compile, $http, $mdSidenav, $q, $timeout, $filter) {
	"use strict";

	globals.get_countries();
	$scope.InvoicesList = function() {
		$scope.loadingData = true;
		$http.get(BASE_URL + 'invoices/get_content/index').then(function (Data) {
			$scope.content = Data.data;
			var div = angular.element(document.getElementById("pageContent"));
			div.html($scope.content);
			$compile(div.contents())($scope);
			$scope.loadingData = false;
		});
	};
	
		$scope.Create = function () {
		    var dataObj = '';
		    var posturl = BASE_URL + 'deposits/create/';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				$scope.savingDeposit = false;
				if (response.data.success == true) {
					window.location.href = BASE_URL + 'deposits/deposit/' + response.data.id;
				} else {
					$scope.savingDeposit = false;
					globals.mdToast('error', response.data.message);
				}
			}
			);
		    
		};

}

CiuisCRM.controller('Attendance_Controller', Attendance_Controller);
