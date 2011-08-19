<?php

class Windowing_View_Gui_Main extends Gui_Object_Icons{
	
	/**
	 * @return void
	 */
	public function init(){
		$this->addItem(array(
			'id' => 1,
			'image' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
			'label' => 'Google',
			'url' => array(
				'action' => 'test-click',
				'controller' => 'tests',
				'module' => 'windowing'
			)
		));
		$this->addItem(array(
			'id' => 2,
			'image' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
			'label' => 'Google'
		));
	}
	
}