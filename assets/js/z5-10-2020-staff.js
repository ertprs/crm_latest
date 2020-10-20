
function Staffs_Controller($scope, $http, $mdSidenav, $mdDialog, $filter) {
	"use strict";
	//$scope.panCardRegex = '/[A-Z]{5}\d{4}[A-Z]{1}/i';
	
	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'staff').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});
	/////Start Staus Add////////
	$http.get(BASE_URL + 'staff/get_status').then(function (AllStatus) {
			$scope.status = AllStatus.data;
	});
	$scope.ManageStatus = function(ev) {
		getStatus();
		///$mdSidenav('EventForm').close();
		$mdSidenav('ManageStatus').toggle();
	}
	$scope.neweventtype = false;
	$scope.addingEventType = false;
	function getStatus() {
		$http.get(BASE_URL + 'staff/get_status').then(function (AllStatus) {
			$scope.status = AllStatus.data;
		});
	}
	
	$scope.ShowStatusForm=function(){
		$scope.event_type = {
			name : '',
			color : '',
			id:0
		}
		$scope.neweventtype = true;
	}
	$scope.AddNewStatus = function(action) {
		$scope.addingEventType = true;
		if (!$scope.event_type) {
			var dataObj = $.param({
				name: '',
				color: ''
			});
		} else  {
			var dataObj = $.param({
				name: $scope.event_type.name,
				color: $scope.event_type.color
			});
		}
		var posturl = BASE_URL + 'staff/add_status';
		$http.post(posturl, dataObj, config)
		.then(
		function (response) {
			$scope.addingEventType = false;
			if (response.data.success == true) {
				showToast(NTFTITLE, response.data.message, 'success');
				getStatus();
				$scope.event_type.name='';
				$scope.neweventtype = false;
			} else {
				globals.mdToast('error', response.data.message);
			}
		},
		function (response) {
			$scope.addingEventType = false;
		}
		);
	}
	$scope.EditNewStatus = function(action) {
		$scope.addingEventType = true;
		if (!$scope.event_type) {
			var dataObj = $.param({
				name: '',
				color: ''
			});
		} else  {
			var dataObj = $.param({
				name: $scope.event_type.name,
				color: $scope.event_type.color
			});
		}
		var posturl = BASE_URL + 'staff/update_status/'+$scope.event_type.id;
		$http.post(posturl, dataObj, config)
		.then(
		function (response) {
			$scope.addingEventType = false;
			if (response.data.success == true) {
				showToast(NTFTITLE, response.data.message, 'success');
				getStatus();
				$scope.event_type.name='';
				
				$scope.neweventtype = false;
			} else {
				globals.mdToast('error', response.data.message);
			}
			window.location.href = BASE_URL + 'staff';
		},
		function (response) {
			$scope.addingEventType = false;
		}
		);
	}

	$scope.EditStatus = function (id, name,color, event) {
		$scope.neweventtype = true;
		$scope.event_type = {
			name : name,
			color : color,
			id:id
		}
	};
		
	$scope.DeleteStatus = function (index) {
		var name = $scope.status[index];
		globals.deleteDialog($scope.lang.attention, $scope.lang.delete_meesage+' '+$scope.lang.status, name.id, $scope.lang.doIt, $scope.lang.cancel, 'staff/remove_status/' + name.id, function(response) {
			if (response.success == true) {
				globals.mdToast('success', response.message);
				$http.get(BASE_URL + 'staff/get_status').then(function (AllStatus) {
					$scope.status = AllStatus.data;
				});
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};

	////End Status Add Code By Namrta///
	globals.get_countries();
	$http.get(BASE_URL + 'api/timezones').then(function (Timezones) {
		$scope.timezones = Timezones.data;
	});
	$scope.toggleFilter = buildToggler('ContentFilter');
	$scope.Create = buildToggler('Create');

	$scope.ViewStaff = function (staff_id) {
		window.location.href = BASE_URL + 'staff/staffmember/' + staff_id;
	};

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();

		};
	}

	$scope.close = function () {
		$mdSidenav('ContentFilter').close();
		$mdSidenav('Create').close();
		$mdSidenav('ManageStatus').close();///////Close Status SidePanel/////////////
		$scope.neweventtype = false;
		$mdDialog.hide();
	};
	$http.get(BASE_URL + 'api/departments').then(function (Departments) {
		$scope.departments = Departments.data;

		

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

		$scope.NewDepartment = function (event) {
			globals.createDialog($scope.lang.new+' '+$scope.lang.department, $scope.lang.department_title+' '+$scope.lang.department+' '+$scope.lang.name, $scope.lang.department+' '+$scope.lang.name,  event, $scope.lang.add, $scope.lang.cancel, 'staff/add_department', function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/departments').then(function (Departments) {
						$scope.departments = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
        
		$scope.EditDepartment = function (index) {
			var department = $scope.departments[index];
			globals.editDialog($scope.lang.update+' '+$scope.lang.department, $scope.lang.department_title+' '+$scope.lang.department+' '+$scope.lang.name, $scope.lang.status+' '+$scope.lang.name, department.name, '', $scope.lang.save, $scope.lang.cancel, 'staff/update_department/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/departments').then(function (Departments) {
						$scope.departments = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};

		$scope.DeleteDepartment = function (index) { 
			var department = $scope.departments[index];
			globals.deleteDialog($scope.lang.delete+' '+$scope.lang.department, $scope.lang.delete_meesage+' '+$scope.lang.department+'?', department.id, $scope.lang.delete, $scope.lang.cancel, 'staff/remove_department/'+department.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/departments').then(function (Departments) {
						$scope.departments = Departments.data;
					});
				} else {
					globals.mdToast('error', response.message );
				}
			});
		};
	});

	/////Start Staus Add////////
	$http.get(BASE_URL + 'staff/get_status').then(function (AllStatus) {
			$scope.statuss = AllStatus.data;
	});
	/* $scope.statuss = [
	    { id: 1, name: 'Active' },
	    { id: 2, name: 'In-Active' },
	    { id: 3, name: 'Cancelled' },
	    { id: 4, name: 'Terminated'},
	    { id: 5, name: 'Onvacation'},
	    { id: 6, name: 'Payroll'},
	    { id: 7, name: 'Rejected'}
	  ]; */

	  $scope.grade = [
	    { id: 5, name: 'A Grade' },
	    { id: 4, name: 'B Grade' },
	    { id: 3, name: 'C Grade' },
	    { id: 2, name: 'D Grade'},
	    { id: 1, name: 'E Grade'}
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
	$http.get(BASE_URL + 'api/countries/').then(function (Country) {
		$scope.countries = Country.data;
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
				console.log(status_value);
				if(status_value == 1 ) {
					
					$('.pinned'+id+'').removeClass('ng-hide');
					$('.pinned'+id+'').show();
					$('.pin'+id+'').hide();
				}else{
					$('.pinned'+id+'').hide();
					$('.pin'+id+'').show();
					$('.pin'+id+'').removeClass('ng-hide');
				}
				$scope.open_pinned();
				}
				if(type ==3){
					$scope.open_payrol();
				}
		});

	}
	
	$scope.showList = true;
	$scope.open_students = function (type) {
		$scope.setBold = type;
		$scope.staff_list = {
		order: '',
		limit: 20,
		page: 1
	};

	$scope.saving = false;
	$http.get(BASE_URL + 'staff/get_staff/' + type).then(function (Staff) {
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
		    var date_of_birth=$("#date_of_birth").datepicker("getDate");
			var joining_date=$("#joining_date").datepicker("getDate");
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
				timezone: $scope.staff_timezone,
				custom_fields: $scope.tempArr,
				joining_date:moment(joining_date).format("YYYY-MM-DD"),
				date_of_birth:moment(date_of_birth).format("YYYY-MM-DD"),
				profession: $scope.staff.profession,
				nominee: $scope.staff.nominee,
				nationality: $scope.staff.country_id,
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
		
	});
	}
	$scope.open_students(0);
}

