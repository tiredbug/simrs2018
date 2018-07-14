<?php 
function epi_retrieve_messages() {
	if (!IsLoggedIn()) return array();
	$msg_sql = "
SELECT
  `pd_users`.pd_nickname,
  `pd_users`.pd_avatar,
  `pd_messages`.m_id,
  `pd_messages`.m_fromid,
  `pd_messages`.m_toid,
  `pd_messages`.m_datetime,
  `pd_messages`.m_content
FROM
  `pd_messages`
LEFT JOIN `pd_users` 
ON (`pd_messages`.m_fromid = `pd_users`.pd_uid)
WHERE
  `pd_messages`.m_toid = ".CurrentUserID()."
AND (`pd_messages`.m_read != 1 OR m_read IS NULL)
ORDER BY
  `pd_messages`.m_datetime DESC";
	if ($msgs = epi_GetAll($msg_sql)) {
		return $msgs;
	} else {
		return array();
	}
}
$messages_array = epi_retrieve_messages();
$messages_count = count($messages_array);
$message_link = "pd_messagesview.php";
$messages_link = "pd_messageslist.php";

if (!empty($EPI_UserExt) && !empty($EPIUser_AvatarField) && !empty($EPIUser_AvatarFolder) && !empty($EPIUser_IDField) && IsloggedIn() && !IsSysAdmin()) {
	$image_folder = ew_UploadPathEx(FALSE, $EPIUser_AvatarFolder);
}
if (IsSysAdmin() && !empty($EPIUser_AvatarFolder)) $image_folder = ew_UploadPathEx(FALSE, $EPIUser_AvatarFolder);
?>
<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <?php if ($messages_count > 0) { ?>
    	<span class="label label-success"><?php echo $messages_count; ?></span>
    <?php } ?>
    </a>
    <ul class="dropdown-menu">
    <li class="header">You have <?php echo $messages_count; ?> messages</li>
    <li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
    <?php if (!empty($messages_array)) 
	foreach ($messages_array as $key=>$message) { 
		?>
        <li><!-- start message -->
        <a href="<?php echo $message_link; ?>?m_id=<?php echo $message['m_id']; ?>">
        <div class="pull-left">
		<?php if (!empty($message['pd_avatar'])) { ?>
        	<img src="<?php echo $image_folder . $message['pd_avatar']; ?>" class="img-circle" alt="User Image">
        <?php } else { ?>
        	<i class = "fa fa-user"></i> 
        <?php } ?>
        </div>
        <h4>From: <?php echo !empty($message['pd_nickname']) ? $message['pd_nickname'] : "ID: " . $message['m_fromid']; ?>
        <small><i class="fa fa-clock-o"></i> <?php echo $message['m_datetime']; ?></small>
        </h4>
        <p><?php echo $message['m_content']; ?></p>
        </a>
        </li>
    <!-- end message -->
    <?php } ?>
    </ul>
    </li>
    <li class="footer"><a href="<?php echo $messages_link; ?>">See All Messages</a></li>
    </ul>
</li>