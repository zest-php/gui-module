<?php

class Gui_Bootstrap extends Zest_Application_Module_Bootstrap{
	
	/**
	 * @return void
	 */
	protected function _initFrameworkVersion(){
		$this->requireAtLeastFramework('1.1.5');
	}
	
}