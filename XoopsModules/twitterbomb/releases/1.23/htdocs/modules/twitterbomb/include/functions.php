<?php

if (!function_exists("twitterbomb_getuser_id")) {
	function twitterbomb_getuser_id()
	{
		if (is_object($GLOBALS['xoopsUser']))
			$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
		else 
			$ret['uid'] = 0;
	
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ret['ip']  = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"].':'.$_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["HTTP_X_FORWARDED_FOR"]);
		} else { 
			$ret['ip']  =  $_SERVER["REMOTE_ADDR"];
			$ip = $_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		}
		$ret['netbios'] = $net;
		
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		
		$ret['md5'] = md5(XOOPS_LICENSE_KEY . $xoConfig['salt'] . $ret['ip'] . $ret['netbios'] . $ret['uid']);	
		return $ret;
	}
}

if (!function_exists("twitterbomb_object2array")) {
	function twitterbomb_object2array($objects) {
		$ret = array();
		foreach((array)$objects as $key => $value) {
			if (is_object($value)) {
				$ret[$key] = twitterbomb_object2array($value);
			} elseif (is_array($value)) {
				$ret[$key] = twitterbomb_object2array($value);
			} else {
				$ret[$key] = $value;
			}
		}
		return $ret;
	}
}

if (!function_exists("twitterbomb_shortenurl")) {
	function twitterbomb_shortenurl($url) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
	
		if (!empty($xoConfig['bitly_username'])&&!empty($xoConfig['bitly_apikey'])) {
			$source_url = $xoConfig['bitly_apiurl'].'/shorten?login='.$xoConfig['bitly_username'].'&apiKey='.$xoConfig['bitly_apikey'].'&format=json&longUrl='.urlencode($url);
			$cookies = XOOPS_ROOT_PATH.'/uploads/twitterbomb_'.md5($xoConfig['bitly_apikey']).'.cookie'; 
			if (!$ch = curl_init($source_url)) {
				return $url;
			}
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_USERAGENT, $xoConfig['user_agent']); 
			$data = curl_exec($ch); 
			curl_close($ch); 
			unlink($cookies);
			$result = twitterbomb_object2array(json_decode($data));
			if ($result['status_code']=200) {
				if (!empty($result['data']['url']))
					return $result['data']['url'];
				else 
					return $url;
			}
			return $url;
		} else {
			return $url;
		}
	}
}

