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
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$filter = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';
	
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

					$criteria = $campaign_handler->getFilterCriteria($filter);
					$ttl = $campaign_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'cid','catid','type','name','description','start','end','timed','uid','created','updated','hits','active') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $campaign_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CAMPAIGN_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CAMPAIGN_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CAMPAIGN_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$campaign = $campaign_handler->get($id);
						if (!$campaign_handler->delete($campaign)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CAMPAIGN_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CAMPAIGN_DELETED);
							exit(0);
						}
					} else {
						$campaign = $campaign_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_CAMPAIGN_DELETE, $campaign->getVar('name')));
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
						
					$criteria = $category_handler->getFilterCriteria($filter);
					$ttl = $category_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
										
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'catid','pcatdid','name','uid','created','updated','hits','active') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $category_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$categorys = $category_handler->getObjects($criteria, true);
					foreach($categorys as $cid => $category) {
						if (is_object($category))					
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CATEGORY_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CATEGORY_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CATEGORY_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$category = $category_handler->get($id);
						if (!$category_handler->delete($category)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CATEGORY_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_CATEGORY_DELETED);
							exit(0);
						}
					} else {
						$category = $category_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_CATEGORY_DELETE, $category->getVar('name')));
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
					$criteria = $keywords_handler->getFilterCriteria($filter);
					$ttl = $keywords_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'kid','cid','catid','base','keyword','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $keywords_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$keywordss = $keywords_handler->getObjects($criteria, true);
					foreach($keywordss as $cid => $keywords) {
						if (is_object($keywords))
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_KEYWORDS_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_KEYWORDS_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_KEYWORDS_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$keywords = $keywords_handler->get($id);
						if (!$keywords_handler->delete($keywords)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_KEYWORDS_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_KEYWORDS_DELETED);
							exit(0);
						}
					} else {
						$keywords = $keywords_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_KEYWORDS_DELETE, $keywords->getVar('name')));
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
						
					$criteria = $base_matrix_handler->getFilterCriteria($filter);
					$ttl = $base_matrix_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'baseid','cid','catid','base1','base2','base3','base4','base5','base6','base7','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $base_matrix_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$base_matrixs = $base_matrix_handler->getObjects($criteria, true);
					foreach($base_matrixs as $cid => $base_matrix) {
						if (is_object($base_matrix))
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_BASEMATRIX_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_BASEMATRIX_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_BASEMATRIX_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$base_matrix = $base_matrix_handler->get($id);
						if (!$base_matrix_handler->delete($base_matrix)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_BASEMATRIX_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_BASEMATRIX_DELETED);
							exit(0);
						}
					} else {
						$base_matrix = $base_matrix_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_BASEMATRIX_DELETE, $base_matrix->getVar('name')));
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
						
					$criteria = $usernames_handler->getFilterCriteria($filter);
					$ttl = $usernames_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
								
					foreach (array(	'tid','cid','catid','screen_name','uid','created','updated', 'type', 'source_nick', 'tweeted') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $usernames_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);

					$usernamess = $usernames_handler->getObjects($criteria, true);
					foreach($usernamess as $cid => $usernames) {
						if (is_object($usernames))
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_USERNAMES_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_USERNAMES_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_USERNAMES_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$usernames = $usernames_handler->get($id);
						if (!$usernames_handler->delete($usernames)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_USERNAMES_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_USERNAMES_DELETED);
							exit(0);
						}
					} else {
						$usernames = $usernames_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_USERNAMES_DELETE, $usernames->getVar('screen_name')));
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
						
					$criteria = $urls_handler->getFilterCriteria($filter);
					$ttl = $urls_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'urlid','cid','catid','surl','name','description','uid','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $urls_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$urlss = $urls_handler->getObjects($criteria, true);
					foreach($urlss as $cid => $urls) {
						if (is_object($urls))
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
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_URLS_FAILEDTOSAVE);
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
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_URLS_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_URLS_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$urls = $urls_handler->get($id);
						if (!$urls_handler->delete($urls)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_URLS_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_URLS_DELETED);
							exit(0);
						}
					} else {
						$urls = $urls_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_URLS_DELETE, $urls->getVar('name')));
					}
					break;
			}
			break;

		case "scheduler":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(7);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
						
					$criteria = $scheduler_handler->getFilterCriteria($filter);
					$ttl = $scheduler_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'sid';
										
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'sid', 'cid','catid','mode','pre','text','hits','rank','uid','when','tweeted','created','updated') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $scheduler_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$schedulers = $scheduler_handler->getObjects($criteria, true);
					foreach($schedulers as $cid => $scheduler) {
						$GLOBALS['xorTpl']->append('scheduler', $scheduler->toArray());
					}
					$GLOBALS['xorTpl']->assign('form', tweetbomb_scheduler_get_form(false));
					$GLOBALS['xorTpl']->assign('upload_form', tweetbomb_scheduler_get_upload_form($scheduler_handler));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_scheduler_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(7);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$scheduler = $scheduler_handler->get(intval($_REQUEST['id']));
					} else {
						$scheduler = $scheduler_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $scheduler->getForm());
					$GLOBALS['xorTpl']->assign('upload_form', $scheduler_handler->getUploadForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_scheduler_edit.html');
					break;
				case "save":
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$scheduler = $scheduler_handler->get($id);
					} else {
						$scheduler = $scheduler_handler->create();
					}
					$scheduler->setVars($_POST[$id]);
					$scheduler->setVar('search', explode('|', $_POST[$id]['search']));
					$scheduler->setVar('replace', explode('|', $_POST[$id]['replace']));
					$scheduler->setVar('strip', explode('|', $_POST[$id]['strip']));
											
					if (!$id=$scheduler_handler->insert($scheduler)) {
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_SCHEDULER_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$scheduler = $scheduler_handler->get($id);
						$scheduler->setVars($_POST[$id]);
						$scheduler->setVar('start', strtotime($_POST[$id]['start']));
						$scheduler->setVar('end', strtotime($_POST[$id]['end']));
						if (empty($_POST[$id]['timed']))
							$scheduler->setVar('timed', FALSE);
						if (!$scheduler_handler->insert($scheduler)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$scheduler = $scheduler_handler->get($id);
						if (!$scheduler_handler->delete($scheduler)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_DELETED);
							exit(0);
						}
					} else {
						$scheduler = $scheduler_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_SCHEDULER_DELETE, $scheduler->getVar('text')));
					}
					break;
				case "importfile":
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					
			  		include_once $GLOBALS['xoops']->path('/modules/twitterbomb/class/myuploader.php');
			  		
					  $allowed_mimetypes = array('application/octet-stream', 'text/plain');
					  $allowed_exts = array('txt', 'log');
					  $maxfilesize = 1024*1024*10;
					  
					  $uploader = new MyXoopsMediaUploader(XOOPS_UPLOAD_PATH, $allowed_mimetypes, $maxfilesize, 0, 0, $allowed_exts);
					  
					  if ($uploader->fetchMedia(0, 'file')) {
					  	
					    if (!$uploader->upload()) {
					    	
					       echo $uploader->getErrors();
					       
					    } else {
					    	
					    	set_time_limit(3600);
					      	ini_set('memory_limit', '128M');
					      	
					      	$lines = file(XOOPS_UPLOAD_PATH.'/'.$uploader->getSavedFileName());
					      	
					      	foreach($lines as $line) {
								
					      		if ($_POST[0]['mode']=='mirc')
					      			$line = twitterbomb_checkmirc_log_line($line);
					      			
					      		if (!empty($line)) {
									$id=0;
									$scheduler = $scheduler_handler->create();
									
									$scheduler->setVars($_POST[$id]);
									$scheduler->setVar('search', explode('|', $_POST[$id]['search']));
									$scheduler->setVar('replace', explode('|', $_POST[$id]['replace']));
									$scheduler->setVar('strip', explode('|', $_POST[$id]['strip']));
									$scheduler->setVar('text', $line);
									if (!$id=$scheduler_handler->insert($scheduler)) {
										unlink(XOOPS_UPLOAD_PATH.'/'.$uploader->getSavedFileName());
										print_r($scheduler);
										exit(0);
						      			redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_IMPORT_FAILED);
						      			exit(0);
						      		}
					      		}
					      	}
					      	
					      	unlink(XOOPS_UPLOAD_PATH.'/'.$uploader->getSavedFileName());
					      	
					      	redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_SCHEDULER_IMPORT_SUCCESSFUL);
					      	exit(0);
					    }
					  } else {
					    echo $uploader->getErrors();
					  }
					break;
			}
			break;
		case "log":	
			
			xoops_loadLanguage('admin', 'twitterbomb');
			twitterbomb_adminMenu(8);
			
			include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
			include_once $GLOBALS['xoops']->path( "/class/template.php" );
			$GLOBALS['xorTpl'] = new XoopsTpl();
			
			$log_handler =& xoops_getmodulehandler('log', 'twitterbomb');
				
			$criteria = $log_handler->getFilterCriteria($filter);
			$ttl = $log_handler->getCount($criteria);
			$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'date';
	
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter);
			$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
	
			foreach (array(	'provider','date','alias','tweet','url','hits', 'rank', 'cid', 'catid', 'tags', 'active') as $id => $key) {
				$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
				$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $log_handler->getFilterForm($filter, $key, $sort, $op, $fct));
			}
			
			$GLOBALS['xorTpl']->assign('limit', $limit);
			$GLOBALS['xorTpl']->assign('start', $start);
			$GLOBALS['xorTpl']->assign('order', $order);
			$GLOBALS['xorTpl']->assign('sort', $sort);
			$GLOBALS['xorTpl']->assign('filter', $filter);
			$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
								
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort('`'.$sort.'`');
			$criteria->setOrder($order);
				
			$logs = $log_handler->getObjects($criteria, true);
			foreach($logs as $id => $log) {
				$GLOBALS['xorTpl']->append('log', $log->toArray());
			}
					
			$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_log.html');
			break;
		case "retweet":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(9);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					
					$criteria = $retweet_handler->getFilterCriteria($filter);
					$ttl = $retweet_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xorTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'rid','search','skip','geocode','longitude','latitude','radius','measurement',
									'language', 'type', 'uid', 'retweets', 'searched', 'created', 'updated', 'actioned', 'retweeted') as $id => $key) {
						$GLOBALS['xorTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xorTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $retweet_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xorTpl']->assign('limit', $limit);
					$GLOBALS['xorTpl']->assign('start', $start);
					$GLOBALS['xorTpl']->assign('order', $order);
					$GLOBALS['xorTpl']->assign('sort', $sort);
					$GLOBALS['xorTpl']->assign('filter', $filter);
					$GLOBALS['xorTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$retweets = $retweet_handler->getObjects($criteria, true);
					foreach($retweets as $rid => $retweet) {
						if (is_object($retweet))					
							$GLOBALS['xorTpl']->append('retweet', $retweet->toArray());
					}
					
					$GLOBALS['xorTpl']->assign('form', tweetbomb_retweet_get_form(false));
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_retweet_list.html');
					
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(9);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xorTpl'] = new XoopsTpl();
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$retweet = $retweet_handler->get(intval($_REQUEST['id']));
					} else {
						$retweet = $retweet_handler->create();
					}
					
					$GLOBALS['xorTpl']->assign('form', $retweet->getForm());
					$GLOBALS['xorTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xorTpl']->display('db:twitterbomb_cpanel_retweet_edit.html');
					break;
				case "save":
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$retweet = $retweet_handler->get($id);
					} else {
						$retweet = $retweet_handler->create();
					}
					$retweet->setVars($_POST[$id]);
					if (!isset($_POST[$id]['geocode'])||empty($_POST[$id]['geocode'])||$_POST[$id]['geocode']!=1)
						$retweet->setVar('geocode', false);
					else 
						$retweet->setVar('geocode', true);
					if (!$id=$retweet_handler->insert($retweet)) {
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_RETWEET_FAILEDTOSAVE);
						exit(0);
					} else {
						redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_RETWEET_SAVEDOKEY);
						exit(0);
					}
					break;
				case "savelist":
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					foreach($_REQUEST['id'] as $id) {
						$retweet = $retweet_handler->get($id);
						$retweet->setVars($_POST[$id]);
						if (!isset($_POST[$id]['geocode'])||empty($_POST[$id]['geocode'])||$_POST[$id]['geocode']!=1)
							$retweet->setVar('geocode', false);
						else 
							$retweet->setVar('geocode', true);
							
						if (!$retweet_handler->insert($retweet)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_RETWEET_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_RETWEET_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$retweet = $retweet_handler->get($id);
						if (!$retweet_handler->delete($retweet)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_RETWEET_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_RETWEET_DELETED);
							exit(0);
						}
					} else {
						$retweet = $retweet_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_RETWEET_DELETE, $retweet->getVar('search')));
					}
					break;
			}
			break;								
	}
	
	twitterbomb_footer_adminMenu();
	xoops_cp_footer();
?>