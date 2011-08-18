<?php

/**
 * @todo
 * 
 * @category Gui
 * @package Gui_Windowing
 *
 */
class Gui_WindowingController extends Gui_Controller_Action{
	
	/**
	 * @return void
	 */
	public function callAction(){
		$manager = Gui_Manager::getInstance();
		$windowingManager = Gui_Windowing_Manager::getInstance();
		
		$object = $manager->get($this->_getParam('gui_object'));
		$method = $this->_getParam('call');
		if(method_exists($object, 'isXhrMethod') && $object->isXhrMethod($method)){
			$args = (array) $this->_getParam('args');
			call_user_func_array(array($object, $method), $args);
			$manager->getLoader()->saveObject($object);
		}
		
		$this->getResponse()
			->setHeader('Content-Type', 'application/json')
			->setBody($windowingManager->render());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
}