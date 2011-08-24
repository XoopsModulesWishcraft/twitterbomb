<?php

// $Author: wishcraft $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Simon Roberts (AKA wishcraft)                                     //
// URL: http://www.chronolabs.org.au                                         //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

$modversion['name'] = _MI_TWEETBOMB_NAME;
$modversion['version'] = 1.15;
$modversion['releasedate'] = "Thursday: August 14, 2011";
$modversion['description'] = _MI_TWEETBOMB_DESCRIPTION;
$modversion['author'] = "Wishcraft";
$modversion['credits'] = "Simon Roberts (simon@chronolabs.coop)";
$modversion['help'] = "twitterbomb.html";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['status']  = "RC";
$modversion['image'] = "images/twitterbomb_slogo.png";
$modversion['dirname'] = _MI_TWEETBOMB_DIRNAME;
$modversion['hasMain'] = 1;

$modversion['author_realname'] = "Simon Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.coop";
$modversion['author_website_name'] = "Chronolabs Cooperative";
$modversion['author_email'] = "simon@chronolabs.coop";
$modversion['demo_site_url'] = "http://xoops.demo.chronolabs.coop";
$modversion['demo_site_name'] = "Chronolabs Co-op XOOPS Demo";
$modversion['support_site_url'] = "";
$modversion['support_site_name'] = "Chronolabs";
$modversion['submit_bug'] = "";
$modversion['submit_feature'] = "";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['onUpdate'] = "include/update.php";
//$modversion['onInstall'] = "include/install.php";
//$modversion['onUninstall'] = "include/uninstall.php";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// $modversion['sqlfile']['postgresql'] = "sql/pgsql.sql";
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "twitterbomb_base_matrix";
$modversion['tables'][1] = "twitterbomb_keywords";
$modversion['tables'][2] = "twitterbomb_urls";
$modversion['tables'][3] = "twitterbomb_usernames";
$modversion['tables'][4] = "twitterbomb_category";
$modversion['tables'][5] = "twitterbomb_campaign";
$modversion['tables'][6] = "twitterbomb_scheduler";
$modversion['tables'][7] = "twitterbomb_oauth";
$modversion['tables'][8] = "twitterbomb_following";

// Blocks
$modversion['blocks'][1]['file'] = "twitterbomb_block_bomb.php";
$modversion['blocks'][1]['name'] = 'Recently Bombed Tweets' ;
$modversion['blocks'][1]['description'] = "Shows recently tweeted scheduled items";
$modversion['blocks'][1]['show_func'] = "b_twitterbomb_block_bomb_show";
$modversion['blocks'][1]['edit_func'] = "b_twitterbomb_block_bomb_edit";
$modversion['blocks'][1]['options'] = "0|10";
$modversion['blocks'][1]['template'] = "twitterbomb_block_tweets.html" ;

$modversion['blocks'][2]['file'] = "twitterbomb_block_scheduler.php";
$modversion['blocks'][2]['name'] = 'Recently Scheduled Tweets' ;
$modversion['blocks'][2]['description'] = "Shows recently tweeted scheduled items";
$modversion['blocks'][2]['show_func'] = "b_twitterbomb_block_scheduler_show";
$modversion['blocks'][2]['edit_func'] = "b_twitterbomb_block_scheduler_edit";
$modversion['blocks'][2]['options'] = "0|10";
$modversion['blocks'][2]['template'] = "twitterbomb_block_tweets.html" ;

$modversion['blocks'][3]['file'] = "twitterbomb_block_topranked.php";
$modversion['blocks'][3]['name'] = 'Recently Ranked Scheduled Tweets' ;
$modversion['blocks'][3]['description'] = "Shows recently top ranking tweeted scheduled items";
$modversion['blocks'][3]['show_func'] = "b_twitterbomb_block_topranked_show";
$modversion['blocks'][3]['edit_func'] = "b_twitterbomb_block_topranked_edit";
$modversion['blocks'][3]['options'] = "10";
$modversion['blocks'][3]['template'] = "twitterbomb_block_tweets_ranked.html" ;

