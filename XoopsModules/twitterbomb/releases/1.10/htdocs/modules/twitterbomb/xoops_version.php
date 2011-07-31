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
$modversion['version'] = 1.10;
$modversion['releasedate'] = "Monday: August 1, 2011";
$modversion['description'] = _MI_TWEETBOMB_DESCRIPTION;
$modversion['author'] = "Wishcraft";
$modversion['credits'] = "Simon Roberts (simon@chronolabs.coop)";
$modversion['help'] = "spiders.html";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['status']  = "Stable";
$modversion['image'] = "images/twitterbomb_slogo.png";
$modversion['dirname'] = _MI_TWEETBOMB_DIRNAME;

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
$modversion['hasMain'] = 1;

$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'aggregate';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_AGGREGATE";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_AGGREGATE_DESC";
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
$modversion['config'][$i]['name'] = 'items';
$modversion['config'][$i]['title'] = "_MI_TWEETBOMB_ITEMS";
$modversion['config'][$i]['description'] = "_MI_TWEETBOMB_ITEMS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

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
$modversion['config'][$i]['default'] = 900;
?>
