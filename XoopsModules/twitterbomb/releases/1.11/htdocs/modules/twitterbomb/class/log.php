<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room TwitterBomb Log
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class TwitterBombLog extends XoopsObject
{

    function TwitterBombLog($id = null)
    {
        $this->initVar('lid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('provider', XOBJ_DTYPE_ENUM, 'bomb', false, false, false, array('bomb', 'sceduler'));
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('alias', XOBJ_DTYPE_TXTBOX, false, false, 64);
		$this->initVar('tweet', XOBJ_DTYPE_TXTBOX, false, false, 140);
		$this->initVar('url', XOBJ_DTYPE_TXTBOX, false, false, 500);
		$this->initVar('date', XOBJ_DTYPE_INT, null, false);
    }

    function toArray() {
    	$ret = parent::toArray();
    	$ret['date_datetime'] = date(_DATESTRING, $this->getVar('date'));
    	$ret['provider'] = ucfirst($this->getVar('provider'));
    	foreach($ret as $key => $value)
    		$ret[str_replace('-', '_', $key)] = $value;
    	return $ret;
    }
    
    function runPrePlugin($default = true) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('provider').'.php'));
		
		switch ($this->getVar('provider')) {
			case 'bomb':
			case 'scheduler':
				$func = ucfirst($this->getVar('action')).'PreHook';
				break;
			default:
				return $default;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($default, $this);
		}
		return $default;
	}
    
	function runPostPlugin($lid) {
		
		include_once($GLOBALS['xoops']->path('/modules/twitterbomb/plugins/'.$this->getVar('provider').'.php'));
		
		switch ($this->getVar('provider')) {
			case 'bomb':
			case 'scheduler':
				$func = ucfirst($this->getVar('action')).'PostHook';
				break;
			default:
				return $lid;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this, $lid);
		}
		return $lid;
	}
}


/**
* XOOPS TwitterBomb Log handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class TwitterBombLogHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'twitterbomb_log', 'TwitterBombLog', "lid", "tweet");
    }
	
    private function getAlias($object) {
    	$tweet = $object->getVar('tweet');
    	foreach(explode(' ', $tweet) as $node) {
    		if (in_array(substr($node, 0, 1), array('@','#'))) {
    			return $node;
    		}
    	}
    	
    }
    
    function insert($object, $force = true) {
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('twitterbomb');
		$xoConfig = $config_handler->getConfigList($xoModule->getVar('mid'));
		
		$criteria = new Criteria('`date`', time()-$xoConfig['logdrops'], '<=');
		$this->deleteAll($criteria, true);
		
    	if ($object->isNew()) {
    		$object->setVar('date', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    		else 
    			$object->setVar('uid', 0);
    	}
    	
    	$object->setVar('alias', $this->getAlias($object));
    	
		$run_plugin_action=false;
    	if ($obj->vars['provider']['changed']==true) {	
			$run_plugin_action=true;
		}
    	if ($run_plugin_action){
    		if ($object->runPrePlugin($xoConfig['save_'.$object->getVar('provider')])==true)
    			$lid = parent::insert($object, $force);
    		else 
    			return false;
    	} else 	
    		$lid = parent::insert($object, $force);		
    	if ($run_plugin_action)
    		return $object->runPostPlugin($lid);
    	else 	
    		return $lid;
    }
}

?>