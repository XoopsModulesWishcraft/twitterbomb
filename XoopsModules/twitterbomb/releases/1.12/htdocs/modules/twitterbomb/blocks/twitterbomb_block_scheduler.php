<?php

function b_twitterbomb_block_scheduler_show( $options )
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
	
	$block['tweets']=array();
	if ($campaign->getVar('timed')!=0) {
		if ($campaign->getVar('start')<time()&&$campaign->getVar('end')>time()) {
			if (!$block['tweets'] = XoopsCache::read('tweetbomb_scheduler_'.$cacheid)) {
				$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
				$block['tweets'][0]['link'] = XOOPS_URL;
				$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
		    }
		} else {
			$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_TITLE, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));
			$block['tweets'][0]['link'] = XOOPS_URL;
			$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_RSS_TIMED_DESCRIPTION, date('Y-m-d', $campaign->getVar('start')), date('Y-m-d', $campaign->getVar('end')));		
		}
	} else {
		if (!$block['tweets']  = XoopsCache::read('tweetbomb_scheduler_'.$cacheid)) {
			$block['tweets'][0]['title'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
			$block['tweets'][0]['link'] = XOOPS_URL;
			$block['tweets'][0]['description'] = sprintf(_BL_TWEETBOMB_NO_TWEETS, date('Y-m-d H:i:s', time()));
		}
	}
	foreach($block['tweets'] as $key => $tweet) {
		if (!empty($tweet['sid'])) {
			$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
			$scheduler = $scheduler_handler->get($tweet['sid']);
			if (is_object($scheduler))
				$block['tweets'][$key]['hits'] = $scheduler->getVar('hits');
		} 
	}
	return $block ;
}


function b_twitterbomb_block_scheduler_edit( $options )
{
	include_once($GLOBALS['xoops']->path('/modules/twitterbomb/include/formobjects.twitterbomb.php'));

	$campaign = new XoopsFormSelectCampaigns('', 'options[]', $options[0], 1, false, false, 'scheduler');
	$form = ""._BL_TWITTERBOMB_CID."&nbsp;".$campaign->render();

	return $form ;
}

?>