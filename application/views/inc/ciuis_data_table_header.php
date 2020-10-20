<?php $rebrand = load_config();
$appconfig = get_appconfig();
$menus = get_menu();
$leftmenus = get_leftmenu();
$user_data = get_user(); 
$app_logo = base_url('uploads/ciuis_settings/'.$user_data['settings']['logo']);
$app_logo_alternate = base_url('assets/img/placeholder.png');
$notiicon = base_url('assets/img/notiicon.png');
$notiicon_image = base_url('uploads/images/'.$user_data['avatar']);
$user_image_alternate = base_url('uploads/images/n-img.jpg');
?>
<!DOCTYPE html>
<html ng-app="Ciuis" lang="<?php echo lang('lang_code');?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $rebrand['meta_description'] ?>">
    <meta name="keywords" content="<?php echo $rebrand['meta_keywords'] ?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/images/' . $rebrand['favicon_icon'] . ''); ?>">
    <title><?php echo $title; ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css" /> 
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom_css.css'); ?>" type="text/css" />
	
	<!--<script data-require="jquery@1.11.0" data-semver="1.11.0" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	
    <script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
    
	<script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
    
	<script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
    
	<script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_' . lang('lang_code_dash') . '.js'); ?>">
    </script>
	
	<!--<script data-require="select2@3.5.1" data-semver="3.5.1" src="//cdn.jsdelivr.net/select2/3.4.8/select2.min.js"></script>-->
	
	<script data-require="angular-ui@0.4.0" data-semver="0.4.0" src="http://rawgithub.com/angular-ui/angular-ui/master/build/angular-ui.js"></script>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/data-table/md-data-table.min.css'); ?>">
	
	
    <script>
    var BASE_URL = "<?php echo base_url(); ?>",
        update_error = "<?php echo lang('update_error'); ?>",
        email_error = "<?php echo lang('email_error'); ?>",
        ACTIVESTAFF = "<?php echo $this->session->userdata('usr_id'); ?>",
        SHOW_ONLY_ADMIN = "<?php if (!if_admin) {echo 'true';} else echo 'false';?>",
        CURRENCY = "<?php echo currency ?>",
        LOCATE_SELECTED = "<?php echo lang('lang_code');?>",
        UPIMGURL = "<?php echo base_url('uploads/images/'); ?>",
        NTFTITLE = "<?php echo lang('notification')?>",
        INVMARKCACELLED = "<?php echo lang('invoicecancelled')?>",
        TICKSTATUSCHANGE = "<?php echo lang('ticketstatuschanced')?>",
        LEADMARKEDAS = "<?php echo lang('leadmarkedas')?>",
        LEADUNMARKEDAS = "<?php echo lang('leadunmarkedas')?>",
        TODAYDATE = "<?php echo date('Y.m.d ')?>",
        LOGGEDINSTAFFID = "<?php echo $this->session->userdata('usr_id'); ?>",
        LOGGEDINSTAFFNAME = "<?php echo $this->session->userdata('staffname'); ?>",
        LOGGEDINSTAFFAVATAR = "<?php echo $this->session->userdata('staffavatar'); ?>",
        VOICENOTIFICATIONLANG = "<?php echo lang('lang_code_dash');?>",
        initialLocaleCode = "<?php echo lang('initial_locale_code');?>";
    var new_item = "<?php echo lang('new'); ?>";
    var item_unit = "<?php echo lang('unit'); ?>";
    </script>
	<style>
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  
  -moz-border-radius: 4px;
  border:1px solid #ddd;

  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
  height:100%;
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #3a4151;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #3a4151;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

