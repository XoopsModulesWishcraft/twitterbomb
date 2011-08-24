<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class TwitterbombCorePreload extends XoopsPreloadItem
{
	function eventCoreIncludeCommonEnd($args)
    {
    	xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
    	$module_handler = xoops_gethandler('module');
    	$config_handler = xoops_gethandler('config');
    	$twMod = $module_handler->getByDirname('twitterbomb');
    	if (is_object($twMod)) {
    		$twConfig = $config_handler->getConfigList($twMod->getVar('mid'));
			switch ($twConfig['crontype']) {
				case 'preloader':
					if (!$read = XoopsCache::read('twitterbomb_pause_preload')) {
						XoopsCache::write('twitterbomb_pause_preload', true, $twConfig['interval_of_cron']);
						include('../cron/all.php');
					}
					break;
			}
    	}
    }

}
?>