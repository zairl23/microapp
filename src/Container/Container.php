<?php namespace Neychang\Microapp\Container;

use Pimple\Container as Pimple;

class Container {

	static private $_instance = null; 

	private function __construct() 
	{ 

	} 

	static public function getInstance() 
	{ 
		if(is_null(self::$_instance)) { 
			self::$_instance = new Pimple(); 
		} 

		return self::$_instance; 
	} 

}