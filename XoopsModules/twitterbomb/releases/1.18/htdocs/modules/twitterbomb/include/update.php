<?php


function xoops_module_update_twitterbomb(&$module) {
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `type` ENUM('bomb','scheduler') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_campaign')."` ADD COLUMN `cron` INT(13) UNSIGNED DEFAULT '0'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_category')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_scheduler')."` ADD COLUMN `pregmatch_replace` VARCHAR(500) DEFAULT NULL";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `type` ENUM('bomb','secheduler') DEFAULT 'bomb'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `source_nick` VARCHAR(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `tweeted` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `id` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `avarta` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `name` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `description` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `indexed` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `followed` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `actioned` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` ADD COLUMN `oid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_usernames')."` CHANGE COLUMN `twitter_username` `screen_name` VARCHAR(64) DEFAULT NULL";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `oid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `tid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `id` VARCHAR(128) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `tags` VARCHAR(255) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `cid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `catid` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `hits` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `rank` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` ADD COLUMN `active` INT(13) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_log')."` CHANGE COLUMN `provider` `provider` ENUM('bomb', 'scheduler') DEFAULT 'bomb'";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base1` `base1` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base2` `base2` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base3` `base3` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base4` `base4` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base5` `base5` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base6` `base6` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_base_matrix')."` CHANGE COLUMN `base7` `base7` ENUM('for','when','clause','then','over','under','their','there','trend','') DEFAULT ''";
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` ADD COLUMN `id` VARCHAR(255) DEFAULT '0'";
	
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
  `oid` INT(13) UNSIGNED DEFAULT '0',
  `tid` INT(13) UNSIGNED DEFAULT '0',
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
  `id` VARCHAR(128) DEFAULT NULL, 
  PRIMARY KEY (`lid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_oauth')."` (
  `oid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cids` VARCHAR(1000) DEFAULT NULL, 
  `catids` VARCHAR(1000) DEFAULT NULL, 
  `mode` ENUM('valid','invalid','expired','disabled','other') DEFAULT NULL,
  `consumer_key` VARCHAR(255) DEFAULT NULL,
  `consumer_secret` VARCHAR(255) DEFAULT NULL,
  `oauth_token` VARCHAR(255) DEFAULT NULL,
  `oauth_token_secret` VARCHAR(255) DEFAULT NULL,
  `username` VARCHAR(64) DEFAULT NULL,
  `ip` VARCHAR(64) DEFAULT NULL,
  `id` VARCHAR(255) DEFAULT '0',
  `netbios` VARCHAR(255) DEFAULT NULL,
  `uid` INT(13) UNSIGNED DEFAULT '0', 
  `created` INT(13) UNSIGNED DEFAULT '0', 
  `actioned` INT(13) UNSIGNED DEFAULT '0', 
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `tweeted` INT(13) UNSIGNED DEFAULT '0',  
  `tweets` INT(13) UNSIGNED DEFAULT '0',  
  `calls` INT(13) UNSIGNED DEFAULT '0',
  `remaining_hits` INT(13) UNSIGNED DEFAULT '0',
  `hourly_limit` INT(13) UNSIGNED DEFAULT '0',
  `api_resets` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`oid`)  
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('twitterbomb_following')."` (
  `fid` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id` VARCHAR(128) DEFAULT NULL,
  `flid` VARCHAR(128) DEFAULT NULL,
  `followed` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`fid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";

	foreach($sql as $id => $question)
		if ($GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'SQL Executed Successfully!!!');
			
	return true;
	
}

?>