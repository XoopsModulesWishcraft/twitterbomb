<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

require_once('../../../mainfile.php');
if ($GLOBALS['xoopsModuleConfig']['cron_tweet']) {
	xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	$scheduler_handler=&xoops_getmodulehandler('scheduler', 'twitterbomb');
	$base_matrix_handler=&xoops_getmodulehandler('base_matrix', 'twitterbomb');
	$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
	$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
	$campaign_handler = xoops_getmodulehandler('campaign', 'twitterbomb');
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
	@$oauth = $oauth_handler->getRootOauth(true);
	if (!$cids = XoopsCache::read('twitterbomb_cids_cron')) {
		$criteria = new Criteria('1', '1');
	} else {
		$criteria = new Criteria('cid', '('.implode(',', $cids).')', 'IN');
	}
	$criteria->setOrder('DESC');
	$criteria->setSort('RAND()');
	$campaigns = $campaign_handler->getObjects($criteria, true);
	$cids=array();
	foreach($campaigns as $cid => $campaign) {
		$catid = $campaign->getVar('catid');
		if ($c<=$GLOBALS['xoopsModuleConfig']['tweets_per_session']) {
			switch($campaign->getVar('type')) {
				case "bomb":
					$items = 0;
					$ret = array();
					while($GLOBALS['xoopsModuleConfig']['items']<$items&&$c<=$GLOBALS['xoopsModuleConfig']['tweets_per_session']) {
						$sentence = $base_matrix_handler->getSentence($cid, $catid);
						$username = $usernames_handler->getUser($cid, $catid);
						$url = $urls_handler->getUrl($cid, $catid);
						if (strlen($username)>0) {
							$mtr=mt_rand(0,5);
							$tweet = (strlen($username)>0&&$mtr>2?'@'.$username.' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $GLOBALS['xoopsModuleConfig']['aggregate'], $GLOBALS['xoopsModuleConfig']['wordlength']))));
							$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
					   		$log = $log_handler->create();
					   		$log->setVar('cid', $cid);
					   		$log->setVar('catid', $catid);
					   		$log->setVar('provider', 'bomb');
					   		$log->setVar('url', $ret[$c]['link']);
					   		$log->setVar('tweet', substr($tweet,0,139));
					  		$log->setVar('tags', twitterbomb_ExtractTags($tweet));
					   		$lid = $log_handler->insert($log, true);
					   		$log = $log_handler->get($lid, true);
					   		$link = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
					   		$log->setVar('url', $link);
					   		$lid = $log_handler->insert($log, true);
					   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
						   		if ($GLOBALS['xoopsModuleConfig']['tags']) {
						   			$tag_handler = xoops_getmodulehandler('tag', 'tag');
									$tag_handler->updateByItem($log->getVar('tags'), $lid, $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
						   		}
						   		$log->setVar('id', $id);
						   		$lid = $log_handler->insert($log, true);
						   		$ret[$item]['title'] = $tweet;	  
								$ret[$item]['link'] = $link;
								$ret[$item]['description'] = (strlen($username)>0&&$mtr>2?'@'.$username.' ':'').htmlspecialchars_decode($sentence);
								$ret[$item]['lid'] = $lid;
					   		} else {
					   			$log_handler->delete($log, true);
					   		}
					   		$c++;
					   		$items++;
						}
					}
					
					break;
				case "scheduler":
					$items=0;
					$ret = array();
					while($GLOBALS['xoopsModuleConfig']['scheduler_items']>$items&&$c<=$GLOBALS['xoopsModuleConfig']['tweets_per_session']) {
						$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
						if (is_array($sentence)) {
							$url = $urls_handler->getUrl($cid, $catid);
							$tweet = str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence['tweet']), $GLOBALS['xoopsModuleConfig']['scheduler_aggregate'], $GLOBALS['xoopsModuleConfig']['scheduler_wordlength']))));	  
							$link = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
							if (strlen($tweet)!=0) {
								$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
				    			$log = $log_handler->create();
				    			$log->setVar('provider', 'scheduler');
				    			$log->setVar('cid', $cid);
				    			$log->setVar('catid', $catid);
				    			$log->setVar('sid', $ret[$c]['sid']);
				    			$log->setVar('url', $link);
				    			$log->setVar('tweet', substr($tweet,0,139));
				    			$log->setVar('tags', twitterbomb_ExtractTags($tweet));
				    			$lid = $log_handler->insert($log, true);
								$log = $log_handler->get($lid, true);
						   		$link = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
						   		$log->setVar('url', $link);
						   		$lid = $log_handler->insert($log, true);
						   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
							   		if ($GLOBALS['xoopsModuleConfig']['tags']) {
										$tag_handler = xoops_getmodulehandler('tag', 'tag');
										$tag_handler->updateByItem($log->getVar('tags'), $lid, $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
					    			}
					    			$log->setVar('id', $id);
						   			$lid = $log_handler->insert($log, true);
						   	   		$ret[$item]['title'] = $tweet;	  
									$ret[$item]['link'] = $link;
									$ret[$item]['description'] = htmlspecialchars_decode($sentence['tweet']);
									$ret[$item]['lid'] = $lid;
									$ret[$item]['sid'] = $sentence['sid'];
						   		} else {
						   			@$log_handler->delete($log, true);
						   		}
				    			$c++;
						   		$items++;
				    			
				    		}
						}
					}
					break;
			}
			XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret);
		} else {
			$cids[$cid] = $cid;
		}
	}
	
	if ($count($cids)==0) {
		XoopsCache::delete('twitterbomb_cids_cron');
	} else {
		XoopsCache::write('twitterbomb_cids_cron', $cids);
	}
}

?>