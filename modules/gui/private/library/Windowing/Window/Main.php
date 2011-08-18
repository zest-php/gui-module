<?php

/**
 * @category Gui
 * @package Gui_Window
 * @subpackage Window
 */
class Gui_Windowing_Window_Main extends Gui_Windowing_Window{
	
	/**
	 * @var string
	 */
	protected $_id = 'gui-windowing-window-main';
	
	/**
	 * @return Gui_Object|Gui_Windowing_Window_Main_Icons
	 */
	public function getContentObject(){
		if(is_null($this->_contentObject)){
			$this->setContentObject('Gui_Windowing_Window_Main_Icons');
		}
		return parent::getContentObject();
	}
	
	/**
	 * @return void
	 */
	public function preRender(){
		$this->getView()->head()->css($this->_manager->getConfigUrl('url.gui.css', 'windowing/window/main.css'));
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$render = parent::render($view);
		
		// suppression du javascript inline hérité de Gui_Widget_Dialog
		$headScript = (array) $this->getView()->headScript()->getIterator();
		foreach($headScript as $offset => $script){
			if(!empty($script->source) && is_int(strpos($script->source, '.dialog('))){
				$this->getView()->headScript()->offsetUnset($offset);
			}
		}
		
		return $render;
	}
	
}