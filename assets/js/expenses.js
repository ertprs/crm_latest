function Expenses_Controller($scope, $http, $mdSidenav, $mdDialog, $q, $timeout, $filter,$log) {
	"use strict";

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'expense').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});
	$http.get(BASE_URL + 'glclasses/get_inventories').then(function (chartaccounts) {
		$scope.chartaccounts = chartaccounts.data;
	});
	$scope.get_staff();
	$http.get(BASE_URL + 'api/get_projects').then(function (Projects) {
		$scope.projects = Projects.data;
	});
	

	/* $scope.GetProduct = (function (search) {
		var deferred = $q.defer();
		$timeout(function () {
			deferred.resolve($scope.products);
		}, Math.random() * 500, false);
		return deferred.promise;
	}); */ 
	
	$scope.newexpense = {
		items: [{
			name: new_item,
			product_id: 0,
			code: '',
			description: '',
			quantity: 1,
			unit: item_unit,
			price: 0,
			account: 0,
			tax: 0,
			project_id:0,
			discount: 0,
		}]
	};

	$scope.add = function () {
		$scope.newexpense.items.push({
			name: new_item,
			product_id: 0,
			code: '',
			description: '',
			quantity: 1,
			unit: item_unit,
			price: 0,
			account: 0,
			tax: 0,
			project_id:0,
			discount: 0,
		});
	};

	$scope.remove = function (index) {
		$scope.newexpense.items.splice(index, 1);
	};

	$scope.subtotal = function () {
		var subtotal = 0;
		angular.forEach($scope.newexpense.items, function (item) {
			subtotal += item.quantity * item.price;
		});
		return subtotal.toFixed(2);
	};

	$scope.linediscount = function () {
		var linediscount = 0;
		angular.forEach($scope.newexpense.items, function (item) {
			linediscount += ((item.discount) / 100 * item.quantity * item.price);
		});
		return linediscount.toFixed(2);
	};

	$scope.totaltax = function () {
		var totaltax = 0;
		angular.forEach($scope.newexpense.items, function (item) {
			totaltax += ((item.tax) / 100 * item.quantity * item.price);
		});
		return totaltax.toFixed(2);
	};

	$scope.grandtotal = function () {
		var grandtotal = 0;
		angular.forEach($scope.newexpense.items, function (item) {
			grandtotal += item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price) - ((item.discount) / 100 * item.quantity * item.price);
		});
		return grandtotal.toFixed(2);
	};

	$scope.today = new Date();

	$scope.NewExpense = buildToggler('NewExpense');
	$scope.toggleFilter = buildToggler('ContentFilter');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function () {
		$('.md-select-menu-container.md-active.md-clickable').css('display', 'block');
		$mdSidenav('NewExpense').close();
		$mdSidenav('ContentFilter').close();
		$mdSidenav('CreateCustomer').close();
		$mdDialog.hide();
	};
	$scope.setvalue=function(val){
		if(val==1){
			$scope.newexpense.card='';
		}else if(val==2){
			$scope.newexpense.account='';
		}
	}
	/////Start vendor drop-down///////
	$scope.expensesLoader = true;
	$http.get(BASE_URL + 'material/get_all_materials_new').then(function (materials) {
		$scope.materials = materials.data;
		$scope.expensesLoader = false;
	});
	$scope.Getmaterial = function (searchText) {
		var deferred = $q.defer();
		$timeout(function() {
			var states = $scope.materials.filter(function(state) {
				return (state.name.toUpperCase().indexOf(searchText.toUpperCase()) !== -1);
			});
			deferred.resolve(states);
		}, 1500);
		return deferred.promise;
	};
	$scope.itemcut = {
		name: new_item,
		id: 0,
	};
	
	$scope.simulateQuery = false;
	$scope.isDisabled    = false;
	$http.get(BASE_URL + 'api/vendors').then(function (vendors) {
		$scope.vendors = vendors.data;
	});
	$scope.querySearch =function(query) {
      var results = query ? $scope.vendors.filter(createFilterFor(query)) : $scope.vendors,
          deferred;
      if ($scope.simulateQuery) {
        deferred = $q.defer();
        $timeout(function () { deferred.resolve(results); }, Math.random() * 1000, false);
        return deferred.promise;
      } else {
        return results;
      }
    }
	$scope.searchTextChange=function(text) {
      //$log.info('Text changed to ' + text);
    }

    $scope.selectedItemChange=function(item) {
     // $log.info('Item changed to ' + JSON.stringify(item));
    }
	function createFilterFor(query) {
      var lowercaseQuery = query.toLowerCase();
       return function filterFn(item) {
        return (item.name.indexOf(lowercaseQuery) === 0);
      }; 

    }
	 /////End vendor drop-down///////
	$scope.AddExpense = function () {
		$scope.savingExpense = true;
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

		var expense_recurring;
		if ($scope.expense_recurring == true) {
			expense_recurring = '1';
		} else {
			expense_recurring = '0';
		}

		var EndRecurring;
		if ($scope.EndRecurring) {
			EndRecurring = moment($scope.EndRecurring).format("YYYY-MM-DD 00:00:00");
		} else {
			EndRecurring = 'Invalid date';
		}

		var internal = false;
		if ($scope.newexpense.internal == true) {
			internal = true;
		}

		if (!$scope.newexpense) {
			var dataObj = $.param({
				title: '',
				amount: '',
				date: '',
				category: '',
				account: '',
				card: '',
				description: '',
				customer: '',
				number: '',
				amountType: '',
				custom_fields: '',
			});
		} else {
			var dataObj = $.param({
				title: $scope.newexpense.title,
				amount: $scope.newexpense.amount,
				card: $scope.newexpense.card,
				amountType: $scope.newexpense.amountType,
				date: moment($scope.newexpense.date).format("YYYY-MM-DD"),
				category: $scope.newexpense.category,
				account: $scope.newexpense.account,
				customer: $scope.itemcut.name,
				customer_id: $scope.itemcut.id,
				custom_fields: $scope.tempArr,
				number: $scope.newexpense.number,
				internal: internal,
				sub_total: $scope.subtotal,
				total_discount: $scope.linediscount,
				total_tax: $scope.totaltax,
				total: $scope.grandtotal,
				staff: $scope.newexpense.staff,
				// START Recurring
				recurring: expense_recurring,
				end_recurring: EndRecurring,
				recurring_type: $scope.recurring_type,
				recurring_period: $scope.recurring_period,
				// END Recurring
				items: $scope.newexpense.items,
				totalItems: $scope.newexpense.items.length
			});
		}
		var posturl = BASE_URL + 'expenses/create/';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				var types = response.data.type;
				$scope.savingExpense = false;
				if (response.data.success == true) {
					$scope.preview_image(response.data.id);
					showToast(NTFTITLE, response.data.message, ' success');
					
				} else {
					showToast(NTFTITLE, response.data.message, ' danger');
				}
			},
			function (response) {
				$scope.savingExpense = false;
				console.log(response);
			}
		);
	};
	$scope.document = [];

    //listen for the file selected event
    $scope.$on("documentSelected", function (event, args) {
        $scope.$apply(function () {            
            //add the file object to the scope's files collection
            $scope.document.push(args.file);
        });
    });
	$scope.preview_image=function($id)  {
		$http({
            method: 'POST',
			url: BASE_URL + 'expenses/add_file_new/'+$id,
            headers: { 'Content-Type': undefined },
            transformRequest: function (data) {
                var formData = new FormData();
				for (var i = 0; i < $scope.document.length; i++) {
                    //add each file to the form data and iteratively name them
                    formData.append("file_name" + i,  $scope.document[i]);
                }
                return formData;
            },
            data: {  files: $scope.document }
        }).then(function (response) {
				$mdSidenav('NewExpense').close();
				window.location.href = BASE_URL + 'expenses/receipt/' + response.data.id;	
        })
	}
	var deferred = $q.defer();
	$scope.expense_list = {
		order: '',
		limit: 5,
		page: 1
	};
	$http.get(BASE_URL + 'expenses/get_expenses').then(function (Expenses) {
		$scope.expenses = Expenses.data;
		deferred.resolve();

		$scope.limitOptions = [5, 10, 15, 20];

		if($scope.expenses.length > 20 ) {
			$scope.limitOptions = [5, 10, 15, 20, $scope.expenses.length];
		}
		$scope.expensesLoader = false;

		$scope.search = {
			title: '',
		};
			// Filtered Datas
			$scope.filter = {};
			$scope.getOptionsFor = function (propName) {
				return ($scope.expenses || []).map(function (item) {
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
		});

	/* $http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
		$scope.accounts = Accounts.data;
	}); */
	$scope.accounts = '';
	$scope.expensesCatLoader = true;
	$http.get(BASE_URL + 'api/expensescategories').then(function (Categories) {
		$scope.categories = Categories.data;
		$scope.expensesCatLoader = false;

		$scope.NewCategory = function () { 
			globals.createDialog($scope.lang.newcategory, $scope.lang.type_categoryname, $scope.lang.categoryname, '', $scope.lang.add, $scope.lang.cancel, 'expenses/add_category/',  function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
				} else {
					globals.mdToast('error', response.message);
				}
				$http.get(BASE_URL + 'api/expensescategories').then(function (Categories) {
					$scope.categories = Categories.data;
				});
			});
		};

		$scope.UpdateCategory = function (index) {
			var Category = $scope.categories[index];
			globals.editDialog($scope.lang.update+' '+$scope.lang.category, $scope.lang.type_categoryname, $scope.lang.category+' '+$scope.lang.name, Category.name, Category.id, 'Save', 'Cancel', 'expenses/update_category/' + Category.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/expensescategories').then(function (Categories) {
						$scope.categories = Categories.data;
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		$scope.Remove = function (index) {
			var Category = $scope.categories[index];
			globals.deleteDialog($scope.lang.attention, $scope.lang.delete_category, Category.id, $scope.lang.doIt, $scope.lang.cancel, 'expenses/remove_category/' + Category.id, function(response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$http.get(BASE_URL + 'api/expensescategories').then(function (Categories) {
						$scope.categories = Categories.data;
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};
	});
}

function Expense_Controller($scope, $http, $mdSidenav, $mdDialog, $q, $timeout, fileUpload) {
	"use strict";

	$scope.Update = buildToggler('Update');
	$scope.get_staff();

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function() {
		$mdDialog.hide();
	};

	$http.get(BASE_URL + 'api/custom_fields_data_by_type/' + 'expense/' + EXPENSEID).then(function (custom_fields) {
		$scope.custom_fields = custom_fields.data;
	});
	$http.get(BASE_URL + 'glclasses/get_inventories').then(function (chartaccounts) {
		$scope.chartaccounts = chartaccounts.data;
	});
	/////Start vendor drop-down///////
	$scope.setvalue=function(val){
		if(val==1){
			$scope.newexpense.card='';
		}else if(val==2){
			$scope.newexpense.account='';
		}
	}
	
	$scope.simulateQuery = false;
	$scope.isDisabled    = false;
	$http.get(BASE_URL + 'api/vendors').then(function (vendors) {
		$scope.vendors = vendors.data;
	});
	$scope.querySearch =function(query) {
      var results = query ? $scope.vendors.filter(createFilterFor(query)) : $scope.vendors,
          deferred;
      if ($scope.simulateQuery) {
        deferred = $q.defer();
        $timeout(function () { deferred.resolve(results); }, Math.random() * 1000, false);
        return deferred.promise;
      } else {
        return results;
      }
    }
	$scope.searchTextChange=function(text) {
      //$log.info('Text changed to ' + text);
    }

    $scope.selectedItemChange=function(item) {
     // $log.info('Item changed to ' + JSON.stringify(item));
    }
	function createFilterFor(query) {
      var lowercaseQuery = query.toLowerCase();
       return function filterFn(item) {
        return (item.name.indexOf(lowercaseQuery) === 0);
      }; 

    }
	
	 /////End vendor drop-down///////
	$scope.expensesLoader = true;
	$http.get(BASE_URL + 'expenses/get_expense/' + EXPENSEID).then(function (Expense) {
		$scope.expense = Expense.data;
		$scope.itemcut = {
			name: $scope.expense.customer_name,
			id: $scope.expense.customer,
		};
		//var itemcut.name = $scope.expense.customer_name;
		//var itemcut.id = $scope.expense.customer;
		//var searchCustomer = $scope.expense.customername?cust.split(' ')[0]:'';
		//$scope.search_customers(searchCustomer);
		$scope.expensesLoader = false;

		$scope.subtotal = function () {
			var subtotal = 0;
			angular.forEach($scope.expense.items, function (item) {
				subtotal += item.quantity * item.price;
			});
			return subtotal.toFixed(2);
		};
		$scope.linediscount = function () {
			var linediscount = 0;
			angular.forEach($scope.expense.items, function (item) {
				linediscount += ((item.discount) / 100 * item.quantity * item.price);
			});
			return linediscount.toFixed(2);
		};
		$scope.totaltax = function () {
			var totaltax = 0;
			angular.forEach($scope.expense.items, function (item) {
				totaltax += ((item.tax) / 100 * item.quantity * item.price);
			});
			return totaltax.toFixed(2);
		};
		$scope.grandtotal = function () {
			var grandtotal = 0;
			angular.forEach($scope.expense.items, function (item) {
				grandtotal += item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price) - ((item.discount) / 100 * item.quantity * item.price);
			});
			return grandtotal.toFixed(2);
		};
		$http.get(BASE_URL + 'material/get_all_materials_new').then(function (materials) {
			$scope.materials = materials.data;
		});
		$http.get(BASE_URL + 'api/get_projects').then(function (Projects) {
			$scope.projects = Projects.data;
		});
		$scope.Getmaterial = function (searchText) {
			var deferred = $q.defer();
			$timeout(function() {
				var states = $scope.materials.filter(function(state) {
					return (state.name.toUpperCase().indexOf(searchText.toUpperCase()) !== -1);
				});
				deferred.resolve(states);
			}, 1500);
			return deferred.promise;
		}; 
	/* $http.get(BASE_URL + 'api/products').then(function (Products) {
		$scope.products = Products.data;
	});

	$scope.GetProduct = (function (search) {
		console.log(search);
		var deferred = $q.defer();
		$timeout(function () {
			deferred.resolve($scope.products);
		}, Math.random() * 500, false);
		return deferred.promise;
	}); */

		$scope.add = function () {
			$scope.expense.items.push({
				name: new_item,
				product_id: 0,
				code: '',
				description: '',
				quantity: 1,
				unit: item_unit,
				price: 0,
				account: 0,
				tax: 0,
				project_id:0,
				discount: 0,
			});
		};

		$scope.remove = function (index) {
			var item = $scope.expense.items[index];
			$http.post(BASE_URL + 'invoices/remove_item/' + item.id)
				.then(
					function (response) {
						console.log(response);
						$scope.expense.items.splice(index, 1);
						$scope.expense.balance = $scope.expense.balance - item.total;
						$scope.amount = $scope.expense.balance;
					},
					function (response) {
						console.log(response);
					}
				);
		};


		$scope.UpdateExpense = function () {
			$scope.savingExpense = true;
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
				var expense_recurring;
				if ($scope.expense_recurring == true) { 
					expense_recurring = '1';
				} else {
					expense_recurring = '0';
				}

				var EndRecurring;
				if ($scope.expense.EndRecurring) {
					EndRecurring = moment($scope.expense.EndRecurring).format("YYYY-MM-DD 00:00:00");
				} else {
					EndRecurring = 'Invalid date';
				}

				var internal = false;
				if ($scope.expense.internal == true) {
					internal = true;
				}
				if ($scope.expense.customer == '0') {
					$scope.expense.customer = '';
				}

				if (!$scope.expense) {
					var dataObj = $.param({
						title: '',
						amount: '',
						date: '',
						category: '',
						account: '',
						description: '',
						customer: '',
						number: '',
						custom_fields: '',
					});
				} else {
					var dataObj = $.param({
						title: $scope.expense.title,
						amount: $scope.expense.amount,
						card: $scope.expense.card,
						amountType: $scope.expense.amountType,
						date: moment($scope.expense.date_edit).format("YYYY-MM-DD"),
						category: $scope.expense.category,
						account: $scope.expense.account,
						//customer: $scope.expense.customer,
						customer: $scope.itemcut.name,
						customer_id: $scope.itemcut.id,
						custom_fields: $scope.tempArr,
						number: $scope.expense.number,
						internal: internal,
						sub_total: $scope.subtotal,
						total_discount: $scope.linediscount,
						total_tax: $scope.totaltax,
						total: $scope.grandtotal,
						staff: $scope.expense.staff_id,
						// START Recurring
						recurring_status: expense_recurring,
						recurring: $scope.expense.recurring_status,
						end_recurring: EndRecurring,
						recurring_type: $scope.expense.recurring_type,
						recurring_period: $scope.expense.recurring_period,
						recurring_id: $scope.expense.recurring_id,
						// END Recurring
						items: $scope.expense.items,
						totalItems: $scope.expense.items.length
					});
				}
				var posturl = BASE_URL + 'expenses/update/'+EXPENSEID;
				$http.post(posturl, dataObj, config)
					.then(
						function (response) {
							$scope.savingExpense = false;
							if (response.data.success == true) {
								//showToast(NTFTITLE, response.data.message, ' success');
								window.location.href = BASE_URL + 'expenses/receipt/' + response.data.id;
							} else {
								showToast(NTFTITLE, response.data.message, ' danger');
							}
						},
						function (response) {
							$scope.savingExpense = false;
							console.log(response);
						}
					);
		};

		$scope.sendEmail = function() {
			$scope.sendingEmail = true;
			$http.post(BASE_URL + 'expenses/send_expense_email/' + EXPENSEID)
				.then(
					function (response) {
						showToast(NTFTITLE, lang.email_sent_success, 'success');
						$scope.sendingEmail = false;
					},
					function (response) {
						$scope.sendingEmail = false;
						showToast(NTFTITLE, response, 'success');
						console.log(response);
					}
				);
		};

		$scope.GeneratePDF = function(ev) {
			$mdDialog.show({
				templateUrl: 'generate-expense-summary.html',
				scope: $scope,
				preserveScope: true,
				targetEvent: ev
			});
		};

		$scope.CreatePDF = function() {
			$scope.PDFCreating = true;
			$http.post(BASE_URL + 'expenses/create_pdf/' + EXPENSEID)
				.then(
					function (response) {
						console.log(response)
						if (response.data.status === true) {
							$scope.PDFCreating = false;
							$scope.CreatedPDFName = response.data.file_name;
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
		
		$http.get(BASE_URL + 'api/expensescategories').then(function (Categories) {
			$scope.categories = Categories.data;
		});

		$scope.Delete = function (index) {
			globals.deleteDialog(lang.attention, lang.delete_expense, EXPENSEID, lang.doIt, lang.cancel, 'expenses/remove/' + EXPENSEID, function(response) {
				if (response.success == true) {
					globals.mdToast('success',response.message);
					window.location.href = BASE_URL + 'expenses';
				} else {
					globals.mdToast('error',response.message);
				}
			});
		};

		$scope.Convert = function (index) {
			globals.deleteDialog(lang.convert_title, lang.convert_text, EXPENSEID, lang.convert, lang.cancel, 'expenses/convert/' + EXPENSEID, function(response) {
				if (response.success == true) {
					window.location.href = BASE_URL + 'invoices/invoice/' + response.id;
				} else {
					globals.mdToast('error',response.message);
				}
			});
		};
	});

	$scope.UploadFile = function (ev) {
		$mdDialog.show({
			templateUrl: 'addfile-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.uploading = false; 
	$scope.uploadExpenseFile = function() {
		$scope.uploading = true;
        var file = $scope.project_file;
        var uploadUrl = BASE_URL+'expenses/add_file/'+EXPENSEID;
        fileUpload.uploadFileToUrl(file, uploadUrl, function(response) {
        	if (response.success == true) {
        		globals.mdToast('success', response.message);
        	} else {
        		globals.mdToast('error', response.message);
        	}
        	$scope.expensesFiles = true;
        	$http.get(BASE_URL + 'expenses/files/'+ EXPENSEID).then(function (Files) {
        		$scope.files = Files.data;
        		$scope.expensesFiles = false;
        	});
        	$scope.uploading = false;
        	$mdDialog.hide();
        });
    };

	/* $http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
		$scope.accounts = Accounts.data;
	}); */

	$scope.accounts = '';
	$scope.expensesFiles = true;
	$http.get(BASE_URL + 'expenses/files/'+ EXPENSEID).then(function (Files) {
		$scope.files = Files.data;

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
			return Math.ceil($scope.files.length / $scope.itemsPerPage) - 1;
		};
		$scope.expensesFiles = false;
		$scope.ViewFile = function(index, image) {
			$scope.file = $scope.files[index];
			$mdDialog.show({
				templateUrl: 'view_image.html',
				scope: $scope,
				preserveScope: true,
				targetEvent: $scope.file.id
			});
		};

		$scope.DeleteFile = function(id) {
			var confirm = $mdDialog.confirm()
				.title($scope.lang.delete_file_title)
				.textContent($scope.lang.delete_file_message)
				.ariaLabel($scope.lang.delete_file_title)
				.targetEvent(EXPENSEID)
				.ok($scope.lang.delete)
				.cancel($scope.lang.cancel);

			$mdDialog.show(confirm).then(function () {
				$http.post(BASE_URL + 'expenses/delete_file/' + id, config)
					.then(
						function (response) {
							if(response.data.success == true) {
								showToast(NTFTITLE, response.data.message, ' success');
								$http.get(BASE_URL + 'expenses/files/'+ EXPENSEID).then(function (Files) {
									$scope.files = Files.data;
								});
							} else {
								globals.mdToast('error', response.data.message);
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
	});

	$http.get(BASE_URL + 'api/expensescategories').then(function (Epxensescategories) {
		$scope.expensescategories = Epxensescategories.data;
	});
}
CiuisCRM.controller('Expenses_Controller', Expenses_Controller);
CiuisCRM.controller('Expense_Controller', Expense_Controller);

CiuisCRM.directive('documentUpload', function () {
	return {
        scope: true,        //create a new scope
        link: function (scope, el, attrs) {
            el.bind('change', function (event) {
                var files = event.target.files;
                //iterate files since 'multiple' may be specified on the element
                for (var i = 0;i<files.length;i++) {
                    //emit event upward
                    scope.$emit("documentSelected", { file: files[i] });
                }                                       
            });
        }
    };	
});