if (!function_exists("twitterbomb_searchtwitter")) {
	function twitterbomb_searchtwitter($numberofresults = 10, $q='', $exceptions = array(), $geocode='', $lang='en', $page=1, $result_type = 'mixed', $rpp = '100', $show_user = 'true', $until='', $since_id ='', $gathered=0, $next_url = '') {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		$ret = array();
		if (!empty($xoConfig['search_url'])) {
			if (empty($next_url))
				$source_url = $xoConfig['search_url'].'?q='.$q.(!empty($geocode)?'&geocode='.$geocode:'').(!empty($lang)?'&lang='.$lang:'').(!empty($page)?'&page='.$page:'').(!empty($result_type)?'&result_type='.$result_type:'').(!empty($rpp)?'&rpp='.$rpp:'').(!empty($show_user)?'&show_user='.$show_user:'').(!empty($until)?'&until='.$until:'').(!empty($since_id)?'&since_id='.$since_id:'');
			else 
				$source_url = $xoConfig['search_url'].$next_url;
				
			$cookies = XOOPS_ROOT_PATH.'/uploads/twitterbomb_'.md5($xoConfig['search_url']).'.cookie'; 
			if (!$ch = curl_init($source_url)) {
				return $url;
			}
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_USERAGENT, $xoConfig['user_agent']); 
			$data = curl_exec($ch); 
			curl_close($ch); 
			unlink($cookies);
			$result = twitterbomb_object2array(json_decode($data));
			if (!empty($result['results'])) {
				foreach($result['results'] as $result) {
					if ($gathered<$numberofresults) {
						$pass=false;
						if (count($exceptions)>0) {
							foreach($exceptions as $seachfor) {
								if (!strpos(strtolower($searchfor), strtolower($result['text']))) {
									$pass=true;
								} else {
									if ($pass==true)
										$pass=false;
								}
							}	
						} else {
							$pass=true;
						}
						if ($pass==true) {
							$ret[$result['id_str']] = $result;
							$gathered++;
						}
					}
				}
				if ($gathered<$numberofresults) {
					foreach(twitterbomb_searchtwitter($numberofresults, $q, $exceptions, $geocode, $lang, $page++, $result_type, $rpp, $show_user, $until, $since, $gathered, $result['next_page']) as $id=>$result) {
						$ret[$id] = $result;
					}
				}
				return $ret;
			} else {
				return false;
			}
		} else {
			return $ret;
		}
	}
}
if (!function_exists("twitterbomb_adminMenu")) {
  function twitterbomb_adminMenu ($currentoption = 0)  {
		$module_handler = xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname('twitterbomb');

	  /* Nice buttons styles */
	    echo "
    	<style type='text/css'>
		#form {float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;}
		    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 0px; border-bottom: 1px solid black; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		  #buttonbar li { display:inline; margin:0; padding:0; }
		  #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px;  text-decoration:none; }
		  #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		  /* Commented Backslash Hack hides rule from IE5-Mac \*/
		  #buttonbar a span {float:none;}
		  /* End IE5-Mac hack */
		  #buttonbar a:hover span { color:#333; }
		  #buttonbar #current a { background-position:0 -150px; border-width:0; }
		  #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		  #buttonbar a:hover { background-position:0% -150px; }
		  #buttonbar a:hover span { background-position:100% -150px; }
		  </style>";
	
	   // global $xoopsDB, $xoModule, $xoopsConfig, $xoModuleConfig;
	
	   $myts = &MyTextSanitizer::getInstance();
	
	   $tblColors = Array();
		// $adminmenu=array();
	   if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php')) {
		   include_once XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php';
	   } else {
		   include_once XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/english/modinfo.php';
	   }
       
	   include XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/admin/menu.php';
	   global $adminmenu;
	   echo "<table width=\"100%\" border='0'><tr><td>";
	   echo "<div id='buttontop'>";
	   echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	   echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoModule->getVar('mid') . "\">" . _PREFERENCES . "</a></td>";
	   echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($xoModule->name()) ."</td>";
	   echo "</tr></table>";
	   echo "</div>";
	   echo "<div id='buttonbar'>";
	   echo "<ul>";
		 foreach ($adminmenu as $key => $value) {
		   $tblColors[$key] = '';
		   $tblColors[$currentoption] = 'current';
	     echo "<li id='" . $tblColors[$key] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/".$value['link']."\"><span>" . $value['title'] . "</span></a></li>";
		 }
		 
	   echo "</ul></div>";
	   echo "</td></tr>";
	   echo "<tr'><td><div id='form'>";
    
  }
  
  function twitterbomb_footer_adminMenu()
  {
		echo "</div></td></tr>";
  		echo "</table>";
  }
}

if (!function_exists('twitterbomb_getSubCategoriesIn')) {
	function twitterbomb_getSubCategoriesIn($catid=0){
		$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
		$categories = $category_handler->getObjects(new Criteria('pcatdid', $catid), true);
		$in_array = twitterbomb_getCategoryTree(array(), $categories, -1, $catid);
		$in_array[$catid]=$catid;
		return $in_array;
	}
}

if (!function_exists('twitterbomb_getCategoryTree')) {
	function twitterbomb_getCategoryTree($in_array, $categories, $ownid) {
		$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
		foreach($categories as $catid => $category) {
			$in_array[$catid] = $catid;
			if ($categoriesb = $category_handler->getObjects(new Criteria('pcatdid', $catid), true)){
				$in_array = twitterbomb_getCategoryTree($in_array, $categoriesb, $ownid);
			}
		}
		return ($in_array);
	}
}

