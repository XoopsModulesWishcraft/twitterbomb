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
class TwitterbombCategory extends XoopsObject
{

    function TwitterbombCategory($fid = null)
    {
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('pcatdid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 128);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		    
	}

	function getForm() {
		return tweetbomb_category_get_form($this);
	}

	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['catid'].']', $this->getVar('catid'));
		$ele['pcatdid'] = new XoopsFormSelectCategories('', $ret['catid'].'[pcatdid]', $this->getVar('pcatdid'));
		$ele['name'] = new XoopsFormText('', $ret['catid'].'[name]', 26,64, $this->getVar('name'));
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
class TwitterbombCategoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_category", 'TwitterbombCategory', "catid", "name");
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
    
    function renderSmarty($catid) {
    	if ($catid>0)
    		$criteria = new CriteriaCompo('pcatdid', $catid);
    	else { 
    		$criteria = new CriteriaCompo('pcatdid', '0');
    	}
    	$objs = parent::getObjects($criteria, true);
    	$ret = array();
    	$id = array();
    	foreach($objs as $catid => $category) {
    		if (!in_array($catid, $id)) {
	    		$id[] = $catid;
	    		$ret[$catid]['catid'] = $catid;
	    		$ret[$catid]['name'] = $category->getVar('name');	
	    		$ret[$catid]['subitems'] = parent::getCount(new Criteria('pcatdid', $catid));
	    		if ($ret[$catid]['subitems']>0) {
	    			foreach(parent::getObjects(new Criteria('pcatdid', $catid), true) as $scatid => $scategory) {
	    				if (!in_array($scatid, $id)) {
	    					$id[] = $scatid;
		    				$ret[$catid]['subcategories'][$scatid]['catid'] = $scatid;
		    				$ret[$catid]['subcategories'][$scatid]['name'] = $scategory->getVar('name');
	    				}
	    			}
	    		}
    		}
    	}
    	return $ret;
    }
}
?>