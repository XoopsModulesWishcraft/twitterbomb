<?php


function xoops_module_update_twitterbomb(&$module) {
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `type` ENUM('bomb','scheduler') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` ADD COLUMN `pregmatch_replace` VARCHAR(500) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `type` ENUM('bomb','secheduler') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `source_nick` VARCHAR(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `tweeted` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `tags` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `cid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `catid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `rank` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` CHANGE COLUMN `provider` `provider` ENUM('bomb', 'scheduler') DEFAULT 'bomb'";
	
	
$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` (
  `sid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT(13) UNSIGNED DEFAULT '0', 
  `catid` INT(13) UNSIGNED DEFAULT '0', 
  `mode` ENUM('direct','filtered','pregmatch','strip','pregmatchstrip','strippregmatch','filteredstrip','stripfiltered','filteredpregmatch','pregmatchfiltered','filteredpregmatchstrip','filteredstrippregmatch','pregmatchfilteredstrip','pregmatchstripfiltered','strippregmatchfiltered','stripfilteredpregmatch','mirc') DEFAULT 'direct',
  `pre` VARCHAR(35) DEFAULT NULL,
  `text` VARCHAR(500) DEFAULT NULL,
  `search` VARCHAR(1000) DEFAULT NULL,
  `replace` VARCHAR(1000) DEFAULT NULL,
  `strip` VARCHAR(1000) DEFAULT NULL,
  `pregmatch` VARCHAR(500) DEFAULT NULL,
  `pregmatch_replace` VARCHAR(500) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `hits` INT(13) UNSIGNED DEFAULT '0', 
  `rank` INT(13) UNSIGNED DEFAULT '0',
  `when` INT(13) UNSIGNED DEFAULT '0', 
  `tweeted` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0', 
  PRIMARY KEY (`sid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` (	
  `lid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` ENUM('bomb', 'scheduler') DEFAULT 'bomb',
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `sid` INT(13) UNSIGNED DEFAULT '0',
  `alias` VARCHAR(64) DEFAULT NULL,
  `tweet` VARCHAR(140) DEFAULT NULL,
  `url` VARCHAR(500) DEFAULT NULL,
  `date` INT(13) UNSIGNED DEFAULT '0',
  `cid` INT(13) UNSIGNED DEFAULT '0',
  `catid` INT(13) UNSIGNED DEFAULT '0',
  `hits` INT(13) UNSIGNED DEFAULT '0',
  `rank` INT(13) UNSIGNED DEFAULT '0',
  `active` INT(13) UNSIGNED DEFAULT '0',
  `tags` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	foreach($sql as $id => $question)
		if ($GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'SQL Executed Successfully!!!');
			
	return true;
	
}

?>