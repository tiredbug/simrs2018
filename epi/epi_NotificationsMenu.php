<?php
function epi_retrieve_notifications() {
	$target_level = CurrentUserLevel();
	$na_sql = "SELECT n_id, n_datetime, n_content, n_targetlevel FROM pd_notifications WHERE n_targetlevel = $target_level ORDER BY n_datetime DESC";
	if ($nas = epi_GetAll($na_sql)) {
		return $nas;
	} else {
		return array();
	}
}
$notifications_array = epi_retrieve_notifications();
$count_notifications = count($notifications_array);
$notifications_link = "pd_notificationslist.php";
$notification_link = "pd_notificationsview.php";
?>
<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-bell-o"></i>
<?php if ($count_notifications > 0) { ?>
	<span class="label label-warning"><?php echo $count_notifications; ?></span>
<?php } ?>
</a>
<ul class="dropdown-menu">
    <li class="header">You have <?php echo $count_notifications; ?> notifications</li>
    <li>
    <ul class="menu">
    <?php if (!empty($notifications_array)) foreach ($notifications_array as $key=>$notification) { ?>
    <li>
    <a href="<?php echo $notification_link; ?>?n_id=<?php echo $notification['n_id']; ?>">
    <i class="fa fa-users text-aqua"></i> <?php echo $notification['n_content']; ?>
    </a>
    </li>
    <?php } ?>
    </ul>
    </li>
    <li class="footer"><a href="<?php echo $notifications_link; ?>">View all</a></li>
</ul>
</li>