$modversion["blocks"][4]	=	array(	"file"           => "twitterbomb_block_tag.php",
    									"name"           => "TwitterBomb Tag Cloud",
    									"description"    => "Show tag cloud",
    									"show_func"      => "twitterbomb_tag_block_cloud_show",
    									"edit_func"      => "twitterbomb_tag_block_cloud_edit",
    									"options"        => "100|0|150|80",
    									"template"       => "twitterbomb_tag_block_cloud.html"
    							);
    
$modversion["blocks"][5]	= 	array(	"file"           => "twitterbomb_block_tag.php",
								    	"name"           => "TwitterBomb Top Tags",
								    	"description"    => "Show top tags",
								    	"show_func"      => "twitterbomb_tag_block_top_show",
								    	"edit_func"      => "twitterbomb_tag_block_top_edit",
								    	"options"        => "50|30|c",
								    	"template"       => "twitterbomb_tag_block_top.html"
    							);

$modversion['blocks'][6]['file'] = "twitterbomb_block_follow.php";
$modversion['blocks'][6]['name'] = 'Follow Me on Twitter' ;
$modversion['blocks'][6]['description'] = "Shows default root twitter username for follow or can set your own username";
$modversion['blocks'][6]['show_func'] = "b_twitterbomb_block_follow_show";
$modversion['blocks'][6]['edit_func'] = "b_twitterbomb_block_follow_edit";
$modversion['blocks'][6]['options'] = "simonaroberts";
$modversion['blocks'][6]['template'] = "twitterbomb_block_follow.html" ;

$modversion['blocks'][6]['file'] = "twitterbomb_block_tweet.php";
$modversion['blocks'][6]['name'] = 'Tweet Me on Twitter' ;
$modversion['blocks'][6]['description'] = "Shows default root twitter username for tweet or can set your own username";
$modversion['blocks'][6]['show_func'] = "b_twitterbomb_block_tweet_show";
$modversion['blocks'][6]['edit_func'] = "b_twitterbomb_block_tweet_edit";
$modversion['blocks'][6]['options'] = "simonaroberts|horizontal";
$modversion['blocks'][6]['template'] = "twitterbomb_block_tweet.html" ;

$modversion['blocks'][7]['file'] = "twitterbomb_block_widget.php";
$modversion['blocks'][7]['name'] = 'Widget on Twitter' ;
$modversion['blocks'][7]['description'] = "Shows default root twitter username for widget or can set your own username";
$modversion['blocks'][7]['show_func'] = "b_twitterbomb_block_widget_show";
$modversion['blocks'][7]['edit_func'] = "b_twitterbomb_block_widget_edit";
$modversion['blocks'][7]['options'] = "simonaroberts|5|10000|300|#333333|#ffffff|#000000|#ffffff|#4aed05|true|true|true|true|true|true";
$modversion['blocks'][7]['template'] = "twitterbomb_block_widget.html" ;

