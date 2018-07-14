<?php
global $EW_LANGUAGE_FILE, $gsLanguage;
foreach ($EW_LANGUAGE_FILE as $k=>$l) { 
	if ($l[0] == $gsLanguage) {
		$langid = $l[0];
		$langLabel = $l[1];
	}
}
?>

<li class="dropdown language-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa fa-language"></i></a>
    <ul class="dropdown-menu"><?php foreach ($EW_LANGUAGE_FILE as $key=>$lang) { ?>
        <li <?php if ($gsLanguage == $lang[0]) echo 'class = \'active\''; ?>>
        <a href="?language=<?php echo $lang[0]; ?>"><?php echo $lang[1]; ?></a>
        </li>
    <?php } ?>
	</ul>
    
</li>
