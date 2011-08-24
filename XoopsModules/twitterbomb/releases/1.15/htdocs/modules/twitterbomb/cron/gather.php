<?php

require_once('../../../mainfile.php');

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$xoModule = $module_handler->getByDirname('twitterbomb');
$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));

$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 30;
 
if ($xoConfig['cron_gather']) {
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
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
	
	if (!$oids = XoopsCache::read('twitterbomb_oids_cron')) {
		$criteria = new CriteriaCompo(new Criteria('1', '1'));
	} else {
		$criteria = new CriteriaCompo(new Criteria('oid', '('.implode(',', $oids).')', 'IN'));
	}
	$criteria->setOrder('DESC');
	$criteria->setSort('RAND()');
	$oauths = $oauth_handler->getObjects($criteria, true);
	foreach($oauths as $oid => $oauth) {
		$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 120;
		set_time_limit($GLOBALS['execution_time']);
		if ($oauth->getVar('friends')<time()&&$xoConfig['look_for_friends']>0) {
			if ($oauth->getVar('id') == 0) {
				if ($user = $oauth->getUsers($oauth->getVar('username'), 'screen_name')) {
					$oauth->setVar('id', $user[$oauth->getVar('username')]['id']);
					$oauth_handler->insert($oauth, true);
				}		
			}
			if ($ids = $oauth->getFriends($oauth->getVar('id'))) {
				foreach($ids as $id) {
					if ($following_handler->getCount(new Criteria('flid', $id))==0) {
						$flid[$id] = $id;
					}
				}
				if (count($flid)>0) {
					$users = $oauth->getUsers($flid);
					foreach($users as $key => $user) {
						$follow = $following_handler->create();
						$follow->setVar('id', $oauth->getVar('id'));
						$follow->setVar('flid', $user['id']);
						$following_handler->insert($follow, true);
						$username = $usernames_handler->create();
						$username->setVar('screen_name', $user['screen_name']);
						$username->setVar('id', $user['id']);		
						$username->setVar('avarta', $user['profile_image_url']);
						$username->setVar('name', $user['name']);
						$username->setVar('description', $user['description']);
						$username->setVar('type' ,'bomb');
						$usernames_handler->insert($username, true);
						echo 'Found: '.$user['screen_name'].'\n';
					}	
				}
			}
			$oauth->setFriendsTimer();
		} else {
			$oids[$oid] = $oid;
		}
		 
		if ($oauth->getVar('mentions')<time()&&$xoConfig['look_for_mention']>0) {
			$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 120;
			set_time_limit($GLOBALS['execution_time']);
			if ($oauth->getVar('id') == 0) {
				if ($user = $oauth->getUsers($oauth->getVar('username'), 'screen_name')) {
					$oauth->setVar('id', $user[$oauth->getVar('username')]['id']);
					$oauth_handler->insert($oauth, true);
				}		
			}
			if ($mentions = $oauth->getMentions($oauth->getVar('id'))) {
				foreach($mentions as $mention) {
					$ids[$mention['user']['id']] = $mention['user']['id'];
				}		
				foreach($ids as $id) {
					if ($following_handler->getCount(new Criteria('flid', $id))==0) {
						$flid[$id] = $id;
					}
				}
				if (count($flid)>0) {
					$users = $oauth->getUsers($flid);
					foreach($users as $key => $user) {
						$follow = $following_handler->create();
						$follow->setVar('id', $oauth->getVar('id'));
						$follow->setVar('flid', $user['id']);
						$following_handler->insert($follow);
						$username = $usernames_handler->create();
						$username->setVar('screen_name', $user['screen_name']);
						$username->setVar('id', $user['id']);		
						$username->setVar('avarta', $user['profile_image_url']);
						$username->setVar('name', $user['name']);
						$username->setVar('description', $user['description']);
						$username->setVar('type' ,'bomb');
						$usernames_handler->insert($username, true);
						echo 'Found: '.$user['screen_name'].'\n';
					}	
				}
			}
			$oauth->setMentionsTimer();
		} else {
			$oids[$oid] = $oid;
		}
	}
	if (count($oids)==0) {
		XoopsCache::delete('twitterbomb_oids_cron');
	} else {
		XoopsCache::write('twitterbomb_oids_cron', $oids);
	}
	
	@$oauth = $oauth_handler->getRootOauth(true);
	$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 120;
	set_time_limit($GLOBALS['execution_time']);

	$criteria = new Criteria('indexed', time(), '<=');
	$criteria->setLimit($xoConfig['gather_per_session']);
	$usernames = $usernames_handler->getObjects($criteria, true);
	foreach($usernames as $uid => $username) {
		$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 60;
		set_time_limit($GLOBALS['execution_time']);
		if ($username->getVar('id') == 0) {
			$user = $oauth->getUsers($username->getVar('screen_name'), 'screen_name');
			$oauth->getVar('id', $user['id']);
			$username->setVar('id', $user['id']);		
			$username->setVar('avarta', $user['profile_image_url']);
			$username->setVar('name', $user['name']);
			$username->setVar('description', $user['description']);
			$usernames_handler->insert($username, true);		
		}
		if ($ids = $oauth->getFriends($username->getVar('id'))) {
			foreach($ids as $id) {
				if ($following_handler->getCount(new Criteria('flid', $id))==0&&$usernames_handler->getCount(new Criteria('id', $id))==0) {
					$flid[$id] = $id;
				}
			}
			if (count($flid)>0) {
				$users = $oauth->getUsers($flid);
				foreach($users as $key => $user) {
					$follow = $following_handler->create();
					$follow->setVar('id', $username->getVar('id'));
					$follow->setVar('flid', $user['id']);
					$following_handler->insert($follow);
					$usernam = $usernames_handler->create();
					$usernam->setVar('screen_name', $user['screen_name']);
					$usernam->setVar('id', $user['id']);		
					$usernam->setVar('avarta', $user['profile_image_url']);
					$usernam->setVar('name', $user['name']);
					$usernam->setVar('description', $user['description']);
					$usernam->setVar('type' ,'bomb');
					echo 'Found: '.$user['screen_name'].'\n';
					$usernames_handler->insert($usernam, true);
				}	
			}
		}
		$username->setVar('indexed', time()+$xoConfig['look_for_friends']);
		$usernames_handler->insert($username, true);
	}
}
?>