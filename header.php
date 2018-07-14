<?php 
global $EPI_TemplateVersion;
$EPI_TemplateActive = true;
$EPI_TemplateVersion = 'EPI AdminLTE';
if ($EPI_TemplateActive === True) {
	include_once("epi/epi_template_functions.php");
	$EPI_UseMessagesMenu = 1;
	$EPI_MessagesMenu = 'epi/epi_MessagesMenu.php'; 
	$EPI_UseNotificationsMenu = 1; 
	$EPI_NotificationsMenu = 'epi/epi_NotificationsMenu.php'; 
	$EPI_UseLanguageDropdown = 1; 
	$EPI_LanguageSource = 'epi/epi_language.php'; 
	$EPI_BodyClass = 'skin-green-light';
	$EPI_UseTasksMenu = 1;
	$EPI_TasksMenu = 'epi/epi_TasksMenu.php';
	$EPI_UseUserMenu = 1;
	$EPI_UserMenu = 'epi/epi_UserMenu.php';
	$EPI_UseUserPanel = 1;
	$EPI_UserPanel = 'epi/epi_UserPanel.php';
	$EPI_TOPMENU =	 'Default'; //
	$EPI_FixedMenu =	 'Fixed'; //
	$EPI_CleanLoginPages = 1; 
	$EPI_LicenseKey = ''; 
	$EPI_ExtraPage = in_array(CurrentPageID(), array('login','register','forgotpwd'));
	$EPI_LayoutClass = ($EPI_FixedMenu 	=== 'Fixed') 	? ' fixed ' : '';
	$EPI_LayoutClass.= ($EPI_TOPMENU 	=== 'Top') 		? ' layout-top-nav ' : ' sidebar-mini '; 
	if (defined("EW_PAGE_TITLE_STYLE")) {
		$EPI_PageTitleStyle = EW_PAGE_TITLE_STYLE; // "None","Caption","Breadcrumbs",""
	} else {
		$EPI_PageTitleStyle = "Breadcrumbs";
	}
	if ($EPI_CleanLoginPages && $EPI_ExtraPage) {
		$EPI_BodyClass = '';
		$EPI_LayoutClass .= ' login-page ';
	}
	if (!defined("EW_PAGE_ID")) {
		define("EW_PAGE_ID",CurrentPage()->PageID, TRUE);
	}
}
$EPI_UserExt = true;
if ($EPI_UserExt === true) {
	$EPIUser_Table = 'm_login';
	$EPIUser_IDField = 'id';
	$EPIUser_AvatarField = 'pd_avatar';
	$EPIUser_Quota = 2; 
	$EPIUser_AvatarFolder = 'uploads'; 
}

// Compatibility with PHP Report Maker
if (!isset($Language)) {
	include_once "ewcfg13.php";
	include_once "ewshared13.php";
	$Language = new cLanguage();
}

