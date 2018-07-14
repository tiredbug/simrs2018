<?php
function epi_retrieve_tasks() {
	$target_level = CurrentUserLevel();
	$na_sql = "SELECT t_id, t_title, t_completion, t_urgency FROM pd_tasks ORDER BY t_order ASC";
	if ($nas = epi_GetAll($na_sql)) {
		return $nas;
	} else {
		return array();
	}
}
$tasks_array = epi_retrieve_tasks();
$tasks_count = count($tasks_array);
$task_list = "pd_taskslist.php";
$task_link = "pd_tasksview.php";
?>
<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-flag-o"></i>
<?php if ($tasks_count > 0) { ?>
    <span class="label label-danger"><?php echo $tasks_count; ?></span>
<?php } ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have <?php echo $tasks_count; ?> tasks</li>
        <li>
        <ul class="menu"><?php if (!empty($tasks_array)) 
			foreach ($tasks_array as $key=>$task) { 
			$v = $task['t_completion'];
			if (($v >= 1) && ($v <= 30))
			   $task_color = "danger";
			else if (($v >= 31) && ($v <= 60))
			   $task_color = "warning";
			else if (($v >= 61) && ($v <= 99))
			   $task_color = "info";
			else if ($v >= 100)
			   $task_color = "success";
   			?>
            <li>
            <a href="<?php echo $task_link;?>?t_id=<?php echo $task['t_id'];?>">
            <h3><?php echo $task['t_title']; ?><small class="pull-right"><?php echo round($task['t_completion'],2); ?>%</small></h3>
            <div class="progress xs">
            <div class="progress-bar progress-bar-<?php echo $task_color; ?>" style="width: <?php echo round($task['t_completion'],2); ?>%" role="progressbar" aria-valuenow="<?php echo round($task['t_completion'],2); ?>" aria-valuemin="0" aria-valuemax="100">
            <span class="sr-only"><?php echo round($task['t_completion'],2); ?>% Complete</span>
            </div>
            </div>
            </a>
            </li>
        <?php } ?>
        </ul>
        </li>
        <li class="footer">
        <a href="<?php echo $task_list; ?>">View all tasks</a>
        </li>
    </ul>
</li>