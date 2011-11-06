<?php
/**
 * XOOPS feed creator
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.0.0
 * @version         $Id$
 */
set_time_limit(180);
include '../../mainfile.php';
include('include/functions.php');	

$cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:'0';
$catid = isset($_REQUEST['catid'])?$_REQUEST['catid']:'0';
$cacheid = isset($_REQUEST['cacheid'])?$_REQUEST['cacheid']:md5($cid.$catid);

if ($cacheid != md5($cid.$catid))
	$cacheid = md5($cid.$catid);
	
if ($GLOBALS['xoopsModuleConfig']['htaccess']) {
	$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/rss,'.$cid.','.$catid.','.$cacheid.$GLOBALS['xoopsModuleConfig']['endofurl_rss'];
	if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
}

$GLOBALS['xoopsLogger']->activated = false;
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
header('Content-Type:text/xml; charset=utf-8');

include_once $GLOBALS['xoops']->path('class/template.php');
$tpl = new XoopsTpl();

	xoops_load('XoopsLocal');
    $tpl->assign('channel_title', XoopsLocal::convert_encoding(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
    $tpl->assign('channel_link', XOOPS_URL . '/');
    $tpl->assign('channel_desc', XoopsLocal::convert_encoding(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
    $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    $tpl->assign('channel_webmaster', checkEmail($xoopsConfig['adminmail'], true));
    $tpl->assign('channel_editor', checkEmail($xoopsConfig['adminmail'], true));
    $tpl->assign('channel_category', 'Category');
    $tpl->assign('channel_generator', 'TwitterBomb');
    $tpl->assign('channel_language', _LANGCODE);
    $tpl->assign('image_url', XOOPS_URL . '/images/logo.png');
    $dimention = getimagesize(XOOPS_ROOT_PATH . '/images/logo.png');
    if (empty($dimention[0])) {
        $width = 88;
    } else {
        $width = ($dimention[0] > 144) ? 144 : $dimention[0];
    }
    if (empty($dimention[1])) {
        $height = 31;
    } else {
        $height = ($dimention[1] > 400) ? 400 : $dimention[1];
    }
    $tpl->assign('image_width', $width);
    $tpl->assign('image_height', $height);
	
    xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	$campaign_handler = &xoops_getmodulehandler('campaign','twitterbomb');
	$campaign = $campaign_handler->get($cid);
	
	if ($campaign->getVar('timed')!=0) {
		if ($campaign->getVar('start')<time()&&$campaign->getVar('end')>time()) {
			if (!$sarray = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid)) {
				switch ($campaign->getVar('type')) {
					default:
					case 'bomb':
						$sarray = twitterbomb_get_rss($GLOBALS['xoopsModuleConfig']['items'], $cid, $catid);
			    		XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid, $sarray, $GLOBALS['xoopsModuleConfig']['cache']);
			    		break;
					case 'scheduler':
						$sarray = twitterbomb_get_scheduler_rss($GLOBALS['xoopsModuleConfig']['scheduler_items'], $cid, $catid);
			    		XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid, $sarray, $GLOBALS['xoopsModuleConfig']['scheduler_cache']);
			    		break;	
				} 
		    }
		} else {
			$sarray=array();
			$sarray[0]['title'] = sprintf(_MN_TWEETBOMB_RSS_TIMED_TITLE, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));
			$sarray[0]['link'] = XOOPS_URL;
			$sarray[0]['description'] = sprintf(_MN_TWEETBOMB_RSS_TIMED_DESCRIPTION, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));		
		}
	} else {
		if (!$sarray = XoopsCache::read('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid)) {
			switch ($campaign->getVar('type')) {
				default:
				case 'bomb':
					$sarray = twitterbomb_get_rss($GLOBALS['xoopsModuleConfig']['items'], $cid, $catid);
	    			XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid, $sarray, $GLOBALS['xoopsModuleConfig']['cache']);
	    			break;
				case 'scheduler':
					$sarray = twitterbomb_get_scheduler_rss($GLOBALS['xoopsModuleConfig']['scheduler_items'], $cid, $catid);
	    			XoopsCache::write('tweetbomb_'.$campaign->getVar('type').'_'.$cacheid, $sarray, $GLOBALS['xoopsModuleConfig']['scheduler_cache']);
	    			break;	
			} 
	    }
	}
	
    if (!empty($sarray) && is_array($sarray)) {
        foreach ($sarray as $story) {
            $tpl->append('items', array(
                'title' => XoopsLocal::convert_encoding(htmlspecialchars($story['title'], ENT_QUOTES)) ,
                'link' => XoopsLocal::convert_encoding(htmlspecialchars($story['link'], ENT_QUOTES)) ,
                'guid' => XoopsLocal::convert_encoding(htmlspecialchars($story['link'], ENT_QUOTES)) ,
                'pubdate' => formatTimestamp(time(), 'rss') ,
                'description' => XoopsLocal::convert_encoding(htmlspecialchars($story['description'], ENT_QUOTES))));

            if ($story['sid']!=0){
            	$scheduler_handler = &xoops_getmodulehandler('scheduler','twitterbomb');
				$scheduler = $scheduler_handler->get($story['sid']);
				if ($scheduler->getVar('when')==0)
					$scheduler->setVar('when', time());
				$scheduler->setVar('tweeted', time());
            	$scheduler_handler->insert($scheduler, true);
            }
        }
    }
    

$tpl->display('db:twitterbomb_rss.html');
?>