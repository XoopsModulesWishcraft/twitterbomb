<?php

	include('../../mainfile.php');
	include('include/functions.php');	
	include('include/formobjects.twitterbomb.php');
	include('include/forms.twitterbomb.php');
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:'campaigns';
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:'list';
	$limit = isset($_REQUEST['num'])?$_REQUEST['num']:10;	
	$start = isset($_REQUEST['start'])?$_REQUEST['start']:0;	
	$cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:'0';
	$catid = isset($_REQUEST['catid'])?$_REQUEST['catid']:'0';
	
	if ($GLOBALS['xoopsModuleConfig']['htaccess']) {
		$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.$op.','.$fct.','.$start.','.$limit.','.$cid.','.$catid.$GLOBALS['xoopsModuleConfig']['endofurl'];
		if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
			header( "HTTP/1.1 301 Moved Permanently" ); 
			header('Location: '.$url);
			exit(0);
		}
	}
	
	switch($op) {
	default:
	case "campaigns":
		switch($fct) {
			default:
			case 'list':
		
				$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
				$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
		
				if ($catid>0)
					$criteria = new CriteriaCompo(new Criteria('catid', $catid), 'AND');
				else 
					$criteria = new CriteriaCompo(new Criteria('1', '1'), 'AND');
		    	
				$total = $campaign_handler->getCount($criteria);
				
				xoops_load('pagenav');
				$pagenav = new XoopsPageNav($total, $limit, $start, 'start', 'num='.$limit.'&op='.$op.'&fct='.$fct.'&cid='.$cid.'&catid='.$catid);
				
				$xoopsOption['template_main'] = 'twitterbomb_index.html';
				
				include($GLOBALS['xoops']->path('/header.php'));
				
				$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
				$GLOBALS['xoopsTpl']->assign('categories', $category_handler->renderSmarty($catid));
				
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				
				foreach($campaign_handler->getObjects($criteria, false) as $id=>$campaign)
					$GLOBALS['xoopsTpl']->append('campaigns', $campaign->toArray());
				
				include($GLOBALS['xoops']->path('/footer.php'));
				exit(0);
				break;
		}
		break;
		
	case "usernames":
		switch($fct) {
			default:
			case 'new':
				$xoopsOption['template_main'] = 'twitterbomb_usernames.html';
				include($GLOBALS['xoops']->path('/header.php'));
				$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xoopsTpl']->assign('form', tweetbomb_usernames_user_form());
				include($GLOBALS['xoops']->path('/footer.php'));
				exit(0);
				break;
			case 'save':
				$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
				$usernames = $usernames_handler->create();
				$usernames->setVars($_POST[0]);
				$usernames_handler->insert($usernames);
				redirect_header('index.php?op=campaign&fct=list', 10, _MN_MSG_USERNAMES_SAVED);
				exit(0);
				break;
		}	
		break;
	}
	
?>