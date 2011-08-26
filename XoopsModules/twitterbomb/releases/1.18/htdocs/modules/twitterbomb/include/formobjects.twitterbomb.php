<?php

include_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');

include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectbase.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectcampaigns.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectcategories.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectmode.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselecttype.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectoauthmode.php');
include_once $GLOBALS['xoops']->path('/modules/twitterbomb/include/formselectscreenname.php');

if (file_exists($GLOBALS['xoops']->path('/modules/tag/include/formtag.php')) && $GLOBALS['xoopsModuleConfig']['tags'])
	include_once $GLOBALS['xoops']->path('/modules/tag/include/formtag.php');

xoops_load('pagenav');

?>