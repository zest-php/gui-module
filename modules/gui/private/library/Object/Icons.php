<?php

/**
 * @category Gui
 * @package Gui_Object
 */
class Gui_Object_Icons extends Gui_Object_Items implements IteratorAggregate{
	
	/**
	 * @var string
	 */
	protected $_itemClassName = 'Gui_Object_Icons_Icon';
	
	/**
	 * @var array
	 */
	protected $_xhrMethods = array('click');
	
	/**
	 * @param string|integer $id
	 * @return Gui_Object_Icons
	 */
	public function click($id){
		if($icon = $this->getItem($id)){
			$url = $icon->getUrl();
			if(is_null($url)){
				throw new Zest_Exception(sprintf('Impossible d\'exécuter l\'url de l\'icône "%s".', $id));
			}
			list($action, $controller, $module) = $url;
			$this->getView()->action($action, $controller, $module);
		}
		return $this;
	}
	
	/**
	 * @param Zend_View_Interface $view
	 * @return string
	 */
	public function render(Zend_View_Interface $view = null){
		$render = parent::render($view);
		
		$this->getView()->jquery()->ui('ui.button');
		$this->getView()->head()
			->css($this->_manager->getConfigUrl('url.gui.css', 'object/icons.css'))
			->jsInline(
				'$(function(){'.
				'$("#'.$this->getId().'").children().button();'.
				'});'
			);
		
		return $render;
	}
	
}