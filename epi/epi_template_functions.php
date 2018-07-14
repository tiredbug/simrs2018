<?php
// EPI Functions for PHPMaker 2017 and EPI Templates
function epi_datediff($timeold,$timenew){
	$ago = "";
	$edDateTime = new DateTime(date('l, F jS, Y g:i:sa T',$timeold));
	$nowDateTime = new DateTime(date('l, F jS, Y g:i:sa T',$timenew));
	$interval = $edDateTime->diff($nowDateTime);
	if ($years = $interval->format("%y")) $ago .= $years . " year(s) " ;
	if ($months = $interval->format("%m")) $ago .= $months . " month(s) ";
	if ($days = $interval->format("%d")) $ago .= $days . " day(s) ";
	if ($hours = $interval->format("%h")) $ago .= $hours . " hour(s) ";
	if ($minutes = $interval->format("%i")) $ago .= $minutes . " minute(s) ";
	if ($seconds = $interval->format("%s")) $ago .= $seconds . " second(s) ";
	return $ago;
}

function bytesConvert($bytes) {
	 $ext = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	 $unitCount = 0;
	 for(; $bytes > 1024; $unitCount++) $bytes /= 1024;
	 return round($bytes,1)." ".$ext[$unitCount];
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);
	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;
	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}
	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function epi_calendar($table, $title_field, $start_dt, $end_dt, $eventid_field, $eventcontent_field = false, $usergroup = false, $userlevelfield = false){
	$sql_orig = "SELECT $eventcontent_field FROM $table WHERE $eventid_field = {query_value}";
	$event_sql = ew_Encrypt($sql_orig);
	$html = "<script src='adminlte/plugins/fullcalendar/fullcalendar.min.js'></script>";
	$html.= "<script src='adminlte/plugins/fullcalendar/epi-locale-all.js'></script>";
	$html.= "<div class='box box-primary'><div class='box-body no-padding'><div id='calendar'></div></div></div>";
	$where = " WHERE 1=1 ";
	if ($usergroup && $userlevelfield) $where.= " AND $userlevelfield = $usergroup ";
	$events_sql = "SELECT $title_field AS title, $eventid_field as id, $start_dt AS start, $end_dt AS end FROM $table $where ORDER BY $start_dt ASC";
	$jevents = json_query($events_sql);	
	$html.= "
	<script>
		$('#calendar').fullCalendar({ 
		locale: '".CurrentLanguageID()."',
		header: {
          left: 'month,agendaWeek,agendaDay',
          center: 'title',
          right: 'prev,next today'
       }, 	
	   	events: $jevents ";
	if (!empty($eventcontent_field)) {
		$html.= ",
			eventClick:function(calEvent){
				$('#ewModalDialog .modal-title').html(calEvent['title']);
				$('#ewModalDialog .modal-date').html('<p class=\'label label-info\'>' + moment.utc(calEvent['start'], 'X').format('ddd MMM D, h:mm A') + '</p> to <p class=\'label label-info\'>' + moment.utc(calEvent['end'], 'X').format('ddd MMM D, h:mm A') + '</p>');
				var htmlbody = ew_Ajax('".htmlentities($event_sql)."', calEvent['id']);
				$('#ewModalDialog .modal-body').html(htmlbody);	
				$('#ewModalDialog .modal-footer').html('<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Close</button>');
				$('#ewModalDialog').modal('show');
            }";
	} else {
		$html.= ",
			eventClick:function(calEvent){
				$('#ewModalDialog .modal-title').html(calEvent['title']);
				$('#ewModalDialog .modal-body').html('<p>Start: ' + calEvent['start'] + '</p><p>End: ' + calEvent['end'] + '</p>');
				$('#ewModalDialog .modal-footer').html('<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Close</button>');
				$('#ewModalDialog').modal('show');
            }";
		}
/*
	FullCalendar makes very ugly recurring events, we'll do it in PHP
	if ($dow) {
		$html.= ",
			eventRender: function(calEvent) {
				if(calEvent['end'] > today) {
					calEvent.editable = true;
				}
			},
			eventAfterAllRender: function() {
				if(hasAlreadyRun === false) {
					hasAlreadyRun = true;
					calendar.fullCalendar('rerenderEvents');  
				} 
			}
			";
		}
*/
	$html.= "});</script>";
	return $html;
}

function epi_private_calendar($table, $title_field, $start_dt, $end_dt, $eventid_field, $eventcontent_field, $active_field, $public_field, $target_field, $color_field = false){
	global $epi_filter;
	$sql_orig = "SELECT $eventcontent_field FROM $table WHERE $eventid_field = {query_value}";
	$event_sql = ew_Encrypt($sql_orig);
	$html = "<script src='adminlte/plugins/fullcalendar/fullcalendar.min.js'></script>";
	$html.= "<script src='adminlte/plugins/fullcalendar/epi-locale-all.js'></script>";
	$html.= "<div class='box box-primary'><div class='box-body no-padding'><div id='calendar'></div></div></div>";
	if (!IsSysAdmin()) {
		$where = (!empty($epi_filter)) ? " WHERE ($epi_filter " : " WHERE (1=1"; 
		$where.= " AND $active_field = 1) "; // my active stuff OR
		$where.= " OR ($public_field = 1 AND $active_field = 1) "; // public active stuff OR
		$where.= " OR ($public_field = 0 OR $public_field IS NULL AND $active_field = 1 AND $target_field = ".CurrentUserLevel().") "; // non-public, level-shared 
	} else {
		$where = " WHERE 1=1"; // sysadmin sees all
	}
	/*
	$dow = ($dow_field) ? " $dow_field as dow, " : NULL;
	*/
	$color = ($color_field) ? " $color_field as backgroundColor, " : NULL;
	$events_sql = "SELECT $title_field AS title, $eventid_field as id, $color $start_dt AS start, $end_dt AS end FROM $table $where ORDER BY $start_dt ASC";
	$phpevents = epi_GetAll($events_sql);
	/*
	if (!empty($dow)) {
		foreach ($phpevents as $key=>$phpevent){
			if (!is_null($phpevent['dow'])) {
				$phpevents[$key]['dow'] = explode(",",$phpevent['dow']);
				$phpevents[$key]['ranges'] = array();
				$phpevents[$key]['start'] = date('H:i:s', strtotime($phpevent['start']));
				$phpevents[$key]['end'] = date('H:i:s', strtotime($phpevent['end']));
				$phpevents[$key]['ranges']['start'] = date('Y-m-d',strtotime($phpevent['start']));
				$phpevents[$key]['ranges']['end']  = date('Y-m-d',strtotime($phpevent['end']));
			}
		}
	}
	*/
	$jevents = json_encode($phpevents);
	$html.= "
	<script>
		$('#calendar').fullCalendar({ 
		locale: '".CurrentLanguageID()."',
		header: {
          left: 'month,agendaWeek,agendaDay',
          center: 'title',
          right: 'prev,next today'
       }, 	
	   	events: $jevents ";
	if (!empty($eventcontent_field)) {
		$html.= ",
			eventClick:function(calEvent){
				$('#ewModalDialog .modal-title').html(calEvent['title']);
				$('#ewModalDialog .modal-date').html('<p class=\'label label-info\'>' + moment.utc(calEvent['start'], 'X').format('ddd MMM D, h:mm A') + '</p> to <p class=\'label label-info\'>' + moment.utc(calEvent['end'], 'X').format('ddd MMM D, h:mm A') + '</p>');
				var htmlbody = ew_Ajax('".htmlentities($event_sql)."', calEvent['id']);
				$('#ewModalDialog .modal-body').html(htmlbody);	
				$('#ewModalDialog .modal-footer').html('<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Close</button>');
				$('#ewModalDialog').modal('show');
            }";
	} else {
		$html.= ",
			eventClick:function(calEvent){
				$('#ewModalDialog .modal-title').html(calEvent['title']);
				$('#ewModalDialog .modal-body').html('<p>Start: ' + calEvent['start'] + '</p><p>End: ' + calEvent['end'] + '</p>');
				$('#ewModalDialog .modal-footer').html('<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Close</button>');
				$('#ewModalDialog').modal('show');
            }";
		}
	$html.= "});</script>";
	return $html;
}

function epi_gridsortable($sort_fld) {
	$currenttable = CurrentTable()->TableName;
	if (CurrentPage()->IsGridEdit()) {
		ew_AddClientScript("epi/js/jquery.tablednd.min.js");
		$html = "
		<script>
		var page_sortable = 1;
		$(document).ready(function(){
			if (page_sortable == 1) {
				$('table#tbl_{$currenttable}list').tableDnD({
					buttonState: '', 
					containerID: 'gmp_{$currenttable}', 
					onDragClass: 'alert alert-warning text-warning', 
					dragHandle: null, 
					dropStyles: null, 
					onAllowDrop: null, 
					onDragStart: null, 
					onDrop: function(table, row) {
						var rows = table.tBodies[0].rows;
						for (var i=0; i<rows.length; i++) {
							$(rows[i]).find('input[id$=\"{$sort_fld}\"]').val(i);
							}
						},   
					onRowsChanged: null, 
					filterRegexp: null
				});
			}
		});</script>";
	} else {
		$html = "<script>var page_sortable = 0;</script>";
	}
	return $html;
}

function epi_audittrim() {
	$tablename = CurrentTable()->TableName;
	$tablelabel = CurrentTable()->TableCaption();
	$nullcount = ew_ExecuteScalar("SELECT COUNT(*) FROM $tablename WHERE (oldvalue = '' OR oldvalue IS NULL) 
		AND (newvalue = '' OR newvalue IS NULL) AND (action = 'A' or action = 'U') OR `action` LIKE '%***%';");
	$prunesql = "DELETE FROM $tablename WHERE (oldvalue = '' OR oldvalue IS NULL) AND (newvalue = '' OR newvalue IS NULL) 
		AND (action = 'A' or action = 'U') OR `action` LIKE '%***%';";
	if ($nullcount > 0 && !isset($_GET['prune_audit'])) {
		CurrentPage()->setWarningMessage("You have $nullcount useless records in your $tablelabel. <a href = '"
		.$tablename."list.php?prune_audit=1'>Click here</a> to delete them.");
		} 
	if (isset($_GET['prune_audit']) && $nullcount > 0 && intval($_GET['prune_audit']) === 1) { 
		CurrentPage()->setWarningMessage(
			"To delete these $nullcount records in your $tablelabel, <strong><a href = '"
			.$tablename
			."list.php?prune_audit=2'>Click here</a></strong>. Or you can <strong><a href='"
			.$tablename."list.php'>Cancel</a></strong> this operation.");
		}
	if (isset($_GET['prune_audit']) && intval($_GET['prune_audit']) === 2) { 
		ew_Execute($prunesql); 
		CurrentPage()->setSuccessMessage("$tablelabel maintenance complete.");
	}
}
	
function epi_GetAll($SQL) {
	$db = Conn();
	$original_mode = $GLOBALS["ADODB_FETCH_MODE"];
	$db->raiseErrorFn = 'ew_ErrorFn';
	$GLOBALS["ADODB_FETCH_MODE"] = ADODB_FETCH_ASSOC;
	$res = $db->GetAll($SQL);
	$db->raiseErrorFn = '';
	$GLOBALS["ADODB_FETCH_MODE"] = $original_mode;
	return $res;
}

function json_query($sql) {
	$original_mode = $GLOBALS["ADODB_FETCH_MODE"];
	$GLOBALS["ADODB_FETCH_MODE"] = ADODB_FETCH_ASSOC;
	$myqueryresult = $GLOBALS["conn"]->GetAll($sql);
	$json_result = json_encode($myqueryresult);
	$GLOBALS["ADODB_FETCH_MODE"] = $original_mode;
	return $json_result;
}

function epi_escape_string($string) {
	$db = $GLOBALS['conn'];
	$cleanstring = $db->qstr($string, get_magic_quotes_gpc());
	return $cleanstring;
}
// EPI Analytics

function geoiparray ($ip) {
	require_once("geoip/geoipcity.inc");
	if (file_exists("geoip/GeoLiteCity.dat")) {
		$gi = geoip_open("geoip/GeoLiteCity.dat",GEOIP_STANDARD);
	} else if (file_exists("geoip/GeoLiteCity.dat")) {
		$gi = geoip_open("geoip/GeoLiteCity.dat",GEOIP_STANDARD);
	}
	$ipr = GeoIP_record_by_addr($gi, $ip);
	geoip_close($gi);
	return $ipr;
}

function epi_getVisitorInfo() {
	require_once("epi/Browser.php");
	$s = array('REMOTE_ADDR','HTTP_X_REAL_IP','HTTP_REFERER','HTTP_ACCEPT_LANGUAGE','HTTP_COOKIE','HTTP_USER_AGENT');
	$vi = array('v_remote_addr','v_ipaddr','v_referer','v_language','v_http_cookie','v_useragent');
	$sessionid = (!empty($_SERVER['HTTP_COOKIE'])) ? $_SERVER['HTTP_COOKIE'] : 'hidden_session';
	$mygeo = geoiparray($_SERVER['REMOTE_ADDR']);
	// Note: using epi_escape_string() means you do NOT quote it in your SQL
	$mycity = epi_escape_string($mygeo->city); 
	$mycountry = epi_escape_string($mygeo->country_name);
	$mycountrycode = epi_escape_string($mygeo->country_code);
	$browser = new Browser();
	$v_browser = $browser->getBrowser();
	$v_platform = $browser->getPlatform();
	$v_version = $browser->getVersion();
	@$insert_sql = "INSERT INTO pd_analytics (v_remote_addr,v_ipaddr,v_datetime,v_referer,v_language,v_http_cookie,v_useragent,v_browser,v_platform,v_version,v_city,v_country,v_countrycode) VALUES ('{$_SERVER['REMOTE_ADDR']}','{$_SERVER['HTTP_X_REAL_IP']}',NOW(),'{$_SERVER['HTTP_REFERER']}','{$_SERVER['HTTP_ACCEPT_LANGUAGE']}','{$_SERVER['HTTP_COOKIE']}','{$_SERVER['HTTP_USER_AGENT']}','{$v_browser}','{$v_platform}','{$v_version}',{$mycity},{$mycountry},{$mycountrycode})";
	if (!isset($_SESSION['VisitorInfo'])) {
		$analytics = @ew_Execute($insert_sql);
		$_SESSION['VisitorInfo'] = $sessionid;
	}
}

function epi_mapBox($data = false, $height = 250, $marker = false, $title = "Visitors", $style = "light-blue") {
	if ($marker) {
		$geoip = geoiparray(ew_CurrentUserIP());
		$latitude = $geoip->latitude;
		$longitude = $geoip->longitude;
	}
	$html = '
	<link rel="stylesheet" href="adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<div class="box box-solid bg-'.$style.'-gradient">
	<div class="box-header">
		<div class="pull-right box-tools">
		<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
		<i class="fa fa-minus"></i></button>
		</div>
		<i class="fa fa-map-marker"></i>
		<h3 class="box-title">'.$title.'</h3>
	</div>
	<div class="box-body">
	<div id="world-map" style="height: '.$height.'px; width: 100%;"></div>
	</div>
	</div>
	<script src="adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script>';
	if (empty($data)) {
		$html.='	  var visitorsData = {
		"US": 398, //USA
		"SA": 400, //Saudi Arabia
		"CA": 1000, //Canada
		"DE": 500, //Germany
		"FR": 760, //France
		"CN": 300, //China
		"AU": 700, //Australia
		"BR": 600, //Brazil
		"IN": 800, //India
		"GB": 320, //Great Britain
		"RU": 3000 //Russia
  	};';
		} else {
	$visitors = array();
		foreach ($data as $key=>$value) {
			array_push($visitors,array($value['ccode']=>$value['visits']));
		}
		$result = call_user_func_array('array_merge', $visitors);
		$html.=' var visitorsData = ' . json_encode($result);
	}
	$html.= ';
	//World map by jvectormap
	$("#world-map").vectorMap({
		map: "world_mill_en",
		backgroundColor: "transparent",';
		if ($marker) {
			$html.= '
			markerStyle: {initial: {fill: "#F8E23B",stroke: "#383f47"}},
			markers: [{latLng: ['.$latitude.','.$longitude.'], name: "You Are Here!"}],';
		}
		$html.=	'
		regionStyle: {
			initial: {
				fill: "#e4e4e4",
				"fill-opacity": 1,
				stroke: "none",
				"stroke-width": 0,
				"stroke-opacity": 1
				}
			},
			series: {
				regions: [{
					values: visitorsData,
					scale: ["#92c1dc", "#ebf4f9"],
					normalizeFunction: "polynomial"
					}]
				},
			onRegionLabelShow: function (e, el, code) {
				if (typeof visitorsData[code] != "undefined")
				el.html(el.html() + ": " + visitorsData[code] + " new visitors");
			}
		});
	</script>';
	return $html;
}

function epi_carousel($table_field,$image_field,$caption_field,$order_field = false, $title = "Carousel") {
	$page_obj = Page($table_field);
	$imgpath = (!empty($page_obj->$image_field->UploadPath)) ? $page_obj->$image_field->UploadPath : EW_UPLOAD_DEST_PATH;
	$order = (!empty($order_field)) ? " ORDER BY $order_field ASC" : '';
	$slides = epi_GetAll("SELECT * FROM $table_field $order");
	$count = count($slides);
	$html = '
	<div class="box box-solid">
	<div class="box-header with-border">
	<h3 class="box-title">'.$title.'</h3>
	</div>
	<div class="box-body">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">';
	foreach ($slides as $key=>$slide) {
		$class = ($key == 0) ? 'active' : ''; 
		$html.= '<li data-target="#carousel-example-generic" data-slide-to="'.$key.'" class="'.$class.'"></li>';
	}
	$html.= '</ol>
	<div class="carousel-inner">';
	foreach ($slides as $key=>$slide) {
		$class = ($key == 0) ? 'active' : '';
		$html .= '
		<div class="item '.$class.'">
		<img src="'.$imgpath.$slide[$image_field].'" alt="'.$slide[$caption_field].'">
		<div class="carousel-caption">'.$slide[$caption_field].'</div>
		</div>';
	}
	$html .= '</div>
	<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
	<span class="fa fa-angle-left"></span>
	</a>
	<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
	<span class="fa fa-angle-right"></span>
	</a>
	</div>
	</div>
	</div>';
	return $html;
}

function epi_latestMembers($avatar_folder, $users_table, $activated_field, $date_field, $title = "Latest Members", $limit = 8){
	$newmembers_sql = "SELECT * FROM $users_table WHERE $activated_field = 1 ORDER BY $date_field DESC LIMIT $limit";
	$newmembers = epi_GetAll($newmembers_sql);
	$html = '
	<div class="box box-danger">
		<div class="box-header with-border">
		<h3 class="box-title">'.$title.'</h3>
		<div class="box-tools pull-right">
		<span class="label label-danger">'.count($newmembers).' '.$title.'</span>
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body no-padding">
	<ul class="users-list clearfix">';
	foreach ($newmembers as $key=>$member){
		$name = !empty($member['pd_nickname']) ? $member['pd_nickname'] : $member['pd_username'];
		$html.= '<li>';
		if (!empty($member['pd_avatar'])) {
		$html.= '<img src="'.ew_UploadPathEx(FALSE,$avatar_folder).$member['pd_avatar'].'" alt="'.$name.'" style = "width:96px;height:96px;object-fit:cover;">';
		} else {
		$html.= '<i class="fa fa-4x fa-user-secret" style="width:96px;height:96px;object-fit:cover;"></i>';
		}
		$html.= '<a class="users-list-name" href="#">'.$name.'</a>
		<span class="users-list-date">'.time_elapsed_string($member[$date_field]).'</span>
		</li>';
	}
	$html.= '
	</ul></div>
	<div class="box-footer text-center"><a href="'.$users_table.'list.php" class="uppercase">View All Users</a></div>
	</div>';
	return $html;
}

// META tags

function epi_addMetaTag($name,$content){
	$html = '<meta name="'.$name.'" content="'.$content.'">'.PHP_EOL;
	return $html;
}

function epi_editTitleTag($title){
	global $Language;
	$Language->Phrases['ew-language']['project']['phrase']['bodytitle']['attr']['value'] = $title;
}

// Widget Boxes

function epi_closeableBox($title, $body, $type){
	$html ='
	<div class="box box-'.$type.'">
	<div class="box-header with-border">
	<h3 class="box-title">'.$title.'</h3>
	<div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	</div>
	</div>
	<div class="box-body">'.$body.'</div>
	</div>';
	return $html;
}

function epi_alert($title, $body, $type, $align = 'full'){
	switch ($type) {
		case 'success': $icon = 'icon fa fa-check'; break;
		case 'warning': $icon = 'icon fa fa-warning'; break;
		case 'info': $icon = 'icon fa fa-info'; break;
		case 'danger': $icon = 'icon fa fa-ban'; break;
		default: $icon = 'icon fa fa-check'; break;
	}
	switch ($align) {
		case 'full': $div_class = 'col-xs-12'; break;
		case 'right': $div_class = 'col-md-4 pull-right'; break;
		case 'left': $div_class = 'col-md-4 pull-left'; break;
		default: $div_class = 'col-xs-12'; break;
	}
	$html = '
	<div class="row"><div class="'.$div_class.' ">
	<div class="alert alert-'.$type.' alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="'.$icon.'"></i> '.$title.'</h4>
	'.$body.'
	</div></div></div>';
	return $html;
}

function epi_helpBox($title, $content, $align = false, $width = 6) {
	if (empty($title) || empty($content)) return false;
	$pull = !empty($align) ? ' pull-'.$align : ' '; 
	$html = '
	<div class = "col-xs-12 col-md-'.$width.$pull.'">
	<div class="box box-default collapsed-box">
	<div class="box-header with-border">
	<h3 class="box-title">'.$title.'</h3>
	<div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	</div>
	</div>
	<div class="box-body" style="">'.$content.'</div>
	</div>
	</div>
	<div class = "clearfix"></div>';
	return $html;
}

function epi_downloadBox($link,$meta_array,$description,$style) {
	$html = '
	<div class="small-box bg-'.$style.'">
	<div class="inner">
		<span class="info-box-text">'.$description.'</span>
		<p>' . date("M d, Y g:ia", strtotime($meta_array["lastmod"])) .'</p>
	</div>
	<div class="icon">
		<i class="ion ion-android-archive"></i>
	</div>';
	if (IsSysAdmin()) { 
		$html.= '<a href="'.$link.'" class="small-box-footer">Download Now ('.$meta_array["filesize"].') <i class="fa fa-arrow-circle-right"></i></a>';
	} else { 
		$html.= '<div class = "small-box-footer">Only SysAdmin can download!</div>';
	}
	$html.= '</div>';
	return $html;
}

function epi_custDownloadBox($link,$meta_array,$description,$style,$condition = false) {
	$html = '
	<div class="small-box bg-'.$style.'">
	<div class="inner">
		<span class="info-box-text">'.$description.'</span>
		<p>' . date("M d, Y g:ia", strtotime($meta_array["lastmod"])) .'</p>
	</div>
	<div class="icon">
		<i class="ion ion-android-archive"></i>
	</div>';
	if ($condition || IsSysAdmin()) {  // condition must be evaluated prior to function call, false by default
		$html.= '<a href="'.$link.'" class="small-box-footer">Download Now ('.$meta_array["filesize"].') <i class="fa fa-arrow-circle-right"></i></a>';
	} else { 
		$html.= '<div class = "small-box-footer">Insufficient access to download!</div>';
	}
	$html.= '</div>';
	return $html;
}

// Programmatically send a message

function epi_addMessage($fromid, $toid, $msg) {
	if (empty($fromid) || empty($toid) || empty($msg)) {
		error_log("Unable to epi_addMessage."); 
		return false;
	} else {
		$safe_msg = strip_tags($msg, "<b>,<p>,<br>,<h3>,<strong>,<em>,<u>");
		$addmsg = ew_Execute("INSERT INTO pd_messages (m_fromid, m_toid, m_content, m_datetime) VALUES ($fromid, $toid, '".$safe_msg."', NOW())");
	}
}
function epi_addNotification($targetlevel, $msg) {
	if (empty($targetlevel) || empty($msg)) {
		error_log("Unable to epi_addNotification."); 
		return false;
	} else {
		$safe_msg = strip_tags($msg, "<b>,<p>,<br>,<h3>,<strong>,<em>,<u>");
		$addnote = ew_Execute("INSERT INTO pd_notifications (n_targetlevel, n_content, n_datetime) VALUES ($targetlevel, '".$safe_msg."', NOW())");
	}
}
function epi_addTask($title, $completion, $urgency, $order) {
	if (empty($title) || empty($completion) || empty($urgency) || empty($order)) {
		error_log("Unable to epi_addTask."); 
		return false;
	} else {
		$safe_msg = strip_tags($msg, "<b>,<p>,<br>,<h3>,<strong>,<em>,<u>");
		$addtask = ew_Execute("INSERT INTO pd_tasks (t_title, t_completion, t_urgency, t_order) VALUES ('".$safe_msg."', $completion, $urgency, $order)");
	}
}

// Timeline Functions

function epi_renderTimeline($table, $fldid, $flddatetime, $fldtitle, $fldtype, $fldcontent, $fldactive, $fldowner, $fldtargetlevel) {
	$currentUserId = IsLoggedIn() ? CurrentUserID() : -2;
	if (CurrentUserID() == null) 
	if (empty($table) || empty($fldid) || empty($flddatetime) || empty($fldtitle) || empty($fldtype) || empty($fldcontent) || empty($fldactive)) return false;
	$timeline_sql = "
	SELECT $fldid AS tlid, $flddatetime AS tlda, $fldtitle AS tlti, $fldtype as tlty, $fldcontent AS tlco, $fldowner AS tlow, $fldtargetlevel as tltr
	FROM $table 
	WHERE $fldactive = 1
	AND ($fldowner = $currentUserId OR FIND_IN_SET(".CurrentUserLevel().",$fldtargetlevel)) 
	ORDER BY $flddatetime DESC";
	$timeline = epi_GetAll($timeline_sql);
	if (empty($timeline)) error_log("Error in Timeline SQL: " . $timeline_sql);
	$html = '<div class="row"><div class="col-md-12"><ul class="timeline">';
	$currentDate = 0; 
	foreach ($timeline as $key=>$event) {
		if (date("y-m-d",strtotime($event['tlda'])) <> date("y-m-d",strtotime($currentDate))) {
			$html.= epi_renderTimelineDate($event['tlda']);
			$currentDate = date("y-m-d", strtotime($event['tlda']));
			}
		$event['table'] = $table;
		$html.= epi_renderTimelineItem($event);
	}
	$html.='<li><i class="fa fa-clock-o bg-gray"></i></li></ul></div></div>';
	return $html;
}

function epi_renderTimelineDate($time){
	$html = '<li class="time-label"><span class="bg-red">'.date("M d Y",strtotime($time)).'</span></li>';
	return $html;
}

function epi_renderTimelineItem($item){
	global $Language;
	$html = '<li><i class="';
	$html.= epi_timelineIcon($item['tlty']);
	$html.= '"></i><div class="timeline-item">
	<span class="time"><i class="fa fa-clock-o"></i>';
	$html.= date("h:i a", strtotime($item['tlda']));
	$html.= '</span>
	<h3 class="timeline-header">'.$item['tlti'].'</h3>
	<div class="timeline-body">'.$item['tlco'].'</div>
	<div class="timeline-footer">
	<a class="btn btn-primary btn-xs" href="#">'.$Language->Phrase("ViewLink").$Language->Phrase("View").'</a>';
	if (IsSysAdmin() || $item['tlow'] == CurrentUserID()) {
		$html.= '
		<a class="btn btn-warning btn-xs" href="'.$item['table'].'edit.php?cl_id='.$item['tlid'].'">'.$Language->Phrase("EditLink").$Language->Phrase("Edit").'</a>
		<a class="btn btn-danger btn-xs" href="'.$item['table'].'delete.php?cl_id='.$item['tlid'].'">'.$Language->Phrase("DeleteLink").$Language->Phrase("Delete").'</a>';
		}
	$html.='</div></div></li>';
	return $html;
}

function epi_timelineIcon($type){
	$class = 'fa ';
	switch ($type) {
		case 1: $class.= 'fa-video-camera bg-maroon'; break;
		case 2: $class.= 'fa-camera bg-purple'; break;
		case 3: $class.= 'fa-comments bg-yellow'; break;
		case 4: $class.= 'fa-user bg-aqua'; break;
		case 5: $class.= 'fa-envelope bg-blue'; break;
		case 6: $class.= 'fa-wrench bg-orange'; break;
		case 7: $class.= 'fa-star bg-green'; break;
		case 8: $class.= 'fa-trash bg-red'; break;
		case 9: $class.= 'fa-exchange bg-yellow'; break;
		default : $class.= 'fa-clock-o bg-gray'; break;
	}
	return $class;
}

function epi_tagsinput($field_id) {
	$html = "<script>
$(document).ready(function(){ 
	$('input#".$field_id."').addClass('tagsinput').attr('data-role','tagsinput');
});
</script>";
	return $html;
}

function epi_sessionTimer() {
	if (EW_SESSION_TIMEOUT > 0) {
		$timeout = EW_SESSION_TIMEOUT * 60; 	
	} else {
		$timeout = ini_get('session.gc_maxlifetime');
	}
	$html = '<script src="epi/js/jquery.knob.min.js"></script>';
	$html.= '<script>
	$.fn.timer = function( userdefinedoptions ){ 
    	var $this = $(this), opt, count = 0; 
		opt = $.extend( { 
		// Config 
        "timer" : '.$timeout.', // 300 second default
        "width" : 28 ,
        "height" : 28 ,
        "bgColor" : "rgba(255,255,255,0.15)" ,
        "fgColor" : "rgba(255,255,255,0.85)"
        }, userdefinedoptions 
    ); 
    $this.knob({ 
        "min":0, 
        "max": opt.timer, 
        "readOnly": true, 
        "width": opt.width, 
        "height": opt.height, 
        "fgColor": opt.fgColor, 
        "bgColor": opt.bgColor,                 
        "displayInput" : false, 
        "dynamicDraw": false, 
        "ticks": 0, 
        "thickness": 0.6,
		"format" : function (value) {
    		return (Math.ceil(value/60) + "m");
		}
    }); 
    setInterval(function(){ 
        newVal = ++count; 
        $this.val(newVal).trigger("change"); 
    }, 1000); 
};
$("#epi_sessionTimer").timer();
</script>';
	return $html;
}
?>