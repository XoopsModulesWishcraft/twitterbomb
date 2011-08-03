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

		$id = $object->getVar('baseid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'base_matrix');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_BASEMATRIX, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_BASEMATRIX);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_BASEMATRIX, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_BASEMATRIX);
		$ele['base1'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEA_BASEMATRIX, $id.'[base1]', $object->getVar('base1'));
		$ele['base1']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEA_BASEMATRIX);
		$ele['base2'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEB_BASEMATRIX, $id.'[base2]', $object->getVar('base2'));
		$ele['base2']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEB_BASEMATRIX);
		$ele['base3'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEC_BASEMATRIX, $id.'[base3]', $object->getVar('base3'));
		$ele['base3']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEC_BASEMATRIX);
		$ele['base4'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASED_BASEMATRIX, $id.'[base4]', $object->getVar('base4'));
		$ele['base4']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASED_BASEMATRIX);
		$ele['base5'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEE_BASEMATRIX, $id.'[base5]', $object->getVar('base5'));
		$ele['base5']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEE_BASEMATRIX);
		$ele['base6'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEF_BASEMATRIX, $id.'[base6]', $object->getVar('base6'));
		$ele['base6']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASEF_BASEMATRIX);
		$ele['base7'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASEG_BASEMATRIX, $id.'[base7]', $object->getVar('base7'));
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
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
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_SCHEDULER, 'campaign', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_SCHEDULER, 'campaign', 'index.php', 'post');

		$id = $object->getVar('cid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'campaign');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_CAMPAIGN, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_CAMPAIGN);
		$ele['type'] = new XoopsFormSelectType(_AM_TWEETBOMB_FORM_TYPE_CAMPAIGN, $id.'[type]', $object->getVar('type'));
		$ele['type']->setDescription(_AM_TWEETBOMB_FORM_DESC_TYPE_CAMPAIGN);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CAMPAIGN, $id.'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_CAMPAIGN);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_CAMPAIGN, $id.'[description]', $object->getVar('description'), 4, 26);
		$ele['description']->setDescription(_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_CAMPAIGN);
		$ele['start'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_START_CAMPAIGN, $id.'[start]', 15, $object->getVar('start'));
		$ele['start']->setDescription(_AM_TWEETBOMB_FORM_DESC_START_CAMPAIGN);
		$ele['end'] = new XoopsFormTextDateSelect(_AM_TWEETBOMB_FORM_END_CAMPAIGN, $id.'[end]', 15, $object->getVar('end'));
		$ele['end']->setDescription(_AM_TWEETBOMB_FORM_DESC_END_CAMPAIGN);
		$ele['timed'] = new XoopsFormRadioYN(_AM_TWEETBOMB_FORM_TIMED_CAMPAIGN, $id.'[timed]', $object->getVar('timed'));
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'catid');
		
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

		$id = $object->getVar('catid');
		if (empty($id)) $id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'category');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['pcatdid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_PCATID_CATEGORY, $id.'[pcatdid]', $object->getVar('pcatdid'));
		$ele['pcatdid']->setDescription(_AM_TWEETBOMB_FORM_DESC_PCATID_CATEGORY);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_CATEGORY, $id.'[name]', 26,64, $object->getVar('name'));
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
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

		$id = $object->getVar('kid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'keywords');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_KEYWORDS, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_KEYWORDS);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_KEYWORDS, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_KEYWORDS);
		$ele['base'] = new XoopsFormSelectBase(_AM_TWEETBOMB_FORM_BASE_KEYWORDS, $id.'[base]', $object->getVar('base'));
		$ele['base']->setDescription(_AM_TWEETBOMB_FORM_DESC_BASE_KEYWORDS);
		$ele['keyword'] = new XoopsFormText(_AM_TWEETBOMB_FORM_KEYWORD_KEYWORDS, $id.'[keyword]', 30,35, $object->getVar('keyword'));
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
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
		
		$id = $object->getVar('tid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'usernames');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_USERNAMES, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'bomb');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_USERNAMES);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_USERNAMES, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_USERNAMES);
		$ele['twitter_username'] = new XoopsFormText(_AM_TWEETBOMB_FORM_USERNAME_USERNAMES, $id.'[twitter_username]', 30,64, $object->getVar('twitter_username'));
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
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

		$id = $object->getVar('urlid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'urls');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_URLS, $id.'[cid]', $object->getVar('cid'));
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_URLS);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_URLS, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_URLS);
		$ele['surl'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SURL_URLS, $id.'[surl]', 40,255, $object->getVar('surl'));
		$ele['surl']->setDescription(_AM_TWEETBOMB_FORM_DESC_SURL_URLS);
		$ele['name'] = new XoopsFormText(_AM_TWEETBOMB_FORM_NAME_URLS, $id.'[name]', 26,64, $object->getVar('name'));
		$ele['name']->setDescription(_AM_TWEETBOMB_FORM_DESC_NAME_URLS);
		$ele['description'] = new XoopsFormTextArea(_AM_TWEETBOMB_FORM_DESCRIPTION_URLS, $id.'[description]', $object->getVar('description'), 4, 26);
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
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('surl', 'name');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_usernames_user_form() {
		
		$sform = new XoopsThemeForm(_MN_TWEETBOMB_FORM_ISNEW_USERNAMES, 'usernames', 'index.php', 'post');
	
		$ele['op'] = new XoopsFormHidden('op', 'usernames');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', '0');
		$ele['cid'] = new XoopsFormSelectCampaigns(_MN_TWEETBOMB_FORM_CID_USERNAMES, '0[cid]');
		$ele['cid']->setDescription(_MN_TWEETBOMB_FORM_DESC_CID_USERNAMES);
		$ele['catid'] = new XoopsFormSelectCategories(_MN_TWEETBOMB_FORM_CATID_USERNAMES, '0[catid]');
		$ele['catid']->setDescription(_MN_TWEETBOMB_FORM_DESC_CATID_USERNAMES);
		$ele['twitter_username'] = new XoopsFormText(_MN_TWEETBOMB_FORM_USERNAME_USERNAMES, '0[twitter_username]', 30,64);
		$ele['twitter_username']->setDescription(_MN_TWEETBOMB_FORM_DESC_USERNAME_USERNAMES);
		
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('twitter_username');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_scheduler_get_form($object) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('campaign', 'twitterbomb');
			$object = $handler->create(); 
		}

		if ($object->isNew())
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_ISNEW_SCHEDULER, 'campaign', 'index.php', 'post');
		else
			$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_EDIT_SCHEDULER, 'campaign', 'index.php', 'post');

		$id = $object->getVar('cid');
		if (empty($id)) $id = '0';
			
		$ele['op'] = new XoopsFormHidden('op', 'campaign');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		$ele['id'] = new XoopsFormHidden('id', $id);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_SCHEDULER, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'scheduler');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_SCHEDULER);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_SCHEDULER, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_SCHEDULER);
		$ele['mode'] = new XoopsFormSelectMode(_AM_TWEETBOMB_FORM_MODE_SCHEDULER, $id.'[mode]', $object->getVar('mode'));
		$ele['mode']->setDescription(_AM_TWEETBOMB_FORM_DESC_MODE_SCHEDULER);
		$ele['pre'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PRE_SCHEDULER, $id.'[pre]', 15, 35, $object->getVar('pre'));
		$ele['pre']->setDescription(_AM_TWEETBOMB_FORM_DESC_PRE_SCHEDULER);
		$ele['text'] = new XoopsFormText(_AM_TWEETBOMB_FORM_TEXT_SCHEDULER, $id.'[text]', 15, 140, $object->getVar('text'));
		$ele['text']->setDescription(_AM_TWEETBOMB_FORM_DESC_TEXT_SCHEDULER);
		$ele['replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_REPLACE_SCHEDULER, $id.'[replace]', 25, 200, implode('|',$object->getVar('replace')));
		$ele['replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_REPLACE_SCHEDULER);
		$ele['strip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_STRIP_SCHEDULER, $id.'[strip]', 25, 200, implode('|',$object->getVar('strip')));
		$ele['strip']->setDescription(_AM_TWEETBOMB_FORM_DESC_STRIP_SCHEDULER);
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_SCHEDULER, $id.'[search]', 25, 200, implode('|',$object->getVar('search')));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_SCHEDULER);
		$ele['pregmatch'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_SCHEDULER, $id.'[pregmatch]', 25, 500, $object->getVar('pregmatch'));
		$ele['pregmatch']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_SCHEDULER);		
		
		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_SCHEDULER, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_SCHEDULER, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('text', 'mode');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}

	function tweetbomb_scheduler_get_upload_form($handler) {
		
		if (!is_object($handler)) {
			$handler = xoops_getmodulehandler('scheduler', 'twitterbomb');
		}
		
		$object = $handler->create();

		$sform = new XoopsThemeForm(_AM_TWEETBOMB_FORM_IMPORT_SCHEDULE, 'schedule', 'index.php', 'post');
		$sform->setExtra( "enctype='multipart/form-data'" ) ;
		$id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'scheduler');
		$ele['fct'] = new XoopsFormHidden('fct', 'importfile');
		$ele['id'] = new XoopsFormHidden('id', 0);
		$ele['cid'] = new XoopsFormSelectCampaigns(_AM_TWEETBOMB_FORM_CID_SCHEDULER, $id.'[cid]', $object->getVar('cid'), 1, false, false, 'scheduler');
		$ele['cid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CID_SCHEDULER);
		$ele['catid'] = new XoopsFormSelectCategories(_AM_TWEETBOMB_FORM_CATID_SCHEDULER, $id.'[catid]', $object->getVar('catid'));
		$ele['catid']->setDescription(_AM_TWEETBOMB_FORM_DESC_CATID_SCHEDULER);
		$ele['mode'] = new XoopsFormSelectMode(_AM_TWEETBOMB_FORM_MODE_SCHEDULER, $id.'[mode]', $object->getVar('mode'));
		$ele['mode']->setDescription(_AM_TWEETBOMB_FORM_DESC_MODE_SCHEDULER);
		$ele['pre'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PRE_SCHEDULER, $id.'[pre]', 15, 35, $object->getVar('pre'));
		$ele['pre']->setDescription(_AM_TWEETBOMB_FORM_DESC_PRE_SCHEDULER);
		$ele['replace'] = new XoopsFormText(_AM_TWEETBOMB_FORM_REPLACE_SCHEDULER, $id.'[replace]', 25, 200, implode('|',$object->getVar('replace')));
		$ele['replace']->setDescription(_AM_TWEETBOMB_FORM_DESC_REPLACE_SCHEDULER);
		$ele['strip'] = new XoopsFormText(_AM_TWEETBOMB_FORM_STRIP_SCHEDULER, $id.'[strip]', 25, 200, implode('|',$object->getVar('strip')));
		$ele['strip']->setDescription(_AM_TWEETBOMB_FORM_DESC_STRIP_SCHEDULER);
		$ele['search'] = new XoopsFormText(_AM_TWEETBOMB_FORM_SEARCH_SCHEDULER, $id.'[search]', 25, 200, implode('|',$object->getVar('search')));
		$ele['search']->setDescription(_AM_TWEETBOMB_FORM_DESC_SEARCH_SCHEDULER);
		$ele['pregmatch'] = new XoopsFormText(_AM_TWEETBOMB_FORM_PREGMATCH_SCHEDULER, $id.'[pregmatch]', 25, 500, $object->getVar('pregmatch'));
		$ele['pregmatch']->setDescription(_AM_TWEETBOMB_FORM_DESC_PREGMATCH_SCHEDULER);		
		$ele['file'] = new XoopsFormFile(_AM_TWEETBOMB_FORM_FILE_SCHEDULER, $id.'[file]', 1024*1024*10);
		$ele['file']->setDescription(_AM_TWEETBOMB_FORM_DESC_FILE_SCHEDULER);

		if ($object->getVar('uid')>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($object->getVar('uid'));
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$object->getVar('uid').'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UID_SCHEDULER, _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_CREATED_SCHEDULER, date(_DATESTRING, $object->getVar('created')));
		}
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(_AM_TWEETBOMB_FORM_UPDATED_SCHEDULER, date(_DATESTRING, $object->getVar('updated')));
		}			
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('file', 'mode');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
				
		return $sform->render();
		
	}
	
?>
