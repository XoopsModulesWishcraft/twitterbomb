<?php

function b_twitterbomb_block_bomb_show( $options )
{
	if (empty($options[0]))
		return false;
				
	$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
	$campaign = $campaign_handler->get($options[0]);
	$cid = $campaign->getVar('cid');
	$catid = $campaign->getVar('catid');
	$cacheid = md5($cid.$catid);
	
    xoops_load('xoopscache');
	if (!class_exists('XoopsCache')) {
		// XOOPS 2.4 Compliance
		xoops_load('cache');
		if (!class_exists('XoopsCache')) {
			include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
		}
	}
	
	if ($campaign->getVar('timed')!=0) {
		if ($campaign->getVar('start')<time()&&$campaign->getVar('end')>time()) {
			if (!$block['tweets'] = XoopsCache::read('tweetbomb_bomb_'.$cacheid)) {
				$block['tweets']=array();
				$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
				$block['tweets'][0]['link'] = XOOPS_URL;
				$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
		    }
		} else {
			$block['tweets']=array();
			$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_TITLE, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));
			$block['tweets'][0]['link'] = XOOPS_URL;
			$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_DESCRIPTION, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));		
		}
	} else {
		if (!$block['tweets']  = XoopsCache::read('tweetbomb_bomb_'.$cacheid)) {
			$block['tweets']=array();
			$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
			$block['tweets'][0]['link'] = XOOPS_URL;
			$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
		}
	}
	return $block ;
}


function b_twitterbomb_block_bomb_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));

	$campaign = new XoopsFormSelectCampaigns('', 'options[]', $options[0], 1, false, false, 'bomb');
	$form = ""._BL_TWITTERBOMB_CID."&nbsp;".$campaign->render();

	return $form ;
}

?>