/*header#mainHeader {
    width: 280px;
	
	}
	
	.main-content {
    padding: 0px 10px 0px 216px;
}
.toolbar-ciuis-top{
padding-left: 278px;
}*/
.nav-side-menu {
  overflow: auto;
  font-family: verdana;
  font-size: 12px;
  font-weight: 200;
  background-color: #2e353d;
  position: fixed;
  top: 0px;
  width: 207px;
  height: 100%;
  color: #e1ffff;
  left:66px;
}
.nav-side-menu .brand {
  background-color: #23282e;
  line-height: 50px;
  display: block;
  text-align: center;
  font-size: 14px;
}
.nav-side-menu .toggle-btn {
  display: none;
}
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  /*    
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  font-family: FontAwesome;
  content: "\f105";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
}
.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
}
body {
  margin: 0px;
  padding: 0px;
}

.num {
  position: absolute;
  right: 11px;
  top: 6px;
  color: #fff;
}
.notification-counter {   
    position: absolute;
    top: -2px;
    left: 12px;
    background-color: rgba(212, 19, 13, 1);
    color: #fff;
    border-radius: 3px;
    padding: 1px 3px;
    font: 8px Verdana;
}
.notification-container {
    position: relative;
    width: 16px;
    height: 16px;
    top: 15px;
    left: 15px;
}
</style>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis();
?>
<body ng-controller="Ciuis_Controller">
    <?php if ($rebrand['disable_preloader'] == '0') { 
        $preloader =  base_url('assets/img/'.$rebrand['preloader']); ?>
        <div id="ciuisloader" style="background-image: url(<?php echo $preloader ?>);"></div>
    <?php } ?>
    <md-toolbar class="toolbar-ciuis-top">
        <div class="md-toolbar-tools">
            <!-- CRM NAME -->
            <div md-truncate class="crm-name crm-nm"><span><?php echo $user_data['settings']['crm_name'] ?></span></div>
            <md-button ng-click="OpenMenu()" class="md-icon-button hidden-lg hidden-md" aria-label="Menu">
                <md-icon><i class="ion-navicon-round text-muted"></i></md-icon>
            </md-button> 
            <!-- CRM NAME -->
            <!-- NAVBAR MENU -->
            <ul flex class="ciuis-v3-menu hidden-xs">
                <?php
                foreach ($menus as $menu) { 
				?>
                    <?php if ($menu['url'] != '#' || sizeof($menu['sub_menu']) > 0) { ?>
					
                        <li><?php if($menu['id']=='27'){
							if ( $this->Privileges_Model->has_privilege( 'mrequests' ) ) {
									$url=base_url().'mrequests';
								}else if ( $this->Privileges_Model->has_privilege( 'leaverequests' ) ) {
									$url=base_url().'leaverequests';
								}else if ( $this->Privileges_Model->has_privilege( 'billrequests' ) ) {
									$url=base_url().'billrequests';
								}else if ( $this->Privileges_Model->has_privilege( 'salaryrequests' ) ) {
									$url=base_url().'salaryrequests';
								}
							?>
							<a href="<?php echo $url;?>"><?php echo $menu['name'] ?></a>
						
					<?php }else{?><a href="<?php echo $menu['url'] ?>"><?php echo $menu['name'] ?></a>
					<?php }?>
                            <?php if (sizeof($menu['sub_menu']) > 0 && $menu['id']!='27') { ?>
                                <ul>
                                    <?php foreach ($menu['sub_menu'] as $submenu) { ?>
                                        <li><a href="<?php echo $submenu['url'] ?>"> <i class="icon <?php echo $submenu['icon'] ?>"></i> <span class="title"><?php echo $submenu['name'] ?></span> <span class="descr"><?php echo $submenu['description'] ?></span> </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <!-- NAVBAR MENU -->
            <md-button class="md-icon-button" ng-click="searchNav()" aria-label="search" ng-cloak>
                <md-tooltip md-direction="left" ng-bind='lang.search'></md-tooltip>
                <md-icon><i class="ion-search text-muted" style="color:darkmagenta;"></i></md-icon>
            </md-button>
            <?php if (!$this->session->userdata('other')) { ?>
             <div class="dropdown-container timer" ng-cloak>
                                    <a href="<?php echo base_url(); ?>/tickets"><md-tooltip md-direction="left" ng-bind='lang.tasks'></md-tooltip>
                        <md-icon>
                            <i class="ion-ios-clock text-muted" id="timerStart" ng-hide="settings.timers == true || settings.timers == 'true'" style="color:crimson;"></i>
                            <i id="timerStarted" ng-show="settings.timers==true || settings.timers=='true'" class="ion-ios-clock text-success"></i>
                        </md-icon></a>
                    
                </div>
                
            <?php } ?>
            <md-button class="md-icon-button" aria-label="User Profile" ng-cloak  ng-click="EstNotifications();get_estnotifications();" > 

                <img height="100%" src="<?php echo $notiicon ?>" class="md-avatar" style="max-height: 36px;height: 100%;max-width: 40px;" onerror="this.onerror=null; this.src='<?php echo $notiicon ?>'"> 
                <span class="notification-counter" style="margin-top: 10;">2</span>
            </md-button>
            <md-button ng-hide="ONLYADMIN != 'true'" class="md-icon-button" ng-href="{{appurl + 'settings'}}" aria-label="Settings" ng-cloak>
                <md-tooltip md-direction="left" ng-bind='lang.settings'></md-tooltip>
                <md-icon><i class="ion-gear-a text-muted"  style="color:crimson;"></i></md-icon>
            </md-button>
            <md-button ng-click="Todo();get_todo()" class="md-icon-button" aria-label="Todo" ng-cloak>
                <md-tooltip md-direction="left" ng-bind='lang.todo'></md-tooltip>
                <md-icon><i class="ion-clipboard text-muted" style="color:darkcyan;"></i></md-icon>
            </md-button>
            <md-button ng-click="Notifications();get_notifications()" class="md-icon-button" aria-label="Notifications" ng-cloak>
                <md-tooltip md-direction="left" ng-bind='lang.notifications'></md-tooltip>
                <div ng-show="settings.newnotification == true" class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                <md-icon><i class="ion-ios-bell text-muted" style="color:darkgreen;"></i></md-icon>
            </md-button>
            <md-button ng-click="Profile();get_meetings();get_appointments();" class="md-icon-button avatar-button-ciuis" aria-label="User Profile" ng-cloak> 
                <img height="100%" src="<?php echo $user_image ?>" class="md-avatar" style="max-height: 36px;height: 100%;max-width: 40px;" onerror="this.onerror=null; this.src='<?php echo $user_image_alternate ?>'"> 
            </md-button>
            <div ng-click="Profile();get_meetings();get_appointments();" md-truncate class="user-informations hidden-xs" ng-cloak> <span class="user-name-in"><?php echo $user_data['name'] ?></span><br>
                <span class="user-email-in"><?php echo $user_data['email'] ?></span> 
            </div>
        </div>
    </md-toolbar>
    <md-content id="mobile-menu" class="" style="left: 0px; opacity: 1; display: none">
        <md-toolbar class="toolbar-white">
            <div class="md-toolbar-tools">
                <div flex md-truncate class="crm-name"><span ng-bind="settings.crm_name"></span></div>
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close">
                    <md-icon><i class="ion-close-circled text-muted"></i></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-content class="mobile-menu-box bg-white">
            <div class="mobile-menu-wrapper-inner">
                <div class="mobile-menu-wrapper">
                    <div class="mobile-menu-slider" style="left: 0px;">
                        <div class="mobile-menu">
                            <?php foreach ($menus as $menu) { ?>
                                <span>
                                <?php if($menu['url'] != '#') {?>
                                    <ul>
                                        <li class="nav-item">
                                            <div class="mobile-menu-item"><a href="<?php $menu['url'] ?>"><?php echo $menu['name'] ?></a>
                                            </div>
                                        </li>
                                    </ul>
                                <?php }?>
                                    <ul>
                                        <?php foreach ($menu['sub_menu'] as $submenu) { ?>
                                            <li class="nav-item">
                                                <div class="mobile-menu-item"><a href="<?php echo $submenu['url'] ?>"><?php echo $submenu['name'] ?></a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </span>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </md-content>
    </md-content>
	
    <header id="mainHeader" role="banner" class="hidden-xs">
	 <div class="top-header">
                <div class="navBurger"><a href="{{appurl + 'panel'}}">
                    <img class="transform_logo" width="34px" src="<?php echo $app_logo ?>" height="34px" onerror="this.onerror=null; this.src='<?php echo $app_logo_alternate ?>'">
                </a>
                </div>
            </div>
        <div class="col-lg-12 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
            <div class="col-lg-12 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group" style="display:none">
                  <a href="#" class="list-group-item  text-center " data-id="4">
                 <i class="fa fa-address-book" ></i><br><span>Reception</span>
                </a>
			  <a href="#" class="list-group-item  text-center " data-id="1">
                <i class="fa fa-user" ></i><br><span>HR</span>
                </a>
				<a href="#" class="list-group-item  text-center " data-id="2">
                 <i class="fa fa-money" ></i><br><span>Request</span>
                </a>
				<a href="#" class="list-group-item  text-center " data-id="3">
                 <i class="fa fa-tasks" ></i><br><span>Tasks</span>
                </a>
                
                <a href="#" class="list-group-item  text-center " data-id="5">
                 <i class="fa fa-cart-arrow-down" ></i><br><span>Purchase</span>
                </a>
                <a href="#" class="list-group-item  text-center " data-id="6">
                 <i class="fa fa-industry" ></i><br><span>Sales</span>
                </a>
                <a href="#" class="list-group-item  text-center " data-id="7">
                 <i class="fa fa-cart-arrow-down" ></i><br><span>Estimation</span>
                </a>
			   <?php /*$t=0;foreach ($menus as $menu) { echo $menu['icon'];?>
                    <?php if ($menu['url'] != '#' || sizeof($menu['sub_menu']) > 0) {?>
					<a href="#" class="list-group-item  text-center <?php if($t==0){print "";}?>" data-id="<?php print $t;?>">
                 <i class="icon <?php echo $menu['icon'] ?>"></i><br/><?php echo $menu['name'] ?>
                </a>
                        
                    <?php $t++;} ?>
                <?php }*/ ?>
                
               
              </div>
            </div>
			
            <div class="bhoechie-tab">
                <div class="bhoechie-tab-content " id="submenu4">
			<div class="nav-side-menu" >
    <div class="brand">Contacts <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('4')"></i></span></div>
    <i class="fa fa-address-card  fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('contacts'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Contacts</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('notebooks'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Note Books</span><br></a></li>
					<li><a href="<?php echo base_url('document'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Documents</span><br>  </a>
			</li>
		
			
            </ul>
     </div>
