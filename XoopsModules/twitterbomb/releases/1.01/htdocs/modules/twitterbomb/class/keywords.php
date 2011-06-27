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
class TwitterbombKeywords extends XoopsObject
{

    function TwitterbombKeywords($fid = null)
    {
        $this->initVar('kid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);         
        $this->initVar('base', XOBJ_DTYPE_ENUM, null, false, false, false, array('for','when','clause','then','over','under','their','there'));
		$this->initVar('keyword', XOBJ_DTYPE_TXTBOX, null, true, 35);    
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
   	}

	function getForm() {
		return tweetbomb_keywords_get_form($this);
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormHidden('id['.$ret['kid'].']', $this->getVar('kid'));
		$ele['cid'] = new XoopsFormSelectCampaigns('', $ret['kid'].'[cid]', $this->getVar('cid'));
		$ele['catid'] = new XoopsFormSelectCategories('', $ret['kid'].'[catid]', $this->getVar('catid'));
		$ele['base'] = new XoopsFormSelectBase('', $ret['kid'].'[base]', $this->getVar('base'), 1, false, false);
		$ele['keyword'] = new XoopsFormText('', $ret['kid'].'[keyword]', 26, 35, $this->getVar('keyword'));
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
	
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugin/'.$this->getVar('base').'.php'));
		
		switch ($this->getVar('base')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':				
				$func = ucfirst($this->getVar('base')).'SaveHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('kid');
	}
	
	function runGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugin/'.$this->getVar('base').'.php'));
		
		switch ($this->getVar('base')) {
			case 'for':
			case 'when';
			case 'clause':
			case 'then':
			case 'over':				
			case 'under':
			case 'their':
			case 'there':				
				$func = ucfirst($this->getVar('base')).'GetHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('kid');
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
class TwitterbombKeywordsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "twitterbomb_keywords", 'TwitterbombKeywords', "kid", "keyword");
    }
	
    function insert($obj, $force=true) {
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	$run_plugin = false;
    	if ($obj->vars['base']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
     	
    	if ($run_plugin == true) {
    		$id = parent::insert($obj, $force);
    		$obj = parent::get($id);
    		if (is_object($obj)) {
	    		$ret = $obj->runInsertPlugin();
	    		return ($ret!=0)?$ret:$id;
    		} else {
    			return $id;
    		}
    	} else {
    		return parent::insert($obj, $force);
    	}
    }
}
?>