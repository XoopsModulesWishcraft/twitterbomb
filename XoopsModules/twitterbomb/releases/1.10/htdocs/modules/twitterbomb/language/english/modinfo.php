<?php

	define('_MI_TWEETBOMB_ANONYMOUS','Anonymous');
	
	// Select Box Definitions
	define('_MI_TWEETBOMB_NONE','None at All');
	
	//Select Box Base Definitions
	define('_MI_TWEETBOMB_BASE_TITLE_FOR','For Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_WHEN','When Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_CLAUSE','Clause Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THEN','Then Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_OVER','Over Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_UNDER','Under Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THEIR','Their Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THERE','There Phrase');
	
	// Admin Menus
	define('_MI_TWEETBOMB_TITLE_ADMENU1','Campaign Trail');
	define('_MI_TWEETBOMB_ICON_ADMENU1','');
	define('_MI_TWEETBOMB_LINK_ADMENU1','admin/index.php?op=campaign&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU2','Categories');
	define('_MI_TWEETBOMB_ICON_ADMENU2','');
	define('_MI_TWEETBOMB_LINK_ADMENU2','admin/index.php?op=category&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU3','Keywords/Key Phrases');
	define('_MI_TWEETBOMB_ICON_ADMENU3','');
	define('_MI_TWEETBOMB_LINK_ADMENU3','admin/index.php?op=keywords&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU4','Keyword Matrix');
	define('_MI_TWEETBOMB_ICON_ADMENU4','');
	define('_MI_TWEETBOMB_LINK_ADMENU4','admin/index.php?op=base_matrix&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU5','Twitter Username');
	define('_MI_TWEETBOMB_ICON_ADMENU5','');
	define('_MI_TWEETBOMB_LINK_ADMENU5','admin/index.php?op=usernames&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU6','Search URLS');
	define('_MI_TWEETBOMB_ICON_ADMENU6','');
	define('_MI_TWEETBOMB_LINK_ADMENU6','admin/index.php?op=urls&fct=list');
	
	// XOOPS_VERSION.PHP - Version 1.01
	define('_MI_TWEETBOMB_NAME','Twitter Bomb');
	define('_MI_TWEETBOMB_DESCRIPTION','Twitter Bomb is a module for XOOPS which allows keyword/keyphrase combination campaigns!');
	define('_MI_TWEETBOMB_DIRNAME','twitterbomb');
	
	// Submenus Definitions
	define('_MI_TWEETBOMBS_MENU_USERNAME','Add Twitter Username');
	
	//Preferences Definitions
	define('_MI_TWEETBOMB_AGGREGATE','Aggregate with a # Words Meeting length?');
	define('_MI_TWEETBOMB_AGGREGATE_DESC','This will place a hash symbol infront of words seperated by a space.');
	define('_MI_TWEETBOMB_WORDLENGTH','Aggregated Word Length');
	define('_MI_TWEETBOMB_WORDLENGTH_DESC','This is the minimal number of characters for aggreagated words.');
	define('_MI_TWEETBOMB_ITEMS','RSS Items');
	define('_MI_TWEETBOMB_ITEMS_DESC','Number of items to return on RSS Feeds');
	define('_MI_TWEETBOMB_HTACCESS','HTAccess SEO');
	define('_MI_TWEETBOMB_HTACCESS_DESC','You need to alter your .htaccess for this.');
	define('_MI_TWEETBOMB_BASEURL','Base of URL for SEO');
	define('_MI_TWEETBOMB_BASEURL_DESC','Base path of SEO');
	define('_MI_TWEETBOMB_ENDOFURL','End of URL for HTML');
	define('_MI_TWEETBOMB_ENDOFURL_DESC','End of URL for standard output.');
	define('_MI_TWEETBOMB_ENDOFURLRSS','End of URL for RSS');
	define('_MI_TWEETBOMB_ENDOFURLRSS_DESC','End of URL for RSS Output.');
	
	// Version 1.05
	//Preferences Definitions
	define('_MI_TWEETBOMB_ANONYMOUS','Anonymous Guest can Submit Twitter Usernames?');
	define('_MI_TWEETBOMB_ANONYMOUS_DESC','Allows anonymous guest to submit twitter usernames to campaigns and categories.');
	define('_MI_TWEETBOMB_CACHE','Number of Seconds RSS Feed is cached!');
	define('_MI_TWEETBOMB_CACHE_DESC','Total number of seconds the RSS Feed is cached for.');
?>