if (!function_exists('twitterbomb_get_rss')) {
	function twitterbomb_get_rss($items, $cid, $catid) {
		$base_matrix_handler=&xoops_getmodulehandler('base_matrix', 'twitterbomb');
		$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
		$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
		xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
		$ret = XoopsCache::read('tweetbomb_bomb_'.md5($cid.$catid));
		while($looped<$items) {
			$sentence = $base_matrix_handler->getSentence($cid, $catid);
			$username = $usernames_handler->getUser($cid, $catid);
			$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence);
			$url = $urls_handler->getUrl($cid, $catid);
			$c = sizeof($ret)+1;
			$mtr=mt_rand($GLOBALS['xoopsModuleConfig']['odds_lower'],$GLOBALS['xoopsModuleConfig']['odds_higher']);
			$ret[$c]['title'] = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').(strlen($username)>0&&($mtr<=$GLOBALS['xoopsModuleConfig']['odds_minimum']||$mtr>=$GLOBALS['xoopsModuleConfig']['odds_maximum'])?'@'.$username.' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $GLOBALS['xoopsModuleConfig']['aggregate'], $GLOBALS['xoopsModuleConfig']['wordlength']))));	  
			$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
			$ret[$c]['description'] = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').(strlen($username)>0&&($mtr<=$GLOBALS['xoopsModuleConfig']['odds_minimum']||$mtr>=$GLOBALS['xoopsModuleConfig']['odds_maximum'])?'@'.$username.' ':'').htmlspecialchars_decode($sentence);
			if (strlen($ret[$c]['title'])!=0) {
    			$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
    			$log = $log_handler->create();
    			$log->setVar('cid', $cid);
    			$log->setVar('catid', $catid);
    			$log->setVar('provider', 'bomb');
    			$log->setVar('url', $ret[$c]['link']);
    			$log->setVar('tweet', substr($ret[$c]['title'],0,139));
    			$log->setVar('tags', twitterbomb_ExtractTags($ret[$c]['title']));
    			$ret[$c]['lid'] = $log_handler->insert($log, true);
    			$ret[$c]['link'] = twitterbomb_shortenurl(XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&lid='.$ret[$c]['lid'].'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence)))));
    			if ($GLOBALS['xoopsModuleConfig']['tags']) {
    				$tag_handler = xoops_getmodulehandler('tag', 'tag');
					$tag_handler->updateByItem($log->getVar('tags'), $ret[$c]['lid'], $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
    			}
    		}
    		$c++;
			$looped++;
		}
		if ($count($ret)>$xoConfig['items']) {
			foreach($ret as $key => $value) {
				if ($count($ret)>$xoConfig['items'])
					unset($ret[$key]);
			}
		}			
		return $ret;
	}
}

if (!function_exists('twitterbomb_get_scheduler_rss')) {
	function twitterbomb_get_scheduler_rss($items, $cid, $catid) {
		$scheduler_handler=&xoops_getmodulehandler('scheduler', 'twitterbomb');
		$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
		$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
		xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
		$ret = XoopsCache::read('tweetbomb_scheduler_'.md5($cid.$catid));
		while($looped<$items) {
			$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
			if (is_array($sentence)&&count($ret)<$items) {
				$sourceuser = $usernames_handler->getSourceUser($cid, $catid, $sentence['tweet']);
				$url = $urls_handler->getUrl($cid, $catid);
				$ret[$c]['title'] = (is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence['tweet']), $GLOBALS['xoopsModuleConfig']['scheduler_aggregate'], $GLOBALS['xoopsModuleConfig']['scheduler_wordlength']))));	  
				$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
				$ret[$c]['description'] = htmlspecialchars_decode((is_object($sourceuser)?'@'.$sourceuser->getVar('screen_name').' ':'').$sentence['tweet']);
				$ret[$c]['sid'] = $sentence['sid'];
				if (strlen($ret[$c]['title'])!=0) {
					$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
	    			$log = $log_handler->create();
	    			$log->setVar('provider', 'scheduler');
	    			$log->setVar('cid', $cid);
	    			$log->setVar('catid', $catid);
	    			$log->setVar('sid', $ret[$c]['sid']);
	    			$log->setVar('url', $ret[$c]['link']);
	    			$log->setVar('tweet', substr($ret[$c]['title'],0,139));
	    			$log->setVar('tags', twitterbomb_ExtractTags($ret[$c]['title']));
	    			$ret[$c]['lid'] = $log_handler->insert($log, true);
	    			$ret[$c]['link'] = twitterbomb_shortenurl(XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&lid='.$ret[$c]['lid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet'])))));
	    			if ($GLOBALS['xoopsModuleConfig']['tags']) {
						$tag_handler = xoops_getmodulehandler('tag', 'tag');
						$tag_handler->updateByItem($log->getVar('tags'), $ret[$c]['lid'], $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
	    			}
		    	}
				$c++;
			}
			$looped++;
		}
		if ($count($ret)>$xoConfig['scheduler_items']) {
			foreach($ret as $key => $value) {
				if ($count($ret)>$xoConfig['scheduler_items'])
					unset($ret[$key]);
			}
		}	
		return $ret;
	}
}