// Templates
$modversion['templates'][1]['file'] = 'twitterbomb_rss.html';
$modversion['templates'][1]['description'] = 'Main Twitter Bomb RSS Feed';
$modversion['templates'][2]['file'] = 'twitterbomb_usernames.html';
$modversion['templates'][2]['description'] = 'Main Twitter Bomb Add User to Tweet bomb';
$modversion['templates'][3]['file'] = 'twitterbomb_cpanel_usernames_edit.html';
$modversion['templates'][3]['description'] = 'Main Control Panel Twitter Bomb Username Edit';
$modversion['templates'][4]['file'] = 'twitterbomb_cpanel_usernames_list.html';
$modversion['templates'][4]['description'] = 'Main Control Panel Twitter Bomb Username List';
$modversion['templates'][5]['file'] = 'twitterbomb_cpanel_keywords_edit.html';
$modversion['templates'][5]['description'] = 'Main Control Panel Twitter Bomb Keywords Edit';
$modversion['templates'][6]['file'] = 'twitterbomb_cpanel_keywords_list.html';
$modversion['templates'][6]['description'] = 'Main Control Panel Twitter Bomb Keywords List';
$modversion['templates'][7]['file'] = 'twitterbomb_cpanel_urls_edit.html';
$modversion['templates'][7]['description'] = 'Main Control Panel Twitter Bomb URLS Edit';
$modversion['templates'][8]['file'] = 'twitterbomb_cpanel_urls_list.html';
$modversion['templates'][8]['description'] = 'Main Control Panel Twitter Bomb URLS List';
$modversion['templates'][9]['file'] = 'twitterbomb_cpanel_base_matrix_edit.html';
$modversion['templates'][9]['description'] = 'Main Control Panel Twitter Bomb Base Matrix Edit';
$modversion['templates'][10]['file'] = 'twitterbomb_cpanel_base_matrix_list.html';
$modversion['templates'][10]['description'] = 'Main Control Panel Twitter Bomb Base Matrix List';
$modversion['templates'][11]['file'] = 'twitterbomb_categories_list.html';
$modversion['templates'][11]['description'] = 'Main Twitter Bomb Category List';
$modversion['templates'][12]['file'] = 'twitterbomb_category_item.html';
$modversion['templates'][12]['description'] = 'Main Twitter Bomb Category Item';
$modversion['templates'][13]['file'] = 'twitterbomb_index.html';
$modversion['templates'][13]['description'] = 'Main Twitter Bomb Index';
$modversion['templates'][14]['file'] = 'twitterbomb_campaign_list.html';
$modversion['templates'][14]['description'] = 'Main Twitter Bomb Campaign List';
$modversion['templates'][15]['file'] = 'twitterbomb_campaign_item.html';
$modversion['templates'][15]['description'] = 'Main Twitter Bomb Campaign Item';
$modversion['templates'][16]['file'] = 'twitterbomb_cpanel_category_edit.html';
$modversion['templates'][16]['description'] = 'Main Control Panel Twitter Bomb Category Edit';
$modversion['templates'][17]['file'] = 'twitterbomb_cpanel_category_list.html';
$modversion['templates'][17]['description'] = 'Main Control Panel Twitter Bomb Category List';
$modversion['templates'][18]['file'] = 'twitterbomb_cpanel_campaign_edit.html';
$modversion['templates'][18]['description'] = 'Main Control Panel Twitter Bomb Campaign Edit';
$modversion['templates'][19]['file'] = 'twitterbomb_cpanel_campaign_list.html';
$modversion['templates'][19]['description'] = 'Main Control Panel Twitter Bomb Campaign List';
$modversion['templates'][20]['file'] = 'twitterbomb_cpanel_scheduler_edit.html';
$modversion['templates'][20]['description'] = 'Main Control Panel Twitter Bomb Scheduler Edit';
$modversion['templates'][21]['file'] = 'twitterbomb_cpanel_scheduler_list.html';
$modversion['templates'][21]['description'] = 'Main Control Panel Twitter Bomb Scheduler List';
$modversion['templates'][22]['file'] = 'twitterbomb_cpanel_log.html';
$modversion['templates'][22]['description'] = 'Main Control Panel Twitter Bomb Log List';

// Menu
$i = 0;
if ($GLOBALS['xoopsModuleConfig']['anonymous']==true&&!is_object($GLOBALS['xoopsUser'])) {
	$i++;
	$modversion['sub'][$i]['name'] = _MI_TWEETBOMBS_MENU_USERNAME;
	$modversion['sub'][$i]['url'] = "index.php?op=usernames&fct=new";
} elseif (is_object($GLOBALS['xoopsUser'])) {
	$i++;
	$modversion['sub'][$i]['name'] = _MI_TWEETBOMBS_MENU_USERNAME;
	$modversion['sub'][$i]['url'] = "index.php?op=usernames&fct=new";
}
if (!empty($GLOBALS['xoopsModuleConfig']['consumer_key'])&&!empty($GLOBALS['xoopsModuleConfig']['consumer_secret'])) {
	$i++;
	$modversion['sub'][$i]['name'] = _MI_TWEETBOMBS_MENU_AUTHORISE;
	$modversion['sub'][$i]['url'] = "redirect.php";
}

$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'aggregate';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_AGGREGATE";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_AGGREGATE_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'scheduler_aggregate';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SCHEDULER_AGGREGATE";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SCHEDULER_AGGREGATE_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'wordlength';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_WORDLENGTH";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_WORDLENGTH_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3;

$i++;
$modversion['config'][$i]['name'] = 'scheduler_wordlength';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SCHEDULER_WORDLENGTH";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SCHEDULER_WORDLENGTH_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3;

$i++;
$modversion['config'][$i]['name'] = 'items';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ITEMS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ITEMS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;

$i++;
$modversion['config'][$i]['name'] = 'scheduler_items';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SCHEDULER_ITEMS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SCHEDULER_ITEMS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;