// Responsive layout
if (ew_IsResponsiveLayout()) {
	$gsHeaderRowClass = "hidden-xs ewHeaderRow";
	$gsMenuColumnClass = "hidden-xs ewMenuColumn";
	$gsSiteTitleClass = "hidden-xs ewSiteTitle";
} else {
	$gsHeaderRowClass = "ewHeaderRow";
	$gsMenuColumnClass = "ewMenuColumn";
	$gsSiteTitleClass = "ewSiteTitle";
}
?>
<!DOCTYPE html>
<html <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'id = "extr-page"'; ?>><head>
<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="epi_templateversion" content="<?php echo $EPI_TemplateVersion; ?>">
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>adminlte/bootstrap/css/<?php echo ew_CssFile("bootstrap.min.css") ?>">
<link rel="stylesheet" type="text/css" href="epi/css/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="epi/css/fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="epi/css/ii/css/ionicons.min.css">
<link rel="stylesheet" type="text/css" href="adminlte/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="adminlte/plugins/fullcalendar/fullcalendar.print.css" media="print">
<link rel="stylesheet" type="text/css" href="adminlte/dist/css/AdminLTE.min.css">
<?php if (!empty($EPI_BodyClass)) { ?><link rel="stylesheet" type="text/css" href="adminlte/dist/css/skins/<?php echo $EPI_BodyClass; ?>.min.css"><?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>epi/css/<?php echo ew_CssFile("epi-overrides.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>colorbox/colorbox.css">
<?php if (ew_IsResponsiveLayout()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<script src="<?php echo $EW_RELATIVE_PATH ?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>adminlte/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.storageapi.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>jquery/pStrength.jquery.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>jquery/pGenerator.jquery.js"></script>
<?php
if (CurrentPageID() == 'userpriv') {
	ew_AddStylesheet("adminlte/plugins/datatables/dataTables.bootstrap.css");
	ew_AddClientScript("adminlte/plugins/datatables/jquery.dataTables.min.js");
	ew_AddClientScript("adminlte/plugins/datatables/dataTables.bootstrap.min.js");
}
?>
<script src="<?php echo $EW_RELATIVE_PATH ?>epi/js/jquery.ui.widget.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>phpjs/typeahead.bundle.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/load-image.all.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/jqueryfileupload.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>phpjs/mobile-detect.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>epi/js/moment.min.js"></script>
<script src="<?php echo $EW_RELATIVE_PATH ?>epi/js/locales.min.js"></script>
<link href="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewcalendar.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "<?php echo $EW_DATE_SEPARATOR ?>"; // Date separator
var EW_TIME_SEPARATOR = "<?php echo $EW_TIME_SEPARATOR ?>"; // Time separator
var EW_DATE_FORMAT = "<?php echo $EW_DATE_FORMAT ?>"; // Default date format
var EW_DATE_FORMAT_ID = "<?php echo $EW_DATE_FORMAT_ID ?>"; // Default date format ID
var EW_DECIMAL_POINT = "<?php echo $EW_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $EW_THOUSANDS_SEP ?>";
var EW_MIN_PASSWORD_STRENGTH = 60;
var EW_GENERATE_PASSWORD_LENGTH = 16;
var EW_GENERATE_PASSWORD_UPPERCASE = true;
var EW_GENERATE_PASSWORD_LOWERCASE = true;
var EW_GENERATE_PASSWORD_NUMBER = true;
var EW_GENERATE_PASSWORD_SPECIALCHARS = false;
var EW_SESSION_TIMEOUT = <?php echo (EW_SESSION_TIMEOUT > 0) ? ew_SessionTimeoutTime() : 0 ?>; // Session timeout time (seconds)
var EW_SESSION_TIMEOUT_COUNTDOWN = <?php echo EW_SESSION_TIMEOUT_COUNTDOWN ?>; // Count down time to session timeout (seconds)
var EW_SESSION_KEEP_ALIVE_INTERVAL = <?php echo EW_SESSION_KEEP_ALIVE_INTERVAL ?>; // Keep alive interval (seconds)
var EW_RELATIVE_PATH = "<?php echo $EW_RELATIVE_PATH ?>"; // Relative path
var EW_SESSION_URL = EW_RELATIVE_PATH + "ewsession13.php"; // Session URL
var EW_IS_LOGGEDIN = <?php echo IsLoggedIn() ? "true" : "false" ?>; // Is logged in
var EW_IS_SYS_ADMIN = <?php echo IsSysAdmin() ? "true" : "false" ?>; // Is sys admin
var EW_CURRENT_USER_NAME = "<?php echo ew_JsEncode2(CurrentUserName()) ?>"; // Current user name
var EW_IS_AUTOLOGIN = <?php echo IsAutoLogin() ? "true" : "false" ?>; // Is logged in with option "Auto login until I logout explicitly"
var EW_TIMEOUT_URL = EW_RELATIVE_PATH + "logout.php"; // Timeout URL
var EW_LOOKUP_FILE_NAME = "ewlookup13.php"; // Lookup file name
var EW_LOOKUP_FILTER_VALUE_SEPARATOR = "<?php echo EW_LOOKUP_FILTER_VALUE_SEPARATOR ?>"; // Lookup filter value separator
var EW_MODAL_LOOKUP_FILE_NAME = "ewmodallookup13.php"; // Modal lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload URL
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_MULTIPLE_UPLOAD_SEPARATOR = "<?php echo EW_MULTIPLE_UPLOAD_SEPARATOR ?>"; // Upload multiple separator
var EW_USE_COLORBOX = <?php echo (EW_USE_COLORBOX) ? "true" : "false" ?>;
var EW_USE_JAVASCRIPT_MESSAGE = false;
var EW_MOBILE_DETECT = new MobileDetect(window.navigator.userAgent);
var EW_IS_MOBILE = EW_MOBILE_DETECT.mobile() ? true : false;
var EW_PROJECT_STYLESHEET_FILENAME = "<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>"; // Project style sheet
var EW_PDF_STYLESHEET_FILENAME = "<?php echo EW_PDF_STYLESHEET_FILENAME ?>"; // Pdf style sheet
var EW_TOKEN = "<?php echo @$gsToken ?>";
var EW_CSS_FLIP = <?php echo ($EW_CSS_FLIP) ? "true" : "false" ?>;
var EW_CONFIRM_CANCEL = true;
var EW_SEARCH_FILTER_OPTION = "<?php echo EW_SEARCH_FILTER_OPTION ?>";
</script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/jsrender.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewp13.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.ewjtable.js"></script>
<script type="text/javascript">
var ewVar = <?php echo json_encode($EW_CLIENT_VAR); ?>;
<?php echo $Language->ToJSON() ?>
</script>
<?php
ew_AddStylesheet("pacemaster/themes/red/pace-theme-flash.css"); 
ew_AddClientScript("pacemaster/pace.min.js");

//ew_AddStylesheet("external/centurygothic-12px-flat.css");
//if (!isset($_SESSION['VisitorInfo']) && !IsSysAdmin()) {
	//epi_getVisitorInfo();
//}

?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/userfn13.js"></script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo ew_ConvertFullUrl("favicon.ico") ?>"><link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo ew_ConvertFullUrl("favicon.ico") ?>">
<meta name="generator" content="PHPMaker v2017.0.7">
</head>
<?php 	
?>
    <body class=" <?php echo $EPI_BodyClass . $EPI_LayoutClass; ?>">
<?php if (@!$gbSkipHeaderFooter) { ?>
<!-- header (begin) -->
<!-- ** Note: Only licensed users are allowed to change the logo ** -->
<div class="wrapper">
<?php if ($EPI_TOPMENU == 'Default') { ?>
<header class="main-header" <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'style = "display:none;"'; ?>>
    <a class="logo" href="#">
    <div id="logo-group">
    <span id="logo" class="logo-lg"><img src="<?php echo $EW_RELATIVE_PATH ?>phpimages/Untitled-23.png" alt=""></span>
    </div> 
    </a>
    <nav class="navbar navbar-static-top">
		<!-- collapse menu button -->
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</a>
		<!-- end collapse menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">    
            <!-- Notification area -->
            <li class="dropdown session-timer hidden-sm" title="Session Timer"><div id = "epi_sessionTimer"></div></li>
            <?php if ($EPI_UseMessagesMenu && !$EPI_ExtraPage) include ($EPI_MessagesMenu); ?>
            <?php if ($EPI_UseNotificationsMenu && !$EPI_ExtraPage) include ($EPI_NotificationsMenu); ?>
            <?php if ($EPI_UseTasksMenu && !$EPI_ExtraPage) include ($EPI_TasksMenu); ?>
            <?php if ($EPI_UseUserMenu && !$EPI_ExtraPage) include ($EPI_UserMenu); ?>
            <!-- end notification area -->
			</ul>
		</div>
	</nav>
</header>
<?php } ?>
<?php if (ew_IsResponsiveLayout()) { ?>
<nav id="ewMobileMenu" role="navigation" class="navbar navbar-default visible-xs hidden-print">
	<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button data-target="#ewMenu" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo (EW_MENUBAR_BRAND_HYPERLINK <> "") ? EW_MENUBAR_BRAND_HYPERLINK : "#" ?>"><?php echo (EW_MENUBAR_BRAND <> "") ? EW_MENUBAR_BRAND : $Language->ProjectPhrase("BodyTitle") ?></a>
		</div>
		<div id="ewMenu" class="collapse navbar-collapse" style="height: auto;"><!-- Begin Main Menu -->
<?php
	$RootMenu = new cMenu("MobileMenu");
	$RootMenu->MenuBarClassName = "";
	$RootMenu->MenuClassName = "sidebar-menu";
	$RootMenu->SubMenuClassName = "treeview";
	$RootMenu->SubMenuDropdownImage = "";
	$RootMenu->SubMenuDropdownIconClassName = "icon-arrow-down";
	$RootMenu->MenuDividerClassName = "divider";
	$RootMenu->MenuItemClassName = "dropdown";
	$RootMenu->SubMenuItemClassName = "dropdown";
	$RootMenu->MenuActiveItemClassName = "active";
	$RootMenu->SubMenuActiveItemClassName = "active";
	$RootMenu->MenuRootGroupTitleAsSubMenu = TRUE;
	$RootMenu->MenuLinkDropdownClass = "ewDropdown";
	$RootMenu->MenuLinkClassName = "icon-arrow-right";
?>
<?php include_once "ewmobilemenu.php" ?>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php } ?>
	<!-- header (end) -->
<!-- content (begin) -->
<?php if (!empty($EPI_TOPMENU) && $EPI_TOPMENU == 'Top') { 	?>
<header class="main-header" <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'style = "display:none;"'; ?>>
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
        <a class="navbar-brand" href="#">
        <div id="logo-group">
        <span id="logo" class="logo-sm"><img src="<?php echo $EW_RELATIVE_PATH ?>phpimages/Untitled-23.png" alt=""></span>
        </div> 
        </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div id="navbar-collapse" class="collapse navbar-collapse pull-left">
<?php include_once "ewmenu.php" ?>
        </div>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">    
            <!-- Notification area -->
            <?php if ($EPI_UseMessagesMenu && !$EPI_ExtraPage) include ($EPI_MessagesMenu); ?>
            <?php if ($EPI_UseNotificationsMenu && !$EPI_ExtraPage) include ($EPI_NotificationsMenu); ?>
            <?php if ($EPI_UseTasksMenu && !$EPI_ExtraPage) include ($EPI_TasksMenu); ?>
            <?php if ($EPI_UseUserMenu && !$EPI_ExtraPage) include ($EPI_UserMenu); ?>
            <!-- end notification area -->
			</ul>
		</div>
        </div>
    </nav>
</header>
<?php } else { ?>
<aside class="main-sidebar" <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'style = "display:none;"'; ?>>
    <section class="sidebar">
    <?php if ($EPI_UseUserPanel && !$EPI_ExtraPage) include ($EPI_UserPanel); ?>
    <?php if (!empty(CurrentTable()->TableName) && (EW_PAGE_ID !== "custom")) { ?>
    <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
    <input type="text" name="psearch" class="form-control" placeholder="Search...">
    <input type="hidden" name="cmd" value="search">
    <input type="hidden" name="t" value="<?php if (!empty(CurrentTable()->TableName)) echo CurrentTable()->TableName; ?>">
    <span class="input-group-btn">
    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
    </button>
    </span>
    </div>
    </form>
    <?php } ?>
    <nav>
<?php include_once "ewmenu.php" ?>
    </nav>
    </section>
</aside>
<?php } ?>
<!-- right column (begin) -->
<!-- begin SA main -->
<?php if ($EPI_CleanLoginPages && !$EPI_ExtraPage) { ?> 	<div class="content-wrapper"><?php } ?>
<section class="content-header" <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'style = "display:none;"'; ?>>
	<?php if (!$EPI_ExtraPage) { 
	if ($EPI_PageTitleStyle == "Caption") { 
		$TableCaption = CurrentTable() ? CurrentTable()->TableCaption() : ''; 
	} else { 
		$TableCaption = '';  
		}
	if ($EPI_PageTitleStyle == "Breadcrumbs") { 
		$TableCaption = CurrentTable() ? CurrentTable()->TableCaption() : '';
		$TableName = (!empty(CurrentTable()->TableName) && (EW_PAGE_ID !== "custom")) ? CurrentTable()->TableName : '';
	} else { 
		$TableName = ''; 
		}
	if (EW_PAGE_ID == "custom") {
		$TableCaption = @$Language->Phrases['ew-language']['project']['table'][strtolower(CurrentPage()->PageObjName)]['phrase']['tblcaption']['attr']['value'];

		//$TableCaption = $Language->ProjectPhrase(CurrentPage()->PageObjName);
	}
	if (!empty($TableCaption) || !empty($TableName) && ($EPI_PageTitleStyle == "Caption" || $EPI_PageTitleStyle == "Breadcrumbs")) { ?>
        <h1 class="<?php echo $gsSiteTitleClass ?>">
            <?php echo $TableCaption; ?>
        </h1>
    <?php } } ?>
<?php 
if (!empty($Breadcrumb)) $Breadcrumb->Render(); 
?>
</section>
<section class="content">
<?php } ?>
