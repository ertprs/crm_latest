 <md-content class="bg-white" style="padding:0px">
 	<md-toolbar class="toolbar-white">
 		<div class="md-toolbar-tools">
 			<h2 flex md-truncate class="pull-left" ><strong><?php echo lang('approve') ?></strong></h2>
 			<?php if (check_privilege('settings', 'create')) { ?> 
 				<md-button ng-click="CreateApproval()" class="md-icon-button md-primary" aria-label="New">
 					<md-tooltip md-direction="top"><?php echo lang('new_approval') ?></md-tooltip>
 					<md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
 				</md-button>
 			<?php } ?>
 		</div>
 	</md-toolbar>
 	<md-content ng-show="!approvalLoader" class="bg-white" ng-cloak> 
 		<md-table-container ng-show="approve_lists.length > 0">
 			<table md-table  md-progress="promise">
 				<thead md-head md-order="approve_lists.order">
 					<tr md-row>
 						<th md-column><span><?php echo lang('module'); ?></span></th>
 						<th md-column md-order-by="option"><span><?php echo lang('option'); ?></span></th>
 						<th md-column md-order-by="active"><span><?php echo lang('status'); ?></span></th>
 						<th md-column md-order-by="created_on"><span><?php echo lang('created_on'); ?></span></th>
 						<th md-column><span><?php echo lang('actions'); ?></span></th>
 					</tr>
 				</thead>
 				<tbody md-body>
 					<tr class="select_row" md-row ng-repeat="field in approve_lists | orderBy: approveitem_lists.order | limitTo: approveitem_lists.limit : (approveitem_lists.page -1) * approveitem_lists.limit"  class="cursor">
 						<td md-cell>
 							<strong>
 								<span ng-bind="field.module"></span>
 							</strong>
 						</td>
 						<td md-cell>
 							<strong><span class="text-uppercase" ng-bind="field.option"></span></strong>
 						</td>
 						<td md-cell>
 							<md-switch style="margin:unset!important" ng-change="UpdateApprovalStatus(field.id,field.active)" ng-model="field.active"><label><?php echo lang('active');?></label></md-switch>
 						</td>
 						<td md-cell>
 							<strong ng-bind="field.created_on"></strong>
 						</td>
 						<td md-cell>
 							<?php if (check_privilege('settings', 'edit')) { ?> 
 								<md-button class="md-icon-button" aria-label="Edit" ng-click="GetApprovalDetail(field.id);" ng-cloak>
 									<md-tooltip md-direction="bottom"><?php echo lang('edit_field') ?></md-tooltip>
 									<md-icon><i class="ion-compose text-muted"></i></md-icon>
 								</md-button>
 							<?php } if (check_privilege('settings', 'delete')) { ?> 
 								<md-button class="md-icon-button" aria-label="Delete" ng-click="RemoveApproval(field.id);" ng-cloak>
 									<md-tooltip md-direction="bottom"><?php echo lang('remove_field') ?></md-tooltip>
 									<md-icon><i class="ion-android-delete text-muted"></i></md-icon>
 								</md-button>
 							<?php } ?>
 						</td>
 					</tr>
 				</tbody>
 			</table>
 		</md-table-container>
 		<md-table-pagination ng-show="approve_lists.length > 0" md-limit="approveitem_lists.limit" md-limit-options="limitOptions" md-page="approveitem_lists.page" md-total="{{approve_lists.length}}" ></md-table-pagination>
 		<md-content ng-show="!approve_lists.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
 	</md-content>
 </md-content>