<?php
	
	require('header.php');
	
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"dashboard";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$filter = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';
	
	switch($op) {
		default:
			$_GET['op'] = 'dashboard';
			
		case "dashboard":
					
			echo twitterbomb_adminMenu(0);
			
		    $base_matrix_handler = xoops_getmodulehandler('base_matrix', 'twitterbomb');
		    $campaign_handler = xoops_getmodulehandler('campaign', 'twitterbomb');
		    $category_handler = xoops_getmodulehandler('category', 'twitterbomb');
		    $keywords_handler = xoops_getmodulehandler('keywords', 'twitterbomb');
		    $log_handler = xoops_getmodulehandler('log', 'twitterbomb');
		    $retweet_handler = xoops_getmodulehandler('retweet', 'twitterbomb');
		    $scheduler_handler = xoops_getmodulehandler('scheduler', 'twitterbomb');
		    $urls_handler = xoops_getmodulehandler('urls', 'twitterbomb');
		    $usernames_handler = xoops_getmodulehandler('usernames', 'twitterbomb');

		 	$indexAdmin = new ModuleAdmin();	
		    $indexAdmin->addInfoBox(_AM_TWEETBOMB_ADMIN_COUNTS);
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CAMPAIGNSBOMB."</label>", $campaign_handler->getCount(new Criteria('`type`', 'bomb', '=')), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CAMPAIGNSSCHEDULER."</label>", $campaign_handler->getCount(new Criteria('`type`', 'scheduler', '=')), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CAMPAIGNSRETWEET."</label>", $campaign_handler->getCount(new Criteria('`type`', 'retweet', '=')), 'Green');

		    $criteria_a = new CriteriaCompo(new Criteria('timed', '0'));
			$criteria_b = new CriteriaCompo(new Criteria('timed', '1'));
			$criteria_b->add(new Criteria('start', time(), '<'));
			$criteria_b->add(new Criteria('end', time(), '>'));
			$criteria = new CriteriaCompo($criteria_a);
			$criteria->add($criteria_b, 'OR');

		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CAMPAIGNSACTIVE."</label>", $campaign_handler->getCount($criteria), 'Orange');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CAMPAIGNSINACTIVE."</label>", ($campaign_handler->getCount(NULL)-$campaign_handler->getCount($criteria)), 'Orange');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_CATEGORIES."</label>", $category_handler->getCount(NULL), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_KEYWORDS."</label>", $keywords_handler->getCount(NULL), 'Green');
			$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_URLS."</label>", $urls_handler->getCount(NULL), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_RETWEETS."</label>", $retweet_handler->getCount(NULL), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_SCHEDULERTOTAL."</label>", $scheduler_handler->getCount(NULL), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_SCHEDULERWAITING."</label>", $scheduler_handler->getCount(new Criteria('`tweeted`', '0', '=')), 'Green');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_SCHEDULERTWEETED."</label>", $scheduler_handler->getCount(new Criteria('`tweeted`', '0', '!=')), 'Green');
			$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGTOTAL."</label>", $log_handler->getCount(NULL), 'Orange');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGBOMB."</label>", $log_handler->getCount(new Criteria('`provider`', 'bomb', '=')), 'Orange');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGSCHEDULER."</label>", $log_handler->getCount(new Criteria('`provider`', 'scheduler', '=')), 'Orange');
		    $indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGRETWEET."</label>", $log_handler->getCount(new Criteria('`provider`', 'retweet', '=')), 'Orange');

		    $criteria = new CriteriaCompo(new Criteria('`provider`', 'bomb', '='));
		    $criteria->setSort('`date`');
		    $criteria->setOrder('DESC');
		    $criteria->setLimit(1);
		    $logs = $log_handler->getObjects($criteria, false);
		    if (is_object($logs[0])) {
		    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGLASTBOMB."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    $criteria = new CriteriaCompo(new Criteria('`provider`', 'bomb', '='));
			    $criteria->setSort('`date`');
			    $criteria->setOrder('ASC');
			    $criteria->setLimit(1);
			    $logs = $log_handler->getObjects($criteria, false);
			    if (is_object($logs[0])) {
			    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGFIRSTBOMB."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    }
		    }
			    		
		    $criteria = new CriteriaCompo(new Criteria('`provider`', 'scheduler', '='));
		    $criteria->setSort('`date`');
		    $criteria->setOrder('DESC');
		    $criteria->setLimit(1);
		    $logs = $log_handler->getObjects($criteria, false);
		    if (is_object($logs[0])) {
		    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGLASTSCHEDULE."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    $criteria = new CriteriaCompo(new Criteria('`provider`', 'scheduler', '='));
			    $criteria->setSort('`date`');
			    $criteria->setOrder('ASC');
			    $criteria->setLimit(1);
			    $logs = $log_handler->getObjects($criteria, false);
			    if (is_object($logs[0])) {
			    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGFIRSTSCHEDULE."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    }
		    }

		    $criteria = new CriteriaCompo(new Criteria('`provider`', 'retweet', '='));
		    $criteria->setSort('`date`');
		    $criteria->setOrder('DESC');
		    $criteria->setLimit(1);
		    $logs = $log_handler->getObjects($criteria, false);
		    if (is_object($logs[0])) {
		    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGLASTRETWEET."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    $criteria = new CriteriaCompo(new Criteria('`provider`', 'retweet', '='));
			    $criteria->setSort('`date`');
			    $criteria->setOrder('ASC');
			    $criteria->setLimit(1);
			    $logs = $log_handler->getObjects($criteria, false);
			    if (is_object($logs[0])) {
			    	$indexAdmin->addInfoBoxLine(_AM_TWEETBOMB_ADMIN_COUNTS, "<label>"._AM_TWEETBOMB_ADMIN_THEREARE_LOGFIRSTRETWEET."</label>", date(_DATESTRING, $logs[0]->getVar('date')), 'Green');
			    }
		    }
		    
		    echo $indexAdmin->renderIndex();	
			
			break;	
		case "about":
			echo twitterbomb_adminMenu(11);
			$paypalitemno='TWITTERBOMB125';
			$aboutAdmin = new ModuleAdmin();
			$about = $aboutAdmin->renderabout($paypalitemno, false);
			$donationform = array(	0 => '<form name="donation" id="donation" action="http://www.chronolabs.coop/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
									1 => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'.constant('_AM_TWITTERBOMB_ABOUT_MAKEDONATE').'</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'._SUBMIT.'" title="'._SUBMIT.'" type="submit"></td></tr></tbody></table>',
									2 => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"></form>',																'D'=>'',
									3 => '',
									4 => '<!-- Start Form Validation JavaScript //-->
	<script type="text/javascript">
	<!--//
	function xoopsFormValidate_donation() { var myform = window.document.donation; 
	var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
	}
	//--></script>
	<!-- End Form Validation JavaScript //-->');
			$paypalform = array(	0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
									1 => '<input name="cmd" value="_s-xclick" type="hidden">',
									2 => '<input name="hosted_button_id" value="%s" type="hidden">',
									3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
									4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
									5 => '</form>');
			for($key=0;$key<=4;$key++) {
				switch ($key) {
					case 2:
						$donationform[$key] =  sprintf($donationform[$key], $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name'))>0?$GLOBALS['xoopsUser']->getVar('name'). ' ['.$GLOBALS['xoopsUser']->getVar('uname').']':$GLOBALS['xoopsUser']->getVar('uname')), $GLOBALS['xoopsUser']->getVar('email'), XOOPS_LICENSE_KEY, strtoupper($GLOBALS['twitterbombModule']->getVar('dirname')),  strtoupper($GLOBALS['twitterbombModule']->getVar('dirname')). ' '.$GLOBALS['twitterbombModule']->getVar('name'));
						break;
				}
			}
			
			$istart = strpos($about, ($paypalform[0]), 1);
			$iend = strpos($about, ($paypalform[5]), $istart+1)+strlen($paypalform[5])-1;
			echo (substr($about, 0, $istart-1));
			echo implode("\n", $donationform);
			echo (substr($about, $iend+1, strlen($about)-$iend-1));
			break;
		case "campaign":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(1);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');

					$criteria = $campaign_handler->getFilterCriteria($filter);
					$ttl = $campaign_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'cid','catid','type','name','description','start','end','timed','uid','created','updated','hits','active') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $campaign_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$campaigns = $campaign_handler->getObjects($criteria, true);
					foreach($campaigns as $cid => $campaign) {
						$GLOBALS['xoopsTpl']->append('campaign', $campaign->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_campaign_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_campaign_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(1);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$campaign = $campaign_handler->get(intval($_REQUEST['id']));
					} else {
						$campaign = $campaign_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $campaign->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_campaign_edit.html');
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
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
						
					$criteria = $category_handler->getFilterCriteria($filter);
					$ttl = $category_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
										
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'catid','pcatdid','name','uid','created','updated','hits','active') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $category_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$categorys = $category_handler->getObjects($criteria, true);
					foreach($categorys as $cid => $category) {
						if (is_object($category))					
							$GLOBALS['xoopsTpl']->append('category', $category->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_category_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_category_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(2);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$category = $category_handler->get(intval($_REQUEST['id']));
					} else {
						$category = $category_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $category->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_category_edit.html');
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
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					$criteria = $keywords_handler->getFilterCriteria($filter);
					$ttl = $keywords_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'kid','cid','catid','base','keyword','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $keywords_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$keywordss = $keywords_handler->getObjects($criteria, true);
					foreach($keywordss as $cid => $keywords) {
						if (is_object($keywords))
							$GLOBALS['xoopsTpl']->append('keywords', $keywords->toArray());
					}
					
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_keywords_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_keywords_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(3);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$keywords_handler =& xoops_getmodulehandler('keywords', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$keywords = $keywords_handler->get(intval($_REQUEST['id']));
					} else {
						$keywords = $keywords_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $keywords->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_keywords_edit.html');
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
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
						
					$criteria = $base_matrix_handler->getFilterCriteria($filter);
					$ttl = $base_matrix_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'baseid','cid','catid','base1','base2','base3','base4','base5','base6','base7','uid','created','actioned','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $base_matrix_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$base_matrixs = $base_matrix_handler->getObjects($criteria, true);
					foreach($base_matrixs as $cid => $base_matrix) {
						if (is_object($base_matrix))
							$GLOBALS['xoopsTpl']->append('base_matrix', $base_matrix->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_base_matrix_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);		
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_base_matrix_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(4);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$base_matrix_handler =& xoops_getmodulehandler('base_matrix', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$base_matrix = $base_matrix_handler->get(intval($_REQUEST['id']));
					} else {
						$base_matrix = $base_matrix_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $base_matrix->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_base_matrix_edit.html');
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
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
						
					$criteria = $usernames_handler->getFilterCriteria($filter);
					$ttl = $usernames_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
								
					foreach (array(	'tid','cid','catid','screen_name','uid','created','updated', 'type', 'source_nick', 'tweeted') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $usernames_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);

					$usernamess = $usernames_handler->getObjects($criteria, true);
					foreach($usernamess as $cid => $usernames) {
						if (is_object($usernames))
							$GLOBALS['xoopsTpl']->append('usernames', $usernames->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_usernames_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);		
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_usernames_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(5);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$usernames_handler =& xoops_getmodulehandler('usernames', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$usernames = $usernames_handler->get(intval($_REQUEST['id']));
					} else {
						$usernames = $usernames_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $usernames->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_usernames_edit.html');
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
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
						
					$criteria = $urls_handler->getFilterCriteria($filter);
					$ttl = $urls_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'urlid','cid','catid','surl','name','description','uid','created','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $urls_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
						
					$urlss = $urls_handler->getObjects($criteria, true);
					foreach($urlss as $cid => $urls) {
						if (is_object($urls))
							$GLOBALS['xoopsTpl']->append('urls', $urls->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_urls_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);					
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_urls_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(6);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$urls_handler =& xoops_getmodulehandler('urls', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$urls = $urls_handler->get(intval($_REQUEST['id']));
					} else {
						$urls = $urls_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $urls->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_urls_edit.html');
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
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
						
					$criteria = $scheduler_handler->getFilterCriteria($filter);
					$ttl = $scheduler_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'sid';
										
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
			
					foreach (array(	'sid', 'cid','catid','mode','pre','text','hits','rank','uid','when','tweeted','created','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $scheduler_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
										
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$schedulers = $scheduler_handler->getObjects($criteria, true);
					foreach($schedulers as $cid => $scheduler) {
						$GLOBALS['xoopsTpl']->append('scheduler', $scheduler->toArray());
					}
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_scheduler_get_form(false));
					$GLOBALS['xoopsTpl']->assign('upload_form', tweetbomb_scheduler_get_upload_form($scheduler_handler));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_scheduler_list.html');
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(7);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xoopsTpl'] = new XoopsTpl();
					
					$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$scheduler = $scheduler_handler->get(intval($_REQUEST['id']));
					} else {
						$scheduler = $scheduler_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $scheduler->getForm());
					$GLOBALS['xoopsTpl']->assign('upload_form', $scheduler_handler->getUploadForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_scheduler_edit.html');
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

			$log_handler =& xoops_getmodulehandler('log', 'twitterbomb');
				
			$criteria = $log_handler->getFilterCriteria($filter);
			$ttl = $log_handler->getCount($criteria);
			$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'date';
	
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
	
			foreach (array(	'provider','date','alias','tweet','url','hits', 'rank', 'cid', 'catid', 'tags', 'active') as $id => $key) {
				$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
				$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $log_handler->getFilterForm($filter, $key, $sort, $op, $fct));
			}
			
			$GLOBALS['xoopsTpl']->assign('limit', $limit);
			$GLOBALS['xoopsTpl']->assign('start', $start);
			$GLOBALS['xoopsTpl']->assign('order', $order);
			$GLOBALS['xoopsTpl']->assign('sort', $sort);
			$GLOBALS['xoopsTpl']->assign('filter', $filter);
			$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
								
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort('`'.$sort.'`');
			$criteria->setOrder($order);
				
			$logs = $log_handler->getObjects($criteria, true);
			foreach($logs as $id => $log) {
				$GLOBALS['xoopsTpl']->append('log', $log->toArray());
			}
					
			$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_log.html');
			break;
		case "retweet":	
			switch ($fct)
			{
				default:
				case "list":				
					twitterbomb_adminMenu(9);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					
					$criteria = $retweet_handler->getFilterCriteria($filter);
					$ttl = $retweet_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'rid','search','skip','geocode','longitude','latitude','radius','measurement',
									'language', 'type', 'uid', 'retweets', 'searched', 'created', 'updated', 'actioned', 'retweeted') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_TWEETBOMB_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $retweet_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$retweets = $retweet_handler->getObjects($criteria, true);
					foreach($retweets as $rid => $retweet) {
						if (is_object($retweet))					
							$GLOBALS['xoopsTpl']->append('retweet', $retweet->toArray());
					}
					
					$GLOBALS['xoopsTpl']->assign('form', tweetbomb_retweet_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_retweet_list.html');
					
					break;		
					
				case "new":
				case "edit":
					
					twitterbomb_adminMenu(9);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					include_once $GLOBALS['xoops']->path( "/class/template.php" );
					$GLOBALS['xoopsTpl'] = new XoopsTpl();
					
					$retweet_handler =& xoops_getmodulehandler('retweet', 'twitterbomb');
					if (isset($_REQUEST['id'])) {
						$retweet = $retweet_handler->get(intval($_REQUEST['id']));
					} else {
						$retweet = $retweet_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', $retweet->getForm());
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:twitterbomb_cpanel_retweet_edit.html');
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