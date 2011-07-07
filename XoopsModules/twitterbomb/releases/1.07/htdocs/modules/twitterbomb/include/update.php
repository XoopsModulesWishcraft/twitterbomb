<?php


function xoops_module_update_twitterbomb(&$module) {
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	
	foreach($sql as $id => $question)
		if ($GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'SQL Executed Successfully!!!');
			
	return true;
	
}

?>