function Staff_Controller($scope, $http, $mdSidenav, $mdDialog, $filter,$timeout, fileUpload) {
	"use strict";
	$scope.Update = buildToggler('Update');
	$scope.filterValue = function($event){
        if(isNaN(String.fromCharCode($event.keyCode))){
            $event.preventDefault();
        }
	};
	$scope.edit_appraisal=function(appraisal_id){
		$http.get(BASE_URL + 'staff/GetAppraisal/' + appraisal_id).then(function (appraisaldata) {
		$scope.appraisaldata = appraisaldata.data;
		$scope.appraisal_id=appraisaldata.data[0]['id'];
		$scope.increment_date=appraisaldata.data[0]['increment_date'];
		$scope.type_of_amount=appraisaldata.data[0]['type_of_amount'];
		$scope.increment_amount=appraisaldata.data[0]['increment_amount'];
		$scope.increment_type=appraisaldata.data[0]['increment_type'];
		$scope.increment_reason=appraisaldata.data[0]['increment_reason'];
		$scope.remarks=appraisaldata.data[0]['remarks'];
			console.log($scope.appraisaldata);
			$('#appraisal_modal').modal('show');
			$timeout(function(){
					console.log("sadsd");
				var date_input=$('.newdatepicker2'); //our date input has the name "date"
				var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
				date_input.datepicker({format:'dd-mm-yy',
				container: container,
				todayHighlight: true,
				autoclose: true,changeYear: true,changeMonth: true,zIndex: 3000});
			},1000);
		});
	};
	$scope.edit_warning=function(warning_id){
		$http.get(BASE_URL + 'staff/GetWarning/' + warning_id).then(function (warningdata) {
		$scope.warningdata = warningdata.data;
		$scope.warning_id=warningdata.data[0]['id'];
		$scope.warning_date=warningdata.data[0]['warning_date'];
		$scope.date_of_incident=warningdata.data[0]['date_of_incident'];
		$scope.warning_type=warningdata.data[0]['warning_type'];
		$scope.type_of_violation=warningdata.data[0]['type_of_violation'];
		$scope.action=warningdata.data[0]['action'];
		$scope.employee_signature=warningdata.data[0]['employee_signature'];
		$('#warnings_modal').modal('show');
			$timeout(function(){
				var date_input=$('.newdatepicker1'); //our date input has the name "date"
				var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
				date_input.datepicker({format:'dd-mm-yy',
				container: container,
				todayHighlight: true,
				autoclose: true,changeYear: true,changeMonth: true,zIndex: 3000});
			},1000);
		});
	};
	$scope.edit_tools=function(tools_id){
		
			
		$http.get(BASE_URL + 'staff/GetTools/' + tools_id).then(function (toolsdata) {
		$scope.toolsdata = toolsdata.data;
		$scope.tools_id=toolsdata.data[0]['id'];
		$scope.date=toolsdata.data[0]['date'];
		$scope.item_discription=toolsdata.data[0]['item_discription'];
		$scope.quantity=toolsdata.data[0]['quantity'];
		$scope.approved_by=toolsdata.data[0]['approved_by'];
		$scope.status=toolsdata.data[0]['status'];
		$scope.remarks=toolsdata.data[0]['remarks'];
			$('#tools_modal').modal('show'); 
			
			 
		});
	};
	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}
