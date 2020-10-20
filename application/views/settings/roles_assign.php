 <md-content class="bg-white" style="padding:0px">
 	<md-toolbar class="toolbar-white">
 		<div class="md-toolbar-tools">
 			<h2 flex md-truncate class="pull-left" ><strong><?php echo lang('User Group') ?></strong></h2>
 			<?php if (check_privilege('settings', 'create')) { ?> 
 				<md-button ng-click="CreateRoleAssign()" class="md-icon-button md-primary" aria-label="New">
 					<md-tooltip md-direction="top"><?php echo lang('new_roles_assign') ?></md-tooltip>
 					<md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
 				</md-button>
 			<?php } ?>
 		</div>
 	</md-toolbar>
 	<md-content ng-show="!rolesassignLoader" class="bg-white" ng-cloak> 
 		<md-table-container ng-show="rolesassign_lists.length > 0">
 			<table md-table  md-progress="promise">
 				<thead md-head md-order="rolesassign_lists.staffname">
 					<tr md-row>'
 						<th md-column md-order-by="staffname"><span><?php echo lang('staffname'); ?></span></th>
 						<th md-column md-order-by="role_name"><span><?php echo lang('Role'); ?></span></th>
 						<th md-column md-order-by="status"><span><?php echo lang('status'); ?></span></th>
 						<th md-column><span><?php echo lang('actions'); ?></span></th>
 					</tr>
 				</thead>
 				<tbody md-body>
 					<tr class="select_row" md-row ng-repeat="field in rolesassign_lists | orderBy: rolesassignitem_lists.order | limitTo: rolesassignitem_lists.limit : (rolesassignitem_lists.page -1) * rolesassignitem_lists.limit"  class="cursor">
 						<td md-cell>
 							<strong>
 								<span ng-bind="field.staffname"></span>
 							</strong>
 						</td>
						<td md-cell>
 							<strong><span class="text-uppercase" ng-bind="field.role_name"></span></strong>
 						</td>
						<!--<td md-cell>
 							<strong><span class="text-uppercase" ng-bind="field.statusname"></span></strong>
 						</td>-->
						<td md-cell>
 							<md-switch style="margin:unset!important" ng-change="UpdateAssignStatus(field.staffId,field.login_access,field.admin)" ng-model="field.login_access"><label><?php echo lang('active');?></label></md-switch>
 						</td>
 						<td md-cell>
 							<?php if (check_privilege('settings', 'edit')) { ?> 
 								<md-button class="md-icon-button" aria-label="Edit" ng-click="GetstaffDetail(field.staffId);" ng-cloak>
 									<md-tooltip md-direction="bottom"><?php echo lang('edit_field') ?></md-tooltip>
 									<md-icon><i class="ion-compose text-muted"></i></md-icon>
 								</md-button>
 							<?php } ?>
							<md-button data-toggle="modal" data-target="#roleModal" class="md-icon-button" aria-label="Edit" ng-click="GetstaffRoleDetail(field.staffId);" ng-cloak>
								<md-tooltip md-direction="bottom"><?php echo lang('role') ?></md-tooltip>
								<md-icon><img src="assets/img/role-icon.jpg" width="25px" height="25px"/></md-icon>
							</md-button>
							<?php if (check_privilege('settings', 'delete')) { ?> 
 								<span ng-click="delete_NonStaff(field.staffId)" ng-show="field.is_staff !=1"> 
									<md-icon md-menu-align-target class="md-raised md-primary ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
								</span>
 							<?php } ?>
							<md-button ng-show='field.permissionStaff !=0' class="md-icon-button" aria-label="Reset" ng-cloak ng-click="resetStaff(field.staffId)">
								<md-icon><img src="assets/img/reset-img.jpg" width="25px"height="25px"/></md-icon>
							</md-button>
 						</td>
 					</tr>
 				</tbody>
 			</table>
 		</md-table-container>
 		<md-table-pagination ng-show="rolesassign_lists.length > 0" md-limit="rolesassignitem_lists.limit" md-limit-options="limitOptions" md-page="rolesassignitem_lists.page" md-total="{{rolesassign_lists.length}}" ></md-table-pagination>
 		<md-content ng-show="!rolesassign_lists.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
 	</md-content>
 </md-content>
 
 <!-- Individual Role Settings-->
 <script type="text/ng-template" id="addrole-template.html">
  <md-dialog aria-label="options dialog" style="min-width:80% !important;; min-height:80% !important;">
  <md-dialog-content layout-padding>
   <md-table-container>
		<table md-table md-progress="promise">
			<tbody md-body>
				<tr ng-show="permission.key != 'quotes'" class="select_row" md-row ng-repeat-start='permission in staff_permissions'>
				   <td md-cell class="width25">
						<md-checkbox ng-change="mainStaffCheckEdit(permission.id,permission.permission_check);" md-no-ink aria-label="view_own" ng-model="permission.permission_check" class="md-primary" id="permission.id"></md-checkbox>
				        <button class="btn btn-primary btn-xs" ng-show="permission.viewChilds == 1" ng-click="viewChilds= !viewChilds">
						<i class="fa fa-caret-down" ng-class="{'fa fa-caret-down': viewChilds != 1, 'fa fa-caret-up': viewChilds == 1}"></i></button>
						<span ng-bind="permission.permission_key"></span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-show="permission.key != 'staff' && permission.key != 'accounts' && permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'settings'" md-no-ink aria-label="view_own" ng-model="permission.permission_view_own" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">  
							<md-checkbox md-no-ink aria-label="view_all" ng-model="permission.permission_view_all" class="md-primary">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'staff'" md-no-ink aria-label="create" ng-model="permission.permission_create" class="md-primary" ng-change="permission.permission_create?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="permission.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && newrole.usertype != 'other' && permission.key != 'staff'" md-no-ink aria-label="edit" ng-model="permission.permission_edit" class="md-primary" ng-change="permission.permission_edit?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
					<td md-cell class="width15">
						<span ng-show="permission.viewChilds == 0">
							<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'"ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other'"md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
							<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="permission.key != 'report' && permission.key != 'emails' && newrole.usertype != 'other' && permission.key != 'staff'"md-no-ink aria-label="delete" ng-model="permission.permission_delete" class="md-primary" ng-change="permission.permission_delete?((!permission.permission_view_own && !permission.permission_view_all)? (permission.permission_view_own = true):''):''">
							</md-checkbox>
						</span>
					</td>
				</tr>
				<tr class="select_row" ng-show="permission.viewChilds == 1" md-row ng-class="viewChilds == 1? '' : 'hide'">
					 <td colspan='6' ng-class="viewChilds == 1? '' : 'hide'">
						<table md-table>
							<tbody md-body>
								<tr class="select_row" md-row>
									<td md-cell class="width25"><?php echo lang('Permissions'); ?></td>
									<td md-cell class="width15"><?php echo lang('view').' '.lang('own'); ?></td>
									<td md-cell class="width15"><?php echo lang('view').' '.lang('all'); ?></td>
									<td md-cell class="width15"><?php echo lang('create'); ?></td>
									<td md-cell class="width15"><?php echo lang('edit'); ?></td>
									<td md-cell class="width15"><?php echo lang('delete'); ?></td>
								</tr>
								<tr class="select_row" md-row ng-repeat-start='chilItem in permission.child'>
									<td md-cell class="width25">
										<md-checkbox ng-change="mainStaffSubEditCheck(chilItem.id,chilItem.permission_check)" md-no-ink aria-label="view_own" ng-model="chilItem.permission_check" class="md-primary"></md-checkbox>
										<button class="btn btn-primary btn-xs mrgn_lft30" ng-show="chilItem.viewChilds == 1" ng-click="viewSubChilds= !viewSubChilds"><i class="fa fa-caret-down" ng-class="{'fa fa-caret-down': viewSubChilds != 1, 'fa fa-caret-up': viewSubChilds == 1}"></i></button>
										<span ng-class="{'mrgn_lft30': chilItem.viewChilds == 0 }">{{chilItem.permission_key}}</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-show="chilItem.key != 'accounts' && chilItem.key != 'report' && chilItem.key != 'emails' && chilItem.key != 'settings' && newrole.usertype != 'other'" md-no-ink aria-label="view_own" ng-model="chilItem.permission_view_own" class="md-primary" ng-change="mainSubUnCheck(chilItem.parent,chilItem.permission_view_own)">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>  
											<md-checkbox md-no-ink aria-label="view_all" ng-model="chilItem.permission_view_all" class="md-primary">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilItem.permission_create" class="md-primary" ng-change="chilItem.permission_create?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilItem.permission_edit" class="md-primary" ng-change="chilItem.permission_edit?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
									<td md-cell class="width15">
										<span>
											<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
											<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilItem.key != 'report' && chilItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilItem.permission_delete" class="md-primary" ng-change="chilItem.permission_delete?((!chilItem.permission_view_own && !chilItem.permission_view_all)? (chilItem.permission_view_own = true):''):''">
											</md-checkbox>
										</span>
									</td>
								</tr>
								<tr class="select_row" ng-show="chilItem.viewChilds == 1" md-row ng-class="viewSubChilds == 1? '' : 'hide'">
									<td colspan='6' ng-class="viewSubChilds == 1? '' : 'hide'">
										<table md-table>
											<tbody md-body>
											<tr class="select_row" md-row ng-repeat='chilSubItem in chilItem.child'>
												<td md-cell class="width25">
													<span class="mrgn_lft60" ng-bind="chilSubItem.permission_key"></span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-show="chilSubItem.key != 'staff' && chilSubItem.key != 'accounts' && chilSubItem.key != 'report' && chilSubItem.key != 'emails' && chilSubItem.key != 'settings' && newrole.usertype != 'other'" md-no-ink aria-label="view_own" ng-model="chilSubItem.permission_view_own" class="md-primary">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
														<span>  
															<md-checkbox md-no-ink aria-label="view_all" ng-model="chilSubItem.permission_view_all" class="md-primary">
															</md-checkbox>
														</span>
													</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="create" ng-model="chilSubItem.permission_create" class="md-primary" ng-change="chilSubItem.permission_create?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && newrole.usertype != 'other'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="edit" ng-model="chilSubItem.permission_edit" class="md-primary" ng-change="chilSubItem.permission_edit?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)? (chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
												<td md-cell class="width15">
													<span>
														<md-checkbox ng-if="newrole.usertype == 'admin' || newrole.usertype == 'other'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)?(chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
														<md-checkbox ng-if="newrole.usertype == 'staff'" ng-show="chilSubItem.key != 'report' && chilSubItem.key != 'emails' && newrole.usertype != 'other' && chilSubItem.key != 'staff'" md-no-ink aria-label="delete" ng-model="chilSubItem.permission_delete" class="md-primary" ng-change="chilSubItem.permission_delete?((!chilSubItem.permission_view_own && !chilSubItem.permission_view_all)?(chilSubItem.permission_view_own = true):''):''">
														</md-checkbox>
													</span>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<tr ng-repeat-end ></tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr ng-repeat-end ></tr>
			</tbody>
		</table>
	</md-table-container>
  </md-dialog-content>
  </br></br>
  <md-dialog-actions>
	<md-button ng-click="SavePermissionsByStaff(individual_role_permissions)" aria-label="add" class="btn btn-success"><?php echo lang('save') ?></md-button>
    <md-button ng-click="modelclose()" aria-label="add" class="btn btn-danger"><?php echo lang('cancel') ?>!</md-button>
  </md-dialog-actions>
  </md-dialog>
</script>