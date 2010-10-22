<?php
class IDKDatabase {
	/* IDKDatabase — Super-easy MySQL DB interface for PHP
	 * Sigleton pattern applied.
	 */
	
	private static $instance = null;
	private static $db_link = null;
	private static $initialized = false;
	
	private function __construct() {}
	
	public function __destruct() {
		if( self::$initialized === true ) {
			mysql_close(self::$db_link);
		}
		self::$instance = null;
		self::$db_link = null;
		self::$initialized = false;
	}
	
	public function __clone() {
		trigger_error('Clone is not allowed for IDKDatabase.', E_USER_ERROR);
	}
	
	
	/* STATIC METHODS*/
	
	public static function getInstance() {
		if( self::$instance === null ) {
			self::$instance = new IDKDatabase();
		}
		return self::$instance;
	}
	
	public static function initWithValues($IDKDatabase_HOST, $IDKDatabase_USER, $IDKDatabase_PASSWORD, $IDKDatabase_DBNAME) {
	/* @name initWithValues
	 * @brief Establishes the database links or overrides the previous db link from a given values.
	 * @input $IDKDatabase_HOST, $IDKDatabase_USER, $IDKDatabase_PASSWORD, $IDKDatabase_DBNAME
	 * @use IDKDatabase::initWithValues($IDKDatabase_HOST, $IDKDatabase_USER, $IDKDatabase_PASSWORD, $IDKDatabase_DBNAME);
	 * @returns bool TRUE if the link have been established, FALSE otherwise.
	 */
		if( self::$initialized === true ) {
			trigger_error('IDKDatabase connection have previously started, so you are overriding your database link which can cause unexpected results.', E_USER_NOTICE);
			mysql_close(self::$db_link);
		}
		self::$initialized = false;
		self::$db_link = mysql_connect($IDKDatabase_HOST, $IDKDatabase_USER, $IDKDatabase_PASSWORD, true);
		if( self::$db_link === false ) {
			return false;
		}
		$db_selection = mysql_select_db($IDKDatabase_DBNAME, self::$db_link);
		if( $db_selection === false ) {
			return false;
		}
		self::$initialized = true;
		return true;
	}
	
	public static function initWithConstants() {
	/* @name initWithConstants
	 * @brief Establishes the database links or overrides the previous db link from a given constants.
	 ! Requires IDKDatabase_HOST, IDKDatabase_USER, IDKDatabase_PASSWORD and IDKDatabase_DBNAME to be defined before calling.
	 * @use IDKDatabase::initWithConstants(); 
	 * @returns bool TRUE if the link have been established, FALSE otherwise.
	 */
		return self::initWithValues(IDKDatabase_HOST, IDKDatabase_USER, IDKDatabase_PASSWORD, IDKDatabase_DBNAME);
	}
	
	
	/* PUBLIC METHODS */
	
	public function query($query) {
		return $this->raw_query($query);
	}
	
	public function fetch_assoc($query) {
		return $this->fetch_array($query, MYSQL_ASSOC);
	}
	
	public function fetch_row($query) {
		return $this->fetch_array($query, MYSQL_NUM);
	}
	
	
	/* PRIVATE METHODS */
	
	private function check() {
		if( self::$db_link === null ) {
			trigger_error('DB link not established. Establish it before querying.', E_USER_ERROR)
		}
	}
	
	private function raw_query($query) {
		$this->check();
		return mysql_query($query, self::$db_link);
	}
	
	private function fetch_array($query, $result_type) {
		$array = array( 'data'=>array(), 'rows'=>0);
		$result = $this->raw_query($query);
		while($data = mysql_fetch_array($result, $result_type)) {
			foreach($data as $k=>$v) {
				$array['data'][$array['rows']] = array();
				$array['data'][$array['rows']][$k] = $v; 
			}
			$array['rows']++;
		}
		mysql_free_result($result);
		return $array;
	}	
	  
}