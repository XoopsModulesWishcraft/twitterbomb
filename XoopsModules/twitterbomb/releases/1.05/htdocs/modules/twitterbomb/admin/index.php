<?php
	
	include('../../../mainfile.php');
	include('../../../include/cp_functions.php');
	include('../include/functions.php');	
	include('../include/formobjects.twitterbomb.php');
	include('../include/forms.twitterbomb.php');
		
	xoops_loadLanguage('admin', 'twitterbomb');
	
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"campaign";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
	
	switch($op) {
		default:
		case "campaign":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(1);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
						
					$ttl = $campaign_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'cid','catid','name','description','start','end','timed','uid','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$campaigns = $campaign_handler->getObjects($criteria, true);
					foreach($campaigns as $cid => $campaign) {
						$GLOBALS['xorTpl']->append('campaign', $campaign->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_campaign_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_campaign_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(1);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$campaign = $campaign_handler->get(intval($_REQUEST['id']));
					} else {
						$campaign = $campaign_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $campaign->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_campaign_edit.html');
					break;
				case "save":
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$campaign = $campaign_handler->get($id);
					} else {
						$campaign = $campaign_handler->create();
					}
					$campaign->setVars($_POST[$id]);
					$campaign->setVar('start', strtotime($_POST[$id]['start']));
					$campaign->setVar('end', strtotime($_POST[$id]['end']));
					
					if (empty($_POST[$id]['timed']))
						$campaign->setVar('timed', FALSE);
						
					if (!$id=$campaign_handler->insert($campaign)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CAMPAIGN_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_CAMPAIGN_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$campaign = $campaign_handler->get($id);
						$campaign->setVars($_POST[$id]);
						$campaign->setVar('start', strtotime($_POST[$id]['start']));
						$campaign->setVar('end', strtotime($_POST[$id]['end']));
						if (empty($_POST[$id]['timed']))
							$campaign->setVar('timed', FALSE);
						if (!$campaign_handler->insert($campaign)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CAMPAIGN_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CAMPAIGN_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$campaign = $campaign_handler->get($id);
						if (!$campaign_handler->delete($campaign)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CAMPAIGN_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CAMPAIGN_DELETED);
							exit(0);
						}
					} else {
						$campaign = $campaign_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_CAMPAIGN_DELETE, $campaign->getVar('name')));
					}
					break;
			}
			break;
		case "category":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(2);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
						
					$ttl = $category_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'catid','pcatdid','name','uid','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$categorys = $category_handler->getObjects($criteria, true);
					foreach($categorys as $cid => $category) {
						$GLOBALS['xorTpl']->append('category', $category->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_category_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_category_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(2);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$category = $category_handler->get(intval($_REQUEST['id']));
					} else {
						$category = $category_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $category->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_category_edit.html');
					break;
				case "save":
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$category = $category_handler->get($id);
					} else {
						$category = $category_handler->create();
					}
					$category->setVars($_POST[$id]);
					if (!$id=$category_handler->insert($category)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CATEGORY_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_CATEGORY_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$category = $category_handler->get($id);
						$category->setVars($_POST[$id]);
						if (!$category_handler->insert($category)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CATEGORY_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CATEGORY_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$category = $category_handler->get($id);
						if (!$category_handler->delete($category)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CATEGORY_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_CATEGORY_DELETED);
							exit(0);
						}
					} else {
						$category = $category_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_CATEGORY_DELETE, $category->getVar('name')));
					}
					break;
			}
			break;
		case "keywords":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(3);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
						
					$ttl = $keywords_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'kid','cid','catid','base','keyword','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$keywordss = $keywords_handler->getObjects($criteria, true);
					foreach($keywordss as $cid => $keywords) {
						$GLOBALS['xorTpl']->append('keywords', $keywords->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_keywords_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_keywords_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(3);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$keywords = $keywords_handler->get(intval($_REQUEST['id']));
					} else {
						$keywords = $keywords_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $keywords->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_keywords_edit.html');
					break;
				case "save":
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$keywords = $keywords_handler->get($id);
					} else {
						$keywords = $keywords_handler->create();
					}
					$keywords->setVars($_POST[$id]);
					if (!$id=$keywords_handler->insert($keywords)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_KEYWORDS_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_KEYWORDS_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$keywords = $keywords_handler->get($id);
						$keywords->setVars($_POST[$id]);
						if (!$keywords_handler->insert($keywords)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_KEYWORDS_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_KEYWORDS_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$keywords = $keywords_handler->get($id);
						if (!$keywords_handler->delete($keywords)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_KEYWORDS_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_KEYWORDS_DELETED);
							exit(0);
						}
					} else {
						$keywords = $keywords_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_KEYWORDS_DELETE, $keywords->getVar('name')));
					}
					break;
			}
			break;
		case "base_matrix":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(4);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
						
					$ttl = $base_matrix_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'baseid','cid','catid','base1','base2','base3','base4','base5','base6','base7','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$base_matrixs = $base_matrix_handler->getObjects($criteria, true);
					foreach($base_matrixs as $cid => $base_matrix) {
						$GLOBALS['xorTpl']->append('base_matrix', $base_matrix->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_base_matrix_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);		
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_base_matrix_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(4);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$base_matrix = $base_matrix_handler->get(intval($_REQUEST['id']));
					} else {
						$base_matrix = $base_matrix_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $base_matrix->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_base_matrix_edit.html');
					break;
				case "save":
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$base_matrix = $base_matrix_handler->get($id);
					} else {
						$base_matrix = $base_matrix_handler->create();
					}
					$base_matrix->setVars($_POST[$id]);
					if (!$id=$base_matrix_handler->insert($base_matrix)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_BASEMATRIX_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_BASEMATRIX_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$base_matrix = $base_matrix_handler->get($id);
						$base_matrix->setVars($_POST[$id]);
						if (!$base_matrix_handler->insert($base_matrix)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_BASEMATRIX_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_BASEMATRIX_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$base_matrix = $base_matrix_handler->get($id);
						if (!$base_matrix_handler->delete($base_matrix)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_BASEMATRIX_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_BASEMATRIX_DELETED);
							exit(0);
						}
					} else {
						$base_matrix = $base_matrix_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_BASEMATRIX_DELETE, $base_matrix->getVar('name')));
					}
					break;
			}
			break;
		case "usernames":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(5);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
						
					$ttl = $usernames_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'tid','cid','catid','twitter_username','uid','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$usernamess = $usernames_handler->getObjects($criteria, true);
					foreach($usernamess as $cid => $usernames) {
						$GLOBALS['xorTpl']->append('usernames', $usernames->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_usernames_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);		
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_usernames_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(5);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$usernames = $usernames_handler->get(intval($_REQUEST['id']));
					} else {
						$usernames = $usernames_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $usernames->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_usernames_edit.html');
					break;
				case "save":
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$usernames = $usernames_handler->get($id);
					} else {
						$usernames = $usernames_handler->create();
					}
					$usernames->setVars($_POST[$id]);
					if (!$id=$usernames_handler->insert($usernames)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_USERNAMES_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_USERNAMES_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$usernames = $usernames_handler->get($id);
						$usernames->setVars($_POST[$id]);
						if (!$usernames_handler->insert($usernames)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_USERNAMES_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_USERNAMES_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$usernames = $usernames_handler->get($id);
						if (!$usernames_handler->delete($usernames)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_USERNAMES_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_USERNAMES_DELETED);
							exit(0);
						}
					} else {
						$usernames = $usernames_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_USERNAMES_DELETE, $usernames->getVar('twitter_username')));
					}
					break;
			}
			break;
		case "urls":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(6);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
						
					$ttl = $urls_handler->getCount(NULL);
					$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
					$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
					$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'urlid','cid','catid','surl','name','description','uid','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					}
						
					$criteria = new Criteria('1','1');
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$urlss = $urls_handler->getObjects($criteria, true);
					foreach($urlss as $cid => $urls) {
						$GLOBALS['xorTpl']->append('urls', $urls->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_urls_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);					
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_urls_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(6);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$urls = $urls_handler->get(intval($_REQUEST['id']));
					} else {
						$urls = $urls_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $urls->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_urls_edit.html');
					break;
				case "save":
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$urls = $urls_handler->get($id);
					} else {
						$urls = $urls_handler->create();
					}
					$urls->setVars($_POST[$id]);
					if (!$id=$urls_handler->insert($urls)) {
						redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_URLS_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_URLS_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$urls = $urls_handler->get($id);
						$urls->setVars($_POST[$id]);
						if (!$urls_handler->insert($urls)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_URLS_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_URLS_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$urls = $urls_handler->get($id);
						if (!$urls_handler->delete($urls)) {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_URLS_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list', 10, _AM_MSG_URLS_DELETED);
							exit(0);
						}
					} else {
						$urls = $urls_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct']), 'index.php', sprintf(_AM_MSG_URLS_DELETE, $urls->getVar('name')));
					}
					break;
			}
			break;															
	}
	
	twitterbomb_footer_adminMenu();
	xoops_cp_footer();
?>