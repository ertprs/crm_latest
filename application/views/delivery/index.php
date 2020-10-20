<?php include_once(APPPATH . 'views/inc/ciuis_data_table_header.php'); ?>
<?php $appconfig = get_appconfig(); ?>
<div class="ciuis-body-content" ng-controller="Delivery_Controller">
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
    <md-toolbar class="toolbar-white" style="margin-bottom: 1%;">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="File">
          <md-icon><i class="icon ico-ciuis-projects text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php echo lang('delivery'); ?> <small>(<span ng-bind="projects.length"></span>)</small></h2>
        <div class="ciuis-external-search-in-table" ng-cloak>
          <input ng-model="project_search" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('search_by') . ' ' . lang('project') . ' ' . lang('name') ?>">
          <md-button class="md-icon-button" aria-label="Search">
            <md-icon><i class="ion-search text-muted"></i></md-icon>
          </md-button>
        </div>
        <md-button ng-show="showGrid==true" ng-click="showGrid=false;showList=true;updateColumns('list_view', true);" class="md-icon-button" aria-label="New" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('show') . ' ' . lang('list') ?></md-tooltip>
          <md-icon><i class="ion-ios-list-outline text-muted"></i></md-icon>
        </md-button>
        <md-button ng-show="showList==true" ng-click="showList=false;showGrid=true;updateColumns('list_view', false);" class="md-icon-button" aria-label="New" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('show') . ' ' . lang('grid') ?></md-tooltip>
          <md-icon><i class="ion-android-apps text-muted"></i></md-icon>
        </md-button>
        <md-menu md-position-mode="target-right target">
          <md-button ng-show="showList==true" class="md-icon-button" aria-label="New" ng-cloak ng-click="$mdMenu.open($event)">
            <md-tooltip md-direction="bottom"><?php echo lang('filter_columns') ?></md-tooltip>
            <md-icon><i class="ion-connection-bars text-muted"></i></md-icon>
          </md-button>
          <md-menu-content width="4" ng-cloak>
            <md-contet layout-padding>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.name" ng-change="updateColumns('name', table_columns.name);">
                <?php echo lang('project') . ' ' . lang('name') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.customer" ng-change="updateColumns('customer', table_columns.customer);">
                <?php echo lang('customer') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.delivery_date" ng-change="updateColumns('startdate', table_columns.delivery_date);">
                <?php echo lang('startdate') ?>
              </md-checkbox><br>
            
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.status" ng-change="updateColumns('status', table_columns.status);">
                <?php echo lang('status') ?>
              </md-checkbox><br>
              <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.members" ng-change="updateColumns('members', table_columns.members);">
                <?php echo lang('members') ?>
              </md-checkbox><br>
           <!--    <md-checkbox md-no-ink aria-label="column select" class="md-primary" ng-model="table_columns.actions" ng-change="updateColumns('actions', table_columns.actions);">
                <?php echo lang('actions') ?>
              </md-checkbox><br> -->
          
            </md-contet>
          </md-menu-content>
        </md-menu>
        <md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
          <md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
        </md-button>
        <?php if (check_privilege('projects', 'create')) { ?>
          <md-button ng-click="Create()" class="md-icon-button" aria-label="New" ng-cloak>
            <md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
            <md-icon><i class="ion-android-add-circle text-success"></i></md-icon>
          </md-button>
        <?php } ?>
      </div>
    </md-toolbar>
    <div class="row projectRow">
      <div ng-show="projectLoader" layout-align="center center" class="text-center" id="circular_loader">
        <md-progress-circular md-mode="indeterminate" md-diameter="40"></md-progress-circular>
        <p style="font-size: 15px;margin-bottom: 5%;">
          <span>
            <?php echo lang('please_wait') ?> <br>
            <small><strong><?php echo lang('loading') . ' ' . lang('projects') . '...' ?></strong></small>
          </span>
        </p>
      </div>
      <div ng-show="!projectLoader" id="ciuisprojectcard" style="padding-left: 15px;padding-right: 15px;" ng-cloak>
        <md-table-container ng-show="showList==true" class="bg-white">
          <table md-table md-progress="promise">
            <thead md-head md-order="projects_list.order">
              <tr md-row>
                <th md-column><span>#</span></th>
                <th ng-show="table_columns.name" md-column md-order-by="name"><span><?php echo lang('project'); ?></span></th>
                <th ng-show="table_columns.customer" md-column md-order-by="customer"><span><?php echo lang('customer'); ?></span></th>
                <th ng-show="table_columns.members" md-column><span><?php echo lang('members'); ?></span></th>
                <th ng-show="table_columns.latest_status" md-column><span>Last Status</span></th>
                <th ng-show="table_columns.delivery_date" md-column><span>Date</span></th>
                <th ng-show="table_columns.status" md-column md-order-by="progress"><span><?php echo lang('status'); ?></span></th>

              </tr>
            </thead>
            <tbody md-body>
              <tr class="select_row" md-row ng-repeat="project in projects | orderBy: projects_list.order | limitTo: projects_list.limit : (projects_list.page -1) * projects_list.limit | filter: project_search | filter: FilteredData">
                <td md-cell>
                  <strong>
                    <a class="link" ng-href="<?php echo base_url('/delivery/delivery/') ?>{{project.id}}"> <span ng-bind="project.delivery_number"></span></a>
                  </strong>
                </td>
                <td ng-show="table_columns.name" md-cell class="cursor" ng-click="goToLink('delivery/delivery/'+project.id)">
                  <strong><span class="link" ng-bind="project.name"></span></strong>
                </td>
                <td md-cell ng-show="table_columns.customer">
                  <strong ng-bind="project.customer"></strong><br>
                  <small ng-bind="project.customeremail"></small>
                </td>

              
            

                <td md-cell ng-show="table_columns.members">
                  <div class="bottom-right text-right">
                    <ul class="more-avatar">
                      <li ng-repeat="member in project.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
                        <md-tooltip md-direction="top">{{member.staffname}}</md-tooltip>
                        <div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
                      </li>
                      <div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
                    </ul>
                  </div>
                </td>
                <td md-cell ng-show="table_columns.latest_status">
                  <span ng-bind="project.latest_status"></span>
                </td>
                <td md-cell ng-show="table_columns.delivery_date ">
                  <span ng-show="project.delivery_date != NULL" class="badge" ng-bind="project.delivery_date"></span><br/>
                </td>
                <td md-cell ng-show="table_columns.status">
                <span class="sup-label colorGreenBack" style="background: <?php echo '{{project.status_type}}' ?>;font-size: 12px !important; font-weight: bold; width: 20%;height: 35px;padding: 3px 9px;font-family: Roboto, 'Helvetica Neue', Helvetica, Arial, sans-serif" ng-bind="project.status"></span>
                </td>

              </tr>
            </tbody>
          </table>
        </md-table-container>
        <md-table-pagination ng-show="showList==true" md-limit="projects_list.limit" md-limit-options="limitOptions" md-page="projects_list.page" md-total="{{projects.length}}"></md-table-pagination>
        <div ng-show="showGrid==true" ng-repeat="project in projects | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 6" class="col-md-4 {{project.status_class}}" style="padding-left: 0px;padding-right: 10px;">
          <div id="project-card" class="ciuis-project-card">
            <div class="ciuis-project-content">
              <div class="ciuis-content-header">
                <a href="<?php echo base_url('/projects/project/') ?>{{project.id}}">
                  <div class="pull-left">
                    <p ng-attr-title="{{project.name}}" class="md-m-0" style="font-size: 14px;font-weight: 900;margin: unset;">
                      <span class="blur5" ng-bind="project.project_number"></span>
                      {{ project.name | limitTo: 28 }}{{project.name.length > 30 ? '...' : ''}}
                    </p>
                    <small ng-show="project.template == 1" ng-attr-title="<?php echo lang('template') . ' ' . lang('project') ?>"><?php echo lang('template') . ' ' . lang('project') ?></small>
                    <small ng-show="project.template == 0" ng-attr-title="{{project.customer}}">{{ project.customer | limitTo: 28 }}{{project.customer.length > 30 ? '...' : ''}}</small>
                  </div>
                </a>
                <?php if (check_privilege('projects', 'edit')) { ?>
                  <div class="pull-right md-pr-10" ng-hide="project.status_id == '4' || project.status_id == '5'">
                    <i class="ciuis-project-badge pull-right ion-checkmark-circled text-success" ng-click="markasComplete(project.id)"></i>
                    <md-tooltip md-direction="top"><?php echo lang('markasprojectcomplete') ?></md-tooltip>
                  </div>
                  <div class="pull-right md-pr-10" ng-show="project.template == 1 || project.template == 'true'">
                    <i class="ciuis-project-badge pull-right ion-ios-copy" ng-click="copyProjectDialog(project.id)"></i>
                    <md-tooltip md-direction="top"><?php echo lang('create_new_template_project') ?></md-tooltip>
                  </div>
                  <div class="pull-right md-pr-10">
                    <span>
                      <i ng-click='CheckPinned($index)' class="ciuis-project-badge pull-right ion-pin"></i>
                      <md-tooltip md-direction="top"><?php echo lang('mark_as_pinned') ?></md-tooltip>
                    </span>

                    <img data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{project.status}}" class="pull-right md-mr-5" height="32" ng-src="{{IMAGESURL}}{{project.status_icon}}">
                  </div>
                <?php } ?>
              </div>
              <div class="ciuis-project-dates">
                <div class="ciuis-project-start text-uppercase"><strong><?php echo lang('start'); ?></strong><b ng-bind="project.startdate"></b></div>
                <div class="ciuis-project-end text-uppercase"><strong><?php echo lang('deadline'); ?></strong><b ng-bind="project.leftdays"></b></div>
              </div>
              <div class="ciuis-project-stat col-md-12">
                <div class="col-md-6 bottom-left">
                  <div class="progress-widget">
                    <div class="progress-data text-left"><span ng-hide="project.status_class == 'cancelled'" class="progress-value" ng-bind="project.progress+'%'"></span> <span class="name" ng-bind="project.status"></span> </div>
                    <div ng-hide="project.status_class == 'cancelled'" class="progress" style="height: 7px">
                      <div ng-hide="project.progress == 100" style="width: {{project.progress}}%;" class="progress-bar progress-bar-primary"></div>
                      <div ng-show="project.progress == 100" style="width: {{project.progress}}%;" class="progress-bar progress-bar-success"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 md-p-0 bottom-right text-right">
                  <ul class="more-avatar">
                    <li ng-repeat="member in project.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
                      <md-tooltip md-direction="top">{{member.staffname}}</md-tooltip>
                      <div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
                    </li>
                    <div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <md-content ng-show="!projects.length && !projectLoader" class="md-padding no-item-data" ng-cloak><?php echo lang('notdata') ?></md-content>
    </div>
    <div ng-show="showGrid==true" ng-show="projects.length > 6 && !projectLoader" ng-cloak>
      <div class="pagination-div">
        <ul class="pagination">
          <li ng-class="DisablePrevPage()"> <a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a> </li>
          <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)"> <a href="#" ng-bind="n+1"></a> </li>
          <li ng-class="DisableNextPage()"> <a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a> </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 bg-white">
    <div class="projects-graph">
      <div class="col-md-12" style="padding: 0px;">
        <div class="panel-default">
          <div class="panel-heading panel-heading-divider xs-pb-15 text-bold" style="margin: 0px;"><?php echo lang('delivery') ?>
		  <md-button ng-click="ProjectSettings()" class="md-icon-button pull-right" aria-label="New" ng-cloak>
              <md-icon><i class="ion-gear-a text-muted"></i></md-icon>
          </md-button>
		  </div>
          <div class="panel-body" style="padding: 0px;">
            <div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="project.sumnotstarted"></span> <span class="project-name"><?php echo lang('notsch'); ?></span> </div>
            
                <h4 >{{stats.sumnotstarted}}</h4>
            </div>
            <!--<div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="stats.started_percent+'%'"></span> <span class="project-name"><?php echo lang('schdule'); ?></span> </div>
              <div class="progress" style="height: 5px">
                <div style="width: {{stats.started_percent}}%;" class="progress-bar progress-bar-success"></div>
              </div>
            </div>-->
			      <div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="stats.started_count"></span> <span class="project-name"><?php echo lang('schdule'); ?></span> </div>
              <h4 >{{stats.sumstarted}}</h4>
            </div>
            <div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="stats.hold_count"></span> <span class="project-name"><?php echo lang('hold'); ?></span> </div>
              <h4 >{{stats.sumhold}}</h4>
            </div>
            <div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="stats.cancelled_count"></span> <span class="project-name"><?php echo lang('cancelled'); ?></span> </div>
              <h4 >{{stats.sumcancelled}}</h4>
            </div>
            <div class="project-stats-body pull-left">
              <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="stats.complete_count"></span> <span class="project-name"><?php echo lang('complete'); ?></span> </div>
              <h4 >{{stats.sumcomplete}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 pinnedprojects bg-white">
      <div class="panel-default bg-white">
        <div class="pinned-projects-header bg-white"> <span><i class="ion-pin"></i> <?php echo lang('pinnedprojects'); ?></span> <span class="pull-right hide-pinned-projects"><a data-toggle="collapse" data-parent="#pinned-projects" href="#pinned-projects"><i class="icon mdi ion-minus-circled"></i></a></span> </div>
        <div id="pinned-projects" class="panel-collapse collapse in" ng-cloak>
          <div class="pinned-projects">
            <div ng-repeat="project_pinned in pinnedprojects | filter: { pinned: '1' }" class="pinned-project-widget">
              <div class="pinned-project-body pull-left">
                <div class="project-progress-data"> <span class="project-progress-value pull-right" ng-bind="project_pinned.progress+'%'"></span> <span class="project-name" ng-bind="project_pinned.name"></span> </div>
                <div class="progress" style="height: 5px">
                  <div style="width:{{project_pinned.progress}}%;" class="progress-bar progress-bar-info"></div>
                </div>
              </div>
              <?php if (check_privilege('projects', 'delete')) { ?> 
                <a ng-click='UnPinned(project_pinned.id)' class="pinned-project-action pull-right"><i class="ion-close-round"></i><md-tooltip md-direction="top"><?php echo lang('remove') ?></md-tooltip></a> 
              <?php } ?>
              <a href="<?php echo base_url('projects/project/')?>{{project_pinned.id}}" class="pinned-project-action pull-right"><i class="ion-android-open"></i><md-tooltip md-direction="top"><?php echo lang('go_to_project') ?></md-tooltip></a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Side Nav
 -->  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <h2 flex md-truncate><?php echo lang('create') ?></h2>
      
      </div>
    </md-toolbar>
    <md-content>
      <md-content layout-padding>
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('installation') ?></label>
          <md-select ng-model="delivery.installation" name="delivery" >
            <md-option  ng-value="allstage.id" ng-repeat="allstage in stages">
            <strong ng-bind="allstage.name"></strong><br>
            </md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs ng-hide="delivery.template">
          <md-select required placeholder="<?php echo lang('choiseproject'); ?>" ng-model="delivery.projectname" name="project" style="min-width: 200px;" data-md-container-class="selectdemoSelectHeader">
            <md-select-header class="demo-select-header">
              <label style="display: none;width: 450px;"><?php echo lang('search').' '.lang('delivery')?></label>
              <input ng-submit="search_customers(search_input)" ng-model="search_input" type="text" placeholder="<?php echo lang('search').' '.lang('delivery')?>" class="demo-header-searchbox md-text" ng-keyup="search_customers(search_input)">
            </md-select-header>
            <md-optgroup label="Projects">
              <md-option ng-value="projects.id" ng-repeat="projects in projectname">
                <strong ng-bind="projects.name"></strong><br>
              </md-option>
            </md-optgroup>            
          </md-select>
        </md-input-container>
  
        <md-input-container class="md-block">
          <label>Date</label>
          <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="delivery.delivery_date" class=" dtp-no-msclear dtp-input md-input">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('description') ?></label><br>
          <input type="text" id="location" class="form-control text-left" placeholder="" <?php echo lang('description'); ?>  ng-model="delivery.description">
        </md-input-container>
        <md-switch ng-model="NeedShippingAddress" aria-label="Status"><strong class="text-muted"><?php echo lang('need_shipping_address') ?></strong></md-switch>
        <md-subheader ng-show='NeedShippingAddress == true' class="md-primary bg-white text-uppercase text-bold"><?php echo lang('shipping_address') ?></md-subheader>
        <md-content  ng-show='NeedShippingAddress == true' layout-padding class="bg-white" ng-cloak>
        <md-input-container class="md-block">
          <label><?php echo lang('address') ?></label>
          <textarea ng-model="delivery.address" md-maxlength="500" rows="2" md-select-on-focus></textarea>
        </md-input-container>
        <md-input-container class="md-block">
        <md-select placeholder="<?php echo lang('country'); ?>" ng-model="delivery.shipping_country_id"  ng-change="getShippingStates(delivery.shipping_country_id)" name="shipping_country" style="min-width: 200px;">
            <md-option ng-value="{{country.id}}" ng-repeat="country in countries">{{country.shortname}}</md-option>
          </md-select>
          <br />
        </md-input-container>        
        <md-input-container class="md-block">
          <md-select placeholder="<?php echo lang('state'); ?>" ng-model="delivery.shipping_state_id" name="shipping_state_id" style="min-width: 200px;">
            <md-option ng-value="state.id" ng-repeat="state in shippingStates">{{state.state_name}}</md-option>
          </md-select>
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('city'); ?></label>
          <input name="city" ng-model="delivery.shipping_city">
        </md-input-container>
        <md-input-container class="md-block">
          <label><?php echo lang('zipcode'); ?></label>
          <input name="zipcode" ng-model="delivery.shipping_zip">
        </md-input-container>
        <md-input-container class="md-block">
          <label>Contact Name</label>
          <input name="zipcode" ng-model="delivery.contact_name">
        </md-input-container>
        <md-input-container class="md-block">
          <label>Contact number</label>
          <input name="zipcode" ng-model="delivery.contact_number">
        </md-input-container>
        <bind-expression ng-init="delivery.shipping_country = '----'" expression="delivery.shipping_country" ng-model="delivery.shipping_country" />
      </md-content>
      <md-content layout-padding>
        <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
          <md-button ng-click="CreateNew()" class="md-raised md-primary btn-report block-button" ng-disabled="saving == true">
            <span ng-hide="saving == true"><?php echo lang('create'); ?></span>
            <md-progress-circular class="white" ng-show="saving == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          </md-button>
          <br /><br /><br /><br />
        </section>
      </md-content>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="CreateGroup" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
        <md-truncate><?php echo lang('groups') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content>
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <h4 class="text-bold text-muted" flex><?php echo lang('customer') . ' ' . lang('groups') ?></h4>
          <?php if (check_privilege('customers', 'create')) { ?> 
            <md-button aria-label="Add Status" class="md-icon-button" ng-click="NewGroup()">
              <md-tooltip md-direction="bottom"><?php echo lang('add') . ' ' . lang('customer') . ' ' . lang('group') ?>
            </md-tooltip>
            <md-icon><i class="ion-plus-round text-success"></i></md-icon>
          </md-button>
        <?php } ?>
        </div>
      </md-toolbar>
      <md-list-item ng-repeat="name in group" class="noright" ng-click="EditGroup(name.id,name.name, $event)" aria-label="Edit Status"> <strong ng-bind="name.name"></strong>
        <?php if (check_privilege('customers', 'edit')) { ?> 
          <md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit group"></md-icon>
        <?php } if (check_privilege('customers', 'delete')) { ?> 
          <md-icon ng-click='DeleteCustomerGroup($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b"></md-icon>
        <?php } ?>
      </md-list-item>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp projects-filter" md-component-id="ContentFilter" ng-cloak style="width: 450px;">
    <md-toolbar class="md-theme-light" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
        <md-truncate><?php echo lang('filter') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content layout-padding="">
      <div ng-repeat="(prop, ignoredValue) in projects[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'name' && prop != 'leftdays' && prop != 'members' && prop != 'milestones' && prop != 'pinned' && prop != 'progress' && prop != 'project_id' && prop != 'startdate' && prop != 'status_icon' && prop != 'status_id' && prop != 'tax' && prop != 'template' && prop != 'value' && prop!='customer' && prop!='status' && prop!='status_class' && prop!='customer_id' && prop!='<?php echo lang('filterbycustomer') ?>' && prop != 'project_number' && prop != 'customeremail'">
        <div class="filter col-md-12">
          <h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
          <hr>
          <div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop=='<?php echo lang('filterbystatus') ?>'">
            <md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
          </div>
        </div>
      </div>
    </md-content>
  </md-sidenav>
  <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ProjectSettings" ng-cloak style="width: 450px;">
    <md-toolbar class="toolbar-white" style="background:#262626">
      <div class="md-toolbar-tools">
        <md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
        <md-truncate><?php echo lang('stage') ?></md-truncate>
      </div>
    </md-toolbar>
    <md-content>
      <md-toolbar class="toolbar-white" style="background:#262626">
        <div class="md-toolbar-tools">
          <h4 class="text-bold text-muted" flex><?php echo lang('projectstage') ?></h4>
          <?php if (check_privilege('projects', 'create')) { ?>
            <md-button aria-label="Add Installation" class="md-icon-button" ng-click="NewInstallation()">
              <md-tooltip md-direction="bottom"><?php echo lang('add') . ' ' . lang('projectstage') ?>
              </md-tooltip>
              <md-icon><i class="ion-plus-round text-success"></i></md-icon>
            </md-button>
          <?php } ?>
        </div>
      </md-toolbar>
      <md-list-item ng-repeat="name in stages" class="noright" ng-click="EditProjectStage(name.id,name.name, $event)" aria-label="Edit Stage"> <strong ng-bind="name.name"></strong>
        <?php if (check_privilege('projects', 'edit')) { ?>
          <md-icon class="md-secondary md-hue-3 ion-compose " aria-hidden="Edit Stage"></md-icon>
        <?php }
        if (check_privilege('projects', 'delete')) { ?>
          <md-icon ng-click='DeleteProjectStage($index)' aria-label="Remove Stage" class="md-secondary md-hue-3 ion-trash-b"></md-icon>
        <?php } ?>
      </md-list-item>
    </md-content>
  </md-sidenav>
</div>
<script type="text/ng-template" id="copyProjectDialog.html">
  <md-dialog aria-label="Expense Detail">
      <md-toolbar class="toolbar-white">
        <div class="md-toolbar-tools">
          <h2><strong class=""><?php echo lang('create_new_template_project') ?></strong></h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="close()">
            <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content style="max-width:800px;max-height:810px;">
        <md-content class="bg-white">
          <md-list flex>
            <md-list-item>
              <div class="ciuis-custom-list-item-item col-md-12">
                <p><?php echo lang('eventtype') ?></p>
                <md-input-container class="md-block" flex-gt-xs>
                  <md-checkbox ng-model="copy.service" ng-value="true" ng-checked="true">
                    <?php echo lang('installation') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.expenses" ng-value="true" ng-checked="false">
                    <?php echo lang('location') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.milestones" ng-value="true" ng-checked="copy.tasks">
                    <?php echo lang('eventstage') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.tasks" ng-value="true" ng-checked="copy.milestones">
                    <?php echo lang('removal') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.peoples" ng-value="true" ng-checked="true">
                    <?php echo lang('sitesurvey') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.files" ng-value="true" ng-checked="true">
                    <?php echo lang('delivery') ?>
                  </md-checkbox><br>
                  <md-checkbox ng-model="copy.notes" ng-value="true" ng-checked="false">
                    <?php echo lang('collection') ?>
                  </md-checkbox>
                  <md-checkbox ng-model="copy.notes" ng-value="true" ng-checked="false">
                    <?php echo lang('removal&disposal') ?>
                  </md-checkbox>
                </md-input-container>
                <div class="row">
                  <div class="col-md-6 md-block">
                    <md-input-container class="md-block" flex-gt-xs>
                      <label><?php echo lang('customer'); ?></label>
                      <md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="copy.customer" name="customer" style="min-width: 200px;">
                        <md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
                      </md-select>
                    </md-input-container>
                  </div>
                  <div class="col-md-6 md-block">
                  </div>
                </div>
                <md-input-container>
                  <label><?php echo lang('startdate') ?></label>
                  <md-datepicker name="start" ng-model="copy.start" md-open-on-focus></md-datepicker>
                </md-input-container>
                <md-input-container>
                  <label><?php echo lang('deadline') ?></label>
                  <md-datepicker name="deadline" ng-model="copy.end" md-open-on-focus></md-datepicker>
                </md-input-container>
              </div>
            </md-list-item>
          </md-list>
        </md-content>     
      </md-dialog-content>
      <md-dialog-actions>
        <span flex></span>
        <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
        <md-button ng-click="copyProjectConfirm()"><?php echo lang('doIt') ?></md-button>
      </md-dialog-actions>
    </md-dialog>
  </script>
<script type="text/ng-template" id="processing.html">
  <md-dialog id="updating" style="box-shadow:none;padding:unset;min-width: 25%;">
      <md-dialog-content layout-padding layout-align="center center" aria-label="wait" style="text-align: center;">
        <md-progress-circular md-mode="indeterminate" md-diameter="40" style="margin-left: auto;margin-right: auto;"></md-progress-circular>
        <span style="font-size: 15px;"><strong><?php echo lang('processing'); ?></strong></span>
        <div class="row">
          <div class="col-md-12">
            <p style="opacity: 0.7;"><br><?php echo lang('update_note'); ?></p>
          </div>
        </div>
      </md-dialog-content>
    </md-dialog>
  </script>
<script type="text/javascript">
  var lang = {};
  lang.doIt = '<?php echo lang("doIt") ?>';
  lang.project_complete_note = '<?php echo lang("project_complete_note") ?>';
  lang.attention = '<?php echo lang("attention") ?>';
  lang.cancel = '<?php echo lang("cancel") ?>';
</script>
<?php include_once(APPPATH . 'views/inc/other_footer.php'); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/delivery.js') ?>"></script>