<?php

require_once('../../../mainfile.php');

if ($GLOBALS['xoopsModuleConfig']['cron_follow']) {
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
	
	@$oauth = $oauth_handler->getRootOauth(true);
	
	$criteria = new Criteria('followed', 0, '=');
	$criteria->setLimit($GLOBALS['xoopsModuleConfig']['gather_per_session']);
	$usernames = $usernames_handler->getObjects($criteria, true);
	foreach($usernames as $uid => $username) {
		if ($username->getVar('id') == 0) {
			$user = $oauth->getUsers($username->getVar('screen_name'), 'screen_name');
			$oauth->getVar('id', $user['id']);
			$username->setVar('id', $user['id']);		
			$username->setVar('avarta', $user['profile_image_url']);
			$username->setVar('name', $user['name']);
			$username->setVar('description', $user['description']);
			$usernames_handler->insert($username, true);		
		}
		if ($user = $oauth->createFollow($username->getVar('id'))) {
			$username->setVar('followed', time());
			$usernames_handler->insert($username, true);
		}
	}
}
?>