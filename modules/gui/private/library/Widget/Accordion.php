<?php

/**
 * @category Gui
 * @package Gui_Widget
 */
class Gui_Widget_Accordion extends Gui_Widget implements IteratorAggregate{
	
	/**
	 * @var array
	 */
	protected $_availableWidgetOptions = array(
		'active', 'animated', 'autoHeight', 'clearStyle', 'collapsible', 'disabled', 'event', 'fillSpace', 'header', 'icons',
		'navigation', 'navigationFilter'
	);
	
	/**
	 * @var array
	 */
	protected $_availableWidgetEvents = array(
		'change', 'changestart', 'create'
	);
	
	/**
	 * @var array
	 */
	protected $_sections = array();
	
	/**
	 * @param Gui_Widget_Accordion_Section|array $section
	 * @param array $options
	 * @return Gui_Widget_Accordion_Section
	 */
	public function addSection($section = null, $options = array()){
		if($section instanceof Gui_Widget_Accordion_Section){
			$section = new $section();
		}
		else{
			if(is_null($section)){
				$section = array();
			}
			if(is_array($section)){
				$section = new Gui_Widget_Accordion_Section($section);
			}
			else if(is_string($section)){
				$section = $this->_manager->get($section);
				$section = new $section($options);
			}
			if(!$section instanceof Gui_Widget_Accordion_Section){
				throw new Zest_Exception('La section doit être une instance de Gui_Widget_Accordion_Section.');
			}
		}
		$this->_sections[] = $section;
		return $section;
	}
	
	/**
	 * @return array
	 */
	public function getSections(){
		return $this->_sections;
	}
	
	/**
	 * @return ArrayIterator
	 */
	public function getIterator(){
		return new ArrayIterator($this->getSections());
	}
	
}