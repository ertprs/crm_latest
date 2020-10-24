function Document_Controller($scope, $http, $mdSidenav, $mdDialog, $filter) {
	"use strict";

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'staff').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});

	$http.get(BASE_URL + 'api/timezones').then(function (Timezones) {
		$scope.timezones = Timezones.data;
	});
	
		
	$scope.toggleFilter = showmodal();
	$scope.Create = buildToggler('Create');
	
	function showmodal(){
		return function () {
	    
	        $('#sidebar-filter').modal('show');

		};
	}
    
    
	$scope.ViewStaff = function (staff_id) {
	   	window.location.href = BASE_URL + 'staff/staffmember/' + staff_id;
	}; 
	
 	$scope.Update = buildToggler1('Update');
      
	function buildToggler(navID) {
	   
	    return function () {
	    
	        $mdSidenav(navID).toggle();
	         
	        

		};
		
	}


function buildToggler1(navID) {
    
	    return function () {
	        
	        $mdSidenav(navID).toggle();

		};
		
	} 

	$scope.close = function () {
	    $mdSidenav('ContentFilter').close();
		$mdSidenav('Create').close();
		$mdDialog.hide();
	};
	
	$scope.close = function () {
		$mdSidenav('Update').close();
		$mdDialog.hide();
	};

	
	
	
	$http.get(BASE_URL + 'api/matunittype').then(function (Departments) {
		$scope.unittypes = Departments.data;
		
		$scope.NewUnitType = function (event) {
			globals.createDialog($scope.lang.new+' '+$scope.lang.unit, $scope.lang.department_title+' '+$scope.lang.unit+' '+$scope.lang.name, $scope.lang.unit+' '+$scope.lang.name,  event, $scope.lang.add, $scope.lang.cancel, 'material/add_unit', function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/matunittype').then(function (Departments) {
						$scope.unittypes = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
        
		$scope.EditUnit = function (index) {
			
			var department = $scope.unittypes[index];
			globals.editDialog($scope.lang.update+' '+$scope.lang.unit, $scope.lang.department_title+' '+$scope.lang.unit+' '+$scope.lang.name, $scope.lang.status+' '+$scope.lang.name, department.name, '', $scope.lang.save, $scope.lang.cancel, 'material/update_unit/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/matunittype').then(function (Departments) {
						$scope.unittypes = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};

		$scope.DeleteUnit = function (index) { 
			var department = $scope.unittypes[index];
			globals.deleteDialog($scope.lang.delete+' '+$scope.lang.unit, $scope.lang.delete_meesage+' '+$scope.lang.unit+'?', department.id, $scope.lang.delete, $scope.lang.cancel, 'material/remove_unit/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/matunittype').then(function (Departments) {
						$scope.unittypes = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
	});

	
	

		

		$scope.DeleteLeadStatus = function (index) { 
			var status = $scope.leadstatuses[index];
			globals.deleteDialog($scope.lang.delete+' '+$scope.lang.status, $scope.lang.delete_meesage+' '+$scope.lang.status+'?', status.id, $scope.lang.delete, $scope.lang.cancel, 'leads/remove_status/'+status.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/departments').then(function (Departments) {
						$scope.departments = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};
		
		$http.get(BASE_URL + 'api/doccategories').then(function (Departments) {
		$scope.docscat = Departments.data;

		$scope.NewDepartment = function (event) {
			globals.createDialog($scope.lang.new+' '+$scope.lang.category, $scope.lang.department_title+' '+$scope.lang.category+' '+$scope.lang.name, $scope.lang.category+' '+$scope.lang.name,  event, $scope.lang.add, $scope.lang.cancel, 'document/add_department', function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/doccategories').then(function (Departments) {
						$scope.docscat = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
		
	
        
		$scope.EditDepartment = function (index) {
			var department = $scope.docscat[index];
			globals.editDialog($scope.lang.update+' '+$scope.lang.category, $scope.lang.department_title+' '+$scope.lang.category+' '+$scope.lang.name, $scope.lang.status+' '+$scope.lang.name, department.name, '', $scope.lang.save, $scope.lang.cancel, 'document/update_department/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/doccategories').then(function (Departments) {
						$scope.docscat = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};

		$scope.DeleteDepartment = function (index) { 
			var department = $scope.docscat[index];
			globals.deleteDialog($scope.lang.delete+' '+$scope.lang.category, $scope.lang.delete_meesage+' '+$scope.lang.category+'?', department.id, $scope.lang.delete, $scope.lang.cancel, 'document/remove_department/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/doccategories').then(function (Departments) {
						$scope.docscat = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
	});


	$scope.statuss = [
	    { id: 1, name: 'Active' },
	    { id: 2, name: 'In-Active' },
	    { id: 3, name: 'Cancelled' },
	    { id: 4, name: 'Terminated'},
	    { id: 5, name: 'Onvacation'},
	    { id: 6, name: 'Payroll'},
	    { id: 7, name: 'Rejected'}
	  ];

	  $scope.grade = [
	    { id: 1, name: 'A Grade' },
	    { id: 2, name: 'B Grade' },
	    { id: 3, name: 'C Grade' },
	    { id: 4, name: 'D Grade'},
	    { id: 5, name: 'E Grade'}
	  ];

	   $scope.gender = [
	    { id: 1,  name: 'Male' },
	    { id: 2,  name: 'Female' },
	  ];

	
	$http.get(BASE_URL + 'api/languages').then(function (Languages) {
		$scope.languages = Languages.data;
	});

	$http.get(BASE_URL + 'settings/permission/').then(function (Permissions) {
		$scope.permissions = Permissions.data;
	});

	$http.get(BASE_URL + 'settings/get_roles/').then(function (Roles) {
		$scope.roles = Roles.data;
	});

	$scope.checkType = function (type) {
		$http.get(BASE_URL + 'settings/permission/' + type).then(function (Permissions) {
			$scope.permissions = Permissions.data;
		});
	};
	$scope.open_pinned = function (type) {
		$http.get(BASE_URL + 'staff/get_pin').then(function (Pinned) {
			$scope.pinned = Pinned.data;
		});

	}
	$scope.open_pinned();
	$scope.open_payrol = function (type) {
		$http.get(BASE_URL + 'staff/payroll').then(function (Payroll) {
			$scope.payroll = Payroll.data;
		});
	}
    $scope.open_payrol();
	$scope.update_status = function (checked_status,type,id) {
		//alert(checked_status +"--"+ type +"--"+id);
		var status_value = 1;
		if(checked_status == true ) {
			var status_value= 0
		}
		
		$http.get(BASE_URL + 'staff/update_stauts/' + id +"/"+type+"/"+status_value).then(function (Permissions) {
			if(type == 2){
				$scope.open_pinned();
				}
				if(type ==3){
					$scope.open_payrol();
				}
		});

	}
	

	$scope.showList = true;
	$scope.open_students = function (type) {
		$scope.staff_list = {
		order: '',
		limit: 20,
		page: 1
	};

	$scope.saving = false;
	$http.get(BASE_URL + 'document/get_all_materials/' + type).then(function (Staff) {
		$scope.staff = Staff.data;
		$scope.limitOptions = [20, 40, 60, 80];
		if ($scope.staff.length > 80) {
			$scope.limitOptions = [20, 40, 60, 80, $scope.staff.length];
		}
		$scope.itemsPerPage = 6;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 6;
			var ps = [];
			var start;
			start = $scope.currentPage;
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}
			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};
		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};
		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};
		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};
		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};
		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};
		$scope.pageCount = function () {
			return Math.ceil($scope.staff.length / $scope.itemsPerPage) - 1;
		};

	
        
		$scope.AddStaff = function(){
			$scope.saving = true;
			$scope.tempArr = [];
			angular.forEach($scope.custom_fields, function (value) {
				if (value.type === 'input') {
					$scope.field_data = value.data;
				}
				if (value.type === 'textarea') {
					$scope.field_data = value.data;
				}
				if (value.type === 'date') {
					$scope.field_data = moment(value.data).format("YYYY-MM-DD");
				}
				
				if (value.type === 'select') {
					$scope.field_data = JSON.stringify(value.selected_opt);
				}
				$scope.tempArr.push({
					id: value.id,
					name: value.name,
					type: value.type,
					order: value.order,
					data: $scope.field_data,
					relation: value.relation,
					permission: value.permission,
				});
			});
			var dataObj = $.param({
				name: $scope.staff.name,
				employee_no: $scope.staff.employee_no,
				email: $scope.staff.email,
				phone: $scope.staff.phone,
				nomineephone: $scope.staff.nomineephone,
				department: $scope.staff.department_id,
				language: $scope.staff.language,
				status: $scope.staff.status,
				remark: $scope.staff.remark,
				grade: $scope.staff.grade,
				gender: $scope.staff.gender,
				homeaddress: $scope.staff.homeaddress,
				address: $scope.staff.address,
				password: $scope.passwordNew,
				timezone: $scope.staff_timezone,
				custom_fields: $scope.tempArr,
				role: $scope.staff.assigned_role,
				joining_date:moment($scope.joining_date).format("YYYY-MM-DD"),
				date_of_birth:moment($scope.date_of_birth).format("YYYY-MM-DD"),
				profession: $scope.staff.profession,
				nominee: $scope.staff.nominee,
				nationality: $scope.staff.nationality,
			});
            


			var posturl = BASE_URL + 'staff/createStaff/';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.saving = false;
						if (response.data.success == true) {
							globals.mdToast('success', response.data.message);
							$mdSidenav('Create').close();
							$http.get(BASE_URL + 'staff/get_staff/').then(function (Staff) {
								$scope.staff = Staff.data;
								//$scope.staff.admin = true;
								$scope.tabIndex--;
							});
						} else {
							globals.mdToast('error', response.data.message, 7000);
						}
					},
					function (response) {
						$scope.saving = false;
					}
				);
	
		};
		
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.staff || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};

		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		// Filtered Datas
		$scope.search = {
			name: '',
		};
	});
	}
	$scope.open_students(0);
	
	
}


CiuisCRM.controller('Document_Controller', Document_Controller);