globals.get_countries();


var hash = location.hash.replace("#","");

if(hash!=""){
	var lastChar = hash.substr(hash.length - 1); 
	var prevval=lastChar-1;
	$scope.selectedIndex = prevval;
}


	$scope.sal_calculate = function () {
			/*$scope.total_salary  = (parseInt($scope.basic_salary) +  parseInt($scope.allowance) ) +  (parseInt($scope.accom_amound) + parseInt($scope.vehicle_amound) ) ;
			alert($scope.total_salary);*/
			if(parseInt($scope.basic_salary) && parseInt($scope.allowance )){
				$scope.total_salary = parseInt($scope.basic_salary) +  parseInt($scope.allowance) ;
			}
			else if(parseInt($scope.basic_salary)){
				$scope.total_salary = parseInt($scope.basic_salary);
			}
	};


	$scope.close = function () {
		$mdSidenav('Update').close();
		$mdDialog.hide();
	};

	$scope.staffLoader = false;

	$scope.ChangeAvatar = function (ev) {
		$mdDialog.show({
			templateUrl: 'change-avatar-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.GoogleCalendar = function (ev) {
		$mdDialog.show({
			templateUrl: 'google-calendar-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.changeStaff = function (data, type) {
		if (type == 'admin') {
			if (data) {
				$scope.staff.staffmember = false;
			} else {
				$scope.staff.staffmember = true;
			}
		}
		if (type == 'staff') {
			if (data) {
				$scope.staff.admin = false;
			} else {
				$scope.staff.admin = true;
			}
		}
	};

	$scope.ChangePasswordAdmin = function (ev) {
		$mdDialog.show({
			templateUrl: 'change-password-admin.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.UpdatePasswordAdmin = function() {
		$scope.saving = true;
		if (!$scope.apassword) {
			var dataObj = $.param({
				new_password: '',
				c_new_password: ''
			});
		} else {
			var dataObj = $.param({
				new_password: $scope.apassword.newpassword,
				c_new_password: $scope.apassword.c_newpassword
			});
		}
		$http.post(BASE_URL + 'staff/changestaffpassword_admin/'+STAFFID, dataObj, config)
			.then(
				function (response) {
					$scope.saving = false;
					if (response.data.success == true) {
						globals.mdToast('success', response.data.message);
						$mdDialog.hide();
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					$scope.saving = false;
					console.log(response);
				}
			);
	};

	$scope.ChangePassword = function (ev) {
		$mdDialog.show({
			templateUrl: 'change-password.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.UpdatePassword = function() {
		$scope.saving = true;
		if (!$scope.password) {
			var dataObj = $.param({
				password: '',
				new_password: '',
				c_new_password: ''
			});
		} else {
			var dataObj = $.param({
				password: $scope.password.old,
				new_password: $scope.password.newpassword,
				c_new_password: $scope.password.c_newpassword
			});
		}
		$http.post(BASE_URL + 'staff/changestaffpassword/', dataObj, config)
			.then(
				function (response) {
					$scope.saving = false;
					if (response.data.success == true) {
						showToast(NTFTITLE, response.data.message, ' success');
						$mdDialog.hide();
					} else {
						showToast(NTFTITLE, response.data.message, ' danger');
					}
				},
				function (response) {
					$scope.saving = false;
					console.log(response);
				}
			);
	};

	$scope.uploading = false; 
	$scope.updateProfilePic = function() {
		$scope.uploading = true;
        var file = $scope.profile_photo;
        var uploadUrl = BASE_URL+'staff/change_avatar/'+STAFFID;
        fileUpload.uploadFileToUrl(file, uploadUrl, function(response) {
        	if (response.success == true) {
        		$mdDialog.hide();
        		showToast(NTFTITLE, response.message, ' success');
        		$http.get(BASE_URL + 'staff/staff_detail/' + STAFFID).then(function (StaffDetail) {
        			$scope.staff = StaffDetail.data;
        		});
        	} else {
        		showToast(NTFTITLE, response.message, ' danger');
        	}
        	$scope.uploading = false;
        });
    };

	$scope.UpdateGoogleCalendar = function () {
		if ($scope.staff.google_calendar_enable === true) {
			$scope.Enable = 1;
		} else {
			$scope.Enable = 0;
		}
		var dataObj = $.param({
			google_calendar_id: $scope.staff.google_calendar_id,
			google_calendar_api_key: $scope.staff.google_calendar_api_key,
			google_calendar_enable: $scope.Enable,
		});
		$http.post(BASE_URL + 'staff/update_google_calendar/' + STAFFID, dataObj, config)
			.then(
				function (response) {
					console.log(response);
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: response.data.message,
						class_name: response.data.color,
					});
					$mdDialog.hide();

				},
				function (response) {
					console.log(response);
				}
			);
	};

	globals.get_departments();
	$http.get(BASE_URL + 'api/languages').then(function (Languages) {
		$scope.languages = Languages.data;
	});

	$http.get(BASE_URL + 'api/timezones').then(function (Timezones) {
		$scope.timezones = Timezones.data;
	});

	$http.get(BASE_URL + 'settings/get_roles').then(function (Roles) {
		$scope.roles = Roles.data;
	});
	/////Start Staus Add////////
	$http.get(BASE_URL + 'staff/get_status').then(function (AllStatus) {
			$scope.statuss = AllStatus.data;
	});
		/* $scope.statuss = [
	    { id: 1, name: 'Active' },
	    { id: 2, name: 'In-Active' },
	    { id: 3, name: 'Cancelled' },
	    { id: 4, name: 'Terminated'},
	    { id: 5, name: 'Vacation'},
	    { id: 6, name: 'Payroll'},
	    { id: 7, name: 'Rejected'}
	  ]; */

	  $scope.grade = [
	    { id: 5, name: 'A Grade' },
	    { id: 4, name: 'B Grade' },
	    { id: 3, name: 'C Grade' },
	    { id: 2, name: 'D Grade'},
	    { id: 1, name: 'E Grade'},
	  ];

	   $scope.gender = [
	    { id: 1,  name: 'Male' },
	    { id: 2,  name: 'Female' },
	  ];

	$http.get(BASE_URL + 'api/invoices').then(function (Invoices) {
		$scope.all_invoices = Invoices.data;
		$scope.invoices = $filter('filter')($scope.all_invoices, {
			staff_id: STAFFID,
		});
	});

	$scope.GoInvoice = function (index) {
		var invoice = $scope.invoices[index];
		window.location.href = BASE_URL + 'invoices/invoice/' + invoice.id;
	};

	$http.get(BASE_URL + 'api/proposals').then(function (Proposals) {
		$scope.all_proposals = Proposals.data;
		$scope.proposals = $filter('filter')($scope.all_proposals, {
			assigned: STAFFID,
		});
	});

	$scope.GoProposal = function (index) {
		var proposal = $scope.proposals[index];
		window.location.href = BASE_URL + 'proposals/proposal/' + proposal.id;
	};

	$http.get(BASE_URL + 'api/tickets').then(function (Tickets) {
		$scope.all_tickets = Tickets.data;
		$scope.tickets = $filter('filter')($scope.all_tickets, {
			staff_id: STAFFID,
		});
	});

	$scope.GoTicket = function (index) {
		var ticket = $scope.tickets[index];
		window.location.href = BASE_URL + 'tickets/ticket/' + ticket.id;
	};

	$http.get(BASE_URL + 'api/custom_fields_data_by_type/' + 'staff/' + STAFFID).then(function (custom_fields) {
		$scope.custom_fields = custom_fields.data;
	});

	$http.get(BASE_URL + 'staff/staff_detail/' + STAFFID).then(function (StaffDetail) {
		$scope.staff = StaffDetail.data; 
		$scope.View_Work = true;
		$scope.isActive = $scope.staff.staff_isActive;
		if ($scope.staff.timezone) {
			$scope.staff_timezone = $scope.staff.timezone;
		}
		
		$scope.savingWork = false;
		$scope.UpdateWorkPlan = function () {
			$scope.savingWork = true;
			var dataObj = $.param({
				work_plan: JSON.stringify($scope.staff.work_plan)
			});
			var posturl = BASE_URL + 'staff/update_workplan/' + STAFFID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.savingWork = false;
						if(response.data.success == true) {
							globals.mdToast('success', response.data.message);
						} else {
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.saving = false;
		$scope.UpdateStaff = function () {
			$scope.saving = true;
			$scope.type = {};
			if ($scope.staff.type == 'admin') {
				$scope.type.admin = true;
				$scope.type.staffmember = false;
				$scope.type.other = false;
			}
			if ($scope.staff.type == 'staffmember') {
				$scope.type.admin = false;
				$scope.type.staffmember = true;
				$scope.type.other = false;
			}
			if ($scope.staff.type == 'other') {
				$scope.type.admin = false;
				$scope.type.staffmember = false;
				$scope.type.other = true;
			}
			$scope.tempArr = [];
			angular.forEach($scope.custom_fields, function (value) {
				if (value.type === 'input') {
					$scope.field_data = value.data;
				}
				if (value.type === 'textarea') {
					$scope.field_data = value.data;
				}
				
				if (value.type === 'date') {
					$scope.field_data = moment(value.data).format("DD-MM-YYYY");
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
			//alert($('#date_of_birth').val());
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
				joining_date: $('#joining_date').val(), 
				date_of_birth: $('#date_of_birth').val(),
				
				profession: $scope.staff.profession,
				nominee: $scope.staff.nominee,
				nationality: $scope.staff.nationality,
			});

//alert(dataObj);
			var posturl = BASE_URL + 'staff/update/' + STAFFID;
			$http.post(posturl, dataObj, globals.config )
				.then(
					function (response) {
						$scope.saving = false;
						if (response.data.success == true) {
							globals.mdToast('success', response.data.message);
							$mdSidenav('Update').close();
							location.reload();
						} else {
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						$scope.saving = false;
						console.log(response);
					}
				);
		};

		$scope.Delete = function (index) {
			globals.deleteDialog(lang.attention, lang.delete_staff, STAFFID, lang.doIt, lang.cancel, 'staff/remove/' + STAFFID, function(response) {
				if (response.success == true) {
					window.location.href = BASE_URL + 'staff';
				} else {
					globals.mdToast('error',response.message);
				}
			});
		};

		var canvas = document.getElementById("staff_sales_chart");
		var multiply = {
			beforeDatasetsDraw: function (chart, options, el) {
				chart.ctx.globalCompositeOperation = 'multiply';
			},
			afterDatasetsDraw: function (chart, options) {
				chart.ctx.globalCompositeOperation = 'source-over';
			},
		};
		var gradientThisWeek = canvas.getContext('2d').createLinearGradient(0, 0, 0, 150);
		gradientThisWeek.addColorStop(0, '#ffbc00');
		gradientThisWeek.addColorStop(1, '#fff');
		var gradientPrevWeek = canvas.getContext('2d').createLinearGradient(0, 0, 0, 150);
		gradientPrevWeek.addColorStop(0, '#616f8c');
		gradientPrevWeek.addColorStop(1, '#fff');
		var configs = {
			type: 'bar',
			data: $scope.staff.properties.chart_data,
			options: {
				elements: {
					point: {
						radius: 0,
						hitRadius: 5,
						hoverRadius: 5
					}
				},
				legend: {
					display: false,
				},
				scales: {
					xAxes: [{
						display: false,
					}],
					yAxes: [{
						display: false,
						ticks: {
							beginAtZero: true,
						},
					}]
				},
				legend: {
					display: true
				}
			},
			plugins: [multiply],
		};
		window.chart = new Chart(canvas, configs);
	});
}

function Recruitment_Controller($scope, $http, $mdSidenav, $filter,$mdDialog,fileUpload,$timeout) {
	"use strict";
	$scope.Update = buildToggler('Update');
	$scope.Create = buildToggler('Create');
	$scope.ReminderForm = buildToggler('ReminderForm');
	
	$scope.statuss = [
	    { id: 1, name: 'Awaiting Review' },
	    { id: 2, name: 'Reviewed' },
	    { id: 3, name: 'Screened' },
	    { id: 4, name: 'Interviewed'},
	    { id: 5, name: 'Hired'},
	    { id: 6, name: 'Rejected'}
	  ];
	$scope.statusnew=statusold; 
	$scope.recruitment_status=recruitment_status; 
	$scope.documentFiles = false;
	$scope.files1 = files1;
	$scope.filetype = filetype;
	$scope.CandidateID = CandidateID;
	$scope.path =  BASE_URL+ 'uploads/files/candidates/'+$scope.CandidateID+'/'+$scope.files1;
	
	$http.get(BASE_URL + 'api/staff').then(function (Staff) {
		//alert("a");
		$scope.staff = Staff.data;
	});
	$http.get(BASE_URL + 'api/doclogs/'+CandidateID+'/" "/Recruitment').then(function (Logs) {
		$scope.logs = Logs.data;
	});
	$scope.loadMoreLogs = function() {
		$scope.getLogs = true;
		$http.get(BASE_URL + 'api/doclogs/'+CandidateID+'/loadMore/Recruitment').then(function (Logs) {
			$scope.logs = Logs.data;
			$scope.getLogs = false;
		});
	}
	$scope.gender = [
	    { id: 1,  name: 'Male' },
	    { id: 2,  name: 'Female' },
	  ];
	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}
	$scope.close = function () {
		$mdSidenav('Create').close();
	};
	$scope.recruitment_list = {
		order: '',
		limit: 10,
		page: 1
	};
	$scope.open_contact_type = function () {
		$http.get(BASE_URL + 'recruitment/recruitmenttype').then(function (Payroll) {
			$scope.recruitmenttype = Payroll.data;
		});
	}
    $scope.open_contact_type();
	$scope.taskLoader = true;
	
	$scope.open_recruitment = function (type) {
		$scope.setBold = type;
		$http.get(BASE_URL + 'recruitment/get_Recruitment/'+ type).then(function (Recruitment) {
			$scope.recruitments = Recruitment.data;
			$scope.limitOptions = [10, 15, 20];
			if ($scope.recruitments.length > 20) {
				$scope.limitOptions = [10, 15, 20, $scope.recruitments.length];
			}
			$scope.taskLoader = false;
		});
	}
	$scope.open_recruitment(0);
	$scope.MarkAs = function (id, name) {
		var dataObj = $.param({
			status_id: id,
			candidate_id: CandidateID,
			name: name,
		});
		var posturl = BASE_URL + 'recruitment/update_status/';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if(response.data.success == true){
						globals.mdToast('success', response.data.message);
						window.location.reload();
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};
	$http.get(BASE_URL + 'api/reminders_by_type/recruitment/' + CandidateID).then(function (Reminders) {
		$scope.in_reminders = Reminders.data;
		$scope.AddReminder = function () {
			var dataObj = $.param({
				description: $scope.reminder_description,
				date: moment($scope.reminder_date).format("YYYY-MM-DD HH:mm:ss"),
				staff: $scope.reminder_staff,
				relation_type: 'recruitment',
				relation: CandidateID,
			});
			var posturl = BASE_URL + 'trivia/addreminder';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$http.get(BASE_URL + 'api/reminders_by_type/recruitment/' + CandidateID).then(function (Reminders) {
							$scope.in_reminders = Reminders.data;
						});
						$mdSidenav('ReminderForm').close();
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.DeleteReminder = function (index) {
			var reminder = $scope.in_reminders[index];
			var dataObj = $.param({
				reminder: reminder.id
			});
			var posturl = BASE_URL + 'trivia/removereminder';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.in_reminders.splice($scope.in_reminders.indexOf(reminder), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});

	$http.get(BASE_URL + 'api/notes/recruitment/' + CandidateID).then(function (Notes) {
		
		$scope.notes = Notes.data;
		$scope.AddNote = function () {
			
			var dataObj = $.param({
				description: $scope.note,
				relation_type: 'recruitment',
				relation: CandidateID,
			});
			var posturl = BASE_URL + 'trivia/addnote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if (response.data.success == true) {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color success'
							});
							$('.note-description').val('');
							$scope.note = '';
							$http.get(BASE_URL + 'api/notes/recruitment/' + CandidateID).then(function (Notes) {
								$scope.notes = Notes.data;
							});
						} else {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color danger'
							});
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note.id
			});
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
					},
					function (response) {
					}
				);
		};
	});
	$scope.Convert = function (index) {
		globals.deleteDialog(lang.convert_title, lang.convert_text, CandidateID, lang.convert, lang.cancel, 'recruitment/convert/' + CandidateID, function(response) {
			if (response.success == true) {
				window.location.href = BASE_URL + 'recruitment/GetRecruitment/' + CandidateID;
				$('.lostBtn').css('display','none');
			} else {							
				globals.mdToast('error',response.message);
			}
		});
	};
		$scope.DeleteDocFile = function(id,files1) {
			var confirm = $mdDialog.confirm()
				.title($scope.lang.delete_file_title)
				.textContent($scope.lang.delete_file_message)
				.ariaLabel($scope.lang.delete_file_title)
				.targetEvent(CandidateID)
				.ok($scope.lang.delete)
				.cancel($scope.lang.cancel);

			$mdDialog.show(confirm).then(function () {
				var config = {
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
					}
				};
				var dataObj = $.param({
					id: id,
					files1: files1
				});
				var posturl = BASE_URL + 'recruitment/update_status/';
				$http.post(posturl, dataObj, config)
				//$http.post(BASE_URL + 'recruitment/delete_file/' + id+'/'+files1, config)
					.then(
						function (response) {
							if(response.data.success == true) {
								showToast(NTFTITLE, response.data.message, ' success');
								$http.get(BASE_URL + 'recruitment/GetRecruitment/' + CandidateID).then(function (Files) {
									$scope.files1 = '';
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
CiuisCRM.controller('Staffs_Controller', Staffs_Controller);
CiuisCRM.controller('Staff_Controller', Staff_Controller);
CiuisCRM.controller('Recruitment_Controller', Recruitment_Controller);
