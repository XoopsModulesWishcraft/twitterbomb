<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class TwitterbombCorePreload extends XoopsPreloadItem
{
	function eventCoreIncludeCommonEnd($args)
    {
    	$module_handler = xoops_gethandler('module');
    	$config_handler = xoops_gethandler('config');
    	$twMod = $module_handler->getByDirname('twitterbomb');
    	if (is_object($twMod)) {
    		$twConfig = $config_handler->getConfigList($twMod->getVar('mid'));
			switch ($twConfig['crontype']) {
				case 'preloader':
					
					break;
			}
    	}
    }

}
?>