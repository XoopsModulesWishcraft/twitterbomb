<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Spiders
 * @author Simon Roberts (simon@xoops.org)
 * @copyright copyright (c) 2000-2009 XOOPS.org
 * @package kernel
 */
class TwitterbombUsernames extends XoopsObject
{

    function TwitterbombUsernames($fid = null)
    {
        $this->initVar('tid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);        
		$this->initVar('twitter_username', XOBJ_DTYPE_TXTBOX, null, true, 64);   
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('type', XOBJ_DTYPE_ENUM, 'bomb', false, false, false, array('bomb', 'scheduler'));
		$this->initVar('source_nick', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('tweeted', XOBJ_DTYPE_INT, null, false);
	}

	function getForm() {
		return tweetbomb_usernames_get_form($this);
	}

	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['tid'].']', $this->getVar('tid'));
		$ele['cid'] = new XoopsFormSelectCampaigns('', $ret['tid'].'[cid]', $this->getVar('cid'));
		$ele['catid'] = new XoopsFormSelectCategories('', $ret['tid'].'[catid]', $this->getVar('catid'));
		$ele['type'] = new XoopsFormSelectType('', $ret['cid'].'[type]', $this->getVar('type'));
		$ele['twitter_username'] = new XoopsFormText('', $ret['tid'].'[twitter_username]', 45, 64, $this->getVar('twitter_username'));
		$ele['source_nick'] = new XoopsFormText('', $ret['tid'].'[source_nick]', 45, 64, $this->getVar('source_nick'));
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormLabel('', _MI_TWEETBOMB_ANONYMOUS);
		}
		if ($ret['created']>0) {
			$ele['created'] = new XoopsFormLabel('', date(_DATESTRING, $ret['created']));
		} else {
			$ele['created'] = new XoopsFormLabel('', '');
		}
		if ($ret['actioned']>0) {
			$ele['actioned'] = new XoopsFormLabel('', date(_DATESTRING, $ret['actioned']));
		} else {
			$ele['actioned'] = new XoopsFormLabel('', '');
		}
		if ($ret['updated']>0) {
			$ele['updated'] = new XoopsFormLabel('', date(_DATESTRING, $ret['updated']));
		} else {
			$ele['updated'] = new XoopsFormLabel('', '');
		}
		if ($ret['tweeted']>0) {
			$ele['tweeted'] = new XoopsFormLabel('', date(_DATESTRING, $ret['tweeted']));
		} else {
			$ele['tweeted'] = new XoopsFormLabel('', '');
		}
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}
	
}


/**
* XOOPS Spider handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class TwitterbombUsernamesHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_usernames", 'TwitterbombUsernames', "tid", "twitter_username");
    }
	
    function insert($obj, $force=true) {
    	
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	
    	return parent::insert($obj, $force);
    }
    
    function getUser($cid, $catid, $source_nick='') {
    	$criteriaa = new CriteriaCompo(new Criteria('cid', 0), 'OR');
    	$criteriaa->add(new Criteria('catid', 0), 'OR');
    	$criteriab = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriab->add(new Criteria('catid', $catid), 'OR');
    	$criteriac = new CriteriaCompo(new Criteria('cid', $cid), 'AND');
    	$criteriac->add(new Criteria('catid', $catid), 'AND');
    	$criteriad = new CriteriaCompo($criteriaa, 'OR');
    	$criteriad->add($criteriab, 'OR');
    	$criteriad->add($criteriac, 'OR');
    	$criteria = new CriteriaCompo($criteriad, 'OR');
    	if (!empty($source_nick)) {
    		$criteria->add(new Criteria('source_nick', $source_nick, 'LIKE'));
    		$criteria->add(new Criteria('`type`', 'scheduler'));
    	} else {
    		$criteria->add(new Criteria('`type`', 'bomb'));
    	}
    	$criteria->setOrder('DESC');
    	$criteria->setSort('RAND()');
    	$criteria->setLimit(1);
    	$criteria->setStart(0);
    	echo __LINE__.'<br/>';
    	$obj = parent::getObjects($criteria, false);
    	if (is_object($obj[0])) {
    		echo __LINE__.'<br/>';
    		$obj[0]->setVar('tweeted', time());
    		echo __LINE__.'<br/>';
    		parent::insert($obj[0], true);
    		echo __LINE__.'<br/>';
    		return trim($obj[0]->getVar('twitter_username'));
    	}
    	echo __LINE__.'<br/>';
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria($var[0], $var[1]));
    		}
    	}
    	return $criteria;
    }
       
    function getFilterForm($filter, $field, $sort='created') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
}
?>