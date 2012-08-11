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
	
	// Version 1.11
	//Select Box Base Definitions
	define('_MI_TWEETBOMB_MODE_TITLE_DIRECT','Direct Entry');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTERED','Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCH','Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIP','Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHSTRIP','Pregmatch + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPPREGMATCH','Strip + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDSTRIP','Filtered + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPFILTERED','Strip + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDPREGMATCH','Filtered + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHFILTERED','Pregmatch + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDPREGMATCHSTRIP','Filtered + Pregmatch + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDSTRIPPREGMATCH','Filtered + Strip + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHFILTEREDSTRIP','Pregmatch + Filtered + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHSTRIPFILTERED','Pregmatch + Strip + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPPREGMATCHFILTERED','Strip + Pregmatch + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPFILTEREDPREGMATCH','Strip + Filtered + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_MIRC','mIRC Logs');
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_BOMB','Phrase Bomb');
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_SCHEDULER','Tweet Scheduler');
	
	//Preferences Definitions
	define('_MI_TWEETBOMB_SCHEDULER_ITEMS','Tweet Scheduler - RSS Items');
	define('_MI_TWEETBOMB_SCHEDULER_ITEMS_DESC','Number of items to return on RSS Feeds of a tweet scheduler campaign.');
	define('_MI_TWEETBOMB_SCHEDULER_CACHE','Tweet Scheduler - Number of Seconds RSS Feed is cached!');
	define('_MI_TWEETBOMB_SCHEDULER_CACHE_DESC','Total number of seconds the RSS Feed is cached for before getting the next set of scheduled tweets.');
	define('_MI_TWEETBOMB_KILL_TWEETED','Tweet Scheduler - Kill Tweeted after seconds');
	define('_MI_TWEETBOMB_KILL_TWEETED_DESC','Tweet Scheduler - Kill Tweeted and remove from the database this record after so many seconds. (0 - Disabled)');
	define('_MI_TWEETBOMB_NUMBER_TO_RANK','Tweet Scheduler - Number of Tweets to Keep in Rank');
	define('_MI_TWEETBOMB_NUMBER_TO_RANK_DESC','Tweet Scheduler - Number of Tweets to keep in scheduler rank - that are not in rank if you disable this it will not keep a rank score and all will be killed. (0 - Disabled)');
	define('_MI_TWEETBOMB_SCHEDULER_AGGREGATE','Tweet Scheduler - Aggregate with a # Words Meeting length?');
	define('_MI_TWEETBOMB_SCHEDULER_AGGREGATE_DESC','This will place a hash symbol infront of words seperated by a space.');
	define('_MI_TWEETBOMB_SCHEDULER_WORDLENGTH','Tweet Scheduler - Aggregated Word Length');
	define('_MI_TWEETBOMB_SCHEDULER_WORDLENGTH_DESC','This is the minimal number of characters for aggreagated words.');
	define('_MI_TWEETBOMB_LOG_BOMB','Log Bomb Providers');
	define('_MI_TWEETBOMB_LOG_BOMB_DESC','When Twitter Bomb bomb\'s something on the feeds, then log it!');
	define('_MI_TWEETBOMB_LOG_SCHEDULER','Log Secheduler Provider');
	define('_MI_TWEETBOMB_LOG_SCHEDULER_DESC','When Twitter Bomb sechedules\'s as tweet, then log it!');
	define('_MI_TWEETBOMB_LOGDROPS','Log Deletes Itself After');
	define('_MI_TWEETBOMB_LOGDROPS_DESC','This is how long the log stays on your site for after a record reaches this age it is deleted!');
		
	//Prefence options
	define('_MI_TWEETBOMB_LOGDROPS_24HOURS','24 Hours');
	define('_MI_TWEETBOMB_LOGDROPS_1WEEK','1 Week');
	define('_MI_TWEETBOMB_LOGDROPS_FORTNIGHT','A Fortnight');
	define('_MI_TWEETBOMB_LOGDROPS_1MONTH','1 Month');
	define('_MI_TWEETBOMB_LOGDROPS_2MONTHS','2 Months');
	define('_MI_TWEETBOMB_LOGDROPS_3MONTHS','3 Months');
	define('_MI_TWEETBOMB_LOGDROPS_4MONTHS','4 Months');
	define('_MI_TWEETBOMB_LOGDROPS_5MONTHS','5 Months');
	define('_MI_TWEETBOMB_LOGDROPS_6MONTHS','6 Months');
	define('_MI_TWEETBOMB_LOGDROPS_12MONTHS','1 Year');
	define('_MI_TWEETBOMB_LOGDROPS_24MONTHS','2 Years');
	define('_MI_TWEETBOMB_LOGDROPS_36MONTHS','3 Years');
	
	// Admin Menus
	define('_MI_TWEETBOMB_TITLE_ADMENU7','Tweet Scheduler');
	define('_MI_TWEETBOMB_ICON_ADMENU7','');
	define('_MI_TWEETBOMB_LINK_ADMENU7','admin/index.php?op=scheduler&fct=list');
	define('_MI_TWEETBOMB_TITLE_ADMENU8','Tweet Log');
	define('_MI_TWEETBOMB_ICON_ADMENU8','');
	define('_MI_TWEETBOMB_LINK_ADMENU8','admin/index.php?op=log');	
?>