<?php

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
				if (!$read = XoopsCache::read('twitterbomb_pause_preload_gather_follow')) {
					XoopsCache::write('twitterbomb_pause_preload_gather_follow', true, $twConfig['interval_of_cron']);
					ob_start();
					include($GLOBALS['xoops']->path('/modules/twitterbomb/cron/gather.php'));
					include($GLOBALS['xoops']->path('/modules/twitterbomb/cron/follow.php'));
					ob_end_clean();
				}
				break;
		}
    }
    
    ?>