<style type="text/css">
.hide {display: none;}
.width25 {width: 25%;}
.width15 {width:15%;}
.mrgn_lft30 {margin-left:30px}
.mrgn_lft60 {margin-left:60px;}
</style>
<?php if (check_privilege('settings', 'edit')) { ?> 
	<md-content ng-show="viewsalestarget == true" class="md-padding bg-white">
		<md-button ng-click="addTarget()" class="md-raised md-primary pull-right successButton" ng-disabled="getsalestarget == true">
			<span ng-hide="getsalestarget == true"><?php echo lang('create').' '.lang('target');?></span>
			<md-progress-circular class="white" ng-show="getsalestarget == true" md-mode="indeterminate" md-diameter="20">
			</md-progress-circular>
		</md-button>
	</md-content>
<?php } ?>
<md-content ng-show="viewsalestarget == true" class="md-padding bg-white"> 
	<md-table-container>
		<table md-table md-progress="promise">
			<thead md-head>
				<tr md-row>
					<th md-column><?php echo lang('Year'); ?></th>
					<th md-column><?php echo lang('name').' '.lang('type'); ?></th>
					<th md-column><?php echo lang('1st_quarter'); ?></th>
					<th md-column><?php echo lang('2nd_quarter'); ?></th>
					<th md-column><?php echo lang('3rd_quarter'); ?></th>
					<th md-column><?php echo lang('4th_quarter'); ?></th>
					<th md-column><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody md-body>
				<tr class="select_row" md-row ng-repeat="target in sales_target_lists">
					<td md-cell>
						<span ng-bind="target.year"></span>
					</td>
					<td md-cell>
						<span ng-bind="target.staffname"></span>
					</td>
					<td md-cell>
						<span ng-bind="target.qtr1"></span>
					</td>
					<td md-cell>
						<span ng-bind="target.qtr2"></span>
					</td>
					<td md-cell>
						<span ng-bind="target.qtr3"></span>
					</td>
					<td md-cell>
						<span ng-bind="target.qtr4"></span>
					</td>
					<td md-cell>
						<?php if (check_privilege('settings', 'edit')) { ?> 
							<span ng-click="edit_target(target.targetId)">
								<md-progress-circular ng-show="editLoader == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
								<md-icon  ng-hide="editLoader == true" md-menu-align-target class="md-raised md-primary mdi mdi-edit" style="margin: auto 3px auto 0;">
								</md-icon>
							</span>
						<?php } if (check_privilege('settings', 'delete')) { ?> 
							<span ng-click="delete_target(target.targetId)"> 
								<md-icon md-menu-align-target class="md-raised md-primary ion-trash-b" style="margin: auto 3px auto 0;">
								</md-icon>
							</span>
						<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>
	</md-table-container>
</md-content>
<br/>
<md-content ng-show="createsalestarget == true" class="bg-white">
	<md-button ng-click="create_target()" class="md-raised md-primary btn-report pull-right" ng-disabled="creatingRole == true">
		<span ng-hide="creatingRole == true"><?php echo lang('create');?></span>
		<md-progress-circular class="white" ng-show="creatingRole == true" md-mode="indeterminate" md-diameter="20">
		</md-progress-circular>
	</md-button>
	<md-button ng-click="cancel_target()" class="md-raised md-primary btn-report pull-right">
		<?php echo lang('cancel');?>
	</md-button>
</md-content>
<md-content ng-show="createsalestarget == true" class="bg-white"> 
	<div layout-gt-xs="row" layout-padding>
		<md-input-container class="md-block" flex-gt-xs></md-input-container>
		<md-input-container class="md-block" flex-gt-xs></md-input-container>
		<md-input-container class="md-block" flex-gt-xs></md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('target').' '.lang('year') ?></label>
			<md-select ng-model="target.year" name="targetyear">
			    <md-option ng-value="eachyear.value" ng-repeat="eachyear in targetyearlist" ng-selected="eachyear.value == 2020">{{eachyear.name}}</md-option>
			</md-select>
		</md-input-container>
	</div>
	<hr>
	<md-list-item ng-repeat="target in tergates.items">
		<md-input-container class="md-block" flex-gt-sm style="padding-bottom:2%;">
			<label><?php echo lang('Employee'); ?></label>
			<md-select required placeholder="<?php echo 'Select User' ?>" ng-model="target.staffId">
			  <md-option ng-value="user.id" ng-repeat="user in saleteamuserlist">{{user.name}}</md-option>
			</md-select>
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('1st_quarter'); ?></label>
			<input type="number" class="min_input_width" ng-model="target.qtr1">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('2nd_quarter'); ?></label>
			<input type="number" class="min_input_width" ng-model="target.qtr2">
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('3rd_quarter'); ?></label>
			<input type="number" class="min_input_width" ng-model="target.qtr3">
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('4th_quarter'); ?></label>
			<input type="number" class="min_input_width" ng-model="target.qtr4">
		</md-input-container>
        <md-icon aria-label="Remove Line" ng-click="remove($index)" class="ion-trash-b text-muted"></md-icon>
    </md-list-item>
	<div class="col-md-6">
	  <md-button ng-click="addMoreTarget()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
		<md-icon class="ion-plus-round text-muted"></md-icon>
	  </md-button>
	</div>
	<br><br><br>
</md-content>  

