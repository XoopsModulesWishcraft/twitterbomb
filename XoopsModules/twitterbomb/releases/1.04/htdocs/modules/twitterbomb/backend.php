<?php
/**
 * XOOPS feed creator
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.0.0
 * @version         $Id: backend.php 4941 2010-07-22 17:13:36Z beckmi $
 */
 
include '../../mainfile.php';
include('include/functions.php');	

if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
else 
	$ip = $_SERVER["REMOTE_ADDR"];

$cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:'0';
$catid = isset($_REQUEST['catid'])?$_REQUEST['catid']:'0';
$cacheid = isset($_REQUEST['cacheid'])?$_REQUEST['cacheid']:md5($cid.$catid.$ip);

if ($GLOBALS['xoopsModuleConfig']['htaccess']) {
	$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/rss,'.$cid.','.$catid.','.$cacheid.$GLOBALS['xoopsModuleConfig']['endofurl_rss'];
	if (strpos($url, $_SERVER['REQUEST_URI'])==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
}

$GLOBALS['xoopsLogger']->activated = false;
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
header('Content-Type:text/xml; charset=utf-8');

include_once $GLOBALS['xoops']->path('class/template.php');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(900);
if (!$tpl->is_cached('db:twitterbomb_rss.html', $cacheid, $cacheid)) {
    xoops_load('XoopsLocal');
    $tpl->assign('channel_title', XoopsLocal::convert_encoding(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
    $tpl->assign('channel_link', XOOPS_URL . '/');
    $tpl->assign('channel_desc', XoopsLocal::convert_encoding(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
    $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    $tpl->assign('channel_webmaster', checkEmail($xoopsConfig['adminmail'], true));
    $tpl->assign('channel_editor', checkEmail($xoopsConfig['adminmail'], true));
    $tpl->assign('channel_category', 'Category');
    $tpl->assign('channel_generator', 'TwitterBomb');
    $tpl->assign('channel_language', _LANGCODE);
    $tpl->assign('image_url', XOOPS_URL . '/images/logo.png');
    $dimention = getimagesize(XOOPS_ROOT_PATH . '/images/logo.png');
    if (empty($dimention[0])) {
        $width = 88;
    } else {
        $width = ($dimention[0] > 144) ? 144 : $dimention[0];
    }
    if (empty($dimention[1])) {
        $height = 31;
    } else {
        $height = ($dimention[1] > 400) ? 400 : $dimention[1];
    }
    $tpl->assign('image_width', $width);
    $tpl->assign('image_height', $height);
    
    $sarray = twitterbomb_get_rss($GLOBALS['xoopsModuleConfig']['items'], $cid, $catid);
    
    if (!empty($sarray) && is_array($sarray)) {
        foreach ($sarray as $story) {
            $tpl->append('items', array(
                'title' => XoopsLocal::convert_encoding(htmlspecialchars($story['title'], ENT_QUOTES)) ,
                'link' => XoopsLocal::convert_encoding(htmlspecialchars($story['link'], ENT_QUOTES)) ,
                'guid' => XoopsLocal::convert_encoding(htmlspecialchars($story['link'], ENT_QUOTES)) ,
                'pubdate' => formatTimestamp(time(), 'rss') ,
                'description' => XoopsLocal::convert_encoding(htmlspecialchars($story['description'], ENT_QUOTES))));
        }
    }
}
$tpl->display('db:twitterbomb_rss.html');
?>