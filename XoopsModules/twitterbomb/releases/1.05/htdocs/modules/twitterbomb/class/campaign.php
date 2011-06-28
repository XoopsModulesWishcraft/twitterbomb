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
class TwitterbombCampaign extends XoopsObject
{

    function TwitterbombCampaign($fid = null)
    {
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);    
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('start', XOBJ_DTYPE_INT, null, false);
		$this->initVar('end', XOBJ_DTYPE_INT, null, false);
		$this->initVar('timed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
	}

	function getForm() {
		return tweetbomb_campaign_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['cid'].']', $this->getVar('cid'));
		$ele['catid'] = new XoopsFormSelectCategories('', $ret['catid'].'[catid]', $this->getVar('catid'));
		$ele['name'] = new XoopsFormText('', $ret['cid'].'[name]', 26,64, $this->getVar('name'));
		$ele['description'] = new XoopsFormTextArea('', $ret['cid'].'[catid]', 26, 4, $this->getVar('description'));
		$ele['start'] = new XoopsFormTextDateSelect('', $ret['cid'].'[start]', 15, $this->getVar('start'));
		$ele['end'] = new XoopsFormTextDateSelect('', $ret['cid'].'[end]', 15, $this->getVar('end'));
		$ele['timed'] = new XoopsFormRadioYN('', $ret['cid'].'[timed]', $this->getVar('timed'));
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
		if ($ret['updated']>0) {
			$ele['updated'] = new XoopsFormLabel('', date(_DATESTRING, $ret['updated']));
		} else {
			$ele['updated'] = new XoopsFormLabel('', '');
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
class TwitterbombCampaignHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_campaign", 'TwitterbombCampaign', "cid", "name");
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
}
?>