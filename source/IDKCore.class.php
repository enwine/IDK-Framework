<?php

/* Code documented at its GitHub Wiki, read more at www.github.com/enwine/IDK-Framework/ */

abstract class IDKCore {

// -- PROPERTIES -- //	

	private $IDKvar_properties = array();

	final protected function getProperty($prop_name) {
		if( array_key_exists($prop_name, $this->IDKvar_properties) ) {
			return $this->IDKvar_properties[$prop_name]['data'];
		} else {
			trigger_error('Unable to get property: <b>$'.$arg[$i].'</b> value\'s in '.__CLASS__, E_USER_ERROR);
		}
	}

	final protected function setProperty($prop_name, $prop_value=null) {
		if( array_key_exists($prop_name, $this->IDKvar_properties) ) {
				$this->IDKvar_properties[$prop_name]['data'] = $prop_value;
				return $this;
		} else {
			trigger_error('Unable to set a new value to property: <b>$'.$func.'</b> in '.__CLASS__, E_USER_ERROR);
		}
	}

	final private function __call($func, $arg) {
	//$this->addProperties($prop1, $prop2, ...);
		if( $func === 'addProperties' ) {
			$i = 1;
			while( isset($arg[$i]) ) {
				$this->IDKvar_properties[$arg[$i]] = array('data'=>null, 'get'=>false, 'set'=>false);
				switch( $arg[0] ) {
				case 'get':
					$this->IDKvar_properties[$arg[$i]]['get'] = true;
					break;
				case 'set':
					$this->IDKvar_properties[$arg[$i]]['set'] = true;
					break;
				case 'both':
					$this->IDKvar_properties[$arg[$i]]['set'] = true;
					$this->IDKvar_properties[$arg[$i]]['get'] = true;
					break;
				default:
					//Nothig to do;
				}
				$i++;
			}
			return $this;
		}
	//$this->removeProperties($prop1, $prop2, ...);
		if( $func === 'removeProperties' ) {
			$i = 1;
			while( isset($arg[$i]) ) {
				if( array_key_exists($arg[$i], $this->IDKvar_properties) ) {
					switch( $arg[0] ) {
					case 'get':
						$this->IDKvar_properties[$arg[$i]]['get'] = false;
						break;
					case 'set':
						$this->IDKvar_properties[$arg[$i]]['set'] = false;
						break;
					case 'both':
						$this->IDKvar_properties[$arg[$i]]['set'] = false;
						$this->IDKvar_properties[$arg[$i]]['get'] = false;
						break;
					case 'delete':
						unset($this->IDKvar_properties[$arg[$i]]);
						break;
					default:
						//Nothig to do;
					}
				} else {
					trigger_error('Unable to remove a property: <b>$'.$arg[$i].'</b> in '.__CLASS__, E_USER_ERROR);
				}
				$i++;
			}
			return $this;
		}
	// Getters & setters
		if( array_key_exists($func, $this->IDKvar_properties) ) {
			if( isset($arg[0]) && $this->IDKvar_properties[$func]['set'] === true ) {
				$this->IDKvar_properties[$func]['data'] = $arg[0];
				return $this;
			} elseif( $this->IDKvar_properties[$func]['get'] === true ) {
				return $this->IDKvar_properties[$func]['data'];
			} else {
				trigger_error('Property <b>$'.$func.'</b> is not accesible at this time in '.__CLASS__, E_USER_ERROR);
			}
		} else {
			trigger_error('Unable to call method <b>$'.$func.'</b> in '.__CLASS__, E_USER_ERROR);
		}
	}

	private function __set($var_name, $var_value) {
		trigger_error('Unable to access to var: <b>$'.$var_name.'</b> in '.__CLASS__, E_USER_ERROR);
	}
	private function __get($var_name) {
		trigger_error('Unable to access to var: <b>$'.$var_name.'</b> in '.__CLASS__, E_USER_ERROR);
	}

}