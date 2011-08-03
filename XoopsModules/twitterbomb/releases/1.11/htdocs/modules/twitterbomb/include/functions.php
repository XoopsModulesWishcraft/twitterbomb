<?php


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
		while(count($ret)<$items||$looped<$items*2) {
			$sentence = $base_matrix_handler->getSentence($cid, $catid);
			$username = $usernames_handler->getUser($cid, $catid);
			$url = $urls_handler->getUrl($cid, $catid);
			if (strlen($username)>0) {
				$ret[$c]['title'] = (strlen($username)>0&&mt_rand(0,1)==1?'@'.$username.' ':'').str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence), $GLOBALS['xoopsModuleConfig']['aggregate'], $GLOBALS['xoopsModuleConfig']['wordlength']));	  
				$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence))));
				$ret[$c]['description'] = '@'.$username.' '.htmlspecialchars_decode($sentence);
				if (strlen($ret[$c]['title'])!=0) {
	    			$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
	    			$log = $log_handler->create();
	    			$log->setVar('provider', 'bomb');
	    			$log->setVar('url', $ret[$c]['link']);
	    			$log->setVar('tweet', substr($ret[$c]['title'],0,139));
	    			$log_handler->insert($log, true);
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
		while(count($ret)<$items||$looped<$items*2) {
			$sentence = $scheduler_handler->getTweet($cid, $catid, 0, 0);
			if (is_array($sentence)) {
				$url = $urls_handler->getUrl($cid, $catid);
				$ret[$c]['title'] = str_replace('#(', '(#', str_replace('##', '#', twitterbomb_TweetString(htmlspecialchars_decode($sentence['tweet']), $GLOBALS['xoopsModuleConfig']['scheduler_aggregate'], $GLOBALS['xoopsModuleConfig']['scheduler_wordlength'])));	  
				$ret[$c]['link'] = XOOPS_URL.'/modules/twitterbomb/go.php?sid='.$sentence['sid'].'&cid='.$cid.'&catid='.$catid.'&uri='.urlencode( sprintf($url, urlencode(str_replace(array('#', '@'), '',$sentence['tweet']))));
				$ret[$c]['description'] = htmlspecialchars_decode($sentence['tweet']);
				$ret[$c]['sid'] = $sentence['sid'];
				if (strlen($ret[$c]['title'])!=0) {
	    			$log_handler=xoops_getmodulehandler('log', 'twitterbomb');
	    			$log = $log_handler->create();
	    			$log->setVar('provider', 'scheduler');
	    			$log->setVar('sid', $ret[$c]['sid']);
	    			$log->setVar('url', $ret[$c]['link']);
	    			$log->setVar('tweet', substr($ret[$c]['title'],0,139));
	    			$log_handler->insert($log, true);
		    	}
				$c++;
			}
			$looped++;
		}
		return $ret;
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
?>