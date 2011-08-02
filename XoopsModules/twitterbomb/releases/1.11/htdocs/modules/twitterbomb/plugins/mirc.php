<?php

	function MircInsertHook($object) {
		return $object->getVar('sid');
	}
	
	function MircGetHook($object, $for_tweet=false) {
		switch ($for_tweet)
		{
			case false;
				return $object;
				break;
			case true;
				$text = $object->getVar('text');
				$nickstart = strpos($text, '&lt;', 0);
				$convostart = strpos($text, '&gt;', $nickstart+1);
				if ($convostart!=0&&$nickstart!=0) {
					$nick = trim(substr($text, $nickstart+4, $convostart-$nickstart-4));
					return '#'.str_replace(array('@', '%', '+'), '', $nick).' '.trim(substr($text, $convostart+4, strlen($text)-$convostart-4));
				} else {
					$nickstart = strpos($text, '*', 0);
					$convostart = strpos($text, ' ', $nickstart+3);
					$nick = trim(substr($text, $nickstart+1, $convostart-$nickstart));
					$cut = strpos($text, ')', $convostart);
					if ($cut!=0)
						return '#'.str_replace(array('@', '%', '+'), '', $nick).' '.trim(substr($text, $cut+1, strlen($text)-$cut));
					else 
						return '#'.str_replace(array('@', '%', '+'), '', $nick).' '.trim(substr($text, $convostart+1, strlen($text)-$convostart));
				}
				break;	
		}
	}
	
?>