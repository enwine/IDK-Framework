<?php
class IDKDatabase {
	/* IDKDatabase — Super-easy MySQL DB interface for PHP
	 * Sigleton pattern applied.
	 */
	
	private static $instance = null;
	private static $db_link = null;
	private static $initialized = false;
	private function __construct() {}
	
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
	
	public function __clone() {
		trigger_error('Clone is not allowed for IDKDatabase.', E_USER_ERROR);
	}
	
	/* Methods to use
	 * This Class aims to make your DB interface as safe as possible, and for
	 * this reason method naming have been specially divided in two:
	 * STANDARD functions: All the methods that you should be using.
	 * DANGEROUS functions: Starting by an underscore, you'll check their
	 * source code before using them, as the function will never check your
	 * input.
	 ! DANGEROUS and PRIVATE methods may be undocumented.
	 */
	public function _query($query) {
		trigger_error('Using methods starting with an underscore (DANGEROUS methods) is discouraged.', E_USER_NOTICE);
		return $this->raw_query($query);
	}
	
	// —— UNDER DEV ——
	public function select(array $fields, array $tables, array $conditions = null) {
	/* @name select
	 * @brief Preapares a SELECT query string that would be executed when on the next data fetch.
	 * @input array $fields, array $tables[, array $conditions = null]
	 * @use $instance->select(array('field1', 'field2', ...), array('table1', 'table2', ...), array('field1=SomeValue', 'field2 NOT LIKE PartialValue%', ...)); 
	 * @returns bool TRUE if the link have been established, FALSE otherwise.
	 */
	}
	// —— UNDER DEV ——
	
	/* Private methods
	 * DO NOT PUT YOUR FINGERS IN HERE!! — Joke ;-)
	 */
	private function check() {
		if( self::$db_link === null ) {
			trigger_error('DB link not established. Establish it before querying.', E_USER_ERROR)
		}
	}
	private function raw_query($query) {
		$this->check();
		return mysql_query($query, self::$db_link);
	}
	  
}