</div>
			</div>
			
			<div class="bhoechie-tab-content " id="submenu1">
			<div class="nav-side-menu" >
    <div class="brand">HR <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('1')"></i></span></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('staff'); ?>"> <i class="fa fa-users"></i> <span class="title">Staff</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('attendance'); ?>"> <i class="fa fa-address-book-o"></i> <span class="title">Attendance</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('workshift'); ?>"> <i class="fa fa-address-book-o"></i> <span class="title">Workshift</span><br>  </a>
			</li>
		<!--	<li><a href="<?php //echo base_url('report'); ?>"> <i class="fa fa-file" aria-hidden="true"></i> <span class="title">Reports</span><br>  </a>
			</li>
			<li><a href="<?php //echo base_url('calendar'); ?>"> <i class="fa fa-calendar" aria-hidden="true"></i> <span class="title">Calender</span><br>  </a> -->
			</li>
			<li><a href="<?php echo base_url('recruitment'); ?>"><i class="fa fa-users"></i><span class="title">Recruitment</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('interview'); ?>"><i class="fa fa-question-circle-o"></i><span class="title">Interview</span><br>  </a>
			</li>
            <li><a href="<?php echo base_url('payroll'); ?>"><i class="icon ion-cash"></i><span class="title">Payroll</span><br>  </a>
			</li>
            </ul>
     </div>
</div>
			</div>
			
			<div class="bhoechie-tab-content " id="submenu2">
			<div class="nav-side-menu" >
    <div class="brand">Request <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('2')"></i></span></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('requests'); ?>"> <i class="icon glyphicon glyphicon-indent-left"></i><span class="title">Material Request</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('leaverequests'); ?>"> <i class="icon glyphicon glyphicon-pencil"></i> <span class="title">Leave Request</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('billrequests'); ?>"> <i class="icon ion-cash"></i> <span class="title">Bill Request</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('salaryrequests'); ?>"> <i class="icon ion-cash"></i> <span class="title">Salary Request</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('otherrequests'); ?>"><i class="icon ion-pull-request"></i><span class="title">Other Request</span>  </a>
			</li>
			
            </ul>
     </div>
</div>
			</div>
			
			
			
			<div class="bhoechie-tab-content " id="submenu3">
			<div class="nav-side-menu" >
    <div class="brand">Tasks <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('3')"></i></span></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('tasks'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Tasks</span><br>  </a>
			</li>
		
			
            </ul>
     </div>
</div>
			</div>
			
			
			<div class="bhoechie-tab-content " id="submenu5">
			<div class="nav-side-menu" >
    <div class="brand">Contacts <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('5')"></i></span></div>
    <i class="fa fa-cart-plus  fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('supplier'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Suplliers</span><br>  </a>
			</li>
		
			
            </ul>
     </div>
</div>
			</div>
			<div class="bhoechie-tab-content " id="submenu6">
			<div class="nav-side-menu" >
    <div class="brand">Contacts <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('6')"></i></span></div>
    <i class="fa fa-address-card  fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('client'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Clients</span><br>  </a>
			</li>
		
			
            </ul>
     </div>
</div>
			</div>
			<div class="bhoechie-tab-content " id="submenu7">
			<div class="nav-side-menu" >
    <div class="brand">Estimations <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('7')"></i></span></div>
    <i class="fa fa-address-card  fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo base_url('material'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Material</span><br>  </a>
			</li>
			<li><a href="<?php echo base_url('estimations'); ?>"><i class="icon ico-ciuis-tasks"></i> <span class="title">Estimations</span><br>  </a>
			</li>

			
            </ul>
     </div>
