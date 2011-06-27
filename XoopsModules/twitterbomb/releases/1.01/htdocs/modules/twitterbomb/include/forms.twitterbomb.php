<?php

	function tweetbomb_base_matrix_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('base_matrix', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_BASEMATRIX, 'category', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_BASEMATRIX, 'category', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'base_matrix');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('baseid'));
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_BASEMATRIX, $object->getVar('baseid').'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_BASEMATRIX);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_BASEMATRIX, $object->getVar('baseid').'[catid]', $object->getVar('catid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_BASEMATRIX);
		$ele['base1'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEA_BASEMATRIX, $object->getVar('baseid').'[base1]', $object->getVar('base1'));
		$ele['base1']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEA_BASEMATRIX);
		$ele['base2'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEB_BASEMATRIX, $object->getVar('baseid').'[base2]', $object->getVar('base2'));
		$ele['base2']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEB_BASEMATRIX);
		$ele['base3'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEC_BASEMATRIX, $object->getVar('baseid').'[base3]', $object->getVar('base3'));
		$ele['base3']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEC_BASEMATRIX);
		$ele['base4'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASED_BASEMATRIX, $object->getVar('baseid').'[base4]', $object->getVar('base4'));
		$ele['base4']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASED_BASEMATRIX);
		$ele['base5'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEE_BASEMATRIX, $object->getVar('baseid').'[base5]', $object->getVar('base5'));
		$ele['base5']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEE_BASEMATRIX);
		$ele['base6'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEF_BASEMATRIX, $object->getVar('baseid').'[base6]', $object->getVar('base6'));
		$ele['base6']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEF_BASEMATRIX);
		$ele['base7'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEG_BASEMATRIX, $object->getVar('baseid').'[base7]', $object->getVar('base7'));
		$ele['base7']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEG_BASEMATRIX);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_BASEMATRIX, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_BASEMATRIX, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_BASEMATRIX, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_BASEMATRIX, date(_DATESTRING, $object->getVar('actioned')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_BASEMATRIX, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('base1', 'base2');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}


	function tweetbomb_campaign_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('campaign', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_CAMPAIGN, 'campaign', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_CAMPAIGN, 'campaign', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'campaign');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('cid'));
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CAMPAIGN, $object->getVar('cid').'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_CAMPAIGN);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_CAMPAIGN, $object->getVar('cid').'[description]', 26, 4, $object->getVar('description'));
		$ele['description']->setDescription(_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_CAMPAIGN);
		$ele['start'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_START_CAMPAIGN, $object->getVar('cid').'[start]', $object->getVar('start'));
		$ele['start']->setDescription(_AM_TWEETBOMB_FORM_DESC_START_CAMPAIGN);
		$ele['end'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_END_CAMPAIGN, $object->getVar('cid').'[end]', $object->getVar('end'));
		$ele['end']->setDescription(_AM_TWEETBOMB_FORM_DESC_END_CAMPAIGN);
		$ele['timed'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_TIMED_CAMPAIGN, $object->getVar('cid').'[timed]', $object->getVar('timed'));
		$ele['timed']->setDescription(_AM_TWEETBOMB_FORM_DESC_TIMED_CAMPAIGN);
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CAMPAIGN, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CAMPAIGN, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_CAMPAIGN, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_CAMPAIGN, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('name', 'description');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_category_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('category', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_CATEGORY, 'category', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_CATEGORY, 'category', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'category');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('catid'));
		$ele['pcatdid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_PCATID_CATEGORY, $object->getVar('catid').'[pcatdid]', $object->getVar('pcatdid'));
		$ele['pcatdid']->setDescription(_AM_TWEETBOMB_FORM_DESC_PCATID_CATEGORY);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CATEGORY, $object->getVar('catid').'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_CATEGORY);
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CATEGORY, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_CATEGORY, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_CATEGORY, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_CATEGORY, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('name', 'description');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}	
	
	function tweetbomb_keywords_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('keywords', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_KEYWORDS, 'keywords', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_KEYWORDS, 'keywords', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'keywords');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('kid'));
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_KEYWORDS, $object->getVar('kid').'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_KEYWORDS);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_KEYWORDS, $object->getVar('kid').'[catid]', $object->getVar('catid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_KEYWORDS);
		$ele['base'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASE_KEYWORDS, $object->getVar('kid').'[base]', $object->getVar('base'));
		$ele['base']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASE_KEYWORDS);
		$ele['keyword'] = new XoopsFormText(_AM_TWEETBOMB_FORM_KEYWORD_KEYWORDS, $object->getVar('kid').'[keyword]', 30,35, $object->getVar('keyword'));
		$ele['keyword']->setDescription(_AM_TWEETBOMB_FORM_DESC_KEYWORD_KEYWORDS);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_KEYWORDS, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_KEYWORDS, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_KEYWORDS, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('actioned')>0) {
			$ele['actioned'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_ACTIONED_KEYWORDS, date(_DATESTRING, $object->getVar('actioned')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_KEYWORDS, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('base', 'keyword');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	
	function tweetbomb_usernames_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('usernames', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_USERNAMES, 'usernames', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_USERNAMES, 'usernames', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'usernames');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('tid'));
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_USERNAMES, $object->getVar('tid').'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_USERNAMES);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_USERNAMES, $object->getVar('tid').'[catid]', $object->getVar('catid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_USERNAMES);
		$ele['twitter_username'] = new XoopsFormText(_AM_TWEETBOMB_FORM_USERNAME_USERNAMES, $object->getVar('tid').'[twitter_username]', 30,64, $object->getVar('twitter_username'));
		$ele['twitter_username']->setDescription(_AM_TWEETBOMB_FORM_DESC_USERNAME_USERNAMES);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_USERNAMES, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_USERNAMES, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_USERNAMES, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_USERNAMES, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('twitter_username');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_urls_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('urls', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_URLS, 'urls', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_URLS, 'urls', 'index.php', 'post');

		$ele['op'] = new XoopsFormHidden('op', 'urls');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $object->getVar('urlid'));
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_URLS, $object->getVar('urlid').'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_URLS);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_URLS, $object->getVar('urlid').'[catid]', $object->getVar('catid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_URLS);
		$ele['surl'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SURL_URLS, $object->getVar('urlid').'[surl]', 40,255, $object->getVar('surl'));
		$ele['surl']->setDescription(_AM_TWEETBOMB_FORM_DESC_SURL_URLS);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_URLS, $object->getVar('urlid').'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_URLS);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_URLS, $object->getVar('urlid').'[description]', 26, 4, $object->getVar('description'));
		$ele['description']->setDescription(_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_URLS);
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_URLS, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_URLS, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_URLS, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_URLS, date(_DATESTRING, $object->getVar('updated')));
		}			
		
		$required = array('surl', 'name');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}	
?>
