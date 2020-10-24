function Contacts_Controller($scope, $http, $mdSidenav, $q, $timeout, $filter) {
	"use strict";

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'order').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});

	$http.get(BASE_URL + 'api/staff').then(function (Staff) {
		$scope.staff = Staff.data;
	});



	$scope.remove = function (index) {
		$scope.order.items.splice(index, 1);
	};

	$scope.saveAll = function () {
		alert('ffffffff')
		var dataObj = $.param({
			cname: $scope.cname,
			cemail: $scope.cemail,
			cperson: $scope.cperson,
			cnum: $scope.cnum,
			keyword_content: $scope.keyword_content,
			date: moment($scope.created).format("YYYY-MM-DD"),
			created: moment($scope.created).format("YYYY-MM-DD"),
			address: $scope.address,
			chooseFile: $scope.chooseFile,
		});
		var posturl = BASE_URL + 'contacts/create';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if (response.data.success == true) {
						window.location.href = BASE_URL + 'orders/order/' + response.data.id;
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};	
}

CiuisCRM.controller('Payroll_Controller', Contacts_Controller);
CiuisCRM.controller('Payroll_Controller', Contacts_Controller);