</div>
			</div>
                <!-- flight section -->
				<?php /*$m=0;foreach ($menus as $menu) { ?>
				
                    <?php if ($menu['url'] != '#' || sizeof($menu['sub_menu']) > 0) {?>
					<div class="bhoechie-tab-content <?php if($m==0){print "";}?>" id="submenu<?php print $m;?>">
					<?php if (sizeof($menu['sub_menu']) > 0) {
						?>
                
<div class="nav-side-menu" >
    <div class="brand"><?php echo $menu['name'] ?> <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('<?php print $m;?>')"></i></span></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
			<?php foreach ($menu['sub_menu'] as $submenu) {?>
                 <li><a href="<?php echo $submenu['url'] ?>"> <i class="icon <?php echo $submenu['icon'] ?>"></i> <span class="title"><?php echo $submenu['name'] ?></span><br> <span class="descr"><?php echo $submenu['description'] ?></span> </a>
                                        </li>
			<?php }?>
               
            </ul>
     </div>
</div><!--
                    <center>
                      
                      <li><a href="<?php echo $submenu['url'] ?>"> <i class="icon <?php echo $submenu['icon'] ?>"></i> <span class="title"><?php echo $submenu['name'] ?></span><br> <span class="descr"><?php echo $submenu['description'] ?></span> </a>
                                        </li>
                    </center>-->
                
<?php }else{?><div class="nav-side-menu" >
    <div class="brand"><?php echo $menu['name'] ?> <span style="float: right;
    padding-right: 20px;"><i class="ion-close-circled text-muted" onclick="closesubmenu('<?php print $m;?>')"></i></span></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
		
               
            </ul>
     </div>
</div><?php }?></div>
				<?php $m++;}}*/?>
            </div>
        </div>
  
        
    </header>

    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="taskTimer" ng-cloak style="width: 450px;">
        <md-toolbar class="md-theme-light" style="background:#262626">
            <div class="md-toolbar-tools">
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
                <md-truncate flex><?php echo lang('task') . ' ' . lang('timer') ?></md-truncate>
                <div class="task-timer">
                    <md-button class="task-timer md-icon-button">
                    <md-progress-circular ng-show="startingTimer == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                        <md-icon ng-hide="startingTimer ==true">
                            <md-tooltip md-direction="left" ng-bind='lang.start_timer'></md-tooltip>
                            <i class="ion-ios-play" ng-click="startTimer('start')"></i>
                        </md-icon>
                    </md-button>
                </div>
            </div>
        </md-toolbar>
        <md-content>
            <md-content>
                <md-progress-circular ng-if="timers.loading" class="" md-mode="indeterminate" md-diameter="25">
                </md-progress-circular>
                <ul class="" style="padding: unset;">
                    <li class="" ng-repeat="time in timers">
                        <div layout="row" layout-wrap class="timer-section">
                            <div flex-gt-xs="60" flex-xs="60">
                                <span ng-show="time.task_id"><?php echo lang('task') ?>: </span> <a ng-show="time.task_id" href="{{appurl + 'tasks/task/' + time.task_id}}" class="assigned"><strong ng-bind="time.task"></strong></a>
                                <a ng-show="!time.task_id" class="label label-info assign" ng-click="stopTimerWithTask('assign',time.id)"><?php echo lang('assign_task') ?>
                                    &nbsp;&nbsp;<i class="ion-compose"></i></a>
                                <br>
                                <span class="text-muted"><?php echo lang('started_at') ?>: {{time.started}}</span>
                            </div>
                            <div class="text-right" flex-gt-xs="40" flex-xs="40" layout="row">
                                <div class="text-right" flex-gt-xs="90" flex-xs="90">
                                    <span class="totalTime" id="totalTime{{time.id}}"></span>
                                    <div style="display: inline-flex;">
                                        <md-icon>
                                            <md-tooltip md-direction="top" ng-bind='lang.stop_timer'></md-tooltip>
                                            <i class="ion-ios-pause" ng-click="startTimer('stop', time.id)"></i>
                                            <md-tooltip md-direction="top" ng-bind='lang.stop_timer'></md-tooltip>
                                        </md-icon>
                                    </div>
                                </div>
                                <div class="text-right" flex-gt-xs="10" flex-xs="10">
                                    <div>
                                        <md-button class="md-icon-button timer-menu" ng-click="DeleteMenuTimer(time.id)" aria-label="Delete">
                                            <md-icon><i class="ion-trash-b text-muted"></i></md-icon>
                                        </md-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <p ng-show="!timers.length" class="not-found"><?php echo lang('not_found') ?></p>
                </ul>
            </md-content>
        </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-left md-whiteframe-4dp" md-component-id="PickUpTo" ng-cloak style="width: 450px;"></md-sidenav>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="SetOnsiteVisit" ng-cloak style="width: 450px;">
        <md-toolbar class="md-theme-light" style="background:#262626">
            <div class="md-toolbar-tools">
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i></md-button>
                <md-truncate ng-bind='lang.set_onsite_visit'></md-truncate>
            </div>
        </md-toolbar>
        <md-content layout-padding="">
            <md-content layout-padding>
                <md-input-container class="md-block">
                    <label ng-bind='lang.title'></label>
                    <input ng-model="onsite_visit.title">
                </md-input-container>
                <md-input-container class="md-block" flex-gt-xs>
                    <label ng-bind='lang.customer'></label>
                    <md-select required placeholder="{{lang.choisecustomer}}" ng-model="onsite_visit.customer_id" style="min-width: 200px;" aria-label='Customer'>
                        <md-option ng-repeat="customer in all_customers" ng-value="customer.id">{{customer.name}}
                        </md-option>
                    </md-select>
                </md-input-container>
                <md-input-container class="md-block">
                    <label ng-bind='lang.assigned'></label>
                    <md-select placeholder="{{lang.choosestaff}}" ng-model="onsite_visit.staff_id" style="min-width: 200px;" aria-label='Staff'>
                        <md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
                    </md-select>
                </md-input-container>
                <br>
                <md-input-container class="md-block">
                    <label ng-bind='lang.start'></label>
                    <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="{{lang.chooseadate}}" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="onsite_visit.start" class=" dtp-no-msclear dtp-input md-input">
                </md-input-container>
                <md-input-container class="md-block">
                    <label ng-bind='lang.end'></label>
                    <input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="{{lang.chooseadate}}" show-todays-date="" minutes="true" min-date="onsite_visit.start" show-icon="true" ng-model="onsite_visit.end" class=" dtp-no-msclear dtp-input md-input">
                </md-input-container>
                <md-input-container class="md-block">
                    <label ng-bind='lang.description'></label>
                    <textarea required ng-model="onsite_visit.description" placeholder="<?php echo lang('typeSomething'); ?>" class="form-control note-description"></textarea>
                </md-input-container>
                <div class="pull-right">
                    <md-button ng-click="AddOnsiteVisit()" class="md-raised md-primary md-button md-ink-ripple" ng-disabled="addingOnsite == true" aria-label='Add Onsite Visit'>
                        <span ng-hide="addingOnsite == true"><?php echo lang('set'); ?></span>
                        <md-progress-circular class="white" ng-show="addingOnsite == true" md-mode="indeterminate" md-diameter="20">
                        </md-progress-circular>
                    </md-button>
                </div>
            </md-content>
        </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-right md-whiteframe-5dp" md-component-id="searchNav" ng-cloak style="width: 450px;" md-disable-close-events style="width: 650px;" ng-cloak>
        <md-toolbar class="md-theme-light" style="background:#262626">
            <div class="md-toolbar-tools">
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i></md-button>
                <md-truncate ng-bind='lang.search'></md-truncate>
            </div>
        </md-toolbar>
        <md-content><br>
            <md-input-container ng-submit="searchInput(search_input)" class="md-block" style="margin-bottom: unset;">
                <label><?php echo lang('searchhere'); ?></label>
                <input ng-submit="searchInput(search_input)" name="search" ng-model="search_input" ng-keyup="searchInput(search_input)">
            </md-input-container>
            <p class="text-center text-muted" ng-show="searchResult == 1"><?php echo lang('not_found'); ?></p>
            <p class="text-center text-muted" ng-show="searchInputMsg == 1"><?php echo lang('type_something'); ?></p>
            <div ng-show="searchLoader == 1">
                <md-progress-circular md-mode="indeterminate" md-diameter="20" style="margin-left: auto;margin-right: auto;">
                </md-progress-circular>
                <p class="text-center">
                    <strong><?php echo lang('searching'); ?></strong>
                </p>
            </div>
            <section ng-show="searchStaff.length > 0">
                <md-subheader class="md-accent"><span class="material-icons ico-ciuis-staff search-icon pull-right"></span>
                    <?php echo lang('staff_members'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="staff in searchStaff">
                        <a href="{{appurl + 'staff/staffmember/' + staff.staff_id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='staff.staff_number?("<?php echo '{{staff.staff_number}}' ?>") : ("<?php echo $appconfig['staff_prefix'] . '' . '{{staff.staff_id}}' ?>")'>
                                    </span>
                                    <span ng-bind='staff.name?("<?php echo '{{staff.name | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('email'); ?>:</strong>
                                    {{ staff.email | limitTo: 30 }}{{staff.email.length > 30 ? '...' : ''}}
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchProjects.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-projects search-icon pull-right"></span>
                    <?php echo lang('projects'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="project in searchProjects">
                        <a href="{{appurl + 'projects/project/' + project.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='project.project_number?("<?php echo '{{project.project_number}}' ?>") : ("<?php echo $appconfig['project_prefix'] . '' . '{{project.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='project.name?("<?php echo '{{project.name | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('status'); ?>:</strong>
                                    <span ng-switch="project.status">
                                        <span ng-switch-when="1"><?php echo lang( 'notstarted' ); ?></span>
                                        <span ng-switch-when="2"><?php echo lang( 'started' ); ?></span>
                                        <span ng-switch-when="3"><?php echo lang( 'percentage' ); ?></span>
                                        <span ng-switch-when="4"><?php echo lang( 'cancelled' ); ?></span>
                                        <span ng-switch-when="5"><?php echo lang( 'complete' ); ?></span>
                                    </span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchInvoices.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-invoices search-icon pull-right"></span>
                    <?php echo lang('invoices'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="invoice in searchInvoices">
                        <a href="{{appurl + 'invoices/invoice/' + invoice.invoice_id}}">
                            <div class="md-list-item-text">
                                <h4 class="blur5" ng-bind='invoice.invoice_number?(invoice.invoice_number):("<?php echo $appconfig['inv_prefix'] . '' . '{{invoice.invoice_id}}' ?>")'>
                                </h4>
                                <p>
                                    <strong><?php echo lang('customer'); ?>:</strong>
                                    <span>{{invoice.namesurname?(invoice.namesurname):(invoice.company) | limitTo: 30 }}{{invoice.namesurname.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchProposals.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-proposals search-icon pull-right"></span>
                    <?php echo lang('proposals'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="proposal in searchProposals">
                        <a href="{{appurl + 'proposals/proposal/' + proposal.proposal_id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='proposal.proposal_number?("<?php echo '{{proposal.proposal_number}}'?>") : ("<?php echo $appconfig['proposal_prefix'] . '' .'{{proposal.proposal_id}}'?>")'>
                                    </span>
                                    <span ng-bind='proposal.subject?("<?php echo '{{proposal.subject | limitTo :20}}'  ?>") : ("<?php echo '{{ proposal.subject | limitTo: 20 }}' ?>")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('customer'); ?>:</strong>
                                    <span>{{ proposal.email | limitTo: 30 }}{{proposal.email.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchCustomers.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-customers search-icon pull-right"></span>
                    <?php echo lang('customers'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="customer in searchCustomers">
                        <a href="{{appurl + 'customers/customer/' + customer.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='customer.customer_number?("<?php echo '{{customer.customer_number}}' ?>") : ("<?php echo $appconfig['customer_prefix'] . '' . '{{customer.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='customer.name?("<?php echo '{{customer.name | limitTo :20}}'  ?>") : ("<?php echo '{{ customer.company | limitTo: 20 }}' ?>")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('email'); ?>:</strong>
                                    <span>{{ customer.email | limitTo: 30 }}{{customer.email.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchLeads.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-leads search-icon pull-right"></span>
                    <?php echo lang('leads'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="lead in searchLeads">
                        <a href="{{appurl + 'leads/lead/' + lead.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='lead.lead_number?("<?php echo '{{lead.lead_number}}' ?>") : ("<?php echo $appconfig['lead_prefix'] . '' . '{{lead.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='lead.name?("<?php echo '{{lead.name | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p> 
                                <p>
                                    <strong><?php echo lang('customer'); ?>:</strong>
                                    <span>{{ lead.company | limitTo: 30 }}{{lead.company.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchExpenses.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-expenses search-icon pull-right"></span>
                    <?php echo lang('expenses'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="expense in searchExpenses">
                        <a href="{{appurl + 'expenses/receipt/' + expense.id}}">
                            <div class="md-list-item-text">
                                <h4 class="blur5" ng-bind='expense.expense_number?(expense.expense_number):("<?php echo $appconfig['expense_prefix'] . '' . '{{expense.id}}' ?>")'>
                                </h4>
                                <p>
                                    <strong><?php echo lang('title'); ?>:</strong>
                                    <span>{{ expense.title | limitTo: 30 }}{{expense.title.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchProducts.length > 0">
                <md-subheader class="md-accent"><span class="material-icons ico-ciuis-products search-icon pull-right"></span>
                    <?php echo lang('products'); ?></md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="product in searchProducts">
                        <a href="{{appurl + 'products/product/' + product.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='product.product_number?("<?php echo '{{product.product_number}}' ?>") : ("<?php echo $appconfig['product_prefix'] . '' . '{{product.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='product.name?("<?php echo '{{product.name | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('status'); ?>:</strong>
                                    <span>{{ product.description | limitTo: 30 }}{{product.description.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchTickets.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-supports search-icon pull-right"></span>
                    <?php echo lang('tickets'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="ticket in searchTickets">
                        <a href="{{appurl + 'tickets/ticket/' + ticket.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='ticket.ticket_number?("<?php echo '{{ticket.ticket_number}}' ?>") : ("<?php echo $appconfig['ticket_prefix'] . '' . '{{ticket.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='ticket.subject?("<?php echo '{{ticket.subject | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('message'); ?>:</strong>
                                    <span>{{ ticket.message | limitTo: 30 }}{{ticket.message.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchTasks.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ico-ciuis-tasks search-icon pull-right"></span>
                    <?php echo lang('tasks'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="task in searchTasks">
                        <a href="{{appurl + 'tasks/task/' + task.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='task.task_number?("<?php echo '{{task.task_number}}' ?>") : ("<?php echo $appconfig['task_prefix'] . '' . '{{task.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='task.name?("<?php echo '{{task.name | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('assigned'); ?>:</strong>
                                    <span>{{ task.staff | limitTo: 30 }}{{task.staff.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchOrders.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ion-ios-filing-outline search-icon pull-right"></span>
                    <?php echo lang('orders'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="order in searchOrders">
                        <a href="{{appurl + 'orders/order/' + order.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='order.order_number?("<?php echo '{{order.order_number}}' ?>") : ("<?php echo $appconfig['order_prefix'] . '' . '{{order.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='order.subject?("<?php echo '{{order.subject | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('customer'); ?>:</strong>
                                    <span>{{order.name?(order.name):(order.company) | limitTo: 30 }}{{order.name.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchVendors.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ion-social-buffer-outline search-icon pull-right"></span>
                    <?php echo lang('vendors'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="vendor in searchVendors">
                        <a href="{{appurl + 'vendors/vendor/' + vendor.id}}">
                            <div class="md-list-item-text">
                                <p>
                                    <span class="blur5" ng-bind='vendor.vendor_number?("<?php echo '{{vendor.vendor_number}}' ?>") : ("<?php echo $appconfig['vendor_prefix'] . '' . '{{vendor.id}}' ?>")'>
                                    </span>
                                    <span ng-bind='vendor.company?("<?php echo '{{vendor.company | limitTo :20}}'  ?>") : ("")'>
                                    </span>
                                </p>
                                <p>
                                    <strong><?php echo lang('vendor') . ' ' . lang('name'); ?>:</strong>
                                    <span>{{ vendor.company | limitTo: 30 }}{{vendor.company.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchPurchases.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ion-ios-cart-outline search-icon pull-right"></span>
                    <?php echo lang('purchases'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="purchase in searchPurchases">
                        <a href="{{appurl + 'purchases/purchase/' + purchase.purchase_id}}">
                            <div class="md-list-item-text">
                                <h4 class="blur5" ng-bind='purchase.purchase_number?(purchase.purchase_number):("<?php echo $appconfig['purchase_prefix'] . '' . '{{purchase.purchase_id}}' ?>")'></h4>
                                <p>
                                    <strong><?php echo lang('vendor'); ?>:</strong>
                                    <span>{{ purchase.company | limitTo: 30 }}{{purchase.company.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
            <section ng-show="searchDeposits.length > 0">
                <md-subheader class="md-accent">
                    <span class="material-icons ion-ios-paper-outline search-icon pull-right"></span>
                    <?php echo lang('deposits'); ?>
                </md-subheader>
                <md-list layout-padding>
                    <md-list-item class="md-3-line search-item" ng-repeat="deposit in searchDeposits">
                        <a href="{{appurl + 'deposits/deposit/' + deposit.id}}">
                            <div class="md-list-item-text">
                                <h4 class="blur5" ng-bind='deposit.deposit_number?(deposit.deposit_number):("<?php echo $appconfig['deposit_prefix'] . '' . '{{deposit.id}}' ?>")'>
                                </h4>
                                <p>
                                    <strong><?php echo lang('title'); ?>:</strong>
                                    <span>{{ deposit.title | limitTo: 30 }}{{deposit.title.length > 30 ? '...' : ''}}</span>
                                </p>
                            </div>
                        </a>
                        <md-divider inset></md-divider>
                    </md-list-item>
                </md-list>
            </section>
        </md-content>
    </md-sidenav>

    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Todo" ng-cloak style="width: 450px;">
        <md-content layout-padding="">
            <div ng-show="loadingtodo">
                <br>
                <md-progress-circular md-mode="indeterminate" md-diameter="20" style="margin-left: auto;margin-right: auto;">
                </md-progress-circular>
            </div>
            <md-content ng-hide="loadingtodo" layout-padding="">
                <md-input-container class="md-icon-float md-icon-right md-block">
                    <textarea ng-model="tododetail" placeholder="<?php echo lang('type_todo') ?>" class="tododetail"></textarea>
                    <md-icon class="" aria-label='Add Todo'>
                        <md-tooltip md-direction="bottom"><?php echo lang('add') ?></md-tooltip>
                        <md-progress-circular ng-show="addingTodo == true" md-mode="indeterminate" md-diameter="18"></md-progress-circular>
                        <i ng-hide="addingTodo == true" ng-click="AddTodo()" class="ion-android-send text-success cursor"></i>
                    </md-icon>
                </md-input-container>
                <h4 md-truncate class=" text-muted text-uppercase"><strong ng-bind='lang.new'></strong></h4>
                <md-content layout-padding="">
                    <ul class="todo-item">
                        <li ng-repeat="todo in todos" class="todo-alt-item todo">
                            <div class="todo-c" style="display: grid;margin-top: 10px;">
                                <div class="todo-item-header">
                                    <div class="btn-group-sm btn-space pull-right">
                                        <button data-id='{{todo.id}}' ng-click='TodoAsDone($index)' class="btn btn-default btn-sm ion-checkmark">
                                            <md-tooltip md-direction="top"><?php echo lang('mark_as_done') ?>
                                            </md-tooltip>
                                        </button>
                                        <button data-id='{{todo.id}}' ng-click='DeleteTodo($index)' class="btn btn-default btn-sm ion-trash-a">
                                            <md-tooltip md-direction="top"><?php echo lang('delete') ?></md-tooltip>
                                        </button>
                                    </div>
                                    <span style="padding:5px;" class="pull-left label label-default" ng-bind="todo.date | date : 'MMM d, y h:mm:ss a'"></span>
                                </div>
                                <br>
                                <p class="todo-desc" ng-bind="todo.description"></p>
                            </div>
                        </li>
                    </ul>
                </md-content>
                <h4 md-truncate class=" text-success"><strong ng-bind='lang.donetodo'></strong></h4>
                <md-content layout-padding="">
                    <ul class="todo-item-done">
                        <li ng-class="{ 'donetodo-x' : todo.done }" ng-repeat="done in tododone" class="todo-alt-item-done todo">
                            <div class="todo-c" style="display: grid;margin-top: 10px;">
                                <div class="todo-item-header">
                                    <div class="btn-group-sm btn-space pull-right">
                                        <button data-id='{{todo.id}}' ng-click='TodoAsUnDone($index)' class="btn btn-default btn-sm ion-refresh">
                                            <md-tooltip md-direction="top"><?php echo lang('mark_as_undone') ?>
                                            </md-tooltip>
                                        </button>
                                        <button data-id='{{todo.id}}' ng-click='DeleteTodoDone($index)' class="btn btn-default btn-sm ion-trash-a">
                                            <md-tooltip md-direction="top"><?php echo lang('delete') ?></md-tooltip>
                                        </button>
                                    </div>
                                    <span style="padding:5px;" class="pull-left label label-success" ng-bind="done.date | date : 'MMM d, y h:mm:ss a'"></span>
                                </div>
                                <br>
                                <p class="todo-desc" ng-bind="done.description"></p>
                            </div>
                        </li>
                    </ul>
                </md-content>
            </md-content>
        </md-content>
    </md-sidenav>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Notifications" ng-cloak style="width: 450px;">
        <md-toolbar class="md-theme-light" style="background:#262626">
            <div class="md-toolbar-tools">
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
                <md-truncate><?php echo lang('notifications') ?></md-truncate>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a ng-click="markAllAsRead()" class="cursor" style="font-size: 14px;"><?php echo lang('mark_all_as_read') ?></a>
            </div>
        </md-toolbar>
        <div ng-show="loadingnotification">
            <br>
            <md-progress-circular md-mode="indeterminate" md-diameter="20" style="margin-left: auto;margin-right: auto;">
            </md-progress-circular>
        </div>
        <md-content ng-hide="loadingnotification">
            <md-list flex>
               
                <md-list-item class="md-3-line" ng-repeat="ntf in notifications" ng-click="NotificationRead($index)" ng-class="{new_notification: ntf.read == true}" aria-label="Read"> <img ng-src="{{appurl + 'uploads/images/' + ntf.avatar}}" class="md-avatar" alt="NTF" on-error-src="<?php echo base_url('assets/img/placeholder.png') ?>" />
                    <div class="md-list-item-text" layout="column">
                        <h4 ng-bind="ntf.detail"></h4>
                        <p ng-bind="ntf.date"></p>
                    </div>
                </md-list-item>
                <p ng-show="!notifications.length" class="not-found"><?php echo lang('not_found') ?></p>
            </md-list>
        </md-content>
    </md-sidenav>
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Profile" ng-cloak style="width: 450px;">
        <md-content>
            <md-tabs md-dynamic-height md-border-bottom>
                <md-tab label="Profile">
                    <md-content layout-padding class="md-mt-10 text-center" style="line-height: 0px;height:200px"> <img style="border-radius: 50%; box-shadow: 0 0 20px 0px #00000014;" height="100px" width="auto" ng-src="{{appurl + 'uploads/images/' + user.avatar}}" class="md-avatar" alt="{{user.name}}" />
                        <h3><strong ng-bind="user.name"></strong></h3>
                        <br>
                        <span ng-bind="user.email"></span>
                    </md-content>
                    <md-content class="md-mt-30 text-center">
                    <md-button ng-show="ONLYADMIN != 'true'" ng-href="{{appurl + 'staff/profile'}}" class="md-raised" ng-bind='lang.profile' aria-label='Profile'></md-button> 
                     
                        <md-button ng-show="ONLYADMIN == 'true'" ng-href="{{appurl + 'staff/staffmember/' + activestaff}}" class="md-raised" ng-bind='lang.profile' aria-label='Profile'></md-button>
                        <md-button ng-href="{{appurl + 'login/logout'}}" class="md-raised" ng-bind='lang.logout' aria-label='LogOut'></md-button>
                    </md-content>
                    <?php if (!$this->session->userdata('other')) { ?>
                        <md-content layout-padding>
                            <md-switch ng-model="appointment_availability" ng-change="ChangeAppointmentAvailability(user.id,appointment_availability)" aria-label="Status"><strong class="text-muted" ng-bind='lang.appointment_availability'></strong></md-switch>
                        </md-content>
                    <?php } ?>
                    <md-tabs>
                        <?php if (!$this->session->userdata('other')) { ?>
                            <md-tab label="<?php echo lang('onsite_visits') ?> ">
                                <md-list class="md-dense" flex>
                                    <md-list-item class="md-3-line" ng-repeat="meet in meetings">
                                        <div class="md-list-item-text" layout="column">
                                            <h3 ng-bind="meet.title"></h3>
                                            <h4 ng-bind="meet.customer"></h4>
                                            <p>
                                                <span ng-bind="meet.date | date : 'MMM d, y h:mm:ss a'"></span><br>
                                                <span ng-bind="meet.staff"></span>
                                            </p>
                                        </div>
                                        <md-divider></md-divider>
                                    </md-list-item>
                                    <p ng-show="!meetings.length" class="not-found"><?php echo lang('not_found') ?></p>
                                </md-list>
                            </md-tab>
                        <?php } ?>
                        <?php if (!$this->session->userdata('other')) { ?>
                            <md-tab label="<?php echo lang('appointments'); ?>">
                                <md-content>
                                    <md-list class="md-dense" flex>
                                        <md-list-item class="md-3-line" ng-repeat="appointment in dashboard_appointments">
                                            <div class="md-avatar a64"><span ng-bind="appointment.day"></span><br>
                                                <span class="a65" ng-bind="appointment.aday"></span>
                                            </div>
                                            <div class="md-list-item-text" layout="column">
                                                <h3 ng-bind="appointment.title"></h3>
                                                <p>
                                                    <span ng-bind="appointment.start_iso_date | date : 'MMM d, y h:mm:ss a'"></span><br>
                                                    <span ng-bind="appointment.staff"></span>
                                                </p>
                                            </div>
                                        </md-list-item>
                                        <p ng-show="!dashboard_appointments.length" class="not-found"><?php echo lang('not_found') ?></p>
                                    </md-list>
                                </md-content>
                            </md-tab>
                        <?php } ?>
                    </md-tabs>
                </md-tab>
            <md-tabs>
        </md-content>
    </md-sidenav>
        <!--     Estimation Notification -->    
        <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="EstNotifications" ng-cloak style="width: 450px;">
        <md-toolbar class="md-theme-light" style="background:#262626">
            <div class="md-toolbar-tools">
                <md-button ng-click="close()" class="md-icon-button" aria-label="Close"> <i class="ion-android-arrow-forward"></i> </md-button>
                <md-truncate><?php echo lang('notifications') ?></md-truncate>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a ng-click="markAllEstAsRead()" class="cursor" style="font-size: 14px;"><?php echo lang('mark_all_as_read') ?></a>
            </div>
        </md-toolbar>
        <div ng-show="loadingnotification">
            <br>
            <md-progress-circular md-mode="indeterminate" md-diameter="20" style="margin-left: auto;margin-right: auto;">
            </md-progress-circular>
        </div>
        <md-content ng-hide="loadingnotification">
            <md-list flex>
                
             <!--    <md-list-item class="md-3-line" ng-repeat="ntf in estnotifications" ng-click="EstNotificationRead($index)" ng-class="{new_notification: ntf.read == true}" aria-label="Read"> <img ng-src="{{appurl + 'uploads/images/' + ntf.avatar}}" class="md-avatar" alt="NTF" on-error-src="<?php echo base_url('assets/img/placeholder.png') ?>" />
                    <div class="md-list-item-text" layout="column">
                        <h4 ng-bind="ntf.number"></h4>
                        <h4 ng-bind="ntf.customer_name"></h4>
                        <h4 ng-bind="ntf.first_levelinfo  | uppercase" ></h4>
                        <h4 ng-bind="ntf.second_levelinfo  | uppercase  "></h4>
                    </div>
                    <div class="md-list-item-text" layout="column" style="display: inline-block; ">
                        <h4 ng-bind="ntf.value"></h4>
                    </div>
                </md-list-item> -->
                <div class="events events_xs col-md-12" style="margin-top: 0px;">
				<ul>
					<li ng-repeat="ntf in estnotifications" class="next overdueinvoices" ng-click="EstNotificationRead($index)" ng-class="{new_notification: ntf.read == true}">
                   <img ng-src="{{appurl + 'assets/img/'  + ntf.request_type + '.png'}}" class="date" alt="NTF"  style="height: 67px;width:47px;" />
                   <div style=" display: inline-block;">
						<h3 class="text-bold overduetext" ng-bind='ntf.number'><b><span  ng-bind='ntf.number'></span></b></h3>
						<p>
							<span class='duration text-bold' ng-bind="ntf.customer_name.substring(0, 25)"></span>
                            <span class='location text-bold'  style="color: #ee7a6b;display: inline-block;  font-weight: bold;">
                            <span ng-bind-html="ntf.value | currencyFormat:cur_code:null:true:cur_lct"  style="font-size:11px;"  ></span></span><br>
                            <span style="color: #ee7a6b;" class='text-bold'>
                            <span class="text-default"><b ng-bind="ntf.first_levelinfo"></b></span>
                            <span class="text-default"><b ng-bind="ntf.second_levelinfo"></b></span>
                        </span>
                        </p>
                        <span ng-bind="ntf.date" > <i class="ion-alert"></i> </span>
                        </div>
                    </li>
                </ul>
                </div>   
<!--                 <p ng-show="!estnotifications.length" class="not-found"><?php echo lang('not_found') ?></p>
 -->            </md-list>
        </md-content>
    </md-sidenav>
    <md-content class="ciuis-body-wrapper ciuis-body-fixed-sidebar" ciuis-ready>