if (!function_exists('twitterbomb_get_retweet_rss')) {
	function twitterbomb_get_retweet_rss($items, $cid, $catid) {
		$campaign_handler=&xoops_getmodulehandler('campaign', 'twitterbomb');
		$retweet_handler=&xoops_getmodulehandler('retweet', 'twitterbomb');
		$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
		$usernames_handler=&xoops_getmodulehandler('usernames', 'twitterbomb');
		$log_handler=&xoops_getmodulehandler('log', 'twitterbomb');
		$oauth_handler=&xoops_getmodulehandler('oauth', 'twitterbomb');

		xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
		
		$oauth = $oauth_handle->getRootOauth(true);
		if (!is_object($oauth))
			return array();
		
		$campaign = $campaign_handler->get($cid);
		if (!is_object($campaign))
			return array();
		
		$item = 0;
		$ret = XoopsCache::read('tweetbomb_scheduler_'.md5($cid.$catid));
		$itemsttl = count($ret);
		while($looped<$items) {
			$search = $retweet_handler->doSearchForTweet($cid, $catid, $campaign->getVar('rids'));
			if (is_array($search)) {
				foreach ($search as $rid => $results) {
					foreach($results as $id => $tweet) {
						if (is_array($tweet)&&item<$items) {
							$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
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
					   		} else {
					   			@$log_handler->delete($log, true);
					   		}
			    		}
					}
				}
			}
			$looped++;
		}
		if ($count($ret)>$xoConfig['retweet_items']) {
			foreach($ret as $key => $value) {
				if ($count($ret)>$xoConfig['retweet_items'])
					unset($ret[$key]);
			}
		}	
		return $ret;
	}
}

if (!function_exists('twitterbomb_ExtractTags')) {
	function twitterbomb_ExtractTags($tweet='', $as_array = false, $seperator=', ') {
		$ret = array();
		foreach(explode(' ', $tweet) as $node) {
    		if (in_array(substr($node, 0, 1), array('@','#'))) {
    			$ret[ucfirst(substr($node, 1, strlen($node)-1))] = ucfirst(substr($node, 1, strlen($node)-1)); 
    		}
    	}
		if ($as_array==true)
			return $ret;
		else 
			return implode($seperator, $ret);
				    	
	}
}
	 
if (!function_exists('twitterbomb_TweetString')) {
	function twitterbomb_TweetString($title, $doit=false, $wordlen=4) {
		if ($doit==true) {
			$title_array = explode(' ', $title);
			$title = '';
			foreach($title_array as $item) {
				if (strlen($item)>$wordlen) 
					$title .= ' #'.$item;
				else 
					$title .= ' '.$item;
			}
		}
		return trim($title);
	}
}

// Sometimes this function needs altering
if (!function_exists('twitterbomb_checkmirc_log_line')) {
	function twitterbomb_checkmirc_log_line($line) {
		$parts = explode(' ', $line);
		if ($parts[0]==$parts[sizeof($parts)]) {
			return null;
		}
		if ($parts[0]=='Session') {
			return null;
		}
		return $line;
	}
}

