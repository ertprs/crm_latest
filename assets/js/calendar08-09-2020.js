
function Calendar_Controller($scope, $http, $mdDialog, $filter, $mdSidenav) {
  "use strict";
	
	$scope.appointment_color = appointment_color;
	$scope.project_color = project_color;
	$scope.task_color = task_color;
	$scope.close = function () {
		$mdDialog.hide();
		$mdSidenav('ManageEventTypes').close();
	};

	$scope.ManageEventTypes = function(ev) {
		getEventTypes();
		$mdSidenav('EventForm').close();
		$mdSidenav('ManageEventTypes').toggle();
	}

	$scope.closeEventTypes = function(ev) {
		$mdSidenav('ManageEventTypes').close();
		$mdSidenav('EventForm').toggle();
	}

    $scope.HolidayForm = function(ev) {
        
		//getEventTypes();
		$scope.event_title = '';
		$scope.eventType= '';
		$scope.event_start= '';
		$scope.event_end='';
		$scope.normal_holidays= '';
		$scope.event_detail= '';
		$scope.event_id=0;
		$mdSidenav('HolidayForm').toggle();
	}
	///Set Holiday Details//////
	$scope.EditHoliday = function (id, event_title,eventType,event_start,event_end,normal_holidays,event_detail, event) {
		$scope.event_title = event_title;
		$scope.eventType= eventType;
		$scope.event_start= event_start;
		$scope.event_end= event_end;
		$scope.normal_holidays= normal_holidays;
		$scope.event_detail= event_detail;
		$scope.event_id=id;
		
		$mdSidenav('HolidayForm').toggle();
	};
	$scope.EventForm = function(ev) {
		getEventTypes();
		$mdSidenav('EventForm').toggle();
	}

    
 
	function getEventTypes() {
		$http.get(BASE_URL + 'api/eventtypes').then(function (Data) {
			$scope.eventtypes = Data.data;
		});
	}

	$scope.CloseEventForm = function(ev) {
		$mdSidenav('EventForm').close();
	}

	$scope.neweventtype = false;

	$scope.addingEvent = false;
	$scope.AddEvent = function () {
		$scope.addingEvent = true;
		var start = '', end = '';
		if ($scope.event_start) {
			start = moment($scope.event_start).format("YYYY-MM-DD HH:mm:ss")
		}
		if ($scope.event_end) {
			end = moment($scope.event_end).format("YYYY-MM-DD HH:mm:ss")
		}
		var dataObj = $.param({
			title: $scope.event_title,
			detail: $scope.event_detail,
			eventstart: start,
			eventType: $scope.eventType?$scope.eventType.id:'',
			eventend: end,
			staff_id: $scope.event_staff,
			notification: +($scope.event_reminder?$scope.event_reminder:false),
			email_to_all: +($scope.email_to_all?$scope.email_to_all:false),
			notification_type: $scope.event_ntf_type,
			notification_duration: $scope.event_ntf_duration,
			notification_time: $scope.event_ntf_time,
		});
		var posturl = BASE_URL + 'calendar/addevent';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					$scope.addingEvent = false;
					if (response.data.success == true) {
						showToast(NTFTITLE, response.data.message, ' success');
						$mdSidenav('EventForm').close();
						window.location.href = window.location.href;
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					$scope.addingEvent = false;
				}
			);
	};

	$scope.addingHoliday = false;
	$scope.AddHoliday = function () {
		$scope.addingHoliday = true;
		var start = '', end = '';
		if( $scope.eventType==1){
			if ($scope.event_start) {
			start = moment($scope.event_start).format("YYYY-MM-DD")
			}
			if ($scope.event_end) {
				end = moment($scope.event_end).format("YYYY-MM-DD")
			}
			$scope.normal_holidays="";
		}
		if($scope.eventType==2){
			var start = '', end = '';
		}
		var dataObj = $.param({
			title: $scope.event_title,
			detail: $scope.event_detail,
			eventstart: start,
			eventType: $scope.eventType,
			eventend: end,
			normal_holidays: $scope.normal_holidays,
			//staff_id: $scope.event_staff,
			notification: +($scope.event_reminder?$scope.event_reminder:false),
			email_to_all: +($scope.email_to_all?$scope.email_to_all:false),
			notification_type: $scope.event_ntf_type,
			notification_duration: $scope.event_ntf_duration,
			notification_time: $scope.event_ntf_time,
			event_id: $scope.event_id,
		});
		var posturl = BASE_URL + 'calendar/addholiday';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response.data.success);
					$scope.addingHoliday = false;
					if (response.data.success == true) {
						showToast(NTFTITLE, response.data.message, ' success');
						$mdSidenav('EventForm').close();
						window.location.href = window.location.href;
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					$scope.addingHoliday = false;
				}
			);
	};
	$scope.DeleteHoliday = function (index) {
		var name = $scope.all_holidays[index];
		globals.deleteDialog($scope.lang.attention, $scope.lang.delete_meesage+' '+$scope.lang.holiday, name.id, $scope.lang.doIt, $scope.lang.cancel, 'calendar/remove_holiday/' + name.id, function(response) {
			if (response.success == true) {
				globals.mdToast('success', response.message);
				$http.get(BASE_URL + 'api/holidays').then(function (Events) {
					$scope.all_holidays = Events.data;
				});
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};
	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.addingEventType = false;
	$scope.AddEventType = function(action) {
		$scope.addingEventType = true;
		if (!$scope.event_type) {
			var dataObj = $.param({
				name: '',
				color: '',
				public: '',
			});
		} else  {
			var dataObj = $.param({
				name: $scope.event_type.name,
				color: $scope.event_type.color,
				public: +($scope.event_type.public?$scope.event_type.public:false),
			});
		}
		var posturl = BASE_URL + 'api/add_eventtype';
		$http.post(posturl, dataObj, config)
			.then(
			function (response) {
				$scope.addingEventType = false;
				if (response.data.success == true) {
					showToast(NTFTITLE, response.data.message, 'success');
					getEventTypes();
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

	$scope.DeleteEventType = function (id) {
		var confirm = $mdDialog.confirm()
		.title($scope.lang.delete+' '+$scope.lang.event+' '+$scope.lang.type)
		.textContent($scope.lang.event_type_delete_meesage)
		.ariaLabel('Delete Converted Leads')
		.targetEvent(id)
		.ok($scope.lang.delete)
		.cancel($scope.lang.cancel);
		$mdDialog.show(confirm).then(function () {
			$http.post(BASE_URL + 'api/remove_eventtype/'+id, config)
			.then(
				function (response) {
					getEventTypes();
					globals.mdToast('error', response.data.message);
				},
				function (response) {
					console.log(response);
				}
				);
		}, function () {
		});
	};

	//$scope.EventForm = buildToggler('EventForm');

	function openEventModal() {
		$mdSidenav('EventForm').toggle();
	}

	$scope.changeEventType = function(ev) {
		if($scope.event_ntf_type == 'email') {
			if ($scope.eventType) {
				if ($scope.eventType.public == '1') {
					$scope.send_to_all = true;
				} else {
					$scope.send_to_all=false;
				}
			} else {
				$scope.send_to_all=false;
			}
		} else {
			$scope.send_to_all=false;
		}
	}

	$scope.changeEventTypes = function(ev) {
		if($scope.event_ntf_type == 'email') {
			if ($scope.event_reminder) {
				if ($scope.eventType) {
					if ($scope.eventType.public == '1') {
						$scope.send_to_all = true;
					} else {
						$scope.send_to_all=false;
					}
				} else {
					$scope.send_to_all=false;
				}
			} else {
			    
				$scope.send_to_all=false;
			}
		} else {
			$scope.send_to_all=false;
		}
	}

	$scope.get_staff();
	$http.get(BASE_URL + 'api/events').then(function (Events) {
		$scope.all_events = Events.data;
		$scope.today_events = $filter('filter')($scope.all_events, {
			date: $scope.curDate,
		});
	});

	$http.get(BASE_URL + 'api/holidays').then(function (Events) {
		$scope.all_holidays = Events.data;
		/* $scope.today_holidays = $filter('filter')($scope.all_holidays, {
			date: $scope.curDate,
		}); */
	});


	$http.get(BASE_URL + 'api/appointments').then(function (appointments) {
		$scope.all_appointments = appointments.data;
		$scope.today_appointments = $filter('filter')($scope.all_appointments, {
			date: $scope.curDate,
			status: 1,
		});
	});

	$http.get(BASE_URL + 'api/appointments').then(function (appointments) {
		$scope.all_appointments = appointments.data;
		$scope.requested_appointments = $filter('filter')($scope.all_appointments, {
			status: 0,
		});
	});

	$http.get(BASE_URL + 'api/appointments').then(function (appointments) {
		$scope.appointments = appointments.data;
	});

	$scope.ShowAppointment = function (index) {
    var appointment = $scope.appointments[index];
    console.log(index);
		$mdDialog.show({
			contentElement: '#Appointment-' + index,
			parent: angular.element(document.body),
			targetEvent: index,
			clickOutsideToClose: true
		});
	};

	$scope.ConfirmAppointment = function (id) {
		var posturl = BASE_URL + 'appointments/confirm_appointment/' + id;
		$http.post(posturl)
			.then(
				function (response) {
					console.log(response);
					$mdDialog.hide();
				},
				function (response) {
					console.log(response);
				}
			);
	};
	$scope.DeclineAppointment = function (id) {
		var posturl = BASE_URL + 'appointments/decline_appointment/' + id;
		$http.post(posturl)
			.then(
				function (response) {
					console.log(response);
					$mdDialog.hide();
				},
				function (response) {
					console.log(response);
				}
			);
	};
	$scope.MarkAsDoneAppointment = function (id) {
		var posturl = BASE_URL + 'appointments/mark_as_done_appointment/' + id;
		$http.post(posturl)
			.then(
				function (response) {
					console.log(response);
					$mdDialog.hide();
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.saving = false;
	$scope.save_colors = function () {
		$scope.saving = true;
		var dataObj = $.param({
			appointment_color: $scope.appointment_color,
			project_color: $scope.project_color,
			task_color: $scope.task_color,
		});
		var posturl = BASE_URL + 'calendar/save_colors/';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) { 
					if (response.data.success == true) {
						$scope.saving = false;
						globals.mdToast('success', response.data.message);
					} else {
						$scope.saving = false;
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					globals.mdToast('error', response.data.message);
					$scope.saving = false;
				}
			);
	};
	////Code BY Namrta////////
	$scope.weekdays = [
	    { id: 1, name: 'Sunday' },
	    { id: 2, name: 'Monday' },
	    { id: 3, name: 'Tuesday' },
	    { id: 4, name: 'Wednesday'},
	    { id: 5, name: 'Thursday'},
	    { id: 6, name: 'Friday'},
	    { id: 7, name: 'Saturday'}
	  ];
}

CiuisCRM.controller('Calendar_Controller', Calendar_Controller);