$i++;
$modversion['config'][$i]['name'] = 'anonymous';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ANONYMOUS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ANONYMOUS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'cache';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_CACHE";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_CACHE_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*45;

$i++;
$modversion['config'][$i]['name'] = 'scheduler_cache';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SCHEDULER_CACHE";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SCHEDULER_CACHE_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*45;

$i++;
$modversion['config'][$i]['name'] = 'kill_tweeted';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_KILL_TWEETED";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_KILL_TWEETED_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*1;

$i++;
$modversion['config'][$i]['name'] = 'number_to_rank';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_NUMBER_TO_RANK";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_NUMBER_TO_RANK_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 20;

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_HTACCESS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_BASEURL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tweetbomb';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ENDOFURL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_rss';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ENDOFURLRSS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ENDOFURLRSS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.rss';

$i++;
$modversion['config'][$i]['name'] = 'save_bomb';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_LOG_BOMB';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_LOG_BOMB_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'save_scheduler';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_LOG_SCHEDULER';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_LOG_BLOCKED_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'logdrops';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_LOGDROPS';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_LOGDROPS_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (60*60*24*7*4*1);
$modversion['config'][$i]['options'] = array(_MI_TWEETBOMB_LOGDROPS_24HOURS => (60*60*24), _MI_TWEETBOMB_LOGDROPS_1WEEK => (60*60*24*7), _MI_TWEETBOMB_LOGDROPS_FORTNIGHT => (60*60*24*7*2), 
											 _MI_TWEETBOMB_LOGDROPS_1MONTH => (60*60*24*7*4*1), _MI_TWEETBOMB_LOGDROPS_2MONTHS => (60*60*24*7*4*2), _MI_TWEETBOMB_LOGDROPS_3MONTHS => (60*60*24*7*4*3), 
											 _MI_TWEETBOMB_LOGDROPS_4MONTHS => (60*60*24*7*4*4), _MI_TWEETBOMB_LOGDROPS_5MONTHS => (60*60*24*7*4*5), _MI_TWEETBOMB_LOGDROPS_6MONTHS => (60*60*24*7*4*6),
											 _MI_TWEETBOMB_LOGDROPS_12MONTHS => (60*60*24*7*4*12), _MI_TWEETBOMB_LOGDROPS_24MONTHS => (60*60*24*7*4*24));
											 
$i++;
$modversion['config'][$i]['name'] = 'scheduler_usernames';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SCHEDULER_USERNAMES";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SCHEDULER_USERNAMES_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'twitter username is %username%';

$i++;
$modversion['config'][$i]['name'] = 'tags';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SUPPORTTAGS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SUPPORTTAGS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'root_tweeter';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ROOT_TWEETER";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ROOT_TWEETER_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'simonaroberts';

$i++;
$modversion['config'][$i]['name'] = 'consumer_key';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_CONSUMER_KEY";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_CONSUMER_KEY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'consumer_secret';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_CONSUMER_SECRET";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_CONSUMER_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'request_url';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_REQUEST_URL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_REQUEST_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/request_token';

$i++;
$modversion['config'][$i]['name'] = 'authorise_url';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_AUTHORISE_URL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_AUTHORISE_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/authorize';

$i++;
$modversion['config'][$i]['name'] = 'access_token_url';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ACCESS_TOKEN_URL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ACCESS_TOKEN_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/access_token';

$i++;
$modversion['config'][$i]['name'] = 'authenticate_url';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_AUTHENTICATE_URL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_AUTHENTICATE_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/authenticate';

$i++;
$modversion['config'][$i]['name'] = 'callback_url';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_CALLBACK_URL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_CALLBACK_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL.'/modules/twitterbomb/callback/';

$i++;
$modversion['config'][$i]['name'] = 'access_token';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ACCESS_TOKEN";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ACCESS_TOKEN_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'access_token_secret';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ACCESS_TOKEN_SECRET";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ACCESS_TOKEN_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'bitly_username';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_BITLY_USERNAME";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_BITLY_USERNAME_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'bitly_apikey';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_BITLY_APIKEY";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_BITLY_APIKEY_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'bitly_apiurl';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_BITLY_APIURL";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_BITLY_APIURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'http://api.bitly.com/v3';

