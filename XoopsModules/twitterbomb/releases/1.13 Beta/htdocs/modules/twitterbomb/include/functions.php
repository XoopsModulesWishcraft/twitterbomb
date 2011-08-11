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
			$ip = $_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
			$ip  = $_SERVER["REMOTE_ADDR"];
		}
		$ret['netbios'] = $net;
		$ret['md5'] = md5($GLOBALS['xoopsModuleConfig']['salt'] . $ip . $net);	
		return $ret;
	}
}

if (!function_exists("twitterbomb_object2array")) {
	function twitterbomb_object2array($objects) {
		$ret = array();
		foreach((array)$objects as $key => $value) {
			if (is_object($value)) {
				$ret[$key] = xortify_obj2array($value);
			} elseif (is_array($value)) {
				$ret[$key] = xortify_obj2array($value);
			} else {
				$ret[$key] = $value;
			}
		}
		return $ret;
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
		$ret = array();
		$c=0;
		while(count($ret)<$items&&$looped<$items*2) {
			$sentence = $base_matrix_handler->getSentence($cid, $catid);
			$username = $usernames_handler->getUser($cid, $catid);
			$url = $urls_handler->getUrl($cid, $catid);
			if (strlen($username)>0&&count($ret)<$items) {
				$ret[$c]['title'] = (strlen($username)>0&&mt_rand(0,5)>2?'@'.$username.' ':'').str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $GLOBALS['xoopsModuleConfig']['aggregate'], $GLOBALS['xoopsModuleConfig']['wordlength']))));	  
				$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
				$ret[$c]['description'] = '@'.$username.' '.htmlspecialchars_decode($sentence);
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
	    			$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&lid='.$ret[$c]['lid'].'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
	    			if ($GLOBALS['xoopsModuleConfig']['tags']) {
	    				$tag_handler = xoops_getmodulehandler('tag', 'tag');
						$tag_handler->updateByItem($log->getVar('tags'), $ret[$c]['lid'], $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
	    			}
	    		}
	    		$c++;
			}
			$looped++;
		}
		return $ret;
	}
}

if (!function_exists('twitterbomb_get_scheduler_rss')) {
	function twitterbomb_get_scheduler_rss($items, $cid, $catid) {
		$scheduler_handler=&xoops_getmodulehandler('scheduler', 'twitterbomb');
		$urls_handler=&xoops_getmodulehandler('urls', 'twitterbomb');
		$ret = array();
		$c=0;
		
		while(count($ret)<$items&&$looped<$items*2) {
			
			$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
			
			if (is_array($sentence)&&count($ret)<$items) {
				$url = $urls_handler->getUrl($cid, $catid);
				$ret[$c]['title'] = str_replace('#@', '@', str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence['tweet']), $GLOBALS['xoopsModuleConfig']['scheduler_aggregate'], $GLOBALS['xoopsModuleConfig']['scheduler_wordlength']))));	  
				$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
				$ret[$c]['description'] = htmlspecialchars_decode($sentence['tweet']);
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
	    			$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&lid='.$ret[$c]['lid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
	    			if ($GLOBALS['xoopsModuleConfig']['tags']) {
						$tag_handler = xoops_getmodulehandler('tag', 'tag');
						$tag_handler->updateByItem($log->getVar('tags'), $ret[$c]['lid'], $GLOBALS['xoopsModule']->getVar("dirname"), $catid);
	    			}
		    	}
				$c++;
			}
			$looped++;
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
	function tweetbomb_getFilterElement($filter, $field, $sort='created') {
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
				$ele = new TwitterBombFormSelectType('', 'filter_'.$field.'', $components['value']);
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
		    	$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_'.$field.'', 18, 40, $components['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+$(\'#filter_'.$field.'\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;
		    	
		}
		return $ele;
	}
}

if (!function_exists('tweetbomb_getFilterComponents')) {
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