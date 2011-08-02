<?php
	include('../../mainfile.php');
	include('include/functions.php');	
	
	$cid = isset($_REQUEST['cid'])?intval($_REQUEST['cid']):0;
	$sid = isset($_REQUEST['sid'])?intval($_REQUEST['sid']):0;
	$catid = isset($_REQUEST['catid'])?intval($_REQUEST['catid']):0;
	$uri = isset($_REQUEST['uri'])?$_REQUEST['uri']:'';
	
	if ($cid==0||$url=''||$catid==0) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.XOOPS_URL);
		exit(0);
	}
	
	if ($sid!=0) {
		$scheduler_handler =& xoops_getmodulehandler('scheduler', 'twitterbomb');
		$scheduler_handler->plusHit($sid);
	}           	
	$campaign_handler =& xoops_getmodulehandler('campaign', 'twitterbomb');
	$campaign_handler->plusHit($cid);
	$category_handler =& xoops_getmodulehandler('category', 'twitterbomb');
	$category_handler->plusHit($catid);
		
	header( "HTTP/1.1 301 Moved Permanently" ); 
	header('Location: '.$uri);

?>