$i++;
$modversion['config'][$i]['name'] = 'user_agent';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_USER_AGENT";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_USER_AGENT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Mozilla/5.0 (XOOPS 2.x; cURL; PHP 5.x;) TwitterBomb/'.$modversion['version'];

$i++;
$modversion['config'][$i]['name'] = 'keep_trend_for';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_KEEPTRENDFOR';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_KEEPTRENDFOR_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3600;
$modversion['config'][$i]['options'] = array(_MI_TWEETBOMB_CACHE_30SECONDS => 30, _MI_TWEETBOMB_CACHE_60SECONDS => 60, _MI_TWEETBOMB_CACHE_120SECONDS => 120, 
											 _MI_TWEETBOMB_CACHE_240SECONDS => 240, _MI_TWEETBOMB_CACHE_480SECONDS => 480, _MI_TWEETBOMB_CACHE_960SECONDS => 960,
											 _MI_TWEETBOMB_CACHE_1820SECONDS => (60*32), _MI_TWEETBOMB_CACHE_1HOUR => (60*60), _MI_TWEETBOMB_CACHE_3HOUR => (60*60*3),
											 _MI_TWEETBOMB_CACHE_6HOURS => (60*60*6), _MI_TWEETBOMB_CACHE_12HOURS => (60*60*12), _MI_TWEETBOMB_CACHE_24HOURS => (60*60*24), 
											 _MI_TWEETBOMB_CACHE_1WEEK => (60*60*24*7), _MI_TWEETBOMB_CACHE_FORTNIGHT => (60*60*24*7*2), _MI_TWEETBOMB_CACHE_1MONTH => (60*60*24*7*4));

											 
$i++;
$modversion['config'][$i]['name'] = 'trend_type';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_TRENDTYPE';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_TRENDTYPE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'current';
$modversion['config'][$i]['options'] = array(_MI_TWEETBOMB_TREND_STANDARD => '', _MI_TWEETBOMB_TREND_CURRENT => 'current', 
											 _MI_TWEETBOMB_TREND_DAILY => 'daily', _MI_TWEETBOMB_TREND_WEEKLY => 'weekly');
											 
$i++;
$modversion['config'][$i]['name'] = 'crontype';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_CRONTYPE';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_CRONTYPE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'rss';
$modversion['config'][$i]['options'] = 	array(	_MI_TWEETBOMB_CRONTYPE_RSS => 'rss', 
												_MI_TWEETBOMB_CRONTYPE_PRELOADER => 'preloader', 
												_MI_TWEETBOMB_CRONTYPE_CRONTAB => 'crontab', 
												_MI_TWEETBOMB_CRONTYPE_SCHEDULER => 'scheduler'
										);

$i++;
$modversion['config'][$i]['name'] = 'cron_follow';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_CRON_FOLLOW';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_CRON_FOLLOW';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = 	array();

$i++;
$modversion['config'][$i]['name'] = 'cron_gather';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_CRON_GATHER';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_CRON_GATHER';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = 	array();

$i++;
$modversion['config'][$i]['name'] = 'cron_tweet';
$modversion['config'][$i]['title'] = '_MI_TWEETBOMB_CRON_TWEET';
$modversion['config'][$i]['description'] = '_MI_TWEETBOMB_CRON_TWEET';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = 	array();

$i++;
$modversion['config'][$i]['name'] = 'interval_of_cron';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_INTERVAL_OF_CRON";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_INTERVAL_OF_CRON_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60;

$i++;
$modversion['config'][$i]['name'] = 'tweets_per_session';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_TWEETS_PER_SESSION";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_TWEETS_PER_SESSION_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;

$i++;
$modversion['config'][$i]['name'] = 'look_for_friends';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_LOOK_FOR_FRIENDS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_LOOK_FOR_FRIENDS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (60*60*12);

$i++;
$modversion['config'][$i]['name'] = 'look_for_mention';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_LOOK_FOR_MENTION";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_LOOK_FOR_MENTION_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (60*60*12);

$i++;
$modversion['config'][$i]['name'] = 'gather_per_session';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_GATHER_PER_SESSION";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_GATHER_PER_SESSION_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;


$i++;
$modversion['config'][$i]['name'] = 'salt';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_SALT";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_SALT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = (mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)<>2?chr(mt_rand(32,190)):'');

?>
