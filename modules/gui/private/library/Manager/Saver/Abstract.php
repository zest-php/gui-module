<?php

/**
 * @category Gui
 * @package Gui_Manager
 * @subpackage Saver
 */
abstract class Gui_Manager_Saver_Abstract{
	
	/**
	 * @param string $owner
	 * @param string $key
	 * @param mixed $data
	 * @return Gui_Manager_Saver_Abstract
	 */
	abstract public function save($owner, $key, $data);
	
	/**
	 * @param string $owner
	 * @param string $key
	 * @return mixed
	 */
	abstract public function load($owner, $key);
	
}