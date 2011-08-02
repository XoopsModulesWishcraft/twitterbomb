<?php
	function PregmatchInsertHook($object) {
		if (is_object($object))
			return $object->getVar('sid');
		elseif(is_numeric($object))
			return $object;
	}
	
	function PregmatchGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$object->vars['text']['value'] = preg_replace($object->getVar('pregmatch'), implode(' ', $object->getVar('replace')), $object->getVar('text'));
				return $object;
				break;	
		}
	}