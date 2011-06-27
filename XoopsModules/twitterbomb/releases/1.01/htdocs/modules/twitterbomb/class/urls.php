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
class TwitterbombUrls extends XoopsObject
{

    function TwitterbombUrls($fid = null)
    {
        $this->initVar('urlid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('surl', XOBJ_DTYPE_TXTBOX, null, true, 255);    
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);    
		$this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);		
	}

	function getForm() {
		return tweetbomb_urls_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['urlid'].']', $this->getVar('urlid'));
		$ele['cid'] = new XoopsFormSelectCampaigns('', $ret['urlid'].'[cid]', $this->getVar('cid'));
		$ele['catid'] = new XoopsFormSelectCategories('', $ret['urlid'].'[catid]', $this->getVar('catid'));
		$ele['surl'] = new XoopsFormText('', $ret['urlid'].'[surl]', 45,255, $this->getVar('surl'));
		$ele['name'] = new XoopsFormText('', $ret['urlid'].'[name]', 26,64, $this->getVar('name'));
		$ele['description'] = new XoopsFormTextArea('', $ret['urlid'].'[catid]', 26, 4, $this->getVar('description'));
		
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
class TwitterbombUrlsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_urls", 'TwitterbombUrls', "urlid", "surl");
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