<?php

/**
 * @category Gui
 * @package Gui_Widget
 */
class Gui_Widget_Tabs extends Gui_Widget implements IteratorAggregate{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'ajaxOptions', 'cache', 'collapsible', 'cookie', 'deselectable', 'disabled', 'event', 'fx', 'idPrefix', 'panelTemplate',
		'selected', 'spinner', 'tabTemplate'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'add', 'create', 'disable', 'enable', 'load', 'remove', 'select', 'show'
	);
	
	/**
	 * @var array
	 */
	protected $_tabs = array();
	
	/**
	 * @param Gui_Widget_Tabs_Tab|array|string $tab
	 * @param array $options
	 * @return Gui_Widget_Tabs
	 */
	public function addTab($tab = null, array $options = array()){
		if(!$tab instanceof Gui_Widget_Tabs_Tab){
			if(is_null($tab)){
				$tab = array();
			}
			if(is_array($tab)){
				$tab = new Gui_Widget_Tabs_Tab($tab);
			}
			else if(is_string($tab)){
				$tab = $this->_manager->get($tab);
			}
			if(!$tab instanceof Gui_Widget_Tabs_Tab){
				throw new Zest_Exception('L\'onglet doit être une instance de Gui_Widget_Tabs_Tab.');
			}
		}
		$tab->setOptions($options);
		$this->_tabs[] = $tab;
		return $this;
	}
	
	/**
	 * @param array $tabs
	 * @return Gui_Widget_Accordion
	 */
	public function addTabs($tabs){
		foreach($tabs as $tab => $options){
			if(is_numeric($tab)){
				$this->addTab($options);
			}
			else{
				$this->addTab($tab, $options);
			}
		}
		return $this;
	}
	
	/**
	 * @param array $tabs
	 * @return Gui_Widget_Accordion
	 */
	public function setTabs($tabs){
		$this->_tabs = array();
		$this->addTabs($tabs);
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getTabs(){
		return $this->_tabs;
	}
	
	/**
	 * @return ArrayIterator
	 */
	public function getIterator(){
		return new ArrayIterator($this->getTabs());
	}
	
}