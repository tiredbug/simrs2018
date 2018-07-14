<?php 
if (!empty($EPI_UserExt) && !empty($EPIUser_AvatarField) && !empty($EPIUser_AvatarFolder) && !empty($EPIUser_IDField) && IsloggedIn() && !IsSysAdmin()) {
	$user_array = epi_GetAll("SELECT $EPIUser_AvatarField FROM $EPIUser_Table WHERE $EPIUser_IDField = ".CurrentUserID() );
	$image_folder = ew_UploadPathEx(FALSE, $EPIUser_AvatarFolder);
	$usermenu_image_path = $image_folder.$user_array[0][$EPIUser_AvatarField];
	$usermenu_smallimage =  '<img src="'.$usermenu_image_path.'" alt="'.CurrentUserName().'" class="online img-circle" alt="User Image">';
	$usermenu_image =  '<img src="'.$usermenu_image_path.'" alt="'.CurrentUserName().'" class="user-image" alt="User Image">';
} else if (empty($EPI_UserExt)) {
	$usermenu_smallimage =  "<i class='fa fa-user' title='EPI User Extension not enabled'></i> <span></span>";
} else {
	$usermenu_smallimage =  "<i class='fa fa-user' title='Avatar fields missing'></i> <span></span>";
}
?>
<div class="user-panel">
        <div class="pull-left image">
          <?php echo $usermenu_smallimage; ?>
        </div>
        <div class="pull-left info">
          <p><?php echo CurrentUserName(); ?></br><?php echo Security()->CurrentUserLevelName(); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>