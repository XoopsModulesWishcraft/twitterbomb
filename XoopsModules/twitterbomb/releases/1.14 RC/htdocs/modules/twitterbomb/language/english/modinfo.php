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
	
	// Version 1.12
	//Preferences Definitions
	define('_MI_TWEETBOMB_SCHEDULER_USERNAMES','Tweet Scheduler - Keyword phrase for twitter username associations');
	define('_MI_TWEETBOMB_SCHEDULER_USERNAMES_DESC','Must contain a phrase that has words with the position of the twitter username replaced with <em>%username%</em>.');
	define('_MI_TWEETBOMB_SUPPORTTAGS','Support Tagging');
	define('_MI_TWEETBOMB_SUPPORTTAGS_DESC','Support Tag (2.3 or later)<br/><a href="http://sourceforge.net/projects/xoops/files/XOOPS%20Module%20Repository/XOOPS%20tag%202.30%20RC/">Download Tag Module</a>');
	
	//Version 1.13
	//Preferences Definitions
	define('_MI_TWEETBOMB_CONSUMER_KEY','Twitter Application Consumer Key');
	define('_MI_TWEETBOMB_CONSUMER_KEY_DESC','To get a <em>consumer key</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_CONSUMER_SECRET','Twitter Application Consumer Secret');
	define('_MI_TWEETBOMB_CONSUMER_SECRET_DESC','To get a <em>consumer secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_REQUEST_URL','Twitter Application Request URL');
	define('_MI_TWEETBOMB_REQUEST_URL_DESC','To get a <em>request url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_AUTHORISE_URL','Twitter Application Authorise URL');
	define('_MI_TWEETBOMB_AUTHORISE_URL_DESC','To get a <em>authorise url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_AUTHENTICATE_URL','Twitter Authentication URL');
	define('_MI_TWEETBOMB_AUTHENTICATE_URL_DESC','To get a <em>authentication url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_URL','Twitter Application Access Token URL');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_URL_DESC','To get a <em>access token url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_CALLBACK_URL','Twitter Application Callback URL');
	define('_MI_TWEETBOMB_CALLBACK_URL_DESC','Do not change this unless you are certain you know the setting, this is also the setting for the twitter application call back URL.');
	define('_MI_TWEETBOMB_ACCESS_TOKEN','Twitter Application Root Access Token');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_DESC','To get a <em>access token</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_SECRET','Twitter Application Root Access Token Secret');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_SECRET_DESC','To get a <em>access token secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ROOT_TWEETER','Main Default Twitter Username (root)');
	define('_MI_TWEETBOMB_ROOT_TWEETER_DESC','Your default twitter username for the basis of following etc. (without the @)');
	define('_MI_TWEETBOMB_CRONTYPE','Cron execution type');
	define('_MI_TWEETBOMB_CRONTYPE_DESC','This is the type of cron job that is being executed. If you have set up a cronjob as per INSTALL then please select either the \'cron job\' or \'scheduler\'.');
	define('_MI_TWEETBOMB_CRONTYPE_PRELOADER','Preloader');
	define('_MI_TWEETBOMB_CRONTYPE_CRONTAB','UNIX Cron Job');
	define('_MI_TWEETBOMB_CRONTYPE_SCHEDULER','Windows Scheduled Task');
	define('_MI_TWEETBOMB_INTERVAL_OF_CRON','Interval of Cron');
	define('_MI_TWEETBOMB_INTERVAL_OF_CRON_DESC','This is the interval between executions of the cron job. (In Seconds)');
	define('_MI_TWEETBOMB_RUNTIME_OF_CRON','Runtime of Cron');
	define('_MI_TWEETBOMB_RUNTIME_OF_CRON_DESC','This is how long the cron executes for in it runtime operations. (In Seconds)');
	define('_MI_TWEETBOMB_TWEETS_PER_SESSION','Tweets per Cron Session');
	define('_MI_TWEETBOMB_TWEETS_PER_SESSION_DESC','Number of Tweet issued per section per cron task execution.');
	define('_MI_TWEETBOMB_SALT','Salt Password for Encryption and Hashing');
	define('_MI_TWEETBOMB_SALT_DESC','Do not change on production machines!');
	define('_MI_TWEETBOMB_KEEPTRENDFOR','Cache trend results for this period.');
	define('_MI_TWEETBOMB_KEEPTRENDFOR_DESC','To improve performance trends of topics are cached for this period.');
	define('_MI_TWEETBOMB_TRENDTYPE','Trend type to retrieve');
	define('_MI_TWEETBOMB_TRENDTYPE_DESC','This is the type of trend that is retrieved from the twitter API');
	
	//Preference Options
	define('_MI_TWEETBOMB_CRONTYPE_RSS','Aggregated Via RSS Feed');
	define('_MI_TWEETBOMB_CRONTYPE_PRELOADER','Aggregated Via API & Preloader');
	define('_MI_TWEETBOMB_CRONTYPE_CRONTAB','Aggregated Via API & Cron Job');
	define('_MI_TWEETBOMB_CRONTYPE_SCHEDULER','Aggregated Via API & a Scheduled Task');
	define('_MI_TWEETBOMB_CACHE_30SECONDS','Cache for 30 Seconds');
	define('_MI_TWEETBOMB_CACHE_60SECONDS','Cache for 1 Minute');
	define('_MI_TWEETBOMB_CACHE_120SECONDS','Cache for 2 Minutes');
	define('_MI_TWEETBOMB_CACHE_240SECONDS','Cache for 4 Minutes');
	define('_MI_TWEETBOMB_CACHE_480SECONDS','Cache for 8 Minutes');
	define('_MI_TWEETBOMB_CACHE_960SECONDS','Cache for 16 Minutes');
	define('_MI_TWEETBOMB_CACHE_1820SECONDS','Cache for 32 Minutes');
	define('_MI_TWEETBOMB_CACHE_1HOUR','Cache for 1 Hour');
	define('_MI_TWEETBOMB_CACHE_3HOUR','Cache for 3 Hour');
	define('_MI_TWEETBOMB_CACHE_6HOURS','Cache for 6 Hours');
	define('_MI_TWEETBOMB_CACHE_12HOURS','Cache for 12 Hours');
	define('_MI_TWEETBOMB_CACHE_24HOURS','Cache for 1 Day');
	define('_MI_TWEETBOMB_CACHE_1WEEK','Cache for 1 Week');
	define('_MI_TWEETBOMB_CACHE_FORTNIGHT','Cache for 1 Fortnight');
	define('_MI_TWEETBOMB_CACHE_1MONTH','Cache for 1 Month');
	define('_MI_TWEETBOMB_TREND_STANDARD','Standard Trend');
	define('_MI_TWEETBOMB_TREND_CURRENT','Current Trend');
	define('_MI_TWEETBOMB_TREND_DAILY','Daily Trend');
	define('_MI_TWEETBOMB_TREND_WEEKLY','Weeky Trend');
	
	//Enumerators
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_VALID','Valid');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_INVALID','Invalid');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_EXPIRED','Expired');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_DISABLED','Disabled');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_OTHER','Other');
	
	//Select Box Definitions
	define('_MI_TWEETBOMB_BASE_TITLE_TREND','Trending Topic');
	
	//User Menus
	define('_MI_TWEETBOMBS_MENU_AUTHORISE','Authorise App at Twitter');
	
	//Version 1.14
	//Preferences Definitions
	define('_MI_TWEETBOMB_LOOK_FOR_FRIENDS','How many seconds delay between looking for new friends');
	define('_MI_TWEETBOMB_LOOK_FOR_FRIENDS_DESC','Number of seconds delay between looking for new friends.');
	define('_MI_TWEETBOMB_LOOK_FOR_MENTION','How may seconds delay between looking for new mentions');
	define('_MI_TWEETBOMB_LOOK_FOR_MENTION_DESC','Number of seconds delat between looking for new mentions.');
	define('_MI_TWEETBOMB_GATHER_PER_SESSION','How many usernames to process per cron session for new friends');
	define('_MI_TWEETBOMB_GATHER_PER_SESSION_DESC','Number of  usernames to process per cron session for new friends.');
	define('_MI_TWEETBOMB_CRON_FOLLOW','Run following script on cronjob?');
	define('_MI_TWEETBOMB_CRON_FOLLOW_DESC','Whether you want to scan and set people to follow from the username tables.');
	define('_MI_TWEETBOMB_CRON_GATHER','Run gather script on cronjob?');
	define('_MI_TWEETBOMB_CRON_GATHER_DESC','Whether you want to scan for new usernames for the username tables.');
	define('_MI_TWEETBOMB_CRON_TWEET','Run generate tweets script on cronjob?');
	define('_MI_TWEETBOMB_CRON_TWEET_DESC','Whether you want tweets to be cronned.');
	
?>