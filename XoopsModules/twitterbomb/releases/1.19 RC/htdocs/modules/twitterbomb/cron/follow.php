<?php

include_once('../../../mainfile.php');

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$xoModule = $module_handler->getByDirname('twitterbomb');
$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));

if ($xoConfig['cron_follow']) {
	echo 'Follower Cron Started: '.date('Y-m-d D H:i:s', time())."\n";
	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	$campaign_handler = xoops_getmodulehandler('campaign', 'twitterbomb');
	$following_handler=&xoops_getmodulehandler('following', 'twitterbomb');
	$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
	$oauth_handler=&xoops_getmodulehandler('oauth', 'twitterbomb');
	
	$oauth = $oauth_handler->getRootOauth(true);
	
	$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 120;
	set_time_limit($GLOBALS['execution_time']);
	
	$criteria = new Criteria('followed', 0, '=');
	$criteria->setLimit($xoConfig['follow_per_session']);
	$usernames = $usernames_handler->getObjects($criteria, true);
	foreach($usernames as $uid => $username) {
		if ($username->getVar('id') == 0) {
			$user = $oauth->getUsers($username->getVar('screen_name'), 'screen_name');
			$username->setVar('id', $user['id']);		
			$username->setVar('avarta', $user['profile_image_url']);
			$username->setVar('name', $user['name']);
			$username->setVar('description', $user['description']);
			$usernames_handler->insert($username, true);		
		}
		if ($user = $oauth->createFollow($username->getVar('id'))) {
			echo 'Followed: '.$username->getVar('screen_name')."\n";
			$username->setVar('followed', time());
			$usernames_handler->insert($username, true);
		}
	}
	echo 'Follower Cron Ended: '.date('Y-m-d D H:i:s', time())."\n";
}

?>