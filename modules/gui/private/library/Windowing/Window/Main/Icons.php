<?php

/**
 * @category Gui
 * @package Gui_Window
 * @subpackage Window
 */
class Gui_Windowing_Window_Main_Icons extends Gui_Object_Icons{
	
	/**
	 * @return void
	 */
	public function init(){
		$controller = Zest_Controller_Front::getInstance();
		$modules = array_keys($controller->getControllerDirectory());
		foreach($modules as $module){
			$file = $this->_manager->getViewGuiDir($module).'/Main.php';
			if(file_exists($file)){
				require_once $file;
				$class = ucfirst($module).'_View_Gui_Main';
				if(!class_exists($class)){
					throw new Zest_Exception(sprintf('La classe "%s" n\'existe pas.', $class));
				}
				$icons = new $class();
				$items = $icons->getItems();
				foreach($items as $item){
					$item->setId($module.'-'.$item->getId());
				}
				$this->addItems($items);
			}
		}
		$this->sortByLabel();
	}
	
	/**
	 * @param string|integer $id
	 * @return Gui_Windowing_Window_Main_Icons
	 */
	public function click($id){
		if(!is_int(strpos($id, '-'))){
			throw new Zest_Exception(sprintf('"%s" ne correspond pas à un identifiant valide', $id));
		}
		list($module, $id) = explode('-', $id, 2);
		
		$file = $this->_manager->getViewGuiDir($module).'/Main.php';
		if(file_exists($file)){
			$class = ucfirst($module).'_View_Gui_Main';
			if(!class_exists($class)){
				throw new Zest_Exception(sprintf('La classe "%s" n\'existe pas.', $class));
			}
			$icons = new $class();
			$icons->click($id);
		}
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getViewScript(){
		if(is_null($this->_viewScript)){
			if(parent::getViewScript() == 'gui/windowing/window/main/icons.phtml'){
				$this->setViewScript('gui/object/icons.phtml');
			}
		}
		return parent::getViewScript();
	}
	
}