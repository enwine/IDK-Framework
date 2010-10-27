<?php

/* Code documented at its GitHub Wiki, read more at www.github.com/enwine/IDK-Framework/ */

class IDKFactory {
	
	private function __construct() {}
	private function __destruct() {}
	
	public static function getInstance($class_name) {
		if( class_exists($class_name) ) {
			return new $class_name;
		} else {
			trigger_error('<b>'.$class_name.'</b> is not a declared class name', E_USER_ERROR);
		}
	}

}