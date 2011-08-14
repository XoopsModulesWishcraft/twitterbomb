<?php

require_once('../../mainfile.php');
$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
@$oauth_handler->getTempAuthenticaton();

?>