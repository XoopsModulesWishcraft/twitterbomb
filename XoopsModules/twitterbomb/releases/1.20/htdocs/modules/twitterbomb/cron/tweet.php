<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

include_once('../../../mainfile.php');
include_once(XOOPS_ROOT_PATH.'/modules/twitterbomb/include/functions.php');

$module_handler = xoops_gethandler('module');
$config_handler = xoops_gethandler('config');
$xoModule = $module_handler->getByDirname('twitterbomb');
$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));

if ($xoConfig['cron_tweet']||$xoConfig['cron_retweet']) {
	echo 'Tweeter Cron Started: '.date('Y-m-d D H:i:s', time())."\n";
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
	$criteria->setSort('`cron`');
	$campaigns = $campaign_handler->getObjects($criteria, true);
	$campaignCount = $campaign_handler->getCount($criteria);
	while ($c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&$loopsb<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))*1.75&&$campaignCount>0) {
		$loopsb++;
		$cids=array();
		foreach($campaigns as $cid => $campaign) {
			$GLOBALS['execution_time'] = $GLOBALS['execution_time'] + 45;
			set_time_limit($GLOBALS['execution_time']);
			$catid = $campaign->getVar('catid');
			if ($c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))) {
				$campaign->setCron();
				switch($campaign->getVar('type')) {
					case "bomb":
						$item=0;
						$items = 0;
						$ret = array();
						$loop=0;
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['items']))*2>$loop) {
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
						   			echo 'Tweet Sent: '.$tweet.' - '.$link."\n";
							   		if ($xoConfig['tags']) {
							   			$tag_handler = xoops_getmodulehandler('tag', 'tag');
										$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $xoModule->getVar("dirname"), $catid);
							   		}
							   		$log->setVar('id', $id);
							   		$lid = $log_handler->insert($log, true);
							   		$ret[$item]['title'] = $tweet;	  
									$ret[$item]['link'] = $link;
									$ret[$item]['description'] = (strlen($username)>0&&($mtr<=$xoConfig['odds_minimum']||$mtr>=$xoConfig['odds_maximum'])?'@'.$username.' ':'').htmlspecialchars_decode($sentence);
									$ret[$item]['lid'] = $lid;
									$item++;
						   		} else {
						   			$log_handler->delete($log, true);
						   		}
						   		$c++;
						   		$items++;
						   		
							}
							$loop++;
						}
						XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $xoConfig['interval_of_cron']+$xoConfig['cache']);
						break;
					case "scheduler":
						$items=0;
						$ret = array();
						$loop=0;
						$item=0;
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['scheduler_items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['scheduler_items']))*2>$loop) {
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
							   			echo 'Tweet Sent: '.$tweet.' - '.$link."\n";
								   		if ($xoConfig['tags']) {
											$tag_handler = xoops_getmodulehandler('tag', 'tag');
											$tag_handler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $xoModule->getVar("dirname"), $catid);
						    			}
						    			$log->setVar('id', $id);
							   			$lid = $log_handler->insert($log, true);
							   	   		$ret[$item]['title'] = $tweet;	  
										$ret[$item]['link'] = $link;
										$ret[$item]['description'] = htmlspecialchars_decode($sentence['tweet']);
										$ret[$item]['lid'] = $lid;
										$ret[$item]['sid'] = $sentence['sid'];
										$item++;
							   		} else {
							   			$scheduler = $scheduler_handler->get($sentence['sid']);
							   			$scheduler->setVar('when', 0);
							   			$scheduler_handler->insert($scheduler);
							   			@$log_handler->delete($log, true);
							   		}
					    			$c++;
							   		$items++;
					    			
					    		}
							}
							
							$loop++;
						
						}
						XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.md5($cid.$catid), $ret, $xoConfig['interval_of_cron']+$xoConfig['scheduler_cache']);
						break;
					case "retweet":
						$items=0;
						$ret = array();
						$loop=0;
						$item=0;
						while((((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['retweet_items']))>$items&&$c<=(($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))&&(((($xoConfig['tweets_per_session']+$xoConfig['retweets_per_session']))/$campaignCount)*(($xoConfig['items']+$xoConfig['scheduler_items']+$xoConfig['retweet_items'])/$xoConfig['retweet_items']))*2>$loop) {
							$search = $retweet_handler->doSearchForTweet($cid, $catid, $campaign->getVar('rids'));
							if (is_array($search)) {
								foreach ($search as $rid => $results) {
									if (!empty($results)) {
										foreach($results as $id => $tweet) {
											if (is_array($tweet)) {
												$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
												$criteria = new Criteria('id', $id);
												if ($log_handler->getCount($criteria)==0) {
													echo __LINE__.'<br/>';
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
											   			echo 'Retweet Sent: '.$id.' - '.$tweet['text']."\n";
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
										    				
											   	   		$ret[$item]['title'] = $retweet['text'];	  
														$ret[$item]['link'] = $link;
														$ret[$item]['description'] = htmlspecialchars_decode($retweet['text']);
														$ret[$item]['lid'] = $lid;
														$ret[$item]['rid'] = $rid;
														$item++;
										    			$c++;
												   		$items++;
											   		} else {
											   			@$log_handler->delete($log, true);
											   		}
												}
											}						    			
							    		}
									}
								}
							}
							$loop++;
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
			} else {
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
			$criteria->setSort('cron');
			$campaigns = $campaign_handler->getObjects($criteria, true);
			$campaignCount = $campaign_handler->getCount($criteria);
		}
	}
	if (count($cids)==0) {
		XoopsCache::delete('twitterbomb_cids_cron');
	} else {
		XoopsCache::write('twitterbomb_cids_cron', $cids);
	}
	echo 'Tweeter Cron Ended: '.date('Y-m-d D H:i:s', time())."\n";
}

?>