if (!function_exists('tweetbomb_getFilterElement')) {
	function tweetbomb_getFilterElement($filter, $field, $sort='created', $op = '', $fct = '') {
		$components = tweetbomb_getFilterURLComponents($filter, $field, $sort);
		include_once('formobjects.twitterbomb.php');
		switch ($field) {
			case 'cid':
				$ele = new TwitterBombFormSelectCampaigns('', 'filter_'.$field.'', $components['value']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'pcatdid':	
			case 'catid':
				$ele = new TwitterBombFormSelectCategories('', 'filter_'.$field.'', $components['value']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
	    	case 'mode':
				$ele = new TwitterBombFormSelectMode('', 'filter_'.$field.'', $components['value']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
	    	case 'provider':
		    case 'type':
				 if ($op=='retweet') {
					$ele = new TwitterBombFormSelectRetweetType('', 'filter_'.$field.'', $components['value'], 1, false, true);
			    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	} elseif ($op=='log') {
					$ele = new TwitterBombFormSelectLogType('', 'filter_'.$field.'', $components['value'], 1, false, true);
			    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	} else {
					$ele = new TwitterBombFormSelectType('', 'filter_'.$field.'', $components['value'], 1, false, true);
			    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	}
		    	break;
		    case 'measurement':
				$ele = new TwitterBombFormSelectMeasurement('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'language':
				$ele = new TwitterBombFormSelectLanguage('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'base':
		    case 'base1':
		    case 'base2':
			case 'base3':
			case 'base4':
			case 'base5':
			case 'base6':
			case 'base7':						    	
				$ele = new TwitterBombFormSelectBase('', 'filter_'.$field.'', $components['value']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'description':
		    case 'pre':
		    case 'alias':
		    case 'screen_name':
		    case 'source_nick':	
		    case 'keyword':
		    case 'tweet':
		    case 'name':
		    case 'search':
		    case 'skip':
		    case 'longitude':
			case 'latitude':		    	
		    	$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_'.$field.'', 11, 40, $components['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+$(\'#filter_'.$field.'\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;
		    case 'radius':
		    	$measurement = tweetbomb_getFilterURLComponents($components['filter'], 'measurement', $sort);
				$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_radius', 8, 40, $components['value']));
				$ele->addElement(new TwitterBombFormSelectMeasurement('', 'filter_measurement', $measurement['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$measurement['extra'].'&filter='.$measurement['filter'].(!empty($measurement['filter'])?'|':'').'radius'.',\'+$(\'#filter_radius\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').'+\'|'.'measurement'.',\'+$(\'#filter_measurement'.'\').val()'.(!empty($measurement['operator'])?'+\','.$measurement['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);		    	
		}
		return $ele;
	}
}

if (!function_exists('tweetbomb_getFilterURLComponents')) {
	function tweetbomb_getFilterURLComponents($filter, $field, $sort='created') {
		$parts = explode('|', $filter);
		$ret = array();
		$value = '';
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (count($var)>1) {
	    		if ($var[0]==$field) {
	    			$ele_value = $var[1];
	    			if (isset($var[2]))
	    				$operator = $var[2];
	    		} elseif ($var[0]!=1) {
	    			$ret[] = implode(',', $var);
	    		}
    		}
    	}
    	$pagenav = array();
    	$pagenav['op'] = isset($_REQUEST['op'])?$_REQUEST['op']:"campaign";
		$pagenav['fct'] = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
		$pagenav['limit'] = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$pagenav['start'] = 0;
		$pagenav['order'] = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$pagenav['sort'] = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':$sort;
    	$retb = array();
		foreach($pagenav as $key=>$value) {
			$retb[] = "$key=$value";
		}
		return array('value'=>$ele_value, 'field'=>$field, 'operator'=>$operator, 'filter'=>implode('|', $ret), 'extra'=>implode('&', $retb));
	}
}
?>