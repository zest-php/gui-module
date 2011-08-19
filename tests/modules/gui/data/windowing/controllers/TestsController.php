<?php

class Windowing_TestsController extends Gui_Controller_Action{
	
	/**
	 * @return void
	 */
	public function testClickAction(){
		Zest_Controller_Front::getInstance()->getResponse()->setBody('ok', 'testClickAction');
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
}