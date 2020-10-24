<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateCustomField"
    ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> 
            </md-button>
            <md-truncate><?php echo lang('new_custom_field'); ?></md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
        <md-input-container class="md-block">
            <label><?php echo lang('field_name'); ?></label>
            <input required ng-model="new_custom_field.name">
        </md-input-container>
        <md-input-container class="md-block" style=" margin-bottom: 40px; ">
            <label><?php echo lang('field_belogns_to'); ?></label>
            <md-select required ng-model="new_custom_field.relation">
                <md-option ng-value="relation.relation" ng-repeat="relation in custom_fields_relation_types">
                {{relation.name}}</md-option>
            </md-select>
        </md-input-container>
        <md-input-container class="md-block">
            <label><?php echo lang('field_order'); ?></label>
            <input type="number" ng-model="new_custom_field.order">
        </md-input-container>
        <md-input-container class="md-block" style=" margin-bottom: 40px; ">
            <label><?php echo lang('field_type'); ?></label>
            <md-select required ng-model="new_custom_field.type">
                <md-option ng-value="type.type" ng-repeat="type in custom_fields_types">{{type.name}}
                </md-option>
            </md-select>
        </md-input-container>
        <md-input-container class="md-icon-float md-icon-right md-block"
        ng-if="new_custom_field.type === 'select'">
        <input ng-model="new_custom_field.new_option_name" placeholder="Type option name">
        <md-icon ng-click="AddOption()" class="ion-ios-checkmark"></md-icon>
        </md-input-container>
        <md-list ng-if="new_custom_field.type === 'select'" class="bg-white">
            <md-list-item class="md-2-line" ng-repeat="option in select_options"
            style="max-height: 48px !important; height: 48px !important; min-height: 48px !important; padding: 0px;">
                <div class="md-list-item-text">
                    <h3> {{ option.name }} </h3>
                </div>
                <md-button class="md-secondary md-icon-button" ng-click='RemoveOption($index)'
                aria-label="call">
                <md-icon class="ion-trash-a"></md-icon>
                </md-button>
            <md-divider></md-divider>
            </md-list-item>
        </md-list>
        {{custom_fields.select_options}}
        <md-input-container>
            <md-switch class="pull-left" ng-model="new_custom_field.permission" aria-label="Status"><?php echo lang('only_admin');?>
            </md-switch>
        </md-input-container>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="AddCustomField()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_customfield == true">
                <span ng-hide="saving_customfield == true"><?php echo lang('create'); ?></span>
                <md-progress-circular class="white" ng-show="saving_customfield == true" md-mode="indeterminate" md-diameter="20">
                </md-progress-circular>
            </md-button>
        </section>
    </md-content>            
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" [fixedInViewport]="true"
    md-component-id="RestoreDatabaseNav" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i
                class="ion-android-arrow-forward"></i>
            </md-button>
            <md-truncate><?php echo lang('restoredatabase') ?></md-truncate>
        </div>
    </md-toolbar>
    <md-content>
        <?php echo form_open_multipart('settings/restore_database'); ?>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">
                    <?php echo lang('backup_file_msg'); ?>
                </label>
                <div class="file-upload">
                    <div class="file-select">
                        <div class="file-select-button" id="fileName"><span
                            class="mdi mdi-accounts-list-alt"></span>
                            <?php echo lang('attachment')?>
                        </div>
                        <div class="file-select-name" id="noFile">
                            <?php echo lang('notchoise')?>
                        </div>
                        <input type="file" name="upload_file" id="chooseFile" required=""
                        accept="application/zip,application/x-zip,application/x-zip-compressed,application/octet-stream">
                    </div>
                </div>
            </div>
            <br>
            <div class="well well-sm"><?php echo lang('backup_msg'); ?></div>
        </div>
        <div class="modal-footer">
            <button type="submit" ng-click="Restoring()"
            class="btn btn-default"><?php echo lang('save'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="FieldDetail" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i>
            </md-button>
            <md-truncate><?php echo lang('field_details'); ?></md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
            <md-input-container class="md-block">
                <label><?php echo lang('field_name'); ?></label>
                <input required ng-model="selected_field.name">
            </md-input-container>
            <md-input-container class="md-block" style=" margin-bottom: 40px; ">
                <label><?php echo lang('field_belogns_to'); ?></label>
                <md-select required ng-model="selected_field.relation">
                    <md-option ng-value="relation.relation" ng-repeat="relation in custom_fields_relation_types">
                    {{relation.name}}</md-option>
                </md-select>
            </md-input-container>
            <md-input-container class="md-block">
                <label><?php echo lang('field_order'); ?></label>
                <input type="number" ng-model="selected_field.order">
            </md-input-container>
            <md-input-container class="md-block" style=" margin-bottom: 40px; ">
                <label><?php echo lang('field_type'); ?></label>
                <md-select ng-model="selected_field.type">
                    <md-option ng-value="type.type" ng-repeat="type in custom_fields_types">{{type.name}}
                    </md-option>
                </md-select>
            </md-input-container>
            <md-input-container class="md-icon-float md-icon-right md-block"
                ng-if="selected_field.type === 'select'">
                <input ng-model="selected_field.new_option_name" placeholder="Type option name">
                <md-icon ng-click="AddOptionToField()" class="ion-ios-checkmark"></md-icon>
            </md-input-container>
            <md-list ng-if="selected_field.id === 1" class="bg-white">
                <md-list-item class="md-2-line" ng-repeat="option in selected_field.data"
                style="max-height: 48px !important; height: 48px !important; min-height: 48px !important; padding: 0px;">
                    <div class="md-list-item-text">
                        <h3> {{ option.name }} </h3>
                    </div>
                    <md-button class="md-secondary md-icon-button" ng-click='RemoveFieldOption($index)'
                        aria-label="call">
                        <md-icon class="ion-trash-a"></md-icon>
                    </md-button>
                    <md-divider></md-divider>
                </md-list-item>
            </md-list>
            {{custom_fields.select_options}}
            <md-input-container>
                <md-switch class="pull-left" ng-model="selected_field.permission" aria-label="Status">
                    <?php echo lang('only_admin');?></md-switch>
            </md-input-container>
            <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                <md-button ng-click="UpdateCustomField()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_customfield == true">
                    <span ng-hide="saving_customfield == true"><?php echo lang('update'); ?></span>
                    <md-progress-circular class="white" ng-show="saving_customfield == true" md-mode="indeterminate" md-diameter="20">
                    </md-progress-circular>
                </md-button>
            </section>
    </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" [fixedInViewport]="true"
    md-component-id="uploadAppFiles" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i
                class="ion-android-arrow-forward"></i>
            </md-button>
            <md-truncate><?php echo lang('uploadappfiles') ?></md-truncate>
        </div>
    </md-toolbar>
    <md-content>
        <?php echo form_open_multipart('settings/replace_files'); ?>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">
                    <?php echo lang('uploadappfiles'); ?>
                </label>
                <div class="file-upload">
                    <div class="file-select">
                        <div class="file-select-button" id="fileName"><span class="mdi mdi-upload"></span>
                            <?php echo lang('attachment')?>
                        </div>
                        <div class="file-select-name" id="noFile">
                            <?php echo lang('notchoise')?>
                        </div>
                        <input type="file" name="upload_file" id="chooseFile" required=""
                        accept="application/zip,application/x-zip,application/x-zip-compressed,application/octet-stream">
                    </div>
                </div>
            </div>
            <br>
            <div class="well well-sm"><?php echo lang('uploadappfiles_msg'); ?></div>
        </div>
        <div class="modal-footer">
            <button type="submit" ng-click="adding()"
            class="btn btn-default"><?php echo lang('upload'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" [fixedInViewport]="true" md-component-id="RunMySQL" ng-show="settings_detail.is_mysql == '1'" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
            <md-truncate><?php echo lang('mysql_queries') ?></md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
        <md-input-container class="md-block" ng-show="is_sql_query">
            <textarea rows="2" ng-model="mysql_query" placeholder="<?php echo lang('write_sql'); ?>"></textarea>
        </md-input-container>
        <md-input-container class="md-block" ng-show="!is_sql_query">
            <md-label><?php echo lang('select_mysql_file') ?></md-label>
            <input type="file" name="" file-model="sql_run_file" ng-model="sql_run_file" accept=".sql">
        </md-input-container>
        <md-switch ng-model="is_sql_query" aria-label="Type" ng-init="is_sql_query = false">
            <strong class="text-muted"><?php echo lang('sql_query') ?>?</strong>
        </md-switch>
        <div class="well well-sm"><?php echo lang('mysql_queries_msg'); ?></div>
     </md-content>
     <md-content layout-padding>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="RunMySQLQuery()" class="template-button" ng-disabled="executing == true" ng-show="is_sql_query">
                <span ng-hide="executing == true"><?php echo lang('execute');?></span>
                <md-progress-circular class="white" ng-show="executing == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
            <md-button ng-click="RunMySQLFile()" class="template-button" ng-disabled="executing == true" ng-show="!is_sql_query">
                <span ng-hide="executing == true"><?php echo lang('execute');?></span>
                <md-progress-circular class="white" ng-show="executing == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
            </md-button>
        </section>
    </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateApproval"
    ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> 
            </md-button>
            <md-truncate>{{title}}</md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
        <md-input-container class="md-block" style=" margin-bottom: 40px; ">
            <label><?php echo lang('module'); ?></label>
			<md-select required placeholder="<?php echo 'Select Module' ?>" ng-model="approval_field.module" name="module" ng-disabled="IsDisable">
              <md-option ng-value="module.id" ng-repeat="module in modulelist"ng-if="Is_update==0" >{{module.name}}</md-option>
              <md-option ng-value="module.id" ng-repeat="module in updatemodulelist" ng-if="Is_update==1" >{{module.name}}</md-option>
			</md-select>
        </md-input-container>
        <md-input-container class="md-block">
		    <md-radio-group ng-model="approval_field.option" name="option">
			  <md-radio-button ng-repeat="item in approvalitems" ng-value="item.value" aria-label="{{item.name}}">{{ item.name }}
			  </md-radio-button>
			</md-radio-group>
        </md-input-container>
		<md-content class="bg-white" layout-padding ng-cloak>
		<md-list-item ng-repeat="user in approval_field.approvaluser">
			<div layout-gt-md="col-md-12" style="width: 90% !important;">
				<md-input-container class="md-block" flex-gt-sm style="width:50% !important;">
					<label><?php echo lang('Employee'); ?></label>
					<md-select required placeholder="<?php echo 'Select User' ?>" ng-model="user.approvename">
					  <md-option ng-value="user.id" ng-repeat="user in approveuserlist">{{user.name}}</md-option>
					</md-select>
				</md-input-container>
			<!-- 	<md-input-container class="md-block" flex-gt-sm ng-show="approval_field.option=='level'" style="width:39% !important;">
					<label><?php echo lang('level'); ?></label>
					<md-select required placeholder="<?php echo 'Select level' ?>"ng-model="user.approvelevel">
					  <md-option ng-value="eachlevel.id" ng-repeat="eachlevel in modulelevel">{{eachlevel.name}}</md-option>
					</md-select>
				</md-input-container> -->
				<md-input-container class="md-block" flex-gt-sm ng-show="approval_field.option=='price'" style="width:39% !important;">
					<label><?php echo lang('value'); ?></label>
					<input class="min_input_width" ng-model="user.approveprice">
				</md-input-container>
				<md-input-container style="width:1% !important;">
					<input type="hidden" ng-model="user.approveid">
				</md-input-container>
				<md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
			</div>
		</md-list-item>
		<md-content class="bg-white" layout-padding>
			<div class="col-md-12">
				<md-button ng-click="addapprove()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
					<md-icon class="ion-plus-round text-muted"></md-icon>
				</md-button>
			</div>
		</md-content>
	</md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="AddapproveField()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_approval == true">
                <span ng-hide="saving_approval == true">{{btntitle}}</span>
                <md-progress-circular class="white" ng-show="saving_approval == true" md-mode="indeterminate" md-diameter="20">
                </md-progress-circular>
            </md-button>
        </section>
    </md-content>            
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateRoleAssign"
    ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> 
            </md-button>
            <md-truncate>{{title}}</md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
        <md-input-container class="md-block">
		    <md-radio-group ng-model="roles_assign_field.option" name="option">
			  <md-radio-button ng-repeat="item in stafftypeitems" ng-value="item.value" aria-label="{{item.name}}">{{ item.name }}
			  </md-radio-button>
			</md-radio-group>
        </md-input-container>
		<md-content class="bg-white" layout-padding ng-cloak>
		<md-input-container class="md-block" flex-gt-sm ng-show="roles_assign_field.option=='staff'">
			<label><?php echo lang('Employee'); ?></label>
			<md-select required placeholder="<?php echo 'Select User' ?>" ng-model="roles_assign_field.staffId">
			  <md-option ng-value="user.id" ng-repeat="user in staffuserlist">{{user.name}}</md-option>
			</md-select>
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm ng-show="roles_assign_field.option=='nonstaff'">
				<label><?php echo lang('staffname'); ?></label>
				<input class="min_input_width" ng-model="roles_assign_field.staffName">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('email'); ?></label>
            <input required type="text" ng-model="roles_assign_field.staffEmail" ng-pattern="/^.+@.+\..+$/">
        </md-input-container>
		 <md-input-container class="md-block password-input">
          <label><?php echo lang('password') ?></label>
          <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
          <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('Role'); ?></label>
			<md-select required placeholder="<?php echo 'Select Role' ?>" ng-model="roles_assign_field.staffRole">
			  <md-option ng-value="eachrole.id" ng-repeat="eachrole in rolelist">{{eachrole.name}}</md-option>
			</md-select>
		</md-input-container>
	</md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="AddRoleAssign()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_roleassign == true">
                <span ng-hide="saving_roleassign == true">{{btntitle}}</span>
                <md-progress-circular class="white" ng-show="saving_roleassign == true" md-mode="indeterminate" md-diameter="20">
                </md-progress-circular>
            </md-button>
        </section>
    </md-content>            
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="EditRoleAssign"
    ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> 
            </md-button>
            <md-truncate>{{title}}</md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
		<md-content class="bg-white" layout-padding ng-cloak>
		<md-input-container class="md-block" flex-gt-sm>
				<label><?php echo lang('staffname'); ?></label>
				<input type="hidden" ng-model="roles_assign_field.staffId">
				<input class="min_input_width" ng-model="roles_assign_field.staffName">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('email'); ?></label>
            <input required type="text" ng-model="roles_assign_field.staffEmail" ng-pattern="/^.+@.+\..+$/">
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
		  Would you like to change Password:   <md-checkbox ng-model="showpassword"></md-checkbox>
		</md-input-container>
		 <md-input-container class="md-block password-input" ng-show="showpassword">
          <label><?php echo lang('password') ?></label>
          <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
          <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('Role'); ?></label>
			<md-select required placeholder="<?php echo 'Select Role' ?>" ng-model="roles_assign_field.staffRole">
			  <md-option ng-value="eachrole.id" ng-repeat="eachrole in rolelist">{{eachrole.name}}</md-option>
			</md-select>
		</md-input-container>
	</md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="EditRoleAssign()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_roleassign == true">
                <span ng-hide="saving_roleassign == true">{{btntitle}}</span>
                <md-progress-circular class="white" ng-show="saving_roleassign == true" md-mode="indeterminate" md-diameter="20">
                </md-progress-circular>
            </md-button>
        </section>
    </md-content>            
</md-sidenav>

<md-sidenav ng-show="editsalestarget == true" class="md-sidenav-right md-whiteframe-4dp" md-component-id="EditTargetAssign"
    ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
            <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i
                class="ion-android-arrow-forward"></i> 
            </md-button>
            <md-truncate>{{title}}</md-truncate>
        </div>
    </md-toolbar>
    <md-content layout-padding>
		<md-content class="bg-white" layout-padding ng-cloak>
		<md-input-container class="md-block" flex-gt-sm>
				<label><?php echo lang('staffname'); ?></label>
				<input type="hidden" ng-model="roles_assign_field.staffId">
				<input class="min_input_width" ng-model="roles_assign_field.staffName">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('email'); ?></label>
            <input required type="text" ng-model="roles_assign_field.staffEmail" ng-pattern="/^.+@.+\..+$/">
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
		  Would you like to change Password:   <md-checkbox ng-model="showpassword"></md-checkbox>
		</md-input-container>
		 <md-input-container class="md-block password-input" ng-show="showpassword">
          <label><?php echo lang('password') ?></label>
          <input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
          <md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
        </md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('Role'); ?></label>
			<md-select required placeholder="<?php echo 'Select Role' ?>" ng-model="roles_assign_field.staffRole">
			  <md-option ng-value="eachrole.id" ng-repeat="eachrole in rolelist">{{eachrole.name}}</md-option>
			</md-select>
		</md-input-container>
	</md-content>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
            <md-button ng-click="EditRoleAssign()" class="md-raised md-primary pull-right block-button" ng-disabled="saving_roleassign == true">
                <span ng-hide="saving_roleassign == true">{{btntitle}}</span>
                <md-progress-circular class="white" ng-show="saving_roleassign == true" md-mode="indeterminate" md-diameter="20">
                </md-progress-circular>
            </md-button>
        </section>
    </md-content>            
</md-sidenav>