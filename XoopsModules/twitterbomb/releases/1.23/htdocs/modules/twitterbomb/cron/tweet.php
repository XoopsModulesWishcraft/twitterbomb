<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

include_once('../../../mainfile.php');
include_once(XOOPS_ROOT_PATH.'/modules/twitterbomb/include/functions.php');

if (!defined('NLB')) {
	if (!isset($_SERVER['HTTP_HOST']))
		define('NLB', "\n");
	else 
		define('NLB', "<br/>");
}

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$xoModule = $module_handler->getByDirname('twitterbomb');
$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));

if (!isset($GLOBALS['cron_run_for']))
	$GLOBALS['cron_run_for'] = ceil($xoConfig['interval_of_cron'] / (($xoConfig['cron_follow']?1:0)+($xoConfig['cron_gather']?1:0)+($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)));
$GLOBALS['cron_start'] = microtime(true);

if ($xoConfig['cron_tweet']||$xoConfig['cron_retweet']) {
	echo 'Tweeter Cron Started: '.date('Y-m-d D H:i:s', time()).NLB;
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
	$retweet_handler=&xoops_getmodulehandler('retweet', 'twitterbomb');
	
	$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
	@$oauth = $oauth_handler->getRootOauth(true);
	if (!$cids = XoopsCache::read('twitterbomb_cids_cron')) {
		$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
		$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
		$criteria_b->add(new Criteria('start', time(), '<'));
		$criteria_b->add(new Criteria('end', time(), '>'));
		$criteria = new CriteriaCompo($criteria_a);
		$criteria->add($criteria_b, 'OR');
	} else {
		XoopsCache::delete('twitterbomb_cids_cron');
		$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
		$criteria_a->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
		$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
		$criteria_b->add(new Criteria('start', time(), '<'));
		$criteria_b->add(new Criteria('end', time(), '>'));
		$criteria_b->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
		$criteria = new CriteriaCompo($criteria_a);
		$criteria->add($criteria_b, 'OR');
	}
	if ($xoConfig['cron_retweet']&&$xoConfig['cron_tweet']) {
		$criteria->add(new Criteria('`type`', '("scheduler", "bomber", "retweet")', 'IN'));
	} elseif ($xoConfig['cron_tweet']) {
		$criteria->add(new Criteria('`type`', '("scheduler", "bomber")', 'IN'));
	} elseif ($xoConfig['cron_retweet']) {
		$criteria->add(new Criteria('`type`', '("retweet")', 'IN'));		
	}
	$criteria->setOrder('ASC');
	$criteria->setSort('RAND()');
	$campaigns = $campaign_handler->getObjects($criteria, true);
	$campaignCount = $campaign_handler->getCount($criteria);
	while ($c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&$loopsb<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))*1.75&&$campaignCount>0) {
		if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
			continue;
		$loopsb++;
		$cids=array();
		foreach($campaigns as $cid => $campaign) {
			if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
				continue;
			$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 45;
			set_time_limit($GLOBALS['execution_time']);
			$catid = $campaign->getVar('catid');
			if ($c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))) {
				if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
					continue;
				$campaign->setCron();
				switch($campaign->getVar('type')) {
					case "bomb":
						$item=0;
						$items = 0;
						$loop=0;
						$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['items']))*2>$loop) {
							if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
								continue;
							$sentence = $base_matrix_handler->getSentence($cid, $catid);
							$username = $usernames_handler->getUser($cid, $catid);
							$url = $urls_handler->getUrl($cid, $catid);
							$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence);
							if (strlen($sentence)>0) {
								$mtr=mt_rand($xoConfig['odds_lower'],$xoConfig['odds_higher']);
								$tweet = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').(strlen($username)>0&&($mtr<=$xoConfig['odds_minimum']||$mtr>=$xoConfig['odds_maximum'])?'@'.$username.' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $xoConfig['aggregate'], $xoConfig['wordlength']))));
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
						   		$link = twitterbomb_shortenurl($link);
						   		$log->setVar('url', $link);
						   		$log = $log_handler->get($lid = $log_handler->insert($log, true));
						   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
						   			echo 'Tweet Sent: '.$tweet.' - '.$link.NLB;
							   		if ($xoConfig['tags']) {
							   			$tag_handler = xoops_getmodulehandler('tag', 'tag');
										$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $xoModule->getVar("dirname"), $catid);
							   		}
							   		$log->setVar('id', $id);
							   		$lid = $log_handler->insert($log, true);
							   		$ret[]['title'] = $tweet;	  
									$ret[sizeof($ret)]['link'] = $link;
									$ret[sizeof($ret)]['description'] = (strlen($username)>0&&($mtr<=$xoConfig['odds_minimum']||$mtr>=$xoConfig['odds_maximum'])?'@'.$username.' ':'').htmlspecialchars_decode($sentence);
									$ret[sizeof($ret)]['lid'] = $lid;
									$item++;
						   		} else {
						   			echo 'Tweet Failed: '.$tweet.' - '.$link.NLB;
						   			$log_handler->delete($log, true);
						   			$loop = (((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['items']))*2+1;
						   			$c=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))+1;
						   			continue;
						   		}
						   		$c++;
						   		$items++;
						   		
							}
							$loop++;
						}
						if (count($ret)>$xoConfig['items']) {
							foreach($ret as $key => $value) {
								if (count($ret)>$xoConfig['items'])
									unset($ret[$key]);
							}
						}	
						XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $xoConfig['interval_of_cron']+$xoConfig['cache']);
						break;
					case "scheduler":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['scheduler_items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['scheduler_items']))*2>$loop) {
							if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
								continue;
							$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
							if (is_array($sentence)) {
								$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence['tweet']);
								$url = $urls_handler->getUrl($cid, $catid);
								$tweet = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence['tweet']), $xoConfig['scheduler_aggregate'], $xoConfig['scheduler_wordlength']))));	  
								$link = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$tweet))));
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
							   		$link = twitterbomb_shortenurl($link);
							   		$log->setVar('url', $link);
							   		$log = $log_handler->get($lid = $log_handler->insert($log, true));
							   		if ($id = $oauth->sendTweet($tweet, $link, true)) {
							   			echo 'Tweet Sent: '.$tweet.' - '.$link.NLB;
								   		if ($xoConfig['tags']) {
											$tag_handler = xoops_getmodulehandler('tag', 'tag');
											$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $xoModule->getVar("dirname"), $catid);
						    			}
						    			$log->setVar('id', $id);
							   			$lid = $log_handler->insert($log, true);
							   	   		$ret[]['title'] = $tweet;	  
										$ret[sizeof($ret)]['link'] = $link;
										$ret[sizeof($ret)]['description'] = htmlspecialchars_decode($sentence['tweet']);
										$ret[sizeof($ret)]['lid'] = $lid;
										$ret[sizeof($ret)]['sid'] = $sentence['sid'];
										$item++;
							   		} else {
							   			echo 'Tweet Failed: '.$tweet.' - '.$link.NLB;
							   			$scheduler = $scheduler_handler->get($sentence['sid']);
							   			if (is_object($scheduler)) {
							   				$scheduler->setVar('when', 0);
							   				$scheduler_handler->insert($scheduler);
							   			}
							   			@$log_handler->delete($log, true);
							   			$loop = (((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['scheduler_items']))*2+1;
							   			$c=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))+1;
							   			continue;
							   		}
					    			$c++;
							   		$items++;
					    			
					    		}
							}
							
							$loop++;
						
						}
						if (count($ret)>$xoConfig['scheduler_items']) {
							foreach($ret as $key => $value) {
								if (count($ret)>$xoConfig['scheduler_items'])
									unset($ret[$key]);
							}
						}						
						XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $xoConfig['interval_of_cron']+$xoConfig['scheduler_cache']);
						break;
					case "retweet":
						$items=0;
						$loop=0;
						$item=0;
						$ret = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid));
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['retweet_items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['retweet_items']))*2>$loop) {
							if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
								continue;
							$search = $retweet_handler->doSearchForTweet($cid, $catid, $campaign->getVar('rids'));
							if (is_array($search)) {
								foreach ($search as $rid => $results) {
									if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
										continue;
									if (!empty($results)) {
										foreach($results as $id => $tweet) {
											if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
												continue;
											if (is_array($tweet)) {
												$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
												$criteria = new Criteria('id', $id);
												if ($log_handler->getCount($criteria)==0) {
									    			$log = $log_handler->create();
									    			$log->setVar('provider', 'retweet');
									    			$log->setVar('cid', $cid);
									    			$log->setVar('catid', $catid);
									    			$log->setVar('alias', '@'.$tweet['from_user']);
									    			$log->setVar('rid', $rid);
									    			$log->setVar('id', $id);
									    			$log->setVar('url', '');
									    			$log->setVar('tweet', substr($tweet['text'],0,140));
									    			$log->setVar('tags', twitterbomb_ExtractTags($tweet['text']));
													$log = $log_handler->get($lid = $log_handler->insert($log, true));
											   		if ($retweet = $oauth->sendRetweet($id, true)) {
											   			$retweet_handler->setReweeted($rid);
											   			echo 'Retweet Sent: '.$id.' - '.$tweet['text'].NLB;
												   		if ($xoConfig['tags']) {
															$tag_handler = xoops_getmodulehandler('tag', 'tag');
															$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet['text']), $lid, $xoModule->getVar("dirname"), $catid);
										    			}
										    			$url = $urls_handler->getUrl($cid, $catid);
										    			$link = XOOPS_URL.'/modules/twitterbomb/go.php?rid='.$rid.'&cid='.$cid.'&lid='.$lid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$tweet['text']))));
											   			
										    			$criteria = new Criteria('`screen_name`', $tweet['from_user']);
										    			if ($usernames_handler->getCount($criteria)==0) {
										    				$username = $usernames_handler->create();
										    				$username->setVar('screen_name', $tweet['from_user']);
										    				$username->setVar('type' , 'bomb');
										    				$tid = $usernames_handler->insert($username,  true);
										    			} else {
										    				$usernames = $usernames_handler->getObjects($criteria, false);
										    				if (is_object($usernames[0]))
										    					$tid = $usernames[0]->getVar('tid');
										    				else 
										    					$tid = 0;
										    			}
										    											    			
										    			$log->setVar('tweet', substr($retweet['text'],0,140));
										    			$log->setVar('url', $link);
										    			$log->setVar('tid', $tid);
										    			$log_handler->insert($log, true);
										    				
											   	   		$ret[]['title'] = $retweet['text'];	  
														$ret[sizeof($ret)]['link'] = $link;
														$ret[sizeof($ret)]['description'] = htmlspecialchars_decode($retweet['text']);
														$ret[sizeof($ret)]['lid'] = $lid;
														$ret[sizeof($ret)]['rid'] = $rid;
														$item++;
										    			$c++;
												   		$items++;
											   		} else {
											   			echo 'Retweet Failed: '.$id.' - '.$tweet['text'].NLB;
											   			@$log_handler->delete($log, true);
											   			$loop = (((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['retweet_items']))*2+1;
											   			$c=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))+1;
											   			continue;
											   		}
												}
											}						    			
							    		}
									}
								}
							}
							$loop++;
						}
						if (count($ret)>$xoConfig['retweet_items']) {
							foreach($ret as $key => $value) {
								if (count($ret)>$xoConfig['retweet_items'])
									unset($ret[$key]);
							}
						}
						XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $xoConfig['interval_of_cron']+$xoConfig['retweet_cache']);
						break;						
				}
			} else {
				$cids[$cid] = $cid;
			}
			
		}
		if ($c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))) {
			if (count($cids)==0) {
				$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
				$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
				$criteria_b->add(new Criteria('start', time(), '<'));
				$criteria_b->add(new Criteria('end', time(), '>'));
				$criteria = new CriteriaCompo($criteria_a);
				$criteria->add($criteria_b, 'OR');
				$criteria->setSort('RAND()');
			} else {
				$criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
				$criteria_a->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
				$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
				$criteria_b->add(new Criteria('start', time(), '<'));
				$criteria_b->add(new Criteria('end', time(), '>'));
				$criteria_b->add(new Criteria('cid', '('.implode(',', $cids).')', 'IN'));
				$criteria = new CriteriaCompo($criteria_a);
				$criteria->add($criteria_b, 'OR');
				$criteria->setSort('RAND()');
			}
			if ($xoConfig['cron_retweet']&&$xoConfig['cron_tweet']) {
				$criteria->add(new Criteria('`type`', '("scheduler", "bomber", "retweet")', 'IN'));
			} elseif ($xoConfig['cron_tweet']) {
				$criteria->add(new Criteria('`type`', '("scheduler", "bomber")', 'IN'));
			} elseif ($xoConfig['cron_retweet']) {
				$criteria->add(new Criteria('`type`', '("retweet")', 'IN'));		
			}
			$criteria->setOrder('ASC');
			$criteria->setSort('cron');
			$campaigns = $campaign_handler->getObjects($criteria, true);
			$campaignCount = $campaign_handler->getCount($criteria);
		}
		if (microtime(true)-$GLOBALS['cron_start']>$GLOBALS['cron_run_for']*(($xoConfig['cron_tweet']?1:0)+($xoConfig['cron_retweet']?1:0)))
			continue;
	}
	if (count($cids)==0) {
		XoopsCache::delete('twitterbomb_cids_cron');
	} else {
		XoopsCache::write('twitterbomb_cids_cron', $cids);
	}
	echo 'Tweeter Cron Ended: '.date('Y-m-d D H:i:s', time()).NLB;
}

?>