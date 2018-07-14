<?php
global $EPI_TemplateVersion, $conn;
?>
<div class="col-xs-6 col-sm-6 text-right hidden-xs">
<div class="txt-color-white inline-block">
  <div class="btn-group dropup">
  <button class="btn btn-xs dropdown-toggle bg-color-blue txt-color-white" data-toggle="dropdown">
<i class="fa fa-link"></i> <span class="caret"></span>
</button>
<ul class="dropdown-menu pull-right text-left">
<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Server OS: <?php echo PHP_OS; ?></p>
</div>
</li>
<li class="divider"></li>
<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Server IP: <strong><?php echo $_SERVER['SERVER_ADDR']; ?></strong></p>
</div>
</li>
<li class="divider"></li>
<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Your IP: <strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong></p>
</div>
</li>
<li class="divider"></li>
<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Apache/PHP: <strong><?php echo function_exists("apache_get_version") ? apache_get_version() : phpversion(); ?></strong></p>
</div>
</li>
<li class="divider"></li>

<?php if (EW_IS_MYSQL) { ?>
<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">MySQL: <strong><?php echo isset($GLOBALS['conn']->connectionId->server_info) ? $GLOBALS['conn']->connectionId->server_info : ew_ExecuteScalar("SHOW VARIABLES LIKE '%version%';"); ?></strong></p>
</div>
</li>
<li class="divider"></li>
<?php } ?>

<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Template: <span class="text-danger"><?php echo $EPI_TemplateVersion; ?></span></p>
</div>
</li>
<li class="divider"></li>

<li>
<div style="padding:5px;">
<p class="txt-color-darken font-sm no-margin">Session Timeout: <?php echo (EW_SESSION_TIMEOUT > 0) ? EW_SESSION_TIMEOUT : ini_get('session.gc_maxlifetime') / 60; ?>m</p>
</div>
</li>

<li>
<div style="padding:5px;">
<button class="btn btn-block btn-default">Close</button>
</div>
</li>
</ul>
</div>
<!-- end btn-group-->
</div>
<!-- end div-->
</div>