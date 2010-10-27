<?php

/* Code documented at its GitHub Wiki, read more at www.github.com/enwine/IDK-Framework/ */

class IDKLog {
	
	private static $IDKvar_log = array();
	private static $IDKvar_dump = false;
	
	private function __construct() {}
	public function __destruct() {}
	
	public static function log($string, $print=false, $time=true) {
		if( $time === true ) {
			$string = '@'.date('m/d/Y H:i:s', time()).' :: '.$string;
		}
		self::$IDKvar_log[] = $string;
		if( $print === true ) {
			echo '<br />'.$string.'<br />';
		}
	}
	
	public static function printLog() {
		foreach( self::$IDKvar_log as $v ) {
			echo '<br />'.$v;
		}
	}
	
}

/* Short form 
 ! NOTICE that as it is intended for fast printing, in this case the default $print value is TRUE, and not FALSE.
 *
 ! By the way, notice that this code should be placed in a function repository, not in this file, in a future revision.
 */

function IDKLog($string, $print=true, $time=true) {
	IDKLog::log( $string, $print, $time);
}
