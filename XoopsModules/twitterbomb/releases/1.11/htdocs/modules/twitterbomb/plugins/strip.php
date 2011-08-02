<?php
	function StripInsertHook($object) {
		if (is_object($object))
			return $object->getVar('sid');
		elseif(is_numeric($object))
			return $object;
	}
	
	function StripGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$object->vars['text']['value'] = str_replace($object->getVar('strip'), '', $object->getVar('text'));
				return $object;
				break;	
		}
	}
